<?php

namespace App\Http\Controllers;

use App\Events\OrderUpdatedEvent;
use App\Http\Requests\TinkoffNotificationRequest;
use App\Models\Hall;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use PhpParser\Error;

class TinkoffController extends Controller
{
    const DataType_Image = 'IMAGE';
    const DataType_Payload = 'PAYLOAD';

    public static array $prefixes = [
        'len',
        'spm',
        'pav',
        'nno',
        'vlg',
        'sch',
        'ivo',
        'pzk',
    ];

    private string $url;
    private string $terminal_key;
    private string $password;

    private $dataType;

    private string $notification_url;

    public function __construct($dataType = self::DataType_Image)
    {
        if (\auth()->check()) $this->getTerminalByUser();

        if (app()->environment('production')) {
            $this->url = config('app.tinkoff_prod_url');
        } else {
            $this->url = config('app.tinkoff_test_url');
        }

        $this->notification_url = route('tinkoff.notification');

        $this->dataType = $dataType;
    }

    /**
     * @param Order $order
     * @param string|null $description
     * @return array|false
     */
    public function generateQR(Order $order, string $description = null)
    {
        $payment_id = $this->init($order, $description);
        if (!$payment_id) {
            return false;
        }

        $qr_code = $this->getQR($payment_id);
        if (!$qr_code) {
            return false;
        }

        return [
            'order_id' => $order->id,
            'qr_code' => $qr_code,
        ];
    }

    /**
     * @param int $order_id
     * @param float $amount
     * @param string|null $description
     * @return false|string
     */
    public function init(Order $order, string $description = null)
    {
        $payload = $this->generateToken([
            'TerminalKey' => $this->terminal_key,
            'Amount' => $order->total * 100,
            'OrderId' => $order->id,
            'Description' => $description,
            'NotificationURL' => $this->notification_url,
            'SuccessURL' => config('app.land_url'),
            'FailURL' => config('app.land_url'),
            'Receipt' => [
                'Items' => [
                    [
                        'Name' => 'Сертификат на визит в Бизнес-зал. Заказ №' . $order->id . '.',
                        'Price' => $order->product->price * 100,
                        'Quantity' => $order->quantity,
                        'Amount' => $order->total * 100,
                        'Tax' => 'vat20',
                    ]
                ],
                'Email' => $order->email,
                'Taxation' => 'osn',
            ],
        ]);

        $response = \Http::post($this->url . '/v2/Init', $payload);

        if (!$response->successful()) return false;

        $response = json_decode($response->body());

        if ($response->Success and $response->Status === 'NEW') {
            return $response->PaymentId;
        }

        \Log::error('Payment Init failed. Payload: ' . json_encode($payload, JSON_UNESCAPED_UNICODE) . '. Response: ' . json_encode($response, JSON_UNESCAPED_UNICODE));

        return false;
    }

    public function getQR(string $payment_id)
    {
        $payload = $this->generateToken([
            'TerminalKey' => $this->terminal_key,
            'PaymentId' => $payment_id,
            'DataType' => $this->dataType,
        ]);

        $response = \Http::post($this->url . '/v2/GetQr', $payload);

        if (!$response->successful()) return false;

        $response = json_decode($response->body());

        if ($response->Success) {
            return $response->Data;
        }

        \Log::error('QR creation failed. Payload: ' . json_encode($payload, JSON_UNESCAPED_UNICODE) . '. Response: ' . json_encode($response, JSON_UNESCAPED_UNICODE));

        return false;
    }

    public function notification(TinkoffNotificationRequest $request)
    {
        $this->getTerminalByRequest($request);

        if (!$this->isValidToken($request)) {
            \Log::error('Token mismatched. Request: ' . json_encode($request, JSON_UNESCAPED_UNICODE));
            return response('Token mismatch', 401);
        }

        $order = Order::where('id', $request->OrderId)->first();
        if (!$order) {
            \Log::error('Order for payment not found. Request: ' . json_encode($request, JSON_UNESCAPED_UNICODE));
            return response('Order error', 404);
        }

        // Change order status
        switch ($request->Status) {
            case 'CONFIRMED':
                \Log::info('Order (ID #' . $request->OrderId . ') confirmed.');
                $order->status = Order::STATUSES['com'];
                break;
            case 'REVERSED':
            case 'REJECTED':
            case 'REFUNDED':
            case 'PARTIAL_REFUNDED':
                \Log::info('Order (ID #' . $request->OrderId . ') canceled.');
                $order->status = Order::STATUSES['f'];
                break;
            case 'AUTHORIZED':
                $order->status = Order::STATUSES['pr'];
                break;
            default:
                break;
        }

        if ($order->isDirty()) {
            $order->save();
            OrderUpdatedEvent::broadcast($order);
        }

        return response('OK');
    }

    private function generateToken($payload)
    {
        // unset token
        unset($payload['Token']);

        if(isset($payload['Receipt'])) $payload['Receipt'] = json_encode($payload['Receipt']);

        // add password to payload
        $payload['Password'] = $this->password;

        // sort by keys
        $sorted = $payload;
        ksort($sorted);

        $concatenated = '';

        foreach ($sorted as $item) {
            if(is_bool($item)) {
                $item = $item ? 'true' : 'false';
            }
            $concatenated .= $item;
        }

        $token = hash('sha256', $concatenated);

        $payload['Token'] = $token;

        unset($payload['Password']);

        if(isset($payload['Receipt'])) $payload['Receipt'] = json_decode($payload['Receipt']);

        return $payload;
    }

    private function isValidToken($request): bool
    {
        $requestToken = $request->Token;
        $generatedToken = $this->generateToken($request->validated())['Token'];

        return $generatedToken === $requestToken;
    }

    private function getTerminalByUser()
    {
        $hall = Hall::where('user_id', Auth::id())->first('prefix');

        $this->terminal_key = config('app.tinkoff_terminal_' . $hall->prefix . '_key');
        $this->password = config('app.tinkoff_' . $hall->prefix . '_password');
    }

    private function getTerminalByRequest(TinkoffNotificationRequest $request)
    {
        $terminalPrefix = null;

        foreach (self::$prefixes as $prefix) {
            if ($request->TerminalKey === config('app.tinkoff_terminal_' . $prefix . '_key')) {
                $terminalPrefix = $prefix;
                break;
            }
        }

        if (!$terminalPrefix) {
            \Log::error('Tinkoff terminal key not found');
            throw new Error('Terminal key not found');
        }

        $this->terminal_key = config('app.tinkoff_terminal_' . $terminalPrefix . '_key');
        $this->password = config('app.tinkoff_' . $terminalPrefix . '_password');
    }
}

<?php

namespace App\Http\Controllers;

use App\Events\OrderUpdatedEvent;
use App\Http\Requests\YookassaNotificationRequest;
use App\Models\Order;
use YooKassa\Client;

class YookassaController extends Controller
{
    private $client;

    private $secretKey;
    private $shopID;

    private $order;

    const STATUS_PENDING = 'pending';
    const STATUS_WAITING = 'waiting_for_capture';
    const STATUS_SUCCEEDED = 'succeeded';
    const STATUS_CANCELED = 'canceled';

    public function __construct()
    {
        if (app()->environment('production')) {
            $this->secretKey = config('app.yookassa_secret');
            $this->shopID = config('app.yookassa_shop_id');
        } else {
            $this->secretKey = config('app.yookassa_test_secret');
            $this->shopID = config('app.yookassa_test_shop_id');
        }

        $this->client = new Client();
        $this->client->setAuth($this->shopID, $this->secretKey);
    }

    public function shopInfo()
    {
        try {
            $response = $this->client->me();
        } catch (\Exception $e) {
            $response = $e;
            $this->logError($response);
        }

        return $response;
    }

    public function createPayment(Order $order, string $description = null, bool $isInstallments = false): string
    {
        $idempotenceKey = uniqid('', true);

        $payload = [
            'amount' => [
                'value' => $order->total,
                'currency' => 'RUB',
            ],
            'description' => $description,
            'confirmation' => [
                'type' => 'redirect',
                'locale' => 'ru_RU',
                'return_url' => config('app.land_url'),
            ],
            'capture' => true,
            'receipt' => [
                'customer' => [
                    'email' => $order->email,
                ],
                'items' => [
                    [
                        'description' => 'Сертификат на визит в Бизнес-зал. Заказ №' . $order->id . '.',
                        'quantity' => $order->quantity,
                        'amount' => [
                            'value' => $order->product->price,
                            'currency' => 'RUB',
                        ],
                        'vat_code' => 4,
                    ]
                ]
            ],
            'metadata' => [
                'orderId' => $order->id,
            ],
        ];

        // Если оплата частями - добавить параметр
        if($isInstallments) $payload['payment_method_data'] = [
            'type' => 'installments'
        ];

        $response = $this->client->createPayment($payload,
            $idempotenceKey
        );

        // get confirmationUrl for redirect
        return $response->getConfirmation()->getConfirmationUrl();
    }

    public function notification(YookassaNotificationRequest $request)
    {
        $payment = $this->paymentInfo($request->object['id']);

        $this->order = Order::where('id', $payment->metadata['orderId'] ?? '')->first();
        if (!$this->order) {
            \Log::error('Order for payment not found. Request: ' . json_encode($request, JSON_UNESCAPED_UNICODE));
            return response('Order error', 404);
        }
        switch ($payment->status) {
            case self::STATUS_PENDING:
                $this->order->status = Order::STATUSES['pr'];
                break;
            case self::STATUS_SUCCEEDED:
                $this->orderSucceed();
                break;
            case self::STATUS_WAITING:
                if ($this->capturePayment($request->object['id'], $this->order->total)) {
                    $this->orderSucceed();
                }
                break;
            case self::STATUS_CANCELED:
                $this->order->status = Order::STATUSES['f'];
                break;
        }

        if ($this->order->isDirty()) {
            $this->order->save();
            OrderUpdatedEvent::broadcast($this->order);
        }

        return response('', 200);
    }

    public function paymentInfo($paymentId)
    {
        return $this->client->getPaymentInfo($paymentId);
    }

    public function capturePayment($paymentId, float $amount)
    {
        $payment = $this->client->capturePayment(
            [
                'amount' => [
                    'value' => $amount,
                    'currency' => 'RUB',
                ]
            ],
            $paymentId,
            uniqid('', true));

        return $payment->status === self::STATUS_SUCCEEDED;
    }

    private function orderSucceed()
    {
        \Log::info('Order (ID #' . $this->order->id . ') confirmed.');
        $this->order->status = Order::STATUSES['com'];
    }

    private function logError($error)
    {
        if (!is_string($error)) $error = json_encode($error, JSON_UNESCAPED_UNICODE);

        \Log::error('Yookassa error: ' . $error);;
    }
}

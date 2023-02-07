<?php

namespace App\Http\Controllers;

use App\Events\OrderCreatedEvent;
use App\Http\Requests\OrderMakeRequest;
use App\Models\Certificate;
use App\Models\Order;
use Illuminate\Http\Response;
use PDF;

class OrderController extends Controller
{
    public function banksList(): array
    {
        return OrderMakeRequest::$banks;
    }

    public function productByUser()
    {
        return \auth()->user()->product;
    }

    public function orderMake(OrderMakeRequest $request)
    {
        if (!isset($request->quantity)) $request->quantity = 1;

        if (!isset($request->email)) {
            $request->email = \auth()->user()->email;
        }

        $order = Order::createOrder($request);

        if ($order instanceof Response) {
            return $order;
        }

        $payment = null;

        switch ($request->bank) {
            case OrderMakeRequest::TINKOFF:
                $tinkoff = new TinkoffController();
                $payment = $tinkoff->generateQR($order);

                $payment = str_replace('"', '``', $payment);
                break;
            case OrderMakeRequest::YOOKASSA:
                $yookassa = new YookassaController();
                $payment = $yookassa->createPayment($order, null, $request->installments);
                break;
            default:
                $order->delete();

                return response(
                    ['errors' =>
                        ['order' => ['Ошибка создания ссылки на оплату'],]
                    ], 422);
        }

        OrderCreatedEvent::broadcast($order);

        return response()->json([
            'status' => 'success',
            'data' => $payment,
        ]);
    }

    public function getAll()
    {
        return response()->json([
            'orders' => Order::all()
        ]);
    }
}

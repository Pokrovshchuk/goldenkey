<?php

namespace App\Listeners;

use App\Events\OrderUpdatedEvent;
use App\Http\Controllers\CertificateController;
use App\Models\Order;

class SendCertificate
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @return void
     */
    public function handle(OrderUpdatedEvent $event)
    {
        if ($event->order->status === Order::STATUSES['com']) {
            $order = Order::where('id',$event->order->id)->with('order_meta')->first();
            (new CertificateController())->store($order);
        }
    }
}

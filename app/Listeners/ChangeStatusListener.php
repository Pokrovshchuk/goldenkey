<?php

namespace App\Listeners;

use App\Events\CertificateChangeStatusEvent;
use App\Jobs\ChekTimerJob;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class ChangeStatusListener
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
     * @param  CertificateChangeStatusEvent  $event
     * @return void
     */
    public function handle(CertificateChangeStatusEvent $event)
    {
        $event->certificate->start_time = Carbon::now();
        $event->certificate->save();
    }
}

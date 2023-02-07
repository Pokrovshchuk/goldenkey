<?php

namespace App\Events;

use App\Models\Certificate;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CertificateChangeStatusEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Certificate $certificate;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }
}

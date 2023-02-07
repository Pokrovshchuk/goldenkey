<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CertificateScannedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public array $message;
    public int $user_id;

    public function __construct(array $message, int $user_id)
    {
        $this->message = $message;
        $this->user_id = $user_id;
    }

    public function broadcastOn(): Channel
    {
        return new PrivateChannel('user-events.' . $this->user_id);
    }
}

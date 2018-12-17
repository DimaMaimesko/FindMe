<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PrivateMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $room_id;

    public function __construct($message, $room_id)
    {
        $this->message = $message;
        $this->room_id = $room_id;
        $this->dontBroadcastToCurrentUser();
    }


    public function broadcastOn()
    {

        return new PresenceChannel('room.'.$this->room_id);

    }
}

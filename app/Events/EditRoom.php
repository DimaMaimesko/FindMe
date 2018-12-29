<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class EditRoom implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $members;
    public $room_id;



    public function __construct($members, $room_id)
    {
        $this->members = $members;
        $this->room_id = $room_id;
        $this->dontBroadcastToCurrentUser();
    }


    public function broadcastOn()
    {

        return new Channel('edit-room');
    }
}

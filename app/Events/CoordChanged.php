<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class CoordChanged  implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $lat;
    public $lng;
    public $time;
    public $user_id;



    public function __construct($lat, $lng, $time, $user_id)
    {
        $this->lat = $lat;
        $this->lng = $lng;
        $this->time = $time;
        $this->user_id = $user_id;
        $this->dontBroadcastToCurrentUser();
    }


    public function broadcastOn()
    {

        return new PrivateChannel('coordchanged');
    }
}

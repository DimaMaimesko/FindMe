<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\Room;

class Message extends Model
{

    protected $fillable = [
        'room_id', 'user_id', 'text', 'photo'
    ];



    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }



}

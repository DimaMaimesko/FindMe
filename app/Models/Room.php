<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use App\User;

class Room extends Model
{

    protected $fillable = [
        'name', 'creator_id'
    ];

    public function members()
    {
        return $this->belongsToMany(User::class, 'rooms_users');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id', 'id');
    }



}

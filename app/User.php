<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'photo','id'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = array('thumbnail', 'isFollowedByAuth');

    public function getThumbnailAttribute()
    {
        if (isset($this->photo)){
            $path = pathinfo($this->photo);
            return $path['dirname'].'/'.$path['filename'].'-thumb.jpg';
        }
        return "";
    }

    public function getIsFollowedByAuthAttribute()
    {
//        $authId = Auth::id();
//        Redis::command('sadd', ['followers'])
    }

//    public function rooms()
//    {
//        return $this->hasMany('App\Models\Room', 'creator_id', 'id');
//    }

    public function rooms()
    {
        return $this->belongsToMany('App\Models\Room', 'rooms_users');
    }

    public function myrooms()
    {
        return $this->hasMany('App\Models\Room', 'creator_id');
    }






}

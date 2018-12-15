<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Services\RelationsService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redis;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'photo'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
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
}

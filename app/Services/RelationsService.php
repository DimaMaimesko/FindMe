<?php
/**
 * Created by PhpStorm.
 * User: dima
 * Date: 14.12.18
 * Time: 21:06
 */

namespace App\Services;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Auth;

class RelationsService
{

   public function follow($id)
   {
       return Redis::sadd('followees:'.Auth::id(), $id);
   }

   public function unfollow($id)
   {
      return Redis::srem('followees:'.Auth::id(), $id);
   }

   public function getFolloweesIdsOf($id)
   {
       return Redis::smembers('followees:'.$id);
   }



}

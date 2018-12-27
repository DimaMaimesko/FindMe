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
       Redis::sadd('followees:'.Auth::id(), $id);
       Redis::sadd('followers:'.$id, Auth::id());
       if ($this->isMyFriend($id)){
           Redis::sadd('friends:'.Auth::id(), $id);
           Redis::sadd('friends:'.$id, Auth::id());
       }else{
           Redis::srem('friends:'.Auth::id(), $id);
           Redis::srem('friends:'.$id, Auth::id());
       }
   }

   public function unfollow($id)
   {
     Redis::srem('followees:'.Auth::id(), $id);
     Redis::srem('followers:'.$id, Auth::id());
       if ($this->isMyFriend($id)){
           Redis::sadd('friends:'.Auth::id(), $id);
           Redis::sadd('friends:'.$id, Auth::id());
       }else{
           Redis::srem('friends:'.Auth::id(), $id);
           Redis::srem('friends:'.$id, Auth::id());
       }
   }

   public function getFolloweesIdsOf($id)
   {
       return Redis::smembers('followees:'.$id);
   }

   public function getFollowersIdsOf($id)
   {
       return Redis::smembers('followers:'.$id);
   }

    public function getFriendsIdsOf($id)
    {
        return Redis::smembers('friends:'.$id);
    }

   private function isMyFollowee($id)
   {
      return Redis::sismember('followees:'.Auth::id(), $id);
   }

   private function isMyFollower($id)
   {
      return  Redis::sismember('followers:'.Auth::id(), $id);
   }

   private function isMyFriend($id)
   {
       if(($this->isMyFollowee($id) == 1) && ($this->isMyFollower($id) == 1)){
           return true;
       }else{
           return false;
       }

   }







}

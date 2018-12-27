<?php

namespace App\Http\Controllers\Frontend\Chat;

use Illuminate\Http\Request;
use App\Services\RelationsService;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;


class RoomsController extends Controller
{
    private  $relations;

    public function __construct(RelationsService $service)
    {
        $this->relations = $service;
    }

   public function getRooms()
   {
      $rooms = Auth::user()->rooms->toArray();
      return ['rooms' => $rooms];
   }


   public function getMembers(Request $request)
   {
      $room_id = $request->get('room_id');
      $room = Room::find($room_id);
      $members = $room->members->toArray();
      return ['members' => $members];
   }

   public function getFriends()
   {
      $ids = $this->relations->getFriendsIdsOf(Auth::id());
       if (!empty($ids)){
           $friends = User::whereIn('id', $ids)->get()->toArray();
           return ['friends' => $friends];
       }else{
           return ['friends' => []];
       }
   }



   public function createRoom(Request $request)
   {
       $checked =  $request->get('checked');
       $roomName = $request->get('roomName');
       $friends = [];
       foreach ($checked as $key => $value){
           if ($value == "true")
               $friends[] = $key;
       }
       $room = Room::create(['name' => $roomName]);
       $room->creator()->associate(Auth::user());
       $room->save();
       $room->members()->attach($friends);
       return $this->getRooms();

   }

   public function create()
   {
     return view('frontend/chat/index', [
         'room' => 25,
         'user' => 50,
     ]);
   }


}

<?php

namespace App\Http\Controllers\Frontend\Chat;

use App\Events\DeleteRoom;
use App\Events\EditRoom;
use App\Events\UpdateRooms;
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
      $rooms = Auth::user()->rooms()->with('creator')->get()->toArray();
      return ['rooms' => $rooms, 'authId' => Auth::id()];
   }


   public function getMembers(Request $request)
   {
      $room_id = $request->get('room_id');
      $room = Room::find($room_id);
      $members = $room->members->toArray();
//      dump($members);
//       if (($key = array_search(Auth::id(), $members)) !== false) {
//           unset($members[$key]);
//       }
//       dump($members);
      return ['members' => $members, 'authId' => Auth::id()];
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

   public function getMembersFriends(Request $request)
   {
      $idsOfMembers = [];
      $members = $this->getMembers($request);
      foreach ($members['members'] as $member){
          $idsOfMembers[] = $member['id'];
      }
      //dump($idsOfMembers);
      return ['checked' => $idsOfMembers, 'friends' => $this->getFriends()];
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
       $room->members()->attach(Auth::id());
       $this->broadcastUpdateRooms($room, $room->id);

       return $this->getRooms();

   }

   public function updateRoom(Request $request)
   {
       $checked =  $request->get('checked');
       $roomId = $request->get('room_id');
       $room = Room::find($roomId);
       $room->members()->sync($checked);
       //$this->broadcastUpdateRooms($room, $roomId);
       $members = $room->members;
       foreach ($members as $member){
           $membersIds[] = $member->id;
       }
       EditRoom::dispatch($membersIds, $roomId);
       return ['updatedMembersIds' =>$room->members];
   }

   public function deleteRoom(Request $request)
   {
       $roomId = $request->get('room_id');
       $room = Room::find($roomId);
       $room->members()->detach();
       $room->members()->detach(Auth::id());
       $room->delete();
       DeleteRoom::dispatch($roomId);
       return $this->getRooms();
   }

    public function quitRoom(Request $request)
    {
        $room_id = $request->get('room_id');
        $room = Room::find($room_id);
        $room->members()->detach(Auth::id());
        $rooms = Auth::user()->rooms()->with('creator')->get()->toArray();
        $members = $room->members;
        foreach ($members as $member){
            $membersIds[] = $member->id;
        }
        EditRoom::dispatch($membersIds, $room_id);
        return ['rooms' => $rooms];
    }

   public function create()
   {
     return view('frontend/chat/index', [
         'room' => 25,
         'user' => 50,
     ]);
   }

   private function broadcastUpdateRooms($room, $room_id)
   {
       if ($room !== 'deleted'){
           $membersIds = [];
           $members = $room->members;
           foreach ($members as $member){
               $membersIds[] = $member->id;
           }
           UpdateRooms::dispatch($membersIds);
       }else{
           UpdateRooms::dispatch($room_id);
       }


   }


}

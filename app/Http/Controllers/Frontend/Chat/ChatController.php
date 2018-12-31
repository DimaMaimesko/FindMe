<?php

namespace App\Http\Controllers\Frontend\Chat;

use App\Models\Room;
use App\Services\RelationsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
//use App\Events\Message;
use App\Events\PrivateMessage;
use App\Models\Message;

class ChatController extends Controller
{
   public function index()
   {
     return view('frontend/chat/index', [
         //'room' => 25,
         'user' => Auth::user(),
     ]);
   }

    public function sendMessage(Request $request)
    {
        $message = $request->get('message');
        $roomId = $request->get('room_id');
        $userId = $request->get('user_id');
        $newMessage = Message::create([
            'text' => $message,
        ]);
        $newMessage->creator()->associate($userId);
        $newMessage->room()->associate($roomId);
        $newMessage->save();
        $mess = Message::where('id', $newMessage->id)->with('creator')->first()->toArray();
        PrivateMessage::dispatch($mess, $roomId);
        return [$request->get('message'), $request->get('room_id')];
    }

    public function getMessages(Request $request)
    {
        $roomId = $request->get('room_id');
        $room = Room::find($roomId);
        $messages = $room->messages()->with('creator')->get()->toArray();
        return ['messages' => $messages];
    }
}

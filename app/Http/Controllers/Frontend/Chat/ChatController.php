<?php

namespace App\Http\Controllers\Frontend\Chat;

use App\Services\RelationsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Events\Message;
use App\Events\PrivateMessage;

class ChatController extends Controller
{
   public function index()
   {
     return view('frontend/chat/index', [
         'room' => 25,
         'user' => 50,
     ]);
   }

    public function sendMessage(Request $request)
    {
        PrivateMessage::dispatch($request->get('message'), $request->get('room_id'));
        return [$request->get('message'), $request->get('room_id')];
    }
}

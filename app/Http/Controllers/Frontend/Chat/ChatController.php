<?php

namespace App\Http\Controllers\Frontend\Chat;

use App\Services\RelationsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Events\Message;

class ChatController extends Controller
{
   public function index()
   {
     return view('frontend/chat/index');
   }

    public function sendMessage(Request $request)
    {
        Message::dispatch($request->input('body'));
    }
}

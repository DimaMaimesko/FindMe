<?php

namespace App\Http\Controllers\Frontend\Chat;

use App\Services\RelationsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Events\Message;
use App\Events\PrivateMessage;

class RoomsController extends Controller
{
   public function create()
   {
     return view('frontend/chat/index', [
         'room' => 25,
         'user' => 50,
     ]);
   }


}

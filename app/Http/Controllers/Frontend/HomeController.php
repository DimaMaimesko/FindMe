<?php

namespace App\Http\Controllers\Frontend;

use App\Services\RelationsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    private  $relations;

    public function __construct(RelationsService $service)
    {
        $this->relations = $service;
    }

    public function index()
    {
        $users = User::all()->toArray();
        return view('frontend.index',[
            'users' => $users,
            'authUserId' => Auth::id(),
            'followees' => $this->relations->getFolloweesIdsOf(Auth::id()),
        ]);
    }


    public function follow(Request $request)
    {
       $this->relations->follow($request->get('id'));
       return ['followees' => $this->relations->getFolloweesIdsOf(Auth::id())];

    }


    public function unfollow(Request $request)
    {
        $this->relations->unfollow($request->get('id'));
        return ['followees' => $this->relations->getFolloweesIdsOf(Auth::id())];

    }
}

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

    public function getUsers(Request $request)
    {
        $pickedGroup = $request->get('pickedGroup');
        if ($pickedGroup == 'all'){
            $users = User::all()->toArray();
            return ['users' => $users];
        }
        if ($pickedGroup == 'friends'){
            $ids = $this->relations->getFriendsIdsOf(Auth::id());
            if (!empty($ids)){
                $users = User::whereIn('id', $ids)->get()->toArray();
                return ['users' => $users];
            }else{
                return ['users' => []];
            }
        }
        if ($pickedGroup == 'followers'){
            $ids = $this->relations->getFollowersIdsOf(Auth::id());
            if (!empty($ids)){
                $users = User::whereIn('id', $ids)->get()->toArray();
                return ['users' => $users];
            }else{
                return ['users' => []];
            }
        }
        if ($pickedGroup == 'followees'){
            $ids = $this->relations->getFolloweesIdsOf(Auth::id());
            if (!empty($ids)){
                $users = User::whereIn('id', $ids)->get()->toArray();
                return ['users' => $users];
            }else{
                return ['users' => []];
            }
        }
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

<?php

namespace App\Http\Controllers\Frontend\Map;

use App\Events\CoordChanged;
use App\Services\RelationsService;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MapController extends Controller
{
    private  $relations;

    public function __construct(RelationsService $service)
    {
        $this->relations = $service;
    }



    public function getAllFriends()
    {
        $ids = $this->relations->getFriendsIdsOf(Auth::id());
        if (!empty($ids)){
            $friends = User::whereIn('id', $ids)->get()->toArray();
            //dump($friends);
            return ['friends' => $friends];
        }else{
            return ['friends' => []];
        }
    }

    public function writeNewPosition(Request $request)
    {
        $lat = $request->get('lat');
        $lng = $request->get('lng');
        $this->relations->writePositionForAuth($lat, $lng);
        $this->relations->writeTimeForAuth();
        $newPosition = $this->relations->getPositionForAuth();
        $newTime = $this->relations->getTimeForAuth();
        //event(new CoordChanged($lat, $lng, $newTime, Auth::id()));
        broadcast(new CoordChanged($lat, $lng, $newTime, Auth::id()));
        return [
            'newPosition' => $newPosition,
            'newTime'     => $newTime,
            ];
    }



}

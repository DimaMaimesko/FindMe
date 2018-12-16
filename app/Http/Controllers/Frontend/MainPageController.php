<?php

namespace App\Http\Controllers\Frontend;

use App\Services\RelationsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;


class MainPageController extends Controller
{


    public function index()
    {
        return view('frontend.page.index');


    }



}

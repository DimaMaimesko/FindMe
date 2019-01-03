@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <a href="{{route('frontend.chat.index')}}" class="btn btn-info">Chat</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6">

            <h3>Map</h3>
            <map-component  ref="foo"></map-component>
            <div style="height: 300px" id="map"></div>
        </div>
        <div class="col-md-6">

            <h3>Watch friends</h3>

            <watch-friends></watch-friends>

        </div>
    </div>






@endsection





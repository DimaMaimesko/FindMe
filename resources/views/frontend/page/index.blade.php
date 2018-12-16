@extends('layouts.app')

@section('content')

    <h1>Main Users Page</h1>
    <h3>Events</h3>
    <h3>Map</h3>
    <h3>Watch friends</h3>

    <a href="{{route('frontend.chat.index')}}" class="btn btn-info">Chat</a>



@endsection

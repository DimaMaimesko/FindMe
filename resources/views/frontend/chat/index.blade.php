@extends('layouts.app')

@section('content')

    <h1>Chat</h1>

    <chat-component :room="{{$room}}" :user="{{$user}}"></chat-component>


@endsection

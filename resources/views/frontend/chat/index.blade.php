@extends('layouts.app')

@section('content')

    <h1 class="text-center">Chat</h1>

    <chat-component  :user="{{$user}}"></chat-component>


@endsection

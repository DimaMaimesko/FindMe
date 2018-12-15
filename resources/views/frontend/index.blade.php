@extends('layouts.app')

@section('content')


    <users-table :users="{{json_encode($users)}}" :auth-user-id="{{$authUserId}}" :followees="{{json_encode($followees)}}"></users-table>

@endsection

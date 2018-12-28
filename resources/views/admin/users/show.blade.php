@extends('layouts.app')

@section('content')
    @include('admin.users._nav')
    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.users.index') }}" class="btn btn-dark mr-1">Back</a>
        <form method="POST" action="{{ route('admin.users.destroy', ['user'=> $user]) }}" data-confirm="Do you want to delete user {{$user->name}}?" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">Delete</button>
        </form>
        <a href="{{ route('admin.users.edit',['user'=> $user]) }}" class="btn btn-primary mr-1">Edit</a>

    </div>
    <div class="row">

        <div class="col-md-4">
            @if(isset($user->photo))
            <div class="img-thumbnail m-md-2">
                <a href="{{asset($user->photo)}}">
                    <img src="{{asset($user->thumbnail)}}" alt="Photo" style="width:100%">

                </a>
            </div>
            @endif
        </div>

    </div>
    <table class="table table-bordered table-striped">
        <tbody>

            <tr>
                <th>ID</th><td>{{ $user->id }}</td>
            </tr>
            <tr>
                <th>Name</th><td>{{ $user->name }}</td>
            </tr>
            <tr>
                <th>Email</th><td>{{ $user->email }}</td>
            </tr>

        </tbody>
    </table>
@endsection



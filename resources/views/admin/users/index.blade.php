@extends('layouts.app')

@section('content')
    @include('admin.users._nav')
    <div class="row">
        <div class="col-6 col-md-8 col-lg-10">
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <p>
                <a href="{{ route('admin.users.create') }}" class="btn btn-success text-uppercase">
                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                    Create new User
                </a>
            </p>
        </div>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th style="width:100px">Photo</th>
            <th>Name</th>
            <th>Email</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>
                    @if(isset($user->photo))

                        <a href="{{asset($user->photo)}}">
                            <img src="{{asset($user->thumbnail)}}" alt="Photo" style="width:100%">

                        </a>

                        @endif
                </td>
                <td><a href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></td>
                <td>{{ $user->email }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection

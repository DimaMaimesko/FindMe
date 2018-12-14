@extends('layouts.app')

@section('content')
    @include('admin.users._nav')


    {!! Form::open(['url' => route('admin.users.update',['user'=> $user]),'method'=>'PUT','data-parsley-validate','autocomplete'=>'off', 'enctype'=>"multipart/form-data"]) !!}
    <div class="form-group">
        <label for="userCreateName">Username</label>
        {!! Form::text('name',$user->name,['class'=>'form-control','placeholder'=>'Username','required','id'=>'userCreateName']) !!}
    </div>
    <div class="form-group">
        <label for="userCreateEmail">Email address</label>
        {!! Form::email('email',$user->email,['class'=>'form-control','placeholder'=>'Email','required','id'=>'userCreateEmail']) !!}
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>

    <div class="form-group">
        <div class="form-group">
            <label>Image</label>
            <br>
            @if(!empty($user->photo))
                <img src="{{asset($user->thumbnail)}}" width="100px">
            @endif
            {!! Form::file('photo',['class'=>'form-control']) !!}
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Submit</button>
        </div>
    </div>

    {!! Form::close() !!}
@endsection

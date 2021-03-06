@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    {!! Form::open(['url' => route('admin.users.store'),'method'=>'POST','autocomplete'=>'off', 'enctype'=>"multipart/form-data"]) !!}
    <br>
    <div class="form-group">
        <label for="userCreateName">Username</label>
        {!! Form::text('name',null,['class'=>'form-control','placeholder'=>'Username','required','id'=>'userCreateName']) !!}
    </div>
    <div class="form-group">
        <label for="userCreateEmail">Email address</label>
        {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Email','required','id'=>'userCreateEmail']) !!}
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="userCreatePassword">Password</label>
        {!! Form::password('password',['class'=>'form-control','placeholder'=>'Password','required','id'=>'userCreatePassword']) !!}
    </div>
    <div class="form-group">
        <label>Photo</label>
        {!! Form::file('photo',['class'=>'form-control']) !!}
    </div>


    <button type="submit" class="btn btn-success text-uppercase"><i class="fa fa-save"></i> Submit</button>

    {!! Form::close() !!}
@endsection

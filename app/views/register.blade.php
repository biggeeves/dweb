@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-2">Registration Page</div>
    </div>
    @if( Session::has( 'message' ) )
        <div class="row">
            <div class="col-md-6 col-md-offset-2 alert alert-danger">There are session messages</div>
            <div class="col-md-6 col-md-offset-2 alert alert-success">{{ Session::get( 'message' ) }}</div>
        </div>
    @endif

<div class="welcome">
    <h1>New Users Registration</h1>
    {{Form::open(array('url' => 'register')) }}
        {{Form::label('firstname', 'First Name') }}
        {{Form::text('firstname')}} <br />

        {{Form::label('lastname', 'Last Name') }}
        {{Form::text('lastname')}} <br />

        {{Form::label('email', 'Email Address') }}
        {{Form::text('email')}} <br />
    
        {{Form::label('username', 'Username') }}
        {{Form::text('username')}} <br />
    
        {{Form::label('password', 'Password') }}
        {{Form::password('password')}} <br />
        
        {{Form::submit('Sign up')}}
    
    {{Form::close()}}
    
</div>
@stop
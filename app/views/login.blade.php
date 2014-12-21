@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-2">Log In Page</div>
    </div>
    @if( Session::has( 'message' ) )
        <div class="row">
            <div class="col-md-6 col-md-offset-2 alert alert-danger">There are session messages</div>
            <div class="col-md-6 col-md-offset-2 alert alert-success">{{ Session::get( 'message' ) }}</div>
        </div>
    @endif

<div class="welcome">
    <h1>Log In</h1>
    {{Form::open(array('url' => 'login')) }}

        {{Form::label('username', 'Username') }}
        {{Form::text('username')}} <br />
    
        {{Form::label('password', 'Password') }}
        {{Form::password('password')}} <br />
        
        {{Form::submit('Log In')}}
    
    {{Form::close()}}
    
</div>
@stop
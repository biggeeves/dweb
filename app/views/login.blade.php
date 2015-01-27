@extends('layout')
@section('content')
    <div class="row">
        <h2 class="col-md-6 col-md-offset-2">Welcome.  Please log in.</h2>
    </div>
    @if( Session::has( 'message' ) )
        <div class="row">
            <div class="col-md-6 col-md-offset-2 alert alert-danger">There are session messages</div>
            <div class="col-md-6 col-md-offset-2 alert alert-success">{{ Session::get( 'message' ) }}</div>
        </div>
    @endif
    @if( isset( $err ) )
			<div class="col-md-6 col-md-offset-2 alert alert-success">{{ $err }}</div>
    @endif
<div class="welcome">
    <h1>Log In</h1>
    <p>
    {{ $errors->first('email') }}
    {{ $errors->first('password') }}
    </p>
    {{Form::open(array('url' => 'login')) }}

        {{Form::label('user_login', 'Username') }}
        {{Form::text('user_login')}} <br />
    
        {{Form::label('user_password', 'Password') }}
        {{Form::password('user_password')}} <br />
        
        {{Form::submit('Log In')}}
    
    {{Form::close()}}
    
</div>
@stop
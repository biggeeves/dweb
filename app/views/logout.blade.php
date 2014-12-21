@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-2">Log out Page</div>
    </div>
    @if( Session::has( 'message' ) )
        <div class="row">
            <div class="col-md-6 col-md-offset-2 alert alert-danger">There are session messages</div>
            <div class="col-md-6 col-md-offset-2 alert alert-success">{{ Session::get( 'message' ) }}</div>
        </div>
    @endif

<div class="welcome">
    <h1>Log out</h1>
    <p>You have successfully logged out. <a href="{{URL::to('/login')}}"> Log in? </a></p>   
</div>
@stop
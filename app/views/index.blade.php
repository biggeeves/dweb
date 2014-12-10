@extends('layout')
@section('content')
    <div class="row">
        <div class="col-md-6 col-md-offset-2">DCC Home Page</div>
    </div>
    @if( Session::has( 'message' ) )
        <div class="row">
            <div class="col-md-6 col-md-offset-2 alert alert-danger">There are session messages</div>
            <div class="col-md-6 col-md-offset-2 alert alert-success">{{ Session::get( 'message' ) }}</div>
        </div>
    @endif

<div class="welcome">
		<a href="sir_table"><h1>This is called the home page (index) right now</h1></a>
	</div>
@stop
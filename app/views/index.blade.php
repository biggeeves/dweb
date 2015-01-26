@extends('layout')
@section('content')
    <div class="welcome">
		<a href="sir_table"><h1>DCC Home Page (index)</h1></a>
    </div>
    @if( Session::has( 'message' ) )
        <div class="row">
            <div class="col-md-12 alert alert-success">{{ Session::get( 'message' ) }}</div>
        </div>
    @endif

@stop
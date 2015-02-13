@extends('layout')
@section('content')
    <h2>Opps.  You've found our error page.</h2>

    @if ( Session::has( 'message' ) )
    <div class="row">
        <div class="col-md-6 col-md-offset-2 alert alert-success">{{ Session::get( 'message' ) }}</div>
    </div>
    @endif

 @stop
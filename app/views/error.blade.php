@extends('layout')
@section('content')
    <h2>Error Page
    </h2>

    @if ( Session::has( 'message' ) )
    <div class="row">
        <div class="col-md-6 col-md-offset-2 alert alert-success">{{ Session::get( 'message' ) }}</div>
    </div>
    @endif

    <p>Opps.  You've found our error page.</p>

 @stop
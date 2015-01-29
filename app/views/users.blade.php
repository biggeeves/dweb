@extends('layout')
@section('content')
    @foreach( $users as $user )
        <p>UserName: {{ $user->username }}</p>
	@endforeach
@stop
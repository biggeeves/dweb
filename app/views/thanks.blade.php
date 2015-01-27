@extends('layout')
@section('content')
    <h1>Thanks for registering! We'll send your first email to: {{$theEmail}}</h1>
    <h1>Your hashed password is : {{$hashedpw}}</h1>
@stop
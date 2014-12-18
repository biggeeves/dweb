@extends('layout')
@section('content')
<h1>Newsletter sign up</h1>
{{Form::open(array('url' => 'thanks', 'class' => 'zzzzzzzzzzzzzzzz')) }}
    {{Form::label('email', 'Email Address')}}
    {{Form::text('email')}}
    <br />
    {{Form::label('os', 'Operating System')}}
    {{Form::select('os', array(
        'Linux' => 'Linux',
        'mac' => 'Mac OS x',
        'windows' => 'Windows'
    ))}}
    <br />
    {{Form::label('comment', 'Comments')}}
    {{Form::textarea('comment','', array('placeholder' => 'What are your interests' ))}}
    <br />
    {{Form::checkbox('agree', 'yes', false)}} <br />
    {{Form::label('agree', 'I agree to your terms of service')}}
    <br />
    {{Form::submit('Sign Up')}}

{{Form::close()}}

@stop
@extends('layout')
@section('content')
    <h2>Nerd Form Update</h2>
	<h3>Selected Nerd</h3>
	
    @if ( ! $errors->isEmpty() )
    <div class="row">
        @foreach ( $errors->all() as $error )
        <div class="col-md-6 col-md-offset-2 alert alert-danger">{{ $error }}</div>
        @endforeach
    </div>
    @elseif ( Session::has( 'message' ) )
    <div class="row">
        <div class="col-md-6 col-md-offset-2 alert alert-success">{{ Session::get( 'message' ) }}</div>
    </div>
    @else
        <p>&nbsp;</p>
    @endif
	


	{{ Form::model($nerd, array('route' => 'nerd.edit', $nerd->id_num)) }}	

		<!-- id_num -->
		{{ Form::label('id_num', 'ID NUM ') }}
		{{ Form::text('idnum') }}
        <br/ >

        <!-- name -->
		{{ Form::label('slname', 'Last Name') }}
		{{ Form::text('slname') }}
        <br />

        <!-- name -->
		{{ Form::label('sfname', 'First Name') }}
		{{ Form::text('sfname') }}
        <br />

        <!-- name -->
		{{ Form::label('status', 'Status') }}
		{{ Form::text('status') }}
        <br />
{{ Form::submit('Update Nerd!') }}

	{{ Form::close() }}

		
@stop
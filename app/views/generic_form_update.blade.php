@extends('layout')
@section('content')
    <h2>{{$tableName}}  Generic Form Update</h2>
	<h3>Selected {{$this_crf}}</h3>
	
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
	
	@if (count($crf) == 0 )
		<p>There are no records in that table</p>
	@else
{{ Form::open(array('url' => url('crud'), 'class'=>'form-horizontal', 'id'=>'frmFoo', 'style'=>'border:solid gray 1px')) }}

		<form class="form-horizontal" role="form" action="crud"  method="POST">
		    {{Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-primary'])}}
			{{Form::hidden('crf', $tableName)}}
			@foreach( $crf as $key=>$value )
					<div class="form-group">
						<label for="{{$key}}" class="col-sm-2 control-label">{{$key}}</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="{{$key}}" name="{{$key}}" value="{{$value}}">
						</div>
					</div>
			@endforeach
	    {{ Form::close() }}
	@endif
	<p>Database Tables</p>
	@foreach ($tables as $tablename)
		@foreach($tablename as $key=>$value)
			<p><a href="generic?crf={{$value}}">{{$value}}</a></p>
		@endforeach
	@endforeach
		
@stop
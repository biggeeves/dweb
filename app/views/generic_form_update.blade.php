@extends('layout')
@section('content')
    <h2>{{$tableName}}  Generic Form Update</h2>
	<h3>Selected {{$this_crf}}</h3>
	
    @if ( ! $errors->isEmpty() )
    <div class="row">
        <div class="col-md-4 alert alert-danger">Please fix these errors before continuing on.</div>
        <div class="col-md-6 col-md-offset-2 alert alert-danger">
            <ul>
        @foreach ( $errors->all() as $error )
            <li>{{ $error }} </li>
        @endforeach
            </ul>
        </div>
    </div>
    @elseif ( Session::has( 'message' ) )
    <div class="row">
        <div class="col-md-6 col-md-offset-2 alert alert-danger">There are session messages</div>
        <div class="col-md-6 col-md-offset-2 alert alert-success">{{ Session::get( 'message' ) }}</div>
    </div>
    @else
        <p>&nbsp;</p>
    @endif
	
	@if (count($crf) == 0 )
		<p>There are no records in that table</p>
	@else
    <div class="row">
        <div class="col-md-12 well">
        
        {{ Form::open(array('url' => url('crud'), 'class'=>'form-horizontal', 'id'=>'frmFoo')) }}

		<form class="form-horizontal" role="form" action="crud"  method="POST">
		    {{Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-primary', 'name' => 'submit', 'value'=>'update'])}}
			{{Form::hidden('crf', $tableName)}}
			@foreach( $crf as $key=>$value )
					<div class="form-group">
						<label for="{{$key}}" class="col-sm-2 control-label">{{$key}}</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="{{$key}}" name="{{$key}}" value="{{$value}}">
						</div>
                    @if ($errors->has($key)) 
                        <div class="col-md-6 col-md-offset-3 alert alert-danger">{{$errors->first($key);}}</div>
                    @endif
					</div>
            @endforeach
	    {{ Form::close() }}
	@endif
        </div>
    </div>
   
		
@stop
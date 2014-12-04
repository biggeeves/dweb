@extends('layout')
@section('content')
    <h2>{{$tableName}}  Generic Form View- Read Only</h2>
		<a href="generic?caseid=W05004&crud=u">Link to W05004</a>

	<h3>Selected {{$this_crf}}</h3>
	@if (count($crf) == 0 )
		<p>There are no records in that table</p>
	@else
		<form class="form-horizontal" role="form">
			@foreach( $crf as $key=>$value )
					<div class="form-group">
						<label for="{{$key}}" class="col-sm-2 control-label">{{$key}}</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="{{$key}}" value="{{$value}}">
						</div>
					</div>
			@endforeach
		</form>
	@endif
	@foreach ($tables as $tablename)
		@foreach($tablename as $key=>$value)
			<p><a href="generic?crf={{$value}}">{{$value}}</a></p>
		@endforeach
	@endforeach
		
@stop
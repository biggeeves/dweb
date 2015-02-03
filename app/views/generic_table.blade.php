@extends('layout')
@section('content')
    <h2>{{$tableName}}  Generic Table View</h2>
	@if (count($this_crf) == 0 )
        <a href="{{URL::route('showForm', array('crf'=>$tableName,'caseid'=>'1720'))}}" class="btn btn-default">Create a New one</a>
	@endif
		<p>There are {{count($this_crf)}} record(s) in that table.  CASEID: {{$db_caseid}}</p>
		<table class="table table-striped table-bordered table-hover">
			<tr>
				@foreach( $columns as $column )
					<th>{{{$column}}}</th>
				@endforeach
			</tr>
			@foreach( $this_crf as $this_row )
                <tr>
				@foreach($this_row as $key=>$value)
					<?php if( $key === $db_caseid )   { $value = "<a href='$tableName?caseid=$value'>$value</a>"; } ?>
					<td>{{$value}}</td>
				@endforeach
                </tr>
		@endforeach
		</table>
@stop
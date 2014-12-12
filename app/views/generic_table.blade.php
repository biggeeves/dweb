@extends('layout')
@section('content')
    <h2>{{$tableName}}  Generic Table View</h2>
	<h3>Selected {{$this_crf}}</h3>
	@if (count($crf) == 0 )
		<p>There are no records in that table</p>
	@else
		<p>There are {{count($crf)}} record(s) in that table</p>
		<table class="table table-striped table-bordered table-hover">
			<tr>
				@foreach( $columns as $column )
					<th>{{{$column}}}</th>
				@endforeach
			</tr>
			@foreach( $crf as $this_row )
                <tr>
				@foreach($this_row as $key=>$value)
					<?php if( $key === 'id_num' )   { $value = "<a href='generic?caseid=$value&crf=$this_crf'>$value</a>"; } ?>

					<td>{{$value}}</td>
				@endforeach
                </tr>
		@endforeach
		</table>
	@endif
@stop
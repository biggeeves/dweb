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
			<tr>
				@foreach( $crf as $this_row )
				<?php $columnCount=0; ?>
			<tr>
				@foreach($this_row as $key=>$value)
					<?php $columnCount++; ?>
					<?php if( $columnCount === 1 )   { $value = "<a href='generic?caseid=$value'>$value</a>"; } ?>

					<td>{{$value}}</td>
				@endforeach
			</tr>
		@endforeach
		</table>
	@endif
@stop
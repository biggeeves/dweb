@extends('layout')
@section('content')
    <h2>{{$tableName}}  Table View</h2>
	<table class="table table-striped table-bordered table-hover">
		<tr>
		@foreach( $columns as $column )
				<th>{{$column}}</th>
		@endforeach
		</tr>
		
		</tr>
		@foreach( $ptracks as $ptrack )
			<tr>
			@foreach( $ptrack->toArray() as $property=>$value )
				<td>
				@if (isset ( $value ) )
					{{$value}}
				@else
					Null
				@endif
				</td>
			@endforeach
			</tr>
		@endforeach
	</table>
@stop
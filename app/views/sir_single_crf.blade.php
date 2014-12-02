@extends('layout')
@section('content')
    <h2>{{$tableName}}  Table View</h2>
	<h3>Selected {{$this_crf}}</h3>
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
	
	
	<p>Current directions.  Include?slname=XXXX and change XXXX to someones last name to query the database
	It uses the LIKE SQL and at this point is non-case sensitive just like SQL</p>
	<p>{{gettype($lol)}}  , {{count($lol)}}, {{var_dump($lol)}}</p>
	@foreach( $lol as $laugh)
<p>{{$laugh}}</p>


@endforeach
	
	
	<p>end</p>
@stop
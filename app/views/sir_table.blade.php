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
			<?php $columnCount =0; ?>
			<tr>
			@foreach( $ptrack->toArray() as $property=>$value )
				<?php $columnCount++; ?>
				<td>
				@if (isset ( $value ) )
					<?php if( $columnCount === 1 )   { $value = "<a href='generic?caseid=$value'>$value</a>"; } ?>
					<?php if( $property == 'SLNAME' )  { $value = "<a href='sir_table?crf=crf_ptrack&amp;slname=$value'>$value</a>"; } ?>
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
	<p>The results of the query will show below</p>
	@if ( count( $lol )  == 0 )
		<p>No Results</p>
	@else
		@foreach( $lol as $laugh)
			<p>Results include: {{$laugh}}</p>
		@endforeach
	@endif
	<p>Debug Info- Type: {{gettype($lol)}}  , Count: {{count($lol)}}, var_dump: {{var_dump($lol)}}</p>
	<p>end of page</p>
@stop
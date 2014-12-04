@extends('layout')
@section('content')
    <h2>{{$tableName}}  From Update</h2>
	
	<form class="form-horizontal" role="form">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Remember me
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Sign in</button>
    </div>
  </div>
</form>
	
	
	
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

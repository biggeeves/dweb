@extends('layout')
@section('content')
    <h2>{{$tableName}}  Generic Form View- Read Only</h2>
		<a href="generic?caseid={{$caseid}}&crud=u">Edit {{$caseid}}</a>
            
                        
	<h3>Selected {{$this_crf}}</h3>
	@if (count($crf) == 0 )
		<p>There are no records in that table</p>
	@else
		<form class="form-horizontal" role="form">
			@foreach( $crf as $key=>$value )
                <?php $thisLabel = $key; ?>
					<div class="form-group">
                        <?php 
                            foreach( $varSchema as $schemaRow ) {
                                $b= $schemaRow->toArray(); 
                                if ($b['variable_name'] == $key ) {
                                    $thisLabel = $b['variable_label'];
                                    break;
                                }
                            }
                        ?>
						<label for="{{$key}}" class="col-sm-2 control-label">{{$thisLabel}}</label>
						<div class="col-sm-10">
							<input type="text" class="form-control" id="{{$key}}" value="{{$value}}">
						</div>
					</div>
			@endforeach
		</form>
	@endif
@stop
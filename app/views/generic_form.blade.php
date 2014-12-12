@extends('layout')
@section('content')
    <h2>{{$tableName}}  Generic Form View- Read Only</h2>
		<a href="generic?caseid={{$caseid}}&crud=u&crf={{$this_crf}}">Edit {{$caseid}}</a>


                        
	<h3>Selected {{$this_crf}}</h3>
	@if (count($crf) == 0 )
		<p>There are no records in that table</p>
	@else
		<form class="form-horizontal" role="form">
			@foreach( $crf as $key=>$value )
                <?php $thisLabel = $key; 
                    $thisMax = ''; 
                    $thisMin = '';
                    $valueLabels = [];
                ?>
					<div class="form-group">
                        <?php 
                            foreach( $varSchema as $schemaRow ) {
                                $b= $schemaRow->toArray(); 
                                if ($b['variable_name'] == $key ) {
                                    $thisLabel = $b['variable_label'];
                                    $thisMin = $b['variable_range_min'];
                                    $thisMax = $b['variable_range_max'];
                                    break;
                                }
                            }
                            $valueLabels = [];
                            foreach( $valueSchema as $valueRow ) {
                                $c= $valueRow->toArray(); 
                                if ($c['variable_name'] == $key ) {
                                    $valueLabels[] = $c['value_label'];
                                }
                            }
                        ?>
						<label for="{{$key}}" class="col-sm-2 control-label">{{$thisLabel}}</label>
						<div class="col-sm-4">
							<input type="text" class="form-control" id="{{$key}}" value="{{$value}}"  min="{{$thisMin}}" max="{{$thisMax}}">
						</div>
						<div class="col-sm-5">
                            @if ( count($valueLabels) > 0 )
                                <select>
                                    @foreach ($valueLabels as $label) 
                                        <option class="form-control" value="{{$label}}">{{$label}}</option>
                                    @endforeach
                                </select>
                            @endif
						</div>
					</div>
			@endforeach
		</form>
	@endif
@stop
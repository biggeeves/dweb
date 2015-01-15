@extends('layout')
@section('content')
    <h2>{{$tableName}}  Generic Form View- Read Only</h2>
		<a href="{{$tableName}}?caseid={{$caseid}}&crud=u">Edit {{$caseid}}</a>
        @if (count($crf) == 0 )
		<p>There are no records in that table</p>
	@else
		<form class="form-horizontal" role="form">
			@foreach( $crf as $key=>$value )
                <?php 
                    $varLabel = $key; 
                    $varMax = ''; 
                    $varMin = '';
                    $valueLabels = [];
                ?>
					<div class="form-group">
                        <?php 
                            foreach( $varSchema as $schemaRow ) {
                                $b= $schemaRow->toArray(); 
                                if ($b['variable_name'] == $key ) {
                                    $varLabel = $b['variable_label'];
                                    $varMin = $b['variable_range_min'];
                                    $varMax = $b['variable_range_max'];
                                    break;
                                }
                            }
                            $valueLabels = [];
                            foreach( $valueSchema as $valueRow ) {
                                $c= $valueRow->toArray(); 
                                if ($c['variable_name'] == $key ) {
                                    $valueLabels[ $c['value'] ] = $c['value_label'];
                                }
                            }
                        ?>
                        <label for="{{$key}}" class="col-sm-6 control-label" style="text-align:left;">{{$varLabel}}</label>
						<div class="col-sm-3">
							<input type="text" class="form-control" id="{{$key}}" name="{{$key}}" value="{{$value}}"
                            @if (count($valueLabels) > 0 ) oninput="SelectListFromValue('{{$key}}','{{$key}}_list');" @endif
                            @if( isset($varMin) ) min="{{$varMin}}" @endif 
                            @if( isset($varMax) ) max="{{$varMax}}" @endif 
                            >
						</div>
						<div class="col-sm-3">
                            @if ( count($valueLabels) > 0 )
                                <select oninput="SelectValueFromList('{{$key}}_list','{{$key}}');" name="{{$key}}_list" id="{{$key}}_list">
                                    @foreach ($valueLabels as $labelValue=>$label) 
                                        <option class="form-control" value="{{$labelValue}}" >{{$label}}</option>
                                    @endforeach
                                </select>
                            @endif
						</div>
					</div>
			@endforeach
		</form>
	@endif
@stop
@extends('layout')
@section('content')
    <h2>{{$tableName}}  Generic Form View
    	@if($crud == 'r') (Read Only) <a href="{{$tableName}}?caseid={{$caseid}}&crud=u">Edit {{$caseid}}</a> 
        @else Update
        @endif
    </h2>

    @if ( ! $errors->isEmpty() )
    <div class="row">
        <div class="col-md-4 alert alert-danger">Please fix these errors before continuing on.</div>
        <div class="col-md-6 col-md-offset-2 alert alert-danger">
            <ul>
        @foreach ( $errors->all() as $error )
            <li>{{ $error }} </li>
        @endforeach
            </ul>
        </div>
    </div>
    @elseif ( Session::has( 'message' ) )
    <div class="row">
        <div class="col-md-12 alert alert-success">{{ Session::get( 'message' ) }}</div>
    </div>
    @endif



    @if (count($crf) == 0 )
		<p>There are no records in that table</p>
	@else
        {{ Form::open(array('url' => url('forms/crud'), 'class'=>'form-horizontal', 'id'=>'crf_form', 'role'=>'form', 'data-parsley-validate'=>'' ))  }}
            @if ($crud == 'u')
                {{Form::button('Save', ['type' => 'submit', 'class' => 'btn btn-primary', 'name' => 'submit', 'value'=>'update'])}}
                {{Form::button('Delete', ['type' => 'submit', 'class' => 'btn btn-primary', 'name' => 'submit', 'value'=>'delete'])}}
                {{Form::hidden('crf', $tableName)}}
            @endif
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
                                if(!$c['value_value'] =='') {
                                    $valueLabels[ $c['value_value'] ] = $c['value_label'];
                                }
                            }
                        }
                    ?>
                    <label for="{{$key}}" class="col-sm-6 control-label" style="text-align:left;" title="{{$key}}">{{$varLabel}}</label>
                    <div class="col-sm-3">
                        <input type="text" class="form-control" id="{{$key}}" name="{{$key}}" value="{{$value}}"
                        @if (count($valueLabels) > 0 ) oninput="SelectListFromValue('{{$key}}','{{$key}}_list');" @endif
                        @if( !$varMin == '' ) min="{{$varMin}}" @endif 
                        @if( !$varMax == '' ) max="{{$varMax}}" @endif 
                        >
                    </div>
                    <div class="col-sm-3">
                        @if ( count($valueLabels) > 0 )
                            <select oninput="SelectValueFromList('{{$key}}_list','{{$key}}');" name="{{$key}}_list" id="{{$key}}_list" class="form-control" >
                                <option value=""></option>
                                @foreach ($valueLabels as $labelValue=>$label) 
                                    <option value="{{$labelValue}}" @if ($labelValue == $value) selected="selected" @endif>{{$label}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                </div>
			@endforeach
		{{Form::close()}}
        <script type="text/javascript">
            $('#crf_form').parsley();
        </script>
	@endif
@stop
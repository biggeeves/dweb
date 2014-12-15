@extends('layout')
@section('content')
    <h2>{{$tableName}}  Generic Table Schema View</h2>
	<h3>You're viewing the schema for {{$tableName}}</h3>
    <table class="table table-striped table-bordered table-hover">
        <tr>
            @foreach( $schemaColumn as $tableColumnName )
                <th>{{{$tableColumnName}}}</th>
            @endforeach
        </tr>
        @foreach ($varLine as $short )
            <tr>
                @foreach ($short as $key=>$value)
                    <td>{{$value}}</td>
                @endforeach
            </tr>
        @endforeach
    </table>
        
@stop
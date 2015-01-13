@extends('layout')
@section('content')
    <h2>{{$tableLabel}}  Generic Table Schema View</h2>
    
    <table class="table table-striped table-bordered table-hover">
        <tr>
            @foreach( $columnNames as $eachColumn )
                <th>{{{$eachColumn}}}</th>
            @endforeach
        </tr>
        @foreach ($varTable as $row)
           <tr>
                @foreach ($row as $key=>$value)
                    <td>
                        @if ($key == 'id') 
                            <a href="/dcc/public/var_schema/{{$crf}}/{{$value}}">
                        @endif
                        {{$value}}
                        @if ($key == 'id') 
                            </a>
                        @endif
                        
                    </td>
                @endforeach
            </tr>
        @endforeach
    </table>   
@stop
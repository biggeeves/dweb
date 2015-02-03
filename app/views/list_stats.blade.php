@extends('layout')
@section('content')
    <h2>List Stats</h2>

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
    @foreach($tableCounts as $tableName=>$tableCount)
        @if($tableCount > 0)
            <p><a href="{{URL::route('showForm', array('value'=>$tableName))}}">{{$tableName}}</a>:{{$tableCount}}</p>
        @else
            <p>{{$tableName}}:{{$tableCount}}</p>
        @endif
    @endforeach
@stop
@extends('layout')
@section('content')
    <h2>Primary Keys</h2>

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

    @foreach ($tableInfo as $tableRow)
        <a href="{{URL::route('crfSchema', array('value'=>$tableRow[0]->Table))}}">{{$tableRow[0]->Table}}</a>
        <ul>
        @foreach ($tableRow as $singleValue)
            <li>{{$singleValue->Column_name}} </li>
        @endforeach
        </ul>
    @endforeach
@stop
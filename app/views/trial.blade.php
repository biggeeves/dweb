@extends('layout')
@section('content')
    @foreach( $trials as $trial )
        <p>{{ $trial->id_num }}</p>
	@endforeach
	
	{{ Form::open(array('url' => url('crud'), 'class'=>'form-horizontal', 'id'=>'frmFoo', 'style'=>'border:solid gray 1px')) }}
	{{Form::close()}}


{{ Form::model($trial) }}
    <div>
        {{ Form::label('id_num', 'ID:') }}
        {{ Form::text('id_num') }}
    </div>
 
    <div>
        {{ Form::label('slname', 'Subjects last name:') }}
        {{ Form::textarea('slname') }}
    </div>
	<div>
		{{Form::selectRange('number', 10, 20)}}
	</div>
	{{Form::selectMonth('month')}}
	<br />
	{{Form::select('size', array('L' => 'Large', 'S' => 'Small'))}}
	{{Form::select('size', array('L' => 'Large', 'S' => 'Small'), 'S')}}
	<br />

	{{Form::select('animal', array(
		'Cats' => array('leopard' => 'Leopard'),
		'Dogs' => array('spaniel' => 'Spaniel'),
	))}}
	<br />
	{{Form::number('mynumber', 'value');}}
	<br />
	
	{{Form::checkbox('mycheckbox', 'value')}}
	<br />
	{{Form::radio('myradio', 'value')}}
	<br />
Generating A Checkbox Or Radio Input That Is Checked
	<br />
	{{Form::checkbox('checked', 'value', true)}}
	<br />

	{{Form::radio('radiomarked', 'value', true)}}
	<br />
	{{Form::password('password')}}
	<br />
	Default Inputs {{Form::text('email', 'example@gmail.com')}}
	


{{ Form::close() }}

	
@stop
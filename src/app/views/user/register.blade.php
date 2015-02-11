@extends('layouts.master')
<title>Registro</title>
@section('content')

<div class="col-md-8 col-md-offset-2">

@if ($errors->any())
  <div class="alert alert-danger">
    {{ implode('', $errors->all('<p class="error">:message</p>')) }}
  </div>
@endif

  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title">
        <strong>Registro</strong>
      </h3>
    </div>

    <div class="panel-body">
      {{ Form::open(array('role' => 'form')) }}
        <div class="form-group">
          {{Form::label('email', 'E-mail')}}
          {{Form::email('email', null, array('class' => 'form-control', 'required'))}}
        </div>

        <div class="form-group">
          {{Form::label('password', 'Contraseña')}} <small>(8 caracteres mínimo)</small> 
          {{Form::password('password', array('class' => 'form-control', 'pattern' => '.{8,}', 'placeholder' => '', 'required'))}}
        </div>

        <div class="form-group">
          {{Form::label('password_confirmation', 'Repetir contraseña')}} 
          {{Form::password('password_confirmation', array('class' => 'form-control', 'pattern' => '.{8,}', 'placeholder' => '', 'required'))}}
        </div> 

        <div class="form-group">
          {{Form::label('first_name', 'Nombre')}} 
          {{Form::text('first_name', null, array('class' => 'form-control', 'placeholder' => '', 'required'))}}
        </div>

        <div class="form-group">
          {{Form::label('last_name', 'Apellido')}} 
          {{Form::text('last_name', null, array('class' => 'form-control', 'placeholder' => '', 'required'))}}
        </div>

          {{Form::submit('Registrarme', array('class' => 'btn btn-default'))}}

      {{ Form::close() }}
    </div>
  </div>
</div>
@stop
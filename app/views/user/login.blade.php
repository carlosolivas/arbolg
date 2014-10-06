@extends('layouts.master')

<title>Ingreso</title>

@section('content')

@if (!isset($email)) 
  {{ $email = '' }}
@endif

<div class="col-md-4 col-md-offset-4">

@if ($errors->any())
  <div class="alert alert-danger">
    {{ implode('', $errors->all('<p class="error">:message</p>')) }}
  </div>
@endif

@if (Session::has('message'))
  <div class="alert alert-success">
    <p class="success">{{ Session::get('message') }}</p>
  </div>
@endif

  <div class="panel panel-default center-box">
    <div class="panel-heading">
      <h3 class="panel-title">
        <strong>Ingreso</strong>
      </h3>
    </div>

    <div class="panel-body">
      {{ Form::open(array('role' => 'form')) }}
        <div class="form-group">
          {{Form::label('email', 'E-mail')}}
          {{Form::email('email', $email, array('class' => 'form-control', 'required'))}}
        </div>

        <div class="form-group">
          {{Form::label('password', 'Contraseña')}} 
          {{Form::password('password', array('class' => 'form-control', 'placeholder' => '', 'required'))}}
        </div>
          {{Form::submit('Ingresar', array('class' => 'btn btn-default btn-success full-size-btn'))}}
       
      {{ Form::close() }}
    </div>
    <div class="panel-body">
      <div class="row">
          <div class="col-md-6">
           <a class="btn btn-default btn-sm " href="/register">Registrarme</a>
        </div>
         <div class="col-md-6">          
          <a class="btn btn-default btn-sm " href="#">Olvidé la contraseña</a>
        </div>
        </div>
    </div>
  </div>
</div>
@stop
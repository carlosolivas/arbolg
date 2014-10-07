@extends('layouts.master-backend')
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
        <strong>Nueva persona</strong>
      </h3>
    </div>

    <div class="panel-body">
      {{ Form::open(array('role' => 'form')) }}
        <div class="form-group">
          {{Form::label('name', Lang::get('titles.name'))}}
          {{Form::text('name', null, array('class' => 'form-control', 'required'))}}
        </div>

        <div class="form-group">
          {{Form::label('lastName', Lang::get('titles.lastName'))}} 
          {{Form::text('lastName',null, array('class' => 'form-control', 'required'))}}
        </div>

        <div class="form-group">
          {{Form::label('mothersMaidenName', Lang::get('titles.mothersMaidenName'))}} 
          {{Form::text('mothersMaidenName', null, array('class' => 'form-control'))}}
        </div>

        <div class="form-group">
          {{Form::label('gender', Lang::get('titles.gender'))}} 
          {{Form::select('gender', array(
          'M' => Lang::get('titles.male'), 
          'F' => Lang::get('titles.female')), 
          'M') }}
        </div>

        <div class="form-group">
          {{Form::label('dateOfBirth', Lang::get('titles.dateOfBirth'))}} 
          {{Form::text('dateOfBirth', null, array('class' => 'form-control datepicker'))}}
        </div>

         <div class="form-group">
          {{Form::label('email', Lang::get('titles.email'))}} 
          {{Form::email('email', null, array('class' => 'form-control'))}}
        </div>

          {{Form::submit('Crear', array('class' => 'btn btn-default'))}}

      {{ Form::close() }}
    </div>
  </div>
</div>
@stop
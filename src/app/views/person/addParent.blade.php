@extends('layouts.template')
<title>Agregar hijo-padre</title>
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
        <strong>Nueva relación hijo-padre</strong>
      </h3>
    </div>

    <div class="panel-body">
      {{ Form::open(array('role' => 'form')) }}

        <div class="form-group">
          {{Form::label('son', Lang::get('titles.son'))}}
          {{Form::text('son', null, array('class' => 'form-control', 'required'))}}
        </div>

        <div class="form-group">
          {{Form::label('parent', Lang::get('titles.parent'))}}
          {{Form::text('parent', null, array('class' => 'form-control', 'required'))}}
        </div>

        {{Form::submit('Crear relación hijo-padre', array('class' => 'btn btn-default'))}}

      {{ Form::close() }}
    </div>
  </div>
</div>

@stop
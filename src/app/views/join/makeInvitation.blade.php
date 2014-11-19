@extends('layouts.template')
<title>{{{Lang::get("titles.invitation")}}}</title>
@section('content')

<div class="col-md-8 col-md-offset-2">

  <div class="panel panel-default">
    <div class="panel-heading">
    </div>

    <div class="panel-body">
      {{ Form::open(array('role' => 'form')) }}        

        <div class="form-group">
          {{Form::label('connection', Lang::get('titles.connectionPoint'))}} 
          	<select class="form-control m-b" required>
			    @foreach($connectionNodes as $person)
			    	<option value="{{ $person->id }} ">
              {{ $person->name }} {{ $person->lastname }} {{ $person->mothersname }}
            </option>
			    @endforeach
			</select>
        </div>

         <div class="form-group">
          {{Form::label('email', Lang::get('titles.email'))}} 
          {{Form::email('email', null, array('class' => 'form-control', 'required' => 'required'))}}
        </div>

          {{Form::submit(Lang::get('titles.sendInvitation'), 
          	array('class' => 'btn btn-primary'))}}

          <a href="/tree" class="btn btn-success">{{{Lang::get('titles.cancel')}}}</a>

      {{ Form::close() }}
    </div>
  </div>
</div>

@stop
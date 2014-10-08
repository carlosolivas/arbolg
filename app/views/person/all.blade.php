@extends('layouts.master-backend')
<title>Todas las personas</title>
@section('content')

<table class="table">
	<thead>
  <tr>
  	<th>Nombre</th>
  	<th>Apellido paterno</th>
  	<th>Apellido materno</th>
  	<th>Género</th>
  	<th>Fallecido?</th>
  	<th>Fecha de Nacimiento</th>
  	<th>Lugar de Nacimiento</th>
  	<th>País</th>
  	<th>Email</th>
  	<th>Biografía</th>
  	<th>Hermanos</th>
  </tr>
</thead>

<tbody>
@foreach ($persons as $person)
    <tr>
  	<td>{{ $person->name }}</td>
  	<td>{{ $person->lastName }}</td>
  	<td>{{ $person->mothersMaidenName }}</td>
  	<td>{{ $person->gender == 'M' ? Lang::get('titles.male') : Lang::get('titles.female')}}</td>
  	<td>{{ $person->isDeceased ? 'Si' : 'No' }}</td>
  	<td>{{ $person->dateOfBirth }}</td>
  	<td>{{ $person->placeOfBirth }}</td>
  	<td>{{ $person->country }}</td>
  	<td>{{ $person->email }}</td>
  	<td>{{ $person->biography }}</td>
  	<td>
  		@foreach ($person->brothers as $brother)
  			{{$brother->name}}
  		@endforeach
  	</td>
  </tr>
@endforeach
</tbody>
</table>

@stop
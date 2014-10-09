@extends('layouts.template')
<title>Arbol</title>
@section('content')

<h2>Padres</h2>
<a href='/addParent' class='btn btn-success btn-sm'>Agregar</a>
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
  </tr>
</thead>

<tbody>
@foreach ($person->parents as $parent)
    <tr>
  	<td>{{ $parent->name }}</td>
  	<td>{{ $parent->lastName }}</td>
  	<td>{{ $parent->mothersMaidenName }}</td>
  	<td>{{ $parent->gender == 'M' ? Lang::get('titles.male') : Lang::get('titles.female')}}</td>
  	<td>{{ $parent->isDeceased ? 'Si' : 'No' }}</td>
  	<td>{{ $parent->dateOfBirth }}</td>
  	<td>{{ $parent->placeOfBirth }}</td>
  	<td>{{ $parent->country }}</td>
  	<td>{{ $parent->email }}</td>
  	<td>{{ $parent->biography }}</td>
  </tr>
@endforeach
</tbody>
</table>

<h2>Hermanos</h2>
<a href='/addBrother' class='btn btn-success btn-sm'>Agregar</a>
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
  </tr>
</thead>

<tbody>
@foreach ($person->brothers as $brother)
    <tr>
    <td>{{ $brother->name }}</td>
    <td>{{ $brother->lastName }}</td>
    <td>{{ $brother->mothersMaidenName }}</td>
    <td>{{ $brother->gender == 'M' ? Lang::get('titles.male') : Lang::get('titles.female')}}</td>
    <td>{{ $brother->isDeceased ? 'Si' : 'No' }}</td>
    <td>{{ $brother->dateOfBirth }}</td>
    <td>{{ $brother->placeOfBirth }}</td>
    <td>{{ $brother->country }}</td>
    <td>{{ $brother->email }}</td>
    <td>{{ $brother->biography }}</td>
  </tr>
@endforeach
</tbody>
</table>

@stop
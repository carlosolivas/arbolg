@extends('layouts.template')
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
  	<th>Padres</th>
    <th>Hijos</th>
  </tr>
</thead>

<tbody>  
    @foreach ($persons as $person)
    <tr>
    <td>{{ $person->name() }}</td>
    <td>{{ $person->lastName() }}</td>
    <td>{{ $person->mothersMaidenName() }}</td>
    <td>{{ $person->gender() == 'M' ? Lang::get('titles.male') : Lang::get('titles.female')}}</td>
    <td>{{ $person->isDeceased() ? 'Si' : 'No' }}</td>
    <td>
      <!--@foreach ($person->parents() as $parent)
        <p>{{$parent->name}}</p>
      @endforeach-->
    </td>
    <td>
      <!--@foreach ($person->sons() as $son)
        <p>{{$son->name}}</p>
      @endforeach-->
    </td>
  </tr>
@endforeach
</tbody>
</table>
@stop
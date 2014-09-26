@extends('layouts.master')

@section('content')

@foreach ($users as $user)
	<li>  
		<b><p>{{ $user-> email }}</p></b>
		<p>{{ $user-> password }}</p>
		<p>{{ $user-> first_name}} {{ $user-> last_name }}</p>
	</li>
@endforeach



@stop
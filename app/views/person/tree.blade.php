@extends('layouts.template')
<title>Todas las personas</title>
 <!-- Tree script -->
<style>
#tree{
  height: 100%;
  width: 100%;
}
</style>
@section('content')
<div id='tree'>                            
</div>
<div id="menu-form" title='Menu'>
	<div id='menu-form-message'> </div>
</div>
{{ HTML::script('assets/js/page-scripts/tree.js'); }}
@stop


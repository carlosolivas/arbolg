@extends('layouts.template')
<title>Extender árbol</title>

<style>
  .toAssign { width: 100px; height: 100px; padding: 0.5em; float: left; margin: 10px 10px 10px 0; }
  #Connector { width: 150px; height: 150px; padding: 0.5em; float: left; margin: 10px; }  

  .ui-widget-header{
  	background: none !important;
  	color: gray !important;
	border: 3px solid #2f4050 !important;
  }

  .ui-widget-content{
  	background: none !important;
  	color: gray !important;
	border: 3px solid #2f4050 !important;
  }
</style>

@section('content')
<div id="panel" style="height: 100%; width: 100%" hidden= "true">

	<div class="row">
		<div class="col-xs-4"></div>
		<div class="col-xs-4" style="text-align:center">			
			<div id="connector" class="ui-widget-header" style="width: 100%" 
			personData={{{ $connectionNode['fullname'] }}}>
				<p>
					{{{ Lang::get('titles.dropHere') }}}									
				</p>			  
				<div>
					<h2>
						{{{ $connectionNode->name }}}
						{{{ $connectionNode->lastname }}} 
						{{{ $connectionNode->mothersname }}}
					</h2>
				</div>			
			</div>
		</div>
		<div class="col-xs-4"></div>
	</div>

	@foreach ($availablePersons as $person)
		<div class="ui-widget-content toAssign" id= {{{ $person['id'] }}} 
			personData= {{{ $person['fullname'] }}}>
	  		<h3>{{{ $person['fullname'] }}}</h3>
		</div>
	@endforeach
	
</div>


  	
<div id="sendRequestQuestion" hidden>{{{ Lang::get('titles.sendRequests') }}}</div>  	


{{ HTML::script('assets/js/page-scripts/extendTree.js'); }}
@stop
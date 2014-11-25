@extends('layouts.template')
<title>{{{Lang::get("titles.tree")}}}</title>

{{ HTML::style('assets/css/plugins/cytoscape/cytoscape.js-panzoom.css'); }}
{{ HTML::style('assets/css/plugins/cytoscape/style.css'); }}

@section('content')
<div id="readyToConnect">
	<div class="ui-widget-content toAssign" style="border: 3px solid #1ab394; text-align: center;">
	  		<p>{{{ Lang::get('titles.readyToConnect') }}}</p>
	</div>
	@foreach ($suggestedPersons as $person)
		<div class="ui-widget-content toAssign">
	  		<h4>{{{ $person['fullname'] }}}</h4>
		</div>
	@endforeach	
</div>
<div id='cy'>                            
</div>
<div id="menu-form" title='Menu' style="display: none">
		 
	 <div class="input-group m-b">
	    <span class="input-group-addon"><b> {{{ Lang::get('titles.name') }}}</b></span>			    
		<input type="text" id="personDetailName" class="form-control" disabled="true">
	</div>
	
	<div class="input-group m-b"> 
	    <span class="input-group-addon"><b>{{{ Lang::get('titles.lastName') }}}</b></span>
    	<input type="text" id="personDetailLastName" class="form-control" disabled="true">       
    </div>              
    
	<div class="input-group m-b"> 
	     <span class="input-group-addon"><b>{{{ Lang::get('titles.mothersMaidenName') }}}</b></span>  
    	<input type="text" id="personDetailMothersName" class="form-control" disabled="true">
    </div>

	<div class="input-group m-b"> 
	   <span class="input-group-addon"><b>{{{ Lang::get('titles.email') }}}</b></span>	  
    	<input type="text" id="personDetailEmail" class="form-control" disabled="true"> 
    </div>

	<div class="input-group m-b"> 
	    <span class="input-group-addon"><b>{{{ Lang::get('titles.birth') }}}</b></span>
	    	<div class="input-group">
	    		<input type="text" id="personDetailBirthDate" class="form-control datePicker" disabled="true"> 
	    	</div>	        
    </div>
	   
	<div class="input-group m-b"> 
	    <span class="input-group-addon"><b>Sexo</b></span>    
	    	<select id="personDetailGender" disabled="true" class="form-control m-b">
	    		<option value="1">{{{ Lang::get('titles.male') }}}</option>
	    		<option value="2">{{{ Lang::get('titles.female') }}}</option>
	    	</select>	        
    </div>   
	 
	<div class="input-group m-b"> 
	    <span class="input-group-addon"><b>{{{ Lang::get('titles.phone') }}}</b></span>    
	    <div class="col-lg-10">
	    	<input type="text" id="personDetailPhone" class="form-control" disabled="true">         
    	</div>  	
 	</div> 
 	
</div>

<div id="familiarDialog-form" title='Agregar padre' style="display: none">
	<div id='familiarDialog-form-message'>
		
			<input type="text" name="name" id="newPerson_name" class="form-control" 
			placeholder="Nombre">
	 
		  	<input type="text" name="lastname" id="newPerson_lastname" class="form-control" placeholder="Apellido*">  	      
		 
		  	<input type="text" name="mothersname" id="newPerson_mothersname" class="form-control" placeholder="Apellido materno">   

		 	<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				<input type="text" id="newPerson_dateOfBirth" class="form-control datePicker" placeholder="Fecha de Nacimiento"> 
			</div>  	
		      
			<select id="newPerson_gender" class="form-control">
				<option default disable value="">Sexo*</option>
				<option value="1">{{{ Lang::get('titles.male') }}}</option>
				<option value="2">{{{ Lang::get('titles.female') }}}</option>
			</select>	       

		  	<input type="text" name="phone" id="newPerson_phone" class="form-control" placeholder="Teléfono">   
		  	<span class="help-block m-b-none" id="validationBlockMessage">(*) Campos obligatorios</span> 	  	
			
	</div>
</div>

<div id="extendTree-form" title= {{{ Lang::get('titles.suggesteds') }}} style="display: none">
		
</div>


<!-- Modal for sent request -->
<div class="modal fade" id="sentRequestsModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">{{{ Lang::get('titles.sentRequests') }}}</h4>
      </div>
      <div class="modal-body">
      	@if ($sentRequests == null || $sentRequests->count() == 0)
      		<div style="text-align: center">
      			<h2>{{{ Lang::get('titles.noSentRequests') }}}</h2>
      		</div>
      	@endif
      	@if ($sentRequests != null && $sentRequests->count() > 0)
	        @foreach ($sentRequests as $request)
				<div class="ui-widget-content toAssign">
			  		<h4>{{{ $request['person'] }}}</h4>
				</div>
			@endforeach	
		@endif
      </div>
    </div>
  </div>
</div>

{{ HTML::script('assets/js/page-scripts/dagre.js'); }}
{{ HTML::script('assets/js/page-scripts/cytoscape.js-panzoom.js'); }}
{{ HTML::script('assets/js/page-scripts/tree.js'); }}
{{ HTML::script('assets/js/page-scripts/arbolizr.js'); }}
@stop


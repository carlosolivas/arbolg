@extends('layouts.template')
<title>Árbol genealógico</title>
 <!-- Tree script -->
<style>

	#requests{
	  height: 20%;
	  border: 3px solid #2f4050 !important;
	}
	#tree{
	  height: 100%;
	  width: 100%;
	}

	.connectWithSuggested{
		 border: 3px solid #2f4050;
		 width: 100px; height: 100px; padding: 0.5em; float: left; margin: 10px 10px 10px 10px;
	}
	.toAssign { width: 100px; height: 100px; padding: 0.5em; float: left; margin: 10px 10px 10px 10px; }

  	.ui-widget-header{
	  	background: none !important;
	  	color: gray !important;
		border: 3px solid #2f4050 !important;
  	}

  .ui-widget-content{
	  	background: white !important;
	  	color: gray !important;
		border: 3px solid #2f4050 !important;
  }
  .closebtn{
  	margin-left: 99% !important;
  }
</style>
@section('content')
<div id="requests">
	@foreach ($suggestedPersons as $person)
		<div class="ui-widget-content toAssign onHoverShow" personData= {{{ $person['fullname'] }}}>
	  		<h4>{{{ $person['fullname'] }}}</h4>
	  		<button class="btn btn-primary btn-xs" type="button" style="display: none" 
	  		id= {{{ $person['id'] }}} >
	  			<strong>{{{ Lang::get('titles.accept') }}}</strong>
	  		</button>
		</div>
	@endforeach	
	<button class="btn btn-warning btn-circle closebtn" type="button" id="closeSuggesteds"><i class="fa fa-times"></i></button>
</div>
<div id='tree'>                            
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
{{ HTML::script('assets/js/page-scripts/tree.js'); }}
@stop


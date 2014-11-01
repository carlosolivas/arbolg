@extends('layouts.template')
<title>Árbol genealógico</title>
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
<div id="menu-form" title='Menu' style="display: none">
		 
	 <div class="input-group m-b">
	    <span class="input-group-addon"><b>Nombre</b></span>			    
		<input type="text" id="personDetailName" class="form-control" disabled="true">
	</div>
	
	<div class="input-group m-b"> 
	    <span class="input-group-addon"><b>Apellido</b></span>
    	<input type="text" id="personDetailLastName" class="form-control" disabled="true">       
    </div>              
    
	<div class="input-group m-b"> 
	     <span class="input-group-addon"><b>Apellido materno</b></span>		    
    	<input type="text" id="personDetailMothersName" class="form-control" disabled="true">
    </div>

	<div class="input-group m-b"> 
	   <span class="input-group-addon"><b>Email</b></span>		   
    	<input type="text" id="personDetailEmail" class="form-control" disabled="true"> 
    </div>

	<div class="input-group m-b"> 
	    <span class="input-group-addon"><b>Nació</b></span>
	    	<div class="input-group">
	    		<input type="text" id="personDetailBirthDate" class="form-control datePicker" disabled="true"> 
	    	</div>	        
    </div>
	   
	<div class="input-group m-b"> 
	    <span class="input-group-addon"><b>Sexo</b></span>    
	    	<select id="personDetailGender" disabled="true" class="form-control m-b">
	    		<option value="1">Masculino</option>
	    		<option value="2">Femenino</option>
	    	</select>	        
    </div>   
	 
	<div class="input-group m-b"> 
	    <span class="input-group-addon"><b>Teléfono</b></span>    
	    <div class="col-lg-10">
	    	<input type="text" id="personDetailPhone" class="form-control" disabled="true">         
    	</div>  	
 	</div> 
 	
</div>

<div id="addDirectFamiliarDialog-form" title='Agregar padre' style="display: none">
	<div id='addDirectFamiliarDialog-form-message'>
		
			<input type="text" name="name" id="newPerson_name" class="form-control" placeholder="Nombre*">
	 
		  	<input type="text" name="lastname" id="newPerson_lastname" class="form-control" placeholder="Apellido*">  	      
		 
		  	<input type="text" name="mothersname" id="newPerson_mothersname" class="form-control" placeholder="Apellido materno">   

		 	<div class="input-group">
				<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				<input type="text" id="newPerson_dateOfBirth" class="form-control datePicker" placeholder="Fecha de Nacimiento"> 
			</div>  	
		      
			<select id="newPerson_gender" class="form-control">
				<option default disable value="">Sexo*</option>
				<option value="1">Masculino</option>
				<option value="2">Femenino</option>
			</select>	       

		  	<input type="text" name="phone" id="newPerson_phone" class="form-control" placeholder="Teléfono">   
		  	<span class="help-block m-b-none" id="validationBlockMessage">(*) Campos obligatorios</span> 	  	
			
	</div>
</div>
{{ HTML::script('assets/js/page-scripts/tree.js'); }}
@stop


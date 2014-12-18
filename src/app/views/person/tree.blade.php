@extends('layouts.template')
<title>{{{Lang::get("titles.tree")}}}</title>

{{ HTML::style('assets/css/plugins/cytoscape/cytoscape.js-panzoom.css'); }}
{{ HTML::style('assets/css/plugins/cytoscape/style.css'); }}

@section('content')
<nav id="menuBar" class="navbar navbar-static-top " role="navigation">
	<div class="navbar-header" style="margin-bottom: 20px">
		<h1>{{{ Lang::get('titles.tree') }}}</h1>
		<label>Inicio |</label><label>Datos |</label><label>Ingresar</label>
	</div>
		<ul class="nav navbar-top-links navbar-right" style="margin-top: 20px;">
				<li>
						 <h5><span class="glyphicon glyphicon-inbox"></span> {{{ Lang::get('titles.requestStatus') }}}</h5>
				</li>
				<li>
					{{ Form::open(array('url' => '/#', 'method' => 'get')) }}
								<button type="submit" class="btn btn-w-m btn-primary">
										{{{ Lang::get('titles.sent') }}}
								</button>
					{{ Form::close() }}
				</li>
				<li>
					{{ Form::open(array('url' => '/#', 'method' => 'get')) }}
								<button type="submit" class="btn btn-w-m btn-warning">
										{{{ Lang::get('titles.inConfirmation') }}}
								</button>
					{{ Form::close() }}
				</li>
				<li>
					{{ Form::open(array('url' => '/#', 'method' => 'get')) }}
								<button type="submit" class="btn btn-w-m btn-success">
										{{{ Lang::get('titles.accepted') }}}
								</button>
					{{ Form::close() }}
				</li>
		</ul>
</nav>
 <nav id="menuBarBottomBar" class="navbar navbar-static-top  menuBarBottomBarItem" role="navigation" style="margin-bottom: 0">
      <ul class="nav navbar-top-links row">
          <li class="col-xs-3">
              <a href="#"><span class="fa fa-plus-square-o"></span></i> {{ Lang::get('titles.create') }}</a>
          </li>
          <li class="col-xs-3">
              <a href="#"><span class="fa fa-calendar-o"></span> {{ Lang::get('titles.events') }}</a>
          </li>
					<li class="col-xs-3">
						<a href="#"><span class="fa fa-picture-o"></span> {{ Lang::get('titles.photoGallery') }}</a>
				  </li>
					<li class="col-xs-3" style="margin-right: 0px">
						<a href="#"><span class="fa fa-users"></span> {{ Lang::get('titles.invite') }}</a>
					</li>
      </ul>
</nav>

<div id='cy'>
</div>

<div id="menu-form" class="form-horizontal" title='Menu' style="display: none">

	<div class="form-group">
		<label class="col-xs-3 control-label">
			{{ Lang::get('titles.name') }}
		</label>
    	<div class="col-xs-8">
    		<input type="text" id="personDetailName" class="form-control" disabled="true">
    	</div>
	</div>

	<div class="form-group">
		<label class="col-xs-3 control-label">{{ Lang::get('titles.lastName') }}
		</label>
    	<div class="col-xs-8">
    		<input type="text" id="personDetailLastName" class="form-control" disabled="true">
    	</div>
	</div>	

	<div class="form-group">
		<label  class="col-xs-3 control-label">{{ Lang::get('titles.mothersMaidenName') }}
		</label>
    	<div class="col-xs-8">
    		<input type="text" id="personDetailMothersName" class="form-control" disabled="true">
    	</div>
	</div>	

	<div class="form-group">
		<label class="col-xs-3 control-label">{{ Lang::get('titles.email') }}
		</label>
    	<div class="col-xs-8">
    		<input type="text" id="personDetailEmail" class="form-control" disabled="true">
    	</div>
	</div>

	<div class="form-group">
		<label class="col-xs-3 control-label">{{ Lang::get('titles.birth') }}
		</label>
    	<div class="col-xs-8">
    		<input type="text" id="personDetailBirthDate" class="form-control" disabled="true">
    	</div>
	</div>

	<div class="form-group">
		<label class="col-xs-3 control-label">{{ Lang::get('titles.sex') }}
		</label>
    	<div class="col-xs-8">
    		<select id="personDetailGender" disabled="true" class="form-control m-b">
	    		<option value="1">{{{ Lang::get('titles.male') }}}</option>
	    		<option value="2">{{{ Lang::get('titles.female') }}}</option>
	    	</select>
    	</div>
	</div>
	
	<div class="form-group">
		<label class="col-xs-3 control-label">{{ Lang::get('titles.phone') }}
		</label>
    	<div class="col-xs-8">
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

		  	<input type="email" name="email" id="newPerson_email" class="form-control" placeholder="Email">

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

<div id="extendTree-form" style="display: none">	
	<div id="extendTreeBody"></div>	
</div>

{{ HTML::script('assets/js/page-scripts/dagre.js'); }}
{{ HTML::script('assets/js/page-scripts/cytoscape.js-panzoom.js'); }}
{{ HTML::script('assets/js/page-scripts/tree.js'); }}
{{ HTML::script('assets/js/page-scripts/arbolizr.js'); }}
@stop

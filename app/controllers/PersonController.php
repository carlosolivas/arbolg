<?php

use App\Models\viewModels\Person;

class PersonController extends BaseController
{
	/* Artificial login */
	public function login()
	{
		if (!Session::has('userLogged'))
		{
		    Session::put('userLogged', 'Bart');
		}

		Session::put('userLogged', 'Marge');
		
		return Redirect::to('/tree');
	}
	public function get_all()
	{
		return $this->get('Person')->findAll();	
	}
	public function get_tree()
	{
		
		return View::make('person.tree');
	}

	public function get_loadTreePersons()
	{
		/* Session */
		$userIdentifier = Session::get('userLogged');

		$family = $this->get('Person')->getAscendingFamily($userIdentifier);	
		$descendingFamily = $this->get('Person')->getDescendingFamily($userIdentifier);	

		/* Remove the first element because are the duplicated of the root (already was included in $family) */
		array_shift($descendingFamily);
		
		/* Add the descending family to the complete array of family */
		foreach ($descendingFamily as $descending) {
			$family[] = $descending;
		}	

		$nodes = array();
		foreach ($family as $person) {	
			$personId = (string)$person->id;
			$personName = $person->name;
			$dataOfPerson = array("id" => $personId, "name" => $personName);
			$data = array('data' => $dataOfPerson);
			array_push($nodes, $data);
		}
		
		return Response::json( $nodes );		
	}

	public function get_loadTreeRelations()
	{
		/* Session */
		$userIdentifier = Session::get('userLogged');

		$family = $this->get('Person')->getAscendingFamily($userIdentifier);	
		$descendingFamily = $this->get('Person')->getDescendingFamily($userIdentifier);	

		/* Remove the first element because are the duplicated of the root (already was included in $family) */
		array_shift($descendingFamily);
		
		/* Add the descending family to the complete array of family */
		foreach ($descendingFamily as $descending) {
			$family[] = $descending;
		}	

		$relations = array();
		foreach ($family as $person) {
			
			foreach ($person->parents as $parent) {	
				// Source is the parent of person					
				$source = (string)$parent->id;

				// Target is the person 
				$target = (string)$person->id;

				$dataParOfRelations = array("source" => $source, "target" => $target);
				$data = array("data" => $dataParOfRelations);

				array_push($relations, $data);
			}
		}

		return Response::json( $relations );	
	}


	public function get_create()
	{
		return View::make('person.create');
	}

	public function post_create()
	{
		try {
			$this->get('Person')->create(Input::all());
		}		
		catch(App\Exceptions\ValidationException $e){
			return Redirect::to('/create')
                ->withErrors($e->getValidationErrors());
		}
		 catch (Exception $e) {
			return Redirect::to('/create')
			->withErrors((new Illuminate\Support\MessageBag)
                ->add('error', $e->getMessage()));
		}

		return Redirect::to('/tree');
	}

	public function get_addParent()
	{
		return View::make('person.addParent');
	}

	public function post_addParent()
	{
		$son = Input::get('son');
		$parent = Input::get('parent');

		$this->get('Person')->addParent($son, $parent);

		return Redirect::to('/tree');
	}
}
<?php

use App\Models\viewModels\Person;

class PersonController extends BaseController
{
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
		$allPersons = $this->get('Person')->findAll();	

		$nodes = array();
		foreach ($allPersons as $person) {	
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
		$allPersons = $this->get('Person')->findAll();	

		$relations = array();
		foreach ($allPersons as $person) {
			
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

	public function get_familyTree()
	{
		$user = $this->get('Person')->findPersonByName(Session::get('User'));

		return View::make('person.familyTree')->with('person', $user);
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
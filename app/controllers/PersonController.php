<?php

use App\Models\viewModels\Person;

class PersonController extends BaseController
{
	public function get_all()
	{

		$allPersons = $this->get('Person')->findAll();		
		$persons = array();

		foreach ($allPersons as $personItem) {
			$person = new Person();
			$person->name($personItem->name);
			$person->lastName($personItem->lastName);
			$person->mothersMaidenName($personItem->mothersMaidenName);
			$person->gender($personItem->gender);
			$person->isDeceased($personItem->isDeceased);
			$person->placeOfBirth($personItem->placeOfBirth);
			$person->country($personItem->country);
			$person->email($personItem->email);
			$person->biography($personItem->biography);

			$person->parents($personItem->parents);
			
			$person->sons($this->get('Person')->getSons($personItem->name));

			array_push($persons,$person);
		}

		return View::make('person.all')->with('persons',$persons);
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

		return Redirect::to('/allPersons');
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

		return Redirect::to('/allPersons');
	}
}
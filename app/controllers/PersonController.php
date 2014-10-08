<?php

class PersonController extends BaseController
{
	public function get_all()
	{

		$persons = $this->get('Person')->findAll();

		foreach ($persons as $person) {
					$brothers = $person->brothers;
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
		
	}

	public function get_createRelation()
	{
		$persons = $this->get('Person')->findAll();

		foreach ($persons as $person) {
			if ($person->name == 'Federico') {

				$federico = $person;

				foreach ($persons as $person2) {
					if ($person2->name == 'Julian') {

						$julian = $person2;
						$federico->brothers()->detach($julian);
						/*$federico->brothers()->save($julian);*/
					}
				}
			}
		}
	}
}
<?php

class PersonController extends BaseController
{
	public function get_allPersons()
	{
		$persons = $this->get('Person')->findAllPersons();

		return View::make('person.allPersons')->with('persons',$persons);
	}
}
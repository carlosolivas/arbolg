<?php

use s4h\core\PersonRepositoryInterface;

class PersonController extends BaseController
{
	protected $personRepository;

	public function __construct(PersonRepositoryInterface $personRepository) 
	{
        $this->personRepository = $personRepository;
	}

	/*public function get_all()
	{
		return $this->get('NodePerson')->findAll();	
	}*/

	public function get_tree()
	{

		$person = Auth::user()->Person;
		/* Check if the NodePerson for this user wasn´t created yet */
		if (!($this->get('NodePerson')->nodePersonExists($person->id))) {

			/* Create the NodePerson for this user */
			$this->get('NodePerson')->create($person->id,$person->id);			
		}


		return View::make('person.tree');
	}

	/**
     * Get the family of Person
     * @return Node Persons   
     */  
	public function get_loadTreePersons()
	{
		$user = Auth::user();		
		$personLogged = $user->Person->id;
		$family = $this->get('NodePerson')->getFamily($personLogged);
		$nodes = array();
		foreach ($family as $nodePerson) {	

			$person = $this->personRepository->getById($nodePerson->personId);

			$personId = (string)$person->id;
			$dataOfPerson = array(
				"id" 			=> $personId, 
				"name" 			=> $person->name, 
				"lastname" 		=> $person->lastname,
				"mothersname" 	=> $person->mothersname,
				"email" 		=> $person->email,				
				"birthdate"	 	=> $person->date_of_birth,
				"gender"		=> $person->sex,
				"phone"			=> $person->cellphone,
				"fullname"		=> $person->name . " " . $person->lastname . " " . $person->mothersname
				);

			$data = array('data' => $dataOfPerson);
			array_push($nodes, $data);
		}
		
		return Response::json( $nodes );		
	}

	/**
     * Get the relations between the Person's familiars
     * @return Node Persons   
     */ 
	public function get_loadTreeRelations()
	{
		$user = Auth::user();		
		$personLogged = $user->id;
		$family = $this->get('NodePerson')->getFamily($personLogged);

		$relations = array();
		foreach ($family as $person) {			

			foreach ($person->parents as $nodeParent) {	

				$parent = $this->personRepository->getById($nodeParent->personId);

				// Source is the parent of person					
				$source = (string)$parent->id;

				// Target is the person 
				$target = (string)$person->personId;

				$dataParOfRelations = array("source" => $source, "target" => $target);
				$data = array("data" => $dataParOfRelations);

				array_push($relations, $data);
			}
		}

		return Response::json( $relations );	
	}

	public function post_saveParent()
	{
		try {
			// Data of new Person
			$input = Input::all();
			$data = array(
				'name' 			=> $input['name'], 
				'lastname' 		=> $input['lastname'],
				'mothersname' 	=> $input['mothersname'],
				'birthdate' 	=> $input['dateOfBirth'],
				'gender' 		=> $input['gender'],
				'phone' 		=> $input['phone'],
				'email'		    => 'test@gmail.com',
				'user_id' 		=> null,
				'role_id' 		=> 1,
				'file_id'		=> null
			);		

			// Create a Person 
			$newPersonId =  $this->personRepository->store($data);

			// Create a NodePerson
			$user = Auth::user();
			$personLogged = $user->id;

			$this->get('NodePerson')->create($newPersonId, $personLogged);

			
			// Add new Person as parent
			$sonId = (int)$input['son'];
			$parentId = $newPersonId;

			$this->get('NodePerson')->addParent($sonId, $parentId);

		} catch (Exception $e) {
			return Response::json( false );
		}
		
		return Response::json( true );
	}
	
	public function get_create()
	{
		return View::make('person.create');
	}

	public function post_create()
	{
		try {
			$this->get('NodePerson')->create(Input::all());
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

		$this->get('NodePerson')->addParent($son, $parent);

		return Redirect::to('/tree');
	}
}
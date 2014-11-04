<?php

use s4h\core\PersonRepositoryInterface;

class PersonController extends BaseController
{
	protected $personRepository;

	/**
     * General constants
     */
 	const FATHER 	= 1;
    const MOTHER    = 2;
    const SON       = 3;

	public function __construct(PersonRepositoryInterface $personRepository) 
	{
        $this->personRepository = $personRepository;
	}


	/**
     * This function check if the Person exists already in the graph model
     * and create the view for the tree
     * @return Node Persons   
     */ 
	public function get_tree()
	{
		try {
			$person = Auth::user()->Person;

			/* Check if the NodePerson for this user wasn´t created yet */
			if (!($this->get('NodePerson')->nodePersonExists($person->id))) {

				/* Create the NodePerson for this user */
				$this->get('NodePerson')->create($person->id,$person->id);	

				/* Sort the familiars: first the parents and then the sons */
				$directFamiliars = array();

				/* First the parents */
				foreach ($person->getFamily()->Persons as $directFamiliar) {
					if ($directFamiliar->role_id == self::FATHER || $directFamiliar->role_id == self::MOTHER) {
						array_push($directFamiliars, $directFamiliar);
					}
				}

				/* Then the sons */
				foreach ($person->getFamily()->Persons as $directFamiliar) {
					if ($directFamiliar->role_id == self::SON) {
						array_push($directFamiliars, $directFamiliar);
					}
				}

				foreach ($directFamiliars as $directFamiliar) 
				{
					/* If is not the same Person who are logged */
					if ( $directFamiliar->id != $person->id) {

						/* Create the NodePerson for this direct familiar */
						$this->get('NodePerson')->create($directFamiliar->id,$directFamiliar->id);

						/* Now we check the role of the logged Person and we infer how relate it to
						the direct familiar */
						if ($person->role_id == self::FATHER || $person->role_id == self::MOTHER) {
							if ($directFamiliar->role_id == self::SON) {
								$sonId = $directFamiliar->id;
								$parentId = $person->id;

								/* Add as parent the logged Person */
								$this->get('NodePerson')->addParent($sonId, $parentId);

								/* Add as parent the coup of logged Person */
								$nodePersonLogged = $this->get('NodePerson')->findById($person->id);
								if ($nodePersonLogged->coup != null) {
									$this->get('NodePerson')->addParent($sonId, $nodePersonLogged->coup->personId);
								}
							}

							if ($directFamiliar->role_id == self::FATHER || $directFamiliar->role_id == self::MOTHER) {
								$coupId = $directFamiliar->id;
								/* Add as the coup the logged Person and vice versa */
								$this->get('NodePerson')->addCoup($person->id, $coupId);
								$this->get('NodePerson')->addCoup($directFamiliar->id, $person->id);
							}	
						}

						if ($person->role_id == self::SON) {
							if ($directFamiliar->role_id == self::FATHER || $directFamiliar->role_id == self::MOTHER) {
								$sonId = $person->id;
								$parentId = $directFamiliar->id;

								/* Add as son the logged Person */
								$this->get('NodePerson')->addParent($sonId, $parentId);

								/* Unite the parents if already have loaded 2 of them */
								if ($person->parents()->count() == 2) {
									foreach ($person->parents() as $parent) {
										foreach ($person->parents() as $otherParent) {
											if ($parent->personId != $otherParent->personId) {
												$this->get('NodePerson')->addCoup($parent->personId, $otherParent->personId);
											}
										}
									}								
								}
							}
							if ($directFamiliar->role_id == self::SON) {

								$sonId = $directFamiliar->id;

								foreach ($person->parents() as $parentOfLoggedPerson) {
									$parentId = $parentOfLoggedPerson->id;

									/* Add as parent the parent of logged person, and as son
									the current direct familiar */
									$this->get('NodePerson')->addParent($sonId, $parentId);
								}							
							}
						}									
					}
				}		
			}

			return View::make('person.tree');
			
		} catch (Exception $e) {
			return $e;
		}		
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

			// Check if can add more Parents
			$canAddParents = $this->get('NodePerson')->canAddParents($nodePerson);	

			// Set the root Node
			$isRootNode = false;		
			if ($nodePerson->personId == $personLogged) {
				$isRootNode = true;
			}

			$personId = (string)$person->id;
			$dataOfPerson = array(
				"id" 			=> $personId, 
				"name" 			=> $person->name, 
				"lastname" 		=> $person->lastname,
				"mothersname" 	=> $person->mothersname,
				"email" 		=> $person->email,				
				"birthdate"	 	=> $person->birthdate,
				"gender"		=> $person->gender,
				"phone"			=> $person->phone,
				"fullname"		=> $person->name . " " . $person->lastname . " " . $person->mothersname,
				"canAddParents"	=> $canAddParents,
				"isRootNode"	=> $isRootNode
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

	/**
     * This function creates a Person, a NodePerson and relate this NodePerson with 
     * the the corresponding son
     * @return Json   
     */ 
	public function post_saveParent()
	{
		try {

			// Data of new Person
			$input = Input::all();			
			
			// Converting the date of birth
			$timestamp = strtotime($input['dateOfBirth']); 
			$birthdate = date("Y-m-d H:i:s", $timestamp);

			$data = array(
				'name' 			=> $input['name'], 
				'lastname' 		=> $input['lastname'],
				'mothersname' 	=> $input['mothersname'],
				'birthdate' 	=> $birthdate,
				'gender' 		=> $input['gender'],
				'phone' 		=> $input['phone'],
				'email'		    => 'test@gmail.com',
				'user_id' 		=> null,
				'role_id' 		=> 1,
				'file_id'		=> null
			);	

		 	$rules = array(
			 	'name' => 'required',
	            'lastname' => 'required',
	            'gender' => 'required',
	            'birthdate' => 'date',
	            'phone' => 'numeric'
            );

			$validation = Validator::make($data, $rules);	

			// Check if son can add more Parents
			$sonId = (int)$input['son'];
			$son = $this->get('NodePerson')->findById($sonId);		

			if ($this->get('NodePerson')->canAddParents($son) && !($validation->fails())) {		
			
				// Create a Person 
				$newPersonId =  $this->personRepository->store($data);

				// Create a NodePerson
				$user = Auth::user();
				$personLogged = $user->Person->id;
				$this->get('NodePerson')->create($newPersonId, $personLogged);
				
				// Add new Person as parent
				$parentId = $newPersonId;
				$this->get('NodePerson')->addParent($sonId, $parentId);

				return Response::json( 'successful' );
			}		
			else {
				return Response::json( $validation->messages()->all('- :message -') );
			}

		} catch (Exception $e) {
			return Response::json( $e->getMessage() );
		}		
	}
}
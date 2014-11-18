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
     * @return View   
     */ 
	public function get_tree()
	{
		try {

			/* Suggesteds */
			
			$rootPerson = $this->personRepository->getById(8); // Milhouse
			$suggestedPersons = array();

			foreach ($rootPerson->getFamily()->Persons as $p) {
				$fullname = $p->name . " " . $p->lastname . " " . $p->mothersname;
				$personItem = array('id' => $p->id, 
					'fullname' => $fullname);

				$suggestedPersons[] = $personItem;
			}

			/**/
			

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

				/* The NodePerson of logged Person */
				$nodePersonLogged = $this->get('NodePerson')->findById($person->id);

				if ( $nodePersonLogged != null ) {				
				
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
									if ($nodePersonLogged->parents()->count() == 2) {
										foreach ($nodePersonLogged->parents as $parent) {
											foreach ($nodePersonLogged->parents as $otherParent) {
												if ($parent->personId != $otherParent->personId) {
													$this->get('NodePerson')->addCoup($parent->personId, $otherParent->personId);
												}
											}
										}								
									}
								}
								if ($directFamiliar->role_id == self::SON) {

									$sonId = $directFamiliar->id;

									foreach ($nodePersonLogged->parents as $parentOfLoggedPerson) {
										$parentId = $parentOfLoggedPerson->personId;

										/* Add as parent the parent of logged person, and as son
										the current direct familiar */
										$this->get('NodePerson')->addParent($sonId, $parentId);
									}							
								}
							}									
						}
					}	
				}	
			}

			return View::make('person.tree')->with('suggestedPersons', $suggestedPersons);
			
		} catch (Exception $e) {
			return Redirect::to('error')->with('error', $e);			
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
				"id" => $personId,
				"name" => $person->name,
				"lastname" => $person->lastname,
				"mothersname" => $person->mothersname,
				"email" => $person->email,
				"birthdate"	=> $person->birthdate,
				"gender"	=> $person->gender,
				"phone"	=> $person->phone,
				"fullname"	=> $person->name . " " . $person->lastname . " " . $person->mothersname,
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
		$personLogged = $user->Person->id;
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
     * @return Json with the request status
     */ 
	public function post_saveParent()
	{
		try {

			// Data of new Person
			$input = Input::all();			
			
			// Converting the date of birth
			$birthdate =  $this->formatDate($input['dateOfBirth']);

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

	/**
     * This function return the view and the corresponding options to send a tree extension request 
     * the the corresponding son
     * @param id The id of the connnection NodePerson from extends the tree
     * @return View
     */ 
	public function get_extendTree($id)
	{
		$connectionPerson = $this->personRepository->getById($id);

		/* Get the the avalable Persons to connect */
		/* Simulation of Van Houten  family are available*/
		$rootPerson = $this->personRepository->getById(8); // Milhouse
		$availablePersons = array();

		foreach ($rootPerson->getFamily()->Persons as $p) {
			$fullname = $p->name . " " . $p->lastname . " " . $p->mothersname;
			$personItem = array('id' => $p->id, 
				'fullname' => $fullname);

			$availablePersons[] = $personItem;
		}

		Session::put('connectionPersonId', $connectionPerson->id);

		return View::make('person.extendTree')->with("connectionNode" , $connectionPerson )->with("availablePersons", $availablePersons);
	}

	/**
     * The function wich manages the request
     * @param id The id of the NodePerson to connect
     * @return View
     */ 
	public function get_sendRequest($fromId, $toId)
	{
		if (is_string($fromId)) {
			$fromId = (int)$fromId;
		}

		if (is_string($toId)) {
			$toId = (int)$toId;
		}

		/*$connectionPersonId = (int)Session::get('connectionPersonId');*/
		$connectionPerson = $this->get('NodePerson')->findById($fromId);

		$nodePersonToConnect = $this->get('NodePerson')->findById($toId);

		/* Connect with Distribution module */

		/* Simulating  that the Person to connect discard his tree */

		/* Deleting parents */
		if ($nodePersonToConnect->parents != null) {
			foreach ($nodePersonToConnect->parents as $parent) {
				$this->get('NodePerson')->removeParent($nodePersonToConnect->personId, $parent->personId);
			}
		}		

		 /* Check if nodePersonToConnect has father and mothers  */

        $nodePersonToConnectHasFather = false;
        $nodePersonToConnectHasMother = false;
        if ($connectionPerson->parents != null) {
              foreach ($connectionPerson->parents as $parent) {
				$person = $this->personRepository->getById($parent->personId);

				if ($person != null && $person->gender == 1) {
					$nodePersonToConnectHasFather = true;
				}	
				
				if ($person != null && $person->gender == 2) {
					$nodePersonToConnectHasMother = true;
				}			
			}
        }

        // Logged Person
		$user = Auth::user();		
		$personLoggedId = $user->Person->id;	

        /* Create nodePersonToConnect parent's */
        if (!$nodePersonToConnectHasFather) {

        	/* Father creation */

            $father = array(
				'name' 			=> Lang::get('titles.addParent'), 
				'lastname' 		=> ' ',
				'mothersname' 	=> ' ',
				'birthdate' 	=> '',
				'gender' 		=> 1,
				'phone' 		=> '',
				'email'		    => '',
				'user_id' 		=> null,
				'role_id' 		=> 1,
				'file_id'		=> null
			);

			// Create a Person 
			$newPersonId =  $this->personRepository->store($father);

			// Create a NodePerson (the owner is the logged User)
			$this->get('NodePerson')->create($newPersonId, $personLoggedId);
			
			// Add new Person as parent
			$parentId = $newPersonId;
			$this->get('NodePerson')->addParent($connectionPerson->personId, $parentId);
		}

		if (!$nodePersonToConnectHasMother) {

			/* Mother creation */

			 $mother = array(
				'name' 			=> Lang::get('titles.addMother'), 
				'lastname' 		=> ' ',
				'mothersname' 	=> ' ',
				'birthdate' 	=> '',
				'gender' 		=> 2,
				'phone' 		=> '',
				'email'		    => '',
				'user_id' 		=> null,
				'role_id' 		=> 1,
				'file_id'		=> null
			);

			// Create a Person 
			$newPersonId =  $this->personRepository->store($mother);

			// Create a NodePerson (the owner is the logged User)
			$this->get('NodePerson')->create($newPersonId, $personLoggedId);
			
			// Add new Person as parent
			$parentId = $newPersonId;
			$this->get('NodePerson')->addParent($connectionPerson->personId, $parentId);
		}        

		// Get again nodePersonToConnect to update the relations
		$connectionPerson = $this->get('NodePerson')->findById($connectionPerson->personId);

		/* New parents */
		foreach ($connectionPerson->parents as $parent) {	

			$this->get('NodePerson')->addParent($nodePersonToConnect->personId, $parent->personId);
		}

		return Redirect::to('/tree');
	}


	/**
	* This function update the data of person
	* @return Json with the request status
	*/
	function post_updatePersonData()
	{
		try {

			// Logged Person
			$user = Auth::user();		
			$personLoggedId = $user->Person->id;

			// Data of new Person
			$input = Input::all();		

			$personId = (int)$input['id'];	

			$personToUpdateData = $this->get('NodePerson')->findById($personId);

			// Check if the Person exists and if the logged user can be edit it
			if ($personToUpdateData != null && $personToUpdateData->ownerId == $personLoggedId) {

				// Converting the date of birth
				$birthdate = $this->formatDate($input['dateOfBirth']);

				$data = array(
					'id'			=> $input['id'],
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

				if (!($validation->fails())) {		
			
					// Edition a Person 
					$this->personRepository->store($data);

					return Response::json( 'successful' );
				}		
				else {
					return Response::json( $validation->messages()->all('- :message -') );
				}
			} else{
				return Response::json( Lang::get('messages.cannotUpdateData') );
			}

		} catch (Exception $e) {
			return Response::json( $e->getMessage() );
		}		
	}

	/**
	* Tis function return the suggested persons to connect
	* @param id The id of the person to search suggested familiars
	* @return Json with suggested familiars
	*/
	public function get_loadSuggesteds($id)
	{
		/* Suggesteds */
			
			$rootPerson = $this->personRepository->getById(8); // Milhouse
			$suggestedPersons = array();

			foreach ($rootPerson->getFamily()->Persons as $p) {
				$fullname = $p->name . " " . $p->lastname . " " . $p->mothersname;
				$personItem = array('id' => $p->id, 
					'fullname' => $fullname);

				$suggestedPersons[] = $personItem;
			}

			/**/

			return Response::json($suggestedPersons);
	}

	/* Utilities */

	/**
     * The function wich manages the date format
     * @param date The date to format
     * @param toSpanishFormat Indicates if the return value must be in spanish format
     * @return Date
     */ 
	public function formatDate($date, $toSpanishFormat = false)
	{
		if ($toSpanishFormat) {
			$birthdate = date("d-m-Y", strtotime($date));
			$birthdate = str_replace('-', '/', $birthdate);

			return $birthdate;
		}

		$date = str_replace('/', '-', $date);
		$birthdate = date('Y-m-d', strtotime($date));	

		return $birthdate;
	}
}

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
		try
		{

			$suggestedPersons = array();
			$readyToConnectPersons = array();
			$sentRequests = array();

			/* Suggesteds (the people who accepted join)*/
				

			/**/


			$person = Auth::user()->Person;
			

			/* Check if the NodePerson for this user wasn´t created yet */
			if (!($this->get('NodePerson')->nodePersonExists($person->id))) {
				

				/* Create the NodePerson for this user */
				$this->get('NodePerson')->create($person->id,$person->id);

				if ($person->getFamily() == null) {
					
					return View::make('person.tree')->with('suggestedPersons', $suggestedPersons)
						->with('readyToConnectPersons', $readyToConnectPersons)->with('sentRequests', $sentRequests);

				}

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

			return View::make('person.tree')->with('suggestedPersons', $suggestedPersons)
			->with('readyToConnectPersons', $readyToConnectPersons)->with('sentRequests', $sentRequests);

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
			// Check if the logged person can update his data
			$canBeUpdatedByLoggedUser = $nodePerson->ownerId == $personLogged;

			$personId = (string)$person->id;
			$dataOfPerson = array(
				"id" => $personId,
				"name" => $person->name,
				"lastname" => $person->lastname,
				"mothersname" => $person->mothersname,
				"email" => $person->email,
				"birthdate"	=> $this->formatDate($person->birthdate, $toSpanishFormat = true),
				"gender"	=> $person->gender,
				"phone"	=> $person->phone,
				"fullname"	=> $person->name . " " . $person->lastname . " " . $person->mothersname,
				"canAddParents"	=> $canAddParents,
				"isRootNode"	=> $isRootNode,
				"canBeUpdatedByLoggedUser"	=> $canBeUpdatedByLoggedUser
			);

			$photo = array('background-image' => $person->Photo->fileURL,
					"background-fit" => 'cover');


			$data = array('data' => $dataOfPerson, 'css' => $photo);

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
				'email'		    => $input['email'],
				'user_id' 		=> null,
				'role_id' 		=> $input['gender'] == self::MOTHER ? self::MOTHER : self::FATHER,
				'file_id'		=> null
			);

		 	$rules = array(
			 	'name' => 'required',
	            'lastname' => 'required',
	            'gender' => 'required',
	            'birthdate' => 'date',
	            'phone' => 'numeric',
	            'email' => 'email'
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
					'email'		    => $input['email'],
					'user_id' 		=> null,
					'role_id' 		=> $input['gender'] == self::MOTHER ? self::MOTHER : self::FATHER,
					'file_id'		=> null
				);

			 	$rules = array(
				 	'name' => 'required',
		            'lastname' => 'required',
		            'gender' => 'required',
		            'birthdate' => 'date',
		            'phone' => 'numeric',
	            	'email' => 'email'
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
	 * This function laod the view to set photo
	 * @return View
	 */
	function get_setPhoto($id)
	{
		// Logged Person
		$user = Auth::user();
		$personLoggedId = $user->Person->id;

		if (is_string($id)) {
			$id = (int)$id;
		}

		$personToUpdatePhoto = $this->get('NodePerson')->findById($id);

		if ($personToUpdatePhoto == null || $personToUpdatePhoto->ownerId != $personLoggedId) {
			return Redirect::to('/tree');
		}

		$person = $this->personRepository->getById($id);
		Session::put('personIdPhotonEditing', $id);
		return View::make('person.photo')->with('person', $person);
	}

	/**
	* This function add the person photo
	*/
	function post_setPhoto()
	{
		$personId = Session::get('personIdPhotonEditing');
		$input = Input::all();

		$data = array(
			'id'			=> $personId,
			'photo'			=> $input['photo']
		);

		$this->personRepository->store($data);
		return Redirect::to('/tree');
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

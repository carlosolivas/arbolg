<?php
/**
* PersonController.php
*
* Handles the tree's people's interaction
*
*  @category Controllers
*  @author   Kiwing IT Solutions <info@kiwing.net>
*  @author   Federico Rossi <rossi.federico.e@gmail.com>
*
*/

use s4h\core\PersonRepositoryInterface;
use s4h\core\UserRepositoryInterface;
use s4h\social\GroupRepositoryInterface;

class PersonController extends BaseController
{
	protected $personRepository;
	protected $userRepository;
	protected $groupRepository;

	  /**
    * General constants
    */
 	  const FATHER                                = 1;
    const MOTHER                                = 2;
    const SON                                   = 3;
    const NODE_IS_A_COPY                    = 1;
    const NODE_IS_NOT_A_COPY                    = 0;
    const NO_GROUP                              = 0;
    const NOT_ADMIN                             = 0;
    const REQUEST_STATUS_SUCCESSFUL 			= 'successful';


	public function __construct(
		PersonRepositoryInterface $personRepository,
		UserRepositoryInterface $userRepository,
		GroupRepositoryInterface $groupRepository)
	{
        $this->personRepository = $personRepository;
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;
	}


	/**
    * This function check if the Person exists already in the tree (graph model)
    * and create the view for the tree. If the Persons doesn't exists in the
		* graph model, then we create it and map all his family into the tree.
    * @return View
    */
	public function get_tree()
	{
		try
		{
			$person = Auth::user()->Person;

			/* Check if the NodePerson for this user wasn´t created yet */
			if (!($this->get('NodePerson')->nodePersonExists($person->getId()))) {
				
				$groupId = self::NO_GROUP;
				if ($person->getFamily() != null) {
					$groupId = $person->getFamily()->id;
				}

				/* Create the NodePerson for this user */
				$this->get('NodePerson')->create($person->getId(),$person->getId(), self::NODE_IS_NOT_A_COPY, $groupId);

				if ($person->getFamily() == null) {

					return View::make('person.tree');

				}

				/* Sort the familiars: first the parents and then the sons */
				$directFamiliars = array();

				/* First the parents */
				foreach ($person->getFamily()->Persons as $directFamiliar) {
					if ($directFamiliar->getFamily()->pivot->role_id == self::FATHER || $directFamiliar->getFamily()->pivot->role_id == self::MOTHER) {
						array_push($directFamiliars, $directFamiliar);
					}
				}

				// Real or auxiliar sons
				$theCoupleHasSons = false;
				/* Then the sons */
				foreach ($person->getFamily()->Persons as $directFamiliar) {
					if ($directFamiliar->getFamily()->pivot->role_id == self::SON) {
						array_push($directFamiliars, $directFamiliar);
						$theCoupleHasSons = true;
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
							$this->get('NodePerson')->create($directFamiliar->id,$directFamiliar->id, self::NODE_IS_NOT_A_COPY,$groupId);

							/* Now we check the role of the logged Person and we infer how relate it to
							the direct familiar */
							if ($person->getFamily()->pivot->role_id == self::FATHER || $person->getFamily()->pivot->role_id == self::MOTHER) {
								if ($directFamiliar->getFamily()->pivot->role_id == self::SON) {
									$sonId = $directFamiliar->id;
									$parentId = $person->id;

									/* Add as parent the logged Person */
									$this->get('NodePerson')->addParent($sonId, $parentId);

									/* Add as parent the couple of logged Person */
									if ($nodePersonLogged->couple->first() != null) {
										$this->get('NodePerson')->addParent($sonId, $nodePersonLogged->couple()->first()->personId);
									}
								}

								if ($directFamiliar->getFamily()->pivot->role_id == self::FATHER || $directFamiliar->getFamily()->pivot->role_id == self::MOTHER) {
									$coupId = $directFamiliar->id;
									/* Add as the coup the logged Person and vice versa */
									$this->get('NodePerson')->addCouple($person->id, $coupId);
									$this->get('NodePerson')->addCouple($coupId, $person->id);

									if (!$theCoupleHasSons) {
										// Create the auxiliar son node. For the right drawing
										$coupleNode = $this->get('NodePerson')->findById($directFamiliar->id);
				                        $this->get('NodePerson')->addAuxiliarSon($nodePersonLogged, $coupleNode, $nodePersonLogged->personId);
				                        $theCoupleHasSons = true;
									}
								}
							}

							if ($person->getFamily()->pivot->role_id == self::SON) {
								if ($directFamiliar->getFamily()->pivot->role_id == self::FATHER || $directFamiliar->getFamily()->pivot->role_id == self::MOTHER) {
									$sonId = $person->id;
									$parentId = $directFamiliar->id;

									/* Add as son the logged Person */
									$this->get('NodePerson')->addParent($sonId, $parentId);

									/* Unite the parents if already have loaded 2 of them */
									if ($nodePersonLogged->parents()->count() == 2) {
										foreach ($nodePersonLogged->parents as $parent) {
											foreach ($nodePersonLogged->parents as $otherParent) {
												if ($parent->personId != $otherParent->personId) {
													$this->get('NodePerson')->addCouple($parent->personId, $otherParent->personId);
												}
											}
										}
									}
								}
								if ($directFamiliar->getFamily()->pivot->role_id == self::SON) {

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

			return View::make('person.tree');

		} catch (Exception $e) {
			return Redirect::to('500')->with('error', $e);
		}
	}

	/**
     * Get the elements (nodes and edges) necessary for the tree
     * @return Node Persons
     */
	public function get_loadTreeElements()
	{
		$user = Auth::user();

		$personLogged = $user->Person->getId();

		$family = $this->get('NodePerson')->getFamily($personLogged);

		// Loading Nodes
		$nodes = array();
		foreach ($family as $nodePerson) {
			// If isn't a auxiliar node
			if ($nodePerson->aux == null) {
				$person = $this->personRepository->getById($nodePerson->personId);
				// Check if can add more Parents
				$canAddParents = $this->get('NodePerson')->canAddParents($nodePerson);
				// Check if can add a Couple
				$canAddCouple = $this->get('NodePerson')->canAddCouple($nodePerson);

				// Check if the logged person can update his data
				$canBeModifiedByLoggedUser = ($nodePerson->ownerId == $personLogged) && ($nodePerson->isACopy != self::NODE_IS_A_COPY);
				// If the node is the logged person, he can't remove itself
				$canBeRemoved = ($nodePerson->personId != $personLogged) && ($nodePerson->ownerId == $personLogged);

				$personId = $person->id;
				$dataOfPerson = array(
					"id" => (string)$personId,
					"name" => $person->name,
					"lastname" => $person->lastname,
					"mothersname" => $person->mothersname,
					"email" => $person->email,
					"birthdate"	=> $this->formatDate($person->birthdate, $toSpanishFormat = true),
					"gender"	=> $person->gender,
					"phone"	=> $person->phone,
					"fullname"	=> $person->name . " " . $person->lastname . " " . $person->mothersname,
					"canAddParents"	=> $canAddParents,
					"canAddCouple"	=> $canAddCouple,
					"canBeModifiedByLoggedUser"	=> $canBeModifiedByLoggedUser,
					"canBeRemoved"	=> $canBeRemoved,
					"ownerId"		=> $nodePerson->ownerId
				);

				/* If the person are user, set a distinctive border */
				if ($this->userRepository->existsUser($personId)) {

					/* Distinctive border for the logged person*/
					if ($personId == $personLogged) {
						$photo = array('background-image' => $person->Photo->fileURL,
						"background-fit" => 'cover', 'border-width' => '3px', 'border-color' => '#18a78a');
					}
					else
					{
						$photo = array('background-image' => $person->Photo->fileURL,
						"background-fit" => 'cover', 'border-width' => '3px', 'border-color' => '#f8ac59');
					}
				}
				else
				{
					$photo = array('background-image' => $person->Photo->fileURL,
					"background-fit" => 'cover');
				}


				$data = array('data' => $dataOfPerson, 'css' => $photo);

				array_push($nodes, $data);
			}
			else {
				$dataOfPerson = array(
					"id" => (string)$nodePerson->personId,
					"aux" => $nodePerson->aux
				);

				$css = array('display' => 'none');

				$data = array('data' => $dataOfPerson, 'css' => $css);
				array_push($nodes, $data);
			}
		}

		// Loading edges
		$relations = array();
		foreach ($family as $person) {
			foreach ($person->parents as $nodeParent) {
				// Source is the parent of person
				$source = (string)$nodeParent->personId;
				// Target is the person
				$target = (string)$person->personId;
				$dataParOfRelations = array("source" => $source, "target" => $target);
				$data = array("data" => $dataParOfRelations);
				array_push($relations, $data);
			}
		}

		$elements = array('nodes' => $nodes, 'edges' => $relations);
		return Response::json( $elements );
	}

	/**
    * This function creates a Person, a NodePerson and relate this NodePerson
		* like a someone's father
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
				'role_id' 		=> $input['gender'],
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

				$user = Auth::user();
				$personLogged = $user->Person->getId();

				// Create a Person
				$newPersonId =  $this->personRepository->store($data);

				// Push into the family group
				if ($user->Person->getFamily() != null) {

					$groupFamilyId = $user->Person->getFamily()->id;
					$this->groupRepository->addGroupMember($groupFamilyId, $newPersonId, self::NOT_ADMIN);
				}

				// Create a NodePerson
				$this->get('NodePerson')->create($newPersonId, $personLogged, self::NODE_IS_NOT_A_COPY, $son->groupId);

				// Add new Person as parent
				$parentId = $newPersonId;
				$this->get('NodePerson')->addParent($sonId, $parentId);

				return Response::json( self::REQUEST_STATUS_SUCCESSFUL );
			}
			else {
				return Response::json( $validation->messages()->all('- :message -') );
			}

		} catch (Exception $e) {
			return Response::json( Lang::get('messages.error_on_create_person') );
		}
	}

	/**
    * This function creates a Person, a NodePerson and relate this NodePerson
		* with a someone's couple
    * @return Json with the request status
    */
	public function post_saveCouple()
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
				'role_id' 		=> $input['gender'],
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

			// Check if son can add a Couple
			$clickedPersonId = (int)$input['id'];
			$clickedPerson = $this->get('NodePerson')->findById($clickedPersonId);

			if ($this->get('NodePerson')->canAddCouple($clickedPerson) && !($validation->fails())) {

				$user = Auth::user();
				$personLogged = $user->Person->getId();

				// Create a Person
				$newPersonId =  $this->personRepository->store($data);

				// Push into the family group
				if ($user->Person->getFamily() != null) {

					$groupFamilyId = $user->Person->getFamily()->id;
					$this->groupRepository->addGroupMember($groupFamilyId, $newPersonId, self::NOT_ADMIN);
				}

				// Create a NodePerson
				$this->get('NodePerson')->create($newPersonId, $personLogged, self::NODE_IS_NOT_A_COPY, $clickedPerson->groupId);

				// Add new Person as couple
				$coupleId = $newPersonId;
				$this->get('NodePerson')->addCouple($clickedPersonId, $coupleId);
				$this->get('NodePerson')->addCouple($coupleId, $clickedPersonId);

				// Create the auxiliar son node. For the right drawing
				$coupleAdded = $this->get('NodePerson')->findById($newPersonId);
				$this->get('NodePerson')->addAuxiliarSon($clickedPerson, $coupleAdded, $personLogged);

				return Response::json( self::REQUEST_STATUS_SUCCESSFUL );
			}
			else {
				return Response::json( $validation->messages()->all('- :message -') );
			}

		} catch (Exception $e) {
			return Response::json( Lang::get('messages.error_on_create_person') );
		}
	}

	/**
	* This function update the data of person
	* @return Json with the request status
	*/
	public function post_updatePersonData()
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
					'name' 			=> $input['name'],
					'lastname' 		=> $input['lastname'],
					'mothersname' 	=> $input['mothersname'],
					'date_of_birth' => $birthdate,
					'sex' 		=> $input['gender'],
					'cellphone' 	=> $input['phone'],
					'role' 		=> $input['gender'] == self::MOTHER ? self::MOTHER : self::FATHER
				);

			 	$rules = array(
				 	'name' => 'required',
		            'lastname' => 'required',
		            'sex' => 'required',
		            'date_of_birth' => 'date',
		            'cellphone' => 'numeric'
	            );

				$validation = Validator::make($data, $rules);

				if (!($validation->fails())) {
					
					$this->personRepository->updatePerson($personId, $data);

					return Response::json( self::REQUEST_STATUS_SUCCESSFUL );
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
	 * This function load the view of the photo loading
	 * @return View
	 */
	public function get_setPhoto($id)
	{
		// Logged Person
		$user = Auth::user();
		$personLoggedId = $user->Person->getId();

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
	public function post_setPhoto()
	{
		// Logged Person
		$user = Auth::user();
		$personLoggedId = $user->Person->id;

		$personId = Session::get('personIdPhotonEditing');
		$input = Input::all();

		$rules = array(
		 	'photo' => 'required|mimes:jpeg,bmp,png'
        );

        $validation = Validator::make($input, $rules);

		$nodePersonToUpdatePhoto = $this->get('NodePerson')->findById($personId);

		if ($validation->fails() || $nodePersonToUpdatePhoto == null || $nodePersonToUpdatePhoto->ownerId != $personLoggedId)
		{
			return Redirect::to('/tree');
		}

		$person = $this->personRepository->getById($personId);
		$person->photo = $input["photo"];

		$this->personRepository->store($person);
		return Redirect::to('/tree');
	}

	/**
	 * This function remove the person photo
	 */
	public function get_removePhoto()
	{
		// Logged Person
		$user = Auth::user();
		$personLoggedId = $user->Person->id;

		$personId = Session::get('personIdPhotonEditing');
		$input = Input::all();

		$nodePersonToUpdatePhoto = $this->get('NodePerson')->findById($personId);

		if ($nodePersonToUpdatePhoto == null || $nodePersonToUpdatePhoto->ownerId != $personLoggedId) {
			return Redirect::to('/tree');
		}

		$person = $this->personRepository->getById($personId);
		$person->photo = null;

		$this->personRepository->store($person);
		return Redirect::to('/tree');
	}

/**
 * This function removes a person from the tree
 * @param $id The personId of the node in the tree
 * @param $ownerId The personId of the node's owner
 * @return Json with the request status
 */
	public function get_removePerson($id, $ownerId)
	{
		try {

			if (is_string($id)) {
				$id = (int)$id;
			}

			if (is_string($ownerId)) {
				$ownerId = (int)$ownerId;
			}

			// Logged Person
			$user = Auth::user();
			$personLoggedId = $user->Person->id;
			
			$nodePerson = $this->get('NodePerson')->findById($id);

			if ($nodePerson == null) {
				return Response::json( Lang::get('messages.not_existing_node_person') );
			}

			if ($this->userRepository->existsUser($id)) {
			   return Response::json( Lang::get('messages.cannotRemove') );
			}
			else {
				if ($nodePerson->ownerId != $personLoggedId) {
					return Response::json( Lang::get('messages.cannotRemove') );
			}

			// If have couple
			if (!$this->get('NodePerson')->canAddCouple($nodePerson)) {

				// Try to delete the deleted auxiliar son
				$this->get('NodePerson')->delete(-($nodePerson->personId), $personLoggedId);

				// Try to delete the auxiliar son via couple
				$couple = $nodePerson->couple()->first();			

				if ($couple != null) {
					$this->get('NodePerson')->delete(-($couple->personId), $personLoggedId);
				}				
			}

			// Delete the person
			$this->get('NodePerson')->delete($nodePerson->personId, $nodePerson->ownerId);


			return Response::json( self::REQUEST_STATUS_SUCCESSFUL );
		}
		} catch (Exception $e) {
			return Response::json( $e->getMessage() );
			return Response::json( Lang::get('messages.error_removing_node') );
		}

	}

	/* Utilities */

	/**
     * The function wich manages the date format
     * @param $date The date to format
     * @param $toSpanishFormat Indicates if the return value must be in spanish format
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

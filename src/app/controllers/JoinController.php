<?php

use s4h\core\PersonRepositoryInterface;

class JoinController extends BaseController
{
	protected $personRepository;

	public function __construct(PersonRepositoryInterface $personRepository) 
	{
        $this->personRepository = $personRepository;
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

	/**
	 * This function load the page to avoid the user send an invitation
	 * @return View
	 */
	public function get_makeInvitation()
	{
		$user = Auth::user();
		$personId = $user->person->id;
		$familiars = $this->get('NodePerson')->getFamily($personId);

		$connectionNodes = array();
		foreach ($familiars as $nodePerson) {
			$person = $this->personRepository->getById($nodePerson->personId);
			if ($person != null) {
				$connectionNodes[] = $person;
			}
		}

		return View::make('join.makeInvitation')->with('connectionNodes', $connectionNodes);
	}

	public function post_makeInvitation()
	{

	}
}
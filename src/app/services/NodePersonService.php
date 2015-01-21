<?php

/**
 *  NodePersonService.php
 *
 *  @category Services
 *  @package  ArbolG
 *  @author   Kiwing IT Solutions <info@kiwing.net>
 *  @author   Federico Rossi <rossi.federico.e@gmail.com>
 *  @license  undefined
 *  @version  0.1
 *  @link     https://github.com/kiwing-it/arbolg
 *
 */

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\NodePerson;
use s4h\core\PersonRepositoryInterface;

class NodePersonService extends BaseService
{
    public $personRepository;

    public function setPersonRepository($personRepository)
    {
       $this->personRepository = $personRepository;
    }

    /**
    * Queries
    */
    const GET_ALL_FAMILY = 'MATCH (n:NodePerson {personId: R_PERSON, ownerId: R_OWNER, isACopy: 0})-[r*]-(p) RETURN DISTINCT p';
    const DELETE_NODE    = 'MATCH (n:NodePerson {personId: R_PERSON, ownerId: R_OWNER }) OPTIONAL MATCH (n)-[r]-() DELETE n,r';
    const GET_SONS = 'MATCH (n {personId: R_PERSON})-[r:PARENT]->(s) RETURN DISTINCT s';

    /**
     * General constants
     */
    const MAX_PARENTS_ALLOWED               = 2;
    const MAX_COUPLES_ALLOWED               = 1;
    const SUCCESSFUL_MERGE                  = true;
    const FAILURE_MERGE                     = false;
    const GENDER_MALE                       = 1;
    const GENDER_FEMALE                     = 2;
    const NODE_IS_A_COPY                    = 1;
    const NODE_IS_NOT_A_COPY                = 0;


    /**
    * Check if is the user's first login and create the NodePerson if it's
    * @param int $personId The person id to verify if exists
    * @return true or false
    */
    public function nodePersonExists($personId)
    {
        $existsAlready = false;
        $node = NodePerson::where('personId','=',$personId)->first();
        if ($node != null) {
            $existsAlready = true;
        }
        return $existsAlready;
    }

    /**
     * Find NodePerson by the Person id
     * @param $personId The id of the Person related with the NodePerson to find
     * @return Person
     */
    public function findById($personId)
    {
        return NodePerson::where('personId', '=', $personId)->where('isACopy', '<', 1)->first();
    }

    /**
     * Create a new NodePerson
     * @param $personId The id of the person to create the NodePerson
     * @param $ownerID The id of the NodePerson owner
     * @param $isACopy If the NodePerson is a copy of other NodePerson
     * @param $groupId The id of the Person's group
     * @return NodePerson The new NodePerson
     */
    public function create($personId, $ownerId, $isACopy, $groupId)
    {
    	try {

    		$nodePerson = NodePerson::create([
          'personId'          => $personId,
          'ownerId'           => $ownerId,
          'isACopy'           => $isACopy,
          'groupId'           => $groupId,
        ]);

        return $nodePerson;

    	} catch (Exception $e) {
    		Log::error($e);
    		throw new Exception($e->getMessage());
    	}
    }

    /**
     * Delete a NodePerson
     * @param $personId The id of the Person to delete
     * @param $ownerId The id of the owner
     */
    public function delete($personId, $ownerId)
    {
        try {

            $query = str_replace("R_PERSON", $personId, self::DELETE_NODE);
            $query = str_replace("R_OWNER", $ownerId, $query);

            $result = DB::connection('neo4j')->select($query);

        } catch (Exception $e) {
            Log::error($e);
            throw new Exception($e->getMessage());
        }
    }


    /**
     * Add parent to a NodePerson
     * @param int $son The id of the son
     * @param int $parent The id of the parent
     */
    public function addParent($son, $parent)
    {
        $person = $this->findById($son);

        $personToAsignLikeParent = $this->findById($parent);

        $person->parents()->save($personToAsignLikeParent);

    }

    /**
     * Add couple to a NodePerson
     * @param int $root The id of the person
     * @param int $couple The id of the couple
     */
    public function addCouple($root, $couple)
    {
        $personToAddCouple = $this->findById($root);

        $personToAsignLikeCouple = $this->findById($couple);

        $personToAddCouple->couple()->save($personToAsignLikeCouple);
    }

    /**
    * Add auxiliar son Node for the couple
    * @param $firstCouple The first couple
    * @param $secondCouple The second couple
    */
    public function addAuxiliarSon($firstCouple, $secondCouple, $ownerId)
    {
      // The personId of a auxiliar son node is the negative of parent id.
      $id = -$firstCouple->personId;
      $auxNodePerson = NodePerson::create([
        'personId'          => $id,
        'ownerId'           => $ownerId,
        'isACopy'           => 0,
        'groupId'           => $firstCouple->groupId,
        'aux'               => true]);

        $auxNodePerson->parents()->save($firstCouple);
        $auxNodePerson->parents()->save($secondCouple);
    }

    /**
     * Get the family of Person
     * @param  $personId The id of the Person
     * @return Persons
     */
    public function getFamily($personId)
    {
        $family = array();

        $query = str_replace("R_PERSON", $personId, self::GET_ALL_FAMILY);
        $query = str_replace("R_OWNER", $personId, $query);
        $result = DB::connection('neo4j')->select($query);
        foreach ($result as $item) {

            $itemPersonId = $item->current()->getProperties()['personId'];
            $itemOwnerId = $item->current()->getProperties()['ownerId'];
            $itemIsACopy = $item->current()->getProperties()['isACopy'];

            $person;

            if ($itemIsACopy == 1) {
              $person = NodePerson::where('personId', '=', $itemPersonId)
              ->where('ownerId', '=', $itemOwnerId)
              ->where('isACopy', '=', $itemIsACopy)->first();
            }
             else {
             $person = $this->findById($itemPersonId);
            }

            if ($person != null) {
                $family[] = $person;
            }
        }
        // Add the logged user
        $family[] = $this->findById($personId);

        return $family;
    }

    /**
     * Get the id of the persons son
     * @param  $personId The id of the Person
     * @return id of Persons
     */
    public function getSonsId($personId)
    {
        $ids = array();

        $query = str_replace("R_PERSON", $personId, self::GET_SONS);
        $result = DB::connection('neo4j')->select($query);
        foreach ($result as $item) {

            $itemPersonId = $item->current()->getProperties()['personId'];
            $ids[] = $itemPersonId;
        }

        return $ids;
    }

    /**
     * Return if the person has sons
     * @param  personId
     * @return Bool
     */
    public function hasSons($personId)
    {
        $hasSons = false;

        foreach (NodePerson::with('parents')->get() as $son)
        {
            foreach ($son->parents as $parentItem) {
                if ($parentItem->personId == $personId) {
                    $hasSons = true;
                }
            }
        }

       return $hasSons;
    }

    /**
     * Check if the Person can have more Parents
     * @param  $person The NodePerson to evaluate if can add Parents
     * @return Bool
     */
    public function canAddParents($person)
    {
        if ($person->parents != null) {
           if ($person->parents()->count() < self::MAX_PARENTS_ALLOWED)
            {
                return true;
            }
            else
            {
                return false;
            }
        } else{
            return true;
        }

    }
    /**
     * Check if the Person can add a Couple
     * @param $person The NodePerson to evaluate if can add a Couple
     * @return Bool
     */
    public function canAddCouple($person)
    {
      if ($this->hasSons($person->personId)) {
        return false;
      }

      if ($person->couple != null) {
         if ($person->couple()->count() < self::MAX_COUPLES_ALLOWED)
          {
              return true;
          }
          else
          {
              return false;
          }
      } else{
          return true;
      }
    }

    /**
     * The function wich manages the merge
     * @param fromId The id of the Person in the tree of the sender
     * @param toId The id of the Person to connect like Person(fromId) brother
     * @param fromKeepsTheTree Indicates if Person(fromId) keeps his tree or join in the Person(toId) tree
     * @param userWhoMakesTheInvitation is id of the user who makes the invitation to share the tree
     * @return boolean indicating the success or failure of the merge
     */
    public function merge($fromId, $toId, $fromKeepsTheTree, $userWhoMakesTheInvitation)
    {
        try {
            // data parsing
            $fromId = (int)$fromId;
            $toId = (int)$toId;
            $fromKeepsTheTree = (int)$fromKeepsTheTree;
            $userWhoMakesTheInvitation = (int)$userWhoMakesTheInvitation;

            $connectionPerson = $this->findById($fromId);

            $nodePersonToConnect = $this->findById($toId);            

            /* If connectionPerson keeps his tree, then we makes a copy of $nodePersonToConnect
            and set nodePersonToConnect like connectionPerson brother */
            if ($fromKeepsTheTree == 1) {

              $connectionPersonHasParents = false;
              $nodePersonToConnectHasParents = false;

              if ($connectionPerson->parents != null && $connectionPerson->parents()->count() != 0) {
                $connectionPersonHasParents = true;
              }

              if ($nodePersonToConnect->parents != null && $nodePersonToConnect->parents()->count() != 0) {
                $nodePersonToConnectHasParents = true;
              }
                
                // If connectionPerson has parents 
                if ($connectionPersonHasParents) {

                  if ($nodePersonToConnectHasParents) {
                      /* Creating a copy of nodePersonToConnect into connectionPerson tree */
                      $newNodePerson = $this->create($nodePersonToConnect->personId, $userWhoMakesTheInvitation, self::NODE_IS_A_COPY, $nodePersonToConnect->groupId);

                      /* New parents */
                      foreach ($connectionPerson->parents as $parent) {
                          $newNodePerson->parents()->save($parent);
                      }

                      /* Creating a copy of connectionPerson into nodePersonToConnect tree */
                      $newConnectionPerson = $this->create($connectionPerson->personId, $userWhoMakesTheInvitation, self::NODE_IS_A_COPY, $connectionPerson->groupId);

                      /* New parents of newConnectionPerson*/
                      foreach ($nodePersonToConnect->parents as $parent) {
                          $newConnectionPerson->parents()->save($parent);
                      }
                   }
                   else {
                      // Add nodePersonToConnect like connectionPerson parent's son
                      foreach ($connectionPerson->parents as $parent) {
                      $nodePersonToConnect->parents()->save($parent);
                    }
                   }

                }
                else {

                  if ($nodePersonToConnectHasParents) {
                    // Add connectionPerson like nodePersonToConnect parent's son
                      foreach ($nodePersonToConnect->parents as $parent) {
                      $connectionPerson->parents()->save($parent);
                    }
                  }
                  else {

                    /* Check if connectionPerson has father and mothers  */
                    $connectionPersonHasFather = false;
                    $connectionPersonHasMother = false;
                    if ($connectionPerson->parents != null) {
                          foreach ($connectionPerson->parents as $parent) {
                            $person = $this->personRepository->getById($parent->personId);

                            if ($person != null && $person->gender == self::GENDER_MALE) {
                                $connectionPersonHasFather = true;
                            }

                            if ($person != null && $person->gender == self::GENDER_FEMALE) {
                                $connectionPersonHasMother = true;
                            }
                        }
                    }

                    /* Create connectionPerson parent's */
                    if (!$connectionPersonHasFather) {

                        /* Father creation */

                        $father = array(
                            'name'          => 'Agregar Padre',
                            'lastname'      => ' ',
                            'mothersname'   => ' ',
                            'birthdate'     => '',
                            'gender'        => self::GENDER_MALE,
                            'phone'         => '',
                            'email'         => '',
                            'user_id'       => null,
                            'role_id'       => 1,
                            'file_id'       => null
                        );

                        // Create a Person
                        $newPersonId =  $this->personRepository->store($father);

                        // Create a NodePerson (the owner is the user who makes the invitation)
                        $this->create($newPersonId, $userWhoMakesTheInvitation, self::NODE_IS_NOT_A_COPY, $connectionPerson->groupId);

                        // Add new Person as parent
                        $parentId = $newPersonId;
                        $this->addParent($connectionPerson->personId, $parentId);
                    }

                    if (!$connectionPersonHasMother) {

                        /* Mother creation */

                         $mother = array(
                            'name'          => 'Agregar Madre',
                            'lastname'      => ' ',
                            'mothersname'   => ' ',
                            'birthdate'     => '',
                            'gender'        => self::GENDER_FEMALE,
                            'phone'         => '',
                            'email'         => '',
                            'user_id'       => null,
                            'role_id'       => 1,
                            'file_id'       => null
                        );

                        // Create a Person
                        $newPersonId =  $this->personRepository->store($mother);

                        // Create a NodePerson (the owner is the user who makes the invitation)
                        $this->create($newPersonId, $userWhoMakesTheInvitation, self::NODE_IS_NOT_A_COPY, $connectionPerson->groupId);

                        // Add new Person as parent
                        $parentId = $newPersonId;
                        $this->addParent($connectionPerson->personId, $parentId);
                    }

                    // Get again connectionPerson to update the relations
                    $connectionPerson = $this->findById($connectionPerson->personId);

                    /* Add nodePersonToConnect like connectionPerson brother */
                    foreach ($connectionPerson->parents as $parent) {

                        $this->addParent($nodePersonToConnect->personId, $parent->personId);
                    }
                  }

                }               
                
            }
            else
            {
                /* If connectionPerson don't keep his tree, then we separates him from the current tree
                and add into the nodePersonToConnect's tree  */

                /* Deleting parents */
                if ($connectionPerson->parents != null) {
                  $connectionPersonParents = $connectionPerson->parents;
                    foreach ($connectionPersonParents as $parent) {
                        $connectionPerson->parents()->detach($parent);   
                    }
                }

                 /* Check if nodePersonToConnect has father and mothers  */

                $nodePersonToConnectHasFather = false;
                $nodePersonToConnectHasMother = false;
                if ($nodePersonToConnect->parents != null) {
                      foreach ($nodePersonToConnect->parents as $parent) {
                        $person = $this->personRepository->getById($parent->personId);

                        if ($person != null && $person->gender == self::GENDER_MALE) {
                            $nodePersonToConnectHasFather = true;
                        }

                        if ($person != null && $person->gender == self::GENDER_FEMALE) {
                            $nodePersonToConnectHasMother = true;
                        }
                    }
                }

                /* Create nodePersonToConnect parent's */
                if (!$nodePersonToConnectHasFather) {

                    /* Father creation */

                    $father = array(
                        'name'          => Lang::get('titles.addParent'),
                        'lastname'      => ' ',
                        'mothersname'   => ' ',
                        'birthdate'     => '',
                        'gender'        => self::GENDER_MALE,
                        'phone'         => '',
                        'email'         => '',
                        'user_id'       => null,
                        'role_id'       => 1,
                        'file_id'       => null
                    );

                    // Create a Person
                    $newPersonId =  $this->personRepository->store($father);

                    // Create a NodePerson (the owner is the user who makes the invitation)
                    $this->create($newPersonId, $userWhoMakesTheInvitation, self::NODE_IS_NOT_A_COPY, $nodePersonToConnect->groupId);

                    // Add new Person as parent
                    $parentId = $newPersonId;
                    $this->addParent($nodePersonToConnect->personId, $parentId);
                }

                if (!$nodePersonToConnectHasMother) {

                    /* Mother creation */

                     $mother = array(
                        'name'          => Lang::get('titles.addMother'),
                        'lastname'      => ' ',
                        'mothersname'   => ' ',
                        'birthdate'     => '',
                        'gender'        => self::GENDER_FEMALE,
                        'phone'         => '',
                        'email'         => '',
                        'user_id'       => null,
                        'role_id'       => 1,
                        'file_id'       => null
                    );

                    // Create a Person
                    $newPersonId =  $this->personRepository->store($mother);

                    // Create a NodePerson (the owner is the user who makes the invitation)
                    $this->create($newPersonId, $userWhoMakesTheInvitation, self::NODE_IS_NOT_A_COPY, $nodePersonToConnect->groupId);

                    // Add new Person as parent
                    $parentId = $newPersonId;
                    $this->addParent($nodePersonToConnect->personId, $parentId);
                }

                // Get again nodePersonToConnect to update the relations
                $nodePersonToConnect = $this->findById($nodePersonToConnect->personId);

                /* New parents */
                foreach ($nodePersonToConnect->parents as $parent) {

                    $this->addParent($connectionPerson->personId, $parent->personId);
                }
        }

        } catch (Exception $e) {
            return self::FAILURE_MERGE;
        }

        return self::SUCCESSFUL_MERGE;
    }
}

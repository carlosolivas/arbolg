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
    const GET_ALL_FAMILY = 'MATCH (n:NodePerson {personId: ROOT})<-[r*]-(p) RETURN DISTINCT p';

    /**
     * General constants
     */
    const MAX_PARENTS_ALLOWED               = 2;
    const SUCCESSFUL_MERGE                  = true;
    const FAILURE_MERGE                     = false;
    const GENDER_MALE                       = 1;
    const GENDER_FEMALE                     = 2;
    const NODE_IS_A_COPY                    = 1;


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
     * Get all the persons
     * @return NodePersons collection
     */
    public function findAll() 
    {
        return NodePerson::all();
    }

    /**
     * Find person by identifier
     * @param int $personId The id of the NodePerson to find
     * @return Person       
     */
    public function findById($personId)
    {        
        return NodePerson::where('personId', '=', $personId)->where('isACopy', '<', 1)->first();
    }

    /**
     * Create a new NodePerson
     * @param $personId The id of the person to create the NodePerson
     */
    public function create($personId, $ownerId, $isACopy, $groupId)
    {
        
    	try {           

    		NodePerson::create([
                'personId'          => $personId,
                'ownerId'           => $ownerId,
                'isACopy'           => $isACopy,
                'groupId'           => $groupId,
            ]);

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
        if ($this->canAddParents($person)) 
        {             
            $personToAsignLikeParent = $this->findById($parent);

            $person->parents()->save($personToAsignLikeParent); 
        }
    }

    /**
     * REmove parent to a NodePerson
     * @param int $sonId The id of the son
     * @param int $parentId The id of the parent
     */
    public function removeParent($sonId, $parentId)
    {
        $person = Person::where('personId', '=', $sonId)->first();    
    
        $personToUnAsignLikeParent = Person::where('personId', '=', $parent)->first();

        $person->parents()->detach($personToUnAsignLikeParent);                
    }

    /**
     * Add couple to a NodePerson
     * @param int $root The id of the person
     * @param int $couple The id of the couple
     */
    public function addCoup($root, $couple)
    {
        $personToAddCoup = $this->findById($root);               
                        
        $personToAsignLikeCoup = $this->findById($couple);

        $personToAddCoup->coup()->save($personToAsignLikeCoup);
    }

    /**
     * Get the family of Person
     * @param  $personId The id of the Person
     * @return Persons   
     */  
    public function getFamily($personId)
    {
        $family = array();
        
        $query = str_replace("ROOT", $personId, self::GET_ALL_FAMILY);        
         
        $result = DB::connection('neo4j')->select($query);
        
        foreach ($result as $item) {
            $itemPersonId = $item->current()->getProperties('personId');
            $person = $this->findById($itemPersonId);

            if ($person != null) {
                $family[] = $person;
            }
        }

        /* If doesn't have family, return the single node of Person */
        /*if (count($family) == 0) {
            $family[] = $this->findById($personId);
        }*/
        $family[] = $this->findById($personId);

        return $family;             
    }       

     /**
     * Get all brothers of a Person deducing through the Person's parent
     * @param  $parent: the Person's parent
     * @param  $person: the Person to search his brothers
     * @return Persons   
     */
    public function getBrothers($parent, $person)
    {
        $brothers = array();

        foreach (NodePerson::with('parents')->get() as $son)
        {
            if ($son->name != $person) {
                foreach ($son->parents as $parentItem) {
                    if ($parentItem->name == $parent) {
                        $brothers[] = $son;
                    }
                }
            }            
        }

        return $brothers;
    }    

     /**
     * Get all sons of a Person deducing through the Person's parent
     * @param  $parent The son's parent to search
     * @return Persons   
     */
    public function getSons($parentId)
    {
        $sons = array();

        foreach (NodePerson::with('parents')->get() as $son)
        {
            foreach ($son->parents as $parentItem) {
                if ($parentItem->personId == $parentId) {
                    array_push($sons,$son);
                }
            }
        }

        return $sons;
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

            $connectionPerson = $this->get('NodePerson')->findById($fromId);

            $nodePersonToConnect = $this->get('NodePerson')->findById($toId);

            /* If connectionPerson keeps his tree, then we makes a copy of $nodePersonToConnect
            and set nodePersonToConnect like connectionPerson brother */
            if ($fromKeepsTheTree) {                

                /* Creating a copy of nodePersonToConnect into connectionPerson tree */
                $this->create($nodePersonToConnect->personId, $userWhoMakeTheInvitation, self::NODE_IS_A_COPY, $nodePersonToConnect->groupId);

                /* New parents */
                foreach ($connectionPerson->parents as $parent) {   

                    $this->get('NodePerson')->addParent($nodePersonToConnect->personId, $parent->personId);
                }
            }
            else
            {
                /* If connectionPerson don't keep his tree, then we separates him from the current tree
                and add into the nodePeronToConnect's tree  */

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
                    $this->get('NodePerson')->create($newPersonId, $userWhoMakesTheInvitation);
                    
                    // Add new Person as parent
                    $parentId = $newPersonId;
                    $this->get('NodePerson')->addParent($connectionPerson->personId, $parentId);
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
                    $this->get('NodePerson')->create($newPersonId, $userWhoMakesTheInvitation);
                    
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
        }        
            
        } catch (Exception $e) {
            return self::FAILURE_MERGE;
        }       

        return self::SUCCESSFUL_MERGE;
    }
}
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

class NodePersonService extends BaseService 
{  
    /**
    * Queries
    */
    const GET_ALL_FAMILY = 'MATCH (n:NodePerson {personId: ROOT})-[r*]-(p) RETURN DISTINCT p';

    /**
     * General constants
     */
    const MAX_PARENTS_ALLOWED               = 2;


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
        return NodePerson::where('personId', '=', $personId)->first();
    }

    /**
     * Create a new NodePerson
     * @param $personId The id of the person to create the NodePerson
     */
    public function create($personId, $ownerId)
    {
        
    	try {           

    		NodePerson::create([
                'personId'          => $personId,
                'ownerId'           => $ownerId
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
    public function addParent($son, $parent, $anonymousParent = false)
    {
        $person = $this->findById($son);
        if ($this->canAddParents($person)) 
        {                
            if (!$anonymousParent) {                
            $personToAsignLikeParent = $this->findById($parent);

            $person->parents()->save($personToAsignLikeParent); 
               
            } else {
                // Do something with anonymous parent
            }                
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
    

    /*public function removeParent($son, $parent)
    {
        $person = NodePerson::where('name', '=', $son)->firstOrFail();    
    
        $personToUnAsignLikeParent = NodePerson::where('name', '=', $parent)->firstOrFail();

        $person->parents()->save($personToUnAsignLikeParent);                
    }*/

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
            $personId = $item->current()->getProperties('personId');
            $person = $this->findById($personId);

            if ($person != null) {
                $family[] = $person;
            }
        }

        /* If doesn't have family, return the single node of Person */
        if (count($family) == 0) {
            $family[] = $this->findById($personId);
        }

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
}
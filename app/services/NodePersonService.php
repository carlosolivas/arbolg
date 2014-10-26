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
use App\Models\NodePerson;

class NodePersonService extends BaseService 
{  

    /**
     * Fields validations constants
     */
 	const NAME_VALIDATION_RULE 				= 'required';
    const LAST_NAME_VALIDATION_RULE 		= 'required';	
 	const GENDER_VALIDATION_RULE 			= 'required';
    const EMAIL_VALIDATION_RULE             = 'email';

    /**
    * Queries
    */
    const GET_ALL_FAMILY = 'MATCH (person:Person)<-[:PARENT*0..]->(parents)
                            WHERE person.personId = "ROOT"
                            RETURN parents';

    const GET_NODE_PERSON_BY_PERSON_ID = 'MATCH (person:NodePerson)
                            WHERE person.personId = "ROOT"
                            RETURN person';

    /**
     * General constants
     */
    const MAX_PARENTS_ALLOWED               = 2;

 	protected $create_validation_rules = array(
 		'name' 			=> self::NAME_VALIDATION_RULE, 
 		'lastName'		=> self::LAST_NAME_VALIDATION_RULE,
 		'gender'		=> self::GENDER_VALIDATION_RULE,
        'email'         => self::EMAIL_VALIDATION_RULE,
 		);

    /**
    * Check if is the user's first login and create the NodePerson if it's
    * @return true or false
    */
    public function nodePersonExists($personId)
    {
        $existsAlready = false;
        $query = str_replace("ROOT", $id, self::GET_NODE_PERSON_BY_PERSON_ID);
         foreach (NodePerson::query($query)->get() as $person) {
            $existsAlready = true;
        }

        return $existsAlready;
    }

    /*
    * Register a Person like NodePerson
    */
    public function firstRegisterNodePerson($personId)
    {
        if (!$existsAlready) {
            $input = array('personId' => $personId, 'ownerId' => $personId);
            $this->create($input);
        }
    }

    /**
     * Get all the persons
     * @return Persons collection
     */
    public function findAll() 
    {
        return NodePerson::all();
    }

    /**
     * Find person by identifier
     * @param  $name The name of the person to find
     * @return Person       
     */
    public function findById($id)
    {
        return NodePerson::where('name', '=', $id)->first();
    }

    /**
     * Create a new NodePerson
     */
    public function create($input)
    {
        
    	try {

    		$validation = Validator::make($input, $this->createValidationRules());

    		if ($validation->fails()) {
    			throw new \App\Exceptions\ValidationException('Error validating', $validation);
    		}
            
            $personId = $input['personId'];
            $ownerId = $input['ownerId'];            

    		NodePerson::create([
                'personId'          => $personId,
                'ownerId'           => $ownerId
                ]);

    	} catch (Exception $e) {
    		Log::error($e); 	
    		throw new Exception($e->getMessage());
    	}
    }

    public function addBrother($brother, $brotherToAssign)
    {
        $person = NodePerson::where('name', '=', $brother)->firstOrFail();

        $personToAsignLikeBrother = NodePerson::where('name', '=', $brotherToAssign)->firstOrFail();

        $person->brothers()->save($personToAsignLikeBrother);
    }

    public function removeBrother($broter, $brotherToUnAssign)
    {
        $person = NodePerson::where('name', '=', $broter)->firstOrFail();

        $personToUnAsignLikeBrother = NodePerson::where('name', '=', $brotherToUnAssign)->firstOrFail();

        $person->brothers()->detach($personToUnAsignLikeBrother);
    }

    public function addParent($son, $parent, $anonymousParent = false)
    {
        $person = NodePerson::where('name', '=', $son)->firstOrFail();

        if ($person->parents()->count() < self::MAX_PARENTS_ALLOWED) {            
    
            if (!$anonymousParent) {                
            $personToAsignLikeParent = NodePerson::where('name', '=', $parent)->firstOrFail();

            $person->parents()->save($personToAsignLikeParent);    
            } else {
                /*$anonymousParent = Person::create([
                'name'              => name, 
                'lastName'          => lastName,
                'mothersMaidenName' => mothersMaidenName,
                'gender'            => gender,
                'isDeceased'        => isDeceased,
                'dateOfBirth'       => dateOfBirth,
                'placeOfBirth'      => placeOfBirth,
                'country'           => country,
                'email'             => email,
                'biography'         => biography
                ]);*/
            }
                
        }
    }

    public function removeParent($son, $parent)
    {
        $person = NodePerson::where('name', '=', $son)->firstOrFail();    
    
        $personToUnAsignLikeParent = NodePerson::where('name', '=', $parent)->firstOrFail();

        $person->parents()->save($personToUnAsignLikeParent);                
    }

    /**
     * Get the family of Person
     * @param  $id The id of the Person
     * @return Persons   
     */  
    public function getFamily($personId)
    {
        $family = array();
        $query = str_replace("ROOT", $personId, self::GET_ALL_FAMILY);
        
        foreach (NodePerson::query($query)->get() as $familiar) {
            $family[] = $familiar;
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
     * @param  $parent: the son's parent to search
     * @return Persons   
     */
    public function getSons($parent)
    {
        $sons = array();

        foreach (NodePerson::with('parents')->get() as $son)
        {
            foreach ($son->parents as $parentItem) {
                if ($parentItem->name == $parent) {
                    array_push($sons,$son);
                }
            }
        }

        return $sons;
    }

    /** 
     * @return array of Person creation rules
     */
    public function createValidationRules()
    {
        return $this->create_validation_rules;
    }
}
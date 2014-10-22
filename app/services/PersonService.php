<?php

/**
 *  PersonServiceService.php
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
use App\Models\Person;

class PersonService extends BaseService 
{

    /**
     * Fields validations constants
     */
 	const NAME_VALIDATION_RULE 				= 'required';
    const LAST_NAME_VALIDATION_RULE 		= 'required';	
 	const GENDER_VALIDATION_RULE 			= 'required';
    const EMAIL_VALIDATION_RULE             = 'email';

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
     * Get all the persons
     * @return Persons collection
     */
    public function findAll() 
    {
        return Person::all();
    }

    /**
     * Find person by identifier
     * @param  $name The name of the person to find
     * @return Person       
     */
    public function findById($id)
    {
        return Person::where('name', '=', $id)->first();
    }

    /**
     * Create a new Person
     */
    public function create($input)
    {
        
    	try {

    		$validation = Validator::make($input, $this->createValidationRules());

    		if ($validation->fails()) {
    			throw new \App\Exceptions\ValidationException('Error validating', $validation);
    		}
            
    		$name = $input['name'];
			$lastName = $input['lastName'];
			$mothersMaidenName = $input['mothersMaidenName'];
			$gender = $input['gender'];

            if (array_key_exists('isDeceased', $input)) {
                $isDeceased = $input['isDeceased'];
            }
            else{
                $isDeceased = false;
            }
            
			$dateOfBirth = $input['dateOfBirth'];
            $placeOfBirth = $input['placeOfBirth'];
            $country = $input['country'];
			$email = $input['email'];
            $biography = $input['biography'];            

    		Person::create([
                'name'	            => $name, 
                'lastName'          => $lastName,
                'mothersMaidenName' => $mothersMaidenName,
    			'gender' 			=> $gender,
                'isDeceased'        => $isDeceased,
    			'dateOfBirth' 		=> $dateOfBirth,
                'placeOfBirth'      => $placeOfBirth,
                'country'           => $country,
    			'email' 			=> $email,
                'biography'         => $biography
                ]);

    	} catch (Exception $e) {
    		Log::error($e); 	
    		throw new Exception($e->getMessage());
    	}
    }

    public function personsAvailableToRelate($person)
    {
        $persons = Person::all();
           
    }

    public function addBrother($brother, $brotherToAssign)
    {
        $person = Person::where('name', '=', $brother)->firstOrFail();

        $personToAsignLikeBrother = Person::where('name', '=', $brotherToAssign)->firstOrFail();

        $person->brothers()->save($personToAsignLikeBrother);
    }

    public function removeBrother($broter, $brotherToUnAssign)
    {
        $person = Person::where('name', '=', $broter)->firstOrFail();

        $personToUnAsignLikeBrother = Person::where('name', '=', $brotherToUnAssign)->firstOrFail();

        $person->brothers()->detach($personToUnAsignLikeBrother);
    }

    public function addParent($son, $parent, $anonymousParent = false)
    {
        $person = Person::where('name', '=', $son)->firstOrFail();

        if ($person->parents()->count() < self::MAX_PARENTS_ALLOWED) {            
    
            if (!$anonymousParent) {                
            $personToAsignLikeParent = Person::where('name', '=', $parent)->firstOrFail();

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
        $person = Person::where('name', '=', $son)->firstOrFail();    
    
        $personToUnAsignLikeParent = Person::where('name', '=', $parent)->firstOrFail();

        $person->parents()->save($personToUnAsignLikeParent);                
    }

     /**
     * Get all the tree of Person
     * @param  $id The id of the Person
     * @return Persons   
     */
    public function getFamily($id)
    {        
        $person = Person::where('name', '=', $id)->first();  
        $tree = array();
        $tree[] = $person;

        foreach ($person->parents as $parent) {
            
            /* Load Person's parents */
            foreach ($this->getFamily($parent->name) as $value) {
                $tree[] = $value;
            }

            /* Load Person's brothers */
            foreach ($this->getBrothers($parent->name, $person->name) as $brother) {
                /* Prevent the brother's duplicated */
                $brotherAlreadyLoaded = false;
                foreach ($tree as $brotherToCompare) {
                   if ($brotherToCompare->name == $brother->name) {
                       $brotherAlreadyLoaded = true;
                   }
                }
                if (!$brotherAlreadyLoaded) {
                    $tree[] = $brother;
                }                    
            }   
        }

        return $tree;
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

        foreach (Person::with('parents')->get() as $son)
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

        foreach (Person::with('parents')->get() as $son)
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
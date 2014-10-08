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

    public function findPersonByName($name)
    {
        return Person::where('name', '=', $name)->firstOrFail();
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

    public function addParent($son, $parent)
    {
        $person = Person::where('name', '=', $son)->firstOrFail();

        if ($person->parents()->count() < MAX_PARENTS_ALLOWED) {            
    
            $personToAsignLikeParent = Person::where('name', '=', $parent)->firstOrFail();

            $person->parents()->save($personToAsignLikeParent);        
        }
    }

    public function removeParent($son, $parent)
    {
        $person = Person::where('name', '=', $son)->firstOrFail();    
    
        $personToUnAsignLikeParent = Person::where('name', '=', $parent)->firstOrFail();

        $person->parents()->save($personToUnAsignLikeParent);                
    }

    /** 
     * @return array of Person creation rules
     */
    public function createValidationRules()
    {
        return $this->create_validation_rules;
    }
}
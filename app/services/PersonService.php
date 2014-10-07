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
			$dateOfBirth = $input['dateOfBirth'];
			$email = $input['email'];

    		Person::create([
                'name'	            => $name, 
                'lastName'          => $lastName,
                'mothersMaidenName' => $mothersMaidenName,
    			'gender' 			=> $gender,
    			'dateOfBirth' 		=> $dateOfBirth,
    			'email' 			=> $email
                ]);

    	} catch (Exception $e) {
    		Log::error($e); 	
    		throw new Exception($e->getMessage());
    	}
    }

    /** 
     * @return array of Person creation rules
     */
    public function createValidationRules()
    {
        return $this->create_validation_rules;
    }
}
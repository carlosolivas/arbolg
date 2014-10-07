<?php

namespace App\Models;

class Person extends \NeoEloquent
{
	protected $label = 'Person';

	protected $fillable = array(
		'name', 
		'lastName', 
		'mothersMaidenName', 
		'gender',
		'isDeceased',
		'placeOfBirth' 
		'dateOfBirth',
		'country', 
		'email',
		'biography'
		)
}
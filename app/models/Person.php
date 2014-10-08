<?php

namespace App\Models;

class Person extends \NeoEloquent
{
	protected $label = 'Person';

	public function brothers()
    {
        return $this->belongsToMany('App\Models\Person', 'BROTHER');
    }

    public function parents()
    {
        return $this->belongsToMany('App\Models\Person', 'PARENT');
    }

	protected $fillable = array(
		'name', 
		'lastName', 
		'mothersMaidenName', 
		'gender',
		'isDeceased',
		'placeOfBirth', 
		'dateOfBirth',
		'country', 
		'email',
		'biography'
		);
}
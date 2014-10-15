<?php

namespace App\Models;

class Person extends \NeoEloquent
{
	protected $label = 'Person';

	public function parents()
    {
        return $this->belongsToMany('App\Models\Person', 'PARENT');
    }

	public function coup()
    {
        return $this->hasOne('App\Models\Person', 'COUP');
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
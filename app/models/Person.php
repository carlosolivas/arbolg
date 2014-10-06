<?php

namespace App\Models;

class Person extends \NeoEloquent
{
	protected $label = 'Person';

    protected $fillable = ['name'];
}
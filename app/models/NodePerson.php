<?php

namespace App\Models;

class NodePerson extends \NeoEloquent
{
	protected $label = 'NodePerson';
	protected $connection = 'neo4j';

	public function parents()
    {
        return $this->belongsToMany('App\Models\NodePerson', 'PARENT');
    }

	public function coup()
    {
        return $this->hasOne('App\Models\NodePerson', 'COUP');
    } 

    protected $fillable = array('personId', 'ownerId');

}
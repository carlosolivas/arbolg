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

    /*
    * personId: The id of the person in relational database
    * ownerId: The id of the person who created the node and the only which have permission to edit and remove it
    * isACopy: When a node is added into other tree like a copy, this attribute is 1.
    * groupId: The id of the group in which the person are included 
    */
    protected $fillable = array('personId', 'ownerId', 'isACopy', 'groupId');

}
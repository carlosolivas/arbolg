<?php
namespace s4h\core;

use Zizaco\Confide\ConfideUser;

class User extends ConfideUser {

	/*public function userdetail() {
	return $this->hasOne('Userdetail');
	}*/

	/*public function familie() {
	return $this->hasOne('Familie');
	}*/

	public function getId() 
	{
	    if(!is_null($this->id)) {
		return intval($this->id);
	    }

	    return null;
	}

	public function calendars() {
		return $this->hasMany('Calendar');
	}

	public function Person() {
		return $this->belongsTo('s4h\core\Person', 'person_id', 'id');
	}
}
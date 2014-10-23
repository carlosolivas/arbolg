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

	public function calendars() {
		return $this->hasMany('Calendar');
	}

	public function Person() {
		return $this->hasOne('s4h\core\Person');
	}
}
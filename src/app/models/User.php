<?php

use Zizaco\Confide\ConfideUser;

class User extends ConfideUser {

    protected $table = 'users';

    public function userdetail()
    {
        return $this->hasOne('Userdetail');
    }
	
	public function familie()
    {
        return $this->hasOne('Familie');
    }
	
    public function calendars()
    {
        return $this->hasMany('Calendar');
    }

    public function Person() {
        return $this->hasOne('s4h\core\Person');
    }
}
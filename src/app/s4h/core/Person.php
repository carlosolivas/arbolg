<?php
namespace s4h\core;

class Person extends \Eloquent {
	protected $table = 'people';

	protected $fillable = [];

	public function getThumbnail() {
		return asset('assets/img/groups/' . $this->id . '-48x48.jpg');
	}

	public function getId() 
	{
	    if(!is_null($this->id)) {
		return intval($this->id);
	    }
	    return null;
	}

	public function Photo() {
		//return $this->belongsTo('s4h\core\File');
		return $this->belongsTo('s4h\core\File', 'file_id', 'id');
	}

	public function User() {
		return $this->hasOne('s4h\core\User', 'user_id', 'id');
	}

	public function Groups() {
		return $this->belongsToMany('s4h\social\Group', 'group_person', 'person_id', 'group_id')->withPivot('role_id');
	}

	public function getFamily() {
		return $this->Groups()->where('GroupTypeId', '=', '1')->first();
	}

	public function FriendFamilies() {
		return $this->Groups()->where('GroupTypeId', '=', '4')->first();
	}

	public function FriendRequests() {
		return $this->belongsToMany('s4h\social\FriendRequest');
	}

    function getAge($format, $start, $end = false) {
        // Checks $start and $end format (timestamp only for more simplicity and portability)
        if (!$end) {$end = date('Y-m-d H:i:s');}

        $d_start = new \DateTime($start);
        $d_end = new \DateTime($end);
        $diff = $d_start->diff($d_end);
        // return all data
        //$this->year    = $diff->format('%y');
        //$this->month    = $diff->format('%m');
        //$this->day      = $diff->format('%d');
        //$this->hour     = $diff->format('%h');
        //$this->min      = $diff->format('%i');
        //$this->sec      = $diff->format('%s');
        return $diff->format('%' . $format);
    }
}

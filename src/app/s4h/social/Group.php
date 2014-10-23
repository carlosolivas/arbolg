<?php
namespace s4h\social;

class Group extends \Eloquent {
	protected $fillable = [];

	public function getThumbnail() {
		return asset('assets/img/groups/' . $this->id . '-48x48.jpg');
	}

	public function GroupType() {
		return $this->hasOne('GroupType', 'Id', 'GroupTypeId');
	}

	public function Persons() {
		return $this->belongsToMany('s4h\core\Person');
	}

	public function FriendRequests() {
		return $this->hasMany('FriendRequest', 'TargetGroupId', 'id');
	}

	public function RequestedFriends() {
		return $this->hasMany('FriendRequest', 'SourceGroupId', 'id');
	}
}

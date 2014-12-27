<?php
namespace s4h\social;

class DbGroupRepository implements GroupRepositoryInterface {
    protected $file;

    public function __construct(\s4h\core\FileRepositoryInterface $file)
    {
        $this->file = $file;
    }

	public function getAll() {
		return Group::all();
	}

	public function get($id) {
		return Group::findOrFail($id);
	}

	public function findNewFriends($groupTypeId, $keyword) {
		$myGroups = \DB::table('group_person')
			->where('person_id', '=', \Auth::user()->Person->id)
		                                               ->lists('group_id');

		$groups = \DB::table('groups')
			->where('GroupTypeId', '=', $groupTypeId)
			->where('GroupName', 'like', '%' . $keyword . '%')
			->whereNotIn('id', $myGroups)
			->get();

		return $groups;
	}

	public function createFamily($data) {
        //store family's avatar
        if (isset($data['photo'])) {
            $file_id = $file->store($data['photo']);
        } else {
            $file_id = 26;
        }
		//Create the base group
		$group = new Group;
		$group->GroupName = $data['name'];
		$group->GrouptypeID = 1;
		$group->JoinAuthOption = 2;
		$group->InviteAuthOption = 2;
		$group->Active = 1;
		$group->file_id = $file_id;
		$group->save();

		//Create the family specific object
		$family = new Family;
		$family->name = $data['name'];
		$family->group_id = $group->id;
		$family->countrie_id = $data['country_id'];
		$family->zipcode_id = $data['zipcode_id'];
		$family->suburb_id = $data['suburb_id'];
		$family->street = $data['street'];
		$family->numberint = $data['numberint'];
		$family->numberext = $data['numberext'];
		$family->phone = $data['phone'];

		$family->save();

		return $group->id;
	}

	public function addGroupMember($groupId, $personId, $admin) {
		$group = $this->get($groupId);
		$group->Persons()->attach($personId, array('admin'=>$admin, 'role_id'=>1));
	}

    public function getGroupMembers($groupId) {
        $group = $this->get($groupId);
        return $group->Persons()->get();
    }

	public function myFriends() {
		$groupIds = \DB::table('group_person')
			->where('person_id', '=', \Auth::user()->Person->id)
            ->lists('group_id');

		$groups = \DB::table('groups')
			->where('GroupTypeId', '<>', '1')//La familia propia
			->where('GroupTypeId', '<>', '4')//Las familias amigas
			->whereIn('id', $groupIds)
			->lists('id');

		$myFriends = array();
		if (count($groups) > 0) {
			$myFriends = Group::with('Persons')
				->whereIn('id', $groups)	->get();
		}

		$ff = \DB::table('groups')
			->where('GroupTypeId', '=', '4')//Las familias amigas
			->whereIn('id', $groupIds)
			->lists('id');

		$myFamilyFriends = array();
		if (!empty($ff)) {
			$myFamilyFriends = \DB::table('group_person')
			->join('groups', 'group_person.group_id', '=', 'groups.id')
			->whereIn('group_person.group_id', $ff)	->get();
		}	

		return array('myFriends' => $myFriends, 'myFamilyFriends' => $myFamilyFriends);
	}

}
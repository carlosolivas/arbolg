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

        return Family::where('id', '<>', \Auth::user()->Person->Family->id)
            ->where('name', 'like', '%' . $keyword . '%')
            ->where('name', '<>', '')
            ->get();
		/*$myFriends = \DB::table('group_group')
			->where('person_id', '=', \Auth::user()->Person->id)
            ->lists('group_id');
*/
		//return Family::all();


	}

	public function createFamily($data) {
        //Create the family object
		$family = new Family;
		$family->name = $data['name'];
		//$family->group_id = $group->id;
		$family->countrie_id = $data["country_id"];
		$family->zipcode_id = $data['zipcode_id'];
		$family->suburb_id = $data['suburb_id'];
		$family->street = $data['street'];
		$family->numberint = $data['numberint'];
		$family->numberext = $data['numberext'];
		$family->phone = $data['phone'];
		$family->save();

        //Create base group
        $data['grouptype_id'] = 1;
        $data['joinAuthOpt'] = 2;
        $data['inviteAuthOpt'] = 2;
        $data['family_id'] = $family->id;
        $this->createGroup($data);

		return $family->id;
	}

    public function updateFamily($id, $data) {
        $family = Family::findOrFail($id);

        $family->name = $data['familyname'];
        $family->street = $data['street'];
        $family->numberext = $data['numberext'];
        $family->numberint = $data['numberint'];
        $family->phone = $data['phone'];
        $family->countrie_id = $data['country'];
        $family->zipcode_id = $data['zipcode'];
        $family->suburb_id = $data['suburb'];

        $family->save();

        return $family;
    }

    public function addFamilyMember($familyId, $personId, $admin) {
        $group = Group::where('family_id', '=', $familyId)
            ->where('GroupTypeID', '=', 1)
            ->first();

        $this->addGroupMember($group->id, $personId, $admin);
    }

	public function addFamilyMemberX($familyId, $personId, $admin, $roleId) {
        $group = Group::where('family_id', '=', $familyId)
            ->where('GroupTypeID', '=', 1)
            ->first();

        $group->Persons()->attach($personId, array('admin'=>$admin, 'role_id'=>$roleId));
    }

	public function addGroupMember($groupId, $personId, $admin) {
		$group = $this->get($groupId);
		$group->Persons()->attach($personId, array('admin'=>$admin, 'role_id'=>1));
	}

    public function getGroupMembers($groupId) {
        $group = $this->get($groupId);
        return $group->Persons()->get();
    }

	public function friendsByFamilyId($familyId) {

		$groupId = $this->getFriendsGroupByFamilyId($familyId)->id;

        $myFamilyFriendsIDs = \DB::table('group_group')
            ->join('groups', 'group_group.member_group_id', '=', 'groups.id')
            ->where('group_group.group_id', $groupId)
            ->lists('family_id');

        if (!$myFamilyFriendsIDs)
            return array();

        return Family::whereIn('id', $myFamilyFriendsIDs)->get();
	}

    /**
     * @param $data
     *
     * @return array
     */
    public function createGroup($data)
    {
        //store family's avatar
        if (isset($data['photo'])) {
            $file_id = $this->file->store($data['photo']);
        } else {
            $file_id = 26;
        }
        //Create the base group
        $group = new Group;
        $group->GroupName = $data['name'];
        $group->GrouptypeID = $data['grouptype_id'];
        $group->JoinAuthOption = $data['joinAuthOpt'];
        $group->InviteAuthOption = $data['inviteAuthOpt'];
        $group->Active = 1;
        $group->file_id = $file_id;
        $group->family_id = $data['family_id'];
        $group->save();

        return $group;
    }

    public function getFriendsGroupByFamilyId($id)
    {
        return Group::where('family_id', '=', $id)
            ->where('GroupTypeId', '=', 4)
            ->first();
    }

    public function getFavoritesGroupByFamilyId($id)
    {
        return Group::where('family_id', '=', $id)
            ->where('GroupTypeId', '=', 6)
            ->first();
    }

    public function updatePhoto($id, $data) {
        $file_id = $this->file->store($data['photo']);

        $group = Group::findOrFail($id);
        $group->file_id = $file_id;

        if ($group->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function getFamilyByGroupId($id)
    {
        $group = Group::find($id);
        return $group->Family;
    }
}

<?php
namespace s4h\social;

interface GroupRepositoryInterface {
	public function getAll();

	public function get($id);

	public function createFamily($data);

    public function createGroup($data);

	public function findNewFriends($groupTypeId, $keyword);

    public function addGroupMember($groupId, $personId, $admin);

    public function getGroupMembers($groupId);

    public function friendsByFamilyId($familyId);

    public function updateFamily($id, $data);

    public function getFriendsGroupByFamilyId($id);

    public function getFavoritesGroupByFamilyId($id);

    public function getFamilyByGroupId($id);
}

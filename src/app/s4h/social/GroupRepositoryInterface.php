<?php
namespace s4h\social;

interface GroupRepositoryInterface {
	public function getAll();

	public function get($id);

	public function createFamily($data);

	public function findNewFriends($groupTypeId, $keyword);

    public function addGroupMember($groupId, $personId, $admin);

    public function getGroupMembers($groupId);

	public function myFriends();
}

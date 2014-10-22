<?php
namespace s4h\core;

class UserHandler {

	protected $person;
	protected $group;

	public function __construct(PersonRepositoryInterface $person, \s4h\social\GroupRepositoryInterface $group) {
		$this->person = $person;
		$this->group = $group;
	}

	public function handle(User $user) {
		// Create a new Person for this User
		$personId = $this->person->store(array(
			'user_id' => $user->id,
			'role_id' => 0,
			'file_id' => 0,
			'name' => '',
			'lastname' => '',
			'mothersname' => '',
			'birthdate' => date('1900-01-01 00:00:00'),
			'gender' => '',
			'phone' => '',
			'email' => $user->email
		));

		//Create a new Family for this Person
		$famId = $this->group->createFamily(array(
			'name' => '',
			'country_id' => 1,
			'zipcode_id' => 15073,
			'suburb_id' => 63907,
			'street' => '',
			'numberint' => '',
			'numberext' => '',
			'phone' => '',
		));

		//Add the Person to the Family
		$this->group->addGroupMember($famId, $personId, 1);

		return true;
	}

}

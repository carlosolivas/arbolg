<?php

namespace App\Models\viewModels;

class Person
{
	private $name;
	private $lastName;
	private $mothersMaidenName;
	private $gender;
	private $isDeceased;
	private $placeOfBirth;
	private $dateOfBirth;
	private $country;
	private $email;
	private $biography;
	private $parents;
	private $sons;
	private $coup;

	public function name($name = null)
	{
		if ($name != null) {
			$this->name = $name;
		} else{
			return $this->name;
		}
	}

	public function lastName($lastName = null)
	{
		if ($lastName != null) {
			$this->lastName = $lastName;
		} else{
			return $this->lastName;
		}
	}

	public function mothersMaidenName($mothersMaidenName = null)
	{
		if ($mothersMaidenName != null) {
			$this->mothersMaidenName = $mothersMaidenName;
		} else{
			return $this->mothersMaidenName;
		}
	}

	public function gender($gender = null)
	{
		if ($gender != null) {
			$this->gender = $gender;
		} else{
			return $this->gender;
		}
	}

	public function isDeceased($isDeceased = null)
	{
		if ($isDeceased != null) {
			$this->isDeceased = $isDeceased;
		} else{
			return $this->isDeceased;
		}
	}

	public function placeOfBirth($placeOfBirth = null)
	{
		if ($placeOfBirth != null) {
			$this->placeOfBirth = $placeOfBirth;
		} else{
			return $this->placeOfBirth;
		}
	}

	public function dateOfBirth($dateOfBirth = null)
	{
		if ($dateOfBirth != null) {
			$this->dateOfBirth = $dateOfBirth;
		} else{
			return $this->dateOfBirth;
		}
	}

	public function country($country = null)
	{
		if ($country != null) {
			$this->country = $country;
		} else{
			return $this->country;
		}
	}

	public function email($email = null)
	{
		if ($email != null) {
			$this->email = $email;
		} else{
			return $this->email;
		}
	}

	public function biography($biography = null)
	{
		if ($biography != null) {
			$this->biography = $biography;
		} else{
			return $this->biography;
		}
	}

	public function parents($parents = null)
	{
		if ($parents != null) {
			$this->parents = $parents;
		} else{
			return $this->parents;
		}
	}

	public function sons($sons = null)
	{
		if ($sons != null) {
			$this->sons = $sons;
		} else{
			return $this->sons;
		}
	}

}

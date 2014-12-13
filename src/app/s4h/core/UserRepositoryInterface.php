<?php
namespace s4h\core;

interface UserRepositoryInterface {

	public function create($personId, $data);
	public function existsUser($personId);

}

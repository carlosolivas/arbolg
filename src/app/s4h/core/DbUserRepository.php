<?php
namespace s4h\core;

class DbUserRepository implements UserRepositoryInterface {

	public function create($personId, $data) {

		$user = new User;
		$user->username = $data['username'];
        $user->person_id = $personId;
		$user->email = $data['email'];
		$user->password = $data['password'];

		// The password confirmation will be removed from model
		// before saving. This field will be used in Ardent's
		// auto validation.
		$user->password_confirmation = $data['password_confirmation'];

		//Para la confirmacion del usuario
		//Tambien sera removida
		$user->username_confirmation = $data['email'];

		// Save if valid. Password field will be hashed before save
		$user->save();

		return $user;
	}

    public function add($data) {

        $user = new User;
        $user->username = $data['username'];
        $user->email = $data['email'];
        $user->password = $data['password'];

        // The password confirmation will be removed from model
        // before saving. This field will be used in Ardent's
        // auto validation.
        $user->password_confirmation = $data['password_confirmation'];

        //Para la confirmacion del usuario
        //Tambien sera removida
        $user->username_confirmation = $data['email'];

        // Save if valid. Password field will be hashed before save
        $user->save();

        return $user;
    }

    /**
     * @param       $id
     *
     * @return User
     */public function getById($id) {
        return User::find($id);
	}
}
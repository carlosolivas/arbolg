<?php

use s4h\core\PersonRepositoryInterface;

class DatabaseSeeder extends Seeder {  
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UsersTableSeeder');
	}

}

class UsersTableSeeder extends Seeder {

  protected $personRepository;

  public function __construct(PersonRepositoryInterface $personRepository) 
  {
        $this->personRepository = $personRepository;
  }

  public function run()
  {
    /*$data = array('name' => 'Bart', 
      'lastname' => 'Simpson',
      'mothersname' => 'Bouvier',
      'birthdate' => new DateTime(),
      'gender' => 1,
      'phone' => '132456',
      'email' => 'bart@gmail.com');

    $personId = $this->personRepository->store($data);*/

    /*$user = new s4h\core\User;
    $user->person_id = 77;
    $user->username = 'bartsimpson';
    $user->email = 'bart@gmail.com';
    $user->password = 'Secret1234';
    $user->password_confirmation = 'Secret1234';
    $user->confirmation_code = md5(uniqid(mt_rand(), true));


    if(! $user->save()) {
      Log::info('Unable to create user '.$user->username, (array)$user->errors());
    } else {
      Log::info('Created user "'.$user->username.'" <'.$user->email.'>');
    }*/

    /*$data = array('name' => 'Lisa', 
      'lastname' => 'Simpson',
      'mothersname' => 'Bouvier',
      'birthdate' => new DateTime(),
      'gender' => 1,
      'phone' => '132456',
      'email' => 'lisa@gmail.com');

    $personId = $this->personRepository->store($data);

    $user = new s4h\core\User;
    $user->person_id = $personId;
    $user->username = 'lisasimpson';
    $user->email = 'lisa@gmail.com';
    $user->password = 'Secret1234';
    $user->password_confirmation = 'Secret1234';
    $user->confirmation_code = md5(uniqid(mt_rand(), true));


    if(! $user->save()) {
      Log::info('Unable to create user '.$user->username, (array)$user->errors());
    } else {
      Log::info('Created user "'.$user->username.'" <'.$user->email.'>');
    }*/

    /*$data = array('name' => 'Selma', 
      'lastname' => 'Bouvier',
      'mothersname' => '',
      'birthdate' => new DateTime(),
      'gender' => 1,
      'phone' => '132456',
      'email' => 'selma@gmail.com');

    $personId = $this->personRepository->store($data);

    $user = new s4h\core\User;
    $user->person_id = $personId;
    $user->username = 'selmabouvier';
    $user->email = 'selma@gmail.com';
    $user->password = 'Secret1234';
    $user->password_confirmation = 'Secret1234';
    $user->confirmation_code = md5(uniqid(mt_rand(), true));


    if(! $user->save()) {
      Log::info('Unable to create user '.$user->username, (array)$user->errors());
    } else {
      Log::info('Created user "'.$user->username.'" <'.$user->email.'>');
    }*/

    /*$data = array('name' => 'Herb', 
      'lastname' => 'Simpson',
      'mothersname' => '',
      'birthdate' => new DateTime(),
      'gender' => 1,
      'phone' => '132456',
      'email' => 'herb@gmail.com');

    $personId = $this->personRepository->store($data);

    $user = new s4h\core\User;
    $user->person_id = $personId;
    $user->username = 'herbsimpson';
    $user->email = 'herb@gmail.com';
    $user->password = 'Secret1234';
    $user->password_confirmation = 'Secret1234';
    $user->confirmation_code = md5(uniqid(mt_rand(), true));


    if(! $user->save()) {
      Log::info('Unable to create user '.$user->username, (array)$user->errors());
    } else {
      Log::info('Created user "'.$user->username.'" <'.$user->email.'>');
    }*/

    /*$data = array('name' => 'Tyrone', 
      'lastname' => 'Simpson',
      'mothersname' => '',
      'birthdate' => new DateTime(),
      'gender' => 1,
      'phone' => '132456',
      'email' => 'tyrone@gmail.com');

    $personId = $this->personRepository->store($data);

    $user = new s4h\core\User;
    $user->person_id = $personId;
    $user->username = 'tyronesimpson';
    $user->email = 'tyrone@gmail.com';
    $user->password = 'Secret1234';
    $user->password_confirmation = 'Secret1234';
    $user->confirmation_code = md5(uniqid(mt_rand(), true));


    if(! $user->save()) {
      Log::info('Unable to create user '.$user->username, (array)$user->errors());
    } else {
      Log::info('Created user "'.$user->username.'" <'.$user->email.'>');
    }*/

    $data = array('name' => 'Cyrus', 
      'lastname' => 'Simpson',
      'mothersname' => '',
      'birthdate' => new DateTime(),
      'gender' => 1,
      'phone' => '132456',
      'email' => 'cyrus@gmail.com');

    $personId = $this->personRepository->store($data);

    $user = new s4h\core\User;
    $user->person_id = $personId;
    $user->username = 'cyrussimpson';
    $user->email = 'cyrus@gmail.com';
    $user->password = 'Secret1234';
    $user->password_confirmation = 'Secret1234';
    $user->confirmation_code = md5(uniqid(mt_rand(), true));


    if(! $user->save()) {
      Log::info('Unable to create user '.$user->username, (array)$user->errors());
    } else {
      Log::info('Created user "'.$user->username.'" <'.$user->email.'>');
    }
  }
}

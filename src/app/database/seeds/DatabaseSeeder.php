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
    $data = array('name' => 'Bart', 
      'lastname' => 'Simpson',
      'mothersname' => 'Bouvier',
      'birthdate' => new DateTime(),
      'gender' => 1,
      'phone' => '132456',
      'email' => 'bart@gmail.com');

    $personId = $this->personRepository->store($data);

    $user = new s4h\core\User;
    $user->person_id = $personId;
    $user->username = 'bartsimpson';
    $user->email = 'bart@gmail.com';
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

<?php
use s4h\core\UserRepositoryInterface;
use s4h\core\RoleRepositoryInterface;
use s4h\core\CountryRepositoryInterface;
use s4h\core\PersonRepositoryInterface;
use s4h\core\SuburbRepositoryInterface;
use s4h\social\GroupRepositoryInterface;

/*
|--------------------------------------------------------------------------
| Confide Controller Template
|--------------------------------------------------------------------------
|
| This is the default Confide controller template for controlling user
| authentication. Feel free to change to your needs.
|
 */

class UserController extends BaseController {

	protected $user;
    protected $role;
    protected $person;
    protected $country;
    protected $suburb;

	public function __construct(
        UserRepositoryInterface $user,
        RoleRepositoryInterface $role,
        PersonRepositoryInterface $person,
        CountryRepositoryInterface $country,
        SuburbRepositoryInterface $suburb,
        GroupRepositoryInterface $group) {

		$this->user = $user;
        $this->role = $role;
        $this->person = $person;
        $this->country = $country;
        $this->suburb = $suburb;
        $this->group = $group;
	}

	public $profiles = array(
		1 => 'Administrator',
		2 => 'Limited access',
		3 => 'No access',
	);

	/**
	 * Displays the form for account creation
	 *
	 */
	public function create() {

		return View::make('users.create');
	}

	/**
	 * Stores new account
	 *
	 */
	public function store() {

		$u = $this->user->create(Input::all());

		if ($u->id) {
			$notice = Lang::get('confide::confide.alerts.account_created') . ' ' . Lang::get('confide::confide.alerts.instructions_sent');

			// Redirect with success message, You may replace "Lang::get(..." for your custom message.
			return Redirect::action('UserController@login')
				->with('notice', $notice);
		} else {
			// Get validation errors (see Ardent package)
			$error = $u->errors()->all(':message');

			return Redirect::action('UserController@login')
				->withInput(Input::except('password'))
				->with('error', $error);
		}
	}

	/**
	 * Displays the login form
	 *
	 */
	public function login() {	
		if (Confide::user()) {
			return Redirect::to('/tree');
		} else {
			//return View::make(Config::get('confide::login_form'));
			return View::make('login/index');
		}
	}

	/**
	 * Attempt to do login
	 *
	 */
	public function do_login() {
		$input = array(
			'email' => Input::get('email'), // May be the username too
			'username' => Input::get('email'), // so we have to pass both
			'password' => Input::get('password'),
			'remember' => Input::get('remember'),
		);

		// If you wish to only allow login from confirmed users, call logAttempt
		// with the second parameter as true.
		// logAttempt will check if the 'email' perhaps is the username.
		// Get the value from the config file instead of changing the controller
		if (Confide::logAttempt($input, Config::get('confide::signup_confirm'))) {
			// Verificamos si debemos de enviarlo al wizard de registro
			// Antes de mandarlo a la ruta deseada

			$person = Auth::user()->Person;
			
            if ($person->name = '') {
				// Si no tiene registro en la tabla userdetails
				return Redirect::to('/confirm');
			} else {
                // Redirect the user to the URL they were trying to access before
                // caught by the authentication filter IE Redirect::guest('user/login').
                // Otherwise fallback to '/'
                // Fix pull #145
				return Redirect::intended('/');// change it to '/admin', '/dashboard' or something
			}
		} else {
			$user = new \s4h\core\User;
			// Check if there was too many login attempts
			if (Confide::isThrottled($input)) {
				$err_msg = Lang::get('confide::confide.alerts.too_many_attempts');
			} elseif ($user->checkUserExists($input) and !$user->isConfirmed($input)) {
				$err_msg = Lang::get('confide::confide.alerts.not_confirmed');
			} else {
				$err_msg = Lang::get('confide::confide.alerts.wrong_credentials');
			}

			return Redirect::action('UserController@login')
				->withInput(Input::except('password'))
				->with('error', $err_msg);
		}
	}

	/**
	 * Attempt to confirm account with code
	 *
	 * @param    string  $code
	 */
	public function confirm($code) {
		if (Confide::confirm($code)) {
			$notice_msg = Lang::get('confide::confide.alerts.confirmation');
			return Redirect::action('UserController@login')
				->with('notice', $notice_msg);
		} else {
			$error_msg = Lang::get('confide::confide.alerts.wrong_confirmation');
			return Redirect::action('UserController@login')
				->with('error', $error_msg);
		}
	}

	/**
	 * Displays the forgot password form
	 *
	 */
	public function forgot_password() {
		//return View::make(Config::get('confide::forgot_password_form'));
		return View::make('users.forgot_password');
	}

	/**
	 * Attempt to send change password link to the given email
	 *
	 */
	public function do_forgot_password() {
		if (Confide::forgotPassword(Input::get('email'))) {
			$notice_msg = Lang::get('confide::confide.alerts.password_forgot');
			return Redirect::action('UserController@login')
				->with('notice', $notice_msg);
		} else {
			$error_msg = Lang::get('confide::confide.alerts.wrong_password_forgot');
			return Redirect::action('UserController@forgot_password')
				->withInput()
				->with('error', $error_msg);
		}
	}

	/**
	 * Shows the change password form with the given token
	 *
	 */
	public function reset_password($token) {
		/*return View::make(Config::get('confide::reset_password_form'))
		->with('token', $token);*/
		return View::make('users.reset_password')
			->with('token', $token);
	}

	/**
	 * Attempt change password of the user
	 *
	 */
	public function do_reset_password() {
		$input = array(
			'token' => Input::get('token'),
			'password' => Input::get('password'),
			'password_confirmation' => Input::get('password_confirmation'),
		);

		// By passing an array with the token, password and confirmation
		if (Confide::resetPassword($input)) {
			$notice_msg = Lang::get('confide::confide.alerts.password_reset');
			return Redirect::action('UserController@login')
				->with('notice', $notice_msg);
		} else {
			$error_msg = Lang::get('confide::confide.alerts.wrong_password_reset');
			return Redirect::action('UserController@reset_password', array('token' => $input['token']))
				->withInput()
				->with('error', $error_msg);
		}
	}

	/**
	 * Log the user out of the application.
	 *
	 */
	public function logout() {
		Confide::logout();

		return Redirect::to('login');
	}

	/**
	 * Detalles de los usuarios recientemente registrados.
	 *
	 */
	public function detail() {
		$person =  Auth::user()->Person;
		$family = $this->person->getFamilyByPersonId($person->id);
        $roles = $this->role->getAll();
		$countries = $this->country->getAll();
		$zipcode = $family->Suburb->ZipCode;
		$county = $family->Suburb->City->County;
		$state = $county->State;
		$suburbs = $this->suburb->getSuburbsByZipCodeId($zipcode->id);//DB::table('suburbs')->where('zipcode_id', $zipcode->id)->orderBy('name', 'asc')->lists('name', 'id');

		return View::make('users.detail', array('userdetail' => $person, 'familie' => $family, 'countries' => $countries, 'zipcode' => $zipcode, 'county' => $county, 'state' => $state, 'suburbs' => $suburbs, 'roles' => $roles));
	}

	/**
	 * POST de la funcion anterior.
	 *
	 */
	public function detail_post() {
		$result = array('x' => 0, 'y' => 0, 'z' => 0);

        $person =  Auth::user()->Person;
        $family = $this->person->getFamilyByPersonId($person->id);

        if ($this->person->updateFamily($family->id, Input::all())) {
            if ($this->person->updatePerson($person->id, Input::all())) {
                $result['x'] = 1;
            }
        }

		$json = json_encode($result);

		return View::make('users.detail_post', array('json' => $json));
	}

	/**
	 * Permite cambiar la foto del usuario.
	 *
	 */
	public function picture() {
		return View::make('users.picture');
	}

	/**
	 * POST de la funcion anterior.
	 *
	 */
	public function picture_post($id) {
		$input = Input::all();

		$rules = array(
			'file' => 'image|max:3000',
		);

		$validation = Validator::make($input, $rules);

		if ($validation->fails()) {
			return Response::json('error', 400);
		} else {
			$extension = Input::file('file')->getClientOriginalExtension();
			$directory = public_path() . '/assets/klve3469';
			$filename = sha1(time() . time()) . ".{$extension}";

			$upload_success = Input::file('file')->move($directory, $filename);

			if ($upload_success) {
				//Validar permiso para editar usuario
				$userdetail = User::find($id)->userdetail;
				$userdetail->photo = $filename;
				$userdetail->save();

				return Response::json('success', 200);
			} else {
				return Response::json('error', 400);
			}
		}
	}

	/**
	 * ABC de los mienbros de la familia.
	 *
	 */
	public function members() {
        $person =  Auth::user()->Person;
        $family = $this->person->getFamilyByPersonId($person->id);
        $members = $this->group->getGroupMembers($family->group_id);

		return View::make('users.members', array('members' => $members));
	}

	/**
	 * Add de los mienbros de la familia.
	 *
	 */
	public function members_add() {
		$roles = DB::table('roles')->orderBy('position', 'asc')->lists('name', 'id');

		return View::make('users.members_add', array('roles' => $roles, 'profiles' => $this->profiles));
	}

	/**
	 * POST de la funcion anterior.
	 *
	 */
	public function members_add_post() {
		//Validar que tenga permisos de agregar
		$result = array('x' => 0, 'y' => 0, 'z' => 0);

		$user = new User;

		//Validar que el dominio no sea localhost pq no pasa la validacion del correo
		if ($_SERVER['SERVER_NAME'] == 'localhost') {
			$correo = uniqid(mt_rand(10, 99)) . '@' . $_SERVER['SERVER_NAME'] . '.com';
		} else {
			$correo = uniqid(mt_rand(10, 99)) . '@' . $_SERVER['SERVER_NAME'];
		}

		$user->username = $correo;
		$user->email = $user->username;
		$user->password = uniqid(mt_rand(10, 99));
		$user->password_confirmation = $user->password;
		$user->username_confirmation = $user->username;

		//Validar que el usuario le esta dando acceso al sistema
		if (Input::get('profile') <= 2) {
			$user->username = Input::get('email');
			$user->username_confirmation = $user->username;
			$user->email = Input::get('email');
			$user->password = Input::get('password');
			$user->password_confirmation = Input::get('confirm');
		}

		$user->save();

		if ($user->id) {
			//Agrega el detalle del usuario
			$userdetail = new Userdetail;
			$userdetail->date_of_birth = Input::get('date_of_birth');
			$userdetail->sex = Input::get('sex');
			$userdetail->role_id = Input::get('role');
			$userdetail->name = Input::get('name');
			$userdetail->lastname = Input::get('lastname');
			$userdetail->mothersname = Input::get('mothersname');
			$userdetail->cellphone = Input::get('cellphone');
			$userdetail->familie_id = Auth::user()->userdetail->familie_id;
			$userdetail->user_id = $user->id;
			$userdetail->confirmed = 1;
			$userdetail->photo = 'default.jpg';
			$userdetail->profile = Input::get('profile');

			$userdetail->save();

			if ($userdetail->id) {
				$result['x'] = 1;
				$result['y'] = $user->id;
			}
		}

		$json = json_encode($result);
		return View::make('json', array('json' => $json));
	}

	/**
	 * Edit de los mienbros de la familia.
	 *
	 */
	public function members_edit($id) {
		$user = User::find($id);

		$roles = DB::table('roles')->orderBy('position', 'asc')->lists('name', 'id');

		//Verifica que el usuario exista
		if ($user) {
			//Determinar si el usuario tiene acceso al sistema

			return View::make('users.members_edit', array('roles' => $roles, 'profiles' => $this->profiles, 'user' => $user));
		} else {
			return Redirect::action('UserController@members');
		}
	}

	/**
	 * POST de la funcion anterior.
	 *
	 */
	public function members_edit_post($id) {
		//Validar que tenga permisos de editar usuarios
		$result = array('x' => 0, 'y' => 0, 'z' => 0);

		$user = User::find($id);

		$userChanged = false;
		$canContinue = true;
		$pasos = array(0, 0, 0, 0, 0, 0);

		//Solo quiere cambiar la contraseña
		if ($user->password != Input::get('password') && Input::get('password') != '') {
			$user->password = Input::get('password');
			$user->password_confirmation = Input::get('confirm');
			$user->username_confirmation = $user->username;
			$userChanged = true;
			$pasos[0] = 1;
		}

		//Solo quiere cambiar el correo
		if ($user->email != Input::get('email') && Input::get('email') != '') {
			$user->username = Input::get('email');
			$user->username_confirmation = Input::get('email');
			$user->email = Input::get('email');
			$user->confirmed = 0;

			$userChanged = true;
			$pasos[1] = 1;
		}

		//Solo quieren quitar el acceso
		if (Input::get('profile') == 3 && $user->userdetail->profile != Input::get('profile')) {
			//Validar que el dominio no sea localhost pq no pasa la validacion del correo
			if ($_SERVER['SERVER_NAME'] == 'localhost') {
				$correo = uniqid(mt_rand(10, 99)) . '@' . $_SERVER['SERVER_NAME'] . '.com';
			} else {
				$correo = uniqid(mt_rand(10, 99)) . '@' . $_SERVER['SERVER_NAME'];
			}

			$user->username = $correo;
			$user->username_confirmation = $correo;
			$user->email = $correo;
			$password = uniqid(mt_rand(10, 99));
			$user->password = $password;
			$user->password_confirmation = $password;
			$user->confirmed = 0;
			$userChanged = true;
			$pasos[2] = 1;
		}

		if ($userChanged) {
			if ($user->save()) {
				$pasos[3] = 1;
				if ($pasos[1]) {
					//$view = static::$app['config']->get('confide::email_account_confirmation');
					//$this->sendEmail( 'confide::confide.email.account_confirmation.subject', $view, array('user' => $user) );

					$pasos[4] = 1;
				}
			} else {
				$canContinue = false;
				$pasos[5] = 1;
			}
		}

		//Verifica que el usuario exista
		if ($user && $canContinue) {
			$user->userdetail->date_of_birth = Input::get('date_of_birth');
			$user->userdetail->sex = Input::get('sex');
			$user->userdetail->role_id = Input::get('role');
			$user->userdetail->name = Input::get('name');
			$user->userdetail->lastname = Input::get('lastname');
			$user->userdetail->mothersname = Input::get('mothersname');
			$user->userdetail->cellphone = Input::get('cellphone');
			$user->userdetail->profile = Input::get('profile');

			if ($user->userdetail->save()) {
				$result['x'] = 1;
				$result['y'] = $id;
			}
		}

		//$result['z'] = array('error' => $user->errors()->all(), 'user' => $user, 'pasos' => $pasos, 'pass' => $user->getAuthPassword());
		$json = json_encode($result);
		return View::make('json', array('json' => $json));
	}

	/**
	 * Cambiar contraseña del usuario.
	 *
	 */
	public function change_password() {
		return View::make('users.change_password');
	}

	/**
	 * POST de la funcion anterior.
	 *
	 */
	public function change_password_post() {
		$result = array('x' => 0, 'y' => 0, 'z' => 0);

		$oldpassword = Input::get('current');
		$newpassword = Input::get('password');
		$repassword = Input::get('confirm');

		$hash = Auth::user()->password;
		$value = $oldpassword;

		if (crypt($value, $hash) === $hash && $newpassword === $repassword) {
			$passw = Hash::make($newpassword);

			DB::table('users')
				->where('id', Auth::user()->id)
				->update(array('password' => $passw, 'confirmation_code' => $passw));

			$result['x'] = 1;
		}

		$json = json_encode($result);
		return View::make('json', array('json' => $json));
	}

	/**
	 * Cambiar informacion personal del usuario.
	 *
	 */
	public function profile() {
		$userdetail = User::find(Auth::user()->id)->userdetail;

		return View::make('users.profile', array('userdetail' => $userdetail));
	}

	/**
	 * POST de la funcion anterior.
	 *
	 */
	public function profile_post() {
		$result = array('x' => 0, 'y' => 0, 'z' => 0);

		$userdetail = User::find(Auth::user()->id)->userdetail;

		$userdetail->name = Input::get('name');
		$userdetail->lastname = Input::get('lastname');
		$userdetail->mothersname = Input::get('mothersname');
		$userdetail->date_of_birth = Input::get('date_of_birth');
		$userdetail->sex = Input::get('sex');
		$userdetail->cellphone = Input::get('cellphone');

		if ($userdetail->save()) {
			$result['x'] = 1;
		}

		$json = json_encode($result);
		return View::make('json', array('json' => $json));
	}

	/**
	 * Cambiar informacion de la familia.
	 *
	 */
	public function family() {
		$familie = Auth::user()->Person->Family;

		$countries = DB::table('countries')->orderBy('name', 'asc')->lists('name', 'id');

		$zipcode = User::find(Auth::user()->id)->userdetail->familie->zipcode;

		$county = User::find(Auth::user()->id)->userdetail->familie->suburb->citie->countie;

		$state = User::find(Auth::user()->id)->userdetail->familie->suburb->citie->countie->state;

		$suburbs = DB::table('suburbs')->where('zipcode_id', $familie->zipcode_id)->orderBy('name', 'asc')->lists('name', 'id');

		return View::make('users.family', array('familie' => $familie, 'countries' => $countries, 'zipcode' => $zipcode, 'county' => $county, 'state' => $state, 'suburbs' => $suburbs));
	}

	/**
	 * POST de la funcion anterior.
	 *
	 */
	public function family_post() {
		$result = array('x' => 0, 'y' => 0, 'z' => 0);

		$familie = Auth::user()->Person->Family;

		$familie->name = Input::get('familyname');
		$familie->street = Input::get('street');
		$familie->numberext = Input::get('numberext');
		$familie->numberint = Input::get('numberint');
		$familie->phone = Input::get('phone');
		$familie->countrie_id = Input::get('country');
		$familie->zipcode_id = Input::get('zipcode');
		$familie->suburb_id = Input::get('suburb');

		if ($familie->save()) {
			$result['x'] = 1;
		}

		$json = json_encode($result);
		return View::make('json', array('json' => $json));
	}

	/**
	 * POST de la funcion anterior.
	 *
	 */
	function _userAge($format, $start, $end = false) {
		// Checks $start and $end format (timestamp only for more simplicity and portability)
		if (!$end) {$end = date('Y-m-d H:i:s');}

		$d_start = new DateTime($start);
		$d_end = new DateTime($end);
		$diff = $d_start->diff($d_end);
		// return all data
		//$this->year    = $diff->format('%y');
		//$this->month    = $diff->format('%m');
		//$this->day      = $diff->format('%d');
		//$this->hour     = $diff->format('%h');
		//$this->min      = $diff->format('%i');
		//$this->sec      = $diff->format('%s');
		return $diff->format('%' . $format);
	}
}
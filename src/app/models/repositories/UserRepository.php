<?php
/**
 * UserRepository.php
 * 
 *  Hides Eloquent methods in model specific getters.
 *
 *  @category Models
 *  @author   Federico Rossi <rossi.federico.e@gmail.com>
 *
 */

namespace App\Models\Repositories;

use \App\Models\User;

class UserRepository extends BaseRepository {

    protected $modelClassName = 'User';

    const EMAIL_FIELD = 'email';
    

    /**
     * Finds the first user that matches the email supplied.
     * 
     * @return User
     */
    public function findByEmail($email = null)
    {
        if(is_null($email)) {
            return null;
        }

        $where = call_user_func_array("{$this->modelClassName}::where", array(self::EMAIL_FIELD, '=', $email));
        $users = $where->get();

        if (count($users) === 1) {
            return $users[0];
        }

        return null;
    }

    public function findById ($id = null) {
        if(!is_null($id)) {
            return User::find($id);
        }
    }
    
    public function findByUsername($username = null)
    {
        if (is_null($username)) {
            return null;
        }

        return self::findByEmail($username);
    }
}
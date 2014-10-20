<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 15/10/14
 * Time: 23:20
 */

namespace s4h\core;


/**
 * Class DbRoleRepositoryInterface
 * @package s4h\core
 */
class DbRoleRepository implements RoleRepositoryInterface {
    /**
     * Gets all the Roles from DB
     * @return Role collection
     */
    public function getAll() {
        return Role::orderBy('position', 'asc')->get();
    }
} 
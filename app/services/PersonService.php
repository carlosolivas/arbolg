<?php

/**
 *  PersonServiceService.php
 *
 *  @category Services
 *  @package  ArbolG
 *  @author   Kiwing IT Solutions <info@kiwing.net>
 *  @author   Federico Rossi <rossi.federico.e@gmail.com>
 *  @license  undefined 
 *  @version  0.1
 *  @link     https://github.com/kiwing-it/arbolg  
 *
 */

namespace App\Services;

use App\Models\Person;

class PersonService extends BaseService 
{
	protected $repository = null;

	public function setRepository() 
    {
        $this->repository = Person::all();
    }

    public function repository() 
    {
        return $this->repository;
    }

    public function findAllPersons() {
        return $this->repository;
    }
}
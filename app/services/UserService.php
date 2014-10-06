<?php
/**
 *  UserService.php
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

Class UserService extends BaseService
{
	protected $repository = null;

	public function setRepository($repo) 
    {
        $this->repository = $repo;
    }

    public function findById($id) 
    {
        return $this->repository->findById($id);
    }

    public function repository() 
    {
        return $this->repository;
    }
}
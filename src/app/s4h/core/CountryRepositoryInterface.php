<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 15/10/14
 * Time: 23:38
 */

namespace s4h\core;


/**
 * Interface CountryRepositoryInterface
 * @package s4h\core
 */
interface CountryRepositoryInterface {

    /**
     * @return mixed
     */
    public function getAll();

    /**
     * @param $countryId
     *
     * @return State[]
     */
    public function getStates($countryId);
} 
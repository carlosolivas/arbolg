<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 16/10/14
 * Time: 00:11
 */

namespace s4h\core;


/**
 * Interface SuburbRepositoryInterface
 * @package s4h\core
 */
interface SuburbRepositoryInterface {
    /**
     * @param $suburbId
     *
     * @return City[]
     */
    public function getCity($suburbId);

    /**
     * @param $suburbId
     *
     * @return Zipcode
     */
    public function getZipcode($suburbId);

    public function getSuburbsByZipCodeId($zipcodeid);
} 
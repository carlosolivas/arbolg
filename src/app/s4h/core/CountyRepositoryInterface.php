<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 15/10/14
 * Time: 23:55
 */

namespace s4h\core;


/**
 * Class CountyRepositoryInterface
 * @package s4h\core
 */
interface CountyRepositoryInterface {
    /**
     * @param $countyId
     */
    public function getState($countyId);

    /**
     * @param $countyId
     */
    public function getCities($countyId);
} 
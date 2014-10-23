<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 15/10/14
 * Time: 23:48
 */

namespace s4h\core;


/**
 * Interface StateRepositoryInterface
 * @package s4h\core
 */
interface StateRepositoryInterface {
    /**
     * @param $stateId
     *
     * @return Country[]
     */
    public function getCountry($stateId);

    /**
     * @param $stateId
     *
     * @return County[]
     */
    public function getCounties($stateId);
} 
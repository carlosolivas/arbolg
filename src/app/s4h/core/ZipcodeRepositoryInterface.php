<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 16/10/14
 * Time: 00:16
 */

namespace s4h\core;


/**
 * Interface ZipcodeRepositoryInterface
 * @package s4h\core
 */
interface ZipcodeRepositoryInterface {
    /**
     * @param $zipcodeId
     *
     * @return Country
     */
    public function getCountry($zipcodeId);

    /**
     * @param $zipcodeId
     *
     * @return Suburb[]
     */
    public function getSuburbs($zipcodeId);
} 
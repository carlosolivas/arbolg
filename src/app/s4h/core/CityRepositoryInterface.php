<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 16/10/14
 * Time: 00:05
 */

namespace s4h\core;


/**
 * Interface CityRepositoryInterface
 * @package s4h\core
 */
interface CityRepositoryInterface {
    /**
     * @param $cityId
     *
     * @return County[]
     */
    public function getCounty($cityId);

    /**
     * @param $cityId
     *
     * @return Suburb[]
     */
    public function getSuburbs($cityId);
}
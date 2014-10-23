<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 15/10/14
 * Time: 23:57
 */

namespace s4h\core;


/**
 * Class DbCountyRepository
 * @package s4h\core
 */
class DbCountyRepository implements CountyRepositoryInterface{
    /**
     * @param $countyId
     */
    public function getState($countyId)
    {
        $county = County::find($countyId);
        return  State::where('county_id', '=', $county->state_id);
    }

    /**
     * @param $countyId
     */
    public function getCities($countyId)
    {
        return City::where('countie_id', '=', $countyId);
    }

} 
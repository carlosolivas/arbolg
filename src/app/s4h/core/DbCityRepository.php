<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 16/10/14
 * Time: 00:07
 */

namespace s4h\core;


class DbCityRepository implements CityRepositoryInterface{
    /**
     * @param $cityId
     *
     * @return County[]
     */
    public function getCounty($cityId)
    {
        $city = City::find($cityId);
        return County::find($city->county_id);
    }

    /**
     * @param $cityId
     *
     * @return Suburb[]
     */
    public function getSuburbs($cityId)
    {
        return Suburbs::where('citie_id', '=', $cityId);
    }

} 
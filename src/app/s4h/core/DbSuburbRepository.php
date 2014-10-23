<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 16/10/14
 * Time: 00:13
 */

namespace s4h\core;


class DbSuburbRepository implements SuburbRepositoryInterface {
    /**
     * @param $suburbId
     *
     * @return City[]
     */
    public function getCity($suburbId)
    {
        $suburb = Suburb::find($suburbId);
        $city = City::find($suburb->id);
    }

    /**
     * @param $suburbId
     *
     * @return Zipcode
     */
    public function getZipcode($suburbId)
    {
        return Suburb::find($suburbId)->Zipcode;
    }

    public function getSuburbsByZipCodeId($zipcodeid)
    {
        return Suburb::where('zipcode_id', '=', $zipcodeid)->get();
    }

} 
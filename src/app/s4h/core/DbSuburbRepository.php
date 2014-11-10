<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 27/10/14
 * Time: 11:09
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
        return $suburb->City;
    }

    /**
     * @param $suburbId
     *
     * @return Zipcode
     */
    public function getZipcode($suburbId)
    {
        $suburb = Suburb::find($suburbId);
        return $suburb->ZipCode;
    }

    public function getSuburbsByZipCodeId($zipcodeid)
    {
        return Suburb::where('zipcode_id', '=', $zipcodeid)->get();
    }

} 
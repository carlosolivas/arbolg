<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 16/10/14
 * Time: 00:19
 */

namespace s4h\core;


class DbZipcodeRepository implements ZipcodeRepositoryInterface {
    /**
     * @param $zipcodeId
     *
     * @return Country
     */
    public function getCountry($zipcodeId)
    {
        $zipcode = Zipcode::find($zipcodeId);
        return Country::find($zipcode->country_id);
    }

    /**
     * @param $zipcodeId
     *
     * @return Suburb[]
     */
    public function getSuburbs($zipcodeId)
    {
        return Suburb::where('zipcode_id', '=', $zipcodeId);
    }

} 
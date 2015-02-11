<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 15/10/14
 * Time: 23:40
 */

namespace s4h\core;


/**
 * Class DbCountryRepository
 * @package s4h\core
 */
class DbCountryRepository implements CountryRepositoryInterface {
    /**
     * @return Country[]
     */
    public function getAll()
    {
        return Country::orderBy('name', 'asc')->lists('name', 'id');
    }

    /**
     * @param $countryId
     *
     * @return State[]
     */
    public function getStates($countryId)
    {
        return State::where('country_id', '=', $countryId)->get();
    }


} 
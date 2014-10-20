<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 15/10/14
 * Time: 23:50
 */

namespace s4h\core;


/**
 * Class DbStateRepository
 * @package s4h\core
 */
class DbStateRepository implements StateRepositoryInterface {
    /**
     * @param $stateId
     *
     * @return Country[]
     */
    public function getCountry($stateId)
    {
        $state = State::find($stateId);
        return Country::find($state->country_id);
    }

    /**
     * @param $stateId
     *
     * @return County[]
     */
    public function getCounties($stateId)
    {
        return County::where('state_id', '=', $stateId);
    }

} 
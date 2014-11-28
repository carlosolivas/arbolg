<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 11/11/14
 * Time: 23:50
 */

namespace s4h\Facades;


use Illuminate\Support\Facades\Facade;

class Sharing extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'sharing';
    }

} 
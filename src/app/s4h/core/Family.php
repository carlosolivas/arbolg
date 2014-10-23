<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 19/10/14
 * Time: 12:42
 */

namespace s4h\core;


class Family extends \Eloquent {

    protected $table = 'families';

    public function Suburb() {
        return $this->belongsTo('s4h\core\Suburb');
    }

    public function Group() {
        return $this->belongsTo('Group', 'group_id', 'Id');
    }
} 
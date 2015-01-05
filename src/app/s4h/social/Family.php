<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 28/10/14
 * Time: 15:46
 */

namespace s4h\social;


class Family extends \Eloquent {
    protected $fillable = [];

    protected $table = 'families';

    public function Suburb() {
        return $this->belongsTo('s4h\core\Suburb');
    }

    public function Groups() {
        return $this->hasMany('s4h\social\Group');
    }

    public function getGroup() {
        return Group::where('GroupTypeId', '=', 1)
            ->where('family_id', '=', $this->id)
            ->first();
    }
} 
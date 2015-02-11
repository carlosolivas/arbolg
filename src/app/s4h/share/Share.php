<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 12/11/14
 * Time: 23:19
 */

namespace s4h\share;


class Share extends \Eloquent {

    protected $fillable = [];

    protected $table = 'shares';

    public function ShareOptions()
    {
        return $this->hasMany('s4h\share\ShareOption');
    }

    public function SharedWith()
    {
        return $this->hasMany('s4h\share\ShareDetail');
    }

    public function Person()
    {
        return $this->belongsTo('s4h\core\Person');
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 22/11/14
 * Time: 12:38
 */

namespace s4h\share;


class ShareDetail extends \Eloquent {

    protected $fillable = [];

    protected $table = 'sharedetails';

    public function Share()
    {
        return $this->belongsTo('s4h\share\Share');
    }
} 
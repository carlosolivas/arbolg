<?php
/**
 * Created by PhpStorm.
 * User: carlosolivas
 * Date: 15/11/14
 * Time: 14:48
 */

namespace s4h\share;


class ShareOption extends \Eloquent{

    protected $fillable = [];

    protected $table = 'shareoptions';

    public function Share()
    {
        return $this->belongsTo('s4h\share\Share');
    }
} 
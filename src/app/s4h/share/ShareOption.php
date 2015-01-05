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

    public function Details()
    {
        return $this->belongsToMany(
            's4h\share\ShareOption',
            'sharedetail_shareoption',
            'sharedetail_id',
            'shareoption_id')
            ->withPivot('value');
    }
} 
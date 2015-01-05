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

    public function Options()
    {
        return $this->belongsToMany(
            's4h\share\ShareOption',
            'sharedetail_shareoption',
            'sharedetail_id',
            'shareoption_id')
            ->withPivot('value');
    }
} 
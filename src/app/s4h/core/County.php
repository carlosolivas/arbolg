<?php
namespace s4h\core;

/**
 * Class County
 */
class County extends \Eloquent {

    protected $table = 'counties';

    public function State() {
        return $this->belongsTo('s4h\core\State', 'state_id', 'id');
    }
}
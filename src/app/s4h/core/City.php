<?php
namespace s4h\core;

class City extends \Eloquent {
	
	protected $table = 'cities';

    public function County() {
        return $this->belongsTo('s4h\core\County', 'countie_id', 'id');
    }
}
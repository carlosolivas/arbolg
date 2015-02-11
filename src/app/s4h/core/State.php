<?php
namespace s4h\core;

class State extends \Eloquent {
	
	protected $table = 'states';

    public function Country() {
        return $this->belongsTo('s4h\core\Country', 'countrie_id', 'id');
    }
}
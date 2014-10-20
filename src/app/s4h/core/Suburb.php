<?php
namespace s4h\core;

/**
 * Class Suburb
 * @package s4h\core
 */
class Suburb extends \Eloquent {
	
	protected $table = 'suburbs';

    public function City() {
        return $this->belongsTo('s4h\core\City', 'citie_id', 'id');
    }

    public function ZipCode() {
        return $this->belongsTo('s4h\core\Zipcode', 'zipcode_id', 'id');
    }
}
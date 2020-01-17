<?php

class Test_Model extends Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function add() {
		echo 'Added';
	} 
}
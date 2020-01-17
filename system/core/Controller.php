<?php

class Controller {

	public $load;
	public $input;
	
	public function __construct() {

		require SYSTEM_DIR . 'core/Load.php';
		require SYSTEM_DIR . 'core/Input.php';
		$this->load = new Load();
		$this->input = new Input();
	}

}
<?php

class Err extends Controller {

	public $message;

	public function __construct($message) {
		$this->message = $message;
		require APP_DIR . 'views/err/index.php';
	}
}
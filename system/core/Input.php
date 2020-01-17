<?php

class Input {

	public function post($name) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		return $post[$name];
	}

	public function xss_clean($name) {
		$post = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
		return $post[$name];	
	}
}
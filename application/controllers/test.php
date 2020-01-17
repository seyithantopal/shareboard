<?php

class Test extends Controller {
	public function __construct() {
		parent::__construct();
	}

	public function Index() {
		echo 'Test/Index<br>';
		${"file" . '1'} = 'aa';
		echo $file1;
	}
}
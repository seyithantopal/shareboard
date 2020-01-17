<?php

class Home extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function Index() {
		$model = $this->load->model('home');
		$data = $model->show_users();
		$this->load->view('home/index', $data);
	}
}
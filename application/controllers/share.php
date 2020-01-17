<?php

class Share extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function Index() {
		$model = $this->load->model('share');
		$this->load->view('share/index', $model->getShares());
	}

	public function add() {
		@session_start();
		if(isset($_SESSION['user_data']) == false) {
			redirect('share');
		}
		$this->load->view('share/add');

		$title = $this->input->post('title');
		$content = $this->input->post('content');
		$link = $this->input->post('link');
		$id = $_SESSION['user_data']['id'];
		$submit = $this->input->post('submit');

		if($submit) {
			$model = $this->load->model('share');
			$model->addShare($title, $content, $link, $id);
			redirect('share');
		}
	}
}
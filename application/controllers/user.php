<?php

class User extends Controller {

	public function __construct() {
		parent::__construct();
	}

	public function Index() {
		$model = $this->load->model('user');
		$this->load->view('user/index', $model->getUsers());
	}

	public function login() {
		$this->load->view('user/login');

		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$submit = $this->input->post('submit');
		if(isset($submit)) {
			$model = $this->load->model('user');
			$result = $model->login($email, $password);
			if($result == false) {
				redirect('user/login');
			} else {
				$_SESSION['user_data'] = [
					'id' => $result['id'],
					'name' => $result['name'],
					'username' => $result['username'],
					'email' => $result['email']
				];
				redirect('home');
			}
		}
	}

	public function register() {
		$this->load->view('user/register');

		$name = $this->input->post('name');
		$username = $this->input->post('username');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$submit = $this->input->post('submit');

		if(isset($submit)) {
			$model = $this->load->model('user');
			$model->add($name, $email, $password, $username);
			redirect('user/login');
		}
	}

	public function profile($username= null) {
		$model = $this->load->model('user');
		$this->load->view('user/profile', $model->getShares($username));
	}

	public function logout() {
		session_start();
		unset($_SESSION['user_data']);
		redirect('home');
	}
}
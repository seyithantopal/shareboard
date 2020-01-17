<?php

class User_Model extends Model {

	public function __construct() {
		parent::__construct();
	}

	public function login($email, $password) {
		return $this->db->where(['email' => $email, 'password' => $password])->row('users');
	}
	public function add($name, $email, $password, $username) {
		$datas = [
			'name' => $name,
			'email' => $email,
			'password' => $password,
			'username' => $username,
			'register_date' => date("Y/m/d")
		];
		$insert = $this->db->insert('users', $datas);
	}

	public function getUsers() {
		return $this->db->get('users');
	}

	public function getShares($username) {
		$result = $this->db->where(['username' => $username])->row('users');
		$id = $result['id'];
		return $this->db->where(['users.id' => $id])->join(['shares' => 'shares.user_id = users.id'])->order_by('shares.id', 'DESC')->get('users');
	}
}
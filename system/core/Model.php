<?php

class Model {

	public 	$db;
	private $config;

	public $a = 'Deneme';

	public function __construct() {
		$this->config = require APP_DIR . 'config/database.php';

		require SYSTEM_DIR . 'database/Database.php';

		$this->db = Database::init($this->config);
		//$this->db->insert('users', ['id' => '', 'name' => 'adsoyad', 'email' => 'adsoyad@gmail.com', 'password' => '123', 'register_date' => 'now()']);
		//$this->db->where(['name' => 'adsoyad', 'id' => '6'])->delete('users');
		//$this->db->truncate('posts');
		//$this->db->where(['id' => '5'])->update('users',['email' => 'adsoyad@gmail.com']);
		
		/*$query = $this->db->where(['name' => 'adsoyad', 'email' => 'aa@gmail.com'])->get('users');
		foreach($query as $value) {
			echo $value['name'] . '<br>';
		}*/
	}
}
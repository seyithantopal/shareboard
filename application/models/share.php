<?php

class Share_Model extends Model {
	
	public function __construct() {
		parent::__construct();
	}

	public function getShares() {
		return $this->db->order_by('id', 'DESC')->get('shares');
	}

	public function addShare($title, $content, $link, $id) {
		$datas = [
			'title' => $title,
			'content' => $content,
			'link' => $link,
			'user_id' => $id,
			'create_date' => date("Y/m/d")
		];
		$this->db->insert('shares', $datas);
	}
}
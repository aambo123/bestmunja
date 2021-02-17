<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax extends CI_Controller {
	function __construct(){
		parent::__construct();

		$this->load->model('popup_model');
	}

	public function get_popup(){
		$date = date('Y-m-d');
		$list = $this->popup_model->get_popups($date);
		echo json_encode($list);
	}
}

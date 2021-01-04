<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mod_login extends CI_Model{

	function check_login($uname, $pass)
	{
		$password = hash ( "sha256", $pass);
		$this->db->select('*');
		$this->db->from('g5_member');
		$this->db->where('mb_id', $uname);
		$this->db->where('mb_password', $password);

		$this->db->limit(1);
		$query = $this->db->get();

		if($query->num_rows() == 1) {			
			return $query->result();
		} else {
			return false;
		}
	}

	function code_check($code) {

		$this->db->select('*');
		$this->db->from('recommendation');
		$this->db->where('rec_code', $code);

		$this->db->limit(1);
		$query = $this->db->get();

		if($query->num_rows() == 1)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	// Database get reseller code
	function reseller_code_check($reseller_code) {

		$this->db->select('*');
		$this->db->from('g5_member');
		$this->db->where('reseller_code', $reseller_code);

		$this->db->limit(1);
		$query = $this->db->get();

		if($query->num_rows() == 1){
			return true;
		} else {
			return false;
		}
	}
}

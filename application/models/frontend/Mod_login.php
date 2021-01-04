<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mod_login extends CI_Model{
	
	
	
function check_login($uname, $pass)
	  {
          $password = hash ( "sha256", $pass);
				$this->db->select('*');
				$this->db->from('admin');
				$this->db->where('username =', $uname);
				$this->db->where('password =', $password);

				$this->db->limit(1);
				$query = $this->db->get();

				
				if($query->num_rows() == 1)
					{
						
					       return $query->result();
					}
					else
					{
						return false;
					}
	  }	
	
	
}


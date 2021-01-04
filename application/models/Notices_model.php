<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class notices_model extends CI_Model{

  function store($data) {
		$this->db->insert("notice", $data);
	}

	function show() {
		$this->db->select('*');
		$this->db->from('notice');
		$query = $this->db->get();
		return $query->result();
	}

	function edit($id) {
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->from('notice');
		$query = $this->db->get();
		return $query->row();
	}

	function update($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('notice', $data);
	}

	function destroy($id) {
		$this->db->where("id", $id);
		$this->db->delete("notice");
	}

	function notice_rows()
	{
		 $this->db->select('*')
				   ->from('notice');
		 $query = $this->db->get();
		 return $query->num_rows();
	}

	function front_notice($per_pg,$offset)
	{
		 $this->db->select('*')
					 ->from('notice')
					 ->where('use_yn', '1')
				   ->order_by('created_date','desc')
				   ->limit($per_pg,$offset);
		 $query = $this->db->get();
		 return $query->result();
	}

	function login_notice()
	{
		 $this->db->select('*')
					 ->from('notice')
					 ->where('use_yn', '1')
				   ->order_by('created_date','desc')
					 ->limit(3);
		 $query = $this->db->get();
		 return $query->result();
	}
}

<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class links_model extends CI_Model{

  function store($data) {
		$this->db->insert("link", $data);
	}

	function show() {
		$this->db->select('*');
		$this->db->from('link');
		$query = $this->db->get();
		return $query->result();
	}

	function edit($id) {
		$this->db->select('*');
		$this->db->where('id', $id);
		$this->db->from('link');
		$query = $this->db->get();
		return $query->row();
	}

	function update($id, $data)
	{
		$this->db->where('id', $id);
		$this->db->update('link', $data);
	}

	function destroy($id) {
		$this->db->where("id", $id);
		$this->db->delete("link");
	}

	function link_rows()
	{
		 $this->db->select('*')
				   ->from('link');
		 $query = $this->db->get();
		 return $query->num_rows();
	}

	function front_link($per_pg,$offset)
	{
		 $this->db->select('*')
					 ->from('link')
					 ->where('use_yn', '1')
				   ->order_by('created_date','desc')
				   ->limit($per_pg,$offset);
		 $query = $this->db->get();
		 return $query->result();
	}

	function login_link()
	{
		 $this->db->select('*')
					 ->from('link')
					 ->where('use_yn', '1')
				   ->order_by('created_date','desc')
					 ->limit(3);
		 $query = $this->db->get();
		 return $query->result();
	}
}

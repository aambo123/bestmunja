<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class popup_model extends CI_Model{

	function list() {
		$this->db->select('*');
		$this->db->from('popup');
		$query = $this->db->get();
		return $query->result();
	}
	function getPopupOne($id){
		$this->db->select('*');
		$this->db->where('popup_seq', $id);
		$this->db->from('popup');
		$query = $this->db->get();
		return $query->row();
	}


	function update($id, $data)
	{
		$this->db->where('popup_seq', $id);
		$this->db->update('popup', $data);
	}

	function save($data)
	{
		$this->db->insert('popup', $data);
	}

	function destroy($id) {
		$this->db->where("popup_seq", $id);
		$this->db->delete("popup");
	}

	function get_popups($date) {
		$this->db->select('*');
		$this->db->where('start_dt <=', $date);
		$this->db->where('end_dt >', $date);
		$this->db->from('popup');
		$query = $this->db->get();
		return $query->result();
	}

}

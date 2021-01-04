<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class codes_model extends CI_Model{

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
  
  function get_code_count_filter($search_user_id, $search_date, $search_reseller){
		$this->db->select('*');

		$this->db->from('g5_member');

		if ($search_user_id) {
			$this->db->like('mb_id', $search_user_id);
		}
		
		if (isset($search_date) && count($search_date) == 1){
			$firstStart = $search_date[0].' 00:00:00';
			$firstEnd = $search_date[0].' 23:59:59';
			$this->db->where('mb_datetime <',$firstEnd);
			$this->db->where('mb_datetime >',$firstStart);
		}

		if (isset($search_date) && count($search_date) == 2){
			$secondStart = $search_date[0].' 00:00:00';
			$secondEnd = $search_date[1].' 23:59:59';
			$this->db->where("mb_datetime BETWEEN '$secondStart' AND '$secondEnd'");
		}

		if (isset($search_reseller) && $search_reseller != "all") {
			$this->db->where('reseller_code', $search_reseller);
		}

		if ($this->session->userData('user_level') == 'Reseller') {
			$this->db->where('reseller_id', $this->session->userData('id'));
			$this->db->where('mb_no !=', $this->session->userData('id'));
		}
		
		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0) {
			return $total_sold;
		}

		return NULL;
	}


	function search_code_all($search_user_id,$search_date, $search_reseller, $per_pg,$offset){
		$this->db->select('*');

		$this->db->from('g5_member');

		if ($search_user_id) {
			$this->db->like('mb_id', $search_user_id);
		}
		
		if (isset($search_date) && count($search_date) == 1){
			$firstStart = $search_date[0].' 00:00:00';
			$firstEnd = $search_date[0].' 23:59:59';
			$this->db->where('mb_datetime <',$firstEnd);
			$this->db->where('mb_datetime >',$firstStart);
		}

		if (isset($search_date) && count($search_date) == 2){
			$secondStart = $search_date[0].' 00:00:00';
			$secondEnd = $search_date[1].' 23:59:59';
			$this->db->where("mb_datetime BETWEEN '$secondStart' AND '$secondEnd'");
		}

		if (isset($search_reseller) && $search_reseller != "all") {
			$this->db->where('reseller_code', $search_reseller);
		}

		if ($this->session->userData('user_level') == 'Reseller') {
			$this->db->where('reseller_id', $this->session->userData('id'));
			$this->db->where('mb_no !=', $this->session->userData('id'));
		}

		$this->db->limit($per_pg, $offset);
		$this->db->order_by('mb_id','desc');
		$query = $this->db->get();

		// print_r($per_pg);
		// print_r($search_date);
		// die();
		// print_r($this->db->last_query());
		// die();
		return $query->result();
	}
}

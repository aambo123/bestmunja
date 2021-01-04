<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model{

	function __construct() {

		parent::__construct();
	}

	function register($data) {

		$this->db->insert('g5_member', $data);
		return $this->db->insert_id();
	}


	function user_one($id) {

		$this->db->select('*');
		$this->db->from('g5_member');
		$this->db->where('mb_no', $id);
		$query = $this->db->get();
		return $query->row();
	}

	function user_update($id, $data) {

		$this->db->where('mb_no', $id);
		$this->db->update('g5_member', $data);
	}

	function user_delete($id, $data) {
		$this->db->where("mb_no", $id);
		$this->db->update('g5_member', $data);
	}

	function check_cur_pass($id, $pass) {

		$this->db->select('*');
		$this->db->from('g5_member');
		$this->db->where('mb_no', $id);
		$this->db->where('mb_password', $pass);

		$this->db->limit(1);
		$query = $this->db->get();

		if($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	function get_users_count($search_user_id, $search_date, $reseller_code) {

		$this->db->select('*');

		$this->db->from('g5_member');
		$this->db->where('mb_level !=', 'Reseller');

		if ($search_user_id) {
			$this->db->like('g5_member.mb_id', $search_user_id);
		}
		
		if (isset($search_date) && count($search_date) == 1){
			$firstStart = $search_date[0].' 00:00:00';
			$firstEnd = $search_date[0].' 23:59:59';
			$this->db->where('created_date <',$firstEnd);
			$this->db->where('created_date >',$firstStart);
		}

		if (isset($search_date) && count($search_date) == 2){
			$secondStart = $search_date[0].' 00:00:00';
			$secondEnd = $search_date[1].' 23:59:59';
			$this->db->where("created_date BETWEEN '$secondStart' AND '$secondEnd'");
		}


		if($this->session->userData('user_level') == 'Reseller' || !empty($reseller_code)){
			$this->db->where('reseller_code', $reseller_code);
		}
		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0) {
			return $total_sold;
		}

		return NULL;
	}

	function get_users($per_pg,$offset) {

		$this->db->select('*');
		$this->db->from('g5_member');
		$this->db->where('mb_level !=', 'Super admin');
		
		$this->db->limit($per_pg, $offset);

		$this->db->order_by('mb_no','desc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_resellers_customers($reseller_id, $per_pg, $offset) {
		
		$this->db->select('*');
		$this->db->from('g5_member');
		$this->db->where('mb_level !=', 'Super admin');
		$this->db->where('mb_no !=', $this->session->userData('id'));
		$this->db->where('reseller_id', $reseller_id);

		if($per_pg != 'all') {
			$this->db->limit($per_pg, $offset);
		}

		$this->db->order_by('mb_no','desc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_resellers() {

		$this->db->select('*');
		$this->db->from('g5_member');
		if($this->session->userData('user_level') == 'Super admin') {
			$this->db->where('mb_level', 'Reseller');
		} elseif($this->session->userData('user_level') == 'Reseller') {
			$this->db->where('mb_no', $this->session->userData('id'));
		}
		$query = $this->db->get();
		return $query->result();
	}

	function get_all_resellers() {

		$this->db->select('*');
		$this->db->from('g5_member');
		$this->db->where('mb_level', 'Reseller');
		$query = $this->db->get();
		return $query->result();
	}

	function get_user($field, $value) {
		$this->db->select('*');
		$this->db->from('g5_member');
		$this->db->where($field, $value);

		$query = $this->db->get();
		return $query->row();
	}

	function get_user_one($id) {

		$this->db->select('*');
		$this->db->from('g5_member');
		$this->db->where('mb_no', $id);

		$query = $this->db->get();
		return $query->row();
	}

	function get_cs_info() {

		$this->db->select('*');
		$this->db->from('cs_info');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}

	function get_sms_account($id) {

		$this->db->select('*');
		$this->db->from('sms_1s2u_account');
		$this->db->where('id', $id);

		$query = $this->db->get();
		return $query->row();
	}

	function msg_add($data) {

		$this->db->insert('message', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	}

	function msg_update($id, $data) {

		$this->db->where('id', $id);
		$this->db->update('message', $data);
	}

	function msg_detail_add($data) {

		$this->db->insert('message_send_detail', $data);
	}

	function msg_detail_update($id, $phone_number, $data) {

		$this->db->where('message_id', $id);
		$this->db->where('phone_number', $phone_number);
		$this->db->update('message_send_detail', $data);
	}

	function msg_detail_add_batch($data) {

		$this->db->insert_batch('message_send_detail', $data);
	}

	function smsAddRequestSave($data) {

		$this->db->insert('msgaddrequest', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	}



	function smsAddRequets_update($id, $data) {

		$this->db->where('id', $id);
		$this->db->update('msgaddrequest', $data);
	}

	function get_smsAddRequets_count() {

		$this->db->select('*');

		$this->db->from('msgaddrequest');

		if ($this->session->userData('user_level') == 'Reseller') {
			$this->db->join('g5_member','g5_member.mb_no = msgaddrequest.member_id');
			$this->db->where('g5_member.reseller_id', $this->session->userData('id'));
		}

		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0) {
			return $total_sold;
		}

		return NULL;
	}

	function get_smsAddRequets($per_pg,$offset) {

		$this->db->select('*');
		$this->db->from('msgaddrequest');
	
		if ($this->session->userData('user_level') == 'Reseller') {
			$this->db->join('g5_member','g5_member.mb_no = msgaddrequest.member_id');
			$this->db->where('g5_member.reseller_id', $this->session->userData('id'));
		}
		$this->db->limit($per_pg, $offset);
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_member_msg_quantity_by_request($request_id) {

		$this->db->select('*');
		$this->db->from('member_msg_quantity');
		$this->db->where('request_id', $request_id);
		$this->db->limit(1);

		$query = $this->db->get();
		return $query->row();
	}

	function get_smsAddRequetsDetail($id) {

		$this->db->select('msgaddrequest.*');
		$this->db->from('msgaddrequest');
		$this->db->where('id', $id);

		$query = $this->db->get();
		return $query->row();
	}

	function smsAdd_set($data) {

		$this->db->insert('msgaddset', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	}

	function member_msg_quantity_set($data) {

		$this->db->insert('member_msg_quantity', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	}

	function get_member_messages($id, $per_pg,$offset) {

		$this->db->select('*');
		$this->db->from('message');
		$this->db->where('member_id', $id);
		$this->db->where('del', null);
		$this->db->limit($per_pg, $offset);
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		return $query->result();
	}

	function search_member_messages($id,$search, $per_pg,$offset) {

		$this->db->select('*');
		$this->db->from('message');
		$this->db->where('member_id', $id);
	   $this->db->like('message',$search);
		$this->db->limit($per_pg, $offset);
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		return $query->result();
	}

	function count_user_messages($id) {

		$this->db->select('SUM(quantity) AS quantity,SUM(delivered_count) AS delivered_count',FALSE)
					->from('message')
					->where('member_id',$id);
		$query = $this->db->get();
		return $query->row();
	}

	function get_member_message_detail($id) {

		$this->db->select('*');
		$this->db->from('message');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();
	}
	function get_message_send_numbers($id, $per_pg,$offset) {

		$this->db->select('phone_number,code,success');
		$this->db->from('message_send_detail');
		$this->db->where('message_id', $id);
		$this->db->limit($per_pg, $offset);
		$query = $this->db->get();
		return $query->result();
	}
	// function get_message_send_numbers($id)
	// {
	//     $this->db->select('phone_number,code,success');
	//     $this->db->from('message_send_detail');
	//     $this->db->where('message_id', $id);
	//     $query = $this->db->get();
	//     return $query->result();
	//
	// }
	function search_message_send_numbers($id, $per_pg,$offset,$search) {

		$this->db->select('phone_number');
		$this->db->from('message_send_detail');
		$this->db->where('message_id', $id);
		$this->db->like('phone_number', $search);
		$this->db->limit($per_pg, $offset);
		$query = $this->db->get();
		return $query->result();
	}

	function get_message_detail($ids) {

		$this->db->select('id,code,api_message_id,message_id')
		->from('message_send_detail')
		->where_in('message_id',$ids);
		$query = $this->db->get();
		return $query->result();
	}

	function get_message_send_numbers_search($id, $phone_number) {

		$str = substr($phone_number, 3);
		$num = "8210" . $str . "";
		$this->db->select('*');
		$this->db->from('message_send_detail');
		$this->db->where('message_id', $id);
		$this->db->where('phone_number', $num);
		$query = $this->db->get();
		return $query->result();
	}

	function get_member_msg_count($id) {

		$this->db->select('*');
		$this->db->from('message');
		$this->db->where('member_id', $id);
		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0) {
			return $total_sold;
		}

		return NULL;
	}

	function get_send_numbers_count($id) {

		$this->db->select('*');
		$this->db->from('message_send_detail');
		$this->db->where('message_id', $id);
		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0) {
			return $total_sold;
		}

		return NULL;
	}

	function get_today_count($id) {

		$start = date('Y-m-d 00:00:00');
		$end = date('Y-m-d 23:59:59');
		$this->db->select('SUM(message.quantity) as today_count');

		$this->db->from('message');
		$this->db->where('member_id', $id);

		$this->db->where('created_date >', $start);
		$this->db->where('created_date <', $end);
		$total_sold = $this->db->get();

		if ($total_sold->num_rows() > 0)
		{
			return $total_sold->row();
		}

		return NULL;
	}

	function get_month_count($id) {

		$start = date('Y-m-d 00:00:00',strtotime('first day of this month'));
		$end = date('Y-m-d 23:59:59',strtotime('last day of this month'));

		$this->db->select('SUM(message.quantity) as month_count');

		$this->db->from('message');
		$this->db->where('member_id', $id);

		$this->db->where('created_date >', $start);
		$this->db->where('created_date <', $end);
		$total_sold = $this->db->get();

		if ($total_sold->num_rows() > 0) {
			return $total_sold->row();
		}

		return NULL;
	}

	function get_all_count($id)
	{

		$this->db->select('SUM(message.quantity) as all_count');

		$this->db->from('message');
		$this->db->where('member_id', $id);

		$total_sold = $this->db->get();

		if ($total_sold->num_rows() > 0)
		{
			return $total_sold->row();
		}

		return NULL;

	}

	function get_success_msgs($id)
	{

		$this->db->select('*');

		$this->db->from('message_send_detail');
		$this->db->where('message_id', $id);
		$this->db->where('success', 1);
		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0)
		{
			return $total_sold;
		}

		return NULL;
	}

	function get_message($id) {
		$this->db->select('*');
		$this->db->from('message');
		$this->db->where('id', $id);
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();
	}

	function get_pending_msgs($id)
	{

		$this->db->select('*');

		$this->db->from('message_send_detail');
		$this->db->where('message_id', $id);
		$this->db->where('success', 2);

		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0)
		{
			return $total_sold;
		}

		return NULL;

	}
	function get_error_msgs($id)
	{

		$this->db->select('*');

		$this->db->from('message_send_detail');
		$this->db->where('message_id', $id);
		$this->db->where('success', 0);

		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0)
		{
			return $total_sold;
		}

		return NULL;

	}

	function delivery_report_set($data)
	{
		$this->db->insert('delivery_report', $data);
		$insert_id = $this->db->insert_id();

		return  $insert_id;

	}

	function get_msg_count(){
		$this->db->select('*');
		$this->db->from('message');
		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0){
			return $total_sold;
		}

		return NULL;
	}

	function get_msg_count_filter($search_user_id, $search_date, $search_code_customer, $search_code_reseller, $search_code_organization, $search_mb_level){
		$this->db->select('message.*,g5_member.mb_id');
		$this->db->from('message');
		$this->db->join('g5_member','g5_member.mb_no = message.member_id');
		// print_r($search_date);
		// die();
		if ($search_user_id) {
			$this->db->like('g5_member.mb_id', $search_user_id);
		}
		
		if (isset($search_date) && count($search_date) == 1){
			$firstStart = $search_date[0].' 00:00:00';
			$firstEnd = $search_date[0].' 23:59:59';
			$this->db->where('created_date <',$firstEnd);
			$this->db->where('created_date >',$firstStart);
		}

		if (isset($search_date) && count($search_date) == 2){
			$secondStart = $search_date[0].' 00:00:00';
			$secondEnd = $search_date[1].' 23:59:59';
			$this->db->where("created_date BETWEEN '$secondStart' AND '$secondEnd'");
		}

		if ($search_mb_level && $search_mb_level != "all") {
			$this->db->like('g5_member.mb_level', $search_mb_level);
		}

		if ($this->session->userData('user_level') == 'Reseller') {
			$this->db->like('g5_member.reseller_id', $this->session->userData('id'));
		}
		
		if (isset($search_code_customer) && $search_code_customer != "all") {
			$this->db->where('g5_member.mb_code', $search_code_customer);
		}

		if (isset($search_code_reseller) && $search_code_reseller != "all") {
			$this->db->where('g5_member.mb_code', $search_code_reseller);
		}

		if (isset($search_code_organization) && $search_code_organization != "all") {
			$this->db->where('g5_member.mb_code', $search_code_organization);
		}

		$total_sold = $this->db->count_all_results();

		// print_r($total_sold);
		// die();

		if ($total_sold > 0){
			return $total_sold;
		}

		return NULL;
	}

	function get_msg_by_sender($sender)
	{
		$this->db->select('*');
		$this->db->from('message');
		$this->db->where('sender', $sender);
		$this->db->order_by('id','desc');
		$this->db->limit(1);
		$query = $this->db->get();
		return $query->row();

	}

	function search_msg_all($search_user_id,$search_date, $search_code_customer, $search_code_reseller, $search_code_organization, $search_mb_level, $per_pg,$offset){
		$this->db->select('message.*,g5_member.mb_id');
		$this->db->from('message');
		$this->db->join('g5_member','g5_member.mb_no = message.member_id');
		// print_r($search_date);
		// die();
		if ($search_user_id) {
			$this->db->like('g5_member.mb_id', $search_user_id);
		}
		
		if (isset($search_date) && count($search_date) == 1){
			$firstStart = $search_date[0].' 00:00:00';
			$firstEnd = $search_date[0].' 23:59:59';
			$this->db->where('created_date <',$firstEnd);
			$this->db->where('created_date >',$firstStart);
		}

		if (isset($search_date) && count($search_date) == 2){
			$secondStart = $search_date[0].' 00:00:00';
			$secondEnd = $search_date[1].' 23:59:59';
			$this->db->where("created_date BETWEEN '$secondStart' AND '$secondEnd'");
		}

		if ($search_mb_level && $search_mb_level != "all") {
			$this->db->like('g5_member.mb_level', $search_mb_level);
		}

		if ($this->session->userData('user_level') == 'Reseller') {
			$this->db->like('g5_member.reseller_id', $this->session->userData('id'));
		}
		
		if (isset($search_code_customer) && $search_code_customer != "all") {
			$this->db->where('g5_member.mb_code', $search_code_customer);
		}

		if (isset($search_code_reseller) && $search_code_reseller != "all") {
			$this->db->where('g5_member.mb_code', $search_code_reseller);
		}

		if (isset($search_code_organization) && $search_code_organization != "all") {
			$this->db->where('g5_member.mb_code', $search_code_organization);
		}

		$this->db->limit($per_pg, $offset);
		$this->db->order_by('message.id','desc');
		$query = $this->db->get();

		// print_r($per_pg);
		// print_r($search_date);
		// die();
		// print_r($this->db->last_query());
		// die();
		return $query->result();
	}

	function get_msg_all($per_pg,$offset)
	{
		$this->db->select('*');
		$this->db->from('message');
		// Reseller
		if ($this->session->userData('user_level') == 'Reseller') {
			$this->db->join('g5_member','g5_member.mb_no = message.member_id');
			$this->db->where('g5_member.reseller_id', $this->session->userData('id'));
		}
		$this->db->limit($per_pg, $offset);
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		return $query->result();
	}

	function msg_detail_delete($id)
	{

		$this->db->where('message_id', $id);
		$this->db->where('success', 0);
		$this->db->delete('message_send_detail');

	}

	function msg_count_all()
	{
		$this->db->select('message.*');
		$this->db->from('message');
		$this->db->join('message_send_detail', 'message.id = message_send_detail.message_id');
		// Reseller
		if ($this->session->userData('user_level') == 'Reseller') {
			$this->db->join('g5_member','g5_member.mb_no = message.member_id');
			$this->db->where('g5_member.reseller_id', $this->session->userData('id'));
		}
		$this->db->where('message_send_detail.success', 1);
		$this->db->group_by('message_send_detail.id');

		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0) {
			return $total_sold;
		}

		return 0;
	}

	function get_total_revenue(){
		$this->db->select_sum('reseller_revenue');
		$this->db->from('member_msg_quantity');
		$this->db->join('g5_member','g5_member.mb_no = member_msg_quantity.member_id');

		if($this->session->userData('user_level') == 'Reseller') {
			$this->db->where('member_id =', $this->session->userData('id'));
		} else {
			$this->db->where('g5_member.mb_level', 'Reseller');
		}
	
		$query = $this->db->get();
    	return $query->row()->reseller_revenue;
	}

	function get_payment_total($search_user_id, $search_date) {

		$this->db->select('*');
		$this->db->from('member_msg_quantity');
		$this->db->join('g5_member','g5_member.mb_no = member_msg_quantity.member_id');
		$this->db->where('member_msg_quantity.current_quantity > member_msg_quantity.last_quantity');

		$this->payment_filter($search_user_id, $search_date);

		$total_payment = $this->db->count_all_results();

		if ($total_payment > 0) {
			return $total_payment;
		}

		return NULL;
	}

	function payment_filter($search_user_id, $search_date){		
		if ($search_user_id) {
			$this->db->like('g5_member.mb_id', $search_user_id);
		}
		
		if (isset($search_date) && count($search_date) == 1){
			$firstStart = $search_date[0].' 00:00:00';
			$firstEnd = $search_date[0].' 23:59:59';
			$this->db->where('member_msg_quantity.created_date <',$firstEnd);
			$this->db->where('member_msg_quantity.created_date >',$firstStart);
		}

		if (isset($search_date) && count($search_date) == 2){
			$secondStart = $search_date[0].' 00:00:00';
			$secondEnd = $search_date[1].' 23:59:59';
			$this->db->where("member_msg_quantity.created_date BETWEEN '$secondStart' AND '$secondEnd'");
		}
	
		if ($this->session->userData('user_level') == 'Reseller') {
			$this->db->where('g5_member.reseller_id', $this->session->userData('id'));
			$this->db->where('g5_member.mb_level', 'Customer');
		}
		
		if ($this->session->userData('user_level') == 'Super admin') {
			// $this->db->where("g5_member.reseller_id", NULL);
			// $this->db->or_where("g5_member.reseller_id = g5_member.mb_no");
			$this->db->where('(g5_member.reseller_id IS NULL OR g5_member.reseller_id = g5_member.mb_no)', null, false);
		}
	}

	function get_payment_list($search_user_id, $search_date, $per_pg, $offset) {

		$this->db->select('*');
		$this->db->from('member_msg_quantity');
		$this->db->join('g5_member','g5_member.mb_no = member_msg_quantity.member_id');
		$this->db->where('member_msg_quantity.current_quantity > member_msg_quantity.last_quantity');

		$this->payment_filter($search_user_id, $search_date);

		$this->db->limit($per_pg, $offset);
		$this->db->order_by('id','desc');
		$query = $this->db->get();
		// print_r($this->db->last_query());
		// die();
		return $query->result();
	}

	function get_payment_chart($search_user_id, $search_date) {

		$this->db->select('member_id, created_date, SUM(reseller_revenue) AS reseller_revenue, SUM(action_quantity) AS action_quantity, SUM(member_msg_quantity.action_quantity / recommendation.msg_price) AS message_quantity');
		$this->db->from('member_msg_quantity');
		$this->db->join('g5_member','g5_member.mb_no = member_msg_quantity.member_id');
		$this->db->join('recommendation','g5_member.mb_recommend = recommendation.rec_code');
		$this->db->where('member_msg_quantity.current_quantity > member_msg_quantity.last_quantity');

		$this->payment_filter($search_user_id, $search_date);

		$this->db->order_by('created_date','ASC');
		$this->db->group_by('YEAR(created_date), MONTH(created_date), DAY(created_date)');
		$query = $this->db->get();
		// print_r($this->db->last_query());
		// die();
		return $query->result();
	}

	function msg_count_month()
	{
		$start = date('Y-m-d 00:00:00',strtotime('first day of this month'));
		$end = date('Y-m-d 23:59:59',strtotime('last day of this month'));

		$this->db->select('message.*');
		$this->db->from('message');
		$this->db->join('message_send_detail', 'message.id = message_send_detail.message_id');
		// Reseller
		if ($this->session->userData('user_level') == 'Reseller') {
			$this->db->join('g5_member','g5_member.mb_no = message.member_id');
			$this->db->where('g5_member.reseller_id', $this->session->userData('id'));
		}
		$this->db->where('message_send_detail.success', 1);
		$this->db->where('message.created_date >', $start);
		$this->db->where('message.created_date <', $end);
		$this->db->group_by('message_send_detail.id');

		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0) {
			return $total_sold;
		}

		return 0;
	}

	function msg_count_today()
	{
		$start = date('Y-m-d 00:00:00');
		$end = date('Y-m-d 23:59:59');

		$this->db->select('message.*');
		$this->db->from('message');
		$this->db->join('message_send_detail', 'message.id = message_send_detail.message_id');
		// Reseller
		if ($this->session->userData('user_level') == 'Reseller') {
			$this->db->join('g5_member','g5_member.mb_no = message.member_id');
			$this->db->where('g5_member.reseller_id', $this->session->userData('id'));
		}
		$this->db->where('message_send_detail.success', 1);
		$this->db->where('message.created_date >', $start);
		$this->db->where('message.created_date <', $end);
		$this->db->group_by('message_send_detail.id');

		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0)
		{
			return $total_sold;
		}

		return 0;

	}

	function member_msg_count_today($member_id)
	{

		$start = date('Y-m-d 00:00:00');
		$end = date('Y-m-d 23:59:59');
		$this->db->select('message.*');
		$this->db->where('message.created_date >', $start);
		$this->db->where('message.created_date <', $end);
		$this->db->where('message.member_id', $member_id);
		$this->db->from('message');
		$this->db->join('message_send_detail', 'message.id = message_send_detail.message_id');

		$this->db->group_by('message_send_detail.id');
		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0)
		{
			return $total_sold;
		}

		return 0;

	}

	function member_msg_count_all($member_id)
	{
		$this->db->select('*');

		$this->db->select('message.*');

		$this->db->from('message');
		$this->db->where('message.member_id', $member_id);
		$this->db->join('message_send_detail', 'message.id = message_send_detail.message_id');


		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0)
		{
			return $total_sold;
		}

		return 0;

	}

	public function dates($date){
		$return=[];
		$result=[];

		$start_date=strtotime($date['start']. ' 00:00:00');
		$end_date=strtotime($date['end'].' 23:59:59');
		$dates=$start_date;

		while($dates <= $end_date):
			$return['dates'][]=date('Y-m-d', $dates);
			$dates += 86400;
		endwhile;

		$dates=$start_date;
		while($dates <= $end_date):
			$result['data'][]=$this->bnum($this->getDayData($dates));
			$dates += 86400;
		endwhile;

		$return['data'][]=implode(',',  $result['data']);
		$return['dates']=implode(",", $return['dates']);

		return $return;
	}

	public function bnum($num){
		return number_format($num, 2, '.', '');
	}

	function getDayData($dates) {
		$start = date('Y-m-d H:i:s', $dates);
		$end = date('Y-m-d 23:59:59', $dates);

		$this->db->select('message.id');
		$this->db->from('message');
		$this->db->join('message_send_detail', 'message.id = message_send_detail.message_id');
		// Reseller
		if ($this->session->userData('user_level') == 'Reseller') {
			$this->db->join('g5_member','g5_member.mb_no = message.member_id');
			$this->db->where('g5_member.reseller_id', $this->session->userData('id'));
		}
		$this->db->where('message_send_detail.success', 1);
		$this->db->where('message.created_date >', $start);
		$this->db->where('message.created_date <', $end);
		$this->db->group_by('message_send_detail.id');
		$total_sold = $this->db->count_all_results();
		if ($total_sold > 0)
		{
			return $total_sold;
		}
		return NULL;
	}

	function smsRequestsDelete($id)
	{
		$data = array(
			'del' => 1,
		);
		$this->db->where('id', $id);
		$this->db->update('message', $data);

	}
	function smsDetailDelete($id)
	{
		$data = array(
			'del' => 1,
		);
		$this->db->where('message_id', $id);
		$this->db->update('message_send_detail', $data);
	}

	function sms_account_update($id, $msg_limit)
	{
		$data = array(
			'msg_limit' => $msg_limit,

		);
		$this->db->where('id', $id);
		$this->db->update('sms_1s2u_account', $data);

	}

	function sms_account_limit($id)
	{
		$this->db->select('*');
		$this->db->from('sms_1s2u_account');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->row();

	}
	function update_status($id,$code){
		 $data = array(
			'code' => $code,
		);
		$this->db->where('id', $id);
	   $this->db->update('message_send_detail', $data);
	}
	function message_detail_update($sender,$mobile,$data){
		 $this->db->where('sender',$sender);
		$this->db->where('phone_number', $mobile);
	   $this->db->update('message_send_detail', $data);
	}
	function get_msg_data($id)
	{
		 $this->db->select('date(created_date) as created_date')
				  ->select_sum('undelivered_count','undelivered_total')
				  ->select_sum('error_count','error_total')
				  ->select_sum('delivered_count','delivered_total')
				  ->from('message')
				  ->where('member_id', $id)
				  ->group_by('date(created_date)')
				  ->order_by('date(created_date)','desc')
				  ->limit(7,0);
		$query = $this->db->get();
		return $query->result();
	}
	function get_recharge_log($id,$per_pg,$offset)
	{
		 $this->db->select('*')
				   ->from('msgaddrequest')
				   ->where('member_id',$id)
				   ->order_by('created_date','desc')
				   ->limit($per_pg,$offset);
		 $query = $this->db->get();
		 return $query->result();
	}

	function count_recharge($id)
	{
		 $this->db->select('*')
				   ->from('msgaddrequest')
				   ->where('member_id',$id);
		 $query = $this->db->get();
		 return $query->num_rows();
	}

	function get_banned_numbers()
	{
		$this->db->select('phone_number')
			->from('banned_phone_numbers')
			->order_by('id','desc');

		$query = $this->db->get();
		return $query->result();
	}


	function count_result($id) {

		$sqlArray = '(' . join(',', $id) . ')';
		$query = $this->db->query("SELECT message_id AS id,
			-- SUM(CASE WHEN success = '0' THEN 1 ELSE 0 END) AS pending_count,
			SUM(CASE WHEN success = '1' THEN 1 ELSE 0 END) AS delivered_count,
			-- SUM(CASE WHEN success = '2' THEN 1 ELSE 0 END) AS undelivered_count,
			SUM(CASE WHEN success = '3' THEN 1 ELSE 0 END) AS error_count
			FROM message_send_detail where message_id in $sqlArray  group by message_id;");
			
		return $query->result();
	}
	
	function get_daily_report($start,$end) {
		 $this->db->select('DAY(created_date) as created_date')
				   ->select('sum(msg* delivered_count) as cash')
				   ->select_sum('quantity','quantity_total')
				  ->select_sum('undelivered_count','undelivered_total')
				  ->select_sum('error_count','error_total')
				  ->select_sum('pending_count','pending_total')
				  ->select_sum('delivered_count','delivered_total')
				  ->from('message')
				  ->where('created_date >', $start)
				  ->where('created_date <',$end)
				  ->group_by('DAY(created_date)')
				  ->order_by('DAY(created_date)','asc');
		$query = $this->db->get();
		return $query->result();
	}

	function get_monthly_report($start,$end) {
		
		$this->db->select('MONTH(created_date) as created_date')
				   ->select('sum(msg* quantity) as cash')
				   ->select_sum('quantity','quantity_total')
				  ->select_sum('undelivered_count','undelivered_total')
				  ->select_sum('error_count','error_total')
				  ->select_sum('pending_count','pending_total')
				  ->select_sum('delivered_count','delivered_total')
				  ->from('message')
				  ->where('created_date >', $start)
				  ->where('created_date <',$end)
				  ->group_by('YEAR(created_date), MONTH(created_date)')
				  ->order_by('YEAR(created_date), MONTH(created_date)','asc');
		$query = $this->db->get();
		
		return $query->result();
	}

	function get_referral_report($url) {

		$this->db->select('referrer,COUNT(referrer) as count')
							->from('visit')
							//->where('ip !=','127.0.0.1')
							->where('referrer !=','')
							->where('referrer !=',$url)
							->group_by('referrer')
							->order_by('count','desc')
							->limit(10,0);
		$query = $this->db->get();

		return $query->result();
	}

	function get_referral_count($url) {
		
		$this->db->select('referrer,COUNT(referrer) as count')
				->from('visit')
				//->where('ip !=','127.0.0.1')
				->where('referrer !=',$url)
				->where('referrer !=','');
		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0) {
			return $total_sold;
		}

		return 0;
	}
	// function get_visit($start,$end,$mobile){
	//      $this->db->select('MONTH(created_date) as created_date')
	//                ->select_sum('quantity','quantity_total')
	//               ->select_sum('undelivered_count','undelivered_total')
	//               ->select_sum('error_count','error_total')
	//               ->select_sum('pending_count','pending_total')
	//               ->select_sum('delivered_count','delivered_total')
	//               ->from('visit')
	//               ->where('created_date >', $start)
	//               ->where('created_date <',$end)
	//               ->where('mobile')
	//               ->group_by('YEAR(created_date), MONTH(created_date)')
	//               ->order_by('YEAR(created_date), MONTH(created_date)','asc');
	//     $query = $this->db->get();
	//     return $query->result();
	// }
	function get_visit($dates,$mobile) {

		$start = $dates.' 00:00:00';
		$end = $dates.' 23:59:59';
		$this->db->select('*')
				->from('visit')
				->where('created_date >', $start)
				->where('created_date <',$end)
				->where('is_mobile',$mobile);
		$total_sold = $this->db->count_all_results();
			
		if ($total_sold > 0) {
			return $total_sold;
		}
		return 0;
	}

	function get_visit_by($value) {

		$this->db->select("{$value} as name ,COUNT({$value}) as count")
				->from('visit')
				->group_by($value)
				->order_by($value,'desc');
		$query = $this->db->get();
		
		return $query->result();
	}

	function get_visit_count() {
		
		$this->db->select('*')
						->from('visit');
		$total_sold = $this->db->count_all_results();
		
		if ($total_sold > 0) {
			return $total_sold;
		}

		return NULL;
	}


	function get_cash_history($id, $per_pg, $offset) {
		
		$this->db->select('*')
				   ->from('cash_history')
				   ->where('member_id',$id)
					 ->limit($per_pg,$offset)
					 ->order_by('date(created_date)','desc');
		$query = $this->db->get();
		
		return $query->result();
	}

	function get_cash_history_rows($id) {
		 
		$this->db->select('*')
				   ->from('cash_history')
				   ->where('member_id',$id);
		$query = $this->db->get();

		return $query->num_rows();
	}

	function cash_history_add($data) {

		$this->db->insert('cash_history', $data);
	}

	function cash_history_update($id, $data) {

		$this->db->where('member_id', $id);
		$this->db->update('cash_history', $data);
	}

	function get_user_last() {
		
		$this->db->select('*')
				   ->from('g5_member')
					 ->limit(1)
					 ->order_by('mb_no','desc');
		$query = $this->db->get();
		
		return $query->result();
	}

	// Generate random string
	function generateRandomString($length) {
		$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}


	// function get_recharge_log($id)
	// {
	//      $this->db->select('msgaddrequest.total_price,msgaddrequest.num_send,msgaddrequest.created_date,msgaddrequest.status,member_msg_quantity.last_quantity,member_msg_quantity.action_quantity,member_msg_quantity.current_quantity')
	//                ->from('msgaddrequest')
	//                ->join('member_msg_quantity','msgaddrequest.id = member_msg_quantity.request_id')
	//                ->where('msgaddrequest.member_id',$id)
	//                ->order_by('msgaddrequest.created_date','asc');
	//      $query = $this->db->get();
	//      return $query->result();
	// }

	function get_member_count_filter($search_user_id, $search_date, $search_code_customer, $search_code_reseller, $search_code_organization, $search_mb_level){
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

		if ($search_mb_level && $search_mb_level != "all") {
			$this->db->where('mb_level', $search_mb_level);
		}

		if (isset($search_code_customer) && $search_code_customer != "all") {
			$this->db->where('mb_code', $search_code_customer);
		}else if (isset($search_code_reseller) && $search_code_reseller != "all") {
			$this->db->where('mb_code', $search_code_reseller);
		}else if (isset($search_code_organization) && $search_code_organization != "all") {
			$this->db->where('mb_code', $search_code_organization);
		}

		if ($this->session->userData('user_level') == 'Reseller') {
			$this->db->where('reseller_id', $this->session->userData('id'));
			$this->db->where('mb_no !=', $this->session->userData('id'));
		}
		
		$this->db->where('mb_level !=', "Super admin");
		$total_sold = $this->db->count_all_results();

		if ($total_sold > 0) {
			return $total_sold;
		}

		return NULL;
	}


	function search_member_all($search_user_id,$search_date, $search_code_customer, $search_code_reseller, $search_code_organization , $search_mb_level, $per_pg,$offset){
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

		if ($search_mb_level && $search_mb_level != "all") {
			$this->db->where('mb_level', $search_mb_level);
		}

		if (isset($search_code_customer) && $search_code_customer != "all") {
			$this->db->where('mb_code', $search_code_customer);
		}else if (isset($search_code_reseller) && $search_code_reseller != "all") {
			$this->db->where('mb_code', $search_code_reseller);
		}else if (isset($search_code_organization) && $search_code_organization != "all") {
			$this->db->where('mb_code', $search_code_organization);
		}

		if ($this->session->userData('user_level') == 'Reseller') {
			$this->db->where('reseller_id', $this->session->userData('id'));
			$this->db->where('mb_no !=', $this->session->userData('id'));
		}
		
		$this->db->where('mb_level !=', "Super admin");
		$this->db->limit($per_pg, $offset);
		$this->db->order_by('mb_id','desc');
		$query = $this->db->get();

		// print_r($per_pg);
		// print_r($search_code_reseller);
		// die();
		// print_r($this->db->last_query());
		// die();
		return $query->result();
	}

	function get_code($code, $level) {
		
		$this->db->select('*')
				   ->from('g5_member')
				   ->like('mb_code', $code , "after")
				   ->where('mb_level', $level)
					 ->order_by('mb_no','desc');

		$query = $this->db->get();
		
		
		// print_r($this->db->last_query());
		// die();
		return $query->result();
	}

}
?>

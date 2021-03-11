<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

/**
 * Admin Class
 *
 * @package    	Controllers
 * @category    Admin
 * @link        /admin
 */
class Admin extends CI_Controller {

	/**
	 * @constructor
	 */
	function __construct(){

		parent::__construct();
		if($this->session->userdata('user_level') == 'Reseller' || $this->session->userdata('user_level') == 'Super admin'){
				$this->load->model('users_model');
				$this->load->model('settings_model');
				$this->load->model('notices_model');
				$this->load->model('popup_model');
				$this->load->model('links_model');
				$this->load->model('codes_model');
				$this->load->helper('text');
		} else {
				redirect('/home', 'refresh');
		}
		//$this->load->library('email');
	}

	/**
	 * Index
	 *
	 * @param $data
	 * @return index
	 */
	public function index()
	{
		$current = 'dashboard';
		$template['menu'] = $this->menu($current);
		$data['main_content'] = '/dashboard';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Encodes datetime data
	 *
	 * @param $data
	 * @return date_count
	 */
	public function date_count()
	{
		$today = date('Y-m-d');
		$start = new DateTime('now');
		$start->modify('-6 days'); // or you can use '-90 day' for deduct
		$start = $start->format('Y-m-d');
		$date['start'] = $start;
		$date['end'] = $today;
		$result = $this->users_model->dates($date);
		$data['dates'] = $result['dates'];
		$data['counts'] = $result['data'][0];
		echo json_encode($data);
	}

	/**
	 * Message result
	 *
	 * @param $data
	 * @return members
	 */
	public function members($msg = null)
	{
		unset(
			$_SESSION['search_user_id'],
			$_SESSION['search_date'],
			$_SESSION['search_mb_level'],
			$_SESSION['search_code_customer'],
			$_SESSION['search_code_reseller'],
			$_SESSION['search_code_organization']
		);

		$current = 'members';
		$data['msg'] = $msg;

		$template['menu'] = $this->menu($current);
		$search_user_id = null;
		$search_mb_level = null;
		$search_date = [];

		// Get total count
		if ($this->input->post('user_id')) {
			$search_user_id = $this->input->post('user_id');
			$this->session->set_userdata('search_user_id', $search_user_id);
		} else {
			$search_user_id = $this->session->userdata('search_user_id');
		}

		if ($this->input->post('date')) {
			$search_date = $this->input->post('date');			
			$search_date = explode("~",$search_date);

			if(count($search_date) == 1) {
				$this->session->set_userdata('search_date', $search_date);
			} 
			
			if (count($search_date) == 2){
				$this->session->set_userdata('search_date', $search_date);
			}
		} else {
			$search_date = $this->session->userdata('search_date');
		}

		// Get total count
		if ($this->input->post('mb_level')) {
			$search_mb_level = $this->input->post('mb_level');
			$this->session->set_userdata('search_mb_level', $search_mb_level);
		} else {
			$search_mb_level = $this->session->userdata('search_mb_level');
		}

		// Code customer
		if ($this->input->post('code_customer')) {
			$search_code_customer = $this->input->post('code_customer');
			$this->session->set_userdata('search_code_customer', $search_code_customer);
		} else {
			$search_code_customer = $this->session->userdata('search_code_customer');
		}

		// Code reseller
		if ($this->input->post('code_reseller')) {
			$search_code_reseller = $this->input->post('code_reseller');
			$this->session->set_userdata('search_code_reseller', $search_code_reseller);
		} else {
			$search_code_reseller = $this->session->userdata('search_code_reseller');
		}

		// Code organization
		if ($this->input->post('code_organization')) {
			$search_code_organization = $this->input->post('code_organization');
			$this->session->set_userdata('search_code_organization', $search_code_organization);
		} else {
			$search_code_organization = $this->session->userdata('search_code_organization');
		}

		// Total count rows
		$total = $this->users_model->get_member_count_filter($search_user_id, $search_date, $search_code_customer, $search_code_reseller, $search_code_organization, $search_mb_level);
		$per_pg = 20;
		$offset = $this->uri->segment(3, 0);

		$this->load->library('pagination');

		$config['base_url'] = base_url().'admin/members';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = "<div style='font-size:14px; '><ul class='pagination'>";
		$config['full_tag_close'] ="</ul></div>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$this->pagination->initialize($config);

		$data['pagination']=$this->pagination->create_links();
		$data['countstart'] = $offset;
		$data['users'] = $this->users_model->search_member_all($search_user_id,$search_date, $search_code_customer, $search_code_reseller, $search_code_organization, $search_mb_level, $per_pg,$offset);
		if($this->session->userData('user_level') == 'Super admin'){
			$data['resellers'] = $this->users_model->get_all_resellers();
		}

		$data['codeResellers'] = $this->users_model->get_code('R', 'Reseller');
		$data['codeCustomers'] = $this->users_model->get_code('C', 'Customer');
		$data['codeOrganizations'] = $this->users_model->get_code('O', 'Organziation');

		$data['msg_count_all'] = null;
		$data['msg_count_month'] = null;
		$data['msg_count_today'] = null;
		$data['main_content'] = '/users_list';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Member search
	 *
	 * @param $data
	 * @return member_search
	 */
	public function member_search($msg = null){

		$search_user_id = null;
		$search_mb_level = null;
		
		$search_code_customer = null;
		$search_code_reseller = null;
		$search_code_organization = null;
		$search_date = [];
		

		// Get total count
		if ($this->input->post('user_id')) {
			$search_user_id = $this->input->post('user_id');
			$this->session->set_userdata('search_user_id', $search_user_id);
		} else {
			$search_user_id = $this->session->userdata('search_user_id');
		}
		
		if ($this->input->post('date')) {
			$search_date = $this->input->post('date');			
			$search_date = explode("~",$search_date);
			if(count($search_date) == 1) {
				$this->session->set_userdata('search_date', $search_date);
			} 
			
			if (count($search_date) == 2){
				
				$this->session->set_userdata('search_date', $search_date);
			}
		} else {
			$search_date = $this->session->userdata('search_date');
		}

		// Get total count
		if ($this->input->post('mb_level')) {
			$search_mb_level = $this->input->post('mb_level');
			$this->session->set_userdata('search_mb_level', $search_mb_level);
		} else {
			$search_mb_level = $this->session->userdata('search_mb_level');
		}

		// print_r($this->input->post('code_customer'));
		// die();
		// Code customer
		if ($this->input->post('code_customer')) {
			$search_code_customer = $this->input->post('code_customer');
			$this->session->set_userdata('search_code_customer', $search_code_customer);
		} else {
			$search_code_customer = $this->session->userdata('search_code_customer');
		}

		// Code reseller
		if ( $this->input->post('code_reseller')) {
			$search_code_reseller = $this->input->post('code_reseller');
			$this->session->set_userdata('search_code_reseller', $search_code_reseller);
		} else {
			$search_code_reseller = $this->session->userdata('search_code_reseller');
		}

		// Code organization
		if ($this->input->post('code_organization')) {
			$search_code_organization = $this->input->post('code_organization');
			$this->session->set_userdata('search_code_organization', $search_code_organization);
		} else {
			$search_code_organization = $this->session->userdata('search_code_organization');
		}

		$current = 'member_search';
		$data['msg'] = $msg;

		$template['menu'] = $this->menu($current);
		
		$total = $this->users_model->get_member_count_filter($search_user_id,$search_date, $search_mb_level, $search_code_customer, $search_code_reseller, $search_code_organization);

		$per_pg = 20;
		$offset = $this->uri->segment(3, 0);

		$this->load->library('pagination');

		$config['base_url'] = base_url().'admin/member_search';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = "<div style='font-size:14px; '><ul class='pagination'>";
		$config['full_tag_close'] ="</ul></div>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$this->pagination->initialize($config);

		$data['pagination']=$this->pagination->create_links();
		$data['countstart'] = $offset;
		$data['users'] = $this->users_model->search_member_all($search_user_id,$search_date, $search_code_customer, $search_code_reseller, $search_code_organization , $search_mb_level, $per_pg,$offset);

		if($this->session->userData('user_level') == 'Super admin'){
			$data['resellers'] = $this->users_model->get_all_resellers();
		}

		$data['codeResellers'] = $this->users_model->get_code('R', 'Reseller');
		$data['codeCustomers'] = $this->users_model->get_code('C', 'Customer');
		$data['codeOrganizations'] = $this->users_model->get_code('O', 'Organziation');

		$data['msg_count_all'] = null;
		$data['msg_count_month'] = null;
		$data['msg_count_today'] = null;
		$data['main_content'] = '/users_list';
		
		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Members account change
	 *
	 * @param $id, $data
	 * @return members_account_change
	 */
	public function members_account_change()
	{
		$idx = $this->input->post('idx');
		$account_id = $this->input->post('account_id');
		$account = $this->settings_model->get_sms_account_one($account_id);

		foreach ($idx as $id) {
				$data = array(
						'sms_send_account' => $account->name,
						'sms_account_id' => $account->id,
				);
				$this->users_model->user_update($id, $data);
		}
		redirect('/admin/members/0/'.$msg="success_updated".'');
	}

	/**
	 * users index
	 *
	 * @param $data
	 * @return users
	 */
	public function userAdd()
	{
		$current = 'users';
		$template['menu'] = $this->menu($current);

		$data['rec_code'] = $this->settings_model->get_recommendation();
		$data['resellers'] = $this->users_model->get_resellers();
		$data['main_content'] = '/users_add';

		$this->load->view('admin/template/main_template', $data);
	}

	public function downloadMembers(){

	
		$table = [];
		$fileName = 'Members';
		$fields = ['mb_no', 'mb_id', 'mb_email', 'mb_recommend', 'today', 'all', 'msg_quantity', 'mb_datetime'];
		$fieldNames = ['번호', '회원아이디', '이메일', '추천 코드', '금일', '전체', '남은 CASH', '등록일'];
		
		$thead = 'A1:I1';

		if($this->session->userData('user_level') == 'Super admin') {
			array_push($fields, 'reseller_id');
			array_push($fieldNames, 'Reseller');
		}
		$join = [];
		$where = [];
		$where['mb_level != '] = 'Super admin';
		$orderBy = [];
		$orderBy['mb_no'] = 'desc';
		if($this->session->userdata('user_level') == 'Reseller') {
			// $join['g5_member'] = "g5_member.mb_no = recommendation.created_id";
			$where['reseller_id'] = $this->session->userdata('id');
			$where['mb_no != '] = $this->session->userdata('id');
		}

		if ($this->input->post('excel_date')) {
			$search_date = $this->input->post('excel_date');		
			$search_date = explode("~",$search_date);
			if(count($search_date) == 1) {
				$start = $search_date[0].' 00:00:00';
				$end = $search_date[0].' 23:59:59';
				$where['mb_datetime > '] = $start;
				$where['mb_datetime < '] = $end;
			} 
		}

		if($this->input->post('user_id_excel')){
			
			$userName = $this->input->post('user_id_excel');
			$where['mb_id LIKE '] = '%'.$userName.'%';
		}

		if($this->input->post('mb_level_excel') !== 'all') {
			// $join['g5_member'] = "g5_member.mb_no = recommendation.created_id";
			$where['mb_level'] = $this->input->post('mb_level_excel');
		}

		if($this->input->post('code_reseller_excel') !== 'all') {
			// $join['g5_member'] = "g5_member.mb_no = recommendation.created_id";
			$where['mb_code'] = $this->input->post('code_reseller_excel');
		}else if($this->input->post('code_customer_excel') !== 'all') {
			// $join['g5_member'] = "g5_member.mb_no = recommendation.created_id";
			$where['mb_code'] = $this->input->post('code_customer_excel');
		} else if($this->input->post('code_organization_excel') !== 'all') {
			// $join['g5_member'] = "g5_member.mb_no = recommendation.created_id";
			$where['mb_code'] = $this->input->post('code_organization_excel');
		}

		// Create table header
		foreach ($fieldNames as $index => $fieldName) {
			$table[0][$index] = $fieldName;
		}

		// ADD DATA
		$this->db->select('*');
		$this->db->from('g5_member');
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		foreach ($orderBy as $key => $value) {
			$this->db->order_by($key, $value);
		}

		if ($this->input->post('excel_date')) {
			$search_date = $this->input->post('excel_date');		
			$search_date = explode("~",$search_date);
		
			if (count($search_date) == 2){
				$secondStart = $search_date[0].' 00:00:00';
				$secondEnd = $search_date[1].' 23:59:59';
				$this->db->where("mb_datetime BETWEEN '$secondStart' AND '$secondEnd'");
			}
		}

		$query = $this->db->get();
		// print_r($this->db->last_query());
		// die();
		
		foreach ($query->result() as $index_row => $row) {
			foreach ($fields as $index_field => $field) {
				if ($field == 'mb_no'){
					$cellData = $index_row + 1;
				} else if ($field == 'reseller_id'){
					$reseller = $this->users_model->get_user('mb_no', $row->$field);
					$cellData = ($reseller) ? $reseller->mb_id : '리셀러를 찾을 수 없습니다';
				} else if ($field == 'today') {
					$cellData = $this->users_model->member_msg_count_today($row->mb_no) . " 건";
				} else if ($field == 'all') {
					$cellData = $this->users_model->member_msg_count_all($row->mb_no) . " 건";
				} else if ($field == 'msg_quantity') {
					$cellData =  $row->$field . " Cash";
				} else {
					$cellData = $row->$field;
				}
				$table[$index_row+1][$index_field] = $cellData;
			}
		}

		$this->createExcel($fileName, $table, $thead);
	}

	public function downloadMessageRequests(){
		$table = [];
		$fileName = 'Message Add Requests';
		$fields = ['id', 'member_name', 'total_price', 'num_send', 'status', 'approve_id', 'approve_date'];
		$fieldNames = ['번호', '회원아이디', '충전금액', 'CASH', '상태', '승인 된 사용자', '날짜'];
		$thead = 'A1:G1';
		$join = [];
		$where = [];
		$orderBy = [];
		$orderBy['id'] = 'desc';

		if ($this->input->post('excel_date')) {
			$search_date = $this->input->post('excel_date');		
			$search_date = explode("~",$search_date);
			if(count($search_date) == 1) {
				$start = $search_date[0].' 00:00:00';
				$end = $search_date[0].' 23:59:59';
				$where['created_date > '] = $start;
				$where['created_date < '] = $end;
			} 
		}

		if($this->session->userdata('user_level') == 'Reseller') {
			$join['g5_member'] = 'g5_member.mb_no = msgaddrequest.member_id';
			$where['g5_member.reseller_id'] = $this->session->userdata('id');
		}

		// Create table header
		foreach ($fieldNames as $index => $fieldName) {
			$table[0][$index] = $fieldName;
		}

		// ADD DATA
		$this->db->select('*');
		$this->db->from('msgaddrequest');
		foreach ($join as $key => $value) {
			$this->db->join($key, $value);
		}
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		foreach ($orderBy as $key => $value) {
			$this->db->order_by($key, $value);
		}

		if ($this->input->post('excel_date')) {
			$search_date = $this->input->post('excel_date');		
			$search_date = explode("~",$search_date);
		
			if (count($search_date) == 2){
				$secondStart = $search_date[0].' 00:00:00';
				$secondEnd = $search_date[1].' 23:59:59';
				$this->db->where("created_date BETWEEN '$secondStart' AND '$secondEnd'");
			}
		}

		$query = $this->db->get();
		// print_r($this->db->last_query());
		// die();
		
		foreach ($query->result() as $index_row => $row) {
			foreach ($fields as $index_field => $field) {
				if ($field == 'id'){
					$cellData = $index_row + 1;
				} else if ($field == 'approve_id'){
					$reseller = $this->users_model->get_user('mb_no', $row->$field);
					$cellData = ($reseller) ? $reseller->mb_id : '리셀러를 찾을 수 없습니다';
				} else if ($field == 'status'){
					$cellData = ($row->$field == 2) ? '확인' : '보류 중';
				} else {
					$cellData = $row->$field;
				}
				$table[$index_row+1][$index_field] = $cellData;
			}
		}

		$this->createExcel($fileName, $table, $thead);
	}

	public function downloadMessageResults(){
		$table = [];
		$fileName = 'Message Results';
		$fields = ['id', 'member_id', 'sender', 'sms_count', 'message', 'quantity', 'delivered_count', 'pending', 'error_count', 'created_date'];
		$fieldNames = ['번호', '회원아이디', '발신번호', 'SMS count', '메시지', '모든 전화', '성공', '보류 중', '실패', '등록일'];
		$thead = 'A1:J1';
		$join = [];
		$join['g5_member'] = 'g5_member.mb_no = message.member_id';
		$where = [];
		$orderBy = [];
		$orderBy['message.id'] = 'desc';

		if ($this->input->post('excel_date')) {
			$search_date = $this->input->post('excel_date');		
			$search_date = explode("~",$search_date);
			if(count($search_date) == 1) {
				$start = $search_date[0].' 00:00:00';
				$end = $search_date[0].' 23:59:59';
				$where['created_date > '] = $start;
				$where['created_date < '] = $end;
			} 
		}

		if($this->input->post('user_id_excel')){
			
			$userName = $this->input->post('user_id_excel');
			$where['mb_id LIKE '] = '%'.$userName.'%';
		}

		if($this->input->post('mb_level_excel') !== 'all') {
			// $join['g5_member'] = "g5_member.mb_no = recommendation.created_id";
			$where['g5_member.mb_level'] = $this->input->post('mb_level_excel');
		}

		if($this->input->post('code_reseller_excel') !== 'all') {
			// $join['g5_member'] = "g5_member.mb_no = recommendation.created_id";
			$where['g5_member.mb_code'] = $this->input->post('code_reseller_excel');
		}else if($this->input->post('code_customer_excel') !== 'all') {
			// $join['g5_member'] = "g5_member.mb_no = recommendation.created_id";
			$where['g5_member.mb_code'] = $this->input->post('code_customer_excel');
		} else if($this->input->post('code_organization_excel') !== 'all') {
			// $join['g5_member'] = "g5_member.mb_no = recommendation.created_id";
			$where['g5_member.mb_code'] = $this->input->post('code_organization_excel');
		}
		
		if($this->session->userdata('user_level') == 'Reseller') {
			$where['g5_member.reseller_id'] = $this->session->userdata('id');
		}

		// Create table header
		foreach ($fieldNames as $index => $fieldName) {
			$table[0][$index] = $fieldName;
		}

		// ADD DATA
		$this->db->select('*');
		$this->db->from('message');
		foreach ($join as $key => $value) {
			$this->db->join($key, $value);
		}
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		foreach ($orderBy as $key => $value) {
			$this->db->order_by($key, $value);
		}

		if ($this->input->post('excel_date')) {
			$search_date = $this->input->post('excel_date');		
			$search_date = explode("~",$search_date);
		
			if (count($search_date) == 2){
				$secondStart = $search_date[0].' 00:00:00';
				$secondEnd = $search_date[1].' 23:59:59';
				$this->db->where("created_date BETWEEN '$secondStart' AND '$secondEnd'");
			}
		}

		$query = $this->db->get();
		// print_r($this->db->last_query());
		// die();
		
		foreach ($query->result() as $index_row => $row) {
			foreach ($fields as $index_field => $field) {
				if ($field == 'id'){
					$cellData = $index_row + 1;
				} else if ($field == 'member_id'){
					$member = $this->users_model->get_user('mb_no', $row->$field);
					$cellData = ($member) ? $member->mb_id : '리셀러를 찾을 수 없습니다';
				} else if ($field == 'sms_count'){
					$cellData = $row->split_count * $row->delivered_count;
				} else if ($field == 'pending'){
					$pendingNumber = $row->delivered_count + $row->error_count;
					$cellData = $row->quantity - $pendingNumber;
				} else {
					$cellData = $row->$field;
				}
				$table[$index_row+1][$index_field] = $cellData;
			}
		}

		$this->createExcel($fileName, $table, $thead);
	}

	public function downloadMessageResult($id){
		$table = [];
		$fileName = 'Message Result Detail';
		$fields = ['id', 'sender', 'message_id', 'phone_number', 'success'];
		$fieldNames = ['번호', '송신기', '메시지', '전화 번호', '상태'];
		$thead = 'A1:E1';
		$join = [];
		$join['message'] = 'message.id = message_send_detail.message_id';
		$where = [];
		$where['message_id'] = $id;
		$orderBy = ['success'];

		// Create table header
		foreach ($fieldNames as $index => $fieldName) {
			$table[0][$index] = $fieldName;
		}

		// ADD DATA
		$this->db->select('message_send_detail.id, message_send_detail.sender, message_send_detail.message_id, message_send_detail.phone_number, message_send_detail.success');
		$this->db->from('message_send_detail');
		foreach ($join as $key => $value) {
			$this->db->join($key, $value);
		}
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		// foreach ($orderBy as $key => $value) {
		// 	$this->db->order_by($key, $value);
		// }
		$this->db->order_by('success');
		$query = $this->db->get();
		// print_r($this->db->last_query());
		// die();
		
		foreach ($query->result() as $index_row => $row) {
			foreach ($fields as $index_field => $field) {
				if ($field == 'id'){
					$cellData = $index_row + 1;
				} else if ($field == 'message_id'){
					$message = $this->users_model->get_message($row->message_id);
					$cellData = ($message) ? $message->message : '';
				} else if ($field == 'phone_number'){
					$cellData = $row->phone_number;
				} else if ($field == 'success'){
					if($row->$field == NULL){
						$cellData = 'Pending';
					} else if ($row->$field == 3){
						$cellData = 'Failed';
					} else if($row->$field == 1) {
						$cellData = 'Success';
					}
				} else {
					$cellData = $row->$field;
				}
				$table[$index_row+1][$index_field] = $cellData;
			}
		}

		$this->createExcel($fileName, $table , $thead);
	}

	public function downloadRecommendation(){
		$table = [];
		$fileName = 'Recommendation';
		$fields = ['rec_id', 'rec_code', 'msg_price', 'created_id'];
		$fieldNames = ['번호', '추천 코드	', '메시지 당 가격', '작성일'];
		$thead = 'A1:D1';
		$join = [];
		$where = [];
		$orderBy = [];
		if($this->session->userdata('user_level') == 'Reseller') {
			$where['created_id'] = $this->session->userdata('id');
		}

		// Create table header
		foreach ($fieldNames as $index => $fieldName) {
			$table[0][$index] = $fieldName;
		}

		// ADD DATA
		$this->db->select('*');
		$this->db->from('recommendation');
		foreach ($join as $key => $value) {
			$this->db->join($key, $value);
		}
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		foreach ($orderBy as $key => $value) {
			$this->db->order_by($key, $value);
		}
		$query = $this->db->get();
		// print_r($this->db->last_query());
		// die();
		
		foreach ($query->result() as $index_row => $row) {
			foreach ($fields as $index_field => $field) {
				if ($field == 'rec_id'){
					$cellData = $index_row + 1;
				} else if ($field == 'created_id'){
					$user = $this->users_model->get_user('mb_no', $row->$field);
					$cellData = ($user) ? $user->mb_id : 'Super admin';
				} else {
					$cellData = $row->$field;
				}
				$table[$index_row+1][$index_field] = $cellData;
			}
		}

		$this->createExcel($fileName, $table , $thead);
	}

	public function downloadSmsAcount(){
		$table = [];
		$fileName = 'SMS 계정';
		$fields = ['id', 'account_name', 'username', 'password', 'msg_limit'];
		$fieldNames = ['연동', 'Interlocking name', 'Interlock ID', 'Integration password', 'Message'];
		$thead = 'A1:E1';
		$join = [];
		$where = [];
		$orderBy = [];

		// Create table header
		foreach ($fieldNames as $index => $fieldName) {
			$table[0][$index] = $fieldName;
		}

		// ADD DATA
		$this->db->select('*');
		$this->db->from('sms_1s2u_account');
		foreach ($join as $key => $value) {
			$this->db->join($key, $value);
		}
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}
		foreach ($orderBy as $key => $value) {
			$this->db->order_by($key, $value);
		}
		$query = $this->db->get();
		// print_r($this->db->last_query());
		// die();
		
		foreach ($query->result() as $index_row => $row) {
			foreach ($fields as $index_field => $field) {
				if ($field == 'id'){
					$cellData = $index_row + 1;
				} else {
					$cellData = $row->$field;
				}
				$table[$index_row+1][$index_field] = $cellData;
			}
		}

		$this->createExcel($fileName, $table , $thead);
	}

	public function downloadPaymentStatistic(){
		$table = [];
		$fileName = 'Payment log';
		$fields = ['id', 'member_id', 'action_quantity', 'current_quantity', 'reseller_revenue', 'message_quantity', 'created_date'];
		$fieldNames = ['번호', '회원아이디', 'Action', 'Current', 'Reseller revenue', 'SMS quantity', 'Date'];
		$thead = 'A1:G1';
		$join = [];
		$join['g5_member'] = 'g5_member.mb_no = member_msg_quantity.member_id';
		$where = [];
		$orderBy = [];
		$orderBy['member_msg_quantity.id'] = 'desc';
		
		if($this->session->userdata('user_level') == 'Reseller') {
			$where['g5_member.reseller_id'] = $this->session->userData('id');
			$where['g5_member.mb_level'] = 'Customer';
		}

		if($this->input->post('user_id_excel')){
			$userName = $this->input->post('user_id_excel');
			$where['g5_member.mb_id LIKE '] = '%'.$userName.'%';
		}

		if ($this->input->post('excel_date')) {
			$search_date = $this->input->post('excel_date');		
			$search_date = explode("~",$search_date);
		
			if (count($search_date) == 2){
				$secondStart = $search_date[0].' 00:00:00';
				$secondEnd = $search_date[1].' 23:59:59';
				$this->db->where("created_date BETWEEN '$secondStart' AND '$secondEnd'");
			}
			if(count($search_date) == 1) {
				$start = $search_date[0].' 00:00:00';
				$end = $search_date[0].' 23:59:59';
				$where['created_date > '] = $start;
				$where['created_date < '] = $end;
			} 
		}

		// Create table header
		foreach ($fieldNames as $index => $fieldName) {
			$table[0][$index] = $fieldName;
		}

		// ADD DATA
		$this->db->select('*');
		$this->db->from('member_msg_quantity');
		foreach ($join as $key => $value) {
			$this->db->join($key, $value);
		}
		foreach ($where as $key => $value) {
			$this->db->where($key, $value);
		}		
		if ($this->session->userData('user_level') == 'Super admin') {
			$this->db->where('(g5_member.reseller_id IS NULL OR g5_member.reseller_id = g5_member.mb_no)', null, false);
		}
		foreach ($orderBy as $key => $value) {
			$this->db->order_by($key, $value);
		}

		$query = $this->db->get();
		// print_r($this->db->last_query());
		// die();
		
		foreach ($query->result() as $index_row => $row) {
			foreach ($fields as $index_field => $field) {
				if ($field == 'id'){
					$cellData = $index_row + 1;
				} else if ($field == 'member_id'){
					$member = $this->users_model->get_user('mb_no', $row->$field);
					$cellData = ($member) ? $member->mb_id : '리셀러를 찾을 수 없습니다';
				} else if ($field == 'message_quantity'){
					// Get member
					$member = $this->users_model->get_user('mb_no', $row->member_id);
					// Set mesage quantity
					$recommendation = $recommendation = $this->settings_model->get_recommendation_one_by_id($member->mb_recommend);
					$diff = ($row->current_quantity > $row->last_quantity) ? "+" : "";
					$msg_quantity = floor($row->action_quantity / $recommendation->msg_price);
					$cellData = $msg_quantity;
				}  else {
					$cellData = $row->$field;
				}
				$table[$index_row+1][$index_field] = $cellData;
			}
		}

		$this->createExcel($fileName, $table, $thead);
	}

	public function createExcel($fileName, $table, $thead){

		$tableHead = [
			'font'=>[
				'bold'=>true,
			]
		];
		
		// Create new Spreadsheet object
		$spreadsheet = new Spreadsheet();

		// Set document properties
		$spreadsheet->getProperties()->setCreator('Bestmunja')
				->setLastModifiedBy('Bestmunja')
				->setTitle('Office 2007 XLSX Test Document')
				->setSubject('Office 2007 XLSX Test Document')
				->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
				->setKeywords('Bestmunja, SMS')
				->setCategory('');

		$spreadsheet->getActiveSheet()->getStyle($thead)->applyFromArray($tableHead);

		// Create Excel		
		foreach ($table as $index_row => $row) {
			foreach ($row as $index_field => $field) {
				$alphabet = $this->getAlphabetFromNumber($index_field+1);

				$numeric = ($index_field+1 - 1) % 26;
				$letter = chr(65 + $numeric);
				
				$width = strlen($field);

				// Style Width
				if ($width < 30) {
					$spreadsheet->getActiveSheet()->getColumnDimension($letter)->setWidth($width + 5);
				} else {
					$spreadsheet->getActiveSheet()->getColumnDimension($letter)->setWidth(30);
				}

				$spreadsheet->setActiveSheetIndex(0)->setCellValue($alphabet.($index_row + 1), $field);
				$spreadsheet->getActiveSheet()->getStyle($letter . 1)->getBorders()->applyFromArray( [ 'bottom' => [ 'borderStyle' => Border::BORDER_THICK, 'color' => [ 'rgb' => '000000' ] ] ] );
				$spreadsheet->getActiveSheet()->getStyle($alphabet.($index_row + 1))->getBorders()->applyFromArray( [ 'allBorders' => [ 'borderStyle' => Border::BORDER_THIN, 'color' => [ 'rgb' => '000000' ] ] ] );	
			}
		}

		// Rename worksheet
		$spreadsheet->getActiveSheet()->setTitle('Sheet01');

		// Set active sheet index to the first sheet, so Excel opens this as the first sheet
		$spreadsheet->setActiveSheetIndex(0);

		$fileName = $fileName . '('.date("Y-m-d H:i:s").')';

		// Redirect output to a client’s web browser (Xlsx)
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="'.$fileName.'.xlsx"');
		header('Cache-Control: max-age=0');
		// If you're serving to IE 9, then the following may be needed
		header('Cache-Control: max-age=1');
		// If you're serving to IE over SSL, then the following may be needed
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		header('Pragma: public'); // HTTP/1.0

		$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		$writer->save('php://output');
		exit;
	}

	function getAlphabetFromNumber($num) {
		$numeric = ($num - 1) % 26;
		$letter = chr(65 + $numeric);
		$num2 = intval(($num - 1) / 26);

		if ($num2 > 0) {	
			return $this->getAlphabetFromNumber($num2) . $letter;
		} else {
			return $letter;
		}
	}

	public function regex_check($str) {
		if(preg_match("/^[a-zA-Z0-9]+$/", $str) != 1) {
			$this->form_validation->set_message('regex_check', '문자와 숫자 만 허용됩니다.');

			return false;
		}

		return $str;
	}


	/**
	 * user add
	 *
	 * @param $data
	 * @return userAdd
	 */
	public function userSave()
	{	
		$this->form_validation->set_rules('mb_id', '아이디', 'trim|required|is_unique[g5_member.mb_id]');
		$this->form_validation->set_rules('mb_name', '이름', 'trim|required');
		$this->form_validation->set_rules('mb_email', '이메일', 'trim|required|valid_email|is_unique[g5_member.mb_email]');
		$this->form_validation->set_rules('mb_level', '수평', 'trim|required');
		$this->form_validation->set_rules('mb_password', '비밀번호', 'trim|required|min_length[6]|max_length[20]');
		$this->form_validation->set_rules('mb_password_re', '비밀번호 확인', 'required|matches[mb_password]');
		$this->form_validation->set_rules('mb_recommend', '추천코드', 'trim|required');


		if($this->form_validation->run() == FALSE) {
			$current = 'users';
			$template['menu'] = $this->menu($current);

			$data['rec_code'] = $this->settings_model->get_recommendation();
			
			$data['resellers'] = $this->users_model->get_resellers();

			$data['main_content'] = '/users_add';

			$this->load->view('admin/template/main_template', $data);
		}else{

			$account = $this->settings_model->get_sms_account_default();
			if($account != null){
				$sms_account_name = $account->name;
				$sms_account_id = $account->id;
			}else{
				$sms_account_name = null;
				$sms_account_id = null;
			}

			$password = hash( "sha256", $this->input->post('mb_password') );
			date_default_timezone_set("Asia/Seoul");
			$date = date('Y-m-d');
			$datetime = date('Y-m-d H:i:s');
			$data = array(
				'mb_id' => $this->input->post('mb_id'),
				'mb_name' => $this->input->post('mb_name'),
				'mb_nick' => $this->input->post('mb_id'),
				'mb_password' => $password,
				'mb_pstr' => $this->input->post('mb_password'),
				'mb_email' => $this->input->post('mb_email'),
				'mb_recommend' => $this->input->post('mb_recommend'),
				'mb_level' => $this->input->post('mb_level'),
				'mb_nick_date' => $date,
				'sms_send_account' => $sms_account_name,
				'sms_account_id' => $sms_account_id,
				'mb_open' => $this->input->post('mb_open'),
				'mb_datetime' => $datetime,
				'mb_open_date' => $date,
				'mb_ip' => $_SERVER['REMOTE_ADDR'],
				'mb_login_ip' => $_SERVER['REMOTE_ADDR'],
			);

			$user_id = $this->users_model->register($data);
			

			if($this->session->userData("user_level") == "Super admin") {
				// if new reseller give id to reseller id and code
				if ($this->input->post('mb_level') == 'Reseller'){
					$data1 = array(
						'reseller_id' => $user_id,
						'reseller_code' => "R" . $user_id . "A".$this->input->post('mb_reseller_code'),
						'mb_code' => "R" . $user_id . "A". $this->input->post('mb_reseller_code'),
					);
					$this->users_model->user_update($user_id, $data1);
				}

				// if new customer give id to customer id and code
				if ($this->input->post('mb_level') == 'Customer'){
					$data1 = array(
						'mb_code' => "C" . $user_id . "A". $this->input->post('mb_customer_code'),
					);
					$this->users_model->user_update($user_id, $data1);
				}

				// if new Organization give id to Organization id and code
				if ($this->input->post('mb_level') == 'Organization'){
					$data1 = array(
						'mb_code' => "O" . $user_id . "A". $this->input->post('mb_organization_code'),
					);
					$this->users_model->user_update($user_id, $data1);
				}
			}

			if($this->session->userData("user_level") == "Reseller") {
				// if new customer give id to Customer id and code
				if ($this->input->post('mb_level') == 'Customer'){
					$data1 = array(
						'reseller_id' => $this->session->userData("id"),
						'reseller_code' => $this->session->userData("mb_id"),
						'mb_code' => "RC" . $user_id . "A". $this->input->post('mb_customer_code'),
					);
					$this->users_model->user_update($user_id, $data1);
				}
			}

			redirect('admin/members');
		}
	}

	/**
	 * User add set
	 *
	 * @param $data
	 * @return user_add_set
	 */
  public function user_edit($id)
	{
        

		$current = 'users';

		$template['menu'] = $this->menu($current);
		$data['user'] = $this->users_model->get_user_one($id);
		$data['today_count'] = $this->users_model->get_today_count($id);
		$data['month_count'] = $this->users_model->get_month_count($id);
		$data['all_count'] = $this->users_model->get_all_count($id);
		$data['user'] = $this->users_model->get_user_one($id);
        
        // if($data['user']->reseller_code != $this->session->userData("user_name")){
        //     show_404('권한 없습니다. ');
        // }
		$total = $this->users_model->count_recharge($id);
		$total1 = $this->users_model->get_cash_history_rows($id);
		
		$per_pg = 10;
		$offset = $this->uri->segment(4, 0);
		$this->load->library('pagination');
		$config['base_url'] = base_url().'admin/user_edit/'.$id;
		$config['total_rows'] = $total;
		$config['total_rows'] = $total1;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = "<div style='font-size:14px; '><ul class='pagination'>";
		$config['full_tag_close'] ="</ul></div>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();

		// data cash, data, fail, success, unknown and msg
		$data['history'] = $this->users_model->get_recharge_log($id,$per_pg,$offset);

		// data cash, data, fail, success, unknown and msg
		$data["cash"] = $this->users_model->get_cash_history($id, $per_pg,$offset);

		$data['total'] = $total;
		$data['total1'] = $total1;
		$data['rec_code'] = $this->settings_model->get_recommendation();
		
		$data['resellers'] = $this->users_model->get_resellers();
		$data['main_content'] = '/users_edit';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * User show
	 *
	 * @param $data
	 * @return user_show
	 */
  public function user_show($id)
	{
		$current = 'users';

		$template['menu'] = $this->menu($current);
		$data['user'] = $this->users_model->get_user_one($id);
		$data['today_count'] = $this->users_model->get_today_count($id);
		$data['month_count'] = $this->users_model->get_month_count($id);
		$data['all_count'] = $this->users_model->get_all_count($id);
		$data['user'] = $this->users_model->get_user_one($id);

		$total = $this->users_model->count_recharge($id);
		$total1 = $this->users_model->get_cash_history_rows($id);
		
		$per_pg = 10;
		$offset = $this->uri->segment(4, 0);
		$this->load->library('pagination');
		$config['base_url'] = base_url().'admin/user_show/'.$id;
		$config['total_rows'] = $total;
		$config['total_rows'] = $total1;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = "<div style='font-size:14px; '><ul class='pagination'>";
		$config['full_tag_close'] ="</ul></div>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();

		// data cash, data, fail, success, unknown and msg
		$data['history'] = $this->users_model->get_recharge_log($id,$per_pg,$offset);

		// data cash, data, fail, success, unknown and msg
		$data["cash"] = $this->users_model->get_cash_history($id, $per_pg,$offset);

		$data['total'] = $total;
		$data['total1'] = $total1;
		$data['rec_code'] = $this->settings_model->get_recommendation();
		
		$data['resellers'] = $this->users_model->get_resellers();
		$data['main_content'] = '/users_show';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * User history update
	 *
	 * @param $data
	 * @return user_edit_history_update
	 */
  public function user_edit_history_update($id)
	{
		$current = 'users';

		$template['menu'] = $this->menu($current);
		$data['user'] = $this->users_model->get_user_one($id);
		$data['today_count'] = $this->users_model->get_today_count($id);
		$data['month_count'] = $this->users_model->get_month_count($id);
		$data['all_count'] = $this->users_model->get_all_count($id);
		$data['user'] = $this->users_model->get_user_one($id);
		$total = $this->users_model->count_recharge($id);
		$per_pg = 10;
		$offset = $this->uri->segment(4, 0);
		$this->load->library('pagination');
		$config['base_url'] = base_url().'admin/user_edit/'.$id;
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = "<div style='font-size:14px; '><ul class='pagination'>";
		$config['full_tag_close'] ="</ul></div>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$this->pagination->initialize($config);

		$data['pagination'] = $this->pagination->create_links();

		$data['history'] = $this->users_model->get_recharge_log($id,$per_pg,$offset);
		$data['total'] = $total;
		$data['rec_code'] = $this->settings_model->get_recommendation();
		$data['main_content'] = '/users_edit';

		$this->load->view('admin/template/main_template', $data);
	}
		
	/**
	 * User add set
	 *
	 * @param $id, $data
	 * @return user_add_set
	 */
	public function user_edit_set()
	{
		$this->form_validation->set_rules('mb_id', '아이디', 'trim|required');
		$this->form_validation->set_rules('mb_name', '이름', 'trim|required');
		$this->form_validation->set_rules('mb_email', '이메일', 'trim|required|valid_email');
		$this->form_validation->set_rules('mb_recommend', '추천코드', 'trim|required');

		
		if($this->input->post('old_mb_email') != $this->input->post('mb_email')){
				$this->form_validation->set_rules('mb_email', '이메일', 'trim|required|valid_email|is_unique[g5_member.mb_email]');
		}else{
				$this->form_validation->set_rules('mb_email', '이메일', 'trim|required');
		}
				

		if($this->input->post('mb_password') != null) {
				$password = hash("sha256", $this->input->post('mb_password'));
		}else{
				$password = $this->input->post('old_mb_password');
		}

		$id = $this->input->post('user_id');

		if($this->form_validation->run() == FALSE) {
			$current = 'users';

			$template['menu'] = $this->menu($current);
			$data['user'] = $this->users_model->get_user_one($id);
			$data['today_count'] = $this->users_model->get_today_count($id);
			$data['month_count'] = $this->users_model->get_month_count($id);
			$data['all_count'] = $this->users_model->get_all_count($id);
			$data['user'] = $this->users_model->get_user_one($id);

			$total = $this->users_model->count_recharge($id);
			$total1 = $this->users_model->get_cash_history_rows($id);
			
			$per_pg = 10;
			$offset = $this->uri->segment(4, 0);
			$this->load->library('pagination');
			$config['base_url'] = base_url().'admin/user_edit/'.$id;
			$config['total_rows'] = $total;
			$config['total_rows'] = $total1;
			$config['per_page'] = $per_pg;
			$config['uri_segment'] = 4;
			$config['full_tag_open'] = "<div style='font-size:14px; '><ul class='pagination'>";
			$config['full_tag_close'] ="</ul></div>";
			$config['num_tag_open'] = "<li>";
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
			$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
			$config['next_tag_open'] = "<li>";
			$config['next_tagl_close'] = "</li>";
			$config['prev_tag_open'] = "<li>";
			$config['prev_tagl_close'] = "</li>";
			$config['first_tag_open'] = "<li>";
			$config['first_tagl_close'] = "</li>";
			$config['last_tag_open'] = "<li>";
			$config['last_tagl_close'] = "</li>";

			$this->pagination->initialize($config);

			$data['pagination'] = $this->pagination->create_links();

			// data cash, data, fail, success, unknown and msg
			$data['history'] = $this->users_model->get_recharge_log($id,$per_pg,$offset);

			// data cash, data, fail, success, unknown and msg
			$data["cash"] = $this->users_model->get_cash_history($id, $per_pg,$offset);

			$data['total'] = $total;
			$data['total1'] = $total1;
			$data['rec_code'] = $this->settings_model->get_recommendation();
			
			$data['resellers'] = $this->users_model->get_resellers();
			$data['main_content'] = '/users_edit';

			$this->load->view('admin/template/main_template', $data);
		}else{
			
			$data = array(
					'mb_id' => $this->input->post('mb_id'),
					'mb_open' => $this->input->post('mb_open'),
					'mb_password' => $password,
					'mb_pstr' => $this->input->post('mb_password'),
					'mb_level' => $this->input->post('mb_level'),
					'mb_name' => $this->input->post('mb_name'),
					'mb_email' => $this->input->post('mb_email'),
					'mb_recommend' => $this->input->post('mb_recommend'),

			);
			$this->users_model->user_update($id, $data);

			$countResellerCode = strlen($this->input->post('mb_reseller_code'));

			if($countResellerCode == 7) {
			$oldCode = substr($this->input->post('mb_reseller_code'), 0, 4); 
			}

			
			$generateNumber = $this->users_model->generateRandomString(2);

			if($this->session->userData("user_level") == "Super admin") {

				if($countResellerCode == 2) {
					// if new reseller give id to reseller id and code
					if ($this->input->post('mb_level') == 'Reseller'){
						$data1 = array(
							'reseller_id' => $id,
							'reseller_code' => "R" . $id . "A".$generateNumber,
							'mb_code' => "R" . $id . "A". $generateNumber,
						);
						$this->users_model->user_update($id, $data1);
					}

					// if new customer give id to customer id and code
					if ($this->input->post('mb_level') == 'Customer'){
						$data1 = array(
							'mb_code' => "C" . $id . "A". $generateNumber,
						);
						$this->users_model->user_update($id, $data1);
					}

					// if new Organization give id to Organization id and code
					if ($this->input->post('mb_level') == 'Organization'){
						$data1 = array(
							'mb_code' => "O" . $id . "A". $generateNumber,
						);
						$this->users_model->user_update($id, $data1);
					}
				} else if($countResellerCode == 7) {
					// if new reseller give id to reseller id and code
				
					if ($this->input->post('mb_level') == 'Reseller'){
					
						$data1 = array(
							'reseller_id' => $id,
							'reseller_code' => $this->input->post('mb_reseller_code'),
							'mb_code' => $this->input->post('mb_reseller_code'),
						);
						$this->users_model->user_update($id, $data1);
					}

					// if new customer give id to customer id and code
					if ($this->input->post('mb_level') == 'Customer'){
						$data1 = array(
							'reseller_id' => "",
							'reseller_code' => "",
							'mb_code' => $this->input->post('mb_customer_code'),
						);
						$this->users_model->user_update($id, $data1);
					}

					// if new Organization give id to Organization id and code
					if ($this->input->post('mb_level') == 'Organization'){
						$data1 = array(
							'reseller_id' => "",
							'reseller_code' => "",
							'mb_code' => $this->input->post('mb_organization_code'),
						);
						
						$this->users_model->user_update($id, $data1);
					}
				} else {

					$generateNumber = $this->users_model->generateRandomString(2);

					// if new reseller give id to reseller id and code
					if ($this->input->post('mb_level') == 'Reseller'){
						$data1 = array(
							'reseller_id' => $id,
							'reseller_code' => "R" . $id . "A".$generateNumber,
							'mb_code' => "R" . $id . "A". $generateNumber,
						);
						$this->users_model->user_update($id, $data1);
					}

					// if new customer give id to customer id and code
					if ($this->input->post('mb_level') == 'Customer'){
						$data1 = array(
							'mb_code' => "C" . $id . "A". $generateNumber,
						);
						$this->users_model->user_update($id, $data1);
					}

					// if new Organization give id to Organization id and code
					if ($this->input->post('mb_level') == 'Organization'){
						$data1 = array(
							'mb_code' => "O" . $id . "A". $generateNumber,
						);
						$this->users_model->user_update($id, $data1);
					}
				}
				
			}

			if($this->session->userData("user_level") == "Reseller") {
				// if new customer give id to Customer id and code
				if ($this->input->post('mb_level') == 'Customer'){
					$data1 = array(
						'reseller_id' => $this->session->userData("id"),
						'reseller_code' => $this->session->userData("mb_id"),
					);
				}
				$this->users_model->user_update($id, $data1);

			}
			
			redirect('/admin/members/0/'.$msg="success_updated".'');
		}
	}

	/**
	 * users delete
	 *
	 * @param $id
	 * @return usersDelete
	 */
	public function usersDelete($id)
	{
		$data['mb_open'] = 1;
		
		$this->users_model->user_delete($id, $data);
		redirect('/admin/members/0/' . $msg = "success_deleted" . '');
	}

	/**
	 * Message search
	 *
	 * @param $data
	 * @return sms_search
	 */
	public function sms_search(){

		$search_user_id = null;
		$search_mb_level = null;
		$search_date = [];

		// Get total count
		if ($this->input->post('user_id')) {
			$search_user_id = $this->input->post('user_id');
			$this->session->set_userdata('search_user_id', $search_user_id);
		} else {
			$search_user_id = $this->session->userdata('search_user_id');
		}
		
		if ($this->input->post('date')) {
			$search_date = $this->input->post('date');			
			$search_date = explode("~",$search_date);
			if(count($search_date) == 1) {
				$this->session->set_userdata('search_date', $search_date);
			} 
			
			if (count($search_date) == 2){
				
				$this->session->set_userdata('search_date', $search_date);
			}
		} else {
			$search_date = $this->session->userdata('search_date');
		}

		// Get mb_level
		if ($this->input->post('mb_level')) {
			$search_mb_level = $this->input->post('mb_level');
			$this->session->set_userdata('search_mb_level', $search_mb_level);
		} else {
			$search_mb_level = $this->session->userdata('search_mb_level');
		}

		// Code customer
		if ($this->input->post('code_customer')) {
			$search_code_customer = $this->input->post('code_customer');
			$this->session->set_userdata('search_code_customer', $search_code_customer);
		} else {
			$search_code_customer = $this->session->userdata('search_code_customer');
		}

		// Code reseller
		if ($this->input->post('code_reseller')) {
			$search_code_reseller = $this->input->post('code_reseller');
			$this->session->set_userdata('search_code_reseller', $search_code_reseller);
		} else {
			$search_code_reseller = $this->session->userdata('search_code_reseller');
		}

		// Code organization
		if ($this->input->post('code_organization')) {
			$search_code_organization = $this->input->post('code_organization');
			$this->session->set_userdata('search_code_organization', $search_code_organization);
		} else {
			$search_code_organization = $this->session->userdata('search_code_organization');
		}

		$current = 'sms_search';
		$template['menu'] = $this->menu($current);
		$total = $this->users_model->get_msg_count_filter($search_user_id,$search_date, $search_code_customer, $search_code_reseller, $search_code_organization , $search_mb_level);
		$per_pg = 20;
		$offset = $this->uri->segment(3, 0);

		$this->load->library('pagination');

		$config['base_url'] = base_url().'admin/sms_search';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = "<div style='font-size:14px; '><ul class='pagination'>";
		$config['full_tag_close'] ="</ul></div>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$this->pagination->initialize($config);

		$data['pagination']=$this->pagination->create_links();
		$data['countstart'] = $offset;
		$data['sms_results'] = $this->users_model->search_msg_all($search_user_id,$search_date, $search_code_customer, $search_code_reseller, $search_code_organization , $search_mb_level, $per_pg,$offset);
		if($this->session->userData('user_level') == 'Super admin'){
			$data['resellers'] = $this->users_model->get_all_resellers();
		}

		$data['codeResellers'] = $this->users_model->get_code('R', 'Reseller');
		$data['codeCustomers'] = $this->users_model->get_code('C', 'Customer');
		$data['codeOrganizations'] = $this->users_model->get_code('O', 'Organziation');

		$data['msg_count_all'] = null;
		$data['msg_count_month'] = null;
		$data['msg_count_today'] = null;
		$data['main_content'] = '/sms_results_list';
		
		$this->load->view('admin/template/main_template', $data);
	}
	
	/**
	 * Message result
	 *
	 * @param $data
	 * @return smsResults
	 */
	public function smsResults()
	{
		unset(
			$_SESSION['search_user_id'],
			$_SESSION['search_date'],
			$_SESSION['search_mb_level'],
			$_SESSION['search_code_customer'],
			$_SESSION['search_code_reseller'],
			$_SESSION['search_code_organization']
		);

		$current = 'smsResults';
		$template['menu'] = $this->menu($current);
		$search_user_id = null;
		$search_date = [];

		// Get total count
		if ($this->input->post('user_id')) {
			$search_user_id = $this->input->post('user_id');
			$this->session->set_userdata('search_user_id', $search_user_id);
		} else {
			$search_user_id = $this->session->userdata('search_user_id');
		}

		if ($this->input->post('date')) {
			$search_date = $this->input->post('date');			
			$search_date = explode("~",$search_date);

			if(count($search_date) == 1) {
				$this->session->set_userdata('search_date', $search_date);
			} 
			
			if (count($search_date) == 2){
				$this->session->set_userdata('search_date', $search_date);
			}
		} else {
			$search_date = $this->session->userdata('search_date');
		}

		// Get mb_level
		if ($this->input->post('mb_level')) {
			$search_mb_level = $this->input->post('mb_level');
			$this->session->set_userdata('search_mb_level', $search_mb_level);
		} else {
			$search_mb_level = $this->session->userdata('search_mb_level');
		}

		// Code customer
		if ($this->input->post('code_customer')) {
			$search_code_customer = $this->input->post('code_customer');
			$this->session->set_userdata('search_code_customer', $search_code_customer);
		} else {
			$search_code_customer = $this->session->userdata('search_code_customer');
		}

		// Code reseller
		if ($this->input->post('code_reseller')) {
			$search_code_reseller = $this->input->post('code_reseller');
			$this->session->set_userdata('search_code_reseller', $search_code_reseller);
		} else {
			$search_code_reseller = $this->session->userdata('search_code_reseller');
		}

		// Code organization
		if ($this->input->post('code_organization')) {
			$search_code_organization = $this->input->post('code_organization');
			$this->session->set_userdata('search_code_organization', $search_code_organization);
		} else {
			$search_code_organization = $this->session->userdata('search_code_organization');
		}

		// Total count rows
		$total = $this->users_model->get_msg_count_filter($search_user_id, $search_date, $search_code_customer, $search_code_reseller, $search_code_organization , $search_mb_level);
		$per_pg = 20;
		$offset = $this->uri->segment(3, 0);

		$this->load->library('pagination');

		$config['base_url'] = base_url().'admin/smsResults';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = "<div style='font-size:14px; '><ul class='pagination'>";
		$config['full_tag_close'] ="</ul></div>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$this->pagination->initialize($config);

		$data['pagination']=$this->pagination->create_links();
		$data['countstart'] = $offset;

		$data['sms_results'] = $this->users_model->search_msg_all($search_user_id,$search_date, $search_code_customer, $search_code_reseller, $search_code_organization , $search_mb_level, $per_pg,$offset);
		if($this->session->userData('user_level') == 'Super admin'){
			$data['resellers'] = $this->users_model->get_all_resellers();
		}

		$data['codeResellers'] = $this->users_model->get_code('R', 'Reseller');
		$data['codeCustomers'] = $this->users_model->get_code('C', 'Customer');
		$data['codeOrganizations'] = $this->users_model->get_code('O', 'Organziation');

		$data['msg_count_all'] = null;
		$data['msg_count_month'] = null;
		$data['msg_count_today'] = null;
		$data['main_content'] = '/sms_results_list';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Statistic payment
	 *
	 * @param $data
	 * @return sms_search
	 */
	public function statisticPayment_search($msg = null){

		$search_user_id = null;
		$search_date = [];

		// Get total count
		if ($this->input->post('user_id')) {
			$search_user_id = $this->input->post('user_id');
			$this->session->set_userdata('search_user_id', $search_user_id);
		} else {
			$search_user_id = $this->session->userdata('search_user_id');
		}
		
		if ($this->input->post('date')) {
			$search_date = $this->input->post('date');			
			$search_date = explode("~",$search_date);
			if(count($search_date) == 1) {
				$this->session->set_userdata('search_date', $search_date);
			} 
			
			if (count($search_date) == 2){
				
				$this->session->set_userdata('search_date', $search_date);
			}
		} else {
			$search_date = $this->session->userdata('search_date');
		}

		$data['msg'] = $msg;
		$current = 'statisticPayment';
		$template['menu'] = $this->menu($current);
		$total = $this->users_model->get_payment_total($search_user_id, $search_date);
		$per_pg = 20;
		$offset = $this->uri->segment(3, 0);

		$this->load->library('pagination');

		$config['base_url'] = base_url().'admin/statisticPayment_search';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = "<div style='font-size:14px; '><ul class='pagination'>";
		$config['full_tag_close'] ="</ul></div>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$this->pagination->initialize($config);


		$data['pagination']=$this->pagination->create_links();
		$data['countstart'] = $offset;

		$data['payments'] = $this->users_model->get_payment_list($search_user_id, $search_date, $per_pg, $offset);
		$data['chart'] = $this->users_model->get_payment_chart($search_user_id, $search_date);

		$data['main_content'] = '/statisticPayment';

		$this->load->view('admin/template/main_template', $data);
	}

	public function statisticPayment($msg = null){
		unset(
			$_SESSION['search_user_id'],
			$_SESSION['search_date']
		);

		$current = 'sms_results';
		$template['menu'] = $this->menu($current);
		$search_user_id = null;
		$search_date = [];

		// Get total count
		if ($this->input->post('user_id')) {
			$search_user_id = $this->input->post('user_id');
			$this->session->set_userdata('search_user_id', $search_user_id);
		} else {
			$search_user_id = $this->session->userdata('search_user_id');
		}

		if ($this->input->post('date')) {
			$search_date = $this->input->post('date');			
			$search_date = explode("~",$search_date);

			if(count($search_date) == 1) {
				$this->session->set_userdata('search_date', $search_date);
			} 
			
			if (count($search_date) == 2){
				$this->session->set_userdata('search_date', $search_date);
			}
		} else {
			$search_date = $this->session->userdata('search_date');
		}

		$data['msg'] = $msg;
		$current = 'statisticPayment';
		$template['menu'] = $this->menu($current);
		$total = $this->users_model->get_payment_total($search_user_id, $search_date);
		$per_pg = 20;
		$offset = $this->uri->segment(3, 0);

		$this->load->library('pagination');

		$config['base_url'] = base_url().'admin/statisticPayment';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = "<div style='font-size:14px; '><ul class='pagination'>";
		$config['full_tag_close'] ="</ul></div>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$this->pagination->initialize($config);


		$data['pagination']=$this->pagination->create_links();
		$data['countstart'] = $offset;

		$data['payments'] = $this->users_model->get_payment_list($search_user_id, $search_date, $per_pg, $offset);
		$data['chart'] = $this->users_model->get_payment_chart($search_user_id, $search_date);

		$data['main_content'] = '/statisticPayment';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Message detail
	 *
	 * @param $data
	 * @return sms_detail
	 */
	public function sms_detail($id)
	{

		//$data['msg'] = $msg;
		$current = 'sms_results';
		$template['menu'] = $this->menu($current);
		$total = $this->users_model->get_send_numbers_count($id);
		$per_pg = 100000000000;
		$offset = $this->uri->segment(4, 0);

		$this->load->library('pagination');

		$config['base_url'] = base_url().'admin/sms_detail/'.$id.'';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = "<div style='font-size:14px; '><ul class='pagination'>";
		$config['full_tag_close'] ="</ul></div>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$this->pagination->initialize($config);

		$data['pagination']=$this->pagination->create_links();
		$data['countstart'] = $offset;
		$data['numbers'] = $this->users_model->get_message_send_numbers($id, $per_pg,$offset);
		$data['sms_results'] = $this->users_model->get_member_message_detail($id);
		$data['account'] = $this->settings_model->get_sms_accounts();
		$data['main_content'] = '/sms_results_detail';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Message add
	 *
	 * @param $data
	 * @return smsAdd
	 */
	public function smsAdd($id)
	{

		$current = 'users';

		$template['menu'] = $this->menu($current);
		$data['user_one'] = $this->users_model->get_user_one($id);
		$data['settings'] = $this->settings_model->get_settings();
		$data['main_content'] = '/smsAdd';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Message add set
	 *
	 * @param $data
	 * @return smsAdd_set
	 */
	public function smsAdd_set()
	{
		$this->form_validation->set_rules('msg_quantity', '충전금액', 'trim|required');

		if ($this->form_validation->run() == FALSE) {

			$id = $this->input->post('member_id');
			$current = 'users';

			$template['menu'] = $this->menu($current);
			$data['user_one'] = $this->users_model->get_user_one($id);
			$data['settings'] = $this->settings_model->get_settings();
			$data['main_content'] = '/smsAdd';

			$this->load->view('admin/template/main_template', $data);
		} else {

			$id = $this->input->post('member_id');
			$user_one = $this->users_model->get_user_one($id);
			date_default_timezone_set("Asia/Seoul");
			$date = date('Y-m-d H:i:s');
			$data = array(
				'member_id' => $id,
				'payment' => $this->input->post('payment'),
				'msg_quantity' => $this->input->post('msg_quantity'),
				'created_date' => $date,
			);
			$this->users_model->smsAdd_set($data);

			$new_quantity = $user_one->msg_quantity + $this->input->post('msg_quantity');
			$data2 = array(
				'member_id' => $id,
				'last_quantity' => $user_one->msg_quantity,
				'action_quantity' => $this->input->post('msg_quantity'),
				'current_quantity' => $new_quantity,
				'status' => 1,
				'created_date' => date('Y-m-d H:i:s'),
			);

			$this->users_model->member_msg_quantity_set($data2);

			$data3 = array(
				'msg_quantity' => $new_quantity,
			);

			$this->users_model->user_update($id, $data3);
			redirect('/admin/index/0/' . $msg = "success_updated" . '');
		}
	}
	
	/**
	 * Message add request
	 *
	 * @param $data
	 * @return smsAddRequets
	 */
	public function smsAddRequets($i=0, $msg=null)
	{
		$data['msg'] = $msg;
		$current = 'smsAddRequets';
		$template['menu'] = $this->menu($current);
		$total = $this->users_model->get_smsAddRequets_count();
		$per_pg = 20;
		$offset = $this->uri->segment(3, 0);

		$this->load->library('pagination');

		$config['base_url'] = base_url().'admin/smsAddRequets';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = "<div style='font-size:14px; '><ul class='pagination'>";
		$config['full_tag_close'] ="</ul></div>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$this->pagination->initialize($config);

		$data['pagination']=$this->pagination->create_links();
		$data['countstart'] = $offset;


		$data['smsAddRequets'] = $this->users_model->get_smsAddRequets($per_pg,$offset);


		$data['main_content'] = '/smsAddRequets_list';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Message add request detail
	 *
	 * @param $data
	 * @return smsAddRequetsDetail
	 */
	public function smsAddRequetsDetail($id)
	{
		$data = array(
			'status' => 1,
		);
		$this->users_model->smsAddRequets_update($id, $data);
		$current = 'smsAddRequets';
		//$data['msg'] = $msg;
		$template['menu'] = $this->menu($current);
		$data['detail'] = $this->users_model->get_smsAddRequetsDetail($id);
		$data['main_content'] = '/smsAddRequets_Detail';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Message add request accept
	 *
	 * @param $data
	 * @return requestaccept
	 */
	public function requestaccept($id)
	{
		$request_detail = $this->users_model->get_smsAddRequetsDetail($id);
		$user_one = $this->users_model->get_user_one($request_detail->member_id);

		/* RESELLER PAYMENT START */
		$reseller_revenue = NULL;
		$reseller_cash_change = NULL;
		if ($this->session->userdata('user_level') == 'Reseller' && $user_one->reseller_id == $this->session->userdata('id')){

			// Check reseller's message quantity and number
			$reseller = $this->users_model->get_user('mb_no', $this->session->userdata('id'));
			$reseller_msg_quantity = $reseller->msg_quantity;
			$reseller_recommendation = $this->settings_model->get_recommendation_one_by_id($reseller->mb_recommend);
			$reseller_price = $reseller_recommendation->msg_price;

			// Get customer's requested quantity and number
			$member_recommendation = $this->settings_model->get_recommendation_one_by_id($user_one->mb_recommend);
			$member_msg_quantity = $user_one->msg_quantity;
			$member_price = $member_recommendation->msg_price;

			// if ($msg_num >= $member_msg_num){
			if ($reseller_msg_quantity >= $request_detail->num_send){
				// Set reseller message quantity log
				// $new_quantity = $reseller_msg_quantity - ($msg_price * $member_msg_num);
                $new_quantity = $reseller_msg_quantity - $request_detail->num_send;
                
				$reseller_revenue = ($member_price - $reseller_price) * $request_detail->num_send;
                $reseller_cash_change = 0 - $request_detail->num_send;
                
				$reseller_data = array(
					'member_id' => $reseller->mb_no,
					'last_quantity' => $reseller_msg_quantity,
					// 'action_quantity' => $msg_price * $member_msg_num,
					'action_quantity' => $request_detail->num_send,
                    'current_quantity' => $new_quantity,
					'reseller_revenue' => $reseller_revenue,
					'reseller_cash_change' => $reseller_cash_change,
					'status' => 1,
					'created_date' => date('Y-m-d H:i:s'),
					'request_id'=>$id,
				);
				$this->users_model->member_msg_quantity_set($reseller_data);

				// Update message quantity for reseller
				$reseller_data2 = array(
					'msg_quantity' => $new_quantity,
				);
				$this->users_model->user_update($reseller->mb_no, $reseller_data2);
			} else {
				redirect('/admin/smsAddRequets/0/' . $msg = "error_updated" . '');
			}
		}
		/* RESELLER PAYMENT END */

		date_default_timezone_set("Asia/Seoul");
		$date = date('Y-m-d H:i:s');
		$new_quantity = $user_one->msg_quantity + $request_detail->num_send;
		$data2 = array(
			'member_id' => $user_one->mb_no,
			'last_quantity' => $user_one->msg_quantity,
			'action_quantity' => $request_detail->num_send,
			'current_quantity' => $new_quantity,
			'reseller_revenue' => $reseller_revenue,
			'reseller_cash_change' => $reseller_cash_change,
			'status' => 1,
			'created_date' => date('Y-m-d H:i:s'),
			'request_id'=>$id,
		);
		$this->users_model->member_msg_quantity_set($data2);

		// Update message quantity for member
		$data3 = array(
			'msg_quantity' => $new_quantity,
		);
		$this->users_model->user_update($user_one->mb_no, $data3);
		
		// Update message request
		$data4 = array(
			'approve_id' =>$this->session->userdata('id'),
			'approve_date' =>$date,
			'status' => 2,
		);
		$this->users_model->smsAddRequets_update($id, $data4);

		redirect('/admin/smsAddRequets/0/' . $msg = "success_updated" . '');
	}

	/**
	 * Edit
	 *
	 * @param $data
	 * @return edit
	 */
	public function edit($msg = null)
	{
		$id = $this->session->userdata('id');
		$current = 'admin';
		$data['msg'] = $msg;
		$template['menu'] = $this->menu($current);
		$data['user'] = $this->users_model->get_user_one($id);
		$data['main_content'] = '/admin_edit';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Edit set
	 *
	 * @param $data
	 * @return edit_set
	 */
	public function edit_set($msg = null)
	{
		if ($this->input->post('old_mb_id') != $this->input->post('mb_id')) {
			$this->form_validation->set_rules('mb_id', '이름', 'trim|required|is_unique[g5_member.mb_id]');
		} else {
			$this->form_validation->set_rules('mb_id', '이름', 'trim|required');
		}

		if ($this->input->post('old_mb_email') != $this->input->post('mb_email')) {
			$this->form_validation->set_rules('mb_email', '이메일', 'trim|required|valid_email|is_unique[g5_member.mb_email]');
		} else {
			$this->form_validation->set_rules('mb_email', '이메일', 'trim|required');
		}

		if ($this->form_validation->run() == FALSE) {
			$id = $this->session->userdata('id');
			$current = 'admin';
			$data['msg'] = $msg;
			$template['menu'] = $this->menu($current);
			$data['user'] = $this->users_model->get_user_one($id);
			$data['main_content'] = '/admin_edit';

			$this->load->view('admin/template/main_template', $data);
		} else {

			$id = $this->input->post('user_id');
			if ($this->input->post('mb_password') != null) {
				$password = hash("sha256", $this->input->post('mb_password'));
			} else {
				$password = $this->input->post('old_mb_password');
			}

			$data = array(
				'mb_id' => $this->input->post('mb_id'),
				'mb_password' => $password,
				'mb_pstr' => $this->input->post('mb_password'),
				'mb_name' => $this->input->post('mb_name'),
				'mb_email' => $this->input->post('mb_email'),
				'mb_hp' => $this->input->post('user_mobile_number'),
				'mb_tel' => $this->input->post('user_phone_number'),
				'mb_zip1' => $this->input->post('user_postcode'),
				'mb_addr1' => $this->input->post('mb_addr1'),
				'mb_addr2' => $this->input->post('user_detailAddress'),
			);
			$this->users_model->user_update($id, $data);
			redirect('/admin/edit/' . $msg = "success_updated" . '');
		}
	}

	/**
	 * Setting index
	 *
	 * @param $data
	 * @return settings
	 */
	public function settings($msg = null)
	{
		$id = $this->session->userdata('id');
		$current = 'settings';
		$data['msg'] = $msg;
		$template['menu'] = $this->menu($current);
		$data['settings'] = $this->settings_model->get_settings($id);
		$data['main_content'] = '/settings';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Setting save
	 *
	 * @param $data
	 * @return settings_save
	 */
	public function settings_save($msg = null)
	{

		$data = array(
			'phone' => $this->input->post('phone'),
			'account_name' => $this->input->post('account_name'),
			'account_number' => $this->input->post('account_number'),

		);

		if ($this->input->post('settings_id') != null) {
			$this->settings_model->update($this->input->post('settings_id'), $data);
		} else {
			$this->settings_model->settings_save($data);
		}
		
		redirect('/admin/settings/' . $msg = "success_updated" . '');
	}

	/**
	 * Recommendation index
	 *
	 * @param $data
	 * @return recommendation
	 */
	public function recommendation($msg=null)
	{
		$data['msg'] = $msg;
		$current = 'rec_code';
		$template['menu'] = $this->menu($current);
        $data['rec_code'] = $this->settings_model->get_recommendation_whith_api();
		$data['main_content'] = '/recommendation_list';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Recommendation add
	 *
	 * @param $data
	 * @return recommendationAdd
	 */
	public function recommendationAdd()
	{

		$current = 'rec_code';
		$template['menu'] = $this->menu($current);
		$data['main_content'] = '/recommendation_add';
        $data['api_accounts'] = $this->settings_model->get_sms_accounts();
		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Recommendation add
	 *
	 * @param $data
	 * @return recommendationAdd
	 */
	public function recommendationSave()
	{
		$this->form_validation->set_rules('rec_code', '가입 코드', 'trim|required');
		$this->form_validation->set_rules('msg_price', '추천 코드', 'trim|required');
		$this->form_validation->set_rules('account_id', 'api 계정', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) {
				$current = 'rec_code';
				$template['menu'] = $this->menu($current);
				$data['api_accounts'] = $this->settings_model->get_sms_accounts();
				$data['main_content'] = '/recommendation_add';
				$this->load->view('admin/template/main_template', $data);
		} else {

			date_default_timezone_set("Asia/Seoul");
			$date = date('Y-m-d H:i:s');

			if($this->session->userdata('user_level') == 'Super admin'){
				$data = array(
					'rec_code' => $this->input->post('rec_code'),
					'msg_price' => $this->input->post('msg_price'),
					'account_id' => $this->input->post('account_id'),
					'created_id' => '0',
				);
	
				$this->settings_model->recommendation_save($data);
			}

			if($this->session->userdata('user_level') == 'Reseller'){
                
				$reseller_recommend = $this->users_model->user_one($this->session->userdata('id'));
				$recommend_price = $this->settings_model->get_recommendation_one_by_id($reseller_recommend->mb_recommend);

				if($recommend_price->msg_price <= $this->input->post('msg_price')) {
					$data = array(
						'rec_code' => $this->input->post('rec_code'),
						'msg_price' => $this->input->post('msg_price'),
						'account_id' => $this->input->post('account_id'),
						'created_id' => $this->session->userData('id'),
					);
		
					$this->settings_model->recommendation_save($data);
				} else {
					redirect('/admin/recommendation/' . $msg = "price_more_than_yours" . '');
				}
			}
			

			redirect('/admin/recommendation/' . $msg = "success_added" . '');
		}
	}

	/**
	 * Recommendation show
	 *
	 * @param $data
	 * @return recommendationShow
	 */
	public function recommendationShow($id)
	{

		$current = 'rec_code';
		$template['menu'] = $this->menu($current);
		$data['recommendation'] = $this->settings_model->get_recommendation_one($id);
		$data['main_content'] = '/recommendation_show';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Recommendation edit
	 *
	 * @param $data
	 * @return recommendationEdit
	 */
	public function recommendationEdit($id)
	{

		$current = 'rec_code';
		$template['menu'] = $this->menu($current);
		$data['recommendation'] = $this->settings_model->get_recommendation_one($id);
		$data['main_content'] = '/recommendation_edit';

		$this->load->view('admin/template/main_template', $data);
	}

	public function recommendationUpdate()
	{
		
		$this->form_validation->set_rules('msg_price', '추천 코드', 'trim|required');

		if ($this->form_validation->run() == FALSE) {
			$id = $this->input->post('rec_id');
			$current = 'rec_code';
			$template['menu'] = $this->menu($current);
			$data['recommendation'] = $this->settings_model->get_recommendation_one($id);
			$data['main_content'] = '/recommendation_edit';

			$this->load->view('admin/template/main_template', $data);
		} else {
			$id = $this->input->post('rec_id');

			if($this->session->userdata('user_level') == 'Super admin'){
				$data = array(
					'msg_price' => $this->input->post('msg_price'),
					'created_id' => '0',
				);
	
				$this->settings_model->recommendation_update($id, $data);
			}

			if($this->session->userdata('user_level') == 'Reseller'){

				$reseller_recommend = $this->users_model->user_one($this->session->userdata('id'));
				$recommend_price = $this->settings_model->get_recommendation_one_by_id($reseller_recommend->mb_recommend);

				if($recommend_price->msg_price <= $this->input->post('msg_price')) {
					$data = array(
						'msg_price' => $this->input->post('msg_price'),
						'created_id' => $this->session->userData('id'),
					);
		
					$this->settings_model->recommendation_update($id, $data);
				} else {
					redirect('/admin/recommendation/' . $msg = "price_more_than_yours" . '');
				}
			}

			redirect('/admin/recommendation/' . $msg = "success_updated" . '');
		}
	}

	/**
	 * Recommendation delete
	 *
	 * @param $id
	 * @return recommendationDelete
	 */
	public function recommendationDelete($id)
	{
		$this->settings_model->recommendation_delete($id);
		redirect('/admin/recommendation/' . $msg = "success_deleted" . '');
	}

	/**
	 * Sender index
	 *
	 * @param $data
	 * @return sender
	 */
	public function sender($msg=null)
	{
		$data['msg'] = $msg;
		$current = 'sender';
		$template['menu'] = $this->menu($current);
		$data['sender'] = $this->settings_model->get_sender();
		$data['main_content'] = '/sender_list';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Sender save
	 *
	 * @param $data
	 * @return sender_save
	 */
	public function sender_save()
	{
		$data = array(
			'sender_number' => $this->input->post('sender_number'),
		);
		$this->settings_model->sender_save($data);

		redirect('/admin/sender/' . $msg = "success_added" . '');
	}

	/**
	 * Sender update
	 *
	 * @param $id, $data
	 * @return sender_update
	 */
	public function sender_update()
	{
		$id = $this->input->post('sender_id');
		$data = array(
			'sender_number' => $this->input->post('sender_number'),
		);

		$this->settings_model->sender_update($id, $data);

		redirect('/admin/sender/' . $msg = "success_updated" . '');
	}

	/**
	 * Sender delete
	 *
	 * @param $id
	 * @return senderDelete
	 */
	public function senderDelete($id)
	{

		$this->settings_model->sender_delete($id);

		redirect('/admin/sender/' . $msg = "success_deleted" . '');
	}

	/**
	 * Sender delete
	 *
	 * @param $id
	 * @return senderDelete
	 */
	public function getcredits()
	{
		$id = $this->input->post('id');
		$user = $this->input->post('user');
		$pass = $this->input->post('pass');

		$content = file_get_contents("https://api.1s2u.io/checkbalance?user=".$user."&pass=".$pass."");
		$msg_limit = json_decode($content);

		if ($msg_limit !== null) {
				$this->users_model->sms_account_update($id, $msg_limit);
				echo $msg_limit;
		} else {
				echo 0;
		}
	}

	/**
	 * Header
	 *
	 * @param $data
	 * @return header
	 */
	public function header()
	{

		$data['current'] = "home";
		return $this->load->view('admin/template/header',$data, true);
		//return $template;
	}

	/**
	 * Menu
	 *
	 * @param $data
	 * @return menu
	 */
	public function menu($current)
	{

		$data['current'] = $current;
		return $this->load->view('admin/template/menu', $data, true);
		//return $template;
	}

	/**
	 * Footer
	 *
	 * @param $data
	 * @return footer
	 */
	public function footer()
	{
		return $this->load->view('admin/template/footer', null, true);
	}

	/**
	 * Recharge user
	 *
	 * @param $data
	 * @return recharge_user
	 */
	public function recharge_user()
	{
		// Get member
		$id = $this->input->post('id');
		$cash = $this->input->post('cash');
		date_default_timezone_set("Asia/Seoul");
		$date = date('Y-m-d H:i:s');			
		$user_one = $this->users_model->get_user_one($id);
		$reseller_revenue = NULL;
		$reseller_cash_change = NULL;
        $member_recommendation = $this->settings_model->get_recommendation_one_by_id($user_one->mb_recommend);
        $member_msg_price = $member_recommendation->msg_price;
        $member_msg_num = floor($cash / $member_msg_price);
		/* RESELLER PAYMENT START */
		if ($this->session->userdata('user_level') == 'Reseller'){
			
			// Check reseller's message quantity and number
			$reseller = $this->users_model->get_user('mb_no', $this->session->userdata('id'));
			$reseller_msg_quantity = $reseller->msg_quantity;
            $recommendation = $this->settings_model->get_recommendation_one_by_id($reseller->mb_recommend);
            
			$msg_price = $recommendation->msg_price;
			$msg_num = floor($reseller_msg_quantity / $msg_price);

			// Get customer's requested quantity and number
			

			// Check message price
			// if($member_msg_price > $cash){
			// 	echo 'Requested price must be higher than message price!';
			// 	// echo '요청한 가격이 메시지 가격보다 높아야합니다!';
			// 	die();
			// }
			
			// Check message quantity
			// if ($msg_num >= $member_msg_num){
			if ($reseller_msg_quantity >= $cash){
				// Set message add request log
				$message_request = array(
					'member_id' => $id,
					'member_name' => $user_one->mb_id,
					'status' => 2,
					'num_send' => $cash,
					'created_date' => $date,
					'approve_date' => $date,
					'approve_id' => $this->session->userData('id'),
					'type' => 1,
					'total_price'=>$cash*$member_msg_price,
				);
				$request_id = $this->users_model->smsAddRequestSave($message_request);

				// Set reseller message quantity log
				// $new_quantity = $reseller_msg_quantity - ($msg_price * $member_msg_num);
				$new_quantity = $reseller_msg_quantity - $cash;
				$reseller_revenue = $cash - ($msg_price * $member_msg_num);
				$reseller_cash_change = 0 - ($msg_price * $member_msg_num);
				$reseller_data = array(
					'member_id' => $reseller->mb_no,
					'last_quantity' => $reseller_msg_quantity,
					// 'action_quantity' => $msg_price * $member_msg_num,
					'action_quantity' => $cash,
					'current_quantity' => $new_quantity,
					'reseller_revenue' => $reseller_revenue,
					'reseller_cash_change' => $reseller_cash_change,
					'status' => 1,
					'created_date' => date('Y-m-d H:i:s'),
					'request_id'=>$request_id,
				);
				$this->users_model->member_msg_quantity_set($reseller_data);

				// Set member message quantity log
				$member_data = array(
					'member_id' => $user_one->mb_no,
					'last_quantity' => $user_one->msg_quantity,
					'action_quantity' => $cash,
					'current_quantity' => $user_one->msg_quantity + $cash,
					'reseller_revenue' => $reseller_revenue,
					'reseller_cash_change' => $reseller_cash_change,
					'status' => 1,
					'created_date' => date('Y-m-d H:i:s'),
					'request_id'=>$request_id,
				);
				$this->users_model->member_msg_quantity_set($member_data);

				// Update message quantity for reseller
				$reseller_data2 = array(
					'msg_quantity' => $new_quantity,
				);
				$this->users_model->user_update($reseller->mb_no, $reseller_data2);

				// Update message quantity for member
				$member_data2 = array(
					'msg_quantity' => $user_one->msg_quantity + $cash,
				);
				$this->users_model->user_update($id, $member_data2);
			} else {
				echo 'Requested cash must be higher than resellers cash!';
				// echo 'Requested message quantity must be higher than resellers message quantity!';
				// echo '요청한 메시지 수량은 리셀러 메시지 수량보다 높아야합니다!';
				die();
			}
		}
		/* RESELLER PAYMENT END */
		
		/* SUPER ADMIN PAYMENT START */
		if ($this->session->userdata('user_level') == 'Super admin'){

			$new_quantity = $user_one->msg_quantity + $cash;

			// Set message add request log
			$data4 = array(
				'member_id' => $id,
				'member_name' => $user_one->mb_id,
				'status' => 2 ,
				'num_send' => $cash,
				'created_date' => $date,
				'approve_id' =>$this->session->userData('id'),
				'approve_date' =>$date,
				'type' => 1,
				'total_price'=>$cash*$member_msg_price,
			);
			$request_id = $this->users_model->smsAddRequestSave($data4);

			// Set member message quantity log
			$data2 = array(
				'member_id' => $user_one->mb_no,
				'last_quantity' => $user_one->msg_quantity,
				'action_quantity' => $cash,
				'current_quantity' => $new_quantity,
				'reseller_revenue' => $reseller_revenue,
				'reseller_cash_change' => $reseller_cash_change,
				'status' => 1,
				'created_date' => date('Y-m-d H:i:s'),
				'request_id'=>$request_id,
			);
			$this->users_model->member_msg_quantity_set($data2);

			// Update g5_member quantity
			$data3 = array(
				'msg_quantity' => $new_quantity,
			);
			$this->users_model->user_update($id, $data3);

		}
		/* SUPER ADMIN PAYMENT END */

		echo 'success';
	}

	/**
	 * Meta index
	 *
	 * @param $data
	 * @return meta
	 */
	public function meta($msg=null)
	{
		$data['msg'] = $msg;
		$current = 'meta';
		$template['menu'] = $this->menu($current);

		$data['meta'] = $this->settings_model->get_meta();
		$data['main_content'] = '/meta';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Meta update
	 *
	 * @param $data
	 * @return meta_update
	 */
	public function meta_update()
	{
		if ($_FILES['image']['size'] > 0) {
			$config['upload_path'] = 'upload/meta/'; //give the path to upload the image in folder
			$config['allowed_types'] = '*';
			$config['max_size']	= '10000';
			$config['overwrite'] = false;
			$config['encrypt_name'] = TRUE;
			$this->load->library('upload');
			$this->upload->initialize($config);
			$this->upload->do_upload('image');
			$image_data = $this->upload->data();
			$fileName = $image_data['file_name'];
		} else {
			$fileName = $this->input->post('old_image');
		}

		$table = 'meta';

		$data = array(
			'site_name' => $this->input->post('site_name'),
			'website_title' => $this->input->post('website_title'),
			'description' => $this->input->post('description'),
			'keywords' => $this->input->post('keywords'),
			'author' => $this->input->post('author'),
			'url' => $this->input->post('url'),
			'image' => $fileName,
		);

		$this->db->where('id',1)->update($table,$data);

		redirect('admin/meta');
	}

	/**
	 * Meta update
	 *
	 * @param $data
	 * @return meta_update
	 */
	public function api_list($msg=null){

		$data['msg'] = $msg;
		$current = 'api';
		$template['menu'] = $this->menu($current);
		$data['api'] = $this->settings_model->get_api_list();
		$data['main_content'] = '/api_list';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Api
	 *
	 * @param $uildel, $data, $id
	 * @return api
	 */
	public function api($uildel,$id)
	{
		$current = 'api';
		$template['menu'] = $this->menu($current);

		$a_1 = array('add','edit');
		$a_2 = array('save','update');

		$data['uildel'] = $uildel;

		if (in_array($uildel,$a_1)) {

					$data['main_content'] = '/api_form';
					$data['api'] = $this->settings_model->get_api_one($id);

					$this->load->view('admin/template/main_template', $data);
		} elseif (in_array($uildel,$a_2)) {

				$this->form_validation->set_rules('name', 'API 서비스명', 'trim|required');
				$this->form_validation->set_rules('send_url', '발송 URL', 'trim|required');
				$this->form_validation->set_rules('dlr_url', 'Callback URL', 'trim|required');
				$this->form_validation->set_rules('username', '발송 아이디', 'trim|required');
				$this->form_validation->set_rules('password', '발송 비밀번호', 'trim|required');
				$this->form_validation->set_rules('sender', '발신번호', 'trim|required');
				$this->form_validation->set_rules('recipient', '수신번호', 'trim|required');
				$this->form_validation->set_rules('message', '텍스트', 'trim|required');
				//$this->form_validation->set_rules('type', 'type', 'trim|required');
				$this->form_validation->set_rules('unicode', 'unicode', 'trim|required');

				if ($this->form_validation->run() == FALSE) {
					$current = 'api';
					$template['menu'] = $this->menu($current);
					$data['main_content'] = '/api_form';
					$this->load->view('admin/template/main_template', $data);
				} else {
					date_default_timezone_set("Asia/Seoul");

					$date = date('Y-m-d H:i:s');
					$datas = array(
						'name' => $this->input->post('name'),
						'send_url' => $this->input->post('send_url'),
						'dlr_url' => $this->input->post('dlr_url'),
						'username' => $this->input->post('username'),
						'password' => $this->input->post('password'),
						'sender' => $this->input->post('sender'),
						'recipient' => $this->input->post('recipient'),
						'message' => $this->input->post('message'),
						'type' => $this->input->post('type'),
						'unicode' => $this->input->post('unicode'),
						'action' => $this->input->post('action'),
						'created_date' => $date,
					);

					if ($uildel=='save') {
						$this->settings_model->api_save($datas);

						redirect('/admin/api_list/' . $msg = "success_added" . '');
					} elseif ($uildel=='update') {

						$this->settings_model->api_update($id,$datas);
						redirect('/admin/api_list/' . $msg = "success_updated" . '');
					}

				}
		} elseif ($uildel == 'delete') {
				$this->settings_model->api_delete($id);

				redirect('/admin/api_list/' . $msg = "success_deleted" . '');
		}
	}

	/**
	 * Message account list
	 *
	 * @param $data
	 * @return smsAccount_list
	 */
	public function smsAccount_list($msg=null)
	{
		if ($this->session->userdata('user_level') != 'Super admin') {
			redirect('/admin/index');
		} else {
			$data['msg'] = $msg;
			$current = 'smsAccount';
			$template['menu'] = $this->menu($current);
			$data['account'] = $this->settings_model->get_sms_accounts();
			$data['main_content'] = '/smsAccount_list';

			$this->load->view('admin/template/main_template', $data);
		}
	}

	/**
	 * Message account list
	 *
	 * @param $data
	 * @return smsAccount_list
	 */
	public function smsAccount($uildel,$id)
	{
		if ($this->session->userdata('user_level') != 'Super admin') {
				redirect('/admin/index');
		} else {
			$current = 'smsAccount';
			$template['menu'] = $this->menu($current);

			$a_1 = array('add', 'edit');
			$a_2 = array('save', 'update');
			$data['uildel'] = $uildel;
			
			if (in_array($uildel, $a_1)) {
					$data['main_content'] = '/smsAccount_form';
					$data['api'] = $this->settings_model->get_api_list();
					$data['account'] = $this->settings_model->get_sms_account_one($id);
					$this->load->view('admin/template/main_template', $data);
			} elseif (in_array($uildel, $a_2)) {
					$this->form_validation->set_rules('api_name', 'API 서비스명', 'trim|required');
					$this->form_validation->set_rules('z_id', '연결 Parameter 1', 'trim|required');
					$this->form_validation->set_rules('z_password', '연결 Parameter 1', 'trim|required');
					if ($this->form_validation->run() == FALSE) {
						$current = 'smsAccount';
						$template['menu'] = $this->menu($current);
						$data['main_content'] = '/smsAccount_form';
						$data['api'] = $this->settings_model->get_api_list();
						$this->load->view('admin/template/main_template', $data);
					} else {
						date_default_timezone_set("Asia/Seoul");
						$date = date('Y-m-d H:i:s');
						$last_order = $this->settings_model->get_sms_account_one_last_order();
						$order = $last_order->order + 1;
						$api = $this->settings_model->get_api_one($this->input->post('api_name'));
						$datas = array(
							'name' => $this->input->post('api_name'),
							'username' => $this->input->post('z_id'),
							'password' => $this->input->post('z_password'),
							'created_date' => $date,
							'msg_limit' => $this->input->post('msg_limit'),		
							'account_name' => $api->name,
							'order' => $order,
						);
						$datas2 = array(
							'name' => $this->input->post('api_name'),
							'username' => $this->input->post('z_id'),
							'password' => $this->input->post('z_password'),
							'msg_limit' => $this->input->post('msg_limit'),
						);
						if ($uildel == 'save') {
							$this->settings_model->sms_account_save($datas);
							redirect('/admin/smsAccount_list/' . $msg = "success_added" . '');
						} elseif ($uildel == 'update') {
							$this->settings_model->sms_account_update($id, $datas2);
							redirect('/admin/smsAccount_list/' . $msg = "success_updated" . '');
						}
					}
			} elseif ($uildel == 'delete') {
				$this->settings_model->sms_account_delete($id);
				redirect('/admin/smsAccount_list/' . $msg = "success_deleted" . '');
			}
		}
	}

	/**
	 * Message account add index
	 *
	 * @param $data
	 * @return smsAccountAdd
	 */
	public function smsAccountAdd()
	{

		$current = 'smsAccount';
		$template['menu'] = $this->menu($current);

		$data['main_content'] = '/smsAccount_add';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Message account add save
	 *
	 * @param $data
	 * @return smsAccountSave
	 */
	public function smsAccountSave()
	{
		date_default_timezone_set("Asia/Seoul");
		$date = date('Y-m-d H:i:s');
		$data = array(
			'name' => $this->input->post('api_name'),
			'username' => $this->input->post('z_id'),
			'password' => $this->input->post('z_password'),
			'msg_limit' => $this->input->post('msg_limit'),
			'created_date' => $date,
		);

		$this->settings_model->sms_account_save($data);

		redirect('/admin/smsAccount/' . $msg = "success_added" . '');
	}

	/**
	 * Message account add edit
	 *
	 * @param $data
	 * @return smsAccountSave
	 */
	public function smsAccountEdit($id)
	{

		$current = 'smsAccount';
		$template['menu'] = $this->menu($current);
		$data['account'] = $this->settings_model->get_sms_account_one($id);
		$data['main_content'] = '/smsAccount_edit';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Message account add update
	 *
	 * @param $data
	 * @return smsAccountUpdate
	 */
	public function smsAccountUpdate()
	{
		$id = $this->input->post('account_id');
		$data = array(
			'name' => $this->input->post('z_name'),
			'username' => $this->input->post('z_id'),
			'password' => $this->input->post('z_password'),
			'msg_limit' => $this->input->post('msg_limit'),
		);

		$this->settings_model->sms_account_update($id, $data);

		if ($this->input->post('default') != null) {
			$accounts = $this->settings_model->get_sms_accounts();
			foreach ($accounts as $ac){

				if ($ac->id == $id) {
					$data2 = array(
							'default' => 1,
					);

					$this->settings_model->sms_account_update($ac->id, $data2);
				} else {

					$data2 = array(
							'default' => 0,
					);

					$this->settings_model->sms_account_update($ac->id, $data2);
				}
			}
		}

	redirect('/admin/smsAccount/' . $msg = "success_updated" . '');
	}

	/**
	 * Message account add default
	 *
	 * @param $data
	 * @return smsAccountDefault
	 */
	public function smsAccountDefault($id)
	{

		$accounts = $this->settings_model->get_sms_accounts();
		
		foreach ($accounts as $ac){
			
			if ($ac->id == $id) {
				$data2 = array(
						'default' => 1,
				);

				$this->settings_model->sms_account_update($ac->id, $data2);
			} else {
				$data2 = array(
						'default' => 0,
				);

				$this->settings_model->sms_account_update($ac->id, $data2);
			}
		}

		redirect('/admin/smsAccount/' . $msg = "success_updated" . '');
	}

	/**
	 * Message account add delete
	 *
	 * @param $id
	 * @return smsAccountDelete
	 */
	public function smsAccountDelete($id)
	{
		$this->settings_model->sms_account_delete($id);

		redirect('/admin/smsAccount/' . $msg = "success_deleted" . '');
	}

	/**
	 * Report
	 *
	 * @param $data
	 * @return report
	 */
	public function report()
	{
		$current = 'report';
		$template['menu'] = $this->menu($current);
		$date = date('Y-m-d');
		$first_of_month = date('Y-m-01', strtotime($date));
		$last_of_month = date('Y-m-t', strtotime($date));
		//$result = $this->users_model->get_daily_report($first_of_month,$last_of_month);
		$data['date'] = array();
		$data['undelivered'] = array();
		$data['delivered'] = array();
		$data['error'] = array();
		$data['pending'] = array();
		// foreach ($result as $msg){
		//      array_push($data['date'], date('Y/m/d', strtotime($msg->created_date)));
		//      array_push($data['undelivered'], $msg->undelivered_total);
		//      array_push($data['delivered'], $msg->delivered_total);
		//      array_push($data['error'], $msg->error_total);
		//       array_push($data['pending'], $msg->pending_total);
		// };
		$base_url = base_url();
		$url = parse_url($base_url)['host'];

		$data['total'] = $this->users_model->get_referral_count($url);
		$data['referral'] = $this->users_model->get_referral_report($url);
		$data['main_content'] = '/report';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Get day report
	 *
	 * @param $result
	 * @return get_day_report
	 */	
	public function get_day_report()
	{
		$today = $this->input->post('date');
		$first_of_month = date('Y-m-01', strtotime($today));
		$last_of_month = date('Y-m-t', strtotime($today));
		$result = $this->users_model->get_daily_report($first_of_month,$last_of_month);

		echo json_encode($result);
	}
		
	/**
	 * Get day report table
	 *
	 * @param $data
	 * @return get_day_report_table
	 */
	public function get_day_report_table()
	{
		$today = $this->input->post('date');
		$first_of_month = date('Y-m-01', strtotime($today));
		$last_of_month = date('Y-m-t', strtotime($today));

		$data['rows'] = $this->users_model->get_daily_report($first_of_month,$last_of_month);
		$data['type'] = 'day';

		$this->load->view('admin/daily_table', $data);
	}

	/**
	 * Get month report table
	 *
	 * @param $data
	 * @return get_month_report_table
	 */
	public function get_month_report_table()
	{
		$today = $this->input->post('date');
		$first_of_month = date('Y-01-01', strtotime($today));
		$last_of_month = date('Y-12-31', strtotime($today));

		$data['rows'] = $this->users_model->get_monthly_report($first_of_month,$last_of_month);
		$data['type'] = 'month';

		$this->load->view('admin/daily_table', $data);
	}

	/**
	 * Get routee
	 *
	 * @param $data
	 * @return getRoutee
	 */
	public function getRoutee()
	{
		$id = $this->input->post('id');
		$acc = $this->settings_model->get_sms_account_one($id);

		$this->load->library('curl_token');

		$token = $this->curl_token->get_token($acc->username,$acc->password);
		$balance = $this->curl_token->get_balance($token->access_token);
		$price = $this->curl_token->get_pricing($token->access_token);

		foreach ($price->sms as $arr) {

			if ($arr->country == 'SOUTH KOREA') {
				$api_price = $arr->networks[0]->price;
			}
		}

		$save = array(
			'msg_limit'=>floor($balance->balance/$api_price),
			'col2'=>$balance->currency->sign,
		);

		$this->db->where('id',$id);
		$this->db->update('sms_1s2u_account',$save);

		echo floor($balance->balance/$api_price);
	}

	/**
	 * Get traffic
	 *
	 * @param $data
	 * @return get_traffic
	 */
	public function get_traffic()
	{
		$data['pc'] = array();
		$data['mobile'] = array();

		for ($i=0; $i < 7 ; $i++) {
					$date = new DateTime();
					$date->modify("-{$i} day");
					$pc = $this->users_model->get_visit($date->format('Y-m-d'),0);
					array_push($data['pc'],$pc);
		};

		for ($i=0; $i < 7 ; $i++) {
					$date = new DateTime();
					$date->modify("-{$i} day");
					$mobile = $this->users_model->get_visit($date->format('Y-m-d'),1);
					array_push($data['mobile'],$mobile);
		};

		$data['pc'] = array_reverse($data['pc']);
		$data['mobile'] = array_reverse($data['mobile']);

		$test = array('device','browser');

		foreach ($test as $key => $value) {

			$result = $this->users_model->get_visit_by($value);
			$data['result_by'][$key]["list"] = array();
			$data['result_by'][$key]["count"] = array();

			foreach ($result as $row) {
				array_push($data['result_by'][$key]["list"],$row->name);
				array_push($data['result_by'][$key]["count"],$row->count);
			};
		};
		echo json_encode($data);
	}

	/**
	 * Order up
	 *
	 * @param $data
	 * @return order_up
	 */
	public function order_up()
	{

		if ($this->input->post('accountorder') > 1) {

			$accountid = $this->input->post('accountid');
			$order = $this->input->post('accountorder');
			$up = $order - 1;
			$up_menu = $this->settings_model->get_account_by_order($up);

			$data = array(
				'order' => $up,
			);
			
			$data2 = array(
				'order' => $order,
			);

			$this->settings_model->sms_account_update($accountid, $data);
			$this->settings_model->sms_account_update($up_menu->id, $data2);

			echo true;
		}else{
			echo false;
		}
	}

	/**
	 * Order up
	 *
	 * @param $data
	 * @return order_up
	 */
	public function order_down()
	{

		$accountid = $this->input->post('accountid');
		$order = $this->input->post('accountorder');
		$down = $order + 1;
		$down_menu = $this->settings_model->get_account_by_order($down);

		if ($down_menu != null) {
				$data = array(
						'order' => $down,
				);

				$data2 = array(
						'order' => $order,
				);

				$this->settings_model->sms_account_update($accountid, $data);
				$this->settings_model->sms_account_update($down_menu->id, $data2);

				echo true;
		} else {
			echo false;
		}
	}

	/**
	 * notice index
	 *
	 * @param $data
	 * @return notice
	 */
	public function notice($msg=null)
	{
		$data['msg'] = $msg;
		$current = 'notice';
		$template['menu'] = $this->menu($current);

		$data['notice'] = $this->notices_model->show();
		$data['main_content'] = '/notice_list';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * notice add
	 *
	 * @param $data
	 * @return noticeAdd
	 */
	public function noticeAdd()
	{

		$current = 'notice';
		$template['menu'] = $this->menu($current);

		$data['main_content'] = '/notice_add';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * notice add
	 *
	 * @param $data
	 * @return noticeAdd
	 */
	public function noticeSave()
	{
		$this->form_validation->set_rules('title', '추천 코드', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) {
				$current = 'title';
				$template['menu'] = $this->menu($current);

				$data['main_content'] = '/notice_add';

				$this->load->view('admin/template/main_template', $data);
		} else {

			date_default_timezone_set("Asia/Seoul");
			$date = date('Y-m-d H:i:s');

			if (!empty($this->input->post('use_yn'))){
				$useYn = 1;
			} else {
				$useYn = 0;
			}

			$data = array(
				'title' => $this->input->post('title'),
				'content' => $this->input->post('content'),
				'use_yn' => $useYn,
				'updated_id' => $this->session->userdata('id'),
				'created_date' => $date,
			);

			$this->notices_model->store($data);

			redirect('/admin/notice/' . $msg = "success_added" . '');
		}
	}	

	/**
	 * notice edit
	 *
	 * @param $data
	 * @return noticeEdit
	 */
	public function noticeEdit($id)
	{

		$current = 'notice';
		$template['menu'] = $this->menu($current);
		$data['notice'] = $this->notices_model->edit($id);
		$data['main_content'] = '/notice_edit';

		$this->load->view('admin/template/main_template', $data);
	}

	public function noticeUpdate()
	{
		if ($this->input->post('title') != $this->input->post('old_title')) {
			$this->form_validation->set_rules('title', '추천 코드', 'trim|required');
		} else {
			$this->form_validation->set_rules('title', '추천 코드', 'trim|required');
		}

		if ($this->form_validation->run() == FALSE) {
			$id = $this->input->post('id');
			$current = 'title';
			$template['menu'] = $this->menu($current);
			$data['notice'] = $this->notices_model->edit($id);
			$data['main_content'] = '/notice_edit';

			$this->load->view('admin/template/main_template', $data);
		} else {
			$id = $this->input->post('id');

			if (!empty($this->input->post('use_yn'))){
				$useYn = 1;
			} else {
				$useYn = 0;
			}

			$data = array(
				'title' => $this->input->post('title'),
				'content' => $this->input->post('content'),
				'use_yn' => $useYn,
				'updated_id' => $this->session->userdata('id'),
			);

			$this->notices_model->update($id, $data);

			redirect('/admin/notice/' . $msg = "success_updated" . '');
		}
	}

	/**
	 * notice delete
	 *
	 * @param $id
	 * @return noticeDelete
	 */
	public function noticeDelete($id)
	{
		$this->notices_model->destroy($id);
		redirect('/admin/notice/' . $msg = "success_deleted" . '');
	}

	/**
	 * link index
	 *
	 * @param $data
	 * @return link
	 */
	public function link($msg=null)
	{
		$data['msg'] = $msg;
		$current = 'link';
		$template['menu'] = $this->menu($current);

		$data['link'] = $this->links_model->show();
		$data['main_content'] = '/link_list';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * link add
	 *
	 * @param $data
	 * @return linkAdd
	 */
	public function linkAdd()
	{

		$current = 'link';
		$template['menu'] = $this->menu($current);

		$data['rec_code'] = $this->settings_model->get_recommendation();

		$data['main_content'] = '/link_add';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * link add
	 *
	 * @param $data
	 * @return linkAdd
	 */
	public function linkSave()
	{
		$this->form_validation->set_rules('mb_recommend', '추천', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) {
				$current = 'link';
				$template['menu'] = $this->menu($current);
		
				$data['rec_code'] = $this->settings_model->get_recommendation();
		
				$data['main_content'] = '/link_add';
		
				$this->load->view('admin/template/main_template', $data);
		} else {

			date_default_timezone_set("Asia/Seoul");
			$date = date('Y-m-d H:i:s');
			$reseller = $this->users_model->get_user_one($this->session->userdata('id'));

			$data = array(
				'recommend' => $this->input->post('mb_recommend'),
				'created_id' => $this->session->userdata('id'),
				'created_date' => $date,
			);

			if ($this->session->userData('user_level') == 'Super admin') {
				$data['link'] = base_url()."home/register_form#".$this->input->post('mb_recommend');
			} else if ($this->session->userData('user_level') == 'Reseller') {
				$data['link'] = base_url()."home/register_form#".$this->input->post('mb_recommend').'#'.$reseller->reseller_code;
			}

			$this->links_model->store($data);

			redirect('/admin/link/' . $msg = "success_added" . '');
		}
	}	

	/**
	 * link edit
	 *
	 * @param $data
	 * @return linkEdit
	 */
	public function linkEdit($id) {

		$current = 'link';
		$template['menu'] = $this->menu($current);

		$data['rec_code'] = $this->settings_model->get_recommendation();

		$data['link'] = $this->links_model->edit($id);
		$data['main_content'] = '/link_edit';

		$this->load->view('admin/template/main_template', $data);
	}

	public function linkUpdate()
	{
	
		$this->form_validation->set_rules('mb_recommend', '추천 코드', 'trim|required');
		

		if ($this->form_validation->run() == FALSE) {
			$id = $this->input->post('id');
			$current = 'link';
			$template['menu'] = $this->menu($current);

			$data['rec_code'] = $this->settings_model->get_recommendation();

			$data['link'] = $this->links_model->edit($id);
			$data['main_content'] = '/link_edit';

			$this->load->view('admin/template/main_template', $data);
		} else {
			$id = $this->input->post('id');
			$reseller = $this->users_model->get_user_one($this->session->userdata('id'));

			$data = array(
				'recommend' => $this->input->post('mb_recommend'),
			);

			if ($this->session->userData('user_level') == 'Super admin') {
				$data['link'] = base_url()."home/register_form#".$this->input->post('mb_recommend');
			} else if ($this->session->userData('user_level') == 'Reseller') {
				$data['link'] = base_url()."home/register_form#".$this->input->post('mb_recommend').'#'.$reseller->reseller_code;
			}

			$this->links_model->update($id, $data);

			redirect('/admin/link/' . $msg = "success_updated" . '');
		}
	}

	/**
	 * link delete
	 *
	 * @param $id
	 * @return linkDelete
	 */
	public function linkDelete($id)
	{
		$this->links_model->destroy($id);
		redirect('/admin/link/' . $msg = "success_deleted" . '');
	}

	/**
	 * Message result
	 *
	 * @param $data
	 * @return codes
	 */
	public function codes($msg = null)
	{
		unset(
			$_SESSION['search_user_id'],
			$_SESSION['search_date'],
			$_SESSION['search_reseller']
		);

		$current = 'codes';
		$data['msg'] = $msg;

		$template['menu'] = $this->menu($current);
		$search_user_id = null;
		$search_date = [];

		// Get total count
		if ($this->input->post('user_id')) {
			$search_user_id = $this->input->post('user_id');
			$this->session->set_userdata('search_user_id', $search_user_id);
		} else {
			$search_user_id = $this->session->userdata('search_user_id');
		}

		if ($this->input->post('date')) {
			$search_date = $this->input->post('date');			
			$search_date = explode("~",$search_date);

			if(count($search_date) == 1) {
				$this->session->set_userdata('search_date', $search_date);
			} 
			
			if (count($search_date) == 2){
				$this->session->set_userdata('search_date', $search_date);
			}
		} else {
			$search_date = $this->session->userdata('search_date');
		}

		if ($this->input->post('reseller')) {
			$search_reseller = $this->input->post('reseller');
			$this->session->set_userdata('search_reseller', $search_reseller);
		} else {
			$search_reseller = $this->session->userdata('search_reseller');
		}

		// Total count rows
		$total = $this->codes_model->get_code_count_filter($search_user_id, $search_date, $search_reseller);
		$per_pg = 20;
		$offset = $this->uri->segment(3, 0);

		$this->load->library('pagination');

		$config['base_url'] = base_url().'admin/codes';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = "<div style='font-size:14px; '><ul class='pagination'>";
		$config['full_tag_close'] ="</ul></div>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$this->pagination->initialize($config);

		$data['pagination']=$this->pagination->create_links();
		$data['countstart'] = $offset;
		$data['codes'] = $this->codes_model->search_code_all($search_user_id,$search_date, $search_reseller, $per_pg,$offset);
	
		$data['msg_count_all'] = null;
		$data['msg_count_month'] = null;
		$data['msg_count_today'] = null;
		$data['main_content'] = '/codes_list';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Code search
	 *
	 * @param $data
	 * @return code_search
	 */
	public function code_search($msg = null){

		$search_user_id = null;
		$search_date = [];

		// Get total count
		if ($this->input->post('user_id')) {
			$search_user_id = $this->input->post('user_id');
			$this->session->set_userdata('search_user_id', $search_user_id);
		} else {
			$search_user_id = $this->session->userdata('search_user_id');
		}
		
		if ($this->input->post('date')) {
			$search_date = $this->input->post('date');			
			$search_date = explode("~",$search_date);
			if(count($search_date) == 1) {
				$this->session->set_userdata('search_date', $search_date);
			} 
			
			if (count($search_date) == 2){
				
				$this->session->set_userdata('search_date', $search_date);
			}
		} else {
			$search_date = $this->session->userdata('search_date');
		}

		if ($this->input->post('reseller')) {
			$search_reseller = $this->input->post('reseller');
			$this->session->set_userdata('search_reseller', $search_reseller);
		} else {
			$search_reseller = $this->session->userdata('search_reseller');
		}

		$current = 'code_search';
		$data['msg'] = $msg;

		$template['menu'] = $this->menu($current);
		
		$total = $this->codes_model->get_code_count_filter($search_user_id,$search_date, $search_reseller);

		$per_pg = 20;
		$offset = $this->uri->segment(3, 0);

		$this->load->library('pagination');

		$config['base_url'] = base_url().'admin/code_search';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = "<div style='font-size:14px; '><ul class='pagination'>";
		$config['full_tag_close'] ="</ul></div>";
		$config['num_tag_open'] = "<li>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li>";
		$config['next_tagl_close'] = "</li>";
		$config['prev_tag_open'] = "<li>";
		$config['prev_tagl_close'] = "</li>";
		$config['first_tag_open'] = "<li>";
		$config['first_tagl_close'] = "</li>";
		$config['last_tag_open'] = "<li>";
		$config['last_tagl_close'] = "</li>";

		$this->pagination->initialize($config);

		$data['pagination']=$this->pagination->create_links();
		$data['countstart'] = $offset;
		$data['codes'] = $this->codes_model->search_code_all($search_user_id,$search_date, $search_reseller, $per_pg,$offset);

		if($this->session->userData('user_level') == 'Super admin'){
			$data['resellers'] = $this->users_model->get_all_resellers();
		}

		$data['msg_count_all'] = null;
		$data['msg_count_month'] = null;
		$data['msg_count_today'] = null;
		$data['main_content'] = '/codes_list';
		
		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Code add
	 *
	 * @param $data
	 * @return codeAdd
	 */
	public function codeAdd()
	{

		$current = 'codes';
		$template['menu'] = $this->menu($current);

		$data['rec_code'] = $this->settings_model->get_recommendation();

		$data['main_content'] = '/codes_add';

		$this->load->view('admin/template/main_template', $data);
	}

	/**
	 * Code add
	 *
	 * @param $data
	 * @return codeAdd
	 */
	public function codeSave()
	{
		$this->form_validation->set_rules('mb_recommend', '추천', 'trim|required');
		
		if ($this->form_validation->run() == FALSE) {
				$current = 'codes';
				$template['menu'] = $this->menu($current);
		
				$data['rec_code'] = $this->settings_model->get_recommendation();
		
				$data['main_content'] = '/codes_add';
		
				$this->load->view('admin/template/main_template', $data);
		} else {

			date_default_timezone_set("Asia/Seoul");
			$date = date('Y-m-d H:i:s');
			$reseller = $this->users_model->get_user_one($this->session->userdata('id'));

			$data = array(
				'recommend' => $this->input->post('mb_recommend'),
				'created_id' => $this->session->userdata('id'),
				'created_date' => $date,
			);

			if ($this->session->userData('user_level') == 'Super admin') {
				$data['link'] = base_url()."home/register_form#".$this->input->post('mb_recommend');
			} else if ($this->session->userData('user_level') == 'Reseller') {
				$data['link'] = base_url()."home/register_form#".$this->input->post('mb_recommend').'#'.$reseller->reseller_code;
			}

			$this->codes_model->store($data);

			redirect('/admin/codes/' . $msg = "success_added" . '');
		}
	}

	/**
	 * Code edit
	 *
	 * @param $data
	 * @return codeEdit
	 */
	public function codeEdit($id) {

		$current = 'codes';
		$template['menu'] = $this->menu($current);

		$data['rec_code'] = $this->settings_model->get_recommendation();

		$data['codes'] = $this->codes_model->edit($id);
		$data['main_content'] = '/codes_edit';

		$this->load->view('admin/template/main_template', $data);
	}

	public function codeUpdate()
	{
	
		$this->form_validation->set_rules('mb_recommend', '추천 코드', 'trim|required');
		

		if ($this->form_validation->run() == FALSE) {
			$id = $this->input->post('id');
			$current = 'link';
			$template['menu'] = $this->menu($current);

			$data['rec_code'] = $this->settings_model->get_recommendation();

			$data['link'] = $this->codes_model->edit($id);
			$data['main_content'] = '/link_edit';

			$this->load->view('admin/template/main_template', $data);
		} else {
			$id = $this->input->post('id');
			$reseller = $this->users_model->get_user_one($this->session->userdata('id'));

			$data = array(
				'recommend' => $this->input->post('mb_recommend'),
			);

			if ($this->session->userData('user_level') == 'Super admin') {
				$data['link'] = base_url()."home/register_form#".$this->input->post('mb_recommend');
			} else if ($this->session->userData('user_level') == 'Reseller') {
				$data['link'] = base_url()."home/register_form#".$this->input->post('mb_recommend').'#'.$reseller->reseller_code;
			}

			$this->codes_model->update($id, $data);

			redirect('/admin/link/' . $msg = "success_updated" . '');
		}
	}

	/**
	 * code delete
	 *
	 * @param $id
	 * @return codeDelete
	 */
	public function codeDelete($id)
	{
		$this->codes_model->destroy($id);
		redirect('/admin/link/' . $msg = "success_deleted" . '');
    }
    
    public function check_rec_code(){
        $code = $this->input->post('code');
        $data = false;
        $sql = "SELECT * FROM recommendation WHERE REC_CODE = ?";
        $query = $this->db->query($sql,$code);
        echo json_encode($query->num_rows());
	}
	
	
	/**
	 * notice index
	 *
	 * @param $data
	 * @return notice
	 */
	public function popup($msg=null)
	{
		$data['msg'] = $msg;
		$current = 'popup';
		$template['menu'] = $this->menu($current);

		$data['list'] = $this->popup_model->list();
		$data['main_content'] = '/popup_list.php';

		$this->load->view('admin/template/main_template', $data);
	}

	public function popupAdd($id = null)
	{
		$current = 'popup';
		$template['menu'] = $this->menu($current);
		$data['vo'] = $this->popup_model->getPopupOne($id);
	
		$data['main_content'] = '/popup_write';

		$this->load->view('admin/template/main_template', $data);
	}

	public function popup_proc(){
		
		$this->form_validation->set_rules('subject', '제목', 'trim|required');
		$this->form_validation->set_rules('link_url', '링크', 'trim|required');
		$this->form_validation->set_rules('start_dt', '시작일', 'trim|required');
		$this->form_validation->set_rules('end_dt', '종료일', 'trim|required');
		$this->form_validation->set_rules('body', '내용', 'trim|required');
		if ($this->form_validation->run() == FALSE) {
				$current = 'popup';
				$template['menu'] = $this->menu($current);
				$data['main_content'] = '/popup_write';
				$this->load->view('admin/template/main_template', $data);
		} else {
			$data = $this->input->post();
			$data["reg_user"] = $this->session->userdata('id');
			unset($data["popup_seq"]);
			unset($data["button"]);
			if($this->input->post("popup_seq") == ""){
				$this->popup_model->save($data);
			}else{
				$this->popup_model->update($this->input->post("popup_seq"),$data);
			}
			redirect('/admin/popup/' . $msg = "success_added" . '');
		}
	}

	public function popup_upload (){
        $config['upload_path'] = 'upload/popup/'; //give the path to upload the image in folder
        $config['allowed_types'] = '*';
        $config['max_size']	= '10000';
        $config['overwrite'] = false;
        $config['encrypt_name'] = TRUE;
        $this->load->library('upload');
        $this->upload->initialize($config);
        $this->upload->do_upload('image');
        $image_data = $this->upload->data();
        $fileName = $image_data['file_name'];
        $response = new StdClass;
        $response->link = "/upload/popup/" . $fileName;
        echo stripslashes(json_encode($response));
    }
    public function popup_delete ($id){
        $this->popup_model->destroy($id);
        redirect('/admin/popup/' . $msg = "success_deleted" . '');
    }
}

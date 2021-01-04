<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Users Class
 *
 * @package    	Controllers
 * @category    Users
 * @link        /admin
 */
class Users extends CI_Controller {

	/**
	 * @consturctor
	 */
	function __construct() {

		parent::__construct();
		if($this->session->userdata('logged_in') == true){
				$this->load->model('users_model');
				$this->load->model('settings_model');
				$this->load->model('notices_model');
				$this->load->helper('text');
		} else {
				redirect('/home', 'refresh');
		}
		//$this->load->library('email');


		$this->load->helper('logger');
	}

	/**
	 * Index
	 *
	 * @param Data $data
	 * @return index
	 */
	function index() {

		echo "Proc_text::Index is called at ".$this->rightnow()."<br>";

		$param = '999';
		$id = '123';
		$command = "start /B php ".FCPATH."index.php msgsend send_msg $param $id > NUL";

		pclose( popen( $command, 'r' ) );
		//exec($command);
		echo $command;

		echo "<br > Proc_text::Index is done at ".$this->rightnow()."<br>";
	}

	/**
	 * Preget
	 *
	 * @return preget
	 */
	function preget() {
		
		// Echo
		echo "<br/>Done!!!!!!";
	}

	/**
	 * Message strInArray
	 *
	 * @param $haystack, $needle
	 * @return strInArray
	 */
	function strInArray($haystack, $needle) {
		
		$i = 0;
		
		foreach ($haystack as $value) {
			$result = stripos($value,$needle);
			if ($result !== FALSE) return TRUE;
			$i++;
		}

		return FALSE;
	}

	/**
	 * Mb string split
	 *
	 * @param $data
	 * @return mb_str_split
	 */
	function mb_str_split($string, $split_length = 1)
	{
		if ($split_length == 1) {
			return preg_split("//u", $string, -1, PREG_SPLIT_NO_EMPTY);
		} elseif ($split_length > 1) {
			$return_value = [];
			$string_length = mb_strlen($string);

			for ($i = 0; $i < $string_length; $i += $split_length) {
					$return_value[] = mb_substr($string, $i, $split_length, "UTF-8");
			}

			return $return_value;
		} else {
			return false;
		}
	}

	/**
	 * Print line
	 *
	 * @param $data
	 * @return print_ln
	 */
	function print_ln($content) {

		if (isset($_SERVER["SERVER_NAME"])) {
			print $content."<br />";
		} else {
			print $content."\n";
		}
	}

	/**
	 * Formatted server response
	 *
	 * @param $data
	 * @return formatted_server_response
	 */
	function formatted_server_response( $result ) {

		$this_result = "";
		
		if ($result['success']) {
			$this_result .= "Success: ID ".$result['id'];
		}
		else 
		{
			$this_result .= "Fatal error: HTTP status " .$result['http_status_code']. ", API status " .$result['api_status_code']. " Full details " .$result['details'];
		}

		return $this_result;
	}

	/**
	 * Send message
	 *
	 * @param $data
	 * @return send_message
	 */
	function send_message ( $get_url ) {
		$ch = curl_init( );
		curl_setopt ( $ch, CURLOPT_URL, $get_url );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		// Allowing cUrl funtions 20 second to execute
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 20 );
		// Waiting 20 seconds while trying to connect
		curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 20 );
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response_string = curl_exec( $ch );
		$curl_info = curl_getinfo( $ch );
		$sms_result = array();
		$sms_result['success'] = 0;
		$sms_result['details'] = '';
		$sms_result['http_status_code'] = $curl_info['http_code'];
		$sms_result['api_status_code'] = '';
		$sms_result['id'] = $response_string;

		if ( $response_string == FALSE ) {
			$sms_result['details'] .= "cURL error: " . curl_error( $ch ) . "\n";
		} elseif ( $curl_info[ 'http_code' ] != 200 ) {
			$sms_result['details'] .= "Error: non-200 HTTP status code: " . $curl_info[ 'http_code' ] . "\n";
		}
		else {
			$sms_result['details'] .= "Response from server: $response_string\n";
			$api_result = substr($response_string, 0, 2);
			$status_code = $api_result;
			$sms_result['api_status_code'] = $status_code;
			if ( $api_result != 'OK' ) {
					$sms_result['details'] .= "Error: could not parse valid return data from server.\n" . $api_result;
			} else {
					if ($status_code == 'OK') {
							$sms_result['success'] = 1;
					}
			}
		}

		curl_close( $ch );
		return $sms_result;
	}

	/**
	 * Seven bit sms
	 *
	 * @param $data
	 * @return seven_bit_sms
	 */
	function seven_bit_sms( $username, $password, $message, $mno, $sid, $fl, $mt)
	{
		$post_fields = array(
			'username' => $username,
			'password' => $password,
			'mno' => $mno,
			'sid' => $sid,
			'sfl' => $fl,
			'mt' => $mt,
			'message' => $message
		);

		return $this->make_post_body($post_fields);
	}

	/**
	 * Male post body
	 *
	 * @param $data
	 * @return make_post_body
	 */
	function make_post_body($post_fields) {

		$stop_dup_id = $this->make_stop_dup_id();

		if ($stop_dup_id > 0) {
			$post_fields['stop_dup_id'] = $this->make_stop_dup_id();
		}

		$post_body = '';

		foreach( $post_fields as $key => $value ) {
			$post_body .= urlencode( $key ).'='.urlencode($value).'&';
		}

		$post_body = rtrim( $post_body,'&' );

		return $post_body;
	}

	/**
	 * Make stop dup id
	 *
	 * @param 
	 * @return make_stop_dup_id
	 */
	function make_stop_dup_id() {
		return 0;
	}

	/**
	 * Right now date
	 *
	 * @param $date
	 * @return rightnow
	 */
	public function rightnow() {

		$time = microtime(true);
		$micro_time = sprintf("%06d", ($time - floor($time)) * 1000000);
		$date = new DateTime(date('Y-m-d H:i:s.'.$micro_time, $time));
		
		return $date->format("H:i:s.u");
	}

	/**
	 * Header
	 *
	 * @return header
	 */
	public function header() {

		$data['current'] = "home";
		
		// return $data
		return $this->load->view('frontend/template/header',$data, true);
	}

	/**
	 * Menu
	 *
	 * @return menu
	 */
	public function menu() {

		// return null
		return $this->load->view('frontend/template/menu', null, true);
	}

	/**
	 * Main template
	 *
	 * @param $data
	 * @return main_template
	 */
		public function main_template($data) {

			// return $data
			$this->load->view('frontend/template/main_template', $data);
		}

	/**
	 * Message add
	 *
	 * @param $data
	 * @return smsAdd
	 */
	public function smsAdd() {

		// Find user
		$user_one = $this->users_model->get_user_one($this->session->userdata('id'));
		$rec_code = $user_one->mb_recommend;
		
		// $data title, current, cs_info, user, settings, msg_price and main_content
		$data['title'] = '충전 | 글로벌문자';
		$data['current'] = 'smsAdd';
		$data['cs_info'] = $this->users_model->get_cs_info();
		$data['user'] = $user_one;
		$data['settings'] = $this->settings_model->get_settings();
		$data['msg_price'] = $this->settings_model->get_recommendation_one_by_id($rec_code);
		$data['main_content'] = 'frontend/smsAdd';
		
		$this->main_template($data);
	}

	/**
	 * Message add send
	 *
	 * @param $data
	 * @return smsAddSend
	 */
	public function smsAddSend() {
		
		// total_price and num_send
		$total_price = $this->input->post('total_price');
		$num_send = $this->input->post('num_send');

		// Timezine Asia/Seoul
		date_default_timezone_set("Asia/Seoul");

		// date
		$date = date('Y-m-d H:i:s');
		$data = array(
				'member_id' => $this->session->userdata('id'),
				'member_name' => $this->session->userdata('mb_id'),
				'total_price' => $total_price,
				'num_send' => $num_send,
				'created_date' => $date,
				'type' => 0,
		);

		$this->users_model->smsAddRequestSave($data);

		$this->load->view('vendor/autoload.php');

		$options = array(
				'cluster' => 'ap3',
				'useTLS' => true
		);

		// New pusher
		$pusher = new Pusher\Pusher(
				'86886ac93a23bc33e419',
				'4d0e4bc5891658f88bfc',
				'824740',
				$options
		);

		// data message and id
		$data['message'] = "<div class='notif_title1'>SMS 승인 요청 <a class='close' onclick='hideNotif($(this))'> x </a></div>  <div style='border-top: solid 1px #eee;'></div> <div class='notif_title2'> ".$this->session->userdata('mb_id')." - ".$total_price."</div>";
		$data['id'] = $insert_id;

		// mysql trigger
		$pusher->trigger('lcdns', 'my-event', $data);

		// data status done
		$data['status'] = 'done';
		die(json_encode($data));
	}

	/**
	 * My page
	 *
	 * @param $data
	 * @return mypage
	 */
	public function mypage($msg = null) {

		$id = $this->session->userdata('id');
		$data['title'] = '마이페이지 | 글로벌문자';
		$data['current'] = 'mypage';
		$data['user'] = $this->users_model->get_user_one($id);

		$rec_code = $data['user']->mb_recommend;
		$data['main_content'] = 'frontend/mypage';
		$data['stats'] = $this->users_model->count_user_messages($id);
		$data['msg_price'] = $this->settings_model->get_recommendation_one_by_id($rec_code);
		$messages = $this->users_model->get_msg_data($id);

		$total = $this->users_model->count_recharge($id);
		$total1 = $this->users_model->get_cash_history_rows($id);
		$per_pg = 5;
		$offset = $this->uri->segment(3, 0);
		$this->load->library('pagination');

		// config
		$config['base_url'] = base_url().'users/mypage';
		$config['total_rows'] = $total;
		$config['total_rows'] = $total1;
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

		// pagination config
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

		// data recharge_log, data, fail, success, unknown and msg
		$data['recharge_log'] = $this->users_model->get_recharge_log($id,$per_pg,$offset);

		// data cash, data, fail, success, unknown and msg
		$data["cash"] = $this->users_model->get_cash_history($id, $per_pg,$offset);
		
		$data['date'] = array();
		$data['fail'] = array();
		$data['success'] = array();
		$data['unknown'] = array();
		$data['msg'] = $msg;

		// loop
		foreach ($messages as $msg){
					array_push($data['date'], date('Y/m/d', strtotime($msg->created_date)));
					array_push($data['fail'], $msg->error_total);
					array_push($data['success'], $msg->delivered_total);

		};

		// view 
		$this->main_template($data);
	}
		
	/**
	 * Set per page
	 *
	 * @param $data
	 * @return setPerpg
	 */
	public function setPerpg() {

		// data
		$data = $this->input->post('data');
		
		$this->session->set_userdata('per_pg',$data);
		echo "success";
	}

	/**
	 * My page
	 *
	 * @param $data
	 * @return mypage
	 */
  public function SmsRequests() {

		$id = $this->session->userdata('id');
		$data['title'] = '결과 | 글로벌문자';
		$data['current'] = 'SmsRequests';
		$data['user'] = $this->users_model->get_user_one($id);
		$total = $this->users_model->get_member_msg_count($id);
		if ($this->session->userdata('per_pg')) {
					$per_pg = $this->session->userdata('per_pg');
		}else {
					$per_pg = 10;
		};


		$offset = $this->uri->segment(3, 0);

		$this->load->library('pagination');

		$config['base_url'] = base_url().'users/smsRequests';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = "<ul role='menubar' aria-disabled='false' aria-label='Pagination' class=' pagination b-pagination pagination-md justify-content-center'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = "<li role='none presentation' aria-hidden='true' class='page-item '><span class='page-link'>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li role='none presentation' class='page-item active '><a  class='page-link btn-primary '>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li role='none presentation' class='page-item ' aria-hidden='true'><span class='page-link'>";
		$config['next_tagl_close'] = "</span></li>";
		$config['prev_tag_open'] = "<li role='none presentation' class='page-item ' aria-hidden='true'><span
														class='page-link'>";
		$config['prev_tagl_close'] = "</span></li>";
		$config['first_tag_open'] = "<li ><span class='page-link'>";
		$config['first_tagl_close'] = "</span></li>";
		$config['last_tag_open'] = "<li><span class='page-link'>";
		$config['last_tagl_close'] = "</span></li>";

		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

		// data countstart, total, offset, per_pg, messages and main_content
		$data['countstart'] = $offset;
		$data['total'] = $total;
		$data['offset'] = $offset;
		$data['per_pg'] = $per_pg;
		$data['messages'] = $this->users_model->get_member_messages($id, $per_pg,$offset);
		$data['main_content'] = 'frontend/smsRequests';

		// return to view data
		$this->main_template($data);

	}

	/**
	 * Message request view
	 *
	 * @param $data
	 * @return SmsRequestView
	 */
	public function SmsRequestView($id) {

		// Find by id user
		$user_id = $this->session->userdata('id');

		// data, title, current, user and message_detail
		$data['title'] = '결과 | 글로벌문자';
		$data['current'] = 'SmsRequests';
		$data['user'] = $this->users_model->get_user_one($user_id);
		$data['message_detail'] = $this->users_model->get_member_message_detail($id);
		
		// total
		$total = $this->users_model->get_send_numbers_count($id);
		$per_pg = 40;
		$offset = $this->uri->segment(4, 0);

		$this->load->library('pagination');

		// config
		$config['base_url'] = base_url().'users/SmsRequestView/'.$id.'';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = "<ul role='menubar' aria-disabled='false' aria-label='Pagination' class='mt-4 pagination b-pagination pagination-md justify-content-center'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = "<li role='none presentation' aria-hidden='true' class='page-item '><span class='page-link'>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li role='none presentation' class='page-item active '><a  class='page-link btn-primary '>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li role='none presentation' class='page-item ' aria-hidden='true'><span class='page-link'>";
		$config['next_tagl_close'] = "</span></li>";
		$config['prev_tag_open'] = "<li role='none presentation' class='page-item ' aria-hidden='true'><span
														class='page-link'>";
		$config['prev_tagl_close'] = "</span></li>";
		$config['first_tag_open'] = "<li ><span class='page-link'>";
		$config['first_tagl_close'] = "</span></li>";
		$config['last_tag_open'] = "<li><span class='page-link'>";
		$config['last_tagl_close'] = "</span></li>";

		// Paginate config
		$this->pagination->initialize($config);

		// data pagination, countstart, numbers and main_content
		$data['pagination']=$this->pagination->create_links();
		$data['countstart'] = $offset;
		$data['numbers'] = $this->users_model->get_message_send_numbers($id, $per_pg,$offset);
		$data['main_content'] = 'frontend/smsRequestsView';

		// return to view data
		$this->main_template($data);
	}

	/**
	 * Message request phone search
	 *
	 * @param $data
	 * @return SmsRequestPhoneSearch
	 */
	public function SmsRequestPhoneSearch() {

		// input search and msg_id
		$search = $this->input->post('search');
		$id = $this->input->post('msg_id');

		// total 
		$total = $this->users_model->get_send_numbers_count($id);
		$per_pg = 5;
		$offset = $this->uri->segment(4, 0);

		$this->load->library('pagination');

		// config
		$config['base_url'] = base_url().'users/SmsRequestView/'.$id.'';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 4;
		$config['full_tag_open'] = "<ul role='menubar' aria-disabled='false' aria-label='Pagination' class='mt-4 pagination b-pagination pagination-md justify-content-center'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = "<li role='none presentation' aria-hidden='true' class='page-item '><span class='page-link'>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li role='none presentation' class='page-item active '><a  class='page-link btn-primary '>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li role='none presentation' class='page-item ' aria-hidden='true'><span class='page-link'>";
		$config['next_tagl_close'] = "</span></li>";
		$config['prev_tag_open'] = "<li role='none presentation' class='page-item ' aria-hidden='true'><span
														class='page-link'>";
		$config['prev_tagl_close'] = "</span></li>";
		$config['first_tag_open'] = "<li ><span class='page-link'>";
		$config['first_tagl_close'] = "</span></li>";
		$config['last_tag_open'] = "<li><span class='page-link'>";
		$config['last_tagl_close'] = "</span></li>";

		// Paginate config
		$this->pagination->initialize($config);

		//$data['pagination']=$this->pagination->create_links();
		//$data['countstart'] = $offset;
		$data = $this->users_model->search_message_send_numbers($id, $per_pg,$offset,$search);
		echo json_encode($data);

	}

	/**
	 * Message requests delete
	 *
	 * @param $data
	 * @return SmsRequestsDelete
	 */
	public function SmsRequestsDelete() {

		// inout id
		$data = $this->input->post('id');

		// loop data
		foreach ($data as $id) {
			$this->users_model->smsRequestsDelete($id);
			$this->users_model->smsDetailDelete($id);

			Logger::write("info", "message", "userId: " . $this->session->userdata('id') . ", username: " . $this->session->userdata('mb_id') . ", message id: " . $id . ", Delete has been success." );
		}
	}

	/**
	 * My page save
	 *
	 * @param $data
	 * @return mypage_save
	 */
	public function mypage_save() {

		// input id, name, current password and new password
		$id = $this->input->post('mb_id');
		$name = $this->input->post('name');
		$this->input->post('curr_pass');
		$pass = hash ( "sha256", $this->input->post('curr_pass') );
		$new_pass = hash ( "sha256", $this->input->post('new_pass') );

		// result
		$result = $this->users_model->check_cur_pass($id, $pass);
		
		// if result equal 1
		if ($result == 1) {
			$data = array(
					'mb_name' => $this->input->post('name'),
					'mb_password' => $new_pass,
			);

			$this->users_model->user_update($id, $data);

			$data['status'] = 'done';
			die(json_encode($data));
		} else {
			$data['status'] = '올바른 기존 비밀번호를 입력해 주세요';
			die(json_encode($data));
		}
	}

	/**
	 * Message send
	 *
	 * @param $data
	 * @return smsSend
	 */
	public function smsSend() {

		// data title and current
		$data['title'] = '회원가입약관 | 글로벌문자';
		$data['current'] = 'home';

		// Find by user id
		$id = $this->session->userdata('id');

		// data user and main_content
		$data['user'] = $this->users_model->get_user_one($id);
		$data['main_content'] = 'frontend/msg_send';

		// return to view data
		$this->main_template($data);
	}

	/**
	 * Message resend
	 *
	 * @param $data
	 * @return smsResend
	 */
	public function smsResend() {

		$recipients = array();
		$ret_data = array();

		if ($this->input->post('mno') != null) {

			// loop
			foreach (preg_split('/\r\n|\r|\n/', $this->input->post('mno')) as $num) {
				$num = preg_replace('/\s+/', '', $num);
				$num = str_replace(',', '', $num);
				$num = str_replace('.', '', $num);
				
				if ($num == '') {
						continue;
				}
				if(substr($num, 0, 1) === '+'){
					$num = str_replace('+', '', $num);
				} elseif (substr($num, 0, 3) === '010') {
					//$str = substr($num, 1);
					$str = substr($num, 3);
					$num = "8210" . $str . "";
				} elseif (substr($num, 0, 3) === '015') {
					//$str = substr($num, 1);
					$str = substr($num, 3);
					$num = "8215".$str."";
				} elseif(substr($num, 0, 2) === '10') {
					//$str = substr($num, 1);
					//$str = substr($num, 2);
					$num = "82".$num."";
				} elseif(substr($num, 0, 2) === '15') {
					//$str = substr($num, 1);
					//$str = substr($num, 2);
					$num = "82".$num."";
				}

				$num = str_replace('-', '', $num);
				array_push($recipients, $num);
			}
		}

		$phone_numbers = array_unique($recipients);
		// $rec_arr = array_chunk($phone_numbers,15);
		// var_dump($rec_arr);
		// die();
		$phone_count = sizeof($phone_numbers);

		//var_dump(array_unique($recipients)); die();

		if ($this->input->post('sid') == null) {
			$msg = 6;
			echo json_encode($msg);
			die();
		}

		if ($this->input->post('body') == null) {
			$msg = 3;
			echo json_encode($msg);
			die();
		}

		if ($phone_count < 1) {
			$msg = 4;
			echo json_encode($msg);
			die();
		}


		$seven_bit_msg = $this->input->post('body');

		$text_array = $this->mb_str_split($seven_bit_msg,70);
		$split_count = sizeof($text_array);
		$count = sizeof($text_array) * $phone_count;

		//echo $count;


		$sms_account = $this->settings_model->get_sms_account_one($this->input->post('sms_account'));

		$sms_account_id = $sms_account->id;
		if($sms_account->msg_limit < $count){

			$msg = 5;
			echo json_encode($msg);
			die();
		}


		$type = 1;
		$ipcl = $_SERVER['REMOTE_ADDR'];
		$flash = 0;

		$fl = $flash;
		$mt = $type;
		$Sid = $this->input->post('sid');

		$success_count = $this->input->post('success_count');

		$data = array(
			'quantity'	=>	$count + $success_count,
			'pending_count'	=>	$count,
			'error_count'	=>	0,
		);

		$this->users_model->msg_update($this->input->post('msg_id'), $data);
		$insert_id = $this->input->post('msg_id');

		$member_id = $this->session->userdata('id');

		$msgtext = 'upload/msg'.$insert_id;
		$msg_file = fopen($msgtext, 'w');
		fwrite($msg_file, $seven_bit_msg);
		fclose($msg_file);

		$phones = implode(',', $phone_numbers);
		$pho = 'upload/ph'.$insert_id;
		$pho_file = fopen($pho, 'w');
		fwrite($pho_file, $phones);
		fclose($pho_file);

		if($sms_account->name == '1s2u') {

			// $command = "php ".FCPATH."index.php msgsend admin_send_msg $insert_id $member_id $Sid > /dev/null &"; // linux server
			$command = "start /B php " . FCPATH . "index.php msgsend admin_send_msg $insert_id $sms_account_id $Sid > NUL"; //windows server
			pclose(popen($command, 'r'));
		}

		if($sms_account->name == 'Easysendsms') {

			// $command = "php ".FCPATH."index.php msgsend admin_easy_send_msg $insert_id $member_id $Sid > /dev/null &"; // linux server
			$command = "start /B php " . FCPATH . "index.php msgsend admin_easy_send_msg $insert_id $sms_account_id $Sid > NUL"; //windows server
			pclose(popen($command, 'r'));
		}

		// $new_quantity = $user_one->msg_quantity - $phone_count;


		// $data4 = array(
		// 		'msg_quantity' => $new_quantity,

		// );
		// $this->users_model->user_update($member_id, $data4);
		

		$msg = 2;
		echo json_encode($msg);


		die();
	}

	/**
	 * Message rep1
	 *
	 * @param $data
	 * @return msg_rep1
	 */
	public function msg_rep1($mno) {

		foreach (explode(',', $mno) as $num) {
			$num = preg_replace('/\s+/', '_', $num);

			if ($num == '') {
					continue;
			}

			if (substr($num, 0, 1) === '+') {
				$num = str_replace('+', '', $num);
			} elseif(substr($num, 0, 3) === '010') {
				$num = str_replace('010', '8210', $num);
			}

			$num = str_replace('-', '', $num);
			return $num;
		}
	}

	/**
	 * Message send
	 *
	 * @param $data
	 * @return send_msg
	 */
	public function send_msg() {

		// Find by banned numbers
		$banned_numbers = $this->users_model->get_banned_numbers();

		$bnarray = array();
		
		foreach ($banned_numbers as $asd) {
			array_push($bnarray,$asd->phone_number);
		}

		$recipients = array();
		$ret_data = array();
		$failed_num = array();
		if (isset($_FILES['file']['tmp_name'])) {
			$file = $_FILES['file']['tmp_name'];
			$filename = $_FILES['file']['name'];
		} else {
			$file = null;
			$filename = null;
		}

		if($this->input->post('mno') != null) {
			foreach(preg_split('/\r\n|\r|\n/', $this->input->post('mno')) as $num){
				$num = preg_replace('/\s+/', '', $num);
				$num = str_replace(',', '', $num);
				$num = str_replace('.', '', $num);
				$num = str_replace('-', '', $num);
				$num = str_replace('+', '', $num);
							
				if($num == ''){
					continue;
				}
				
				// replace + add country code KOREAN
				if (substr($num, 0, 3) === '010' && strlen($num) == 11 && substr($num, 3, 1) != 0 && substr($num, 3, 1) != 1) {
					$str = substr($num, 3);
					$num = "8210" . $str . "";
					$key = in_array($num, $bnarray);
						
						if ($key == 1) {
							array_push($failed_num, $num);
						} else {
							array_push($recipients, $num);
						}
				} elseif (substr($num, 0, 3) === '976') {

						$key = in_array($num, $bnarray);
						
						if($key == 1){
							array_push($failed_num, $num);
						}else {
							array_push($recipients, $num);
						}
				} elseif (substr($num, 0, 4) === '8210' && strlen($num) == 12 && substr($num, 4, 1) != 0 && substr($num, 4, 1) != 1) {
						$key = in_array($num, $bnarray);
						
						if ($key == 1) {
							array_push($failed_num, $num);
						} else {
							array_push($recipients, $num);
						}
				} elseif (substr($num, 0, 2) === '10' && strlen($num) == 10 && substr($num, 2, 1) != 0 && substr($num, 2, 1) != 1) {
					$str = substr($num, 2);
					$num = "8210" . $str . "";
					$key = in_array($num, $bnarray);
					
					if ($key == 1) {
							array_push($failed_num, $num);
					} else {
							array_push($recipients, $num);
					}
				} else {
						array_push($failed_num, $num);
				}
			}
		}
		
		if($file != null) {
			$pos = strrpos($filename, '.');
			$ext = strtolower(substr($filename, $pos, strlen($filename)));
			switch ($ext) {
				case '.txt':
					$data = file($file);
					foreach ($data as $num) {
							
						if (substr($num, 0, 3) == "\xEF\xBB\xBF") {
							$num = substr($num, 3);
						}

						$num = trim($num);
						$num = preg_replace('/\s+/', '', $num);
						$num = str_replace(',', '', $num);
						$num = str_replace('.', '', $num);
						$num = str_replace('-', '', $num);
						$num = str_replace('+', '', $num);
						if($num == ''){
							continue;
						}
						// replace + add country code KOREAN
						if(substr($num, 0, 3) === '010' && strlen($num) == 11 && substr($num, 3, 1) != 0 && substr($num, 3, 1) != 1) {
								$str = substr($num, 3);
								$num = "8210" . $str . "";
								$key = in_array($num, $bnarray);
								if($key == 1){
										array_push($failed_num, $num);
								}else {
										array_push($recipients, $num);
								}
						}elseif(substr($num, 0, 3) === '976') {
								$key = in_array($num, $bnarray);
								if($key == 1){
										array_push($failed_num, $num);
								}else {
										array_push($recipients, $num);
								}
						}elseif (substr($num, 0, 4) === '8210' && strlen($num) == 12 && substr($num, 4, 1) != 0 && substr($num, 4, 1) != 1) {
								$key = in_array($num, $bnarray);
								if($key == 1){
										array_push($failed_num, $num);
								}else {
										array_push($recipients, $num);
								}
						} elseif (substr($num, 0, 2) === '10' && strlen($num) == 10 && substr($num, 2, 1) != 0 && substr($num, 2, 1) != 1) {
								$str = substr($num, 2);
								$num = "8210" . $str . "";
								$key = in_array($num, $bnarray);
								if($key == 1){
										array_push($failed_num, $num);
								}else {
										array_push($recipients, $num);
								}
						} else {
								array_push($failed_num, $num);
						}
					}
				break;			
				case '.csv' :
					$data = file($file);			
					$num_rows = count($data) + 1;
					$csv = array();
					foreach ($data as $num) {
							if (substr($num, 0, 3) == "\xEF\xBB\xBF") {
									$num = substr($num, 3);
							}
							$num = explode(',', $num);

							$num[1] = get_hp($num[1]);

							$num = preg_replace('/\s+/', '_', $num);
							$num = str_replace(',', '', $num);
							$num = str_replace('.', '', $num);
							$num = str_replace('-', '', $num);
							$num = str_replace('+', '', $num);
							if ($num == '') {
								continue;
							}
							// replace + add country code KOREAN
							if(substr($num, 0, 3) === '010' && strlen($num) == 11 && substr($num, 3, 1) != 0 && substr($num, 3, 1) != 1) {
								$str = substr($num, 3);
								$num = "8210" . $str . "";
								$key = in_array($num, $bnarray);
								if ($key == 1) {
										array_push($failed_num, $num);
								} else {
										array_push($recipients, $num);
								}
							} elseif(substr($num, 0, 3) === '976') {
								$key = in_array($num, $bnarray);
								
								if($key == 1){
										array_push($failed_num, $num);
								}else {
										array_push($recipients, $num);
								}
							} elseif (substr($num, 0, 4) === '8210' && strlen($num) == 12 && substr($num, 4, 1) != 0 && substr($num, 4, 1) != 1) {
								$key = in_array($num, $bnarray);
								
								if($key == 1){
										array_push($failed_num, $num);
								}else {
										array_push($recipients, $num);
								}
							} elseif (substr($num, 0, 2) === '10' && strlen($num) == 10 && substr($num, 2, 1) != 0 && substr($num, 2, 1) != 1) {
								$str = substr($num, 2);
								$num = "8210" . $str . "";
								$key = in_array($num, $bnarray);
								
								if($key == 1){
										array_push($failed_num, $num);
								} else {
										array_push($recipients, $num);
								}
							} else {
								array_push($failed_num, $num);
							}
					}
					break;
							case '.xlsx' :
									$this->load->library('excel');
									$objPHPExcel = new PHPExcel();
									// 업로드 된 엑셀 형식에 맞는 Reader객체를 만든다.

									$objReader = PHPExcel_IOFactory::createReaderForFile($file);
									// 읽기전용으로 설정

									$objReader->setReadDataOnly(true);
									// 엑셀파일을 읽는다

									$objExcel = $objReader->load($file);

									// 첫번째 시트를 선택

									$objExcel->setActiveSheetIndex(0);

									$objWorksheet = $objExcel->getActiveSheet();

									$rowIterator = $objWorksheet->getRowIterator();

									foreach ($rowIterator as $row) { // 모든 행에 대해서

											$cellIterator = $row->getCellIterator();

											$cellIterator->setIterateOnlyExistingCells(false);

									}

									$maxRow = $objWorksheet->getHighestRow();

									for ($i = 0; $i <= $maxRow; $i++) {
											$num = $objWorksheet->getCell('A' . $i)->getValue();
											if ($num != null) {
													$num = preg_replace('/\s+/', '_', $num);
													$num = str_replace(',', '', $num);
													$num = str_replace('.', '', $num);
													$num = str_replace('-', '', $num);
													$num = str_replace('+', '', $num);
													if($num == ''){
															continue;
													}
													// replace + add country code KOREAN
													if(substr($num, 0, 3) === '010' && strlen($num) == 11 && substr($num, 3, 1) != 0 && substr($num, 3, 1) != 1) {
															$str = substr($num, 3);
															$num = "8210" . $str . "";
															$key = in_array($num, $bnarray);
															if($key == 1){
																	array_push($failed_num, $num);
															}else {
																	array_push($recipients, $num);
															}
													}elseif(substr($num, 0, 3) === '976') {

															$key = in_array($num, $bnarray);
															if($key == 1){
																	array_push($failed_num, $num);
															}else {
																	array_push($recipients, $num);
															}
													}elseif (substr($num, 0, 4) === '8210' && strlen($num) == 12 && substr($num, 4, 1) != 0 && substr($num, 4, 1) != 1) {
															$key = in_array($num, $bnarray);
															if($key == 1){
																	array_push($failed_num, $num);
															}else {
																	array_push($recipients, $num);
															}
													}elseif (substr($num, 0, 2) === '10' && strlen($num) == 10 && substr($num, 2, 1) != 0 && substr($num, 2, 1) != 1) {
															$str = substr($num, 2);
															$num = "8210" . $str . "";
															$key = in_array($num, $bnarray);
															if($key == 1){
																	array_push($failed_num, $num);
															}else {
																	array_push($recipients, $num);
															}
													}else {
															array_push($failed_num, $num);
													}
											}
									}
									break;
							default :
									alert_after('xlsx, csv, txt파일만 허용합니다.');
					}
			}


			$phone_numbers = array_unique($recipients);

			$phone_count = sizeof($phone_numbers);
			$failed_num = array_unique($failed_num);
			$failed_count = sizeof($failed_num);
			//var_dump(array_unique($recipients)); die();

			if($this->input->post('sid') == null){
					$msg = 6;
					echo json_encode($msg);
					die();
			}

			if($this->input->post('body') == null){
					$msg = 3;
					echo json_encode($msg);
					die();
			}

			if($phone_count < 1){
					$msg = 4;
					echo json_encode($msg);
					die();
			}	



			$seven_bit_msg = $this->input->post('body');

			$text_array = $this->mb_str_split($seven_bit_msg,70);
			$split_count = sizeof($text_array);
			$count = sizeof($text_array) * $phone_count;

			//echo $count;
			$account_limit = $this->settings_model->get_account_limit();
			$user_one = $this->users_model->get_user_one($this->session->userdata('id'));
			$smsaccount = $this->settings_model->get_sms_account_one($user_one->sms_account_id);
			$price = $this->settings_model->get_recommendation_one_by_id($user_one->mb_recommend);
			$sms_api = $this->settings_model->get_api_one($user_one->sms_send_account);

			// if user dont have recommendation alert and die process
			if(!isset($price->msg_price)){
				$msg = 12;
				echo json_encode($msg);
				die();
			}

			if($user_one->msg_quantity < $count){
					$msg = 5;
					echo json_encode($msg);
					die();
			}
			
			if(empty($price->msg_price)){
				$msg = 12;
				echo json_encode($msg);
				die();
			} 

			if($account_limit->msg_limit_count < $count){
					$msg = 11;
					echo json_encode($msg);
					die();
			}

			//  if($smsaccount->msg_limit < $count){
			//      $msg = 11;
			//      echo json_encode($msg);
			//      die();
			//  }


			$type = 1;
			$ipcl = $_SERVER['REMOTE_ADDR'];
			$flash = 0;

			$fl = $flash;
			$mt = $type;
			$Sid = $this->input->post('sid');

			date_default_timezone_set("Asia/Seoul");
			$date =  date('Y-m-d H:i:s');
			
			if($user_one->msg_quantity >= $count){
				
				// update user cash
				$data1 = array(
					'msg_quantity' => $user_one->msg_quantity - $count,
				);

				$this->users_model->user_update($this->session->userdata('id'), $data1);

				// insert message
				$data2 = array(
					'member_id'	=>	$this->session->userdata('id'),
					'sender'	=>	$Sid,
					'message'	=>	$seven_bit_msg,
					'quantity'	=>	$phone_count + $failed_count,
					'pending_count'	=>	$count,
					'error_count'=> $failed_count,
					'split_count'	=>	$split_count,
					'ph_quantity'	=>	0,
					'type'	=>	$mt,
					'ipcl'	=>	$ipcl,
					'message_success'	=>	1,
					'msg' => null,
					'created_date'	=>	$date,
					//'sms_account'	=>	$smsaccount->username,
				);
				$insert_id = $this->users_model->msg_add($data2);


				Logger::write("info", "message", "userId: " . $this->session->userdata('id') . ", username: " . $this->session->userdata('mb_id') . ", message id: " . $insert_id . ", Filter has been operated." );
				
				$save_phone_number = array();

				//insert message detail
				foreach($phone_numbers as $nb ) {
					$data3 = array(
						'sender'	=>	$Sid,
						'message_id'	=>	$insert_id,
						'phone_number'	=>	$nb,
						'success'	=>	null,
						'code'	=>	"Pending",
					);
					array_push($save_phone_number,$data3);
				}

				if (sizeof($save_phone_number) > 0) {
					$this->db->insert_batch('message_send_detail',$save_phone_number);
				};

				// Insert to cash_history
				$data4 = array(
					'member_id' => $this->session->userdata('id'),
					'message_id'	=>	$insert_id,
					'cash' => ('-'. $count),
					'success' => 'Cash out',
					'system' => 'System',
					'created_date' => $date
				);

				$this->users_model->cash_history_add($data4);

				Logger::write("info", "message", "userId: " . $this->session->userdata('id') . ", username: " . $this->session->userdata('mb_id') . ", refund: -" . $count . ", Cash out has been completed." );
			}
			
			$save_details = array();

			$f = 0;

			foreach($failed_num as $ph){$f++;
					$insert_row = array(
							'sender'	=>	$Sid,
							'message_id'	=>	$insert_id,
							'phone_number'	=>	$ph,
							'success'	=>	3,
					);
					array_push($save_details,$insert_row);
			};

			if (sizeof($save_details) > 0) {
				$this->db->insert_batch('message_send_detail',$save_details);
			};	

			if ($failed_num) {
				// Insert to cash_history
				$data10 = array(
					'member_id' => $this->session->userdata('id'),
					'message_id'	=>	$insert_id,
					'cash' => ('+'. $f),
					'success' => 'Refund',
					'system' => 'System',
					'created_date' => $date
				);

				$this->users_model->cash_history_add($data10);

				Logger::write("info", "message", "userId: " . $this->session->userdata('id') . ", username: " . $this->session->userdata('mb_id') . ", refund: +" . $f . ", Refund has been completed." );
			}

			$member_id = $this->session->userdata('id');

			$date = date('Y-m-d');

			// create directory/folder uploads message
			$msg_filedir = "upload/messages/".$date."";
			if (!file_exists($msg_filedir))
			{
				mkdir($msg_filedir, 0777, true);
			}
			
			$msgtext = ''. $msg_filedir .'/msg'.$insert_id;
			$msg_file = fopen($msgtext, 'w');
			fwrite($msg_file, $seven_bit_msg);
			fclose($msg_file);
			
			$phones = implode(',', $phone_numbers);

			// create directory/folder uploads message
			$phones_filedir = "upload/phones/".$date."";
			if (!file_exists($phones_filedir))
			{
				mkdir($phones_filedir, 0777, true);
			}

			$pho = ''. $phones_filedir .'/ph'.$insert_id;
			$pho_file = fopen($pho, 'w');
			fwrite($pho_file, $phones);
			fclose($pho_file);

			$command = "php ".FCPATH."index.php msgsend send_message_all $insert_id $member_id $Sid > /dev/null &"; // linux server
			//$command = "start /B php " . FCPATH . "index.php msgsend send_message_all $insert_id $member_id $Sid > NUL"; //windows server
			pclose(popen($command, 'r'));


			$msg = 2;
			echo json_encode($msg);


			die();
	}

	/**
	 * Message send version old
	 *
	 * @param $data
	 * @return send_msg_v_old
	 */
	public function send_msg_v_old()
	{
		$banned_numbers = $this->users_model->get_banned_numbers();
		$bnarray = array();
		foreach ($banned_numbers as $asd)
		{
				array_push($bnarray,$asd->phone_number);
		}


		$recipients = array();
		$ret_data = array();
		$failed_num = array();
		if(isset($_FILES['file']['tmp_name'])){
				$file = $_FILES['file']['tmp_name'];
				$filename = $_FILES['file']['name'];
		}else{
				$file = null;
				$filename = null;
		}

		if($this->input->post('mno') != null) {
				foreach(preg_split('/\r\n|\r|\n/', $this->input->post('mno')) as $num){
						$num = preg_replace('/\s+/', '', $num);
						$num = str_replace(',', '', $num);
						$num = str_replace('.', '', $num);
						$num = str_replace('-', '', $num);
						$num = str_replace('+', '', $num);
						if($num == ''){
								continue;
						}
						// replace + add country code KOREAN
						if(substr($num, 0, 3) === '010' && strlen($num) == 11 && substr($num, 3, 1) != 0 && substr($num, 3, 1) != 1) {
								$str = substr($num, 3);
								$num = "8210" . $str . "";
								$key = in_array($num, $bnarray);
								if($key == 1){
										array_push($failed_num, $num);
								}else {
										array_push($recipients, $num);
								}
						}elseif(substr($num, 0, 3) === '976') {

								$key = in_array($num, $bnarray);
								if($key == 1){
										array_push($failed_num, $num);
								}else {
										array_push($recipients, $num);
								}
						}elseif (substr($num, 0, 4) === '8210' && strlen($num) == 12 && substr($num, 4, 1) != 0 && substr($num, 4, 1) != 1) {
								$key = in_array($num, $bnarray);
								if($key == 1){
										array_push($failed_num, $num);
								}else {
										array_push($recipients, $num);
								}
						}elseif (substr($num, 0, 2) === '10' && strlen($num) == 10 && substr($num, 2, 1) != 0 && substr($num, 2, 1) != 1) {
								$str = substr($num, 2);
								$num = "8210" . $str . "";
								$key = in_array($num, $bnarray);
								if($key == 1){
										array_push($failed_num, $num);
								}else {
										array_push($recipients, $num);
								}
						}else {
								array_push($failed_num, $num);
						}

				}

		}
		if($file != null) {
				$pos = strrpos($filename, '.');
				$ext = strtolower(substr($filename, $pos, strlen($filename)));
				switch ($ext) {
						case '.txt':
								$data = file($file);
								foreach ($data as $num) {
										if (substr($num, 0, 3) == "\xEF\xBB\xBF") {
												$num = substr($num, 3);
										}
										$num = trim($num);
										$num = preg_replace('/\s+/', '', $num);
										$num = str_replace(',', '', $num);
										$num = str_replace('.', '', $num);
										$num = str_replace('-', '', $num);
										$num = str_replace('+', '', $num);
										if($num == ''){
												continue;
										}
										// replace + add country code KOREAN
										if(substr($num, 0, 3) === '010' && strlen($num) == 11 && substr($num, 3, 1) != 0 && substr($num, 3, 1) != 1) {
												$str = substr($num, 3);
												$num = "8210" . $str . "";
												$key = in_array($num, $bnarray);
												if($key == 1){
														array_push($failed_num, $num);
												}else {
														array_push($recipients, $num);
												}
										}elseif(substr($num, 0, 3) === '976') {

												$key = in_array($num, $bnarray);
												if($key == 1){
														array_push($failed_num, $num);
												}else {
														array_push($recipients, $num);
												}
										}elseif (substr($num, 0, 4) === '8210' && strlen($num) == 12 && substr($num, 4, 1) != 0 && substr($num, 4, 1) != 1) {
												$key = in_array($num, $bnarray);
												if($key == 1){
														array_push($failed_num, $num);
												}else {
														array_push($recipients, $num);
												}
										}elseif (substr($num, 0, 2) === '10' && strlen($num) == 10 && substr($num, 2, 1) != 0 && substr($num, 2, 1) != 1) {
												$str = substr($num, 2);
												$num = "8210" . $str . "";
												$key = in_array($num, $bnarray);
												if($key == 1){
														array_push($failed_num, $num);
												}else {
														array_push($recipients, $num);
												}
										}else {
												array_push($failed_num, $num);
										}
								}
								break;
						case '.csv' :
								$data = file($file);
								$num_rows = count($data) + 1;
								$csv = array();
								foreach ($data as $num) {
										if (substr($num, 0, 3) == "\xEF\xBB\xBF") {
												$num = substr($num, 3);
										}
										$num = explode(',', $num);

										$num[1] = get_hp($num[1]);

										$num = preg_replace('/\s+/', '_', $num);
										$num = str_replace(',', '', $num);
										$num = str_replace('.', '', $num);
										$num = str_replace('-', '', $num);
										$num = str_replace('+', '', $num);
										if($num == ''){
												continue;
										}
										// replace + add country code KOREAN
										if(substr($num, 0, 3) === '010' && strlen($num) == 11 && substr($num, 3, 1) != 0 && substr($num, 3, 1) != 1) {
												$str = substr($num, 3);
												$num = "8210" . $str . "";
												$key = in_array($num, $bnarray);
												if($key == 1){
														array_push($failed_num, $num);
												}else {
														array_push($recipients, $num);
												}
										}elseif(substr($num, 0, 3) === '976') {

												$key = in_array($num, $bnarray);
												if($key == 1){
														array_push($failed_num, $num);
												}else {
														array_push($recipients, $num);
												}
										}elseif (substr($num, 0, 4) === '8210' && strlen($num) == 12 && substr($num, 4, 1) != 0 && substr($num, 4, 1) != 1) {
												$key = in_array($num, $bnarray);
												if($key == 1){
														array_push($failed_num, $num);
												}else {
														array_push($recipients, $num);
												}
										}elseif (substr($num, 0, 2) === '10' && strlen($num) == 10 && substr($num, 2, 1) != 0 && substr($num, 2, 1) != 1) {
												$str = substr($num, 2);
												$num = "8210" . $str . "";
												$key = in_array($num, $bnarray);
												if($key == 1){
														array_push($failed_num, $num);
												}else {
														array_push($recipients, $num);
												}
										}else {
												array_push($failed_num, $num);
										}
								}
								break;
						case '.xlsx' :
								$this->load->library('excel');
								$objPHPExcel = new PHPExcel();
								// 업로드 된 엑셀 형식에 맞는 Reader객체를 만든다.

								$objReader = PHPExcel_IOFactory::createReaderForFile($file);
								// 읽기전용으로 설정

								$objReader->setReadDataOnly(true);
								// 엑셀파일을 읽는다

								$objExcel = $objReader->load($file);

								// 첫번째 시트를 선택

								$objExcel->setActiveSheetIndex(0);

								$objWorksheet = $objExcel->getActiveSheet();

								$rowIterator = $objWorksheet->getRowIterator();

								foreach ($rowIterator as $row) { // 모든 행에 대해서

										$cellIterator = $row->getCellIterator();

										$cellIterator->setIterateOnlyExistingCells(false);

								}

								$maxRow = $objWorksheet->getHighestRow();

								for ($i = 0; $i <= $maxRow; $i++) {
										$num = $objWorksheet->getCell('A' . $i)->getValue();
										if ($num != null) {
												$num = preg_replace('/\s+/', '_', $num);
												$num = str_replace(',', '', $num);
												$num = str_replace('.', '', $num);
												$num = str_replace('-', '', $num);
												$num = str_replace('+', '', $num);
												if($num == ''){
														continue;
												}
												// replace + add country code KOREAN
												if(substr($num, 0, 3) === '010' && strlen($num) == 11 && substr($num, 3, 1) != 0 && substr($num, 3, 1) != 1) {
														$str = substr($num, 3);
														$num = "8210" . $str . "";
														$key = in_array($num, $bnarray);
														if($key == 1){
																array_push($failed_num, $num);
														}else {
																array_push($recipients, $num);
														}
												}elseif(substr($num, 0, 3) === '976') {

														$key = in_array($num, $bnarray);
														if($key == 1){
																array_push($failed_num, $num);
														}else {
																array_push($recipients, $num);
														}
												}elseif (substr($num, 0, 4) === '8210' && strlen($num) == 12 && substr($num, 4, 1) != 0 && substr($num, 4, 1) != 1) {
														$key = in_array($num, $bnarray);
														if($key == 1){
																array_push($failed_num, $num);
														}else {
																array_push($recipients, $num);
														}
												}elseif (substr($num, 0, 2) === '10' && strlen($num) == 10 && substr($num, 2, 1) != 0 && substr($num, 2, 1) != 1) {
														$str = substr($num, 2);
														$num = "8210" . $str . "";
														$key = in_array($num, $bnarray);
														if($key == 1){
																array_push($failed_num, $num);
														}else {
																array_push($recipients, $num);
														}
												}else {
														array_push($failed_num, $num);
												}
										}
								}
								break;
						default :
								alert_after('xlsx, csv, txt파일만 허용합니다.');
				}
		}


		$phone_numbers = array_unique($recipients);

		$phone_count = sizeof($phone_numbers);
		$failed_num = array_unique($failed_num);
		$failed_count = sizeof($failed_num);
		//var_dump(array_unique($recipients)); die();

		if($this->input->post('sid') == null){
				$msg = 6;
				echo json_encode($msg);
				die();
		}

		if($this->input->post('body') == null){
				$msg = 3;
				echo json_encode($msg);
				die();
		}

		if($phone_count < 1){
				$msg = 4;
				echo json_encode($msg);
				die();
		}


		$seven_bit_msg = $this->input->post('body');

		$text_array = $this->mb_str_split($seven_bit_msg,70);
		$split_count = sizeof($text_array);
		$count = sizeof($text_array) * $phone_count;

		//echo $count;

		$user_one = $this->users_model->get_user_one($this->session->userdata('id'));
		$smsaccount = $this->settings_model->get_sms_account_one($user_one->sms_account_id);
		$price = $this->settings_model->get_recommendation_one_by_id($user_one->mb_recommend);
		$sms_api = $this->settings_model->get_api_one($user_one->sms_send_account);
		if($user_one->msg_quantity < $count){
				$msg = 5;
				echo json_encode($msg);
				die();
		}

		if($smsaccount->msg_limit < $count){
				$msg = 11;
				echo json_encode($msg);
				die();
		}


		$type = 1;
		$ipcl = $_SERVER['REMOTE_ADDR'];
		$flash = 0;

		$fl = $flash;
		$mt = $type;
		$Sid = $this->input->post('sid');

		date_default_timezone_set("Asia/Seoul");
		$date =  date('Y-m-d H:i:s');
		$data = array(
				'member_id'	=>	$this->session->userdata('id'),
				'sender'	=>	$Sid,
				'message'	=>	$seven_bit_msg,
				'quantity'	=>	$phone_count + $failed_count,
				'pending_count'	=>	$count,
				'error_count'=> $failed_count,
				'split_count'	=>	$split_count,
				'ph_quantity'	=>	0,
				'type'	=>	$mt,
				'ipcl'	=>	$ipcl,
				'message_success'	=>	1,
				'msg' => null,
				'created_date'	=>	$date,
				'sms_account'	=>	$smsaccount->username,
		);
		$insert_id = $this->users_model->msg_add($data);


		$save_details = array();

		foreach($failed_num as $ph){
					$insert_row = array(
							'sender'	=>	$Sid,
							'message_id'	=>	$insert_id,
							'phone_number'	=>	$ph,
							'success'	=>	3,
					);
					array_push($save_details,$insert_row);
		};
		if (sizeof($save_details) > 0) {
					$this->db->insert_batch('message_send_detail',$save_details);
		};

		$member_id = $this->session->userdata('id');

		$msgtext = 'upload/msg'.$insert_id;
		$msg_file = fopen($msgtext, 'w');
		fwrite($msg_file, $seven_bit_msg);
		fclose($msg_file);

		$phones = implode(',', $phone_numbers);
		$pho = 'upload/ph'.$insert_id;
		$pho_file = fopen($pho, 'w');
		fwrite($pho_file, $phones);
		fclose($pho_file);
		if($sms_api->name == '1s2u') {

				$command = "php ".FCPATH."index.php msgsend send_msg $insert_id $member_id $Sid > /dev/null &"; // linux server
				//$command = "start /B php " . FCPATH . "index.php msgsend send_msg $insert_id $member_id $Sid > NUL"; //windows server
				pclose(popen($command, 'r'));
		}elseif($sms_api->name == 'Easysendsms') {

				$command = "php ".FCPATH."index.php msgsend easy_send_msg $insert_id $member_id $Sid > /dev/null &"; // linux server
				//$command = "start /B php " . FCPATH . "index.php msgsend easy_send_msg $insert_id $member_id $Sid > NUL"; //windows server
				pclose(popen($command, 'r'));
		}elseif($sms_api->name == 'Ediarosms') {

					$command = "php ".FCPATH."index.php msgsend ediaro_send_msg $insert_id $member_id $Sid > /dev/null &"; // linux server
					//$command = "start /B php " . FCPATH . "index.php msgsend ediaro_send_msg $insert_id $member_id $Sid > NUL"; //windows server
					pclose(popen($command, 'r'));
			}
			elseif($sms_api->name == 'Routee') {

						$command = "php ".FCPATH."index.php msgsend routee_msg $insert_id $member_id $Sid > /dev/null &"; // linux server
						//$command = "start /B php " . FCPATH . "index.php msgsend routee_msg $insert_id $member_id $Sid > NUL"; //windows server
						pclose(popen($command, 'r'));
				}

		$msg = 2;
		echo json_encode($msg);


		die();
	}

	/**
	 * Send message old version
	 *
	 * @param $data
	 * @return send_msg_old
	 */
    public function send_msg_old()
    {
        $sms_account = $this->settings_model->get_sms_account_default();
        $recipients = array();
        $ret_data = array();
        if($this->input->post('fl') == 1){
            $file = $_FILES['file']['tmp_name'];
            $filename = $_FILES['file']['name'];
        }else{
            $file = null;
            $filename = null;
        }

        if($this->input->post('mno') != null) {
            foreach(preg_split('/\r\n|\r|\n/', $this->input->post('mno')) as $num){
                $num = preg_replace('/\s+/', '', $num);
                $num = str_replace(',', '', $num);
                $num = str_replace('.', '', $num);
                if($num == ''){
                    continue;
                }
                if(substr($num, 0, 1) === '+'){
                    $num = str_replace('+', '', $num);
                }elseif(substr($num, 0, 3) === '010') {
                    //$str = substr($num, 1);
                    $str = substr($num, 3);
                    $num = "8210" . $str . "";
                }elseif(substr($num, 0, 3) === '015'){
                    //$str = substr($num, 1);
                    $str = substr($num, 3);
                    $num = "8215".$str."";
                }elseif(substr($num, 0, 2) === '10'){
                    //$str = substr($num, 1);
                    //$str = substr($num, 2);
                    $num = "82".$num."";
                }elseif(substr($num, 0, 2) === '15'){
                    //$str = substr($num, 1);
                    //$str = substr($num, 2);
                    $num = "82".$num."";
                }

                $num = str_replace('-', '', $num);
                array_push($recipients, $num);
            }

        }
        if($file != null) {
            $pos = strrpos($filename, '.');
            $ext = strtolower(substr($filename, $pos, strlen($filename)));
            switch ($ext) {
                case '.txt':
                    $data = file($file);
                    foreach ($data as $num) {
                        if (substr($num, 0, 3) == "\xEF\xBB\xBF") {
                            $num = substr($num, 3);
                        }
                        $num = trim($num);
                        $num = preg_replace('/\s+/', '', $num);
                        $num = str_replace(',', '', $num);
                        $num = str_replace('.', '', $num);
                        if($num == ''){
                            continue;
                        }
                        if(substr($num, 0, 1) === '+'){
                            $num = str_replace('+', '', $num);
                        }elseif(substr($num, 0, 3) === '010') {
                            //$str = substr($num, 1);
                            $str = substr($num, 3);
                            $num = "8210" . $str . "";
                        }elseif(substr($num, 0, 3) === '015'){
                                //$str = substr($num, 1);
                            $str = substr($num, 3);
                            $num = "8215".$str."";
                        }elseif(substr($num, 0, 2) === '10'){
                            //$str = substr($num, 1);
                            //$str = substr($num, 2);
                            $num = "82".$num."";
                        }elseif(substr($num, 0, 2) === '15'){
                            //$str = substr($num, 1);
                            //$str = substr($num, 2);
                            $num = "82".$num."";
                        }

                        $num = str_replace('-', '', $num);
                        array_push($recipients, $num);
                    }
                    break;
                case '.csv' :
                    $data = file($file);
                    $num_rows = count($data) + 1;
                    $csv = array();
                    foreach ($data as $num) {
                        if (substr($num, 0, 3) == "\xEF\xBB\xBF") {
                            $num = substr($num, 3);
                        }
                        $num = explode(',', $num);

                        $num[1] = get_hp($num[1]);

                        $num = preg_replace('/\s+/', '_', $num);
                        $num = str_replace(',', '', $num);
                        $num = str_replace('.', '', $num);
                        if($num == ''){
                            continue;
                        }
                        if(substr($num, 0, 1) === '+'){
                            $num = str_replace('+', '', $num);
                        }elseif(substr($num, 0, 3) === '010') {
                            //$str = substr($num, 1);
                            $str = substr($num, 3);
                            $num = "8210" . $str . "";
                        }elseif(substr($num, 0, 3) === '015'){
                            //$str = substr($num, 1);
                            $str = substr($num, 3);
                            $num = "8215".$str."";
                        }elseif(substr($num, 0, 2) === '10'){
                            //$str = substr($num, 1);
                            //$str = substr($num, 2);
                            $num = "82".$num."";
                        }elseif(substr($num, 0, 2) === '15'){
                            //$str = substr($num, 1);
                            //$str = substr($num, 2);
                            $num = "82".$num."";
                        }

                        $num = str_replace('-', '', $num);
                        array_push($recipients, $num);
                    }
                    break;
                case '.xlsx' :
                    $this->load->library('excel');
                    $objPHPExcel = new PHPExcel();
                    // 업로드 된 엑셀 형식에 맞는 Reader객체를 만든다.

                    $objReader = PHPExcel_IOFactory::createReaderForFile($file);
                    // 읽기전용으로 설정

                    $objReader->setReadDataOnly(true);
                    // 엑셀파일을 읽는다

                    $objExcel = $objReader->load($file);

                    // 첫번째 시트를 선택

                    $objExcel->setActiveSheetIndex(0);

                    $objWorksheet = $objExcel->getActiveSheet();

                    $rowIterator = $objWorksheet->getRowIterator();

                    foreach ($rowIterator as $row) { // 모든 행에 대해서

                        $cellIterator = $row->getCellIterator();

                        $cellIterator->setIterateOnlyExistingCells(false);

                    }

                    $maxRow = $objWorksheet->getHighestRow();

                    for ($i = 0; $i <= $maxRow; $i++) {
                        $num = $objWorksheet->getCell('A' . $i)->getValue();
                        if ($num != null) {
                            $num = preg_replace('/\s+/', '_', $num);
                            $num = str_replace(',', '', $num);
                            $num = str_replace('.', '', $num);
                            if($num == ''){
                                continue;
                            }
                            if (substr($num, 0, 3) == "\xEF\xBB\xBF") {
                                $num = substr($num, 3);
                            }

                            if(substr($num, 0, 1) === '+'){
                                $num = str_replace('+', '', $num);
                            }elseif(substr($num, 0, 3) === '010') {
                                //$str = substr($num, 1);
                                $str = substr($num, 3);
                                $num = "8210" . $str . "";
                            }elseif(substr($num, 0, 3) === '015'){
                                //$str = substr($num, 1);
                                $str = substr($num, 3);
                                $num = "8215".$str."";
                            }elseif(substr($num, 0, 2) === '10'){
                                //$str = substr($num, 1);
                                //$str = substr($num, 2);
                                $num = "82".$num."";
                            }elseif(substr($num, 0, 2) === '15'){
                                //$str = substr($num, 1);
                                //$str = substr($num, 2);
                                $num = "82".$num."";
                            }

                            $num = str_replace('-', '', $num);
                            array_push($recipients, $num);
                        }
                    }
                    break;
                default :
                    alert_after('xlsx, csv, txt파일만 허용합니다.');
            }
        }


        $phone_numbers = array_unique($recipients);

        $phone_count = sizeof($phone_numbers);

        //var_dump(array_unique($recipients)); die();

        if($this->input->post('sid') == null){
            $msg = 6;
            echo json_encode($msg);
            die();
        }

        if($this->input->post('body') == null){
            $msg = 3;
            echo json_encode($msg);
            die();
        }

        if($phone_count < 1){
            $msg = 4;
            echo json_encode($msg);
            die();
        }


        $seven_bit_msg = $this->input->post('body');

        $text_array = $this->mb_str_split($seven_bit_msg,70);
        $split_count = sizeof($text_array);
        $count = sizeof($text_array) * $phone_count;

        //echo $count;

        $user_one = $this->users_model->get_user_one($this->session->userdata('id'));

        if($user_one->msg_quantity < $count){

            $msg = 5;
            echo json_encode($msg);
            die();
        }


        $username = 'leessong2019';
        $password = 'esm45875';

        $type = 1;
        $ipcl = $_SERVER['REMOTE_ADDR'];
        $flash = 0;

        $fl = $flash;
        $mt = $type;
        $Sid = $this->input->post('sid');

        date_default_timezone_set("Asia/Seoul");
        $date =  date('Y-m-d H:i:s');
        $data = array(
            'member_id'	=>	$this->session->userdata('id'),
            'sender'	=>	$Sid,
            'message'	=>	$seven_bit_msg,
            'quantity'	=>	$count,
            'split_count'	=>	$split_count,
            'ph_quantity'	=>	0,
            'type'	=>	$mt,
            'ipcl'	=>	$ipcl,
            'message_success'	=>	1,
            'msg' => null,
            'created_date'	=>	$date,
        );
        $insert_id = $this->users_model->msg_add($data);
        /*
        * Your phone number, including country code, i.e. 60123456756:
        */
        $url = 'https://www.easysendsms.com/sms/bulksms-api/bulksms-api';
        $rec_arr = array_chunk($phone_numbers,25);

        foreach ($rec_arr as $ra){
            $co =  count($ra);
            //var_dump($ra); die();
            $string = implode(',',$ra);

            //var_dump($string); die();
            $mno = $string;
            $post_fields = array(
                'username' => $username,
                'password' => $password,
                'from' => $Sid,
                'to' => $string,
                'text' => $seven_bit_msg,
                'type' => $mt,
            );

            $get_url = $url . "?" . http_build_query($post_fields);


            //$post_body = $this->seven_bit_sms( $username, $password, $seven_bit_msg, $string, $Sid, $fl, $mt);
            $result = $this->send_message( $get_url);
            if( $result ) {

//                $req = explode(',', $result['id']);
//                var_dump($req);
//                die();
                if($result['id'] == '00'){
                    $msg = 8;
                    echo json_encode($msg);
                    die();
                }
                //$this->users_model->msg_detail_delete($insert_id);
                $r_codes = explode(',', $result['id']);
                $i_too = count($r_codes);

                $t = -1;
                $q = 0;

                foreach ($ra as $pc){ $t++;
                    //echo $t;

                    $sus = substr($r_codes[$t], 0, 2);

                    if($sus == 'OK'){ $q++;

                        $success = 1;
                        $code = 'OK';

                    }
//                    if($sus == '00'){
//
//                        $success = 0;
//                        $code = $r_codes[$t];
//
//                    }
////                    if($sus == 'du'){
////                        $success = 0;
////                        $code = 'duplicate';
////                    }
//
//                    $data2 = array(
//                        'message_id'	=>	$insert_id,
//                        'phone_number'	=>	$pc,
//                        'success'	=>	$success,
//                        'code'	=>	$code,
//                    );
//                    $this->users_model->msg_detail_add($data2);

                }
                echo $q;
                die();
                $new_quantity = $user_one->msg_quantity - $q;


                $data4 = array(
                    'msg_quantity' => $new_quantity,

                );
                $this->users_model->user_update($this->session->userdata('id'), $data4);


            }else{

                $msg = 8;
                echo json_encode($msg);
                die();
            }
        }
        $msg = 2;
        echo json_encode($msg);
        die();
    }

	/**
	 * Footer
	 *
	 * @param 
	 * @return footer
	 */
	public function footer()
	{
		return $this->load->view('frontend/template/footer', null, true);
	}

	/**
	 * Post Request
	 *
	 * @param 
	 * @return PostRequest
	 */
	public function PostRequest($url, $_data,$insert_id) {
		// convert variables array to string:
		$data = array();
		foreach ($_data as $a => $v) {
				$data[] = "$a=$v";
		}
		$data = implode('&', $data);

		$url = parse_url($url);


		$host = $url['host'];
		$path = $url['path'];
		$fp = fsockopen($host, 80);
		fwrite($fp, "POST $path HTTP/1.1\r\n");
		fwrite($fp, "Host: $host\r\n");
		fwrite($fp, "Content-type: application/x-www-form-urlencoded\r\n");
		fwrite($fp, "Content-length: ". strlen($data) ."\r\n");
		fwrite($fp, "Connection: close\r\n\r\n");
		fwrite($fp, $data);
		$result = '';
		while(!feof($fp)) {
				$result .= fgets($fp, 128);
		}
		fclose($fp);
		$result = explode("\r\n\r\n", $result, 2);
		$header = isset($result[0]) ? $result[0] : '';
		$content = isset($result[1]) ? $result[1] : '';

		//echo stripslashes(json_encode($content));
		$response = json_decode($content);
		if ($response->ErrorCode == 13) {
					echo "wrong numbers";
		};
		if ($response->ErrorCode == 0) {
					foreach($response->MessageData as $msg_data){
							foreach($msg_data->MessageParts as $msg_parts){
										$message_to_save = array(
												'message_id' => $insert_id,
												'sender' =>$_data['sid'],
												'phone_number' => $msg_data->Number,
												'api_message_id'=>$msg_parts->MsgId,
												'part_id'=>$msg_parts->PartId,
												'success'=>1,
										);
										$this->users_model->msg_detail_update($insert_id, $message_to_save);
							};
					};
		};
	}

	/**
	 * Get detail
	 *
	 * @param 
	 * @return get_detail
	 */
	public function get_detail(){
		$id = $this->input->post('id');
		$detail = $this->users_model->get_message_detail($id);
		$message = $this->users_model->get_member_message_detail($id);
			
		if (sizeof($detail) == 0) {

			$save_data = array(
				'error_count'=>$message->quantity,
				'pending_count'=>0,
			);

			$this->users_model->msg_update($id,$save_data);
		};

		$response = array();

		foreach($detail as $ds){
			if ($ds->code == null || $ds->code == '#Submitted') {
				$_data = array(
					'apikey' => "584b406f-ccac-4ede-803d-610ceb3b2889",
					'clientid' => "95aa76ca-03b4-4bb9-9f31-b3783fda21b3",
					'messageid' => $ds->api_message_id,
				);

				$url= 'https://my.forwardvaluesms.com/vendorsms/checkdelivery.aspx';
				$data = array();

				foreach ($_data as $a => $v) {
						$data[] = "$a=$v";
				};

				$data = implode('&', $data);
				$url = parse_url($url);
				$host = $url['host'];
				$path = $url['path'];
				$fp = fsockopen($host, 80);
				fwrite($fp, "POST $path HTTP/1.1\r\n");
				fwrite($fp, "Host: $host\r\n");
				fwrite($fp, "Content-type: application/x-www-form-urlencoded\r\n");
				fwrite($fp, "Content-length: ". strlen($data) ."\r\n");
				fwrite($fp, "Connection: close\r\n\r\n");
				fwrite($fp, $data);
				$result = '';
				while(!feof($fp)) {
						$result .= fgets($fp, 128);
				}
				fclose($fp);
				$result = explode("\r\n\r\n", $result, 2);
				$header = isset($result[0]) ? $result[0] : '';
				$content = isset($result[1]) ? $result[1] : '';
				// return as array:
				$this->users_model->update_status($ds->id,$content);
				$save_data = array();
				if ($content == '#UNDELIV' && $message->pending_count > 0) {
					$save_data = array(
						'undelivered_count'=>$message->undelivered_count + 1,
						'pending_count'=>$message->pending_count - 1,
					);
				}elseif($content == '#DELIVRD' && $message->pending_count > 0) {
					$save_data = array(
						'delivered_count'=>$message->delivered_count + 1,
						'pending_count'=>$message->pending_count - 1,
					);
				}elseif($content == '#StatusUnknown' && $message->pending_count > 0) {
					$save_data = array(
						'error_count'=>$message->error_count + 1,
						'pending_count'=>$message->pending_count - 1,
					);
				};
				if($save_data != null) {
					$this->users_model->msg_update($ds->message_id,$save_data);
				};
				};

		};
		$message1 = $this->users_model->get_member_message_detail($id);
		$result = array(
				'id'=>$message1->id,
				'delivrd' => $message1->delivered_count,
				'undeliv' => $message1->undelivered_count,
				'pending'=>$message1->pending_count,
				'error'=>$message1->error_count,
		);
		array_push($response,$result);
		echo json_encode($response);
		//$message1 = $this->users_model->get_member_message_detail($id);

	}
	
	/**
	 * Get detail old
	 *
	 * @param 
	 * @return get_detail_old
	 */
	public function get_detail_old()
	{
		$id = $this->input->post('id');
		$details =  $this->users_model->get_member_message_detail($id);
		$data = array(
			'id'=>$details->id,
			'delivrd'=>$details->delivered_count,
			'pending'=>$details->pending_count,
			'error'=>$details->error_count,
			'undeliv'=>$details->undelivered_count,
		);
		echo json_encode($data);
	}

	/**
	 * Meassage search
	 *
	 * @param 
	 * @return SmsSearch
	 */
	public function SmsSearch($search)
	{
		$id = $this->session->userdata('id');
		$data['title'] = '결과 | 글로벌문자';
		$data['current'] = 'SmsSearch';
		$data['user'] = $this->users_model->get_user_one($id);
		$total = $this->users_model->get_member_msg_count($id);
		$per_pg = $this->session->userdata('per_pg');;
		$offset = $this->uri->segment(3, 0);

		$this->load->library('pagination');

		$config['base_url'] = base_url().'users/smsRequests';
		$config['total_rows'] = $total;
		$config['per_page'] = $per_pg;
		$config['uri_segment'] = 3;
		$config['full_tag_open'] = "<ul role='menubar' aria-disabled='false' aria-label='Pagination' class=' pagination b-pagination pagination-md justify-content-center'>";
		$config['full_tag_close'] ="</ul>";
		$config['num_tag_open'] = "<li role='none presentation' aria-hidden='true' class='page-item '><span class='page-link'>";
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = "<li role='none presentation' class='page-item active '><a  class='page-link btn-primary '>";
		$config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
		$config['next_tag_open'] = "<li role='none presentation' class='page-item ' aria-hidden='true'><span class='page-link'>";
		$config['next_tagl_close'] = "</span></li>";
		$config['prev_tag_open'] = "<li role='none presentation' class='page-item ' aria-hidden='true'><span
														class='page-link'>";
		$config['prev_tagl_close'] = "</span></li>";
		$config['first_tag_open'] = "<li ><span class='page-link'>";
		$config['first_tagl_close'] = "</span></li>";
		$config['last_tag_open'] = "<li><span class='page-link'>";
		$config['last_tagl_close'] = "</span></li>";

		$this->pagination->initialize($config);

		$data['pagination']=$this->pagination->create_links();
		$data['countstart'] = $offset;
		$data['total'] = $total;
		$data['searchby'] = $search;
		$data['messages'] = $this->users_model->search_member_messages($id,$search, $per_pg,$offset);
		$data['main_content'] = 'frontend/SmsSearch';
		
		// return to view data
		$this->main_template($data);
	}
	
	/**
	 * Get detail new
	 *
	 * @param 
	 * @return get_detail_new
	 */
	public function get_detail_new()
	{
		$ids = $this->input->post('id');
		$result = $this->users_model->count_result($ids);
		
		if ($result!=null) {
			echo json_encode($result);
			$this->db->update_batch('message', $result, 'id');
		} else {
			echo 0;
		}
	}

	/**
	 * notice
	 *
	 * @param $data
	 * @return notice
	 */
	public function notice($msg = null) {
		$id = $this->session->userdata('id');
		$data['current'] = 'notice';
		$data['user'] = $this->users_model->get_user_one($id);

		$rec_code = $data['user']->mb_recommend;
		$data['main_content'] = 'frontend/notice';

		$total = $this->notices_model->notice_rows();
		$per_pg = 10;
		$offset = $this->uri->segment(3, 0);
		$this->load->library('pagination');

		// config
		$config['base_url'] = base_url().'home/notice';
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

		// pagination config
		$this->pagination->initialize($config);
		$data['pagination']=$this->pagination->create_links();

		// data cash, data, fail, success, unknown and msg
		$data["notices"] = $this->notices_model->front_notice($per_pg,$offset);
		
		// view 
		$this->main_template($data);
	}
}
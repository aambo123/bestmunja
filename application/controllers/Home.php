<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct(){
		parent::__construct();

		$this->load->model('mod_login');
		$this->load->model('users_model');
		$this->load->model('settings_model');
		$this->load->model('notices_model');
		$this->load->library('user_agent');
		$this->load->helper('Logger');
	}

	public function index() {
		$this->user_tracking();
		$data['main_content'] = 'frontend/home';
		if($this->session->userdata('id')){
			$id = $this->session->userdata('id');
			$data['user'] = $this->users_model->get_user_one($id);
		}
		$this->main_template($data);
    }
    
    // public function main() {

		// 	$data['notices'] = $this->notices_model->login_notice();

		// 	$this->load->view('frontend/main', $data);
    // }

    public function login($msg=null)
    {
			$data['msg']=$msg;
			
			$data['notices'] = $this->notices_model->login_notice();

			if ($this->session->userdata('logged_in')) {
				redirect('users/smsSend');
			} else {
				// $this->load->view('frontend/login', $data);
				
				$this->load->view('frontend/login', $data);
			}
    }

    public function login_check() {

			$uname = $this->input->post('mb_id');
			$pass = $this->input->post('mb_password');
			$result = $this->mod_login->check_login($uname, $pass);
			if($result && $result[0]->mb_open == 0)
			{
				foreach($result as $row)
				{
					Logger::write("info", "user", "userId: " . $row->mb_no . ", username: " . $row->mb_name .", login.");

					$this->session->set_userdata('id', $row->mb_no);
					$this->session->set_userdata('mb_id', $row->mb_id);
					$this->session->set_userdata('user_name', $row->mb_name);
					$this->session->set_userdata('user_email', $row->mb_email);
					$this->session->set_userdata('user_level', $row->mb_level);
					$this->session->set_userdata('user_rec_code', $row->mb_recommend);
					$this->session->set_userdata('logged_in', TRUE);

					date_default_timezone_set("Asia/Seoul");

					$datetime = date('Y-m-d H:i:s');
					$data = array(
						'mb_today_login' => $datetime,
						'mb_login_ip' => $_SERVER['REMOTE_ADDR'],
					);

					$this->users_model->user_update($row->id, $data);

					if($this->input->post("auto_login")) {
						setcookie ("loginId", $uname, time()+ (10 * 365 * 24 * 60 * 60));
						setcookie ("loginPass",	$pass,	time()+ (10 * 365 * 24 * 60 * 60));
					} else {
						setcookie ("loginId","");
						setcookie ("loginPass","");
					}
				}

				redirect('/users/smsSend');
			}
			else
			{
				$this->session->sess_destroy();
				$data['msg']='error';
				$this->load->view('frontend/login', $data);
			}
    }

    public function register($msg=null)
    {
			$data['msg']=$msg;
			$data['title'] = '회원가입약관 | 글로벌문자';
			$data['current'] = 'home';

			$data['main_content'] = 'frontend/register';
			$this->main_template($data);
    }

    public function register_form($msg=null) {

			$data['msg']=$msg;
			$data['title'] = '회원 가입 | 글로벌문자';
			$data['current'] = 'home';
			
			$this->load->view('frontend/register_form', $data);
		}
		
    public function check_user_id() {

			$this->form_validation->set_rules('mb_id', '이름', 'trim|required|is_unique[g5_member.mb_id]');

			if($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}else{
				echo true;
			}
    }

    public function check_user_email() {

			$this->form_validation->set_rules('mb_email', '이메일', 'trim|required|valid_email|is_unique[g5_member.mb_email]');

			if($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}else{
				echo true;
			}
    }

    public function check_user_referral() {

			$this->form_validation->set_rules('referral', '추천코드', 'trim|required|callback_code_check');

			if($this->form_validation->run() == FALSE) {
				echo validation_errors();
			}else{
				echo true;
			}
		}
		
    public function check_current_pass() {
			
			$user = $this->users_model->user_one( $this->session->userdata('id'));
			$input_password = hash ( "sha256", $this->input->post('mb_password') );
			if ($user->mb_password == $input_password) {
				echo  1;
			}else{
				echo  0;
			}
		}
		
    public function register_send() {

			$this->form_validation->set_rules('mb_id', '아이디', 'trim|required|is_unique[g5_member.mb_id]');
			$this->form_validation->set_rules('mb_name', '이름', 'trim|required');
			$this->form_validation->set_rules('mb_email', '이메일', 'trim|required|valid_email|is_unique[g5_member.mb_email]');
			$this->form_validation->set_rules('mb_password', '비밀번호', 'trim|required|min_length[6]|max_length[20]');
			$this->form_validation->set_rules('mb_password_re', '비밀번호 확인', 'required|matches[mb_password]');
			$this->form_validation->set_rules('referral', '추천코드', 'trim|required|callback_code_check');

	   	//$this->form_validation->set_rules('term_accept', '개인정보처리방침', 'trim|required');
			if($this->form_validation->run() == FALSE) {
				$data['title'] = '회원 가입 | 글로벌문자';
				$data['current'] = 'home';

				$data['main_content'] = 'frontend/register_form'; // Register form page
				$this->main_template($data);
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
                $reccom_code = $this->settings_model->get_recommendation_one_by_code($this->input->post('referral'));
				$data = array(
					'mb_id' => $this->input->post('mb_id'),
					'mb_name' => $this->input->post('mb_name'),
					'mb_nick' => $this->input->post('mb_id'),
					'mb_password' => $password,
					'mb_pstr' => $this->input->post('mb_password'),
					'mb_email' => $this->input->post('mb_email'),
					'mb_recommend' => $reccom_code->rec_id,
					'mb_nick_date' => $date,
					'sms_send_account' => $sms_account_name,
					'sms_account_id' => $sms_account_id,
					'mb_level' => 'Customer',
					'mb_datetime' => $datetime,
					'mb_open_date' => $date,
					'mb_ip' => $_SERVER['REMOTE_ADDR'],
					'mb_login_ip' => $_SERVER['REMOTE_ADDR'],
				);

				$user_id = $this->users_model->register($data);

				$generateNumber = $this->users_model->generateRandomString(2);

				$data1['mb_code'] = "C" . $user_id. "A" .$generateNumber;

				$this->users_model->user_update($user_id, $data1);

				// Reseller code
				if($this->input->post('referral')) {
					
					$reseller = $this->settings_model->get_recommendation_one_by_code($this->input->post('referral'));

				
					if($reseller->created_id !== 0){

						$reseller_id = $reseller->created_id;
						$reseller = $this->users_model->get_user('mb_no',$reseller_id);
						
						$data1['reseller_id'] = $reseller->mb_no;
						$data1['reseller_code'] = $reseller->reseller_code;

						$this->users_model->user_update($user_id, $data1);
					}
					
				}


				redirect('home/register_result/'.$user_id.'');
			}
		}
		
    public function change_profile() {

			if ($this->input->post('pass_will_change') == 1) {
				$this->form_validation->set_rules('mb_password', '비밀번호', 'trim|required|min_length[6]|max_length[20]');
				$this->form_validation->set_rules('mb_password_re', '비밀번호 확인', 'required|matches[mb_password]');
			};
        $this->form_validation->set_rules('mb_name', '이름', 'trim|required');

	   	//$this->form_validation->set_rules('term_accept', '개인정보처리방침', 'trim|required');
			if($this->form_validation->run() == FALSE) {
				$data['title'] = '마이페이지 | 글로벌문자';
				$data['current'] = 'mypage';

				$data['main_content'] = 'frontend/mypage'; // Register form page
				$this->main_template($data);
			} else {
				if ($this->input->post('pass_will_change') == 1) {
					$password = hash ( "sha256", $this->input->post('mb_password') );
					$data = array(
						'mb_name' => $this->input->post('mb_name'),
						'mb_password' => $password,
					);
				} else {
					$data = array(
						'mb_name' => $this->input->post('mb_name'),
					);
			}

			$this->users_model->user_update($this->session->userdata('id'),$data);
			$msg = 'success';
			redirect('users/mypage/'.$msg);
			}
    }

    public function code_check()
    {
			$code = $this->input->post('referral');
			if($code != null) {
				$result = $this->mod_login->code_check($code);
				if ($result == true) {

					return true;
				} else {
					$this->form_validation->set_message('code_check', '추천인 코드가 올바르지 않습니다.');
					return false;
				}
			}else{
				$this->form_validation->set_message('code_check', '추천인 코드가 없습니다. 올바른 방법으로 이용해 주십시오.');
				return false;
			}
		}
		
		public function reseller_code_check()
    {
			// Reseller code check from database
			$reseller_code = $this->input->post('reseller_code');
			if($reseller_code != null) {
				$result = $this->mod_login->reseller_code_check($reseller_code);
				if ($result == true) {

					return true;
				} 
				// else {
				// 	$this->form_validation->set_message('reseller_code_check', '추천인 코드가 올바르지 않습니다.');
				// 	return false;
				// }
			}else{
				$this->form_validation->set_message('reseller_code_check', '리셀러 코드가 없습니다. 올바른 방법으로 사용하십시오.');
				return false;
			}
    }

    public function register_result($id) {

			$data['title'] = '회원가입 완료 | 글로벌문자';
			$data['current'] = 'home';
			$data['user'] = $this->users_model->user_one($id);
			$data['main_content'] = 'frontend/register_result'; // Register form page
			$this->main_template($data);
    }

    public function main_template($data)
    {
			$this->load->view('frontend/template/main_template', $data);
    }



    public function logout()
    {   
			Logger::write("info", "user", "userId: " . $this->session->userdata('id') . ", username: " . $this->session->userdata('mb_id') .", logout.");
			$this->session->sess_destroy();

			redirect('home/login');
    }


    public function delivery_report()
    {
			$sender = $_REQUEST['sid'];
			$mobile = $_REQUEST['mno'];
			$messageid = $_REQUEST['msgid'];
			$date = $_REQUEST['date'];
			$status = $_REQUEST['status'];
			$save_report = array(
				'mno'=>$mobile,
				'sid'=>$sender,
				'msgid'=>$messageid,
				'dates'=>$date,
				'status'=>$status,
			);
			$this->db->insert('delivery_report',$save_report);
	  	$data = array();

      if($status == 'DELIVRD'){
        $data = array(
          'success' => 1,
			 		'code' => $status,
        );
	  	} elseif ($status == 'UNDELIV') {
				$data = array(
					'success' => 2,
			 		'code' => $status,
				);

	  	}else {
				$data = array(
					'success' => 3,
					'code' => $status,
				);
	  	}
    }

    public function save_data() {
			$data = json_decode(file_get_contents('php://input'), true);
			
			foreach ($data as $rd){
					echo "<pre>";
					print_r($rd);
					echo "</pre>";
			}
    }


    public function msg_count() {

			$msg_id = $this->input->post('msg_id');
			$data['success_msgs'] = $this->users_model->get_success_msgs($msg_id);
			$data['pending_msgs'] = $this->users_model->get_pending_msgs($msg_id);
			$data['error_msgs'] = $this->users_model->get_error_msgs($msg_id);
			$data['total'] = $data['success_msgs'] + $data['error_msgs'];
			
			echo json_encode($data);
    }

    public function all_msg_count() {

			$data['msg_count_all'] = $this->users_model->msg_count_all();
			$data['msg_count_month'] = $this->users_model->msg_count_month();
			$data['msg_count_today'] = $this->users_model->msg_count_today();

			echo json_encode($data);

    }

    public function member_msg_count() {
			$member_id = $this->input->post('member_id');
			$data['count_today'] = $this->users_model->member_msg_count_today($member_id);
			$data['count_all'] = $this->users_model->member_msg_count_all($member_id);

			echo json_encode($data);
    }

    public function callback_url() {
			$message_data = json_decode(file_get_contents('php://input'));
			$mobile = $message_data->to;
			$sender = $message_data->from;
			$status = $message_data->status->name;

			if ($status == 'Queued') {
					$success = 0;
			}elseif ($status == 'Sent') {
					$success = 0;
			}elseif ($status == 'Delivered') {
					$success = 1;
			}elseif ($status == 'Undelivered') {
					$success = 2;
			}elseif ($status == 'Failed') {
					$success = 3;
			}elseif ($status == 'Unsent ') {
					$success = 4;
			};
			
			$data = array(
				'success'=>$success,
				'code'=> $status,
				'detail'=>$message_data->status->reason->description,
				'api_message_id'=>$message_data->messageId,
			);

			$this->users_model->message_detail_update($sender,$mobile,$data);
		}
		
    public function callback_campaign() {
			$campaign_data = json_decode(file_get_contents('php://input'),false);
			$campaign_id = $campaign_data->trackingId;
			$messages = $campaign_data->messageStatuses;
			
			// Queued, Sent, Failed, Unsent, Delivered or Undelivered.
			$data = array(
				'pending_count'=> $messages->Queued,
				'delivered_count'=> $messages->Delivered,
				'undelivered_count'=> $messages->Undelivered,
				'error_count'=> $messages->Failed + $messages->Unsent,
			);
		}
		
    public function user_tracking() {

			$date = date('Y-m-d H:i:s');
			$url = $this->agent->referrer();
			date_default_timezone_set("Asia/Seoul");
			$parse = $url == null ? $url: parse_url($url)['host'];

			if ($parse != base_url()) {
				$data = array(
					'ip'=>$_SERVER['REMOTE_ADDR'],
					'created_date'=>$date,
					'referrer'=> $parse,
					'browser'=> $this->agent->browser(),
					'os'=> $this->agent->platform(),
					'device'=>$this->agent->is_mobile()? $this->agent->mobile() : $this->agent->platform(),
					'is_mobile'=> $this->agent->is_mobile(),
					'agent'=> $this->agent->agent_string()
				);

				$this->db->insert('visit',$data);
			}
		}
		
		/**
		 * Res data
		 *
		 * @param $data
		 * @return res_data
		 */
    public function res_data() {
			$this->db->select('id,referrer')
               ->from('visit')
               ->where('referrer !=','');
      $query = $this->db->get();
      $result =  $query->result();
      foreach($result as $row)
      {
				$url = $row->referrer;
				$parse = parse_url($url);
				if ($parse['host']) {
						$parse= $parse['host'];
				}
				var_dump($parse);
				$data = array(
						'referrer'=>$parse,
				);

				$this->db->where('id',$row->id);
				$this->db->update('visit',$data);
      }
    }

    public function service(){
		$data['main_content'] = 'frontend/service';
		$this->main_template($data);
    }
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

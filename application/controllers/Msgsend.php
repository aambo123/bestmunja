<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Msgsend Class
 *
 * @package    	Controllers
 * @category    Msgsend
 */
class Msgsend extends CI_Controller {

	/**
	 * @consturctor
	 */
	function __construct(){

		parent::__construct();

		$this->load->model('users_model');
		$this->load->model('settings_model');
		$this->load->model('procTimes');
		$this->load->helper('logger');
	}
	


	/**
	 * Send messsage 1
	 *
	 * @param Data $data
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
	 * ATTEMPT TO ADD SMS API CONTROL
	 *
	 * @param Data $data
	 * @return send_message_all
	 */
	public function send_message_all($insert_id, $member_id, $Sid)
	{// user info
		$user_one = $this->users_model->get_user_one($member_id);
		$rec_info = $this->settings_model->get_recommendation_one($user_one->mb_recommend);
		
        $curacc = $this->settings_model->get_send_account($member_id);
        $api_info = $this->settings_model->get_api_one($curacc->name);
		$date = date('Y-m-d');

		// user info
		$msgfile = 'upload/messages/'.$date.'/msg'.$insert_id;
		$phonefile = 'upload/phones/'.$date.'/ph'.$insert_id;

		$data2 = fopen($phonefile, 'r');
		$datas = fread($data2, filesize($phonefile));
		fclose($data2);
		$arrData = explode(",",$datas);

		$msg_f = fopen($msgfile, 'r');
		$seven_bit_msg = fread($msg_f, filesize($msgfile));
		fclose($msg_f);

		$phone_numbers = array_unique($arrData);
		$rec_arr = array_chunk($phone_numbers,15);
		
		foreach ($rec_arr as $numbers){

			$co = sizeof($numbers);
			if($curacc != null) {
				if ($curacc->account_name == '1s2u') {
					$this->ones2u($user_one,$api_info, $curacc,$rec_info, $insert_id, $Sid, $numbers, $seven_bit_msg, $co);
				}elseif($curacc->account_name == 'ebulk'){
					$this->ebulksms($user_one,$api_info, $curacc,$rec_info, $insert_id, $Sid, $numbers, $seven_bit_msg, $co);
                }elseif($curacc->account_name == 'bulksms'){
					$this->bulksms($user_one,$api_info, $curacc,$rec_info, $insert_id, $Sid, $numbers, $seven_bit_msg, $co);
                }
            }
		}
		die();
	}

	/**
	 * SMS API ones2u
	 *
	 * @param Data $data
	 * @return ones2u
	 */
	public function ones2u($memberInfoVo, $api_info,$accountInfo,$rec_info, $insert_id, $Sid, $ra, $seven_bit_msg, $co){
		
		Logger::write("info", "message", "userId: " . $memberInfoVo->mb_id . ", message id: " . $insert_id . ", Get api result.");

		$get_message_one = $this->users_model->get_member_message_detail($insert_id);
		$string = implode(',',$ra);

		$url = $api_info->send_url;
		$post_fields = array(
			''.$api_info->username.'' => $accountInfo->username,
			''.$api_info->password.'' => $accountInfo->password,
			''.$api_info->sender.'' => $Sid,
			''.$api_info->recipient.'' => $string,
            ''.$api_info->message.'' => $seven_bit_msg,
            'mt'=>'1',
            'fl'=>'0'
		);

		$get_url = $url . "?" . http_build_query($post_fields);

		$date = date('Y-m-d');
		$log_filedir = "logs/".$date."";
		if (!file_exists($log_filedir))
		{
			// create directory/folder uploads.
			mkdir($log_filedir, 0777, true);
		}
		$log = "".$log_filedir."/".$insert_id."";
		$log_file = fopen($log, 'a');
		$logtext = "Sender:".$Sid.PHP_EOL."Message ID: ".$insert_id.PHP_EOL."SMS Account: ".$$accountInfo->name.PHP_EOL."SMS Account username: ".$accountInfo->username.PHP_EOL."";
		//file_put_contents(''.$log.'', $logtext.PHP_EOL, FILE_APPEND | LOCK_EX);
		fwrite($log_file, "\r\n". $logtext);
        fclose($log_file);
        log_message('debug', $logtext);

		//$post_body = $this->seven_bit_sms( $username, $password, $seven_bit_msg, $string, $Sid, $fl, $mt);
		$result = $this->send_message( $get_url);
		if( $result ) {
			//var_dump($result['id']); die();
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
            $f = 0;

			foreach ($ra as $pc){ $t++;
				//echo $t;

				$sus = substr($r_codes[$t], 0, 2);

				if($sus == 'OK'){ $q++;
					$success = 1;
					$code = 'OK';
				}else{ $f++;
					$success = 3;
					$code = $r_codes[$t];
				}

				$data2 = array(
					'sender'	=>	$Sid,
					'message_id'	=>	$insert_id,
					'phone_number'	=>	$pc,
					'success'	=>	$success,
					'code'	=>	$code,
                );
                
				$id = $insert_id;
				$phone_number = $pc;
				$this->users_model->msg_detail_update($id, $phone_number, $data2);

				$log_file = fopen($log, 'a');
				$logtext = "Phone number: ".$pc." - Code: ".$code.PHP_EOL."";
				//file_put_contents(''.$log.'', $logtext.PHP_EOL, FILE_APPEND | LOCK_EX);
				fwrite($log_file, $logtext);
				fclose($log_file);
			}
			$failed_quantity = $memberInfoVo->msg_quantity + $f;
			Logger::write("info", "message", "userId: " . $memberInfoVo->mb_id . ", message id: " . $insert_id . ", phone numbers: " . $string . ", success count: " . $q . ", failed count: " . $f .", Message has been sended.");
			if ($f > 0 ){
				// Insert to cash_history
				$data10 = array(
					'member_id' => $memberInfoVo->mb_id,
					'message_id'	=>	$insert_id,
					'cash' => ('+'. $f*$rec_info->msg_price),
					'success' => 'Success',
					'system' => 'System',
					'created_date' => date('Y-m-d H:i:s')
				);

				$this->users_model->cash_history_add($data10);
			}

			
			
			$dataS = array(
				'msg' => $rec_info->msg_price,
			);
			$this->db->where('id', $insert_id);
			$this->db->update('message', $dataS);
			
			// if has failed number give back cash certain user
			if ($f > 0 ){
				$data4 = array(
					'msg_quantity' => $failed_quantity,
				);
				$this->users_model->user_update($memberInfoVo->mb_id, $data4);	
			}
			

			// $curlimit = $accountInfo->msg_limit - $get_message_one->split_count * $q;
			// $data7 = array(
			// 	'msg_limit' => $curlimit,
			// );
			// $this->db->where('username', $accountInfo->username);
			// $this->db->where('password', $accountInfo->password);
			// $this->db->update('sms_1s2u_account', $data7);

		}else{

			$msg = 8;
			echo json_encode($msg);
			die();
		}
	}
public function bulksms($memberInfoVo, $api_info,$accountInfo,$rec_info, $insert_id, $Sid, $ra, $seven_bit_msg, $co){
		
		Logger::write("info", "message", "userId: " . $memberInfoVo->mb_id . ", message id: " . $insert_id . ", Get api result.");

		$get_message_one = $this->users_model->get_member_message_detail($insert_id);
		$string = implode(',',$ra);

		$url = $api_info->send_url;
		$post_fields = array(
			''.$api_info->username.'' => $accountInfo->username,
			''.$api_info->password.'' => $accountInfo->password,
			''.$api_info->sender.'' => $Sid,
			''.$api_info->recipient.'' => $string,
            ''.$api_info->message.'' => $seven_bit_msg,
            'type'=>'u',
		);

		$get_url = $url . "?" . http_build_query($post_fields);

		$date = date('Y-m-d');
		$log_filedir = "logs/".$date."";
		if (!file_exists($log_filedir))
		{
			// create directory/folder uploads.
			mkdir($log_filedir, 0777, true);
		}
		$log = "".$log_filedir."/".$insert_id."";
		$log_file = fopen($log, 'a');
		$logtext = "Sender:".$Sid.PHP_EOL."Message ID: ".$insert_id.PHP_EOL."SMS Account: ".$$accountInfo->name.PHP_EOL."SMS Account username: ".$accountInfo->username.PHP_EOL."";
		//file_put_contents(''.$log.'', $logtext.PHP_EOL, FILE_APPEND | LOCK_EX);
		fwrite($log_file, "\r\n". $logtext);
        fclose($log_file);
        log_message('debug', $logtext);

		//$post_body = $this->seven_bit_sms( $username, $password, $seven_bit_msg, $string, $Sid, $fl, $mt);
		$result = $this->send_message( $get_url);
		if( $result ) {
			//var_dump($result['id']); die();
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
            $f = 0;

			foreach ($ra as $pc){ $t++;
				//echo $t;

				$sus = substr($r_codes[$t], 0, 2);

				if($sus == 'OK'){ $q++;
					$success = 1;
					$code = 'OK';
				}else{ $f++;
					$success = 3;
					$code = $r_codes[$t];
				}

				$data2 = array(
					'sender'	=>	$Sid,
					'message_id'	=>	$insert_id,
					'phone_number'	=>	$pc,
					'success'	=>	$success,
					'code'	=>	$code,
                );
                
				$id = $insert_id;
				$phone_number = $pc;
				$this->users_model->msg_detail_update($id, $phone_number, $data2);

				$log_file = fopen($log, 'a');
				$logtext = "Phone number: ".$pc." - Code: ".$code.PHP_EOL."";
				//file_put_contents(''.$log.'', $logtext.PHP_EOL, FILE_APPEND | LOCK_EX);
				fwrite($log_file, $logtext);
				fclose($log_file);
			}
			$failed_quantity = $memberInfoVo->msg_quantity + $f;
			Logger::write("info", "message", "userId: " . $memberInfoVo->mb_id . ", message id: " . $insert_id . ", phone numbers: " . $string . ", success count: " . $q . ", failed count: " . $f .", Message has been sended.");
			if ($f > 0 ){
				// Insert to cash_history
				$data10 = array(
					'member_id' => $memberInfoVo->mb_id,
					'message_id'	=>	$insert_id,
					'cash' => ('+'. $f*$rec_info->msg_price),
					'success' => 'Success',
					'system' => 'System',
					'created_date' => date('Y-m-d H:i:s')
				);

				$this->users_model->cash_history_add($data10);
			}

			
			
			$dataS = array(
				'msg' => $rec_info->msg_price,
			);
			$this->db->where('id', $insert_id);
			$this->db->update('message', $dataS);
			
			// if has failed number give back cash certain user
			if ($f > 0 ){
				$data4 = array(
					'msg_quantity' => $failed_quantity,
				);
				$this->users_model->user_update($memberInfoVo->mb_id, $data4);	
			}
			

			// $curlimit = $accountInfo->msg_limit - $get_message_one->split_count * $q;
			// $data7 = array(
			// 	'msg_limit' => $curlimit,
			// );
			// $this->db->where('username', $accountInfo->username);
			// $this->db->where('password', $accountInfo->password);
			// $this->db->update('sms_1s2u_account', $data7);

		}else{

			$msg = 8;
			echo json_encode($msg);
			die();
		}
	}
	public function ebulksms($memberInfoVo, $api_info,$accountInfo,$rec_info, $insert_id, $Sid, $ra, $seven_bit_msg, $co){
		
		Logger::write("info", "message", "userId: " . $memberInfoVo->mb_id . ", message id: " . $insert_id . ", Get api result.");

		$get_message_one = $this->users_model->get_member_message_detail($insert_id);
		$string = implode(',',$ra);

		$url = $api_info->send_url;
		$post_fields = array(
			''.$api_info->username.'' => $accountInfo->username,
			''.$api_info->password.'' => $accountInfo->password,
			''.$api_info->sender.'' => $Sid,
			''.$api_info->recipient.'' => $string,
            ''.$api_info->message.'' => $seven_bit_msg,
            'type'=>'2',
            'dcs'=>'0'
		);

		$get_url = $url . "?" . http_build_query($post_fields);

		$date = date('Y-m-d');
		$log_filedir = "logs/".$date."";
		if (!file_exists($log_filedir))
		{
			// create directory/folder uploads.
			mkdir($log_filedir, 0777, true);
		}
		$log = "".$log_filedir."/".$insert_id."";
		$log_file = fopen($log, 'a');
		$logtext = "Sender:".$Sid.PHP_EOL."Message ID: ".$insert_id.PHP_EOL."SMS Account: ".$accountInfo->name.PHP_EOL."SMS Account username: ".$accountInfo->username.PHP_EOL."";
		//file_put_contents(''.$log.'', $logtext.PHP_EOL, FILE_APPEND | LOCK_EX);
		fwrite($log_file, "\r\n". $logtext);
        fclose($log_file);
        log_message('debug', $logtext);

		//$post_body = $this->seven_bit_sms( $username, $password, $seven_bit_msg, $string, $Sid, $fl, $mt);
		$result = $this->send_ebulk( $get_url);
		if( $result ) {
			//var_dump($result['id']); die();
			if($result['success'] == false){
                $msg = 8;
                $data2 = array(
                    'success'	=>	3,
                );
                $id = $insert_id;
                $this->users_model->msg_detail_bulk_error($id, $ra,$data2);
				echo json_encode($msg);
				die();
			}
			//$this->users_model->msg_detail_delete($insert_id);
			$r_codes = explode(',', $result['result']);
			$i_too = count($r_codes);
			$t = -1;
			$q = 0;
			$f = 0;
			foreach ($ra as $pc){ $t++;
				//echo $t;
				$q++;
                $success = 1;
                $code = 'OK';
				$data2 = array(
					'sender'	=>	$Sid,
					'message_id'	=>	$insert_id,
					'phone_number'	=>	$pc,
					'success'	=>	$success,
					'code'	=>	$code,
				);
				$id = $insert_id;
				$phone_number = $pc;
				$this->users_model->msg_detail_update($id, $phone_number, $data2);


				$log_file = fopen($log, 'a');
				$logtext = "Phone number: ".$pc." - Code: ".$code.PHP_EOL."";
				//file_put_contents(''.$log.'', $logtext.PHP_EOL, FILE_APPEND | LOCK_EX);
				fwrite($log_file, $logtext);
				fclose($log_file);
			}
			
			
			$failed_quantity = $memberInfoVo->msg_quantity + $f;
			
			Logger::write("info", "message", "userId: " . $memberInfoVo->mb_id . ", message id: " . $insert_id . ", phone numbers: " . $string . ", success count: " . $q . ", failed count: " . $f .", Message has been sended.");

			if ($f > 0 ){
				// Insert to cash_history
				// $data10 = array(
				// 	'member_id' => $memberInfoVo->mb_id,
				// 	'message_id'	=>	$insert_id,
				// 	'cash' => ('+'. $f*$rec_info->msg_price),
				// 	'success' => 'Success',
				// 	'system' => 'System',
				// 	'created_date' => date('Y-m-d H:i:s')
				// );
				// $this->users_model->cash_history_add($data10);
			}

			
			
			$dataS = array(
				'msg' => $rec_info->msg_price,
			);
			$this->db->where('id', $insert_id);
			$this->db->update('message', $dataS);
			
			// if has failed number give back cash certain user
			if ($f > 0 ){
				// $data4 = array(
				// 	'msg_quantity' => $failed_quantity,
				// );
				// $this->users_model->user_update($memberInfoVo->mb_id, $data4);	
			}
			

			// $curlimit = $msg_limit - $get_message_one->split_count * $q;
			// $data7 = array(
			// 	'msg_limit' => $curlimit,
			// );
			// $this->db->where('username', $username);
			// $this->db->where('password', $password);
			// $this->db->update('sms_1s2u_account', $data7);

		}else{

			$msg = 8;
			echo json_encode($msg);
			die();
		}
	}


	function send_ebulk ( $get_url ) {
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

       
        
		$sms_result['success'] = false;
		$sms_result['result'] = '';
		if ( $response_string == FALSE ) {
			$sms_result['result'] .= "cURL error: " . curl_error( $ch ) . "\n";
		} elseif ( $curl_info[ 'http_code' ] != 200 ) {
			$sms_result['result'] .= "Error: non-200 HTTP status code: " . $curl_info[ 'http_code' ] . "\n";
		}
		else {
            $str_arr = preg_split ("/\:/", $response_string);
            if($str_arr[0] === "Response "){
                $sms_result['success'] = true;
                $sms_result['result'] = $str_arr[1];
            }else{
                $sms_result['result'] = $response_string;
            }
		}
		curl_close( $ch );
		return $sms_result;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

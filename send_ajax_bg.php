<?php
include_once('./_common.php');
include_once(G5_LIB_PATH . '/common.lib.php');

error_reporting(E_ALL);

ini_set("display_errors", 1);

ignore_user_abort(true);
set_time_limit(0);

print_r($argv);

$mb_id = $argv[1];
$msg_fname = $argv[4];
$send_result_id = $argv[5];
$sender_number = $argv[6];
$recipient_number = $argv[7];

$msg_f = fopen($msg_fname, 'r');
$msg = fread($msg_f, filesize($msg_fname));
fclose($msg_f);
unlink($msg_fname);
echo $msg;

$recipients = array();

foreach(explode(',', $recipient_number) as $num){
    $num = preg_replace('/\s+/', '_', $num);
    if($num == ''){
        continue;
    }
    if(substr($num, 0, 1) === '+'){
        $num = str_replace('+', '', $num);
    }elseif(substr($num, 0, 3) === '010'){
        $num = str_replace('010', '8210', $num);
    }

    $num = str_replace('-', '', $num);
    array_push($recipients, $num);
}

$file = $argv[2];
$filename = $argv[3];

if($file && $file!="None") {
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
                $num = preg_replace('/\s+/', '_', $num);
                if($num == ''){
                    continue;
                }
                if(substr($num, 0, 1) === '+'){
                    $num = str_replace('+', '', $num);
                }elseif(substr($num, 0, 3) === '010'){
                    $num = str_replace('010', '8210', $num);
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
                if($num == ''){
                    continue;
                }
                if(substr($num, 0, 1) === '+'){
                    $num = str_replace('+', '', $num);
                }elseif(substr($num, 0, 3) === '010'){
                    $num = str_replace('010', '8210', $num);
                }

                $num = str_replace('-', '', $num);
                array_push($recipients, $num);
            }
            break;
        case '.xlsx' :
            require_once(G5_LIB_PATH . '/Excel/PHPExcel.php');
            require_once(G5_LIB_PATH . '/Excel/PHPExcel/IOFactory.php');
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
                    if($num == ''){
                        continue;
                    }
                    if (substr($num, 0, 3) == "\xEF\xBB\xBF") {
                        $num = substr($num, 3);
                    }
                    if (substr($num, 0, 1) === '+') {
                        $num = str_replace('+', '', $num);
                    } elseif (substr($num, 0, 3) === '010') {
                        $num = str_replace('010', '8210', $num);
                    }

                    $num = str_replace('-', '', $num);
                    array_push($recipients, $num);
                }
            }
            break;
        default :
            alert_after('xlsx, csv, txt파일만 허용합니다.');
    }

    unlink($file);
}

print_r($recipients);

$username = 'worldsms1';
$password = 'worldsms1';
$fl = '0';
$mt = '1';
$ipcl = '183.111.174.85';
$Sid = ''.$sender_number;

while(count($recipients) > 0){
    $mno = join(',', array_splice($recipients, 0, 15));

    $url = 'http://sms487.com/sms/sendsms/sendsms.asp';
    $post_fields = array(
        'username' => $username,
        'password' => $password,
        'mt' => $mt,
        'fl' => $fl,
        'Sid' => $Sid,
        'mno' => $mno,
        'ipcl' => $ipcl,
        'msg' => $msg,
    );
    $get_url = $url . "?" . http_build_query($post_fields);
    echo $get_url.'\n';
    /*
    * A 7-bit GSM SMS message can contain up to 160 characters (longer messages can be
    * achieved using concatenation).
    *
    * All non-alphanumeric 7-bit GSM characters are included in this example. Note that Greek characters,
    * and extended GSM characters (e.g. the caret "^"), may not be supported
    * to all networks. Please let us know if you require support for any characters that
    * do not appear to work to your network.
    */
    /*
    * Sending 7-bit message
    */
    $post_body = seven_bit_sms($username, $password, $msg, $mno, $Sid, $fl, $mt, $ipcl);
    print_r($post_body);
    $result = send_message($post_body, $get_url);
    print_r($result);
    if( $result['success'] ) {
        $sql = 'update send_result set num_sent = num_sent+'.count(explode(',', $mno)).' where send_id='.$send_result_id.';';
        echo $sql;
        $vote_num = sql_fetch($sql);
        $success = 1;
    } else {
        $sql = 'update send_result set num_fail = num_fail+'.count(explode(',', $mno)).' where send_id='.$send_result_id.';';
        echo $sql;
        $vote_num = sql_fetch($sql);
        insert_point($mb_id, (ceil((mb_strlen($msg)/2) / 140)*count(explode(',', $mno))), "FAIL");
//        $sql = 'update g5_member set mb_point = mb_point+'.(ceil((mb_strlen($msg)/2) / 140)*count(explode(',', $mno))).' where mb_id="'.$mb_id.'";';
//        echo $sql;
//        $vote_num = sql_fetch($sql);
        $success = 0;
    }
    foreach(explode(',', $mno) as $pn){
        $sql = 'insert into send_detail (send_id, success, phone_no) value ('.$send_result_id.','.$success.',"'.$pn.'");';
        $vote_num = sql_fetch($sql);
    }
}
/*
* If you don't see this, and no errors appeared to screen, you should
* check your Web server's error logs for error output:
*/
function print_ln($content) {
    if (isset($_SERVER["SERVER_NAME"])) {
        print $content."<br />";
    }
    else {
        print $content."\n";
    }
}
function formatted_server_response( $result ) {
    $this_result = "";
    if ($result['success']) {
        $this_result .= "Success: ID ".$result['id'];
    }
    else {
        $this_result .= "Fatal error: HTTP status " .$result['http_status_code']. ", API status " .$result['api_status_code']. " Full details " .$result['details'];
    }
    return $this_result;
}
function send_message ( $post_body, $get_url ) {
    $ch = curl_init( );
    curl_setopt ( $ch, CURLOPT_URL, $get_url );
    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
    // Allowing cUrl funtions 20 second to execute
    curl_setopt ( $ch, CURLOPT_TIMEOUT, 60 );
    // Waiting 20 seconds while trying to connect
    curl_setopt ( $ch, CURLOPT_CONNECTTIMEOUT, 60 );
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response_string = curl_exec( $ch );
    $curl_info = curl_getinfo( $ch );
    print_r($curl_info);
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
        $api_result = substr($response_string, 0, 4);
        $status_code = $api_result;
        $sms_result['api_status_code'] = $status_code;
        if ( $api_result != 2019 ) {
            $sms_result['details'] .= "Error: could not parse valid return data from server.\n" . $api_result;
        } else {
            if ($status_code == '2019') {
                $sms_result['success'] = 1;
            }
        }
    }
    curl_close( $ch );
    return $sms_result;
}
function seven_bit_sms ( $username, $password, $message, $mno, $sid, $fl, $mt, $ipcl ) {
    $post_fields = array (
        'username' => $username,
        'password' => $password,
        'mno'   => $mno,
        'sid' => $sid,
        'sfl' => $fl,
        'mt' => $mt,
        'ipcl' => $ipcl,
        'message'  => $message
    );
    return make_post_body($post_fields);
}
function make_post_body($post_fields) {
    $stop_dup_id = make_stop_dup_id();
    if ($stop_dup_id > 0) {
        $post_fields['stop_dup_id'] = make_stop_dup_id();
    }
    $post_body = '';
    foreach( $post_fields as $key => $value ) {
        $post_body .= urlencode( $key ).'='.urlencode( $value ).'&';
    }
    $post_body = rtrim( $post_body,'&' );
    return $post_body;
}
function make_stop_dup_id() {
    return 0;
}


?>
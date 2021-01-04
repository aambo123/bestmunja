<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


class Curl_token {
    public function get_token($username,$password)
    {
         $str = base64_encode(''.$username.':'.$password.'');
         $curl = curl_init();
         curl_setopt_array($curl, array(
           CURLOPT_URL => "https://auth.routee.net/oauth/token",
           CURLOPT_RETURNTRANSFER => true,
           CURLOPT_ENCODING => "",
           CURLOPT_MAXREDIRS => 10,
           CURLOPT_TIMEOUT => 30,
           CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
           CURLOPT_CUSTOMREQUEST => "POST",
           CURLOPT_POSTFIELDS => "grant_type=client_credentials",
           CURLOPT_HTTPHEADER => array(
              "authorization: Basic {$str}",
              "content-type: application/x-www-form-urlencoded"
            ),
          ));
          $response = curl_exec($curl);
          $err = curl_error($curl);
          curl_close($curl);
          if ($err) {
               echo "cURL Error #:" . $err;
          } else {
               return json_decode($response);
          }
    }
    public function get_balance($token)
    {

          $curl = curl_init();

          curl_setopt_array($curl, array(
               CURLOPT_URL => "https://connect.routee.net/accounts/me/balance",
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_ENCODING => "",
               CURLOPT_MAXREDIRS => 10,
               CURLOPT_TIMEOUT => 30,
               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
               CURLOPT_CUSTOMREQUEST => "GET",
               CURLOPT_HTTPHEADER => array(
               "Authorization: Bearer {$token}"
            ),
          ));

          $response = curl_exec($curl);
          $err = curl_error($curl);

          curl_close($curl);

          if ($err) {
               echo "cURL Error #:" . $err;
          } else {
               return json_decode($response);
          }
    }
    function send_message($url,$post_fields,$token){

         $body = json_encode($post_fields);
         $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_HTTPHEADER => array(
              "authorization: Bearer {$token}",
              "content-type: application/json"
            ),
          ));

          $response = curl_exec($curl);
          $err = curl_error($curl);

          curl_close($curl);

         if ($err) {
               echo "cURL Error #:" . $err;
         } else {
              return json_decode($response);
         };
    }
    function get_pricing($token)
    {
          $curl = curl_init();
          curl_setopt_array($curl, array(
               CURLOPT_URL => "https://connect.routee.net/system/prices",
               CURLOPT_RETURNTRANSFER => true,
               CURLOPT_ENCODING => "",
               CURLOPT_MAXREDIRS => 10,
               CURLOPT_TIMEOUT => 30,
               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
               CURLOPT_CUSTOMREQUEST => "GET",
               CURLOPT_HTTPHEADER => array(
                    "Authorization: Bearer {$token}"
               ),
          ));

          $response = curl_exec($curl);
          $err = curl_error($curl);

          curl_close($curl);

          if ($err) {
               echo "cURL Error #:" . $err;
          } else {
               return json_decode($response);
          }
    }
}

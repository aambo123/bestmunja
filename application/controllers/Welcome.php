<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->view('welcome_message');
	}
	public function process(){
		$this->load->view('vendor/autoload.php');
		
		$options = array(
		    'cluster' => 'ap3',
		    'useTLS' => true
		  );
		  $pusher = new Pusher\Pusher(
		    '86886ac93a23bc33e419',
		    '4d0e4bc5891658f88bfc',
		    '824740',
		    $options
		  );

		  $data['message'] = "<div class='notif_title1'>SMS Notification <a class='close' onclick='hideNotif($(this))'> x </a></div>  <div style='border-top: solid 1px #eee;'></div> <div class='notif_title2'> baaska SMS Sending</div>";
          $data['id'] =
		  $pusher->trigger('lcdns', 'my-event', $data);
	}
}

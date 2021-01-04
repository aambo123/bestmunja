<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings_model extends CI_Model{

    function __construct() {
			parent::__construct();
    }

    function get_settings() {

			$this->db->select('*');
			$this->db->from('settings');
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->row();
    }

    function settings_save($data) {

			$this->db->insert('settings', $data);
			return $this->db->insert_id();
    }


    function update($id, $data) {

			$this->db->where('id', $id);
			$this->db->update('settings', $data);
    }


    function get_sms_accounts() {

			$this->db->select('*');
			$this->db->from('sms_1s2u_account');
			$this->db->order_by('order', 'asc');
			$query = $this->db->get();
			return $query->result();
    }

    function get_msg_price($rec_code) {

			$this->db->select('*');
			$this->db->where('rec_code', $rec_code);
			$this->db->from('recommendation');
			$query = $this->db->get();
			return $query->row();
    }

    function get_recommendation_one($id) {

			$this->db->select('*');
			$this->db->where('rec_id', $id);
			$this->db->from('recommendation');
			$query = $this->db->get();
			return $query->row();
		}
    
    function get_recommendation_whith_api() {
        $id = $this->session->userData('id');
        $sql = 'SELECT rc1.*,acc.username
                FROM recommendation rc1
                JOIN sms_1s2u_account acc
                on acc.id = 
                    CASE rc1.account_id
                        WHEN 0 then (
                            SELECT rc.account_id FROM g5_member mb
                            JOIN recommendation rc
                            ON mb.mb_recommend = rc.rec_id
                            WHERE mb.mb_no = rc1.created_id )
                        ELSE rc1.account_id 
                    END';
        if($this->session->userData('user_level') == 'Reseller') {
            $sql = $sql.' WHERE created_id = ?';
        }
        $query = $this->db->query($sql,$id);
        return $query->result();
    }

    function get_recommendation_one_by_code($id) {

			$this->db->select('*');
			$this->db->where('rec_code', $id);
			$this->db->from('recommendation');
			$query = $this->db->get();
			return $query->row();
    }
    function get_recommendation_one_by_id($id) {

			$this->db->select('*');
			$this->db->where('rec_id', $id);
			$this->db->from('recommendation');
			$query = $this->db->get();
			return $query->row();
    }

    function get_recommendation() {
			
			$this->db->select('*');
			
			if($this->session->userData('user_level') == 'Reseller') {
				$this->db->join('g5_member','g5_member.mb_no = recommendation.created_id');
				$this->db->where('g5_member.reseller_id', $this->session->userData('id'));
				$this->db->where('created_id', $this->session->userData('id'));
			} 
			$this->db->from('recommendation');
			
			$query = $this->db->get();
			return $query->result();
		}

	function get_send_account($member_id){
        $sql = 'SELECT * FROM sms_1s2u_account
                WHERE id = (
                SELECT
                    CASE rc1.account_id
                        WHEN 0 then (
                            SELECT rc.account_id FROM g5_member mb
                            JOIN recommendation rc
                            ON mb.mb_recommend = rc.rec_id
                            WHERE mb.mb_no = rc1.created_id )
                        ELSE rc1.account_id 
                    END AS api_id
                FROM recommendation rc1
                JOIN g5_member mb1
                ON mb1.mb_recommend = rc1.rec_id 
                WHERE mb1.mb_no = ? ) ';
        $query = $this->db->query($sql,$member_id);
        return $query->row();

    }

    function recommendation_save($data) {

			$this->db->insert('recommendation', $data);
			return $this->db->insert_id();
    }

    function recommendation_update($id, $data) {

			$this->db->where('rec_id', $id);
			$this->db->update('recommendation', $data);
    }

    function sender_save($data) {

			$this->db->insert('sender', $data);
			return $this->db->insert_id();
    }

		function sender_update($id, $data) {

			$this->db->where('id', $id);
			$this->db->update('sender', $data);
    }

    function sender_delete($id) {

			$this->db->where('id', $id);
			$this->db->delete('sender');
    }

    function recommendation_delete($id) {

			$this->db->where('rec_id', $id);
			$this->db->delete('recommendation');
    }

    function sms_account_save($data) {

			$this->db->insert('sms_1s2u_account', $data);
			return $this->db->insert_id();
    }

    function get_sms_account_count() {

			$this->db->select('*');

			$this->db->from('sms_1s2u_account');
			//$this->db->where('msg_limit >', 0);
			$total_sold = $this->db->count_all_results();

			if ($total_sold > 0) {
				return $total_sold;
			}

			return 0;
    }

    function get_account_limit() {

			$this->db->select('sum(msg_limit) as msg_limit_count');
			//$this->db->where('order', $order);
			$this->db->from('sms_1s2u_account');
			$query = $this->db->get();
			return $query->row();
    }

    function get_account_by_order($order) {

			$this->db->select('*');
			$this->db->where('order', $order);
			$this->db->from('sms_1s2u_account');
			$query = $this->db->get();
			return $query->row();
    }

    function get_sms_account_one($id) {

			$this->db->select('*');
			$this->db->where('id', $id);
			$this->db->from('sms_1s2u_account');
			$query = $this->db->get();
			return $query->row();
    }

    function get_sms_account_one_last_order() {
			$this->db->select('*');

			$this->db->from('sms_1s2u_account');
			$this->db->order_by('order', 'desc');
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->row();
    }

    function get_sms_account_by_order($acount, $co) {

			$this->db->select('*');

			$this->db->from('sms_1s2u_account');
			$this->db->where('order', $acount);
			$this->db->where('msg_limit >=', $co);
			$query = $this->db->get();
			return $query->row();
    }

    function get_sms_account_by_order_other($co) {

			$this->db->select('*');

			$this->db->from('sms_1s2u_account');
			$this->db->where('msg_limit >=', $co);
			$this->db->order_by('id', 'RANDOM');
			$this->db->limit(1);
			$query = $this->db->get();
			return $query->row();
    }

    function sms_account_update($id, $data) {

			$this->db->where('id', $id);
			$this->db->update('sms_1s2u_account', $data);
    }

    function sms_account_delete($id) {

			$this->db->where('id', $id);
			$this->db->delete('sms_1s2u_account');
    }

    function get_sms_account_default() {

			$this->db->select('*');
			$this->db->where('default', 1);
			$this->db->from('sms_1s2u_account');
			$query = $this->db->get();
			return $query->row();
    }

    function get_api_list() {

			$this->db->select('*')
									->from('sms_api');
			$query = $this->db->get();
			return $query->result();
		}
		
    function api_save($data) {

			$this->db->insert('sms_api', $data);
			return $this->db->insert_id();
		}
		
    function api_update($id,$data) {

			$this->db->where('id', $id);
			$this->db->update('sms_api', $data);
		}
		
    function get_api_one($id) {

			$this->db->select('*')
									->from('sms_api')
									->where('id',$id);
			$query = $this->db->get();
			return $query->row();
		}
		
    function api_delete($id) {

			$this->db->where('id', $id);
			$this->db->delete('sms_api');
		}
		
    function get_meta() {

			$this->db->select('*')
								->from('meta')
								->where('id',1);
			$query = $this->db->get();
			return $query->row();
    }
}
?>

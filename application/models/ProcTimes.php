<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ProcTimes extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
    }

    public function update($data)
    {
        $this->db->insert('test', $data);
    }
}


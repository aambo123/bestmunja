<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tools extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //$this->load->database();
        $this->load->model('procTimes');
    }

    public function proc1($param = 1)
    {
        if(is_cli()) //so this cannot be run from a browser
        {

            $data = array(
                'proc1' => '123',
            );
            $this->procTimes->update($data);


        }
    }

    public function proc2($param = 1)
    {
        if(is_cli())
        {
            $time_start = microtime(true);
            for($i = 1; $i < $param; $i++)
            {
                log10($i);
            }
            $time_end = microtime(true);
            $time = $time_end - $time_start;
            $data = array(
                'proc2' => $time,
            );
            $this->procTimes->update($data);
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

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
        
        $this->load->view('v_main');
	}
    
    function get_data($dt = ""){
        if(!empty($_GET['dt'])) {
            $dt = $_GET['dt'];
        } elseif(empty($dt)) {
            $dt = date("Y-m-d");
        }
        $sql = "select temperature, 
                       humidity,
                       to_char(dt, 'hh24:mi') as time
                from dht22
                where dt between ? and ? 
                order by dt;";
        $res = $this->db->query($sql, array($dt." 00:00:00", $dt." 23:59:59"));
        $rows = $res->result_array();
        echo json_encode($rows);
    }
}

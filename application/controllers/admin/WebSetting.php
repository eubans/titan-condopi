<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebSetting extends CI_Controller {

	private $is_login = false;
    private $data = array();
    private $user_id = 0;
	public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->data["is_login"] = true;
            $this->data['user'] = $this->session->userdata('user_info');
            $this->user_id = $this->data['user']['id'];
        }
        else{
            redirect(base_url('/home/'));
        }
    }

	public function index()
	{
        if($this->input->post()){
             
        }
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/admin/web_setting',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
	}

    
}

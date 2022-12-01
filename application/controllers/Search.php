<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller {

	private $is_login = false;
    private $data = array();
	public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->data["is_login"] = true;
            $this->data['user'] = $this->session->userdata('user_info');
            
            $this->user_id = $this->data['user']['id'];
            $this->data['member_expiry'] = $this->Common_model->get_record('Member_Expiry',array('Member_ID' => $this->user_id));
        }
        $this->load->helper(array('url','form'));
    }

	public function index()
	{
        $this->data['not_show_breadcrum'] = true;
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/search/index',$this->data);
	}
    public function detail()
    {
        $this->data['not_show_breadcrum'] = true;
        $this->data["not_show_banner"] = true;
        $this->load->view('frontend/block/header',$this->data);
        $this->load->view('frontend/search/detail-new',$this->data);
    }
	private function _get_paging($array_init) 
    {
        $config                = array();
        $config["base_url"]    = $array_init["base_url"];
        $config["total_rows"]  = $array_init["total_rows"];
        $config["per_page"]    = $array_init["per_page"];
        $config["uri_segment"] = $array_init["segment"];
        if(isset($array_init['page_query_string']) && $array_init['page_query_string']){
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'offset';
        }
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = 'Prev «';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Next »';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '<span aria-hidden="true">»</span>';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '<span aria-hidden="true">«</span>';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        return $config;
    }

}

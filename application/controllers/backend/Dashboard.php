<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends My_Controller {
    private $html_modules = '';
    private $folder_view  = "dashboard"; 
    private $base_controller ;
    public function __construct() {
        parent::__construct();
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    public function index() {
    	$this->data["controller"] = "users";
        $this->data["main_page"] = "dashboard";
        $where["1"] = "1";
        $where["Status"] = "0";
        if($this->input->get("membername")){
            $where["CONCAT(First_Name ,' ',Last_Name) Like"] = "%".$this->input->get("membername")."%" ;
        }
        if($this->input->get("typemember") && $this->input->get("typemember") != "0"){
            $where["Type_Member"]= @$this->input->get("typemember") ;
        }   	
        $count_table =  $this->Common_model->count_table("Members",$where);
        $page_current = ($this->input->get("per_page") != "") ? $this->input->get("per_page") : 0 ;    
        $per_page = 20;
        $page_current = ($page_current > 0) ? ($page_current - 1) : $page_current;
        $offset = $per_page * $page_current;
        $this->data["table_data"] = $this->Common_model->get_result("Members",$where,$offset,$per_page);
        $this->load->library('pagination');
        $config['base_url'] = base_url("backend/users");
        $config['total_rows'] = $count_table ;
        $config['per_page'] = $per_page;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['prev_link'] = '&larr; Previous';
        $config['first_link'] = '<< First';
        $config['last_link'] = 'Last >>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['enable_query_strings']  = true;
        $config['page_query_string']  = true;
        $config['query_string_segment'] = "per_page";
        $config['use_page_numbers'] = TRUE;
        $this->pagination->initialize($config);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }

}

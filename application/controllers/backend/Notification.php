<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Notification extends MY_Controller {
    private $folder_view = "notification"; 
    private $base_controller ;
    
    public function __construct() {
        parent::__construct();
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    
    public function index(){
        $where["1"] = 1;
        if($this->input->get("keyword")){
            $where ["Title Like"] = "%".$this->input->get("keyword")."%" ;
        }
        $count_table =  $this->Common_model->count_table("Notification",$where);
        $page_current = ($this->input->get("per_page") != "") ? $this->input->get("per_page") : 0 ;
        $per_page = 20;
        $page_current = ($page_current > 0) ? ($page_current - 1) : $page_current;
        $offset = $per_page * $page_current;
        $this->data["table_data"] = $this->Common_model->get_result("Notification",$where,$offset,$per_page,array('Created_at' => 'DESC'));
        $this->load->library('pagination');
        $config['base_url'] = base_url("backend/notification");
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
    
    public function create() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('Title', 'Title', 'required');
            if ($this->form_validation->run() == TRUE) {
                $colums = $this->db->list_fields('Notification');
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }
                }
                $data_insert["Created_at"] = date('Y-m-d H:i:s');
                $id = $this->Common_model->add("Notification",$data_insert);
                if (isset($id)) {
                	// Save to database for each member
                	$member_collection = $this->Common_model->get_result("Members",null,null,null);
                	if ($member_collection != null) {
                		foreach ($member_collection as $key => $member_item) {
                			$data_member_insert = array(
                				'Member_ID' => $member_item['ID'],
                				'Notification_ID' => $id,
                				'IsRead' => '0',
                				'Read_Date' => date('Y-m-d H:i:s')
                			);
                			$this->Common_model->add("Notification_Member", $data_member_insert);
                		}
                	}
                }
                redirect(backend_url($this->base_controller.'/edit/' . $id ."?create=success"));
            }else{
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        $path = '../../skins/js/ckfinder';
        $this->_editor($path, '400px');
        $this->load->view($this->backend_asset."/".$this->folder_view."/create",$this->data);
    }
    
    public function delete($id = 0){
    	// Delete Notification member
    	$this->Common_model->delete("Notification_Member",array("Notification_ID" => $id));
    	$this->Common_model->delete("Notification",array("ID" => $id));
    	redirect(backend_url($this->base_controller."?delete=success"));
    }
    
    public function edit($id = null){
    	if($id == null)
    		redirect(backend_url($this->base_controller));
    	$record = $this->Common_model->get_record("Notification",array("ID" => $id));
    	if($record == null)
    		redirect(backend_url($this->base_controller));
        if($this->input->post()){
            $this->form_validation->set_rules('Title', 'Title', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Notification');
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }
                }  
                $this->Common_model->update("Notification",$data_update,array("ID" =>$record["ID"]));  
                redirect(backend_url($this->base_controller.'/edit/' . $id. "?edit=success"));
            }else{
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        $path = '../../skins/js/ckfinder';
        $this->_editor($path, '400px');
    	$this->data['record'] = $record;
    	$this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }
}

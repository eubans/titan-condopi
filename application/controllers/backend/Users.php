<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller {
    private $folder_view     = "users"; 
    private $base_controller ;
    public function __construct() {
        parent::__construct();
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    public function index(){
        $where  ["1"] = "1";
        if($this->input->get("membername")){
            $where ["CONCAT(First_Name ,' ',Last_Name) Like"] = "%".$this->input->get("membername")."%" ;
        }
        if($this->input->get("typemember") && $this->input->get("typemember") != "0"){
            $where ["Type_Member"]= @$this->input->get("typemember") ;
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
    public function create(){
        if($this->input->post()){
            $this->form_validation->set_rules('First_Name', 'First Name', 'required');
            $this->form_validation->set_rules('Last_Name', 'Last Name', 'required');
            $this->form_validation->set_rules('Password', 'Password', 'trim|min_length[6]');
            $this->form_validation->set_rules('Status', 'Status', 'required');
            $this->form_validation->set_rules('Gender', 'Gender', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Members');
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }              
                }
                $data_insert["Password"] = md5(trim($data_insert["Email"]) .':'.trim($data_insert["Password"]));
                $id = $this->Common_model->add("Members",$data_insert);  
                if($id){
	                if (isset($_FILES["Avatar"]) && $_FILES["Avatar"]["error"] == 0){
	                    $upload_path = FCPATH . "/uploads";
	                    if (!is_dir($upload_path)) {
	                        mkdir($upload_path, 0755, TRUE);
	                    }
	                    $upload_path = FCPATH . "/uploads/member";
	                    if (!is_dir($upload_path)) {
	                        mkdir($upload_path, 0755, TRUE);
	                    }
	                    $upload_path = $upload_path . "/" . $id;
	                    if (!is_dir($upload_path)) {
	                        mkdir($upload_path, 0755, TRUE);
	                    }
	                    $file = $_FILES["Avatar"];
	                    $allowed_types = "jpg|png";
	                    $upload = upload_flie($upload_path, $allowed_types, $file);	                   
	                    if($upload["status"] == "success"){
	                    	$data_update["Avatar"] = "uploads/member/".$id."/".$upload["reponse"]["file_name"];
	                    	$this->Common_model->update("Members",$data_update,array("ID" => $id));
	                    }                	
	                }
                }
                redirect(backend_url($this->base_controller.'/edit/' . $id ."?create=success"));
            }else{
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $this->load->view($this->backend_asset."/".$this->folder_view."/create",$this->data);
    }
    public function delete($id = 0){
    	$this->Common_model->delete("Members",array("ID" => $id));
    	redirect(backend_url($this->base_controller."?delete=success"));
    }
    public function edit($id = null){
    	if($id == null)
    		redirect(backend_url($this->base_controller));
    	$record = $this->Common_model->get_record("Members",array("ID" => $id));
    	if($record == null)
    		redirect(backend_url($this->base_controller));
        if($this->input->post()){
            $this->form_validation->set_rules('First_Name', 'First Name', 'required');
            $this->form_validation->set_rules('Last_Name', 'Last Name', 'required');
            $this->form_validation->set_rules('Password', 'Password', 'trim|min_length[6]');
            $this->form_validation->set_rules('Status', 'Status', 'required');
            $this->form_validation->set_rules('Gender', 'Gender', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Members');
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }              
                }  
                $data_update["Update_At"]    = date("Y-m-d h:i:sa");
                if($data_update["Password"] != null && $data_update["Password"] != "")
                    $data_update["Password"] = md5(trim($record["Email"]) .':'.trim($data_update["Password"]));
                if (isset($_FILES["Avatar"]) && $_FILES["Avatar"]["error"] == 0){
                    $upload_path = FCPATH . "/uploads";
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = FCPATH . "/uploads/member";
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = $upload_path . "/" . $id;
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $file = $_FILES["Avatar"];
                    $allowed_types = "jpg|png";
                    $upload = upload_flie($upload_path, $allowed_types, $file);
                    if($upload["status"] == "success")
                    	$data_update["Avatar"] = "/uploads/member/".$id."/".$upload["reponse"]["file_name"];
                }else{
                	$data_update["Avatar"] = $record["Avatar"];
                }
                $this->Common_model->update("Members",$data_update,array("ID" =>$record["ID"]));  
                redirect(backend_url($this->base_controller.'/edit/' . $id. "?edit=success"));
            }else{
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
    	$this->data['record'] = $record;
    	$this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }
}

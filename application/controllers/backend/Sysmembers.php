<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sysmembers extends MY_Controller {
    private $folder_view  = "sysmembers"; 
    private $base_controller ;
    public function __construct() {
        parent::__construct();
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    public function index(){
    	$this->data["table_data"] = $this->Common_model->get_result("Sys_Users");
    	$this->data["role"] = $this->Common_model->get_result("Sys_Roles");
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }
    public function create(){
        if($this->input->post()){
            $this->form_validation->set_rules('User_Name', 'Name', 'required');
            $this->form_validation->set_rules('User_Email', 'Email', 'required|trim|valid_email|is_unique[Sys_Users.User_Email]');
            $this->form_validation->set_rules('User_Pwd', 'Password', 'required|trim|min_length[6]');
            $this->form_validation->set_rules('Status', 'Status', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Sys_Users');
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }              
                }
                $data_insert["User_Pwd"] = md5(trim($data_insert["User_Pwd"])."{:MC:}".trim($data_insert["User_Email"]));
                if (isset($_FILES["User_Avatar"]) && isset($_FILES["User_Avatar"]["name"]) && !empty($_FILES["User_Avatar"]["name"])){
                    $upload_path = FCPATH . "/uploads/backend";
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = FCPATH . "/uploads/backend/member";
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = $upload_path . "/" . $this->user_info["ID"];
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $file = $_FILES["User_Avatar"];
                    $allowed_types = "jpg|png";
                    $upload = upload_flie($upload_path, $allowed_types, $file);
                    if($upload["status"] == "success")
                    	$data_insert["User_Avatar"] = "uploads/backend/member/".$this->user_info["ID"]."/".$upload["reponse"]["file_name"];
                	else
                		$data_insert["User_Avatar"] = "";
                }else{
                	$data_insert["User_Avatar"] = "";
                }
                $id = $this->Common_model->add("Sys_Users",$data_insert);  
                redirect(backend_url($this->base_controller.'/edit/' . $id ."?create=success"));
            }else{
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $this->data["role"] = $this->Common_model->get_result("Sys_Roles");
        $this->load->view($this->backend_asset."/".$this->folder_view."/create",$this->data);
    }
    public function delete($id = 0){
    	$this->Common_model->delete("Sys_Users",array("ID" => $id));
    	redirect(backend_url($this->base_controller."?delete=success"));
    }
    public function edit($id = null){
    	if($id == null){
    		redirect(backend_url("/".$this->folder_view.""));
        }
    	$record = $this->Common_model->get_record("Sys_Users",array("ID" => $id));
    	if($record == null){
    		redirect(backend_url("/".$this->folder_view.""));
        }
        if($this->input->post()){
            $this->form_validation->set_rules('User_Name', 'Name', 'required');
            $this->form_validation->set_rules('User_Pwd', 'Password', 'min_length[6]');
            $this->form_validation->set_rules('Status', 'Status', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Sys_Users');
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }              
                }
                $data_update["Updatedat"] = date("Y-m-d h:i:sa");
                if($data_update["User_Pwd"] != null && $data_update["User_Pwd"] != "")
                	$data_update["User_Pwd"] = md5(trim($data_update["User_Pwd"])."{:MC:}".trim($record["User_Email"]));

                if (isset($_FILES["User_Avatar"]) && isset($_FILES["User_Avatar"]["name"]) && !empty($_FILES["User_Avatar"]["name"])){
                    $upload_path = FCPATH . "/uploads/backend";
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = FCPATH . "/uploads/backend/member";
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = $upload_path . "/" . $this->user_info["ID"];
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $file = $_FILES["User_Avatar"];
                    $allowed_types = "jpg|png";
                    $upload = upload_flie($upload_path, $allowed_types, $file);
                    if($upload["status"] == "success")
                    	$data_update["User_Avatar"] = "uploads/backend/member/".$this->user_info["ID"]."/".$upload["reponse"]["file_name"];
                	else
                		$data_update["User_Avatar"] = $record["User_Avatar"];
                }else{
                	$data_update["User_Avatar"] = $record["User_Avatar"];
                }
                $this->Common_model->update("Sys_Users",$data_update,array("ID" =>$record["ID"]));  
                redirect(backend_url($this->base_controller.'/edit/' . $id. "?edit=success"));
            }else{
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $this->data["role"] = $this->Common_model->get_result("Sys_Roles");
    	$this->data['record'] = $record;
    	$this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }
}

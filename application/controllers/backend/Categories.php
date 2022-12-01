<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categories extends MY_Controller {
    private $folder_view   = "categories"; 
    private $base_controller ;
    public function __construct() {
        parent::__construct();
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    public function index(){
        $listCat = $this->Common_model->get_result("Categories");
        $this->data["table_data"] = $this->get_html_category($listCat);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }
    public function create(){
        if($this->input->post()){
            $this->form_validation->set_rules('Name', 'Name', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Categories');
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }              
                }
                $id = $this->Common_model->add("Categories",$data_insert);  
                if($id){
                    if (isset($_FILES["Thumb"]) && $_FILES["Thumb"]["error"] == 0){
                        $upload_path = FCPATH . "/uploads";
                        if (!is_dir($upload_path)) {
                            mkdir($upload_path, 0755, TRUE);
                        }
                        $upload_path = FCPATH . "/uploads/categories/";
                        if (!is_dir($upload_path)) {
                            mkdir($upload_path, 0755, TRUE);
                        } 
                        $file = $_FILES["Thumb"];
                        $allowed_types = "jpg|png";
                        $upload = upload_flie($upload_path, $allowed_types, $file);                    
                        if($upload["status"] == "success"){
                            $data_update["Thumb"] = "uploads/categories/".$upload["reponse"]["file_name"];
                            $this->Common_model->update("Categories",$data_update,array("ID" => $id));
                        }                   
                    }
                }
                redirect(backend_url($this->base_controller.'/edit/' . $id ."?create=success"));
            }else{
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $listCat = $this->Common_model->get_result("Categories");
        $this->data["listcat"] = $this->get_html_category($listCat,0,'',false);
        $this->load->view($this->backend_asset."/".$this->folder_view."/create",$this->data);
    }
    public function delete($id = 0){
        $this->Common_model->delete("Categories",array("ID" => $id));
        redirect(backend_url($this->base_controller."?delete=success"));
    }
    public function edit($id = null){
        $record = $this->Common_model->get_record("Categories",array("ID" => $id));
        if($record == null)
            redirect(backend_url($this->base_controller));
        if($this->input->post()){
            $this->form_validation->set_rules('Name', 'Name', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Categories');
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }              
                }
                if (isset($_FILES["Thumb"]) && $_FILES["Thumb"]["error"] == 0){
                    $upload_path = FCPATH . "/uploads/backend";
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = FCPATH . "/uploads/categories";
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $file = $_FILES["Thumb"];
                    $allowed_types = "jpg|png";
                    $upload = upload_flie($upload_path, $allowed_types, $file);
                    if($upload["status"] == "success")
                        $data_update["Thumb"] = "uploads/categories/".$upload["reponse"]["file_name"];
                    else
                        $data_update["Thumb"] = $record["Thumb"];
                }else{
                    $data_update["Thumb"] = $record["Thumb"];
                }
                $this->Common_model->update("Categories",$data_update,array("ID" =>$record["ID"]));  
                redirect(backend_url($this->base_controller.'/edit/' . $id. "?edit=success"));
            }else{
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $this->data["record"] = $record;
        $listCat = $this->Common_model->get_result("Categories",array("ID != " => $record["ID"]));
        $this->data["listcat"] = $this->get_html_category($listCat,0,'',false,$record["Parent_ID"]);
        $this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }

    private $index = 1;
    private $html_modules = "";
    private function get_html_category($data = null,$root = 0,$level = '', $table = true , $activer = -1){
        $termsList = array();
        $new_listdata = array();
        if ($root != 0)
        {
            $level .= '&mdash; &mdash;';
        }
        if ($data != null) { 
            foreach ($data AS $key => $item )
            {
                if ($item['Parent_ID'] == $root)
                {
                    $termsList[] = ($item);
                }
                else
                {
                    $new_listdata[] = ($item);
                }
            }
        }
        if ($termsList != null)
        {
            foreach ($termsList AS $key => $item_2 )
            {
                $active = '';
                if ($activer == $item_2['ID'])
                {
                    $active = 'selected';
                }
                if ($table == false)
                {
                    $this->html_modules .= '<option value="' . $item_2['ID'] . '" '. $active . '>' . $level . '  ' . $item_2['Name'] . '</option>';                   
                }
                else
                {
                    $this->html_modules .= '<tr>';
                    $this->html_modules .= '<td>'.($this->index++).'</td>';
                    $this->html_modules .= '<td>' . $level . '  ' . $item_2['Name'] . '</td>';
                    $this->html_modules .= '<td><img src="' .base_url( $item_2['Thumb'] ) . '"/></td>';
                    $this->html_modules .= '<td>English</td>';
                    $this->html_modules .= '<td>'.$item_2["Create_At"].'</td>';
                    $this->html_modules .= '<td><a href = "'.backend_url($this->base_controller.'/edit/'. $item_2['ID']).'" title = "Edit" style = "margin-right:5px;"> edit </a> | <a title="delete" href = "'.backend_url($this->base_controller.'/delete/'. $item_2['ID']).'" onclick="return confirm(\'Do you really want to delete ?\');"> delete </a> </td>';
                    $this->html_modules .= '</tr>';
                }
                $this->get_html_category($new_listdata, $item_2['ID'], $level, $table, $activer);
            }
        }
        return $this->html_modules;
    }
}

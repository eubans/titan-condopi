<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class sysroles extends MY_Controller {
    private $folder_view = "sysroles"; 
    private $base_controller ;
    public function __construct() {
        parent::__construct();
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    public function index(){
    	$this->data["table_data"] = $this->Common_model->get_result("Sys_Roles");
        $this->data["role"] = $this->Common_model->get_result("Sys_Users");
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }
    public function create(){
        if($this->input->post()){
            $this->form_validation->set_rules('Role_Title', 'Role Name', 'required');
            $this->form_validation->set_rules('Status', 'Status', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Sys_Roles');
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }              
                }
                $data_insert["Member_ID"] = $this->user_info["ID"];
                $id = $this->Common_model->add("Sys_Roles",$data_insert);  
                redirect(backend_url($this->base_controller.'/edit/' . $id ."?create=success"));
            }else{
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $this->load->view($this->backend_asset."/".$this->folder_view."/create",$this->data);
    }
    public function edit($id = null){
        if($id == null)
            redirect(backend_url($this->base_controller));
        $record = $this->Common_model->get_record("Sys_Roles",array("ID" => $id));
        if($record == null)
            redirect(backend_url($this->base_controller));
        if($this->input->post()){
            $this->form_validation->set_rules('Role_Title', 'Role Name', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Sys_Roles');
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }              
                }
                $this->Common_model->update("Sys_Roles",$data_update,array("ID" =>$record["ID"]));  
                redirect(backend_url($this->base_controller.'/edit/' . $id. "?edit=success"));
            }else{
                $this->data['post']['error'] = validation_errors();
            }
        }
        $this->data['record'] = $record;
        $this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }
    public function details($id = null){
        $record = $this->Common_model->get_record("Sys_Roles",array("ID" => $id));
        if($record == null)
            redirect(backend_url($this->base_controller));
        if($this->input->post()){
            $modules = $this->input->post("Modules");
            $allow = $this->input->post("Allow");
            if(count($modules) == count($allow)){
                foreach ($modules as $key => $value) {
                    $data_cm = array("Module_ID" => $value, "Role_ID" => $id );
                    $check_record = $this->Common_model->get_record("Sys_Rules",$data_cm);
                    $data_cm["Allow"] = $allow[$key];
                    $data_cm["Updatedat"] = date("Y-m-d h:i:sa");
                    if($check_record == null){
                        $this->Common_model->add("Sys_Rules",$data_cm); 
                    }else{
                        $this->Common_model->update("Sys_Rules",$data_cm,array("ID" =>$check_record["ID"])); 
                    }
                }
            }
            redirect(backend_url($this->base_controller.'/details/' . $id. "?edit=success"));
            
        }
        $this->load->model("Sys_rules_model");
        $record_md = $this->Sys_rules_model->get_data_role($id);
        $this->data["html_modules"] = $this->get_html_modules($record_md);
        $this->load->view($this->backend_asset."/".$this->folder_view."/details",$this->data);
    }
    public function delete($id = 0){
        $this->Common_model->delete("Sys_Roles",array("ID" => $id));
        redirect(backend_url("/sysroles?delete=success"));
    }
    private $index = 1;
    private $html_modules = "";
    private function get_html_modules($data = null,$root = 0,$level = '', $table = true , $activer = -1){
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
                    $active = 'checked';
                }
                $this->html_modules .= '<tr><td>'.($this->index++).'</td><td>'.$level .'  '.$item_2['Module_Name'].'</td><td>'.$item_2['Module_Url'].'</td><td> <label>';
                $this->html_modules .=  ($item_2['Allow'] == "1") ? '<input name = "Rules[]" type="checkbox" value = "1" class="js-switch" checked /><input type = "hidden" name = "Allow[]" value="1">' : '<input name="Rules[]" type="checkbox" value = "0" class="js-switch"/><input type = "hidden" name = "Allow[]" value="0">';
                $this->html_modules .= '<input type = "hidden" name = "Modules[]" value="'.$item_2['ID'].'"></label></td></tr>';
                $this->get_html_modules($new_listdata, $item_2['ID'], $level, $table, $activer);
            }
        }
        return $this->html_modules;
    }
}

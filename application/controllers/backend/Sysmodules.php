<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sysmodules extends MY_Controller {
    private $html_modules = '';
    private $folder_view  = "sysmodules"; 
    private $base_controller ;
    public function __construct() {
        parent::__construct();
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    public function index(){
        if($this->input->post()){
            $od = $this->input->post("Order");
            $md = $this->input->post("IDModel");
            foreach ($md as $key => $value) {
                $data_update = array("Order" => $od[$key]);
                $this->Common_model->update("Sys_Modules",$data_update , array("ID" => $value));
            }
            redirect(backend_url($this->base_controller.'?edit=success'));
        }
    	$table_data = $this->Common_model->get_result('Sys_Modules',null,null,null,array(["field" => "Order","sort" => "ASC"]));
    	$this->data['html_modules'] = $this->get_html_modules($table_data);
        $this->load->view($this->backend_asset.'/'.$this->folder_view.'/index',$this->data);
    }
    public function create(){
        if($this->input->post()){
            $this->form_validation->set_rules('Module_Name', 'Name system', 'required');
            $this->form_validation->set_rules('Module_Key', 'Identifier System', 'required');
            $this->form_validation->set_rules('Module_Url', 'Path', 'required');
            $this->form_validation->set_rules('Status', 'Status', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Sys_Modules');
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }              
                }
                $id = $this->Common_model->add("Sys_Modules",$data_insert);  
                redirect(backend_url($this->base_controller.'/edit/' . $id ."?create=success"));
            }else{
            	$this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $table_data = $this->Common_model->get_result('Sys_Modules');
        $this->data['option_modules'] = $this->get_html_modules($table_data,0,'',false,-1);
    	$this->load->view($this->backend_asset."/".$this->folder_view."/create",$this->data);
    }
    public function edit($id = null){
    	if($id == null)
    		redirect(backend_url($this->base_controller));
    	$record = $this->Common_model->get_record("Sys_Modules",array("ID" => $id));
    	if($record == null)
    		redirect(backend_url($this->base_controller));
        if($this->input->post()){
            $this->form_validation->set_rules('Module_Name', 'Name system', 'required');
            $this->form_validation->set_rules('Module_Key', 'Identifier System', 'required');
            $this->form_validation->set_rules('Module_Url', 'Path', 'required');
            $this->form_validation->set_rules('Status', 'Status', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Sys_Modules');
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }              
                }
                $this->Common_model->update("Sys_Modules",$data_update,array("ID" =>$record["ID"]));  
                redirect(backend_url($this->base_controller.'/edit/' . $id. "?edit=success"));
            }else{
                $this->data['post']['error'] = validation_errors();
            }
        }
    	$this->data['record'] = $record;
    	$table_data = $this->Common_model->get_result('Sys_Modules',array("ID !=" => $record["ID"]));
        $this->data['option_modules'] = $this->get_html_modules($table_data,0,'',false,@$record["Parent_ID"]);
    	$this->load->view($this->backend_asset."/".$this->folder_view."/edit",$this->data);
    }
    public function delete($id = 0){
    	$this->Common_model->delete("Sys_Modules",array("ID" => $id));
    	redirect(backend_url("/".$this->folder_view."?delete=success"));
    }
    private $index = 1;
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
                    $active = 'selected';
                }
                if ($table == false)
                {
                    $this->html_modules .= '<option value="' . $item_2['ID'] . '" '. $active . '>' . $level . '  ' . $item_2['Module_Name'] . '</option>';
                   
                }
                else
                {
                    $this->html_modules .= '<tr>';
                    $this->html_modules .= '<td>'.($this->index++).'</td>';
                    $this->html_modules .= '<td>' . $level . '  ' . $item_2['Module_Name'] . '</td>';
                    $this->html_modules .= '<td>' . $item_2['Module_Url'] . '</td>';
                    $this->html_modules .= '<td><input type="number" name = "Order[]" value ="'. $item_2['Order'] .'"><input type="hidden" name = "IDModel[]" value ="'. $item_2['ID'] . '"> </td>';
                    if($item_2["Status"] == "1")
                    	$this->html_modules .='<td>Activity</td>';
                    else
                    	$this->html_modules .='<td>Shut down </td>';
                    $this->html_modules .= '<td><a href = "'.backend_url($this->base_controller.'/edit/'. $item_2['ID']).'" title = "Edit" style = "margin-right:5px;"> edit </a> | <a title="delete" href = "'.backend_url($this->base_controller.'/delete/'. $item_2['ID']).'" onclick="return confirm(\'Do you really want to delete ?\');"> delete </a> </td>';
                    $this->html_modules .= '</tr>';
                }
                $this->get_html_modules($new_listdata, $item_2['ID'], $level, $table, $activer);
            }
        }
        return $this->html_modules;
    }
}

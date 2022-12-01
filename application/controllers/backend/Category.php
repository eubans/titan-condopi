<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends MY_Controller {
    private $folder_view   = "category"; 
    private $base_controller ;
    private $post_type = "blog";
    public function __construct() {
        parent::__construct();
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
        $post_type = isset($_GET["post_type"]) ? $_GET["post_type"] : "blog";
        // Find post_type in database
        $check = $this->Common_model->get_record("Post_Category",array("post_type" => $post_type));
        if ($check == null) {
            $post_type = "blog";
        }
        $this->post_type = $post_type;
        $this->data["post_type"] = $post_type;
    }

    public function index(){
        $listCat = $this->Common_model->get_result("Post_Category",array("Post_Type" => $this->post_type));
        $this->data["table_data"] = $this->get_html_category($listCat);
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }

    public function create(){
        if($this->input->post()){
            $this->form_validation->set_rules('Name', 'Name', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Post_Category');
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }              
                }
                $data_insert['Slug'] =  $this->helperclass->slug('Post_Category',"Slug",$this->input->post('Name'));
                $data_insert['Created_At'] = date('Y-m-d H:i:s');
                $data_insert['Post_Type'] = $this->post_type;
                $id = $this->Common_model->add("Post_Category",$data_insert);
                redirect(backend_url($this->base_controller.'/edit/' . $id ."/?post_type=".$this->post_type."&create=success"));
            }else{
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $listCat = $this->Common_model->get_result("Post_Category",array("Post_Type" => $this->post_type));
        $this->data["listcat"] = $this->get_html_category($listCat,0,'',false);
        $this->load->view($this->backend_asset."/".$this->folder_view."/create",$this->data);
    }

    public function delete($id = 0){
        $this->Common_model->delete("Post_Category",array("ID" => $id));
        redirect(backend_url($this->base_controller."?delete=success&post_type=".$this->post_type));
    }

    public function edit($id = null){
        $record = $this->Common_model->get_record("Post_Category",array("ID" => $id));
        if($record == null)
            redirect(backend_url($this->base_controller."?post_type=".$this->post_type));
        if($this->input->post()){
            $this->form_validation->set_rules('Name', 'Name', 'required');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Post_Category');
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }              
                }
                if($this->input->post('Name') != $record['Name']){
                    $data_update['Slug'] =  $this->helperclass->slug('Post_Category',"Slug",$this->input->post('Name'));
                }
                $this->Common_model->update("Post_Category",$data_update,array("ID" =>$record["ID"]));  
                redirect(backend_url($this->base_controller.'/edit/' . $id. "?edit=success&post_type=".$this->post_type));
            }else{
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $this->data["record"] = $record;
        $listCat = $this->Common_model->get_result("Post_Category",array("ID != " => $record["ID"], "Post_Type" => $this->post_type));
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
                    $this->html_modules .= '<td>' . $level . '  ' . $item_2['Slug'] . '</td>';
                    $this->html_modules .= '<td>'.$item_2["Created_At"].'</td>';
                    $this->html_modules .= '<td><a href = "'.backend_url($this->base_controller.'/edit/'. $item_2['ID'] . '/?post_type='.$this->post_type).'" title = "Edit" style = "margin-right:5px;"> edit </a> | <a title="delete" href = "'.backend_url($this->base_controller.'/delete/'. $item_2['ID'].'/?post_type='.$this->post_type).'" onclick="return confirm(\'Do you really want to delete ?\');"> delete </a> </td>';
                    $this->html_modules .= '</tr>';
                }
                $this->get_html_category($new_listdata, $item_2['ID'], $level, $table, $activer);
            }
        }
        return $this->html_modules;
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Post extends MY_Controller {

    private $folder_view   = "post"; 
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
        $list = $this->Common_model->get_result("Post",array("Post_Type" => $this->post_type));
        $this->data["table_data"] = $list;
        $this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }


    public function create(){
        if($this->input->post()){
            $this->form_validation->set_rules('Name', 'Name', 'required|trim');
            $this->form_validation->set_rules('Content', 'Content', 'required|trim');
            $this->form_validation->set_rules('Category_ID', 'Category_ID', 'required|trim');
            if ($this->post_type == 'blog') {
                //$this->form_validation->set_rules('Media', 'Media', 'required|trim');
                //$this->form_validation->set_rules('Summary', 'Summary', 'required|trim');
            }
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Post');
                $data_post = $this->input->post();
                $data_insert = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_insert[$key] = $value;
                    }              
                }
                $data_insert['Slug'] =  $this->helperclass->slug('Post',"Slug",$this->input->post('Name'));
                $data_insert['Created_At'] = date('Y-m-d H:i:s');
                $data_insert['Updated_At'] = date('Y-m-d H:i:s');
                $data_insert['Post_Type'] = $this->post_type;
                $id = $this->Common_model->add("Post",$data_insert);
                redirect(backend_url($this->base_controller.'/edit/' . $id ."?create=success&post_type=".$this->post_type));
            }else{
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        $path = '../../skins/js/ckfinder';
        $this->_editor($path, '400px');
        $listCat = $this->Common_model->get_result("Post_Category",array("Post_Type" => $this->post_type));
        $this->data["listcat"] = $this->get_html_category($listCat,0,'',false);
        $this->load->view($this->backend_asset."/".$this->folder_view."/create",$this->data);
    }

    public function delete($id = 0){
        $this->Common_model->delete("Post",array("ID" => $id));
        redirect(backend_url($this->base_controller."?delete=success&post_type=".$this->post_type));
    }


    public function edit($id = null){
        $record = $this->Common_model->get_record("Post",array("ID" => $id));
        if($record == null)
            redirect(backend_url($this->base_controller));
        if($this->input->post()){
            $this->form_validation->set_rules('Name', 'Name', 'required|trim');
            $this->form_validation->set_rules('Content', 'Content', 'required|trim');
            $this->form_validation->set_rules('Category_ID', 'Category_ID', 'required|trim');
            if ($this->post_type == 'blog') {
                //$this->form_validation->set_rules('Media', 'Media', 'required|trim');
                //$this->form_validation->set_rules('Summary', 'Summary', 'required|trim');
            }
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Post');
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
                $data_insert['Updated_At'] = date('Y-m-d H:i:s');
                $this->Common_model->update("Post",$data_update,array("ID" =>$record["ID"]));  
                redirect(backend_url($this->base_controller.'/edit/' . $id. "?edit=success&post_type=".$this->post_type));
            }else{
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        $path = '../../skins/js/ckfinder';
        $this->_editor($path, '400px');
        $this->data["record"] = $record;
        $listCat = $this->Common_model->get_result("Post_Category",array("Post_Type" => $this->post_type));
        $this->data["listcat"] = $this->get_html_category($listCat,0,'',false,$record["Category_ID"]);
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
                $this->get_html_category($new_listdata, $item_2['ID'], $level, $table, $activer);
            }
        }
        return $this->html_modules;
    }
}

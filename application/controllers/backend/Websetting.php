<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Websetting extends MY_Controller {
    private $folder_view = "websetting"; 
    private $base_controller ;
    public function __construct() {
        parent::__construct();
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    
    public function index(){
    	$record = $this->Common_model->get_record("Web_Setting");

        if ($this->input->post()) {
            $this->form_validation->set_rules('Title', 'Title', 'required');
            if ($this->form_validation->run() == TRUE) {
                $Title = $this->input->post('Title');
                $Body_Json = $this->input->post('Body_Json');
                if ($Body_Json != null && !empty($Body_Json)) {
                    $Body_Json = json_encode($Body_Json);
                }
                $data_update = array("Title" => $Title, "Body_Json" => $Body_Json);
                $this->Common_model->update("Web_Setting",$data_update,array("ID" =>$record["ID"]));  
                redirect(backend_url($this->base_controller.'/index/?edit=success'));
            } else {
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $this->load->library('ckeditor');
        $path = '../../skins/js/ckfinder';
        $this->_editor($path, '200px');
    	$this->data['record'] = $record;
    	$this->load->view($this->backend_asset."/".$this->folder_view."/index",$this->data);
    }
}

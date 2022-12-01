<?php 
class MY_Controller extends CI_Controller{
    public  $data      = null;
    public  $is_login  = false;
    public  $user_info = null;
    public  $_menu     = '';
    public  $backend_asset = "backend";
    public 	$user_id = 0;
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('admin_info')) {
            $this->is_login  = true;
            $this->user_info = $this->session->userdata('admin_info');
        }
        $this->is_login();
        $this->data["_menu"] = "";
        if (!$this->input->is_ajax_request()) {
            $this->check_module();
            $this->data["_menu"] = $this->_menu;
        }
        $this->data["admin_info"] = $this->user_info;
        $this->user_id = 0;// $this->user_info['Member_ID'];
        $this->data["is_login"]   = $this->is_login;
        $this->data['post'] = $this->input->post();
        $this->data['get'] = $this->input->get();
        $this->load->view($this->backend_asset.'/includes/header',$this->data);
    }
    public function __destruct(){
       echo($this->load->view($this->backend_asset.'/includes/footer',$this->data,true));
    }
    function _editor($path,$height) {
        //Loading Library For Ckeditor
        $this->load->library('ckeditor');
        $this->load->library('ckfinder');
        //configure base path of ckeditor folder 
        $this->ckeditor->basePath = base_url().'skins/js/ckeditor/';
        $this->ckeditor->config['toolbar'] = 'Full';
        $this->ckeditor->config['language'] = 'en';
        $this->ckeditor->config['height'] = $height;
        //configure ckfinder with ckeditor config 
        $this->ckfinder->SetupCKEditor($this->ckeditor,$path); 
    }
    private function is_login()
    {
        if (!$this->is_login) redirect(backend_url('/acounts/login'));
    }
    private function check_module(){
        $rol_model [] = array(
            "ID" => 0,
            "Module_Name"       => "Dashboard",
            "Module_Url"        => "/dashboard",
            "Parent_ID"         => 0,
            "Order"             => 0,
            "Module_Class"      => "dashboard",
            "Icon"              => "fa fa-home"
        );
        $rol_model [] = array(
            "ID" => 0,
            "Module_Name"       => "Your profile",
            "Module_Url"        => "/profiles",
            "Parent_ID"         => 0,
            "Order"             => 0,
            "Module_Class"      => "profile",
            "Icon"              => "fa fa-user",
            "Show"              => "no"
        );
        $rol_model = array_merge($rol_model,$this->Common_model->get_use_rol($this->user_info['Role_ID']));
        $check_url = FALSE;
        $resurl = $this->uri->rsegment(1);
        foreach ($rol_model as $key => $value) {
            $url = str_replace("////","/", $value["Module_Url"]);
            $url = str_replace("///","/", $value["Module_Url"]);
            $url = str_replace("//","/", $value["Module_Url"]);
            $arg = explode("/",$url);
            $arg = array_values(array_diff($arg,array("")));
            if ($arg[0] == $resurl) {
                $this->data["title_page"] = $value["Module_Name"];
                $check_url = true;
            }
        }
        if($this->user_info["System"] != "1" && !$check_url) redirect(backend_url()); 
        $this->create_menu($rol_model,0);
    }
    private function create_menu ($data,$id = 0){
        $termsList = array();
        $new_listdata = array();
        if ($data != null) { 
            foreach ($data AS $key => $item )
            {
                if ($item['Parent_ID'] == $id)
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
        {   if($id == 0){
                $this->_menu .= '<ul class="nav side-menu">';
            }else{
                $this->_menu .= '<ul class="nav child_menu">';
            }
            foreach ($termsList AS $key => $item_2 )
            {
                if(@$item_2["Show"] != "no"){
                    $url = ($item_2["Module_Url"] == "#" || $item_2["Module_Url"] == "") ? "" : ' href = "'. backend_url($item_2["Module_Url"]) . '"';
                    $this->_menu .= '<li class="'.$item_2["Module_Class"].'">';
                    if($id != 0){
                        $this->_menu .= '<a'.$url.'>'.$item_2["Module_Name"].'<span class="fa fa-chevron-down"></span></a>';
                    }else{
                        $this->_menu .= '<a'.$url.'><i class="'.$item_2["Icon"].'"></i>'.$item_2["Module_Name"].'<span class="fa fa-chevron-down"></span></a>';
                    }
                    $this->create_menu($new_listdata, $item_2['ID']);
                    $this->_menu .= '</li>';
                }
                
            }
            $this->_menu .= "</ul>";
        }
    }
}
<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends My_Controller {
	private $folder_view = "products"; 
    private $base_controller ;
    public function __construct() {
        parent::__construct();
         $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    //list all product controller
    public function index()
    {
    	$where = '1=1';
        $count_table =  $this->Common_model->count_table("Products",$where);
        $page_current = ($this->input->get("per_page") != "") ? $this->input->get("per_page") : 0 ;    
        $per_page = 20;
        $page_current = ($page_current > 0) ? ($page_current - 1) : $page_current;
        $offset = $per_page * $page_current;
        $this->data["products"] = $this->Common_model->get_result("Products",$where,$offset,$per_page);
        $this->load->library('pagination');
        $config['base_url'] = base_url("backend/products");
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

    /*public function add(){
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('content', 'Content', 'required|trim');
            $this->form_validation->set_rules('address', 'Address', 'required|trim');
            $this->form_validation->set_rules('price', 'Price', 'required|trim');
            $this->form_validation->set_rules('unit', 'Unit', 'required|trim');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">'.validation_errors().'</div>');
            } else {
                $image = '';
                if (isset($_FILES['picture']) && is_uploaded_file($_FILES['picture']['tmp_name'])) {
                    $output_dir = FCPATH."/uploads/member/".$this->user_id.'/';
                    $output_url = "/uploads/member/".$this->user_id.'/';

                    if (!file_exists($output_dir)) {
                        mkdir($output_dir, 0777, true);
                    }

                    $allowed =  array('gif','png' ,'jpg');
                    $filename = $_FILES['picture']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if(in_array($ext,$allowed)) {
                        $RandomNum    = time();
                        $ImageName    = str_replace(' ', '-', strtolower($_FILES['picture']['name']));
                        $ImageType    = $_FILES['picture']['type']; //"image/png", image/jpeg etc. 
                        $ImageExt     = substr($ImageName, strrpos($ImageName, '.'));
                        $ImageExt     = str_replace('.', '', $ImageExt);
                        $ImageName    = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                        $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                        if(move_uploaded_file($_FILES["picture"]["tmp_name"], $output_dir . $NewImageName)){
                            $image = $output_url.$NewImageName;
                            $image = $output_url.$NewImageName;
                        }
                    }

                }
                $city = 0;
                if($this->input->post('city_code')){
                    $city = $this->input->post('city');
                    $city_code = $this->input->post('city_code');
                    $city_check = $this->Common_model->get_record('CountryCity',array('Code' => $city_code));
                    if(isset($city_check['ID']) && $city_check['ID'] != null){
                        $city_id = $city_check['ID'];
                    }
                    else{
                        $arr = array(
                            'ParentID' => 0,
                            'Name' => $city,
                            'Code' => $city_code,
                            'PathSlug' => '/'
                        );
                        $city_id = $this->Common_model->add("CountryCity", $arr);
                    }
                }

                $arr  = array(
                    'Member_ID' => $this->user_id,
                    'Name' => $this->input->post('name'),
                    'Slug' => $this->helperclass->slug('Products',"Slug",$this->input->post('name')),
                    'Description' => $this->input->post('content'),
                    'Price' => $this->input->post('price'),
                    'Product_Unit' => $this->input->post('unit'),
                    'Image' => $image,
                    'Thumb' => $image,
                    'City_ID' => $city_id,
                    'Address' => $this->input->post('address'),
                    'Latitude' => $this->input->post('latitude'),
                    'Longitude' => $this->input->post('longitude'),
                    'Update_At' => date('Y-m-d H:i:s')
                );
                $product_id = $this->Common_model->add("Products", $arr);
                if(isset($product_id) && $product_id != null && is_numeric($product_id)){
                    $category = $this->input->post('category');
                    if(isset($category) && $category != null){
                        foreach ($category as $key => $item) {
                            $arr = array(
                                'Product_ID' => $product_id,
                                'Category_ID' => $item
                            );
                            $this->Common_model->add("Products_Category", $arr);
                        }
                    }

                    $attribute = $this->input->post('attribute');
                    if(isset($attribute) && $attribute != null){
                        foreach ($attribute as $key => $item) {
                            $arr = array(
                                'Product_ID' => $product_id,
                                'Attribute_ID' => $item
                            );
                            $this->Common_model->add("Products_Attribute", $arr);
                        }
                    }
                    $this->session->set_flashdata('message', '<div class="alert alert-success">Save successfully.</div>');
                }
                else{
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Error!.</div>');
                }
            }
            redirect('/backend/products/add');
        }
        $this->data['title'] = 'Add new Product';
        $this->data['category'] = $this->Common_model->get_result('Categories');
        $this->data['attribute'] = $this->Common_model->get_result('Attributes');
        $this->load->view($this->backend_asset."/".$this->folder_view."/add",$this->data);
    }*/

    public function edit($product_id = null){
    	$this->data['title'] = 'Edit Product';
        $this->data['product'] = $this->Common_model->get_record('Products',array('ID' => $product_id));
        if(!(isset($this->data['product']) && $this->data['product'] != null)){
        	redirect('/backend/products/add');
        }
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('content', 'Content', 'required|trim');
            $this->form_validation->set_rules('address', 'Address', 'required|trim');
            $this->form_validation->set_rules('price', 'Price', 'required|trim');
            $this->form_validation->set_rules('capacity', 'Capacity', 'required|trim');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">'.validation_errors().'</div>');
            } else {
                $city = 0;
                if($this->input->post('city_code')){
                    $city = $this->input->post('city');
                    $city_code = $this->input->post('city_code');
                    $city_check = $this->Common_model->get_record('CountryCity',array('Code' => $city_code));
                    if(isset($city_check['ID']) && $city_check['ID'] != null){
                        $city_id = $city_check['ID'];
                    }
                    else{
                        $arr = array(
                            'ParentID' => 0,
                            'Name' => $city,
                            'Code' => $city_code,
                            'PathSlug' => '/'
                        );
                        $city_id = $this->Common_model->add("CountryCity", $arr);
                    }
                }

                $arr  = array(
                    'Member_ID' => $this->user_id,
                    'Name' => $this->input->post('name'),
                    'Description' => $this->input->post('content'),
                    'Price' => $this->input->post('price'),
                    //'Product_Unit' => $this->input->post('unit'),
                    'Capacity' => $this->input->post('capacity'),
                    'City_ID' => $city_id,
                    'Address' => $this->input->post('address'),
                    'Latitude' => $this->input->post('latitude'),
                    'Longitude' => $this->input->post('longitude'),
                );
                if(@$this->data['product']['Name'] != $this->input->post('name')){
                     $arr['Slug'] = $this->helperclass->slug('Products',"Slug",$this->input->post('name'));
                }
                if (isset($_FILES['picture']) && is_uploaded_file($_FILES['picture']['tmp_name'])) {
                    $output_dir = FCPATH."/uploads/member/".$this->user_id.'/';
                    $output_url = "/uploads/member/".$this->user_id.'/';

                    if (!file_exists($output_dir)) {
                        mkdir($output_dir, 0777, true);
                    }

                    $allowed =  array('gif','png' ,'jpg');
                    $filename = $_FILES['picture']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    if(in_array($ext,$allowed)) {
                        $RandomNum    = time();
                        $ImageName    = str_replace(' ', '-', strtolower($_FILES['picture']['name']));
                        $ImageType    = $_FILES['picture']['type']; //"image/png", image/jpeg etc. 
                        $ImageExt     = substr($ImageName, strrpos($ImageName, '.'));
                        $ImageExt     = str_replace('.', '', $ImageExt);
                        $ImageName    = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                        $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                        if(move_uploaded_file($_FILES["picture"]["tmp_name"], $output_dir . $NewImageName)){
                        	$arr['Image'] = $output_url.$NewImageName;
                        	$arr['Thumb'] = $output_url.$NewImageName;
                        }
                    }

                }
                $this->Common_model->update("Products",$arr,array('ID' => $product_id));
       			
                /*$this->Common_model->delete('Products_Category',array('Product_ID' => $product_id));
       			$category = $this->input->post('category');
                if(isset($category) && $category != null){
                    foreach ($category as $key => $item) {
                        $arr = array(
                            'Product_ID' => $product_id,
                            'Category_ID' => $item
                        );
                        $this->Common_model->add("Products_Category", $arr);
                    }
                }*/

                $this->Common_model->delete('Products_Attribute',array('Product_ID' => $product_id));
                $attribute = $this->input->post('attribute');
                if(isset($attribute) && $attribute != null){
                    foreach ($attribute as $key => $item) {
                        $arr = array(
                            'Product_ID' => $product_id,
                            'Attribute_ID' => $item
                        );
                        $this->Common_model->add("Products_Attribute", $arr);
                    }
                }

                $this->session->set_flashdata('message', '<div class="alert alert-success">Save successfully.</div>');
            }
            redirect('/backend/products/edit/'.$product_id);
        }
        $this->data['category'] = $this->Common_model->get_result('Categories');
        $this->data['attribute'] = $this->Common_model->get_result('Attributes');
        $this->data['category_product'] = $this->Common_model->get_result('Products_Category',array('Product_ID' => $product_id));
        $this->data['attribute_product'] = $this->Common_model->get_result('Products_Attribute',array('Product_ID' => $product_id));
        $this->data['city'] = $this->Common_model->get_record('CountryCity',array('ID' => $this->data['product']['City_ID']));
        $this->load->view($this->backend_asset."/".$this->folder_view."/add",$this->data);
    }
    public function delete($product_id = null){
        $this->data['products'] = $this->Common_model->get_record('Products',array('ID' => $product_id));
        if(!(isset($this->data['products']) && $this->data['products'] != null)){
        	$this->session->set_flashdata('message', '<div class="alert alert-danger">Product Not Found.</div>');
        	redirect('/backend/products');
        }
        $result = $this->Common_model->delete('Products',array('ID' => $product_id));
        if($result){
        	//$this->Common_model->delete('Products_Category',array('Product_ID' => $product_id));
            $this->Common_model->delete('Products_Attribute',array('Product_ID' => $product_id));
        }
        $this->session->set_flashdata('message', '<div class="alert alert-success">Delete successfully.</div>');
    	redirect('/backend/products');
    }
    
}

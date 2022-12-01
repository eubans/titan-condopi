<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Members extends CI_Controller {
	private $is_login = false;
    private $data = array();
    private $user_id = 0;
	public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
        	$this->data['user'] = $this->session->userdata('user_info');
        	if(@$this->data['user']["is_admin"] != 1) redirect(base_url('/home/'));
            $this->data["is_login"] = true;
            $this->user_id = $this->data['user']['id'];
        }
        else{
            redirect(base_url('/home/'));
        }
    }
    public function index(){
        $where  ["1"] = "1";
        if($this->input->get("keyword")){
            $where ["CONCAT(First_Name ,' ',Last_Name) Like"] = "%".$this->input->get("keyword")."%" ;
        }
        if ($this->input->get("status") == "1" || $this->input->get("status") == "0") {
            $where ["Status"]= @$this->input->get("status") ;
        }
        
		$field_sort = 'Create_At';
        if ($this->input->get("field_sort") && in_array($this->input->get("field_sort"),['Create_At','First_Name','Email','Last_Login','Estate_License','QtyListing'])) {
            $field_sort = $this->input->get("field_sort");
        }
        $type_sort = 'DESC';
        if ($this->input->get("type_sort") && in_array($this->input->get("type_sort"),['DESC','ASC'])) {
            $type_sort = $this->input->get("type_sort");
        }
        
        $per_page = ($this->input->get("perpage") != "") ? $this->input->get("perpage") : 20 ;
        $per_page = $per_page == "all" ? 9999999999 : $per_page;
        $per_page = !is_numeric($per_page) ? 20: $per_page;
        $this->data["perpage"] = $per_page;
        
        $count_table =  $this->Common_model->count_table("Members",$where);
        $page_current = ($this->input->get("per_page") != "") ? $this->input->get("per_page") : 0 ;    
        $page_current = ($page_current > 0) ? ($page_current - 1) : $page_current;
        $offset = $per_page * $page_current;
        $this->db->from("Members as tbl1");
        $this->db->select("*,(select count(ID) from Listing where( Member_ID = tbl1.ID)) as QtyListing");
        $this->db->where($where);
        $this->db->order_by($field_sort,$type_sort);
        
        $this->db->limit($per_page,$offset );

        $this->data["table_data"] =  $this->db->get()->result_array();
        $this->load->library('pagination');
        
        $uri = "search=1";
        $arr_uri = $this->input->get();
        if (is_array($arr_uri) && count($arr_uri) > 0) {
        	foreach($arr_uri as $item_key => $item_uri) {
        		if ($item_key != "search" && $item_key != "per_page") {
        			$uri .= "&".$item_key."=".$item_uri;
        		}
        	}
        }
        
        $config['base_url'] = base_url("admin/members")."/?".$uri;
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
        $this->load->view('frontend/block/header',$this->data);
        $this->load->view('frontend/admin/users',$this->data);
        $this->load->view('frontend/block/footer',$this->data);

    }
     
    public function delete($id = 0){
        $this->Common_model->delete("Members",array("ID" => $id));
        redirect(base_url("admin/members/?delete=success"));
    }
    
    public function add() {
        if ($this->input->post()) {
            $this->load->library('form_validation');
	        $this->form_validation->set_rules('first_name', 'First name', 'required|trim');
	        $this->form_validation->set_rules('last_name', 'Last name', 'required|trim');
	        $this->form_validation->set_rules('pwd', 'Password', 'required|trim');
	        $this->form_validation->set_rules('email', 'Email', 'required|trim');
	        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
	        if ($this->form_validation->run() == FALSE) {
	            $this->session->set_flashdata('message', '<div class="alert alert-danger">Please enter all information.</div>');
	        } else {
	            $record = $this->Common_model->get_record("Members", array(
	                'email' => $this->input->post('email')
	            ));
	            if (isset($record) && $record != null) {
	            	$this->session->set_flashdata('message', '<div class="alert alert-danger">Email already exists.</div>');
	            } else {
	            	if (strlen($this->input->post('pwd')) < 6) {
                    	$this->session->set_flashdata('message', '<div class="alert alert-danger">Password must have at least 6 characters.</div>');
                    }
                    else{
                        $token = md5(uniqid());
                    	$arr   = array(
		                    'First_Name' => $this->input->post('first_name'),
		                    'Last_Name' => $this->input->post('last_name'),
		                    'Email' => $this->input->post('email'),
		                    'Address' => '',
		                    'Status' => $this->input->post('Status'),
		                    'Phone' => $this->input->post('phone'),
		                    'Password' => md5($this->input->post('email') . ':' . $this->input->post('pwd')),
                            'Is_Receive'        => $this->input->post('is_receive') == 'on' ? 1 : 0,
                            'Is_Estate_License' => $this->input->post('is_estate_license') == 'on' ? 1 : 0,
                            'Estate_License'    => $this->input->post('is_estate_license') == 'on' ? $this->input->post('estate_license') : '',
                            'Hear_About_Us' => $this->input->post('hear_about_us'),
                            'Token' => $token
		                );
		                $this->Common_model->add("Members", $arr);
		                $this->session->set_flashdata('message', '<div class="alert alert-success">Add successfully.</div>');
		                
		                // SEND MAIL
		                $content_mail = '<p>Welcome to Condo PI.&nbsp; Thank you for joining our community of investors and realtors.</p>
										<p>&nbsp;</p>
										<p>Your account has been set up by our Administrator.</p>
										<p>Logging into <a href="http://www.condopi.com">www.condopi.com</a> is very simple:</p>
										<p>&nbsp;</p>
										<p>Your Login is: '.$this->input->post('email').'</p>
										<p>Your temporary password is: '.$this->input->post('pwd').'</p>
										<p>Please change your password at your convenience.</p>
										<p>&nbsp;</p>
										<p>You now have full access in our website to:</p>
										<p>&nbsp;</p>
										<ul>
										<li>Post New Listings</li>
										<li>Make Offers</li>
										<li>Buy Properties Immediately</li>
										<li>View Free Property Reports</li>
										<li>Message Users</li>
										<li>Save Your Research</li>
										<li>View Private Content</li>
										<li>Get Special Discounts through our Escrow, Title, and Lender Affiliates</li>
										</ul>
										<p>&nbsp;</p>
										<p>We hope that Condo PI will create opportunities for you as an investor or realtor.&nbsp; Please feel free to provide us with feedback to make our platform better and provide you with more value.</p>';
	                    sendmail($this->input->post('email'),"Your new condopi.com account",$content_mail);
		                
		                redirect('admin/members/add/');
                    }
	            }
	        }
        }
        $this->load->view('frontend/block/header',$this->data);
        $this->load->view('frontend/admin/add_user',$this->data);
        $this->load->view('frontend/block/footer',$this->data);
    }
    
    public function edit($id = null){
        $record = $this->Common_model->get_record("Members",array("ID" => $id));
        if($record == null)
            redirect(base_url("/admin/members"));
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('first_name', 'First name', 'required|trim');
            $this->form_validation->set_rules('last_name', 'Last name', 'required|trim');
            //$this->form_validation->set_rules('address', 'Address', 'required|trim');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Please enter all information.</div>');
            } else {
                $emergency_contact = $this->input->post('emergency');
                $shipping_address = $this->input->post('shipping');
                $guest_profiles = $this->input->post('guest');
                $arr = array(
                    'First_Name' => $this->input->post('first_name'),
                    'Last_Name' => $this->input->post('last_name'),
                    'Address' => $this->input->post('address'),
                    'Address2' => $this->input->post('address2'),
                    'Gender' => $this->input->post('gender'),
                    'Phone' => $this->input->post('phone'),
                    'City' => $this->input->post('city'),
                    'Zipcode' => $this->input->post('zipcode'),
                    'State' => $this->input->post('state'),
                    'Is_Receive'        => $this->input->post('is_receive') == 'on' ? 1 : 0,
                    'Is_Estate_License' => $this->input->post('is_estate_license') == 'on' ? 1 : 0,
                    'Estate_License'    => $this->input->post('is_estate_license') == 'on' ? $this->input->post('estate_license') : '',
                    'Real_Estate_Office' => $this->input->post('real_estate_office'),
                    'Location_Default'  => $this->input->post('Location_Default'),
                    'Best_Represents'  => $this->input->post('Best_Represents')
                );
                $password = @$this->input->post('password');
                if($password){
                    if (strlen($password) < 6) {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger">Password must have at least 6 characters.</div>');
                        redirect('admin/members/edit/'.$id);
                    }
                }else{
                    $arr['Password'] = md5($record['Email'] .':'.$password);
                }
                $image = '';
                if (isset($_FILES['heroimage']) && is_uploaded_file($_FILES['heroimage']['tmp_name'])) {
                    $output_dir = FCPATH."/uploads/member/".$id.'/';
                    $output_url = "/uploads/member/".$id.'/';

                    if (!file_exists($output_dir)) {
                        mkdir($output_dir, 0777, true);
                    }
                    $allowed =  array('gif','png' ,'jpg','jpeg');
                    $filename = $_FILES['heroimage']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $ext = strtolower($ext);
                    if(in_array($ext,$allowed)) {
                        $RandomNum    = time();
                        $ImageName    = str_replace(' ', '-', strtolower($_FILES['heroimage']['name']));
                        $ImageType    = $_FILES['heroimage']['type'];
                        $ImageExt     = substr($ImageName, strrpos($ImageName, '.'));
                        $ImageExt     = str_replace('.', '', $ImageExt);
                        $ImageName    = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                        $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                        if (move_uploaded_file($_FILES["heroimage"]["tmp_name"], $output_dir . $NewImageName)) {
                            $image = $output_url.$NewImageName;
                            $arr["Avatar"] = $image;
                        }
                    }
                }
                $this->Common_model->update("Members", $arr,array('ID' => $id));
                $this->session->set_flashdata('message', '<div class="alert alert-success">Save successfully.</div>');
            }
            redirect('admin/members/edit/'.$id);
        }
        $this->data['user'] = $record;
        $this->load->view('frontend/block/header',$this->data);
        $this->load->view('frontend/admin/edit_user',$this->data);
        $this->load->view('frontend/block/footer',$this->data);
    }
}
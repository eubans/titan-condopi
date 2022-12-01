<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	private $is_login = false;
    private $data = array();
    private $user_id = 0;
	public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->data["is_login"] = true;
            $this->data['user'] = $this->session->userdata('user_info');
            $this->user_id = $this->data['user']['id'];
        }
        else{
            redirect(base_url('/home/'));
        }
    }

	public function index()
	{
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('first_name', 'First name', 'required|trim');
            $this->form_validation->set_rules('last_name', 'Last name', 'required|trim');
            $this->form_validation->set_rules('address', 'Address', 'required|trim');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Please enter all information.</div>');
            } else {
                $emergency_contact = $this->input->post('emergency');
                $shipping_address = $this->input->post('shipping');
                $guest_profiles = $this->input->post('guest');
                $arr   = array(
                    'First_Name' => $this->input->post('first_name'),
                    'Last_Name' => $this->input->post('last_name'),
                    'Address' => $this->input->post('address'),
                    'Address2' => $this->input->post('address2'),
                    'Gender' => $this->input->post('gender'),
                    'Phone' => $this->input->post('phone'),
                    'City' => $this->input->post('city'),
                    'Zipcode' => $this->input->post('zipcode'),
                    'State' => $this->input->post('state'),
                    'License_Number' => $this->input->post('license_number'),
                    'Real_Estate_Office' => $this->input->post('real_estate_office'),
                    'Is_Send_Email'     => @$this->input->post("Is_Send_Email") ?  $this->input->post("Is_Send_Email") : 0,
                    'Is_Send_Text'      => @$this->input->post("Is_Send_Text") ?  $this->input->post("Is_Send_Text") : 0,
                    'Location_Default'  => $this->input->post('Location_Default'),
                );
                $image = '';
                if (isset($_FILES['heroimage']) && is_uploaded_file($_FILES['heroimage']['tmp_name'])) {
                    $output_dir = FCPATH."/uploads/member/".$this->user_id.'/';
                    $output_url = "/uploads/member/".$this->user_id.'/';

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
                $this->Common_model->update("Members", $arr,array('ID' => $this->user_id));
                $this->session->set_flashdata('message', '<div class="alert alert-success">Save successfully.</div>');
            }
            redirect('/profile/');
        }
        $this->data['user'] = $this->Common_model->get_record('Members',array('ID' => $this->user_id));
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/admin/index',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
	}

    public function message()
    {
        $count_table =  $this->Common_model->count_table("Notification");
        $page_current = ($this->input->get("per_page") != "") ? $this->input->get("per_page") : 0 ;    
        $per_page = 20;
        $page_current = ($page_current > 0) ? ($page_current - 1) : $page_current;
        $offset = $per_page * $page_current;
        $this->load->library('pagination');
        $config['base_url'] = base_url("/product/");
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

        $this->data['collections'] = $this->Common_model->get_raw('SELECT n.*, nm.IsRead FROM Notification n INNER JOIN Notification_Member nm ON n.ID = nm.Notification_ID WHERE nm.Member_ID = ' . $this->user_id . ' LIMIT ' . $per_page .' OFFSET ' . $offset);
        $this->load->view('frontend/block/header',$this->data);
        $this->load->view('frontend/admin/message',$this->data);
        $this->load->view('frontend/block/footer',$this->data);
    }

    public function viewmsg($id)
    {
        if ($id == null || !is_numeric($id)) {
            redirect('/profile/message');
        }
        // Find message
        $this->data['collections'] = $this->Common_model->get_raw('SELECT n.* FROM Notification n INNER JOIN Notification_Member nm ON n.ID = nm.Notification_ID WHERE nm.Member_ID = ' . $this->user_id . ' AND n.ID = ' . $id);
        if ($this->data['collections'] != null) {
            // Update to status
            $this->Common_model->update('Notification_Member', array('IsRead' => '1', 'Read_Date' => date('Y-m-d H:i:s')), array('Notification_ID' => $id, 'Member_ID' => $this->user_id));
        }

        $this->load->view('frontend/block/header',$this->data);
        $this->load->view('frontend/admin/viewmsg',$this->data);
        $this->load->view('frontend/block/footer',$this->data);
    }

	public function change_password()
	{
		$this->data['user'] = $this->Common_model->get_record('Members',array('ID' => $this->user_id));
        if($this->input->post()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('password', 'Password', 'required|trim');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Please enter all information.</div>');
            } else {
            	$password       = @$this->input->post('password');
                $configpassword = @$this->input->post('confirm_password');
                if (strlen($password) < 6) {
                	$this->session->set_flashdata('message', '<div class="alert alert-danger">Password must have at least 6 characters.</div>');
                } 
                else if ($password != $configpassword) {                    
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Passwords entered do not match.</div>');
                }
                else{
                	$arr   = array(
	                    'Password' => md5($this->data['user']['Email'] .':'.$password)
	                );
	                $this->Common_model->update("Members", $arr,array('ID' => $this->user_id));
	                $this->session->set_flashdata('message', '<div class="alert alert-success">Save successfully.</div>');
                }
            }
            redirect('admin/profile/change_password');
        }
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/admin/change_password',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
	}

    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url('/home/'));
    }

    public function listing() {
        $user_id = $this->user_id;
        $where = "Member_ID = '$user_id'";
        $count_table =  $this->Common_model->count_table("Listing",$where);
        $page_current = ($this->input->get("per_page") != "") ? $this->input->get("per_page") : 0 ;    
        $per_page = 20;
        $page_current = ($page_current > 0) ? ($page_current - 1) : $page_current;
        $offset = $per_page * $page_current;
        
        $sql = "SELECT l.*, le.Extend_Date, (datediff(le.Extend_Date, now()) + 7) AS DayLeft 
                    FROM Listing AS l INNER JOIN Listing_Extend AS le ON l.ID = le.Listing_ID 
                    WHERE 
                        Member_ID = '{$user_id}' AND le.Status = '1'
                    LIMIT
                        {$offset},{$per_page}";

        $this->data["collections"] = $this->Common_model->query_raw($sql);
        $this->load->library('pagination');
        $config['base_url'] = base_url("/profile/listing/");
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
        $this->load->view('frontend/admin/listing',$this->data);
        $this->load->view('frontend/block/footer',$this->data);
    }
    public function extendlisting($listing_id = null){
    	$date = date('Y-m-d', strtotime("-7 days"));
    	$sql = "SELECT *
    			FROM Listing AS l
    			INNER JOIN Listing_Extend AS le ON l.id = le.Listing_ID 
    			WHERE l.id = '$listing_id' AND le.Status = '1' AND le.Extend_Date < '$date' ";
    	$result = $this->Common_model->query_raw_row($sql);
    	if(isset($result) && $result != null){
    		$arr = array(
    			'Status' => 0
    		);
    		$this->Common_model->update('Listing_Extend',$arr,array('Listing_ID' => $listing_id));
    		$arr = array(
    			'Status' => 1,
    			'Listing_ID' => $listing_id,
    			'Extend_Date' => date('Y-m-d H:i:s')
    		);
    		$this->Common_model->add('Listing_Extend',$arr);
			$this->session->set_flashdata('message', '<div class="alert alert-success">Save successfully.</div>');
    	}
    	redirect('/admin/listings');
    }

    public function expiredlisting(){
    	$date = date('Y-m-d', strtotime("-7 days"));
    	$sql = "SELECT l.*,m.Email
    			FROM Listing AS l
    			INNER JOIN Members AS m ON m.id = l.Member_ID 
    			INNER JOIN Listing_Extend AS le ON l.id = le.Listing_ID 
    			WHERE le.Status = '1' AND le.Extend_Date < '$date' 
    			GROUP BY l.ID";
    	$result = $this->Common_model->query_raw($sql);
    	echo count($result);
    	if(isset($result) && $result != null){
    		foreach ($result as $key => $item) {
    			 /*$message = "Hi " . $name . ",<br/><br/>
		                    You have requested to reset the password for your CouchStay account.<br/>
		                    To reset your password at CouchStay, click the link below:<br/>
		                    <a href='" . base_url() . "?reset=reset&email=" . $email . "&token=" . $token . "'>" . base_url() . "?reset=reset&email=" . $email . "&token=" . $token . "</a><br/>
		                    If clicking the link above doesn't work, please copy it into a new browser window.<br/><br/>
		                    If you did not attempt to reset your password, or if you have already managed to retrieve your password, you can ignore this message and continue using CouchStay with your current password.";
			        $replace = array("[%firstname%]", "[%link%]");
			        $replace_with = array('', '');
			        $sentdata = str_replace($replace, $replace_with, $message);
			        $msg = $this->load->view('frontend/block/emailtemplate', array('content' => htmlspecialchars_decode($sentdata)), true);
			        
			        $to = $item['Email'];
			        $subject = "Extend Listing";
			        sendmail($to, $subject, $msg);*/
    		}
    	}
    }

    

    public function editlisting($listing_id = null) {
        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("Listing", array('ID' => $listing_id,'Member_ID' => $user_id));
        if(!(isset($record) && $record != null)){
            redirect('/profile/addlisting');
        }
        if ($this->input->post()) {
            $this->load->library('form_validation');
            // $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('summary', 'Summary', 'required|trim');
            // $this->form_validation->set_rules('detail', 'Detail', 'required|trim');
            $this->form_validation->set_rules('address', 'Address', 'required|trim');
            $this->form_validation->set_rules('city', 'City', 'required|trim');
            $this->form_validation->set_rules('state', 'State', 'required|trim');
            $this->form_validation->set_rules('country', 'Country', 'required|trim');
            $this->form_validation->set_rules('price', 'Price', 'required|trim');
            // $this->form_validation->set_rules('heroimage', 'HeroImage', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">'.validation_errors().'</div>');
            } else {
                $image = @$record['HeroImage'];
                if (isset($_FILES['heroimage']) && is_uploaded_file($_FILES['heroimage']['tmp_name'])) {
                    $output_dir = FCPATH."/uploads/member/".$this->user_id.'/';
                    $output_url = "/uploads/member/".$this->user_id.'/';

                    if (!file_exists($output_dir)) {
                        mkdir($output_dir, 0777, true);
                    }

                    $allowed =  array('gif','png' ,'jpg','jpeg');
                    $filename = $_FILES['heroimage']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $ext = strtolower($ext);
                    if (in_array($ext,$allowed)) {
                        $RandomNum    = time();
                        $ImageName    = str_replace(' ', '-', strtolower($_FILES['heroimage']['name']));
                        $ImageType    = $_FILES['heroimage']['type'];
                        $ImageExt     = substr($ImageName, strrpos($ImageName, '.'));
                        $ImageExt     = str_replace('.', '', $ImageExt);
                        $ImageName    = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                        $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                        if (move_uploaded_file($_FILES["heroimage"]["tmp_name"], $output_dir . $NewImageName)){
                            $image = $output_url.$NewImageName;
                        }
                    }
                }

                $gallery = $this->input->post('gallery');
                $slideImage = json_decode(@$record['SlideImage'],true);
                if (isset($slideImage) && $slideImage != null) {
                    foreach ($slideImage as $key => $item) {
                        if(isset($gallery) && is_array($gallery) && !in_array($item, $gallery)){
                            @unlink(FCPATH.$item);
                        }
                    }
                }
                if (isset($_FILES['upload_file'])) {
                    $this->load->library('upload');
                    $files = $_FILES;
                    $cpt = count($_FILES['upload_file']['name']);
                    for($i=0; $i < $cpt; $i++)
                    {           
                        $_FILES['files']['name']= $files['upload_file']['name'][$i];
                        $_FILES['files']['type']= $files['upload_file']['type'][$i];
                        $_FILES['files']['tmp_name']= $files['upload_file']['tmp_name'][$i];
                        $_FILES['files']['error']= $files['upload_file']['error'][$i];
                        $_FILES['files']['size']= $files['upload_file']['size'][$i];    

                        $output_dir = FCPATH."/uploads/gallery/".$this->user_id.'/';
                        $output_url = "/uploads/gallery/".$this->user_id.'/';

                        if (!file_exists($output_dir)) {
                            mkdir($output_dir, 0777, true);
                        }

                        $allowed =  array('gif','png' ,'jpg','jpeg');
                        $filename = $_FILES['files']['name'];
                        $ext = pathinfo($filename, PATHINFO_EXTENSION);
                        $ext = strtolower($ext);
                        if(in_array($ext,$allowed)) {
                            $RandomNum    = time();
                            $ImageName    = str_replace(' ', '-', strtolower($_FILES['files']['name']));
                            $ImageType    = $_FILES['files']['type'];
                            $ImageExt     = substr($ImageName, strrpos($ImageName, '.'));
                            $ImageExt     = str_replace('.', '', $ImageExt);
                            $ImageName    = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                            $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                            if (move_uploaded_file($_FILES["files"]["tmp_name"], $output_dir . $NewImageName)){
                                $gallery[] = $output_url.$NewImageName;
                            }
                        }
                    }
                }

                $commission = $this->input->post('commission');
                if (!is_numeric($commission) || $commission > 100) {
                    $commission = 0;
                }
                $arr  = array(
                    'Name'              => $this->input->post('address'),
                    'Summary'           => $this->input->post('summary'),
                    'Price'             => $this->input->post('price'),
                    'Commission'        => $commission,
                    'Escrow_Company'    => $this->input->post('Escrow_Company'),
                    'Insurance_Company' => $this->input->post('Insurance_Company'),
                    'Detail'            => $this->input->post('detail'),
                    'Rates'             => '',
                    'SlideImage'        => json_encode($gallery),
                    'HeroImage'         => $image,
                    'Address2'          => $this->input->post('address2'),
                    'Address'           => $this->input->post('address'),
                    'City'              => $this->input->post('city'),
                    'State'             => $this->input->post('state'),
                    'Zipcode'           => $this->input->post('zipcode'),
                    'Country'              => $this->input->post('country'),
                    'Showing_Instructions' => $this->input->post('Showing_Instructions'),
                    'Allow_Commission'     => @$this->input->post('Allow_Commission') ? $this->input->post('Allow_Commission') : 0,

                );
                $result = $this->Common_model->update("Listing", $arr,array('ID' => $listing_id,'Member_ID' => $user_id));
                if ($result) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success">Save successfully.</div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Error!.</div>');
                }
            }
            redirect('/admin/listings/editlisting/'.$listing_id);
        }
        $this->data['product'] = $record;
        $this->data['title'] = 'Edit Listing';
        $this->load->view('frontend/block/header',$this->data);
        $this->load->view('frontend/admin/editlisting',$this->data);
        $this->load->view('frontend/block/footer',$this->data);
    }

    public function dellisting($listing_id = null) {
        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("Listing", array('ID' => $listing_id,'Member_ID' => $user_id));
        if(!(isset($record) && $record != null)){
            redirect('/admin/listings');
        }
        $result = $this->Common_model->delete("Listing", array('ID' => $listing_id,'Member_ID' => $user_id));
        if($result){
        	if(isset($record['HeroImage']) && $record['HeroImage'] != null){
	        	 @unlink(FCPATH.$record['HeroImage']);
	        }
	        $slideImage = json_decode(@$record['SlideImage'],true);
	        if(isset($slideImage) && $slideImage != null){
	            foreach ($slideImage as $key => $item) {
	                if(isset($item) && $item != null){
	                    @unlink(FCPATH.$item);
	                }
	            }
	        }
	        $this->session->set_flashdata('message', '<div class="alert alert-success">Delete successfully.</div>');
        }
        redirect('/admin/listings');
    }
    public function WebSetting(){
        $allowSetting = [
            "Name",
            "Contact",
            "Address",
            "Phone",
            "Email",
            "Escrow",
            "Title",
            "Email_Test",
            "Email_Receive_Buy",
            "BODY_JSON"
        ];
        $this->db->from("Web_Setting");
        $this->db->where_in("IKEY", $allowSetting);
        $this->data["Setting"] = $this->db->get()->result_array();
        if($this->input->post()){
            foreach ($this->input->post() as $key => $value) {
            	if (is_array($value)) {
                	$this->Common_model->update("Web_Setting",["Body_Json" => json_encode($value)],["IKEY" => $key]);
                } else {
                	$this->Common_model->update("Web_Setting",["Body_Json" => $value],["IKEY" => $key]);
                }
            }
            redirect('/admin/profile/websetting');
        }
        $this->load->view('frontend/block/header',$this->data);
        $this->load->view('frontend/admin/websetting',$this->data);
        $this->load->view('frontend/block/footer',$this->data);
    }
    
    public function send_mail_client() {
    	if ($this->input->post() && $this->input->post("email")) {
    		$email = $this->input->post("email");
            $subject = $this->input->post("subject");
            $message = $this->input->post("message");
            $message = str_replace("\r\n",'<br>', $message);
            sendmail($email,$subject,$message);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Sent successfully.</div>');
            redirect('/admin/profile/send_mail_client');
        }
        $this->load->view('frontend/block/header',$this->data);
        $this->load->view('frontend/admin/send_mail_client',$this->data);
        $this->load->view('frontend/block/footer',$this->data);
    }
    
    public function msg_management () {
    	$count_table =  $this->Common_model->count_table("Message_Seller");
        $page_current = ($this->input->get("per_page") != "") ? $this->input->get("per_page") : 0 ;    
        $per_page = 20;
        $page_current = ($page_current > 0) ? ($page_current - 1) : $page_current;
        $offset = $per_page * $page_current;
        
        $this->load->library('pagination');
        $config['base_url'] = base_url("admin/profile/msg_management/");
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
    	
    	$this->data['collections'] = $this->Common_model->get_raw("SELECT ms.*, m.Email as EmailTo FROM Message_Seller ms LEFT JOIN Listing l ON l.ID = ms.Listing_ID
    															LEFT JOIN Members m ON m.ID = l.Member_ID ORDER BY ms.ID DESC LIMIT  {$offset},{$per_page} ");
    	$this->load->view('frontend/block/header',$this->data);
        $this->load->view('frontend/admin/msg_management',$this->data);
        $this->load->view('frontend/block/footer',$this->data);
    }
    
    public function del_msg($id = null) {
        $this->Common_model->delete("Message_Seller", array('ID' => $id));
        $this->session->set_flashdata('message', '<div class="alert alert-success">Deleted successfully.</div>');
        redirect('/admin/profile/msg_management');
    }
    
    public function send_msg($id = null) {
    	$message_seller = $this->Common_model->query_raw_row("SELECT ms.*, m.Email as EmailTo FROM Message_Seller ms LEFT JOIN Listing l ON l.ID = ms.Listing_ID
    															LEFT JOIN Members m ON m.ID = l.Member_ID WHERE ms.ID='{$id}' ");
    	if ($message_seller != null && isset($message_seller['ID'])) {
    		// Update Is_Send
    		$this->Common_model->update("Message_Seller", ['Is_Send' => 1], array('ID' => $message_seller['ID']));
    		
    		$email_from = $message_seller["Email"];
    		$email_to = $message_seller["EmailTo"];
    		$email_to = empty($email_to) ? 'admin@condopi.com' : $email_to;
            $subject = $message_seller["Subject"];
            $message = $message_seller["Message"];
            $message = str_replace("\r\n",'<br>', $message);
            sendmail_from($email_from,$message_seller["Full_Name"],$email_to,$subject,$message);
            $this->session->set_flashdata('message', '<div class="alert alert-success">Sent successfully.</div>');
        }
        redirect('/admin/profile/msg_management');
    }
}

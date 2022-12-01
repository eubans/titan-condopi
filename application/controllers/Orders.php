<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Orders extends CI_Controller {

	private $is_login = false;
    private $data = array();
    private $plan = 'plan_G9xnVh5MsNo2aE';// 'plan_Fshw9RYDVdFplu';
    private $mailchimp_list_id = "cbe5bd92e7";
    
	public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->data["is_login"] = true;
            $this->data['user'] = $this->session->userdata('user_info');
            $this->user_id = $this->data['user']['id'];
            $this->data['member_expiry'] = $this->Common_model->get_record('Member_Expiry',array('Member_ID' => $this->user_id));
        }
        $this->load->library('stripe_lib'); 
        $this->load->helper(array('url','form'));
        $this->load->model('Common_model'); 
    }
    public function prime(){
        $this->data["is_show_search"] = 0;
    
    	$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/home/prime',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
    }
    public function primeBilling(){
        if(!isset($this->data["is_login"])){
            redirect('/'); 
        }
        $user_info = $this->session->userdata('user_info');
        $where = array('Member_ID'=>$user_info['id']);
        $this->data['Member_Card'] = $this->Common_model->get_record('Member_Card',$where); 
        $this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/home/prime-billing',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
    }
    
    function submitBilling(){ 
        $data = array();
        if($this->input->post('stripeToken')){
            // Retrieve stripe token, card and user info from the submitted form data 
            $postData = $this->input->post(); 
            $postData['price'] = 50;
            $paymentID = $this->payment($postData); 
            if($paymentID){
                redirect('billing/payment_status/'.$paymentID); 
            }else{ 
                $apiError = !empty($this->stripe_lib->api_error)?' ('.$this->stripe_lib->api_error.')':''; 
                $data['error_msg'] = 'Transaction has been failed!'.$apiError; 
            }
        } 
    } 
    function submitBillingAuto(){
        if($this->input->post()){
            $postData = $this->input->post(); 
            $postData['price'] = 50;
            $user_info = $this->session->userdata('user_info');
            $where = array('Member_ID'=>$user_info['id']);
            $Member_Card = $this->Common_model->get_record('Member_Card',$where);
            
            if($Member_Card){
                $customer_id = $Member_Card['Customer_Id'];
                $plan =  $this->plan;
                
                if($customer_id){
                    $charge = $this->stripe_lib->createSubscription($customer_id, $plan);
                    if($charge){ 
                        
                        // Check whether the charge is successful 
                        if(($charge['object'] == 'subscription') && ($charge['status'] == 'active')){
                            // Transaction details  
                            //$transactionID = $charge['balance_transaction']; 
                            $transactionID = $charge['id'];
                            $paidAmount = $charge['plan']['amount']; 
                            $paidAmount = ($paidAmount/100); 
                            $paidCurrency = $charge['plan']['currency']; 
                            $payment_status = $charge['status']; 
                             
                            // Insert tansaction data into the database 
                            $time = strtotime("now");
                            $final = date("Y-m-d", strtotime("+1 month", $time));
                            
                            
                            $time = strtotime("now");
                            $orderData = array( 
                                'Member_ID' => $user_info['id'], 
                                'Payment_Date' => date("Y-m-d H:i:s"), 
                                'Status' => 1,
                                'Stripe_Info' => $plan, 
                            ); 
                            $orderID = $this->Common_model->add('Payment_History',$orderData); 
                            $final = date("Y-m-d", strtotime("+1 month", $time));
                            $where = array('Member_ID'=>$user_info['id']);
                            $Member_Expiry = $this->Common_model->get_record('Member_Expiry',$where);
                            if($Member_Expiry){
                                $orderData = array(
                                    'Member_ID' => $user_info['id'], 
                                    'Expiry_Date' => $final, 
                                    //'CreatedAt' => date("Y-m-d"),
                                ); 
                                $whereUpdate = array('Member_ID'=>$user_info['id']);
                                $orderID = $this->Common_model->update('Member_Expiry',$orderData,$whereUpdate);
                            }else{
                                $orderData = array(
                                    'Member_ID' => $user_info['id'], 
                                    'Expiry_Date' => $final, 
                                    'CreatedAt' => date("Y-m-d H:i:s"),
                                ); 
                                $orderID = $this->Common_model->add('Member_Expiry',$orderData);  
                            }
                             
                            // If the order is successful 
                            if($orderID){ 
                                redirect('billing/payment_status/'.$orderID); 
                            } 
                        } 
                    }
                }
                
            }
        }
    }
    function payment($postData){ 
        $user_info = $this->session->userdata('user_info');
        if(!empty($postData)){ 
            // Retrieve stripe token, card and user info from the submitted form data 
            $token  = $postData['stripeToken']; 
            $name = $postData['cardholder_name']; 
            $email = $user_info['email']; 
            $card_number = $postData['card_number']; 
            $card_number = preg_replace('/\s+/', '', $card_number); 
            $card_exp_month = $postData['card_exp_month']; 
            $card_exp_year = $postData['card_exp_year']; 
            $card_cvc = $postData['card_cvc']; 
             
            // Unique order ID 
            $orderID = strtoupper(str_replace('.','',uniqid('', true))); 
             
            // Add customer to stripe
            $where = array('Member_ID'=>$user_info['id']);
            //$Member_Card = $this->Common_model->get_record('Member_Card',$where);
            $Card_Number_new = '';
            //if($Member_Card){
                //$customer_id = $Member_Card['Customer_Id'];
                //$Card_Number_new = $Member_Card['Card_Number'];
            //}else{
                $customer = $this->stripe_lib->addCustomer($email, $token);
                $customer_id = $customer->id;
            //}
             
             
            if($customer_id){
                $plan =  $this->plan;
                
                // Charge a credit or a debit card 
                //$charge = $this->stripe_lib->createCharge($customer->id, 'Prime', $postData['price'], $orderID); 
                $charge = $this->stripe_lib->createSubscription($customer_id, $plan); 
                
                if($charge){ 
                    
                    // Check whether the charge is successful 
                    if(($charge['object'] == 'subscription') && ($charge['status'] == 'active')){
                        // Transaction details  
                        //$transactionID = $charge['balance_transaction']; 
                        $transactionID = $charge['id'];
                        $paidAmount = $charge['plan']['amount']; 
                        $paidAmount = ($paidAmount/100); 
                        $paidCurrency = $charge['plan']['currency']; 
                        $payment_status = $charge['status']; 
                         
                        // Insert tansaction data into the database 
                        $time = strtotime("now");
                        $final = date("Y-m-d", strtotime("+1 month", $time));
                        
                        $save_credit_info = $postData['save_credit_info'];
                        
                        if($save_credit_info == 'on'){
                            $Card_Number = substr($card_number,-4);
                            if($Card_Number_new != $Card_Number){
                                $orderData = array( 
                                    'Member_ID' => $user_info['id'], 
                                    'Expiry_Month' => $card_exp_month, 
                                    'Expiry_Year' => $card_exp_year, 
                                    'Owner_Name' => $postData['cardholder_name'],
                                    'Card_Type' => $postData['card_type'],
                                    'Card_Number' => substr($card_number,-4),
                                    'Customer_Id' => $customer_id,
                                    'Address' => $postData['address'], 
                                    'Address_2' => $postData['address_2'], 
                                    'City' => $postData['city'], 
                                    'State' => $postData['state'], 
                                    'Zip_Code' => $postData['zip_code'], 
                                    'Promo_Code' => $postData['promo_code'],
                                    'Card_CVC' => $postData['card_cvc'],
                                    'TransactionID' => $transactionID,
                                    'Stripe_Return_Key' => $plan,
                                    'CreatedAt' => date("Y-m-d H:i:s"), 
                                ); 
                                $orderID = $this->Common_model->add('Member_Card',$orderData);
                            }else{
                                $orderData = array( 
                                    'Member_ID' => $user_info['id'], 
                                    'Expiry_Month' => $card_exp_month, 
                                    'Expiry_Year' => $card_exp_year, 
                                    'Owner_Name' => $postData['cardholder_name'],
                                    'Card_Type' => $postData['card_type'],
                                    'Card_Number' => substr($card_number,-4),
                                    'Customer_Id' => $customer_id,
                                    'Address' => $postData['address'], 
                                    'Address_2' => $postData['address_2'], 
                                    'City' => $postData['city'], 
                                    'State' => $postData['state'], 
                                    'Zip_Code' => $postData['zip_code'], 
                                    'Promo_Code' => $postData['promo_code'],
                                    'Card_CVC' => $postData['card_cvc'],
                                    'TransactionID' => $transactionID,
                                    'Stripe_Return_Key' => $plan,
                                    'UpdateAt' => date("Y-m-d H:i:s"), 
                                ); 
                                $whereUpdate = array('Member_ID'=>$user_info['id']);
                                $orderID = $this->Common_model->update('Member_Card',$orderData,$whereUpdate);
                            }
                        }
                        $time = strtotime("now");
                        $orderData = array( 
                            'Member_ID' => $user_info['id'], 
                            'Payment_Date' => date("Y-m-d H:i:s"), 
                            'Status' => 1,
                            'Stripe_Info' => $plan, 
                        ); 
                        $orderID = $this->Common_model->add('Payment_History',$orderData); 
                        $final = date("Y-m-d", strtotime("+1 month", $time));
                        
                        $where = array('Member_ID'=>$user_info['id']);
                        $Member_Expiry = $this->Common_model->get_record('Member_Expiry',$where);
                        if($Member_Expiry){
                            $orderData = array(
                                'Member_ID' => $user_info['id'], 
                                'Expiry_Date' => $final, 
                                //'CreatedAt' => date("Y-m-d"),
                            ); 
                            $whereUpdate = array('Member_ID'=>$user_info['id']);
                            $orderID = $this->Common_model->update('Member_Expiry',$orderData,$whereUpdate);
                        }else{
                            $orderData = array(
                                'Member_ID' => $user_info['id'], 
                                'Expiry_Date' => $final, 
                                'CreatedAt' => date("Y-m-d H:i:s"),
                            ); 
                            $orderID = $this->Common_model->add('Member_Expiry',$orderData);  
                        }
                        // If the order is successful 
                        if($orderID){ 
                            return $orderID; 
                        } 
                    } 
                }
            } 
        } 
        return false; 
    }
    function payment_status($id){ 
        $data = array(); 
        $user_info = $this->session->userdata('user_info');
        $where = array('Member_ID'=>$user_info['id']);
        $data['member_subscription_current'] = $this->Common_model->get_record('Member_Expiry',$where); 
        
        $this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/home/payment-status', $data); 
		$this->load->view('frontend/block/footer',$this->data);
        
    }
    function checkplancustomer(){
        $where = array('Expiry_Date <'=>date("Y-m-d"));
        $member_expirys = $this->Common_model->get_result('Member_Expiry',$where); 
        foreach($member_expirys as $member_expiry){
            $where = array('Member_ID'=>$member_expiry['Member_ID']);
            $Member_Card = $this->Common_model->get_record('Member_Card',$where); 
            $sub  =  $Member_Card['TransactionID'];
            $charge = $this->stripe_lib->retrieveSubscription($sub);
            if($charge['status'] == 'active'){
                $orderData = array(
                    'Member_ID' => $member_expiry['Member_ID'], 
                    'Expiry_Date' => date("Y-m-d",$charge['current_period_end']), 
                ); 
                $whereUpdate = array('Member_ID'=>$member_expiry['Member_ID']);
                $orderID = $this->Common_model->update('Member_Expiry',$orderData,$whereUpdate);
            }
        }
    }
    function cancelplancustomer(){
        $sub  =  'sub_FsU4kz3MOe51Hs';
        $charge = $this->stripe_lib->retrieveSubscription($sub);
        var_dump($charge);
    }
    function billing(){
        $user_info = $this->session->userdata('user_info');
        $listing_sessions = $data["listing_sessions"] = $this->session->userdata('listing_sessions');
        $total_money = 0;
        foreach($listing_sessions as $listing_session){
            $total_money = $total_money + $listing_session["total_money"];
        }
        if(!isset($this->data["is_login"])){
            redirect('/'); 
        }
        $where = array('Member_ID'=>$user_info['id']);
        $this->data['Member_Card'] = $this->Common_model->get_record('Member_Card',$where); 
        
        $data["total_money"] = $total_money;
        $this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/home/billing', $data); 
		$this->load->view('frontend/block/footer',$this->data);
    }
    function submit_billing_ads(){
        $data = array();
        if($this->input->post('stripeToken')){
            // Retrieve stripe token, card and user info from the submitted form data 
            $this->load->library('form_validation');
            $this->form_validation->set_rules('amount', 'Amount', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">Please enter all information.</div>');
            }
            $postData = $this->input->post(); 
            $total_money = 0;
            $listing_sessions = $this->session->userdata('listing_sessions');
            foreach($listing_sessions as $listing_session){
                $total_money = $total_money + $listing_session["total_money"];
            }
            $postData['amount'] = $total_money;
            $paymentID = $this->payment_ads($postData); 
            if($paymentID){
                redirect('billing/payment_ads_status/'.$paymentID); 
            }else{ 
                $apiError = !empty($this->stripe_lib->api_error)?' ('.$this->stripe_lib->api_error.')':''; 
                $data['error_msg'] = 'Transaction has been failed!'.$apiError; 
            }
        } 
    }
    function payment_ads($postData){
        $user_info = $this->session->userdata('user_info');
        if(!empty($postData)){
            // Retrieve stripe token, card and user info from the submitted form data 
            $token  = $postData['stripeToken']; 
            $name = $postData['cardholder_name']; 
            $email = $user_info['email']; 
            $card_number = $postData['card_number']; 
            $card_number = preg_replace('/\s+/', '', $card_number); 
            $card_exp_month = $postData['card_exp_month']; 
            $card_exp_year = $postData['card_exp_year']; 
            $card_cvc = $postData['card_cvc']; 
            $amount = $postData['amount'];
            // Unique order ID 
            $orderID = strtoupper(str_replace('.','',uniqid('', true))); 
             
            $customer = $this->stripe_lib->addCustomer($email, $token);
            $customer_id = $customer->id;
            //}
            if($customer_id){
                
                // Charge a credit or a debit card 
                $charge = $this->stripe_lib->createCharge($customer->id, 'Payment for Ads', $amount, $orderID); 
                if($charge){ 
                    
                    // Check whether the charge is successful 
                    if(($charge['object'] == 'charge') && ($charge['status'] == 'succeeded')){
                        // Transaction details  
                        //$transactionID = $charge['balance_transaction']; 
                        $transactionID = $charge['id'];
                        $paidAmount = $charge['amount']; 
                        $paidAmount = ($paidAmount/100); 
                        $paidCurrency = ['currency']; 
                        $payment_status = $charge['status']; 
                        $Stripe_Return_Key = $charge['id']; 
                        // Insert tansaction data into the database 
                        $time = strtotime("now");
                        $final = date("Y-m-d", strtotime("+1 month", $time));
                        
                        //$save_credit_info = $postData['save_credit_info'];
                        
                        $orderData = array( 
                            'Member_ID' => $user_info['id'], 
                            'Payment_Date' => date("Y-m-d H:i:s"), 
                            'Status' => 1,
                            'Stripe_Info' => $transactionID, 
                        ); 
                        $orderID = $this->Common_model->add('Payment_History',$orderData); 
                        
                        //if($save_credit_info == 'on'){
                        $Card_Number = substr($card_number,-4);
                        $where = array('Member_ID'=>$user_info['id']);
                        $data = $this->Common_model->get_record('Member_Card',$where);
                        $Card_Number_new = "";
                        if($data){
                            $Card_Number_new = $data['Card_Number'];
                        }
                        if($Card_Number_new != $Card_Number){
                            $orderData = array(
                                'Member_ID' => $user_info['id'], 
                                'Expiry_Month' => $card_exp_month, 
                                'Expiry_Year' => $card_exp_year, 
                                'Owner_Name' => $postData['cardholder_name'],
                                'Card_Type' => $postData['card_type'],
                                'Card_Number' => substr($card_number,-4),
                                'Customer_Id' => $customer_id,
                                'Address' => $postData['address'], 
                                'Address_2' => $postData['address_2'], 
                                'City' => $postData['city'], 
                                'State' => $postData['state'], 
                                'Zip_Code' => $postData['zip_code'], 
                                'Promo_Code' => $postData['promo_code'],
                                'Card_CVC' => $postData['card_cvc'],
                                'TransactionID' => $transactionID,
                                'Stripe_Return_Key' => $Stripe_Return_Key,
                                'CreatedAt' => date("Y-m-d H:i:s"), 
                            ); 
                            $orderID = $this->Common_model->add('Member_Card',$orderData);
                        }else{
                            $orderData = array( 
                                'Member_ID' => $user_info['id'], 
                                'Expiry_Month' => $card_exp_month, 
                                'Expiry_Year' => $card_exp_year, 
                                'Owner_Name' => $postData['cardholder_name'],
                                'Card_Type' => $postData['card_type'],
                                'Card_Number' => substr($card_number,-4),
                                'Customer_Id' => $customer_id,
                                'Address' => $postData['address'], 
                                'Address_2' => $postData['address_2'], 
                                'City' => $postData['city'], 
                                'State' => $postData['state'], 
                                'Zip_Code' => $postData['zip_code'], 
                                'Promo_Code' => $postData['promo_code'],
                                'Card_CVC' => $postData['card_cvc'],
                                'TransactionID' => $transactionID,
                                'Stripe_Return_Key' => $Stripe_Return_Key,
                                'UpdateAt' => date("Y-m-d H:i:s"), 
                            ); 
                            $whereUpdate = array('Member_ID'=>$user_info['id']);
                            $orderID = $this->Common_model->update('Member_Card',$orderData,$whereUpdate);
                            $where = array('Member_ID'=>$user_info['id']);
                            $data = $this->Common_model->get_record('Member_Card',$where); 
                            $orderID = $data['ID'];
                        }
                        //}
                        
                        
                        $orderData = array(
                            'Member_ID' => $user_info['id'], 
                            'member_card_id' => $orderID, 
                            'amount' => $amount, 
                            'transaction_type' => "Purchase",
                            'datetime' => date("Y-m-d H:i:s"),
                        ); 
                        $orderID_receipt = $this->Common_model->add('receipt_payment',$orderData);
                        
                        $listing_sessions = $this->session->userdata('listing_sessions');
                        foreach($listing_sessions as $listing_session){
                            if($listing_session["blast_number_one"] || $listing_session["blast_number_two"] || $listing_session["blast_number_three"]){
                                $orderData = array(
                                    'listing_id' => $listing_session['listing_id'], 
                                    'Member_ID' => $user_info['id'],
                                    'receipt_payment_id' => $orderID_receipt, 
                                    'blast_number_one' => $listing_session["blast_number_one"],
                                    'blast_number_two' => $listing_session["blast_number_two"],
                                    'blast_number_three' => $listing_session["blast_number_three"],
                                    'total_money' => $listing_session["total_money"],
                                    'created_at' => date("Y-m-d H:i:s"),
                                ); 
                                $active_listing_ad_id = $this->Common_model->add('active_listing_ads',$orderData);
                            }
                            
                        }
                        
                        
                        if($orderID_receipt){
                            return $orderID_receipt; 
                        }
                    } 
                }
            }
        } 
        return false; 
    }
    function submitBillinAdsgAuto(){
        if($this->input->post()){
            $postData = $this->input->post(); 
            $postData['price'] = 50;
            $user_info = $this->session->userdata('user_info');
            $where = array('Member_ID'=>$user_info['id']);
            $Member_Card = $this->Common_model->get_record('Member_Card',$where);
            
            if($Member_Card){
                $customer_id = $Member_Card['Customer_Id'];
                $orderID = strtoupper(str_replace('.','',uniqid('', true))); 
                if($customer_id){
                    $postData = $this->input->post(); 
                    $total_money = 0;
                    $listing_sessions = $this->session->userdata('listing_sessions');
                    foreach($listing_sessions as $listing_session){
                        $total_money = $total_money + $listing_session["total_money"];
                    }
                    $amount = $postData['amount'] = $total_money;
                    // Charge a credit or a debit card 
                    $charge = $this->stripe_lib->createCharge($customer_id, 'Payment for Ads', $amount, $orderID); 
                    if($charge){ 
                        
                        // Check whether the charge is successful 
                        if(($charge['object'] == 'charge') && ($charge['status'] == 'succeeded')){
                            // Transaction details  
                            //$transactionID = $charge['balance_transaction']; 
                            $transactionID = $charge['id'];
                            $paidAmount = $charge['amount']; 
                            $paidAmount = ($paidAmount/100); 
                            $paidCurrency = ['currency']; 
                            $payment_status = $charge['status']; 
                            $Stripe_Return_Key = $charge['id']; 
                            // Insert tansaction data into the database 
                            $time = strtotime("now");
                            $final = date("Y-m-d", strtotime("+1 month", $time));
                            
                            //$save_credit_info = $postData['save_credit_info'];
                            
                            $orderData = array( 
                                'Member_ID' => $user_info['id'], 
                                'Payment_Date' => date("Y-m-d H:i:s"), 
                                'Status' => 1,
                                'Stripe_Info' => $transactionID, 
                            ); 
                            $orderID = $this->Common_model->add('Payment_History',$orderData); 
                            
                            $orderID = $Member_Card["ID"];
                            $orderData = array(
                                'Member_ID' => $user_info['id'], 
                                'member_card_id' => $orderID, 
                                'amount' => $amount, 
                                'transaction_type' => "Purchase",
                                'datetime' => date("Y-m-d H:i:s"),
                            ); 
                            $orderID_receipt = $this->Common_model->add('receipt_payment',$orderData);
                            
                            $listing_sessions = $this->session->userdata('listing_sessions');
                            foreach($listing_sessions as $listing_session){
                                if($listing_session["blast_number_one"] || $listing_session["blast_number_two"] || $listing_session["blast_number_three"]){
                                    $orderData = array(
                                        'listing_id' => $listing_session['listing_id'], 
                                        'Member_ID' => $user_info['id'],
                                        'receipt_payment_id' => $orderID_receipt, 
                                        'blast_number_one' => $listing_session["blast_number_one"],
                                        'blast_number_two' => $listing_session["blast_number_two"],
                                        'blast_number_three' => $listing_session["blast_number_three"],
                                        'total_money' => $listing_session["total_money"],
                                        'created_at' => date("Y-m-d H:i:s"),
                                    ); 
                                    $active_listing_ad_id = $this->Common_model->add('active_listing_ads',$orderData);
                                }
                            }
                            if($orderID_receipt){
                                redirect('billing/payment_ads_status/'.$orderID_receipt);
                            }
                        } 
                    }
                }
                
            }
        }
    }
    function payment_ads_status($orderID_receipt){
        $listing_sessions = $this->session->userdata('listing_sessions');
        if($listing_sessions){
            //$this->session->unset_userdata('listing_sessions');
            $data = array(); 
            $user_info = $this->session->userdata('user_info');
            $where = array('Member_ID'=>$user_info['id']);
            $data['receipt_payment'] = $this->Common_model->get_record('receipt_payment',$where); 
            $where = array('Member_ID'=>$user_info['id'],'receipt_payment_id'=>$orderID_receipt);
            $active_listing_ads = $this->Common_model->get_result('active_listing_ads',$where); 
            $detail = $this->Common_model->get_record('active_listing_ads',$where); 
            $where = array('Member_ID'=>$user_info['id']);
            $data['member_card'] = $this->Common_model->get_record('Member_Card',$where); 
            $where = array('id'=>$orderID_receipt);
            $data['receipt_payment'] = $this->Common_model->get_record('receipt_payment',$where); 
            $listtings = array();
            foreach($active_listing_ads as $active_listing_ad){
                $where = array('Member_ID'=>$user_info['id'],'ID'=>$active_listing_ad['listing_id']);
                $list = $this->Common_model->get_record('Listing',$where); 
                
                $active_listing_ad['Name'] = $list['Name'];
                $active_listing_ad['HeroImage'] = $list['HeroImage'];
                $listtings[] = $active_listing_ad;
            }
            
            $data['listtings'] = $listtings;
            $data['user_info'] = $user_info;
            $data['orderID_receipt'] = $orderID_receipt;
            $data['created_at'] = $detail['created_at'];
            $this->receipt($orderID_receipt,$user_info['email']);
            $this->load->view('frontend/block/header',$this->data);
    		$this->load->view('frontend/home/payment_ads_status', $data); 
    		$this->load->view('frontend/block/footer',$this->data);
        }else{
            redirect('/');
        }
        
    }
    public function receipt($orderID_receipt,$email){
        $user_info = $this->session->userdata('user_info');
        $data = array();            
        $htmlContent='';
        
        $user_info = $this->session->userdata('user_info');
        $where = array('Member_ID'=>$user_info['id']);
        $data['receipt_payment'] = $this->Common_model->get_record('receipt_payment',$where); 
        $where = array('Member_ID'=>$user_info['id'],'receipt_payment_id'=>$orderID_receipt);
        $active_listing_ads = $this->Common_model->get_result('active_listing_ads',$where); 
        $detail = $this->Common_model->get_record('active_listing_ads',$where); 
        $where = array('Member_ID'=>$user_info['id']);
        $data['member_card'] = $this->Common_model->get_record('Member_Card',$where); 
        $where = array('id'=>$orderID_receipt);
        $data['receipt_payment'] = $this->Common_model->get_record('receipt_payment',$where); 
        $listtings = array();
        foreach($active_listing_ads as $active_listing_ad){
            $where = array('Member_ID'=>$user_info['id'],'ID'=>$active_listing_ad['listing_id']);
            $list = $this->Common_model->get_record('Listing',$where); 
            
            $active_listing_ad['Name'] = $list['Name'];
            $active_listing_ad['HeroImage'] = $list['HeroImage'];
            $listtings[] = $active_listing_ad;
        }
        $data['listtings'] = $listtings;
        $data['user_info'] = $user_info;
        $data['orderID_receipt'] = $orderID_receipt;
        $data['created_at'] = $detail['created_at'];
        
        //$this->load->view('frontend/home/pdf_receipt', $data); 
        
        $htmlContent = $this->load->view('frontend/home/pdf_receipt', $data, TRUE);  
        $output_dir = FCPATH."uploads/pdf/";      
        if (!file_exists($output_dir)) {
            mkdir($output_dir, 0777, true);
        }
        $file_name = $user_info['id'].'-'.$orderID_receipt.'.pdf';
        $createPDFFile = $output_dir.$file_name;
        $this->createPDF($createPDFFile, $htmlContent);
        
        
        $this->load->library('email');
        
        $this->email->from('support@condopi.com', 'condopi.com');
        $this->email->to("$email");
        //2019-11-19
		//add bcc to admin
        $this->email->bcc('support@condopi.com');

        $this->email->subject('Receipt for your Ad Spend');
        
        $message = 'Thank you for your Ad Spend purchase on Condo PI.                     ';
        $message .= 'Please see attached PDF for your receipt of this purchase. Thank you for your business.';
        $this->email->message($message);
        $this->email->attach($createPDFFile);
        $this->email->send();
        
        
        
        
        //redirect('uploads/pdf/'.$file_name);
        
    }
    public function createPDF($fileName,$html) {
        ob_start(); 
        // Include the main TCPDF library (search for installation path).
        $this->load->library('Pdf');
        // create new PDF document
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        // set document information
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('TechArise');
        $pdf->SetTitle('TechArise');
        $pdf->SetSubject('TechArise');
        $pdf->SetKeywords('TechArise');

        // set default header data
        $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

        // set header and footer fonts
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);

        // set default monospaced font
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, 0, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(0);
        $pdf->SetFooterMargin(0);

        // set auto page breaks
        //$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->SetAutoPageBreak(TRUE, 0);

        // set image scale factor
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        // set some language-dependent strings (optional)
        if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
            require_once(dirname(__FILE__).'/lang/eng.php');
            $pdf->setLanguageArray($l);
        }       

        // set font
        $pdf->SetFont('dejavusans', '', 10);

        // add a page
        $pdf->AddPage();

        // output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // reset pointer to the last page
        $pdf->lastPage();       
        ob_end_clean();
        //Close and output PDF document
        $pdf->Output($fileName, 'F');        
    }
    
}
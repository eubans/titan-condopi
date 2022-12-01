<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

    private $is_login = false;
    private $data = array();
    private $user_id = 0;
    private $table = "Members";
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
            redirect(base_url('/home/'));
        }
        $this->load->helper(array('url','form'));
    }

    public function index($id = 0) {
    	$this->data['is_estate'] = @$this->data['user']['is_estate']; // BUYER
        $type = $this->input->get("type");
        $type = $type == "buynow" ? "buynow" : "offer";
        $product = $this->Common_model->get_record('Listing',array('ID' => $id));
        if (!(isset($product) && $product != null)) {
            redirect('/');
            die;
        }
        if (empty($product['Price'])) {
        	redirect('/');
            die;
        }
        if ($product['ListingType'] == 'Auction') {
        	redirect('/');
            die;
        }
        
        $listing_type = getDetailListingTypeSEO($product['ListingType']);
		if (strtolower($listing_type) == 'auction') {
			redirect('/');
            die;
		}
        
        $this->data['product'] = $product;
        // GET SELLER INFORMATION
        $seller = $this->Common_model->get_record($this->table, array('ID' => $product['Member_ID']));
        if (!(isset($seller) && $seller != null)) {
            redirect('/');
            die;
        }
        
        $commission_type = $product['Commission_Type'];
	    $commission = $product['Commission'];
	    if ($commission_type == 'Percent' && (!is_numeric($commission) || $commission > 100 || $commission < 0)) {
	        $commission = 0;
	    }
	    $commission_label = '';
	    if ($commission_type == 'Percent') {
	    	$offered = $product['Price'] * $commission/100;
	    	$commission_label = '(' . $commission . '%)';
	    } else {
	    	$offered = $commission;
	    }
	    $fee     = $product['Price'] * 0.25/100;
	    $deposit = $product['Price'] * 3/100;
	    $total   = $product['Price'] + $offered;
    	$cash 	 = 0;
        
        // Assign to view
        $listing_price 	= $product['Price'];
        $this->data['commission'] = $commission;
        $this->data['listing_price'] = $listing_price;
        $this->data['offered'] = $offered;
        $this->data['deposit'] = $deposit;
        $this->data['final_price'] = $total;
        
        $buyer_type = "";
        if (@$this->data['user']["is_estate"] == 1) {
        	// $commission = 0;
        	$buyer_type = "Buyer Type: Real Estate Licensee<br/>";
        }
        
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('message', 'Other Terms', 'required|trim');
            if ($type == "offer") {
                $this->form_validation->set_rules('offer', 'Offer', 'required|trim');
                $this->form_validation->set_rules('financing[]', 'Financing Terms', 'required|trim');
                
                $offer = $this->input->post("offer");
                $offer = preg_replace('/,/', '', $offer);
                $offer = preg_replace('/\$/', '', $offer);
            	$offer = str_replace('$', '', $offer);// Listing price
                
                $commission = $this->input->post("commission");
                $commission = preg_replace('/,/', '', $commission);
               	$commission = preg_replace('/\$/', '', $commission);
            	$commission = str_replace('$', '', $commission);
                
                $cash = "$".number_format($offer);
                $offered = "$".number_format($offer);
                $fee     = "$".number_format($offer * 0.25/100);
                $deposit = "$".number_format($offer * 3/100);
                $total   = "$".number_format($offer + $commission);
                $commission = "$".number_format($commission);
                
                $this->data['listing_price'] = $offered;
		        $this->data['offered'] = $commission;
		        $this->data['final_price'] = $total;
        
            } else { // buynow
            	$commission_type = $product['Commission_Type'];
			    $commission = $product['Commission'];
			    if ($commission_type == 'Percent' && (!is_numeric($commission) || $commission > 100 || $commission < 0)) {
			        $commission = 0;
			    }
			    if ($commission_type == 'Percent') {
			    	$commission = $product['Price'] * $commission/100;
			    }
	    		
            	$listing_price = $product['Price'];
            	$cash = "$".number_format($listing_price);
            	$offered = "$".number_format($listing_price);
                $fee     = "$".number_format($listing_price * 0.25/100);
                $deposit = "$".number_format($listing_price * 3/100);
                $total   = "$".number_format($listing_price + $commission);
                $commission = "$".number_format($commission);
            }
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">'.validation_errors().'</div>');
            } else {
                $arr  = array(
                    'Member_ID' => $this->user_id,
                    'Listing_ID' => $id,
                    'Offer_Price' => $this->input->post('offer') ? $this->input->post('offer') : 0,
                    'Financing_Terms' => $this->input->post('financing') ? implode($this->input->post('financing'),",") : "",
                    'Other_Terms' => $this->input->post('message'),
                    'Allow_Commission' => @$this->input->post('Allow_Commission'),
                    'Is_Hard_Money' => @$this->input->post('Is_Hard_Money'),
                    'Status' => 0
                );
                $latest_id = $this->Common_model->add("BuyNow", $arr);
                if(isset($latest_id) && $latest_id != null && is_numeric($latest_id)) {
                    $this->session->set_flashdata('message', '<div class="alert alert-success">Save successfully.</div>');
                    $this->session->set_flashdata('status', 'SUCCESS');
                    
                    // Find email admin
                    $email_admin = getWebSetting("Email_Receive_Buy");
			        if (empty($email_admin)) {
			        	$email_admin = "support@condopi.com";
			        }
			        
			        $str_mail_commission = "";
			        if (@$this->data['user']["is_estate"] != 1) {
			        	$total = $cash;
			        } else {
			        	$str_mail_commission = "Commission: {$commission}<br />";
			        }
                    
                    // =========== NEW REQUIRE 2019.01.26 =================
                    // SEND MAIL TO BUYER AND SELLER
                    $address = $product['Address'] . ' ' . $product['City'].', '.$product['State'].' '.$product['Zipcode'];
                    if ($type == "buynow") {
                    	// 1. BUYER
	                    $content_mail = "Thank you for selecting “Buy Now” to purchase<br/>
											{$address} <br/><br/>
											Here are the terms of your purchase: <br/>
											Listing Price: {$cash} <br/>
											{$str_mail_commission}
											Final Price: {$total}<br/>
											Financing Terms: ".($this->input->post('financing') ? implode($this->input->post('financing'),",") : "")." <br/>
											Notes: ".$this->input->post('message')." <br/><br/>
											We will send to escrow and title these purchase terms and conditions.<br/>
											Escrow will email you deposit and transaction requirements.<br/>
											Thank you for using condopi.com.";
											
	                    sendmail($this->data['user']["email"],"Buy Now: {$address}, condopi.com",$content_mail);
	                    // sendmail($email_admin,"Buy Now Confirmation for {$address}, condopi.com",$content_mail);
	                    
	                    // 2. SELLER
	                    $content_mail = "You have received a full price offer in condopi.com on <br/>
											{$address} <br/><br/>
											Here are the terms of your purchase: <br/>
											Buyer: ".$this->data['user']["first_name"] . ' ' . $this->data['user']["last_name"]."<br>
											Email: ".$this->data['user']["email"]."<br>{$buyer_type}
											Listing Price: {$cash} <br/>
											{$str_mail_commission}
											Final Price: {$total}<br/>
											Financing Terms: ".($this->input->post('financing') ? implode($this->input->post('financing'),",") : "")." <br/>
											Deposit: {$deposit} <br/><br/>
											Notes: ".$this->input->post('message')." <br/><br/>
											We will send to escrow and title these purchase terms and conditions.<br/>
											Escrow will email transaction requirements.<br/>
											Thank you for using condopi.com.";
	                    // sendmail($seller["Email"],"Buy Now: {$address}, condopi.com",$content_mail);
	                    sendmail($email_admin,"Buy Now: {$address}, condopi.com",$content_mail);
	                    
                    } else { // OFFER
                    	// 1. BUYER
                    	$content_mail = "Thank you for selecting “Offer” to make an offer for the following address<br/>
											{$address} <br/><br/>
											Listing Price: {$cash} <br/>
											{$str_mail_commission}
											Final Price: {$total} <br/>
											Financing Terms: ".($this->input->post('financing') ? implode($this->input->post('financing'),",") : "")." <br/><br/>
											Notes: ".$this->input->post('message')." <br/><br/>
											If the Seller agrees to you price and terms, <br/>we will send to escrow and title these purchase terms and conditions. Thank you.
											<br/><br/>Otherwise, the seller can email you for a counter offer.";
	                    sendmail($this->data['user']["email"],"Offer: {$address}, condopi.com",$content_mail);
	                    // sendmail($email_admin,"Offer Confirmation for {$address}, condopi.com",$content_mail);
	                    
	                    // 2. SELLER 
	                    $content_mail = "You have received an offer in condopi.com on <br/>
											{$address} <br/><br/>
											This is not a full price offer. Here are the terms of the Buyer’s offer: <br/>
											Buyer: ".$this->data['user']["first_name"] . ' ' . $this->data['user']["last_name"]."<br>
											Email: ".$this->data['user']["email"]."<br>{$buyer_type}
											Listing Price: {$cash} <br/>
											{$str_mail_commission}
											Final Price: {$total}<br/>
											Financing Terms: ".($this->input->post('financing') ? implode($this->input->post('financing'),",") : "")." <br/>
											Deposit: {$deposit} <br/><br/>
											Notes: ".$this->input->post('message')." <br/><br/>
											Should you decide to accept this, <br/>we will send to escrow and title these purchase terms and conditions.
											<br><br>If you do not accept this, you may choose to email the buyer a counter. Thank you.";
	                    // sendmail($seller["Email"],"Offer: {$address}, condopi.com",$content_mail);
	                    sendmail($email_admin,"Offer: {$address}, condopi.com",$content_mail);
                    }
                    
                    // ===================================
                    // SEND TO ADMIN AND BUYER IF Allow_Commission = 1
                    if (@$this->input->post('Allow_Commission') == 1) {
                        $content_mail =  '
                        	Name: '. $this->data['user']['full_name'] .' <br/>
							Email: '. $this->data['user']['email'] .' <br/>
							Phone: '. $this->data['user']['phone'] .' <br/>
							Property: '.@$product['Address'] . '<br>' . @$product['City'].' '.@$product['State'].' '.$product['Zipcode'] . '';
	                    sendmail($email_admin,"Buyer Requesting Agent Assistance",$content_mail);
	                    
	                    // Send to user
	                    $content_mail= 'Thank you for using condopi.com. <br>
										Our goal is to make your real estate transaction process as quick and easy as possible. <br><br>

										Your request for a real estate agent to help you with this transaction for a minimal fee has been sent to an agent. <br>
										He will send you confirmation of your request and will soon contact you by email. <br><br>

										We consider you a special customer. Thank you for your continued support.<br><br>

										Best,<br>
										Administrator<br>
										condopi.com – #1 source for real estate deals';
	                    sendmail($this->data['user']['email'],"condopi.com: a minimal fee agent request",$content_mail);
	                    //sendmail($email_admin,"condopi.com a minimal fee Agent Request",$content_mail);
	                }
	                
	                // SEND TO ADMIN IF Is_Hard_Money = 1
                	if (@$this->input->post('Is_Hard_Money') == 1) {
                        $content_mail = '
                        	Name: '. $this->data['user']['full_name'] .' <br/>
							Email: '. $this->data['user']['email'] .' <br/>
							Phone: '. $this->data['user']['phone'] .' <br/>
							Property: '.@$product['Address'] . '<br>' . @$product['City'].' '.@$product['State'].' '.$product['Zipcode'] . '';
	                    sendmail($email_admin,"Buyer Requesting Hard Money Loan",$content_mail);
	                    
	                    $content_mail = 'Thank you for using condopi.com. <br>
											Our goal is to make your real estate transaction process as quick and easy as possible. <br><br>

											Your request for a hard money loan has been sent to a lender. <br>
											He will send you confirmation of your request and will soon contact you by email. <br><br>

											We consider you a special customer. Thank you for your continued support.<br><br>

											Best,<br>
											Administrator<br>
											condopi.com – #1 source for real estate deals';
						
						sendmail($this->data['user']['email'],"Buyer Requesting Hard Money Loan",$content_mail);
	                    //sendmail($email_admin,"Buyer Requesting Hard Money Loan",$content_mail);
	                }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Error!.</div>');
                }
            }
            redirect('/payment/index/'.$id.'/?type='.$type);
        }
        $this->data['type'] = $type;
        $this->data['title'] = 'Payment';
        $this->load->view('frontend/block/header',$this->data);
        $this->load->view('frontend/payment/buynow',$this->data);
        $this->load->view('frontend/block/footer',$this->data);
    }

}
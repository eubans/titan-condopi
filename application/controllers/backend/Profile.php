<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends MY_Controller {
    private $folder_view  = "profile"; 
    private $base_controller ;
    public function __construct() {
        parent::__construct();
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }
    public function index(){
        $id = $this->user_info["ID"];
    	if($id == null)
    		redirect(backend_url("/"));
    	$record = $this->Common_model->get_record("Sys_Users",array("ID" => $id));
    	if($record == null)
    		redirect(backend_url("/"));
        if($this->input->post()){
            $this->form_validation->set_rules('User_Name', 'Tên hệ thống', 'required');
            $this->form_validation->set_rules('User_Pwd', 'Mật khẩu', 'min_length[6]');
            if ($this->form_validation->run() == TRUE){
                $colums = $this->db->list_fields('Sys_Users');
                $data_post = $this->input->post();
                $data_update = array();
                foreach ($data_post as $key => $value) {
                    if(in_array($key, $colums)){
                        $data_update[$key] = $value;
                    }              
                }
                $data_update["Updatedat"] = date("Y-m-d h:i:sa");
                if($data_update["User_Pwd"] != null && $data_update["User_Pwd"] != "")
                	$data_update["User_Pwd"] = md5(trim($data_update["User_Pwd"])."{:MC:}".trim($record["User_Email"]));
                if (isset($_FILES["User_Avatar"])){
                    $upload_path = FCPATH . "/uploads/backend";
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = FCPATH . "/uploads/backend/member";
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $upload_path = $upload_path . "/" . $this->user_info["ID"];
                    if (!is_dir($upload_path)) {
                        mkdir($upload_path, 0755, TRUE);
                    }
                    $file = $_FILES["User_Avatar"];
                    $allowed_types = "jpg|png";
                    $upload = upload_flie($upload_path, $allowed_types, $file);
                    if($upload["status"] == "success")
                    	$data_update["User_Avatar"] = "uploads/backend/member/".$this->user_info["ID"]."/".$upload["reponse"]["file_name"];
                	else
                		$data_update["User_Avatar"] = $record["User_Avatar"];
                }else{
                	$data_update["User_Avatar"] = $record["User_Avatar"];
                }
                $this->Common_model->update("Sys_Users",$data_update,array("ID" =>$record["ID"]));  
                redirect(backend_url($this->base_controller."?edit=success"));
            }else{
                $this->data['post']['status'] = "error";
                $this->data['post']['error'] = validation_errors();
            }
        }
        $this->data["role"] = $this->Common_model->get_result("Sys_Roles");
    	$this->data['record'] = $record;
    	$this->load->view($this->backend_asset."/".$this->base_controller."/edit",$this->data);
    }

    public function history_order (){
        $page_current = ($this->input->get("per_page") != "") ? $this->input->get("per_page") : 0 ;    
        $per_page = 10;
        $page_current = ($page_current > 0) ? ($page_current - 1) : $page_current;
        $offset = $per_page * $page_current;
        $this->data['payment_url'] = base_url($this->backend_asset."/".$this->folder_view."/payment");

        $this->db->select("Products.ID");
        $this->db->from("Products");
        $this->db->join("Order_Detail","Order_Detail.Product_ID = Products.ID");
        $this->db->join("Orders","Order_Detail.Order_ID = Orders.ID");
        $countdata = $this->db->count_all_results();

        $this->db->select("Products.*,Order_Detail.Order_ID,Orders.Status_Order,Orders.Total_Order,Orders.Total_Admin,Orders.Status_Owner,Orders.Createdat_Owner,Order_Detail.Qty,Order_Detail.Start_Day,Order_Detail.Expires_at,Order_Detail.Create_at");
        $this->db->from("Products");
        $this->db->join("Order_Detail","Order_Detail.Product_ID = Products.ID");
        $this->db->join("Orders","Order_Detail.Order_ID = Orders.ID");
        $this->db->limit($per_page,$offset);
        $this->db->order_by('Order_Detail.ID', 'DESC');
        $query = $this->db->get();
        $listrecord = $query->result_array();
        $this->data["records"] = ($listrecord);
        $this->load->library('pagination');

        $config['base_url'] = base_url($this->backend_asset."/".$this->folder_view."/history_order");
        $config['total_rows'] = $countdata ;
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
        $this->load->view($this->backend_asset."/".$this->folder_view."/history_order",$this->data);
    }

    public function payment($order_id = null) {
        $this->db->select("Products.ID, Products.Name,Orders.Total_Discount");
        $this->db->from("Products");
        $this->db->join("Order_Detail","Order_Detail.Product_ID = Products.ID");
        $this->db->join("Orders","Order_Detail.Order_ID = Orders.ID");
        $this->db->where("Orders.ID",$order_id);
        $this->db->where("Orders.Status_Owner",0);
        $this->db->where("Orders.Status_Order",1);
        $this->db->where("Orders.Total_Discount>0");
        $query = $this->db->get();
        $listrecord = $query->result_array();

        if ($listrecord && count($listrecord) > 0 && isset($listrecord[0])) {
            $product = $listrecord[0];
            $params = array(
                "clientId" => "AYc6pO8bLv4FQSkmhyDkTpvXtRO0sk49TW8EJ254Uc8zrq86kgKVMIqcYKs7LUEvI44bo_ALdamEORc-",
                "clientSecret" => "ECh5CWC6cRxbxfO7RZtuQber6W8TUzClg05UgeS4rUPTwSHVoDljd69sQL9aBdXnvDjAynUug2EMzeNz" 
            );
            $this->load->library('Paypal',$params);
            $return_url  = base_url($this->backend_asset."/".$this->folder_view."/checkout_paypal/".$order_id."/");
            $cancel_url  = base_url($this->backend_asset."/".$this->folder_view."/cancel_payment/".$order_id."/");
            $data_paypal = $this->paypal->CreatePaymentUsingPayPal($return_url,$cancel_url,$product["Total_Discount"],$product); 
            if ($data_paypal != null) { 
                redirect($data_paypal["approvalUrl"]);
                die;
            }
        }
    }

    public function checkout_paypal($id){
        $od = $this->Common_model->get_record("Orders",["ID" => @$id,"Status_Order" => 1,"Status_Owner" => 0]);
        if($od != null){
            if($this->input->get("paymentId")!= null  && $this->input->get("PayerID")!= null){
                $params = array(
                    "clientId" => "AYc6pO8bLv4FQSkmhyDkTpvXtRO0sk49TW8EJ254Uc8zrq86kgKVMIqcYKs7LUEvI44bo_ALdamEORc-",
                    "clientSecret" => "ECh5CWC6cRxbxfO7RZtuQber6W8TUzClg05UgeS4rUPTwSHVoDljd69sQL9aBdXnvDjAynUug2EMzeNz" 
                );
                $this->load->library('Paypal',$params);
                $data = $this->paypal->ExecutePayment($od["Total_Discount"],$this->input->get("paymentId"),$this->input->get("PayerID"));
                if (@$data["payer"]["status"] == "VERIFIED") {
                    $this->Common_model->update("Orders",array("Status_Owner" => 1, "Createdat_Owner" => date('Y-m-d H:i:s')),array("ID" => $id));
                }
            }
        }
        redirect(base_url($this->backend_asset."/".$this->folder_view."/history_order"));
    }

    public function cancel_payment($id) {
        redirect(base_url($this->backend_asset."/".$this->folder_view."/history_order"));
    }

}

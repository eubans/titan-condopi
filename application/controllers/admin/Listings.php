<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Listings extends CI_Controller {
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
    public function index() {
        $user_id = $this->user_id;
        $where = array();
        $likes = array();
        $str_where = "1=1";
        $str_having = "";
        if ($this->input->get("keyword")) {
        	array_push($likes,['field' => 'Name', 'value' => $this->input->get("keyword")]);
        	$str_where .= " AND (l.Name LIKE '%".$this->input->get("keyword")."%')";
        }
        if ($this->input->get("status") == "1" || $this->input->get("status") == "2") {
            $where["Status"]= @$this->input->get("status") ;
            $str_where .= " AND (l.Status=".$this->input->get("status").")";
        }
        
		$field_sort = 'Created_At';
        if ($this->input->get("field_sort") && in_array($this->input->get("field_sort"),['Name','Price','DayLeft','Created_At','Favorites','Comments','Views'])) {
            $field_sort = $this->input->get("field_sort");
        }
        $type_sort = 'DESC';
        if ($this->input->get("type_sort") && in_array($this->input->get("type_sort"),['DESC','ASC'])) {
            $type_sort = $this->input->get("type_sort");
        }
        $having = '';
        if ($this->input->get("status") == "1") {
        	$str_having = " HAVING DayLeft > 0 ";
        	$having = ' AND (datediff(le.Extend_Date, now()) + 7) > 0 ';
        	$type_sort = 'DESC';
        	$field_sort = 'DayLeft';
        } else if ($this->input->get("status") == "0") {
        	$str_having = " HAVING DayLeft <= 0 ";
        	$having = ' AND (datediff(le.Extend_Date, now()) + 7) <= 0 ';
        	$type_sort = 'DESC';
        	$field_sort = 'DayLeft';
        }
        
        // $count_table =  $this->Common_model->count_table("Listing",$where, $likes, $having);
        $page_current = ($this->input->get("per_page") != "") ? $this->input->get("per_page") : 0 ;
        
        $per_page = ($this->input->get("perpage") != "") ? $this->input->get("perpage") : 20 ;
        $per_page = $per_page == "all" ? 9999999999 : $per_page;
        $per_page = !is_numeric($per_page) ? 20: $per_page;
        $this->data["perpage"] = $per_page;
        
        $uri = "search=1";
        $arr_uri = $this->input->get();
        if (is_array($arr_uri) && count($arr_uri) > 0) {
        	foreach($arr_uri as $item_key => $item_uri) {
        		if ($item_key != "search" && $item_key != "per_page") {
        			$uri .= "&".$item_key."=".$item_uri;
        		}
        	}
        }
        
        $page_current = ($page_current > 0) ? ($page_current - 1) : $page_current;
        $offset = $per_page * $page_current;
        
        $sql_count = "SELECT count(l.ID) as count_table
        		FROM Listing AS l 
        		INNER JOIN Members AS m ON l.Member_ID = m.ID
        		INNER JOIN Listing_Extend AS le ON le.Listing_ID = l.ID AND le.Status=1
        		WHERE $str_where $having ";
        $count_table  = $this->Common_model->query_raw_row($sql_count);
        
        $sql = "SELECT l.ID, l.Name, l.Price, l.Created_At, le.Extend_Date, l.ListingType, l.Status,l.PDF, CONCAT(m.First_Name,' ',m.Last_Name) as Full_Name, m.Email, l.Member_ID,
        				(datediff(le.Extend_Date, now()) + 7) AS DayLeft, 
        				fNum AS Favorites, lvNum AS Views, lcvNum AS CViews, cNum AS Comments
        		FROM Listing AS l 
        		INNER JOIN Members AS m ON l.Member_ID = m.ID
        		INNER JOIN Listing_Extend AS le ON le.Listing_ID = l.ID AND le.Status=1
        		LEFT JOIN 
        			(SELECT count(f.ID) AS fNum, f.Listing_ID FROM `Listing` AS l LEFT JOIN Favorites AS f ON f.Listing_ID = l.ID GROUP BY l.ID) 
        			AS f ON f.Listing_ID = l.ID
        		LEFT JOIN 
        			(SELECT count(lv.ID) AS lvNum, lv.Listing_ID FROM `Listing` AS l LEFT JOIN Listing_Views AS lv ON lv.Listing_ID = l.ID AND lv.Created_At != '0000-00-00 00:00:00' GROUP BY l.ID) 
        			AS lv ON lv.Listing_ID = l.ID
        		LEFT JOIN 
        			(SELECT count(lv.ID) AS lcvNum, lv.Listing_ID FROM `Listing` AS l 
        				INNER JOIN Listing_Extend AS le ON le.Listing_ID = l.ID AND le.Status=1 
        				LEFT JOIN Listing_Views AS lv ON lv.Listing_ID = l.ID AND lv.Created_At != '0000-00-00 00:00:00'
        				WHERE DATE(lv.Created_At) >= DATE(le.Extend_Date) GROUP BY l.ID
        			) 
        			AS lcv ON lcv.Listing_ID = l.ID
        		LEFT JOIN 
        			(SELECT count(c.ID) AS cNum, c.Listing_ID FROM `Listing` AS l LEFT JOIN Listing_Saved_ByMember AS c ON c.Listing_ID = l.ID GROUP BY l.ID) 
        			AS c ON c.Listing_ID = l.ID
        		WHERE $str_where
                GROUP BY l.ID $str_having 
                ORDER BY {$field_sort} {$type_sort}
                LIMIT {$offset},{$per_page}
        		";
        
        $this->data["collections"] = $this->Common_model->query_raw($sql);
        $this->load->library('pagination');
        $config['base_url']    = base_url("/admin/listings/")."/?".$uri;
        $config['total_rows']  = @$count_table['count_table']; 
        $config['per_page']    = $per_page;
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
    public function uploadpdf(){
        $status = ["status" => "error", "title" => "", "body" => ""];
        $record = $this->Common_model->get_record("Listing",["ID" => $this->input->post("id")]);
        if($record){
            $path = FCPATH . '/uploads';
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $path .= '/listings';
            if (!is_dir($path)) {
                mkdir($path, 0777, true);
            }
            $config['upload_path']          = $path;
            $config['allowed_types']        = 'pdf|doc|xlsx|xls';
            $new_name = time().$_FILES["file"]['name'];
            $new_name = ucwords($new_name);
            $config['file_name'] = $new_name;
            $this->load->library('upload', $config);
            if ( ! $this->upload->do_upload('file'))
            {
                $error = array('error' => $this->upload->display_errors());
                $status = ["status" => "error", "message" => $error];
                echo json_encode($status);
            }
            else
            {

                $data = $this->upload->data();

                $pathURL = str_replace(FCPATH,'/', $data['full_path']);  
                $this->Common_model->update("Listing",["PDF" => $pathURL],["ID" => $record["ID"]]);
                $status = ["status" => "status"];
                echo json_encode($status); 
            }
        }
        

    }
    public function getinfo($type="",$listing_id=null) {
    	$status = ["status" => "error", "title" => "", "body" => ""];
    	if (!is_numeric($listing_id) || !in_array($type,["comment","view","view_current"])) {
    		die(json_encode($status));
    	}
    	if ($type == "comment") {
	    	$sql = "SELECT * FROM Listing_Saved_ByMember WHERE Listing_ID=".$listing_id." ORDER BY Created_At ASC";
        	$this->data["collections"] = $this->Common_model->query_raw($sql);
        	$status["status"] = "success";
        	$status["title"] = "Comments";
        	$status["body"] = $this->load->view('frontend/admin/getinfo/comment',$this->data, TRUE);
        } else if ($type == "view_current") {
        	$sql = "SELECT * FROM Listing_Extend WHERE Listing_ID=".$listing_id." ORDER BY ID DESC LIMIT 40";
        	$result = $this->Common_model->query_raw($sql);
        	$collections = array();
        	if ($result != null) {
        		$cur_date = "";
        		foreach ($result as $item) {
        			$tmp_date = date("Y-m-d", strtotime($item["Extend_Date"]));
        			
        			if (empty($cur_date)) {
        				$where_last_date = " AND DATE(lv.Created_At) >= DATE('".$tmp_date."') ";
        			} else {
        				$where_last_date = " AND DATE(lv.Created_At) >= DATE('".$tmp_date."') AND DATE(lv.Created_At) < DATE('".$cur_date."') ";
        			}
        			$cur_date = $tmp_date;
        			
        			$sql = "SELECT count(lv.ID) AS lcvNum, lv.Listing_ID FROM `Listing` AS l 
        					INNER JOIN Listing_Extend AS le ON le.Listing_ID = l.ID AND le.Status=1 
        					LEFT JOIN Listing_Views AS lv ON lv.Listing_ID = l.ID AND lv.Created_At != '0000-00-00 00:00:00' 
        					WHERE l.ID=".$listing_id.$where_last_date." GROUP BY l.ID";
        			
    				$result2 = $this->Common_model->query_raw_row($sql);
    				$count = 0;
    				if ($result2 != null) {
    					$count = $result2['lcvNum'];
    				}
    				
    				array_push($collections,array("Created_At" => $cur_date, "Views" => $count, "Status" => $item["Status"]));
        		}
        	}
        	$this->data["collections"] = $collections;
        	$status["status"] = "success";
        	$status["title"] = "Views";
        	$status["body"] = $this->load->view('frontend/admin/getinfo/view',$this->data, TRUE);
        } else if ($type == "view") {
        	$sql = "SELECT count(ID) as Views, DATE(Created_At) AS Created_At FROM Listing_Views WHERE Listing_ID=".$listing_id." AND Created_At != '0000-00-00 00:00:00' GROUP BY DATE(Created_At) ORDER BY Created_At ASC";
        	$this->data["collections"] = $this->Common_model->query_raw($sql);
        	$status["status"] = "success";
        	$status["title"] = "Views";
        	$status["body"] = $this->load->view('frontend/admin/getinfo/view',$this->data, TRUE);
        }
    	die(json_encode($status));
    }
    
    public function getlisting($member_id=null) {
    	$status = ["status" => "error", "title" => "", "body" => ""];
    	if (!is_numeric($member_id)) {
    		die(json_encode($status));
    	}
    	
    	$sql = "SELECT l.*,(datediff(le.Extend_Date, now()) + 7) AS DayLeft
    			FROM Listing as l 
    			INNER JOIN Listing_Extend AS le ON le.Listing_ID = l.ID AND le.Status=1
    			WHERE Member_ID=".$member_id." 
    			ORDER BY DayLeft DESC
    	";
    	$this->data["collections"] = $this->Common_model->query_raw($sql);
    	$status["status"] = "success";
    	$status["body"] = $this->load->view('frontend/admin/getinfo/listing',$this->data, TRUE);
    	die(json_encode($status));
    }
    
    
    public function extendlisting($listing_id = null){
    	$sql = "SELECT l.*, (datediff(le.Extend_Date, now()) + 7) AS DayLeft
    			FROM Listing AS l
    			INNER JOIN Listing_Extend AS le ON l.id = le.Listing_ID 
    			WHERE l.id = '$listing_id' AND le.Status = '1' HAVING DayLeft <= 0 AND l.ListingType != 'Pre-MLS' ";
    	$result = $this->Common_model->query_raw_row($sql);
    	if (isset($result) && $result != null) {
	    	$date = date('Y-m-d', strtotime("-7 days"));
	    	$arr = array(
				'Status' => 0
			);
			$this->Common_model->update('Listing_Extend',$arr,array('Listing_ID' => $listing_id));
			$arr = array(
				'Status'      => 1,
				'Listing_ID'  => $listing_id,
				'Extend_Date' => date('Y-m-d H:i:s')
			);
			$this->Common_model->add('Listing_Extend',$arr);
			$this->session->set_flashdata('message', '<div class="alert alert-success">Renew successfully.</div>');
		}
    	redirect('/admin/listings');
    }
    
    public function updatestatus($listing_id = null){
    	$sql = "UPDATE Listing SET Status = CASE 
    				WHEN Status = 1 THEN 0
    				ELSE 1 END
    			WHERE Id='$listing_id'";
    	$result = $this->Common_model->non_query_raw($sql);
    	redirect('/admin/listings');
    }

    public function expiredlisting(){
    	$date = date('Y-m-d', strtotime("+7 days"));
    	$sql = "SELECT l.*,m.Email
    			FROM Listing AS l
    			INNER JOIN Members AS m ON m.id = l.Member_ID 
    			INNER JOIN Listing_Extend AS le ON l.id = le.Listing_ID 
    			WHERE le.Status = '1' AND le.Extend_Date < '$date' 
    			GROUP BY l.ID";
    	$result = $this->Common_model->query_raw($sql);
    	
    	if(isset($result) && $result != null){
    		foreach ($result as $key => $item) {
    			 
    		}
    	}
    }

    public function addlisting() {
        if ($this->input->post()) {
            $content_mail = "";
            $this->load->library('form_validation');
            // $this->form_validation->set_rules('name', 'Name', 'required|trim');
            // $this->form_validation->set_rules('summary', 'Summary', 'required|trim');
            // $this->form_validation->set_rules('detail', 'Detail', 'required|trim');
            //$this->form_validation->set_rules('address', 'Address', 'required|trim');
            $this->form_validation->set_rules('City', 'City', 'required|trim');
            //$this->form_validation->set_rules('county', 'County', 'required|trim');
            //$this->form_validation->set_rules('state', 'State', 'required|trim');
            //$this->form_validation->set_rules('country', 'Country', 'required|trim');
            $this->form_validation->set_rules('Price', 'Price', 'required|trim');
            // $this->form_validation->set_rules('heroimage', 'HeroImage', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">'.validation_errors().'</div>');
            } else {
            	$pdf = '';
                if (isset($_FILES['pdf']) && is_uploaded_file($_FILES['pdf']['tmp_name'])) {
                    $output_dir = FCPATH."/uploads/member/".$this->user_id.'/';
                    $output_url = "/uploads/member/".$this->user_id.'/';

                    if (!file_exists($output_dir)) {
                        mkdir($output_dir, 0777, true);
                    }

                    $allowed =  array('pdf');
                    $filename = $_FILES['pdf']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $ext = strtolower($ext);
                    if (in_array($ext,$allowed)) {
                        $RandomNum    = time();
                        $ImageName    = str_replace(' ', '-', strtolower($_FILES['pdf']['name']));
                        $ImageType    = $_FILES['pdf']['type'];
                        $ImageExt     = substr($ImageName, strrpos($ImageName, '.'));
                        $ImageExt     = str_replace('.', '', $ImageExt);
                        $ImageName    = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                        $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                        if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $output_dir . $NewImageName)){
                            $pdf = $output_url.$NewImageName;
                        }
                    }
                }
            	
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
                    'Commission'        => $commission,
                    'Commission_Type'   => $commission_type,
                    'Escrow_Company'    => $this->input->post('Escrow_Company'),
                    'Insurance_Company' => $this->input->post('Insurance_Company'),
                    'Detail'            => $this->input->post('Detail'),
                    'Rates'             => '',
                    'SlideImage'        => json_encode($gallery),
                    'HeroImage'         => $image,
                    'PDF'         		=> $pdf,
                    'Address2'           => $this->input->post('Address2'),
                    'Address'           => $this->input->post('Address'),
                    'City'              => $this->input->post('City'),
                    'County'            => $this->input->post('County'),
                    'Region'            => $this->input->post('Region'),
                    'State'                => $this->input->post('State'),
                    'Zipcode'           => $this->input->post('Zipcode'),
                    'Country'              => $this->input->post('Country'),
                    'Showing_Instructions' => $this->input->post('Showing_Instructions'),
                    'Allow_Commission'  => @$this->input->post('Allow_Commission') ? $this->input->post('Allow_Commission') : 0,
                    'Updated_At'        => date('Y-m-d H:i:s'),
                    'Created_At'        => date('Y-m-d H:i:s'),
                    'Status'            => $this->input->post('Status'),
                    'APN'           	=> $this->input->post('APN'),
                    'Videos'           	=> $this->input->post('Videos'),
                    'Type'              => $this->input->post('Type'),
                    'ListingType'       => $this->input->post('ListingType')
                );
                $last_id = $this->Common_model->add("Listing", $arr);
                if (isset($last_id) && $last_id != null && is_numeric($last_id)) {
                	// Send mail now
                	if(@$this->input->post('Allow_Commission') == 1){
                        $content_mail .=  '
                        	Name: '. @$this->data['user']['full_name'] .' <br/>
							Email: '. @$this->data['user']['email'] .' <br/>
							Phone: '. @$this->data['user']['phone'] .' <br/>
							Property: '.@$this->input->post('Address') . '<br>' . $this->input->post('City').' '.$this->input->post('State').' '.$this->input->post('Zipcode') . '';
	                    
	                    $web_setting = $this->Common_model->get_record("Web_Setting");
	                    // Send to admin
	                    $email_to = "info@condopi.com";
	                    if ($web_setting['Body_Json'] != null && $web_setting['Body_Json'] != '') {
	                        $Body_Json = json_decode($web_setting['Body_Json'], true);
	                        if (isset($Body_Json['Email_Address']) && !empty($Body_Json['Email_Address'])) {
	                            $email_to = $Body_Json['Email_Address'];
	                        }
	                    }
	                    sendmail($email_to,"Seller requesting ??% Agent",$content_mail);
	                    
	                    // Send to user
	                    $content_mail= 'Thank you for using Condo PI.  Our goal is to make your real estate transaction process as quick and easy as possible.  We appreciate you working with us.  Your request for a real estate agent to help you with this transaction for ??% commission has been sent to an agent.  He will send you confirmation of your request. Thank you again.';
	                    sendmail($this->data['user']['email'],"Condo PI ??% Commission Agent Request",$content_mail);
	                    
	                }
                	
                    // Update Listing_Extend
                    $this->Common_model->update("Listing_Extend", array("Status" => 0), array('Listing_ID' => $last_id));

                    // Add new item Extend
                    $id = $this->Common_model->add("Listing_Extend", array('Listing_ID' => $last_id, 'Status' => 1));

                    $this->session->set_flashdata('message', '<div class="alert alert-success">Save successfully.</div>');
                    redirect('/admin/listings/editlisting/'.$last_id);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">Error!.</div>');
                }
            }
            redirect('/admin/addlisting');
        }
        $this->data['title'] = 'New Listing';
        $this->load->view('frontend/block/header',$this->data);
        $this->load->view('frontend/admin/addlisting',$this->data);
        $this->load->view('frontend/block/footer',$this->data);
    }

    public function editlisting($listing_id = null) {
        $user_id = $this->user_id;
        $record = $this->Common_model->get_record("Listing", array('ID' => $listing_id));
        if(!(isset($record) && $record != null)){
            redirect('/admin/addlisting');
        }
        $user_id = $record['Member_ID'];
        if ($this->input->post()) {
            $this->load->library('form_validation');
            // $this->form_validation->set_rules('name', 'Name', 'required|trim');
            // $this->form_validation->set_rules('summary', 'Summary', 'required|trim');
            // $this->form_validation->set_rules('detail', 'Detail', 'required|trim');
            //$this->form_validation->set_rules('address', 'Address', 'required|trim');
            $this->form_validation->set_rules('City', 'City', 'required|trim');
            //$this->form_validation->set_rules('county', 'County', 'required|trim');
            //$this->form_validation->set_rules('state', 'State', 'required|trim');
            //$this->form_validation->set_rules('country', 'Country', 'required|trim');
            $this->form_validation->set_rules('Price', 'Price', 'required|trim');
            // $this->form_validation->set_rules('heroimage', 'HeroImage', 'required');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">'.validation_errors().'</div>');
            } else {
            	$pdf = @$record['PDF'];
                $pdf = $this->input->post('PDF_remove');
                if (isset($_FILES['pdf']) && is_uploaded_file($_FILES['pdf']['tmp_name'])) {
                    $output_dir = FCPATH."/uploads/member/".$this->user_id.'/';
                    $output_url = "/uploads/member/".$this->user_id.'/';

                    if (!file_exists($output_dir)) {
                        mkdir($output_dir, 0777, true);
                    }

                    $allowed =  array('pdf');
                    $filename = $_FILES['pdf']['name'];
                    $ext = pathinfo($filename, PATHINFO_EXTENSION);
                    $ext = strtolower($ext);
                    if (in_array($ext,$allowed)) {
                        $RandomNum    = time();
                        $ImageName    = str_replace(' ', '-', strtolower($_FILES['pdf']['name']));
                        $ImageType    = $_FILES['pdf']['type'];
                        $ImageExt     = substr($ImageName, strrpos($ImageName, '.'));
                        $ImageExt     = str_replace('.', '', $ImageExt);
                        $ImageName    = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                        $NewImageName = $ImageName . '-' . $RandomNum . '.' . $ImageExt;
                        if (move_uploaded_file($_FILES["pdf"]["tmp_name"], $output_dir . $NewImageName)){
                            $pdf = $output_url.$NewImageName;
                        }
                    }
                }
            	
                $image = @$record['HeroImage'];
                $image = $this->input->post('heroimage_remove');
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
                    'Commission'        => $commission,
                    'Commission_Type'   => $commission_type,
                    'Escrow_Company'    => $this->input->post('Escrow_Company'),
                    'Insurance_Company' => $this->input->post('Insurance_Company'),
                    'Detail'            => $this->input->post('Detail'),
                    'Rates'             => '',
                    'SlideImage'        => json_encode($gallery),
                    'HeroImage'         => $image,
                    'PDF'         		=> $pdf,
                    'Address2'          => $this->input->post('Address2'),
                    'Address'           => $this->input->post('Address'),
                    'City'              => $this->input->post('City'),
                    'County'            => $this->input->post('County'),
                    'Region'            => $this->input->post('Region'),
                    'State'                => $this->input->post('State'),
                    'Zipcode'           => $this->input->post('Zipcode'),
                    'Country'              => $this->input->post('Country'),
                    'Showing_Instructions' => $this->input->post('Showing_Instructions'),
                    'Allow_Commission'     => @$this->input->post('Allow_Commission') ? $this->input->post('Allow_Commission') : 0,
                    'Updated_At'        => date('Y-m-d H:i:s'),
                    'Status'            => $this->input->post('Status'),
                    'APN'           	=> $this->input->post('APN'),
                    'Videos'           	=> $this->input->post('Videos'),
                    'Type'              => $this->input->post('Type'),
                    'ListingType'       => $this->input->post('ListingType')

                );
                $result = $this->Common_model->update("Listing", $arr,array('ID' => $listing_id));
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
        $record = $this->Common_model->get_record("Listing", array('ID' => $listing_id));
        if(!(isset($record) && $record != null)){
            redirect('/admin/listings');
        }
        if ($record['Status'] < 2) {
        	$result = $this->Common_model->update("Listing", ['Status' => 2],array('ID' => $listing_id));
        	$this->session->set_flashdata('message', '<div class="alert alert-success">Delete successfully.</div>');
        } else {
	        $result = $this->Common_model->delete("Listing", array('ID' => $listing_id));
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
        }
        redirect('/admin/listings');
    }
}

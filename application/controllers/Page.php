<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	private $is_login = false;
    private $data = array();
	public function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('user_info')) {
            $this->data["is_login"] = true;
            $this->data['user'] = $this->session->userdata('user_info');
            $this->user_id = $this->data['user']['id'];
            $this->data['member_expiry'] = $this->Common_model->get_record('Member_Expiry',array('Member_ID' => $this->user_id));
        }
        $this->load->helper(array('url','form'));
    }

	public function index($slug = null)
	{
		$this->data['page'] = $this->Common_model->get_record('Page',array('Key_Identify' => $slug));
		if(!(isset($this->data['page']) && $this->data['page'] != null)){
			redirect('/');
			die;
		}
		$disclaimer = '';
		if ($this->data['page']['Disclaimer'] == 'yes') {
			$page_disclaimer = $this->Common_model->get_record('Page',array('Key_Identify' => 'disclaimer'));
			$disclaimer = @$page_disclaimer['Content'];
		}
		$this->data['disclaimer'] = $disclaimer;
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/page/index',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
	}

	public function resources(){
		$categories = $this->Common_model->get_result('Post_Category',array('Post_Type' => 'blog'),null,null,array('Position' => 'ASC'),true);
		if(isset($categories) && $categories != null){
			foreach ($categories as $key => $category) {
				$categories[$key]['articles'] = $this->Common_model->get_result('Post',array('Post_Type' => 'blog','Category_ID' => $category['ID']),null,null,array('ID' => 'ASC'),true);
			}
		}
		$this->data['categories'] = $categories;
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/page/resources',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
	}

	public function article($slug = null){
		$this->data['article'] = $this->Common_model->get_record('Post',array('Slug' => $slug));
		if(!(isset($this->data['article']) && $this->data['article'] != null)){
			redirect('/');
			die;
		}
		$this->data['category'] = $this->Common_model->get_record('Post_Category',array('ID' => @$this->data['article']['Category_ID']));
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/page/article',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
	}

	public function contact(){
		if($this->input->post()){
			$this->load->library('form_validation');
            $this->form_validation->set_rules('full_name', 'Full Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
            $this->form_validation->set_rules('subject', 'Subject', 'required|trim');
            $this->form_validation->set_rules('message', 'Message', 'required|trim');
			if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger">'.validation_errors().'</div>');
            } else {
            	$email = $this->input->post('email');
            	$subject = $this->input->post('subject');
            	$message = $this->input->post('message');
            	$full_name = $this->input->post('full_name');
            	$this->load->library('email');
				$this->email->from($email, $full_name);
				$this->email->to('support@condopi.com');
				$this->email->subject($subject);
				$this->email->message($message);
				$this->email->send();
            	$this->session->set_flashdata('message', '<div class="alert alert-success">Sent mail successfully.</div>');
            }
            redirect('/page/contact-us');
		}
		$this->load->view('frontend/block/header',$this->data);
		$this->load->view('frontend/page/contact',$this->data);
		$this->load->view('frontend/block/footer',$this->data);
	}
}

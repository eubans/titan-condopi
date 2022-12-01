<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class Blog extends CI_Controller {



	private $is_login = false;

    private $data = array();

	public function __construct()

    {

        parent::__construct();

        if ($this->session->userdata('user_info')) {
            $this->user_id = $this->data['user']['id'];
            $this->data['member_expiry'] = $this->Common_model->get_record('Member_Expiry',array('Member_ID' => $this->user_id));
            $this->data["is_login"] = true;

            $this->data['user'] = $this->session->userdata('user_info');

        }

        $this->load->helper(array('url','form'));

    }



	public function index()

	{

    	$where = " 1 = 1 ";

    	$this->data['title'] = 'Blog';

        $count_table =  $this->Common_model->count_table("Post",$where);

        $page_current = ($this->input->get("per_page") != "") ? $this->input->get("per_page") : 0 ;    

        $per_page = 10;

        $page_current = ($page_current > 0) ? ($page_current - 1) : $page_current;

        $offset = $per_page * $page_current;

        $this->data["blog"] = $this->Common_model->get_result("Post",$where,$offset,$per_page,array('ID' => 'DESC'),true);

        $this->load->library('pagination');

        $config['base_url'] = base_url("/blog/");

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



        $this->data["category"] = $this->Common_model->get_result("Post_Category");

        $this->data["last_post"] = $this->Common_model->get_result("Post",array(),0,10,array('ID' => 'DESC'),true);

		$this->load->view('frontend/block/header',$this->data);

		$this->load->view('frontend/blog/index',$this->data);

		$this->load->view('frontend/block/footer',$this->data);

	}



	public function category($slug = null)

	{

		$category = $this->Common_model->get_record("Post_Category",array("Slug" => $slug));

    	if(!(isset($category) && $category != null)){

        	redirect('/blog/');

        }

    	$where = " Category_ID = '".$category['ID']."' ";

    	$this->data['title'] = $category['Name'];

        $count_table =  $this->Common_model->count_table("Post",$where);

        $page_current = ($this->input->get("per_page") != "") ? $this->input->get("per_page") : 0 ;    

        $per_page = 10;

        $page_current = ($page_current > 0) ? ($page_current - 1) : $page_current;

        $offset = $per_page * $page_current;

        $this->data["blog"] = $this->Common_model->get_result("Post",$where,$offset,$per_page,array('ID' => 'DESC'),true);

        $this->load->library('pagination');

        $config['base_url'] = base_url("/blog/");

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



        $this->data["category"] = $this->Common_model->get_result("Post_Category");

        $this->data["last_post"] = $this->Common_model->get_result("Post",array(),0,10,array('ID' => 'DESC'),true);

		$this->load->view('frontend/block/header',$this->data);

		$this->load->view('frontend/blog/index',$this->data);

		$this->load->view('frontend/block/footer',$this->data);

	}



    public function detail($slug = null){

    	$this->data["post"] = $this->Common_model->get_record("Post",array("Slug" => $slug));

        if(!(isset($this->data["post"]) && $this->data["post"] != null)){

        	redirect('/blog/');

        }

        $this->data['post_category'] = $this->Common_model->get_record("Post_Category",array("ID" => $this->data["post"]['Category_ID']));

        $this->data["category"] = $this->Common_model->get_result("Post_Category");

        $this->data["last_post"] = $this->Common_model->get_result("Post",array(),0,10,array('ID' => 'DESC'),true);

        $this->load->view('frontend/block/header',$this->data);

        $this->load->view('frontend/blog/detail',$this->data);

        $this->load->view('frontend/block/footer',$this->data);

    }

}


<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Hook_Config {

    public function load_config() 
    {
    	$ci=&get_instance();
    	$ci->load->model('Common_model');
        $ci->load->library('session');
        if ($ci->session->userdata('config_site') === NULL || $ci->session->userdata('config_site') === FALSE) {
            $collection = $ci->Common_model->get_record("Web_Setting");
            $ci->session->set_userdata('config_site', $collection);
        }
    }

}
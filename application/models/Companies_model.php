<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Companies_model extends CI_Model {
	private $_table = "Aka_Sys_Company";
    function __construct() {
        parent::__construct();
    }
    function get_all(){
    	$this->db->select("tbl1.*,tbl2.User_Name");
    	$this->db->from( $this->_table. " AS tbl1");
    	$this->db->join("Aka_Sys_Users AS tbl2","tbl2.ID = tbl1.User_ID");
        $query = $this->db->get();
        return $query->result_array();
    }

}

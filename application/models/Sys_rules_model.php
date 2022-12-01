<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sys_rules_model extends CI_Model {
	private $_table = "Sys_Rules";
    function __construct() {
        parent::__construct();
    }
    function get_data_role($id){
    	$this->db->select("tbl1.*,tbl2.Allow");
    	$this->db->from( "Sys_Modules  AS tbl1");
    	$this->db->join($this->_table." AS tbl2","tbl2.Module_ID = tbl1.ID AND tbl2.Role_ID = ".$id."","LEFT");
        $query = $this->db->get();
        return $query->result_array();
    }

}

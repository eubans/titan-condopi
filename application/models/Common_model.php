<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function add($table, $data) {
        $this->db->trans_start();
        $this->db->insert($table, $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function delete($table, $where) {
        $return = false;
        $this->db->trans_start();
        $return = $this->db->delete($table, $where);
        $this->db->trans_complete();
        return $return;
    }

    function get_raw($sql){
        $query = $this->db->query($sql);
        return $query->result_array();
    }

    function update($table, $data, $where) {
        $return = false;
        $this->db->trans_start();
        $this->db->where($where);
        $return = $this->db->update($table, $data);
        $this->db->trans_complete();
        return $return;
    }

    function query_raw($sql) {
        return $this->db->query($sql)->result_array();
    }
    
    function non_query_raw($sql) {
        return $this->db->query($sql);
    }

    function query_raw_row($sql) {
        return $this->db->query($sql)->row_array();
    }

    function get_record($table, $where = "", $order = null) {
        $this->db->select('*');
        $this->db->from($table);
        if ($where != "") {
            $this->db->where($where);
        }
        if ($order != null && is_array($order) && !isset($order["field"])) {
            foreach ($order as $item) {
                if (isset($item["field"])) {
                    $this->db->order_by($item["field"], $item["sort"]);
                }
            }
        }
        return $this->db->get()->row_array();
    }

    function get_result($table, $where = null, $offset = null, $limit = null, $order = null,$is_order = false) {
        $this->db->select('*');
        $this->db->from($table);
        if ($where != null) {
            $this->db->where($where);
        }

        if ($limit != null) { 
            $this->db->limit($limit, $offset);
        }
        if ($order != null) {
            foreach ($order as $key => $item) {
                if (isset($item["field"])) {
                    $this->db->order_by($item["field"], $item["sort"]);
                }
            }
        }

        if($is_order){
            foreach ($order as $key => $value) {
                $this->db->order_by($key, $value);
            }
        }
        return $this->db->get()->result_array();
    }

    function get_result_distinct($member_id, $type, $data,$columdate = "createdat_profile") {
        $this->db->distinct();
        $this->db->from("common_view AS cv");
        if($type != "profile"){
            if($type == "blog"){
                $this->db->join("article AS a","a.id = cv.reference_id");
            }
            if($type == "photo"){
                $this->db->join("photos AS a","a.photo_id = cv.reference_id");
            }
        }
        
        $this->db->where(array("cv.member_owner" => $member_id, "cv.type_object" => $type, "cv.".$columdate." >=" => $data, "cv.member_id !=" => $member_id,"cv.member_id !="=> 0 ,"cv.type_share_view" => "view"));
       // $this->db->group_by(array("member_id", "ip"));
        return $this->db->get()->num_rows();
    }
    function get_result_in($table, $column, $in = array()) {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where_in($column, $in);
        return $this->db->get()->result_array();
    }

    function insert_batch_data($table, $data) {
        $this->db->trans_start();
        $this->db->insert_batch($table, $data);
        $insert_id[] = $this->db->insert_id();
        $this->db->trans_complete();
        return $insert_id;
    }

    function count_table($table, $filter = array(), $likes = array(), $having="") {
        $this->db->select('*');
        $this->db->from($table);
        if (count($filter)) {
            $this->db->where($filter);
        }
        if (count($likes) >= 0 ) {
        	foreach ($likes as $like) {
        		$this->db->like($like['field'],$like['value']);
        	}
        }
        if (!empty($having)) {
        	$this->db->having($having);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_sort($group_id, $pid) {
        $filter = array("group_id" => $group_id, "pid" => $pid);
        $this->db->select('sort_id');
        $this->db->from("menu");
        $this->db->where($filter);
        $this->db->order_by("sort_id", "DESC");
        return $this->db->get()->row_array();
    }

    function get_search_category() {
        $all_category = $this->get_result("categories", array(
            "type" => "system"
        ));
        return $this->recursive_category($all_category, 0);
    }

    function slug($table, $colum, $like) {
        $this->db->select($colum);
        $this->db->from($table);
        $this->db->like($colum, $like);
        return $this->db->get()->result_array();
    }
    function get_conversation_comment($member_id, $type_object ='photo', $limit=2, $start=0) 
    {
        $sql = "SELECT DISTINCT `mb`.`avatar`, `ptc`.*, `mb`.`logo`, `mb`.`first_name`, `mb`.`last_name`, `mb`.`company_name`, `pt`.`photo_id`, `pt`.`path_file`, `pt`.`thumb`,`pt`.`name`
                FROM `common_comment` AS `ptc`
                JOIN `members` AS `mb` ON `mb`.`id` = `ptc`.`member_id`
                JOIN `photos` AS `pt` ON `pt`.`photo_id` = `ptc`.`reference_id`
                WHERE 
                `ptc`.`type_object` = '" . $type_object . "' AND 
                (`ptc`.`member_id` = '" . $member_id . "' OR 
                `ptc`.`member_id` IN (SELECT cc.member_id from photos as p JOIN common_comment as cc ON cc.reference_id = p.photo_id AND cc.type_object='" . $type_object . "' WHERE p.member_id='" . $member_id . "'))
                ORDER BY `ptc`.`created_at` DESC";

        if ($limit != -1) {
            $sql .= " LIMIT $start, $limit";
        }
 
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function get_conversation_comment_blog($member_id, $type_object ='photo', $limit=2, $start=0) 
    {
        $sql = "SELECT DISTINCT `mb`.`avatar`, `ptc`.*, `mb`.`logo`, `mb`.`first_name`, `mb`.`last_name`, `mb`.`company_name`, `pt`.`id` AS photo_id , `pt`.`thumbnail` AS  path_file, `pt`.`thumbnail` AS thumb ,`pt`.`title` AS name
                FROM `common_comment` AS `ptc`
                JOIN `members` AS `mb` ON `mb`.`id` = `ptc`.`member_id`
                JOIN `article` AS `pt` ON `pt`.`id` = `ptc`.`reference_id`
                WHERE 
                `ptc`.`type_object` = '" . $type_object . "' AND 
                (`ptc`.`member_id` = '" . $member_id . "' OR 
                `ptc`.`member_id` IN (SELECT cc.member_id from article as p JOIN common_comment as cc ON cc.reference_id = p.id AND cc.type_object='" . $type_object . "' WHERE p.member_id='" . $member_id . "'))
                ORDER BY `ptc`.`created_at` DESC";

        if ($limit != -1) {
            $sql .= " LIMIT $start, $limit";
        }
 
        $query = $this->db->query($sql);
        return $query->result_array();
    }
    private $recursive_reponse = '';

    private function recursive_category($arg, $parent, $index = 0) {
        $loop = array();
        $category_show = array(
            "Style" => "Style",
            "Product" => "Product",
            "Project" => "Project",
            "Area" => "Area",
            "Certifications" => "Certifications",
            "Compliance" => "Compliance",
            "Source" => "Source",
        );
        if ($parent != 0) {
            foreach ($arg as $key => $value) {
                if ($value['pid'] == $parent) {
                    $loop[] = $value;
                    unset($arg[$key]);
                }
            }
        } else {
            foreach ($category_show as $key_1 => $value_1) {
                foreach ($arg as $key => $value) {
                    if ($key_1 == $value["title"]) {
                        if ($value['pid'] == $parent) {
                            $value["title"] = $value_1;
                            $loop[] = $value;
                            unset($arg[$key]);
                        }
                    }
                }
            }
        }
        if (!empty($loop)) {
            if ($index > 2) {
                $class = "parents";
            } else {
                $class = "";
            }

            if ($parent != 0) {
                $this->recursive_reponse.= "<ul class='" . $class . "'>";
            }
            foreach ($loop as $key_loop => $value_loop) {
                $index++;
                if ($parent == 0) {
                    $this->recursive_reponse.= "<div class='col-md-12'>";
                    $this->recursive_reponse.= "<div class='left-box category' id='" . $value_loop["id"] . "'>" . $value_loop["title"] . ":</div><div id='" . $value_loop["id"] . "' class='right-box category'><p id='0'>Any " . $value_loop["title"] . "<span class='glyphicon glyphicon-menu-down' aria-hidden='true'></span></p>";
                    $this->recursive_category($arg, $value_loop['id'], $index);
                    $this->recursive_reponse.= "</div></div>";
                } else {
                    $this->recursive_reponse.= "<li id='" . $value_loop["id"] . "'><a href='#'>" . $value_loop["title"] . "</a>";
                    $this->recursive_category($arg, $value_loop['id'], $index);
                    $this->recursive_reponse.= "</li>";
                }
            }

            if ($parent != 0) {
                $this->recursive_reponse.= "</ul>";
            }
        }

        return $this->recursive_reponse;
    }

    public function get_web_setting($key_identify='',$fields='c.*') {
        $sql = "SELECT {$fields} FROM `web_setting` as p INNER JOIN web_setting c ON c.group_id = p.id AND p.group_id = 0 AND p.selected_item = c.id";
        if (!empty($key_identify)) {
            $sql .= " WHERE p.key_identify = '$key_identify'";
        }

        $query = $this->db->query($sql);
        return $query->result_array();
    }
    function get_use_rol($rol_id){
        $this->db->select("r.Allow,sm.Icon,sm.ID,sm.Module_Name,sm.Module_Url,sm.Module_Class,sm.Module_Key,sm.Parent_ID");
        $this->db->from("Sys_Modules". " AS sm");
        $this->db->join("Sys_Rules AS r","r.Module_ID = sm.ID AND r.Role_ID = ".$rol_id."","LEFT");
        if($rol_id != 1){
            $this->db->where("r.Allow","1");
        }
        $this->db->order_by("sm.Order","ASC");
        $query = $this->db->get();
        return $query->result_array();
    }

}

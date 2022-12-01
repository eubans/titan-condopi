<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Helperclass extends CI_Controller {

    private $key_slug = 0;
    private $table_tree_select = "";
    private $table_tree = "";
    private $all_record_category = [];
    private $id_tree = [];

    public function __construct() {
        $CI = & get_instance();
        $CI->load->helper('url');
        $CI->load->library('session');
        $CI->load->database();
    }

    public function gen_slug($str) {
        $a = array("à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ", " ");
        $b = array("a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A ", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D", "-");
        return strtolower(preg_replace(array('/[^a-zA-Z0-9 -]/', '/[ -]+/', '/^-|-$/'), array('', '-', ''), str_replace($a, $b, $str)));
    }

    public function check_slug($slug, $arg, $key_slug, $default) {
        if (in_array($slug, $arg) == true) {
            $this->key_slug++;
            $this->check_slug($default . "-" . $this->key_slug, $arg, $this->key_slug, $default);
        }
        return $this->key_slug;
    }

    public function slug($table, $colum, $name , $where = null) {
        $CI = & get_instance();
        $CI->load->model("Common_model");
        $slug = $this->gen_slug($name);
        $record = $CI->Common_model->slug($table, $colum, $slug , $where);
        $arg_slug = array();
        if (count($record) > 0) {
            foreach ($record as $key => $value) {
                $arg_slug[] = $value[$colum];
            }
            $key_slug = $this->check_slug($slug, $arg_slug, $this->key_slug, $slug);
            if ($key_slug != 0) {
                $slug = $slug . "-" . $key_slug;
            }
        }
        $this->key_slug = 0;
        return $slug;
    }


    public function slug_member($table, $colum, $name,$member_id) {
        $CI = & get_instance();
        $CI->load->model("Common_model");
        $slug = $this->gen_slug($name);
        $record = $CI->Common_model->slug($table, $colum, $slug, $member_id);
        $arg_slug = array();
        if (count($record) > 0) {
            foreach ($record as $key => $value) {
                $arg_slug[] = $value[$colum];
            }
            $key_slug = $this->check_slug($slug, $arg_slug, $this->key_slug, $slug);
            if ($key_slug != 0) {
                $slug = $slug . "-" . $key_slug;
            }
        }
        $this->key_slug = 0;
        return $slug;
    }

}

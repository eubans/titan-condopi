<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends MY_Controller {

    private $folder_view  = "menu"; 
    private $base_controller ;
    public function __construct() {
        parent::__construct();
        $this->base_controller = $this->folder_view;
        $this->data["base_controller"] = $this->base_controller;
    }

    public function index() 
    {
        /*$this->is_login();
        $this->load->model('Menu_model');
        $this->data['title'] = 'Menu';
        $menu_group = $this->Menu_model->getMenuGroup();
        if (!isset($id) || $id == null) {
            $id = @$menu_group[0]['Group_ID'];
        }

        $this->data['menu_group'] = $menu_group;
        $this->data['id'] = $id;
        $this->data['current'] = "menu";
        $list_menu = $this->Menu_model->get_list_menu_group($id);
        $this->data['menu'] = $this->Menu_model->build_menu_admin(0, $list_menu, "easymm");
        $pages = $this->Common_model->get_result("Page");*/
        $this->load->view('backend/menu/index', $this->data);
    }

    public function add_menu_of_category() 
    {
        $this->is_login();
        if ($this->input->post('new_text')) {
            $new_text = $this->input->post('new_text');
            $id = $this->input->post('id');
            $data_return = array();
            $sort = $this->Common_model->get_sort($id, 0);
            $sort = $sort['Order'];
            foreach ($new_text as $key => $value) {
                $sort++;
                $new_category = array(
                    "Parent_ID" => 0,
                    "Slug" => $value["slug"],
                    "Name" => $value["title"],
                    "URL" => $value["url"],
                    "Group_ID" => $id,
                    'Class' => '',
                    'Order' => $sort
                );
                $insert_id = $this->Common_model->add("menu", $new_category);
                $new_category["id_insert"] = $insert_id;
                $data_return[] = $new_category;
            }

            die(json_encode($data_return));
        }
    }

    function update_menu() 
    {
        if ($this->input->post('easymm') != null) {
            $this->_position($this->input->post('easymm'), 0);
            die('true');
        }

        die('false');
    }

    function delete_menu_item($id = null) 
    {
        $this->load->model('Menu_model');
        if (isset($id) && $id != null) {
            $this->Menu_model->deleteMenuItem($id);
            die('true');
        }

        die('false');
    }

    function update_item_menu($id = null) 
    {
        $this->load->model('Menu_model');
        if (isset($id) && $id != null) {
            $data = array(
                'Name' => $this->input->post('title'),
                'Slug' => $this->_create_slug($this->input->post('title')),
                'Url' => $this->input->post('url'),
                'Class' => $this->input->post('class')
            );
            $this->Menu_model->updateMenuItem($id, $data);
            die('true');
        }

        die('false');
    }

    function add_menu_group() 
    {
        $data = array(
            'Name' => $this->input->post('name')
        );
        $this->load->model('Menu_model');
        $id = $this->Menu_model->addMenuGroup($data);
        die('' . $id);
    }

    function add_item_menu() 
    {
        $this->load->model('Menu_model');
        $data = array(
            'Name' => $this->input->post('title'),
            'Slug' => $this->_create_slug($this->input->post('title')),
            'Url' => $this->input->post('url'),
            'Class' => $this->input->post('class'),
            'Group_ID' => $this->input->post('group_id')
        );
        $id = $this->Menu_model->addMenuItem($data);
        if (isset($id) && $id != null && $id > 0) {
            die("" . $id);
        }

        die('0');
    }

    function get_item_menu($id = null) 
    {
        $this->load->model('Menu_model');
        $result = array();
        if (isset($id) && $id != null) {
            $result = $this->Menu_model->getItemMenu($id);
        }

        die(json_encode($result));
    }

    function _position($data, $parent) 
    {
        $this->load->model('Menu_model');
        foreach ($data as $item => $value) {
            // update position menu item
            $this->Menu_model->updateMenuItem($value['id'], array(
                "Parent_ID" => $parent,
                "Order" => $item
            ));
            if (isset($value['children']) && $value['children'] != null) {
                $this->_position($value['children'], $value['id']);
            }
        }
    }

    function _create_slug($string) 
    {
        $slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
        return $slug;
    }

    private $recursive_response = '';
    function _recursive_category_admin($arg, $parent) 
    {
        if ($parent != 0) {
            $this->recursive_response.= "<ul class='nav nav-list tree'>";
        } else {
            $this->recursive_response.= "<ul class='nav'>";
        }
        if ($arg != null && count($arg) > 0) {
            foreach ($arg as $key => $value) {
                if ($value["Parent_ID"] == $parent) {
                    $this->recursive_response.= "<li id ='" . $value["ID"] . "'><label class='tree-toggler nav-header'><input type='checkbox' data-parent = '" . $parent . "' data-title = '" . $value["Name"] . "' data-id='" . $value["ID"] . "' value='" . $value["Slug"] . "'>" . $value["Name"] . "</label>";
                    $this->_recursive_category_admin($arg, $value["ID"]);
                    $this->recursive_response.= "</li>";
                    unset($arg[$key]);
                }
            }
        }

        $this->recursive_response.= "</ul>";
        return $this->recursive_response;
    }
}
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: hthan
 * Date: 03/21/2019
 * Time: 10:15 AM
 */

class Custom_link extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('customlink_model');
        $this->load->model('collection_model');
        $this->load->model('category_link_model');
    }

    public function ajax_load_child_categories_link()
    {
        if($this->input->is_ajax_request()) {
            $parent_id = $this->input->post('category_id');
            $result    = $this->category_link_model->get_categories_child($parent_id);
            echo json_encode($result);
        }
        exit();
    }

}
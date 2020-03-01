<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Category_link extends MY_Controller {

    function __construct() {
        parent::__construct();
        #BEGIN: CHECK LOGIN
//        if (!$this->isLogin('admin')) {
//            redirect(base_url() . 'administ', 'location');
//            die();
//        }
        //$this->lang->load('admin/common');
        $this->load->model('category_link_model');
    }

    function index() {

    }

    function create()
    {
//        if (!$this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'category_add')) {
//            show_error($this->lang->line('unallowed_use_permission'));
//            die();
//        }

        $data['categories_parent'] = $this->category_link_model->gets([
            'param'     => 'parent_id = 0',
            'orderby'   => 'ordering',
            'type'      => 'array',
        ]);

        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Tên danh mục', 'required|trim|striptag');
        $this->form_validation->set_rules('slug', 'Path danh mục', 'required|callback_valid_path|is_unique[tbtt_category_links.slug]');

        if($this->input->post('ordering')){
            $this->form_validation->set_rules('ordering', 'Sắp xếp', 'numeric|greater_than[0]');
        }

        if($this->input->post('parent_id')){
            $this->form_validation->set_rules('parent_id', 'Danh mục gốc', 'numeric|callback_check_category_parent');
        }else{
            //nếu là category root thì bắt buộc có image
            $this->form_validation->set_rules('image', 'Hình danh mục', 'required');
        }

        //$this->form_validation->set_error_delimiters('<div class="div_errorpost">', '</div>');

        if ($this->form_validation->run()) {
            $data = $this->form_validation->get_post_data();
            $data['status'] = $this->input->post('status') == 1;
//            $data = array(
//                'cat_name' => trim($this->filter->injection_html($this->input->post('name_category'))),
//                'cat_descr' => trim($this->filter->injection_html($this->filter->clear($this->input->post('descr_category')))),
//                'cat_image' => $this->filter->injection($this->input->post('image_category')),
//                'cat_order' => (int)$this->input->post('order_category'),
//                'parent_id' => (int)$this->input->post('parent_id'),
//                'cat_index' => (int)$this->input->post('cat_index'),
//                'cat_level' => (int)$this->input->post('cat_level'),
//                'status' => $active_category,
//                'keyword' => $this->input->post('keyword'),
//                'h1tag' => $this->input->post('h1tag'),
//                'cat_hot' => $this->input->post('cat_hot'),
//            );

            if ($this->category_link_model->add($data)) {
                redirect(base_url() . 'administ/category-links/' . $this->db->insert_id() . '/edit', 'location');
            }
        }
        //  category_link_model
        $this->load->view('admin/category-links/add', $data);
    }

    public function valid_path($path)
    {
        if(preg_match('/[^a-zA-z0-9_-\.]/i', $path)){
            return false;
        }
        return true;
    }

    public function check_category_parent($id)
    {
        if(!$id || !($this->category_link_model->find_where(['id' => $id, 'parent_id' => 0]))){
            return false;
        }

        return true;
    }



}

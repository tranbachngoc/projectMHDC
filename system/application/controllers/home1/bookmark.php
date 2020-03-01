<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
#****************************************#
# * @Author: hthanhbmt                   #
# * @Email: hthanhbmt@gmail.com          #
# * @Copyright: 2008 - 2009              #
#****************************************#
class Bookmark extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->lang->load('form_validation', 'vietnamese');
        $this->load->model('bookmark_model');
        $this->load->model('user_model');
        $this->load->model('shop_model');
    }

    public function create()
    {
        if($this->isLogin() && $this->input->is_ajax_request()){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', 'Tiêu đề', 'trim|strip_tags|required');
            $this->form_validation->set_rules('link', 'Liên kết', 'trim|strip_tags|required|url');

            if ($this->form_validation->run()){
                $data_insert = $this->form_validation->get_post_data();
                $data_crawl  = getUrlMeta($data_insert['link']);
                if(!empty($data_crawl)){
                    if(!empty($data_crawl['favicon'])){
                        if(!filter_var( $data_crawl['favicon'], FILTER_VALIDATE_URL)){
                            $urlData = parse_url($data_insert['link']);
                            $data_insert['icon'] = $urlData['scheme'] . '://'. $urlData['host'] .'/'. ltrim($data_crawl['favicon'], '/');
                        }else{
                            $data_insert['icon'] = $data_crawl['favicon'];
                        }
                    }
                }

                $data_insert['user_id'] = $this->session->userdata('sessionUser');
                $bookmark = $this->bookmark_model->find_where([
                    'user_id'   => $data_insert['user_id'],
                    'link'      => $data_insert['link']
                ]);

                //update
                if(!empty($bookmark)){
                    $data_insert['updated_at'] = date('Y-m-d H:i:s');
                    if($this->bookmark_model->update_where($data_insert, ['user_id' => $data_insert['user_id'], 'id' => $bookmark['id']])){
                        echo json_encode(['status' => 1, 'message' => 'Đã thêm lối tắt.']);
                        die();
                    }
                }else{
                    $data_insert['created_at'] = date('Y-m-d H:i:s');
                    if($this->bookmark_model->add_new($data_insert)){
                        echo json_encode(['status' => 1, 'message' => 'Đã thêm lối tắt.']);
                        die();
                    }
                }

                echo json_encode(['status' => 0, 'message' => 'Sảy ra lỗi trong quá trình lưu vui lòng thử lại.']);
                die();

            }else{
                echo json_encode($this->form_validation->error_array());
            }
        }
        die();
    }

    public function destroy($id)
    {
        if($this->isLogin() && $this->input->is_ajax_request()){
            if($this->bookmark_model->delete_where(['id' => (int)$id, 'user_id' => $this->session->userdata('sessionUser')])){
                echo json_encode(['status' => 1, 'message' => 'Đã xóa lối tắt.']);
                die();
            }
            echo json_encode(['status' => 0, 'message' => 'Sảy ra lỗi trong quá trình thực hiện vui lòng thử lại.']);
        }
        die();
    }

}

?>
<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 12/17/2015
 * Time: 8:31 AM
 */
class Ajax_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();

    }

    function addFavourite($data){
        $this->db->cache_off();
        $this->db->where('prf_product', $data['prf_product']);
        $this->db->where('prf_user', $data['prf_user']);
        $this->db->from('tbtt_product_favorite');
        if( $this->db->count_all_results() > 0){
            return array('error'=>true, 'message'=>'Bạn đã thích sản phẩm này rồi.');
        }else{
            $data['prf_date'] = time();
            $this->db->insert('tbtt_product_favorite', $data);
            return array('error'=>false, 'message'=>'Thêm vào danh sách <b>sản phẩm yêu thích</b> thành công!');
        }

    }

    function delFavourite($data){
        $this->db->cache_off();
        $this->db->where('prf_product', $data['prf_product']);
        $this->db->where('prf_user', $data['prf_user']);
        $this->db->from('tbtt_product_favorite');
        $this->db->delete('tbtt_product_favorite', $data);
        return array('error'=>false, 'message'=>'Đã xóa sản phẩm khỏi danh sách yêu thích');
        

    }

}

<?php
class Order_detail_model extends CI_Model
{
    private $_table = 'tbtt_order_detail';
    function __construct()
    {
            parent::__construct();
    }

    /**
     * Add new record into table
     * @param type $data
     */
    public function add($order_detail = array()) {
        //Get pro_cost
        foreach ($order_detail['products_id'] as $key => $pro_id) {
            $query = $this->db->get_where('tbtt_product', array('pro_id' => $pro_id), 1, 0);
            $product = $query->result_array();
            $product = $product[0];
            $data = array(
                'order_id'  => $order_detail['order_id'],
                'pro_id'    => $pro_id,
                'pro_price' => (float)$product['pro_cost'],
                'af_id'     => $order_detail['af_id'],
                'af_rate'   => (float)$product['af_rate'],
                'af_amt'    => (float)$product['af_amt'],
                'qty'       => (int)$order_detail['qtys'][$key],
//                'lastStatus' => 
            );
            $this->db->insert($this->_table, $data);
        }        
    }
}
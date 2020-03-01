<?php

class Order_model extends CI_Model
{
    private $_table = 'tbtt_order';
    function __construct()
    {
        parent::__construct();
    }

    function get($select = "*", $where = "")
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($where && $where != "") {
            $this->db->where($where);
        }
        #Query
        $query = $this->db->get("tbtt_order");
        $result = $query->row();
        $query->free_result();
        return $result;
    }

    function fetch($select = "*", $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0)
    {
        $this->db->cache_off();
        $this->db->select($select, false);
        if ($where && $where != "") {
            $this->db->where($where);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        #Query
        $query = $this->db->get("tbtt_order");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function create_order($id, $payment_method = 0, $shipping_method = 0, $order_saler = 0, $order_user = 0, $currentDate, $af_id = 0, $order_total, $payment_status = 0, $token = "", $other_info = "", $payment_info = "")
    {
        if ($order_saler) {
            $data = array(
                'id' => $id,
                'payment_method' => $payment_method,
                'shipping_method' => $shipping_method,
                'order_user' => $order_user,
                'order_saler' => $order_saler,
                'date' => $date = time(),
                'af_id' => $af_id,
                'order_total' => $order_total,
                'payment_status' => $payment_status,
                'token' => $token,
                'other_info' => $other_info,
                'payment_other_info' => $payment_info
            );
            $this->db->insert($this->_table, $data);
            return $this->db->insert_id();

            //$query = "INSERT IGNORE INTO tbtt_order VALUES (".$id.",NULL,'".$payment_method."','".$shipping_method."',".$order_saler.",".$order_user.")";
        } else {
            return NULL;
        }
    }

    function update_order($id, $status)
    {
        $query = "UPDATE `tbtt_order` SET `order_status` = '" . $status . "' WHERE `id` = " . $id;
        $return = $this->db->query($query);
        return $return;
    }

    function update_nl_order($id, $status, $token = "", $other_info = "", $coupon_code = "", $order_status = "")
    {
        $query = "UPDATE `tbtt_order` SET `payment_status` = '" . $status . "' ";
        if ($token != "") {
            $query .= " ,`token` = '" . $token . "'";
        }
        if ($other_info != "") {
            $query .= " ,`payment_other_info` = '" . $other_info . "'";
        }
        if ($coupon_code != "") {
            $query .= " ,`order_coupon_code` = '" . $coupon_code . "'";
        }
        if ($order_status != "") {
            $query .= " ,`order_status` = '" . $order_status . "'";
        }
        $query .= " WHERE `id` = " . $id;
        $return = $this->db->query($query);
        return $return;
    }

    function loadDetailOrder($id, $shc_saler = NULL)
    {
        $this->db->cache_off();
        $this->db->select("*");
        //$this->db->from("tbtt_order");
        $this->db->join("tbtt_showcart", "tbtt_showcart.shc_orderid = tbtt_order.id", 'INNER');
        $this->db->join("tbtt_product", "tbtt_product.pro_id = tbtt_showcart.shc_product", 'INNER');
        $this->db->join("tbtt_user_receive", "tbtt_user_receive.order_id = tbtt_order.id", 'LEFT');
        $this->db->where("tbtt_order.id", $id);

        if (!is_null($shc_saler)) {
            $this->db->where("tbtt_showcart.shc_saler", $shc_saler);
        }
        #Query
        $query = $this->db->get("tbtt_order");

        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function DetailOrder($id, $join = TRUE)
    {
        $select = '*';
        $this->db->cache_off();
        $this->db->select($select);

        if ($join === TRUE) {
            $this->db->join('tbtt_user_receive', 'tbtt_user_receive.order_id = tbtt_order.id', 'inner');
        }
        
        $this->db->where('tbtt_order.id', $id);
        $query = $this->db->get('tbtt_order');
        $result = reset($query->result());
        $query->free_result();
        return $result;
    }

    function getTotalOrder($id)
    {
        $this->db->cache_off();
        $this->db->select("tbtt_showcart.shc_quantity, tbtt_product.pro_cost, tbtt_product.pro_saleoff, tbtt_product.pro_type_saleoff, tbtt_product.pro_saleoff_value");
        //$this->db->from("tbtt_order");
        $this->db->join("tbtt_showcart", "tbtt_showcart.shc_orderid = tbtt_order.id", 'INNER');
        $this->db->join("tbtt_product", "tbtt_product.pro_id = tbtt_showcart.shc_product", 'INNER');
        $this->db->where("tbtt_order.id", $id);
        #Query
        $query = $this->db->get("tbtt_order");
        $result = $query->result();
        $query->free_result();
        $total = 0;
        foreach ($result as $product) {
            if ($product->pro_saleoff) {
                switch ($product->pro_type_saleoff) {
                    case 1:
                        $price = (float)$product->pro_cost - (float)$product->pro_cost * (float)$product->pro_saleoff_value / 100;
                        break;
                    case 2:
                        $price = (float)$product->pro_cost - (float)$product->pro_saleoff_value;
                        break;
                }
            } else $price = $product->pro_cost;
            $total += $price * $product->shc_quantity;
        }
        return $total;
    }

    function getPaymentMethod($id)
    {
        $this->db->cache_off();
        $this->db->select("tbtt_order.payment_method");
        $this->db->where("tbtt_order.id", $id);
        #Query
        $query = $this->db->get("tbtt_order");
        $result = reset($query->result());
        $query->free_result();
        return $result->payment_method;
    }

    function getOrderSaler($id, $info)
    {
        $this->db->cache_off();
        $this->db->select("tbtt_payment." . $info);
        $this->db->join('tbtt_payment', "tbtt_payment.id_user = tbtt_order.order_saler", 'INNER');
        $this->db->where("tbtt_order.id", $id);
        #Query
        $query = $this->db->get("tbtt_order");
        $result = reset($query->result());
        echo $this->db->last_query();
        die;
        $query->free_result();
        return $return;
    }

    function fetch_join($select = "*", $join_1, $table_1, $on_1, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group_by = NULL)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
            $this->db->join($table_1, $on_1, $join_1);
        }

        if ($where && $where != "") {
            $this->db->where($where);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();
        }
        if ($group_by && $group_by != NULL) {
            $this->db->group_by($group_by);
        }
        #Query
        $query = $this->db->get("tbtt_order");

        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join3($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $group_by = NULL)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
            $this->db->join($table_1, $on_1, $join_1);
        }
        if ($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "") {
            $this->db->join($table_2, $on_2, $join_2);
        }
        if ($where && $where != "") {
            $this->db->where($where);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();
        }
        if ($group_by && $group_by != NULL) {
            $this->db->group_by($group_by);
        }
        #Query
        $query = $this->db->get("tbtt_order");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join4($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $where = "", $order = "id", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $groupBy = false)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
            $this->db->join($table_1, $on_1, $join_1);
        }
        if ($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "") {
            $this->db->join($table_2, $on_2, $join_2);
        }
        if ($join_3 && ($join_3 == "INNER" || $join_3 == "LEFT" || $join_3 == "RIGHT") && $table_3 && $table_3 != "" && $on_3 && $on_3 != "") {
            $this->db->join($table_3, $on_3, $join_3);
        }
        if ($where && $where != "") {
            $this->db->where($where);
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();

        }
        if ($groupBy && $groupBy == true) {
            $this->db->group_by($groupBy);

        }
        #Query
        $query = $this->db->get("tbtt_order");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join5($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $where = "", $order = "pro_name", $by = "DESC", $start = -1, $limit = 0, $distinct = false)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
            $this->db->join($table_1, $on_1, $join_1);
        }
        if ($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "") {
            $this->db->join($table_2, $on_2, $join_2);
        }
        if ($join_3 && ($join_3 == "INNER" || $join_3 == "LEFT" || $join_3 == "RIGHT") && $table_3 && $table_3 != "" && $on_3 && $on_3 != "") {
            $this->db->join($table_3, $on_3, $join_3);
        }
        if ($where && $where != "") {
            $this->db->where($where);
            $this->db->group_by('tbtt_product.pro_id');
        }
        if ($order && $order != "" && $by && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();

        }
        #Query
        $query = $this->db->get("tbtt_order");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function fetch_join6($select = "*", $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $join_3, $table_3, $on_3, $join_4, $table_4, $on_4, $where = "", $order = "", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $join_5 = null, $table_5 = null, $on_5 = null)
    {
        $this->db->cache_off();
        $this->db->select($select);
        if ($join_1 && ($join_1 == "INNER" || $join_1 == "LEFT" || $join_1 == "RIGHT") && $table_1 && $table_1 != "" && $on_1 && $on_1 != "") {
            $this->db->join($table_1, $on_1, $join_1);
        }
        if ($join_2 && ($join_2 == "INNER" || $join_2 == "LEFT" || $join_2 == "RIGHT") && $table_2 && $table_2 != "" && $on_2 && $on_2 != "") {
            $this->db->join($table_2, $on_2, $join_2);
        }
        if ($join_3 && ($join_3 == "INNER" || $join_3 == "LEFT" || $join_3 == "RIGHT") && $table_3 && $table_3 != "" && $on_3 && $on_3 != "") {
            $this->db->join($table_3, $on_3, $join_3);
        }
        if ($join_4 && ($join_4 == "INNER" || $join_4 == "LEFT" || $join_4 == "RIGHT") && $table_4 && $table_4 != "" && $on_4 && $on_4 != "") {
            $this->db->join($table_4, $on_4, $join_4);
        }
        if ($join_5 && ($join_5 == "INNER" || $join_5 == "LEFT" || $join_5 == "RIGHT") && $table_5 && $table_5 != "" && $on_5 && $on_5 != "") {
            $this->db->join($table_5, $on_5, $join_5);
        }
        if ($where && $where != "") {
            $this->db->where($where);
            // $this->db->group_by('tbtt_order.order_user');
        }
        if ($order && $order != "" && ($by == "DESC" || $by == "ASC")) {
            $this->db->order_by($order, $by);
        }
        if ((int)$start >= 0 && $limit && (int)$limit > 0) {
            $this->db->limit($limit, $start);
        }
        if ($distinct && $distinct == true) {
            $this->db->distinct();

        }
        #Query
        $query = $this->db->get("tbtt_order");
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    function update($data, $where = "")
    {
        $this->db->cache_delete_all();
        if (!file_exists('system/cache/index.html')) {
            $this->load->helper('file');
            @write_file('system/cache/index.html', '<p>Directory access is forbidden.</p>');
        }
        if ($where && $where != "") {
            $this->db->where($where);
        }
        return $this->db->update("tbtt_order", $data);
    }

    function list_order_by_id_shop($params, $viewbyparent = array())
    {
        $param = array(
            'pro_type'    => '',
            'is_count'    => false
        );

        $params = array_merge($param, $params);

        $this->db->cache_off();
        $this->db->select($params['select']);
        $this->db->join('tbtt_order', 'tbtt_order.id = tbtt_showcart.shc_orderid', 'inner');
        $this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_order.order_user', 'left');
        $this->db->join('tbtt_product', 'tbtt_showcart.shc_product = tbtt_product.pro_id', 'inner');
        $this->db->join('tbtt_status', 'tbtt_status.status_id = tbtt_order.order_status', 'inner');
        $this->db->join('tbtt_user_receive', 'tbtt_user_receive.order_id = tbtt_order.id', 'inner');
        $this->db->join('tbtt_detail_product', 'tbtt_detail_product.`id` = tbtt_showcart.shc_dp_pro_id', 'left');
        //$this->db->group_by('tbtt_showcart.shc_orderid');
        if (!empty($params['order_id'])) {
            $this->db->where('tbtt_showcart.shc_orderid', $params['order_id']);
        }
        if (!empty($params['username'])) {
            $this->db->like('use_fullname', $params['username']);
        }
        if (!empty($params['ordmobile'])) {
            $this->db->like('ord_smobile', $params['ordmobile']);
        }
        if (isset($params['start_date']) && $params['start_date'] && isset($params['end_date']) && $params['end_date']) {
            $this->db->where('date >=', $params['start_date'] . ' AND =<' . $params['end_date']);
        }
        if ($params['pro_type'] < 3) {
            $this->db->where_in('pro_type', $params['pro_type']);
        }
        if (!empty($params['coupon_code'])) {
            $this->db->where('order_coupon_code', $params['coupon_code']);
        }
        if (!empty($params['ship_order'])) {
            $this->db->like('shipping_method', $params['ship_order']);
        }
        if (!empty($params['order_status'])) {
            $this->db->like('order_status', $params['order_status']);
        }
        if (empty($viewbyparent)) {
            if ($params['where'] != '') {
                $this->db->where($params['where']);
            } else {
                $this->db->where('shc_saler', $params['shc_saler']);
            }
        } else {
            $this->db->where('shc_saler IN (' . $viewbyparent['data'] . ')');
        }
        #Query
        if ($params['is_count']) {
            $query = $this->db->get('tbtt_showcart');
            $result = $query->result();
            return count($result);

        } else {

            if (!empty($params['sort'])) {
                $this->db->order_by($params['sort'], $params['by']);
            }
            if (!empty($params['user'])) {
                $this->db->order_by($params['sort'], $params['by']);
            }
            if (!empty($params['date'])) {
                $this->db->order_by($params['sort'], $params['by']);
            }
            if (!empty($params['limit'])) {
                $this->db->limit($params['limit'], $params['start']);
                $query = $this->db->get('tbtt_showcart');
            } else {
                $query = $this->db->get('tbtt_showcart');
            }

            $result = $query->result();
            //   echo $this->db->last_query();exit;
            $query->free_result();
        }

        return $result;
    }

    function list_order_by_id_user($params)
    {
        //$this->db->cache_off();
        $this->db->select($params['select']);
        $this->db->where('order_user', $params['id_user']);
        if (!empty($params['order_id'])) {
            $this->db->where('tbtt_order.id', $params['order_id']);
        }
        if ($params['is_count']) {
            $query = $this->db->get('tbtt_order');
            $result = $query->result();
            return count($result);
        } else {
            if (!empty($params['sort'])) {
                $this->db->order_by($params['sort'], $params['by']);
            }
            if (!empty($params['user'])) {
                $this->db->order_by($params['sort'], $params['by']);
            }
            if (!empty($params['date'])) {
                $this->db->order_by($params['sort'], $params['by']);
            }
            if (!empty($params['limit'])) {
                $this->db->limit($params['limit'], $params['start']);
                $query = $this->db->get('tbtt_order');
            } else {
                $query = $this->db->get('tbtt_order');
            }
            $result = $query->result();
            $query->free_result();
        }

        return $result;
    }

    function get_user_order_info($order_id)
    {
        $select = 'tbtt_order.*, tbtt_user.use_fullname, tbtt_user.use_address, tbtt_user.use_email, tbtt_user.use_phone, tbtt_user.use_mobile, tbtt_user.fax';
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_order.order_user', 'left');
        $this->db->where('tbtt_order.id', $order_id);
        $query = $this->db->get('tbtt_order');
        $result = reset($query->result());
        $query->free_result();
        return $result;
    }

    function get_user_receive_info($order_id)
    {
        $select = 'tbtt_user_receive.ord_sname, tbtt_user_receive.ord_saddress, tbtt_user_receive.ord_semail, tbtt_user_receive.ord_smobile, tbtt_user_receive.ord_note';
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->join('tbtt_user_receive', 'tbtt_user_receive.order_id = tbtt_order.id', 'inner');
        $this->db->where('tbtt_order.id', $order_id);
        $query = $this->db->get('tbtt_order');
        $result = reset($query->result());
        $query->free_result();
        return $result;
    }

    function getUser_receive_info($order_id)
    {
        $select = 'shipping_method,order_status, payment_method, order_clientCode, tbtt_user_receive.*, ProvinceName, DistrictName, shipping_fee, shc_total,shc_buydate, payment_status, tbtt_order.order_coupon_code, tbtt_order.product_type';
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->join('tbtt_user_receive', 'tbtt_user_receive.order_id = tbtt_order.id', 'inner');
        $this->db->join('tbtt_district', 'tbtt_user_receive.ord_district = tbtt_district.DistrictCode', 'left');
        $this->db->join('tbtt_showcart', 'tbtt_order.id = tbtt_showcart.shc_orderid', 'inner');
        $this->db->where('tbtt_user_receive.order_id', $order_id);
        $query = $this->db->get('tbtt_order');
        $result = reset($query->result());
        $query->free_result();
        return $result;
    }

    /*
     * List of orders in: confirm, in progress, ...
     */
    public function list_orders_progress($params)
    {
        $this->db->cache_off();
        $select = "tbtt_order.*, count(shc_orderid) as 'num_products', sum(pro_price) as 'total_price', sho_name, sho_link, tbtt_user.use_username, tbtt_user.use_fullname,  tbtt_showcart.*, tbtt_product.pro_type";
        $this->db->select($select);

        $this->db->join('tbtt_user', 'tbtt_user.use_id = tbtt_showcart.shc_buyer', 'left');
        $this->db->join('tbtt_shop', 'tbtt_shop.sho_user = tbtt_showcart.shc_saler', 'inner');
        $this->db->join('tbtt_order', 'tbtt_order.id = tbtt_showcart.shc_orderid', 'inner');
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_showcart.shc_product', 'inner');
        $this->db->group_by('tbtt_showcart.shc_orderid');
        $this->db->group_by('tbtt_showcart.shc_saler');
        //	$this->db->order_by("tbtt_showcart.shc_orderid","DESC");
        if (!empty($params['order_status'])) {
            $this->db->where('order_status', $params['order_status']);
        }
        if (!empty($params['search'])) {
            switch ($params['search']) {
                case 'orderid':
                    $this->db->where('shc_orderid', $params['keyword']);
                    break;
                case 'buyer':
                    $this->db->like('tbtt_user.use_username', $params['keyword']);
                    break;
                default:
                    break;
            }
        }

        if (!empty($params['filter'])) {
            $where = $params['where'];
            $this->db->where($where);
        }

        if (isset($params['payment_status']) && ($params['payment_status'] == 0 || $params['payment_status'] == 1)) {
            $this->db->where('payment_status', $params['payment_status']);
        }
        if (!empty($params['order_id'])) {
            // $this->db->where('tbtt_showcart.shc_orderid', $params['order_id']);
        }
        if (!empty($params['username'])) {
            // $this->db->like('use_fullname', $params['username']);
        }
        if (isset($params['pro_type'])) {
            $this->db->where('pro_type', $params['pro_type']);
        }
        if (isset($params['startMonth']) && isset($params['endMonth'])) {
            $this->db->where('tbtt_showcart.shc_change_status_date >= ', $params['startMonth']);
            $this->db->where('tbtt_showcart.shc_change_status_date <= ', $params['endMonth']);
        }
        if (isset($params['order_type']) && $params['order_type'] != '') {
            $this->db->where('pro_type', $params['order_type']);
        }
        if (isset($params['user_saler'])) {
            $this->db->where('order_saler', $params['user_saler']);
        }
        if ($params['is_count']) {
            $query = $this->db->get('tbtt_showcart');
            $result = $query->result();
            return count($result);

        } else {
            if (!empty($params['sort'])) {
                $this->db->order_by($params['sort'], $params['by']);
            }
            if (!empty($params['user'])) {
                // $this->db->order_by($params['sort'], $params['by']); 
            }
            if (!empty($params['date'])) {
                // $this->db->order_by($params['sort'], $params['by']); 
            }
            if (!empty($params['limit'])) {
                $this->db->limit($params['limit'], $params['start']);
                // $query = $this->db->get('tbtt_showcart');
            } else {
                // $query = $this->db->get('tbtt_showcart');
            }
            $query = $this->db->get('tbtt_showcart');
            //print_r($this->db->last_query());
            $result = $query->result();
            $query->free_result();
        }
        return $result;
    }

    function makeOrder($data)
    {
        $this->db->insert($this->_table, $data);
        return $this->db->insert_id();
    }

    function makeOrderCouponCode()
    {
        $codes = '';
        $strs = '123456789ABCDEFGHJKLMNPQRSTUVWXYZ';
        for ($i = 0; $i < 6; $i++) {
            $codes .= $strs[rand(0, strlen($strs) - 1)];
        }
        return $codes;
    }

    //by phuc nguyen
    public function getDetailOrders($where = NULL, $order = NULL, $limit = NULL, $offset = NULL, $total = NULL)
    {
        $this->db->cache_off();
        $this->db->select("tbl.af_id,tbl.*, product.*, showcart.*, rev.*, user.use_username, user.website, user.use_id, shop.sho_link, tdp.dp_images");
        $this->db->from('tbtt_order AS tbl');
        $this->db->join('tbtt_showcart AS showcart', 'showcart.shc_orderid = tbl.id');
        $this->db->join('tbtt_user_receive AS rev', 'rev.order_id = tbl.id');
        $this->db->join("tbtt_product AS product", "product.pro_id = showcart.shc_product");
        $this->db->join("tbtt_user AS user", "user.use_id = showcart.af_id", 'left');
        $this->db->join("tbtt_shop AS shop", "user.use_id = shop.sho_user", 'left');
        $this->db->join("tbtt_detail_product AS tdp", "tdp.`id` = showcart.shc_dp_pro_id", "left");

        if (isset($where['id'])) {
            $this->db->where('tbl.id', $where['id']);
        }

        if (isset($where['order_user'])) {
            $this->db->where('tbl.order_user', $where['order_user']);
        }

        if (isset($where['where']) && $where['where'] != '') {
            $this->db->where($where['where']);
        }

        if (isset($where['order_status'])) {
            $this->db->where('tbl.order_status', $where['order_status']);
        }

        if ($offset) {
            $this->db->limit($limit, $offset);
        } else if ($limit) {
            $this->db->limit($limit);
        }

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        if ($total) {
            return $query->num_rows();
        }
        return $query->result();
    }

    //Get list order by User and by product, by Bao Tran
    public function getDetailOrdersBySalerAndProduct($user_saler = NULL, $pro_id = NULL)
    {
        $this->db->cache_off();
        $this->db->select("tbl.*, product.*, showcart.*, rev.*, user.use_id, user.use_username, shop.sho_link");
        $this->db->from('tbtt_order AS tbl');
        $this->db->join('tbtt_showcart AS showcart', 'showcart.shc_orderid = tbl.id');
        $this->db->join('tbtt_user_receive AS rev', 'rev.order_id = tbl.id');
        $this->db->join("tbtt_product AS product", "product.pro_id = showcart.shc_product");
        $this->db->join("tbtt_user AS user", "user.use_id = showcart.af_id", 'left');
        $this->db->join("tbtt_shop AS shop", "user.use_id = shop.sho_user", 'left');

        $this->db->where('showcart.shc_saler', $user_saler);
        $this->db->where('showcart.shc_product', $pro_id);

        $query = $this->db->get();
        //echo $this->db->last_query();exit;
        $result = $query->result();
        $query->free_result();
        return $result;
    }

    public function countOrderCode($where)
    {
        $this->db->select("tbl.order_code");
        $this->db->from('tbtt_order AS tbl');
        if (isset($where['order_code']) && $where['order_code']) {
            $this->db->where('tbl.order_code', $where['order_code']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function updateOrderCode($OrderCode, $payment_status, $shc_saler, $order_id, $cancel_reason = NULL, $cancel_date = 0)
    {
        $change_status_date = time();
        $sql = "UPDATE `{$this->_table}` SET `cancel_date` = '{$cancel_date}',`cancel_reason` = '{$cancel_reason}', `order_clientCode` = '{$OrderCode}', `order_status` = '{$payment_status}', `change_status_date` = {$change_status_date} WHERE order_saler= '{$shc_saler}' AND id = '{$order_id}'";
        $this->db->query($sql);

        $sql = "UPDATE tbtt_showcart SET `shc_status` = '{$payment_status}', `shc_change_status_date` = {$change_status_date} WHERE shc_orderid = '{$order_id}'";
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    public function getListOrders($where = NULL, $order = NULL, $select = '*')
    {
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->from('tbtt_order');

        if (isset($where['order_status']) && $where['order_status']) {
            $this->db->where('order_status', $where['order_status']);
        }

        if (isset($where['order_id']) && $where['order_id']) {
            $this->db->where('id', $where['order_id']);
        }

        if (isset($where['order_status_delivery']) && $where['order_status_delivery']) {
            $this->db->where('order_status IN (03,05)');
        }

        if (isset($where['order_user'])) {
            $this->db->where('order_user', $where['order_user']);
        }
        if ($order) {
            $this->db->order_by($order['key'], $order['value']);
        }

        $query = $this->db->get();
        return $query->result();
    }    

    public function getListComplaintsOrders($where = NULL, $order = NULL, $select = 'tbl.*')
    {
        $this->db->cache_off();
        $this->db->select($select);
        $this->db->from('tbtt_changedelivery AS tbl');

        if (isset($where['status_id_delivery']) && $where['status_id_delivery']) {
            $this->db->where('status_id IN (01,02,03)');
        }

        if (isset($where['status_id_solved']) && $where['status_id_solved']) {
            $this->db->where('status_id IN (04)');
        }

        if (isset($where['user_id']) && $where['user_id'] > 0) {
            $this->db->where('shop_id = '. $where['user_id']);
        }

        if ($order) {
            $this->db->order_by($order['key'], $order['value']);
        }

        $query = $this->db->get();
        return $query->result();
    }

    public function getOrderStatistic($begin_date = NULL, $end_date = NULL)
    {
        $this->db->select('id');
        $this->db->from('tbtt_order');
        if (isset($begin_date) && $begin_date && isset($end_date) && $end_date) {
            $this->db->where('date >= ' . $begin_date . ' AND ' . ' date <= ' . $end_date);
        }
        $this->db->where('order_status', 98);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getSumOrderStatistic($begin_date = NULL, $end_date = NULL)
    {
        $this->db->select('SUM(order_total_no_shipping_fee) AS order_total');
        $this->db->from('tbtt_order');
        if (isset($begin_date) && $begin_date && isset($end_date) && $end_date) {
            $this->db->where('change_status_date >= ' . $begin_date . ' AND ' . ' change_status_date <= ' . $end_date);
        }

        $this->db->where('order_status', '98');

        $query = $this->db->get();
        $result = $query->result();
        if ($result[0]->order_total) {
            return $result[0]->order_total;
        } else {
            return '0';
        }
    }
    
    //Thong ke theo thang
    public function getOrderStatisticmonth($begin_date = NULL, $end_date = NULL)
    {
        $this->db->select('id');
        $this->db->from('tbtt_order');
        if (isset($begin_date) && $begin_date && isset($end_date) && $end_date) {
            $this->db->where('change_status_date >= ' . $begin_date . ' AND ' . 'change_status_date <= ' . $end_date);
        }
        $this->db->where('order_status', 98);
        $query = $this->db->get();
        return $query->num_rows();
    }

    //luu nguoi xu ly don hang
    public function updateUserProcess($order_id, $uid = 0)
    {
        $this->db->cache_off();
        $this->db->where('id', $order_id);
        $this->db->update('tbtt_order', array('user_process' => $uid));  
    }

    // update đơn hàng
    public function updateStatus($order_id, $status = 0, $token = '')
    {
        $this->db->cache_off();
        $this->db->where('id', $order_id);
        $dataUpdate = array('payment_status' => $status);
        if ($token != '') 
        {
           $dataUpdate['token'] = $token;
        }
        return $this->db->update('tbtt_order', $dataUpdate);
    }
}
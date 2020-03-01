<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/25/2015
 * Time: 15:21 PM
 */
class Af_product_model extends CI_Model
{
    var $_link = null;
    var $_afKey = '';
    var $_curLink = '';

    function __construct()
    {
        parent::__construct();
        $this->load->database();
        // Paginaiton defaults
        $this->pagination_enabled = FALSE;
        $this->pagination_per_page = 20;
        $this->pagination_num_links = 5;
        $this->pager = '';
        $this->filter = array('cat' => 0, 'q' => '', 'pf' => '', 'pt' => '', 'uid' => '');
        $this->_link = array(
            'product' => 'account/affiliate/products',
            'myproducts' => 'account/affiliate/myproducts',
            'profromshop' => 'account/profromshop'
        );
        /**
         *    bool $this->raw_data
         *    Used to decide what data should the SQL queries retrieve if tables are joined
         *     - TRUE:  just the field names of the items table
         *     - FALSE: related fields are replaced with the forign tables values
         *    Triggered to TRUE in the controller/edit method
         */
        $this->load->model('shop_category_model');
        $this->load->model("user_model");
    }

    function setCurLink($link)
    {
        $this->_curLink = $link;
    }

    function setAfKey($uid)
    {
        $this->db->select('af_key');
        $this->db->from('tbtt_user');
        $this->db->where('use_id', $uid);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            $this->_afKey = $row['af_key'];
        }
    }

    function get($id, $get_one = false)
    {
        $select_statement = '`pro_id`,`pro_name`';
        $this->db->select($select_statement);
        $this->db->from('tbtt_product');
        $this->db->limit(1, 0);
        // Pick one record
        // Field order sample may be empty because no record is requested, eg. create/GET event
        if ($get_one) {
            $this->db->limit(1, 0);
        } else // Select the desired record
        {
            $this->db->where('pro_id', $id);
        }
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            return array(
                'pro_id' => $row['pro_id'],
                'pro_name' => $row['pro_name'],
            );
        } else {
            return array();
        }
    }

    function lister($where = array(), $page = FALSE, $catSubStr = null)
    {
        $this->load->model("user_model");
        $this->db->cache_off();
        $user_detail = $this->user_model->get('*', "use_id IN(" . $where['use_id'] . ')');
        $this->db->flush_cache();
        $parent_detail = $this->user_model->get('*', "use_id IN(" . $user_detail->parent_id . ')');
        $this->setAfKey($where['use_id']);
        $this->db->cache_off();
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'name';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
        $this->filter['uid'] = isset($_REQUEST['uid']) ? (int)$_REQUEST['uid'] : 0;
        $this->filter['st'] = isset($_REQUEST['st']) ? (int)$_REQUEST['st'] : 0;
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;
        $this->filter['price_type'] = isset($_REQUEST['price_type']) ? (int)$_REQUEST['price_type'] : 1;
        $this->filter['garantee'] = isset($_REQUEST['garantee']) ? (int)$_REQUEST['garantee'] : 0;
        $this->filter['no_store'] = isset($_REQUEST['no_store']) ? (int)$_REQUEST['no_store'] : 0;
        //Filter price

        $priceFrom = isset($_REQUEST['pf']) ? $_REQUEST['pf'] : 0;
        if ($priceFrom > 0) {
            $this->filter['pf'] = $priceFrom;
        }
        $priceTo = isset($_REQUEST['pt']) ? $_REQUEST['pt'] : 0;
        if ($priceTo > 0) {
            $this->filter['pt'] = $priceTo;
        }
        $price = isset($_REQUEST['price']) ? $_REQUEST['price'] : '';
        if ($price != '') {
            $tmp = explode('-', $price);
            $this->filter['pf'] = $tmp[0];
            $this->filter['pt'] = $tmp[1];
        }
        switch ($this->filter['price_type']) {
            case 1:
                if (@$this->filter['pf'] > 0) {
                    $where['tbtt_product.pro_cost >='] = $this->filter['pf'];
                }
                if (@$this->filter['pt'] > 0) {
                    $where['tbtt_product.pro_cost <='] = $this->filter['pt'];
                }
                break;
            case 2:
                if (@$this->filter['pf'] > 0) {
                    $where['tbtt_product.af_amt >='] = $this->filter['pf'];
                }
                if (@$this->filter['pt'] > 0) {
                    $where['tbtt_product.af_amt <='] = $this->filter['pt'];
                }
                break;
            case 3:
                if (@$this->filter['pf'] > 0) {
                    $where['tbtt_product.af_rate >='] = $this->filter['pf'];
                }
                if (@$this->filter['pt'] > 0) {
                    $where['tbtt_product.af_rate <='] = $this->filter['pt'];
                }
                break;
        }

        $pro_type = isset($_REQUEST['product_type']) ? (int)$_REQUEST['product_type'] : 0;
        if (isset($pro_type)) {
            $this->filter['product_type'] = $pro_type;
            $where['tbtt_product.pro_type'] = $pro_type;
        }

        $catsub = isset($_REQUEST['cat_pro_0']) ? (int)$_REQUEST['cat_pro_0'] : 0;
        $catsub1 = isset($_REQUEST['cat_pro_1']) ? (int)$_REQUEST['cat_pro_1'] : 0;
        $catsub2 = isset($_REQUEST['cat_pro_2']) ? (int)$_REQUEST['cat_pro_2'] : 0;
        $catsub3 = isset($_REQUEST['cat_pro_3']) ? (int)$_REQUEST['cat_pro_3'] : 0;
        $catsub4 = isset($_REQUEST['cat_pro_4']) ? (int)$_REQUEST['cat_pro_4'] : 0;
        // Filter cat sub
        if ($catsub > 0 && (int)$catSubStr > 0) {
            $where_in = "tbtt_product.pro_category IN (" . $catSubStr . ")";
            $this->db->where($where_in);
            $this->filter['cat_pro_0'] = $catsub;
        }

        // Set filter
        if (trim($q) != '') {
            $searchString = $this->db->escape('%' . $q . '%');
            $this->db->where("(tbtt_product.`pro_name` LIKE  {$searchString} OR tbtt_shop.`sho_link` LIKE  {$searchString} OR tbtt_shop.`sho_name` LIKE  {$searchString}) ");
            $this->filter['q'] = trim($q);
        }
        $catName = '(SELECT `cat_name` FROM `tbtt_category` WHERE `cat_id` = tbtt_product.`pro_category`) as cName ';
        switch ($sort) {
            case 'name':
                $this->db->order_by("tbtt_product.`pro_name`", $dir);
                break;
            case 'price':
                $this->db->order_by("tbtt_product.`pro_cost`", $dir);
                break;
            case 'cat':
                $this->db->order_by("tbtt_category.cat_name", $dir);
                $catName = 'tbtt_category.cat_name as cName';
                break;
            case 'shop':
                $this->db->order_by("tbtt_shop.`sho_name`", $dir);
                break;
            case 'amt':
                $this->db->order_by("tbtt_product.`af_amt` + tbtt_product.`af_rate` * tbtt_product.`pro_cost` / 100", $dir);
                break;
            case 'af_amt':
                $this->db->order_by("tbtt_product.`af_amt`", $dir);
                break;
            case 'af_rate':
                $this->db->order_by("tbtt_product.`af_rate`", $dir);
                break;
        }

        $curTime = time();
        $where['tbtt_product.is_product_affiliate'] = 1;
        $where['tbtt_product.pro_status'] = 1;
        $where['tbtt_product.pro_user <> '] = $where['use_id'];

        /*if($where1!=''){
            if ($this->filter['no_store'] == 0) {
                $where['tbtt_product.pro_user'] = $where1;
            }elseif ($this->filter['no_store'] == 1) {
                $where['tbtt_product.pro_user <>'] = $where1;
            }
        }*/
        if ($parent_detail->use_group == 3 && $this->filter['no_store'] == 0) {
            $where['tbtt_product.pro_user'] = $parent_detail->use_id;
        } elseif ($parent_detail->use_group == 3 && $this->filter['no_store'] == 1) {
            $where['tbtt_product.pro_user <> '] = $parent_detail->use_id;
        } elseif ($parent_detail->use_group != 3 && $user_detail->parent_shop > 0 && $this->filter['no_store'] == 0) {
            $where['tbtt_product.pro_user'] = $user_detail->parent_shop;
        } elseif ($parent_detail->use_group != 3 && $user_detail->parent_shop > 0 && $this->filter['no_store'] == 1) {
            $where['tbtt_product.pro_user <> '] = $user_detail->parent_shop;
        }


        // Get only product of retailer shop
        $where['tbtt_shop.shop_type <> '] = 1;
        // Get only not select product

        if ($this->filter['garantee'] == 1) {
            $garantee = 'EXISTS (SELECT
                              pu.package_id
                            FROM
                              tbtt_package_user AS pu
                              LEFT JOIN tbtt_package AS p
                                ON pu.package_id = p.id
                              LEFT JOIN tbtt_package_info AS info
                                ON info.id = p.info_id
                            WHERE pu.user_id = tbtt_shop.sho_user
                                AND NOW() > pu.begined_date
                              AND NOW() < pu.ended_date
                              AND pu.payment_status = 1
                              AND pu.status = 1
                              AND info.pType = "package"
                              AND p.info_id >= 3)';
            $this->db->where($garantee, null, false);
        }
        $select = 'tbtt_product.`pro_id`
                  ,tbtt_product.`pro_name`
                  ,tbtt_product.`pro_user`
                  ,tbtt_product.`af_amt`
                  ,tbtt_product.`af_amt` + tbtt_product.`af_rate` * tbtt_product.`pro_cost` / 100 as amt
                  ,tbtt_product.`af_rate`
                  ,tbtt_product.`pro_cost`
                  ,tbtt_product.`pro_dir`
                  ,tbtt_product.`pro_image`
                  ,tbtt_product.`pro_category`
				  ,tbtt_shop.`sho_link` as linkshop
				  ,tbtt_shop.`sho_name` as nameshop
                  ,' . $catName;
        // Unset user id
        unset($where['use_id']);
        $this->db->select($select);
        $this->db->from('tbtt_product');
        $this->db->join('tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user');
        if ($sort == 'cat') {
            $this->db->join('tbtt_category', 'tbtt_category.cat_id = tbtt_product.pro_category');
        }
        $this->db->where($where);
        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $this->db->count_all_results();
            $config['base_url'] = base_url() . $this->_curLink;
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $this->buildLink(array("sort={$sort}", "dir={$dir}"));
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
            $this->db->limit($config['per_page'], $page);
        }
        // Get the results
        $query = $this->db->get();
        //  echo $this->db->last_query();die;
        $temp_result = array();
        foreach ($query->result_array() as $row) {
            $temp_result[] = array(
                'pro_id' => $row['pro_id'],
                'pro_name' => $row['pro_name'],
                'pro_user' => $row['pro_user'],
                'isselect' => $row['isselect'] > 0 ? TRUE : FALSE,
                'af_amt' => $row['af_amt'],
                'amt' => $row['amt'],
                'af_rate' => $row['af_rate'],
                'pro_cost' => $row['pro_cost'],
                'pro_dir' => $row['pro_dir'],
                'pro_image' => $row['pro_image'],
                'pro_category' => $row['pro_category'],
                'cName' => $row['cName'],
                'nameshop' => $row['nameshop'],
                'linkshop' => $row['linkshop'],
                'link' => base_url() . $row['pro_category'] . '/' . $row['pro_id'] . '/' . RemoveSign($row['pro_name']) . '/?af_id=' . $this->_afKey
            );
        }
        $this->db->flush_cache();
        return $temp_result;
    }

    
    function lister1($afId = '', $page = FALSE, $catSubStr = null)
    {
        $this->db->cache_off();
        $get_info = $this->user_model->get('use_id,parent_id, use_group', 'use_id = ' . (int)$afId);
        if ($get_info != '') {
            $get_p1 = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = "' . $get_info->parent_id . '"');
            // $get_p2 = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = "' . $get_p1->parent_id . '"');
            // $get_p3 = $this->user_model->get('use_group, use_username, parent_id, use_id', 'use_id = "' . $get_p2->parent_id . '"'); //lay cha thu 2
            // $get_p4 = $this->user_model->get('use_group, use_username, parent_id, use_id', 'use_id = "' . $get_p3->parent_id . '"'); //lay cha thu 3

        }
        $this->db->flush_cache();
        $this->db->cache_off();
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'name';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
        $this->filter['uid'] = isset($_REQUEST['uid']) ? (int)$_REQUEST['uid'] : 0;
        $this->filter['st'] = isset($_REQUEST['st']) ? (int)$_REQUEST['st'] : 0;
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;
        $this->filter['price_type'] = isset($_REQUEST['price_type']) ? (int)$_REQUEST['price_type'] : 1;
        $this->filter['garantee'] = isset($_REQUEST['garantee']) ? (int)$_REQUEST['garantee'] : 0;
        $this->filter['no_store'] = isset($_REQUEST['no_store']) ? (int)$_REQUEST['no_store'] : 0;
        //Filter price

        $priceFrom = isset($_REQUEST['pf']) ? $_REQUEST['pf'] : 0;
        if ($priceFrom > 0) {
            $this->filter['pf'] = $priceFrom;
        }
        $priceTo = isset($_REQUEST['pt']) ? $_REQUEST['pt'] : 0;
        if ($priceTo > 0) {
            $this->filter['pt'] = $priceTo;
        }
        $price = isset($_REQUEST['price']) ? $_REQUEST['price'] : '';
        if ($price != '') {
            $tmp = explode('-', $price);
            $this->filter['pf'] = $tmp[0];
            $this->filter['pt'] = $tmp[1];
        }


        $catsub = isset($_REQUEST['cat_pro_0']) ? (int)$_REQUEST['cat_pro_0'] : 0;
        $catsub1 = isset($_REQUEST['cat_pro_1']) ? (int)$_REQUEST['cat_pro_1'] : 0;
        $catsub2 = isset($_REQUEST['cat_pro_2']) ? (int)$_REQUEST['cat_pro_2'] : 0;
        $catsub3 = isset($_REQUEST['cat_pro_3']) ? (int)$_REQUEST['cat_pro_3'] : 0;
        $catsub4 = isset($_REQUEST['cat_pro_4']) ? (int)$_REQUEST['cat_pro_4'] : 0;
        // Filter cat sub
        if ($catsub > 0 && (int)$catSubStr > 0) {
            $where_in = "tbtt_product.pro_category IN (" . $catSubStr . ")";
            $this->db->where($where_in);
            $this->filter['cat_pro_0'] = $catsub;
        }

        // Set filter
        if (trim($q) != '') {
//            $searchString = $this->db->escape('"'.$q.'"');
            $searchString = '"' . $q . '"';
            $this->db->where("(tbtt_product.`pro_name` LIKE " . $searchString . " OR tbtt_shop.`sho_link` LIKE" . $searchString . " OR tbtt_shop.`sho_name` LIKE" . $searchString . ")");
            $this->filter['q'] = trim($q);
        }
        $catName = '(SELECT `cat_name` FROM `tbtt_category` WHERE `cat_id` = tbtt_product.`pro_category`) as cName ';
        switch ($sort) {
            case 'name':
                $this->db->order_by("tbtt_product.`pro_name`", $dir);
                break;
            case 'price':
                $this->db->order_by("tbtt_product.`pro_cost`", $dir);
                break;
            case 'cat':
                $this->db->order_by("tbtt_category.cat_name", $dir);
                $catName = 'tbtt_category.cat_name as cName';
                break;
            case 'shop':
                $this->db->order_by("tbtt_shop.`sho_name`", $dir);
                break;
            case 'amt':
                $this->db->order_by("tbtt_product.`af_amt` + tbtt_product.`af_rate` * tbtt_product.`pro_cost` / 100", $dir);
                break;
            case 'af_amt':
                $this->db->order_by("tbtt_product.`af_amt`", $dir);
                break;
            case 'af_rate':
                $this->db->order_by("tbtt_product.`af_rate`", $dir);
                break;
        }
        $curTime = time();
        if ($this->filter['no_store'] == 0) {
            $where = 'tbtt_product.pro_user =' . (int)$get_p1->use_id;
        } else {
            $where = 'tbtt_product.pro_user <> ' . (int)$get_p1->use_id; 
        }
        // if ($get_p3->use_group == StaffStoreUser) {
        //     if ($this->filter['no_store'] == 0) {
        //         $where = 'tbtt_product.pro_user IN(' . (int)$get_p2->use_id . ')';
        //     } else
        //         $where = 'tbtt_product.pro_user <> ' . (int)$get_p4->use_id; //Gh la cha cap 4 //GH-NVGH-CN-NV-AF
        // } else {

        //     if ($get_p2->use_group == AffiliateStoreUser || $get_p2->use_group == StaffStoreUser || $get_p2->use_group == BranchUser) {
        //         if ($get_p2->use_group == AffiliateStoreUser) {
        //             //Gh la cha cap 2
        //             if ($this->filter['no_store'] == 0) {
        //                 if ($get_p1->use_group == BranchUser) {
        //                     $where = 'tbtt_product.pro_user IN(' . (int)$get_p1->use_id . ')'; // GH-CN-Aff
        //                 } else {
        //                     $where = 'tbtt_product.pro_user = "' . (int)$get_p2->use_id . '"'; //GH-NVGH-AF, GH-NV-AF
        //                 }
        //             } else {
        //                 $where = 'tbtt_product.pro_user <>' . (int)$get_p2->use_id;
        //             }
        //         } else {
        //             $afId = (int)$get_p3->use_id; //Gh la cha cap 3
        //             if ($this->filter['no_store'] == 0) {
        //                 if ($get_p2->use_group == BranchUser) {
        //                     $where = 'tbtt_product.pro_user IN(' . (int)$get_p2->use_id . ')'; //GH-CN-NV-AF
        //                 } else {
        //                     if ($get_p1->use_group == StaffUser) {
        //                         $where = 'tbtt_product.pro_user IN(' . (int)$get_p3->use_id . ')'; //GH-NVGH-NV-AF
        //                     } else {
        //                         $where = 'tbtt_product.pro_user IN(' . (int)$get_p1->use_id . ')'; //GH-NVGH-CN-AF
        //                     }
        //                 }
        //             } else {
        //                 $where = 'tbtt_product.pro_user <>' . (int)$get_p3->use_id;
        //             }
        //         }
        //     } else {
        //         if ($get_p2->use_group == StaffStoreUser) {
        //             $afId = (int)$get_p3->use_id . ',' . (int)$get_p1->use_id; // GH-NVGH-CN-AF
        //             $body['pro_user'] = $get_p1->use_id;
        //         } else {
        //             if ($this->filter['no_store'] == 0) {
        //                 $where = 'tbtt_product.pro_user IN( ' . $get_p1->use_id . ' )';
        //             } else {
        //                 $where = 'tbtt_product.pro_user <>' . (int)$get_p1->use_id;
        //             }
        //         }
        //     }
        // }

        $where .= ' AND tbtt_shop.shop_type <> 1 AND is_product_affiliate = 1 AND pro_status=1';
        // Get only product of retailer shop
        if ($this->filter['pf'] != '' && $this->filter['pt'] != '') {
            switch ($this->filter['price_type']) {
                case 1:
                    $where .= ' AND ( tbtt_product.pro_cost BETWEEN ' . $this->filter['pf'] . ' AND ' . $this->filter['pt'] . ')';
                    break;
                case 2:
                    $where .= ' AND ( tbtt_product.af_amt BETWEEN ' . $this->filter['pf'] . ' AND ' . $this->filter['pt'] . ')';
                    break;
                case 3:
                    $where .= ' AND ( tbtt_product.af_rate BETWEEN ' . $this->filter['pf'] . ' AND ' . $this->filter['pt'] . ')';
                    break;
            }
        }
        $pro_type = isset($_REQUEST['product_type']) ? (int)$_REQUEST['product_type'] : 0;
        if (isset($pro_type)) {
            $this->filter['product_type'] = $pro_type;
            $where .= ' AND tbtt_product.pro_type = ' . $pro_type;
        } else {
            $where .= ' AND tbtt_product.pro_type = 0';
        }


        // Get only not select product

        if ($this->filter['garantee'] == 1) {
            $garantee = 'EXISTS (SELECT
                              pu.package_id
                            FROM
                              tbtt_package_user AS pu
                              LEFT JOIN tbtt_package AS p
                                ON pu.package_id = p.id
                              LEFT JOIN tbtt_package_info AS info
                                ON info.id = p.info_id
                            WHERE pu.user_id = tbtt_shop.sho_user
                                AND NOW() > pu.begined_date
                              AND NOW() < pu.ended_date
                              AND pu.payment_status = 1
                              AND pu.status = 1
                              AND info.pType = "package"
                              AND p.info_id >= 3)';
            $this->db->where($garantee, null, false);
        }
        $select = 'tbtt_product.`pro_id`
                  ,tbtt_product.`pro_name`
                  ,tbtt_product.`pro_user`
                  ,tbtt_product.`af_amt`
                  ,tbtt_product.`af_amt` + tbtt_product.`af_rate` * tbtt_product.`pro_cost` / 100 as amt
                  ,tbtt_product.`af_rate`
                  ,tbtt_product.`pro_cost`
                  ,tbtt_product.`pro_dir`
                  ,tbtt_product.`pro_image`
                  ,tbtt_product.`pro_category`
                  ,tbtt_shop.`sho_link` as linkshop
                  ,tbtt_shop.`sho_name` as nameshop
                  ,tbtt_shop.`domain`
                  ,' . $catName;
        // Unset user id
        // unset($where['use_id']);
        $this->db->select($select);
        $this->db->from('tbtt_product');
        $this->db->join('tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user');
        if ($sort == 'cat') {
            $this->db->join('tbtt_category', 'tbtt_category.cat_id = tbtt_product.pro_category');
        }
        $this->db->where($where);
        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $this->db->count_all_results();
            $config['base_url'] = base_url() . $this->_curLink;
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $this->buildLink(array("sort={$sort}", "dir={$dir}"));
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
            $this->db->limit($config['per_page'], $page);
        }
        // Get the results
        $query = $this->db->get();
        $temp_result = array();
        foreach ($query->result_array() as $row) {
            $temp_result[] = array(
                'pro_id' => $row['pro_id'],
                'pro_name' => $row['pro_name'],
                'pro_user' => $row['pro_user'],
                'isselect' => (isset($row['isselect']) && $row['isselect'] > 0) ? TRUE : FALSE,
                'af_amt' => $row['af_amt'],
                'amt' => $row['amt'],
                'af_rate' => $row['af_rate'],
                'pro_cost' => $row['pro_cost'],
                'pro_dir' => $row['pro_dir'],
                'pro_image' => $row['pro_image'],
                'pro_category' => $row['pro_category'],
                'cName' => $row['cName'],
                'nameshop' => $row['nameshop'],
                'linkshop' => $row['linkshop'],
                'domain' => $row['domain'],
                'link' => base_url() . $row['pro_category'] . '/' . $row['pro_id'] . '/' . RemoveSign($row['pro_name']) . '/?af_id=' . $this->_afKey
            );
        }
        $this->db->flush_cache();
//          echo $this->db->last_query();
        return $temp_result;
    }
    function SelectListFromShop($where = array(), $page = FALSE, $catSubStr = null)
    {
        $this->load->model("user_model");
        $this->db->cache_off();
        $user_detail = $this->user_model->get('*', "use_id = " . $where['use_id']);
        $this->db->flush_cache();
        $parent_detail = $this->user_model->get('*', "use_id = " . $user_detail->parent_id);
        $this->setAfKey($where['use_id']);
        $this->db->cache_off();
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'pro_id';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'desc';
        $this->filter['uid'] = isset($_REQUEST['uid']) ? (int)$_REQUEST['uid'] : 0;
        $this->filter['st'] = isset($_REQUEST['st']) ? (int)$_REQUEST['st'] : 0;
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;
        $this->filter['price_type'] = isset($_REQUEST['price_type']) ? (int)$_REQUEST['price_type'] : 1;
        $this->filter['garantee'] = isset($_REQUEST['garantee']) ? (int)$_REQUEST['garantee'] : 0;
        $this->filter['no_store'] = isset($_REQUEST['no_store']) ? (int)$_REQUEST['no_store'] : 0;
            //Filter price

        $priceFrom = isset($_REQUEST['pf']) ? $_REQUEST['pf'] : 0;
        if ($priceFrom > 0) {
            $this->filter['pf'] = $priceFrom;
        }
        $priceTo = isset($_REQUEST['pt']) ? $_REQUEST['pt'] : 0;
        if ($priceTo > 0) {
            $this->filter['pt'] = $priceTo;
        }
        $price = isset($_REQUEST['price']) ? $_REQUEST['price'] : '';
        if ($price != '') {
            $tmp = explode('-', $price);
            $this->filter['pf'] = $tmp[0];
            $this->filter['pt'] = $tmp[1];
        }
        switch ($this->filter['price_type']) {
            case 1:
                if (@$this->filter['pf'] > 0) {
                    $where['tbtt_product.pro_cost >='] = $this->filter['pf'];
                }
                if (@$this->filter['pt'] > 0) {
                    $where['tbtt_product.pro_cost <='] = $this->filter['pt'];
                }
                break;
            case 2:
                if (@$this->filter['pf'] > 0) {
                    $where['tbtt_product.af_amt >='] = $this->filter['pf'];
                }
                if (@$this->filter['pt'] > 0) {
                    $where['tbtt_product.af_amt <='] = $this->filter['pt'];
                }
                break;
            case 3:
                if (@$this->filter['pf'] > 0) {
                    $where['tbtt_product.af_rate >='] = $this->filter['pf'];
                }
                if (@$this->filter['pt'] > 0) {
                    $where['tbtt_product.af_rate <='] = $this->filter['pt'];
                }
                break;
        }

        if ($this->uri->segment(2) == 'coufromshop') {
            $where['tbtt_product.pro_type'] = 2;
        } elseif ($this->uri->segment(2) == 'profromshop') {
            $where['tbtt_product.pro_type'] = 0;
        }

        $catsub = isset($_REQUEST['cat_pro_0']) ? (int)$_REQUEST['cat_pro_0'] : 0;
        $catsub1 = isset($_REQUEST['cat_pro_1']) ? (int)$_REQUEST['cat_pro_1'] : 0;
        $catsub2 = isset($_REQUEST['cat_pro_2']) ? (int)$_REQUEST['cat_pro_2'] : 0;
        $catsub3 = isset($_REQUEST['cat_pro_3']) ? (int)$_REQUEST['cat_pro_3'] : 0;
        $catsub4 = isset($_REQUEST['cat_pro_4']) ? (int)$_REQUEST['cat_pro_4'] : 0;
        // Filter cat sub
        if ($catsub > 0 && (int)$catSubStr > 0) {
            $where_in = "tbtt_product.pro_category IN (" . $catSubStr . ")";
            $this->db->where($where_in);
            $this->filter['cat_pro_0'] = $catsub;
        }

        // Set filter
        if (trim($q) != '') {
            $searchString = $this->db->escape('%' . $q . '%');
            $this->db->where("(tbtt_product.`pro_name` LIKE  {$searchString} OR tbtt_shop.`sho_link` LIKE  {$searchString} OR tbtt_shop.`sho_name` LIKE  {$searchString}) ");
            $this->filter['q'] = trim($q);
        }
        $catName = '(SELECT `cat_name` FROM `tbtt_category` WHERE `cat_id` = tbtt_product.`pro_category`) as cName ';
        switch ($sort) {
            case 'name':
                $this->db->order_by("tbtt_product.`pro_name`", $dir);
                break;
            case 'price':
                $this->db->order_by("tbtt_product.`pro_cost`", $dir);
                break;
            case 'cat':
                $this->db->order_by("tbtt_category.cat_name", $dir);
                $catName = 'tbtt_category.cat_name as cName';
                break;
            case 'shop':
                $this->db->order_by("tbtt_shop.`sho_name`", $dir);
                break;
            case 'amt':
                $this->db->order_by("tbtt_product.`af_amt` + tbtt_product.`af_rate` * tbtt_product.`pro_cost` / 100", $dir);
                break;
            case 'af_amt':
                $this->db->order_by("tbtt_product.`af_amt`", $dir);
                break;
            case 'af_rate':
                $this->db->order_by("tbtt_product.`af_rate`", $dir);
                break;
            default:
                $this->db->order_by("tbtt_product.`pro_id`", $dir); //Add
                break;
        }

        $curTime = time();
        //$where['tbtt_product.is_product_affiliate'] = 1;
        $where['tbtt_product.pro_status'] = 1;
        $where['tbtt_product.pro_user <> '] = $where['use_id'];
        if ($parent_detail->use_group == 3 && $this->filter['no_store'] == 0) {
            $where['tbtt_product.pro_user'] = $parent_detail->use_id;
        } elseif ($parent_detail->use_group == 3 && $this->filter['no_store'] == 1) {
            $where['tbtt_product.pro_user <> '] = $parent_detail->use_id;
        } elseif ($parent_detail->use_group != 3 && $user_detail->parent_shop > 0 && $this->filter['no_store'] == 0) {
            $where['tbtt_product.pro_user'] = $user_detail->parent_shop;
        } elseif ($parent_detail->use_group != 3 && $user_detail->parent_shop > 0 && $this->filter['no_store'] == 1) {
            //$where['tbtt_product.pro_user <> '] = $user_detail->parent_shop;
        }

        // Get only product of retailer shop
        //$where['tbtt_shop.shop_type <> '] = 1;
        // Get only not select product       

        if ($this->filter['garantee'] == 1) {
            $garantee = 'EXISTS (SELECT
                              pu.package_id
                            FROM
                              tbtt_package_user AS pu
                              LEFT JOIN tbtt_package AS p
                                ON pu.package_id = p.id
                              LEFT JOIN tbtt_package_info AS info
                                ON info.id = p.info_id
                            WHERE pu.user_id = tbtt_shop.sho_user
                                AND NOW() > pu.begined_date
                              AND NOW() < pu.ended_date
                              AND pu.payment_status = 1
                              AND pu.status = 1
                              AND info.pType = "package"
                              AND p.info_id >= 3)';
            $this->db->where($garantee, null, false);
        }
        $select = 'tbtt_product.`pro_id`
                  ,tbtt_product.`pro_name`
                  ,tbtt_product.`pro_user`
                  ,tbtt_product.`af_amt`
                  ,tbtt_product.`af_amt` + tbtt_product.`af_rate` * tbtt_product.`pro_cost` / 100 as amt
                  ,tbtt_product.`af_rate`
                  ,tbtt_product.`pro_cost`
                  ,tbtt_product.`pro_instock`
                  ,tbtt_product.`pro_dir`
                  ,tbtt_product.`pro_image`
                  ,tbtt_product.`pro_category`
                  ,tbtt_shop.`sho_link` as linkshop
                  ,tbtt_shop.`sho_name` as nameshop
                  ,' . $catName;
        // Unset user id
        unset($where['use_id']);
        $this->db->select($select);
        $this->db->from('tbtt_product');
        $this->db->join('tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user');
        if ($sort == 'cat') {
            $this->db->join('tbtt_category', 'tbtt_category.cat_id = tbtt_product.pro_category');
        }
        $this->db->where($where);
        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $this->db->count_all_results();
            $config['base_url'] = base_url() . $this->_curLink;
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $this->buildLink(array("sort={$sort}", "dir={$dir}"));
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
            $this->db->limit($config['per_page'], $page);
        }
        // Get the results
        $query = $this->db->get();
        // echo $this->db->last_query();die;
        $temp_result = array();
        foreach ($query->result_array() as $row) {
            $temp_result[] = array(
                'pro_id' => $row['pro_id'],
                'pro_name' => $row['pro_name'],
                'pro_user' => $row['pro_user'],
                'isselect' => $row['isselect'] > 0 ? TRUE : FALSE,
                'af_amt' => $row['af_amt'],
                'amt' => $row['amt'],
                'af_rate' => $row['af_rate'],
                'pro_cost' => $row['pro_cost'],
                'pro_instock' => $row['pro_instock'],
                'pro_dir' => $row['pro_dir'],
                'pro_image' => $row['pro_image'],
                'pro_category' => $row['pro_category'],
                'cName' => $row['cName'],
                'nameshop' => $row['nameshop'],
                'linkshop' => $row['linkshop'],
                'link' => base_url() . $row['pro_category'] . '/' . $row['pro_id'] . '/' . RemoveSign($row['pro_name']) . '/?af_id=' . $this->_afKey
            );
        }
        $this->db->flush_cache();
        return $temp_result;
    }

    function myNumberProduct($afID)
    {
        $number = 0;
        if ($afID > 0) {
            $q = "SELECT count(pro_id) AS number FROM tbtt_product_affiliate_user WHERE use_id IN($afID) AND pro_id <> 1";
            $query = $this->db->query($q);
            $result = $query->result();
            $number = $result[0]->number;
        }
        return $number;
    }

    function myProduct($where = array(), $page = FALSE)
    {
        $this->setAfKey($where['use_id']);
        $this->db->cache_off();
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'name';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
        $this->filter['uid'] = isset($_REQUEST['uid']) ? (int)$_REQUEST['uid'] : 0;
        $this->filter['st'] = isset($_REQUEST['st']) ? (int)$_REQUEST['st'] : 0;
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;
        $this->filter['price_type'] = isset($_REQUEST['price_type']) ? (int)$_REQUEST['price_type'] : 1;
        $this->filter['product_type'] = isset($_REQUEST['product_type']) ? (int)$_REQUEST['product_type'] : '';
        $this->filter['garantee'] = isset($_REQUEST['garantee']) ? (int)$_REQUEST['garantee'] : 0;
        //Filter price
        $priceFrom = isset($_REQUEST['pf']) ? $_REQUEST['pf'] : 0;
        if ($priceFrom > 0) {
            $this->filter['pf'] = $priceFrom;
        }
        $priceTo = isset($_REQUEST['pt']) ? $_REQUEST['pt'] : 0;
        if ($priceTo > 0) {
            $this->filter['pt'] = $priceTo;
        }
        $price = isset($_REQUEST['price']) ? $_REQUEST['price'] : '';
        if ($price != '') {
            $tmp = explode('-', $price);
            $this->filter['pf'] = $tmp[0];
            $this->filter['pt'] = $tmp[1];
        }
        switch ($this->filter['price_type']) {
            case 1:
                if (@$this->filter['pf'] > 0) {
                    $where['tbtt_product.pro_cost >='] = $this->filter['pf'];
                }
                if (@$this->filter['pt'] > 0) {
                    $where['tbtt_product.pro_cost <='] = $this->filter['pt'];
                }
                break;
            case 2:
                if (@$this->filter['pf'] > 0) {
                    $where['tbtt_product.af_amt >='] = $this->filter['pf'];
                }
                if (@$this->filter['pt'] > 0) {
                    $where['tbtt_product.af_amt <='] = $this->filter['pt'];
                }
                break;
            case 3:
                if (@$this->filter['pf'] > 0) {
                    $where['tbtt_product.af_rate >='] = $this->filter['pf'];
                }
                if (@$this->filter['pt'] > 0) {
                    $where['tbtt_product.af_rate <='] = $this->filter['pt'];
                }
                break;
        }
        switch ($this->filter['product_type']) {
            case 0:
                $where['tbtt_product.pro_type'] = 0;
                break;
            case 1:
                $where['tbtt_product.pro_type'] = 1;
                break;
            case 2:
                $where['tbtt_product.pro_type'] = 2;
                break;
        }

        $cat = isset($_REQUEST['cat']) ? (int)$_REQUEST['cat'] : 0;
        if ($cat > 0) {
            $where['tbtt_product.pro_category'] = $cat;
            $this->filter['cat'] = $cat;
        }
        //tung edit
        $catshop = isset($_REQUEST['catshop']) ? (int)$_REQUEST['catshop'] : 0;
        if ($catshop > 0) {
            $where['tbtt_shop.sho_category'] = $catshop;
            $this->filter['catshop'] = $catshop;
        }
        // Get only product of retailer shop
        $where['tbtt_shop.shop_type <> '] = 1;
        // Set filter
        if (trim($q) != '') {
            $searchString = $this->db->escape('%' . $q . '%');
            $this->db->where("(tbtt_product.`pro_name` LIKE  {$searchString} OR tbtt_shop.`sho_link` LIKE  {$searchString} OR tbtt_shop.`sho_name` LIKE  {$searchString}) ");
            $this->filter['q'] = trim($q);
        }
        $catName = '(SELECT `cat_name` FROM `tbtt_category` WHERE `cat_id` = tbtt_product.`pro_category`) as cName';
        switch ($sort) {
            case 'name':
                $this->db->order_by("tbtt_product.`pro_name`", $dir);
                break;
            case 'price':
                $this->db->order_by("tbtt_product.`pro_cost`", $dir);
                break;
            case 'cat':
                $this->db->order_by("tbtt_category.cat_name", $dir);
                $catName = 'tbtt_category.cat_name as cName';
                break;
            case 'shop':
                $this->db->order_by("tbtt_shop.`sho_name`", $dir);
                break;
            case 'amt':
                $this->db->order_by("tbtt_product.`af_amt` + tbtt_product.`af_rate` * tbtt_product.`pro_cost` / 100", $dir);
                break;
            case 'af_amt':
                $this->db->order_by("tbtt_product.`af_amt`", $dir);
                break;
            case 'af_rate':
                $this->db->order_by("tbtt_product.`af_rate`", $dir);
                break;
        }
        $curTime = time();
        $where['tbtt_product.is_product_affiliate'] = 1;
        $where['tbtt_product.pro_status'] = 1;
        //$where['tbtt_product.pro_begindate <= '] = $curTime;
        //$where['tbtt_product.pro_enddate >= '] = $curTime;
        $select = 'tbtt_product.`pro_id`
                  ,tbtt_product.`pro_name`
                  ,tbtt_product.`af_amt`
                  ,tbtt_product.`af_amt` + tbtt_product.`af_rate` * tbtt_product.`pro_cost` / 100 as amt
                  ,tbtt_product.`af_rate`
                  ,tbtt_product.`pro_cost`
                  ,tbtt_product.`pro_dir`
                  ,tbtt_product.`pro_image`
                  ,tbtt_product.`pro_category`
                  ,tbtt_product_affiliate_user.`homepage`
				  ,tbtt_shop.`sho_link` as linkshop
				  ,tbtt_shop.`sho_name` as nameshop
                  ,' . $catName;
        $where['tbtt_product_affiliate_user.use_id'] = $where['use_id'];
        $this->db->where('tbtt_product.pro_id is not NULL', null);
        if ($this->filter['garantee'] == 1) {
            $garantee = 'EXISTS (SELECT
                              pu.package_id
                            FROM
                              tbtt_package_user AS pu
                              LEFT JOIN tbtt_package AS p
                                ON pu.package_id = p.id
                              LEFT JOIN tbtt_package_info AS info
                                ON info.id = p.info_id
                            WHERE pu.user_id = tbtt_shop.sho_user
                                AND NOW() > pu.begined_date
                              AND NOW() < pu.ended_date
                              AND pu.payment_status = 1
                              AND pu.status = 1
                              AND info.pType = "package"
                              AND p.info_id >= 3)';
            $this->db->where($garantee, null, false);
        }
        // Unset user id
        unset($where['use_id']);
        $this->db->select($select);
        $this->db->from('tbtt_product_affiliate_user');
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_product_affiliate_user.pro_id');
        $this->db->join('tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user');
        $this->db->where($where);
        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $this->db->count_all_results();
            $config['base_url'] = base_url() . $this->_curLink;
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $this->buildLink(array("sort={$sort}", "dir={$dir}"));
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
            $this->db->limit($config['per_page'], $page);
        }
        // Get the results
        $query = $this->db->get();       
        $temp_result = array();
        foreach ($query->result_array() as $row) {
            $temp_result[] = array(
                'pro_id' => $row['pro_id'],
                'pro_name' => $row['pro_name'],
                'isselect' => TRUE,
                'af_amt' => $row['af_amt'],
                'amt' => $row['amt'],
                'af_rate' => $row['af_rate'],
                'pro_cost' => $row['pro_cost'],
                'pro_dir' => $row['pro_dir'],
                'pro_image' => $row['pro_image'],
                'pro_category' => $row['pro_category'],
                'homepage' => $row['homepage'],
                'cName' => $row['cName'],
                'nameshop' => $row['nameshop'],
                'linkshop' => $row['linkshop'],
                'link' => base_url() . $row['pro_category'] . '/' . $row['pro_id'] . '/' . RemoveSign($row['pro_name']) . '?af_id=' . $this->_afKey
            );
        }
        $query->free_result();
        $this->db->flush_cache();
        return $temp_result;
    }
    function myProduct1($select = "*", $afKey, $join_1, $table_1, $on_1, $join_2, $table_2, $on_2, $where = "", $order = "", $by = "DESC", $start = -1, $limit = 0, $distinct = false, $page = FALSE)
    {        
        $this->setAfKey($afKey);
        $this->db->cache_off();
        $this->db->start_cache();        
        $this->db->from('tbtt_product');
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
        
        if ($distinct && $distinct == true) {
            $this->db->distinct();            
        }
       
        if ($this->pagination_enabled == TRUE) {            
            $config = array();
            $config['cur_page'] = $page;            
            $config['total_rows'] = $this->db->count_all_results();
            $config['base_url'] = base_url() . $this->_curLink;
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $this->buildLink(array("sort={$sort}", "dir={$dir}"));
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
            $this->db->limit($config['per_page'], $page);
        }

        #Query        
        $query = $this->db->get();
        $result = array();
        $result['data'] = $query->result();
        $result['setAfKey'] = $this->_afKey;
        $this->db->flush_cache();
        $query->free_result();
        return $result;
    }

    function pressProduct($where = array(), $page = FALSE)
    {
        $this->setAfKey($where['use_id']);
        $this->db->cache_off();
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'name';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
        $this->filter['uid'] = isset($_REQUEST['uid']) ? (int)$_REQUEST['uid'] : 0;
        $this->filter['st'] = isset($_REQUEST['st']) ? (int)$_REQUEST['st'] : 0;
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;
        $this->filter['price_type'] = isset($_REQUEST['price_type']) ? (int)$_REQUEST['price_type'] : 1;
        $this->filter['garantee'] = isset($_REQUEST['garantee']) ? (int)$_REQUEST['garantee'] : 0;
        //Filter price
        $priceFrom = isset($_REQUEST['pf']) ? $_REQUEST['pf'] : 0;
        if ($priceFrom > 0) {
            $this->filter['pf'] = $priceFrom;
        }
        $priceTo = isset($_REQUEST['pt']) ? $_REQUEST['pt'] : 0;
        if ($priceTo > 0) {
            $this->filter['pt'] = $priceTo;
        }
        $price = isset($_REQUEST['price']) ? $_REQUEST['price'] : '';
        if ($price != '') {
            $tmp = explode('-', $price);
            $this->filter['pf'] = $tmp[0];
            $this->filter['pt'] = $tmp[1];
        }
        switch ($this->filter['price_type']) {
            case 1:
                if (@$this->filter['pf'] > 0) {
                    $where['tbtt_product.pro_cost >='] = $this->filter['pf'];
                }
                if (@$this->filter['pt'] > 0) {
                    $where['tbtt_product.pro_cost <='] = $this->filter['pt'];
                }
                break;
            case 2:
                if (@$this->filter['pf'] > 0) {
                    $where['tbtt_product.af_amt >='] = $this->filter['pf'];
                }
                if (@$this->filter['pt'] > 0) {
                    $where['tbtt_product.af_amt <='] = $this->filter['pt'];
                }
                break;
            case 3:
                if (@$this->filter['pf'] > 0) {
                    $where['tbtt_product.af_rate >='] = $this->filter['pf'];
                }
                if (@$this->filter['pt'] > 0) {
                    $where['tbtt_product.af_rate <='] = $this->filter['pt'];
                }
                break;
        }
        $cat = isset($_REQUEST['cat']) ? (int)$_REQUEST['cat'] : 0;
        if ($cat > 0) {
            $where['tbtt_product.pro_category'] = $cat;
            $this->filter['cat'] = $cat;
        }
        //tung edit
        $catshop = isset($_REQUEST['catshop']) ? (int)$_REQUEST['catshop'] : 0;
        if ($catshop > 0) {
            $where['tbtt_shop.sho_category'] = $catshop;
            $this->filter['catshop'] = $catshop;
        }
        // Get only product of retailer shop
        $where['tbtt_shop.shop_type <> '] = 1;
        // Set filter
        if (trim($q) != '') {
            $searchString = $this->db->escape('%' . $q . '%');
            $this->db->where("(tbtt_product.`pro_name` LIKE  {$searchString} OR tbtt_shop.`sho_link` LIKE  {$searchString} OR tbtt_shop.`sho_name` LIKE  {$searchString}) ");
            $this->filter['q'] = trim($q);
        }
        $catName = '(SELECT `cat_name` FROM `tbtt_category` WHERE `cat_id` = tbtt_product.`pro_category`) as cName';
        switch ($sort) {
            case 'name':
                $this->db->order_by("tbtt_product.`pro_name`", $dir);
                break;
            case 'price':
                $this->db->order_by("tbtt_product.`pro_cost`", $dir);
                break;
            case 'cat':
                $this->db->order_by("tbtt_category.cat_name", $dir);
                $catName = 'tbtt_category.cat_name as cName';
                break;
            case 'shop':
                $this->db->order_by("tbtt_shop.`sho_name`", $dir);
                break;
            case 'amt':
                $this->db->order_by("tbtt_product.`af_amt` + tbtt_product.`af_rate` * tbtt_product.`pro_cost` / 100", $dir);
                break;
            case 'af_amt':
                $this->db->order_by("tbtt_product.`af_amt`", $dir);
                break;
            case 'af_rate':
                $this->db->order_by("tbtt_product.`af_rate`", $dir);
                break;
        }
        $curTime = date('Y-m-d');
        $where['tbtt_product.is_product_affiliate'] = 1;
        $where['tbtt_product.pro_status'] = 1;
        //$where['tbtt_product.pro_begindate <= '] = $curTime;
        //$where['tbtt_product.pro_enddate >= '] = $curTime;
        $select = 'tbtt_product.`pro_id`
                  ,tbtt_product.`pro_name`
                  ,tbtt_product.`af_amt`
                  ,tbtt_product.`af_amt` + tbtt_product.`af_rate` * tbtt_product.`pro_cost` / 100 as amt
                  ,tbtt_product.`af_rate`
                  ,tbtt_product.`pro_cost`
                  ,tbtt_product.`pro_dir`
                  ,tbtt_product.`pro_image`
                  ,tbtt_product.`pro_category`
                  ,tbtt_product_press_af.`begin_date`
				  ,tbtt_shop.`sho_link` as linkshop
				  ,tbtt_shop.`sho_name` as nameshop
                  ,' . $catName;

        $where['tbtt_product_press_af.user_id_af LIKE'] = '%,' . $where['use_id'] . ',%';
        //  $where['tbtt_product_press_af.pro_begindate >= '] = $curTime;
        $this->db->where('tbtt_product.pro_id is not NULL', null);

        // Unset user id
        unset($where['use_id']);
        $this->db->select($select);
        $this->db->from('tbtt_product_press_af');
        $this->db->join('tbtt_product', 'tbtt_product.pro_id = tbtt_product_press_af.pro_id');
        $this->db->join('tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user');
        $this->db->where($where);
        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $this->db->count_all_results();
            $config['base_url'] = base_url() . $this->_curLink;
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $this->buildLink(array("sort={$sort}", "dir={$dir}"));
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
            $this->db->limit($config['per_page'], $page);
        }
        // Get the results
        $query = $this->db->get();
        // echo $this->db->last_query();
        $temp_result = array();
        foreach ($query->result_array() as $row) {
            $temp_result[] = array(
                'pro_id' => $row['pro_id'],
                'pro_name' => $row['pro_name'],
                'isselect' => TRUE,
                'af_amt' => $row['af_amt'],
                'amt' => $row['amt'],
                'af_rate' => $row['af_rate'],
                'pro_cost' => $row['pro_cost'],
                'pro_dir' => $row['pro_dir'],
                'pro_image' => $row['pro_image'],
                'pro_category' => $row['pro_category'],
                'begin_date' => $row['begin_date'],
                'cName' => $row['cName'],
                'nameshop' => $row['nameshop'],
                'linkshop' => $row['linkshop'],
                'link' => base_url() . $row['pro_category'] . '/' . $row['pro_id'] . '/' . RemoveSign($row['pro_name']) . '?af_id=' . $this->_afKey
            );
        }
        $query->free_result();
        $this->db->flush_cache();
        return $temp_result;
    }

    function pagination($bool)
    {
        $this->pagination_enabled = ($bool === TRUE) ? TRUE : FALSE;
    }

    function getSort()
    {
        return array(
            array('id' => 1, 'text' => 'Tên sản phẩm: A->Z', 'link' => $this->buildLink(array('sort=name', 'dir=asc'))),
            array('id' => 1, 'text' => 'Tên sản phẩm: Z->A', 'link' => $this->buildLink(array('sort=name', 'dir=desc'))),
            array('id' => 1, 'text' => 'Giá: từ cao tới thấp', 'link' => $this->buildLink(array('sort=price', 'dir=desc'))),
            array('id' => 2, 'text' => 'Giá: từ thấp tới cao', 'link' => $this->buildLink(array('sort=price', 'dir=asc')))
        );
    }

    function buildLink($parrams, $issort = false)
    {
        if ($issort == true) {
            unset($this->filter['sort']);
            unset($this->filter['dir']);
        }
        foreach ($this->filter as $key => $val) {
            if ($val != '') {
                array_unshift($parrams, $key . '=' . $val);
            }
        }
        return '?' . implode('&', $parrams);
    }

    function getAdminSort()
    {
        $sortField = array('name', 'price', 'amt', 'rate', 'shop', 'cat', 'amt', 'username', 'email', 'group', 'creatdate', 'status', 'af_amt', 'af_rate', 'doanhso', 'logindate');
        $data = array();
        foreach ($sortField as $item) {
            $data[$item]['asc'] = $this->buildLink(array('sort=' . $item, 'dir=asc'), true);
            $data[$item]['desc'] = $this->buildLink(array('sort=' . $item, 'dir=desc'), true);
        }
        return $data;
    }

    function getFilterSort($fields)
    {
        $data = array();
        foreach ($fields as $item) {
            $data[$item]['asc'] = $this->buildLink(array('sort=' . $item, 'dir=asc'), true);
            $data[$item]['desc'] = $this->buildLink(array('sort=' . $item, 'dir=desc'), true);
        }
        return $data;
    }

    function getFilter()
    {
        return $this->filter;
    }

    function getRoute($var)
    {
        return $this->_link[$var];
    }

    function getCategory()
    {
        $where = array();
        //$where['cat_level'] = 0;
        $where['cat_status'] = 1;
        $this->db->start_cache();
        $this->db->select('cat_id, cat_name');
        $this->db->from('tbtt_category');
        $this->db->where($where);
        $this->db->order_by("cat_order", "asc");
        // Get the results
        $query = $this->db->get();
        // echo $this->db->last_query();
        $temp_result = $query->result_array();
        $this->db->flush_cache();
        return $temp_result;
    }

    function getFilterTypes()
    {
        return array(
            array('val' => '0', 'text' => 'Tất cả sản phẩm'),
            array('val' => '1', 'text' => 'Sản phẩm thành viên')
        );
    }

    function affiliateShop($where = array(), $page = FALSE)
    {
        $this->setAfKey($where['use_id']);
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'name';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';

        //Filter by doanh so
        $fday = isset($_REQUEST['day']) ? $_REQUEST['day'] : '0';
        $fmonth = isset($_REQUEST['month']) ? $_REQUEST['month'] : '0';
        $fyear = isset($_REQUEST['year']) ? $_REQUEST['year'] : '0';
        $tday = isset($_REQUEST['tday']) ? $_REQUEST['tday'] : '0';
        $tmonth = isset($_REQUEST['tmonth']) ? $_REQUEST['tmonth'] : '0';
        $tyear = isset($_REQUEST['tyear']) ? $_REQUEST['tyear'] : '0';

        $key = mktime(0, 0, 0, $fmonth, $fday, $fyear);
        $tokey = mktime(23, 59, 59, $tmonth, $tday, $tyear);

        if ($fday != 0 && $fmonth != 0 && $fyear != 0 && $tday != 0 && $tmonth != 0 && $tyear != 0) {
            $from = $key;
            $to = $tokey;
        } else {
            $from = '';
            $to = '';
        }

        $this->filter['uid'] = isset($_REQUEST['uid']) ? (int)$_REQUEST['uid'] : 0;
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $this->filter['q'] = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;

        $where_date = '';

        //Filter price
        $this->filter['qt'] = isset($_REQUEST['qt']) ? $_REQUEST['qt'] : '1';
        // Set filter
        if (trim($this->filter['q']) != '') {
            $searchString = $this->db->escape('%' . $this->filter['q'] . '%');
            switch ($this->filter['qt']) {
                case '1':
                    $this->db->where("tbtt_user.`use_username` LIKE  {$searchString} ");
                    break;
                case '2':
                    $this->db->where("tbtt_user.`use_email` LIKE  {$searchString} ");
                    break;
                case '3':
                    $this->db->where("tbtt_user.`use_fullname` LIKE  {$searchString} ");
                    break;
            }
        }
        switch ($sort) {
            case 'username':
                $this->db->order_by("tbtt_user.`use_username`", $dir);
                break;
            case 'name':
                //$this->db->order_by("tbtt_user.`use_fullname`", $dir);
                break;
            case 'email':
                $this->db->order_by("tbtt_user.use_email", $dir);
                break;
            case 'group':
                $this->db->order_by("tbtt_user.`use_group`", $dir);
                break;
            case 'creatdate':
                $this->db->order_by("tbtt_user.`use_regisdate`", $dir);
                break;
            case 'status':
                $this->db->order_by("tbtt_user.`use_status`", $dir);
                break;
            case 'publish':
                $this->db->where("tbtt_user.use_status", '1');
                break;
            case 'unpublish':
                $this->db->where("tbtt_user.use_status", '0');
                break;
            case 'logindate':
                if ($page != FALSE) {
                    $this->filter['key'] = isset($_REQUEST['key']) ? (int)$_REQUEST['key'] : 0;
                    $this->filter['tokey'] = isset($_REQUEST['tokey']) ? (int)$_REQUEST['tokey'] : 0;
                    $key = $this->filter['key'];
                    $tokey = $this->filter['tokey'];
                    $from = $key;
                    $to = $tokey;
                }
                $where = "tbtt_showcart.`shc_change_status_date` >= " . $key . " AND tbtt_showcart.`shc_change_status_date` <= " . $tokey;

                $where_date .= 'AND shc.`shc_change_status_date` >= ' . $key . ' AND shc.`shc_change_status_date` <= ' . $tokey;
                break;
            case 'doanhso':
                if ($dir == 'asc') {
                    $this->db->order_by("tbtt_showcart.`shc_total`", $dir);
                } else {
                    $this->db->order_by("tbtt_showcart.`shc_total`", $dir);
                }
                break;
        }
        // Get only not select product
        $select = 'tbtt_user.`use_id`,
                   tbtt_user.`use_username`,
                   tbtt_user.`use_fullname`,
                   tbtt_user.`use_status`,
                   tbtt_user.use_regisdate,
                   tbtt_user.`use_address`,
                   tbtt_user.`use_phone`,
                   tbtt_user.`use_mobile`,
                   tbtt_user.`use_email`,
                  `use_yahoo`,
                  FROM_UNIXTIME(
                    tbtt_user.use_regisdate,
                    "%d-%m-%Y"
                  ) AS use_regisdate,
                  tbtt_user.`use_group`,
                  (SELECT `gro_name` FROM `tbtt_group` WHERE `gro_id` = tbtt_user.`use_group`) as gro_name,
                  tbtt_user.`parent_id`,
                  (SELECT
                    u.use_username
                  FROM
                    tbtt_user AS u
                  WHERE u.use_id = `tbtt_user`.`parent_id`) AS pUsername, 
                  (SELECT SUM(shc.shc_total) FROM tbtt_showcart shc WHERE tbtt_user.`use_id` = shc.af_id ' . $where_date . ' AND shc.`shc_status` = "98") AS TongDS, 
                  tbtt_showcart.`shc_change_status_date`
                  ';

        // Unset user id
        $this->db->select($select, false);
        $this->db->from('tbtt_user');
        $this->db->join('tbtt_showcart', 'tbtt_showcart.af_id = tbtt_user.use_id', 'inner');
        $this->db->where('EXISTS (SELECT 1  FROM  `tbtt_product_affiliate_user`  WHERE `use_id` = tbtt_user.use_id)', null, false);
        $this->db->where('tbtt_showcart.`shc_status`', "98");
        $this->db->where($where);
        $this->db->group_by("tbtt_user.`use_username`");

        /**
         *   PAGINATION
         **/
        if ($this->pagination_enabled == TRUE) {
            $config = array();
            $config['cur_page'] = $page;
            $total_result = count($this->Count_All_Result($from, $to, $sort));
            //$config['total_rows'] = $this->db->count_all_results(); 
            $config['total_rows'] = $total_result;
            $config['base_url'] = base_url() . $this->_curLink;
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            if ($sort == 'logindate') {
                $config['suffix'] = $this->buildLink(array("sort={$sort}", "dir={$dir}", "key={$key}", "tokey={$tokey}"));
            } else {
                $config['suffix'] = $this->buildLink(array("sort={$sort}", "dir={$dir}"));
            }

            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
            $this->db->limit($config['per_page'], $page);
        }

        // Get the results
        $query = $this->db->get();
        //echo $this->db->last_query(); 
        $temp_result = $query->result_array();
        $this->db->flush_cache();
        return $temp_result;
    }

    function Count_All_Result($from, $to)
    {
        if ($from != '' && $to != '') {
            $query = $this->db->query('SELECT shc_id FROM tbtt_showcart WHERE af_id != "" AND shc_change_status_date >= ' . $from . ' AND  shc_change_status_date <= ' . $to . ' GROUP BY af_id ');
        } else {
            $query = $this->db->query('SELECT shc_id FROM tbtt_showcart WHERE af_id != ""  GROUP BY af_id ');
        }

        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }

    function getSearchBox()
    {
        return array(
            array('id' => 1, 'text' => 'Tài khoản'),
            array('id' => 2, 'text' => 'Email'),
            array('id' => 3, 'text' => 'Họ tên')
        );
    }

    function getStatusBox()
    {
        return array(
            // array('id' => 'creatdate', 'text' => 'Ngày đăng ký'),
            array('id' => 'publish', 'text' => 'Kích hoạt'),
            array('id' => 'unpublish', 'text' => 'Chưa kích hoạt'),
            array('id' => 'logindate', 'text' => 'Doanh số')
        );
    }

    function getUserInfo($uid)
    {
        $this->db->start_cache();
        $select_statement = '`use_username`,`use_fullname`';
        $this->db->select($select_statement);
        $this->db->where('use_id', $uid);
        $this->db->from('tbtt_user');
        $data = $this->db->get()->row_array();
        //echo $this->db->last_query();
        $this->db->flush_cache();
        return $data;
    }

    function getSupplierProduct($where = array(), $page = FALSE)
    {
        $this->db->start_cache();
        $sort = isset($_REQUEST['sort']) ? $_REQUEST['sort'] : 'name';
        $dir = isset($_REQUEST['dir']) ? $_REQUEST['dir'] : 'asc';
        $this->filter['uid'] = isset($_REQUEST['uid']) ? (int)$_REQUEST['uid'] : 0;
        $this->filter['st'] = isset($_REQUEST['st']) ? (int)$_REQUEST['st'] : 0;
        $dir = strtolower($dir);
        $dir = $dir == 'asc' ? 'asc' : 'desc';
        $q = isset($_REQUEST['q']) ? $_REQUEST['q'] : '';
        $this->filter['sort'] = $sort;
        $this->filter['dir'] = $dir;
        //Filter price
        $priceFrom = isset($_REQUEST['pf']) ? $_REQUEST['pf'] : 0;
        if ($priceFrom > 0) {
            $this->filter['pf'] = $priceFrom;
        }
        $priceTo = isset($_REQUEST['pt']) ? $_REQUEST['pt'] : 0;
        if ($priceTo > 0) {
            $this->filter['pt'] = $priceTo;
        }
        $price = isset($_REQUEST['price']) ? $_REQUEST['price'] : '';
        if ($price != '') {
            $tmp = explode('-', $price);
            $this->filter['pf'] = $tmp[0];
            $this->filter['pt'] = $tmp[1];
        }
        if (@$this->filter['pf'] > 0) {
            $where['tbtt_product.pro_cost >='] = $this->filter['pf'];
        }
        if (@$this->filter['pt'] > 0) {
            $where['tbtt_product.pro_cost <='] = $this->filter['pt'];
        }
//        $cat = isset($_REQUEST['cat']) ? (int)$_REQUEST['cat'] : 0;
//        if($cat > 0){
//            $where['tbtt_shop.sho_category'] = $cat;
//            $this->filter['cat'] = $cat;
//        }
        $cat = isset($_REQUEST['cat']) ? (int)$_REQUEST['cat'] : 0;
        if ($cat > 0) {
            $where['tbtt_shop.sho_category'] = $cat;
            $this->filter['cat'] = $cat;
        }
        // Set filter
        if (trim($q) != '') {
            $searchString = $this->db->escape('%' . $q . '%');
            $this->db->where("(tbtt_product.`pro_name` LIKE  {$searchString} OR tbtt_shop.`sho_link` LIKE  {$searchString} OR tbtt_shop.`sho_name` LIKE  {$searchString}) ");
            $this->filter['q'] = trim($q);
        }
        $catName = '(SELECT `cat_name` FROM `tbtt_category` WHERE `cat_id` = tbtt_product.`pro_category` ORDER BY tbtt_product.`pro_category` DESC) as cName ';
        switch ($sort) {
            case 'name':
                $this->db->order_by("tbtt_product.`pro_name`", $dir);
                break;
            case 'price':
                $this->db->order_by("tbtt_product.`pro_cost`", $dir);
                break;
            case 'cat':
                $this->db->order_by("tbtt_category.cat_name", $dir);
                $catName = 'tbtt_category.cat_name as cName';
                break;
            case 'shop':
                $this->db->order_by("tbtt_shop.`sho_name`", $dir);
                break;
        }
        $where['tbtt_product.pro_status'] = 1;
        $where['tbtt_product.pro_minsale >= '] = 1;
        //$where['tbtt_product.pro_begindate <= '] = $curTime;
        //$where['tbtt_product.pro_enddate >= '] = $curTime;
        $select = 'tbtt_product.`pro_id`
                  ,tbtt_product.`pro_name`
                  ,tbtt_product.`pro_cost`
                  ,tbtt_product.`pro_dir`
                  ,tbtt_product.`pro_image`
                  ,tbtt_product.`pro_category`
                  ,tbtt_product.`pro_type`
				  ,tbtt_shop.`sho_link` as linkshop
				  ,tbtt_shop.`sho_name` as nameshop
				  ,tbtt_shop.`sho_category` as catshop
				  ,(SELECT `use_username` FROM `tbtt_user` WHERE `use_id` = tbtt_product.pro_user) as shop
                  ,' . $catName;
        // Unset user id
        $this->db->select($select, false);
        $this->db->from('tbtt_product');
        $this->db->join('tbtt_shop', 'tbtt_product.pro_user = tbtt_shop.sho_user');
        $this->db->join('tbtt_product_promotion', 'tbtt_product.pro_id = tbtt_product_promotion.pro_id');
        $this->db->group_by('tbtt_product.pro_id');
        if ($sort == 'cat') {
            $this->db->join('tbtt_category', 'tbtt_category.cat_id = tbtt_product.pro_category');
        }
        $this->db->where($where);
        /**
         *   PAGINATION
         */
        if ($this->pagination_enabled == TRUE) {
            $query = $this->db->get();
            $rowcount = $query->num_rows();
            $config = array();
            $config['cur_page'] = $page;
            $config['total_rows'] = $rowcount;
            $config['base_url'] = base_url() . $this->_curLink;
            $config['uri_segment'] = 3;
            $config['cur_tag_open'] = '<li><span class="current">';
            $config['cur_tag_close'] = '</span></li>';
            $config['per_page'] = $this->pagination_per_page;
            $config['num_links'] = $this->pagination_num_links;
            $config['suffix'] = $this->buildLink(array());
            $this->load->library('pagination');
            $this->pagination->initialize($config);
            $this->pager = $this->pagination->create_links();
            $this->db->limit($config['per_page'], $page);
        }
        // Get the results
        $query = $this->db->get();
        // echo $this->db->last_query();
        $temp_result = array();
        foreach ($query->result_array() as $row) {
            $temp_result[] = array(
                'pro_id' => $row['pro_id'],
                'pro_name' => $row['pro_name'],
                'pro_type' => $row['pro_type'],
                'isselect' => TRUE,
                'af_amt' => $row['af_amt'],
                'amt' => $row['amt'],
                'af_rate' => $row['af_rate'],
                'pro_cost' => $row['pro_cost'],
                'pro_dir' => $row['pro_dir'],
                'pro_image' => $row['pro_image'],
                'pro_category' => $row['pro_category'],
                'cName' => $row['cName'],
                'nameshop' => $row['nameshop'],
                'linkshop' => $row['linkshop'],
                'link' => base_url() . $row['shop'] . '/product/detail' . '/' . $row['pro_id'] . '/' . RemoveSign($row['pro_name'])
            );
        }
        $query->free_result();
        $this->db->flush_cache();
        return $temp_result;
    }

    function getShopCategory()
    {
        $cat_level_0 = $this->category_model->fetch("*", "parent_id = 0 AND cat_status = 1 ", "cat_name", "ASC");
        if (isset($cat_level_0)) {
            foreach ($cat_level_0 as $key => $item) {
                $cat_level_1 = $this->category_model->fetch("*", "parent_id = " . (int)$item->cat_id . " AND cat_status = 1");
                $cat_level_0[$key]->child_count = count($cat_level_1);
            }
        }
        return $cat_level_0;
    }
}

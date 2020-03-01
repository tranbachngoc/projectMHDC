<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 11/25/2015
 * Time: 13:01 PM
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ajax extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function action($action)
    {
        $return = array();
        switch ($action) {
            case 'wishlist':
                if ($this->session->userdata('sessionUser') > 0 && $this->input->post('product_showcart') > 0) {
                    $this->load->model('ajax_model');
                    $return = $this->ajax_model->addFavourite(array(
                        'prf_product' => $this->input->post('product_showcart'),
                        'prf_user' => $this->session->userdata('sessionUser')));

                } else {
                    $return = array('error' => true, 'message' => 'Vui lòng <a href="'.base_url().'login"> đăng nhập</a> để sử dụng chức năng này');
                }
                break;
            
            case 'delheart':
                if ($this->session->userdata('sessionUser') > 0 && $this->input->post('product_showcart') > 0) {
                    $this->load->model('ajax_model');
                    $return = $this->ajax_model->delFavourite(array(
                        'prf_product' => $this->input->post('product_showcart'),
                        'prf_user' => $this->session->userdata('sessionUser')));
                } else {
                    $return = array('error' => true, 'message' => 'Vui lòng <a href="'.base_url().'login"> đăng nhập</a> để sử dụng chức năng này');
                }
                break;
            
            case 'load_danhmuc':
                //menu
                $shop = $this->input->post('listshop');
                $lpro = $this->input->post('listpro');
                $type = (int)$this->input->post('pro_type');
                if($type == 0){
                    $pro_type = 'product';
                }else{
                    $pro_type = 'coupon';
                }
                if($shop != '' && $lpro != '' && $type != ''){
                    $list_pro = $this->product_model->fetch('pro_id, pro_category, pro_type', 'pro_user IN (' . $shop . ') AND pro_type = '.$type.' AND pro_status = 1 AND pro_id NOT IN (' . $lpro . ')');
                    $li_pro = $cat = $cat_pro = $cat_coupon = array();
                    $pro_id = 0;
                    if ($list_pro) {
                        foreach ($list_pro as $k => $vpro) {
                            $li_pro[] = $vpro->pro_id;
                            $cat[$vpro->pro_category] = $vpro->pro_category;
                        }
                        $list_cat = implode(',', $cat);
                        $pro_id = implode(',', $li_pro);
                    }
                    $li_pro = array();
                    $cat = array();
                    $_arr = "0";
                    if ($list_pro) {
                        $_arr = $pro_id;
                        $_arrcat = $list_cat;
                    }
                    if ($_arrcat != '') {
                        $catpye = $type;
                        $cat_parent = $this->category_model->fetch("cat_id,cat_level, parent_id", "cat_id IN(" . $_arrcat .")");

                        $level_0 = array();
                        $level_1 = array();
                        $level_2 = array();
                        $level_3 = array();
                        $level_4 = array();

                        //lam tiep
                        foreach($cat_level_0 as $key => $value){
                            //echo $value->cat_id.'|| ';
                        }
                        foreach($cat_parent as $key => $value){
                            switch ($value->cat_level) {
                                case '1':
                                    $level_1[] = $value->cat_id;
                                    break;
                                case '2':
                                    $level_1[] = $value->parent_id;
                                    $level_2[] = $value->cat_id;
                                    break;
                                case '3':
                                    $level_2[] = $value->parent_id;
                                    $level_3[] = $value->cat_id;
                                    break;
                                case '4':
                                    $level_3[] = $value->parent_id;
                                    $level_4[] = $value->cat_id;
                                    break;
                            } 
                        }
                        //var_dump($level_2);    
                        if(!empty($level_4)){
                            $level4 = implode(',', $level_4);
                            $get_category_leve4 = $this->category_model->fetch("cat_id, cat_name, parent_id", "cat_status = 1 AND cate_type = " . $catpye . " AND cat_id IN(" . $level4 .")");
                            if($get_category_leve4){
                                foreach ($get_category_leve4 as $key => $items){
                                    $level_3[] = $items->parent_id;
                                }
                            }
                        }
                        if(!empty($level_3)){
                            $level3 = implode(',', $level_3);
                            $get_category_leve3 = $this->category_model->fetch("cat_id, cat_name, parent_id", "cat_status = 1 AND cate_type = " . $catpye . " AND cat_id IN(" . $level3 .")");
                            if($get_category_leve3){
                                foreach ($get_category_leve3 as $key => $items){
                                    $level_2[] = $items->parent_id;
                                }
                            }
                        }
                        if(!empty($level_2)){
                            $level2 = implode(',', $level_2);
                            $get_category_leve2 = $this->category_model->fetch("cat_id, cat_name, parent_id", "cat_status = 1 AND cate_type = " . $catpye . " AND cat_id IN(" . $level2 .")");
                            if($get_category_leve2){
                                foreach ($get_category_leve2 as $key => $items){
                                    if($items->parent_id != ''){
                                        $level_1[] = $items->parent_id;
                                    }
                                }
                            }
                        }
                        if(!empty($level_1)){
                            $level1 = implode(',',$level_1);
                            $cat_lavel_1_temp = $this->category_model->fetch("cat_id, cat_name, parent_id", "cat_status = 1 AND cate_type = " . $catpye . " AND cat_id IN(" . $level1.")");
                            foreach ($cat_lavel_1_temp as $key => $items){
                                $level_0[] = $items->parent_id;
                            }
                        }
                        $menu = array();
                        $cat = array();
                        $li = '';
                        if(!empty($level_0)){
                            $level0 = implode(',', $level_0);
                            $cat_level_0 = $this->category_model->fetch("cat_id, cat_name", "cat_status = 1 AND cate_type = " . $catpye . " AND cat_id IN(" . $level0 .")");
                            if (isset($cat_level_0) && count($cat_level_0) > 0) {
                                foreach ($cat_level_0 as $keys => $value) {
                                    $li .= '<li class="licap1"><a href="/grtshop/'.$pro_type.'/cat/'.$value->cat_id.'-'.RemoveSign($value->cat_name).'">'.$value->cat_name.'</a> <span class="caret" onclick="show_menu(this,'.$value->cat_id.');" id="i_'.$value->cat_id.'"></span>';
                                    $li .= '<ul class="menu_'.$value->cat_id.'" id="cap2">';
                                    if($level1 != ''){
                                        $cat1_temp = $this->category_model->fetch("cat_id, cat_name, parent_id", "cat_status = 1 AND cate_type = " . $catpye . " AND parent_id = " . (int)$value->cat_id . " AND cat_id IN(" . $level1.")");
                                        foreach ($cat1_temp as $key => $item){ 
                                            if($item->parent_id == $value->cat_id){
                                                $li .= '<li class="licap2"><a href="/grtshop/'.$pro_type.'/cat/'.$item->cat_id.'-'.RemoveSign($item->cat_name).'">'.$item->cat_name.'</a>';
                                                if($level2 != ''){
                                                    $get_cat2 = $this->category_model->fetch("cat_id, cat_name, parent_id", "cat_status = 1 AND cate_type = " . $catpye . " AND parent_id = " . (int)$item->cat_id . " AND cat_id IN(" . $level2.")");
                                                    if(count($get_cat2) > 0){
                                                        $li .= ' <span class="caret" onclick="show_menu(this,'.$item->cat_id.');" id="i_'.$item->cat_id.'"></span><ul class="menu_'.$item->cat_id.'" id="cap3">';
                                                        foreach ($get_cat2 as $key2 => $item2) { 
                                                            if($item2->parent_id == $item->cat_id) {
                                                                $li .= '<li class="licap3"><a href="/grtshop/'.$pro_type.'/cat/'.$item2->cat_id.'-'.RemoveSign($item2->cat_name).'">'.$item2->cat_name.'</a>';
                                                                if($level3 != ''){
                                                                    $get_cat3 = $this->category_model->fetch("cat_id, cat_name, parent_id", "cat_status = 1 AND cate_type = " . $catpye . " AND parent_id = " . (int)$item2->cat_id . " AND cat_id IN(" . $level3.")");
                                                                    if(count($get_cat3) > 0) {
                                                                        $li .= ' <span class="caret" onclick="show_menu(this,'.$item2->cat_id.');" id="i_'.$item2->cat_id.'"></span><ul class="menu_'.$item2->cat_id.'" id="cap4">';
                                                                        foreach ($get_cat3 as $key3 => $item3) { 
                                                                           if($item3->parent_id == $item2->cat_id) 
                                                                           {
                                                                               $li .= '<li class="licap4"><a href="/grtshop/'.$pro_type.'/cat/'.$item3->cat_id.'-'.RemoveSign($item3->cat_name).'">'.$item3->cat_name.'</a>';
                                                                               if($level4 != ''){
                                                                                    $get_cat4 = $this->category_model->fetch("cat_id, cat_name, parent_id", "cat_status = 1 AND cate_type = " . $catpye . " AND parent_id = " . (int)$item3->cat_id . " AND cat_id IN(" . $level4.")");
                                                                                    if(count($get_cat4) > 0) {
                                                                                       $li .= ' <span class="caret" onclick="show_menu(this,'.$item3->cat_id.');" id="i_'.$item3->cat_id.'"></span><ul class="menu_'.$item3->cat_id.'" id="cap5">';
                                                                                       foreach ($get_cat4 as $key4 => $item4) {
                                                                                           if($item4->parent_id == $item3->cat_id) {
                                                                                                $li .= '<li class="licap5"><a href="/grtshop/'.$pro_type.'/cat/'.$item4->cat_id.'-'.RemoveSign($item4->cat_name).'">'.$item4->cat_name.'</a></li>';
                                                                                           }
                                                                                       }
                                                                                       $li .= '</ul>';
                                                                                   }
                                                                               }
                                                                               $li .= '</li>';
                                                                           }
                                                                        }
                                                                        $li .= '</ul>';
                                                                    }
                                                                }
                                                                $li .= '</li>';
                                                            }
                                                        }
                                                        $li .= '</ul>';
                                                    }
                                                }
                                                $li .= '</li>';
                                            }
                                        }
                                    }
                                    $li .= '</ul></li>';
                                    //if( $keys>0 && $keys%20 == 0) echo '</ul><ul style="display: inline-block; vertical-align: top;">';
                                }
                            }
                        }               
                    }
                }
                $return = array('error' => false, 'li' => $li);
                //end menu
            break;
            
            case 'load_cat':
                $catp = $this->input->post('catp');
                $listcat = $this->input->post('listcat');
                $get_cat2 = $this->category_model->fetch("cat_id, cat_name, parent_id", "cat_status = 1 AND parent_id = " . (int)$catp." AND cat_id IN(" . $listcat .")");
                if(!empty($get_cat2)){
                    $li = '<ul class="cap1">';
                    foreach ($get_cat2 as $key2 => $item2) {
                        $li .= '<li><a href="/grtshop/product/cat/'.$item2->cat_id.'-'.RemoveSign($item2->cat_name).'">'.$item2->cat_name.'</a>';
                        $get_cat3 = $this->category_model->fetch("cat_id, cat_name, parent_id", "cat_status = 1 AND parent_id = " . (int)$item2->cat_id." AND cat_id IN(" . $listcat .")");
                        if(!empty($get_cat3)) {
                            $li .= '<ul class="">';
                            foreach ($get_cat3 as $key3 => $item3) { 
                               if($item3->parent_id == $item2->cat_id) 
                               {
                                    $li .= '<li><a href="/grtshop/product/cat/'.$item3->cat_id.'-'.RemoveSign($item3->cat_name).'">'.$item3->cat_name.'</a>';
                                    $get_cat4 = $this->category_model->fetch("cat_id, cat_name, parent_id", "cat_status = 1 AND parent_id = " . (int)$item3->cat_id." AND cat_id IN(" . $listcat .")");
                                    if(count($get_cat4) > 0) {
                                        $li .= '<ul class="">';
                                        foreach ($get_cat4 as $key4 => $item4) {
                                            if($item4->parent_id == $item3->cat_id) {
                                                 $li .= '<li><a href="/grtshop/product/cat/'.$item4->cat_id.'-'.RemoveSign($item4->cat_name).'">'.$item4->cat_name.'</a></li>';
                                            }
                                        }
                                        $li .= '</ul>';
                                    }
                                   $li .= '</li>';
                               }
                            }
                            $li .= '</ul>';
                        }
                        $li .= '</li>';
                    }
                    $li .= '</ul>';
                }
                $return = array('error' => false, 'li' => $li);
                break;
            
            case 'district':
                $this->load->model('district_model');
                if($this->input->post('company') == 'VTP' || $this->input->post('company') == 'SHO'){
                    // Case VTP & SHO
                    $filterDistrict = array(
                        'select' => 'vtp_code AS MA_QUANHUYEN, DistrictName AS TEN_QUANHUYEN',
                        'order_by' => 'DistrictName ASC',
                        'where' => array('vtp_province_code' => $this->input->post('province'))
                        );
                } else { 
                    // Case GHN & GHTK
                    $filterDistrict = array(
                        'select' => 'DistrictCode AS MA_QUANHUYEN, DistrictName AS TEN_QUANHUYEN',
                        'order_by' => 'DistrictName ASC',
                        'where' => array('ProvinceCode' => (int)$this->input->post('province'))
                    );
                }
                $return = $this->district_model->getDistrict($filterDistrict);
                break;

            case 'province':
                $this->load->model('district_model');
                if($this->input->post('company') == 'VTP' || $this->input->post('company') == 'SHO'){
                    // Case VTP & SHO
                    $filterDistrict = array(
                        'select' => " vtp_province_code AS MA_TINH, ProvinceName AS TEN_TINH",
                        'order_by' => 'ProvinceName ASC'
                    );
                } else {
                    // Case GHN & GHTK
                    $filterDistrict = array(
                        'select' => " ProvinceCode AS MA_TINH, ProvinceName AS TEN_TINH",
                        'order_by' => 'ProvinceName ASC'
                    );
                }
                $return = $this->district_model->getDistrict($filterDistrict);
                break;

            case 'checkprice':
                $pack_id = $this->input->post('pack');
                $city = $this->input->post('position');
                $this->load->model('package_daily_model');
                $this->load->model('package_daily_user_model');
                $filter = array();
                $filter['where'] = array(
                    'tbtt_package_daily.id' => $pack_id,
                    'tbtt_package_daily_price.city' => $city,
                );
                $filter['select'] = "tbtt_package_daily_price.pos_num,
                                    tbtt_package_daily_price.price_min,
                                    tbtt_package_daily_price.price_max ";
                $package_info = $this->package_daily_model->get_package_detail($filter);
                $regis_date = $this->input->post('date_range');
                $regis_date = explode('_', $regis_date);

                $current = strtotime($regis_date[0]);
                $last = strtotime($regis_date[1]);
                $output_format = 'Y-m-d';
                $step = '+1 day';
                $return['dates'] = array();
                $total = 0;
                while( $current <= $last) {

                    $check_date = date($output_format, $current);

                    $max_num = $this->package_daily_user_model->get_max_pos_num($check_date, $pack_id, $city);

                    if ($package_info['pos_num'] < $max_num['max_num']) {
                        $return['dates'][] = array('date'=>date('d/m/Y', $current), 'd'=>date('Y-m-d', $current),'error' => true, 'message' => 'Đã hết chỗ');
                    } else {

                        $unit_price = ($package_info['price_max'] - $package_info['price_min']) / $package_info['pos_num'];
                        $price = $package_info['price_min'] + (($max_num['max_num'] - 1) * $unit_price);
                        $total += $price;
                        $return['dates'][] = array('date'=>date('d/m/Y', $current), 'd'=>date('Y-m-d', $current), 'error' => false, 'price' => $price, 'price_text' => lkvUtil::formatPrice($price, 'đ'));
                    }

                    $current = strtotime($step, $current);
                }
                $return['pack_id'] = $pack_id;
                $return['position'] = $city;
                $return['total'] = $total;
                $return['total_text'] = lkvUtil::formatPrice($total, 'đ');

                break;
            
            case 'packprice':
                $userId = (int)$this->session->userdata('sessionUser');
                $period = (int)$this->input->post('periods');
                $package = (int)$this->input->post('package');
                $this->load->model('package_user_model');
                $return = $this->package_user_model->getPackInfomation($package, $period);
                $remainData = $this->package_user_model->getRemainAmount($userId);
                $totalRemain = 0;
                foreach($remainData as $item){
                    $totalRemain += $item['amount'] * $item['remain']/  $item['num_date'];
                }
                $return['price'] = $return['request_amt'] - $totalRemain;
                $return['price'] = $return['price'] < 0 ? 0 : $return['price'];
                $return['price_text'] = lkvUtil::formatPrice($return['price'], 'đ');
                break;

            case 'getpricebran':
                $userId = (int)$this->session->userdata('sessionUser');
                $package = (int)$this->input->post('package');
                $this->load->model('package_user_model');
                $this->load->model('shop_model');
                $return = $this->package_user_model->getPackAmountBran($package);
                $dShop = $this->shop_model->get('sho_discount_rate', 'sho_user = '.$userId);
                $dis = $dShop->sho_discount_rate <= 0 ? 1 : 1 - ($dShop->sho_discount_rate / 100);                     
                $return['price'] = $return['price'] < 0 ? 0 : ($return['price']*$dis);
                $return['price_text'] = lkvUtil::formatPrice($return['price'], 'đ');
                $return['dis'] = $dis;
                break;

            case 'getpricectv':
                $userId = (int)$this->session->userdata('sessionUser');
                $package = (int)$this->input->post('package');
                $this->load->model('package_user_model');
                $this->load->model('shop_model');
                $return = $this->package_user_model->getPackAmountCTV($package);
                $dShop = $this->shop_model->get('sho_discount_rate', 'sho_user = '.$userId);
                $dis = $dShop->sho_discount_rate <= 0 ? 1 : 1 - ($dShop->sho_discount_rate / 100);                     
                $return['price'] = $return['price'] < 0 ? 0 : ($return['price']*$dis);
                $return['price_text'] = lkvUtil::formatPrice($return['price'], 'đ');
                $return['dis'] = $dis;
                break;    
                
            case 'addpack':
                $regis_date = $this->input->post('daterange');

                $pack_id = $this->input->post('pack');
                $dates = $this->input->post('date');
                $price = $this->input->post('price');
                $price_total = $this->input->post('total');
                $city = $this->input->post('position');
                $userId = (int)$this->session->userdata('sessionUser');
                $pid = $this->input->post('pid');

                if ($userId <= 0) {
                    $return = array('error' => true, 'message' => 'Vui lòng đăng nhập');

                } else {
                    $this->load->model('package_daily_model');
                    $this->load->model('package_daily_user_model');
                    $filter = array();
                    $filter['where'] = array(
                        'tbtt_package_daily.id' => $pack_id,
                        'tbtt_package_daily_price.city' => $city,
                    );
                    $filter['select'] = "tbtt_package_daily.unit_type,
                                    tbtt_package_daily.content_type,
                                    tbtt_package_daily.p_type,
                                    tbtt_package_daily.p_name,
                                    tbtt_package_daily_price.pos_num,
                                    tbtt_package_daily_price.price_min,
                                    tbtt_package_daily_price.price_max ";
                    $package_info = $this->package_daily_model->get_package_detail($filter);

                    if ($package_info['unit_type'] == 'ngày') {
                        $total = 0;
                        foreach($dates as $date){
                            $max_num = $this->package_daily_user_model->get_max_pos_num($date, $pack_id, $city);
                            $tmp = explode('-', $date);
                            $checkDate = $tmp[2].'/'.$tmp[1].'/'.$tmp[0];
                            if ($package_info['pos_num'] < $max_num['max_num']) {
                                $return['dates'][] = array('max_num'=>$max_num['max_num'],'date'=>$checkDate, 'd'=>$date,'error' => true, 'message' => 'Đã hết chỗ');
                            } else {
                                $unit_price = ($package_info['price_max'] - $package_info['price_min']) / $package_info['pos_num'];
                                $price = $package_info['price_min'] + (($max_num['max_num'] - 1) * $unit_price);
                                $total += $price;
                                $return['dates'][] = array('max_num'=>$max_num['max_num'],'date'=>$checkDate, 'd'=>$date, 'error' => false, 'price' => $price, 'price_text' => lkvUtil::formatPrice($price, 'đ'));
                            }
                        }
                        if($total != $price_total){
                            $return['pack_id'] = $pack_id;
                            $return['position'] = $city;
                            $return['total'] = $total;
                            $return['total_text'] = lkvUtil::formatPrice($total, 'đ');
                            $return['error'] = true;
                            $return['message']= 'Giá đã thay đổi';
                        }else{
                            $amount = $this->package_daily_user_model->getWallet($userId);
                            if ($total > $amount['amount_money'] + $amount['amount_point']) {
                                $return['error'] = true;
                                $return['message']= 'Vui lòng nạp thêm tiền vào tài khoản để đăng ký dịch vụ';

                            }else{

                                foreach($return['dates'] as $date){
                                    $this->package_daily_user_model->addPackage($userId, $pack_id, $date['d'], $date['price'], $date['max_num'], $package_info['content_type'], $package_info['p_type'], $city, $package_info['p_name'], $pid);
                                }
                                $return['error'] = false;
                                $return['message']= 'Thành công';
                                $news = "";
                                if($this->input->post('pack') == 8){
                                    $position = array(
                                        '000'=>"Toàn quốc",
                                        '001'=>"Khu vực 1",
                                        '999'=>"Khu vực 2"
                                    );
                                    $news = '. Khu vực: '.$position[$this->input->post('position')];
                                }
                                
                                if($this->input->post('pack') == 1){
                                    $position = array(
                                        '000'=>"Tin hot",
                                        '111'=>"Tin khuyến mãi"
                                    );
                                    $news = '. Loại: '.$position[$this->input->post('position')];
                                }
                                
                                $beginTime      =   date("d-m-Y",strtotime($_POST['date'][0]));
                                $endTime        =   date("d-m-Y",strtotime($_POST['date'][count($this->input->post('date')) - 1]));
                                
                                if($endTime == $beginTime && $endTime == ""){
                                    $timeline       =   $beginTime;
                                } else {
                                    $timeline       =   $beginTime.' đến '.$endTime;
                                }
                                
                                $logaction      =   'Bạn đã mua thành công gói '.$package_info['p_name'].'. Thời gian: '.$timeline.'. Số tiền:'.number_format($total, 0, ",", ".").' đ'.$news;
                                $this->session->set_flashdata('flash_message_success', $logaction);
                            }
                        }
                    }else{
                        $return = $this->package_daily_user_model->addShelfPackage($userId, $pack_id,  $package_info['price_min'], $package_info['pos_num'], $package_info['content_type'], $package_info['p_type'], $package_info['p_name']);
                    }

                }


                break;
            
            case 'addshelf':
                $pack_id = $this->input->post('pack');
                $p_shelf = $this->input->post('p_shelf');
                $p_time = $this->input->post('p_time');

                $userId = (int)$this->session->userdata('sessionUser');
                if ($userId <= 0) {
                    $return = array('error' => true, 'message' => 'Vui lòng đăng nhập');

                } else {
                    $this->load->model('package_model');
                    $filter_package = array(
                        'select'=>'*',
                        'where'=>array(
                            'id'=>$p_time
                        )
                    );
                    $package_data = $this->package_model->get_one($filter_package);
                    if(empty($package_data)){
                        $return = array('error'=>true, 'message'=>"Thông tin gói không hợp lệ");
                    }else{
                        $this->load->model('package_daily_model');
                        $this->load->model('package_daily_user_model');
                        $filter_package = array(
                            'select'=>'*',
                            'where'=>array(
                                'id'=>$pack_id
                            )
                        );
                        $package_daily = $this->package_daily_model->get_one($filter_package);



                        $request_amt = $package_data['month_price'] * $package_data['period'] * $p_shelf;
                        if($package_data['discount_rate'] > 0){
                            $request_amt =  (100 - $package_data['discount_rate']) * $request_amt / 100;
                        }

                        $amount = $this->package_daily_user_model->getWallet($userId);

                        if ($request_amt > $amount['amount_money'] + $amount['amount_point']) {
                            $return['error'] = true;
                            $return['message']= 'Vui lòng nạp thêm tiền vào tài khoản để đăng ký dịch vụ';

                        }else{
                            $return = $this->package_daily_user_model->addShelfPackage($userId, $pack_id, $request_amt, $package_data['period'], $p_shelf,$package_daily['content_type'],$package_daily['p_type'], $package_daily['p_name']);


                        }

                    }

                }


                break;
            
            case 'checkpwd':

                if($this->input->server('REQUEST_METHOD') == 'POST' && $this->session->userdata('sessionUser') > 0){
                    $this->load->model('user_model');
                    $this->load->library('hash');

                    $user_info  =   $this->user_model->get('use_salt,use_password','use_id = '.$this->session->userdata('sessionUser'));
                    $check      =   $this->hash->create($this->input->post('pwd'), $user_info->use_salt, 'md5sha512');
                    
                    if($user_info->use_password == $check){
                        $return = array('error'=>'1','msg'=>'');
                    }else{
                        $return = array('error'=>'0','msg'=>'Mật khẩu nhập chưa đúng');
                    }
                }
                break;
                
        }
        echo json_encode($return);
        exit();


    }
}

<?php
#****************************************#
# * @Author: lehieu008                   #
# * @Email: lehieu008@gmail.com          #
# * @Website: http://www.iscvietnam.net  #
# * @Copyright: 2008 - 2009              #
#****************************************#
class User extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        #CHECK SETTING
        if ((int)settingStopSite == 1) {
            $this->lang->load('home/common');
            show_error($this->lang->line('stop_site_main'));
            die();
        }
        #END CHECK SETTING
        #Load language
        $this->lang->load('home/contact');
        $this->lang->load('home/common');
        $this->lang->load('home/register');
        
        #BEGIN: Ads & Notify Taskbar
        $this->load->model('ads_model');
        $this->load->model('notify_model');
        $this->load->model('category_model');
        $this->load->model('province_model');
        $this->load->model('district_model');
        $this->load->model('shop_model');
        $this->load->model('user_model');
        #BEGIN Eye
        if ($this->session->userdata('sessionUser') > 0) {
            $data['currentuser'] = $this->user_model->get("use_id,use_username,avatar","use_id = " . $this->session->userdata('sessionUser'));            
            if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
                $myshop = $this->shop_model->get("sho_link, domain","sho_user = " . $this->session->userdata('sessionUser'));                
	    } else {
		$parentUser = $this->user_model->get("parent_id","use_id = " . $this->session->userdata('sessionUser'));
                $myshop = $this->shop_model->get("sho_link, domain","sho_user = " . $parentUser->parent_id);
	    }
	    $data['myshop'] = $myshop;            
            /*$this->load->model('eye_model');
            $data['listeyeproduct'] = $this->eye_model->geteyetype('product', $this->session->userdata('sessionUser'));
            $data['listeyeraovat'] = $this->eye_model->geteyetype('raovat', $this->session->userdata('sessionUser'));
            $data['listeyehoidap'] = $this->eye_model->geteyetype('hoidap', $this->session->userdata('sessionUser'));*/
        }
        #END Eye
        
        $data['menuType'] = 'product';
        // $retArray = $this->loadCategory(0, 0);
        // $data['menu'] = $retArray;

        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $adsTaskbar = $this->ads_model->fetch("ads_id, ads_title, ads_category, ads_descr", "ads_status = 1 AND ads_enddate >= $currentDate AND ads_reliable = 1", "rand()", "DESC", 0, (int)settingAdsNew_Home);
        $data['adsTaskbarGlobal'] = $adsTaskbar;
        $notifyTaskbar = $this->notify_model->fetch("not_id, not_title, not_begindate", "not_group = '0,1,2,3' AND not_status = 1 AND not_enddate >= $currentDate", "not_id", "DESC", 0, 4);
        $data['notifyTaskbarGlobal'] = $notifyTaskbar;
        #BEGIN: Notify
	
        $data['isMobile'] = 0;
        $this->load->library('Mobile_Detect');
        $detect = new Mobile_Detect();       
        if ($detect->isAndroidOS() || $detect->isiOS() || $detect->isMobile()) {
	    $data['isMobile'] = 1;
        }

        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $select = "not_id, not_title, not_detail, not_degree";
        $this->db->limit(settingNotify);
        $this->db->order_by("not_id", "DESC");
        $data['listNotify'] = $this->notify_model->fetch($select, "not_status = 1 AND not_group = '0,1,2,3'", "not_degree", "DESC");
        #END Notify
        $data['mainURL'] = $this->getMainDomain();

        $this->load->vars($data);
        #END Ads & Notify Taskbar
    }

    public function index()
    {
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        #BEGIN: Menu
        $data['menuSelected'] = 'index';
        $data['menuType'] = 'product';
        #END Menu
        #BEGIN: Advertise
        $data['advertisePage'] = 'account';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter

        #Load view
        $this->load->view('home/user/defaults', $data);
    }


    public function profile($id)
    {
        if(! $this->session->userdata('sessionUser')){
            redirect(base_url() . "account", 'location');
            die();
        }

        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
        $this->load->model('order_model');
        #BEGIN: Advertise
        $data['advertisePage'] = 'account';
        $data['advertise'] = $this->advertise_model->fetch("adv_id, adv_title, adv_banner, adv_dir, adv_link, adv_page, adv_position,adv_iframe", "adv_status = 1 AND adv_enddate >= $currentDate", "adv_order", "ASC");
        #END Advertise
        #BEGIN: Counter
        $data['counter'] = $this->counter_model->get();
        #END Counter

        $this->load->model('district_model');
        $data['user'] = $profile = $this->user_model->get("use_id, use_username, use_group, parent_id, use_fullname, avatar, use_sex, use_address, use_email, use_mobile, use_yahoo, id_card, tax_type, tax_code, use_skype, use_province, user_district", 'use_id = '. (int)$id);
        $get_u = $this->user_model->get('use_id, use_group, parent_id', 'use_id = '.$this->session->userdata('sessionUser').' AND use_status = 1');

        $vt = '';
        $use_group = $profile->use_group;

        $tree = array();
        if ($use_group == StaffStoreUser){
            $tree[] = (int)$id;
        }

        $sub_tructiep = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group IN (' . BranchUser . ',' . StaffStoreUser . ',' . StaffUser . ',' . AffiliateUser . ') AND use_status = 1 AND parent_id = '.(int)$profile->use_id);
        
        if (!empty($sub_tructiep)) {
            foreach ($sub_tructiep as $key => $value) {
                //Nếu là chi nhánh, lấy danh sách nhân viên
                $tree[] = $value->use_id;               

                if ($value->use_group == StaffStoreUser) {
                    //Lấy danh sách CN dưới nó cua NVGH
                    $sub_cn = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group IN(' . BranchUser . ',' . StaffUser . ') AND use_status = 1 AND parent_id = ' . $value->use_id);
                    if (!empty($sub_cn)) {
                        foreach ($sub_cn as $k => $vlue) {
                            $tree[] = $vlue->use_id;
                            if ($vlue->use_group == BranchUser) {
                                $tree[] = $vlue->use_id;
                                //Lấy danh sách CN dưới nó cua NVGH
                                $sub_cn = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group = '. StaffUser .' AND use_status = 1 AND parent_id = '. $vlue->use_id);
                                if (! empty($sub_cn)) {
                                    foreach ($sub_cn as $k => $v) {
                                        $tree[] = $v->use_id;
                                    }
                                }
                            }
                        }
                    }
                }

                if ($value->use_group == BranchUser) {
                    //Lấy danh sách CN dưới nó cua NVGH
                    $sub_cn = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group = '. StaffUser .' AND use_status = 1 AND parent_id = '. $value->use_id);
                    if (!empty($sub_cn)) {
                        foreach ($sub_cn as $k => $v) {
                            $tree[] = $v->use_id;
                        }
                    }
                }
            }
        }
        $id = implode(',', $tree);

        //Get thông tin group
        if ($use_group == NormalUser) {
            $vt = 'Thành viên thường';
        } elseif ($use_group == AffiliateStoreUser) {
            $vt = 'Gian hàng';
        } elseif ($use_group == BranchUser) {           
            $vt = 'Chi nhánh';
        } elseif ($use_group == StaffStoreUser) {
            $vt = 'Nhân viên';
        } elseif ($use_group == AffiliateUser) {
            $vt = 'Cộng tác viên';
        } else {
            $vt = 'Nhân viên';
        }

        $data['vt'] = $vt;
        $data['thuocGH'] = $data['thuocNVGH'] = $data['thuocCN'] = $data['thuocNV'] = '';
        $data['idGH'] = $data['idNVGH'] = $data['idCN'] = $data['idNV'] = '';
        //End get thông tin group

        $get_p1 = $get_p = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = '. (int)$profile->parent_id);
        $group = array(StaffUser, BranchUser, StaffStoreUser);
        $data['group'] = $get_p1->use_group;
        $data['parent_id'] = $get_p1->use_group;
        $this->load->model('province_model');
        $filter = array(
            'select' => '*',
            'where' => "DistrictCode = '" . $data['user']->user_district . "'",
        );

        $district = $this->district_model->getDistrict($filter);
        // $province = $this->province_model->get("pre_id,pre_name", "pre_status = 1 AND pre_id = " . $data['user']->use_province);
        $data['district'] = $district[0]['DistrictName'];
        $data['province'] = $district[0]['ProvinceName'];
        /*tach doanh thu tu sp GH dang va sp CN tu dang*/
        $whereSaler = '';

        //gán dieu kien loai sp CN tu dang va sp tu gh khac
        if ($use_group == AffiliateStoreUser 
            || $use_group == StaffStoreUser 
            || $use_group == BranchUser 
            || $use_group == StaffUser) 
        {
            $tree1 = array();            
            if($get_p->use_group == AffiliateStoreUser){
                $GH = (int)$profile->parent_id; //cha la GH
            } elseif($get_p->use_group == BranchUser){
                $GH = (int)$get_p->parent_id;
            } else {
                if ($use_group == StaffStoreUser) {
                    $getp = $this->user_model->fetch('use_id,parent_id', 'use_id = ' . (int)$profile->use_id);
                    $tree1[] = $GH = (int)$getp[0]->parent_id;
                } else {
                    if ($get_p->use_group == StaffStoreUser) {
                        $GH = (int)$get_p->parent_id;
                    }                       
                }                
            }
            $sub_tructiep = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group IN (' . BranchUser . ',' . StaffStoreUser . ') AND use_status = 1 AND parent_id = '.(int)$profile->use_id);
            if (!empty($sub_tructiep)) {
                foreach ($sub_tructiep as $key => $value) {
                    //Nếu là chi nhánh, lấy danh sách nhân viên
                    if ($value->use_group == StaffStoreUser) {
                        //Lấy danh sách CN dưới nó cua NVGH
                        $sub_cn = $this->user_model->get_list_user('use_id, use_username, use_group', 'use_group = '. BranchUser .' AND use_status = 1 AND parent_id = '. $value->use_id);
                        if (!empty($sub_cn)) {
                            foreach ($sub_cn as $k => $vlue) {
                                $tree1[] = $vlue->use_id;
                            }
                        }
                    } else {
                        $tree1[] = $value->use_id;
                    }
                }
            }
            $idCN = implode(",", $tree1);
            if($get_u->use_group == AffiliateStoreUser || $get_u->use_group == StaffStoreUser) {
                if (($get_p->use_group == BranchUser && $use_group == StaffUser)) {
                    $whereSaler .= ' AND ((tbtt_showcart.shc_saler = '. $GH .' AND pro_of_shop > 0)';
                } else {
                    $whereSaler .= ' AND ((tbtt_showcart.shc_saler = '. $GH .' AND pro_of_shop = 0)';
                }
                if (!empty($idCN)) {
                    $whereSaler .= ' OR ((tbtt_showcart.shc_saler IN('. $idCN .')) AND pro_of_shop > 0)';
                }
                //dk danh cho tk CN
                if ($use_group == BranchUser) {
                    $whereSaler .= ' OR ((tbtt_showcart.shc_saler = '. (int)$profile->use_id .') AND pro_of_shop > 0)';
                }//end dk cua CN

                $whereSaler .= ')';
            }else{
                if($get_u->use_group == BranchUser) {
                    $whereSaler .= ' AND ((tbtt_showcart.shc_saler = '. $GH .')';

                    //dk danh cho tk CN
                    if ($use_group == BranchUser) {
                        $whereSaler .= ' OR ((tbtt_showcart.shc_saler = '. (int)$profile->use_id .') AND pro_of_shop > 0)';
                    }//end dk cua CN

                    $whereSaler .= ')';
                }
            }
        }
        //end gán dieu kien loai sp CN tu dang va sp tu gh khac

        $enddatenull = mktime(0, 0, 0, 01, 01, 2006);
        $whereSaler .= ' AND shc_change_status_date >= '.$enddatenull;
        /*end tach doanh thu tu sp GH dang va sp CN tu dang*/
        $shc_saler = $treeSaler = '';
        $select = "use_id, use_username, use_fullname, use_email, use_mobile, tbtt_shop.sho_link, tbtt_shop.sho_name, parent_id, tbtt_showcart.*, SUM(tbtt_showcart.shc_total) As showcarttotal,";
        $left3 = "LEFT";
        $tb3 = "tbtt_product";
        $join3 = "tbtt_showcart.shc_product = tbtt_product.pro_id"; //join bang de dat dieu kien pro_of_shop
        $join_4 = "LEFT";
        $table_4 = "tbtt_order";
        $on_4 = "tbtt_showcart.shc_orderid = tbtt_order.id"; //join bang de dat dieu kien pro_of_shop
        // $groupBy = 'id,tbtt_showcart.af_id,pro_id';
        $groupBy = '';
        $where = 'shc_status IN(01,02,03,98) AND (use_group = ' . AffiliateUser . ' or  use_group =' . BranchUser . ')' .$whereSaler .' AND use_status = 1';

        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $dm = explode('/',$this->getMainDomain());
        $url = substr(base_url(), 0,strlen(base_url())-1);
        $duoi = explode('//',$url);
        $data['parent'] = '';

        switch ($profile->use_group) {            
            case StaffStoreUser:
                $data['thuocGH'] = $get_p1->use_username;
                $data['idGH'] = $treeSaler = $get_p1->use_id;
                $where .= ' AND parent_id='. (int)$profile->use_id;
                $data['detailDT'] = 'account/statisticlistNVGH/userid/'.$profile->use_id;
                break;
          
            case BranchUser:
                $paCN_saler = $profile->use_id;
                if ($get_p1->use_group == StaffStoreUser) {
                    $get_p2 = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = '. $get_p1->parent_id);
                    $data['thuocGH'] = $get_p2->use_username;
                    $data['thuocNVGH'] = $get_p1->use_username;
                    $data['idGH'] = $get_p2->use_id;
                    $data['idNVGH'] = $get_p1->use_id;
                    $paGH_saler = $get_p2->use_id;
                    $linkNews = $this->shop_model->get('sho_link, domain', 'sho_user = '. $profile->use_id);
                } else {
                    $data['thuocGH'] = $get_p1->use_username;
                    $data['idGH'] = $get_p1->use_id;
                    $paGH_saler = $get_p1->use_id;
                    $linkNews = $this->shop_model->get('sho_link, domain', 'sho_user = '. $profile->use_id);
                }
                $shc_saler = ' AND ( ( shc_saler = '. $paGH_saler .' AND parent_id = ' . $profile->use_id . ') OR (shc_saler = '. $paCN_saler .' AND parent_id = ' . $profile->parent_id . ') )';
                $data['detailDT'] = 'account/detailstatisticlistbran/'.$profile->use_id;
                break;
            
            case AffiliateUser:

                $get_p2 = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = ' . $get_p1->parent_id);
                if($get_p2){
                    $get_p3 = $this->user_model->get('use_group, use_username, parent_id, use_id', 'use_id = '. $get_p2->parent_id); //lay cha thu 2
                }

                if ($get_p3->use_group == StaffStoreUser) {
                    $get_p4 = $this->user_model->get('use_group, use_username, parent_id, use_id', 'use_id = '. $get_p3->parent_id); //lay cha thu 3
                    $linkNews = $this->shop_model->get('sho_link, domain', 'sho_user = ' . $get_p4->use_id);
                    $data['thuocGH'] = $get_p4->use_username;
                    $data['idGH'] = $get_p4->use_id;

                    $data['thuocNVGH'] = $get_p3->use_username;
                    $data['idNVGH'] = $get_p3->use_id;

                    $data['thuocCN'] = $get_p2->use_username;
                    $data['idCN'] = $saler = $get_p2->use_id;
                    $treeSaler = $get_p4->use_id.','.$get_p2->use_id;

                    $data['thuocNV'] = $get_p1->use_username;
                    $data['idNV'] = $get_p1->use_id;
                    $pro_ofShop = ' AND pro_of_shop>0';
                } else {
                    if ($get_p2->use_group == AffiliateStoreUser || $get_p2->use_group == StaffStoreUser || $get_p2->use_group == BranchUser) {
                        if ($get_p2->use_group == AffiliateStoreUser) {
                            // $linkNews = $this->shop_model->get('sho_link, domain', 'sho_user = '. $get_p1->parent_id);
                            $linkNews = $this->shop_model->get('sho_link, domain', 'sho_user = '. $profile->use_id);
                            $data['thuocGH'] = $get_p2->use_username;
                            $data['idGH'] = $saler = $treeSaler = $get_p2->use_id;
                            $pro_ofShop = ' AND pro_of_shop=0';
                            if ($get_p1->use_group == StaffStoreUser) {
                                $data['thuocNVGH'] = $get_p1->use_username;
                                $data['idNVGH'] = $get_p1->use_id;
                            } else {
                                if ($get_p1->use_group == StaffUser) {
                                    $data['thuocNV'] = $get_p1->use_username;
                                    $data['idNV'] = $get_p1->use_id;
                                } else {
                                    $linkNews = $this->shop_model->get('sho_link, domain', 'sho_user = '. $profile->use_id);
                                    $data['thuocCN'] = $get_p1->use_username;
                                    $data['idCN'] = $saler = $get_p1->use_id;
                                    $treeSaler = $get_p2->use_id.','.$get_p1->use_id;
                                    $pro_ofShop = ' AND pro_of_shop > 0';
                                }
                            }
                        } else {
                            $linkNews = $this->shop_model->get('sho_link, domain', 'sho_user = '. $profile->use_id);
                            $data['thuocGH'] = $get_p3->use_username;
                            $data['idGH'] = $treeSaler = $get_p3->use_id;
                            if ($get_p2->use_group == BranchUser) {
                                $linkNews = $this->shop_model->get('sho_link, domain', 'sho_user = ' . $profile->use_id);
                                $data['thuocCN'] = $get_p2->use_username;
                                $data['idCN'] = $saler = $get_p2->use_id;
                                $data['thuocNV'] = $get_p1->use_username;
                                $data['idNV'] = $get_p1->use_id;
                                $treeSaler = $get_p2->use_id.','.$get_p3->use_id;
                            } else {
                                $data['thuocNVGH'] = $get_p2->use_username;
                                $data['idNVGH'] = $get_p2->use_id;
                                if ($get_p1->use_group == StaffUser) {
                                    $data['thuocNV'] = $get_p1->use_username;
                                    $data['idNV'] = $get_p1->use_id;
                                } else {
                                    $linkNews = $this->shop_model->get('sho_link, domain', 'sho_user = '. $profile->use_id);
                                    $data['thuocCN'] = $get_p1->use_username;
                                    $data['idCN'] = $saler = $get_p1->use_id;
                                    $treeSaler = $get_p3->use_id.','.$get_p1->use_id;
                                }
                            }
                            $pro_ofShop = ' AND pro_of_shop>0';
                        }
                    } else {
                        if ($get_p2->use_group == StaffStoreUser) {
                            $linkNews = $this->shop_model->get('sho_link, domain', 'sho_user = '. $profile->use_id);
                            $data['thuocGH'] = $get_p3->use_username;
                            $data['idGH'] = $get_p3->use_id;

                            $data['thuocNVGH'] = $get_p2->use_username;
                            $data['idNVGH'] = $get_p2->use_id;

                            $data['thuocCN'] = $get_p1->use_username;
                            $data['idCN'] = $saler = $get_p1->use_id;
                            $treeSaler = $get_p3->use_id.','.$get_p1->use_id;
                            $pro_ofShop = ' AND pro_of_shop > 0';
                        } else {
                            $linkNews = $this->shop_model->get('sho_link, domain', 'sho_user = '. $profile->use_id);
                            $data['thuocGH'] = $get_p1->use_username;
                            $data['idGH'] = $saler =$treeSaler = $get_p1->use_id;
                            $pro_ofShop = ' AND pro_of_shop = 0';
                        }
                    }
                }

                $get_pu = $this->user_model->get('use_id, use_group', 'use_status = 1 AND use_id = ' . (int)$get_u->parent_id);//get parent session user

                if($get_u->use_group == BranchUser || ($get_u->use_group == StaffUser && $get_pu->use_group == BranchUser)) {
                    $pro_ofShop='';
                }
                $where = 'use_status = 1 AND shc_status IN(01,02,03,98) AND use_group =' . AffiliateUser.' AND tbtt_showcart.shc_saler = ' . (int)$saler.' AND tbtt_showcart.af_id ='.$profile->use_id.$pro_ofShop;
                $data['detailDT'] = 'account/detailstatisticlistaffiliate/'.$profile->use_id;
                break;
        }
        // $shoName = $linkNews->sho_link.'.'.$duoi[1].$dm[1];
        $shoName = $linkNews->sho_link.'.'.$duoi[1].$dm[1];
        if($linkNews->domain != ''){
            // $shoName = $linkNews->domain;
            $shoName = $linkNews->domain;
        }

        $data['parent'] = $protocol.$shoName;

        $where .=  $shc_saler;        
        $total_dt = $this->user_model->fetch_join4($select, "INNER", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", "LEFT", "tbtt_showcart", "tbtt_user.use_id = tbtt_showcart.af_id or tbtt_user.use_id = tbtt_showcart.shc_saler", $left3, $tb3, $join3, $join_4, $table_4, $on_4, $where, '', '', '', '',false,$groupBy);
        $tongDT = 0;
        foreach ($total_dt as $vl){
            $tongDT += $vl->shc_total;
        }
        $tongDT =$total_dt[0]->showcarttotal;
        $data['doanhthu'] = $tongDT;
        $this->session->set_userdata('tree_array', $treeSaler);
        #Load view
        $data['titleSiteGlobal'] = "Thông tin " . $data['user']->use_username;

        $this->load->view('home/user/defaults', $data);
    }

    public function doanhthuAff()
    {
        $dateto = $this->session->userdata('dateto');
        $datefrom = $this->session->userdata('datefrom');
        $data['afsavedateto'] = $dateto;
        $data['afsavedatefrom'] = $datefrom;

        $monthsto = date('m', strtotime($dateto));
        $dayto = date('d', strtotime($dateto));
        $yearto = date('y', strtotime($dateto));

        $monthsfrom = date('m', strtotime($datefrom));
        $dayfrom = date('d', strtotime($datefrom));
        $yearfrom = date('y', strtotime($datefrom));
        $startdate = mktime(0, 0, 0, $monthsto, $dayto, $yearto);
        $enddate = mktime(23, 59, 59, $monthsfrom, $dayfrom, $yearfrom);
        $enddatenull = mktime(0, 0, 0, 01, 01, 2006);

        $group_id = $this->session->userdata('sessionGroup');
        if ($group_id == AffiliateStoreUser
            || $group_id == Developer2User
            || $group_id == Developer1User
            || $group_id == Partner2User
            || $group_id == Partner1User
            || $group_id == CoreMemberUser
            || $group_id == CoreAdminUser
            || $group_id == AffiliateUser
            || $group_id == StaffUser
            || $group_id == BranchUser
        ) {
        } else {
            redirect(base_url() . "account", 'location');
            die();
        }
        $tree = $this->session->userdata('tree_array'); //get session tree array from Statiscal Affiliate

        $sort = 'use_id';
        $by = 'DESC';
        $sortUrl = '';
        $pageUrl = '';
        $pageSort = '';
        $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(3, $action);
        #If have sort
        if ($getVar['sort'] != FALSE && trim($getVar['sort']) != '') {
            switch (strtolower($getVar['sort'])) {
                case 'doanhthu':
                    $pageUrl .= '/sort/doanhthu';
                    $sort = "showcarttotal";
                    break;
                default:
                    $pageUrl .= '/sort/id';
                    $sort = "use_id";
            }
            if ($getVar['by'] != FALSE && strtolower($getVar['by']) == 'desc') {
                $pageUrl .= '/by/desc';
                $by = "DESC";
            } else {
                $pageUrl .= '/by/asc';
                $by = "ASC";
            }
        }
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & sort
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'account/detailstatisticlistaffiliate' . $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        $where = '';
        #END Create link sort
        #Keyword
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'account/detailstatisticlistaffiliate' . $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;
        #END Create link sort
        $this->load->library('pagination');
        if ($this->uri->segment('3') != 'page') {
            $tree_af_id = $this->uri->segment('3');
            $this->session->set_userdata('tree_af_id', $tree_af_id);
        }
        $tree_af_id_session = $this->session->userdata('tree_af_id');
        $wherestore = 'use_status = 1 AND use_group = 2 AND use_id = ' . $tree_af_id_session;// . ' AND shc_saler IN (' . $tree . ')';
        if ($dateto != '' && $datefrom != '') {
            $wherestore .= " AND shc_change_status_date >= " . (float)$startdate . " AND shc_change_status_date <= " . (float)$enddate;
        } else {
            $wherestore .= " AND shc_change_status_date >= " . (float)$enddatenull;
        }
        #BEGIN: Pagination
        #Count total record
        $totalRecord = count($this->user_model->fetch_join2("use_id, shc_id,  pro_id", "INNER", "tbtt_showcart", "tbtt_user.use_id = tbtt_showcart.af_id", "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", $wherestore, '', '', '', ''));
        $config['base_url'] = base_url() . 'account/detailstatisticlistaffiliate' . $pageUrl . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = settingOtherAccount;
        $config['num_links'] = 1;
        $config['uri_segment'] = 4;
        $limit = 20;
        $config['cur_page'] = $start;
        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        $data['stt'] = $start;
        #END Pagination
        #sTT - So thu tu
        $liststoreAF = $this->user_model->fetch_join2("shc_orderid, use_username, shc_quantity, shc_change_status_date, shc_total, pro_name", "INNER", "tbtt_showcart", "tbtt_user.use_id = tbtt_showcart.af_id", "LEFT", "tbtt_product", "tbtt_showcart.shc_product = tbtt_product.pro_id", $wherestore, $sort, $by, $start, $limit);
        $data['liststoreAF'] = $liststoreAF;
        if ($sort == 'showcarttotal') {
            $pageUrl .= '/sort/id';
            $sort = "use_id";
        }

        //Unset session data TREE_ARRAY
        //$this->session->unset_userdata('tree_array');
        #Load view
        $use_id = (int)$this->input->post('use_id');
        $shop_id = (int)$this->input->post('parent_shop_id');
        if (isset($use_id) && $use_id > 0) {
            $this->user_model->update(array('parent_shop' => $shop_id), 'use_id = ' . $use_id);
            echo '1';
            return false;
            exit();
        }
        $data['menuSelected'] = 'statistic';
        $data['menuType'] = 'account';
        $this->load->view('home/user/doanhthuAff', $data);
    }

    public function listaffiliate()
    {
        $action = array('detail', 'search', 'keyword', 'sort', 'by', 'page');
        $getVar = $this->uri->uri_to_assoc(4, $action);

        $sort = '';
        $by = 'DESC';
        $sortUrl = '';
        $pageUrl = '';
        $pageSort = '';

        $getid = $this->uri->segment('3');
        #If have page
        if ($getVar['page'] != FALSE && (int)$getVar['page'] > 0) {
            $start = (int)$getVar['page'];
            $pageSort .= '/page/' . $start;
        } else {
            $start = 0;
        }
        #END Search & sort
        #BEGIN: Create link sort
        $data['sortUrl'] = base_url() . 'user/listaffiliate/'. $this->uri->segment(3) . $sortUrl . '/sort/';
        $data['pageSort'] = $pageSort;

        $tree = array();
        $this->session->set_userdata('tree_array', $getid);
        $select = 'use_id, use_username, use_fullname, use_group, use_email, use_mobile, parent_id, sho_id, sho_link, sho_name, sho_user, domain, tbtt_showcart.*, SUM(tbtt_showcart.shc_total) As showcarttotal';
        $where = 'use_group = 2 AND use_status = 1 AND parent_id ="' . $getid . '"';

        #BEGIN: Pagination
        $limmit = 20;
        $this->load->library('pagination');
        $totalRecord = count($this->user_model->fetch_join1($select, "INNER", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", "LEFT", "tbtt_showcart", "tbtt_user.use_id = tbtt_showcart.af_id", $where, $sort, $by, $start, ''));
        $config['cur_page'] = $start;
        $config['base_url'] = base_url() . 'user/listaffiliate/' . $this->uri->segment(3) . '/page/';
        $config['total_rows'] = $totalRecord;
        $config['per_page'] = $limmit;
        $config['num_links'] = 5;
        $config['uri_segment'] = 3;
        $config['cur_page'] = $start;
        $data['sTT'] = $start;

        $this->pagination->initialize($config);
        $data['linkPage'] = $this->pagination->create_links();
        $model_aff = $this->user_model->fetch_join1($select, "INNER", "tbtt_shop", "tbtt_user.use_id = tbtt_shop.sho_user", "LEFT", "tbtt_showcart", "tbtt_user.use_id = tbtt_showcart.af_id", $where, $sort, $by, $start, $limmit);
        // Get thong tin Chi Nhanh or Nhan vien cho tung Affiliate

        $parent = $this->user_model->get('*', 'use_id = ' . $getid);
        $data['parent_name'] = $parent->use_username;
        $LArray = array();
        if (!empty($model_aff)) {
            foreach ($model_aff as $key => $row) {
                $haveDomain = $info_parent = $pshop = $pgroup = '';
                $LArray[] = array(
                    'use_id' => $row->use_id,
                    'use_username' => $row->use_username,
                    'use_group' => $row->use_group,
                    'use_fullname' => $row->use_fullname,
                    'use_email' => $row->use_email,
                    'use_mobile' => $row->use_mobile,
                    'parent_id' => $row->parent_id,
                    'sho_link' => $row->sho_link,
                    'sho_name' => $row->sho_name,
                    'sho_user' => $row->sho_user,
                    'showcarttotal' => $row->showcarttotal,
                    'info_parent' => $info_parent,
                    'haveDomain' => $row->domain,
                    'pshop' => $row->sho_link,
                    'pgroup' => $pgroup
                );
            }
        }
        $data['totalaff'] = $LArray;
        $data['totalRecord'] = $totalRecord;
        #Load View
        $this->load->view('home/user/listaffiliate', $data);
    }
    public function loadCategory($parent, $level)
    {
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent'";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
        if (count($category) > 0) {
            $retArray .= "<ul id='mega-1' class='mega-menu right'>";
            foreach ($category as $key => $row) {                
                $link = '<a href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
                if ($key == 0) {
                    $retArray .= "<li class='menu_item_top dc-mega-li'>" . $link;
                } else if ($key == count($category) - 1) {
                    $retArray .= "<li class='menu_item_last dc-mega-li'>" . $link;
                } else {
                    $retArray .= "<li class='dc-mega-li'>" . $link;
                }
                $retArray .= $this->loadSubCategory($row->cat_id, $level + 1);
                $retArray .= "</li>";
            }
            $retArray .= "</ul>";
        }
        return $retArray;
    }

    public function loadSubCategory($parent, $level)
    {
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent'";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
        if (count($category) > 0) {
            $retArray .= "<div class='sub-container mega'>";
            $retArray .= "<ul class='sub'>";
            $rowwidth = 190;
            if (count($category) == 2) {
                $rowwidth = 450;
            }
            if (count($category) >= 3) {
                $rowwidth = 660;
            }
            foreach ($category as $key => $row) {                
                $link = '<a class="mega-hdr-a"  href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
                if ($key % 3 == 0) {
                    $retArray .= "<div class='row' style='width: " . $rowwidth . "px;'>";
                    $retArray .= "<li class='mega-unit mega-hdr'>";
                    $retArray .= $link;
                    $retArray .= $this->loadSubSubCategory($row->cat_id, $level + 1);
                    $retArray .= "</li>";
                } else if ($key % 3 == 1) {
                    $retArray .= "<li class='mega-unit mega-hdr'>";
                    $retArray .= $link;
                    $retArray .= $this->loadSubSubCategory($row->cat_id, $level + 1);
                    $retArray .= "</li>";
                } else if ($key % 3 == 2 || $key = count($category) - 1) {
                    $retArray .= "<li class='mega-unit mega-hdr'>";
                    $retArray .= $link;
                    $retArray .= $this->loadSubSubCategory($row->cat_id, $level + 1);
                    $retArray .= "</li>";
                    $retArray .= "</div>";
                }
            }
            $retArray .= "</ul></div>";
        }
        return $retArray;
    }

    public function loadSubSubCategory($parent, $level)
    {
        $retArray = '';
        $select = "*";
        $whereTmp = "cat_status = 1  and parent_id='$parent'";
        $category = $this->category_model->fetch($select, $whereTmp, "cat_name", "ASC");
        if (count($category) > 0) {
            $retArray .= "<ul>";
            foreach ($category as $key => $row) {                
                $link = '<a href="' . base_url() . $row->cat_id . '/' . RemoveSign($row->cat_name) . '">' . $row->cat_name . '</a>';
                $retArray .= "<li>" . $link . "</li>";
            }
            $retArray .= "</ul>";
        }
        return $retArray;
    }

    public function check_username()
    {
        $count = 0;
        $username = trim($this->input->post('idUser'));
        $this->load->model('user_model');
        $re = $this->user_model->getUserByUsername($username);
        $count = count($re);
        if ($count == 0) echo "0";
        else echo "1";
        exit();
    }

    public function ajax_lien_he()
    {
        $q = $_REQUEST["q"];
        if (!$q) return;
        $this->load->model('user_model');
        $currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

        #BEGIN: autocomplete Users
        $select = "use_username";
        $this->db->like('use_username', $q);
        $allUsers = $this->user_model->fetch($select, "use_status = 1 AND (use_enddate >= $currentDate OR use_enddate = 0)", "use_username", "DESC");
        #END autocomplete Users

        foreach ($allUsers as $item) {
            echo "$item->use_username|$item->use_username\n";
        }
    }

    public function getMainDomain()
    {
        $result = base_url();
        $sub = $this->getShopLink();
        if ($sub != '') {
            $result = str_replace('//' . $sub . '.', '//', $result);
        }
        return $result;
    }

    public function getShopLink()
    {
        $result = '';
        $arrUrl = explode('.', $_SERVER['HTTP_HOST']);
        if (count($arrUrl) === 3) {
            $result = $arrUrl[0];
        }
        return $result;
    }
    
    public function updateprofile() {        
        # Begin: Kiểm tra quyền truy cập nhân viên hành chính
        if ($this->session->userdata('sessionGroup') == SubAdminUser) {
            if (! $this->check_permis_subadmin((int)$this->session->userdata('sessionUser'), 4)) {
                redirect(base_url() . 'account', 'location');
                die();
            }
        }
        # End: Kiểm tra quyền truy cập nhân viên hành chính

	    $data['menuType'] = 'account';
	    $data['menuSelected'] = 'updateprofile';
	    $data['menuPanelGroup'] = 1;
        $userid = (int) $this->session->userdata('sessionUser');
        if(empty($userid)){
            redirect(base_url() . 'login', 'location');
            die();
        }
	
	    $data['user'] = $this->user_model->get("use_email,use_fullname,use_birthday,use_sex,use_mobile","use_id = ".$userid);	
        $query = $this->db->query('SELECT * FROM tbtt_resume WHERE userid = '. $userid);
        $resume_edit = $query->row();
        
        if(empty($resume_edit)) {
            $this->db->insert("tbtt_resume", array('userid' => $userid));       
        } 
        
        $data['updateProfile'] = 0;
        if ($this->input->post('updateinfo') == 'update') {
            $this->load->library('upload');
            $this->load->library('image_lib');
            $pathUpload = "media/images/profiles/";
            $dirUpload = $userid;
            if (!is_dir($pathUpload . $dirUpload)) {
                @mkdir($pathUpload . $dirUpload, 0777, true);
                $this->load->helper('file');
                @write_file($pathUpload . $dirUpload . '/index.html', '<p>Directory access is forbidden.</p>');
            }
            $configUpload['upload_path'] = $pathUpload . $dirUpload . '/';
            $configUpload['allowed_types'] = 'gif|jpg|jpeg|png';
            $configUpload['encrypt_name'] = true;
            $configUpload['max_size'] = '10240';
            $this->upload->initialize($configUpload);
            $this->load->library('ftp');
            $configftp['hostname'] = IP_CLOUDSERVER;
            $configftp['username'] = USER_CLOUDSERVER;
            $configftp['password'] = PASS_CLOUDSERVER;
            $configftp['port'] = PORT_CLOUDSERVER;
            $configftp['debug'] = TRUE;
            $this->ftp->connect($configftp);
            $pathTarget = '/public_html/media/images/profiles/';
            $listDir = array();
            $listDir = $this->ftp->list_files($pathTarget);
            if (!in_array($dirUpload, $listDir)) {
                $this->ftp->mkdir($pathTarget . $dirUpload, 0775);
            }

            if ($this->upload->do_upload('logo_new')) {
                $uploadData = $this->upload->data();
                if ($uploadData['is_image'] == TRUE) {
                    if ($resume_edit->logo && is_array(getimagesize(DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $dirUpload . '/' . $resume_edit->logo))) {
                        $this->ftp->delete_file($pathTarget . $userid . '/' . $resume_edit->logo);
                    }
                    $logo = $uploadData['file_name'];
                    $configResize = array(
                        'source_image' => $pathUpload . $dirUpload . '/' . $logo,
                        'new_image' => $pathUpload . $dirUpload . '/' . $logo,
                        'maintain_ratio' => true,
                        'quality' => '90%',
                        'width' => '1',
                        'height' => '40',
                        'master_dim' => 'height'
                    );
                    $this->image_lib->clear();
                    $this->image_lib->initialize($configResize);
                    $this->image_lib->resize();
                }
                $source_path = $pathUpload . $dirUpload . '/' . $logo;
                $target_path = $pathTarget . $dirUpload . '/' . $logo;
                $this->ftp->upload($source_path, $target_path, 'auto', 0775);
            } else {
                $logo = $this->input->post('logo');
            }

            if ($this->upload->do_upload('banner_new')) {
                $uploadData = $this->upload->data();
                if ($uploadData['is_image'] == TRUE) {
                    if ($resume_edit->banner && is_array(getimagesize(DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $dirUpload . '/' . $resume_edit->banner))) {
                        $this->ftp->delete_file($pathTarget . $userid . '/' . $resume_edit->banner);
                    }
                    $banner = $uploadData['file_name'];
                    $configResize = array(
                        'source_image' => $pathUpload . $dirUpload . '/' . $banner,
                        'new_image' => $pathUpload . $dirUpload . '/' . $banner,
                        'maintain_ratio' => true,
                        'quality' => '90%',
                        'width' => '1600',
                        'height' => '1',
                        'master_dim' => 'width'
                    );
                    $this->image_lib->clear();
                    $this->image_lib->initialize($configResize);
                    $this->image_lib->resize();
                }
                $source_path = $pathUpload . $dirUpload . '/' . $banner;
                $target_path = $pathTarget . $dirUpload . '/' . $banner;
                $this->ftp->upload($source_path, $target_path, 'auto', 0775);
            } else {
                $banner = $this->input->post('banner');
            }

            if ($this->upload->do_upload('company_image_new')) {
                $uploadData = $this->upload->data();
                if ($uploadData['is_image'] == TRUE) {
                    if ($resume_edit->company_image && is_array(getimagesize(DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $dirUpload . '/' . $resume_edit->company_image))) {
                        $this->ftp->delete_file($pathTarget . $userid . '/' . $resume_edit->company_image);
                    }
                    $company_image = $uploadData['file_name'];
                    $configResize = array(
                        'source_image' => $pathUpload . $dirUpload . '/' . $company_image,
                        'new_image' => $pathUpload . $dirUpload . '/' . $company_image,
                        'maintain_ratio' => true,
                        'quality' => '90%',
                        'width' => '400',
                        'height' => '1',
                        'master_dim' => 'width'
                    );
                    $this->image_lib->clear();
                    $this->image_lib->initialize($configResize);
                    $this->image_lib->resize();
                }
                $source_path = $pathUpload . $dirUpload . '/' . $company_image;
                $target_path = $pathTarget . $dirUpload . '/' . $company_image;
                $this->ftp->upload($source_path, $target_path, 'auto', 0775);
            } else {
                $company_image = $this->input->post('company_image');
            }

            if ($this->upload->do_upload('slogan_bg_new')) {
                $uploadData = $this->upload->data();
                if ($uploadData['is_image'] == TRUE) {
                    if ($resume_edit->slogan_bg && is_array(getimagesize(DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $dirUpload . '/' . $resume_edit->slogan_bg))) {
                        $this->ftp->delete_file($pathTarget . $userid . '/' . $resume_edit->slogan_bg);
                    }
                    $slogan_bg = $uploadData['file_name'];
                    $configResize = array(
                        'source_image' => $pathUpload . $dirUpload . '/' . $slogan_bg,
                        'new_image' => $pathUpload . $dirUpload . '/' . $slogan_bg,
                        'maintain_ratio' => true,
                        'quality' => '90%',
                        'width' => '1600',
                        'height' => '1',
                        'master_dim' => 'width'
                    );
                    $this->image_lib->clear();
                    $this->image_lib->initialize($configResize);
                    $this->image_lib->resize();
                }
                $source_path = $pathUpload . $dirUpload . '/' . $slogan_bg;
                $target_path = $pathTarget . $dirUpload . '/' . $slogan_bg;
                $this->ftp->upload($source_path, $target_path, 'auto', 0775);
            } else {
                $slogan_bg = $this->input->post('slogan_bg');
            }
            
            /* services */           
            $services = array();                
            foreach ($_FILES['imageService']['name'] as $i => $val) {
                $_FILES['img[]']['name']=  $_FILES['imageService']['name'][$i];
                $_FILES['img[]']['type']= $_FILES['imageService']['type'][$i];
                $_FILES['img[]']['tmp_name']= $_FILES['imageService']['tmp_name'][$i];
                $_FILES['img[]']['error']= $_FILES['imageService']['error'][$i];
                $_FILES['img[]']['size']= $_FILES['imageService']['size'][$i];
                if ($this->upload->do_upload('img[]')) {
                    $uploadData = $this->upload->data();
                    if ($uploadData['is_image'] == TRUE) {
                        $imageService = $uploadData['file_name'];
                        // Crop image 16x9
                        $configCrop['source_image'] = $pathUpload . $dirUpload . '/' . $imageService;
                        $configCrop['new_image'] = $pathUpload . $dirUpload . '/' . $imageService;
                        $configCrop['maintain_ratio'] = FALSE;
                        $w = $uploadData['image_width'];
                        $h = $uploadData['image_height'];
                        if( $w > $h && $h <= $w / 16 * 9 ){
                            $configCrop['width'] = $h / 9 * 16;
                            $configCrop['height'] = $h;
                            $configCrop['x_axis'] = ($w - $configCrop['width']) / 2;
                            $configCrop['y_axis'] = 0;
                        }
                        if (($w <= $h ) || ( $w > $h && $h > $w / 16 * 9 )) {
                            $configCrop['width'] = $w;
                            $configCrop['height'] = $w / 16 * 9;
                            $configCrop['y_axis'] = ($h - $configCrop['height']) / 2;
                            $configCrop['x_axis'] = 0;
                        }
                        $this->image_lib->initialize($configCrop);
                        $this->image_lib->crop();
                        $this->image_lib->clear();
                        /*resize image via height 480x270 */
                        $configImage['source_image'] = $pathUpload . $dirUpload . '/' . $imageService;
                        $configImage['new_image'] = $pathUpload . $dirUpload . '/' . $imageService;
                        $configImage['maintain_ratio'] = TRUE;
                        $configImage['width'] = 1;
                        $configImage['height'] = 270;
                        $configImage['quality'] = 90;
                        $configImage['master_dim'] = 'height';
                        $this->image_lib->initialize($configImage);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                    }
                    // upload this image to other server 
                    
                    if (file_exists($pathUpload . $dirUpload . '/' . $imageService)) {
                        $source_path = $pathUpload . $dirUpload . '/' . $imageService;
                        $target_path = $pathTarget . $dirUpload . '/' . $imageService;
                        $this->ftp->upload($source_path, $target_path, 'auto', 0775);
                        if($this->input->post('imageServiceOld')[$i] != '') {
                            $this->ftp->delete_file($pathTarget . $dirUpload .'/'.  $this->input->post('imageServiceOld')[$i]); 
                        } //endif                                               
                    }                                               
                } else {
                    $imageService = $this->input->post('imageServiceOld')[$i];
                }  
                $services[$i]->image = $imageService;
                $services[$i]->title = $this->input->post('titleService')[$i];
                $services[$i]->desc = $this->input->post('descService')[$i];
                $services[$i]->url = $this->input->post('urlService')[$i];                
            }                
            

            $statistic[0]->label = $this->input->post('statistic_label_0');
            $statistic[0]->number = $this->input->post('statistic_number_0');

            $statistic[1]->label = $this->input->post('statistic_label_1');
            $statistic[1]->number = $this->input->post('statistic_number_1');

            $statistic[2]->label = $this->input->post('statistic_label_2');
            $statistic[2]->number = $this->input->post('statistic_number_2');

            $statistic[3]->label = $this->input->post('statistic_label_3');
            $statistic[3]->number = $this->input->post('statistic_number_3');


            if ($this->upload->do_upload('statistic_bg_new')) {
                $uploadData = $this->upload->data();
                if ($uploadData['is_image'] == TRUE) {
                    if ($resume_edit->statistic_bg && is_array(getimagesize(DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $dirUpload . '/' . $resume_edit->statistic_bg))) {
                        $this->ftp->delete_file($pathTarget . $userid . '/' . $resume_edit->statistic_bg);
                    }
                    $statistic_bg = $uploadData['file_name'];
                }
                $source_path = $pathUpload . $dirUpload . '/' . $statistic_bg;
                $target_path = $pathTarget . $dirUpload . '/' . $statistic_bg;
                $this->ftp->upload($source_path, $target_path, 'auto', 0775);
            } else {
                $statistic_bg = $this->input->post('statistic_bg');
            }

            $product_cat = json_encode(array(
                $this->input->post('product_cat_0'),
                $this->input->post('product_cat_1'),
                $this->input->post('product_cat_2'),
                $this->input->post('product_cat_3')
            ));

           
            // BEGIN: product_list_0 
            $product_list_0 = array();                
            foreach ($_FILES['product_image_0']['name'] as $i => $val) {
                $_FILES['img[]']['name']=  $_FILES['product_image_0']['name'][$i];
                $_FILES['img[]']['type']= $_FILES['product_image_0']['type'][$i];
                $_FILES['img[]']['tmp_name']= $_FILES['product_image_0']['tmp_name'][$i];
                $_FILES['img[]']['error']= $_FILES['product_image_0']['error'][$i];
                $_FILES['img[]']['size']= $_FILES['product_image_0']['size'][$i];
                if ($this->upload->do_upload('img[]')) {
                    $uploadData = $this->upload->data();
                    if ($uploadData['is_image'] == TRUE) {
                        $file_name = $uploadData['file_name'];
                        // Crop image 1x1
                        $configCrop['source_image'] = $pathUpload . $dirUpload . '/' . $file_name;
                        $configCrop['new_image'] = $pathUpload . $dirUpload . '/' . $file_name;
                        $configCrop['maintain_ratio'] = FALSE;
                        $w = $uploadData['image_width'];
                        $h = $uploadData['image_height'];
                        if ($w != $h) {
                            if ($w > $h) {
                                $width = $h;
                                $height = $h;
                                $y_axis = 0;
                                $x_axis = ($w - $width) / 2;
                            }
                            if ($w < $h) {
                                $width = $w;
                                $height = $w;
                                $y_axis = ($h - $height) / 2;
                                $x_axis = 0;
                            }
                            $configCrop = array(
                                'source_image' => $pathUpload . $dirUpload . '/' . $file_name,
                                'new_image' => $pathUpload . $dirUpload . '/' . $file_name,
                                'maintain_ratio' => FALSE,
                                'width' => $width, 'height' => $height,
                                'x_axis' => $x_axis, 'y_axis' => $y_axis
                            );
                            $this->image_lib->initialize($configCrop);
                            $this->image_lib->crop();
                            $this->image_lib->clear();
                        }
                        #BEGIN: Resize image
                        $img_config = array(
                            'source_image' => $pathUpload . $dirUpload . '/' . $file_name,
                            'new_image' => $pathUpload . $dirUpload . '/' . $file_name,
                            'maintain_ratio' => true,
                            'quality' => '90%',
                            'width' => '600',
                            'height' => '600'
                        );
                        $this->image_lib->initialize($img_config);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                    }
                    // upload this image to other server 
                    
                    if (file_exists($pathUpload . $dirUpload . '/' . $file_name)) {
                        $source_path = $pathUpload . $dirUpload . '/' . $file_name;
                        $target_path = $pathTarget . $dirUpload . '/' . $file_name;
                        $this->ftp->upload($source_path, $target_path, 'auto', 0775);  
                        if($this->input->post('product_image_0_old')[$i] != '') {
                            $this->ftp->delete_file($pathTarget . $dirUpload .'/'.  $this->input->post('product_image_0_old')[$i]); 
                        }                                               
                    }                                               
                } else {
                    $file_name = $this->input->post('product_image_0_old')[$i];
                }  
                $product_list_0[$i]->image = $file_name;
                $product_list_0[$i]->title = $this->input->post('product_title_0')[$i];
                $product_list_0[$i]->url = $this->input->post('product_url_0')[$i];                
                $product_list_0[$i]->cat = $this->input->post('product_cat_0');                
            }
            // END: product_list_0
            
            // BEGIN: product_list_1 
            $product_list_1 = array();                
            foreach ($_FILES['product_image_1']['name'] as $i => $val) {
                $_FILES['img[]']['name']=  $_FILES['product_image_1']['name'][$i];
                $_FILES['img[]']['type']= $_FILES['product_image_1']['type'][$i];
                $_FILES['img[]']['tmp_name']= $_FILES['product_image_1']['tmp_name'][$i];
                $_FILES['img[]']['error']= $_FILES['product_image_1']['error'][$i];
                $_FILES['img[]']['size']= $_FILES['product_image_1']['size'][$i];
                if ($this->upload->do_upload('img[]')) {
                    $uploadData = $this->upload->data();
                    if ($uploadData['is_image'] == TRUE) {
                        $file_name = $uploadData['file_name'];
                        // Crop image 1x1
                        $configCrop['source_image'] = $pathUpload . $dirUpload . '/' . $file_name;
                        $configCrop['new_image'] = $pathUpload . $dirUpload . '/' . $file_name;
                        $configCrop['maintain_ratio'] = FALSE;
                        $w = $uploadData['image_width'];
                        $h = $uploadData['image_height'];
                        if ($w != $h) {
                            if ($w > $h) {
                                $width = $h;
                                $height = $h;
                                $y_axis = 0;
                                $x_axis = ($w - $width) / 2;
                            }
                            if ($w < $h) {
                                $width = $w;
                                $height = $w;
                                $y_axis = ($h - $height) / 2;
                                $x_axis = 0;
                            }
                            $configCrop = array(
                                'source_image' => $pathUpload . $dirUpload . '/' . $file_name,
                                'new_image' => $pathUpload . $dirUpload . '/' . $file_name,
                                'maintain_ratio' => FALSE,
                                'width' => $width, 'height' => $height,
                                'x_axis' => $x_axis, 'y_axis' => $y_axis
                            );
                            $this->image_lib->initialize($configCrop);
                            $this->image_lib->crop();
                            $this->image_lib->clear();
                        }
                        #BEGIN: Resize image
                        $img_config = array(
                            'source_image' => $pathUpload . $dirUpload . '/' . $file_name,
                            'new_image' => $pathUpload . $dirUpload . '/' . $file_name,
                            'maintain_ratio' => true,
                            'quality' => '90%',
                            'width' => '600',
                            'height' => '600'
                        );
                        $this->image_lib->initialize($img_config);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                    }
                    // upload this image to other server 
                    
                    if (file_exists($pathUpload . $dirUpload . '/' . $file_name)) {
                        $source_path = $pathUpload . $dirUpload . '/' . $file_name;
                        $target_path = $pathTarget . $dirUpload . '/' . $file_name;
                        $this->ftp->upload($source_path, $target_path, 'auto', 0775);  
                        if($this->input->post('product_image_1_old')[$i] != '') {
                            $this->ftp->delete_file($pathTarget . $dirUpload .'/'.  $this->input->post('product_image_1_old')[$i]); 
                        }                                               
                    }                                               
                } else {
                    $file_name = $this->input->post('product_image_1_old')[$i];
                }  
                $product_list_1[$i]->image = $file_name;
                $product_list_1[$i]->title = $this->input->post('product_title_1')[$i];
                $product_list_1[$i]->url = $this->input->post('product_url_1')[$i];
                $product_list_1[$i]->cat = $this->input->post('product_cat_1');                
            }
            // END: product_list_1
            
            // BEGIN: product_list_2 
            $product_list_2 = array();                
            foreach ($_FILES['product_image_2']['name'] as $i => $val) {
                $_FILES['img[]']['name']=  $_FILES['product_image_2']['name'][$i];
                $_FILES['img[]']['type']= $_FILES['product_image_2']['type'][$i];
                $_FILES['img[]']['tmp_name']= $_FILES['product_image_2']['tmp_name'][$i];
                $_FILES['img[]']['error']= $_FILES['product_image_2']['error'][$i];
                $_FILES['img[]']['size']= $_FILES['product_image_2']['size'][$i];
                if ($this->upload->do_upload('img[]')) {
                    $uploadData = $this->upload->data();
                    if ($uploadData['is_image'] == TRUE) {
                        $file_name = $uploadData['file_name'];
                        // Crop image 1x1
                        $configCrop['source_image'] = $pathUpload . $dirUpload . '/' . $file_name;
                        $configCrop['new_image'] = $pathUpload . $dirUpload . '/' . $file_name;
                        $configCrop['maintain_ratio'] = FALSE;
                        $w = $uploadData['image_width'];
                        $h = $uploadData['image_height'];
                        if ($w != $h) {
                            if ($w > $h) {
                                $width = $h;
                                $height = $h;
                                $y_axis = 0;
                                $x_axis = ($w - $width) / 2;
                            }
                            if ($w < $h) {
                                $width = $w;
                                $height = $w;
                                $y_axis = ($h - $height) / 2;
                                $x_axis = 0;
                            }
                            $configCrop = array(
                                'source_image' => $pathUpload . $dirUpload . '/' . $file_name,
                                'new_image' => $pathUpload . $dirUpload . '/' . $file_name,
                                'maintain_ratio' => FALSE,
                                'width' => $width, 'height' => $height,
                                'x_axis' => $x_axis, 'y_axis' => $y_axis
                            );
                            $this->image_lib->initialize($configCrop);
                            $this->image_lib->crop();
                            $this->image_lib->clear();
                        }
                        #BEGIN: Resize image
                        $img_config = array(
                            'source_image' => $pathUpload . $dirUpload . '/' . $file_name,
                            'new_image' => $pathUpload . $dirUpload . '/' . $file_name,
                            'maintain_ratio' => true,
                            'quality' => '90%',
                            'width' => '600',
                            'height' => '600'
                        );
                        $this->image_lib->initialize($img_config);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                    }
                    // upload this image to other server 
                    
                    if (file_exists($pathUpload . $dirUpload . '/' . $file_name)) {
                        $source_path = $pathUpload . $dirUpload . '/' . $file_name;
                        $target_path = $pathTarget . $dirUpload . '/' . $file_name;
                        $this->ftp->upload($source_path, $target_path, 'auto', 0775);  
                        if($this->input->post('product_image_2_old')[$i] != '') {
                            $this->ftp->delete_file($pathTarget . $dirUpload .'/'.  $this->input->post('product_image_2_old')[$i]); 
                        }                                               
                    }                                               
                } else {
                    $file_name = $this->input->post('product_image_2_old')[$i];
                }  
                $product_list_2[$i]->image = $file_name;
                $product_list_2[$i]->title = $this->input->post('product_title_2')[$i];
                $product_list_2[$i]->url = $this->input->post('product_url_2')[$i];  
                $product_list_2[$i]->cat = $this->input->post('product_cat_2');  
            }
            // END: product_list_2
            
            // BEGIN: product_list_3 
            $product_list_3 = array();                
            foreach ($_FILES['product_image_3']['name'] as $i => $val) {
                $_FILES['img[]']['name']=  $_FILES['product_image_3']['name'][$i];
                $_FILES['img[]']['type']= $_FILES['product_image_3']['type'][$i];
                $_FILES['img[]']['tmp_name']= $_FILES['product_image_3']['tmp_name'][$i];
                $_FILES['img[]']['error']= $_FILES['product_image_3']['error'][$i];
                $_FILES['img[]']['size']= $_FILES['product_image_3']['size'][$i];
                if ($this->upload->do_upload('img[]')) {
                    $uploadData = $this->upload->data();
                    if ($uploadData['is_image'] == TRUE) {
                        $file_name = $uploadData['file_name'];
                        // Crop image 1x1
                        $configCrop['source_image'] = $pathUpload . $dirUpload . '/' . $file_name;
                        $configCrop['new_image'] = $pathUpload . $dirUpload . '/' . $file_name;
                        $configCrop['maintain_ratio'] = FALSE;
                        $w = $uploadData['image_width'];
                        $h = $uploadData['image_height'];
                        if ($w != $h) {
                            if ($w > $h) {
                                $width = $h;
                                $height = $h;
                                $y_axis = 0;
                                $x_axis = ($w - $width) / 2;
                            }
                            if ($w < $h) {
                                $width = $w;
                                $height = $w;
                                $y_axis = ($h - $height) / 2;
                                $x_axis = 0;
                            }
                            $configCrop = array(
                                'source_image' => $pathUpload . $dirUpload . '/' . $file_name,
                                'new_image' => $pathUpload . $dirUpload . '/' . $file_name,
                                'maintain_ratio' => FALSE,
                                'width' => $width, 'height' => $height,
                                'x_axis' => $x_axis, 'y_axis' => $y_axis
                            );
                            $this->image_lib->initialize($configCrop);
                            $this->image_lib->crop();
                            $this->image_lib->clear();
                        }
                        #BEGIN: Resize image
                        $img_config = array(
                            'source_image' => $pathUpload . $dirUpload . '/' . $file_name,
                            'new_image' => $pathUpload . $dirUpload . '/' . $file_name,
                            'maintain_ratio' => true,
                            'quality' => '90%',
                            'width' => '600',
                            'height' => '600'
                        );
                        $this->image_lib->initialize($img_config);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                    }
                    // upload this image to other server 
                    
                    if (file_exists($pathUpload . $dirUpload . '/' . $file_name)) {
                        $source_path = $pathUpload . $dirUpload . '/' . $file_name;
                        $target_path = $pathTarget . $dirUpload . '/' . $file_name;
                        $this->ftp->upload($source_path, $target_path, 'auto', 0775);  
                        if($this->input->post('product_image_3_old')[$i] != '') {
                            $this->ftp->delete_file($pathTarget . $dirUpload .'/'.  $this->input->post('product_image_3_old')[$i]); 
                        }                                               
                    }                                               
                } else {
                    $file_name = $this->input->post('product_image_3_old')[$i];
                }  
                $product_list_3[$i]->image = $file_name;
                $product_list_3[$i]->title = $this->input->post('product_title_3')[$i];
                $product_list_3[$i]->url = $this->input->post('product_url_3')[$i];  
                $product_list_3[$i]->cat = $this->input->post('product_cat_3');  
            }
            // END: product_list_3

            // BEGIN: Customer 
            $customers = array();                
            foreach ($_FILES['customer_image']['name'] as $i => $val) {
                $_FILES['img[]']['name']=  $_FILES['customer_image']['name'][$i];
                $_FILES['img[]']['type']= $_FILES['customer_image']['type'][$i];
                $_FILES['img[]']['tmp_name']= $_FILES['customer_image']['tmp_name'][$i];
                $_FILES['img[]']['error']= $_FILES['customer_image']['error'][$i];
                $_FILES['img[]']['size']= $_FILES['customer_image']['size'][$i];
                if ($this->upload->do_upload('img[]')) {
                    $uploadData = $this->upload->data();
                    if ($uploadData['is_image'] == TRUE) {
                        $file_name = $uploadData['file_name'];
                        // Crop image 1x1
                        $configCrop['source_image'] = $pathUpload . $dirUpload . '/' . $file_name;
                        $configCrop['new_image'] = $pathUpload . $dirUpload . '/' . $file_name;
                        $configCrop['maintain_ratio'] = FALSE;
                        $w = $uploadData['image_width'];
                        $h = $uploadData['image_height'];
                        if ($w != $h) {
                            if ($w > $h) {
                                $width = $h;
                                $height = $h;
                                $y_axis = 0;
                                $x_axis = ($w - $width) / 2;
                            }
                            if ($w < $h) {
                                $width = $w;
                                $height = $w;
                                $y_axis = ($h - $height) / 2;
                                $x_axis = 0;
                            }
                            $configCrop = array(
                                'source_image' => $pathUpload . $dirUpload . '/' . $file_name,
                                'new_image' => $pathUpload . $dirUpload . '/' . $file_name,
                                'maintain_ratio' => FALSE,
                                'width' => $width, 'height' => $height,
                                'x_axis' => $x_axis, 'y_axis' => $y_axis
                            );
                            $this->image_lib->initialize($configCrop);
                            $this->image_lib->crop();
                            $this->image_lib->clear();
                        }
                        #BEGIN: Resize image
                        $img_config = array(
                            'source_image' => $pathUpload . $dirUpload . '/' . $file_name,
                            'new_image' => $pathUpload . $dirUpload . '/' . $file_name,
                            'maintain_ratio' => true,
                            'quality' => '90%',
                            'width' => '200',
                            'height' => '200'
                        );
                        $this->image_lib->initialize($img_config);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                    }
                    // upload this image to other server 
                    
                    if (file_exists($pathUpload . $dirUpload . '/' . $file_name)) {
                        $source_path = $pathUpload . $dirUpload . '/' . $file_name;
                        $target_path = $pathTarget . $dirUpload . '/' . $file_name;
                        $this->ftp->upload($source_path, $target_path, 'auto', 0775);  
                        if($this->input->post('customer_image_old')[$i] != '') {
                            $this->ftp->delete_file($pathTarget . $dirUpload .'/'.  $this->input->post('customer_image_old')[$i]); 
                        }                                               
                    }                                               
                } else {
                    $file_name = $this->input->post('customer_image_old')[$i];
                }  
                $customers[$i]->image = $file_name;
                $customers[$i]->name = $this->input->post('customer_name')[$i];
                $customers[$i]->say = $this->input->post('customer_say')[$i];
                $customers[$i]->url = $this->input->post('customer_url')[$i];                
            }
            // END: Customer

            if ($this->upload->do_upload('customer_bg_new')) {
                $uploadData = $this->upload->data();
                if ($uploadData['is_image'] == TRUE) {
                    if ($resume_edit->customer_bg && is_array(getimagesize(DOMAIN_CLOUDSERVER . 'media/images/profiles/' . $dirUpload . '/' . $resume_edit->customer_bg))) {
                        $this->ftp->delete_file($pathTarget . $userid . '/' . $resume_edit->customer_bg);
                    }
                    $customer_bg = $uploadData['file_name'];
                }
                $source_path = $pathUpload . $dirUpload . '/' . $customer_bg;
                $target_path = $pathTarget . $dirUpload . '/' . $customer_bg;
                $this->ftp->upload($source_path, $target_path, 'auto', 0775);
            } else {
                $customer_bg = $this->input->post('customer_bg');
            }

            // BEGIN: Certification 
            $certification = array();               
            foreach ($_FILES['certification_image']['name'] as $i => $val) {
                $_FILES['img[]']['name']=  $_FILES['certification_image']['name'][$i];
                $_FILES['img[]']['type']= $_FILES['certification_image']['type'][$i];
                $_FILES['img[]']['tmp_name']= $_FILES['certification_image']['tmp_name'][$i];
                $_FILES['img[]']['error']= $_FILES['certification_image']['error'][$i];
                $_FILES['img[]']['size']= $_FILES['certification_image']['size'][$i];
                if ($this->upload->do_upload('img[]')) {
                    $uploadData = $this->upload->data();
                    if ($uploadData['is_image'] == TRUE) {
                        $file_name = $uploadData['file_name'];                        
                        //Resize image auto x 600px
                        $img_config = array(
                            'source_image' => $pathUpload . $dirUpload . '/' . $file_name,
                            'new_image' => $pathUpload . $dirUpload . '/' . $file_name,
                            'maintain_ratio' => true,
                            'quality' => '90%',
                            'width' => '1',
                            'height' => '600',
                            'master_dim' => 'height'
                        );
                        $this->image_lib->initialize($img_config);
                        $this->image_lib->resize();
                        $this->image_lib->clear();						
                    }
                    // upload this image to other server                     
                    if (file_exists($pathUpload . $dirUpload . '/' . $file_name)) {
                        $source_path = $pathUpload . $dirUpload . '/' . $file_name;
                        $target_path = $pathTarget . $dirUpload . '/' . $file_name;
                        $this->ftp->upload($source_path, $target_path, 'auto', 0775);						
                        if($this->input->post('certification_image_old')[$i] != '') {
                            $this->ftp->delete_file($pathTarget . $dirUpload .'/'.  $this->input->post('certification_image_old')[$i]); 
                        }                                               
                    }                                               
                } else {
                    $file_name = $this->input->post('certification_image_old')[$i];
                }  
                $certification[$i]->image = $file_name;                               
            }
            // END: Certification
            
            // BEGIN: History             
            $historys = array();                
            foreach ($_FILES['history_image']['name'] as $i => $val) {
                $_FILES['img[]']['name']=  $_FILES['history_image']['name'][$i];
                $_FILES['img[]']['type']= $_FILES['history_image']['type'][$i];
                $_FILES['img[]']['tmp_name']= $_FILES['history_image']['tmp_name'][$i];
                $_FILES['img[]']['error']= $_FILES['history_image']['error'][$i];
                $_FILES['img[]']['size']= $_FILES['history_image']['size'][$i];
                if ($this->upload->do_upload('img[]')) {
                    $uploadData = $this->upload->data();
                    if ($uploadData['is_image'] == TRUE) {
                        $file_name = $uploadData['file_name'];
                        // Crop image 16 x 9
                        $configCrop['source_image'] = $pathUpload . $dirUpload . '/' . $file_name;
                        $configCrop['new_image'] = $pathUpload . $dirUpload . '/' . $file_name;
                        $configCrop['maintain_ratio'] = FALSE;
                        $w = $uploadData['image_width'];
                        $h = $uploadData['image_height'];                        
                        if( $w > $h && $h <= $w / 16 * 9 ){
                            $configCrop['width'] = $h / 9 * 16;
                            $configCrop['height'] = $h;
                            $configCrop['x_axis'] = ($w - $configCrop['width']) / 2;
                            $configCrop['y_axis'] = 0;
                        }
                        if (($w <= $h ) || ( $w > $h && $h > $w / 16 * 9 )) {
                            $configCrop['width'] = $w;
                            $configCrop['height'] = $w / 16 * 9;
                            $configCrop['y_axis'] = ($h - $configCrop['height']) / 2;
                            $configCrop['x_axis'] = 0;
                        }
                        $this->image_lib->initialize($configCrop);
                        $this->image_lib->crop();
                        $this->image_lib->clear();                        
                        
                        // Resize image 640 x 360
                        $img_config = array(
                            'source_image' => $pathUpload . $dirUpload . '/' . $file_name,
                            'new_image' => $pathUpload . $dirUpload . '/' . $file_name,
                            'maintain_ratio' => true,
                            'quality' => '90%',
                            'width' => '640',
                            'height' => '1',
                            'master_dim' => 'width'
                        );
                        $this->image_lib->initialize($img_config);
                        $this->image_lib->resize();
                        $this->image_lib->clear();
                    }
                    // upload this image to other server                     
                    if (file_exists($pathUpload . $dirUpload . '/' . $file_name)) {
                        $source_path = $pathUpload . $dirUpload . '/' . $file_name;
                        $target_path = $pathTarget . $dirUpload . '/' . $file_name;
                        $this->ftp->upload($source_path, $target_path, 'auto', 0775);  
                        if($this->input->post('history_image_old')[$i] != '') {
                            $this->ftp->delete_file($pathTarget . $dirUpload .'/'.  $this->input->post('history_image_old')[$i]); 
                        }                                               
                    }                                               
                } else {
                    $file_name = $this->input->post('history_image_old')[$i];
                }  
                $historys[$i]->image = $file_name;
                $historys[$i]->title = $this->input->post('history_title')[$i];
                $historys[$i]->date = $this->input->post('history_date')[$i];
                $historys[$i]->youtube = $this->input->post('history_youtube')[$i]; 
                $historys[$i]->text = $this->input->post('history_text')[$i];
                $historys[$i]->url = $this->input->post('history_url')[$i];
            }
            // END: History            

            if (file_exists('media/images/profiles/' . $dirUpload . '/index.html')) {
                @unlink('media/images/profiles/' . $dirUpload . '/index.html');
            }
            array_map('unlink', glob('media/images/profiles/' . $dirUpload . '/*'));
            @rmdir('media/images/profiles/' . $dirUpload);

            $this->ftp->close();
            
            $dataEdit = array(
                'userid' => (int)$userid,
                'logo' => $logo,
                'banner' => $banner,
                'fullname' => $this->input->post('fullname'),
                'career' => $this->input->post('career'),
                'sex' => $this->input->post('sex'),
                'birthday' => $this->input->post('birthday'),
                'religion' => $this->input->post('religion'),
                'department' => $this->input->post('department'),
                'mobile' => $this->input->post('mobile'),
                'email' => $this->input->post('email'),
                'education' => $this->input->post('education'),
                'favorites' => $this->input->post('favorites'),
                'marriage' => $this->input->post('marriage'),
                'accommodation' => $this->input->post('accommodation'),
                'sayings' => $this->input->post('sayings'),
                'company_name' => $this->input->post('company_name'),
                'company_image' => $company_image,
                'company_intro' => str_replace("\r\n", '', $this->input->post('company_intro')),
                'show_company' => (int)$this->input->post('show_company'),
                'slogan' => $this->input->post('slogan'),
                'slogan_by' => $this->input->post('slogan_by'),
                'slogan_bg' => $slogan_bg,
                'show_slogan' => (int)$this->input->post('show_slogan'),
                
                'title_service' => $this->input->post('title_service'),
                'service_desc' => str_replace("\r\n", '', $this->input->post('service_desc')),
                'list_service' => json_encode($services),    
                'show_service' => (int)$this->input->post('show_service'),
                
                'statistic' => json_encode($statistic),
                'statistic_bg' => $statistic_bg,
                'show_statistic' => (int)$this->input->post('show_statistic'),
                
                'title_product' => $this->input->post('title_product'),
                'product_desc' => str_replace("\r\n", '', $this->input->post('product_desc')),
                'product_cat' => $product_cat,
                'product_list_0' => json_encode($product_list_0),
                'product_list_1' => json_encode($product_list_1),
                'product_list_2' => json_encode($product_list_2),
                'product_list_3' => json_encode($product_list_3),
                'show_product' => (int)$this->input->post('show_product'),
                
                'title_customer' => $this->input->post('title_customer'),
                'list_customer' => json_encode($customers),
                'show_customer' => (int)$this->input->post('show_customer'),
                'customer_bg' => $customer_bg,
                
                'title_certification' => $this->input->post('title_certification'),
                'certification' => json_encode($certification),
                'show_certification' => (int)$this->input->post('show_certification'),
                
                'title_history' => $this->input->post('title_history'),
                'list_history' => json_encode($historys),
                'show_history' => (int)$this->input->post('show_history'),
                
                'facebook' => $this->input->post('facebook'),
                'twitter' => $this->input->post('twitter'),
                'google' => $this->input->post('google'),
                'show_contactUs' => (int)$this->input->post('show_contact'),
                'style' => (int)$this->input->post('style'),
                'color' => $this->input->post('color')
            );
            
            $this->db->where("userid = " . $userid);
            $this->db->update("tbtt_resume", $dataEdit);
            $this->db->trans_complete();
            
            if ($this->db->trans_status() === FALSE) {
               $data['updateProfile'] = 0;
            } else {                    
               $data['updateProfile'] = 1; 
            }            
        }

        $query = $this->db->query('SELECT * FROM tbtt_resume WHERE userid = '. $userid);
        $resume_edit = $query->row();        
        $data['resume'] = $resume_edit;	
        $this->load->view('home/account/defaults/updateprofile', $data);
    }

    public function viewresume($userid)
    { 
        $query = $this->db->query('SELECT a.*,b.use_message,b.avatar,b.use_address,b.use_province,b.user_district FROM tbtt_resume AS a LEFT JOIN tbtt_user AS b ON a.userid = b.use_id WHERE a.userid = '. $userid);
        $resume = $query->row();        
        if($resume){
            $data['resume'] = $resume;  
        } else {
            redirect(base_url(), 'location');
            die();
        }
        $this->load->library('GMap');
        $this->gmap->GoogleMapAPI();
        $this->gmap->setMapType('map');
        $this->gmap->setWidth('100%');
        $this->gmap->setHeight('450px');
       
        $province = $this->province_model->get('pre_id, pre_name', 'pre_status = 1 and pre_id = ' . $resume->use_province, 'pre_order', 'ASC');
        $district = $this->district_model->get("DistrictCode, DistrictName", "pre_status = 1 and ProvinceCode = " . (int)$resume->use_province . " AND DistrictCode='" . $resume->user_district . "'");
        $address = $resume->use_address . ', ' . $district->DistrictName . ', ' . $province->pre_name; 
        $data['address'] = $address;
        $this->gmap->addMarkerByAddress($address, $resume->company_name, '<div style="color: #1155CC; font-size:120%; font-weight: bold;">' . $resume->fullname.' | '.$resume->company_name . '</div><div style="color: #f01929;">' . $address . '</div><div style="text-align:left; font-weight:bold;color: #f01929;">Điện Thoại:' . $resume->mobile . ' - Email:' . $resume->email .'</div>');

        $data['headerjs'] = $this->gmap->getHeaderJS();
        $data['headermap'] = $this->gmap->getMapJS();
        $data['onload'] = $this->gmap->printOnLoad();
        $data['map'] = $this->gmap->printMap();
        
        if ($this->session->flashdata('sessionSuccessContact')) {
            $data['successContact'] = true;
        } else {
            $this->load->library('form_validation');
            $data['successContact'] = false;
            if ($this->input->post('submitconntact') == 'submitconntact' && time() - (int) $this->session->userdata('sessionTimePosted') > (int) settingTimePost) {
                #BEGIN: Set rules
                $this->form_validation->set_rules('name_contact', 'lang:name_contact_label_defaults', 'trim|required');
                $this->form_validation->set_rules('email_contact', 'lang:email_contact_label_defaults', 'trim|required|valid_email');
                $this->form_validation->set_rules('subject_contact', 'lang:title_contact_label_defaults', 'trim|required');
                $this->form_validation->set_rules('content_contact', 'lang:content_contact_label_defaults', 'trim|required|min_length[10]|max_length[1000]');
                #END Set rules
                #BEGIN: Set message
                $this->form_validation->set_message('required', $this->lang->line('required_message'));
                $this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
                $this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
                $this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
                $this->form_validation->set_message('_valid_captcha', $this->lang->line('_valid_captcha_message_defaults'));
                $this->form_validation->set_error_delimiters('<div class="text-danger"><em>', '</em></div>');
                #END Set message
                if ($this->form_validation->run() != FALSE) {
                    //print_r($user);
                    $email = $resume->email;
                    
                    $this->load->library('email');
                    $config['useragent'] = $this->lang->line('useragen_defaults');
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);
                    $messageContact = 'Liên hệ từ '.site_url('resume/'.$resume->userid.'/'. RemoveSign($resume->fullname)) . '/#contact<br/><br/>' 
                            . $this->lang->line('fullname_contact_mail_defaults') . $this->input->post('name_contact') . '<br/><br/>' 
                            . $this->lang->line('email_contact_mail_defaults') . $this->input->post('email_contact') . '<br/><br/>'                            
                            . $this->lang->line('date_contact_mail_defaults') . date('h\h:i, d-m-Y') . '<br/><br/>' 
                            . $this->lang->line('subject_contact_mail_defaults') . $this->input->post('subject_contact') . '<br/><br/>'                             
                            . $this->lang->line('content_contact_mail_defaults') . '<br/><br/>'. nl2br($this->filter->html($this->input->post('content_contact')));
                    
                    $this->email->from($this->input->post('email_contact'));
                    
                    #Email
                    $folder = folderWeb;
                    require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
                    require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');

                    $return_email = $this->smtpmailer($email, $this->input->post('email_contact'), "azibai.com", $this->input->post('subject_contact'), $messageContact);

                    if ($return_email) {
                        $this->session->set_flashdata('sessionSuccessContact', 1);
                    }
                    $this->session->set_userdata('sessionTimePosted', time());
                    redirect(base_url() . trim(uri_string(), '/'), 'location');
                } else {
                    $data['name_contact'] = $this->input->post('name_contact');
                    $data['email_contact'] = $this->input->post('email_contact');       
                    $data['title_contact'] = $this->input->post('subject_contact');
                    $data['content_contact'] = $this->input->post('content_contact');
                }
            }            
        }
        # LOAD VIEWS
        switch ($resume->style){
    	    case 1 : 
    		    $this->load->view('home/user/profile/style1', $data);
    		    break;
    	    case 2 : 
    		    $this->load->view('home/user/profile/style2', $data);
    		    break;
    	    case 3 : 
    		    $this->load->view('home/user/profile/style3', $data);
    		    break;
    	    default : 
    		    $this->load->view('home/user/profile/default', $data);
    		    break;
    	}
    }

    public function viewprofile($userid)
    { 
        $query = $this->db->query('SELECT a.*, b.use_message, b.avatar, b.use_address, b.use_province, b.user_district FROM tbtt_resume AS a LEFT JOIN tbtt_user AS b ON a.userid = b.use_id WHERE a.userid = '. $userid);
        $resume = $query->row();        
        if($resume){
            $data['resume'] = $resume;  
        } else {
            redirect(base_url(), 'location');
            die();
        }
        $this->load->library('GMap');
        $this->gmap->GoogleMapAPI();
        $this->gmap->setMapType('map');
        $this->gmap->setWidth('100%');
        $this->gmap->setHeight('450px');
       
        $province = $this->province_model->get('pre_id, pre_name', 'pre_status = 1 AND pre_id = ' . $resume->use_province, 'pre_order', 'ASC');
        $district = $this->district_model->get("DistrictCode, DistrictName", "pre_status = 1 AND ProvinceCode = " . (int)$resume->use_province . " AND DistrictCode='" . $resume->user_district . "'");
        $address = $resume->use_address . ', ' . $district->DistrictName . ', ' . $province->pre_name; 
        $data['address'] = $address;
        $this->gmap->addMarkerByAddress($address, $resume->company_name, '<div style="color: #1155CC; font-size:120%; font-weight: bold;">' . $resume->fullname.' | '.$resume->company_name . '</div><div style="color: #f01929;">' . $address . '</div><div style="text-align:left; font-weight:bold;color: #f01929;">Điện Thoại:' . $resume->mobile . ' - Email:' . $resume->email .'</div>');

        $data['headerjs'] = $this->gmap->getHeaderJS();
        $data['headermap'] = $this->gmap->getMapJS();
        $data['onload'] = $this->gmap->printOnLoad();
        $data['map'] = $this->gmap->printMap();
        
        if ($this->session->flashdata('sessionSuccessContact')) {
            $data['successContact'] = true;
        } else {
            $this->load->library('form_validation');
            $data['successContact'] = false;
            if ($this->input->post('submitconntact') == 'submitconntact' && time() - (int) $this->session->userdata('sessionTimePosted') > (int) settingTimePost) {
                #BEGIN: Set rules
                $this->form_validation->set_rules('name_contact', 'lang:name_contact_label_defaults', 'trim|required');
                $this->form_validation->set_rules('email_contact', 'lang:email_contact_label_defaults', 'trim|required|valid_email');
                $this->form_validation->set_rules('subject_contact', 'lang:title_contact_label_defaults', 'trim|required');
                $this->form_validation->set_rules('content_contact', 'lang:content_contact_label_defaults', 'trim|required|min_length[10]|max_length[1000]');
                #END Set rules
                #BEGIN: Set message
                $this->form_validation->set_message('required', $this->lang->line('required_message'));
                $this->form_validation->set_message('min_length', $this->lang->line('min_length_message'));
                $this->form_validation->set_message('max_length', $this->lang->line('max_length_message'));
                $this->form_validation->set_message('valid_email', $this->lang->line('valid_email_message'));
                $this->form_validation->set_message('_valid_captcha', $this->lang->line('_valid_captcha_message_defaults'));
                $this->form_validation->set_error_delimiters('<div class="text-danger"><em>', '</em></div>');
                #END Set message
                if ($this->form_validation->run() != FALSE) {
                    //print_r($user);
                    $email = $resume->email;
                    
                    $this->load->library('email');
                    $config['useragent'] = $this->lang->line('useragen_defaults');
                    $config['mailtype'] = 'html';
                    $this->email->initialize($config);
                    $messageContact = 'Liên hệ từ '.site_url('profile/'.$resume->userid.'/'. RemoveSign($resume->fullname)) . '/#contact<br/><br/>' 
                            . $this->lang->line('fullname_contact_mail_defaults') . $this->input->post('name_contact') . '<br/><br/>' 
                            . $this->lang->line('email_contact_mail_defaults') . $this->input->post('email_contact') . '<br/><br/>'                            
                            . $this->lang->line('date_contact_mail_defaults') . date('h\h:i, d-m-Y') . '<br/><br/>' 
                            . $this->lang->line('subject_contact_mail_defaults') . $this->input->post('subject_contact') . '<br/><br/>'                             
                            . $this->lang->line('content_contact_mail_defaults') . '<br/><br/>'. nl2br($this->filter->html($this->input->post('content_contact')));
                    
                    $this->email->from($this->input->post('email_contact'));
                    
                    #Email
                    $folder = folderWeb;
                    require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.phpmailer.php');
                    require_once($_SERVER['DOCUMENT_ROOT'] . $folder . '/PHPMailer/class.pop3.php');

                    $return_email = $this->smtpmailer($email, $this->input->post('email_contact'), "azibai.com", $this->input->post('subject_contact'), $messageContact);

                    if ($return_email) {
                        $this->session->set_flashdata('sessionSuccessContact', 1);
                    }
                    $this->session->set_userdata('sessionTimePosted', time());
                    redirect(base_url() . trim(uri_string(), '/'), 'location');
                } else {
                    $data['name_contact'] = $this->input->post('name_contact');
                    $data['email_contact'] = $this->input->post('email_contact');       
                    $data['title_contact'] = $this->input->post('subject_contact');
                    $data['content_contact'] = $this->input->post('content_contact');
                }
            }            
        }        
        # LOAD VIEWS
    	switch ($resume->style){
    	    case 1 : 
    		$this->load->view('home/user/profile/style1', $data);
    		break;
    	    case 2 : 
    		$this->load->view('home/user/profile/style2', $data);
    		break;
    	    case 3 : 
    		$this->load->view('home/user/profile/style3', $data);
    		break;
    	    default : 
    		$this->load->view('home/user/profile/default', $data);
    		break;
    	}        
    }
    
    public function smtpmailer($to, $from, $from_name, $subject, $body)
	{
		$mail = new PHPMailer();  				// tạo một đối tượng mới từ class PHPMailer
		$mail->IsSMTP(); 	
		$mail->CharSet="utf-8";					// bật chức năng SMTP
		$mail->SMTPDebug = 0;  					// kiểm tra lỗi : 1 là  hiển thị lỗi và thông báo cho ta biết, 2 = chỉ thông báo lỗi
		$mail->SMTPAuth = true;  				// bật chức năng đăng nhập vào SMTP này
		$mail->SMTPSecure = SMTPSERCURITY; 				// sử dụng giao thức SSL vì gmail bắt buộc dùng cái này
		$mail->Host = SMTPHOST; 		// smtp của gmail
		$mail->Port = SMTPPORT; 						// port của smpt gmail
		$mail->Username = GUSER;  
		$mail->Password = GPWD;           
		$mail->SetFrom($from, $from_name);
		$mail->Subject = $subject;
		$mail->Body = $body;
		$mail->isHTML(true);
		$mail->AddAddress($to);
		
		if(!$mail->Send())
		{
			$message = 'Gởi mail bị lỗi: '.$mail->ErrorInfo; 
			return false;
		} else {
			$message = 'Thư của bạn đã được gởi đi ';
			return true;
		}	
	}        
   
    public function deleteimage()
    {
        $image = $this->input->post('image');        
        $field = $this->input->post('field');
        if($image != ''){
            $this->load->library('ftp');
            $configftp['hostname'] = IP_CLOUDSERVER;
            $configftp['username'] = USER_CLOUDSERVER;
            $configftp['password'] = PASS_CLOUDSERVER;
            $configftp['port'] = PORT_CLOUDSERVER;
            $configftp['debug'] = TRUE;
            $this->ftp->connect($configftp);
            
            $userid = (int)$this->session->userdata('sessionUser');
            $pathTarget = '/public_html/media/images/profiles/';
            $fileurl = DOMAIN_CLOUDSERVER . 'media/images/profiles/'. $userid .'/'. $image;
            
            if (is_array(getimagesize($fileurl))) {
                $this->db->where("userid = ".$userid);
                $this->db->update("tbtt_resume", array($field => ''));            
                $this->ftp->delete_file($pathTarget . $userid . '/' . $image); 
                echo '.'.$field; exit();
            }            
            $this->ftp->close();
        }
        echo '0';
        exit();
    }

    public function delete_box()
    {
        $image = $this->input->post('image');        
        if($image != ''){            
            $this->load->library('ftp');
            $configftp['hostname'] = IP_CLOUDSERVER;
            $configftp['username'] = USER_CLOUDSERVER;
            $configftp['password'] = PASS_CLOUDSERVER;
            $configftp['port'] = PORT_CLOUDSERVER;
            $configftp['debug'] = TRUE;
            $this->ftp->connect($configftp);            
            $userid = $this->session->userdata('sessionUser');
            $pathTarget = '/public_html/media/images/profiles/';
            $fileurl = DOMAIN_CLOUDSERVER . 'media/images/profiles/'. $userid .'/'. $image;                 
            $this->ftp->delete_file($pathTarget . $userid . '/' . $image); 
            $this->ftp->close();
            echo '1'; exit();        
        } else {
            echo '0'; exit();    
        } 
    }

    
    
    public function delete_product ()
    {
	    $key = $this->input->post('key');
	    $image = $this->input->post('image'); 
    	if($image != ''){
    	    $this->load->library('ftp');
    	    $configftp['hostname'] = IP_CLOUDSERVER;
    	    $configftp['username'] = USER_CLOUDSERVER;
    	    $configftp['password'] = PASS_CLOUDSERVER;
    	    $configftp['port'] = PORT_CLOUDSERVER;
    	    $configftp['debug'] = TRUE;
    	    $this->ftp->connect($configftp);
    	    $userid = (int)$this->session->userdata('sessionUser');
    	    $pathTarget = '/public_html/media/images/profiles/';
    	    $fileurl = DOMAIN_CLOUDSERVER .'media/images/profiles/'. $userid .'/'. $image;  
    	    if (is_array(getimagesize($fileurl))) {          
                $this->ftp->delete_file($pathTarget . $userid .'/'. $image); 
                echo '.productimage_'. $key; exit();
            } 
    	    $this->ftp->close();
    	}

    	echo '0'; exit();
    }    
    
    public function delete_certification ()
    {
        $image = $this->input->post('image'); 
        $key = $this->input->post('key'); 
        if($image != ''){
            $this->load->library('ftp');
            $configftp['hostname'] = IP_CLOUDSERVER;
            $configftp['username'] = USER_CLOUDSERVER;
            $configftp['password'] = PASS_CLOUDSERVER;
            $configftp['port'] = PORT_CLOUDSERVER;
            $configftp['debug'] = TRUE;
            $this->ftp->connect($configftp);
            
            $userid = (int)$this->session->userdata('sessionUser');
            $pathTarget = '/public_html/media/images/profiles/';
            $fileurl = DOMAIN_CLOUDSERVER . 'media/images/profiles/'. $userid .'/'. $image;            
            
            $query = $this->db->query('SELECT certification FROM tbtt_resume WHERE userid = '. $userid);
            $res = $query->row(); 
            $certification = json_decode($res->certification);             
            unset($certification[$key]);            
            $certification2 = json_encode($certification, true);            
            $this->db->where("userid = ".$userid);            
            $this->db->update("tbtt_resume", array('certification' => $certification2) );            
            if (is_array(getimagesize($fileurl))) {
                $this->ftp->delete_file($pathTarget . $userid . '/' . $image);
            }
            
            echo '.'.$key; exit();
            $this->ftp->close();
        }
        echo '0';
        exit();
    }

    public function check_permis_subadmin($user = 0, $menu = 0)
    {
        $p = false;
        if ($user > 0 && $menu > 0) {
            $this->load->model('permission_menu_model');
            $per = $this->permission_menu_model->get('*', 'pm_userid = '. $user);            
            if ($per && count($per) == 1) {
                if (in_array($menu, explode(',', $per->pm_listmenu))) {
                   $p = true; 
               }                
            }
        }

        return $p;
    }

    public function delete()
    {
        if (! $this->session->userdata('sessionUser')) {
            redirect(base_url() .'login', 'location'); die;
        }

        $data['menuSelected'] = 'edit';
        $data['menuType'] = 'account';
        $info = $this->user_model->get('use_mobile', 'use_id = '. (int)$this->session->userdata('sessionUser'));
        
        if ($this->input->post('dongy') == '1') {
            if($this->user_model->update(array('use_status' => '-1', 'use_mobile' => '000'. $info->use_mobile), 'use_id = '. (int)$this->session->userdata('sessionUser'))){
                redirect(base_url() .'logout', 'location'); die;
            }
        }
        #load view
        $this->load->view('home/user/unactive',$data);
    }
}
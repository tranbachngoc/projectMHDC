<?php
global $idHome;
$group_id = (int)$this->session->userdata('sessionGroup');
?>
<?php if ($isMobile == 1) { ?>
    <style>
        #list_module > ul > li > a { font-size: 17px; }
        a.left_menu { font-size: 16px; }
    </style>
<?php } ?>

<?php switch ($menuType) {
    case 'product': ?>
        <tr>
            <td><?php
                if ($idHome == 1) {
                    echo $menu;
                }
                ?>
            </td>
        </tr>
        <?php break; ?>

    <?php case 'raovat': ?>
        <tr>
            <td><?php
                if ($idHome == 1) {
                    echo $menu;
                }
                ?></td>
        </tr>
        <?php break; ?>

    <?php case 'hoidap': ?>
        <tr>
            <td><?php
                if ($idHome == 1) {
                    echo $menu;
                }
                ?></td>
        </tr>
        <?php break; ?>

    <?php case 'timviec': ?>
        <tr>
            <td><?php
                if ($idHome == "1") {
                    echo $menu;
                }
                ?></td>
        </tr>
        <?php break; ?>

    <?php case 'shop': ?>
        <tr>
            <td><?php if ($idHome == 1) { ?>
                    <?php echo $menu; ?>
                <?php } ?></td>
        </tr>
        <?php break; ?>

    <?php case 'job': ?>
        <tr>
            <td>
                <div class="temp_2" style="width:180px;">
                    <div class="title">
                        <div class="fl"></div>
                        <div class="fc">
                            <h3>THÔNG TIN CHUNG</h3>
                        </div>
                        <div class="fr"></div>
                    </div>
                    <div class="content">
                        <table border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="30" height="30">
                                    <div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_01.gif"
                                              border="0" alt=""/></div>
                                </td>
                                <td width="171" height="30">
                                    <div class="le_menu">
                                        <a href="<?php echo base_url(); ?>tuyendung"
                                           class="<?php if ($menuSelected == 'job') {
                                               echo 'menu_selected';
                                           } else {
                                               echo 'menu';
                                           } ?>"><?php echo $this->lang->line('job_job_menu'); ?></a>
                                    </div>
                                </td>
                            </tr>
                            <?php if ($menuFieldJob == true) { ?>
                                <tr>
                                    <td width="30" height="30">
                                        <div><img
                                                src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_02.gif"
                                                border="0" alt=""/></div>
                                    </td>
                                    <td width="171" height="30">
                                        <div class="le_menu">
                                            <a href="#Field" onclick="OpenTabField()"
                                               class="menu"><?php echo $this->lang->line('field_job_job_menu'); ?></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td width="30" height="30">
                                    <div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_03.gif"
                                              border="0" alt=""/></div>
                                </td>
                                <td width="171" height="30">
                                    <div class="le_menu">
                                        <a href="<?php echo base_url(); ?>job/post"
                                           class="<?php if ($menuSelected == 'post_job') {
                                               echo 'menu_selected';
                                           } else {
                                               echo 'menu';
                                           } ?>"><?php echo $this->lang->line('post_job_job_menu'); ?></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td width="30" height="30">
                                    <div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_04.gif"
                                              border="0" alt=""/></div>
                                </td>
                                <td width="171" height="30">
                                    <div class="le_menu">
                                        <a href="<?php echo base_url(); ?>timviec"
                                           class="<?php if ($menuSelected == 'employ') {
                                               echo 'menu_selected';
                                           } else {
                                               echo 'menu';
                                           } ?>"><?php echo $this->lang->line('employ_job_menu'); ?></a>
                                    </div>
                                </td>
                            </tr>
                            <?php if ($menuFieldEmploy == true) { ?>
                                <tr>
                                    <td width="30" height="30">
                                        <div><img
                                                src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_05.gif"
                                                border="0" alt=""/></div>
                                    </td>
                                    <td width="171" height="30">
                                        <div class="le_menu">
                                            <a href="#Field" onclick="OpenTabField()"
                                               class="menu"><?php echo $this->lang->line('field_employ_job_menu'); ?></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td width="30" height="30">
                                    <div><img src="<?php echo base_url(); ?>templates/home/images/icon_menu_job_06.gif"
                                              border="0" alt=""/></div>
                                </td>
                                <td width="171" height="30">
                                    <div class="le_menu">
                                        <a href="<?php echo base_url(); ?>employ/post"
                                           class="<?php if ($menuSelected == 'post_employ') {
                                               echo 'menu_selected';
                                           } else {
                                               echo 'menu';
                                           } ?>">
                                            <?php echo $this->lang->line('post_employ_job_menu'); ?></a>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="bottom">
                        <div class="fl"></div>
                        <div class="fr"></div>
                    </div>
                </div>
            </td>
        </tr>
        <?php break; ?>

    <?php case 'account': ?>
    <!--Start modified menu Nhanvien -->
    <?php if($group_id == StaffStoreUser) {?>
        <?php
        $uid = $this->session->userdata('sessionUser');
        $u_roles = $this->session->userdata('sessionRoles');

        $query = "SELECT a.use_id, a.use_group
                    FROM tbtt_user a , tbtt_user b
                    WHERE b.parent_id = a.use_id and b.use_id = $uid ";
        $data_parent = $this->db->query($query)->result_array();
        $query1 = "SELECT a.id, a.men_name, a.arr_role, a.is_sub
                    FROM tbtt_user_emp_menu a
                    WHERE a.group_emp = 1 AND a.parent_id = 0 AND a.status = 1
                    ORDER BY a.id ASC";
        $data_menu = $this->db->query($query1)->result_array();
        $query2 = "SELECT a.id, a.men_name AS sub_menu, b.id AS parentID, b.men_name
                    FROM tbtt_user_emp_menu a, tbtt_user_emp_menu b
                    WHERE a.parent_id = b.id AND a.group_emp = 1 AND a.status = 1
                    ORDER BY a.id, b.id ASC";
        $data_sub_menu = $this->db->query($query2)->result_array();

        $menu_emp = array();
        foreach ($data_menu as $key_m => $m_menu) {
            $menu_emp[$m_menu['id']]['id']          = $m_menu['id'];
            $menu_emp[$m_menu['id']]['men_name']    = $m_menu['men_name'];
            $menu_emp[$m_menu['id']]['arr_role']    = $m_menu['arr_role'];
            $menu_emp[$m_menu['id']]['is_sub']      = $m_menu['is_sub'] == 1 ? true : false;
            foreach ($data_sub_menu as $key_s	 => $s_menu) {
                if(in_array($m_menu['id'], $s_menu)) {
                    $menu_emp[$m_menu['id']]['list_sub'][] = $s_menu;
                }
            }
        }

        echo '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';
        foreach ($menu_emp as $key => $value) {
            if(!empty(array_intersect(explode(',',$value['arr_role']),$u_roles))) {?>
                <?php if($data_parent['0']['use_group'] != BranchUser || $value['id'] != 100 && $data_parent['0']['use_group'] == BranchUser) { ?>
                    <div class="panel panel-default panel-menu">
                        <div class="panel-heading" role="tab" id="heading<?php echo $value['id']?>">
                            <a role="button" data-toggle="collapse"
                            data-parent="#accordion" href="#collapse<?php echo $value['id']?>"
                            ria-expanded="true" aria-controls="collapse<?php echo $value['id']?>"><?php echo $value['men_name'] ?></a>
                        </div>
                        <div id="collapse<?php echo $value['id']?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $value['id']?>">
                            <div class="panel-body">
                                <ul class="nav menuadmin">
                                    <?php if(isset($value['list_sub']) && !empty($value['list_sub'])) { ?>
                                        <?php foreach ($value['list_sub'] as $k => $v) { 
                                            if($data_parent['0']['use_group'] != BranchUser || !in_array($v['id'],array(122,136,137,139)) && $data_parent['0']['use_group'] == BranchUser) { ?>
                                            <li>
                                                <a role="presentation" href="<?php echo base_url(). 'account/menu/'. $v['id'] ?>">
                                                    <?php echo $v['sub_menu'] ?>
                                                </a>
                                            </li>
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
            <?php }
        }
        echo '</div>';
    } else if($group_id == BranchUser) { ?>
        <?php $this->load->view('home/common/menu_branch'); ?>
    <?php } else {?>

        <!--End modified menu Nhanvien -->
        <script language="javascript" type="text/javascript">
            jQuery(document).ready(function () {
                $menuselected = '<?php echo $menuSelected; ?>';
                $menutype = '';
                if ($menuselected) {
                    if ($menuselected == 'edit' || $menuselected == 'changepassword' || $menuselected == 'updateprofile') {
                        $menutype = 'profile';
                    }
                    if ($menuselected == 'tamgiu') {
                        $menutype = 'tamgiu';
                    }
                    if ($menuselected == 'hoidap') {
                        $menutype = 'hoidap';
                    }
                    if ($menuselected == 'shop' || $menuselected == 'setup_up_normal') {
                        $menutype = 'shop';
                    }
                    if ($menuselected == 'contact' || $menuselected == 'notify' || $menuselected == 'send_contact') {
                        $menutype = 'contact';
                    }
                    if ($menuselected == 'product' || $menuselected == 'favorite_product') {
                        $menutype = 'product';
                    }
                    if ($menuselected == 'product_coupon') {
                        $menutype = 'product_coupon';
                    }
                    if ($menuselected == 'product_service') {
                        $menutype = 'product_service';
                    }
                    if ($menuselected == 'order_coupon') {
                        $menutype = 'order_coupon';
                    }
                    if ($menuselected == 'order_service') {
                        $menutype = 'order_service';
                    }

                    if ($menuselected == 'raovat' || $menuselected == 'favorite_ads') {
                        $menutype = 'raovat';
                    }
                    if ($menuselected == 'job' || $menuselected == 'favorite_job' || $menuselected == 'employ' || $menuselected == 'favorite_employ') {
                        $menutype = 'job';
                    }
                    if ($menuselected == 'customer' || $menuselected == 'showcart') {
                        $menutype = 'showcart';
                    }
                    if ($menuselected == 'naptien' || $menuselected == 'lichsugiaodich') {
                        $menutype = 'money';
                    }

                    if ($menuselected == 'setup_up' || $menuselected == 'history_up') {

                        $menutype = 'uptin';
                    }
                    if ($menuselected == 'addbanner' || $menuselected == 'listbanner') {
                        $menutype = 'banner';
                    }
                    if ($menuselected == 'docs') {
                        $menutype = 'docs';
                    }
                    if ($menuselected == 'task') {
                        $menutype = 'task';
                    }
                    if ($menuselected == 'affiliate') {
                        $menutype = 'affiliate';
                    }
                    if ($menuselected == 'statistic') {
                        $menutype = 'statistic';
                    }
                    if ($menuselected == 'statisticStore') {
                        $menutype = 'statisticStore';
                    }
                    if ($menuselected == 'tree') {
                        $menutype = 'tree';
                    }
                    if ($menuselected == 'advs') {
                        $menutype = 'advs';
                    }
                    if ($menuselected == 'service') {
                        $menutype = 'service';
                    }
                    if ($menuselected == 'news') {
                        $menutype = 'news';
                    }
                    if ($menuselected == 'commission') {
                        $menutype = 'commissions';
                    }
                    if ($menuselected == 'income') {
                        $menutype = 'income';
                    }
                    if ($menuselected == 'landingpage') {
                        $menutype = 'landingpage';
                    }
                    if ($menuselected == 'azidirect') {
                        $menutype = 'account';
                    }
                    if ($menuselected == 'azibranch') {
                        $menutype = 'account';
                    }
                    if ($menuselected == 'azipublisher') {
                        $menutype = 'account';
                    }
                    if ($menuselected == 'aziaffiliate') {
                        $menutype = 'account';
                    }
                    if ($menuselected == 'azimanager') {
                        $menutype = 'account';
                    }

                    if ($menuselected == 'requirements_change_delivery') {
                        $menutype = 'requirements_change_delivery';
                    }

                    if ($menuselected == 'recharge_and_spend_money') {
                        $menutype = 'recharge_and_spend_money';
                    }
                    if ($menuselected == 'share' || $menuselected == 'sharelist') {
                        $menutype = 'share';
                    }
                    if ($menuselected == 'chinhanh') {
                        $menutype = 'chinhanh';
                    }
                    if ($menuselected == 'staffstore') {
                        $menutype = 'staffstore';
                    }
                    if ($menuselected == 'grouptrade') {
                        $menutype = 'grouptrades';
                    }
                    if ($menuselected == 'grtthamgia') {
                        $menutype = 'grtthamgia';
                    }
                    if ($menuselected == 'hanhchinh') {
                        $menutype = 'hanhchinh';
                    }
                    if ($menuselected == 'flatform') {
                        $menutype = 'flatform';
                    }

                }
                if ($menutype) {
                    jQuery('#' + $menutype + '_title').attr('class', 'left_menu_title_current');
                    jQuery('#' + $menutype + '_link').attr('class', 'left_menu_show');
                }
            });
            function show_left_menu($menuid) {
                if (jQuery('#' + $menuid + '_title').attr('class') == 'left_menu_title_current') {
                    jQuery('#' + $menuid + '_title').attr('class', 'left_menu_title');
                    jQuery('#' + $menuid + '_link').attr('class', 'left_menu_hidden');
                } else {
                    jQuery('.left_menu_title_current').attr('class', 'left_menu_title');
                    jQuery('.left_menu_show').attr('class', 'left_menu_hidden');
                    jQuery('#' + $menuid + '_title').attr('class', 'left_menu_title_current');
                    jQuery('#' + $menuid + '_link').attr('class', 'left_menu_show');
                }
            }
        </script>
        <?php
        //// Chuyen cau truc link sang dang subdomain /////
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $protocol1 = "http://";
        $domainName = $_SERVER['HTTP_HOST'];

        if ($group_id == AffiliateStoreUser || $group_id == AffiliateUser || $group_id == BranchUser) {
            $this->db->flush_cache();
            $shop_info_menu = $this->shop_model->get("sho_link, sho_id, sho_name, domain", "sho_user = " . (int)$this->session->userdata('sessionUser'));
        }
        $link_abc = $protocol . $shoplink . '.' . $domainName;
        $my_link_shop = $protocol . $shop_info_menu->sho_link . '.' . $domainName . '/shop';
        if ($shop_info_menu->domain != "") {
            $my_link_shop = $protocol1 . $shop_info_menu->domain . '/shop';
        }
        ?>
        <?php
            if($group_id == AffiliateUser) {
                $khctv = 'Kho hàng cộng tác viên chọn bán';
                $qlsp = 'Quản lý sản phẩm';
                $sp = 'Danh sách sản phẩm';
                $favorite_pro = 'Sản phẩm yêu thích';
                $coupon = 'phiếu mua hàng điện tử';
                $tk = 'Báo cáo kết quả kinh doanh';
                $tn = 'Quản lý thu nhập';
                $tnctv = 'Thu nhập từ bán hàng';
                $tntt = 'Thu nhập bán hàng tạm tính';
            }else{
                $khctv = 'Cộng tác viên';
                $qlsp = 'Quản lý sản phẩm';
                $sp = $this->lang->line('product_account_menu');
                $favorite_pro = $this->lang->line('favorite_product_account_menu');
                $coupon = 'coupon';
                $tk = 'Thống kê hệ thống';
                $tn = 'Thu nhập';
                $tnctv = 'Thu nhập cộng tác viên';
                $tntt = 'Thu nhập tạm tính';
            }
        ?>

        <tr>
            <td>
                <?php
                $url = $this->uri->segment(2);
                if ($url) { ?>
                    <a id="btn_menu" class="btn btn-azibai visible-xs">
                        <i class="fa fa-bars fa-fw"></i> <span> MENU </span>
                    </a>
                <?php } else { ?>
                    <a id="btn_menu_home" class="btn btn-azibai  visible-xs">
                        <i class="fa fa-bars"></i> <span> MENU </span>
                    </a>
                <?php } ?>

                <div class="collapse navbar-collapse" id="menuNavbar" style="padding:0">
                    <div id="list_module">
                        <ul class="sortable-list ui-sortable">
                            <li>
                                <?php if ($group_id == AffiliateStoreUser || $group_id == AffiliateUser || $group_id == BranchUser) { ?>
                                    <a class="left_menu_title" target="_blank" href="<?php echo $my_link_shop; ?>">Xem gian hàng<i class="fa fa-eye pull-right"></i> </a>
                                <?php } ?>
                            </li>                            
                            <li id="0">
                                <a class="left_menu_title" href="<?php echo base_url(); ?>account">Bảng điều khiển</a>
                            </li>

                            <li id="1">
                                <a href="javascript:show_left_menu('profile')" class="left_menu_title" id="profile_title"><?php echo $this->lang->line('general_info_account_menu'); ?></a>

                                <div class="left_menu_hidden" id="profile_link">
                                    <div class="bg_left_menu">
                                        <a href="<?php echo base_url(); ?>account/edit" class="left_menu">
                                            <i class="fa fa-info-circle"></i> <?php echo $this->lang->line('edit_account_account_menu'); ?>
                                        </a>                                        
                                    </div>
                                    <div class="bg_left_menu">                                        
                                        <a href="<?php echo base_url(); ?>account/updateprofile" class="left_menu">
                                            <i class="fa fa-pencil-square-o"></i> Cập nhật hồ sơ
                                        </a>
                                    </div>
                                    <div class="bg_left_menu">                                        
                                        <a href="<?php echo base_url(); ?>account/changepassword" class="left_menu">
                                            <i class="fa fa-key"></i> <?php echo $this->lang->line('change_password_account_menu'); ?>
                                        </a>
                                    </div>
                                    <?php if ($group_id == AffiliateUser) { ?>
                                    <div class="bg_left_menu">                                            
                                        <a href="<?php echo base_url(); ?>account/delete" class="left_menu">
                                            <i class="fa fa-user-times"></i> Hủy tài khoản
                                        </a>                                           
                                    </div>
                                    <?php } ?>
                                </div>
                            </li>

                            <!-- <li id="2"><a href="javascript:show_left_menu('contact')" class="left_menu_title" id="contact_title">Thông báo và tin nhắn</a>
                                <div class="left_menu_hidden" id="contact_link">
                                    <div class="bg_left_menu">
                                        <div style="float:left"><a href="<?php echo base_url(); ?>account/notify" class="left_menu"><i class="fa fa-bullhorn"></i> <?php echo $this->lang->line('notify_account_menu'); ?>
                                            </a></div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div class="bg_left_menu">
                                        <div style="float:left"><a href="<?php echo base_url(); ?>account/contact/send" class="left_menu"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Soạn thư</a>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div class="bg_left_menu">
                                        <div style="float:left"><a href="<?php echo base_url(); ?>account/contact" class="left_menu"><i class="fa fa-inbox" aria-hidden="true"></i> Thư đã nhận</a>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                    <div class="bg_left_menu">
                                        <div style="float:left">
                                            <a href="<?php echo base_url(); ?>account/contact/outbox" class="left_menu"><i class="fa fa-paper-plane"></i>Thư đã gửi</a>
                                        </div>
                                        <div style="clear:both"></div>
                                    </div>
                                </div>
                            </li> -->

                            <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser) { ?>
                                <li id="12">
                                    <a href="javascript:show_left_menu('news')" class="left_menu_title" id="news_title">Quản lý tin tức</a>
                                    <div class="left_menu_hidden" id="news_link">
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/news/add" class="left_menu"><i class="fa fa-plus-circle"></i> Đăng tin</a>
                                        </div>
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/news" class="left_menu"><i class="fa fa-list-ul"></i> Tin đã đăng</a>
                                        </div>
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/comments" class="left_menu"><i class="fa fa-comment"></i> Bình luận của khách hàng</a>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>

                            <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser) { ?>
                                <li id="5">
                                    <a href="javascript:show_left_menu('product')" class="left_menu_title" id="product_title">
                                        <?php echo $qlsp; ?>
                                    </a>

                                    <div class="left_menu_hidden" id="product_link">
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/product/product"
                                               class="left_menu"><i class="fa fa-shopping-bag"></i> <?php echo $sp; ?>
                                            </a>
                                        </div>
                                        <?php if ($group_id == BranchUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/profromshop"
                                                   class="left_menu"><i class="fa fa-shopping-basket"></i> <?php echo $this->lang->line('product_from_shop'); ?>
                                                </a>
                                            </div>
                                        <?php } ?>
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/product/product/post" class="left_menu"><i class="fa fa-plus-circle"></i> Đăng sản phẩm mới</a>
                                        </div>
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/product/product/favorite" class="left_menu"><i class="fa fa-thumbs-up"></i> <?php echo $favorite_pro; ?>
                                            </a>
                                        </div>
                                    </div>
                                </li>

                                <?php if (serviceConfig == 1) { ?>
                                    <li id="21">
                                        <a href="javascript:show_left_menu('product_service')" class="left_menu_title" id="product_service_title">Dịch vụ</a>
                                        <div class="left_menu_hidden" id="product_service_link"> 
                                            <div class="bg_left_menu"> 
                                                <a href="<?php echo base_url(); ?>account/product/service" class="left_menu"><i class="fa fa-shopping-bag"></i> Dịch vụ </a>
                                            </div> 
                                            <div class="bg_left_menu"> 
                                                <a href="<?php echo base_url(); ?>product/product/service/post" class="left_menu"><i class="fa fa-plus-circle"></i> Đăng Dịch vụ</a>
                                            </div> 
                                            <div class="bg_left_menu"> 
                                                <a href="<?php echo base_url(); ?>account/product/service/favorite" class="left_menu"><i class="fa fa-thumbs-up"></i> Dịch vụ yêu thích </a> 
                                            </div> 
                                        </div> 
                                    </li>
                                <?php } ?>

                                <li id="20">
                                    <a href="javascript:show_left_menu('product_coupon')" class="left_menu_title" id="product_coupon_title">Quản lý <?php echo $coupon ?></a>
                                    <div class="left_menu_hidden" id="product_coupon_link">
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/product/coupon" class="left_menu"><i class="fa fa-shopping-bag"></i> Danh sách <?php echo $coupon ?> </a>
                                        </div>
                                        <?php if ($group_id == BranchUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/coufromshop" class="left_menu"><i class="fa fa-shopping-basket"></i> <?php echo $this->lang->line('coupon_from_shop'); ?> </a>
                                            </div>
                                        <?php } ?>
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/product/coupon/post" class="left_menu"><i class="fa fa-plus-circle"></i> Đăng <?php echo $coupon ?> mới</a>
                                        </div>
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/product/coupon/favorite" class="left_menu"><i class="fa fa-thumbs-up"></i> Phiếu mua hàng điện tử yêu thích </a>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>

                            <?php if ($group_id >= AffiliateUser) { ?>
                                <li id="4">
                                    <a href="javascript:show_left_menu('affiliate')" class="left_menu_title"
                                       id="affiliate_title"><?php echo $khctv ?></a>

                                    <div class="left_menu_hidden" id="affiliate_link">
                                        <?php if ($group_id == AffiliateUser) { ?>
                                            <div class="bg_left_menu"> 
                                                <a href="<?php echo base_url(); ?>account/affiliate/products" class="left_menu"><i class="fa fa-search-plus"></i> Tìm sản phẩm để chọn bán</a> 
                                            </div> 
                                            <div class="bg_left_menu"> 
                                                <a href="<?php echo base_url(); ?>account/affiliate/myproducts" class="left_menu"><i class="fa fa-shopping-bag"></i> Sản phẩm đã chọn bán</a> 
                                            </div> 
                                            <div class="bg_left_menu"> 
                                                <a href="<?php echo base_url(); ?>account/affiliate/pressproducts" class="left_menu"><i class="fa fa-shopping-bag"></i> Sản phẩm ký gửi hàng Online</a> 
                                            </div>
                                        <?php } ?>

                                        <?php if ($group_id > AffiliateUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/tree/inviteaf" class="left_menu"><i class="fa fa-files-o"></i> Giới thiệu mở Cộng tác viên online</a>
                                            </div>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/listaffiliate" class="left_menu"><i class="fa fa-user"></i> Cộng tác viên online đã giới thiệu</a>
                                            </div>
                                            <?php if ($group_id != StaffUser) { ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/allaffiliateunder" class="left_menu">
                                                        <i class="fa fa-user"></i> 
                                                        Cộng tác viên online <?php if ($group_id == AffiliateStoreUser) { echo 'toàn công ty'; } else echo 'trực thuộc hệ thống dưới'; ?> 
                                                    </a>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php if ($group_id == AffiliateStoreUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/affiliate/configaffiliate"
                                                   class="left_menu"><i class="fa fa-cogs"></i> Thưởng thêm Cộng tác viên</a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>

                            <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser || $group_id == AffiliateUser || $group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser) { ?>
                                <li id="9">
                                    <a href="javascript:show_left_menu('shop')" class="left_menu_title" id="shop_title">Quản lý gian
                                        hàng <?php if ($group_id == AffiliateUser) { ?> cộng tác viên<?php } elseif ($group_id == BranchUser) { ?> chi nhánh <?php } ?></a>
                                    <div class="left_menu_hidden" id="shop_link">
                                        <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser || $group_id == AffiliateUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/shop" class="left_menu"><i
                                                        class="fa fa-pencil-square-o"></i> Cập nhật thông tin gian hàng
                                                </a>
                                            </div>

                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/shop/intro" class="left_menu"><i
                                                        class="fa fa-info-circle"></i> Giới thiệu về Gian hàng
                                                </a>
                                            </div>

                                            <?php if ($group_id != AffiliateUser) { ?>
                                                <div class="bg_left_menu" style="border-bottom:1px dotted #90CFFA">
                                                    <a href="<?php echo base_url(); ?>account/shop/shoprule"
                                                       class="left_menu"><i
                                                            class="fa fa-cogs"></i> <?php echo $this->lang->line('edit_shop_account_shop_rule_menu'); ?>
                                                    </a>
                                                </div>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/shop/warranty"
                                                       class="left_menu"><i
                                                            class="fa fa-wrench"></i> <?php echo $this->lang->line('edit_shop_account_warranty_menu'); ?>
                                                    </a>
                                                </div>
                                            <?php } ?>

                                        <?php } ?>

                                        <?php if ($group_id != AffiliateStoreUser && $group_id != BranchUser && $group_id != AffiliateUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/tree/invite"
                                                   class="left_menu"><i
                                                        class="fa fa-info-circle"></i> Giới thiệu mở gian hàng</a>
                                            </div>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/tree/store" class="left_menu"><i
                                                        class="fa fa-info-circle"></i> Gian hàng đã giới thiệu</a>
                                            </div>
                                        <?php } ?>

                                        <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser || $group_id == AffiliateUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/shop/domain"
                                                   class="left_menu"><i
                                                        class="fa fa-cogs"></i> <?php echo $this->lang->line('edit_shop_domain'); ?>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>

                            <!-- Menu Chi nhanh -->
                            <?php if ($group_id == AffiliateStoreUser || $group_id == StaffStoreUser) { ?>
                                <li id="211"><a href="javascript:show_left_menu('chinhanh')" class="left_menu_title" id="chinhanh_title"><?php echo $this->lang->line('sub_comany'); ?></a>

                                    <div class="left_menu_hidden" id="chinhanh_link">
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/addbranch"
                                               class="left_menu"><i class="fa fa-plus-circle"></i> <?php echo 'Thêm Chi nhánh'; ?>
                                            </a>
                                        </div>
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/listbranch"
                                               class="left_menu"><i class="fa fa-list-ol fa-fw"></i> <?php echo $this->lang->line('list_sub_comany'); ?>
                                            </a>
                                        </div>
                                        <?php if ($group_id != StaffStoreUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>branch/prowaitingapprove"
                                                   class="left_menu"><i class="fa fa-cubes fa-fw"></i> <?php echo $this->lang->line('product_waiting'); ?>
                                                </a>
                                            </div>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>branch/flyerwaitapprove"
                                                   class="left_menu"><i class="fa fa-file-text-o fa-fw"></i> <?php echo $this->lang->line('landing_page_waiting'); ?>
                                                </a>
                                            </div>

                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>branch/newswaitapprove"
                                                   class="left_menu"><i class="fa fa-newspaper-o fa-fw"></i> <?php echo $this->lang->line('news_waiting'); ?>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>
                            <!-- End menu Chi Nhanh -->

                            <?php
                            if ($group_id == AffiliateStoreUser || $group_id == BranchUser || $group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser || $group_id == StaffUser || $group_id == StaffStoreUser) { ?>
                                <li id="3">
                                    <a href="javascript:show_left_menu('task')" class="left_menu_title"
                                       id="task_title"><?php if ($group_id != StaffStoreUser && $group_id != StaffUser) {
                                            echo 'Nhân viên';
                                        } else echo 'Tình trạng công việc'; ?></a>
                                    <div class="left_menu_hidden" id="task_link">
                                        <?php if ($group_id != StaffUser && $group_id != StaffStoreUser) { ?>
                                            <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser) { ?>
                                                <?php if (($sho_package && $sho_package['id'] >= 4) || ($sho_pack_bran && $sho_pack_bran['id'] >= 4)) : ?>
                                                    <div class="bg_left_menu">
                                                        <a href="<?php echo base_url(); ?>account/staffs/add" class="left_menu">
                                                            <i class="fa fa-plus-circle"></i> Thêm Nhân viên</a>
                                                    </div>

                                                    <div class="bg_left_menu">
                                                        <a href="<?php echo base_url(); ?>account/staffs/all" class="left_menu"><i class="fa fa-list-ul"></i> Danh sách Nhân viên</a>
                                                    </div>

                                                <?php endif; ?>
                                                <?php if ($group_id == AffiliateStoreUser) { ?>
                                                    <div class="bg_left_menu">
                                                        <a href="<?php echo base_url(); ?>account/statisticalbran"
                                                           class="left_menu">
                                                            <i class="fa fa-line-chart"></i> Thống kê chi nhánh</a>
                                                    </div>
                                                <?php } ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/statisticalemployee"
                                                       class="left_menu">
                                                        <i class="fa fa-line-chart"></i> Thống kê cộng tác viên</a>
                                                </div>
                                            <?php } ?>

                                            <?php if ($group_id != BranchUser && $group_id != Developer2User) { ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/viewtasks/month/<?php echo date('m'); ?>"
                                                       class="left_menu">
                                                        <i class="fa fa-tasks"></i> Bảng công việc từ cấp trên</a>
                                                </div>
                                            <?php } ?>

                                            <?php if ($group_id != AffiliateStoreUser && $group_id != BranchUser) { ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/treetaskuser"
                                                       class="left_menu"><i
                                                            class="fa fa-share"></i> Phân công cho cấp dưới</a>
                                                </div>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/treetask/today"
                                                       class="left_menu"><i
                                                            class="fa fa-wifi"></i> Tình trạng công việc cấp
                                                        dưới</a>
                                                </div>
                                            <?php } ?>

                                        <?php } else { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/viewtasks/month/<?php echo date('m'); ?>" class="left_menu"><i class="fa fa-sort-amount-desc"></i> Phân công từ gian hàng</a>
                                            </div>
                                        <?php } ?>

                                    </div>
                                </li>
                            <?php } ?>                           

                            <!-- Begin: menu nhóm -->
                            <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser) { ?>
                                <li id="12">
                                    <a href="javascript:show_left_menu('grouptrades')" class="left_menu_title" id="grouptrades_title">Quản lý nhóm
                                        <?php if($to_invite > 0) { ?>
                                            <span class="badge pull-right" id="note_invite" style="background-color: #ff0000; display: inline-block; padding: 6px 12px;" data-toggle="modal" data-target="#checkModal" title="Click vào đây để chấp nhận">+ <?php echo $to_invite; ?> Lời mời</span>
                                        <?php } ?>
                                    </a>

                                    <div class="left_menu_hidden" id="grouptrades_link">
                                        <?php if ($group_id == AffiliateStoreUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/group/mychannel" class="left_menu"><i class="fa fa-list"></i>Danh sách nhóm của tôi</a>
                                            </div>
                                        <?php } ?>
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/group/joinchannel" class="left_menu"><i class="fa fa-list"></i>Danh sách nhóm tham gia</a>
                                        </div>
                                        <?php if ($group_id == AffiliateStoreUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>grouptrade/add" class="left_menu"><i class="fa fa-plus-circle"></i> Tạo nhóm thương mại</a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>
                            <!-- End: menu nhóm -->

                            <!-- Begin:: menu platform -->
                            <?php if ($group_id == Developer2User) { ?>
                                <li id="31"><a href="javascript:show_left_menu('flatform')" class="left_menu_title" id="flatform_title">Quản lý sàn D2</a>
                                    <div class="left_menu_hidden" id="flatform_link">
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/flatformd2/add"
                                               class="left_menu"><i class="fa fa-plus-circle"></i> Cập nhật sàn D2
                                            </a>
                                        </div>

                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/flatformd2/joinshop"
                                               class="left_menu"><i class="fa fa-plus-circle"></i> Chọn gian hàng vào sàn
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                            <!-- Begin:: menu platform -->

                            <?php if ($group_id == 1) { ?>
                                <li id="4">
                                    <a href="javascript:show_left_menu('affiliate')" class="left_menu_title"
                                       id="affiliate_title">Cộng tác viên</a>
                                    <div class="left_menu_hidden" id="affiliate_link">
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/affiliate/upgrade" class="left_menu"><i class="fa fa-search-plus"></i> Nâng cấp lên cộng tác viên</a>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>

                            <?php if ($group_id == BranchUser || $group_id == NormalUser || $group_id == StaffUser || $group_id == AffiliateUser || $group_id == AffiliateStoreUser || $group_id == StaffStoreUser || in_array($group_id, array(Developer2User, Developer1User, Partner2User, Partner1User, CoreMemberUser, CoreAdminUser))) { ?>
                                <li id="6">
                                    <a href="javascript:show_left_menu('showcart')" class="left_menu_title"
                                       id="showcart_title"><?php echo 'Quản lý đơn hàng'; ?></a>
                                    <div class="left_menu_hidden" id="showcart_link">
                                        <?php if ($group_id == NormalUser || $group_id == AffiliateStoreUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/user_order" class="left_menu"><i class="fa fa-shopping-cart"></i> <?php
                                                    if ($group_id == AffiliateStoreUser) {
                                                        echo 'Đơn hàng mua sỉ';
                                                    } else {
                                                        echo 'Đơn hàng cá nhân';
                                                    }
                                                    ?></a>
                                            </div>
                                        <?php } ?>

                                        <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/order/product"
                                                   class="left_menu"><i class="fa fa-shopping-cart"></i> Đơn hàng SP Gian hàng</a>
                                            </div>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/order/coupon"
                                                   class="left_menu"><i class="fa fa-tags"></i> Đơn hàng Coupon Gian hàng</a>
                                            </div>
                                        <?php } ?>

                                        <?php if ($group_id == AffiliateUser || $group_id == StaffStoreUser || $group_id == StaffUser ) { ?>
                                            <?php if ($group_id == AffiliateUser) { ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/user_order"
                                                       class="left_menu"><i class="fa fa-shopping-cart"></i> Đơn hàng tôi đã mua</a>
                                                </div>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/affiliate/orders" class="left_menu">
                                                        <i class="fa fa-shopping-cart"></i> Đơn hàng tôi đã bán
                                                    </a>
                                                </div>
                                            <?php } ?>
                                            <?php if ($group_id == StaffStoreUser) { ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/listbran_order" class="left_menu"><i class="fa fa-shopping-cart"></i> Đơn hàng Chi nhánh</a>
                                                </div>
                                            <?php } ?>
                                            <?php if ($group_id != AffiliateUser) { ?>

                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/affiliate/orders" class="left_menu"><i class="fa fa-shopping-cart"></i> Đơn hàng Cộng tác viên</a>
                                                </div>

                                            <?php } ?>
                                        <?php } ?>

                                        <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/customer" class="left_menu"><i class="fa fa-users"></i> Khách hàng từ Gian hàng</a>
                                            </div>
                                        <?php } ?>

                                        <?php if (in_array($group_id, array(Developer2User, Developer1User, Partner2User, Partner1User, CoreMemberUser, CoreAdminUser))) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/order/viewbyparent" class="left_menu"><i class="fa fa-shopping-cart"></i> Đơn hàng cấp dưới</a>
                                            </div>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/order/coupon"
                                                   class="left_menu"><i class="fa fa-shopping-cart"></i> Đơn hàng coupon</a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>

                            <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser || $group_id == StaffStoreUser || $group_id == StaffUser) { ?>
                                <li id="19"><a href="javascript:show_left_menu('requirements_change_delivery')"
                                               class="left_menu_title"
                                               id="requirements_change_delivery_title"><?php echo $this->lang->line('requirements_change_delivery'); ?></a>

                                    <div class="left_menu_hidden" id="requirements_change_delivery_link">
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/complaintsOrders"
                                               class="left_menu"><i class="fa fa-arrows" aria-hidden="true"></i>
                                                <?php echo $this->lang->line('requirements_change_delivery'); ?></a>
                                        </div>
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/solvedOrders" class="left_menu"><i
                                                    class="fa fa-arrows" aria-hidden="true"></i>
                                                <?php echo $this->lang->line('requirements_solved_delivery'); ?></a>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>

                            <?php if (in_array($group_id, array(AffiliateUser, AffiliateStoreUser))) { ?>
                                <li id="19"><a href="javascript:show_left_menu('recharge_and_spend_money')"
                                               class="left_menu_title"
                                               id="recharge_and_spend_money"><?php echo $this->lang->line('recharge_and_spend_money'); ?></a>
                                    <?php if (in_array($group_id, array(AffiliateUser, AffiliateStoreUser))) { ?>
                                        <div class="left_menu_hidden" id="recharge_and_spend_money_link">
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/addWallet" class="left_menu">
                                                    <i class="fa fa-money"
                                                       aria-hidden="true"></i> <?php echo $this->lang->line('add_money_to_account'); ?>
                                                </a>
                                            </div>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/historyRecharge"
                                                   class="left_menu">
                                                    <i class="fa fa-history"
                                                       aria-hidden="true"></i> <?php echo $this->lang->line('history_recharge'); ?>
                                                </a>
                                            </div>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/spendingHistory"
                                                   class="left_menu">
                                                    <i class="fa fa-history"
                                                       aria-hidden="true"></i> <?php echo $this->lang->line('spending_history'); ?>
                                                </a>
                                            </div>


                                        </div>
                                    <?php } ?>
                                </li>
                            <?php } ?>

                            <?php if ($group_id == AffiliateStoreUser || $group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser || $group_id == BranchUser || $group_id == AffiliateUser || $group_id == StaffUser || $group_id == StaffStoreUser) { ?>
                                <li id="7"><a href="javascript:show_left_menu('statistic')" class="left_menu_title"
                                              id="statistic_title"><?php echo $tk ?></a>
                                    <div class="left_menu_hidden" id="statistic_link">
                                        <?php if ($group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser) { ?>

                                            <?php if ($group_id == Partner1User || $group_id == Partner2User || $group_id == CoreMemberUser || $group_id == CoreAdminUser) { ?>

                                                <?php if ($group_id != Partner2User) { ?>
                                                    <div class="bg_left_menu">
                                                        <a href="<?php echo base_url(); ?>account/listPartner"
                                                           class="left_menu"><i class="fa fa-line-chart"></i> Danh sách Partner</a>
                                                    </div>
                                                    <div class="bg_left_menu">
                                                        <a href="<?php echo base_url(); ?>account/statisticlistPartner"
                                                           class="left_menu"><i
                                                                class="fa fa-line-chart"></i> Thống kê doanh số Partner </a>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                            <?php if ($group_id != Developer2User){ ?>
                                                    <div class="bg_left_menu">
                                                        <a href="<?php echo base_url(); ?>account/listDeveloper"
                                                           class="left_menu"><i class="fa fa-line-chart"></i> Danh sách Developer trực thuộc</a>
                                                    </div>
                                                <?php if ($group_id != Developer1User){ ?>
                                                    <div class="bg_left_menu">
                                                        <a href="<?php echo base_url(); ?>account/listallDeveloper"
                                                           class="left_menu"><i class="fa fa-line-chart"></i> Danh sách Developer của toàn hệ thống</a>
                                                    </div>
                                                <?php } ?>
                                                    <div class="bg_left_menu">
                                                        <a href="<?php echo base_url(); ?>account/statisticlistDeveloper"
                                                           class="left_menu"><i class="fa fa-line-chart"></i> Thống kê doanh số của Developer </a>
                                                    </div>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php if ($group_id != AffiliateUser && $group_id != StaffUser && $group_id != BranchUser && $group_id != AffiliateStoreUser && $group_id != StaffStoreUser) { ?>
                                            <?php if ($group_id == Developer1User || $group_id == Developer2User) { ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/statisticlistshop"
                                                       class="left_menu"><i
                                                            class="fa fa-line-chart"></i> Thống kê doanh số gian hàng trực thuộc</a>
                                                </div>
                                            <?php } ?>
                                            <?php if ($group_id != Developer2User) { ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/statisticlistshopall"
                                                       class="left_menu"><i
                                                            class="fa fa-line-chart"></i> Thống kê doanh số gian hàng toàn hệ thống</a>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser || $group_id == AffiliateUser || $group_id == StaffUser || $group_id == StaffStoreUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/statistic"
                                                   class="left_menu"><i
                                                        class="fa fa-line-chart"></i> Thống kê chung</a>
                                            </div>
                                            <?php if ($group_id != StaffUser && $group_id != StaffStoreUser) { ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/statisticIncome"
                                                       class="left_menu"><i
                                                            class="fa fa-line-chart"></i> Thống kê
                                                        <?php if ($group_id != StaffStoreUser) {
                                                            echo 'thu nhập';
                                                        } else echo 'doanh số'; ?>
                                                    </a>
                                                </div>
                                            <?php } ?>

                                            <?php if ($group_id != AffiliateUser && $group_id != BranchUser && $group_id != StaffUser) { ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/statisticlistbran"
                                                       class="left_menu"><i
                                                            class="fa fa-line-chart"></i> Thống kê chi nhánh </a>
                                                </div>
                                            <?php } ?>

                                            <?php if ($group_id != AffiliateUser && $group_id != StaffUser && $group_id != StaffStoreUser) { ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/salesemployee"
                                                       class="left_menu"><i
                                                            class="fa fa-line-chart"></i> Thống kê nhân viên </a>
                                                </div>
                                            <?php } ?>

                                            <?php if ($group_id == AffiliateStoreUser || $group_id == StaffUser || $group_id == StaffStoreUser || $group_id == BranchUser) {
                                                ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/statisticlistaffiliate"
                                                       class="left_menu"><i
                                                            class="fa fa-line-chart"></i> Thống kê Cộng tác viên
                                                    </a>
                                                </div>
                                            <?php } ?>

                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/statisticproduct"
                                                   class="left_menu">
                                                    <i class="fa fa-line-chart"></i> Thống kê theo sản phẩm</a>
                                            </div>

                                        <?php } ?>

                                    </div>
                                </li>
                            <?php } ?>

                            <?php if ($sho_package && $sho_package['id'] > 3) { ?>
                                <?php if ($group_id == AffiliateStoreUser) { ?>
                                    <li id="8"><a href="javascript:show_left_menu('statisticStore')"
                                                  class="left_menu_title"
                                                  id="statisticStore_title">Thống kê gian hàng</a>

                                        <div class="left_menu_hidden" id="statisticStore_link">
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/statistic_Store"
                                                   class="left_menu"><i
                                                        class="fa fa-line-chart"></i> Thống kê chung</a>
                                            </div>
                                            <?php if ($group_id != StaffUser && $group_id != StaffStoreUser) { ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/statisticIncome_Store"
                                                       class="left_menu"><i
                                                            class="fa fa-line-chart"></i> Thống kê
                                                        <?php if ($group_id != StaffStoreUser) {
                                                            echo 'thu nhập';
                                                        } else echo 'doanh số'; ?>
                                                    </a>
                                                </div>
                                            <?php } ?>

                                            <?php if ($group_id != AffiliateUser && $group_id != StaffUser && $group_id != StaffStoreUser) { ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/salesemployee_Store"
                                                       class="left_menu"><i
                                                            class="fa fa-line-chart"></i> Thống kê nhân viên </a>
                                                </div>
                                            <?php } ?>

                                            <?php if ($group_id == AffiliateStoreUser || $group_id == StaffUser || $group_id == StaffStoreUser || $group_id == BranchUser) {
                                                ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/statisticlistaffiliate_Store"
                                                       class="left_menu"><i
                                                            class="fa fa-line-chart"></i> Thống kê Cộng tác viên </a>
                                                </div>
                                            <?php } ?>

                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/statisticproduct_Store"
                                                   class="left_menu">
                                                    <i class="fa fa-line-chart"></i> Thống kê theo sản phẩm</a>
                                            </div>

                                        </div>
                                    </li>
                                <?php } ?>
                            <?php } ?>

                            <?php if ($group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser) { ?>
                                <li id="7"><a href="javascript:show_left_menu('commissions')" class="left_menu_title" id="commissions_title">Hoa hồng</a>
                                    <div class="left_menu_hidden" id="commissions_link">
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/commission" class="left_menu"><i class="fa fa-percent"></i> Hoa hồng hệ thống</a>
                                        </div>
                                    </div>
                                </li>
                                <?php
                            }

                            if ($group_id != NormalUser && $group_id != StaffUser && $group_id != StaffStoreUser) {
                                ?>
                                <li id="7"><a href="javascript:show_left_menu('income')" class="left_menu_title"
                                              id="income_title"><?php echo $tn ?></a>
                                    <div class="left_menu_hidden" id="income_link">
                                        <?php if ($group_id == AffiliateUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/income/user"
                                                   class="left_menu"><i
                                                        class="fa fa-percent"></i> <?php echo $tnctv?></a>
                                            </div>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/income/provisional"
                                                   class="left_menu"><i
                                                        class="fa fa-percent"></i> <?php echo $tntt?></a>
                                            </div>

                                        <?php } ?>
                                        <?php if ($group_id == AffiliateStoreUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/income/user"
                                                   class="left_menu"><i
                                                        class="fa fa-percent"></i> Thu nhập Gian hàng</a>
                                            </div>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/income/provisional_store"
                                                   class="left_menu"><i
                                                        class="fa fa-percent"></i> Thu nhập tạm tính</a>
                                            </div>
                                            <!-- <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/income/tamtinhGH"
                                                   class="left_menu"><i
                                                        class="fa fa-percent"></i> Thu nhập tạm tính của gian hàng</a>
                                            </div> -->
                                        <?php } ?>

                                        <?php if ($group_id != AffiliateUser && $group_id != AffiliateStoreUser && $group_id != BranchUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/income/user"
                                                   class="left_menu"><i
                                                        class="fa fa-percent"></i> Thu nhập Cộng tác viên</a>
                                            </div>
                                        <?php } ?>
                                        <?php if ($group_id == BranchUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/income/user"
                                                   class="left_menu"><i
                                                        class="fa fa-percent"></i> Thu nhập Chi Nhánh</a>
                                            </div>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/income/provisional_store"
                                                   class="left_menu"><i
                                                        class="fa fa-percent"></i> Thu nhập tạm tính</a>
                                            </div>
                                        <?php } ?>
                                        <?php if ($group_id > 1) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/bank" class="left_menu">
                                                    <i class="fa fa-university"></i> Cập nhật tài khoản ngân hàng
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>

                                </li>
                            <?php } ?>

                            <?php if ($group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser) { ?>
                                <li id="8"><a href="javascript:show_left_menu('tree')" class="left_menu_title"
                                              id="tree_title">Cây
                                        hệ thống</a>

                                    <div class="left_menu_hidden" id="tree_link">
                                        <?php if ($group_id != Developer2User) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/tree" class="left_menu"><i
                                                        class="fa fa-sitemap"></i> Xem dạng cây</a>
                                            </div>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/treelist" class="left_menu"><i
                                                        class="fa fa-list"></i> Xem dạng danh sách</a>
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if ($group_id != Developer2User) {
                                            ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/tree/request/member"
                                                   class="left_menu"><i class="fa fa-asterisk"></i> Yêu cầu tạo Thành
                                                    viên</a>
                                            </div>
                                        <?php } ?>
                                        <?php
                                        if ($group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser) {
                                            ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/tree/uprated"
                                                   class="left_menu"><i class="fa fa-upload" aria-hidden="true"></i> Yêu cầu nâng cấp Thành viên</a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </li>
                            <?php } ?>

                            <?php if ($group_id == AffiliateStoreUser || $group_id == AffiliateUser) { ?>
                                <?php if ($group_id == AffiliateStoreUser) { ?>
                                    <li id="10">
                                        <a href="javascript:show_left_menu('advs')" class="left_menu_title" id="advs_title">Dịch vụ quảng cáo</a>
                                        <div class="left_menu_hidden" id="advs_link">
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/myads" class="left_menu"><i
                                                        class="fa fa-bullhorn"></i> Banner quảng cáo của tôi</a>
                                            </div>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/advs" class="left_menu"><i
                                                        class="fa fa-bullhorn"></i> Tạo banner quảng cáo</a>
                                            </div>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/advs/click" class="left_menu">
                                                    <i class="fa fa-line-chart"></i> Thống kê lượt click</a>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                                <li id="10">
                                    <a href="javascript:show_left_menu('service')" class="left_menu_title"
                                       id="service_title">Dịch vụ Azibai</a>
                                    <div class="left_menu_hidden" id="service_link">
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/service" class="left_menu">
                                                <i class="fa fa-gratipay"></i> Danh sách dịch vụ
                                            </a>
                                        </div>
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/service/using" class="left_menu">
                                                <i class="fa fa-bookmark"></i> Đang sử dụng
                                            </a>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>

                            <?php if ($group_id == AffiliateUser || $group_id == StaffStoreUser || $group_id == StaffUser) { ?>

                                <li id="10">
                                    <a href="<?php echo base_url(); ?>account/share-land"
                                       class="left_menu_title"
                                       id=""> Danh sách tờ rơi điện tử</a>
                                </li>
                                <!--<li id="10">
                                    <a href="<?php /*echo base_url(); */ ?>account/landing_page/lists/"
                                       class="left_menu_title"
                                       id=""> Danh sách tờ rơi điện tử</a>
                                </li>-->
                            <?php } ?>

                            <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser) { ?>

                                <li id="10"><a href="javascript:show_left_menu('landingpage')" class="left_menu_title"
                                               id="landingpage_title">Công cụ Marketing</a>
                                    <div class="left_menu_hidden" id="landingpage_link">
                                        <!--                                    --><?php //if ($sho_package && $sho_package['id'] > 1):        ?>

                                        <?php if ($group_id != StaffStoreUser) { ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/tool-marketing/email-marketing"
                                                   class="left_menu"><i
                                                        class="fa fa-envelope"></i> Email Marketing</a>
                                            </div>
                                        <?php } ?>
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/landing_page/lists/"
                                               class="left_menu"><i class="fa fa-file-o"></i> Tờ rơi điện tử</a>
                                        </div>


                                        <div class="hidden">
                                            <!--                                    --><?php //endif;         ?>
                                            <?php if ($sho_package && $sho_package['id'] > 1): ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/tool-marketing/azi-direct"
                                                       class="left_menu"><i
                                                            class="fa fa-cloud-download"></i> Azi-direct</a>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($sho_package && $sho_package['id'] > 2): ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/tool-marketing/azi-branch"
                                                       class="left_menu"><i
                                                            class="fa fa-map-marker"></i> Azi-branch</a>
                                                </div>
                                            <?php endif; ?>
                                            <?php if ($sho_package && $sho_package['id'] > 1): ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/tool-marketing/azi-publisher"
                                                       class="left_menu"><i
                                                            class="fa fa-rss"></i> Azi-publisher</a>
                                                </div>
                                            <?php endif; ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/tool-marketing/azi-affiliate"
                                                   class="left_menu"><i
                                                        class="fa fa-share-alt "></i> Cộng tác viên online Azibai</a>
                                            </div>
                                            <?php if ($sho_package && $sho_package['id'] > 4): ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/tool-marketing/azi-manager"
                                                       class="left_menu"><i
                                                            class="fa fa-tachometer"></i> Azi-manager</a>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>

                            <?php if ($group_id == AffiliateStoreUser || $group_id == StaffStoreUser || $group_id == StaffUser || $group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser || $group_id == AffiliateUser || $group_id == BranchUser) { ?>
                                <li id="11"><a href="javascript:show_left_menu('docs')" class="left_menu_title"
                                               id="docs_title">Tài
                                        liệu</a>

                                    <div class="left_menu_hidden" id="docs_link">
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/docs/30/chinh-sach-thanh-vien.html"
                                               class="left_menu"><i class="fa fa-user"></i> Chính sách thành viên</a>
                                        </div>
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/docs/33/chinh-sach-hoa-hong.html"
                                               class="left_menu"><i class="fa fa-percent"></i> Chính sách hoa hồng</a>
                                        </div>
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/docs/31/huong-dan-cach-lam-viec.html"
                                               class="left_menu"><i class="fa fa-book"></i> Hướng dẫn cách làm việc</a>
                                        </div>
                                        <div class="bg_left_menu">
                                            <a href="<?php echo base_url(); ?>account/docs/32/video-huong-dan.html"
                                               class="left_menu"><i class="fa fa-video-camera"></i> Video hướng dẫn, tài
                                                liệu</a>
                                        </div>
                                    </div>
                                </li>

                                <?php if ($group_id != StaffStoreUser && $group_id != StaffUser) { ?>
                                    <li id="13">
                                        <a href="javascript:show_left_menu('share')" class="left_menu_title"
                                           id="share_title">Chia
                                            sẻ</a>

                                        <div class="left_menu_hidden" id="share_link">
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/sharelist"
                                                   class="left_menu"><i
                                                        class="fa fa-list-ul"></i> Danh sách link cần chia sẻ</a>
                                            </div>
                                            <?php if ($group_id == BranchUser) { ?>
                                                <div class="bg_left_menu">
                                                    <a href="<?php echo base_url(); ?>account/share-land"
                                                       class="left_menu"><i
                                                            class="fa fa-list-ul"></i> Tờ rơi điện tử</a>
                                                </div>
                                            <?php } ?>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/share" class="left_menu"><i
                                                        class="fa fa-line-chart"></i> Thống kê chia sẻ link</a>
                                            </div>
                                            <div class="bg_left_menu">
                                                <a href="<?php echo base_url(); ?>account/share/view-list"
                                                   class="left_menu"><i
                                                        class="fa fa-line-chart"></i> Thống kê lượt xem sản phẩm</a>
                                            </div>
                                        </div>

                                    </li>
                                <?php } ?>
                            <?php } ?>

                            <li id="14">
                                <a href="<?php echo base_url(); ?>logout" class="left_menu_title" id="logout_title">Thoát</a>
                            </li>
                        </ul>
                    </div>
                </div>

            </td>
        </tr>
        <?php break; } ?>
    <?php } ?>

<script>
    function replyInvite(reply,uid,grt) {
        $.ajax({
            type: "POST",
            url: "/grouptrade/repinvite",
            data: {reply:reply, uid:uid, grt:grt},
            success: function (res) {
                console.log(res);
                if(res == 0){
                    $('#invite_'+grt).css("display", "none");
                    $('#note_invite').css("display", "none");
                    $('#note_invite1').css("display", "none");
                    $('#checkModal').modal('hide');
                } else {
                    $('#invite_'+grt).css("display", "none");
                    $('#note_invite').text(res);
                    $('#note_invite1').text(res);
                }
            },
            error: function () {
                alert('Có lỗi xảy ra. Vui lòng thử lại!');
            }
        });
    }
</script>
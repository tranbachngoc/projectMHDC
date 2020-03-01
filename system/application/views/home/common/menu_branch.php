 <?php
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $protocol1 = "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    $this->db->flush_cache();
    $shop_info_menu = $this->shop_model->get("sho_link, sho_id, sho_name, domain", "sho_user = " . (int)$this->session->userdata('sessionUser'));
    $link_abc = $protocol . $shoplink . '.' . $domainName;
    $my_link_shop = $protocol . $shop_info_menu->sho_link . '.' . $domainName . '/shop';
    if ($shop_info_menu->domain != "") {
        $my_link_shop = $protocol1 . $shop_info_menu->domain . '/shop';
        $link_aff_shop = $protocol . $shop_info_menu->domain .'.'. domain_site .'/affiliate/product';
    }else {
        $link_aff_shop = $protocol . $shop_info_menu->sho_link .'.'. domain_site .'/affiliate/product';
    }

    ?>
    <?php
        $aMenuBranch = array(
            'thongtinchung'         => array(
                'name'      => 'THÔNG TIN CHUNG',
                'submenu'   => array(
                    array(
                        'name'  => 'Thông tin cá nhân',
                        'icon'  => '<i class="fa fa-info-circle"></i>',
                        'link'  => 'account/edit'
                    ),
                    array(
                        'name'  => 'Cập nhật hồ sơ',
                        'icon'  => '<i class="fa fa-pencil-square-o"></i>',
                        'link'  => 'account/updateprofile'
                    ),
                    array(
                        'name'  => 'Đổi mật khẩu',
                        'icon'  => '<i class="fa fa-key"></i>',
                        'link'  => 'account/changepassword'
                    ),
                    array(
                        'name'  => 'Tên miền cá nhân',
                        'icon'  => '<i class="fa fa-globe" aria-hidden="true"></i>',
                        'link'  => 'account/personaldomain'
                    ),
                )
            ),
            'nguoimuahang'         => array(
                'name'      => 'NGƯỜI MUA HÀNG',
                'submenu'   => array(
                    array(
                        'name'  => 'Sản phẩm đã mua',
                        'icon'  => '<i class="fa fa-cubes fa-fw"></i>',
                        'link'  => 'account/user_order/product'
                    ),
                    array(
                        'name'  => 'Coupon đã mua',
                        'icon'  => '<i class="fa  fa-tags fa-fw"></i>',
                        'link'  => 'account/user_order/coupon'
                    ),
                )
            ),
            'congtacvien'         => array(
                'name'      => 'CÔNG TÁC VIÊN',
                'submenu'   => array(
                    'xemgianhang'           =>array(
                        'name'      => 'Xem gian hàng',
                        'icon'      => '<i class="fa fa-eye" aria-hidden="true"></i>',
                        'link'      => (isset($link_aff_shop)) ? $link_aff_shop : '',
                        'linkdomain'=> true,
                    ),
                    'quanlykhohang'         => array(
                        'name'      => 'Quản lý kho hàng',
                        'type'      => 'parent',
                        'submenu'   => array(
                            array(
                                'name'  => 'Tìm nguồn hàng về kho',
                                'icon'  => '<i class="fa fa-search fa-fw"></i>',
                                'link'  => 'account/affiliate/pickup/product'
                            ),
                            array(
                                'name'  => 'Sản phẩm đã chọn',
                                'icon'  => '<i class="fa fa-list-ul fa-fw"></i>',
                                'link'  => 'account/affiliate/depot/product'
                            ),
                            array(
                                'name'  => 'Coupon đã chọn',
                                'icon'  => '<i class="fa fa-list-ul fa-fw"></i>',
                                'link'  => 'account/affiliate/depot/coupon'
                            ),
                        )
                    ),
                    'quanlydonhang'         => array(
                        'name'      => 'Quản lý đơn hàng',
                        'type'      => 'parent',
                        'submenu'   => array(
                            array(
                                'name'  => 'Đơn hàng sản phẩm',
                                'icon'  => '<i class="fa fa-list-ul fa-fw"></i>',
                                'link'  => 'account/affiliate/order/product'
                            ),
                            array(
                                'name'  => 'Đơn hàng coupon',
                                'icon'  => '<i class="fa fa-list-ul fa-fw"></i>',
                                'link'  => 'account/affiliate/order/coupon'
                            ),
                        )
                    ),
                    'quanlydonhang'         => array(
                        'name'      => 'Quản lý đơn hàng',
                        'type'      => 'parent',
                        'submenu'   => array(
                            array(
                                'name'  => 'Đơn hàng sản phẩm',
                                'icon'  => '<i class="fa fa-list-ul fa-fw"></i>',
                                'link'  => 'account/affiliate/order/product'
                            ),
                            array(
                                'name'  => 'Đơn hàng coupon',
                                'icon'  => '<i class="fa fa-list-ul fa-fw"></i>',
                                'link'  => 'account/affiliate/order/coupon'
                            ),
                        )
                    ),
                    'thongkekinhdoanh'         => array(
                        'name'      => 'Thống kê kinh doanh',
                        'type'      => 'parent',
                        'submenu'   => array(
                            array(
                                'name'  => 'Thống kê chung',
                                'icon'  => '<i class="fa fa-line-chart fa-fw"></i>',
                                'link'  => 'account/affiliate/shop_statistic'
                            ),
                        )
                    ),
                    'tinhtoanthunhap'         => array(
                        'name'      => 'Tính toán thu nhập',
                        'type'      => 'parent',
                        'submenu'   => array(
                            array(
                                'name'  => 'Thu nhập tạm tính',
                                'icon'  => '<i class="fa fa-money fa-fw"></i>',
                                'link'  => 'account/affiliate/shop_temp_income'
                            ),
                            array(
                                'name'  => 'Thu nhập thực',
                                'icon'  => '<i class="fa fa-money fa-fw"></i>',
                                'link'  => 'account/affiliate/shop_income'
                            ),
                        )
                    ),
                )
            ),
            'nguoibanhang'         => array(
                'name'      => 'NGƯỜI BÁN HÀNG',
                'submenu'   => array(
                        'xemgianhang'           =>array(
                            'name'      => 'Xem gian hàng',
                            'icon'      => '<i class="fa fa-eye" aria-hidden="true"></i>',
                            'link'      => (isset($my_link_shop)) ? $my_link_shop : '',
                            'linkdomain'=> true,
                        ),
                        'quanlytin'             => array(
                            'name'      => 'Quản lý tin tức',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Đăng tin',
                                    'icon'  => '<i class="fa fa-plus-circle"></i>',
                                    'link'  => 'account/news/add'
                                ),
                                array(
                                    'name'  => 'Tin đã đăng',
                                    'icon'  => '<i class="fa fa-list-ul"></i>',
                                    'link'  => 'account/news'
                                ),
                                array(
                                    'name'  => 'Bình luận của khách hàng',
                                    'icon'  => '<i class="fa fa-comment"></i>',
                                    'link'  => 'account/comments'
                                ),
                            )
                        ),
                        'quanlysp'              => array(
                            'name'      => 'Quản lý sản phẩm',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Quản lý sản phẩm',
                                    'icon'  => '<i class="fa fa-shopping-bag"></i>',
                                    'link'  => 'account/product/product'
                                ),
                                array(
                                    'name'  => 'Sản phẩm từ gian hàng',
                                    'icon'  => '<i class="fa fa-shopping-basket"></i>',
                                    'link'  => 'account/profromshop'
                                ),
                                array(
                                    'name'  => 'Đăng sản phẩm mới',
                                    'icon'  => '<i class="fa fa-plus-circle"></i>',
                                    'link'  => 'account/product/product/post'
                                ),
                                array(
                                    'name'  => 'Sản phẩm ưa thích',
                                    'icon'  => '<i class="fa fa-thumbs-up"></i>',
                                    'link'  => 'account/product/product/favorite'
                                ),
                            )
                        ),
                        'quanlycoupon'          => array(
                            'name'      => 'Quản lý coupon',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Danh sách coupon',
                                    'icon'  => '<i class="fa fa-shopping-bag"></i>',
                                    'link'  => 'account/product/coupon'
                                ),
                                array(
                                    'name'  => 'Coupon từ gian hàng',
                                    'icon'  => '<i class="fa fa-shopping-basket"></i>',
                                    'link'  => 'account/coufromshop'
                                ),
                                array(
                                    'name'  => 'Đăng coupon mới',
                                    'icon'  => '<i class="fa fa-plus-circle"></i>',
                                    'link'  => 'account/product/coupon/post'
                                ),
                                array(
                                    'name'  => 'Phiếu mua hàng điện tử yêu thích',
                                    'icon'  => '<i class="fa fa-thumbs-up"></i>',
                                    'link'  => 'account/product/coupon/favorite'
                                ),
                            )
                        ),
                        'quanlygianhang'        => array(
                            'name'      => 'Quản lý gian hàng chi nhánh',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Cập nhật thông tin gian hàng',
                                    'icon'  => '<i class="fa fa-pencil-square-o"></i>',
                                    'link'  => 'account/shop'
                                ),
                                array(
                                    'name'  => 'Giới thiệu về Gian hàng',
                                    'icon'  => '<i class="fa fa-info-circle"></i>',
                                    'link'  => 'account/shop/intro'
                                ),
                                array(
                                    'name'  => 'Chính sách gian hàng',
                                    'icon'  => '<i class="fa fa-cogs"></i>',
                                    'link'  => 'account/shop/shoprule'
                                ),
                                array(
                                    'name'  => 'Cấu hình domain',
                                    'icon'  => '<i class="fa fa-cogs"></i>',
                                    'link'  => 'account/shop/domain'
                                ),
                            )
                        ),
                        'congtacvienonline'         => array(
                            'name'      => 'Cộng tác viên online',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Giới thiệu mở Cộng tác viên online',
                                    'icon'  => '<i class="fa fa-files-o"></i>',
                                    'link'  => 'account/tree/inviteaf'
                                ),
                                array(
                                    'name'  => 'Cộng tác viên online đã giới thiệu',
                                    'icon'  => '<i class="fa fa-user"></i>',
                                    'link'  => 'account/listaffiliate'
                                ),
                                // array(
                                //     'name'  => 'Cộng tác viên online trực thuộc hệ thống dưới',
                                //     'icon'  => '<i class="fa fa-user"></i>',
                                //     'link'  => 'account/allaffiliateunder'
                                // ),
                            )
                        ),
                        'nhanvien'              => array(
                            'name'      => 'Nhân viên',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Thêm Nhân viên',
                                    'icon'  => '<i class="fa fa-plus-circle"></i>',
                                    'link'  => 'account/staffs/add'
                                ),
                                array(
                                    'name'  => 'Danh sách Nhân viên',
                                    'icon'  => '<i class="fa fa-list-ul"></i>',
                                    'link'  => 'account/staffs/all'
                                ),
                                array(
                                    'name'  => 'Thống kê cộng tác viên',
                                    'icon'  => '<i class="fa fa-line-chart"></i>',
                                    'link'  => 'account/statisticalemployee'
                                ),
                            )
                        ),
                        'quanlynhom'            => array(
                            'name'      => 'Quản lý nhóm',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Danh sách nhóm tham gia',
                                    'icon'  => '<i class="fa fa-list"></i>',
                                    'link'  => 'account/group/joinchannel'
                                ),
                            )
                        ),
                        'quanlydonhang'         => array(
                            'name'      => 'Quản lý đơn hàng',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Đơn hàng SP Gian hàng',
                                    'icon'  => '<i class="fa fa-shopping-cart"></i>',
                                    'link'  => 'account/order/product'
                                ),
                                array(
                                    'name'  => 'Đơn hàng Coupon Gian hàng',
                                    'icon'  => '<i class="fa fa-tags"></i>',
                                    'link'  => 'account/order/coupon'
                                ),
                                array(
                                    'name'  => 'Khách hàng từ Gian hàng',
                                    'icon'  => '<i class="fa fa-users"></i>',
                                    'link'  => 'account/customer'
                                ),
                            )
                        ),
                        'yeucaukhieunai'        => array(
                            'name'      => 'Yêu cầu khiếu nại',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Yêu cầu khiếu nại',
                                    'icon'  => '<i class="fa fa-arrows" aria-hidden="true"></i>',
                                    'link'  => 'account/complaintsOrders'
                                ),
                                array(
                                    'name'  => 'Khiếu nại đã giải quyết',
                                    'icon'  => '<i class="fa fa-arrows" aria-hidden="true"></i>',
                                    'link'  => 'account/solvedOrders'
                                ),
                            )
                        ),
                        'thongkehethong'        => array(
                            'name'      => 'Thống kê hệ thống',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Thống kê chung',
                                    'icon'  => '<i class="fa fa-line-chart"></i>',
                                    'link'  => 'account/statistic'
                                ),
                                array(
                                    'name'  => 'Thống kê thu nhập',
                                    'icon'  => '<i class="fa fa-line-chart"></i>',
                                    'link'  => 'account/statisticIncome'
                                ),
                                array(
                                    'name'  => 'Thống kê Cộng tác viên',
                                    'icon'  => '<i class="fa fa-line-chart"></i>',
                                    'link'  => 'account/statisticlistaffiliate'
                                ),
                                array(
                                    'name'  => 'Thống kê theo sản phẩm',
                                    'icon'  => '<i class="fa fa-line-chart"></i>',
                                    'link'  => 'account/statisticproduct'
                                ),
                            )
                        ),
                        'thunhap'               => array(
                            'name'      => 'Thu nhập',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Thu nhập Chi Nhánh',
                                    'icon'  => '<i class="fa fa-percent"></i>',
                                    'link'  => 'account/income/user'
                                ),
                                array(
                                    'name'  => 'Thu nhập tạm tính',
                                    'icon'  => '<i class="fa fa-percent"></i>',
                                    'link'  => 'account/income/provisional_store'
                                ),
                                array(
                                    'name'  => 'Cập nhật tài khoản ngân hàng',
                                    'icon'  => '<i class="fa fa-university"></i>',
                                    'link'  => 'account/bank'
                                ),
                            )
                        ),
                        'congcumarketing'     => array(
                            'name'      => 'Công cụ Marketing',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Email Marketing',
                                    'icon'  => '<i class="fa fa-envelope"></i>',
                                    'link'  => 'account/tool-marketing/email-marketing'
                                ),
                                array(
                                    'name'  => 'Tờ rơi điện tử',
                                    'icon'  => '<i class="fa fa-file-o"></i>',
                                    'link'  => 'account/landing_page/lists'
                                ),
                            )
                        ),
                        'quanlychitiet'     => array(
                            'name'      => 'Quản lý chi tiêu',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Nạp tiền vào ví điện tử',
                                    'icon'  => '<i class="fa fa-money fa-fw"></i>',
                                    'link'  => 'account/addWallet'
                                ),
                            )
                        ),
                        'tailieu'               => array(
                            'name'      => 'Tài liệu',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Chính sách thành viên',
                                    'icon'  => '<i class="fa fa-user"></i>',
                                    'link'  => 'account/docs/30/chinh-sach-thanh-vien.html'
                                ),
                                array(
                                    'name'  => 'Chính sách hoa hồng',
                                    'icon'  => '<i class="fa fa-percent"></i>',
                                    'link'  => 'account/docs/33/chinh-sach-hoa-hong.html'
                                ),
                                array(
                                    'name'  => 'Hướng dẫn cách làm việc',
                                    'icon'  => '<i class="fa fa-book"></i>',
                                    'link'  => 'account/docs/31/huong-dan-cach-lam-viec.html'
                                ),
                                array(
                                    'name'  => 'Video hướng dẫn, tài liệu',
                                    'icon'  => '<i class="fa fa-video-camera"></i>',
                                    'link'  => 'account/docs/32/video-huong-dan.html'
                                ),
                            )
                        ),
                        'chiase'                => array(
                            'name'      => 'Chia sẻ',
                            'type'      => 'parent',
                            'submenu'   => array(
                                array(
                                    'name'  => 'Danh sách link cần chia sẻ',
                                    'icon'  => '<i class="fa fa-list-ul"></i>',
                                    'link'  => 'account/sharelist'
                                ),
                                array(
                                    'name'  => 'Tờ rơi điện tử',
                                    'icon'  => '<i class="fa fa-list-ul"></i>',
                                    'link'  => 'account/share-land'
                                ),
                                array(
                                    'name'  => 'Thống kê chia sẻ link',
                                    'icon'  => '<i class="fa fa-line-chart"></i>',
                                    'link'  => 'account/share'
                                ),
                                array(
                                    'name'  => 'Thống kê lượt xem sản phẩm',
                                    'icon'  => '<i class="fa fa-line-chart"></i>',
                                    'link'  => 'account/share/view-list'
                                ),
                            )
                        )
                )
            ),
        );
    ?>
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <!-- Thông tin thành viên -->
        <?php if(!empty($aMenuBranch)) { ?>
            <?php foreach ($aMenuBranch as $key => $oMenu) { ?>
                <div class="panel panel-default panel-menu">
                    <div class="panel-heading" role="tab" id="heading_<?=$key?>">          
                        <a role="button" data-toggle="collapse" 
                       data-parent="#accordion" href="#collapse_<?=$key?>" 
                       ria-expanded="true" aria-controls="collapse_<?=$key?>">
                           <?php echo $oMenu['name']; ?>
                       </a>          
                    </div>
                    <div id="collapse_<?=$key?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_<?=$key?>">
                        <div class="panel-body">
                            <ul class="nav menuadmin">
                                <?php if(isset($oMenu['submenu']) && !empty($oMenu['submenu'])) { ?>
                                    <?php foreach ($oMenu['submenu'] as $key => $aSubMenu) { ?>
                                        <?php if(isset($aSubMenu['type']) && $aSubMenu['type'] == 'parent') : ?>
                                            <li role="presentation" class="">
                                                <a href="#menu">
                                                    <?php echo $aSubMenu['name']; ?>
                                                    <i class="fa fa-angle-down fa-fw pull-right"></i>
                                                </a>
                                                <ul class="nav">
                                                    <?php if(!empty($aSubMenu['submenu'])) : ?>
                                                        <?php foreach ($aSubMenu['submenu'] as $k => $aMenu) : ?>
                                                            <li role="presentation">
                                                                <a href="<?php echo base_url().$aMenu['link']; ?>">
                                                                    <?php echo $aMenu['icon']; ?>
                                                                    <?php echo $aMenu['name']; ?>
                                                                </a>
                                                            </li>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </ul>
                                            </li> 
                                        <?php else : ?>
                                            <li>
                                                <a role="presentation" href="<?php echo (isset($aSubMenu['linkdomain'])) ? $aSubMenu['link'] : base_url().$aSubMenu['link']; ?>">
                                                    <?php echo $aSubMenu['icon']; ?>
                                                    <?php echo $aSubMenu['name']; ?>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php } ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>

        <!-- Dịch vụ -->
        <?php if (serviceConfig == 1) { ?>
            <div class="panel panel-default panel-menu">
                <div class="panel-heading" role="tab" id="heading_dichvu">          
                    <a role="button" data-toggle="collapse" 
                   data-parent="#accordion" href="#collapse_dichvu" 
                   ria-expanded="true" aria-controls="collapse_dichvu">
                       Dịch vụ
                   </a>          
                </div>
                <div id="collapse_dichvu" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading_dichvu">
                    <div class="panel-body">
                        <ul class="nav menuadmin">
                            <li>
                                <a role="presentation" href="<?php echo base_url(); ?>account/product/service">
                                    <i class="fa fa-shopping-bag"></i>Dịch vụ
                                </a>
                            </li>
                            <li>
                                <a role="presentation" href="<?php echo base_url(); ?>product/product/service/post">
                                    <i class="fa fa-plus-circle"></i> Đăng Dịch vụ
                                </a>
                            </li>
                            <li>
                                <a role="presentation" href="<?php echo base_url(); ?>account/product/service/favorite" >
                                    <i class="fa fa-thumbs-up"></i> Dịch vụ yêu thích
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>

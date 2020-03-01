<?php
$group_id = $this->session->userdata('sessionGroup');

if ($this->session->userdata('sessionUser')) {
    if ($this->session->userdata('sessionGroup') == 3 || $this->session->userdata('sessionGroup') == 14 || $this->session->userdata('sessionGroup') == 2) {
	$shop = $this->shop_model->get("sho_link,domain", "sho_user = " . (int) $this->session->userdata('sessionUser'));
    } elseif ($this->session->userdata('sessionGroup') == 11 || $this->session->userdata('sessionGroup') == 15) {
	$parentUser = $this->user_model->get("parent_id", "use_id = " . $this->session->userdata('sessionUser'));
	$shop = $this->shop_model->get("sho_link,domain", "sho_user = " . $parentUser->parent_id);
    } else {
	//redirect($this->mainURL . 'account');
    }

    if ($shop) {
	if ($shop->domain) {
	    $linktoshop = "http://" . $shop->domain;
	} else {
	    $linktoshop = "https://" . $shop->sho_link . '.' . domain_site;
	}
    }
}
?>
<ul class="nav nav-child-1">
    <?php if ($this->session->userdata('sessionUser')) { ?>
	<li>
	    <a href="<?php echo $linktoshop ?>">
		<img src="/templates/home/icons/black/icon-user.png" alt="icon-user" style="height: 20px;"/> &nbsp; Chào
		<strong><?php echo $this->session->userdata('sessionUsername') ?></strong>
	    </a>
	</li>
	<li>
	    <a href="<?php echo $linktoshop . '/shop' ?>">
		<img src="/templates/home/icons/black/icon-store.png" alt="icon-store" style="height: 20px;"/> &nbsp; Đến gian hàng</strong>
	    </a>
	</li>
	<li class="parent">
	    <a href="#thong-tin-thanh-vien" id="profile_title">
		<img src="/templates/home/icons/menus/icon-10.png" alt="icon-10" style="height: 20px;"/> &nbsp; Thông tin thành viên
	    </a>
	    <ul class="nav nav-child-2">
		<li><a href="/account/edit"><i class="fa fa-info-circle fa-fw"></i> &nbsp; Thông tin cá nhân </a></li>
		<li><a href="/account/updateprofile"><i class="fa fa-edit fa-fw"></i> &nbsp; Cập nhật danh thiếp </a></li>
		<li><a href="/account/changepassword"><i class="fa fa-key fa-fw"></i> &nbsp; Đổi mật khẩu </a></li>
	    </ul>
	</li>

    <!-- Menu Chi nhanh -->
	<?php if ($group_id == AffiliateStoreUser || $group_id == StaffStoreUser) { ?>
	    <li class="parent">
		<a href="#chi-nhanh">
		    <img src="/templates/home/icons/menus/icon-04.png" alt="" style="height: 20px;"> &nbsp;
		    <?php echo $this->lang->line('sub_comany'); ?></a>
		<ul class="nav nav-child-2">
		    <li><a href="/account/addbranch"><i
				class="fa fa-plus-circle fa-fw"></i> &nbsp;<?php echo 'Thêm Chi Nhánh'; ?>
			</a></li>
		    <li><a href="/account/listbranch"><i
				class="fa fa-list-ol fa-fw"></i>
			    &nbsp;<?php echo $this->lang->line('list_sub_comany'); ?> </a></li>
		    <?php if ($group_id != StaffStoreUser) { ?>
	    	    <li><a href="/branch/prowaitingapprove"><i
	    			class="fa fa-cubes fa-fw"></i>
	    		    &nbsp;<?php echo $this->lang->line('product_waiting'); ?> </a></li>
	    	    <li><a href="/branch/flyerwaitapprove"><i
	    			class="fa fa-file-text-o fa-fw"></i>
	    		    &nbsp;<?php echo $this->lang->line('landing_page_waiting'); ?> </a></li>
	    	    <li><a href="/branch/newswaitapprove"><i
	    			class="fa fa-newspaper-o fa-fw"></i> &nbsp;Tin tức chờ duyệt</a></li>
			<?php } ?>
		</ul>
	    </li>
	<?php } ?>

    <!-- End menu Chi Nhanh -->
    <li class="parent">
	    <a href="#thong-bao-tin-nhan" id="contact_title">
		<img src="/templates/home/icons/menus/icon-03.png" alt="" style="height: 20px;"/> &nbsp; Thông báo và tin nhắn
	    </a>
	    <ul class="nav nav-child-2">
			<li><a href="/account/notify"><i class="fa fa-bullhorn fa-fw"></i>
				&nbsp; <?php echo $this->lang->line('notify_account_menu'); ?> </a></li>
			<li><a href="/account/contact/send"><i
				    class="fa fa-pencil-square-o fa-fw"></i> &nbsp; Soạn thư</a></li>
			<li><a href="/account/contact"><i class="fa fa-inbox fa-fw"></i>
				&nbsp; Thư đã nhận</a></li>
			<li><a href="/account/contact/outbox"><i
				    class="fa fa-paper-plane fa-fw"></i> &nbsp; Thư đã gửi</a></li>
	    </ul>
    </li>

	<?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser || $group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser || $group_id == StaffUser || $group_id == StaffStoreUser) { ?>

	    <li class="parent">
		<a href="#quan-ly-nhan-vien" id="task_title">
		    <img src="/templates/home/icons/menus/icon-05.png" alt="" style="height: 20px;"/> &nbsp; 
		    <?php
		    if ($group_id != StaffStoreUser && $group_id != StaffUser) {
			echo 'Quản lý nhân viên';
		    } else
			echo 'Tình trạng công việc';
		    ?>
		</a>
		<ul class="nav nav-child-2">
		    <?php if ($group_id != StaffUser && $group_id != StaffStoreUser) { ?>
			<?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser) { ?>			    
	    	    <li><a href="/account/staffs/add"> <i
	    			class="fa fa-plus-circle fa-fw"></i> &nbsp; Thêm Nhân viên</a>
	    	    </li>
	    	    <li><a href="/account/staffs/all"><i
	    			class="fa fa-list-ul fa-fw"></i> &nbsp; Danh sách Nhân viên</a>
	    	    </li>
			    <?php if ($group_id == AffiliateStoreUser) { ?>
		    	    <li>
		    		<a href="/account/statisticalbran"> <i
		    			class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê mở Chi nhánh</a>
		    	    </li>
			    <?php } ?>
			    <li>
				<a href="/account/statisticalemployee"> <i
					class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê mở Cộng tác viên
				    online</a>
			    </li>
			<?php } ?>
			<?php if ($group_id != BranchUser && $group_id != AffiliateStoreUser && $group_id != StaffStoreUser && $group_id != AffiliateUser) { ?>
			    <li>
				<a href="/account/viewtasks/month/<?php echo date('m'); ?>">
				    <i class="fa fa-tasks fa-fw"></i> &nbsp; Bảng công việc từ Cấp trên</a>
			    </li>
			<?php } ?>
			<?php if ($group_id != AffiliateStoreUser && $group_id != BranchUser) { ?>
			    <li><a href="/account/treetaskuser"><i
					class="fa fa-share fa-fw"></i> &nbsp; Phân công cho Cấp dưới</a>
			    </li>
			    <li><a href="/account/treetask/today"><i
					class="fa fa-wifi fa-fw"></i> &nbsp; Tình trạng công việc Cấp
				    dưới</a></li>
			<?php } ?>
		    <?php } else { ?>
	    	    <li>
	    		<a href="/account/viewtasks/month/<?php echo date('m'); ?>"><i
	    			class="fa fa-sort-amount-desc fa-fw"></i> Phân công từ Gian hàng</a>
	    	    </li>
		    <?php } ?>
		</ul>
	    </li>
	<?php } ?>

	<?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser) { ?>
	    <li class="parent">
		<a href="#tin-tuc" id="news_title">
		    <img src="/templates/home/icons/menus/icon-06.png" alt="" style="height: 20px;"/> &nbsp;
		    Tin tức
		</a>
		<ul class="nav nav-child-2">
		    <li><a href="/account/news/add"><i
				class="fa fa-plus-circle fa-fw"></i> &nbsp;Đăng tin</a></li>
		    <li><a href="/account/news"><i class="fa fa-list-ul fa-fw"></i>
			    &nbsp;Tin đã đăng</a></li>
		    <li><a href="/account/comments"><i
				class="fa fa-comment fa-fw"></i> &nbsp;Bình luận của Khách hàng</a></li>
		</ul>
	    </li>
	<?php } ?>

	<?php if ($group_id >= AffiliateUser) { ?>
	    <li class="parent">
		
		<a href="#dai-ly-ban-le" id="affiliate_title">
		    <img src="/templates/home/icons/menus/icon-04.png" alt="" style="height: 20px;"/> &nbsp;
		    <?php
		    if ($group_id == AffiliateUser) {
			echo "Kho hàng ";
		    }
		    ?>Cộng tác viên online</a>
		
		<ul class="nav nav-child-2">
		    <?php if ($group_id == AffiliateUser) { ?>
	    	    <li><a href="/account/affiliate/products"><i
	    			class="fa fa-search-plus fa-fw"></i> &nbsp;Chọn sản phẩm để bán online</a>
	    	    </li>
	    	    <li><a href="/account/affiliate/myproducts"><i
	    			class="fa fa-shopping-bag fa-fw"></i> &nbsp;Sản phẩm đã chọn bán</a>
	    	    </li>
	    	    <li><a href="/account/affiliate/pressproducts"><i
	    			class="fa fa-shopping-bag fa-fw"></i> &nbsp;Sản phẩm ký gửi hàng Online</a>
	    	    </li>
		    <?php } ?>
		    <?php if ($group_id > AffiliateUser) { ?>
	    	    <li><a href="/account/tree/inviteaf"><i
	    			class="fa fa-files-o fa-fw"></i> &nbsp;Giới thiệu mở Cộng tác viên
	    		    online</a></li>
	    	    <li><a href="/account/listaffiliate"><i
	    			class="fa fa-user fa-fw"></i> &nbsp;Cộng tác viên online đã giới thiệu</a>
	    	    </li>

			<?php if ($group_id != StaffUser) { ?>
			    <li><a href="/account/allaffiliateunder"><i
					class="fa fa-user fa-fw"></i> &nbsp;Cộng tác viên online
					<?php
					if ($group_id == AffiliateStoreUser) {
					    echo 'toàn công ty';
					} else
					    echo 'trực thuộc hệ thống dưới';
					?>
				</a></li>
			<?php } ?>
		    <?php } ?>
		    <?php if ($group_id == AffiliateStoreUser) { ?>
	    	    <li>
	    		<a href="/account/affiliate/configaffiliate"><i
	    			class="fa fa-cogs fa-fw"></i> Thưởng thêm Cộng tác viên online</a>
	    	    </li>
		    <?php } ?>
		</ul>
	    </li>
	<?php } ?>

	<?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser) { ?>

	    <li class="parent" id="12">                    
		<a href="javascript:show_left_menu('grouptrade')" class="left_menu_title" id="grouptrades_title">
		    <img src="/templates/home/icons/menus/icon-10.png" alt="" style="height: 20px;">
		    &nbsp; Quản trị nhóm 
		    <?php if ($to_invite > 0) { ?>
	    	    <span class="badge pull-right" id="note_invite" style="background-color: #ff0000; display: inline-block; padding: 6px 12px;" data-toggle="modal" data-target="#checkModal" title="Click vào đây để chấp nhận">+ <?php echo $to_invite; ?> Lời mời</span> 
		    <?php } ?>
		</a>

		<ul class="nav nav-child-2">
		    <?php if ($group_id == AffiliateStoreUser) { ?>
	    	    <li><a href="<?php echo base_url() ?>account/group/mychannel" class="left_menu"><i class="fa fa-list"></i> &nbsp; Thông tin cá nhânDanh sách nhóm của tôi</a></li>
		    <?php } ?>
		    <?php //if ((int) $this->session->userdata('sessionGrt') > 0) { ?>
		    <li><a href="<?php echo base_url() ?>account/group/joinchannel" class="left_menu"><i class="fa fa-list"></i> &nbsp; Danh sách nhóm tham gia</a></li>
		    <?php //} else { ?>
		    <?php if ($group_id == AffiliateStoreUser) { ?>
	    	    <li>
	    		<a href="<?php echo base_url(); ?>grouptrade/add" class="left_menu"><i class="fa fa-plus-circle"></i> &nbsp; Tạo group thương mại</a>
	    	    </li>
		    <?php } ?>
		    <?php //} ?>
		</ul>        
	    </li>
	<?php } ?>

	<?php if ($group_id == 1) { ?>
	    <li class="parent">
		<a href="#dai-ly-ban-le" id="affiliate_title">
		    <img src="/templates/home/icons/menus/icon-04.png" alt="" style="height: 20px;"/> &nbsp;
		    Cộng tác viên
		</a>
		<ul class="nav nav-child-2">
		    <li><a href="/account/affiliate/upgrade"><i
				class="fa fa-search-plus fa-fw"></i> &nbsp;Nâng cấp lên Cộng tác viên
			</a></li>
		</ul>
	    </li>
	<?php } ?>

	<?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser) { ?>
	    <li class="parent">
		<a href="#san-pham" id="product_title">
		    <img src="/templates/home/icons/menus/icon-08.png" alt="" style="height: 20px;"/> &nbsp; 
		    <?php echo $this->lang->line('product_account_menu'); ?>
		</a>
		<ul class="nav">
		    <li><a href="/account/product/product"><i
				class="fa fa-shopping-bag fa-fw"></i>
			    &nbsp; <?php echo $this->lang->line('product_account_menu'); ?> </a></li>
		    <?php if ($group_id == BranchUser) { ?>
	    	    <li><a href="/account/profromshop"><i
	    			class="fa fa-shopping-basket fa-fw"></i>
	    		    &nbsp; <?php echo $this->lang->line('product_from_shop'); ?> </a></li>
		    <?php } ?>
		    <li><a href="/account/product/product/post"><i
				class="fa fa-plus-circle fa-fw"></i> &nbsp; Đăng sản phẩm</a></li>
		    <li><a href="/account/product/product/favorite"><i
				class="fa fa-thumbs-up fa-fw"></i>
			    &nbsp; <?php echo $this->lang->line('favorite_product_account_menu'); ?> </a>
		    </li>
		</ul>
	    </li>
	    <?php if (serviceConfig == 1) { ?>
	        <li class="parent">
	    	<a href="#dich-vu" id="product_service_title">
	    	    <img src="/templates/home/icons/menus/icon-08.png" alt="" style="height: 20px;"/>
	    	    &nbsp; Dịch vụ
	    	</a>
	    	<ul class="nav nav-child-2">
	    	    <li><a href="/account/product/service"><i
	    			class="fa fa-shopping-bag fa-fw"></i> &nbsp; Dịch vụ </a></li>
	    	    <li><a href="/product/product/service/post"><i
	    			class="fa fa-plus-circle fa-fw"></i> &nbsp; Đăng Dịch vụ</a></li>
	    	    <li><a href="/account/product/service/favorite"><i
	    			class="fa fa-thumbs-up fa-fw"></i> &nbsp; Dịch vụ yêu thích </a></li>
	    	</ul>
	        </li>
	    <?php } ?>
	    <li class="parent">
		<a href="#giam-gia" id="product_coupon_title">
		    <img src="/templates/home/icons/menus/icon-09.png" alt="" style="height: 20px;"/> &nbsp; Coupon
		</a>
		<ul class="nav nav-child-2">
		    <li><a href="/account/product/coupon"><i
				class="fa fa-shopping-bag fa-fw"></i> &nbsp; Coupon </a></li>
			<?php if ($group_id == BranchUser) { ?>
	    	    <li><a href="/account/coufromshop"><i
	    			class="fa fa-shopping-basket fa-fw"></i>
	    		    &nbsp; <?php echo $this->lang->line('coupon_from_shop'); ?> </a></li>
		    <?php } ?>
		    <li><a href="/account/product/coupon/post"><i
				class="fa fa-plus-circle fa-fw"></i> &nbsp; Đăng Coupon</a></li>
		    <li><a href="/account/product/coupon/favorite"><i
				class="fa fa-thumbs-up fa-fw"></i> &nbsp; Coupon yêu thích </a></li>
		</ul>
	    </li>
	<?php } ?>

	<?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser || $group_id == AffiliateUser || $group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser) { ?>
	    <li class="parent">
		<a href="#gian-hang" id="shop_title">
		    <img src="/templates/home/icons/menus/icon-10.png" alt="" style="height: 20px;"/> &nbsp; Gian hàng 
			<?php if ($group_id == AffiliateUser) { ?> Cộng tác viên online<?php } elseif ($group_id == BranchUser) { ?> Chi nhánh <?php } ?>
		</a>
		<ul class="nav nav-child-2">
		    <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser || $group_id == AffiliateUser) { ?>
	    	    <li>
	    		<a href="/account/shop" class="left_menu"><i
	    			class="fa fa-pencil-square-o"></i> &nbsp; Cập nhật thông tin gian hàng
	    		</a>
	    	    </li>

			<?php if ($group_id != AffiliateUser && $group_id != BranchUser) { ?>
			    <li>
				<a href="/account/supplier" class="left_menu"><i
					class="fa fa-search"></i> &nbsp; Tìm nhà sản xuất - bán sỉ</a>
			    </li>
			<?php } ?>

	    	    <li>
	    		<a href="/account/shop/intro" class="left_menu"><i
	    			class="fa fa-info-circle"></i> &nbsp; Giới thiệu về Gian hàng
	    		</a>
	    	    </li>

			<?php if ($group_id != AffiliateUser) { ?>
			    <li>
				<a href="/account/shop/shoprule"
				   class="left_menu"><i
					class="fa fa-cogs"></i> &nbsp; <?php echo $this->lang->line('edit_shop_account_shop_rule_menu'); ?>
				</a>
			    </li>
			    <li>
				<a href="/account/shop/warranty"
				   class="left_menu"><i
					class="fa fa-wrench"></i> &nbsp; <?php echo $this->lang->line('edit_shop_account_warranty_menu'); ?>
				</a>
			    </li>
			<?php } ?>

		    <?php } ?>

		    <?php if ($group_id != AffiliateStoreUser && $group_id != BranchUser && $group_id != AffiliateUser) { ?>
	    	    <li>
	    		<a href="/account/tree/invite" class="left_menu"><i
	    			class="fa fa-info-circle"></i> &nbsp; Giới thiệu mở Gian hàng</a>
	    	    </li>
	    	    <li>
	    		<a href="/account/tree/store" class="left_menu"><i
	    			class="fa fa-info-circle"></i> &nbsp; Gian hàng đã giới thiệu</a>
	    	    </li>
		    <?php } ?>
		    <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser || $group_id == AffiliateUser) { ?>
	    	    <li>
	    		<a href="/account/shop/domain" class="left_menu"><i
	    			class="fa fa-cogs"></i> &nbsp; <?php echo $this->lang->line('edit_shop_domain'); ?>
	    		</a>
	    	    </li>
		    <?php } ?>
		</ul>
	    </li>
	<?php } ?>

	<?php if ($group_id == BranchUser || $group_id == NormalUser || $group_id == StaffUser || $group_id == AffiliateUser || $group_id == AffiliateStoreUser || $group_id == StaffStoreUser || in_array($group_id, array(Developer2User, Developer1User, Partner2User, Partner1User, CoreMemberUser, CoreAdminUser))) { ?>
	    <li class="parent">
		<a href="#don-hang" id="showcart_title">
		    <img src="/templates/home/icons/menus/icon-11.png" alt="" style="height: 20px;"/> &nbsp; 
		    <?php echo $this->lang->line('mua_hang_account_menu'); ?>
		</a>
		<ul class="nav nav-child-2">
		    <?php if ($group_id == NormalUser || $group_id == AffiliateStoreUser) { ?>
	    	    <li><a href="/account/user_order"><i
	    			class="fa fa-shopping-cart fa-fw"></i> &nbsp; <?php
				    if ($group_id == AffiliateStoreUser) {
					echo 'Đơn hàng mua sỉ';
				    } else {
					echo 'Đơn hàng cá nhân'; 
				    }
				    ?></a></li>
		    <?php } ?>
		    <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser) { ?>
	    	    <li><a href="/account/order/product"><i
	    			class="fa fa-shopping-cart fa-fw"></i> &nbsp; Đơn hàng SP Gian hàng</a>
	    	    </li>
	    	    <li><a href="/account/order/coupon"><i
	    			class="fa fa-tags fa-fw"></i> &nbsp; Đơn hàng Coupon Gian hàng</a></li>
			<?php } ?>
			<?php if ($group_id == AffiliateUser || $group_id == StaffStoreUser || $group_id == StaffUser) { ?>
			    <?php if ($group_id == AffiliateUser) { ?>
			    <li><a href="/account/user_order"><i
					class="fa fa-shopping-cart fa-fw"></i> &nbsp; Đơn hàng cá nhân</a>
			    </li>
			<?php } ?>
			<?php if ($group_id == StaffStoreUser) { ?>
			    <li><a href="/account/listbran_order"
				   class="left_menu"><i class="fa fa-shopping-cart"></i> Đơn hàng Chi Nhánh</a>
			    </li>
			<?php } ?>
	    	    <li><a href="/account/affiliate/orders"><i
	    			class="fa fa-shopping-cart fa-fw"></i> &nbsp; Đơn hàng Cộng tác viên
	    		    online</a></li>
		    <?php } ?>
		    <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser) { ?>
	    	    <li><a href="/account/customer"><i class="fa fa-users"></i>
	    		    &nbsp; Khách hàng từ Gian hàng</a></li>
		    <?php } ?>
		    <?php if (in_array($group_id, array(Developer2User, Developer1User, Partner2User, Partner1User, CoreMemberUser, CoreAdminUser))) { ?>
	    	    <li><a href="/account/order/viewbyparent"><i
	    			class="fa fa-shopping-cart fa-fw"></i> &nbsp; Đơn hàng cấp dưới</a></li>
	    	    <li><a href="/account/order/coupon"><i
	    			class="fa fa-shopping-cart fa-fw"></i> &nbsp; Đơn hàng coupon</a></li>
		    <?php } ?> </ul>
	    </li>
	<?php } ?>

	<?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser || $group_id == StaffStoreUser || $group_id == StaffUser) { ?>
	    <li class="parent">
		<a href="#yeu-cau-khieu-nai" id="requirements_change_delivery_title">
		    <img src="/templates/home/icons/menus/icon-12.png" alt="" style="height: 20px;"/> &nbsp; 
		    <?php echo $this->lang->line('requirements_change_delivery'); ?>
		</a>
		<ul class="nav nav-child-2">
		    <li><a href="/account/complaintsOrders"><i
				class="fa fa-arrows fa-fw"></i>
			    &nbsp; <?php echo $this->lang->line('requirements_change_delivery'); ?></a></li>
		    <li><a href="/account/solvedOrders"><i
				class="fa fa-arrows fa-fw"></i>
			    &nbsp; <?php echo $this->lang->line('requirements_solved_delivery'); ?></a></li>
		</ul>
	    </li>
	<?php } ?>

	<?php if (in_array($group_id, array(AffiliateUser, AffiliateStoreUser))) { ?>
	    <li class="parent">
		<a href="#nap-tien-tieu-tien" id="recharge_and_spend_money">
		    <img src="/templates/home/icons/menus/icon-13.png" alt="" style="height: 20px;"/> &nbsp; 
		    <?php echo $this->lang->line('recharge_and_spend_money'); ?>
		</a>
		<?php if (in_array($group_id, array(AffiliateUser, AffiliateStoreUser))) { ?>
	    	<ul class="nav nav-child-2">
	    	    <li>
	    		<a href="/account/addWallet"> <i
	    			class="fa fa-money fa-fw"></i>
	    		    &nbsp; <?php echo $this->lang->line('add_money_to_account'); ?> </a>
	    	    </li>
	    	    <li>
	    		<a href="/account/historyRecharge"> <i
	    			class="fa fa-history fa-fw"></i>
	    		    &nbsp; <?php echo $this->lang->line('history_recharge'); ?> </a>
	    	    </li>
	    	    <li>
	    		<a href="/account/spendingHistory"> <i
	    			class="fa fa-history fa-fw"></i>
	    		    &nbsp; <?php echo $this->lang->line('spending_history'); ?> </a>
	    	    </li>
	    	</ul>
		<?php } ?> </li>
	<?php } ?>

	<?php if ($group_id == AffiliateStoreUser || $group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser || $group_id == BranchUser || $group_id == AffiliateUser || $group_id == StaffUser || $group_id == StaffStoreUser) { ?>
	    <li class="parent">
		<a href="#thong-ke" id="statistic_title">
		    <img src="/templates/home/icons/menus/icon-14.png" alt="" style="height: 20px;"/> &nbsp; Thống kê hệ thống
		</a>
		<ul class="nav nav-child-2">
		    <?php if ($group_id != AffiliateUser && $group_id != StaffUser && $group_id != StaffStoreUser && $group_id != BranchUser && $group_id != AffiliateStoreUser) { ?>
	    	    <li><a href="/account/statisticlistshop"><i
	    			class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê gian hàng </a></li>
			<?php } ?>

		    <?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser || $group_id == AffiliateUser || $group_id == StaffUser || $group_id == StaffStoreUser) { ?>
	    	    <li><a href="/account/statistic"><i class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê chung</a></li>
		    <?php if ($group_id != StaffUser && $group_id != StaffStoreUser) { ?>
		    <li><a href="/account/statisticIncome"><i class="fa fa-line-chart fa-fw"></i> &nbsp; 
					<?php
					if ($group_id != StaffStoreUser) {
					    echo 'thu nhập';
					} else
					    echo 'doanh số';
					?>
				</a></li><?php } ?>
			<?php if ($group_id != AffiliateUser && $group_id != BranchUser && $group_id != StaffUser) { ?>
			    <li><a href="/account/statisticlistbran"><i class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê chi nhánh </a></li>
			    <?php } ?>
			    <?php if ($group_id != AffiliateUser && $group_id != StaffUser && $group_id != StaffStoreUser) { ?>
			    <li><a href="/account/salesemployee"><i class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê nhân viên </a></li>
			    <?php } ?>
			    <?php if ($group_id == AffiliateStoreUser || $group_id == StaffUser || $group_id == BranchUser || $group_id == StaffStoreUser) { ?>
			    <li><a href="/account/statisticlistaffiliate"><i class="fa fa-line-chart fa-fw"></i> &nbsp;  Thống kê Cộng tác viên </a>
			    </li>
			<?php } ?>
	    	    <li>
	    		<a href="/account/statisticproduct"> <i
	    			class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê theo sản phẩm</a>
	    	    </li>
		    <?php } ?>
		</ul>
	    </li>
	<?php } ?>

	<?php if ($group_id == AffiliateStoreUser) { ?>
	    <li class="parent">
		<a href="#thong-ke" id="statistic_title">
		    <img src="/templates/home/icons/menus/icon-14.png" alt="" style="height: 20px;"/> &nbsp; Thống kê gian hàng
		</a>
		<ul class="nav nav-child-2">
		    <li><a href="/account/statistic"><i
				class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê chung</a></li>
			<?php if ($group_id != StaffUser && $group_id != StaffStoreUser) { ?>
	    	    <li><a href="/account/statisticIncome_Store"><i
	    			class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê
				    <?php
				    if ($group_id != StaffStoreUser) {
					echo 'thu nhập';
				    } else
					echo 'doanh số';
				    ?>
	    		</a></li><?php } ?>
		    <?php if ($group_id != AffiliateUser && $group_id != StaffUser && $group_id != StaffStoreUser) { ?>
	    	    <li><a href="/account/salesemployee_Store"><i
	    			class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê nhân viên </a></li>
			<?php } ?>
			<?php if ($group_id == AffiliateStoreUser || $group_id == StaffUser || $group_id == BranchUser || $group_id == StaffStoreUser) { ?>
	    	    <li><a href="/account/statisticlistaffiliate_Store"><i
	    			class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê Cộng tác viên </a>
	    	    </li>
		    <?php } ?>
		    <li>
			<a href="/account/statisticproduct_Store"> <i
				class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê theo sản phẩm</a>
		    </li>
		</ul>
	    </li>
	<?php } ?>

	<?php if ($group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser) { ?>
	    <li class="parent">
		<a href="#hoa-hong" id="statistic_title">
		    <img src="/templates/home/icons/menus/icon-i.png" alt="" style="height: 20px;"/> &nbsp; Hoa hồng
		</a>
		<ul id="nav nav-child-2 commission_link">
		    <li><a href="/account/commission"><i class="fa fa-percent"></i>
			    &nbsp; Hoa hồng hệ thống</a></li>
		</ul>
	    </li>
	    <?php
	}

	if ($group_id != NormalUser && $group_id != StaffUser && $group_id != StaffStoreUser) {
	    ?>
	    <li class="parent">
		<a href="#thu-nhap" id="income_title">
		    <img src="/templates/home/icons/menus/icon-15.png" alt="" style="height: 20px;"/> &nbsp; Thu nhập
		</a>
		<ul class="nav">
		    <?php if ($group_id == AffiliateUser) { ?>
	    	    <li><a href="/account/income/user"><i
	    			class="fa fa-percent fa-fw"></i> &nbsp; Thu nhập Cộng tác viên
	    		    online</a></li>
	    	    <li><a href="/account/income/provisional"><i
	    			class="fa fa-percent fa-fw"></i> &nbsp; Thu nhập tạm tính</a></li>
			<?php } ?>
			<?php if ($group_id == AffiliateStoreUser) { ?>
	    	    <li><a href="/account/income/user"><i
	    			class="fa fa-percent fa-fw"></i> &nbsp; Thu nhập Gian hàng</a></li>
	    	    <li><a href="/account/income/provisional_store"><i
	    			class="fa fa-percent fa-fw"></i> &nbsp; Thu nhập tạm tính</a></li>
			<?php } ?>
			<?php if ($group_id != AffiliateUser && $group_id != AffiliateStoreUser && $group_id != BranchUser) { ?>
	    	    <li><a href="/account/income/user"><i
	    			class="fa fa-percent fa-fw"></i> &nbsp; Thu nhập Cộng tác viên
	    		    online</a></li>
		    <?php } ?>
		    <?php if ($group_id == BranchUser) { ?>
	    	    <li><a href="/account/income/user"><i
	    			class="fa fa-percent fa-fw"></i> &nbsp; Thu nhập Chi Nhánh</a></li>
	    	    <li><a href="/account/income/provisional_store"><i
	    			class="fa fa-percent fa-fw"></i> &nbsp;Thu nhập tạm tính</a></li>
			<?php } ?>
			<?php if ($group_id > 1) { ?>
	    	    <li>
	    		<a href="/account/bank"> <i
	    			class="fa fa-university fa-fw"></i> &nbsp; Cập nhật tài khoản ngân hàng
	    		</a>
	    	    </li>
		    <?php } ?> </ul>
	    </li>
	<?php } ?>

	<?php if ($group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser) { ?>
	    <li class="parent">
		<a href="#cay-he-thong" id="tree_title">
		    <img src="/templates/home/icons/menus/icon-i.png" alt="" style="height: 20px;"/> &nbsp; Cây hệ thống
		</a>
		<ul class="nav nav-child-2">
		    <?php if ($group_id != Developer2User) { ?>
	    	    <li><a href="/account/tree"><i
	    			class="fa fa-sitemap fa-fw"></i> &nbsp; Xem dạng cây</a></li>
	    	    <li><a href="/account/treelist"><i
	    			class="fa fa-list fa-fw"></i> &nbsp; Xem dạng danh sách</a></li>
			<?php } ?>
			<?php if ($group_id != Developer2User) { ?>
	    	    <li><a href="/account/tree/request/member"><i
	    			class="fa fa-asterisk fa-fw"></i> &nbsp; Yêu cầu tạo Thành viên</a></li>
			<?php } ?>
			<?php if ($group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser) { ?>
	    	    <li><a href="/account/tree/uprated"><i
	    			class="fa fa-upload fa-fw"></i> &nbsp; Yêu cầu nâng cấp Thành viên</a>
	    	    </li>
		    <?php } ?> </ul>
	    </li>
	<?php } ?>

	<?php if ($group_id == AffiliateStoreUser || $group_id == AffiliateUser) { ?>
	    <?php if ($group_id == AffiliateStoreUser) { ?>
	        <li class="parent">
	    	<a href="#quang-cao" id="advs_title">
	    	    <img src="/templates/home/icons/menus/icon-16.png" alt="" style="height: 20px;"/>
	    	    &nbsp; Dịch vụ quảng cáo
	    	</a>
	    	<ul class="nav nav-child-2">
	    	    <li><a href="/account/myads"><i
	    			class="fa fa-bullhorn fa-fw"></i> &nbsp; Banner quảng cáo của tôi</a>
	    	    </li>
	    	    <li><a href="/account/advs"><i
	    			class="fa fa-bullhorn fa-fw"></i>
	    		    &nbsp; Tạo banner quảng cáo</a></li>
	    	    <li>
	    		<a href="/account/advs/click"> <i
	    			class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê lượt click</a>
	    	    </li>
	    	</ul>
	        </li>
	    <?php } ?>

	    <li class="parent">
		<a href="#dich-vu-azibai" id="service_title">
		    <img src="/templates/home/icons/menus/icon-17.png" alt="" style="height: 20px;"/> &nbsp; Dịch vụ Azibai</a>
		<ul class="nav nav-child-2">
		    <li>
			<a href="/account/service"> <i
				class="fa fa-gratipay fa-fw"></i> &nbsp; Danh sách dịch vụ </a>
		    </li>
		    <li>
			<a href="/account/service/using"> <i
				class="fa fa-bookmark fa-fw"></i> &nbsp; Đang sử dụng </a>
		    </li>
		</ul>
	    </li>
	<?php } ?>

	<?php if ($group_id == AffiliateUser || $group_id == StaffStoreUser || $group_id == StaffUser) { ?>

	    <li class="parent">
		<a href="/account/share-land"
		   class="left_menu_title"
		   id="">
		    <img src="/templates/home/icons/menus/icon-06.png" alt="" style="height: 20px;"/> &nbsp; Danh sách tờ rơi điện tử</a>
	    </li>
	<?php } ?>

	<?php if ($group_id == AffiliateStoreUser || $group_id == BranchUser) { ?>
	    <li class="parent">
		<a href="#cong-cu-maketing" id="landingpage_title">
		    <img src="/templates/home/icons/menus/icon-18.png" alt="" style="height: 20px;"/> &nbsp; Công cụ Marketing
		</a>
		<ul class="nav nav-child-2">
		    <!---->
		    <?php //if ($sho_package && $sho_package[ 'id']> 1):  ?>
		    <?php if ($group_id != StaffStoreUser) { ?>
	    	    <li><a href="/account/tool-marketing/email-marketing"><i
	    			class="fa fa-envelope fa-fw"></i> &nbsp; Email Marketing</a></li>

		    <?php } ?>
		    <li><a href="/account/landing_page/lists/"><i
				class="fa fa-file-o fa-fw"></i> &nbsp; Tờ rơi điện tử</a></li>
		    <!---->
		    <?php //endif;   ?>

		    <div class="hidden">
			<?php if ($sho_package && $sho_package['id'] > 1): ?>
	    		<li><a href="/account/tool-marketing/azi-direct"><i
	    			    class="fa fa-cloud-download fa-fw"></i> &nbsp; Azi-direct</a></li>
			    <?php endif; ?>
			    <?php if ($sho_package && $sho_package['id'] > 2): ?>
	    		<li><a href="/account/tool-marketing/azi-branch"><i
	    			    class="fa fa-map-marker fa-fw"></i> &nbsp; Azi-branch</a></li>
			    <?php endif; ?>
			    <?php if ($sho_package && $sho_package['id'] > 1): ?>
	    		<li><a href="/account/tool-marketing/azi-publisher"><i
	    			    class="fa fa-rss fa-fw"></i> &nbsp; Azi-publisher</a></li>
			    <?php endif; ?>
			<li><a href="/account/tool-marketing/azi-affiliate"><i
				    class="fa fa-share-alt fa-fw"></i> &nbsp; Cộng tác viên online
				Azibai</a></li>
			<?php if ($sho_package && $sho_package['id'] > 4): ?>
	    		<li><a href="/account/tool-marketing/azi-manager"><i
	    			    class="fa fa-tachometer fa-fw"></i> &nbsp; Azi-manager</a></li>
			    <?php endif; ?>
		    </div>
		</ul>
	    </li>
	<?php } ?>

	<?php if ($group_id == AffiliateStoreUser || $group_id == StaffStoreUser || $group_id == StaffUser || $group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser || $group_id == AffiliateUser || $group_id == BranchUser) { ?>
	    <li class="parent">
		<a href="#tai-lieu" id="docs_title">
		    <img src="/templates/home/icons/menus/icon-19.png" alt="" style="height: 20px;"/> &nbsp; Tài liệu
		</a>
		<ul class="nav nav-child-2">
		    <li><a href="/account/docs/30/chinh-sach-thanh-vien.html"><i
				class="fa fa-user fa-fw"></i> &nbsp; Chính sách thành viên</a></li>
		    <li><a href="/account/docs/33/chinh-sach-hoa-hong.html"><i
				class="fa fa-percent fa-fw"></i> &nbsp; Chính sách hoa hồng</a></li>
		    <li><a href="/account/docs/31/huong-dan-cach-lam-viec.html"><i
				class="fa fa-book fa-fw"></i> &nbsp; Hướng dẫn cách làm việc</a></li>
		    <li><a href="/account/docs/32/video-huong-dan.html"><i
				class="fa fa-video-camera fa-fw"></i> &nbsp; Video hướng dẫn, tài liệu</a>
		    </li>
		</ul>
	    </li>
	    <?php if ($group_id != StaffStoreUser && $group_id != StaffUser) { ?>
	        <li class="parent">
	    	<a href="#chia-se" id="share_title">
	    	    <img src="/templates/home/icons/menus/icon-20.png" alt="" style="height: 20px;"/>
	    	    &nbsp; Chia sẻ
	    	</a>
	    	<ul class="nav nav-child-2">
	    	    <li><a href="/account/sharelist"><i
	    			class="fa fa-list-ul fa-fw"></i> &nbsp; Danh sách link cần chia sẻ</a>
	    	    </li>
			<?php if ($group_id == BranchUser) { ?>
			    <li><a href="/account/share-land"><i
					class="fa fa-list-ul fa-fw"></i> &nbsp; Tờ rơi điện tử</a></li>
			    <?php } ?>
	    	    <li><a href="/account/share"><i
	    			class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê chia sẻ link</a>
	    	    </li>
	    	    <li><a href="/account/share/view-list"><i
	    			class="fa fa-line-chart fa-fw"></i> &nbsp; Thống kê lượt xem sản
	    		    phẩm</a></li>
	    	</ul>
	        </li>
	    <?php } ?>
	<?php } ?>



    <li><a href="<?php echo getAliasDomain('logout/');?>" id="logout_title">
    		<img src="/templates/home/icons/black/icon-logout.png" alt="" style="height:20px;"/> &nbsp; Đăng xuất
    	</a>
    </li>

    <?php } else { ?>
        <li class="parent1">
    	<a href="<?php echo getAliasDomain();?>">
    	    <img src="/templates/home/icons/black/icon-user.png" alt=""/> &nbsp; Đăng ký
    	    <span class="fa fa-angle-down pull-right"></span>
    	</a>
    	<ul class="nav nav-child-1">
    	    <li>
    		<a href="<?php echo getAliasDomain('register');?>"><img
    			src="/templates/home/icons/black/icon-add-user.png" alt=""/>
    		    &nbsp; Đăng ký thành viên</a>
    	    </li>
    	    <li>
    		<a href="<?php echo getAliasDomain('register/affiliate');?>"><img
    			src="/templates/home/icons/black/icon-add-user.png" alt=""/>
    		    &nbsp; Đăng ký cộng tác viên</a>
    	    </li>
    	    <li>
    		<a href="<?php echo getAliasDomain('discovery');?>"><img
    			src="/templates/home/icons/black/icon-store.png" alt=""/>
    		    &nbsp; Mở gian hàng</a>
    	    </li>
    	</ul>
        </li>    
        <li>
    	<a href="<?php echo getAliasDomain('login');?>">
    	    <img src="/templates/home/icons/black/icon-login.png" alt=""/>
    	    &nbsp; Đăng nhập
    	</a>
        </li>
    <?php } ?>

</ul>



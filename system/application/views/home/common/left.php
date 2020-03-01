<?php    
    $group_id = (int) $this->session->userdata('sessionGroup');
    if ($group_id == AffiliateStoreUser || $group_id == AffiliateUser || $group_id == BranchUser) {
	$this->db->flush_cache();
	$shop_info_menu = $this->shop_model->get('sho_link, sho_id, sho_name, domain', 'sho_user = '. (int)$this->session->userdata('sessionUser'));
    }

    if ($shop_info_menu->domain != '') {
	$my_link_shop = 'http://'. $shop_info_menu->domain .'/shop';
        $link_aff_shop = 'http://'. $shop_info_menu->domain .'/affiliate/product';
    } else {
        $ptc = stripos($_SERVER['SERVER_PROTOCOL'],'https') === true ? 'https://' : 'http://';
	    $my_link_shop = $ptc . $shop_info_menu->sho_link .'.'. domain_site .'/shop';
        $link_aff_shop = $ptc . $shop_info_menu->sho_link .'.'. domain_site .'/affiliate/product';
    }
?>
<style>
    #accordion .panel-body {padding: 0;}
    #accordion .panel-heading  a { display: block; }
    .menuadmin li ul {display: none; background: #fff; }
    .menuadmin > li + li {border-top:1px solid #eee}
    .menuadmin > li.active,
    .menuadmin > li.active:hover {background: #5cb5b5; box-shadow: 0 1px 2px 0 #999;}
    .menuadmin > li.active > a,
    .menuadmin > li.active > a:hover {background: #5cb5b5; color: #fff; }    
    .fa.pull-right {margin-top: 5px;}
    #accordion .panel-menu {border-color: #008c8c}
    #accordion .panel-menu + .panel-menu{ margin-top: 3px;}
    #accordion .panel-menu .panel-heading{color: #fff; background-color: #008c8c; border-color: #008c8c;}
    #accordion .panel-menu .panel-heading a{color:#fff;}
    
    .menuadmin ul li a {padding: 5px 10px;}
    .menuadmin ul li {border-top:1px dotted #ccc;}   
    .menuadmin ul li:hover,
    .menuadmin ul li a:hover {background: #f7f8f9; }    
</style>
<script>
    jQuery(function ($) {
    	$('ul.menuadmin > li > a').click(function () {
    	    $(this).next().slideToggle();
    	    $(this).parent().addClass('active');
    	    $('ul.menuadmin > li > a').not(this).next().slideUp();
    	    $('ul.menuadmin > li > a').not(this).parent().removeClass('active');
    	});	
    });
</script>

<!--BEGIN: LEFT-->
<div class="col-md-3 col-sm-4 col-xs-12">
    <?php if ($group_id == AffiliateStoreUser || $group_id == SubAdminUser) { ?> 
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">    	
        <div class="panel panel-menu">
    	    <div class="panel-heading" role="tab" id="headingOne">    		
    		    <a role="button" data-toggle="collapse" 
		       data-parent="#accordion" href="#collapseOne" 
		       ria-expanded="true" aria-controls="collapseOne">THÔNG TIN CHUNG</a>    		
    	    </div>
    	    <div id="collapseOne" class="panel-collapse collapse <?php echo ($menuPanelGroup == 1) ? 'in' : '' ?>" role="tabpanel" aria-labelledby="headingOne">
    		<div class="panel-body">
    		    <ul class="nav menuadmin">
    			<li role="presentation" class="<?php echo $menuSelected == 'edit' ? 'active' : ''; ?>"><a href="/account/edit"><i class="fa fa-info-circle fa-fw"></i> Thông tin cá nhân</a></li>
    			<li role="presentation" class="<?php echo $menuSelected == 'updateprofile' ? 'active' : ''; ?>"><a href="/account/updateprofile"><i class="fa fa-pencil-square-o fa-fw"></i> Danh thiếp điện tử</a></li>
    			<li role="presentation" class="<?php echo $menuSelected == 'changepassword' ? 'active' : ''; ?>"><a href="/account/changepassword"><i class="fa fa-key fa-fw"></i> Đổi mật khẩu</a></li>
                <li role="presentation" class="<?php echo $menuSelected == 'personaldomain' ? 'active' : ''; ?>"><a href="/account/personaldomain"><i class="fa fa-globe" aria-hidden="true"></i> Tên miền cá nhân</a></li>
    		    </ul>
    		</div>
    	    </div>
    	</div>

    	<div class="panel panel-menu">
    	    <div class="panel-heading" role="tab" id="headingTwo">    		
    		    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">NGƯỜI MUA HÀNG</a>    		
    	    </div>
    	    <div id="collapseTwo" class="panel-collapse collapse <?php echo ($menuPanelGroup == 2) ? 'in' : '' ?>" role="tabpanel" aria-labelledby="headingTwo">
    		<div class="panel-body">
    		    <ul class="nav menuadmin">
    			<li role="presentation" class="<?php echo $menuSelected == 'probuy' ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>account/user_order/product"><i class="fa fa-cubes fa-fw"></i> Sản phẩm đã mua</a></li>
    			<li role="presentation" class="<?php echo $menuSelected == 'procou' ? 'active' : ''; ?>"><a href="<?php echo base_url(); ?>account/user_order/coupon"><i class="fa  fa-tags fa-fw"></i> Coupon đã mua</a></li>                        
    		    </ul>
    		</div>
    	    </div>
    	</div>

    	<div class="panel panel-menu">
    	    <div class="panel-heading" role="tab" id="headingThree">    		
        		<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">CỘNG TÁC VIÊN</a>    		
    	    </div>
    	    <div id="collapseThree" class="panel-collapse collapse <?php echo ($menuPanelGroup == 3) ? 'in' : '' ?>" role="tabpanel" aria-labelledby="headingThree">
        		<div class="panel-body">
        		    <ul class="nav menuadmin">
                        <li role="presentation">
                            <a target="_blank" href="<?php echo $link_aff_shop; ?>">Xem gian hàng <i class="fa fa-eye fa-fw pull-right"></i></a>                       
                        </li>                                          

                        <li role="presentation" class="<?php echo $menuSelected == 'affiliate_store' ? 'active' : ''; ?>"><a href="#menu"> Quản lý kho hàng <i class="fa fa-angle-down fa-fw pull-right"></i></a>
                            <ul class="nav" <?php echo $menuSelected == 'affiliate_store' ? 'style="display: block"' : ''; ?> >
                                <li role="presentation"><a href="/account/affiliate/pickup/product"><i class="fa fa-search fa-fw"></i> Tìm nguồn hàng về kho</a></li>
                                <li role="presentation"><a href="/account/affiliate/depot/product"><i class="fa fa-list-ul fa-fw"></i> Sản phẩm đã chọn</a></li>
                                <li role="presentation"><a href="/account/affiliate/depot/coupon"><i class="fa fa-list-ul fa-fw"></i> Coupon đã chọn</a></li>
                            </ul>
                        </li> 

                        <li role="presentation" class="<?php echo $menuSelected == 'affiliate_order' ? 'active' : ''; ?>"><a href="#menu"> Quản lý đơn hàng<i class="fa fa-angle-down fa-fw pull-right"></i></a>
                            <ul class="nav" <?php echo $menuSelected == 'affiliate_order' ? 'style="display: block"' : ''; ?> >
                                <li role="presentation"><a href="/account/affiliate/order/product"><i class="fa fa-list-ul fa-fw"></i> Đơn hàng sản phẩm</a></li>
                                <li role="presentation"><a href="/account/affiliate/order/coupon"><i class="fa fa-list-ul fa-fw"></i> Đơn hàng coupon</a></li>                                
                            </ul>
                        </li>

                        <li role="presentation" class="<?php echo $menuSelected == 'affiliate_statistic' ? 'active' : ''; ?>"><a href="#menu"> Thống kê kinh doanh<i class="fa fa-angle-down fa-fw pull-right"></i></a>
                            <ul class="nav" <?php echo $menuSelected == 'affiliate_statistic' ? 'style="display: block"' : ''; ?> >
                                <li role="presentation"><a href="/account/affiliate/shop_statistic"><i class="fa fa-line-chart fa-fw"></i> Thống kê chung</a></li>
                                <!-- <li role="presentation"><a href="/account/affiliate/statistic/coupon"><i class="fa fa-line-chart fa-fw"></i> Thống kê theo coupon</a></li> -->                                
                            </ul>
                        </li>

                        <li role="presentation" class="<?php echo $menuSelected == 'affiliate_income' ? 'active' : ''; ?>"><a href="#menu"> Tính toán thu nhập<i class="fa fa-angle-down fa-fw pull-right"></i></a>
                            <ul class="nav" <?php echo $menuSelected == 'affiliate_income' ? 'style="display: block"' : ''; ?> >
                                <li role="presentation"><a href="/account/affiliate/shop_temp_income"><i class="fa fa-money fa-fw"></i> Thu nhập tạm tính</a></li>
                                <li role="presentation"><a href="/account/affiliate/shop_income"><i class="fa fa-money fa-fw"></i> Thu nhập thực</a></li>
                            </ul>
                        </li> 

                        <!-- <li role="presentation">
                            <a href="/account/cancel/relative" class="">Hủy cộng tác</a>
                        </li> --> 			    
        		    </ul>
        		</div>
    	    </div>
    	</div>
        
    	<div class="panel panel-menu">
    	    <div class="panel-heading" role="tab" id="headingFour">    		
    		    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">NGƯỜI BÁN HÀNG</a>    		
    	    </div>
    	    <div id="collapseFour" class="panel-collapse collapse <?php echo ($menuPanelGroup == 4) ? 'in' : '' ?>" role="tabpanel" aria-labelledby="headingFour">
    		<div class="panel-body">
    		    <ul class="nav menuadmin">
    			<li role="presentation">
    			    <a target="_blank" href="<?php echo $my_link_shop; ?>">Xem gian hàng <i class="fa fa-eye fa-fw pull-right"></i>
    			    </a>                       
    			</li>

                <li role="presentation" class="<?php echo ($menuSelected == 'shop') ? 'active' : ''; ?>">
                <a href="#menu">Quản lý gian hàng <i class="fa fa-angle-down fa-fw pull-right"></i></a>
                    <ul class="nav" <?php echo ($menuSelected == 'shop') ? 'style="display: block"' : ''; ?>>
                    <li role="presentation"><a href="/account/shop"><i class="fa fa-pencil-square-o fa-fw"></i>  Cập nhật thông tin gian hàng</a></li>                  
                    <li role="presentation"><a href="/account/shop/intro"><i class="fa fa-inbox fa-fw"></i> Giới thiệu về gian hàng</a></li>
                    <li role="presentation"><a href="/account/shop/shoprule"><i class="fa fa-toggle-on fa-fw"></i> Chính sách gian hàng</a></li>                    
                    <li role="presentation"><a href="/account/shop/domain"><i class="fa fa-link fa-fw"></i> Gắn tiên miền</a></li>
                    </ul>
                </li>

    			<li role="presentation" class="<?php echo $menuSelected == 'news' ? 'active' : ''; ?>"><a href="#menu">Quản lý tin tức <i class="fa fa-angle-down fa-fw pull-right"></i></a>
			    <ul class="nav" <?php echo $menuSelected == 'news' ? 'style="display: block"' : ''; ?> >
    				<li role="presentation"><a href="/account/news/add"><i class="fa fa-pencil-square-o fa-fw"></i> Đăng tin</a></li>
    				<li role="presentation"><a href="/account/news"><i class="fa fa-list-ul fa-fw"></i> Tin đã đăng</a></li>
    				<li role="presentation"><a href="/account/comments"><i class="fa fa-comments-o fa-fw"></i> Bình luận của khách hàng</a></li>
    			    </ul>
    			</li>
			
    			<li role="presentation" class="<?php echo ($menuSelected == 'product' || $menuSelected == 'product_coupon') ? 'active' : ''; ?>"><a href="#menu">Quản lý hàng hóa <i class="fa fa-angle-down fa-fw pull-right"></i></a>
    			    <ul class="nav" <?php echo ($menuSelected == 'product' || $menuSelected == 'product_coupon') ? 'style="display: block"' : ''; ?>>
    				<!-- <li role="presentation"><a href="/account/product/product/post"><i class="fa fa-pencil-square-o fa-fw"></i> Đăng sản phẩm</a></li> -->
    				<li role="presentation"><a href="/product/add/<?php echo $this->session->userdata('sessionUser') ?>" target="_blank"><i class="fa fa-pencil-square-o fa-fw"></i> Đăng sản phẩm</a></li>
    				<li role="presentation"><a href="/account/product/product"><i class="fa fa-shopping-bag fa-fw"></i> Sản phẩm đã đăng</a></li>
    				<!-- <li role="presentation"><a href="/account/product/coupon/post"><i class="fa fa-pencil-square-o fa-fw"></i> Đăng coupon</a></li> -->
    				<li role="presentation"><a href="/coupon/add/<?php echo $this->session->userdata('sessionUser') ?>" target="_blank"><i class="fa fa-pencil-square-o fa-fw"></i> Đăng coupon</a></li>
    				<li role="presentation"><a href="/account/product/coupon"><i class="fa fa-shopping-bag fa-fw"></i> Coupon đã đăng</a></li>    					   
    			    </ul>
    			</li>   			

    			<li role="presentation" class="<?php echo ($menuSelected == 'showcart') ? 'active' : ''; ?>">
			    <a href="#menu">Quản lý đơn hàng <i class="fa fa-angle-down fa-fw pull-right"></i></a>
    			    <ul class="nav" <?php echo ($menuSelected == 'showcart') ? 'style="display: block"' : ''; ?>>
    				<li role="presentation"><a href="/account/order/product"><i class="fa fa-file-text-o fa-fw"></i> Đơn hàng sản phẩm mới</a></li>
    				<li role="presentation"><a href="/account/order/coupon"><i class="fa fa-file-text-o fa-fw"></i> Đơn hàng coupon mới</a></li>
    				<li role="presentation"><a href="/account/customer"><i class="fa fa-users fa-fw"></i> Danh sách khách hàng</a></li>
    			    </ul>
    			</li>

    			<li role="presentation" class="<?php echo ($menuSelected == 'requirements_change_delivery') ? 'active' : ''; ?>">
			    <a href="#menu">Yên cầu khiếu nại <i class="fa fa-angle-down fa-fw pull-right"></i></a>
    			    <ul class="nav" <?php echo ($menuSelected == 'requirements_change_delivery') ? 'style="display: block"' : ''; ?>>
    				<li role="presentation"><a href="/account/complaintsOrders"><i class="fa fa-arrows fa-fw"></i> Khiếu nại mới</a></li>
    				<li role="presentation"><a href="/account/solvedOrders"><i class="fa fa-arrows fa-fw"></i> Khiếu nại đã giải quyết</a></li>
    			    </ul>
    			</li>

    			<li role="presentation" class="<?php echo ($menuSelected == 'statistic') ? 'active' : ''; ?>">
			    <a href="#menu">Thống kê hệ thống <i class="fa fa-angle-down fa-fw pull-right"></i></a>
    			    <ul class="nav" <?php echo ($menuSelected == 'statistic') ? 'style="display: block"' : ''; ?>>
    				<li role="presentation"><a href="/account/statistic"><i class="fa fa-line-chart fa-fw"></i> Thống kê chung</a></li>
    				<li role="presentation"><a href="/account/statisticIncome"><i class="fa fa-line-chart fa-fw"></i> Thống kê thu nhập</a></li> 
                    <li role="presentation"><a href="/account/statisticlistbran"><i class="fa fa-line-chart fa-fw"></i> Thống kê chi nhánh</a></li>
    				<!-- <li role="presentation"><a href="/account/salesemployee"><i class="fa fa-line-chart fa-fw"></i> Thống kê nhân viên</a></li> -->
    				<li role="presentation"><a href="/account/statisticlistaffiliate"><i class="fa fa-line-chart fa-fw"></i> Thống kê cộng tác viên</a></li>
                    <li role="presentation"><a href="/account/statisticlistaffiliatebran"><i class="fa fa-line-chart fa-fw"></i> Thống kê cộng tác viên chi nhánh</a></li>
    				<li role="presentation"><a href="/account/statisticproduct"><i class="fa fa-line-chart fa-fw"></i> Thống kê theo sản phẩm</a></li>
    			    </ul>
    			</li>

    			<!-- <li role="presentation" class="<?php echo ($menuSelected == 'statisticStore') ? 'active' : ''; ?>">
			    <a href="#menu">Thống kê gian hàng <i class="fa fa-angle-down fa-fw pull-right"></i></a>
    			    <ul class="nav" <?php echo ($menuSelected == 'statisticStore') ? 'style="display: block"' : ''; ?>>
    				<li role="presentation"><a href="/account/statistic_Store"><i class="fa fa-line-chart fa-fw"></i> Thống kê chung</a></li>
    				<li role="presentation"><a href="/account/statisticIncome_Store"><i class="fa fa-line-chart fa-fw"></i> Thống kê thu nhập</a></li>
    				<li role="presentation"><a href="/account/statisticlistbran"><i class="fa fa-line-chart fa-fw"></i> Thống kê chi nhánh</a></li>
    				<li role="presentation"><a href="/account/salesemployee_Store"><i class="fa fa-line-chart fa-fw"></i> Thống kê nhân viên</a></li>
    				<li role="presentation"><a href="/account/statisticlistaffiliate_Store"><i class="fa fa-line-chart fa-fw"></i> Thống kê cộng tác viên</a></li>
    				<li role="presentation"><a href="/account/statisticproduct_Store"><i class="fa fa-line-chart fa-fw"></i> Thống kê theo sản phẩm</a></li>
    			    </ul>
    			</li> -->

    			<li role="presentation" class="<?php echo ($menuSelected == 'income') ? 'active' : ''; ?>">
			    <a href="#menu">Thu nhập <i class="fa fa-angle-down fa-fw pull-right"></i></a>
    			    <ul class="nav" <?php echo ($menuSelected == 'income') ? 'style="display: block"' : ''; ?>>
    				<li role="presentation"><a href="/account/income/user"><i class="fa fa-percent fa-fw"></i> Thu nhập gian hàng</a></li>
    				<li role="presentation"><a href="/account/income/provisional_store"><i class="fa fa-percent fa-fw"></i> Thu nhập tạm tính</a></li>
    				<!-- <li role="presentation"><a href="/account/income/tamtinhGH"><i class="fa fa-percent fa-fw"></i> Thu nhập tạm tính của gian hàng</a></li> -->
    				<li role="presentation"><a href="/account/bank"><i class="fa fa-university fa-fw"></i> Cập nhật tài khoản ngân hàng</a></li>
    			    </ul>
    			</li>

                <li role="presentation" class="<?php echo ($menuSelected == 'affiliate') ? 'active' : ''; ?>">
                <a href="#menu">Cộng tác viên <i class="fa fa-angle-down fa-fw pull-right"></i></a>
                    <ul class="nav" <?php echo ($menuSelected == 'affiliate') ? 'style="display: block"' : ''; ?>>
                    <li role="presentation"><a href="/account/tree/inviteaf"><i class="fa fa-files-o"></i> Giới thiệu mở cộng tác viên</a></li>                  
                    <li role="presentation"><a href="/account/listaffiliate"><i class="fa fa-list-ol fa-fw"></i> Danh sách cộng tác viên</a></li>
                    <li role="presentation"><a href="/account/allaffiliateunder"><i class="fa fa-list-ol fa-fw"></i> Cộng tác viên toàn công ty</a></li>                    
                    <li role="presentation"><a href="/account/affiliate/listuserregister"><i class="fa fa-list-ol fa-fw"></i> Danh sách đăng ký qua trang doanh nghiệp</a></li>
                    </ul>
                </li>
    			                    
			<!-- <li role="presentation" class="<?php echo ($menuSelected == 'chinhanh') ? 'active' : ''; ?>">
			    <a href="#menu">Chi nhánh <i class="fa fa-angle-down fa-fw pull-right"></i></a>
			    <ul class="nav" <?php echo ($menuSelected == 'chinhanh') ? 'style="display: block"' : ''; ?>>				
    				<li role="presentation"><a href="/account/addbranch"><i class="fa fa-pencil-square-o fa-fw"></i> Thêm chi nhánh</a></li>
    				<li role="presentation"><a href="/account/listbranch"><i class="fa fa-list-ol  fa-fw"></i> Danh sách chi nhánh</a></li>
    				<li role="presentation"><a href="/branch/prowaitingapprove"><i class="fa fa-cubes  fa-fw"></i> Sản phẩm chờ duyệt</a></li>
    				<li role="presentation"><a href="/branch/newswaitapprove"><i class="fa fa-newspaper-o  fa-fw"></i> Tin tức chờ duyệt</a></li>
    				<li role="presentation"><a href="/branch/flyerwaitapprove"><i class="fa fa-file-text-o  fa-fw"></i> Tờ rơi chờ duyệt</a></li>
    			    </ul>
    			</li> -->

    			<li role="presentation" class="<?php echo ($menuSelected == 'task') ? 'active' : ''; ?>">
			    <a href="#menu">Nhân viên <i class="fa fa-angle-down fa-fw pull-right"></i></a>
    			    <ul class="nav" <?php echo ($menuSelected == 'task') ? 'style="display: block"' : ''; ?>>				
    				<li role="presentation"><a href="/account/staffs/add"><i class="fa fa-pencil-square-o fa-fw"></i> Thêm nhân viên</a></li>
    				<li role="presentation"><a href="/account/staffs/all"><i class="fa fa-list-ol  fa-fw"></i> Danh sách nhân viên</a></li>
    				<li role="presentation"><a href="/account/statisticalbran"><i class="fa fa-line-chart fa-fw"></i> Thống kê mở chi nhánh</a></li>
    				<li role="presentation"><a href="/account/statisticalemployee"><i class="fa fa-line-chart fa-fw"></i> Thống kê mở cộng tác viên</a></li>
                    <?php if ($group_id != AffiliateStoreUser) { ?>
    				<li role="presentation"><a href="/account/viewtasks/month/03"><i class="fa fa-tasks fa-fw"></i> Bảng công việc từ cấp trên</a></li>
                    <?php } ?>
    			    </ul>
    			</li>                 

    			<li role="presentation" class="<?php echo ($menuSelected == 'grouptrade') ? 'active' : ''; ?>">
			    <a href="#menu">Quản lý nhóm <i class="fa fa-angle-down fa-fw pull-right"></i></a>
    			    <ul class="nav" <?php echo ($menuSelected == 'grouptrade') ? 'style="display: block"' : ''; ?>>	
    				<li role="presentation"><a href="/account/group/mychannel"><i class="fa fa-list-ol  fa-fw"></i> Nhóm của tôi</a></li>
    				<li role="presentation"><a href="/account/group/joinchannel"><i class="fa fa-list-ol  fa-fw"></i> Nhóm tôi tham gia</a></li>
    				<li role="presentation"><a href="/grouptrade/add"><i class="fa fa-pencil-square-o fa-fw"></i> Tạo nhóm</a></li>
    			    </ul>
    			</li>

    			<li role="presentation" class="<?php echo ($menuSelected == 'tool') ? 'active' : ''; ?>">
			    <a href="#menu">Công cụ marketing <i class="fa fa-angle-down fa-fw pull-right"></i></a>
    			    <ul class="nav" <?php echo ($menuSelected == 'tool') ? 'style="display: block"' : ''; ?>>	
    				<li role="presentation"><a href="/account/tool-marketing/email-marketing"><i class="fa fa-envelope fa-fw"></i> Email marketing</a></li>
    				<li role="presentation"><a href="/account/landing_page/lists/"><i class="fa fa-file-o fa-fw"></i> Tờ rơi điện tử</a></li>
    			    </ul>
    			</li>

    			<li role="presentation" class="<?php echo ($menuSelected == 'recharge_and_spend_money') ? 'active' : ''; ?>">
			    <a href="#menu">Quản lý chi tiêu <i class="fa fa-angle-down fa-fw pull-right"></i></a>           
    			    <ul class="nav" <?php echo ($menuSelected == 'recharge_and_spend_money') ? 'style="display: block"' : ''; ?>>	
    				<li role="presentation"><a href="/account/addWallet"><i class="fa fa-money fa-fw"></i> Nạp tiền vào ví điện tử</a></li>
    				<li role="presentation"><a href="/account/historyRecharge"><i class="fa fa-history fa-fw"></i> Lịch sử nạp tiền</a></li>
    				<li role="presentation"><a href="/account/spendingHistory"><i class="fa fa-history fa-fw"></i> Lịch sử tiêu tiền</a></li>
    			    </ul>
    			</li>                   

    			<li role="presentation" class="<?php echo ($menuSelected == 'service') ? 'active' : ''; ?>">
			    <a href="#menu">Dịch vụ azibai <i class="fa fa-angle-down fa-fw pull-right"></i></a>           
    			    <ul class="nav" <?php echo ($menuSelected == 'service') ? 'style="display: block"' : ''; ?>>
    				<li role="presentation"><a href="/account/service"><i class="fa fa-gratipay fa-fw"></i> Danh sách dịch vụ</a></li>
    				<li role="presentation"><a href="/account/service/using"><i class="fa fa-bookmark fa-fw"></i> Đang sử dụng</a></li>
    			    </ul>
    			</li>                    

    			<li role="presentation" class="<?php echo ($menuSelected == 'docs') ? 'active' : ''; ?>">
			    <a href="#menu">Tài liệu <i class="fa fa-angle-down fa-fw pull-right"></i></a>
    			    <ul class="nav" <?php echo ($menuSelected == 'docs') ? 'style="display: block"' : ''; ?>>
    				<li role="presentation"><a href="/account/docs/30/chinh-sach-thanh-vien.html"><i class="fa fa-user fa-fw"></i> Chính sách thành viên</a></li>
    				<li role="presentation"><a href="/account/docs/33/chinh-sach-hoa-hong.html"><i class="fa fa-percent fa-fw"></i> Chính sách hoa hồng</a></li>
    				<li role="presentation"><a href="/account/docs/31/huong-dan-cach-lam-viec.html"><i class="fa fa-book fa-fw"></i> Hướng dẫn làm việc</a></li>
    				<li role="presentation"><a href="/account/docs/32/video-huong-dan.html"><i class="fa fa-video-camera fa-fw"></i> Video hướng dẫn, tài liệu</a></li>
    			    </ul>
    			</li>

    			<li role="presentation" class="<?php echo ($menuSelected == 'share') ? 'active' : ''; ?>">
			    <a href="#menu">Chia sẻ <i class="fa fa-angle-down fa-fw pull-right"></i></a>
    			    <ul class="nav" <?php echo ($menuSelected == 'share') ? 'style="display: block"' : ''; ?>>
    				<li role="presentation"><a href="/account/sharelist"><i class="fa fa-list-ul fa-fw"></i> Đường dẫn cần chia sẻ</a></li>
    				<li role="presentation"><a href="/account/share"><i class="fa fa-line-chart fa-fw"></i> Thống kê chia sẻ đường dẫn</a></li>
    				<li role="presentation"><a href="/account/share/view-list"><i class="fa fa-line-chart fa-fw"></i> Thống kê lượt xem sản phẩm</a></li>
    			    </ul>
    			</li>
    		    </ul>
    		</div>
    	    </div>
    	</div>
    </div>
    <?php } else { ?>
    <div class="left-menu" style="margin-bottom:20px;">        
    	<table width="100%" border="0" cellpadding="0" cellspacing="0">	    	
		<?php $this->load->view('home/common/menu'); ?>
            
		<?php if (isset($advertisePage) && $advertisePage != 'account') { ?>
		    <tr>
			<td height="5"></td>
		    </tr>
		    <?php if ($this->uri->segment(1) == 'shop') { ?>
	    	    <tr>
	    		<td>
	    		    <div style="clear:both; padding-top:10px;">
	    		    </div>
				<?php $this->load->view('home/advertise/gianhangtrai'); ?>
	    		</td>
	    	    </tr>
		    <?php } else { ?>				
			<?php if (isset($topLastestAds)) { ?>
			    <?php if ($this->uri->segment(1) != 'raovat') { ?>
				<?php $this->load->view('home/raovat/top_lastest_home'); ?>
			    <?php } ?>
			<?php } ?>
		    <?php } ?>
		    <tr>
			<td height="10"></td>
		    </tr>
		    <?php //$this->load->view('home/advertise/left'); ?>
		<?php } ?>
    	</table>
    </div>
    <?php } ?>
    
    <?php if ($group_id == AffiliateStoreUser || $group_id == AffiliateUser) { ?>
        <!-- <div class="menu_support">
            <ul class="sortable-list ui-sortable infomation_col list-unstyled">
                <li>
                    <a class="left_menu_title" id="landingpage_title">
                        <i class="fa fa-server" aria-hidden="true"></i> Gói DV:
                        <span class="red_money"><?php echo ($sho_package) ? $sho_package['name'] : 'Miễn phí'; ?></span></a>
                    <br/>                                    
                </li>
                <li>
                    <a class="left_menu_title" id="landingpage_title">
                        <i class="fa fa-money" aria-hidden="true"></i> Số dư:
                        <span class="red_money"><?php echo ($wallet_info[0]->amount) ? number_format($wallet_info[0]->amount, 0, ",", ".") : '0' ?>
                            đ</span></a>
                </li>
            </ul>
        </div> -->
    <?php } ?>

    <div class="menu_support">
        <div class="text-icon">Hỗ trợ
            <i class="fa fa-phone-square"></i>
        </div>
        <div class="hotline">                           
            <p class="number"><?php echo HOTLINE; ?></p>
            <p class="email"><i class="fa fa-envelope"></i> <?php echo emailSupport; ?></p>
        </div> 
	<div class="clearfix"></div>
    </div>
     <div class="clearfix">&nbsp;</div>
</div>

<!--END LEFT-->

<tr>
    <td height="27" valign="top">
        <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td width="2" height="27" valign="top"></td>
                <td height="27" valign="top">
                    <div id="chromemenu">
                        <ul>
							<?php if($this->session->userdata('sessionUserAdmin') == 3026){ ?>
							<li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu61')" style="cursor:pointer;">Đơn hàng coupon</a></li>
							<?php } else { ?>
                            <?php if($this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'wallet_view ')) {?>
                                <?php /*
                           <li><a onclick="ActionLink('--><?php //echo base_url(); ?>//administ')" style="cursor:pointer;">Home<?php //echo $this->lang->line('home_menu'); ?></a></li>
                                */?>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu1')" style="cursor:pointer;"><?php echo $this->lang->line('system_menu'); ?></a></li>
                           <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu2')" style="cursor:pointer;">Newsletter</a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu11')" style="cursor:pointer;">Banner</a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu3')" style="cursor:pointer;"><?php echo $this->lang->line('member_menu'); ?></a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu100')"   style="cursor:pointer;">Dịch vụ Azibai</a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu12')" style="cursor:pointer;">Cây hệ thống </a></li>
							<?php } ?>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu4')" style="cursor:pointer;"><?php echo $this->lang->line('shop_menu'); ?></a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu70')" style="cursor:pointer;"><?php echo $this->lang->line('bran_menu'); ?></a></li>
                             <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu15')" style="cursor:pointer;">Cộng tác viên</a></li>   
							 <?php if($this->check->is_allowed($this->session->userdata('sessionPermissionAdmin'), 'wallet_view ')) {?>	
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu5')" style="cursor:pointer;"><?php echo $this->lang->line('product_menu'); ?></a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu50')" style="cursor:pointer;">Dịch vụ</a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu51')" style="cursor:pointer;">Coupon</a></li>
                           <?php /*?> <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu6')" style="cursor:pointer;"><?php echo $this->lang->line('ads_menu'); ?></a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu7')" style="cursor:pointer;" ><?php echo $this->lang->line('hoidap_menu'); ?></a></li>
                              <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu12')" style="cursor:pointer;"><?php echo $this->lang->line('tuyendung_timviec_menu'); ?></a></li><?php */?>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu8')" style="cursor:pointer;"><?php echo $this->lang->line('info_menu'); ?></a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu14')" style="cursor:pointer;">Chia sẻ</a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu9')" style="cursor:pointer;"><?php echo $this->lang->line('tool_menu'); ?></a></li>
                              <?php /*?><li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu10')" style="cursor:pointer;">Up Tin</a></li><?php */?>
							<?php } ?>  
							<li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu16')" style="cursor:pointer;">Hoa hồng</a></li>
                            <li><a onclick="ActionLink('<?php echo base_url(); ?>administ/account')" style="cursor:pointer;">Quản lý chuyển tiền</a></li>
							<!--<li><a onclick="ActionLink('<?php /*echo base_url(); */?>administ/test')" style="cursor:pointer;">Test</a></li>-->                            							
							<li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu13')" style="cursor:pointer;">Đơn hàng sản phẩm</a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu60')" style="cursor:pointer;">Đơn hàng dịch vụ</a></li>
                            <li><a onMouseover="cssdropdown.dropit(this,event,'dropmenu61')" style="cursor:pointer;">Đơn hàng coupon</a></li>
                            <li><a onclick="ActionLink('<?php echo base_url(); ?>administ/recharge')" style="cursor:pointer;">Nạp tiền</a></li>                            
							<?php } ?>
                        </ul>
                    </div>
                    <!--1st drop down menu -->
			        <div id="dropmenu1" class="dropmenudiv">
			            <!--<a onclick="ActionLink('<?php echo base_url(); ?>administ/system/config')" style="cursor:pointer;"><?php echo $this->lang->line('config_system_menu'); ?></a>-->
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/system/info')" style="cursor:pointer;"><?php echo $this->lang->line('info_system_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/system/payment')" style="cursor:pointer;"><?php echo $this->lang->line('payment_system_menu'); ?></a>
                         <a onclick="ActionLink('<?php echo base_url(); ?>administ/province')" style="cursor:pointer;">Danh sách <?php echo $this->lang->line('province_category_menu'); ?></a>
                         <a onclick="ActionLink('<?php echo base_url(); ?>administ/district')" style="cursor:pointer;">Danh sách <?php echo $this->lang->line('district_category_menu'); ?></a>
                          
                         <a onclick="ActionLink('<?php echo base_url(); ?>administ/system/config/solution_commission')" style="cursor:pointer;">Cấu hình hoa hồng bán Giải pháp</a>
                         
                         <a onclick="ActionLink('<?php echo base_url(); ?>administ/system/config/commission_rate')" style="cursor:pointer;">Cấu hình hoa hồng bán Sản phẩm</a>
                         
                         <a onclick="ActionLink('<?php echo base_url(); ?>administ/system/config/data')" style="cursor:pointer;">Cấu hình giảm giá khi mua từ Affiliate</a>
                         
                         <a onclick="ActionLink('<?php echo base_url(); ?>administ/category/fee')" style="cursor:pointer;">Cấu hình phí mua bán trên Azibai</a>
                        
			        </div>
			        <!--2st drop down menu -->
			        <div id="dropmenu2" class="dropmenudiv">
			            <!--<a onclick="ActionLink('< ?php echo base_url(); ?>administ/field')" style="cursor:pointer;">< ?php echo $this->lang->line('field_category_menu'); ?></a>-->
			          <a onclick="ActionLink('<?php echo base_url(); ?>administ/newsletter')" style="cursor:pointer;">Danh sách Email đăng ký</a>
			            <!--<a onclick="ActionLink('<?php echo base_url(); ?>administ/menu')" style="cursor:pointer;"><?php echo $this->lang->line('menu_category_menu'); ?></a>-->
                          <?php /*?><a onclick="ActionLink('<?php echo base_url(); ?>administ/manufacturer')" style="cursor:pointer;"><?php echo $this->lang->line('menu_manufacture_menu'); ?></a><?php */?>
			           
			        </div>
                    <div id="dropmenu11" class="dropmenudiv">
			           <a onclick="ActionLink('<?php echo base_url(); ?>administ/advertise')" style="cursor:pointer;"><?php echo $this->lang->line('advertise_category_menu'); ?></a>
			           <a onclick="ActionLink('<?php echo base_url(); ?>administ/advertiseconfig')" style="cursor:pointer;">Vị trí banner</a>
			           <a onclick="ActionLink('<?php echo base_url(); ?>administ/advertise-statistics')" style="cursor:pointer;">Thống kê lượt click</a>

			        </div>
                    <div id="dropmenu12" class="dropmenudiv">
                    <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/uprated')" style="cursor:pointer;">Chờ lên cấp</a>
                    <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/noactive')" style="cursor:pointer;">Chờ kích hoạt</a>
                     <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/allusertree')" style="cursor:pointer;">Hệ thống dạng danh sách</a>
                      <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/usertreetree/624')" style="cursor:pointer;">Hệ thống dạng Cây</a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/developer2')" style="cursor:pointer;"><?php echo $this->lang->line('user_member_menu')." Developer 2"; ?></a>
                        
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/developer1')" style="cursor:pointer;"><?php echo $this->lang->line('user_member_menu')." Developer 1"; ?></a>
                        
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/partner2')" style="cursor:pointer;"><?php echo $this->lang->line('user_member_menu')." Partner 2"; ?></a>
                        
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/partner1')" style="cursor:pointer;"><?php echo $this->lang->line('user_member_menu')." Partner 1"; ?></a>
                        
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/coremember')" style="cursor:pointer;"><?php echo "Core Member"; ?></a> 
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/coreadmin')" style="cursor:pointer;"><?php echo "Core Admin"; ?></a> 
                        
   
                       </div>
			        <!--3st drop down menu -->
			        <div id="dropmenu3" class="dropmenudiv">
                    		<a onclick="ActionLink('<?php echo base_url(); ?>administ/user/alluser')" style="cursor:pointer;">Tất cả thành viên</a>
			            <!-- <a onclick="ActionLink('<?php echo base_url(); ?>administ/user')" style="cursor:pointer;"><?php echo $this->lang->line('user_member_menu')." thường"; ?></a> -->
			           <!-- <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/affiliate')" style="cursor:pointer;">Thành viên Affiliate</a> -->
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/shopfree')" style="cursor:pointer;"><?php echo "Gian hàng miễn phí"; ?></a>
                         <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/shoppremium')" style="cursor:pointer;"><?php echo "Gian hàng có phí"; ?></a>
                        <!-- <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/admin')" style="cursor:pointer;"><?php echo "Admin"; ?></a> -->
                        
			           <?php /*?> <a onclick="ActionLink('<?php echo base_url(); ?>administ/user/end')" style="cursor:pointer;"><?php echo $this->lang->line('end_user_member_menu'); ?></a><?php */?>
			            <?php /*?><a onclick="ActionLink('<?php echo base_url(); ?>administ/user/inactive')" style="cursor:pointer;"><?php echo $this->lang->line('inactive_user_member_menu'); ?></a><?php */?>
                         			            <?php /*?><a onclick="ActionLink('<?php echo base_url(); ?>administ/user/vip')" style="cursor:pointer;"><?php echo $this->lang->line('vip_member_menu'); ?></a><?php */?>
			            <?php /*?><a onclick="ActionLink('<?php echo base_url(); ?>administ/user/vip/end')" style="cursor:pointer;"><?php echo $this->lang->line('end_vip_member_menu'); ?></a><?php */?>
			            
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/group')" style="cursor:pointer;"><?php echo $this->lang->line('group_member_menu'); ?></a>
			        </div>
			        <!--4st drop down menu -->
			        <div id="dropmenu4" class="dropmenudiv">
                        <!--<a onclick="ActionLink('<?php echo base_url(); ?>administ/shop/danhmuc')" style="cursor:pointer;">Danh mục gian hàng</a>-->
                 		<a onclick="ActionLink('<?php echo base_url(); ?>administ/shop/all')" style="cursor:pointer;">Tất cả gian hàng</a>

			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/shop')" style="cursor:pointer;"><?php echo $this->lang->line('shop_shop_menu')." đã kích hoạt"; ?></a>
			           <?php /*?> <a onclick="ActionLink('<?php echo base_url(); ?>administ/shop/end')" style="cursor:pointer;"><?php echo $this->lang->line('end_shop_shop_menu'); ?></a><?php */?>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/shop/noactive')" style="cursor:pointer;">Gian hàng chưa kích hoạt</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/shop/statistical')" style="cursor:pointer;">Doanh số Gian hàng</a>
			        </div>

                <div id="dropmenu70" class="dropmenudiv">                        
                    <a onclick="ActionLink('<?php echo base_url(); ?>administ/branch/all')" style="cursor:pointer;">Tất cả chi nhánh</a>                    
                    <a onclick="ActionLink('<?php echo base_url(); ?>administ/branch/statistical')" style="cursor:pointer;">Doanh số chi nhánh</a>
                </div>

                    <div id="dropmenu13" class="dropmenudiv">
                      <!--  <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/confirm_order_saler')" style="cursor:pointer;">Xác nhận giao hàng</a>-->
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/news_order_saler/product')" style="cursor:pointer;">Đơn hàng mới</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/notpay_order_saler/product')" style="cursor:pointer;">Đơn hàng chưa thanh toán</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/pay_order_saler/product')" style="cursor:pointer;">Đơn hàng đã thanh toán</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/inprogress_order_saler/product')" style="cursor:pointer;">Đơn hàng đang vận chuyển</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/success_order_saler/product')" style="cursor:pointer;">Đơn hàng đã giao hàng</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/notsuccess_order_saler/product')" style="cursor:pointer;">Giao hàng không thành công</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/re_order_saler/product')" style="cursor:pointer;">Đơn hàng đã nhận lại hàng</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/complain_order_saler/product')" style="cursor:pointer;">Đơn hàng đang khiếu nại</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/cancel_order_saler/product')" style="cursor:pointer;">Đơn hàng bị hủy</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/done_order_saler/product')" style="cursor:pointer;">Đơn hàng đã hoàn thành</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/refundOrders/product')" style="cursor:pointer;">Đơn hàng hoàn tiền</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/allorder/product')" style="cursor:pointer;">Tất cả đơn hàng</a>
			        </div>
                     <div id="dropmenu60" class="dropmenudiv">
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/confirm_order_checkout/service')" style="cursor:pointer;">Xác nhận Thanh toán</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/news_order_saler/service')" style="cursor:pointer;">Đơn hàng mới</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/notpay_order_saler/service')" style="cursor:pointer;">Đơn hàng chưa thanh toán</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/pay_order_saler/service')" style="cursor:pointer;">Đơn hàng đã thanh toán</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/cancel_order_saler/service')" style="cursor:pointer;">Đơn hàng bị hủy</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/done_order_saler/service')" style="cursor:pointer;">Đơn hàng đã hoàn thành</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/allorder/service')" style="cursor:pointer;">Tất cả đơn hàng</a>
			        </div>
					<?php if($this->session->userdata('sessionUserAdmin') == 3026){ ?>
					<div id="dropmenu61" class="dropmenudiv">
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/confirm_order_checkout/coupon')" style="cursor:pointer;">Xác nhận Thanh toán</a>
                    </div>
					<?php } else {?>
                     <div id="dropmenu61" class="dropmenudiv">
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/confirm_order_checkout/coupon')" style="cursor:pointer;">Xác nhận Thanh toán</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/news_order_saler/coupon')" style="cursor:pointer;">Đơn hàng mới</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/notpay_order_saler/coupon')" style="cursor:pointer;">Đơn hàng chưa thanh toán</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/pay_order_saler/coupon')" style="cursor:pointer;">Đơn hàng đã thanh toán</a>


                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/cancel_order_saler/coupon')" style="cursor:pointer;">Đơn hàng bị hủy</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/done_order_saler/coupon')" style="cursor:pointer;">Đơn hàng đã hoàn thành</a>

                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/showcart/allorder/coupon')" style="cursor:pointer;">Tất cả đơn hàng</a>
			        </div>
					<?php } ?>
                    <div id="dropmenu14" class="dropmenudiv">
                 		<a onclick="ActionLink('<?php echo base_url(); ?>administ/share')" style="cursor:pointer;">Thống kê lượt chia sẻ</a>			                                      
                 		<a onclick="ActionLink('<?php echo base_url(); ?>administ/notify/share')" style="cursor:pointer;">Danh sách link cần chia sẻ</a>
			        </div>
                    <div id="dropmenu16" class="dropmenudiv">
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/revenue')" style="cursor:pointer;">Xem doanh số</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/commission')" style="cursor:pointer;">Xem hoa hồng</a>
                    </div>
                    
			        <!--5st drop down menu -->
			        <div id="dropmenu5" class="dropmenudiv">
                  <a onclick="ActionLink('<?php echo base_url(); ?>administ/category')" style="cursor:pointer;"><?php echo $this->lang->line('category_category_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/product')" style="cursor:pointer;">Tất cả sản phẩm</a>

			           <!-- <a onclick="ActionLink('<?php echo base_url(); ?>administ/product/end')" style="cursor:pointer;"><?php echo $this->lang->line('end_product_product_menu'); ?></a>-->
			          <!--  <a onclick="ActionLink('<?php /*echo base_url(); */?>administ/product/bad')" style="cursor:pointer;"><?php /*echo $this->lang->line('bad_product_product_menu'); */?></a>-->
                         <!--<a onclick="ActionLink('<?php /*echo base_url(); */?>administ/product/hethang')" style="cursor:pointer;">Sản phẩm hết hàng</a>-->
			        </div>
              <div id="dropmenu50" class="dropmenudiv">
                    	<a onclick="ActionLink('<?php echo base_url(); ?>administ/category/service')" style="cursor:pointer;">Danh mục Dịch vụ</a>
			                <a onclick="ActionLink('<?php echo base_url(); ?>administ/service/product')" style="cursor:pointer;">Tất cả Dịch vụ</a>
			        </div>
              <div id="dropmenu51" class="dropmenudiv">
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/category/coupon')" style="cursor:pointer;">Danh mục Coupon</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/coupon/product')" style="cursor:pointer;">Tất cả Coupon</a>
			        </div>

			        <!--6st drop down menu -->
			        <?php /*?><div id="dropmenu6" class="dropmenudiv">
                    	<a onclick="ActionLink('<?php echo base_url(); ?>administ/adscategory')" style="cursor:pointer;"><?php echo $this->lang->line('category_ads_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/ads')" style="cursor:pointer;"><?php echo $this->lang->line('ads_ads_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/ads/end')" style="cursor:pointer;"><?php echo $this->lang->line('end_ads_ads_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/ads/bad')" style="cursor:pointer;"><?php echo $this->lang->line('bad_ads_ads_menu'); ?></a>
			        </div><?php */?>
			        <!--7st drop down menu -->
			      <?php /*?> <div id="dropmenu7" class="dropmenudiv">
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/hoidap/category')" style="cursor:pointer;"><?php echo $this->lang->line('hoidap_cat_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/hoidap')" style="cursor:pointer;"><?php echo $this->lang->line('hoidap_hoidap_menu'); ?></a>
                            <a onclick="ActionLink('<?php echo base_url(); ?>administ/hoidap/theodoi')" style="cursor:pointer;">Theo dõi</a>
                             <a onclick="ActionLink('<?php echo base_url(); ?>administ/hoidap/traloi')" style="cursor:pointer;">Trả lời</a>
                             <a onclick="ActionLink('<?php echo base_url(); ?>administ/hoidapvipham')" style="cursor:pointer;">Hỏi đáp vi phạm</a>
                              <a onclick="ActionLink('<?php echo base_url(); ?>administ/traloivipham')" style="cursor:pointer;">Trả lời vi phạm</a>
			        </div><?php */?>
			        <!--8st drop down menu -->
                    <?php /*?> <div id="dropmenu12" class="dropmenudiv">
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/field')" style="cursor:pointer;"><?php echo $this->lang->line('danh_muc_tuyen_dung'); ?></a>	
                            <a onclick="ActionLink('<?php echo base_url(); ?>administ/job')" style="cursor:pointer;"><?php echo $this->lang->line('tin_tuyen_dung'); ?></a>		
                            <a onclick="ActionLink('<?php echo base_url(); ?>administ/job/end')" style="cursor:pointer;"><?php echo $this->lang->line('tin_tuyen_dung_het_han'); ?></a>	 
                             <a onclick="ActionLink('<?php echo base_url(); ?>administ/job/bad')" style="cursor:pointer;"><?php echo $this->lang->line('tin_tuyen_dung_xau'); ?></a>	
                            
                              <a onclick="ActionLink('<?php echo base_url(); ?>administ/employ')" style="cursor:pointer;"><?php echo $this->lang->line('tin_tim_viec'); ?></a> 
                                <a onclick="ActionLink('<?php echo base_url(); ?>administ/employ/end')" style="cursor:pointer;"><?php echo $this->lang->line('tin_tim_viec_het_han'); ?></a> 
                                  <a onclick="ActionLink('<?php echo base_url(); ?>administ/employ/bad')" style="cursor:pointer;"><?php echo $this->lang->line('tin_tim_viec_xau'); ?></a>                              
			        </div>  <?php */?>                  
			        <div id="dropmenu8" class="dropmenudiv">
                    <!--lien ket den thu lien he-->
    <a onclick="ActionLink('<?php echo base_url(); ?>administ/reports/content')" style="cursor:pointer;"><?php echo $this->lang->line('report_content_info_menu'); ?></a>
    <a onclick="ActionLink('<?php echo base_url(); ?>administ/reports/product')" style="cursor:pointer;"><?php echo $this->lang->line('report_product_info_menu'); ?></a>
    <a onclick="ActionLink('<?php echo base_url(); ?>administ/contact')" style="cursor:pointer;"><?php echo $this->lang->line('contact_info_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/notify')" style="cursor:pointer;"><?php echo $this->lang->line('notify_info_menu'); ?></a>
                  <a onclick="ActionLink('<?php echo base_url(); ?>administ/content')" style="cursor:pointer;">Bài viết</a>
                  <a onclick="ActionLink('<?php echo base_url(); ?>administ/ctcategory')" style="cursor:pointer;">Danh mục bài viết</a>
                  <a onclick="ActionLink('<?php echo base_url(); ?>administ/tintuc')" style="cursor:pointer;">Tin tức Doanh nghiệp viết</a>
                  <a onclick="ActionLink('<?php echo base_url(); ?>administ/ttcategory')" style="cursor:pointer;">Danh mục Doanh nghiệp viết</a>
                  <a onclick="ActionLink('<?php echo base_url(); ?>administ/doc')" style="cursor:pointer;">Tài liệu</a>
                  <a onclick="ActionLink('<?php echo base_url(); ?>administ/doccategory')" style="cursor:pointer;">Danh mục tài liệu</a>
                  <?php /*?><a onclick="ActionLink('<?php echo base_url(); ?>administ/cohoi')" style="cursor:pointer;">Các cơ hội</a>
                  <a onclick="ActionLink('<?php echo base_url(); ?>administ/chcategory')" style="cursor:pointer;">Danh mục cơ hội</a><?php */?>
			       
              </div>

                    <div id="dropmenu100" class="dropmenudiv">

                        <!--<a onclick="ActionLink('<?php /*echo base_url(); */?>administ/service')" style="cursor:pointer;">Dịch vụ người dùng</a>-->
                        <!--<a onclick="ActionLink('<?php /*echo base_url(); */?>administ/service/request')" style="cursor:pointer;">Dịch vụ đang yêu cầu</a>
                        <a onclick="ActionLink('<?php /*echo base_url(); */?>administ/service/paymented')" style="cursor:pointer;">Dịch vụ đã thanh toán</a>-->
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/service/using')" style="cursor:pointer;">Dịch vụ đang sử dụng</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/service/expiring')" style="cursor:pointer;">Dịch vụ sắp hết hạn</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/service/expired')" style="cursor:pointer;">Dịch vụ hết hạn</a>
                        <!--<a onclick="ActionLink('<?php /*echo base_url(); */?>administ/service/cancel')" style="cursor:pointer;">Dịch vụ bị hủy</a>-->
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/service/list')" style="cursor:pointer;">Danh sách dịch vụ</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/service/package')" style="cursor:pointer;">Danh sách gói</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/service/simple')" style="cursor:pointer;">Dịch vụ sử dụng 1 lần</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/service/daily_service')" style="cursor:pointer;">Dịch vụ đăng tin/ Ký gửi hàng online</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/service/group')" style="cursor:pointer;">Mô tả dịch vụ</a>
                    </div>
                    
                    <div id="dropmenu15" class="dropmenudiv">
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/shop/af')" style="cursor:pointer;">Tất cả cộng tác viên</a>
                         <a onclick="ActionLink('<?php echo base_url(); ?>administ/affiliate/shop')" style="cursor:pointer;">Doanh số cộng tác viên</a>

                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/product/affiliate')" style="cursor:pointer;">Sản phẩm, phiếu mua hàng cho cộng tác viên</a>
                     </div>
			        <!--9st drop down menu -->
			        <div id="dropmenu9" class="dropmenudiv">
			           <!--  <a onclick="ActionLink('<?php //echo base_url(); ?>administ/tool/mail')" style="cursor:pointer;"><?php //echo $this->lang->line('mail_tool_menu'); ?></a> -->
                  <a onclick="ActionLink('<?php echo base_url(); ?>administ/tool/mediamanage')" style="cursor:pointer;">Upload Image</a>
                  <a onclick="ActionLink('<?php echo base_url(); ?>administ/tool/unlocked')" style="cursor:pointer;"><?php echo $this->lang->line('clear_cache_tool_unlocked'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/tool/cache')" style="cursor:pointer;"><?php echo $this->lang->line('clear_cache_tool_menu'); ?></a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/tool/captcha')" style="cursor:pointer;"><?php echo $this->lang->line('clear_captcha_tool_menu'); ?></a>
			        </div>

                     <?php /*?><div id="dropmenu10" class="dropmenudiv">
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/uptin/naptien')" style="cursor:pointer;">Nạp tiền thành viên</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/uptin/suanaptien')" style="cursor:pointer;">Chỉnh sửa nạp tiền</a>
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/uptin/giaup')" style="cursor:pointer;">cấu hình giá</a>
			            <a onclick="ActionLink('<?php echo base_url(); ?>administ/uptin/thongke')" style="cursor:pointer;">Thống kê giao dịch</a>	
                        <a onclick="ActionLink('<?php echo base_url(); ?>administ/uptin/thongkedondatnaptien')" style="cursor:pointer;">Đơn đặt nạp tiền</a>		           
			        </div> <?php */?>                   
                </td>
                <td width="2" height="27" valign="top"></td>
            </tr>
        </table>
    </td>
</tr>
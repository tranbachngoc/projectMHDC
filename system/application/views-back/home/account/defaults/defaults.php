<?php
    $group_id = (int) $this->session->userdata('sessionGroup');
    $this->load->view('home/common/account/header');
?>
<div id="panel_accout" class="container-fluid"> 
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
	<!--BEGIN: RIGHT-->
	<div class="col-md-9 col-sm-8 col-xs-12">
	    <?php if ($group_id == 1) { ?>
		<div style="padding: 10px; border: solid 1px #00aaaa; margin-bottom: 20px">
		    <p><b>Bạn muốn có thêm thu nhập hàng tháng?</b> Tham gia bán hàng online cùng Azibai</p>
		    <p><i class="fa fa-hand-o-right" aria-hidden="true fa-fw"></i> Kinh doanh không cần vốn đầu tư, không cần cửa hàng</p>
		    <p><i class="fa fa-hand-o-right" aria-hidden="true fa-fw"></i> Công việc đơn giản, dễ thực hiện</p>
		    <p><i class="fa fa-hand-o-right" aria-hidden="true fa-fw"></i> Hoa hồng bán hàng minh bạch rõ ràng</p>
		    <p>Click <a class="text-primary" href="<?php echo base_url() . 'account/affiliate/upgrade' ?>">vào đây</a> để nâng cấp tài khoản <b>Cộng tác viên online</b> trên Azibai và tham gia bán hàng ngay bây giờ!</p>
		</div>
	    <?php } ?>
	    <?php
	    if ($flash_message) {
		?>
		<div class="message success">
		    <div class="alert alert-success">
			<?php echo $flash_message; ?>
			<button type="button" class="close" data-dismiss="alert">×</button>
		    </div>
		</div>
		<?php
	    }
	    ?>
	    <!-- Thông báo lỗi nếu có -->
	    <?php if ($this->session->flashdata('sessionEror')) { ?>
		<br>
		<div class="message success">
		    <div class="alert alert-danger">
			<?php echo $this->session->flashdata('sessionEror'); ?>
			<button type="button" class="close" data-dismiss="alert">×</button>
		    </div>
		</div>
	    <?php } ?>
	    <!-- Thông báo lỗi nếu có -->
	<div class="cpanel">
	    <div class="row">
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
		    <a class="menu_1" href="<?php echo base_url(); ?>account/edit">
			<img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" border="0">
			<div class="title_menu_account">Thành viên</div>
		    </a>
		</div>

		<!-- <?php if ($group_id != StaffUser) { ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/notify">
			    <img src="<?php echo base_url(); ?>templates/home/images/icon/noi-icon.png" border="0">
			    <?php if ($notify > 0) { ?>
				<span class="badge"><?php echo $notify; ?></span>
			    <?php } ?>
			    <div class="title_menu_account"><?php echo $this->lang->line('notify_account_defaults'); ?></div>
			</a>
		    </div>
		<?php } ?> -->

		<!-- <?php if ($group_id != StaffUser) { ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/contact">
			    <img src="<?php echo base_url(); ?>templates/home/images/icon/email-icon.png" border="0">
			    <?php if ($contact > 0) { ?>
				<span class="badge"><?php echo $contact; ?></span>
			    <?php } ?>
			    <div class="title_menu_account">Tin nhắn</div>
			</a>
		    </div>
		<?php } ?> -->
		<?php
		if ($group_id == AffiliateStoreUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/shop"> <img
				src="<?php echo base_url(); ?>templates/home/images/icon/settings-icon.png" border="0">

			    <div class="title_menu_account">Cài đặt gian hàng</div>
			</a>
		    </div>
		<?php } ?>
		<?php
		if ($group_id == AffiliateStoreUser || $group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser || $group_id == BranchUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/viewtasks/month/<?php echo date('m'); ?>">
			    <img src="<?php echo base_url(); ?>templates/home/images/icon/pen-icon.png" border="0">
			    <?php if ($tasklist > 0) { ?>
				<span class="badge"><?php echo $tasklist; ?></span>
			    <?php } ?>
			    <div class="title_menu_account">Phân công công việc</div>
			</a>
		    </div>
		<?php } ?>
		
		<?php if ($group_id == AffiliateStoreUser /* && !empty($sho_package) */) { ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/news">
			    <img src="<?php echo base_url(); ?>templates/home/images/icon/information-icon.png" border="0">
			    <div class="title_menu_account">Tin tức</div>
			</a>
		    </div>
		<?php } ?>
		
		

		<?php
		if ($group_id == NormalUser //|| $group_id == AffiliateUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/user_order">
			    <img  src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png" border="0">
			    <?php if ($totalOrderUser > 0) { ?>
				<span class="badge"><?php echo $totalOrderUser; ?></span>
			    <?php } ?>
			    <div class="title_menu_account"><?php echo $this->lang->line('showcart_account_defaults'); ?></div>
			</a>
		    </div>
		<?php } ?>
		<?php if ($group_id == AffiliateUser) { ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/affiliate/products">
			    <img src="<?php echo base_url(); ?>templates/home/images/icon/cart-add-icon.png" border="0">
			    <div class="title_menu_account">Kho hàng</div>
			</a>
		    </div>
		<?php } ?>
		
		<?php
		if ($group_id == AffiliateStoreUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/product/product">
			    <img src="<?php echo base_url(); ?>templates/home/images/icon/shopping-icon.png" border="0">
			    <div class="title_menu_account"><?php echo $this->lang->line('product_account_defaults'); ?></div>
			</a>
		    </div>
		
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/product/coupon">
			    <img src="<?php echo base_url(); ?>templates/home/images/icon/shopping-icon.png" border="0">
			    <div class="title_menu_account">COUPON</div>
			</a>
		    </div>
		<?php } ?>
		<?php
		if ($group_id != StaffUser && $group_id == AffiliateStoreUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/order">
			    <img  src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png" border="0">
			    <?php if ($totalOrder > 0) { ?>
				<span class="badge"><?php echo $totalOrder; ?></span>
			    <?php } ?>
			    <div class="title_menu_account"><?php echo $this->lang->line('showcart_account_defaults'); ?></div>
			</a>
		    </div>
		<?php } ?>
		<?php if ($group_id == AffiliateUser) { ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/affiliate/orders">
			    <img src="<?php echo base_url(); ?>templates/home/images/icon/share-2-icon.png" border="0">
			    <div class="title_menu_account">Đơn hàng CTV</div>
			</a>
		    </div>
		<?php } ?>
		<?php
		if ($group_id == AffiliateStoreUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/customer">
			    <img src="<?php echo base_url(); ?>templates/home/images/icon/people-icon.png" border="0">
			    <div class="title_menu_account">Khách hàng</div>
			</a>
		    </div>
		<?php } ?>
		<?php
		if ($group_id == AffiliateStoreUser || $group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser || $group_id == AffiliateUser || $group_id == BranchUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/statistic">
			    <img src="<?php echo base_url(); ?>templates/home/images/icon/analytics-icon.png" border="0">
			    <div class="title_menu_account">Thống kê chung</div>
			</a>
		    </div>
		<?php } ?>
		<?php
		if ($group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/tree"> <img
				src="<?php echo base_url(); ?>templates/home/images/icon/treesystem-icon.png" border="0">
			    <div class="title_menu_account">Cây hệ thống</div>
			</a>
		    </div>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/tree">
			    <img  src="<?php echo base_url(); ?>templates/home/images/icon/analytics-icon.png" border="0">
			    <?php if ($totamember > 0) { ?>
				<span class="badge"><?php echo $totamember; ?></span>
			    <?php } ?>
			    <div class="title_menu_account">Thành viên mới đăng ký</div>
			</a>
		    </div>
		<?php } ?>
		<?php
		if ($group_id == AffiliateUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/income/user"> <img
				src="<?php echo base_url(); ?>templates/home/images/icon/income-icon.png" border="0">

			    <div class="title_menu_account">Thu nhập CTV</div>
			</a>
		    </div>
		<?php } ?>
		<!-- Thu nhap gian hang -->
		<?php
		if ($group_id == AffiliateStoreUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/income/user"> <img
				src="<?php echo base_url(); ?>templates/home/images/icon/income-icon.png" border="0">

			    <div class="title_menu_account">Thu nhập Gian hàng</div>
			</a>
		    </div>
		<?php } ?>
		<!-- Thu nhap chi nhanh -->
		<?php
		if ($group_id == BranchUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/income/user"> <img
				src="<?php echo base_url(); ?>templates/home/images/icon/income-icon.png" border="0">

			    <div class="title_menu_account">Thu nhập Chi nhánh</div>
			</a>
		    </div>
		<?php } ?>

		<?php
		if ($group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/income/user"> <img
				src="<?php echo base_url(); ?>templates/home/images/icon/income-icon.png" border="0">

			    <div class="title_menu_account">Thu nhập Cộng tác viên</div>
			</a>
		    </div>
		<?php } ?>

		<?php
		if ($group_id == AffiliateStoreUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/service/using"> <img
				src="<?php echo base_url(); ?>templates/home/images/icon/favourite-heart-icon.png" border="0">

			    <div class="title_menu_account">Dịch vụ Azibai</div>
			</a>
		    </div>
		<?php } ?>
		
		

		<?php
		if ($group_id == StaffUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/viewtasks/month/<?php echo date('m'); ?>"> <img
				src="<?php echo base_url(); ?>templates/home/images/icon/pen-icon.png" border="0">
				<?php if ($tasklist > 0) { ?>
				<span class="badge"><?php echo $tasklist; ?></span>
			    <?php } ?>
			    <div class="title_menu_account">Phân công từ Gian hàng</div>
			</a>
		    </div>
		<?php } ?>
		<?php
		if ($group_id == AffiliateStoreUser || $group_id == Developer2User || $group_id == Developer1User || $group_id == Partner2User || $group_id == Partner1User || $group_id == CoreMemberUser || $group_id == CoreAdminUser || $group_id == AffiliateUser || $group_id == BranchUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/docs/31/huong-dan-cach-lam-viec.html"> <img
				src="<?php echo base_url(); ?>templates/home/images/icon/folder-icon.png" border="0">
			    <div class="title_menu_account">Tài liệu</div>
			</a>
		    </div>
		<?php } ?>
		
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
		    <a class="menu_1" href="<?php echo base_url(); ?>account/sharelist">
			<img  src="<?php echo base_url(); ?>templates/home/images/icon/share-2-icon.png" border="0">
			<?php if ($sharelink > 0) { ?>
			    <span class="badge"><?php echo $sharelink; ?></span>
			<?php } ?>
			<div class="title_menu_account">Chia sẻ link</div>
		    </a>
		</div>
		<?php
		if ($group_id == AffiliateStoreUser || $group_id == BranchUser
		) {
		    ?>
		    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
			<a class="menu_1" href="<?php echo base_url(); ?>account/complaintsOrders">
			    <img  src="<?php echo base_url(); ?>templates/home/images/icon/dislike-icon.png" border="0">
			    <?php if (count($listComplaintsOrders) > 0) { ?>
				<span class="badge"><?php echo count($listComplaintsOrders); ?></span>
			    <?php } ?>
			    <div class="title_menu_account">Yêu cầu khiếu nại</div>
			</a>
		    </div>
		<?php } ?>
		<div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
		    <a class="menu_1" href="<?php echo base_url(); ?>logout/">
			<img  src="<?php echo base_url(); ?>templates/home/images/icon/stop-icon.png" border="0">
			<div class="title_menu_account">Đăng xuất</div>
		    </a>
		</div>
	    </div>
	</div>

	</div>
    </div>
</div>

<script>
      $(document).ready(function()
        {
            close_outside('.menu-dropdown-horizontal','.dropdown-menu-custom');
        });
</script>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

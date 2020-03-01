<?php $this->load->view('home/common/header'); ?>

	<div class="container">
		<div class="row">
			<?php $this->load->view('home/common/left'); ?>
			<!--BEGIN: RIGHT-->
			<div class="col-lg-9 col-md-9 col-sm-8 cpanel">
				<div class="row text-center">
					<div class="col-lg-3">
						<a class="menu_1" href="<?php echo base_url(); ?>account/affiliate/products">
							<img src="<?php echo base_url() ?>templates/home/images/icon/shopping-icon.png"/><br/>
							<strong>Sản phẩm Cộng Tác Viên Online</strong>
						</a>
					</div>
					<div class="col-lg-3">
						<a class="menu_1"  href="<?php echo base_url(); ?>account/affiliate/myproducts">
							<img src="<?php echo base_url() ?>templates/home/images/icon/cart-icon.png"/><br/>
							<strong>Sản phẩm đang bán</strong>
						</a>
					</div>

					<div class="col-lg-3">
						<a class="menu_1"  href="<?php echo base_url(); ?>account/affiliate/orders">
							<img src="<?php echo base_url() ?>templates/home/images/icon/shopping-icon.png"/><br/><strong>Đơn hàng Cộng Tác Viên Online</strong>
						</a>
					</div>
					<div class="col-lg-3">
						<a  class="menu_1" href="<?php echo base_url(); ?>account/affiliate/statistic">
							<img src="<?php echo base_url() ?>templates/home/images/icon/analytics-icon.png"/><br/>
							<strong>Thống kê Cộng Tác Viên Online</strong>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php $this->load->view('home/common/footer'); ?>
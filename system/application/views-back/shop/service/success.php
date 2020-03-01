<link href="/templates/shop/css/service.css" rel="stylesheet" type="text/css" />
<div class="successfull-mess">
	<?php if ($msg == 2) { ?> 
	<div class="icon-check">
		<i class="fa fa-check" aria-hidden="true"></i>
	</div>
	<p>Bạn đã thanh toán thành công</p>
	<div class="button-groups">
	  <a href="<?php echo base_url(); ?>" class="btn btn-border-pink">Trang Chủ</a>
	  	<?php if (!empty($package)) { ?>
		  <?php if ($package == 16) { ?>
		  <a href="/page-business?new_branch=1" class="btn btn-bg-pink ml20">Mở chi nhánh ngay</a>
		  <?php } else if ($package == 18) { ?>
		  <a href="/account/shop/domain" class="btn btn-bg-pink ml20">Cấu hình tên miền riêng ngay</a>
		  <?php } ?>
		<?php } ?>
	</div>
	<?php } else { ?>
	<div class="icon-check">
		<i class="fa fa-times" aria-hidden="true"></i>
	</div>
	<p>Bạn đã thanh toán thất bại</p>
	<div class="button-groups">
	  <a href="<?php echo base_url(); ?>" class="btn btn-border-pink">Trang Chủ</a>
	</div>
	<?php } ?>
</div>
<style>
    #header{ display: none;}
    ul.menu-shop li:hover > a,
    ul.menu-shop li.active > a{ background: #f6f7f9;}
    ul.menu-shop li li a { padding: 5px 5px 5px 15px; margin-top: 1px;}
</style>

<script>
    jQuery(function($){
        $('ul.menu-shop > li a').click( function(){ $(this).next().slideToggle(); });
    });
</script>

<?php 
    $shop_af = $this->user_model->get('use_group', "use_id = " . (int) $siteGlobal->sho_user);
?>
<div class="fixtoscroll">
	<ul class="nav menu-shop">
		<li class="<?php echo (!empty($menuSelected) && $menuSelected == 'home') ? 'active' : ''; ?> ">
			<a target="_self" href="/" >
				<span>Trang chủ</span>
			</a>
		</li>
		<li>
			<a target="_self" href="/shop/introduct">
				<span>Giới thiệu</span>
			</a>
		</li>
		<li>
			<a target="_self" href="/shop">
				<span>Cửa hàng</span>
			</a>
		</li>
		<li>
			<a  href="#">
				<?php echo $this->lang->line('product_menu_detail_global'); ?>
				<i class="pull-right fa fa-angle-down fa-fw"></i>
			</a>

			<ul class="nav small" style="padding-left: 20px; display: none;">
				<?php if ($shop_af->use_group == 2) { ?>
					<li><a href="/shop/san-pham-tu-gian-hang/">Sản phẩm từ Gian hàng</a></li>
				<?php } ?>

				<?php
				foreach ($listCategory as $k => $category) {
					if ($category->cate_type == 0) { ?>
						<li>
							<?php if (!empty($category->child)) { ?>
								<span><?php echo $category->cat_name; ?></span>
								<ul>
									<?php foreach ($category->child as $item) { ?>
										<li><a href="<?php echo '/shop/' . $tlink . '/cat/' . $item->cat_id . '-' . RemoveSign($item->cat_name); ?>"><?php echo $item->cat_name; ?></a></li>
									<?php } ?>
								</ul>
							<?php } else { ?>
								<a href="<?php echo '/shop/' . $tlink . '/cat/' . $category->cat_id . '-' . RemoveSign($category->cat_name); ?>"><?php echo $category->cat_name; ?></a>
							<?php } ?>
						</li>
					<?php } ?>
				<?php } ?>
				
				<li><?php if ($shop_af->use_group == 2) { ?>
						<a class="hover" href="<?php echo '/shop/' . $tlink . '/pro_type/0-Tat-ca-san-pham' ?>">Xem tất cả sản phẩm</a></li>
				<?php } else { ?>
					<a class="hover" href="<?php echo '/shop/' . $tlink ?>">Xem tất cả sản phẩm</a></li>
		<?php } ?>
	</ul>
	</li>
	<?php if (serviceConfig == 1) { ?>
		<li class="<?php echo $url == 'services' ? 'active' : 'normal'; ?>">
			<a  href="#">
				Dịch vụ
				<i class="pull-right fa fa-angle-down fa-fw"></i>
			</a>

			<ul class="nav small" style="padding-left: 20px; display: none;">
				<?php if ($shop_af->use_group == 2) { ?>
					<li><a href="/shop/dich-vu-tu-gian-hang/">Dịch vụ từ Gian hàng</a></li>
				<?php } ?>
				<?php
				foreach ($listCategory as $k => $category) {
					if ($category->cate_type == 1) {
						?>
						<li>
							<?php if (!empty($category->child)) { ?>
								<span><?php echo $category->cat_name; ?></span>
								<ul>
									<?php foreach ($category->child as $item) { ?>
										<li><a href="<?php echo '/services/cat/' . $item->cat_id . '-' . RemoveSign($item->cat_name); ?>"><?php echo $item->cat_name; ?></a></li>
									<?php } ?>
								</ul>
							<?php } else { ?>
								<a href="<?php echo '/services/cat/' . $category->cat_id . '-' . RemoveSign($category->cat_name); ?>"><?php echo $category->cat_name; ?></a>
							<?php } ?>
						</li>
					<?php } ?>
				<?php } ?>
				<li><a class="hover" href="<?php echo '/shop/services'; ?>">Xem tất cả dịch vụ</a></li>
			</ul>
		</li>
	<?php } ?>
		<li class="<?php echo $url == 'coupon' ? 'active' : 'normal'; ?>">
			<a href="#">Coupon<i class="pull-right fa fa-angle-down fa-fw"></i></a>
			<ul class="nav small" style="padding-left: 20px; display: none;">
				<?php foreach ($listCategory as $k => $category) {
					if ($category->cate_type == 2) { ?>
						<li>
							<?php if (!empty($category->child)) { ?>
								<span><?php echo $category->cat_name; ?></span>
								<ul>
									<?php foreach ($category->child as $item) { ?>
										<li><a href="<?php echo '/shop/' . $afLink . '/cat/' . $item->cat_id . '-' . RemoveSign($item->cat_name); ?>"><?php echo $item->cat_name; ?></a></li>
									<?php } ?>
								</ul>
							<?php } else { ?>
								<a href="<?php echo '/shop/' . $afLink . '/cat/' . $category->cat_id . '-' . RemoveSign($category->cat_name); ?>"><?php echo $category->cat_name; ?></a>
							<?php } ?>
						</li>
						<?php } ?>
				<?php } ?>
				<li><?php if ($shop_af->use_group == 2) { ?>
					<a class="hover" href="<?php echo '/shop/' . $afLink . '/pro_type/2-Tat-ca-coupon' ?>">Xem tất cả coupon</a></li>
				<?php } else { ?>
					<a class="hover" href="<?php echo '/shop/' . $afLink ?>">Xem tất cả coupon</a></li>
				<?php } ?>
			</ul>
		</li>

		<?php if ($shop_af->use_group != 2) { ?>
			<li class="<?php if (isset($menuSelected) && $menuSelected == 'warranty') { echo 'active';
			} else { echo 'normal'; } ?>">
				<a target="_self" href="/shop/warranty">
					<span><?php echo $this->lang->line('ads_menu_warranty_global'); ?></span></a>
			</li>
		<?php } ?>

		<li class="<?php if (isset($menuSelected) && $menuSelected == 'contact') { echo 'active';
		} else { echo 'normal'; } ?>">
			<a target="_self" href="/shop/contact">
				<span><?php echo $this->lang->line('contact_menu_detail_global'); ?></span></a>
		</li>

		<li>
			<a class="back_home" target="_blank" href="<?php echo $mainURL; ?>"><span>Azibai</span></a>
		</li>

	</ul>
</div>

<style>
.list-unstyled li span{font-weight: bold;}
</style>
<?php if(isset($siteGlobal)){ ?>
    <?php if (isset($listCategory)): ?>
        <div class="module">
            <h4 class="module-title">
                <i class="fa fa-list-ul" aria-hidden="true"></i> 
                <?php
				$url = $this->uri->segment(2);
				if ($url == 'services' || $url == 'afsevices') {
					echo 'Danh mục dịch vụ';
					$DM = 'Dịch vụ';
					$tc = 'Xem tất cả dịch vụ';
					$type = 'services';
					if ($url == 'afsevices') {
						$pro_type = 'services';
					}
				} elseif ($url == 'coupon' || $url == 'afcoupon') {
					echo 'Danh mục coupon';
					$DM = 'Coupon';
					$pro_type = '2-Tat-ca-coupon';
					$tc = 'Xem tất cả Coupon';
					$type = 'coupon';
				} elseif ($url == 'product' || $url == 'afproduct') {
					echo 'Danh mục sản phẩm';
					$DM = 'Sản phẩm';
					$tc = 'Xem tất cả Sản phẩm';
					$type = 'product';
					$pro_type = '0-Tat-ca-san-pham';
				} else {
					echo 'Danh mục';
					$DM = 'Danh mục';
					$tc = 'Xem tất cả Sản phẩm';
					$type = 'product';
					$pro_type = '0-Tat-ca-san-pham';
				}

				?>
            </h4>
            <div class="module-content">
                <ul class="list-unstyled">
                        <?php
                        foreach ($listCategory as $k => $category) { ?>
                                <li>
                                    <?php if ($category->child > 0) { ?>
                                        <span><?php echo $category->cat_name; ?></span>
                                        <ul class="list-unstyled" >
                                            <?php foreach ($category->child as $item) { ?>
                                                <li><a href="<?php echo '/shop/' . $url . '/cat/' . $item->cat_id . '-' . RemoveSign($item->cat_name); ?>"><?php echo $item->cat_name; ?></a></li>
                                            <?php } ?>
                                        </ul>
                                    <?php } else { ?>
                                        <a style="font-size: 14px; font-weight: normal;" href="<?php echo '/shop/' . $url . '/cat/' . $category->cat_id . '-' . RemoveSign($category->cat_name); ?>"><?php echo $category->cat_name; ?></a>
                                    <?php } ?>
                                </li>
                        <?php } ?>
					<?php
					$afproduct = $type;
					if($UserGroup==AffiliateUser && $url != 'services'){
						$afproduct = 'af'.$type.'/pro_type/'.$pro_type;
					}
					$cn='';
					if($CN_segment2 == BranchUser){
						$cn = '/'.$siteGlobal->sho_link;
					}
					?>
                        <li><a style="font-size: 14px; font-weight: normal;" href="<?php echo $cn?>/shop/<?php echo $afproduct?>"><?php echo $tc?></a></li>
                    </ul>
            </div>
        </div>	
    <?php endif; ?>

<?php if(isset($listcatnews)){ ?>
<div class="module">
	<h4 class="module-title">
		<i class="fa fa-newspaper-o" aria-hidden="true"></i> Danh mục tin tức</h4>
	<div class="module-content">
            <?php if($listcatnews):?>
                    <?php 		
                            $cat_id = strtolower($this->uri->segment(3));
                    ?>
                    <ul class="list-unstyled">			
                            <?php foreach($listcatnews as $cat) { ?>
                            <li><a href="/news/<?php echo $cat->cat_id ?>/<?php echo RemoveSign($cat->cat_name);?>" <?php if($cat_id==$cat->cat_id) echo 'selected="selected"';?>><?php echo $cat->cat_name ?></a></li>
                            <?php } //endforeach ?>			
                    </ul>
            <?php else: ?>
                    <a href="/news">Xem tất cả tin tức</a>
            <?php endif; ?>
		
	</div>
</div>
<?php } ?>

<?php if(isset($bannerlefts) && count($bannerlefts) > 0){ ?>
<div class="module">
	<h4 class="module-title"><?php echo $this->lang->line('title_advertise_left_detail_global'); ?></h4>
	<div class="module-content">
				<?php foreach($bannerlefts as $item){?>
				<?php if($item->banner_type == 1){?>
				<div style="text-align:center"> <a target="<?php echo $item->target;?>" href="http://<?php echo $item->link;?>" alt="<?php echo $item->banner_name;?>"> <img width="190" src="<?php echo $URLRoot; ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $item->content; ?>"/> </a> </div>
				<?php }elseif($item->banner_type == 2){$height = (190/$item->banner_width)*$item->banner_height;?>
				<div style="text-align:center">
					<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" style="width:190px; height:<?php echo $height;?>px;" id="FlashID_Banner">
						<param name="movie" value="<?php echo $URLRoot; ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $item->content; ?>" />
						<param name="quality" value="high" />
						<param name="wmode" value="opaque" />
						<param name="swfversion" value="6.0.65.0" />
						<param name="expressinstall" value="<?php echo $URLRoot; ?>templates/shop/style1/images/expressInstall.swf" />
						<!--[if !IE]>-->
						<object type="application/x-shockwave-flash" style="width:190px; height:<?php echo $height;?>px;" data="<?php echo $URLRoot; ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $item->content; ?>" class="banner_flash">
							<!--<![endif]-->
							<param name="quality" value="high" />
							<param name="wmode" value="opaque" />
							<param name="swfversion" value="6.0.65.0" />
							<param name="expressinstall" value="<?php echo $URLRoot; ?>templates/shop/style1/images/expressInstall.swf" />
							<div>
								<h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
								<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
							</div>
							<!--[if !IE]>-->
						</object>
						<!--<![endif]-->
					</object>
					<!--<script type="text/javascript" language="javascript"> swfobject.registerObject("FlashID_Banner");</script>--> </div>
				<?php }else{?>
				<div style="width:190px; margin-left:5px;"> <a target="<?php echo $item->target;?>" href="<?php echo $item->link;?>"> <?php echo htmlspecialchars_decode(html_entity_decode($item->content));?> </a> </div>
				<?php } ?>
				<?php } ?>
			</div>
</div>
<?php } ?>

<?php if($siteGlobal->sho_style =='style3'){ ?>

	<?php if(isset($module) && $module == 'top_lastest_ads'){ ?>
	<?php $this->load->view('shop/raovat/top_lastest'); ?>
	<?php } ?>
	<?php if(isset($module) && $module == 'top_lastest_product'){ ?>
	<?php $this->load->view('shop/product/top_lastest'); ?>
	<?php } ?>

<?php if(isset($bannerrights) && count($bannerrights) >0){?>
<div class="module">
	<h4 class="module-title"><?php echo $this->lang->line('title_advertise_right_detail_global'); ?></h4>
	<div class="module-content">
		<?php foreach($bannerrights as $item){?>
			<?php if($item->banner_type == 1){?>
				<div style="text-align:center"> <a target="<?php echo $item->target;?>" href="http://<?php echo $item->link;?>" alt="<?php echo $item->banner_name;?>"> <img width="190" src="<?php echo $URLRoot; ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $item->content; ?>"/> </a> </div>
				<?php }elseif($item->banner_type == 2){$height = (190/$item->banner_width)*$item->banner_height;?>
				<div style="text-align:center">
					<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" style="width:190px; height:<?php echo $height;?>px;" id="FlashID_Banner">
						<param name="movie" value="<?php echo $URLRoot; ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $item->content; ?>" />
						<param name="quality" value="high" />
						<param name="wmode" value="opaque" />
						<param name="swfversion" value="6.0.65.0" />
						<param name="expressinstall" value="<?php echo $URLRoot; ?>templates/shop/style1/images/expressInstall.swf" />
						<!--[if !IE]>-->
						<object type="application/x-shockwave-flash" style="width:190px; height:<?php echo $height;?>px;" data="<?php echo $URLRoot; ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $item->content; ?>" class="banner_flash">
							<!--<![endif]-->
							<param name="quality" value="high" />
							<param name="wmode" value="opaque" />
							<param name="swfversion" value="6.0.65.0" />
							<param name="expressinstall" value="<?php echo $URLRoot; ?>templates/shop/style1/images/expressInstall.swf" />
							<div>
								<h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
								<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
							</div>
							<!--[if !IE]>-->
						</object>
						<!--<![endif]-->
					</object>
					<!--<script type="text/javascript"> swfobject.registerObject("FlashID_Banner");</script>--> </div>
				<?php }else{?>
				<div style="width:190px; margin-left:5px;"> <a target="<?php echo $item->target;?>" href="<?php echo $item->link;?>"> <?php echo htmlspecialchars_decode(html_entity_decode($item->content));?> </a> </div>
				<?php } ?>
				<?php } ?>
			</div>
</div>			
<?php } ?>
<?php } ?>

    <div class="module">
        <h4 class="module-title"><i class="fa fa-bar-chart" aria-hidden="true"></i> Thống kê gian hàng</h4>
        <div class="module-content">
            <p><i class="fa fa-bar-chart fa-fw"></i> <?php echo $this->lang->line('access_footer_detail_global'); ?>: <span class="pull-right"><?php echo $siteGlobal->sho_view; ?></span></p>
            <p><i class="fa fa-calendar fa-fw"></i> Tham gia: <span class="pull-right"><?php echo date('d/m/Y', $siteGlobal->sho_begindate); ?></span></p>
            <?php if ($siteGlobal->sho_guarantee) { ?>
                <p><img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/icon_verified.png"> Gian hàng đảm bảo</p>
            <?php } ?>
        </div>
    </div>
<!--END Left-->
<?php } ?>

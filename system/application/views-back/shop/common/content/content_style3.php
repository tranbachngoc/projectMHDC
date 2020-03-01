<?php
	$shop_af = $this->user_model->get('use_group', "use_id = ".(int)$siteGlobal->sho_user);
	if($shop_af->use_group == 2){
		$stopslide = '';
	}else{
		$stopslide = 'data-interval="false"';
	}
	$select = '*';
	$start = 0;
	$limit = 8;
	$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	if($shop_af->use_group == 2){

		$affiliate_products = $this->product_model->getAFProductsByCat((int)$siteGlobal->sho_user);
		$afbyCat = array();
		if(!empty($affiliate_products)){
			foreach($affiliate_products as $item){
				if(!isset($afbyCat[$item->cat])){
					$afbyCat[$item->cat] = array();
				}
				array_push($afbyCat[$item->cat], $item);
			}
		}
		$cats = array_keys($afbyCat);
		if(!empty($cats)){
			$cats = $this->product_model->getCategoryInfo($cats);
		}

	}else{
		$new_products = $this->product_model->fetch($select, "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 ", pro_id, "DESC", $start, $limit);

		$featured_products = $this->product_model->fetch($select, "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 ", pro_view, "DESC", $start, $limit);

		$sale_products = $this->product_model->fetch($select, "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1  AND pro_saleoff = 1", pro_id, "DESC", $start, $limit);

		$azibai_products = $this->product_model->fetch($select, "is_product_affiliate = 1 AND is_asigned_by_admin = 1 AND id_shop_cat = {$siteGlobal->sho_category} AND pro_status = 1 ", "rand()", "DESC", $start, $limit);

		$affiliate_products = $this->product_model->fetchAF('tbtt_product.*'.DISCOUNT_QUERY, array('pro_status'=>1, 'tbtt_product_affiliate_user.use_id'=>(int)$siteGlobal->sho_user), "rand()", "DESC", $start, 16);

	}

	$shopAfLink = $this->product_model->getAFLink((int)$siteGlobal->sho_user);
?>
<hr/>
<?php if($new_products) { ?>
<div class="products new_products">
	<h3><span class="modtitle"><i class="fa fa-cubes"></i> Sản phẩm mới nhất </span></h3>
	<a class="btn btn-default btn-left pull-left" href="#new_products" role="button" data-slide="prev">
		<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
		<span class="sr-only">Prev</span>
	</a>
	<a class="btn btn-default  btn-right pull-right" href="#new_products" role="button" data-slide="next">
		<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
	<div id="new_products" class="carousel slid" data-ride="carousel" <?php echo $stopslide;?>>
		<div class="carousel-inner" role="listbox">
			<?php $this->load->view('shop/common/product_item', array('products'=>$new_products)); ?>
		</div>
	</div>
</div>
<hr/>
<?php } ?>

<?php if($featured_products) {?>
<div class="products featured_products">
   <h3><span class="modtitle"><i class="fa fa-cubes"></i> Sản phẩm nổi bật	</span>
		<span class="pull-right">
			<a class="btn btn-default btn-left" href="#featured_products" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
				<span class="sr-only">Prev</span>
			</a>
			<a class="btn btn-default btn-right" href="#featured_products" role="button" data-slide="next">
				<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</span>
	</h3>
	<div id="featured_products" class="carousel slid" data-ride="carousel" <?php echo $stopslide;?>>
		<div class="carousel-inner" role="listbox">
			<?php $this->load->view('shop/common/product_item', array('products'=>$featured_products)); ?>
		</div>
	</div>
</div>
<hr/>
<?php } ?>
<?php if($sale_products) {?>
<div class="products sale_products">
   <h3><span class="modtitle"><i class="fa fa-cubes"></i> Sản phẩm khuyến mãi</span>
		<span class="pull-right">
			<a class="btn btn-default btn-left" href="#sale_products" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
				<span class="sr-only">Prev</span>
			</a>
			<a class="btn btn-default btn-right" href="#sale_products" role="button" data-slide="next">
				<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</span>
	</h3>
	<div id="sale_products" class="carousel slid" data-ride="carousel" <?php echo $stopslide;?>>
		<div class="carousel-inner" role="listbox">
			<?php $this->load->view('shop/common/product_item', array('products'=>$sale_products)); ?>
		</div>
	</div>
</div>
<hr/>
<?php } ?>
<?php if($shop_af->use_group == 2){ ?>
<?php if($affiliate_products) {?>
<div  class="products affiliate_products">
	<?php foreach($cats as $cat):?>
   <h3><span class="modtitle"><i class="fa fa-cubes"></i><a href="<?php echo $URLRoot.'afproduct?cat='.$cat['cat_id'];?>"><?php echo $cat['cat_name'];?></a></span></h3>
		<div>
				<?php
				$link = $URLRoot.'afproduct';
				$this->load->view('shop/common/item', array('products'=>$afbyCat[$cat['cat_id']], 'link'=>$link, 'afLink'=>$shopAfLink));
				?>
		</div>
	<?php endforeach;?>
</div>
<hr/>
<?php }
}?>
<?php if(@$azibai_products) {?>
	<div class="products azibai_products">
		<h3><span class="modtitle"><i class="fa fa-cubes"></i> Sản phẩm từ azibai</span>
		<span class="pull-right">
			<a class="btn btn-default btn-left" href="#azibai_products" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
				<span class="sr-only">Prev</span>
			</a>
			<a class="btn btn-default btn-right" href="#azibai_products" role="button" data-slide="next">
				<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</span>
		</h3>
		<div id="azibai_products" class="carousel slid" data-ride="carousel" <?php echo $stopslide;?>>
			<div class="carousel-inner" role="listbox">
				<?php $this->load->view('shop/common/item', array('products'=>$azibai_products)); ?>
			</div>
		</div>
	</div>
	<hr/>
<?php } ?>


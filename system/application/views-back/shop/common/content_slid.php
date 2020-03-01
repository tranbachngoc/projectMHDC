<!-- content style_1 -->
<?php	
	$select = '*';
	$start = 0;
	$limit = 8;
    $shop_af = $this->user_model->get('*','use_id = '.(int)$siteGlobal->sho_user.' AND use_status = 1');
	$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

	if($shop_af->use_group == 2){
		$stopslide = '';
        $af_products_parent = $this->product_model->fetchAF('tbtt_product.*' . DISCOUNT_QUERY, array('pro_status' => 1, 'tbtt_product_affiliate_user.use_id' => (int)$siteGlobal->sho_user, 'pro_user'=>$shop_af->parent_id), 'pro_id', "DESC", $start, 8);
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
		$stopslide = 'data-interval="false"';
		$this->db->order_by("pro_order","asc");
		$new_products = $this->product_model->fetch_join1($select. ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 AND pro_type = 0 GROUP BY pro_id", "pro_id", "DESC", $start, $limit);
		$new_service = $this->product_model->fetch_join1($select . ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 AND pro_type = 1 GROUP BY pro_id", "pro_id", "DESC", $start, $limit);
		$new_coupon = $this->product_model->fetch_join1($select . ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY, 'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 AND pro_type = 2 GROUP BY pro_id", "pro_id", "DESC", $start, $limit);
		//$featured_products = $this->product_model->fetch($select, "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 ", pro_view, "DESC", $start, $limit);
		$this->db->order_by("pro_order","asc");
		
		$sale_products = $this->product_model->fetch_join1($select . ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY, 'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 AND pro_saleoff = 1 AND pro_type = 0 AND tbtt_product.pro_saleoff = 1 AND ((". time() ." >= tbtt_product.begin_date_sale AND ". time() ." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )) GROUP BY pro_id", "pro_id", "DESC", $start, $limit);
		$sale_service = $this->product_model->fetch_join1($select . ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY, 'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 AND pro_saleoff = 1 AND pro_type = 1 AND tbtt_product.pro_saleoff = 1 AND ((". time() ." >= tbtt_product.begin_date_sale AND ". time() ." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )) GROUP BY pro_id", "pro_id", "DESC", $start, $limit);
		$sale_coupon = $this->product_model->fetch_join1($select . ',tbtt_detail_product.id as dp_id' . DISCOUNT_QUERY, 'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 AND pro_saleoff = 1 AND pro_type = 2 AND tbtt_product.pro_saleoff = 1 AND ((". time() ." >= tbtt_product.begin_date_sale AND ". time() ." <= tbtt_product.end_date_sale) OR (tbtt_product.begin_date_sale = 0 AND tbtt_product.end_date_sale = 0 )) GROUP BY pro_id", "pro_id", "DESC", $start, $limit);
		$azibai_products = $this->product_model->fetch($select . DISCOUNT_QUERY, "is_product_affiliate = 1 AND is_asigned_by_admin = 1 AND id_shop_cat = {$siteGlobal->sho_category} AND pro_status = 1 ", "rand()", "DESC", $start, $limit);
		$affiliate_products = $this->product_model->fetchAF('tbtt_product.*'.DISCOUNT_QUERY, array('pro_status'=>1, 'tbtt_product_affiliate_user.use_id'=>(int)$siteGlobal->sho_user), "rand()", "DESC", $start, 16);
	}
	$shopAfLink = $this->product_model->getAFLink((int)$siteGlobal->sho_user);
?>


<?php if($new_products) {?>
<div class="module new_products">
	<h3><span class="modtitle"><i class="fa fa-list-ul" aria-hidden="true"></i> Sản phẩm mới nhất </span>
		<span class="pull-right">
			<a class="btn btn-default btn-left" href="#new_products" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
				<span class="sr-only">Prev</span>
			</a>
			<a class="btn btn-default  btn-right" href="#new_products" role="button" data-slide="next">
				<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</span>
	</h3>
	<div id="new_products" class="carousel slid" data-ride="carousel" <?php echo $stopslide;?>>
		<div class="carousel-inner" role="listbox">
			<?php $this->load->view('shop/common/product_item', array('products'=>$new_products)); ?>
		</div>
	</div>
</div>
<?php } ?>
<?php if($new_service && serviceConfig == 1) {?>
<div class="module new_products">
	<h3><span class="modtitle"><i class="fa fa-list-ul" aria-hidden="true"></i> Dịch vụ mới nhất </span>
		<span class="pull-right">
			<a class="btn btn-default btn-left" href="#new_products" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
				<span class="sr-only">Prev</span>
			</a>
			<a class="btn btn-default  btn-right" href="#new_products" role="button" data-slide="next">
				<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</span>
	</h3>
	<div id="new_products" class="carousel slid" data-ride="carousel" <?php echo $stopslide;?>>
		<div class="carousel-inner" role="listbox">
			<?php $this->load->view('shop/common/product_item', array('products'=>$new_service)); ?>
		</div>
	</div>
</div>
<?php } ?>
<?php if($new_coupon) {?>
<div class="module new_products">
	<h3><span class="modtitle"><i class="fa fa-list-ul" aria-hidden="true"></i> Coupon mới nhất </span>
		<span class="pull-right">
			<a class="btn btn-default btn-left" href="#new_coupons" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
				<span class="sr-only">Prev</span>
			</a>
			<a class="btn btn-default  btn-right" href="#new_coupons" role="button" data-slide="next">
				<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</span>
	</h3>
	<div id="new_coupons" class="carousel slid" data-ride="carousel" <?php echo $stopslide;?>>
		<div class="carousel-inner" role="listbox">
			<?php $this->load->view('shop/common/product_item', array('products'=>$new_coupon)); ?>
		</div>
	</div>
</div>
<?php } ?>

<?php /* if($featured_products){?>
<div class="module featured_products">
   <h3><span class="modtitle"><i class="fa fa-list-ul" aria-hidden="true"></i> Sản phẩm nổi bật	</span>
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
<?php }  */?>

<?php if($sale_products) { ?>
<div class="module sale_products">
   <h3><span class="modtitle"><i class="fa fa-list-ul" aria-hidden="true"></i> Sản phẩm khuyến mãi</span>
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
<?php } ?>
<?php if($sale_service  && serviceConfig == 1) { ?>
<div class="module sale_services">
   <h3><span class="modtitle"><i class="fa fa-list-ul" aria-hidden="true"></i> Dịch vụ khuyến mãi</span>
		<span class="pull-right">
			<a class="btn btn-default btn-left" href="#sale_services" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
				<span class="sr-only">Prev</span>
			</a>
			<a class="btn btn-default btn-right" href="#sale_services" role="button" data-slide="next">
				<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</span>
	</h3>
	<div id="sale_services" class="carousel slid" data-ride="carousel" <?php echo $stopslide;?>>
		<div class="carousel-inner" role="listbox">
			<?php $this->load->view('shop/common/product_item', array('products'=>$sale_service)); ?>
		</div>
	</div>
</div>
<?php } ?>
<?php if($sale_coupon) { ?>
<div class="module sale_coupons">
   <h3><span class="modtitle"><i class="fa fa-list-ul" aria-hidden="true"></i> Coupon khuyến mãi</span>
		<span class="pull-right">
			<a class="btn btn-default btn-left" href="#sale_coupons" role="button" data-slide="prev">
				<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
				<span class="sr-only">Prev</span>
			</a>
			<a class="btn btn-default btn-right" href="#sale_coupons" role="button" data-slide="next">
				<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
				<span class="sr-only">Next</span>
			</a>
		</span>
	</h3>
	<div id="sale_coupons" class="carousel slid" data-ride="carousel" <?php echo $stopslide;?>>
		<div class="carousel-inner" role="listbox">
			<?php $this->load->view('shop/common/product_item', array('products'=>$sale_coupon)); ?>
		</div>
	</div>
</div>
<?php } ?>
<?php if ($shop_af->use_group == 2) { ?>
    <?php if ($af_products_parent) { ?>
        <h3><span class="modtitle"><i class="fa fa-cubes"></i><a
                        href="#"> Sản phẩm từ gian hàng</a></span></h3>
        <div class="products affiliate_products">
            <div>
                <?php
                $link = $URLRoot . 'afproduct';
                $this->load->view('shop/common/af_parent_item', array('products' => $af_products_parent, 'afLink'=>'?af_id='.$shop_af->af_key));
                ?>
            </div>
        </div>
        <hr/>
    <?php }
} ?>
<?php if($shop_af->use_group == 2){ ?>
<?php if($affiliate_products) {?>
<div  class="module affiliate_products">
	<?php foreach($cats as $cat):?>
   <h3><span class="modtitle"><i class="fa fa-list-ul"></i><a href="<?php echo $URLRoot.'afproduct?cat='.$cat['cat_id'];?>"><?php echo $cat['cat_name'];?></a></span></h3>
		<div>
				<?php
				$link = $URLRoot.'afproduct';
				$this->load->view('shop/common/item', array('products'=>$afbyCat[$cat['cat_id']], 'link'=>$link, 'afLink'=>$shopAfLink));
				?>
		</div>
	<?php endforeach;?>
</div>

<?php }
}?>
<?php if(@$azibai_products) {?>
	<div class="module azibai_products">
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
<?php } ?>


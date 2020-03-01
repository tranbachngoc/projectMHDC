
<?php

	$select = '*';
	$start = 0;
	$limit = 8;
	$currentDate = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	$this->db->order_by("pro_order","asc");
	$new_products = $this->product_model->fetch($select, "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 ", pro_id, "DESC", $start, $limit);
	
	//$featured_products = $this->product_model->fetch($select, "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 ", pro_view, "DESC", $start, $limit);
	$this->db->order_by("pro_order","asc");
	$sale_products = $this->product_model->fetch($select, "pro_user = ".(int)$siteGlobal->sho_user." AND pro_status = 1 AND pro_saleoff = 1", pro_id, "DESC", $start, $limit);
	
	$azibai_products = array();
	$affiliate_products = array();

	if ($shop_af->use_group == 2) {
		$azibai_products = $this->product_model->fetch($select, "is_product_affiliate = 1 AND is_asigned_by_admin = 1 AND id_shop_cat = {$siteGlobal->sho_category} AND pro_status = 1", "rand()", "DESC", $start, $limit);	
		$affiliate_products = $this->product_model->fetchAF('tbtt_product.*'.DISCOUNT_QUERY, array( 'pro_status'=>1, 'tbtt_product_affiliate_user.use_id'=>(int)$siteGlobal->sho_user), "rand()", "DESC", $start, $limit);
	    $shopAfLink = $this->product_model->getAFLink((int)$siteGlobal->sho_user);
	}

?>

<div>
    <!-- Nav tabs -->
    <ul id="navtabs" role="tablist">
        <li role="presentation" class="active"><a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab"><i class="fa fa-cubes fa-fw"></i> <b lang="vi"><?php echo $this->lang->line('title_interest_detail_defaults'); ?></b></a></li>
        <li role="presentation"><a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab"><i class="fa fa-cubes fa-fw"></i> <b lang="vi"><?php echo $this->lang->line('title_new_detail_defaults'); ?></b></a></li>
        <li role="presentation"><a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab"><i class="fa fa-cubes fa-fw"></i> <b lang="vi"><?php echo $this->lang->line('title_saleoff_detail_defaults'); ?></b></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="tab1">								
				
					<?php $this->load->view('shop/common/product_item', array('products'=>$featured_products)); ?>							
			
        </div>
        <div role="tabpanel" class="tab-pane" id="tab2">
			
					<?php $this->load->view('shop/common/product_item', array('products'=>$new_products)); ?>
				
        </div>
        <div role="tabpanel" class="tab-pane" id="tab3">
			
					<?php $this->load->view('shop/common/product_item', array('products'=>$sale_products)); ?>
				
        </div>
    </div>
</div>


<?php
if($shop_af->use_group == 2){
if(!empty($affiliate_products)):?>
<hr/>
<div  class="products affiliate_products">
   <div class="row">
		<div class="col-sm-6">
			<h3><span class="modtitle"><i class="fa fa-cubes"></i> Sản phẩm khuyến mãi liên kết</span></h3>
		</div>
		<div class="col-sm-6 text-right">
			<div style="margin-top: 20px; margin-bottom: 10px;">
				<a class="btn btn-default btn-left" href="#affiliate_products" role="button" data-slide="prev">
					<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
					<span class="sr-only">Prev</span>
				</a>
				<a class="btn btn-default btn-right" href="#affiliate_products" role="button" data-slide="next">
					<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</a>
			</div>
		</div>
	</div>
	<div id="affiliate_products" class="carousel slid" data-ride="carousel"> 
		<div class="carousel-inner" role="listbox">
		<?php 
			$link = $URLRoot.'afproduct';
			$this->load->view('shop/common/item', array('products'=>$affiliate_products, 'link'=>$link, 'afLink'=>$shopAfLink));
		?>
		</div>
	</div>
</div>
<?php endif; }?>

<?php if(!empty($azibai_products)):?>
	<hr/>
	<div class="products azibai_products">
		<div class="row">
			<div class="col-sm-6">
				<h3><span class="modtitle"><i class="fa fa-cubes"></i> Sản phẩm từ azibai</span></h3>
			</div>
			<div class="col-sm-6 text-right">
				<div style="margin-top: 20px; margin-bottom: 10px;">
					<a class="btn btn-default btn-left" href="#azibai_products" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-menu-left" aria-hidden="true"></span>
						<span class="sr-only">Prev</span>
					</a>
					<a class="btn btn-default btn-right" href="#azibai_products" role="button" data-slide="next">
						<span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>
						<span class="sr-only">Next</span>
					</a>
				</div>
			</div>
		</div>
		<div id="azibai_products" class="carousel slid" data-ride="carousel">
			<div class="carousel-inner" role="listbox">
				<?php $this->load->view('shop/common/item', array('products'=>$azibai_products)); ?>
			</div>
		</div>
	</div>
<?php endif;?>

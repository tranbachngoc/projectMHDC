<?php

	$select = 'Distinct pro_id, pro_name, pro_image, pro_dir, pro_cost,tbtt_detail_product.id as dp_id'; //tbtt_product.*, , tbtt_detail_product.dp_pro_id
	$where = 'pro_user IN ('. $list_join .') AND pro_id NOT IN ('. $_bl_pro .') AND pro_status = 1';
	$start = 0;
	$limit = 8;	

	//SP mới nhất
	$new_products = $this->product_model->fetch_join1($select . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','tbtt_detail_product.dp_pro_id = pro_id', $where .' AND pro_type = 0 GROUP BY pro_id', 'pro_id', "DESC", $start, $limit);	
	//$new_products = $this->product_model->fetch($select . DISCOUNT_QUERY, $where .' AND pro_type = 0', 'pro_id', "DESC", $start, $limit);	
	//CP mới nhất
	$new_coupon = $this->product_model->fetch_join1($select . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','dp_pro_id = pro_id', $where ." AND pro_type = 2 GROUP BY pro_id", 'pro_id', "DESC", $start, $limit);	
        //$new_coupon = $this->product_model->fetch($select . DISCOUNT_QUERY, $where ." AND pro_type = 2 ", 'pro_id', "DESC", $start, $limit);	

	// Khuyen mai
	$sale_products = $this->product_model->fetch_join1($select . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','dp_pro_id = pro_id', $where . " AND pro_saleoff = 1 AND pro_type = 0 GROUP BY pro_id", 'pro_id', "DESC", $start, $limit);	
	$sale_coupon = $this->product_model->fetch_join1($select . DISCOUNT_QUERY,'LEFT','tbtt_detail_product','dp_pro_id = pro_id', $where . " AND pro_saleoff = 1 AND pro_type = 2 GROUP BY pro_id", 'pro_id', "DESC", $start, $limit);
        //$sale_products = $this->product_model->fetch($select . DISCOUNT_QUERY, $where . " AND pro_saleoff = 1 AND pro_type = 0", 'pro_id', "DESC", $start, $limit);	
	//$sale_coupon = $this->product_model->fetch($select . DISCOUNT_QUERY, $where . " AND pro_saleoff = 1 AND pro_type = 2", 'pro_id', "DESC", $start, $limit);
 ?>

<!-- /******************** SẢN PHẨM MỚI NHẤT **********************/ -->                
<?php if($new_products){ ?>
<h4 class="text-left"><span>SẢN PHẨM MỚI NHẤT</span></h4>
<div class="row products">
    <div  class="owl-carousel owl-theme">
    <?php foreach ($new_products as $key => $item) { ?>
        <?php 
            $afSelect = false;
            $discount = lkvUtil::buildPrice($item, $this->session->userdata('sessionGroup'), $afSelect)
         ?>                        
        <div class="item <?php echo $key == 0 ? 'active' : ''; ?>">
            <?php $this->load->view('group/product/product_item', array('product' => $item, 'discount' => $discount)); ?>
        </div>                       
    <?php }?>
    </div>
</div>
<br/>
<?php } ?>
<!-- /******************** SẢN PHẨM KHUYỄN MÃI *******************/ -->
<?php if($sale_products){ ?>
<h4 class="text-left"><span>SẢN PHẨM KHUYỄN MÃI</span></h4>
<div class="row products">
   <div  class="owl-carousel owl-theme">
    <?php foreach ($sale_products as $key => $item) { ?>
    	<?php 
            $afSelect = false;
            $discount = lkvUtil::buildPrice($item, $this->session->userdata('sessionGroup'), $afSelect)
         ?>                         
        <div class="item <?php echo $key == 0 ? 'active' : ''; ?>">           
            <?php $this->load->view('group/product/product_item', array('product' => $item, 'discount' => $discount)); ?>
        </div>                       
    <?php }?>
    </div>
</div>
<br/>
<?php } ?>
<!-- /******************** COUPON MỚI ************************/ -->
<?php if($new_coupon){ ?>
<h4 class="text-left"><span>COUPON MỚI NHẤT</span></h4>
<div class="row products">
   <div  class="owl-carousel owl-theme">
    <?php foreach ($new_coupon as $key => $item) { ?>
    	<?php 
            $afSelect = false;
            $discount = lkvUtil::buildPrice($item, $this->session->userdata('sessionGroup'), $afSelect)
         ?>                        
        <div class="item <?php echo $key == 0 ? 'active' : ''; ?>">          
            <?php $this->load->view('group/product/product_item', array('product' => $item, 'discount' => $discount)); ?>
        </div>                       
    <?php } ?>
    </div>
</div>      
<br/>
<?php } ?>

 <!-- /******************** COUPON KHUYẾN MÃI ********************/ -->
<?php if($sale_coupon){ ?>
<h4 class="text-left"><span>COUPON KHUYẾN MÃI</span></h4>
<div class=" products">
   <div  class="owl-carousel owl-theme">
    <?php foreach ($sale_coupon as $key => $item) { ?>
    	<?php 
            $afSelect = false;
            $discount = lkvUtil::buildPrice($item, $this->session->userdata('sessionGroup'), $afSelect)
         ?>                        
        <div class="item <?php echo $key == 0 ? 'active' : ''; ?>">           
            <?php $this->load->view('group/product/product_item', array('product' => $item, 'discount' => $discount)); ?>
        </div>                       
    <?php } ?>
    </div>
</div>                
<br/>
<?php } ?>

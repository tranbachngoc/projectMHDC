<?php 
	$link_img = 'media/images/no_photo_icon.png';
	$filename = DOMAIN_CLOUDSERVER . 'media/images/product/'. $product->pro_dir .'/thumbnail_2_'. explode(',', $product->pro_image)[0];
	if(explode(',', $product->pro_image)[0] != ''){ //file_exists($filename)
		$link_img = $filename;
		$link_img_full = 'media/images/product/'. $product->pro_dir .'/'. explode(',', $product->pro_image)[0];
	}

	if($product->pro_type == 0){$url_type = 'product'; }
	else{ $url_type = 'coupon'; }	

	$product_detail = getAliasDomain(). 'grtshop/' . $url_type . '/detail/'. $product->pro_id .'/'. RemoveSign($product->pro_name);
	// if($siteGlobal->grt_domain != ''){
 //            $product_detail = $protocol . $siteGlobal->grt_domain .'/grtshop/' . $url_type . '/detail/'. $product->pro_id .'/'. RemoveSign($product->pro_name);
	// }

    if($this->session->userdata('sessionUser') > 0){        
        $user = $this->user_model->get('af_key', 'use_id = '. (int)$this->session->userdata('sessionUser'));
        $ukey = ($user->af_key != '') ? $user->af_key : '';
        $gr_saler = ($ukey != '') ? ('?gr_saler='. $ukey) : '';
    }

    $product_detail = $product_detail . $gr_saler;

    // echo "<pre>";
    // print_r($product);
    // echo "</pre>"; die;

 ?>

<div class="product-item" style="padding: 10px; border: 1px solid #ddd; background: #fff;">
    <div class="fix1by1">
        <div class="c">
            <a href="<?php echo $product_detail; ?>">
                <img src="<?php echo $link_img; ?>" id="<?php echo $product->pro_id; ?>" alt="<?php echo $product->pro_name; ?>">
            </a>
        </div>
    </div>
    
    <div class="new" style="position: absolute; top: 15px; left: 15px;">
        <img src="/templates/shop/default/images/new.png">        
    </div>
    <?php if($product->pro_saleoff == 1){ ?>
        <div class="sale" style="position: absolute; top: 15px; right: 15px;">        
            <img src="/templates/shop/default/images/saleoff.png">
        </div> 
    <?php }?>
    <div class="">
        <h5 class="pro-name text-center">
            <a href="<?php echo $product_detail; ?>"><?php echo $product->pro_name; ?></a>
        </h5>
        <p class="content_price text-center">
        	<?php if ($product->pro_cost > $discount['salePrice']) { ?>
            	<span class="sale-price" style="color: #f00;"><?php echo lkvUtil::formatPrice($discount['salePrice'], 'đ'); ?></span>
            	<span class="cost-price"><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></span>
        	<?php } else { ?>
           		 <span class="sale-price" style="color: #f00;"><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></span>
        	<?php } ?>                                          
        </p>
       
        <div class="button-group text-center" id="bt_<?php echo $product->pro_id; ?>">
            <button class="btn btn-default addToCart" type="button" title="Thêm vào giỏ hàng" onclick="addCart(<?php echo $product->pro_id; ?>);">
                <i class="fa fa-cart-plus fa-fw"></i>
            </button>
            <button class="btn btn-default wishlist" type="button" title="Thích" onclick="wishlist(<?php echo $product->pro_id; ?>);">
                <i class="fa fa-heart-o fa-fw"></i>
            </button>
            <a class="btn btn-default quickview" href="<?php echo $product_detail; ?>"" title="Xem chi tiết"><i class="fa fa-eye fa-fw"></i>
            </a>

            <input type="hidden" name="product_showcart" value="<?php echo $product->pro_id; ?>">
            <input type="hidden" name="af_id">
            <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->dp_id; ?>">
            <input type="hidden" name="qty" value="1">
        </div>
    </div>
</div>
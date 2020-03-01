<?php 
$segment = $this->uri->segment(2);
$siteUrl = getAliasDomain();
if ($item->domain != '') {
    $siteUrl = $linkweb;
}
$a = $siteUrl.'affiliate/'.$segment.'/detail/'.$item->pro_id.'/'.RemoveSign($item->pro_name);

$filename = DOMAIN_CLOUDSERVER . 'media/images/product/'.$item->pro_dir.'/thumbnail_2_'. explode(',', $item->pro_image)[0];
if(!empty($item->pro_image)){
}else{
    $filename = base_url(). 'media/images/no_photo_icon.png';
}
$user_login = $this->user_model->get('af_key', "use_id = " . (int)$shop->sho_user);
$af_id = $user_login->af_key;

$suffix = !empty($shop->user_af_key) ?  '?af_id='. $shop->user_af_key : '';
if ($item->domain != '') {
   $a =  $protocol . $item->domain . '/shop/product/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name) . $suffix;
} else if ($item->sho_link != '') { 
    $a =  $protocol . $item->sho_link . '.' . domain_site . '/shop/product/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name) . $suffix;
}


$discount = lkvUtil::buildPrice($item, $this->session->userdata('sessionGroup'), true);
?>
<div class="product-item text-center" style="border:1px solid #ddd; margin-bottom: 20px">
    <div class="left-block">        
	<div class="thumbox">
		<a href="<?php echo $a; ?>">           
		    <img class="img-responsive" src="<?php echo $filename; ?>" id="<?php echo $item->pro_id; ?>" alt="<?php echo $item->pro_name; ?>"/>
		</a>        
	</div>        
    </div>
    <div class="right-block">
        <div class="pro-name" style="height:48px;overflow: hidden; margin: 10px;">
            <a href="<?php echo $a; ?>"><?php echo $item->pro_name; ?></a>
        </div>
        <div class="content_price">
            <strong class="text-danger">
                <?php if ($item->pro_cost > $discount['salePrice']) { ?>
                    <span class="sale-price"><?php echo lkvUtil::formatPrice($discount['salePrice'], 'đ'); ?></span>
                    <span class="cost-price"><?php echo lkvUtil::formatPrice($item->pro_cost, 'đ'); ?></span>
                <?php } else { ?>
                    <span class="sale-price"><?php echo lkvUtil::formatPrice($item->pro_cost, 'đ'); ?></span>
                <?php } ?>
            </strong>                                
        </div>                            
        <div class="button-group" id="bt_<?php echo $item->pro_id; ?>" style="margin:10px 0">
            <!-- <button class="btn btn-default addToCart" type="button" title="Thêm vào giỏ hàng" onclick="addCart(<?php echo $item->pro_id; ?>);"><i class="fa fa-cart-plus"></i></button> -->
            <!-- <button class="btn btn-default wishlist" type="button" title="Thích" onclick="wishlist(<?php echo $item->pro_id; ?>);"><i class="fa fa-heart-o"></i></button> -->
            <!-- <a class="btn btn-default quickview" href="<?php echo $a; ?>" title="Xem chi tiết"><i class="fa fa-eye"></i></a> -->
            <a class="btn btn-default" href="<?php echo $a; ?>" title="Xem chi tiết">Xem chi tiết</a>
            <input type="hidden" name="product_showcart" value="<?php echo $item->pro_id; ?>">
            <input type="hidden" name="af_id" value="<?php echo $af_id; ?>">
            <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $dp->id; ?>">
            <?php $pty_min = $item->shop_type >= 1 ? $item->pro_minsale : 1; ?>
            <input type="hidden" name="qty" value="<?php echo $pty_min; ?>">
            <input type="hidden" name="position" value="3">

        </div>
    </div>
</div>
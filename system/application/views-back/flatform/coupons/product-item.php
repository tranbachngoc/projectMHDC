<?php
$flatform = $this->uri->segment(1);
$type = 'coupon';
$segment2 = $this->uri->segment(2);
$link = getAliasDomain().$flatform.'/'.$type.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name).$af;
if($isAffiliate == TRUE){
    $link = $shop->sho_link.'.'.domain_site.'/shop/'.$linkt.'/detail/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
}
$af = $this->session->userdata('af_id') ? $this->session->userdata('af_id') : (($siteGlobal->af_key != '' && $siteGlobal->isAffiliate) ? $siteGlobal->af_key : "");
if(isset($af_id) && !empty($af_id)){
    $af = $af_id;
}
if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
    $user_login = $this->user_model->get('af_key', "use_id = " . (int)$this->session->userdata('sessionUser'));
    $af = $user_login->af_key;
}
$link = ($af != '') ? $link.'?af_id='.$af : $link;
?>
<?php $images = explode(',', $product->pro_image); ?>
<div class="product-item" style="margin-bottom: 20px;">
    <div class="pro-image">        
        <div class="fix1by1">
            <a class="c" href="<?php echo $link; ?>">           
                <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_2_' . $images[0] ?>" id="<?php echo $product->pro_id ?>" alt="<?php echo $product->pro_name ?>">
            </a>
        </div>
	<?php if ($product->pro_type == 2) { ?>
            <div class="tag_coupon"><i class="fa fa-tag fa-fw"></i></div>
        <?php } ?>
    </div>                    
    <div class="pro-info">
        <div class="pro-name">
            <a href="<?php echo $link; ?>"><?php echo sub($product->pro_name, 50); ?></a>
        </div>
        <div class="content_price text-center">             
            <?php if ($product->pro_cost > $discount['salePrice']) { ?>
                <span class="sale-price"><?php echo lkvUtil::formatPrice($discount['salePrice'], 'đ'); ?></span>
                <span class="cost-price"><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></span>
            <?php } else { ?>
                <span class="sale-price"><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></span>
            <?php } ?>
        </div>
        <div id="bt_<?php echo $product->pro_id ?>" class="btn-group btn-group-justified text-center" role="group" aria-label="..." style=" padding: 10px">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-default addToCart" onclick="addCart(<?php echo $product->pro_id ?>);"><i class="fa fa-cart-plus fa-fw"></i></button>
            </div>
            <div class="btn-group" role="group">
                <?php
                    if(in_array($product->pro_id, $favorite) || $segment2 == 'favorite_cou'){
                    ?>
                        <a href="#wishlist" onclick="delheart(<?php echo $product->pro_id ?>);" class="btn btn-default delheart_<?php echo $product->pro_id ?>" title="Bỏ thích">
                            <i class="fa fa-heartbeat"></i>
                        <a href="#wishlist" onclick="wishlist(<?php echo $product->pro_id ?>);" class="btn btn-default addheart_<?php echo $product->pro_id ?> hidden" title="Thêm vào yêu thích">
                            <i class="fa fa-heart-o"></i>
                        </a>
                    <?php } else{ ?>
                        <a href="#wishlist" onclick="wishlist(<?php echo $product->pro_id ?>);" class="btn btn-default addheart_<?php echo $product->pro_id ?>" title="Thêm vào yêu thích">
                            <i class="fa fa-heart-o"></i>
                        </a>
                    <a href="#wishlist" onclick="delheart(<?php echo $product->pro_id ?>);" class="btn btn-default delheart_<?php echo $product->pro_id ?> hidden" title="Bỏ thích">
                            <i class="fa fa-heartbeat"></i>
                        </a>
                <?php } ?>
            </div>
            <div class="btn-group" role="group">
                <a class="btn btn-default quickview" href="<?php echo $link; ?>"><i class="fa fa-eye fa-fw"></i></a>
            </div>        
            <input type="hidden" name="product_showcart" value="<?php echo $product->pro_id; ?>" />
            <input type="hidden" name="af_id" value="<?php echo $_REQUEST['af_id']; ?>" />
            <input type="hidden" name="dp_id" id="dp_id"  value="<?php echo $product->id; ?>"/>
            <input type="hidden" name="qty" value="1" />
            <input type="hidden" name="fl_id" id="fl_id" value="<?php echo $head_footer->fl_id; ?>" />
        </div>
    </div>
</div>
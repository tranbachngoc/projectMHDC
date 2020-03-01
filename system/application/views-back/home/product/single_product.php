
<?php
    $link = base_url().$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
    if(isset($af_id) && !empty($af_id)){
        $link = $link .'?af_id='. $af_id;
    }
?>
<div class="product-item product-container">
    <div class="left-block">
        <div class='thumbox'>
            <?php if ($product->pro_type == 2){ ?>
                <div class="tag_coupon"><i class="fa fa-tags"></i> Coupon</div>
            <?php } ?>
            <?php
                $imgs = explode(',', $product->pro_image);
                $filename = DOMAIN_CLOUDSERVER . 'media/images/product/'. $product->pro_dir .'/thumbnail_2_'. $imgs[0];
                
                if(!empty($product->pro_image)){               
                }else{
                    $filename = base_url(). 'media/images/no_photo_icon.png';                
                }
            ?>
            <a href="<?php echo $link; ?>">           
                <img class="lazy" data-src="<?php echo $filename; ?>" id="<?php echo $product->pro_id; ?>" alt="<?php echo $product->pro_name; ?>" />
            </a>
        </div>
    </div>

    <div class="right-block">
        <div class="pro-name">
            <a href="<?php echo $link; ?>"><?php echo sub($product->pro_name, 50); ?></a></div>
        <div class="content_price">
            <?php if ($product->pro_cost > $discount['salePrice']) { ?>
                <span class="cost-price"><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ');?></span>
		<br class="visible-sm">
                <span class="sale-price"><?php echo lkvUtil::formatPrice($discount['salePrice'], 'đ'); ?></span>
            <?php } else { ?>
                <br class="visible-sm">
		<span class="sale-price"><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ');?></span>
            <?php } ?>
        </div>

        <div class="pro_descr"><?php echo sub($product->pro_descr, 250); ?></div>
        <div class="button-group" id="bt_<?php echo $product->pro_id?>" style="margin:10px 0">
            <button class="btn btn-default addToCart" type="button" title="Thêm vào giỏ hàng" onclick="addCart(<?php echo $product->pro_id?>);"><i class="fa fa-cart-plus"></i>&nbsp;
            </button>
            <p class="btn like js-like-product" data-id="<?php echo $product->pro_id; ?>">
            <?php if (!empty($product->is_like)) { ?>
                <img class="icon-img" src="/templates/home/styles/images/svg/like_pink.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like.svg" >
               <?php } else { ?>
                <img class="icon-img" src="/templates/home/styles/images/svg/like.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like.svg">
            <?php } ?>
            </p>
            <!-- <button class="btn btn-default wishlist" type="button" title="Thích" onclick="wishlist(<?php echo $product->pro_id?>);"><i class="fa fa-heart-o"></i>&nbsp;
            </button> -->
            <a class="btn btn-default quickview" href="<?php echo $link; ?>" title="Xem chi tiết"><i class="fa fa-eye"></i>&nbsp;</a>
            <!--<button class="btn btn-default  quickview" type="button" title=""
                    onclick="quickView(<?php /*echo $product->pro_id*/?>);"><i class="fa fa-eye"></i>&nbsp;
            </button>-->
            <?php $pty_min = $product->shop_type >= 1 ? $product->pro_minsale : 1; ?>
            <input type="hidden" name="product_showcart" value="<?php echo $product->pro_id; ?>" />
            <input type="hidden" name="af_id" value="<?php echo $af_id; ?>" />
            <input type="hidden" name="dp_id" id="dp_id"  value="<?php echo $product->id; ?>"/>
            <input type="hidden" name="qty" value="<?php echo $pty_min; ?>" id="qty_min"/>
        </div>
    </div>
</div>
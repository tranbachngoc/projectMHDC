<div class="product-item text-center">
    <?php
    $shop = $this->shop_model->get('sho_link, domain', "sho_user = " . (int)$product->pro_user);
    $mainURL = $protocol.$domainName.'/';
    if(count(explode('.', $domainName)) === 3){
        $url = '';
        $strUrl = explode('.', $domainName);
        $url = $strUrl[1].'.'.$strUrl[2];
    }

    $siteURL = $mainURL;
    //if($shop->domain != ""){
        // $siteURL = $protocol.$shop->domain.'/';
    //}

    $link = '';
    $linkt = '';
    if ($product->pro_type == 0) {
        $linkt = 'product';
    } elseif ($product->pro_type == 1) {
        $linkt = 'services';
    } elseif ($product->pro_type == 2) {
        $linkt = 'coupon';
    }

    $af = isset($afLink) ? $afLink : '';

    $filename = DOMAIN_CLOUDSERVER . 'media/images/product/'.$product->pro_dir.'/thumbnail_3_'. explode(',', $product->pro_image)[0];
    if($product->pro_image == ',,,' || $product->pro_image == ''){
        $filename = base_url(). 'media/images/noimage.png';
    }

    $link = $siteURL.'product/detail/'.$product->pro_id.'/'.RemoveSign($product->pro_name).$af;
    if($isAffiliate == TRUE){
        $link = $protocol.$shop->sho_link.'.'.$url.'/shop/'.$linkt.'/detail/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
    }

    $af = $this->session->userdata('af_id') ? $this->session->userdata('af_id') : (($siteGlobal->af_key != '' && $siteGlobal->isAffiliate) ? $siteGlobal->af_key : "");

    if(isset($af_id) && !empty($af_id)){
        $af =  $af_id;
    }

    if(in_array($this->session->userdata('sessionGroup'), json_decode(ListGroupAff, true) )) {
        $user_login = $this->user_model->get('af_key', "use_id = " . (int)$this->session->userdata('sessionUser'));
        $af = $user_login->af_key;
        $link = ($af != '') ? $link.'?af_id='.$af : $link;
    }
    
    ?>
    <div class="thumbox">
        <?php if ($product->pro_type == 2){ ?>
            <div class="tag_coupon"><i class="fa fa-tags"></i> Coupon</div>
        <?php } ?>
        <a href="<?php echo $link; ?>">
            <img src="<?php echo $filename; ?>"  onmouseover="tooltipPicture(this,'<?php echo $product->$siteURL . pro_id; ?>')" id="<?php echo $product->pro_id; ?>" class="image_boxpro img-responsive" alt="<?php echo($product->pro_name); ?>"/>
        </a>
    </div>
    <h4 class="pro_name"><a href="<?php echo $link; ?>"><?php echo sub($product->pro_name, 50); ?> </a></h4>

    <?php if($discount['saleOff'] > 0):?>
        <div class="saleoff">
            <img src="<?php echo $siteURL; ?>templates/shop/default/images/saleoff.png"/>
        </div>
    <?php endif;?>
    <?php if(false):?>
        <p class="pro_descr">
            <?php echo sub($product->pro_descr,250); ?>
        </p>
    <?php endif;?>
    <div class="price">
        <?php if ($product->pro_cost > $discount['salePrice']) { ?>
            <span
                class="sale-price"><?php echo lkvUtil::formatPrice($discount['salePrice'], 'đ'); ?></span>
            <span
                class="cost-price"><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></span>
        <?php } else { ?>
            <span
                class="sale-price"><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></span>
        <?php } ?>
    </div>
    <div class="button-group" id="bt_<?php echo $product->pro_id?>">
        <?php if($isAffiliate == TRUE){ ?>
        <a class="btn btn-default"  href="<?php echo $link; ?>">Xem chi tiết</a>
        <?php }else{ ?>
        <button class="btn btn-default  addToCart" type="button" title=""
                onclick="addCart(<?php echo $product->pro_id?>);"><i class="fa fa-cart-plus"></i>&nbsp;
        </button>

        <button class="btn btn-default  wishlist" type="button" title=""
                onclick="wishlist(<?php echo $product->pro_id?>);"><i class="fa fa-heart-o"></i>&nbsp;
        </button>
        <a class="btn btn-default  quickview"  href="<?php echo $link; ?>"><i class="fa fa-eye"></i>&nbsp;</a>
        <?php } ?>
        <input type="hidden" name="product_showcart" value="<?php echo $product->pro_id; ?>" />
        <?php
        $hiddenAf = '';
        if($afLink != ''){
            $af = explode('=', $afLink);
            $hiddenAf = $af[1];
        }
        ?>
        <input type="hidden" name="af_id" value="<?php echo $hiddenAf; ?>" />
        <input type="hidden" name="qty" value="<?php echo !empty($product->pro_minsale) ? $product->pro_minsale : 1 ?>" />
    </div>
</div>
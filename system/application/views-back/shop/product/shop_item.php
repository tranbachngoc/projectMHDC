<div class="product-item text-center">
<?php     
    $mainURL = $protocol.$domainName.'/';
    if(count(explode('.', $domainName)) === 3){
        $url = '';
        $strUrl = explode('.', $domainName);
        $url = $strUrl[1].'.'.$strUrl[2];
    }        

    $URLRoot = strstr($this->subURL, $domainName);
    $domain_user = substr($URLRoot, 0, strpos($URLRoot, '.'));
    $domain = substr($URLRoot, strlen($domain_user), strlen($URLRoot));    

    //$user = $this->user_model->get('use_group', "af_key = '" . $this->session->userdata('af_id')."'");
    $sho_user1 = $this->shop_model->get("(SELECT use_group FROM tbtt_user WHERE use_id = sho_user) AS user_group", "sho_link = '". $strUrl[0] ."'");

    $shop = $this->shop_model->get('sho_link, sho_user', "sho_user = " . (int)$product->pro_user);
    $filename = DOMAIN_CLOUDSERVER . 'media/images/product/'.$product->pro_dir.'/thumbnail_2_'. explode(',', $product->pro_image)[0];
    if(!empty($product->pro_image)){ //file_exists($filename) && 
    }else{
        $filename = base_url(). 'media/images/no_photo_icon.png';
    }
    // Nếu không có hình, load hình noimage.png (bỏ không dùng)
    if(!file_exists($filename) || $product->pro_image == ',,,' || $product->pro_image == ''){
        //$filename = 'media/images/noimage.png';
    }   
    
    $link = '';
    $linkt = '';
    if ($product->pro_type == 0) {
        $linkt = 'product';
    } elseif ($product->pro_type == 1) {
        $linkt = 'services';
    } elseif ($product->pro_type == 2) {
        $linkt = 'coupon';
    } 
    
    // Trường hợp có sub domain
    if(count(explode('.', $domainName )) === 3){
        //$link = $mainURL.$linkt.'/detail/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
        if($sho_user1->user_group == 3 || $sho_user1->user_group == 14){
            $link = '/shop/'.$linkt.'/detail/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
        } elseif ($sho_user1->user_group == 2) {
            $link = '//'.$shop->sho_link.'.'.$url.'/shop/'.$linkt.'/detail/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
        }
    } elseif (count(explode('.', $domainName )) === 2 && $domainName == domain_site) {
        // Trường hợp trên trang chủ AZIBAI, domain là "azibai.xyz" định nghĩa trong constant
        $link = '/'.$product->pro_category.'/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
    } elseif (count(explode('.', $domainName )) === 2) {
        // Trường hợp là doamin riêng, thực tế không tồn tại
        $link = '/shop/'.$linkt.'/detail/'.$product->pro_id.'/'.RemoveSign($product->pro_name);
    }



    // chuyển về azibai hết (tạm thời) 
    if(strpos( $domainName, 'azibai.xxx') !== false){
        $link = 'http://azibai.xxx/' . $product->pro_category .'/'. $product->pro_id .'/'.RemoveSign($product->pro_name);
    } else if(strpos( $domainName, 'azibai.xyz') !== false){
        $link = 'http://azibai.xyz/'.$product->pro_category. '/' . $product->pro_id.'/'.RemoveSign($product->pro_name);
    } else {
        $link = 'https://azibai.com/' .$product->pro_category. '/' . $product->pro_id.'/'.RemoveSign($product->pro_name);
    }

    if($sho_user1->user_group == 2 || !isset($af_id) || empty($af_id)){
        $af = $this->session->userdata('af_id') ? $this->session->userdata('af_id') : (($siteGlobal->af_key != '' && $siteGlobal->isAffiliate) ? $siteGlobal->af_key : "");
    } else {
       $af = '';
    }

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
            <a class="" href="<?php echo $link; ?>">
				<img src="<?php echo $filename; ?>" onmouseover="tooltipPicture(this,'<?php echo $product->pro_id; ?>')" id="<?php echo $product->pro_id; ?>" class="image_boxpro" alt="<?php echo $product->pro_name; ?>" />
			</a>
    </div>
    <div style="padding:1px 10px 10px;">
	<div class="pro_name">
	    <a href="<?php echo $link; ?>">
		<?php echo sub($product->pro_name, 50); ?> 
	    </a>
	</div>
	<?php if(false):?>
	    <p class="pro_descr">
		<?php echo sub($product->pro_descr,250); ?>
	    </p>
	<?php endif;?>
	    <div class="price">
        <?php if ($product->pro_cost > $discount['salePrice']) { ?>
            <span class="sale-price"><?php echo lkvUtil::formatPrice($discount['salePrice'], 'đ'); ?></span>
            <span class="cost-price"><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></span>
        <?php } else { ?>
            <span class="sale-price"><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></span>
        <?php } ?>
        </div>

        <div class="button-group" id="bt_<?php echo $product->pro_id?>">
            <a class="btn btn-default"  href="<?php echo $link; ?>">Xem chi tiết</a>
            <!-- <?php if ($sho_user1->user_group == 2) { ?>
            <a class="btn btn-default"  href="<?php echo $link; ?>">Xem chi tiết</a>
            <?php } else { ?>
            <button class="btn btn-default addToCart" type="button" onclick="addCart(<?php echo $product->pro_id?>);">
                <i class="fa fa-cart-plus"></i>&nbsp;
            </button>
            <button class="btn btn-default wishlist" type="button" onclick="wishlist(<?php echo $product->pro_id?>);">
                <i class="fa fa-heart-o"></i>&nbsp;
            </button>
            <a class="btn btn-default quickview"  href="<?php echo $link; ?>"><i class="fa fa-eye"></i>&nbsp;</a>
            <?php } ?> -->
            <!--<button class="btn btn-default  quickview" type="button" title=""
                    onclick="quickView(<?php /*echo $product->pro_id*/?>);"><i class="fa fa-eye"></i>&nbsp;
                </button>-->
            <?php $af_id = ($af != '') ? $af : $_REQUEST['af_id']; ?>
            <input type="hidden" name="product_showcart" value="<?php echo $product->pro_id; ?>" />
            <input type="hidden" name="af_id" value="<?php echo $af_id; ?>" />
            <input type="hidden" id="qty_<?php echo $product->pro_id; ?>" name="qty" value="<?php echo !empty($product->pro_minsale) ? $product->pro_minsale : 1 ?>" />
            <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->dp_id; ?>">
        </div>
    </div>
    

    <?php if($discount['saleOff'] > 0): ?>
        <div class="saleoff">
            <img src="/templates/shop/default/images/saleoff.png"/>
        </div>
    <?php endif;?>    
</div>
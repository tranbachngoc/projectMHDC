<?php if(count($product_new) > 0 ) { ?>
<div class="shop-product">
  <div class="container">
    <div class="shop-tit">
      <h3>sản phẩm mới</h3>
    </div>
    <div class="shop-product-items">
      <?php foreach ($product_new as $key => $value) { ?>
        <?php 
          $pro_image = explode(',', $value->pro_image)[0];
          $src = DOMAIN_CLOUDSERVER . 'media/images/product/' . $value->pro_dir . '/' . $pro_image;
          $price = $value->pro_cost;
          if($has_af_key == true && $value->is_product_affiliate == 1){
            if($value->af_dc_amt > 0){
              $price = $price - $value->af_dc_amt;
            } else if($value->af_dc_rate > 0){
              $price = $price - ($price * $value->af_dc_rate / 100);
            }
          }

          $price = number_format($price, 0, ",", ".");
          $link_item = azibai_url().'/'.$value->pro_category.'/'.$value->pro_id.'/'. RemoveSign($value->pro_name);
          if(!empty($af_id)){
            $link_item .= "?af_id=$af_id";
          }
        ?>
      <div class="item" id="bt_<?=$value->pro_id?>">
        <div class="img hovereffect">
          <img class="img-responsive" src="<?=$src?>" alt="">
          <div class="action">
            <p class="like js-like-product" data-id="<?php echo $value->pro_id; ?>">
            <?php if (!empty($value->is_like)) { ?>
                <img class="icon-img" src="/templates/home/styles/images/svg/like_pink.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg" >
             <?php } else { ?>
                <img class="icon-img" src="/templates/home/styles/images/svg/like_white.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg">
            <?php } ?>
            </p>
            <!-- <p><img src="/templates/home/styles/images/svg/bag_white.svg" alt="" onclick="addCart(<?=$value->pro_id?>)"></p> -->
            <p><img src="/templates/home/styles/images/svg/bookmark_white.svg" alt=""></p>
          </div>
        </div>
        <div class="text">
          <a href="<?=$link_item?>" target="_blank">
            <p class="tensanpham two-lines"><?=$value->pro_name?></p>
            <div class="giadasale">
              <span class="dong">đ</span><?=$price?></div>
            <!-- <div class="giachuasale">150.000.000</div> -->
          </a>
          <div class="sm-btn-show sm"><img src="/templates/home/styles/images/svg/shop_icon_add.svg" alt=""></div>
        </div>
        <input type="hidden" name="af_id" value="<?php echo $af_id; ?>" />
        <input type="hidden" name="qty" value="<?php echo !empty($value->pro_minsale) ? $value->pro_minsale : 1 ?>" />
        <input type="hidden" name="product_showcart" value="<?php echo $value->pro_id; ?>" />
        <input type="hidden" name="dp_id" value="<?php echo $value->dp_id; ?>" />
      </div>
      <?php } ?>
    </div>
    <div class="icon-add bg-white">
      <span><a href="<?=$current_profile['profile_url'].'affiliate-shop/product'?>">
        <img src="/templates/home/styles/images/svg/add_gray.svg" alt="">
      </a></span>
    </div>
  </div>
</div>
<?php } ?>

<?php if(count($coupon_new) > 0) { ?>
<div class="shop-product">
  <div class="container">
    <div class="shop-tit">
      <h3>coupon mới</h3>
    </div>
    <div class="shop-product-items">
      <?php foreach ($coupon_new as $key => $value) { ?>
        <?php 
          $pro_image = explode(',', $value->pro_image)[0];
          $src = DOMAIN_CLOUDSERVER . 'media/images/product/' . $value->pro_dir . '/' . $pro_image;
          $price = number_format($value->pro_cost, 0, ",", ".");
          $link_item = azibai_url().'/'.$value->pro_category.'/'.$value->pro_id.'/'. RemoveSign($value->pro_name);
          if(!empty($af_id)){
            $link_item .= "?af_id=$af_id";
          }
        ?>
      <div class="item" id="bt_<?=$value->pro_id?>">
        <div class="img hovereffect">
          <img class="img-responsive" src="<?=$src?>" alt="">
          <div class="action">
            <p class="like js-like-product" data-id="<?php echo $value->pro_id; ?>">
            <?php if (!empty($value->is_like)) { ?>
                <img class="icon-img" src="/templates/home/styles/images/svg/like_pink.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg" >
             <?php } else { ?>
                <img class="icon-img" src="/templates/home/styles/images/svg/like_white.svg" alt="like" data-like-icon="/templates/home/styles/images/svg/like_pink.svg" data-notlike-icon="/templates/home/styles/images/svg/like_white.svg">
            <?php } ?>
            </p>
            <!-- <p><img src="/templates/home/styles/images/svg/bag_white.svg" alt="" onclick="addCart(<?=$value->pro_id?>)"></p> -->
            <p><img src="/templates/home/styles/images/svg/bookmark_white.svg" alt=""></p>
          </div>
        </div>
        <div class="text">
          <a href="<?=$link_item?>" target="_blank">
            <p class="tensanpham two-lines"><?=$value->pro_name?></p>
            <div class="giadasale">
              <span class="dong">đ</span><?=$price?></div>
            <!-- <div class="giachuasale">150.000.000</div> -->
          </a>
          <div class="sm-btn-show sm"><img src="/templates/home/styles/images/svg/shop_icon_add.svg" alt=""></div>
        </div>
        <input type="hidden" name="af_id" value="<?php echo $af_id; ?>" />
        <input type="hidden" name="qty" value="<?php echo !empty($value->pro_minsale) ? $value->pro_minsale : 1 ?>" />
        <input type="hidden" name="product_showcart" value="<?php echo $value->pro_id; ?>" />
        <input type="hidden" name="dp_id" value="<?php echo $value->dp_id; ?>" />
      </div>
      <?php } ?>
    </div>
    <div class="icon-add bg-white">
      <span><a href="<?=$current_profile['profile_url'].'affiliate-shop/coupon'?>">
        <img src="/templates/home/styles/images/svg/add_gray.svg" alt="">
      </a></span>
    </div>
  </div>
</div>
<?php } ?>
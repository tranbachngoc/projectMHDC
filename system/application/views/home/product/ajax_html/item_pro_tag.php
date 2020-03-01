<?php 
  $discount = lkvUtil::buildPrice($v_user_pro, $this->session->userdata('sessionGroup'), false);
  if (!empty($v_user_pro->pro_image)) { 
    $imgs = explode(',', $v_user_pro->pro_image);
    $filename = DOMAIN_CLOUDSERVER . 'media/images/product/'. $v_user_pro->pro_dir .'/thumbnail_2_'. $imgs[0];              
  } else {
    $filename = base_url(). 'media/images/no_photo_icon.png';
  }

$pro_price = ($v_user_pro->hoahong['price_aff'] > 0) ? $v_user_pro->hoahong['price_aff'] : $v_user_pro->hoahong['priceSaleOff'];
?>


<li>
  <div class="images">
    <a href="<?php echo getAliasDomain().$v_user_pro->pro_category.'/'.$v_user_pro->pro_id.'/'. RemoveSign($v_user_pro->pro_name).'?af_key='.$af_key;?>" target="_blank" class="hrc<?php echo $v_user_pro->pro_id; ?>">
      <img src="<?php echo $filename; ?>" data-id="<?php echo $v_user_pro->pro_id; ?>" alt="<?php echo $v_user_pro->pro_name; ?>">
    </a>
    <div class="ctv-flash">
      <?php if (!empty($v_user_pro->is_product_affiliate) && !empty($this->session->userdata('sessionUser'))) { 
        if ($v_user_pro->pro_cost > $discount['salePrice']) {
          $giapro = $discount['salePrice'];
        }else{
          $giapro = $v_user_pro->pro_cost;
        }
        if($v_user_pro->af_rate > 0){
          $pthoahong = $v_user_pro->af_rate;
          $hoahongdetail = $giapro * ($pthoahong/100);
        }else{
          $hoahongdetail = $v_user_pro->af_off;
        }
        ?> 
        <span class="ctv">
          <!-- <a href="#javascript:void();" tabindex="0"> -->
            <img src="/templates/home/styles/images/svg/CTV.svg" style="width: 30px;" class="img-popup-ctv" data-toggle="modal" data-target="#myModal_ctv_<?php echo $v_user_pro->pro_id?>" data-id="<?php echo $v_user_pro->pro_id; ?>"
            data-key="<?php echo $hoahongdetail;?>"
            data-valuea="<?php echo $v_user_pro->af_rate;?>"
            data-valueb="<?php echo $v_user_pro->af_off;?>">
          <!-- </a> -->
        </span>
      <?php } ?>
      <?php
      $time_current = time();
      if (!empty($v_user_pro->pro_saleoff) && $time_current >= $v_user_pro->begin_date_sale && $v_user_pro->end_date_sale >= $time_current) {
        $difference = $v_user_pro->end_date_sale - $time_current;
        $hours = floor($difference / 3600);
        $minutes = floor(($difference / 60) % 60);
        $seconds = $difference % 60;
      ?>
      <div class="flash">
        <img src="/templates/home/styles/images/svg/flashsale_pink_sm.svg" alt="">
        <div class="time flash-sale_<?php echo $v_user_pro->pro_id?>" id="flash-sale_<?php echo $v_user_pro->pro_id?>">
          <script>
          cd_time(<?php echo $v_user_pro->end_date_sale * 1000?>,<?php echo $v_user_pro->pro_id?>, 'class');
          </script>
        </div>
      </div>
    <?php } ?>
    </div>
  </div>
  <a href="<?php echo getAliasDomain().$v_user_pro->pro_category.'/'.$v_user_pro->pro_id.'/'. RemoveSign($v_user_pro->pro_name);?>" target="_blank">
    <div class="text"> 
      <p class="txt" title="<?php echo $v_user_pro->pro_name; ?>"><?php echo sub($v_user_pro->pro_name, 50); ?></p>
      
      <div class="price">
        <?php
        if ($v_user_pro->have_num_tqc > 0)
        {
        ?>
          <span class="sale-price">Sản phẩm giá theo lựa chọn</span>
        <?php
        }
        else
        {
            ?>
        <?php if ($v_user_pro->pro_cost > $discount['salePrice']) { ?>
          <div class="current-price">
            <span class="dong">đ</span><?php echo lkvUtil::formatPrice($v_user_pro->pro_cost, '');?>
          </div>
          <div class="sale-price sale-price-product">
            <?php echo lkvUtil::formatPrice($pro_price, ''); ?>
          </div>
        <?php } else { ?>
          <div class="sale-price sale-price-product">
            <span class="dong">đ</span><?php echo lkvUtil::formatPrice($pro_price, '');?>
          </div>
        <?php } ?>
        <?php } ?>
      </div>
    </div>
  </a>
</li>

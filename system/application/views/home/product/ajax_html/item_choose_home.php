<?php 
  $discount = lkvUtil::buildPrice($v_user_pro, $this->session->userdata('sessionGroup'), false);
    if (!empty($v_user_pro->pro_image)) { 
      $imgs = explode(',', $v_user_pro->pro_image);
      $filename = DOMAIN_CLOUDSERVER . 'media/images/product/'. $v_user_pro->pro_dir .'/thumbnail_2_'. $imgs[0];              
    } else {
      $filename = base_url(). 'media/images/no_photo_icon.png';
    }
?>

<li>
  <a href="<?php echo getAliasDomain().$v_user_pro->pro_category.'/'.$v_user_pro->pro_id.'/'. RemoveSign($v_user_pro->pro_name).'?af_key='.$af_key;?>" target="_blank">
    <div class="images">
      <img src="<?php echo $filename; ?>" data-id="<?php echo $v_user_pro->pro_id; ?>" alt="<?php echo $v_user_pro->pro_name; ?>">
      <!-- <div class="flash-sale"><strong>Flash sale</strong><br>2: 12: 60</div> -->
    </div>
    <div class="text">
      <p style="color: white" title="<?php echo $v_user_pro->pro_name; ?>">
        <?php echo sub($v_user_pro->pro_name, 50); ?>
      </p>
      <?php if ($v_user_pro->pro_cost > $discount['salePrice']) { ?>

        <div class="current-price">
          <span>đ</span><?php echo lkvUtil::formatPrice($v_user_pro->pro_cost, '');?>
        </div>
        <div class="sale-price">
          <?php echo lkvUtil::formatPrice($discount['salePrice'], ''); ?>
        </div>
      <?php } else { ?>
        <div class="sale-price">
          <span>đ</span><?php echo lkvUtil::formatPrice($v_user_pro->pro_cost, '');?>
        </div>
      <?php } ?>
    </div>
  </a>
</li>















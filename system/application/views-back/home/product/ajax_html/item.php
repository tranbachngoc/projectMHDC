<?php 
	$discount = lkvUtil::buildPrice($v_user_pro, $this->session->userdata('sessionGroup'), false);
    if (!empty($v_user_pro->pro_image)) { 
      $imgs = explode(',', $v_user_pro->pro_image);
      $filename = DOMAIN_CLOUDSERVER . 'media/images/product/'. $v_user_pro->pro_dir .'/thumbnail_2_'. $imgs[0];              
    } else {
      $filename = base_url(). 'media/images/no_photo_icon.png';
    }
?>

<li class="choose-pro-tag" data-id="<?php echo $v_user_pro->pro_id; ?>">
  <div class="image" data-id="<?php echo $v_user_pro->pro_id; ?>">
	  <img class="lazy" data-src="<?php echo $filename; ?>" src="<?php echo $filename; ?>" data-id="<?php echo $v_user_pro->pro_id; ?>" alt="<?php echo $v_user_pro->pro_name; ?>">
	  <span class="icon-chon">
	   <img data-id="<?php echo $v_user_pro->pro_id; ?>" src="<?=base_url()?>templates/home/images/svg/chon.svg" alt="">
	  </span>
	  <div class="btn-chon" data-id="<?php echo $v_user_pro->pro_id; ?>">Chọn</div>
  </div>
  <div class="decs">
    <?php echo sub($v_user_pro->pro_name, 50); ?><br>
    <?php if ($v_user_pro->pro_cost > $discount['salePrice']) { ?>
      <span class="cost-price">
        <?php echo lkvUtil::formatPrice($v_user_pro->pro_cost, 'đ');?>
      </span>
      <span class="sale-price">
        <?php echo lkvUtil::formatPrice($discount['salePrice'], 'đ'); ?>
      </span>
    <?php } else { ?>
      <span class="sale-price">
        <?php echo lkvUtil::formatPrice($v_user_pro->pro_cost, 'đ');?>
      </span>
    <?php } ?>
  </div>
</li>
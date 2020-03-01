<?php 
  $discount = lkvUtil::buildPrice($v_user_pro, $this->session->userdata('sessionGroup'), false);
    if (!empty($v_user_pro->pro_image)) { 
      $imgs = explode(',', $v_user_pro->pro_image);
      $filename = DOMAIN_CLOUDSERVER . 'media/images/product/'. $v_user_pro->pro_dir .'/thumbnail_2_'. $imgs[0];              
    } else {
      $filename = base_url(). 'media/images/no_photo_icon.png';
    }
?>


<div class="item" data-id="<?php echo $v_user_pro->pro_id; ?>">
  <div class="image">
    <img src="<?php echo $filename; ?>" data-id="<?php echo $v_user_pro->pro_id; ?>" alt="<?php echo $v_user_pro->pro_name; ?>">
    <span class="icon-chon remove-prodct-choose" data-id="<?php echo $v_user_pro->pro_id; ?>">
     <img data-id="<?php echo $v_user_pro->pro_id; ?>" src="<?=base_url()?>templates/home/images/svg/xoa.svg" alt="">
    </span>
    <div class="btn-chon" data-id="<?php echo $v_user_pro->pro_id; ?>">Xóa</div>
  </div>
  <div class="text">
    <div class="tit"><?php echo sub($v_user_pro->pro_name, 50); ?></div>
    <?php if ($v_user_pro->pro_cost > $discount['salePrice']) { ?>
      <div class="current-price">
        <span>đ</span><?php echo lkvUtil::formatPrice($v_user_pro->pro_cost, '');?>
      </div>
      <div class="price">
        <?php echo lkvUtil::formatPrice($discount['salePrice'], ''); ?>
      </div>
    <?php } else { ?>
      <div class="price"><span class="dong">đ</span><?php echo lkvUtil::formatPrice($v_user_pro->pro_cost, '');?></div>
    <?php } ?>
  </div>
</div>

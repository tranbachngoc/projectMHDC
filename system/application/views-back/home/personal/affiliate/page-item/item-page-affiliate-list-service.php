<?php
$link = azibai_url('/affiliate/list/') . $item['id'] . '?uid='.$item['user_id'].'&type_sv='.$item['type_affiliate'].'&af_id=' . $item['af_key'];
?>
<div class="col-xl-3 col-lg-4 col-md-4">
  <div class="item">
    <div class="img">
      <a href="<?=$link?>">
        <img src="<?=$item['sImage']?>" class="main-img" alt="thanhvien.html">
      </a>
      <?php if($_REQUEST['type_sv'] == 1) { ?>
      <div class="action">
        <?php if($user_infomation['affiliate_level'] < 3 && $user_infomation['affiliate_level'] != 0) { ?>
        <a class="js-setup-service-all" href="javascript:void(0)" title="Cấu hình"
          data-id="<?=$item['id'];?>">
          <img src="/templates/home/styles/images/svg/settings_white.svg" width="20" alt="">
        </a>
        <?php } ?>
        <a href="javascript:void(0)" title="Chia sẻ" class="get-link" data-url="<?=base_url()?>shop/service/detail/<?=$item['id'].'?af_id='.$user_infomation['af_key']?>">
          <img src="/templates/home/styles/images/svg/share_white.svg" width="20" alt="">
        </a>
      </div>
      <?php }?>
    </div>
    <div class="text">
      <p class="two-lines tit"><a href="<?=$link?>"><?=$item['name']?></a></p>
      <?php if (!empty($item['iDiscountPrice'])) { ?>
      <p class="price-before">Giá gốc:&#12288;
        <span><?=number_format($item['iPrice'], 0, ',', '.');?> VNĐ</span>
      </p>
      <p class="price-after">Giá giảm:&#12288;
        <span><?=number_format($item['iDiscountPrice'], 0, ',', '.');?> VNĐ</span>
      </p>
      <?php } else { ?>
      <p class="price-after">Giá gốc:&#12288;
        <span><?=number_format($item['iPrice'], 0, ',', '.');?> VNĐ</span>
      </p>
      <?php } ?>
      <p>
        <img src="/templates/home/styles/images/svg/ctv_sm.svg" alt="" width="20" class="mr05">Hoa hồng:
        <span class="text-blue"><?=$item['iDiscountPercen']?>%</span>
      </p>
    </div>
  </div>
</div>
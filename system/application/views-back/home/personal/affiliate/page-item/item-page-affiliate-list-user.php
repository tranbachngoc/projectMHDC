<div class="item moreBox-item" data-search="<?=$item['use_fullname']?>">
  <div class="infor">
    <div class="avata"><a href="<?=$item['sLink']?>" target="_blank">
      <img src="<?=$item['avatar']?>" onerror="error_image(this)" class="avata-img" alt="">
      <?php if(!in_array($item['affiliate_level'], [0])) { ?>
      <span class="bg-no">
        <img src="/templates/home/styles/images/svg/bg_no.svg" alt="">
      </span>
      <span class="no"><?=$item['affiliate_level']?></span>
      <?php } ?>
    </a></div>
    <div class="name">
      <div class="tit one-line"><a href="<?=$item['sLink']?>" target="_blank"><?=$item['use_fullname']?></a></div>
      <?php if(!in_array($item['affiliate_level'], [0])) { ?>
      <div class="order">
        <div class="number"><?=(int)$item['iTotalOrder'] > 0 ? $item['iTotalOrder'] . ' đơn hàng' : 'Chưa có đơn hàng nào' ?></div>
        <div class="price">
          <img src="/templates/home/styles/images/svg/CTV.svg" alt="" class="mr10"><?=number_format($item['amount'], 0, ',', '.')?> VNĐ</div>
      </div>
      <?php } ?>
      <div class="name-staff">Thuộc: <?=$item['parent_name']?></div>
    </div>
  </div>
  <div class="actions">
    <?php if(!empty($item['use_email'])) { ?>
    <a href="mailto:<?=$item['use_email']?>">
      <img src="/templates/home/styles/images/svg/message03.svg" alt="">
    </a>
    <?php } ?>
    <a href="tel:<?=$item['use_mobile']?>">
      <img src="/templates/home/styles/images/svg/tel.svg" alt="">
    </a>
    <a href="javascript:void(0)" class="js-menu-item"
      data-id="<?=$item['use_id']?>"
      data-name="<?=$item['use_fullname']?>"
      data-level="<?=$item['affiliate_level']?>">
      <img src="/templates/home/styles/images/svg/3dot_doc.svg" alt="">
    </a>
  </div>
</div>
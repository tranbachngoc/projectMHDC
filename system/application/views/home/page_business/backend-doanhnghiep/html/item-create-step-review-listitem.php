<?php
$link = azibai_url("/{$item['pro_category']}/{$item['pro_id']}/"). RemoveSign($item['pro_name']);
?>
<div class="col-xl-4 col-md-6">
  <div class="item">
    <a href="<?=$link?>">
    <div class="show-time">
      <!-- <p>Hết hạn ngày: <?=date('H:i d-m-Y', $item['iTimeEnd'])?></p> -->
      <!-- <p><?=$item['isExpired'] == 1 ? 'Hết hạn' : 'Đang chạy' ?></p> -->
    </div>
    <div class="show-product">
      <img src="<?=$item['pro_image']?>" alt="">
      <div class="tt"><?=$item['pro_name']?>
      </div>
    </div>
    <!-- <div class="show-price">
      <p>
        <span class="txt">Giá niêm yết</span><?=$item['iPrice'] ? number_format($item['iPrice'], 0, ',', '.') : 0 ?> VNĐ</p>
      <p>
        <span class="txt">Giá ưu đãi</span><?=$item['iPriceDiscount'] ? number_format($item['iPrice'] - $item['iPriceDiscount'], 0, ',', '.') : number_format($item['iPrice'], 0, ',', '.') ?> VNĐ</p>
    </div> -->
    </a>
  </div>
</div>
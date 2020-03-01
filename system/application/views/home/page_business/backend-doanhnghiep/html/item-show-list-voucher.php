<?php
$link = azibai_url("/page-business/list-voucher/{$user_id}/detail?view={$item['id']}&back=1");
?>
<div class="col-xl-4 col-md-6">
  <div class="item">
    <a href="<?=$link?>">
    <div class="show-time">
      <p>Hết hạn ngày: <?=date('H:i d-m-Y', $item['iTimeEnd'])?></p>
      <p><?=$item['isExpired'] == 1 ? 'Hết hạn' : 'Đang chạy' ?></p>
    </div>
    <div class="show-product">
      <img src="<?=$item['sImage']?>" alt="">
      <div class="tt">Mã giảm giá <?=$item['iVoucherType'] == 1 ? $item['iValue'] . '%' : ($item['iVoucherType'] == 2 ? number_format($item['iValue'], 0, ',', '.') . ' VNĐ' : 0)?>
        <br><?=$item['iProductType'] == 1 ? 'Áp dụng cho tất cả sản phẩm của shop có giá trị đơn hàng tối thiểu: ' . number_format($item['iPriceRank'], 0, ',', '.') . ' VNĐ' : ($item['iProductType'] == 2 ? 'Áp dụng cho '.$item['iCountProduct'].' sản phẩm' : 0)?></div>
    </div>
    <div class="show-price">
      <p>
        <span class="txt">Giá niêm yết</span><?=$item['iPrice'] ? number_format($item['iPrice'], 0, ',', '.') : 0 ?> VNĐ</p>
      <p>
        <span class="txt">Giá ưu đãi</span><?=$item['iPriceDiscount'] ? number_format($item['iPrice'] - $item['iPriceDiscount'], 0, ',', '.') : number_format($item['iPrice'], 0, ',', '.') ?> VNĐ</p>
    </div>
    </a>
  </div>
</div>
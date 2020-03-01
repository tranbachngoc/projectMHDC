<?php
if($this->session->userdata('sessionAfKey')) {
  $af_key = '?af_id='.$this->session->userdata('sessionAfKey');
  $af_key_pu = $this->session->userdata('sessionAfKey');
}
if(!empty($_REQUEST['af_id'])) {
  $af_key = '?af_id='.$_REQUEST['af_id'];
  $af_key_pu = $_REQUEST['af_id'];
}
$link = azibai_url("/voucher/{$item['user_id']}/{$item['id']}{$af_key}");
$shop_url = shop_url($item);
$link_show_product = "{$shop_url}/library/vouchers/{$item['id']}{$af_key}";
if($item["iCountProduct"] == 0) {
  $link_show_product = "{$shop_url}/shop{$af_key}";
}

$json_data = json_encode([
  "item_name"=> "Mã giảm giá " . ($item["iVoucherType"] == 1 ? "{$item['iValue']}%" : ($item["iVoucherType"] == 2 ? number_format($item["iValue"],0,",",".") . " VNĐ" : $item["iValue"])),
  "item_price"=> $item['iDiscountPrice'],
  "item_id"=> $item['id'],
  "item_user_affiliate_key"=> $af_key_pu,
  "item_user_id"=> $this->session->userdata('sessionUser'),
  "item_type_affiliate" => 2,
  "item_discount_type" => $item['iVoucherType'],
]);
?>
<div class="col-xl-4 col-lg-6 col-md-6">
  <div class="item bg-coupon">
    <div class="bg-coupon-avata">
      <a href="<?=$link_show_product?>"><img src="<?=$item["sImage"]?>" class="main" alt=""></a>
      <h3 class="one-line"><?=$item["sShopName"]?></h3>
    </div>
    <div class="bg-coupon-info">
      <a href="<?=$link?>">
        <div class="tit">Giảm <?=$item["iVoucherType"] == 1 ? "{$item['iValue']}%" : ($item["iVoucherType"] == 2 ? number_format($item["iValue"],0,",",".") . " VNĐ" : $item["iValue"])?></div>
        <p><?=$item["iCountProduct"] > 0 ? "Áp dụng cho {$item["iCountProduct"]} sản phẩm" : ($item["iCountProduct"] == 0 ? "Đơn hàng tối thiểu " . number_format($item["iPriceRank"],0,",",".") . " VNĐ" : "")?></p>
      </a>
      <div class="time"><img src="/templates/home/styles/images/svg/clock.svg" class="mr05 mt04" alt=""><?=$item["dTimeStart"]?>  đến <?=$item["dTimeEnd"]?></div>
      <div class="buynow">
        <div class="buynow-price"><?=number_format($item["iDiscountPrice"],0,",",".")?> <span class="f12">đ</span></div>
        <?php if($this->session->userdata('sessionUser') > 0) { ?>
        <button class="buynow-btn js-show-popup-payment-voucher" data-json='<?=$json_data?>' >Mua ngay</button>
        <?php } else { ?>
        <button class="buynow-btn js-alert-login">Mua ngay</button>
        <script>
          $(".js-alert-login").click(function () {
            $("#js-show-alert .modal-body").html('<div>Vui lòng <a class="text-danger" href="<?=azibai_url("/login")?>">đăng nhập</a> để mua mã giảm giá</div>');
            $("#js-show-alert").modal("show");
          })
        </script>
        <?php } ?>
      </div>
    </div>
  </div>
</div>
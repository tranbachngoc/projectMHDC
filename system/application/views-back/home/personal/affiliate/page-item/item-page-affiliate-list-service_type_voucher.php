<?php
if($this->session->userdata('sessionAfKey')) {
  $af_key = '?af_id='.$this->session->userdata('sessionAfKey');
  $af_key_pu = $this->session->userdata('sessionAfKey');
}
if(!empty($_REQUEST['af_id'])) {
  $af_key = '?af_id='.$_REQUEST['af_id'];
  $af_key_pu = $_REQUEST['af_id'];
}
$link = azibai_url("/voucher/{$item['user_id']}/{$item['id']}$af_key");
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

// dd($item);
// dd(json_decode($json_data));

?>

<div class="col-xl-4  col-lg-6 col-md-6">
  <div class="item bg-coupon">
    <a class="bg-coupon-avata" href="<?=$link_show_product?>">
      <img src="<?=$item['sImage']?>" class="main" alt="">
      <h3 class="two-lines"><?=$item['sShopName']?></h3>
    </a>
    <div class="bg-coupon-info">
      <a href="<?=$link?>">
        <div class="tit"><?=$item['name']?></div>
        <p><?=$item["iCountProduct"] > 0 ? "Áp dụng cho {$item["iCountProduct"]} sản phẩm" : ($item["iCountProduct"] == 0 ? "Đơn hàng tối thiểu " . number_format($item["iPriceRank"],0,",",".") . " VNĐ" : "")?></p>
        <div class="time"><img src="/templates/home/styles/images/svg/clock.svg" class="mr05" alt=""><?=$item["dTimeStart"]?> đến <?=$item["dTimeEnd"]?></div>
      </a>
      <div class="buynow">
        <div class="buynow-price"><?=number_format($item["iDiscountPrice"],0,",",".")?> <span class="f12">đ</span></div>
        <!-- <button class="buynow-btn">Mua ngay</button> -->
        <button class="buynow-btn"><a href="<?=$link?>">Chi tiết</a></button>
      </div>
    </div>
  </div>
</div>

<!--
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
-->

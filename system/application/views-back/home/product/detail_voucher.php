<?php
if($this->session->userdata('sessionAfKey')) {
  $af_key = '?af_id='.$this->session->userdata('sessionAfKey');
  $af_key_pu = $this->session->userdata('sessionAfKey');
}
if(!empty($_REQUEST['af_id'])) {
  $af_key = '?af_id='.$_REQUEST['af_id'];
  $af_key_pu = $_REQUEST['af_id'];
}
$shop_url = shop_url($detail_voucher);

$this->load->view('home/common/header_new');
?>
<link href="/templates/home/styles/css/content.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/coupon.css" rel="stylesheet" type="text/css">

<script src="/templates/home/styles/js/countdown.js"></script>

<main class="trangcuatoi coupondisplay sanphamchitiet ">
  <section class="main-content">
    <div class="breadcrumb md">
      <div class="container">
        <ul>
          <li>
            <a href="<?=azibai_url("/shop/products{$af_key}")?>">azibai</a>
            <img src="/templates/home/styles/images/svg/breadcrumb_arrow.svg" class="ml10" alt="">
          </li>
          <li>
            <a href="javascript:void(0)">Mã giảm giá</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="container">
      <!-- <div class="info-shop">
        <div class="left">
          <div class="logo">
            <img src="<?=$detail_voucher["sShopImage"]?>" alt="">
          </div>
          <div class="name">
            <h3><?=$detail_voucher["sShopName"]?>
              <br>
              <span class="md">Online 15 phút trước</span>
            </h3>
            <p class="md">
              <strong>456</strong> Người theo dõi
              </p>
          </div>
        </div>
        <div class="right sm" data-toggle="modal" data-target="#congtacvien">
          <img src="/templates/home/styles/images/svg/3dot_doc.svg" alt="">
        </div>
        <div class="right md">
          <p>
            <span class="theodoi">Theo dõi</span>
            <img data-toggle="modal" data-target="#congtacvien" class="mt05" src="/templates/home/styles/images/svg/CTV.svg" alt="">
          </p>
          <ul class="sanpham-danhgia">
            <li>
              <span>29</span>
              <br>Sản phẩm</li>
            <li>
              <span>4.5</span>
              <br>Đánh giá</li>
          </ul>
        </div>
      </div> -->
      <div class="coupon-content">
        <div class="sanphamchitiet-content row preview-coupon">
          <div class="col-xl-4 col-md-6">
            <div class="preview-coupon-img">
              <div class="img">
                <img src="<?=$detail_voucher["sImage"]?>" alt="">
              </div>
              <div class="group-action-likeshare">
                <!-- <div class="show-number-action version02">
                  <ul>
                    <li data-toggle="modal" data-target="#luotthich">
                      <img src="/templates/home/styles/images/svg/liked.svg" class="mr05" alt="">48</li>
                    <li>15 bình luận</span>
                    </li>
                    <li>5 chia sẻ</span>
                    </li>
                  </ul>
                </div>
                <div class="action">
                  <div class="action-left">
                    <ul class="action-left-listaction">
                      <li class="like">
                        <img class="icon-img" src="/templates/home/styles/images/svg/like.svg" alt="like">
                      </li>
                      <li class="comment">
                        <img class="icon-img" src="/templates/home/styles/images/svg/comment.svg" alt="comment">
                      </li>
                      <li class="share-click">
                        <span>
                          <img class="icon-img" src="/templates/home/styles/images/svg/share.svg" alt="share">
                        </span>
                      </li>
                      <li>
                        <img src="/templates/home/styles/images/svg/bookmark.svg" alt="">
                      </li>
                    </ul>
                  </div>
                </div> -->
              </div>
            </div>
          </div>
          <div class="col-xl-8 col-md-6">
            <div class="sanphamchitiet-content-detail">
              <h2 class="f18 mb20">Mã giảm giá <?=$detail_voucher["iVoucherType"] == 1 ? "{$detail_voucher['iValue']}%" : ($detail_voucher["iVoucherType"] == 2 ? number_format($detail_voucher["iValue"],0,",",".") . " VNĐ" : $detail_voucher["iValue"])?></h2>
              <p><?=$detail_voucher["iCountProduct"] > 0 ? "Áp dụng cho <a href='$shop_url/library/vouchers/{$detail_voucher['id']}'>{$detail_voucher["iCountProduct"]} sản phẩm</a>" : "Áp dụng cho <a href='$shop_url/library/vouchers/{$detail_voucher['id']}'>tất cả sản phẩm</a>"?> của shop:
                <a href="<?=$shop_url?>" class="text-red">Cửa hàng mua sắm trực tuyến</a>
                <br> <?=$detail_voucher["iCountProduct"] == 0 ? "Đơn hàng tối thiểu: " . number_format($detail_voucher["iPriceRank"],0,",",".") . " VNĐ" : ""?></p>
              <div class="thongso">
                <h3 class="mb10">Thời gian áp dụng:</h3>
                <p><?=$detail_voucher["dTimeStart"]?> đến <?=$detail_voucher["dTimeEnd"]?></p>
                <div class="price mt10">
                  <div class="no-sale f14">
                    <span><?=number_format($detail_voucher["iPrice"],0,",",".")?></span>
                    <strong class="dong">đ</strong>
                  </div>
                  <div class="sale f18"><?=number_format($detail_voucher["iDiscountPrice"],0,",",".")?>
                    <strong class="dong">đ</strong>/Mã</div>
                </div>
                <div class="price mt10">
                  <strong class="no-sale">Tổng giá: </strong>
                  <span class="sale"><?=number_format($detail_voucher["iDiscountPrice"],0,",",".")?> VNĐ</span>
                </div>
                <div class="buttons-group mt20 mb20">
                  <!-- <button class="btn-addcart btn-bg-white ml00 mr20 f16">Thêm vào giỏ</button> -->
                  <?php if($this->session->userdata('sessionUser') > 0) { ?>
                    <button class="btn-buynow btn-bg-gray f16" data-toggle="modal" data-target="#popup-payment-voucher">Mua ngay</button>
                  <?php } else { ?>
                    <button class="btn-buynow btn-bg-gray f16 js-alert-login">Mua ngay</button>
                    <script>
                      $(".js-alert-login").click(function () {
                        $("#js-show-alert .modal-body").html('<div>Vui lòng <a class="text-danger" href="<?=azibai_url("/login")?>">đăng nhập</a> để mua mã giảm giá</div>');
                        $("#js-show-alert").modal("show");
                      })
                    </script>
                  <?php } ?>
                </div>
                <p>Mã giảm giá được sử dụng để mua hàng của shop, bao gồm tất cả các sản phẩm đang trong chương trình
                  khuyến mãi
                  <br>
                  <br>Mã giảm giá không được chuyển đổi thành tiền mặt và không được hoàn lại tiền thừa
                  <br>
                  <br> Tối đa 01 mã giảm giá /01 đơn
                  <br>
                  <br>Sản phẩm mã giảm giá không được xuất hóa đơn
                  <br>
                  <br>Sản phẩm mã giảm giá không được áp dụng đổi trả</p>
              </div>
            </div>
          </div>
        </div>

        <div class="coupondisplay-content-item trangcuahang-ver2">
          <div class="tit">
            <h3 class="sub-tt one-line">Sản phẩm được áp dụng</h3>
            <a href="<?="$shop_url/library/vouchers/{$detail_voucher['id']}"?>" class="seemore">Xem tất cả</a>
          </div>
          <div class="detail shop-product">
            <div class="shop-product-items js-shop-product-items">
              <?php foreach ($detail_voucher["aListProduct"] as $key => $item) {
                $link = azibai_url("/{$item['pro_category']}/{$item['pro_id']}/") . RemoveSign($item['pro_name']) . $af_key;
                ?>
                <div class="item"><a href="<?=$link?>">
                  <div class="img hovereffect">
                    <img class="img-responsive" src="<?=$item["pro_image"]?>" alt="">
                    <!-- <div class="action">
                      <p><a href=""><img src="/templates/home/styles/images/svg/like_white.svg" alt=""></a></p>
                      <p><a href=""><img src="/templates/home/styles/images/svg/bag_white.svg" alt=""></a></p>
                      <p><a href=""><img src="/templates/home/styles/images/svg/bookmark_white.svg" alt=""></a></p>
                      <div class="ctv"><a href="">
                        <img src="/templates/home/styles/images/svg/CTV.svg" alt="" class="md">
                        <img src="/templates/home/styles/images/svg/ctv_sm.svg" alt="" class="sm">
                      </a></div>
                    </div> -->
                    <div class="flash">
                      <!-- <img src="/templates/home/styles/images/svg/flashsale_pink.svg" class="md" alt=""> -->
                      <img src="/templates/home/styles/images/svg/flashsale_pink_sm.svg" alt="" >
                      <div class="time flash-sale_iTimeEnd"></div>
                    </div>
                  </div>
                  <div class="text">
                    <p class="tensanpham two-lines"><?=$item["pro_name"]?></p>
                    <div class="giadasale"><span class="dong">đ</span><?=number_format($item["pro_dis"],0,",",".")?></div>
                    <div class="giachuasale"><?=number_format($item["pro_cost"],0,",",".")?></div>
                  </div>
                </a></div>
              <?php } ?>
            </div>
          </div>
        </div>
        <script>cd_time(<?=$detail_voucher["iTimeEnd"] * 1000?>, 'iTimeEnd', true)</script>

        <div class="coupondisplay-content-item">
          <div class="tit">
            <h3 class="sub-tt one-line">Mã giảm giá liên quan</h3>
            <a href="<?="$shop_url/library/vouchers"?>" class="seemore">Xem tất cả</a>
          </div>
          <div class="detail">
            <ul class="js-coupon-recent-items coupon-recent-items">
              <?php foreach ($detail_voucher["aListVoucher"] as $key => $item) { 
                $link = azibai_url("/voucher/{$item['user_id']}/{$item['id']}{$af_key}");
                ?>
              <li>
                <div class="item bg-coupon">
                  <div class="bg-coupon-avata">
                    <img src="<?=$item["sImage"]?>" class="main" alt="">
                    <h3 class="one-line"><?=$item["sShopName"]?></h3>
                  </div>
                  <div class="bg-coupon-info">
                    <a href="<?=$link?>">
                      <div class="tit">Giảm <?=$item["iVoucherType"] == 1 ? "{$item['iValue']}%" : ($item["iVoucherType"] == 2 ? number_format($item["iValue"],0,",",".") . " VNĐ" : $item["iValue"])?></div>
                      <p><?=$item["iCountProduct"] > 0 ? "Áp dụng cho {$item["iCountProduct"]} sản phẩm" : "Áp dụng cho tất cả sản phẩm"?></p>
                      <p><?=$item["iCountProduct"] == 0 ? "Đơn hàng tối thiểu " . number_format($item["iPriceRank"],0,",",".") . " VNĐ" : ""?></p>
                    </a>
                    <div class="time"><img src="/templates/home/styles/images/svg/clock.svg" class="mr05 mt04" alt=""><?=$item["dTimeStart"]?>  đến <?=$item["dTimeEnd"]?></div>
                    <div class="buynow">
                      <div class="buynow-price"><?=number_format($item["iDiscountPrice"],0,",",".")?> <span class="f12">đ</span></div>
                      <button class="buynow-btn"><a href="<?=$link?>">Chi tiết</a></button>
                    </div>
                  </div>
                </div>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

</main>
<footer id="footer"> </footer>
<?php $this->load->view('e-azibai/common/common-overlay-waiting', $data, FALSE); ?>

<?php $this->load->view('home/product/popup/popup-payment-voucher', [
  "item_name"=> "Mã giảm giá " . ($detail_voucher["iVoucherType"] == 1 ? "{$detail_voucher['iValue']}%" : ($detail_voucher["iVoucherType"] == 2 ? number_format($detail_voucher["iValue"],0,",",".") . " VNĐ" : $detail_voucher["iValue"])),
  "item_price"=> $detail_voucher['iDiscountPrice'],
  "item_id"=> $detail_voucher['id'],
  "item_user_affiliate_key"=> $af_key_pu,
  "item_user_id"=> $this->session->userdata('sessionUser'),
  "item_type_affiliate" => 2,
  "item_discount_type" => $detail_voucher['iVoucherType'],
], FALSE);?>

<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/styles/js/slick.js"></script>
<script type="text/javascript">
  // $('.coupondisplayFilter').modal('show');
  // $(".form_datetime").datetimepicker({
  //     format: "hh:ii - dd MM yyyy"
  // });
  $(document).ready(function(){
    $('.js-shop-product-items').slick({
      slidesToShow: <?=count($detail_voucher["aListProduct"]) > 4 ? 4 : count($detail_voucher["aListProduct"])?>,
      slidesToScroll: <?=count($detail_voucher["aListProduct"]) > 4 ? 4 : count($detail_voucher["aListProduct"])?>,
      arrows: true,
      responsive: [
      {
        breakpoint: 1025,
        settings: {
          slidesToShow: <?=count($detail_voucher["aListProduct"]) > 3 ? 3 : count($detail_voucher["aListProduct"])?>,
          slidesToScroll: <?=count($detail_voucher["aListProduct"]) > 3 ? 3 : count($detail_voucher["aListProduct"])?>,
        }
      },
      {
        breakpoint: 769,
        settings: {
          slidesToShow: <?=count($detail_voucher["aListProduct"]) > 2 ? 2 : count($detail_voucher["aListProduct"])?>,
          slidesToScroll: <?=count($detail_voucher["aListProduct"]) > 2 ? 2 : count($detail_voucher["aListProduct"])?>,
          arrows: false, 
        }
      },
      
      ]
    });
    $('.js-coupon-recent-items').slick({
      slidesToShow: 3,
      slidesToScroll: 3,
      arrows: true,      
      responsive: [
      {
        breakpoint: 1025,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2,
        }
      },

      {
        breakpoint: 769,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false, 
        }
      },
      
      ]
    });
  })
</script>

</div>
</body>
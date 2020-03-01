<?php
if(!($current_profile['is_show_storetab'] != 0 || $current_profile['use_id'] == $this->session->userdata('sessionUser'))) {
  redirect(base_url(),'refresh');
}

if($this->session->userdata('sessionAfKey')) {
  $af_key = '?af_id='.$this->session->userdata('sessionAfKey');
}
if(!empty($_REQUEST['af_id'])) {
  $af_key = '?af_id='.$_REQUEST['af_id'];
}
?>

<link href="/templates/home/styles/css/coupon.css" rel="stylesheet">

<?php if($current_profile['use_id'] == $this->session->userdata('sessionUser')) { ?>
<div class="coupondisplay-showShop">
  <div class="coupondisplay-showShop-tit">
    <h2>Hiện cửa hàng</h2> 
    <div class="custom-control custom-switch">
      <input type="checkbox" class="custom-control-input js-active-show-shop-person" value="<?=$current_profile['is_show_storetab'] != 0 ? "0" : "1"?>" id="customSwitches"
      <?=$current_profile['is_show_storetab'] != 0 ? "checked" : ""?>
      >
      <label class="custom-control-label" for="customSwitches"></label>
    </div>
  </div>
  <script>
    $(".js-active-show-shop-person").click(function (event) {
      $.ajax({
        type: "post",
        url: "<?=base_url()."home/api_common/change_show_person_shop"?>",
        data: {show_storetab: $(".js-active-show-shop-person").val()},
        dataType: "json",
        success: function (response) {
          if(response.status == 1) {
            location.reload();
          } else {
            alert("Xử lý thất bại");
            location.reload();
          }
        },
        error: function () {
          alert("Xử lý thất bại");
          location.reload();
        }
      });
    })
  </script>
  <p>Người khác sẽ thấy mục cửa hàng trên trang cá nhân của bạn.</p>
</div>
<?php } ?>
<div class="coupondisplay-listServices">
  <div class="item">
    <a href="<?=$current_profile['profile_url'].'affiliate-shop/voucher'?>">
    <img src="/templates/home/styles/images/svg/magiamgia.svg">
    <br>Mã giảm giá
    </a>
  </div>
  <div class="item">
    <a href="<?=$current_profile['profile_url'].'affiliate-shop/product'?>">
    <img src="/templates/home/styles/images/svg/sanpham02.svg">
    <br>Sản phẩm
    </a>
  </div>
  <div class="item">
    <a href="<?=$current_profile['profile_url'].'affiliate-shop/coupon'?>">
    <img src="/templates/home/styles/images/svg/dichvu02.svg">
    <br>Dịch vụ
    </a>
  </div>
  <!-- <div class="item">
    <a href="">
    <img src="/templates/home/styles/images/svg/danhmuc02.svg">
    <br>Danh mục
    </a>
  </div>
  <div class="item">
    <a href="">
    <img src="/templates/home/styles/images/svg/shop02.svg">
    <br>Shop
    </a>
  </div> -->
</div>

<div class="coupondisplay-content trangcuahang-ver2">
  <div class="coupondisplay-content-banner">
    <div class="js-coupondisplay-banner">
      <div class="items">
        <img src="/templates/home/styles/images/product/sanazibai/banner01.jpg" alt="">
      </div>
      <div class="items">
        <img src="/templates/home/styles/images/product/sanazibai/banner02.jpg" alt="">
      </div>
      <div class="items">
        <img src="/templates/home/styles/images/product/sanazibai/banner03.jpg" alt="">
      </div>
    </div>
  </div>
  <div class="coupondisplay-category">
    <a class="item <?=$type_segment === '' ? 'active' :''?>" href="<?=$info_public['profile_url'] . 'voucher'.$af_key?>">Tất cả</a>
    <a class="item <?=$type_segment === '0' || $type_segment === 0? 'active' :''?>" href="<?=$info_public['profile_url'] . 'affiliate-shop/voucher/type/0'.$af_key?>">Mới nhất</a>
    <a class="item <?=$type_segment === '1' || $type_segment === 1? 'active' :''?>" href="<?=$info_public['profile_url'] . 'affiliate-shop/voucher/type/1'.$af_key?>">Bán chạy</a>
    <a class="item filter" href="#coupondisplayFilter" data-toggle="modal"><img src="/templates/home/styles/images/svg/filter.svg" class="mr05">Bộ lọc</a>
  </div>

  <div class="coupondisplay-content-item">
    <div class="tit">
      <h3 class="sub-tt one-line">Tìm kiếm mã giảm giá</h3>
    </div>
    <div class="detail">
      <div class="row">
        <?php foreach ($aAll as $key => $item) {
          $this->load->view('home/personal/affililate-shop-v2/elements/voucher_item', ["item"=>$item], FALSE);
        }?>
      </div>
    </div>
  </div>

  <?=$pagination_html?>
</div>

<?php $this->load->view('home/product/popup/popup-payment-voucher');?>
<?php $this->load->view('home/personal/affililate-shop-v2/popup/popup-filter-voucher', ["info_public"=>$info_public], FALSE);?>

<script type="text/javascript">
  $(document).ready(function () {
    function setBoundries(slick, state) {
      if (state === 'default') {
        slick.find('ul.slick-dots li').eq(2).addClass('n-small-1');
      }
    }

    // Slick Selector.
    var slickSlider = $('.js-coupondisplay-banner');
    var maxDots = 3;
    var transformXIntervalNext = -18;
    var transformXIntervalPrev = 18;

    slickSlider.on('init', function (event, slick) {

      console.log(number);
      $(this).find('ul.slick-dots').wrap("<div class='slick-dots-container'></div>");
      $(this).find('ul.slick-dots li').each(function (index) {
        $(this).addClass('dot-index-' + index);
      });
      $(this).find('ul.slick-dots').css('transform', 'translateX(0)');
      setBoundries($(this), 'default');
      var number = $(this).find('ul.slick-dots li').length;
      if (number <= 2) {
        $(this).find('.slick-dots-container').addClass("lessthanfour");
      }
    });

    var transformCount = 0;
    slickSlider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
      var totalCount = $(this).find('.slick-dots li').length;
      if (totalCount > maxDots) {
        if (nextSlide > currentSlide) {
          if ($(this).find('ul.slick-dots li.dot-index-' + nextSlide).hasClass('n-small-1')) {
            if (!$(this).find('ul.slick-dots li:last-child').hasClass('n-small-1')) {
              transformCount = transformCount + transformXIntervalNext;
              $(this).find('ul.slick-dots li.dot-index-' + nextSlide).removeClass('n-small-1');
              var nextSlidePlusOne = nextSlide + 1;
              $(this).find('ul.slick-dots li.dot-index-' + nextSlidePlusOne).addClass('n-small-1');
              $(this).find('ul.slick-dots').css('transform', 'translateX(' + transformCount + 'px)');
              var pPointer = nextSlide - 1;
              var pPointerMinusOne = pPointer - 1;
              $(this).find('ul.slick-dots li').eq(pPointerMinusOne).removeClass('p-small-1');
              $(this).find('ul.slick-dots li').eq(pPointer).addClass('p-small-1');
            }
          }
        }
        else {
          if ($(this).find('ul.slick-dots li.dot-index-' + nextSlide).hasClass('p-small-1')) {
            if (!$(this).find('ul.slick-dots li:first-child').hasClass('p-small-1')) {
              transformCount = transformCount + transformXIntervalPrev;
              $(this).find('ul.slick-dots li.dot-index-' + nextSlide).removeClass('p-small-1');
              var nextSlidePlusOne = nextSlide - 1;
              $(this).find('ul.slick-dots li.dot-index-' + nextSlidePlusOne).addClass('p-small-1');
              $(this).find('ul.slick-dots').css('transform', 'translateX(' + transformCount + 'px)');
              var nPointer = currentSlide + 1;
              var nPointerMinusOne = nPointer - 1;
              $(this).find('ul.slick-dots li').eq(nPointer).removeClass('n-small-1');
              $(this).find('ul.slick-dots li').eq(nPointerMinusOne).addClass('n-small-1');
            }
          }
        }
      }
    });

    $('.js-coupondisplay-banner').slick({
      slidesToShow: 1,
      slidesToScroll: 1,
      dots: true,
      focusOnSelect: true,
      infinite: false,
      arrows: false
    });
  });
</script>
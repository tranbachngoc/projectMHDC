<?php
if($this->session->userdata('sessionAfKey')) {
  $af_key = '?af_id='.$this->session->userdata('sessionAfKey');
}
if(!empty($_REQUEST['af_id'])) {
  $af_key = '?af_id='.$_REQUEST['af_id'];
}
?>
<div class="coupondisplay-category">
  <a class="item" href="<?=base_url()."library/vouchers".$af_key?>">Tất cả</a>
  <a class="item" href="<?=base_url()."library/vouchers/type/0".$af_key?>">Mới nhất</a>
  <a class="item" href="<?=base_url()."library/vouchers/type/1".$af_key?>">Bán chạy</a>
</div>
<div class="coupondisplay-content">
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

  <div class="coupondisplay-content-item trangcuahang-ver2">
    <div class="tit">
      <h3 class="sub-tt one-line">Sản phẩm áp dụng mã giảm giá</h3>
    </div>
    <div class="detail shop-product">
      <div class="shop-product-items js-append-data">
        <?php foreach ($list_product["data"] as $key => $item) {
          $this->load->view('shop/media/elements/voucher-item-show-product', ["item"=>$item], FALSE);
        } ?>
      </div>
    </div>
  </div>

  <?=$pagination_html?>
</div>

<?php $this->load->view('shop/media/popups/popup-filter-voucher', $data, FALSE);?>

<script type="text/javascript">
 $(document).ready(function() {
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

<script type="text/javascript">
  var _page = 1;
  var has_next = 1;
  var is_processing = false;
  $(window).scroll(function(event) {
    if(has_next == 1 && $(window).scrollTop() > $(document).height() - $(window).height() - 200) {
      if(is_processing == true) {
        event.stopPropagation();
        return false;
      }

      is_processing = true;
      _page = _page + 1;
      url = window.location.href;

      $.ajax({
        type: "GET",
        url: url,
        data: {page: _page},
        dataType: "html",
        success: function (html) {
          if(html != '') {
            $(".js-append-data").append(html);
          } else {
            has_next = 0;
          }
        },
        error: function () {
          has_next = 0;
          alert("Lỗi kết nối");
        }
      }).always(function () {
        is_processing = false;
      });
      return false;
    } else {
      console.log("not");
    }
  });
</script>
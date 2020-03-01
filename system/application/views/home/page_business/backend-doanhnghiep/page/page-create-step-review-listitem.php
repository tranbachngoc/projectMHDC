<?php
unset($_REQUEST['prolist']);
$back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
// dd($list_product);die;
?>
<div class="coupon-tt">
  <a href="<?=$back_link?>">
    <i class="fa fa-angle-left" aria-hidden="true"></i>Mã giảm giá đã đăng</a>
</div>
<div class="coupon-content">
  <div class="posted-coupon coupon-content-creat">
    <div class="creat-item-content">
      <div class="apply-for-product">
        <div class="search mt00">
          <input type="text" class="form-control js-search-keyword" placeholder="Tìm kiếm theo tên">
          <img src="/templates/home/styles/images/svg/search.svg" alt="">
        </div>
        <div class="show-result">
          <div class="tt">Sản phẩm (<?=$list_product['total'] ? $list_product['total'] : 0 ?>)</div>
        </div>
      </div>
    </div>
    <div class="posted-coupon-list row data-append">
      <?php foreach ($list_product['data'] as $key => $item) { 
        $this->load->view('home/page_business/backend-doanhnghiep/html/item-create-step-review-listitem', ['item'=>$item,'user_id'=>$user_id]);
      } ?>
    </div>
  </div>
</div>

<script>
  // scroll append data pop library
  var __is_busy = false;
  var __stopped = false;
  var __page = 1;
  var __keyword = '';

  $(window).scroll(function (event) {
    if ($(this).scrollTop() + $(this).find('.item').height() >= $(this).height()) {
      if (__is_busy == true) {
        event.stopPropagation();
        return false;
      }
      if (__stopped == true) {
        event.stopPropagation();
        return false;
      }
      __is_busy = true;
      __page++;

      $.ajax({
        type: 'post',
        dataType: 'html',
        url: window.location.href,
        data: { page: __page, search: __keyword},
        success: function (result) {
          if (result == '') {
            __stopped = true;
          }
          if (result) {
            $('.data-append').append(result);
          }
        }
      }).always(function () {
        __is_busy = false;
      });
      return false;
    }
  });
</script>

<script>
  $('.js-search-keyword').on('keypress', function (e) {
    if(e.which == 13) { // enter
      __is_busy = false;
      __stopped = false;
      __page = 1;
      __keyword = $(this).val();

      $.ajax({
        type: 'post',
        dataType: 'html',
        url: window.location.href,
        data: { page: __page, search: __keyword},
        success: function (result) {
          if (result == '') {
            __stopped = true;
          }
          if (result) {
            $('.data-append').html(result);
          }
        }
      }).always(function () {
        __is_busy = false;
      });
      return false;
    }
  })
</script>
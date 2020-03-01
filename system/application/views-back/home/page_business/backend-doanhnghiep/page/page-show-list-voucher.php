<?php
$back_link = azibai_url("/page-business/{$user_id}");
$create_link = azibai_url("/page-business/create-voucher/{$user_id}?step=1&back=1");

?>
<div class="coupon-tt">
  <a href="<?=$back_link?>">
    <i class="fa fa-angle-left" aria-hidden="true"></i>Mã giảm giá đã đăng</a>
</div>
<div class="coupon-content">
  <div class="posted-coupon coupon-content-creat">
    <a href="<?=$create_link?>" class="btn-add-coupon">
      <img src="/templates/home/styles/images/svg/add_circle_white02.svg" alt="" class="mr10">Thêm mã giảm giá</a>
    <div class="creat-item-content">
      <div class="apply-for-product">
        <!-- <div class="search mt00">
          <input type="text" class="form-control" placeholder="Tìm kiếm theo tên">
          <img src="/templates/home/styles/images/svg/search.svg" alt="">
        </div> -->
        <div class="show-result">
          <div class="tt">Sản phẩm (<?=$list_voucher['total'] ? $list_voucher['total'] : 0 ?>)</div>
        </div>
      </div>
    </div>
    <div class="posted-coupon-list row data-append">
      <?php foreach ($list_voucher['data'] as $key => $item) { 
        $this->load->view('home/page_business/backend-doanhnghiep/html/item-show-list-voucher', ['item'=>$item,'user_id'=>$user_id]);
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
<?php
$is_review = 0;
if(isset($_REQUEST['is_review']) && $_REQUEST['is_review'] == 1) {
  $is_review = 1;
}

$back_link = azibai_url();
if($is_review === 1) {
  $_REQUEST['step'] = 2;
  $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
} else if($is_review === 0) {
  $request_tmp = $_REQUEST;
  $request_tmp['step'] = 2;
  unset($request_tmp['voucher_type']);
  unset($request_tmp['value']);
  $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($request_tmp);
}

// next step review
$params_review = $_REQUEST;
$params_review['step'] = 7;
$params_review['skip'] = 1;
unset($params_review['is_review']);
$link_review = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($params_review);
?>


<div class="coupon-tt">
  <a href="<?=$back_link?>">
    <i class="fa fa-angle-left" aria-hidden="true"></i>Số lượng
  </a>
  <a href="<?=$link_review?>">
    <p class="previous"><img src="/templates/home/styles/images/svg/eye_on.svg" class="mr05" alt=""><span class="md">Xem trước</span></p>
  </a>
</div>
<div class="coupon-stepdot">
  <ul>
    <li class="active">
      <span></span>
    </li>
    <li class="active">
      <span></span>
    </li>
    <li class="active">
      <span></span>
    </li>
    <li>
      <span></span>
    </li>
    <li>
      <span></span>
    </li>
    <li>
      <span></span>
    </li>
  </ul>
</div>
<div class="coupon-content">
  <div class="coupon-content-creat">
    <div class="creat-item-content">
      <div class="apply-for-all">
        <p class="mb10">Nhập số lượng mã giảm giá cần bán</p>
        <input type="text" class="form-control js-quantily" placeholder="Nhập số" value="<?=$_REQUEST['is_review'] == 1 ? $_REQUEST['quantily'] : ''?>">
        <p class="small-text">Tổng số mã giảm giá có thể cung cấp</p>
      </div>
    </div>
    <div class="text-center js-next-step-4">
      <a href="javascript:void(0)" class="btn-continue">Tiếp tục</a>
    </div>
  </div>
</div>

<script>
  var quantily = 0
  $('.js-quantily').on('change', function () {
    quantily = parseInt($(this).val());
    if(quantily < 1 || isNaN(quantily)){
      $(this).val('');
      quantily = 0;
    } else {
      $(this).val(quantily);
    }
  });

  <?php if($is_review == 1 && @$_REQUEST['quantily']) { ?>
    $(document).ready(function(){
      quantily = <?=$_REQUEST['quantily']?>;
      $('.js-next-step-4 > a').click(function () {
        <?php
        $_REQUEST['step'] = 4;
        unset($_REQUEST['quantily']);
        $url = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
        ?>
        var url = '<?=$url?>';

        if(quantily > 0) {
          url = url + '&quantily=' + quantily;

          window.location.href = url;
          return false;
        }
      });
    });
  <?php } else { ?>
    $('.js-next-step-4 > a').click(function () {
      <?php
      $_REQUEST['step'] = 4;
      $url = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
      ?>
      url = '<?=$url?>'

      if(quantily > 0) {
        url = url + '&quantily=' + quantily;
        window.location.href = url;
        return false;
      }
    });
  <?php } ?>
</script>
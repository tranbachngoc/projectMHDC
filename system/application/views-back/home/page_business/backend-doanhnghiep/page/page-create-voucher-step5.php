<?php
$is_review = 0;
if(isset($_REQUEST['is_review']) && $_REQUEST['is_review'] == 1) {
  $is_review = 1;
}

$back_link = azibai_url();
if($is_review === 1) {
  $_REQUEST['step'] = 4;
  $back_link = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
} else if($is_review === 0) {
  $request_tmp = $_REQUEST;
  $request_tmp['step'] = 4;
  unset($request_tmp['time_start']);
  unset($request_tmp['time_end']);
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
    <i class="fa fa-angle-left" aria-hidden="true"></i>Cho phép cộng tác viên bán hộ</a>
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
    <li class="active">
      <span></span>
    </li>
    <li class="active">
      <span></span>
    </li>
    <li>
      <span></span>
    </li>
  </ul>
</div>
<div class="coupon-content">
  <ul class="ctv-list">
    <li>
      <label class="checkbox-style-circle">
        <input type="radio" name="apply" value="2" class="js-apply">
        <span>Chỉ cho hệ thống cộng tác viên của tôi bán</span>
      </label>
    </li>
    <li>
      <label class="checkbox-style-circle">
        <input type="radio" name="apply" value="3" class="js-apply">
        <span>Chỉ cho hệ thống cộng tác viên của azibai bán</span>
      </label>
    </li>
    <li>
      <label class="checkbox-style-circle">
        <input type="radio" name="apply" value="1" class="js-apply">
        <span>Cho phép tất cả</span>
      </label>
    </li>
  </ul>
  <div class="text-center js-next-step-6" style="display:none">
    <a href="javascript:void(0)" class="btn-continue">Tiếp tục</a>
  </div>
</div>

<script>
  $('.js-apply').click(function () {
    $('.js-next-step-6').show();
  });

  <?php if($is_review == 1 && @$_REQUEST['apply']) { ?>
    $(document).ready(function(){
      setTimeout(function(){
        $.each($('.js-apply'), function (i, e) {
          $(e).val() == <?=$_REQUEST['apply']?> ? $(e).trigger('click') : '';
        })
      }, 500)
    })

    $('.js-next-step-6 > a').click(function () {
      <?php
      $_REQUEST['step'] = 6;
      unset($_REQUEST['apply']);
      $url = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
      ?>
      url = '<?=$url?>'

      var apply = parseInt($('.js-apply:checked').val());
      if (apply === 1 || apply === 2 || apply === 3) {
        url = url + '&apply=' + apply;

        window.location.href = url;
        return false;
      }
    });

  <?php } else { ?>
    $('.js-next-step-6 > a').click(function () {
      <?php
      $_REQUEST['step'] = 6;
      $url = azibai_url("/page-business/create-voucher/{$user_id}?") . http_build_query($_REQUEST);
      ?>
      url = '<?=$url?>'

      var apply = parseInt($('.js-apply:checked').val());
      if (apply === 1 || apply === 2 || apply === 3) {
        url = url + '&apply=' + apply;
        window.location.href = url;
        return false;
      }
    });
  <?php } ?>
</script>
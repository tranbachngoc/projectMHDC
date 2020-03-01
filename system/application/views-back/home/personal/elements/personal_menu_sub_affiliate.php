<?php
$current_url = get_current_full_url();
$segments = explode('/',parse_url($current_url, PHP_URL_PATH));
$last_segments = end($segments);
$prev_last_segments = prev($segments);
## ex: https://www.php.net/manual/en/function.prev.php
?>
<?php if(isset($show_affiliate_menu) && $show_affiliate_menu == 1) {?>
  <div class="affiliate-menupage">
    <ul>
      <li class="<?=$last_segments == 'affiliate' ? 'active' : ''?>">
        <a href="<?=azibai_url('/affiliate')?>">
          <span class="icon">
            <img src="/templates/home/styles/images/svg/affiliate_home<?=$last_segments == 'affiliate' ? '_on' : ''?>.svg" alt="">
          </span>
          <br>
          <span class="tit">Trang chủ</span>
        </a>
      </li>
      <?php if(isset($show_affiliate_menu) && $show_affiliate_menu == 1) { ?>
      <li class="<?=$last_segments == 'user' ? 'active' : ''?>">
        <a href="<?=azibai_url('/affiliate/user?affiliate=all')?>">
          <span class="icon">
            <img src="/templates/home/styles/images/svg/affiliate_staff<?=$last_segments == 'user' ? '_on' : ''?>.svg" alt="">
          </span>
          <br>
          <span class="tit">Thành viên</span>
        </a>
      </li>
      <?php } ?>
      <li class="<?=$last_segments == 'list' ? 'active' : ''?>">
        <a href="<?=azibai_url('/affiliate/list?type_sv=1&af_id=').$current_profile['af_key']?>">
          <span class="icon">
            <img src="/templates/home/styles/images/svg/affiliate_coupon<?=$last_segments == 'list' ? '_on' : ''?>.svg" alt="">
          </span>
          <br>
          <span class="tit">Cửa hàng</span>
        </a>
      </li>
      <li class="<?=($last_segments == 'order' || $prev_last_segments == 'order') ? 'active' : ''?>">
        <a href="<?=azibai_url('/affiliate/order?type=0')?>">
          <span class="icon">
            <img src="/templates/home/styles/images/svg/affiliate_order<?=($last_segments == 'order' || $prev_last_segments == 'order') ? '_on' : ''?>.svg" alt="">
          </span>
          <br>
          <span class="tit">Đơn hàng</span>
        </a>
      </li>
      <li class="<?=in_array($last_segments, ['income', 'income-provisonal-sum', 'income-history', 'income-payment', 'income-payment-account']) ? 'active' : ''?>">
        <a href="<?=azibai_url('/affiliate/income')?>">
          <span class="icon">
            <img src="/templates/home/styles/images/svg/affiliate_income<?=in_array($last_segments, ['income', 'income-provisonal-sum', 'income-history', 'income-payment', 'income-payment-account']) ? '_on' : ''?>.svg" alt="">
          </span>
          <br>
          <span class="tit">Thu nhập</span>
        </a>
      </li>
      <li class="<?=in_array($last_segments, ['statistic']) ? 'active' : ''?>">
        <a href="<?=azibai_url('/affiliate/statistic?view=general')?>">
          <span class="icon">
            <img src="/templates/home/styles/images/svg/affiliate_statis<?=in_array($last_segments, ['statistic']) ? '_on' : ''?>.svg" alt="">
          </span>
          <br>
          <span class="tit">Thống kê</span>
        </a>
      </li>
    </ul>
  </div>
<?php } ?>

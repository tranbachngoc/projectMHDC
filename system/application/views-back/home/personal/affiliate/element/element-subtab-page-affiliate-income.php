<?php
$current_url = get_current_full_url();
$segments = explode('/',parse_url($current_url, PHP_URL_PATH));
$last_segments = end($segments);
$prev_last_segments = prev($segments);
## ex: https://www.php.net/manual/en/function.prev.php
?>

<div class="affiliate-category">
  <ul>
    <li class="<?=$last_segments == 'income' ? 'active' : ''?>">
      <a href="<?=azibai_url('/affiliate/income')?>">Số dư</a>
    </li>
    <li class="<?=$last_segments == 'income-provisonal-sum' ? 'active' : ''?>">
      <a href="<?=azibai_url('/affiliate/income-provisonal-sum')?>">Tạm tính</a>
    </li>
    <li class="<?=$last_segments == 'income-history' ? 'active' : ''?>">
      <a href="<?=azibai_url('/affiliate/income-history?view=all')?>">Lịch sử</a>
    </li>
    <li class="<?=$last_segments == 'income-payment' ? 'active' : ''?>">
      <a href="<?=azibai_url('/affiliate/income-payment')?>">Tài khoản nhận tiền</a>
    </li>
  </ul>
</div>
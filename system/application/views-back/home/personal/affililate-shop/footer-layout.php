<?php
// dd($myshop_url);
// dd($azitab['myshop']);
// dd($azitab['user']);
// dd($profile_shop_url);
// dd($current_profile);
// dd($this->session->userdata('sessionUser'));
// die;

?>
<footer id="footer" class="footer-border-top">
  <div class="container footer">
    <ul class="footer-link">
      <li>
        <h3><?=$current_profile['use_fullname']?></h3>
        <p><?=$current_profile['use_address']?></p>
        <p><span><?=$current_profile['district']['DistrictName']?></span> <span><?=$current_profile['province']['pre_name']?></span></p>
        <p><span><?=$current_profile['use_email']?></span></p>
        <p><span><?=$current_profile['use_mobile']?></span></p>
      </li>
      <li>
        <p>
          <a href="javascript:void(0)">Hướng dẫn mua hàng</a>
        </p>
        <p>
          <a href="javascript:void(0)">Hướng dẫn thanh toán</a>
        </p>
        <p>
          <a href="javascript:void(0)">Quy định về sản phẩm</a>
        </p>
        <p>
          <a href="javascript:void(0)">Quy định về thông tin </a>
        </p>
      </li>
      <li>
        <p>
          <a href="<?=azibai_url('/login')?>">Đăng nhập</a>
        </p>
        <p>
          <a href="javascript:void(0)">Cộng tác với cửa hàng</a>
        </p>
      </li>
      <li>
        <p>Giờ làm việc</p>
        <p>Thứ 2 - thứ 6: 8h - 17h30</p>
        <p>Thứ 7 - Chủ nhật: 8h - 12h</p>
      </li>
    </ul>
  </div>
</footer>
<footer id="footer" class="footer-border-top">
  <div class="container footer">
    <ul class="footer-link">
      <li>
        <h3><?=$shop_current->sho_name?> | <?=$shop_current->sho_descr?></h3>
        <p><?=$shop_current->sho_address?></p>
        <p><span><?=$shop_current->distin->DistrictName?></span> <span><?=$shop_current->distin->ProvinceName?></span></p>
        <p><span><?=$shop_current->sho_email?></span></p>
        <p><span><?=$shop_current->sho_phone?></span> <span><?=$shop_current->sho_mobile?></span></p>
      </li>
      <li>
        <p>
          <a href="">Hướng dẫn mua hàng</a>
        </p>
        <p>
          <a href="">Hướng dẫn thanh toán</a>
        </p>
        <p>
          <a href="">Quy định về sản phẩm</a>
        </p>
        <p>
          <a href="">Quy định về thông tin </a>
        </p>
      </li>
      <li>
        <p>
          <a href="<?=$shop_url.'login'?>">Đăng nhập</a>
        </p>
        <p>
          <a href="">Cộng tác với cửa hàng</a>
        </p>
        <h3>THEO DÕI CHÚNG TÔI TRÊN</h3>
        <?php if(!empty($shop_current->sho_facebook)){?>
        <p>
          <a href="<?=$shop_current->sho_facebook?>">
            <img src="/templates/home/styles/images/svg/facebook.svg" width="24" class="mr05" alt="">facebook</a>
        </p>
        <?php }?>
        <!-- <p>
          <a href="">
            <img src="/templates/home/styles/images/svg/instagram.svg" width="24" class="mr05" alt="">instagram</a>
        </p> -->
      </li>
      <li>
        <p>Giờ làm việc</p>
        <p>Thứ 2 - thứ 6: 8h - 17h30</p>
        <p>Thứ 7 - Chủ nhật: 8h - 12h</p>
      </li>
    </ul>
  </div>
</footer>
<?php
if(isset($siteGlobal) && !empty($siteGlobal)){
  $sho_name = $siteGlobal->sho_name;
  $sho_address = $siteGlobal->sho_address;
  $sho_full_address = $siteGlobal->sho_address.', '.$siteGlobal->distin['DistrictName'].', '.$siteGlobal->distin['ProvinceName'];
  $sho_email = $siteGlobal->sho_email;
  $sho_phone = $siteGlobal->sho_phone;
  $sho_mobile = $siteGlobal->sho_mobile;
}else{
  $sho_name = $shop->sho_name;
  $sho_address = $shop->sho_address;
  $sho_full_address = $shop->sho_address.', '.$district_name.', '.$province_name;
  $sho_email = $shop->sho_email;
  $sho_phone = $shop->sho_phone;
  $sho_mobile = $shop->sho_mobile;
}
?>
<footer id="footer" class="footer-border-top">
  <div class="container footer">
    <ul class="footer-link">
      <li>
        <?php if ($sho_name){ echo '<h3>Gian hàng: '.$sho_name.'</h3>'; }?>
        <?php if ($sho_address) { echo $sho_full_address;} ?>
        <?php if ($sho_email) { echo '<p>'.$sho_email.'</p>'; } ?>
        <?php if ($sho_mobile || $sho_phone) { echo '<p>'.$sho_mobile.'  '.$sho_phone.'</p>'; } ?>
      </li>
      <li>
        <p><a href="">Hướng dẫn mua hàng</a></p>
        <p><a href="">Hướng dẫn thanh toán</a></p>
        <p><a href="">Quy định về sản phẩm</a></p>
        <p><a href="">Quy định về thông tin </a></p>
      </li>
      <li>
        <p><a href="">Đăng nhập</a></p>
        <p><a href="">Cộng tác với cửa hàng</a></p>
        <h3>THEO DÕI CHÚNG TÔI TRÊN</h3>
        <p><a href=""><img src="/templates/home/styles/images/svg/instagram.svg" width="24" class="mr05" alt="">facebook</a></p>
        <p><a href=""><img src="/templates/home/styles/images/svg/instagram.svg" width="24" class="mr05" alt="">instagram</a></p>
      </li>
      <?php
      if(isset($time_work))
      {
      ?>
      <li>
        <p>Giờ làm việc</p>
        <?php
        if(!empty($time_work))
        {
          if($time_work->type == 1){
            ?>
            <table>
              <tbody>
              <?php
              foreach ($time_work as $key => $value)
              {
                if($key != 'type')
                {
                ?>
                <tr>
                  <td class="weekday">
                  <?php
                  if($key == 0 || $key == 'Mon'){
                      $thu = 'Thứ 2';
                  }
                  if($key == 1 || $key == 'Tue'){
                      $thu = 'Thứ 3';
                  }
                  if($key == 2 || $key == 'Wed'){
                      $thu = 'Thứ 4';
                  }
                  if($key == 3 || $key == 'Thu'){
                      $thu = 'Thứ 5';
                  }
                  if($key == 4 || $key == 'Fri'){
                      $thu = 'Thứ 6';
                  }
                  if($key == 5 || $key == 'Sat'){
                      $thu = 'Thứ 7';
                  }
                  if($key == 6 || $key == 'Sun'){
                      $thu = 'Chủ nhật';
                  }
                  echo $thu;
                  ?>
                </td>
                <td style="padding-left: 5px;">
                  <?php
                  if($value->on == 0){
                      echo 'Nghỉ';
                  }
                  else{
                    if(!empty($value->am)){
                      echo $value->am->start.' - '.$value->am->end;
                    }
                    if(!empty($value->pm)){
                      echo ' | '.$value->pm->start.' - '.$value->pm->end;
                    }
                  }
                  ?>
                </td>
              </tr>
              <?php
              }
            }
          ?>
            </tbody>
          </table>
          <?php
          }else{
            if($time_work->type == 2){
                echo 'Luôn mở cửa';
            }else{
                echo 'Đóng cửa tạm thời hoặc vĩnh viễn';
            }
          }
        }
        ?>
      </li>
      <?php
      }
      ?>
    </ul>
  </div>
</footer>

</div>
</body>
</html>
<?php
$this->load->view('home/common/header_new');
?>
<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">
<script src="/templates/home/styles/js/common.js"></script>


<main>
  <?php 
    $avatar_default  = site_url('media/images/avatar/default-avatar.png');
  ?>      
  <section class="main-content business-management">
    <div class="container">
      <div class="bosuutap-header-tabs">
        <ul class="bosuutap-header-tabs-content">
          <li class="active"><a href="">Trang của bạn</a></li>
          <li><a href="">Trang đã theo dõi</a></li>
          <li><a href="">Lời mời <span class="number-invitation">19+</span></a></li>
        </ul>
      </div>
      <div class="business-management-title">
        <div class="avata">
          <img src="<?php echo !empty($user->avatar) ? $this->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $user->use_id . '/' .  $user->avatar : $avatar_default  ?>" alt="">
        </div>
        <br>
        <div class="name">Xin chào <span><?php echo $user->use_fullname; ?></span></div>
      </div>
      <div class="business-management-content">
        <div class="detail">
          <div class="title">
            <h4>Quản lý trang doanh nghiệp và chi nhánh</h4>
            <a class="cursor-pointer btn-creat-branch <?php echo $active_bran ? '' : 'disabled' ?>">Tạo chi nhánh</a>
          </div>
          <div class="manage-pages">
            <?php 
              if ($shop->domain != '') 
              {
                $linktoshop = 'http://' . $shop->domain;
              } 
              else 
              {
                $linktoshop = '//' . $shop->sho_link . '.' . domain_site;
              }
            ?>
            <div class="item">
              <div class="img"><a href="<?php echo $linktoshop ?>"><img src="<?php echo !empty($shop->sho_logo) ? $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/' . $shop->sho_dir_logo . '/' . $shop->sho_logo : $avatar_default  ?>" alt=""></a></div>
              <div class="text">
                <p class="name"><a href="<?php echo $linktoshop ?>"><?php echo $shop->sho_name; ?></a></p>
                <a class="cursor-pointer" href="<?php echo base_url() .'page-business/' . $shop->sho_user; ?>">Quản lý trang</a>
              </div>
            </div>

            <?php 
              if (!empty($list_bran)) {
                foreach ($list_bran as $key => $value) {
                  if ($value->domain != '') 
                  {
                    $linktoshop = 'http://' . $value->domain;
                  } 
                  else 
                  {
                    $linktoshop = '//' . $value->sho_link . '.' . domain_site;
                  }
            ?>
            <div class="item">

              <div class="img"><a href="<?php echo $linktoshop ?>"><img src="<?php echo !empty($value->sho_logo) ? $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/' . $value->sho_dir_logo . '/' . $value->sho_logo : $avatar_default  ?>" alt=""></a></div>
              <div class="text">
                <p class="name"><a href="<?php echo $linktoshop ?>"><?php echo $value->sho_name; ?></a></p>
                <a class="cursor-pointer" href="<?php echo base_url() .'page-business/' . $value->use_id; ?>">Quản lý trang</a>
              </div>
            </div>
            <?php } } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- The Modal -->
<div class="modal settingBranch" id="settingBranch">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Thiết lập chi nhánh <span class="name_branch"></span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <form id="js-form-config-bran" method="post">
      <div class="modal-body">
        <input type="hidden" name="id_branch" class="id_branch">
        <div class="creatBranch-content settingBranch-content">
          <?php if (!empty($master_rule)) { ?>
            <?php foreach ($master_rule as $key => $item) { ?>
              <p class="mb10">
                <label class="checkbox-style">
                  <input type="checkbox" class="shop_rule" name="shop_rule[]" value="<?php echo $item->id; ?>" id="shop_rule_<?php echo $item->id; ?>"><span><?php echo $item->content; ?></span>
                </label>
              </p>
              <?php if ($item->id == 50) { ?>
                <div class="shop_rule_bank">
                  <div class="form-group">
                    <label>Tên ngân hàng *</label>
                    <input type="text" name="namebank_regis" class="form-control" maxlength="250"  placeholder="" required>
                    <span class="text-red js-msg-error"></span>
                  </div>
                  <div class="form-group">
                    <label>Chi nhánh / Phòng giao dịch *</label>
                    <input type="text" name="addbank_regis" class="form-control" maxlength="250"  placeholder="" required>
                    <span class="text-red js-msg-error"></span>
                  </div>
                  <div class="form-group">
                    <label>Họ và tên chủ tài khoản *</label>
                    <input type="text" name="accountname_regis" class="form-control" maxlength="250"  placeholder="" required>
                    <span class="text-red js-msg-error"></span>
                  </div>
                  <div class="form-group">
                    <label>Số tài khoản *</label>
                    <input type="text" name="accountnum_regis" class="form-control" maxlength="20"  placeholder="" required>
                    <span class="text-red js-msg-error"></span>
                  </div>
                </div>
              <?php } else if ($item->id == 51) { ?>
                <div class="shop_rule_warehouse">
                  <div class="form-group">
                    <label>Tỉnh /  thành phố </label>
                    <select name="province_kho_shop" id="province_kho_shop" class="js-province form-control" required>
                        <option value="">Chọn Tỉnh/Thành Kho</option>
                        <?php foreach ($province as $provinceArray) { ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>">
                                  <?php echo $provinceArray->pre_name; ?>
                                </option>
                        <?php } ?>
                    </select>
                    <span class="text-red js-msg-error"></span>
                  </div>
                  <div class="form-group">
                    <label>Quận / Huyện</label>
                    <select name="district_kho_shop" id="district_kho_shop" class="js-district form-control" required>
                        <option value="">Chọn Quận / Huyện</option>
                    </select>
                    <span class="text-red js-msg-error"></span>
                  </div>
                  <div class="form-group">
                    <label>Địa chỉ kho hàng</label>
                    <input type="text" name="address_kho_shop" class="form-control"  placeholder="" required>
                    <span class="text-red js-msg-error"></span>
                  </div>
                </div>
              <?php } ?>
            <?php } ?>
          <?php } ?>
        </div>
      </div>   
      <div class="modal-footer">
        <div class="shareModal-footer">
          <div class="permision"></div>
          <div class="buttons-direct">
            <button class="btn-cancle">Hủy</button>
            <button class="btn-share js-config-bran" type="button">Xong</button>
          </div>
        </div>
      </div>
      </form>
      <!-- End modal-footer -->       
    </div>
  </div>
</div>
<!-- End The Modal -->

<!-- The Modal -->
<?php if ($active_bran) { ?>
<div class="modal creatBranch" id="creatBranch">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tạo chi nhánh</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="creatBranch-content">
          <form id="add_new_bran" method="post">
            <span class="text-red js-msg-error-sytem"></span>
            <div class="form-group">
              <label>Tên đăng nhập</label>
              <input type="text" required class="form-control username_regis" name="username_regis"  placeholder="">
              <span class="text-red js-msg-error"></span>
            </div>
            <div class="form-group">
              <label>Tên chi nhánh</label>
              <input type="text" required class="form-control sho_name_regis" name="sho_name_regis"  placeholder="">
              <span class="text-red js-msg-error"></span>
            </div>
            <div class="form-group">
              <label>Họ và tên</label>
              <input type="text" required class="form-control fullname_regis" name="fullname_regis"  placeholder="">
              <span class="text-red js-msg-error"></span>
            </div>
            <!-- <div class="form-group">
              <label>Email</label>
              <input type="text" required class="form-control email_regis" name="email_regis"  placeholder="">
              <span class="text-red js-msg-error"></span>
            </div> -->
            <div class="form-group">
              <label>Số điện thoại</label>
              <input type="text" required class="form-control mobile_regis" name="mobile_regis"  placeholder="">
              <span class="text-red js-msg-error"></span>
            </div>
            <div class="form-group">
              <label>Mật khẩu</label>
              <input type="password" required class="form-control password_regis" name="password_regis"  placeholder="">
              <span class="text-red js-msg-error"></span>
            </div>
            <div class="form-group">
              <label>Xác nhận mật khẩu</label>
              <input type="password" required class="form-control repassword_regis" name="repassword_regis"  placeholder="">
              <span class="text-red js-msg-error"></span>
            </div>
            <div class="shareModal-footer">
              <div class="permision"></div>
              <div class="buttons-direct">
                <button class="btn-cancle close" data-dismiss="modal">Hủy</button>
                <button class="btn-share js-new-bran" type="button">Xong</button>
              </div>
            </div>
          </form>
        </div>
      </div> 
      <!-- End modal-footer -->       
    </div>
  </div>
</div>
  <?php if ($_REQUEST['new_branch']) { ?>
  <script type="text/javascript">
      $('#creatBranch').modal('show');
  </script>
  <?php } ?>

<?php } ?>

<footer id="footer" class="footer-border-top">
<?php $this->load->view('e-azibai/common/common-html-footer'); ?>
<?php $this->load->view('home/common/overlay_waiting')?>
<script src="/templates/home/js/page_business.js"></script>
</footer>

<script type="text/javascript">
  function validate_phone(e) {
      if (e.length < 10 || e.length > 16) {
          return false
      } else {
          var t = "0123456789";
          for (var n = 0; n < e.length; n++) {
              if (t.indexOf(e.charAt(n)) == -1) {
                  return false
              }
          }
      }
      return true
  }

  function validate_character(e) {
      var t = "0123456789abcdefghikjlmnopqrstuvwxyszABCDEFGHIKJLMNOPQRSTUVWXYSZ_";
      for (var n = 0; n < e.length; n++) {
          if (t.indexOf(e.charAt(n)) == -1) {
              return false
          }
      }
      return true
  }

  function validate_email(email) {
    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    return regex.test(email);
  }

  // DistrictCode not id
  $('body').on('change', '.js-province', function() {
      var id_province = $(this).val();
      $('.load-wrapp').show();
      $.ajax({
            type: "POST",
            url: "/v-checkout/get-district",
            data: {id_province: id_province},
            dataType: "json",
            success: function (data) {
                var str = '<option value="">Chọn Quận/Huyện</option>';
                if (data.error == false && data.result.length > 0) {
                  $.each(data.result, function( index, value ) {
                    str += '<option value="'+value.DistrictCode+'">'+value.DistrictName+'</option>';
                  });
                }
                $('.js-district').html(str);
            }
      }).always(function() {
          $('.load-wrapp').hide();
      });
  });

  $('.btn-creat-branch').click(function(){
    $('#creatBranch').modal('show');   
  });

  $('#add_new_bran').submit(function(){
    return false;
  });

  $('.js-new-bran').click(function(){
      var username_regis = $.trim($('#add_new_bran .username_regis').val());
      // var email_regis = $.trim($('#add_new_bran .email_regis').val());
      var mobile_regis = $.trim($('#add_new_bran .mobile_regis').val());
      var password_regis = $.trim($('#add_new_bran .password_regis').val());
      var repassword_regis = $.trim($('#add_new_bran .repassword_regis').val());
      var fullname_regis = $.trim($('#add_new_bran .fullname_regis').val());
      var sho_name_regis = $.trim($('#add_new_bran .sho_name_regis').val());
      var error_new_bran = false;
      $('#add_new_bran .js-msg-error').text('');
      if (username_regis.length < 6) 
      {
        $('#add_new_bran .username_regis').next('.js-msg-error').text('Tài khoản phải có ít nhất 6 ký tự!'); 
        error_new_bran = true;
      }
      else if (username_regis.length > 35) 
      {
        $('#add_new_bran .username_regis').next('.js-msg-error').text('Tài khoản không được quá 35 ký tự!'); 
        error_new_bran = true;
      } 
      else if (!validate_character(username_regis)) 
      {
        $('#add_new_bran .username_regis').next('.js-msg-error').text('Tài khoản bạn nhập không hợp lệ! Chỉ chấp nhận các ký tự số 0-9 và các ký tự a-z và ký tự _'); 
        error_new_bran = true;
      }


      if (fullname_regis.length == 0) 
      {
        $('#add_new_bran .fullname_regis').next('.js-msg-error').text('Bạn chưa nhập họ và tên!'); 
        error_new_bran = true;
      }

      if (sho_name_regis.length == 0) 
      {
        $('#add_new_bran .sho_name_regis').next('.js-msg-error').text('Bạn chưa nhập tên chi nhánh!'); 
        error_new_bran = true;
      }

      // if (email_regis.length == 0) 
      // {
      //   $('#add_new_bran .email_regis').next('.js-msg-error').text('Bạn chưa nhập email!'); 
      //   error_new_bran = true;
      // }
      // else if (!validate_email(email_regis)) 
      // {
      //   $('#add_new_bran .email_regis').next('.js-msg-error').text('Email bạn nhập không hợp lệ!'); 
      //   error_new_bran = true;
      // }

      if (mobile_regis.length == 0) {
        $('#add_new_bran .mobile_regis').next('.js-msg-error').text('Bạn chưa nhập số điện thoại!'); 
        error_new_bran = true;
      }
      else if (!validate_phone(mobile_regis)) 
      {
        $('#add_new_bran .mobile_regis').next('.js-msg-error').text('Số điện thoại bạn nhập không hợp lệ!'); 
        error_new_bran = true;
      }

      if (password_regis.length < 6) 
      {
        $('#add_new_bran .password_regis').next('.js-msg-error').text('Mật khẩu phải có ít nhất 6 ký tự!');
        error_new_bran = true;
      }
      else if (password_regis.length > 35) 
      {
        $('#add_new_bran .password_regis').next('.js-msg-error').text('Mật khẩu không được quá 35 ký tự!'); 
        error_new_bran = true;
      } 
      else if (password_regis != repassword_regis) 
      {
        $('#add_new_bran .repassword_regis').next('.js-msg-error').text('Xác nhận mật khẩu không đúng!');
        error_new_bran = true;
      }
      
      if (!error_new_bran) 
      {
        $('.load-wrapp').show();
        $.ajax({
            type: 'POST',
            url: '/page-business/add-branch',
            data: $('#add_new_bran').serialize(),
            dataType: 'json',
            success: function (data) {
                if (Object.keys(data.error_validate).length != 0) 
                {
                  for (var key in data.error_validate){
                    $('#add_new_bran .' + key).next('.js-msg-error').text(data.error_validate[key]);
                  }
                } 
                else if (data.error_system) 
                {
                  $('#add_new_bran .js-msg-error-sytem').text('Thêm chi nhánh thất bại!');
                } 
                else
                {
                  $('#creatBranch').modal('hide');
                  $('#settingBranch .id_branch').val(data.data_new_branch.id_branch);
                  $('#settingBranch .name_branch').text(data.data_new_branch.name_branch);
                  $('#settingBranch').modal('show');
                }
            },
            error: function (data) {
                alert('Error');
            }
        }).always(function() {
            $('.load-wrapp').hide();
        });
      }
      return false;

  });

  $('input#shop_rule_50').change(function () {
      if ($(this).is(':checked')) {
          $('.shop_rule_bank').fadeOut(400);
          $('.shop_rule_warehouse input').removeAttr('required');
          $('.shop_rule_warehouse select').removeAttr('required');
      } else {
          $('.shop_rule_bank').fadeIn(400);
          $('.shop_rule_bank input').attr('required','required');
          $('.shop_rule_bank select').attr('required','required');
      }
  });

  $('input#shop_rule_51').change(function () {
      if ($(this).is(':checked')) {
          $('.shop_rule_warehouse').fadeOut(400);
          $('.address_kho_shop input').removeAttr('required');
          $('.address_kho_shop select').removeAttr('required');
      } else {
          $('.shop_rule_warehouse').fadeIn(400);
          $('.address_kho_shop input').attr('required','required');
          $('.address_kho_shop select').attr('required','required');
      }
  });

  $('.js-config-bran').click(function(){
      var error_cofig_bran = false;
      var id_branch = $('#settingBranch').find('.id_branch').val();
      $('#js-form-config-bran .js-msg-error').text('');
      if (!$('input#shop_rule_50').is(':checked')) 
      {
          // 250
          var namebank_regis = $.trim($('.shop_rule_bank input[name="namebank_regis"]').val());
          // 250 
          var addbank_regis = $.trim($('.shop_rule_bank input[name="addbank_regis"]').val());
          // 250
          var accountname_regis = $.trim($('.shop_rule_bank input[name="accountname_regis"]').val());
          // 20
          var accountnum_regis = $.trim($('.shop_rule_bank input[name="accountnum_regis"]').val());

          if (namebank_regis == '') 
          {
              error_cofig_bran = true;
              $('.shop_rule_bank input[name="namebank_regis"]').next('.js-msg-error').text('Bạn chưa nhập tên ngân hàng!'); 
          } 
          else if (namebank_regis.length > 250) 
          {
              $('.shop_rule_bank input[name="namebank_regis"]').next('.js-msg-error').text('Tên ngân hàng không được quá 250 ký tự!');
              error_cofig_bran = true; 
          }
          

          if (addbank_regis == '') 
          {
              $('.shop_rule_bank input[name="addbank_regis"]').next('.js-msg-error').text('Bạn chưa nhập Chi nhánh / Phòng giao dịch!');
              error_cofig_bran = true; 
          } 
          else if (addbank_regis.length > 250)
          {
              $('.shop_rule_bank input[name="addbank_regis"]').next('.js-msg-error').text('Chi nhánh / Phòng giao dịch không được quá 250 ký tự!');
              error_cofig_bran = true; 
          }

          if (accountname_regis == '') 
          {
              error_cofig_bran = true;
              $('.shop_rule_bank input[name="accountname_regis"]').next('.js-msg-error').text('Bạn chưa nhập họ và tên chủ tài khoản!');
          }
          else if (accountname_regis.length > 250)
          {
              $('.shop_rule_bank input[name="accountname_regis"]').next('.js-msg-error').text('Họ và tên chủ tài khoản không được quá 250 ký tự!');
              error_cofig_bran = true; 
          }

          if (accountnum_regis == '') 
          {
              $('.shop_rule_bank input[name="accountnum_regis"]').next('.js-msg-error').text('Bạn chưa nhập số tài khoản!');
              error_cofig_bran = true; 
          }
          else if (accountnum_regis.length > 20)
          {
              $('.shop_rule_bank input[name="accountnum_regis"]').next('.js-msg-error').text('Số tài khoản không được quá 20 ký tự!');
              error_cofig_bran = true; 
          } 
      }

      if (!$('input#shop_rule_51').is(':checked')) 
      {
          var province_kho_shop = $.trim($('#province_kho_shop').val());
          var district_kho_shop = $.trim($('#district_kho_shop').val());
          var address_kho_shop = $.trim($('.shop_rule_warehouse input[name="address_kho_shop"]').val());

          if (province_kho_shop == '') 
          {
              $('#province_kho_shop').next('.js-msg-error').text('Bạn chưa chọn "Tỉnh / thành phố"!');
              error_cofig_bran = true; 
          }

          if (district_kho_shop == '') 
          {
              $('#district_kho_shop').next('.js-msg-error').text('Bạn chưa chọn "Quận / Huyện"!');
              error_cofig_bran = true; 
          }

          if (address_kho_shop == '') 
          {
              $('.shop_rule_warehouse input[name="address_kho_shop"]').next('.js-msg-error').text('Bạn chưa nhập địa chỉ kho hàng!');
              error_cofig_bran = true; 
          } 
          else if (address_kho_shop.length > 255)
          {
              $('.shop_rule_warehouse input[name="address_kho_shop"]').next('.js-msg-error').text('Địa chỉ kho hàng không được quá 255 ký tự!');
              error_cofig_bran = true;  
          }
      }
      console.log(error_cofig_bran);
      console.log(id_branch);
      if (!error_cofig_bran && id_branch > 0) 
      {
        $('.load-wrapp').show();
        $.ajax({
            type: 'POST',
            url: '/page-business/config-branch/' + id_branch,
            data: $('#js-form-config-bran').serialize(),
            dataType: 'json',
            success: function (data) {
                if (data.error_system) 
                {
                  $('#js-form-config-bran .js-msg-error-sytem').text('Cấu hình chi nhánh thất bại!');
                } 
                else
                {
                  alert('Cấu hình chi nhánh thành công');
                  location.reload();
                }
            },
            error: function (data) {
                alert('Error');
            }
        }).always(function() {
            $('.load-wrapp').hide();
        });
      }
      return false;
  });
</script>

<!-- End The Modal -->


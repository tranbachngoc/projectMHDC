<?php $this->load->view('home/common/header_new'); ?>
<script src="<?php echo base_url(); ?>templates/home/js/general_registry.js"></script>
<script src="<?php echo base_url(); ?>templates/home/styles/js/common.js"></script>

<main>      
      <section class="main-content">
        <div class="container">
          <div class="signin">
            <div class="signin-info">
              <h2 class="wellcome">Chào mừng đến với <strong>azibai</strong></h2>
              <ul class="list-info">
                <li>
                  <div class="icon"><img src="/templates/home/images/svg/icon_a.svg" alt=""></div>
                  <div class="text">Mạng xã hội kinh doanh<br>Khởi tạo blog cá nhân và trang web tiếp thị bán hàng miễn phí </div>
                </li>
                <li>
                  <div class="icon"><img src="/templates/home/images/svg/icon_dola.svg" alt=""></div>
                  <div class="text">Tiếp thị liên kết - kiểm thêm thu nhập bằng việc chia sẻ thông tin " sản phẩm - dịch vụ "</div>
                </li>
                <li>
                  <div class="icon"><img src="/templates/home/images/svg/icon_headphone.svg" alt=""></div>
                  <div class="text">Nhắn tin - goi điện thoại trực tuyến </div>
                </li>
              </ul>
            </div>
            <div class="signin-form">
              <ul class="tabs-list">
                <li class="">
                  <div class="icon"><span><a href="<?php echo base_url(); ?>login"><img src="/templates/home/images/svg/user_signin.svg" alt=""></a></span></div>
                  <p>Đăng nhập</p>
                </li>
                <li class="is-active">
                  <div class="icon"><span><img src="/templates/home/images/svg/user_signin.svg" alt=""></span></div>
                  <p>Đăng ký</p>
                </li>
              </ul>
			
              <div class="form-login">
                <div class="show-form show-form-signup" style="display: block;">

				          <form method="post">
                    <p class="mb40">Nhập mã xác thực vừa được gởi đến số điện thoại <strong><?php echo $_REQUEST['mb']?$_REQUEST['mb']:''; ?></strong>
                      <span class="error-mess" style="display: block; color: red"><?php echo $this->session->flashdata('_sessionErrorLogin'); ?></span>
                    </p>

                    <div class="form-group">
                      <input type="text" placeholder="Nhập mã xác thực" name="sms_code" required class="input-form">
                     </div>
                    <div class="form-group">
                      <input type="password" class="input-form" name="password_regis" id="password_regis" autocomplete="off" placeholder="Mật khẩu" required>
                    </div>
                    <div class="form-group">
                      <input type="password" class="input-form" name="repassword_regis" id="repassword_regis" autocomplete="off" placeholder="Nhập lại mật khẩu" required onblur="comparePass('password_regis', 'repassword_regis');">
                    </div>
                     <div class="form-button">
                        <button type="submit" class="button button-white">Xác nhận</button>
                     </div>
                     <!-- <p>Không nhận được mã? (33)</p> -->
                  </form>

                </div>
              </div> 
			      
            </div>
          </div>
        </div>
      </section>
    </main>
<?php $this->load->view('home/common/footer_new'); ?>
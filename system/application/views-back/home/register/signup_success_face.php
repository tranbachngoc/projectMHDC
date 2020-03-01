<?php $this->load->view('home/common/header_new'); ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/general_registry.js"></script>
<script src="/templates/home/styles/js/common.js"></script>

<main>      
      <section class="main-content">
        <div class="container">
          <div class="signin">
            <div class="signin-info">
              <h2 class="wellcome">Chào mừng đến với <strong>azibai</strong></h2>
              <ul class="list-info">
                <li>
                  <div class="icon"><img src="/templates/home/images/svg/icon_a.svg" alt=""></div>
                  <div class="text">Mạng xã hội kinh doanh<br>Khởi tạo blog cá nhân và trang web tiếp thị bán hàng miễn phí</div>
                </li>
                <li>
                  <div class="icon"><img src="/templates/home/images/svg/icon_dola.svg" alt=""></div>
                  <div class="text">Tiếp thị liên kết - kiểm thêm thu nhập bằng việc chia sẻ thông tin "sản phẩm - dịch vụ"</div>
                </li>
                <li>
                  <div class="icon"><img src="/templates/home/images/svg/icon_headphone.svg" alt=""></div>
                  <div class="text">Nhắn tin - goi điện thoại trực tuyến</div>
                </li>
              </ul>
            </div>
          <?php if (!$auth_success) { ?>
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
                
                  <form action="<?php echo base_url().'home/register/getCodeAuthenFace'; ?>" class="" method="post">                    
                    <div class="form-group">
                        <p>Mã xác thực đã được gửi tới số điện thoại <?php echo $mobile; ?></p>
                        <label for=""></label>
                        <input type="text" name="verify_regis" class="input-form input-tel" placeholder="Nhập mã xác thực..." required> 
                        <span class="error-mess"><?php echo $this->session->flashdata('_sessionErrorLogin')?$this->session->flashdata('_sessionErrorLogin'):''; ?></span>
                        <input type="hidden" name="userId" value="<?php echo $userId; ?>">
                     </div>
                     <div class="form-button">
                      <button type="submit" class="button button-white">Xác nhận mã</button>
                     </div>                     
                  </form>

                </div>
              </div> 			        
            </div>
          <?php } else { ?>
            <div class="signin-form">
              <div class="form-login">
                <div class="show-form show-form-signup" style="display: block;">
                  <p>Chúc mừng bạn đã đăng ký thành viên thành công! Mật khẩu được tạo ra cho bạn mặc định là: <span style="color:red">azibai</span>. Vui lòng <a href="/account/changepassword">vào đây</a> để đổi mật khẩu khác để bảo mật hơn.</p>
                  <div class="form-group">
                  </div>
                  <div class="form-button">
                    <a href="/account" class="button button-white">Vào quản trị</a>
                  </div>
                </div>
              </div>
            </div>
          <?php } ?>
          </div>
        </div>
      </section>
    </main>
</div>
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
                    <div class="form-group">
                      <div class="avata-signing">
                        <div class="img">
                          <img src="<?php echo ($_REQUEST['avatar'] ? $_REQUEST['avatar']: base_url().'templates/home/images/ava_default.jpg'); ?>" alt="avatar">
                        </div>
                        <p class="name"><?php echo ($_REQUEST['name'] ? $_REQUEST['name'] : ''); ?></p>
                      </div>
                    </div>
                    <span class="error-mess" style="display: block; color: red"><?php echo $this->session->flashdata('_sessionErrorLogin'); ?></span>
                    <div class="form-group">
                        <span class="header-tel">+84</span>
                        <input type="text" name="phone_num" class="input-form input-tel" placeholder="Số điện thoại..." onblur="checkMobile(this.value, '<?php echo base_url().'regiter/inputmobile'; ?>', 'phone_num')" autocomplete="off" required>
                        <?php if ($this->session->flashdata('sessionErrorInput')) { ?>
                            <span class="error-mess"> <?= $this->session->flashdata('sessionErrorInput') ?> </span>
                        <?php } ?>
                        <!-- <span class="error-mess">* Số điện thoại này đã sử dụng</span> -->
                        
                     </div>
                     <div class="form-button">
                      <button type="submit" class="button button-white">Nhận mã kích hoạt</button>
                     </div>
                     <p>Bằng việc nhận mã kích hoạt, bạn đã đồng ý với các <span class="bold">điều khoản và điều kiện, chính sách, quyền riêng tư của azibai</span></p>
                  </form>

                </div>
              </div>              
            </div>
          </div>
        </div>
      </section>
    </main>
<?php $this->load->view('home/common/footer_new'); ?>
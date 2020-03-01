<?php $this->load->view('home/common/header_new'); ?>
<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">
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
			<?php if ($successRegister == false) { ?>
              <div class="form-login">
                <div class="show-form show-form-signup" style="display: block;">
          				<?php $post_old = $this->session->flashdata('_sessionPostOld'); ?>
                  <form name="frmRegister" id="frmRegister" method="post">
          					<p class="mb40">Một mã kích hoạt đã được gửi đến số điện thoại của bạn <span><strong><?php echo $this->session->userdata('phone_num'); ?></strong></span></p>
          					<div class="form-group">
          						<input type="text" class="input-form" name="verify_regis" id="verify_regis" autocomplete="off" placeholder="Mã kích hoạt" required value="<?php echo !empty($post_old['verify_regis']) ? $post_old['verify_regis']: ''  ?>">
                      <span class="error-mess"><?php echo $this->session->flashdata('_sessionErrorCode'); ?></span>
          					</div>
                    <!-- <div class="form-group">
                      <input type="email" maxlength="50" class="input-form" name="email" id="use_email" autocomplete="off" placeholder="Email" required value="">
                      <span class="error-mess">
                        <?php echo $this->session->flashdata('_sessionErrorEmail'); ?>
                      </span>
                    </div> -->
                    <div class="form-group">
                      <input type="text" maxlength="150" class="input-form" name="full_name" id="full_name" autocomplete="off" placeholder="Họ tên" required value="<?php echo !empty($post_old['full_name']) ? $post_old['full_name']: ''  ?>">
                    </div>
          					<div class="form-group">
          						<input type="password" class="input-form" name="password_regis" id="password_regis" autocomplete="off" placeholder="Mật khẩu" required>
          					</div>
          					<div class="form-group">
          						<input type="password" class="input-form" name="repassword_regis" id="repassword_regis" autocomplete="off" placeholder="Nhập lại mật khẩu" required onblur="comparePass('password_regis', 'repassword_regis');">
          					</div>
          					<div class="form-button">
          						<input type="submit" class="button button-white" value="Xác nhận">
          					</div>
          				</form>

                </div>
              </div> 
			  <?php } else { ?> 
				<div class="row wrap_regis">
					<p>Chúc mừng bạn đã đăng ký thành công</p>
				</div>
	    	<?php } ?>         
            </div>
          </div>
        </div>
      </section>
    </main>

<?php $this->load->view('home/common/footer_new'); ?>
<?php $this->load->view('home/common/overlay_waiting')?>

<div class="modal" id="pop-forgot-email">
  <div class="modal-dialog modal-dialog-centered modal-mess ">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Thông báo !!</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>          
      <!-- Modal body -->
      <div class="modal-body">
        <p>Yêu cầu khôi phục tài khoản thành công. Vui lòng kiểm tra mail của bạn.</p>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $('.js-forgot-pass').click(function(){
      var data_email = $(this).attr('data-email');
      $('.load-wrapp').show();
      $.ajax({
          type:'POST',
          url:'<?php echo base_url()?>home/forgot/forgotByEmail',
          data:{email_forgot: data_email},
          success:function(result){
              if (result.error != true) {
                  $('#pop-forgot-email').modal('show');
              }
          }
      }).always(function() {
        $('.load-wrapp').hide();
      });

  });
</script>
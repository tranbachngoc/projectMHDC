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
			<?php if ($sessionSuccessLogin == true) { ?>
              <div class="form-login">
                <div class="show-form show-form-signup" style="display: block;">
				<form name="frmContinue" id="frmContinue" method="post" enctype="multipart/form-data" style="margin-bottom:0" action="<?php echo base_url().'register/signupcontinue'; ?>">
					<div class="form-group">
		    			    <input type="text" class="input-form" name="fullname_res" id="fullname_res" placeholder="Họ và tên (*)" required>
		    		</div>
					<?php if(isset($user) && $user->use_mobile != '') { ?>
							<div class="form-group">
				    			<input type="text" class="input-form" name="email_res" id="email_res" placeholder="Địa chỉ email" >
				    		</div>
			    		<?php } else { ?>
			    			<div class="form-group">
				    			<input type="text" class="input-form" name="mobile_res" id="mobile_res" placeholder="Số điện thoại" >
				    		</div>			    			
			    		<?php } ?>
					
						<div class="row text-center">
						    <div class="col-xs-6 col-sm-6">
								<div class="form-group">								    
								    <div class="btn-uploadfile">
									<br>
									<i class="fa fa-camera fa-4x"></i>
									<br>
									<span>Ảnh đại diện</span>
									<span class="add">+</span>
								    </div>
								    <input type="file" accept="image" name="avatar_res" id="avatar_res" style="display: none" onchange="PreviewImgAvatar(event);">
								    <div class="img-uploadfile hidden" id="img_avatar">
									<div style="display: table-cell;vertical-align: middle;height: 130px; width: 130px;">
									    <img class="preview_avatar" id="preview_avatar" src=""/>	
									    <span class="delete_avatar" id="delete_avatar" style="cursor: pointer;">X</span>
									</div>								    
								    </div>								    
								</div>
						    </div>

						    <div class="col-xs-6 col-sm-6">
								<div class="form-group">
								    
								<div class="btn-uploadfile">
									<br>
									<i class="fa fa-camera fa-4x"></i>
									<br>
									<span>Ảnh bìa</span>
									<span class="add">+</span>
								    </div>
								    <input type="file" accept="image" name="cover_res" id="cover_res"  style="display: none" onchange="PreviewImgCover(event);">
								    <div class="img-uploadfile hidden" id="img_cover">
									<div style="display: table-cell;vertical-align: middle;height: 130px; width: 130px;">
									    <img class="preview_cover" id="preview_cover" src=""/>	
									    <span class="delete_cover" id="delete_cover" style="cursor: pointer;">X</span>
									</div>
								    </div>
								</div>
						    </div>							    							    
			    		</div>

					<div class="form-button">
						<button type="submit" class="button button-white" autofocus>Xác nhận</button>
					</div>
				</form>
                </div>
              </div> 
			  <?php } ?>       
            </div>
          </div>
        </div>
      </section>
    </main>

<script>
	jQuery(function($){
		$('.btn-uploadfile').click(function(){
			$(this).next().trigger('click');			
		});
	});

	var PreviewImgAvatar = function(event1) {
	    var output1 = document.getElementById('preview_avatar');
	    output1.src = URL.createObjectURL(event1.target.files[0]);
	    $(output1).parent().parent().removeClass( "hidden" );
	};

	var PreviewImgCover = function(event2) {
	    var output2 = document.getElementById('preview_cover');
	    output2.src = URL.createObjectURL(event2.target.files[0]);
	    $(output2).parent().parent().removeClass( "hidden" );
	};
	
	$(document).ready(function(){
	    $("#delete_avatar").click(function(){	       
	        $('#preview_avatar').parent().parent().addClass('hidden');
	    });

	    $("#delete_cover").click(function(){
	        $('#preview_cover').parent().parent().addClass('hidden');
	    });
	});	

</script>
<?php $this->load->view('home/common/footer_new'); ?>
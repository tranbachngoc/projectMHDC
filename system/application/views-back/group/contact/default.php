<?php $this->load->view('group/product/common/header'); ?>
<div id="main" class="container">
    <ol class="breadcrumb">
        <li><a href="/grtnews">Trang chủ</a></li>            
        <li><a href="/grtshop">Cửa hàng</a></li>
        <li class="active">Liên hệ</li>
    </ol>
    <div class="row">
        <div class="col-xs-12">
            <div class="group-products">
                <br/>                
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6">  
                        <h4><span>Liên hệ</span></h4>
                        <?php $this->load->view('group/product/common/block-about'); ?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6">
                        <h4><span>Gửi email</span></h4>	
						<?php if($successContact == true) {?> 
							<div class="alert alert-success" role="alert">Bạn đã gửi liên hệ thành công.</div>
						<?php }?>
                        <form name="grtcontact" method="post">
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon"><i class="fa fa-user fa-fw"></i></span>
                                        <input type="text" class="form-control" id="name" name="name_contact" placeholder="Họ và tên" value="<?php echo $name_contact ?>">
                                    </div>                                  
									<?php echo form_error('name_contact'); ?>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon"><i class="fa fa-envelope fa-fw"></i></span>
                                        <input type="email" class="form-control" id="email" name="email_contact" placeholder="youremail@domain.com" value="<?php echo $email_contact ?>">
                                    </div>
									<?php echo form_error('email_contact'); ?>
                                </div>
                                 <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon"><i class="fa fa-phone fa-fw"></i></span>
                                        <input type="text" class="form-control" id="phone" name="phone_contact" placeholder="0987 654 321" value="<?php echo $phone_contact ?>">
                                    </div>
									<?php echo form_error('phone_contact'); ?>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon" id="basic-addon"><i class="fa fa-info-circle fa-fw"></i></span>
                                        <input type="text" class="form-control" id="subject" name="subject_contact" placeholder="Tiêu đề" value="<?php echo $subject_contact ?>">
                                    </div>                                  
									<?php echo form_error('subject_contact'); ?>
                                </div>
                                <div class="form-group">                                  
                                  <textarea class="form-control" id="message" name="message_contact" placeholder="Nhập nội dung tin nhắn"><?php echo $message_contact ?></textarea>
                                  <?php echo form_error('message_contact'); ?>
                                </div>
                                <div class="form-group">
                                    <div class="row">                                        
                                        <div class="col-xs-12 col-sm-7">
                                            <div class="input-group">
                                                <span class="input-group-addon" id="basic-addon"><i class="fa fa-shield fa-fw"></i></span>
                                                <input onkeypress="return submitenter(this, event)" type="text" name="captcha_contact" id="captcha_groupContact" value="<?php echo $captcha_contact ?>" maxlength="6" class="form-control" placeholder="Mã bảo vệ">                                   
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-5">                                            
                                            <img src="<?php echo $imageCaptchaContact ?>" height="34"/>
                                        </div>
                                    </div>
									<?php echo $error_captcha_contact; ?>
                                </div>
                                <div class="form-group">                                    
                                    <button name ="submit_contact" type="submit" class="btn btn-primary">Liên hệ</button>                                   
                                    <button name ="reset_contact" type="reset" class="btn btn-default">Hủy bỏ</button>
                                </div>
                            </form>  
                    </div>
                </div>
               
                <h4><span>Xem bản đồ</span></h4>                
                <div class="row">
                    <div class="col-xs-12">
                        <?php echo $headerjs; ?>
                        <?php echo $headermap; ?>
                        <?php echo $onload; ?>
                        <?php echo $map; ?>
                        <?php //echo $sidebar; ?>
                    </div>
                </div>
                <br/>
            </div>
        </div>   
    </div>
</div>

<?php $this->load->view('group/common/footer-group'); ?>
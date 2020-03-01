<?php $this->load->view('home/common/login/header'); ?>
<!--BEGIN: LEFT-->
<div class="container-fluid">
    <?php if ($successForgot == false && empty($this->session->userdata('forgot'))) { ?>
        <div class="row">    
    	<div class="col-sm-4 col-sm-offset-4">
	    <br>
    	    <div class="panel panel-default">
    		<div class="panel-body">
		    <br>
		    <div class="tile_Register">
			<h4>
			    <span>
			    <?php echo $this->lang->line('title_defaults'); ?>
			    </span>
			</h4>
		    </div>
    		    
    		    <form action="<?=base_url()?>forgot" name="_frmForgotPassword" id="_frmForgotPassword" method="post" class="form" novalidate>
    			<fieldset>
					<div class="form-group">
					<?php if($this->session->flashdata('_sessionErrorForgot')) {?>
						<span class="alert alert-danger"><?php echo $this->session->flashdata('_sessionErrorForgot');?></span>
					<?php }?>
					<?php if($this->session->flashdata('_sessionSuccessForgot')) {?>
						<span class="alert alert-success"><?php echo $this->session->flashdata('_sessionSuccessForgot');?></span>
					<?php }?>						
					</div>
					<div class="form-group">
						<input type="radio" name="option" value="0" checked onclick="showOption(0)"> Email<br>
						<input type="radio" name="option" value="1" onclick="showOption(1)"> Số Điện Thoại<br>
					</div>

					<div class="form-group" id="option0">
					<input type="text" name="email_forgot" id="email_forgot" 
					maxlength="50" class="form-control input_form_custom" 
					onkeyup="BlockChar(this, 'SpecialChar')" 
					onblur="_forgot_pass(this.value, '<?php echo base_url(); ?>', 0)"
					placeholder="Nhập email"
					required/>
    			    </div>

					<div class="form-group" id="option1" style="display:none">
					<input type="tel" name="phone_num" id="phone_num"
					placeholder="Số điện thoại" 
					class="input_form_custom form-control" 
					onblur="_forgot_pass(this.value, '<?php echo base_url(); ?>', 1 ,'phone_num')" 
					autocomplete="off" 
					required/>
    			    </div>
			    <?php if (isset($imageCaptchaForgot)) { ?>
				<div class="form-group">
				    <div class="row">
					<div class="col-xs-6">
					    <input type="text" name="captcha_forgot" placeholder="<?php echo $this->lang->line('captcha_main'); ?>" id="captcha_forgot" value="" maxlength="6" class="form-control input_form_custom" />
					</div>
					<div class="col-xs-6">
					    <img src="<?php echo $imageCaptchaForgot; ?>"  width="100%" height="34" />
					</div>
				    </div>
				    <input id="captcha" name="captcha" type="hidden" value="<?php echo($captcha); ?>"  />
				    <input type="hidden" id="isPostValidCaptcha" name="isPostValidCaptcha" value=""/>
				    <?php echo form_error('captcha_forgot'); ?>
				</div>
			    <?php } ?>
    			    
    				<div class="form-group">
				    <input name="submit_forgot" class="btn btn-primary btn-block" value="Xác nhận" type="submit" style="background-color:#008C8C">
				</div>
				
    			    

    			</fieldset>
    		    </form>
				<script>
					function showOption(val) {
						if(val === 1){
							$("#option1").show();
							$("#option0").hide();
						}else{
							$("#option1").hide();
							$("#option0").show();
						}
					}
				</script>

    		</div>

    	    </div> 
    	</div>
        </div>
    <?php } else { ?>
        <div  class="container">
		<?php if(empty($this->session->userdata('forgot'))){?>
    	<div class="row">
    	    <div class="col-sm-5">
    		<div class="panel panel-default">
    		    <div class="panel-heading"><h4 class="text-center">THÀNH CÔNG</h4></div>
    		    <div class="panel-body">
    			<p class="text-center"> <?php echo $this->lang->line('success_defaults'); ?><br/>
    			    <b><a class="text-primary" href="<?php echo base_url(); ?>">Click vào đây để tiếp tục</a></b>
    			</p>
    		    </div>
    		</div>
    	    </div>
    	    <div class="col-sm-6">
		    <?php
		    echo $this->load->view('home/common/info');
		    ?>
    	    </div>
    	</div>
		<?php } else {?>
			<form name="frmForgot" id="frmForgot" method="post" style="margin-bottom:0">
			<div id="box_regis_1" style="padding:20px;">
				<div class="form-group">
					<p style="text-align:center">
						<small>Một mã kích hoạt đã được gửi đến số điện thoại của bạn</small>
						<span><?php echo $this->session->userdata('phone_num'); ?></span>
					</p>
				</div>
				<div class="form-group">
					<input type="text" class="input_form_custom form-control" name="verify_regis" id="verify_regis"  placeholder="Mã kích hoạt" required>
				</div>
				
				<div class="form-group">		    
					<input type="password" name="password_regis" id="password_regis" class="input_form_custom form-control"  placeholder="Mật khẩu" required>
				</div>
				<div class="form-group">
					<input type="password" name="repassword_regis" id="repassword_regis" class="input_form_custom form-control"  placeholder="Nhập lại mật khẩu" required onblur="comparePass('password_regis', 'repassword_regis');">
				</div>  
				<br>
				<div class="form-group">							
					<input type="button" value="Đăng ký" class="btn btn-azibai btn-block" style="background-color:#008C8C" onclick="check_Input_frmForgot();" autofocus>
				</div>
				<div class="form-group">
					<a href="<?php echo base_url() . 'forgot/1';?>"><button type="button" class="btn btn-azibai btn-block" style="background-color:gray">Lấy mật khẩu bằng Email</button></a>
				</div>
			</div>
			</form>
		<?php } ?>
        </div>
    <?php } ?>
</div>
<?php $this->load->view('home/common/footer'); ?>
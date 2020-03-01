<?php $this->load->view('home/common/header'); ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<div id="main" class="container-fluid">
    <div class="row rowmain">
	<div class="col-lg-2 hidden-md hidden-sm hidden-xs">
	    <?php $this->load->view('home/common/left_tintuc'); ?>
	</div>
	<div class="col-lg-8 col-xs-12">
	    <ol id="breadcrumb" class="breadcrumb" style="white-space: nowrap; overflow: auto;">
		<li><a href="<?php echo base_url(); ?>">Trang chủ</a></li>
		<li><span>Liên hệ</span></li>
	    </ol>
	    <h2 class="text-center">CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI</h2>
	    <div class="row">                    
		<?php if ($successContact == false) { ?>
    		<div class="col-sm-12 col-xs-12">
    		    <h3>Thông tin liên hệ</h3>
    		    <table class="table">
    			<tr>
    			    <th>Công ty</th>
    			    <td>CÔNG TY TNHH DỊCH VỤ MỌI NGƯỜI CÙNG VUI
    			</tr>
    			<tr>
    			    <th>Địa chỉ</th>
    			    <td><?php echo settingAddress_1 ?></td>
    			</tr>
    			<tr>
    			    <th>Điện thoại</th>
    			    <td><?php echo settingPhone ?></td>
    			</tr>
<!--    			<tr>
    			    <th>Mobile</th>
    			    <td><?php echo settingMobile ?></td>
    			</tr>-->
    			<tr>
    			    <th>Email</th>
    			    <td><?php echo settingEmail_1 ?></td>
    			</tr>
    			<tr>
    			    <th>Website</th>
    			    <td><a href="<?php echo settingWebsite ?>"><?php echo settingWebsite ?></a></td>
    			</tr>
    		    </table>
    		    <h3>Xem bản đồ</h3>
    		    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3919.322384009375!2d106.6855093154804!3d10.786601992314637!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31752f2d81374683%3A0x8da8bb8f098d160f!2sAzibai!5e0!3m2!1sen!2s!4v1505190032542" width="100%" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
    		</div>
    		<div class="col-sm-12 col-xs-12">
    		    <h3>Gửi email cho azibai</h3>
    		    <form name="frmContact" method="post" class="">
    			<div class="form-group">
    			    (<font color="#FF0000"><b>*</b></font>)&nbsp;&nbsp;<?php echo $this->lang->line('must_input_help'); ?>
			</div>
			<div class="row">
			    <div class="col-sm-6 col-xs-12">
				<div class="form-group">			    
    				    <label class="control-label"><font
    					    color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('fullname_defaults'); ?>
    				    </label>
    				    <input type="text" name="name_contact" id="name_contact"
    					   value="<?php
					       if (isset($name_contact)) {
						   echo $name_contact;
					       }
					       ?>" maxlength="80" class="input_form form-control"
    					   onkeyup="BlockChar(this, 'SpecialChar'); CapitalizeNames('frmContact', 'name_contact');"
    					   onfocus="ChangeStyle('name_contact', 1)"
    					   onblur="ChangeStyle('name_contact', 2)"/>
					       <?php echo form_error('name_contact'); ?>			    
    				</div>
			    </div>
			    <div class="col-sm-6 col-xs-12">
				<div class="form-group">
    				    <label class="control-label"><font
    					    color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_defaults'); ?>
    				    </label>

    				    <input type="text" name="email_contact" id="email_contact"
    					   value="<?php
					       if (isset($email_contact)) {
						   echo $email_contact;
					       }
					       ?>" maxlength="50" class="input_form form-control"
    					   onkeyup="BlockChar(this, 'SpecialChar')"
    					   onfocus="ChangeStyle('email_contact', 1)"
    					   onblur="ChangeStyle('email_contact', 2)"/>
					       <?php echo form_error('email_contact'); ?>

    				</div>
			    </div>
			</div>
			<div class="row">
    			    <div class="col-sm-6 col-xs-12">    			
    				<div class="form-group">
    				    <label class="control-label"><font
    					    color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_defaults'); ?>
    				    </label>
    				    <input type="text" name="address_contact" id="address_contact"
    					   value="<?php
					       if (isset($address_contact)) {
						   echo $address_contact;
					       }
					       ?>" maxlength="80" class="input_form form-control"
    					   onkeyup="BlockChar(this, 'SpecialChar'); CapitalizeNames('frmContact', 'address_contact');"
    					   onfocus="ChangeStyle('address_contact', 1)"
    					   onblur="ChangeStyle('address_contact', 2)"/>
					       <?php echo form_error('address_contact'); ?>

    				</div>
    			    </div>
    			    <div class="col-sm-6 col-xs-12">			   
    				<div class="form-group">
    				    <label class="control-label"><font
    					    color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_defaults'); ?>
    				    </label>

    				    <input type="text" name="phone_contact" id="phone_contact"
    					   value="<?php
					       if (isset($phone_contact)) {
						   echo $phone_contact;
					       }
					       ?>" maxlength="50" class="input_form form-control"
    					   onkeyup="BlockChar(this, 'SpecialChar')"
    					   onfocus="ChangeStyle('phone_contact', 1)"
    					   onblur="ChangeStyle('phone_contact', 2)"/>
					       <?php echo form_error('phone_contact'); ?>

    				</div>
    			    </div>
    			</div>
			<div class="form-group">
    			    <label class="control-label"><font
    				    color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('title_contact_defaults'); ?>
    			    </label>

    			    <input type="text" name="title_contact" id="title_contact"
    				   value="<?php
				       if (isset($title_contact)) {
					   echo $title_contact;
				       }
				       ?>" maxlength="80" class="input_form form-control"
    				   onkeyup="BlockChar(this, 'SpecialChar')"
    				   onfocus="ChangeStyle('title_contact', 1);"
    				   onblur="ChangeStyle('title_contact', 2);"/>
				       <?php echo form_error('title_contact'); ?>

    			</div>
    			<div class="form-group">
    			    <label class="control-label"><font
    				    color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('position_defaults'); ?>
    			    </label>

    			    <select name="position_contact" id="position_contact"
    				    class="selectposition_contact form-control">
    				<option
    				    value="1" <?php
					if (isset($position_contact) && $position_contact == $this->lang->line('business_defaults')) {
					    echo 'selected="selected"';
					} elseif (!isset($position_contact)) {
					    echo 'selected="selected"';
					}
					?>><?php echo $this->lang->line('business_defaults'); ?></option>
    				<option
    				    value="2" <?php
					if (isset($position_contact) && $position_contact == $this->lang->line('tech_defaults')) {
					    echo 'selected="selected"';
					}
					?>><?php echo $this->lang->line('tech_defaults'); ?></option>
    			    </select>

    			</div>
    			<div class="form-group">
    			    <label class="control-label"><font
    				    color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('content_defaults'); ?>
    			    </label>

    			    <textarea name="content_contact" id="content_contact" cols="47" rows="8"
    				      class="textarea_form form-control"
    				      onfocus="ChangeStyle('content_contact', 1);"
    				      onblur="ChangeStyle('content_contact', 2);"><?php
					      if (isset($content_contact)) {
						  echo $content_contact;
					      }
					      ?></textarea>
				<?php echo form_error('content_contact'); ?>

    			</div>
			    <?php if (isset($imageCaptchaContact)) { ?>
				<div class="form-group">
				    <label class="control-label"><font
					    color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>
				    </label>

				    <div class="row">
					<div class="col-sm-4">
					    <img src="<?php echo $imageCaptchaContact; ?>"
						 width="151" height="34"/>
					</div>
					<div class="col-sm-8">
					    <input type="text" name="captcha_contact" id="captcha_contact"
						   value="" class="inputcaptcha_form form-control"
						   onfocus="ChangeStyle('captcha_contact', 1);"
						   onblur="ChangeStyle('captcha_contact', 2);"/>
					</div>
				    </div>
				    <input type="hidden" id="captcha" name="captcha"
					   value="<?php echo $captcha; ?>"/>
				    <input type="hidden" id="isPostProduct" name="isPostProduct" value=""/>
				    <?php echo form_error('captcha_contact'); ?>


				</div>

			    <?php } ?>

    			<div class="form-group">
    			    <label class="control-label"></label>
    			    <div class="text-center">
    				<input type="button" onclick="CheckInput_Contact();" name="submit_contact"
    				       value="Gửi đi"
    				       class="button_form btn btn-azibai"/>
    				<input type="reset" name="reset_contact"
    				       value="Nhập lại"
    				       class="button_form btn btn-default"/>
    			    </div>
    			</div>
    		    </form>
    		</div>
		<?php } else { ?>
    		<div class="success_post">
    		    <div class="alert alert-warning alert-dismissible" role="alert">
    			<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
    				aria-hidden="true">&times;</span></button>
    			<strong>Cảm ơn!</strong> Bạn đã liên hệ với <a href="www.azibai.com"><b>azibai.com</b></a>, Chúng tôi sẽ kiểm tra email và phản hồi cho bạn trong thời gian sớm nhất!
    			<a href="<?php echo base_url(); ?>contact"><b>Click vào đây để tiếp tục</b></a>
    		    </div>
    		</div>
		<?php } ?>
	    </div>
	</div>

	<div class="col-lg-2 hidden-md hidden-sm hidden-xs">
	    <?php $this->load->view('home/common/ads_right'); ?>
	</div>
    </div>
</div>
<script>
jQuery(function($){
    $('.fixtoscroll').scrollToFixed( { 
        marginTop: function() { 
                var marginTop = $(window).height() - $(this).outerHeight(true) - 20; 
                if (marginTop >= 0) return 75; 
                return marginTop; 
        },
        limit: function() {
                var limit = 0;
                limit = $('#footer').offset().top - $(this).outerHeight(true) - 20;
                return limit;
        }            
    });	
});
</script>
<?php $this->load->view('home/common/footer'); ?>
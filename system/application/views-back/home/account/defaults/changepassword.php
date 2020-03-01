<?php $this->load->view('home/common/account/header'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <SCRIPT TYPE="text/javascript">
            <!--
            function submitenter(myfield, e)
            {
                var keycode;
                if (window.event)
                    keycode = window.event.keyCode;
                else if (e)
                    keycode = e.which;
                else
                    return true;

                if (keycode == 13)
                {
                    CheckInput_ChangePassword();
                    return false;
                } else
                    return true;
            }
            //-->
        </SCRIPT>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12 account_edit">
            <h4 class="page-header" style="margin-top:10px">
                <?php echo $this->lang->line('title_change_password'); ?>
            </h4>
		
            <form name="frmChangePassword" id="frmChangePassword" method="post" class="form-horizontal">
                <?php if ($successChangePasswordAccount == false) { ?>
                    <div class="form-group">
                        <div class="control-label col-md-3 col-sm-4 col-xs-12"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('old_password_change_password'); ?>:</div>
                        <div class="col-md-6 col-sm-8 col-xs-12">
			    <?php echo form_error('oldpassword_changepass'); ?>
                            <input type="password" value="" name="oldpassword_changepass" id="oldpassword_changepass" maxlength="35" class="input_formpost form-control" onkeyup="BlockChar(this, 'AllSpecialChar')" onfocus="ChangeStyle('oldpassword_changepass', 1)" onblur="ChangeStyle('oldpassword_changepass', 2)" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="control-label col-md-3 col-sm-4 col-xs-12"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('new_password_change_password'); ?>:</div>
                        <div class="col-md-6 col-sm-8 col-xs-12">
			    <?php echo form_error('password_changepass'); ?>
                            <input type="password" value="" name="password_changepass" id="password_changepass" maxlength="35" class="input_formpost form-control" onkeyup="BlockChar(this, 'AllSpecialChar')" onfocus="ChangeStyle('password_changepass', 1)" onblur="ChangeStyle('password_changepass', 2)" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="control-label col-md-3 col-sm-4 col-xs-12"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('renew_password_change_password'); ?>:</div>
                        <div class="col-md-6 col-sm-8 col-xs-12">
			    <?php echo form_error('repassword_changepass'); ?>
                            <input type="password" value="" name="repassword_changepass" id="repassword_changepass" maxlength="35" class="input_formpost form-control" onkeyup="BlockChar(this, 'AllSpecialChar')" onfocus="ChangeStyle('repassword_changepass', 1)" onblur="ChangeStyle('repassword_changepass', 2)" />
                        </div>
                    </div>

                    <?php if (isset($imageCaptchaChangePasswordAccount)) { ?>
                        <div class="form-group">
                            <div class="control-label col-md-3 col-sm-4 col-xs-12"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</div>
			    
                            <div class="col-md-6 col-sm-8 col-xs-12">
                                <?php echo form_error('captcha_changepass'); ?>
                                <div class="input-group">
                                    <input type="text"  onkeypress="return submitenter(this, event)" name="captcha_changepass" id="captcha_changepass" value="" maxlength="10" class="inputcaptcha_form  form-control" onfocus="ChangeStyle('captcha_changepass', 1);" onblur="ChangeStyle('captcha_changepass', 2);" />
                                    <span class="input-group-addon" style="padding: 0"><img src="<?php echo $imageCaptchaChangePasswordAccount; ?>"  height="32" /></span>
                                </div>
                                <input type="hidden" name="hidden_captcha" value="<?php echo $codeCaptcha; ?>" id="hidden_captcha" />
			    </div>				    
                            
                        </div>
                    <?php } ?>
                
                    
                
                    <div class="form-group">
			<div class="control-label col-md-3 col-sm-4 col-xs-12"></div>
                        <div class="col-md-9 col-sm-8 col-xs-12">
                            <input type="button" onclick="CheckInput_ChangePassword();" name="submit_changepass" value="<?php echo $this->lang->line('button_update_change_password'); ?>" class="btn btn-azibai" />
                            <input type="button" name="reset_changepass" value="<?php echo $this->lang->line('button_cancel_change_password'); ?>" onclick="ActionLink('<?php echo base_url(); ?>account')" class="btn btn-default" />
                        </div>
                    </div>                   
            </div>
        <?php } else { ?>
            <div class="form-group">
                <div class="success_post" style="padding-top: 10px;">
                    <p class="text-center"><a href="<?php echo base_url(); ?>account">Click vào đây để tiếp tục</a></p>
                    <?php echo $this->lang->line('success_change_password'); ?>
                </div>
            </div>
        <?php } ?>

        </form>
    </div>
</div>

<?php $this->load->view('home/common/footer'); ?>
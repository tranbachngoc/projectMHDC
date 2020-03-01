<?php $this->load->view('home/common/account/header'); ?>

<div class="container-fluid">
    <div class="row">
        <?php
        $this->load->view('home/common/left');
        $group_id = (int) $this->session->userdata('sessionGroup');
        ?>
	<?php $this->load->view('home/common/tinymce'); ?>
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
                    CheckInput_EditShopIntro();
                    return false;
                } else
                    return true;
            }
            //-->
        </SCRIPT>
        <!--BEGIN: RIGHT-->
	<div class="col-md-9 col-sm-8 col-xs-12 account_edit">
               
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                <?php echo $this->lang->line('edit_shop_account_intro_menu'); ?> <?php if ($group_id == AffiliateUser) { ?>Cộng Tác Viên Online<?php } ?>
            </h4>
            <form name="frmEditShopIntro" id="frmEditShopIntro" method="post">
                <?php if ($shopid > 0) { ?>
                    <?php if ($successEditShopIntroAccount == false) { ?>
			    <p style="color: #004B7A;font-weight: bold;"><?php echo $this->lang->line('edit_shop_account_intro_menu'); ?>:</p>
			    <textarea class="editor" name="txtContent1">
				<?php echo $txtContent1; ?>
			    </textarea>
			    <br>
                        <?php if ($group_id != AffiliateUser) { ?>
                            <p style="color: #004B7A;font-weight: bold;">Hồ sơ công ty:</p>
                            <textarea class="editor" name="txtContent2">
                                <?php echo $txtContent2; ?>
                            </textarea>
			    <br>
                            <p style="color: #004B7A;font-weight: bold;">Chứng nhận công nghiệp:</p>
                            <textarea class="editor" name="txtContent3">
                                <?php echo $txtContent3; ?>
                            </textarea>
			    <br>
                            <p style="color: #004B7A;font-weight: bold;">Năng lực thương mại:</p>
                            <textarea class="editor" name="txtContent4">
                                <?php echo $txtContent4; ?>
                            </textarea>
                        <?php } ?>

                        <?php if (isset($imageCaptchaSendContactAccount)) { ?>
                            <font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:
                            <img src="<?php echo $imageCaptchaEditShopIntroAccount; ?>" width="151" height="30" /><br />
                            <input type="text" onkeypress="return submitenter(this, event)" name="captcha_shop" id="captcha_shop" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_shop', 1);" onblur="ChangeStyle('captcha_shop', 2);" />
                        <?php } ?>
                            <p class="text-center"> 
			    <input type="button" onclick="CheckInput_EditShopIntro();" name="submit_editshopintro" value="<?php echo $this->lang->line('button_update_shop_account'); ?>" class="btn btn-azibai" />
			    <input type="button" name="cancle_editshop" value="<?php echo $this->lang->line('button_cancle_shop_account'); ?>" onclick="ActionLink('<?php echo base_url(); ?>account')" class="btn btn-default" />
			    </p>
                        <input type="hidden" name="isEditShopIntro" id="isEditShopIntro" value=""/>
                        <input type="hidden" name="current_captcha" id="current_captcha" value="<?php echo $captcha; ?>"/>
                    <?php } else { ?>
                        
                                <p class="text-center"><a href="<?php echo base_url(); ?>account">Click vào đây để tiếp tục</a></p>
                                <?php echo $this->lang->line('success_edit_shop_account'); ?>
                           
                    <?php } ?>
                <?php } else { ?>
                    <div class="noshop"><?php echo $this->lang->line('noshop'); ?> <a href="<?php echo base_url(); ?>account/shop">tại đây</a></div>
                <?php } ?>
               
            </form>
        </div>
    </div>
</div>
<!--END: RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <SCRIPT TYPE="text/javascript">
                <!--
                function submitenter(myfield, e) {
                    var keycode;
                    if (window.event) keycode = window.event.keyCode;
                    else if (e) keycode = e.which;
                    else return true;

                    if (keycode == 13) {
                        CheckInput_EditShopWarranty();
                        return false;
                    }
                    else
                        return true;
                }
                //-->
            </SCRIPT>
            <!--BEGIN: RIGHT-->
            <div class="col-md-9 col-sm-8 col-xs-12">
                <h4 class="page-header text-uppercase" style="margin-top:10px">
                    <?php echo $this->lang->line('edit_shop_account_warranty_menu'); ?>
                </h4>
                
                <form name="frmEditShopWarranty" id="frmEditShopWarranty" method="post">
                 
                    <?php if ($shopid > 0){ ?>                                
                            
                        <?php if ($successEditShopWarrantyAccount == false) { ?>                            
                            <div class="form-group">
                               
                                <?php $this->load->view('home/common/tinymce'); ?>
                                <textarea class="editor form-control" name="txtContent"><?php echo $txtContent; ?></textarea>
                            </div>
                                <?php if (isset($imageCaptchaSendContactAccount)) { ?>
                            <div class="form-group">    
                                <label for="captcha_main"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</label>
                                     
                                <img src="<?php echo $imageCaptchaEditShopWarrantyAccount; ?>"
                                     width="151" height="30"/>
                                <input type="text" onkeypress="return submitenter(this,event)" name="captcha_shop"
                                       id="captcha_shop" value="" maxlength="10" class="inputcaptcha_form"
                                       onfocus="ChangeStyle('captcha_shop',1);"
                                       onblur="ChangeStyle('captcha_shop',2);"/>

                            <?php }?>
                            
                            <input type="button" onclick="CheckInput_EditShopWarranty();"
                                   name="submit_editshopwarranty"
                                   value="<?php echo $this->lang->line('button_update_shop_account'); ?>"
                                   class="btn btn-primary"/>
                            <input type="button" name="cancle_editshop"
                                   value="<?php echo $this->lang->line('button_cancle_shop_account'); ?>"
                                   onclick="ActionLink('<?php echo base_url(); ?>account')"
                                   class="btn btn-danger"/>
                                
                            <input type="hidden" name="isEditShopWarranty" id="isEditShopWarranty" value=""/>
                            <input type="hidden" name="current_captcha" id="current_captcha"
                                   value="<?php echo $captcha; ?>"/>
                        <?php } else { ?>
                            <div class="success_post" style="padding-top: 10px;">
                                    <p> <?php echo $this->lang->line('success_edit_shop_account'); ?></p>
                                    <p class="text-center"><a href="<?php echo base_url(); ?>account">Click vào đây để tiếp tục</a></p>
                            </div>
                        <?php } ?>

                    <?php } else { ?>

                                <div class="noshop"><?php echo $this->lang->line('noshop'); ?> <a
                                        href="<?php echo base_url(); ?>account/shop">tại đây</a></div>

                    <?php } ?>
                    
                </form>
            </div>
        </div>
    </div>
    <!--END: RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
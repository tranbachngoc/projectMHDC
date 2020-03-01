<?php $this->load->view('shop/common/header'); ?>
<?php //$this->load->view('shop/common/left');            ?>
<?php if (isset($siteGlobal)) { ?>
    <script language="javascript" src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/check_email.js"></script>
    <!--BEGIN: Center-->
    <div id="main">
        <div class="container contact">
            <div class="row" style="margin-top:20px">
                <div class="col-lg-12">
                    <ol id="breadcrumb" class="breadcrumb" style="white-space: nowrap; overflow: auto;">
                        <li><a href="/"><?php echo $this->lang->line('index_page_menu_detail_global'); ?></a></li>
                        <li class="active"><?php echo $this->lang->line('title_detail_contact'); ?></li>
                    </ol>
                </div>
            </div>
            
            <div class="row" style="margin-top:20px">
                <div class="col-md-6">
                    <h3 class="contact-title">Thông tin liên hệ</h3>            
                    <p> <i class="fa fa-home fa-fw"></i> <strong><?php echo $siteGlobal->sho_name; ?></strong></p>
                    <p> <i class="fa fa-info-circle fa-fw"></i> <?php echo $siteGlobal->sho_descr; ?></p>
                    <p> <i class="fa fa-map-marker fa-fw"></i> <?php echo $siteGlobal->sho_address .', '. $siteGlobal->sho_district .', '. $siteGlobal->sho_province; ?></p>
                    <p> <i class="fa fa-phone fa-fw"></i> <?php echo $siteGlobal->sho_phone; ?></p>
                    <p> <i class="fa fa-mobile fa-fw"></i> <?php echo $siteGlobal->sho_mobile; ?></p>
                    <p> <i class="fa fa-fax fa-fw"></i> <?php echo $siteGlobal->shop_fax; ?></p>
                    <p> <i class="fa fa-envelope fa-fw"></i> <?php echo $siteGlobal->sho_email; ?></p>
                    <p> <i class="fa fa-globe fa-fw"></i> <?php echo $siteGlobal->sho_website; ?></p>
                </div>
                <div class="col-md-6">
                    <h3 class="contact-title">Vị trí cửa hàng</h3>
                    <?php echo $headerjs; ?>
                    <?php echo $headermap; ?>
                    <?php echo $onload; ?>
                    <?php echo $map; ?>
                </div>
            </div>    
<br>
            <h3 class="contact-title">Gửi email đến gian hàng</h3>
            
            <?php if ($successContactShopDetail == false) { ?>
                <form name="frmContact" method="post" class="form">
                    <div class="row">  
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-user fa-fw"></i></div>
                                    <input type="text" name="name_contact" id="name_contact" placeholder="<?php echo $this->lang->line('fullname_detail_contact'); ?>" value="<?php
                                    if (isset($name_contact)) {
                                        echo $name_contact;
                                    }
                                    ?>" maxlength="80" class="input_form form-control" onkeyup="BlockChar(this, 'SpecialChar'); CapitalizeNames('frmContact', 'name_contact');" onfocus="ChangeStyle('name_contact', 1)" onblur="ChangeStyle('name_contact', 2)" />
                                           <?php echo form_error('name_contact'); ?>
                                </div>
                            </div>
                        </div>    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                                    <input type="text" name="email_contact" id="email_contact" placeholder="<?php echo $this->lang->line('email_detail_contact'); ?>" value="<?php
                                    if (isset($email_contact)) {
                                        echo $email_contact;
                                    }
                                    ?>" maxlength="50" class="input_form form-control" onkeyup="BlockChar(this, 'SpecialChar')" onfocus="ChangeStyle('email_contact', 1)" onblur="ChangeStyle('email_contact', 2)" />
                                           <?php echo form_error('email_contact'); ?>
                                </div>
                            </div>
                        </div>      
                    </div>    
                    <div class="row">  
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-map-marker fa-fw"></i></span>
                                    <input type="text" name="address_contact" id="address_contact" placeholder="<?php echo $this->lang->line('address_detail_contact'); ?>" value="<?php
                                    if (isset($address_contact)) {
                                        echo $address_contact;
                                    }
                                    ?>" maxlength="80" class="input_form form-control" onkeyup="BlockChar(this, 'SpecialChar'); CapitalizeNames('frmContact', 'address_contact');" onfocus="ChangeStyle('address_contact', 1)" onblur="ChangeStyle('address_contact', 2)" />
                                           <?php echo form_error('address_contact'); ?>
                                </div>
                            </div>
                        </div>    
                        <div class="col-sm-6">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone fa-fw"></i></span>
                                    <input type="text" name="phone_contact" id="phone_contact" placeholder="<?php echo $this->lang->line('phone_detail_contact'); ?>" value="<?php
                                    if (isset($phone_contact)) {
                                        echo $phone_contact;
                                    }
                                    ?>" maxlength="50" class="input_form form-control" onkeyup="BlockChar(this, 'SpecialChar')" onfocus="ChangeStyle('phone_contact', 1)" onblur="ChangeStyle('phone_contact', 2)" />
                                           <?php echo form_error('phone_contact'); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-info fa-fw"></i></span>
                            <input type="text" name="title_contact" id="title_contact" placeholder="<?php echo $this->lang->line('title_contact_detail_contact'); ?>" value="<?php
                            if (isset($title_contact)) {
                                echo $title_contact;
                            }
                            ?>" maxlength="80" class="input_form form-control" onkeyup="BlockChar(this, 'SpecialChar')" onfocus="ChangeStyle('title_contact', 1);" onblur="ChangeStyle('title_contact', 2);" />
                                   <?php echo form_error('title_contact'); ?>
                        </div>
                    </div>



                    <div class="form-group">

                        <textarea name="content_contact" id="content_contact" placeholder="Nội dung" cols="47" rows="8" class="textarea_form form-control" onfocus="ChangeStyle('content_contact', 1);" onblur="ChangeStyle('content_contact', 2);"><?php
                            if (isset($content_contact)) {
                                echo $content_contact;
                            }
                            ?></textarea>
                        <?php echo form_error('content_contact'); ?>
                    </div>

                    <div class="form-inline text-center">
                        <?php if (isset($imageCaptchaContactShopDetail)) { ?>

                            <div class="form-group">
                                <label class=""><?php echo $this->lang->line('captcha_main'); ?>:</label>
                                <img src="<?php echo $imageCaptchaContactShopDetail; ?>" width="151" height="30" />
                                <input id="captcha" name="captcha" type="hidden" value="<?php echo($captcha); ?>"  />
                                <input type="text" name="captcha_contact" id="captcha_contact" value="" maxlength="10" class="inputcaptcha_form form-control" onfocus="ChangeStyle('captcha_contact', 1);" onblur="ChangeStyle('captcha_contact', 2);" />
                                <?php echo form_error('captcha_contact'); ?>
                            </div>                                
                        <?php } ?>

                        <div class="form-group">
                            <input type="button" onclick="CheckInput_Contact();" name="submit_contact" value="Gửi email" class="button_form btn btn-primary" />
                            <input type="reset" name="reset_contact" value="Nhập lại" class="button_form btn btn-danger" />

                        </div>
                    </div>

                </form>
            <?php } else { ?>
                <div class="success_post">
                    <p class="text-center"><a href="<?php echo $URLRoot; ?>shop/contact">Click vào đây để tiếp tục</a></p>
                    <?php echo $this->lang->line('success_detail_contact'); ?>
                </div>
            <?php } ?>
            <br>
        </div>

        <div style="height:30px"></div>
    </div>
    <!--END Center-->
<?php } ?>
<?php $this->load->view('shop/common/footer'); ?>
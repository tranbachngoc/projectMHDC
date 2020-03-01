<div class="container">
    <?php $style = $_REQUEST['style'];
    if ($style != '') { ?>
        <div id="open_shop">
            <a href="<?php echo $mainURL . 'register?style=' . $style; ?>" class="btn btn-warning btn-lg" target="_blank"><i class="fa fa-shopping-basket"></i> Mở shop ngay</a>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12 ">
            <div style="background: #fff;">
                <table class="table table-bordered">
                    <tbody>
                    <tr>
                        <td colspan="2">
                            <h2 class="text-center" style="margin-bottom: 10px"><?php echo $siteGlobal->sho_name ?></h2>
                        </td>
                    <tr>
                        <td align="left" width="">Mô tả ngắn</td>
                        <td><?php echo $siteGlobal->sho_descr ?></td>
                    </tr>
                    <tr>
                        <td align="left" width="" valign="center">Bình chọn</td>
                        <td><span style="color:#f90; font-size:18px"><?php
                                if(@$package == 2){
                                    echo '<img width="15%" src="' . $URLRoot . 'templates/home/images/icon_chuyennghiep.png" style="margin:0 10px 0 0"/>';
                                }
                                if ($star > 0) {
                                    echo '<img width="15%" src="' . $URLRoot . 'templates/home/images/icon_estore_verified.png" style="margin:0 10px 0 0"/>';
                                    for ($i = 1; $i <= $star; $i++) {
                                        echo '<i class="fa fa-star"></i>';
                                    }

                                } else {
                                }
                                ?></span></td>
                    </tr>
                    <tr>
                        <td align="left">Tham gia</td>
                        <td><?php echo date('d/m/Y', $siteGlobal->sho_begindate) ?></td>
                    </tr>
                    <tr>
                        <td align="left">Địa chỉ</td>
                        <td><?php echo $siteGlobal->sho_address ?></td>
                    </tr>
                    <tr>
                        <td align="left">Tỉnh/thành</td>
                        <td><?php foreach ($province as $p) {
                                if ($p->pre_id == $siteGlobal->sho_province) echo $p->pre_name;
                            } ?></td>
                    </tr>
                    <tr>
                        <td align="left">Điện thoại</td>
                        <td><?php echo $siteGlobal->sho_phone ?></td>
                    </tr>
                    <tr>
                        <td align="left">Mobile</td>
                        <td><?php echo $siteGlobal->sho_mobile ?> </td>
                    </tr>
                    <tr>
                        <td align="left">Website</td>
                        <td><?php echo $siteGlobal->sho_website ?></td>
                    </tr>
                    <tr>
                        <td align="left">Email</td>
                        <td><?php echo $siteGlobal->sho_email ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center"><a class="btn btn-info" href="<?php echo $URLRoot; ?>/introduct"><i class="fa fa-file-o fa-fw"></i> Xem chi tiết</a> <a class="btn btn-primary"
                                                                                                                                                                                                         href="#sendmail"><i
                                    class="fa fa-envelope-o fa-fw"></i> Gửi email</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12 ">
            <div class="video">
                <iframe src="https://www.youtube.com/embed/<?php echo $siteGlobal->shop_video == '' ? 'zlsQF_ufUNU' : $siteGlobal->shop_video ?>?rel=0&amp;controls=1&amp;showinfo=1" allowfullscreen="" frameborder="0" height="315"
                        width="560"></iframe>
            </div>
            <div class="row hidden-xs hidden-sm">
                <div class="col-sm-6">
                    <div style="background:#ddd; height:152px; margin-top:30px"></div>
                </div>
                <div class="col-sm-6">
                    <div style="background:#ddd; height:152px; margin-top:30px"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!--BEGIN: Center-->
        <div class="col-lg-12 col-md-12 col-sm-12">
            <?php if (isset($siteGlobal)) { ?>
                <script language="javascript" src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/ajax.js"></script>

                <?php
                switch ($siteGlobal->sho_style) {
                    case 'default':
                        $this->load->view('shop/common/content');
                        break;
                    case 'style1':
                        $this->load->view('shop/common/content_slid');
                        break;
                    case 'style2':
                        $this->load->view('shop/common/content_tab');
                        break;
                    case 'style3':
                        $this->load->view('shop/common/content_slid');
                        break;
                } ?>

                <?php $this->load->view('shop/common/blogtintuc'); ?>

                <!--<div id="DivSearch">
						<?php //$this->load->view('shop/common/search'); ?>
					</div>
					<script>OpenSearch(0);</script-->
            <?php } ?>

        </div>
        <!--END Center-->
    </div>

</div>
<div id="sendmail">
    <div class="container">
        <div class="row contact" style="margin:30px 0;">
            <div class="col-lg-12 text-center">
                <h3><i class="fa fa-envelope-o fa-fw"></i> Gửi email cho chúng tôi</h3>
                <p>Bạn có thắc mắc về sản phẩm, dịch vụ của chúng tôi? Đừng ngại, hãy gửi ý kiến của bạn để chúng tôi phục vụ bạn tốt hơn!</p>
            </div>
            <?php if ($successContactShopDetail == false) { ?>
                <form name="frmContact" method="post" class="">

                    <div class="col-md-6 col-sm-6 form-group">
                        <input type="text" name="name_contact" id="name_contact" value="<?php if (isset($name_contact)) {
                            echo $name_contact;
                        } ?>" maxlength="80" class="input_form form-control" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmContact','name_contact');" onfocus="ChangeStyle('name_contact',1)"
                               onblur="ChangeStyle('name_contact',2)" placeholder="* <?php echo $this->lang->line('fullname_detail_contact'); ?>"/>
                        <?php echo form_error('name_contact'); ?>
                    </div>

                    <div class="form-group col-md-6 col-sm-6">
                        <input type="text" name="email_contact" id="email_contact" value="<?php if (isset($email_contact)) {
                            echo $email_contact;
                        } ?>" maxlength="50" class="input_form form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_contact',1)" onblur="ChangeStyle('email_contact',2)"
                               placeholder="* <?php echo $this->lang->line('email_detail_contact'); ?>"/>
                        <?php echo form_error('email_contact'); ?>
                    </div>

                    <div class="form-group col-md-6 col-sm-6">
                        <input type="text" name="address_contact" id="address_contact" value="<?php if (isset($address_contact)) {
                            echo $address_contact;
                        } ?>" maxlength="80" class="input_form form-control" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmContact','address_contact');" onfocus="ChangeStyle('address_contact',1)"
                               onblur="ChangeStyle('address_contact',2)" placeholder="* <?php echo $this->lang->line('address_detail_contact'); ?>"/>
                        <?php echo form_error('address_contact'); ?>
                    </div>
                    <div class="form-group col-md-6 col-sm-6">
                        <input type="text" name="phone_contact" id="phone_contact" value="<?php if (isset($phone_contact)) {
                            echo $phone_contact;
                        } ?>" maxlength="50" class="input_form form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('phone_contact',1)" onblur="ChangeStyle('phone_contact',2)"
                               placeholder="* <?php echo $this->lang->line('phone_detail_contact'); ?>"/>
                        <?php echo form_error('phone_contact'); ?>
                    </div>
                    <div class="form-group col-md-12">
                        <input type="text" name="title_contact" id="title_contact" value="<?php if (isset($title_contact)) {
                            echo $title_contact;
                        } ?>" maxlength="80" class="input_form form-control" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_contact',1);" onblur="ChangeStyle('title_contact',2);"
                               placeholder="* <?php echo $this->lang->line('title_contact_detail_contact'); ?>"/>
                        <?php echo form_error('title_contact'); ?>
                    </div>
                    <div class="form-group col-md-12">
                            <textarea name="content_contact" id="content_contact" cols="47" rows="8" class="textarea_form form-control" onfocus="ChangeStyle('content_contact',1);" onblur="ChangeStyle('content_contact',2);"
                                      placeholder="* <?php echo $this->lang->line('content_detail_contact'); ?>"><?php if (isset($content_contact)) {
                                    echo $content_contact;
                                } ?></textarea>
                        <?php echo form_error('content_contact'); ?>
                    </div>

                    <?php if (isset($imageCaptchaContactShopDetail)) { ?>
                        <div class="form-group col-md-3 col-md-offset-1 text-center">
                            <img src="<?php echo $imageCaptchaContactShopDetail; ?>" width="160" height="34"/>
                        </div>
                        <div class="form-group col-md-4 text-center">
                            <input type="text" name="captcha_contact" id="captcha_contact" value="" maxlength="10" class="inputcaptcha_form form-control" onfocus="ChangeStyle('captcha_contact',1);"
                                   onblur="ChangeStyle('captcha_contact',2);" placeholder="* <?php echo $this->lang->line('captcha_main'); ?>"/>
                            <?php echo form_error('captcha_contact'); ?>
                        </div>
                    <?php } ?>
                    <div class="form-group col-md-3 text-center">

                        <input type="button" onclick="CheckInput_Contact();" name="submit_contact" value="<?php echo $this->lang->line('button_send_detail_contact'); ?>" class="button_form btn btn-primary"/>

                        <input type="reset" name="reset_contact" value="<?php echo $this->lang->line('button_reset_detail_contact'); ?>" class="button_form btn btn-danger"/>

                    </div>

                </form>
            <?php } else { ?>
                <div>
                    <div class="success_post">
                        <p class="text-center"><a href="<?php echo $URLRoot; ?>">Click vào đây để tiếp tục</a></p>
                        <?php echo $this->lang->line('success_detail_contact'); ?>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/header'); ?>
    <div class="container">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <SCRIPT TYPE="text/javascript">
                function submitenter(myfield, e) {
                    var keycode;
                    if (window.event) keycode = window.event.keyCode;
                    else if (e) keycode = e.which;
                    else return true;

                    if (keycode == 13) {
                        CheckInput_ContactAccount();
                        return false;
                    }
                    else
                        return true;
                }
                jQuery(document).ready(function () {
                    jQuery('#con_user_recieve').change(function () {
                        if (jQuery(this).val() != 0)jQuery('#position_line').css('display', 'none');
                        else jQuery('#position_line').css('display','block');
                    });
                    jQuery('#choose_receiver_0').click(function () {
                        jQuery('#position_contact').attr('disabled', 'disabled');
                        jQuery('#con_user_recieve').attr('disabled', 'disabled');
                    });
                    jQuery('#choose_receiver_1').click(function () {
                        jQuery('#position_contact').removeAttr('disabled');
                        jQuery('#con_user_recieve').removeAttr('disabled');
                    })
                });
            </SCRIPT>
            <script>
                jQuery(document).ready(function () {
                    jQuery("#username").autocomplete("<?php echo base_url() ?>home/user/ajax_lien_he", {
                        width: 500,
                        selectFirst: true
                    }).result(function (event, item, formatted) {
                        checUserNameContact(formatted);
                    });
                });

                function checUserNameContact(idUser) {
                    jQuery.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>home/user/check_username",
                        data: "idUser=" + idUser,
                        success: function (data) {
                            if (data == "0") {
                                $.jAlert({
                                    'title': 'Thông báo',
                                    'content': 'Username không tồn tại vui lòng kiểm tra lại!',
                                    'theme': 'red',
                                    'btns': {
                                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                                            e.preventDefault();
                                            jQuery('#username').val('');
                                            document.getElementById("username").focus();
                                            return false;
                                        }
                                    }
                                });
                                return false;
                            }
                        },
                        error: function () {
                        }
                    });
                }
                function checkGuiBanQuanTriOrThanhVien(_value) {
                    if (_value == 1) {
                        jQuery(".user_name_gui").css("display", "block");
                    }
                    else {
                        jQuery(".user_name_gui").css("display", "none");
                    }
                }
            </script>
            <!--BEGIN: RIGHT-->
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
                <h2>
                    <?php echo $this->lang->line('title_contact_send'); ?>
                </h2>
                <form name="frmContactAccount" method="post" class="form-horizontal vienchung">
                    <?php if ($successSendContactAccount == false) { ?>
                        <div class="form-group">
                            <label class="control-label col-sm-2"><font
                                    color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('title_list_contact_send'); ?>
                                :</label>

                            <div class="col-sm-6">
                                <input type="text" name="title_contact" id="title_contact"
                                       value="<?php if (isset($title_contact)) {
                                           echo $title_contact;
                                       } ?>" maxlength="80" class="input_form form-control"
                                       onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_contact',1);"
                                       onblur="ChangeStyle('title_contact',2);"/>
                                <?php echo form_error('title_contact'); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2"><font color="#FF0000"><b>*</b></font>Gửi đến: </label>
                            <div class="col-sm-6">
                                <div style="display:none;">
                                    <input type="radio" name="choose_receiver" id="choose_receiver_0" value="0"/>
                                    Gửi hết hệ thống
                                </div>
                                <div style="display:none;"><input type="radio" name="choose_receiver"
                                                                  id="choose_receiver_1" value="1" checked="checked"/>
                                </div>
                                <select name="con_user_recieve" id="con_user_recieve"
                                        class="con_user_recieve form-control"
                                        onchange="checkGuiBanQuanTriOrThanhVien(this.value);">
                                    <option selected value="-1">--Chọn người gửi</option>
                                    <option value="0">Ban quản trị</option>
                                    <option value="1">Thành viên</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group user_name_gui" style="display: none">
                            <label class="control-label col-sm-2">
                                <div><font color="#FF0000"><b>*</b></font> Thành viên :</div>
                            </label>
                            <div class="col-sm-6">
                                <div>
                                    <input name="username" type="text"
                                            maxlength="255" id="username" class="searchSelect inputbox form-control"/>
                                </div>
                            </div>
                        </div>
                        <div id="position_line" style="display: none" class="form-group">
                            <label class="control-label col-sm-2"><font
                                    color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('position_list_contact_send'); ?>
                                :</label>

                            <div class="col-sm-6">
                                <select  name="position_contact" id="position_contact"
                                        class="form-control">
                                    <option value="1" <?php if (isset($position_contact) && $position_contact == '1') {
                                        echo 'selected="selected"';
                                    } elseif (!isset($position_contact)) {
                                        echo 'selected="selected"';
                                    } ?>><?php echo $this->lang->line('business_contact_send'); ?></option>
                                    <option value="2" <?php if (isset($position_contact) && $position_contact == '2') {
                                        echo 'selected="selected"';
                                    } ?>><?php echo $this->lang->line('tech_contact_send'); ?></option>
                                </select>
                                <?php /*?><img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('position_tip_help_contact_send') ?>',220,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" /><?php */ ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2"><font
                                    color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('content_list_contact_send'); ?>
                                :</label>

                            <div class="col-sm-10">
                                <?php $this->load->view('home/common/editor'); ?>
                                <?php echo form_error('txtContent'); ?>
                                <?php /*?> <?php $this->load->view('home/common/tinymce'); ?>
                    <textarea name="txtContent" id="txtContent"></textarea>
                    <?php echo form_error('txtContent'); ?><?php */ ?>
                            </div>
                        </div>
                        <?php if (isset($imageCaptchaSendContactAccount)) { ?>
                            <div class="form-group">
                                <label class="control-label col-sm-2"><font
                                        color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>
                                    :</label>

                                <div class="col-sm-3">
                                    <img src="<?php echo $imageCaptchaSendContactAccount; ?>"
                                         height="30"/>
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" onkeypress="return submitenter(this,event)"
                                           name="captcha_contact" id="captcha_contact" value="" maxlength="10"
                                           class="inputcaptcha_form form-control"
                                           onfocus="ChangeStyle('captcha_contact',1);"
                                           onblur="ChangeStyle('captcha_contact',2);"/>
                                    <?php echo form_error('captcha_contact'); ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <label class="control-label col-md-2"></label>

                            <div class="col-md-5">
                                <input type="button" onclick="CheckInput_ContactAccount();" name="submit_contact"
                                       value="<?php echo $this->lang->line('button_send_contact_send'); ?>"
                                       class="btn btn-azibai"/>
                                <input type="reset" name="reset_contact"
                                       value="<?php echo $this->lang->line('button_reset_contact_send'); ?>"
                                       class="btn btn-danger"/>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="form-group">
                            <div class="success_post">
                                <p class="text-center"><a href="<?php echo base_url(); ?>account/contact">Click vào đây để tiếp tục</a></p>
                               <p class="text-center"> <?php echo $this->lang->line('success_contact_send'); ?></p>
                            </div>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
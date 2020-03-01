<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<tr>
    <td valign="top">
        <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td width="2"></td>
                <td width="10" class="left_main" valign="top"></td>
                <td align="center" valign="top">
                    <!--BEGIN: Main-->
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td>
                                <!--BEGIN: Item Menu-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="5%" height="67" class="item_menu_left">
                                            <a href="<?php echo base_url(); ?>administ/system/config">
                                            	<img src="<?php echo base_url(); ?>templates/admin/images/item_config.gif" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_defaults'); ?></td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <div class="icon_item" id="icon_item_1" onclick="ActionLink('<?php echo base_url(); ?>administ')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_reset.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('cancel_tool'); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="icon_item" id="icon_item_2" onclick="CheckInput_Config()" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_save.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('save_tool'); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                <!--END Item Menu-->
                            </td>
                        </tr>
                        <tr>
                            <td height="10"></td>
                        </tr>
                        <tr>
                            <td align="center" valign="top">
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="20" height="20" class="corner_lt_post"></td>
                                        <td height="20" class="top_post"></td>
                                        <td width="20" height="20" class="corner_rt_post"></td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="left_post"></td>
                                        <td align="center" valign="top">
                                            <!--BEGIN: Content-->
                                            <table width="780" class="config_main" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td height="30" class="config_top"></td>
                                                </tr>
                                                <?php if($existFile == true){ ?>
                                                <?php if($isWritable == false){ ?>
                                                <tr>
                                                    <td class="message_conf" style="padding-bottom: 20px;">
                                                        <?php echo $this->lang->line('not_writable_message_defaults'); ?>
                                                    </td>
												</tr>
                                                <?php } ?>
                                                <?php if($successEdit == true){ ?>
                                                <tr>
                                                    <td class="message_conf" style="padding-bottom: 20px;">
                                                        <?php echo $this->lang->line('success_edit_defaults'); ?>
                                                    </td>
												</tr>
                                                <?php } ?>
                                                <form name="frmConfig" method="post">
                                                <tr>
                                                    <td>
                                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td colspan="5" class="title_conf"><?php echo $this->lang->line('info_defaults'); ?>:</td>
                                                            </tr>
                                                            <tr>
                                                                <td width="285" class="list_post"><?php echo $this->lang->line('site_name_defaults'); ?>:</td>
                                                                <td align="left">
                                                                    <input type="text" name="site_config" id="site_config" value="<?php echo $site_config; ?>" maxlength="" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('site_config',1)" onblur="ChangeStyle('site_config',2)" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="285" class="list_post"><?php echo $this->lang->line('site_descr_defaults'); ?>:</td>
                                                                <td align="left">
                                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td width="155" valign="top" align="left">
                                                                                <textarea name="descr_config" id="descr_config" class="textarea_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('descr_config',1)" onblur="ChangeStyle('descr_config',2)"><?php echo $descr_config; ?></textarea>
                                                                            </td>
                                                                            <td align="left"></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="285" class="list_post"><?php echo $this->lang->line('site_keyword_defaults'); ?>:</td>
                                                                <td align="left">
                                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td width="155" valign="top" align="left">
                                                                                <textarea name="keyword_config" id="keyword_config" class="textarea_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('keyword_config',1)" onblur="ChangeStyle('keyword_config',2)" /><?php echo $keyword_config; ?></textarea>
                                                                            </td>
                                                                            <td align="left"></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="285" class="list_post"><?php echo $this->lang->line('email1_defaults'); ?>:</td>
                                                                <td align="left">
                                                                    <input type="text" name="email1_config" id="email1_config" value="<?php echo $email1_config; ?>" maxlength="" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email1_config',1)" onblur="ChangeStyle('email1_config',2)" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="285" class="list_post"><?php echo $this->lang->line('email2_defaults'); ?>:</td>
                                                                <td align="left">
                                                                    <input type="text" name="email2_config" id="email2_config" value="<?php echo $email2_config; ?>" maxlength="" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email2_config',1)" onblur="ChangeStyle('email2_config',2)" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="285" class="list_post"><?php echo $this->lang->line('address1_defaults'); ?>:</td>
                                                                <td align="left">
                                                                    <input type="text" name="address1_config" id="address1_config" value="<?php echo $address1_config; ?>" maxlength="" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmConfig','address1_config');" onfocus="ChangeStyle('address1_config',1)" onblur="ChangeStyle('address1_config',2)" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="285" class="list_post"><?php echo $this->lang->line('address2_defaults'); ?>:</td>
                                                                <td align="left">
                                                                    <input type="text" name="address2_config" id="address2_config" value="<?php echo $address2_config; ?>" maxlength="" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmConfig','address2_config');" onfocus="ChangeStyle('address2_config',1)" onblur="ChangeStyle('address2_config',2)" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="285" class="list_post"><?php echo $this->lang->line('phone_defaults'); ?>:</td>
                                                                <td align="left">
                                                                    <img src="<?php echo base_url(); ?>templates/admin/images/phone_1.gif" border="0" />
                                                                    <input type="text" name="phone_config" id="phone_config" value="<?php echo $phone_config; ?>" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phone_config',1)" onblur="ChangeStyle('phone_config',2)" />
                                                                    <b>-</b>
                                                                    <img src="<?php echo base_url(); ?>templates/admin/images/mobile_1.gif" border="0" />
                                                                    <input type="text" name="mobile_config" id="mobile_config" value="<?php echo $mobile_config; ?>" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobile_config',1)" onblur="ChangeStyle('mobile_config',2)" />
                                                                    <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" class="img_helppost" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help'); ?>',135,'#F0F8FF');" onmouseout="hideddrivetip();" />
                                                        			<span class="div_helppost"><?php echo $this->lang->line('phone_help'); ?></span>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="285" class="list_post"><?php echo $this->lang->line('yahoo1_defaults'); ?>:</td>
                                                                <td align="left">
                                                                    <input type="text" name="yahoo1_config" id="yahoo1_config" value="<?php echo $yahoo1_config; ?>" maxlength="" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo1_config',1)" onblur="ChangeStyle('yahoo1_config',2)" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="285" class="list_post"><?php echo $this->lang->line('yahoo2_defaults'); ?>:</td>
                                                                <td align="left">
                                                                    <input type="text" name="yahoo2_config" id="yahoo2_config" value="<?php echo $yahoo2_config; ?>" maxlength="" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo2_config',1)" onblur="ChangeStyle('yahoo2_config',2)" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="285" class="list_post"><?php echo $this->lang->line('skype1_defaults'); ?>:</td>
                                                                <td align="left">
                                                                    <input type="text" name="skype1_config" id="skype1_config" value="<?php echo $skype1_config; ?>" maxlength="" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype1_config',1)" onblur="ChangeStyle('skype1_config',2)" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td width="285" class="list_post"><?php echo $this->lang->line('skype2_defaults'); ?>:</td>
                                                                <td align="left">
                                                                    <input type="text" name="skype2_config" id="skype2_config" value="<?php echo $skype2_config; ?>" maxlength="" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype2_config',1)" onblur="ChangeStyle('skype2_config',2)" />
                                                                </td>
                                                            </tr>
                                                            <!---->
                                                            <tr>
                                                                <td colspan="2" valign="top">
                                                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                                                        <tr>
                                                                            <td height="6" colspan="5"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="5" class="title_conf"><?php echo $this->lang->line('common_defaults'); ?>:</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('timepost_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="timepost_config" id="timepost_config" value="<?php echo $timepost_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('timepost_config',1)" onblur="ChangeStyle('timepost_config',2)" />
                                                                                <font color="#0066FF"><b><?php echo $this->lang->line('second_defaults'); ?></b></font>
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('timelock_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="timelock_config" id="timelock_config" value="<?php echo $timelock_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('timelock_config',1)" onblur="ChangeStyle('timelock_config',2)" />
                                                                                <font color="#0066FF"><b><?php echo $this->lang->line('date_defaults'); ?></b></font>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('timesession_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="timesession_config" id="timesession_config" value="<?php echo $timesession_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('timesession_config',1)" onblur="ChangeStyle('timesession_config',2)" />
                                                                                <font color="#0066FF"><b><?php echo $this->lang->line('minute_defaults'); ?></b></font>
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('timecache_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="timecache_config" id="timecache_config" value="<?php echo $timecache_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('timecache_config',1)" onblur="ChangeStyle('timecache_config',2)" />
                                                                                <font color="#0066FF"><b><?php echo $this->lang->line('minute_defaults'); ?></b></font>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('stopsite_defaults'); ?>:</td>
                                                                            <td align="left" style="padding-top:7px;">
                                                                                <input type="checkbox" name="stopsite_config" id="stopsite_config" value="1" <?php if($stopsite_config == '1'){echo 'checked="checked"';} ?> />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('active_defaults'); ?>:</td>
                                                                            <td align="left" style="padding-top:7px;">
                                                                                <input type="checkbox" name="active_config" id="active_config" value="1" <?php if($active_config == '1'){echo 'checked="checked"';} ?> />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('stopregis_defaults'); ?>:</td>
                                                                            <td align="left" style="padding-top:7px;">
                                                                                <input type="checkbox" name="stopregis_config" id="stopregis_config" value="1" <?php if($stopregis_config == '1'){echo 'checked="checked"';} ?> />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('stopvip_defaults'); ?>:</td>
                                                                            <td align="left" style="padding-top:7px;">
                                                                                <input type="checkbox" name="stopvip_config" id="stopvip_config" value="1" <?php if($stopvip_config == '1'){echo 'checked="checked"';} ?> />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('stopshop_defaults'); ?>:</td>
                                                                            <td align="left" style="padding-top:7px;">
                                                                                <input type="checkbox" name="stopshop_config" id="stopshop_config" value="1" <?php if($stopshop_config == '1'){echo 'checked="checked"';} ?> />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('exchange_defaults'); ?> </td>
                                                                            <td align="left">
                                                                                <input type="text" name="exchange_config" id="exchange_config" value="<?php echo $exchange_config; ?>" maxlength="5" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('exchange_config',1)" onblur="ChangeStyle('exchange_config',2)" />
                                                                                <font color="#0066FF"><b><?php echo $this->lang->line('vnd_defaults'); ?></b></font>
                                                                            </td>
                                                                        </tr>
                                                                            <tr>
                                                                            <td width="230" class="list_post">Chi Phí Uptin:</td>
                                                                            <td align="left" style="padding-top:7px;">
                                                                               <input type="text" name="chiphi_uptin" id="exchange_config" value="<?php echo $chiphi_uptin; ?>" maxlength="5" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('exchange_config',1)" onblur="ChangeStyle('exchange_config',2)" /> <?php echo $this->lang->line('vnd_defaults'); ?>
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"> </td>
                                                                            <td align="left">
                                                                            
                                                                            </td>
                                                                        </tr>
                                                                        <!---->
                                                                        <tr>
                                                                            <td height="6" colspan="5"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="5" class="title_conf"><?php echo $this->lang->line('product_defaults'); ?>:</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('pro1_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="pro1_config" id="pro1_config" value="<?php echo $pro1_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('pro1_config',1)" onblur="ChangeStyle('pro1_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('pro2_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="pro2_config" id="pro2_config" value="<?php echo $pro2_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('pro2_config',1)" onblur="ChangeStyle('pro2_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('pro3_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="pro3_config" id="pro3_config" value="<?php echo $pro3_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('pro3_config',1)" onblur="ChangeStyle('pro3_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('pro4_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="pro4_config" id="pro4_config" value="<?php echo $pro4_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('pro4_config',1)" onblur="ChangeStyle('pro4_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('pro5_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="pro5_config" id="pro5_config" value="<?php echo $pro5_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('pro5_config',1)" onblur="ChangeStyle('pro5_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('pro6_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="pro6_config" id="pro6_config" value="<?php echo $pro6_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('pro6_config',1)" onblur="ChangeStyle('pro6_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('pro7_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="pro7_config" id="pro7_config" value="<?php echo $pro7_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('pro7_config',1)" onblur="ChangeStyle('pro7_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('pro8_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="pro8_config" id="pro8_config" value="<?php echo $pro8_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('pro8_config',1)" onblur="ChangeStyle('pro8_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('pro9_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="pro9_config" id="pro9_config" value="<?php echo $pro9_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('pro9_config',1)" onblur="ChangeStyle('pro9_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('pro10_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="pro10_config" id="pro10_config" value="<?php echo $pro10_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('pro10_config',1)" onblur="ChangeStyle('pro10_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <!---->
                                                                        <tr>
                                                                            <td height="6" colspan="5"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="5" class="title_conf"><?php echo $this->lang->line('ads_defaults'); ?>:</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('ads1_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="ads1_config" id="ads1_config" value="<?php echo $ads1_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('ads1_config',1)" onblur="ChangeStyle('ads1_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('ads2_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="ads2_config" id="ads2_config" value="<?php echo $ads2_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('ads2_config',1)" onblur="ChangeStyle('ads2_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('ads3_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="ads3_config" id="ads3_config" value="<?php echo $ads3_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('ads3_config',1)" onblur="ChangeStyle('ads3_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('ads4_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="ads4_config" id="ads4_config" value="<?php echo $ads4_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('ads4_config',1)" onblur="ChangeStyle('ads4_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('ads5_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="ads5_config" id="ads5_config" value="<?php echo $ads5_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('ads5_config',1)" onblur="ChangeStyle('ads5_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('ads6_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="ads6_config" id="ads6_config" value="<?php echo $ads6_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('ads6_config',1)" onblur="ChangeStyle('ads6_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('ads7_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="ads7_config" id="ads7_config" value="<?php echo $ads7_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('ads7_config',1)" onblur="ChangeStyle('ads7_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('ads8_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="ads8_config" id="ads8_config" value="<?php echo $ads8_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('ads8_config',1)" onblur="ChangeStyle('ads8_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('ads9_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="ads9_config" id="ads9_config" value="<?php echo $ads9_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('ads9_config',1)" onblur="ChangeStyle('ads9_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('ads10_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="ads10_config" id="ads10_config" value="<?php echo $ads10_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('ads10_config',1)" onblur="ChangeStyle('ads10_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <!---->
                                                                        <tr>
                                                                            <td height="6" colspan="5"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="5" class="title_conf"><?php echo $this->lang->line('job_defaults'); ?>:</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('job1_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="job1_config" id="job1_config" value="<?php echo $job1_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('job1_config',1)" onblur="ChangeStyle('job1_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('job2_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="job2_config" id="job2_config" value="<?php echo $job2_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('job2_config',1)" onblur="ChangeStyle('job2_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('job3_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="job3_config" id="job3_config" value="<?php echo $job3_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('job3_config',1)" onblur="ChangeStyle('job3_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('job4_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="job4_config" id="job4_config" value="<?php echo $job4_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('job4_config',1)" onblur="ChangeStyle('job4_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('job5_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="job5_config" id="job5_config" value="<?php echo $job5_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('job5_config',1)" onblur="ChangeStyle('job5_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('job6_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="job6_config" id="job6_config" value="<?php echo $job6_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('job6_config',1)" onblur="ChangeStyle('job6_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <!---->
                                                                        <tr>
                                                                            <td height="6" colspan="5"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="5" class="title_conf"><?php echo $this->lang->line('shop_defaults'); ?>:</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shop1_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shop1_config" id="shop1_config" value="<?php echo $shop1_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shop1_config',1)" onblur="ChangeStyle('shop1_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shop2_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shop2_config" id="shop2_config" value="<?php echo $shop2_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shop2_config',1)" onblur="ChangeStyle('shop2_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shop3_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shop3_config" id="shop3_config" value="<?php echo $shop3_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shop3_config',1)" onblur="ChangeStyle('shop3_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shop4_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shop4_config" id="shop4_config" value="<?php echo $shop4_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shop4_config',1)" onblur="ChangeStyle('shop4_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shop5_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shop5_config" id="shop5_config" value="<?php echo $shop5_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shop5_config',1)" onblur="ChangeStyle('shop5_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shop6_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shop6_config" id="shop6_config" value="<?php echo $shop6_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shop6_config',1)" onblur="ChangeStyle('shop6_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shop7_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shop7_config" id="shop7_config" value="<?php echo $shop7_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shop7_config',1)" onblur="ChangeStyle('shop7_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"></td>
                                                                            <td align="left"></td>
                                                                        </tr>
                                                                        <!---->
                                                                        <tr>
                                                                            <td height="6" colspan="5"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="5" class="title_conf"><?php echo $this->lang->line('shopping_defaults'); ?>:</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shopping1_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shopping1_config" id="shopping1_config" value="<?php echo $shopping1_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shopping1_config',1)" onblur="ChangeStyle('shopping1_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shopping2_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shopping2_config" id="shopping2_config" value="<?php echo $shopping2_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shopping2_config',1)" onblur="ChangeStyle('shopping2_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shopping3_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shopping3_config" id="shopping3_config" value="<?php echo $shopping3_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shopping3_config',1)" onblur="ChangeStyle('shopping3_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shopping4_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shopping4_config" id="shopping4_config" value="<?php echo $shopping4_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shopping4_config',1)" onblur="ChangeStyle('shopping4_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shopping5_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shopping5_config" id="shopping5_config" value="<?php echo $shopping5_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shopping5_config',1)" onblur="ChangeStyle('shopping5_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shopping6_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shopping6_config" id="shopping6_config" value="<?php echo $shopping6_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shopping6_config',1)" onblur="ChangeStyle('shopping6_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shopping7_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shopping7_config" id="shopping7_config" value="<?php echo $shopping7_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shopping7_config',1)" onblur="ChangeStyle('shopping7_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shopping8_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shopping8_config" id="shopping8_config" value="<?php echo $shopping8_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shopping8_config',1)" onblur="ChangeStyle('shopping8_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('shopping9_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="shopping9_config" id="shopping9_config" value="<?php echo $shopping9_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('shopping9_config',1)" onblur="ChangeStyle('shopping9_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"></td>
                                                                            <td align="left"></td>
                                                                        </tr>
                                                                        <!---->
                                                                        <tr>
                                                                            <td height="6" colspan="5"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="5" class="title_conf"><?php echo $this->lang->line('search_defaults'); ?>:</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('search1_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="search1_config" id="search1_config" value="<?php echo $search1_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('search1_config',1)" onblur="ChangeStyle('search1_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('search2_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="search2_config" id="search2_config" value="<?php echo $search2_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('search2_config',1)" onblur="ChangeStyle('search2_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('search3_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="search3_config" id="search3_config" value="<?php echo $search3_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('search3_config',1)" onblur="ChangeStyle('search3_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('search4_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="search4_config" id="search4_config" value="<?php echo $search4_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('search4_config',1)" onblur="ChangeStyle('search4_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <!---->
                                                                        <tr>
                                                                            <td height="6" colspan="5"></td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td colspan="5" class="title_conf"><?php echo $this->lang->line('other_defaults'); ?>:</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('other1_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="other1_config" id="other1_config" value="<?php echo $other1_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('other1_config',1)" onblur="ChangeStyle('other1_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('other2_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="other2_config" id="other2_config" value="<?php echo $other2_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('other2_config',1)" onblur="ChangeStyle('other2_config',2)" />
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td width="230" class="list_post"><?php echo $this->lang->line('other3_defaults'); ?>:</td>
                                                                            <td align="left">
                                                                                <input type="text" name="other3_config" id="other3_config" value="<?php echo $other3_config; ?>" maxlength="3" class="inputconf_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('other3_config',1)" onblur="ChangeStyle('other3_config',2)" />
                                                                            </td>
                                                                            <td width="4"></td>
                                                                            <td width="230" class="list_post"></td>
                                                                            <td align="left"></td>
                                                                        </tr>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <input type="hidden" name="isSubmit" value="true" />
                                                </form>
                                                <?php }else{ ?>
                                                <tr>
                                                    <td class="message_conf">
                                                        <?php echo $this->lang->line('not_find_file_message_defaults'); ?>
                                                    </td>
												</tr>
                                                <?php } ?>
                                                <tr>
                                                    <td height="30" class="config_bottom"></td>
                                                </tr>
                                            </table>
                                            <!--END Content-->
                                        </td>
                                        <td width="20" class="right_post"></td>
                                    </tr>
                                    <tr>
                                        <td width="20" height="20" class="corner_lb_post"></td>
                                        <td height="20" class="bottom_post"></td>
                                        <td width="20" height="20" class="corner_rb_post"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <!--END Main-->
                </td>
                <td width="10" class="right_main" valign="top"></td>
                <td width="2"></td>
            </tr>
            <tr>
                <td width="2" height="11"></td>
                <td width="10" height="11" class="corner_lb_main" valign="top"></td>
                <td height="11" class="middle_bottom_main"></td>
                <td width="10" height="11" class="corner_rb_main" valign="top"></td>
                <td width="2" height="11"></td>
            </tr>
        </table>
    </td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>
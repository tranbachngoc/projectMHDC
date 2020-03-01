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
                                            <img src="<?php echo base_url(); ?>templates/admin/images/item_editnotify.gif" border="0" />
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle">
                                            <?php
                                            $share = strtolower($this->uri->segment(3));
                                            if (isset($share) && $share == 'share') {
                                                echo "Chỉnh sửa link chia sẻ";
                                                $shareurl = '/share';
                                            } else {
                                                echo $this->lang->line('title_edit');
                                            }
                                            ?>
                                            </td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <?php if($successEdit == false){ ?>
                                            <div class="icon_item" id="icon_item_1" onclick="ActionLink('<?php echo base_url().'administ/notify'.$shareurl; ?>')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
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
                                            <div class="icon_item" id="icon_item_2" onclick="CheckInput_EditNotify()" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
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
                                            <?php }else{ ?>
                                            <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url().'administ/notify'.$shareurl.'/add'; ?>')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_add.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('add_tool'); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <?php } ?>
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
                                            <table width="760" class="form_main" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td colspan="2" height="30" class="form_top"></td>
                                                </tr>
                                                <?php if($successEdit == false){ ?>
                                                <form name="frmEditNotify" method="post">
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('title_title_edit'); ?>:</td>
                                                    <td align="left">
                                                        <input type="text" name="title_notify" id="title_notify" value="<?php echo $title_notify; ?>" maxlength="130" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_notify',1)" onblur="ChangeStyle('title_notify',2)" />
                                                        <?php echo form_error('title_notify'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('group_edit'); ?>:</td>
                                                    <td align="left">
                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td>
                                                                    <select name="role_notify[]" id="role_notify" class="selectgroup_formpost" multiple="multiple">
                                                                    	<option value="0" <?php if($role_notify != '' && stristr($role_notify, '0')){echo 'selected="selected"';} ?> style="color:#FF0000; font-weight:bold;"><?php echo $this->lang->line('all_group_edit'); ?></option>
                                                                        <option value="1" <?php if($role_notify != '' && stristr($role_notify, '1') && !stristr($role_notify, '0')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('normal_group_edit'); ?></option>
                                                                        <option value="2" <?php if($role_notify != '' && stristr($role_notify, '2') && !stristr($role_notify, '0')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('af_group_add'); ?></option>
                                                                        <option value="3" <?php if($role_notify != '' && stristr($role_notify, '3') && !stristr($role_notify, '0')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('saler_group_edit'); ?></option>
                                                                        <option value="7" <?php if($role_notify != '' && stristr($role_notify, '7') && !stristr($role_notify, '0')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('developer1_group_edit'); ?></option>
                                                                        <option value="6" <?php if($role_notify != '' && stristr($role_notify, '6') && !stristr($role_notify, '0')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('developer2_group_edit'); ?></option>
                                                                        <option value="9" <?php if($role_notify != '' && stristr($role_notify, '9') && !stristr($role_notify, '0')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('partner1_group_edit'); ?></option>
                                                                        <option value="8" <?php if($role_notify != '' && stristr($role_notify, '8') && !stristr($role_notify, '0')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('partner2_group_edit'); ?></option>
                                                                        <option value="10" <?php if($role_notify != '' && stristr($role_notify, '10') && !stristr($role_notify, '0')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('core_group_edit'); ?></option>
                                                                        <option value="12" <?php if($role_notify != '' && stristr($role_notify, '12') && !stristr($role_notify, '0')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('core_add_admin'); ?></option>
                                                                    </select>
                                                                </td>
                                                                <td style="padding-top:7px;">
                                                                    <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('group_tip_help_edit'); ?>',200,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('degree_edit'); ?>:</td>
                                                    <td align="left">
                                                        <select name="degree_notify" id="degree_notify" class="selectdegree_formpost">
                                                            <option value="1" <?php if($degree_notify == '1'){echo 'selected="selected"';}elseif($degree_notify == ''){echo 'selected="selected"';} ?> style="color:#009900;"><?php echo $this->lang->line('normal_degree_edit'); ?></option>
                                                            <option value="2" <?php if($degree_notify == '2'){echo 'selected="selected"';} ?> style="color:#06F; font-weight:bold;"><?php echo $this->lang->line('important_degree_edit'); ?></option>
                                                            <option value="3" <?php if($degree_notify == '3'){echo 'selected="selected"';} ?> style="color:#FF0000; font-weight:bold;"><?php echo $this->lang->line('rushed_degree_edit'); ?></option>
                                                        </select>
                                                        <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('degree_tip_help_edit'); ?>',240,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                                    </td>
                                                </tr>
                                                    <?php   if (isset($share) && $share == 'share') {?>
                                                    <tr>
                                                        <td  width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> Link chia sẻ: </td>
                                                        <td><input width="100%" name="txtLink" id="txtLink" type="text" value="<?php if(!empty($link_share)){ echo $link_share;}?>" /></td>
                                                    </tr>
                                                    <?php }?>
                                                <tr>
                                                    <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('content_edit'); ?>:</td>
                                                    <td align="left">
                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td>
                                                                         <?php $this->load->view('admin/common/tinymce'); ?>
                                                                     
<textarea name="txtContent" style="width:200px !important;">
<?php echo $txtContent;?>
</textarea>
                                                                </td>
                                                                <td style="padding-top:7px;">
                                                                    <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('content_tip_help'); ?>',320,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <?php echo form_error('txtContent'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('enddate_edit'); ?>:</td>
                                                    <td align="left">
                                                        <select name="endday_notify" id="endday_notify" class="selectdate_formpost">
                                                            <?php for($endday = 1; $endday <= 31; $endday++){ ?>
                                                            <?php if($endday_notify == $endday){ ?>
                                                            <option value="<?php echo $endday; ?>" selected="selected"><?php echo $endday; ?></option>
                                                            <?php }else{ ?>
                                                            <option value="<?php echo $endday; ?>"><?php echo $endday; ?></option>
                                                            <?php } ?>
															<?php } ?>
                                                        </select>
                                                        <b>-</b>
                                                        <select name="endmonth_notify" id="endmonth_notify" class="selectdate_formpost">
                                                            <?php for($endmonth = 1; $endmonth <= 12; $endmonth++){ ?>
                                                            <?php if($endmonth_notify == $endmonth){ ?>
                                                            <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                                                            <?php }elseif($endmonth == $nextMonth && $endmonth_notify == ''){ ?>
                                                            <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                                                            <?php }else{ ?>
                                                            <option value="<?php echo $endmonth; ?>"><?php echo $endmonth; ?></option>
                                                            <?php } ?>
															<?php } ?>
                                                        </select>
                                                        <b>-</b>
                                                        <select name="endyear_notify" id="endyear_notify" class="selectdate_formpost">
                                                            <?php for($endyear = (int)date('Y'); $endyear < (int)date('Y')+10; $endyear++){ ?>
                                                            <?php if($endyear_notify == $endyear){ ?>
                                                            <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                                                            <?php }elseif($endyear == $nextYear && $endyear_notify == ''){ ?>
                                                            <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                                                            <?php }else{ ?>
                                                            <option value="<?php echo $endyear; ?>"><?php echo $endyear; ?></option>
                                                            <?php } ?>
															<?php } ?>
                                                        </select>
                                                        <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('enddate_tip_help'); ?>',325,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                                        <span class="div_helppost"><?php echo $this->lang->line('enddate_help'); ?></span>
                                                        <?php echo form_error('endday_notify'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('status_edit'); ?>:</td>
                                                    <td align="left" style="padding-top:7px;">
                                                        <input type="checkbox" name="active_notify" id="active_notify" value="1" <?php if($active_notify == '1'){echo 'checked="checked"';} ?> />
                                                    </td>
                                                </tr>
                                                </form>
                                                <?php }else{ ?>
                                                <tr class="success_post">
                                                    <td colspan="2">
                                                        <?php   if (isset($share) && $share == 'share') {?>
                                                        <p class="text-center"><a href="<?php echo base_url().'administ/notify/share' ?>">Click vào đây để tiếp tục</a></p>
                                                		<?php echo 'Chỉnh sửa link chia sẻ thành công !'; ?>
                                                        <?php   } else{ ?>
                                                            <p class="text-center"><a href="<?php echo base_url().'administ/notify' ?>">Click vào đây để tiếp tục</a></p>
                                                            <?php echo $this->lang->line('success_edit'); ?>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
												<?php } ?>
                                                <tr>
                                                    <td colspan="2" height="30" class="form_bottom"></td>
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
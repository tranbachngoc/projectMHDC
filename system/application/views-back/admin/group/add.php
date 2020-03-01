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
                                            <img src="<?php echo base_url(); ?>templates/admin/images/item_addgroup.gif" border="0" />
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_add'); ?></td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <?php if($successAdd == false){ ?>
                                            <div class="icon_item" id="icon_item_1" onclick="ActionLink('<?php echo base_url(); ?>administ/group')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
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
                                            <div class="icon_item" id="icon_item_2" onclick="CheckInput_AddGroup()" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
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
                                            <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url(); ?>administ/group/add')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
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
                                            <table width="585" class="form_main" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td colspan="2" height="30" class="form_top"></td>
                                                </tr>
                                                <?php if($successAdd == false){ ?>
                                                <form name="frmAddGroup" method="post">
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('name_add'); ?>:</td>
                                                    <td align="left">
                                                        <input type="text" value="<?php echo $name_group; ?>" name="name_group" id="name_group" maxlength="100" class="input_formpost" onkeyup="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('name_group',1)" onblur="ChangeStyle('name_group',2)" />
                                                        <?php echo form_error('name_group'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('descr_add'); ?>:</td>
                                                    <td align="left">
                                                        <input type="text" value="<?php echo $descr_group; ?>" name="descr_group" id="descr_group" maxlength="100" class="input_formpost" onfocus="ChangeStyle('descr_group',1)" onblur="ChangeStyle('descr_group',2)" />
                                                        <?php echo form_error('descr_group'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('order_add'); ?>:</td>
                                                    <td align="left">
                                                        <input type="text" value="<?php if($order_group != ''){echo $order_group;}else{echo '1';} ?>" name="order_group" id="order_group" maxlength="4" class="inputorder_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('order_group',1)" onblur="ChangeStyle('order_group',2)" />
                                                        <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('order_tip_help'); ?>',155,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                                        <?php echo form_error('order_group'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('permission_add'); ?>:</td>
                                                    <td align="left">
                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td>
                                                                    <select name="permission_group[]" class="selectper_formpost" multiple="multiple">
                                                                        <option value="none" style="color:#F00;" <?php if($permission_group != '' && stristr($permission_group, 'none')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('none_permission_add') ?></option>
                                                                        <option value="config_view" <?php if($permission_group != '' && stristr($permission_group, 'config_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('config_view_add'); ?></option>
                                                                        <option value="config_edit" <?php if($permission_group != '' && stristr($permission_group, 'config_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('config_edit_add'); ?></option>
                                                                        <option value="user_view" <?php if($permission_group != '' && stristr($permission_group, 'user_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('user_view_add'); ?></option>
                                                                        <option value="user_add" <?php if($permission_group != '' && stristr($permission_group, 'user_add')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('user_add_add'); ?></option>
                                                                        <option value="user_edit" <?php if($permission_group != '' && stristr($permission_group, 'user_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('user_edit_add'); ?></option>
                                                                        <option value="user_delete" <?php if($permission_group != '' && stristr($permission_group, 'user_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('user_delete_add'); ?></option>
                                                                        <option value="group_view" <?php if($permission_group != '' && stristr($permission_group, 'group_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('group_view_add'); ?></option>
                                                                        <option value="group_add" <?php if($permission_group != '' && stristr($permission_group, 'group_add')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('group_add_add'); ?></option>
                                                                        <option value="group_edit" <?php if($permission_group != '' && stristr($permission_group, 'group_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('group_edit_add'); ?></option>
                                                                        <option value="group_delete" <?php if($permission_group != '' && stristr($permission_group, 'group_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('group_delete_add'); ?></option>
                                                                        <option value="category_view" <?php if($permission_group != '' && stristr($permission_group, 'category_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('category_view_add'); ?></option>
                                                                        <option value="category_add" <?php if($permission_group != '' && stristr($permission_group, 'category_add')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('category_add_add'); ?></option>
                                                                        <option value="category_edit" <?php if($permission_group != '' && stristr($permission_group, 'category_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('category_edit_add'); ?></option>
                                                                        <option value="category_delete" <?php if($permission_group != '' && stristr($permission_group, 'category_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('category_delete_add'); ?></option>
                                                                        <option value="field_view" <?php if($permission_group != '' && stristr($permission_group, 'field_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('field_view_add'); ?></option>
                                                                        <option value="field_add" <?php if($permission_group != '' && stristr($permission_group, 'field_add')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('field_add_add'); ?></option>
                                                                        <option value="field_edit" <?php if($permission_group != '' && stristr($permission_group, 'field_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('field_edit_add'); ?></option>
                                                                        <option value="field_delete" <?php if($permission_group != '' && stristr($permission_group, 'field_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('field_delete_add'); ?></option>
                                                                        <option value="province_view" <?php if($permission_group != '' && stristr($permission_group, 'province_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('province_view_add'); ?></option>
                                                                        <option value="province_add" <?php if($permission_group != '' && stristr($permission_group, 'province_add')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('province_add_add'); ?></option>
                                                                        <option value="province_edit" <?php if($permission_group != '' && stristr($permission_group, 'province_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('province_edit_add'); ?></option>
                                                                        <option value="province_delete" <?php if($permission_group != '' && stristr($permission_group, 'province_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('province_delete_add'); ?></option>
                                                                        <option value="product_view" <?php if($permission_group != '' && stristr($permission_group, 'product_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('product_view_add'); ?></option>
                                                                        <option value="product_edit" <?php if($permission_group != '' && stristr($permission_group, 'product_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('product_edit_add'); ?></option>
                                                                        <option value="product_delete" <?php if($permission_group != '' && stristr($permission_group, 'product_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('product_delete_add'); ?></option>
                                                                        <option value="ads_view" <?php if($permission_group != '' && stristr($permission_group, 'ads_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('ads_view_add'); ?></option>
                                                                        <option value="ads_edit" <?php if($permission_group != '' && stristr($permission_group, 'ads_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('ads_edit_add'); ?></option>
                                                                        <option value="ads_delete" <?php if($permission_group != '' && stristr($permission_group, 'ads_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('ads_delete_add'); ?></option>
                                                                        <option value="job_view" <?php if($permission_group != '' && stristr($permission_group, 'job_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('job_view_add'); ?></option>
                                                                        <option value="job_edit" <?php if($permission_group != '' && stristr($permission_group, 'job_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('job_edit_add'); ?></option>
                                                                        <option value="job_delete" <?php if($permission_group != '' && stristr($permission_group, 'job_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('job_delete_add'); ?></option>
                                                                        <option value="employ_view" <?php if($permission_group != '' && stristr($permission_group, 'employ_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('employ_view_add'); ?></option>
                                                                        <option value="employ_edit" <?php if($permission_group != '' && stristr($permission_group, 'employ_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('employ_edit_add'); ?></option>
                                                                        <option value="employ_delete" <?php if($permission_group != '' && stristr($permission_group, 'employ_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('employ_delete_add'); ?></option>
                                                                        <option value="shop_view" <?php if($permission_group != '' && stristr($permission_group, 'shop_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('shop_view_add'); ?></option>
                                                                        <option value="shop_add" <?php if($permission_group != '' && stristr($permission_group, 'shop_add')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('shop_add_add'); ?></option>
                                                                        <option value="shop_edit" <?php if($permission_group != '' && stristr($permission_group, 'shop_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('shop_edit_add'); ?></option>
                                                                        <option value="shop_delete" <?php if($permission_group != '' && stristr($permission_group, 'shop_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('shop_delete_add'); ?></option>
                                                                        <option value="advertise_view" <?php if($permission_group != '' && stristr($permission_group, 'advertise_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('advertise_view_add'); ?></option>
                                                                        <option value="advertise_add" <?php if($permission_group != '' && stristr($permission_group, 'advertise_add')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('advertise_add_add'); ?></option>
                                                                        <option value="advertise_edit" <?php if($permission_group != '' && stristr($permission_group, 'advertise_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('advertise_edit_add'); ?></option>
                                                                        <option value="advertise_delete" <?php if($permission_group != '' && stristr($permission_group, 'advertise_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('advertise_delete_add'); ?></option>
                                                                        <option value="contact_view" <?php if($permission_group != '' && stristr($permission_group, 'contact_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('contact_view_add'); ?></option>
                                                                        <option value="contact_add" <?php if($permission_group != '' && stristr($permission_group, 'contact_add')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('contact_add_add'); ?></option>
                                                                        <option value="contact_edit" <?php if($permission_group != '' && stristr($permission_group, 'contact_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('contact_edit_add'); ?></option>
                                                                        <option value="contact_delete" <?php if($permission_group != '' && stristr($permission_group, 'contact_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('contact_delete_add'); ?></option>
                                                                        <option value="notify_view" <?php if($permission_group != '' && stristr($permission_group, 'notify_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('notify_view_add'); ?></option>
                                                                        <option value="notify_add" <?php if($permission_group != '' && stristr($permission_group, 'notify_add')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('notify_add_add'); ?></option>
                                                                        <option value="notify_edit" <?php if($permission_group != '' && stristr($permission_group, 'notify_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('notify_edit_add'); ?></option>
                                                                        <option value="notify_delete" <?php if($permission_group != '' && stristr($permission_group, 'notify_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('notify_delete_add'); ?></option>
                                                                        <option value="menu_view" <?php if($permission_group != '' && stristr($permission_group, 'menu_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('menu_view_add'); ?></option>
                                                                        <option value="menu_add" <?php if($permission_group != '' && stristr($permission_group, 'menu_add')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('menu_add_add'); ?></option>
                                                                        <option value="menu_edit" <?php if($permission_group != '' && stristr($permission_group, 'menu_edit')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('menu_edit_add'); ?></option>
                                                                        <option value="menu_delete" <?php if($permission_group != '' && stristr($permission_group, 'menu_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('menu_delete_add'); ?></option>
                                                                        <option value="showcart_view" <?php if($permission_group != '' && stristr($permission_group, 'showcart_view')){echo 'selected="selected"';}elseif($permission_group == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('showcart_view_add'); ?></option>
                                                                        <option value="showcart_delete" <?php if($permission_group != '' && stristr($permission_group, 'showcart_delete')){echo 'selected="selected"';} ?>><?php echo $this->lang->line('showcart_delete_add'); ?></option>
                                                                    </select>
                                                                </td>
                                                                <td style="padding-top:7px;">
                                                                    <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('permission_tip_help_add'); ?>',340,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('status_add'); ?>:</td>
                                                    <td align="left" style="padding-top:7px;">
                                                        <input type="checkbox" name="active_group" id="active_group" value="1" <?php if($active_group == '1'){echo 'checked="checked"';} ?> />
                                                    </td>
                                                </tr>
                                                </form>
                                                <?php }else{ ?>
                                                <tr class="success_post">
                                                    <td colspan="2">
                                                        <p class="text-center"><a href="<?php echo base_url().'administ/group' ?>">Click vào đây để tiếp tục</a></p>
                                                		<?php echo $this->lang->line('success_add'); ?>
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
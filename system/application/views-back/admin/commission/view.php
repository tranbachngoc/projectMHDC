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
                                            <a href="">
                                            	<img src="<?php echo base_url(); ?>templates/admin/images/item_replycontact.gif" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_view'); ?></td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <?php if($successReply == false){ ?>
                                            <div class="icon_item" id="icon_item_1" onclick="ActionLink('<?php echo base_url(); ?>administ/contact')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
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
                                            <div class="icon_item" id="icon_item_2" onclick="CheckInput_ReplyContact()" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
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
                                            <?php if($successReply == false){ ?>
                                            <table width="780" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td height="60" class="reply_top">
                                                        <table border="0" width="100%" height="60" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td>
                                                                    <div class="title_reply">
                                                                        <?php echo $contact->con_title; ?>
																		<span class="date_reply">(<?php echo $this->lang->line('datecontact_view'); ?> <?php echo date('d-m-Y', $contact->con_date_contact); ?>)</span>
                                                                    </div>
                                                                    <div class="info_reply">
                                                                        <span class="author_reply"><?php echo $this->lang->line('username_view'); ?>: <font color="#A80000"><?php echo $user->use_username; ?></font> <img src="<?php echo base_url(); ?>templates/admin/images/icon_expand.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('fullname_tip_view'); ?>&nbsp;<?php echo $user->use_fullname; ?><br /><?php echo $this->lang->line('email_tip_view'); ?>&nbsp;<?php echo $user->use_email; ?><br /><?php echo $this->lang->line('phone_tip_view'); ?>&nbsp;<?php echo $user->use_phone; ?><br /><?php echo $this->lang->line('yahoo_tip_view'); ?>&nbsp;<?php echo $user->use_yahoo; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();" border="0" style="cursor:pointer;" alt=""/></span>
                                                                        <font color="#666666"><b>|</b></font>
                                                                        <span class="position_reply">
																		<?php echo $this->lang->line('position_view'); ?>:
																		<?php if($contact->con_position == 1){ ?>
																		<font color="#0066FF"><b><?php echo $this->lang->line('business_defaults'); ?></b></font>
																		<?php }else{ ?>
																		<font color="#00CC00"><b><?php echo $this->lang->line('tech_defaults'); ?></b></font>
																		<?php } ?>
																		</span>
                                                                    </div>
                                                                </td>
                                                                <td width="30" style="padding-top:10px; padding-right:4px;"><img src="<?php echo base_url(); ?>templates/admin/images/reply.gif" border="0" style="cursor:pointer;" onclick="OpenTabReply(1)" alt="<?php echo $this->lang->line('reply_tip_view'); ?>" /></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td valign="top" class="reply_main">
                                                    <?php echo $this->bbcode->light($contact->con_detail); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="30" class="reply_bottom"></td>
                                                </tr>
                                                <form name="frmReplyContact" method="post">
                                                <tr id="DivReply">
                                                    <td height="260">
                                                        <?php $this->load->view('admin/common/weditor'); ?>
                                                        <?php echo form_error('txtContent'); ?>
                                                    </td>
                                                </tr>
                                                <input type="hidden" name="isSubmit" value="true"  />
                                                </form>
                                                <?php if($errorReply == true){ ?>
                                                <script>OpenTabReply(2);</script>
                                                <?php }else{ ?>
                                                <script>OpenTabReply(0);</script>
                                                <?php } ?>
                                                <?php }else{ ?>
                                                <table width="585" class="form_main" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td height="30" class="form_top"></td>
                                                </tr>
                                                <tr class="success_post">
                                                    <td>
                                                        <p class="text-center"><a href="">Click vào đây để tiếp tục</a></p>
                                                		<?php echo $this->lang->line('success_reply_view'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td height="30" class="form_bottom"></td>
                                                </tr>
                                                <?php } ?>
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
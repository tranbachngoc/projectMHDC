<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<tr>
    <td valign="top">
    <script>
    function showChoosingSponser(value){
			if(value==6 || value==7 || value==8 || value==9){
				$('#active_user').attr('checked', false);
				$('#active_user').css('display', 'none');
				$('#sponserid').css('display', 'block');								
			}else{
				
				$('#sponserid').css('display', 'none');
				
				if(value==10){
					$('#active_user').css('display', 'none');
				}else{
					$('#active_user').css('display', 'block');
				}
				
				if(value==12){
					$('#active_user').css('display', 'none');
				}else{
					$('#active_user').css('display', 'block');
				}
				
			}
			
			
		}
    </script>
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
                                            <img src="<?php echo base_url(); ?>templates/admin/images/item_adduser.gif" border="0" />
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_add'); ?></td>
                                        <td width="55%" height="67" class="item_menu_right">
											<?php if($successAdd == false){ ?>
                                            <div class="icon_item" id="icon_item_1" onclick="ActionLink('<?php echo base_url(); ?>administ/user')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
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
                                            <div class="icon_item" id="icon_item_2" onclick="CheckInput_AddUser()" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
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
                                            <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url(); ?>administ/user/add')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
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
                                                <form name="frmAddUser" method="post">
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('username_add'); ?>:</td>
                                                    <td align="left">
                                                        <input type="text" value="<?php echo $username_user; ?>" name="username_user" id="username_user" maxlength="35" class="input_formpost" onkeyup="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('username_user',1)" onblur="ChangeStyle('username_user',2)" />
                                                        <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" class="img_helppost" onmouseover="ddrivetip('<?php echo $this->lang->line('username_tip_help'); ?>',275,'#F0F8FF');" onmouseout="hideddrivetip();" />
                                                        <span class="div_helppost"><?php echo $this->lang->line('username_help'); ?></span>
                                                        <?php echo form_error('username_user'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('password_add'); ?>:</td>
                                                    <td align="left">
                                                        <input type="password" value="" name="password_user" id="password_user" maxlength="35" class="input_formpost" onfocus="ChangeStyle('password_user',1)" onblur="ChangeStyle('password_user',2)" />
                                                        <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" class="img_helppost" onmouseover="ddrivetip('<?php echo $this->lang->line('password_tip_help'); ?>',275,'#F0F8FF');" onmouseout="hideddrivetip();" />
                                                        <span class="div_helppost"><?php echo $this->lang->line('password_help'); ?></span>
                                                        <?php echo form_error('password_user'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('repassword_add'); ?>:</td>
                                                    <td align="left">
                                                        <input type="password" value="" name="repassword_user" id="repassword_user" maxlength="35" class="input_formpost" onfocus="ChangeStyle('repassword_user',1)" onblur="ChangeStyle('repassword_user',2)" />
                                                        <?php echo form_error('repassword_user'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_add'); ?>:</td>
                                                    <td align="left">
                                                        <input type="text" value="<?php echo $email_user; ?>" name="email_user" id="email_user" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_user',1)" onblur="ChangeStyle('email_user',2)" />
                                                        <?php echo form_error('email_user'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('reemail_add'); ?>:</td>
                                                    <td align="left">
                                                        <input type="text" value="<?php echo $reemail_user; ?>" name="reemail_user" id="reemail_user" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('reemail_user',1)" onblur="ChangeStyle('reemail_user',2)" />
                                                        <?php echo form_error('reemail_user'); ?>
													</td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('fullname_add'); ?>:</td>
                                                    <td align="left">
                                                        <input type="text" value="<?php echo $fullname_user; ?>" name="fullname_user" id="fullname_user" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmAddUser','fullname_user');" onfocus="ChangeStyle('fullname_user',1)" onblur="ChangeStyle('fullname_user',2)" />
                                                        <?php echo form_error('fullname_user'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('birthday_add'); ?>:</td>
                                                    <td align="left">
                                                        <select name="day_user" id="day_user" class="selectdate_formpost">
                                                            <?php for($day = 1; $day <= 31; $day++){ ?>
                                                            <?php if($day_user == $day){ ?>
                                                            <option value="<?php echo $day; ?>" selected="selected"><?php echo $day; ?></option>
                                                            <?php }else{ ?>
                                                            <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                                                            <?php } ?>
															<?php } ?>
                                                        </select>
                                                        <b>-</b>
                                                        <select name="month_user" id="month_user" class="selectdate_formpost">
                                                            <?php for($month = 1; $month <= 12; $month++){ ?>
                                                            <?php if($month_user == $month){ ?>
                                                            <option value="<?php echo $month; ?>" selected="selected"><?php echo $month; ?></option>
                                                            <?php }else{ ?>
                                                            <option value="<?php echo $month; ?>"><?php echo $month; ?></option>
                                                            <?php } ?>
															<?php } ?>
                                                        </select>
                                                        <b>-</b>
                                                        <select name="year_user" id="year_user" class="selectdate_formpost">
                                                            <?php for($year = (int)date('Y')-70; $year <= (int)date('Y')-10; $year++){ ?>
                                                            <?php if($year_user == $year){ ?>
                                                            <option value="<?php echo $year; ?>" selected="selected"><?php echo $year; ?></option>
                                                            <?php }else{ ?>
                                                            <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                            <?php } ?>
															<?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('sex_add'); ?>:</td>
                                                    <td align="left">
                                                        <select name="sex_user" id="sex_user" class="selectsex_formpost">
                                                            <option value="1" <?php if($sex_user == '1'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('male_add'); ?></option>
                                                            <option value="0" <?php if($sex_user == '0'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('female_add'); ?></option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_add'); ?>:</td>
                                                    <td align="left">
                                                        <input type="text" value="<?php echo $address_user; ?>" name="address_user" id="address_user" maxlength="80" class="input_formpost"  onfocus="ChangeStyle('address_user',1)" onblur="ChangeStyle('address_user',2)" />
                                                        <?php echo form_error('address_user'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('province_add'); ?>:</td>
                                                    <td align="left">
                                                        
                                                        <select name="province_user" id="province_user" class="selectprovince_formpost">
                                                            <?php foreach($province as $provinceArray){ ?>
                                                                <?php if($province_user == $provinceArray->pre_id){ ?>
                                                                    <option value="<?php echo $provinceArray->pre_id; ?>" selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                                                <?php }else{ ?>
                                                                    <option value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('district_add'); ?>:</td>
                                                    <td align="left">
                                                        <select name="district_user" id="district_user" class="selectdistrict_formpost">
                                                        </select>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_add'); ?>:</td>
                                                    <td align="left">
                                                        <img src="<?php echo base_url(); ?>templates/admin/images/phone_1.gif" border="0" />
                                                        <input type="text" value="<?php echo $phone_user; ?>" name="phone_user" id="phone_user" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phone_user',1)" onblur="ChangeStyle('phone_user',2)" />
                                                        <b>-</b>
                                                        <img src="<?php echo base_url(); ?>templates/admin/images/mobile_1.gif" border="0" />
                                                        <input type="text" value="<?php echo $mobile_user; ?>" name="mobile_user" id="mobile_user" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobile_user',1)" onblur="ChangeStyle('mobile_user',2)" />
                                                        <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" class="img_helppost" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help'); ?>',135,'#F0F8FF');" onmouseout="hideddrivetip();" />
                                                        <span class="div_helppost"><?php echo $this->lang->line('phone_help'); ?></span>
                                                        <?php echo form_error('phone_user'); ?>
                                                        <?php echo form_error('mobile_user'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('yahoo_add'); ?>:</td>
                                                    <td align="left">
                                                        <input type="text" value="<?php echo $yahoo_user; ?>" name="yahoo_user" id="yahoo_user" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo_user',1)" onblur="ChangeStyle('yahoo_user',2)" />
                                                        <?php echo form_error('yahoo_user'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('skype_add'); ?>:</td>
                                                    <td align="left">
                                                        <input type="text" value="<?php echo $skype_user; ?>" name="skype_user" id="skype_user" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_user',1)" onblur="ChangeStyle('skype_user',2)" />
                                                        <?php echo form_error('skype_user'); ?>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('cmnd_number'); ?>:</td>
                                                    <td align="left">
                                                        <input type="text" value="" name="idcard_regis" id="idcard_regis" maxlength="50" class="input_formpost" />
                                                        <?php echo form_error('idcard_regis'); ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('taxcode_regis'); ?>:</td>
                                                    <td align="left">
                                                        <input type="text" value="" name="taxcode_regis" id="taxcode_regis" maxlength="50" class="input_formpost" />
                                                        <?php echo form_error('taxcode_regis'); ?>
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('group_add'); ?>:</td>
                                                    <td align="left">
                                                        <select style="width:150px;" name="role_user" id="role_user" class="selectrole_formpost" onchange="showChoosingSponser(this.value); OpenTabEndday('DivEndDay',this.value,1);">
                                                            <?php foreach($group as $groupArray){
																if($groupArray->gro_id == 3){ continue;
																} 
															?>
                                                            <?php if($groupArray->gro_id == 4){ ?>
                                                            <option value="<?php echo $groupArray->gro_id; ?>" <?php if($role_user == $groupArray->gro_id){echo 'selected="selected"';} ?> style="font-weight:bold; color:#F00;"><?php echo $groupArray->gro_name; ?></option>
                                                            <?php }elseif($groupArray->gro_id == 3){ ?>
                                                            <option value="<?php echo $groupArray->gro_id; ?>" <?php if($role_user == $groupArray->gro_id){echo 'selected="selected"';} ?> style="font-weight:bold; color:#009900;"><?php echo $groupArray->gro_name; ?></option>
                                                            <?php }elseif($groupArray->gro_id == 6 || $groupArray->gro_id == 7 ){ ?>
                                                            <option value="<?php echo $groupArray->gro_id; ?>" <?php if($role_user == $groupArray->gro_id){echo 'selected="selected"';} ?> style="font-weight:bold; color:#06F;"><?php echo $groupArray->gro_name; ?></option>
                                                             <?php }elseif($groupArray->gro_id == 8 || $groupArray->gro_id == 9 ){ ?>
                                                            <option value="<?php echo $groupArray->gro_id; ?>" <?php if($role_user == $groupArray->gro_id){echo 'selected="selected"';} ?> style="font-weight:bold; color: #F30;"><?php echo $groupArray->gro_name; ?></option>
                                                             <?php }elseif($groupArray->gro_id == 10){ ?>
                                                            <option value="<?php echo $groupArray->gro_id; ?>" <?php if($role_user == $groupArray->gro_id){echo 'selected="selected"';} ?> style="font-weight:bold; color: #0FF;"><?php echo $groupArray->gro_name; ?></option>
                                                            
                                                            <?php }else{ ?>
                                                            <option value="<?php echo $groupArray->gro_id; ?>" <?php if($role_user == $groupArray->gro_id){echo 'selected="selected"';} ?>><?php echo $groupArray->gro_name; ?></option>
                                                            <?php } ?>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                                <tr >
	                                                    <td width="150" valign="top" class="list_post">Người giới thiệu:</td>
	                                                    <td align="left">
                                                        <div id="sponserid" style="display:none;">
	                                                        <input type="text" value="" name="sponser_user" id="sponser_user" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" placeholder="username" onfocus="ChangeStyle('sponser_user',1)" onblur="ChangeStyle('sponser_user',2)" />
	                                                        <?php echo form_error('skype_user'); ?>
                                                            </div>
	                                                    </td>
	                                                </tr>
                                                <tr id="DivEndDay">
                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('enddate_add'); ?>:</td>
                                                    <td align="left">
                                                        <select name="endday_user" id="endday_user" class="selectdate_formpost">
                                                            <?php for($endday = 1; $endday <= 31; $endday++){ ?>
                                                            <?php if($endday_user == $endday){ ?>
                                                            <option value="<?php echo $endday; ?>" selected="selected"><?php echo $endday; ?></option>
                                                            <?php }else{ ?>
                                                            <option value="<?php echo $endday; ?>"><?php echo $endday; ?></option>
                                                            <?php } ?>
															<?php } ?>
                                                        </select>
                                                        <b>-</b>
                                                        <select name="endmonth_user" id="endmonth_user" class="selectdate_formpost">
                                                            <?php for($endmonth = 1; $endmonth <= 12; $endmonth++){ ?>
                                                            <?php if($endmonth_user == $endmonth){ ?>
                                                            <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                                                            <?php }elseif($endmonth == $nextMonth && $endmonth_user == ''){ ?>
                                                            <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                                                            <?php }else{ ?>
                                                            <option value="<?php echo $endmonth; ?>"><?php echo $endmonth; ?></option>
                                                            <?php } ?>
															<?php } ?>
                                                        </select>
                                                        <b>-</b>
                                                        <select name="endyear_user" id="endyear_user" class="selectdate_formpost">
                                                            <?php for($endyear = (int)date('Y'); $endyear < (int)date('Y')+10; $endyear++){ ?>
                                                            <?php if($endyear_user == $endyear){ ?>
                                                            <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                                                            <?php }elseif($endyear == $nextYear && $endyear_user == ''){ ?>
                                                            <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                                                            <?php }else{ ?>
                                                            <option value="<?php echo $endyear; ?>"><?php echo $endyear; ?></option>
                                                            <?php } ?>
															<?php } ?>
                                                        </select>
                                                        <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" class="img_helppost" onmouseover="ddrivetip('<?php echo $this->lang->line('enddate_tip_help'); ?>',325,'#F0F8FF');" onmouseout="hideddrivetip();" />
                                                        <span class="div_helppost"><?php echo $this->lang->line('enddate_help'); ?></span>
                                                        <?php echo form_error('endday_user'); ?>
                                                    </td>
                                                </tr>
                                                <?php if($role_user == '2'){ ?>
                                                <script>OpenTabEndday('DivEndDay','',2);</script>
                                                <?php }else{ ?>
                                                <script>OpenTabEndday('DivEndDay','',0);</script>
                                                <?php } ?>
                                                <tr>
                                                    <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('active_add'); ?>:</td>
                                                    <td align="left" style="padding-top:7px;">
                                                        <input type="checkbox" name="active_user" id="active_user" value="1" <?php if($active_user == '1'){echo 'checked="checked"';} ?> />
                                                    </td>
                                                </tr>
                                                </form>
                                                <?php }else{ ?>
                                                <tr class="success_post">
                                                    <td colspan="2">
                                                        <p class="text-center"><a href="<?php echo base_url().'administ/user' ?>">Click vào đây để tiếp tục</a></p>
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
<script>
$( "#province_user" ).change(function() {
    if($("#province_user").val()){
        $.ajax({
            url     : '<?php echo base_url(); ?>home/showcart/getDistrict',
            type    : "POST",
            data    : {user_province_put:$("#province_user").val()},
            cache   : true,
            beforeSend: function(){
                document.getElementById("province_user").disabled = true;
            },
            success:function(response)
            {
                document.getElementById("province_user").disabled = false;
                if(response){
                    var json = JSON.parse(response);
                    emptySelectBoxById('district_user',json);
                    delete json;
                } else {
                    alert("Lỗi! Vui lòng thử lại");
                }
            },
            error: function()
            {
                alert("Lỗi! Vui lòng thử lại");
            }
        });
    }
});

function emptySelectBoxById(eid, value) {
    if(value){
        var text = "";
        $.each(value, function(k, v) {
                //display the key and value pair
                if(k != ""){
                    text += "<option value='" + k + "'>" + v + "</option>";
                }
        });
        document.getElementById(eid).innerHTML = text;
        delete text;
    }
}
</script>
<?php $this->load->view('admin/common/footer'); ?>
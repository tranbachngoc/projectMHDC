<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>

    <tr>
		<td valign="top">
        <script>
        $(document).ready(function() {
                $('#password_user').val('');
                $('#repassword_user').val('');
                $("select :selected").each(function(){
                        $(this).parent().data("default", this);
                });
                
                
                $( "#province_user" ).change(function() {
                        if($("#province_user").val()){
                            $.ajax({
                                url     : '<?php echo base_url(); ?>home/showcart/getDistrict',
                                type    : "POST",
                                data    : {user_province_put:$("#province_user").val()},
                                cache   : true,
                                success:function(response)
                                {
                                    if(response){
                                        var json = JSON.parse(response);
                                        emptySelectBoxById('user_district',json);
                                        delete json;
                                    } else {
                                        document.getElementById("user_district").innerHTML = "<option value=''>Không tìm thấy quận/huyện</option>";
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
                
                
                $("input[name='taxtype_regis']").change(function() {
                    if($(this).val() == 1){
                        document.getElementById('group_company1').style.display = 'block';
                        document.getElementById('group_company1').style.display = 'table-row';
                        
                        document.getElementById('group_company2').style.display = 'block';
                        document.getElementById('group_company2').style.display = 'table-row';
                        
                        document.getElementById('group_company3').style.display = 'block';
                        document.getElementById('group_company3').style.display = 'table-row';
                    } else {
                        document.getElementById('group_company1').style.display = 'none';
                        document.getElementById('group_company2').style.display = 'none';
                        document.getElementById('group_company3').style.display = 'none';
                    }
                });

          });
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
                                            	<img src="<?php echo base_url(); ?>templates/admin/images/item_edituser.gif" border="0" />
                                            </td>
                                            <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_edit'); ?></td>
                                            <td width="55%" height="67" class="item_menu_right">
                                             	<?php if($successEdit == false){ ?>
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
	                                            <div class="icon_item" id="icon_item_2" onclick="CheckInput_EditUser()" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
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
                                                    <?php if($successEdit == false){ ?>
                                                    <form name="frmEditUser" method="post">
                                                        <?php if($tax_type == 0): ?>
                                                            <?php $display = "style='display:none'"; ?>
                                                        <?php else: ?>
                                                            <?php $display = "style='display:table-row'"; ?>
                                                        <?php endif; ?>
													<tr>
	                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('username_edit'); ?>:</td>
	                                                    <td align="left">
	                                                        <input type="text" value="<?php echo $username_user; ?>" name="username_user" id="username_user" maxlength="35" onkeyup="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('username_user',1)" onblur="ChangeStyle('username_user',2)" />
	                                                        <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" class="img_helppost" onmouseover="ddrivetip('<?php echo $this->lang->line('username_tip_help'); ?>',275,'#F0F8FF');" onmouseout="hideddrivetip();"  />
	                                                        <span class="div_helppost"><?php echo $this->lang->line('username_help'); ?></span>
	                                                        <?php echo form_error('username_user'); ?>
	                                                    </td>
	                                                </tr>

	                                                <tr>
	                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('password_edit'); ?>:</td>
	                                                    <td align="left">
	                                                        <input type="password" value="" name="password_user" id="password_user" maxlength="35" onfocus="ChangeStyle('password_user',1)" onblur="ChangeStyle('password_user',2)" />
	                                                        <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" class="img_helppost" onmouseover="ddrivetip('<?php echo $this->lang->line('password_tip_help'); ?>',275,'#F0F8FF');" onmouseout="hideddrivetip();" />
	                                                        <span class="div_helppost"><?php echo $this->lang->line('password_help'); ?></span>
	                                                        <?php echo form_error('password_user'); ?>
	                                                    </td>
	                                                </tr>
	                                                <tr>
	                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('repassword_edit'); ?>:</td>
	                                                    <td align="left">
	                                                        <input type="password" value="" name="repassword_user" id="repassword_user" maxlength="35" onfocus="ChangeStyle('repassword_user',1)" onblur="ChangeStyle('repassword_user',2)" />
	                                                        <?php echo form_error('repassword_user'); ?>
	                                                    </td>
	                                                </tr>
	                                                <tr>
	                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_edit'); ?>:</td>
	                                                    <td align="left">
	                                                        <input type="text" value="<?php echo $email_user; ?>" name="email_user" id="email_user" maxlength="50" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_user',1)" onblur="ChangeStyle('email_user',2)" />
	                                                        <?php echo form_error('email_user'); ?>
	                                                    </td>
	                                                </tr>
<!--	                                                <tr>-->
<!--	                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> --><?php //echo $this->lang->line('reemail_edit'); ?><!--:</td>-->
<!--	                                                    <td align="left">-->
<!--	                                                        <input type="text" value="--><?php //echo $reemail_user; ?><!--" name="reemail_user" id="reemail_user" maxlength="50" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('reemail_user',1)" onblur="ChangeStyle('reemail_user',2)" />-->
<!--	                                                        --><?php //echo form_error('reemail_user'); ?>
<!--														</td>-->
<!--	                                                </tr>-->
	                                                <tr>
	                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('fullname_edit'); ?>:</td>
	                                                    <td align="left">
	                                                        <input type="text" value="<?php echo $fullname_user; ?>" name="fullname_user" id="fullname_user" maxlength="80" onfocus="ChangeStyle('fullname_user',1)" />
	                                                        <?php echo form_error('fullname_user'); ?>
	                                                    </td>
	                                                </tr>
	                                                <tr>
	                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('birthday_edit'); ?>:</td>
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
	                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('sex_edit'); ?>:</td>
	                                                    <td align="left">
	                                                        <select name="sex_user" id="sex_user" class="selectsex_formpost">
	                                                            <option value="1" <?php if($sex_user == '1'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('male_edit'); ?></option>
	                                                            <option value="0" <?php if($sex_user == '0'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('female_edit'); ?></option>
	                                                        </select>
	                                                    </td>
	                                                </tr>
	                                                <tr>
	                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_edit'); ?>:</td>
	                                                    <td align="left">
	                                                        <input type="text" value="<?php echo $address_user; ?>" name="address_user" id="address_user" maxlength="80" onfocus="ChangeStyle('address_user',1)" />
	                                                        <?php echo form_error('address_user'); ?>
	                                                    </td>
	                                                </tr>
	                                                <tr>
	                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('province_edit'); ?>:</td>
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
                                                                <select name="user_district" id="user_district" class="selectprovince_formpost">
                                                                    <?php foreach($district as $districtArray){ ?>
                                                                        <?php if($user_district == $districtArray->DistrictCode){ ?>
                                                                            <option value="<?php echo $districtArray->DistrictCode; ?>" selected="selected"><?php echo $districtArray->DistrictName; ?></option>
                                                                        <?php }else{ ?>
                                                                            <option value="<?php echo $districtArray->DistrictCode; ?>"><?php echo $districtArray->DistrictName; ?></option>
                                                                        <?php } ?>
                                                                    <?php } ?>
	                                                        </select>
                                                            </td>
                                                        </tr>
	                                                <tr>
	                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_edit'); ?>:</td>
	                                                    <td align="left" style="padding:10px 0">
	                                                        
	                                                        <input type="text" value="<?php echo $phone_user; ?>" name="phone_user" id="phone_user" maxlength="20" class="" onfocus="ChangeStyle('phone_user',1)" onblur="ChangeStyle('phone_user',2)" />
                                                                <img src="<?php echo base_url(); ?>templates/admin/images/phone_1.gif" border="0" />
                                                                <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" class="img_helppost" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help'); ?>',135,'#F0F8FF');" onmouseout="hideddrivetip();" />
	                                                        <span class="div_helppost"><?php echo $this->lang->line('phone_help'); ?></span>
	                                                        <br/>
	                                                        
	                                                        <input type="text" value="<?php echo $mobile_user; ?>" name="mobile_user" id="mobile_user" maxlength="20" class="" onfocus="ChangeStyle('mobile_user',1)" onblur="ChangeStyle('mobile_user',2)" />
                                                                <img src="<?php echo base_url(); ?>templates/admin/images/mobile_1.gif" border="0" />
                                                                
	                                                        <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" class="img_helppost" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help'); ?>',135,'#F0F8FF');" onmouseout="hideddrivetip();" />
	                                                        <span class="div_helppost"><?php echo $this->lang->line('phone_help'); ?></span>
	                                                        <?php echo form_error('phone_user'); ?>
	                                                        <?php echo form_error('mobile_user'); ?>
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="150" valign="top" class="list_post">Số CMND:</td>
	                                                    <td align="left">
	                                                        <input type="text" value="<?php echo $id_card; ?>" name="id_card" id="id_card" maxlength="20"/>
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="150" valign="top" class="list_post">Mã số thuế <?php echo $tax_type == 0?'cá nhân':'doanh nghiệp';?>:</td>
	                                                    <td align="left" style="padding:10px 0">
	                                                        <input type="text" value="<?php echo $tax_code; ?>" name="tax_code" id="tax_code"/>
                                                                <br/>
                                                                <input type="radio" name="taxtype_regis" class="tax_type" <?php echo $tax_type == 0?'checked="checked"':'';?> value="0" id="tax_0"> <label for="tax_0">Mã số thuế cá nhân</label>
                                                                <input type="radio" name="taxtype_regis" class="tax_type" <?php echo $tax_type == 1?'checked="checked"':'';?> value="1" id="tax_1"> <label for="tax_1">Mã số doanh nghiệp</label>
	                                                    </td>
	                                                </tr>
                                                        
                                                        <tr id="group_company1" <?php echo $display; ?>>
                                                                <td width="150" valign="top" class="list_post">Tên công ty đầy đủ:</td>
                                                                <td align="left">
                                                                    <input type="text" value="<?php echo $company_name; ?>" name="company_name" id="company_name" maxlength="35" />
                                                                </td>
                                                            </tr>
                                                            <tr id="group_company2" <?php echo $display; ?>>
                                                                <td width="150" valign="top" class="list_post">Người đại diện:</td>
                                                                <td align="left">
                                                                    <input type="text" value="<?php echo $company_agent; ?>" name="company_agent" id="company_agent" maxlength="35" />
                                                                </td>
                                                            </tr>
                                                            <tr id="group_company3" <?php echo $display; ?>>
                                                                <td width="150" valign="top" class="list_post">Chức vụ:</td>
                                                                <td align="left">
                                                                    <input type="text" value="<?php echo $company_position; ?>" name="company_position" id="company_position" maxlength="35" />
                                                                </td>
                                                            </tr>
                                                        
                                                        
                                                        
													<tr>
	                                                    <td width="150" valign="top" class="list_post">Tên ngân hàng:</td>
	                                                    <td align="left">
	                                                        <input type="text" value="<?php echo $bank_name; ?>" name="bank_name" id="bank_name"/>
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="150" valign="top" class="list_post">Địa chỉ ngân hàng:</td>
	                                                    <td align="left">
	                                                        <input type="text" value="<?php echo $bank_add; ?>" name="bank_add" id="bank_add" />
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="150" valign="top" class="list_post">Chủ tài khoản:</td>
	                                                    <td align="left">
	                                                        <input type="text" value="<?php echo $account_name; ?>" name="account_name" id="account_name" />
	                                                    </td>
	                                                </tr>
													<tr>
	                                                    <td width="150" valign="top" class="list_post">Số tài khoản:</td>
	                                                    <td align="left">
	                                                        <input type="text" value="<?php echo $num_account; ?>" name="num_account" id="num_account" />
	                                                    </td>
	                                                </tr>

<!--	                                                <tr>-->
<!--	                                                    <td width="150" valign="top" class="list_post">--><?php //echo $this->lang->line('yahoo_edit'); ?><!--:</td>-->
<!--	                                                    <td align="left">-->
<!--	                                                        <input type="text" value="--><?php //echo $yahoo_user; ?><!--" name="yahoo_user" id="yahoo_user" maxlength="50" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo_user',1)" onblur="ChangeStyle('yahoo_user',2)" />-->
<!--	                                                        --><?php //echo form_error('yahoo_user'); ?>
<!--	                                                    </td>-->
<!--	                                                </tr>-->
<!--	                                                <tr>-->
<!--	                                                    <td width="150" valign="top" class="list_post">--><?php //echo $this->lang->line('skype_edit'); ?><!--:</td>-->
<!--	                                                    <td align="left">-->
<!--	                                                        <input type="text" value="--><?php //echo $skype_user; ?><!--" name="skype_user" id="skype_user" maxlength="50" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_user',1)" onblur="ChangeStyle('skype_user',2)" />-->
<!--	                                                        --><?php //echo form_error('skype_user'); ?>
<!--	                                                    </td>-->
<!--	                                                </tr>-->
                                                   
	                                                <tr>
	                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('group_edit'); ?>:</td>
	                                                    <td align="left">

	                                                        <select name="role_user" id="role_user" <?php if($userLogined == true){echo 'readonly = "readonly"="readonly = "readonly""';} ?> class="selectrole_formpost" onchange="OpenTabEndday('DivEndDay',this.value,1);">
	                                                            <?php foreach($group as $groupArray){
                                                                        if(count($arrGroup) > 0){
                                                                                if(!in_array($groupArray->gro_id,$arrGroup)){
                                                                                        continue;
                                                                                }
                                                                        }

                                                                if($userObject->use_group == 3 || $userObject->use_group == 1){
                                                                        if($groupArray->gro_id !=3 && $groupArray->gro_id !=1){
                                                                                continue;
                                                                        }
                                                                }
                                                                if($userObject->use_group == 6 
                                                                || $userObject->use_group == 7
                                                                || $userObject->use_group == 8
                                                                || $userObject->use_group == 9
                                                                || $userObject->use_group == 10){
                                                                        if($groupArray->gro_id !=6 && $groupArray->gro_id !=7 && $groupArray->gro_id !=8 && $groupArray->gro_id !=9 && $groupArray->gro_id !=10){
                                                                                continue;
                                                                        } 
                                                                }
                                                                ?>
	                                                            <?php if($groupArray->gro_id == 4){ ?>
	                                                            <option value="<?php echo $groupArray->gro_id; ?>" <?php if($role_user == $groupArray->gro_id){echo 'selected="selected"';} ?> style="font-weight:bold; color:#F00;"><?php echo $groupArray->gro_name; ?></option>
	                                                            <?php }elseif($groupArray->gro_id == 3){ ?>
	                                                            <option value="<?php echo $groupArray->gro_id; ?>" <?php if($role_user == $groupArray->gro_id){echo 'selected="selected"';} ?> style="font-weight:bold; color:#009900;"><?php echo $groupArray->gro_name; ?></option>
	                                                            <?php }elseif($groupArray->gro_id == 2){ ?>
	                                                            <option value="<?php echo $groupArray->gro_id; ?>" <?php if($role_user == $groupArray->gro_id){echo 'selected="selected"';} ?> style="font-weight:bold; color:#06F;"><?php echo $groupArray->gro_name; ?></option>
	                                                            <?php }else{ ?>
	                                                            <option value="<?php echo $groupArray->gro_id; ?>" <?php if($role_user == $groupArray->gro_id){echo 'selected="selected"';} ?>><?php echo $groupArray->gro_name; ?></option>
	                                                            <?php } ?>
	                                                            <?php } ?>
	                                                        </select>
	                                                    </td>
	                                                </tr>
                                                    
	                                                <tr style="display:none;">
	                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('enddate_edit'); ?>:</td>
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
	                                                            <?php for($endyear = (int)date('Y'); $endyear < (int)date('Y')+50; $endyear++){ ?>
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
	                                                    <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> Người giới thiệu:</td>
	                                                    <td align="left">
                                                                <select name="parent_id">
                                                                    <?php 
                                                                                $ad = $m = $p1 = $p2 = $d1 = $d2 = 0;
                                                                        foreach ($coremember as $key=> $value){
                                                                                $sl = '';
                                                                            if($value->use_group == 12){
                                                                                if($ad == 0){
                                                                                    $op = '<option value="" disabled>---Core Admin---</option>';
                                                                                    echo $op;
                                                                                }
                                                                                $ad++;
                                                                            }
                                                                            if($value->use_group == 10){
                                                                                if($m == 0){
                                                                                    $op = '<option value="" disabled>---Core Member---</option>';
                                                                                    echo $op;
                                                                                }
                                                                                $m++;
                                                                            }
                                                                            if($value->use_group == 9){
                                                                                if($p1 == 0){
                                                                                    $op = '<option value="" disabled>---Partner 1---</option>';
                                                                                    echo $op;
                                                                                }
                                                                                $p1++;
                                                                            }
                                                                            if($value->use_group == 8){
                                                                                if($p2 == 0){
                                                                                    $op = '<option value="" disabled>---Partner 2---</option>';
                                                                                    echo $op;
                                                                                }
                                                                                $p2++;
                                                                            }
                                                                            if($value->use_group == 7){
                                                                                if($d1 == 0){
                                                                                    $op = '<option value="" disabled>---Developer 1---</option>';
                                                                                    echo $op;
                                                                                }
                                                                                $d1++;
                                                                            }
                                                                            if($value->use_group == 6){
                                                                                if($d2 == 0){
                                                                                    $op = '<option value="" disabled>---Developer 2---</option>';
                                                                                    echo $op;
                                                                                }
                                                                                $d2++;
                                                                            }
                                                                            if($value->use_id == $parent_id){$sl = 'selected';}
                                                                            echo '<option value="'.$value->use_id.'" '.$sl.'>'.$value->use_username.'</option>';
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                    <tr>
                                                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> Thuộc về:</td>
                                                        <td align="left">
                                                            <?php
                                                                if(isset($UserParent)) {
                                                                    echo $UserParent['use_fullname'];
                                                                }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> Affiliate Level:</td>
                                                        <td align="left">
                                                                <select name="affiliate_level">
                                                                    <option value="0">Vui lòng chọn</option>
                                                                    <?php if(isset($affiliatelevel) && !empty($affiliatelevel)) { ?>

                                                                        <?php foreach ($affiliatelevel as $iAff => $oAf) { ?>
                                                                            <?php if($oAf->id == $userObject->affiliate_level) { ?>
                                                                                <option value="<?=$oAf->id?>" selected><?=$oAf->name?></option>
                                                                            <?php } else { ?>
                                                                                <option value="<?=$oAf->id?>"><?=$oAf->name?></option>
                                                                            <?php } ?>
                                                                        <?php } ?>
                                                                    <?php } ?>
                                                                </select>
                                                            </td>
                                                        </tr>
	                                                <tr id="activeuser">
	                                                    <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('active_edit'); ?>:</td>
	                                                    <td align="left" style="padding-top:7px;">
	                                                        <input type="checkbox" name="active_user" id="active_user" value="1" <?php if($active_user == '1'){echo 'checked="checked"';} ?> <?php if($userLogined == true){echo 'readonly = "readonly"="readonly = "readonly""';} ?> />
	                                                    </td>
	                                                </tr>
                                                    </form>
                                                    <?php }else{ ?>
	                                                <tr class="success_post">
	                                                    <td colspan="2">
	                                                        <p class="text-center"><a href="<?php echo $_SESSION['previous_page']; ?>">Click vào đây để tiếp tục</a></p>
	                                                		<?php echo $this->lang->line('success_edit'); ?>
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
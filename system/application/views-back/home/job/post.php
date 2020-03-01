<?php $this->load->view('home/common/header'); ?>
    <div class="container">
    <div id="main">
<?php $this->load->view('home/common/left'); ?>

<?php /*?><script language="javascript" src="<?php echo base_url(); ?>templates/home/js/him.js"></script><?php */?>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<script language="javascript">show_left_menu('job');</script>

<!--BEGIN: LEFT-->

<?php
if($_SERVER['HTTP_REFERER']!=base_url()."job/post")
{
	$_SESSION['trangtruoc_tuyendung']=$_SERVER['HTTP_REFERER'];
}
?>
<div class="col-lg-9">
    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <div class="tile_modules tile_modules_blue">
                <div class="fl"></div>
                <div class="fc">
				<?php echo $this->lang->line('title_post'); ?>
                </div>
                <div class="fr"></div>
                </div>
            </td>
        </tr>
        <tr>
            <td valign="top" >
                <?php if($successPostJob == false){ ?>
                <div class="note_post">
                    <img src="<?php echo base_url(); ?>templates/home/images/note_post.gif" border="0" width="20" height="20" />&nbsp;
                    <b><font color="#FD5942"><?php echo $this->lang->line('note_help'); ?>:</font></b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <font color="#FF0000"><b>*</b></font>&nbsp;&nbsp;<?php echo $this->lang->line('must_input_help'); ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" />&nbsp;&nbsp;<?php echo $this->lang->line('input_help'); ?>
                </div>
                <?php } ?>
                <table width="100%" class="post_main" cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                        <td colspan="2" height="20" class="post_top"></td>
                    </tr>
                    <?php if($successPostJob == false){ ?>
                    <form name="frmPostJob" method="post">
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('title_post_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($title_job)){echo $title_job;} ?>" name="title_job" id="title_job" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_job',1)" onblur="ChangeStyle('title_job',2)" />
                            <?php echo form_error('title_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td height="7" colspan="2"></td>
                    </tr>
                    <tr>
                        <td height="20" class="seperate_line"><?php echo $this->lang->line('require_title_post'); ?></td>
                        <td height="20" class="seperate_line"></td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('field_post'); ?>:</td>
                        <td>
                            <select name="field_job" id="field_job" class="selectcategory_formpost">
                            <option value="0" selected="selected">Chọn ngành nghề</option>
                                <?php foreach($field as $fieldArray){ ?>
                                <?php if(isset($field_job) && $field_job == $fieldArray->fie_id){ ?>
                                <option value="<?php echo $fieldArray->fie_id; ?>" selected="selected"><?php echo $fieldArray->fie_name; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $fieldArray->fie_id; ?>"><?php echo $fieldArray->fie_name; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <span>
                            hoặc điền
                            </span>
                                <input type="text"  name="nganhnghe_dien" id="nganhnghe_dien" maxlength="120" class="input_formpost" style="width:130px;"/>
                            <?php echo form_error('field_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('position_post'); ?>:</td>
                        <td>
                        
                            <input type="text" value="<?php if(isset($position_job)){echo $position_job;} ?>" name="position_job" id="position_job" maxlength="120" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('position_job',1)" onblur="ChangeStyle('position_job',2)" />
                            <?php echo form_error('position_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('level_post'); ?>:</td>
                        <td>
                         <select name="yeu_cau_trinh_Do" id="yeu_cau_trinh_Do" class="selectcategory_formpost">
                            <option value="0" >Bạn hãy chọn</option>
                             <option value="Tốt nghiệp đại học tại chức trở lên" >Tốt nghiệp đại học tại chức trở lên</option>
                                 <option value="Tốt nghiệp cấp 2  trở lên" >Tốt nghiệp cấp 2  trở lên</option>
                                      <option value="Tốt nghiệp cấp 3  trở lên" >Tốt nghiệp cấp 3 trở lên</option>
                                            <option value="Tốt nghiệp trung cấp  trở lên" >Tốt nghiệp trung cấp trở lên</option>
                                                 <option value="Tốt nghiệp cao đẳng  trở lên" >Tốt nghiệp cao đẳng trở lên</option>
                                                  <option value="Tốt nghiệp đại học  trở lên" >Tốt nghiệp đại học trở lên</option>
                                                     <option value="Tốt nghiệp master  trở lên" >Tốt nghiệp master trở lên</option>
                                                        <option value="Tiến sỹ" >Tiến sỹ</option>
                                                         <option value="Kỹ sư" >Kỹ sư</option>
                          </select>
                          <span>
                          hoặc điền
                          </span>
                            <input type="text" value="<?php if(isset($level_job)){echo $level_job;} ?>" name="level_job" id="level_job" maxlength="120" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('level_job',1)" onblur="ChangeStyle('level_job',2)" style="width:130px;" />
                            <?php echo form_error('level_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('foreign_language_post'); ?>:</td>
                        <td>
       						<div style="clear:both; padding-top:10px;">
                            </div>                         
                                   <textarea name="foreign_language_job" id="foreign_language_job" rows="3" class="textarea_post" cols="45"  style="width:300px;"  /></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('computer_post'); ?>:</td>
                        <td>
                            <div style="clear:both ; padding-top:10px;">
                            </div>
                        
                              <textarea name="computer_job" id="computer_job" rows="3" class="textarea_post" cols="45"  style="width:300px;"  /></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('age_post'); ?>:</td>
                        <td>
                            <span class="age_post"><?php echo $this->lang->line('from_post'); ?></span>
                            <select name="age1_job" id="age1_job" class="selectage_formpost">
                                <?php for($age1 = 15; $age1 <= 60; $age1++){ ?>
                                <?php if(isset($age1_job) && $age1_job == $age1){ ?>
                                <option value="<?php echo $age1; ?>" selected="selected"><?php echo $age1; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $age1; ?>"><?php echo $age1; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <span class="age_post"><?php echo $this->lang->line('to_post'); ?></span>
                            <select name="age2_job" id="age2_job" class="selectage_formpost">
                                <?php for($age2 = 15; $age2 <= 60; $age2++){ ?>
                                <?php if(isset($age2_job) && $age2_job == $age2){ ?>
                                <option value="<?php echo $age2; ?>" selected="selected"><?php echo $age2; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $age2; ?>"><?php echo $age2; ?></option>
                                <?php } ?>
                                <?php } ?>

                            </select>
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('age_tip_help_post') ?>',410,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <?php echo form_error('age1_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('sex_post'); ?>:</td>
                        <td>
                            <select name="sex_job" id="sex_job" class="selectsex_formpost">
                                <option value="2" <?php if(isset($sex_job) && $sex_job == '2'){echo 'selected="selected"';}elseif(!isset($sex_job)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('all_sex_post'); ?></option>
                                <option value="1" <?php if(isset($sex_job) && $sex_job == '1'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('male_post'); ?></option>
                                <option value="0" <?php if(isset($sex_job) && $sex_job == '0'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('female_post'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('require_job_post'); ?>:</td>
                        <td>
                       <div >
                       </div>
       
							<div style="clear:both; padding-top:10px;">
                            </div>                       
                              <textarea name="require_job" id="require_job" rows="3" class="textarea_post" cols="45"  style="width:300px;"  /></textarea>
						
                            <?php echo form_error('require_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font>Kỹ năng kinh nghiệm:</td>
                        <td>
                        <div style="clear:both; padding-top:10px;">
                        </div>                    
                          <textarea name="experience_job" id="experience_job" rows="3" class="textarea_post" cols="45"  style="width:300px;"  /></textarea>
                           
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('province_post'); ?>:</td>
                        <td>
                            <select name="province_job" id="province_job" class="selectprovince_formpost">
                                <?php foreach($province as $provinceArray){ ?>
                                <?php if(isset($province_job) && $province_job == $provinceArray->pre_id){ ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>" selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <?php echo form_error('province_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('time_job_post'); ?>:</td>
                        <td>
                            <select name="time_job" id="time_job" class="selecttime_formpost">
                                <option value="1" > Bán thời gian </option>
                                <option value="2" >Toàn thời gian</option>
                                <option value="3" >Hành chính</option>
                             	<option value="4" >Buổi sáng</option>
                              	<option value="5" >Buổi trưa</option>
                                <option value="6" >Buổi tối</option>
                                <option value="7" >Thời gian khác</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('salary_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($salary_job)){echo $salary_job;} ?>" name="salary_job" id="salary_job" maxlength="8" class="inputsalary_formpost" onkeyup="FormatCurrency('DivShowSalary','currency_job',this.value); BlockChar(this,'NotNumbers');" onfocus="ChangeStyle('salary_job',1)" onblur="ChangeStyle('salary_job',2)" />
                            <select name="currency_job" id="currency_job" class="selectcurrency_formpost" onchange="FormatCurrency('DivShowSalary','currency_job',document.getElementById('salary_job').value)">
                                <option value="VND" <?php if(isset($currency_job) && $currency_job == 'VND'){echo 'selected="selected"';}elseif(!isset($currency_job)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('vnd_post'); ?></option>
                                <option value="USD" <?php if(isset($currency_job) && $currency_job == 'USD'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('usd_post'); ?></option>
                            </select>
                            <font size="+1">/</font>
                            <select name="datesalary_job" id="datesalary_job" class="selectsalary_formpost">
                                <option value="1" <?php if(isset($datesalary_job) && $datesalary_job == '1'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('day_post'); ?></option>
                                <option value="2" <?php if(isset($datesalary_job) && $datesalary_job == '2'){echo 'selected="selected"';}elseif(!isset($datesalary_job)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('month_post'); ?></option>
                                <option value="3" <?php if(isset($datesalary_job) && $datesalary_job == '3'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('year_post'); ?></option>
                            </select>
                            <span class="div_helppost">(<?php echo $this->lang->line('only_input_number_help'); ?>)</span>
                            <div id="DivShowSalary"></div>
                            <?php echo form_error('salary_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('try_time_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($try_job)){echo $try_job;} ?>" name="try_job" id="try_job" maxlength="3" class="inputtry_formpost" onkeyup="BlockChar(this,'NotNumbers');" onfocus="ChangeStyle('try_job',1)" onblur="ChangeStyle('try_job',2)" />
                            <select name="datetry_job" id="datetry_job" class="selectdatetry_formpost">
                                <option value="1" <?php if(isset($datetry_job) && $datetry_job == '1'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('day_post'); ?></option>
                                <option value="2" <?php if(isset($datetry_job) && $datetry_job == '2'){echo 'selected="selected"';}elseif(!isset($datetry_job)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('month_post'); ?></option>
                                <option value="3" <?php if(isset($datetry_job) && $datetry_job == '3'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('year_post'); ?></option>
                            </select>
                            <span class="div_helppost">(<?php echo $this->lang->line('only_input_number_help'); ?>)</span>
                            <?php echo form_error('try_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('interest_post'); ?>:</td>
                        <td align="left">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <textarea name="interest_job" id="interest_job" rows="3" class="textarea_post" style="width:300px"  cols="45" /> </textarea>
                                        <?php echo form_error('interest_job'); ?>
                                    </td>
                                    <td style="padding-top:7px;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('quantity_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($quantity_job)){echo $quantity_job;} ?>" name="quantity_job" id="quantity_job" maxlength="5" class="inputquantity_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('quantity_job',1)" onblur="ChangeStyle('quantity_job',2)" />
                            <span class="quantity_job"> <?php echo $this->lang->line('person_post'); ?></span>
                            <span class="div_helppost">(<?php echo $this->lang->line('only_input_number_help'); ?>)</span>
                            <?php echo form_error('quantity_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('record_post'); ?>:</td>
                        <td align="left">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
                                        <textarea name="record_job" id="record_job" rows="3" class="textarea_post" style="width:300px;"  cols="45" /></textarea>
                                        <?php echo form_error('record_job'); ?>
                                    </td>
                                    <td style="padding-top:7px;"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('detail_post'); ?>:</td>
                        <td style="padding-top:7px;">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>
									
                                    
                                  <textarea name="txtContent" id="txtContent" rows="5" class="textarea_post" cols="45"  style="width:350px;"  /></textarea>
                                  
                                    </td>
                                    <td style="padding-top:7px;">
                                        <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('detail_tip_help') ?>',400,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="7" colspan="2"></td>
                    </tr>
                    <tr>
                        <td height="20" class="seperate_line"><?php echo $this->lang->line('info_title_post'); ?></td>
                        <td height="20" class="seperate_line"></td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('name_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($name_job)){echo $name_job;} ?>" name="name_job" id="name_job" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostJob','name_job');" onfocus="ChangeStyle('name_job',1)" onblur="ChangeStyle('name_job',2)" />
                            <?php echo form_error('name_job'); ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="150" valign="top" class="list_post">Giới thiệu :</td>
                        <td>
                        <div style=" clear:both; padding-top:10px;">
                        </div>
                     
                           </textarea>
                             <textarea name="gioi_thieu_nha_tuyen_dung" id="gioi_thieu_nha_tuyen_dung" rows="3" class="textarea_post" cols="45"  style="width:300px;"  /></textarea>
                        </td>
                    </tr>
                    
                    
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($address_job)){echo $address_job;} ?>" name="address_job" id="address_job" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostJob','address_job');" onfocus="ChangeStyle('address_job',1)" onblur="ChangeStyle('address_job',2)" />
                            <?php echo form_error('address_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_post'); ?>:</td>
                        <td>
                            <img src="<?php echo base_url(); ?>templates/home/images/phone_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($phone_job)){echo $phone_job;} ?>" name="phone_job" id="phone_job" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phone_job',1)" onblur="ChangeStyle('phone_job',2)" />
                            <b>-</b>
                            <img src="<?php echo base_url(); ?>templates/home/images/mobile_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($mobile_job)){echo $mobile_job;} ?>" name="mobile_job" id="mobile_job" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobile_job',1)" onblur="ChangeStyle('mobile_job',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help') ?>',225,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>)</span>
                            <?php echo form_error('phone_job'); ?>
                            <?php echo form_error('mobile_job'); ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="150" valign="top" class="list_post">Fax :</td>
                        <td>
                          
                            <input type="text" name="fax_job_nha_tuyen_dung" id="fax_job_nha_tuyen_dung" maxlength="50"  class="input_formpost" />
                           
                        
                        </td>
                    </tr>
                    
                    
                    
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($email_job)){echo $email_job;} ?>" name="email_job" id="email_job" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_job',1)" onblur="ChangeStyle('email_job',2)" />
                            <?php echo form_error('email_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('website_post'); ?>:</td>
                        <td>
                            <input type="text" name="website_job" id="website_job" value="<?php if(isset($website_job)){echo $website_job;} ?>" maxlength="100" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('website_job',1)" onblur="ChangeStyle('website_job',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('website_tip_help') ?>',165,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <?php echo form_error('website_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td height="7" colspan="2"></td>
                    </tr>
                    <tr>
                        <td height="20" class="seperate_line"><?php echo $this->lang->line('info_contact_title_post'); ?></td>
                        <td height="20" class="seperate_line"></td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('name_contact_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($namecontact_job)){echo $namecontact_job;} ?>" name="namecontact_job" id="namecontact_job" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostJob','namecontact_job');" onfocus="ChangeStyle('namecontact_job',1)" onblur="ChangeStyle('namecontact_job',2)" />
                            <?php echo form_error('namecontact_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_contact_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($addresscontact_job)){echo $addresscontact_job;} ?>" name="addresscontact_job" id="addresscontact_job" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostJob','addresscontact_job');" onfocus="ChangeStyle('addresscontact_job',1)" onblur="ChangeStyle('addresscontact_job',2)" />
                            <?php echo form_error('addresscontact_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_contact_post'); ?>:</td>
                        <td>
                            <img src="<?php echo base_url(); ?>templates/home/images/phone_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($phonecontact_job)){echo $phonecontact_job;} ?>" name="phonecontact_job" id="phonecontact_job" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phonecontact_job',1)" onblur="ChangeStyle('phonecontact_job',2)" />
                            <b>-</b>
                            <img src="<?php echo base_url(); ?>templates/home/images/mobile_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($mobilecontact_job)){echo $mobilecontact_job;} ?>" name="mobilecontact_job" id="mobilecontact_job" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobilecontact_job',1)" onblur="ChangeStyle('mobilecontact_job',2)" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help') ?>',225,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>)</span>
                            <?php echo form_error('phonecontact_job'); ?>
                            <?php echo form_error('mobilecontact_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_contact_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($emailcontact_job)){echo $emailcontact_job;} ?>" name="emailcontact_job" id="emailcontact_job" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('emailcontact_job',1)" onblur="ChangeStyle('emailcontact_job',2)" />
                            <?php echo form_error('emailcontact_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('yahoo_contact_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($yahoo_job)){echo $yahoo_job;} ?>" name="yahoo_job" id="yahoo_job" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo_job',1)" onblur="ChangeStyle('yahoo_job',2)" />
                            <?php echo form_error('yahoo_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('skype_contact_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($skype_job)){echo $skype_job;} ?>" name="skype_job" id="skype_job" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_job',1)" onblur="ChangeStyle('skype_job',2)" />
                            <?php echo form_error('skype_job'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('best_contact_post'); ?>:</td>
                        <td>
                        <input name="checkbox_lienhetructiep" type="checkbox" id="checkbox_lienhetructiep"  /><?php echo $this->lang->line('best_contact_1_contact_post'); ?>
                          <input name="checkbox_lienhedienthoai" type="checkbox" id="checkbox_lienhedienthoai"  /><?php echo $this->lang->line('best_contact_2_contact_post'); ?>
                          <input name="checkbox_Email" type="checkbox" id="checkbox_Email"  />
                          <?php echo $this->lang->line('best_contact_3_contact_post'); ?>
                            <input name="checkbox_Chatyahoo_sype" type="checkbox" id="checkbox_Chatyahoo_sype"  />
                            <?php echo $this->lang->line('best_contact_4_contact_post'); ?>
                             <input name="checkbox_website" type="checkbox" id="checkbox_website"  />
                             <?php echo $this->lang->line('best_contact_5_contact_post'); ?>
                             
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('enddate_post'); ?>:</td>
                        <td>
                            <select name="endday_job" id="endday_job" class="selectdate_formpost">
                                <?php for($endday = 1; $endday <= 31; $endday++){ ?>
                                <?php if(isset($endday_job) && (int)$endday_job == $endday){ ?>
                                <option value="<?php echo $endday; ?>" selected="selected"><?php echo $endday; ?></option>
                                <?php }elseif($endday == (int)date('d') && $endday_job == ''){ ?>
                                <option value="<?php echo $endday; ?>" selected="selected"><?php echo $endday; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $endday; ?>"><?php echo $endday; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <b>-</b>
                            <select name="endmonth_job" id="endmonth_job" class="selectdate_formpost">
                                <?php for($endmonth = 1; $endmonth <= 12; $endmonth++){ ?>
                                <?php if(isset($endmonth_job) && (int)$endmonth_job == $endmonth){ ?>
                                <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                                <?php }elseif($endmonth == $nextMonth && $endmonth_job == ''){ ?>
                                <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $endmonth; ?>"><?php echo $endmonth; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <b>-</b>
                            <select name="endyear_job" id="endyear_job" class="selectdate_formpost">
                                <?php for($endyear = (int)date('Y'); $endyear < (int)date('Y')+2; $endyear++){ ?>
                                <?php if(isset($endyear_job) && (int)$endyear_job == $endyear){ ?>
                                <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                                <?php }elseif($endyear == $nextYear && $endyear_job == ''){ ?>
                                <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $endyear; ?>"><?php echo $endyear; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('enddate_tip_help') ?>',235,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('enddate_help'); ?>)</span>
                            <?php echo form_error('endday_job'); ?>
                        </td>
                    </tr>
                    <?php if(isset($imageCaptchaPostJob)){ ?>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                        <td align="left" style="padding-top:7px;">
                            <img src="<?php echo $imageCaptchaPostJob; ?>" width="151" height="30" /><br />
                            <input type="text" name="captcha_job" id="captcha_job" value="" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_job',1);" onblur="ChangeStyle('captcha_job',2);" onKeyPress="return submitenter(this,event)" />
                            <input type="hidden" id="captcha" name="captcha" value="<?php echo $captcha;?>"/>
                            <input type="hidden" id="isPostProduct" name="isPostProduct" value=""/>
                            <?php echo form_error('captcha_job'); ?>
                        </td>
                    </tr>
					<?php } ?>
                    <tr>
                        <td width="150"></td>
                        <td height="30" valign="bottom" align="center">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td colspan="3" height="25"></td>
                                </tr>
                                <tr>
                                    <td>
                                    <SCRIPT TYPE="text/javascript">
<!--
function submitenter(myfield,e)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;

if (keycode == 13)
   {
   CheckInput_PostJob();
   return false;
   }
else
   return true;
}
//-->
</SCRIPT>


                                    <input type="hidden"  value="" id="checkInsertData" name="checkInsertData" />
                                    
                                    <input type="button" onclick="CheckInput_PostJob();" name="submit_postjob" value="<?php echo $this->lang->line('button_agree_post'); ?>" class="button_form" /></td>
                                    <td width="15"></td>
                                    <td><input type="reset" name="reset_postjob" value="<?php echo $this->lang->line('button_reset_post'); ?>" class="button_form" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </form>
                    <?php }else{ ?>
                    <tr>
                        <td class="success_post">
                            <p class="text-center"><a href="<?php echo $_SESSION['trangtruoc_tuyendung']; ?>">Click vào đây để tiếp tục</a></p>
                            <?php echo $this->lang->line('success_post'); ?>
						</td>
					</tr>
                    <?php } ?>
                    <tr>
                        <td colspan="2" height="30" class="post_bottom"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td>
            	<div class="border_bottom_blue">
                	<div class="fl"></div>
                    <div class="fr"></div>
                </div>
            </td>
        </tr>
    </table>
</div>
</div>
    </div>
<!--END LEFT-->
<?php $this->load->view('home/common/footer'); ?>
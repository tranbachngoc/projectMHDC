<?php $this->load->view('home/common/header'); ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/him.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<!--BEGIN: LEFT-->
<td width="100%" valign="top" style="padding:10px 20px 10px 0;">
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
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
            <td style="border-left:1px solid #62c7fd; border-right:1px solid #62c7fd;" valign="top" >
                <?php if($successPostAds == false){ ?>
                <div class="note_post">
                    <img src="<?php echo base_url(); ?>templates/home/images/note_post.gif" border="0" width="20" height="20" />&nbsp;
                    <b><font color="#FD5942"><?php echo $this->lang->line('note_help'); ?>:</font></b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <font color="#FF0000"><b>*</b></font>&nbsp;&nbsp;<?php echo $this->lang->line('must_input_help'); ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" />&nbsp;&nbsp;<?php echo $this->lang->line('input_help'); ?>
                </div>
                <?php } ?>
                <table width="585" class="post_main" cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                        <td colspan="2" height="20" class="post_top"></td>
                    </tr>
                    <?php if($successPostAds == false){ ?>
                    <form name="frmPostAds" method="post" enctype="multipart/form-data">
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('title_post_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($title_ads)){echo $title_ads;} ?>" name="title_ads" id="title_ads" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_ads',1)" onblur="ChangeStyle('title_ads',2)" />
                            <?php echo form_error('title_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('descr_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($descr_ads)){echo $descr_ads;} ?>" name="descr_ads" id="descr_ads" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('descr_ads',1)" onblur="ChangeStyle('descr_ads',2)" />
                            <?php echo form_error('descr_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('province_post'); ?>:</td>
                        <td>
                            <select name="province_ads" id="province_ads" class="selectprovince_formpost">
                                <?php foreach($province as $provinceArray){ ?>
                                <?php if(isset($province_ads) && $province_ads == $provinceArray->pre_id){ ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>" selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <?php echo form_error('province_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('category_post'); ?>:</td>
                        <td>
                            <select name="category_ads" id="category_ads" class="selectcategory_formpost">
                                <?php foreach($category as $categoryArray){ ?>
                                <?php if(isset($category_ads) && $category_ads == $categoryArray->cat_id){ ?>
                                <option value="<?php echo $categoryArray->cat_id; ?>" selected="selected"><?php echo $categoryArray->cat_name; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $categoryArray->cat_id; ?>"><?php echo $categoryArray->cat_name; ?></option>
                                <?php } ?>
                                <?php } ?>
                            </select>
                            <?php echo form_error('category_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('enddate_post'); ?>:</td>
                        <td>
                            <select name="day_ads" id="day_ads" class="selectdate_formpost">
                                <?php for($endday = 1; $endday <= 31; $endday++){ ?>
                                <?php if(isset($day_ads) && (int)$day_ads == $endday){ ?>
                                <option value="<?php echo $endday; ?>" selected="selected"><?php echo $endday; ?></option>
                                <?php }elseif($endday == (int)date('d') && $day_ads == ''){ ?>
                                <option value="<?php echo $endday; ?>" selected="selected"><?php echo $endday; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $endday; ?>"><?php echo $endday; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <b>-</b>
                            <select name="month_ads" id="month_ads" class="selectdate_formpost">
                                <?php for($endmonth = 1; $endmonth <= 12; $endmonth++){ ?>
                                <?php if(isset($month_ads) && (int)$month_ads == $endmonth){ ?>
                                <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                                <?php }elseif($endmonth == $nextMonth && $month_ads == ''){ ?>
                                <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $endmonth; ?>"><?php echo $endmonth; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <b>-</b>
                            <select name="year_ads" id="year_ads" class="selectdate_formpost">
                                <?php for($endyear = (int)date('Y'); $endyear < (int)date('Y')+2; $endyear++){ ?>
                                <?php if(isset($year_ads) && (int)$year_ads == $endyear){ ?>
                                <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                                <?php }elseif($endyear == $nextYear && $year_ads == ''){ ?>
                                <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                                <?php }else{ ?>
                                <option value="<?php echo $endyear; ?>"><?php echo $endyear; ?></option>
                                <?php } ?>
								<?php } ?>
                            </select>
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('enddate_tip_help') ?>',235,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('enddate_help'); ?>)</span>
                            <?php echo form_error('day_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('detail_post'); ?>:</td>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding-top:7px;">
                                        <?php $this->load->view('home/common/editor'); ?>
                                        <?php echo form_error('txtContent'); ?>
                                    </td>
                                    <td style="padding-top:7px;">
                                        <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('detail_tip_help') ?>',400,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('image_post'); ?>:</td>
                        <td>
                            <input type="file" name="image_ads" id="image_ads" class="inputimage_formpost" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('image_tip_help') ?>',285,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('image_help'); ?>)</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('poster_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($fullname_ads)){echo $fullname_ads;} ?>" name="fullname_ads" id="fullname_ads" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostAds','fullname_ads');" onfocus="ChangeStyle('fullname_ads',1)" onblur="ChangeStyle('fullname_ads',2)" />
                            <?php echo form_error('fullname_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($address_ads)){echo $address_ads;} ?>" name="address_ads" id="address_ads" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostAds','address_ads');" onfocus="ChangeStyle('address_ads',1)" onblur="ChangeStyle('address_ads',2)" />
                            <?php echo form_error('address_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_post'); ?>:</td>
                        <td>
                            <img src="<?php echo base_url(); ?>templates/home/images/phone_1.gif" border="0" />
                           
                            <input type="text" value="<?php if(isset($mobile_ads)){echo $mobile_ads;} ?>" name="mobile_ads" id="mobile_ads" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobile_ads',1)" onblur="ChangeStyle('mobile_ads',2)" />
                             <b>-</b>
                              <img src="<?php echo base_url(); ?>templates/home/images/mobile_1.gif" border="0" />
                            
                            <input type="text" value="<?php if(isset($phone_ads)){echo $phone_ads;} ?>" name="phone_ads" id="phone_ads" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phone_ads',1)" onblur="ChangeStyle('phone_ads',2)" />
                           
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help') ?>',225,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>)</span>
                            <?php echo form_error('phone_ads'); ?>
                            <?php echo form_error('mobile_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($email_ads)){echo $email_ads;} ?>" name="email_ads" id="email_ads" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_ads',1)" onblur="ChangeStyle('email_ads',2)" />
                            <?php echo form_error('email_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('yahoo_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($yahoo_ads)){echo $yahoo_ads;} ?>" name="yahoo_ads" id="yahoo_ads" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo_ads',1)" onblur="ChangeStyle('yahoo_ads',2)" />
                            <?php echo form_error('yahoo_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('skype_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($skype_ads)){echo $skype_ads;} ?>" name="skype_ads" id="skype_ads" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_ads',1)" onblur="ChangeStyle('skype_ads',2)" />
                            <?php echo form_error('skype_ads'); ?>
                        </td>
                    </tr>
                    <?php if(isset($imageCaptchaPostAds)){ ?>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                        <td align="left" style="padding-top:7px;">
                            <img src="<?php echo $imageCaptchaPostAds; ?>" width="151" height="30" /><br />
                            <input type="text" name="captcha_ads" id="captcha_ads" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_ads',1);" onblur="ChangeStyle('captcha_ads',2);" />
                            <input type="hidden" id="captcha" name="captcha" value="<?php echo $captcha;?>"/>
                            <input type="hidden" id="isPostAds" name="isPostAds" value=""/>
                            <?php echo form_error('captcha_ads'); ?>
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
                                    <td><input type="button" onclick="CheckInput_PostAds();" name="submit_postads" value="<?php echo $this->lang->line('button_agree_post'); ?>" class="button_form" /></td>
                                    <td width="15"></td>
                                    <td><input type="reset" name="reset_postads" value="<?php echo $this->lang->line('button_reset_post'); ?>" class="button_form" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </form>
                    <?php }else{ ?>
                    <tr>
                        <td class="success_post">
                            <p class="text-center"><a href="<?php echo base_url(); ?>">Click vào đây để tiếp tục</a></p>
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
</td>
<!--END LEFT-->
<?php $this->load->view('home/common/info'); ?>
<?php $this->load->view('home/common/footer'); ?>
<?php $this->load->view('home/common/header'); ?>
    <div class="container">
    <div id="main">
<?php $this->load->view('home/common/left'); ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/him.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<script language="javascript" >show_left_menu('raovat'); </script>
<!--BEGIN: LEFT-->
<?php
if($_SERVER['HTTP_REFERER']!=base_url()."raovat/post")
{
	$_SESSION['trangtruoc_raovat']=$_SERVER['HTTP_REFERER'];
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
             <td class="k_fixpaddingie"  valign="top" >
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
                <table width="770" class="post_main" cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                        <td colspan="2" height="20" class="post_top"></td>
                    </tr>
                    <?php if($successPostAds == false){ ?>
                    <form name="frmPostAds" method="post" enctype="multipart/form-data">
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('category_post'); ?>:</td>
                        <td>
                        
                        <div id="hoidap_0" style="float: left; display: inline;">
                                	<select id="hd_select_0" class="form_control_hoidap_select" onclick="check_postCategoryRaovat(this.value,0,'<?php echo base_url(); ?>');" size="14">
                                    <?php if(isset($catlevel0)){
										foreach($catlevel0 as $item){
									?>
                                    <option value="<?php echo $item->cat_id;?>"><?php echo $item->cat_name;?><?php if($item->child_count >0){echo ' >';}?></option>
                                    <?php }}?>
                                    </select>
                                </div>
                                     <div id="hoidap_1" style="float: left; display: none; margin-left: 15px;">
                                
                                </div>
                                <div id="hoidap_2" style="float: left; display: none; margin-left: 15px;">
                                
                                </div>
                                <input type="hidden" id="hd_category_id" name="hd_category_id" value=""/>
                                
                            <?php echo form_error('category_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('title_post_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($title_ads)){echo $title_ads;} ?>" name="title_ads" id="title_ads" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_ads',1)" onblur="ChangeStyle('title_ads',2)"  onkeypress="return submitenter(this,event)"/>
                            <?php echo form_error('title_ads'); ?>
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="150" valign="top" class="list_post"> Loại tin:</td>
                        <td>
                           <select name="loai_tin" id="loai_tin" class="selectprovince_formpost">
                            <option value="0" >Tin bán</option>
                            <option value="1">Tin mua</option>
                          </select>
                            </td>
                    </tr>
                    
                    
                    
                    <tr style="display:none">
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"></font> <?php echo $this->lang->line('descr_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($descr_ads)){echo $descr_ads;} ?>" name="descr_ads" id="descr_ads" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('descr_ads',1)" onblur="ChangeStyle('descr_ads',2)" style="float:left;"  onkeypress="return submitenter(this,event)"/><div class="gioihankytu">(Không quá 35 ký tự)</div>
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
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('enddate_post'); ?>:</td>
                        <td  height="35">
                           
                             <input type="text" name="DivEnddate" id="DivEnddate" value="<?php echo (int)date('d'); ?>-<?php echo $nextMonth;  ?>-<?php echo $nextYear; ?>" readonly="readonly" class="set_enddate" />
                      
                            <script type="text/javascript">
                                jQuery(function() {
                                                jQuery("#DivEnddate").datepicker({showOn: 'button',
                                                buttonImage: '<?php echo base_url(); ?>templates/home/images/calendar.gif',
                                                buttonImageOnly: true,
                                                buttonText: '<?php echo $this->lang->line('set_enddate_tip'); ?>',
                                                dateFormat: 'dd-mm-yy',
                                                minDate: new Date(),
                                                maxDate: '+6m',
                                                onClose: function(){
                                                   jQuery("#ngay_ket_thuc").val(document.getElementById('DivEnddate').value);
                                                    }

                                                });
			                                 });
                            </script>
                            
                      
                            <link type="text/css" href="<?php echo base_url(); ?>templates/home/css/datepicker.css" rel="stylesheet" />	
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/ajax.js"></script>
                          
                            <input type="hidden" value="<?php echo (int)date('d'); ?>-<?php echo $nextMonth;  ?>-<?php echo $nextYear; ?>" id="ngay_ket_thuc" name="ngay_ket_thuc" />
                            
                            
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('detail_post'); ?>:</td>
                        <td>
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="padding-top:7px;">
                                  
                                      <?php $this->load->view('admin/common/tinymce'); ?>                                      
                                <textarea name="txtContent" id="txtContent" >
                                </textarea>
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
                             <input type="button"  onclick="resetBrowesIimgQ('image_ads');"  value="Hủy" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('image_tip_help') ?>',285,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(Size < 512 KB)</span>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('poster_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($fullname_ads)){echo $fullname_ads;} ?>" name="fullname_ads" id="fullname_ads" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostAds','fullname_ads');" onfocus="ChangeStyle('fullname_ads',1)" onblur="ChangeStyle('fullname_ads',2)" onkeypress="return submitenter(this,event)" />
                            <?php echo form_error('fullname_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($address_ads)){echo $address_ads;} ?>" name="address_ads" id="address_ads" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostAds','address_ads');" onfocus="ChangeStyle('address_ads',1)" onblur="ChangeStyle('address_ads',2)" onkeypress="return submitenter(this,event)" />
                            <?php echo form_error('address_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_post'); ?>:</td>
                        <td>
                          
                            <img src="<?php echo base_url(); ?>templates/home/images/mobile_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($mobile_ads)){echo $mobile_ads;} ?>" name="mobile_ads" id="mobile_ads" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobile_ads',1)" onblur="ChangeStyle('mobile_ads',2)" onkeypress="return submitenter(this,event)" />
                              <b>-</b>
                              <img src="<?php echo base_url(); ?>templates/home/images/phone_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($phone_ads)){echo $phone_ads;} ?>" name="phone_ads" id="phone_ads" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phone_ads',1)" onblur="ChangeStyle('phone_ads',2)" onkeypress="return submitenter(this,event)" />
                          
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help') ?>',225,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('phone_help'); ?>)</span>
                            <?php echo form_error('phone_ads'); ?>
                            <?php echo form_error('mobile_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($email_ads)){echo $email_ads;} ?>" name="email_ads" id="email_ads" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_ads',1)" onblur="ChangeStyle('email_ads',2)" onkeypress="return submitenter(this,event)" />
                            <?php echo form_error('email_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('yahoo_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($yahoo_ads)){echo $yahoo_ads;} ?>" name="yahoo_ads" id="yahoo_ads" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo_ads',1)" onblur="ChangeStyle('yahoo_ads',2)"  onkeypress="return submitenter(this,event)" />
                            <?php echo form_error('yahoo_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('skype_post'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($skype_ads)){echo $skype_ads;} ?>" name="skype_ads" id="skype_ads" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_ads',1)" onblur="ChangeStyle('skype_ads',2)" onkeypress="return submitenter(this,event)" />
                            <?php echo form_error('skype_ads'); ?>
                        </td>
                    </tr>
                    <?php if(isset($imageCaptchaPostAds)){ ?>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                        <td align="left" style="padding-top:7px;">
                            <img src="<?php echo $imageCaptchaPostAds; ?>" width="151" height="30" /><br />
                            <input type="text" name="captcha_ads" id="captcha_ads" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_ads',1);" onblur="ChangeStyle('captcha_ads',2);" onkeypress="return submitenter(this,event)" />
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
									   CheckInput_PostAds();
									   return false;
									   }
									else
									   return true;
									}
									//-->
									</SCRIPT>
                                    
                                    <input type="button" onclick="CheckInput_PostAds();" name="submit_postads" value="<?php echo $this->lang->line('button_agree_post'); ?>" class="button_form" onkeypress="return submitenter(this,event)" /></td>
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
                            <p class="text-center"><a href="<?php echo $_SESSION['trangtruoc_raovat']; ?>">Click vào đây để tiếp tục</a></p>
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

    </table>
</div>
</div>
</div>

<?php $this->load->view('home/common/footer'); ?>
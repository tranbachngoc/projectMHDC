<?php $this->load->view('home/common/header'); ?>
    <div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/him.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<!--BEGIN: RIGHT-->
<div class="col-lg-9">
    <table class="table table-bordered " width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
            	
                <div class="tile_modules tile_modules_blue">
                <div class="fl"></div>
                <div class="fc">
				<?php echo $this->lang->line('title_ads_edit'); ?>
                </div>
                <div class="fr"></div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="k_fixpaddingie"   valign="top" >
                
                <table class="post_main" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td colspan="2" height="35" class="post_top"></td>
                    </tr>
                    <?php if($successEditAdsAccount == false){ ?>
                    <form name="frmEditAds" method="post" enctype="multipart/form-data">
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('category_ads_edit'); ?>:</td>
                        <td>
                          
                          <div class="viewDatatNone" style=" padding-top:14px; width:572px;">
                          <div id="hoidap_0" style="float: left; display: inline;">
                         
                                	<select id="hd_select_0" class="form_control_hoidap_select" onclick="check_postCategoryRaovat(this.value,0,'<?php echo base_url(); ?>');" size="14"> 
                                    <?php if(isset($catlevel0)){
										foreach($catlevel0 as $item){
									?>
                                   
                                    <?php if(isset($cat_getcategory0)) { ?>
                                    	  <?php  if($category_ads == $item->cat_id){ ?>                              		
                                    <option value="<?php echo $item->cat_id; ?>" selected="selected" ><?php echo $item->cat_name; ?></option                             
                                ><?php }else { ?>
                                  <option value="<?php echo $item->cat_id; ?>" selected= ><?php echo $item->cat_name; ?></option >
                                <?php
								}?>
                                    
									<?php
									}
									else
									{ ?>
                                       <?php  if( $cat_parent_parent_0 -> parent_id == $item->cat_id){ ?>
                              
                                    <option value="<?php echo $item->cat_id; ?>" selected="selected" ><?php echo $item->cat_name; ?></option                             
                                ><?php }else { ?>
                                
                                
                                
                                    <option value="<?php echo $item->cat_id;?>"><?php echo $item->cat_name;?><?php if($item->child_count >0){echo ' >';}?></option>
                                    <?php }}}}?>
                                    </select>
                                </div>
                                     <div id="hoidap_1" style="float: left; margin-left: 15px;">
                                     <?php if(isset($cat_level_1_cuoi))
									 {
										 ?>
                                       <?php if(isset($cat_level_1_cuoi)){ ?>
                                <select name="category_pro" id="category_proaa" class="selectcategory_formpost_edit" size="14" onclick="check_postCategoryRaovat(this.value,1,'<?php echo base_url(); ?>');" >                            
                                    <?php 
										foreach($cat_level_1_cuoi as $item){
									?>                                  
                                    <?php if( $category_ads == $item->cat_id){ ?>
                              
                                    <option value="<?php echo $item->cat_id; ?>" selected="selected" ><?php echo $item->cat_name; ?></option
                               
                                ><?php } else { ?>
                                <option value="<?php echo $item->cat_id; ?>" ><?php echo $item->cat_name; ?></option>
                                <?php } } ?>
                                </select>
                                
                                    <?php } 
									?>
                                         <?php }else{
										 ?>
                                     <?php if(isset($cat_level_1)){ ?>
                                <select name="category_pro" id="category_proaa" class="selectcategory_formpost_edit" size="14" onclick="check_postCategoryRaovat(this.value,1,'<?php echo base_url(); ?>');" >
                            
                                    <?php 
										foreach($cat_level_1 as $item){
									?>                                  
                                    <?php if( $cat_parent_parent -> parent_id == $item->cat_id){ ?>
                              
                                    <option value="<?php echo $item->cat_id; ?>" selected="selected" ><?php echo $item->cat_name; ?></option
                               
                                ><?php } else { ?>
                                <option value="<?php echo $item->cat_id; ?>" ><?php echo $item->cat_name; ?></option>
                                <?php } } ?>
                                </select>
                                
                                    <?php } }?>                                    
                                </div>
                                <div id="hoidap_2" style="float: left;  margin-left: 15px; width:150px;">               <?php if(isset($cat_level_2)){ ?>
                                <select name="category_pro" id="category_pro_edit" class="selectcategory_formpost_edit" size="14"  onclick="check_postCategoryRaovat(this.value,2,'<?php echo base_url(); ?>');" >
                             
                                    <?php 
										foreach($cat_level_2 as $item){
									?>                                  
                                    <?php if(isset($category_ads) && $category_ads == $item->cat_id){ ?>
                                    <option value="<?php echo $item->cat_id; ?>" selected="selected" ><?php echo $item->cat_name; ?></option
                               
                                ><?php } else { ?>
                                <option value="<?php echo $item->cat_id; ?>" ><?php echo $item->cat_name; ?></option>
                                <?php } } ?>
                                </select>
                                
                                    <?php }?>
                                
                                    
                                </div>
                                <input type="hidden" id="hd_category_id" name="hd_category_id" value="<?php echo $category_ads; ?>"/>
                                </div>
                                
                                
                            
                           
                        </td>
                    </tr>
                    
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('title_post_ads_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($title_ads)){echo $title_ads;} ?>" name="title_ads" id="title_ads" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_ads',1)" onblur="ChangeStyle('title_ads',2)" onkeypress="return submitenter(this,event)" />
                            <?php echo form_error('title_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"> Loại tin:</td>
                        <td>
                           <select name="loai_tin" id="loai_tin" class="selectprovince_formpost">
                            <option value="0" <?php if($loai_tin==0) { ?> selected="selected" <?php  } ?> >Tin bán</option>
                            <option value="1" <?php if($loai_tin==1) { ?> selected="selected" <?php  } ?> >Tin mua</option>
                          </select>
                            </td>
                    </tr>
                    
                    <tr>
                        <td width="150" valign="top" class="list_post"> <?php echo $this->lang->line('descr_ads_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($descr_ads)){echo $descr_ads;} ?>" name="descr_ads" id="descr_ads" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('descr_ads',1)" onblur="ChangeStyle('descr_ads',2)" onkeypress="return submitenter(this,event)" />
                            <?php echo form_error('descr_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('province_ads_edit'); ?>:</td>
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
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('enddate_ads_edit'); ?>:</td>
                        <td>
                            
                             <input type="text" name="DivEnddate" id="DivEnddate" value="<?php echo $day_ads; ?>-<?php echo $month_ads;  ?>-<?php echo $year_ads; ?>" readonly="readonly" class="set_enddate" />
                      
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
                          
                            <input type="hidden" value="<?php echo $day_ads; ?>-<?php echo $month_ads;  ?>-<?php echo $year_ads; ?>" id="ngay_ket_thuc" name="ngay_ket_thuc" />
                            
                            
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('detail_ads_edit'); ?>:</td>
                        <td style="padding-top:7px;">
                            <table border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td>                              
                                             <?php $this->load->view('admin/common/tinymce'); ?>                                      
                                <textarea name="txtContent" id="txtContent" >
                                 <?php $vovel=array("&curren;"); echo html_entity_decode(str_replace($vovel,"#",$txtContent));?>
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
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('image_ads_edit'); ?>:</td>
                        <td>
                        
                        <div style=" display:<?php if($ads_image!=''){ echo "none" ; } else { echo "block"; } ?>" id="vavatar_input">
							
                            <input type="file" name="image_ads" id="image_ads" class="inputimage_formpost" />                              <input type="button"  onclick="resetBrowesIimgQ('image_ads');"  value="Hủy" />
                            <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('image_tip_help') ?>',285,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                            <span class="div_helppost">(<?php echo $this->lang->line('image_help'); ?>)</span> <br />                            
                         </div>
                         <div style=" display:<?php if($ads_image==''){ echo "none" ; } else { echo "block"; } ?>" id="img_vavatar_input">
                         <div style="float:left;">
                          
                            <img src="<?php echo base_url(); ?>media/images/raovat/<?php echo $ads_dir; ?>/<?php echo $ads_image ?>"  style="min-width:60px; min-height:60px; max-height:80px; max-width:80px; margin-top:5px; clear:both;"  />
                            </div>
                            <div style="float:left; " class="xoa_hinh_nay">
                             <img style="margin-top:7px;" src="<?php echo base_url(); ?>templates/home/images/xoaimg.png" border="0" title="Xóa hình này " onclick=" return delete_img_ajax('<?php echo base_url(); ?>home/account/','<?php echo $ads_id; ?>','ads_id','ads_image','tbtt_ads');" />
                             </div>
                             </div>
                          
                          
                          
                       
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('poster_ads_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($fullname_ads)){echo $fullname_ads;} ?>" name="fullname_ads" id="fullname_ads" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostAds','fullname_ads');" onfocus="ChangeStyle('fullname_ads',1)" onblur="ChangeStyle('fullname_ads',2)" />
                            <?php echo form_error('fullname_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_ads_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($address_ads)){echo $address_ads;} ?>" name="address_ads" id="address_ads" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmPostAds','address_ads');" onfocus="ChangeStyle('address_ads',1)" onblur="ChangeStyle('address_ads',2)" onkeypress="return submitenter(this,event)" />
                            <?php echo form_error('address_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_ads_edit'); ?>:</td>
                        <td>
                     
                            <img src="<?php echo base_url(); ?>templates/home/images/mobile_1.gif" border="0" />
                            <input type="text" value="<?php if(isset($mobile_ads)){echo $mobile_ads;} ?>" name="mobile_ads" id="mobile_ads" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobile_ads',1)" onblur="ChangeStyle('mobile_ads',2)" />
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
                        <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_ads_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($email_ads)){echo $email_ads;} ?>" name="email_ads" id="email_ads" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_ads',1)" onblur="ChangeStyle('email_ads',2)" onkeypress="return submitenter(this,event)" />
                            <?php echo form_error('email_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('yahoo_ads_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($yahoo_ads)){echo $yahoo_ads;} ?>" name="yahoo_ads" id="yahoo_ads" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('yahoo_ads',1)" onblur="ChangeStyle('yahoo_ads',2)" onkeypress="return submitenter(this,event)" />
                            <?php echo form_error('yahoo_ads'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('skype_ads_edit'); ?>:</td>
                        <td>
                            <input type="text" value="<?php if(isset($skype_ads)){echo $skype_ads;} ?>" name="skype_ads" id="skype_ads" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('skype_ads',1)" onblur="ChangeStyle('skype_ads',2)" onkeypress="return submitenter(this,event)"  />
                            <?php echo form_error('skype_ads'); ?>
                        </td>
                    </tr>
                    <?php if(isset($imageCaptchaEditAdsAccount)){ ?>
                    <tr>
                        <td width="150" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:</td>
                        <td align="left" style="padding-top:7px;">
                            <img src="<?php echo $imageCaptchaEditAdsAccount; ?>" width="151" height="30" /><br />
                            <input type="text" name="captcha_ads" id="captcha_ads" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_ads',1);" onblur="ChangeStyle('captcha_ads',2);" onkeypress="return submitenter(this,event)" />
                            <input type="hidden" id="captcha" name="captcha" value="<?php echo $captcha;?>"/>
                            <input type="hidden" id="isEditAds" name="isEditAds" value=""/>
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
   CheckInput_EditAds();
   return false;
   }
else
   return true;
}
//-->
</SCRIPT>

                                    <input type="button" onclick="CheckInput_EditAds();" name="submit_editads" value="<?php echo $this->lang->line('button_agree_ads_edit'); ?>" class="button_form" id="interummit" onkeypress="return submitenter(this,event)" /></td>
                                    <td width="15"></td>
                                    <td><input type="button" onclick="ActionLink('<?php echo base_url(); ?>account/raovat');" name="reset_editads" value="<?php echo $this->lang->line('button_cancel_ads_edit'); ?>" class="button_form" /></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </form>
                    <?php }else{ ?>
                    <tr>
                        <td class="success_post" style="padding-top:10px;">
                            <p class="text-center"><a href="<?php echo base_url(); ?>account/raovat">Click vào đây để tiếp tục</a></p>
                            <?php echo $this->lang->line('success_ads_edit'); ?>
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
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
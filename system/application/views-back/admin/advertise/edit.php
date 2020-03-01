<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>

<tr>
  <td valign="top"><table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
      <tr>
        <td width="2"></td>
        <td width="10" class="left_main" valign="top"></td>
        <td align="center" valign="top"><!--BEGIN: Main-->
          
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="10"></td>
            </tr>
            <tr>
              <td><!--BEGIN: Item Menu-->
                
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="5%" height="67" class="item_menu_left"><img src="<?php echo base_url(); ?>templates/admin/images/item_editadvertise.gif" border="0" /></td>
                    <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_edit'); ?></td>
                    <td width="55%" height="67" class="item_menu_right"><?php if($successEdit == false){ ?>
                      <div class="icon_item" id="icon_item_1" onclick="ActionLink('<?php echo base_url(); ?>administ/advertise')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                        <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_reset.png" border="0" /></td>
                          </tr>
                          <tr>
                            <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('cancel_tool'); ?></td>
                          </tr>
                        </table>
                      </div>
                      <div class="icon_item" id="icon_item_2" onclick="CheckInput_EditAdvertise()" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                        <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_save.png" border="0" /></td>
                          </tr>
                          <tr>
                            <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('save_tool'); ?></td>
                          </tr>
                        </table>
                      </div>
                      <?php }else{ ?>
                      <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url(); ?>administ/advertise/add')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                        <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_add.png" border="0" /></td>
                          </tr>
                          <tr>
                            <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('add_tool'); ?></td>
                          </tr>
                        </table>
                      </div>
                      <?php } ?></td>
                  </tr>
                </table>
                
                <!--END Item Menu--></td>
            </tr>
            <tr>
              <td height="10"></td>
            </tr>
            <tr>
              <td align="center" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="20" height="20" class="corner_lt_post"></td>
                    <td height="20" class="top_post"></td>
                    <td width="20" height="20" class="corner_rt_post"></td>
                  </tr>
                  <tr>
                    <td width="20" class="left_post"></td>
                    <td align="center" valign="top"><!--BEGIN: Content-->
                      
                      <table width="585" class="form_main" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td colspan="2" height="30" class="form_top"></td>
                        </tr>
                        <?php if($successEdit == false){ ?>
                          <form name="frmEditAdvertise" method="post" enctype="multipart/form-data">
                        
                        <tr>
                          <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('title_title_edit'); ?>:</td>
                          <td align="left"><input type="text" name="title_adv" id="title_adv" value="<?php echo $title_adv; ?>" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'AllSpecialChar')"  onfocus="ChangeStyle('title_adv',1)" onblur="ChangeStyle('title_adv',2)" />
                            <?php echo form_error('title_adv'); ?></td>
                        </tr>
                        <tr> </tr>
                        <tr>
                          <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> Định dạng Banner :</td>
                          <td align="left"><select id="ub_format_0" alt="Định dạng Banner" name="ub_format_0" style="margin-top:10px; height:20px;"  >
                              <option title="Chọn" value="" >Chọn định dạng</option>
                              <option title="Ảnh" value="1" <?php  if($adv_iframe=="") echo "selected=\"selected\"" ; ?>>Ảnh và Flash</option>
                              <option title="Iframe" value="2" <?php  if($adv_iframe!="") echo "selected=\"selected\"" ; ?> >Iframe</option>
                            </select>
                            <script>
				function changFlashIframe(value)
				{
					if(value==1)
					{
						jQuery('.img_flash_file').css("display","block");
						jQuery('.iframe_file').css("display","none");
					}
					else
					{
						jQuery('.iframe_file').css("display","block");
						jQuery('.img_flash_file').css("display","none");
					}
				}
				</script>
                            <style>
					.img_flash_file{
						clear:both;
						
					}
					.iframe_file{
						clear:both;
					}
				</style></td>
                        </tr>
                        
                          <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('position_edit'); ?>:</td>
                          <td align="left"><select name="position_adv" id="position_adv" class="selectposition_formpost" onchange="thong_bao_kich_thuoc_banner(this.value)" >
                                  <option value="1" <?php if($position_adv == 1){echo 'selected="selected"';} ?>><?php echo $this->lang->line('header_add') ?></option>
                                  <option value="2" <?php if($position_adv == 2){echo 'selected="selected"';} ?>><?php echo $this->lang->line('footer_add') ?></option>
                                  <option value="3" <?php if($position_adv == 3){echo 'selected="selected"';}elseif($position_adv == ''){echo 'selected="selected"';} ?>><?php echo $this->lang->line('left_add') ?></option>
                                  <option value="4" <?php if($position_adv == 4){echo 'selected="selected"';} ?>><?php echo $this->lang->line('right_add') ?></option>
                                  <option value="5" <?php if($position_adv == 5){echo 'selected="selected"';} ?>><?php echo $this->lang->line('top_add') ?></option>
                                  <option value="6" <?php if($position_adv == 6){echo 'selected="selected"';} ?>><?php echo $this->lang->line('center1_add') ?></option>
                                  <option value="7" <?php if($position_adv == 7){echo 'selected="selected"';} ?>><?php echo $this->lang->line('center2_add') ?></option>
                                  <option value="8" <?php if($position_adv == 8){echo 'selected="selected"';} ?>><?php echo $this->lang->line('center3_add') ?></option>
                                  <option value="9" <?php if($position_adv == 9){echo 'selected="selected"';} ?>><?php echo $this->lang->line('slide_add') ?></option>
                                  <option value="10" <?php if($position_adv == 10){echo 'selected="selected"';} ?>><?php echo $this->lang->line('header') ?></option>
                                  <option value="11" <?php if($position_adv == 11){echo 'selected="selected"';} ?>><?php echo $this->lang->line('header1') ?></option>
                                  <option value="12" <?php if($position_adv == 12){echo 'selected="selected"';} ?>><?php echo $this->lang->line('top1_add') ?></option>
                                  <option value="13" <?php if($position_adv == 13){echo 'selected="selected"';} ?>><?php echo $this->lang->line('top2_add') ?></option>
                                  <option value="14" <?php if($position_adv == 14){echo 'selected="selected"';} ?>><?php echo $this->lang->line('bottom1_add') ?></option>
                                  <option value="15" <?php if($position_adv == 15){echo 'selected="selected"';} ?>><?php echo $this->lang->line('bottom2_add') ?></option>
                            </select>
                            <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('position_tip_help_edit'); ?>',190,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" /></td>
                        <tr>
                          <td></td>
                          <td><div id="quydinhichtuocbanner" class="form_asterisk" style="font-weight:bold; color:#F00;  padding-top:10px; padding-bottom:10px; width:100%;">
                              <?php if(isset($position_adv) && $position_adv == 1){echo "Kích thước chuẩn cho banner là chiều dài 980px và chiều cao 120px ";}?>
                              <?php if(isset($position_adv) && $position_adv == 2){echo "Kích thước chuẩn cho banner là chiều dài 970px và chiều cao 250px ";}?>
                              <?php if(isset($position_adv) && $position_adv == 3){echo "Kích thước chuẩn cho banner là chiều dài 468px và chiều cao 60px ";}?>
                              <?php if(isset($position_adv) && $position_adv == 4){echo "Kích thước chuẩn cho banner là chiều dài 468px và chiều cao 60px ";}?>
                              <?php if(isset($position_adv) && $position_adv == 5){echo "Kích thước chuẩn cho banner là chiều dài 580px và chiều cao 400px ";}?>
                              <?php if(isset($position_adv) && $position_adv == 6){echo "Kích thước chuẩn cho banner là chiều dài 200px và chiều cao 200px ";}?>
                              <?php if(isset($position_adv) && $position_adv == 7){echo "Kích thước chuẩn cho banner là chiều dài 200px và chiều cao 200px ";}?>
                              <?php if(isset($position_adv) && $position_adv == 8){echo "Kích thước chuẩn cho banner là chiều dài 320px và chiều cao 480px ";}?>
                              <?php if(isset($position_adv) && $position_adv == 9){echo "Kích thước chuẩn cho banner là chiều dài 240px và chiều cao 400px ";}?>
                              <?php if(isset($position_adv) && $position_adv == 10){echo "Kích thước chuẩn cho banner là chiều dài 234px và chiều cao 60px ";}?>
                              <?php if(isset($position_adv) && $position_adv == 11){echo "Kích thước chuẩn cho banner là chiều dài 425px và chiều cao 600px";}?>
                              <?php if(isset($position_adv) && $position_adv == 12){echo "Kích thước chuẩn cho banner là chiều dài 468px và chiều cao 60px";}?>
                              <?php if(isset($position_adv) && $position_adv == 13){echo "Kích thước chuẩn cho banner là chiều dài 468px và chiều cao 60px";}?>
                              <?php if(isset($position_adv) && $position_adv == 14){echo "Kích thước chuẩn cho banner là chiều dài 728px và chiều cao 90px";}?>
                              <?php if(isset($position_adv) && $position_adv == 15){echo "Kích thước chuẩn cho banner là chiều dài 230px và chiều cao 90px";}?>
                            </div></td>
                        </tr>
                        <tr>
                          <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('banner_edit'); ?>:</td>
                          <td align="left" style="padding-top:7px;"><div class="img_flash_file"  <?php  //if($adv_iframe!="") echo "style=\"display:none\"" ; ?> >
                              <input type="file" name="banner_adv" id="banner_adv" value="" size="24" />
                              <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('banner_tip_help_edit'); ?>',355,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" /> <font color="#0066FF">(Dung lượng <= 1MB)</font><br />
                              <?php if($adv_iframe!=""){ ?>
                              <IFRAME SRC="<?php echo base_url(); ?>media/banners/<?php echo $image_dir_adv; ?>/<?php echo $image_adv; ?>" frameborder="0"> </IFRAME>
                              <?php } else { ?>
                              <img style="margin-top:5px; border:1px solid #CCC;" width="200" height="50" src="<?php echo base_url(); ?>media/banners/<?php echo $image_dir_adv; ?>/<?php echo $image_adv; ?>" border="0" />
                              <?php } ?>
                            </div>
                            <div style="display:none;" class="iframe_file"<?php // if($adv_iframe=="") echo "style=\"display:none\"" ; ?> >
                              <textarea name="link_frame" id="link_frame" cols="45" rows="5" wrap="off" ><?php echo $adv_iframe; ?></textarea>
                            </div></td>
                        </tr><!--db-->
                        <tr><td width="150" valign="top" class="list_post">Chọn danh mục</td>
                        <td><select name="cat_id" >
                       <option value="0">Chọn danh mục</option>                        
                          <?php //'.$item['cat_id'].''.$item['cat_name'].'
                          foreach ($category as $item) {
                          $selected="";
                          if ($item->cat_id==$cat_id) {
                            $selected="selected";
                          }
                           echo '<option value="'.$item->cat_id.'" '.$selected.'>'.$item->cat_name.'</option>';
                          }
                          ?>
                          
                        </select></td>
                        </tr>
                        <tr>
                          <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('link_edit'); ?>:</td>
                          <td align="left"><input type="text" name="link_adv" id="link_adv" maxlength="100" value="<?php echo $link_adv; ?>" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('link_adv',1)" onblur="ChangeStyle('link_adv',2)" />
                            <img  src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('link_tip_help_edit'); ?>',185,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" /> <?php echo form_error('link_adv'); ?></td>
                        </tr>
                        <tr>
                          <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('page_edit'); ?>:</td>
                          <td align="left"><table border="0" cellpadding="0" cellspacing="0">
                              <tr>
                                <td><select name="page_adv[]" id="page_adv" class="selectpage_formpost" multiple="multiple">
                                    <option value="home" <?php if($page_adv != '' && stristr($page_adv, 'home')){echo 'selected="selected"';}; ?>><?php echo $this->lang->line('home_add') ?></option>
                                    <option value="product_sub" <?php if($page_adv != '' && stristr($page_adv, 'product_sub')){echo 'selected="selected"';}; ?>><?php echo $this->lang->line('product_sub_add') ?></option>
                                  </select></td>
                                <td><img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('page_tip_help_edit'); ?>',225,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" /></td>
                              </tr>
                            </table></td>
                        </tr>
                        <tr>
                          <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('order_edit'); ?>:</td>
                          <td align="left"><input type="text" name="order_adv" id="order_adv" value="<?php if($order_adv != ''){echo $order_adv;}else{echo '1';} ?>" maxlength="4" class="inputorder_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('order_adv',1)" onblur="ChangeStyle('order_adv',2)" />
                            <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('order_tip_help'); ?>',155,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" /> <?php echo form_error('order_adv'); ?></td>
                        </tr>
                        <tr>
                          <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('advertiser_edit'); ?>:</td>
                          <td align="left"><input type="text" name="name_adv" id="name_adv" value="<?php echo $name_adv; ?>" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmEditAdvertise','name_adv');" onfocus="ChangeStyle('name_adv',1)" onblur="ChangeStyle('name_adv',2)" />
                            <?php echo form_error('name_adv'); ?></td>
                        </tr>
                        <tr>
                          <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('address_edit'); ?>:</td>
                          <td align="left"><input type="text" name="address_adv" id="address_adv" value="<?php echo $address_adv; ?>" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmEditAdvertise','address_adv');" onfocus="ChangeStyle('address_adv',1)" onblur="ChangeStyle('address_adv',2)" />
                            <?php echo form_error('address_adv'); ?></td>
                        </tr>
                        <tr>
                          <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('phone_edit'); ?>:</td>
                          <td align="left"><img src="<?php echo base_url(); ?>templates/admin/images/phone_1.gif" border="0" />
                            <input type="text" name="phone_adv" id="phone_adv" value="<?php echo $phone_adv; ?>" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('phone_adv',1)" onblur="ChangeStyle('phone_adv',2)" />
                            <b>-</b> <img src="<?php echo base_url(); ?>templates/admin/images/mobile_1.gif" border="0" />
                            <input type="text" name="mobile_adv" id="mobile_adv" value="<?php echo $mobile_adv; ?>" maxlength="20" class="inputphone_formpost" onfocus="ChangeStyle('mobile_adv',1)" onblur="ChangeStyle('mobile_adv',2)" />
                            <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('phone_tip_help'); ?>',135,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" /> <span class="div_helppost"><?php echo $this->lang->line('phone_help'); ?></span> <?php echo form_error('phone_adv'); ?> <?php echo form_error('mobile_adv'); ?></td>
                        </tr>
                        <tr>
                          <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('email_edit'); ?>:</td>
                          <td align="left"><input type="text" name="email_adv" id="email_adv" value="<?php echo $email_adv; ?>" maxlength="50" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('email_adv',1)" onblur="ChangeStyle('email_adv',2)" />
                            <?php echo form_error('email_adv'); ?></td>
                        </tr>
                        <tr>
                          <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('enddate_edit'); ?>:</td>
                          <td align="left"><select name="endday_adv" id="endday_adv" class="selectdate_formpost">
                              <?php for($endday = 1; $endday <= 31; $endday++){ ?>
                              <?php if($endday_adv == $endday){ ?>
                              <option value="<?php echo $endday; ?>" selected="selected"><?php echo $endday; ?></option>
                              <?php }else{ ?>
                              <option value="<?php echo $endday; ?>"><?php echo $endday; ?></option>
                              <?php } ?>
                              <?php } ?>
                            </select>
                            <b>-</b>
                            <select name="endmonth_adv" id="endmonth_adv" class="selectdate_formpost">
                              <?php for($endmonth = 1; $endmonth <= 12; $endmonth++){ ?>
                              <?php if($endmonth_adv == $endmonth){ ?>
                              <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                              <?php }elseif($endmonth == $nextMonth && $endmonth_adv == ''){ ?>
                              <option value="<?php echo $endmonth; ?>" selected="selected"><?php echo $endmonth; ?></option>
                              <?php }else{ ?>
                              <option value="<?php echo $endmonth; ?>"><?php echo $endmonth; ?></option>
                              <?php } ?>
                              <?php } ?>
                            </select>
                            <b>-</b>
                            <select name="endyear_adv" id="endyear_adv" class="selectdate_formpost">
                              <?php for($endyear = (int)date('Y'); $endyear < (int)date('Y')+10; $endyear++){ ?>
                              <?php if($endyear_adv == $endyear){ ?>
                              <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                              <?php }elseif($endyear == $nextYear && $endyear_adv == ''){ ?>
                              <option value="<?php echo $endyear; ?>" selected="selected"><?php echo $endyear; ?></option>
                              <?php }else{ ?>
                              <option value="<?php echo $endyear; ?>"><?php echo $endyear; ?></option>
                              <?php } ?>
                              <?php } ?>
                            </select>
                            <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('enddate_tip_help'); ?>',325,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" /> <span class="div_helppost"><?php echo $this->lang->line('enddate_help'); ?></span> <?php echo form_error('endday_adv'); ?></td>
                        </tr>
                        <tr>
                          <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('status_edit'); ?>:</td>
                          <td align="left" style="padding-top:7px;"><input type="checkbox" name="active_adv" id="active_adv" value="1" <?php if($active_adv == '1'){echo 'checked="checked"';} ?> /></td>
                        </tr>
                          </form>
                        
                        <?php }else{ ?>
                        <tr class="success_post">
                          <td colspan="2"><p class="text-center"><a href="<?php echo base_url().'administ/advertise' ?>">Click vào đây để tiếp tục</a></p>
                            <?php echo $this->lang->line('success_edit'); ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td colspan="2" height="30" class="form_bottom"></td>
                        </tr>
                      </table>
                      
                      <!--END Content--></td>
                    <td width="20" class="right_post"></td>
                  </tr>
                  <tr>
                    <td width="20" height="20" class="corner_lb_post"></td>
                    <td height="20" class="bottom_post"></td>
                    <td width="20" height="20" class="corner_rb_post"></td>
                  </tr>
                </table></td>
            </tr>
          </table>
          
          <!--END Main--></td>
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
    </table></td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>

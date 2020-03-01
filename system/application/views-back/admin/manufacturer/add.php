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
                    <td width="5%" height="67" class="item_menu_left"><img src="<?php echo base_url(); ?>templates/admin/images/item_addcategory.gif" border="0" /></td>
                    <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_add'); ?></td>
                    <td width="55%" height="67" class="item_menu_right"><?php if($successAdd == false){ ?>
                      <div class="icon_item" id="icon_item_1" onclick="ActionLink('<?php echo base_url(); ?>administ/manufacturer')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                        <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_reset.png" border="0" /></td>
                          </tr>
                          <tr>
                            <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('cancel_tool'); ?></td>
                          </tr>
                        </table>
                      </div>
                      <div class="icon_item" id="icon_item_2" onclick="CheckInput_Addmanufacture()" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
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
                      <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url(); ?>administ/manufacturer/add')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
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
                      
                      <table width="850" class="form_main" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td colspan="2" height="30" class="form_top"></td>
                        </tr>
                        <?php if($successAdd == false){ ?>
                        <form name="frmAddCategory" method="post">
                          
                          <tr>
                            <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> Chọn danh mục:</td>
                            <td align="left"><div  style=" padding-top:14px;">
                                <div id="hoidap_0" style="float: left; ">
                                  <select id="hd_select_0" class="form_control_hoidap_select" onclick="check_edit_nha_san_xuat_cate(this.value,0,'<?php echo base_url(); ?>');" size="14">
                                    <?php 
                    			  if(isset($catlevel0)){
										foreach($catlevel0 as $item){
									?>
                                    <?php if($cat_getcategory0!="") { ?>
                                    <?php  if($category_shop == $item->cat_id){ ?>
                                    <option value="<?php echo $item->cat_id; ?>" selected="selected" ><?php echo $item->cat_name; ?></option>
                                    <?php if($item->child_count >0){echo ' >';}?>
                                    <?php }else { ?>
                                    <option value="<?php echo $item->cat_id; ?>"  ><?php echo $item->cat_name; ?></option >
                                    <?php
								}?>
                                    <?php
									}
									else
									{ ?>
                                    <?php  if( $cat_parent_parent_0 -> parent_id == $item->cat_id){ ?>
                                    <option value="<?php echo $item->cat_id; ?>" selected="selected" ><?php echo $item->cat_name; ?></option                             
                                >
                                    <?php }   else { ?>
                                    <option value="<?php echo $item->cat_id;?>"><?php echo $item->cat_name;?>
                                    <?php if($item->child_count >0){echo ' >';}?>
                                    </option>
                                    <?php }}}}?>
                                  </select>
                                </div>
                                <div id="hoidap_1" style="float: left; margin-left: 15px;"> </div>
                                <div id="hoidap_2" style="float: left;  margin-left: 15px;"> </div>
                                <input type="hidden" id="hd_category_id" name="hd_category_id" value="<?php echo $category_pro ; ?>"/>
                              </div></td>
                          </tr>
                          <tr>
                          <tr>
                            <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('name_add'); ?>:</td>
                            <td align="left"><input type="text" name="name_manufacturer" id="name_manufacturer" value="<?php echo $name_manufacturer; ?>" maxlength="35" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('name_manufacturer',1)" onblur="ChangeStyle('name_manufacturer',2)" />
                              <?php echo form_error('name_manufacturer'); ?></td>
                          </tr>
                          <tr>
                            <td width="150" valign="top" class="list_post"><font color="#FF0000"></font> <?php echo $this->lang->line('descr_add'); ?>:</td>
                            <td align="left"><input type="text" name="descr_manufacturer" id="descr_manufacturer" value="<?php echo $descr_manufacturer; ?>" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('descr_manufacturer',1)" onblur="ChangeStyle('descr_manufacturer',2)" />
                              <?php echo form_error('descr_manufacturer'); ?></td>
                          </tr>
                          <tr>
                            <td width="150" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('order_add'); ?>:</td>
                            <td align="left"><input type="text" name="order_manufacturer" id="order_manufacturer" value="<?php if($order_manufacturer != ''){echo $order_manufacturer;}else{echo '1';} ?>" maxlength="4" class="inputorder_formpost" onkeyup="BlockChar(this,'NotNumbers')" onfocus="ChangeStyle('order_manufacturer',1)" onblur="ChangeStyle('order_manufacturer',2)" />
                              <img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('order_tip_help'); ?>',155,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" /> <?php echo form_error('order_manufacturer'); ?></td>
                          </tr>
                          <tr>
                            <td width="150" valign="top" class="list_post"><?php echo $this->lang->line('status_add'); ?>:</td>
                            <td align="left" style="padding-top:7px;"><input type="checkbox" name="active_manufacturer" id="active_manufacturer" value="1" <?php if($active_manufacturer == '1'){echo 'checked="checked"';} ?> /></td>
                          </tr>
                        </form>
                        <?php }else{ ?>
                        <tr class="success_post">
                          <td colspan="2"><p class="text-center"><a href="<?php echo base_url().'administ/manufacturer' ?>">Click vào đây để tiếp tục</a></p>
                            <?php echo $this->lang->line('success_add'); ?></td>
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

<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>

<tr>
  <td valign="top"><table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
      <tr>
        <td align="center" valign="top"><!--BEGIN: Main-->
          
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="10"></td>
            </tr>
            <tr>

			  <!--BEGIN: Item Menu--> 
			  
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="5%" height="67" class="item_menu_left"><a href="<?php echo base_url(); ?>administ/system/info"> <img src="<?php echo base_url(); ?>templates/home/images/icon/information-icon.png" border="0" /> </a></td>
                    <td width="40%" height="67" class="item_menu_middle">Cấu hình hoa hồng bán Giải pháp</td>
                    <td width="55%" height="67" class="item_menu_right"><div class="icon_item" id="icon_item_1" onclick="ActionLink('<?php echo base_url(); ?>administ')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                        <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_back.png" border="0" /></td>
                          </tr>
                          <tr>
                            <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('back_tool'); ?></td>
                          </tr>
                        </table>
                      </div></td>
                  </tr>
                </table>
                <!--END Item Menu-->
				
				
				
				</td>
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
                    <td align="center" valign="top"><div class="wapper_config">
                    	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td class="title_list">Tên nhóm</td>
                            <td class="title_list">Doanh thu / tháng</td>
                            <td class="title_list">Hoa hồng <br />(%)</td>
                            <!--<td class="title_list">Hoa hồng Mức 1 <br />(%)</td>
                            <td class="title_list">Hoa hồng Mức 2 <br />(%)</td>
                            <td class="title_list">Hoa hồng Mức 3 <br />(%)</td>
                            <td class="title_list">Số AF Mức 1 <br />(người)</td>
                            <td class="title_list">Số AF Mức 2 <br />(người)</td>
                            <td class="title_list">Số AF Mức 3 <br />(người)</td>-->
                            <td class="title_list">Sửa</td>
                          </tr>
                          <?php for($i=0; $i <5; $i++ ){ ?>
                          <tr>
                            <td class="detail_list"><b><?php echo $listConfig[$i]->group_name; ?></b></td>
                            <td class="detail_list"><?php echo $listConfig[$i]->revenue; ?></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_<?php echo $listConfig[$i]->id; ?> " id="commission_<?php echo $listConfig[$i]->id; ?>" name="" type="text" value="<?php echo $listConfig[$i]->commission; ?>" /></td>
                            <!--<td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_<?php /*echo $listConfig[$i]->id; */?>" id="commission_level1_<?php /*echo $listConfig[$i]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[$i]->commission_level1; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_<?php /*echo $listConfig[$i]->id; */?>" id="commission_level2_<?php /*echo $listConfig[$i]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[$i]->commission_level2; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_<?php /*echo $listConfig[$i]->id; */?>" id="commission_level3_<?php /*echo $listConfig[$i]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[$i]->commission_level3; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_<?php /*echo $listConfig[$i]->id; */?>" id="affiliate_number_level1_<?php /*echo $listConfig[$i]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[$i]->affiliate_number_level1; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_<?php /*echo $listConfig[$i]->id; */?>" id="affiliate_number_level2_<?php /*echo $listConfig[$i]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[$i]->affiliate_number_level2; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_<?php /*echo $listConfig[$i]->id; */?>" id="affiliate_number_level3_<?php /*echo $listConfig[$i]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[$i]->affiliate_number_level3; */?>" /></td>
                            --><td class="detail_list" align="center" style="text-align:center"><button onclick="checkToEdit(<?php echo $listConfig[$i]->id; ?>,'<?php echo base_url(); ?>')" class="save_commission_config save_commission_config_<?php echo $listConfig[$i]->id; ?>">Lưu</button><button onclick="editConfig(<?php echo $listConfig[$i]->id; ?>);" class="edit_commission_config edit_commission_config_<?php echo $listConfig[$i]->id; ?>" >Sửa</button></td>
                          </tr>
                          <?php } ?>
                          
                          <tr>
                            <td class="detail_list"><b><?php echo $listConfig[5]->group_name; ?></b></td>
                            <td class="detail_list"><?php echo $listConfig[5]->revenue; ?></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_6" id="commission_<?php echo $listConfig[5]->id; ?>" name="" type="text" value="<?php echo $listConfig[5]->commission; ?>" /></td>
                            <!--<td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_6" id="commission_level1_<?php /*echo $listConfig[5]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[5]->commission_level1; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_6" id="commission_level2_<?php /*echo $listConfig[5]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[5]->commission_level2; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_6" id="commission_level3_<?php /*echo $listConfig[5]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[5]->commission_level3; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_6" id="affiliate_number_level1_<?php /*echo $listConfig[5]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[5]->affiliate_number_level1; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_6" id="affiliate_number_level2_<?php /*echo $listConfig[5]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[5]->affiliate_number_level2; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_6" id="affiliate_number_level3_<?php /*echo $listConfig[5]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[5]->affiliate_number_level3; */?>" /></td>
                            --><td class="detail_list" align="center" style="text-align:center"><button onclick="checkToEdit(6,'<?php echo base_url(); ?>')" class="save_commission_config save_commission_config_<?php echo $listConfig[5]->id; ?>">Lưu</button><button onclick="editConfig(6);" class="edit_commission_config edit_commission_config_<?php echo $listConfig[5]->id; ?>" >Sửa</button></td>
                          </tr>
                          
                          <tr>
                            <td class="detail_list"><b><?php echo $listConfig[6]->group_name; ?></b></td>
                            <td class="detail_list"><?php echo $listConfig[6]->revenue; ?></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_7" id="commission_<?php echo $listConfig[6]->id; ?>" name="" type="text" value="<?php echo $listConfig[6]->commission; ?>" /></td>
                         <!--   <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_7" id="commission_level1_<?php /*echo $listConfig[6]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[6]->commission_level1; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_7" id="commission_level2_<?php /*echo $listConfig[6]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[6]->commission_level2; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_7" id="commission_level3_<?php /*echo $listConfig[6]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[6]->commission_level3; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_7" id="affiliate_number_level1_<?php /*echo $listConfig[6]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[6]->affiliate_number_level1; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_7" id="affiliate_number_level2_<?php /*echo $listConfig[6]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[6]->affiliate_number_level2; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_7" id="affiliate_number_level3_<?php /*echo $listConfig[6]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[6]->affiliate_number_level3; */?>" /></td>
                            --><td class="detail_list" align="center" style="text-align:center"><button onclick="checkToEdit(7,'<?php echo base_url(); ?>')" class="save_commission_config save_commission_config_<?php echo $listConfig[6]->id; ?>">Lưu</button><button onclick="editConfig(7);" class="edit_commission_config edit_commission_config_<?php echo $listConfig[6]->id; ?>" >Sửa</button></td>
                          </tr>
                          
                          <tr>
                            <td class="detail_list"><b><?php echo $listConfig[7]->group_name; ?></b></td>
                            <td class="detail_list"><?php echo $listConfig[7]->revenue; ?></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_8" id="commission_<?php echo $listConfig[7]->id; ?>" name="" type="text" value="<?php echo $listConfig[7]->commission; ?>" /></td>
                          <!--  <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_8" id="commission_level1_<?php /*echo $listConfig[7]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[7]->commission_level1; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_8" id="commission_level2_<?php /*echo $listConfig[7]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[7]->commission_level2; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_8" id="commission_level3_<?php /*echo $listConfig[7]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[7]->commission_level3; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_8" id="affiliate_number_level1_<?php /*echo $listConfig[7]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[7]->affiliate_number_level1; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_8" id="affiliate_number_level2_<?php /*echo $listConfig[7]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[7]->affiliate_number_level2; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_8" id="affiliate_number_level3_<?php /*echo $listConfig[7]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[7]->affiliate_number_level3; */?>" /></td>
                            --><td class="detail_list" align="center" style="text-align:center"><button onclick="checkToEdit(8,'<?php echo base_url(); ?>')" class="save_commission_config save_commission_config_<?php echo $listConfig[7]->id; ?>">Lưu</button><button onclick="editConfig(8);" class="edit_commission_config edit_commission_config_<?php echo $listConfig[7]->id; ?>" >Sửa</button></td>
                          </tr>
                          
                          <tr>
                            <td class="detail_list"><b><?php echo $listConfig[8]->group_name; ?></b></td>
                            <td class="detail_list"><?php echo $listConfig[8]->revenue; ?></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_9" id="commission_<?php echo $listConfig[8]->id; ?>" name="" type="text" value="<?php echo $listConfig[8]->commission; ?>" /></td>
                           <!-- <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_9" id="commission_level1_<?php /*echo $listConfig[8]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[8]->commission_level1; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_9" id="commission_level2_<?php /*echo $listConfig[8]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[8]->commission_level2; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_9" id="commission_level3_<?php /*echo $listConfig[8]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[8]->commission_level3; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_9" id="affiliate_number_level1_<?php /*echo $listConfig[8]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[8]->affiliate_number_level1; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_9" id="affiliate_number_level2_<?php /*echo $listConfig[8]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[8]->affiliate_number_level2; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_9" id="affiliate_number_level3_<?php /*echo $listConfig[8]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[8]->affiliate_number_level3; */?>" /></td>
                            --><td class="detail_list" align="center" style="text-align:center"><button onclick="checkToEdit(9,'<?php echo base_url(); ?>')" class="save_commission_config save_commission_config_<?php echo $listConfig[8]->id; ?>">Lưu</button><button onclick="editConfig(9);" class="edit_commission_config edit_commission_config_<?php echo $listConfig[8]->id; ?>" >Sửa</button></td>
                          </tr>
                          
                          <tr>
                            <td class="detail_list"><b><?php echo $listConfig[9]->group_name; ?></b></td>
                            <td class="detail_list"><?php echo $listConfig[9]->revenue; ?></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_10" id="commission_<?php echo $listConfig[9]->id; ?>" name="" type="text" value="<?php echo $listConfig[9]->commission; ?>" /></td>
                            <!--<td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_10" id="commission_level1_<?php /*echo $listConfig[9]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[9]->commission_level1; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_10" id="commission_level2_<?php /*echo $listConfig[9]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[9]->commission_level2; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_10" id="commission_level3_<?php /*echo $listConfig[9]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[9]->commission_level3; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_10" id="affiliate_number_level1_<?php /*echo $listConfig[9]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[9]->affiliate_number_level1; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_10" id="affiliate_number_level2_<?php /*echo $listConfig[9]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[9]->affiliate_number_level2; */?>" /></td>
                            <td class="detail_list"><input disabled="disabled" class="text_edit_config text_edit_config_10" id="affiliate_number_level3_<?php /*echo $listConfig[9]->id; */?>" name="" type="text" value="<?php /*echo $listConfig[9]->affiliate_number_level3; */?>" /></td>
                            --><td class="detail_list" align="center" style="text-align:center"><button onclick="checkToEdit(10,'<?php echo base_url(); ?>')" class="save_commission_config save_commission_config_<?php echo $listConfig[9]->id; ?>">Lưu</button><button onclick="editConfig(10);" class="edit_commission_config edit_commission_config_<?php echo $listConfig[9]->id; ?>" >Sửa</button></td>
                          </tr>
                          
                        </table>
                      </div></td>
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

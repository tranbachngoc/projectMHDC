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
                    <td width="5%" height="67" class="item_menu_left"><a href="<?php echo base_url(); ?>administ/tool/mail"> <img src="<?php echo base_url(); ?>templates/admin/images/item_mail.gif" border="0" /> </a></td>
                    <td width="40%" height="67" class="item_menu_middle"><?php echo $this->lang->line('title_mail'); ?></td>
                    <td width="55%" height="67" class="item_menu_right"><?php if($successSend == false){ ?>
                      <div class="icon_item" id="icon_item_1" onclick="ActionLink('<?php echo base_url(); ?>administ')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                        <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_reset.png" border="0" /></td>
                          </tr>
                          <tr>
                            <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('cancel_tool'); ?></td>
                          </tr>
                        </table>
                      </div>
                      <div class="icon_item" id="icon_item_2" onclick="CheckInput_Mail()" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                        <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_send.png" border="0" /></td>
                          </tr>
                          <tr>
                            <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('send_mail'); ?></td>
                          </tr>
                        </table>
                      </div>
                      <?php }else{ ?>
                      <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url(); ?>administ/tool/mail')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                        <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                          <tr>
                            <td align="center"><img src="<?php echo base_url(); ?>templates/admin/images/icon_send.png" border="0" /></td>
                          </tr>
                          <tr>
                            <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('send_mail'); ?></td>
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
                      
                      <table width="780" class="config_main" cellpadding="0" cellspacing="0" border="0">
                        <tr>
                          <td height="30" class="config_top"></td>
                        </tr>
                        <?php if($successSend == false){ ?>
                        <tr>
                          <td><table width="100%" cellpadding="0" cellspacing="0" border="0">
                              <form name="frmMail" method="post">
                                <tr>
                                  <td width="100" class="list_post"><?php echo $this->lang->line('to_mail'); ?>: </td>
                                  <td align="left"><textarea name="to_mail" rows="10" class="textarea_mail" id="to_mail" onfocus="ChangeStyle('to_mail',1)" onblur="ChangeStyle('to_mail',2)" style="width:503px; height:200px;"><?php echo $to_mail; ?></textarea>
                                    <?php echo form_error('to_mail'); ?></td>
                                </tr>
                                 <tr>
                                  <td width="100" valign="top" class="list_post">Nhóm: </td>
                                  <td align="left" height="40"><?php echo $nhomguimail ; ?>
                                    </td>
                                </tr>
                                
                                <tr>
                                  <td width="100" class="list_post"><?php echo $this->lang->line('list_mail'); ?>: </td>
                                  <td align="left"><table width="425" cellpadding="0" cellspacing="0" border="0">
                                      <tr>
                                        <td>
<script>
	jQuery(document).ready(function() {
		jQuery("#checkAllEmail").click(function() {
			jQuery("#list_mail").each(function(){
			jQuery("#list_mail option").attr("selected","selected"); 
			
			});
			
			var foo = []; 
			var chuoi="";
			var j=0;
			$('#list_mail option').each(function(i, selected){ 
			if(j==0)
			{
			foo[i] = $(selected).text(); 
			chuoi+=foo[i];
			}
			else
			{	
			
			foo[i] = $(selected).text(); 
			
			chuoi+=","+foo[i];
			
			}
			j=j+1;
			
			});
			jQuery('#to_mail').val(chuoi);
						
		}) ;
		jQuery("#checkNoAllEmail").click(function() {
			jQuery("#list_mail").each(function(){
				jQuery("#list_mail option").attr("selected",""); 
			});
			jQuery('#to_mail').val('');
			
		}) ;
	
	});

</script>
                                          <select name="list_mail" id="list_mail" onclick="SelectMail()" class="selectmail_formpost" size="1000" multiple="multiple">
                                            <?php foreach($email as $emailArray){ ?>
                                            <option value="<?php echo $emailArray->use_email; ?>"><?php echo $emailArray->use_email; ?></option>
                                            <?php } ?>
                                          </select>
                                          <input style="margin-top:7px;" value="Chọn tất cả" name="selectall" type="button" id="checkAllEmail" />
                                          &nbsp;&nbsp;
                                          <input style="margin-top:7px;" value="Hủy tất cả" name="selectall" type="button" id="checkNoAllEmail" /></td>
                                        <td align="left"><img src="<?php echo base_url(); ?>templates/admin/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('list_tip_help_mail'); ?>',335,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" /></td>
                                      </tr>
                                    </table></td>
                                </tr>
                                   
                                
                                <tr>
                                  <td width="100" valign="top" class="list_post"><?php echo $this->lang->line('from_mail'); ?>: </td>
                                  <td align="left"><input type="text" name="from_mail" id="from_mail" value="<?php echo $from_mail; ?>" maxlength="100" class="inputmail_formpost" onfocus="ChangeStyle('from_mail',1)" onblur="ChangeStyle('from_mail',2)" />
                                    <?php echo form_error('from_mail'); ?></td>
                                </tr>
                                <tr>
                                  <td width="100" valign="top" class="list_post"><?php echo $this->lang->line('subject_mail'); ?>: </td>
                                  <td align="left"><input type="text" name="subject_mail" id="subject_mail" value="<?php echo $subject_mail; ?>" maxlength="100" class="inputmail_formpost" onfocus="ChangeStyle('subject_mail',1)" onblur="ChangeStyle('subject_mail',2)" />
                                    <?php echo form_error('subject_mail'); ?></td>
                                </tr>
                                <tr>
                                  <td width="100" class="list_post"><?php echo $this->lang->line('content_mail'); ?>: </td>
                                  <td align="left" class="content_mail"><?php $this->load->view('admin/common/meditor'); ?>
                                    <?php echo form_error('txtContent'); ?></td>
                                </tr>
                              </form>
                            </table></td>
                        </tr>
                        <?php }else{ ?>
                        <tr class="success_post">
                          <td align="center"><p class="text-center"><a href="<?php echo base_url().'administ/tool/mail' ?>">Click vào đây để tiếp tục</a></p>
                            <?php echo $this->lang->line('success_send'); ?></td>
                        </tr>
                        <?php } ?>
                        <tr>
                          <td height="30" class="config_bottom"></td>
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

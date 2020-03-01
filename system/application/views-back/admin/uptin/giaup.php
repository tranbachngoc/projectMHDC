<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<tr>
    <td valign="top">

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
                                            <a href="<?php echo base_url(); ?>administ/tool/mail">
                                            	<img src="<?php echo base_url(); ?>templates/admin/images/item_mail.gif" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle">cấu hình giá</td>
                                        <td width="55%" height="67" class="item_menu_right">
                                            <?php if($successSend == false){ ?>
                                            <div class="icon_item" id="icon_item_1" onclick="ActionLink('<?php echo base_url(); ?>administ')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
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
                                            <div class="icon_item" id="icon_item_2" onclick="CheckInput_Mail()" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                                               
                                            </div>
                                            <?php }else{ ?>
                                            <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url(); ?>administ/tool/mail')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                                                <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                    <tr>
                                                        <td align="center">
                                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_send.png" border="0" />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('send_mail'); ?></td>
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
 	<script type="text/javascript">
		function mysubmitUpdate()
		{
			if(CheckBlank(document.getElementById('money').value))
			{
				alert("Bạn chưa số giá tiền!");
				document.getElementById('money').focus();
				return false;
			}
			 if(!IsNumber(document.getElementById('money').value))
			 {
				alert("Số  tiền  bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
				document.getElementById('money').focus();
				return false;
			 }
			 
			jQuery('#submit_form').val(1);
			document.myadminForm.submit();
		}
	</script>

     <form name="myadminForm" accept-charset="utf-8" method="post" action="">
		<fieldset class="adminform">
			<legend>Chỉnh sửa số tiền trên một lần uptin</legend>
            <?php if((int)$capnhatthanhcong!=1) { ?>
			<table class="admintable">
			  <tbody>
				<tr>
				  <td class="key"><label for="name"> Số tiền trên một lần uptin (D): </label>
				    </td>
				  <td><input type="text" class="inputbox"  name="money" id="money" size="60" maxlength="255" value="<?php echo $price_up; ?>"> &nbsp;&nbsp; 				 
				    </td>
				  </tr>
                
				<tr>
				  <td></td>
				  <td> <input type="button" onclick="return mysubmitUpdate();" value="Lưu" name="rechargeSubmit"> </td>
				  </tr>
				
			  </tbody>
			</table>
            <?php } else { ?>
            <table class="admintable">
            <tr class="success_post">
                                                    <td colspan="2">
                                                        <p class="text-center"><a href="<?php echo base_url().'administ' ?>">Click vào đây để tiếp tục</a></p>
                                                		Cập nhật thành công
                                                    </td>
                                                </tr>
                                                </table>
            <?php } ?>
			</fieldset>
		 <input name="submit_form" id="submit_form" type="hidden" value="" />
			   </form>
			<? //echo form_close($string);?>
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
<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<tr>
    <td valign="top">
<script >
	jQuery(document).ready(function() {
		jQuery("#username").autocomplete("<?php echo base_url() ?>administ/user/ajax", {
			width: 500,
			selectFirst: false
		}).result(function(event, item, formatted) {
			qSearch('<?php echo base_url(); ?>');
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
                                            <a href="<?php echo base_url(); ?>administ/tool/mail">
                                            	<img src="<?php echo base_url(); ?>templates/admin/images/item_mail.gif" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle">Nạp Tiền Cho Thành Viên</td>
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
                                            <!--BEGIN: Content-->
 <script> 
	   Number.prototype.formatMoney = function(c, d, t){
	var n = this, c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
	   return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	 };
	 
	
	function isInt(x) {
	 /* var y=parseInt(x);
	  if (isNaN(y)) return false;
	  return x==y && x.toString()==y.toString();*/
	  return parseFloat(x)==x;
	}
   function mysubmit(){
	
				var username = document.getElementById("username").value;
				  
				var money = document.getElementById("money").value;
				if(username ==""){
					alert("Vui lòng nhập Username!");
					return false;
				}else if(money==""){
					alert("Vui lòng nhập số tiền muốn nạp!");
					return false;
				}else if(!isInt(money)){
					alert("Vui lòng nhập số tiền dạng số!");
					return false;
				}else{	
					var url = "<? echo base_url()?>/administ/uptin/check_username/"+username;
					
					$.get(url, function(response) {
						if(response==0){
							alert("Username này không tồn tại, vui lòng kiểm tra lại!");
						}else{
							 
							document.forms["myadminForm"].submit();	
						}    
					});
									
					
				}				
				
			}
			
	function changeMoney(money){
		document.getElementById("moneyConfirm").value="Số tiền tính theo VNĐ: "+(money*10000).formatMoney(0, ".", ".")+" VNĐ";
			
	}
   
   </script>
	<?
	//$attributes = array('name' => 'myadminForm');
	
	 //echo form_open('administ/uptin/naptien', $attributes);
	  ?>
     <form name="myadminForm" accept-charset="utf-8" method="post" action="<?php echo base_url()."administ/uptin/naptien"; ?>">
		<fieldset class="adminform">
			<legend>Nạp tiền cho thành viên</legend>
			<table class="admintable">
			  <tbody>
				<tr>
				  <td class="key"><label for="name"> Nạp cho (username): </label>
				  </td>
				  <td>
                  <input <?php /*?>onKeyPress="autoCompleteSearch();"<?php */?> name="username" type="text" size="60" maxlength="255" id="username" class="searchSelect inputbox"  />                                     
                 <!-- <input type="text" class="inputbox" name="username" id="username" size="60" maxlength="255" value="">-->
				  </td>
				</tr>
				<tr>
				  <td class="key"><label for="name"> Số tiền (D): </label>
				  </td>
				  <td><input type="text" class="inputbox" onkeyup="changeMoney(this.value);" name="money" id="money" size="60" maxlength="255" value=""> &nbsp;&nbsp; 				 <strong style="color:#FF0000;">(1D = 10.000 VNĐ)</strong>
				  </td>
				</tr>
				
				<tr>
				  <td class="key" >
				  </td>
				  <td><input readonly="readonly" type="text" style="border:none; color:#FF0000; font-weight:bold;"  name="moneyConfirm" id="moneyConfirm" size="60" maxlength="255" value="">
				  </td>
				</tr>
				
				<tr>
				  <td class="key"><label for="name"> Diễn giải: </label>
				  </td>
				  <td>
				  <textarea name="description" cols="50" rows="3"></textarea>
				  </td>
				</tr>
                
				<tr>
				<td></td>
				<td> <input type="button" onclick="return mysubmit();" value="Lưu" name="rechargeSubmit"></td>
				</tr>
				
			  </tbody>
			</table>
			</fieldset>
		 <input name="submit_form" type="hidden" value="1" />
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
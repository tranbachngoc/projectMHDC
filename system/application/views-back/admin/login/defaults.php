<?php $this->load->view('admin/common/header'); ?>
<!--[if ie]>
<link type="text/css" rel="stylesheet" href="css/ie.css" />
<![endif]-->
<tr>
    <td valign="top">
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
   myfield.form.submit();
   return false;
   }
else
   return true;
}
//-->
</SCRIPT>
        <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
            <tr>
                <td width="2"></td>
                <td width="10" class="left_main" valign="top"></td>
                <td align="center" valign="top">
                    <!--BEGIN: Main-->
                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center">
                                <table class="table_login" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="20" height="20" class="corner_lt_post"></td>
                                        <td height="20" class="top_post"></td>
                                        <td width="20" height="20" class="corner_rt_post"></td>
                                    </tr>
                                    <tr>
                                        <td width="20" class="left_post"></td>
                                        <td align="center" valign="top">
                                            <!--BEGIN: Content-->
                                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td><img src="<?php echo base_url(); ?>templates/admin/images/item_login.jpg" border="0" /></td>
                                                    <td>
                                                        <table width="96%" height="110" cellpadding="0" cellspacing="0" border="0">
                                                            <form name="frmLogin" method="post">
                                                            <tr>
                                                                <td height="20" class="valid_message_login" colspan="2">
                                                                    <?php if($errorLogin == true){ ?>
                                                                    <?php echo $this->lang->line('valid_message_login'); ?>
                                                                    <?php } ?>
																</td>
															</tr>
                                                            <tr>
                                                                <td class="title_login"><?php echo $this->lang->line('username_login'); ?>: </td>
                                                                <td >
                                                                    <input type="text" onKeyPress="return submitenter(this,event)" name="usernameLogin" id="usernameLogin" value="" maxlength="35" class="input_login" onfocus="ChangeStyle('usernameLogin',1)" onblur="ChangeStyle('usernameLogin',2)" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="title_login"><?php echo $this->lang->line('password_login'); ?>: </td>
                                                                <td>
                                                                    <input type="password" onKeyPress="return submitenter(this,event)" name="passwordLogin" id="passwordLogin" value="" maxlength="35" class="input_login" onfocus="ChangeStyle('passwordLogin',1)" onblur="ChangeStyle('passwordLogin',2)" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td align="right"><input type="button" name="login" value="<?php echo $this->lang->line('login_login'); ?>" onclick="CheckLogin()" class="button_login" /></td>
                                                            </tr>
                                                            </form>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
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
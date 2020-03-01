<?php $this->load->view('home/common/header'); ?>
    <div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/him.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
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
   CheckInput_editTraLoi();
   return false;
   }
else
   return true;
}
//-->
</SCRIPT>

<?phps
if($_SERVER['HTTP_REFERER']!=base_url()."hoidap/post")
{
	$_SESSION['trangtruoc_hoidap']=$_SERVER['HTTP_REFERER'];
}
?>
<div class="col-lg-9 col-md-9 col-sm-8">
    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <div class="tile_modules tile_modules_blue">
                <div class="fl"></div>
                <div class="fc">
					Sửa phản hồi hỏi đáp
                </div>
                <div class="fr"></div>
                </div>
            </td>
        </tr>
        <tr>
            <td   valign="top" >
            	
                <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                    <?php if($successPostHds != "1"){ ?>
                    	<form name="frmPostHds" method="post">
                        <tr height="35">
                            <td style="width:25%;" valign="top" class="list_post">Tiêu đề câu hỏi :</td>
                            <td>
                            <span style="color:#E86402 ; font-weight:bold;">
                               <?php echo $hds_title ;?>
                               </span>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%;" valign="top" class="list_post">Nội dung phản hồi :</td>
                            <td>
                                <?php $this->load->view('admin/common/tinymce'); ?>                                      
                                <textarea name="txtContent" id="txtContent" style="width:500px">
                                
                                <?php echo $answers_content ?>
                                </textarea>
                            </td>
                        </tr>                        
                        <tr>
                            <td style="width:25%;" valign="middle" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('captcha_main'); ?>:
                            </td>
                            <td align="left" style="padding-top:7px;">
                                <img src="<?php echo $imageCaptchaPostHds; ?>" width="151" height="30" /><br />
                                <input type="text" name="captcha_hds" id="captcha_hds" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_ads',1);" onblur="ChangeStyle('captcha_ads',2);"  onKeyPress="return submitenter(this,event)" />
                                <input type="hidden" id="captcha" name="captcha" value="<?php echo $captcha;?>"/>
                                <input type="hidden" id="isPostHds" name="isPostHds" value=""/>
                            </td>
                        </tr>
                        <tr height="50">
                        	<td></td>
                        	<td>
               	<input type="button" onclick="CheckInput_editTraLoi();" name="submit_posthds" value="Thực hiện" class="button_form" />
                                <input type="reset" name="reset_posthds" value="Làm lại" class="button_form" />
                            </td>
                        </tr>
                        </form>
                    <?php }else{ ?>
                    <tr>
                        <td class="success_post">
                            <p class="text-center"><a href="<?php echo base_url(); ?>account/traloi">Click vào đây để tiếp tục</a></p>
                            Thực hiện thành công
						</td>
					</tr>
                    <?php } ?>
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
<!--END LEFT-->
<?php $this->load->view('home/common/footer'); ?>
<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div id="main">
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
   CheckInput_PostHds();
   return false;
   }
else
   return true;
}
//-->
</SCRIPT>

<?php
if($_SERVER['HTTP_REFERER']!=base_url()."hoidap/post")
{
	$_SESSION['trangtruoc_hoidap']=$_SERVER['HTTP_REFERER'];
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
            <td valign="top" >
            	<?php if($successPostHds == false){ ?>
                <div class="note_post">
                    <img src="<?php echo base_url(); ?>templates/home/images/note_post.gif" border="0" width="20" height="20" />&nbsp;
                    <b><font color="#FD5942"><?php echo $this->lang->line('note_help'); ?>:</font></b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <font color="#FF0000"><b>*</b></font>&nbsp;&nbsp;<?php echo $this->lang->line('must_input_help'); ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" />&nbsp;&nbsp;<?php echo $this->lang->line('input_help'); ?>
                </div>
                <?php } ?>
                <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0">
                    <?php if($successPostHds == false){ ?>
                    	<form name="frmPostHds" method="post">
                        <tr>
                        	<td style="width:25%;" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> Danh mục:</td>
                        	<td>
                            	<div id="hoidap_0" style="float: left; display: inline;">
                                	<select id="hd_select_0" class="form_control_hoidap_select" onclick="check_hoidap(this.value,0,'<?php echo base_url(); ?>');" size="14">
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
                            </td>
                        </tr>
                        
                        <tr height="35">
                            <td style="width:25%;" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('title_post_post'); ?>:</td>
                            <td>
                                <input type="text" value="<?php if(isset($title_hds)){echo $title_hds;} ?>" name="title_hds" id="title_hds" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_hds',1)" onblur="ChangeStyle('title_hds',2)" />
                            </td>
                        </tr>
                        <tr>
                            <td style="width:25%;" valign="top" class="list_post"><?php echo $this->lang->line('txtcontent_label_post'); ?>:</td>
                            <td>
                                <?php $this->load->view('admin/common/tinymce'); ?>                                      
                                <textarea name="txtContent" id="txtContent" style="width:500px">
                                </textarea>
                            </td>
                        </tr>
                        
                        
                        <tr height="35" style="display:none;">
                            <td style="width:25%;" valign="top" class="list_post"><font color="#FF0000"><b>*</b></font> <?php echo $this->lang->line('poster_post'); ?>:</td>
                            <td>
                                <input type="text" value="<?php if(isset($fullname_ads)){echo $fullname_ads;} ?>" name="username_hds" id="username_hds" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_hds',1)" onblur="ChangeStyle('title_hds',2)" />
                            </td>
                        </tr>
                        <tr height="35">
                            <td style="width:25%;" valign="top" class="list_post"><?php echo $this->lang->line('email_post'); ?>:</td>
                            <td>
                                <input type="text" value="<?php if(isset($email_ads)){echo $email_ads;} ?>" name="user_email_hds" id="user_email_hds" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_hds',1)" onblur="ChangeStyle('title_hds',2)" />
                            </td>
                        </tr>
                        <tr height="35">
                            <td style="width:25%;" valign="top" class="list_post"><?php echo $this->lang->line('yahoo_post'); ?>:</td>
                            <td>
                                <input type="text" value="<?php if(isset($yahoo_ads)){echo $yahoo_ads;} ?>" name="user_yahoo_hds" id="user_yahoo_hds" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_hds',1)" onblur="ChangeStyle('title_hds',2)" />
                            </td>
                        </tr>
                        <tr height="35">
                            <td style="width:25%;" valign="top" class="list_post"><?php echo $this->lang->line('skype_post'); ?>:</td>
                            <td>
                                <input type="text" value="<?php if(isset($skype_ads)){echo $skype_ads;} ?>" name="user_skype_hds" id="user_skype_hds" maxlength="80" class="input_formpost" onkeyup="BlockChar(this,'SpecialChar')" onfocus="ChangeStyle('title_hds',1)" onblur="ChangeStyle('title_hds',2)" />
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
               	<input type="button" onclick="CheckInput_PostHds();" name="submit_posthds" value="<?php echo $this->lang->line('button_agree_post'); ?>" class="button_form" />
                                <input type="reset" name="reset_posthds" value="<?php echo $this->lang->line('button_reset_post'); ?>" class="button_form" />
                            </td>
                        </tr>
                        </form>
                    <?php }else{ ?>
                    <tr>
                        <td class="success_post">
                            <p class="text-center"><a href="<?php echo $_SESSION['trangtruoc_hoidap']; ?>">Click vào đây để tiếp tục</a></p>
                            <?php echo $this->lang->line('success_post'); ?>
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
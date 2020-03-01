<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>

<!--BEGIN: CENTER-->
<td valign="top">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 0  10px;">
        <?php $this->load->view('home/advertise/center1'); ?>
        <tr>
            <td height="30">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h3><?php echo $this->lang->line('title_detail'); ?></h3>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td >
                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" valign="top">
                            <table width="99%" class="tbl_detail" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="image_view_detail_top">
                                        <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center">
                                                    <a href="<?php echo base_url(); ?>media/images/ads/<?php echo $ads->ads_dir; ?>/<?php echo show_image($ads->ads_image); ?>" rel="lightbox">
                                                        <img src="<?php echo base_url(); ?>media/images/ads/<?php echo $ads->ads_dir; ?>/<?php echo show_thumbnail($ads->ads_dir, $ads->ads_image, 3, 'ads'); ?>" id="image_detail" />
                                                    </a>
                                                    <div id="click_view">
                                                        <?php if($ads->ads_image != 'none.gif'){ ?>
                                                        (<?php echo $this->lang->line('click_image_detail'); ?>)
                                                        <?php }else{ ?>
                                                        (<?php echo $this->lang->line('none_image_detail'); ?>)
                                                        <?php } ?>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="7" valign="top"></td>
                                    <td rowspan="2" class="info_view_detail" valign="top">
                                        <div id="title_detail">
                                            <?php echo $ads->ads_title; ?>
                                        </div>
                                        <table border="0" cellpadding="0" cellspacing="5" align="left">
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('place_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><?php if($placeSaleIsShop == true){ ?><a class="menu_1" href="<?php echo base_url(); ?><?php echo $shop->sho_link; ?>" target="_blank" alt="<?php echo $shop->sho_descr; ?>"><?php echo $shop->sho_name; ?></a><?php }elseif(count($province) == 1){echo $province->pre_name;} ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('address_detail'); ?>:</td>
                                                <td class="content_list_detail"><?php echo $ads->ads_address; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('phone_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><?php echo $ads->ads_phone; ?><?php if(trim($ads->ads_phone) != '' && trim($ads->ads_mobile) != ''){echo ' - ';} ?><?php echo $ads->ads_mobile; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width="70" class="list_detail"><?php echo $this->lang->line('email_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><a class="menu" href="mailto:<?php echo $ads->ads_email; ?>"><img src="<?php echo base_url(); ?>templates/home/images/mail.gif" border="0" />&nbsp;<?php echo $ads->ads_email; ?></a></b></td>
                                            </tr>
                                            <tr>
                                                <td width="70" class="list_detail"><?php echo $this->lang->line('yahoo_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><a class="menu" href="ymsgr:SendIM?<?php echo $ads->ads_yahoo; ?>"><img class="list_ten" alt="yahoo status" src="http://opi.yahoo.com/online?u=<?php echo $ads->ads_yahoo; ?>;m=g;t=5;l=us" border="0" />&nbsp;<?php echo $ads->ads_yahoo; ?></a></b></td>
                                            </tr>
                                            <tr>
                                                <td width="70" class="list_detail"><?php echo $this->lang->line('skype_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><a class="menu" href="skype:<?php echo $ads->ads_skype; ?>?Chat"><img class="list_ten" alt="skype status" src="http://mystatus.skype.com/smallicon/<?php echo $ads->ads_skype; ?>" style="border: none;"/>&nbsp;<?php echo $ads->ads_skype; ?></a></b></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('poster_detail'); ?>:</td>
                                                <td class="content_list_detail"><?php echo $ads->ads_poster; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('post_date_detail'); ?>:</td>
                                                <td class="content_list_detail"><?php echo date('d-m-Y', $ads->ads_begindate); ?></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('view_detail'); ?>:</td>
                                                <td class="content_list_detail"><?php echo $ads->ads_view; ?></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr height="100%">
                                    <td class="image_view_detail_bottom" valign="bottom">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td height="25" valign="middle" style="padding-right:3px;"><a onclick="Favorite('frmOneFavorite', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" href="#Favorite"><img src="<?php echo base_url(); ?>templates/home/images/icon_favorite_detail.gif" border="0" alt="<?php echo $this->lang->line('favorite_tip_detail'); ?>" /></a></td>
                                                <div style="display:none;"><form name="frmOneFavorite" method="post"><input type="hidden" name="checkone" value="<?php echo $ads->ads_id; ?>" /></form></div>
                                                <td width="90%" align="left" valign="middle">
                                                    <a class="menu_1" onclick="Favorite('frmOneFavorite', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" href="#Favorite" alt="<?php echo $this->lang->line('favorite_tip_detail'); ?>">
                                                        <?php echo $this->lang->line('favorite_detail'); ?>
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="7" valign="top"></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" valign="top">
                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" background="<?php echo base_url(); ?>templates/home/images/bg_detailtabads.jpg" height="26">
                                       <div class="TabView" id="TabView">
                                           <div class="Tabs" style="width: 560px;">
                                               <a onclick="OpenTabAds(1);"><?php echo $this->lang->line('tab_detail_detail'); ?></a>
                                               <a onclick="OpenTabAds(2);"><?php echo $this->lang->line('tab_comment_detail'); ?></a>
                                            </div>
                                        </div>
                                        <?php if((isset($isViewComment) && $isViewComment == true) || (isset($isReply) && $isReply == true) || (isset($successReplyAds) && $successReplyAds == true)){ ?>
                                        <script>
											function tabview_initialize_2(TabViewId) { tabview_aux(TabViewId,  2); }
											$(document).ready(function() {
												tabview_initialize_2('TabView');
											 });
										</script>
                                        <?php }else{ ?>
                                        <script type="text/javascript">
										
										jQuery(document).ready(function() {
										tabview_initialize('TabView');
                                        
                                        });</script>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </table>
                            <div id="DivContentDetail"><?php echo $this->bbcode->light($ads->ads_detail); ?></div>
                            <div id="DivReplyDetail">
                                <table width="500" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <?php foreach($comment as $commentArray){ ?>
                                    <tr>
                                        <td height="10"></td>
                                    </tr>
                                    <tr>
                                        <td height="50" class="header_reply">
                                            <div class="title_reply"><?php echo $commentArray->adc_title; ?> <span class="time_reply">(<?php echo $this->lang->line('time_comment_detail'); ?> <?php echo date('H\h:i', $commentArray->adc_date); ?> <?php echo $this->lang->line('date_comment_detail'); ?> <?php echo date('d-m-Y', $commentArray->adc_date); ?>)</span></div>
                                            <div class="author_reply"><font color="#999999"><?php echo $this->lang->line('poster_comment_detail'); ?>:</font> <?php echo $commentArray->use_fullname; ?> <span class="email_reply"><a class="menu_1" href="mailto:<?php echo $commentArray->use_email; ?>">(<?php echo $commentArray->use_email; ?>)</a></span></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content_reply"><?php echo nl2br($commentArray->adc_comment); ?></td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="show_page" style="padding-right:1px;"><?php echo $cLinkPage; ?></td>
                                    </tr>
                                </table>
                                <table width="500" class="form_main" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="20" class="form_top"></td>
                                    </tr>
                                    <form name="frmReply" method="post">
                                    <tr>
                                        <td valign="top">
                                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                                <tr>
                                                    <td colspan="2" height="15"></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('title_comment_detail'); ?>:</td>
                                                    <td align="left"><input type="text" name="title_reply" id="title_reply" value="<?php if(isset($title_reply)){echo $title_reply;} ?>" maxlength="40" class="input_form" onfocus="ChangeStyle('title_reply',1);" onblur="ChangeStyle('title_reply',2);" /><?php echo form_error('title_reply'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('content_comment_detail'); ?>:</td>
                                                    <td align="left"><textarea name="content_reply" id="content_reply" cols="50" rows="7" class="textarea_form" onfocus="ChangeStyle('content_reply',1);" onblur="ChangeStyle('content_reply',2);"><?php if(isset($content_reply)){echo $content_reply;} ?></textarea><?php echo form_error('content_reply'); ?></td>
                                                </tr>
                                                <?php if(isset($imageCaptchaReplyAds)){ ?>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('captcha_main'); ?>:</td>
                                                    <td align="left">
                                                        <img src="<?php echo $imageCaptchaReplyAds; ?>" width="151" height="30" /><br />
                                                        <input type="text" name="captcha_reply" id="captcha_reply" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_reply',1);" onblur="ChangeStyle('captcha_reply',2);" />
                                                        <?php echo form_error('captcha_reply'); ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td height="30"></td>
                                                    <td height="30" valign="bottom" align="center">
                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td><input type="button" onclick="CheckInput_Reply('<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>');" name="submit_reply" value="<?php echo $this->lang->line('button_comment_comment_detail'); ?>" class="button_form" /></td>
                                                                <td width="15"></td>
                                                                <td><input type="reset" name="reset_reply" value="<?php echo $this->lang->line('button_reset_comment_detail'); ?>" class="button_form" /></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    </form>
                                    <tr>
                                        <td height="25" class="form_bottom"></td>
                                    </tr>
                                </table>
                            </div>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="50%" id="send_link">
                                        <a class="menu" onclick="OpenTabAds(3);" style="cursor:pointer;">
                                            <img src="<?php echo base_url(); ?>templates/home/images/send_link.png" border="0" /> <?php echo $this->lang->line('send_friend_detail'); ?>
                                        </a>
                                    </td>
                                    <td align="right" id="send_fail">
                                        <a class="menu" onclick="OpenTabAds(4);" style="cursor:pointer;">
                                            <img src="<?php echo base_url(); ?>templates/home/images/send_fail.png" border="0" /> <?php echo $this->lang->line('send_bad_detail'); ?>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <div id="DivSendLinkDetail">
                                <table width="500" class="sendlink_main" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="55" class="sendlink_topads"></td>
                                    </tr>
                                    <form name="frmSendLink" method="post">
                                    <tr>
                                        <td valign="top">
                                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                                <tr>
                                                    <td colspan="2" height="15"></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('email_sender_send_friend_detail'); ?>:</td>
                                                    <td align="left"><input type="text" name="sender_sendlink" id="sender_sendlink" value="<?php if(isset($sender_sendlink)){echo $sender_sendlink;} ?>" maxlength="50" class="input_form" onfocus="ChangeStyle('sender_sendlink',1);" onblur="ChangeStyle('sender_sendlink',2);" /><?php echo form_error('sender_sendlink'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('email_receiver_send_friend_detail'); ?>:</td>
                                                    <td align="left"><input type="text" name="receiver_sendlink" id="receiver_sendlink" value="<?php if(isset($receiver_sendlink)){echo $receiver_sendlink;} ?>" maxlength="50" class="input_form" onfocus="ChangeStyle('receiver_sendlink',1);" onblur="ChangeStyle('receiver_sendlink',2);" /><?php echo form_error('receiver_sendlink'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('title_send_friend_detail'); ?>:</td>
                                                    <td align="left"><input type="text" name="title_sendlink" id="title_sendlink" value="<?php if(isset($title_sendlink)){echo $title_sendlink;} ?>" maxlength="80" class="input_form" onfocus="ChangeStyle('title_sendlink',1);" onblur="ChangeStyle('title_sendlink',2);" /><?php echo form_error('title_sendlink'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('message_send_friend_detail'); ?>:</td>
                                                    <td align="left"><textarea name="content_sendlink" id="content_sendlink" cols="50" rows="7" class="textarea_form" onfocus="ChangeStyle('content_sendlink',1);" onblur="ChangeStyle('content_sendlink',2);"><?php if(isset($content_sendlink)){echo $content_sendlink;} ?></textarea><?php echo form_error('content_sendlink'); ?></td>
                                                </tr>
                                                <?php if(isset($imageCaptchaSendFriendAds)){ ?>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('captcha_main'); ?>:</td>
                                                    <td align="left">
                                                        <img src="<?php echo $imageCaptchaSendFriendAds; ?>" width="151" height="30" /><br />
                                                        <input type="text" name="captcha_sendlink" id="captcha_sendlink" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_sendlink',1);" onblur="ChangeStyle('captcha_sendlink',2);" />
                                                        <?php echo form_error('captcha_sendlink'); ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td height="30"></td>
                                                    <td height="30" valign="bottom" align="center">
                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td><input type="button" onclick="CheckInput_SendLink();" name="submit_sendlink" value="<?php echo $this->lang->line('button_send_send_friend_detail'); ?>" class="button_form" /></td>
                                                                <td width="15"></td>
                                                                <td><input type="reset" name="reset_sendlink" value="<?php echo $this->lang->line('button_reset_send_friend_detail'); ?>" class="button_form" /></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    </form>
                                    <tr>
                                        <td height="32" class="sendlink_bottom"></td>
                                    </tr>
                                </table>
                            </div>
                            <div id="DivSendFailDetail">
                                <table class="sendfail_main" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="55" class="sendfail_topads"></td>
                                    </tr>
                                    <form name="frmSendFail" method="post">
                                    <tr>
                                        <td valign="top">
                                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                                <tr>
                                                    <td colspan="2" height="15"></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('email_sender_send_bad_detail'); ?>:</td>
                                                    <td align="left"><input type="text" name="sender_sendfail" id="sender_sendfail" value="<?php if(isset($sender_sendfail)){echo $sender_sendfail;} ?>" maxlength="50" class="input_form" onfocus="ChangeStyle('sender_sendfail',1);" onblur="ChangeStyle('sender_sendfail',2);" /><?php echo form_error('sender_sendfail'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('title_send_bad_detail'); ?>:</td>
                                                    <td align="left"><input type="text" name="title_sendfail" id="title_sendfail" value="<?php if(isset($title_sendfail)){echo $title_sendfail;} ?>" maxlength="80" class="input_form" onfocus="ChangeStyle('title_sendfail',1);" onblur="ChangeStyle('title_sendfail',2);" /><?php echo form_error('title_sendfail'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('content_send_bad_detail'); ?>:</td>
                                                    <td align="left"><textarea name="content_sendfail" id="content_sendfail" cols="50" rows="7" class="textarea_form" onfocus="ChangeStyle('content_sendfail',1);" onblur="ChangeStyle('content_sendfail',2);"><?php if(isset($content_sendfail)){echo $content_sendfail;} ?></textarea><?php echo form_error('content_sendfail'); ?></td>
                                                </tr>
                                                <?php if(isset($imageCaptchaSendFailAds)){ ?>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('captcha_main'); ?>:</td>
                                                    <td align="left">
                                                        <img src="<?php echo $imageCaptchaSendFailAds; ?>" width="151" height="30" /><br />
                                                        <input type="text" name="captcha_sendfail" id="captcha_sendfail" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_sendfail',1);" onblur="ChangeStyle('captcha_sendfail',2);" />
                                                        <?php echo form_error('captcha_sendfail'); ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td height="30"></td>
                                                    <td height="30" valign="bottom" align="center">
                                                        <table border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td><input type="button" onclick="CheckInput_SendFail('<?php if(isset($isSendedOneFail) && $isSendedOneFail == true){echo $this->lang->line('is_sended_one_message_detail');}else{echo 1;} ?>');" name="submit_sendfail" value="<?php echo $this->lang->line('button_send_send_bad_detail'); ?>" class="button_form" /></td>
                                                                <td width="15"></td>
                                                                <td><input type="reset" name="reset_sendfail" value="<?php echo $this->lang->line('button_reset_send_bad_detail'); ?>" class="button_form" /></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    </form>
                                    <tr>
                                        <td height="32" class="sendfail_bottom"></td>
                                    </tr>
                                </table>
                            </div>
                            <?php if(isset($isViewComment) && $isViewComment == true){ ?>
                            <script type="text/javascript">OpenTabAds(2);</script>
                            <?php }else{ ?>
                            <script type="text/javascript">OpenTabAds(1);</script>
                            <?php } ?>
                            <?php if((isset($isReply) && $isReply == true) || (isset($successReplyAds) && $successReplyAds == true)){ ?>
                            <script>OpenTabAds(2);</script>
                            <?php }elseif(isset($isSendFriend) && $isSendFriend == true){ ?>
                            <script>OpenTabAds(3);</script>
                            <?php }elseif(isset($isSendFail) && $isSendFail == true){ ?>
                            <script>OpenTabAds(4);</script>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
       <!-- <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_bottomkhung.png" height="16" ></td>
        </tr>-->
        <tr>
            <td height="5"></td>
		</tr>
        <?php $this->load->view('home/advertise/bottom'); ?>
        <?php if(count($userAds) > 0){ ?>
        <tr>
            <td height="30">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h3><?php echo $this->lang->line('title_relate_user_ads_detail'); ?></h3>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td height="29">

                <table align="center" width="100%" height="29" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="title_boxads_1" style="border:1px dotted #C7C7C7; border-top:none;" >
                            <div style="float:left; margin-left:10px;"><?php echo $this->lang->line('title_list'); ?></div>
                            <div style="float:right; margin-right:10px;">
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            </div>
                        </td>
                        <td width="110" class="title_boxads_1" style="border-bottom:1px dotted #C7C7C7; border-right:1px dotted #C7C7C7;">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="110" class="title_boxads_1" style="border-bottom:1px dotted #C7C7C7; border-right:1px dotted #C7C7C7;">
                            <?php echo $this->lang->line('place_ads_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>place/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>place/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td >
               <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($userAds as $userAdsArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowAdsUser_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowAdsUser_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowAdsUser_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="28" height="32" class="line_boxads_1" style="border-left: 1px solid #D4EDFF"><img src="<?php echo base_url(); ?>templates/home/images/icon_tieude.gif" /></td>
                        <td height="32" class="line_boxads_1"><a class="menu" href="<?php echo base_url(); ?>ads/category/detail/<?php echo $userAdsArray->ads_category; ?>/<?php echo $userAdsArray->ads_id; ?>/<?php echo RemoveSign($userAdsArray->ads_title); ?>" onmouseover="ddrivetip('<?php echo $userAdsArray->ads_descr; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo sub($userAdsArray->ads_title, 60); ?></a>&nbsp;<span class="number_view">(<?php echo $userAdsArray->ads_view; ?>)</span>&nbsp;</td>
                        <td width="110" height="32" class="line_boxads_2"><?php echo date('d-m-Y', $userAdsArray->ads_begindate); ?></td>
                        <td width="110" height="32" class="line_boxads_3" style="border-right: 1px solid #D4EDFF;"><?php echo $userAdsArray->pre_name; ?></td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" class="post_boxads"><img src="<?php echo base_url(); ?>templates/home/images/icon_postboxads.gif" onclick="ActionLink('<?php echo base_url(); ?>ads/post')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" class="sort_boxads">
                            <select name="select_sort" class="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_asc_by_view_detail'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_desc_by_view_detail'); ?></option>
                            </select>
                        </td>
                        <td width="37%" class="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <?php } ?>
        <?php if(count($categoryAds) > 0){ ?>
        <tr>
            <td height="30">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h3><?php echo $this->lang->line('title_relate_category_ads_detail'); ?></h3>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td height="29">
                <table align="center" width="100%" height="29" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="title_boxads_1" style="border:1px dotted #C7C7C7; border-top:none;">
                            <?php echo $this->lang->line('title_list'); ?>
                        </td>
                        <td width="110" class="title_boxads_1" style="border-bottom:1px dotted #C7C7C7; border-right:1px dotted #C7C7C7;">
                            <?php echo $this->lang->line('date_post_list'); ?>
                        </td>
                        <td width="110" class="title_boxads_1" style="border-bottom:1px dotted #C7C7C7; border-right:1px dotted #C7C7C7;">
                            <?php echo $this->lang->line('place_ads_list'); ?>
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td >
              <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($categoryAds as $categoryAdsArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowAdsCategory_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowAdsCategory_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowAdsCategory_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="28" height="32" class="line_boxads_1" style="border-left: 1px solid #D4EDFF"><img src="<?php echo base_url(); ?>templates/home/images/icon_tieude.gif" /></td>
                        <td height="32" class="line_boxads_1"><a class="menu" href="<?php echo base_url(); ?>ads/category/detail/<?php echo $categoryAdsArray->ads_category; ?>/<?php echo $categoryAdsArray->ads_id; ?>/<?php echo RemoveSign($categoryAdsArray->ads_title); ?>" onmouseover="ddrivetip('<?php echo $categoryAdsArray->ads_descr; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo sub($categoryAdsArray->ads_title, 60); ?></a>&nbsp;<span class="number_view">(<?php echo $categoryAdsArray->ads_view; ?>)</span>&nbsp;</td>
                        <td width="110" height="32" class="line_boxads_2"><?php echo date('d-m-Y', $categoryAdsArray->ads_begindate); ?></td>
                        <td width="110" height="32" class="line_boxads_3" style="border-right: 1px solid #D4EDFF;"><?php echo $categoryAdsArray->pre_name; ?></td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" class="post_boxads"><img src="<?php echo base_url(); ?>templates/home/images/icon_postboxads.gif" onclick="ActionLink('<?php echo base_url(); ?>ads/post')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" class="sort_boxads"></td>
                        <td width="37%" class="show_page"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php } ?>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($successFavoriteAds) && $successFavoriteAds == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_favorite_detail'); ?>');</script>
<?php }elseif(isset($successReplyAds) && $successReplyAds == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_reply_detail'); ?>');</script>
<?php }elseif(isset($successSendFriendAds) && $successSendFriendAds == true){ ?>
<script>alert('<?php echo $this->lang->line('success_send_friend_detail'); ?>');</script>
<?php }elseif(isset($successSendFailAds) && $successSendFailAds == true){ ?>
<script>alert('<?php echo $this->lang->line('success_send_fail_detail'); ?>');</script>
<?php } ?>
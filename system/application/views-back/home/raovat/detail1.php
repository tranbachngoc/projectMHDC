<?php $this->load->view('home/common/header'); ?>


<!--BEGIN: CENTER-->
<td valign="top">
<div class="navigate">
            	
                <div class="bgrumQ" >      
                    <?php if($CategorysiteGlobalRoot->cat_id=="") { ?>
                    
                    <?php } ?> 
                    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/move/views-home-raovat-detail.css" />
                        <div class="bgrumQHome">
                	<a href="<?php echo base_url() ?>" class="home">Home</a>     
                     <img src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif" alt="" />
                     </div>    
                     	<div id="sub_cateory_bgrum">
                           	<a href="<?php echo base_url(); ?>raovat">
                           Rao vặt
                           <img alt=""  src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>
                           </a>
                        </div>
                    
                          <div class="sub_cateory_bgrum"> 
                            <?php echo $raovat_sub_rum; ?>
                        </div>
             
                      <?php if(isset($CategorysiteGlobalRoot->cat_id)) { ?>
          			<div id="CategorysiteGlobalRoot" >
                         
                    <a href="<?php echo base_url()?>raovat/<?php echo $CategorysiteGlobalRoot->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobalRoot->cat_name);?>"><?php echo trim(mb_substr($CategorysiteGlobalRoot->cat_name,0,20,'UTF-8')); ?></a>
                     <?php if(isset($CategorysiteRootConten)) { ?>
                      <div class="CategorysiterootConten">
                    	<?php echo $CategorysiteRootConten; ?>
                    </div>
                    <?php } ?> 
                    
                       <?php if($CategorysiteRootConten!="") { ?>						       
                                <img  alt="" src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>
                         <?php } else {?>
                          <img src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif" alt="" />
                         <?php 
                         }
                         ?> 
                         </div>
                 <?php    } ?>
                
                 
                 
                    <?php if(isset($CategorysiteGlobal->cat_id)) { ?>             
                	<div id="CategorysiteGlobal">
                    <a  href="<?php echo base_url()?>raovat/<?php echo $CategorysiteGlobal->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobal->cat_name);?>"><?php echo $CategorysiteGlobal->cat_name; ?></a>                    
                     <?php if(isset($CategorysiteGlobalConten)) { ?>
                      <div class="CategorysiteGlobalConten">
                    	<?php echo $CategorysiteGlobalConten; ?>
                    </div>
                    <?php } ?>  
                    
                    <?php if($CategorysiteGlobalConten!="") { ?>						       
                           <img alt=""  src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>
                         <?php } else {?>
                          <img src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif" alt="" />
                         <?php 
                         }
                         ?>                           
                         </div>
                 <?php    } ?>
                 
                    <?php if(isset($siteGlobal->cat_id)) { ?>   
                    <div <?php if($shop_glonal_conten!="")  {  echo "id=\"shop_glonal_conten_ho\""; } ?> >          
                    <a href="<?php echo base_url()?>raovat/<?php echo $siteGlobal->cat_id; ?>/<?php echo RemoveSign($siteGlobal->cat_name);?>"><?php echo mb_substr($siteGlobal->cat_name,0,30,'UTF-8');  if(strlen($siteGlobal->cat_name)>30) { echo "....";} ?></a>
                      <?php if(isset($shop_glonal_conten)) { ?>
                      <div class="shop_glonal_conten">
                    	<?php echo $shop_glonal_conten; ?>
                    </div>
                                        
                    	<?php if($shop_glonal_conten!="") { ?>						       
                          <img alt=""  src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>
                         <?php } else {?>
                          <img src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif" alt="" />
                         <?php 
                         }
                         ?>
                          <?php } ?>
                         </div>
                 <?php    } ?>
                    
                    
          <span><?php
				
				 echo mb_substr($ads->ads_title,0,30,'UTF-8') ;
				 if(strlen($ads->ads_title)>30) { echo "....";} ?></span>
             
                 </div>
                
             </div>
             <div class="h1-styleding">
             <h1><?php echo $titleSiteGlobal; ?></h1>
             </div>  
             
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
                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0" style="table-layout:fixed">
                    <tr>
                        <td align="center" valign="top">
                            <table width="99%" class="tbl_detail" border="0" cellpadding="0" cellspacing="5">
                                <tr>
                                    <td class="image_view_detail_top">
                                        <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center">
                                                    <a href="<?php echo base_url(); ?>media/images/raovat/<?php echo $ads->ads_dir; ?>/<?php echo show_image($ads->ads_image); ?>" rel="lightbox">
                                                        <img alt="<?php echo ($ads->ads_title); ?>" src="<?php echo base_url(); ?>media/images/raovat/<?php echo $ads->ads_dir; ?>/<?php echo show_thumbnail($ads->ads_dir, $ads->ads_image, 3, 'ads'); ?>" id="image_detail" />
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
                                    
                                    <td width="100%" rowspan="2" class="info_view_detail" valign="top">
                                        <h3>
                                            <div id="title_detail">
                                                <?php echo $ads->ads_title; ?>
                                            </div>
                                        </h3>
                                        <table class="k_wraptext" border="0" cellpadding="0" cellspacing="5" align="left">
                                         <tr>
                                                <td width="70" valign="top" class="list_detail">Mã Tin:</td>
                                                <td class="content_list_detail"><b><?php echo $ads->ads_id; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('place_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><?php if(count($provinceads) == 1){echo $provinceads->pre_name;} ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width="" valign="top" class="list_detail"><?php echo $this->lang->line('address_detail'); ?>:</td>
                                                <td class="content_list_detail"><?php echo $ads->ads_address; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="" valign="top" class="list_detail"><?php echo $this->lang->line('phone_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><?php echo $ads->ads_phone; ?><?php if(trim($ads->ads_phone) != '' && trim($ads->ads_mobile) != ''){echo ' - ';} ?><?php echo $ads->ads_mobile; ?></b></td>
                                            </tr>
                                            <tr>
                                                <td width="" class="list_detail"><?php echo $this->lang->line('email_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><a class="menu" href="mailto:<?php echo $ads->ads_email; ?>"><img src="<?php echo base_url(); ?>templates/home/images/mail.gif" border="0" alt="" />&nbsp;<?php echo $ads->ads_email; ?></a></b></td>
                                            </tr>
                                            <tr>
                                                <td width="" class="list_detail"><?php echo $this->lang->line('yahoo_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><a class="menu" href="ymsgr:SendIM?<?php echo $ads->ads_yahoo; ?>"><img class="list_ten" alt="yahoo status" src="http://opi.yahoo.com/online?u=<?php echo $ads->ads_yahoo; ?>;m=g;t=5;l=us" border="0" />&nbsp;<?php echo $ads->ads_yahoo; ?></a></b></td>
                                            </tr>
                                            <tr>
                                                <td width="" class="list_detail"><?php echo $this->lang->line('skype_detail'); ?>:</td>
                                                <td class="content_list_detail"><b><a class="menu" href="skype:<?php echo $ads->ads_skype; ?>?Chat"><img class="list_ten" alt="skype status" src="http://mystatus.skype.com/smallicon/<?php echo $ads->ads_skype; ?>" style="border: none;"/>&nbsp;<?php echo $ads->ads_skype; ?></a></b></td>
                                            </tr>
                                            <tr>
                                                <td width="" valign="top" class="list_detail"><?php echo $this->lang->line('poster_detail'); ?>:</td>
                                                <td class="content_list_detail"><?php echo $ads->ads_poster; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="" valign="top" class="list_detail"><?php echo $this->lang->line('post_date_detail'); ?>:</td>
                                                <td class="content_list_detail"><?php echo date('d-m-Y', $ads->ads_begindate); ?></td>
                                            </tr>
                                            <tr>
                                                <td width="" valign="top" class="list_detail"><?php echo $this->lang->line('view_detail'); ?>:</td>
                                                <td class="content_list_detail"><?php echo $ads->ads_view; ?></td>
                                                <td>
                                                
                                                </td>
                                            </tr>
                                            <tr>
                                            <td colspan="3" >
                                            
                                            <!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style ">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fd98edf3c3558e8"></script>
<!-- AddThis Button END -->

                                            <?php /*?><div class="addthis">
                                        <div class="addThisIcon">
                                   
<div class="addThisShareFace">
<a rel="nofollow" href="http://static.vatgia.com" title="Chia sẻ qua Facebook." >
<img src="<?php echo base_url(); ?>templates/home/images/icon_facebook_share.gif" border="0"/>
</a>
</div>
       <script >
								jQuery(document).ready(function(){									
 var pathname = "http://www.facebook.com/sharer.php?u="+window.location;

									jQuery(".addThisShareFace a").attr('href',pathname);
										
								});
							</script>
                                        
</div>

  <div class="addThisIcon">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
</div>
  <div class="addThisIcon" style="width:60px;position:relative;">
<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
</div>
<div class="addThisIcon" style="width:60px; position:relative;">
<a href="https://twitter.com/share" class="twitter-share-button">Tweet</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
</div>


</div><?php */?>

<?php /*?><div style="clear:both; padding-bottom:31px;padding-top:5px">
<div class="addThisIcon">
<script type="text/javascript">
(function() {
var s = document.createElement('SCRIPT'), s1 = document.getElementsByTagName('SCRIPT')[0];
s.type = 'text/javascript';
s.async = true;
s.src = 'http://widgets.digg.com/buttons.js';
s1.parentNode.insertBefore(s, s1);
})();
</script>

<a class="DiggThisButton DiggCompact"></a>
</div>
<div class="addThisIcon">
	<script src="//platform.linkedin.com/in.js" type="text/javascript"></script>
<script type="IN/Share" data-counter="right"></script>
</div>
<div class="addThisIcon">
<a class="ultLH" title="Chia sẻ tin lên LinkHay.com" href="javascript:(function(){var d=document,f='http://linkhay.com/submit',l=d.location,e=encodeURIComponent,p='?url='+e(l.href)+'&title='+e(d.title)+'&utm_source=VOV&utm_medium=embedded&utm_campaign=lh_button';if(!window.open(f+p,'sharer','toolbar=0,status=0,resizable=1,width=800,height=450'))l.href=f+p})();" rel="nofollow"><font color="#FF0000" style="font-weight:bold;"><img src="<?php echo base_url(); ?>templates/home/images/linkhay.png" border="0" alt="" /></font></a>
</div>

</div><?php */?>


<!--<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4fa8c3be2248d92e"></script>
                                        </div>-->
                                        <!--  them phan thanh toan-->
                                       
                                            </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                <tr height="100%">
                                    <td class="image_view_detail_bottom" valign="bottom">
                                        <table width="100%" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td height="25" valign="middle" style="padding-right:3px;"><a onclick="Favorite('frmOneFavorite', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" href="#Favorite"><img src="<?php echo base_url(); ?>templates/home/images/icon_favorite_detail.gif" border="0"  alt="" /></a></td>
                                                <div style="display:none;"><form name="frmOneFavorite" method="post"><input type="hidden" name="checkone" value="<?php echo $ads->ads_id; ?>" /></form></div>
                                                <td width="90%" align="left" valign="middle">
                                                    <a class="menu_1" onclick="Favorite('frmOneFavorite', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" href="#Favorite" title="<?php echo $this->lang->line('favorite_tip_detail'); ?>">
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
                        <td align="left" valign="top" style="word-wrap:break-word; width:100%">
                            <table border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" background="<?php echo base_url(); ?>templates/home/images/bg_detailtabads.jpg" height="26">
                                       <div class="TabView" id="TabView">
                                           <div class="Tabs" style="width: 100%;">
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
                            <div id="DivContentDetail">
							<?php $vovel=array("&curren;"); echo html_entity_decode(str_replace($vovel,"#",$ads->ads_detail));?><?php //echo $this->bbcode->light($product->pro_detail); ?>
							</div>
                            <div id="DivReplyDetail">
                                <table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
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
                                <table width="450" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <form name="frmReply" method="post">
                                    <tr>
                                        <td valign="top">
                                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                                <tr>
                                                    <td colspan="2" height="15"></td>
                                                </tr>
                                                <tr>
                                                    <td width="60" class="list_form"><?php echo $this->lang->line('title_comment_detail'); ?>:</td>
                                                    <td align="left"><input type="text" name="title_reply" id="title_reply" value="<?php if(isset($title_reply)){echo $title_reply;} ?>" maxlength="40" class="input_form" onfocus="ChangeStyle('title_reply',1);" onblur="ChangeStyle('title_reply',2);" /><?php echo form_error('title_reply'); ?></td>
                                                </tr>
                                                <tr>
                                                    <td width="60" class="list_form"><?php echo $this->lang->line('content_comment_detail'); ?>:</td>
                                                    <td align="left"><textarea name="content_reply" id="content_reply" style="width:350px; height:200px;" class="textarea_form" onfocus="ChangeStyle('content_reply',1);" onblur="ChangeStyle('content_reply',2);"><?php if(isset($content_reply)){echo $content_reply;} ?></textarea><?php echo form_error('content_reply'); ?></td>
                                                </tr>
                                                <?php if(isset($imageCaptchaReplyAds)){ ?>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('captcha_main'); ?>:</td>
                                                    <td align="left">
                                                        <img src="<?php echo $imageCaptchaReplyAds; ?>" width="151" height="30" alt="" /><br />
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
                                </table>
                            </div>
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="50%" id="send_link">
                                        <a class="menu" onclick="OpenTabAds(3);" style="cursor:pointer;">
                                            <img src="<?php echo base_url(); ?>templates/home/images/send_link.png" border="0" alt="" /> <?php echo $this->lang->line('send_friend_detail'); ?>
                                        </a>
                                    </td>
                                    <td align="right" id="send_fail">
                                        <a class="menu" onclick="OpenTabAds(4);" style="cursor:pointer;">
                                            <img src="<?php echo base_url(); ?>templates/home/images/send_fail.png" border="0" alt="" /> <?php echo $this->lang->line('send_bad_detail'); ?>
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
                                                        <img src="<?php echo $imageCaptchaSendFriendAds; ?>" width="151" height="30" alt="" /><br />
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
                                <table  class="sendfail_main" border="0" align="center" cellpadding="0" cellspacing="0">
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
                                                        <img src="<?php echo $imageCaptchaSendFailAds; ?>" width="151" height="30" alt="" /><br />
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
                    	<td width="0%">
                        </td>
                        <td class="title_boxads_1" style="border:1px dotted #C7C7C7; border-top:none; text-align:center" >
                            <?php echo $this->lang->line('title_list'); ?>
                          
                        </td>
                           <td class="title_boxads_1" style="border:1px dotted #C7C7C7; border-top:none; width:17%;"  >
                            Ngày đăng
                        </td>
                        <td  width="21%" class="title_boxads_1" style="border-bottom:1px dotted #C7C7C7; border-right:1px dotted #C7C7C7;">
                         <select name="filter-position" id="filter-position" >
                           <option value="0" <?php if($selectPlaceTruth==0){ ?>  <?php }else{ ?>selected="selected" <?php } ?> onclick="ActionSort('<?php echo base_url(); ?>raovat/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3) ?>/<?php echo $this->uri->segment(4) ?>')"  >--Tỉnh/TP--</option>
                           <?php foreach($province as $item): ?>
                           <option value="<?php echo $item->pre_id ?>" <?php if($selectPlaceTruth==$item->pre_id){ ?> selected="selected"  <?php } ?> onclick="ActionSort('<?php echo base_url(); ?>raovat/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3) ?>/<?php echo $this->uri->segment(4) ?>/<?php echo $item->pre_id ?>/thanhvien')"><?php echo $item->pre_name ?></option>
                           <?php endforeach; ?>
                           </select>
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
                        <td height="32" class="line_boxads_1" style="border-left: 1px solid #D4EDFF"><a href="<?php echo base_url(); ?>raovat/<?php echo $userAdsArray->ads_category; ?>/<?php echo $userAdsArray->ads_id; ?>/<?php echo RemoveSign($userAdsArray->ads_title); ?>" target="_parent"><img width="32" height="30" src="<?php if($userAdsArray->ads_image!=''){ ?><?php echo base_url(); ?>media/images/raovat/<?php echo $userAdsArray->ads_dir; ?>/<?php echo $userAdsArray->ads_image; ?><?php }else{ ?><?php echo base_url(); ?>media/images/avatar/default.png<?php } ?>" alt="" /></a></td>
                        <td height="32" class="line_boxads_1"><a class="menu" href="<?php echo base_url(); ?>raovat/<?php echo $userAdsArray->ads_category; ?>/<?php echo $userAdsArray->ads_id; ?>/<?php echo RemoveSign($userAdsArray->ads_title); ?>" ><?php echo sub($userAdsArray->ads_title, 60); ?></a>&nbsp;<span class="number_view">(<?php echo $userAdsArray->ads_view; ?>)</span>&nbsp; <br />
                        <?php $vovel=array("&curren;"); echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel,"#",$userAdsArray->ads_detail))),150);?>
                        
                        </td>
                        <td width="17%" height="32" class="line_boxads_2"><?php echo date('d-m-Y', $userAdsArray->ads_begindate); ?></td>
                        <td width="21%" height="32" class="line_boxads_3" style="border-right: 1px solid #D4EDFF;">
                        <a href="<?php echo base_url(); ?>raovat/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3) ?>/<?php echo $this->uri->segment(4) ?>/<?php echo $userAdsArray->pre_id;  ?>/thanhvien">
						<?php echo $userAdsArray->pre_name; ?>
                        </a>
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" class="post_boxads"><img src="<?php echo base_url(); ?>templates/home/images/icon_postboxads.gif" onclick="ActionLink('<?php echo base_url(); ?>raovat/post')" style="cursor:pointer;" border="0" alt="" /></td>
                        <td align="center" class="sort_boxads">
                            <?php /*?><select name="select_sort" class="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_asc_by_view_detail'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_desc_by_view_detail'); ?></option>
                            </select><?php */?>
                        </td>
                        <td width="37%" class="show_page"><?php //echo $linkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
       
   
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
                        <td width="17%" class="title_boxads_1" style="border-bottom:1px dotted #C7C7C7; border-right:1px dotted #C7C7C7;">
                            <?php echo $this->lang->line('date_post_list'); ?>
                        </td>
                        <td width="21%" class="title_boxads_1" style="border-bottom:1px dotted #C7C7C7; border-right:1px dotted #C7C7C7;">
                           <select name="filter-position" id="filter-position" >
                           <option value="0" <?php if($selectPlace==0){ ?>  <?php }else{ ?>selected="selected" <?php } ?> onclick="ActionSort('<?php echo base_url(); ?>raovat/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3) ?>/<?php echo $this->uri->segment(4) ?>')" >--Tỉnh/TP--</option>
                           <?php foreach($province as $item): ?>
                           <option value="<?php echo $item->pre_id ?>" <?php if($selectPlace==$item->pre_id){ ?> selected="selected"  <?php } ?> onclick="ActionSort('<?php echo base_url(); ?>raovat/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3) ?>/<?php echo $this->uri->segment(4) ?>/<?php echo $item->pre_id ?>/danhmuc')"><?php echo $item->pre_name ?></option>
                           <?php endforeach; ?>
                           </select>
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
                        <td height="32" class="line_boxads_1" style="border-left: 1px solid #D4EDFF">
                        
                        <a href="<?php echo base_url(); ?>raovat/<?php echo $categoryAdsArray->ads_category; ?>/<?php echo $categoryAdsArray->ads_id; ?>/<?php echo RemoveSign($categoryAdsArray->ads_title); ?>" target="_parent"><img width="32" height="30" src="<?php if($categoryAdsArray->ads_image!=''){ ?><?php echo base_url(); ?>media/images/raovat/<?php echo $categoryAdsArray->ads_dir; ?>/<?php echo $categoryAdsArray->ads_image; ?><?php }else{ ?><?php echo base_url(); ?>media/images/avatar/default.png<?php } ?>" alt="" /></a>
                        
                        </td>
                        <td height="32" class="line_boxads_1"><a class="menu" href="<?php echo base_url(); ?>raovat/<?php echo $categoryAdsArray->ads_category; ?>/<?php echo $categoryAdsArray->ads_id; ?>/<?php echo RemoveSign($categoryAdsArray->ads_title); ?>"<?php /*?> onmouseover="ddrivetip('<?php echo $categoryAdsArray->ads_descr; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"<?php */?>><?php echo sub($categoryAdsArray->ads_title, 60); ?></a>&nbsp; <br/>
                          <?php $vovel=array("&curren;"); echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel,"#",$categoryAdsArray->ads_detail))),150);?>                       
                       
                        <span class="number_view">(<?php echo $categoryAdsArray->ads_view; ?>)</span>&nbsp;</td>
                        <td width="17%" height="32" class="line_boxads_2"><?php echo date('d-m-Y', $categoryAdsArray->ads_begindate); ?></td>
                        <td width="21%" height="32" class="line_boxads_3" style="border-right: 1px solid #D4EDFF;">
						
						<a href="<?php echo base_url(); ?>raovat/<?php echo $this->uri->segment(2); ?>/<?php echo $this->uri->segment(3) ?>/<?php echo $this->uri->segment(4) ?>/<?php echo $categoryAdsArray->pre_id;  ?>/danhmuc">
						<?php echo $categoryAdsArray->pre_name; ?></a></td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" class="post_boxads"><img src="<?php echo base_url(); ?>templates/home/images/icon_postboxads.gif" onclick="ActionLink('<?php echo base_url(); ?>raovat/post')" style="cursor:pointer;" border="0" alt="" /></td>
                        <td align="center" class="sort_boxads"></td>
                        <td width="37%" class="show_page"></td>
                    </tr>
                </table>
            </td>
        </tr>
 
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
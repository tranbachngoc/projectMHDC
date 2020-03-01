<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<SCRIPT TYPE="text/javascript">
<!--
function submitenterCuteo(myfield,e,enterForm)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;
if (keycode == 13)
   {
	 CheckInput_SendFail('<?php if(isset($isSendedOneFail) && $isSendedOneFail == true){echo $this->lang->line('is_sended_one_message_detail');}else{echo 1;} ?>');
  
   return false;
   }
else
   return true;
}
//-->
</SCRIPT>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<!--BEGIN: CENTER-->
<td valign="top">
<div class="navigate">
    <div class="L"></div>
    <div class="C">             
        <a href="<?php echo base_url() ?>" class="home">Home</a>              
         <img alt=""  src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif"/>                   <span> <a href="<?php echo base_url(); ?>tuyendung"> Tuyển dụng</a> </span>  
           <img alt=""  src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif"/>
            <span> <a href="<?php echo base_url(); ?>tuyendung/<?php echo $this->uri->segment(2) ?>/<?php echo RemoveSign($tencongviec); ?>"> <?php echo $tencongviec; ?> </a> </span>  
           <img alt=""  src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif"/>
         <span>
            <?php echo mb_substr($titleSiteGlobal,0,30,'UTF-8');  if(strlen($titleSiteGlobal)>30) { echo "....";} ?>  
         </span>        
     </div>
     <div class="R"></div>
 </div>
 
 
 <div style="display:none;">
<p>
<div xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumbs-title">
<span typeof="v:Breadcrumb">
<a rel="v:url" property="v:title"   href="<?php echo base_url() ?>" class="home">Home</a> 
</span>

<span typeof="v:Breadcrumb">
 <a rel="v:url" property="v:title" href="<?php echo base_url(); ?>tuyendung/<?php echo $this->uri->segment(2) ?>/<?php echo RemoveSign($tencongviec); ?>" title="<?php echo $tencongviec; ?>">
 <?php echo $tencongviec; ?>
 </a>
 </span>
 

<span class="separator">»</span>
<?php echo $titleSiteGlobal;?>  
</div>
</p>
</div>

         
<div class="h1-styleding">
             <h1><?php echo $h1tagSiteGlobal; ?></h1>
             </div> 
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 0 10px;">
        <?php $this->load->view('home/advertise/center1'); ?>
        <tr id="DivField_1" style="display:none;">            
            <td height="30">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2><?php echo $this->lang->line('title_field_field'); ?></h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr id="DivField_2" style="display:none;">
            <td  valign="top">
                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td height="6" colspan="4"></td>
                    </tr>
                    <tr>
                    <?php $counter = 1; ?>
                    <?php foreach($listField as $listFieldArray){ ?>
                        <td align="left" width="25" class="icon_field"><img src="<?php echo base_url(); ?>templates/home/images/field/<?php echo $listFieldArray->fie_image; ?>" border="0" /></td>
                        <td align="left" class="list_field">
                            <a class="menu_1" href="<?php echo base_url(); ?>tuyendung/<?php echo $listFieldArray->fie_id; ?>/<?php echo RemoveSign($listFieldArray->fie_name); ?>" title="<?php echo $listFieldArray->fie_descr; ?>">
                            <?php echo $listFieldArray->fie_name; ?>
                            </a>
                        </td>
                    <?php if($counter % 2 == 0 && $counter < count($listField)){ ?>
					</tr><tr>
    				<?php } ?>
                    <?php $counter++; ?>
                    <?php } ?>
                    <?php if(count($listField) % 2 != 0){ ?>
                    <td align="left" width="25" class="icon_field"></td>
                    <td align="left" class="list_field"></td>
                    <?php } ?>
					</tr>
                </table>
            </td>
        </tr>
        <tr id="DivField_3" style="display:none;">
            <td height="16" ></td>
        </tr>
        <tr id="DivField_4" style="display:none;">
            <td height="10"></td>
		</tr>
        <tr>            
            <td height="30">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2><?php echo $this->lang->line('title_detail'); ?></h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  align="center" >
                <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                    <tr>
                        <td class="global_title_job" valign="top">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td class="title_job"><img src="<?php echo base_url(); ?>templates/home/images/icon_job.gif" border="0" />
									<?php echo $job->job_title; ?>
									<?php if((int)$job->job_reliable == 1){ ?>
									<img src="<?php echo base_url(); ?>templates/home/images/icon_reliable_job.gif" border="0" title="<?php echo $this->lang->line('reliable_tip_detail'); ?>" />
									<?php } ?>
									</td>
                                    <td width="22" align="left" valign="bottom">
                                    <div style="display:none;"><form name="frmOneFavorite" method="post"><input type="hidden" name="checkone" value="<?php echo $job->job_id; ?>" /></form></div>
                                        <a href="#Favorite" onclick="Favorite('frmOneFavorite', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" title="<?php echo $this->lang->line('favorite_tip_detail'); ?>">
											<img src="<?php echo base_url(); ?>templates/home/images/icon_favorite_detail.gif" border="0" />
										</a>
									</td>
								</tr>
							</table>
						</td>
                    </tr>
                    <tr>
                        <td height="30">
                            <div class="temp_3">
                                <div class="title">
                                    <div class="fl">
                                        <h2><?php echo $this->lang->line('subject_require_detail'); ?></h2>
                                    </div>
                                </div>
                            </div>
            			</td>
                    </tr>
                    <tr>
                        <td class="main_job">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td height="5"></td>
                                    <td height="5"></td>
								</tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('field_detail'); ?>:</td>
                                    <td class="content_detailjob"><b><a class="menu_1" href="<?php echo base_url(); ?>tuyendung/<?php echo $field->fie_id; ?>/<?php echo RemoveSign($field->fie_name); ?>" title="<?php echo $field->fie_descr; ?>"><?php echo $field->fie_name; ?> </a> <?php if($field->fie_name==""){ echo $job->job_nganhnghe_dien; } ?></b></td>
                                </tr>
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('postition_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php echo $job->job_position; ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('level_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php echo $job->job_level; ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('foreign_language_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php if(trim($job->job_foreign_language) == ''){echo $this->lang->line('none_record_detail');}else{echo $job->job_foreign_language;} ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('computer_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php if(trim($job->job_computer) == ''){echo $this->lang->line('none_record_detail');}else{echo $job->job_computer;} ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('age_detail'); ?>:</td>
                                    <?php $ageJob = explode('-', $job->job_age); ?>
                                    <td class="content_detailjob"><?php if($ageJob[0] == array_pop($ageJob)){echo $ageJob[0];}else{echo $job->job_age;} ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('sex_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php if((int)$job->job_sex == 0){echo $this->lang->line('female_detail');}elseif((int)$job->job_sex == 1){echo $this->lang->line('male_detail');}else{echo $this->lang->line('all_sex_detail');} ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('require_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php 
									
									  $vovel=array("&curren;"); echo html_entity_decode(str_replace($vovel,"#",$job->job_require)); 
									
									 ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('exper_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php echo $job_exper ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('place_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php if(count($province) == 1){echo $province->pre_name;} ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('time_job_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php echo $job->job_time_job; ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('salary_detail'); ?>:</td>
                                    <?php $salaryView = explode('|', $job->job_salary); ?>
                                    <td class="content_detailjob" style="color:#F00;"><span id="DivCostJob"></span>&nbsp;<?php echo array_pop($salaryView); ?></td>
                                    <script type="text/javascript">FormatCost('<?php echo $salaryView[0]; ?>', 'DivCostJob');</script>
                                </tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('time_try_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php echo $job->job_timetry; ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('interest_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php $vovel=array("&curren;"); echo html_entity_decode(str_replace($vovel,"#",$job->job_interest));?>
                                    
                                    </td>
                                </tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('quantity_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php echo $job->job_quantity; ?>&nbsp;<?php echo $this->lang->line('person_detail'); ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('record_detail'); ?>:</td>
                                    <td class="content_detailjob">
                   <?php $vovel=array("&curren;"); echo html_entity_decode(str_replace($vovel,"#",$job->job_record));?>                 
                                    
                                    </td>
                                </tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('time_surrend_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php echo date('d-m-Y', $job->job_enddate); ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('detail_detail'); ?>:</td>
                                    <td class="content_detailjob">
                                    <?php $vovel=array("&curren;"); echo html_entity_decode(str_replace($vovel,"#",$job->job_detail));?>
									</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="30" class="k_bottom_job"></td>
                    </tr>
                    <tr>                       
                        <td height="30">
                            <div class="temp_3">
                                <div class="title">
                                    <div class="fl">
                                        <h2><?php echo $this->lang->line('title_new_job_field'); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="main_job">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td height="5"></td>
                                    <td height="5"></td>
								</tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('jober_detail'); ?>:</td>
                                    <td class="content_detailjob"><b><?php echo $job->job_jober; ?></b></td>
                                </tr>
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('address_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php echo $job->job_address; ?></td>
                                </tr>
                                   <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob">Giới thiệu:</td>
                                    <td class="content_detailjob"><?php echo $job->job_gioithieu_nhatuyendung; ?></td>
                                </tr>
                                
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('phone_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php echo $job->job_phone; ?><?php if(trim($job->job_phone) != '' && trim($job->job_mobile) != ''){echo ' - ';} ?><?php echo $job->job_mobile; ?></td>
                                </tr>
                                  <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob">Fax:</td>
                                    <td class="content_detailjob"><?php echo $job->job_fax_nhatuyendung; ?></td>
                                </tr>
                                
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('email_detail'); ?>:</td>
                                    <td class="content_detailjob"><a class="menu_1" style="font-size:11px;" href="mailto:<?php echo $job->job_email; ?>"><b><?php echo $job->job_email; ?></b></a></td>
                                </tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('website_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php if(trim($job->job_website) == ''){echo $this->lang->line('none_record_detail');}else{ ?><a class="menu_1" href="<?php echo prep_url($job->job_website); ?>" target="_blank" title="<?php echo prep_url($job->job_website); ?>"><?php echo prep_url($job->job_website); ?></a><?php } ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="30" class="k_bottom_job"></td>
                    </tr>
                    <tr>                        
                        <td height="30">
                            <div class="temp_3">
                                <div class="title">
                                    <div class="fl">
                                        <h2><?php echo $this->lang->line('info_contact_detail'); ?></h2>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="main_job">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0" align="center">
                                <tr>
                                    <td height="5"></td>
                                    <td height="5"></td>
								</tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('name_contact_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php echo $job->job_name_contact; ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('address_contact_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php echo $job->job_address_contact; ?></td>
                                </tr>
                                 
                                
                                
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('phone_contact_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php echo $job->job_phone_contact; ?><?php if(trim($job->job_phone_contact) != '' && trim($job->job_mobile_contact) != ''){echo ' - ';} ?><?php echo $job->job_mobile_contact; ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('email_contact_detail'); ?>:</td>
                                    <td class="content_detailjob"><a class="menu_1" style="font-size:11px;" href="mailto:<?php echo $job->job_email_contact; ?>"><b><?php echo $job->job_email_contact; ?></b></a></td>
                                </tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('yahoo_detail'); ?>:</td>
                                    <td class="content_detailjob"><a class="menu_1" style="font-size:11px; font-weight:bold;" href="ymsgr:SendIM?<?php echo $job->job_yahoo; ?>"><img class="list_ten" alt="yahoo status" src="http://opi.yahoo.com/online?u=<?php echo $job->job_yahoo; ?>;m=g;t=5;l=us" border="0" />&nbsp;&nbsp;<?php echo $job->job_yahoo; ?></a></td>
                                </tr>
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('skype_detail'); ?>:</td>
                                    <td class="content_detailjob"><a class="menu_1" style="font-size:11px; font-weight:bold;" href="skype:<?php echo $job->job_skype; ?>?Chat"><img class="list_ten" alt="skype status" src="http://mystatus.skype.com/smallicon/<?php echo $job->job_skype; ?>" style="border: none;"/>&nbsp;&nbsp;<?php echo $job->job_skype; ?></a></td>
                                </tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('best_contact_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php echo $job->job_best_contact; ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_1">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('poster_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php if(count($user) == 1){echo $user->use_username;} ?></td>
                                </tr>
                                <tr class="changestyle_detail_job_2">
                                    <td width="180" class="list_detailjob"><?php echo $this->lang->line('post_date_detail'); ?>:</td>
                                    <td class="content_detailjob"><?php echo date('d-m-Y', $job->job_begindate); ?></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td height="30" class="k_bottom_job"></td>
                    </tr>

                </table>
                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td colspan="2">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="50%" id="send_link" align="left">
                                        <a class="menu" onclick="OpenTabJob(1);" style="cursor:pointer;">
                                            <img src="<?php echo base_url(); ?>templates/home/images/send_link.png" border="0" /> <?php echo $this->lang->line('send_friend_detail'); ?>
                                        </a>
                                    </td>
                                    <td align="right" id="send_fail">
                                        <a class="menu" onclick="baocaotuyendungquypham('<?php echo base_url();?>','<?php echo $job->job_id; ?>','<?php echo $this->session->userdata('sessionUser'); ?>');" style="cursor:pointer;">
                                            <img src="<?php echo base_url(); ?>templates/home/images/send_fail.png" border="0" /> <?php echo $this->lang->line('send_bad_detail'); ?>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                            <div id="DivSendLinkDetail">
                                <table width="500" class="sendlink_main" border="0" align="center" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td height="55" class="sendlink_topjob"></td>
                                    </tr>
                                    <form name="frmSendLink" method="post">
                                    <tr>
                                        <td valign="top" >
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
                                                <?php if(isset($imageCaptchaSendFriendJob)){ ?>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('captcha_main'); ?>:</td>
                                                    <td align="left">
                                                        <img src="<?php echo $imageCaptchaSendFriendJob; ?>" width="151" height="30" /><br />
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
                                        <td height="55" class="sendfail_topjob"></td>
                                    </tr>
                                    <form name="frmSendFail" method="post">
                                     <?php if($this->session->userdata('sessionUser')>0){ ?>
                                    <tr>
                                        <td valign="top" style="display:none">
                                            <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                                <tr>
                                                    <td colspan="2" height="15"></td>
                                                </tr>
                                                <tr style="display:none;">
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
                                                <?php if(isset($imageCaptchaReplyAds)){ ?>
                                                <tr>
                                                    <td width="110" class="list_form"><?php echo $this->lang->line('captcha_main'); ?>:</td>
                                                    <td align="left">
                                                        <img src="<?php echo $imageCaptchaReplyAds; ?>" width="151" height="30" alt="" /><br />
                                                        <input type="text" name="captcha_sendfail" id="captcha_sendfail" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_sendfail',1);" onblur="ChangeStyle('captcha_sendfail',2);" onKeyPress="return submitenterCuteo(this,event)" />
                                                        <?php echo form_error('captcha_sendfail'); ?>
                                                    </td>
                                                </tr>
                                                <?php } ?>
                                                <input type="hidden" value="" id="bao_cao_sai_gia" name="bao_cao_sai_gia" />
                                                 <input type="hidden" value="<?php echo $cacha; ?>" name="capcha_het_hang" id="capcha_het_hang" />
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
                                    <?php } else { ?>
                                         <div style="padding-top:10px;">
                                        	Bạn hãy <a href="<?php echo base_url() ?>login"> đăng nhập </a> để thực hiện chức năng này
                                        </div>
                                    <?php } ?>
                                    </form>
                                    
                                    <tr>
                                        <td height="32" class="sendfail_bottom"></td>
                                    </tr>
                                </table>
                            </div>
                            <?php if(isset($isSendFriend) && $isSendFriend == true){ ?>
                            <script>OpenTabJob(2);</script>
                            <?php }elseif(isset($isSendFail) && $isSendFail == true){ ?>
                            <script>OpenTabJob(1);</script>
                            <?php }else{ ?>
                            <script>OpenTabJob(0);</script>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="16" ></td>
        </tr>
        <tr>
            <td height="5"></td>
		</tr>
        <?php $this->load->view('home/advertise/bottom'); ?>
        <?php if(count($userJob) > 0){ ?>
        <tr>            
            <td height="30">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2><?php echo $this->lang->line('title_field_field'); ?></h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_tinraovat.jpg" height="29">
                <table align="center" width="100%" height="29" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td  class="title_boxads_1 k_title_boxads_1">
                            <?php echo $this->lang->line('title_list'); ?>
                            <div class="k_floatrightmarginright10">
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            </div>
                        </td>
                        <td width="110" class="title_boxads_1 k_title_boxads_1_right">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <div class="k_floatrightmarginright10">
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            </div>
                        </td>
                        <td width="130" class="title_boxads_1 k_title_boxads_1_right">
                            <?php echo $this->lang->line('place_job_list'); ?>
                            <div class="k_floatrightmarginright10">
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>place/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>place/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            </div>
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td class="k_border" >
                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($userJob as $userJobArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowJobUser_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowJobUser_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowJobUser_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="28" height="32" class="line_boxjob_1" ><img src="<?php echo base_url(); ?>templates/home/images/icon_tieudejob.gif" /></td>
                        <td style="text-align:left" height="32" class="line_boxjob_1"><a class="menu" href="<?php echo base_url(); ?>tuyendung/<?php echo $userJobArray->job_field; ?>/<?php echo $userJobArray->job_id; ?>/<?php echo RemoveSign($userJobArray->job_title); ?>" onmouseover="ddrivetip('<?php echo $this->lang->line('position_tip'); ?>&nbsp;<?php echo $userJobArray->job_position; ?><br /><?php echo $this->lang->line('time_surrend_tip'); ?>&nbsp;<?php echo date('d-m-Y', $userJobArray->job_time_surrend); ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo sub($userJobArray->job_title, 60); ?></a>&nbsp;<span class="number_view">(<?php echo $userJobArray->job_view; ?>)</span>&nbsp;</td>
                        <td width="110" height="32" class="line_boxjob_2"><?php echo date('d-m-Y', $userJobArray->job_begindate); ?></td>
                        <td width="130" height="32" class="line_boxjob_3"><?php echo $userJobArray->pre_name; ?></td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" id="post_boxjob"><img src="<?php echo base_url(); ?>templates/home/images/icon_postboxjob.gif" onclick="ActionLink('<?php echo base_url(); ?>job/post')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="sort_boxjob">
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
            <td height="16" ></td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <?php } ?>
        <?php if(count($fieldJob) > 0){ ?>
        <tr>            
            <td height="30">
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2><?php echo $this->lang->line('title_relate_field_job_detail'); ?></h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_tinraovat.jpg" height="29">
                <table align="center" width="100%" height="29" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td  class="title_boxads_1 k_title_boxads_1_right">
                            <?php echo $this->lang->line('title_list'); ?>
                        </td>
                        <td width="110" class="title_boxads_1 k_title_boxads_1_right">
                            <?php echo $this->lang->line('date_post_list'); ?>
                        </td>
                        <td width="130" class="title_boxads_1 k_title_boxads_1_right">
                            <?php echo $this->lang->line('place_job_list'); ?>
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td class="k_border" >
                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($fieldJob as $fieldJobArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowJobField_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowJobField_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowJobField_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="28" height="32" class="line_boxjob_1" ><img src="<?php echo base_url(); ?>templates/home/images/icon_tieudejob.gif" /></td>
                        <td style="text-align:left" height="32" class="line_boxjob_1"><a class="menu" href="<?php echo base_url(); ?>tuyendung/<?php echo $fieldJobArray->job_field; ?>/<?php echo $fieldJobArray->job_id; ?>/<?php echo RemoveSign($fieldJobArray->job_title); ?>" onmouseover="ddrivetip('<?php echo $this->lang->line('position_tip'); ?>&nbsp;<?php echo $fieldJobArray->job_position; ?><br /><?php echo $this->lang->line('time_surrend_tip'); ?>&nbsp;<?php echo date('d-m-Y', $fieldJobArray->job_time_surrend); ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo sub($fieldJobArray->job_title, 60); ?></a>&nbsp;<span class="number_view">(<?php echo $fieldJobArray->job_view; ?>)</span>&nbsp;</td>
                        <td width="110" height="32" class="line_boxjob_2"><?php echo date('d-m-Y', $fieldJobArray->job_begindate); ?></td>
                        <td width="130" height="32" class="line_boxjob_3"><?php echo $fieldJobArray->pre_name; ?></td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" id="post_boxjob"><img src="<?php echo base_url(); ?>templates/home/images/icon_postboxjob.gif" onclick="ActionLink('<?php echo base_url(); ?>job/post')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="sort_boxjob"></td>
                        <td width="37%" class="show_page"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="16" ></td>
        </tr>
        <?php } ?>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($successFavoriteJob) && $successFavoriteJob == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_favorite_detail'); ?>');</script>
<?php }elseif(isset($successSendFriendJob) && $successSendFriendJob == true){ ?>
<script>alert('<?php echo $this->lang->line('success_send_friend_detail'); ?>');</script>
<?php }elseif(isset($successSendFailJob) && $successSendFailJob == true){ ?>
<script>alert('<?php echo $this->lang->line('success_send_fail_detail'); ?>');</script>
<?php } ?>
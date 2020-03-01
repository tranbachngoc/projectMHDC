<?php $this->load->view('home/common/header'); ?>
    <div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<link type="text/css" href="<?php echo base_url(); ?>templates/home/css/datepicker.css" rel="stylesheet" />	
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/datepicker.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>templates/home/js/ajax.js"></script>
<!--BEGIN: RIGHT-->
 <SCRIPT TYPE="text/javascript">
  function SearchJob(baseUrl){	
		  product_name='';		 
		  if(document.getElementById('keyword_account').value!='')
		  product_name=document.getElementById('keyword_account').value;  
		 
		  window.location = baseUrl+'account/job/search/title/keyword/'+product_name+'/';		 	
}
<!--
function submitenterJob(myfield,e,baseUrl)
{
var keycode;
if (window.event) keycode = window.event.keyCode;
else if (e) keycode = e.which;
else return true;
if (keycode == 13)
   {
   SearchJob(baseUrl);
   return false;
   }
else
   return true;
}
-->
</SCRIPT>
<div class="col-lg-9 col-md-9 col-sm-8">
    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <div class="tile_modules tile_modules_blue">
                <div class="fl"></div>
                <div class="fc">
				<?php echo $this->lang->line('title_job_defaults'); ?>
                </div>
                <div class="fr"></div>
                </div>
            </td>
        </tr>
        <?php if(count($job) > 0){ ?>
        <form name="frmAccountJob" method="post">
        <tr>
            <td class="v_background" >
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="46" class="title_account_0">STT</td>
                        <td width="30" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountJob',0)" /></td>
                        <td class="title_account_2">
                            <?php echo $this->lang->line('title_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="150" class="title_account_1">
                            <?php echo $this->lang->line('field_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>field/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>field/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="110" class="title_account_2">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>postdate/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>postdate/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="120" class="title_account_1">
                            <?php echo $this->lang->line('enddate_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>enddate/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>enddate/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="60" class="title_account_2"><?php echo $this->lang->line('status_list'); ?></td>

                        <td width="45" class="title_account_3"><?php echo $this->lang->line('edit_list'); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td valign="top"   >
                <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($job as $jobArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="46" height="32" class="line_account_0"><?php echo $sTT; ?></td>
                        <td width="30" height="32" class="line_account_1">
                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $jobArray->job_id; ?>" onclick="DoCheckOne('frmAccountJob')" />
                        </td>
                        <td height="32" class="line_account_2">
                            <a class="menu_1" href="<?php echo base_url(); ?>job/field/<?php echo $jobArray->job_field; ?>/detail/<?php echo $jobArray->job_id; ?>" alt="<?php echo $this->lang->line('detail_tip'); ?>">
                                <?php echo sub($jobArray->job_title, 30); ?>
                            </a>
                            <span class="number_view">(<?php echo $jobArray->job_view; ?>)</span>
                        </td>
                        <td width="140" height="32" class="line_account_3" style="text-align:center;">
                            <?php echo $jobArray->fie_name; ?>
                        </td>
                        <td width="110" height="32" class="line_account_4">
                            <?php echo date('d-m-Y', $jobArray->job_begindate); ?>
                        </td>
                        <td width="120" height="32" class="line_account_1">
                            <input type="text" name="DivEnddate_<?php echo $idDiv; ?>" id="DivEnddate_<?php echo $idDiv; ?>" value="<?php echo date('d-m-Y', $jobArray->job_enddate); ?>" readonly="readonly" class="set_enddate" />
                            <script type="text/javascript">
                                jQuery(function() {
                                                jQuery("#DivEnddate_<?php echo $idDiv; ?>").datepicker({showOn: 'button',
                                                buttonImage: '<?php echo base_url(); ?>templates/home/images/calendar.gif',
                                                buttonImageOnly: true,
                                                buttonText: '<?php echo $this->lang->line('set_enddate_tip'); ?>',
                                                dateFormat: 'dd-mm-yy',
                                                minDate: new Date(),
                                                maxDate: '+6m',
                                                onClose: function(){
                                                        setEndDate(<?php echo $jobArray->job_id; ?>, document.getElementById('DivEnddate_<?php echo $idDiv; ?>').value, 3, '<?php echo base_url(); ?>', '<?php echo $this->hash->create($this->session->userdata('sessionUser')); ?>');
                                                    }
                                                });
			                                 });
                            </script>
                        </td>
                        <td width="60" height="32" class="line_account_4">
                            <?php if((int)$jobArray->job_status == 1){ ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/public.png" onclick="ActionLink('<?php echo $statusUrl; ?>/status/deactive/id/<?php echo $jobArray->job_id; ?>')" style="cursor:pointer;" border="0" alt="<?php echo $this->lang->line('deactive_tip'); ?>" />
                           	<?php }else{ ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" onclick="ActionLink('<?php echo $statusUrl; ?>/status/active/id/<?php echo $jobArray->job_id; ?>')" style="cursor:pointer;" border="0" />
                            <?php } ?>
                        </td>
                        <td width="45" height="32" class="line_account_5">
                            <img src="<?php echo base_url(); ?>templates/home/images/edit.jpg" onclick="ActionLink('<?php echo base_url(); ?>account/job/edit/<?php echo $jobArray->job_id; ?>')" alt="<?php echo $this->lang->line('edit_tip'); ?>" style="cursor:pointer;" border="0" />
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php $sTT++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="30%" id="delete_account"><img src="<?php echo base_url(); ?>templates/home/images/icon_deletejob_account.gif" onclick="ActionSubmit('frmAccountJob')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="boxfilter_account">
                            <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" onKeyPress="return submitenterJob(this,event,'<?php echo base_url(); ?>')"/>
                            <input type="hidden" name="search_account" id="search_account" value="title" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/job/', 0)" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                        </td>
                        <td width="30%" class="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        </form>
        <?php }elseif(count($job) == 0 && trim($keyword) != ''){ ?>
        <tr>
            <td class="v_background" height="29">
                <table border="0" width="100%" height="29" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="50" class="title_account_0">STT</td>
                        <td width="30" class="title_account_1"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmAccountJob',0)" /></td>
                        <td class="title_account_2">
                            <?php echo $this->lang->line('title_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="150" class="title_account_1">
                            <?php echo $this->lang->line('field_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="110" class="title_account_2">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="120" class="title_account_1">
                            <?php echo $this->lang->line('enddate_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0" />
                        </td>
                        <td width="60" class="title_account_2"><?php echo $this->lang->line('status_list'); ?></td>
                        <td width="50" class="title_account_3"><?php echo $this->lang->line('edit_list'); ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td valign="top"   >
                <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td class="none_record_search" align="center"><?php echo $this->lang->line('none_record_search_job_defaults'); ?></td>
					</tr>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="30%" id="delete_account"><img src="<?php echo base_url(); ?>templates/home/images/icon_deletejob_account.gif" onclick="" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="boxfilter_account">
                            <input type="text" name="keyword_account" id="keyword_account" value="<?php if(isset($keyword)){echo $keyword;} ?>" maxlength="100" class="inputfilter_account" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('keyword_account',1)" onblur="ChangeStyle('keyword_account',2)" onKeyPress="return submitenterJob(this,event,'<?php echo base_url(); ?>')"/>
                            <input type="hidden" name="search_account" id="search_account" value="title" />
                            <img src="<?php echo base_url(); ?>templates/home/images/icon_filter.gif" onclick="ActionSearch('<?php echo base_url(); ?>account/job/', 0)" border="0" style="cursor:pointer;" alt="<?php echo $this->lang->line('search_tip'); ?>" />
                        </td>
                        <td width="30%" class="show_page"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php }else{ ?>
        <tr>
        	<td class="none_record" align="center"><?php echo $this->lang->line('none_record_job_defaults'); ?></td>
		</tr>
        <?php } ?>
    </table>
    </div>
</div>
    </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
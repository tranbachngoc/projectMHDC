<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->
<td  valign="top" class="search">
    <table  border="0" cellpadding="0" cellspacing="0">
        <?php $this->load->view('home/advertise/center1'); ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_job'); ?></div>
            </td>
        </tr>
        <tr>
            <td  >
                <table  class="post_main" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td height="20" class="post_top"></td>
                    </tr>
                    <form name="frmSearchJob" method="post">
                    <tr>
                        <td>
                            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td colspan="2" height="12"></td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('title_job_job'); ?>:</td>
                                    <td>
                                        <input type="text" name="title_search" id="title_search" value="<?php if(isset($titleKeyword)){echo $titleKeyword;} ?>" maxlength="80" class="input_formpost" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('title_search',1)" onblur="ChangeStyle('title_search',2)" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('salary_job'); ?>:</td>
                                    <td>
                                        <input type="text" value="<?php if(isset($salaryKeyword)){echo $salaryKeyword;} ?>" name="salary_search" id="salary_search" maxlength="8" class="inputcost_formpost" onkeyup="FormatCurrency('DivShowSalarySearch','currency_search',this.value); BlockChar(this,'NotNumbers');" onfocus="ChangeStyle('salary_search',1)" onblur="ChangeStyle('salary_search',2)" />
                                        <select name="currency_search" id="currency_search" class="selectcurrency_formpost" onchange="FormatCurrency('DivShowSalarySearch','currency_search',document.getElementById('salary_search').value)">
                                            <option value="VND" <?php if(isset($currencyKeyword) && $currencyKeyword == 'VND'){echo 'selected="selected"';}elseif(!isset($currencyKeyword)){echo 'selected="selected"';} ?>><?php echo $this->lang->line('vnd_main'); ?></option>
                                			<option value="USD" <?php if(isset($currencyKeyword) && $currencyKeyword == 'USD'){echo 'selected="selected"';} ?>><?php echo $this->lang->line('usd_main'); ?></option>
                                        </select>
                                        <span class="div_helppost" style="padding-right:40px;">(<?php echo $this->lang->line('only_input_number_help'); ?>)</span>
                                        <div id="DivShowSalarySearch" style="padding-right:30px;"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('place_job'); ?>:</td>
                                    <td>
                                        <select name="province_search" id="province_search" class="selectprovince_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('select_place_job'); ?></option>
                                            <?php foreach($province as $provinceArray){ ?>
			                                <?php if(isset($placeKeyword) && $placeKeyword == $provinceArray->pre_id){ ?>
			                                <option value="<?php echo $provinceArray->pre_id; ?>" selected="selected"><?php echo $provinceArray->pre_name; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
			                                <?php } ?>
			                                <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('field_job'); ?>:</td>
                                    <td>
                                        <select name="field_search" id="field_search" class="selectcategory_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('select_field_job'); ?></option>
                                            <?php foreach($field as $fieldArray){ ?>
			                                <?php if(isset($fieldKeyword) && $fieldKeyword == $fieldArray->fie_id){ ?>
			                                <option value="<?php echo $fieldArray->fie_id; ?>" selected="selected"><?php echo $fieldArray->fie_name; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $fieldArray->fie_id; ?>"><?php echo $fieldArray->fie_name; ?></option>
			                                <?php } ?>
			                                <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('postdate_job'); ?>:</td>
                                    <td>
                                        <font color="#666666"><b><?php echo $this->lang->line('from_job'); ?></b></font>
                                        <select name="beginday_search1" id="beginday_search1" class="selectdate_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('day_job'); ?></option>
                                            <?php for($beginday = 1; $beginday <= 31; $beginday++){ ?>
			                                <?php if(isset($sDayKeyword) && (int)$sDayKeyword == $beginday){ ?>
			                                <option value="<?php echo $beginday; ?>" selected="selected"><?php echo $beginday; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $beginday; ?>"><?php echo $beginday; ?></option>
			                                <?php } ?>
											<?php } ?>
                                        </select>
                                        <b>-</b>
                                        <select name="beginmonth_search1" id="beginmonth_search1" class="selectdate_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('month_job'); ?></option>
                                            <?php for($beginmonth = 1; $beginmonth <= 12; $beginmonth++){ ?>
			                                <?php if(isset($sMonthKeyword) && (int)$sMonthKeyword == $beginmonth){ ?>
			                                <option value="<?php echo $beginmonth; ?>" selected="selected"><?php echo $beginmonth; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $beginmonth; ?>"><?php echo $beginmonth; ?></option>
			                                <?php } ?>
											<?php } ?>
                                        </select>
                                        <b>-</b>
                                        <select name="beginyear_search1" id="beginyear_search1" class="selectdate_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('year_job'); ?></option>
                                            <?php for($beginyear = (int)date('Y')-1; $beginyear <= (int)date('Y'); $beginyear++){ ?>
			                                <?php if(isset($sYearKeyword) && (int)$sYearKeyword == $beginyear){ ?>
			                                <option value="<?php echo $beginyear; ?>" selected="selected"><?php echo $beginyear; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $beginyear; ?>"><?php echo $beginyear; ?></option>
			                                <?php } ?>
											<?php } ?>
                                        </select>
                                        <font color="#666666"><b><?php echo $this->lang->line('to_job'); ?></b></font>
                                        <select name="beginday_search2" id="beginday_search2" class="selectdate_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('day_job'); ?></option>
                                            <?php for($beginday = 1; $beginday <= 31; $beginday++){ ?>
			                                <?php if(isset($eDayKeyword) && (int)$eDayKeyword == $beginday){ ?>
			                                <option value="<?php echo $beginday; ?>" selected="selected"><?php echo $beginday; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $beginday; ?>"><?php echo $beginday; ?></option>
			                                <?php } ?>
											<?php } ?>
                                        </select>
                                        <b>-</b>
                                        <select name="beginmonth_search2" id="beginmonth_search2" class="selectdate_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('month_job'); ?></option>
                                            <?php for($beginmonth = 1; $beginmonth <= 12; $beginmonth++){ ?>
			                                <?php if(isset($eMonthKeyword) && (int)$eMonthKeyword == $beginmonth){ ?>
			                                <option value="<?php echo $beginmonth; ?>" selected="selected"><?php echo $beginmonth; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $beginmonth; ?>"><?php echo $beginmonth; ?></option>
			                                <?php } ?>
											<?php } ?>
                                        </select>
                                        <b>-</b>
                                        <select name="beginyear_search2" id="beginyear_search2" class="selectdate_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('year_job'); ?></option>
                                            <?php for($beginyear = (int)date('Y')-1; $beginyear <= (int)date('Y'); $beginyear++){ ?>
			                                <?php if(isset($eYearKeyword) && (int)$eYearKeyword == $beginyear){ ?>
			                                <option value="<?php echo $beginyear; ?>" selected="selected"><?php echo $beginyear; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $beginyear; ?>"><?php echo $beginyear; ?></option>
			                                <?php } ?>
											<?php } ?>
                                        </select>
                                        <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('date_search_tip_help') ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85"></td>
                                    <td height="30" valign="bottom" align="center">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td colspan="3" height="15"></td>
                                            </tr>
                                            <tr>
                                                <td><input type="button" onclick="CheckInput_SearchJob('<?php echo base_url(); ?>search/job/')" name="submit_searchjob" value="<?php echo $this->lang->line('button_search_job'); ?>" class="button_form" /></td>
                                                <td width="15"></td>
                                                <td><input type="reset" name="reset_searchjob" value="<?php echo $this->lang->line('button_reset_job'); ?>" class="button_form" /></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    </form>
                    <tr>
                        <td height="30" class="post_bottom"></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="16" ></td>
        </tr>
        <?php if(isset($searchJob)){ ?>
        <tr>
            <td><div class="h1-styleding">
             <h1><?php echo $h1tagSiteGlobal; ?></h1>
             </div></td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <td  height="30">
                <div class="tile_modules"><?php echo $this->lang->line('title_result_search_main'); ?> <span class="result_number">(<?php if(isset($totalResult)){echo $totalResult;}else{echo '0';} ?>)</span></div>
            </td>
        </tr>
        <?php if(count($searchJob) > 0){ ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_tinraovat.jpg" height="29">
                <table align="center"  height="29" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="300" class="title_boxjob_1">
                            <?php echo $this->lang->line('title_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>titleSort/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>titleSort/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="105" class="title_boxjob_2">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="110" class="title_boxjob_1">
                            <?php echo $this->lang->line('place_job_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>placeSort/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>placeSort/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td  >
                <table align="center"  border="0" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($searchJob as $searchJobArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowJob_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowJob_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowJob_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="25" height="32" class="line_boxjob_1" ><img src="<?php echo base_url(); ?>templates/home/images/icon_tieudejob.gif" /></td>
                        <td width="238" height="32" class="line_boxjob_1"><a class="menu" href="<?php echo base_url(); ?>job/field/<?php echo $searchJobArray->job_field; ?>/detail/<?php echo $searchJobArray->job_id; ?>" onmouseover="ddrivetip('<?php echo $this->lang->line('position_tip'); ?>&nbsp;<?php echo $searchJobArray->job_position; ?><br /><?php echo $this->lang->line('time_surrend_tip'); ?>&nbsp;<?php echo date('d-m-Y', $searchJobArray->job_time_surrend); ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo sub($searchJobArray->job_title, 60); ?></a>&nbsp;<span class="number_view">(<?php echo $searchJobArray->job_view; ?>)</span>&nbsp;</td>
                        <td width="100" height="32" class="line_boxjob_2"><?php echo date('d-m-Y', $searchJobArray->job_begindate); ?></td>
                        <td width="105" height="32" class="line_boxjob_3"><?php foreach($province as $provinceArrays){if($searchJobArray->job_province == $provinceArrays->pre_id){echo $provinceArrays->pre_name; break;}} ?></td>
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
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_asc_by_view_job'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_desc_by_view_job'); ?></option>
                            </select>
                        </td>
                        <td width="37%" class="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php }else{ ?>
        <tr>
        	<td class="none_record_search" style="padding-top: 10px;" >
           		<?php echo $this->lang->line('none_record_search_job'); ?>
			</td>
		</tr>
        <?php } ?>
        <tr>
            <td  height="16" ></td>
        </tr>
        <?php } ?>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
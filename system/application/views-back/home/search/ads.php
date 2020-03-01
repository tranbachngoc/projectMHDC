<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->
<script>
jQuery(document).ready(function() {
	jQuery('a#uptin').each(function(index) {
	
		jQuery(this).fancybox({
					'width'				: '25%',
					'height'			: '25%',
					'autoScale'			: false,
					'transitionIn'		: 'none',
					'transitionOut'		: 'none',
					'type'				: 'iframe'
				});
	});
});
</script>
<td valign="top">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding:0 10px;">
        <?php $this->load->view('home/advertise/center1'); ?>
        <tr>
            <td>
                <div class="tile_modules">
                <div class="fl"></div>
                <div class="fc">
				<?php echo $this->lang->line('title_ads'); ?>
                </div>
                <div class="fr"></div>
                </div>
            </td>
        </tr>
        <tr>
            <td  >
                <table width="585" class="post_main" align="center" cellpadding="0" cellspacing="0" border="0" style="margin-top:5px;">
                    <tr>
                        <td height="20" class="post_top"></td>
                    </tr>
                    <form name="frmSearchAds" method="post" >
                    <tr>
                        <td>
                            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td colspan="2" height="12"></td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('title_ads_ads'); ?>:</td>
                                    <td>
                                        <input type="text" name="title_search" id="title_search" value="<?php if(isset($titleKeyword)){echo $titleKeyword;} ?>" maxlength="80" class="input_formpost" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('title_search',1)" onblur="ChangeStyle('title_search',2)" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('view_ads'); ?>:</td>
                                    <td>
                                        <font color="#666666"><b><?php echo $this->lang->line('from_ads'); ?></b></font>
                                        <input type="text" value="<?php if(isset($sViewKeyword)){echo $sViewKeyword;} ?>" name="view_search1" id="view_search1" maxlength="10" class="inputcost_formpost" onkeyup="BlockChar(this,'NotNumbers');" onfocus="ChangeStyle('view_search1',1)" onblur="ChangeStyle('view_search1',2)" />
                                        <font color="#666666"><b><?php echo $this->lang->line('to_ads'); ?></b></font>
                                        <input type="text" value="<?php if(isset($eViewKeyword)){echo $eViewKeyword;} ?>" name="view_search2" id="view_search2" maxlength="10" class="inputcost_formpost" onkeyup="BlockChar(this,'NotNumbers');" onfocus="ChangeStyle('view_search2',1)" onblur="ChangeStyle('view_search2',2)" />
                                        <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('view_search_tip_help') ?>',290,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost" />
                                        <span class="div_helppost" style="padding-right:40px;">(<?php echo $this->lang->line('only_input_number_help'); ?>)</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('place_ads'); ?>:</td>
                                    <td>
                                        <select name="province_search" id="province_search" class="selectprovince_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('select_place_ads'); ?></option>
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
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('category_ads'); ?>:</td>
                                    <td>
                                        <select name="category_search" id="category_search" class="selectcategory_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('select_category_ads'); ?></option>
                                            <?php foreach($category as $categoryArray){ ?>
			                                <?php if((isset($categoryKeyword) && $categoryKeyword == $categoryArray->cat_id)|| $categoryArray->cat_id == $activeCat){ ?>
			                                <option value="<?php echo $categoryArray->cat_id; ?>" selected="selected"><?php echo $categoryArray->cat_name; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $categoryArray->cat_id; ?>"><?php echo $categoryArray->cat_name; ?></option>
			                                <?php } ?>
			                                <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('postdate_ads'); ?>:</td>
                                    <td>
                                        <font color="#666666"><b><?php echo $this->lang->line('from_ads'); ?></b></font>
                                        <select name="beginday_search1" id="beginday_search1" class="selectdate_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('day_ads'); ?></option>
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
                                            <option value="0" selected="selected"><?php echo $this->lang->line('month_ads'); ?></option>
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
                                            <option value="0" selected="selected"><?php echo $this->lang->line('year_ads'); ?></option>
                                            <?php for($beginyear = (int)date('Y')-1; $beginyear <= (int)date('Y'); $beginyear++){ ?>
			                                <?php if(isset($sYearKeyword) && (int)$sYearKeyword == $beginyear){ ?>
			                                <option value="<?php echo $beginyear; ?>" selected="selected"><?php echo $beginyear; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $beginyear; ?>"><?php echo $beginyear; ?></option>
			                                <?php } ?>
											<?php } ?>
                                        </select>
                                        <font color="#666666"><b><?php echo $this->lang->line('to_ads'); ?></b></font>
                                        <select name="beginday_search2" id="beginday_search2" class="selectdate_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('day_ads'); ?></option>
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
                                            <option value="0" selected="selected"><?php echo $this->lang->line('month_ads'); ?></option>
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
                                            <option value="0" selected="selected"><?php echo $this->lang->line('year_ads'); ?></option>
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
                                                <td><input type="button" onclick="CheckInput_SearchAds('<?php echo base_url(); ?>search/ads/')" name="submit_searchads" value="<?php echo $this->lang->line('button_search_ads') ?>" class="button_form" /></td>
                                                <td width="15"></td>
                                                <td><input type="reset" name="reset_searchads" value="<?php echo $this->lang->line('button_reset_ads') ?>" class="button_form" /></td>
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
        <?php if(isset($searchAds)){ ?>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
                <div class="tile_modules tile_modules_blue">
                <div class="fl"></div>
                <div class="fc">
				<?php echo $this->lang->line('title_result_search_main'); ?> <span class="result_number">(<?php if(isset($totalResult)){echo $totalResult;}else{echo '0';} ?>)</span>
                </div>
                <div class="fr"></div>
                </div>
            </td>
        </tr>
        <?php if(count($searchAds) > 0){ ?>
        <tr>
            <td height="29">
                <table align="center" width="100%" height="29" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                    	<td width="28" class="title_boxads_1">&nbsp;</td>
                        <td width="334" class="title_boxads_1">
                            <?php echo $this->lang->line('title_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>titleSort/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>titleSort/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="105" class="title_boxads_1">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="105" class="title_boxads_1">
                            <?php echo $this->lang->line('place_ads_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>placeSort/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>placeSort/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                    </tr>
                </table>
           </td>
        </tr>
        <tr>
            <td  >
                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?php $idDiv = 1; ?>
                    <?php foreach($searchAds as $searchAdsArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowAds_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowAds_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowAds_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="28" height="32" class="line_boxads_2" ><img src="<?php echo base_url(); ?>templates/home/images/icon_tieude.gif" /></td>
                        <td width="330" height="32" class="line_boxads_1"><a class="menu" href="<?php echo base_url(); ?>ads/category/detail/<?php echo $searchAdsArray->ads_category; ?>/<?php echo $searchAdsArray->ads_id; ?>/<?php echo RemoveSign($searchAdsArray->ads_title); ?>" onmouseover="ddrivetip('<?php echo $searchAdsArray->ads_descr; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();"><?php echo sub($searchAdsArray->ads_title, 60); ?></a>&nbsp;<span class="number_view">(<?php echo $searchAdsArray->ads_view; ?>) | 
                           <?
                           if(!$this->check->is_logined($this->session->userdata('sessionUser'))){
							   echo "<a href='".base_url()."account/uptin/".$searchAdsArray->ads_id."/2' id='uptin'>Up Tin</a>";
						   }
							
							?>
                        
                        </span>&nbsp;</td>
                        <td width="100" height="32" class="line_boxads_1"><?php echo date('d-m-Y', $searchAdsArray->ads_begindate); ?></td>
                        <td width="100" height="32" class="line_boxads_1"><?php foreach($province as $provinceArrays){if($searchAdsArray->ads_province == $provinceArrays->pre_id){echo $provinceArrays->pre_name; break;}} ?></td>
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
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_asc_by_view_ads'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_desc_by_view_ads'); ?></option>
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
           		<?php echo $this->lang->line('none_record_search_ads'); ?>
			</td>
		</tr>
        <?php } ?>
        <?php } ?>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->
<td width="100%" valign="top">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding:5px 10px 0;">
        <?php $this->load->view('home/advertise/center1'); ?>
        <tr>
            <td background="<?php echo base_url(); ?>templates/home/images/bg_topkhung.png" height="30">
            	<div class="tile_modules">
                    <div class="fl"></div>
                    <div class="fc">
                    <?php echo $this->lang->line('title_shop'); ?>
                    </div>
                    <div class="fr"></div>
                </div>
            </td>
        </tr>
        <tr>
            <td  >
                <table width="100%" class="post_main" align="center" cellpadding="0" cellspacing="0" border="0">
                    <tr>
                        <td height="20" class="post_top"></td>
                    </tr>
                    <form name="frmSearchShop" method="post">
                    <tr>
                        <td>
                            <table border="0" width="100%" align="center" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td colspan="2" height="12"></td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('name_shop'); ?>:</td>
                                    <td>
                                        <input type="text" name="name_search" id="name_search" value="<?php if(isset($nameKeyword)){echo $nameKeyword;} ?>" maxlength="80" class="input_formpost" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('name_search',1)" onblur="ChangeStyle('name_search',2)" />
                                        <div class="saleoff">
                                            <input type="checkbox" name="saleoff_search" id="saleoff_search" value="1" <?php if(isset($saleoffKeyword) && $saleoffKeyword == '1'){echo 'checked="checked"';} ?> />
                                            <?php echo $this->lang->line('saleoff_shop'); ?>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('address_shop'); ?>:</td>
                                    <td>
                                        <input type="text" name="address_search" id="address_search" value="<?php if(isset($addressKeyword)){echo $addressKeyword;} ?>" maxlength="80" class="input_formpost" onKeyUp="BlockChar(this,'AllSpecialChar')" onfocus="ChangeStyle('address_search',1)" onblur="ChangeStyle('address_search',2)" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('province_shop'); ?>:</td>
                                    <td>
                                        <select name="province_search" id="province_search" class="selectprovince_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('select_province_shop'); ?></option>
                                            <?php foreach($province as $provinceArray){ ?>
			                                <?php if(isset($provinceKeyword) && $provinceKeyword == $provinceArray->pre_id){ ?>
			                                <option value="<?php echo $provinceArray->pre_id; ?>" selected="selected"><?php echo $provinceArray->pre_name; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
			                                <?php } ?>
			                                <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('category_shop'); ?>:</td>
                                    <td>
                                        <select name="category_search" id="category_search" class="selectcategory_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('select_category_shop'); ?></option>
                                            <?php foreach($category as $categoryArray){ ?>
			                                <?php if(isset($categoryKeyword) && $categoryKeyword == $categoryArray->cat_id){ ?>
			                                <option value="<?php echo $categoryArray->cat_id; ?>" selected="selected"><?php echo $categoryArray->cat_name; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $categoryArray->cat_id; ?>"><?php echo $categoryArray->cat_name; ?></option>
			                                <?php } ?>
			                                <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="85" valign="top" class="list_post"><?php echo $this->lang->line('begindate_shop'); ?>:</td>
                                    <td>
                                        <font color="#666666"><b><?php echo $this->lang->line('from_shop'); ?></b></font>&nbsp;&nbsp;
                                        <select name="beginday_search1" id="beginday_search1" class="selectdate_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('day_shop'); ?></option>
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
                                            <option value="0" selected="selected"><?php echo $this->lang->line('month_shop'); ?></option>
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
                                            <option value="0" selected="selected"><?php echo $this->lang->line('year_shop'); ?></option>
                                            <?php for($beginyear = (int)date('Y')-1; $beginyear <= (int)date('Y'); $beginyear++){ ?>
			                                <?php if(isset($sYearKeyword) && (int)$sYearKeyword == $beginyear){ ?>
			                                <option value="<?php echo $beginyear; ?>" selected="selected"><?php echo $beginyear; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $beginyear; ?>"><?php echo $beginyear; ?></option>
			                                <?php } ?>
											<?php } ?>
                                        </select>
                                        <br /><font color="#666666"><b><?php echo $this->lang->line('to_shop'); ?></b></font>
                                        <select name="beginday_search2" id="beginday_search2" class="selectdate_formpost">
                                            <option value="0" selected="selected"><?php echo $this->lang->line('day_shop'); ?></option>
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
                                            <option value="0" selected="selected"><?php echo $this->lang->line('month_shop'); ?></option>
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
                                            <option value="0" selected="selected"><?php echo $this->lang->line('year_shop'); ?></option>
                                            <?php for($beginyear = (int)date('Y')-1; $beginyear <= (int)date('Y'); $beginyear++){ ?>
			                                <?php if(isset($eYearKeyword) && (int)$eYearKeyword == $beginyear){ ?>
			                                <option value="<?php echo $beginyear; ?>" selected="selected"><?php echo $beginyear; ?></option>
			                                <?php }else{ ?>
			                                <option value="<?php echo $beginyear; ?>"><?php echo $beginyear; ?></option>
			                                <?php } ?>
											<?php } ?>
                                        </select>
                                        <img src="<?php echo base_url(); ?>templates/home/images/help_post.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('date_search_tip_help') ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();" class="img_helppost"  alt="" />
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
                                                <td><input type="button" onclick="CheckInput_SearchShop('<?php echo base_url(); ?>search/shop/')" name="submit_searchshop" value="<?php echo $this->lang->line('button_search_shop'); ?>" class="button_form" /></td>
                                                <td width="15"></td>
                                                <td><input type="reset" name="reset_searchshop" value="<?php echo $this->lang->line('button_reset_shop'); ?>" class="button_form" /></td>
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
        
        <?php if(isset($searchShop)){ ?>
         <tr>
            <td><div class="h1-styleding">
             <h1><?php echo $h1tagSiteGlobal; ?></h1>
             </div></td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <td height="30">
           		 <div class="tile_modules">
                    <div class="fl"></div>
                    <div class="fc">
                    <?php echo $this->lang->line('title_result_search_main'); ?> <span class="result_number">(<?php if(isset($totalResult)){echo $totalResult;}else{echo '0';} ?>)</span>
                    </div>
                    <div class="fr"></div>
                </div>            
            </td>
        </tr>
        <?php if(count($searchShop) > 0){ ?>
        <tr>
            <td  >
                <table align="center" width="100%" style="border:1px #D4EDFF solid; margin-top:5px;" cellpadding="0" cellspacing="0">
                    <tr class="v_height29">
                        <td width="110" class="title_boxshop_1">Logo</td>
                        <td class="title_boxshop_2">
                            <?php echo $this->lang->line('shop_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>nameSort/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;"  alt="" /> 
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>nameSort/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;"  alt="" />
                        </td>
                        <td width="150" class="title_boxshop_1">
                            <?php echo $this->lang->line('address_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>addressSort/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;"  alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>addressSort/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;"  alt="" />
                        </td>
                    </tr>
                    <?php foreach($searchShop as $searchShopArray){ ?>
                    <tr>
                        <td width="110" class="line_boxshop_1">
                            <a class="menu" href="<?php echo base_url(); ?><?php echo $searchShopArray->sho_link; ?>" title="<?php echo $this->lang->line('access_shop_tip'); ?>">
                                <img src="<?php echo base_url(); ?>media/shop/logos/<?php echo $searchShopArray->sho_dir_logo; ?>/<?php echo $searchShopArray->sho_logo; ?>" class="image_boxshop" alt=""  />
                            </a>
                        </td>
                        <td valign="top" class="line_boxshop_2">
                            <a class="menu_1" href="<?php echo base_url(); ?><?php echo $searchShopArray->sho_link; ?>" title="<?php echo $this->lang->line('access_shop_tip'); ?>">
                                <?php echo $searchShopArray->sho_name; ?>
                            </a>
                            <div class="descr_boxshop">
                                <?php echo $searchShopArray->sho_descr; ?>
                            </div>
                            <table style="margin-top:10px;" border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="41%" class="saleoff_boxshop">
                                        <?php if((int)$searchShopArray->sho_saleoff == 1){ ?>
                                        <img src="<?php echo base_url(); ?>templates/home/images/saleoff_shop.gif" border="0"  alt="" />
                                        <?php } ?>
                                    </td>
                                    <td class="vr_boxshop"><?php echo $this->lang->line('view_shop'); ?>:&nbsp;<?php echo $searchShopArray->sho_view; ?>&nbsp;<b>|</b>&nbsp;<?php echo $this->lang->line('quantity_product_shop'); ?>:&nbsp;<?php echo $searchShopArray->sho_quantity_product; ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="150" class="line_boxshop_1">
                            <div class="address_boxshop"><?php echo $searchShopArray->sho_address; ?>, <?php foreach($province as $provinceArrays){if($searchShopArray->sho_province == $provinceArrays->pre_id){echo $provinceArrays->pre_name; break;}} ?></div>
                            <div class="phone_boxshop">(<?php echo $this->lang->line('phone_shop'); ?>: <?php echo $searchShopArray->sho_phone; ?>)</div>
                            <div class="status_yahoo"><img src="http://opi.yahoo.com/online?u=<?php echo $searchShopArray->sho_yahoo; ?>&amp;m=g&amp;t=1" alt=""/></div>
                        </td>
                    </tr>
                    <?php } ?>
                 </table>
                 <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" id="regis_boxshop"><img src="<?php echo base_url(); ?>templates/home/images/icon_regisboxshop.gif" onclick="ActionLink('<?php echo base_url(); ?>register')" style="cursor:pointer;" border="0" alt="" /></td>
                        <td align="center" id="sort_boxshop">
                            <select name="select_sort" class="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_asc_by_view_shop'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_desc_by_view_shop'); ?></option>
                                <option value="<?php echo $sortUrl; ?>product/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_asc_by_quantity_product_shop'); ?></option>
                                <option value="<?php echo $sortUrl; ?>product/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_desc_by_quantity_product_shop'); ?></option>
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
           		<?php echo $this->lang->line('none_record_search_shop'); ?>
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
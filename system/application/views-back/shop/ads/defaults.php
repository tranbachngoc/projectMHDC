<?php $this->load->view('shop/common/header'); ?>
<?php $this->load->view('shop/common/left'); ?>
<?php if(isset($siteGlobal)){ ?>
<!--BEGIN: Center-->
<td valign="top" align="center">
    <?php $this->load->view('shop/common/top'); ?>
    <table width="100%" class="table_module" style="margin-top:5px;" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td height="28" class="title_module"><?php echo $this->lang->line('title_detail_ads'); ?></td>
        </tr>
        <?php if(count($ads) > 0){ ?>
        <tr>
            <td class="main_module_1">
                <table align="center" width="100%" style="border:1px #D4EDFF solid;" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="28" height="29" style="background:url(<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/bg_tinraovat.jpg) repeat-x;">&nbsp;</td>
                        <td class="title_boxads_1" style="background:url(<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/bg_tinraovat.jpg) repeat-x;">
                            <?php echo $this->lang->line('title_list'); ?>
                            <img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="110" class="title_boxads_2" style="background:url(<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/bg_tinraovat.jpg) repeat-x;">
                            <?php echo $this->lang->line('date_post_list'); ?>
                            <img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="110" class="title_boxads_1" style="background:url(<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/bg_tinraovat.jpg) repeat-x;">
                            <?php echo $this->lang->line('place_ads_list'); ?>
                            <img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>place/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>place/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                    </tr>
                    <?php $idDiv = 1; ?>
                    <?php foreach($ads as $adsArray){ ?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'f1f9ff';}else{echo 'FFF';} ?>;" id="DivRowAds_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRowAds_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRowAds_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                        <td width="28" height="32" class="line_boxads_1" ><img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/icon_tieude.gif" /></td>
                        <td height="32" class="line_boxads_1"><a class="menu" href="<?php echo $URLRoot; ?>raovat/detail/<?php echo $adsArray->ads_id; ?>/<?php echo RemoveSign($adsArray->ads_title); ?>_<?php echo $adsArray->ads_id; ?>"  onmouseout="hideddrivetip();"><?php echo sub($adsArray->ads_title, 50); ?></a>&nbsp;<span class="number_view">(<?php echo $adsArray->ads_view; ?>)</span>&nbsp;</td>
                        <td width="110" height="32" class="line_boxads_2"><?php echo date('d-m-Y', $adsArray->ads_begindate); ?></td>
                        <td width="110" height="32" class="line_boxads_3"><?php echo $adsArray->pre_name; ?></td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                </table>
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" class="post_boxads"><img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/icon_postboxads.gif" onclick="ActionLink('<?php echo $mainURL; ?>raovat/post')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" class="sort_boxads">
                            <select name="select_sort" class="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_asc_detail_ads'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_desc_detail_ads'); ?></option>
                            </select>
                        </td>
                        <td width="37%" class="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <?php }else{ ?>
        <tr>
        	<td class="main_module none_record"><?php echo $this->lang->line('none_record_detail_ads'); ?></td>
		</tr>
        <?php } ?>
        <tr>
            <td height="10" class="bottom_module"></td>
        </tr>
    </table>
</td>
<!--END Center-->
<?php } ?>
<?php $this->load->view('shop/common/right'); ?>
<?php $this->load->view('shop/common/footer'); ?>
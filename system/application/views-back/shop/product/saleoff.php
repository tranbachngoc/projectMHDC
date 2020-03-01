<?php $this->load->view('shop/common/header'); ?>
<?php $this->load->view('shop/common/left'); ?>
<script>
jQuery(document).ready(function() {
	jQuery('.image_boxpro').mouseover(function(){
		tooltipPicture(this,jQuery(this).attr('id'));
	});	
});
</script>
<?php if(isset($siteGlobal)){ ?>
<!--BEGIN: Center-->
<td width="602" valign="top" align="center">
<div id="DivContent">
    <?php $this->load->view('shop/common/top'); ?>
    <table width="594" class="table_module" style="margin-top:5px;" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td height="28" class="title_module"><?php echo $this->lang->line('title_detail_product_saleoff'); ?></td>
        </tr>
        <?php if(count($saleoffProduct) > 0){ ?>
        
        <tr>
            <td class="main_module"><form name="frmListPro" method="post" action="">
                <table align="center" width="580" style="border:1px #D4EDFF solid;" cellpadding="0" cellspacing="0">
                    <tr class="v_height29">
                        <td width="28" align="center" class="title_boxpro_0"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmListPro',0)" /></td>
                        <td width="110" class="title_boxpro_1"><?php echo $this->lang->line('image_list'); ?></td>
                        <td class="title_boxpro_2">
                            <?php echo $this->lang->line('product_list'); ?>
                            <img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="105" class="title_boxpro_1">
                            <?php echo $this->lang->line('cost_list'); ?>
                            <img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                    </tr>
                    <?php $idDiv = 1; ?>
                    <?php foreach($saleoffProduct as $saleoffProductArray){
                        // Added
                        // by le van son
                        // Calculation discount amount
                        $afSelect = false;
                        /*if ($_REQUEST['af_id'] != '' && $product->is_product_affiliate == 1) {
                            if ($userObject->use_id > 0) {
                                $afSelect = true;
                            }
                        }*/
                        $discount = lkvUtil::buildPrice($saleoffProductArray, $this->session->userdata('sessionGroup'), $afSelect);
                        ?>
                    <tr>
                        <td width="28" align="center" class="line_boxpro_0">
							<input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $saleoffProductArray->pro_id; ?>" onclick="DoCheckOne('frmListPro')" />
						</td>
                        <td width="110" class="line_boxpro_1">
                            <a class="menu_1" href="<?php echo $URLRoot; ?>product/detail/<?php echo $saleoffProductArray->pro_id; ?>/<?php echo RemoveSign($saleoffProductArray->pro_name); ?>">
                                <img src="<?php echo $URLRoot; ?>media/images/product/<?php echo $saleoffProductArray->pro_dir; ?>/<?php echo show_thumbnail($saleoffProductArray->pro_dir, $saleoffProductArray->pro_image); ?>" class="image_boxpro" onmouseover="ddrivetip_image('<img class=\'my_img\' src=\'<?php echo $URLRoot; ?>media/images/product/<?php echo $saleoffProductArray->pro_dir; ?>/<?php echo show_image($saleoffProductArray->pro_image); ?>\' border=0>',1,'#F0F8FF');" onmouseout="hideddrivetip();" />
                            </a>
                        </td>
                        <td valign="top" class="line_boxpro_2">
                            <a class="menu_1" href="<?php echo $URLRoot; ?>product/detail/<?php echo $saleoffProductArray->pro_id; ?>/<?php echo RemoveSign($saleoffProductArray->pro_name); ?>" title="<?php echo $this->lang->line('detail_tip'); ?>">
                                <?php echo $saleoffProductArray->pro_name; ?>
                            </a>
                            <div class="descr_boxpro">
                                <?php echo $saleoffProductArray->pro_descr; ?>
                            </div>
                            <table style="margin-top:10px;" border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="45%" class="saleoff_boxpro">
                                        <?php if((int)$saleoffProductArray->pro_saleoff == 1){ ?>
                                        <img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/icon_mirror.gif" border="0" />
                                        <?php } ?>
                                    </td>
                                    <td class="vr_boxpro"><?php echo $this->lang->line('view_detail_product_saleoff'); ?>:&nbsp;<?php echo $saleoffProductArray->pro_view; ?>&nbsp;<b>|</b>&nbsp;<?php echo $this->lang->line('comment_detail_product_saleoff'); ?>:&nbsp;<?php echo $saleoffProductArray->pro_comment; ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="105" class="line_boxpro_1">
                            <?php if((int)$saleoffProductArray->pro_cost == 0){ ?>
						  	<?php echo $this->lang->line('call_main'); ?>
							<?php }else{ ?>
                            <span id="DivCost_<?php echo $idDiv; ?>"><?php echo number_format($discount['salePrice']);?></span>&nbsp;<?php echo $saleoffProductArray->pro_currency; ?>
                            <div class="usd_boxpro">
                                <?php if(strtoupper($saleoffProductArray->pro_currency) == 'VND'){ ?>
								<span id="DivCostExchange_<?php echo $idDiv; ?>"><?php echo number_format(round((int)$saleoffProductArray->pro_cost/settingExchange));?></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?>

								<?php }else{ ?>
								<span id="DivCostExchange_<?php echo $idDiv; ?>"><?php echo number_format(round((int)$saleoffProductArray->pro_cost*settingExchange));?></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>

								<?php } ?>
							</div>

                            <?php if((int)$saleoffProductArray->pro_hondle == 1){ ?>
                            <div class="nego_boxpro"><img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/hondle.gif" border="0" /></div>
                            <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                 </table>
                 <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" id="favorite_boxpro"><img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/icon_favorite.gif" onclick="Favorite('frmListPro', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="sort_boxpro">
                            <select name="select_sort" class="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $sortUrl; ?>buy/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_asc_detail_product_saleoff'); ?></option>
                                <option value="<?php echo $sortUrl; ?>buy/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_desc_detail_product_saleoff'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_asc_detail_product_saleoff'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_desc_detail_product_saleoff'); ?></option>
                                <option value="<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_asc_detail_product_saleoff'); ?></option>
                                <option value="<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begin_desc_detail_product_saleoff'); ?></option>
                            </select>
                        </td>
                        <td width="37%" class="show_page"><?php echo $linkPage; ?></td>
                    </tr>
                </table>
            </form>
            </td>
        </tr>
        
        <?php }else{ ?>
        <tr>
        	<td class="main_module none_record"><?php echo $this->lang->line('none_record_detail_product_saleoff'); ?></td>
		</tr>
        <?php } ?>
        <tr>
            <td height="10" class="bottom_module"></td>
        </tr>
    </table>
</div>
<div id="DivSearch">
    <?php $this->load->view('shop/common/search'); ?>
</div>
<script>OpenSearch(0);</script>
</td>
<!--END Center-->
<?php } ?>
<?php $this->load->view('shop/common/right'); ?>
<?php $this->load->view('shop/common/footer'); ?>
<?php 
    if($siteGlobal->sho_phone){
        $phonenumber = $siteGlobal->sho_phone;
    } elseif($siteGlobal->sho_mobile){
        $phonenumber = $siteGlobal->sho_mobile;
    }
    if($phonenumber){
    ?>    
    <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
        <div class="phonering-alo-ph-circle"></div>
        <div class="phonering-alo-ph-circle-fill"></div>            
        <div class="phonering-alo-ph-img-circle">
            <a href="tel:<?php echo $siteGlobal->sho_mobile; ?>">
                <img data-toggle="modal" data-target=".bs-example-modal-md" src="https://i.imgur.com/v8TniL3.png" alt="Liên hệ" width="50" onmouseover="this.src = 'https://i.imgur.com/v8TniL3.png';" onmouseout="this.src = 'https://i.imgur.com/v8TniL3.png';">
            </a>
        </div>
    </div>
<?php } ?>

<?php if(isset($successFavoriteProduct) && $successFavoriteProduct == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_favorite_message_detail_product_saleoff'); ?>');</script>
<?php } ?>
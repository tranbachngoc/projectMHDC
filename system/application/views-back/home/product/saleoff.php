<?php $this->load->view('home/common/header');
/*if ($_REQUEST['af_id'] != '') {
    $this->load->model('user_model');
    $userObject = $this->user_model->get("use_id", "af_key = '" . $_REQUEST['af_id'] . "'");
}*/
?>
<?php $this->load->view('home/common/left'); ?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery('.image_boxpro').mouseover(function(){
			tooltipPicture(this,jQuery(this).attr('id'));
		});
	});
	var widthScreen=jQuery(window).width();
	jQuery('.header_bar_v2').css('width',widthScreen);
		jQuery('.logo-banner').css('width',widthScreen);


</script>

<!--BEGIN: CENTER-->
<td  valign="top">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 0 10px;">
        <?php $this->load->view('home/advertise/center1'); ?>
        <tr>
            <td>
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2><?php echo $this->lang->line('title_saleoff'); ?></h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <?php if(count($saleoffProduct) > 0){ ?>
        
        <tr>
            <td  ><form name="frmListPro" method="post" action="">
                <table align="center" width="100%" style="border:1px #D4EDFF solid; margin-top:5px;" cellpadding="0" cellspacing="0">
                    <tr class="v_height29">
                        <td width="28" align="center" class="title_boxpro_0"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmListPro',0)" /></td>
                        <td width="110" class="title_boxpro_1"><?php echo $this->lang->line('image_list'); ?></td>
                        <td class="title_boxpro_2">
                            <?php echo $this->lang->line('product_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                        <td width="105" class="title_boxpro_1">
                            <?php echo $this->lang->line('cost_list'); ?>
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </td>
                    </tr>
                    <?php $idDiv = 1; ?>
                    <?php foreach($saleoffProduct as $saleoffProductArray){
                        // Added
                        // by le van son
                        // Calculation discount amount
                        $afSelect = false;
                        /*if ($_REQUEST['af_id'] != '' && $saleoffProductArray->is_product_affiliate == 1) {
                            if ($userObject->use_id > 0) {
                                $afSelect = true;
                            }
                        }*/

                        $discount = lkvUtil::buildPrice($saleoffProductArray, $this->session->userdata('sessionGroup'), $afSelect);

                        ?>
                    <tr>
                        <td width="28" align="center" class="line_boxpro_0"><input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $saleoffProductArray->pro_id; ?>" onclick="DoCheckOne('frmListPro')" /></td>
                        <td width="110" class="line_boxpro_1">
                            <a class="menu_1" href="<?php echo base_url(); ?><?php echo $saleoffProductArray->pro_category; ?>/<?php echo $saleoffProductArray->pro_id; ?>/<?php echo RemoveSign($saleoffProductArray->pro_name); ?>">
                                <input type="hidden" id="name-<?php echo 'f'.$saleoffProductArray->pro_id;?>" value="<?php echo $saleoffProductArray->pro_name;?>"/>
                                <input type="hidden" id="view-<?php echo 'f'.$saleoffProductArray->pro_id;?>" value="<?php echo $saleoffProductArray->pro_view;?>"/>
                                <input type="hidden" id="shop-<?php echo 'f'.$saleoffProductArray->pro_id;?>" value="<?php echo $saleoffProductArray->sho_name;?>"/>
                                <input type="hidden" id="pos-<?php echo 'f'.$saleoffProductArray->pro_id;?>" value="<?php echo $saleoffProductArray->pre_name;?>"/>
                                <input type="hidden" id="date-<?php echo 'f'.$saleoffProductArray->pro_id;?>" value="<?php echo date('d/m/Y',$saleoffProductArray->sho_begindate);?>"/>
                                <input type="hidden" id="image-<?php echo 'f'.$saleoffProductArray->pro_id;?>" value="<?php echo base_url() ?>media/images/product/<?php echo $saleoffProductArray->pro_dir; ?>/<?php echo show_image($saleoffProductArray->pro_image); ?>"/>
                                <div style="display:none" id="price-<?php echo 'f'.$saleoffProductArray->pro_id;?>">
                                     <span id="DivCostReliable_<?php echo $saleoffProductArray->pro_id; ?>"><?php echo number_format($discount['salePrice']);?></span>&nbsp;<?php echo $saleoffProductArray->pro_currency; ?>
                                </div>

                                <img src="<?php echo base_url() ?>media/images/product/<?php echo $saleoffProductArray->pro_dir; ?>/<?php echo show_thumbnail($saleoffProductArray->pro_dir, $saleoffProductArray->pro_image); ?>" onmouseover="tooltipPicture(this,'<?php echo 'f'.$saleoffProductArray->pro_id;?>')" id="<?php echo 'f'.$saleoffProductArray->pro_id;?>"  class="image_boxpro"/>
                            </a>
                        </td>
                        <td valign="top" class="line_boxpro_2">
                            <a class="menu_1" href="<?php echo base_url(); ?><?php echo $saleoffProductArray->pro_category; ?>/<?php echo $saleoffProductArray->pro_id; ?>/<?php echo RemoveSign($saleoffProductArray->pro_name); ?>" title="<?php echo $this->lang->line('detail_tip'); ?>">
                                <?php echo $saleoffProductArray->pro_name; ?>
                            </a>
                            <div class="descr_boxpro">
                               <?php $vovel=array("&curren;"); ?> <?php echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel,"#",$saleoffProductArray->pro_detail))),300); ?>
                                
                            </div>
                            <table style="margin-top:10px;" border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="45%" class="saleoff_boxpro">
                                        <?php if($saleoffProductArray->pro_saleoff == 1){ ?>
                                        <img src="<?php echo base_url(); ?>templates/home/images/saleoff.gif" border="0" />
                                        <?php } ?>
                                    </td>
                                    <td class="vr_boxpro"><?php echo $this->lang->line('view_saleoff'); ?>:&nbsp;<?php echo $saleoffProductArray->pro_view; ?>&nbsp;<b>|</b>&nbsp;<?php echo $this->lang->line('comment_saleoff'); ?>:&nbsp;<?php echo $saleoffProductArray->pro_comment; ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="105" class="line_boxpro_1">
                            <?php if((int)$saleoffProductArray->pro_cost == 0){ ?>
                            <?php echo $this->lang->line('call_main'); ?>
                            <?php }else{ ?>
                            <span <?php if($saleoffProductArray->pro_cost > $discount['salePrice']){echo "class='line-saleoff'" ;} ?> id="DivCost_<?php echo $idDiv; ?>"><?php echo number_format($saleoffProductArray->pro_cost);?></span>&nbsp;<?php echo $saleoffProductArray->pro_currency; ?>
                            <?php if($saleoffProductArray->pro_cost > $discount['salePrice']){ ?>
                                <br />
                                <span id="DivCostSale_<?php echo $idDiv; ?>"><?php echo number_format($discount['salePrice']);?></span>&nbsp;<?php echo $saleoffProductArray->pro_currency; ?>
                                <?php

                                } ?>
                            <div class="usd_boxpro">
                                <?php if(strtoupper($saleoffProductArray->pro_currency) == 'VND'){ ?>
								<!--<span id="DivCostExchange_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?>
								<script type="text/javascript">FormatCost('<?php echo round($saleoffProductArray->pro_cost/settingExchange); ?>', 'DivCostExchange_<?php echo $idDiv; ?>');</script>-->
								<?php }else{ ?>
								<span id="DivCostExchange_<?php echo $idDiv; ?>"><?php echo number_format(round($saleoffProductArray->pro_cost*settingExchange));?></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>

								<?php } ?>
							</div>

                            <?php if($saleoffProductArray->pro_hondle == 1){ ?>
                            <div class="nego_boxpro"><img src="<?php echo base_url(); ?>templates/home/images/hondle.gif" border="0" /></div>
                            <?php } ?>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                 </table>
                 <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="37%" id="favorite_boxpro"><img src="<?php echo base_url(); ?>templates/home/images/icon_favorite.gif" onclick="Favorite('frmListPro', '<?php if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} ?>')" style="cursor:pointer;" border="0" /></td>
                        <td align="center" id="sort_boxpro">
                            <select name="select_sort" class="select_sort" onchange="ActionSort(this.value)">
                                <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                                <option value="<?php echo $sortUrl; ?>buy/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_asc_saleoff'); ?></option>
                                <option value="<?php echo $sortUrl; ?>buy/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_desc_saleoff'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_asc_saleoff'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_desc_saleoff'); ?></option>
                                <option value="<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_asc_saleoff'); ?></option>
                                <option value="<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_desc_saleoff'); ?></option>
                                           <option value="<?php echo $sortUrl; ?>vote/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('vote_asc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>vote/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('vote_desc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>comment/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('comment_asc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>comment/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('comment_desc_category'); ?></option>
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
	        <td class="none_record" >
				<?php echo $this->lang->line('none_product_saleoff'); ?>
			</td>
		</tr>
  		<?php } ?>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($successFavoriteProduct) && $successFavoriteProduct == true){ ?>
<script type="text/javascript">alert('<?php echo $this->lang->line('success_add_favorite_saleoff'); ?>');</script>
<?php } ?>
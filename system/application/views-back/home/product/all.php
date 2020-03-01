<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: CENTER-->
<script >
jQuery(document).ready(function(){
	hiddenProductViaResolutionCategory('showCateGoRyScren');
	jQuery('.image_boxpro').mouseover(function(){
		tooltipPicture(this,jQuery(this).attr('id'));
	});
	var widthScreen=jQuery(window).width();
	jQuery('.header_bar_v2').css('width',widthScreen);
		jQuery('.logo-banner').css('width',widthScreen);


	var isCtrl = false;
	jQuery(document).keyup(function (e) {
		if(window.event)
        {
             key = window.event.keyCode;     //IE
             if(window.event.ctrlKey)
                 isCtrl = true;
             else
                 isCtrl = false;
        }
        else
        {
             key = e.which;     //firefox
             if(e.ctrlKey)
                 isCtrl = true;
             else
                 isCtrl = false;
        }
		if(isCtrl){
			if(key == 109 || key == 189)
			{
				// zoom out
				hiddenProductViaResolutionCategory('showCateGoRyScren');
			}
			if(key == 107 || key == 187)
			{
				// zoom in
				hiddenProductViaResolutionCategory('showCateGoRyScren');
			}
		}
	});
});
</script>
<td width="100%" valign="top">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding:0 10px;">
        <?php $this->load->view('home/advertise/center1'); ?>
        <?php if(count($reliableProduct) > 0){ ?>
        <tr>
            <td>
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2><?php echo $this->lang->line('title_reliable_category'); ?></h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  >
                <table align="center" style="margin-top:6px;" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td valign="top" align="center">
                             <div class="showCateGoRyScren">
                            <?php $idDiv = 1; ?>
                            <?php foreach($reliableProduct as $reliableProductArray){
                                // Added
                                // by le van son
                                // Calculation discount amount
                                $afSelect = false;
                                /*if ($_REQUEST['af_id'] != '' && $product->is_product_affiliate == 1) {
                                    if ($userObject->use_id > 0) {
                                        $afSelect = true;
                                    }
                                }*/

                                $discount = lkvUtil::buildPrice($reliableProductArray, $this->session->userdata('sessionGroup'), $afSelect);

                                ?>
                            <div class="showbox_1" id="DivReliableProductBox_<?php echo $idDiv; ?>" onmouseover="ChangeStyleBox('DivReliableProductBox_<?php echo $idDiv; ?>',1)" onmouseout="ChangeStyleBox('DivReliableProductBox_<?php echo $idDiv; ?>',2)">
                                <div class="icon-saleoff" ><span class="giamgia"><?php if($reliableProductArray->pro_saleoff==1) {?>Khuyến mãi<?php } ?> </span></div>
                                <div class="cost_showbox" id="price-<?php echo $reliableProductArray->pro_id;?>">
                                    <span id="DivCostReliable_<?php echo $idDiv; ?>"><?php echo number_format($discount['salePrice']);?></span>&nbsp;<?php echo $reliableProductArray->pro_currency; ?>
                                </div>
                            </div>
                            <?php $idDiv++; ?>
                            <?php } ?>
                            </div>
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
        <?php $this->load->view('home/advertise/center2'); ?>
        <?php } ?>
        <tr>
            <td>
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2><?php echo $this->lang->line('title_new_category'); ?></h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

        <tr>
            <td  >
            <form name="frmListPro" method="post" action="">
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
                    <?php foreach($newProduct as $newProductArray){
                        // Added
                        // by le van son
                        // Calculation discount amount
                        $afSelect = false;
                        /*if ($_REQUEST['af_id'] != '' && $product->is_product_affiliate == 1) {
                            if ($userObject->use_id > 0) {
                                $afSelect = true;
                            }
                        }*/

                        $discount = lkvUtil::buildPrice($newProductArray, $this->session->userdata('sessionGroup'), $afSelect);
                        ?>
                    <tr>
                        <td width="28" align="center" class="line_boxpro_0"><input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $newProductArray->pro_id; ?>" onclick="DoCheckOne('frmListPro')" /></td>
                        <td width="110" class="line_boxpro_1">
                            <a class="menu_1" href="<?php echo base_url(); ?><?php echo $newProductArray->pro_category; ?>/<?php echo $newProductArray->pro_id; ?>/<?php echo RemoveSign($newProductArray->pro_name); ?>">
                                <input type="hidden" id="name-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo $newProductArray->pro_name;?>"/>
                                <input type="hidden" id="view-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo $newProductArray->pro_view;?>"/>
                                <input type="hidden" id="shop-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo $newProductArray->sho_name;?>"/>
                                <input type="hidden" id="pos-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo $newProductArray->pre_name;?>"/>
                                <input type="hidden" id="date-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo date('d/m/Y',$newProductArray->sho_begindate);?>"/>
                                <input type="hidden" id="image-<?php echo 'f'.$newProductArray->pro_id;?>" value="<?php echo base_url() ?>media/images/product/<?php echo $newProductArray->pro_dir; ?>/<?php echo show_image($newProductArray->pro_image); ?>"/>
                                <div style="display:none" id="price-<?php echo 'f'.$newProductArray->pro_id;?>">
                                     <span id="DivCostReliable_<?php echo $newProductArray->pro_id; ?>"><?php echo number_format($discount['salePrice']);?></span>&nbsp;<?php echo $newProductArray->pro_currency; ?>
                                </div>

                                <img alt="<?php echo($reliableProductArray->pro_name);?>" src="<?php echo base_url() ?>media/images/product/<?php echo $newProductArray->pro_dir; ?>/<?php echo show_thumbnail($newProductArray->pro_dir, $newProductArray->pro_image); ?>" onmouseover="tooltipPicture(this,'<?php echo 'f'.$newProductArray->pro_id;?>')" id="<?php echo 'f'.$newProductArray->pro_id;?>"  class="image_boxpro"/>
                            </a>
                        </td>
                        <td valign="top" class="line_boxpro_2">
                            <a class="menu_1" href="<?php echo base_url(); ?><?php echo $newProductArray->pro_category; ?>/<?php echo $newProductArray->pro_id; ?>/<?php echo RemoveSign($newProductArray->pro_name); ?>" title="<?php echo $this->lang->line('detail_tip'); ?>">
                                <?php echo $newProductArray->pro_name; ?>
                            </a>
                            <div class="descr_boxpro">
                            <?php $vovel=array("&curren;"); ?> <?php echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel,"#",$newProductArray->pro_detail))),300); ?>

                            </div>
                            <table style="margin-top:10px;" border="0" width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="45%" class="saleoff_boxpro">
                                        <?php if((int)$newProductArray->pro_saleoff == 1){ ?>
                                        <img src="<?php echo base_url(); ?>templates/home/images/saleoff.gif" border="0" />
                                        <?php } ?>
                                    </td>
                                    <td class="vr_boxpro"><?php echo $this->lang->line('view_category'); ?>:&nbsp;<?php echo $newProductArray->pro_view; ?>&nbsp;<b>|</b>&nbsp;<?php echo $this->lang->line('comment_category'); ?>:&nbsp;<?php echo $newProductArray->pro_comment; ?></td>
                                </tr>
                            </table>
                        </td>
                        <td width="105" class="line_boxpro_1">
                            <?php if((int)$newProductArray->pro_cost == 0){ ?>
                            <?php echo $this->lang->line('call_main'); ?>
                            <?php }else{ ?>
                            <span  <?php if($newProductArray->pro_saleoff==1 && $newProductArray->pro_saleoff_value>0){echo "class='line-saleoff'" ;} ?> id="DivCost_<?php echo $idDiv; ?>"><?php echo number_format($newProductArray->pro_cost);?></span>&nbsp;<?php echo $newProductArray->pro_currency; ?>

							<?php if($newProductArray->pro_cost > $discount['salePrice']){ ?>
                            <br />
                            <span id="DivCostSale_<?php echo $idDiv; ?>"><?php echo number_format($discount['salePrice']);?></span>&nbsp;<?php echo $newProductArray->pro_currency; ?>
                            <?php

                            } ?>


                            <div class="usd_boxpro">
                                <?php if(strtoupper($newProductArray->pro_currency) == 'VND'){ ?>
								<!--<span id="DivCostExchange_<?php echo $idDiv; ?>"></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?>
								<script type="text/javascript">FormatCost('<?php echo round($newProductArray->pro_cost/settingExchange); ?>', 'DivCostExchange_<?php echo $idDiv; ?>');</script>-->
								<?php }else{ ?>
								<span id="DivCostExchange_<?php echo $idDiv; ?>"><?php echo number_format(round($newProductArray->pro_cost*settingExchange));?></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>

								<?php } ?>
							</div>

                            <?php if($newProductArray->pro_hondle == 1){ ?>
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
                                <option value="<?php echo $sortUrl; ?>buy/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_asc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>buy/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_desc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_asc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_desc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_asc_category'); ?></option>
                                <option value="<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_desc_category'); ?></option>
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

        <tr>
            <td height="16" ></td>
        </tr>
        <tr>
            <td height="10"></td>
        </tr>
        <tr>
            <td>
                <div class="temp_3">
                	<div class="title">
                    	<div class="fl">
                        	<h2><?php echo $this->lang->line('title_favorite_category'); ?></h2>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td  >
                <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td>
                            <table align="center" style="margin-top:6px;" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr valign="top">
                                    <?php $isCounter = 1; ?>
                                    <?php foreach($favoriteProduct as $favoriteProductArray){
                                    // Added
                                    // by le van son
                                    // Calculation discount amount
                                    $afSelect = false;
                                    /*if ($_REQUEST['af_id'] != '' && $product->is_product_affiliate == 1) {
                                        if ($userObject->use_id > 0) {
                                            $afSelect = true;
                                        }
                                    }*/

                                    $discount = lkvUtil::buildPrice($favoriteProductArray, $this->session->userdata('sessionGroup'), $afSelect);
                                    ?>
                                    <td width="12%">
                                        <div class="img_bestvote">
                                            <a class="menu_1" href="<?php echo base_url(); ?><?php echo $favoriteProductArray->pro_category; ?>/<?php echo $favoriteProductArray->pro_id; ?>/<?php echo RemoveSign($favoriteProductArray->pro_name); ?>">
                                                <input type="hidden" id="name-<?php echo 'fr'.$favoriteProductArray->pro_id;?>" value="<?php echo $favoriteProductArray->pro_name;?>"/>
                                                <input type="hidden" id="view-<?php echo 'fr'.$favoriteProductArray->pro_id;?>" value="<?php echo $favoriteProductArray->pro_view;?>"/>
                                                <input type="hidden" id="shop-<?php echo 'fr'.$favoriteProductArray->pro_id;?>" value="<?php echo $favoriteProductArray->sho_name;?>"/>
                                                <input type="hidden" id="pos-<?php echo 'fr'.$favoriteProductArray->pro_id;?>" value="<?php echo $favoriteProductArray->pre_name;?>"/>
                                                <input type="hidden" id="date-<?php echo 'fr'.$favoriteProductArray->pro_id;?>" value="<?php echo date('d/m/Y',$favoriteProductArray->sho_begindate);?>"/>
                                                <input type="hidden" id="image-<?php echo 'fr'.$favoriteProductArray->pro_id;?>" value="<?php echo base_url() ?>media/images/product/<?php echo $favoriteProductArray->pro_dir; ?>/<?php echo show_image($favoriteProductArray->pro_image); ?>"/>
                                                <div style="display:none" id="price-<?php echo 'fr'.$favoriteProductArray->pro_id;?>">
                                                     <span id="DivCostReliable_<?php echo 'fr'.$favoriteProductArray->pro_id; ?>"><?php echo number_format($discount['salePrice']);?></span>&nbsp;<?php echo $favoriteProductArray->pro_currency; ?>
                                                </div>

                                                <img alt="<?php echo($reliableProductArray->pro_name);?>" src="<?php echo base_url() ?>media/images/product/<?php echo $favoriteProductArray->pro_dir; ?>/<?php echo show_thumbnail($favoriteProductArray->pro_dir, $favoriteProductArray->pro_image); ?>" onmouseover="tooltipPicture(this,'<?php echo 'fr'.$favoriteProductArray->pro_id;?>')" id="<?php echo 'fr'.$favoriteProductArray->pro_id;?>"  class="image_boxpro"/>

                                            </a>
                                        </div>
                                    </td>
                                    <td width="38%" <?php if($isCounter % 2 != 0){ ?>style="border-right:1px #D4EDFF dotted;"<?php } ?>>
                                        <div class="title_bestvote">
                                            <a class="menu_1" href="<?php echo base_url(); ?><?php echo $favoriteProductArray->pro_category; ?>/<?php echo $favoriteProductArray->pro_id; ?>/<?php echo RemoveSign($favoriteProductArray->pro_name); ?>" title="<?php echo $this->lang->line('detail_tip'); ?>">
                                            <?php echo sub($favoriteProductArray->pro_name, 80); ?>
                                            </a>
                                        </div>
                                        <div class="descr_bestvote">
                                                <?php $vovel=array("&curren;"); ?> <?php echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel,"#",$favoriteProductArray->pro_detail))),150); ?>
                                        </div>
                                        <div class="vote_bestvote">
                                            <?php for($vote = 0; $vote < (int)$favoriteProductArray->pro_vote_total; $vote++){ ?>
                                            <img src="<?php echo base_url(); ?>templates/home/images/star1.gif" border="0" />
                                            <?php } ?>
                                            <?php for($vote = 0; $vote < 10-(int)$favoriteProductArray->pro_vote_total; $vote++){ ?>
                                            <img src="<?php echo base_url(); ?>templates/home/images/star0.gif" border="0" />
                                            <?php } ?>
                                            <font color="#004B7A"><b>[<?php echo $favoriteProductArray->pro_vote; ?>]</b></font>
                                        </div>
                                    </td>
                                    <?php if($isCounter % 2 == 0 && $isCounter < count($favoriteProduct)){ ?>
                                    </tr><tr valign="top">
                                    <?php } ?>
                                    <?php $isCounter++; ?>
                                    <?php } ?>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td height="16" ></td>
        </tr>
        <?php $this->load->view('home/advertise/footer'); ?>
    </table>
</td>
<!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($successFavoriteProduct) && $successFavoriteProduct == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_favorite_category'); ?>');</script>
<?php } ?>
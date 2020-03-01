<?php
$this->load->view('shop/common/header'); ?>

<div class="container">
	
    <div class="row" style="margin-top: 15px;">
        <div class="col-xs-12">	
            <ol id="breadcrumb" class="breadcrumb" style="white-space: nowrap; overflow: auto;">
                <li><a href="<?php echo '/'.$siteGlobal->sho_link; ?>/shop" class="home">Mua sắm</a></li>
                <li><a href="<?php echo '/'.$siteGlobal->sho_link; ?>/shop/product"><?php echo $this->lang->line('product_menu_detail_global');  ?></a></li>
                <li><span><?php echo $category_name->cat_name; ?></span></li>
            </ol>
        </div>
    </div>
   
    <div class="row">		
		<?php if(isset($siteGlobal)){ ?>
		<!--BEGIN: Center-->
			<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 pull-right">
				<div id="DivContent">
					<div class="col-xs-12 col-sm-9 col-md-9 col-lg-9">
						<?php $this->load->view('shop/common/top'); ?>
					</div>
					<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
						<select name="select_sort" class="form-control" onchange="ActionSort(this.value)">
							<option value="/name/by/asc<?php echo $pageSort; ?>">Tên sản phẩm tăng dần</option>
							<option value="/name/by/desc<?php echo $pageSort; ?>">Tên sản phẩm giảm dần</option>
							<option value="/cost/by/asc<?php echo $pageSort; ?>">Giá tăng dần</option>
							<option value="/cost/by/desc<?php echo $pageSort; ?>">Giá giảm dần</option>
							<option value="/id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
							<option value="/buy/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_asc_detail_product'); ?></option>
							<option value="/buy/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_desc_detail_product'); ?></option>
							<option value="/view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_asc_detail_product'); ?></option>
							<option value="/view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_desc_detail_product'); ?></option>
							<option value="/date/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_asc_detail_product'); ?></option>
							<option value="<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_desc_detail_product'); ?></option>
						</select>
					</div>
					<div class="clearfix"></div>
					<?php if($this->uri->segment(2) == 'afproduct'){ ?><h3>Danh sách sản phẩm Cộng Tác Viên Online</h3> <?php }else{ ?>
						<h3>Danh sách sản phẩm</h3>
					<?php } ?>
					<form name="frmListPro" method="post" action="">
						<div class="row">
							<?php $idDiv = 1; ?>
							<?php foreach($product as $productArray){
								// Added
								// by le van son
								// Calculation discount amount
								$afSelect = false;
								/*if ($_REQUEST['af_id'] != '' && $product->is_product_affiliate == 1) {
                                    if ($userObject->use_id > 0) {
                                        $afSelect = true;
                                    }
                                }*/
								$discount = lkvUtil::buildPrice($productArray, $this->session->userdata('sessionGroup'), $afSelect);
								?>
								<div class="col-md-4 col-sm-6">
									<div class="product-item text-center">
										
											<div class="thumbox">
												<?php $img = 'media/images/product/'.$productArray->pro_dir.'/'.show_thumbnail($productArray->pro_dir, $productArray->pro_image,3);?>
											<?php if($this->uri->segment(2) == 'afproduct'){ ?>
											<a target="_blank" href="<?php echo $mainURL; ?><?php echo $productArray->pro_category; ?>/<?php echo $productArray->pro_id; ?>/<?php echo RemoveSign($productArray->pro_name)?>" title="<?php echo $productArray->pro_name; ?>">
												<?php }else{ ?>
												<a href="<?php echo $URLRoot; ?>/product/detail/<?php echo $productArray->pro_id; ?>/<?php echo RemoveSign($productArray->pro_name)?>" title="<?php echo $productArray->pro_name; ?>">
											<?php } ?>
													<input type="hidden" id="name-<?php echo $productArray->pro_id;?>" value="<?php echo $productArray->pro_name;?>"/>
													<input type="hidden" id="view-<?php echo $productArray->pro_id;?>" value="<?php echo $productArray->pro_view;?>"/>
													<input type="hidden" id="shop-<?php echo $productArray->pro_id;?>" value="<?php echo $productArray->sho_name;?>"/>
													<input type="hidden" id="pos-<?php echo $productArray->pro_id;?>" value="<?php echo $productArray->pre_name;?>"/>
													<input type="hidden" id="date-<?php echo $productArray->pro_id;?>" value="<?php echo date('d/m/Y',$productArray->sho_begindate);?>"/>
													<input type="hidden" id="image-<?php echo $productArray->pro_id;?>" value="<?php echo $URLRoot ?>media/images/product/<?php echo $productArray->pro_dir; ?>/<?php echo show_image($productArray->pro_image); ?>"/>
											<span style="display:none" id="price-<?php echo $productArray->pro_id;?>">
												<span id="DivCostReliable_<?php echo $productArray->pro_id; ?>"><?php echo number_format($discount['salePrice']);?></span>&nbsp;<?php echo $productArray->pro_currency; ?></span>
													<?php if (file_exists($img) && $productArray->pro_image != ''){?>
													<img alt="<?php echo $productArray->pro_name;?>" src="<?php echo $URLRoot.$img; ?>" onmouseover="tooltipPicture(this,'<?php echo $productArray->pro_id;?>')" id="<?php echo $productArray->pro_id;?>"  class="img-responsive"/>
													<?php }else{ ?>
														<img src="<?php echo $URLRoot; ?>media/images/no_photo_icon.png" class="img-responsive" alt="">
													<?php }?>
												</a>
										</div>
										<h4>
											<?php if($this->uri->segment(2) == 'afproduct'){ ?>
											<a target="_blank" href="<?php echo $mainURL; ?><?php echo $productArray->pro_category; ?>/<?php echo $productArray->pro_id; ?>/<?php echo RemoveSign($productArray->pro_name)?>" title="<?php echo $productArray->pro_name; ?>">
												<?php }else{ ?>
												<a href="product/detail/<?php echo $productArray->pro_id; ?>/<?php echo RemoveSign($productArray->pro_name)?>" title="<?php echo $productArray->pro_name; ?>">
													<?php } ?>
											<span class="pro_name"><?php echo $productArray->pro_name; ?></span>
												</a>
										</h4>
										<?php if($productArray->pro_cost > $discount['salePrice']){ ?>
											<div class="saleoff">
												<img src="/templates/shop/default/images/saleoff.png"/>
											</div>
										<?php } ?>										

										<?php if((int)$productArray->pro_cost == 0){ ?>
											<div class="price"><?php echo $this->lang->line('call_main'); ?></div>
										<?php } else { ?>
											<div class="price">
												<?php if($productArray->pro_cost > $discount['salePrice']){ ?>
													<span id="DivCostSale_<?php echo $idDiv; ?>" class="sale-price" ><?php echo number_format($discount['salePrice']);?></span> <?php echo $productArray->pro_currency; ?>
												<?php } ?>
												&nbsp;
												<span id="DivCost_<?php echo $idDiv; ?>"  <?php if($productArray->pro_cost > $discount['salePrice'] ){echo "class='cost-price'" ;} else {echo "class='sale-price'";} ?>><?php echo number_format($productArray->pro_cost);?></span> <?php echo $productArray->pro_currency; ?>

												<div class="usd_boxpro">
													<?php if(strtoupper($productArray->pro_currency) == 'VND'){ ?>
													<?php }else{ ?>
														<span id="DivCostExchange_<?php echo $idDiv; ?>"><?php echo number_format(round((int)$productArray->pro_cost*settingExchange));?></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>

													<?php } ?>
												</div>

												<?php if((int)$productArray->pro_hondle == 1){ ?>
													<div class="nego_boxpro"><img src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/hondle.gif" border="0" /></div>
												<?php } ?>
											</div>
										<?php } ?>

										<div class="button-group">
											<button class="btn btn-default  addToCart" type="button" title="" onclick="#"><i class="fa fa-shopping-cart"></i>&nbsp;</button>
											<button class="btn btn-default  wishlist" type="button" title="" onclick="#"><i class="fa fa-heart"></i>&nbsp;</button>
											<button class="btn btn-default  compare" type="button" title="" onclick="#"><i class="fa fa-exchange"></i>&nbsp;</button>
											<button class="btn btn-default  quickview" type="button" title="" onclick="#"><i class="fa fa-eye"></i>&nbsp;</button>
										</div>
									</div>
								</div>
								<?php $idDiv++; ?>
							<?php } ?>
						</div>
						<div class="linkPage"><?php echo $linkPage; ?></div>
					</form>
				</div>
				<div id="DivSearch">
					<?php $this->load->view('shop/common/search'); ?>
				</div>
				<script>OpenSearch(0);</script>
				<div style="height:30px;"></div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 pull-left">
				<?php $this->load->view('shop/common/left'); ?>
				<?php $this->load->view('shop/common/right'); ?>
			</div>
		<!--END Center-->
		<?php } ?>
	</div>
</div>
<?php $this->load->view('shop/common/footer'); ?>
<?php 
    if($siteGlobal->sho_mobile){
        $phonenumber = $siteGlobal->sho_mobile;
    } elseif($siteGlobal->sho_phone){
        $phonenumber = $siteGlobal->sho_phone;
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
<script>alert('<?php echo $this->lang->line('success_add_favorite_message_detail_product'); ?>');</script>
<?php } ?>
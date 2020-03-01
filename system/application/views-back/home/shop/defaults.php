<?php
global $idHome;
$idHome=1;
?>
<?php $this->load->view('home/common/header'); ?>

<!--BEGIN: CENTER-->
<div class="container-fluid">

	<div class="navigate">
		<a href="<?php echo base_url() ?>" class="home">Home</a>
		<?php if(isset($CategorysiteGlobalRoot->cat_id)) { ?>
		<img alt=""  src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>
		<?php } ?>
		<?php if($siteGlobal->cat_id!="") ?>
		<?php { ?>
		<img alt=""  src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/><span>Gian hàng</span>
		<?php } ?>
	</div>
	<div class="row">
		<?php $this->load->view('home/common/left'); ?>
		<div class="col-lg-6">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding: 0 10px;">
			<?php $this->load->view('home/advertise/center1'); ?>
			<tr>
				<td>
					<h2><?php echo $this->lang->line('title_interest_defaults'); ?></h2>
				</td>
			</tr>
			<tr>
				<td>
					<table align="center" style="margin-top:6px;" width="100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td valign="top">
								<div class="row">
								<?php $idDiv = 1; ?>
								<?php foreach($interestShop as $interestShopArray){ ?>
								<div class="col-lg-3 col-md-3 col-sm-3 showbox_2" id="DivInterestShopBox_<?php echo $idDiv; ?>">
									<a target="_blank" href="<?php echo base_url(); ?><?php echo $interestShopArray->sho_link; ?>" title="<?php echo $interestShopArray->sho_descr; ?>">
										<img alt="<?php echo ($interestShopArray->sho_descr); ?>" src="<?php echo base_url(); ?>media/shop/logos/<?php echo $interestShopArray->sho_dir_logo; ?>/<?php echo $interestShopArray->sho_logo; ?>" class="image_showbox_2" />
									</a>
								</div>
								<?php $idDiv++; ?>
								<?php } ?>
								</div>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<?php $this->load->view('home/advertise/center2'); ?>
			<tr>
				<td>
					<h2><?php echo $this->lang->line('title_new_defaults'); ?></h2>
				</td>
			</tr>
			<tr>
				<td>
					<table align="center" width="100%" style="border:1px #D4EDFF solid; margin-top:5px;" cellpadding="0" cellspacing="0">
						<tr class="v_height29">
							<td width="110" class="title_boxshop_1"><?php echo $this->lang->line('logo_list'); ?></td>
							<td class="title_boxshop_2">
								<?php echo $this->lang->line('shop_list'); ?>
								<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;"  alt="" />
								<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;"  alt="" />
							</td>
							<td width="150" class="title_boxshop_1">
								<?php echo $this->lang->line('address_list'); ?>
								<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>address/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;"  alt="" />
								<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>address/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;"  alt="" />
							</td>
						</tr>
						<?php foreach($shop as $shopArray){ ?>
						<tr>
							<td width="110" class="line_boxshop_1">
								<a class="menu" target="_blank" href="<?php echo base_url(); ?><?php echo $shopArray->sho_link; ?>" title="<?php echo $this->lang->line('access_shop_tip'); ?>">
									<img alt="<?php echo ($shopArray->sho_name); ?>" src="<?php echo base_url(); ?>media/shop/logos/<?php echo $shopArray->sho_dir_logo; ?>/<?php echo $shopArray->sho_logo; ?>" class="image_boxshop" />
								</a>
							</td>
							<td valign="top" class="line_boxshop_2">
								<a class="menu_1" href="<?php echo base_url(); ?><?php echo $shopArray->sho_link; ?>" title="<?php echo $this->lang->line('access_shop_tip'); ?>">
									<?php echo $shopArray->sho_name; ?>
								</a>
								<div class="descr_boxshop">
									<?php echo $shopArray->sho_descr; ?>
								</div>
								<table style="margin-top:10px;" border="0" width="100%" cellpadding="0" cellspacing="0">
									<tr>
										<td width="41%" class="saleoff_boxshop">
											<?php if($shopArray->sho_saleoff == 1){ ?>
											<img src="<?php echo base_url(); ?>templates/home/images/saleoff_shop.gif" border="0"  alt="" />
											<?php } ?>
										</td>
										<td class="vr_boxshop"><?php echo $this->lang->line('access_defaults'); ?>:&nbsp;<?php echo $shopArray->sho_view; ?>&nbsp;<b>|</b>&nbsp;<?php echo $this->lang->line('quantity_product_defaults'); ?>:&nbsp;<?php echo $shopArray->sho_quantity_product; ?></td>
									</tr>
								</table>
							</td>
							<td width="150" class="line_boxshop_1">
								<div class="address_boxshop"><?php echo $shopArray->sho_address; ?>, <?php echo $shopArray->pre_name; ?></div>
								<div class="phone_boxshop">(<?php echo $this->lang->line('phone_defaults'); ?>: <?php echo $shopArray->sho_phone; ?>)</div>
								<?php if(trim($shopArray->sho_yahoo) != ''){ ?>
								<div class="status_yahoo"><a href="ymsgr:SendIM?<?php echo $shopArray->sho_yahoo; ?>"><img src="//opi.yahoo.com/online?u=<?php echo $shopArray->sho_yahoo; ?>&amp;m=g&amp;t=1" border="0" alt="" /></a></div>
								<?php } ?>
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
									<option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_asc_by_view_defaults'); ?></option>
									<option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_desc_by_view_defaults'); ?></option>
									<option value="<?php echo $sortUrl; ?>product/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_asc_by_quantity_product_defaults'); ?></option>
									<option value="<?php echo $sortUrl; ?>product/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_desc_by_quantity_product_defaults'); ?></option>
								</select>
							</td>
							<td width="37%" class="show_page"><?php echo $linkPage; ?></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td  height="16" ></td>
			</tr>
			<?php $this->load->view('home/advertise/center3'); ?>
		</table>
		</div>

		<?php $this->load->view('home/common/right'); ?>

	</div>
</div>
<!-- END CENTER-->

<?php $this->load->view('home/common/footer'); ?>
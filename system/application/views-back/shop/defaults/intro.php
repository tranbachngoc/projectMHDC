<?php
$this->load->view('shop/common/header'); ?>
<?php //$this->load->view('shop/common/left'); ?>
<?php if (isset($siteGlobal)) { ?>
    <script language="javascript" src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/jquery.js"></script>
    <script language="javascript" src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/ajax.js"></script>
    <!--BEGIN: Center-->

    <div id="main" class="style_<?php echo $siteGlobal->sho_style; ?>">
        <div class="container">            
           <div class="row" style="margin-top: 20px;">     
                <div class="col-xs-12">
                    <ol id="breadcrumb" class="breadcrumb" style="white-space: nowrap; overflow: auto;">
                        <li><a href="/"><?php echo $this->lang->line('index_page_menu_detail_global'); ?></a></li>
                        <li class="active"><?php echo $this->lang->line('index_page_menu_introduct_global'); ?></li>
                    </ol>
                </div>
            </div>
            <div class="row">                
                <div class="article col-lg-9 col-md-9 col-sm-8 col-xs-12 pull-right">                   
                    
                        <?php if (isset($introduction)) : ?>
                            <div id="introduction">
                                <h3><i class="fa fa-info-circle fa-fw" aria-hidden="true"></i> Giới thiệu gian hàng</h3>
				
				
				<table class="table table-bordered ">
                                    <tbody>
                                    <tr>
                                        <td align="left" width="150">Tên gian hàng</td>
					<td><strong><?php echo $siteGlobal->sho_name ?></strong></td>
                                    <tr>
                                        <td align="left">Mô tả gian hàng</td>
                                        <td><?php echo $siteGlobal->sho_descr ?></td>
                                    </tr>
                                    
                                    <tr>
                                        <td align="left">Ngày tham gia</td>
                                        <td><?php echo date('d/m/Y', $siteGlobal->sho_begindate) ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left">Địa chỉ</td>
                                        <td>
					    <?php echo $siteGlobal->sho_address ?> - 
					    <?php echo $siteGlobal->sho_district ?> - 
					    <?php echo $siteGlobal->sho_province ?>
					</td>
                                    </tr>				    
                                    <tr>
                                        <td align="left">Điện thoại</td>
                                        <td><?php echo $siteGlobal->sho_phone ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left">Mobile</td>
                                        <td><?php echo $siteGlobal->sho_mobile ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left">Website</td>
                                        <td><?php echo $siteGlobal->sho_website ?></td>
                                    </tr>
                                    <tr>
                                        <td align="left">Email</td>
                                        <td><?php echo $siteGlobal->sho_email ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                                
                                <?php echo $introduction; ?>
                            </div>
                        <?php endif; ?>
		        
			<?php if (isset($company_profile) && $company_profile != '') { ?>
			 
			    <div id="company_profile">
				<h3><i class="fa fa-folder-open fa-fw" aria-hidden="true"></i> Hồ sơ công ty</h3>
				<?php echo $company_profile; ?>                                
			    </div>
			<?php } ?>


			<?php if (isset($certificate) && $certificate !=''){ ?>
			
			<div id="certificate">
			    <h3><i class="fa fa-certificate fa-fw" aria-hidden="true"></i> Các chứng nhận</a></h3>
			    <?php echo $certificate; ?>
			</div>                               
			<?php }?>


			<?php if (isset($trade_capacity) && $trade_capacity != ''){ ?>
			
			<div id="trade_capacity">
			    <h3><i class="fa fa-check-square-o fa-fw" aria-hidden="true"></i> Năng lực thương mại</a></h3>
			    <?php echo $trade_capacity; ?>                                
			</div>
			<?php } ?>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 pull-left">
                    <?php $this->load->view('shop/common/left'); ?>
                    <?php $this->load->view('shop/common/right'); ?>
                </div>
            </div>
        </div>
    </div>
    <!--END Center-->
<?php } ?>

<?php $this->load->view('shop/common/footer'); ?>

<?php $this->load->view('shop/common/header'); ?>
<script>
jQuery(document).ready(function() {
	jQuery('.image_boxpro').mouseover(function(){
		tooltipPicture(this,jQuery(this).attr('id'));
	});	
});
</script>
<style >
	.search_top{
		margin-left:20px;
	}
</style>
<?php if(isset($siteGlobal)){ ?>
<!--BEGIN: Center-->
    <div class="container">
        <div class="row">
            <div class="col-xs-12">	
                <ol id="breadcrumb" class="breadcrumb" style="white-space: nowrap; overflow: auto;">
                    <li><a href="<?php echo $URLRoot; ?>" class="home"><?php echo $this->lang->line('index_page_menu_detail_global'); ?></a></li>
                    <li><a href="<?php echo $URLRoot; ?>product"><?php echo $this->lang->line('product_menu_detail_global'); ?></a></li>
                    <li><span>Tìm kiếm</span></li>
                </ol>
            </div>
        </div>
	<div class="row">
        <div class="col-sm-3 col-xs-12">
            <?php $this->load->view('shop/common/left'); ?>
            <?php $this->load->view('shop/common/right'); ?>
        </div>
        <div class="col-sm-9 col-xs-12">

               <div id="cat_shop" class="row">
                   <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                               <?php $this->load->view('shop/common/top'); ?>
                   </div>
                   <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                       <select name="select_sort" class="form-control" onchange="ActionSort(this.value)">
                           <option value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                           <option value="<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>">Tên sản phẩm A&rarr;Z</option>
                           <option value="<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>">Tên sản phẩm Z&rarr;A</option>
                           <option value="<?php echo $sortUrl; ?>cost/by/asc<?php echo $pageSort; ?>">Giá sản phẩm tăng dần</option>
                           <option value="<?php echo $sortUrl; ?>cost/by/desc<?php echo $pageSort; ?>">Giá sản phẩm giảm dần</option>
                           <option value="<?php echo $sortUrl; ?>buy/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_asc_detail_product'); ?></option>
                           <option value="<?php echo $sortUrl; ?>buy/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_desc_detail_product'); ?></option>
                           <option value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_asc_detail_product'); ?></option>
                           <option value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_desc_detail_product'); ?></option>
                           <option value="<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_asc_detail_product'); ?></option>
                           <option value="<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_desc_detail_product'); ?></option>
                       </select>
                   </div>
               </div>
               <div class="page-title">
                   <h3>Kết quả tìm kiếm</h3>
               </div>
                 <?php if(isset($searchProduct) && count($searchProduct) > 0){ ?>
                       <form name="frmListPro" method="post" action="">
                           <div class="row">
                               <?php $idDiv = 1; ?>
                               <?php foreach($searchProduct as $productArray){
                                   // Added
                                   // by le van son
                                   // Calculation discount amount
                                   $afSelect = false;
                                   $discount = lkvUtil::buildPrice($productArray, $this->session->userdata('sessionGroup'), $afSelect);
                                   ?>
                                   <div class="col-lg-4 col-md-4 col-sm-6">
                                       <?php $this->load->view('shop/product/shop_item', array('product' => $productArray, 'discount' => $discount, 'shop_link'=> $siteGlobal->sho_link)); ?>
                                   </div>
                                   <?php $idDiv++; ?>
                               <?php } ?>
                           </div>
                           <div class="linkPage"><?php echo $linkPage; ?></div>
                           <div class="row">
                               <!--<div class="col-sm-8 col-md-8 col-lg-8">
								<input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmListPro',0)" /> Chọn tất cả &nbsp;
								<button class="btn btn-default" onclick="Favorite('frmListPro', '<?php /*if(isset($isLogined) && $isLogined == true){echo 1;}else{echo $this->lang->line('must_login_message');} */?>')" style="cursor:pointer;"><i class="fa fa-thumbs-o-up"></i> Thêm vào yêu thích </button>
						</div>-->

                           </div>
                       </form>
                 <?php }else{ ?>
                     <div class="alert alert-warning alert-dismissible" role="alert">
                         Không có sản phẩm nào được tìm thấy!
                     </div>
                 <?php } ?>
                       <!--div id="DivSearch">
				<?php //$this->load->view('shop/common/search'); ?>
			</div-->
                       <script>OpenSearch(0);</script>
                       <div style="height:30px;"></div>
       </div>
    </div>
</div>
<!--END Center-->
<?php } ?>
<?php $this->load->view('shop/common/footer'); ?>
<?php if(isset($successFavoriteProduct) && $successFavoriteProduct == true){ ?>
<script>alert('<?php echo $this->lang->line('success_add_favorite_detail_search'); ?>');</script>
<?php } ?>
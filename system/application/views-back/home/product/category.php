<?php $this->load->view('home/common/header'); ?>
<!--BEGIN: CENTER-->
<script type="text/javascript">
    function sortby(val) {
        var filterForm = $('#formfilter');
        filterForm.find('input[name="sort"]').val(val);
        filterForm.submit();
    }

    function searchType(val) {
        var filterForm = $('#formfilter');
        filterForm.find('input[name="type"]').val(val);
        filterForm.submit();
    }

</script>
<script src="/templates/home/js/home_news.js"></script>
<style type="text/css">
    .product-item img[data-src] {
        opacity: 0;
    }
</style>
<?php if($siteGlobal->cate_type == 2) { $folder = 'coupons'; } else { $folder = 'products';} ?>

<div id="main" class="container-fluid">
    <div id="cat_page" class="row rowmain">        
        <div class="col-lg-2 col-md-3 col-sm-3 hidden-xs">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-10 col-md-9 col-sm-9 col-xs-12">
        <div class="row"> 
            <div class="col-xs-12">
                <ol id="breadcrumb" class="breadcrumb" style="white-space: nowrap; overflow: auto;">
					<li><a href="/shop/<?php echo $folder; ?>" class="home">Mua sắm</a></li>
					<?php if (isset($CategorysiteGlobalRoot->cat_id)) { ?>
                    <li><a href="<?php echo base_url() ?><?php echo $CategorysiteGlobalRoot->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobalRoot->cat_name); ?>"
                           title="<?php echo $CategorysiteGlobalRoot->cat_name; ?>"><?php echo mb_substr($CategorysiteGlobalRoot->cat_name, 0, 30, 'UTF-8'); ?></a></li>
                    <?php } ?>
                    <?php if (isset($CategorysiteGlobal->cat_id)) { ?>
                    <li><a rel="v:url" property="v:title"
                           href="<?php echo base_url() . $CategorysiteGlobal->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobal->cat_name); ?>"
                           title="<?php echo $CategorysiteGlobal->cat_name; ?>">
                               <?php echo mb_substr($CategorysiteGlobal->cat_name, 0, 30, 'UTF-8'); ?>
                        </a>
                    </li>
					<?php } ?>

					<?php if ($siteGlobal->cat_id != "") { ?>
                    <li>
                        <?php
                        if ($catlv2 < 1) {
                            echo ' <span>' . $siteGlobal->cat_name . '</span>';
                        } elseif ($catlv2 >= 2 && $endCat == 0) {
                            echo ' <a class="show_sub_cat" href="javascript:void(0)">' . $siteGlobal->cat_name . '<i class="fa fa-sort-desc" aria-hidden="true"></i></a>';
                        } else {
                            echo ' <span>' . $siteGlobal->cat_name . '</span>';
                        }
                        ?>
                    </li>
					<?php } ?>
				</ol> 
            </div>
        </div>            
       
        <div class="row">
            <div class="col-xs-12">
                <div style="background: #fff; padding: 0px;">
                    <div style="white-space: nowrap; overflow: auto; border-bottom: 1px solid #fff; border-top: 0px solid #fff;">
                        <?php
                        if (isset($categorylv1) && count($categorylv1) > 0) {
                            foreach ($categorylv1 as $k => $catitem) { 
                                $catlink = base_url() . $catitem->cat_id . '/' . RemoveSign($catitem->cat_name);
                                ?>
                                <div style="display: inline-block; width: 100px; margin: 10px; text-align:center; white-space: normal;">
                                    <a href="<?php echo $catlink ?>" title="<?php echo $catitem->cat_name ?>">
                                        <?php
                                        if ($catitem->cat_level == 1) {                                            
                                            if ($catitem->cat_image!="") { ?>
                                                <img style="height:70px; border-radius:50%; border:1px solid #999;  margin-bottom: 10px;" src="<?php echo DOMAIN_CLOUDSERVER.'media/images/categories/' . $catitem->cat_image; ?>"/>
                                            <?php } else { ?>                                                
                                                <img style="height:70px; border-radius:50%; border:1px solid #999;  margin-bottom: 10px;" src="/images/noimage.jpg"/>
                                            <?php } ?>
                                        <?php } ?>
                                        <span style="display: block; height: 50px; overflow: hidden; margin-top: 10px;"><?php echo $catitem->cat_name ?></span>
                                    </a>
                                </div>
                                <?php
                            } //endforeach
                        } //endif 
                        ?>
                    </div>
                </div>
            </div>
        </div>
<br>

            <?php
            $tab_title = '';
            if ($siteGlobal->cate_type == 1) {
                $tab_title = 'Dịch vụ';
            } elseif ($siteGlobal->cate_type == 2) {
                $tab_title = 'Coupon';
            } else {
                $tab_title = 'Sản phẩm';
            }
            ?>
            <div class="row">    
                <div class="col-xs-12">    
                    <ul id="tabcategory" class="text-center" role="tablist"> 
                        <li role="presentation" class="active">
                            <a href="#tab1" aria-controls="tab1" role="tab" data-toggle="tab">
                                <span class="hidden-sm"><?php echo $tab_title; ?></span> mới nhất
                            </a>
                        </li>
                        <li class="" role="presentation">
                            <a href="#tab2" aria-controls="tab2" role="tab" data-toggle="tab">
                                <span class="hidden-sm"><?php echo $tab_title; ?></span> mua nhiều
                            </a>
                        </li>
                        <li class="" role="presentation">
                            <a href="#tab3" aria-controls="tab3" role="tab" data-toggle="tab">
                                <span class="hidden-sm"><?php echo $tab_title; ?></span> khuyến mãi
                            </a>
                        </li>
                        <?php
                        if($this->session->userdata('sessionUser')){
                        ?>
                        <li class="" role="presentation">
                            <a href="#tab4" aria-controls="tab4" role="tab" data-toggle="tab">
                                <span class="hidden-sm"><?php echo $tab_title; ?></span> có nhiều lượt thích
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                 </div>
            </div>  

            <div class="tab-content" style="margin-top:10px">
                <div role="tabpanel" class="tab-pane fade in active" id="tab1">
                    <div class="row products text-center">
                        <?php if ($newProduct): ?>
                            <?php
                            foreach ($newProduct as $k => $product) :
                                // Added
                                // by le van son
                                // Calculation discount amount
                                $afSelect = false;
                                $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 <?php
                                if ($k > 5) {
                                    echo 'hidden-xs hidden-sm';
                                }
                                ?>">
                                         <?php $this->load->view('home/product/single_product', array('product' => $product, 'discount' => $discount)); ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-xs-12 ">
                                <p class="alert alert-danger"><?php echo $this->lang->line('notfound_product'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab2">
                    <div class="row products text-center">
                        <?php if ($topBuyestProduct): ?>
                            <?php
                            foreach ($topBuyestProduct as $k => $product) :
                                // Added
                                // by le van son
                                // Calculation discount amount
                                $afSelect = false;
                                $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 <?php
                                if ($k > 5) {
                                    echo 'hidden-xs hidden-sm';
                                }
                                ?>">
                                         <?php $this->load->view('home/product/single_product', array('product' => $product, 'discount' => $discount)); ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-xs-12 ">
                                <p class="alert alert-danger"><?php echo $this->lang->line('notfound_product'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab3">
                    <div class="row products text-center">
                        <?php if ($topSaleoffProduct): ?>
                            <?php
                            foreach ($topSaleoffProduct as $k => $product) :
                                // Added
                                // by le van son
                                // Calculation discount amount
                                $afSelect = false;
                                $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 <?php
                                if ($k > 5) {
                                    echo 'hidden-xs hidden-sm';
                                }
                                ?> item_sale">
                                     <?php if ($product->pro_saleoff == 1) { ?>
                                        <div class="saleoff">
                                            <img
                                                src="<?php echo base_url(); ?>templates/shop/default/images/saleoff.png">
                                        </div>
                                    <?php } ?>
                                    <?php $this->load->view('home/product/single_product', array('product' => $product, 'discount' => $discount)); ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-xs-12 ">
                                <p class="alert alert-danger"><?php echo $this->lang->line('notfound_product'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab4">
                    <div class="row products text-center">
                        <?php if ($favoriteProduct): ?>
                            <?php
                            foreach ($favoriteProduct as $k => $product) :
                            // Added
                                // by le van son
                                // Calculation discount amount
                                $afSelect = false;
                                /* if ($_REQUEST['af_id'] != '' && $product->is_product_affiliate == 1) {
                                  if ($userObject->use_id > 0) {
                                  $afSelect = true;
                                  }
                                  } */
                                $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                                ?>
                                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-6 <?php
                                if ($k > 5) {
                                    echo 'hidden-xs hidden-sm';
                                }
                                ?>">
                                 <?php $this->load->view('home/product/single_product', array('product' => $product, 'discount' => $discount)); ?>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-xs-12 ">
                                <p class="alert alert-danger"><?php echo $this->lang->line('notfound_product'); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div> 
            <hr>
       <?php //if ($catlv2  >= 1) {  ?>
            <div class="row">
                <div class="col-xs-12 col-sm-8">
                    <?php echo '<h3 style="margin:0px;">' . $siteGlobal->cat_name . '</h3>'; ?>
                </div>
                <div class="col-xs-12 col-sm-4 text-right">
                    <button type="button" id="filter" class="btn btn-default" data-toggle="modal" data-target="#myFilter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                    <button type="button" id="grid" class="btn btn-default"><i class="fa fa-th" aria-hidden="true"></i></button>
                    <button type="button" id="list" class="btn btn-default"><i class="fa fa-list" aria-hidden="true"></i></button>
                </div>
            </div>

            <?php if (count($reliableProduct) > 0) { ?>
                <div id="products" class="products text-center row">                
                    <?php $idDiv = 1; ?>
                    <?php
                    foreach ($reliableProduct as $product) {
                        // Added
                        // by le van son
                        // Calculation discount amount
                        $afSelect = false;
                        $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                        ?>
                        <div class="item col-lg-3 col-md-4 col-sm-4 col-xs-6" id="DivReliableProductBox_<?php echo $idDiv; ?>">
                            <?php $this->load->view('home/product/single_product', array('product' => $product, 'discount' => $discount)); ?>
                        </div>
                        <?php $idDiv++; ?>
                    <?php } ?>
                </div>
                <div class="row linkPage text-center">
                    <div class="col-md-12"> <?php echo $linkPage ?> </div>
                </div>
            <?php } else { ?>
                <div class="alert alert-info"> Danh mục chưa có sản phẩm</div>
            <?php } ?>
        <?php //}  ?>                    

        <div class="clearfix"></div>
        <?php if ($catlv2 < 1) { ?>
            <hr/>
            <style>
                .grid-container {
                  display: grid;
                  grid-gap: 20px 20px;
                  grid-template-columns: auto auto auto auto auto auto;
                  margin: 20px 0;
                }
               .grid-container .grid-item {
                  background-color: rgba(255, 255, 255, 0.8);
                  border: 1px solid rgba(0, 0, 0, 0.8);
                  padding: 0px;
                  text-align: center;
                }

                .grid-container .grid-item:first-child {grid-row: 1 / 3; grid-column: 1 / 5;}
                
                
                @media screen and (max-width: 1024px) {                    
                    .grid-container { grid-template-columns: auto auto auto auto;  }
                    .grid-container .grid-item:first-child {grid-row: 1 / 3; grid-column: 1 / 5;}
                }

                @media screen and (max-width: 767px) {                    
                    .grid-container { grid-template-columns: auto auto;  }
                    .grid-container .grid-item:first-child {grid-row: 1 / 3; grid-column: 1 / 3;}
                }
                
            </style>
            
            <div class="grid-container">
                <div class="grid-item"><img style="width:100%; height: 100%" src="/media/banners/default/default_580_400.jpg"/></div>
                <div class="grid-item"><img style="width:100%; height: 100%" border="0" src="/media/banners/default/default_200_200.jpg"></div>
                <div class="grid-item"><img style="width:100%; height: 100%" border="0" src="/media/banners/default/default_200_200.jpg"></div>
                <div class="grid-item"><img style="width:100%; height: 100%" border="0" src="/media/banners/default/default_200_200.jpg"></div>
                <div class="grid-item"><img style="width:100%; height: 100%" border="0" src="/media/banners/default/default_200_200.jpg"></div>
            </div>
            
        <?php } ?>
    </div>
    </div>
</div>
<!-- END CENTER-->
<!-- Modal -->
<div class="modal fade" id="myFilter" tabindex="-1" role="dialog" aria-labelledby="myFilterLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <!-- <span class="modal-title" id="myModalLabel">Lọc sản phẩm</span> -->
            </div>
            <div class="modal-body" style="background: #eee;">                
               
                <form id="formfilter" method="get" action="<?php echo base_url() . $siteGlobal->cat_id . '/' . RemoveSign($siteGlobal->cat_name); ?>" class="form">
                   
                    <p class="text-center"><strong>Sắp xếp theo</strong></p>                
                    <div class="row">
                        <p class="col-xs-6">                            
                            <a class="btn btn-block <?php echo ($filter['sort'] == 'product') ? 'btn-info at_db' : 'btn-default'; ?>"
                               onclick="sortby('product')"
                               href="javascript:void(0);">Mới cập nhật</a>
                        </p>
                        <p class="col-xs-6">      
                                <a class="btn btn-block <?php echo ($filter['sort'] == 'seller') ? 'btn-info' : 'btn-default'; ?>"
                                   onclick="sortby('seller')"
                                   href="javascript:void(0);">Bán chạy nhất</a>
                        </p>                   
                    </div>

                    <hr/>

                    <p class="text-center"><strong>Lọc sản phẩm</strong></p>                
                    <div class="row">
                        <div class="col-xs-6">
                            <a class="btn  btn-block <?php echo ($filter['type'] != 'discount') ? 'btn-info' : 'btn-default'; ?>" onclick="searchType('all')" href="javascript:void(0);">Tất Cả</a>
                        </div>

                        <div class="col-xs-6">
                            <a class="btn  btn-block <?php echo ($filter['type'] == 'discount') ? 'btn-info' : 'btn-default'; ?>" onclick="searchType('discount')" href="javascript:void(0);">Đang giảm giá</a>
                        </div>                     
                    </div>
                    
                    <hr/>
                    <p class="text-center"><strong>Tìm kiếm sản phẩm</strong></p>
                    <div class="row">
                        <p class="col-xs-12 col-sm-2">
                            <input type="text"  class="form-control" name="pf"
                                value="<?php echo @$filter['pf']; ?>"
                                placeholder="Giá từ" />
                        </p>
                        <p class="col-xs-12 col-sm-2">
                            <input type="text"  class="form-control" name="pt"
                                value="<?php echo @$filter['pt']; ?>"
                                placeholder="Giá đến"  />
                        </p>
                        <p class="col-xs-12 col-sm-6">
                            <input type="text" class="form-control" name="pro_name"
                                value="<?php echo @$filter['pro_name']; ?>"
                                placeholder="Tên sản phẩm" />
                        </p>
                        <p class="col-xs-12 col-sm-2">
                            <button type="submit" class="btn btn-azibai btn-block"><i class="fa fa-search fa-fw" aria-hidden="true"></i> Tìm</button>
                            <input type="hidden" name="sort" value="<?php echo @$filter['sort']; ?>"/>
                            <input type="hidden" name="type" value="<?php echo @$filter['type']; ?>"/>
                        </p>
                    </div>
                    <?php if ((isset($categorylv1) && count($categorylv1) > 0) || (isset($categorylv2) && count($categorylv2) > 0)) { ?>
                        <?php if (isset($categorylv1) && count($categorylv1) > 0) { ?>
                    <hr/>
                    <p class="text-center"><strong>Xem theo danh mục con</strong></p>
                        <div class="row">
                            <?php foreach ($categorylv1 as $k => $catitem) {
                                $subcat = $catitem->cat_level2;                                    
                                ?>                                        
                                <div class="col-xs-12 col-sm-6 <?php if (count($subcat) > 0) { echo 'has_child'; } ?>" style="margin-bottom: 20px; ">
                                    <div style="border:1px solid #ddd; padding: 5px 10px; background: #f5f5f5;">
                                        <a href="<?php echo base_url() ?><?php echo $catitem->cat_id; ?>/<?php echo RemoveSign($catitem->cat_name); ?>">
                                            <?php echo $catitem->cat_name; ?>
                                            <?php
                                            if (count($subcat) > 0) {
                                                echo '<i class="fa fa-sort-desc pull-right" aria-hidden="true"></i>';
                                            }
                                            ?>
                                         </a>
                                    </div>                                        
                                </div>                                        
                            <?php } ?>
                        </div>
                        <?php } ?>
                    <?php } ?>
                </form>
            </div>            
        </div>
    </div>
</div>

<?php $this->load->view('home/common/footer'); ?>

<?php if (isset($successFavoriteProduct) && $successFavoriteProduct == true) { ?>
    <script>alert('<?php echo $this->lang->line('success_add_favorite_category'); ?>');</script>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#Province').change(function () {
            $.ajax({
                url: siteUrl + 'save-province',
                type: 'post',
                data: {province: $("#Province").val()}
            }).done(function (response) {
                if (response == "1") {
                    window.location.reload();
                } else {
                    alert("Lỗi trình duyệt! Vui lòng xóa cache");
                    return false;
                }
            });
        });
        $('.full_item_hd').css('display', 'none');
        $('#btn_show_more').click(function () {
            $('.full_item_hd').slideToggle();
        });
    });
    function clickShow() {
        $('.full_item_hd').slideToggle();
    }
	
	$('.left-scrollfix').scrollToFixed( { 
		marginTop: function() { 
			var marginTop = $(window).height() - $(this).outerHeight(true) - 20; 
			if (marginTop >= 0) return 75; 
			return marginTop; 
		},
		limit: function() {
			var limit = 0;
			limit = $('#footer').offset().top - $(this).outerHeight(true) - 20;
			return limit;
		}            
	});

    $('.lazy').lazy();
	
</script>
<!--        <script type="text/javascript">
            document.onclick = hideallpop;
            jQuery(document).ready(function () {
                jQuery('.image_boxpro').mouseover(function () {
                    tooltipPicture(this, jQuery(this).attr('id'));
                });
                var widthScreen = jQuery(window).width();
                jQuery('.header_bar_v2').css('width', widthScreen);
                jQuery('.logo-banner').css('width', widthScreen);
                var isCtrl = false;
                jQuery(document).keyup(function (e) {
                    if (window.event) {
                        key = window.event.keyCode;     //IE
                        if (window.event.ctrlKey)
                            isCtrl = true;
                        else
                            isCtrl = false;
                    }
                    else {
                        key = e.which;     //firefox
                        if (e.ctrlKey)
                            isCtrl = true;
                        else
                            isCtrl = false;
                    }

                });
                function hoverpop(co, id, obj) {
                    jQuery('.sub_sub_cat').css('display', 'none');
                    if (co > 0) {
                        var position = jQuery(obj).position();
                        jQuery('#sub_sub_cat_' + id).css('left', position.left);
                        jQuery('#sub_sub_cat_' + id).css('top', position.top + 20);
                        jQuery('#sub_sub_cat_' + id).slideDown();
                    }
                }

                function hidepop(id) {
                    jQuery('#sub_sub_cat_' + id).slideUp();
                }

                function hideallpop() {
                    jQuery('.sub_sub_cat').css('display', 'none');
                }

                jQuery('.sub_sub_cat').hover(
                    function () {
                    },
                    function () {
                        jQuery('.sub_sub_cat').css('display', 'none');
                    }
                );
                jQuery('#myTab a').click(function (e) {
                    e.preventDefault();
                    jQuery(this).tab('show');
                });
            });
        </script>-->


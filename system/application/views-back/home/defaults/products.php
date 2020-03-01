<?php
global $idHome;
$idHome = 1;
?>
<?php $this->load->view('home/common/header'); ?>
<!-- <?php //$this->load->view('home/common/header_new'); ?>
<style>
.container-fluid {
    margin-top: 50px;
} -->
</style>
<script>
    $(document).ready(function(){
        $('#Province').change(function(){
            $.ajax({
                url     : siteUrl  +'save-province',
                type    : 'post',
                data    : {province: $("#Province").val()}
            }).done(function(response) {
                if(response == "1"){
                    $(".nameProvince").html($("#Province option:selected").text());
                    window.location.reload();
                } else {
                    alert("Lỗi trình duyệt! Vui lòng xóa cache");return false;
                }
            });
        });
    });

    function Search_home() {
        //var url = '<?php echo base_url();?>search/product/name/';
        var url = '<?php echo base_url();?>search-information';
        var data = $('#singleBirdRemote').val();
        $('#formsearch_home').attr('action');
        document.formsearch_home.submit();
    }

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

<div class="container-fluid con_index">
      	
    
            <div class="row text-center">
                <div class="active col-xs-6 col-sm-3 col-sm-offset-3" style="margin-top:0px;margin-bottom:20px;">
                    <a class="btn btn-lg btn-default1 btn-block" href="/shop/products"><i class="fa fa-shopping-cart fa-fw"></i> Sản phẩm</a>
                </div>                
                <div class="col-xs-6 col-sm-3" style="margin-top:0px;margin-bottom:20px;">
                    <a class="btn btn-lg btn-default btn-block" href="/shop/coupons"><i class="fa fa-tags fa-fw"></i> Coupon</a>
                </div>	    
            </div>

            <div class="row"> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div style="background: #fff; padding: 10px 0px 0; border:1px solid #ddd; border-radius: 4px;">
                        <div class="list-categories">
                            <?php                            
                            foreach ($azitab['categories'] as $k => $category) : ?>
                            
				<?php if($category->cat_image != ''){
				    $imgsrc = DOMAIN_CLOUDSERVER.'media/images/categories/' . $category->cat_image;
				} else { 
				    $imgsrc = '/images/noimage.jpg';
				} ?>
			    
                                <div style="display: inline-block; width: 100px; margin: 10px; text-align:center; white-space: normal;">
                                    <a href="<?php echo base_url(). $category->cat_id."/".RemoveSign($category->cat_name); ?>">
                                       <img style="height:70px; border-radius:50%; border:1px solid #999;" src="<?php echo $imgsrc ?>"/>
                                       <span style="display: block; height: 50px; overflow: hidden; margin-top: 10px;"><?php echo $category->cat_name; ?></span>
                                    </a>
                                </div>
                            <?php endforeach; ?>		
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">                  
                <div class="col-xs-12 text-center" style="margin:20px 0 10px">
                    <button type="button" id="filter" class="btn btn-default" data-toggle="modal" data-target="#myFilter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                    <button type="button" id="grid" class="btn btn-default"><i class="fa fa-th" aria-hidden="true"></i></button>
                    <button type="button" id="list" class="btn btn-default"><i class="fa fa-list" aria-hidden="true"></i></button>
                </div>
            </div>

            <div id="products" class="products text-center">
                <div class="row">
                    <?php 
                    $idDiv = 1;
                    foreach ($allproducts as $key => $product) {
                        $afSelect = false;
                        if ($af_id != '' && $product->is_product_affiliate == 1) {
                            $this->load->model('user_model');
                            $userObject = $this->user_model->get("use_id", "af_key = '" . $af_id . "'");
                            if ($userObject->use_id > 0) {
                                $afSelect = true;
                            }
                        }
                        $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);                       
                    ?>
                    <div class="item col-lg-2 col-md-3 col-sm-4 col-xs-6" id="DivReliableProductBox_<?php echo $idDiv; ?>">
                            <?php $this->load->view('home/product/single_product', array('product' => $product, 'discount' => $discount)); ?>
                        </div>
                    <?php $idDiv++;                   
                    } ?>
                </div>
            </div>

            <div class="row text-center">
                <?php echo $linkPage; ?>
            </div>
        
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myFilter" tabindex="-1" role="dialog" aria-labelledby="myFilterLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <!-- <span class="modal-title" id="myModalLabel">Lọc sản phẩm</span> -->
            </div>
            <div class="modal-body" style="background: #eee;">                
               
                <form id="formfilter" method="get" action="<?php echo base_url() . 'shop/products' ?>" class="form">
                   
                    <div class="text-center"><strong>Sắp xếp theo</strong></div>                
                    <div class="row">
                        <div class="col-xs-6">                            
                            <a class="btn btn-block <?php echo ($filter['sort'] == 'product') ? 'btn-info at_db' : 'btn-default'; ?>" onclick="sortby('product')"
                               href="javascript:void(0);">Mới cập nhật</a>
                        </div>
                        <div class="col-xs-6">      
                                <a class="btn btn-block <?php echo ($filter['sort'] == 'seller') ? 'btn-info' : 'btn-default'; ?>" onclick="sortby('seller')" href="javascript:void(0);">Bán chạy nhất</a>
                        </div>
                    </div>
                    
                    <hr/>

                    <div class="text-center"><strong>Lọc sản phẩm</strong></div>     
                    <div class="row"> 
                        <div class="col-xs-6">
                            <a class="btn  btn-block <?php echo ($filter['type'] != 'discount') ? 'btn-info' : 'btn-default'; ?>" onclick="searchType('all')" href="javascript:void(0);">Tất Cả</a>
                        </div>

                        <div class="col-xs-6">
                            <a class="btn  btn-block <?php echo ($filter['type'] == 'discount') ? 'btn-info' : 'btn-default'; ?>" onclick="searchType('discount')" href="javascript:void(0);">Đang giảm giá</a>
                        </div>                 
                    </div>
                    
                    <hr/>
                    <div class="text-center"><strong>Tìm kiếm sản phẩm</strong></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-2">
                            <input type="text"  class="form-control" name="pf" value="<?php echo @$filter['pf']; ?>" placeholder="Giá từ" />
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <input type="text"  class="form-control" name="pt" value="<?php echo @$filter['pt']; ?>" placeholder="Giá đến"  />
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <input type="text" class="form-control" name="pro_name" value="<?php echo @$filter['pro_name']; ?>" placeholder="Tên sản phẩm" />
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search fa-fw" aria-hidden="true"></i> Tìm</button>
                            <input type="hidden" name="sort" value="<?php echo @$filter['sort']; ?>"/>
                            <input type="hidden" name="type" value="<?php echo @$filter['type']; ?>"/>
                        </div>
                    </div>

                    <hr/>
                    <div class="text-center"><strong>Xem theo danh mục</strong></div>
                    <div class="row">
                        <?php foreach ($azitab['categories'] as $k => $catitem) {
                            $subcat = $catitem->cat_level2;                                    
                            ?>                                        
                            <div class="col-xs-12 col-sm-6 <?php if (count($subcat) > 0) { echo 'has_child'; } ?>">
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
                </form>
            </div>            
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.lazy').lazy();
</script>

<?php $this->load->view('home/common/footer'); ?>

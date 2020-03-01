<?php
global $idHome;
$idHome = 1;
?>
<?php $this->load->view('home/common/header'); ?>
<script src="/templates/home/js/home_news.js"></script>
<style type="text/css">
    .product-item img[data-src] {
        opacity: 0;
    }
</style>
<script src="/templates/home/js/home_news.js"></script>
<style type="text/css">
    .product-item img[data-src] {
        opacity: 0;
    }
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

</script>

<div class="container con_index">
            
    <!--<div class="row">

        <div class="col-lg-3 col-xs-12 sieuthiazibai">
            <select name="Province" id="Province" style="width:150px" class="form_control_select">
              <option value=""> -- Siêu thị azibai -- </option>
              <?php $nameProvince = "";?>
              <?php foreach($province as $provinceArray){ ?>            
              <?php
                  if($provinceArray->pre_id == $this->session->userdata['s_province'] && $nameProvince == ""){
                      $nameProvince = $provinceArray->pre_name;
                  }
              ?>
                <option value="<?php echo $provinceArray->pre_id;?>" <?php echo  ($provinceArray->pre_id == $this->session->userdata['s_province'])?"selected='selected'":""; ?>><?php echo $provinceArray->pre_name;?></option>
              <?php }?>
            </select>
        </div>

    </div>
	<div class="row">
      <div class="col-lg-12 col-xs-11 text-center">
        <h1 class="brand logo-h1">
            <a href="<?php echo base_url(); ?>">
		<img src="<?php echo base_url()?>images/logo-home.png"/>
	    </a>
        </h1>
		<p style="height: 30px;" class="nameProvince"><?php echo  $nameProvince; ?></p>
      </div>
    </div>
-->
<div class="row">      	
    <div class="col-xs-12">      	
            <div class="row text-center">
                <div class=" col-xs-6 col-sm-3 col-sm-offset-3">
                    <a class="btn btn-lg btn-default1 btn-block" href="/shop/products"><i class="fa fa-shopping-cart fa-fw"></i> Sản phẩm</a>
                </div>
                <?php /*if (serviceConfig == 1){ ?>
                <div class="active">
                    <a class="btn btn-lg btn-default1 btn-block" href="/shop/services"><i class="fa fa-cog fa-fw"></i> Dịch vụ</a>
                </div>
                <?php }*/ ?>
                <div class="col-xs-6 col-sm-3">
                    <a class="btn btn-lg btn-default btn-block" href="/shop/coupons"><i class="fa fa-tags fa-fw"></i> Coupon</a>
                </div>	    
            </div>

            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div style="background: #fff;">
                        <div style="white-space: nowrap; overflow: auto; border-bottom: 1px solid #fff; border-top: 0px solid #fff;">
                            <?php foreach ($azitab['cat_service'] as $k=>$category) : ?>                                                   
                            <div style="display: inline-block; width: 100px; margin: 10px; text-align:center; white-space: normal;">
                                <a href="<?php echo base_url(). $category->cat_id."/".RemoveSign($category->cat_name); ?>">
                                   <img style="height:70px; border-radius:50%; border:1px solid #999; padding: 15px;" src="<?php echo base_url().'images/icon/icon'.$category->cat_id.'.png'?>"/>
                                   <span style="display: block; height: 50px; overflow: hidden; margin-top: 10px;"><?php echo $category->cat_name; ?></span>
                                </a>
                            </div>
                            <?php endforeach; ?>		
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">                  
                <div class="col-xs-12 text-center">
                    <button type="button" id="filter" class="btn btn-default" data-toggle="modal" data-target="#myFilter"><i class="fa fa-filter" aria-hidden="true"></i></button>
                    <button type="button" id="grid" class="btn btn-default"><i class="fa fa-th" aria-hidden="true"></i></button>
                    <button type="button" id="list" class="btn btn-default"><i class="fa fa-list" aria-hidden="true"></i></button>
                </div>
            </div>
            <div id="products" class="products text-center row">
                <?php foreach ($allproducts as $key => $product) {
                    $idDiv = 1;
                    $afSelect = false;
                    $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                    ?>
                    <div class="item col-lg-3 col-md-3 col-sm-3 col-xs-6" id="DivReliableProductBox_<?php echo $idDiv; ?>">
                        <?php $this->load->view('home/product/single_product', array('product' => $product, 'discount' => $discount)); ?>
                    </div>
                <?php  $idDiv++;  } ?>
            </div>

            <div class="row text-center">
                <?php echo $linkPage ?>
            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 introvideo">
              <div class="video">
                <iframe src="https://www.youtube.com/embed/<?php echo defaultVideo ?>?rel=0&amp;controls=0&amp;showinfo=0"
                                    allowfullscreen="" frameborder="0" width="100%" height="450"></iframe>
              </div>
            </div>


            <div class="discover col-lg-6 col-md-6 col-sm-12 col-xs-12">
               <div class="item_inside">
                   <form class="form-horizontal" id="form_discovery" action="#">
                       <div class="input-group">
                           <input name="email" id="email" class="form-control" placeholder="your-email@domain.com" type="email">
                           <div name="submitemail" class="input-group-addon" onclick="addEmailNewsletter('<?php echo base_url(); ?>')">Khám phá!</div>
                       </div>
                   </form>
                   <div class="socialbtns">
                       <ul>
                           <li><a href="<?php echo socialFacebook; ?>" class="fa fa-2x fa-facebook"></a></li>
                           <li><a href="<?php echo socialTwitter; ?>" class="fa fa-2x fa-twitter"></a></li>
                           <li><a href="<?php echo socialGooglePlus; ?>" class="fa fa-2x fa-google-plus"></a></li>
                           <li><a href="<?php echo socialYoutube; ?>" class="fa fa-2x fa-youtube"></a></li>
                           <li><a href="<?php echo socialLinkedin; ?>" class="fa fa-2x fa-linkedin"></a></li>
                           <li><a href="<?php echo socialIntergram; ?>" class="fa fa-2x fa-instagram"></a></li>
                       </ul>
                   </div>
               </div>
            </div>

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="myFilter" tabindex="-1" role="dialog" aria-labelledby="myFilterLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <span class="modal-title" id="myModalLabel">Lọc sản phẩm</span>
            </div>
            <div class="modal-body" style="background: #eee;">                
               
                <form id="formfilter" method="post" action="<?php echo base_url() . 'shop/services' ?>" class="form">
                   
                    <div class="text-center"><strong>Sắp xếp theo</strong></div>                
                    <div class="row">
                        <div class="col-xs-6">                            
                            <a class="btn btn-block <?php echo ($filter['sort'] == 'product') ? 'btn-info at_db' : 'btn-default'; ?>"
                               onclick="sortby('product')"
                               href="javascript:void(0);">Mới cập nhật</a>
                        </div>
                        <div class="col-xs-6">
                            <a class="btn  btn-block <?php echo ($filter['sort'] == 'discount') ? 'btn-info' : 'btn-default'; ?>"
                                onclick="sortby('discount')"
                                href="javascript:void(0);">Đang giảm giá</a>
                        </div>
                    </div>
                    <div class="row">    
                        <div class="col-xs-6">      
                                <a class="btn btn-block <?php echo ($filter['sort'] == 'seller') ? 'btn-info' : 'btn-default'; ?>"
                                   onclick="sortby('seller')"
                                   href="javascript:void(0);">Bán chạy nhất</a>
                        </div>
                        <div class="col-xs-6"> 
                            <a class="btn btn-block <?php echo ($filter['sort'] == 'guarantee') ? 'btn-info' : 'btn-default'; ?>"
                               onclick="sortby('guarantee')"
                               href="javascript:void(0);">GH đảm bảo</a>
                        </div>                        
                    </div>
                    
                    <hr/>
                    <div class="text-center"><strong>Tìm kiếm sản phẩm</strong></div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-2">
                            <input type="text"  class="form-control" name="pf"
                                value="<?php echo @$filter['pf']; ?>"
                                placeholder="Giá từ" />
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <input type="text"  class="form-control" name="pt"
                                value="<?php echo @$filter['pt']; ?>"
                                placeholder="Giá đến"  />
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <input type="text" class="form-control" name="pro_name"
                                value="<?php echo @$filter['pro_name']; ?>"
                                placeholder="Tên sản phẩm" />
                        </div>
                        <div class="col-xs-12 col-sm-2">
                            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search fa-fw" aria-hidden="true"></i> Tìm</button>
                            <input type="hidden" name="sort" value="<?php echo @$filter['pro_name']; ?>"/>
                        </div>
                    </div>
                    <hr/>
                    <div class="text-center"><strong>Xem theo danh mục</strong></div>
                    <div class="row">
                        <?php foreach ($azitab['cat_service'] as $k => $catitem) {
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
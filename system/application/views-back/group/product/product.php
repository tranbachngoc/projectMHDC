<?php $this->load->view('group/product/common/header'); ?>
<div id="main" class="container">
    <ol class="breadcrumb">
        <li><a href="/">Trang chủ</a></li>            
        <li><a href="/grtshop">Cửa hàng</a></li>            
        <li class="active">Sản phẩm</li>
    </ol>
    <div class="row">
        <div class="col-xs-12 col-sm-3">
           <?php  $this->load->view('group/product/common/menu-left'); ?> 
        </div>
        <div class="col-xs-12 col-sm-9">
            <div class="group-products">                            
                <div class="well">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12">
                            <form class="form" id="searchBox" action="" method="get">
                                <div class="row">                                
                                    <div class="col-sm-4">
                                        <input type="text" value="" name="q" id="KeywordSearch" class="form-control keyword" title="Từ khóa tìm kiếm" onkeypress="return submit_enter(event)" placeholder="Từ khóa tìm kiếm">
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input class="form-control min_price" type="text" value="" name="price_fo" id="price" title="Giá nhỏ nhất" onkeypress="return submit_enter(event)" placeholder="Giá nhỏ nhất">
                                            <span class="input-group-addon" id="basic-addon2">vnđ</span>
                                        </div>
                                        </div>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input class="form-control max_price" type="text" value="" name="price_to" id="price_to" title="Giá lớn nhất" onkeypress="return submit_enter(event)" placeholder="Giá lớn nhất">
                                            <span class="input-group-addon" id="basic-addon2">vnđ</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-search"></i> &nbsp; Tìm kiếm</button>
                                    </div>
                                </div>
                            </form>                        
                        </div>   

                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-sm-10">
                        <strong style="font-size: 24px">Tất cả sản phẩm</strong>
                    </div>
                    <div class="col-xs-12 col-sm-2">
                        <select autocomplete="off" name="select_sort" class="form-control input-sm" onchange="ActionSort(this.value)">
                            <option selected="selected" value="/shop/product/cat/0/sort/id/by/desc">Sắp xếp theo...</option>
                            <option value="/shop/product/cat/0/sort/name/by/asc">Tên sản phẩm A→Z</option>
                            <option value="/shop/product/cat/0/sort/name/by/desc">Tên sản phẩm Z→A</option>
                            <option value="/shop/product/cat/0/sort/cost/by/asc">Giá sản phẩm tăng dần</option>
                            <option value="/shop/product/cat/0/sort/cost/by/desc">Giá sản phẩm giảm dần</option>
                            <option value="/shop/product/cat/0/sort/buy/by/asc">Lượt mua tăng dần</option>
                            <option value="/shop/product/cat/0/sort/buy/by/desc">Lươt mua giảm dần</option>
                            <option value="/shop/product/cat/0/sort/view/by/asc">Lượt xem tăng dần</option>
                            <option value="/shop/product/cat/0/sort/view/by/desc">Lượt xem giảm dần</option>
                            <option value="/shop/product/cat/0/sort/date/by/asc">Ngày đăng tăng dần</option>
                            <option value="/shop/product/cat/0/sort/date/by/desc">Ngày đăng giảm dần</option>
                        </select>
                    </div>
                </div>
                <div class="row products">
                    
                    <?php for ($i=0;$i<20;$i++) { ?>                        
                        <div class="item col-xs-6 col-sm-4 col-md-3">
                            <div class="product-item" style="background: #fff;">
                                <div class="fix1by1">
                                    <div class="c">
                                        <a href="http://azibai.xxx/6304/3143/chuoi-gia">
                                            <img src="http://hoala.vn/upload/img/images/sen_da_4.jpg" id="3143" class="" alt="chuối già">
                                        </a>
                                    </div>
                                </div>
                                <div class="new" style="position: absolute; top: 15px; left: 15px;">
                                    <img src="http://lavender.azibai.xxx/templates/shop/default/images/new.png">
                                </div>
                                <div style="padding: 0px 10px 10px;">
                                    <h5 class="pro-name text-center">
                                        <a href="http://azibai.xxx/6304/3143/chuoi-gia">Cách trồng sen đá trong chậu</a>
                                    </h5>
                                    <p class="content_price text-center">
                                        <strong class="sale-price" style="color: #f00;">13.300.000 đ</strong>&nbsp;
                                        <span class="cost-price text-muted" style="text-decoration:line-through">15.350.000 đ</span>                                        
                                    </p>
                                    <!--<div class="pro_descr">Chuối già việt nam có nhiều chất dinh dưỡng</div>-->
                                    <div class="button-group text-center">
                                        <button class="btn btn-default  addToCart" type="button" title="Thêm vào giỏ hàng" onclick="addCart(3143);">
                                            <i class="fa fa-cart-plus fa-fw"></i>
                                        </button>
                                        <button class="btn btn-default  wishlist" type="button" title="Thích" onclick="wishlist(3143);">
                                            <i class="fa fa-heart-o fa-fw"></i>
                                        </button>
                                        <a class="btn btn-default quickview" href="http://azibai.xxx/6304/3143/chuoi-gia" title="Xem chi tiết">
                                            <i class="fa fa-eye fa-fw"></i>
                                        </a>

                                        <input type="hidden" name="product_showcart" value="3143">
                                        <input type="hidden" name="af_id" value="">
                                        <input type="hidden" name="dp_id" id="dp_id">
                                        <input type="hidden" name="qty" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>                       
                    <?php }?>
                    
                </div>
                <div class="row text-center">
                    <nav>
                        <ul class="pagination">
                            <li><span>1</span></li>
                            <li><a href="http://azibai.xxx/shop/products/page/60">2</a></li>
                            <li><a href="http://azibai.xxx/shop/products/page/60">›</a></li>
                            <li><a href="http://azibai.xxx/shop/products/page/2580">»</a></li>
                        </ul>
                    </nav>            
                </div>
                
            </div>
        </div>   
    </div>
</div>
<?php $this->load->view('group/common/footer-group'); ?>
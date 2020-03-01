<?php $this->load->view('flatform/common/header_shop'); ?>
<div class="container" role="main">
    <br>
    <div class="row visible-xs">
	<div class="col-xs-6"><a class="btn btn-block btn-default" href="/flatform/product">Sản phẩm</a></div>
	<div class="col-xs-6"><a class="btn btn-block btn-default1" href="/flatform/coupon">Coupon</a></div>
    </div>
    <br>
    <?php 
	foreach ($categories as $key => $category) { ?>
            <?php if(count($category->list_product) > 0) { ?>  

                <div class="module new_coupons text-center">
                    <h3>
                        <a href="/flatform/coupon/cat/<?php echo $category->cat_id .'/'. RemoveSign($category->cat_name) ?>" class="title text-uppercase"><?php echo $category->cat_name ?></a>
                        <span class="border"></span>
                    </h3>

                    <div class="owl-carousel">
                        <?php
                            foreach($category->list_product as $product) {   
                                $afSelect = false;
                                $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                                $this->load->view('flatform/coupons/product-item',array('product'=>$product, 'discount'=>$discount));
                            }
                        ?>
                    </div>
                    <br/>
                </div>

            <?php 
                    } 
                } 
            
        ?>
</div>
<script>
    $('.owl-carousel').owlCarousel({
        loop: false, nav: true, dots: false, 
        margin: 10, navText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 2,                
                margin: 10
            },
            600: {
                items: 3,
                margin: 20
            },
            1000: {
                items: 5,
                margin: 20
            }
        }
    })
</script>


<?php $this->load->view('flatform/common/footer'); ?>

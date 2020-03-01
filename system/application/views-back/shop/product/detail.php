<?php $this->load->view('shop/common/header'); ?>

<!--START Center-->
<?php if (isset($siteGlobal)) { ?>
    <div class="container">
        <?php
            $url = $this->uri->segment(2);
            if ($url == 'services' || $url == 'afsevices') {
                $DM = 'Danh mục dịch vụ';
            } elseif ($url == 'coupon' || $url == 'afcoupon') {
                $DM = 'Coupon';
                $pro_type = 'coupon';
                $tc = 'Xem tất cả Coupon';
            } elseif ($url == 'product' || $url == 'afproduct') {
                $DM = 'Sản phẩm';
                $pro_type = 'product';
                $tc = 'Xem tất cả Sản phẩm';
            } else {
                $DM = 'Danh mục';
                $tc = 'Xem tất cả Sản phẩm';
                $pro_type = 'product';
            }
        ?>
        <div class="row" style="margin-top: 20px;">
            <div class="col-xs-12">
                <ol id="breadcrumb" class="breadcrumb" style="white-space: nowrap; overflow: auto;">
                    <li><a href="/shop" class="home">Mua sắm</a></li>
                    <li><a href="/shop/<?php echo $url ?>"><?php echo $DM; ?></a></li>
                    <li><a href="/shop/<?php echo $url ?>/cat/<?php echo $category->cat_id; ?>/<?php echo RemoveSign($category->cat_name); ?>"><?php echo $category->cat_name; ?></a></li>
                </ol>
            </div>
        </div>
        
            
        <div class="row">    
            <div class="col-lg-3 col-md-3 col-sm-4 hidden-xs">
                <?php $this->load->view('shop/common/left'); ?>
                <?php $this->load->view('shop/common/right'); ?>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-8">
                <div id="pro_detail">
                    <h2><?php echo $product->pro_name; ?></h2>
                    <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <p>
                                <a title="Lượt mua" href="#">
                                <i class="fa fa-shopping-bag" aria-hidden="true"></i> <?php echo $product->pro_buy; ?></a>
                                <a title="Lượt xem" href="#"><i class="fa fa-eye"></i> <?php echo $product->pro_view; ?></a>
                                <a href="#" style="border:none;" class="report text-center" style="width: 100px" data-id="<?php echo $product->pro_id ?>" data-toggle="modal" data-target="#reportdetailModal">
                                    <i class="fa fa-exclamation-triangle"></i> Báo cáo
                                </a>
                            </p>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm- col-xs-12">
                            <?php if($product->end_date_sale != '' && $product->end_date_sale > strtotime(date("Y-m-d")) ) { ?>
                            <script src="/templates/home/js/jquery.countdown.min.js"></script>
                            <p class="promotion-time">
                                <i class="fa fa-clock-o fa-fw"></i> Thời gian khuyến mãi: 
                                <strong data-countdown="<?php echo date("Y-m-d",$product->end_date_sale) ?>"></strong>
                            </p>
                            <script>
                            $('[data-countdown]').each(function() {
                              var $this = $(this), finalDate = $(this).data('countdown');
                              $this.countdown(finalDate, function(event) {
                                    $this.html(event.strftime('%D Ngày %H:%M:%S'));
                              });
                            });
                            </script>
                            <?php } ?>
                        </div>				
                    </div>
						
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-5">
                            <?php $listimages = explode(',', $product->pro_image); ?>
                            <?php
                            if ($product->pro_show == 0) {
                                $img = 'media/images/product/' . $product->pro_dir . '/' . show_image($product->pro_image); ?>
                                <style>
                                    #carousel-ligghtgallery {
                                        margin-bottom: 20px;
                                        text-align: center
                                    }

                                    .owl-carousel .owl-item img {
                                        width: auto !important;
                                    }

                                    .style-group {
                                        display: inline-block;
                                        padding: 5px 15px;
                                        border: 1px solid #ddd;
                                        border-radius: 0px;
                                        cursor: pointer;
                                        width: 80px;
                                        text-align: center;
                                    }

                                    .actived {
                                        background: #fff;
                                        color: #000;
                                        border: 1px solid #d1d1d1;
                                    }

                                    .hoahongAf {
                                        border: 1px solid #d9534f;
                                        overflow: hidden;
                                        position: relative;
                                        margin-bottom: 20px;
                                    }

                                    .TenHH {
                                        float: left;
                                        padding: 10px;
                                        width: 66%;
                                    }

                                    .phantranHH {
                                        padding: 10px;
                                        text-align: center;
                                        border-left: 1px solid #d9534f;
                                        box-sizing: border-box;
                                        background: #d9534f;
                                        width: 34%;
                                        float: left;
                                        color: #fff;
                                        font-size: 15px;
                                        position: absolute;
                                        right: 0;
                                        bottom: 0;
                                        top: 0;
                                    }
                                </style>
                            <link href="/templates/home/lightgallery/dist/css/lightgallery.css" rel="stylesheet" type="text/css" />
                            <link href="/templates/home/owlcarousel/owl.carousel.min.css" rel="stylesheet" type="text/css"/>
                            <link href="/templates/home/owlcarousel/owl.theme.default.min.css" rel="stylesheet" type="text/css"/>
                            <div class="imagepro">
                                <div id="carousel-ligghtgallery" class="owl-carousel owl-theme">
                                    <?php
                                    foreach ($listimages as $k => $image):
                                        $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_3_' . $image;
                                        ?>
                                        <div class="fix1by1 item">
                                            <?php if ($image != '') { ?>
                                                <a class="c image" href="<?php echo $imgsrc ?>">
                                                    <img src="<?php echo $imgsrc ?>" alt="...">
                                                </a>
                                            <?php } else { ?>
                                                <a class="c image" href="<?php echo base_url() . 'images/noimage.jpg' ?>">
                                                    <img src="<?php echo base_url() . 'images/noimage.jpg' ?>" alt="...">
                                                </a>
                                            <?php } ?>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                </div>
                                <script src="/templates/home/lightgallery/dist/js/lightgallery.js"></script>
                                <script src="/templates/home/js/owl.carousel.js"></script>
                                <script language="javascript">
                                    jQuery(function ($) {
                                        $('#carousel-ligghtgallery').lightGallery({
                                            selector: '.image',
                                            download: false
                                        });
                                        $('.owl-carousel').owlCarousel({
                                            items: 1,
                                            loop: false,
                                            margin: 0,
                                            nav: false
                                        })
                                    });
                                </script>
                            <?php } else { ?>
                            <?php $imageDetail = explode(',', $product->pro_image); ?>
                                <div class="large-img">
                                    <a class="slideshow" href="/media/images/product/<?php echo $product->pro_dir; ?>/<?php echo $imageDetail[0]; ?>">
                                        <img class="img-responsive" src="<?php echo $URLRoot; ?>media/images/product/<?php echo $product->pro_dir; ?>/<?php echo $imageDetail[0]; ?>" alt=""/>
                                    </a>
                                </div>
                                <ul class="list-img">
                                    <?php foreach ($imageDetail as $key => $imageDetailArray) { ?>
                                        <?php if ($imageDetailArray != "") { ?>
                                            <li class="<?php if ($key == 0) { echo 'current'; } ?>">
                                                <a class="slideshow" href="<?php echo $URLRoot; ?>media/images/product/<?php echo $product->pro_dir; ?>/<?php echo $imageDetailArray; ?>">
                                                    <img src="/media/images/product/<?php echo $product->pro_dir; ?>/<?php echo $imageDetailArray; ?>"/></a>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                </ul>
                                <script language="javascript" src="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/js/colorbox.js"></script>
                            <link type="text/css" href="<?php echo $URLRoot; ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/css/colorbox.css" rel="stylesheet">
                                <script type="text/javascript">
                                    jQuery.noconflict();
                                    jQuery(function ($) {
                                        $(".slideshow").colorbox({rel: 'slideshow', slideshow: true, height: "90%"});
                                        $('.list-img a').hover(function () {
                                            $('.large-img a').attr('href', $(this).attr('href'));
                                            $('.large-img a img').attr('src', $(this).find('img').attr('src'));
                                        });
                                    });
                                </script>
                            <?php } ?>

                            <div class="clear"></div>
                            <?php
                            $af_id = ($_REQUEST['af_id'] != "") ? $_REQUEST['af_id'] : '';
                            if ($af_id != '') {
                                $this->session->set_userdata('af_id', $af_id);
                            }
                            else if (($af_id == "") && ($this->session->userdata('af_id') != "")) {
                                $af_id = $this->session->userdata('af_id');
                            }

                            $path_info = $_SERVER["PATH_INFO"]; // ==> "/product/detail/pro_id/pro-name-not-hide-vnamese"
                            $domain_alias = $_SERVER["HTTP_X_FORWARDED_HOST"]; // ==> "domainshop.com"

                            $url = current_url();
                            if ($shop_pro->domain != "") {
                                $url = $protocol . $domain_alias . $path_info;
                            }
                            $link_af_id = !empty($af_id) ? $url . "?af_id=" . $af_id : $url;

                            function url_origin($s, $use_forwarded_host = false)
                            {
                                $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on');
                                $sp = strtolower($s['SERVER_PROTOCOL']);
                                $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
                                $port = $s['SERVER_PORT'];
                                $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
                                $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
                                $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
                                return $protocol . '://' . $host;
                            }

                            function full_url($s, $use_forwarded_host = false)
                            {
                                return url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
                            }

                            $absolute_url = full_url($_SERVER);
                            //echo $absolute_url;
                            //print_r($_SERVER);
                            ?>
                            <p class="text-center">Chia sẻ sản phẩm này:</p>                            
                            <div class="btn-group btn-group-justified" style="margin-bottom:20px;">
                                <div class="btn-group" role="group">
                                    <a class="btn btn-default" href="javascript:void(0)" onclick="
                                        window.open(
                                                'https://www.facebook.com/sharer/sharer.php?u=<?php echo $ogurl ?>&amp;app_id=<?php echo app_id ?>',
                                                'facebook-share-dialog',
                                                'width=800,height=600');
                                        return false;">
                                            <span class="fa fa-facebook"></span>
                                    </a>
                                </div>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-default"  href="javascript:void(0)" onclick="
                                            window.open(
                                                    'https://twitter.com/share?text=<?php echo $product->pro_name ?>&amp;url=<?php echo $ogurl ?>',
                                                    'twitter-share-dialog',
                                                    'width=800,height=600');
                                            return false;">
                                        <span class="fa fa-twitter"></span>
                                    </a>  
                                </div>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-default"  href="javascript:void(0)" onclick="
                                            window.open(
                                                    'https://plus.google.com/share?url=<?php echo $ogurl ?>',
                                                    'google-share-dialog',
                                                    'width=800,height=600');
                                            return false;">
                                        <span class="fa fa-google-plus"></span>
                                    </a>   
                                </div>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-default"  href="javascript:void(0)" onclick="
                                            window.open(
                                                    'https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $ogurl ?>',
                                                    'google-share-dialog',
                                                    'width=800,height=600');
                                            return false;">
                                        <span class="fa fa-linkedin"></span>
                                    </a>
                                </div>
                                <div class="btn-group" role="group">
                                    <a  class="btn btn-default" href="javascript:void(0)" onclick="
                                            window.open('https://mail.google.com/mail/u/0/?view=cm&fs=1&to&su=<?php echo $product->pro_name ?>&body=<?php echo $ogurl ?>&ui=2&tf=1',
                                                'google-share-dialog',
                                                'width=800,height=600')
                                            return false;" >
                                        <span class="fa fa-envelope-o"></span>
                                    </a>                                    
                                </div>
                            </div>                           
                            

                            <div class="thanh-toan">
                                <!-- them phan thanh toan-->
                                <?php if (!empty($product->status)): ?>
                                    <div class="order_messsage">
                                        <?php if (!$product->status['pro_instock']): ?>
                                            <?php echo $product->status['message'] ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php
                            $group_id = (int)$this->session->userdata('sessionGroup');
                            if ($group_id == AffiliateUser || $GHchonban == 1) {
                                if ($product->is_product_affiliate == 1) {
                                    if ($product->af_amt > 0) {
                                        $pro_affiliate_value = $product->af_amt . ' VNĐ';
                                        $pro_type_affiliate = 2;
                                    } else {
                                        $pro_affiliate_value = $product->aff_rate . ' %';
                                        $pro_type_affiliate = 1;
                                    }
                                } else {
                                    $pro_affiliate_value = '0 VNĐ';
                                }
                                ?>
                                <?php if ($product->is_product_affiliate == 1) { ?>
                                    <div class="hoahongAf">
                                        <div class="TenHH">Hoa hồng cộng tác viên được hưởng khi bán sản phẩm này</div>
                                        <div class="phantranHH"><?php echo $pro_affiliate_value; ?></div>
                                    </div>
                                    <?php if ($selected_sale != true) { ?>
                                        <button class="btn btn-default"
                                                onclick="SelectProSales(<?php echo $product->pro_id; ?>);">
                                            <i class="fa fa-check fa-fw"></i> Chọn bán
                                        </button>
                                    <?php } else { ?>
                                        <button class="btn btn-default"><i class="fa fa-check fa-fw"></i> Đã chọn bán
                                        </button>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-7">
                            <table class="table table-bordered">
                                <?php
                                // Added by le van son
                                // Calculation discount amount
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
                                <tr>
                                    <td width="120" valign="top" class="list_detail" style="line-height:18px;">
                                        <?php echo $this->lang->line('cost_detail_product_detail'); ?>:
                                    </td>
                                    <td id="cost_detail" valign="top">
                                        <?php if ((int)$product->pro_cost == 0) { ?>
                                            <?php echo $this->lang->line('call_main'); ?>
                                        <?php } else {
                                            $today_date = time() - 84000;
                                            if ($product->begin_date_sale < $today_date && $product->end_date_sale > $today_date) {
                                                $promotion_status = 1;
                                            } else {
                                                $promotion_status = 0;
                                            }
                                            ?>
                                            <?php if ($product->pro_cost > $discount['salePrice']) { ?>
                                                <span class="cost-price"
                                                      id="show-cost"><?php echo lkvUtil::formatPrice($product->pro_cost, 'vnđ'); ?></span>
                                            <?php } else { ?>
                                                <span class="sale-price"
                                                      id="show-cost"><?php echo lkvUtil::formatPrice($product->pro_cost, 'vnđ'); ?></span>
                                            <?php } ?>
                                            <?php /* ?><?php if($product->off_amount > 0 ) {?><span class="cost-price" ><?php echo number_format($product->pro_cost); ?> vnđ</span>
                                            <span style="background:#eee; border-radius:4px; padding: 3px 10px; ">Tiết kiệm: <span style="color:red"><?php echo ($product->off_rate > 0) ? $product->off_rate.'%' : number_format($product->off_amount).' vnđ'; ?></span></span><?php }?><?php */ ?>
                                        <?php } ?>
                                    </td>
                                </tr>

                                <?php if ($product->off_amount > 0) { ?>
                                    <tr>
                                        <?php 
                                        if($product->off_rate > 0){ 
                                            $price_sale = $product->pro_cost * (1 - $product->off_rate/100); 
                                            $saleoff = $product->off_rate . '%'; 
                                        }else { 
                                            $price_sale = $product->pro_cost - $product->off_amount; 
                                            $saleoff = number_format($product->off_amount) . ' vnđ';
                                        } ?>
                                        <td width="120" valign="top" class="list_detail" style="line-height:18px;">
                                            Giá khuyến mãi:
                                        </td>
                                        <td>
                                            <span class="sale-price detail <?php if ($discount['af_off'] > 0) { echo 'cost-price-line';} ?>" id="cost-save"><?php echo number_format($price_sale, 0, ",", "."); ?></span>
                                            vnđ
                                            <span class="label label-success" style="float:right; padding: 5px ;font-size: 14px ">Tiết kiệm: <b><?php echo $saleoff; ?></b></span>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php if ($discount['af_off'] > 0): ?>
                                    <tr>
                                        <td width="120" valign="top" class="list_detail" style="line-height:18px;"> Giá mua qua CTV:
                                        </td>
                                        <td><span class="sale-price" id="cost-save-af"><?php echo number_format($discount['af_sale'], 0, ",", "."); ?>
                                                vnđ</span>
                                            <span>Tiết kiệm thêm: <?php echo ($product->af_rate > 0) ? $product->af_rate . '%' : number_format($discount['af_off'], 0, ",", ".") . ' vnđ'; ?></span>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php if ($product->off_amount > 0 && $discount['em_off'] <= 0 && $promotion_status > 0) { ?>
                                <?php } ?>

                                <?php if ($discount['em_off'] > 0): ?>
                                    <tr>
                                        <td width="120" valign="top" class="list_detail" style="line-height:18px;">Giảm giá sỉ:
                                        </td>
                                        <td><span class="sale-price"><?php echo number_format($discount['em_sale']); ?> vnđ</span>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php if ($promotions): ?>
                                    <tr>
                                        <td width="120" valign="top" class="list_detail" style="line-height:18px;">Giảm giá sỉ:
                                        </td>
                                        <td>
                                            
                                            
                                                <p style="border-bottom:1px dotted #444"><em>Số lượng mua</em><em class="pull-right">Giảm thêm</em></p>
                                                <?php foreach ($promotions as $promotion): ?>
                                                <p style="border-bottom:1px dotted #444">
                                                        <?php if ($promotion['limit_type'] == 2): ?>
                                                            <?php
                                                            $pDiscount = $promotion['dc_rate'] > 0 ? $promotion['dc_amount'] . ' %' : number_format($promotion['dc_amount']) . ' vnđ';
                                                            if ($promotion['limit_from'] == 0) {
                                                                echo 'Mua dưới ' . number_format($promotion['limit_to']) . ' vnđ <span class="pull-right">-' . $pDiscount . '</span>';
                                                            } elseif ($promotion['limit_to'] == 0) {
                                                                echo 'Mua từ ' . number_format($promotion['limit_from']) . ' vnđ <span class="pull-right">-' . $pDiscount . '</span>';
                                                            } else {
                                                                echo 'Mua từ ' . number_format($promotion['limit_from']) . ' vnđ tới ' . number_format($promotion['limit_to']) . ' vnđ <span class="pull-right">-' . $pDiscount . '</span>';
                                                            } ?>
                                                        <?php else: ?>
                                                            <?php
                                                            $pDiscount = $promotion['dc_rate'] > 0 ? $promotion['dc_amount'] . ' %' : number_format($promotion['dc_amount']) . ' vnđ';
                                                            if ($promotion['limit_from'] == 0) {
                                                                echo 'Mua dưới ' . $promotion['limit_to'] . ' sp <span class="pull-right">-' . $pDiscount . '</span>';
                                                            } elseif ($promotion['limit_to'] == 0) {
                                                                echo 'Mua trên ' . $promotion['limit_from'] . ' sp <span class="pull-right">-' . $pDiscount . '</span>';
                                                            } else {
                                                                echo 'Mua từ ' . $promotion['limit_from'] . ' sp đến ' . $promotion['limit_to'] . ' sp <span class="pull-right">-' . $pDiscount . '</span>';
                                                            } ?>
                                                        <?php endif; ?>
                                                    </p>
                                                <?php endforeach; ?>
                                                
                                            
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <tr>
                                    <td width="70" valign="top"
                                        class="list_detail"><?php echo $this->lang->line('category_detail_product_detail'); ?>
                                        :
                                    </td>
                                    <td class="content_list_detail">
                                        <b>
                                            <?php
                                            if ((int)$category->cat_status == 1) {
                                            if ($category->cate_type == 0) {
                                                $linkt = 'product';
                                            } elseif ($category->cate_type == 1) {
                                                $linkt = 'services';
                                            } else {
                                                $linkt = 'coupon';
                                            }
                                            $link_cat = '/shop/'. $linkt .'/cat/'. $category->cat_id .'-'. RemoveSign($category->cat_name);
                                            ?>
                                            <a class="menu_1" href="<?php echo $link_cat; ?>"
                                               alt="<?php echo $category->cat_descr; ?>" target="_blank">
                                                <?php } ?>
                                                <?php echo $category->cat_name; ?>
                                                <?php if ((int)$category->cat_status == 1) { ?>
                                            </a>
                                        <?php } ?>
                                        </b>
                                    </td>
                                </tr>

                                <?php if ($product->pro_vat != 0) { ?>
                                    <tr>
                                        <td width="70" valign="top"
                                            class="list_detail"><?php echo $this->lang->line('pro_vat'); ?>:
                                        </td>
                                        <td class="content_list_detail"><?php if ($product->pro_vat == 1) echo "Đã có VAT";
                                            if ($product->pro_vat == 2) echo "Không có VAT";
                                            if ($product->pro_vat == 0) echo "Chưa cập nhật"; ?></td>
                                    </tr>
                                <?php } ?>

                                <?php if ($product->pro_quality != -1) { ?>
                                    <tr>
                                        <td width="70" valign="top"
                                            class="list_detail"><?php echo $this->lang->line('pro_quality'); ?>:
                                        </td>
                                        <td class="content_list_detail"><?php if ($product->pro_quality == 1) echo "Cũ";
                                            if ($product->pro_quality == 0) echo "Mới";
                                            if ($product->pro_quality == -1) echo "Chưa cập nhật"; ?></td>
                                    </tr>
                                <?php } ?>

                                <?php if ($product->pro_made_from != 0 && $product->pro_type == 0) { ?>
                                    <tr>
                                        <td width="70" valign="top"
                                            class="list_detail"><?php echo $this->lang->line('pro_made_from'); ?>:
                                        </td>
                                        <td class="content_list_detail"><?php if ($product->pro_made_from == 1) echo "Chính hãng";
                                            if ($product->pro_made_from == 2) echo "Xách tay";
                                            if ($product->pro_made_from == 3) echo "Hàng công ty";
                                            if ($product->pro_made_from == 0) echo "Chưa cập nhật"; ?></td>
                                    </tr>
                                <?php } ?>
                                <?php if (Counter_model::GetNhaSanXuatToID($product->pro_manufacturer_id) != '' && $product->pro_type == 0): ?>
                                    <tr>
                                        <td class="title_detail_tb">Nhà sản xuất:</td>
                                        <td>
                                            <?php echo Counter_model::GetNhaSanXuatToID($product->pro_manufacturer_id); ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                <?php if ($product->pro_warranty_period != 0 && $product->pro_type == 0) { ?>
                                    <tr>
                                        <td width="70" valign="top"
                                            class="list_detail"><?php echo $this->lang->line('pro_baohanh'); ?>:
                                        </td>
                                        <td class="content_list_detail"><?php
                                            if ($product->pro_warranty_period == 0) {
                                                echo "Không bảo hành";
                                            } else {
                                                echo $product->pro_warranty_period . " tháng";
                                            } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td width="70" valign="top" class="list_detail"><?php echo $this->lang->line('post_date_detail_product_detail'); ?>:
                                    </td>
                                    <td class="content_list_detail"><?php echo date('d-m-Y', $product->pro_begindate); ?></td>
                                </tr>
                                <?php if ($product->pro_video != '') { ?>
                                    <tr>
                                        <td width="70" class="list_detail">Video:</td>
                                        <td class="content_list_detail">
                                            <?php
                                            if ($product->pro_video != '') {
                                                $arrayYoutubeLink = explode("?v=", $product->pro_video);
                                                if ($arrayYoutubeLink[1] != '') { ?>
                                                    <a class="btn btn-link" data-toggle="modal"
                                                       data-target="#youtubeModal"> Xem video về sản phẩm </a>
                                                    <div class="modal fade" id="youtubeModal" tabindex="-1"
                                                         role="dialog" aria-labelledby="youtubeModalLabel">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <div class="video">
                                                                        <iframe
                                                                            src="https://www.youtube.com/embed/<?php echo $arrayYoutubeLink[1]; ?>"
                                                                            allowfullscreen="" frameborder="0"
                                                                            height="600" width="800"></iframe>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td width="70" valign="top"
                                        class="list_detail"><?php echo $this->lang->line('vote_detail_product_detail'); ?>
                                        :
                                    </td>
                                    <td id="vote_detail">
                                        <?php for ($vote = 0; $vote < (int)$product->pro_vote_total; $vote++) { ?>
                                            <img
                                                src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/star1.gif"
                                                border="0"/>
                                        <?php } ?>
                                        <?php for ($vote = 0; $vote < 10 - (int)$product->pro_vote_total; $vote++) { ?>
                                            <img
                                                src="<?php echo base_url(); ?>templates/shop/<?php echo $siteGlobal->sho_style; ?>/images/star0.gif"
                                                border="0"/>
                                        <?php } ?>
                                        <b>[<?php echo $product->pro_vote; ?>]</b>
                                    </td>
                                </tr>
                            </table>

                            <?php if ($product->pro_instock > 0) { ?>
                                <!-- Begin:: Trường Quy Cách -->
                                <?php if (isset($list_style)) { ?>

                                    <?php
                                    //co mau
                                    if (isset($ar_color) && !empty($ar_color)) {
                                        $hiddenColor = '';
                                        if (isset($ar_size) && !empty($ar_size) && $ar_size[0] != '') {
                                            $hiddenSize = '';
                                            $hiddenMaterial = ' hidden';
                                        } else {
                                            $hiddenSize = ' hidden';
                                            if (isset($ar_material) && !empty($ar_material) && $ar_material[0] != '') {
                                                $hiddenMaterial = '';
                                            }else{
                                                $hiddenMaterial = ' hidden';
                                            }
                                        }
                                    } //k co mau
                                    else {
                                        $hiddenColor = ' hidden';
                                        if (isset($ar_size) && !empty($ar_size) && $ar_size[0] != '') {
                                            $hiddenSize = '';
                                            $hiddenMaterial = ' hidden';
                                        } else {
                                            $hiddenSize = ' hidden';
                                            if (isset($ar_material) && !empty($ar_material) && $ar_material[0] != '') {
                                                $hiddenMaterial = '';
                                            }else{
                                                $hiddenMaterial = ' hidden';
                                            }
                                        }
                                    }
                                    $vowels = array(".", " ", ",", "/");
                                    ?>
                                    <?php if (isset($ar_color) && !empty($ar_color)) { ?>
                                        <div class="ms" style="float: left"> Màu sắc:</div><span class="note" style="display: none; float: left; margin-left: 10px;">Bạn phải chọn màu sắc</span>
                                        <div class="row ar_color<?php echo $hiddenColor ?>">
                                            <div class="col-xs-12">
                                                <?php
                                                $t1 = 0;
                                                foreach ($ar_color as $k1 => $v1) {
                                                    $t1++;
                                                    if ($k1 == 0) {
                                                        $sel_color = $v1;
                                                    }
                                                    $st_color = str_replace($vowels, "_", $v1);
                                                    ?>
                                                    <div class="pull-left" style="margin:5px">
                                                        <button id="mausac_<?php echo $t1; ?>" class="style-group " onclick="ClickColor('<?php echo $st_color; ?>','<?php echo $t1; ?>');"><?php echo $v1; ?></button>
                                                        <!--<span class="style-group "  onclick="SeletColorStyle('<?php echo $v1; ?>','<?php echo $t1; ?>');"><?php echo $v1; ?></span>-->
                                                        <input type="hidden" id="<?php echo 'st_color_' . $st_color; ?>" name="<?php echo 'st_color_' . $st_color; ?>" value="<?php echo $v1; ?>">
                                                    </div>
                                                <?php } ?>
                                                <input type="hidden" name="_selected_color" id="_selected_color"/>
                                            </div>
                                        </div>
                                        <span class="hidden" id="prompt_select_color">Bạn phải chọn màu sắc.</span>
                                    <?php } ?>

                                        <div class="row ar_size<?php echo $hiddenSize ?>">
                                            <div class="col-xs-12">
                                                <div class="dropdown">
                                                    <a id="dLabel" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Chọn kích thước <span class="caret"></span> &nbsp;
                                                        <span class="st_size_value"></span>
                                                        <span class="hidden qcalert" id="prompt_select_size">Bạn phải chọn kích thước.</span>
                                                    </a>
                                                    <ul class="dropdown-menu list_ar_size" aria-labelledby="dLabel">
                                                        <?php
                                                        $t2 = 0;
                                                        foreach ($ar_size as $k2 => $v2) {
                                                            $t2++;
                                                            if ($k2 == 0) {
                                                                $sel_size = $v2;
                                                            }
                                                            $st_size = str_replace($vowels, "_", $v2);
                                                            ?>
                                                            <li class="qc" style="cursor: pointer;">
                                                                <span id="kichthuoc_<?php echo $t2; ?>"
                                                                    onclick="ClickSize('<?php echo $st_size; ?>','<?php echo $t2; ?>');"><?php echo $v2; ?></span>
                                                                <input type="hidden"
                                                                       id="<?php echo 'st_size_' . $st_size; ?>"
                                                                       name="<?php echo 'st_size_' . $st_size; ?>"
                                                                       value="<?php echo $v2; ?>"/></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <input type="hidden" name="_selected_size" id="_selected_size"/>
                                            </div>
                                        </div>

                                        <div class="row ar_material<?php echo $hiddenMaterial ?>" id="ar_material">
                                            <div class="col-xs-12">
                                                <div class="dropdown">
                                                    <a id="dLabel" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Chọn chất liệu <span class="caret"></span> &nbsp;
                                                        <span class="st_material_value"></span>
                                                        <span class="hidden qcalert" id="prompt_select_material">Bạn phải chọn chất liệu.</span>
                                                    </a>
                                                    <ul class="dropdown-menu list_ar_material" aria-labelledby="dLabel">
                                                        <?php
                                                        $t3 = 0;
                                                        foreach ($ar_material as $k3 => $v3) {
                                                            $t3++;
                                                            if ($k3 == 0) {
                                                                $sel_material = $v3;
                                                            }
                                                            $st_material = str_replace($vowels, "_", $v3);
                                                            ?>
                                                            <li style="cursor: pointer;"><span
                                                                    id="chatlieu_<?php echo $t3; ?>"
                                                                    onclick="ClickMaterial('<?php echo $st_material; ?>','<?php echo $t3; ?>');"><?php echo $v3; ?></span>
                                                                <input type="hidden"
                                                                       id="<?php echo 'st_material_' . $st_material; ?>"
                                                                       name="<?php echo 'st_material_' . $st_material; ?>"
                                                                       value="<?php echo $v3; ?>"></li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                                <input type="hidden" name="_selected_material" id="_selected_material"/>
                                            </div>
                                        </div>


                                    <hr/>
                                <?php } ?>
                                <!-- End:: Trường Quy Cách -->

                                <div class="qty_row">
                                    <?php $pty_min = $shop_type->shop_type >= 1 ? $product->pro_minsale : 1; ?>
                                    <span class="">Số lượng:</span>
                                    <span class="qty_group" id="mes_<?php echo $product->pro_id; ?>">
				    <span class="sub-qty" title="Bớt" onclick="update_qty(<?php echo $product->pro_id; ?>, -1);"><i class="fa fa-minus"></i></span>
				    <input id="qty_<?php echo $product->pro_id; ?>" name="qty" onkeypress="return isNumberKey(event)" autofocus="autofocus" autocomplete="off"
					   type="text" min="1" max="9999" class="inpt-qty" required="" value="<?php echo $pty_min; ?>" title="">
				    <span class="add-qty" title="Thêm" onclick="update_qty(<?php echo $product->pro_id; ?>, 1);"><i class="fa fa-plus"></i></span>
				    </span>
				    <a href="#wishlist" class="pull-right btn btn-default" onclick="wishlist(<?php echo $product->pro_id; ?>);"><i class="fa fa-heart-o fa-fw like_db"></i> Yêu Thích</a>
                                </div>
								
				<br>				
                               
                                <div id="bt_<?php echo $product->pro_id; ?>"
                                     class="add_to_cart_button set_in_footer cart_db">
				    
                                    <div class="btn-group btn-group-justified">
                                        <div class="btn-group" role="group">
                                            <button onclick="addCartQty(<?php echo $product->pro_id; ?>);" style="background: #585858; color: #fff;" type="button" class="btn btn-lg addToCart addToCart_detail"><i class="fa fa-cart-plus"></i>&nbsp;Thêm vào giỏ
                                            </button>
                                        </div>
                                        <div class="btn-group" role="group">
                                            <button onclick="buyNowQty(<?php echo $product->pro_id; ?>);" title="" type="button" class="btn btn-default btn-lg wishlist buyNow_detail"><i class="fa fa-check-square-o"></i>&nbsp;Mua ngay
                                            </button>
                                        </div>
                                        
                                    </div> 
                                    
                                    <input type="hidden" name="product_showcart" id="product_showcart"
                                           value="<?php echo $product->pro_id; ?>"/>
                                    <input type="hidden" name="af_id" value="<?php echo $af_id; ?>"/>
                                    <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->id; ?>"/>
                                    <input type="hidden" name="qty_min" id="qty_min" value="<?php echo $pty_min; ?>"/>
                                    <input type="hidden" name="qty_max" id="qty_max" value="<?php echo $product->pro_instock; ?>"/>
                                </div>

                                <!-- Tạm hết hàng -->
                                <div id="bt_hethang_<?php echo $product->pro_id; ?>" class="btn-hethang hidden">
                                    <button title="Hết hàng" id="buynow-login" class="btn btn-danger sm" type="button">
                                        Tạm hết hàng
                                    </button>
                                    <button onclick="wishlist(<?php echo $product->pro_id; ?>);" title="" type="button"
                                            class="btn btn-link  wishlist"><i class="fa fa-heart fa-fw"></i>&nbsp;Yêu
                                        thích
                                    </button>
                                    <input type="hidden" name="product_showcart"
                                           value="<?php echo $product->pro_id; ?>"/>
                                </div>
                                <!-- Tạm hết hàng -->

                                <?php if ($product->pro_type != 0) { ?>
                                    <div class="text-warning" style="margin-top:10px;"><i class="fa fa-tags"
                                                                                          aria-hidden="true"></i>&nbsp;<b>Sản
                                            phẩm này được bán dưới hình thức E-coupon.
                                            <br/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a target="_blank" href="/content/398">Click
                                                để tìm hiểu thêm.</a></b>
                                    </div>
                                <?php } ?>
                            <?php } else { ?>
                                <div id="bt_<?php echo $product->pro_id; ?>" class="add_to_cart_button">
                                    <button title="Hết hàng" id="buynow-login" class="btn btn-danger sm" type="button">
                                        Hết hàng
                                    </button>
                                    <button onclick="wishlist(<?php echo $product->pro_id; ?>);" title="" type="button"
                                            class="btn btn-link  wishlist"><i class="fa fa-heart fa-fw"></i>&nbsp;Yêu
                                        thích
                                    </button>
                                    <input type="hidden" name="product_showcart"
                                           value="<?php echo $product->pro_id; ?>"/>
                                    <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->id; ?>"/>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="pro_desc">
                        <h3><?php echo $this->lang->line('detail_detail_product_detail'); ?></h3>
                        <?php echo htmlspecialchars_decode(html_entity_decode(str_replace("&curren;", "#", $product->pro_detail))); ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
<?php } ?>
<!--END Center-->
<?php
if ($siteGlobal->sho_phone) {
    $phonenumber = $siteGlobal->sho_phone;
} elseif ($siteGlobal->sho_mobile) {
    $phonenumber = $siteGlobal->sho_mobile;
}
if ($phonenumber) {
    ?>
    <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
        <div class="phonering-alo-ph-circle"></div>
        <div class="phonering-alo-ph-circle-fill"></div>
        <div class="phonering-alo-ph-img-circle">
            <a href="tel:<?php echo $siteGlobal->sho_mobile; ?>">
                <img data-toggle="modal" data-target=".bs-example-modal-md" src="https://i.imgur.com/v8TniL3.png"
                     alt="Liên hệ" width="50" onmouseover="this.src = 'https://i.imgur.com/v8TniL3.png';"
                     onmouseout="this.src = 'https://i.imgur.com/v8TniL3.png';">
            </a>
        </div>
    </div>
<?php } ?>


<!-- GUI BAO CAO SAN PHAM -->
			
<link type="text/css" rel="stylesheet" href="/templates/home/js/jAlert-master/jAlert-v3.css"/>
<script async src="/templates/home/js/jAlert-master/jAlert-v3.min.js"></script>
<script async src="/templates/home/js/jAlert-master/jAlert-functions.min.js"></script>

<?php if($this->session->userdata('sessionUser') > 0) { ?>
<div class="modal fade" id="reportdetailModal" tabindex="-1" role="dialog" aria-labelledby="reportdetailModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="frmReport" name="frmReport" action="/home/shop/report" method="post" class="form" enctype="multipart/form-data">
            <input type="hidden" name="sho_name" id="" value="<?php echo $siteGlobal->sho_name; ?>">
            <input type="hidden" name="sho_link" id="" value="<?php echo $protocol.$_SERVER['SERVER_NAME'].'/shop/'; ?>">
            <input type="hidden" name="pro_link" id="" value="<?php echo $protocol.$_SERVER['SERVER_NAME'].'/shop/'. $linkt .'/detail/'. $product->pro_id .'/'. RemoveSign($product->pro_name); ?>">
            <input type="hidden" name="pro_name" id="" value="<?php echo $product->pro_name ?>">
            <input id="" name="pro_id" type="hidden" value="<?php echo $product->pro_id ?>">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="reportModalLabel">Gửi báo cáo sản phẩm này</h4>
            </div>
            <div class="modal-body" style="color: #000">
                <?php foreach ($listreports as $key => $value) { ?>
                    <div class="radio">
                        <label>
                            <input type="radio" name="rp_id" id="optionsReport" value="<?php echo $value->rp_id ?>" <?php echo $key == 0 ? 'checked': '' ?> >
                            <?php echo $value->rp_desc ?>
                        </label>
                    </div>			
                <?php } ?>
                <textarea type="text" name="rpd_reason" id="rpd_reason" placeholder="Nhập nội dung báo cáo" class="" style="display: none; resize: none; width: 100%; padding: 5px;"/></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <button type="submit" name="sendReport" class="btn btn-primary">Gửi báo cáo</button>
            </div>
        </form>
    </div>
  </div>
</div>
<script>	
$(document).ready(function () {
    $('input[name=rp_id]').each(function(){
        $(this).change(function () {
            if ($(this).val() == '11' && $(this).is(':checked')) {
                $('#rpd_reason').fadeIn(400);
                $('#rpd_reason').attr('required','required');
            }else{
                $('#rpd_reason').fadeOut(0);
                $('#rpd_reason').removeAttr('required');
            }
        });
    });
});

$('.report').click(function(){			
    $('#reportpost').attr('value', $(this).data('id'));
});

var frm = $('#frmReport');
frm.submit(function (e) {
    e.preventDefault();
    $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        success: function (data) {
            var mes = '';
            $('#reportdetailModal').modal('hide');
            if (data == '0') {
                mes = 'Bạn đã gửi báo cáo cho sản phẩm này rồi. Cám ơn bạn!';
            } else if (data == '1') {
                mes = 'Gửi báo cáo sản phẩm thành công. Cảm ơn bạn!';
            }
            $.jAlert({
                'title': 'Thông báo',
                'content': mes,
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        location.reload();
                        return false;
                    }
                }
            });	
        },
        error: function (data) {					
            $('#reportdetailModal').modal('show');				
        }
    });
});
</script> 
<?php } else { ?>
<div class="modal fade" id="reportdetailModal" tabindex="-1" role="dialog" aria-labelledby="reportdetailModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
	<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="reportModalLabel">Gửi báo cáo sản phẩm này</h4>
        </div>
        <div class="modal-body">
            <div class="alert alert-warning" role="alert">
                    Bạn chưa đăng nhập, vui lòng <a href="/login">đăng nhập</a> vào để sử dụng tính năng này!
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>			
        </div>		
    </div>
  </div>
</div>
<?php } ?>
<!-- GUI BAO CAO SAN PHAM -->

<?php $this->load->view('shop/common/footer'); ?>


<?php
if ($siteGlobal->sho_mobile) {
    $phonenumber = $siteGlobal->sho_mobile;
} elseif ($siteGlobal->sho_phone) {
    $phonenumber = $siteGlobal->sho_phone;
}
if ($phonenumber) {
    ?>
    <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
        <div class="phonering-alo-ph-circle"></div>
        <div class="phonering-alo-ph-circle-fill"></div>
        <div class="phonering-alo-ph-img-circle">
            <a href="tel:<?php echo $siteGlobal->sho_mobile; ?>">
                <img data-toggle="modal" data-target=".bs-example-modal-md" src="https://i.imgur.com/v8TniL3.png"
                     alt="Liên hệ" width="50" onmouseover="this.src = 'https://i.imgur.com/v8TniL3.png';"
                     onmouseout="this.src = 'https://i.imgur.com/v8TniL3.png';">
            </a>
        </div>
    </div>
<?php } ?>
<style>
    span.qty_message {
        color: #f00;
    }
</style>
<script type="text/javascript">
    var n1 = <?php echo $t1 ? $t1 : 0; ?>;
    var n2 = <?php echo $t2 ? $t2 : 0; ?>;
    var n3 = <?php echo $t3 ? $t3 : 0; ?>;
    var pro_id = $('#product_showcart').val();
    var sl_color = '<?php echo $sel_color ? $sel_color : ""; ?>';
    var sl_size = '<?php echo $sel_size ? $sel_size : ""; ?>';
    var sl_material = '<?php echo $sel_material ? $sel_material : ""; ?>';

    $(document).ready(function () {
        if ($('.ar_size').attr('class') == 'row ar_size hidden' && $('.ar_material').attr('class') == 'row ar_material hidden') {
            $('.addToCart_detail').attr('disabled', 'disabled');
            $('.addToCart_detail').css('cursor', 'auto');
            $('.addToCart_detail').attr('title', 'Bạn phải chọn màu sắc');
            $('.buyNow_detail').attr('disabled', 'disabled');
            $('.buyNow_detail').css('cursor', 'auto');
            $('.buyNow_detail').attr('title', 'Bạn phải chọn màu sắc');
            $('.note').css('display', 'block');
        }
        else {
            $('#mausac_1').click();
            $('#kichthuoc_1').addClass('actived');
            $('#chatlieu_1').addClass('actived');
        }
        $('#_selected_color').val($('#mausac_1').text());
    });

    function SelectProSales(id) {
        jQuery.ajax({
            type: "POST",
            url: siteUrl + "home/affiliate/ajax_select_pro_sales",
            dataType: 'json',
            data: {proid: id},
            success: function (data) {
                console.log(data);
                if (data == '1') {
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra!');
                }
            }
        });
    }

    function ClickColor(name, no, e) {
        var a = $('#st_color_' + name).val();
        if (a) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url(); ?>" + "home/product/select_style_pro_1?id=" + pro_id + "&color=" + a,
                data: {id: pro_id, color: a, size: sl_size, material: sl_material},
                success: function (result) {
                    for (var i = 1; i <= n1; i++) {
                        if (i != no) {
                            $('#mausac_' + i).removeClass('actived');
                        } else {
                            $('#mausac_' + i).addClass('actived');
                        }
                    }
                    var text = $('#chatlieu_1').text();
                    if (text != '') {
                        $("#ar_material").addClass('hidden');
                    }
                    $('.pull-left').each(function () {
                    });
                    if (result.error == false) {
                        $(".qty_message").text('');
                        $("#_selected_size").val("");
                        $("#_selected_material").val("");
                        $("#qty_" + pro_id).val(<?php echo $pty_min; ?>);
                        sl_color = name;
                        if (result.pro_prices == null) {
                            $(".qty_row").addClass('hidden');
                            //$("#bt_" + pro_id).addClass('hidden');
//                            $("#bt_hethang_" + pro_id).removeClass('hidden');
                        } else {
                            var money = parseInt(result.pro_prices);
                            var money_save = money - parseInt(result.off_amount);
                            var money_save_af = money_save - parseInt(result.af_off);
                            money = money.toLocaleString();
                            money_save = money_save.toLocaleString();
                            money_save_af = money_save_af.toLocaleString();
                            $("#show-cost").text(money + ' vnđ');
                            $("#cost-save").text(money_save + '');
                            $("#cost-save-af").text(money_save_af + ' vnđ');
                            $("#bt_hethang_" + pro_id).addClass('hidden');
                            $("span.st_size_value").text("");
                            $("span.st_material_value").text("");
                            $('#_selected_color').val($('#mausac_' + no).text());
                            $(".qty_row").removeClass('hidden');
                            $("#bt_" + pro_id).removeClass('hidden');
                            $("#carousel-ligghtgallery .owl-item.active .item img").attr("src", function () {
                                return "<?php echo base_url() . 'media/images/product/'; ?>" + result.pro_dir + "/" + result.pro_images;
                            });
                            $("#dp_id").val(result.pro_id);
                        }
                        if (result.ar_size == '' && result.ar_material == '') {
                            $('.addToCart_detail').removeAttr('disabled');
                            $('.addToCart_detail').css('cursor', 'pointer');
                            $('.addToCart_detail').removeAttr('title');
                            $('.buyNow_detail').removeAttr('disabled');
                            $('.buyNow_detail').css('cursor', 'pointer');
                            $('.buyNow_detail').removeAttr('title');
                            $('.note').css('display', 'none');

                            var str = result.pro_images;
                            var arr_img = str.split(',');
                            var str_price = result.pro_prices;
                            var str_offamount = result.offamount_arr;
                            var str_offaff = result.offaff_arr;

                            var str_max = result.pro_max;
                            var str_id = result.pro_id;
                            var arr_id = str_id.split(',');
                            var arr_max = str_max.split(',');
                            if (arr_id.length > 1) {
                                $("#dp_id").val(arr_id[0]);
                                $("#qty_max").val(arr_max[0]);
                            }
                            getdata(str, result.pro_dir, arr_img, str_price, str_max, str_id, str_offamount, str_offaff);
                        } else {
                            var data = {pro_id: pro_id, color: a};
                            if (result.ar_size != '') {
                                load_size(data);
                            } else {
                                $('#_selected_size').val('');
                                load_chatlieu(data);
                            }
                        }
                    } else {
                        alert('error: true');
                    }
                },
                error: function () {
                    alert('Có lỗi xảy ra.');
                }
            });
        }
    }

    function load_size(datajs){
        $.ajax({
            url:  '<?php echo base_url(); ?>home/product/load_size',
            type: "POST",
            data: datajs,
            dataType: "json",
            beforeSend: function () {
                $(this).disabled = true;
            },
            success: function (response) {
                $('.list_ar_size').disabled = false;
                var text = $('#kichthuoc_1').text();
                if(response != null && response.li != null){
                    $('.list_ar_size').html(response.li);
                    var text = $('#kichthuoc_1').text();
                    if (response.li != '') {
                        $(".ar_size").removeClass('hidden');
                    }
                    $('.st_size_value').text('');
                }
                hideLoading();
            },
            error: function () {
                alert('Khong load duoc mau sac');
            }
        });
    }
    
    function ClickSize(name, no) {
        var b = $('#st_size_' + name).val();
        if (b) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url(); ?>" + "home/product/product_style_azibai",
                data: {id: pro_id, color: sl_color, size: b, material: sl_material},
                success: function (result) {
                    for (var i = 1; i <= n2; i++) {
                        if (i != no) {
                            $('#kichthuoc_' + i).removeClass('actived');
                        } else {
                            $('#kichthuoc_' + i).addClass('actived');
                        }
                    }
                    if (result.error == false) {
                        $("#qty_" + pro_id).val(<?php echo $pty_min; ?>);
                        $(".qty_message").text('');
                        sl_size = name;
                        if (result.pro_prices == null) {
                            $(".qty_row").addClass('hidden');
                            $("#bt_" + pro_id).addClass('hidden');
//                            $("#bt_hethang_" + pro_id).removeClass('hidden');
                        } else {
                            var text = $('#chatlieu_1').text();
                            if (text == '') {
                                var money = parseInt(result.pro_prices);
                                var money_save = money - parseInt(result.off_amount);
                                var money_save_af = money_save - parseInt(result.af_off);
                                money = money.toLocaleString();
                                money_save = money_save.toLocaleString();
                                money_save_af = money_save_af.toLocaleString();
                                $("#show-cost").text(money + ' vnđ');
                                $("#cost-save").text(money_save);
                                $("#cost-save-af").text(money_save_af + ' vnđ');
                            }

                            if (text != '') {
                                $("#ar_material").removeClass('hidden');
                            }

                            $("span.st_material_value").text("");
                            $("#_selected_material").val("");
                            $("#prompt_select_size").addClass('hidden');
                            $('#_selected_size').val($('#kichthuoc_' + no).text());
                            $("#bt_hethang_" + pro_id).addClass('hidden');
                            $(".qty_row").removeClass('hidden');
                            var active_cl = false;
                            $("#bt_" + pro_id).removeClass('hidden');
                            for (var i = 1; i <= n3; i++) {
                                if ($('#chatlieu_' + i).attr('class') == 'active') {
                                    active_cl = true;
                                }
                            }
                            //$("#dp_id").val(result.pro_id);

                            if (text == '') {

                                var str = result.pro_images;
                                var arr_img = str.split(',');
                                var str_price = result.pro_prices;
                                var str_offamount = result.offamount_arr;
                                var str_offaff = result.offaff_arr;

                                var str_max = result.pro_max;
                                var str_id = result.pro_id;
                                var arr_id = str_id.split(',');
                                var arr_max = str_max.split(',');
                                if (arr_id.length > 1) {
                                    $("#dp_id").val(arr_id[0]);
                                    $("#qty_max").val(arr_max[0]);
                                }
                                getdata(str, result.pro_dir, arr_img, str_price, str_max, str_id, str_offamount, str_offaff);
                            }
                        }
                    }
                },
                error: function () {
                }
            });
        }
        
        var data = {pro_id: pro_id, color: $('#st_color_'+sl_color).val(), size: b};
        load_chatlieu(data);
        $('.st_size_value').text(b);
    }
    
    function load_chatlieu(datajs){
        //console.log(datajs);
        $.ajax({
            url:  '<?php echo base_url(); ?>home/product/load_chatlieu',
            type: "POST",
            data: datajs,
            dataType: "json",
            beforeSend: function () {
                $(this).disabled = true;
            },
            success: function (response) {
                $('.list_ar_material').disabled = false;
                var text = $('#chatlieu_1').text();
                if(response != null && response.li != null){
                    $('.list_ar_material').html(response.li);
                    var text = $('#chatlieu_1').text();
                    if (response.li != '') {
                        $("#ar_material").removeClass('hidden');
                    }
                    $('.st_material_value').text('');
                }
                hideLoading();
            },
            error: function () {
                alert('No show data');
            }
        });
    }
    
    function ClickMaterial(name, no) {
        var b = $('#_selected_size').val();
        var c = $('#st_material_' + name).val();
        var size = '';
        var url = '';
        if (b == '') {
            size = '';
        } else {
            size = "&size=" + b;
        }
        if (c) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url(); ?>" + "home/product/product_style_azibai",
                data: {id: pro_id, color: sl_color, size: sl_size, material: c},
                success: function (result) {
                    for (var i = 1; i <= n3; i++) {
                        if (i != no) {
                            $('#chatlieu_' + i).removeClass('actived');
                        } else {
                            $('#chatlieu_' + i).addClass('actived');
                        }
                    }
                    if (result.error == false) {
                        $("#qty_" + pro_id).val(<?php echo $pty_min; ?>);
                        $(".qty_message").text('');
                        sl_material = name;
                        if (result.pro_prices == null) {
                            $(".qty_row").addClass('hidden');
                            $("#bt_" + pro_id).addClass('hidden');
//                            $("#bt_hethang_" + pro_id).removeClass('hidden');
                        } else {
                            var money = parseInt(result.pro_prices);
                            var money_save = money - parseInt(result.off_amount);
                            var money_save_af = money_save - parseInt(result.af_off);
                            money = money.toLocaleString();
                            money_save = money_save.toLocaleString();
                            money_save_af = money_save_af.toLocaleString();
                            $("#show-cost").text(money + ' vnđ');
                            $("#cost-save").text(money_save);
                            $("#cost-save-af").text(money_save_af + ' vnđ');
                            $("#prompt_select_material").addClass('hidden');
                            $('#_selected_material').val($('#chatlieu_' + no).text());
                            $("#bt_hethang_" + pro_id).addClass('hidden');
                            $(".qty_row").removeClass('hidden');
                            $("#bt_" + pro_id).removeClass('hidden');

                            $("#dp_id").val(result.pro_id);
                            var str = result.pro_images;
                            var arr_img = str.split(',');
                            var str_price = result.pro_prices;
                            var str_offamount = result.offamount_arr;
                            var str_offaff = result.offaff_arr;

                            var str_max = result.pro_max;
                            var str_id = result.pro_id;
                            var arr_id = str_id.split(',');
                            var arr_max = str_max.split(',');
                            if (arr_id.length > 1) {
                                $("#dp_id").val(arr_id[0]);
                                $("#qty_max").val(arr_max[0]);
                            }
                            getdata(str, result.pro_dir, arr_img, str_price, str_max, str_id, str_offamount, str_offaff);
                        }
                    }
                },
                error: function () {
                }
            });
        }

        $('.st_material_value').html(c);
    }

    function getdata(str, pro_dir, arr_img, str_price, str_max, str_id, str_off_amount, str_af_off) {
        $('.imagepro').load("<?php echo base_url(); ?>" + "home/product/slide_img?arr_img=" + str + '&dir_img=' + pro_dir, function (response, status, xhr) {
            if (status != 'error') {
                var el = $('.owl-stage .owl-item'), elW = 0;
                el.each(function () {
                    elW += $(this).width();
                });
                $('.owl-stage').css('width', elW);
                $('#carousel-ligghtgallery').lightGallery({
                    selector: '.image',
                    download: false
                });
                $('.owl-carousel').owlCarousel({
                    loop: false, margin: 0, nav: false, items: 1
                });
                if (arr_img.length > 1) {
                    set_price(str_price, str_max, str_id, str_off_amount, str_af_off);
                }
                else {
                    var price_tp = parseInt(str_price).toLocaleString();
                    $("#show-cost").text(price_tp + ' vnđ');
                    $("#qty_max").val(str_max);
                    $("#dp_id").val(str_id);
                }
            } else {
                alert('error');
            }
        });
    }

    function set_price(str_price, str_max, str_id, str_off_amount, str_af_off) {
        var arr_price = str_price.split(',');
        var arr_affamount = str_off_amount.split(',');
        var arr_afoff = str_af_off.split(',');

        var arr_max = str_max.split(',');
        var id = str_id.split(',');
        if (arr_price.length > 1) {
            $('.owl-carousel').on('changed.owl.carousel', function (event) {
                var index = event.item.index;
                if (index == null) {
                    $("#show-cost").text(arr_price + '');
                    console.log('null: ' + arr_price);
                } else {
                    var money = parseInt(arr_price[index]);
                    var money_save = money - parseInt(arr_affamount[index]);
                    var money_save_af = money_save - parseInt(arr_afoff[index]);
                    money = money.toLocaleString();
                    money_save = money_save.toLocaleString();
                    money_save_af = money_save_af.toLocaleString();
                    $("#show-cost").text(money + ' vnđ');
                    $("#cost-save").text(money_save);
                    $("#cost-save-af").text(money_save_af + ' vnđ');
                    $("#qty_max").val(arr_max[index]);
                    $("#dp_id").val(id[index]);
                }
            });
        }
    }

</script>
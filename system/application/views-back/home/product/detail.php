<?php 
    $this->load->view('home/common/header');
    $group_id = (int)$this->session->userdata('sessionGroup');
?>

<!-- START CENTER-->
<div class="container-fluid">
    <div class="row rowmain">
        <div class="col-lg-2 hidden-md hidden-sm hidden-xs">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-10 col-xs-12">
            
            <ol id="breadcrumb" class="breadcrumb" style="white-space: nowrap; overflow: auto;">
                <li><a href="/shop/products" class="home">Mua sắm</a></li>
                <?php if ($siteGlobal->cat_id != "") { ?>
                    <li>
                        <a rel="v:url" property="v:title"
                           href="<?php echo base_url() ?><?php echo $siteGlobal->cat_id; ?>/<?php echo RemoveSign($siteGlobal->cat_name); ?>"
                           title="<?php echo $siteGlobal->cat_name; ?>"><?php echo $siteGlobal->cat_name ?></a>
                    </li>
                <?php } ?>
            </ol>
            
            <div class="row">
               
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?php
                    if ($shop->domain != '') {
                        $my_link_news = 'http://' . $shop->domain;
                        $my_link_shop = $my_link_news . '/shop';
                    } else {
                        $my_link_news = '//' . $shop->sho_link . '.' . domain_site;
                        $my_link_shop = $my_link_news . '/shop'; 
                    }

                    $shoplogo = DOMAIN_CLOUDSERVER."images/logo-home.png";
                    if ($shop->sho_logo) {
                        $shoplogo = DOMAIN_CLOUDSERVER.'media/shop/logos/' . $shop->sho_dir_logo . '/' . $shop->sho_logo;
                    }
                    ?>
                    <table width="100%"> 
                        <tr>
                            <td width="50">
                                <div class="img-circle" style="width: 44px; height: 44px; border:1px solid #ddd;overflow: hidden;">
                                    <a target="_blank" class="sho_logo_small" href="<?php echo $my_link_news; ?>">
                                        <img src="<?php echo $shoplogo ?>" alt="<?php echo $shop->sho_name; ?>"/>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <strong><a target="_blank" href="<?php echo $my_link_shop; ?>"><?php echo $shop->sho_name; ?></a></strong>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <?php if($product->end_date_sale != '' && $product->end_date_sale > strtotime(date("Y-m-d")) ) { ?>				
                        <script src="/templates/home/js/jquery.countdown.min.js"></script>
                        <p class="promotion-time">
                                <i class="fa fa-clock-o fa-fw"></i>Thời gian khuyến mãi: 							
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
            <br class="hidden-xs">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                    <?php
                        $product_report = $product; 
                        $listimages = explode(',', $product->pro_image);
                    ?>
                    <?php if ($product->pro_show == 0) {
                        $img = 'media/images/product/' . $product->pro_dir . '/' . show_image($product->pro_image);
                        ?>
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
                                text-align: center;
                                background: #fff;
                            }

                            span.w150 {
                                display: inline-block;
                                width: 100px;
                            }

                            .actived {
                                background: #e5e5e5;
                                color: #000;
                                border: 1px solid #d1d1d1;
                            }

                            .row-hidden {
                                display: none;
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
                        <!-- Owl Stylesheets -->
                    <link href="/templates/home/owlcarousel/owl.carousel.min.css" rel="stylesheet" type="text/css"/>
                    <link href="/templates/home/owlcarousel/owl.theme.default.min.css" rel="stylesheet" type="text/css"/>
                        <div class="imagepro">
                            <div id="carousel-ligghtgallery" class="owl-carousel owl-theme">
                                <?php
                                foreach ($listimages as $k => $image):
                                    $imgsrc = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_3_' . $image;
                                    ?>
                                    <div class="fix1by1 item <?php echo $k == 0 ? 'active' : '' ?>">
                                        <?php if ($image != '') { //file_exists($imgsrc) &&  ?>
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
                            $(function ($) {
                                $('#carousel-ligghtgallery').lightGallery({selector: '.image', download: false});
                                $('#carousel-ligghtgallery').owlCarousel({
                                    loop: false, margin: 0, nav: false, items: 1
                                })
                            });
                        </script>
                    <?php } else { ?>
                    <?php $imageDetail = explode(',', $product->pro_image); ?>
                        <div class="large-img">
                            <a class="slideshow"
                               href="<?php echo DOMAIN_CLOUDSERVER; ?>media/images/product/<?php echo $product->pro_dir; ?>/thumbnail_3_<?php echo $imageDetail[0]; ?>">
                                <img class="img-responsive"
                                     src="<?php echo DOMAIN_CLOUDSERVER; ?>media/images/product/<?php echo $product->pro_dir; ?>/thumbnail_3_<?php echo $imageDetail[0]; ?>"
                                     alt=""/>
                            </a>
                        </div>
                        <ul class="list-img">
                            <?php foreach ($imageDetail as $key => $imageDetailArray) { ?>
                                <?php if ($imageDetailArray != "") { ?>
                                    <li class="<?php if ($key == 0) {
                                        echo 'current';
                                    } ?>">
                                        <a class="slideshow"
                                           href="<?php echo DOMAIN_CLOUDSERVER; ?>media/images/product/<?php echo $product->pro_dir; ?>/thumbnail_3_<?php echo $imageDetailArray; ?>">
                                            <img
                                                src="<?php echo DOMAIN_CLOUDSERVER; ?>media/images/product/<?php echo $product->pro_dir; ?>/thumbnail_3_<?php echo $imageDetailArray; ?>"/>
                                        </a>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                        <script language="javascript"
                                src="<?php echo base_url(); ?>templates/home/js/colorbox.js"></script>
                    <link type="text/css" href="<?php echo base_url(); ?>templates/home/css/colorbox.css"
                          rel="stylesheet">
                        <script type="text/javascript">
                            jQuery(function ($) {
                                $(".slideshow").colorbox({rel: 'slideshow', slideshow: true, height: "90%"});
                                $('.list-img a').hover(function () {
                                    $('.large-img a').attr('href', $(this).attr('href'));
                                    $('.large-img a img').attr('src', $(this).find('img').attr('src'));
                                });
                            });
                        </script>
                    <?php } ?>
                    <div style="clear:both"></div>
                    <?php
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
                            <a class="btn btn-default" href="javascript:void(0)" onclick="
                                window.open(
                                'https://twitter.com/share?text=<?php echo $product->pro_name ?>&amp;url=<?php echo $ogurl ?>',
                                'twitter-share-dialog',
                                'width=800,height=600');
                                return false;">
                                <span class="fa fa-twitter"></span>
                            </a>
                        </div>
                        <div class="btn-group" role="group">
                            <a class="btn btn-default" href="javascript:void(0)" onclick="
                                window.open(
                                'https://plus.google.com/share?url=<?php echo $ogurl ?>',
                                'google-share-dialog',
                                'width=800,height=600');
                                return false;">
                                <span class="fa fa-google-plus"></span>
                            </a>
                        </div>
                        <div class="btn-group" role="group">
                            <a class="btn btn-default" href="javascript:void(0)" onclick="
                                window.open(
                                'https://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $ogurl ?>',
                                'google-share-dialog',
                                'width=800,height=600');
                                return false;">
                                <span class="fa fa-linkedin"></span>
                            </a>
                        </div>
                        <div class="btn-group" role="group">
                            <a class="btn btn-default" href="javascript:void(0)" onclick="
                                window.open('https://mail.google.com/mail/u/0/?view=cm&fs=1&to&su=<?php echo $product->pro_name ?>&body=<?php echo $ogurl ?>&ui=2&tf=1',
                                'google-share-dialog',
                                'width=800,height=600')
                                return false;">
                                <span class="fa fa-envelope-o"></span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">					
                    <div class="cost_detail_value">
                        <h2><?php echo $product->pro_name; ?></h2>
                        <div class="row view_buy">
                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
                                <a title="Lượt mua" href="#">
                                    <i class="fa fa-shopping-bag" aria-hidden="true"></i> <?php echo $product->pro_buy; ?>
                                </a>
                                <a title="Lượt xem" href="#"><i class="fa fa-eye"></i> <?php echo $product->pro_view; ?></a>
                            </div>
                            <div class="col-lg-3 col-md-2 col-sm-2 col-xs-12">
                                <a href="#" style="border:none;" class="report" data-id="<?php echo $product->pro_id ?>" data-toggle="modal" data-target="#reportdetailModal">Báo cáo</a>
                            </div>
                        </div>
						
                        <div class="cost_detail_box">
                            <div class="product-price">							
                                <table class="table-custom" width="100%" style="margin-bottom: 0">
                                    <?php
                                    // Added
                                    // by le van son
                                    // Calculation discount amount	
                                    $class = '';
                                    $afSelect = false;
                                    $_REQUEST['af_id'] = $_REQUEST['af_id'] != '' ? $_REQUEST['af_id'] : $this->session->userdata('af_id');
                                    if (($_REQUEST['af_id'] != '' && $product->is_product_affiliate == 1) || $this->session->userdata('sessionGroup') == 2) {
                                        $this->load->model('user_model');
                                        if($this->session->userdata('sessionGroup') == 2){
                                           $where = "use_id = ".$this->session->userdata('sessionUser'); 
                                           //$class = 'old-price';
                                        }else{
                                            $where = "af_key = '" . $_REQUEST['af_id'] . "'";
                                        }
                                        $userObject = $this->user_model->get("use_id", $where);
                                        if ($userObject->use_id > 0) {
                                            $afSelect = true;
                                        }
                                    }
                                    $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                                    ?>
                                    <tr>
                                        <td class="title_detail_tb"><?php echo $this->lang->line('cost_detail'); ?>:</td>
                                        <td>
                                            <?php if ((int)$product->pro_cost == 0) { ?>
                                                <?php echo $this->lang->line('call_main'); ?>
                                            <?php } else { ?>
                                                <span
                                                    class="sale-price root detail <?php echo ($product->off_amount > 0 || $discount['em_off'] > 0 || $discount['af_off'] > 0) ? 'old-price' : ''; ?>"
                                                    id="show-cost"><?php echo number_format($product->pro_cost, 0, ",", "."); ?>
                                                    vnđ</span> <br>
                                            <?php } ?>
                                        </td>
                                    </tr>

                                    <?php if ($product->off_amount > 0 && $discount['em_off'] <= 0) { ?>  
                                    <tr>
                                        <td> Giá khuyến mãi:</td>  
                                        <td>
                                                <span class="sale-price detail <?php echo $class?>" id="cost-save"><?php echo number_format($discount['off_sale'], 0, ",", "."); ?> vnđ</span>
                                                <span class="label label-success pull-right" style="padding: 5px;margin-left:15px;"> - <span><?php echo ($product->off_rate > 0) ? $product->off_rate . '%' : number_format($product->off_amount) . ' vnđ'; ?></span></span>
                                            <?php if($this->session->userdata('sessionGroup') == 2){ ?>  
                                                <!--<span class="sale-price detail">-->
                                                    <?php //echo number_format($discount['af_sale'], 0, ",", ".") . ' vnđ'; ?>
                                                <!--</span>-->
                                            <?php }else{ ?> 
                                            <?php } ?>   
                                        </td>
                                    </tr>    
                                    <?php } ?>

                                <?php if ($discount['af_off'] > 0): ?>
                                    <tr>
                                        <td width="120" valign="top" class="list_detail" style="line-height:18px;"> Giá mua qua CTV:
                                        </td>
                                        <td><span class="sale-price" id="cost-save-af"><?php echo number_format($discount['af_sale']); ?>
                                                vnđ</span>
                                            <span>Tiết kiệm thêm: <?php echo ($product->af_rate > 0) ? $product->af_rate . '%' : number_format($discount['af_off']) . ' vnđ'; ?></span>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                                    <?php if ($discount['em_off'] > 0): ?>
                                    <tr>
                                        <td>
                                            Giảm giá sỉ:
                                        </td>
                                        <td>
                                            <span class="sale-price detail"><?php echo number_format($discount['em_sale'], 0, ",", "."); ?> vnđ</span>
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                    <?php if ($promotions): ?>
                                    <tr>
                                        <td colspan="2">
                                            Giảm giá sỉ:                                       
                                            <table style="margin: 0" class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Mua từ</th>
                                                    <th>Mua tới</th>
                                                    <th>Được giảm</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <?php foreach ($promotions as $promotion): ?>
                                                    <?php
                                                    if ($promotion['limit_type'] == 2):
                                                        $pDiscount = $promotion['dc_rate'] > 0 ? $promotion['dc_amount'] . ' %' : number_format($promotion['dc_amount']) . ' đ';
                                                        ?>
                                                        <tr>
                                                            <?php
                                                            if ($promotion['limit_from'] == 0) {
                                                                echo '<td>Tổng tiền dưới ' . number_format($promotion['limit_to']) . ' đ</td><td></td><td>' . $pDiscount . '</td>';
                                                            } elseif ($promotion['limit_to'] == 0) {
                                                                echo '<td></td><td>Tổng tiền ' . number_format($promotion['limit_from']) . ' đ</td><td>' . $pDiscount . '</td>';
                                                            } else {
                                                                echo '<td>Tổng tiền ' . number_format($promotion['limit_from']) . ' đ</td><td>Tổng tiền ' . number_format($promotion['limit_to']) . ' đ </td><td>' . $pDiscount . '</td>';
                                                            }
                                                            ?>
                                                        </tr>
                                                    <?php else: ?>
                                                        <tr>
                                                            <?php
                                                            $pDiscount = $promotion['dc_rate'] > 0 ? $promotion['dc_amount'] . ' %' : number_format($promotion['dc_amount']) . ' đ';
                                                            if ($promotion['limit_from'] == 0) {
                                                                echo '<td>dưới ' . $promotion['limit_to'] . ' sản phẩm </td><td></td> <td>' . $pDiscount . '</td>';
                                                            } elseif ($promotion['limit_to'] == 0) {
                                                                echo '<td></td><td>trên ' . $promotion['limit_from'] . ' sản phẩm</td><td>' . $pDiscount . '</td>';
                                                            } else {
                                                                echo '<td>' . $promotion['limit_from'] . ' sản phẩm </td><td>' . $promotion['limit_to'] . ' sản phẩm </td><td>' . $pDiscount . '</td>';
                                                            }
                                                            ?>
                                                        </tr>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                            <!--                                            <ul>-->
                                            <!--                                                --><?php //foreach ($promotions as $promotion):                                                                                              ?>
                                            <!--                                                    <li>-->
                                            <!--                                                        --><?php //if ($promotion['limit_type'] == 2):                                                                                            ?>
                                            <!--                                                            --><?php
                                            //                                                            $pDiscount = $promotion['dc_rate'] > 0 ? $promotion['dc_amount'] . ' %' : number_format($promotion['dc_amount']) . ' đ';
                                            //                                                            if ($promotion['limit_from'] == 0) {
                                            //                                                                echo 'Tổng tiền mua hàng dưới ' . number_format($promotion['limit_to']) . ' đ được giảm ' . $pDiscount;
                                            //                                                            } elseif ($promotion['limit_to'] == 0) {
                                            //                                                                echo 'Tổng tiền mua hàng từ ' . number_format($promotion['limit_from']) . ' đ được giảm ' . $pDiscount;
                                            //                                                            } else {
                                            //                                                                echo 'Tổng tiền mua hàng từ ' . number_format($promotion['limit_from']) . ' đ tới ' . number_format($promotion['limit_to']) . ' đ được giảm ' . $pDiscount;
                                            //                                                            }
                                            ?>
                                            <!--                                                        --><?php //else:                                                                                             ?>
                                            <!--                                                            --><?php
                                            //                                                            $pDiscount = $promotion['dc_rate'] > 0 ? $promotion['dc_amount'] . ' %' : number_format($promotion['dc_amount']) . ' đ';
                                            //                                                            if ($promotion['limit_from'] == 0) {
                                            //                                                                echo 'Mua dưới ' . $promotion['limit_to'] . ' sản phẩm được giảm ' . $pDiscount;
                                            //                                                            } elseif ($promotion['limit_to'] == 0) {
                                            //                                                                echo 'Mua trên ' . $promotion['limit_from'] . ' sản phẩm được giảm ' . $pDiscount;
                                            //                                                            } else {
                                            //                                                                echo 'Mua từ ' . $promotion['limit_from'] . ' sản phẩm tới ' . $promotion['limit_to'] . ' sản phẩm được giảm ' . $pDiscount;
                                            //                                                            }
                                            ?>
                                            <!--                                                        --><?php //endif;                                                                                               ?>
                                            <!--                                                    </li>-->
                                            <!--                                                --><?php //endforeach;                                                                                               ?>
                                            <!--                                            </ul>-->

                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </table>
                            </div>
                            
				

                                <?php if (strtoupper($product->pro_currency) == 'VND') { ?>           <!--(<span id="DivCostExchange"></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?>)                                                                           <script type="text/javascript">FormatCost('<?php echo round((int)$product->pro_cost / settingExchange); ?>', 'DivCostExchange');</script>-->
                                <?php } else { ?>
                                    (<span
                                        id="DivCostExchange"></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>)
                                    <script
                                        type="text/javascript">FormatCost('<?php echo round((int)$product->pro_cost * settingExchange); ?>', 'DivCostExchange');</script>
                                <?php } ?>
                                <?php if ((int)$product->pro_hondle == 1 || (int)$product->pro_saleoff == 1) { ?>
                                    <div id="nego_detail">
                                        <?php if ((int)$product->pro_hondle == 1) { ?>
                                            <img src="<?php echo base_url(); ?>templates/home/images/hondle.gif"
                                                 border="0" alt=""/>&nbsp;&nbsp;&nbsp;
                                        <?php } ?>
                                    </div>
                                <?php } ?>
           
                        </div>
                        <div class="left_detail_botom">
                            <table class="table-custom" width="100%" style="margin-bottom: 0">
                                <?php if ($product->pro_quality != -1): ?>
                                    <tr>
                                        <td class="title_detail_tb"><?php echo $this->lang->line('pro_quality'); ?></td>
                                        <td>
                                            <?php
                                            if ($product->pro_quality == 1)
                                                echo "Cũ";
                                            if ($product->pro_quality == 0)
                                                echo "Mới";
                                            if ($product->pro_quality == -1)
                                                echo "Chưa cập nhật";
                                            ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php if ($product->pro_made_from != 0 && $product->pro_type == 0): ?>
                                    <tr>
                                        <td class="title_detail_tb"><?php echo $this->lang->line('pro_made_from'); ?></td>
                                        <td>
                                            <?php
                                            if ($product->pro_made_from == 1)
                                                echo "Chính hãng";
                                            if ($product->pro_made_from == 2)
                                                echo "Xách tay";
                                            if ($product->pro_made_from == 3)
                                                echo "Hàng công ty";
                                            if ($product->pro_made_from == 0)
                                                echo "Chưa cập nhật";
                                            ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php if (Counter_model::GetNhaSanXuatToID($product->pro_manufacturer_id) != '' && $product->pro_type == 0): ?>
                                    <tr>
                                        <td class="title_detail_tb">Nhà sản xuất:</td>
                                        <td>
                                            <?php echo Counter_model::GetNhaSanXuatToID($product->pro_manufacturer_id); ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php if ($product->pro_vat != 0): ?>
                                    <tr>
                                        <td class="title_detail_tb"><?php echo 'VAT'; ?></td>
                                        <td>
                                            <?php
                                            if ($product->pro_vat == 1)
                                                echo "Đã có VAT";
                                            if ($product->pro_vat == 2)
                                                echo "Chưa có VAT";
                                            if ($product->pro_vat == 0)
                                                echo "Chưa cập nhật";
                                            ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php if ($product->pro_type == 0) { ?>
                                    <tr>
                                        <td class="title_detail_tb"><?php echo $this->lang->line('pro_baohanh'); ?></td>
                                        <td>
                                            <?php
                                            if ($product->pro_warranty_period == 0) {
                                                echo "Không bảo hành";
                                            } else {
                                                echo $product->pro_warranty_period . " tháng";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php if ($siteGlobal->cat_id != "") { ?>
                                    <tr>
                                        <td class="title_detail_tb">Danh mục</td>
                                        <td>
                                            <a class="shoplink"
                                               href="<?php echo getAliasDomain() ?><?php echo $siteGlobal->cat_id; ?>/<?php echo RemoveSign($siteGlobal->cat_name); ?>"
                                               title="<?php echo $siteGlobal->cat_name; ?>"><?php echo mb_substr($siteGlobal->cat_name, 0, 30, 'UTF-8'); ?></a>

                                        </td>
                                    </tr>
                                <?php } ?>

                                <?php if ($product->pro_begindate): ?>
                                    <tr>
                                        <td class="title_detail_tb"><?php echo $this->lang->line('post_date_detail'); ?></td>
                                        <td><?php echo date('d-m-Y', $product->pro_begindate); ?>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php if ($product->pro_video): ?>
                                    <tr>
                                        <td class="title_detail_tb">Video sản phẩm</td>
                                        <td><?php if ($product->pro_video != '') { ?>
                                                <a href="#" class="youtube-play" data-toggle="modal"
                                                   data-target="#youtubeModal"><i class="fa fa-youtube-play"></i> Video
                                                    về sản phẩm </a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="youtubeModal" tabindex="-1" role="dialog"
                                                     aria-labelledby="youtubeModalLabel">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="video">
                                                                    <?php
                                                                    $provideo = explode("=", $product->pro_video);
                                                                    ?>
                                                                    <iframe width="800" height="450"
                                                                            src="https://www.youtube.com/embed/<?php echo $provideo ? $provideo[1] : 'zlsQF_ufUNU' ?>"
                                                                            frameborder="0" allowfullscreen></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php } ?></td>
                                    </tr>
                                <?php endif; ?>


                                <?php if ($product->pro_vote_total): ?>
                                    <tr>
                                        <td class="title_detail_tb"><?php echo $this->lang->line('vote_detail'); ?>:
                                        </td>
                                        <td>
                                            <?php for ($vote = 0; $vote < (int)$product->pro_vote_total; $vote++) { ?>
                                                <img src="<?php echo base_url(); ?>templates/home/images/star1.gif"
                                                     border="0" alt=""/>
                                            <?php } ?>
                                            <?php for ($vote = 0; $vote < 10 - (int)$product->pro_vote_total; $vote++) { ?>
                                                <img src="<?php echo base_url(); ?>templates/home/images/star0.gif"
                                                     border="0" alt=""/>
                                            <?php } ?>
                                            <b>[<?php echo $product->pro_vote; ?>]</b>
                                        </td>

                                    </tr>
                                <?php endif; ?>

                                <?php 
                                if ($group_id == BranchUser || $group_id == 2 || ($this->session->userdata('sessionGroup') == 3 && $this->session->userdata('sessionUser') != $product->pro_user && $product->is_product_affiliate == 1)) {
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
                                    } ?>
                                    <?php if ($product->is_product_affiliate == 1) { ?>
                                        <tr>

                                            <td colspan="2">
                                                <div class="hoahongAf">
                                                    <div class="TenHH">Hoa hồng Cộng tác viên được hưởng</div>
                                                    <div class="phantranHH"><?php echo $pro_affiliate_value; ?></div>
                                                </div>
                                                <?php if ($selected_sale != true) { ?>
                                                    <button class="btn btn-default"
                                                            onclick="SelectProSales('<?php echo getAliasDomain() ?>',<?php echo $product->pro_id; ?>);">
                                                        <i class="fa fa-check fa-fw"></i> Chọn bán
                                                    </button>
                                                <?php } else { ?>
                                                    <button class="btn btn-default"><i class="fa fa-check fa-fw"></i> Đã
                                                        chọn bán
                                                    </button>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            </table>
                        </div>

                        <div class="thanhtoan_edit">
                            <?php if ($product->pro_instock <= 0): ?>
                                <div class="order_messsage">Sản phẩm hết hàng</div>
                            <?php endif; ?>

                            <?php if ($product->pro_instock > 0) { ?>
                                <!-- BEGIN:: STYLE PRODUCT -->
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
                                            } else {
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
                                            } else {
                                                $hiddenMaterial = ' hidden';
                                            }
                                        }
                                    }
                                    $vowels = array(".", " ", ",", "/");
                                    ?>
                                    <?php if (isset($ar_color) && !empty($ar_color)) { ?>
                                <div class="ms" style="float: left"> Chọn màu sắc<span style="color:#f00;">*</span>: </div><span class="note" style="display: none; float: left; margin-left: 10px;"><strong>Bạn phải chọn màu sắc</strong></span>

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
                                                    <div class="pull-left" style="margin:5px 5px 5px 0">
                                                        <button id="mausac_<?php echo $t1; ?>"
                                                                class="style-group mausac "
                                                                onclick="ClickColor('<?php echo $st_color; ?>','<?php echo $t1; ?>',this);"><?php echo $v1; ?></button>
                                                        <!--<span class="style-group "  onclick="SeletColorStyle('<?php echo $v1; ?>','<?php echo $t1; ?>');"><?php echo $v1; ?></span>-->
                                                        <input type="hidden" id="<?php echo 'st_color_' . $st_color; ?>"
                                                               name="<?php echo 'st_color_' . $st_color; ?>"
                                                               value="<?php echo $v1; ?>">
                                                    </div>
                                                <?php } ?>
                                                <input type="hidden" name="_selected_color" id="_selected_color"/>
                                            </div>
                                        </div>
                                        <span class="hidden" id="prompt_select_color">Bạn phải chọn màu sắc.</span>
                                    <?php } ?>

                                    <?php //if (isset($ar_size) && !empty($ar_size) && $ar_size[0] != '') { ?>
                                    <div class="row ar_size<?php echo $hiddenSize ?>">
                                        <div class="col-xs-12">
                                            <div class="dropdown">
                                                <a id="dLabel" data-target="#" href="#" data-toggle="dropdown"
                                                   role="button" aria-haspopup="true" aria-expanded="false">
                                                    Chọn kích thước <span class="caret"></span> &nbsp;
                                                    <span class="st_size_value"></span>
                                                    <span class="hidden qcalert" id="prompt_select_size">Bạn phải chọn kích thước.</span>
                                                </a>
                                                <ul class="dropdown-menu list-inline list_ar_size"
                                                    aria-labelledby="dLabel">
                                                    <?php
                                                    $t2 = 0;
                                                    foreach ($ar_size as $k2 => $v2) {
                                                        $t2++;
                                                        if ($k2 == 0) {
                                                            $sel_size = $v2;
                                                        }
                                                        $st_size = str_replace($vowels, "_", $v2);
                                                        ?>
                                                        <li style="cursor: pointer;"><span
                                                                id="kichthuoc_<?php echo $t2; ?>"
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
                                    <?php //} ?>
                                    <?php //if(isset($ar_material) && !empty($ar_material) && $ar_material[0] != ''){ ?>
                                    <div class="row ar_material<?php echo $hiddenMaterial ?>" id="ar_material">

                                        <div class="col-xs-12">
                                            <div class="dropdown">
                                                <a id="dLabel" data-target="#" href="#" data-toggle="dropdown"
                                                   role="button" aria-haspopup="true" aria-expanded="false">
                                                    Chọn chất liệu <span class="caret"></span> &nbsp;
                                                    <span class="st_material_value text-primary"></span>
                                                    <span class="hidden qcalert" id="prompt_select_material">Bạn phải chọn chất liệu.</span>
                                                </a>
                                                <ul class="dropdown-menu list-inline list_ar_material"
                                                    aria-labelledby="dLabel">
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
                                    <?php //} ?>
                                    <hr/>
                                <?php } ?>
                                <!-- END:: STYLE PRODUCT -->

                                <div class="qty_row number_db">
                                    <?php $pty_min = $shop_type->shop_type >= 1 ? $product->pro_minsale : 1; ?>
                                    <div class="pull-left" style="width:150px;">Số lượng:</div>
                                    <div class="qty_group" id="mes_<?php echo $product->pro_id; ?>">
					<span class="sub-qty number3_db" title="Bớt" onclick="update_qty(<?php echo $product->pro_id; ?>, -1);">-</span>
					<input id="qty_<?php echo $product->pro_id; ?>" name="qty" autofocus="autofocus" autocomplete="off" type="text" min="1" max="9999" class="inpt-qty" required="true" value="<?php echo $pty_min; ?>" title="">
					<span class="add-qty" title="Thêm" onclick="update_qty(<?php echo $product->pro_id; ?>, 1);">+</span>
				    </div>				    
                                </div>
				<div class="clearfix">&nbsp;</div>
                                <div id="bt_<?php echo $product->pro_id; ?>"
                                     class="add_to_cart_button cart_db text-center">

                                    <div class="btn-group btn-group-justified" role="group">
                                        <?php if ($product->pro_type == 0) { ?>
                                            <div class="btn-group" role="group">
                                                <button onclick="addCartQty(<?php echo $product->pro_id; ?>);" title=""
                                                        type="button" class="btn btn-lg btn-addCart addToCart_detail"><i
                                                        class="fa fa-cart-plus fa-fw"></i>&nbsp;<span class="">Thêm vào giỏ</span>
                                                </button>
                                            </div>
                                        <?php } ?>
                                        <div class="btn-group" role="group">
                                            <button onclick="buyNowQty(<?php echo $product->pro_id; ?>);" title=""
                                                    type="button" class="btn btn-lg btn-buyNow buyNow_detail"><i
                                                    class="fa fa-check fa-fw"></i> Mua ngay
                                            </button>
                                        </div>
                                    </div>
                                    <!--<a class="fav" onclick="wishlist(<?php echo $product->pro_id; ?>);"><i class="fa fa-heart-o" aria-hidden="true"></i>&nbsp;Yêu thích </a>-->

                                    <input type="hidden" name="product_showcart" id="product_showcart"
                                           value="<?php echo $product->pro_id; ?>"/>
                                    <input type="hidden" name="af_id" value="<?php echo $_REQUEST['af_id']; ?>"/>
                                    <input type="hidden" name="qty_min" value="<?php echo $pty_min; ?>" id="qty_min"/>
                                    <input type="hidden" name="qty_max" value="<?php echo $product->pro_instock; ?>"
                                           id="qty_max"/>
                                    <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->id; ?>">

                                </div>
                                <?php if ($product->pro_type != 0) { ?>
                                    <div class="text-warning" style="margin-top:10px;"><i class="fa fa-tags"
                                                                                          aria-hidden="true"></i>&nbsp;<b>Sản
                                            phẩm này được bán dưới hình thức E-coupon.
                                            <a target="_blank" href="<?php echo base_url() . 'content/398'; ?>">Click để
                                                tìm hiểu thêm.</a></b></div>
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
                                    <input type="hidden" name="product_showcart" id="product_showcart"
                                           value="<?php echo $product->pro_id; ?>"/>
                                    <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->id; ?>">
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="height:30px;"></div>
            <div class="row">
                <!-- THÔNG TIN CHI TIẾT -->
                <div class="col-lg-12 col-xs-12">
                    <ul class="menu-justified" id="tabsanpham">
                        <li class="active">
							<a data-toggle="tab" href="#DivContentDetail">
                                <span class="hint--top" data-hint="Thông tin chi tiết"><i class="fa fa-list-alt"
                                                                                          aria-hidden="true"></i></span>
                                <span class="hidden-xs"><?php echo $this->lang->line('tab_detail_detail'); ?></span>
                            </a>
                        </li>
                        <li>
							<a data-toggle="tab" href="#DivVoteDetail">
                                <span class="hint--top" data-hint="Bình chọn sản phẩm"><i class="fa fa-thumbs-up"
                                                                                          aria-hidden="true"></i></span>
                                <span class="hidden-xs"><?php echo $this->lang->line('tab_vote_detail'); ?></span></a>
                        </li>
                        <li><a data-toggle="tab" href="#DivReplyDetail"> <span class="hint--top"
                                                                                                     data-hint="Gửi phản hồi"><i
                                        class="fa fa-comments" aria-hidden="true"></i></span> <span
                                    class="hidden-xs"><?php echo $this->lang->line('tab_comment_detail'); ?></span></a>
                        </li>
                        <li><a data-toggle="tab" href="#DivSendLinkDetail">
                                <span class="hint--top" data-hint="Chia sẻ bạn bè"><i class="fa fa-share-alt"
                                                                                      aria-hidden="true"></i></span>
                                <span
                                    class="hidden-xs"><?php echo $this->lang->line('send_friend_detail'); ?></span></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div id="DivContentDetail" class="tab-pane fade in active">
                            <?php
                            $vovel = array("&curren;");
                            echo html_entity_decode(str_replace($vovel, "#", $product->pro_detail));                            
                            ?>
                        </div>
                        <div id="DivVoteDetail" class="tab-pane fade">
                            <form name="frmVote" method="post">
                                <table border="0" width="100%" style="border:1px #B3D9FF solid;" align="center"
                                       cellpadding="0" cellspacing="3">
                                    <tr height="25"
                                        style="color:#0AA2EB; background:url(<?php echo base_url(); ?>templates/home/images/bg_titlevote.jpg);">
                                        <td align="center" width="200"
                                            style="padding-left: 15px"><?php echo $this->lang->line('info_vote_detail'); ?></td>
                                        <td align="center"
                                            colspan="4"><?php echo $this->lang->line('bad_vote_detail'); ?></td>
                                        <td align="center"
                                            colspan="3"><?php echo $this->lang->line('normal_vote_detail'); ?></td>
                                        <td align="center"
                                            colspan="3"><?php echo $this->lang->line('good_vote_detail'); ?></td>
                                    </tr>
                                    <tr style="color:#666; font-size:11px;">
                                        <td align="center" style=""></td>
                                        <td align="center" style="background:#CCCCCC;">1</td>
                                        <td align="center" style="background:#CCCCCC;">2</td>
                                        <td align="center" style="background:#CCCCCC;">3</td>
                                        <td align="center" style="background:#CCCCCC;">4</td>
                                        <td align="center" style="background:#C8D7E6;">5</td>
                                        <td align="center" style="background:#C8D7E6;">6</td>
                                        <td align="center" style="background:#C8D7E6;">7</td>
                                        <td align="center" style="background:#A0DBFE;">8</td>
                                        <td align="center" style="background:#A0DBFE;">9</td>
                                        <td align="center" style="background:#A0DBFE;">10</td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="background:#ffffff; padding-left:15px;"><img
                                                src="<?php echo base_url(); ?>templates/home/images/icon_costvote.gif"
                                                border="0"
                                                alt=""/>&nbsp;<?php echo $this->lang->line('cost_vote_detail'); ?>:
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="cost"
                                                                                              value="1"></td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="cost"
                                                                                              value="2"></td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="cost"
                                                                                              value="3"></td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="cost"
                                                                                              value="4"></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="cost"
                                                                                              value="5" checked></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="cost"
                                                                                              value="6"></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="cost"
                                                                                              value="7"></td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="cost"
                                                                                              value="8"></td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="cost"
                                                                                              value="9"></td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="cost"
                                                                                              value="10"></td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="background:#ffffff; padding-left:15px;"><img
                                                src="<?php echo base_url(); ?>templates/home/images/icon_qualityvote.gif"
                                                border="0"
                                                alt=""/>&nbsp;<?php echo $this->lang->line('quanlity_vote_detail'); ?>:
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio"
                                                                                              name="quanlity" value="1">
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio"
                                                                                              name="quanlity" value="2">
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio"
                                                                                              name="quanlity" value="3">
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio"
                                                                                              name="quanlity" value="4">
                                        </td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio"
                                                                                              name="quanlity" value="5"
                                                                                              checked></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio"
                                                                                              name="quanlity" value="6">
                                        </td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio"
                                                                                              name="quanlity" value="7">
                                        </td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio"
                                                                                              name="quanlity" value="8">
                                        </td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio"
                                                                                              name="quanlity" value="9">
                                        </td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio"
                                                                                              name="quanlity"
                                                                                              value="10"></td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="background:#ffffff; padding-left:15px;"><img
                                                src="<?php echo base_url(); ?>templates/home/images/icon_modelvote.gif"
                                                border="0"
                                                alt=""/>&nbsp;<?php echo $this->lang->line('model_vote_detail'); ?>:
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="model"
                                                                                              value="1"></td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="model"
                                                                                              value="2"></td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="model"
                                                                                              value="3"></td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="model"
                                                                                              value="4"></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="model"
                                                                                              value="5" checked></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="model"
                                                                                              value="6"></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="model"
                                                                                              value="7"></td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="model"
                                                                                              value="8"></td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="model"
                                                                                              value="9"></td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="model"
                                                                                              value="10"></td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="background:#ffffff; padding-left:15px;"><img
                                                src="<?php echo base_url(); ?>templates/home/images/icon_servicevote.gif"
                                                border="0"
                                                alt=""/>&nbsp;<?php echo $this->lang->line('service_vote_detail'); ?>:
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio"
                                                                                              name="service" value="1">
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio"
                                                                                              name="service" value="2">
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio"
                                                                                              name="service" value="3">
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio"
                                                                                              name="service" value="4">
                                        </td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio"
                                                                                              name="service" value="5"
                                                                                              checked></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio"
                                                                                              name="service" value="6">
                                        </td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio"
                                                                                              name="service" value="7">
                                        </td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio"
                                                                                              name="service" value="8">
                                        </td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio"
                                                                                              name="service" value="9">
                                        </td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio"
                                                                                              name="service" value="10">
                                        </td>
                                    </tr>
                                </table>
                                <div class="text-center" style="padding-top:10px">
                                    <input type="button" name="submit_vote" onclick="SubmitVote()"
                                           value="<?php echo $this->lang->line('button_vote_detail'); ?>"
                                           class="btn btn-azibai"/>
                                </div>
                            </form>
                        </div>
                        <div id="DivReplyDetail" class="tab-pane fade">
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                                <?php foreach ($comment as $commentArray) { ?>
                                    <tr>
                                        <td height="50" class="header_reply">
                                            <div class="title_reply"><?php echo $commentArray->prc_title; ?> <span
                                                    class="time_reply">(<?php echo $this->lang->line('time_comment_detail'); ?> <?php echo date('H\h:i', $commentArray->prc_date); ?> <?php echo $this->lang->line('date_comment_detail'); ?> <?php echo date('d-m-Y', $commentArray->prc_date); ?>
                                                    )</span></div>
                                            <div class="author_reply"><font
                                                    color="#999999"><?php echo $this->lang->line('poster_comment_detail'); ?>
                                                    :</font> <?php echo $commentArray->use_fullname; ?> <span
                                                    class="email_reply"><a class="menu_1"
                                                                           href="mailto:<?php echo $commentArray->use_email; ?>">(<?php echo $commentArray->use_email; ?>
                                                        )</a></span></div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content_reply"><?php echo nl2br($commentArray->prc_comment); ?></td>
                                    </tr>
                                <?php } ?>
                                <tr>
                                    <td class="show_page" style="padding-right:1px;"><?php echo $cLinkPage; ?></td>
                                </tr>
                            </table>
                            <form name="frmReply" method="post" class="form-horizontal">
                                <div class="form-group">
                                    <label
                                        class="col-md-3 control-label"><?php echo $this->lang->line('title_comment_detail'); ?>
                                        :</label>
                                    <div class="col-md-6">
                                        <input type="text" name="title_reply" id="title_reply"
                                               value="<?php if (isset($title_reply)) {
                                                   echo $title_reply;
                                               } ?>" maxlength="40" class="input_form form-control"
                                               onfocus="ChangeStyle('title_reply', 1);"
                                               onblur="ChangeStyle('title_reply', 2);"/>
                                    </div>
                                    <div class="col-md-3"> <?php echo form_error('title_reply'); ?> </div>
                                </div>
                                <div class="form-group">
                                    <label
                                        class="col-md-3 control-label"><?php echo $this->lang->line('content_comment_detail'); ?>
                                        :</label>
                                    <div class="col-md-6">
                                        <textarea name="content_reply" id="content_reply" class="form-control"
                                                  onfocus="ChangeStyle('content_reply', 1);"
                                                  onblur="ChangeStyle('content_reply', 2);"><?php if (isset($content_reply)) {
                                                echo $content_reply;
                                            } ?>
                                        </textarea>
                                    </div>
                                    <div class="col-md-3"> <?php echo form_error('content_reply'); ?> </div>
                                </div>

                                <?php if (isset($imageCaptchaReplyProduct)) { ?>
                                    <div class="form-group">
                                        <label
                                            class="col-md-3 control-label"><?php echo $this->lang->line('captcha_main'); ?>
                                            :</label>
                                        <div class="col-md-6"><img
                                                src="<?php echo $imageCaptchaReplyProduct; ?>" width="151"
                                                height="30" alt=""/><br/>
                                             <input type="hidden" value="<?php echo $cacha_reply; ?>"
                                                           name="captcha" id="captcha"/>
                                            <input type="text" name="captcha_reply" id="captcha_reply" value=""
                                                   maxlength="10" class="inputcaptcha_form"
                                                   onfocus="ChangeStyle('captcha_reply', 1);"
                                                   onblur="ChangeStyle('captcha_reply', 2);"/>
                                        </div>
                                        <div class="col-md-3"> <?php echo form_error('captcha_reply'); ?> </div>
                                    </div>
                                <?php } ?>

                                <div class="form-group">
                                    <label class="col-md-3 form-label"></label>
                                    <div class="col-md-6">
                                        <input type="button" onclick="CheckInput_Reply('<?php
                                        if (isset($isLogined) && $isLogined == true) {
                                            echo 1;
                                        } else {
                                            echo $this->lang->line('must_login_message');
                                        } ?>');" name="submit_reply"
                                               value="<?php echo $this->lang->line('button_comment_comment_detail'); ?>"
                                               class="btn btn-azibai"/>
                                        <input type="reset" name="reset_reply"
                                               value="<?php echo $this->lang->line('button_reset_comment_detail'); ?>"
                                               class="btn btn-default"/>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                            </form>
                        </div>
                        <div id="DivSendLinkDetail" class="tab-pane fade">
                            <div class="sendlink_main">
                                <form name="frmSendLink" class="form-horizontal" method="post">
                                    <div class="form-group">
                                        <label
                                            class="col-sm-3 control-label"><?php echo $this->lang->line('email_sender_send_friend_detail'); ?>
                                            :</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="sender_sendlink" id="sender_sendlink"
                                                   value="<?php if (isset($sender_sendlink)) {
                                                       echo $sender_sendlink;
                                                   } ?>" maxlength="50" class="input_form form-control"
                                                   onfocus="ChangeStyle('sender_sendlink', 1);"
                                                   onblur="ChangeStyle('sender_sendlink', 2);"/>
                                        </div>
                                        <div class="col-sm-3"> <?php echo form_error('sender_sendlink'); ?> </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            class="col-sm-3 control-label"><?php echo $this->lang->line('email_receiver_send_friend_detail'); ?>
                                            :</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control input_form" name="receiver_sendlink"
                                                   id="receiver_sendlink" value="<?php
                                            if (isset($receiver_sendlink)) {
                                                echo $receiver_sendlink;
                                            }
                                            ?>" maxlength="50" onfocus="ChangeStyle('receiver_sendlink', 1);"
                                                   onblur="ChangeStyle('receiver_sendlink', 2);"/>
                                        </div>
                                        <div class="col-sm-3"> <?php echo form_error('receiver_sendlink'); ?> </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            class="col-sm-3 control-label"><?php echo $this->lang->line('title_send_friend_detail'); ?>
                                            :</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="title_sendlink" id="title_sendlink"
                                                   value="<?php
                                                   if (isset($title_sendlink)) {
                                                       echo $title_sendlink;
                                                   }
                                                   ?>" maxlength="80" class="input_form form-control"
                                                   onfocus="ChangeStyle('title_sendlink', 1);"
                                                   onblur="ChangeStyle('title_sendlink', 2);"/>
                                        </div>
                                        <div class="col-sm-3"> <?php echo form_error('title_sendlink'); ?> </div>
                                    </div>
                                    <div class="form-group">
                                        <label
                                            class="col-sm-3 control-label"><?php echo $this->lang->line('message_send_friend_detail'); ?>
                                            :</label>
                                        <div class="col-sm-6">
                                            <textarea name="content_sendlink" class="form-control" id="content_sendlink"
                                                      cols="50" rows="7" onfocus="ChangeStyle('content_sendlink', 1);"
                                                      onblur="ChangeStyle('content_sendlink', 2);">
                                                <?php if (isset($content_sendlink)) {
                                                    echo $content_sendlink;
                                                } ?>
                                            </textarea>
                                        </div>
                                        <div class="col-sm-3"> <?php echo form_error('content_sendlink'); ?> </div>
                                    </div>
                                    <?php if (isset($imageCaptchaSendFriendProduct)) { ?>
                                        <div class="form-group">
                                            <label
                                                class="col-sm-3 control-label"><?php echo $this->lang->line('captcha_main'); ?>
                                                :</label>
                                            <div class="col-sm-6">
                                                <img src="<?php echo $imageCaptchaSendFriendProduct; ?>"
                                                     width="151" height="30" alt=""/><br/>
                                                <input type="hidden" value="<?php echo $cacha; ?>"
                                                           name="capcha_friend" id="capcha_friend"/>
                                                <input onKeyPress="return submitenter(this, event, 1)" type="text"
                                                       name="captcha_sendlink" id="captcha_sendlink" value=""
                                                       maxlength="10" class="inputcaptcha_form form-control"
                                                       onfocus="ChangeStyle('captcha_sendlink', 1);"
                                                       onblur="ChangeStyle('captcha_sendlink', 2);"/>
                                            </div>
                                            <div class="col-sm-3"> <?php echo form_error('captcha_sendlink'); ?> </div>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"> </label>
                                        <div class="col-sm-6">
                                            <input type="button" onclick="CheckInput_SendLink();" name="submit_sendlink"
                                                   value="<?php echo $this->lang->line('button_send_send_friend_detail'); ?>"
                                                   class="btn btn-azibai"/>
                                            <input type="reset" name="reset_sendlink"
                                                   value="<?php echo $this->lang->line('button_reset_send_friend_detail'); ?>"
                                                   class="btn btn-default"/>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div style="clear:both;"></div>
                    <?php /*
                      <div class="row text-center">
                      <div class="col-lg-6 col-md-6 col-sm-6"><a class="btn btn-default btn-block"
                      onclick="bao_cao_sai_gia('<?php echo base_url(); ?>','<?php echo $product->pro_id ?>','<?php echo $this->session->userdata('sessionUser'); ?>','0');"
                      data-toggle="tab" href="#DivSendFailDetail"><img
                      src="<?php echo base_url(); ?>templates/home/images/send_fail.png"
                      border="0"/> <?php echo $this->lang->line('send_bad_detail'); ?></a></div>
                      <div class="col-lg-6 col-md-6 col-sm-6"><a class="btn btn-default btn-block"
                      onclick="bao_cao_sai_gia('<?php echo base_url(); ?>','<?php echo $product->pro_id ?>','<?php echo $this->session->userdata('sessionUser'); ?>','1');"
                      data-toggle="tab" href="#DivHetHangDetail"><img
                      src="<?php echo base_url(); ?>templates/home/images/send_fail.png" border="0"/>Báo
                      cáo hết hàng</a></div>
                      </div>
                     */ ?>
                    <div id="DivSendFailDetail" style="display: none;">
                        <form name="frmSendFail" method="post">
                            <?php if ($this->session->userdata('sessionUser') > 0) { ?>
                                <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                    <tr>
                                        <td colspan="2" height="15"></td>
                                    </tr>
                                    <tr style="display:none;">
                                        <td width="110"
                                            class="list_form"><?php echo $this->lang->line('email_sender_send_bad_detail'); ?>
                                            :
                                        </td>
                                        <td align="left"><input type="text" name="sender_sendfail" id="sender_sendfail"
                                                                value="<?php if (isset($sender_sendfail)) {
                                                                    echo $sender_sendfail;
                                                                } ?>" maxlength="50" class="input_form"
                                                                onfocus="ChangeStyle('sender_sendfail', 1);"
                                                                onblur="ChangeStyle('sender_sendfail', 2);"/>
                                            <?php echo form_error('sender_sendfail'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="110"
                                            class="list_form"><?php echo $this->lang->line('title_send_bad_detail'); ?>:
                                        </td>
                                        <td align="left"><input type="text" name="title_sendfail" id="title_sendfail"
                                                                value="<?php if (isset($title_sendfail)) {
                                                                    echo $title_sendfail;
                                                                } ?>" maxlength="80" class="input_form"
                                                                onfocus="ChangeStyle('title_sendfail', 1);"
                                                                onblur="ChangeStyle('title_sendfail', 2);"/>
                                            <?php echo form_error('title_sendfail'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="110"
                                            class="list_form"><?php echo $this->lang->line('content_send_bad_detail'); ?>
                                            :
                                        </td>
                                        <td align="left">
                                        <textarea name="content_sendfail" id="content_sendfail" cols="50" rows="7"
                                                  class="textarea_form" onfocus="ChangeStyle('content_sendfail', 1);"
                                                  onblur="ChangeStyle('content_sendfail', 2);"><?php if (isset($content_sendfail)) {
                                                echo $content_sendfail;
                                            } ?>
                                        </textarea>
                                            <?php echo form_error('content_sendfail'); ?></td>
                                    </tr>
                                    <?php if (isset($imageCaptchaSendFriendProduct)) { ?>
                                        <tr>
                                            <td width="110"
                                                class="list_form"><?php echo $this->lang->line('captcha_main'); ?>:
                                            </td>
                                            <td align="left"><img
                                                    src="<?php echo $imageCaptchaSendFriendProduct; ?>"
                                                    width="151" height="30" alt=""/><br/>
                                                <input onKeyPress="return submitenter(this, event, 2)" type="text"
                                                       name="captcha_sendfail" id="captcha_sendfail" value=""
                                                       maxlength="10" class="inputcaptcha_form"
                                                       onfocus="ChangeStyle('captcha_sendfail', 1);"
                                                       onblur="ChangeStyle('captcha_sendfail', 2);"/>
                                                <?php echo form_error('captcha_sendfail'); ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td height="30"></td>
                                        <td height="30" valign="bottom" align="center">
                                            <table border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td><input type="button"
                                                               onclick="CheckInput_SendFail('<?php if (isset($isSendedOneFail) && $isSendedOneFail == true) {
                                                                   echo $this->lang->line('is_sended_one_message_detail');
                                                               } else {
                                                                   echo 1;
                                                               } ?>');" name="submit_sendfail"
                                                               value="<?php echo $this->lang->line('button_send_send_bad_detail'); ?>"
                                                               class="button_form"/>
                                                    </td>
                                                    <input type="hidden" value="" name="bao_cao_sai_gia"
                                                           id="bao_cao_sai_gia"/>
                                                    <input type="hidden" value="<?php echo $cacha; ?>"
                                                           name="capcha_sai_gia" id="capcha_sai_gia"/>
                                                    <td width="15"></td>
                                                    <td><input type="reset" name="reset_sendfail"
                                                               value="<?php echo $this->lang->line('button_reset_send_bad_detail'); ?>"
                                                               class="button_form"/></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                                
                            <?php } else { ?>
                                <div style="padding-top:10px;"> Bạn hãy <a href="<?php echo base_url() ?>login"> đăng
                                        nhập </a> để thực hiện chức năng này
                                </div>
                            <?php } ?>
                        </form>
                    </div>
					<div style="clear:both;"></div>
                    <div id="DivHetHangDetail" style="display: none;">
                        <?php if ($this->session->userdata('sessionUser') > 0) { ?>
                            <form name="frmSendFailHetHang" method="post">
                                <table class="sendfail_main" border="0" align="center" cellpadding="0" cellspacing="0"
                                       style="padding-left:20px;">
                                    <tr style="display:none">
                                        <td width="110"
                                            class="list_form"><?php echo $this->lang->line('email_sender_send_bad_detail'); ?>
                                            :
                                        </td>
                                        <td align="left"><input type="text" name="sender_sendfail_het_hang"
                                                                id="sender_sendfail_het_hang" value="" maxlength="50"
                                                                class="input_form"
                                                                onfocus="ChangeStyle('sender_sendfail', 1);"
                                                                onblur="ChangeStyle('sender_sendfail', 2);"/><?php echo form_error('sender_sendfail'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="110"
                                            class="list_form"><?php echo $this->lang->line('title_send_bad_detail'); ?>:
                                        </td>
                                        <td align="left"><input type="text" name="title_sendfail_het_hang"
                                                                id="title_sendfail_het_hang" value="" maxlength="80"
                                                                class="input_form"
                                                                onfocus="ChangeStyle('title_sendfail', 1);"
                                                                onblur="ChangeStyle('title_sendfail', 2);"/> <?php echo form_error('title_sendfail'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="110"
                                            class="list_form"><?php echo $this->lang->line('content_send_bad_detail'); ?>
                                            :
                                        </td>
                                        <td align="left">
                                        <textarea name="content_sendfail_het_hang" id="content_sendfail_het_hang"
                                                  cols="50" rows="7" class="textarea_form"
                                                  onfocus="ChangeStyle('content_sendfail', 1);"
                                                  onblur="ChangeStyle('content_sendfail', 2);"><?php if (isset($content_sendfail)) {
                                                echo $content_sendfail;
                                            } ?>
                                            </textarea>
                                            <?php echo form_error('content_sendfail'); ?></td>
                                    </tr>
                                    <?php if (isset($imageCaptchaSendFriendProduct)) { ?>
                                        <tr>
                                            <td width="110"
                                                class="list_form"><?php echo $this->lang->line('captcha_main'); ?>:
                                            </td>
                                            <td align="left"><img
                                                    src="<?php echo $imageCaptchaSendFriendProduct; ?>"
                                                    width="151" height="30" alt=""/><br/>
                                                <input onKeyPress="return submitenter(this, event, 3)" type="text"
                                                       name="captcha_sendfail_het_hang" id="captcha_sendfail_het_hang"
                                                       maxlength="10" class="inputcaptcha_form"
                                                       onfocus="ChangeStyle('captcha_sendfail', 1);"
                                                       onblur="ChangeStyle('captcha_sendfail', 2);"/>
                                                <?php echo form_error('captcha_sendfail'); ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td height="30"></td>
                                        <td height="30" valign="bottom" align="center">
                                            <table border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td><input type="hidden" name="bao_cao_het_hang"
                                                               id="bao_cao_het_hang"/>
                                                        <input type="hidden" value="<?php echo $cacha; ?>"
                                                               name="capcha_het_hang" id="capcha_het_hang"/>
                                                        <input type="button" onclick="CheckInput_SendHetHang();"
                                                               name="submit_sendfail"
                                                               value="<?php echo $this->lang->line('button_send_send_bad_detail'); ?>"
                                                               class="button_form"/></td>
                                                    <td width="15"></td>
                                                    <td><input type="reset" name="reset_sendfail"
                                                               value="<?php echo $this->lang->line('button_reset_send_bad_detail'); ?>"
                                                               class="button_form"/></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        <?php } else { ?>
                            <div> Bạn hãy <a
                                    href="<?php echo base_url() ?>login"> đăng nhập </a> để thực hiện chức năng này
                            </div>
                        <?php } ?>
                    </div>
					
                    <?php /*if (isset($isViewComment) && $isViewComment == true) { ?>
                        <script type="text/javascript">OpenTab(3);</script>
                    <?php } else { ?>
                        <script type="text/javascript">OpenTab(1);</script>
                    <?php } ?>
					
                    <?php if ((isset($isReply) && $isReply == true) || (isset($successReplyProduct) && $successReplyProduct == true)) { ?>
                        <script>OpenTab(3);</script>
                    <?php } elseif (isset($isSendFriend) && $isSendFriend == true) { ?>
                        <script>OpenTab(4);</script>
                    <?php } elseif (isset($isSendFail) && $isSendFail == true) { ?>
                        <script>OpenTab(5);</script>
                    <?php } */?>
					
                </div>
            </div>

            <!-- Begin:: Sản phẩm cùng danh mục -->
            <?php if (count($categoryProduct) > 0) { ?>                
                <div class="row productscarousel">
                    <div class="col-sm-12 col-xs-12">
                        <h2><span class="borderbottom"><?php echo $this->lang->line('title_relate_category_product_detail'); ?></span></h2>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div id="productsincategory" class="owl-carousel owl-theme">
                        <?php
                        $idDiv = 1;
                        foreach ($categoryProduct as $product) {
                            $afSelect = false;
                            $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                            ?>                    
                            <div class="showbox_1q_detail"
                                 id="DivReliableProductBoxNew_<?php echo $idDiv; ?>"
                                 style="margin:10px 0;">
                                <?php $this->load->view('shop/product/shop_item', array('product' => $product, 'discount' => $discount)); ?>
                            </div>
                            <?php $idDiv++; ?>
                        <?php } ?>
                        </div>
                    </div>                    
                </div>
            <?php } ?>
            <!-- End:: Sản phẩm cùng danh mục -->
            
            <!-- Begin:: Sản phẩm cùng gian hàng -->
            <?php if (count($userProduct) > 0) { ?>
               
                <div class="row productscarousel">
                    <div class="col-sm-12 col-xs-12">
                        <h2><span class="borderbottom"><?php echo $this->lang->line('title_relate_shop_product_detail'); ?></span></h2>
                    </div>
                    <div class="col-sm-12 col-xs-12">
                        <div id="productsinshop" class="owl-carousel owl-theme">
                        <?php $idDiv = 1; ?>
                        <?php
                        foreach ($userProduct as $product) {
                            $afSelect = false;
                            $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                            ?>
                            <div class="showbox_1q_detail"
                                 id="DivReliableProductBoxNew_<?php echo $idDiv; ?>"
                                 style="margin:10px 0;">
                                <?php $this->load->view('shop/product/shop_item', array('product' => $product, 'discount' => $discount)); ?>
                            </div>
                            <?php $idDiv++; ?>
                        <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- End:: Sản phẩm cùng gian hàng -->
        </div>



        <?php if (isset($successFavoriteProduct) && $successFavoriteProduct == true) { ?>
            <script>alert('<?php echo $this->lang->line('success_add_favorite_detail'); ?>');</script>
        <?php } elseif (isset($successVote) && $successVote == true) { ?>
            <script>alert('<?php echo $this->lang->line('success_vote_detail'); ?>');</script>
        <?php } elseif (isset($successReplyProduct) && $successReplyProduct == true) { ?>
            <script>alert('<?php echo $this->lang->line('success_add_reply_detail'); ?>');</script>
        <?php } elseif (isset($successSendFriendProduct) && $successSendFriendProduct == true) { ?>
            <script>alert('<?php echo $this->lang->line('success_send_friend_detail'); ?>');</script>
        <?php } elseif (isset($successSendFailProduct) && $successSendFailProduct == true) { ?>
            <script>alert('<?php echo $this->lang->line('success_send_fail_detail'); ?>');</script>
        <?php } ?>
    </div>
</div>

<textarea style="height:1px; visibility:hidden;"
          class="js-copytextarea"><?php echo 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
    ?share=<?php echo $currentUser->af_key; ?></textarea>

<!-- end container-fluid -->
<!-- END CENTER-->

<!-- GUI BAO CAO SAN PHAM -->

<?php if($this->session->userdata('sessionUser') > 0) { ?>
<div class="modal fade" id="reportdetailModal" tabindex="-1" role="dialog" aria-labelledby="reportdetailModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="frmReport" name="frmReport" action="/home/product/report" method="post" class="form" enctype="multipart/form-data">
            <input type="hidden" name="sho_name" id="" value="<?php echo $shop->sho_name; ?>">
            <input type="hidden" name="sho_link" id="" value="<?php echo $my_link_shop; ?>">
            <input type="hidden" name="pro_link" id="" value="<?php echo $pro_link ?>">
            <input type="hidden" name="pro_name" id="" value="<?php echo $product_report->pro_name ?>">
            <input id="reportpost" name="pro_id" type="hidden" value="<?php echo $product_report->pro_id ?>">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="reportModalLabel">Gửi báo cáo sản phẩm này</h4>
            </div>
            <div class="modal-body">
                <?php foreach ($listreports as $key => $value) { ?>
                        <div class="radio">
                          <label>
                                <input type="radio" name="rp_id" id="rpid_<?php echo $value->rp_id ?>" value="<?php echo $value->rp_id ?>" <?php echo $key == 0 ? 'checked': '' ?> >
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
            console.log(data);
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

<?php $this->load->view('home/common/footer'); ?>

<?php
if ($shop->sho_phone) {
    $phonenumber = $shop->sho_phone;
} elseif ($shop->sho_mobile) {
    $phonenumber = $shop->sho_mobile;
}
if ($phonenumber) {
    ?>
    <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="asdphonering-alo-phoneIcon">
        <div class="phonering-alo-ph-circle"></div>
        <div class="phonering-alo-ph-circle-fill"></div>
        <div class="phonering-alo-ph-img-circle">
            <a href="tel:<?php echo $shop->sho_mobile; ?>">
                <img data-toggle="modal" data-target=".bs-example-modal-md" src="https://i.imgur.com/v8TniL3.png"
                     alt="Liên hệ" width="50" onmouseover="this.src = 'https://i.imgur.com/v8TniL3.png';"
                     onmouseout="this.src = 'https://i.imgur.com/v8TniL3.png';">
            </a>
        </div>
    </div>
<?php } ?>

<script>    

	$('#productsincategory, #productsinshop').owlCarousel({
        loop: false, nav: false, responsiveClass:true, responsive:{ 0:{ items:2, margin: 10 }, 600:{ items:3, margin: 20 }, 1000:{ items:4, margin: 20 } }
    });
    function submitenter(myfield, e, enterForm) {
        var keycode;
        if (window.event) {
            keycode = window.event.keyCode;
        } else if (e) {
            keycode = e.which;
        } else {
            return true;
        }

        if (keycode == 13) {
            if (enterForm == 1) {
                CheckInput_SendLink();
            }

            if (enterForm == 2) {
                CheckInput_SendFail('<?php
                    if (isset($isSendedOneFail) && $isSendedOneFail == true) {
                        echo $this->lang->line('is_sended_one_message_detail');
                    } else {
                        echo 1;
                    }
                    ?>');
            }

            if (enterForm == 3) {
                CheckInput_SendHetHang();
            }

            return false;
        } else {
            return true;
        }
    }

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
            $('.wishlist_detail').attr('disabled', 'disabled');
            $('.note').css('display', 'block');
        }
        else {
            $('#mausac_1').click();
            $('#kichthuoc_1').addClass('actived');
            $('#chatlieu_1').addClass('actived');
        }
        $('#_selected_color').val($('#mausac_1').text());
		
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
    });

    function SelectProSales(siteUrl, id) {
        jQuery.ajax({
            type: "POST",
            url: siteUrl + "home/affiliate/ajax_select_pro_sales",
            dataType: 'json',
            data: {proid: id},
            success: function (data) {
                //console.log(data);
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
                        $("#qty_" + pro_id).val(<?php echo $pty_min; ?>);
                        sl_color = name;
                        $("#_selected_size").val("");
                        $("#_selected_material").val("");
                        if (result.pro_prices == null) {
                            $(".qty_row").addClass('hidden');
                            //$("#bt_" + pro_id).addClass('hidden');
                            $("#bt_hethang_" + pro_id).removeClass('hidden');
                        } else {
                            var money = parseInt(result.pro_prices);
                            var money_save = money - parseInt(result.off_amount);
                            var money_save_af = money_save - parseInt(result.af_off);
                            money = money.toLocaleString();
                            money_save = money_save.toLocaleString();
                            money_save_af = money_save_af.toLocaleString();
                            $("#show-cost").text(money + ' vnđ');
                            $("#cost-save").text(money_save + ' vnđ');
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
                            $('.wishlist_detail').removeAttr('disabled');
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
                success: function (result) {console.log(result);
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
                            $("#bt_hethang_" + pro_id).removeClass('hidden');
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
                                $("#cost-save").text(money_save + ' vnđ');
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
        $('.st_size_value').html(b);
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
                            $("#bt_hethang_" + pro_id).removeClass('hidden');
                        } else {
                            var money = parseInt(result.pro_prices);
                            var money_save = money - parseInt(result.off_amount);
                            var money_save_af = money_save - parseInt(result.af_off);
                            money = money.toLocaleString();
                            money_save = money_save.toLocaleString();
                            money_save_af = money_save_af.toLocaleString();
                            $("#show-cost").text(money + ' vnđ');
                            $("#cost-save").text(money_save + ' vnđ');
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
                $('#carousel-ligghtgallery').owlCarousel({
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
            $('#carousel-ligghtgallery').on('changed.owl.carousel', function (event) {
                var index = event.item.index;
                if (index == null) {
                    $("#show-cost").text(arr_price + ' vnđ');
                } else {
                    var money = parseInt(arr_price[index]);
                    var money_save = money - parseInt(arr_affamount[index]);
                    var money_save_af = money_save - parseInt(arr_afoff[index]);
                    money = money.toLocaleString();
                    money_save = money_save.toLocaleString();
                    money_save_af = money_save_af.toLocaleString();
                    $("#show-cost").text(money + ' vnđ');
                    $("#cost-save").text(money_save + ' vnđ');
                    $("#cost-save-af").text(money_save_af + ' vnđ');
                    $("#qty_max").val(arr_max[index]);
                    $("#dp_id").val(id[index]);
                }
            });
        }
    }
</script>

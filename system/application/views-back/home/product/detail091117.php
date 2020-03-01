<?php $this->load->view('home/common/header'); 
    $group_id = (int) $this->session->userdata('sessionGroup');
    if(isset($_REQUEST['af_id']) && !empty($_REQUEST['af_id'])){
        $this->session->set_userdata('af_id', $_REQUEST['af_id']);
    }
    echo "<pre>";
    print_r($ar_color);
    print_r($ar_size);
    print_r($ar_material);

    if(isset($ar_color) && empty($ar_color)){echo 'Tồn tại màu sắc';}
    echo "</pre>";   
?>
<!-- START CENTER-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 hidden-md hidden-sm hidden-xs"
             style="">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-10">
        
            <ol id="breadcrumb" class="breadcrumb" style="white-space: nowrap; overflow: auto;">
                <li><a href="/shop" class="home">Mua sắm</a></li>
                <?php if ($siteGlobal->cat_id != "") { ?>
                <li>
                    <a rel="v:url" property="v:title" href="<?php echo base_url() ?><?php echo $siteGlobal->cat_id; ?>/<?php echo RemoveSign($siteGlobal->cat_name); ?>" title="<?php echo $siteGlobal->cat_name; ?>"><?php echo $siteGlobal->cat_name ?></a>
                </li>
                <?php } ?>
            </ol>
            
            <div class="row">                
                <div class="col-xs-12">
                <?php
                    $mainURL = $protocol.$domainName.'/';
                    $my_link_news = $protocol.$shop->sho_link.'.'.$domainName;
                    $my_link_shop = $my_link_news.'/shop';
                    if($shop->domain != ''){
                        $my_link_news = $protocol.$shop->domain;
                        $my_link_shop = $my_link_news.'/shop';
                    }
                    
                    $shoplogo ="/images/logo-home.png";
                    if ($shop->sho_logo){
                        $shoplogo = '/media/shop/logos/' . $shop->sho_dir_logo . '/' . $shop->sho_logo;
                    }
                ?>
                    <table>
                        <tr>
                            <td width="50">
                                <a class="sho_logo_small img-circle" href="<?php echo $my_link_news; ?>">
                                    <img width="40" src="<?php echo $shoplogo ?>" />
                                </a>
                            </td>
                            <td>
                               <strong><a href="<?php echo $my_link_shop; ?>"><?php echo $shop->sho_name; ?></a></strong> 
                            </td>
                        </tr>
                    </table>
               </div>                
            </div>
            
            <div style="clear:both">&nbsp;</div>
            <div class="navigate" style="display: none">
                <div class="bgrumQ">
                    <div class="bgrumQHome" id="sub_cateory_bgrum">
                        <a href="<?php echo base_url() ?>" class="home">Azibai</a> <i class="fa fa-caret-right"></i>
                        <div class="sub_cateory_bgrum">
                            <?php echo $sanpham_sub_rum; ?>
                        </div>
                    </div>
                    <?php if (isset($CategorysiteGlobalRoot->cat_id)) { ?>
                        <div id="CategorysiteGlobalRoot">
                            <a href="<?php echo base_url() ?><?php echo $CategorysiteGlobalRoot->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobalRoot->cat_name); ?>"><?php echo mb_substr($CategorysiteGlobalRoot->cat_name, 0, 30, 'UTF-8'); ?></a>
                            <?php if ($CategorysiteRootConten != "") { ?>
                                <img alt="" src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>
                            <?php } else { ?>
                                <img src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif"
                                     alt=""/>
                            <?php } ?>
                            <?php if (isset($CategorysiteRootConten)) { ?>
                                <div class="CategorysiterootConten">
                                    <?php echo $CategorysiteRootConten; ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if (isset($CategorysiteGlobal->cat_id)) { ?>
                        <div id="CategorysiteGlobal">
                            <a href="<?php echo base_url() ?><?php echo $CategorysiteGlobal->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobal->cat_name); ?>"><?php echo mb_substr($CategorysiteGlobal->cat_name, 0, 30, 'UTF-8'); ?></a>
                            <?php if ($CategorysiteGlobalConten != "") { ?>
                                <i class="fa fa-caret-right"></i>
                            <?php } else { ?>
                                <i class="fa fa-caret-right"></i>
                            <?php } ?>
                            <?php if (isset($CategorysiteGlobalConten)) { ?>
                                <div class="CategorysiteGlobalConten">
                                    <?php echo $CategorysiteGlobalConten; ?>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if ($siteGlobal->cat_id != "")  ?>
                    <?php { ?>
                        <span><?php echo $siteGlobal->cat_name; ?></span>
                    <?php } ?>

                </div>
            </div>

            <div style="display:none;">
                <div xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumbs-title">
                    <span typeof="v:Breadcrumb">
                        <a rel="v:url" property="v:title" href="<?php echo base_url() ?>" class="home">Home</a>
                    </span>
                    <span class="separator">»</span>
                    <?php if (isset($CategorysiteGlobalRoot->cat_id)) { ?>
                        <span typeof="v:Breadcrumb">
                            <a rel="v:url" property="v:title"
                               href="<?php echo base_url() ?><?php echo $CategorysiteGlobalRoot->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobalRoot->cat_name); ?>"
                               title="<?php echo $CategorysiteGlobalRoot->cat_name; ?>"><?php echo mb_substr($CategorysiteGlobalRoot->cat_name, 0, 30, 'UTF-8'); ?></a> <span
                               class="separator">»</span>
                        </span>
                    <?php } ?>
                    <?php if (isset($CategorysiteGlobal->cat_id)) { ?><span typeof="v:Breadcrumb">
                            <a rel="v:url" property="v:title"
                               href="<?php echo base_url() ?><?php echo $CategorysiteGlobal->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobal->cat_name); ?>"
                               title="<?php echo $CategorysiteGlobal->cat_name; ?>"><?php echo mb_substr($CategorysiteGlobal->cat_name, 0, 30, 'UTF-8'); ?></a> <span
                               class="separator">»</span>
                        </span>
                    <?php } ?>
                    <?php if ($siteGlobal->cat_id != "") { ?>
                        <?php echo $siteGlobal->cat_name; ?>
                    <?php } ?>
                </div>
            </div>
            
            <div xmlns:v="http://rdf.data-vocabulary.org/#" typeof="v:Review-aggregate" style="display:none;">
                <span property="v:itemreviewed"><?php echo $product->pro_name; ?></span> <span rel="v:rating"> <span typeof="v:Rating"> <span property="v:average"><?php echo $product->pro_vote_total; ?></span>/ <span
                            property="v:best">10</span> </span> </span> <span
                    property="v:count"><?php echo $product->pro_vote; ?></span>
                <h2 class="updated"><?php echo $product->up_date; ?></h2>
                <span class="vcard author"> <span class="fn"><?php echo $user_product; ?></span> </span>
            </div>

            <div style="display:none;" itemscope itemtype="http://data-vocabulary.org/Product">
                <span itemprop="offerDetails" itemscope itemtype="http://data-vocabulary.org/Offer"> Giá bán:
                    <p class="currency" content="VND"/>
                    <span itemprophp echo number_format($product->pro_cost, 0, ',', ','); ?>
                          VND
                        <meta itemprop="price">
                        <?php
                        if ($product->pro_type_saleoff == 1)
                            echo number_format($product->pro_cost - (($product->pro_cost * $product->pro_saleoff_value) / 100), 0, ',', ',');
                        else
                            echo number_format($product->pro_cost - $product->pro_saleoff_value, 0, ',', ',');
                        ?>
                    </span> VND </span>
            </div>

            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-5">                   
                    
                    <?php $listimages = explode(',', $product->pro_image); ?>
                    <?php if ($product->pro_show == 0) {                        
                        $img = 'media/images/product/' . $product->pro_dir . '/' . show_image($product->pro_image);
                        ?>
                        <style> 
                            #carousel-ligghtgallery { margin-bottom: 20px; text-align:  center}
                            .owl-carousel .owl-item img { width: auto !important;}
                            .style-group { 
                                display: inline-block; padding: 5px 15px; border: 1px solid #ddd; border-radius: 0px; cursor: pointer; width: 80px; text-align: center; background: #fff;
                            }
                            span.w150 { display: inline-block; width: 100px;}
                            .actived {
                                background: #e5e5e5; color: #000; border: 1px solid #d1d1d1; 
                            }
                            .row-hidden {display: none;}
                            .hoahongAf {border: 1px solid #d9534f; overflow: hidden; position: relative; margin-bottom: 20px;
                            }
                            .TenHH {float: left; padding: 10px;width: 66%; }
                            .phantranHH { padding: 10px; text-align: center;border-left: 1px solid #d9534f; box-sizing: border-box; background: #d9534f; width: 34%; float: left; color: #fff; font-size: 15px; position: absolute; right: 0;bottom: 0; top: 0;
                            }                            
                        </style>
                        <link href="/templates/home/lightgallery/dist/css/lightgallery.css" rel="stylesheet" type="text/css" />
                        <!-- Owl Stylesheets -->
                        <link href="/templates/home/owlcarousel/owl.carousel.min.css" rel="stylesheet" type="text/css"/>
                        <link href="/templates/home/owlcarousel/owl.theme.default.min.css" rel="stylesheet" type="text/css"/>   
                        <div id="carousel-ligghtgallery" class="owl-carousel owl-theme">                              
                            <?php
                            foreach ($listimages as $k => $image):
                                $imgsrc = 'media/images/product/' . $product->pro_dir . '/' . $image;
                                ?>        
                                <div class="fix1by1 item <?php echo $k == 0 ? 'active' : '' ?>">
                                    <?php if (file_exists($imgsrc) && $image != '') { ?>
                                        <a class="c image" href="<?php echo base_url() . $imgsrc ?>">
                                            <img src="<?php echo base_url() . $imgsrc ?>" alt="...">
                                        </a>
                                    <?php } else { ?>
                                        <a class="c image" href="<?php echo base_url() . 'images/noimage.jpg' ?>">
                                            <img src="<?php echo base_url() . 'images/noimage.jpg' ?>" alt="...">
                                        </a>
                                <?php } ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <script src="/templates/home/lightgallery/dist/js/lightgallery.js"></script>
                        <script src="/templates/home/js/owl.carousel.js"></script>
                        <script language="javascript">
                            jQuery(function ($) {
                                $('#carousel-ligghtgallery').lightGallery({selector: '.image', download: false});
                                $('.owl-carousel').owlCarousel({
                                    loop:false, margin:0, nav:false, items:1
                                })
                            });
                        </script>                        
                    <?php } else { ?>                    
                        <?php $imageDetail = explode(',', $product->pro_image); ?>
                        <div class="large-img">
                            <a class="slideshow" href="<?php echo base_url(); ?>media/images/product/<?php echo $product->pro_dir; ?>/<?php echo $imageDetail[0]; ?>">
                                <img class="img-responsive" src="<?php echo base_url(); ?>media/images/product/<?php echo $product->pro_dir; ?>/<?php echo $imageDetail[0]; ?>"
                                     alt=""/>
                            </a>
                        </div>
                        <ul class="list-img">
                            <?php foreach ($imageDetail as $key => $imageDetailArray) { ?>
                                <?php if ($imageDetailArray != "") { ?>
                                    <li class="<?php if ($key == 0) { echo 'current'; } ?>">
                                        <a class="slideshow" href="<?php echo base_url(); ?>media/images/product/<?php echo $product->pro_dir; ?>/<?php echo $imageDetailArray; ?>">
                                            <img src="<?php echo base_url(); ?>media/images/product/<?php echo $product->pro_dir; ?>/<?php echo $imageDetailArray; ?>"/>
                                        </a>
                                    </li>
                            <?php } ?>
                        <?php } ?>
                        </ul>
                        <script language="javascript"
                        src="<?php echo base_url(); ?>templates/home/js/colorbox.js"></script>
                        <link type="text/css" href="<?php echo base_url(); ?>templates/home/css/colorbox.css" rel="stylesheet">
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
                    function url_origin( $s, $use_forwarded_host = false )
                    {
                        $ssl      = ( ! empty( $s['HTTPS'] ) && $s['HTTPS'] == 'on' );
                        $sp       = strtolower( $s['SERVER_PROTOCOL'] );
                        $protocol = substr( $sp, 0, strpos( $sp, '/' ) ) . ( ( $ssl ) ? 's' : '' );
                        $port     = $s['SERVER_PORT'];
                        $port     = ( ( ! $ssl && $port=='80' ) || ( $ssl && $port=='443' ) ) ? '' : ':'.$port;
                        $host     = ( $use_forwarded_host && isset( $s['HTTP_X_FORWARDED_HOST'] ) ) ? $s['HTTP_X_FORWARDED_HOST'] : ( isset( $s['HTTP_HOST'] ) ? $s['HTTP_HOST'] : null );
                        $host     = isset( $host ) ? $host : $s['SERVER_NAME'] . $port;
                        return $protocol . '://' . $host;
                    }

                    function full_url( $s, $use_forwarded_host = false )
                    {
                        return url_origin( $s, $use_forwarded_host ) . $s['REQUEST_URI'];
                    }

                    $absolute_url = full_url( $_SERVER );
                    //echo $absolute_url;

                    ?> 
                    <p class="text-center">Chia sẻ sản phẩm này:</p>
                    <div class="btn-group btn-group-justified" style="margin-bottom:20px;">
                        <div class="btn-group" role="group"><a data-original-title="Share at Facebook" href="http://www.facebook.com/sharer.php?u=<?php echo $absolute_url; ?>" class="btn btn-default"> <span class="fa fa-facebook"></span></a></div>
                        <div class="btn-group" role="group"><a data-original-title="Share at Tweet" href="http://twitter.com/home?status=<?php echo $absolute_url; ?>" class="btn btn-default"><span class="fa fa-twitter"></span></a></div>
                        <div class="btn-group" role="group"><a data-original-title="Share at Google+" href="http://plus.google.com/share?url=<?php echo $absolute_url; ?>" class="btn btn-default"> <span class="fa fa-google-plus"></span></a></div>
                        <div class="btn-group" role="group"><a data-original-title="Share at LinkedIn" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $absolute_url; ?>" class="btn btn-default"> <span class="fa fa-linkedin"></span></a></div>
                        <div class="btn-group" role="group"><a data-original-title="Share via Email" href="mailto:?subject=<?php echo $product->pro_name; ?>&amp;body=<?php echo $absolute_url; ?>" class="btn btn-default"> <span class="fa fa-envelope-o"></span></a></div>
                    </div>                    
                </div>
                   
                <div class="col-lg-7 col-md-7 col-sm-7">
                    <div class="cost_detail_value">                        
                        <h2><?php echo $product->pro_name; ?></h2>                        
                        <div class="view_buy">
                            <a title="Lượt mua" href="#">
                                <i class="fa fa-shopping-bag" aria-hidden="true"></i> <?php echo $product->pro_buy; ?></a> &nbsp;&nbsp;&nbsp;
                            <a title="Lượt xem" href="#"><i class="fa fa-eye"></i> <?php echo $product->pro_view; ?></a>
                        </div>	

                        <div class="cost_detail_box">
                            <div class="product-price">
                                <dl class="dl-horizontal">
                                    <?php
                                    // Added
                                    // by le van son
                                    // Calculation discount amount				    
				    
				                    $afSelect = false;
                                    if ($_REQUEST['af_id'] != '' && $product->is_product_affiliate == 1) {
                                        $this->load->model('user_model');
                                        $userObject = $this->user_model->get("use_id", "af_key = '" . $_REQUEST['af_id'] . "'");
                                        if ($userObject->use_id > 0) {
                                            $afSelect = true;
                                        }
                                    }

                                    $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                                    ?>
                                    <dt><?php echo $this->lang->line('cost_detail'); ?>:</dt>
                                    <dd>
                                        <?php if ((int) $product->pro_cost == 0) { ?>
                                        <?php echo $this->lang->line('call_main'); ?>
                                        <?php } else { ?>
                                            <span class="sale-price root detail <?php echo ($product->off_amount > 0 || $discount['em_off'] > 0 || $discount['af_off'] > 0) ? 'old-price' : ''; ?>" id="show-cost"><?php echo number_format($product->pro_cost, 0, ",", ".");  ?> đ</span> <br>                            
                                        <?php } ?>

                                <?php if ($product->off_amount > 0 && $discount['em_off'] <= 0 && $_REQUEST['af_id'] == '') { ?>
                                    </dd>
                                    <dt> Giá Khuyến mãi:</dt>
                                    <dd>
                                        <span class="sale-price detail" id="cost-save"><?php echo number_format($discount['off_sale'], 0, ",", "."); ?> đ</span>
                                        <span class="label label-success" style="padding: 5px ;font-size: 14px ">Tiết kiệm: <span><?php echo ($product->off_rate > 0) ? $product->off_rate . '%' : number_format($product->off_amount) . ' đ'; ?></span></span><?php } ?>
                                    </dd>

                                <?php if ($discount['af_off'] > 0 && $discount['em_off'] <= 0): ?>
                                    <dt>
                                            Giá Khuyến mãi:
                                    </dt>
                                    <dd><span class="sale-price detail"><?php echo number_format($discount['af_sale'], 0, ",", "."); ?>
                                                đ</span>
                                            <!--<span>Tiết kiệm: <?php echo ($product->af_rate > 0) ? $product->af_rate . '%' : number_format($discount['af_off']) . ' đ'; ?></span>-->
                                    </dd>
                                <?php endif; ?>

                                <?php if ($discount['em_off'] > 0): ?>
                                        <dt>
                                            Giảm giá sỉ:
                                        </dt>
                                        <dd><span class="sale-price detail"><?php echo number_format($discount['em_sale'], 0, ",", "."); ?>
                                                đ</span>
                                        </dd>

                                <?php endif; ?>
                            <?php if ($promotions): ?>
                                        <dt>
                                            Giảm giá sỉ:
                                        </dt>
                                        <dd>
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

                                        </dd>
                                    <?php endif; ?>                                

                                    <dd>
                                        <!--<a href="#" onclick="jQuery('.address_table').css('display','block');" class=""><i class="fa fa-map-marker"></i> Xem địa chỉ mua hàng </a>-->
                                <?php if ($shop->sho_guarantee == "1") { ?>
                                            <div id="k_messagecontent" style="display:none"><?php echo(html_entity_decode($shoptypeMessage[0]->not_detail)); ?></div>
                                            <div class="dam_bao"><a class="" href="<?php echo base_url(); ?>content/20"><img onmouseover="tooltipShopType(this)" src="<?php echo base_url(); ?>templates/home/images/icon_dambao.gif" width="80" height="80" alt="Lợi ích khi mua hàng tại gian hàng đảo bảo" title="Lợi ích khi mua hàng tại gian hàng đảo bảo"/></a></div>
                                <?php } ?>
                                        <div class="address_table" style="display: block; position: absolute; display:none; background:#eee; padding:15px 15px 0;">
                                            <dl class="dl-horizontal">
                                                <dt>
                                                    <?php if ($placeSaleIsShop == true) { ?>
                                                        <a class="menu_1" href="<?php echo base_url(); ?><?php echo $shop->sho_link; ?>" target="_blank" title="<?php echo $shop->sho_descr; ?>"><?php echo $shop->sho_name; ?></a>
                                                    <?php } elseif (count($province) == 1) {
                                                           echo $province->pre_name;
                                                    } ?>
                                                </dt>
                                                <dd><a class="pull-right" onclick="jQuery('.address_table').css('display', 'none');" href="javascript:;" title="Đóng">
                                                    <img src="<?php echo base_url(); ?>templates/home/images/icon_remove_small.gif"></a>
                                                </dd>
                                                <dt>Địa chỉ:</dt>
                                                <dd><?php echo $product->pro_address; ?></dd>
                                                <dt>Điện thoại:</dt>
                                                <dd><?php echo $product->pro_phone; ?>
                                                    <?php
                                                    if (trim($product->pro_phone) != '' && trim($product->pro_mobile) != '') {
                                                        echo ' - ';
                                                    }
                                                    ?>
                                                    <?php echo $product->pro_mobile; ?></dd>
                                            </dl>
                                        </div>
                                    </dd>
                                </dl>

                                <?php if (strtoupper($product->pro_currency) == 'VND') { ?>           <!--(<span id="DivCostExchange"></span>&nbsp;<?php echo $this->lang->line('usd_main'); ?>)                                                                           <script type="text/javascript">FormatCost('<?php echo round((int) $product->pro_cost / settingExchange); ?>', 'DivCostExchange');</script>-->
                            <?php } else { ?>
                                    (<span
                                        id="DivCostExchange"></span>&nbsp;<?php echo $this->lang->line('vnd_main'); ?>)
                                    <script
                                    type="text/javascript">FormatCost('<?php echo round((int) $product->pro_cost * settingExchange); ?>', 'DivCostExchange');</script>
                                    <?php } ?>
                                    <?php if ((int) $product->pro_hondle == 1 || (int) $product->pro_saleoff == 1) { ?>
                                    <div id="nego_detail">
                                             <?php if ((int) $product->pro_hondle == 1) { ?>
                                            <img src="<?php echo base_url(); ?>templates/home/images/hondle.gif"
                                                 border="0" alt=""/>&nbsp;&nbsp;&nbsp;
                                    <?php } ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="left_detail_botom">
                            <table class="table-custom" width="100%">
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
                                        <td  class="title_detail_tb"><?php echo $this->lang->line('pro_made_from'); ?></td>
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
                                
                                <?php if ($shop->sho_link): ?>
                                    <tr>
                                        <td class="title_detail_tb">Gian hàng</td>
                                        <td>
                                            <a class="shoplink" href="<?php echo $my_link_shop;  ?>">
                                            <?php echo $shop->sho_name; ?></a>
                                        </td>
                                    </tr>
                                <?php endif; ?>

                                <?php if ($siteGlobal->cat_id != "") { ?>
                                    <tr>
                                        <td class="title_detail_tb">Danh mục</td>
                                        <td>
                                            <a class="shoplink" href="<?php echo base_url() ?><?php echo $siteGlobal->cat_id; ?>/<?php echo RemoveSign($siteGlobal->cat_name); ?>" title="<?php echo $siteGlobal->cat_name; ?>"><?php echo mb_substr($siteGlobal->cat_name, 0, 30, 'UTF-8'); ?></a>
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
                                                <a href="#" class="youtube-play" data-toggle="modal" data-target="#youtubeModal"><i class="fa fa-youtube-play"></i> Video về sản phẩm </a>
                                                <!-- Modal -->
                                                <div class="modal fade" id="youtubeModal" tabindex="-1" role="dialog" aria-labelledby="youtubeModalLabel">
                                                    <div class="modal-dialog modal-lg" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <div class="video">
                                                                    <?php
                                                                    $provideo = explode("=", $product->pro_video);
                                                                    ?>
                                                                    <iframe width="800" height="450" src="https://www.youtube.com/embed/<?php echo $provideo ? $provideo[1] : 'zlsQF_ufUNU' ?>" frameborder="0" allowfullscreen></iframe>
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
                                        <td class="title_detail_tb"><?php echo $this->lang->line('vote_detail'); ?>:</td>
                                        <td>
                                            <?php for ($vote = 0; $vote < (int) $product->pro_vote_total; $vote++) { ?>
                                                <img src="<?php echo base_url(); ?>templates/home/images/star1.gif" border="0" alt=""/>
                                            <?php } ?>
                                                 <?php for ($vote = 0; $vote < 10 - (int) $product->pro_vote_total; $vote++) { ?>
                                                <img src="<?php echo base_url(); ?>templates/home/images/star0.gif" border="0" alt=""/>
                                            <?php } ?>
                                            <b>[<?php echo $product->pro_vote; ?>]</b>
                                        </td>

                                    </tr>
                                <?php endif; ?>
                                    
                                <?php if($group_id == 2) {
                                    if ($product->is_product_affiliate == 1) {
                                        if ($product->af_amt > 0) {
                                            $pro_affiliate_value = $product->af_amt.' VNĐ';
                                            $pro_type_affiliate = 2;
                                        } else {
                                            $pro_affiliate_value = $product->aff_rate.' %';
                                            $pro_type_affiliate = 1;
                                        }
                                    } else {
                                        $pro_affiliate_value = '0 VNĐ';
                                    } ?>
                                    <?php if($product->is_product_affiliate == 1) { ?>
                                    <tr>
                                        
                                        <td colspan="2"> 
                                            <div class="hoahongAf">
                                                <div class="TenHH">Hoa hồng Cộng tác viên được hưởng</div>
                                                <div class="phantranHH"><?php echo $pro_affiliate_value; ?></div>
                                            </div>
                                            <?php if($selected_sale != true) { ?> 
                                                <button  class="btn btn-default" onclick="SelectProSales('<?php echo base_url() ?>',<?php echo $product->pro_id; ?>);"><i class="fa fa-check fa-fw"></i> Chọn bán</button>
                                            <?php } else { ?>
                                                <button class="btn btn-default" ><i class="fa fa-check fa-fw"></i> Đã chọn bán</button>
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
                                <?php if (isset($ar_color) && !empty($ar_color)) { ?>
                                    Màu sắc:
                                    <div class="row ar_color">
                                        <div class="col-xs-12">                 
                                            <?php
                                            $t1 = 0;
                                            foreach ($ar_color as $k1 => $v1) {
                                                $t1++;
                                                if ($k1 == 0) { $sel_color = $v1; }
                                            ?>                      
                                                <div class="pull-left" style="margin:5px">
                                                    <button  id="mausac_<?php echo $t1; ?>" class="style-group " onclick="ClickColor('<?php echo $v1; ?>','<?php echo $t1; ?>');"><?php echo $v1; ?></button>                                           
                                                    <!--<span class="style-group "  onclick="SeletColorStyle('<?php echo $v1; ?>','<?php echo $t1; ?>');"><?php echo $v1; ?></span>-->
                                                    <input type="hidden" id="<?php echo 'st_color_' . $v1; ?>" name="<?php echo 'st_color_' . $v1; ?>" value="<?php echo $v1; ?>">
                                                </div>
                                            <?php } ?>
                                            <input type="hidden" name="_selected_color" id="_selected_color" />
                                        </div>
                                    </div>
                                    <span class="hidden" id="prompt_select_color">Bạn phải chọn màu sắc.</span>
                                <?php } ?>

                                <?php if (isset($ar_size) && !empty($ar_size) && $ar_size[0] != '') { ?>
                                    <div class="row ar_size ">
                                        <div class="col-xs-12">
                                            <div class="dropdown">
                                                <a id="dLabel" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                    Chọn kích thước <span class="caret"></span> &nbsp;
                                                    <span class="st_size_value"></span>
                                                    <span class="hidden qcalert" id="prompt_select_size">Bạn phải chọn kích thước.</span>
                                                </a>
                                                <ul class="dropdown-menu list-inline" aria-labelledby="dLabel" >                      
                                                    <?php
                                                    $t2 = 0;
                                                    foreach ($ar_size as $k2 => $v2) {
                                                        $t2++;
                                                        if ($k2 == 0) { $sel_size = $v2; }
                                                    ?>  
                                                        <li style="cursor: pointer;"><span id="kichthuoc_<?php echo $t2; ?>" onclick="ClickSize('<?php echo $v2; ?>','<?php echo $t2; ?>');"><?php echo $v2; ?></span>
                                                            <input type="hidden" id="<?php echo 'st_size_' . $v2; ?>" name="<?php echo 'st_size_' . $v2; ?>" value="<?php echo $v2; ?>" /></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <input type="hidden" name="_selected_size" id="_selected_size" />                      
                                        </div>
                                    </div>                                    
                                <?php } ?>
                        
                                <?php if(isset($ar_material) && !empty($ar_material) && $ar_material[0] != ''){ ?>
                                    <div class="row ar_material <?php if(isset($ar_size) && !empty($ar_size) && $ar_size[0] != ''){echo 'hidden';} ?>" id="ar_material">
                                        <div class="col-xs-12">
                                            <div class="dropdown">
                                                <a id="dLabel" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                    Chọn chất liệu <span class="caret"></span>  &nbsp;
                                                    <span class="st_material_value text-primary"></span>
                                                    <span class="hidden qcalert" id="prompt_select_material">Bạn phải chọn chất liệu.</span>
                                                </a>
                                                <ul class="dropdown-menu list-inline" aria-labelledby="dLabel" >
                                                    <?php
                                                    $t3 = 0;
                                                    foreach ($ar_material as $k3 => $v3) {
                                                        $t3++;
                                                        if ($k3 == 0) { $sel_material = $v3; }
                                                    ?>                      
                                                        <li style="cursor: pointer;"><span id="chatlieu_<?php echo $t3; ?>" onclick="ClickMaterial('<?php echo $v3; ?>','<?php echo $t3; ?>');"><?php echo $v3; ?></span>
                                                            <input type="hidden" id="<?php echo 'st_material_' . $v3; ?>" name="<?php echo 'st_material_' . $v3; ?>" value="<?php echo $v3; ?>"></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                            <input type="hidden" name="_selected_material" id="_selected_material" /> 
                                        </div>
                                    </div>                                    
                                <?php } ?>
                                <hr/>   
                            <?php } ?>
                            <!-- END:: STYLE PRODUCT -->

                            <div class="qty_row number_db">
                                <?php $pty_min = $product->shop_type >= 1 ? $product->pro_minsale : 1; ?>
                                <span class="">Số lượng:</span>
                                <span class="qty_group" id="mes_<?php echo $product->pro_id; ?>">
                                    <span class="sub-qty number3_db" title="Bớt" onclick="update_qty(<?php echo $product->pro_id; ?>, -1);">-</span>
                                    <input  id="qty_<?php echo $product->pro_id; ?>" name="qty" onkeypress="return isNumberKey(event)" autofocus="autofocus" autocomplete="off" type="text" min="1" max="9999" class="inpt-qty" required="" value="<?php echo $pty_min; ?>"  title="">
                                    <span class="add-qty number2_db" title="Thêm" onclick="update_qty(<?php echo $product->pro_id; ?>, 1);">+</span>
                                </span>
                            </div>

                            <div id="bt_<?php echo $product->pro_id; ?>" class="add_to_cart_button cart_db text-center">
								
								<div class="btn-group btn-group-justified" role="group">
								  <?php if ($product->pro_type == 0) { ?> 
									<div class="btn-group" role="group">
										<button onclick="addCartQty(<?php echo $product->pro_id; ?>);" title="" type="button" class="btn btn-default1 btn-lg addToCart"><i class="fa fa-cart-plus fa-fw"></i>&nbsp;<span class="">Thêm vào giỏ</span> </button> 
									</div>
								 <?php } ?> 
								  <div class="btn-group" role="group">
									<button onclick="buyNowQty(<?php echo $product->pro_id; ?>);" title="" type="button" class="btn btn-warning btn-lg wishlist"><i class="fa fa-check fa-fw"></i> Mua ngay </button> 
                                  </div>								  
								</div>
                                <!--<a class="fav" onclick="wishlist(<?php echo $product->pro_id; ?>);"><i class="fa fa-heart-o" aria-hidden="true"></i>&nbsp;Yêu thích </a>-->
                                    
                                <input type="hidden" name="product_showcart" id="product_showcart" value="<?php echo $product->pro_id; ?>"/>
                                <input type="hidden" name="af_id" value="<?php echo $_REQUEST['af_id']; ?>"/>
                                <input type="hidden" name="qty_min" value="<?php echo $pty_min; ?>"/>
                                <input type="hidden" name="qty_max" value="<?php echo $product->pro_instock; ?>"/>
                                <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->id; ?>">
                                </div>
                                <?php if ($product->pro_type != 0) { ?>
                                    <div class="text-warning" style="margin-top:10px;"><i class="fa fa-tags" aria-hidden="true"></i>&nbsp;<b>Sản phẩm này được bán dưới hình thức E-coupon.
                                        <a target="_blank" href="<?php echo base_url() . 'content/398'; ?>">Click để tìm hiểu thêm.</a></b></div>
                                <?php } ?>
                            <?php } else { ?>
                                    <div id="bt_<?php echo $product->pro_id; ?>" class="add_to_cart_button">
                                    <button title="Hết hàng" id="buynow-login" class="btn btn-danger sm" type="button">
                                        Hết hàng
                                    </button>
                                    <button onclick="wishlist(<?php echo $product->pro_id; ?>);" title="" type="button" class="btn btn-link  wishlist"><i class="fa fa-heart fa-fw"></i>&nbsp;Yêu thích
                                    </button>
                                    <input type="hidden" name="product_showcart" id="product_showcart" value="<?php echo $product->pro_id; ?>"/>
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
                <div class="col-lg-12">
                    <ul class="menu-justified" id="tabsanpham">
                        <li class="active"><a onclick="OpenTab(1);" data-toggle="tab" href="#DivContentDetail">
                            <span class="hint--top" data-hint="Thông tin chi tiết"><i class="fa fa-list-alt" aria-hidden="true"></i></span> <span class="hidden-xs"><?php echo $this->lang->line('tab_detail_detail'); ?></span>
                            </a>
                        </li>
                        <li><a onclick="OpenTab(2);" data-toggle="tab" href="#DivVoteDetail">
                            <span class="hint--top" data-hint="Bình chọn sản phẩm"><i class="fa fa-thumbs-up" aria-hidden="true"></i></span> <span class="hidden-xs"><?php echo $this->lang->line('tab_vote_detail'); ?></span></a></li>
                        <li><a onclick="OpenTab(3);" data-toggle="tab" href="#DivReplyDetail"> <span class="hint--top" data-hint="Gửi phản hồi"><i class="fa fa-comments" aria-hidden="true"></i></span> <span class="hidden-xs"><?php echo $this->lang->line('tab_comment_detail'); ?></span></a></li>
                        <li><a onclick="OpenTab(4);" data-toggle="tab" href="#DivSendLinkDetail">
                            <span class="hint--top" data-hint="Chia sẻ bạn bè"><i class="fa fa-share-alt" aria-hidden="true"></i></span> <span class="hidden-xs"><?php echo $this->lang->line('send_friend_detail'); ?></span></a></li>
                    </ul>
                    <div class="tab-content">
                        <div id="DivContentDetail" class="tab-pane fade in active">
                            <?php
                            $vovel = array("&curren;");
                            echo html_entity_decode(str_replace($vovel, "#", $product->pro_detail));
                            //echo $this->bbcode->light($product->pro_detail);
                            ?>                            
                        </div>
                        <div id="DivVoteDetail" class="tab-pane fade">
                            <form name="frmVote" method="post">
                                <table border="0" width="100%" style="border:1px #B3D9FF solid;" align="center" cellpadding="0" cellspacing="3">
                                    <tr height="25" style="color:#0AA2EB; background:url(<?php echo base_url(); ?>templates/home/images/bg_titlevote.jpg);">
                                        <td align="center" width="200" style="padding-left: 15px"><?php echo $this->lang->line('info_vote_detail'); ?></td>
                                        <td align="center" colspan="4"><?php echo $this->lang->line('bad_vote_detail'); ?></td>
                                        <td align="center" colspan="3"><?php echo $this->lang->line('normal_vote_detail'); ?></td>
                                        <td align="center" colspan="3"><?php echo $this->lang->line('good_vote_detail'); ?></td>
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
                                        <td align="center" style="background:#ffffff; padding-left:15px;"><img src="<?php echo base_url(); ?>templates/home/images/icon_costvote.gif" border="0" alt=""/>&nbsp;<?php echo $this->lang->line('cost_vote_detail'); ?>:
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="cost" value="1"></td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="cost" value="2"></td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="cost" value="3"></td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="cost" value="4"></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="cost" value="5" checked></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="cost" value="6"></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="cost" value="7"></td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="cost" value="8"></td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="cost" value="9"></td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="cost" value="10"></td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="background:#ffffff; padding-left:15px;"><img src="<?php echo base_url(); ?>templates/home/images/icon_qualityvote.gif"  border="0" alt=""/>&nbsp;<?php echo $this->lang->line('quanlity_vote_detail'); ?>:
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="quanlity" value="1">
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="quanlity" value="2">
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="quanlity" value="3">
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="quanlity" value="4">
                                        </td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="quanlity" value="5" checked></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="quanlity" value="6">
                                        </td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="quanlity" value="7">
                                        </td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="quanlity" value="8">
                                        </td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="quanlity" value="9">
                                        </td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="quanlity" value="10"></td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="background:#ffffff; padding-left:15px;"><img src="<?php echo base_url(); ?>templates/home/images/icon_modelvote.gif" border="0" alt=""/>&nbsp;<?php echo $this->lang->line('model_vote_detail'); ?>:
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="model" value="1"></td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="model" value="2"></td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="model" value="3"></td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="model" value="4"></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="model" value="5" checked></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="model" value="6"></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="model" value="7"></td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="model" value="8"></td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="model" value="9"></td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="model" value="10"></td>
                                    </tr>
                                    <tr>
                                        <td align="center" style="background:#ffffff; padding-left:15px;"><img src="<?php echo base_url(); ?>templates/home/images/icon_servicevote.gif" border="0" alt=""/>&nbsp;<?php echo $this->lang->line('service_vote_detail'); ?>:
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="service" value="1">
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio" name="service" value="2">
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio"  name="service" value="3">
                                        </td>
                                        <td align="center" style="background:#CCCCCC;"><input type="radio"  name="service" value="4">
                                        </td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="service" value="5" checked></td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="service" value="6">
                                        </td>
                                        <td align="center" style="background:#C8D7E6;"><input type="radio" name="service" value="7">
                                        </td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="service" value="8">
                                        </td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="service" value="9">
                                        </td>
                                        <td align="center" style="background:#A0DBFE;"><input type="radio" name="service" value="10">
                                        </td>
                                    </tr>
                                </table>
                                <div class="text-center" style="padding-top:10px">
                                    <input type="button" name="submit_vote" onclick="SubmitVote()" value="<?php echo $this->lang->line('button_vote_detail'); ?>" class="btn btn-azibai"/>
                                </div>
                            </form>
                        </div>
                        <div id="DivReplyDetail" class="tab-pane fade">
                            <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <?php foreach ($comment as $commentArray) { ?>
                            <tr>
                                <td height="50" class="header_reply">
                                    <div class="title_reply"><?php echo $commentArray->prc_title; ?> <span class="time_reply">(<?php echo $this->lang->line('time_comment_detail'); ?> <?php echo date('H\h:i', $commentArray->prc_date); ?> <?php echo $this->lang->line('date_comment_detail'); ?> <?php echo date('d-m-Y', $commentArray->prc_date); ?> )</span></div>
                                    <div class="author_reply"><font color="#999999"><?php echo $this->lang->line('poster_comment_detail'); ?>:</font> <?php echo $commentArray->use_fullname; ?> <span class="email_reply"><a class="menu_1" href="mailto:<?php echo $commentArray->use_email; ?>">(<?php echo $commentArray->use_email; ?> )</a></span></div>
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
                                    <label class="col-md-3 control-label"><?php echo $this->lang->line('title_comment_detail'); ?> :</label>
                                    <div class="col-md-6">
                                        <input type="text" name="title_reply" id="title_reply" value="<?php if (isset($title_reply)) { echo $title_reply; } ?>" maxlength="40" class="input_form form-control" onfocus="ChangeStyle('title_reply', 1);" onblur="ChangeStyle('title_reply', 2);"/>
                                    </div>
                                    <div class="col-md-3"> <?php echo form_error('title_reply'); ?> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"><?php echo $this->lang->line('content_comment_detail'); ?> :</label>
                                    <div class="col-md-6">
                                        <textarea name="content_reply" id="content_reply" class="form-control" onfocus="ChangeStyle('content_reply', 1);" onblur="ChangeStyle('content_reply', 2);"><?php if (isset($content_reply)) { echo $content_reply; } ?>
                                        </textarea>
                                    </div>
                                    <div class="col-md-3"> <?php echo form_error('content_reply'); ?> </div>
                                </div>

                                <?php if (isset($imageCaptchaReplyProduct)) { ?>
                                    <div class="form-group">
                                        <label class="col-md-3 control-label"><?php echo $this->lang->line('captcha_main'); ?> :</label>
                                        <div class="col-md-6"><img src="<?php echo $imageCaptchaReplyProduct; ?>" width="151" height="30" alt=""/><br/>
                                            <input type="text" name="captcha_reply" id="captcha_reply" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_reply', 1);" onblur="ChangeStyle('captcha_reply', 2);"/>
                                        </div>
                                        <div class="col-md-3"> <?php echo form_error('captcha_reply'); ?> </div>
                                    </div>
                                <?php } ?>

                                <div class="form-group">
                                    <label class="col-md-3 form-label"></label>
                                    <div class="col-md-6">
                                        <input type="button" onclick="CheckInput_Reply('<?php
                                               if (isset($isLogined) && $isLogined == true) { echo 1; } else { echo $this->lang->line('must_login_message'); } ?>');" name="submit_reply" value="<?php echo $this->lang->line('button_comment_comment_detail'); ?>" class="btn btn-azibai"/>
                                        <input type="reset" name="reset_reply" value="<?php echo $this->lang->line('button_reset_comment_detail'); ?>" class="btn btn-danger"/>
                                    </div>
                                    <div class="col-md-3"></div>
                                </div>
                            </form>
                        </div>
                        <div id="DivSendLinkDetail" class="tab-pane fade">
                            <div class="sendlink_main">
                                <form name="frmSendLink" class="form-horizontal" method="post">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('email_sender_send_friend_detail'); ?> :</label>
                                        <div class="col-sm-6">
                                            <input type="text" name="sender_sendlink" id="sender_sendlink" value="<?php if (isset($sender_sendlink)) { echo $sender_sendlink; } ?>" maxlength="50" class="input_form form-control" onfocus="ChangeStyle('sender_sendlink', 1);" onblur="ChangeStyle('sender_sendlink', 2);"/>
                                        </div>
                                        <div class="col-sm-3"> <?php echo form_error('sender_sendlink'); ?> </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('email_receiver_send_friend_detail'); ?> :</label>
                                        <div class="col-sm-6">
                                            <input type="text" class="form-control input_form" name="receiver_sendlink" id="receiver_sendlink" value="<?php
                                                   if (isset($receiver_sendlink)) {
                                                       echo $receiver_sendlink;
                                                   }
                                                   ?>" maxlength="50" onfocus="ChangeStyle('receiver_sendlink', 1);"
                                                   onblur="ChangeStyle('receiver_sendlink', 2);"/>
                                        </div>
                                        <div class="col-sm-3"> <?php echo form_error('receiver_sendlink'); ?> </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('title_send_friend_detail'); ?> :</label>
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
                                        <label class="col-sm-3 control-label"><?php echo $this->lang->line('message_send_friend_detail'); ?> :</label>
                                        <div class="col-sm-6">
                                            <textarea name="content_sendlink" class="form-control" id="content_sendlink" cols="50" rows="7" onfocus="ChangeStyle('content_sendlink', 1);" onblur="ChangeStyle('content_sendlink', 2);">
                                                <?php if (isset($content_sendlink)) { echo $content_sendlink; } ?>
                                            </textarea>
                                        </div>
                                        <div class="col-sm-3"> <?php echo form_error('content_sendlink'); ?> </div>
                                    </div>
                                <?php if (isset($imageCaptchaSendFriendProduct)) { ?>
                                        <div class="form-group">
                                            <label class="col-sm-3 control-label"><?php echo $this->lang->line('captcha_main'); ?> :</label>
                                            <div class="col-sm-6">
                                                <img src="<?php echo $imageCaptchaSendFriendProduct; ?>" width="151" height="30" alt=""/><br/>
                                                <input onKeyPress="return submitenter(this, event, 1)" type="text" name="captcha_sendlink" id="captcha_sendlink" value="" maxlength="10" class="inputcaptcha_form form-control" onfocus="ChangeStyle('captcha_sendlink', 1);" onblur="ChangeStyle('captcha_sendlink', 2);"/>
                                            </div>
                                            <div class="col-sm-3"> <?php echo form_error('captcha_sendlink'); ?> </div>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label"> </label>
                                        <div class="col-sm-6">
                                            <input type="button" onclick="CheckInput_SendLink();" name="submit_sendlink" value="<?php echo $this->lang->line('button_send_send_friend_detail'); ?>" class="btn btn-default1"/>
                                            <input type="reset" name="reset_sendlink" value="<?php echo $this->lang->line('button_reset_send_friend_detail'); ?>" class="btn btn-default1"/>
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
                    <div id="DivSendFailDetail">
                        <form name="frmSendFail" method="post">
                            <?php if ($this->session->userdata('sessionUser') > 0) { ?>
                                <table border="0" width="100%" cellpadding="0" cellspacing="2">
                                    <tr>
                                        <td colspan="2" height="15"></td>
                                    </tr>
                                    <tr style="display:none;">
                                        <td width="110" class="list_form"><?php echo $this->lang->line('email_sender_send_bad_detail'); ?> :
                                        </td>
                                        <td align="left"><input type="text" name="sender_sendfail" id="sender_sendfail" value="<?php  if (isset($sender_sendfail)) { echo $sender_sendfail; } ?>" maxlength="50" class="input_form" onfocus="ChangeStyle('sender_sendfail', 1);" onblur="ChangeStyle('sender_sendfail', 2);"/>
                                        <?php echo form_error('sender_sendfail'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="110" class="list_form"><?php echo $this->lang->line('title_send_bad_detail'); ?>:
                                        </td>
                                        <td align="left"><input type="text" name="title_sendfail" id="title_sendfail" value="<?php if (isset($title_sendfail)) { echo $title_sendfail; } ?>" maxlength="80" class="input_form" onfocus="ChangeStyle('title_sendfail', 1);" onblur="ChangeStyle('title_sendfail', 2);"/>
                                            <?php echo form_error('title_sendfail'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="110" class="list_form"><?php echo $this->lang->line('content_send_bad_detail'); ?> :
                                        </td>
                                        <td align="left">
                                        <textarea name="content_sendfail" id="content_sendfail" cols="50" rows="7" class="textarea_form" onfocus="ChangeStyle('content_sendfail', 1);" onblur="ChangeStyle('content_sendfail', 2);"><?php if (isset($content_sendfail)) { echo $content_sendfail; } ?>
                                        </textarea>
                                    <?php echo form_error('content_sendfail'); ?></td>
                                    </tr>
                                    <?php if (isset($imageCaptchaSendFriendProduct)) { ?>
                                        <tr>
                                            <td width="110" class="list_form"><?php echo $this->lang->line('captcha_main'); ?>:
                                            </td>
                                            <td align="left"><img src="<?php echo base_url() . $imageCaptchaSendFriendProduct; ?>" width="151" height="30" alt=""/><br/>
                                                <input onKeyPress="return submitenter(this, event, 2)" type="text" name="captcha_sendfail" id="captcha_sendfail" value="" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_sendfail', 1);" onblur="ChangeStyle('captcha_sendfail', 2);"/>
                                        <?php echo form_error('captcha_sendfail'); ?></td>
                                        </tr>
                                    <?php } ?>
                                    <tr>
                                        <td height="30"></td>
                                        <td height="30" valign="bottom" align="center">
                                            <table border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td><input type="button" onclick="CheckInput_SendFail('<?php if (isset($isSendedOneFail) && $isSendedOneFail == true) { echo $this->lang->line('is_sended_one_message_detail'); } else { echo 1;} ?>');" name="submit_sendfail" value="<?php echo $this->lang->line('button_send_send_bad_detail'); ?>" class="button_form"/>
                                                    </td>
                                                <input type="hidden" value="" name="bao_cao_sai_gia"
                                                       id="bao_cao_sai_gia"/>
                                                <input type="hidden" value="<?php echo $cacha; ?>"
                                                       name="capcha_sai_gia" id="capcha_sai_gia"/>
                                                <td width="15"></td>
                                                <td><input type="reset" name="reset_sendfail" value="<?php echo $this->lang->line('button_reset_send_bad_detail'); ?>" class="button_form"/></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            <?php } else { ?>
                                <div style="padding-top:10px;"> Bạn hãy <a href="<?php echo base_url() ?>login"> đăng nhập </a> để thực hiện chức năng này
                                </div>
                            <?php } ?>
                        </form>
                    </div>

                    <div id="DivHetHangDetail">
<?php if ($this->session->userdata('sessionUser') > 0) { ?>
                            <form name="frmSendFailHetHang" method="post">
                                <table class="sendfail_main" border="0" align="center" cellpadding="0" cellspacing="0" style="padding-left:20px;">
                                    <tr style="display:none">
                                        <td width="110" class="list_form"><?php echo $this->lang->line('email_sender_send_bad_detail'); ?> :
                                        </td>
                                        <td align="left"><input type="text" name="sender_sendfail_het_hang" id="sender_sendfail_het_hang" value="" maxlength="50" class="input_form" onfocus="ChangeStyle('sender_sendfail', 1);" onblur="ChangeStyle('sender_sendfail', 2);"/><?php echo form_error('sender_sendfail'); ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="110" class="list_form"><?php echo $this->lang->line('title_send_bad_detail'); ?>:
                                        </td>
                                        <td align="left"><input type="text" name="title_sendfail_het_hang" id="title_sendfail_het_hang" value="" maxlength="80" class="input_form" onfocus="ChangeStyle('title_sendfail', 1);" onblur="ChangeStyle('title_sendfail', 2);"/> <?php echo form_error('title_sendfail'); ?>
                                            </td>
                                    </tr>
                                    <tr>
                                        <td width="110" class="list_form"><?php echo $this->lang->line('content_send_bad_detail'); ?> :
                                        </td>
                                        <td align="left">
                                        <textarea name="content_sendfail_het_hang" id="content_sendfail_het_hang" cols="50" rows="7" class="textarea_form" onfocus="ChangeStyle('content_sendfail', 1);" onblur="ChangeStyle('content_sendfail', 2);"><?php if (isset($content_sendfail)) { echo $content_sendfail; } ?>
                                            </textarea>
                                    <?php echo form_error('content_sendfail'); ?></td>
                                    </tr>
                                        <?php if (isset($imageCaptchaSendFriendProduct)) { ?>
                                        <tr>
                                            <td width="110" class="list_form"><?php echo $this->lang->line('captcha_main'); ?>:
                                            </td>
                                            <td align="left"><img src="<?php echo base_url() . $imageCaptchaSendFriendProduct; ?>" width="151" height="30" alt=""/><br/>
                                                <input onKeyPress="return submitenter(this, event, 3)" type="text" name="captcha_sendfail_het_hang" id="captcha_sendfail_het_hang" maxlength="10" class="inputcaptcha_form" onfocus="ChangeStyle('captcha_sendfail', 1);" onblur="ChangeStyle('captcha_sendfail', 2);"/>
                                        <?php echo form_error('captcha_sendfail'); ?></td>
                                        </tr>
                                        <?php } ?>
                                    <tr>
                                        <td height="30"></td>
                                        <td height="30" valign="bottom" align="center">
                                            <table border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td><input type="hidden" name="bao_cao_het_hang" id="bao_cao_het_hang"/>
                                                        <input type="hidden" value="<?php echo $cacha; ?>" name="capcha_het_hang" id="capcha_het_hang"/>
                                                        <input type="button" onclick="CheckInput_SendHetHang();" name="submit_sendfail" value="<?php echo $this->lang->line('button_send_send_bad_detail'); ?>"  class="button_form"/></td>
                                                    <td width="15"></td>
                                                    <td><input type="reset" name="reset_sendfail" value="<?php echo $this->lang->line('button_reset_send_bad_detail'); ?>" class="button_form"/></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </form>
<?php } else { ?>
                            <div style="padding-top:10px; padding-left:170px"> Bạn hãy <a href="<?php echo base_url() ?>login"> đăng nhập </a> để thực hiện chức năng này
                            </div>
<?php } ?>
                    </div>
                    <?php if (isset($isViewComment) && $isViewComment == true) { ?>
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
<?php } ?>
                </div>
            </div>

<!-- Begin:: Sản phẩm cùng danh mục -->
<?php if (count($categoryProduct) > 0) { ?>
    <hr/>
    <div class="row">
        <div class="col-md-12">
            <h2><?php echo $this->lang->line('title_relate_category_product_detail'); ?></h2>
        </div>        
        <?php           
            $idDiv = 1;
            foreach ($categoryProduct as $product) {
                $afSelect = false;
                $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
         ?>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 showbox_1q_detail" id="DivReliableProductBoxNew_<?php echo $idDiv; ?>">
                <?php $this->load->view('shop/product/shop_item', array('product' => $product, 'discount' => $discount)); ?>
                </div>
            <?php $idDiv++; ?>
        <?php } ?>
    </div>
<?php } ?>
<!-- End:: Sản phẩm cùng danh mục -->
<!-- Begin:: Sản phẩm cùng gian hàng -->
<?php if (count($userProduct) > 0) { ?>
    <hr/>
    <div class="row">
        <div class="col-md-12">
            <h2><?php echo $this->lang->line('title_relate_shop_product_detail'); ?></h2>
        </div>
        <?php $idDiv = 1; ?>
        <?php
            foreach ($userProduct as $product) {
                $afSelect = false;
                $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
        ?>
                <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 showbox_1q_detail" id="DivReliableProductBoxNew_<?php echo $idDiv; ?>">
                <?php $this->load->view('shop/product/shop_item', array('product' => $product, 'discount' => $discount)); ?>
                </div>
            <?php $idDiv++; ?>
        <?php } ?>
    </div>
<?php } ?>
<!-- End:: Sản phẩm cùng gian hàng -->           
</div>
       
<div style="display:none;">
    <div xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumbs-title">
        <span typeof="v:Breadcrumb"> 
            <a rel="v:url" property="v:title" href="<?php echo base_url() ?>" class="home">Home</a> 
        </span>
        <span class="separator">»</span>

<?php if (isset($CategorysiteGlobalRoot->cat_id)) { ?>
        <span typeof="v:Breadcrumb"> <a rel="v:url" property="v:title" href="<?php echo base_url() ?><?php echo $CategorysiteGlobalRoot->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobalRoot->cat_name); ?>" title="<?php echo $CategorysiteGlobalRoot->cat_name; ?>"><?php echo mb_substr($CategorysiteGlobalRoot->cat_name, 0, 30, 'UTF-8'); ?> </a> 
            <span class="separator">»</span> 
        </span>
<?php } ?>

<?php if (isset($CategorysiteGlobal->cat_id)) { ?>
        <span typeof="v:Breadcrumb"> <a rel="v:url" property="v:title" href="<?php echo base_url() ?><?php echo $CategorysiteGlobal->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobal->cat_name); ?>" title="<?php echo $CategorysiteGlobal->cat_name; ?>"><?php echo mb_substr($CategorysiteGlobal->cat_name, 0, 30, 'UTF-8'); ?></a> 
        <span class="separator">»</span> </span>
<?php } ?>

<?php if ($siteGlobal->cat_id != "") { ?>
    <span class="separator">»</span> 
    <span typeof="v:Breadcrumb"> 
        <a rel="v:url" property="v:title" href="<?php echo base_url() ?><?php echo $siteGlobal->cat_id; ?>/<?php echo RemoveSign($siteGlobal->cat_name); ?>" title="">
    <?php echo $siteGlobal->cat_name; ?></a> 
    </span>
<?php } ?>

<?php echo $product->pro_name; ?> 
    </div>
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
                    <textarea style="height:1px; visibility:hidden;" class="js-copytextarea"><?php echo 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?> ?share=<?php echo $currentUser->af_key; ?></textarea>
                        <!-- end container-fluid -->
                        <!-- END CENTER-->                        
<?php $this->load->view('home/common/footer'); ?>

<?php 
	if($shop->sho_phone){
		$phonenumber = $shop->sho_phone;
	} elseif($shop->sho_mobile){
		$phonenumber = $shop->sho_mobile;
	}
	if($phonenumber){
?>    
	<div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
		<div class="phonering-alo-ph-circle"></div>
		<div class="phonering-alo-ph-circle-fill"></div>            
		<div class="phonering-alo-ph-img-circle">
			<a href="tel:<?php echo $shop->sho_mobile; ?>">
				<img data-toggle="modal" data-target=".bs-example-modal-md" src="https://i.imgur.com/v8TniL3.png" alt="Liên hệ" width="50" onmouseover="this.src = 'https://i.imgur.com/v8TniL3.png';" onmouseout="this.src = 'https://i.imgur.com/v8TniL3.png';">
			</a>
		</div>
	</div>
<?php } ?>      

<script>        
    $("#toTop").css("display", "none");

    function submitenter(myfield, e, enterForm) {
        var keycode;
        if (window.event){
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

    $(document).ready(function() {
        $('#mausac_1').addClass('actived');
        $('#_selected_color').val($('#mausac_1').text());
        $('#kichthuoc_1').addClass('actived');
        $('#chatlieu_1').addClass('actived');
    });

    function SeletColorStyle(name, no){ 
        var a = $('#st_color_'+name).val();
        if(a){
            $.ajax({
               type: "POST",
               dataType: "json",
               url: "<?php echo base_url(); ?>" + "home/product/product_style_azibai",
               data: {id : pro_id, color: a, size : sl_size, material : sl_material},
               success: function (result) { 
                    for(var i = 1; i <= n1; i++){
                        if(i != no){
                            $('#mausac_'+i).removeClass('actived');
                        }else{
                            $('#mausac_'+i).addClass('actived');
                        }
                    } 
                                       
                    if (result.error == false) {                         
                        console.log(result);                     
                        sl_color = name;
                        if(result.pro_prices == null){
                            $(".qty_row").addClass('hidden');
                            $("#bt_"+pro_id).addClass('hidden');
                            $("#bt_hethang_"+pro_id).removeClass('hidden');
                        }else{
                            var money = parseInt(result.pro_prices);
                            var money_save = money -  parseInt(result.off_amount);
                            var money_save_af = money_save - parseInt(result.af_off);
                            money = money.toLocaleString();
                            money_save = money_save.toLocaleString();
                            money_save_af = money_save_af.toLocaleString();
                            $("#show-cost").text(money+ ' Vnđ');
                            $("#cost-save").text(money_save+' Vnđ');
                            $("#cost-save-af").text(money_save_af+' Vnđ');
                            $("#bt_hethang_"+pro_id).addClass('hidden');
                            $(".qty_row").removeClass('hidden');
                            $("#bt_"+pro_id).removeClass('hidden');
                            $( "#carousel-ligghtgallery .owl-item.active .item img" ).attr( "src", function() {
                                  return "<?php echo base_url(). 'media/images/product/'; ?>"+result.pro_dir+"/"+result.pro_images;
                                });
                            $("#dp_id").val(result.pro_id);
                        }                       
                    }else{
                        alert('error: true');
                    }                       
               },
               error: function () {
                    alert('Loi roi chu');
               }
            });             
        }
    }

    function SeletSizeStyle(name, no){
        var b = $('#st_size_'+name).val();  
        if(b){
            $.ajax({
               type: "POST",
               dataType: "json",
               url: "<?php echo base_url(); ?>" + "home/product/product_style_azibai",
               data: {id : pro_id, color: sl_color, size : b, material : sl_material},
               success: function (result) {
                    for(var i = 1; i <= n2; i++){
                        if(i != no){
                            $('#kichthuoc_'+i).removeClass('actived');
                        }else{
                            $('#kichthuoc_'+i).addClass('actived');
                        }
                    }                       
                    if (result.error == false) { 
                        console.log(result.pro_prices);                     
                        sl_size = name;
                        if(result.pro_prices == null){                              
                            $(".qty_row").addClass('hidden');
                            $("#bt_"+pro_id).addClass('hidden');
                            $("#bt_hethang_"+pro_id).removeClass('hidden');
                        }else{
                            var money = parseInt(result.pro_prices);
                            var money_save = money - parseInt(result.off_amount); 
                            var money_save_af = money_save - parseInt(result.af_off);
                            money = money.toLocaleString();
                            money_save = money_save.toLocaleString();
                            money_save_af = money_save_af.toLocaleString();
                            $("#show-cost").text(money+ ' Vnđ');
                            $("#cost-save").text(money_save+' Vnđ');
                            $("#cost-save-af").text(money_save_af+' Vnđ');
                            $("#bt_hethang_"+pro_id).addClass('hidden');
                            $(".qty_row").removeClass('hidden');
                            $("#bt_"+pro_id).removeClass('hidden');
                            $( "#carousel-ligghtgallery .owl-item.active .item img" ).attr( "src", function() {
                                  return "<?php echo base_url(). 'media/images/product/'; ?>"+result.pro_dir+"/"+result.pro_images;
                                });
                            $("#dp_id").val(result.pro_id);
                        }                           
                    }                       
               },
               error: function () {
               }
            });
        }
        $('.st_size_value').html(b);
    }

    function SeletMaterialStyle(name, no){
        var c = $('#st_material_'+name).val();	    
        if(c){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url(); ?>" + "home/product/product_style_azibai",
                data: {id : pro_id, color: sl_color, size : sl_size, material : c},
                success: function (result) {
                    for(var i = 1; i <= n3; i++){
                        if(i != no){
                             $('#chatlieu_'+i).removeClass('actived');
                        }else{
                            $('#chatlieu_'+i).addClass('actived');
                        }
                    }                       
                    if (result.error == false) {
                        console.log(result.pro_prices);                     
                        sl_material = name;
                        if(result.pro_prices == null){                              
                            $(".qty_row").addClass('hidden');
                            $("#bt_"+pro_id).addClass('hidden');
                            $("#bt_hethang_"+pro_id).removeClass('hidden');
                        }else{
                            var money = parseInt(result.pro_prices);
                            var money_save = money - parseInt(result.off_amount); 
                            var money_save_af = money_save - parseInt(result.af_off);
                            money = money.toLocaleString();
                            money_save = money_save.toLocaleString();
                            money_save_af = money_save_af.toLocaleString();
                            $("#show-cost").text(money+ ' Vnđ');
                            $("#cost-save").text(money_save+' Vnđ');
                            $("#cost-save-af").text(money_save_af+' Vnđ');
                            $("#bt_hethang_"+pro_id).addClass('hidden');
                            $(".qty_row").removeClass('hidden');
                            $("#bt_"+pro_id).removeClass('hidden');
                            $( "#carousel-ligghtgallery .owl-item.active .item img" ).attr( "src", function() {
                                    return "<?php echo base_url(). 'media/images/product/'; ?>"+result.pro_dir+"/"+result.pro_images;
                                });
                            $("#dp_id").val(result.pro_id);
                        }                                                   
                    }                       
                },
                error: function () {
                }
            });
        }
    
        $('.st_material_value').html(c);
    }    

    function SelectProSales(siteUrl, id){
        jQuery.ajax({
            type: "POST",
            url: siteUrl+"home/affiliate/ajax_select_pro_sales",                
            dataType: 'json',
            data: { proid:id},
            success: function (data) {
                console.log(data);
                if(data == '1'){
                    location.reload();
                }else{
                    alert('Có lỗi xảy ra!');
                }
            }
        });
    }

    function ClickColor(name, no){
        var a = $('#st_color_'+name).val();
        if(a){
            $.ajax({
               type: "POST",
               dataType: "json",
               url: "<?php echo base_url(); ?>" + "home/product/select_style_product",
               data: {id : pro_id, color: a, size : sl_size, material : sl_material},
               success: function (result) {
                    for(var i = 1; i <= n1; i++){
                        if(i != no){
                            $('#mausac_'+i).removeClass('actived');
                        }else{
                            $('#mausac_'+i).addClass('actived');
                        }
                    } 
                                       
                    if (result.error == false) {                         
                        console.log(result);                     
                        sl_color = name;
                        if(result.pro_prices == null){
                            $(".qty_row").addClass('hidden');
                            $("#bt_"+pro_id).addClass('hidden');
                            $("#bt_hethang_"+pro_id).removeClass('hidden');
                        }else{
                            var money = parseInt(result.pro_prices);
                            var money_save = money -  parseInt(result.off_amount);
                            var money_save_af = money_save - parseInt(result.af_off);
                            money = money.toLocaleString();
                            money_save = money_save.toLocaleString();
                            money_save_af = money_save_af.toLocaleString();
                            $("#show-cost").text(money+ ' Vnđ');
                            $("#cost-save").text(money_save+' Vnđ');
                            $("#cost-save-af").text(money_save_af+' Vnđ');
                            $("#bt_hethang_"+pro_id).addClass('hidden');
                            $("#_selected_size").val("");
                            $("#_selected_material").val("");
                            $("span.st_size_value").text("");
                            $("span.st_material_value").text("");
                            $('#_selected_color').val($('#mausac_'+no).text());
                            $("#ar_material").addClass('hidden');                                
                            $(".qty_row").removeClass('hidden');
                            $("#bt_"+pro_id).removeClass('hidden');
                            $( "#carousel-ligghtgallery .owl-item.active .item img" ).attr( "src", function() {
                                  return "<?php echo base_url(). 'media/images/product/'; ?>"+result.pro_dir+"/"+result.pro_images;
                            });
                            $("#dp_id").val(result.pro_id);
                        }                       
                    }else{
                        alert('error: true');
                    }                       
               },
               error: function () {
                    alert('Có lỗi xảy ra.');
               }
            }); 
        }
    }

    function ClickSize(name, no){
        var b = $('#st_size_'+name).val();  
        if(b){
            $.ajax({
               type: "POST",
               dataType: "json",
               url: "<?php echo base_url(); ?>" + "home/product/product_style_azibai",
               data: {id : pro_id, color: sl_color, size : b, material : sl_material},
               success: function (result) {
                    for(var i = 1; i <= n2; i++){
                        if(i != no){
                            $('#kichthuoc_'+i).removeClass('actived');
                        }else{
                            $('#kichthuoc_'+i).addClass('actived');
                        }
                    }                       
                    if (result.error == false) { 
                        console.log(result.pro_prices);                     
                        sl_size = name;
                        if(result.pro_prices == null){  
                            $(".qty_row").addClass('hidden');
                            $("#bt_"+pro_id).addClass('hidden');
                            $("#bt_hethang_"+pro_id).removeClass('hidden');
                        }else{
                            var money = parseInt(result.pro_prices);
                            var money_save = money - parseInt(result.off_amount); 
                            var money_save_af = money_save - parseInt(result.af_off);
                            money = money.toLocaleString();
                            money_save = money_save.toLocaleString();
                            money_save_af = money_save_af.toLocaleString();
                            $("#show-cost").text(money+ ' Vnđ');
                            $("#cost-save").text(money_save+' Vnđ');
                            $("#cost-save-af").text(money_save_af+' Vnđ');
                            $("#ar_material").removeClass('hidden');
                            $("span.st_material_value").text("");
                            $("#_selected_material").val("");
                            $("#prompt_select_size").addClass('hidden');
                            $('#_selected_size').val($('#kichthuoc_'+no).text());
                            $("#bt_hethang_"+pro_id).addClass('hidden');
                            $(".qty_row").removeClass('hidden');
                            $("#bt_"+pro_id).removeClass('hidden');
                            $( "#carousel-ligghtgallery .owl-item.active .item img" ).attr( "src", function() {
                                  return "<?php echo base_url(). 'media/images/product/'; ?>"+result.pro_dir+"/"+result.pro_images;
                                });
                            $("#dp_id").val(result.pro_id);
                        }                           
                    }                       
               },
               error: function () {
               }
            });
        }
        $('.st_size_value').html(b);
    }

    function ClickMaterial(name, no){
        var c = $('#st_material_'+name).val();      
        if(c){
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo base_url(); ?>" + "home/product/product_style_azibai",
                data: {id : pro_id, color: sl_color, size : sl_size, material : c},
                success: function (result) {
                    for(var i = 1; i <= n3; i++){
                        if(i != no){
                             $('#chatlieu_'+i).removeClass('actived');
                        }else{
                            $('#chatlieu_'+i).addClass('actived');
                        }
                    }                       
                    if (result.error == false) {
                        console.log(result.pro_prices);                     
                        sl_material = name;
                        if(result.pro_prices == null){                              
                            $(".qty_row").addClass('hidden');
                            $("#bt_"+pro_id).addClass('hidden');
                            $("#bt_hethang_"+pro_id).removeClass('hidden');
                        }else{
                            var money = parseInt(result.pro_prices);
                            var money_save = money - parseInt(result.off_amount); 
                            var money_save_af = money_save - parseInt(result.af_off);
                            money = money.toLocaleString();
                            money_save = money_save.toLocaleString();
                            money_save_af = money_save_af.toLocaleString();
                            $("#show-cost").text(money+ ' Vnđ');
                            $("#cost-save").text(money_save+' Vnđ');
                            $("#cost-save-af").text(money_save_af+' Vnđ');
                            $("#prompt_select_material").addClass('hidden');
                            $('#_selected_material').val($('#chatlieu_'+no).text());
                            $("#bt_hethang_"+pro_id).addClass('hidden');
                            $(".qty_row").removeClass('hidden');
                            $("#bt_"+pro_id).removeClass('hidden');
                            $( "#carousel-ligghtgallery .owl-item.active .item img" ).attr( "src", function() {
                                return "<?php echo base_url(). 'media/images/product/'; ?>"+result.pro_dir+"/"+result.pro_images;
                            });
                            $("#dp_id").val(result.pro_id);
                        }                                                   
                    }                       
                },
                error: function () {
                }
            });
        }
    
        $('.st_material_value').html(c);
    }
</script>
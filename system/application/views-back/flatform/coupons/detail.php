<?php $this->load->view('flatform/common/header_shop'); ?>
<?php
$segment = $this->uri->segment(2);
if($segment == 'product'){
    $typesp = 'Sản phẩm';
}else{
    $typesp = 'Coupon';
}
?>
<div class="container" role="main">
    <br>
    <ol class="breadcrumb">
        <li>Trang chủ</li>
        <li><a href="/flatform/<?php echo $segment; ?>"><?php echo ($segment == 'product') ? 'Sản phẩm' : 'Coupon'; ?></a></li>
        <li class="active"><?php echo $products[0]->pro_name; ?></li>
    </ol>
    <div class="row">
        <?php foreach($products as $key => $product){?>
        <div class="col-sm-8 col-xs-12"> 
            <div class="row">        
                <div class="col-sm-5 col-xs-12">
                    <div class="imagepro text-center">
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
                                        background: #e5e5e5;
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
                                            <?php if ($image != '') { //file_exists($imgsrc) && ?>
                                                <a class="c image" href="<?php echo $imgsrc ?>">
                                                    <img src="<?php echo $imgsrc ?>" alt="...">
                                                </a>
                                            <?php } else { ?>
                                                <a class="c image"
                                                   href="<?php echo base_url() . 'images/noimage.jpg' ?>">
                                                    <img src="<?php echo base_url() . 'images/noimage.jpg' ?>"
                                                         alt="...">
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
                                        <img class="img-responsive" src="<?php echo $linkshop; ?>media/images/product/<?php echo $product->pro_dir; ?>/<?php echo $imageDetail[0]; ?>" alt=""/>
                                    </a>
                                </div>
                                <ul class="list-img">
                                    <?php foreach ($imageDetail as $key => $imageDetailArray) { ?>
                                        <?php if ($imageDetailArray != "") { ?>
                                            <li class="<?php if ($key == 0) { echo 'current'; } ?>">
                                                <a class="slideshow" href="<?php echo $linkshop; ?>media/images/product/<?php echo $product->pro_dir; ?>/<?php echo $imageDetailArray; ?>">
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

                            if (($af_id == "") && ($this->session->userdata('af_id') != "")) {
                                $af_id = $this->session->userdata('af_id');
                            }

                            $path_info = $_SERVER["PATH_INFO"]; // ==> "/product/detail/pro_id/pro-name-not-hide-vnamese"
                            $domain_alias = $_SERVER["HTTP_X_FORWARDED_HOST"]; // ==> "domainshop.com"

                            $url = current_url();
                            if ($shop_pro->domain != "") {
                                $url = $protocol . $domain_alias . $path_info;
                            }
                            $link_af_id = !empty($af_id) ? $url . "?af_id=" . $af_id : $url;

//                            function url_origin($s, $use_forwarded_host = false)
//                            {
//                                $ssl = (!empty($s['HTTPS']) && $s['HTTPS'] == 'on');
//                                $sp = strtolower($s['SERVER_PROTOCOL']);
//                                $protocol = substr($sp, 0, strpos($sp, '/')) . (($ssl) ? 's' : '');
//                                $port = $s['SERVER_PORT'];
//                                $port = ((!$ssl && $port == '80') || ($ssl && $port == '443')) ? '' : ':' . $port;
//                                $host = ($use_forwarded_host && isset($s['HTTP_X_FORWARDED_HOST'])) ? $s['HTTP_X_FORWARDED_HOST'] : (isset($s['HTTP_HOST']) ? $s['HTTP_HOST'] : null);
//                                $host = isset($host) ? $host : $s['SERVER_NAME'] . $port;
//                                return $protocol . '://' . $host;
//                            }
//
//                            function full_url($s, $use_forwarded_host = false)
//                            {
//                                return url_origin($s, $use_forwarded_host) . $s['REQUEST_URI'];
//                            }
//
//                            $absolute_url = full_url($_SERVER);
                            //echo $absolute_url;
                            //print_r($_SERVER);
                            ?>
                        <p>Chia sẻ sản phẩm này:</p>                      
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
                            <?php
                            $group_id = (int)$this->session->userdata('sessionGroup');
                            if ($group_id == AffiliateUser) {
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
                                        <div class="TenHH">Hoa hồng Cộng tác viên được hưởng</div>
                                        <div class="phantranHH"><?php echo $pro_affiliate_value; ?></div>
                                    </div>
                                    <?php if ($selected_sale != true) { ?>
                                        <button class="btn btn-default"
                                                onclick="SelectProSales('<?php echo getAliasDomain() ?>',<?php echo $product->pro_id; ?>);">
                                            <i class="fa fa-check fa-fw"></i> Chọn bán
                                        </button>
                                    <?php } else { ?>
                                        <button class="btn btn-default"><i class="fa fa-check fa-fw"></i> Đã chọn bán
                                        </button>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>       
                    </div> 
                </div> 
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
                
                if ($shop_pro->domain != '') {
                    $my_link_news = 'http://' . $shop_pro->domain;
                    $my_link_shop = $my_link_news . '/shop';
                } else {
                    $my_link_news = 'http://' . $shop_pro->sho_link . '.' . domain_site;
                    $my_link_shop = $my_link_news . '/shop'; 
                }
                ?>
                <div class="col-sm-7 col-xs-12">
                    <h2 style="margin-top: 0"><?php echo $product->pro_name; ?></h2>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <p class="small">
                            <i class="fa fa-shopping-bag fa-fw" data-toggle="tooltip" data-placement="top" title="Lượt mua"></i> <?php echo $product->pro_buy; ?> &nbsp;|&nbsp; 
                            <i class="fa fa-eye fa-fw" data-toggle="t|ooltip" data-placement="top" title="Lượt xem"></i> <?php echo $product->pro_view; ?>
                        </p>
                    </div>
                    <?php if($product->pro_user != $this->session->userdata('sessionUser')){ ?>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-right">
                            <a href="#" style="border:none;" class="report text-center" style="width: 100px" data-id="<?php echo $product->pro_id ?>" data-toggle="modal" data-target="#reportdetailModal">
                                <i class="fa fa-exclamation-triangle"></i> Báo cáo
                            </a>
                        </div>
                    <?php } ?>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td width="120" valign="top" class="list_detail" style="line-height:18px;">Giá Gốc                                        :
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
                                    <td width="120" valign="top" class="list_detail" style="line-height:18px;">Giá
                                        khuyến mãi:
                                    </td>
                                    <td>
                                        <span class="sale-price detail <?php if ($discount['af_off'] > 0) { echo 'cost-price-line';} ?>" id="cost-save"><?php echo number_format($discount['off_sale'], 0, ",", "."); ?></span>
                                        vnđ
                                        <span class="label label-success" style="float:right; padding: 5px ;font-size: 14px ">Tiết kiệm: <b><?php echo ($product->off_rate > 0) ? $product->off_rate . '%' : number_format($product->off_amount) . ' vnđ'; ?></b></span>
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
                                
                            <tr>
                                <td width="70" valign="top" class="list_detail">Gian hàng                                 :
                                </td>
                                <td>
                                    <strong><a target="_blank" href="<?php echo $my_link_shop; ?>"><?php echo $shop_pro->sho_name; ?></a></strong>
                                </td>
                            </tr>
                            <tr>
                                <td width="70" valign="top" class="list_detail">Danh mục                                        :
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
                                        $link_cat = '/flatform/' . $linkt . '/cat/' . $category->cat_id . '/' . RemoveSign($category->cat_name);
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
<!--                                <td width="70" valign="top"
                                    class="list_detail"><?php echo $this->lang->line('vote_detail_product_detail'); ?>
                                    :
                                </td>-->
<!--                                <td id="vote_detail">
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
                                </td>-->
                            </tr>
                        </tbody>
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
                                            $gt = explode(' ', $v1);
                                            $st_color = implode('_', $gt);
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
                                            <ul class="dropdown-menu list-inline list_ar_size" aria-labelledby="dLabel">
                                                <?php
                                                $t2 = 0;
                                                foreach ($ar_size as $k2 => $v2) {
                                                    $t2++;
                                                    if ($k2 == 0) {
                                                        $sel_size = $v2;
                                                    }
                                                    $gt = explode(' ', $v2);
                                                    $st_size = implode('_', $gt);
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

                                <div class="row ar_material<?php echo $hiddenMaterial ?>" id="ar_material">
                                    <div class="col-xs-12">
                                        <div class="dropdown">
                                            <a id="dLabel" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Chọn chất liệu <span class="caret"></span> &nbsp;
                                                <span class="st_material_value text-primary"></span>
                                                <span class="hidden qcalert" id="prompt_select_material">Bạn phải chọn chất liệu.</span>
                                            </a>
                                            <ul class="dropdown-menu list-inline list_ar_material" aria-labelledby="dLabel">
                                                <?php
                                                $t3 = 0;
                                                foreach ($ar_material as $k3 => $v3) {
                                                    $t3++;
                                                    if ($k3 == 0) {
                                                        $sel_material = $v3;
                                                    }
                                                    $gt = explode(' ', $v3);
                                                    $st_material = implode('_', $gt);
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
                            <?php $pty_min = $product->shop_type >= 1 ? $product->pro_minsale : 1; ?>
                            <span class="">Số lượng:</span>
                            <span class="qty_group" id="mes_<?php echo $product->pro_id; ?>">
                            <span class="sub-qty" title="Bớt" onclick="update_qty(<?php echo $product->pro_id; ?>, -1);"><i class="fa fa-minus"></i></span>
                            <input id="qty_<?php echo $product->pro_id; ?>" name="qty" onkeypress="return isNumberKey(event)" autofocus="autofocus" autocomplete="off"
                                   type="text" min="1" max="9999" class="inpt-qty" required="" value="<?php echo $pty_min; ?>" title="">
                            <span class="add-qty" title="Thêm" onclick="update_qty(<?php echo $product->pro_id; ?>, 1);"><i class="fa fa-plus"></i></span>
                            </span>
                            
                            <?php
                                if(in_array($product->pro_id, $favorite)){
                                ?>
                                    <a href="#wishlist" onclick="delheart(<?php echo $product->pro_id ?>);" class="pull-right delheart_<?php echo $product->pro_id ?>" title="Bỏ thích">
                                        <i class="fa fa-heartbeat"style="color: #f00"></i> Đã thích
                                    <a href="#wishlist" onclick="wishlist(<?php echo $product->pro_id ?>);" class="pull-right addheart_<?php echo $product->pro_id ?> hidden" title="Thêm vào yêu thích">
                                        <i class="fa fa-heart-o"></i> Yêu thích
                                    </a>
                                <?php } else{ ?>
                                    <a href="#wishlist" onclick="wishlist(<?php echo $product->pro_id ?>);" class="pull-right addheart_<?php echo $product->pro_id ?>" title="Thêm vào yêu thích">
                                        <i class="fa fa-heart-o"></i> Yêu thích
                                    </a>
                                    <a href="#wishlist" onclick="delheart(<?php echo $product->pro_id ?>);" class="pull-right delheart_<?php echo $product->pro_id ?> hidden" title="Bỏ thích">
                                        <i class="fa fa-heartbeat" style="color: #f00"></i> Đã thích
                                    </a>
                            <?php } ?>
                            
                        </div>
                        <br/>
                        <div id="bt_<?php echo $product->pro_id; ?>"
                             class="add_to_cart_button set_in_footer cart_db">

                            <div class="btn-group btn-group-justified">
                                <div class="btn-group" role="group">
                                    <button onclick="addCartQty(<?php echo $product->pro_id; ?>);" style="background: #585858; color: #fff;" type="button" class="btn btn-lg addToCart addToCart_detail"><i class="fa fa-cart-plus"></i>&nbsp;Thêm vào giỏ
                                    </button>
                                </div>
                                <div class="btn-group" role="group">
                                    <button onclick="buyNowQty(<?php echo $product->pro_id; ?>);" title="" type="button" class="btn btn-lg wishlist buyNow_detail"><i class="fa fa-check-square-o"></i>&nbsp;Mua ngay
                                    </button>
                                </div>

                            </div> 

                            <input type="hidden" name="product_showcart" id="product_showcart"
                                   value="<?php echo $product->pro_id; ?>"/>
                            <input type="hidden" name="af_id" value="<?php echo $af_id; ?>"/>
                            <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->id; ?>"/>
                            <input type="hidden" name="qty_min" id="qty_min" value="<?php echo $pty_min; ?>"/>
                            <input type="hidden" name="qty_max" id="qty_max" value="<?php echo $product->pro_instock; ?>"/>
                            <input type="hidden" name="fl_id" id="fl_id" value="<?php echo $head_footer->fl_id; ?>" />
                        </div>

                        <!-- Tạm hết hàng -->
                        <div id="bt_hethang_<?php echo $product->pro_id; ?>" class="btn-hethang hidden">
                            <button title="Hết hàng" id="buynow-login" class="btn btn-danger sm" type="button">
                                Tạm hết hàng
                            </button>
                            <?php
                                if(in_array($product->pro_id, $favorite)){
                                ?>
                                    <a href="#wishlist" onclick="delheart(<?php echo $product->pro_id ?>);" class="btn btn-default delheart_<?php echo $product->pro_id ?>" title="Bỏ thích">
                                        <i class="fa fa-heartbeat"></i>
                                    <a href="#wishlist" onclick="wishlist(<?php echo $product->pro_id ?>);" class="btn btn-default addheart_<?php echo $product->pro_id ?> hidden" title="Thêm vào yêu thích">
                                        <i class="fa fa-heart-o"></i>
                                    </a>
                                <?php } else{ ?>
                                    <a href="#wishlist" onclick="wishlist(<?php echo $product->pro_id ?>);" class="btn btn-default addheart_<?php echo $product->pro_id ?>" title="Thêm vào yêu thích">
                                        <i class="fa fa-heart-o"></i>
                                    </a>
                                <a href="#wishlist" onclick="delheart(<?php echo $product->pro_id ?>);" class="btn btn-default delheart_<?php echo $product->pro_id ?> hidden" title="Bỏ thích">
                                        <i class="fa fa-heartbeat"></i>
                                    </a>
                            <?php } ?>
                            
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
                            <?php
                                if(in_array($product->pro_id, $favorite)){
                                ?>
                                    <a href="#wishlist" onclick="delheart(<?php echo $product->pro_id ?>);" class="btn btn-default delheart_<?php echo $product->pro_id ?>" title="Bỏ thích">
                                        <i class="fa fa-heartbeat"></i>
                                    <a href="#wishlist" onclick="wishlist(<?php echo $product->pro_id ?>);" class="btn btn-default addheart_<?php echo $product->pro_id ?> hidden" title="Thêm vào yêu thích">
                                        <i class="fa fa-heart-o"></i>
                                    </a>
                                <?php } else{ ?>
                                    <a href="#wishlist" onclick="wishlist(<?php echo $product->pro_id ?>);" class="btn btn-default addheart_<?php echo $product->pro_id ?>" title="Thêm vào yêu thích">
                                        <i class="fa fa-heart-o"></i>
                                    </a>
                                <a href="#wishlist" onclick="delheart(<?php echo $product->pro_id ?>);" class="btn btn-default delheart_<?php echo $product->pro_id ?> hidden" title="Bỏ thích">
                                        <i class="fa fa-heartbeat"></i>
                                    </a>
                            <?php } ?>
                            <input type="hidden" name="product_showcart"
                                   value="<?php echo $product->pro_id; ?>"/>
                            <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->id; ?>"/>
                        </div>
                    <?php } ?>
                </div> 
            </div>

            <div class="row">        
                <div class="col-sm-12 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Mô tả sản phẩm
                        </div>
                        <div class="panel-body">
                            <?php echo htmlspecialchars_decode(html_entity_decode(str_replace("&curren;", "#", $product->pro_detail))); ?>
                        </div>
                    </div>
                </div>        
            </div>
        </div>        
        <?php } ?>
        <div class="col-sm-4 col-xs-12"> 
            <div class="panel panel-default">
                <div class="panel-heading"> <?php echo $typesp?> khác cùng gian hàng</div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                        foreach ($same_store_products as $products) {
                            $afSelect = false;
                            $discount = lkvUtil::buildPrice($products, $this->session->userdata('sessionGroup'), $afSelect);
                            ?>
                            <div class="col-xs-6">
                                <?php $this->load->view('flatform/coupons/product-item', array('product' => $products, 'discount' => $discount)); ?>
                            </div>                      
                        <?php } ?>
                    </div>
                </div>
            </div>
<!--            <div class="panel panel-default">
                <div class="panel-heading">Cùng danh mục</div>
                <div class="panel-body">
                    <div class="row">
                        <?php
                        foreach ($same_category_products as $products) {
                            $afSelect = false;
                            $discount = lkvUtil::buildPrice($products, $this->session->userdata('sessionGroup'), $afSelect);
                            ?>
                            <div class="col-xs-12">
                                <?php $this->load->view('flatform/coupons/product-item', array('product' => $products, 'discount' => $discount)); ?>
                            </div>                      
                        <?php } ?>
                    </div>                    
                </div>
            </div>-->
        </div>
    </div>
</div>

</div>
<script>
    $('.owl-carousel').owlCarousel({
        loop: false, nav: false, dots: true,
        margin: 0, navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        items: 1
    })
</script>


<!-- GUI BAO CAO SAN PHAM -->

<?php if($this->session->userdata('sessionUser') > 0) { ?>
<link type="text/css" rel="stylesheet" href="/templates/home/js/jAlert-master/jAlert-v3.css"/> 
<script async src="/templates/home/js/jAlert-master/jAlert-v3.min.js"></script>
<script async src="/templates/home/js/jAlert-master/jAlert-functions.min.js"></script>

<div class="modal fade" id="reportdetailModal" tabindex="-1" role="dialog" aria-labelledby="reportdetailModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="frmReport" name="frmReport" action="/home/flatform/report" method="post" class="form" enctype="multipart/form-data">
            <input type="hidden" name="sho_name" id="" value="<?php echo $shop_pro->sho_name ?>">
            <input type="hidden" name="sho_link" id="" value="<?php echo $protocol.$_SERVER['SERVER_NAME'].'/flatform/product'; ?>">
            <input type="hidden" name="pro_link" id="" value="<?php echo $protocol.$_SERVER['SERVER_NAME'].'/flatform/'. $linkt .'/'. $product->pro_id .'/'. RemoveSign($product->pro_name); ?>">
            <input type="hidden" name="pro_name" id="" value="<?php echo $product->pro_name ?>">
            <input id="reportpost" name="pro_id" type="hidden" value="<?php echo $product->pro_id ?>">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="reportModalLabel">Gửi báo cáo sản phẩm này</h4>
            </div>
            <div class="modal-body">
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

<?php $this->load->view('flatform/common/footer'); ?>

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
            $('#mausac_1').addClass('actived');
            $('#kichthuoc_1').addClass('actived');
            $('#chatlieu_1').addClass('actived');
        }
        $('#_selected_color').val($('#mausac_1').text());
    });

    function SelectProSales(siteUrl, id) {
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
                url: "<?php echo getAliasDomain(); ?>" + "home/product/select_style_pro_1?id=" + pro_id + "&color=" + a,
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
                        $("#qty_" + pro_id).val('1');
                        sl_color = name;
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
                            $("#cost-save").text(money_save + '');
                            $("#cost-save-af").text(money_save_af + ' vnđ');
                            $("#bt_hethang_" + pro_id).addClass('hidden');
                            $("#_selected_size").val("");
                            $("#_selected_material").val("");
                            $("span.st_size_value").text("");
                            $("span.st_material_value").text("");
                            $('#_selected_color').val($('#mausac_' + no).text());
                            $(".qty_row").removeClass('hidden');
                            $("#bt_" + pro_id).removeClass('hidden');
                            $("#carousel-ligghtgallery .owl-item.active .item img").attr("src", function () {
                                return "<?php echo getAliasDomain() . 'media/images/product/'; ?>" + result.pro_dir + "/" + result.pro_images;
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
                            if (result.ar_size != '') {
                                $('.list_ar_size').load("<?php echo getAliasDomain(); ?>" + "home/product/load_size?pro_id=" + pro_id + "&color=" + name, function (response, status, xhr) {
                                    if (status == 'error') {
                                        alert("Load was error.");
                                    } else {
                                        $('.st_size_value').text('');
                                        $('.st_material_value').text('');
                                    }
                                });
                            } else {
                                $('#_selected_size').val('');
                                $('.list_ar_material').load("<?php echo getAliasDomain(); ?>" + "home/product/load_chatlieu?pro_id=" + pro_id + "&color=" + name, function (response, status, xhr) {
                                    if (status == 'error') {
                                        alert("Load was error.");
                                    } else {
                                        var text = $('#chatlieu_1').text();
                                        if (text != '') {
                                            $("#ar_material").removeClass('hidden');
                                        }
                                        $('.st_material_value').text('');
                                    }
                                });
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

    function ClickSize(name, no) {
        var b = $('#st_size_' + name).val();
        if (b) {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "<?php echo getAliasDomain(); ?>" + "home/product/product_style_azibai",
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
                        $("#qty_" + pro_id).val('1');
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
                                $("#show-cost").text(money + ' Vnđ');
                                $("#cost-save").text(money_save + ' Vnđ');
                                $("#cost-save-af").text(money_save_af + ' Vnđ');
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
        $('.st_size_value').html(b);

        $('.list_ar_material').load("<?php echo getAliasDomain(); ?>" + "home/product/load_chatlieu?pro_id=" + pro_id + "&color=" + sl_color + "&size=" + name, function (response, status, xhr) {
            if (status == 'error') {
                alert("Load was error.");
            } else {
                var text = $('#chatlieu_1').text();
                if (text != '') {
                    $("#ar_material").removeClass('hidden');
                }
                $('.st_material_value').text('');
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
                url: "<?php echo getAliasDomain(); ?>" + "home/product/product_style_azibai",
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
                        $("#qty_" + pro_id).val('1');
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
                            $("#show-cost").text(money + ' Vnđ');
                            $("#cost-save").text(money_save + ' Vnđ');
                            $("#cost-save-af").text(money_save_af + ' Vnđ');
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
        $('.imagepro').load("<?php echo getAliasDomain(); ?>" + "home/product/slide_img?arr_img=" + str + '&dir_img=' + pro_dir, function (response, status, xhr) {
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
        console.log('str_price: '+str_price);
        console.log('str_off_amount: '+str_off_amount);
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
                    $("#cost-save").text(money_save + '');
                    $("#cost-save-af").text(money_save_af + ' vnđ');
                    $("#qty_max").val(arr_max[index]);
                    $("#dp_id").val(id[index]);
                }
            });
        }
    }

</script>


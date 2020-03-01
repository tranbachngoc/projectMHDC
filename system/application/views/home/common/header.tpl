<!DOCTYPE html>
<html lang="vi">
<!--<html xmlns="https://www.w3.org/1999/xhtml" xmlns:og="https://ogp.me/ns#" xmlns:fb="https://www.facebook.com/2008/fbml" itemscope="itemscope" itemtype="https://schema.org/NewsArticle">-->
<head>
<!--<head  prefix="og: https://ogp.me/ns# fb: https://ogp.me/ns/fb# article: https://ogp.me/ns/article#">-->

		
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta charset="UTF-8" />
    <meta name="alexaVerifyID" content="J_mnEtPUDglQ039W2oyKZBA5lws"/>
    <meta name="google-site-verification" content="2I2JANiiw42OZIbSWLtSDOMruRC-XYvKdxn3w8xPWfQ"/>
    <meta name="revisit-after" content="1 days"/>
    <meta name="description" content="<?php echo $descrSiteGlobal ? $descrSiteGlobal : settingDescr; ?>"/>
    <meta name="keywords" content="<?php echo isset($keywordSiteGlobal) && $keywordSiteGlobal ? str_replace(',', ' |', $keywordSiteGlobal) : settingKeyword; ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="<?php echo $ogtype; ?>"/>    
    <!--<meta prefix="fb: https://ogp.me/ns/fb#" property="fb:app_id" content="<?php echo app_id ?>" />-->
    <meta property="fb:app_id" content="<?php echo app_id ?>" />
    <meta property="og:url" content="<?php echo $ogurl; ?>"/>
    <meta property="og:title" content="<?php echo $ogtitle ? $ogtitle : settingTitle; ?>"/>
    <meta property="og:description" content="<?php echo $ogdescription ? $ogdescription : settingDescr; ?>"/>
    <meta property="og:image" content="<?php echo isset($ogimage) && $ogimage ? $ogimage : site_url('templates/home/images/logoshare.jpg'); ?>"/>
  
<meta property="al:android:url" content="sharesample://store/apps/details?id=com.azibai.android">
    <meta property="al:android:package" content="com.azibai.android">
    <meta property="al:android:app_name" content="Azibai">
    <meta property="og:title" content="Azibai" />
    <meta property="og:type" content="website" />
    <meta property="fb:app_id" content="2008923082654757" />
    <meta property="al:ios:url" content="https://azibai.com" />
    <meta property="al:ios:app_name" content="azibai" />
    <meta property="al:ios:app_store_id" content="1284773842" />
    <meta property="al:web:should_f" allback content="false"/>

    <!-- <meta http-equiv="refresh" content="0;url=https://itunes.apple.com/WebObjects/MZStore.woa/wa/redirectToContent?id=1284773842" /> -->    
    <title>
        <?php if (isset($titleSiteGlobal)) {
            echo $this->lang->line('title_detail_header') . $titleSiteGlobal;
        } else {
            echo settingTitle;
        } ?> 
    </title>
    <link type="text/css" rel="stylesheet" href="/templates/home/css/bootstrap.css"/>
    <link type="text/css" rel="stylesheet" href="/templates/home/css/style-azibai.css"/>
    <link type="text/css" rel="stylesheet" href="/templates/home/css/newsfeed.css"/>
    <link type="text/css" rel="stylesheet" href="/templates/home/css/font-awesome.min.css"/>
    <link type="text/css" rel="stylesheet" href="/templates/home/css/select2.min.css"/>
    <link type="text/css" rel="stylesheet" href="/templates/home/css/select2-bootstrap.min.css"/>
    <link type="text/css" rel="stylesheet" href="/templates/home/js/jAlert-master/jAlert-v3.css"/>    
    <script  src="/templates/home/js/jquery.min.js"></script>
    <script  src="/templates/home/js/jquery-migrate-1.2.1.js"></script>
    <script  src="/templates/home/js/select2.full.min.js"></script>
    <script  src="/templates/home/js/lang/vi.js"></script>
    <script  src="/templates/home/js/general.js"></script>
    <script  src="/templates/home/js/jAlert-master/jAlert-v3.min.js"></script>
    <script  src="/templates/home/js/jAlert-master/jAlert-functions.min.js"></script>
    <script  src="/templates/home/js/bootbox.min.js"></script>
    <script  src="/templates/home/js/js-azibai-tung.js"></script>
    <script  src="/templates/home/js/jquery.dcverticalmegamenu.1.3.js"></script>
    <script  src="/templates/home/js/jquery.autocomplete.js"></script>
    <script  src="/templates/home/js/jquery.validate.js"></script>
    <script  src="/templates/home/js/bootstrap.min.js"></script>
    <?php
    $sec1 = $this->uri->segment(1);
    $sec2 = $this->uri->segment(2);
    $sec3 = $this->uri->segment(3);
    $productDetail = false;
    $adsDetail = false;
    $raovatDetail = false;
    $default = false;
    if (is_numeric($sec2) && is_numeric($sec3)) {
        if ($sec1 == 'raovat') {
            $raovatDetail = true;
        }
        if ($sec1 == 'hoidap') {
            $hoidapDetail = true;
        }
    }
    if ($sec1 == '') {
        $default = true;
    }
    ?>
    <?php if ((is_numeric($this->uri->segment(1)) && is_numeric($this->uri->segment(2)))) { ?>
        <link type="text/css" rel="stylesheet" href="/templates/home/css/slimbox.css" media="screen"/>
        <link type="text/css" rel="stylesheet" href="/templates/home/css/tabview_detail.css"/>
        <script  src="/templates/home/js/check_email.js"></script>
        <script >
            //<![CDATA[
            jQuery(document).ready(function () {
                var widthScreen = jQuery(window).width();
                if (widthScreen <= 1024) {
                    jQuery('.info_view_detail table').css('width', '100%');
                    jQuery('#product-detail-payment').css('float', 'left');
                }
                <?php if ($product->pro_show == 1) { ?>
                jQuery('.colorbox').colorbox({rel: 'colorbox'});
                <?php } ?>
                jQuery('.image_boxpro').mouseover(function () {
                    tooltipPicture(this, jQuery(this).attr('id'));
                });
            });
        </script>
        <style>
            .sub_cateory_bgrum {
                margin-left: 0px !important;
            }
        </style>
    <?php } ?>

    <?php if ($default) { ?>
        <script  src="/templates/home/js/tabview.js"></script>
        <script  src="/templates/home/js/ajax.js"></script>

        <script  src="/templates/home/js/simplegallery.js"></script>
        <script  src="/templates/home/js/validator.js"></script>
        <link type="text/css" rel="stylesheet" href="/templates/home/css/move/views-home-defaults-defaults.css"/>
    <?php } ?>
        
    <link rel="stylesheet" type="text/css" href="/templates/home/css/jquery.autocomplete.css" media="screen"/>
    <link rel="stylesheet" type="text/css" href="/templates/home/css/hint.css" media="screen"/>
    
    <script >
        function autoCompleteSearch(type) {
            jQuery("#singleBirdRemote").autocomplete("/autocomplete/type/" + type, {
                width: 500,
                selectFirst: false
            }).result(function (event, item, formatted) {
                qSearch('<?php echo base_url(); ?>');
            });
        }        
    </script>
    <script >
        <?php
        $id = $this->uri->segment(6);
        $type = $this->uri->segment(1);
        $type_in_search = $this->uri->segment(2);
        ?>
        jQuery(document).ready(function ($) {
            getCategory4Search('<?php echo base_url(); ?>', '<?php echo $id; ?>');
        });
    </script>
    <?php
    if (!class_exists('utilSlv')) {
        $this->load->library('utilSlv');
    }
    $util = utilSlv::getInstance();
    $sHeader = $util->getData();
    ?>
    <script >
        <?php echo $sHeader['config']; ?>
    </script>
    <?php if ($sHeader['inline_script'] != ''): ?>
        <script >
            <?php echo $sHeader['inline_script']; ?>
        </script>
    <?php endif; ?>
    <?php foreach ($sHeader['scripts'] as $script): ?>
        <script  src="<?php echo $script; ?>"></script>
    <?php endforeach; ?>
    <script >
        // Ajax post
        function Delloginhistory(id) {
            confirm(function (e, btn) { //event + button clicked
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "/" + "home/eye/delete_eye",
                    cache: false,
                    data: {id: id},
                    success: function (data) {
                        if (data == '1') {
                            $("#proid_" + id).css("display", "none");
                        } else {
                            alert('Xóa không thành công...');
                        }
                    }
                });
            });
        }
        // Ajax post
        function DellAllogin() {
            confirm(function (e, btn) { //event + button clicked
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "/home/eye/delete_all",
                    cache: false,
                    success: function (data) {
                        if (data == '1') {
                            $(".row_tab_content, #delete_all_history").css("display", "none");
                        } else {
                            alert('Xóa không thành công...');
                        }
                    }
                });
            });
        }
        // Delete All no login
        function DeleteAllnologin() {
            confirm(function (e, btn) { //event + button clicked
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "/home/eye/delete_all_no_login",
                    cache: false,
                    data: {type: 1},
                    success: function (data) {
                        $(".row_tab_content, #delete_all_history").css("display", "none");
                    }
                });
            });
        }
        // Delete All no login
        function DeleteNologin(id) {
            confirm(function (e, btn) { //event + button clicked
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "/home/eye/delete_eye_no_login",
                    cache: false,
                    data: {id: id, type: 'product'},
                    success: function (data) {
                        if (data == '1') {
                            $("#proid_" + id).css("display", "none");
                        } else {
                            alert('Xóa không thành công...');
                        }
                    },
                    error: function (data) {
                        alert('Xóa không thành công...');
                    }
                });
            });
        }
        // DeleteFavorite
        function DeleteFavorite(id) {
            confirm(function (e, btn) { //event + button clicked
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "/home/defaults/Delete_Fav",
                    cache: false,
                    data: {id: id},
                    success: function (data) {
                        if (data == '1') {
                            $("#proid_" + id).css("display", "none");
                        } else {
                            alert('Xóa không thành công...');
                        }
                    }
                });
            });
        }
        // DeleteFavorite
        function DeleteAllFav() {
            confirm(function (e, btn) { //event + button clicked
                e.preventDefault();
                $.ajax({
                    type: "post",
                    url: "/home/defaults/Delete_allFav",
                    cache: false,
                    success: function (data) {
                        if (data == '1') {
                            $(".row_tab_content, #delete_all_history").css("display", "none");
                        } else {
                            alert('Xóa không thành công...');
                        }
                    }
                });
            });
        }
    </script>   

    <script  src="<?php echo base_url(); ?>templates/home/js/jquery.scrollTo.js"></script>
    <script >
        <?php if ($this->uri->segment(1) != 'checkout') { ?>
        jQuery(window).scroll(function () {
            var height = jQuery(window).scrollTop();
            if (height > 500) {
                jQuery('#btn_toolbox_right').addClass('btn_fixed');
            } else {
                jQuery('#btn_toolbox_right').removeClass('btn_fixed');
            }
        });
        <?php } ?>
        //<![CDATA[
        jQuery(document).ready(function () {
            // placeholder
            var placeholders = document.querySelectorAll('input[placeholder]');
            if (placeholders.length) {
                placeholders = Array.prototype.slice.call(placeholders);
                var div = jQuery('<div id="placeholders" style="display:none;"></div>');
                placeholders.forEach(function (input) {
                    var text = input.placeholder;
                    div.append('<div>' + text + '</div>');
                });
                jQuery('body').append(div);
                var originalPH = placeholders[0].placeholder;
                setInterval(function () {
                    if (isTranslated()) {
                        updatePlaceholders();
                        originalPH = placeholders[0].placeholder;
                    }
                }, 500);
                function isTranslated() { // true if the text has been translated
                    var currentPH = jQuery(jQuery('#placeholders > div')[0]).text();
                    return !(originalPH == currentPH);
                }

                function updatePlaceholders() {
                    jQuery('#placeholders > div').each(function (i, div) {
                        placeholders[i].placeholder = jQuery(div).text();
                    });
                }
            }
        });
        //]]
    </script>
</head>

<?php
///$dmWeb = '';
$strUrl = base_url();
$sub = explode('.', $_SERVER['HTTP_HOST']);
if (count($sub) === 3) {
    $shopname = $sub[0];
    $strUrl = str_replace('//' . $shopname . '.', '//', $strUrl);
}
?>
<body>
<div id="all">
    <div id="header">
        <div id="panel">
            <div class="toggle">
                <button id="btn_close" type="button" class="hidden-lg btn btn-default"><i class="fa fa-times"></i>
                </button>
                <div class="container-fluid" style="padding:30px">
                    <div class="row">
                        <div class="col-lg-3 col-md-3 text-left">
                            <div class="follow-azibai" style="padding:10px 0">Kết nối: <a
                                    href="<?php echo socialFacebook; ?>"><i class="fa fa-facebook fa-fw "></i></a> <a
                                    href="<?php echo socialTwitter; ?>"><i class="fa fa-twitter fa-fw "></i></a> <a
                                    href="<?php echo socialGooglePlus; ?>"><i class="fa fa-google-plus fa-fw "></i></a>
                                <a href="<?php echo socialLinkedin; ?>"><i class="fa fa-linkedin fa-fw"></i></a> <a
                                    href="<?php echo socialYoutube; ?>"><i class="fa fa-youtube fa-fw"></i></a> <a
                                    href="<?php echo socialIntergram; ?>"><i class="fa fa fa-instagram fa-fw"></i></a>
                                <a href="<?php echo socialPinterest; ?>"><i class="fa fa fa-pinterest fa-fw"></i></a> <a
                                    href="<?php echo socialVimeo; ?>"><i class="fa fa fa-vimeo fa-fw"></i></a> <a
                                    href="<?php echo socialTumblr; ?>"><i class="fa fa fa-tumblr fa-fw"></i></a></div>
                        </div>
                        <div class="col-lg-3 col-md-3">

                        </div>
                        <div class="col-lg-6 col-md-6 text-right">
                            <div class="login-azibai" style="padding:10px 0">
                                <?php
                                if ($azitab['user']->use_id > 0) {
                                    ?>
                                    <a href="/account"><img height="16"
                                                            src="<?php echo base_url(); ?>images/icon-72/1_30.gif"
                                                            alt="icon-72/1_30.gif"> <?php echo $this->session->userdata('sessionUsername'); ?>
                                    </a><a href="/logout">| <i class="fa fa-sign-out"></i>
                                        Thoát</a>

                                <?php } else { ?>
                                    <form action="/login" name="frmLogin" method="post"
                                          id="frmLogin" class="form-inline" role="form">
                                        <div class="input-group">
					    <span class="input-group-addon">
						<img height="16"
                                                    src="<?php echo base_url(); ?>images/icon-72/1_30.gif"
                                                    alt="icon-72/1_30.gif">
					    </span>
                                            <input placeholder="Tài khoản đăng nhập" type="text" name="UsernameLogin"
                                                   id="UsernameLogin" maxlength="35" class="input-sm form-control"
                                                   onkeyup="BlockChar(this, 'AllSpecialChar')"
                                                   onfocus="ChangeStyle('UsernameLogin', 1)"
                                                   onblur="ChangeStyle('UsernameLogin', 2);
                                                                       lowerCase(this.value, 'UsernameLogin');"/>
                                        </div>
                                        <p class="hidden-lg"></p>
                                        <div class="input-group"><span class="input-group-addon"><img height="16"
                                                                                                      src="<?php echo base_url(); ?>images/icon-72/1_31.gif"
                                                                                                      alt=""></span>
                                            <input placeholder="Mật khẩu" type="password" name="PasswordLogin"
                                                   id="PasswordLogin" maxlength="35" class="input-sm form-control"
                                                   onfocus="ChangeStyle('PasswordLogin', 1)"
                                                   onblur="ChangeStyle('PasswordLogin', 2);"/>
                                        </div>
                                        <p class="hidden-lg"></p>
                                        <input type="submit" onclick="CheckInput_Login_Form();" name="submit_login"
                                               value="Đăng nhập" class="btn btn-primary input-sm"/>
                                    </form>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 text-left"><span style="color: #39f; font-weight:bold">Hỗ trợ khách hàng:</span>
                            Thứ 2 - Thứ 7 8:00 pm -&gt; 6:00 am (GTM+7)
                        </div>
                        <div class="col-lg-6 col-md-6 text-right register-header">
                            <?php if ($azitab['user']->use_id <= 0) { ?>
                                <a href="/register/affiliate"><i class="fa fa-link"></i> Đăng ký
                                    Cộng tác viên online </a>
                                <a href="/discovery"><i class="fa fa-shopping-bag"></i> Mở Gian
                                    hàng </a>
                                <a href="/register"><i class="fa fa-key fa-fw"></i> Đăng ký
                                    thành viên</a>
                            <?php } ?>
                            <a href="<?php echo $strUrl; ?>checkout"><i class="fa fa-shopping-cart fa-fw"></i>
                                Giỏ hàng &nbsp;<span class="cartNum badge"><?php echo $azitab['cart_num']; ?></span></a>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-3 col-md-3">
                            <h4>DÀNH CHO NGƯỜI BÁN</h4>
                            <ul class="list-unstyled">
                                <li><a href="/discovery">Mở Gian hàng trên Azibai</a></li>
                                <li><a href="/register/affiliate">Đăng ký Cộng tác viên online</a></li>
                                <li><a href="/content/391">Qui định đối với người bán</a></li>
                                <li><a href="/content/393">Hệ thống tiêu chí kiểm duyệt</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <h4>DÀNH CHO NGƯỜI MUA</h4>
                            <ul class="list-unstyled">
                                <li><a href="/register">Đăng ký tài khoản mua hàng</a></li>
                                <li><a href="/content/57">Hướng dẫn mua hàng</a></li>
                                <li><a href="/content/320">Chính sách bảo vệ người mua</a></li>
                                <li><a href="/content/390">Giải quyết khiếu nại</a></li>
                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <h4>VỀ CHÚNG TÔI</h4>
                            <ul class="list-unstyled">
                                <li><a href="/content/5"> Giới thiệu azibai</a></li>
                                <li><a href="/content/394"> Quy chế hoạt động</a></li>
                                <li><a href="/content/395"> Các mức chế tài vi phạm</a></li>
                                <li>Hotline: <?php echo HOTLINE ?> hoặc gửi liên hệ <a
                                        href="/contact"> Tại đây</a></li>

                            </ul>
                        </div>
                        <div class="col-lg-3 col-md-3">
                            <h4>THÔNG TIN LIÊN HỆ</h4>
                            <ul class="list-unstyled">
                                <li><i class="fa fa-map-marker fa-fw"></i><?php echo settingAddress_1; ?></li>
                                <li><i class="fa fa-phone fa-fw"></i><?php echo settingPhone; ?></li>
                                <li><i class="fa fa-envelope-o fa-fw"></i><?php echo settingEmail_1; ?></li>
                                <li><i class="fa fa-copyright fa-fw"></i><?php echo settingCopyright; ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--<a id="clicktonggle" class="down"></a>-->
	    
        </div>


        <?php if (!$default) { ?>
            <a id="btn_toolbox_right" class="hidden" href="#">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </a>
        <?php } ?>

        <div class="popupright" id="popup1">
            <img class="arrow" src="<?php echo base_url(); ?>templates/home/images/untitled-2.png" alt="arrow"/>
            <div class="container">
                <a class="closepopup"><i class="fa fa-times-circle "></i></a>
                <h4 class="text-uppercase">Danh mục sản phẩm</h4>
                <hr/>
                <div class="row">
                    <?php foreach ($azitab['categories'] as $category) : ?>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <a href="<?php echo "/" . $category->cat_id . "/" . RemoveSign($category->cat_name); ?>">
                                <?php if ($category->cate_type == 1) { ?>
                                    <img src="<?php echo base_url() . 'images/icon/icon-service.png' ?>" alt="<?php echo $category->cat_name ?>"/>
                                <?php } elseif ($category->cate_type == 2) { ?>
                                    <img src="<?php echo base_url() . 'images/icon/icon-coupon.png' ?>" alt="<?php echo $category->cat_name ?>"/>
                                <?php } else { ?>
                                    <img src="<?php echo base_url() . 'images/icon/icon' . $category->cat_id . '.png' ?>" alt="<?php echo $category->cat_name ?>"/>
                                <?php } ?>
                                <?php echo $category->cat_name; ?> </a></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
        <div class="popupright" id="popup2">
            <div class="container">
                <a class="closepopup"><i class="fa fa-times-circle "></i></a>
                <div class="tabsright">
                    <!-- Nav tabs -->
                    <ul id="tab_header2" class="nav nav-tabs" role="tablist">
			<li class="active">
			    <a href="#news" role="tab" title="Tin tức" data-toggle="tab">
				<img src="<?php echo base_url(); ?>images/icon-72/1_22.gif" alt="Tin tức"/>
			    </a>
			</li>
			<li>
			    <a href="#home" role="tab" title="Gợi ý ăn gì" data-toggle="tab">
				<img src="<?php echo base_url(); ?>images/icon-72/1_33.gif" alt="ăn gì"/>
			    </a>
			</li>
			<li>
			    <a href="#play" role="tab" title="Gợi ý chơi gì" data-toggle="tab">
				<img src="<?php echo base_url(); ?>images/icon-72/1_34.gif" alt="chơi gì"/>
			    </a>
			</li>
			<li>
			    <a href="#download" role="tab" title="Gợi ý mua gì" data-toggle="tab">
				<img src="<?php echo base_url(); ?>images/icon-72/1_21.gif" alt="mua gì"/>
			    </a>
			</li>
			<li>
			    <a href="#where" role="tab" title="Ở đâu" data-toggle="tab">
				<img src="<?php echo base_url(); ?>images/icon-72/1_35.gif" alt="Ở đâu"/>
			    </a>
			</li>
			<li>
			    <a href="#historied" role="tab" title="Lịch sử" data-toggle="tab">
				<img
				    src="<?php echo base_url(); ?>images/icon-72/1_36.gif" alt="Lịch sử"/>
			    </a></li>
			    <?php if ($azitab['user']->use_id > 0): ?>
    			<li>
			    <a href="#favori" title="Hàng yêu thích" role="tab" data-toggle="tab">
    				<img src="<?php echo base_url(); ?>images/icon-72/1_37.gif" alt="Yêu thích"/>
    			    </a>
    			</li>
			<?php endif; ?>
			<li>
			    <a href="#cart" role="tab" title="Giỏ hàng" data-toggle="tab">
				<img src="<?php echo base_url(); ?>images/icon-72/1_20.gif" alt="Giỏ hàng"/>
			    </a>
			</li>
		    </ul>
                    <!-- Tab panes -->
                    <div id="tab_content_header2" class="tab-content">
                        <div class="tab-pane fade active in" id="news">
                            <h2>Tin tức</h2>
                            <div class="row_tab_content">
                                <?php foreach ($azitab['listNews'] as $item) {
                                    ?>
                                    <div class="item_pro_asign">
                                        <a class="text-primary"
                                           href="<?php echo "/" . 'tintuc/detail/' . $item->not_id . '/' . RemoveSign($item->not_title); ?>"
                                           target="_blank">
                                            <?php
                                            $fileimg = 'media/images/tintuc/' . $item->not_dir_image . '/' . $item->not_image;
                                            if ($item->not_image != "" && file_exists($fileimg)) {
                                                ?>
                                                <img width="80"
                                                     src="<?php echo base_url() . 'media/images/tintuc/' . $item->not_dir_image . '/' . $item->not_image; ?>"
                                                     alt="<?php echo $pro->pro_name ?>"/>
                                            <?php } else { ?>
                                                <img src="<?php echo base_url() . 'images/img_not_available.png' ?>"
                                                     alt="<?php echo $pro->pro_name ?>"/>
                                            <?php } ?>
                                            <?php echo $item->not_title; ?>
                                            <p class="text-default"><b>Ngày đăng: <?php echo date('d-m-Y', $item->not_begindate); ?></b></p>
                                        </a>
                                    </div>
                                <?php } ?>
                                <div class="clearfix"></div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="tab-pane fade" id="home">
                            <h2>Gợi ý ăn gì</h2>
                            <div class="row_tab_content">
                                <?php
                                foreach ($azitab['suggestion_eat'] as $product) {
                                    $afSelect = false;
                                    $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                                    $this->load->view('home/product/pro_item', array('product' => $product, 'discount' => $discount));
                                }
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="play">
                            <h2>Gợi ý chơi gì</h2>
                            <div class="row_tab_content">
                                <?php
                                foreach ($azitab['suggestion_play'] as $product) {
                                    $afSelect = false;
                                    $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                                    $this->load->view('home/product/pro_item', array('product' => $product, 'discount' => $discount));
                                }
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane fade " id="download">
                            <h2>Gợi ý mua gì</h2>
                            <div class="row_tab_content">
                                <?php
                                foreach ($azitab['suggestion_buys'] as $product) {
                                    $afSelect = false;
                                    $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                                    $this->load->view('home/product/pro_item', array('product' => $product, 'discount' => $discount));
                                }
                                ?>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="where">
                            <h2>Ở đâu</h2>
                            <div class="row_tab_content">
                                <?php
                                foreach ($azitab['suggestion_place'] as $product) {
                                    $afSelect = false;
                                    $discount = lkvUtil::buildPrice($product, $this->session->userdata('sessionGroup'), $afSelect);
                                    $this->load->view('home/product/pro_item', array('product' => $product, 'discount' => $discount));
                                }
                                ?>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="historied">
                            <form method="post">
                                <h2>Lịch sử
                                    <?php if (count($listeyeproduct) > 0 && (int)$azitab['user']->use_id > 0) { ?>
                                        <div class="pull-right"><span id="delete_all_history" onclick="DellAllogin();"
                                                                      class="label label-warning">Xóa tất cả</span>
                                        </div>
                                    <?php } elseif (count($listeyeproduct) > 0 && (int)$azitab['user']->use_id <= 0) { ?>
                                        <div class="pull-right"><span id="delete_all_history"
                                                                      onclick="DeleteAllnologin();"
                                                                      class="label label-warning">Xóa tất cả</span>
                                        </div>
                                    <?php } ?>
                                </h2>
                                <div class="row_tab_content">
                                    <?php
                                    foreach ($listeyeproduct as $pro) {
                                        $img1 = explode(',', $pro->pro_image);
                                        ?>
                                        <div id="proid_<?php echo $pro->pro_id; ?>" class="item_pro_asign">
                                            <?php if ((int)$azitab['user']->use_id > 0) { ?>
                                                <i class="fa fa-times"
                                                   onclick="Delloginhistory(<?php echo $pro->pro_id; ?>);"></i>
                                            <?php } else { ?>
                                                <i class="fa fa-times"
                                                   onclick="DeleteNologin(<?php echo $pro->pro_id; ?>);"></i>
                                            <?php } ?>
                                            <a href="<?php echo "/" . $pro->pro_category . '/' . $pro->pro_id . '/' . RemoveSign($pro->pro_name); ?>"
                                               target="_blank">
                                                <?php
                                                $fileimg = 'media/images/product/' . $pro->pro_dir . '/' . $img1[0];
                                                if ($img1[0] != "" && file_exists($fileimg)) {
                                                    ?>
                                                    <img width="80"
                                                         src="<?php echo base_url() . 'media/images/product/' . $pro->pro_dir . '/' . $img1[0]; ?>"
                                                         alt="<?php echo $pro->pro_name ?>"/>
                                                <?php } else { ?>
                                                    <img width="80"
                                                         src="<?php echo base_url() . 'images/img_not_available.png' ?>"
							 alt="<?php echo $pro->pro_name ?>"/>
                                                <?php } ?>
                                                <?php echo $pro->pro_name; ?>
                                                <p class="text-danger">Giá bán:
                                                    <b><?php echo number_format($pro->pro_cost, 0, ',', '.') . 'VNĐ'; ?></b>
                                                </p>
                                            </a>
                                        </div>
                                    <?php } ?>
                                </div>
                            </form>
                        </div>
                        <?php if ($azitab['user']->use_id > 0): ?>
                            <div class="tab-pane fade" id="favori">
                                <form method="post">
                                    <h2>Hàng yêu thích
                                        <?php if (count($favoritePro) > 0) { ?>
                                            <div class="pull-right"><span id="delete_all_history"
                                                                          onclick="DeleteAllFav();"
                                                                          class="label label-warning">Xóa tất cả</span>
                                            </div>
                                        <?php } ?>
                                    </h2>
                                    <div class="row_tab_content">
                                        <?php
                                        foreach ($azitab['favoritePro'] as $pro) {
                                            $discount = lkvUtil::buildPrice($pro, $this->session->userdata('sessionGroup'), false);
                                            $img1 = explode(',', $pro->pro_image);
                                            ?>
                                            <div id="proid_<?php echo $pro->prf_id; ?>" class="item_pro_asign">
                                                <?php if ((int)$azitab['user']->use_id > 0) { ?>
                                                    <i class="fa fa-times"
                                                       onclick="DeleteFavorite(<?php echo $pro->prf_id; ?>);"></i>
                                                <?php } ?>
                                                <a href="<?php echo "/" . $pro->pro_category . '/' . $pro->pro_id . '/' . RemoveSign($pro->pro_name); ?>"
                                                   target="_blank">
                                                    <?php
                                                    $img = 'media/images/product/' . $pro->pro_dir . '/' . $img1[0];
                                                    if ($img1[0] != "" && file_exists($img)) {
                                                        ?>
                                                        <img width="80" src="<?php echo base_url() . $img; ?>" 
							     alt="<?php echo $pro->pro_name ?>"/>
                                                    <?php } else { ?>
                                                        <img width="80" src="<?php echo base_url() . 'images/img_not_available.png' ?>"
                                                             alt="<?php echo $pro->pro_name ?>">
                                                    <?php } ?>
                                                    <?php echo $pro->pro_name; ?>
                                                    <p class="text-danger">Giá bán:
                                                        <b><?php echo lkvUtil::formatPrice($discount['salePrice'], 'đ'); ?></b>
                                                    </p>
                                                </a>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                        <?php endif; ?>
                        <div class="tab-pane fade" id="cart">
                            <h2>Giỏ hàng</h2>
                            <div class="row_tab_content">
                                <?php
                                foreach ($azitab['cart_info'] as $product) {
                                    $this->load->view('home/product/cart_item', array('product' => $product));
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="popupright" id="popup3">

            <div class="container">
                <a class="closepopup"><i class="fa fa-times-circle "></i></a>
                <h4>Danh mục Tin tức</h4>
                <hr/>
                <div class="row">
                    <?php foreach ($azitab['categories'] as $category) : ?>
                        <div class="col-lg-4 col-md-4 col-sm-6"><a
                                href="<?php echo '/tintuc/' . $category->cat_id . "/" . RemoveSign($category->cat_name); ?>">
                                <img src="<?php echo base_url() . 'images/icon/icon' . $category->cat_id . '.png' ?>" alt="category icon"/> <?php echo $category->cat_name; ?>
                            </a></div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="popupright" id="popup4">

            <div class="container">
                <a class="closepopup"><i class="fa fa-times-circle "></i></a>
                <h4>Danh mục hot</h4>
                <hr/>
                <?php if (!empty($azitab['categories_hot'])): ?>
                    <div class="row hotcat">
                        <?php foreach ($azitab['categories_hot'] as $cat_hot): ?>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                <img class="img-responsive"
                                     src="<?php echo base_url() . 'templates/home/images/category/' . $cat_hot->cat_image; ?>" alt="category"/>
                                <a href="<?php echo "/" . $cat_hot->cat_id . '/' . RemoveSign($cat_hot->cat_name); ?>"><?php echo $cat_hot->cat_name; ?></a>
                                <?php if (!empty($cat_hot->subcat)): ?>
                                    <ul class="supcat">
                                        <?php foreach ($cat_hot->subcat as $subcat): ?>
                                            <li>
                                                <a href="<?php echo "/" . $subcat->cat_id . '/' . RemoveSign($subcat->cat_name); ?>"><?php echo $subcat->cat_name; ?></a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        <div class="popupright" id="popup5">
            <div class="container">

                <a class="closepopup"><i class="fa fa-times-circle "></i></a>
                <h4 class="text-uppercase">Kiểm tra đơn hàng</h4>
                <hr>
                <form action="/test-order" name="frmCheckOrder" method="post" id="frmCheckOrder" class="form" role="form"> 
                    <div class="form-group"> 
                        <label for="order_id">Mã đơn hàng</label> 
                        <input type="text" class="form-control input-lg" id="order_id" name="order_id" placeholder="Mã đơn hàng"> 
                    </div> 
                    <div class="form-group"> 
                        <label for="order_email">Email người nhận hàng</label> 
                        <input type="text" class="form-control input-lg" id="order_email" name="order_email" placeholder="Email người nhận hàng"> 
                    </div> 
                    <div class="form-group"> 
                        <button type="submit" style="" onclick="return checkOrderInput();" class="btn btn-primary btn-lg">Kiểm tra </button> 
                    </div> 
                </form>
            </div>
        </div>


    </div>
    <!--END HEADER-->
    
    
    

    <div id="header_news" class="row header_fixed hidden-xs">
	<div class="col-lg-2 col-md-3 col-sm-3 text-center">
	    <a href="<?php echo base_url() ?>">
		<img style="max-height: 34px;" class="img-responsive" src="/images/logo-azibai-white.png" alt="logo-azibai">
	    </a>
	</div>

	<div class="col-lg-5 col-md-4 col-sm-4">
	    <?php if ($this->uri->segment(1) == 'tintuc' || $this->uri->segment(1) == '') { ?>

		<form id="formsearch_home" name="formsearch_home" class="form-horizontal" action="<?php echo base_url() ?>tintuc/search" method="post">
		    <div class="input-group">
			<input name="keyword" id="keyword1" class="form-control" type="text" 
			       value="<?php echo isset($keyword) && $keyword ? $keyword : ''; ?>"
			       placeholder="Nhập từ khóa tìm kiếm"
			       onkeypress="return submitenterQ(this, event,'<?php echo base_url(); ?>')">
			    <div class="input-group-btn">
				<button type="submit"
				class="btn btn-default">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
			    </div>
		    </div>
		</form>

	    <?php } else { ?>
		<form id="formsearch_home" name="formsearch_home" class="form-horizontal"
		      action="<?php echo base_url() . 'search-information' ?>" method="post">
		    <div class="input-group">
			<input name="key" id="singleBirdRemote" class="form-control txt-search ui-autocomplete-input"
			       type="text"
			       placeholder="Nhập từ khóa tìm kiếm"
			       onkeypress="autoCompleteSearch(document.getElementById('category_quick_search_q').value)"/>
			<input type="hidden" id="category_quick_search_q" name="category_quick_search_q"
			       value="product">
			<div class="input-group-btn">
				<button type="submit"
				class="btn btn-default">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
			</div>

		    </div>
		</form>
	    <?php } ?>
	</div>

	<div class="col-lg-5 col-md-5 col-sm-5">
	    <?php  
	    if(isset($currentuser) && $currentuser ){
	       if ($currentuser->avatar != '') {
		    $avatar = DOMAIN_CLOUDSERVER.'media/images/avatar/' . $currentuser->avatar;
		} else {
		    $avatar = site_url('media/images/avatar/default-avatar.png');
		} ?>
		<div class="pull-left">
		    <a class="username" href="<?php echo $linktoshop ? $linktoshop : '/account' ?>">
			<img src="<?php echo $avatar; ?>" alt="account" style="width:34px; height:34px">                                
			<?php echo $this->session->userdata('sessionUsername'); ?>
		    </a>
		</div>
	    <?php } ?>
	    <ul class="menu-top-right pull-right">
		<li class="">
		    <a data-hint="Mua sắm" href="/shop/products" title="Mua sắm" class="hint--left">
			<img src="<?php echo site_url('templates/home/icons/white/icon-store.png'); ?>"
			     style="height:20px" alt="Mua sắm"/>
		    </a>
		</li>
		<li>
		    <a data-hint="Gợi ý cho bạn" href="#popup2" title="Gợi ý cho bạn" 
		       class="hint--left">
			<img src="<?php echo site_url('templates/home/icons/white/icon-newspaper.png'); ?>"
			     style="height:20px" alt="Gợi ý cho bạn"/>
		    </a>
		</li>

		<li>
		    <a class="hint--left" data-hint="Xem giỏ hàng" href="/checkout" title="Xem giỏ hàng">
			<img src="<?php echo site_url('templates/home/icons/white/icon-cart.png'); ?>"
			     style="height:20px" alt="Giỏ hàng"/>
			<span class="cartNum"><?php echo $azitab['cart_num']; ?></span>
		    </a>
		</li>

		<?php if ((int)$this->session->userdata('sessionUser') > 0) { ?>
		    <li class="dropdown pull-right">
			<a id="dLabel" data-target="#" href="<?php echo site_url(); ?>" data-toggle="dropdown"
			   role="button" aria-haspopup="true" aria-expanded="false">
			    <img src="<?php echo site_url('templates/home/icons/white/icon-bars.png'); ?>"
				 style="height:20px" alt="icon-bars"/>
			</a>
			<ul class="dropdown-menu" aria-labelledby="dLabel">
			    <li>
				<a data-hint="Kiểm tra đơn hàng" href="#popup5" title="Kiểm tra đơn hàng" class="nav-right hint--left">
				    <img src="<?php echo site_url('templates/home/icons/black/icon-check.png'); ?>" 
					 style="height:20px" alt="icon-check"/>&nbsp; Kiểm tra đơn hàng
				</a>
			    </li>

			    <li>
				<a class="hint--left" data-hint="Thông tin cá nhân"
				   href="<?php echo site_url('account/edit') ?>" title="Tài khoản">
				    <img src="<?php echo site_url('templates/home/icons/black/icon-user.png'); ?>"
					 style="height:20px" alt="icon-user"/>&nbsp; Thông tin cá nhân
				</a>
			    </li>

			    <li>
				<a class="hint--left" data-hint="Quản trị" href="<?php echo site_url('account') ?>"
				   title="Quản trị">
				    <img src="<?php echo site_url('templates/home/icons/black/icon-store.png'); ?>"
					 style="height:20px" alt="icon-store"/>&nbsp; Quản trị
				</a>
			    </li>
			    <?php if(in_array($this->session->userdata('sessionGroup'), array(3))){ ?> 
			    <li>
				<a class="hint--left" data-hint="Quản trị nhóm" href="<?php echo site_url('grouptrade') ?>" title="Quản trị nhóm">
				    <img src="<?php echo site_url('templates/home/icons/black/icon-store.png'); ?>" style="height:20px" alt="icon-store"/>&nbsp; Quản trị nhóm
				</a>
			    </li>                            
			    <?php } ?>
			    <li>
				<a class="hint--left" data-hint="Đăng xuất" href="<?php echo site_url('logout') ?>"
				   title="Đăng xuất">
				    <img src="<?php echo site_url('templates/home/icons/black/icon-logout.png'); ?>"
					 style="height:20px" alt="icon-logout"/>&nbsp; Đăng xuất
				</a>
			    </li>
			</ul>
		    </li>
		<?php } else { ?>
		    <li>
			<a class="hint--left" data-hint="Đăng nhập" href="<?php echo site_url('login') ?>"
			   title="Đăng nhập">
			    <img src="<?php echo site_url('templates/home/icons/white/icon-login.png'); ?>"
				 style="height:20px" alt="icon-login"/>
			</a>
		    </li>
		<?php } ?>
	    </ul>


	</div>
    </div>
    
    <?php $this->load->view('home/common/menubar'); ?>
    
    <a id="toTop" href="#"><i class="fa fa-chevron-up fa-fw"></i></a>

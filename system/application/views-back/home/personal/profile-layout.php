<?php
if(isset($open_chose) && $open_chose == 1) {
    $this->load->view('home/common/header_new');
    $this->load->view('home/personal/affiliate/popup/popup-get-parent');
    echo '<script>open_chose();</script>';
    exit();
}
?>

<?php
$this->load->view('home/common/header_new');
if (!empty($is_owner)) {
    $cover_path = 'home/personal/elements/cover_login';
} else {
    $cover_path = 'home/personal/elements/cover_not_login';
}
$class_default_sidebar = '';
$profile_shop_url   = shop_url($shop);
?>
<!-- Loading font google -->
<link href="https://fonts.googleapis.com/css?family=Anton|Asap|Bangers|Barlow+Condensed|Chakra+Petch|Charm|Cousine|Dancing+Script|Francois+One|Jura|Oswald|Pacifico|Pattaya|Saira+Condensed|Saira+Extra+Condensed|Taviraj" rel="stylesheet">
<link href="/templates/home/styles/css/modal-show-details.css" type="text/css" rel="stylesheet" />
<link href="/templates/home/css/addnews.css" type="text/css" rel="stylesheet" />
<link href="/templates/home/darkroomjs/css/darkroom.css" type="text/css" rel="stylesheet" />
<link href="/templates/home/styles/plugins/wowslider/owl.carousel.min.css" type="text/css"  rel="stylesheet" />
<link href="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
<link href="/templates/home/css/animate_new.css?ver=<?=time();?>" rel="stylesheet" type="text/css" />
<link href="/templates/home/styles/plugins/videojs/css/video-js.css" rel="stylesheet" type="text/css"/>
<link href="/templates/home/styles/plugins/videojs/css/video-js-custom.css" rel="stylesheet" type="text/css"/>
<link href="/templates/home/css/new-detail.css" rel="stylesheet" type="text/css" />
<link href="/templates/home/css/person-affiliate.css" rel="stylesheet" type="text/css" />
<link href="/templates/home/styles/css/personal.css" type="text/css" rel="stylesheet"/>
<link href="/templates/home/styles/css/tintuc/popup-info-detail.css" type="text/css" rel="stylesheet" />
<link href="/templates/home/css/bootstrap-confirm-delete.css" type="text/css" rel="stylesheet"/>
<link href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">

<script>
    var public_id = '<?php echo $info_public['use_id'];  ?>';
    var url_ajax = '<?php echo $profile_url;  ?>';
</script>
<script src="/templates/home/styles/plugins/videojs/js/video.js"></script>
<script src="/templates/home/styles/plugins/videojs/js/videojs-ie8.min.js"></script>
<script src="/templates/home/js/home_news.js"></script>
<script src="/templates/home/owlcarousel/owl.carousel.js"></script>
<script src="/templates/home/darkroomjs/js/fabric.js"></script>
<script src="/templates/home/darkroomjs/js/darkroom.js"></script>
<script src="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.js" type="text/javascript"></script>
<script src="/templates/engine1/wowslider.js" type="text/javascript"></script>
<script src="/templates/engine1/script.js" type="text/javascript"></script>
<script src="/templates/home/js/addnews-person.js"></script>
<script src="/templates/home/js/addnews-video.js?ver=<?=time();?>"></script>
<script src="/templates/home/js/addnews-validate.js"></script>
<script src="/templates/home/js/addnews-function.js"></script>
<script src="/templates/home/styles/js/commission-aft.js"></script>
<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/styles/js/slick.js"></script>
<script src="/templates/home/styles/js/slick-slider.js"></script>
<script src="/templates/home/styles/js/countdown.js"></script>
<script src="/templates/home/styles/js/jquery-scrolltofixed.js"></script>
<script src="/templates/home/styles/js/fixed_sidebar.js"></script>
<script src="/templates/home/styles/js/shop/shop-news.js"></script>
<script src="/templates/home/js/text.min.js?ver=<?=time();?>" type="text/javascript"></script>
<script src="/templates/home/styles/js/personal/personal_handle_image.js"></script>

<script src="/templates/home/js/jAlert-master/jAlert-v3.min.js"></script>
<script src="/templates/home/js/general_ver2.js"></script>
<script src="/templates/home/js/player.js"></script>
<script src="/templates/home/js/affiliate.js"></script>
<script src="/templates/home/js/bootstrap-confirm-delete.js"></script>

<main class="affiliate trangcuatoi tindoanhnghiep coupondisplay">
    <section class="main-content">
        <?php if ($not_show_cover == false) {
            $this->load->view('home/personal/elements/personal_header', [
                'cover_path'        => $cover_path,
                'profile_url'       => $info_public['profile_url'],
                'profile_shop_url'  => $profile_shop_url,
            ]);
            }?>
        <div class="container clearfix">
            <?php echo @$layout_extend ?>
        </div>
    </section>
</main>
<footer id="footer"></footer>
<?php //$this->load->view('home/common/overlay_waiting'); ?>
<?php $this->load->view('home/report/popup-report'); ?>
<?php $this->load->view('home/common/load_wrapp'); ?>
<!-- // trc để ở cuối, web ko nhận đc tag script -->
<script src="/templates/home/styles/plugins/videojs/js/custom-videojs.js"></script>
<?php if($show_sub_aff != true) { ?>
    <script src="/templates/home/styles/js/personal.js"></script>
<?php } ?>
<script src="/templates/home/styles/js/shop/shop-common.js"></script>
<script src="/templates/home/styles/js/shop/shop-news-video-block.js"></script>
<script src="/templates/home/styles/js/tintuc/popup-info-detail.js"></script>

</div>
<?php $this->load->view('home/personal/elements/popup_edit_avatar'); ?>
<?php $this->load->view('home/tintuc/popup-info-detail'); ?>
<?php $this->load->view('shop/news/elements/popup-news-video', [
    'url'  => $info_public['profile_url'],
    'name' => $info_public['use_fullname'],
    'logo' => $info_public['avatar_url'],
]); ?>
<?php $this->load->view('home/tintuc/popup/popup-list-like'); ?>
<?php $this->load->view('home/personal/affiliate/popup/popup-get-parent'); ?>
<?php $this->load->view('home/common/load_wrapp'); ?>
<script src="/templates/home/styles/js/azibai-contents/content.api.js"></script>
<!--block script tags-->
<?php
if (!empty($script_tags)){
    foreach ($script_tags as $tag) {
        echo $tag;
    }
}
?>
</body>
</html>

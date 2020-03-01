<?php
$group_id = (int) $this->session->userdata('sessionGroup');
$user_id = (int) $this->session->userdata('sessionUser');
//if visit from azibai show menu azibai
if(isset($visited_azibai) && $visited_azibai == date('Y-m-d')){
    $this->load->view('home/common/header_new');
}else{
    $this->load->view('shop/news/elements/header_shop_news', ['body_class' => 'trangtinchitiet']);
}
?>
    <link href="/templates/home/styles/css/modal-show-details.css" type="text/css" rel="stylesheet" />
    <link href="/templates/home/css/addnews.css" rel="stylesheet" type="text/css"/>
    <link href="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="/templates/home/styles/plugins/videojs/css/video-js.css" rel="stylesheet" type="text/css"/>
    <link href="/templates/home/styles/plugins/videojs/css/video-js-custom.css" rel="stylesheet" type="text/css"/>
    <link href="/templates/home/styles/css/enterprise.css" rel="stylesheet" type="text/css">

    <script>
        var default_image_error_path = '<?php echo DEFAULT_IMAGE_ERROR_PATH; ?>';
        function image_error(img)
        {
            img.setAttribute('src', default_image_error_path);
            img.className += ' error-image';
        }

        var DOMAIN_SITE = '<?php echo $protocol . domain_site ?>';
        var api_common_audio_post = '<?php echo $api_common_audio_post ?>';
        var api_common_video_post = '<?php echo $api_common_video_post ?>';
        var token = '<?php echo $token ?>';
        var audios_images = '';
        var audios_url = '';
        var audios_azibai_preview = '';
        var audios_preview_url = '';
        var DOMAIN_CLOUDSERVER = '<?php echo DOMAIN_CLOUDSERVER ?>';
    </script>
    <script src="/templates/home/styles/plugins/videojs/js/video.js"></script>
    <script src="/templates/home/styles/plugins/videojs/js/videojs-ie8.min.js"></script>
    <script src="/templates/home/owlcarousel/owl.carousel.js"></script>
    <script src="/templates/home/styles/js/slick.js"></script>
    <script src="/templates/home/styles/js/slick-slider.js"></script>
    <script src="/templates/home/styles/js/countdown.js"></script>
    <script src="/templates/home/styles/js/jquery-scrolltofixed.js"></script>
    <script src="/templates/home/styles/js/fixed_sidebar.js"></script>
    <script src="/templates/home/styles/js/common.js"></script>
    <script src="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.js" type="text/javascript"></script>
    <script src="/templates/home/js/addnews.js"></script>
    <script src="/templates/home/js/addnews-function.js"></script>
    <script src="/templates/home/js/addnews-validate.js"></script>
    <script src="/templates/home/styles/js/commission-aft.js"></script>
    <script src="/templates/home/js/jquery.appear.js"></script>
    <script src="/templates/home/js/general_ver2.js"></script>
    <script src="/templates/home/styles/js/shop-upload-cover-avatar.js"></script>
    <script src="/templates/home/styles/js/shop/shop-news.js"></script>

    <?php $this->load->view('shop/news/content') ?>
    <?php $this->load->view('shop/news/elements/footer') ?>
    <script type="text/javascript" src="/templates/home/js/text.min.js?ver=<?=time();?>"></script>

    <!--js edit link-->
    <!-- // trc để ở cuối, web ko nhận đc tag script -->
    <script>
        var type_link_template = 'content_index';
    </script>
    <script src="/templates/home/styles/js/shop/shop-library-custom-link-v2.js"></script>
    <!--/end js edit link-->
    <script src="/templates/home/styles/plugins/videojs/js/custom-videojs.js"></script>
    <script src="/templates/home/styles/js/enterprise.js"></script>
    <script src="/templates/home/styles/js/shop/shop-news-video-block.js"></script>
    <script src="/templates/home/styles/js/shop/shop-common.js"></script>
    <script src="/templates/home/styles/js/azibai-contents/content.api.js"></script>

    <!--popup commission-->
    <?php $this->load->view('home/common/pop_aft_commission') ?>
    <!--/popup commission-->
    <?php $this->load->view('home/tintuc/popup-info-detail'); ?>
    <?php $this->load->view('shop/news/elements/popup-news-video', [
            'url'  => $shop_current->shop_url,
            'name' => $shop_current->sho_name,
            'logo' => $shop_current->logo,
    ]); ?>

    <?php $this->load->view('home/tintuc/popup/popup-list-like'); ?>
    <?php $this->load->view('home/report/popup-report'); ?>
    <?php
    /*popup edit link*/
    if(!empty($user_login)){
        $this->load->view('shop/media/elements/library-links/popup-custom-link-create', [
            'sho_id'        => @(int)$user_login['my_shop']['sho_id'],
            'default_shop'  => false
        ]);
    }
    ?>
</div>
</body>
</html>
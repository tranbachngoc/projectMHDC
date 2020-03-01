<?php
if (!isset($user_login)) {
    $user_login = MY_Loader::$static_data['hook_user'];
}
$this->load->view('home/common/header_new');
$group_id = (int)$this->session->userdata('sessionGroup');
$user_id  = (int)$this->session->userdata('sessionUser');

?>
<!-- Loading font google -->
<link href="https://fonts.googleapis.com/css?family=Anton|Asap|Bangers|Barlow+Condensed|Chakra+Petch|Charm|Cousine|Dancing+Script|Francois+One|Jura|Oswald|Pacifico|Pattaya|Saira+Condensed|Saira+Extra+Condensed|Taviraj" rel="stylesheet">
<link href="/templates/home/styles/css/modal-show-details.css" type="text/css" rel="stylesheet"/>
<link href="/templates/home/css/addnews.css" type="text/css" rel="stylesheet"/>
<link href="/templates/home/darkroomjs/css/darkroom.css" type="text/css" rel="stylesheet"/>
<link href="/templates/home/styles/plugins/wowslider/owl.carousel.min.css" rel="stylesheet" type="text/css"/>
<link href="/templates/home/styles/plugins/videojs/css/video-js.css" rel="stylesheet" type="text/css"/>
<link href="/templates/home/styles/plugins/videojs/css/video-js-custom.css" rel="stylesheet" type="text/css"/>
<link href="/templates/home/css/new-detail.css" rel="stylesheet" type="text/css"/>

<script>
    var api_common_audio_post = '<?php echo $api_common_audio_post ?>';
    var api_common_video_post = '<?php echo $api_common_video_post ?>';
    var token = '<?php echo $token ?>';
    var audios_images = '';
    var audios_url = '';
    var audios_azibai_preview = '';
    var audios_preview_url = '';
    var DOMAIN_CLOUDSERVER = '<?php echo DOMAIN_CLOUDSERVER ?>';
</script>

<script src="/templates/home/js/home_news.js"></script>
<script src="/templates/home/owlcarousel/owl.carousel.js"></script>
<script src="/templates/home/darkroomjs/js/fabric.js"></script>
<script src="/templates/home/darkroomjs/js/darkroom.js"></script>
<script src="/templates/home/js/jquery.countdown.min.js"></script>
<script src="/templates/engine1/wowslider.js" type="text/javascript"></script>
<script src="/templates/engine1/script.js" type="text/javascript"></script>
<script src="/templates/home/js/addnews-person.js"></script>
<script src="/templates/home/js/addnews-validate.js"></script>
<script src="/templates/home/js/addnews-function.js"></script>
<script src="/templates/home/styles/js/commission-aft.js"></script>

<script src="/templates/home/styles/js/common.js"></script>
<script src="/templates/home/styles/js/slick.js"></script>
<script src="/templates/home/styles/js/slick-slider.js"></script>
<script src="/templates/home/styles/js/countdown.js"></script>
<script src="/templates/home/styles/js/jquery-scrolltofixed.js"></script>
<script src="/templates/home/js/text.min.js?ver=<?= time(); ?>" type="text/javascript"></script>

<script src="/templates/home/js/jAlert-master/jAlert-v3.min.js"></script>
<script src="/templates/home/js/general_ver2.js"></script>
<script src="/templates/home/js/player.js"></script>
<script src="/templates/home/styles/js/shop/shop-news.js"></script>
<script src="/templates/home/styles/plugins/videojs/js/video.js"></script>
<script src="/templates/home/styles/plugins/videojs/js/videojs-ie8.min.js"></script>

<main>
    <section class="main-content">
        <div class="container clearfix">
            <div class="sidebar md fixtoscroll">
                <?php $this->load->view('home/common/left_tintuc'); ?>
            </div>
            <div class="content">
                <?php if ($this->session->userdata('sessionUser')) { ?>
                    <div class="blockdangtin">
                        <?php $this->load->view('home/tintuc/dangtin_person', array()); ?>
                    </div>
                <?php } ?>
                <ul class="listtabtitle js_filter-news">
                    <li data-filter="all"
                        class="<?php echo !isset($_REQUEST['filter']) || $_REQUEST['filter'] == 'all' ? 'is-active' : '' ?>">
                        <a href="javascript:void(0)">Tất cả</a>
                    </li>
                    <li data-filter="shop"
                        class="<?php echo !empty($_REQUEST['filter']) && $_REQUEST['filter'] == 'shop' ? 'is-active' : '' ?>">
                        <a href="javascript:void(0)">Cộng đồng</a>
                    </li>
                    <li data-filter="user"
                        class="<?php echo !empty($_REQUEST['filter']) && $_REQUEST['filter'] == 'user' ? 'is-active' : '' ?>">
                        <a href="javascript:void(0)">Cá nhân</a>
                    </li>
                </ul>
                <div class="js_fillter-categories" <?php echo !isset($_REQUEST['filter']) || $_REQUEST['filter'] == 'all' ? '' : 'style="display: none"' ?>>
                    <?php echo $this->load->view('/home/common/suggest_category', ['productCategoryRoot' => $productCategoryRoot]); ?>
                </div>
                <div class="content-posts" id="content" data-type="<?php echo $this->uri->segment(2); ?>">
                    <?php
                    $root_url = azibai_url();
                    foreach ($list_news as $key => $item) {
                        $item->collection         = $collection;
                        $item->collection_content = $collection_content;
                        $item->root_url           = $root_url;
                        $this->load->view('home/tintuc/item', array('item' => $item, 'home_page' => 1));

                        if(!empty($item->suggest_list)) {
                            foreach ($item->suggest_list as $key => $value) {
                                echo $value;
                            }
                        }
                    } ?>

                </div>
                <div class="text-center">
                    <i class="fa fa-spinner fa-spin" id="loadding" style="font-size:24px;"></i>
                </div>
            </div>
        </div>
    </section>
</main>

<footer id="footer"></footer>

<?php echo $this->load->view('/home/common/pop_aft_commission') ?>

<script type="text/javascript">
    jQuery(function () {
        $('.fixtoscroll').scrollToFixed({
            marginTop: function () {
                var marginTop = $(window).height() - $(this).outerHeight(true) - 0;
                if (marginTop >= 0) return 75;
                return marginTop;
            }, limit: function () {
                var limit = 0;
                limit = $('#footer').offset().top - $(this).outerHeight(true) - 0;
                return limit;
            }
        });
        $('.rowpro .owl-carousel').owlCarousel({
            loop: false,
            margin: 5,
            nav: true,
            dots: false,
            responsive: {0: {items: 1}, 600: {items: 2}}
        });
        $('[data-countdown]').each(function () {
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function (event) {
                $this.html(event.strftime('%D ngày %H:%M:%S'));
            });
        });
        var itempost = $('.embed-responsive');
        var tolerancePixel = -100;

        $('.lazy').lazy();

        $('.tin24h-slider').slick({
            dots: false,
            infinite: false,
            speed: 300,
            slidesToShow: 6,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1025,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1
                    }
                }
            ]
        });
    });
</script>

<?php
$this->load->view('home/tintuc/popup-info-detail');
$this->load->view('home/tintuc/popup-info-detail-news');
$this->load->view('home/tintuc/popup/popup-list-like');
$this->load->view('home/report/popup-report');

/*popup edit link*/
if(!empty($user_login)){
    $this->load->view('shop/media/elements/library-links/popup-custom-link-create', [
        'sho_id'        => $user_login['my_shop']['sho_id'],
        'default_shop'  => false
    ]);
}
?>
<!--js edit link-->
<script>
    var type_link_template = 'content_index';
</script>
<script src="/templates/home/styles/js/shop/shop-library-custom-link-v2.js"></script>
<!--/end js edit link-->

<script src="/templates/home/js/jquery.appear.js"></script>
<script src="/templates/home/styles/plugins/videojs/js/custom-videojs.js"></script>
<script src="/templates/home/styles/js/tintuc/tintuc-filter.js"></script>
<script type="text/javascript">
    jQuery(function ($) {
        jQuery(document).on('click', '.az-volume', function () {
            if (!$(this).hasClass('volume_off')) {
                var element = $(this).closest('.video').find('video').attr('id');
                $(this).attr("src", "/templates/home/styles/images/svg/icon-volume-on.svg");
                $(this).addClass("volume_off");
                $('#' + element).prop('muted', false);
            } else {
                var element = $(this).closest('.video').find('video').attr('id');
                $(this).attr("src", "/templates/home/styles/images/svg/icon-volume-off.svg");
                $('#' + element).prop('muted', true);
                $(this).removeClass("volume_off");
            }
        });
    });

    jQuery('.animated').appear(function () {
        var element = jQuery(this);
        var animation = element.data('animation');
        var animationDelay = element.data('delay');
        if (animationDelay) {
            setTimeout(function () {
                element.addClass(animation + " visible");
                element.removeClass('hiding');
                if (element.hasClass('counter')) {
                    element.find('.value').countTo();
                }
            }, animationDelay);
        } else {
            element.addClass(animation + " visible");
            element.removeClass('hiding');
            if (element.hasClass('counter')) {
                element.find('.value').countTo();
            }
        }
    });
</script>
<script src="/templates/home/styles/js/azibai-contents/content.api.js"></script>
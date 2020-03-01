
<?php
if (!isset($user_login)) {
    $user_login = MY_Loader::$static_data['hook_user'];
}

$body_class = ' trangtinchitiet trangtinchitiet-v2 ';
if($item->type_show == STYLE_1_SHOW_CONTENT){
    $body_class .= 'trangtinchitiet-v2-v3 ';
}else if($item->type_show == STYLE_2_SHOW_CONTENT){
    $body_class = ' trangtinchitiet ';
}

if(!is_domain_shop()) {
    $this->load->view('home/common/header_new', ['body_class' => $body_class]);
}else{
    $this->load->view('shop/news/elements/header_shop', ['body_class' => $body_class]);
}
$owner_name = '';
$azibai_url = azibai_url();
$show_vol   = true;
$ua         = strtolower($_SERVER['HTTP_USER_AGENT']);
$domain_use = '';
$item_logo  = site_url('templates/home/styles/images/product/avata/default-avatar.png');

//shop
if(!empty($item->sho_id)) {
    $owner_name = $item->sho_name;
    $domain_use = shop_url($item);
    if (!empty($item->sho_logo)) {
        $item_logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $item->sho_dir_logo . '/' . $item->sho_logo;
    }
    if (!empty($item->show_shop)) {
        $item_link = $domain_use . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title) . $afkey;
    }

    $type_shrimg = TYPESHARE_DETAIL_SHOPIMG;
    $type_shrvideo = TYPESHARE_DETAIL_SHOPVIDEO;
}

//user
if(empty($item->sho_id) && !empty($item->not_user)) {
    $owner_name = $item->use_fullname;
    $domain_use = !empty($item->website) ? 'http://' .$item->website : $azibai_url . '/profile/' . $item->not_user;
    if (!empty($item->avatar)) {
        $item_logo = $this->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $item->use_id . '/' . $item->avatar;
    }
    if (!empty($personal_page)) {
        $item_link = $domain_use . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title) . $afkey;
    }

    $type_shrimg = TYPESHARE_DETAIL_PRFIMG;
    $type_shrvideo = TYPESHARE_DETAIL_PRFVIDEO;
}


if(stripos($ua,'ipod') !== false || stripos($ua,'iphone') !== false || stripos($ua,'ipad') !== false ) {
    $show_vol = false;
}

if($af_id != ''){
    $afkey = '?af_id=' . $af_id;
} else {
    $afkey = '';
}
$group_id = $this->session->userdata('sessionGroup');
$user_id = $this->session->userdata('sessionUser');
$article_link =  get_server_protocol() . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

$title_ = $item->use_fullname.' - '.html_entity_decode($item->not_detail);
if($item->sho_id){ $title_ = $item->not_title;}
$title_ = convert_percent_encoding($title_);
?>
<?php
if (isset($popup)) {
?>
<div class="body_black"></div>
<style type="text/css">
    .body_black {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 1050;
        background: #000;
    }
</style>
<?php
}
?>
<!-- Loading font google -->
<link href="https://fonts.googleapis.com/css?family=Anton|Asap|Bangers|Barlow+Condensed|Chakra+Petch|Charm|Cousine|Dancing+Script|Francois+One|Jura|Oswald|Pacifico|Pattaya|Saira+Condensed|Saira+Extra+Condensed|Taviraj" rel="stylesheet">

<link href="/templates/home/styles/css/modal-show-details.css" type="text/css" rel="stylesheet" />

<link rel="stylesheet" type="text/css" href="/templates/home/styles/plugins/wowslider/style.css" />
<link rel="stylesheet" type="text/css" href="/templates/home/styles/plugins/wowslider/owl.carousel.min.css" />
<link rel="stylesheet" type="text/css" href="/templates/home/styles/plugins/lightgallery/css/lightgallery.css" />
<link rel="stylesheet" type="text/css" href="/templates/home/css/animate_new.css?ver=<?=time();?>" />
<link href="/templates/home/css/new-detail.css?ver=<?=time();?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/templates/home/styles/js/countdown.js"></script>
<script type="text/javascript" src="/templates/home/js/text.min.js?ver=<?=time();?>"></script>
<script type="text/javascript" src="/templates/engine1/wowslider.js"></script>
<script type="text/javascript" src="/templates/engine1/script.js"></script>
<script src="/templates/home/styles/js/shop/shop-news.js"></script>

    <div class="wrapper">
        <main style="margin-top: 0px;">
            <section class="main-content bosuutap-content-detail-modal">
                <div class="container clearfix">
                    <div class="sidebar md fixtoscroll">
                        <?php
                        if(!is_domain_shop()){
                            $this->load->view('home/common/left_tintuc');
                        }else{
                            $this->load->view('shop/news/elements/shop_news_menu_left');
                        }
                        ?>
                    </div>
                    <div class="content content-posts">
                        <?php if (isset($popup)) {?>
                            <div class="detail_url" value="<?= $share_url; ?>"></div>
                        <?php } ?>
                        <div class="trangtinchitiet-content post-detail">
                            <?php
                            $show_video = '';
                            $numlike = $numshare = 0;
                            if(!empty($item->likes_content)){
                                $show_video = ' js-show-like';
                                $numlike = $item->likes_content;
                            }
                            if($item->total_share > 0){
                                $numshare = $item->total_share;
                            }
                            ?>
                            <ul class="fixed-like-share js-fixed-like-share js-item-id js-item-id-<?php echo $item->not_id ?>" data-id="<?php echo $item->not_id ?>">
                                <li>
                                    <div class="img js-like-content" data-id="<?php echo $item->not_id ?>">
                                        <a href="#">
                                            <?php if (!empty($item->is_like_content)) { ?>
                                                <img class="icon-img"
                                                     src="/templates/home/styles/images/svg/like_pink.svg" alt="like"
                                                     data-like-icon="/templates/home/styles/images/svg/like_pink.svg"
                                                     data-notlike-icon="/templates/home/styles/images/svg/like.svg">
                                            <?php } else { ?>
                                                <img class="icon-img" src="/templates/home/styles/images/svg/like.svg"
                                                     alt="like"
                                                     data-like-icon="/templates/home/styles/images/svg/like_pink.svg"
                                                     data-notlike-icon="/templates/home/styles/images/svg/like.svg">
                                            <?php } ?>
                                        </a>
                                    </div>
                                    <div class="mess<?= $show_video; ?>" data-id="<?php echo $item->not_id ?>">
                                        <span class="js-count-like-<?php echo $item->not_id; ?>"><?php echo $numlike; ?></span>
                                        <span class="md">lượt thích</span></div>
                                </li>
                                <li>
                                    <div class="img">
                                        <a href=""><img src="/templates/home/styles/images/svg/comment.svg" alt=""></a>
                                    </div>
                                    <div class="mess">
                                        <span class="">0</span>
                                        <span class="md">bình luận</span>
                                    </div>
                                </li>
                                <?php
                                $permission = '';
                                if($this->session->userdata('sessionUser') && $this->session->userdata('sessionUser') == $item->not_user){
                                    $permission = 1;
                                }
                                ?>
                                <li>
                                    <div class="img share-click shr-content" data-toggle="modal" data-value="<?= $share_url; ?>" data-name="<?= $title_ ?>" data-type="<?= $type_share ?>" data-item_id="<?= $item->not_id ?>" data-url_page="<?= $share_url; ?>" data-permission="<?= $permission ?>" data-tag="content">
                                        <a>
                                            <img class="icon-img" src="/templates/home/styles/images/svg/share.svg"
                                                 alt="share">
                                        </a>
                                    </div>
                                    <div class="mess js-list-share js-list-share-content cursor-pointer">
                                        <span class="js-total-image"><?php echo $numshare; ?></span>
                                        <span class="md">chia sẻ</span></div>
                                </li>
                                <li>
                                    <div class="img">
                                        <a href=""><img src="/templates/home/styles/images/svg/bookmark.svg" alt=""></a>
                                    </div>
                                    <div class="mess luu">Lưu tin</div>
                                </li>
                            </ul>
                            <?php if(!empty($item->sho_id) && !empty($item->not_user)){ ?>
                                <?php if (!empty($listImg)) { ?>
                                    <div class="trangtinchitiet-slidermedia slidermedia-full" style="<?=$item->sBackground;?>">
                                        <div id="wowslider-container1" class="wowslider-container">
                                            <div class="ws_images">
                                                <ul>
                                                    <?php
                                                    $images_title = '';
                                                    foreach ($listImg as $key => $value) {
                                                        $type =  pathinfo($value->image, PATHINFO_EXTENSION);
                                                        if($type == 'image/gif') {
                                                            $image_url = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image
                                                             . '/' . $value->image;
                                                        }else {
                                                            $image_url = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image. '/' . $value->link_crop;
                                                        }

                                                        $alt = ($value->title) ? $value->title : $item->not_title;
                                                        $alt = htmlspecialchars($alt);
                                                        $images_title .= '<a href="#" title="'.$alt.'"><span>'. $key.'</span></a>';
                                                    ?>
                                                        <li>
                                                            <img crossOrigin="Anonymous" src="<?php echo $image_url ?>"
                                                                 class="<?=in_array($value->orientation, [-90, 270]) ? 'rotate-l-90' : ($value->orientation == 90 ? 'rotate-r-90' : ($value->orientation == 180 ? 'rotate-180' : '') )?>"
                                                                 alt="<?php echo $alt ?>"
                                                                 title="<?php echo $alt ?>"
                                                                 id="wows1_0" />
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                        <?php if ($item->not_music != '') { ?>
                                            <audio preload="false" id="audio<?php echo $item->not_id ?>" src="<?php echo '/media/musics/' . $item->not_music; ?>"></audio>
                                            <img data-id="audio<?php echo $item->not_id ?>" class="az-volume" src="/templates/home/styles/images/svg/icon-volume-on.svg" data-status="on"/>
                                            <iframe style="display: none;" src="<?php echo '/media/musics/' . $item->not_music; ?>" allow="autoplay" id="iframe_audio<?php echo $item->not_id ?>" type="audio/mp3"></iframe>
                                        <?php } ?>
                                        <span id="pagingInfo1"></span>
                                    </div>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function(){
                                            jQuery("#wowslider-container1").wowSlider({
                                                effect:"<?=$item->not_effect?>",
                                                prev:"",
                                                next:"",
                                                duration:20*100,
                                                delay:10*100,
                                                width:600,
                                                height:338,
                                                autoPlay:true,
                                                autoPlayVideo:false,
                                                playPause:true,
                                                stopOnHover:false,
                                                loop:false,
                                                bullets:0,
                                                caption:true,
                                                captionEffect:"move",
                                                controls:true,
                                                controlsThumb:false,
                                                responsive:1,
                                                fullScreen:false,
                                                gestures:2,
                                                onBeforeStep:0,
                                                images:0,
                                                dots: false
                                            });

                                        });
                                    </script>
                                <?php } else if(!$item->not_slideshow && $item_image) { ?>
                                    <div class="trangtinchitiet-content-item item04 have-bg-banner" style="<?=$item->sBackground;?>">
                                        <div class="item-content">
                                            <div class="image">
                                                <img src="<?php echo $item_image ?>">
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>

                            <div id="trangtinchitiet_info" class="trangtinchitiet-info">
                                <div class="trangtinchitiet-info-header">
                                    <div class="head-name">
                                        <div class="avata">
                                            <a href="<?php echo $domain_use ?>">
                                                <img src="<?php echo $item_logo ?>" alt="<?=$item->sho_name?>">
                                            </a>
                                        </div>
                                        <div class="title">
                                            <p class="shop-name"><?php echo $owner_name; ?></p>
                                            <span><?php echo date('d/m/Y', $item->not_begindate); ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="trangtinchitiet-content item-element-parent">
                                    <div class="trangtinchitiet-content-section">
                                        <?php if ($this->session->userdata('sessionUser') == $item->sho_user) : ?>
                                            <div class="button-chinh-sua">
                                                <a href="<?php echo base_url() ?>tintuc/editnewhome/<?php echo $item->not_id ?>"
                                                   target="_blank">
                                                    <img src="/templates/home/styles/images/svg/pen.svg" alt="">Chỉnh sửa
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                        <?php $this->load->view('home/tintuc/elements/article-content', [
                                            'domain_use'      => $domain_use,
                                            'has_image_video' => !empty($listImg),
                                        ]) ?>

                                        <div class="trangtinchitiet-content-item trangtinchitiet-video">
                                            <?php if ($item->not_video_url1) { ?>
                                                <?php if($show_vol == true) { ?>
                                                    <img class="az-volume-video" src="/templates/home/styles/images/svg/icon-volume-off.svg" width="32">
                                                <?php } ?>
                                                <video id="video_<?php echo $item->not_id; ?>" playsinline muted="true" autoplay="true" preload="metadata" class="videoautoplay popup-detail-image popup-detail-video" data-id="<?php echo $item->not_id; ?>" data-cat="<?php echo $item->not_pro_cat_id; ?>" data-shop-name="<?php echo $item->sho_name ?>" data-shop-date="<?php echo date('d/m/Y', $item->not_begindate); ?>" data-shop-link="<?php echo $domain_use ?>" data-shop-avatar="<?php echo $shop_logo ?>" data-video-link="<?php echo DOMAIN_CLOUDSERVER . 'video/' . $item->not_video_url1; ?>" data-news-id="<?php echo $item->not_id; ?>" data-key="0"
                                                       data-video-id="<?php echo $item->video_id; ?>"
                                                       data-name="<?php echo $share_name; ?>"
                                                       data-value="<?php echo $share_url; ?>"
                                                       data-type="<?php echo $type_shrvideo;?>">
                                                    <source src="<?php echo DOMAIN_CLOUDSERVER . 'video/' . $item->not_video_url1 ?>"
                                                            type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>

                                                <div class="text">
                                                    <?php if(isset($item->video_title) && $item->video_title !='') { ?>
                                                        <h3 class="tit"><?php echo $item->video_title ?></h3>
                                                    <?php } ?>
                                                    <?php if(isset($item->video_description) && $item->video_description !='') { ?>
                                                        <p class="mb10"><?php echo nl2br($item->video_description); ?></p>
                                                    <?php } ?>
                                                </div>
                                                <?php echo $this->load->view('home/tintuc/elements/news_actions', ['type_shr_imgvideo' => $type_shrvideo]); ?>
                                            <?php } ?>
                                        </div>

                                        <?php
                                        if (!empty($listImg)){
                                            foreach ($listImg as $iKeyImage => $oImage) {
                                                $this->load->view('home/tintuc/elements/image-display-default', [
                                                    'oImage'     => $oImage,
                                                    'key_img'    => $iKeyImage,
                                                    'domain_use' => $domain_use,
                                                    'type_shrimg' => $type_shrimg
                                                ]);
                                            }
                                        } ?>

                                        <!-- có 3 trường hợp, 1: có hình rỗng time và title, 2: countdown, 3: clock countdown (thiếu html clock và image)-->
                                        <?php
                                        if (!empty($item->not_ad )){
                                            $this->load->view('home/tintuc/elements/ads', [
                                                'ad' => @json_decode($item->not_ad)
                                            ]);
                                        }
                                        ?>

                                        <?php if ($item->not_statistic == 1) { ?>
                                            <?php
                                            $statistic = @json_decode($item->statistic, true);
                                            if($item->img_statistic != '') {
                                                $sStaticImg = $item->sLinkFolderImage.$item->img_statistic;
                                            }else {
                                                $sStaticImg = '';
                                            }
                                            if (is_array($statistic) && !empty($statistic)){
                                                ?>
                                                <div class="trangtinchitiet-content-item soluong-khachhang bg-overlay pt00 has-bg-img" id="post_statistic" style="background: url('<?=$sStaticImg?>') no-repeat center;background-size: cover;">
                                                    <ul class="soluong-khachhang-detail">
                                                        <?php foreach ($statistic as $k => $value) { ?>
                                                            <li class="khackhang">
                                                                <p class="number countnumber" data-count="<?php echo (int)$value['num'] ?>">0</p>
                                                                <strong><?php echo $value['title'] ?></strong>
                                                                <span class="description"><?php echo $value['description'] ?></span>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                </div>
                                            <?php } ?>
                                        <?php } ?>

                                        <?php
                                        if(!empty($item->not_customer)){
                                            $not_customer = @json_decode($item->not_customer);
                                            if (is_array($not_customer->cus_list) && count($not_customer->cus_list) > 0) {
                                                $html_modal_customer = '';
                                                echo $this->load->view('home/tintuc/elements/customer-review', [
                                                    'not_customer'       => $not_customer,
                                                ]);
                                            }
                                        }
                                        ?>

                                        <?php if (!empty($listPro)) { ?>
                                            <div class="flash-sale">
                                                <div class="slider flash-sale-slider" id="flash-sale-slider_0">
                                                    <?php
                                                    foreach ($listPro as $k => $product) {
                                                        $linktoproduct = azibai_url() . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . $afkey;
                                                        if($product->pro_saleoff == 1 && $product->end_date_sale != '' && $product->end_date_sale >= time() && $product->begin_date_sale <= time())
                                                        {
                                                            $is_fsale = true;
                                                        }
                                                        echo $this->load->view('home/common/product/item_flash_sale', [
                                                            'product'     => $product,
                                                            'content' => $item,
                                                            'group_id'  => $group_id,
                                                            'user_id'   => $user_id,
                                                            'afkey'     => $afkey,
                                                            'k'         => $k,
                                                            'slider_pro' => false,
                                                            'is_fsale'         => $is_fsale,
                                                            'idFlash' => $item->not_id . $random . $k
                                                        ]);
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <?php
                    //tin lien quan
                    if(!empty($item->sho_id) && !empty($item->not_user)) {
                        $this->load->view('home/common/right_tintuc', ['domain_use' => $domain_use]);
                    }
                    ?>
                </div>
            </section>
        </main>
        <footer id="footer"> </footer>
        <?php echo $this->load->view('/home/common/pop_aft_commission') ?>
        <div class="drawer-overlay drawer-toggle"></div>

    </div>
    <?php $this->load->view('home/tintuc/popup-comment-image-detail'); ?>

    <?php
    /*popup edit link*/
    if(!empty($user_login)){
        $this->load->view('shop/media/elements/library-links/popup-custom-link-create', [
            'sho_id'        => @(int)$user_login['my_shop']['sho_id'],
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

    <script type="text/javascript" src="/templates/home/styles/js/common.js"></script>
    <script type="text/javascript" src="/templates/home/styles/js/slick.js"></script>
    <script type="text/javascript" src="/templates/home/styles/js/slick-slider.js"></script>

    <script type="text/javascript" src="/templates/home/styles/js/jquery-scrolltofixed.js"></script>
    <script type="text/javascript" src="/templates/home/styles/js/fixed_sidebar.js"></script>
    <script type="text/javascript" src="/templates/home/styles/js/popup_dangtin.js"></script>
    <script type="text/javascript" src="/templates/home/styles/plugins/wowslider/owl.carousel.js"></script>
    <script type="text/javascript" src="/templates/home/styles/plugins/wowslider/wowslider.js"></script>
    <script type="text/javascript" src="/templates/home/styles/plugins/wowslider/script.js"></script>
    <script type="text/javascript" src="/templates/home/styles/js/commission-aft.js"></script>
    <script type="text/javascript" src="/templates/home/styles/js/home-news.js"></script>
    <script src="/templates/home/js/jquery.countdown.min.js"></script>
    <script src="/templates/home/js/jquery.appear.js"></script>
    <script src="/templates/home/styles/js/detail-content.js"></script>

    <script type="text/javascript">
        jQuery('.animated').appear(function() {
          var element = jQuery(this);
          var animation = element.data('animation');
          var animationDelay = element.data('delay');
          if (animationDelay) {
            setTimeout(function(){
              element.addClass( animation + " visible" );
              element.removeClass('hiding');
              if (element.hasClass('counter')) {
                element.find('.value').countTo();
              }
            }, animationDelay);
          }else {
            element.addClass( animation + " visible" );
            element.removeClass('hiding');
            if (element.hasClass('counter')) {
              element.find('.value').countTo();
            }
          }
        });
        //slider_fs(0);
        jQuery(document).on('click','#pagingInfo1', function(e) {
            var _minus_top = 60;
            if($('body').hasClass('display-sm')) 
            {
                _minus_top = 0;
            }

            $("html, body").animate({scrollTop: $("#trangtinchitiet_info").offset().top - _minus_top}, 1000);
        });

        var prevBottomScrollpos = window.pageYOffset;
        $(window).scroll(function() {

            if($("body.display-sm .js-fixed-like-share").length){
                prevBottomScrollpos = scrollup_bottom_shownavbar (".js-fixed-like-share", prevBottomScrollpos)
            }

            $('#trangtinchitiet_info video').each(function() {
                if(($(this).data('position') == 1 && isElementInViewport($(this)) || ($(this).data('video-type') !== 'link' && isElementInViewport($(this))))){
                    $('video.video-play').trigger("pause");
                    $(this).trigger("play");
                }else{
                    $(this).trigger("pause");
                }
            });

            $('.block-image img.popup-detail-image').each(function() {
                var element = $(this).closest('.block-image');
                if(!isElementInViewport($(this))) {
                    var audio = element.find('audio');
                    var id    = audio.attr('id');
                    var image = $('img#volume_'+id);
                    image.attr("src","/templates/home/styles/images/svg/icon-volume-off.svg");
                    image.attr('data-status','off');
                    audio.trigger("pause");
                }
            });
        });

        window.document.addEventListener("visibilitychange", function(e) {
            var element = $(document.body).find('audio');
            $(element).each(function() {
                var id    = $(this).attr('id');
                var image = $('img#volume_'+id);
                image.attr("src","/templates/home/styles/images/svg/icon-volume-off.svg");
                image.attr('data-status','off');
                $(this).trigger("pause");
                if($('#iframe_'+id).length > 0) {
                    $('#iframe_'+id).remove();
                    var image_main =  $('img[data-id="'+id+'"]');
                    image_main.attr("src","/templates/home/styles/images/svg/icon-volume-off.svg");
                    image_main.attr('data-status','off');
                }
            });
        });

        function show() {
            $(this).attr('controls', '');
        }
        function hide() {
            var isPlaying = false;
            if(!$('#video_<?php echo $item->not_id; ?>').get(0).paused) {
                isPlaying = true;
            }
            if (!isPlaying) {
                $(this).removeAttr('controls');
            }
        }

        var $video = $('#video_<?php echo $item->not_id; ?>');
        $video.on('mouseover', show);
        $video.on('mouseleave', hide);

        function isElementInViewport (el) {

          //special bonus for those using jQuery
          if (typeof jQuery === "function" && el instanceof jQuery) {
              el = el[0];
          }

          var rect = el.getBoundingClientRect();

          return (
            rect.top >= 0 &&
            //rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight)
          );
        }

        var clickvolume = 0;
           $(".az-volume-video").click(function(){
               if(clickvolume == 0){
                   $('.az-volume-video').attr("src","/templates/home/styles/images/svg/icon-volume-on.svg");
                   $('#video_<?php echo $item->not_id; ?>').prop('muted', false);
                   clickvolume = 1;
               } else {
                   $('.az-volume-video').attr("src","/templates/home/styles/images/svg/icon-volume-off.svg");
                   $('#video_<?php echo $item->not_id; ?>').prop('muted', true);
                   clickvolume = 0;
               }
        });

    </script>
    <?php $this->load->view('home/tintuc/popup-info-detail'); ?>

    <script type="text/javascript" language="javascript" >
    <?php if (isset($popup)) {?>
    $(function(){
        $('.load-wrapp').show();
        $('#modal-show-detail-img .share-click-popup').attr('data-pop', <?php echo $popup;?>);
        $('body .popup-detail-image').trigger('click');
    });
    <?php } ?>
    </script>

    <?php $this->load->view('home/tintuc/popup/popup-list-like'); ?>
    <script type="text/javascript">
    $(function(){
        $(window).load(function(){
            var url_current = window.location.href;
            var id_img = url_current.split('#image_')[1];

            if(url_current.indexOf('#image_'+id_img) >= 0){
                var height_md = $('.trangtinchitiet .header.md').innerHeight();
                var height_sm = $('.trangtinchitiet .sm.header-sp').innerHeight();
                var scrolltop = 0;
                if(height_md > 0){
                    scrolltop = -height_md;
                }
                else{
                    scrolltop = -height_sm;
                }
                window.scrollBy(0, scrolltop);
            }
        });
    });

    /*type_show == 1*/
    if($('body .trangcuahang').hasClass('trangtinchitiet-v2-v3')){

    }else if($('body .trangcuahang').hasClass('trangtinchitiet-v2-v3')){
    /*type_show == 2*/

    }else{
    /*type_show == 0*/
    }

    $('.has-video-image.version01 .addlinkthem-slider.three-sliders').slick({
        lazyLoad: 'ondemand',
        slidesToShow: 3,
        slidesToScroll: 2,
        arrows: true,
        dots: false,
        infinite: false,
        speed: 300,
        variableWidth: true,
        responsive: [
            {
                breakpoint: 768,
                settings: {
                    slidesToShow: 2.5,
                    slidesToScroll: 2,
                    arrows: false,
                }
            }
        ]
    });
    $('.addlinkthem.version02 .addlinkthem-slider.three-sliders').slick({
        lazyLoad: 'ondemand',
        arrows: false,
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 1.2,
        slidesToScroll: 2
    });

    /*style show = 2*/
    $('.addlinkthem.addlinkthem-detail-v3 .addlinkthem-slider.three-sliders, .addlinkthem.addlinkthem-detail-v3 .addlinkthem-slider.two-sliders').slick({
        lazyLoad: 'ondemand',
        arrows: false,
        dots: false,
        infinite: false,
        speed: 300,
        slidesToShow: 1.2,
        slidesToScroll: 1
    });
    </script>
</body>
</html>
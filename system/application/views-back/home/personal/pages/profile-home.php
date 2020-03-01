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
<div class="sidebar md">
    <?php echo $this->load->view('home/personal/elements/siderbar_left', [
        'profile_url'       => $info_public['profile_url'],
        'profile_shop_url'  => $profile_shop_url
    ]) ?>
    <div class="sidebar-right tablet">
        <?php echo $this->load->view('home/common/ads_right') ?>
    </div>
</div>
<div class="content">
    <div class="sidebar-right tablet-none md fixtoscroll">
        <?php echo $this->load->view('home/common/ads_right') ?>
    </div>

    <?php if ($is_owner) { ?>
        <div class="blockdangtin">
            <?php $this->load->view('home/tintuc/dangtin_person', array('page_personal' => true)); ?>
        </div>
    <?php } ?>

    <ul class="listtabtitle hide_0">
        <li class="is-active">Tất cả</li>
        <li>@banchiase</li>
        <li>Gắn thẻ @ban</li>
    </ul>

    <!--    get videos news -->
    <?php if (!empty($videos)){ ?>
        <div class="tindoanhnghiep-video">
            <div class="tindoanhnghiep-tit">
                <a target="_blank" href="<?php echo $info_public['profile_url'] ?>library/videos">
                    <span class="title-border bold_text">
                        <img src="/templates/home/styles/images/svg/camera.svg" width="24" alt="" class="mr10">
                        Video <span>(<?php echo formatNumber($videos_news_total) ?>)</span>
                    </span>
                </a>
                <a target="_blank" href="<?php echo $info_public['profile_url'] ?>library/videos">Xem tất cả</a>
            </div>
            <div class="shop-news-page list-video">
                <ul class="slider list-video-slider js_content-video">
                    <?php foreach ($videos as $k => $video) {
                        $url_news = $info_public['profile_url'] . 'news/detail/' . $video->not_id . '/' . RemoveSign($video->not_title);
                        $this->load->view('shop/news/elements/news_video_slider_item', ['video' => $video, 'k' => $k, 'url_news' => $url_news]);
                    } ?>
                </ul>
            </div>
            <script>
                if($('.list-video-slider').length) {
                    $('.list-video-slider').slick({
                        slidesToShow: 2.5,
                        slidesToScroll: 1,
                        arrows: false,
                        dots: false,
                        infinite: false,
                        responsive: [
                            {
                                breakpoint: 768,
                                settings: {
                                    slidesToShow: 1.1,
                                    slidesToScroll: 1
                                }
                            }
                        ]
                    });

                    $('.list-video-slider').on('beforeChange', function(event, slick, currentSlide, nextSlide){
                        var el_current = slick.$slides.get(currentSlide);
                        var el_next = slick.$slides.get(nextSlide);
                        $('.js_btn-pause', el_current).removeClass('hidden');
                        $('.js_btn-pause', el_next).addClass('hidden');
                        if($('.list-video-slider video.video-play').length){
                            $('.list-video-slider video.video-play').each(function () {
                                $(this).trigger("pause");
                            });
                        }
                        $('video', el_next).trigger("play");
                    });
                }
            </script>
        </div>
    <?php } ?>

    <div class="group-album">
        <!--    get images news -->
        <?php if (!empty($images)){ ?>
            <div class="item">
                <div class="tindoanhnghiep-tit">
                    <a target="_blank" href="<?php echo $info_public['profile_url'] ?>library/images">
                        <span class="title-border bold_text">
                            <img src="/templates/home/styles/images/svg/camera.svg" width="24" alt="" class="mr10">Ảnh <span>(<?php echo formatNumber($images_total) ?>)</span>
                        </span>
                    </a>
                </div>
                <div class="ex-img <?php echo sizeof($images) == 1 ? 'one-img' : '' ?>">
                    <?php foreach ($images as $key => $image) {
                        if($image->img_up_detect == IMAGE_UP_DETECT_CONTENT) {
                            $image_wall_xss = htmlspecialchars($image->title ? : $image->not_title);
                            $filename = DOMAIN_CLOUDSERVER . 'media/images/content/' . $image->not_dir_image . '/' . ($image->link_crop ? $image->link_crop : $image->name);
                        } else if($image->img_up_detect == IMAGE_UP_DETECT_LIBRARY) {
                            $image_wall_xss = htmlspecialchars($image->img_library_title);
                            $filename = DOMAIN_CLOUDSERVER . 'media/images/album/' . $image->img_library_dir . '/' . $image->name;
                        } else {
                            $image_wall_xss = '';
                            $filename = '';
                        }
                        ?>
                        <p>
                            <a href="<?php echo $info_public['profile_url'] ?>library/images" target="_blank" title="<?php echo $image_wall_xss ?>">
                                <img onerror="image_error(this)"  src="<?php echo $filename ?>" alt="<?php echo $image_wall_xss ?>" data-title="<?php echo $image_wall_xss ?>">
                            </a>
                        </p>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>

        <?php if (!empty($customlinks)){ ?>
            <div class="item">
                <a target="_blank" href="<?php echo $info_public['profile_url'] ?>library/links">
                    <div class="tindoanhnghiep-tit">
                        <span class="title-border bold_text">
                            <img src="/templates/home/styles/images/svg/lienket.svg" width="24" alt="" class="mr10">Liên kết <span>(<?php echo formatNumber($customlink_total[0]['total']) ?>)</span>
                        </span>
                    </div>
                </a>
                <div class="ex-img">
                    <?php foreach ($customlinks as $customlink) {?>
                        <?php
                        $customlink_title_xss = htmlspecialchars($customlink['link_title']);
                        $link     = '';

                        if($customlink['type_tbl'] == LINK_TABLE_LIBRARY){
                            $link       = 'library-link/';
                        }
                        if($customlink['type_tbl'] == LINK_TABLE_CONTENT){
                            $link       = 'content-link/';
                        }
                        if($customlink['type_tbl'] == LINK_TABLE_IMAGE){
                            $link       = 'image-link/';
                        }
                        if($customlink['image']) {
                            $image_custom_link = $server_media . $customlink['image'];
                        }else{
                            $image_custom_link = $customlink['link_image'];
                        }
                        ?>
                        <p>
                            <a href="<?php echo $info_public['profile_url'] . $link . $customlink['id'] ?>" title="<?php echo $customlink_title_xss ?>">
                                <img onerror="image_error(this)" src="<?php echo $image_custom_link ?>" alt="<?php echo $customlink_title_xss ?>">
                            </a>
                        </p>
                    <?php } ?>
                </div>
            </div>
        <?php } ?>
    </div>

    <div class="sm hide_0">
        <div class="group-album">
            <div class="tindoanhnghiep-tit">
                <span class="title-border"><img src="/templates/home/styles/images/svg/friend.svg" alt="" class="mr10">Bạn bè <span>(264)</span></span>
            </div>
            <div class="list-friends-sm">
                <p><a href=""><img src="/templates/home/styles/images/hinhanh/01.jpg" alt=""></a></p>
                <p><a href=""><img src="/templates/home/styles/images/hinhanh/02.jpg" alt=""></a></p>
                <p><a href=""><img src="/templates/home/styles/images/hinhanh/03.jpg" alt=""></a></p>
                <p><a href=""><img src="/templates/home/styles/images/hinhanh/04.jpg" alt=""></a></p>
                <p><a href=""><img src="/templates/home/styles/images/hinhanh/05.jpg" alt=""></a></p>
                <p><a href=""><img src="/templates/home/styles/images/hinhanh/06.jpg" alt=""></a></p>
                <p><a href=""><img src="/templates/home/styles/images/hinhanh/07.jpg" alt=""></a></p>
                <p><a href=""><img src="/templates/home/styles/images/hinhanh/08.jpg" alt=""></a></p>
            </div>
        </div>
    </div>

    <?php if(!empty($collections) || $is_owner){ ?>
        <div class="tindoanhnghiep-video">
            <div class="tindoanhnghiep-tit">
                <a target="_blank" href="<?php echo $profile_shop_url. '/shop/collection' ?>">
                    <span class="title-border bold"><img src="/templates/home/styles/images/svg/bookmark.svg" width="24" alt="" class="mr10">Bộ sưu tập <span>(<?php echo formatNumber($collection_total['total']) ?>)</span></span>
                </a>
                <a target="_blank" href="<?php echo $profile_shop_url . '/shop/collection' ?>">Xem tất cả</a>
            </div>
            <div class="list-bosuutap">
                <ul class="list-bosuutap-slider">
                    <?php if ($is_owner){ ?>
                        <li class="add">
                            <a href="#"><img src="/templates/home/styles/images/svg/add.svg" alt=""></a>
                        </li>
                    <?php } ?>
                    <?php if(!empty($collections)){ ?>
                        <?php foreach ($collections as $collection) {?>
                            <?php $coll_title_xss = htmlspecialchars($collection->name) ?>
                            <li>
                                <a title="<?php echo $coll_title_xss ?>" target="_blank" href="<?php echo $profile_shop_url. '/shop/collection' ?>">
                                    <img src="<?php echo $collection->avatar_path_full; ?>" title="<?php echo $coll_title_xss ?>" alt="<?php echo $coll_title_xss ?>">
                                    <p><?php echo $collection->name ?></p>
                                </a>
                            </li>
                        <?php } ?>
                    <?php } ?>
                </ul>
            </div>
        </div>
    <?php } ?>
    <div class="content-posts" id="content" data-type="1">
        <?php if (!empty($news)) {
            $root_url = azibai_url();
            foreach ($news as $key => $item) {
                $item->root_url = $root_url;
                $this->load->view('home/tintuc/item', array('item' => $item, 'personal_page' => 1, 'isMobile' => $isMobile));

                if(!empty($item->suggest_list)) {
                    foreach ($item->suggest_list as $key => $value) {
                        echo $value;
                    }
                }
            }
        } ?>
    </div>
</div>

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
<?php
block_js([
    '<script> var type_link_template =  "content_index"; </script>',
    '<script src="/templates/home/styles/js/shop/shop-library-custom-link-v2.js"></script>',
]);
?>
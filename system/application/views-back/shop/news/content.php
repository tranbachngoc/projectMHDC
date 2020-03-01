<?php
$cover_path = 'shop/news/elements/cover_not_login';
if($is_owns){
    $cover_path = 'shop/news/elements/cover_login';
}
?>
<main class="trangcuatoi tindoanhnghiep">
    <section class="main-content">
        <div class="container">
            <div class="cover-content">
                <?php echo $this->load->view($cover_path);  ?>
            </div>
            <div class="sidebarsm">
                <div class="gioithieu">
                    <?php $this->load->view('shop/news/elements/menu_left_items') ?>
                </div>
            </div>
        </div>
        <div class="container clearfix">

            <div class="sidebar md ">
                <div class="fixtoscroll">
                    <?php echo $this->load->view('shop/news/elements/sidebar_left') ?>
                </div>
                <div class="sidebar-right fixtoscroll tablet-none" style="right: 0">
                    <?php echo $this->load->view('shop/news/elements/sidebar_right') ?>
                </div>
            </div>

            <div class="content">
                <?php if($is_owns) { ?>
                    <div class="blockdangtin">
                        <?php $this->load->view('home/tintuc/dangtin', array()); ?>
                    </div>
                <?php } ?>
                <div class="tindoanhnghiep-content">
                    <div class="tindoanhnghiep-info">
                        <div class="tindoanhnghiep-tit pl00">
                            Thông tin
                            <a href="<?php echo $shop_url . 'shop/introduct' ?>" class="md">Xem tất cả</a>
                        </div>
                        <ul class="list-info">
                            <li>
                                <?php
                                $shop_address = trim(strip_tags($siteGlobal->sho_address));
                                if (!empty($siteGlobal->distin)){
                                    $shop_address  .= ', ' . $siteGlobal->distin['DistrictName'] . ', ' . $siteGlobal->distin['ProvinceName'];
                                }
                                ?>
                                <a target="_blank" href="https://www.google.com/maps?q=<?php echo $shop_address ?>">
                                    <img src="/templates/home/styles/images/svg/map.svg" width="24" class="mr10" alt="">
                                    <?php echo $shop_address; ?>
                                </a>
                            </li>
                            <?php if($siteGlobal->sho_phone || $siteGlobal->sho_mobile) { ?>
                                <li>
                                    <?php $num_phone = $siteGlobal->sho_mobile ? $siteGlobal->sho_mobile : ($siteGlobal->sho_phone ? $siteGlobal->sho_phone : '')?>
                                    <a href="tel:<?php echo $num_phone; ?>">
                                        <img src="/templates/home/styles/images/svg/tel02.svg" width="24" class="mr10" alt="">
                                        <?php echo $num_phone; ?>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if($siteGlobal->sho_email) { ?>
                                <li>
                                    <a href="mailto:<?php echo $siteGlobal->sho_email ?>">
                                        <img src="/templates/home/styles/images/svg/email.svg" width="24" class="mr10" alt="">
                                        <?php echo $siteGlobal->sho_email ?>
                                    </a>
                                </li>
                            <?php } ?>
                            <?php if ($siteGlobal->sho_website) {?>
                                <li>
                                    <a href="<?php echo $siteGlobal->sho_website ?>" target="_blank">
                                        <img src="/templates/home/styles/images/svg/user@.svg" width="24" class="mr10" alt="">
                                        <?php echo trim_protocol($siteGlobal->sho_website) ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </ul>
                        <p class="sm"><a href="<?php echo $shop_url . 'shop/introduct' ?>">Xem chi tiết</a></p>
                    </div>
                </div>
                <!--    get videos news -->
                <?php if (!empty($list_videos)){ ?>
                    <div class="tindoanhnghiep-video">
                        <div class="tindoanhnghiep-tit">
                            <a target="_blank" href="<?php echo $shop_url ?>library/videos">
                                <span class="title-border bold_text">
                                    <img src="/templates/home/styles/images/svg/camera.svg" width="24" alt="" class="mr10">
                                    Video <span>(<?php echo formatNumber($videos_news_total) ?>)</span>
                                </span>
                            </a>
                            <a target="_blank" href="<?php echo $shop_url ?>library/videos">Xem tất cả</a>
                        </div>
                        <div class="shop-news-page list-video">
                            <ul class="slider list-video-slider js_content-video">
                                <?php foreach ($list_videos as $k => $video) {
                                    $url_news = $shop_url . 'news/detail/' . $video->not_id . '/' . RemoveSign($video->not_title);
                                    $this->load->view('shop/news/elements/news_video_slider_item', ['video' => $video, 'k' => $k, 'url_news' => $url_news]);
                                } ?>
                            </ul>
                        </div>
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
                <?php } ?>

                <div class="group-album">
                    <!--    get images news -->
                    <?php if (!empty($images)){ ?>
                        <div class="item">
                            <div class="tindoanhnghiep-tit">
                                <a target="_blank" href="<?php echo $shop_url ?>library/images">
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
                                        <a href="<?php echo $shop_url ?>library/images" target="_blank" title="<?php echo $image_wall_xss ?>">
                                            <img onerror="image_error(this)"  src="<?php echo $filename ?>" alt="<?php echo $image_wall_xss ?>" data-title="<?php echo $image_wall_xss ?>">
                                        </a>
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (!empty($customlinks)){ ?>
                        <div class="item">
                            <a target="_blank" href="<?php echo $shop_url ?>library/links">
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
                                        <a href="<?php echo $shop_url . $link . $customlink['id'] ?>" title="<?php echo $customlink_title_xss ?>">
                                            <img onerror="image_error(this)" src="<?php echo $image_custom_link ?>" alt="<?php echo $customlink_title_xss ?>">
                                        </a>
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($list_products)) { ?>
                        <div class="item sm">
                            <a target="_blank" href="<?php echo $shop_url . 'library/products' ?>">
                                <div class="tindoanhnghiep-tit">
                                    <span class="title-border"><img src="/templates/home/styles/images/svg/sanpham.svg" alt="" class="mr10">Sản phẩm <span>(<?php echo formatNumber($product_total['total']) ?>)</span></span>
                                </div>
                            </a>
                            <div class="ex-img">
                                <?php
                                foreach ($list_products as $key => $product) {
                                    if ($key > 3) {
                                        break;
                                    }
                                    $filename = DEFAULT_IMAGE_ERROR_PATH;
                                    if ($product->pro_image) {
                                        $filename = @DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_2_' . explode(',', $product->pro_image)[0];
                                    }
                                    $pro_name_xss  = htmlspecialchars($product->pro_name);
                                ?>
                                    <p>
                                        <a href="<?php echo $shop_url . 'library/products' ?>" title="<?php echo $pro_name_xss ?>">
                                            <img src="<?php echo $filename ?>" alt="<?php echo $pro_name_xss ?>">
                                        </a>
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?php if (!empty($coupons)) { ?>
                        <div class="item sm">
                            <a target="_blank" href="<?php echo $shop_url ?>library/coupons">
                                <div class="tindoanhnghiep-tit">
                                    <span class="title-border bold_text">
                                        <img src="/templates/home/styles/images/svg/dichvu.svg" width="24" alt="" class="mr10">
                                        Coupon <span>(<?php echo formatNumber($coupon_total['total']) ?>)</span>
                                    </span>
                                </div>
                            </a>
                            <div class="ex-img">
                                <?php foreach ($coupons as $key => $coupon) {
                                    if ($key > 3) {
                                        break;
                                    }
                                    $filename = DEFAULT_IMAGE_ERROR_PATH;
                                    if ($coupon->pro_image) {
                                        $filename = @DOMAIN_CLOUDSERVER . 'media/images/product/' . $coupon->pro_dir . '/thumbnail_2_' . explode(',', $coupon->pro_image)[0];
                                    }
                                    $coupon_name_xss  = htmlspecialchars($coupon->pro_name);
                                    ?>
                                    <p>
                                        <a title="<?php echo $coupon_name_xss ?>" target="_blank" href="<?php echo $shop_url ?>library/coupons">
                                            <img onerror="image_error(this)" src="<?php echo $filename ?>" alt="<?php echo $coupon_name_xss ?>">
                                        </a>
                                    </p>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <?php if(!empty($collections) || $is_owns){ ?>
                    <div class="tindoanhnghiep-video">
                        <div class="tindoanhnghiep-tit">
                            <a target="_blank" href="<?php echo $shop_url ?>shop/collection">
                                <span class="title-border bold"><img src="/templates/home/styles/images/svg/bookmark.svg" width="24" alt="" class="mr10">Bộ sưu tập <span>(<?php echo formatNumber($collection_total['total']) ?>)</span></span>
                            </a>
                            <a target="_blank" href="<?php echo $shop_url . 'shop/collection' ?>">Xem tất cả</a>
                        </div>
                        <div class="list-bosuutap">
                            <ul class="list-bosuutap-slider">
                                <?php if ($is_owns){ ?>
                                    <li class="add">
                                        <a href="#"><img src="/templates/home/styles/images/svg/add.svg" alt=""></a>
                                    </li>
                                <?php } ?>
                                <?php if(!empty($collections)){ ?>
                                    <?php foreach ($collections as $collection) {?>
                                        <?php $coll_title_xss = htmlspecialchars($collection->name);
                                        ?>
                                        <li>
                                            <a title="<?php echo $coll_title_xss ?>" target="_blank" href="<?php echo $shop_url . 'shop/collection' ?>">
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

                <div class="flex-between-center">
                    <ul class="listtabtitle mt00 mb00">
                        <li class="is-active">Tất cả</li>
                        <li>@toichiase</li>
                        <li>Gắn thẻ @toi</li>
                    </ul>
                </div>
                <div class="content-posts" id="content" data-type="1">
                    <?php
                    $shop_url_slash = rtrim($shop_url, '/');
                    if (!empty($list_news)){
                        foreach ($list_news as $key => $item) {
                            $item->root_url   = $shop_url_slash;
                            $item->show_shop  = true;
                            $this->load->view('home/tintuc/item', array('item' => $item, 'home_page' => true));

                            if(!empty($item->suggest_list)) {
                                foreach ($item->suggest_list as $key => $value) {
                                    echo $value;
                                }
                            }
                        }
                    } ?>
                </div>
            </div>
        </div>
    </section>
</main>
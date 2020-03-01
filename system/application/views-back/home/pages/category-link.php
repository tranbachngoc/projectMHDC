<main class="trangcuatoi tindoanhnghiep">
    <section class="main-content  bg-purple-black">
        <div class="container bg-black-container liet-ke-hinh-anh">
            <div class="socials-logos">
                <?php if(!empty($bookmarks)){
                    $this->load->view('shop/media/elements/library-links/bookmark-item', ['bookmarks' => $bookmarks]);
                } ?>
                <div class="js-scroll-x mt-4">
                    <div class="tag-column-parent">
                        <?php
                        $this->load->view('home/links/item_category_parent', [
                            'category'   => [
                                'slug'  => '',
                                'name'  => 'Tất cả',
                            ],
                            'domain_url' => $domain_url,
                        ]);
                        $this->load->view('home/links/item_category_parent', [
                            'category'   => [
                                'slug'  => 'moi-nhat',
                                'name'  => 'Mới nhất',
                            ],
                            'category_parent' => [
                                'slug' => $category_slug
                            ],
                            'domain_url' => $domain_url,
                        ]);

                        if(!empty($categories_parent)){
                            foreach ($categories_parent as $cat_parent) {
                                $this->load->view('home/links/item_category_parent', [
                                    'category'   => $cat_parent,
                                    'domain_url' => $domain_url,
                                ]);
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php if(!empty($categories_child)){ ?>
                    <div class="js-scroll-x mt-2 mb-lg-3">
                        <div class="tag-column-children">
                            <?php
                            if(!empty($category_parent) && empty($category_slug)){
                                $this->load->view('home/links/item_category_child', [
                                    'category'   => [
                                        'id'    => '',
                                        'slug'  => 'tat-ca',
                                        'name'  => 'tất cả',
                                    ],
                                    'domain_url'    => $domain_url,
                                    'category_slug' => $category_parent['slug'],
                                ]);
                            }else{
                                $this->load->view('home/links/item_category_child', [
                                    'category'   => $category_temp = [
                                        'id'    => '',
                                        'slug'  => $category_parent['slug'],
                                        'name'  => 'tất cả',
                                    ],
                                    'domain_url'    => $domain_url,
                                ]);
                            }

                            foreach ($categories_child as $child) {
                                $this->load->view('home/links/item_category_child', [
                                    'category'      => $child,
                                    'domain_url'    => $domain_url,
                                    'category_slug' => $category_slug,
                                ]);
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
                <!-- thanh điều hướng -->
                <?php $this->load->view('home/links/link-direction', [
                    'view_type'          => $view_type,
                    'category_link_page' => true,
                ]); ?>
                <script>
                    if($('.js-slider-tag-column').length){
                        $('.js-slider-tag-column').slick({
                            slidesToShow: 7,
                            slidesToScroll: 3,
                            arrows: true,
                            dots: false,
                            variableWidth: true,
                            infinite: false,
                            responsive: [
                                {
                                    breakpoint: 769,
                                    settings: {
                                        slidesToShow: 4.5,
                                        slidesToScroll: 2,
                                        variableWidth: true,
                                        arrows: false,
                                        infinite: false,
                                    }
                                },
                                {
                                    breakpoint: 768,
                                    settings: {
                                        slidesToShow: 4,
                                        slidesToScroll: 2,
                                        variableWidth: true,
                                        arrows: false,
                                        infinite: false,
                                    }
                                }
                            ]
                        });
                    }
                </script>
            </div>
            <div class="group-list-link-content">
                <?php if(!empty($links)){ ?>
                    <?php
                    $item_cat  = $links[0];
                    $image     = $item_cat['image'] ? ($server_media. $item_cat['image']) : $item_cat['link_image'];
                    $type_tbl  = '';

                    if($item_cat['type_tbl'] == LINK_TABLE_LIBRARY){
                        $type_tbl   = 'library-link';
                    }
                    if($item_cat['type_tbl'] == LINK_TABLE_CONTENT){
                        $type_tbl   = 'content-link';
                    }
                    if($item_cat['type_tbl'] == LINK_TABLE_IMAGE){
                        $type_tbl   = 'image-link';
                    }
                    $selector_category_item = 'js_library-category-item-'. $item_cat['id'];
                    ?>

                    <div class="list-link-content <?php echo (!empty($category_parent) ? $category_parent['class_bg_color'] : '') ?>">
                        <div class="wrap-newest-post <?php echo $selector_category_item ?>">
                            <div class="newest-post">
                                <a title="<?php echo htmlspecialchars($item_cat['link_title']); ?>" target="_blank" href="<?php echo $domain_url . '/links/'. $type_tbl .'/'. $item_cat['id'] ?>">
                                    <?php
                                    if($item_cat['video']) {
                                        $btn_play_video  = 'btn_play_link_' . $item_cat['id'];
                                        $video_target     = 'content_link_' . $item_cat['id'];
                                        ?>
                                        <div class="wrap-video-item-single block_video">
                                            <video class="detail-video"
                                                   preload="none"
                                                   id="<?php echo $video_target ?>"
                                                   playsinline
                                                   data-target_video="#<?php echo $video_target ?>"
                                                   data-target_btn_volume=".js_btn-volume-<?php echo $item_cat['id']?>"
                                                   data-target_btn_play=".<?php echo $btn_play_video ?>"
                                                   muted
                                                   poster="<?php echo $image;?>">
                                                <source src="<?=  $server_media . $item_cat['video'] ?>" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                            <div data-video-id="<?php echo $video_target ?>"
                                                 data-target_video="#<?php echo $video_target ?>"
                                                 data-target_btn_play=".<?php echo $btn_play_video ?>"
                                                 class="btn-pause js_btn-pause <?php echo $btn_play_video ?>">
                                                <img class="js_img-play" src="/templates/home/styles/images/svg/play_video.svg" alt="action video">
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="img">
                                            <img src="<?php echo $image ?>"
                                                 onerror="image_error(this, '.<?php echo $selector_category_item ?>')"
                                                 alt="<?php echo htmlspecialchars($item_cat['link_title']); ?>">
                                        </div>
                                    <?php } ?>
                                </a>
                                <div class="head">
                                    <p class="tit"><?php echo $category_slug == 'moi-nhat' ? 'Mới nhất' : ucfirst($category_current['name']) ?></p>
                                </div>
                                <div class="text">
                                    <a target="_blank" ref="nofollow" href="<?php echo $item_cat['link']?>">
                                        <p class="text-bold">Nguồn: <?php echo $item_cat['host'] ?></p>
                                    </a>
                                    <a target="_blank" ref="nofollow" href="<?php echo $item_cat['link']?>">
                                        <h3 class="one-line"><?php echo $item_cat['link_title'] ?></h3>
                                    </a>
                                </div>
                                <div class="newest-post-edit">
                                    <div class="main">
                                        <div class="p-2 cursor-pointer icon js_library-link-show-more"
                                             data-id="<?php echo $item_cat['id'] ?>"
                                             data-link="<?php echo $item_cat['link'] ?>"
                                             data-type="<?php echo $type_tbl ?>"
                                             data-link_id="<?php echo $item_cat['link_id'] ?>"
                                             data-value="<?php echo $domain_url . '/links/'. $type_tbl .'/'. $item_cat['id'] ?>"
                                             data-name="<?php echo $item_cat['link_title'] ?>">
                                            <img src="/templates/home/styles/images/svg/3dot_doc_white.svg">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid">
                            <?php
                            foreach ($links as $key_link => $link) {
                                if($key_link == 0)
                                    continue;

                                $this->load->view('home/links/item_link', [
                                    'item'          => $link,
                                    'server_media'  => $server_media,
                                    'url_item'      => $domain_url,
                                ]);
                            }
                            ?>
                        </div>
                    </div>
                <?php } ?>
            </div>

        </div>
    </section>
</main>
<!--popup item-->
<?php
if(!empty($user_login)){
    $params = [
        'title_popup' => 'Lưu liên kết'
    ];
    if (!empty($user_login['my_shop'])){
        $params['sho_id']       = $user_login['my_shop']['sho_id'];
        $params['default_shop'] = true;
    }
    $this->load->view('shop/media/elements/library-links/popup-custom-link-create', $params);
}
$this->load->view('shop/media/elements/library-links/library-link-popup-action', ['is_owns' => false]);
$this->load->view('home/links/popup-common-link');
/* include script file into bottom layout extend*/
block_css([
    '<link rel="stylesheet" href="/templates/home/styles/font/font-awesome-4.7.0/css/font-awesome.css">',
    '<link rel="stylesheet" href="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.css">',
    '<link rel="stylesheet" href="/templates/home/styles/css/shop/shop-media.css">',
]);
block_js([
    '<script src="/templates/home/styles/js/azibai-links/azibai-hidden-error-images.js"></script>',
    '<script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>',
    '<script src="/templates/home/styles/plugins/lazyload/jquery.lazyload.js" type="text/javascript"></script>',
    '<script src="/templates/home/styles/js/clipboard.min.js" type="text/javascript"></script>',
    '<script src="/templates/home/styles/plugins/masonry/masonry.pkgd.js"></script>',
    '<script src="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>',
], 'script_prioritize_tags');
block_js([
    '<script src="/templates/home/styles/js/shop/shop-bookmark.js"></script>',
    '<script src="/templates/home/styles/js/azibai-links/azibai-link.js"></script>',
    '<script src="/templates/home/styles/js/azibai-links/azibai-category-link.js"></script>',
]);
?>

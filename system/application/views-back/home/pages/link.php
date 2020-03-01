<main class="trangcuatoi tindoanhnghiep">
    <section class="main-content bg-purple-black">
        <div class="container liet-ke-hinh-anh">
            <div class="socials-logos">
                <?php if(!empty($bookmarks)){
                    $this->load->view('shop/media/elements/library-links/bookmark-item', ['bookmarks' => $bookmarks]);
                } ?>
                <div class="js-scroll-x mt-4">
                    <div class="tag-column-parent">
                        <?php
                        $this->load->view('home/links/item_category_parent', [
                            'category'   => [
                                'slug'  => 'tat-ca',
                                'name'  => 'tất cả',
                            ],
                            'category_parent' => [
                                'slug' => 'tat-ca'
                            ],
                            'domain_url' => $azibai_url,
                        ]);
                        $this->load->view('home/links/item_category_parent', [
                            'category'   => [
                                'slug'  => 'moi-nhat',
                                'name'  => 'Mới nhất',
                            ],
                            'domain_url' => $azibai_url,
                        ]);

                        if(!empty($categories_parent)){
                            foreach ($categories_parent as $category_parent) {
                                $this->load->view('home/links/item_category_parent', [
                                    'category'   => $category_parent,
                                    'domain_url' => $azibai_url,
                                ]);
                            }
                        }
                        ?>
                    </div>
                </div>
                <?php if(!empty($categories_child)){ ?>
                    <div class="js-scroll-x mt-2">
                        <div class="tag-column-children">
                            <?php
                            $this->load->view('home/links/item_category_child', [
                                'category'   => [
                                    'id'    => '',
                                    'slug'  => 'tat-ca',
                                    'name'  => 'tất cả',
                                ],
                                'domain_url' => $azibai_url,
                            ]);
                            foreach ($categories_child as $category_child) {
                                $this->load->view('home/links/item_category_child', [
                                    'category'   => $categories_child,
                                    'domain_url' => $azibai_url,
                                ]);
                            } ?>
                        </div>
                    </div>
                <?php } ?>
                <!-- thanh điều hướng -->
                <?php $this->load->view('home/links/link-direction', ['view_type' => $view_type]) ?>
                <script>
                    if($(".js-scroll-x").length){
                        $(".js-scroll-x").mCustomScrollbar({
                            axis:"x",
                            theme:"dark-thin",
                            autoExpandScrollbar:true,
                            advanced:{autoExpandHorizontalScroll:true}
                        });
                    }
                </script>
            </div>
            <!-- load block category  --->
            <div class="group-list-link-content">
                <?php
                /*block new*/
                if(!empty($links_new)){
                    $html_item_temp_new      = '';
                    $html_wrap_item_temp_new = '';
                    $total_link_new          = sizeof($links_new);
                    foreach ($links_new as $key_new => $link_item) {
                        if($key_new == 0){
                            continue;
                        }
                        $html_item_temp_new .= $this->load->view('home/links/item_link', [
                            'item'          => $link_item,
                            'server_media'  => $server_media,
                            'url_item'      => $azibai_url,
                        ], true);

                        if(($key_new % 5 == 0) || ($total_link_new == ($key_new + 1))){
                            $html_wrap_item_temp_new .= '<div class="item-slider '.$key_new.'">';
                            $html_wrap_item_temp_new .= $html_item_temp_new;
                            $html_wrap_item_temp_new .= '</div>';
                            $html_item_temp_new      = '';
                        }

                    }
                    $this->load->view('home/links/item_block_link_category', [
                        'domain_url'   => $azibai_url,
                        'category'     => [
                            'slug' => 'moi-nhat',
                            'name' => 'Mới nhất',
                        ],
                        'html_submenu' => '',
                        'html_item'    => $html_wrap_item_temp_new,
                        'item'         => $links_new[0],
                        'url_item'     => $azibai_url,
                    ]);
                    unset($html_wrap_item_temp_new);
                    unset($html_item_temp_new);
                }
                /*block categories*/
                $this->load->view('home/links/link_category_block_item');
                ?>
            </div>
        </div>
    </section>
</main>
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
    '<script src="/templates/home/styles/plugins/masonry/masonry.pkgd.js"></script>',
    '<script src="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>',
    '<script src="/templates/home/styles/plugins/imagesloaded/imagesloaded.pkgd.min.js"></script>',
    '<script src="/templates/home/styles/plugins/lazyload/jquery.lazyload.js" type="text/javascript"></script>',
    '<script src="/templates/home/styles/plugins/slick/slick.js"></script>',
    '<script src="/templates/home/styles/plugins/slick/slick-slider.js"></script>',
], 'script_prioritize_tags');
block_js([
    '<script src="/templates/home/styles/js/azibai-links/azibai-link.js"></script>',
    '<script src="/templates/home/styles/js/azibai-links/azibai-link-layout.js"></script>',
    '<script src="/templates/home/styles/js/shop/shop-bookmark.js"></script>'
]);
?>
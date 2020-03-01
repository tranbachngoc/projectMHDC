<div class="bosuutap-header-tabs js-scroll-x">
    <ul class="bosuutap-header-tabs-content ">
        <li class="active"><a href="#">Liên kết</a></li>
        <li><a href="<?php echo $profile_shop_url . '/shop/collection-link' ?>">BST Liên kết</a></li>
    </ul>
</div>
<?php if(!empty($is_owner)){ ?>
    <div class="icon-add">
        <div class="icon-add-logo" data-toggle="dropdown">
            <img src="/templates/home/styles/images/svg/sanazibai_add.svg" alt="">
        </div>
        <div class="icon-add-hover dropdown-menu">
            <p data-toggle="modal" data-target="#popup-crawl-custom-link">Thêm liên kết</p>
            <p id="creatNewCollectionLinks">Thêm BST liên kết</p>
            <p data-toggle="modal" data-target="#addBookmarkLinks">Thêm lối tắt</p>
        </div>
    </div>
<?php } ?>
<div class="socials-logos">
    <?php if(!empty($bookmarks)){
        $this->load->view('shop/media/elements/library-links/bookmark-item', ['bookmarks' => $bookmarks]);
    } ?>
    <div class="tag-column">
        <!--category parent-->
        <?php if(!empty($categories_parent)){
            $this->load->view('shop/media/elements/library-links/library-link-category-parent', [
                'categories' => $categories_parent
            ]);
        } else { ?>
        <!-- chưa có danh mục nào có link-->
            <div class="js-scroll-x">
                <div class="tag-column-parent">
                    <span class="is-active">Tất cả</span>
                </div>
            </div>
        <?php } ?>
        <!--category child-->
        <?php if(!empty($categories_child)){
            $this->load->view('shop/media/elements/library-links/library-link-category-child', [
                'categories_child' => $categories_child
            ]);
        } ?>
    </div>
    <!-- thanh điều hướng -->
    <?php $this->load->view('shop/media/elements/library-links/library-direction', [
        'view_type' => $view_type,
    ]) ?>
</div>
<div class="group-list-link-content">
    <!--Link mới nhất-->
    <?php
    /*block new*/
    if(!empty($links_new)){
        $html_item_temp_new      = '';
        $html_wrap_item_temp_new = '';
        $total_link_new = sizeof($links_new);
        foreach ($links_new as $key_new => $link) {
            if($key_new == 0){
                continue;
            }
            $html_item_temp_new .= $this->load->view('shop/media/elements/library-links/library-item-v2', [
                'item'          => $link,
                'server_media'  => $server_media,
                'is_owns'       => $is_owns,
                'url_item'      => $url_item,
            ], true);

            if(($key_new % 5 == 0) || ($total_link_new == ($key_new + 1))){
                $html_wrap_item_temp_new .= '<div class="item-slider '.$key_new.'">';
                $html_wrap_item_temp_new .= $html_item_temp_new;
                $html_wrap_item_temp_new .= '</div>';
                $html_item_temp_new      = '';
            }
        }
        $this->load->view('shop/media/elements/library-links/item_block_link_category', [
            'domain_url'   => $url_item,
            'category'     => [
                'slug' => 'moi-nhat',
                'name' => 'Mới nhất',
            ],
            'html_submenu' => '',
            'html_item'    => $html_wrap_item_temp_new,
            'item'         => $links_new[0],
            'url_item'     => $url_item,
        ]);
        unset($html_item_temp_new);
        unset($html_wrap_item_temp_new);
    }

    /*block categories*/
    $this->load->view('shop/media/elements/library-links/shop-library-block-link');
    ?>
</div>
<?php
/*popup create link*/
if(!empty($is_owns)){
    $this->load->view('shop/media/elements/library-links/popup-bookmark-link');
    $this->load->view('shop/media/elements/library-links/popup-create-collection-link', ['sho_id' => $shop['sho_id']]);
    $this->load->view('shop/media/elements/library-links/popup-custom-link-create', ['sho_id' => $shop['sho_id']]);
}

/******* trang lien kiet của bạn bè ********/
if(empty($is_owns) && !empty($user_login)){
    $params = ['title_popup' => 'Lưu liên kết'];
    if (!empty($user_login['my_shop'])){
        $params['sho_id'] = $user_login['my_shop']['sho_id'];
    }
    $this->load->view('shop/media/elements/library-links/popup-custom-link-create', $params);
}

$this->load->view('shop/media/elements/library-links/library-link-popup-action', ['is_owns' => $is_owns]);

block_js([
    '<script src="/templates/home/styles/plugins/slick/slick.js"></script>',
    '<script src="/templates/home/styles/plugins/slick/slick-slider.js"></script>',
], 'script_prioritize_tags');
block_js([
    '<script src="/templates/home/styles/js/shop/shop-library-custom-link-v2.js"></script>',
    '<script src="/templates/home/styles/js/shop/shop-library-link.js"></script>',
    '<script src="/templates/home/styles/js/shop/popup-create-collection-link.js"></script>',
    '<script src="/templates/home/styles/js/shop/shop-bookmark.js"></script>',
]);
?>

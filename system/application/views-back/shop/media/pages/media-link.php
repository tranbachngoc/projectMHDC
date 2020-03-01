<?php $server_media = $this->config->item('library_link_config')['cloud_server_show_path'] . '/' ?>
<div class="bosuutap-header-tabs js-scroll-x">
    <ul class="bosuutap-header-tabs-content ">
        <li class="active"><a href="#">Liên kết</a></li>
        <li><a href="/shop/collection-link">BST Liên kết</a></li>
    </ul>
</div>
<?php if(!empty($is_owns)){ ?>
    <div class="icon-add">
        <div class="icon-add-logo" data-toggle="dropdown"><img src="/templates/home/styles/images/svg/sanazibai_add.svg" alt=""></div>
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
        <?php if(!empty($categories)){
            $this->load->view('shop/media/elements/library-links/library-link-category-parent', [
                'categories' => $categories
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
    <?php $this->load->view('shop/media/elements/library-links/library-direction', ['view_type' => $view_type]) ?>
</div>

<!--Link mới nhất-->
<?php

if (!empty($links_new)){
    $this->load->view('shop/media/elements/library-links/library-block-item', [
        'data'          => $links_new,
        'is_owns'       => $is_owns,
        'server_media'  => $server_media,
    ]);
}

if(!empty($categories)){
    foreach ($categories as $category) {
        $this->load->view('shop/media/elements/library-links/library-block-item', [
            'data'              => $category['items'],
            'is_owns'           => $is_owns,
            'server_media'      => $server_media,
            'categories_child'  => $category['categories_child'],
            'category'          => [
                'id'    => $category['id'],
                'name'  => $category['name'],
                'slug'  => $category['slug'],
            ]
        ]);
    }
}

/******* trang lien kiet của tôi ********/
if(!empty($is_owns)){
    $this->load->view('shop/media/elements/library-links/popup-bookmark-link');
    $this->load->view('shop/media/elements/library-links/popup-create-collection-link', ['sho_id' => $shop_current->sho_id, 'default_shop' => true]);
    $this->load->view('shop/media/elements/library-links/popup-custom-link-create', ['sho_id' => $shop_current->sho_id, 'default_shop' => true]);
}

/******* trang lien kiet của bạn bè ********/
if(empty($is_owns) && !empty($user_login)){
    $params = [
        'title_popup' => 'Lưu liên kết'
    ];
    if (!empty($user_login['my_shop'])){
        $params['sho_id']       = $user_login['my_shop']['sho_id'];
        $params['default_shop'] = true;
    }
    $this->load->view('shop/media/elements/library-links/popup-custom-link-create', $params);
}

$this->load->view('shop/media/elements/library-links/library-link-popup-action', ['is_owns' => $is_owns]);

/*add load js footer */
block_js([
    '<script type="text/javascript" src="/templates/home/styles/js/clipboard.min.js"></script>',
    '<script src="/templates/home/styles/js/shop/shop-library-custom-link.js"></script>',
    '<script src="/templates/home/styles/js/shop/shop-library-link.js"></script>',
    '<script src="/templates/home/styles/js/shop/popup-create-collection-link.js"></script>',
    '<script src="/templates/home/styles/js/shop/shop-bookmark.js"></script>',
]);
?>

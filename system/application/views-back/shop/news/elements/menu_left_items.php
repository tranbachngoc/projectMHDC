<?php
$menu_active  = rtrim($shop_url . preg_replace('/^\/|(\?.+)|(\#.+)/', '', $_SERVER['REQUEST_URI']), '/');
$pattern_shop = str_replace('.', '\.', str_replace('/', '\/', rtrim($shop_url, '/')));
$pattern_url  = str_replace('.', '\.', str_replace('/', '\/', $menu_active));
$af_key = '';

if($this->session->userdata('sessionAfKey')) {
    $af_key = '?af_id='.$this->session->userdata('sessionAfKey');
}
if(!empty($_REQUEST['af_id'])) {
    $af_key = '?af_id='.$_REQUEST['af_id'];
}
$matches_router = [
    'route_home' => [
        $pattern_shop
    ],
    'route_shop' => [
        $pattern_shop .'\/shop',
        $pattern_shop .'\/shop\/product',
        $pattern_shop .'\/shop\/coupon',
        $pattern_shop .'\/shop\/voucher',
    ],
    'route_branch' => [
        $pattern_shop .'\/branch'
    ],
    'route_voucher' => [
        $pattern_shop .'\/library\/vouchers'
    ],
    'route_product' => [
        $pattern_shop .'\/library\/products'
    ],
    'route_coupon' => [
        $pattern_shop .'\/library\/coupons'
    ],
    'route_link' => [
        $pattern_shop .'\/library\/links',
        $pattern_shop .'\/content-link\/[0-9]+',
        $pattern_shop .'\/library-link\/[0-9]+',
        $pattern_shop .'\/image-link\/[0-9]+',
    ],
    'route_image' => [
        $pattern_shop .'\/library\/images',
    ],
    'route_video' => [
        $pattern_shop .'\/library\/videos',
    ],
    'route_collection' => [
        $pattern_shop .'\/shop\/collection',
        $pattern_shop .'\/shop\/collection-link',
    ],
    'route_introduct' => [
        $pattern_shop .'\/shop\/introduct',
    ],
];

foreach ($matches_router as $key_routes_link => $routes_link) {
    ${$key_routes_link} = false;
    foreach ($routes_link as $froute_link) {
        if(preg_match('/^'.$froute_link.'$/',  $menu_active)){
            ${$key_routes_link} = true;
        }
    }
}
?>
<?php
$list_branch = $shop_current->list_branch;
if(!empty($list_branch) && $shop_current->group_user == AffiliateStoreUser) {
    $this->load->view('shop/news/elements/list_branch_of_shop', ['list_branch'=>$list_branch]);
}
?>
<ul class="tindoanhnghiep-list-menu page-scroll-to-lvl1">
    <li class="<?php echo $route_home == true ? 'active' : '';?>">
        <a href="<?php echo $shop_url ?>" title="Trang chủ"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/trangchu<?php echo $route_home == true ? '' : '' ?>.png" alt="Trang chủ">
            </span>
            <span class="tt">Trang chủ</span>
        </a>
    </li>
    <li class="<?php echo $route_shop == true ? 'active' : ''; ?>">
        <a href="<?php echo $shop_url . 'shop'.$af_key; ?>" title="Cửa hàng"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/cuahang<?php echo $route_shop == true ? '' : '' ?>.png" alt="Cửa hàng">
            </span>
            <span class="tt">Cửa hàng</span>
        </a>
    </li>

    <?php if (!empty($shop_current) && $shop_current->group_user == 3 && !empty($list_bran)) { ?>
    <li class="<?php echo $route_branch == true ? 'active' : ''; ?>">
        <a href="<?php echo $shop_url . 'branch'; ?>" title="Quản lý trang"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/trangphu<?php echo $route_branch == true ? '' : '' ?>.png" alt="Cửa hàng">
            </span>
            <span class="tt">Trang phụ</span>
        </a>
    </li>
    <?php } ?>
    <?php if(!$this->session->userdata('sessionUser')){ ?>
        <li>
            <a title="Tuyển dụng" href="<?php echo azibai_url() . '/register/verifycode?reg_pa=' . $shop_current->sho_user ?>"><span class="bg-img">
                <img src="/templates/home/styles/images/svg/tuyendung.png" alt="Tuyển dụng">
                </span>
                <span class="tt">Tuyển dụng</span>
            </a>
        </li>
    <?php } ?>
    <li class="<?php echo $route_link == true ? 'active' : ''; ?>">
        <a href="<?php echo $shop_url . 'library/links'; ?>" title="Liên kết"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/lienket<?php echo $route_link == true ? '' : '' ?>.png" alt="Liên kết">
            </span>
            <span class="tt">Liên kết</span>
        </a>
    </li>
    <li class="<?php echo $route_image == true ? 'active' : ''; ?>">
        <a href="<?php echo $shop_url . 'library/images'; ?>" title="Ảnh"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/anh<?php echo $route_image == true ? '' : '' ?>.png" alt="Ảnh">
            </span>
            <span class="tt">Ảnh</span>
        </a>
    </li>
    <li class="<?php echo $route_video == true ? 'active' : ''; ?>">
        <a href="<?php echo $shop_url . 'library/videos'; ?>" title="Video"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/video<?php echo $route_video == true ? '' : '' ?>.png" alt="Video">
            </span>
            <span class="tt">Video</span>
        </a>
    </li>
    <li class="<?php echo $route_voucher == true ? 'active' : ''; ?>">
        <a href="<?php echo $shop_url . 'library/vouchers'.$af_key ?>" title="Sản phẩm"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/coupon<?php echo $route_voucher == true ? '' : '' ?>.png" alt="Sản phẩm">
            </span>
            <span class="tt">Mã giảm giá</span>
        </a>
    </li>
    <li class="<?php echo $route_product == true ? 'active' : ''; ?>">
        <a href="<?php echo $shop_url . 'library/products'.$af_key ?>" title="Sản phẩm"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/sanpham<?php echo $route_product == true ? '' : '' ?>.png" alt="Sản phẩm">
            </span>
            <span class="tt">Sản phẩm</span>
        </a>
    </li>
    <li class="<?php echo $route_coupon == true ? 'active' : ''; ?>">
        <a href="<?php echo $shop_url . 'library/coupons'.$af_key ?>" title="Coupon"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/coupon<?php echo $route_coupon == true ? '' : '' ?>.png" alt="Coupon">
            </span>
            <span class="tt">Coupon</span>
        </a>
    </li>
    <li class="<?php echo ( $item_active = ($route_collection == true) || (isset($sl_tab) && in_array($sl_tab,['product','coupon'])) ) ? 'active' : ''; ?>">
        <a href="<?php echo $shop_url . 'shop/collection'.$af_key ?>"
           title="Bộ sưu tập"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/bosuutap<?php echo $item_active == 'active' ? '' : '' ?>.png" alt="Bộ sưu tập">
            </span>
            <span class="tt">Bộ sưu tập</span>
        </a>
    </li>
    <!-- <li class="<?php // echo $item_active = $shop_url . 'shop/warranty' == $menu_active ? 'active' : ''; ?>">
        <a href="<?php // echo $shop_url . 'shop/warranty' ?>" title="Chính sách">
            <img src="/templates/home/styles/images/svg/chinhsach<?php // echo $item_active == 'active' ? '' : '' ?>.png" alt="Chính sách">
            <br>Chính sách
        </a>
    </li> -->
    <li class="<?php echo $route_introduct == true ? 'active' : ''; ?>">
        <a href="<?php echo $shop_url . 'shop/introduct' ?>" title="Giới thiệu"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/gioithieu<?php echo $route_introduct == true ? '' : '' ?>.png" alt="Giới thiệu">
            </span>
            <span class="tt">Giới thiệu</span>
        </a>
    </li>
    <!--    <li class="--><?php ////echo $item_active = $shop_url . 'shop/contact' == $menu_active ? 'active' : ''; ?><!--">-->
    <!--        <a href="--><?php //echo $shop_url . 'shop/contact' ?><!--" title="Liên hệ">-->
    <!--            <img src="/templates/home/styles/images/svg/lienhe.png" alt="Liên hệ">
                    <br>Liên hệ-->
    <!--        </a>-->
    <!--    </li>-->
</ul>
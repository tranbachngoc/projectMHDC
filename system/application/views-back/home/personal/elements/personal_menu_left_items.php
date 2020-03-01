<?php
//$profile_url      = rtrim($profile_url, '\/');
$iUserId             = (int)$this->session->userdata('sessionUser');
$slug_profile        = 'profile/' . $current_profile['use_id'];
$menu_active         = rtrim($profile_url . ltrim(str_replace($slug_profile, '', preg_replace('/^\/|(\?.+)|(\#.+)|\/$/', '', $_SERVER['REQUEST_URI'])), '\/'), '/');
$pattern_profile_url = str_replace('.', '\.', str_replace('/', '\/', rtrim($profile_url, '/')));
$pattern_url         = str_replace('.', '\.', str_replace('/', '\/', rtrim($menu_active, '/')));

$af_key = "";
if($this->session->userdata('sessionAfKey')) {
    $af_key = '?af_id='.$this->session->userdata('sessionAfKey');
}
if(!empty($_REQUEST['af_id'])) {
    $af_key = '?af_id='.$_REQUEST['af_id'];
}

$matches_router = [
    'route_home' => [
        $pattern_profile_url
    ],
    'route_friend' => [
        $pattern_profile_url .'\/friends'
    ],
    'route_about' => [
        $pattern_profile_url .'\/about'
    ],
    'route_link' => [
        $pattern_profile_url .'\/library\/links',
        $pattern_profile_url .'\/content-link\/[0-9]+',
        $pattern_profile_url .'\/library-link\/[0-9]+',
        $pattern_profile_url .'\/image-link\/[0-9]+',
    ],
    'route_image' => [
        $pattern_profile_url .'\/library\/images',
    ],
    'route_video' => [
        $pattern_profile_url .'\/library\/videos',
    ],
    'route_collection' => [
        $pattern_profile_url .'\/collection\/link',
    ],
    'route_affiliate_shop' => [
        $pattern_profile_url .'\/affiliate-shop',
        $pattern_profile_url .'\/affiliate-shop\/coupon',
        $pattern_profile_url .'\/affiliate-shop\/product',
        $pattern_profile_url .'\/affiliate-shop\/voucher',
        $pattern_profile_url .'\/affiliate-shop\/voucher\/type\/[0-9]+',
    ],
    'route_affiliate' => [
        $pattern_profile_url .'\/affiliate',
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
<ul class="tindoanhnghiep-list-menu page-scroll-to-lvl1">
    <li class="<?php echo $route_home == true ? 'active' : '';?>">
        <a href="<?php echo $profile_url ?>" title="Dòng thời gian"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/dongthoigian<?php echo $route_home == true ? '' : '' ?>.png" alt="Dòng thời gian"></span>
            <span class="tt">Dòng thời gian</span>
        </a>
    </li>
    <li class="<?php echo $route_friend == true ? 'active' : ''; ?>">
        <a href="<?php echo $profile_url . 'friends' . $af_key; ?>" title="Bạn bè"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/banbe<?php echo $route_friend == true ? '' : '' ?>.png" alt="Bạn bè"></span>
            <span class="tt">Bạn bè</span>
        </a>
    </li>
    <li class="<?php echo $route_about == true ? 'active' : ''; ?>">
        <a href="<?php echo $profile_url . 'about' . $af_key ?>" title="Giới thiệu">
            <span class="bg-img">
                <img src="/templates/home/styles/images/svg/gioithieu<?php echo $route_about == true ? '' : '' ?>.png" alt="Giới thiệu">
            </span>
            <span class="tt">Giới thiệu</span>
        </a>
    </li>
    <?php if($current_profile['is_show_storetab'] != 0 || $current_profile['use_id'] == $this->session->userdata('sessionUser')) { ?>
    <li class="<?php echo $route_affiliate_shop == true ? 'active' : ''; ?>">
        <a href="<?php  echo $profile_url . 'affiliate-shop' . $af_key; ?>" title="Cửa hàng"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/cuahang<?php echo $route_affiliate_shop == true ? '' : '' ?>.png" alt="Cửa hàng"></span>
            <span class="tt">Cửa hàng</span>
        </a>
    </li>
    <?php } ?>
    <li class="<?php echo $route_image == true ? 'active' : ''; ?>">
        <a href="<?php echo $profile_url . 'library/images' . $af_key; ?>" title="Ảnh"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/anh<?php echo $route_image == true ? '' : '' ?>.png" alt="Ảnh"></span>
            <span class="tt">Ảnh</span>
        </a>
    </li>
    <li class="<?php echo $route_video == true ? 'active' : ''; ?>">
        <a href="<?php echo $profile_url . 'library/videos' . $af_key; ?>" title="Video"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/video<?php echo $route_video == true ? '' : '' ?>.png" alt="Video"></span>
            <span class="tt">Video</span>
        </a>
    </li>
    <li class="<?php echo $route_link == true ? 'active' : ''; ?>">
        <a href="<?php echo $profile_url . 'library/links' . $af_key; ?>" title="Liên kết"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/lienket<?php echo $route_link == true ? '' : '' ?>.png" alt="Liên kết"></span>
            <span class="tt">Liên kết</span>
        </a>
    </li>
<!--    <li class="--><?php // echo $item_active =  $profile_url . 'affiliate-shop/product' == $menu_active ? 'active' : ''; ?><!--">-->
<!--        <a href="--><?php //echo $profile_url . 'affiliate-shop/product' ?><!--" title="Sản phẩm">-->
<!--            <img src="/templates/home/styles/images/svg/sanpham--><?php //echo $item_active == 'active' ? '_on' : '' ?><!--.png" alt="Sản phẩm">Sản phẩm-->
<!--        </a>-->
<!--    </li>-->
<!--    <li class="--><?php // echo $item_active =  $profile_url . 'affiliate-shop/coupon' == $menu_active ? 'active' : ''; ?><!--">-->
<!--        <a href="--><?php //echo $profile_url . 'affiliate-shop/coupon' ?><!--" title="Coupon">-->
<!--            <img src="/templates/home/styles/images/svg/coupon--><?php //echo $item_active == 'active' ? '_on' : '' ?><!--.png" alt="Coupon">Coupon-->
<!--        </a>-->
<!--    </li>-->
    <li class="<?php echo $route_collection == true ? 'active' : '' ?>">
        <a href="<?php echo $profile_url . 'collection/link' . $af_key?>"
           title="Bộ sưu tập"><span class="bg-img">
            <img src="/templates/home/styles/images/svg/bosuutap<?php echo $route_collection == true ? '' : '' ?>.png" alt="Bộ sưu tập"></span>
            <span class="tt">Bộ sưu tập</span>
        </a>
    </li>
</ul>
<?php
$currentuser = !empty($azitab['user']) ? $azitab['user'] : '';
$myshop      = !empty($azitab['myshop']) ? $azitab['myshop'] : '';
$af_key = '';
$avatar = $avatar_shop = site_url('/templates/home/styles/images/product/avata/default-avatar.png');

if(!empty($currentuser)){
    $af_key = $currentuser->af_key;
}
if ($this->session->userdata('sessionUser') > 0) {
    if ($currentuser->avatar) {
      $avatar = $this->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $currentuser->use_id . '/' . $currentuser->avatar;
    }
    if ($myshop->sho_logo) {
      $avatar_shop = $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/' . $myshop->sho_dir_logo . '/' . $myshop->sho_logo;
    }
}
$avatar_used = $avatar;

$myshop_url  = azibai_url();

if(!empty($myshop->domain)){
    $myshop_url = 'http://' . $myshop->domain;
}else if (!empty($myshop->sho_link)){
    $protocol = get_server_protocol();
    $myshop_url =  $protocol . $myshop->sho_link . '.' . domain_site ;
}
?>
<?php
  $this->load->library('Mobile_Detect');
  $detect = new Mobile_Detect();
?>
<?php if ($detect->isiOS()) { ?>
  <link rel="stylesheet" href="/templates/home/styles/css/for_IOS.css">
<?php } ?>
<header>
  <div class="container">
    <div class="drawer-hamburger sm">
      <span></span>
      <span></span>
      <span></span>
    </div> 
    <nav class="header-nav-left sm-gnav sm">
      <ul>
        <li><a href="<?=$current_profile['profile_url']?>">Trang chủ</a></li>
        <li class="<?=$detect_process == 'affiliate-shop' ? 'active' : ''?>"><a href="<?=$current_profile['profile_url'].'affiliate-shop'?>">Cửa hàng</a></li>
        <li class="<?=$detect_process == 'product' ? 'active' : ''?>"><a href="<?=$current_profile['profile_url'].'affiliate-shop/product'?>">Sản phẩm</a></li>
        <li class="<?=$detect_process == 'coupon' ? 'active' : ''?>"><a href="<?=$current_profile['profile_url'].'affiliate-shop/coupon'?>">Coupon</a></li>
        <li><a href="<?=$profile_shop_url.'/shop/collection'?>">Bộ sưu tập</a></li>
        <li>
          <a href="javascript:void(0)">Thư viện</a><img class="down-icon" src="/templates/home/styles/images/svg/up.svg" alt="">
          <div class="sub-menu">
            <p class="list"><a href="<?=$current_profile['profile_url'].'library/images'?>">Thư viện ảnh</a></p>
            <p class="list"><a href="<?=$current_profile['profile_url'].'library/videos'?>">Thư viện video</a></p>
            <p class="list"><a href="<?=$current_profile['profile_url'].'library/links'?>">Thư viện liên kết</a></p>
            <!-- <p class="list"><a href="<?=$current_profile['profile_url'].'library/coupons'?>">Thư viện coupon</a></p> -->
            <!-- <p class="list"><a href="<?=$current_profile['profile_url'].'library/products'?>">Thư viện sản phẩm</a></p> -->
          </div>
        </li>
        <!-- <li>
          <a href="javascript:void(0)">Giới thiệu</a><img class="down-icon" src="/templates/home/styles/images/svg/up.svg" alt="">
          <div class="sub-menu">
            <p class="list"><a href="<?=$shop_url.'shop/warranty'?>">Chính sách</a></p>
            <p class="list"><a href="<?=azibai_url().'/register/verifycode?reg_pa='.$shop_current->sho_user?>">Tuyển dụng</a></p>
            <p class="list"><a href="<?=$shop_url.'shop/contact'?>">Liên hệ</a></p>
          </div>
        </li> -->
        <li><a href="<?=azibai_url()?>">Azibai</a></li>
      </ul>
    </nav>
    <nav class="header-nav-right">
      <div class="dienthoai">
        <a href="tel:<?=$current_profile['use_mobile']?>">
          <span class="icon-tel">
            <img src="/templates/home/styles/images/svg/shop_icon_tel.svg" alt="">
          </span><?=$current_profile['use_mobile']?></a>
        <a href="<?=$current_profile['profile_url'].'affiliate-shop/product'?>" class="btn-tatcasp md">Tất cả sản phẩm</a>
        <a href="<?=$current_profile['profile_url'].'affiliate-shop/coupon'?>" class="btn-tatcasp md">Tất cả coupon</a>
      </div>
      <div class="giohang-avata">
        <a href="<?=azibai_url('/checkout')?>">
          <div class="giohang">
              <img src="/templates/home/styles/images/svg/bag.svg" height="24" alt="">
              <span class="cartNum"><?php echo $azitab['cart_num']; ?></span>
          </div>
        </a>
        <ul class="header-avata">
          <li class="avata">
            <a href="javascript:void(0)">
              <img src="<?=$avatar?>" alt="cart" class="icon-avata">
            </a>
          </li>
          <li class="dropdowninfo">
            <div class="dropdowninfo-arrow ">
              <a href="javascript:void(0)"></a>
            </div>
            <?php if(!(isset($currentuser) && $currentuser)){ ?>
            <div class="dropdowninfo-show-nologin">
              <p class="list">
                <a href="<?=azibai_url('/login')?>">
                  <img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >
                  <strong>Đăng nhập</strong>
                </a>
              </p>
              <p class="list">
                <a href="<?=azibai_url('/register/verifycode')?>">
                  <img src="/templates/home/styles/images/svg/user03.svg" alt="" width="24" >Đăng ký</a>
              </p>
              <p class="kiemtradonhang list">
                <img src="/templates/home/styles/images/svg/kiemtradonhang.svg" alt="" width="24" >Kiểm tra đơn hàng</p>
              <div class="kiemtradonhang-show">
                <p class="list">
                  <input type="text" placeholder="Nhập mã hàng">
                </p>
                <p class="list">
                  <input type="text" placeholder="Email/số điện thoại">
                </p>
              </div>
            </div>
            <?php } else { 
                if ($currentuser->avatar) {
                    // $avatar = DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $currentuser->avatar;
                    $avatar_shop = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $myshop->sho_dir_logo . '/' . $myshop->sho_logo;
                } else {
                    // $avatar = site_url('media/images/avatar/default-avatar.png');
                    $avatar_shop = site_url('media/images/avatar/default-avatar.png');
                } ?>
            <div class="dropdowninfo-show-login">
              <p>Trang của bạn</p>
              <p class="list">
                <a target="_blank" href="<?=azibai_url('/profile/'.$currentuser->use_id)?>">
                  <img src="<?=$avatar?>" alt="" width="24" class="mr15 icon-avata">Trang cá nhân
                </a>
              </p>
              <p class="list">
                <a href="<?=$myshop_url?>">
                  <img src="<?=$avatar_shop?>" alt="" width="24" class="mr15 icon-avata">Trang doanh nghiệp
                </a>
              </p>
              <p class="list">
                <a href="<?=$myshop_url.'/shop'?>">
                  <img src="<?=$avatar_shop?>" alt="" width="24" class="mr15 icon-avata">Tiệm shop
                </a>
              </p>
              <p class="list">
                <a href="<?=azibai_url('/account/edit')?>">
                  <img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Quản lý chung</a>
              </p>
              <p class="list">
                <a href="<?=azibai_url('/manager/order')?>">
                  <img src="/templates/home/styles/images/svg/box.svg" alt="" width="24" >Đơn hàng đã mua</a>
              </p>
              <p class="list">
                <a href="<?=$myshop_url.'/shop/collection'?>">
                  <img src="/templates/home/styles/images/svg/bookmark.svg" alt="" width="24" >Bộ sưu tập
                </a>
              </p>
              <p class="mt10 f18">
                <a href="<?=azibai_url('/logout') ?>">Đăng xuất</a>
              </p>
            </div>
            <?php } ?>
          </li>
        </ul>
      </div>

    </nav>
  </div>
</header>
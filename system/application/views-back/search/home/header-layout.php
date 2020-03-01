<?php
if(!isset($hook_shop)){
  $hook_shop = MY_Loader::$static_data['hook_shop'];
}
if(!isset($user_login)){
  $user_login = MY_Loader::$static_data['hook_user'];
}
$avatar = '/templates/home/styles/images/product/avata/default-avatar.png';

$myshop_url = shop_url($user_login['my_shop']) ;

if (!empty($user_login)) {
  $avatar = $user_login['avatar_url'];
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
  <div class="header md">
    <div class="container">
      <div class="header-menu">
        <div class="header-menu-left">
          <ul>
            <li class="home">
              <a href="<?=azibai_url(); ?>">
                <img class="icon-img" src="/templates/home/styles/images/svg/a.svg" alt="azibai">
              </a>
            </li>
            <li>
              <a href="javascript:void(0)">Tải ứng dụng</a>
            </li>
            <li class="tablet-none">
              <a href="javascript:void(0)">Kết nối</a>
            </li>
            <li class="no-border">
              <a href="javascript:void(0)">
                <img src=".//templates/home/styles/images/svg/instagram.svg" alt="instagram">
              </a>
            </li>
            <li class="no-border">
              <a href="javascript:void(0)">
                <img src=".//templates/home/styles/images/svg/facebook.svg" alt="facebook">
              </a>
            </li>
          </ul>
        </div>
        <div class="header-menu-center">
          <?php $this->load->view('search/home/input-search');?>
        </div>
        <div class="header-menu-right">
          <ul class="header-list-icon">
            <li>
              <a href="<?=azibai_url('/shop/products')?>">
                <img src="/templates/home/styles/images/svg/shop.svg" width="15" alt="">
              </a>
            </li>
            <li>
              <a href="<?=azibai_url('/v-checkout')?>">
                <img src="/templates/home/styles/images/svg/cart02.svg" width="15" alt="">
                <span class="num cartNum"><?php echo !empty($azitab['cart_num']) ? $azitab['cart_num'] : 0 ?></span>
              </a>
            </li>
            <!-- <li>
              <a href="javascript:void(0)">
                <img src="/templates/home/styles/images/svg/bell_black.svg" width="15" alt="">
                <span class="num">0</span>
              </a>
            </li> -->
            <li>
              <a href="<?=azibai_url('/links')?>">
                <img src="/templates/home/styles/images/svg/help_black.svg" width="15" alt="">
              </a>
            </li>
            <!-- <li>
              <a href="javascript:void(0)">
                <img src="/templates/home/styles/images/svg/message02.svg" width="15" alt="">
                <span class="num">0</span>
              </a>
            </li> -->
          </ul>
          <ul class="header-avata">
            <li class="avata">
              <a href="javascript:void(0)">
                <img src="<?=$avatar?>" alt="cart">
              </a>
            </li>
            <li class="dropdowninfo">
              <div class="dropdowninfo-arrow">
                <a href="javascript:void(0)"></a>
              </div>
              <?php if (!empty($user_login)) { ?>
              <div class="dropdowninfo-show-login">
                <p class="list"><a href="<?php echo azibai_url(); ?>"><img src="/templates/home/styles/images/svg/a.svg" alt="" width="24" >Azibai</a></p>
                <a href="<?php echo azibai_url() .'/v-checkout' ?>" class="giohang mb-4">
                  <img src="/templates/home/styles/images/svg/cart02.svg" height="24" alt="">
                  <span class="cartNum"><?php echo !empty($azitab['cart_num']) ? $azitab['cart_num'] : 0 ?></span>&nbsp;Giỏ hàng
                </a>
                <p>Trang của bạn</p>
                <p class="list"><a href="<?=$user_login['profile_url'] ?>"><img src="<?=$user_login['avatar_url'] ?>" alt="" width="32" >Trang cá nhân</a></p>
                <!-- <p class="list"><a href="<?=$user_login['profile_url'] . 'affiliate-shop' ?>"><img src="<?=$user_login['avatar_url'] ?>" alt="" width="32" >Shop cá nhân</a></p> -->
                <p class="list"><a href="<?=$myshop_url ?>"><img src="<?=$user_login['my_shop']['logo'] ?>" alt="<?=htmlspecialchars($user_login['my_shop']['sho_name']) ?>" width="32" >Trang doanh nghiệp</a></p>
                <p class="list"><a href="<?=$myshop_url . '/shop' ?>"><img src="<?=$user_login['my_shop']['logo']; ?>" alt="<?=htmlspecialchars($user_login['my_shop']['sho_name']) ?>" width="32" >Shop doanh nghiệp</a></p>
                <p class="list"><a href="<?=azibai_url('/account/edit'); ?>"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Thông tin chung</a></p>
                <p class="list"><a href="<?=azibai_url('/shop/service'); ?>"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Dịch vụ</a></p>
                <p class="list"><a href="<?=azibai_url('/manager/order')?>"><img src="/templates/home/styles/images/svg/box.svg" alt="" width="24" >Đơn hàng đã mua</a></p>
                <p class="list"><a href="<?=$myshop_url . '/shop/collection'; ?>"><img src="/templates/home/styles/images/svg/bookmark.svg" alt="" width="24" >Bộ sưu tập</a></p>
                <p class="mt10 f18"><a href="<?=azibai_url('/logout')?>">Đăng xuất</a></p>
              </div>
              <?php } else { ?>
              <div class="dropdowninfo-show-nologin">
                <!-- <p>Trang của bạn</p> -->
                <p class="list"><a href="<?=azibai_url('/login') ?>"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" ><strong>Đăng nhập</strong></a></p>
                <p class="list"><a href="<?=azibai_url() .'/register/verifycode' ?>"><img src="/templates/home/styles/images/svg/user03.svg" alt="" width="24" >Đăng ký</a></p>
                <p class="kiemtradonhang list"><img src="/templates/home/styles/images/svg/kiemtradonhang.svg" alt="" width="24" >Kiểm tra đơn hàng</p>
                <div class="kiemtradonhang-show">
                  <p class="list"><input type="text" placeholder="Nhập mã hàng"></p>
                  <p class="list"><input type="text" placeholder="Email/số điện thoại"></p>
                </div>
                <p class="list">
                  <a href="<?php echo azibai_url() ?>">
                      <img src="/templates/home/styles/images/svg/a.svg" alt="" width="24" >Azibai
                  </a>
                </p>
                <a href="<?php echo azibai_url() .'/v-checkout' ?>" class="giohang">
                  <img src="/templates/home/styles/images/svg/cart02.svg" height="24" alt="">
                  <span class="cartNum"><?php echo !empty($azitab['cart_num']) ? $azitab['cart_num'] : 0 ?></span>&nbsp;Giỏ hàng
                </a>
              </div>
              <?php } ?>
            </li>
          </ul>

        </div>
      </div>
    </div>
  </div>
  <div class="sm header-sp js-fixed-header-sm">
    <div class="header-sp-nav">
      <ul class="f-gnav">
        <li>
          <a href="<?=azibai_url(); ?>">
            <img class="icon-img" src="/templates/home/styles/images/svg/a.svg" alt="azibai">
          </a>
        </li>
        <li>
          <a href="<?=azibai_url('/shop/products')?>">
            <img src="/templates/home/styles/images/svg/shop.svg" width="24" alt="">
          </a>
        </li>
        <!-- <li>
          <a href="<?=azibai_url('/v-checkout')?>">
            <img src="/templates/home/styles/images/svg/cart02.svg" width="24" alt="">
            <span class="num cartNum"><?php echo !empty($azitab['cart_num']) ? $azitab['cart_num'] : 0 ?></span>
          </a>
        </li> -->
        <!-- <li>
          <a href="javascript:void(0)">
            <img src="/templates/home/styles/images/svg/bell_black.svg" width="24" alt="">
            <span class="num">0</span>
          </a>
        </li> -->
        <li>
          <a href="<?=azibai_url('/links')?>">
            <img src="/templates/home/styles/images/svg/help_black.svg" width="24" alt="">
          </a>
        </li>
        <li class="search-click">
          <a href="javascript:void(0)">
            <img src="/templates/home/styles/images/svg/search.svg" width="24" alt="">
          </a>
        </li>
        <!-- <li>
          <a href="javascript:void(0)">
            <img src="/templates/home/styles/images/svg/message02.svg" width="24" alt="">
            <span class="num num2">0</span>
          </a>
        </li> -->
        <!-- <li class="mr00"><div class="cart show-info-number"><img src="/templates/home/styles/images/svg/cart.svg" alt="cart"></div></li> -->
        <li class="ico-nav">
          <div class="drawer-hamburger">
            <span></span>
            <span></span>
            <span></span>
          </div>
        </li>
      </ul>
      <div class="autocompletebox input-search hidden dropdown">
        <?php $this->load->view('search/home/input-search');?>
      </div>
      <nav class="sm-gnav">
        <?php if (!empty($user_login)) { ?>
        <div class="dropdowninfo-show-login">
          <p class="list"><a href="<?php echo azibai_url(); ?>"><img src="/templates/home/styles/images/svg/a.svg" alt="" width="24" >Azibai</a></p>
          <a href="<?php echo azibai_url() .'/v-checkout' ?>" class="giohang mb-4">
            <img src="/templates/home/styles/images/svg/cart02.svg" height="24" alt="">
            <span class="cartNum"><?php echo !empty($azitab['cart_num']) ? $azitab['cart_num'] : 0 ?></span>&nbsp;Giỏ hàng
          </a>
          <p>Trang của bạn</p>
          <p class="list">
            <a href="<?=$user_login['profile_url'] ?>">
              <img src="<?=$user_login['avatar_url'] ?>" alt="" width="32" >Trang cá nhân</a>
          </p>
          <!-- <p class="list">
            <a href="<?=$user_login['profile_url'] . 'affiliate-shop' ?>">
              <img src="<?=$user_login['avatar_url'] ?>" alt="" width="32" >Shop cá nhân</a>
          </p> -->
          <p class="list">
            <a href="<?=$myshop_url ?>">
              <img src="<?=$user_login['my_shop']['logo'] ?>" alt="" width="24" >Trang doanh nghiệp</a>
          </p>
          <p class="list">
            <a href="<?=$myshop_url . '/shop' ?>">
              <img src="<?=$user_login['my_shop']['logo']; ?>" alt="" width="24" >Shop doanh nghiệp</a>
          </p>
          <p class="list">
            <a href="<?=azibai_url('/account/edit'); ?>">
              <img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Thông tin chung</a>
          </p>
          <p class="list">
            <a href="<?=azibai_url('/shop/service'); ?>">
              <img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >Dịch vụ</a>
          </p>
          <p class="list">
            <a href="<?=azibai_url('/manager/order')?>">
              <img src="/templates/home/styles/images/svg/box.svg" alt="" width="24" >Đơn hàng đã mua</a>
          </p>
          <p class="list">
            <a href="<?=$myshop_url . '/shop/collection'; ?>">
              <img src="/templates/home/styles/images/svg/bookmark.svg" alt="" width="24" >Bộ sưu tập</a>
          </p>
          <p class="mt10 f18">
            <a href="<?=azibai_url('/logout')?>">Đăng xuất</a>
          </p>
        </div>
        <?php } else { ?>
        <div class="dropdowninfo-show-nologin">
          <!-- <p>Trang của bạn</p> -->
          <p class="list">
            <a href="<?=azibai_url('/login') ?>">
              <img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" >
              <strong>Đăng nhập</strong>
            </a>
          </p>
          <p class="list">
            <a href="<?=azibai_url() .'/register/verifycode' ?>">
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
          <p class="list">
            <a href="<?php echo azibai_url() ?>">
                <img src="/templates/home/styles/images/svg/a.svg" alt="" width="24" >Azibai
            </a>
          </p>
          <a href="<?php echo azibai_url() .'/v-checkout' ?>" class="giohang">
            <img src="/templates/home/styles/images/svg/cart02.svg" height="24" alt="">
            <span class="cartNum"><?php echo !empty($azitab['cart_num']) ? $azitab['cart_num'] : 0 ?></span>&nbsp;Giỏ hàng
          </a>
        </div>
        <?php } ?>
      </nav>
    </div>
  </div>
</header>
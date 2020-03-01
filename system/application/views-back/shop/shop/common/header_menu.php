<?php
if(!isset($hook_shop)){
  $hook_shop = MY_Loader::$static_data['hook_shop'];
}
if(!isset($user_login)){
  $user_login = MY_Loader::$static_data['hook_user'];
}

$avatar = '/templates/home/styles/images/product/avata/default-avatar.png';

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
    <div class="header02">
      <div class="container js-fixed-header-sm">
        <nav class="header-nav-left no-login">
          <div class="search">
            <input type="text" placeholder="Tìm kiếm">
            <img src="/templates/home/styles/images/svg/search.svg" class="icon" alt="">
          </div>
        </nav>
        <nav class="header-nav-right">
          <a href="<?=azibai_url() .'/v-checkout' ?>" class="giohang"><img src="/templates/home/styles/images/svg/cart02.svg" height="24" alt=""><span class="cartNum"><?php echo $azitab['cart_num']; ?></span></a>
          <div class="giohang bell">
            <!-- <img src="/templates/home/styles/images/svg/bell_black.svg" height="24" alt=""><span>0</span> -->
          </div>
          <ul class="header-avata">
            <li class="avata md"><a href="javascript:void(0)"><img src="<?=$avatar?>" alt="cart"></a></li>
            <li class="drawer-hamburger dropdowninfo-drawer-hamburger dropdowninfo-arrow sm">
              <span></span>
              <span></span>
              <span></span>
            </li>
            <li class="dropdowninfo">
              <div class="dropdowninfo-arrow md"><a href="javascript:void(0)"></a></div>
              <?php if (!empty($user_login)) { ?>
              <div class="dropdowninfo-show-login">
                <p class="list"><a href="<?php echo azibai_url(); ?>"><img src="/templates/home/styles/images/svg/a.svg" alt="" width="24" class="mr15">Azibai</a></p>
                <a href="<?php echo azibai_url() .'/v-checkout' ?>" class="giohang mb-4">
                  <img src="/templates/home/styles/images/svg/cart02.svg" height="24" alt="">
                  <span class="cartNum"><?php echo !empty($azitab['cart_num']) ? $azitab['cart_num'] : 0 ?></span>&nbsp;Giỏ hàng
                </a>
                <p>Trang của bạn</p>
                <p class="list"><a href="<?=$user_login['profile_url'] ?>"><img src="<?=$user_login['avatar_url'] ?>" alt="" width="32" class="mr15">Trang cá nhân</a></p>
                <!-- <p class="list"><a href="<?=$user_login['profile_url'] . 'affiliate-shop' ?>"><img src="<?=$user_login['avatar_url'] ?>" alt="" width="32" class="mr15">Shop cá nhân</a></p> -->
                <p class="list"><a href="<?=$user_login['my_shop']['shop_url'] ?>"><img src="<?=$user_login['my_shop']['logo'] ?>" alt="<?=htmlspecialchars($user_login['my_shop']['sho_name']) ?>" width="32" class="mr15">Trang doanh nghiệp</a></p>
                <p class="list"><a href="<?=$user_login['my_shop']['shop_url'] . 'shop' ?>"><img src="<?=$user_login['my_shop']['logo']; ?>" alt="<?=htmlspecialchars($user_login['my_shop']['sho_name']) ?>" width="32" class="mr15">Shop doanh nghiệp</a></p>
                <p class="list"><a href="<?=azibai_url('/account/edit'); ?>"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" class="mr20">Quản lý chung</a></p>
                <?php if(in_array($this->session->userdata('sessionGroup'), [AffiliateStoreUser, BranchUser])) {?>
                <p class="list">
                  <a href="<?= azibai_url('/page-business') . ($this->session->userdata('sessionGroup') == BranchUser ? '/'.$this->session->userdata('sessionUser') : ''); ?>">
                    <img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" class="mr20">Quản lý trang
                  </a>
                </p>
                <?php }?>
                <p class="list"><a href="<?=azibai_url('/shop/service'); ?>"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" class="mr20">Dịch vụ</a></p>
                <p class="list"><a href="<?=azibai_url('/manager/order')?>"><img src="/templates/home/styles/images/svg/box.svg" alt="" width="24" class="mr20">Đơn hàng đã mua</a></p>
                <p class="list"><a href="<?=$user_login['my_shop']['shop_url'] . 'shop/collection'; ?>"><img src="/templates/home/styles/images/svg/bookmark.svg" alt="" width="24" class="mr20">Bộ sưu tập</a></p>
                <p class="mt10 f18"><a href="<?=azibai_url('/logout')?>">Đăng xuất</a></p>
              </div>
              <?php } else { ?>
              <div class="dropdowninfo-show-nologin">
                <p class="list"><a href="<?=azibai_url('/login') ?>"><img src="/templates/home/styles/images/svg/user02.svg" alt="" width="24" class="mr15"><strong>Đăng nhập</strong></a></p>
                <p class="list"><a href="<?=azibai_url() .'/register/verifycode' ?>"><img src="/templates/home/styles/images/svg/user03.svg" alt="" width="24" class="mr15">Đăng ký</a></p>
                <p class="kiemtradonhang list"><img src="/templates/home/styles/images/svg/kiemtradonhang.svg" alt="" width="24" class="mr15">Kiểm tra đơn hàng</p>
                <div class="kiemtradonhang-show">
                  <p class="list"><input type="text" placeholder="Nhập mã hàng"></p>
                  <p class="list"><input type="text" placeholder="Email/số điện thoại"></p>
                </div>
                <p class="list">
                  <a href="<?php echo azibai_url() ?>">
                      <img src="/templates/home/styles/images/svg/a.svg" alt="" width="24" class="mr15">Azibai
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
        </nav>
      </div>
    </div>
</header>
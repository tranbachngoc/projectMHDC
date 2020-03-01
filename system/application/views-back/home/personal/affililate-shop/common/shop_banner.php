<?php
$srcbanner = '/templates/home/images/cover/cover_me.jpg';
if($currentuser->use_cover) {
  $srcbanner = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $currentuser['use_id'] . '/' . $currentuser['use_cover'];
}

?>
<div class="shop-banner">
  <div class="shop-banner-img">
    <img src="<?=$srcbanner?>" alt="">
  </div>
  <div class="shop-banner-stylesm">
    <div class="shop-banner-avata">
      <div class="logo">
        <img src="<?=$current_profile['avatar_url']?>" alt="">
      </div>
      <div class="name"><?=$current_profile['use_fullname']?></div>
    </div>
    <div class="shop-banner-find">
      <p class="search"><input type="text" placeholder="Tìm kiếm sản phẩm"><img src="/templates/home/styles/images/svg/search.svg" alt=""></p>
      <div class="shop-banner-follow">
        <!-- <select class="theodoi" name="" id="be-menu-shop">
          <option value="none">Danh mục quản trị</option>
          <option value="account/shop">Quản lý cửa hàng</option>
          <option value="product/add">Đăng sản phẩm</option>
          <option value="coupon/add">Đăng coupon</option>
          <option value="account/user_order/product">Quản lý đơn hàng</option>
        </select> -->

        <div class="nguoitheodoi md">Người theo dõi <span>567</span></div>
        <div class="list-icons">
          <p><a href="">
            <img src="/templates/home/styles/images/svg/comment_3dot.svg" alt="">
          </a></p>
          <p class="sm"><a href="">
            <img src="/templates/home/styles/images/svg/tel.svg" alt="">
          </a></p>
          <p class="share-click" data-toggle="modal" data-name="<?php echo $current_profile['use_fullname']; ?>" data-value="<?php echo $share_url; ?>" data-type="<?php echo $type_share; ?>" data-item_id="" data-permission="<?php echo ($this->session->userdata('sessionUser') == $current_profile['use_id']) ? 1 : '';?>">
            <a href="#">
              <img src="/templates/home/styles/images/svg/share.svg " alt="">
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
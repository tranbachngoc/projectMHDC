<?php
if (!empty($shop_current->sho_logo)) {
  $sho_logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $shop_current->sho_dir_logo . '/' . $shop_current->sho_logo;
} else {
  $sho_logo = '/templates/home/styles/avatar/default-avatar.png';
}

if (!empty($shop_current->sho_banner)) {
  $srcbanner = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $shop_current->sho_dir_banner . '/' . $shop_current->sho_banner;
} else {
  $srcbanner = '/templates/home/images/cover/cover_me.jpg';
}
?>
<div class="shop-banner">
  <div class="shop-banner-img">
    <img src="<?=$srcbanner?>" alt="">
  </div>
  <div class="shop-banner-stylesm">
    <div class="shop-banner-avata">
      <div class="logo">
        <img src="<?=$sho_logo?>" alt="">
      </div>
      <div class="name"><?=$shop_current->sho_name?></div>
    </div>
    <div class="shop-banner-find">
      <p class="search">
        <!-- <input type="text" placeholder="Tìm kiếm sản phẩm"><img src="/templates/home/styles/images/svg/search.svg" alt=""> -->
      </p>
      <div class="shop-banner-follow">
        <?php if($this->uri->segment(1) == 'shop' && $this->session->userdata('sessionUser') == $shop_current->sho_user){ ?>
        <select class="theodoi" name="" id="be-menu-shop">
          <option value="none">Danh mục quản trị</option>
          <option value="account/shop">Quản lý cửa hàng</option>
          <option value="product/add/<?php echo $shop_current->sho_user;?>">Đăng sản phẩm</option>
          <option value="coupon/add/<?php echo $shop_current->sho_user;?>">Đăng coupon</option>
          <option value="account/user_order/product">Quản lý đơn hàng</option>
        </select>
        <script>
          
          $('select#be-menu-shop').change(function(){
            var option = $(this).children("option:selected").val();
            if(option != 'none'){
              var link = '<?=azibai_url()?>/'+option;
              window.open(link, '_blank');
            }
          })
        </script>
        <?php } ?>

        <div class="nguoitheodoi md">Người theo dõi <span>567</span></div>
        <div class="list-icons">
          <p><a href="">
            <img src="/templates/home/styles/images/svg/comment_3dot.svg" alt="">
          </a></p>
          <p class="sm"><a href="">
            <img src="/templates/home/styles/images/svg/tel.svg" alt="">
          </a></p>
          <?php
          $per = '';
          if($this->session->userdata('sessionUser')){
            if($this->session->userdata('sessionUser') == $sho_user){
              $per = 1;
            }
          }
          ?>
          <p class="share-click" data-toggle="modal" data-name="<?php echo $share_name; ?>" data-value="<?php echo $share_url; ?>" data-type="<?php echo $type_share; ?>" data-item_id="" data-permission="<?php echo $per;?>">
            <a href="#">
              <img src="/templates/home/styles/images/svg/share.svg " alt="">
            </a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="temp-share">
<?php 
$this->load->view('home/share/popup-btn-share');
?>
</div>
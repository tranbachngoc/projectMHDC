<?php 
$avatar_default = '/templates/home/styles/avatar/default-avatar.png';
$shop_url_item = shop_url($item);
// $shop_url_current = $shop_current->shop_url;
?>

<div class="col-xl-6 col-lg-12">
  <div class="item">
    <div class="text">
      <div class="name">
        <div class="avata">
          <a href="<?=$shop_url_item?>">
            <img src="<?=!empty($item->sho_logo) ? $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/' . $item->sho_dir_logo . '/' . $item->sho_logo : $avatar_default  ?>" 
              alt=""
              onerror="error_image(this)">
          </a>
        </div>
        <div class="tit two-lines"><a href="<?=$shop_url_item?>"><?=$item->sho_name?></a></div>
      </div>
      <div class="shop-address one-line">
        <img src="/templates/home/styles/images/svg/map.svg" class="mr05" alt=""><?=$item->sho_address ? $item->sho_address : 'Chưa cập nhật.'?>
      </div>
      <!-- <a class="icon-linkto" href="<?=$shop_url_current .'page-business/' . $item->use_id; ?>"><img src="/templates/home/styles/images/svg/linkto.svg" alt=""></a> -->
    </div>
    <div class="group-buttons">
      <a href="javascript:void(0)" class="btn btn-white">
        <img class="mr05" src="/templates/home/styles/images/svg/theodoi.svg" alt="">Theo dõi</a>
      <a href="javascript:void(0)" class="btn btn-white" onclick="alert('tính năng đang xây dựng')">
        <img class="mr05" src="/templates/home/styles/images/svg/message.svg" alt="">Nhắn tin</a>
      <a href="tel:<?=$item->sho_mobile?>" class="btn btn-pink">
        <img class="mr05" src="/templates/home/styles/images/svg/tel_white.svg" alt="">Gọi điện</a>
    </div>
  </div>
</div>
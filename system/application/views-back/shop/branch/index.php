<?php
$group_id = (int)$this->session->userdata('sessionGroup');
$user_id  = (int)$this->session->userdata('sessionUser');
//if visit from azibai show menu azibai
if(isset($visited_azibai) && $visited_azibai == date('Y-m-d')){
    $this->load->view('home/common/header_new');
}else{
    $this->load->view('shop/news/elements/header_shop_news', ['body_class' => 'trangtinchitiet']);
}
?>

<link href="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.css" rel="stylesheet">
<link href="/templates/home/styles/css/modal-show-details.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/enterprise.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/shop/shop-media.css" rel="stylesheet" type="text/css">
<link href="/templates/home/styles/css/shop.css" rel="stylesheet" type="text/css">

<script src="/templates/home/styles/js/common.js"></script>

<script src="/templates/home/styles/plugins/CustomScrollbar/jquery.mCustomScrollbar.concat.min.js"></script>
<script src="/templates/home/styles/plugins/lazyload/jquery.lazyload.js"></script>
<script src="/templates/home/js/jquery.appear.js"></script>
<script src="/templates/home/styles/js/shop-upload-cover-avatar.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<?php
if($is_owns){
    $cover_path = 'shop/news/elements/cover_login';
}else {
    $cover_path = 'shop/news/elements/cover_not_login';
}
?>
<main class="trangcuatoi tindoanhnghiep <?php echo isset($view_type) && $view_type == 'list' ? 'bg-black' : 'bg-white'; ?>">
    <section class="main-content">
        <div class="container">
            <div class="cover-content">
                <?php echo $this->load->view($cover_path);  ?>
            </div>
            <div class="sidebarsm">
                <div class="gioithieu">
                    <?php $this->load->view('shop/news/elements/menu_left_items') ?>
                </div>
            </div>
        </div>
        <div class="container frontend-list-branchs">
          <div class="row">
            <?php if (!empty($list_bran)) { ?>
                <?php foreach ($list_bran as $key => $value) { ?>
                  <div class="col-md-6 col-lg-4">
                    <div class="item">
                      <div class="info">
                        <?php 
                          $path_banner_bran = '/templates/home/images/cover/cover_me.jpg';
                          if($value->sho_dir_banner && $value->sho_banner){
                              $path_banner_bran = $this->config->item('banner_shop_config')['cloud_server_show_path'] . '/' .$value->sho_dir_banner.'/'.$value->sho_banner;
                          }
                        ?>

                        <?php
                          $info_public_avatar_path = '/templates/home/styles/avatar/default-avatar.png';
                          if($value->sho_dir_logo && $value->sho_logo){
                              $info_public_avatar_path = $this->config->item('logo_shop_config')['cloud_server_show_path'] . '/' .$value->sho_dir_logo.'/'.$value->sho_logo;
                          }
                        ?>
                        
                        <?php 
                          if ($value->domain != '') 
                          {
                            $shop_link = $value->domain;
                          }
                          else
                          {
                            $shop_link = $value->sho_link.'.'.domain_site;
                          }
                        ?>
                        <img src="<?php echo $path_banner_bran; ?>" alt="" class="main-img">
                        
                        <div class="name-branch">
                          <div class="avt"><a href="<?php echo get_server_protocol().$shop_link; ?>"><img src="<?php echo $info_public_avatar_path; ?>" alt=""></a></div>
                          <div class="tit one-line">
                            <a href="<?php echo get_server_protocol().$shop_link; ?>"><?php echo $value->sho_name; ?></a>
                          </div>
                        </div>
                        <div class="button-actions">
                          <a class="follow"><img src="/templates/home/styles/images/svg/theodoi.svg" alt="">Theo dõi</a>
                          <div class="icons">
                            <div class="tel icons-style"><a href=""><img src="/templates/home/styles/images/svg/tel_white.svg" alt=""></a></div>
                            <div class="mess icons-style"><a href=""><img src="/templates/home/styles/images/svg/message02_white.svg" alt=""></a></div>
                          </div>
                        </div>
                      </div>
                      <div class="address">
                        <div class="one-line">
                          <img src="/templates/home/styles/images/svg/map.svg" class="mr05" alt="">
                          <?php 
                            if (empty($v->sho_address) && empty($v->province_name) && empty($v->district_name)) 
                            {
                              echo 'Đang cập nhật!';
                            }
                            else
                            {
                              echo $v->sho_address .', '. $v->district_name .', '. $v->province_name;
                            }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>

                <?php } ?>
              <?php } ?>
          </div>
        </div>
    </section>
</main>
<?php $this->load->view('shop/shop/footer-layout') ?>
</div>
</body>
</html>

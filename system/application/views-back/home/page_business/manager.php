<?php
$this->load->view('home/common/header_new');
?>
<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">
<script src="/templates/home/styles/js/common.js"></script>


<main>
  <?php 
    $avatar_default  = site_url('media/images/avatar/default-avatar.png');
  ?>      
  <section class="main-content business-management">
    <div class="container">
      <div class="business-management-title">
        <div class="avata"><img src="<?php echo !empty($user->avatar) ? $this->config->item('avatar_user_config')['cloud_server_show_path'] . '/' . $user->use_id . '/' .  $user->avatar : $avatar_default  ?>" alt=""></div><br>
        <div class="name">Xin chào <span><?php echo $user->use_fullname; ?></span></div>
      </div>
      <div class="business-management-content">
        <div class="row business-management-items">
          <!-- <div class="col-md-4 item">
            <div class="sub-title">Quản lý <?php echo $user_shop->use_group == 3 ? 'gian hàng' : 'chi nhánh' ?> </div>
            <div class="img"><img src="/templates/home/styles/images/svg/business_management01.png" alt=""></div>
            <div class="text"></div>
            <div class="domain-for-page">
              <a href="">Gắn tên miền cho trang</a>
            </div>
          </div> -->
          <div class="col-md-4 item">
            <div class="sub-title">Quản lý bài viết</div>
            <div class="img"><img src="/templates/home/styles/images/svg/business_management02.png" alt=""></div>
            <div class="text"></div>
            <div class="domain-for-page">
              <!-- <a href="">Đăng bài viết mới</a> -->
              <a href="<?php echo base_url() .'page-business/news/' . $user_shop->use_id; ?>">Bài viết  đã đăng</a>
              <a href="<?php echo base_url() .'page-business/list-news/' . $user_shop->use_id; ?>">
                <?php echo $user_shop->use_group == 3 ? 'Bài viết từ chi nhánh' : 'Bài viết từ gian hàng' ?>
              </a>
              <!-- <a href="">Quản lý bình luận</a> -->
            </div>
          </div>
          <div class="col-md-4 item">
            <div class="sub-title">Quản lý hàng hóa</div>
            <div class="img"><img src="/templates/home/styles/images/svg/business_management03.png" alt=""></div>
            <div class="text"></div>
            <div class="domain-for-page">
              <a target="_blank"  href="<?php echo base_url() .'product/add/' . $user_shop->use_id; ?>">Đăng sản phẩm</a>
              <a href="<?php echo base_url() .'page-business/products/' . $user_shop->use_id; ?>">Sản phẩm đã đăng</a>
              <a href="<?php echo base_url() .'page-business/list-product/' . $user_shop->use_id; ?>">
                <?php echo $user_shop->use_group == 3 ? 'Sản phẩm từ chi nhánh' : 'Sản phẩm từ gian hàng' ?>
              </a>
              <a target="_blank" href="<?php echo base_url() .'coupon/add/' . $user_shop->use_id ?>">Đăng phiếu mua hàng</a>
              <a href="<?php echo base_url() .'page-business/coupons/' . $user_shop->use_id; ?>">Phiếu mua hàng đã đăng</a>
              <a href="<?php echo base_url() .'page-business/list-coupon/' . $user_shop->use_id; ?>">
                <?php echo $user_shop->use_group == 3 ? 'Phiếu mua hàng từ chi nhánh' : 'Phiếu mua hàng từ gian hàng' ?>
              </a>
              <a href="<?php echo base_url() .'page-business/create-voucher/' . $user_shop->use_id . '?step=1'?>">Đăng mã giảm giá</a>
              <a href="<?php echo base_url() .'page-business/list-voucher/' . $user_shop->use_id ?>">Mã giảm giá đã đăng</a>
            </div>
          </div>
          <div class="col-md-4 item">
            <div class="sub-title">Quản lý đơn hàng</div>
            <div class="img"><img src="/templates/home/styles/images/svg/business_management04.png" alt=""></div>
            <div class="text"></div>
            <div class="domain-for-page">
              <a href="<?=azibai_url("/page-business/list-order/{$user_shop->use_id}")?>">Danh sách đơn hàng</a>
            </div>
          </div>
          <!-- <div class="col-md-4 item">
            <div class="sub-title">Yêu cầu khiếu nại</div>
            <div class="img"><img src="/templates/home/styles/images/svg/business_management05.png" alt=""></div>
            <div class="text"></div>
            <div class="domain-for-page">
              <a href="">Khiếu nại mới</a>
              <a href="">Khiếu nại đã giải quyết</a>
            </div>
          </div> -->
          <!-- <div class="col-md-4 item">
            <div class="sub-title">Thu nhập gian hàng</div>
            <div class="img"><img src="/templates/home/styles/images/svg/business_management06.png" alt=""></div>
            <div class="text"></div>
            <div class="domain-for-page">
              <a href="">Thu nhập tạm tính</a>
              <a href="">Thu nhập gian hàng</a>
            </div>
          </div> -->
          <!-- <div class="col-md-4 item">
            <div class="sub-title">Thống kê hệ thống</div>
            <div class="img"><img src="/templates/home/styles/images/svg/business_management07.png" alt=""></div>
            <div class="text"></div>
            <div class="domain-for-page">
              <a href="">Thống kê chung</a>
              <a href="">Thống kê thu nhập</a>
              <a href="">Thống kê chi nhánh</a>
              <a href="">Thống kê cộng tác viên</a>
              <a href="">Thống kê cộng tác viên chi nhánh</a>
              <a href="">Thống kê theo sản phẩm</a>
            </div>
          </div> -->

          <?php if(isset($is_systema) && $is_systema == 1){ ?>
          <div class="col-md-4 item">
            <div class="sub-title">Quản lý cộng tác viên</div>
            <div class="img"><img src="/templates/home/styles/images/svg/business_management10.png" alt=""></div>
            <div class="text"></div>
            <div class="domain-for-page">
              <a href="<?=base_url() .'page-business/inviteaffiliate/'.$user_shop->use_id?>" target="_blank" >Giới thiệu mở cộng tác viên</a>
              <a href="<?php echo base_url() .'page-business/listaffiliate/'.$user_shop->use_id.'?affiliate=all'; ?>">Danh sách cộng tác viên tuyển dụng</a>
            </div>
          </div>
          <?php } ?>

          <?php if($user_shop->use_group == 3){ ?>
          <div class="col-md-4 item">
            <div class="sub-title">Quản lý chi nhánh</div>
            <div class="img"><img src="/templates/home/styles/images/svg/business_management09.png" alt=""></div>
            <div class="text"></div>
            <div class="domain-for-page">
              <a href="<?php echo base_url() .'page-business/list-branch/' . $user_shop->use_id; ?>">Danh sách chi nhánh</a>
              <a href="<?php echo base_url() .'page-business/list-product-branch/' . $user_shop->use_id; ?>">Sản phẩm của chi nhánh chờ duyệt</a>
              <a href="<?php echo base_url() .'page-business/list-coupon-branch/' . $user_shop->use_id; ?>">Phiếu mua hàng của chi nhánh chờ duyệt</a>
              <a href="<?php echo base_url() .'page-business/list-news-branch/' . $user_shop->use_id; ?>">Tin tức của chí nhánh chờ duyệt </a>
              <!-- <a href="">Tờ rơi chờ duyệt</a> -->
            </div>
          </div>
          <div class="col-md-4 item">
            <div class="sub-title">Dịch vụ azibai</div>
            <div class="img"><img src="/templates/home/styles/images/svg/business_management11.png" alt=""></div>
            <div class="text"></div>
            <div class="domain-for-page">
              <?php if($data_config_status['setting_transport'] == true) { ?>
              <a href="<?php echo base_url() .'page-business/config/transport/' . $user_shop->use_id; ?>">Đấu cổng vận chuyển</a>
              <?php } ?>
              <?php if($data_config_status['setting_pay'] == true) { ?>
              <a href="<?php echo base_url() .'page-business/config/payment_nl/' . $user_shop->use_id; ?>">Đấu cổng thanh toán</a>
              <?php } ?>
            </div>
          </div>
          <?php } ?>
          <!-- <div class="col-md-4 item">
            <div class="sub-title">Quản lý chi tiêu</div>
            <div class="img"><img src="/templates/home/styles/images/svg/business_management12.png" alt=""></div>
            <div class="text"></div>
            <div class="domain-for-page">
              <a href="">example</a>
            </div>
          </div> -->
        </div>
      </div>
    </div>
  </section>
</main>

<footer id="footer" class="footer-border-top">
<?php $this->load->view('e-azibai/common/common-html-footer'); ?>
<?php $this->load->view('home/common/overlay_waiting')?>
<script src="/templates/home/js/page_business.js"></script>
</footer>
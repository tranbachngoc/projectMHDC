<div class="control-board-content">
  <div class="control-board-icon">
    <img src="/templates/home/styles/images/svg/control_board.svg" alt="" class="mr05">Bảng điều khiển
  </div>
  <div class="control-board-item">
    <div class="bg">
      <h3 class="tit">BẢNG ĐIỀU KHIỂN</h3>
      <div class="accordion js-accordion">
        <!-- <div class="accordion-item mb20">
          <div class="cate-parent accordion-toggle">
            <h4 class="tt">Quản lý gian hàng</h4>
          </div>
          <div class="cate-child accordion-panel">
            <p><a href="">Gắn tên miền cho trang</a></p>
          </div>
        </div> -->
        <div class="accordion-item mb20">
          <div class="cate-parent accordion-toggle">
            <h4 class="tt">Quản lý bài viết</h4>
          </div>
          <div class="cate-child accordion-panel">
            <!-- <p><a href="">Đăng bài viết mới</a></p> -->
            <p><a href="<?php echo base_url() .'page-business/news/' . $user_shop->use_id; ?>">Bài viết  đã đăng</a></p>
            <p><a href="<?php echo base_url() .'page-business/list-news/' . $user_shop->use_id; ?>">
              <?php echo $user_shop->use_group == 3 ? 'Bài viết từ chi nhánh' : 'Bài viết từ gian hàng' ?>
            </a></p>
            <!-- <p><a href="">Quản lý bình luận</a></p> -->
          </div>
        </div>
        <div class="accordion-item mb20">
          <div class="cate-parent accordion-toggle">
            <h4 class="tt">Quản lý hàng hóa</h4>
          </div>
          <div class="cate-child accordion-panel">
            <p><a target="_blank"  href="<?php echo base_url() .'product/add/' . $user_shop->use_id; ?>">Đăng sản phẩm</a></p>
            <p><a href="<?php echo base_url() .'page-business/products/' . $user_shop->use_id; ?>">Sản phẩm đã đăng</a></p>
            <p><a href="<?php echo base_url() .'page-business/list-product/' . $user_shop->use_id; ?>">
              <?php echo $user_shop->use_group == 3 ? 'Sản phẩm từ chi nhánh' : 'Sản phẩm từ gian hàng' ?>
            </a></p>
            <p><a target="_blank" href="<?php echo base_url() .'coupon/add/' . $user_shop->use_id ?>">Đăng phiếu mua hàng</a></p>
            <p><a href="<?php echo base_url() .'page-business/coupons/' . $user_shop->use_id; ?>">Phiếu mua hàng đã đăng</a></p>
            <p><a href="<?php echo base_url() .'page-business/list-coupon/' . $user_shop->use_id; ?>">
              <?php echo $user_shop->use_group == 3 ? 'Phiếu mua hàng từ chi nhánh' : 'Phiếu mua hàng từ gian hàng' ?>
            </a></p>
            <p><a href="<?php echo base_url() .'page-business/create-voucher/' . $user_shop->use_id . '?step=1'?>">Đăng mã giảm giá</a></p>
            <p><a href="<?php echo base_url() .'page-business/list-voucher/' . $user_shop->use_id ?>">Mã giảm giá đã đăng</a></p>
          </div>
        </div>
        <div class="accordion-item mb20">
          <div class="cate-parent accordion-toggle">
            <h4 class="tt">Quản lý đơn hàng</h4>
          </div>
          <div class="cate-child accordion-panel">
            <p><a href="<?=azibai_url("/page-business/list-order/{$user_shop->use_id}")?>">Danh sách đơn hàng</a></p>
          </div>
        </div>
        <!-- <div class="accordion-item mb20">
          <div class="cate-parent accordion-toggle">
            <h4 class="tt">Thu nhập gian hàng</h4>
          </div>
          <div class="cate-child accordion-panel">
            <p><a href="">Thu nhập tạm tính</a></p>
            <p><a href="">Thu nhập gian hàng</a></p>
          </div>
        </div> -->
        <!-- <div class="accordion-item mb20">
          <div class="cate-parent accordion-toggle">
            <h4 class="tt">Thống kê hệ thống</h4>
          </div>
          <div class="cate-child accordion-panel">
            <p><a href="">Thống kê chung</a></p>
            <p><a href="">Thống kê thu nhập</a></p>
            <p><a href="">Thống kê chi nhánh</a></p>
            <p><a href="">Thống kê cộng tác viên</a></p>
            <p><a href="">Thống kê cộng tác viên chi nhánh</a></p>
            <p><a href="">Thống kê theo sản phẩm</a></p>
          </div>
        </div> -->
        <?php if(isset($is_systema) && $is_systema == 1){ ?>
        <div class="accordion-item mb20">
          <div class="cate-parent accordion-toggle">
            <h4 class="tt">Quản lý cộng tác viên</h4>
          </div>
          <div class="cate-child accordion-panel">
            <p><a href="<?=base_url() .'page-business/inviteaffiliate/' . $user_shop->use_id?>" target="_blank" >Giới thiệu mở cộng tác viên</a></p>
            <p><a href="<?php echo base_url() .'page-business/listaffiliate/'.$user_shop->use_id.'?affiliate=all'; ?>">Danh sách cộng tác viên tuyển dụng</a></p>
          </div>
        </div>
        <?php } ?>
        <?php if($user_shop->use_group == 3){ ?>
        <div class="accordion-item mb20">
          <div class="cate-parent accordion-toggle">
            <h4 class="tt">Quản lý chi nhánh</h4>
          </div>
          <div class="cate-child accordion-panel">
            <p><a href="<?php echo base_url() .'page-business/list-branch/' . $user_shop->use_id; ?>">Danh sách chi nhánh</a></p>
            <p><a href="<?php echo base_url() .'page-business/list-product-branch/' . $user_shop->use_id; ?>">Sản phẩm của chi nhánh chờ duyệt</a></p>
            <p><a href="<?php echo base_url() .'page-business/list-coupon-branch/' . $user_shop->use_id; ?>">Phiếu mua hàng của chi nhánh chờ duyệt</a></p>
            <p><a href="<?php echo base_url() .'page-business/list-news-branch/' . $user_shop->use_id; ?>">Tin tức của chí nhánh chờ duyệt </a></p>
            <!-- <p><a href="">Tờ rơi chờ duyệt</a></p> -->
          </div>
        </div>
        <!-- <div class="accordion-item mb20">
          <div class="cate-parent accordion-toggle">
            <h4 class="tt">Dịch vụ azibai</h4>
          </div>
          <div class="cate-child accordion-panel">
            <p><a href="">Dịch vụ đang sử dụng</a></p>
          </div>
        </div> -->
        <?php } ?>
        <!-- <div class="accordion-item mb20">
          <div class="cate-parent accordion-toggle">
            <h4 class="tt">Quản lý chi tiêu</h4>
          </div>
          <div class="cate-child accordion-panel">
            <p><a href="">example</a></p>
          </div>
        </div> -->
        <div class="accordion-item mb20">
          <div class="cate-parent accordion-toggle">
            <h4 class="tt">Dịch vụ azibai</h4>
          </div>
          <div class="cate-child accordion-panel">
            <?php if($data_config_status['setting_transport'] == true) { ?>
              <p><a href="<?php echo base_url() .'page-business/config/transport/' . $user_shop->use_id; ?>">Đấu cổng vận chuyển</a></p>
            <?php } ?>
            <?php if($data_config_status['setting_pay'] == true) { ?>
              <p><a href="<?php echo base_url() .'page-business/config/payment_nl/' . $user_shop->use_id; ?>">Đấu cổng thanh toán</a></p>
            <?php } ?>
          </div>
        </div>
        <div class="mb20">
          <h4 class="tt"><a href="<?=azibai_url("/page-business")?>">Quản lý trang</a></h4>
        </div>
      </div>
    </div>
  </div>
</div>


<?php
$this->load->view('home/common/header_new');
?>
<link href="<?php echo base_url()?>/templates/landing_page/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">
<script src="/templates/home/styles/js/common.js"></script>

<main class="cart-content main-content">
    <div class="container">
      <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title"><?php echo ($order_status == 1) ? 'Đặt hàng thành công' : 'Đơn hàng thanh toán thất bại' ?></h4>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body">
            <div class="successfully-ordered-modal">
              <p>Chào <span class="name_user"><?php echo $name_user; ?></span>,</p>
              <div class="js-swap-order-item">
              <div class="ordered-items">
                </p>Quý khách vừa đặt thành công sản phẩm của shop <a href="<?php echo $sho_link; ?>"><i class="text-red"><?php echo $shop_name; ?></i></a>, mã đơn hàng của quý khách là:</p>
                <div class="code"><?php echo $order_id; ?></div>
                <p>Quý khách có thể quản lý và theo dõi đơn hàng tại: <strong>menu quản trị</strong> > <a href="<?= azibai_url(); ?>/account/user_order/product" class="text-red">Kiểm tra đơn hàng</a><br/>Hoặc bấm vào <strong>Chi tiết đơn hàng</strong> phía dưới</p>
                <div class="text-center">
                  <a class="detail-of-delivery" href="<?php echo $order_link; ?>">CHI TIẾT ĐƠN HÀNG</a>
                </div>
              </div>  
              </div>              
              <div class="text-center">
                <a href="<?php echo base_url();?>shop/products"><p class="continue-shopping">TIẾP TỤC MUA HÀNG</p></a>
              </div>
              <p>Cảm ơn quý khách đã tin tưởng và giao dịch tại <a href="https://www.azibai.com" class="text-red">www.azibai.com</a></p>
            </div>
          </div>
          <!-- End modal-footer -->
      </div>
    </div>
</main>

<footer id="footer" class="footer-border-top">
<?php $this->load->view('e-azibai/common/common-html-footer'); ?>
<?php $this->load->view('home/common/overlay_waiting')?>
</footer>
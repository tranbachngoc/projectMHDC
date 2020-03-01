<?php $this->load->view('home/common/checkout/header'); ?>

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/orders_success.css" />
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 hidden-md hidden-sm hidden-xs">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-10">
            <div class="breadcrumbs hidden-xs">
                <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                <span>Thông tin đơn hàng</span>
            </div>
                <div class="checkout-success ">   
                    <h2 class="ttl-checkout">Không tìm thấy đơn hàng</h2>
                    <div class="checkout-success-cont">      
                        <div class="checkout-success-cont-bg">
                            <div class="content-order">

                                <p>
                                    Không tìm thấy thông tin đơn hàng với thông tin bạn cung cấp. Vui lòng kiểm tra lại thông tin thật chính xác.
                                    <br>
                                    <br>
                                    Mã đơn hàng: <b>#<?php echo $order_id ?></b>
                                    <br>
                                    Email người nhận hàng: <b><?php echo $order_email ?></b>
                                </p>

                                <div class="contact-info">
                                    <div>Mọi thắc mắc vui lòng liên hệ: <strong><?php echo HOTLINE;?></strong></div>        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
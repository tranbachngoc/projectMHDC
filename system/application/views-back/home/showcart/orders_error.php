<?php $this->load->view('home/common/checkout/header'); ?>

<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/orders_success.css" />
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 hidden-md hidden-sm hidden-xs" >
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-10">
            <div class="breadcrumbs hidden-xs">
                <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                <span>Đặt hàng thất bại</span>
            </div>
                <div class="checkout-success ">   
                    <h2 class="ttl-checkout">Đặt hàng thất bại</h2>
                    <div class="checkout-success-cont">      
                        <div class="checkout-success-cont-bg">        
                                <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/style_azibai_bao.css" />
                                <div class="nganluong_cancle">
                                    <div class="error-template">
                                        <h1>
                                            Thanh toán thất bại</h1>
                                        <h4>
                                           Quá trình thanh toán không thành công</h4>
                                        <div class="error-details">
                                            Quá trình thanh toán của bạn chưa hoàn tất, chọn liên kết bên dưới để về trang chủ:
                                        </div>
                                        <div class="error-actions">
                                            <a href="<?php echo base_url(); ?>" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
                                                Quay về trang chủ </a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
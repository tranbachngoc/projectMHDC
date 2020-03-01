<?php $this->load->view('home/common/header'); ?>

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/orders_success.css" />
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 hidden-md hidden-sm hidden-xs" style="background:#fff; position:fixed; top:0; bottom:0; z-index:100">
                <?php $this->load->view('home/common/left_tintuc'); ?>
            </div>
            <div class="col-lg-10 col-lg-offset-2 ">
                <div class="breadcrumbs hidden-xs">
                    <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                    <span>Nạp tiền thành công</span>
                </div>
                <div class="checkout-success ">
                    <h2 class="ttl-checkout">Nạp tiền thành công</h2>
                    <div class="checkout-success-cont">
                        <div class="checkout-success-cont-bg">
                            <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/style_azibai_bao.css" />
                            <div class="nganluong_cancle">
                                <div class="error-template">
                                    <h1>
                                        Nạp tiền thành công</h1>
                                    <h4>

                                    <div class="error-actions">
                                        <a href="<?php echo base_url(); ?>" class="btn btn-azibai btn-lg"><span class="glyphicon glyphicon-home"></span>
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
<?php $this->load->view('home/common/account/header'); ?>

    <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/orders_success.css" />
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 hidden-md hidden-sm hidden-xs" style="background:#fff; position:fixed; top:0; bottom:0; z-index:100">
                <?php $this->load->view('home/common/left_tintuc'); ?>
            </div>
            <div class="<?php echo ($this->session->userdata('sessionGroup') == AffiliateStoreUser) ? 'col-md-12' : 'col-md-9' ?> col-xs-12">
                <div class="breadcrumbs hidden-xs">
                    <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                    <span>Nạp tiền thành công</span>
                </div>
                <div class="checkout-success ">
                    <div class="alert alert-success alert-dismissible fade in" role="alert">
                        <h4>Nạp tiền thành công!</h4>
                        <p>Chúc mừng bạn đã nạp tiền thành công vào tài khoản của bạn trên <a
                                href="<?php echo base_url() ?>"> Azibai.com</a> qua cổng thanh toán Ngân Lượng</p>
                        <p><a href="<?php echo base_url() ?>account/historyRechargeNL" class="btn btn-primary"><span class="glyphicon glyphicon-home"></span> Quay về Lịch sử nạp tiền</a>
                          </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('home/common/footer'); ?>
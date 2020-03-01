<?php $this->load->view('home/common/account/header'); ?>
<style>
    #statistic .box_item {
        height: 130px;
    }
    #statistic {
        overflow: auto !important;
    }
    #columnchart_values_day,#columnchart_values_month,#columnchart_values_year{
        width: 100%;
        margin-bottom: 20px;
        overflow-x: auto;
        height: 410px !important;
        overflow-y: hidden;
    }
    #columnchart_values_day::-webkit-scrollbar,#columnchart_values_month::-webkit-scrollbar,#columnchart_values_year::-webkit-scrollbar
    {
        width: 5px;
        background-color: #F5F5F5;
        height: 8px;
    }

    #columnchart_values_day::-webkit-scrollbar-track,#columnchart_values_month::-webkit-scrollbar-track,#columnchart_values_year::-webkit-scrollbar-track
    {
        -webkit-box-shadow: inset 0 0 3px rgba(0,0,0,0.9);
        border-radius: 5px;
        background-color: #CCCCCC;
    }

    #columnchart_values_day::-webkit-scrollbar-thumb,#columnchart_values_month::-webkit-scrollbar-thumb,#columnchart_values_year::-webkit-scrollbar-thumb
    {
        border-radius: 5px;
        background-color: #2a292a;
        background-image: -webkit-linear-gradient(90deg,
        transparent,
        rgba(0, 0, 0, 0.4) 20%,
        transparent,
        transparent)
    }

</style>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">Thống kê chung</h4>
            <div id="panel_direct">
                <div id="main">
                    <?php if ($this->session->userdata('sessionGroup') == 3) { ?>
                        <ul class="nav nav-tabs">
                            <li class="active"><a aria-expanded="true" href="#tab2success" data-toggle="tab">Chung</a></li>
                            <li class=""><a aria-expanded="false" href="#tab1success" data-toggle="tab">Tổng</a></li>
                        </ul>
                    <?php } ?>

                    <div class="tab-content" id="statistic"> 
                        <div class="tab-pane fade active in" id="tab2success">
                            <div class="col-lg-3 col-md-3 col-sm-4 box_item col-xs-6">
                                <div class="panel panel-warning">
                                    <p>Đơn hàng hôm nay</p>
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span><?php echo $totaldonhanghnay; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 box_item col-xs-6">
                                <div class="panel panel-success">
                                    <p>Doanh số hôm nay</p>
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                    <span><?php echo number_format($total_re, 0, ',', '.'); ?> đ</span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 box_item col-xs-6">
                                <div class="panel panel-info">
                                    <p>Doanh số hôm qua</p>
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                    <span><?php echo ($sales_yesterday) ? number_format($sales_yesterday, 0, ',', '.') : '0'; ?>
                                        đ</span>
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-3 col-sm-4 box_item col-xs-6">
                                <div class="panel panel-info">
                                    <p>Doanh số tháng này</p>
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                    <span><?php echo ($current_month) ? number_format($current_month, 0, ',', '.') : '0'; ?>
                                        đ</span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 box_item col-xs-6">
                                <div class="panel panel-info">
                                    <p>Doanh số tháng trước</p>
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                    <span><?php echo ($last_month) ? number_format($last_month, 0, ',', '.') : '0'; ?>
                                        đ</span>
                                </div>
                            </div>
                            <?php if ($this->session->userdata('sessionGroup') != StaffStoreUser && $this->session->userdata('sessionGroup') != StaffUser): ?>
                                <a href="<?php echo base_url() . 'account/statisticIncome'; ?>">
                                    <div class="col-lg-3 col-md-3 col-sm-4 box_item col-xs-6">
                                        <div class="panel panel-info">
                                            <p>Thu nhập hiện tại</p>
                                            <i class="fa fa-money" aria-hidden="true"></i>
                                            <span><?php echo ($current_earnings[0]->amount) ? number_format($current_earnings[0]->amount, 0, ',', '.') : '0'; ?>
                                                đ</span>
                                        </div>
                                    </div>
                                </a>

                            <?php endif; ?>
                            <?php if ($this->session->userdata('sessionGroup') == BranchUser || $this->session->userdata('sessionGroup') == AffiliateUser || $this->session->userdata('sessionGroup') == StaffStoreUser || $this->session->userdata('sessionGroup') == StaffUser): ?>
                                <div class="col-lg-3 col-md-3 col-sm-4 box_item col-xs-6">
                                    <div class="panel panel-danger">
                                        <p>Tổng đơn hàng</p>
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        <span><?php echo $total_order; ?></span>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-4 box_item col-xs-6">
                                    <div class="panel panel-success">
                                        <p>Tổng doanh số</p>
                                        <i class="fa fa-archive" aria-hidden="true"></i>
                                        <span><?php echo number_format($total, 0, ',', '.'); ?> đ</span>
                                    </div>
                                </div>

                            <?php endif; ?>

                            <div class="clearfix"></div>
                        </div>

                        <div class="tab-pane fade" id="tab1success">
                            <div class="col-lg-3 col-md-3 col-sm-4 box_item col-xs-6">
                                <div class="panel panel-danger">
                                    <p>Tổng đơn hàng</p>
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                    <span><?php echo $total_order; ?></span>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 box_item col-xs-6">
                                <div class="panel panel-success">
                                    <p>Tổng doanh số</p>
                                    <i class="fa fa-archive" aria-hidden="true"></i>
                                    <span><?php echo number_format($total, 0, ',', '.'); ?> đ</span>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <?php echo $service_charts; ?>                        
                    </div>
                </div>

            </div>
        </div>
        <!--BEGIN: RIGHT-->
    </div>
</div>

    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
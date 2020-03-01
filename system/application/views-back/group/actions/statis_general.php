<?php $this->load->view('group/common/header'); ?>
<br>
<div id="main" class="container-fluid">
        <div class="row">
            <div class="col-md-3 sidebar">
                <?php $this->load->view('group/common/menu'); ?>
            </div>
            <div class="col-md-9 main">
		<h4 class="page-header text-uppercase" style="margin-top:10px">Thống kê chung</h4>
                <div class="dashboard">
                    <!-- ========================== Begin Content ============================ -->                    
               
                    <div class="table-responsive">
                       
                        <div id="panel_direct">
                            <div id="main">
                                <?php if ($this->session->userdata('sessionGroup') == 3): ?>
                                
                                    <ul class="nav nav-pills" >
                                        <li class="active"><a aria-expanded="true" href="#tab2success" data-toggle="tab">Trong ngày</a></li>
                                        <li class=""><a aria-expanded="false" href="#tab1success" data-toggle="tab">Tổng cộng</a></li>
                                    </ul>
                                
                                <?php endif; ?>
                                
                                <div class="tab-content" id="statistic" style="padding-top: 20px;">                                  
                                  
                                    <div class="tab-pane fade active in" id="tab2success">
                                        <?php if (($this->session->userdata('sessionGroup') > 3)): ?>
                                            <div class="col-lg-4">
                                                <div class="panel panel-default panel-black">                                                    
                                                    <div class="panel-body">
                                                        <p></p>
                                                        <i class="fa fa-money fa-fw fa-3x" aria-hidden="true"></i>
                                                        <span class="lead pull-right"><?php echo ($countAF) ? $countAF : '0'; ?></span>
                                                    </div>
                                                </div>
                                            </div>                                            
                                        <?php endif; ?>

                                        <?php if ($this->session->userdata('sessionGroup') == 3): ?>
                                            <div class="col-lg-4">
                                                <div class="panel panel-default panel-black">
                                                    <div class="panel-body">
                                                        <p>Số sản phẩm hết hàng</p>
                                                        <i class="fa fa-money fa-fw fa-3x" aria-hidden="true"></i>
                                                        <span class="lead pull-right"><?php echo $products; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="col-lg-4">
                                            <div class="panel panel-default panel-black">
                                                <div class="panel-body">
                                                    <p>Đơn hàng hôm nay</p>
                                                    <i class="fa fa-shopping-cart fa-fw fa-3x" aria-hidden="true"></i>
                                                    <span class="lead pull-right"><?php echo $totaldonhanghnay; ?></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="panel panel-default panel-black">
                                                <div class="panel-body">
                                                    <p>Doanh số hôm nay</p>
                                                    <i class="fa fa-money fa-fw fa-3x" aria-hidden="true"></i>
                                                    <span class="lead pull-right"><?php echo number_format($total_re, 0, ',', '.'); ?> đ</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="panel panel-default panel-black">
                                                <div class="panel-body">
                                                    <p>Doanh số hôm qua</p>
                                                    <i class="fa fa-money fa-fw fa-3x" aria-hidden="true"></i>
                                                    <span class="lead pull-right"><?php echo ($sales_yesterday) ? number_format($sales_yesterday, 0, ',', '.') : '0'; ?>
                                                        đ</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="panel panel-default panel-black">
                                                <div class="panel-body">
                                                    <p>Doanh số tháng này</p>
                                                    <i class="fa fa-money fa-fw fa-3x" aria-hidden="true"></i>
                                                    <span class="lead pull-right"><?php echo ($current_month) ? number_format($current_month, 0, ',', '.') : '0'; ?>
                                                        đ</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="panel panel-default panel-black">
                                                <div class="panel-body">
                                                    <p>Doanh số tháng trước</p>
                                                    <i class="fa fa-money fa-fw fa-3x" aria-hidden="true"></i>
                                                    <span class="lead pull-right"><?php echo ($last_month) ? number_format($last_month, 0, ',', '.') : '0'; ?>
                                                        đ</span>
                                                </div>
                                            </div>
                                        </div>

                                        <?php if ($this->session->userdata('sessionGroup') == StaffStoreUser): ?>
                                            <a href="<?php echo base_url() . 'account/statisticIncome'; ?>">
                                                <div class="col-lg-4">
                                                    <div class="panel panel-default panel-black">
                                                        <div class="panel-body">
                                                            <p>Thu nhập hiện tại</p>
                                                            <i class="fa fa-money fa-fw fa-3x" aria-hidden="true"></i>
                                                            <span class="lead pull-right"><?php echo ($current_earnings[0]->amount) ? number_format($current_earnings[0]->amount, 0, ',', '.') : '0'; ?>
                                                                đ</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>

                                        <?php endif; ?>

                                        <?php if ($this->session->userdata('sessionGroup') == StaffStoreUser ): ?>
                                            <div class="col-lg-4">
                                                <div class="panel panel-default panel-black">
                                                    <div class="panel-body">
                                                        <p>Tổng số lượng đơn hàng</p>
                                                        <i class="fa fa-shopping-cart fa-fw fa-3x" aria-hidden="true"></i>
                                                        <span class="lead pull-right"><?php echo $total_order; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4">
                                                <div class="panel panel-default panel-black">
                                                    <div class="panel-body">
                                                        <p>Tổng doanh số</p>
                                                        <i class="fa fa-archive fa-fw fa-3x" aria-hidden="true"></i>
                                                        <span class="lead pull-right"><?php echo number_format($total, 0, ',', '.'); ?> đ</span>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endif; ?>
                                        <div class="clearfix"></div>
                                    </div>



                                    <div class="tab-pane fade" id="tab1success">
                                        <div class="col-lg-4">
                                            <div class="panel panel-default panel-black">
                                                <div class="panel-body">
                                                    <p>Tổng số lượng đơn hàng</p>
                                                    <i class="fa fa-shopping-cart fa-fw fa-3x" aria-hidden="true"></i>
                                                    <span class="lead pull-right"><?php echo $total_order; ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="panel panel-default panel-black">
                                                <div class="panel-body">
                                                    <p>Tổng doanh số</p>
                                                    <i class="fa fa-archive fa-fw fa-3x" aria-hidden="true"></i>
                                                    <span class="lead pull-right"><?php echo number_format($total, 0, ',', '.'); ?> đ</span>
                                                </div>
                                            </div>
                                        </div>                                       
                                        <div class="clearfix"></div>
                                    </div>

                                    <!-- Vẽ đồ thị thống kê -->                                  
                                    <?php echo $service_charts; ?>   

                                </div>
                            </div>

                        </div>


                    </div>
                    <!-- ========================== End Content ============================ -->
                </div>
            </div>
        </div>
    </div>   
<?php $this->load->view('group/common/footer'); ?>
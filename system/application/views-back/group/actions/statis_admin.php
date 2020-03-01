<?php $this->load->view('group/common/header'); ?>
<br>
<div id="main" class="container-fluid">
    <div class="row">
        <div class="col-md-3 sidebar">
            <?php $this->load->view('group/common/menu'); ?>
        </div>
        <div class="col-md-9 main">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">Thống kê thu nhập chủ nhóm</h4>
            <div class="dashboard">
                <!-- ========================== Begin Content ============================ -->                    
                
                <?php if (count($shop_grt) > 0 && count($arr_grt) > 0) { ?>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead style="background:#eee">
                                <tr>
                                    <th>#</th>
                                    <th class="text-left">Tên gian hàng</th>
                                    <th class="text-right">Doanh số/Tháng</th>
                                    <th class="text-center">Hoa hồng chủ nhóm</th>
                                    <th class="text-right">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody style="background: white">
                                <?php
                                $i = 0;
                                foreach ($shop_grt as $keys => $items) {
                                    ?>
                                    <?php foreach ($arr_grt[$items->order_saler] as $key => $item) { ?> 
                                        <tr>
                                            <td class="text-center"><?php echo ++$i ?></td>
                                            <td class="text-left"><?php echo $item['shopname'] ?></td>
                                            <td class="text-right"><?php echo number_format($item['total']) ?> đ</td>
                                            <td class="text-center"><?php echo $item['cmss_for_admin'] ?> %</td>
                                            <td class="text-right"><strong class="text-danger"><?php echo number_format($item['doanhthu_admin']) ?> đ</strong></td>
                                        </tr>
                                    <?php 
                                    $total += $item['doanhthu_admin'];
                                    } ?>
                                <?php } ?>
                            </tbody>
                            <tfoot style="background: #eee">
                                <tr>                                    
                                    <td class="text-right" colspan="4"><strong>Tổng cộng:</strong></td>
                                    <td class="text-right"><strong class="text-danger"><?php echo number_format($total)?> đ</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>    
                <?php } else { ?>
                    <div class="alert alert-warning text-center" role="alert">Chưa có dữ liệu thống kê thu nhập chủ nhóm.</div>
                <?php } ?>
                <!-- ========================== End Content ============================ -->
            </div>
        </div>
    </div>
</div>   
<?php $this->load->view('group/common/footer'); ?>
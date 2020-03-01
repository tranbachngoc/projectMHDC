<?php $this->load->view('group/common/header'); ?>
<br>
<div id="main" class="container-fluid">
    <div class="row">
        <div class="col-md-3 sidebar">
            <?php $this->load->view('group/common/menu'); ?>
        </div>
        <div class="col-md-9 main">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">Thống kê doanh số gian hàng <?php echo isset($shop) && $shop->sho_name != '' ? $shop->sho_name : ''; ?></h4>
            <div class="dashboard">
                <!-- ========================== Begin Content ============================ -->                    

                <div class="table-responsive">

                    <table class="table table-bordered" style="min-width: 600px;">
                        <thead style="background: #eee;">
                            <tr>
                                <th width="5%">#</th>
                                <th width="50%" align="center">
                                    Thông tin người bán
                                </th>                                
                                <th width="20%" align="center">
                                    ID đơn hàng
                                </th>
                                <th width="20%" class="text-right">
                                    Doanh số
                                </th>                  
                            </tr>
                        </thead>
                        <tbody style="background: #fff;">
                            <?php if (count($dt_sc_shop_grt) > 0) { ?>
                                <?php $tong = 0; ?>
                                <?php
                                foreach ($dt_sc_shop_grt as $key => $value) {
                                    $stt++;
                                    $tong += $value->order_total_no_shipping_fee;
                                    ?>
                                    <tr>
                                        <td width="5%" height="32" class="line_account_0"><?php echo $stt; ?></td>
                                        <td width="20%" height="32" class="line_account_2">
                                            <label>Cộng tác viên: <strong><?php echo $value->usersaler; ?></strong></label>
                                            <br>
                                            <div><i class="fa fa-mobile"></i> <span><?php echo $value->mobilesaler != '' ? $value->mobilesaler : 'Chưa cập nhật'; ?></span> - <i class="fa fa-envelope-o"></i> <span><?php echo $value->emailsaler != '' ? $value->emailsaler : 'Chưa cập nhật'; ?></span> </div>
                                            <br>
                                            <div class="shop_parent active" style="font-size: 12px;color: orangered!important;"> <i>[<?php echo $value->parentsaler != '' ? 'GH: ' . $value->parentsaler : '-Chưa cập nhật-'; ?>]</i></div>
                                            <p style="font-size: 12px; color: #f57420"><i></i></p>
                                        </td>
                                        <td width="20%" height="32" class="line_account_2">
                                            <a href="/grouptrade/<?php echo (int) $this->uri->segment(2); ?>/orderdetail/<?php echo $value->id; ?>" target="_blank" title="Xem chi tiết"><u>#<?php echo $value->id; ?></u></a>
                                            <p>Ngày bán: <span><?php echo date('d-m-Y', $value->date); ?></span></p>
                                        </td>	                            
                                        <td width="10%" height="32" class=" text-right">
                                            <a href="/grouptrade/<?php echo (int) $this->uri->segment(2); ?>/orderdetail/<?php echo $value->id; ?>"><span style="color: #ff0000; font-weight: 600"><?php echo lkvUtil::formatPrice($value->order_total_no_shipping_fee, 'đ'); ?></span>
                                            </a>
                                        </td> 
                                    </tr>
                                <?php } ?>
                            <?php } else { ?>
                                <tr><div><span>Không có dữ liệu ...</span></div></tr>
                        <?php } ?>


                        <td colspan="3" class="text-right detail_list">
                            Tổng doanh thu:
                        </td>
                        <td colspan="1" class="detail_list text-right"><strong style="color: #f00"><?php echo lkvUtil::formatPrice($tong, 'đ'); ?></strong></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- ========================== End Content ============================ -->
            </div>
        </div>
    </div>
</div>   
<?php $this->load->view('group/common/footer'); ?>
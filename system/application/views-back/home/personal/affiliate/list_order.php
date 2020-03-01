<div class="row">
    <div class="col-md-4">
        <?php echo $this->load->view('home/personal/affiliate/layout/menu-left') ?>
    </div>
    <div class="col-md-8">
        <div class="tranggioithieu-right">
            <div class="alert"></div>
            <div class="item">
                <h3 class="tit">ĐƠN HÀNG ĐÃ BÁN ĐƯỢC</h3>
                <div class="list-affiliate-service">
                    <?php if(isset($services) && !empty($services)) { ?>
                        <?php $total_price_service = 0; ?>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên dịch vụ</th>
                                    <th>SL</th>
                                    <th>Đơn giá</th>
                                    <th>Nhân viên</th>
                                    <th>Ngày tháng</th>
                                    <th>Thu nhập</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($services as $iKS => $oService) { ?>
                                    <tr>
                                        <td><?=$iKS+1?></td>
                                        <td><?=$oService->name?></td>
                                        <td><?=$oService->limited?></td>
                                        <td>
                                            <span class="product_price">
                                                <?= number_format($oService->amount/$oService->limited)?>
                                            </span>
                                            <p style="font-size: 12px;  font-weight: 600" class="text-success">
                                                <i>Hoa hồng: <?= number_format($oService->affiliate_price_rate)?> đ</i>
                                            </p>
                                        </td>
                                        <td>
                                            <?=$oService->use_fullname;?>
                                            <?php if($oService->affiliate_level != 1 && $oService->user_affiliate_id != $iUserId) { ?>
                                                    <p style="font-size: 12px;  font-weight: 600" class="text-success">
                                                    <i>Level: <?=$oService->affiliate_level;?></i>
                                                </p>
                                            <?php } ?>
                                            
                                        </td>
                                        <td style="text-align:center;">
                                            <?= date("d/m/Y", strtotime($oService->payment_date));?>
                                        </td>
                                        <td class="text-right">
                                            <span class="product_price"><?= number_format($oService->affiliate_price_rate)?> đ </span>   
                                        </td>
                                    </tr>
                                    <?php $total_price_service = $total_price_service + $oService->affiliate_price_rate;?>
                                <?php } ?>
                                <tr>
                                    <td class="text-right" colspan="6"><b>Tổng thu nhập tạm tính: </b></td>
                                    <td class="text-right">
                                        <span class="product_price"><?=number_format($total_price_service)?> đ</span>
                                    </td>
                                </tr>
                            </tbody>
                            
                        </table>
                    <?php } ?>
                </div>
            </div>

        </div>

    </div>
</div>
<div id="config_price_service" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Cấu hình giá cho affiliate user</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-body-error">
          
      </div>
      <div class="modal-footer">
        <button type="button" id="edit_price_affiliate">Lưu</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
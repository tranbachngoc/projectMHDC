<div class="row">
    <div class="col-md-4">
        <?php echo $this->load->view('home/personal/affiliate/layout/menu-left') ?>
    </div>
    <div class="col-md-8">
        <div class="tranggioithieu-right">
            <div class="item">
                <h3 class="tit">DỊCH VỤ CỦA AZIBAI</h3>
                <div class="list-affiliate-service affiliate-user">
                    <?php if(isset($services) && !empty($services)) { ?>
                        <table>
                            <thead>
                                <tr>
                                    <th width="40">STT</th>
                                    <th>Tên dịch vụ</th>
                                    <th>Đơn vị</th>
                                    <th>Đơn giá</th>
                                    <th>Chiếu khấu</th>
                                    <th>Thời hạn (tháng)</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($services as $k => $sp): ?>
                                    <tr>
                                    <td><?=$k+1?></td>
                                    <td><?=$sp['name']?></td>
                                    <td><?=$sp['units'];?></td>
                                    <td>
                                        <?=number_format($sp['month_price'], 0, ',', '.');?> đ
                                    </td>
                                    <td>
                                        <?=number_format($sp['discount_rate'], 0, ',', '.');?> đ
                                    </td>
                                    <td>
                                        <?= $sp['ordering'] == 0 ? 'Không giới hạn' : $sp['ordering']; ?>
                                    </td>
                                    <td>
                                        <button data-user="<?=$id?>" data-id="<?=$sp['id'];?>" class="config-service-price" data-toggle="modal" data-target="#config_price_service">Cấu hình hoa hồng cho Affiliate</button>
                                    </td>
                                    </tr>
                                <?php endforeach; ?>
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
        <h4 class="modal-title">Cấu hình hoa hồng cho affiliate user</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" id="edit_price_affiliate">Lưu</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
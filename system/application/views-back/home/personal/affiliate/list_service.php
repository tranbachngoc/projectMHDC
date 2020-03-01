<div class="row">
    <div class="col-md-4">
        <?php echo $this->load->view('home/personal/affiliate/layout/menu-left') ?>
    </div>
    <div class="col-md-8">
        <div class="tranggioithieu-right">
            <div class="alert"></div>
            <div class="item">
                <h3 class="tit">DỊCH VỤ CỦA AZIBAI</h3>
                <div class="list-affiliate-service">
                    <?php if(isset($services) && !empty($services)) { ?>
                        <?php foreach($services as $k => $sp): ?>
                            <div class="affiliate-item">
                                <div class="affiliate-item-inner">
                                    <div class="affiliate-item-header">
                                        <div class="title"><strong><?php echo $sp['name']; ?></strong></div>
                                        <div class="register">
                                            <button class="get-link" data-url="<?=base_url()?>shop/service/detail/<?=$sp['id'].'?af_id='.$user_infomation['af_key']?>" data-id="<?php echo $sp->service_id; ?>"><i class="fa fa-sign-out"></i> Lấy link</button>
                                        </div>
                                    </div>
                                    <div class="affiliate-item-content">
                                        <div class="affiliate-item-infomation">
                                            <strong>Số lượng (đơn vị)</strong>
                                            <p><?php echo $sp['limits']." (".$sp['units'].")"; ?></p>
                                        </div>
                                        <div class="affiliate-item-infomation">
                                            <strong>Giá bán</strong>
                                            <p><?=number_format($sp['discount_price'], 0, ',', '.');?> đ</p>
                                        </div>
                                        <div class="affiliate-item-infomation">
                                            <strong>Phần trăm</strong>
                                            <p><?=number_format($sp['discount_percen'], 0, ',', '.');?> %</p>
                                        </div>
                                        
                                    </div>
                                    <?php if($user_infomation['affiliate_level'] < 3 && $user_infomation['affiliate_level'] != 0) { ?>
                                        <div class="affiliate-item-footer">
                                            <button data-id="<?=$sp['id'];?>" class="config-service-price" data-toggle="modal" data-target="#config_price_service">Cấu hình giá cho Affiliate</button>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
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
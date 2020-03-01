<div class="row">
    <div class="col-md-4">
        <?php echo $this->load->view('home/personal/affiliate/layout/menu-left') ?>
    </div>
    <div class="col-md-8">
        <div class="tranggioithieu-right">
            <div class="alert"></div>
            <div class="item">
                <h3 class="tit">DỊCH VỤ BẠN ĐÃ CHỌN</h3>
                <div class="list-affiliate-service">
                    <?php if(isset($services) && !empty($services)) { ?>
                        <?php foreach($services as $k => $sp): ?>
                            <div id="affiliate_item_<?=$sp->id?>" class="affiliate-item">
                                <div class="affiliate-item-inner">
                                    <div class="affiliate-item-header">
                                        <div class="title"><strong><?php echo $sp->name; ?></strong></div>
                                        <div class="register">
                                            <button class="get-link" data-url="<?=base_url()?>shop/service/detail/<?=$sp->service_id.'?af_id='.$user_infomation['af_key']?>" data-id="<?php echo $sp->service_id; ?>"><i class="fa fa-sign-out"></i> Lấy link</button>
                                        </div>
                                    </div>
                                    <div class="affiliate-item-content">
                                        <div class="affiliate-item-infomation">
                                            <strong>Số lượng (đơn vị)</strong>
                                            <p><?php echo $sp->limits." (".$sp->units.")"; ?></p>
                                        </div>
                                        <div class="affiliate-item-infomation">
                                            <strong>Đơn giá</strong>
                                            <p><?=number_format($sp->discount_price, 0, ',', '.');?> đ</p>
                                        </div>
                                        <div class="affiliate-item-infomation">
                                            <strong>Chiếu khấu</strong>
                                            <p><?=number_format($sp->discount_percen, 0, ',', '.');?> %</p>
                                        </div>
                                        <div class="affiliate-item-infomation">
                                            <strong>Thời hạn (tháng)</strong>
                                            <p><?= $sp->ordering == 0 ? 'Không giới hạn' : $sp->ordering; ?></p>
                                        </div>
                                    </div>
                                    <div class="affiliate-item-footer">
                                        <button class="delete-service-price" data-id="<?=$sp->id?>">Xóa Affiliate</button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php } ?>
                </div>
            </div>

        </div>

    </div>
</div>
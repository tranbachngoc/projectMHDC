<link href="/templates/shop/css/service.css" rel="stylesheet" type="text/css" />
<div class="row">
    <div class="col-md-4">
        <?php echo $this->load->view('shop/service/layout/menu-left') ?>
    </div>
    <div class="col-md-8">
        <div class="services-right">
            <div class="item">
                <h3 class="tit">DỊCH VỤ CỦA BẠN</h3>
                <div class="list-service">
                    <?php if(isset($services) && !empty($services)) { ?>
                        <?php foreach($services as $k => $sp): ?>
                            <div class="service-item">
                                <div class="service-item-inner">
                                    <div class="service-item-header">
                                        <div class="title"><strong><?php echo $sp['package']; ?></strong></div>
                                    </div>
                                    <div class="service-item-content">
                                        <div class="service-item-infomation">
                                            <strong>Số lượng (đơn vị)</strong>
                                            <p><?php echo $sp['limited']." (".$sp['unit'].")"; ?></p>
                                        </div>
                                        <div class="service-item-infomation">
                                            <strong>Đơn giá</strong>
                                            <p><?=number_format($sp['real_amount'], 0, ',', '.');?> đ</p>
                                        </div>
                                        <div class="service-item-infomation">
                                            <strong>Giá giảm</strong>
                                            <p><?=number_format($sp['amount'], 0, ',', '.');?> đ</p>
                                        </div>
                                        <div class="service-item-infomation">
                                            <strong>Thời hạn (tháng)</strong>
                                            <p><?= $sp['ordering'] == 0 ? 'Không giới hạn' : $sp->ordering; ?></p>
                                        </div>
                                        <div class="service-item-infomation">
                                            <p>Ngày đăng ký: <b>
                                                <?=date('d-m-Y H:i:s',strtotime($sp['created_date'])); ?></b>
                                            </p>
                                            
                                            <p> Ngày bắt đầu: <b>
                                                <?=($sp['begined_date'] != '' ? date('d-m-Y', strtotime($sp['begined_date'])) : '')?>
                                                    
                                                </b>
                                            </p>
                                            <p> Ngày cập nhật: <b><?=($sp['modified_date'] != '' ? date('d-m-Y H:i:s',strtotime($sp['modified_date'])) : 'chưa cập nhật')?>
                                                
                                            </b></p>
                                            
                                            <?php if($sp['ended_date']){ ?>
                                                <p> Ngày kết thúc: <b>
                                                    <?=($sp['ended_date'] != '' && $sp['ended_date'] != '0000-00-00 00:00:00' ? date('d-m-Y', strtotime($sp['ended_date'])) : '')?>
                                                    </b>
                                                </p>
                                            <?php } ?>
                                        </div>
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
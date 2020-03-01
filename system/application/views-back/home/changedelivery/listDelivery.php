<div class="col-lg-12 col-md-12 col-sm-12">
    <div id="panel_order_af" class="panel panel-default">
        <div class="panel-heading"><h4><?php echo 'Danh sách đơn hàng khiếu nại'; ?></h4></div>
        <div class="panel-body">
            <?php if(isset($listComplaintsOrders) && $listComplaintsOrders): ?>
                <!---before:list--->
                <table class="table table-condensed">
                    <thead>
                        <tr>
                            <td>Mã đơn hàng</td>
                            <td>Trạng thái</td>
                            <td>Hình thức</td>
                            <td>Email khách hàng</td>
                            <td>Cập nhập</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($listComplaintsOrders as $vals): ?>
                        <?php
                            $order_info =   $this->order_model->get('order_token','id = '.$vals->order_id);
                        ?>
                            <tr>
                                <td class="order_id"><b><a href="<?php echo base_url().'change-delivery/'.$vals->order_id.'?order_token='.$order_info->order_token; ?>">#<?php echo $vals->order_id; ?></a></b></td>
                                <td class="bk_email">
                                    <?php
                                    switch($vals->status_id){
                                        case '01':
                                            $status_id = "Chờ Shop xác nhận";
                                            break;
                                        case '02':
                                            $status_id = "Shop đã xác nhận - Upload mẫu vận chuyển";
                                            break;
                                        case '03':
                                            if($vals->type_id == 1){
                                                $status_id = "Chờ Shop đã xác nhận và tạo đơn hàng";
                                            } else {
                                                $status_id = "Chờ Shop xác nhận và hoàn tiền lại cho bạn";
                                            }
                                            break;
                                        case '04':
                                            $status_id = "Hoàn tất";
                                            break;
                                    }
                                    echo $status_id;
                                    ?>
                                </td>
                                <td class="bk_email"><?php echo ($vals->type_id == 1)?'Đổi hàng':'Trả hàng'; ?></td>
                                <td class="bk_email"><?php echo $vals->email; ?></td>
                                <td class="bk_email"><?php echo date("d-m-Y H:i:s",strtotime($vals->lastupdated)); ?></td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
                <!---end:list--->
            <?php else : ?>
                Không có dữ liệu.
            <?php endif; ?>
        </div>
    </div>
</div> <!-- col -->
<?php $this->load->view('home/common/account/header'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                Chi tiết dịch vụ trong gói
            </h4>
            <div class="table-responsive">
            <table class="table table-bordered sTable" width="100%" border="0" cellpadding="0" cellspacing="0">
                <thead>
               <tr>
                   <th>#</th>
                   <th>Dịch vụ</th>
                   <th>Trạng thái</th>
                   <th>Ghi chú</th>
               </tr>
                </thead>
                <?php  foreach ($services as $key=>$item): ?>
                    <tr>
                        <td><?php echo $key+1; ?></td>
                        <td><?php echo $item['name']; ?> (<?php echo $item['limit'] == -1 ? "Không giới hạn": $item['limit']; ?> <?php echo $item['unit']; ?>)</td>
                        <td><?php echo ($item['status'] == 1) ? "Sẵn sàng" : "Đang cài đặt"; ?></td>
                        <td><?php echo $item['note']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
                </div>
        </div>
        <!--BEGIN: RIGHT-->
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

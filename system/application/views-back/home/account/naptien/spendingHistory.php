<?php $this->load->view('home/common/account/header'); ?>
<style>
    .red_money{text-align: right;}
</style>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">
                <?php echo $this->lang->line('spending_history'); ?>
            </h4>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <?php if (count($spendingHistory) > 0) { ?>
                        <thead>
                            <tr>
                                <th width="5%" class="title_account_0 hidden-xs">STT</th>
                                <th width="15%" align="center">Số tiền (Đ)</th>
                                <th width="20%" align="center">Loại tiền (Đ)</th>
                                <th width="20%" align="center">Lý do tiêu tiền</th>
                                <th width="20%" align="center">Ngày tiêu tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($spendingHistory as $key => $vals): ?>
                            <tr>
                                <td class="order_id hidden-xs"><?php echo ++$key; ?></td>
                                <td class="bk_email red_money"><?php echo number_format($vals->amount, 0, ",", "."); ?></td>
                                <td class="order_id"><?php echo ($vals->type == 1)?$this->lang->line('real_money'):$this->lang->line('virtual_money'); ?></td>
                                <td class="order_id"><?php echo $vals->description; ?></td>
                                <td class="bk_email"><?php echo date("d-m-Y H:i:s", strtotime($vals->created_date)); ?></td>
                            </tr>
                        <?php endforeach;?>
                        </tbody>
                    <?php } else { ?>
                        <tr>
                            <td class="text-center">
                                Không có dữ liệu!
                            </td>
                        </tr>
                    <?php } ?>
                </table>                
            </div>
                
                <div style="text-align: right">
                    <?php if($money[0]->amount): ?>
                        Tổng tiền thật: <span class="red_money"><?php echo number_format($money[0]->amount, 0, ",", "."); ?> đ</span>
                    <?php endif; ?>
                    <?php if($point[0]->amount): ?>
                        Tổng tiền ảo: <span class="red_money"> <?php echo number_format($point[0]->amount, 0, ",", "."); ?> đ</span>
                    <?php endif; ?>
                </div>
                <div class="text-center">
                    <?php 
                        if(isset($linkPage) && $linkPage){
                            echo $linkPage;
                        }
                    ?>
                </div>
            <br>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
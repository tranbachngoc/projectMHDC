<?php $this->load->view('home/common/account/header'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
                <?php echo $this->lang->line('history_recharge'); ?>
            </h4>

            <div style="background-color: white">
                <div id="history_recharge">
                                    
                    <ul class="nav nav-pills">
                        <li class="active"> 
                            <a href="<?php echo base_url().'account/historyRecharge'; ?>"> 
                                <span><i class="fa fa-university"></i></span> 
                                <span class="hidden-xs">CHUYỂN KHOẢN NGÂN HÀNG</span>
                            </a> 
                        </li>
                        <li class=""> 
                            <a href="<?php echo base_url().'account/historyRechargeNL'; ?>"> 
                                <span><i class="fa fa-laptop"></i></span> 
                                <span class="hidden-xs">NẠP TIỀN ONLINE</span> 
                            </a> 
                        </li>
                    </ul>
                    <br>
                    <div class="tab-content">
                        <div class="tab-pane active" id="_banking">
                                <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <?php if (count($listHistoryRecharge) > 0) { ?>
                                        <thead>
                                            <tr>
                                                <th width="5%" class="title_account_0 hidden-xs">STT</th>
                                                <th width="20%" align="center">Số tiền (Đ)</th>
                                                <th width="20%" align="center">Ngân hàng</th>
                                                <th width="20%" align="center">Trạng thái</th>
                                                <th width="20%" align="center" class="hidden-xs">Ngày gởi yêu cầu</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $bank = json_decode(bankpayment); ?>
                                            <?php foreach ($listHistoryRecharge as $key => $vals): ?>
                                                <tr>
                                                    <td class="bk_email hidden-xs"><?php echo ++$key; ?></td>
                                                    <td class="bk_email red_money"><?php echo number_format($vals->amount, 0, ",", "."); ?></td>
                                                    <td class="bk_email"><?php echo $bank[$vals->bank_id]->bank_name; ?></td>
                                                    <td class="bk_email"><?php echo ($vals->status_id == 0) ? "Chưa xác nhận" : "<span style='font-weight:bold'>Đã xác nhận</span>"; ?></td>
                                                    <td class="bk_email hidden-xs"><?php echo date("d-m-Y H:i:s", strtotime($vals->lastupdated)); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    <?php } else { ?>
                                        <tr>
                                            <td class="text-center">
                                                Không có dữ liệu!
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                                <?php if(isset($linkPage) && $linkPage){ echo $linkPage;} ?>
                        </div>
                        <div class="tab-pane" id="_nganluong">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
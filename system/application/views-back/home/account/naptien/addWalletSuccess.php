<?php $this->load->view('home/common/account/header'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>templates/home/css/wallet.css" />
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            
	    <div id="panel_order_af" class="panel panel-default">
                <div class="panel-heading"><h4>Thông tin chuyển khoản</h4></div>
                <div class="panel-body">
                        <div class="container" id="pageContainer">
                        <?php $bank = json_decode(bankpayment); ?>
                        <div>
                            <h2 class="_t1">
                                Thực hiện chuyển khoản tại Ngân hàng <?php echo $bank[$walletlog->bank_id]->bank_name; ?></h2>
                        </div>
                        <div id="btn_print" class="btn-cancel"><img onclick="printContent('pageContainer')" src="<?php echo base_url()?>templates/home/images/payment/print-icon.png"> in hướng dẫn</div>
                        <div class="infomation_col" style="width: 100%;">
                            <h3 class="_t2">Bước 1: Thực hiện giao dịch tại quầy</h3>
                            <div>Tại quầy giao dịch của <?php echo $bank[$walletlog->bank_id]->bank_name; ?>, Quý khách thực hiện giao dịch với nội dung như sau:</div>
                            <div class="clearfix"></div>
                            <dl class="dl-horizontal _atm">
                                <dt>Số tiền</dt>
                                <dd style="color: #0d81b1; font-weight: bold;"><?php echo number_format($walletlog->amount, 0, ".", ","); ?> Đ</dd>
                                <dt>Nội dung chuyển tiền</dt>
                                <dd style="color: #0d81b1; font-weight: bold;">AZIBAI <?php echo $walletlog->id; ?></dd>
                            </dl>
                            <div>Quý khách chuyển khoản đến 1 trong số những ngân hàng Azibai bên dưới</div>
                            <div class="clearfix"></div>
                            <div class="tbl">
                                <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th width="30%" class="title_account_0">Ngân hàng</th>
                                            <th width="20%" align="center">Chủ tài khoản</th>
                                            <th width="20%" align="center">Số tài khoản</th>
                                            <th width="20%" align="center">Chi nhánh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php foreach ($bank_info as $vals): ?>
                                                <tr>
                                                    <td><?php echo $vals->bank_name; ?></td>
                                                    <td><?php echo $vals->account_name; ?></td>
                                                    <td><?php echo $vals->account_number; ?></td>
                                                    <td><?php echo $vals->aff; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <h3 class="_t2">Bước 2: Thông báo cho <?php echo settingTitle; ?></h3>
                            <div class="_bottom">Sau khi chuyển khoản, Quý khách gọi cho AZIBAI thông qua đường dây nóng <?php echo settingPhone; ?></div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>

<script type="text/javascript">
    function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}
</script>
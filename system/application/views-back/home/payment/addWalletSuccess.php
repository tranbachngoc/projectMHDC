<?php $this->load->view('home/common/account/header'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 hidden-md hidden-sm hidden-xs" style="background:#fff; position:fixed; top:0; bottom:0; z-index:100">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-10 col-lg-offset-2 " style="min-height:528px">
            <div class="breadcrumbs hidden-xs">
                <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                <span><?php echo 'Thông tin chuyển khoản'; ?></span>
            </div>
            <link type="text/css" rel="stylesheet" href="<?php echo base_url() ?>templates/home/css/wallet.css" />
            <div class="wraper container-fluid">
                
                <div class="container" id="pageContainer">
                    <style>
                    


table {
	background: #f5f5f5;
	border-collapse: separate;
	box-shadow: inset 0 1px 0 #fff;
	font-size: 12px;
	line-height: 24px;
	margin: 30px auto;
	text-align: left;
	width: 85% !important;
}	

th {
	background: linear-gradient(#777, #444);
	border-left: 1px solid #555;
	border-right: 1px solid #777;
	border-top: 1px solid #555;
	border-bottom: 1px solid #333;
	box-shadow: inset 0 1px 0 #999;
	color: #fff;
  font-weight: bold;
	padding: 10px 15px;
	position: relative;
	text-shadow: 0 1px 0 #000;	
}

th:after {
	background: linear-gradient(rgba(255,255,255,0), rgba(255,255,255,.08));
	content: '';
	display: block;
	height: 25%;
	left: 0;
	margin: 1px 0 0 0;
	position: absolute;
	top: 25%;
	width: 100%;
}

th:first-child {
	border-left: 1px solid #777;	
	box-shadow: inset 1px 1px 0 #999;
}

th:last-child {
	box-shadow: inset -1px 1px 0 #999;
}

td {
	border-right: 1px solid #fff;
	border-left: 1px solid #e8e8e8;
	border-top: 1px solid #fff;
	border-bottom: 1px solid #e8e8e8;
	padding: 10px 15px;
	position: relative;
	transition: all 300ms;
}

.infomation_col ._atm dt{
    float: left;
    width: 160px;
    overflow: hidden;
    clear: left;
    text-overflow: ellipsis;
    white-space: nowrap;
}
#btn_print img{cursor: pointer;}    
                    </style>
                    <?php $bank = json_decode(bankpayment); ?>
                    <div>
                        <h2 class="_t1">
                            Thực hiện chuyển khoản tại quầy giao dịch của Ngân hàng <?php echo $bank[$walletlog->bank_id]->bank_name; ?></h2>
                    </div>
                    <div id="btn_print" class="btn-cancel"><img onclick="printContent('pageContainer')" src="https://www.baokim.vn/thanh-toan/images/print-icon.png"> in hướng dẫn</div>
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
                        <div id="table" class="table-editable">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Ngân hàng</th>
                                        <th>Chủ tài khoản</th>
                                        <th>Số tài khoản</th>
                                        <th>Chi nhánh</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($bank_info as $vals): ?>
                                        <tr>
                                            <td contenteditable="true"><?php echo $vals->bank_name; ?></td>
                                            <td contenteditable="true"><?php echo $vals->account_name; ?></td>
                                            <td contenteditable="true"><?php echo $vals->account_number; ?></td>
                                            <td contenteditable="true"><?php echo $vals->aff; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <h3 class="_t2">Bước 2: Thông báo cho <?php echo settingTitle; ?></h3>
                        <div>Sau khi chuyển khoản, Quý khách gọi cho AZIBAI thông qua đường dây nóng <?php echo settingPhone; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function printContent(el){
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById(el).innerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}
</script>


<?php $this->load->view('home/common/footer'); ?>
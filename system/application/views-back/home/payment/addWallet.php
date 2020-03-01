<?php $this->load->view('home/common/account/header'); ?>

<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>templates/home/css/wallet.css" />

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 hidden-md hidden-sm hidden-xs" style="background:#fff; position:fixed; top:0; bottom:0; z-index:100">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-10 col-lg-offset-2 " style="min-height:528px">
            <div class="breadcrumbs hidden-xs">
                <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                <span>Nạp tiền</span>
            </div>

            <div class="wraper container-fluid">
                <div class="page-title"> 
                    <h3 class="_title">NẠP TIỀN VÀO AZIBAI.COM</h3> 
                </div>

                <div class="add_monney">
                    <div class="fl">

                        <div class="add_money_method">
                            <div class="title blue">
                                <div>Nạp tiền sử dụng dịch vụ</div>
                            </div>
                            <div class="content">
                                <ul id="add_money_method_listing" class="add_money_method_listing">
                                    <li class="payment_method level_0" idata="6">
                                        <div>
                                            <span class="method_name">
                                            <input type="radio" name="payment_method" id="payment_method_6" onclick="showPaymentMethodDetail(6);">
                                            <label for="payment_method_6">Bằng ví điện tử <b>Ngân Lượng</b></label>&nbsp;
                                                <a target="_blank" class="payment_help simple_tip" content="Xem hướng dẫn nạp tiền" href="##########">&nbsp; &nbsp; &nbsp;</a>
                                            </span>
                                            <span class="icon_arrow"></span>
                                        </div>
                                    </li>
                                    <li class="payment_method level_0" idata="11">
                                        <div>
                                            <span class="method_name">
                                                <input type="radio" name="parent_method_11" id="parent_method_11" onclick="showPaymentMethodDetail(5);">
                                                <label for="parent_method_11">Bằng <b>Tài khoản ngân hàng</b></label>
                                                <a target="_blank" class="payment_help simple_tip" content="Xem hướng dẫn nạp tiền" href="##########">&nbsp; &nbsp; &nbsp;</a>
                                            </span>
                                            <span class="icon_arrow"></span>
                                        </div>
                                    </li>
                                    </ul>
                            </div>
                        </div>
                        </div>
                    <div class="fl">
                        <div class="add_money_detail" style="">
                            <div id="add_money_detail">
                                
                                </div>
                        </div></div>

                    <div class="clear"></div>
                </div>


            </div>

        </div>
    </div>
</div>
<script>
    
// Hàm thực hiện show thông tin cụ thể của 1 phương thức
function showPaymentMethodDetail(addType){
    var obLoading= '<div class="loading"></div>';
    var obMethodDetail= $("#add_money_detail");

    obMethodDetail.html(obLoading);
    $.ajax({
        url: '<?php echo base_url();?>payment/loadAddWallet?addType=' + addType,
        success: function(data) {
            if(data != ""){
               obMethodDetail.html(data);
            }
        }
    });
}

// Xử lý khi click vào menu level_0
$("#add_money_method_listing li.level_0").click(function(){
        // Ẩn toàn bộ menu cấp con
        $("#add_money_method_listing li.level_1").hide();

        $("#add_money_method_listing li").removeClass("current");
        $(this).addClass("current");

        // Uncheck tất cả menu khác
        $("#add_money_method_listing li.level_0").not(this).find("input").prop('checked', false);
        $(this).find("input").prop('checked', true);

        // Show cấp con của menu hiện tại nếu có
        iData= $(this).attr("iData");
        if($(".child_payment_method_" + iData).length > 0){
            $(".child_payment_method_" + iData).show();
        }else{
            showPaymentMethodDetail(iData);
        }

});

$(function(){
    $("#add_money_method_listing li:first").click();
});
</script>

<?php $this->load->view('home/common/footer'); ?>
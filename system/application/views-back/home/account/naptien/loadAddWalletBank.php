<form name="frmWallet"  method="post" id="frmWallet" class="form-inline" role="form" action="<?php echo base_url().'account/addWalletSubmit'?>">
    <div class="payment_method_detail_list payment_bank_card">
        <div align="center" style="padding: 5px 0px;"><i class="red">(Chọn ngân hàng cần nạp)</i></div>        
        <?php foreach(json_decode(bankpayment) as $key => $vals): ?>
            <div class="block fl">
                <div class="payment_method">
                    <div class="picture">
                        <table cellpadding="0" cellspacing="0">
                            <tr>
                                <td align="center">
                                    <label for="bank_<?php echo $key; ?>">
                                        <img title="<?php echo $vals->bank_name; ?>" alt="<?php echo $vals->bank_name; ?>" src="<?php echo base_url(); ?>templates/home/images/payment/bank/<?php echo $vals->bank_icon; ?>" />
                                    </label>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <input required="required" type="radio" name="iBank" id="bank_<?php echo $key; ?>" value="<?php echo $key; ?>" />
                </div>
            </div>
        <?php endforeach;?>
        <div class="clearfix"></div>
    </div>
    
    <div class="payment_method_detail_information form-group clearfix">
        <div class="payment_info" id="payment_info_bank_card">
            <input required="required" class="form-control" id="amount_fake" autocomplete="off" placeholder="Nhập số tiền cần nạp" type="text">
            <input type="hidden" id="amount" name="amount">
            <input id="btn_naptien" type="submit" class="btn btn-azibai" value="Nạp tiền" />
            <span id="loading"></span>
        </div>
    </div>
    
</form>
<script src="<?php echo base_url().'templates/home/js/autoNumeric.js';?>"></script>
<script type="text/javascript">
    
$('form').submit(function() {
    var n = $(".payment_bank_card input:checked").length;
    if(isNaN(n) || n <= 0){
        alert("Vui lòng chọn thẻ để thanh toán");
        return false;
    }
    $('#amount_fake').on('autocompletechange change', function () {
        var amountval = parseInt(this.value.replace(/[,]+/g,""));
        $('#amount').val(amountval);
    }).change();

    if($("#amount").val() == "" && $("#amount").val() == ""){
        alert("Vui lòng nhập số tiền cần nạp!");
        return false;
    }
    
    if($("#amount").val() < 50000){
        alert("Số tiền phải trên 50.000 VNĐ!");
        return false;
    }
    
    $(this).find("input[type='submit']").prop('disabled',true);
});
    
    
$('#amount_fake').autoNumeric('init',{aSign:'',mDec:0, pSign:'s' });
$("#amount_fake").keyup(function() {
    document.getElementById("amount").value = UnFormatNumber($('#amount_fake').val());
});

function checkChargeNL(){
    alert($('#amount_fake').val());
    $('#amount_fake').val( UnFormatNumber($('#amount_fake').val()));
    if($('#amount_fake').val() == ''){
        alert("Vui lòng nhập số tiền cần nạp!");
        return false;
    }else{
        return true;
    }
}


function UnFormatNumber(x) {
    if (typeof x === "undefined") {
        return '';
    } else {
    return x.toString().replace(/,|VNĐ|\s/g, "");
    }
};
</script>
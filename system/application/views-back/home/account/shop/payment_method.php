<?php $this->load->view('home/common/account/header'); ?>
<div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<script language="javascript">
function checkbox(id, object){
	if(document.getElementById(id).checked == true){
		document.getElementById(object).style.display = 'inline';
	}
	else{
		document.getElementById(object).style.display = 'none';
	}
}
</script>
<!--BEGIN: RIGHT-->
<div class="col-lg-9 col-md-9 col-sm-8">
<form action="<?php echo base_url(); ?>account/shop/save_payment_method" method="post">
<table style="width:1000px; margin:auto" cellspacing="0" cellpadding="4" class="form_text table table-bordered">
    <tbody>
      <tr>
        <td align="center" colspan="2" class="text_link_bold">Các phương thức thanh toán</td>
      </tr>
      <tr>
        <td width="50%" valign="top" nowrap="nowrap"><div>
            <input <?php echo ($payment_method->info_baokim)? "checked=\"checked\"": '';?> type="checkbox" onclick="checkbox('pm_type_id1', 'div_pm_type1')" value="1" name="payment_type" id="pm_type_id1">
            <label style="font-weight: bold;" for="pm_type_id1">Thanh toán qua Cổng Thanh Toán Bảo Kim <img align="absmiddle" src="<?php echo base_url(); ?>templates/home/images/baokim_icon.gif"></label>
          </div>
          <div class="<?php echo ($payment_method->info_baokim)? '' : 'none'?>" id="div_pm_type1">
            <div style="margin: 3px 0px;">
              <div style="margin-bottom: 3px;"><span class="form_asterisk">*</span> Email tài khoản đăng ký trên Baokim.vn</div>
                 
              <input type="text" style="width: 200px;" value="<?php echo $payment_method->info_baokim ?>" name="info_baokim" class="form_control">
            </div>
            <div><img src="<?php echo base_url(); ?>templates/home/images/baokim_bankcard.gif"></div>
          </div></td>
        <td width="50%" valign="top" nowrap="nowrap"><div>
            <input <?php echo ($payment_method->info_cod)? "checked=\"checked\"": '';?> type="checkbox" onclick="checkbox('pm_type_id2', 'div_pm_type2')" value="1" name="pm_type_id1" id="pm_type_id2">
            <label for="pm_type_id2">Thanh toán khi nhận hàng</label>
          </div>
          <div class="<?php echo ($payment_method->info_cod)? '' : 'none'?>" id="div_pm_type2">
            <textarea style="width: 250px; height: 100px;" name="info_cod" class="form_control"><?php echo $payment_method->info_cod ?></textarea>
          </div></td>
      </tr>
      <tr>
        <td width="50%" valign="top" nowrap="nowrap"><div>
            <input <?php echo ($payment_method->info_nganluong)? "checked=\"checked\"": '';?> type="checkbox" onclick="checkbox('pm_type_id3', 'div_pm_type3')" value="2" name="pm_type_id2" id="pm_type_id3">
            <label for="pm_type_id3">Thanh toán qua Cổng Thanh Toán Ngân Lượng</label>
          </div>
          <div class="<?php echo ($payment_method->info_nganluong)? '' : 'none'?>" id="div_pm_type3">
            <input type="text" style="width: 200px;" value="<?php echo $payment_method->info_nganluong ?>" name="info_nganluong" class="form_control">
          </div></td>
        <td width="50%" valign="top" nowrap="nowrap"><div>
            <input <?php echo ($payment_method->info_bank)? "checked=\"checked\"": '';?> type="checkbox" onclick="checkbox('pm_type_id4', 'div_pm_type4')" value="3" name="pm_type_id3" id="pm_type_id4">
            <label for="pm_type_id4">Chuyển khoản qua Ngân hàng</label>
          </div>
          <div class="<?php echo ($payment_method->info_bank)? '' : 'none'?>" id="div_pm_type4">
            <textarea style="width: 250px; height: 100px;" name="info_bank" class="form_control"><?php echo $payment_method->info_bank ?></textarea>
          </div></td>
      </tr>
      
      <tr>
        <td width="50%" valign="top" nowrap="nowrap"><div>
            <input <?php echo ($payment_method->info_cash)? "checked=\"checked\"": '';?> type="checkbox" onclick="checkbox('pm_type_id5', 'div_pm_type5')" value="5" name="pm_type_id5" id="pm_type_id5">
            <label for="pm_type_id5">Thanh toán bằng tiền mặt</label>
          </div>
          <div class="<?php echo ($payment_method->info_cash)? '' : 'none'?>" id="div_pm_type5">
            <textarea style="width: 250px; height: 100px;" name="info_cash" class="form_control"><?php echo $payment_method->info_cash ?></textarea>
          </div></td>
        <td width="50%" valign="top" nowrap="nowrap"><div>
            <input <?php echo ($payment_method->info_wu)? "checked=\"checked\"": '';?> type="checkbox" onclick="checkbox('pm_type_id6', 'div_pm_type6')" value="6" name="pm_type_id6" id="pm_type_id6">
            <label for="pm_type_id6">Chuyển tiền Western Union</label>
          </div>
          <div class="<?php echo ($payment_method->info_wu)? '' : 'none'?>" id="div_pm_type6">
            <textarea style="width: 250px; height: 100px;" name="info_wu" class="form_control"><?php echo $payment_method->info_wu ?></textarea>
          </div></td>
      </tr>
      
      <tr>
        <td width="50%" valign="top" nowrap="nowrap"><div>
            <input <?php echo ($payment_method->info_po)? "checked=\"checked\"": '';?> type="checkbox" onclick="checkbox('pm_type_id7', 'div_pm_type7')" value="7" name="pm_type_id7" id="pm_type_id7">
            <label for="pm_type_id7">Chuyển qua đường bưu điện</label>
          </div>
          <div class="<?php echo ($payment_method->info_po)? '' : 'none'?>" id="div_pm_type7">
            <textarea style="width: 250px; height: 100px;" name="info_po" class="form_control"><?php echo $payment_method->info_po ?></textarea>
          </div></td>
        <td width="50%" valign="top" nowrap="nowrap"></td>
      </tr>            
      
    </tbody>
  </table>
  <input type="submit" value="Cập nhật"  />
</form>
</div>
        </div>
    </div>
<!--END: RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

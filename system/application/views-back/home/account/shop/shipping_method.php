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
<form action="<?php echo base_url(); ?>account/shop/save_shipping_method" method="post">
<table style="width:1000px; margin:auto" cellspacing="0" cellpadding="4" class="form_text table table-bordered">
    <tbody>
      <tr>
        <td align="center" colspan="2" class="text_link_bold">Các phương thức vận chuyển</td>
      </tr>
      <tr>
        <td width="50%" valign="top" nowrap="nowrap"><div>
            <input <?php echo ($shipping_method->to_receive)? "checked=\"checked\"": '';?> type="checkbox" onclick="checkbox('pm_type_id1', 'div_pm_type1')" value="1" name="shipping_type" id="pm_type_id1">
            <label for="pm_type_id1">Đến địa chỉ người nhận </label>
            </div>
          <div class="<?php echo ($shipping_method->to_receive)? '' : 'none'?>" id="div_pm_type1">
			<textarea style="width: 250px; height: 100px;" name="to_receive" class="form_control"><?php echo $shipping_method->to_receive ?></textarea>
          </div></td>
        <td width="50%" valign="top" nowrap="nowrap"><div>
            <input <?php echo ($shipping_method->to_po)? "checked=\"checked\"": '';?> type="checkbox" onclick="checkbox('pm_type_id2', 'div_pm_type2')" value="2" name="shipping_type" id="pm_type_id2">
            <label for="pm_type_id2">Qua bưu điện </label>
            </div>
          <div class="<?php echo ($shipping_method->to_po)? '' : 'none'?>" id="div_pm_type2">
			<textarea style="width: 250px; height: 100px;" name="to_po" class="form_control"><?php echo $shipping_method->to_po ?></textarea>
          </div></td>
      </tr>
     <tr>
        <td width="50%" valign="top" nowrap="nowrap"><div>
            <input <?php echo ($shipping_method->to_saler)? "checked=\"checked\"": '';?> type="checkbox" onclick="checkbox('pm_type_id3', 'div_pm_type3')" value="1" name="shipping_type" id="pm_type_id3">
            <label for="pm_type_id3">Khách đến nhận hàng </label>
            </div>
          <div class="<?php echo ($shipping_method->to_saler)? '' : 'none'?>" id="div_pm_type3">
			<textarea style="width: 250px; height: 100px;" name="to_saler" class="form_control"><?php echo $shipping_method->to_saler ?></textarea>
          </div></td>
        <td width="50%" valign="top" nowrap="nowrap"><div>
            <input <?php echo ($shipping_method->to_other)? "checked=\"checked\"": '';?> type="checkbox" onclick="checkbox('pm_type_id4', 'div_pm_type4')" value="2" name="shipping_type" id="pm_type_id4">
            <label for="pm_type_id4">Hình thức khác</label>
            </div>
          <div class="<?php echo ($shipping_method->to_other)? '' : 'none'?>" id="div_pm_type4">
			<textarea style="width: 250px; height: 100px;" name="to_other" class="form_control"><?php echo $shipping_method->to_other ?></textarea>
          </div></td>
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

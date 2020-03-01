<?php $this->load->view('home/common/account/header'); ?>
<div class="container">
	<div class="row">
<?php $this->load->view('home/common/left'); ?>
<script>
jQuery(document).ready(function(){
	var value = parseFloat(jQuery('#select_cost').val());
	var bk_fee = parseFloat(value * 0.01);
	var total_fee = value + bk_fee;
	jQuery('#bk_fee').html(number_format(bk_fee, 0, ',','.'));
	jQuery('#total_fee').html(number_format(total_fee, 0, ',','.'));
	jQuery('#total_amount').val(total_fee);	
});
</script>
<!--BEGIN: RIGHT-->
<div class="<?php echo ($this->session->userdata('sessionGroup') == AffiliateStoreUser) ? 'col-md-12' : 'col-md-9' ?> col-xs-12">
<td valign="top">
<div class="add_money_content">
<div class="text_header">
		<span class="title">Nạp tiền</span>
		<span>vào tài khoản thông qua cổng thanh toán sohapay.com</span>
</div>

<form method="post" action="<?php echo base_url(); ?>naptien/submit_sohapay/">
<div class="form-tab">
	<ul>
		    <li class="selected">
	        <div class="number left">
	        01    
	        </div>
	        <div class="tab-label">
	       Nhập Số tiền	        </div>
	    </li>
		    <li class="">
	        <div class="number left">
	        02    
	        </div>
	        <div class="tab-label">
	       Xử lý	        </div>
	    </li>
		    <li class="">
	        <div class="number left">
	        03    
	        </div>
	        <div class="tab-label">
	       Hoàn thành	        </div>
	    </li>
		</ul>	
	<div class="clear"></div>	
</div>
<div class="form-content">
<div>
<table>
<tbody>
<tr>
<td align="right">Chọn số tiền cần nạp:
</td>
<td><select id="select_cost" onchange="select_price()" >
<option value="" selected="selected">Chọn giá</option>
<option value="10000">10.000 VND</option>
<option value="20000">20.000 VND</option>
<option value="30000">30.000 VND</option>
<option value="40000">40.000 VND</option>
<option value="50000">50.000 VND</option>
<option value="100000">100.000 VND</option>
<option value="200000">200.000 VND</option>
<option value="500000">500.000 VND</option>
<option value="1000000">1000.000 VND</option>
</select></td>
</tr>
<tr>
<td align="right">Chi phí (1%): </td><td><strong id="bk_fee">0</strong> VND</td></tr>
<tr>
<td align="right">Tông số tiền cần thanh toán: </td><td style="color:#FF0000"><strong id="total_fee">0</strong> VND</td></tr>
<tr><td align="right"><input type="submit" value="Thanh toán"/></td><td></td></tr>
</tbody>
</table>
</div>
</div>
<div class="form-bottom"></div>
<input type="hidden" value="" name="total_amount" id="total_amount" />
</form>
</div></td>
</tr>

</table>
</td>
	</div>
		</div>
	</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

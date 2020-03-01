
<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>

<!--BEGIN: RIGHT-->

<td width="width:100%" valign="top">
<div class="add_money_content">
<div class="text_header">
		<span class="title">Thanh toán</span>
		<span> thành công thông qua cổng thanh toán Bao Kim</span>
</div>

<form method="post" action="<?php echo base_url(); ?>account/process_baokim/">
<div class="form-tab">
	<ul>
		    <li class="">
	        <div class="number left">
	        01    
	        </div>
	        <div class="tab-label">
	       Tạo giỏ hàng	        </div>
	    </li>
		    <li class="">
	        <div class="number left">
	        02    
	        </div>
	        <div class="tab-label">
	       Xử lý	        </div>
	    </li>
		    <li class="selected">
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
<h2> Chi tiết đơn hàng</h2>
<table cellspacing="0" class="" width="100%" border="0">
	<thead>
  <tr>
    <th class="line_showcart_0">STT</td>
    <th class="line_showcart_1">Tên sản phẩm</td>
    <th class="line_showcart_2">Giá bán</td>
    <th class="line_showcart_3">Số lượng</td>
    <th class="line_showcart_4">Thành tiền</td>
  </tr>
  </thead>
  <?php 
  $i = 0;
  $total =0;
  foreach($list_product as $product):
		if($product->pro_saleoff){
			switch($product->pro_type_saleoff){
				case 1:
					$total_amount = (float)$product->pro_cost - (float)$product->pro_cost * (float) $product->pro_saleoff_value /100;
					break;
				case 2:
					$total_amount = (float)$product->pro_cost - (float) $product->pro_saleoff_value ;
					break;					
			}			
		}  	
		$total += $total_amount * $product->shc_quantity;
  ?>
  <tr>
    <td class="line_showcart_0"><?php echo $i++;?></td>
    <td class="line_showcart_1"><?php echo $product->pro_name;?></td>
    <td class="line_showcart_2"><?php echo number_format($total_amount,0,'.',',');?> VND</td>
    <td class="line_showcart_3"><?php echo $product->shc_quantity;?></td>
    <td class="line_showcart_4"><?php echo number_format($total_amount * $product->shc_quantity,0,'.',',');?> VND</td>
  </tr>
  <?php endforeach;?>
  <tr>
  	<td colspan="3"></td>
  	<td align="center">Tổng</td>
  	<td class="sum_bill" align="center"><?php echo number_format($total,0,'.',',') ?> VND</td>    
  </tr>
</table>
<div class="order_user">
<h3>Thông tin người đặt hàng</h3>
<table cellspacing="0" cellpadding="0" align="center" class="form_table_send">
        <tbody>
          <tr>
            <td width="122px">Tên người đặt hàng :</td>
            <td><?php echo $user->use_fullname; ?></td>
          </tr>
          <tr>
            <td>Địa chỉ :</td>
            <td><?php echo $user->use_address; ?></td>
          </tr>
          <tr>
            <td>Email :</td>
            <td><?php echo $user->use_email; ?></td>
          </tr>
          <tr>
            <td>Điện thoại :</td>
            <td><?php echo $user->use_phone; ?></td>
          </tr>
          <tr>
            <td>Di động :</td>
            <td><?php echo $user->use_mobile; ?></td>
          </tr>
          <tr>
            <td>Fax :</td>
            <td></td>
          </tr>
          <tr>
            <td>Ghi chú :</td>
            <td></td>
          </tr>
        </tbody>
      </table>

</div>
<div class="ship_user">
<?php $user_ship = reset($list_product); ?>
<h3>Thông tin người nhận hàng</h3>
<table cellspacing="0" cellpadding="0" align="center" class="form_table_send">
        <tbody>
          <tr>
            <td width="122px">Tên người đặt hàng :</td>
            <td><?php echo $user_ship->ord_sname; ?></td>
          </tr>
          <tr>
            <td>Địa chỉ :</td>
            <td><?php echo $user_ship->ord_saddress ; ?></td>
          </tr>
          <tr>
            <td>Email :</td>
            <td><?php echo $user_ship->ord_semail; ?></td>
          </tr>
          <tr>
            <td>Điện thoại :</td>
            <td><?php echo $user_ship->ord_sphone; ?></td>
          </tr>
          <tr>
            <td>Di động :</td>
            <td><?php echo $user_ship->ord_smobile 	; ?></td>
          </tr>
          <tr>
            <td>Fax :</td>
            <td><?php echo $user_ship->ord_sfax; ?></td>
          </tr>
          <tr>
            <td>Ghi chú :</td>
            <td></td>
          </tr>
        </tbody>
      </table>
</div>
<div style="clear:both"></div>
<div>
<div style="width:33%; float:left; border-top:none; margin-left:0; padding:0">
<h3>Thông tin thanh toán</h3>
<?php
$payment_method = $user_ship->payment_method;
if($payment_method != 'info_baokim' && $payment_method != 'info_nganluong'){
		$payment = "\$user_ship->$payment_method";
		eval("\$info = \"$payment\";");
} ?>
<p><?php echo $this->lang->line("title".$user_ship->payment_method); ?></p>
<p>
<i><?php echo nl2br ($info) ?></i>
</p>
</div>
<div style="width:33%; float:left">
<h3>Thông tin vận chuyển</h3>
<?php 
		$shipping_method = $user_ship->shipping_method;
		$shipping = "\$user_ship->$shipping_method";
		eval("\$info = \"$shipping\";");
?>
<p><?php echo $this->lang->line("title".$user_ship->shipping_method); ?></p>
<p>
<i><?php echo nl2br ($info) ?></i>
</p>
</div>
<div style="width:33%; float:left">
<h3>Thông tin thêm</h3>
<p>
<?php echo nl2br($user_ship->ord_otherinfo)?>
</p>
<span>Thời gian nhận hàng: </span><?php echo date("h:i d/m/Y",$user_ship->ord_time_receive); ?>
</div>
<div style="clear:both"></div>
</div>
<ul>
<li><a href="<?php echo base_url()?>account/order">Quay về danh sách đơn đặt hàng</a></li>
</ul> 
</div>
</div>
<div class="form-bottom"></div>

</form>
</div></td>

<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

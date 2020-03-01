
<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>

<!--BEGIN: RIGHT-->

<div class="add_money_content col-lg-9">
  <div class="tile_modules tile_modules_blue row">
    Hoàn tất đơn hàng
  </div>
<form method="post" action="<?php echo base_url(); ?>account/process_baokim/">
<!--<div class="form-tab">-->
<!--  <div class="progress">-->
<!--    <div class="progress-bar progress-bar-" style="width: 35%">-->
<!--      <span class="badge">01</span> Tạo giỏ hàng-->
<!--    </div>-->
<!--    <div class="progress-bar progress-bar-warning progress-bar-striped" style="width:35%">-->
<!--      <span class="badge">02</span> Xử lý-->
<!--    </div>-->
<!--    <div class="progress-bar progress-bar-success" style="width:30%">-->
<!--      <span class="badge">03</span> Hoàn thành-->
<!--    </div>-->
<!--  </div>-->
<!--</div>-->
<table cellspacing="0" class="table table-bordered" width="100%" border="0">
	<thead>
  <tr>
    <th class="line_showcart_0">STT</th>
    <th class="line_showcart_1">Tên sản phẩm</th>
    <th class="line_showcart_2 text-right">Giá bán</th>
    <th class="line_showcart_3">Số lượng</th>
    <th class="line_showcart_4 text-right">Thành tiền</th>
  </tr>
  </thead>
  <?php 
  $i = 1;
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
		$total += $product->pro_price * $product->shc_quantity;
  ?>
  <tr>
    <td class="line_showcart_0"><?php echo $i++;?></td>
    <td class="line_showcart_1">
      <a class="menu_1" target="_blank" href="<?php echo base_url(); ?><?php echo $product->pro_category; ?>/<?php echo $product->pro_id; ?>/<?php echo RemoveSign($product->pro_name); ?>" onmouseover="ddrivetip('<table border=0 width=300 cellpadding=1 cellspacing=0><tr><td width=\'20\' valign=\'top\' align=\'left\'><img src=\'<?php echo base_url(); ?>media/images/product/<?php echo $product->pro_dir; ?>/<?php echo show_thumbnail($product->pro_dir, $product->pro_image); ?>\' class=\'image_top_tip\'></td><td valign=\'top\' align=\'left\'><?php echo $product->pro_descr; ?></td></tr></table>',300,'#F0F8FF');" onmouseout="hideddrivetip();">
        <?php echo sub($product->pro_name, 100); ?>
      </a>
     </td>
    <td class="line_showcart_2 text-danger" align="right"><strong><?php echo number_format($product->pro_price, 0,'.',',');?> VNĐ</strong></td>
    <td class="line_showcart_3"><?php echo $product->shc_quantity;?></td>
    <td class="line_showcart_4 text-danger" align="right"><strong><?php echo number_format($product->pro_price * $product->shc_quantity,0,'.',',');?> VNĐ</strong></td>
  </tr>
  <?php endforeach;?>
  <tr>
  	<td colspan="4" align="center"><strong>Tổng</strong></td>
  	<td class="sum_bill text-danger" align="center"><strong><?php echo number_format($total,0,'.',',') ?> VNĐ</strong></td>
  </tr>
</table>
<style>
.td_title{
    font-weight:800;
}
</style>
  <div class="panel panel-primary">
    <div class="panel-heading">
      <?php $user_ship = reset($list_product); ?>
      <h3 class="panel-title">Thông tin người nhận hàng</h3>
    </div>
    <table  cellspacing="0" cellpadding="0" align="center" class="table table-bordered">
      <tbody>
      <tr>
        <td width="30%" class="td_title">Tên người đặt hàng :</td>
        <td><?php echo $user_ship->ord_sname; ?></td>
      </tr>
      <tr>
        <td class="td_title">Địa chỉ :</td>
        <td><?php echo $user_ship->ord_saddress ; ?></td>
      </tr>
      <tr>
        <td class="td_title">Email :</td>
        <td><?php echo $user_ship->ord_semail; ?></td>
      </tr>
      <tr>
        <td class="td_title">Số điện thoại :</td>
        <td><?php echo $user_ship->ord_smobile 	; ?></td>
      </tr>
      </tbody>
    </table>
  </div>
  <div class="text-center">
    <ul class="list-group col-lg-4">
      <li class="list-group-item active"> Thông tin thanh toán </li>
      <?php
      $payment_method = $user_ship->payment_method;
      if($payment_method != 'info_baokim' && $payment_method != 'info_nganluong'){
        $payment = "\$user_ship->$payment_method";
        eval("\$info = \"$payment\";");
      } ?>
      <li class="list-group-item"><?php echo $this->lang->line("title".$user_ship->payment_method); ?></li>
      <?php if(isset($info) && $info !=''){?>
        <li class="list-group-item"><i><?php echo nl2br ($info) ?></i></li>
      <?php }?>
    </ul>

    <ul class="list-group col-lg-4">
      <li class="list-group-item active">Thông tin vận chuyển</li>
      <?php
      $shipping_method = $user_ship->shipping_method;
      $shipping = "\$user_ship->$shipping_method";
      eval("\$info = \"$shipping\";");
      ?>
      <?php if($user_ship->shipping_method != ''){?>
        <li class="list-group-item">Nhà vận chuyển: <?php echo $user_ship->shipping_method ?></li>
      <?php }?>
    </ul>

    <ul class="list-group col-lg-4">
      <li class="list-group-item active">
        Thông tin thêm
      </li>
      <?php if(isset($user_ship->ord_otherinfo) && $user_ship->ord_otherinfo!='') {?>
        <li class="list-group-item"><?php echo nl2br($user_ship->ord_otherinfo)?></li>
      <?php }?>
      <?php if(isset($info) && $info !=''){?>
        <li class="list-group-item"><span>Thời gian nhận hàng: </span><?php echo date("h:i d/m/Y",$user_ship->ord_time_receive); ?></li>
      <?php }?>
    </ul>
  </div>
<a class="btn btn-success pull-right" href="<?php echo base_url()?>account/user_order">Quay về danh sách đơn đặt hàng</a>
</form>

<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

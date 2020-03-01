<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
<?php 
  $protocal = 'http://';
?>

<tr>
  <td valign="top"><table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
      <tr>
        <td width="2"></td>
        <td width="10" class="left_main" valign="top"></td>
        <td align="center" valign="top"><!--BEGIN: Main-->
          
          <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tr>
              <td height="10"></td>
            </tr>
            <tr>
              <td><!--BEGIN: Item Menu-->
                
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <td width="5%" height="67" class="item_menu_left"><a href="<?php echo base_url(); ?>administ/showcart/allorder"> <img src="<?php echo base_url(); ?>templates/home/images/icon/cart-icon.png" border="0" /> </a></td>
                    <td width="40%" height="67" class="item_menu_middle">Chi tiết đơn hàng: #<?php echo $this->uri->segment(4); ?></td>
                    <td width="55%" height="67" class="item_menu_right"></td>
                  </tr>
                </table>

            <form name="frmShowcart" method="post">
              <tr>
                <td><!--BEGIN: Content-->
                  
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td width="25" class="title_list">STT</td>
                      <td width="20" class="title_list"><input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmShowcart',0)" /></td>
                      <td class="title_list">Tên sản phẩm</td>
                      <td class="title_list">Số lượng</td>
                      <td class="title_list">Giá</td>
                      <td class="title_list">Người bán</td>
                      <td class="title_list">Nhà vận chuyển</td>
                      <td class="title_list">Mã vận đơn</td>
                      <td class="title_list">Ngày mua</td>
                      <td class="title_list">Trạng thái</td>
                    </tr>
                    <!---->
                    <?php $idDiv = 1; $sTT = 1; ?>
                    <?php foreach($detail as $item){?>
                    <tr style="background:#<?php if($idDiv % 2 == 0){echo 'F7F7F7';}else{echo 'FFF';} ?>;" id="DivRow_<?php echo $idDiv; ?>" onmouseover="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,1)" onmouseout="ChangeStyleRow('DivRow_<?php echo $idDiv; ?>',<?php echo $idDiv; ?>,2)">
                      <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                      <td class="detail_list" style="text-align:center;"><input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $item->shc_id; ?>" onclick="DoCheckOne('frmShowcart')" /></td>
                      <td class="detail_list"> <a class="menu" href="<?php echo base_url(); ?><?php echo $item->pro_category; ?>/<?php echo $item->pro_id; ?>/<?php echo RemoveSign($item->pro_name); ?>/admin" target="_blank" ><?php echo $item->pro_name; ?></a></td>
                      <td class="detail_list" style="text-align:center;"><?php echo $item->shc_quantity; ?></td>
                      <td class="detail_list" style="text-align:right;"><span style="color:#F00; font-weight:bold;"><?php echo number_format($item->pro_price,0,",","."); ?> đ</span></td>
                      <td class="detail_list" style="text-align:center;" ><a href="<?php echo $protocal. $item->sho_link .'.'. explode('//', base_url())[1]; ?>" target="_blank"><?php echo $item->sho_name; ?></a></td>
                      <td class="detail_list" style="text-align:center;"><?php if($users['order']->shipping_method == 'GHN'){echo 'Giao hàng nhanh';} if($users['order']->shipping_method == 'VTP'){echo 'Viettel Post';} if($users['order']->shipping_method == 'SHO'){echo 'Shop Giao';} if($users['order']->shipping_method == 'GHTK'){echo 'Giao hàng tiết kiệm';} ?></td>
                        <td class="detail_list" style="text-align:center;">#<?php echo $users['order']->order_clientCode; ?></td>
                      <td class="detail_list" style="text-align:center;"><?php echo date('d/m/Y', $item->shc_buydate); ?></td>
                      <td class="detail_list" style="text-align:center;">
                          <?php switch ($item->shc_status){
                              case '01':
                                  echo '<span class="label label-info">'.status_1.'</span>';
                                  break;
                              case '02':
                                  echo '<span class="label label-success">'.status_2.'</span>';
                                  break;
                              case '03':
                                  echo '<span class="label label-primary">'.status_3.'</span>';
                                  break;
                              case '04':
                                  echo '<span class="label label-primary">'.status_4.'</span>';
                                  break;
                              case '05':
                                  echo '<span class="label label-primary">'.status_5.'</span>';
                                  break;
                              case '06':
                                  echo '<span class="label label-primary">'.status_6.'</span>';
                                  break;
                              case '99':
                                  echo '<span class="label label-danger">'.status_99.'</span>';
                                  break;
                              case '98':
                                  echo '<span class="label label-primary">'.status_98.'</span>';
                                  break;
                          } ?>
                      </td>
                    </tr>
                    <?php $idDiv++; ?>
                    <?php } ?>
                      <tr>
                          <td colspan="9" align="right">Tổng tiền không có phí vận chuyển:</td>
                          <td height="30"><span style="color: #FF0000; font-weight: 600">&nbsp;<?php echo number_format($users['order']->order_total_no_shipping_fee,0,',','.');?> đ</span></td>
                      </tr>
                      <tr>
                          <td colspan="9" align="right">Phí vận chuyển:</td>
                          <td height="30"><span style="color: #FF0000; font-weight: 600">&nbsp; <?php echo  number_format($users['order']->shipping_fee,0,'.',',');?> đ</span></td>
                      </tr>

                      <tr>
                          <td colspan="9" align="right">Tổng tiền thanh toán:</td>
                          <td height="30"><span style="color: #FF0000; font-weight: 600">&nbsp; <?php echo number_format($users['order']->order_total,0,'.',',');?> đ</span></td>
                      </tr>
                    <!---->
                    <tr>
                      <td class="show_page" colspan="10"><?php echo $linkPage; ?></td>
                    </tr>
                  </table>
                  <!--END Content--></td>
              </tr>
            </form>
          </table>
          
          <!--END Main--></td>
        <td width="10" class="right_main" valign="top"></td>
        <td width="2"></td>
      </tr>
      <tr>
        <td width="2" height="11"></td>
        <td width="10" height="11" class="corner_lb_main" valign="top"></td>
        <td height="11" class="middle_bottom_main"></td>
        <td width="10" height="11" class="corner_rb_main" valign="top"></td>
        <td width="2" height="11"></td>
      </tr>
      </table>
      <?php if($item->shc_status == 99){?>
      <div class="alert alert-danger alert-dismissible fade in" role="alert">
         <strong>Đơn hàng này đã hủy</strong><p>Lý do hủy: <?php switch ($item->shc_status){
                  case '01':
                      echo '<span class="label label-info">'.status_1.'</span>';
                      break;
                  case '02':
                      echo '<span class="label label-success">'.status_2.'</span>';
                      break;
                  case '03':
                      echo '<span class="label label-primary">'.status_3.'</span>';
                      break;
                  case '04':
                      echo '<span class="label label-primary">'.status_4.'</span>';
                      break;
                  case '05':
                      echo '<span class="label label-primary">'.status_5.'</span>';
                      break;
                  case '06':
                      echo '<span class="label label-primary">'.status_6.'</span>';
                      break;
                  case '99':
                      echo '<span class="label label-danger">'.status_99.'</span>';
                      break;
                  case '98':
                      echo '<span class="label label-primary">'.status_98.'</span>';
                      break;
              } ?></p>
      </div>
      <?php }?>
      <!--INFO BUYER-->
      <div class="user-info">

      <!--END INFO BUYER-->
        
        <!--INFO RECEIVER-->
        
         <div class="panel panel-primary admin-order-detail">
          <!-- Default panel contents -->
          <div class="panel-heading text-uppercase">Thông tin người nhận hàng</div>
          <!-- Table -->
          <table cellspacing="0" cellpadding="0" class="table table-bordered">
              <tr>
                  <td width="30%">Họ tên:</td>
                  <td><?php echo $users['receive']->ord_sname; ?></td>
              </tr>
              <tr>
                  <td>Địa chỉ:</td>
                  <td><?php echo $users['receive']->ord_saddress; ?></td>
              </tr>
              <tr>
                  <td>Email:</td>
                  <td><?php echo $users['receive']->ord_semail; ?></td>
              </tr>

              <tr>
                  <td>Điện thoại:</td>
                  <td><?php echo $users['receive']->ord_smobile; ?></td>
              </tr>

              <tr>
                  <td>Ghi chú:</td>
                  <td><?php echo $users['receive']->ord_note; ?></td>
              </tr>
          </table>
      </div>
        <!--END INFO RECEIVER-->
        </div>
  </td>
</tr>
<?php $this->load->view('admin/common/footer'); ?>

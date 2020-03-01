<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
    <h4 class="page-header text-uppercase" style="margin-top:10px">
        Chi tiết đơn hàng
    </h4>

    <div id="panel_order_wrap" class="panel panel-default">       

        <div id="panel_order" class="panel-body">
            <?php if(count($products) > 0){ ?>
            <div class="row">
               <div class="order_code">
                   <div class="col-sm-4">Ngày mua: <span><b><?php echo date('d/m/Y', $info_user_recivce->shc_buydate);?></b></span>  </div>
                   <div class="col-sm-4">Mã đơn hàng: <span class="text-primary"><b>#<?php echo $info_user_recivce->order_id;?></b></span></div>
                   <div class="col-sm-4">
                       <?php
                       if($order->order_status == '03' && (isset($products[0]->pro_type) && $products[0]->pro_type != 2)) {?>
                          <a class="text-warning" href="<?php echo base_url().clientComplain.$info_user_recivce->order_id ;?>"><i class="fa fa-warning"></i> Khiếu nại</a>
                       <?php }?>
                        <?php if(isset($products[0]->pro_type) && $products[0]->pro_type == 2) { ?>
                          <?php echo 'Mã coupon: <span class="text-primary"><b>'.$info_user_recivce->order_coupon_code.'</b>'; ?>
                        <?php } ?>
                   </div>
               </div>
                <div class="clearfix"></div>
            </div>
          <div class="row">
              <div id="panel_left" class="col-sm-4 col-xs-12">
                  <?php
                  $protocol = "http://"; //(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                  $duoi = '.' . $_SERVER['HTTP_HOST'].'/';

                  foreach($products as $product) {

                      $shop = $protocol . $product->sho_link . $duoi;
                      $domain = $this->shop_model->get('domain', 'sho_link = "' . $product->sho_link . '"');

                      if ($domain->domain != '') {
                          $shop = $protocol . $domain->domain . '/';
                      }
                  }
                  echo '<p>Gian hàng: <a href="'.$shop.'shop" target="_blank"><span class="text-primary"><b>'.$products[0]->sho_name.'</b></span></a></p>';
                  echo '<p>Tình trạng thanh toán: ';
                  switch ($info_user_recivce->payment_status){
                      case '0':
                          echo '<span class="text-right text-danger">Chưa thanh toán</span>';
                          break;
                      case '1':
                          echo '<span class="text-right text-success">Đã thanh toán</span>';
                          break;
                  }
                  echo '</p>';
                  echo '<p>Tình trạng đơn hàng: ';
                  switch ($info_user_recivce->order_status){
                      case '01':
                          echo '<span class="text-primary">'.status_1.'</span>';
                          break;
                      case '02':
                          echo '<span class="text-primary">'.status_2.'</span>';
                          break;
                      case '03':
                          echo '<span class="text-primary">'.status_3.'</span>';
                          break;
                      case '04':
                          echo '<span class="text-primary">'.status_4.'</span>';
                          break;
                      case '05':
                          echo '<span class="text-primary">'.status_5.'</span>';
                          break;
                      case '06':
                          echo '<span class="text-primary">'.status_6.'</span>';
                          break;
                      case '99':
                          echo '<span class=text-danger">'.status_99.'</span>';
                          break;
                      case '98':
                          echo '<span class="text-primary">'.status_98.'</span>';
                          break;
                  }
                  echo '</p>';
                  echo '<p>Hình thức thanh toán: ';
                  switch ($info_user_recivce->payment_method){
                      case 'info_cod':
                          echo '<span class="text-primary">Thanh toán tận nơi</span>';
                          break;
                      case 'info_nganluong':
                          echo '<span class="text-primary">Thanh toán qua Ngân lượng</span>';
                          break;
                      case 'info_bank':
                          echo '<span class="text-primary">Chuyển khoản qua ngân hàng</span>';
                          break;
                       case 'info_cash':
                          echo '<span class="text-primary">Thanh toán tại quầy</span>';
                          break;

                  }
                  echo '</p>';
                  if($info_user_recivce->shipping_method != ''){
                  echo '<p>Nhà vận chuyển: ';
                  switch ($info_user_recivce->shipping_method){
                      case 'GHN':
                          echo '<span class="text-primary">Giao hàng nhanh</span>';
                          break;
                      case 'VNPT':
                          echo '<span class="text-primary">VNPT</span>';
                          break;
                      case 'VTP':
                          echo '<span class="text-primary">Viettel Post</span>';
                          break;
                      case 'GHTK':
                          echo '<span class="text-primary">Giao hàng tiết kiệm</span>';
                          break;
                      case 'SHO':
                          echo '<span class="text-primary">Shop giao</span>';
                          break;
                      default:
                          echo '<span class="text-primary">Đơn hàng Coupon</span>';
                  }
                  echo '</p>'; } ?>
                  <?php if(isset($info_user_recivce->ord_note) && $info_user_recivce->ord_note !='') {?>
                  <p>
                      Ghi chú: <i><?php echo $info_user_recivce->ord_note;?></i>
                  </p>
                  <?php }?>
              </div>
              <div  id="panel_right" class="col-sm-8 col-xs-12">
                  <table class="table table-hover" border="0" cellpadding="0" cellspacing="0">
                      <form name="frmAccountShowcart" method="post">
                          <tr>
                              <td width="10%" colspan="3" class="text-right">
                                  Số lượng
                              </td>
                              <td width="20%" class="aligncenter">
                                  Giá bán
                              </td>
                              <td width="10%" class="aligncenter">
                                  Tổng tiền
                              </td>
                          </tr>
                          <?php $idDiv = 1;
                          $total = 0;
                          $order_status = NULL;
                          $count_qty = 0;

                          foreach($products as $product){

                              $shop = $protocol . $product->sho_link . $duoi;
                              $domain = $this->shop_model->get('domain', 'sho_link = "' . $product->sho_link . '"');

                              if ($domain->domain != '') {
                                  $shop = $protocol . $domain->domain . '/';
                              }

                              if ($product->pro_type == 2) {
                                  $pro_type = 'coupon';
                              } else {
                                  if ($product->pro_type == 0) {
                                      $pro_type = 'product';
                                  }
                              }
                              $order_status = $product->shc_status;
                              $total_amount = $product->pro_price * $product->shc_quantity;
                              $total += $total_amount;
                              $count_qty += $product->shc_quantity;
                              ?>

                              <tr class="datarow">
                                  <td width="10%">
                                      <?php
                                        if ($product->shc_dp_pro_id > 0) 
                                        {
                                            $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_' . $product->dp_images;
                                        } else {
                                            $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_' . explode(',',$product->pro_image)[0];
                                        }
                                        if($product->pro_image != '' || $product->dp_images != ''){ //file_exists($filename) && 
                                          ?>
                                          <img width="80" src="<?php echo $filename; ?>" />
                                      <?php }else{?>
                                          <img width="80" src="<?php echo base_url(); ?>media/images/no_photo_icon.png" />
                                      <?php }?>
                                  </td>
                                  <td width="40%" >
                                      <a target="_blank" class="menu_1" href="<?php echo $shop.'shop/'.$pro_type . '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name); ?>" >
                                          <?php echo sub($product->pro_name, 50); ?>
                                      </a>
                                      <p><i>Ngày mua: <?php echo date('d/m/Y',$info_user_recivce->shc_buydate); ?></i></p>
                                      <?php if (isset($info_user_recivce->order_clientCode) && $info_user_recivce->order_clientCode != null) {
                                          echo '<p>Mã vận đơn: #'.$info_user_recivce->order_clientCode.'</p>';
                                      } ?>
                                  </td>
                                  <td width="10%"  style="text-align: center;">
                                      <?php echo $product->shc_quantity ?>
                                  </td>
                                  <td width="15%" style="text-align: right;">
                                      <p class="product_price"><?php echo number_format($product->pro_price_original,0,",","."); ?> đ</p>
                                      <?php if (!empty($product->pro_price_rate)){ ?>
                                          <span class="text-success"><?php echo number_format($product->pro_price_rate, 0, ",", "."); ?> %</span>
                                      <?php } elseif(!empty($product->pro_price_amt)){ ?>
                                          <span class="text-success"> -<?php echo number_format($product->pro_price_amt, 0, ",", "."); ?> đ</span>
                                      <?php } ?>
                                  </td>
                                  <td width="25%" style="text-align: right;">
                                      <span class="product_price"><?php echo number_format($total_amount,0,",","."); ?> đ</span>
                                  </td>
                              </tr>
                              <?php $idDiv++; ?>
                              <?php $sTT++; ?>
                          <?php } ?>
                          <tr>
                              <td  align="right" colspan="3">Tổng tiền :</td>
<!--                              <td align="center">--><?php //echo $count_qty ?><!--</td>-->
                              <td colspan="2"  align="right" style="text-align: right;">
                                   <b> <?php echo number_format($total, 0, ',', '.') ?> đ</b>
                              </td>
                          </tr>
                          <tr>
                              <td  align="right" colspan="3">Phí vận chuyển :</td>
                              <td colspan="2" align="right" style="text-align: right;">
                                <span>
                                 <?php echo number_format($info_user_recivce->shipping_fee, 0, ',', '.') ?> đ
                                </span>
                              </td>
                          </tr>
                          <tr>
                              <td  align="right" colspan="3"><b>Tổng thành tiền :</b></td>
                              <td  colspan="3" align="right" style="text-align: right;">
                                <span class="product_price">
                                <b> <?php echo number_format($info_user_recivce->shipping_fee + $total, 0, ',', '.') ?> đ</b>
                                </span>
                              </td>
                          </tr>
                      </form>
                  </table>
              </div>
          </div>

            <table class="table">
                <tr>
                    <td><span><b>Thông tin người nhận hàng</b></span></td>
                </tr>
                <tr>
                    <td>
                        <p>Người nhận: <b><?php echo $info_user_recivce->ord_sname;?></b></p>
                        <?php if ($info_user_recivce->ord_saddress !='' && $info_user_recivce->product_type != 2){?>
                        <p>Địa chỉ: <?php 
                        echo $info_user_recivce->ord_saddress;
                        if($info_user_recivce->DistrictName != '' && $info_user_recivce->ProvinceName != ''){
                            echo ', '.$info_user_recivce->DistrictName.', '.$info_user_recivce->ProvinceName;
                        }
                        ?></p>
                        <?php } ?>
                        <p>Điện thoại: <?php echo $info_user_recivce->ord_smobile;?></p>
                        <p>Email: <?php echo $info_user_recivce->ord_semail;?></p>
                    </td>
                </tr>
            </table>
           <div class="col-sm-4"></div>
           <div class="col-sm-8 text-right">
                <?php if($info_user_recivce->product_type == 2 ) { ?>
                  <a href="<?php echo base_url();?>account/user_order/coupon" class="btn btn-default"><i class="fa fa-arrow-left fa-fw"></i> Trở lại</a>
                <?php } else { ?>
                  <a href="<?php echo base_url();?>account/user_order/product" class="btn btn-default"><i class="fa fa-arrow-left fa-fw"></i> Trở lại</a>
                <?php } ?>
                   <?php if($info_user_recivce->order_status == '01' && (int)$this->session->userdata('sessionGroup') == 1){?>
                   <button id="cancel_order" class="btn btn-primary" data-toggle="modal" data-target="#cancel-modal">Hủy đơn hàng</button>
                   <?php }?>
           </div>
            <?php }else{ ?>
                    <p class="text-center">Không có đơn hàng nào!</p>
            <?php } ?>
        </div><!--End panel-body-->
    </div><!--End panel-wrap-->
</div>
</div>
</div>
 <input id="baseUrl" type="hidden" value="<?php echo base_url()?>"  />
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<?php if(isset($successAddShowcart) && trim($successAddShowcart) != ''){ ?>
<script>
alert('<?php echo $successAddShowcart; ?>');</script>
<?php } ?>
<div id="cancel-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:35%;">
        <form id="cancel_order_form" method="post" action="<?php echo base_url() . 'order-cancel-user/'.$this->uri->segment(3); ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Xác nhận hủy đơn hàng</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group no-margin">
                                <label for="field-7" class="control-label"><strong>Nhập lí do hủy</strong></label>
                                <textarea required="required" name="info_cancel" class="form-control autogrow" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info" value="cancel">Xác nhận</button>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('button[type="submit"]').on('click',function() {
            $('button[type="submit"]').attr('disabled','disabled');
            $('button[type="button"]').attr('disabled','disabled');

            $("#cancel_order_form").submit();
        });

        <?php if(isset($_REQUEST['do']) && $_REQUEST['do'] == "cancel"): ?>
        $("#cancel-modal").modal('show');
        <?php endif; ?>

    });
</script>
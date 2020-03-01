<?php
$this->load->view('home/common/header_new');
?>
<link href="<?php echo base_url()?>/templates/landing_page/css/font-awesome.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">
<script src="/templates/home/styles/js/common.js"></script>

<main class="cart-content main-content">
    <div class="breadcrumb">
       <div class="container">
          <ul>
             <li><a href="">Trang chủ azibai</a><img src="/templates/home/images/svg/breadcrumb_arrow.svg" class="ml10" alt=""></li>
             <li>Thanh toán sản phẩm đã mua</li>
          </ul>
       </div>
    </div>
    <div class="container">
      <?php if (!empty($productList)) { ?>
        <form id="frmShowCart">
          <input type="hidden" class="js-key" name="key" value="<?php echo $_REQUEST['key']; ?>">
        <div class="payment">
          <h3 class="tit"><span>1</span>Thông tin người nhận</h3>
          <div class="payment-address">
            <p>Họ và tên: <?php echo $order_address->name ?></p>
            <p>Địa chỉ: <?php echo $order_address->full_address ?></p>
            <p>Điện thoại: <?php echo $order_address->phone ?></p>
            <p>Email: <?php echo $order_address->semail ?></p>
          </div>
          <h3 class="tit"><span>2</span>Phương thức thanh toán</h3>
          <ul class="payment-method">
            <?php if ($order_type == 'product') { ?>
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="payment_method" value="info_cod" checked="checked">
                  <span>Thanh toán khi nhận hàng</span>
                </label>
              </li>
              <?php if ($shop_momo) { ?>
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="payment_method" value="info_momo">
                  <span>Thanh toán qua ví MoMo</span>
                </label>
              </li>  
              <?php } ?>
              <?php if ($shop_nganluong) { ?>
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="payment_method" value="info_nganluong_bank">
                  <span>Thanh toán online bằng thẻ ngân hàng nội địa</span>
                </label>
                <div class="select-banks" style="display: none;">
                  <p><i>
                  <span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>: Bạn cần đăng ký Internet-Banking hoặc dịch vụ thanh toán trực tuyến tại ngân hàng trước khi thực hiện.</i></p>
                  <br>
                  <ul class="select-banks-check">
                    <li>
                      <label for="exampleCheck1">
                        <img src="/templates/home/styles/images/banks/bidv.png" title="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam" alt="Ngân hàng TMCP Đầu tư &amp; Phát triển Việt Nam"><br>
                        <input type="radio" value="BIDV"  name="bankcode" checked>
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck2">
                        <img src="/templates/home/styles/images/banks/vietcombank.png" title="Ngân hàng TMCP Ngoại Thương Việt Nam" alt="Ngân hàng TMCP Ngoại Thương Việt Nam"><br>
                        <input type="radio" value="VCB"  name="bankcode" id="exampleCheck2">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck3">
                        <img src="/templates/home/styles/images/banks/donga.png" title="Ngân hàng Đông Á" alt="Ngân hàng Đông Á"><br>
                        <input type="radio" value="DAB"  name="bankcode" id="exampleCheck3">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck4">
                        <img src="/templates/home/styles/images/banks/techcombank.png" title="Ngân hàng Kỹ Thương" alt="Ngân hàng Kỹ Thương"><br>
                        <input type="radio" value="TCB"  name="bankcode" id="exampleCheck4">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck5">
                        <img src="/templates/home/styles/images/banks/mb.png" title="Ngân hàng Quân Đội" alt="Ngân hàng Quân Đội"><br>
                        <input type="radio" value="MB"  name="bankcode" id="exampleCheck5">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck6">
                        <img src="/templates/home/styles/images/banks/vib.png" title="Ngân hàng Quốc tế" alt="Ngân hàng Quốc tế"><br>
                        <input type="radio" value="VIB"  name="bankcode" id="exampleCheck6">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck7">
                        <img src="/templates/home/styles/images/banks/viettin.png" title="Ngân hàng Công Thương Việt Nam" alt="Ngân hàng Công Thương Việt Nam"><br>
                        <input type="radio" value="ICB"  name="bankcode" id="exampleCheck7">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck8">
                        <img src="/templates/home/styles/images/banks/exim.png" title="Ngân hàng Xuất Nhập Khẩu" alt="Ngân hàng Xuất Nhập Khẩu"><br>
                        <input type="radio" value="EXB"  name="bankcode" id="exampleCheck8">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck9">
                        <img src="/templates/home/styles/images/banks/acb.png" title="Ngân hàng Á Châu" alt="Ngân hàng Á Châu"><br>
                        <input type="radio" value="ACB" name="bankcode" id="exampleCheck9">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck10">
                        <img src="/templates/home/styles/images/banks/hd.png" title="Ngân hàng Phát triển Nhà TPHCM" alt="Ngân hàng Phát triển Nhà TPHCM"><br>
                        <input type="radio" value="HDB"  name="bankcode" id="exampleCheck10">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck11">
                        <img src="/templates/home/styles/images/banks/maritime.png" title="Ngân hàng Hàng Hải" alt="Ngân hàng Hàng Hải"><br>
                        <input type="radio" value="MSB"  name="bankcode" id="exampleCheck11">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck12">
                        <img src="/templates/home/styles/images/banks/ncb.png" title="Ngân hàng Nam Việt" alt="Ngân hàng Nam Việt"><br>
                        <input type="radio" value="NVB"  name="bankcode" id="exampleCheck12">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck13">
                        <img src="/templates/home/styles/images/banks/vieta.png" title="Ngân hàng Việt Á" alt="Ngân hàng Việt Á"><br>
                        <input type="radio" value="VAB"  name="bankcode" id="exampleCheck13">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck15">
                        <img src="/templates/home/styles/images/banks/vp.png" title="Ngân Hàng Việt Nam Thịnh Vượng" alt="Ngân Hàng Việt Nam Thịnh Vượng"><br>
                        <input type="radio" value="VPB"  name="bankcode" id="exampleCheck15">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck16">
                        <img src="/templates/home/styles/images/banks/sacom.png" title="Ngân hàng Sài Gòn Thương tín" alt="Ngân hàng Sài Gòn Thương tín"><br>
                        <input type="radio" value="SCB"  name="bankcode" id="exampleCheck16">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck17">
                        <img src="/templates/home/styles/images/banks/pg.png" title="Ngân hàng Xăng dầu Petrolimex" alt="Ngân hàng Xăng dầu Petrolimex"><br>
                        <input type="radio" value="PGB"  name="bankcode" id="exampleCheck17">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck18">
                        <img src="/templates/home/styles/images/banks/gp.png" title="Ngân hàng TMCP Dầu khí Toàn Cầu" alt="Ngân hàng TMCP Dầu khí Toàn Cầu"><br>
                        <input type="radio" value="GPB"  name="bankcode" id="exampleCheck18">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck19">
                        <img src="/templates/home/styles/images/banks/agri.png" title="Ngân hàng Nông nghiệp &amp; Phát triển nông thôn" alt="Ngân hàng Nông nghiệp &amp; Phát triển nông thôn"><br>
                        <input type="radio" value="AGB"  name="bankcode" id="exampleCheck19">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck20">
                        <img src="/templates/home/styles/images/banks/saigon.png" title="Ngân hàng Sài Gòn Công Thương" alt="Ngân hàng Sài Gòn Công Thương"><br>
                        <input type="radio" value="SGB"  name="bankcode" id="exampleCheck20">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck21">
                        <img src="/templates/home/styles/images/banks/baca.png" title="Ngân hàng Bắc Á" alt="Ngân hàng Bắc Á"><br>
                        <input type="radio" value="BAB"  name="bankcode" id="exampleCheck21">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck22">
                        <img src="/templates/home/styles/images/banks/tp.png" title="Tiền phong bank" alt="Tiền phong bank"><br>
                        <input type="radio" value="TPB"  name="bankcode" id="exampleCheck22">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck23">
                        <img src="/templates/home/styles/images/banks/nama.png" title="Ngân hàng Nam Á" alt="Ngân hàng Nam Á"><br>
                        <input type="radio" value="NAB"  name="bankcode" id="exampleCheck23">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck24">
                        <img src="/templates/home/styles/images/banks/shb.png" title="Ngân hàng TMCP Sài Gòn - Hà Nội (SHB)" alt="Ngân hàng TMCP Sài Gòn - Hà Nội (SHB)"><br>
                        <input type="radio" value="SHB"  name="bankcode" id="exampleCheck24">
                      </label>
                    </li>
                    <li>
                      <label for="exampleCheck25">
                        <img src="/templates/home/styles/images/banks/ocen.png" title="Ngân hàng TMCP Đại Dương (OceanBank)" alt="Ngân hàng TMCP Đại Dương (OceanBank)"><br>
                        <input type="radio" value="OJB"  name="bankcode" id="exampleCheck25">
                      </label>
                    </li>
                  </ul>
                </div>
              </li>
              
              <li>
                <label class="checkbox-style-circle">
                  <input type="radio" name="payment_method" value="info_nganluong_visa">
                  <span>Thanh toán bằng thẻ Visa hoặc MasterCard</span>
                </label>
                <div class="select-visa" style="display: none;">
                    <p><i>
                    <span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>: Visa hoặc MasterCard.</i></p>
                    <br>
                    <ul class="select-banks-check">
                      <li>
                        <label class="checkbox-style mt10">
                            <input class="type_pay" type="radio" name="bankcode_online" value="VISA" checked>
                            <span>VISA</span>
                        </label>
                      </li>
                      <li>
                        <label class="checkbox-style mt10">
                            <input class="type_pay" type="radio" name="bankcode_online" value="MASTER">
                            <span>Master</span>
                        </label>
                      </li>
                    </ul>
                </div>
              </li>
              <?php } ?>
           
            <?php } else { ?>
            <li>
              <label class="checkbox-style-circle">
                <input type="radio" name="payment_method" value="info_bank">
                <span>Chuyển khoản qua ngân hàng</span>
              </label>
            </li>
            <li>
              <label class="checkbox-style-circle">
                <input type="radio" name="payment_method" value="info_cash">
                <span>Thanh toán bằng tiền mặt tại quầy</span>
              </label>
            </li>
            <?php } ?>
          </ul>
          <h3 class="tit">
            <span>3</span><?php echo $order_type == 'product' ? 'Nhà vận chuyển' : 'Xem lại đơn hàng'; ?>
          </h3>

          <div class="transport">
            <?php
            $total_all = 0;
            $total_all_ship = 0; 
            foreach ($productList as $key => $value) {
                $ship =  !empty($value['shipping']['ServiceFee']) ? $value['shipping']['ServiceFee'] : 0;
                $total_all_ship += $ship; 
            ?>

            <?php if ($order_type == 'product') { ?>
            <input type="hidden" name="company" value="SHO" class="js-company-fee">
            
            <div class="selectTypeShip-table">
              <table>
                <tr>
                  <th class="sm-none"><img src="/templates/home/images/svg/tennhavanchuyen.svg" class="mr10">Tên nhà vận chuyển</th>
                  <th class="sm-none">Tiêu chuẩn giao hàng</th>
                  <th class="sm-none">Thời gian dự kiến </th>
                  <th class="sm-none">Phí vận chuyển</th>
                </tr>
                <tr class="shop_shipping <?php if (!empty($value['nhanh_shipping'])) { echo 'hidden';} ?>">  
                  <td class="selectTypeShip-item">
                    <label class="checkbox-style-circle">
                      <input type="radio" name="js-radio" class="js-get-fee" value="SHO" <?php echo (!empty($value['nhanh_shipping'])) ? 'disabled' : 'checked="checked"'; ?> data-key="<?php echo $key; ?>"><span></span>
                    </label>
                    <div>
                      <p>
                        <img src="/templates/home/images/svg/phuongthucvanchuyen.svg" class="mr10">
                        <strong>Shop giao</strong>
                      </p>
                      <div class="sm">
                        <div class="time">
                          <span class="text-gray">Shop liên hệ</span>
                          <strong>Shop liên hệ</strong>
                        </div>
                      </div>
                    </div>
                  </td>
                  <td class="sm-none"><span class="text-gray">Shop liên hệ</span></td>
                  <td class="sm-none"><strong>Shop liên hệ</strong></td>
                  <td class="sm-none">Shop liên hệ</td>
                </tr>
                <?php 
                if (!empty($value['nhanh_shipping'])) { 
                  foreach ($value['nhanh_shipping'] as $k => $v) {
                ?>
                <tr class="nhanh_shipping">  
                  <td class="selectTypeShip-item">
                    <label class="checkbox-style-circle">
                      <input type="radio" name="js-radio" class="js-get-fee" value="<?php echo $k; ?>" data-fee="<?php echo $v->totalFee; ?>" data-time="<?php echo $v->serviceDescription ?>" data-name="<?php echo $v->carrierName; ?>" data-key="<?php echo $key; ?>"><span></span>
                    </label>
                    <div>
                      <p>
                        <img src="/templates/home/images/svg/phuongthucvanchuyen.svg" class="mr10">
                        <strong><?php echo $v->carrierName; ?></strong>
                      </p>
                      <div class="sm">
                        <div class="time">
                          <span class="text-gray"><?php echo $v->serviceName ?></span>
                          <strong><?php echo $v->serviceDescription ?></strong>
                        </div>
                        <p><?php echo lkvUtil::formatPrice($v->totalFee, 'VND') ?></p>
                      </div>
                    </div>
                  </td>
                  <td class="sm-none"><span class="text-gray"><?php echo $v->serviceName ?></span></td>
                  <td class="sm-none"><strong><?php echo $v->serviceDescription ?></strong></td>
                  <td class="sm-none"><?php echo lkvUtil::formatPrice($v->totalFee, 'VND') ?></td>
                </tr>
                <?php } } ?>
              </table>
            </div>


           
            <?php } ?>
            <!-- earch item -->
            <div class="transport-item">
              <div class="cartItem">
                <div class="shopInfo">
                  <span>Người bán:<strong class="ml10"><?php echo $value['info']['sho_name'];  ?></strong></span>
                </div>
                <div class="productCartItemWrapper">
                  <table>
                    <tr>
                      <th class="bg-gray">Sản phẩm</th>
                      <th class="sm-none">Thành tiền</th>
                      <th class="sm-none">Số lượng </th>
                      <?php if ($order_type == 'product') { ?>
                      <th class="sm-none"><a class="cursor-pointer js-pop-fee">Nhà vận chuyển <i class="fa fa-angle-down" aria-hidden="true" style=""></i></a></th>
                      <?php } ?>
                    </tr>

                    <?php 
                      $total = 0;
                      foreach ($value['product'] as $key_num => $product)
                      { 
                          $total += $product->pro_cost * $product->qty - $product->em_discount;
                          $total_all += $product->pro_cost * $product->qty - $product->em_discount;                                
                          $link = getAliasDomain() . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                          $link_name = $mainDomain . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                          $link_img = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_';
                          
                          if ($product->dp_id > 0) 
                          {
                              $img_product = $file_ex = $link_img . $product->dp_image;
                          }
                          else if ($product->pro_image != '') 
                          {
                            $get_img = explode(',', $product->pro_image);

                            if (!empty($get_img[0])) 
                            {
                                  $img_product = $link_img . $get_img[0];
                            }
                          }
                          else
                          {
                            $img_product = getAliasDomain() . 'images/img_not_available.png';
                          }
                    ?>
                     
                    <tr id="row_<?php echo $product->key; ?>" class="js-productCartItems" data-id="<?php echo $product->key; ?>">
                      <td>
                        <div class="productCartItems">
                          <div class="productCartItem">
                            <div class="productCard">
                              <div class="card-horiz">
                                <span class="imageWrap">
                                  <img src="<?php echo $img_product ?>" alt="<?php echo sub($product->pro_name, 200); ?>">
                                </span>
                                <div class="caption">
                                  <div class="tit"><?php echo sub($product->pro_name, 200); ?></div>
                                  <div class="property">
                                    <?php
                                        if ($product->dp_color)
                                        {
                                            echo '<p>Màu: ' . $product->dp_color . '</p>';
                                        }

                                        if ($product->dp_size)
                                        {
                                          echo '<p>Kích thước: <span class="bg-gray">' . $product->dp_size . '</span></p>';
                                        }

                                        if($product->dp_material != '')
                                        {
                                          echo '<p>Chất liệu: ' . $product->dp_material . '</p>';
                                        }
                                    ?>
                                  </div>
                                </div>
                              </div>                        
                            </div>
                          </div>
                          <div class="sm calculator-sm">
                            <div class="price-quanlity">
                              <div class="text-bold f18 one-line">
                                <span class="text-red sub_<?php echo $product->key; ?>">
                                  <?php echo lkvUtil::formatPrice($product->pro_cost * $product->qty, 'VND'); ?>
                                </span>
                              </div>
                              <div class="add-form">
                                <input readonly="readonly" value="<?php echo $product->qty; ?>"
                                      class="qty_<?php echo $product->key; ?> number" 
                                      min="<?php echo ((int) $product->qty_min > 0 ? $product->qty_min : 1); ?>"
                                      max="<?php echo ((int) $product->qty_max > 0 ? $product->qty_max : 1); ?>" />
                              </div>
                            </div>
                          </div>
                        </div>
                        <p class="dc_<?php echo $product->key; ?>">
                          <?php 
                          if ($product->em_discount > 0) 
                          {
                            echo 'Được giảm <span class="text-red">' . lkvUtil::formatPrice($product->em_discount, 'VND') . '</span> cho đơn hàng.';
                          } 
                          ?>
                        </p>
                      </td>
                      <td class="sm-none">
                        <div class="text-bold text-center f18 one-line">
                          <span class="text-red sub_<?php echo $product->key; ?>">
                            <?php echo lkvUtil::formatPrice($product->pro_cost * $product->qty, 'VND'); ?>
                          </span>
                        </div>
                      </td>
                      <td class="sm-none">
                        <div class="add-form">
                           
                            <input readonly="readonly" type="number" value="<?php echo $product->qty; ?>"
                              class="qty_<?php echo $product->key; ?> number" 
                              min="<?php echo ((int) $product->qty_min > 0 ? $product->qty_min : 1); ?>" 
                              max="<?php echo ((int) $product->qty_max > 0 ? $product->qty_max : 1); ?>" />
                            
                        </div>
                      </td>
                      <?php if ($order_type == 'product') { ?>
                      <td class="sm-none">
                        <div class="text-center js-name-fee">Shop giao</div>
                      </td>
                      <?php } ?>
                    </tr>
                    
                    <?php } ?>
                  </table>
                </div>
              </div>
              <div class="note">
                <textarea name="note[<?php echo $key ?>]" class="w100pc" id="" rows="3" placeholder="Ghi chú:"></textarea>
              </div>
              <div class="sum-price">

                <?php if ($order_type == 'product'){ ?>
                  <div class="left">
                    <p>Tổng giá sản phẩm: <span class="js-total-shop-<?php echo $key; ?>"><?php echo lkvUtil::formatPrice($total, 'VND'); ?></span></p>
                    <p><span class="btn-has-coupon cursor-pointer" data-target="#addCodeCoupon" data-toggle="modal">Có mã giảm giá</span><strong class="js-show-text-voucher"></strong></p>
                  </div>
                  <div class="center">
                    <p class="sm">Nhà vận chuyển: &nbsp;
                      <a class="cursor-pointer js-pop-fee"><span class="js-name-fee">Shop giao</span> <i class="fa fa-angle-down" aria-hidden="true" style=""></i></a>
                    </p>
                    <p>Phí vận chuyển: 
                      <span class="js-shipping-<?php echo $key; ?>">
                        <?php echo !empty($value['shipping']['ServiceFee']) ? lkvUtil::formatPrice($value['shipping']['ServiceFee'], 'VND') : '-' ?>
                      </span>
                    </p>
                    <p>Thời gian giao hàng: 
                      <span class="js-time-shipping-<?php echo $key; ?>">
                        <?php echo !empty($value['shipping']['ServiceName']) ? $value['shipping']['ServiceName'] : '-' ?>
                      </span>
                    </p>
                  </div>
                <?php } else { ?>
                <div class="left">
                    <p><span class="btn-has-coupon cursor-pointer" data-target="#addCodeCoupon" data-toggle="modal">Có mã giảm giá</span><strong>Bạn đang sử dụng 5 mã giảm giá</strong></p>
                  </div>
                <?php } ?>
                <div class="<?php echo $order_type == 'product' ? '' : 'w100pc text-right';  ?> right js-div-total-shop" data-id="<?php echo $key; ?>">
                  <input type="hidden" class="input-total-<?php echo $key ?>" value="<?php echo $total; ?>">
                  <input type="hidden" class="input-total-voucher-<?php echo $key ?>" value="0">
                  <input type="hidden" class="input-total-ship-<?php echo $key ?>" value="<?php echo $ship; ?>">
                  <p>Tổng cộng: <span class="js-total-<?php echo $key; ?>"><?php echo lkvUtil::formatPrice($total + $ship, 'VND'); ?></span></p>
                </div>
              </div>
            </div>
            <?php } ?>
            <!-- total -->
            <div class="total-order">
              <div class="sum-order hidden">
                <p class="number-order">Tổng số đơn hàng <span class="text-red">(<?php echo count($productList); ?> đơn)</span></p>
                <p>Tổng giá sản phẩm: <span class="js-total-product"> <?php echo lkvUtil::formatPrice($total_all, 'VND'); ?> </span></p>
                <p>Tổng phí vận chuyển:<span class="js-shipping-all"> <?php echo lkvUtil::formatPrice($total_all_ship, 'VND'); ?></span></p>
                <p class="total">Tổng cộng:<span class="js-total-all"> <?php echo lkvUtil::formatPrice($total_all + $total_all_ship, 'VND'); ?></span></p>
              </div>
              <div class="button-order">
                <button class="js-button-order">Đặt hàng</button>
              </div>
            </div>
            
          </div>
        </div>
        </form>
      <?php } else { ?>

      <?php } ?>
      </div>
</main>

<script id="js-ordered-item" type="text/template">
<div class="ordered-items">
  </p>Quý khách vừa đặt thành công sản phẩm của shop <a href="{{SHO_LINK}}"><i class="text-red">{{SHO_NAME}}</i></a>, mã đơn hàng của quý khách là:</p>
  <div class="code">{{ORDER_ID}}</div>
  <p>Quý khách có thể quản lý và theo dõi đơn hàng tại: <strong>menu quản trị</strong> > <a href="<?= azibai_url(); ?>/account/user_order/product" class="text-red">Kiểm tra đơn hàng</a><br/>Hoặc bấm vào <strong>Chi tiết đơn hàng</strong> phía dưới</p>
  <div class="text-center">
    <a class="detail-of-delivery" href="{{ORDER_LINK}}">CHI TIẾT ĐƠN HÀNG</a>
  </div>
</div> 
</script>

<div class="modal" id="successfully-ordered">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-mess ">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Đặt hàng thành công</h4>
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
            <div class="successfully-ordered-modal">
              <p>Chào <span class="name_user"></span>,</p>
              <div class="js-swap-order-item">
               
              </div>              
              <div class="text-center">
                <a href="<?php echo base_url();?>shop/products"><p class="continue-shopping">TIẾP TỤC MUA HÀNG</p></a>
              </div>
              <p>Cảm ơn quý khách đã tin tưởng và giao dịch tại <a href="https://www.azibai.com" class="text-red">www.azibai.com</a></p>
            </div>
          </div>
      <div class="modal-footer">
        <div class="shareModal-footer">
          <div class="permision">
          </div>
          <div class="buttons-direct">
            <a href="<?php echo base_url();?>"><button class="btn-share">Xong</button></a>
          </div>
        </div>
      </div>
      <!-- End modal-footer -->
    </div>
  </div>
</div>

<div class="modal" id="error-ordered-online">
  <div class="modal-dialog modal-dialog-centered modal-lg modal-mess ">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Đơn hàng thanh toán thất bại</h4>
        <!-- <button type="button" class="close" data-dismiss="modal">&times;</button> -->
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">
            <div class="successfully-ordered-modal">
              <p>Chào <span class="name_user"></span>,</p>
              <div class="js-swap-order-item">
               
              </div>              
              <div class="text-center">
                <a href="<?php echo base_url();?>shop/products"><p class="continue-shopping">TIẾP TỤC MUA HÀNG</p></a>
              </div>
              <p>Cảm ơn quý khách đã tin tưởng và giao dịch tại <a href="https://www.azibai.com" class="text-red">www.azibai.com</a></p>
            </div>
          </div>
      <div class="modal-footer">
        <div class="shareModal-footer">
          <div class="permision">
          </div>
          <div class="buttons-direct">
            <a href="<?php echo base_url();?>"><button class="btn-share">Xong</button></a>
          </div>
        </div>
      </div>
      <!-- End modal-footer -->
    </div>
  </div>
</div>


<script id="js-voucher-template" type="text/template">
<p class="item">{{VOUCHER}} 
  <span class="close js-remove-voucher" data-value="{{VOUCHER}}"><img src="/templates/home/images/svg/close_blue.svg" alt=""></span>
</p>
</script>
<div class="modal addCodeCoupon" id="addCodeCoupon" >
  <div class="modal-dialog modal-dialog-centered modal-lg  modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">              
        <div class="addCodeCoupon-addbox">
          <input type="text" class="form-control js-get-voucher" placeholder="Vui lòng nhập mã giảm giá của bạn ">
          <button class="btn-add js-add-voucher">Áp dụng</button>
        </div>
        <div class="addCodeCoupon-showCodes"></div>
        <div class="addCodeCoupon-showCoupon">
          <?php if (!empty($list_voucher)) { ?>
              <?php foreach ($list_voucher as $k_voucher => $v_voucher) { ?>
                <?php // dd($v_voucher); ?>
                <div class="item bg-coupon">
                  <div class="bg-coupon-avata">
                    <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $v_voucher->sho_dir_logo . '/' . $v_voucher->sho_logo ?>" class="main" alt="">
                    <h3 class="one-line"><?php echo $v_voucher->sho_name ?></h3>
                  </div>
                  <div class="bg-coupon-info">
                    <div class="tit">Mã giảm giá <?=$v_voucher->voucher_type == 1 ? $v_voucher->value . '%' : ($v_voucher->voucher_type == 2 ? number_format($v_voucher->value, 0, ',', '.') . ' VNĐ' : 0)?></div>
                    <p><?=$v_voucher->product_type == 1 ? 'Áp dụng đơn hàng tối thiểu: ' . number_format($v_voucher->price_rank, 0, ',', '.') . ' VNĐ' : ($v_voucher->product_type == 2 ? 'Áp dụng cho '.$v_voucher->product_count.' sản phẩm' : 0)?></p>
                    <div class="time"><img src="/templates/home/images/svg/clock.svg" class="mr05 mt04" alt=""><?php echo date('H:i d-m-Y', strtotime($v_voucher->time_start)); ?>  đến <?php echo date('H:i d-m-Y', strtotime($v_voucher->time_end)); ?></div>
                    <div class="text-right">
                      <button class="btn-use cursor-pointer js-choose-voucher" data-value="<?php echo $v_voucher->v_code ?>">Sử dụng</button>
                    </div>
                  </div>
                </div>
               
              <?php } ?>
          <?php } ?>
        </div>
        <div class="text-center">
          <button class="btn-done" data-dismiss="modal">Xong</button>
        </div>
      </div>     
    </div>
  </div>
</div>
<div class="modal addCodeCoupon" id="messVoucher" >
  <div class="modal-dialog modal-dialog-centered  modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
    
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      
      <!-- Modal body -->
      <div class="modal-body">              
        <p class="pb20">
          Lưu ý :  <span class="js-get-msg-voucher"></span>
        </p>
      </div> 
      <!-- Modal footer -->
      <div class="modal-footer">
        <div class="shareModal-footer">
          <div class="permision">
          </div>
          <div class="buttons-direct">
            <button class="btn-share" data-dismiss="modal">Đồng ý</button>
          </div>
        </div>
      </div>     
    </div>
  </div>
</div>

<footer id="footer" class="footer-border-top">
<?php $this->load->view('e-azibai/common/common-html-footer'); ?>
<?php $this->load->view('home/common/overlay_waiting')?>
</footer>


<script type="text/javascript">
  
  // Number format
  (function (b) {
      b.fn.number = function (o) {
          var r = 0;
          var m = '.';
          var p = '.';
          var currency = 'VND';
          o = (o + "").replace(/[^0-9+\-Ee.]/g, "");
          var s = !isFinite(+o) ? 0 : +o,
              t = !isFinite(+r) ? 0 : Math.abs(r),
              a = (typeof p === "undefined") ? "," : p,
              q = (typeof m === "undefined") ? "." : m,
              l = "",
              n = function (e, c) {
                  var d = Math.pow(10, c);
                  return "" + Math.round(e * d) / d
              };
          l = (t ? n(s, t) : "" + Math.round(s)).split(".");
          if (l[0].length > 3) {
              l[0] = l[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, a)
          }
          if ((l[1] || "").length < t) {
              l[1] = l[1] || "";
              l[1] += new Array(t - l[1].length + 1).join("0")
          }
          return l.join(q) + ' ' + currency;
      }
  })(jQuery);

  $( ".js-company" ).change(function() {
      var company = $(this).val();
      var shop_id = $(this).attr('data-id');
      var shop_district = $(this).attr('data-district');
      var key_order = $('#frmShowCart .js-key').val();
      $('.load-wrapp').show();
      $.ajax({
          type: "POST",
          url: "/v-checkout/shipping",
          data: {
              company: company,
              shop_id: shop_id,
              shop_district: shop_district,
              key_order: key_order
          },
          dataType: "json",
          success: function (data) {
              if (data.error == false) {
                if (company == 'GHN') 
                {
                  $('.js-type-ship-' + shop_id).text('Giao hàng nhanh');
                  $('.js-shipping-' + shop_id).text($.fn.number(data.fee_amount));
                  $('.js-time-shipping-' + shop_id).text(data.feeTime);
                  $('.input-total-ship-' + shop_id).val(data.fee_amount);
                } 
                else if (company == 'SHO') 
                {
                  $('.js-type-ship-' + shop_id).text('Shop giao');
                  $('.js-shipping-' + shop_id).text('-');
                  $('.js-time-shipping-' + shop_id).text('-');
                  $('.input-total-ship-' + shop_id).val('0');
                }                 
              }
              total_order();
          }
      }).always(function() {
          $('.load-wrapp').hide();
      });
  });

  function total_order() {
    var total = 0; 
    var total_ship = 0;
    var list = $('.js-div-total-shop');
    $.each(list, function( index, value ) {
        var key_shop = $(this).attr('data-id');
        total = total + parseInt($('.input-total-'+ key_shop).val());
        total_voucher =  parseInt($('.input-total-voucher-'+ key_shop).val());
        price_shipping = parseInt($('.input-total-ship-'+ key_shop).val());
        total_ship = total_ship + parseInt($('.input-total-ship-'+ key_shop).val());
        $('.js-total-' + key_shop).text($.fn.number(parseInt(total) + parseInt(price_shipping) - parseInt(total_voucher)));
    });

    $('.js-shipping-all').text($.fn.number(total_ship));
    $('.js-total-all').text($.fn.number(total + total_ship));
  }

  $('.js-button-order').click(function(e){
      e.preventDefault();
      $('.load-wrapp').show();
      $(this).prop( "disabled", true );
      $.ajax({
            type: "POST",
            url: "/v-checkout/place-order",
            dataType: 'json',
            data : $('#frmShowCart').serialize(),
            success: function(result) {

              if (typeof(result.reponse_momo) != "undefined") 
              {
                  var reponse_momo = JSON.parse(result.reponse_momo);
                  if (reponse_momo.errorCode != 0) 
                  {
                    $('#error-ordered-online .name_user').text(result.name);
                    $('#error-ordered-online .js-swap-order-item').html('');
                    $.each(result.data, function( index, value ) {
                        var templateHtml = $('#js-ordered-item').html();
                        var appendEditData = templateHtml
                              .replace('{{SHO_LINK}}', value.sho_link)
                              .replace('{{SHO_NAME}}', value.sho_name)
                              .replace('{{ORDER_ID}}', value.order_id)
                              .replace('{{ORDER_LINK}}', value.order_link);
                        $('#error-ordered-online .js-swap-order-item').append(appendEditData);
                    });
                    $('#error-ordered-online').modal({
                          backdrop: 'static',
                          keyboard: true, 
                          show: true
                    });
                    $('.cartNum').text(result.total);
                    $('.js-button-order').hide();
                  } 
                  else 
                  {
                    window.location.href = reponse_momo.payUrl;
                  }
              } 
              else if (typeof(result.reponse_nganluong) != "undefined") 
              {
                  if (result.reponse_nganluong.error_code != '00') 
                  {
                    $('#error-ordered-online .name_user').text(result.name);
                    $('#error-ordered-online .js-swap-order-item').html('');
                    $.each(result.data, function( index, value ) {
                        var templateHtml = $('#js-ordered-item').html();
                        var appendEditData = templateHtml
                              .replace('{{SHO_LINK}}', value.sho_link)
                              .replace('{{SHO_NAME}}', value.sho_name)
                              .replace('{{ORDER_ID}}', value.order_id)
                              .replace('{{ORDER_LINK}}', value.order_link);
                        $('#error-ordered-online .js-swap-order-item').append(appendEditData);
                    });
                    $('#error-ordered-online').modal({
                          backdrop: 'static',
                          keyboard: true, 
                          show: true
                    });
                    $('.cartNum').text(result.total);
                    $('.js-button-order').hide();
                  } 
                  else 
                  {
                    window.location.href = result.reponse_nganluong.checkout_url;
                  }
              } 
              else if (result.error == false) 
              {
                  $('#successfully-ordered .name_user').text(result.name);
                  $('#successfully-ordered .js-swap-order-item').html('');
                  $.each(result.data, function( index, value ) {
                      var templateHtml = $('#js-ordered-item').html();
                      var appendEditData = templateHtml
                            .replace('{{SHO_LINK}}', value.sho_link)
                            .replace('{{SHO_NAME}}', value.sho_name)
                            .replace('{{ORDER_ID}}', value.order_id)
                            .replace('{{ORDER_LINK}}', value.order_link);
                      $('#successfully-ordered .js-swap-order-item').append(appendEditData);
                  });
                  $('#successfully-ordered').modal({
                        backdrop: 'static',
                        keyboard: true, 
                        show: true
                  });
                  $('.cartNum').text(result.total);
                  $('.js-button-order').hide();
              }
            }
      }).always(function() {
          $('.load-wrapp').hide();
      });
  });

  $('.selectTypeShip-table .js-get-fee').on('change', function(){
      var fee_add = $('.selectTypeShip-table .js-get-fee:checked').val();
      $('.js-company-fee').val(fee_add);
      var shop_id = $(this).attr('data-key'); 
      var fee_name = $('.selectTypeShip-table .js-get-fee:checked').attr('data-name');
      var fee_price = $('.selectTypeShip-table .js-get-fee:checked').attr('data-fee');
      var fee_time = $('.selectTypeShip-table .js-get-fee:checked').attr('data-time');
      if (fee_add == 'SHO') 
      {
        $('.js-name-fee').text('Shop giao');
        $('.js-type-ship-' + shop_id).text('Shop giao');
        $('.js-shipping-' + shop_id).text('-');
        $('.js-time-shipping-' + shop_id).text('-');
        $('.input-total-ship-' + shop_id).val('0');
      } else {
        $('.js-name-fee').text(fee_name);
        $('.js-type-ship-' + shop_id).text(fee_name);
        $('.js-shipping-' + shop_id).text($.fn.number(fee_price));
        $('.js-time-shipping-' + shop_id).text(fee_time);
        $('.input-total-ship-' + shop_id).val(fee_price);
      }
      total_order();
  });

  $('.load-wrapp').show();
  $(window).on('load', function() {
      $('.selectTypeShip-table .js-get-fee:not(:disabled):first').prop('checked', true).trigger('change');
      $('.load-wrapp').hide();
  });

  function check_price() 
  {
    var list = $('.js-div-total-shop');
    var total = 0;
    $.each(list, function( index, value ) {
        var key_shop = $(this).attr('data-id');
        total = parseInt($('.input-total-'+ key_shop).val()) - parseInt($('.input-total-voucher-'+ key_shop).val());
    });
    var payment_method = $('input[type=radio][name=payment_method]:checked').val();
    if (payment_method == 'info_cod') 
    {
        if (total > 50000) 
        {
          $('.selectTypeShip-table tr.shop_shipping').hide();
          $('.selectTypeShip-table tr.shop_shipping .js-get-fee').prop("disabled", true);
          $('.selectTypeShip-table tr.nhanh_shipping').show();
          $('.selectTypeShip-table tr.nhanh_shipping .js-get-fee').prop("disabled", false);
        }
        else 
        {
          $('.selectTypeShip-table tr.nhanh_shipping').hide();
          $('.selectTypeShip-table tr.nhanh_shipping .js-get-fee').prop("disabled", true);
          $('.selectTypeShip-table tr.shop_shipping').show();
          $('.selectTypeShip-table tr.shop_shipping .js-get-fee').prop("disabled", false);
        }
        $('.selectTypeShip-table .js-get-fee:not(:disabled):first').prop('checked', true).trigger('change');
    }
  }

  $('input[type=radio][name=payment_method]').change(function() {
    $('.select-banks').hide();
    $('.select-visa').hide();
    var nhanh_shipping = $('.selectTypeShip-table tr.nhanh_shipping').length;

    if (nhanh_shipping > 0) 
    {
      var list = $('.js-div-total-shop');
      var total = 0;
      $.each(list, function( index, value ) {
          var key_shop = $(this).attr('data-id');
          total = parseInt($('.input-total-'+ key_shop).val()) - parseInt($('.input-total-voucher-'+ key_shop).val());
      });
      switch (this.value) {
        case 'info_nganluong_bank':
            $('.select-banks').show();
            $('.selectTypeShip-table tr.nhanh_shipping').hide();
            $('.selectTypeShip-table tr.nhanh_shipping .js-get-fee').prop("disabled", true);
            $('.selectTypeShip-table tr.shop_shipping').show();
            $('.selectTypeShip-table tr.shop_shipping .js-get-fee').prop("disabled", false);
          break;
        case 'info_nganluong_visa':
            $('.select-visa').show();
            $('.selectTypeShip-table tr.nhanh_shipping').hide();
            $('.selectTypeShip-table tr.nhanh_shipping .js-get-fee').prop("disabled", true);
            $('.selectTypeShip-table tr.shop_shipping').show();
            $('.selectTypeShip-table tr.shop_shipping .js-get-fee').prop("disabled", false);
          break;
        case 'info_momo':
            $('.selectTypeShip-table tr.nhanh_shipping').hide();
            $('.selectTypeShip-table tr.nhanh_shipping .js-get-fee').prop("disabled", true);
            $('.selectTypeShip-table tr.shop_shipping').show();
            $('.selectTypeShip-table tr.shop_shipping .js-get-fee').prop("disabled", false);
          break;
        case 'info_cod':
            if (total > 50000) 
            {
              $('.selectTypeShip-table tr.shop_shipping').hide();
              $('.selectTypeShip-table tr.shop_shipping .js-get-fee').prop("disabled", true);
              $('.selectTypeShip-table tr.nhanh_shipping').show();
              $('.selectTypeShip-table tr.nhanh_shipping .js-get-fee').prop("disabled", false);
            }
            else 
            {
              $('.selectTypeShip-table tr.nhanh_shipping').hide();
              $('.selectTypeShip-table tr.nhanh_shipping .js-get-fee').prop("disabled", true);
              $('.selectTypeShip-table tr.shop_shipping').show();
              $('.selectTypeShip-table tr.shop_shipping .js-get-fee').prop("disabled", false);
            }
          break;
      }
      $('.selectTypeShip-table .js-get-fee:not(:disabled):first').prop('checked', true).trigger('change');
    } 
    else 
    {
      switch (this.value) {
        case 'info_nganluong_bank':
            $('.select-banks').show();
          break;
        case 'info_nganluong_visa':
            $('.select-visa').show();
          break;
      }
    }
  });

  // add voucher
  
  $('.js-add-voucher').click(function() {
      var voucher = $('.js-get-voucher').val();
      var key_order = $('#frmShowCart .js-key').val();
      if ($.trim(voucher) != '') 
      {
        if ($.trim(voucher) != '') 
        {
          $('.load-wrapp').show();
          $.ajax({
                type: "POST",
                url: "/v-checkout/get-voucher",
                dataType: 'json',
                data : {voucher:voucher, key_order:key_order},
                success: function(result) {
                  if(result.error == false) 
                  {
                      var template_voucher = $('#js-voucher-template').html();
                      template_voucher = template_voucher.replace(/{{VOUCHER}}/g, voucher);
                      $('.addCodeCoupon-showCodes').append(template_voucher);
                      $('#addCodeCoupon').find('.js-choose-voucher[data-value="'+voucher+'"]').text('Đã chọn');
                      $('#addCodeCoupon').find('.js-choose-voucher[data-value="'+voucher+'"]').removeClass('btn-use');
                      $('#addCodeCoupon').find('.js-choose-voucher[data-value="'+voucher+'"]').addClass('btn-used');
                      var total_voucher = $('.addCodeCoupon-showCodes .item').length;
                      if (total_voucher == 0) 
                      {
                        $('.js-show-text-voucher').text('');
                      }
                      else 
                      {
                        $('.js-show-text-voucher').text('Bạn đang sử dụng '+ total_voucher +' mã giảm giá');
                      }
                      $('.input-total-voucher-'+ result.shop_id).val(result.total_price_voucher);
                      total_order();
                      check_price();
                  } 
                  else 
                  {
                    $('.js-get-msg-voucher').text(result.msg);
                    $('#messVoucher').modal('show');
                  }
                }
          }).always(function() {
              $('.load-wrapp').hide();
          });
        }
      }
  });

  $('.js-choose-voucher').click(function() {
    var voucher = $(this).attr('data-value');
    var key_order = $('#frmShowCart .js-key').val();
    var _this = $(this);
    if ($.trim(voucher) != '' && $(this).hasClass('btn-use')) 
    {
      $('.load-wrapp').show();
      $.ajax({
            type: "POST",
            url: "/v-checkout/get-voucher",
            dataType: 'json',
            data : {voucher:voucher, key_order:key_order},
            success: function(result) {
              if(result.error == false) 
              {
                  var template_voucher = $('#js-voucher-template').html();
                  template_voucher = template_voucher.replace(/{{VOUCHER}}/g, voucher);
                  $('.addCodeCoupon-showCodes').append(template_voucher);
                  $(_this).text('Đã chọn');
                  $(_this).removeClass('btn-use');
                  $(_this).addClass('btn-used');
                  var total_voucher = $('.addCodeCoupon-showCodes .item').length;
                  if (total_voucher == 0) 
                  {
                    $('.js-show-text-voucher').text('');
                  }
                  else 
                  {
                    $('.js-show-text-voucher').text('Bạn đang sử dụng '+ total_voucher +' mã giảm giá');
                  }
                  $('.input-total-voucher-'+ result.shop_id).val(result.total_price_voucher);
                  total_order();
                  check_price();
              } 
              else 
              {
                $('.js-get-msg-voucher').text(result.msg);
                $('#messVoucher').modal('show');
              }
            }
      }).always(function() {
          $('.load-wrapp').hide();
      });
    }
  });

  $('body').on('click', '.js-remove-voucher', function() {
    var voucher = $(this).attr('data-value');
    var key_order = $('#frmShowCart .js-key').val();
    var _this = $(this);
    console.log(voucher);
    if ($.trim(voucher) != '') 
    {
      $('.load-wrapp').show();
      $.ajax({
            type: "POST",
            url: "/v-checkout/remove-voucher",
            dataType: 'json',
            data : {voucher:voucher, key_order:key_order},
            success: function(result) {
              if(result.error == false) 
              {
                  $(_this).parent('p.item').remove();
                  var total_voucher = $('.addCodeCoupon-showCodes .item').length;

                  $('#addCodeCoupon').find('.js-choose-voucher[data-value="'+voucher+'"]').text('Sử dụng');
                  $('#addCodeCoupon').find('.js-choose-voucher[data-value="'+voucher+'"]').removeClass('btn-used');
                  $('#addCodeCoupon').find('.js-choose-voucher[data-value="'+voucher+'"]').addClass('btn-use');


                  if (total_voucher == 0) 
                  {
                    $('.js-show-text-voucher').text('');
                  }
                  else 
                  {
                    $('.js-show-text-voucher').text('Bạn đang sử dụng '+ total_voucher +' mã giảm giá');
                  }
                  $('.input-total-voucher-'+ result.shop_id).val(result.total_price_voucher);

                  total_order();
                  check_price();
              } 
              else 
              {
                $('.js-get-msg-voucher').text(result.msg);
                $('#messVoucher').modal('show');
              }
            }
      }).always(function() {
          $('.load-wrapp').hide();
      });
    }
  });
  

</script>




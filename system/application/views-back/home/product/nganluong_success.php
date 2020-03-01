
<?php $this->load->view('home/common/header'); ?>
<?php $this->load->view('home/common/left'); ?>

<!--BEGIN: RIGHT-->

<div class="add_money_content col-lg-9">
    <div class="tile_modules tile_modules_blue row">
        Hoàn tất đơn hàng
    </div>

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
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">Thông tin người đặt hàng</h3>
            </div>
            <table  cellspacing="0" cellpadding="0" align="center" class="table table-bordered">
                <tbody>
                <tr>
                    <td width="30%">Tên người đặt hàng :</td>
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

        <div class="panel panel-primary">
            <div class="panel-heading">

                <h3 class="panel-title">Thông tin người nhận hàng</h3>
            </div>
            <table  cellspacing="0" cellpadding="0" align="center" class="table table-bordered">
                <tbody>
                <tr>
                    <td width="30%">Tên người đặt hàng :</td>
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
        <div class="text-center">
            <ul class="list-group col-lg-4">
                <li class="list-group-item active"> Thông tin thanh toán </li>

                <li class="list-group-item">Thanh toán thông qua Ngân Lượng với hình thức: </li>
                <?php
                $nganhang = array(
                    'VCB'  =>	'Ngân hàng TMCP Ngoại Thương Việt Nam (Vietcombank)',
                    'DAB'  =>	'Ngân hàng TMCP Đông Á (DongA Bank)',
                    'TCB'  =>	'Ngân hàng TMCP Kỹ Thương (Techcombank)',
                    'MB'  =>	'Ngân hàng TMCP Quân Đội (MB)',
                    'VIB'  =>	'Ngân hàng TMCP Quốc tế (VIB)',
                    'VTB'  =>	'Ngân hàng TMCP Công Thương (VietinBank)',
                    'EXB'  =>	'Ngân hàng TMCP Xuất Nhập Khẩu (Eximbank)',
                    'ACB'  =>	'Ngân hàng TMCP Á Châu (ACB)',
                    'HDB'  =>	'Ngân hàng TMCP Phát Triển Nhà TP. Hồ Chí Minh (HDBank)',
                    'MSB'  =>	'Ngân hàng TMCP Hàng Hải (MariTimeBank)',
                    'NVB'  =>	'Ngân hàng TMCP Nam Việt (NaviBank)',
                    'VAB'  =>	'Ngân hàng TMCP Việt Á (VietA Bank)',
                    'VPB'  =>	'Ngân hàng TMCP Việt Nam Thịnh Vượng  (VPBank)',
                    'SCB'  =>	'Ngân hàng TMCP Sài Gòn Thương Tính (Sacombank)',
                    'GPB'  =>	'Ngân hàng TMCP Dầu Khí (GPBank)',
                    'AGB'  =>	'Ngân hàng Nông nghiệp và Phát triển Nông thôn (Agribank)',
                    'BIDV'  => 'Ngân hàng Đầu tư và Phát triển Việt Nam (BIDV)',
                    'OJB'  =>	'Ngân hàng TMCP Đại Dương (OceanBank)',
                    'PGB'  =>	'Ngân Hàng TMCP Xăng Dầu Petrolimex (PGBank)'
                );
                switch ($nl_result->payment_method) {
                    case "VISA":
                        echo ' <li class="list-group-item">Thanh toán bằng thẻ Visa hoặc MasterCard</li>';
                    break;
                    case "NL":
                        echo ' <li class="list-group-item">Thanh toán bằng Ví điện tử NgânLượn </li>';
                    break;
                    case "ATM_ONLINE":
                        echo ' <li class="list-group-item">Thanh toán online bằng thẻ ngân hàng nội địa</li>'
                            . ' <li class="list-group-item">'.$nganhang[$nl_result->bank_code].'</li>';

                     break;
                }


                ?>
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


        </div>
        <a class="btn btn-success pull-right" href="<?php echo base_url()?>account/user_order">Quay về danh sách đơn đặt hàng</a>


    <!--END RIGHT-->
    <?php $this->load->view('home/common/footer'); ?>

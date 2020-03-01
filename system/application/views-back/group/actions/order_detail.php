<?php $this->load->view('group/common/header'); ?>
<style>
    .detailorder table tr td {
	vertical-align: middle !important
    }
</style>
<br>
<div id="main" class="container-fluid">
        <div class="row">
            <div class="col-md-3 sidebar">
                <?php $this->load->view('group/common/menu'); ?>
            </div>
            <div class="col-md-9 main">
		<h4 class="page-header text-uppercase" style="margin-top:10px">Chi tiết đơn hàng</h4>
                <div class="dashboard detailorder">
                    <!-- ========================== Begin Content ============================ -->
                    
                    <div style="background:#fff; padding: 15px; margin-bottom: 30px">
                        <div class="row">
                            <div class="col-sm-4 text-uppercase">
                                <p><b>Đơn hàng: <span
                                            class="text-danger">#<?php echo $list_product[0]->shc_orderid; ?></span></b>
                                </p>
                            </div>
                            <div class="col-sm-4 text-uppercase">
                                <p><b>Trạng thái:
                                        <?php
                                        switch ($list_product[0]->order_status) {
                                            case '01':
                                                echo '<span class="text-primary">' . status_1 . '</span>';
                                                break;
                                            case '02':
                                                echo '<span class="text-primary">' . status_2 . '</span>';
                                                break;
                                            case '03':
                                                echo '<span class="text-primary">' . status_3 . '</span>';
                                                break;
                                            case '04':
                                                echo '<span class="text-primary">' . status_4 . '</span>';
                                                break;
                                            case '05':
                                                echo '<span class="text-primary">' . status_5 . '</span>';
                                                break;
                                            case '06':
                                                echo '<span class="text-primary">' . status_6 . '</span>';
                                                break;
                                            case '99':
                                                echo '<span class=text-danger">' . status_99 . '</span>';
                                                break;
                                            case '98':
                                                echo '<span class="text-primary">' . status_98 . '</span>';
                                                break;
                                            default:
                                                echo '<span class="label label-danger">Unknow</span>';
                                                break;
                                        }
                                        ?></b></p>
                            </div>
                            <div class="col-sm-4 text-uppercase">
                                <p><b>Vận đơn: <span class="text-success">#<?php echo $list_product[0]->order_clientCode; ?></span></b>
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <p>
                                    <i class="fa fa-calendar fa-fw"></i> Ngày đặt hàng:
                                    <b><?php echo date('d/m/Y H:m:i', $list_product[0]->shc_buydate); ?></b>
                                </p>
                            </div>
                            <div class="col-sm-6">
                                <p><i class="fa fa-truck fa-fw"></i> Nhà vận chuyển: <b>
                                        <?php
                                        switch ($list_product[0]->shipping_method) {
                                            case 'GHN':
                                                echo 'Giao hàng nhanh';
                                                break;
                                            case 'VNPT':
                                                echo 'VNPT';
                                                break;
                                            case 'VTP':
                                                echo 'Viettel Post';
                                                break;
                                            case 'GHTK':
                                                echo 'Giao hàng tiết kiệm';
                                                break;
                                            case 'SHO':
                                                echo 'Shop giao';
                                                break;
                                            default:
                                                echo 'Đơn hàng Coupon';

                                        } ?>    </b></p>
                            </div>
                            <div class="col-sm-6">
                                <p>
                                    <i class="fa fa-money fa-fw"></i> Thanh toán:
                                    <b>
                                        <?php
                                        switch ($list_product[0]->payment_method) {
                                            case 'info_nganluong':
                                                echo 'Thanh toán qua Ngân Lượng';
                                                break;
                                            case 'info_cod':
                                                echo 'Thanh toán khi nhận hàng';
                                                break;
                                            case 'info_bank':
                                                echo 'Chuyển khoản qua ngân hàng';
                                                break;
                                            case 'info_cash':
                                                echo 'Thanh toán tiền mặt tại quầy';
                                                break;

                                        } ?>
                                    </b>
                                </p>
                            </div>
                            <?php $user_ship = reset($list_product); ?>
                            <div class="col-sm-6">
                                <p><i class="fa fa-user fa-fw"></i> Người nhận:
                                    <b><?php echo $user_ship->ord_sname; ?></b></p>
                            </div>
                            <?php if ($list_product[0]->pro_type != 2) { ?>
                                <div class="col-sm-6">
                                    <p><i class="fa fa-map-marker fa-fw"></i> Địa chỉ:
                                        <b><?php echo $user_ship->ord_saddress . ', ' . $_district . ', ' . $_province; ?></b>
                                    </p>
                                </div>
                            <?php } ?>

                            <div class="col-sm-6">
                                <p><i class="fa fa-phone fa-fw"></i> Điện thoại:
                                    <b><?php echo $user_ship->ord_smobile; ?></b></p>
                            </div>
                            <div class="col-sm-6">
                                <p><i class="fa fa-envelope fa-fw"></i> Email:
                                    <b><?php echo $user_ship->ord_semail; ?></b></p>
                            </div>
                            <div class="col-sm-6 text-left">
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered" style="background: #fff;">
                                <tbody>
                                <tr>
                                    <th width="" class="text-center">Hình ảnh</th>
                                    <th width="" class="text-center">Thông tin sản phẩm</th>
                                    <th width="" class="text-center">Trọng lượng</th>
                                    <th width="" class="">SL</th>
                                    <th width="" class="text-left">Tình trạng</th>
                                    <th width="" class="text-center">Đơn giá (VNĐ)</th>
                                    <th width="110" class="text-center">Thành tiền</th>
                                </tr>
                                <?php
                                $i = 1;
                                $total = 0;
                                $order_status = NULL;
                                $count_qty = 0;
                                $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                                $duoi = '.' . substr(base_url(), strlen($protocol), strlen(base_url()));
                                foreach ($list_product as $k => $product):
                                    $promotions = $this->product_promotion_model->getPromotion(array('pro_id' => $product->pro_id));

                                    $order_status = $product->order_status;
                                    $total_amount = $product->pro_price * $product->shc_quantity;
                                    $total += $total_amount;
                                    $count_qty += $product->shc_quantity;
                                    $cart[] = $product->shc_id;

                                    if ($product->pro_type == 2) {
                                        $pro_type = 'coupon';
                                    } else {
                                        if ($product->pro_type == 0) {
                                            $pro_type = 'product';
                                        }
                                    }
                                    if ($product->shc_dp_pro_id > 0) {
                                        $filename = 'media/images/product/' . $product->pro_dir . '/thumbnail_1_' . $product->dp_images;
                                    } else {
                                        $filename = 'media/images/product/' . $product->pro_dir . '/thumbnail_1_' . $product->pro_image;
                                    }

                                    $get_domain = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'sho_user = "' . $product->shc_saler . '"');

                                    $shop = $protocol . $get_domain[0]->sho_link . $duoi . 'shop/';
                                    if ($get_domain[0]->domain != '') {
                                        $shop = $protocol . $get_domain[0]->domain . '/shop/';
                                    }

                                    ?>
                                    <tr>
                                        <td class="line_showcart_0">
                                            <a class="menu_1" target="_blank"
                                               href="<?php echo $shop . $pro_type . '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name); ?>">
                                                <?php
                                                if ($product->pro_name != '') { //file_exists($filename) && $filename != ''
                                                ?>
                                                <img width="80" src="<?php echo DOMAIN_CLOUDSERVER . $filename; ?>"/>
                                                <?php } else { ?>
                                                    <img width="80"
                                                         src="<?php echo base_url(); ?>media/images/no_photo_icon.png"/>
                                                <?php } ?>
                                            </a>
                                        </td>
                                        <td class="line_showcart_1">
                                            <a class="menu_1" target="_blank"
                                               href="<?php echo $shop . $pro_type . '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name); ?>">
                                                <?php
                                                if (isset($product->pro_sku) && $product->pro_sku != '') {
                                                    echo $product->pro_sku . ' - ';
                                                }
                                                echo sub($product->pro_name, 100); ?>
                                            </a>
                                            <div class="small">
                                                <p style="font-size: 13px">
                                                    <i>Gian hàng:
                                                        <a target="_blank" href="<?php echo $shop; ?>">
                                                <span class="text-primary" style="color:#ff0202"><?php
                                                    echo $get_domain[0]->sho_link; ?></span></a></i>
                                                </p>
                                            </div>
                                        </td>
                                        <td class="line_showcart_2" style="text-align: right;">
                                            <span>
                                                <?php echo $product->pro_weight; ?>g
                                            </span>
                                        </td>
                                        <td class="text-center"><?php echo $product->shc_quantity; ?></td>
                                        <td class="" style="text-align: center;">
                                    <span class="text-success">
                                    <?php 
                                    if (isset($product->pro_instock) && $product->pro_instock > 0) {
                                        echo '<span class="text-success"><i class="fa fa-check-square-o"></i> Còn hàng</span>';
                                    } else {
                                        echo '<span class="text-danger"> Hết hàng</span>';
                                    }
                                    ?>
                                        </td>
                                        <td class="" style="text-align: right;">
                                            <?php
                                            $total_pro = $total_amount;
                                            if ($product->em_discount > 0) {
                                                $total_pro = $total_amount - $product->em_discount;
                                            }
                                            ?>
                                            <span class="product_price">
                                                <?php echo number_format($total_pro, 0, ',', '.'); ?> đ
                                            </span>
                                        </td>
                                        <?php
                                        $tongDT += $product->shc_total;//$product->order_total_no_shipping_fee
                                        ?>
                                        <td valign="top" style="text-align: right;">
                                            <strong class="text-danger">
                                                <?php echo number_format($product->shc_total, 0, ',', '.') ?> đ
                                            </strong>
                                        </td>
                                    </tr>
                                    <style>
                                        .col1 {
                                            float: right;
                                            margin-right: 20px;
                                            text-align: center;
                                            font-size: 13px;
                                        }
                                    </style>
                                    <?php
                                    if ($product->af_id > 0 || ($product->pro_price_rate > 0 || $product->pro_price_amt > 0) || ($product->em_discount > 0)) { ?>
                                        <tr>
                                            <td colspan="7">
                                                <?php
                                                if ($product->af_id > 0) {
                                                    ?>
                                                    <div class="col1">
                                                        <?php
                                                        if ($product->af_amt > 0) {
                                                            $type = 'đ';
                                                        } else {
                                                            $type = '%';
                                                        }
                                                        ?>
                                                        Hoa hồng CTV:
                                                        <?php if ($product->af_rate > 0):
                                                            $hoahong = $product->af_rate;
                                                            $moneyShop += $total_amount * ($hoahong / 100);
                                                            ?>

                                                            <span
                                                                class="text-success text-right"><?php echo number_format($product->af_rate, 0, ",", "."); ?>
                                                                <?php echo $type ?></span>
                                                        <?php else: $moneyShop += $product->af_amt * $product->shc_quantity; ?>
                                                            <span
                                                                class="text-success text-right"><?php echo number_format($product->af_amt, 0, ",", "."); ?>
                                                                <?php echo $type ?></span>
                                                        <?php endif; ?>
                                                        <?php //} ?>
                                                    </div>
                                                    <div class="col1">
                                                        <?php
                                                        if ($product->af_dc_amt > 0) {
                                                            $type = 'đ';
                                                        } else {
                                                            $type = '%';
                                                        }
                                                        ?>
                                                        Giảm qua CTV:
                                                        <?php if ($product->af_dc_amt > 0): ?>
                                                            <span
                                                                class="text-success text-right"><?php echo number_format($product->af_dc_amt, 0, ",", "."); ?>
                                                                <?php echo $type ?></span>
                                                        <?php else: ?>
                                                            <span
                                                                class="text-success text-right"><?php echo number_format($product->af_dc_rate, 0, ",", "."); ?>
                                                                <?php echo $type ?></span>
                                                        <?php endif; ?>
                                                    </div>
                                                <?php } ?>
                                                <?php
                                                if ($product->pro_price_rate > 0 || $product->pro_price_amt > 0) { ?>
                                                    <div class="col1">
                                                        Khuyến mãi:
                                                        <?php if (!empty($product->pro_price_rate)): ?>
                                                            <span
                                                                class="text-success text-right"><?php echo number_format($product->pro_price_rate, 0, ",", "."); ?>
                                                                %</span>
                                                        <?php else: ?>
                                                            <span
                                                                class="text-success text-right"><?php echo number_format($product->pro_price_amt, 0, ",", "."); ?>
                                                                đ</span>
                                                        <?php endif; ?>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if ($product->em_discount > 0) {
                                                    ?>
                                                    <div class="col1">
                                                        Giảm giá sỉ:
                                                        <span
                                                            class="text-success text-right"><?php echo number_format($product->em_discount, 0, ",", "."); ?>
                                                            đ</span>
                                                    </div>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right" style="padding: 0 10px">
                            <p>Tổng doanh thu đơn hàng: <span class="pull-right text-danger"
                                                              style="width: 100px"><b><?php echo number_format($tongDT, 0, ',', '.') ?>
                                        đ</b></span></p>
                            <p>Tổng hoa hồng CTV: <span class="pull-right text-danger"
                                                        style="width: 100px"><b><?php echo number_format($moneyShop, 0, ',', '.') ?>
                                        đ</b></span></p>
                            <p>Phí vận chuyển: <span class="pull-right text-danger"
                                                     style="width: 100px"><b><?php echo number_format($product->shipping_fee, 0, ',', '.') ?>
                                        đ</b></span></p>
                            <p>Tổng thanh toán cho shop: <span class="pull-right text-danger" style="width: 100px"><b>
                                <?php $toltalShop = $tongDT - $moneyShop;
                                echo number_format($toltalShop, 0, ',', '.') ?> đ</b></span></p>
                            <div><b>***Lưu ý: Chưa trừ hoa hồng azibai</b></div>
                        </div>
                    </div>
                    <!-- ========================== End Content ============================ -->
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('group/common/footer'); ?>
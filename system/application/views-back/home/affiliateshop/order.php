<?php $this->load->view('home/common/account/header'); ?>
<style>
td {
    border-top: none !important;
}
</style>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
	<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">
		Chi tiết đơn hàng
	    </h4>
	    <?php if ($this->session->flashdata('flash_message_success') || $this->session->flashdata('flash_message_error')) { ?>
    	    <div class="message success">
    		<div class="alert <?php echo($this->session->flashdata('flash_message_error') ? 'alert-danger' : 'alert-success') ?>">
		    <?php echo($this->session->flashdata('flash_message_error') ? $this->session->flashdata('flash_message_error') : $this->session->flashdata('flash_message_success')); ?>
    		    <button type="button" class="close" data-dismiss="alert">×</button>
    		</div>
    	    </div>
	    <?php } ?>
	    <table cellspacing="0" class="table small" width="100%" border="0">
		<tbody>
		    <tr>
			<td class="text-uppercase" colspan="2">
			    <b>Đơn hàng: </b>
			    <span class="text-danger">
				<b>#<?php echo $order_detail[0]->id; ?></b>
			    </span>
			</td>
			<td class="text-uppercase" align="center" colspan="3">
			    <b>Trạng thái:
				
                                <?php
                                switch ($order_detail[0]->order_status) {
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
                                ?>
			    </b>
			</td>
                        <?php
                        if($order_detail[0]->order_clientCode != ''){ ?>
			<td class="text-uppercase" align="right" colspan="2">
			    <b>Vận đơn:</b>
			    <span class="text-success">
				<b>#<?php echo $order_detail[0]->order_clientCode; ?></b>
			    </span>
			</td>
                        <?php } ?>
		    </tr>
		    <tr class="tr_title_order">
			<td colspan="7">
			    <div class="row">
				<div class="col-sm-4">
				    <p>
					<i class="fa fa-clock-o fa-fw"></i> Ngày đặt:
					<b><?php echo date('d/m/Y H:m:i', $order_detail[0]->shc_buydate); ?></b>
				    </p>
				</div>
				<div class="col-sm-3">
                                <?php if ($order_detail[0]->order_coupon_code == '') { ?>
                                    <p><i class="fa fa-truck"></i> Nhà vận chuyển: <b>
                                            <?php
                                            switch ($order_detail[0]->shipping_method) {
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

                                            } ?>
                                    </b></p>
                                <?php } ?>
				</div>
				<div class="col-sm-5">
				    <p>
					<i class="fa fa-money fa-fw"></i> Hình thức thanh toán:
					<b>
                                            <?php
                                            switch ($order_detail[0]->payment_method) {
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
			    </div>
                            <?php if (isset($order_detail[0]->order_status) && $order_detail[0]->order_status == 99) { ?>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <p><i class="fa fa-calendar"></i> Ngày hủy:
                                            <?php if ($order_detail[0]->cancel_date) {
                                                echo date('d/m/Y', $order_detail[0]->cancel_date);
                                            } else {
                                                echo date('d/m/Y', $order_detail[0]->change_status_date);
                                            }
                                            ?>
                                        </p>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php if (!empty($order_detail[0]->cancel_reason)) { ?>
                                            <p><i class="fa fa-thumbs-o-down"></i> Lý do
                                                hủy: <?php echo $order_detail[0]->cancel_reason; ?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="row">
                                <?php if($order_detail[0]->pro_type != 2){ ?>
                                <div class="col-sm-4">
                                    <p><i class="fa fa-user"></i> Người nhận:
                                        <b><?php echo $order_detail[0]->ord_sname; ?></b></p>
                                </div>
                                <div class="col-sm-8">
                                    <p><i class="fa fa-home"></i> Địa chỉ:
                                        <b><?php echo $order_detail[0]->ord_saddress.', '.$_district.', '.$_province; ?></b></p>
                                </div>
                                <?php }
                                else{ ?>
                                    <div class="col-sm-12">
                                        <p><i class="fa fa-user"></i> Người nhận:
                                            <b><?php echo $order_detail[0]->ord_sname; ?></b></p>
                                    </div>
                                <?php } ?>
                            </div>
			    <div class="row">
				<div class="col-sm-4">
				    <p>
					<i class="fa fa-phone fa-fw"></i> Điện thoại:
					<b><?php echo $order_detail[0]->ord_smobile; ?></b>
				    </p>
				</div>
				<div class="col-sm-8">
				    <p>
					<i class="fa fa-envelope fa-fw"></i> Email:
					<b><?php echo $order_detail[0]->ord_semail; ?></b>
				    </p>
				</div>
                                <div class="col-sm-5 text-left">
                                    <?php
                                    if ($order_detail[0]->payment_method == 'info_nganluong') {
                                        if ($order_detail[0]->payment_status == 1 && $order_detail[0]->payment_method == 'info_nganluong') { ?>
                                            <p><i class="fa fa-money"></i> Thanh toán: <span
                                                    class="text-success"><b>Đã thanh toán</b></span></p>
                                        <?php } else { ?>
                                            <p><i class="fa fa-money"></i> Thanh toán: <span
                                                    class="text-danger"><b>Chưa thanh toán</b></span></p>
                                        <?php }
                                    } ?>
                                </div>
			    </div>
			</td>
		    </tr>
                    <?php if (isset($order_detail[0]->ord_note) && $order_detail[0]->ord_note != '') { ?>
                        <tr>
                            <td colspan="7">
                                <i><b>Ghi chú: <?php echo $order_detail[0]->ord_note; ?></b></i>
                            </td>
                        </tr>
                    <?php } ?>
		    <tr>
			<th width="80" class="line_showcart_0 text-center">Hình ảnh</th>
			<th class="line_showcart_1 text-center">Thông tin SP</th>
			<th class="line_showcart_2 text-center">Trọng lượng</th>
			<th class="line_showcart_3 text-center">Số lượng</th>
			<!--<th width="11%" class="line_showcart_4 hidden-xs">Tình trạng</th>-->
			<th width="100" class="line_showcart_4 text-center">Đơn giá (VNĐ)</th>
			<th width="120" class="line_showcart_5 text-center">Khuyến mãi</th>                        
                        <th width="120" class="line_showcart_6 text-center">Giảm qua CTV</th>			
                        <th width="120" class="line_showcart_7 text-center">Thành tiền</th>
		    </tr>
                    <?php
                    $i = 1;
                    $total = 0;
                    $order_status = NULL;
                    $count_qty = 0;
                    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                    
                    foreach ($order_detail as $k => $item):
                        
                        $order_status = $item->order_status;
                        $total_amount = $item->pro_price * $item->shc_quantity;
                        $total += $total_amount;
                        $count_qty += $item->shc_quantity;
                        $cart[] = $item->shc_id;
                        if ($item->pro_type == 2) {
                            $pro_type = 'coupon';
                        } else {
                            if ($item->pro_type == 0) {
                                $pro_type = 'product';
                            }
                        }
                        $chitietsp = '';
                        if ($item->shc_dp_pro_id > 0) {
                            $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $item->pro_dir . '/thumbnail_1_' . $quycach[$item->shc_dp_pro_id]['dp_images'];
                        
                            if($quycach[$item->shc_dp_pro_id]['dp_color'] != ''){
                                $chitietsp = '<b>Màu:</b> <span style="color: #0308dc;">' . $quycach[$item->shc_dp_pro_id]['dp_color'] . '</span><br/>';
                            }
                            if($quycach[$item->shc_dp_pro_id]['dp_size'] != ''){
                                $chitietsp .= '<b>Kích thước:</b> <span style="color: #0308dc;">' . $quycach[$item->shc_dp_pro_id]['dp_size'] . '</span><br/>'; 
                            }
                            if($quycach[$item->shc_dp_pro_id]['dp_material'] != ''){
                                $chitietsp .= '<b>Chất liệu:</b> <span style="color: #0308dc;">' . $quycach[$item->shc_dp_pro_id]['dp_material'] . '</span><br/>';
                            }
                        } else {
                            $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $item->pro_dir . '/thumbnail_1_' . explode(',',$item->pro_image)[0];
                        }
                        ?>
		    <tr>
                        <td class="line_showcart_0" rowspan="3">
                            <a class="menu_1" target="_blank"
                               href="<?php echo $item->link_sp; ?>">
                                <?php
                                if ($quycach->dp_images != '' || $item->pro_name != '') { //file_exists($filename) && ?>
                                    <img width="80" src="<?php echo $filename; ?>"/>
                                <?php } else { ?>
                                    <img width="80" src="<?php echo base_url(); ?>media/images/no_photo_icon.png"/>
                                <?php } ?>
                            </a>
			</td>
			<td class="line_showcart_1" rowspan="3">
                            <a class="menu_1" target="_blank"
                               href="<?php echo $item->link_sp; ?>">
                                <?php
                                if (isset($item->pro_sku) && $item->pro_sku != '') {
                                    echo $item->pro_sku . ' - ';
                                }
                                echo sub($item->pro_name, 100); ?>
                            </a>
                            </br><?php echo $chitietsp?>
                            <?php
                            if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) { ?>
                                <p style="font-size: 13px">
                                    <i>Gian hàng:
                                        <a target="_blank" href="<?php echo $protocol . $sho_link; ?>/shop">
                                            <span class="text-primary" style="color:#ff0202">
                                                <?php echo $shop->sho_name; ?>
                                            </span>
                                        </a>
                                    </i>
                                </p>
                                <?php
                            }?>
			</td>
			<td class="line_showcart_2 text-center">
			    <span>
				<?php echo $item->pro_weight; ?>g
			    </span>
			</td>
			<td class="line_showcart_3 text-center"><?php echo $item->shc_quantity; ?></td>
                        <td class="line_showcart_4 text-center">
			    <span class="product_price">
				<?php echo number_format($item->pro_price_original, 0, ",", "."); ?> đ
			    </span>
			</td>
                        <td class="line_showcart_5 text-center">
                            <?php if ($item->pro_price_rate > 0 || $item->pro_price_amt > 0):?>
                                <?php if ($item->pro_price_rate > 0):?>
                                    <span><?php echo number_format($item->pro_price_rate, 0, ",", "."); ?> %</span>
                                <?php else: ?>
                                    <span><?php echo number_format($item->pro_price_amt, 0, ",", "."); ?> đ</span>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td class="line_showcart_6 text-center">
                            <?php
                            if ($item->affiliate_discount_amt > 0) {
                                $giamqctv = number_format($item->affiliate_discount_amt, 0, ",", ".") . ' đ';
                            } else {
                                $giamqctv = number_format($item->affiliate_discount_rate, 0, ",", ".") . ' %';
                            }
                            ?>
                            <span>
                                <?php echo $giamqctv ?>
                            </span>
                        </td>
                        <td class="line_showcart_7 text-center">
                            <?php
                            $total_pro = $total_amount;
                            if ($item->em_discount > 0) {
                                //$total_pro = $total_amount - $item->em_discount;
                            }
                            ?>
                            <span class="product_price">
                                <?php echo number_format($total_pro, 0, ',', '.'); ?> đ
                            </span>
                        </td>
		    </tr>
                    <tr class=" text-center" style="border:none;">
                        <td colspan="3" style="border:none;"></td>
			<td colspan="1" style="border:none;">
                            <?php
                            if ($item->af_id > 0) {
                                if ($item->af_amt > 0) {
                                    $type = 'đ';
                                } else {
                                    $type = '%';
                                }
                            ?>
                            
                            <?php echo 'Hoa hồng CTV:';
                            if ($item->af_rate > 0):
                                $hoahong = $item->af_rate;
                                $moneyShop += $total_amount * ($hoahong / 100);
                                $hoahongnhan = $total_pro * ($hoahong / 100);
                            else: 
                                $hoahong = number_format($item->af_amt, 0, ",", ".");
                                $moneyShop += $item->af_amt * $item->shc_quantity;
                                $hoahongnhan = $item->af_amt * $item->shc_quantity;
                            endif;
                            }
                            ?>
                        </td>
                        <td><span class="text-success"><?php echo $hoahong; ?><?php echo $type ?></span>
                        </td>
                        <td>
                            <span class="text-success"><?php echo number_format($hoahongnhan, 0, ",", "."); ?> đ</span>
                        </td>
		    </tr>
                    <tr class=" text-center" style="border:none;">
                        <?php
                        if ($item->em_discount > 0) {
                        ?>
                        <td colspan="4"></td>
                        <td colspan="1">Giảm giá sỉ:</td>
                        <td colspan="1">
                            <span style="color: #23527c;"><?php echo number_format($item->em_discount, 0, ",", "."); ?> đ</span>
                        </td>
                        <?php
                        }
                        ?>
                    </tr>
                    <?php
                    $tongDT += $item->shc_total;//$item->order_total_no_shipping_fee
                    endforeach;
                    ?>
		    <tr>
			<td align="right" colspan="10">
			    <p>Tổng doanh thu đơn hàng: 
				<span class="product_price">
				    <b><?php echo number_format($tongDT, 0, ',', '.') ?> đ</b>
				</span>
			    </p>
			    <p>Tổng hoa hồng CTV: 
				<span class="product_price">
				    <b><?php echo number_format($moneyShop, 0, ',', '.') ?> đ</b>
				</span>
			    </p>
			    <p>Phí vận chuyển: 
				<span class="product_price">
				    <b><?php echo number_format($item->shipping_fee, 0, ',', '.') ?> đ</b>
				</span>
			    </p>
                            <p class="td_total">Tổng thanh toán cho shop: 
				<span class="product_price">
				    <b>
                                    <?php
                                    $toltalShop = $tongDT + $item->shipping_fee - $moneyShop;
                                    echo number_format($toltalShop, 0, ',', '.') ?> đ
                                    </b>
				</span>
			    </p>
                            <p>
                                <span class="">
                                    <b>***Lưu ý: Chưa trừ hoa hồng azibai</b>
                                </span>
                            </p>
			</td>
		    </tr>
		</tbody>
	    </table>

	</div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>

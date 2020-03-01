<?php $this->load->view('home/common/account/header'); ?>
<?php  if($this->session->userdata('sessionGroup') == StaffStoreUser) {
    $parent_id = $this->user_model->get('parent_id','use_id = '. $this->session->userdata('sessionUser'))->parent_id;
}?>
<style>
    .td_title { font-weight: 800; }
    h2.page-title.text-uppercase { background: #ddd;padding: 10px;margin: 0;}
    #panel_order_af_detail {overflow: auto; background: #fff;padding: 10px;}
   .table-nobordered tr, .table-nobordered td{ border:0px !important;}
    .col1 {float: right;margin: 0 10px; width: 20%;}
    .col1 span {color: #0820d6;}
    .td_total {width: 40%;border-top: 1px solid #878487;padding: 0;padding-top: 0px;padding-top: 10px;}
 
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

            <div id="panel_order_af_detail">
		
                <table cellspacing="0" class="table" width="100%" border="0">
                    <tr>
                        <td class="text-uppercase" colspan="2"><b>Đơn hàng: </b><span
                                class="text-danger"><b>#<?php echo $list_product[0]->shc_orderid; ?></b></span></td>
                        <td class="text-uppercase" align="center" colspan="3">
                            <b>Trạng thái:
                                <?php switch ($list_product[0]->order_status) {
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
                        <td class="text-uppercase" align="right" colspan="2"><b>Vận đơn:</b> <span class="text-success"><b>#
                            <?php echo $list_product[0]->order_clientCode; ?>
                                </b></span></td>
                    </tr>
                    <tr class="tr_title_order">
                        <td colspan="6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <p>
                                        <i class="fa fa-clock-o fa-fw"></i> Ngày đặt hàng:
                                        <b><?php echo date('d/m/Y H:m:i', $list_product[0]->shc_buydate); ?></b>
                                    </p>
                                </div>
                                <?php if ($list_product[0]->order_coupon_code == '') { ?>
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
                                                       
                                                } ?>
                                            </b></p>
                                    </div>
                                    <?php
                                } ?>
                                <div class="col-sm-12">
                                    <p>
                                        <i class="fa fa-money fa-fw"></i> Hình thức thanh toán:
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
                            </div>
                            <?php if (isset($list_product[0]->order_status) && $list_product[0]->order_status == 99) { ?>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <p><i class="fa fa-calendar fa-fw"></i> Ngày hủy:
                                            <?php if ($list_product[0]->cancel_date) {
                                                echo date('d/m/Y', $list_product[0]->cancel_date);
                                            } else {
                                                echo date('d/m/Y', $list_product[0]->change_status_date);
                                            }
                                            ?>
                                        </p>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php if (!empty($list_product[0]->cancel_reason)) { ?>
                                            <p><i class="fa fa-thumbs-o-down"></i> Lý do
                                                hủy: <?php echo $list_product[0]->cancel_reason; ?></p>
                                        <?php } ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php $user_ship = reset($list_product); ?>
                            <div class="row">
                                <?php if($list_product[0]->pro_type != 2){ ?>
                                <div class="col-sm-4">
                                    <p><i class="fa fa-user fa-fw"></i> Người nhận:
                                        <b><?php echo $user_ship->ord_sname; ?></b></p>
                                </div>
                                <div class="col-sm-8">
                                    <p><i class="fa fa-home fa-fw"></i> Địa chỉ:
                                        <b><?php echo $user_ship->ord_saddress.', '.$_district.', '.$_province; ?></b></p>
                                </div>
                                <?php }
                                else{ ?>
                                    <div class="col-sm-12">
                                        <p><i class="fa fa-user fa-fw"></i> Người nhận:
                                            <b><?php echo $user_ship->ord_sname; ?></b></p>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p><i class="fa fa-phone fa-fw"></i> Điện thoại:
                                        <b><?php echo $user_ship->ord_smobile; ?></b></p>
                                </div>
                                <div class="col-sm-5">
                                    <p><i class="fa fa-envelope fa-fw"></i> Email:
                                        <b><?php echo $user_ship->ord_semail; ?></b></p>
                                </div>
                                <div class="col-sm-3 text-left">				    
                                    <?php
                                    if ($list_product[0]->payment_method == 'info_nganluong') {
                                        if ($list_product[0]->payment_status == 1 && $list_product[0]->payment_method == 'info_nganluong') { ?>
                                            <p><i class="fa fa-money fa-fw"></i> Thanh toán: <span
                                                    class="text-success"><b>Đã thanh toán</b></span></p>
                                        <?php } else { ?>
                                            <p><i class="fa fa-money fa-fw"></i> Thanh toán: <span
                                                    class="text-danger"><b>Chưa thanh toán</b></span></p>
                                        <?php }
                                    } ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php if (isset($user_ship->ord_note) && $user_ship->ord_note != '') { ?>
                        <tr>
                            <td colspan="6">
                                <i><b>Ghi chú: <?php echo $user_ship->ord_note; ?></b></i>
                            </td>
                        </tr>
                    <?php } ?>
		</table>
		<div class="table-responsive">
		    <table class="table table-nobordered" width="100%">		    
                    <tr style="border-bottom:1px solid #ddd !important;">
                        <th width="80" class="line_showcart_0">Hình ảnh</th>
                        <th class="line_showcart_1">Thông tin SP</th>
                        <?php if ($list_product[0]->pro_type == 0) {?>
                        <th class="line_showcart_2 text-center">Trọng lượng</th>
                        <?php } ?>
                        <th class="line_showcart_3 text-center">SL</th>
                        <th width="100" class="line_showcart_4 text-right">Đơn giá</th>
			<th width="120" class="line_showcart_5 text-right">Khuyến mãi</th>
                        <th width="120" class="line_showcart_6 text-right">Giảm qua CTV</th>
                        <th width="120" class="line_showcart_6 text-right">Giảm giá sỉ</th>
                        <th width="120" class="line_showcart_7 text-right">Thành tiền</th>
                    </tr>
                    <?php
                    $i = 1;
                    $total = 0;
                    $order_status = NULL;
                    $count_qty = 0;
                    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                    $duoi = '.' . $_SERVER['HTTP_HOST'];

                    foreach ($list_product as $k => $product):
			
                        $promotions = $this->product_promotion_model->getPromotion(array('pro_id' => $product->pro_id));

                        $order_status = $product->order_status;
                        $total_amount = $product->pro_price * $product->shc_quantity;
			
                        $total += $total_amount;
                        $count_qty += $product->shc_quantity;
                        $cart[] = $product->shc_id;

                        if ($product->pro_type == 2) {
                            $pro_type = 'coupon';
                            $colspan = 7;
                        } else {
                            if ($product->pro_type == 0) {
                                $pro_type = 'product';
                                $colspan = 8;
                            }
                        }
                        if ($product->shc_dp_pro_id > 0) {
                            $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_' . $product->dp_images;
                        } else {
                            $filename = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_' . explode(',',$product->pro_image)[0];
                        }
                        
                        
                        $get_domain = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'sho_user = "' . $product->shc_saler . '"');
                        $shop = $get_domain[0]->sho_link . $duoi;
                        if ($get_domain[0]->domain != '') {
                            $shop = $get_domain[0]->domain;
                        }
                                
                        if($product->order_group_id > 0){
                            $myGrt = $this->grouptrade_model->get('grt_link, grt_domain', 'grt_id = ' . (int)$product->order_group_id);
                            if($myGrt->grt_domain != ''){
                                $store = $myGrt->grt_domain;
                            }else{
                                $store = $myGrt->grt_link . $duoi;
                            }
                            $store .= '/grtshop/';
                        }else{
                            $store = $shop . '/shop/'; 
                        }
                        ?>
                       
                        <tr>
                            <td class="line_showcart_0" rowspan="2">
                                <a class="menu_1" target="_blank"
                                   href="<?php echo $protocol . $store . $pro_type . '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name); ?>">
                                    <?php
                                    if ($product->dp_images != '' || $product->pro_name != '') { //file_exists($filename) && ?>
                                        <img width="80" src="<?php echo $filename; ?>"/>
                                    <?php } else { ?>
                                        <img width="80" src="<?php echo base_url(); ?>media/images/no_photo_icon.png"/>
                                    <?php } ?>
                                </a>
                            </td>
                            <td class="line_showcart_1" rowspan="2">
                                <a class="menu_1" target="_blank"
                                   href="<?php echo $protocol . $store . $pro_type . '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name); ?>">
                                    <?php
                                    if (isset($product->pro_sku) && $product->pro_sku != '') {
                                        echo $product->pro_sku . ' - ';
                                    }
                                    echo sub($product->pro_name, 100); ?>
                                </a>
                                <?php
                                if ($this->session->userdata('sessionGroup') == AffiliateStoreUser) { ?>
                                    <p style="font-size: 13px">
                                        <i>Gian hàng:
                                            <a target="_blank" href="<?php echo $protocol . $shop; ?>">
                                                <span class="text-primary" style="color:#ff0202"><?php
                                                    echo $get_domain[0]->sho_link; ?></span>
                                            </a>
                                        </i>
                                    </p>
                                    <?php
                                }
                                if (isset($product->use_username) && $product->use_username != '') {
                                    $get_u = $this->user_model->get('use_id, use_username, use_group, parent_id', 'use_id = "' . $product->use_id . '"');
                                    $domain='';
                                    switch ($get_u->use_group) {
                                        case AffiliateUser:
                                            $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u->parent_id . '"');
                                            if ($get_p[0]->use_group == AffiliateStoreUser || $get_p[0]->use_group == BranchUser) {
                                                if ($get_p[0]->domain != '') {
                                                    $domain = $get_p[0]->domain;
                                                } else {
                                                    $parent = $get_p[0]->sho_link;
                                                }
                                            } else {
                                                if ($get_p[0]->use_group == StaffStoreUser || $get_p[0]->use_group == StaffUser) {
                                                    $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                                                    if ($get_p1[0]->domain != '') {
                                                        $domain = $get_p1[0]->domain;
                                                    } else {
                                                        $parent = $get_p1[0]->sho_link;
                                                    }
                                                } else {
                                                    $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                                                    if ($get_p1->use_group == StaffStoreUser && $get_p->use_group == StaffUser) {
                                                        $get_p2 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p1[0]->parent_id . '"');
                                                        if ($get_p1[0]->domain != '') {
                                                            $domain = $get_p2[0]->domain;
                                                        } else {
                                                            $parent = $get_p2[0]->sho_link;
                                                        }
                                                    }
                                                }
                                            }
                                            break;
                                    }

                                    $parent = $parent . $duoi;
                                    if ($domain != '') {
                                        $parent = $domain . '/';
                                    }
                                    ?>
                                    <p style="font-size: 13px">
                                        <i>Cộng tác viên:
                                            <?php if($product->website != '') { ?>
                                                <a target="_blank" href="<?php echo $protocol . $product->website . '.' . $_SERVER['HTTP_HOST'] .'/shop'; ?>">
                                            <?php } else { ?>
                                                <a target="_blank" href="<?php echo $protocol . $product->sho_link . '.' . $_SERVER['HTTP_HOST'] .'/shop'; ?>">
                                            <?php } ?>
                                            
                                                <span class="text-primary"><?php echo  $product->use_username; ?></span>
                                            </a>
                                        </i>
                                    </p>
                                <?php }?>
                            </td>
                            
                            <?php if ($list_product[0]->pro_type == 0) {?>
                            <td class="line_showcart_2 text-center">
                                <span>
                                        <?php echo $product->pro_weight; ?> g
                                </span>
                            </td>
                            <?php } ?>
                            <td class="line_showcart_3 text-center">
                                <?php echo $product->shc_quantity; ?>
                            </td>
                            
                            <td class="line_showcart_4 text-right">
                            	<span class="product_price">
                                    <?php echo number_format($product->pro_price_original, 0, ",", "."); ?> đ
                                </span>
                            </td>
			    <td class="line_showcart_5" style="text-align: right;">
				<?php if ($product->pro_price_rate > 0 || $product->pro_price_amt > 0) { ?>
				    <?php if (!empty($product->pro_price_rate)): ?>
					<span class="text-success text-right">
					    <?php echo number_format($product->pro_price_rate, 0, ",", "."); ?>
					    %</span>
				    <?php else: ?>
					<span class="text-success text-right"><?php echo number_format($product->pro_price_amt, 0, ",", "."); ?>
					    đ</span>
				    <?php endif; ?>
				<?php } ?>
                            </td>
			    
			    
                            <td class="line_showcart_6" style="text-align: right;">
				<?php
                                if ($product->affiliate_discount_amt > 0) {
                                    $giamqctv = number_format($product->affiliate_discount_amt, 0, ",", ".") . ' đ';
                                } else {
                                    $giamqctv = number_format($product->affiliate_discount_rate, 0, ",", ".") . ' %';
                                }
                                ?>
                                <span>
                                    <?php echo $giamqctv ?>
                                </span>
                            </td>
			    
			    
                            <td class="line_showcart_6" style="text-align: right;">
				<span class="text-success"><?php echo number_format($product->em_discount, 0, ",", "."); ?> đ</span>
                            </td>
			    
			    
                            <td class="line_showcart_7" style="text-align: right;">
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
			</tr>
			
			<?php if ($product->af_id > 0) { ?>
                        
			<tr>
                            <td colspan="5">
				<div class="text-right">Hoa hồng CTV:</div>
			    </td>
			    <td class="text-right">
				<?php
                                        if ($product->af_amt > 0) {
                                            $type = 'đ';
                                        } else {
                                            $type = '%';
                                        }
                                        ?>
                                        
					<?php if ($product->af_rate > 0):
					    $hoahong = $product->af_rate;
					    $moneyShop += $total_amount * ($hoahong / 100);
					?>

                                            <span class="text-success text-right">
						<?php echo number_format($product->af_rate, 0, ",", "."); ?>
                                                <?php echo $type ?>
					    </span>
                                        <?php else: $moneyShop += $product->af_amt * $product->shc_quantity; ?>
                                            <span class="text-success text-right">
						<?php echo number_format($product->af_amt, 0, ",", "."); ?>
                                                <?php echo $type ?>
					    </span>
                                        <?php endif; ?>
			    </td>
			    <td class="text-right">				 
				<span class="product_price">
				    <?php 
				    if($product->af_rate > 0){				    
					$hhctv = $total_amount * ($product->af_rate / 100);
				    } else {
					$hhctv = $product->af_amt * $product->shc_quantity;
				    }				    
				    echo number_format($hhctv, 0, ",", ".") ?> đ
				</span>
                                <hr/>
			    </td>
			</tr>
			<?php }else{ ?>
                        <tr>
                            <td></td>
                        </tr>
			<?php } ?>
			
			
			
                        <?php
                        $tongDT += $product->shc_total;//$product->order_total_no_shipping_fee
                        ?>
                    <?php endforeach; ?>
			
		    <tr style="border-top:1px solid #ddd !important;">
                        <td align="right" colspan="<?php echo $colspan?>">Tổng doanh thu đơn hàng:</td>
			<td class="text-right"><span  class="product_price"><b><?php echo number_format($tongDT, 0, ',', '.') ?> đ</b></span></td>
                    </tr>
		    <tr>
			<td align="right" colspan="<?php echo $colspan?>">Tổng hoa hồng CTV: </td>
			<td class="text-right"><span class="product_price"><b><?php echo number_format($moneyShop, 0, ',', '.') ?>  đ</b></span></td>
                    </tr>
		    <tr>  
			<td align="right" colspan="<?php echo $colspan?>">Phí vận chuyển: </td>
			<td class="text-right"><span class="product_price"><b><?php echo number_format($product->shipping_fee, 0, ',', '.') ?> đ</b></span></td>
		    </tr>
                    <tr>
                        <td align="right" colspan="<?php echo $colspan?>">
                            Tổng thanh toán cho shop:
                        </td>
			<td class="text-right">
			    <span class="product_price">
                                <b>
                                <?php //echo number_format($product->order_total_no_shipping_fee, 0, ',', '.') ?>
                                <?php
                                $toltalShop = $tongDT + $product->shipping_fee - $moneyShop;
                                echo number_format($toltalShop, 0, ',', '.') ?>
                                đ</b></span>
			</td>
                    </tr>
                    <tr>
                        <td align="right" colspan="<?php echo $colspan + 3?>">
                            <span class=""><b>***Lưu ý: Chưa trừ hoa hồng azibai</b></span>
                        </td>
                    </tr>
                </table>
		</div>
		<div class="text-right col-sm-12">
                    <p>
                        <?php
                        if ($this->uri->segment(2) == 'order_detail') {
                           
                            if ((($this->session->userdata('sessionGroup') <= 3 || $this->session->userdata('sessionGroup') == BranchUser) && $this->session->userdata('sessionUser') == $product->shc_saler) || (isset($parent_id) && $parent_id == $product->shc_saler)) {
                                if ($order_status == '01') {
                                    if ($list_product[0]->payment_status == 0 && $list_product[0]->payment_method == 'info_nganluong') {
                                    } else {
                                        if ($list_product[0]->pro_type == 0) {
                                            echo '<button type="button" value="accept" class="btn btn-primary confirm_order" data-toggle="modal" data-target="#accept-modal">Xác Nhận Đơn Hàng</button> ';
                                        }
                                    }
                                    if ($list_product[0]->pro_type == 0) {
                                        echo '<button type="button" value="cancel" class="btn btn-danger" data-toggle="modal" data-target="#cancel-modal">Hủy Đơn Hàng</button>';
                                    }
                                }

                                if($list_product[0]->shipping_method == 'SHO' && $product->order_status == '02'){                                
                                    echo '<button type="button" value="finish" class="btn btn-primary ship_order" data-toggle="modal" data-target="#finish-modal">Đã giao hàng</button>';
                                }

                                if ($order_status == '02') {
                                    if (testMode == 1) {
                                        echo '<button type="button" value="testmode" class="btn btn-danger" data-toggle="modal" data-target="#testmode-modal">Chuyển trạng thái đã giao hàng</button> ';
                                    }
                                    echo '<button type="button" value="cancel" class="btn btn-danger" data-toggle="modal" data-target="#cancel-modal">Hủy Đơn Hàng</button>';
                                }
                            }
                        }
                        ?>
                    </p>
                </div>
                <div class="text-right col-sm-12">
                    <?php if ($product->pro_type != 0 && $product->order_status == '98' && $product->order_saler == (int)$this->session->userdata('sessionUser') || (isset($parent_id) && $parent_id == $product->order_saler)) { ?>
                        <?php if ($product->pro_type == 2) { ?>
                            <p class="text-right"><b>
                                    Mã coupon:
                                    <?php
                                    if ($product->status_use == 0) {
                                        echo 'Chờ xác nhận';
                                    } elseif ($product->status_use == 1) {
                                        echo $product->order_coupon_code;
                                    } else {
                                        echo '<span style="text-decoration: line-through">' . $product->order_coupon_code . '</span>';
                                    } ?>
                                </b></p>
                        <?php } ?>
                        <?php if ($product->status_use == 1) { ?>
                            <a onclick="Action_apply(<?php echo $product->shc_orderid; ?>)" class="btn btn-default1"
                               href="javascript:void(0)">
                                <i class="fa fa-check"></i> Đã sử dụng
                            </a>
                            <p class="text-info"><i>Xác nhận <?php if ($product->pro_type == 2) {
                                        echo 'coupon';
                                    } elseif ($product->pro_type == 1) {
                                        echo 'dịch vụ';
                                    } ?> đã được sử dụng</i></p>
                        <?php } elseif ($product->status_use == 2) { ?>
                            <p class="text-success"><b>Đã sử dụng: <?php echo date('d/m/Y : H:m:i', $product->change_status_date); ?></b></p>
                        <?php }
                    } ?>
                    <p>
                    <?php
                        if ($this->uri->segment(2) == 'order_detail') {
                            if (($this->session->userdata('sessionGroup') <= 3 || $this->session->userdata('sessionGroup') == BranchUser) && $this->session->userdata('sessionUser') == $product->shc_saler || (isset($parent_id) && $parent_id == $product->shc_saler)) {
                                if ($product->shc_status == '01') {
                                    if ($product->payment_status == 0 && $product->payment_method == 'info_nganluong') {
                                    } else {
                                        if ($product->pro_type == 2) {
                                            echo '<button type="button" value="accept" class="btn btn-primary confirm_order" data-toggle="modal" data-target="#acceptCoupon-modal">Xác Nhận Đơn Hàng</button> ';
                                        }
                                    }

                                    if($list_product[0]->shipping_method == 'SHO' && $product->order_status == '02'){
                                        echo '<button type="button" value="finish" class="btn btn-primary ship_order" data-toggle="modal" data-target="#finish-modal">Đã giao hàng</button> ';
                                    }

                                    if ($product->pro_type == 2) {
                                        echo '<button type="button" value="cancel" class="btn btn-danger" data-toggle="modal" data-target="#cancel-modal">Hủy Đơn Hàng</button>';
                                    }
                                }
                            }
                        }
                    ?>
                    </p>
                    <?php if ($this->uri->segment(2) == 'order_detail') { ?>
                        <p>
                            <a class="btn btn-success" href="<?php //if ($user_ship->order_saler == $this->session->userdata('sessionUser')) { ?><?php echo base_url() ?>account/order/<?php if ($list_product[0]->pro_type == 0) {
                                   echo 'product';
                               } else {
                                   echo 'coupon';
                               } ?><?php //} else {  echo base_url() echo 'account/order?product='.$list_product[0]->pro_type;
                               //} ?>">
                                <?php if ($user_ship->order_saler == $this->session->userdata('sessionUser')) { ?> Quay về danh sách đơn hàng <?php } else { ?>Quay về danh sách  đơn hàng <?php } ?>
                            </a>
                        </p>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <!--</form>-->
        </div>
    </div>
</div>

<script src="<?php echo base_url() . 'templates/home/js/modalEffects.js'; ?>"></script>

<div id="cancel-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:35%;">
        <form id="order_form_cancel" method="post" action="<?php echo base_url() . 'home/account/ordersDonhang'; ?>">
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
                                <textarea name="info_cancel" class="form-control autogrow" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 104px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="order_status" id="order_status" value="">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <input type="hidden" name="do" value="cancel">
                    <button type="submit" class="btn btn-info" value="cancel">Xác nhận</button>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="acceptCoupon-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:35%;">
        <form id="order_form_accept_cp" method="POST" action="<?php echo base_url() .'home/account/ordersDonhang'; ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Xác nhận đơn hàng</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="order_status" id="order_status" value="">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <input type="hidden" name="do" value="acceptcp">
                    <button type="submit" class="btn btn-info" value="acceptcp">Xác nhận</button>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="accept-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:35%;">
        <form id="order_form_accept" method="POST" action="<?php echo base_url().'home/account/ordersDonhang'; ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Xác nhận đơn hàng</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="order_status" id="order_status" value="">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <input type="hidden" name="do" value="accept">
                    <button type="submit" class="btn btn-info" value="accept">Xác nhận</button>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="finish-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:35%;">
        <form id="order_form_finish" method="POST" action="<?php echo base_url().'home/account/finishOrderShopGiao'; ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Chuyển trạng thái tới đã hoàn thành</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="order_status" id="order_status" value="">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <input type="hidden" name="do" value="finish">
                    <button type="submit" class="btn btn-info" value="finish">Xác nhận</button>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="testmode-modal" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
     aria-hidden="true" style="display: none;">
    <div class="modal-dialog" style="width:35%;">
        <form id="order_form_testmode" method="post" action="<?php echo base_url() . 'home/account/ordersDonhang'; ?>">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title">Xác nhận Chuyển trạng thái đã giao hàng</h4>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="order_status" id="order_status" value="">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <input type="hidden" name="do" value="testmode">
                    <button type="submit" class="btn btn-info" value="testmode">Xác nhận</button>
                    <button type="button" class="btn btn-white" data-dismiss="modal">Đóng</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
<style type="text/css">
    .un-submit {
        color: #fff;
        background-color: darkgrey;
        border-color: darkgray;
    }

    .modal-footer {
        padding: 19px 0 24px 8px;
        text-align: center;
        border-top: none;
    }
</style>
<script type="text/javascript">
    function Action_apply(id) {
        confirm(function (e1, btn) {
            e1.preventDefault();
            var url = '<?php echo base_url();?>account/order/coupon/apply/' + id;
            window.location.href = url;
        });
        return false
    }

    $(document).ready(function () {
        $('button[type="submit"]').on('click', function () {
            $('button[type="submit"]').attr('disabled', 'disabled');
            $('button[type="button"]').attr('disabled', 'disabled');
            if (this.value == "accept") {
                $("#order_form_accept").submit();
            } else if (this.value == "finish") {
                $("#order_form_finish").submit();
            } else if (this.value == "acceptcp") {
                $("#order_form_accept_cp").submit();
            } else if (this.value == "cancel") {
                $("#order_form_cancel").submit();
            } else if (this.value == "testmode") {
                $("#order_form_testmode").submit();
            }
        });
    });
</script>
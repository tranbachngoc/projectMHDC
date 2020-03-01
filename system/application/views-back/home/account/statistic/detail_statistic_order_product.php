<?php $this->load->view('home/common/account/header'); ?>
<div class="container">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-lg-9 col-md-9 col-sm-8">
            <h2 class="page-title text-uppercase">
                THỐNG KÊ DOANH SỐ THEO ĐƠN HÀNG CỦA NGƯỜI BÁN
            </h2>
            <div class="db_table" style="overflow: auto; width:100%">

                <!-- Begin:: Đơn hàng -->
                <div id="panel_order_af_detail">
                <table cellspacing="0" class="table" width="100%" border="0">
                    <tr>
                        <td class="text-uppercase" colspan="2"><b>Đơn hàng: </b><span
                                class="text-danger"><b>#<?php echo $list_product[0]->shc_orderid; ?></b></span></td>
                        <td class="text-uppercase" align="center" colspan="3">
                            <b>Trạng thái:
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
                                ?>
                            </b>
                        </td>
                        <td class="text-uppercase" align="right" colspan="2"><b>Vận đơn:</b> <span class="text-success"><b>#<a
                                        href="<?php if ($list_product[0]->shipping_method == 'GHN') {
                                            echo clientOrderCode . $list_product[0]->order_clientCode;
                                        } else {
                                            echo clientVTPOrderCode . $list_product[0]->order_clientCode;
                                        } ?>"><?php echo $list_product[0]->order_clientCode; ?></a></b></span></td>
                    </tr>
                    <tr class="tr_title_order">
                        <td colspan="7">
                            <div class="row">
                                <div class="col-sm-4">
                                    <p>
                                        <i class="fa fa-clock-o"></i> Ngày đặt hàng:
                                        <b><?php echo date('d/m/Y H:m:i', $list_product[0]->shc_buydate); ?></b>
                                    </p>
                                </div>
                                <?php if ($list_product[0]->order_coupon_code == '') { ?>
                                    <div class="col-sm-3">
                                        <p><i class="fa fa-truck"></i> Nhà vận chuyển: <b>
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
                                                    default:
                                                        echo 'Shop giao';
                                                        break;
                                                }
                                                ?></b></p>
                                    </div>
                                    <?php
                                } ?>
                                <div class="col-sm-5">
                                    <p>
                                        <i class="fa fa-money"></i> Hình thức thanh toán:
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
                                        <p><i class="fa fa-calendar"></i> Ngày hủy:
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
                                <div class="col-sm-4">
                                    <p><i class="fa fa-user"></i> Người nhận:
                                        <b><?php echo $user_ship->ord_sname; ?></b></p>
                                </div>
                                <div class="col-sm-8">
                                    <p><i class="fa fa-home"></i> Địa chỉ:
                                        <b><?php echo $user_ship->ord_saddress; ?></b></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4">
                                    <p><i class="fa fa-phone"></i> Điện thoại:
                                        <b><?php echo $user_ship->ord_smobile; ?></b></p>
                                </div>
                                <div class="col-sm-3">
                                    <p><i class="fa fa-envelope"></i> Email:
                                        <b><?php echo $user_ship->ord_semail; ?></b></p>
                                </div>
                                <div class="col-sm-5 text-left">
                                    <?php
                                    if ($list_product[0]->payment_method == 'info_nganluong') {
                                        if ($list_product[0]->payment_status == 1 && $list_product[0]->payment_method == 'info_nganluong') { ?>
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
                    <?php if (isset($user_ship->ord_note) && $user_ship->ord_note != '') { ?>
                        <tr>
                            <td colspan="7">
                                <i><b>Ghi chú: <?php echo $user_ship->ord_note; ?></b></i>
                            </td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td width="10%" class="line_showcart_0">Hình ảnh</td>
                        <td width="30%" class="line_showcart_1">Thông tin SP</td>
                        <td width="10%" class="line_showcart_2">Trọng lượng</td>
                        <td width="10%" class="line_showcart_3  hidden-xs">Số lượng</td>
                        <td width="10%" class="line_showcart_4 hidden-xs">Tình trạng</td>
                        <td width="15%" class="line_showcart_4 hidden-xs">Đơn giá (VNĐ)</td>
                        <td width="15%" class="line_showcart_5">Thành tiền</td>
                    </tr>
                    <?php
                    $i = 1;
                    $total = 0;
                    $order_status = NULL;
                    $count_qty = 0;

                    foreach ($list_product as $k => $product):
                        $order_status = $product->order_status;
                        $total_amount = $product->pro_price * $product->shc_quantity;
                        $total += $total_amount;
                        $count_qty += $product->shc_quantity;
                        $cart[] = $product->shc_id;
                        ?>
                        <!-- Modal -->
                        <div class="modal fade prod_detail_modal" id="myModal<?php echo $k; ?>" tabindex="-1"
                             role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                                class="fa fa-times-circle text-danger"></i></button>
                                        <h4 class="modal-title" id="myModalLabel">Chi tiết sản phẩm</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-lg-3 col-xs-4">Tên sản phẩm:</div>
                                            <div class="col-lg-9 col-xs-8">
                                                <?php echo sub($product->pro_name, 100); ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-xs-4">Số lượng:</div>
                                            <div class="col-lg-9 col-xs-8">
                                                <?php echo $product->shc_quantity; ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-xs-4">Giá sản phẩm:</div>
                                            <div class="col-lg-9 col-xs-8">
                                                        <span class="product_price">
                                        <?php echo number_format($product->pro_price_original, 0, ".", ","); ?>
                                                            VND </span>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-xs-4">Giảm giá:</div>
                                            <div class="col-lg-9 col-xs-8">
                                                <?php if (!empty($product->pro_price_rate)): ?>
                                                    <span
                                                        class="product_price"><?php echo number_format($product->pro_price_rate, 0, ".", "."); ?>
                                                        %</span>
                                                <?php else: ?>
                                                    <span
                                                        class="product_price"><?php echo number_format($product->pro_price_amt, 0, ".", "."); ?>
                                                        VND</span>
                                                <?php endif; ?>

                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-xs-4">Phí vận chuyển:</div>
                                            <div class="col-lg-9 col-xs-8">
                                                <span class="product_price">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-3 col-xs-4">Thành tiền:</div>
                                            <div class="col-lg-9 col-xs-8">
                                                        <span class="product_price">
                                                    <?php echo number_format($total_amount, 0, '.', ','); ?> VND
                                                </span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <tr>
                            <td class="line_showcart_0">
                                <?php
                                $filename = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $product->pro_image);
                                if (file_exists($filename) && $filename != '') {
                                    ?>
                                    <img width="80" src="<?php echo base_url() . $filename; ?>"/>
                                <?php } else {
                                    ?>
                                    <img width="80" src="<?php echo base_url(); ?>media/images/no_photo_icon.png"/>
                                <?php } ?>
                            </td>
                            <td class="line_showcart_1">
                                <a class="menu_1"
                                   href="<?php echo base_url(); ?><?php echo $product->pro_category; ?>/<?php echo $product->pro_id; ?>/<?php echo RemoveSign($product->pro_name); ?>">
                                    <?php
                                    if (isset($product->pro_sku) && $product->pro_sku != '') {
                                        echo $product->pro_sku . ' - ';
                                    }
                                    echo sub($product->pro_name, 100); ?>
                                </a>
                                <?php if (isset($product->use_username) && $product->use_username != '') { ?>
                                    <p style="font-size: 13px">
                                        <i>Cộng tác viên online: <a target="_blank"
                                                                    href="<?php echo $shop; ?><?php echo $product->use_username; ?>"><span
                                                    class="text-primary"><?php echo $product->use_username; ?></span></a></i>
                                    </p>
                                <?php } ?>
                            </td>
                            <td class="line_showcart_2" style="text-align: right;">
                                    <span>
                                        <?php echo $product->pro_weight; ?>g
                                    </span>
                            </td>
                            <td style="text-align: right;" class="hidden-xs">
                                <?php echo $product->shc_quantity; ?>
                            </td>
                            <td class="line_showcart_4 hidden-xs"
                                style="text-align: center;">
                                <?php if (isset($product->pro_instock) && $product->pro_instock > 0) {
                                    echo '<span class="text-success"><i class="fa fa-check-square-o"></i> Còn hàng</span>';
                                } else {
                                    echo '<span class="text-danger"> Hết hàng</span>';
                                }
                                ?>
                            </td>
                            <td class="line_showcart_4 hidden-xs"
                                style="text-align: right;">
                                        <span class="product_price">
                                        <?php echo number_format($product->pro_price_original, 0, ",", "."); ?>
                                            đ
                                        </span>

                                <p class="text-right">
                                    Giảm giá:
                                    <?php if (!empty($product->pro_price_rate)): ?>
                                        <span
                                            class="text-success text-right"><?php echo number_format($product->pro_price_rate, 0, ",", "."); ?>
                                            %</span>
                                    <?php else: ?>
                                        <span
                                            class="text-success text-right"><?php echo number_format($product->pro_price_amt, 0, ",", "."); ?>
                                            vnđ</span>
                                    <?php endif; ?>
                                </p>


                                <?php
                                if ($this->session->userdata('sessionGroup') == AffiliateUser) { ?>
                                    <p class="text-right"> Hoa hồng:
                                        <?php if (!empty($product->af_rate)): ?>

                                            <span
                                                class="text-success text-right"><?php echo number_format($product->af_rate, 0, ",", "."); ?>
                                                %</span>
                                        <?php else: ?>
                                            <span
                                                class="text-success text-right"><?php echo number_format($product->af_amt, 0, ",", "."); ?>
                                                vnđ</span>
                                        <?php endif; ?>
                                    </p>
                                <?php } ?>
                            </td>
                            <td valign="top" style="text-align: right;">
                                    <span class="product_price">
                                        <?php echo number_format($total_amount, 0, ',', '.'); ?> đ
                                    </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td align="right" colspan="10">
                            <p>Tổng tiền: <span
                                    class="product_price"><b><?php echo number_format($product->order_total_no_shipping_fee, 0, ',', '.') ?>
                                        đ</b></span></p>
                            <p>Phí vận chuyển: <span
                                    class="product_price"><b><?php echo number_format($product->shipping_fee, 0, ',', '.') ?>
                                        đ</b></span></p>
                        </td>
                    </tr>
                    <tr>
                        <td align="right" colspan="10">
                            <p class="td_total">Tổng thanh toán cho shop: <span
                                    class="product_price"><b><?php echo number_format($product->order_total_no_shipping_fee, 0, ',', '.') ?>
                                        đ</b></span></p>
                        </td>
                    </tr>
                </table>
                <div class="text-right col-sm-12">
                    <p>

                        <?php
                        if ($this->uri->segment(2) == 'order_detail') {
                            if ($this->session->userdata('sessionGroup') <= 3) {
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
                    <?php if ($product->pro_type != 0 && $product->order_status == '98' && $product->order_saler == (int)$this->session->userdata('sessionUser')) { ?>
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
                            <p class="text-success"><b>Đã sử
                                    dụng: <?php echo date('d/m/Y : H:m:i', $product->change_status_date); ?></b></p>
                        <?php }
                    } ?>
                    <p>
                        <?php
                        if ($this->uri->segment(2) == 'order_detail') {
                            if ($this->session->userdata('sessionGroup') <= 3) {
                                if ($product->shc_status == '01') {
                                    if ($product->payment_status == 0 && $product->payment_method == 'info_nganluong') {

                                    } else {
                                        if ($product->pro_type == 2) {
                                            echo '<button type="button" value="accept" class="btn btn-primary confirm_order" data-toggle="modal" data-target="#acceptCoupon-modal">Xác Nhận Đơn Hàng</button> ';
                                        }
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
                            <a class="btn btn-success"
                               href="<?php if ($user_ship->order_saler == $this->session->userdata('sessionUser')) { ?><?php echo base_url() ?>account/order/<?php if ($list_product[0]->pro_type == 0) {
                                   echo 'product';
                               } else {
                                   echo 'coupon';
                               } ?><?php } else { ?><?php echo base_url() ?>account/order?product=<?php echo $list_product[0]->pro_type;
                               } ?>">
                                <?php if ($user_ship->order_saler == $this->session->userdata('sessionUser')) { ?> Quay về danh sách đơn hàng <?php } else { ?>Quay về danh sách  đơn hàng <?php } ?>
                            </a>
                        </p>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
            </div>
            <!-- End:: Đơn hàng -->

            </div>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<script>
    function add_data_hidden_field(shop_name,user_id,username){
        $('#shop_name').text(shop_name);
        $('#shop_id').val(user_id);
    }

    function add_shop_for_user(){
        if($('#child_list').val() != ''){
            use_id = $('#child_list').val();
            shop_id = $('#shop_id').val();
            $.ajax({
                type: "post",
                url:"<?php echo base_url(); ?>" + 'account/tree/store',
                cache: false,
                data:{use_id: use_id, shop_id: shop_id},
                dataType:'text',
                success: function(data){
                    if(data == '1'){
                        alert("Cập nhật thành công!");
                        $('.modal').modal('hide');
                        location.reload();
                    }else{
                        errorAlert('Có lỗi xảy ra','Thông báo');
                    }
                }
            });
        }else{
            alert("Vui lòng chọn thành viên cần gán!");
        }
        return false;
    }
</script>

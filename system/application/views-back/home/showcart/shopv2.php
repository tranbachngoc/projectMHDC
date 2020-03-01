<?php $this->load->view('home/common/checkout/header'); ?>
<?php 
    // echo "<pre>";
    // print_r($this->session->userdata('cart'));
    // echo "</pre>";
 ?>
<style>
    td { text-align: left;}
    #green { background-color: #2ECC71; }
    #green:hover { background-color: #27AE60;}
    select:focus, select:active { border: 0; outline: 0;}
</style>
<script type="text/javascript">
    $('document').ready(function(){
        $('.form_table_revice1').mouseleave(function () {
            $('#tmm-form-wizard .stage').removeClass('.tmm-current');
            $('#tmm-form-wizard .stage').addClass('.tmm-success ');
        });
        $('input[name="payment_method"]').click(function () {
            console.log($(this).attr('value'));
            $(".nl-payment-more").hide();
            if ($(this).attr('value') == "info_nganluong") {
                $(".nl-payment-more").show();
            }
        });
        $('input[name="payment_method_nganluong"]').bind('click', function () {
            $('.list-content li').removeClass('active');
            $(this).parent().parent('li').addClass('active');
        });
        $("input[type='submit']").click(function () {
            if (document.getElementById('info_nganluong').checked) {
                if ($("#ord_semail_get").val() == '') {
                    $("#ord_semail_get").focus();
                    alert("Vui lòng nhập địa chỉ Email!");
                    return false;
                }
            }
            $(this).find("input[type='submit']").prop('disabled', true);
            $("input[type='submit']").submit();
        });
    });
</script>
<?php 
    $is_shop = false;
    if(count(explode('.', $_SERVER['HTTP_HOST'])) === 3) $is_shop = true;
?>
    <!--BEGIN: CENTER-->
    <div id="baseUrl" style="display:none;"><?php echo base_url(); ?></div>
    <div id="main" class="container-fluid">
        <div class="row">
            <?php /*<div class="col-lg-2 hidden-md hidden-sm hidden-xs <?php if($is_shop){ echo 'hidden';} ?>">
                <?php $this->load->view('home/common/left_tintuc');  ?> 
            </div> */ ?> 
            <div class="col-lg-10 col-lg-offset-1 showcart">
                <div class="breadcrumbs hidden-xs">
                    <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                    <span>Giỏ hàng</span>
                </div>

                <?php if (! empty($cart)) { ?>
                <script type="text/javascript" src="<?php echo base_url() ?>/templates/home/js/jquery.validate.min.js"></script>
                <script type="text/javascript">
                    //checkout_payment_click
                    // Number format
                    (function (b) {
                        b.fn.number = function (o) {

                            var r = 0;
                            var m = ',';
                            var p = ',';
                            var currency = 'đ';
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

                    var cart = <?php echo json_encode(array_values($jsCart));?>;
                    var shop_id = <?php echo $shop['sho_user']; ?>;
                    //var ship_fee = 0;
                    function updatePrice() {
                        total = 0;
                        for (var i = 0, len = cart.length; i < len; ++i) {
                            // blah blah
                            if (cart[i].products.length > 0) {
                                for (var j = 0, prolen = cart[i].products.length; j < prolen; ++j) {
                                    rowPrice = cart[i].products[j].pro_cost * cart[i].products[j].qty ;
                                    total += rowPrice - cart[i].products[j].em_discount;
                                    $('#sub_' + cart[i].products[j].key).text($.fn.number(rowPrice));
                                    if(cart[i].products[j].em_discount > 0){
                                        $('#dc_' + cart[i].products[j].key).text('Đại lý giảm: '+$.fn.number(cart[i].products[j].em_discount));
                                    }else{
                                        $('#dc_' + cart[i].products[j].key).text('');
                                    }
                                }
                            }
                        }
                      
                        $('#total').text($.fn.number(total));
                        $('input[name="amount"]').val(total);
                    }
                    
                    function qtyChange(pKey, pNum) {
                        for (var i = 0, len = cart.length; i < len; ++i) {
                            // blah blah
                            if (cart[i].products.length > 0) {
                                for (var j = 0, prolen = cart[i].products.length; j < prolen; ++j) {
                                    if (cart[i].products[j].key == pKey) {
                                        cart[i].products[j].qty = pNum;
                                        $.ajax({
                                            type: "POST",
                                            //url: siteUrl + "showcart/update_qty",
                                            url:  "/showcart/update_qty",
                                            data: $('#frmShowCart').serialize()+'&qty='+cart[i].products[j].qty+'&pro_id='+cart[i].products[j].pro_id+'&key='+cart[i].products[j].key+'&dp_id='+cart[i].products[j].dp_id+'&shop_id='+shop_id,
                                            dataType: "json",
                                            success: function (data) {
                                                if (data.error == false) {
                                                    $('.cartNum').text(data.num);
                                                    // ship_fee = data.fee_amount;
                                                    // $('#time_shipping').html(data.feeTime);
                                                    for (var i = 0, len = cart.length; i < len; ++i) {
                                                        // blah blah
                                                        if (cart[i].products.length > 0) {
                                                            for (var j = 0, prolen = cart[i].products.length; j < prolen; ++j) {
                                                                if (data.key == cart[i].products[j].key) {
                                                                    cart[i].products[j].em_discount = data.em_discount;
                                                                    updatePrice();
                                                                    hideLoading();
                                                                    return;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                                hideLoading();

                                            }
                                        });
                                    }
                                }
                            }
                        }
                    }

                    function cart_update_qty(pro_id, num) {
                        showLoading();
                        var qty = parseInt($('input#qty_' + pro_id).val(), 10);
                        var qty_min = parseInt($('#bt_' + pro_id + ' input[name="qty_min"]').val(), 10);
                        var qty_max = parseInt($('#bt_' + pro_id + ' input[name="qty_max"]').val(), 10);
                        var qty_new = qty + num;
                        var meg = '';
                        if (qty_new <= qty_min) {
                            qty_new = qty_min;
                            if (qty_new >= 1) {
                                meg = 'Bạn phải mua tối thiểu ' + qty_min + ' sản phẩm';
                            }

                        }
                        if (qty_new >= qty_max) {
                            qty_new = qty_max;
                            meg = 'Xin lỗi, chúng tôi chỉ có ' + qty_max + ' sẩn phẩm trong kho';
                        }
                        $('input#qty_' + pro_id).val(qty_new);
                        if (meg != '') {
                            showMessage(meg, 'alert-danger');
                        }

                        qtyChange(pro_id, qty_new);
                    }

                    $("#check_same").click(function () {
                        if (document.getElementById('check_same').checked) {
                            $("#ord_sname_get").val("");
                            $("#ord_address_get").val("");
                            $("#ord_smobile_get").val("");
                            $("#ord_semail_get").val("");
                            $("#ord_sphone_get").val("");
                            $("#ord_sfax_get").val("");
                            $("#ord_sotherinfo_get").val("");
                            $("#check_same").prop("checked", false);
                        }
                    });
                </script>
               
                <h3 style="text-transform: uppercase" class="hidden-md hidden-lg">
                    Xác nhận đặt hàng
                </h3>
                <div class="tile_modules tile_modules_blue row">
                    <?php echo $this->lang->line('title_defaults'); ?>
                    <?php echo $shop['sho_name']; ?>
                </div>
                <div class="panel panel-default">
                    <?php if ($isMobile == 0) { ?>
                <table id="row_<?php echo $key; ?>" class="table" width="100%" cellpadding="0"
                       cellspacing="0">                  
                    <tr class="table_head">
                        <td width="40">STT</td>
                        <td width="">
                            <?php echo $this->lang->line('product_list'); ?>
                        </td>
                        <td width="150">
                            <?php echo $this->lang->line('cost_list'); ?>
                        </td>
                        <td width="130">
                            <?php echo $this->lang->line('quantity_list'); ?>
                        </td>
                        <td width="150">
                            <?php echo $this->lang->line('equa_currency_list'); ?>
                        </td>
                    </tr>
                    <tbody>
                    <?php
                    $total = 0;
                    foreach ($cart as $key => $product):
                        $total += ($product->pro_cost * $product->qty - $product->em_discount );
                        $link = base_url() . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                        $numberCoupon = 0;
                        if($product->pro_type != 0){
                            $numberCoupon++;
                        }
                        ?>
                        <tr id="row_<?php echo $product->key; ?>">
                            <td class="hidden-xs"><?php echo $key + 1; ?></td>
                            <td>
                                <?php
                                //$img1 = explode(',', $product->pro_image);
                                //$file_ex = 'media/images/product/' . $product->pro_dir . '/thumbnail_2_' . $img1[0];
                                //if ($img1[0] != "") { //&& file_exists($file_ex)
                                $link_img = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_';
                                $img1 = explode(',', $product->pro_image);
                                if($product->dp_id > 0){
                                    $link_image = $link_img . $product->dp_image;
                                } else {
                                    $link_image = $link_img . $img1[0];    
                                }                                       

                                if ($product->dp_image != "" || $img1[0] != "") {
                                    ?>
                                    <img width="80" src="<?php echo $link_image;?>" alt="" />
                                <?php }else {?>
                                    <img width="80" src="<?php echo base_url() . 'images/img_not_available.png'?>" alt="">
                                <?php }?>
                                <a class="menu_1"
                                   href="<?php echo $link; ?>">
                                    <?php echo sub($product->pro_name, 200); ?>
                                </a>
                                <p><span>
                                    <?php if($product->dp_color != '' && $product->dp_size != '' && $product->dp_material != ''){
                                        echo '(Màu: '.$product->dp_color.', kích thước: '.$product->dp_size.', chất liệu: '.$product->dp_material.')';
                                    } elseif ($product->dp_color != '' && $product->dp_size != '' && $product->dp_material == ''){
                                        echo '(Màu: '.$product->dp_color.', kích thước: '.$product->dp_size.')';
                                    } elseif ($product->dp_color != '' && $product->dp_size == '' && $product->dp_material != ''){
                                        echo '(Màu: '.$product->dp_color.', chất liệu: '.$product->dp_material.')';
                                    } elseif ($product->dp_color == '' && $product->dp_size != '' && $product->dp_material != ''){
                                        echo '(Kích thước: '.$product->dp_size.', chất liệu: '.$product->dp_material.')';
                                    } elseif ($product->dp_color != '' && $product->dp_size == '' && $product->dp_material == ''){
                                        echo '(Màu: '.$product->dp_color.')';
                                    } elseif ($product->dp_color == '' && $product->dp_size != '' && $product->dp_material == ''){
                                        echo '(Kích thước: '.$product->dp_size.')';
                                    } elseif ($product->dp_color == '' && $product->dp_size == '' && $product->dp_material != ''){
                                        echo '(Chất liệu: '.$product->dp_material.')';
                                    }
                                    ?> 
                                </span></p>
                            </td>
                            <td class="text-danger text-right">
                                <span id="cost_<?php echo $product->key; ?>"><b><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></b></span>
                            </td>
                            <td class="text-right">
                                <div class="qty_row" id="bt_<?php echo $product->key; ?>">
                                    <span class="qty_group">
                                        <span class="sub-qty" title="Bớt" onclick="cart_update_qty('<?php echo $product->key; ?>', -1);">-</span>
                                        <input readonly="readonly" id="qty_<?php echo $product->key; ?>"
                                               name="<?php echo $product->key; ?>" autofocus="autofocus"
                                               autocomplete="off" type="text" min="1" max="9999"
                                               class="inpt-qty productQty" required=""
                                               value="<?php echo $product->qty; ?>">
                                        <span class="add-qty" title="Thêm"  onclick="cart_update_qty('<?php echo $product->key; ?>', 1);">+</span>
                                    </span>
                                    <input type="hidden" value="<?php echo $product->qty_min; ?>" name="qty_min">
                                    <input type="hidden" value="<?php echo $product->qty_max; ?>" name="qty_max">
                                    <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->dp_id; ?>" />
                                    <input type="hidden" name="gr_id" id="grtid" value="<?php echo $product->gr_id; ?>" />
                                    <input type="hidden" name="gr_user" id="grtuser" value="<?php echo $product->gr_user; ?>" />
                                </div>
                            </td>
                            <td class="text-danger text-right">	
                                <span id="sub_<?php echo $product->key; ?>"><b><?php echo lkvUtil::formatPrice($product->pro_cost * $product->qty, 'đ'); ?></b></span>
                                <br/>
                                <span id="dc_<?php echo $product->key; ?>"><?php echo  $product->em_discount > 0 ? 'CTVien giảm: '.lkvUtil::formatPrice($product->em_discount, 'đ') : ''; ?></span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php } else { ?>
                    <!--show on mobile fix by tung-->
                    <ul id="row_<?php echo $key; ?>" class="wrap_mobile">
                        <p><i>Bán từ shop: <a href="<?php echo base_url().$shop['sho_link']; ?>"><?php echo $shop['sho_name']; ?></a></i></p>
                        <?php
                        $total = 0;
                        foreach ($cart as $key => $product):
                        $total += ($product->pro_cost * $product->qty - $product->em_discount );
                        $link = base_url() . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                        ?>
                        <li id="row_<?php echo $product->key; ?>" class="wrap_item">
                            <div class="row">
                                <div class="col-xs-4">
                                    <p>
                                        <?php
                                        $img1 = explode(',', $product->pro_image);
                                        $file_ex = 'media/images/product/' . $product->pro_dir . '/thumbnail_2_' . $img1[0];
                                        if ($img1[0] != "") { //&& file_exists($file_ex)
                                            ?>
                                            <img width="75" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_3_' . $img1[0]; ?>"
                                                 alt=""/>
                                        <?php } else { ?>
                                            <img width="75" src="<?php echo base_url() . 'images/img_not_available.png' ?>" alt="">
                                        <?php } ?>
                                    </p>
                                </div><!--/col4-->
                                <div class="col-xs-8">
                                    <p>
                                        <a class="menu_1" href="<?php echo $link; ?>">
                                            <?php echo sub($product->pro_name, 200); ?>
                                        </a>
                                    </p> <!--Ten san pham-->
                                </div><!--/Col8-->
                            </div><!-- /form-group-->
                            <div class="row">
                                <div class="col-xs-4">
                                    Số lượng:
                                </div><!--/col4-->
                                <div class="col-xs-8">
                                    <div class="qty_row" id="bt_<?php echo $product->key; ?>">
                                        <p class="qty_group">
                                            <span class="sub-qty" title="Bớt" onclick="cart_update_qty('<?php echo $product->key; ?>', -1);">-</span>
                                            <input readonly="readonly" id="qty_<?php echo $product->key; ?>" name="<?php echo $product->key; ?>" autofocus="autofocus" autocomplete="off" type="text" min="1" max="9999" class="inpt-qty productQty" required="" value="<?php echo $product->qty; ?>">
                                            <span class="add-qty" title="Thêm" onclick="cart_update_qty('<?php echo $product->key; ?>', 1);">+</span>
                                        </p>
                                        <input type="hidden" value="<?php echo $product->qty_min; ?>" name="qty_min">
                                        <input type="hidden" value="<?php echo $product->qty_max; ?>" name="qty_max">
                                        <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->dp_id; ?>" />
                                        <input type="hidden" name="gr_id" id="grtid" value="<?php echo $product->gr_id; ?>" />
                                        <input type="hidden" name="gr_user" id="grtuser" value="<?php echo $product->gr_user; ?>" />
                                    </div>
                                </div><!--/Col8-->
                            </div><!-- /form-group-->
                            <div class="row">
                                <div class="col-xs-4">
                                    <p>
                                        Giá bán:
                                    </p>
                                </div><!--/col4-->
                                <div class="col-xs-8">
                                    <p><b><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></b></p><!--/Gia ban-->
                                </div><!--/Col8-->
                            </div><!-- /form-group-->
                            <div class="row">
                                <div class="col-xs-4">
                                    <p>Thành tiền: </p>
                                </div><!--/col4-->
                                <div class="col-xs-8">
                                    <!--Thanh tien -->
                                    <div id="sub_<?php echo $product->key; ?>" class="text-danger">
                                        <b><?php echo lkvUtil::formatPrice($product->pro_cost * $product->qty, 'đ'); ?></b>
                                    </div>
                                    <div id="dc_<?php echo $product->key; ?>" class="text-danger">
                                        <?php echo $product->em_discount > 0 ? '-' . lkvUtil::formatPrice($product->em_discount, 'đ') : ''; ?>
                                    </div><!--/thanhtien-->
                                </div><!--/Col8-->
                            </div><!-- /form-group-->
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php } ?>
                </div>
                <!-- Modal -->
<!--                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" data-backdrop="static"-->
<!--                     data-keyboard="false" aria-labelledby="myModalLabel">-->
<!--                    <div class="modal-dialog" role="document">-->
<!--                        <div class="modal-content">-->
<!--                            <div class="modal-header">-->
<!--                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span-->
<!--                                        aria-hidden="true">&times;</span></button>-->
<!--                                <h4 class="modal-title" id="myModalLabel">Thông báo</h4>-->
<!--                            </div>-->
<!--                            <div class="modal-body">-->
<!--                                <div class="alert alert-warning">-->
<!--                                    Bạn vui lòng click <a id="btn_login"-->
<!--                                                          href="--><?php //echo base_url() ?><!--login?action=buyer">vào đây để-->
<!--                                        đăng nhập</a>. <br/>Nếu chưa có xin vui lòng đăng ký <a-->
<!--                                        href="--><?php //echo base_url(); ?><!--/register?action=buyer">tại đây</a>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->

                <!-- Ket thuc thong tin nguoi mua hang-->
                <div id="tmm-form-wizard">
                    <div class="row stage-container">
                        <div class="stage tmm-current col-md-4 col-sm-4">
                            <div class="stage-header head-icon head-icon-lock"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                            <div class="stage-content">
                                <h3 class="stage-title">Thông tin nhận hàng</h3>
                            </div>
                        </div><!--/ .stage-->

                        <div class="stage col-md-4 col-sm-4">
                            <div class="stage-header head-icon head-icon-user">
                                <i class="fa fa-credit-card" aria-hidden="true"></i>
                            </div>
                            <div class="stage-content">
                                <h3 class="stage-title">Hình thức thanh toán</h3>
                            </div>
                        </div><!--/ .stage-->
 
                        <!-- <div class="stage col-md-4 col-sm-4">
                                <div class="stage-header head-icon head-icon-payment">
                                    <i class="fa fa-truck fa-flip-horizontal" aria-hidden="true"></i>
                                </div>
                                <div class="stage-content">
                                    <h3 class="stage-title">Chọn nhà vận chuyển</h3>
                                </div>
                            </div> --><!--/ .stage-->

                        <div class="stage col-md-4 col-sm-4">
                            <div class="stage-header head-icon head-icon-details">
                                <i class="fa fa-check-square" aria-hidden="true"></i>
                            </div>
                            <div class="stage-content">
                                <h3 class="stage-title">Xác nhận đặt hàng</h3>
                            </div>
                        </div><!--/ .stage-->
                    </div>
                </div>

                <form id="frmShowCart" name="frmShowCart" method="post"
                      action="">
                      <input type="hidden" name="pro_type" value="<?php echo $pro_type; ?>"> 
                    <div class="infomation_show_shopping infomation_show_shopping<?php echo $key ?>">
                        <div class="content payment_step_1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-map-marker"></i> Thông tin người
                                                nhận</h3>
                                        </div>
                                        <div class="panel-body form_table_revice<?php echo $key ?> form-horizontal">
                                            <div class="form-group">
                                                <div class="form_text">
                                                    <div class="col-sm-12 text-success">
                                                        <?php if((int)$this->session->userdata('sessionUser') > 0){?>
                                                        <input type="checkbox"
                                                               value="1" name="check_same" class="check_same"
                                                               id="check_same">
                                                        <label for="check_same">Nhập lại thông tin người nhận hàng</label>
                                                            <?php }?>
                                                        <div class="info_required">(*) là bắt buộc</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ord_sname_get" class="col-sm-2"><span
                                                        class="form_asterisk"></span><strong><span
                                                            class="info_required">*</span> Tên người
                                                        nhận:</strong></label>

                                                <div class="col-sm-10 form_text"><input type="text" maxlength="250" placeholder="Nhập tên người nhận" value="<?php echo isset($user['use_fullname']) ? $user['use_fullname'] : ''; ?>" name="ord_sname" id="ord_sname_get" title=" " autocomplete="off"  class="form-control required">
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label for="ord_address_get" class="col-sm-2"><span class="
                                                                                              text-danger"></span><strong><span
                                                            class="info_required">*</span> Địa chỉ đường
                                                        :</strong></label>

                                                <div class="col-sm-10 form_text"><input type="text" maxlength="250" placeholder="Nhập địa chỉ đường" value="<?php echo isset($user['use_address']) ? $user['use_address'] : ''; ?>" name="ord_address"  id="ord_address_get" title=" " autocomplete="off" class="form-control required ord_address">
                                                </div>
                                            </div> -->
                                            <div class="form-group">
                                                <label for="ord_smobile_get" class="col-sm-2"><span class="form_asterisk"></span><strong><span  class="info_required">*</span> Số điện thoại:</strong></label>

                                                <div class="col-sm-10 form_text"><input type="text" maxlength="250"  placeholder="Nhập số điện thoại" value="<?php echo isset($user['mobile']) ? $user['mobile'] : ''; ?>" name="ord_smobile" id="ord_smobile_get"  title="Di động" autocomplete="off" class="form-control required">
                                                </div>
                                            </div>
                                            <!-- <div class="form-group">
                                                <label for="user_province_get" class="col-sm-2"><span class=" text-danger"></span><strong><span  class="info_required">*</span> Tỉnh/Thành :</strong></label>

                                                <div class="col-sm-10 form_text">
                                                    <select name="user_province" id="user_province_get"
                                                            class="form-control" autocomplete="off">
                                                        <option value="">Chọn Tỉnh/Thành</option>
                                                        <?php foreach ($province as $item): ?>
                                                            <option
                                                                value="<?php echo $item['id'];?>" <?php echo ($item['id'] == $user['use_province']) ? "selected='selected'" : ""; ?> ><?php echo  $item['val']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div> -->
                                            <!-- <div class="form-group">
                                                <label for="user_district_get" class="col-sm-2"><span class="
                                                                                              text-danger"></span><strong><span
                                                            class="info_required">*</span> Quận/Huyện :</strong></label>

                                                <div class="col-sm-10 form_text">
                                                    <select name="user_district" id="user_district_get"
                                                            class="form-control" autocomplete="off">
                                                        <option value="">Chọn Quận/Huyện</option>
                                                        <?php foreach ($district as $item): ?>
                                                            <option
                                                                value="<?php echo $item['id'];?>" <?php echo ($item['id'] == $user['user_district']) ? "selected='selected'" : ""; ?> ><?php echo  $item['val']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div> -->

                                            <div class="form-group">
                                                <label for="ord_semail_get" class="col-sm-2"><span
                                                        class="form_asterisk"></span><strong><span
                                                            class="info_required">*</span> Email :</strong></label>

                                                <div class="col-sm-10 form_text">
                                                    <input type="text" maxlength="250" placeholder="Nhập email" value="<?php echo isset($user['use_email']) ? $user['use_email'] : ''; ?>" name="ord_semail" id="ord_semail_get" title="" autocomplete="off" class="form-control email">
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label for="ord_note_get" class="col-sm-2"><span
                                                        class="form_asterisk"></span><strong>Ghi chú :</strong></label>

                                                <div class="col-sm-10 form_text">
                                                    <textarea type="text" maxlength="255" placeholder="Nhập ghi chú" name="ord_note" id="ord_note_get"
                                                              class="form-control"></textarea>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="break_content"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-usd"></i> Phương thức thanh toán
                                            </h3>
                                        </div>
                                        <div class="panel-body payment_method form-inline">

                                            <?php
                                            if ($infoPayment->info_nganluong) { ?>
                                                <div class="form-group" style="display:block;">
                                                    <label><input type="radio" value="info_nganluong"
                                                                  name="payment_method" class="info_nganluong"
                                                                  id="info_nganluong"> <i class="fa fa-credit-card"></i>

                                                        Thanh toán Trực tuyến</label>

                                                    <div class="nl-payment-more">
                                                        <ul class="list-content">
                                                            <li class="active">
                                                                <label><input type="radio" value="NL"
                                                                              name="payment_method_nganluong"
                                                                              checked>Thanh toán bằng Ví điện tử Ngân
                                                                    Lượng</label>

                                                                <div class="boxContent">
                                                                    <p>
                                                                        Giao dịch. Đăng ký ví NganLuonng.vn miễn phí <a
                                                                            href="https://www.nganluong.vn/?portal=nganluong&amp;page=user_register"
                                                                            target="_blank">tại đây</a></p>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <label><input type="radio" value="ATM_ONLINE"
                                                                              name="payment_method_nganluong">Thanh toán
                                                                    online bằng
                                                                    thẻ ngân hàng nội địa</label>

                                                                <div class="boxContent">
                                                                    <p><i>
                                                                        <span
                                                                            style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>:
                                                                            Bạn cần đăng ký Internet-Banking hoặc dịch
                                                                            vụ
                                                                            thanh toán trực tuyến tại ngân hàng trước
                                                                            khi
                                                                            thực hiện.</i></p>

                                                                    <ul class="cardList clearfix">
                                                                        <li class="bank-online-methods ">
                                                                            <label for="bidv_ck_on">
                                                                                <i class="BIDV"
                                                                                   title="Ngân hàng Đầu tư &amp; Phát triển Việt Nam"></i>
                                                                                <input type="radio" value="BIDV"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="vcb_ck_on">
                                                                                <i class="VCB"
                                                                                   title="Ngân hàng TMCP Ngoại Thương Việt Nam"></i>
                                                                                <input type="radio" value="VCB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="vnbc_ck_on">
                                                                                <i class="DAB"
                                                                                   title="Ngân hàng Đông Á"></i>
                                                                                <input type="radio" value="DAB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="tcb_ck_on">
                                                                                <i class="TCB"
                                                                                   title="Ngân hàng Kỹ Thương"></i>
                                                                                <input type="radio" value="TCB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="sml_atm_mb_ck_on">
                                                                                <i class="MB"
                                                                                   title="Ngân hàng Quân Đội"></i>
                                                                                <input type="radio" value="MB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="shb_ck_on">
                                                                                <i class="SHB"
                                                                                   title="Ngân hàng Sài Gòn - Hà Nội"></i>
                                                                                <input type="radio" value="SHB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="sml_atm_vib_ck_on">
                                                                                <i class="VIB"
                                                                                   title="Ngân hàng Quốc tế"></i>
                                                                                <input type="radio" value="VIB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="sml_atm_vtb_ck_on">
                                                                                <i class="ICB"
                                                                                   title="Ngân hàng Công Thương Việt Nam"></i>
                                                                                <input type="radio" value="ICB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="sml_atm_exb_ck_on">
                                                                                <i class="EXB"
                                                                                   title="Ngân hàng Xuất Nhập Khẩu"></i>
                                                                                <input type="radio" value="ICB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="sml_atm_acb_ck_on">
                                                                                <i class="ACB"
                                                                                   title="Ngân hàng Á Châu"></i>
                                                                                <input type="radio" value="ACB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="sml_atm_hdb_ck_on">
                                                                                <i class="HDB"
                                                                                   title="Ngân hàng Phát triển Nhà TPHCM"></i>
                                                                                <input type="radio" value="HDB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="sml_atm_msb_ck_on">
                                                                                <i class="MSB"
                                                                                   title="Ngân hàng Hàng Hải"></i>
                                                                                <input type="radio" value="MSB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="sml_atm_nvb_ck_on">
                                                                                <i class="NVB"
                                                                                   title="Ngân hàng Nam Việt"></i>
                                                                                <input type="radio" value="NVB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="sml_atm_vab_ck_on">
                                                                                <i class="VAB"
                                                                                   title="Ngân hàng Việt Á"></i>
                                                                                <input type="radio" value="VAB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="sml_atm_vpb_ck_on">
                                                                                <i class="VPB"
                                                                                   title="Ngân Hàng Việt Nam Thịnh Vượng"></i>
                                                                                <input type="radio" value="VPB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="sml_atm_scb_ck_on">
                                                                                <i class="SCB"
                                                                                   title="Ngân hàng Sài Gòn Thương tín"></i>
                                                                                <input type="radio" value="SCB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="ojb_ck_on">
                                                                                <i class="OJB"
                                                                                   title="Ngân hàng Đại Dương"></i>
                                                                                <input type="radio" value="OJB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="bnt_atm_pgb_ck_on">
                                                                                <i class="PGB"
                                                                                   title="Ngân hàng Xăng dầu Petrolimex"></i>
                                                                                <input type="radio" value="PGB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="bnt_atm_gpb_ck_on">
                                                                                <i class="GPB"
                                                                                   title="Ngân hàng TMCP Dầu khí Toàn Cầu"></i>
                                                                                <input type="radio" value="GPB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="bnt_atm_agb_ck_on">
                                                                                <i class="AGB"
                                                                                   title="Ngân hàng Nông nghiệp &amp; Phát triển nông thôn"></i>
                                                                                <input type="radio" value="AGB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="bnt_atm_sgb_ck_on">
                                                                                <i class="SGB"
                                                                                   title="Ngân hàng Sài Gòn Công Thương"></i>
                                                                                <input type="radio" value="SGB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="bnt_atm_nab_ck_on">
                                                                                <i class="NAB"
                                                                                   title="Ngân hàng Nam Á"></i>
                                                                                <input type="radio" value="NAB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                        <li class="bank-online-methods ">
                                                                            <label for="sml_atm_bab_ck_on">
                                                                                <i class="BAB"
                                                                                   title="Ngân hàng Bắc Á"></i>
                                                                                <input type="radio" value="BAB"
                                                                                       name="bankcode">

                                                                            </label></li>

                                                                    </ul>

                                                                </div>
                                                            </li>
                                                            <li>
                                                                <label><input type="radio" value="VISA"
                                                                              name="payment_method_nganluong"
                                                                              selected="true">Thanh
                                                                    toán bằng thẻ Visa hoặc MasterCard</label>

                                                                <div class="boxContent">
                                                                    <p><span
                                                                            style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>:Dùng
                                                                        thẻ do các ngân hàng trong nước phát hành.</p>

                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <?php
                                            }

                                            $p = 0;
                                            foreach ($infoPayment as $k => $value):
                                                if ($value && $k != 'id_user' && $k != "info_nganluong" && $k != "info_cod" ):
                                                    $p++;
                                                    ?>
                                                    <div class="form-group right_baokim">
                                                        <input checked="checked" id="id_<?php echo $p; ?>" class=""
                                                               title="<?php echo $value ?>" type="radio"
                                                               value="<?php echo $k; ?>" name="payment_method"/>
                                                        <label title="<?php echo $value ?>"
                                                               for="id_<?php echo $p; ?>"> <i
                                                                class="fa fa-truck"></i> <?php echo $this->lang->line("title" . $k); ?>
                                                        </label>
                                                    </div>
                                                    <br/>
                                                    
                                                    <?php
                                                endif;
                                            endforeach; ?>

                                        </div>
                                        <div class="break_content"></div>
                                    </div>
                                </div>


                                <!-- <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-truck"></i> Chọn nhà vận chuyển</h3>
                                        </div>
                                        <div class="panel-body payment_method">
                                            <b>Vận chuyển toàn quốc:</b>
                                            <ul class="transport">
                                                <li>
                                                    Giao hàng đến: <strong><span
                                                            id='shipper_to_address'><?php echo ($shipping_fee[$product->pro_id]['shipping_address']) ? $shipping_fee[$product->pro_id]['shipping_address'] : ''; ?></span></strong>

                                                    <strong><span
                                                            id='shipper_to_district'><?php echo ($shipping_fee[$product->pro_id]['shipping_district']) ? $shipping_fee[$product->pro_id]['shipping_district'] : ''; ?></span></strong>
                                                    <strong><span
                                                            id='shipper_to_province'><?php echo ($shipping_fee[$product->pro_id]['shipping_province']) ? $shipping_fee[$product->pro_id]['shipping_province'] : ''; ?></span></strong>
                                                </li>
                                                <?php
                                                $company = array("GHN" => "GIAO HÀNG NHANH");
                                                ?>
                                                <li>Thông qua :
                                                    <select name="company" id="company" class="form-control">
                                                        <?php foreach ($company as $key => $vals): ?>
                                                            <option
                                                                value="<?php echo $key; ?>" <?php echo ($shipping_fee[$product->pro_id]['shipping_fee']) ? "selected='selected'" : ""; ?> ><?php echo $vals ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </li>
                                                <span id="pending"></span>

                                                <div id="has-error"></div>
                                            </ul>
                                        </div>
                                        <div class="break_content"></div>
                                    </div>
                                </div> -->

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-money"></i> Tổng thành tiền</h3>
                                        </div>
                                        <div class="panel-body payment_method">
                                            <ul class="ulSumMoney">
                                                <!-- <li>
                                                    <label><?php echo $this->lang->line('total_cost_vc_defaults'); ?>: </label>
                                                    <span
                                                        id="total_shipping"><?php echo  ($total_vc>0)?lkvUtil::formatPrice($total_vc, 'đ'):' ----'; ?></span>
                                                </li>
                                                <li>
                                                    <label><?php echo $this->lang->line('time_vc_defaults'); ?>: </label>
                                                    <span
                                                        id="time_shipping"></span>
                                                </li> -->
                                                <li>
                                                    <label><?php echo $this->lang->line('total_cost_showcart_defaults') . ':'; ?></label>
                                                    <span class="text-danger" id="total"><?php echo lkvUtil::formatPrice($total, 'đ'); ?></span>
                                                    <input type="hidden" value="<?php echo $total; ?>" name="amount"/>
                                                </li>
                                            </ul>
											<p style="padding:10px 0;"><i class="fa fa-tags"></i> E-Coupon: sau khi thực hiện đặt hàng và thanh toán, bạn sẽ nhận được mã coupon điện tử gửi đến địa chỉ email cung cấp ở trên.</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!----
                            <div class="form-inline">
                                <label class="form_name">Thời gian mong muốn nhận hàng :</label>

                                <input type="text" style="width: 70px;" maxlength="30" value="08" name="ord_hour"
                                       id="ord_hour" class="form-control"> : <input type="text" style="width: 70px;"
                                                                                    maxlength="30" value="00"
                                                                                    name="ord_minute" id="ord_minute"
                                                                                    class="form-control">
                                <select name="ord_date" id="ord_date" class="form-control">
                                    <?php for ($i = 1; $i <= 30; $i++) { ?>
                                        <option
                                            value="<?php echo $i ?>" <?php if ((int)date('d') == $i) { ?> selected="selected" <?php } ?> ><?php if ($i < 10) echo '0';
                                echo $i; ?></option>
                                    <?php } ?>
                                </select>
                                <select name="ord_month" id="ord_month" class="form-control">
                                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                                        <option
                                            value="<?php echo $i ?>" <?php if ((int)date('m') == $i) { ?> selected="selected" <?php } ?> ><?php if ($i < 10) echo '0';
                                echo $i; ?></option>
                                    <?php } ?>
                                </select>
                                <select name="ord_year" id="ord_year" class="form-control">
                                    <?php for ($year = date('Y', time()); $year > 1940; $year--): ?>
                                        <option value="<?php echo $year ?>"><?php echo $year ?></option>
                                    <?php endfor; ?>
                                </select>
                                &nbsp; <i>(Giờ : phút - Ngày / Tháng / Năm)</i>
                            </div>
                            -->
                        </div>
                        
                        <input type="submit" value="ĐẶT HÀNG" class="btn btn-default btn-checkout"/>
                        <input type="hidden" name="gr_id" id="gr_id">
                        <input type="hidden" name="gr_user" id="gr_user">
                    </div>

                </form>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    $('#gr_id').val($('#grtid').val());
                    $('#gr_user').val($('#grtuser').val());
                    // $("#user_province_get").change(function () {
                    //     showLoading();
                    //     if ($(this).val()) {
                    //         $.ajax({
                    //             url: siteUrl + 'ajax/action/district',
                    //             type: "POST",
                    //             data: {province: $(this).val()},
                    //             dataType: "json",
                    //             beforeSend: function () {
                    //                 $(this).disabled = true;
                    //             },
                    //             success: function (response) {
                    //                 $("#user_province_get").disabled = false;
                    //                 if(response.length > 0){
                    //                     $('select[name="user_district"]').empty();
                    //                     for(var i = 0, j = response.length; i < j; i++){
                    //                         $('select[name="user_district"]').append('<option value="'+response[i].id+'">'+response[i].val+'</option>')
                    //                     }
                    //                     $('#user_district_get-error').empty();
                    //                     $('#user_district_get').removeClass('error');
                    //                     $('select[name="user_district"]').trigger('change');

                    //                 }
                    //                 hideLoading();
                    //             },
                    //             error: function () {
                    //                 alert("Lỗi! Vui lòng thử lại");
                    //             }
                    //         });
                    //     }else{
                    //         $('select[name="user_district"]').empty();
                    //         $('select[name="user_district"]').append('<option value="">Chọn Quận/Huyện</option>');
                    //         hideLoading();
                    //     }
                    // });

                    // $("#user_district_get").change(function () {
                    //     getShippingFee();
                    // });

                    // $("#company").change(function () {
                    //     getShippingFee();
                    // });


                    // //Get fee if have districe
                    // if($('select[name="user_district"]').val() != ''){
                    //     getShippingFee();
                    // }


                    // Reset value
                    // $('input[name="check_same"]').click(function(){
                    //     if($(this).is(':checked')){
                    //         $('#ord_sname_get, #ord_address_get, #ord_smobile_get, #ord_semail_get, #ord_note_get, #user_province_get, #user_district_get').val('');
                    //     }
                    // });
                    var orderForm = $("#frmShowCart");
                    orderForm.validate({
                        submitHandler: function (form) {
                            if($(form).find('input.btn-checkout').hasClass('procesing')){
                                showMessage('Đang xử lý...', 'alert-danger');
                                return;
                            }else{
                                $(form).find('input.btn-checkout').addClass('procesing');
                            }

                            $.ajax({
                                type: "POST",
                                //url: siteUrl + "showcart/place_order_v2",
                                url:  "/showcart/place_order_v2",
                                dataType: 'json',
                                data : $(form).serialize()+'&sho_user='+shop_id,
                                success: function(result) {
                                    $(form).find('input.btn-checkout').removeClass('procesing');
                                    if(result.error == false){
                                        if(result.payment_method == "info_nganluong"){
                                           // window.location = siteUrl + "payment/order_bill_nganluong/"+result.order_id+"?order_token="+result.order_token;
                                            // window.open(siteUrl + "payment/order_bill_nganluong/"+result.order_id+"?order_token="+result.order_token,'_blank');
                                            window.open("/payment/order_bill_nganluong/"+result.order_id+"?order_token="+result.order_token,'_blank');
                                        }else{
                                            // window.location = siteUrl + "orders-success/"+result.order_id+"?order_token="+result.order_token;
                                            window.location = "/orders-success/"+result.order_id+"?order_token="+result.order_token;
                                        }
                                    }else{
                                        showMessage(result.message, 'alert-danger');
                                    }
                                }
                            });
                        },
                        errorPlacement:function (error, element) {
                            switch(element.attr("name")) {
                                case 'ord_sname':
                                    error.insertAfter($("#ord_sname_get"));
                                    break;
                                // case 'ord_address':
                                //     error.insertAfter($("#ord_address_get"));
                                //     break;
                                case 'ord_smobile':
                                    error.insertAfter($("#ord_smobile_get"));
                                    break;

                                // case 'user_province':
                                //     error.insertAfter($("#user_province_get"));
                                //     break;
                                // case 'user_district':
                                //     error.insertAfter($("#user_district_get"));
                                //     break;
                                /*case 'telephone':
                                    error.insertAfter($("#row_telephone"));
                                    break;
                                case 'security_answer':
                                    error.insertAfter($("#row_security_answer"));
                                    break;
                                case 'captcha':
                                    error.insertAfter($("#row_captcha"));
                                    break;
                                case 'terms_condition':
                                    error.insertAfter($("#row_terms_condition"));
                                    break;*/
                                default:
                                    error.insertAfter(element);
                                    break;
                            }
                        }
                    });

                    orderForm.find('input[name="ord_sname"]').rules("add", {
                        required: true,
                        messages: {
                            required: "Vui lòng nhập họ tên.",
                        }
                    });
                    // orderForm.find('input[name="ord_address"]').rules("add", {
                    //     required: true,
                    //     messages: {
                    //         required: "Vui lòng nhập địa chỉ đường.",
                    //     }
                    // });
                    orderForm.find('input[name="ord_smobile"]').rules("add", {
                        required: true,
                        messages: {
                            required: "Vui lòng nhập số điện thoại."
                        }
                    });
                    // orderForm.find('select[name="user_province"]').rules("add", {
                    //     required: true,
                    //     messages: {
                    //         required: "Vui lòng chọn tỉnh/thành phố."
                    //     }
                    // });

                    // orderForm.find('select[name="user_district"]').rules("add", {
                    //     required: true,
                    //     messages: {
                    //         required: "Vui lòng chọn quận/huyện.",
                    //     }
                    // });

                    /*orderForm.find('input[name="telephone"]').rules("add", {
                        required: true,
                        messages: {
                            required: "Vui lòng nhập điện thoại."
                        }
                    });
                    orderForm.find('input[name="security_answer"]').rules("add", {
                        required: true,
                        messages: {
                            required: "Vui lòng nhập câu trả lời."
                        }
                    });
                    orderForm.find('input[name="captcha"]').rules("add", {
                        required: true,
                        messages: {
                            required: "Vui lòng nhập mã xác nhận."
                        }
                    });
                    orderForm.find('input[name="terms_condition"]').rules("add", {
                        required: true,
                        messages: {
                            required: "Bạn phải đồng ý các điều khoản và quy định của LKV FOOD."
                        }
                    });*/



                });
            </script>
            <?php } else { ?>
                <div class="alert alert-info" role="alert">
                    <?php echo $this->lang->line('none_record_showcart_defaults'); ?>! Vui lòng trở lại <a
                        href="<?php echo base_url(); ?>">Trang chủ Azibai</a> thêm coupon/dịch vụ để đặt hàng!
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- END CENTER-->
<?php $this->load->view('home/common/footer'); ?>
<?php if (isset($fullProductShowcart) && $fullProductShowcart == true) { ?>
    <script>alert('<?php echo $this->lang->line('full_product_showcart_defaults'); ?>');</script>
<?php } ?>
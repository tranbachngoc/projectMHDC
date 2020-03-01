<?php $this->load->view('home/common/checkout/header'); ?>
    <!--BEGIN: CENTER-->
   <?php 
        $arrUrl = explode('.', $_SERVER['HTTP_HOST']);
        if (count($arrUrl) === 3) {
            $linkreturn = 'shop/product';
        } else {
            $linkreturn = 'shop/products';
        }

        if (empty($url_g_d2)){
            $url_g_d2 = '';
        }else {
            $linkreturn = $url_g_d2 .'/product';
        }
   ?>
    <div id="baseUrl" style="display:none;"><?php echo getAliasDomain(); ?></div>
    <div id="main" class="container"> 
            <div class="showcart">
                <div class="row">           
                    <div class="col-xs-12">
                        <ol id="breadcrumb" class="breadcrumb" style="white-space: nowrap; overflow: auto;">
                            <li><a href="<?php echo getAliasDomain($url_g_d2) ?>">Trang chủ</a></li>
                            <li class="active">Xem giỏ hàng</li>
                        </ol>
                    </div>
                </div> 
                <div class="row">           
                    <div class="col-xs-12">
                <?php if (!empty($cart) || !empty($service) || !empty($coupon)) { ?>
                <script type="text/javascript" src="<?php echo getAliasDomain() ?>/templates/home/js/jquery.validate.min.js"></script>
                <script type="text/javascript">                    
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

                    var cart = <?php echo json_encode(array_values($jsCart)); ?>;

                    var cart_coupon = <?php echo json_encode(array_values($jsCouponCart)); ?>;

                    function updatePrice(store, element, cart) {
                        $total = 0;
                        var $fee = 0;
                        for (var i = 0, len = cart.length; i < len; ++i) {
                            // blah blah
                            if (typeof cart[i] !== "undefined") {
                                if (cart[i].shop == store && cart[i].products.length > 0) {

                                    for (var j = 0, prolen = cart[i].products.length; j < prolen; ++j) {
                                        if (cart[i].products[j]) {
                                            $rowPrice = cart[i].products[j].pro_cost * cart[i].products[j].qty;
                                            $total += $rowPrice;
                                            $('#sub_' + cart[i].products[j].key).text($.fn.number($rowPrice));
                                            if (cart[i].products[j].em_discount > 0) {
                                                $('#dc_' + cart[i].products[j].key).text('-' + $.fn.number(cart[i].products[j].em_discount));
                                            } else {
                                                $('#dc_' + cart[i].products[j].key).empty();
                                            }
                                            $total = $total - cart[i].products[j].em_discount;
                                        }
                                    }
                                    $total += $fee;

                                    $(element).find('#total_' + store).text($.fn.number($total));

                                    hideLoading();
                                    return;
                                }
                            }
                        }
                    }

                    function qtyChange(pKey, pNum, dpId, element, cart) {
                      var element = $(element).parents('table');
                      for (var i = 0, len = cart.length; i < len; ++i) {
                        // blah blah
                        if (cart[i].products.length > 0) {
                            for (var j = 0, prolen = cart[i].products.length; j < prolen; ++j) {
                                if (cart[i].products[j].key == pKey) {
                                    cart[i].products[j].qty = pNum;
                                    $.ajax({
                                        type: "POST",
                                        //url: siteUrl + "showcart/update_qty",
                                        url: "/showcart/update_qty",
                                        data: {
                                            qty: cart[i].products[j].qty,
                                            pro_id: cart[i].products[j].pro_id,
                                            key: cart[i].products[j].key,
                                            user_district: $("#user_district_get").val(),
                                            dp_id : dpId,
                                            shop_id: cart[i]['shop']
                                        },
                                        dataType: "json",
                                        success: function (data) {
                                            if (data.error == false) {
                                                $('.cartNum').text(data.num);
                                                for (var i = 0, len = cart.length; i < len; ++i) {
                                                    // blah blah
                                                    if (cart[i].products.length > 0) {
                                                        for (var j = 0, prolen = cart[i].products.length; j < prolen; ++j) {
                                                            if (data.key == cart[i].products[j].key) {
                                                                cart[i].products[j].em_discount = data.em_discount;
                                                                var store = pKey.split('_');
                                                                updatePrice(parseInt(store[0], 10), element, cart);
                                                                hideLoading();
                                                                return;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    });
                                }
                            }
                        }
                      }
                    }

                    function deleteProduct(key, element, type) {
                        var element = $(element).parents('table');
                        if (type == 'coupon') {
                            var cart_delete = cart_coupon;
                        } else {
                            var cart_delete = cart;
                        }
                        
                        var tmp = key.split('_');
                        showLoading();
                        $.ajax({
                            type: "POST",
                            //url: siteUrl + "showcart/delete",
                            url: "/showcart/delete",
                            data: {key: key, store: tmp[0], 'pro_id': tmp[1], type: type},
                            dataType: "json",
                            success: function (data) {
                                if (data.error == false) {
                                    $('.cartNum').text(data.num);
                                    for (var i = 0, len = cart_delete.length; i < len; ++i) {
                                        // blah blah
                                        if (cart_delete[i] && cart_delete[i].products.length > 0 && cart_delete[i].shop == tmp[0]) {
                                            for (var j = 0, prolen = cart_delete[i].products.length; j < prolen; ++j) {
                                                if (cart_delete[i].products[j] && key == cart_delete[i].products[j].key) {
                                                    //delete cart[i].products[j];
                                                    cart_delete[i].products.splice(j, 1);
                                                    $('tr#row_' + key).remove();
                                                }
                                            }

                                            if (cart_delete[i].products.length > 0) {
                                                if (type == 'coupon') {
                                                    cart_coupon = cart_delete;
                                                    updatePrice(parseInt(tmp[0], 10), element, cart_coupon);
                                                } else {
                                                    cart = cart_delete;
                                                    updatePrice(parseInt(tmp[0], 10), element, cart);
                                                }
                                            } else {
                                                delete cart_delete[i];
                                                $(element).parent().remove();
                                                // $(element).parent().find('div#title_' + tmp[0]).remove();
                                                // $(element).parent().find('table#row_' + tmp[0]).remove();

                                                if ($('table.shopBox').length == 0) {
                                                    
                                                    var mes = '<?php echo $this->lang->line('none_record_showcart_defaults'); ?>! Vui lòng trở lại <a  href="<?php echo getAliasDomain($linkreturn); ?>"><strong>Trang mua sắm</strong></a> tìm sản phẩm và chọn thêm vào Giỏ hàng!';

                                                    $('#frmShowCart').empty().append('<div class="alert alert-info" role="alert">' + mes + '</div>');
                                                }
                                                hideLoading();
                                            }
                                            return;
                                        }
                                    }
                                }
                                hideLoading();

                            }
                        });
                    }

                    function deleteProductMB(key, element, type) {
                        var element = $(element).parents('ul');
                        if (type == 'coupon') {
                            var cart_delete = cart_coupon;
                        } else {
                            var cart_delete = cart;
                        }
                        var tmp = key.split('_');
                        showLoading();
                        $.ajax({
                            type: "POST",
                            url: siteUrl + "showcart/delete",
                            data: {key: key, store: tmp[0], 'pro_id': tmp[1], type: type},
                            dataType: "json",
                            success: function (data) {
                                if (data.error == false) {
                                    $('.cartNum').text(data.num);
                                    for (var i = 0, len = cart_delete.length; i < len; ++i) {
                                        // blah blah
                                        if (cart_delete[i].products.length > 0 && cart_delete[i].shop == tmp[0]) {
                                            for (var j = 0, prolen = cart_delete[i].products.length; j < prolen; ++j) {
                                                if (cart_delete[i].products[j] && key == cart_delete[i].products[j].key) {
                                                    //delete cart[i].products[j];
                                                    cart_delete[i].products.splice(j, 1);
                                                    $('li#row_' + key).remove();
                                                }
                                            }

                                            if (cart_delete[i].products.length > 0) {
                                                if (type == 'coupon') {
                                                    cart_coupon = cart_delete;
                                                    updatePrice(parseInt(tmp[0], 10), element, cart_coupon);
                                                } else {
                                                    cart = cart_delete;
                                                    updatePrice(parseInt(tmp[0], 10), element, cart);
                                                }
                                            } else {
                                                //
                                                delete cart_delete[i];
                                                $(element).parent().remove();
                                                // $(element).parent().find('ul#row_' + tmp[0]).remove();
                                                // $(element).parent().find('div#title_' + tmp[0]).remove();
                                                if ($('table.shopBox').length == 0) {
                                                    var mes = '<?php echo $this->lang->line('none_record_showcart_defaults'); ?>! Vui lòng trở lại <a  href="<?php echo getAliasDomain(); ?>">Trang chủ Azibai</a> tìm sản phẩm và chọn thêm vào Giỏ hàng!';

                                                    $('#frmShowCart').empty().append('<div class="alert alert-info" role="alert">' + mes + '</div>');
                                                }
                                                hideLoading();
                                            }
                                            return;
                                        }
                                    }
                                }
                                hideLoading();
                            }
                        });
                    }
                                        
                    function cart_update_qty(pro_id, num, dpid, element, type) {
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
                        if (qty_new == 0 ) {
                            qty_new = 1;
                            meg = 'Bạn phải mua tối thiểu 1 sản phẩm';
                        }
                        $('input#qty_' + pro_id).val(qty_new);
                        if (meg != '') {
                            showMessage(meg, 'alert-danger');
                        }
                        if (qty != qty_new) {
                            if (type == 'coupon') {
                                qtyChange(pro_id, qty_new, dpid, element, cart_coupon);
                            } else {
                                qtyChange(pro_id, qty_new, dpid, element, cart);
                            }
                        }
                    }
                </script>
                <form id="frmShowCart" name="frmShowCart" method="post"
                       action="<?php echo getAliasDomain(); ?>showcart/order_cart">
                    <h3 style="text-transform: uppercase" class="hidden-md hidden-lg">Giỏ hàng của bạn</h3>
                <?php 
                    foreach ($cart as $key => $shop): ?>
                    <div class="panel panel-default">
                        <div id="title_<?php echo $key; ?>" class="tile_modules tile_modules_blue row">
                            <?php echo $this->lang->line('title_defaults'); ?>
                            <?php echo $shops[$key]['sho_name']; ?>
                        </div>
                        <?php /* Giao dien desktop */?>
                        <?php if ($isMobile == 0){ ?>
                        <table id="row_<?php echo $key; ?>" class="table shopBox" width="100%"
                               cellpadding="0" cellspacing="0">
                            <!-- <?php //$this->load->view('home/advertise/center1');
                            ?> -->
                            <tr class="table_head">
                                <td class="hidden-xs" width="5%">STT</td>
                                <td width="35%">
                                    <?php echo $this->lang->line('product_list'); ?>
                                </td>
                                <td width="15%">
                                    <?php echo $this->lang->line('quantity_list'); ?>
                                </td>
                                <td width="20%">
                                    <span class="hidden-xs"><?php echo $this->lang->line('cost_list'); ?></span>
                                </td>
                                <td width="20%">
                                    Thành tiền
                                </td>
                                <td class="hidden-xs" width="5%">
                                </td>
                            </tr>
                            <tbody>
                            <?php
                            $total = 0; 
                            foreach ($shop as $key_num => $product) {
                                $total += $product->pro_cost * $product->qty - $product->em_discount;                               
                                $link = getAliasDomain() . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                                $link_name = $mainDomain . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);                                
                                
                                ?>
                                <?php $link_img = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_'; ?>
                                <tr id="row_<?php echo $product->key; ?>">
                                    <td class="hidden-xs"><?php echo $key_num + 1; ?></td>
                                    <td>
                                    <?php
                                        $img1 = explode(',', $product->pro_image);
                                        if($product->dp_id > 0){
                                            //$file_ex = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $product->dp_image, 1);
                                            $link_image = $file_ex = $link_img . $product->dp_image;
                                        } else {
                                            //$file_ex = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $img1[0], 1);
                                            $link_image = $link_img . $img1[0];    
                                        }
                                        if (($product->dp_image != "" || $img1[0] != "")) { // && file_exists($file_ex)
                                            ?>
                                            <img width="100" src="<?php echo $link_image; ?>"
                                                 alt=""/>
                                        <?php } else { ?>
                                            <img width="100" src="<?php echo getAliasDomain() . 'images/img_not_available.png' ?>"
                                                 alt="">
                                        <?php } ?>
                                        <a class="menu_1"
                                           href="<?php echo $link_name; ?>">
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
                                    <td align="center">
                                        <div class="qty_row" id="bt_<?php echo $product->key; ?>">
                                            <div class="qty_group">
                                                <span class="sub-qty" title="Bớt" onclick="cart_update_qty('<?php echo $product->key; ?>', -1, <?php echo $product->dp_id; ?>, this, 'product');">-</span>
                                                <input readonly="readonly" id="qty_<?php echo $product->key; ?>" name="<?php echo $product->key; ?>" autofocus="autofocus" autocomplete="off" type="text" min="1" max="9999" class="inpt-qty productQty" required value="<?php echo $product->qty; ?>">
                                                <span class="add-qty" title="Thêm" onclick="cart_update_qty('<?php echo $product->key; ?>', 1, <?php echo $product->dp_id; ?>, this, 'product');">+</span>
                                            </div>
                                            <input type="hidden" value="<?php echo $product->qty_min; ?>"
                                                   name="qty_min">
                                            <input type="hidden" value="<?php echo $product->qty_max; ?>"
                                                   name="qty_max">
                                            <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->dp_id; ?>">
                                        </div>
                                    </td>
                                    <td>
                                        <p><b><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></b></p>
                                    </td>
                                    <td class="text-danger">
                                        <div
                                            id="sub_<?php echo $product->key; ?>"><b><?php echo lkvUtil::formatPrice($product->pro_cost * $product->qty, 'đ'); ?></b></div>
                                        <div
                                            id="dc_<?php echo $product->key; ?>"><?php echo $product->em_discount > 0 ? '-' . lkvUtil::formatPrice($product->em_discount, 'đ') : ''; ?></div>
                                    </td>
                                    <td align="center">
                                        <button type="button" onclick="deleteProduct('<?php echo $product->key; ?>', this, 'product');"
                                                class="btn button-delete btn-sm">Xóa
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="6" class="text-right"> <b>Tổng tiền: <span class="text-danger" id="total_<?php echo $key; ?>"><?php echo lkvUtil::formatPrice($total, 'đ'); ?></span></b>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-right">
                                    <a href="<?php echo '/checkout/' . $key . '/' . $shops[$key]['sho_link']; ?>" class="btn btn-order" <?php if($noAccesss == 1){ ?> onclick="alert('Bạn là thành viên Azibai, bạn không có quyền mua hàng khi đăng nhập, hay thoát ra và đặt hàng bằng tài khoản khác hoặc đặt hàng qua email. <a href=\'logout\'>Thoát ngay</a>'); return false;" <?php } ?> >Đặt hàng</a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                            <?php /* Giao dien mobile */?>
                            <?php } else { ?>
                        <!--show on mobile fix by tung-->
                        <ul id="row_<?php echo $key; ?>" class="wrap_mobile">
                         <p><i>Bán từ shop: <a href="<?php echo getAliasDomain().$shops[$key]['sho_link']; ?>"><?php echo $shops[$key]['sho_name']; ?></a></i></p>
                    <?php                   
                        $total = 0;
                        foreach ($shop as $key_num => $product) {
                                $total += $product->pro_cost * $product->qty - $product->em_discount;
                                $link = getAliasDomain() . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                                
                                $link_name = $mainDomain . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                            ?>
                            <?php $link_img = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_'; ?>
                           <li id="row_<?php echo $product->key; ?>" class="wrap_item">
                           <div class="row">
                               <div class="col-xs-4">
                                <p>
                                <?php
                                    $img1 = explode(',', $product->pro_image);
                                    if($product->dp_id > 0){                   
                                        $file_ex = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $product->dp_image, 1);
                                        $link_image = $link_img . $product->dp_image;
                                    } else {                                       
                                        $file_ex = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $img1[0], 1);
                                        $link_image = $link_img . $img1[0];    
                                    } 
                                    if (($product->dp_image != "" || $img1[0] != "")) { // && file_exists($file_ex)
                                          ?>
                                          <img width="75"
                                               src="<?php echo $link_image; ?>"
                                               alt=""/>
                                      <?php } else { ?>
                                          <img width="75" src="<?php echo getAliasDomain() . 'images/img_not_available.png' ?>"
                                               alt="">
                                      <?php } ?>
                                  </p>
                               </div><!--/col4-->
                               <div class="col-xs-8">
                                  <p>
                                      <a class="menu_1"
                                         href="<?php echo $link_name; ?>">
                                          <?php echo sub($product->pro_name, 200); ?>
                                      </a>
                                  </p> <!--Ten san pham-->
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
                               </div><!--/Col8-->
                           </div><!-- /form-group-->
                           <div class="row">
                               <div class="col-xs-4">
                                   Số lượng:
                               </div><!--/col4-->
                               <div class="col-xs-8">
                                   <div class="qty_row" id="bt_<?php echo $product->key; ?>">
                                        <div class="qty_group">
                                            <span class="sub-qty" title="Bớt" onclick="cart_update_qty('<?php echo $product->key; ?>', -1, <?php echo $product->dp_id; ?>, this, 'product');">-</span>
                                            <input readonly="readonly" id="qty_<?php echo $product->key; ?>" name="<?php echo $product->key; ?>" autofocus="autofocus" autocomplete="off" type="text" min="1" max="9999" class="inpt-qty productQty" required="" value="<?php echo $product->qty; ?>">
                                            <span class="add-qty" title="Thêm" onclick="cart_update_qty('<?php echo $product->key; ?>', 1, <?php echo $product->dp_id; ?>, this, 'product');">+</span>
                                        </div>
                                       <input type="hidden" value="<?php echo $product->qty_min; ?>"
                                              name="qty_min">
                                       <input type="hidden" value="<?php echo $product->qty_max; ?>"
                                              name="qty_max">
                                       <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->dp_id; ?>">
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
                                   <div id="sub_<?php echo $product->key; ?>">
                                       <b><?php echo lkvUtil::formatPrice($product->pro_cost * $product->qty, 'đ'); ?></b>
                                   </div>
                                   <div id="dc_<?php echo $product->key; ?>">
                                       <?php echo $product->em_discount > 0 ? '-' . lkvUtil::formatPrice($product->em_discount, 'đ') : ''; ?>
                                   </div><!--/thanhtien-->
                                   <button type="button" onclick="deleteProductMB('<?php echo $product->key; ?>', this, 'product');"
                                           class="btn button-delete btn-sm pull-right">Xóa
                                   </button>
                               </div><!--/Col8-->
                           </div><!-- /form-group-->
                           </li>
                            <?php } ?>
                           <div class="row">
                              <div class="col-xs-4">Tổng tiền:</div>
                                <div class="col-xs-8 text-right">
                                    <b><span class="text-danger" id="total_<?php echo $key; ?>"> <?php echo lkvUtil::formatPrice($total, 'đ'); ?>
                                        </span>
                                    </b>
                                </div>
                                <div class="col-xs-12">                                    
                                    <a href="<?php echo '/checkout/' . $key . '/' . $shops[$key]['sho_link']; ?>"
                                       class="btn btn-block btn-order" <?php if($noAccesss == 1){ ?>
                                       onclick="alert('Bạn là thành viên Azibai, bạn không có quyền mua hàng khi đăng nhập, hay thoát ra và đặt hàng bằng tài khoản khác hoặc đặt hàng qua email. <a href=\'<?php echo getAliasDomain() ?>logout\'>Thoát ngay</a>'); return false;" <?php } ?> >
                                        Đặt hàng</a>
                                </div>
                           </div>
                        </ul>
                        <?php } ?>
                    </div>
                    <?php  endforeach; ?>

                <?php 
                    foreach ($coupon as $key => $shop):                        
                        ?>
                    <div class="panel panel-default">
                        <div id="title_<?php echo $key; ?>" class="tile_modules tile_modules_blue row">
                            <?php echo $this->lang->line('title_coupon_defaults'); ?>
                            <?php echo $shops[$key]['sho_name']; ?>
                        </div>
                        <?php /* Giao dien desktop */?>
                        <?php if ($isMobile == 0){ ?>
                        <table id="row_<?php echo $key; ?>" class="table shopBox" width="100%"
                               cellpadding="0" cellspacing="0">
                            <?php //$this->load->view('home/advertise/center1'); ?>
                            <tr class="table_head">
                                <td class="hidden-xs" width="5%">STT</td>
                                <td width="35%">
                                    <?php echo $this->lang->line('product_list'); ?>
                                </td>
                                <td width="15%">
                                    <?php echo $this->lang->line('quantity_list'); ?>
                                </td>
                                <td width="20%">
                                    <span class="hidden-xs"><?php echo $this->lang->line('cost_list'); ?></span>
                                </td>
                                <td width="20%">
                                    Thành tiền
                                </td>
                                <td class="hidden-xs" width="5%">
                                </td>
                            </tr>
                            <tbody>
                            <?php
                            $total = 0;
                            foreach ($shop as $key_num => $product) {
                                $total += $product->pro_cost * $product->qty - $product->em_discount;
                                $link = getAliasDomain() . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                                $link_name =  $mainDomain . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                                
                                ?>
                                <?php $link_img = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_'; ?>
                                <tr id="row_<?php echo $product->key; ?>">
                                    <td class="hidden-xs"><?php echo $key_num + 1; ?></td>
                                    <td>
                                    <?php
                                    $img1 = explode(',', $product->pro_image);
                                    if($product->dp_id > 0){                   
                                        $file_ex = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $product->dp_image, 1);
                                        $link_image = $link_img . $product->dp_image;
                                    } else {                                       
                                        $file_ex = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $img1[0], 1);
                                        $link_image = $link_img . $img1[0];    
                                    } 
                                       
                                    if (($product->dp_image != "" || $img1[0] != "")) { // && file_exists($file_ex)
                                        if($product->dp_image != ""){ $img = $product->dp_image;}else{$img = $img1[0];}
                                        ?>
                                        <img width="100" src="<?php echo $link_img . $img; ?>"
                                                 alt=""/>
                                <?php } else { ?>
                                        <img width="100" src="<?php echo getAliasDomain() . 'images/img_not_available.png' ?>"
                                                 alt="">
                                <?php } ?>
                                <a class="menu_1" href="<?php echo $link_name; ?>">
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
                                <td align="center">
                                    <div class="qty_row" id="bt_<?php echo $product->key; ?>">
                                        <div class="qty_group">
                                            <span class="sub-qty" title="Bớt"
                                                      onclick="cart_update_qty('<?php echo $product->key; ?>', -1, <?php echo $product->dp_id; ?>, this, 'coupon');">-</span>
                                            <input readonly="readonly" id="qty_<?php echo $product->key; ?>"
                                                       name="<?php echo $product->key; ?>" autofocus="autofocus"
                                                       autocomplete="off" type="text" min="1" max="9999"
                                                       class="inpt-qty productQty" required=""
                                                       value="<?php echo $product->qty; ?>">
                                            <span class="add-qty" title="Thêm"
                                                      onclick="cart_update_qty('<?php echo $product->key; ?>', 1, <?php echo $product->dp_id; ?>, this, 'coupon');">+</span>
                                        </div>
                                        <input type="hidden" value="<?php echo $product->qty_min; ?>"
                                                   name="qty_min">
                                        <input type="hidden" value="<?php echo $product->qty_max; ?>"
                                                   name="qty_max">
                                        <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->dp_id; ?>">
                                    </div>
                                </td>
                                    <td>
                                        <p><b><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></b></p>
                                    </td>
                                    <td class="text-danger">
                                        <div
                                            id="sub_<?php echo $product->key; ?>"><b><?php echo lkvUtil::formatPrice($product->pro_cost * $product->qty, 'đ'); ?></b></div>
                                        <div
                                            id="dc_<?php echo $product->key; ?>"><?php echo $product->em_discount > 0 ? '-' . lkvUtil::formatPrice($product->em_discount, 'đ') : ''; ?></div>
                                    </td>
                                    <td align="center">
                                        <button type="button" onclick="deleteProduct('<?php echo $product->key; ?>', this, 'coupon');"
                                                class="btn button-delete btn-sm">Xóa
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="6" class="text-right"> <b>Tổng tiền: <span class="text-danger" id="total_<?php echo $key; ?>"><?php echo lkvUtil::formatPrice($total, 'đ'); ?></span></b>
                                </td>
                            </tr>
                            <tr>
                            <td  colspan="6" class="text-right">                                
                                <a href="<?php echo '/checkout/v2/' . $key . '/2/' . $shops[$key]['sho_link']; ?>"
                                        class="btn btn-order" <?php if($noAccesss == 1){ ?> onclick="alert('Bạn là thành viên Azibai, bạn không có quyền mua hàng khi đăng nhập, hay thoát ra và đặt hàng bằng tài khoản khác hoặc đặt hàng qua email. <a href=\'<?php echo getAliasDomain() ?>logout\'>Thoát ngay</a>'); return false;" <?php } ?> >Đặt hàng</a>            

                            </td>
                            </tr>
                            </tbody>
                        </table>
                            <?php /* Giao dien mobile */?>
                            <?php } else {?>
                        <!--show on mobile fix by tung-->
                        <ul id="row_<?php echo $key; ?>" class="wrap_mobile">
                            <p><i>Bán từ shop: <a href="<?php echo getAliasDomain().$shops[$key]['sho_link']; ?>"><?php echo $shops[$key]['sho_name']; ?></a></i></p>
                            <?php
                            $total = 0;
                            foreach ($shop as $key_num => $product) {
                                $total += $product->pro_cost * $product->qty - $product->em_discount;
                                $link = getAliasDomain() . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                                $link_name = $mainDomain . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                            ?>
                            <?php $link_img = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_'; ?>
                           <li id="row_<?php echo $product->key; ?>" class="wrap_item">
                           <div class="row">
                                <div class="col-xs-4">
                                   <p>
                                    <?php
                                    $img1 = explode(',', $product->pro_image);
                                    if($product->dp_id > 0){                   
                                        $file_ex = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $product->dp_image, 1);
                                        $link_image = $link_img . $product->dp_image;
                                    } else {                                       
                                        $file_ex = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $img1[0], 1);
                                        $link_image = $link_img . $img1[0];    
                                    }
                                      
                                    if (($product->dp_image != "" || $img1[0] != "")) { // && file_exists($file_ex)?>
                                        <img width="75" src="<?php echo $link_image; ?>"
                                               alt=""/>
                                    <?php } else { ?>
                                        <img width="75" src="<?php echo getAliasDomain() . 'images/img_not_available.png' ?>"
                                               alt="">
                                    <?php } ?>
                                  </p>
                               </div><!--/col4-->
                               <div class="col-xs-8">
                                  <p>
                                      <a class="menu_1"
                                         href="<?php echo $link_name; ?>">
                                          <?php echo sub($product->pro_name, 200); ?>
                                      </a>
                                  </p> <!--Ten san pham-->
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
                               </div><!--/Col8-->
                           </div><!-- /form-group-->
                           <div class="row">
                            <div class="col-xs-4">
                                Số lượng:
                            </div><!--/col4-->
                            <div class="col-xs-8">
                                <div class="qty_row" id="bt_<?php echo $product->key; ?>">
                                    <div class="qty_group">
                                            <span class="sub-qty" title="Bớt"
                                                      onclick="cart_update_qty('<?php echo $product->key; ?>', -1, <?php echo $product->dp_id; ?>, this, 'coupon');">-</span>
                                            <input readonly="readonly" id="qty_<?php echo $product->key; ?>"
                                                       name="<?php echo $product->key; ?>" autofocus="autofocus"
                                                       autocomplete="off" type="text" min="1" max="9999"
                                                       class="inpt-qty productQty" required=""
                                                       value="<?php echo $product->qty; ?>">
                        <span class="add-qty" title="Thêm"
                                                      onclick="cart_update_qty('<?php echo $product->key; ?>', 1, <?php echo $product->dp_id; ?>, this, 'coupon');">+</span>
                    </div>
                                    <input type="hidden" value="<?php echo $product->qty_min; ?>" name="qty_min">
                                    <input type="hidden" value="<?php echo $product->qty_max; ?>" name="qty_max">
                                    <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->dp_id; ?>">
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
                                   <div id="sub_<?php echo $product->key; ?>">
                                       <b><?php echo lkvUtil::formatPrice($product->pro_cost * $product->qty, 'đ'); ?></b>
                                   </div>
                                   <div id="dc_<?php echo $product->key; ?>">
                                       <?php echo $product->em_discount > 0 ? '-' . lkvUtil::formatPrice($product->em_discount, 'đ') : ''; ?>
                                   </div><!--/thanhtien-->
                                   <button type="button" onclick="deleteProductMB('<?php echo $product->key; ?>', this, 'coupon');"
                                           class="btn button-delete btn-sm pull-right">Xóa
                                   </button>
                               </div><!--/Col8-->
                           </div><!-- /form-group-->
                           </li>
                            <?php }?>
                           <div class="row">
                              <div class="col-xs-4">Tổng tiền:</div>
                                <div class="col-xs-8 text-right">
                                    <b><span class="text-danger" id="total_<?php echo $key; ?>">
                                            <?php echo lkvUtil::formatPrice($total, 'đ'); ?>
                                        </span>
                                    </b>
                                </div>
                                <div class="col-xs-12">                                    
                                    <a href="<?php echo '/checkout/v2/' . $key . '/2/' . $shops[$key]['sho_link']; ?>"
                                       class="btn btn-block btn-order" <?php if($noAccesss == 1){ ?>
                                      onclick="alert('Bạn là thành viên Azibai, bạn không có quyền mua hàng khi đăng nhập, hay thoát ra và đặt hàng bằng tài khoản khác hoặc đặt hàng qua email. <a href=\'<?php echo getAliasDomain() ?>logout\'>Thoát ngay</a>'); return false;" <?php } ?> >
                                        Đặt hàng</a>
                                </div>
                           </div>
                        </ul>
                        <?php } ?>
                    </div>
                    <?php                      
                    endforeach; ?>

                    <?php 
                    foreach ($service as $key => $shop):                        
                        ?>
                    <div class="panel panel-default">
                        <div id="title_<?php echo $key; ?>" class="tile_modules tile_modules_blue row">
                            <?php echo $this->lang->line('title_service_defaults'); ?>
                            <?php echo $shops[$key]['sho_name']; ?>
                        </div>
                        <?php /* Giao dien desktop */?>
                        <?php if ($isMobile == 0){ ?>
                        <table id="row_<?php echo $key; ?>" class="table shopBox" width="100%"
                               cellpadding="0" cellspacing="0">
                            <!--                    --><?php //$this->load->view('home/advertise/center1');
                            ?>
                            <tr class="table_head">
                                <td class="hidden-xs" width="5%">STT</td>
                                <td width="35%">
                                    <?php echo $this->lang->line('product_list'); ?>
                                </td>
                                <td width="15%">
                                    <?php echo $this->lang->line('quantity_list'); ?>
                                </td>
                                <td width="20%">
                                    <span class="hidden-xs"><?php echo $this->lang->line('cost_list'); ?></span>
                                </td>
                                <td width="20%">
                                    Thành tiền
                                </td>
                                <td class="hidden-xs" width="5%">
                                </td>
                            </tr>
                            <tbody>
                            <?php
                            $total = 0;
                            foreach ($shop as $key_num => $product) {
                                $total += $product->pro_cost * $product->qty - $product->em_discount;
                                $link = getAliasDomain() . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                                $link_name = $mainDomain . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                            ?>
                            <?php $link_img = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_'; ?>
                                <tr id="row_<?php echo $product->key; ?>">
                                    <td class="hidden-xs"><?php echo $key_num + 1; ?></td>
                                    <td>
                                    <?php
                                    $img1 = explode(',', $product->pro_image);
                                    if($product->dp_id > 0){                   
                                        $file_ex = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $product->dp_image, 1);
                                        $link_image = $link_img . $product->dp_image;
                                    } else {                                       
                                        $file_ex = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $img1[0], 1);
                                        $link_image = $link_img . $img1[0];    
                                    }
                                    
                                    if (($img1[0] != "" || $product->dp_image != "")) { ?>
                                        <img width="100" src="<?php echo $link_image; ?>"
                                                 alt=""/>
                                    <?php } else { ?>
                                        <img width="100" src="<?php echo getAliasDomain() . 'images/img_not_available.png' ?>"
                                                 alt="">
                                    <?php } ?>
                                    <a class="menu_1"   href="<?php echo $link_name; ?>">
                                        <?php echo sub($product->pro_name, 200); ?>
                                    </a>
                                    </td>
                                    <td align="center">
                                        <div class="qty_row" id="bt_<?php echo $product->key; ?>">
                                            <div class="qty_group">
                        <span class="sub-qty" title="Bớt"
                              onclick="cart_update_qty('<?php echo $product->key; ?>', -1, <?php echo $product->dp_id; ?>, this, 'coupon');">-</span>
                        <input readonly="readonly" id="qty_<?php echo $product->key; ?>"
                               name="<?php echo $product->key; ?>" autofocus="autofocus"
                               autocomplete="off" type="text" min="1" max="9999"
                               class="inpt-qty productQty" required=""
                               value="<?php echo $product->qty; ?>">
                        <span class="add-qty" title="Thêm"
                              onclick="cart_update_qty('<?php echo $product->key; ?>', 1, <?php echo $product->dp_id; ?>, this, 'coupon');">+</span>
                        </div>
                                            <input type="hidden" value="<?php echo $product->qty_min; ?>"
                                                   name="qty_min">
                                            <input type="hidden" value="<?php echo $product->qty_max; ?>"
                                                   name="qty_max">
                                            <input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->dp_id; ?>" />
                                        </div>
                                    </td>
                                    <td>
                                        <p><b><?php echo lkvUtil::formatPrice($product->pro_cost, 'đ'); ?></b></p>
                                    </td>
                                    <td class="text-danger">
                                        <div
                                            id="sub_<?php echo $product->key; ?>"><b><?php echo lkvUtil::formatPrice($product->pro_cost * $product->qty, 'đ'); ?></b></div>
                                        <div
                                            id="dc_<?php echo $product->key; ?>"><?php echo $product->em_discount > 0 ? '-' . lkvUtil::formatPrice($product->em_discount, 'đ') : ''; ?></div>
                                    </td>
                                    <td align="center">
                                        <button type="button" onclick="deleteProduct('<?php echo $product->key; ?>', this, 'coupon');"
                                                class="btn button-delete btn-sm">Xóa
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="6" class="text-right"> <b>Tổng tiền: <span class="text-danger" id="total_<?php echo $key; ?>"><?php echo lkvUtil::formatPrice($total, 'đ'); ?></span></b>
                                </td>
                            </tr>
                            <tr>
                            <td  colspan="6" class="text-right">                                
                                <a href="<?php echo '/checkout/v2/' . $key . '/2/' . $shops[$key]['sho_link']; ?>" class="btn btn-order" <?php if($noAccesss == 1){ ?> onclick="alert('Bạn là thành viên Azibai, bạn không có quyền mua hàng khi đăng nhập, hay thoát ra và đặt hàng bằng tài khoản khác hoặc đặt hàng qua email. <a href=\'<?php echo getAliasDomain() ?>logout\'>Thoát ngay</a>'); return false;" <?php } ?> >Đặt hàng</a>
                            </td>
                            </tr>
                            </tbody>
                        </table>
                            <?php /* Giao dien mobile */?>
                            <?php }else {?>
                        <!--show on mobile fix by tung-->
                        <ul id="row_<?php echo $key; ?>" class="wrap_mobile">
                             <p><i>Bán từ shop: <a href="<?php echo getAliasDomain().$shops[$key]['sho_link']; ?>"><?php echo $shops[$key]['sho_name']; ?></a></i></p>
                            <?php
                            $total = 0;
                            foreach ($shop as $key_num => $product) {
                            $total += $product->pro_cost * $product->qty - $product->em_discount;
                            $link = getAliasDomain() . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
                            ?>
                           <li id="row_<?php echo $product->key; ?>" class="wrap_item">
                           <div class="row">
                               <div class="col-xs-4">
                                  <p>
                                      <?php
                                      $img1 = explode(',', $product->pro_image);
                                      $file_ex = 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $img1[0], 1);
                                      if ($img1[0] != "" && file_exists($file_ex)) {
                                          ?>
                                          <img width="75"
                                               src="<?php echo getAliasDomain() . 'media/images/product/' . $product->pro_dir . '/' . show_thumbnail($product->pro_dir, $img1[0], 1); ?>"
                                               alt=""/>
                                      <?php } else { ?>
                                          <img width="75" src="<?php echo getAliasDomain() . 'images/img_not_available.png' ?>"
                                               alt="">
                                      <?php } ?>
                                  </p>
                               </div><!--/col4-->
                               <div class="col-xs-8">
                                  <p>
                                      <a class="menu_1"
                                         href="<?php echo $link; ?>">
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
                    <div class="qty_group">
                                            <span class="sub-qty" title="Bớt"
                                                      onclick="cart_update_qty('<?php echo $product->key; ?>', -1, <?php echo $product->dp_id; ?>, this, 'coupon');">-</span>
                                            <input readonly="readonly" id="qty_<?php echo $product->key; ?>"
                                                       name="<?php echo $product->key; ?>" autofocus="autofocus"
                                                       autocomplete="off" type="text" min="1" max="9999"
                                                       class="inpt-qty productQty" required=""
                                                       value="<?php echo $product->qty; ?>">
                        <span class="add-qty" title="Thêm"
                                                      onclick="cart_update_qty('<?php echo $product->key; ?>', 1, <?php echo $product->dp_id; ?>, this, 'coupon');">+</span>
                                        </div>
                                       <input type="hidden" value="<?php echo $product->qty_min; ?>"
                                              name="qty_min">
                                       <input type="hidden" value="<?php echo $product->qty_max; ?>"
                                              name="qty_max">
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
                                   <div id="sub_<?php echo $product->key; ?>">
                                       <b><?php echo lkvUtil::formatPrice($product->pro_cost * $product->qty, 'đ'); ?></b>
                                   </div>
                                   <div id="dc_<?php echo $product->key; ?>">
                                       <?php echo $product->em_discount > 0 ? '-' . lkvUtil::formatPrice($product->em_discount, 'đ') : ''; ?>
                                   </div><!--/thanhtien-->
                                   <button type="button" onclick="deleteProductMB('<?php echo $product->key; ?>', this, 'coupon');"
                                           class="btn button-delete btn-sm pull-right">Xóa
                                   </button>
                               </div><!--/Col8-->
                           </div><!-- /form-group-->
                           </li>
                            <?php }?>
                           <div class="row">
                              <div class="col-xs-4">Tổng tiền:</div>
                                <div class="col-xs-8 text-right">
                                    <b><span class="text-danger" id="total_<?php echo $key; ?>">
                                            <?php echo lkvUtil::formatPrice($total, 'đ'); ?>
                                        </span>
                                    </b>
                                </div>
                                <div class="col-xs-12">                                    
                                    <a href="<?php echo '/checkout/v2/' . $key . '/' . $shops[$key]['sho_link']; ?>" class="btn btn-block btn-order" <?php if($noAccesss == 1){ ?> onclick="alert('Bạn là thành viên Azibai, bạn không có quyền mua hàng khi đăng nhập, hay thoát ra và đặt hàng bằng tài khoản khác hoặc đặt hàng qua email. <a href=\'<?php echo getAliasDomain() ?>logout\'>Thoát ngay</a>'); return false;" <?php } ?> >Đặt hàng</a>
                                </div>
                           </div>
                        </ul>
                        <?php }?>
                    </div>
                    <?php                      
                    endforeach; ?>
                </form>
                   
                <?php } else { ?>
                    <div class="alert alert-info" role="alert">
                        <?php echo $this->lang->line('none_record_showcart_defaults'); ?>! Vui lòng trở lại <a href="<?php echo getAliasDomain($linkreturn); ?>"><strong>Trang mua sắm</strong></a> tìm sản phẩm và chọn thêm vào Giỏ hàng!
                    </div>
                <?php } ?>
                    </div>
                </div>
            </div>
        
    </div>
    <!-- END CENTER-->
 
<?php $this->load->view('home/common/footer'); ?>
<?php if (isset($fullProductShowcart) && $fullProductShowcart == true) { ?>
    <script>alert('<?php echo $this->lang->line('full_product_showcart_defaults'); ?>');</script>
<?php } ?>
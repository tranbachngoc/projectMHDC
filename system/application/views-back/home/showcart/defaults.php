<?php $this->load->view('home/common/checkout/header'); ?>
<style>
    td{text-align: left;}
    #green {
      background-color:#2ECC71;
    }
    #green:hover {
      background-color:#27AE60;
    }
    select:focus, select:active {
      border:0;
      outline:0;
    }
    #frmShowCart th{
       text-transform: uppercase;
    }
</style>

    <!--BEGIN: CENTER-->
    <div id="baseUrl" style="display:none;"><?php echo base_url(); ?></div>
    <div id="main" class="container-fluid showcart">
        <div class="row">
            <div class="col-lg-2 hidden-md hidden-sm hidden-xs">
                <?php $this->load->view('home/common/left_tintuc'); ?>
            </div>
            <div class="col-lg-10 showcart">
                <div class="breadcrumbs hidden-xs">
                    <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                    <span>Giỏ hàng</span>
                </div>

                <?php if (count($productShowcarts)) { ?>
                <?php
                $jsCart     = array();
                foreach ($productShowcarts as $key => $cart){
                    $shopItem = array('shop'=>$key, 'products'=>array());
                    foreach ($cart->productShowcart as $productShowcartArray) {
                        $productItem = array('pro_id'=>$productShowcartArray->pro_id, 'key'=>$productShowcartArray->key, 'qty'=>$productShowcartArray->qty, 'pro_cost'=>$productShowcartArray->pro_cost, 'em_discount'=>$productShowcartArray->em_discount,'shipping_fee'=>$shipping_fee[$productShowcartArray->pro_id]['shipping_fee']);
                        array_push($shopItem['products'], $productItem);
                    }
                    array_push($jsCart, $shopItem);
                } ?>

                <script type="text/javascript" src="<?php echo base_url()?>templates/home/js/jquery.validate.min.js"></script>
                <script type="text/javascript">
                    $("input[type='submit']").click(function() {
                        if(document.getElementById('info_nganluong').checked) {
                            if($("#ord_semail_get").val() == ''){
                                $("#ord_semail_get").focus();
                                alert("Vui lòng nhập địa chỉ Email!");
                                return false;
                            }
                        }
                        $(this).find("input[type='submit']").prop('disabled',true);
                        $("input[type='submit']").submit();
                    });

                    $('input[name="payment_method"]').click(function(){
                        $(".nl-payment-more").hide();
                        if($(this).attr('value') == "info_nganluong"){
                            $(".nl-payment-more").show();
                        }
                    });
                    $('input[name="payment_method_nganluong"]').bind('click', function() {
                        $('.list-content li').removeClass('active');
                        $(this).parent().parent('li').addClass('active');
                    });
                    //checkout_payment_click

                    // Number format
                    (function(b) {
                        b.fn.number = function(o) {

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
                                n = function(e, c) {
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
                            return l.join(q)+' '+currency;
                        }
                    })(jQuery);

                    var cart = <?php echo json_encode($jsCart);?>;

                    function updatePrice(){
                        $total = 0;
                        var $fee = 0;
                        for (var i = 0, len = cart.length; i < len; ++i) {
                            // blah blah
                            if(cart[i].products.length > 0){
                                for (var j = 0, prolen = cart[i].products.length; j < prolen; ++j) {
                                    $rowPrice = cart[i].products[j].pro_cost * cart[i].products[j].qty - cart[i].products[j].em_discount;
                                    $total += $rowPrice;
                                    $('#sub_'+cart[i].products[j].key).text($.fn.number($rowPrice));
                                    $('#dc_'+cart[i].products[j].key).text($.fn.number(cart[i].products[j].em_discount));
                                    if(cart[i].products[j].shipping_fee > 0){
                                        var shipfee = cart[i].products[j].shipping_fee;// * cart[i].products[j].qty;
                                        $fee += shipfee;
                                        $('#fee_'+cart[i].products[j].key).text($.fn.number(shipfee)).show();
                                    }else{
                                        $('#fee_'+cart[i].products[j].key).hide();
                                    }
                                }
                            }
                        }
                        $total += $fee;
                        //$('#total').text($.fn.number($total));
                        //$('input[name="amount"]').val($total);
                        if($fee > 0){
                            $('#total_fee').text($.fn.number($fee)).show();
                        }else{
                            $('#total_fee').hide();
                        }
                    }

                    function qtyChange(pKey, pNum){

                        /*if($("#user_district_get").val() == ""){
                            $("#user_province_get").focus();
                            alert("Vui lòng chọn tỉnh-thành quận-huyện");
                            return false;
                        }*/
                        for (var i = 0, len = cart.length; i < len; ++i) {
                            // blah blah
                            if(cart[i].products.length > 0){
                                for (var j = 0, prolen = cart[i].products.length; j < prolen; ++j) {
                                    if(cart[i].products[j].key == pKey){
                                        cart[i].products[j].qty = pNum;

                                        $.ajax({
                                            type: "POST",
                                            url: siteUrl  + "showcart/getPromotion",
                                            data: {qty: cart[i].products[j].qty, pro_id: cart[i].products[j].pro_id, key: cart[i].products[j].key,user_district:$("#user_district_get").val()},
                                            dataType: "json",
                                            success: function (data) {
                                                if(data.error == false){
                                                    $("#phivanchuyen_"+data.pro_id).text($.fn.number(data.shipping));
                                                    $("#thoigianchuyen_"+data.pro_id).html(data.ServiceName);

                                                    $("#total_vc").text($.fn.number(data.total_vc));
                                                    $("#total").text($.fn.number(data.total_amount));
                                                    $('input[name="amount"]').val(data.total_amount);

                                                    for (var i = 0, len = cart.length; i < len; ++i) {
                                                        // blah blah
                                                        if(cart[i].products.length > 0){
                                                            for (var j = 0, prolen = cart[i].products.length; j < prolen; ++j) {
                                                                if(data.key == cart[i].products[j].key){
                                                                    cart[i].products[j].em_discount = data.em_discount;
                                                                    updatePrice();
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
                    function cart_update_qty(pro_id, num){
                        var qty = parseInt($('input#qty_'+pro_id).val(), 10);
                        var qty_min = parseInt($('#bt_'+pro_id+' input[name="qty_min"]').val(), 10);
                        var qty_max = parseInt($('#bt_'+pro_id+' input[name="qty_max"]').val(), 10);
                        var qty_new = qty + num;
                        var meg = '';
                        if(qty_new <= qty_min){
                            qty_new = qty_min;
                            meg = 'Bạn phải mua tối thiểu '+ qty_min+' sản phẩm';
                        }
                        if(qty_new >= qty_max){
                            qty_new = qty_max;
                            meg = 'Xin lỗi, chúng tôi chỉ có '+qty_max+' sẩn phẩm trong kho';
                        }
                        $('input#qty_'+pro_id).val(  qty_new);
                        if(meg != ''){
                            bootbox.dialog({
                                title: "Thông báo",
                                message: '<p class="alert-danger">'+meg+'</p>'
                            });
                        }

                        qtyChange(pro_id, qty_new);
                    }




                    function getGHN_info(form_id){
                        var ord_sname_get           = $("#ord_sname_get").val();
                        var ord_address_get         = $("#ord_address_get").val();
                        var user_province_get       = $("#user_province_get").val();
                        var user_district_get       = $("#user_district_get").val();
                        var ord_smobile_get         = $("#ord_smobile_get").val();
                        if(ord_sname_get == "" || ord_address_get == "" || user_province_get == "" || user_district_get == "" || ord_smobile_get == ""){

                            $('#'+form_id).val('');
                            if(ord_sname_get==""){
                                $("#ord_sname_get").focus();
                            } else if(ord_address_get==""){
                                $("#ord_address_get").focus();
                            } else if(ord_smobile_get==""){
                                $("#ord_smobile_get").focus();
                            } else if(user_province_get==""){
                                $("#user_province_get").focus();
                            }
                            alert("Địa chỉ, tỉnh thành, quận và số điện thoại bắt buộc nhập"); return;
                        } else {
                            $.ajax({
                                url     : siteUrl + 'home/Restapi/apiGHN',
                                type    : "POST",
                                data    : {district: user_district_get},
                                cache   : true,
                                beforeSend: function(){
                                    $('#pending').html('<img src="http://maps.gov.pe.ca/mapserver2012/stdicons/icon_loading.gif" />').show();
                                },
                                success:function(data)
                                {
                                    $('#pending').hide();
                                    var temp = "";
                                    if(data){
                                        var response    = JSON.parse(data);
                                        var json        = response['arrProduct'];
                                        var str         =   '';
                                        json.forEach(function(entry) {
                                            var div_error           = document.getElementById('has-error');
                                            if(entry['code'] == '-1'){
                                                $("#has-error").html(entry['product_name'] + ': ' + entry['ErrorMessage']).show();
                                            } else {
                                                if(entry['ServiceFee'] == '-1'){
                                                    str = '<li><p class="api_product_name">'+entry['product_name'] + '</p><p>' + entry['ErrorMessage']+'</p></li>';
                                                } else {
                                                    //str = '<li><p class="api_product_name">'+entry['product_name'] + '</p><p>Phí vận chuyển: ' + entry['ServiceFee'].toLocaleString('vi-VI') +' đ</p><p>Thời gian: ' + entry['ServiceName'] + '</p></li>';
                                                    str = '';
                                                    $("#phivanchuyen_"+entry['pro_id']).html(entry['ServiceFee'].toLocaleString('vi-VI')+" đ");
                                                    $("#thoigianchuyen_"+entry['pro_id']).html(entry['ServiceName']);
                                                }
                                            }
                                            temp += str;
                                            div_error.innerHTML     = temp;
                                        });
                                        document.getElementById('total').innerHTML          = response['total'].toLocaleString('vi-VI') + ' đ';
                                        document.getElementById('total_vc').innerHTML       = response['total_vc'].toLocaleString('vi-VI') + ' đ';
                                        $('input[name="amount"]').val(response['total']);
                                        //inner html address
                                        document.getElementById('shipper_to_address').innerHTML         = $("#ord_address_get").val();
                                        document.getElementById('shipper_to_district').innerHTML        = $("#user_district_get :selected").text();
                                        document.getElementById('shipper_to_province').innerHTML        = $("#user_province_get :selected").text();
                                    } else {
                                        alert("Lỗi! Vui lòng thử lại");
                                    }
                                },
                                error: function()
                                {
                                    alert("Lỗi! Vui lòng thử lại");
                                }
                            });

                        }
                    }

                    function emptySelectBoxById(eid, value) {
                        if(value){
                            var text = "<option value=''>Vui lòng chọn</option>";
                            $.each(value, function(k, v) {
                                //display the key and value pair
                                if(k != ""){
                                    text += "<option value='" + k + "'>" + v + "</option>";
                                }
                            });
                            document.getElementById(eid).innerHTML = text;
                            delete text;
                        }
                    }
                    $( "#check_same" ).click(function() {
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

                    function _slvDeleteCart(form){
                        var checkValues = $('.checkbox:checked').map(function()
                        {
                            return $(this).val();
                        }).get();
                        $.ajax({
                            url     : siteUrl  +'home/showcart/order_cart',
                            type    : 'post',
                            data    : {checkone: checkValues}
                        }).done(function(response) {
                            if(response == "1"){
                                window.location.href=siteUrl+"showcart";
                            } else {
                                alert("Lỗi! Vui lòng thử lại");
                            }
                        });
                    }

                    $("#ord_sname_get").focus();
                </script>
                <form id="frmShowCart" name="frmShowCart" method="post"
                      action="<?php echo base_url(); ?>showcart/order_cart">
                    <h3 style="text-transform: uppercase" class="hidden-md hidden-lg">Giỏ hàng của bạn</h3>
                    <?php
                    $total      = 0;
                    $total_vc   = 0;

                    $jsCart     = array();
                    foreach ($productShowcarts as $key => $cart):
                        $productShowcart = $cart->productShowcart;
                        $infoShop = $cart->infoShop;
                        $infoPayment = $cart->infoPayment;
                        $infoShipping = $cart->infoShipping;

                        $shopItem = array('shop'=>$key, 'products'=>array());
                        ?>
                    <div class="panel panel-default">
                        <div class="tile_modules tile_modules_blue row">
                            <?php echo $this->lang->line('title_defaults'); ?>
                            <?php echo $infoShop->sho_name; ?>
                        </div>
                    <?php if ($isMobile == 0){ ?>
                        <table id="row_<?php echo $key;?>" class="table" width="100%" cellpadding="0" cellspacing="0">
                            <!--                    --><?php //$this->load->view('home/advertise/center1');
                            ?>
                            <thead>
                            <tr>
                                <th width="2%">
                                    <input type="checkbox" name="checkall" id="checkall" value="0"
                                           onclick="slvcheckAll(this, '<?php echo 'row_'.$key;?>')">
                                </th>
                                <th width="3%">Stt</th>
                                <th width="40%">
                                <?php echo $this->lang->line('product_list'); ?>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                     onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc')" border="0"
                                     style="cursor:pointer;" alt=""/>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                     onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc')" border="0"
                                     style="cursor:pointer;" alt=""/>
                                </th>
                                <th width="20%">
                                    <?php echo $this->lang->line('cost_list'); ?>
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                         onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/asc')" border="0"
                                         style="cursor:pointer;" alt=""/>
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                         onclick="ActionSort('<?php echo $sortUrl; ?>cost/by/desc')" border="0"
                                         style="cursor:pointer;" alt=""/>
                                </th>
                                <th width="10%">
                                    <?php echo $this->lang->line('quantity_list'); ?>
                                </th>
                                <th width="25%">
                                    <?php echo $this->lang->line('equa_currency_list'); ?>
                                </th>
<!--                                <th width="8%">
                                    <?php echo $this->lang->line('transport_fee'); ?>
                                </th>
                                <th width="12%">
                                    <?php echo $this->lang->line('transport_time'); ?>
                                </th>-->
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $idDiv = 1;

                            ?>
                            <?php
                            foreach ($productShowcart as $productShowcartArray) {
                                $total += ($productShowcartArray->pro_cost * $productShowcartArray->qty - $productShowcartArray->em_discount + $shipping_fee[$productShowcartArray->pro_id]['shipping_fee']);
                                $total_vc += $shipping_fee[$productShowcartArray->pro_id]['shipping_fee'];

                                ?>
                                <tr id="DivRowShowcart_<?php echo $key . '_' . $idDiv; ?>">
                                    <td>
                                        <input type="checkbox" name="checkone[]" class="checkbox"
                                               value="<?php echo $productShowcartArray->key; ?>" />
                                    </td>
                                    <td><?php echo $idDiv; ?></td>
                                    <td>
                                        <?php
                                        $img1 = explode(',', $productShowcartArray->pro_image);
                                        $filename = 'media/images/product/'. $productShowcartArray->pro_dir.'/'. show_thumbnail($productShowcartArray->pro_dir, $img1[0], 1);
                                        if($img1[0] != "" && file_exists($filename)){?>
                                            <img width="80" src="<?php echo base_url().'media/images/product/'. $productShowcartArray->pro_dir.'/'. show_thumbnail($productShowcartArray->pro_dir, $img1[0], 1);?>" alt="" />
                                        <?php }else {?>
                                            <img width="80" src="<?php echo base_url() . 'images/img_not_available.png'?>" alt="">
                                        <?php }?>
                                        <a class="menu_1"
                                           href="<?php echo base_url(); ?><?php echo $productShowcartArray->pro_category; ?>/<?php echo $productShowcartArray->pro_id; ?>/<?php echo RemoveSign($productShowcartArray->pro_name); ?>">
                                            <?php echo sub($productShowcartArray->pro_name, 200); ?>
                                        </a>
                                    </td>
                                    <td class="text-danger" style="font-weight: bold" align="right">
                                        <span
                                            id="cost_<?php echo $productShowcartArray->key; ?>"><?php echo lkvUtil::formatPrice($productShowcartArray->pro_cost, 'đ'); ?></span>
                                            <br/>
                                            CTVien giảm:<span id="dc_<?php echo $productShowcartArray->key; ?>"><?php echo lkvUtil::formatPrice($productShowcartArray->em_discount, 'đ'); ?></span>

                                    </td>
                                    <td align="center">
                                        <div class="qty_row" id="bt_<?php echo $productShowcartArray->key; ?>">
                                            <span class="qty_group" >
                                                <input readonly="readonly" id="qty_<?php echo $productShowcartArray->key; ?>" name="<?php echo $productShowcartArray->key; ?>" autofocus="autofocus" autocomplete="off" type="text" min="1" max="9999" class="inpt-qty productQty" required="" value="<?php echo $productShowcartArray->qty;?>">
                                                <span class="add-qty" title="Thêm" onclick="cart_update_qty('<?php echo $productShowcartArray->key; ?>', 1);">+</span>
                                                <span class="sub-qty" title="Bớt" onclick="cart_update_qty('<?php echo $productShowcartArray->key; ?>', -1);">-</span>
                                            </span>
                                            <input type="hidden" value="<?php echo $productShowcartArray->qty_min;?>" name="qty_min">
                                            <input type="hidden" value="<?php echo $productShowcartArray->qty_max;?>" name="qty_max">
                                        </div>
                                    </td>
                                    <td class="text-danger" style="font-weight: bold" align="right">
                                        <span
                                            id="sub_<?php echo $productShowcartArray->key; ?>"><?php echo lkvUtil::formatPrice($productShowcartArray->pro_cost * $productShowcartArray->qty - $productShowcartArray->em_discount, 'đ'); ?></span>
                                    </td>
<!--                                    <td>
                                        <span id="phivanchuyen_<?php echo $productShowcartArray->pro_id; ?>"><?php echo ($shipping_fee[$productShowcartArray->pro_id]['shipping_fee'] != 0)?lkvUtil::formatPrice($shipping_fee[$productShowcartArray->pro_id]['shipping_fee'], 'đ'):'---'; ?></span>
                                    </td>
                                    <td>
                                        <span id="thoigianchuyen_<?php echo $productShowcartArray->pro_id; ?>"><?php echo ($shipping_fee[$productShowcartArray->pro_id]['ServiceName'] != '')?$shipping_fee[$productShowcartArray->pro_id]['ServiceName']:'---'; ?></span>
                                    </td>-->
                                </tr>

                                <?php
                                $idDiv ++;
                                $backCategory = $productShowcartArray->pro_category; ?>
                            <?php } ?>
                            </tbody>
                        </table>
                        <?php /* Giao dien mobile */?>
                    <?php }else {?>
                        <!--show on mobile fix by tung-->
                        <ul id="row_<?php echo $key; ?>" class="wrap_mobile">
                            <p><i>Bán từ shop: <a href="<?php echo base_url().$infoShop->sho_link; ?>"><?php echo $infoShop->sho_name; ?></a></i></p>
                            <p>Xóa tất cả  <input type="checkbox" name="checkall" id="checkall" value="0"
                                                  onclick="slvcheckAll(this, '<?php echo 'row_'.$key;?>')"></p>
                            <?php
                            $idDiv = 1;
                            foreach ($productShowcart as $productShowcartArray) {
                                $total += ($productShowcartArray->pro_cost * $productShowcartArray->qty - $productShowcartArray->em_discount + $shipping_fee[$productShowcartArray->pro_id]['shipping_fee']);
                                $total_vc += $shipping_fee[$productShowcartArray->pro_id]['shipping_fee'];

                                ?>
                                <li id="DivRowShowcart_<?php echo $key . '_' . $idDiv; ?>" class="wrap_item">
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <p>
                                                <?php
                                                $img1 = explode(',', $productShowcartArray->pro_image);
                                                $file_ex = 'media/images/product/' . $productShowcartArray->pro_dir . '/' . show_thumbnail($productShowcartArray->pro_dir, $img1[0], 1);
                                                if ($img1[0] != "" && file_exists($file_ex)) {
                                                    ?>
                                                    <img width="75"
                                                         src="<?php echo base_url() . 'media/images/product/' . $productShowcartArray->pro_dir . '/' . show_thumbnail($productShowcartArray->pro_dir, $img1[0], 1); ?>"
                                                         alt=""/>
                                                <?php } else { ?>
                                                    <img width="75" src="<?php echo base_url() . 'images/img_not_available.png' ?>"
                                                         alt="">
                                                <?php } ?>
                                            </p>
                                        </div><!--/col4-->
                                        <div class="col-xs-8">
                                            <p>
                                                <a class="menu_1"
                                                   href="<?php echo $link; ?>">
                                                    <?php echo sub($productShowcartArray->pro_name, 200); ?>
                                                </a>
                                            </p> <!--Ten san pham-->
                                        </div><!--/Col8-->
                                    </div><!-- /form-group-->
                                    <div class="row">
                                        <div class="col-xs-4">
                                            Số lượng:
                                        </div><!--/col4-->
                                        <div class="col-xs-8">
                                            <div class="qty_row" id="bt_<?php echo $productShowcartArray->key; ?>">
                                                <p class="qty_group">
                                                <span class="add-qty" title="Thêm"
                                                      onclick="cart_update_qty('<?php echo $productShowcartArray->key; ?>', 1);">+</span>
                                                    <input readonly="readonly" id="qty_<?php echo $productShowcartArray->key; ?>"
                                                           name="<?php echo $productShowcartArray->key; ?>" autofocus="autofocus"
                                                           autocomplete="off" type="text" min="1" max="9999"
                                                           class="inpt-qty productQty" required=""
                                                           value="<?php echo $productShowcartArray->qty; ?>">
                                                <span class="sub-qty" title="Bớt"
                                                      onclick="cart_update_qty('<?php echo $productShowcartArray->key; ?>', -1);">-</span>
                                                </p>
                                                <input type="hidden" value="<?php echo $productShowcartArray->qty_min; ?>"
                                                       name="qty_min">
                                                <input type="hidden" value="<?php echo $productShowcartArray->qty_max; ?>"
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
                                           <span
                                               id="cost_<?php echo $productShowcartArray->key; ?>"><?php echo lkvUtil::formatPrice($productShowcartArray->pro_cost, 'đ'); ?></span>
                                            <br/>
                                            CTVien giảm:<span id="dc_<?php echo $productShowcartArray->key; ?>"><?php echo lkvUtil::formatPrice($productShowcartArray->em_discount, 'đ'); ?></span>
                                        </div><!--/Col8-->
                                    </div><!-- /form-group-->
                                    <div class="row">
                                        <div class="col-xs-4">
                                            <p>Thành tiền: </p>
                                        </div><!--/col4-->
                                        <div class="col-xs-8">
                                            <!--Thanh tien -->
                                            <div id="sub_<?php echo $productShowcartArray->key; ?>">
                                                <b><?php echo lkvUtil::formatPrice($productShowcartArray->pro_cost * $productShowcartArray->qty, 'đ'); ?></b>
                                            </div>
                                            <div id="dc_<?php echo $productShowcartArray->key; ?>">
                                                <?php echo $productShowcartArray->em_discount > 0 ? '-' . lkvUtil::formatPrice($productShowcartArray->em_discount, 'đ') : ''; ?>
                                            </div><!--/thanhtien-->
                                            <input type="checkbox" name="checkone[]" class="checkbox"
                                                   value="<?php echo $productShowcartArray->key; ?>" />
                                        </div><!--/Col8-->
                                    </div><!-- /form-group-->
                                </li>
                                <?php
                                $idDiv ++;
                                $backCategory = $productShowcartArray->pro_category; ?>
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
                                    <a href="<?php echo base_url() . 'checkout/' . $key . '/' . $shops[$key]['sho_link']; ?>"
                                       class="btn btn-block btn-order" <?php if($noAccesss == 1){ ?>
                                        onclick="alert('Bạn là thành viên Azibai, bạn không có quyền mua hàng khi đăng nhập, hay thoát ra và đặt hàng bằng tài khoản khác hoặc đặt hàng qua email. <a href=\'<?php echo base_url() ?>logout\'>Thoát ngay</a>'); return false;" <?php } ?> >
                                        Đặt hàng</a>
                                </div>
                            </div>
                        </ul>
                    <?php }?>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Thông báo</h4>
                                    </div>
                                    <div class="modal-body">
                                         <div class="alert alert-warning">
                                        Bạn vui lòng click <a id="btn_login" href="<?php echo base_url()?>login?action=buyer">vào đây để đăng nhập</a>. <br/>Nếu chưa có xin vui lòng đăng ký <a href="<?php echo base_url();?>/register?action=buyer">tại đây</a>
                                         </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- Ket thuc thong tin nguoi mua hang-->

                    <?php endforeach; ?>

                    <div class="control-button">
                        <script>ResetQuantity('Quantity', 2);</script>
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="20%" id="delete_showcart">
                                    <?php
                                    if (count($user) > 0) {
                                        $new_key = $key;
                                        $disb = 'style="display:none"';
                                    } else
                                        $new_key = $key + 1;
                                    ?>
<!--                                    <img src="<?php echo base_url(); ?>templates/home/images/icon_deleteshowcart.gif"
                                         onclick="_slvDeleteCart('frmShowCart')" style="cursor:pointer;"
                                         border="0" alt=""/>-->
                                    <input type="button" value="XÓA" class="btn btn-default1" onclick="_slvDeleteCart('frmShowCart')"/>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Ket thuc thong tin nguoi mua hang-->
                    <div id="tmm-form-wizard">
                        <div class="row stage-container">
                            <div class="stage tmm-current col-md-3 col-sm-3">
                                <div class="stage-header head-icon head-icon-lock"><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                                <div class="stage-content">
                                    <h3 class="stage-title">Thông tin nhận hàng</h3>
                                </div>
                            </div><!--/ .stage-->

                            <div class="stage col-md-3 col-sm-3">
                                <div class="stage-header head-icon head-icon-user">
                                    <i class="fa fa-credit-card" aria-hidden="true"></i>
                                </div>
                                <div class="stage-content">
                                    <h3 class="stage-title">Hình thức thanh toán</h3>
                                </div>
                            </div><!--/ .stage-->

                            <div class="stage col-md-3 col-sm-3">
                                <div class="stage-header head-icon head-icon-payment">
                                    <i class="fa fa-truck fa-flip-horizontal" aria-hidden="true"></i>
                                </div>
                                <div class="stage-content">
                                    <h3 class="stage-title">Chọn nhà vận chuyển</h3>
                                </div>
                            </div><!--/ .stage-->

                            <div class="stage col-md-3 col-sm-3">
                                <div class="stage-header head-icon head-icon-details">
                                    <i class="fa fa-check-square" aria-hidden="true"></i>
                                </div>
                                <div class="stage-content">
                                    <h3 class="stage-title">Xác nhận đặt hàng</h3>
                                </div>
                            </div><!--/ .stage-->
                        </div>
                    </div>
                    <div class="infomation_show_shopping infomation_show_shopping<?php echo $key ?>">
                        <div class="content payment_step_1">
                            <div class="row">
                                <div class="col-lg-12 col-md-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-map-marker"></i> Thông tin người nhận</h3>
                                        </div>
                                        <div class="panel-body form_table_revice<?php echo $key ?> form-horizontal">
                                            <div class="form-group">
                                                <div class="form_text">
                                                    <div class="col-sm-12 text-success">
                                                        <input type="checkbox"
                                                               value="1" name="check_same" class="check_same"
                                                               id="check_same">
                                                        <label for="check_same"><h5>Đặt lại thông tin</h5></label>
                                                        <div class="info_required">(*) là bắt buộc</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ord_sname_get" class="col-sm-2"><span
                                                        class="form_asterisk"></span><strong><span class="info_required">*</span> Tên người nhận:</strong></label>

                                                        <div class="col-sm-10 form_text"><input type="text" maxlength="250" placeholder="Nhập tên người nhận"
                                                                                       value="<?php echo $user->use_fullname; ?>" name="ord_sname"
                                                                                       id="ord_sname_get"
                                                                                       title=" " autocomplete="off"
                                                                                       class="form-control required">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ord_address_get" class="col-sm-2"><span class="
                                                                                              text-danger"></span><strong><span class="info_required">*</span> Địa chỉ đường :</strong></label>

                                                <div class="col-sm-10 form_text"><input type="text" maxlength="250" placeholder="Nhập địa chỉ đường"
                                                                                       value="<?php echo $user->use_address; ?>"
                                                                                       name="ord_address"
                                                                                       id="ord_address_get"
                                                                                       title=" " autocomplete="off"
                                                                                       class="form-control required ord_address">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="ord_smobile_get" class="col-sm-2"><span
                                                        class="form_asterisk"></span><strong><span class="info_required">*</span> Số điện thoại:</strong></label>

                                                        <div class="col-sm-10 form_text"><input type="text" maxlength="250" placeholder="Nhập số điện thoại"
                                                                                       value="<?php echo $user->use_mobile; ?>" name="ord_smobile"
                                                                                       id="ord_smobile_get"
                                                                                       title="Di động"
                                                                                       autocomplete="off"
                                                                                       class="form-control required">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="user_province_get" class="col-sm-2"><span class="
                                                                                              text-danger"></span><strong><span class="info_required">*</span> Tỉnh/Thành :</strong></label>

                                                <div class="col-sm-10 form_text">
                                                    <select name="user_province" id="user_province_get" class="form-control">
                                                        <option value="">Chọn Tỉnh/Thành</option>
                                                        <?php foreach ($province as $vals): ?>
                                                            <option value="<?php echo $vals->pre_id; ?>" <?php echo ($vals->pre_id == $user->use_province)?"selected='selected'":""; ?> ><?php echo $vals->pre_name; ?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>
                                             <div class="form-group">
                                                <label for="user_district_get" class="col-sm-2"><span class="
                                                                                              text-danger"></span><strong><span class="info_required">*</span> Quận/Huyện :</strong></label>

                                                <div class="col-sm-10 form_text">
                                                    <select name="user_district" id="user_district_get" class="form-control">
                                                        <option value="">Chọn Quận/Huyện</option>
                                                        <?php foreach ($district as $vals): ?>
                                                            <option value="<?php echo $vals->DistrictCode; ?>" <?php echo ($vals->DistrictCode == $user->user_district)?"selected='selected'":""; ?> ><?php echo $vals->DistrictName; ?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="ord_semail_get" class="col-sm-2"><span
                                                        class="form_asterisk"></span><strong>Email :</strong></label>

                                                        <div class="col-sm-10 form_text"><input type="text" maxlength="250" placeholder="Nhập email"
                                                                                       value="<?php echo $user->use_email; ?>" name="ord_semail"
                                                                                       id="ord_semail_get"
                                                                                       title=" " autocomplete="off"
                                                                                       class="form-control email">
                                                </div>

                                            </div>

                                            <div class="form-group">
                                                <label for="ord_note_get" class="col-sm-2"><span
                                                        class="form_asterisk"></span><strong>Ghi chú :</strong></label>

                                                        <div class="col-sm-10 form_text">
    <textarea type="text" maxlength="255" placeholder="Nhập ghi chú" name="ord_note" id="ord_note_get" class="form-control"></textarea>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="break_content"></div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-usd"></i> Phương thức thanh toán</h3>
                                        </div>
                                        <div class="panel-body payment_method form-inline">

                                            <?php   if($infoPayment->info_nganluong) { ?>
                                                <div class="form-group">
                                                <label><input type="radio" value="info_nganluong" name="payment_method" class="info_nganluong" id="info_nganluong"> <i class="fa fa-credit-card"></i>

                                                    Thanh toán Trực tuyến</label>
                                                <div class="nl-payment-more">
                                                    <ul class="list-content">
                                                        <li class="active">
                                                            <label><input type="radio" value="NL" name="payment_method_nganluong"
                                                                          checked>Thanh toán bằng Ví điện tử Ngân Lượng</label>

                                                            <div class="boxContent">
                                                                <p>
                                                                    Giao dịch. Đăng ký ví NganLuonng.vn miễn phí <a
                                                                        href="https://www.nganluong.vn/?portal=nganluong&amp;page=user_register"
                                                                        target="_blank">tại đây</a></p>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <label><input type="radio" value="ATM_ONLINE"
                                                                          name="payment_method_nganluong">Thanh toán online bằng
                                                                thẻ ngân hàng nội địa</label>

                                                            <div class="boxContent">
                                                                <p><i>
                                                                        <span
                                                                            style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>:
                                                                        Bạn cần đăng ký Internet-Banking hoặc dịch vụ
                                                                        thanh toán trực tuyến tại ngân hàng trước khi
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
                                                                            <i class="DAB" title="Ngân hàng Đông Á"></i>
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
                                                                            <i class="ACB" title="Ngân hàng Á Châu"></i>
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
                                                                            <i class="VAB" title="Ngân hàng Việt Á"></i>
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
                                                                            <i class="NAB" title="Ngân hàng Nam Á"></i>
                                                                            <input type="radio" value="NAB"
                                                                                   name="bankcode">

                                                                        </label></li>

                                                                    <li class="bank-online-methods ">
                                                                        <label for="sml_atm_bab_ck_on">
                                                                            <i class="BAB" title="Ngân hàng Bắc Á"></i>
                                                                            <input type="radio" value="BAB"
                                                                                   name="bankcode">

                                                                        </label></li>

                                                                </ul>

                                                            </div>
                                                        </li>
                                                        <li>
                                                            <label><input type="radio" value="VISA"
                                                                          name="payment_method_nganluong" selected="true">Thanh
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
                                                if ($value && $k != 'id_user' && $k != "info_nganluong" && $k != "info_bank"):
                                                    $p++;
                                                    ?>
                                                    <div class="method current fl">
                                                        <div class="form-group right_baokim">
                                                            <input checked="checked" id="id_<?php echo $p; ?>" class=""
                                                                   title="<?php echo $value ?>" type="radio"
                                                                   value="<?php echo $k; ?>" name="payment_method"/>
                                                            <label title="<?php echo $value ?>"
                                                                   for="id_<?php echo $p; ?>"> <i class="fa fa-truck"></i> <?php echo $this->lang->line("title" . $k); ?></label>
                                                        </div>
                                                    </div>
                                                <?php
                                                endif;
                                            endforeach; ?>

                                        </div>
                                        <div class="break_content"></div>
                                    </div>
                                </div>


                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-truck"></i> Chọn nhà vận chuyển</h3>
                                        </div>
                                        <div class="panel-body payment_method">
                                            <b>Vận chuyển toàn quốc:</b>
                                            <ul class="transport">
<li>
Giao hàng đến: <strong><span id='shipper_to_address'><?php echo ($shipping_fee[$productShowcartArray->pro_id]['shipping_address'])?$shipping_fee[$productShowcartArray->pro_id]['shipping_address']:''; ?></span></strong>

<strong><span id='shipper_to_district'><?php echo ($shipping_fee[$productShowcartArray->pro_id]['shipping_district'])?$shipping_fee[$productShowcartArray->pro_id]['shipping_district']:''; ?></span></strong>
<strong><span id='shipper_to_province'><?php echo ($shipping_fee[$productShowcartArray->pro_id]['shipping_province'])?$shipping_fee[$productShowcartArray->pro_id]['shipping_province']:''; ?></span></strong>
</li>
<?php
$company = array("GHN"=>"GIAO HÀNG NHANH");
?>
<li>Thông qua :
    <select name="company" id="company" class="form-control">
        <?php foreach ($company as $key => $vals): ?>
            <option value="<?php echo $key; ?>" <?php echo ($shipping_fee[$productShowcartArray->pro_id]['shipping_fee'])?"selected='selected'":""; ?> ><?php echo $vals ?></option>
        <?php endforeach;?>
    </select>
</li>
                                                                <span id="pending"></span>
                                                                <div id="has-error"></div>
                                                            </ul>
                                        </div>
                                        <div class="break_content"></div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-money"></i> Tổng thành tiền</h3>
                                        </div>
                                        <div class="panel-body payment_method">
                                            <ul  class="ulSumMoney">
                                                <li>
                                                    <label><?php echo $this->lang->line('total_cost_vc_defaults').':'; ?></label>
                                                    <span id="total_vc"><?php echo lkvUtil::formatPrice($total_vc, 'đ'); ?></span>
                                                </li>
                                                <li  class="sumMoney">
                                                    <label><?php echo $this->lang->line('total_cost_showcart_defaults').':'; ?></label>
                                                    <span id="total"><?php echo lkvUtil::formatPrice($total, 'đ'); ?></span>
                                                    <input type="hidden" value="<?php echo $total;?>" name="amount" />
                                                </li>
                                            </ul>
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
                        <div class="bottom">
                            <div class="fl"></div>
                            <div class="fr"></div>
                        </div>
                        <input type="submit" value="ĐẶT HÀNG" class="btn-checkout"/>
                    </div>

                </form>
            </div>
            <script type="text/javascript">
                jQuery(document).ready(function ($) {
                    //updatePrice();

                    /*$('input.productQty').change(function(){

                     });*/
                    $(".show_shopping").click(function (){
                        var qtyValid = true;
                        $('input.productQty').each(function(){
                            if($(this).val() == '' || $(this).val() == '0'){
                                qtyValid = false;
                                $(this).addClass('has-error');
                            }else if( parseInt($(this).val(), 10) <= 0){
                                qtyValid = false;
                                $(this).addClass('has-error');
                            }
                        });
                        if(qtyValid == true){
                            var key = $(this).attr('id');
                            $('#frmShowCart').validate();
                        }else{
                            alert('Vui lòng nhập số lượng hợp lệ!');
                        }
                    });
                    $( "#user_province_get" ).change(function() {

                        if($("#user_province_get").val()){

                            $.ajax({
                                url     : siteUrl  +'home/showcart/getDistrict',
                                type    : "POST",
                                data    : {user_province_put:$("#user_province_get").val()},
                                beforeSend: function(){
                                    document.getElementById("user_province_get").disabled = true;
                                },
                                success:function(response)
                                {
                                    document.getElementById("user_province_get").disabled = false;
                                    if(response){
                                        var json = JSON.parse(response);
                                        emptySelectBoxById('user_district_get',json);
                                        delete json;
                                    } else {
                                        alert("Lỗi! Vui lòng thử lại");
                                    }
                                },
                                error: function()
                                {
                                    alert("Lỗi! Vui lòng thử lại");
                                }
                            });
                        }
                    });

                    $( "#user_district_get" ).change(function() {
                        if($("#user_district_get").val()){
                            $("#company").val("GHN");
                            getGHN_info('user_district_get');
                        }
                    });

                    $( "#company" ).change(function() {
                        if($(this).val() != ""){
                            getGHN_info('company');
                        }
                    });

                    /** Đừng có sửa vị trí code này đi nhé. By Phuc Nguyen**/
                    !function($) {
                        "use strict";
                        var FormValidator = function() {
                            this.$frmShowCart = $("#frmShowCart");
                        };

                        FormValidator.prototype.init = function() {
                            $.validator.setDefaults({
                                submitHandler: function() {
                                    this.$frmShowCart.submit();
                                }
                            });

                            this.$frmShowCart.validate({
                                rules: {
                                    ord_sname				:	"required",
                                    ord_address				:	"required",
                                    ord_smobile				:	"required",
                                    user_province                           :       "required",
                                    user_district                           :       "required",
                                },
                                messages: {
                                    ord_sname				:	"Thông tin bắt buộc",
                                    ord_address				:	"Thông tin bắt buộc",
                                    ord_smobile                             :   "Thông tin bắt buộc",
                                    user_province                             :   "Thông tin bắt buộc",
                                    user_district                             :   "Thông tin bắt buộc",
                                }
                            });
                        },
                            $.FormValidator = new FormValidator, $.FormValidator.Constructor = FormValidator
                    }(window.jQuery),

                        function($) {
                            "use strict";
                            $.FormValidator.init()
                        }(window.jQuery);


                });
            </script>
            <?php } else { ?>
                <div class="alert alert-info" role="alert">
                    <?php echo $this->lang->line('none_record_showcart_defaults'); ?>! Vui lòng trở lại <a
                        href="<?php echo base_url(); ?>">Trang chủ Azibai</a> tìm sản phẩm và chọn thêm vào Giỏ hàng!
                </div>
            <?php } ?>
        </div>
    </div>
    <!-- END CENTER-->
<?php $this->load->view('home/common/footer'); ?>
<?php if (isset($fullProductShowcart) && $fullProductShowcart == true) { ?>
    <script>alert('<?php echo $this->lang->line('full_product_showcart_defaults'); ?>');</script>
<?php } ?>
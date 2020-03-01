<?php $this->load->view('shop/affiliate/header'); ?>
<style>	
.container ol.breadcrumb {margin-top: 20px; border: 1px solid #ccc;}
.container .showcart {min-height:400px;}
.table>tbody>tr>td{ vertical-align: middle; }
#tmm-form-wizard .stage-container{padding:15px 0 4px;}
#tmm-form-wizard .stage-container .fa{padding-top:13px;}
#tmm-form-wizard .stage{display:inline-block;position:relative;text-align:center;min-height:112px;}
#tmm-form-wizard .stage:before,
#tmm-form-wizard .stage:after{position:absolute;background-color:#eaeaea;top:50%;margin-top:-33px;width:50%;height:5px;border-top:1px solid #d9d9d9;border-bottom:1px solid #d9d9d9;content:'';}
#tmm-form-wizard .stage:before{left:0;}
#tmm-form-wizard .stage:after{right:0;}
#tmm-form-wizard .stage:first-child:before{display:none;}
#tmm-form-wizard .stage:first-child + .stage + .stage + .stage:after{display:none;}
#tmm-form-wizard .stage.tmm-current .stage-header{background-color:#fb6b5b;border:none;}
#tmm-form-wizard .stage.tmm-current .stage-header .fa{color:#fff;}
#tmm-form-wizard .stage.tmm-current .stage-header.head-number{color:#fff;text-shadow:1px 1px 0px rgba(0, 0, 0, .9);}
#tmm-form-wizard .stage.tmm-current:after,
#tmm-form-wizard .stage.tmm-current:before{background-color:#fb6b5b;border:none;}
#tmm-form-wizard .stage.tmm-success .stage-header{background-color:#92cf5c;border:none;}
#tmm-form-wizard .stage.tmm-success .stage-header.head-number{color:#3c611b;text-shadow:1px 1px 0px rgba(173, 219, 114, 1);}
#tmm-form-wizard .stage.tmm-success:after,
#tmm-form-wizard .stage.tmm-success:before{background-color:#92cf5c;border:none;}
#tmm-form-wizard .stage.tmm-success .stage-header:after{position:absolute;top:51px;left:-51px;color:#696969;font-family:'fontello';font-size:16px;color:#92cf5c;content:'\e83b';text-shadow:none;font-weight:100;}
#tmm-form-wizard .stage.tmm-success .stage-header.head-number:after{top:42px;}
#tmm-form-wizard .stage-header{display:inline-block;width:50px;height:50px;background-color:#eaeaea;text-align:center;font-size:20px;color:#a9a9a9;border:1px solid #d9d9d9;position:relative;z-index:1;-webkit-border-radius:50%;border-radius:50%;}
#tmm-form-wizard .stage-header.head-number{color:#a9a9a9;font-family:'Arial', sans-serif;font-weight:bold;color:#a9a9a9;font-family:'Arial', sans-serif;font-weight:bold;line-height:2.2em;margin-bottom:7px;}
#tmm-form-wizard .stage-content{margin:0 auto;padding-left:50px;}
#tmm-form-wizard .stage-title{font:400 15px 'calibriregular', sans-serif;color:#464646;padding-left:0px;text-align:left;}
#tmm-form-wizard .stage-info{text-align:left;color:#a8a8a8;font-family:'calibriregular', sans-serif;font-size:11px;line-height:1.4;}
.panel-primary > .panel-heading{background-color:#666666!important;border-top-left-radius: 0px!important;border-top-right-radius: 0px!important;}
.panel-primary{border-color:#666666!important;}	
.list-content li{list-style:none outside none;margin:0 0 10px;}
.list-content li .boxContent{display:none;width:100%;border:1px solid #cccccc;padding:10px;}
.list-content li.active .boxContent{display:block;}
.list-content li .boxContent ul{height:100%;}
ul.cardList li{list-style: none; cursor:pointer;float:left;margin-right:0;padding:5px 4px;text-align:center;width:90px;}
i.VISA, i.MASTE, i.AMREX, i.JCB, i.VCB, i.TCB, i.MB, i.VIB, i.ICB, i.EXB, i.ACB, i.HDB, i.MSB, i.NVB, i.DAB, i.SHB, i.OJB, i.SEA, i.TPB, i.PGB, i.BIDV, i.AGB, i.SCB, i.VPB, i.VAB, i.GPB, i.SGB,i.NAB,i.BAB{width:80px;height:30px;display:block;background:url(https://www.nganluong.vn/webskins/skins/nganluong/checkout/version3/images/bank_logo.png) no-repeat;}
i.MASTE{background-position:0px -31px}
i.AMREX{background-position:0px -62px}
i.JCB{background-position:0px -93px;}
i.VCB{background-position:0px -124px;}
i.TCB{background-position:0px -155px;}
i.MB{background-position:0px -186px;}
i.VIB{background-position:0px -217px;}
i.ICB{background-position:0px -248px;}
i.EXB{background-position:0px -279px;}
i.ACB{background-position:0px -310px;}
i.HDB{background-position:0px -341px;}
i.MSB{background-position:0px -372px;}
i.NVB{background-position:0px -403px;}
i.DAB{background-position:0px -434px;}
i.SHB{background-position:0px -465px;}
i.OJB{background-position:0px -496px;}
i.SEA{background-position:0px -527px;}
i.TPB{background-position:0px -558px;}
i.PGB{background-position:0px -589px;}
i.BIDV{background-position:0px -620px;}
i.AGB{background-position:0px -651px;}
i.SCB{background-position:0px -682px;}
i.VPB{background-position:0px -713px;}
i.VAB{background-position:0px -744px;}
i.GPB{background-position:0px -775px;}
i.SGB{background-position:0px -806px;}
i.NAB{background-position:0px -837px;}
i.BAB{background-position:0px -868px;}
</style>

<div class="container">
   <ol class="breadcrumb">
      <li><a href="/affiliate/product/">Trang chủ</a></li>
      <li><a href="/affiliate/checkout/">Giỏ hàng</a></li>
   </ol>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">        
         
            <?php if (!empty($cart)) { ?>
            <script type="text/javascript" src="<?php echo base_url() ?>/templates/home/js/jquery.validate.min.js"></script>
            <script type="text/javascript">
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
                var shop_id = <?php echo $_shop['sho_user']; ?>;
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
                                    $('#dc_' + cart[i].products[j].key).text('Giảm sỉ: '+$.fn.number(cart[i].products[j].em_discount));
                                }else{
                                    $('#dc_' + cart[i].products[j].key).text('');
                                }
                            }
                        }
                    }
                    
                    $('#total').text($.fn.number(total));
                    $('input[name="amount"]').val(total);
                }               

                function qtyChange(pKey, pNum, dpId) {
                    console.log(cart);
                    for (var i = 0, len = cart.length; i < len; ++i) {
                        // blah blah
                        if (cart[i].products.length > 0) {
                            for (var j = 0, prolen = cart[i].products.length; j < prolen; ++j) {
                                if (cart[i].products[j].key == pKey) {
                                    cart[i].products[j].qty = pNum;
                                    $.ajax({
                                        type: "POST",
                                        url:  "/affiliate/showcart/update_qty",
                                        data: $('#frmShowCart').serialize()+'&qty='+cart[i].products[j].qty+'&pro_id='+cart[i].products[j].pro_id+'&key='+cart[i].products[j].key+'&dp_id='+dpId+'&shop_id='+shop_id,
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

                function cart_update_qty(pro_id, num, dpid) {
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

                    qtyChange(pro_id, qty_new, dpid);
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

                function showLoading() {
                   $('.loading').show();
                   $('#aziload').show();
                }

                function hideLoading() {
                    $('#aziload').hide();
                }

                function showMessage(message, type) {
                    $('.loading').hide();
                    $('#myModal').modal('show');
                    $('#myModal .modal-content').html('<div class="alert ' + type + ' alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>' + message + '</div>');
              	}

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
			<h3 style="text-transform: uppercase" class="hidden-md hidden-lg">
                Xác nhận đặt hàng
            </h3>
            
            <div class="panel panel-primary">
				<div class="panel-heading">
					Coupon của gian hàng: 
					<?php echo $_shop['sho_name']; ?>
				</div>
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
                        $link = base_url() . $product->pro_category .'/'. $product->pro_id .'/'. RemoveSign($product->pro_name);
                        $numberCoupon = 0;
                        if($product->pro_type != 0){
                            $numberCoupon++;
                        }
                        ?>
                        <tr id="row_<?php echo $product->key; ?>">
                            <td class="hidden-xs"><?php echo $key + 1; ?></td>
                            <td>
                                <?php                                
                                $link_img = DOMAIN_CLOUDSERVER .'media/images/product/'. $product->pro_dir .'/thumbnail_1_';
                                $img1 = explode(',', $product->pro_image);
                                if($product->dp_id > 0){
                                    $link_image = $link_img . $product->dp_image;
                                } else {
                                    $link_image = $link_img . $img1[0];    
                                }                                       

                                if ($product->dp_image != "" || $img1[0] != "") { ?>
                                    <img width="80" src="<?php echo $link_image;?>" alt="" />
                                <?php } else { ?>
                                    <img width="80" src="<?php echo base_url() .'images/img_not_available.png'?>" alt="">
                                <?php } ?>
                                <a class="menu_1" href="<?php echo $link; ?>">
                                    <?php echo sub($product->pro_name, 200); ?>
                                </a>
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
                        <p><i>Bán từ shop: <a href="<?php echo base_url() . $_shop['sho_link']; ?>"><?php echo $_shop['sho_name']; ?></a></i></p>
                        <?php
                        $total = 0;
                        foreach ($cart as $key => $product):
                        $total += ($product->pro_cost * $product->qty - $product->em_discount );
                        $link = base_url() . $product->pro_category .'/'. $product->pro_id .'/'. RemoveSign($product->pro_name);
                        ?>
                        <li id="row_<?php echo $product->key; ?>" class="wrap_item">
                            <div class="row">
                                <div class="col-xs-4">
                                    <p>
                                        <?php
                                        $img1 = explode(',', $product->pro_image);
                                        $file_ex = 'media/images/product/'. $product->pro_dir .'/thumbnail_2_'. $img1[0];
                                        if ($img1[0] != "") {
                                            ?>
                                            <img width="75" src="<?php echo DOMAIN_CLOUDSERVER .'media/images/product/'. $product->pro_dir .'/thumbnail_3_'. $img1[0]; ?>"
                                                 alt=""/>
                                        <?php } else { ?>
                                            <img width="75" src="<?php echo base_url() .'images/img_not_available.png' ?>" alt="">
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
                                        <?php echo $product->em_discount > 0 ? '-'. lkvUtil::formatPrice($product->em_discount, 'đ') : ''; ?>
                                    </div><!--/thanhtien-->
                                </div><!--/Col8-->
                            </div><!-- /form-group-->
                        </li>
                        <?php endforeach; ?>
                    </ul>
                <?php } ?>
                </div>               

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

                                                <div class="col-sm-10 form_text"><input type="text" maxlength="250" placeholder="Nhập tên người nhận" value="<?php echo isset($_user['use_fullname']) ? $_user['use_fullname'] : ''; ?>" name="ord_sname" id="ord_sname_get" title=" " autocomplete="off"  class="form-control required">
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="ord_smobile_get" class="col-sm-2"><span class="form_asterisk"></span><strong><span  class="info_required">*</span> Số điện thoại:</strong></label>

                                                <div class="col-sm-10 form_text"><input type="text" maxlength="250"  placeholder="Nhập số điện thoại" value="<?php echo isset($_user['mobile']) ? $_user['mobile'] : ''; ?>" name="ord_smobile" id="ord_smobile_get"  title="Di động" autocomplete="off" class="form-control required">
                                                </div>
                                            </div>                                            

                                            <div class="form-group">
                                                <label for="ord_semail_get" class="col-sm-2"><span
                                                        class="form_asterisk"></span><strong><span
                                                            class="info_required">*</span> Email :</strong></label>

                                                <div class="col-sm-10 form_text">
                                                    <input type="text" maxlength="250" placeholder="Nhập email" value="<?php echo isset($_user['use_email']) ? $_user['use_email'] : ''; ?>" name="ord_semail" id="ord_semail_get" title="" autocomplete="off" class="form-control email">
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
                                        <div class="panel-body payment_method">

                                            <?php
                                            if ($infoPayment->info_nganluong) { ?>
                                                <div class="form-group"">
                                                    <label><input type="radio" value="info_nganluong"
                                                                  name="payment_method" class="info_nganluong"
                                                                  id="info_nganluong"> <i class="fa fa-credit-card"></i>

                                                        Thanh toán Trực tuyến</label>

                                                    <div class="nl-payment-more"  style="display: none;">
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
                                                                <label><input type="radio" value="VISA" name="payment_method_nganluong" selected="true">Thanh toán bằng thẻ Visa hoặc MasterCard</label>

                                                                <div class="boxContent">
                                                                    <p><span style="color:#ff5a00;font-weight:bold;text-decoration:underline;">Lưu ý</span>:Dùng
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
                                                        <input checked id="id_<?php echo $p; ?>"  title="<?php echo $value ?>" type="radio" value="<?php echo $k; ?>" name="payment_method"/>
                                                        <label title="<?php echo $value ?>" for="id_<?php echo $p; ?>"> <i class="fa fa-truck"></i> <?php echo $this->lang->line("title". $k); ?>
                                                        </label>
                                                    </div> 
                                                    <?php
                                                endif;
                                            endforeach; ?>

                                        </div>
                                        <div class="break_content"></div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12">
                                    <div class="panel panel-primary">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><i class="fa fa-money"></i> Tổng thành tiền</h3>
                                        </div>
                                        <div class="panel-body payment_method">
                                            <ul class="ulSumMoney">                        
                                                <li>
                                                    <label>Tổng thành tiền</label>
                                                    <span class="text-danger" id="total"><?php echo lkvUtil::formatPrice($total, 'đ'); ?></span>
                                                    <input type="hidden" value="<?php echo $total; ?>" name="amount"/>
                                                </li>
                                            </ul>
											<p style="padding:10px 0;"><i class="fa fa-tags"></i> E-Coupon: sau khi thực hiện đặt hàng và thanh toán, bạn sẽ nhận được mã coupon điện tử gửi đến địa chỉ email cung cấp ở trên.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        
                        <input type="submit" value="ĐẶT HÀNG" class="btn btn-default1 btn-checkout"/>
                    </div>
                </form>
            </div>

            <script type="text/javascript">
                jQuery(document).ready(function ($) { 
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
                            url: "/showcart/place_order_v2",
                            dataType: "json",
                            data : $(form).serialize()+'&sho_user='+shop_id,
                            success: function(result) {
                                console.log(result);
                                $(form).find('input.btn-checkout').removeClass('procesing');
                                    if(result.error == false){
                                        if (result.payment_method == "info_nganluong") {  
                                            window.open(siteUrl + "payment/order_bill_nganluong/"+result.order_id+"?order_token="+result.order_token,'_blank');
                                            window.open("/payment/order_bill_nganluong/"+result.order_id+"?order_token="+result.order_token,'_blank');
                                        } else {                                            
                                            window.location =  "/orders-success/"+result.order_id+"?order_token="+result.order_token;
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
                               
                                case 'ord_smobile':
                                    error.insertAfter($("#ord_smobile_get"));
                                    break;
                                                           
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
                    
                    orderForm.find('input[name="ord_smobile"]').rules("add", {
                        required: true,
                        messages: {
                            required: "Vui lòng nhập số điện thoại."
                        }
                    });                                        
                });
            </script>
            	
            <?php } else { ?>                    
               <div class="alert alert-info" role="alert">
                    <?php echo $this->lang->line('none_record_showcart_defaults'); ?>! Vui lòng trở lại <a href="/">trang coupon và dịch vụ</a> chọn thêm vào giỏ hàng!
                </div>
            <?php } ?>         
      </div>
   </div>  
</div>

<?php $this->load->view('shop/affiliate/footer'); ?>

<?php if (isset($fullProductShowcart) && $fullProductShowcart == true) { ?>
    <script>alert('<?php echo $this->lang->line('full_product_showcart_defaults'); ?>');</script>
<?php } ?>
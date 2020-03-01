<?php
$total_product_cart = $total_coupon_cart = 0;
$_cart = $this->session->userdata('cart');
$_cart_coupon = $this->session->userdata('cart_coupon');
if(count($_cart) > 0) {
	foreach ($_cart as $key => $shop_cart) {
		$total_product_cart += count($shop_cart);
	}
}

if(count($_cart_coupon) > 0) {
	foreach ($_cart_coupon as $key => $shop_cart) {
		$total_coupon_cart += count($shop_cart);
	}
}

$currentuser = !empty($azitab['user']) ? $azitab['user'] : '';
$af_key = '';
if(!empty($currentuser)){
    $af_key = $currentuser->af_key;
}

$this->load->view('home/common/header_new');
?>

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

<link rel="stylesheet" type="text/css" href="/templates/home/styles/css/shop.css">
<script src="/templates/home/styles/js/common.js"></script>
<style>
	.num-tab {
		font-size: 12px;
		color: #737373;
	}
</style>
<main class="cart-content main-content">
      <div class="breadcrumb">
			<div class="container">
				<ul>
				  <li><a href="<?=azibai_url("/shop/products".(!empty($af_key) ? "?af_id=$af_key" : ""))?>">Sàn mua sắm Azibai</a><img src="/templates/home/images/svg/breadcrumb_arrow.svg" class="ml10" alt=""></li>
				  <li>Giỏ sản phẩm</li>
				</ul>
			</div>
      </div>
      <div class="container">
	        <div class="tit-sanpham-phieumuahang">
	          <p class="<?php echo $type == 'product' ? 'active' : '' ?>"><a href="/v-checkout">Sản phẩm <span class="num-tab">(<?=$total_product_cart?>)</span></p>
	          <p class="<?php echo $type == 'coupon' ? 'active' : '' ?>"><a href="/v-checkout/coupon">Phiếu mua hàng <span class="num-tab">(<?=$total_coupon_cart?>)</span></a></p>
	        </div>
      </div>  
      <div class="cart-content-detail">
        <div class="container">
			<?php if (empty($cart)) { ?>
			<div class="alert alert-info" role="alert">
				<?php echo $this->lang->line('none_record_showcart_defaults'); ?>! Vui lòng trở lại 
				<a  href="<?php echo getAliasDomain($linkreturn); ?>"><strong>Trang mua sắm</strong></a> tìm sản phẩm và chọn thêm vào Giỏ hàng!
			</div>
			<?php } else { ?>


	        <!-- <div class="select-all-cart">
	            <div class="check-all">
	              <label class="checkbox-style">
	                <input type="checkbox" class="checkout_all" name="" value="all" checked="checked">
	                <span>Lựa chọn tất cả sản phẩm</span>
	              </label>
	            </div>
	            <div class="delete-all" data-type="<?php echo $type?>">
	              <img src="/templates/home/images/svg/delete.svg" alt="">
	              Xóa
	            </div>
	        </div> -->

          	<!-- each shop -->
          		<?php  $total = 0; ?>
            	<?php foreach ($cart as $key => $shop) {?>
		          <div class="cartItem js-cartItem">
			            <div class="shopInfo">
			              <label class="checkbox-style-circle">
			                <input type="radio" class="js-check-shop" name="cartShop"><span>Người bán: <strong class="ml10"><?php echo $shops[$key]['sho_name']; ?></strong></span>
			              </label>
			            </div>
			            <div class="productCartItemWrapper">
			              <table>
			                <tr>
			                  <th class="bg-gray">Sản phẩm</th>
			                  <th class="sm-none">Giá bán </th>
			                  <th class="sm-none">Số lượng </th>
			                  <th class="sm-none">Thành tiền</th>
			                </tr>

							<?php foreach ($shop as $key_num => $product) { 
									// $total += $product->pro_cost * $product->qty - $product->em_discount;                               
	                                $link = getAliasDomain() . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
	                                $link_name = $mainDomain . $product->pro_category . '/' . $product->pro_id . '/' . RemoveSign($product->pro_name);
	                                $link_img = DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/thumbnail_1_';
	                                
	                                if ($product->dp_id > 0) 
	                            	{
	                                    $img_product = $file_ex = $link_img . $product->dp_image;
	                                }
	                                else if ($product->pro_image != '') {
	                                	$get_img = explode(',', $product->pro_image);

	                                	if (!empty($get_img[0])) 
	                                	{
	                                        $img_product = $link_img . $get_img[0];
	                                    }
	                                } else {
	                                	$img_product = getAliasDomain() . 'images/img_not_available.png';
	                                }
	                                
							?>

							<tr id="row_<?php echo $product->key; ?>" class="js-productCartItems" data-id="<?php echo $product->key; ?>">
								<td>
				                    <div class="productCartItems">
				                      <div class="productCartItem">
				                        <div class="btn-check">
				                          <label class="checkbox-style">
				                            <input type="checkbox" class="check_cart_item" value="<?php echo $product->key; ?>"><span></span>
				                          </label>
				                        </div>
				                        <div class="productCard">
				                          <div class="card-horiz">
				                            <span class="imageWrap">
				                              <img src="<?php echo $img_product ?>" alt="">
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
				                            	<button type="button" class="sub symbol" onclick="cart_update_qty('<?php echo $product->key; ?>', -1, <?php echo $product->dp_id; ?>, this, 'product');">-</button>
				                            	<input readonly="readonly" type="number" value="<?php echo $product->qty; ?>"
				                            	class="qty_<?php echo $product->key; ?> number" 
				                            	min="<?php echo ((int) $product->qty_min > 0 ? $product->qty_min : 1); ?>"
				                            	max="<?php echo ((int) $product->qty_max > 0 ? $product->qty_max : 1); ?>" />
				                            	<button type="button" class="add symbol" onclick="cart_update_qty('<?php echo $product->key; ?>', +1, <?php echo $product->dp_id; ?>, this, 'product');">+</button>
				                          	</div>
				                        </div>
				                        <button class="delete" onclick="deleteProduct('<?php echo $product->key; ?>', this, '<?php echo $type; ?>');">
				                        	<img src="/templates/home/images/svg/delete.svg" alt="" class="mr10">Xóa
				                        </button>
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
			                    		<span class="text-red">
			                    			<?php echo lkvUtil::formatPrice($product->pro_cost, 'VND'); ?>
			                    		</span>
			                    	</div>
			                  	</td>
			                  	<td class="sm-none">
				                    <div class="add-form">
				                      <button type="button" class="sub symbol" onclick="cart_update_qty('<?php echo $product->key; ?>', -1, <?php echo $product->dp_id; ?>, this, 'product');">-</button>
				                      <input readonly="readonly" type="number" value="<?php echo $product->qty; ?>"
				                      class="qty_<?php echo $product->key; ?> number" 
				                      min="<?php echo ((int) $product->qty_min > 0 ? $product->qty_min : 1); ?>" 
				                      max="<?php echo ((int) $product->qty_max > 0 ? $product->qty_max : 1); ?>" />
				                      <button type="button" class="add symbol" onclick="cart_update_qty('<?php echo $product->key; ?>', +1, <?php echo $product->dp_id; ?>, this, 'product');">+</button>
				                    </div>
				                </td>                  
				                <td class="sm-none">
				                    <div class="price">
				                      <div class="text-bold f18 one-line">
				                      	<span class="text-red sub_<?php echo $product->key; ?>">
				                      		<?php echo lkvUtil::formatPrice($product->pro_cost * $product->qty, 'VND'); ?>
				                      	</span>
				                      	<input type="hidden" id="total_<?php echo $product->key; ?>" value="<?php echo $product->pro_cost * $product->qty ?>">
				                      	<input type="hidden" id="total_dc_<?php echo $product->key; ?>" value="<?php echo $product->em_discount > 0 ? $product->em_discount : 0 ?>">
				                      </div>
				                      <button class="delete" onclick="deleteProduct('<?php echo $product->key; ?>', this, '<?php echo $type; ?>');">
				                      	<img src="/templates/home/images/svg/delete.svg" alt="" class="mr10">Xóa
				                      </button>
				                    </div>
				                </td>
							</tr>
							<?php } ?>
			              </table>
			            </div>
		          </div>
	        	<?php } ?>
          	<!-- end each shop -->

          	<!-- total -->
          	<div class="sum-bill">
	            <div class="price-bill">
	              <p class="txt">Tạm tính:</p>
	              <p><span class="text-red" id="total_all"><?php echo lkvUtil::formatPrice($total, 'VND'); ?></span></p>
	            </div>
	            <div class="btn-buy" data-type="<?php echo $type; ?>" data-route="<?php echo getAliasDomain(). 'v-checkout/order-address' ?>"><button>Mua</button></div>
          	</div>
          	<?php } ?>
        </div>
      </div>
    </main>
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

    var mes = '<?php echo $this->lang->line('none_record_showcart_defaults'); ?>! Vui lòng trở lại <a  href="<?php echo getAliasDomain($linkreturn); ?>"><strong>Trang mua sắm</strong></a> tìm sản phẩm và chọn thêm vào Giỏ hàng!';

    var cart = <?php echo json_encode(array_values($jsCart)); ?>;

    function cart_update_qty(pro_id, num, dpid, element, type) {
        $('.load-wrapp').show();
        var parent_update = $(element).closest('div.add-form');
        var get_input = $(parent_update).find('input.qty_' + pro_id); 
        var qty = parseInt($(get_input).val(), 10);
        var qty_min = parseInt($(get_input).attr('min'), 10);
        var qty_max = parseInt($(get_input).attr('max'), 10);
        var qty_new = qty + num;
        var meg = '';
        if (qty_new < qty_min) {
            qty_new = qty_min;
            meg = 'Bạn phải mua tối thiểu ' + qty_min + ' sản phẩm';
        }
        if (qty_new > qty_max) {
            qty_new = qty_max;
            meg = 'Xin lỗi, chúng tôi chỉ có ' + qty_max + ' sẩn phẩm trong kho';
        }
        if (qty_new == 0 ) {
            qty_new = 1;
            meg = 'Bạn phải mua tối thiểu 1 sản phẩm';
        }
       
        if (meg != '') {
            alert(meg);
        }
        else 
        {
            $(get_input).val(qty_new);
            if (qty != qty_new) {
                qtyChange(pro_id, qty_new, dpid, element, cart);
            }
        }
        $('.load-wrapp').hide();
    }

    function qtyChange(pKey, pNum, dpId, element, cart) {
      var element = $(element).parents('table');
      for (var i = 0, len = cart.length; i < len; ++i) {
        if (cart[i].products.length > 0) {
            for (var j = 0, prolen = cart[i].products.length; j < prolen; ++j) {
                if (cart[i].products[j].key == pKey) {
                    cart[i].products[j].qty = pNum;
                    $.ajax({
                        type: "POST",
                        url: "/showcart/update_qty",
                        data: {
                            qty: cart[i].products[j].qty,
                            pro_id: cart[i].products[j].pro_id,
                            key: cart[i].products[j].key,
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


    function updatePrice(store, element, cart) {
        for (var i = 0, len = cart.length; i < len; ++i) {
            if (typeof cart[i] !== "undefined") {
                if (cart[i].shop == store && cart[i].products.length > 0) {

                    for (var j = 0, prolen = cart[i].products.length; j < prolen; ++j) {
                        if (cart[i].products[j]) {
                            $rowPrice = cart[i].products[j].pro_cost * cart[i].products[j].qty;
                            $('.sub_' + cart[i].products[j].key).text($.fn.number($rowPrice));
                            $('#total_' + cart[i].products[j].key).val($rowPrice);
                            if (cart[i].products[j].em_discount > 0) {
                                $('.dc_' + cart[i].products[j].key).html('Được giảm <span class="text-red">' + $.fn.number(cart[i].products[j].em_discount) + '</span> cho đơn hàng.');
                                $('#total_dc_' + cart[i].products[j].key).val(cart[i].products[j].em_discount);
                            } else {
                                $('.dc_' + cart[i].products[j].key).empty();
                                $('#total_dc_' + cart[i].products[j].key).val(0);
                            }
                        }
                    }
                    get_total();
                    return;
                }
            }
        }
    }


    function deleteProduct(key, element, type) {
    	$('.load-wrapp').show();
        var tmp = key.split('_');
        var cart_delete = cart;
        var parent_element = $(element).parents('.js-cartItem');
        $.ajax({
            type: "POST",
            url: "/showcart/delete",
            data: {key: key, store: tmp[0], 'pro_id': tmp[1], type: type},
            dataType: "json",
            success: function (data) {
                if (data.error == false) {
                    $('.cartNum').text(data.num);
                    for (var i = 0, len = cart_delete.length; i < len; ++i) {
                        
                        if (cart_delete[i] && cart_delete[i].products.length > 0 && cart_delete[i].shop == tmp[0]) {
                            for (var j = 0, prolen = cart_delete[i].products.length; j < prolen; ++j) {
                                if (cart_delete[i].products[j] && key == cart_delete[i].products[j].key) {
                                    cart_delete[i].products.splice(j, 1);
                                    $('tr#row_' + key).remove();
                                }
                            }

                            if (cart_delete[i].products.length > 0) {
                                updatePrice(parseInt(tmp[0], 10), element, cart);
                            } else {
                                delete cart_delete[i];
                                $(parent_element).remove();
                                
                                if ($('.cart-content-detail .js-cartItem').length == 0) {
                                    $('.cart-content-detail .container').empty().append('<div class="alert alert-info" role="alert">' + mes + '</div>');
                                }
                                $('.load-wrapp').hide();
                            }
                            return;
                        }
                    }
                }
            }
        });
    }

    function get_total() {

    	// 	var list_input_check = $('.cart-content-detail').find('input.check_cart_item');
    	// 	var list_checked = $('.cart-content-detail').find('input.check_cart_item:checked');
    	// 	if (list_input_check.length == list_checked.length) {
  		// 	$('.checkout_all').prop('checked', true);
  		// } else {
  		// 	$('.checkout_all').prop('checked', false);
  		// }
  		var shop_checked = $("input.js-check-shop:checked").parents('.js-cartItem');
    	// 
        var total = 0;
        var shop_checked = $("input.js-check-shop:checked").closest('.js-cartItem');
        if (shop_checked.length > 0) 
        {
        	var list_total_element = $(shop_checked).find('.js-productCartItems');
        	$.each(list_total_element, function( index, value ) {
			  	var check_cart_item = $(this).find('.check_cart_item');
			  	if (check_cart_item.prop('checked')) {
			  		var get_key = $(this).attr('data-id');
			  		total += parseInt($(this).find('input#total_'+get_key).val());
			  		total -= parseInt($(this).find('input#total_dc_'+get_key).val());
			  	}
			});
        }
        console.log(total);
        $('#total_all').text($.fn.number(total));
        $('.load-wrapp').hide();
    }

    $('.check_cart_item').change(function() {
    	var parent = $(this).parents('.js-cartItem');
    	var input_shop = $(parent).find('.js-check-shop');
    	
	  	if( $(this).is(':checked') ) {
	  		$(input_shop).prop('checked', true);
	  	} else {
	  		var list_checked = $(parent).find('input.check_cart_item:checked');
	  		if (list_checked.length == 0) {
	  			$(input_shop).prop('checked', false);
	  		}
	  	}

	  	var input_shop_not = $("input.js-check-shop:not(':checked')");
	  	$.each(input_shop_not, function( index, value ) {
		  	var list_checked = $(this).closest('.js-cartItem').find('input.check_cart_item');
		  	
		  	$.each(list_checked, function( index, value ) {
			  	$(this).prop('checked', false);
			});
		});

	  	get_total(); 
	});

	$('.js-check-shop').change(function() {
    	var parent = $(this).parents('.js-cartItem');
    	var list_checked = $(parent).find('input.check_cart_item');
    	var all_checked = $('.cart-content-detail').find('input.check_cart_item');

    	$.each(all_checked, function( index, value ) {
		  	$(this).prop('checked', false);
		});

	  	if( $(this).is(':checked') ) {
	  		$.each(list_checked, function( index, value ) {
			  	$(this).prop('checked', true);
			});
	  	}
	  	get_total(); 
	});

	$(".js-check-shop:radio:first").trigger("click");

	$('.checkout_all').change(function() {
    	var list_checked = $('.cart-content-detail').find('input.check_cart_item');
    	var list_shop_checked = $('.cart-content-detail').find('input.js-check-shop');
    	
	  	if( $(this).is(':checked') ) {
	  		$.each(list_checked, function( index, value ) {
			  	$(this).prop('checked', true);
			});
			$.each(list_shop_checked, function( index, value ) {
			  	$(this).prop('checked', true);
			});
	  	} else {
	  		$.each(list_shop_checked, function( index, value ) {
			  	$(this).prop('checked', false);
			});
	  		$.each(list_checked, function( index, value ) {
			  	$(this).prop('checked', false);
			});
	  	}
	  	get_total(); 
	});

	$('.delete-all').click(function(){
		$('.load-wrapp').show();
      	$.ajax({
            type: "POST",
            url: "/v-checkout/delete-all-qty",
            data: {
                type: $(this).attr('data-type'),
            },
            dataType: "json",
            success: function (data) {
                if (data.error == false) {
                    $('.cartNum').text(0);
                    $('.cart-content-detail .container').empty().append('<div class="alert alert-info" role="alert">' + mes + '</div>');
                }
                $('.load-wrapp').hide();
            }
        });
	});


	$('.btn-buy').click(function(){
		
		var type = $(this).attr('data-type');
		var list_checked = $('.cart-content-detail .container input.check_cart_item:checked');
		var list_key = [];
		var _this = $(this);
		
		if (list_checked.length > 0) {
			$.each(list_checked, function( index, value ) {
			  	list_key.push($(this).val());
			});
			if (list_key.length > 0) 
			{
				$('.load-wrapp').show();
				$(_this).prop( "disabled", true );
				$.ajax({
		            type: "POST",
		            url: "/v-checkout/order-temp",
		            data: {
		                list_key: list_key,
		                type: type
		            },
		            dataType: "json",
		            success: function (data) {
		                if (data.error == false) {
		                    window.location.href = $(_this).attr('data-route') +'?key='+ data.salt;
		                }
		            }
		        }).always(function() {
				    $('.load-wrapp').hide();
				    $(_this).prop( "disabled", true );
				});
			}
		} else {
			alert('Vui lòng chọn sản phẩm.');
		}
	});
	
</script>
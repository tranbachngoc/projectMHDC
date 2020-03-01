/*BEGIN: Get Product Shop*/
function getProduct(type, div, box, token, shop, style, baseUrl)
{
	//jQuery("#" + div).html('<img src="' + baseUrl + 'templates/shop/' + style + '/images/loading.gif" class="loading_image" />');
	jQuery.ajax({
	   type: "POST",
	   url: baseUrl + "shop/ajax",
	   data: "type=" + type + "&link=" + shop + "&token=" + token,
	   dataType: "json",
	   success: function(data){
			if(data[1] > 0)
			{
				str = '';
				if(data[0][0].pro_id!="" )
				{
					jQuery("#" + div).html('<img src="' + baseUrl + 'templates/shop/' + style + '/images/loading.gif" class="loading_image" />');
				}
				for(i = 0; i < data[1]; i++)
				{					
					str += '<div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 " id="' + box + i + '">';
					str += '<div class="product-item text-center">';
					str += '<h4><a class="tooltips" href="' + baseUrl + shop + '/product/detail/'+data[0][i].pro_id  +'/'  +data[0][i].pro_name_url+ '">';
					if(data[0][i].pro_image !='no_image.png'){
						str += '<input type="hidden" id="name-'+data[0][i].pro_id+'" value="'+data[0][i].pro_name+'"/>';
						str += '<input type="hidden" id="price-'+data[0][i].pro_id+'" value="'+addCommas(data[0][i].pro_cost)+' '+data[0][i].pro_currency+'"/>';
						str += '<input type="hidden" id="view-'+data[0][i].pro_id+'" value="'+data[0][i].pro_view+'"/>';
						str += '<input type="hidden" id="shop-'+data[0][i].pro_id+'" value="'+data[0][i].sho_name+'"/>';
						str += '<input type="hidden" id="pos-'+data[0][i].pro_id+'" value="'+data[0][i].pre_name+'"/>';
						str += '<input type="hidden" id="date-'+data[0][i].pro_id+'" value="'+data[0][i].sho_begindate+'"/>';
						str += '<input type="hidden" id="image-'+data[0][i].pro_id+'" value="'+baseUrl + 'media/images/product/' + data[0][i].pro_dir + '/' + showThumbnail(data[0][i].pro_id, data[0][i].pro_image, 3)+'"/>';
						str += '<div style="display:none" id="danhgia-'+data[0][i].pro_id+'" >'+data[0][i].sho_danhgia+'</div>';
						str += '<img alt= "'+data[0][i].pro_name +'" class="img-responsive" id="'+data[0][i].pro_id+'" src="' + baseUrl + 'media/images/product/' + data[0][i].pro_dir + '/' + showThumbnail(data[0][i].pro_id, data[0][i].pro_image, 3) + '" />';
					}else{
						str += '<img src="' + baseUrl + 'media/images/product/' + data[0][i].pro_image + '" class="image_boxpro" />';
					}
					str += '<div class="name_showbox_1">';
					str += '<span id="DivName_' + box + i + '"></span>';
					
					str += '</div>';
					if(data[0][i].pro_saleoff=='1'){
						str += '<div class="saleoff"><img src="' + baseUrl + '/templates/shop/' + style + '/images/saleoff.png"/></div>';	
					}else{
						str += '';	
					}
					str +='</a></h4><div class="price">';
					if(data[0][i].pro_cost==0){
						text_currency='';
						money='Gọi để biết giá';
					}else{
						text_currency = data[0][i].pro_currency;
						money = data[0][i].pro_cost;
					}
					str += '<span class="sale-price" id="DivCost_' + box + i + '"></span>&nbsp;' + text_currency;

					str += '</div>';
					str += '<div class="button-group">';
					str += '<a href="' + baseUrl + shop + '/product/detail/'+data[0][i].pro_id  +'/'  +data[0][i].pro_name_url+ '"><button class="btn btn-default  addtocart" type="button" title="Thêm vào giỏ" onclick="#"><i class="fa fa-cart-plus"></i>&nbsp;</button></a>&nbsp;';
					str += '<button class="btn btn-default  wishlist" type="button" title="Yêu thích" onclick="#"><i class="fa fa-heart-o"></i>&nbsp;</button>&nbsp;';
					str += '<button class="btn btn-default  compare" type="button" title="So sánh" onclick="#"><i class="fa fa-exchange"></i>&nbsp;</button>&nbsp;';
					str += '<button class="btn btn-default  quickview" type="button" title="Xem nhanh" onclick="#"><i class="fa fa-eye"></i>&nbsp;</button>';
					str += '</div>';					
					str += '</div></div></div>';
					str += '<script>subStr("' + data[0][i].pro_name + '", 50, "DivName_' + box + i + '");</script>';
					str += '<script>FormatCost("' + money + '", "DivCost_' + box + i + '");</script>';
					jQuery("#" + div).html(str);
				}
			}
			else
			{
				if(type == 3)
				{
					document.getElementById('TableSaleoff').style.display = "none";
				}
				else
				{
					//alert("No Data!");
				}
			}
		 },
		 error: function(){}
	});
}
function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}
/*END Get Product Shop*/
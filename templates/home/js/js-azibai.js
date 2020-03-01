// JavaScript Document
jQuery(document).ready(function() {
	jQuery('#singleBirdRemote').val(defSearchKeyword);
	jQuery("#navShopAllButton").hover(
	  function () {
		if(jQuery('#inner_menu').css('display') == 'none'){
			jQuery('#inner_menu').slideDown('slow'); 
		}
	  },
	  function () {
		
	  }
	);
	jQuery('#multi-ddm').dropDownMenu({ parentMO: 'parent-hover', childMO: 'child-hover1' });
	jQuery("#inner_menu").hover(
	  function () {
		if(jQuery('#inner_menu').css('display') == 'none'){
			jQuery('#inner_menu').slideDown('slow'); 
		}
	  },
	  function () {
		jQuery('#inner_menu').css('display','none');
	  }
	);
	jQuery('#k_hotro').hover(
		
		function(){
				//alert('aaaa');
				jQuery('#k_hotrocontent').css('display','block');
			},
		function(){
				jQuery('#k_hotrocontent').css('display','none');
			}
	);
	jQuery('#k_hotrocontent').hover(
		
		function(){
				jQuery('#k_hotrocontent').css('display','block');
			},
		function(){
				jQuery('#k_hotrocontent').delay(1000).css('display','none');
			}
	);
	$content_city = jQuery('#all_city').html();
	jQuery('.province_list').simpletip({ content:$content_city,fixed: true, position: 'bottom' });
	jQuery('#izilife_help').hover(
		function(){
				jQuery('#k_hotrocontent').css('display','block');
			},
		function(){
				jQuery('#k_hotrocontent').css('display','none');
			}
	);
	jQuery('#k_hotrocontent').hover(
		function(){
				jQuery('#k_hotrocontent').css('display','block');
			},
		function(){
				jQuery('#k_hotrocontent').delay(1000).css('display','none');
			}
	);
	
	jQuery(".top_left_menu").hover(
	  function () {
		if(jQuery('#inner_menu').css('display') == 'none'){
			jQuery('#inner_menu').slideDown('slow'); 
		}
	  },
	  function () {
		
	  }
	);
	
	jQuery("#inner_menu").hover(
	  function () {
		if(jQuery('#inner_menu').css('display') == 'none'){
			jQuery('#inner_menu').slideDown('slow'); 
		}
	  },
	  function () {
		jQuery('#inner_menu').css('display','none');
	  }
	);
	
	
	// cart
	var widthScreen=jQuery(window).width();
	if(widthScreen >= 1240){
		$adjust_val = (widthScreen - 1240)/2 -5;
		jQuery('#adv_float').css('display','block');
		jQuery('#adv_float_left').css('margin-left',$adjust_val);
		jQuery('#adv_float_right').css('margin-right',$adjust_val);
	}
	if(widthScreen<=1024){
		jQuery('.comp').css('width','950');
	}
	jQuery('#bottom-InquiryCart-wrap-0').click(function(){
		if(jQuery('.inquiry-cart-list').css('display')=='none'){
			jQuery('.inquiry-cart-list').css('display','block');
			jQuery('#inquiry-cart').attr('class','opened');
		}else{
			jQuery('.inquiry-cart-list').css('display','none');
			jQuery('#inquiry-cart').attr('class','');
		}
	});
	jQuery('#cart-header').click(function(){		
		
		if(jQuery('.inquiry-cart-list').css('display')=='none'){
			jQuery('.inquiry-cart-list').css('display','block');
			jQuery('#inquiry-cart').attr('class','opened');
		}else{
			jQuery('.inquiry-cart-list').css('display','none');
			jQuery('#inquiry-cart').attr('class','');
		}
	});
	jQuery('#bottom-linkexchange-wrap-0').click(function(){
		if(jQuery('.link-exchange-list').css('display')=='none'){
			jQuery('.link-exchange-list').css('display','block');
			jQuery('#link-exchange').attr('class','opened');
		}else{
			jQuery('.link-exchange-list').css('display','none');
			jQuery('#link-exchange').attr('class','');
		}
	});
	jQuery('a.popup_box').each(function(index) {
		jQuery(this).fancybox({
			'width'				: '50%',
			'height'			: '90%',
			'autoScale'			: false,
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'type'				: 'iframe'
		});
	});	
});
function langChange(language,baseUrl,curUrl){
	jQuery.ajax({
		type: "POST",
		url: baseUrl + "ajax_language",
		data: "language=" + language,
		success: function(data){
			if(curUrl != ''){
				curUrl = curUrl.substr(1);
			}
			window.location.href = baseUrl+curUrl;
		},
		error: function(){}
	});
}
function curChange(currency,baseUrl,curUrl){
	jQuery.ajax({
		type: "POST",
		url: baseUrl + "ajax_currency",
		data: "currency=" + currency,
		success: function(data){
			if(curUrl != ''){
				curUrl = curUrl.substr(1);
			}
			window.location.href = baseUrl+curUrl;
		},
		error: function(){}
	});
}
function proFilter(pro_id, pro_name,baseUrl){
	jQuery.ajax({
		type: "POST",
		url: baseUrl + "ajax_province",
		data: "pro_id=" + pro_id+"&pro_name="+pro_name,
		success: function(data){
			window.location.href = baseUrl;
		},
		error: function(){}
	});
}


function submitenter(myfield,e,baseUrl)
{
	var keycode;
	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;
	if (keycode == 13)
	{
	   qSearch(baseUrl);
	return false;
	}
	else
	   return true;

}
function openMenu(){
	if(jQuery('#inner_menu').css('display') == 'none'){
		jQuery('#inner_menu').slideDown('slow'); 
	}else{
		jQuery('#inner_menu').slideUp('slow');
	}
}

function addEmailNewsletter(baseurl){
	email = jQuery('#email').val();
	if(checkEmail(email)){
		jQuery.ajax({
			type: "POST",
			url: baseurl + "newsletter/ajax",
			data: "email="+email,
			success: function(data){
				if(data=="1"){					
					jAlert("Đăng ký nhận email thành công!","Thông báo");
				}
				if(data=="0"){					
					jAlert("Đăng ký nhận email không thành công!","Thông báo");
				}
				if(data=="2"){					
					jAlert("Email này đã đăng ký rồi. Cảm ơn bạn!","Thông báo");
				}
			},
			error: function(){}
		 });
	}else{
		jAlert('Email không hợp lệ!','Thông báo');
	}
	
}

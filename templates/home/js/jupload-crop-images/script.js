/*
* Author : Ali Aboussebaba
* Email : bewebdeveloper@gmail.com
* Website : http://www.bewebdeveloper.com
* Subject : Crop photo using PHP and jQuery
*/

// the target size
//var TARGET_W = 600;
//var TARGET_H = 300;
var TARGET_W = 600;
var TARGET_H = 600;
var _URL = window.URL || window.webkitURL;
var jcrop_api;
// show loader while uploading photo
function submit_photo(event) {
	// display the loading texte
	$('#loading_progress').html('<img src="/templates/home/js/jupload-crop-images/loader.gif"> Đang tải ảnh của bạn...');
}

function CheckSizeImage(){
	var file, img;
	var name = jQuery("#photo").val();

	if (jQuery("#photo")[0].files[0]) {		
        if (jQuery("#photo")[0].files[0].size > 1024 * 1024 * 3) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Dung lượng ảnh upload tối đa 3MB',
                'theme': 'default',
            	'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
	                    e.preventDefault();
	                    jQuery("#photo").val("");
	                    document.getElementById("photo").focus();
	                    return false;
                	}
           		}
        	});
        	return false;
    	}
    	//$('#btn-close-x').addClass('hidden');
    }

    if (jQuery("#photo")[0].files[0]) {	    	
        if (!name.match(/(?:jpg)$/)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Định dạng ảnh phải là .jpg',
                'theme': 'default',
            	'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
	                    e.preventDefault();
	                    jQuery("#photo").val("");
	                    document.getElementById("photo").focus();
	                    return false;
                	}
           		}
        	});
        	return false;
    	}    	
    }
    
    if (file = jQuery("#photo")[0].files[0]) {
    	img = new Image();
        img.onload = function() {
	        if ((this.width <= 600) && (this.height <= 600)) {
	            $.jAlert({
	                'title': 'Thông báo',
	                'content': 'Kích thước ảnh bắt buộc lớn hơn 600 x 600',
	                'theme': 'default',
	            	'btns': {
	                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
		                    e.preventDefault();
		                    jQuery("#photo").val("");
		                    document.getElementById("photo").focus();
		                    return false;
	                	}
	           		}
	        	});
	        	return false;
	    	}  
    	};
    	img.src = _URL.createObjectURL(file);    	
    }
}

function CheckSizeImage_qc(){
	var file, img;
	var name = jQuery("#photo_qc").val();

	if (jQuery("#photo_qc")[0].files[0]) {		
        if (jQuery("#photo_qc")[0].files[0].size > 1024 * 1024 * 3) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Dung lượng ảnh upload tối đa 3MB',
                'theme': 'default',
            	'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
	                    e.preventDefault();
	                    jQuery("#photo_qc").val("");
	                    document.getElementById("photo_qc").focus();
	                    return false;
                	}
           		}
        	});
        	return false;
    	}
    	//$('#btn-close-x').addClass('hidden');
    }

    if (jQuery("#photo_qc")[0].files[0]) {	    	
        if (!name.match(/(?:jpg)$/)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Định dạng ảnh phải là .jpg',
                'theme': 'default',
            	'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
	                    e.preventDefault();
	                    jQuery("#photo_qc").val("");
	                    document.getElementById("photo_qc").focus();
	                    return false;
                	}
           		}
        	});
        	return false;
    	}    	
    }
    
    if (file = jQuery("#photo_qc")[0].files[0]) {
    	img = new Image();
        img.onload = function() {
	        if ((this.width <= 600) && (this.height <= 600)) {
	            $.jAlert({
	                'title': 'Thông báo',
	                'content': 'Kích thước ảnh bắt buộc lớn hơn 600 x 600',
	                'theme': 'default',
	            	'btns': {
	                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
		                    e.preventDefault();
		                    jQuery("#photo_qc").val("");
		                    document.getElementById("photo_qc").focus();
		                    return false;
	                	}
	           		}
	        	});
	        	return false;
	    	}  
    	};
    	img.src = _URL.createObjectURL(file);    	
    }
}

// show_popup : show the popup
function show_popup(id, num) {
	// show the popup
	$('#images_pos').val(num);
    $('#images_old').val($('input#nameImage_'+num).val());	
	$('#'+id).show();	
}

// show_popup : show the popup
function show_popup_qc(id, num) {
        // show the popup
        var dp_id = 0;
        var img = $('#rqc_image_'+num).val();
        if($('#dp_id_'+num)[0] && $('#dp_id_'+num).val() != 0){
                dp_id = $('#dp_id_'+num).val();     
        }
        $('#dp_id').val(dp_id);
        $('#images_pos_qc').val(num);
        $('#dp_images').val(img);   
        $('#'+id).show();   
}

// close_popup : close the popup
function close_popup(id) {
	// hide the popup
	$('#'+id).hide();
}

// show_popup_crop : show the crop popup
function show_popup_crop(url, num) {
    // change the photo source
    $('#cropbox').attr('src', url);
    // destroy the Jcrop object to create a new one
    try {
        jcrop_api.destroy();
    } catch (e) {
        // object not defined
    }
    // Initialize the Jcrop using the TARGET_W and TARGET_H that initialized before
    $('#cropbox').Jcrop({
      aspectRatio: TARGET_W / TARGET_H,
      setSelect:   [ 100, 100, TARGET_W, TARGET_H ],
      onSelect: updateCoords
    },function(){
        jcrop_api = this;
    });

    // store the current uploaded photo url in a hidden input to use it later
    $('#photo_url').val(url);
    $('#photo_pos').val(num);
    // hide and reset the upload popup
    $('#popup_upload').hide();
    $('#loading_progress').html('');
    $('#photo').val('');
    // $('#cropbox').removeAttr("style");

    // show the crop popup
    $('#popup_crop').show();
}

// show_popup_crop : show the crop popup
function show_popup_crop_qc(url, num, dp=0) {
	$('#cropbox_qc').attr('src', url);
	try {
		jcrop_api.destroy();
	} catch (e) { }	
    $('#cropbox_qc').Jcrop({
      aspectRatio: TARGET_W / TARGET_H,
      setSelect:   [ 100, 100, TARGET_W, TARGET_H ],
      onSelect: updateCoords
    },function(){
        jcrop_api = this;
    });
   
	$('#photo_url_qc').val(url);
	$('#photo_pos_qc').val(num);
	$('#dp_id_cr').val(dp);	
	$('#popup_upload_qc').hide();
	$('#loading_progress').html('');
	$('#photo_qc').val('');
	// $('#cropbox_qc').removeAttr("style");
	
	$('#popup_crop_qc').show();
}

// crop_photo :
function crop_photo() {
    var x_ = $('#x').val();
    var y_ = $('#y').val();
    var w_ = $('#w').val();
    var h_ = $('#h').val();
    var photo_url_ = $('#photo_url').val();
    console.log(photo_url_);
    var num = $('#photo_pos').val();
    var product_dir = $('#product_dir').val();
    var ajax_link = "/product/crop_photo";
    if(($('#product_dir')[0]) && ($('input#product_dir').val() != "")){ 
        ajax_link = "/account/crop_photo";        
    }             
    var ar_1 = photo_url_.split("/");            
    var res_1 = ar_1[ar_1.length - 1];
   
    // hide thecrop  popup
    $('#popup_crop').hide();

    // display the loading texte
    $('#photo_container').html('<img src="/templates/home/js/jupload-crop-images/loader.gif"> Đang xử lý...');
    // crop photo with a php file using ajax call
    $.ajax({
        url: ajax_link,
        type: 'POST',
        dataType : 'json',
        data: {x:x_, y:y_, w:w_, h:h_, photo_url:photo_url_, targ_w:TARGET_W, targ_h:TARGET_H, product_dir: product_dir},
        success:function(data){
            // display the croped photo
            $('#image'+num+'_edit').val(data.image_name);
            $('#nameImage_'+num).val(data.image_name);
            $('#photo_container_'+num).html(data.image);
        }
    });
} 
// function crop_photo() {
//     var x_ = $('#x').val();
//     var y_ = $('#y').val();
//     var w_ = $('#w').val();
//     var h_ = $('#h').val();
//     var photo_url_ = $('#photo_url').val();
//     console.log(photo_url_);	
//     var num = $('#photo_pos').val();
//     var product_dir = $('#product_dir').val();
//     var ajax_link = "/product/crop_photo";
//     if(($('#product_dir')[0]) && ($('input#product_dir').val() != "")){ 
//         ajax_link = "/account/crop_photo";        
//     }	          
//     var ar_1 = photo_url_.split("/");            
//     var res_1 = ar_1[ar_1.length - 1];
   
//     // hide thecrop  popup
//     $('#popup_crop').hide();

//     // display the loading texte
//     $('#photo_container').html('<img src="/templates/home/js/jupload-crop-images/loader.gif"> Đang xử lý...');
//     // crop photo with a php file using ajax call
//     $.ajax({
//         url: ajax_link,
//         type: 'POST',
//         data: {x:x_, y:y_, w:w_, h:h_, photo_url:photo_url_, targ_w:TARGET_W, targ_h:TARGET_H, product_dir: product_dir},
//         success:function(data){
//             // display the croped photo
//             $('#nameImage_'+num).val(res_1);
//             $('#photo_container_'+num).html(data);
//         }
//     });
// }

function crop_photo_qc() {
    var x_ = $('#x').val();
    var y_ = $('#y').val();
    var w_ = $('#w').val();
    var h_ = $('#h').val();
    var DOMAIN_CLOUDSERVER = $('#DOMAIN_CLOUDSERVER').val();
    var photo_url_ = $('#photo_url_qc').val();	
    var num = $('#photo_pos_qc').val();	
    var dp = 0;
    if($('#dp_id_cr')[0] && $('#dp_id_cr').val() != 0){
        dp = $('#dp_id_cr').val();
    }
    var product_dir = "";
    var ajax_link = "/product/crop_photo_qc";
    if(($('#product_dir')[0]) && ($('input#product_dir').val() != "")){ 
    ajax_link = "/account/crop_photo_qc";
        product_dir = $('#product_dir').val();        
    }	          
    var ar_1 = photo_url_.split("/");            
    var res_1 = ar_1[ar_1.length - 1]; 
    // hide thecrop  popup
    $('#popup_crop_qc').hide();

    // display the loading texte
    $('#photo_container').html('<img src="/templates/home/js/jupload-crop-images/loader.gif"> Đang xử lý...');
    // crop photo with a php file using ajax call
    $.ajax({
        url: ajax_link,
        type: 'POST',
        dataType : 'json',
        data: {x:x_, y:y_, w:w_, h:h_, photo_url:photo_url_, targ_w:TARGET_W, targ_h:TARGET_H, num_qc: num, product_dir:product_dir},
        success:function(data){
            // display the croped photo
            $('#rqc_image_'+num).val(data.image_name);			
            //$('#sp_upload_'+num).addClass('hidden');
            $('#container_show_'+num).html(data.image);
            if(dp > 0){
                $("tr#rowqc_"+ dp +" td img" ).attr( "src", function() {
                    return DOMAIN_CLOUDSERVER + "media/images/product/"+product_dir+"/thumbnail_1_"+data.image_name;
                });
            }
        }
    });
}

// updateCoords : updates hidden input values after every crop selection
function updateCoords(c) {
	$('#x').val(c.x);
	$('#y').val(c.y);
	$('#w').val(c.w);
	$('#h').val(c.h);
}


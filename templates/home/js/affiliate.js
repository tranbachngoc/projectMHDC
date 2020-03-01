window.Clipboard = (function(window, document, navigator) {
    var textArea,
        copy;

    function isOS() {
        return navigator.userAgent.match(/ipad|iphone/i);
    }

    function createTextArea(text) {
        textArea = document.createElement('textArea');
        textArea.value = text;
        document.body.appendChild(textArea);
    }

    function selectText() {
        var range,
            selection;

        if (isOS()) {
            range = document.createRange();
            range.selectNodeContents(textArea);
            selection = window.getSelection();
            selection.removeAllRanges();
            selection.addRange(range);
            textArea.setSelectionRange(0, 999999);
        } else {
            textArea.select();
        }
    }

    function copyToClipboard() {        
        document.execCommand('copy');
        document.body.removeChild(textArea);
    }

    copy = function(text) {
        createTextArea(text);
        selectText();
        copyToClipboard();
    };

    return {
        copy: copy
    };
})(window, document, navigator);

function addProduct(data, status, el){
   // console.log(data);
    jQuery.ajax({
        type: "POST",
        url: siteUrl+"index.php/af/add-products",
        dataType: 'json',
        data: {ids: data, status: status},
        success: function (res) {
            $(el).removeClass('processing');
            console.log(res);
            if(res.error){
                alert(res.message);
            }else{
                var afBox = jQuery('.afBox');
                for(i= 0; i< data.length; i++){
                    var row = afBox.find('#af_row_'+data[i]);
                    row.find('input[name="checkone[]"]').prop('checked', false);
                    if(status == 1){
                        row.find('a.chooseItem').addClass('selected').empty().html('<img src="'+siteUrl+'/templates/home/images/public.png" />');

                        //row.find('img').attr('src', row.find('img').attr('src').replace('/unpublic','/public'));
                    }else{
                        //row.find('a.chooseItem').removeClass('selected');
                        row.find('a.chooseItem').removeClass('selected').empty().html('<img src="'+siteUrl+'/templates/home/images/unpublic.png" />');
                        //row.find('img').attr('src', row.find('img').attr('src').replace('/public','/unpublic'));
                    }
                }
            }
        }
    });
}

function copylink(link){
    clipboard.copy(link);
}
jQuery( document ).ready(function() {
    var afBox = jQuery('.afBox');
    var is_cat = [];
    afBox.find('a.chooseItem').click(function(){

        //is_cat.push($(this).attr('id'));
        //if(is_cat.length > 0) {
        //    if (jQuery.inArray($(this).attr('id'), is_cat) != 0) {
        //        errorAlert('Thông báo','Bạn chỉ được phép chọn sản phẩm từ danh mục bạn đã chọn!');
        //        return false;
        //    }
        //}
        var item = jQuery(this);
        if(item.hasClass('processing')){
            return;
        }
        afBox.find('input[name="checkone[]"]').prop('checked', false);
        var row = item.parents('tr');
        row.find('input[name="checkone[]"]').prop('checked', true);
       // id = id.replace('af_row_', '');
        var data = [];
        //
        afBox.find("input:checked").each(function() {
            if($(this).val() > 0){
                data.push($(this).val());
            }
        });

        var status = item.hasClass('selected') ? 0 : 1;
        item.addClass('processing');
        addProduct(data, status, item);

    });
    afBox.find('span.adminBt').click(function(){
        var item = jQuery(this);
        if(item.hasClass('processing')){
            return;
        }
        var data = [];
        afBox.find("input:checked").each(function() {
            if($(this).val() > 0){
                data.push($(this).val());
            }
        });
        var status = item.hasClass('selected') ? 1 : 0;
        item.addClass('processing');
        addProduct(data, status, item);
    });
    $(document).on('click', '.create-link', function() {
        jQuery.ajax({
            type: "POST",
            url: siteUrl+"profile/affiliate/addservice",
            dataType: 'json',
            data: {id: $(this).attr('data-id')},
            success: function (res) {
                var error = $('.alert');
                if(error.length > 0) {
                    error.html(res.message);
                }
            }
        });
    });
    $(document).on('click', '.edit_affiliate_level', function() {
        var level = $(this).closest('tr').find('input[name="level"]').val();
        jQuery.ajax({
            type: "POST",
            url: siteUrl+"profile/affiliate/editlevel",
            dataType: 'json',
            data: {id: $(this).attr('data-id'), level : level},
            success: function (res) {
                if(res.type == 'success') {
                    location.reload();
                }else {
                    var error = $('.alert');
                    if(error.length > 0) {
                        error.html(res.message);
                    }
                }
            }
        });
        return false;
    });
    $(document).on('click','.config-service-price', function() {
        var id      = $(this).attr('data-id');
        var user_id = $(this).attr('data-user');
        if(user_id != 'undefined') {
            var datas = {
                id      : id,
                user_id : user_id
            };
        }else {
            var datas = {
                id      : id
            };
        }

        jQuery.ajax({
            type: "POST",
            url: siteUrl+"profile/affiliate/getservice",
            dataType: 'json',
            data: datas,
            success: function (res) {
                if(res.type == 'success') {
                    var html = '';
                    html +='<h2 class="title-service">'+res.data.name+'</h2>';
                    html +='<div class="affiliate-item-content">';
                        html +='<div class="affiliate-item-infomation">';
                            html +='<strong>Số lượng (đơn vị)</strong>';
                            html +='<p>'+res.data.limits+' ('+res.data.units+')</p>';
                        html +='</div>';
                        html +='<div class="affiliate-item-infomation">';
                            html +='<strong>Đơn giá</strong>';
                            html +='<p>'+res.data.discount_price+' đ</p>';
                        html +='</div>';
                    html +='</div>';
                    html +='<div class="price-rank-service">';
                        html +='<strong>Số % được cấu hình</strong>';
                        html +='<p style="color:red;">'+res.data.discount_percen+' %</p>';
                    html +='</div>';
                    $('#config_price_service .modal-body').html(html);
                    $('#config_price_service .modal-body').append(res.affiliate_level);
                    $('#config_price_service').attr('data-service',res.data.id);
                    if(user_id != 'undefined') {
                        $('#config_price_service').attr('data-id',user_id);
                    }
                    $('#config_price_service').modal('show');
                }
            }
        });
        return false;
    });

    $(document).on('click','#edit_price_affiliate', function() {
        var input = [];
        $('#config_price_service').find('input').each(function() {
            input.push({name:$(this).attr('name'), value: $(this).val()});
        });
        var user_id = $('#config_price_service').attr('data-id');
        if(user_id != 'undefined') {
            var datas = {
                id      : $('#config_price_service').attr('data-service'),
                user_id : user_id,
                input   : input
            }
        }else {
            var datas = {
                id      : $('#config_price_service').attr('data-service'),
                input   : input
            }
        }
        jQuery.ajax({
            type: "POST",
            url: siteUrl+"profile/affiliate/editservice",
            dataType: 'json',
            data: datas,
            success: function (res) {
                if(res.type == 'success') {
                    $('#config_price_service').modal('hide');
                    var error = $('.alert');
                    if(error.length > 0) {
                        error.html(res.message);
                    }
                }else {
                    var error = $('#config_price_service .modal-body-error');
                    if(error.length > 0) {
                        error.html(res.message);
                    }
                }
            }
        });
        return false;
    });
    $(document).on('click','.copy-link-send', function() {
        var link = $(this).attr('data-link');
        clipboard.copy(link);
        var error = $('.alert');
        if(error.length > 0) {
            error.html('<div class="success">Đã copy link thành công!</div>');
        }
    });
    $(document).on('click','.get-link', function() {
        var link = $(this).attr('data-url');
        Clipboard.copy(link);
        //clipboard.copy(link);
        var error = $('#copy_link');
        if(error.length > 0) {
            $('#copy_link').modal('show');
            var html = '<div class="success">';
            html += '<p>Đã copy link thành công!</p>';
            html += '<p>Link: '+link+'</p>';
            html += '</div>';
            error.find('.modal-body').html(html);
        }
    });

    $(document).on('click', '.delete-service-price', function(event) 
    {
        $event = $(this);
        return false;
    });

    $('.delete-service-price').bootstrap_confirm_delete({
        heading: 'Xóa affiliate',
        message: 'Bạn muốn xóa affiliate này?',
        btn_ok_label: 'Đồng ý',
        btn_cancel_label: 'Hủy bỏ',
        callback: function( event ){
            var id = $event.attr('data-id');
            jQuery.ajax({
            type: "POST",
            url: siteUrl+"profile/affiliate/deleteservice",
            dataType: 'json',
            data: {id: id},
            success: function (res) {
                if(res.type == 'success') {
                    var error = $('.alert');
                    if(error.length > 0) {
                        error.html(res.message);
                        $('#affiliate_item_'+id).remove();
                    }
                }
            }
        });
        }
    });
    function number_format( number, decimals, dec_point, thousands_sep ) {
                              
        var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
        var d = dec_point == undefined ? "," : dec_point;
        var t = thousands_sep == undefined ? "." : thousands_sep, s = n < 0 ? "-" : "";
        var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
                                  
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
      }
    $('body').on('click','.img-popup-ctv-qc',function(){
        var phantram = $(this).attr('data-valuea');
        if(phantram > 0){
            $('#myModal_ctv .tilehoahong').text(phantram+'%');
            var tien = $(this).attr('data-price');
            var uoctinh = tien*(phantram/100);
            $('#myModal_ctv .uoctinh').text(number_format(uoctinh,0));
        }else{
          var tien = $(this).attr('data-valueb');
          var uoctinh = $(this).attr('data-key');
          $('#myModal_ctv .tilehoahong').text(number_format(tien));
          $('#myModal_ctv .uoctinh').text(uoctinh,0);
        }
        
        $('#myModal_ctv .btn-ctv .btn-share a').attr('onclick',$(this).attr('data-url'));
        $('#myModal_ctv').modal('show');
    });
});
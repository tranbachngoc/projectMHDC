/**
 * Created by Administrator on 12/8/2015.
 */
function updatePackagePrice() {
    var box = $('#packageBox');
    var period = box.find('select[name="periods"]').val();
    var pack = box.find('input[name="package"]').val();
    if ($(' #' + pack + '_' + period).length) {
        
        if($('input[name="goline"]').length && $('input[name="goline"]').is(':checked')){
            showLoading();
            box.find('input[name="active_date"]').val('');
            box.find('input[name="end_date"]').val('');
            box.find('span#p_amount').text('');
            jQuery.ajax({
                type: "POST",
                url: siteUrl + "ajax/action/packprice",
                dataType: 'json',
                data: box.find(':input').serialize(),
                success: function (res) {
                    box.find('input[name="active_date"]').val(res.begined_date);
                    box.find('input[name="end_date"]').val(res.ended_date);
                    box.find('span#p_amount').text(res.price_text);
                    box.find('input[name="price"]').val(res.price);
                    hideLoading();
                }
            });

        }else{
            box.find('#p_amount').text($('#' + pack + '_' + period).text());
            box.find('input[name="active_date"]').val(packageDate.begin_date);
            switch (period) {
                case '1':
                    box.find('input[name="end_date"]').val(packageDate.month_1);
                    break;
                case '3':
                    box.find('input[name="end_date"]').val(packageDate.month_3);
                    break;
                case '6':
                    box.find('input[name="end_date"]').val(packageDate.month_6);
                    break;
                case '12':
                    box.find('input[name="end_date"]').val(packageDate.month_12);
                    break;
            }
        }

    }
}
function package(id) {
    //    
    if (id > 1) {
        var packageModal = $('#packageBox');
        packageModal.find('input[name="package"]').val(id);
        packageModal.find('button.packageBt').removeClass('processing');
        packageModal.find('.lkvMessage').removeClass('alert-danger').removeClass('alert-success').empty().hide();
        //packageModal.find('#myModalLabel b').text($('th.p_' + id).text());
        packageModal.find('#myModalLabel b').text($('h3.p_' + id).text());
        updatePackagePrice();
        $('#packageBox').modal('show');
    } else {
        confirm(function(e1,btn){
            e1.preventDefault();
            var item = jQuery('#package_' + id);
            if (item.hasClass('processing')) {
                return;
            }
            item.addClass('processing');
            jQuery.ajax({
                type: "POST",
                url: siteUrl + "index.php/ajax/add-package",
                dataType: 'json',
                data: {package: id, periods: -1},
                success: function (res) {
                    item.removeClass('processing');
                    var packageModal = $('#freeBox');
                    if (res.error == false) {
                        packageModal.modal('hide');
                        showMessage(res.message, 'alert-success');
                        window.location = siteUrl+'account/service/using';
                        packageModal.find('.lkvMessage').removeClass('alert-danger').addClass('alert-success').html(res.message).show();
                    } else {
                        packageModal.modal('show');
                        packageModal.find('.lkvMessage').addClass('alert-danger').removeClass('alert-success').html(res.message).show();
                    }
                    
                }
            });
        });

    }

    /*jConfirm('Bạn muốn đăng ký gói dịch vụ này?', 'Xác nhận', function (r) {
     if (r == true) {
     item.addClass('processing');
     jQuery.ajax({
     type: "POST",
     url: siteUrl+"/index.php/ajax/add-package",
     dataType: 'json',
     data: {package: id},
     success: function (res) {
     item.removeClass('processing');
     if (res.error == false) {
     jAlert(res.message, 'Thông báo');
     } else {
     jAlert(res.message, 'Error');
     }
     }
     });
     }
     });*/
}
function simplePackage(id) {
    var item = jQuery('#package_' + id);
    if (item.hasClass('processing')) {
        return;
    }

    if(id == 16){
        var packageModal = $('#packageBran');
        packageModal.find('input[name="package"]').val(id);
        packageModal.find('button.packageBt').removeClass('processing');
        packageModal.find('.lkvMessage').removeClass('alert-danger').removeClass('alert-success').empty().hide();
        packageModal.find('#myModalLabel b').text($('tr td b.name_' + id).text());             
        $('#packageBran').modal('show');
    }else if(id == 17){
        var packageModal = $('#packageCTV');
        packageModal.find('input[name="package"]').val(id);
        packageModal.find('button.packageBt').removeClass('processing');
        packageModal.find('.lkvMessage').removeClass('alert-danger').removeClass('alert-success').empty().hide();
        packageModal.find('#myModalLabel b').text($('tr td b.name_' + id).text());              
        $('#packageCTV').modal('show');    
    }else{
        confirm(function(e1,btn){
            e1.preventDefault();
            item.addClass('processing');
            jQuery.ajax({
                type: "POST",
                url: siteUrl + "index.php/ajax/add-package",
                dataType: 'json',
                data: {package: id, periods: -1},
                success: function (res) {
                    item.removeClass('processing');
                    var packageModal = $('#freeBox');
                    if (res.error == false) {
                        packageModal.find('.lkvMessage').removeClass('alert-danger').addClass('alert-success').html(res.message).show();
                        window.location = siteUrl+'account/service/using';
                    } else {
                        packageModal.modal('show');
                        packageModal.find('.lkvMessage').addClass('alert-danger').removeClass('alert-success').html(res.message).show();
                        
                    }
                }
            });
        });
    } 
}

function regisPack(id){
    var box = jQuery('#'+id);
    showLoading();
    confirm(function(e1,btn){
        e1.preventDefault();
        jQuery.ajax({
            type: "POST",
            url: siteUrl + "ajax/action/addpack",
            dataType: 'json',
            data: box.find(':input').serialize(),
            success: function (res) {

                if(res.error == true){
                    showLoading();
                    var numday = 0;
                    var html = '<div id="regisBox">';
                    html +='<div class="padding: 15px ;"><div class="alert alert-danger">'+res.message+'</div></div>';
                    html += '<table class="table table-hover">';
                    html += '<thead>';
                    html += '<tr>';
                    html += '<th>';
                    html += 'Ngày';
                    html += '</th>';
                    html += '<th>';
                    html += 'Giá tiền';
                    html += '</th>';
                    html += '</tr>';
                    html += '</thead>';
                    for(var i = 0, len = res.dates.length; i< len; i++){
                        html += '<tr>';
                        html += '<td>';
                        html += res.dates[i].date;
                        html += '</td>';
                        html += '<td><span class="product_price">';
                        if( res.dates[i].error == false){
                            html += res.dates[i].price_text;
                            numday ++;
                        }else{
                            html += res.dates[i].message;
                        }

                        html += '<input type="hidden" name=date['+i+'] value="'+res.dates[i].d+'" />';
                        html += '<input type="hidden" name=price['+i+'] value="'+res.dates[i].price+'" />';
                        html += '</span></td>';
                        html += '</tr>';
                    }
                    if(res.total > 0){
                        html += '<tr>';
                        html += '<td >';
                        html += 'Thời gian: '+numday+' ngày';
                        html += '</td>';
                        html += '<td ><span class="product_price">';
                        html += 'Số tiền: '+res.total_text;
                        html += '</span></td>';
                        html += '</tr>';

                        html += '<tr>';
                        html += '<td colspan="2" align="center">';
                        html += '<input type="button" onclick="regisPack(\'regisBox\');" value="Đăng ký" class="btn btn-primary" id="package_1">';
                        html += '<input type="hidden"  value="'+res.pack_id+'" name="pack">';
                        html += '<input type="hidden"  value="'+res.total+'" name="total">';
                        html += '<input type="hidden"  value="'+res.position+'" name="position">';
                        html += '</td>';

                        html += '</tr>';
                    }

                    html += '</table></div>';
                    showMessageBox(html);


                }else{
                    showMessage(res.message, 'alert-success');
                    window.location = siteUrl+'account/service/using';
                }
            }
        });
    });
    hideLoading();
}

function regisPackShelf(id){
    var box = jQuery('#box_'+id);
    showLoading();
    confirm(function(e1,btn){
        e1.preventDefault();
        jQuery.ajax({
            type: "POST",
            url: siteUrl + "ajax/action/addshelf",
            dataType: 'json',
            data: box.find(':input').serialize(),
            success: function (res) {
                showLoading();

                if(res.error == true){

                    showMessage(res.message, 'alert-danger');


                }else{
                    showMessage(res.message, 'alert-success');
                    window.location = siteUrl+'account/service/using';
                }
            }
        });
    });
    hideLoading();
}

function registerPackage(item) {
    var packageModal = $('#packageBox');
    if ($(item).hasClass('processing')) {
        packageModal.find('.lkvMessage').html('Vui lòng đợi...');
        return;
    }
    confirm(function(e1,btn){
        e1.preventDefault();
        var packageId = packageModal.find('input[name=package]').val();
        var period = packageModal.find('select[name=periods]').val();
        //$('#packageBox').modal('hide');
        $(item).addClass('processing');
        jQuery.ajax({
            type: "POST",
            url: siteUrl + "index.php/ajax/add-package",
            dataType: 'json',
            data: packageModal.find(':input').serialize(),
            success: function (res) {
                console.log(res);
                $(item).removeClass('processing');
                if (res.error == false) {
                    packageModal.modal('hide');
                    showMessage(res.message, 'alert-success');
                    window.location = siteUrl+'account/service/using';
                } else {
                    packageModal.find('.lkvMessage').removeClass('alert-success').addClass('alert-danger').html(res.message).show();

                }
            }
        });
    });
}

function registerPackageBran(item) {
    var packageModal1 = $('#packageBran');
    if ($(item).hasClass('processing')) {
        packageModal1.find('.lkvMessage').html('Vui lòng đợi...');
        return;
    }
    confirm(function(e2,btn){
        e2.preventDefault();
        var package = packageModal1.find('input[name=package]').val();
        var numbran = packageModal1.find('input[name=numbran]').val();
        var period = packageModal1.find('input[name=periods]').val(-1);        
        $(item).addClass('processing');
        jQuery.ajax({
            type: "POST",
            url: siteUrl + "index.php/ajax/add-package",
            dataType: 'json',
            data: packageModal1.find(':input').serialize(),
            success: function (resb) {
                console.log(resb);
                $(item).removeClass('processing');
                if(resb.error == false){
                    packageModal1.modal('hide');
                    showMessage(resb.message, 'alert-success');
                    window.location = siteUrl+'account/service/using';
                }else{                    
                    packageModal1.find('.lkvMessage').removeClass('alert-success').addClass('alert-danger').html(resb.message).show();
                }
            }
        });
    });
}

function registerPackageCTV(item) {
    var packageModal1 = $('#packageCTV');
    if ($(item).hasClass('processing')) {
        packageModal1.find('.lkvMessage').html('Vui lòng đợi...');
        return;
    }
    confirm(function(e3,btn){
        e3.preventDefault();
        var package = packageModal1.find('input[name=package]').val();
        var numctv = packageModal1.find('input[name=num_ctv]').val();
        var period = packageModal1.find('input[name=periods]').val(-1);        
        $(item).addClass('processing');
        jQuery.ajax({
            type: "POST",
            url: siteUrl + "index.php/ajax/add-package",
            dataType: 'json',
            data: packageModal1.find(':input').serialize(),
            success: function (resbb) {
                console.log(resbb);
                $(item).removeClass('processing');
                if(resbb.error == false){
                    packageModal1.modal('hide');
                    showMessage(resbb.message, 'alert-success');
                    window.location = siteUrl+'account/service/using';
                }else{                    
                    packageModal1.find('.lkvMessage').removeClass('alert-success').addClass('alert-danger').html(resbb.message).show();
                }
            }
        });
    });
}

/*jQuery(document).ready(function () {
 var form = jQuery('form[name="sBox"]');
 var table = jQuery('table.sTable');
 var pStatus = form.find('select[name="os"]').val();
 switch (pStatus) {
 case '01':
 table.find('span.completePayment').click(function () {
 var item = jQuery(this);
 if (item.hasClass('processing')) {
 return;
 }
 var id = item.parents('tr').attr('id');
 id = id.replace('row_', '');

 jConfirm('Bạn muốn hoàn tất thanh toán cho yêu cầu này?', 'Xác nhận', function (r) {
 if (r == true) {
 item.addClass('processing');
 jQuery.ajax({
 type: "POST",
 url: siteUrl+"/index.php/ajax/complete-payment",
 dataType: 'json',
 data: {order: id},
 success: function (res) {
 item.removeClass('processing');
 if (res.error == false) {
 item.text('Đã xác nhận thanh toán');
 } else {
 jAlert(res.message, 'Error');
 }
 }
 });
 }
 });
 });


 table.find('span.cancelService').click(function () {
 var item = jQuery(this);
 if (item.hasClass('processing')) {
 return;
 }
 var id = item.parents('tr').attr('id');
 id = id.replace('row_', '');

 jConfirm('Bạn muốn hủy yêu cầu này?', 'Xác nhận', function (r) {
 if (r == true) {
 item.addClass('processing');
 jQuery.ajax({
 type: "POST",
 url: siteUrl+"/index.php/ajax/cancel-order",
 dataType: 'json',
 data: {order: id},
 success: function (res) {
 item.removeClass('processing');
 if (res.error == false) {
 item.text('Đã hủy');
 } else {
 jAlert(res.message, 'Error');
 }
 }
 });
 }
 });
 });
 break;
 case '02':
 table.find('span.startService').click(function () {
 var item = jQuery(this);
 if (item.hasClass('processing')) {
 return;
 }
 var id = item.parents('tr').attr('id');
 id = id.replace('row_', '');

 jConfirm('Bạn muốn kích hoạt dịch vụ cho yêu cầu này?', 'Xác nhận', function (r) {
 if (r == true) {
 item.addClass('processing');
 jQuery.ajax({
 type: "POST",
 url: siteUrl+"/index.php/ajax/start-service",
 dataType: 'json',
 data: {order: id},
 success: function (res) {
 item.removeClass('processing');
 if (res.error == false) {
 item.text('Đã kích hoạt dịch vụ');
 } else {
 jAlert(res.message, 'Error');
 }
 }
 });
 }
 });
 });
 break;
 }
 });*/


/**
**	Create by Bao Tran
** 	Date: 10/10/2017
** 	JavaScript file for Group Trade
**/

$(window).scroll(function(){
    var height = $(window).scrollTop();
    if(height > 500){
        $(".header-top").addClass("navbar-fixed-top"); 
    } else { 
        $(".header-top").removeClass("navbar-fixed-top");
    }
});

function TrimInput(e) {
    if (e != "") {
        while (e.substring(0, 1) == " ") {
            e = e.substring(1, e.length)
        }
        while (e.substring(e.length - 1, e.length) == " ") {
            e = e.substring(0, e.length - 1)
        }
        return e
    }
}

function vali_type(e, t) {
    var n = document.getElementById(e).value;
    if (n != "") {
        if (t.test(n)) {
            return true
        } else {
            return false
        }
    }
}

function CheckBlank(e) {
    if (TrimInput(e) == "" || e == "") {
        return true
    } else {
        return false
    }
}

function IsNumber(e) {
    var t = "0123456789";
    for (var n = 0; n < e.length; n++) {
        if (t.indexOf(e.charAt(n)) == -1) {
            return false
        }
    }
    return true
}

function checkEmail(s) {
    //neu email co khoang trang
    if (s.indexOf(" ") > 0)
        return false;
    //neu khong co @
    if (s.indexOf("@") == -1)
        return false;
    //neu khong co dau cham
    if (s.indexOf(".") == -1)
        return false;
    //neu co 2 dau cham gan nhau
    if (s.indexOf("..") > 0)
        return false;
    //neu email co 2  @
    if (s.indexOf("@") != s.lastIndexOf("@"))
        return false;
    //neu @ va dau cham canh nhau
    if ((s.indexOf("@.") != -1) || (s.indexOf(".@") != -1))
        return false;
    //neu co @ cuoi cung, neu co @ o dau
    if ((s.indexOf("@") == s.length - 1) || (s.indexOf(".") == 0))
        return false;
    //neu co dau cham cuoi cung
    //neu co dau cham o dau
    if ((s.indexOf(".") == s.length - 1) || (s.indexOf("@") == 0))
    //neu sau @ khong co dau cham, hoac dau cham o truoc
        if (s.indexOf("@") > s.indexOf("."))
            return false;
    var str = "0123456789abcdefghikjlmnopqrstuvwxysz-@._";
    //neu email co ky tu khong thuoc cac ky tu str
    for (var i = 0; i < s.length; i++) {
        if (str.indexOf(s.charAt(i)) == -1)
            return false;
    }
    return true;
}

function submitenter(e, t, n) {
    var r;
    if (window.event) r = window.event.keyCode;
    else if (t) r = t.which;
    else return true;
    if (r == 13) {
        qSearch(n);
        return false
    } else return true
}

function emptySelectBoxById(eid, value) {
    if (value) {
        var text = "";
        $.each(value, function (k, v) {
            //display the key and value pair
            if (k != "") {
                text += "<option value='" + k + "'>" + v + "</option>";
            }
        });
        document.getElementById(eid).innerHTML = text;
        delete text;
    }
}

function Check_RegisterGroup() {
    if ($('.nhom').attr('class') == 'nhom' && ($("#cmss_for_grt").val() < 0 || $("#cmss_for_grt").val() > 100)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Hoa hồng theo phần trăm phải nhỏ hơn 100% và lớn hơn 0%!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("cmss_for_grt").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if ($('.kenh').attr('class') == 'kenh' && ($("#cmss_for_sho").val() < 0 || $("#cmss_for_sho").val() > 100)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Hoa hồng theo phần trăm phải nhỏ hơn 100% và lớn hơn 0%!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("cmss_for_sho").focus();
                    return false;
                }
            }
        });
        return false;
    }


    if (CheckBlank(document.getElementById("grt_name").value)) {
        alert("Bạn chưa nhập tên nhóm!");
        document.getElementById("grt_name").focus();
        return false
    }
    if (CheckBlank(document.getElementById("grt_email").value)) {
        alert("Bạn chưa nhập email!");
        document.getElementById("grt_email").focus();
        return false
    }else{
        if (!CheckEmail(document.getElementById("grt_email").value)) {
            alert("Email bạn nhập không hợp lê!");
            document.getElementById("grt_email").focus();
            return false
        }
    }
    if (CheckBlank(document.getElementById("grt_province").value)) {
        alert("Bạn chưa chọn Tỉnh thành!");
        document.getElementById("grt_province").focus();
        return false;
    }

    if (CheckBlank(document.getElementById("grt_address").value)) {
        alert("Bạn chưa nhập địa chỉ!");
        document.getElementById("grt_address").focus();
        return false
    }
    if (CheckBlank(document.getElementById("grt_bank").value)) {
        alert("Bạn chưa nhập tên ngân hàng!");
        document.getElementById("grt_bank").focus();
        return false
    }
    if (CheckBlank(document.getElementById("grt_bank_number").value)) {
        alert("Bạn chưa nhập số tài khoản!");
        document.getElementById("grt_bank_number").focus();
        return false
    } else {
        if (!IsNumber(document.getElementById("grt_bank_number").value)) {
            alert("Số tài khoản chỉ được phép nhập số !");
            document.getElementById("grt_bank_number").focus();
            return false;
        }
    }

    if (CheckBlank(document.getElementById("captcha_regis").value)) {
        alert("Bạn chưa nhập mã xác nhận!");
        document.getElementById("captcha_regis").focus();
        return false
    }
    document.frmAddGrt.submit();
}

function check_ContactGroup() {

    if (CheckBlank(document.getElementById("grt_link").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn chưa nhập liên kết nhóm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("grt_link").focus();
                    return false;
                }
            }
        });
        return false;
    }

    if (jQuery("#grt_logo")[0].files[0]) {
        var e = /(.jpg|.jpeg|.png|.gif)$/i;
        if (!vali_type("grt_logo", e)) {
            errorAlert("Chỉ chấp nhận ảnh dạng .JPG, .PNG, .GIF");
            return false
        }
        if (jQuery("#grt_logo")[0].files[0].size > 500 * 1024) {
            errorAlert("Dung lượng ảnh upload tối đa 500kb ", "Thông báo");
            return false
        }
    }
    if (CheckBlank(document.getElementById("grt_logo").value)) {
        if ($('#img_vavatar_input_1').css('display') == 'none') {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập logo !',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("grt_logo").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (CheckBlank(document.getElementById("grt_banner").value)) {
        if ($('#img_vavatar_input_2').css('display') == 'none') {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập banner!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("grt_banner").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (jQuery("#grt_banner")[0].files[0]) {
        var e = /(.jpg|.jpeg|.png|.gif|.swf)$/i;
        if (!vali_type("grt_banner", e)) {
            errorAlert("Chỉ chấp nhận ảnh dạng .JPG, .PNG, .GIF, .SWF", "Thông báo");
            return false
        }
        /*if (jQuery("#grt_banner")[0].files[0].size > 1024 * 1024) {
            errorAlert("Dung lượng Banner upload tối đa 2M", "Thông báo");
            return false
        }*/
    }
    if (CheckBlank(document.getElementById("grt_desc").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập mô tả nhóm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("grt_desc").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("grt_email").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập email!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("grt_email").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (!CheckEmail(document.getElementById("grt_email").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Email bạn nhập không hợp lệ!',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("grt_email").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("grt_mobile").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập số điện thoại di động!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("grt_mobile").focus();
                    return false;
                }
            }
        });
        return false;
    }else{
        if (!IsNumber(document.getElementById("grt_mobile").value)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Số điện thoại chỉ được phép nhập số!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("grt_mobile").focus();
                        return false;
                    }
                }
            });

            return false;
        }
    }

    if (CheckBlank(document.getElementById("grt_province").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn chưa chọn tỉnh/thành!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("grt_province").focus();
                    return false;
                }
            }
        });
        return false;
    }

    if (CheckBlank(document.getElementById("grt_address").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập địa chỉ của nhóm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("grt_address").focus();
                    return false;
                }
            }
        });
        return false;
    }

    if (CheckBlank(document.getElementById("captcha_groupContact").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn chưa nhập mã bảo vệ!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("captcha_groupContact").focus();
                    return false;
                }
            }
        });
        return false;
    }
    document.frmUpdateGroupContact.submit();
}

function check_StoreGroup() {
    if (CheckBlank(document.getElementById("grt_province_store").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn chưa chọn tỉnh/thành!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("grt_province_store").focus();
                    return false;
                }
            }
        });
        return false;
    }

    if (CheckBlank(document.getElementById("grt_address_store").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập địa chỉ kho!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("grt_address_store").focus();
                    return false;
                }
            }
        });
        return false;
    }

    if (CheckBlank(document.getElementById("captcha_groupStore").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn chưa nhập mã bảo vệ!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("captcha_groupStore").focus();
                    return false;
                }
            }
        });
        return false;
    }
    document.frmUpdateGroupStore.submit();
}

function check_BankGroup() {
    if (CheckBlank(document.getElementById("grt_bank").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn chưa nhập tên ngân hàng!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("grt_bank").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (!IsNumber(document.getElementById("grt_bank_num").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Số tài khoản ngân hàng chỉ được nhập số!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("grt_bank_num").focus();
                    return false;
                }
            }
        });

        return false;
    }
    if (CheckBlank(document.getElementById("grt_bank_addr").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập chi nhánh ngân hàng!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("grt_bank_addr").focus();
                    return false;
                }
            }
        });
        return false;
    }

    if (CheckBlank(document.getElementById("captcha_groupBank").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn chưa nhập mã bảo vệ!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("captcha_groupBank").focus();
                    return false;
                }
            }
        });
        return false;
    }
    document.frmUpdateGroupBank.submit();
}

function check_InvitememberGroup() {
    if (CheckBlank(document.getElementById("grt_invite_value").value)) {
        $.jAlert({  
            'title': 'Thông báo',
            'content': 'Bạn chưa nhập thông tin thành viên mời tham gia nhóm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("grt_invite_value").focus();
                    return false;
                }
            }
        });
        return false;
    }

    if (CheckBlank(document.getElementById("captcha_Invitemember").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn chưa nhập mã bảo vệ!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("captcha_Invitemember").focus();
                    return false;
                }
            }
        });
        return false;
    }
    document.frmInvitemember.submit();
}

function CheckInput_SendLink() {
    if (CheckBlank(document.getElementById("sender_sendlink").value)) {
        alert("Bạn chưa nhập email người gởi!");
        document.getElementById("sender_sendlink").focus();
        return false
    }
    if (!CheckEmail(document.getElementById("sender_sendlink").value)) {
        alert("Email bạn nhập không hợp lệ!");
        document.getElementById("sender_sendlink").focus();
        return false
    }
    if (CheckBlank(document.getElementById("receiver_sendlink").value)) {
        alert("Bạn chưa nhập email người nhận!");
        document.getElementById("receiver_sendlink").focus();
        return false
    }
    if (!CheckEmail(document.getElementById("receiver_sendlink").value)) {
        alert("Email bạn nhập không hợp lệ!");
        document.getElementById("receiver_sendlink").focus();
        return false
    }
    if (CheckBlank(document.getElementById("title_sendlink").value)) {
        alert("Bạn chưa nhập tiêu đề!");
        document.getElementById("title_sendlink").focus();
        return false
    }
    if (CheckBlank(document.getElementById("content_sendlink").value)) {
        alert("Bạn chưa nhập lời nhắn!");
        document.getElementById("content_sendlink").focus();
        return false
    }
    if (CheckBlank(document.getElementById("captcha_sendlink").value)) {
        alert("Bạn chưa nhập mã xác nhận!");
        document.getElementById("captcha_sendlink").focus();
        return false
    }
    document.frmSendLink.submit()
}

function addCart(pro_id) {
    showLoading();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: siteUrl + 'showcart/add',
        data: $('#bt_' + pro_id + ' :input').serialize(),
        success: function (result) {
            if (result.pro_type != 0 && result.error == false) {
                location.href = siteUrl + 'checkout/v2/' + result.pro_user + '/' + result.pro_type;
            }
            if (result.error == false) {
                $('.cartNum').text(result.num);
            }
            if (result.message != '') {
                var type = result.error == true ? 'alert-danger' : 'alert-success';
                showMessage(result.message, type);
            } else {
                hideLoading();
            }
        },
        error: function () {
            alert('error');
        }
    });
}

function addCartQty(pro_id) {
    showLoading();
    var qty = $('input#qty_' + pro_id).val();
    var qty_min = $('#qty_min').val();
    var dp_id = $('input#dp_id').val();
    if (dp_id) {
        if ($('.row.ar_color').attr('class') == 'row ar_color') {
            if ($('#_selected_color')[0]) {
                if ($('input#_selected_color').val() == "") {
                    $('#prompt_select_color').removeClass("hidden");
                    hideLoading();
                    return false;
                }
            }
        }
        if ($('.row.ar_size').attr('class') == 'row ar_size') {
            if ($('#_selected_size')[0]) {
                if ($('input#_selected_size').val() == "") {
                    $('#prompt_select_size').removeClass("hidden");
                    hideLoading();
                    return false;
                }
            }
        }
        if ($('.row.ar_material').attr('class') == 'row ar_material') {
            if ($('#_selected_material')[0]) {
                if ($('input#_selected_material').val() == "") {
                    $('#prompt_select_material').removeClass("hidden");
                    hideLoading();
                    return false;
                }
            }
        }
        if(qty < qty_min){
            alert('Bạn phải chọn tối thiểu '+qty_min+' sản phẩm');
            hideLoading();
            return false;
        }
    }
    $.ajax({
        type: "POST",
        dataType: "json",
        url: siteUrl + 'showcart/add',
        data: $('#bt_' + pro_id + ' :input').serialize() + '&qty=' + qty,
        success: function (result) {
            if (result.error == false) {
                $('.cartNum').text(result.num);
            }
            var type = result.error == true ? 'alert-danger' : 'alert-success';
            showMessage(result.message, type);
        },
        error: function () {
            alert('error connect');
        }
    });
}

function buyNowQty(pro_id) {
    showLoading();
    var qty = $('input#qty_' + pro_id).val();
    var dp_id = $('input#dp_id').val();
    var qty_min = $('#qty_min').val();
    if (dp_id) {
        if ($('.row.ar_color').attr('class') == 'row ar_color') {
            if ($('#_selected_color')[0]) {
                if ($('input#_selected_color').val() == "") {
                    $('#prompt_select_color').removeClass("hidden");
                    hideLoading();
                    return false;
                }
            }
        }
        if ($('.row.ar_size').attr('class') == 'row ar_size') {
            if ($('#_selected_size')[0]) {
                if ($('input#_selected_size').val() == "") {
                    $('#prompt_select_size').removeClass("hidden");
                    hideLoading();
                    return false;
                }
            }
        }
        if ($('.row.ar_material').attr('class') == 'row ar_material') {
            if ($('#_selected_material')[0]) {
                if ($('input#_selected_material').val() == "") {
                    $('#prompt_select_material').removeClass("hidden");
                    hideLoading();
                    return false;
                }
            }
        }
        if(qty < qty_min){
            alert('Bạn phải chọn tối thiểu '+qty_min+' sản phẩm');
            hideLoading();
            return false;
        }
    }
    $.ajax({
        type: "POST",
        dataType: "json",
        url: siteUrl + 'showcart/add',
        data: $('#bt_' + pro_id + ' :input').serialize() + '&qty=' + qty,
        success: function (result) {
            if (result.error == false) {
                window.location = siteUrl + 'checkout';
            } else {
                var type = result.error == true ? 'alert-danger' : 'alert-success';
                showMessage(result.message, type);
            }
        },
        error: function () {
        }
    });
}

function update_qty(pro_id, num){
    var qty = parseInt($('input#qty_' + pro_id).val(), 10);
    var meg = '';
    var qty_min = parseInt($('#bt_' + pro_id + ' input[name="qty_min"]').val(), 10);
    var qty_max = parseInt($('#bt_' + pro_id + ' input[name="qty_max"]').val(), 10);
    var qty_new = qty + num;
    if (qty_new <= qty_min) {
        qty_new = qty_min;
        meg = 'Bạn phải mua tối thiểu ' + qty_min + ' sản phẩm';
    }
    if (qty_new >= qty_max) {
        qty_new = qty_max;
        meg = 'Xin lỗi, chúng tôi chỉ có ' + qty_max + ' sẩn phẩm trong kho';
    }
    $('input#qty_' + pro_id).val(qty_new);
    if ($('#mes_' + pro_id + ' + .qty_message').length == 0) {
        $('#mes_' + pro_id).after('<span class="qty_message"></span>');
    }
    if (meg != '') {
        $('#mes_' + pro_id + ' + .qty_message').text(meg).show();
    } else {
        $('#mes_' + pro_id + ' + .qty_message').hide();
    }
}

function showLoading() {
    $('.loading').show();
    $('#aziload').show();
}

function hideLoading() {
    $('#aziload').hide();
}

function showMessage(message, type) {
    //$('.loading').hide();
    $('#myModal').modal('show');
    $('#myModal .modal-content').html('<div class="alert ' + type + ' alert-dismissible fade in" role="alert"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>' + message + '</div>');
}

function wishlist(pro_id) {
    showLoading();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: siteUrl + 'ajax/action/wishlist',
        data: {product_showcart : pro_id},
        success: function (result) {
            console.log(result);
            var type = result.error == true ? 'alert-danger' : 'alert-success';
            showMessage(result.message, type);
            if(result.error == false){
                var num = parseInt($('.favorites').text()) + 1;
                $('.favorites').text(num);
                $('.addheart_'+pro_id).addClass('hidden');
                $('#bt_'+pro_id+' .like').removeClass('hidden');
            }
        },
        error: function () {
            alert('error');
        }
    });
    
}

function delheart(pro_id,favorite=null) {
    showLoading();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: siteUrl + 'ajax/action/delheart',
        data: {product_showcart : pro_id},
        success: function (result) {
            var type = result.error == true ? 'alert-danger' : 'alert-success';
            showMessage(result.message, type);
            if(result.error == false){
                var num = parseInt($('.favorites').text()) - 1;
                $('.favorites').text(num);
                $('.addheart_'+pro_id).removeClass('hidden');
                $('#bt_'+pro_id+' .like').addClass('hidden');
                if(favorite != null){
                    window.location.href = '/grtshop/favorites';
                }
            }
            console.log(favorite);
        },
        error: function () {
            alert('error');
        }
    });
    
}
function ActionSort(isAddress)
{
    window.location.href = isAddress;
}

function submit_enter(e) {
    var keycode;
    if (window.event) keycode = window.event.keyCode;
    else if (e) keycode = e.which;
    else return true;
    
    if (keycode == 13) {
        jQuery('#searchBox').submit();
        return false;
    } else {
        return true;
    }
}

            
function checklogin(user){
    var session = user;
    if(session != ''){
        $('a.favorite').attr('href','/grtshop/favorites');
    }else{
        showMessage('Bạn phải đăng nhập để xem sản phẩm và coupon đã yêu thích', 'alert-danger');
    }
}

function load_danhmuc(type, lshop, lpro){
    showLoading();
    var child_pro = $('.danhmuc_pro ul.menu_0 li').length;
    var child_cou = $('.danhmuc_coupon ul.menu_0 li').length;
    if(type == 0){
        $('.danhmuc_coupon').css('display','none');
        $('.danhmuc_pro').css('display','block');
    }else{
        $('.danhmuc_pro').css('display','none');
        $('.danhmuc_coupon').css('display','block');
    }
    if(child_cou > 0 || child_pro > 0){
    }else{
        $.ajax({
        type: "POST",
        dataType: "json",
        url: siteUrl + 'ajax/action/load_danhmuc',
        data: {pro_type : type, listshop : lshop, listpro : lpro},
        success: function (result) {
            //console.log(result);
            if(type == 0){
                $('.danhmuc_pro ul.menu_0').html(result.li);
            }else{
                $('.danhmuc_coupon ul.menu_0').html(result.li);
            }
        },
        error: function () {
            alert('tải danh mục lỗi');
        }
    });
    }
}

function show_menubox(menuclass){
    $(menuclass).css('display','block');
}
function show_menu(cur,menu_id){
    var cap = $('.menu_'+menu_id).attr('id');
    var li = '',ul = '';
    if(cap == 'cap2'){
        li = 'li.licap1';
        ul = 'cap1';
    }
    if(cap == 'cap3'){
        li = 'li.licap2';
        ul = 'cap2';
    }
    if(cap == 'cap4'){
        li = 'li.licap3';
        ul = 'cap3';
    }
    if(cap == 'cap5'){
        li = 'li.licap4';
        ul = 'cap4';
    }
    var ul_cungcap = $(cur).parent().parent().children(li);   
    var id;
    if($(window).innerWidth() < 1240){
        ul_cungcap.each(function(key, item){
            if($(this).children('span').length > 0){
                id = $(this).children('span').attr('id').split('_');
                var item_cls = $(cur).parent().parent().attr('class');
                $(this).children('ul.menu_'+id[1]).slideUp();
                $(this).children('span').attr('onclick','show_menu(this,'+id[1]+')');
                $(this).children('span').css('color','#000');
            }
        });
        $('.menu_'+menu_id).slideDown();
        $('#i_'+menu_id).attr('onclick','close_menu('+menu_id+')');
        $('#i_'+menu_id).css('color','#f00');
    }else{
        ul_cungcap.each(function(key, item){
            if($(this).children('span').length > 0){
                $(this).children('span').css('color','#000');
            }
        });
        
        $('ul#'+ul+' ul').attr('style','');
        $('.menu_'+menu_id).css('display','block');
        $('#i_'+menu_id).css('color','#f00');
    }
}
function close_menu(menu_id){
    $('.menu_'+menu_id).slideUp();
    $('#i_'+menu_id).css('color','#000');
    $('#i_'+menu_id).attr('onclick','show_menu(this,'+menu_id+')');
}
 
function close_outside(rootdivhide,divhide){
   var $win = $(window);
   $win.on("click.Bst", function(event){		
      if ($(rootdivhide).has(event.target).length == 0 && !$(rootdivhide).is(event.target)){
           $(divhide).slideUp();
      }
   });
}
function showsale(a,catid,favorite){
    var tab = a.attr('href');
    if(tab == '#sales_'+catid){
        var wheresl = $('.wheresaleoff_'+catid).val();
        var func = 'prosaleoff';
    }
    if(tab == '#views_'+catid){
        var wheresl = $('.wheresalemul_'+catid).val();
        var func = 'salemul';
    }
    if($(tab+' div').length == 0){
        $(tab).load(siteUrl + "home/grouptrade/"+func,{cat_id: catid,where: wheresl, favorite: favorite}, function(res,status,htx){
            if(res != ''){
                $('.product-owl-carousel-2').owlCarousel({ loop:true, responsiveClass:true, nav:true, responsive:{ 0:{ items:1, margin:0 }, 600:{ items:1, margin:0 }, 1000:{ items:1, margin:0 } } });
            }else{
                $(tab).html('<div>Không có dữ liệu</div>');
            }
        });
        $(tab).html('<div class="img_load"><img src="/templates/group/images/load_.gif"></div>');
    }
}
function show_cat(cur,cat_parent,listcat){
    
    console.log($('ul.cap1').length);
    
    $('ul.cap1').each(function(){
        $('ul.cap1').css('display','none');
    });
    $(cur).parent().children('ul.cap1').css('display','block');
    if($(cur).parent().children().length == 2){
        $.ajax({
            type: "POST",
            dataType: "json",
            url: siteUrl + 'ajax/action/load_cat',
            data: {catp: cat_parent, listcat: listcat},
            success: function (result) {
                $(cur).after(result.li);
            },
            error: function () {
                alert('tải danh mục lỗi');
            }
        });
    }
}

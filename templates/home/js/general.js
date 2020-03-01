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
    $('.azimes').html('<p class="' + type + '">' + message + '</p>');
    $('.loading_bg').click(function () {
        hideLoading();
        $('.azimes').empty();
        $('.loading_bg').unbind('click');
    });
}
function showMessageBox(message) {
    $('.loading').hide();
    $('.azimes').html(message);
    $('.loading_bg').click(function () {
        hideLoading();
        $('.azimes').empty();
        $('.loading_bg').unbind('click');
    });
}
function check_login_cm(siteUrl) {
    if ($("#username").val() && $("#password").val()) {
        $.ajax({
            url: siteUrl + 'home/login/Check_login',
            type: "POST",
            data: {user_put: $("#username").val(), pass_put: $("#password").val()},
            cache: false,
            beforeSend: function () {
                document.getElementById("login-submit").disabled = true;
                $('#login-submit').html('Đang đăng nhập...');
            },
            success: function (data) {
                if (data) {
                    $('#myModal').modal('hide');
                    var redirect = siteUrl;
                    window.location = redirect;
                } else {
                    document.getElementById("login-submit").disabled = false;
                    $('.error_submit').html("Tên đăng nhập hoặc mật khẩu không đúng! Vui lòng thử lại");
                }
            },
            error: function () {
                $('.error_submit').html("Tên đăng nhập hoặc mật khẩu không đúng! Vui lòng thử lại");
                document.getElementById("login-submit").disabled = false;
            }
        });
    } else {
        alert('Bạn chưa nhập thông tin đăng nhập!');
    }
}
function check_regis_cm(siteUrl) {
    if ($('#username_regis').val() == '') {
        alert('Bạn chưa nhập Tên đăng nhập!');
        return false;
    }
    if ($('#password_regis').val() == '') {
        alert('Bạn chưa nhập mật khẩu!');
        return false;
    }
    if ($('#email_regis').val() == '') {
        alert('Bạn chưa nhập email!');
        return false;
    }
    if (!checkEmail($('#email_regis').val())) {
        alert('Email không hợp lệ!');
        return false;
    }
    if ($('#mobile_regis').val() == '') {
        alert('Bạn chưa nhập số điện thoại!');
        return false;
    }
    if (!CheckPhone($('#mobile_regis').val())) {
        alert('Số điện thoại chỉ được phép nhập số!');
        return false;
    }
    if ($('#province_regis').val() == '') {
        alert('Bạn chưa nhập tỉnh thành!');
        return false;
    }
    if ($('#district_regis').val() == '') {
        alert('Bạn chưa nhập quận/ huyện!');
        return false;
    } else {
        $.ajax({
            url: siteUrl + 'home/register/Check_register',
            type: "post",
            data: $(this).serialize(),
            beforeSend: function () {
                document.getElementById("login-submit").disabled = true;
                $('#register-submit').html('Đang đăng ký...');
            },
            success: function (data) {
                if (data == 2) {
                    alert("Vui lòng nhập Capcha!");
                    return false;
                }
                $('#myModal').modal('hide');
                var redirect = siteUrl;
                window.location = redirect;
            },
            error: function () {
                alert('Có lỗi xảy ra! Bạn vui lòng đăng ký lại.');
            }
        });
    }
}
function loadDist(siteUrl) {
    if ($("#user_province_get").val()) {
        $.ajax({
            url: siteUrl + 'home/showcart/getDistrict',
            type: "POST",
            data: {user_province_put: $("#user_province_get").val()},
            cache: true,
            beforeSend: function () {
                document.getElementById("user_province_get").disabled = true;
            },
            success: function (response) {
                document.getElementById("user_province_get").disabled = false;
                if (response) {
                    var json = JSON.parse(response);
                    emptySelectBoxById('user_district_get', json);
                    delete json;
                } else {
                    alert("Lỗi! Vui lòng thử lại");
                }
            },
            error: function () {
                alert("Lỗi! Vui lòng thử lại");
            }
        });
    }
}
function emptySelectBoxById(eid, value) {
    if (value) {
        var text = "";
        $.each(value, function (k, v) {
            if (k != "") {
                text += "<option value='" + k + "'>" + v + "</option>";
            }
        });
        document.getElementById(eid).innerHTML = text;
        delete text;
    }
}
jQuery(document).ready(function ($) {
    jQuery("#commentForm").validate({
        rules: {noc_comment: "required"},
        messages: {noc_comment: "Vui lòng nhập nội dung bình luận."},
        submitHandler: function (form) {
            jQuery.ajax({
                type: "POST",
                url: siteUrl + "tintuc/comment",
                data: jQuery(form).find(':input').serialize(),
                dataType: "json",
                success: function (data) {
                    location.reload();
                }
            })
        }
    });
    

    
    $('#btn_login').click(function () {
        $('#myModal').modal('hide');
        $('#panel .toggle').slideToggle('slow');
        var b = $(this).attr('class');
        if (b == 'down') {
            $(this).removeClass('down').addClass('up');
        } else {
            $(this).removeClass('up').addClass('down');
        }
    });
    $('#btn_close').click(function () {
        $('#panel .toggle').slideUp('slow');
        $('#btn_toolbox_right').show(1000);
    });
	
    
    $('[data-toggle="tooltip"]').tooltip();
    $('.linkfilter li').click(function () {
        $('.linkfilter li').removeClass('active');
        $(this).addClass('active');
    });
});
var SHOWCART_ORDER = {'is_allow': true, 'message': null};
function addEmailNewsletter(baseurl) {
    email = jQuery('#email').val();
    if (checkEmail(email)) {
        jQuery.ajax({
            type: "POST", url: baseurl + "newsletter/ajax", data: "email=" + email, success: function (data) {
                if (data == "1") {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Đăng ký nhận email thành công!',
                        'theme': 'green',
                        'btns': {'text': 'Ok', 'theme': 'green'}
                    });
                    // window.location = baseurl + 'discovery';
                }
                if (data == "0") {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Đăng ký nhận email không thành công!',
                        'theme': 'red',
                        'btns': {
                            'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                                e.preventDefault();
                                return false;
                            }
                        }
                    });
                }
                if (data == "2") {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Email này đã đăng ký rồi. Cảm ơn bạn!',
                        'theme': 'blue',
                        'btns': {
                            'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                e.preventDefault();
                                return false;
                            }
                        }
                    });
                    // window.location = baseurl + 'discovery';
                }
            }, error: function () {
            }
        });
    } else {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Email không hợp lệ!',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    return false;
                }
            }
        });
    }
}
function registerStore(baseurl) {
    var style_id = $.map($('input[name="template"]:checked'), function (c) {
        return c.value;
    })
    if (style_id == '') {
        alert('Bạn vui lòng chọn mẫu giao diện trước khi mở shop');
        return false;
    } else {
        window.location = baseurl + 'register/afstore?style=' + style_id;
    }
}
function changeHistoryTab(e) {
    switch (e) {
        case"product":
            jQuery(".k_raovattab").removeClass("current");
            jQuery(".k_hoidaptab").removeClass("current");
            jQuery(".k_producttab").removeClass("current").addClass("current");
            jQuery("#k_sanphamdaxem").css("display", "block");
            jQuery("#k_raovatdaxem").css("display", "none");
            jQuery("#k_hoidapdaxem").css("display", "none");
            break;
        case"raovat":
            jQuery(".k_producttab").removeClass("current");
            jQuery(".k_hoidaptab").removeClass("current");
            jQuery(".k_raovattab").removeClass("current").addClass("current");
            jQuery("#k_sanphamdaxem").css("display", "none");
            jQuery("#k_raovatdaxem").css("display", "block");
            jQuery("#k_hoidapdaxem").css("display", "none");
            break;
        case"hoidap":
            jQuery(".k_raovattab").removeClass("current");
            jQuery(".k_producttab").removeClass("current");
            jQuery(".k_hoidaptab").removeClass("current").addClass("current");
            jQuery("#k_sanphamdaxem").css("display", "none");
            jQuery("#k_raovatdaxem").css("display", "none");
            jQuery("#k_hoidapdaxem").css("display", "block");
            break;
        default:
    }
}
function checkEmail(s) {
    if (s.indexOf(" ") > 0)return false;
    if (s.indexOf("@") == -1)return false;
    if (s.indexOf(".") == -1)return false;
    if (s.indexOf("..") > 0)return false;
    if (s.indexOf("@") != s.lastIndexOf("@"))return false;
    if ((s.indexOf("@.") != -1) || (s.indexOf(".@") != -1))return false;
    if ((s.indexOf("@") == s.length - 1) || (s.indexOf(".") == 0))return false;
    if ((s.indexOf(".") == s.length - 1) || (s.indexOf("@") == 0))if (s.indexOf("@") > s.indexOf("."))return false;
    var str = "0123456789abcdefghikjlmnopqrstuvwxysz-@._";
    for (var i = 0; i < s.length; i++) {
        if (str.indexOf(s.charAt(i)) == -1)return false;
    }
    return true;
}
function submitenter(e, t, n) {
    var r;
    if (window.event)r = window.event.keyCode; else if (t)r = t.which; else return true;
    if (r == 13) {
        qSearch(n);
        return false
    } else return true
}
function openMenu() {
    if (jQuery("#inner_menu").css("display") == "none") {
        jQuery("#inner_menu").slideDown("slow")
    } else {
        jQuery("#inner_menu").slideUp("slow")
    }
}
function WaitingLoadPage() {
    jQuery("DivGlobalSite").css("display", "")
}
function OpenTab(e) {
    switch (e) {
        case 1:
            document.getElementById("DivContentDetail").style.display = "";
            document.getElementById("DivVoteDetail").style.display = "none";
            document.getElementById("DivReplyDetail").style.display = "none";
            document.getElementById("DivSendLinkDetail").style.display = "none";
            document.getElementById("DivSendFailDetail").style.display = "none";
            document.getElementById("DivHetHangDetail").style.display = "none";
            break;
        case 2:
            document.getElementById("DivContentDetail").style.display = "none";
            document.getElementById("DivVoteDetail").style.display = "";
            document.getElementById("DivReplyDetail").style.display = "none";
            document.getElementById("DivSendLinkDetail").style.display = "none";
            document.getElementById("DivSendFailDetail").style.display = "none";
            document.getElementById("DivHetHangDetail").style.display = "none";
            break;
        case 3:
            document.getElementById("DivContentDetail").style.display = "none";
            document.getElementById("DivVoteDetail").style.display = "none";
            document.getElementById("DivReplyDetail").style.display = "";
            document.getElementById("DivSendLinkDetail").style.display = "none";
            document.getElementById("DivSendFailDetail").style.display = "none";
            document.getElementById("DivHetHangDetail").style.display = "none";
            break;
        case 4:
            if (document.getElementById("DivSendLinkDetail").style.display == "") {
                document.getElementById("DivSendLinkDetail").style.display = "none";
                document.getElementById("DivHetHangDetail").style.display = "none"
            } else {
                document.getElementById("DivSendLinkDetail").style.display = "";
                document.getElementById("DivSendFailDetail").style.display = "none";
                document.getElementById("DivHetHangDetail").style.display = "none"
            }
            break;
        case 5:
            if (document.getElementById("DivSendFailDetail").style.display == "") {
                document.getElementById("DivSendFailDetail").style.display = "none";
                document.getElementById("DivHetHangDetail").style.display = "none"
            } else {
                document.getElementById("DivSendFailDetail").style.display = "";
                document.getElementById("DivSendLinkDetail").style.display = "none";
                document.getElementById("DivHetHangDetail").style.display = "none"
            }
            break;
        default:
            document.getElementById("DivContentDetail").style.display = "";
            document.getElementById("DivVoteDetail").style.display = "none";
            document.getElementById("DivReplyDetail").style.display = "none";
            document.getElementById("DivSendLinkDetail").style.display = "none";
            document.getElementById("DivSendFailDetail").style.display = "none";
            document.getElementById("DivHetHangDetail").style.display = "none"
    }
}
function OpenTabhethang() {
    if (document.getElementById("DivHetHangDetail").style.display == "block") {
        document.getElementById("DivHetHangDetail").style.display = "none"
    } else {
        document.getElementById("DivHetHangDetail").style.display = "block";
        document.getElementById("DivSendLinkDetail").style.display = "none";
        document.getElementById("DivSendFailDetail").style.display = "none"
    }
}
function OpenTabAds(e) {
    switch (e) {
        case 1:
            document.getElementById("DivContentDetail").style.display = "";
            document.getElementById("DivReplyDetail").style.display = "none";
            document.getElementById("DivSendLinkDetail").style.display = "none";
            document.getElementById("DivSendFailDetail").style.display = "none";
            break;
        case 2:
            document.getElementById("DivContentDetail").style.display = "none";
            document.getElementById("DivReplyDetail").style.display = "";
            document.getElementById("DivSendLinkDetail").style.display = "none";
            document.getElementById("DivSendFailDetail").style.display = "none";
            break;
        case 3:
            if (document.getElementById("DivSendLinkDetail").style.display == "") {
                document.getElementById("DivSendLinkDetail").style.display = "none"
            } else {
                document.getElementById("DivSendLinkDetail").style.display = "";
                document.getElementById("DivSendFailDetail").style.display = "none"
            }
            break;
        case 4:
            if (document.getElementById("DivSendFailDetail").style.display == "") {
                document.getElementById("DivSendFailDetail").style.display = "none"
            } else {
                document.getElementById("DivSendFailDetail").style.display = "";
                document.getElementById("DivSendLinkDetail").style.display = "none"
            }
            break;
        default:
            document.getElementById("DivContentDetail").style.display = "";
            document.getElementById("DivReplyDetail").style.display = "none";
            document.getElementById("DivSendLinkDetail").style.display = "none";
            document.getElementById("DivSendFailDetail").style.display = "none"
    }
}
function OpenTabJob(e) {
    switch (e) {
        case 1:
            if (document.getElementById("DivSendLinkDetail").style.display == "") {
                document.getElementById("DivSendLinkDetail").style.display = "none"
            } else {
                document.getElementById("DivSendLinkDetail").style.display = "";
                document.getElementById("DivSendFailDetail").style.display = "none"
            }
            break;
        case 2:
            if (document.getElementById("DivSendFailDetail").style.display == "") {
                document.getElementById("DivSendFailDetail").style.display = "none"
            } else {
                document.getElementById("DivSendFailDetail").style.display = "";
                document.getElementById("DivSendLinkDetail").style.display = "none"
            }
            break;
        default:
            document.getElementById("DivSendLinkDetail").style.display = "none";
            document.getElementById("DivSendFailDetail").style.display = "none"
    }
}

function ChangeStyle(e, t) {
    switch (t) {
        case 1:
            document.getElementById(e).style.border = "1px #2F97FF solid";
            break;
        case 2:
            document.getElementById(e).style.border = "1px #CCC solid";
            break;
        default:
            document.getElementById(e).style.border = "1px #2F97FF solid"
    }
}

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

function CheckPhone(e) {
    if (e.length < 5 || e.length > 16) {
        return false
    } else {
        var t = "0123456789.()+";
        for (var n = 0; n < e.length; n++) {
            if (t.indexOf(e.charAt(n)) == -1) {
                return false
            }
        }
    }
    return true
}

function CheckCharacter(e) {
    var t = "0123456789abcdefghikjlmnopqrstuvwxyszABCDEFGHIKJLMNOPQRSTUVWXYSZ-_";
    for (var n = 0; n < e.length; n++) {
        if (t.indexOf(e.charAt(n)) == -1) {
            return false
        }
    }
    return true
}

function CheckLink(e) {
    var t = "0123456789abcdefghikjlmnopqrstuvwxysz-_";
    for (var n = 0; n < e.length; n++) {
        if (t.indexOf(e.charAt(n)) == -1) {
            return false
        }
    }
    return true
}

function CheckWebsite(e) {
    var t = "0123456789abcdefghikjlmnopqrstuvwxysz/.:-_";
    for (var n = 0; n < e.length; n++) {
        if (t.indexOf(e.charAt(n)) == -1) {
            return false
        }
    }
    return true
}

function CheckDate(e, t, n) {
    var r = new Date;
    var i = r.getDate();
    var s = r.getMonth();
    var o = r.getFullYear();
    s = s + 1;
    e = e * 1;
    t = t * 1;
    n = n * 1;
    if (n > o) {
        return true
    }
    if (n == o) {
        if (t > s) {
            return true
        }
        if (t == s) {
            if (e > i) {
                return true
            } else {
                return false
            }
        } else {
            return false
        }
    } else {
        return false
    }
}

function CompareDate(e, t, n, r, i, s) {
    e = e * 1;
    t = t * 1;
    n = n * 1;
    r = r * 1;
    i = i * 1;
    s = s * 1;
    if (n < s) {
        return true
    }
    if (n == s) {
        if (t < i) {
            return true
        }
        if (t == i) {
            if (e <= r) {
                return true
            } else {
                return false
            }
        } else {
            return false
        }
    } else {
        return false
    }
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

    
    if( $('#capcha_friend').length == 1  && $('#captcha_sendlink').length > 0)
        {
            if($('#captcha_sendlink').val() != $('#capcha_friend').val())
            {
                $.jAlert({
                    'title': 'Nhập sai',
                    'content': 'Bạn nhập mã xác nhận chưa đúng!',
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                            jQuery('#captcha_sendlink').focus();   
                            return false;
                        }
                    }
                });
                return false;
            }
        }

    document.frmSendLink.submit()
}

function CheckInput_SendFail(e) {
    if (e == "1") {
        if (CheckBlank(document.getElementById("title_sendfail").value)) {
            alert("Bạn chưa nhập tiêu đề!");
            document.getElementById("title_sendfail").focus();
            return false
        }
        if (CheckBlank(document.getElementById("content_sendfail").value)) {
            alert("Bạn chưa nhập nội dung!");
            document.getElementById("content_sendfail").focus();
            return false
        }
        if (CheckBlank(document.getElementById("captcha_sendfail").value)) {
            alert("Bạn chưa nhập mã xác nhận!");
            document.getElementById("captcha_sendfail").focus();
            return false
        }
        if (document.getElementById("captcha_sendfail").value != document.getElementById("capcha_het_hang").value) {
            alert("Bạn nhập mã xác nhận không đúng!");
            document.getElementById("captcha_sendfail").focus();
            return false
        }
        jQuery("#bao_cao_sai_gia").val(1);
        document.frmSendFail.submit()
    } else {
        alert(e);
        return false
    }
}

function CheckInput_SendHetHang() {
    if (CheckBlank(document.getElementById("title_sendfail_het_hang").value)) {
        alert("Bạn chưa nhập tiêu đề!");
        document.getElementById("title_sendfail_het_hang").focus();
        return false
    }
    if (CheckBlank(document.getElementById("content_sendfail_het_hang").value)) {
        alert("Bạn chưa nhập nội dung!");
        document.getElementById("content_sendfail_het_hang").focus();
        return false
    }
    if (CheckBlank(document.getElementById("captcha_sendfail_het_hang").value)) {
        alert("Bạn chưa nhập mã xác nhận!");
        document.getElementById("captcha_sendfail_het_hang").focus();
        return false
    }
    if (document.getElementById("captcha_sendfail_het_hang").value != document.getElementById("capcha_het_hang").value) {
        alert("Bạn  nhập mã xác nhận không đúng!");
        document.getElementById("captcha_sendfail_het_hang").focus();
        return false
    }
    jQuery("#bao_cao_het_hang").val(1);
    document.frmSendFailHetHang.submit()
}

function CheckInput_Reply(e) {
    if (e == "1") {
        if (CheckBlank(document.getElementById("title_reply").value)) {
            alert("Bạn chưa nhập tiêu đề!");
            document.getElementById("title_reply").focus();
            return false
        }
        if (CheckBlank(document.getElementById("content_reply").value)) {
            alert("Bạn chưa nhập nội dung!");
            document.getElementById("content_reply").focus();
            return false
        }
        if (CheckBlank(document.getElementById("captcha_reply").value)) {
            alert("Bạn chưa nhập mã xác nhận!");
            document.getElementById("captcha_reply").focus();
            return false
        }

        if( $('#captcha').length == 1  && $('.inputcaptcha_form').length > 0)
        {
            if($('.inputcaptcha_form').val() != $('#captcha').val())
            {
                $.jAlert({
                    'title': 'Nhập sai',
                    'content': 'Bạn nhập mã xác nhận chưa đúng!',
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                            jQuery('.inputcaptcha_form').focus();   
                            return false;
                        }
                    }
                });
                return false;
            }
        }



        document.frmReply.submit()
    } else {
        alert(e);
        return false
    }
}

function isInt(e) {
    var t = parseInt(e);
    if (isNaN(t))return false;
    return e == t && e.toString() == t.toString()
}

function CheckInput_PostPro() {
    
    if ($("#cat_pro_0").css('display') != 'none') {
        if (document.getElementById("cat_pro_0").value == 0) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa chọn danh mục sản phẩm!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("cat_pro_0").focus();
                    }
                }
            });
            return false
        }
        if ($("#cat_pro_1").length > 0 && $('#cat_pro_1').css('display') != 'none') {
            if (document.getElementById("cat_pro_1").value == 0) {
                $.jAlert({
                    'title': 'Yêu cầu nhập',
                    'content': 'Bạn chưa chọn danh mục sản phẩm!',
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("cat_pro_1").focus();
                            return false;
                        }
                    }
                });
                return false
            }
        }
        if ($("#cat_pro_2").length > 0 && $('#cat_pro_1').css('display') != 'none') {
            if (document.getElementById("cat_pro_2").value == 0) {
                $.jAlert({
                    'title': 'Yêu cầu nhập',
                    'content': 'Bạn chưa chọn danh mục sản phẩm!',
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("cat_pro_2").focus();
                            return false;
                        }
                    }
                });
                return false
            }
        }
        if ($("#cat_pro_3").length > 0 && $('#cat_pro_1').css('display') != 'none') {
            if (document.getElementById("cat_pro_3").value == 0) {
                $.jAlert({
                    'title': 'Yêu cầu nhập',
                    'content': 'Bạn chưa chọn danh mục sản phẩm!',
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("cat_pro_3").focus();
                            return false;
                        }
                    }
                });
                return false
            }
        }
        if ($("#cat_pro_4").length > 0 && $('#cat_pro_1').css('display') != 'none') {
            if (document.getElementById("cat_pro_4").value == 0) {
                $.jAlert({
                    'title': 'Yêu cầu nhập',
                    'content': 'Bạn chưa chọn danh mục sản phẩm!',
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("cat_pro_4").focus();
                            return false;
                        }
                    }
                });
                return false
            }
        }
    }
    if ($("#cat_search").length > 0 && $('#cat_search').css('display') != 'none') {
        if (document.getElementById("cat_search").value == 0) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa chọn danh mục sản phẩm!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("cat_search").focus();
                        return false;
                    }
                }
            });
            return false
        }
    }
    if (CheckBlank(document.getElementById("name_pro").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập tên sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("name_pro").focus();
                    return false;
                }
            }
        });
        return false
    }
    if (CheckBlank(document.getElementById("pro_sku").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập mã sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("pro_sku").focus();
                    return false;
                }
            }
        });
        return false
    }
    if (CheckBlank(document.getElementById("descr_pro").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa mô tả sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("descr_pro").focus();
                    return false;
                }
            }
        });
        return false
    }
    if (CheckBlank(document.getElementById("pro_instock").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập số lượng!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("pro_instock").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("cost_pro").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập giá sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("cost_pro").focus();
                    return false;
                }
            }
        });
        return false;
    } else {
        if (document.getElementById("cost_pro").value == '0') {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Giá sản phẩm phải lớn hơn 0!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("cost_pro").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (!IsNumber(document.getElementById("cost_pro").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Giá sản phẩm chỉ được phép nhập số!',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("cost_pro").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (document.getElementById("nameImage_1").value == "") {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn chưa chọn hình ảnh!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("image_1_pro").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (jQuery("#affiliate_pro").is(":checked")) {
        if (CheckBlank(document.getElementById("pro_dc_affiliate_value").value)) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập số tiền hoa hồng!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("not_pro_cat_id").focus();
                        return false;
                    }
                }
            });
            return false;
        } else {
            if (jQuery("#pro_affiliate_value").val() > 100 && jQuery("#pro_type_affiliate").val() == "1") {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Hoa hồng theo phần trăm phải nhỏ hơn 100%!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("pro_affiliate_value").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
            if (!isInt(jQuery("#pro_affiliate_value").val())) {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Bạn phải nhập số tiền hoa hồng dạng số!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("not_pro_cat_id").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
            if (jQuery("#pro_affiliate_value").val() == "0") {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Bạn phải nhập số tiền hoa hồng lớn hơn 0!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("pro_affiliate_value").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
        }
    }
    if (jQuery("#saleoff_pro").is(":checked")) {
        if (CheckBlank(document.getElementById("promotion_expiry").value)) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập số ngày áp dụng giảm giá!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("promotion_expiry").focus();
                        return false;
                    }
                }
            });
            return false;
        }
        if (CheckBlank(document.getElementById("pro_saleoff_value").value)) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập số tiền giảm giá!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("not_pro_cat_id").focus();
                        return false;
                    }
                }
            });
            return false;
        } else {
            if (jQuery("#pro_saleoff_value").val() > 100 && jQuery("#pro_type_saleoff").val() == "1") {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Giảm giá theo phần trăm phải nhỏ hơn 100%!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("pro_saleoff_value").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
            if (!isInt(jQuery("#pro_saleoff_value").val())) {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Bạn phải nhập số tiền giảm giá dạng số!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("pro_saleoff_value").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
            if (jQuery("#pro_saleoff_value").val() == "0") {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Bạn phải nhập số tiền giảm giá lớn hơn 0!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("pro_saleoff_value").focus();
                            return false;
                        }
                    }
                });
            }
        }
    }
    var n = tinyMCE.get("txtContent").getContent();
    if (n != "") {
        var r = document.createElement("div");
        r.innerHTML = n;
        var i = r.textContent || r.innerText || "";
        if (i.trim().split(' ').length < 40) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Bạn nhập chi tiết sản phẩm quá ngắn phải nhập lớn hơn 40 ký tự !',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("txtContent").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (CheckBlank(n)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập chi tiết sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("txtContent").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (!IsNumber(document.getElementById("pro_instock").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Số lượng sản phẩm chỉ được phép nhập số!',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("pro_instock").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if ($('#pro_weight').length > 0) {
        if (CheckBlank(document.getElementById("pro_weight").value)) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập trọng lượng sản phẩm!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("pro_weight").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (CheckBlank(document.getElementById("pro_vat").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa thuế VAT!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("pro_vat").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if ($('#pro_weight').length > 0) {
        if (!IsNumber(document.getElementById("pro_weight").value)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Trọng lượng sản phẩm chỉ được phép nhập số!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("pro_weight").focus();
                        return false;
                    }
                }
            });
            return false;
        }
        if (!IsNumber(document.getElementById("pro_length").value)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Chiều dài sản phẩm chỉ được phép nhập số!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("pro_length").focus();
                        return false;
                    }
                }
            });
            return false;
        }
        if (!IsNumber(document.getElementById("pro_width").value)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Chiều rộng sản phẩm chỉ được phép nhập số!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("pro_width").focus();
                        return false;
                    }
                }
            });
            return false;
        }
        if (!IsNumber(document.getElementById("pro_height").value)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Chiều cao sản phẩm chỉ được phép nhập số!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("pro_height").focus();
                        return false;
                    }
                }
            });
            return false;
        }
        if (!IsNumber(document.getElementById("pro_warranty_period").value)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Thời gian bảo hành sản phẩm chỉ được phép nhập số!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("pro_warranty_period").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    jQuery("#isPostProduct").val(1);
    document.frmPostPro.submit()
}
function CheckInput_EditPro() {
    if ($("#cat_pro_0").length > 0) {
        if (document.getElementById("cat_pro_0").value == 0) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa chọn danh mục sản phẩm!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("cat_pro_0").focus();
                    }
                }
            });
            return false
        }
    }
    if ($("#cat_pro_1").length > 0) {
        if (document.getElementById("cat_pro_1").value == 0) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa chọn danh mục sản phẩm!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("cat_pro_1").focus();
                        return false;
                    }
                }
            });
            return false
        }
    }
    if ($("#cat_pro_2").length > 0) {
        if (document.getElementById("cat_pro_2").value == 0) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa chọn danh mục sản phẩm!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("cat_pro_2").focus();
                        return false;
                    }
                }
            });
            return false
        }
    }
    if ($("#cat_pro_3").length > 0) {
        if (document.getElementById("cat_pro_3").value == 0) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa chọn danh mục sản phẩm!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("cat_pro_3").focus();
                        return false;
                    }
                }
            });
            return false
        }
    }
    if ($("#cat_pro_4").length > 0) {
        if (document.getElementById("cat_pro_4").value == 0) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa chọn danh mục sản phẩm!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("cat_pro_4").focus();
                        return false;
                    }
                }
            });
            return false
        }
    }
    if (CheckBlank(document.getElementById("name_pro").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập tên sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("name_pro").focus();
                    return false;
                }
            }
        });
        return false
    }
    if (CheckBlank(document.getElementById("pro_sku").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập mã sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("pro_sku").focus();
                    return false;
                }
            }
        });
        return false
    }
    if (CheckBlank(document.getElementById("descr_pro").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa mô tả sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("descr_pro").focus();
                    return false;
                }
            }
        });
        return false
    }
    if (CheckBlank(document.getElementById("pro_instock").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập số lượng!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("pro_instock").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("cost_pro").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập giá sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("cost_pro").focus();
                    return false;
                }
            }
        });
        return false;
    } else {
        if (document.getElementById("cost_pro").value == '0') {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Giá sản phẩm phải lớn hơn 0!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("cost_pro").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if ($('#wapper-saleoff').css('display') == 'block') {
        if (CheckBlank(document.getElementById("promotion_expiry").value)) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa số ngày khuyến mãi!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("promotion_expiry").focus();
                        return false;
                    }
                }
            });
            return false
        }
    }
    if (document.getElementById("nameImage_1").value == "" && jQuery('#vavatar_input1').css('display') == 'block') {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn chưa chọn hình ảnh!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("image_1_pro").focus();
                    return false;
                }
            }
        });
        return false
    }
    if ($('#pro_minsale')[0]) {
        if ($("#pro_minsale").val() == 0) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Số lượng bán tối thiểu phải lớn hơn 0!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("pro_minsale").focus();
                        $("#pro_minsale").val('1');
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (jQuery("#affiliate_pro").is(":checked")) {
        if (CheckBlank(document.getElementById("pro_affiliate_value").value) || CheckBlank(document.getElementById("pro_dc_affiliate_value").value)) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập số tiền hoa hồng!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("not_pro_cat_id").focus();
                        return false;
                    }
                }
            });
            return false;
        } else {
            if (jQuery("#pro_affiliate_value").val() > 100 && jQuery("#pro_type_affiliate").val() == "1") {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Hoa hồng theo phần trăm phải nhỏ hơn 100%!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("pro_affiliate_value").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
            if (!isInt(jQuery("#pro_affiliate_value").val())) {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Bạn phải nhập số tiền hoa hồng dạng số!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("not_pro_cat_id").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
            if (jQuery("#pro_affiliate_value").val() == "0") {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Bạn phải nhập số tiền hoa hồng lớn hơn 0!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("pro_affiliate_value").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
        }
    }
    if (jQuery("#saleoff_pro").is(":checked")) {
        if (CheckBlank(document.getElementById("pro_saleoff_value").value)) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập số tiền giảm giá!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("not_pro_cat_id").focus();
                        return false;
                    }
                }
            });
            return false;
        } else {
            if (jQuery("#pro_saleoff_value").val() > 100 && jQuery("#pro_type_saleoff").val() == "1") {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Giảm giá theo phần trăm phải nhỏ hơn 100%!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("pro_saleoff_value").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
            if (!isInt(jQuery("#pro_saleoff_value").val())) {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Bạn phải nhập số tiền giảm giá dạng số!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("pro_saleoff_value").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
            if (jQuery("#pro_saleoff_value").val() == "0") {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Bạn phải nhập số tiền giảm giá lớn hơn 0!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("pro_saleoff_value").focus();
                            return false;
                        }
                    }
                });
            }
        }
    }
    var n = tinyMCE.get("txtContent").getContent();
    if (n != "") {
        var r = document.createElement("div");
        r.innerHTML = n;
        var i = r.textContent || r.innerText || "";
        if (i.length < 40) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Bạn nhập chi tiết sản phẩm quá ngắn phải nhập lớn hơn 40 ký tự !',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("txtContent").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (CheckBlank(n)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập chi tiết sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("txtContent").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if ($('#pro_weight').length > 0) {
        if (CheckBlank(document.getElementById("pro_weight").value)) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập trọng lượng sản phẩm!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("pro_weight").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    jQuery("#isEditProduct").val(1);
    document.frmEditPro.submit()
}
function CheckInput_EditProBranch() {
    if (CheckBlank(document.getElementById("cost_pro").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập giá sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("cost_pro").focus();
                    return false;
                }
            }
        });
        return false;
    } else {
        if (document.getElementById("cost_pro").value == '0') {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Giá sản phẩm phải lớn hơn 0!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("cost_pro").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (jQuery("#affiliate_pro").is(":checked")) {
        if (CheckBlank(document.getElementById("pro_dc_affiliate_value").value)) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập số tiền hoa hồng!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("not_pro_cat_id").focus();
                        return false;
                    }
                }
            });
            return false;
        } else {
            if (jQuery("#pro_affiliate_value").val() > 100 && jQuery("#pro_type_affiliate").val() == "1") {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Hoa hồng theo phần trăm phải nhỏ hơn 100%!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("pro_affiliate_value").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
            if (!isInt(jQuery("#pro_affiliate_value").val())) {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Bạn phải nhập số tiền hoa hồng dạng số!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("not_pro_cat_id").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
            if (jQuery("#pro_affiliate_value").val() == "0") {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Bạn phải nhập số tiền hoa hồng lớn hơn 0!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("pro_affiliate_value").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
        }
    }
    var n = tinyMCE.get("txtContent").getContent();
    if (n != "") {
        var r = document.createElement("div");
        r.innerHTML = n;
        var i = r.textContent || r.innerText || "";
        if (i.length < 40) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Bạn nhập chi tiết sản phẩm quá ngắn phải nhập lớn hơn 40 ký tự !',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("txtContent").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (CheckBlank(n)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập chi tiết sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("txtContent").focus();
                    return false;
                }
            }
        });
        return false;
    }
    jQuery("#isEditProduct").val(1);
    document.frmEditPro.submit()
}
function CheckInput_PostAds() {
    if (document.getElementById("image_ads").value != "") {
        var e = document.getElementById("image_ads").value;
        ext = e.split(".")[1];
        var t = "";
        switch (ext) {
            case"png":
                t = 1;
                break;
            case"gif":
                t = 1;
                break;
            case"jpg":
                t = 1;
                break;
            case"PNG":
                t = 1;
                break;
            case"GIF":
                t = 1;
                break;
            case"JPG":
                t = 1;
                break;
            default:
                t = 0
        }
        if (t == 0) {
            alert("Bạn nhập không đúng định dạng file");
            return false
        }
    }
    if (jQuery("#image_ads")[0].files[0]) {
        if (jQuery("#image_ads")[0].files[0].size > 1024 * 1024) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Dung lượng ảnh upload tối đa 1MB',
                'theme': 'default',
                'btns': {'text': 'Ok', 'theme': 'default'}
            });
            return false
        }
    }
    if (CheckBlank(document.getElementById("title_ads").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa tiêu đề!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("title_ads").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (document.getElementById("descr_ads").value.length > 35) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn nhập mô tả quá 35 ký tự!',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("descr_ads").focus();
                    return false;
                }
            }
        });
        return false;
    }
    var n = tinyMCE.get("txtContent").getContent();
    if (n != "") {
        var r = document.createElement("div");
        r.innerHTML = n;
        var i = r.textContent || r.innerText || "";
        if (i.length < 40) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn nhập chi tiết rao vặt quá ngắn phải nhập lớn hơn 40 ký tự !',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("txtContent").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (CheckBlank(n)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập chi tiết sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("txtContent").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("fullname_ads").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập người đăng rao vặt!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("fullname_ads").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("address_ads").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập địa chỉ liên hệ!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("address_ads").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (document.getElementById("phone_ads").value != "") {
        if (!CheckPhone(document.getElementById("phone_ads").value)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("phone_ads").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (!CheckBlank(document.getElementById("mobile_ads").value)) {
        if (!CheckPhone(document.getElementById("mobile_ads").value)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("mobile_ads").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (CheckBlank(document.getElementById("email_ads").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập email!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("email_ads").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (!CheckEmail(document.getElementById("email_ads").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Email bạn nhập không hợp lệ!',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("email_ads").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("captcha_ads").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập mã xác nhận!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("captcha_ads").focus();
                    return false;
                }
            }
        });
        return false;
    } else {
        if (document.getElementById("captcha_ads").value != document.getElementById("captcha").value) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Mã xác nhận bạn nhập không đúng!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("captcha_ads").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (jQuery("#image_ads")[0].files[0]) {
        if (jQuery("#image_ads")[0].files[0].size > 512 * 1024) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Dung lượng upload tối đa 3Mb!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("image_ads").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    jQuery("#isPostAds").val(1);
    document.frmPostAds.submit()
}
function CheckInput_PostHds() {
    if (CheckBlank(document.getElementById("title_hds").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập tiêu đề!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("title_hds").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("hd_category_id").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa danh mục hoặc chưa phải là danh mục cuối để đăng hỏi đáp!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("hd_category_id").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("username_hds").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập tên của người đăng hỏi đáp!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("username_hds").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("captcha_hds").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập mã xác nhận!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("captcha_hds").focus();
                    return false;
                }
            }
        });
        return false;
    } else {
        if (document.getElementById("captcha_hds").value != document.getElementById("captcha").value) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Mã xác nhận bạn nhập không đúng!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("captcha_hds").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    jQuery("#isPostHds").val(1);
    document.frmPostHds.submit()
}
function CheckInput_editTraLoi() {
    if (CheckBlank(document.getElementById("captcha_hds").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập mã xác nhận',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("captcha_hds").focus();
                    return false;
                }
            }
        });
        return false;
    } else {
        if (document.getElementById("captcha_hds").value != document.getElementById("captcha").value) {
            $.jAlert({
                'title': 'Thông báo',
                'content': '"Mã xác nhận bạn nhập không đúng!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("captcha_hds").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    jQuery("#isPostHds").val(1);
    document.frmPostHds.submit()
}
function thong_bao_kich_thuoc_banner(e) {
    if (e == 1) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 980px và chiều cao 120px ")
    }
    if (e == 2) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 970px và chiều cao 250px ")
    }
    if (e == 3) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 468px và chiều cao 60px ")
    }
    if (e == 4) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 468px và chiều cao 60px ")
    }
    if (e == 5) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 580px và chiều cao 400px ")
    }
    if (e == 6) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 200px và chiều cao 200px ")
    }
    if (e == 7) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 200px và chiều cao 200px ")
    }
    if (e == 8) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 320px và chiều cao 480px ")
    }
    if (e == 9) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 240px và chiều cao 400px ")
    }
    if (e == 10) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 234px và chiều cao 60px ")
    }
    if (e == 11) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 425px và chiều cao 600px")
    }
    if (e == 12) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 468px và chiều cao 60px")
    }
    if (e == 13) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 468px và chiều cao 60px")
    }
    if (e == 14) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 728px và chiều cao 90px")
    }
    if (e == 15) {
        jQuery("#quydinhichtuocbanner").html("Kích thước chuẩn cho banner là chiều dài 230px và chiều cao 90px")
    }
}
function CheckInput_PostHdsReply() {
    if (CheckBlank(tinyMCE.get("txtContent").getContent())) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập nội dung câu trả lời!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("txtContent").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("captcha_hds").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập mã xác nhận!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("captcha_hds").focus();
                    return false;
                }
            }
        });
        return false;
    } else {
        if (document.getElementById("captcha_hds").value != document.getElementById("captcha").value) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Mã xác nhận bạn nhập không đúng!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("captcha_hds").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (jQuery("#editAnswerId").val()) {
        jQuery("#isEditHdsReply").val(1)
    } else {
        jQuery("#isPostHdsReply").val(1)
    }
    document.frmHoidapReply.submit()
}
function CheckInput_PostJob() {
    if (CheckBlank(document.getElementById("title_job").value)) {
        alert("Bạn chưa nhập tiêu đề!");
        document.getElementById("title_job").focus();
        return false
    }
    if (document.getElementById("yeu_cau_trinh_Do").value == "0" && CheckBlank(document.getElementById("level_job").value)) {
        alert("Bạn chưa nhập trình độ!");
        document.getElementById("nganhnghe_dien").focus();
        return false
    }
    if (document.getElementById("field_job").value == "0" && CheckBlank(document.getElementById("nganhnghe_dien").value)) {
        alert("Bạn chưa nhập ngành nghề tuyển dụng!");
        document.getElementById("nganhnghe_dien").focus();
        return false
    }
    if (CheckBlank(document.getElementById("position_job").value)) {
        alert("Bạn chưa nhập vị trí tuyển dụng!");
        document.getElementById("position_job").focus();
        return false
    }
    if (document.getElementById("age1_job").value > document.getElementById("age2_job").value) {
        alert("Bạn chọn tuổi không hợp lệ!\nVí dụ: Tuổi từ 18 đến 25.");
        return false
    }
    if (CheckBlank(document.getElementById("require_job").value)) {
        alert("Bạn chưa nhập yêu cầu công việc!");
        document.getElementById("require_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("salary_job").value)) {
        alert("Bạn chưa nhập mức lương khởi điểm!");
        document.getElementById("salary_job").focus();
        return false
    }
    if (!IsNumber(document.getElementById("salary_job").value)) {
        alert("Mức lương khởi điểm bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
        document.getElementById("salary_job").focus();
        return false
    }
    if (document.getElementById("salary_job").value == "0") {
        alert("Mức lương khởi điểm không được bằng 0!");
        document.getElementById("salary_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("try_job").value)) {
        alert("Bạn chưa nhập thời gian thử việc!");
        document.getElementById("try_job").focus();
        return false
    }
    if (!IsNumber(document.getElementById("try_job").value)) {
        alert("Thời gian thử việc bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
        document.getElementById("try_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("interest_job").value)) {
        alert("Bạn chưa nhập quyền lợi!");
        document.getElementById("interest_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("quantity_job").value)) {
        alert("Bạn chưa nhập số lượng tuyển dụng!");
        document.getElementById("quantity_job").focus();
        return false
    }
    if (!IsNumber(document.getElementById("quantity_job").value)) {
        alert("Số lượng tuyển dụng bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
        document.getElementById("quantity_job").focus();
        return false
    }
    if (document.getElementById("quantity_job").value == "0") {
        alert("Số lượng tuyển dụng không được bằng 0!");
        document.getElementById("quantity_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("record_job").value)) {
        alert("Bạn chưa nhập hồ sơ xin việc!");
        document.getElementById("record_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("txtContent").value)) {
        alert("Bạn chưa nhập chi tiết tin tuyển dụng!");
        document.getElementById("txtContent").focus();
        return false
    }
    if (CheckBlank(document.getElementById("name_job").value)) {
        alert("Bạn chưa nhập tên nhà tuyển dụng!");
        document.getElementById("name_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("address_job").value)) {
        alert("Bạn chưa nhập địa chỉ nhà tuyển dụng!");
        document.getElementById("address_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("phone_job").value) && CheckBlank(document.getElementById("mobile_job").value)) {
        alert("Bạn chưa nhập số điện thoại nhà tuyển dụng!");
        document.getElementById("phone_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("email_job").value)) {
        alert("Bạn chưa nhập email!");
        document.getElementById("email_job").focus();
        return false
    }
    if (!CheckEmail(document.getElementById("email_job").value)) {
        alert("Email bạn nhập không hợp lệ!");
        document.getElementById("email_job").focus();
        return false
    }
    if (!CheckWebsite(document.getElementById("website_job").value)) {
        alert("Địa chỉ website bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, / . : _ -");
        document.getElementById("website_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("namecontact_job").value)) {
        alert("Bạn chưa nhập tên người đại diện!");
        document.getElementById("namecontact_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("addresscontact_job").value)) {
        alert("Bạn chưa nhập địa chỉ liên hệ!");
        document.getElementById("addresscontact_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("phonecontact_job").value)) {
        alert("Bạn chưa nhập số điện thoại liên hệ!");
        document.getElementById("phonecontact_job").focus();
        return false
    }
    if (!CheckPhone(document.getElementById("phonecontact_job").value)) {
        alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
        document.getElementById("phonecontact_job").focus();
        return false
    }
    if (!CheckBlank(document.getElementById("mobilecontact_job").value)) {
        if (!CheckPhone(document.getElementById("mobilecontact_job").value)) {
            alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
            document.getElementById("mobilecontact_job").focus();
            return false
        }
    }
    if (CheckBlank(document.getElementById("emailcontact_job").value)) {
        alert("Bạn chưa nhập email!");
        document.getElementById("emailcontact_job").focus();
        return false
    }
    if (!CheckEmail(document.getElementById("emailcontact_job").value)) {
        alert("Email bạn nhập không hợp lệ!");
        document.getElementById("emailcontact_job").focus();
        return false
    }
    if (!CheckDate(document.getElementById("endday_job").value, document.getElementById("endmonth_job").value, document.getElementById("endyear_job").value)) {
        alert("Thời gian hết hạn đăng không hợp lệ!\nThời gian hết hạn đăng phải lớn hơn ngày hiện tại.");
        return false
    }
    if (CheckBlank(document.getElementById("captcha_job").value)) {
        alert("Bạn chưa nhập mã xác nhận!");
        document.getElementById("captcha_job").focus();
        return false
    }
    if (document.getElementById("captcha_job").value != document.getElementById("captcha").value) {
        alert("Bạn nhập mã xác nhận không đúng!");
        document.getElementById("captcha_job").focus();
        return false
    }
    jQuery("#checkInsertData").val(1);
    document.frmPostJob.submit()
}
function CheckInput_PostEmploy() {
    if (CheckBlank(document.getElementById("title_employ").value)) {
        alert("Bạn chưa nhập tiêu đề!");
        document.getElementById("title_employ").focus();
        return false
    }
    if (CheckBlank(document.getElementById("position_employ").value)) {
        alert("Bạn chưa nhập vị trí làm việc!");
        document.getElementById("position_employ").focus();
        return false
    }
    if (CheckBlank(document.getElementById("salary_employ").value)) {
        alert("Bạn chưa nhập mức lương mong muốn!");
        document.getElementById("salary_employ").focus();
        return false
    }
    if (!IsNumber(document.getElementById("salary_employ").value)) {
        alert("Mức lương mong muốn bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
        document.getElementById("salary_employ").focus();
        return false
    }
    if (document.getElementById("salary_employ").value == "0") {
        alert("Mức lương mong muốn không được bằng 0!");
        document.getElementById("salary_employ").focus();
        return false
    }
    var e = tinyMCE.get("txtContent").getContent();
    if (CheckBlank(e)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập chi tiết sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("txtContent").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("name_employ").value)) {
        alert("Bạn chưa nhập họ tên!");
        document.getElementById("name_employ").focus();
        return false
    }
    if (CheckBlank(document.getElementById("level_employ").value)) {
        alert("Bạn chưa nhập trình độ!");
        document.getElementById("level_employ").focus();
        return false
    }
    if (CheckBlank(document.getElementById("address_employ").value)) {
        alert("Bạn chưa nhập địa chỉ!");
        document.getElementById("address_employ").focus();
        return false
    }
    if (CheckBlank(document.getElementById("phone_employ").value)) {
        alert("Bạn chưa nhập số điện thoại!");
        document.getElementById("phone_employ").focus();
        return false
    }
    if (!CheckPhone(document.getElementById("phone_employ").value)) {
        alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
        document.getElementById("phone_employ").focus();
        return false
    }
    if (!CheckBlank(document.getElementById("mobile_employ").value)) {
        if (!CheckPhone(document.getElementById("mobile_employ").value)) {
            alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
            document.getElementById("mobile_employ").focus();
            return false
        }
    }
    if (CheckBlank(document.getElementById("email_employ").value)) {
        alert("Bạn chưa nhập email!");
        document.getElementById("email_employ").focus();
        return false
    }
    if (!CheckEmail(document.getElementById("email_employ").value)) {
        alert("Email bạn nhập không hợp lệ!");
        document.getElementById("email_employ").focus();
        return false
    }
    if (!CheckDate(document.getElementById("endday_employ").value, document.getElementById("endmonth_employ").value, document.getElementById("endyear_employ").value)) {
        alert("Thời gian hết hạn đăng không hợp lệ!\nThời gian hết hạn đăng phải lớn hơn ngày hiện tại.");
        return false
    }
    if (CheckBlank(document.getElementById("captcha_employ").value)) {
        alert("Bạn chưa nhập mã xác nhận!");
        document.getElementById("captcha_employ").focus();
        return false
    }
    if (document.getElementById("captcha_employ").value != document.getElementById("captcha").value) {
        alert("Bạn nhập mã xác nhận không đúng!");
        document.getElementById("captcha_employ").focus();
        return false
    }
    document.frmPostEmploy.submit()
}
function CheckInput_Register() {
    var none_check = $('.none_member').css('display');
    var afstore = $('.afstore').css('display');
    if (none_check == 'block') {
        if (CheckBlank(document.getElementById("fullname_regis").value)) {
            alert("Bạn chưa nhập họ tên!");
            document.getElementById("fullname_regis").focus();
            return false
        }
    }
    var staff = $('.staff ').css('display');
    if (staff == 'block') {
        if (CheckBlank(document.getElementById("username_regis").value)) {
            alert("Bạn chưa nhập tài khoản!");
            document.getElementById("username_regis").focus();
            return false
        }
        if (!CheckCharacter(document.getElementById("username_regis").value)) {
            alert("Tài khoản bạn nhập không hợp lệ!\nChỉ chấp nhận các ký số 0-9\nChấp nhận các ký tự a-z\nChấp nhận các ký tự - _");
            document.getElementById("username_regis").focus();
            return false
        }
        if ($("#namebank_regis").length > 0) {
            if (CheckBlank(document.getElementById("namebank_regis").value)) {
                alert("Bạn chưa nhập tên ngân hàng!");
                document.getElementById("namebank_regis").focus();
                return false
            }
            if (CheckBlank(document.getElementById("addbank_regis").value)) {
                alert("Bạn chưa nhập tên chi nhánh ngân hàng!");
                document.getElementById("addbank_regis").focus();
                return false
            }
            if (CheckBlank(document.getElementById("accountname_regis").value)) {
                alert("Bạn chưa nhập tên chủ tài khoản!");
                document.getElementById("accountname_regis").focus();
                return false
            }
            if (CheckBlank(document.getElementById("accountnum_regis").value)) {
                alert("Bạn chưa nhập số tài khoản!");
                document.getElementById("accountnum_regis").focus();
                return false
            }
        }
    }
    var n = document.getElementById("username_regis").value;
    if (n.length < 6) {
        alert("Tài khoản phải có ít nhất 6 ký tự!");
        document.getElementById("username_regis").focus();
        return false
    }
    if (CheckBlank(document.getElementById("password_regis").value)) {
        alert("Bạn chưa nhập mật khẩu!");
        document.getElementById("password_regis").focus();
        return false
    }
    var r = document.getElementById("password_regis").value;
    if (r.length < 6) {
        alert("Mật khẩu phải có ít nhất 6 ký tự!");
        document.getElementById("password_regis").focus();
        return false
    }
    if (CheckBlank(document.getElementById("email_regis").value)) {
        alert("Bạn chưa nhập email!");
        document.getElementById("email_regis").focus();
        return false
    }
    if (!CheckEmail(document.getElementById("email_regis").value)) {
        alert("Email bạn nhập không hợp lê!");
        document.getElementById("email_regis").focus();
        return false
    }
    if (none_check == 'block') {
        if (CheckBlank(document.getElementById("address_regis").value)) {
            alert("Bạn chưa nhập địa chỉ!");
            document.getElementById("address_regis").focus();
            return false
        }
    }
    if (document.getElementById("shop_regis").checked == true) {
        if (CheckBlank(document.getElementById("name_shop").value)) {
            alert("Bạn chưa nhập tên công ty !");
            document.getElementById("name_shop").focus();
            return false
        }
        if (CheckBlank(document.getElementById("address_shop").value)) {
            alert("Bạn chưa nhập địa chỉ gian hàng !");
            document.getElementById("address_shop").focus();
            return false
        }
        if (CheckBlank(document.getElementById("mobile_shop").value)) {
            alert("Bạn chưa nhập điện thoại di động gian hàng !");
            document.getElementById("mobile_shop").focus();
            return false
        }
    }
    if (CheckBlank(document.getElementById("mobile_regis").value)) {
        alert("Bạn chưa nhập số điện thoại!");
        document.getElementById("mobile_regis").focus();
        return false
    }
    if (CheckBlank(document.getElementById("user_province_get").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập Tỉnh thành!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("user_province_get").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("user_district_get").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập Tỉnh thành!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("user_district_get").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (afstore == "block") {
        if (CheckBlank(document.getElementById("idcard_regis").value)) {
            alert("Bạn chưa nhập số chứng minh nhân dân !");
            document.getElementById("idcard_regis").focus();
            return false
        } else {
            if (!IsNumber(document.getElementById("idcard_regis").value)) {
                alert("Số chứng minh nhân dân chỉ được phép nhập số !");
                document.getElementById("idcard_regis").focus();
                return false;
            }
        }
        if (CheckBlank(document.getElementById("taxcode_regis").value)) {
            alert("Bạn chưa nhập mã số thuế !");
            document.getElementById("idcard_regis").focus();
            return false
        } else {
            if (!IsNumber(document.getElementById("taxcode_regis").value)) {
                alert("Mã số thuế chỉ được phép nhập số !");
                document.getElementById("taxcode_regis").focus();
                return false;
            }
        }
    }
    // if (CheckBlank(document.getElementById("captcha_regis").value)) {
    //     alert("Bạn chưa nhập mã xác nhận!");
    //     document.getElementById("captcha_regis").focus();
    //     return false
    // }
    if ($('#result').hasClass('short') || $('#result').hasClass('weak')) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Mật khẩu của bạn không bảo mật! Vui lòng chọn mật khẩu bảo mật hơn.',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("password_regis").focus();
                    return false;
                }
            }
        });
        return false
    }
    document.frmRegister.submit();
}
function CheckInput_Contact() {
    if (CheckBlank(document.getElementById("name_contact").value)) {
        alert("Bạn chưa nhập họ tên!");
        document.getElementById("name_contact").focus();
        return false
    }
    if (CheckBlank(document.getElementById("email_contact").value)) {
        alert("Bạn chưa nhập email!");
        document.getElementById("email_contact").focus();
        return false
    }
    if (!CheckEmail(document.getElementById("email_contact").value)) {
        alert("Email bạn nhập không hợp lệ!");
        document.getElementById("email_contact").focus();
        return false
    }
    if (CheckBlank(document.getElementById("address_contact").value)) {
        alert("Bạn chưa nhập địa chỉ!");
        document.getElementById("address_contact").focus();
        return false
    }
    if (CheckBlank(document.getElementById("phone_contact").value)) {
        alert("Bạn chưa nhập điện thoại!");
        document.getElementById("phone_contact").focus();
        return false
    }
    if (CheckBlank(document.getElementById("title_contact").value)) {
        alert("Bạn chưa nhập tiêu đề!");
        document.getElementById("title_contact").focus();
        return false
    }
    if (CheckBlank(document.getElementById("content_contact").value)) {
        alert("Bạn chưa nhập nội dung!");
        document.getElementById("content_contact").focus();
        return false
    }
    if (CheckBlank(document.getElementById("captcha_contact").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập mã xác nhận!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("captcha_contact").focus();
                    return false;
                }
            }
        });
        return false;
    }

    if( $('#captcha').length == 1  && $('.inputcaptcha_form').length > 0)
    {
        if($('.inputcaptcha_form').val() != $('#captcha').val())
        {
            $.jAlert({
                'title': 'Nhập sai',
                'content': 'Bạn nhập mã xác nhận chưa đúng!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        jQuery('.inputcaptcha_form').focus();   
                        return false;
                    }
                }
            });
            return false;
        }
    }

    document.frmContact.submit()
}
function CheckInput_Login() {
    jQuery.noConflict();
    if (CheckBlank(jQuery("#UsernameLoginModule").val())) {
        alert("Bạn chưa nhập tài khoản!");
        jQuery("#UsernameLoginModule").focus();
        return false
    }
    if (!CheckCharacter(jQuery("#UsernameLoginModule").val())) {
        alert("Tài khoản bạn nhập không hợp lệ!\nChỉ chấp nhận các ký số 0-9\nChấp nhận các ký tự a-z\nChấp nhận các ký tự - _");
        jQuery("#UsernameLoginModule").focus();
        return false
    }
    if (CheckBlank(jQuery("#PasswordLoginModule").val())) {
        alert("Bạn chưa nhập mật khẩu!");
        jQuery("#PasswordLoginModule").focus();
        return false
    }
    jQuery("#frmLogin").submit()
}

function CheckInput_Login_Page() {
    jQuery.noConflict();    
    if (CheckBlank(jQuery("#frmLoginPage #UsernameLogin").val())) {
        alert("Bạn chưa nhập tài khoản!");
        jQuery("#frmLoginPage #UsernameLogin").val("");
        jQuery("#frmLoginPage #UsernameLogin").focus();
        return false
    }
    if (CheckBlank(jQuery("#frmLoginPage #PasswordLogin").val())) {
        alert("Bạn chưa nhập mật khẩu!");
        jQuery("#frmLoginPage #PasswordLogin").focus();
        return false
    }
    jQuery("#frmLoginPage").submit()
}

function CheckInput_Login_Form() {
    jQuery.noConflict();
    if (CheckBlank(jQuery("#frmLogin #UsernameLogin").val())) {
        alert("Bạn chưa nhập tài khoản!");
        jQuery("#frmLogin #UsernameLogin").val("");
        jQuery("#frmLogin #UsernameLogin").focus();
        return false
    }
    if (!CheckCharacter(jQuery("#frmLogin #UsernameLogin").val())) {
        alert("Tài khoản bạn nhập không hợp lệ!\nChỉ chấp nhận các ký số 0-9\nChấp nhận các ký tự a-z\nChấp nhận các ký tự - _");
        jQuery("#frmLogin #UsernameLogin").focus();
        return false
    }
    if (CheckBlank(jQuery("#frmLogin #PasswordLogin").val())) {
        alert("Bạn chưa nhập mật khẩu!");
        jQuery("#frmLogin #PasswordLogin").focus();
        return false
    }
    jQuery("#frmLogin").submit()
}
function CheckInput_Forgot() {
    if (CheckBlank(document.getElementById("email_forgot").value)) {
        alert("Bạn chưa nhập email!");
        document.getElementById("email_forgot").focus();
        return false
    }
    if (!CheckEmail(document.getElementById("email_forgot").value)) {
        alert("Email bạn nhập không hợp lệ!");
        document.getElementById("email_forgot").focus();
        return false
    }
    if (CheckBlank(document.getElementById("captcha_forgot").value)) {
        alert("Bạn chưa nhập mã xác nhận!");
        document.getElementById("captcha_forgot").focus();
        return false
    } else {
        var str = document.getElementById("captcha_forgot").value.toUpperCase();
        if (str != document.getElementById("captcha").value) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Mã xác nhận bạn nhập không đúng!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("captcha_forgot").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    jQuery("#isPostValidCaptcha").val(1);
    document.frmForgotPassword.submit()
}

jQuery('#frmForgotPassword').submit(function( event ) {
    if (CheckBlank(document.getElementById("email_forgot").value)) {
        alert("Bạn chưa nhập email!");
        document.getElementById("email_forgot").focus();
        event.preventDefault();
    }
    if (!CheckEmail(document.getElementById("email_forgot").value)) {
        alert("Email bạn nhập không hợp lệ!");
        document.getElementById("email_forgot").focus();
        event.preventDefault();
    }
    if (CheckBlank(document.getElementById("captcha_forgot").value)) {
        alert("Bạn chưa nhập mã xác nhận!");
        document.getElementById("captcha_forgot").focus();
        event.preventDefault();
    } else {
        var str = document.getElementById("captcha_forgot").value.toUpperCase();
        if (str != document.getElementById("captcha").value) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Mã xác nhận bạn nhập không đúng!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("captcha_forgot").focus();
                        event.preventDefault();
                    }
                }
            });
            event.preventDefault();
        }
    }
    jQuery("#isPostValidCaptcha").val(1);
});

jQuery('#_frmForgotPassword').submit(function( event ) {
    let option = $('input[name="option"]:checked').val();
    if(option == 0){
        if (CheckBlank(document.getElementById("email_forgot").value)) {
            alert("Bạn chưa nhập email!");
            document.getElementById("email_forgot").focus();
            event.preventDefault();
            return false;
        }        
        if (!CheckEmail(document.getElementById("email_forgot").value)) {
            alert("Email bạn nhập không hợp lệ!");
            document.getElementById("email_forgot").focus();
            event.preventDefault();
            return false;
        }
    }
    if(option == 1){
        if (CheckBlank(document.getElementById("phone_num").value)) {
            alert("Bạn chưa nhập số điện thoại!");
            document.getElementById("phone_num").focus();
            event.preventDefault();
            return false;
        }
        let a = CheckPhone(document.getElementById("phone_num").value);
        // alert("valid", a);
        if (!CheckPhone(document.getElementById("phone_num").value)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888 hoặc có mã nước phía trước VD: +849098888888',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        document.getElementById("phone_num").focus();
                        document.getElementById("phone_num").value = '';
                        event.preventDefault();
                    }
                }
            });
        }
    }
    if (CheckBlank(document.getElementById("captcha_forgot").value)) {
        alert("Bạn chưa nhập mã xác nhận!");
        document.getElementById("captcha_forgot").focus();
        event.preventDefault();
        return false;
    } else {
        var str = document.getElementById("captcha_forgot").value.toUpperCase();
        if (str != document.getElementById("captcha").value) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Mã xác nhận bạn nhập không đúng!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("captcha_forgot").focus();
                        event.preventDefault();
                    }
                }
            });
            event.preventDefault();
        }
    }
    jQuery("#isPostValidCaptcha").val(1);
});

function CheckInput_SearchPro(e) {
    if (!CheckBlank(document.getElementById("cost_search1").value) || !CheckBlank(document.getElementById("cost_search2").value)) {
        if (CheckBlank(document.getElementById("cost_search1").value)) {
            alert("Bạn chưa nhập giá bắt đầu của sản phẩm!");
            document.getElementById("cost_search1").focus();
            return false
        }
        if (!IsNumber(document.getElementById("cost_search1").value)) {
            alert("Giá bắt đầu bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
            document.getElementById("cost_search1").focus();
            return false
        }
        if (document.getElementById("cost_search1").value == "0") {
            alert("Giá bán không được bằng 0!");
            document.getElementById("cost_search1").focus();
            return false
        }
        if (CheckBlank(document.getElementById("cost_search2").value)) {
            alert("Bạn chưa nhập giá kết thúc của sản phẩm!");
            document.getElementById("cost_search2").focus();
            return false
        }
        if (!IsNumber(document.getElementById("cost_search2").value)) {
            alert("Giá kết thúc bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
            document.getElementById("cost_search2").focus();
            return false
        }
        if (document.getElementById("cost_search2").value == "0") {
            alert("Giá bán không được bằng 0!");
            document.getElementById("cost_search2").focus();
            return false
        }
        var t = document.getElementById("cost_search1").value * 1;
        var n = document.getElementById("cost_search2").value * 1;
        if (t > n) {
            alert("Giá kết thúc phải lớn hơn hoặc bằng giá bắt đầu!\nNếu bạn muốn tìm chính xác giá, bạn vui lòng nhập giá bắt đầu bằng với giá kết thúc.");
            document.getElementById("cost_search2").focus();
            return false
        }
    }
    if (document.getElementById("beginday_search1").value != 0 && document.getElementById("beginmonth_search1").value != 0 && document.getElementById("beginyear_search1").value != 0 || document.getElementById("beginday_search2").value != 0 && document.getElementById("beginmonth_search2").value != 0 && document.getElementById("beginyear_search2").value != 0) {
        if (document.getElementById("beginday_search1").value == 0 || document.getElementById("beginmonth_search1").value == 0 || document.getElementById("beginyear_search1").value == 0) {
            alert("Bạn chưa chọn ngày bắt đầu!");
            return false
        }
        if (document.getElementById("beginday_search2").value == 0 || document.getElementById("beginmonth_search2").value == 0 || document.getElementById("beginyear_search2").value == 0) {
            alert("Bạn chưa chọn ngày kết thúc!");
            return false
        }
        if (CheckDate(document.getElementById("beginday_search1").value, document.getElementById("beginmonth_search1").value, document.getElementById("beginyear_search1").value) || CheckDate(document.getElementById("beginday_search2").value, document.getElementById("beginmonth_search2").value, document.getElementById("beginyear_search2").value)) {
            alert("Ngày đăng không hợp lệ!\nNgày đăng phải nhỏ hơn hoặc bằng ngày hiện tại.");
            return false
        }
        if (!CompareDate(document.getElementById("beginday_search1").value, document.getElementById("beginmonth_search1").value, document.getElementById("beginyear_search1").value, document.getElementById("beginday_search2").value, document.getElementById("beginmonth_search2").value, document.getElementById("beginyear_search2").value)) {
            alert("Ngày kết thúc phải lớn hơn hoặc bằng với ngày bắt đâu!\nNếu bạn muốn tìm chính xác ngày đăng, bạn vui lòng chọn ngày bắt đầu bằng với ngày kết thúc.");
            return false
        }
    }
    if (CheckBlank(document.getElementById("name_search").value) && CheckBlank(document.getElementById("cost_search1").value) && document.getElementById("saleoff_search").checked == false && document.getElementById("province_search").value == "0" && document.getElementById("category_search").value == "0" && (document.getElementById("beginday_search1").value == "0" || document.getElementById("beginmonth_search1").value == "0" || document.getElementById("beginyear_search1").value == "0")) {
        alert("Bạn vui lòng chọn ít nhất một tùy chọn tìm kiềm!");
        return false
    }
    ActionSearch(e, 1)
}
function CheckInput_SearchAds(e) {
    if (!CheckBlank(document.getElementById("view_search1").value) || !CheckBlank(document.getElementById("view_search2").value)) {
        if (CheckBlank(document.getElementById("view_search1").value)) {
            alert("Bạn chưa nhập lượt xem bắt đầu!");
            document.getElementById("view_search1").focus();
            return false
        }
        if (!IsNumber(document.getElementById("view_search1").value)) {
            alert("Lượt xem bắt đầu bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
            document.getElementById("view_search1").focus();
            return false
        }
        if (CheckBlank(document.getElementById("view_search2").value)) {
            alert("Bạn chưa nhập lượt xem kết thúc!");
            document.getElementById("view_search2").focus();
            return false
        }
        if (!IsNumber(document.getElementById("view_search2").value)) {
            alert("Lượt xem kết thúc bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
            document.getElementById("view_search2").focus();
            return false
        }
        var t = document.getElementById("view_search1").value * 1;
        var n = document.getElementById("view_search2").value * 1;
        if (t > n) {
            alert("Lượt xem kết thúc phải lớn hơn hoặc bằng lượt xem bắt đầu!\nNếu bạn muốn tìm chính xác lượt xem, bạn vui lòng nhập lượt xem bắt đầu bằng với lượt xem kết thúc.");
            document.getElementById("view_search2").focus();
            return false
        }
    }
    if (document.getElementById("beginday_search1").value != 0 && document.getElementById("beginmonth_search1").value != 0 && document.getElementById("beginyear_search1").value != 0 || document.getElementById("beginday_search2").value != 0 && document.getElementById("beginmonth_search2").value != 0 && document.getElementById("beginyear_search2").value != 0) {
        if (document.getElementById("beginday_search1").value == 0 || document.getElementById("beginmonth_search1").value == 0 || document.getElementById("beginyear_search1").value == 0) {
            alert("Bạn chưa chọn ngày bắt đầu!");
            return false
        }
        if (document.getElementById("beginday_search2").value == 0 || document.getElementById("beginmonth_search2").value == 0 || document.getElementById("beginyear_search2").value == 0) {
            alert("Bạn chưa chọn ngày kết thúc!");
            return false
        }
        if (CheckDate(document.getElementById("beginday_search1").value, document.getElementById("beginmonth_search1").value, document.getElementById("beginyear_search1").value) || CheckDate(document.getElementById("beginday_search2").value, document.getElementById("beginmonth_search2").value, document.getElementById("beginyear_search2").value)) {
            alert("Ngày đăng không hợp lệ!\nNgày đăng phải nhỏ hơn hoặc bằng ngày hiện tại.");
            return false
        }
        if (!CompareDate(document.getElementById("beginday_search1").value, document.getElementById("beginmonth_search1").value, document.getElementById("beginyear_search1").value, document.getElementById("beginday_search2").value, document.getElementById("beginmonth_search2").value, document.getElementById("beginyear_search2").value)) {
            alert("Ngày kết thúc phải lớn hơn hoặc bằng với ngày bắt đâu!\nNếu bạn muốn tìm chính xác ngày đăng, bạn vui lòng chọn ngày bắt đầu bằng với ngày kết thúc.");
            return false
        }
    }
    if (CheckBlank(document.getElementById("title_search").value) && CheckBlank(document.getElementById("view_search1").value) && document.getElementById("province_search").value == "0" && document.getElementById("category_search").value == "0" && (document.getElementById("beginday_search1").value == "0" || document.getElementById("beginmonth_search1").value == "0" || document.getElementById("beginyear_search1").value == "0")) {
        alert("Bạn vui lòng chọn ít nhất một tùy chọn tìm kiềm!");
        return false
    }
    ActionSearch(e, 2)
}
function CheckInput_SearchJob(e) {
    if (!CheckBlank(document.getElementById("salary_search").value)) {
        if (!IsNumber(document.getElementById("salary_search").value)) {
            alert("Mức lương bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
            document.getElementById("salary_search").focus();
            return false
        }
        if (document.getElementById("salary_search").value == "0") {
            alert("Mức lương không được bằng 0!");
            document.getElementById("salary_search").focus();
            return false
        }
    }
    if (document.getElementById("beginday_search1").value != 0 && document.getElementById("beginmonth_search1").value != 0 && document.getElementById("beginyear_search1").value != 0 || document.getElementById("beginday_search2").value != 0 && document.getElementById("beginmonth_search2").value != 0 && document.getElementById("beginyear_search2").value != 0) {
        if (document.getElementById("beginday_search1").value == 0 || document.getElementById("beginmonth_search1").value == 0 || document.getElementById("beginyear_search1").value == 0) {
            alert("Bạn chưa chọn ngày bắt đầu!");
            return false
        }
        if (document.getElementById("beginday_search2").value == 0 || document.getElementById("beginmonth_search2").value == 0 || document.getElementById("beginyear_search2").value == 0) {
            alert("Bạn chưa chọn ngày kết thúc!");
            return false
        }
        if (CheckDate(document.getElementById("beginday_search1").value, document.getElementById("beginmonth_search1").value, document.getElementById("beginyear_search1").value) || CheckDate(document.getElementById("beginday_search2").value, document.getElementById("beginmonth_search2").value, document.getElementById("beginyear_search2").value)) {
            alert("Ngày đăng không hợp lệ!\nNgày đăng phải nhỏ hơn hoặc bằng ngày hiện tại.");
            return false
        }
        if (!CompareDate(document.getElementById("beginday_search1").value, document.getElementById("beginmonth_search1").value, document.getElementById("beginyear_search1").value, document.getElementById("beginday_search2").value, document.getElementById("beginmonth_search2").value, document.getElementById("beginyear_search2").value)) {
            alert("Ngày kết thúc phải lớn hơn hoặc bằng với ngày bắt đâu!\nNếu bạn muốn tìm chính xác ngày đăng, bạn vui lòng chọn ngày bắt đầu bằng với ngày kết thúc.");
            return false
        }
    }
    if (CheckBlank(document.getElementById("title_search").value) && CheckBlank(document.getElementById("salary_search").value) && document.getElementById("province_search").value == "0" && document.getElementById("field_search").value == "0" && (document.getElementById("beginday_search1").value == "0" || document.getElementById("beginmonth_search1").value == "0" || document.getElementById("beginyear_search1").value == "0")) {
        alert("Bạn vui lòng chọn ít nhất một tùy chọn tìm kiềm!");
        return false
    }
    ActionSearch(e, 3)
}
function CheckInput_SearchEmploy(e) {
    if (!CheckBlank(document.getElementById("salary_search").value)) {
        if (!IsNumber(document.getElementById("salary_search").value)) {
            alert("Mức lương bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
            document.getElementById("salary_search").focus();
            return false
        }
        if (document.getElementById("salary_search").value == "0") {
            alert("Mức lương không được bằng 0!");
            document.getElementById("salary_search").focus();
            return false
        }
    }
    if (document.getElementById("beginday_search1").value != 0 && document.getElementById("beginmonth_search1").value != 0 && document.getElementById("beginyear_search1").value != 0 || document.getElementById("beginday_search2").value != 0 && document.getElementById("beginmonth_search2").value != 0 && document.getElementById("beginyear_search2").value != 0) {
        if (document.getElementById("beginday_search1").value == 0 || document.getElementById("beginmonth_search1").value == 0 || document.getElementById("beginyear_search1").value == 0) {
            alert("Bạn chưa chọn ngày bắt đầu!");
            return false
        }
        if (document.getElementById("beginday_search2").value == 0 || document.getElementById("beginmonth_search2").value == 0 || document.getElementById("beginyear_search2").value == 0) {
            alert("Bạn chưa chọn ngày kết thúc!");
            return false
        }
        if (CheckDate(document.getElementById("beginday_search1").value, document.getElementById("beginmonth_search1").value, document.getElementById("beginyear_search1").value) || CheckDate(document.getElementById("beginday_search2").value, document.getElementById("beginmonth_search2").value, document.getElementById("beginyear_search2").value)) {
            alert("Ngày đăng không hợp lệ!\nNgày đăng phải nhỏ hơn hoặc bằng ngày hiện tại.");
            return false
        }
        if (!CompareDate(document.getElementById("beginday_search1").value, document.getElementById("beginmonth_search1").value, document.getElementById("beginyear_search1").value, document.getElementById("beginday_search2").value, document.getElementById("beginmonth_search2").value, document.getElementById("beginyear_search2").value)) {
            alert("Ngày kết thúc phải lớn hơn hoặc bằng với ngày bắt đâu!\nNếu bạn muốn tìm chính xác ngày đăng, bạn vui lòng chọn ngày bắt đầu bằng với ngày kết thúc.");
            return false
        }
    }
    if (CheckBlank(document.getElementById("title_search").value) && CheckBlank(document.getElementById("salary_search").value) && document.getElementById("province_search").value == "0" && document.getElementById("field_search").value == "0" && (document.getElementById("beginday_search1").value == "0" || document.getElementById("beginmonth_search1").value == "0" || document.getElementById("beginyear_search1").value == "0")) {
        alert("Bạn vui lòng chọn ít nhất một tùy chọn tìm kiềm!");
        return false
    }
    ActionSearch(e, 4)
}
function CheckInput_SearchShop(e) {
    if (document.getElementById("beginday_search1").value != 0 && document.getElementById("beginmonth_search1").value != 0 && document.getElementById("beginyear_search1").value != 0 || document.getElementById("beginday_search2").value != 0 && document.getElementById("beginmonth_search2").value != 0 && document.getElementById("beginyear_search2").value != 0) {
        if (document.getElementById("beginday_search1").value == 0 || document.getElementById("beginmonth_search1").value == 0 || document.getElementById("beginyear_search1").value == 0) {
            alert("Bạn chưa chọn ngày bắt đầu!");
            return false
        }
        if (document.getElementById("beginday_search2").value == 0 || document.getElementById("beginmonth_search2").value == 0 || document.getElementById("beginyear_search2").value == 0) {
            alert("Bạn chưa chọn ngày kết thúc!");
            return false
        }
        if (CheckDate(document.getElementById("beginday_search1").value, document.getElementById("beginmonth_search1").value, document.getElementById("beginyear_search1").value) || CheckDate(document.getElementById("beginday_search2").value, document.getElementById("beginmonth_search2").value, document.getElementById("beginyear_search2").value)) {
            alert("Ngày đăng ký không hợp lệ!\nNgày đăng ký phải nhỏ hơn hoặc bằng ngày hiện tại.");
            return false
        }
        if (!CompareDate(document.getElementById("beginday_search1").value, document.getElementById("beginmonth_search1").value, document.getElementById("beginyear_search1").value, document.getElementById("beginday_search2").value, document.getElementById("beginmonth_search2").value, document.getElementById("beginyear_search2").value)) {
            alert("Ngày kết thúc phải lớn hơn hoặc bằng với ngày bắt đâu!\nNếu bạn muốn tìm chính xác ngày đăng ký, bạn vui lòng chọn ngày bắt đầu bằng với ngày kết thúc.");
            return false
        }
    }
    if (CheckBlank(document.getElementById("name_search").value) && CheckBlank(document.getElementById("address_search").value) && document.getElementById("saleoff_search").checked == false && document.getElementById("province_search").value == "0" && document.getElementById("category_search").value == "0" && (document.getElementById("beginday_search1").value == "0" || document.getElementById("beginmonth_search1").value == "0" || document.getElementById("beginyear_search1").value == "0")) {
        alert("Bạn vui lòng chọn ít nhất một tùy chọn tìm kiềm!");
        return false
    }
    ActionSearch(e, 5)
}
function CheckInput_EditAccount() {

    if($('#avatar').length != 0){

        if (document.getElementById("avatar").value != "") {
            var e = document.getElementById("avatar").value;
            ext = e.split(".")[1];
            var t = "";
            switch (ext) {
                case"png":
                    t = 1;
                    break;
                case"gif":
                    t = 1;
                    break;
                case"jpg":
                    t = 1;
                    break;
                case"PNG":
                    t = 1;
                    break;
                case"GIF":
                    t = 1;
                    break;
                case"JPG":
                    t = 1;
                    break;
                default:
                    t = 0
            }
            if (t == 0) {
                alert("Bạn nhập không đúng định dạng file");
                return false
            }
        }
        if (jQuery("#avatar")[0].files[0]) {
            if (jQuery("#avatar")[0].files[0].size > 512 * 1024) {
                errorAlert("Dung lượng upload tối đa 512 Kb", "Thông báo");
                return false
            }
        }

    }

    if (!CheckEmail(document.getElementById("email_account").value)) {
        alert("Email bạn nhập không hợp lê!");
        document.getElementById("email_account").focus();
        return false
    }
    if (CheckBlank(document.getElementById("fullname_account").value)) {
        alert("Bạn chưa nhập họ tên!");
        document.getElementById("fullname_account").focus();
        return false
    }
    if (CheckBlank(document.getElementById("address_account").value)) {
        alert("Bạn chưa nhập địa chỉ!");
        document.getElementById("address_account").focus();
        return false
    }
    if (CheckBlank(document.getElementById("idcard_regis").value)) {
        alert("Bạn chưa nhập chứng minh nhân dân!");
        document.getElementById("idcard_regis").focus();
        return false
    } else {
        var test = /^[0-9]+$/.test(document.getElementById("idcard_regis").value);
        if (test == false) {
            alert("Bạn chỉ được phép nhập số trong Chứng minh nhân dân!");
            document.getElementById("idcard_regis").focus();
            return false;
        }
    }
    if (CheckBlank(document.getElementById("mobile_account").value)) {
        if (!CheckPhone(document.getElementById("mobile_account").value)) {
            alert("Số điện thoại bạn nhập không hợp lệ!");
            document.getElementById("mobile_account").focus();
            return false
        }
    } else {
        var test = /^[0-9]+$/.test(document.getElementById("mobile_account").value);
        if (test == false) {
            alert("Bạn chỉ được phép nhập số!");
            document.getElementById("mobile_account").focus();
            return false;
        }
    }
    
    var messages = document.getElementById("messages_regis").value;
    var aaa      = 'https://www.facebook.com/messages/t/';
    if ( messages != '' && messages.search(aaa) != 0 )  {
        alert("Liên kết facebook messenger bạn nhập vào chưa đúng cú pháp");
        document.getElementById("messages_regis").focus();
        return false
    }
    
    document.frmEditAccount.submit()
}
function CheckInput_ChangePassword() {
    if (document.getElementById("captcha_changepass").value != document.getElementById("hidden_captcha").value) {
        alert("Vui lòng điền chính xác mã xác nhận !");
        document.getElementById("captcha_changepass").focus();
        return false
    }
    if (CheckBlank(document.getElementById("oldpassword_changepass").value)) {
        alert("Bạn chưa nhập mật khẩu củ!");
        document.getElementById("oldpassword_changepass").focus();
        return false
    }
    if (CheckBlank(document.getElementById("password_changepass").value)) {
        alert("Bạn chưa nhập mật khẩu mới!");
        document.getElementById("password_changepass").focus();
        return false
    }
    var e = document.getElementById("password_changepass").value;
    if (e.length < 6) {
        alert("Mật khẩu mới phải có ít nhất 6 ký tự!");
        document.getElementById("password_changepass").focus();
        return false
    }
    if (CheckBlank(document.getElementById("captcha_changepass").value)) {
        alert("Bạn chưa nhập mã xác nhận!");
        document.getElementById("captcha_changepass").focus();
        return false
    }
    document.frmChangePassword.submit()
}
function CheckInput_ContactAccount() {
    if (CheckBlank(document.getElementById("title_contact").value)) {
        alert("Bạn chưa nhập tiêu đề!");
        document.getElementById("title_contact").focus();
        return false
    }
    if (document.getElementById("con_user_recieve").value == -1) {
        alert("Bạn chưa chọn gửi đến!");
        document.getElementById("con_user_recieve").focus();
        return false
    }
    if (document.getElementById("con_user_recieve").value == 1) {
        if (CheckBlank(document.getElementById("username").value)) {
            alert("Bạn chưa nhập tên người nhận thư!");
            document.getElementById("username").focus();
            return false
        }
    }
    if (CheckBlank(document.getElementById("txtContent").value)) {
        alert("Bạn chưa nhập nội dung!");
        document.getElementById("txtContent").focus();
        return false
    }
    document.frmContactAccount.submit()
}
function zoom_img() {
    $("#images1").fancybox({openEffect: 'none', closeEffect: 'none'});
}
function CheckInput_TaskAccount() {
    var test_value1 = $("#images1").val();
    var test_value2 = $("#images2").val();
    var test_value3 = $("#images3").val();
    var test_value4 = $("#file1").val();
    var test_value5 = $("#file2").val();
    var test_value6 = $("#file3").val();
    var extension1 = test_value1.split('.').pop().toLowerCase();
    var extension2 = test_value2.split('.').pop().toLowerCase();
    var extension3 = test_value3.split('.').pop().toLowerCase();
    var extension4 = test_value4.split('.').pop().toLowerCase();
    var extension5 = test_value5.split('.').pop().toLowerCase();
    var extension6 = test_value6.split('.').pop().toLowerCase();
    if ((test_value1 != '') && ($.inArray(extension1, ['png', 'gif', 'jpeg', 'jpg']) == -1)) {
        alert("Hình 1 không hợp lệ!");
        return false;
    }
    if ((test_value2 != '') && ($.inArray(extension2, ['png', 'gif', 'jpeg', 'jpg']) == -1)) {
        alert("Hình 2 không hợp lệ!");
        return false;
    }
    if ((test_value3 != '') && ($.inArray(extension3, ['png', 'gif', 'jpeg', 'jpg']) == -1)) {
        alert("Hình 3 không hợp lệ!");
        return false;
    }
    if ((test_value4 != '') && ($.inArray(extension4, ['doc', 'docx']) == -1)) {
        alert("File 1 (Word) không hợp lệ!");
        return false;
    }
    if ((test_value5 != '') && ($.inArray(extension5, ['pdf']) == -1)) {
        alert("File 2 (Pdf) không hợp lệ!");
        return false;
    }
    if ((test_value6 != '') && ($.inArray(extension6, ['xls', 'xlsx']) == -1)) {
        alert("File 3 (Excel) không hợp lệ!");
        return false;
    }
    document.frmTaskAccount.submit()
}
function CheckInput_TaskComment(baseurl, idtask) {
    $('.fa-times-circle').hide();
    $('.fa-spinner').show();
    jQuery.ajax({
        type: "POST",
        url: baseurl + "home/account/treetask",
        data: {idtask: idtask},
        success: function (data) {
            if (data == "1") {
                $('#last-row').css('display', 'none');
                $('.fa-spinner').hide();
                $('#status_task').html('<span class="text-warning"><i class="fa fa-refresh"></i> Cấp trên đang xem...</span>');
            } else {
                warningAlert('Thông báo', 'Có lỗi xảy ra, vui lòng thử lại!');
            }
        },
        error: function () {
        }
    });
}
function TaskStatus(baseurl, idtask) {
    $('.fa-times-circle').hide();
    $('.fa-spinner').show();
    jQuery.ajax({
        type: "POST", url: baseurl + "home/account/mytask", data: {idtask: idtask}, success: function (data) {
            if (data == "1") {
                $('#last-row').css('display', 'none');
                $('.fa-spinner').hide();
                $('#status_task').html('<span class="text-warning"><i class="fa fa-refresh"></i> Cấp trên đang xem...</span>');
            } else {
                warningAlert('Thông báo', 'Có lỗi xảy ra, vui lòng thử lại!');
            }
        }, error: function () {
        }
    });
}

function Change_daytask() {
    var changging = document.getElementById("daytask").value;
    window.location.href = 'mytask/day/' + changging;
}

function checkSponsor(value, baseurl) {
    if (value != '') {
        jQuery.ajax({
            type: "POST",
            url: baseurl + "register/check/emailusername",
            data: "email=" + value,
            success: function (data) {
                if (data == "1") {
                } else {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Người giới thiệu này không tồn tại trong hệ thống, vui lòng nhập lại!',
                        'theme': 'default',
                        'btns': {
                            'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                e.preventDefault();
                                return false;
                            }
                        }
                    });
                    jQuery('#sponsor').val('');
                }
            },
            error: function () {
            }
        });
    } else {
    }
}

function checkEmailexit(value, baseurl) {
    if (value != '') {
        jQuery.ajax({
            type: "POST",
            url: baseurl + "register/check/emailusername",
            data: "email=" + value,
            success: function (data) {
                if (data == "1") {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Email hoặc số điện thoại này đã có người sử dụng, vui lòng nhập kiểm tra lại và nhập số khác!',
                        'theme': 'default',
                        'btns': {
                            'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                e.preventDefault();
                                jQuery('#email_regis').focus();
                                jQuery('#email_regis').val('');
                                return false;
                            }
                        }
                    });
                }
            },
            error: function () {
            }
        });
    }
}

function _forgot_pass(value, baseurl, option , el){
    if(option === 0){
        checkEmailfoget(value, baseurl);
    }
    if(option === 1){
        checkMobile(value, baseurl, el);
    }
}

function checkEmailfoget(value, baseurl) {
    if (value != '') {
        jQuery.ajax({
            type: "POST",
            url: baseurl + "home/forgot/exist_email",
            data: "email=" + value,
            success: function (data) {
                if (data == "1") {
                } else {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Email của bạn chưa được đăng ký.',
                        'theme': 'default',
                        'btns': {
                            'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                e.preventDefault();
                                jQuery('#email_forgot').focus();
                                jQuery('#email_forgot').val('');
                                return false;
                            }
                        }
                    });
                }
            },
            error: function () {
            }
        });
    }
}
function checkMobile(value, baseurl, el) {
    if (!CheckBlank($('#'+el).val())) {
        if (!CheckPhone($('#'+el).val())) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888 hoặc có mã nước phía trước VD: +849098888888',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        $('#'+el).focus();
                        $('#'+el).val('');
                        return false;
                    }
                }
            });
            return false;
        } 
    }
}

function checkUsername(value, baseurl) {
    if (value != '') {
        jQuery.ajax({
            type: "POST",
            url: baseurl + "register/check/username",
            data: "username=" + value,
            success: function (data) {
                if (data == "1") {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Tên đăng nhập này đã có người sử dụng, vui lòng nhập kiểm tra lại và nhập số khác!',
                        'theme': 'default',
                        'btns': {
                            'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                e.preventDefault();
                                jQuery('#username_regis').focus();
                                return false;
                            }
                        }
                    });
                    jQuery('#username_regis').val('');
                    return false;
                }
            },
            error: function () {
            }
        });
    }
}

function checkUserIdcard_reg(value, baseurl, url) {
    if (value != '') {
        jQuery.ajax({
            type: "POST",
            url: baseurl + "register/check/useridcard/" + url,
            data: "idcard=" + value,
            success: function (data) {
                if (data == "1") {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Số chứng minh này đã có người sử dụng, vui lòng nhập kiểm tra lại và nhập số khác!',
                        'theme': 'default',
                        'btns': {
                            'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                e.preventDefault();
                                document.getElementById("idcard_regis").focus();
                                jQuery('#idcard_regis').val('');
                                return false;
                            }
                        }
                    });
                    return false;
                }
                if (data == '2') {
                    jQuery('#tax_code_personal').prop('checked', false);
                    jQuery('#tax_code_company').prop('checked', true);
                    jQuery('#taxcode_regis').focus();
                }
            },
            error: function () {
            }
        });
    } else {
    }
}

function checkUserIdcard(value, baseurl, url) {
    if (!IsNumber(document.getElementById("idcard_regis").value)) {
        alert("Số chứng minh nhân dân chỉ được phép nhập số !");
        document.getElementById("idcard_regis").focus();
        return false;
    }
    if (value != '') {
        jQuery.ajax({
            type: "POST",
            url: baseurl + "register/check/useridcard/" + url,
            data: "idcard=" + value,
            success: function (data) {
                if (data == "1") {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Số chứng minh này đã có người sử dụng, vui lòng nhập kiểm tra lại và nhập số khác!',
                        'theme': 'default',
                        'btns': {
                            'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                e.preventDefault();
                                document.getElementById("idcard_regis").focus();
                                jQuery('#idcard_regis').val('');
                                return false;
                            }
                        }
                    });
                    return false;
                }
                if (data == '2') {
                    jQuery('#tax_code_personal').prop('checked', false);
                    jQuery('#tax_code_company').prop('checked', true);
                    jQuery('#taxcode_regis').focus();
                }
            },
            error: function () {
            }
        });
    } else {
    }
}

function checkUserMobile(value, baseurl, url) {
    if (!CheckBlank(document.getElementById("mobile_regis").value)) {
        if (!CheckPhone(document.getElementById("mobile_regis").value)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888 hoặc có mã nước phía trước VD: +849098888888',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("mobile_regis").focus();
                        jQuery('#mobile_regis').val('');
                        return false;
                    }
                }
            });
            return false;
        } else {
            jQuery.ajax({
                type: "POST",
                url: baseurl + "register/check/usermobile/" + url,
                data: "mobile=" + value,
                success: function (data) {
                    if (data == "1") {
                        $.jAlert({
                            'title': 'Thông báo',
                            'content': 'Số điện thoại này đã có người sử dụng, vui lòng nhập kiểm tra lại và nhập số khác!',
                            'theme': 'default',
                            'btns': {
                                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                    e.preventDefault();
                                    jQuery('#mobile_regis').focus();
                                    return false;
                                }
                            }
                        });
                        jQuery('#mobile_regis').val('');
                        return false;
                    }
                },
                error: function () {
                }
            });
        }
    }
}

function checkUserTaxcode_reg(value, baseurl, url) {
    if (value != '') {
        jQuery.ajax({
            type: "POST",
            url: baseurl + "register/check/usertaxcode/" + url,
            data: "taxcode=" + value,
            success: function (data) {
                if (data == "1") {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Mã số thuế này đã có người sử dụng, vui lòng nhập kiểm tra lại khác!',
                        'theme': 'default',
                        'btns': {
                            'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                e.preventDefault();
                                document.getElementById("taxcode_regis").focus();
                                jQuery('#taxcode_regis').val('');
                                return false;
                            }
                        }
                    });
                    return false;
                }
            },
            error: function () {
            }
        });
    } else {
    }
}

function checkUserTaxcode(value, baseurl, url) {
    if (!IsNumber(document.getElementById("taxcode_regis").value)) {
        alert("Mã số thuế chỉ được phép nhập số !");
        document.getElementById("taxcode_regis").focus();
        return false;
    }
    if (value != '') {
        jQuery.ajax({
            type: "POST",
            url: baseurl + "register/check/usertaxcode/" + url,
            data: "taxcode=" + value,
            success: function (data) {
                if (data == "1") {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Mã số thuế này đã có người sử dụng, vui lòng nhập kiểm tra lại khác!',
                        'theme': 'default',
                        'btns': {
                            'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                e.preventDefault();
                                document.getElementById("taxcode_regis").focus();
                                jQuery('#taxcode_regis').val('');
                                return false;
                            }
                        }
                    });
                    return false;
                }
            },
            error: function () {
            }
        });
    } else {
    }
}

function checkActiveCode(e, t) {
    jQuery.post(t + "ajax", {code: e}, function (e) {
        if (e == "0") {
            alert("Không tồn tại Mã kích hoạt này!");
            document.getElementById("active_code").value = "";
            return false
        }
        if (e == "1") {
            alert("Mã kích hoạt họp lệ!");
            return false
        }
        if (e == "2") {
            alert("Mã kích hoạt này đã được sử dụng rồi. Vui lòng kiểm tra lại!");
            jQuery(".member_type").attr("checked", false);
            jQuery("#type_value").val("");
            document.getElementById("active_code").value = "";
            return false
        }
    })
}

function CheckInput_newsAdd() {    
    if (CheckBlank(document.getElementById("title_content").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập tiêu đề!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("title_content").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("description").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập mô tả ngắn!',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("description").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("keywords").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập mô từ khóa!',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("keywords").focus();
                    return false;
                }
            }
        });
        return false;
    }
    var editorContent = tinyMCE.get('txtContent').getContent();
    if (editorContent == '') {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập nội dung!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("txtContent").focus();
                    return false;
                }
            }
        });
        return false;
    }
    successAlert('Bạn đã đăng tin thành công!');
    document.frmAddNews.submit();
}

function CheckInput_newsEdit() {
    if (CheckBlank(document.getElementById("not_pro_cat_id").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa chọn danh mục tin!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("not_pro_cat_id").focus();
                    return false;
                }
            }
        });
        return false;
    }
    var style = jQuery("#image").css('display');
    if (document.getElementById("image").value == "" && style != "none") {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập hình đại diện!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("image").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("title_content").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập tiêu đề!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("title_content").focus();
                    return false;
                }
            }
        });
        return false;
    }
    var editorContent = tinyMCE.get('txtContent').getContent();
    if (editorContent == '') {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập nội dung!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("txtContent").focus();
                    return false;
                }
            }
        });
        return false;
    }
    successAlert('Bạn đã cập nhật tin thành công!');
    document.frmEditNews.submit()
}

function CheckInput_EditAds() {
    if (document.getElementById("image_ads").value != "") {
        var e = document.getElementById("image_ads").value;
        ext = e.split(".")[1];
        var t = "";
        switch (ext) {
            case"png":
                t = 1;
                break;
            case"gif":
                t = 1;
                break;
            case"jpg":
                t = 1;
                break;
            case"PNG":
                t = 1;
                break;
            case"GIF":
                t = 1;
                break;
            case"JPG":
                t = 1;
                break;
            case"swf":
                t = 1;
                break;
            case"SWF":
                t = 1;
                break;
            default:
                t = 0
        }
        if (t == 0) {
            alert("Bạn nhập không đúng định dạng file");
            return false
        }
    }
    if (jQuery("#image_ads")[0].files[0]) {
        if (jQuery("#image_ads")[0].files[0].size > 1024 * 1024) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Dung lượng ảnh upload tối đa 1MB',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("image_ads").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (CheckBlank(document.getElementById("title_ads").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập tiêu đề!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("title_ads").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("hd_category_id").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa chọn danh mục !',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("hd_category_id").focus();
                    return false;
                }
            }
        });
        return false;
    }
    var n = tinyMCE.get("txtContent").getContent();
    if (n != "") {
        var r = document.createElement("div");
        r.innerHTML = n;
        var i = r.textContent || r.innerText || "";
        if (i.length < 40) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn nhập chi tiết sản phẩm quá ngắn phải nhập lớn hơn 40 ký tự !", "Yêu cầu nhập hơn 40 ký tự',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("txtContent").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (CheckBlank(n)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập chi tiết rao vặt!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("txtContent").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("fullname_ads").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập người đăng rao vặt!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("fullname_ads").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("address_ads").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập địa chỉ liên hệ!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("address_ads").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (document.getElementById("phone_ads").value != "") {
        if (!CheckPhone(document.getElementById("phone_ads").value)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("phone_ads").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (document.getElementById("mobile_ads").value) {
        if (!CheckBlank(document.getElementById("mobile_ads").value)) {
            if (!CheckPhone(document.getElementById("mobile_ads").value)) {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888',
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("mobile_ads").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
        }
    }
    if (CheckBlank(document.getElementById("email_ads").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập email!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("email_ads").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (!CheckEmail(document.getElementById("email_ads").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Email bạn nhập không hợp lệ!',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("email_ads").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("captcha_ads").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập mã xác nhận!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("captcha_ads").focus();
                    return false;
                }
            }
        });
        return false;
    } else {
        if (document.getElementById("captcha_ads").value != document.getElementById("captcha").value) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Mã xác nhận bạn nhập không đúng!',
                'theme': 'red',
                'btns': {
                    'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("captcha_ads").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    jQuery("#isEditAds").val(1);
    document.frmEditAds.submit()
}

function CheckInput_EditJob() {
    if (CheckBlank(document.getElementById("title_job").value)) {
        alert("Bạn chưa nhập tiêu đề!");
        document.getElementById("title_job").focus();
        return false
    }
    if (document.getElementById("field_job").value == "0" && CheckBlank(document.getElementById("nganhnghe_dien").value)) {
        alert("Bạn chưa nhập ngành nghề tuyển dụng!");
        document.getElementById("nganhnghe_dien").focus();
        return false
    }
    if (CheckBlank(document.getElementById("position_job").value)) {
        alert("Bạn chưa nhập vị trí tuyển dụng!");
        document.getElementById("position_job").focus();
        return false
    }
    if (document.getElementById("yeu_cau_trinh_Do").value == "0" && CheckBlank(document.getElementById("level_job").value)) {
        alert("Bạn chưa nhập trình độ!");
        document.getElementById("nganhnghe_dien").focus();
        return false
    }
    if (document.getElementById("age1_job").value > document.getElementById("age2_job").value) {
        alert("Bạn chọn tuổi không hợp lệ!\nVí dụ: Tuổi từ 18 đến 25.");
        return false
    }
    if (CheckBlank(document.getElementById("require_job").value)) {
        alert("Bạn chưa nhập yêu cầu công việc!");
        document.getElementById("require_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("salary_job").value)) {
        alert("Bạn chưa nhập mức lương khởi điểm!");
        document.getElementById("salary_job").focus();
        return false
    }
    if (!IsNumber(document.getElementById("salary_job").value)) {
        alert("Mức lương khởi điểm bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
        document.getElementById("salary_job").focus();
        return false
    }
    if (document.getElementById("salary_job").value == "0") {
        alert("Mức lương khởi điểm không được bằng 0!");
        document.getElementById("salary_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("try_job").value)) {
        alert("Bạn chưa nhập thời gian thử việc!");
        document.getElementById("try_job").focus();
        return false
    }
    if (!IsNumber(document.getElementById("try_job").value)) {
        alert("Thời gian thử việc bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
        document.getElementById("try_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("interest_job").value)) {
        alert("Bạn chưa nhập quyền lợi!");
        document.getElementById("interest_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("quantity_job").value)) {
        alert("Bạn chưa nhập số lượng tuyển dụng!");
        document.getElementById("quantity_job").focus();
        return false
    }
    if (!IsNumber(document.getElementById("quantity_job").value)) {
        alert("Số lượng tuyển dụng bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
        document.getElementById("quantity_job").focus();
        return false
    }
    if (document.getElementById("quantity_job").value == "0") {
        alert("Số lượng tuyển dụng không được bằng 0!");
        document.getElementById("quantity_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("record_job").value)) {
        alert("Bạn chưa nhập hồ sơ xin việc!");
        document.getElementById("record_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("txtContent").value)) {
        alert("Bạn chưa nhập chi tiết tin tuyển dụng!");
        document.getElementById("txtContent").focus();
        return false
    }
    if (CheckBlank(document.getElementById("name_job").value)) {
        alert("Bạn chưa nhập tên nhà tuyển dụng!");
        document.getElementById("name_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("address_job").value)) {
        alert("Bạn chưa nhập địa chỉ nhà tuyển dụng!");
        document.getElementById("address_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("phone_job").value)) {
        alert("Bạn chưa nhập số điện thoại nhà tuyển dụng!");
        document.getElementById("phone_job").focus();
        return false
    }
    if (!CheckPhone(document.getElementById("phone_job").value)) {
        alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
        document.getElementById("phone_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("email_job").value)) {
        alert("Bạn chưa nhập email!");
        document.getElementById("email_job").focus();
        return false
    }
    if (!CheckEmail(document.getElementById("email_job").value)) {
        alert("Email bạn nhập không hợp lệ!");
        document.getElementById("email_job").focus();
        return false
    }
    if (!CheckWebsite(document.getElementById("website_job").value)) {
        alert("Địa chỉ website bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, / . : _ -");
        document.getElementById("website_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("namecontact_job").value)) {
        alert("Bạn chưa nhập tên người đại diện!");
        document.getElementById("namecontact_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("addresscontact_job").value)) {
        alert("Bạn chưa nhập địa chỉ liên hệ!");
        document.getElementById("addresscontact_job").focus();
        return false
    }
    if (CheckBlank(document.getElementById("phonecontact_job").value)) {
        alert("Bạn chưa nhập số điện thoại liên hệ!");
        document.getElementById("phonecontact_job").focus();
        return false
    }
    if (!CheckPhone(document.getElementById("phonecontact_job").value)) {
        alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
        document.getElementById("phonecontact_job").focus();
        return false
    }
    if (!CheckBlank(document.getElementById("mobilecontact_job").value)) {
        if (!CheckPhone(document.getElementById("mobilecontact_job").value)) {
            alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
            document.getElementById("mobilecontact_job").focus();
            return false
        }
    }
    if (CheckBlank(document.getElementById("emailcontact_job").value)) {
        alert("Bạn chưa nhập email!");
        document.getElementById("emailcontact_job").focus();
        return false
    }
    if (!CheckEmail(document.getElementById("emailcontact_job").value)) {
        alert("Email bạn nhập không hợp lệ!");
        document.getElementById("emailcontact_job").focus();
        return false
    }
    if (!CheckDate(document.getElementById("endday_job").value, document.getElementById("endmonth_job").value, document.getElementById("endyear_job").value)) {
        alert("Thời gian hết hạn đăng không hợp lệ!\nThời gian hết hạn đăng phải lớn hơn ngày hiện tại.");
        return false
    }
    if (CheckBlank(document.getElementById("captcha_job").value)) {
        alert("Bạn chưa nhập mã xác nhận!");
        document.getElementById("captcha_job").focus();
        return false
    }
    if (document.getElementById("captcha_job").value != document.getElementById("captcha").value) {
        alert("Bạn nhập mã xác nhận không đúng!");
        document.getElementById("captcha_job").focus();
        return false
    }
    jQuery("#isPostProduct").val(1);
    document.frmEditJob.submit()
}

function CheckInput_EditEmploy() {
    if (CheckBlank(document.getElementById("title_employ").value)) {
        alert("Bạn chưa nhập tiêu đề!");
        document.getElementById("title_employ").focus();
        return false
    }
    if (CheckBlank(document.getElementById("position_employ").value)) {
        alert("Bạn chưa nhập vị trí làm việc!");
        document.getElementById("position_employ").focus();
        return false
    }
    if (CheckBlank(document.getElementById("salary_employ").value)) {
        alert("Bạn chưa nhập mức lương mong muốn!");
        document.getElementById("salary_employ").focus();
        return false
    }
    if (!IsNumber(document.getElementById("salary_employ").value)) {
        alert("Mức lương mong muốn bạn nhập không hợp lệ!\nBạn chỉ nhập số từ 0-9.");
        document.getElementById("salary_employ").focus();
        return false
    }
    if (document.getElementById("salary_employ").value == "0") {
        alert("Mức lương mong muốn không được bằng 0!");
        document.getElementById("salary_employ").focus();
        return false
    }
    var e = tinyMCE.get("txtContent").getContent();
    if (CheckBlank(e)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập chi tiết sản phẩm!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("txtContent").focus();
                    return false;
                }
            }
        });
        return false
    }
    if (CheckBlank(document.getElementById("name_employ").value)) {
        alert("Bạn chưa nhập họ tên!");
        document.getElementById("name_employ").focus();
        return false
    }
    if (CheckBlank(document.getElementById("level_employ").value)) {
        alert("Bạn chưa nhập trình độ!");
        document.getElementById("level_employ").focus();
        return false
    }
    if (CheckBlank(document.getElementById("address_employ").value)) {
        alert("Bạn chưa nhập địa chỉ!");
        document.getElementById("address_employ").focus();
        return false
    }
    if (CheckBlank(document.getElementById("phone_employ").value)) {
        alert("Bạn chưa nhập số điện thoại!");
        document.getElementById("phone_employ").focus();
        return false
    }
    if (!CheckPhone(document.getElementById("phone_employ").value)) {
        alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
        document.getElementById("phone_employ").focus();
        return false
    }
    if (!CheckBlank(document.getElementById("mobile_employ").value)) {
        if (!CheckPhone(document.getElementById("mobile_employ").value)) {
            alert("Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888");
            document.getElementById("mobile_employ").focus();
            return false
        }
    }
    if (CheckBlank(document.getElementById("email_employ").value)) {
        alert("Bạn chưa nhập email!");
        document.getElementById("email_employ").focus();
        return false
    }
    if (!CheckEmail(document.getElementById("email_employ").value)) {
        alert("Email bạn nhập không hợp lệ!");
        document.getElementById("email_employ").focus();
        return false
    }
    if (!CheckDate(document.getElementById("endday_employ").value, document.getElementById("endmonth_employ").value, document.getElementById("endyear_employ").value)) {
        alert("Thời gian hết hạn đăng không hợp lệ!\nThời gian hết hạn đăng phải lớn hơn ngày hiện tại.");
        return false
    }
    if (CheckBlank(document.getElementById("captcha_employ").value)) {
        alert("Bạn chưa nhập mã xác nhận!");
        document.getElementById("captcha_employ").focus();
        return false
    }
    if (document.getElementById("captcha_employ").value != document.getElementById("captcha").value) {
        alert("Bạn nhập mã xác nhận không đúng!");
        document.getElementById("captcha_employ").focus();
        return false
    }
    document.frmEditEmploy.submit()
}

function CheckInput_EditShopIntro() {
    jQuery("#isEditShopIntro").val(1);
    document.frmEditShopIntro.submit()
}

function CheckInput_addbanner() {
    if (document.getElementById("ub_picture").value != "") {
        var e = document.getElementById("ub_picture").value;
        ext = e.split(".")[1];
        var t = "";
        switch (ext) {
            case"png":
                t = 1;
                break;
            case"gif":
                t = 1;
                break;
            case"jpg":
                t = 1;
                break;
            case"PNG":
                t = 1;
                break;
            case"GIF":
                t = 1;
                break;
            case"JPG":
                t = 1;
                break;
            case"swf":
                t = 1;
                break;
            case"SWF":
                t = 1;
                break;
            default:
                t = 0
        }
        if (t == 0) {
            alert("Bạn nhập không đúng định dạng file");
            return false
        }
    }
    var n = document.getElementById("ub_picture");
    var r = n.files[0];
    alert(r.fileSize);
    if (document.getElementById("ub_type_0").value == "") {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập loại banner!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("ub_type_0").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("ub_name_0").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập tên banner!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("ub_name_0").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (jQuery("#banner_image").css("display") == "table-row") {
        if (jQuery("#ub_picture")[0].files[0]) {
            if (jQuery("#ub_picture")[0].files[0].size > 1024 * 1024) {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Dung lượng upload tối đa 1 MB',
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("ub_picture").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
        } else {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Ban chưa chọn file!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("ub_picture").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (jQuery("#banner_size").css("display") == "table-row") {
    }
    if (CheckBlank(document.getElementById("ub_order_0").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập số thứ tự!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("ub_order_0").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (document.getElementById("captcha_shop").value != document.getElementById("current_captcha").value) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn nhập mã xác nhận chưa đúng!',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("captcha_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    jQuery("#isAddBanner").val(1);
    document.addbanner.submit()
}

function changeChkValue(e) {
    if (jQuery(e).is(":checked")) {
        jQuery(e).val(1)
    } else {
        jQuery(e).val(0)
    }
}

function CheckInput_editbanner() {
    if (document.getElementById("ub_picture").value != "") {
        var e = document.getElementById("ub_picture").value;
        ext = e.split(".")[1];
        var t = "";
        switch (ext) {
            case"png":
                t = 1;
                break;
            case"gif":
                t = 1;
                break;
            case"jpg":
                t = 1;
                break;
            case"PNG":
                t = 1;
                break;
            case"GIF":
                t = 1;
                break;
            case"JPG":
                t = 1;
                break;
            case"swf":
                t = 1;
                break;
            case"SWF":
                t = 1;
                break;
            default:
                t = 0
        }
        if (t == 0) {
            alert("Bạn nhập không đúng định dạng file");
            return false
        }
    }
    if (CheckBlank(document.getElementById("ub_name_0").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập tên banner!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("ub_name_0").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (jQuery("#banner_image").css("display") == "table-row") {
        if (jQuery("#ub_picture")[0].files[0]) {
            if (jQuery("#ub_picture")[0].files[0].size > 1024 * 1024) {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Dung lượng upload tối đa 1 MB',
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("ub_picture").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
        } else {
            if (jQuery("#filename").val() == "") {
                $.jAlert({
                    'title': 'Yêu cầu nhập',
                    'content': 'Ban chưa chọn file!',
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("filename").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
        }
    }
    if (jQuery("#banner_size").css("display") == "table-row") {
    }
    if (CheckBlank(document.getElementById("ub_order_0").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập số thứ tự!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("ub_order_0").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (document.getElementById("captcha_shop").value != document.getElementById("current_captcha").value) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Bạn nhập mã xác nhận chưa đúng!',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("current_captcha").focus();
                    return false;
                }
            }
        });
        return false;
    }
    jQuery("#isEditBanner").val(1);
    document.editbanner.submit()
}

function CheckInput_EditShopWarranty() {
    jQuery("#isEditShopWarranty").val(1);
    document.frmEditShopWarranty.submit()
}

function CheckInput_EditShopRule() {
    jQuery("#isEditShopRule").val(1);
    document.frmEditShopRule.submit()
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

function CheckInput_EditShop() {
    if (CheckBlank(document.getElementById("hd_category_id").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa chọn danh mục!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("hd_category_id").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (jQuery("#logo_shop")[0].files[0]) {
        var e = /(.jpg|.jpeg|.png|.gif)$/i;
        if (!vali_type("logo_shop", e)) {
            errorAlert("Chỉ chấp nhận ảnh dạng .JPG, .PNG, .GIF");
            return false
        }
        if (jQuery("#logo_shop")[0].files[0].size > 500 * 1024) {
            errorAlert("Dung lượng ảnh upload tối đa 500kb ", "Thông báo");
            return false
        }
    }
    if (jQuery("#banner_shop")[0].files[0]) {
        var e = /(.jpg|.jpeg|.png|.gif|.swf)$/i;
        if (!vali_type("banner_shop", e)) {
            errorAlert("Chỉ chấp nhận ảnh dạng .JPG, .PNG, .GIF, .SWF", "Thông báo");
            return false
        }
        /*if (jQuery("#banner_shop")[0].files[0].size > 1024 * 1024) {
            errorAlert("Dung lượng Banner upload tối đa 2M", "Thông báo");
            return false
        }*/
    }
    if (jQuery("#bgimg_shop")[0].files[0]) {
        var e = /(.jpg|.jpeg|.png|.gif)$/i;
        if (!vali_type("bgimg_shop", e)) {
            errorAlert("Chỉ chấp nhận ảnh dạng .JPG, .PNG, .GIF", "Thông báo");
            return false
        }
        if (jQuery("#bgimg_shop")[0].files[0].size > 1024 * 1024) {
            errorAlert("Dung lượng Background upload tối đa 2M", "Notice");
            return false
        }
    }
    if (CheckBlank(document.getElementById("logo_shop").value)) {
        if ($('#img_vavatar_input1').css('display') == 'none') {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập logo !',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("logo_shop").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (!CheckLink(document.getElementById("link_shop").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Link tới gian hàng bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, _-',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("link_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("banner_shop_hiden").value) && CheckBlank(document.getElementById("banner_shop").value)) {
        if ($('#img_vavatar_input2').css('display') == 'none') {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập  banner!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("banner_shop").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (CheckBlank(document.getElementById("link_shop").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập link tới gian hàng!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("link_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("name_shop").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập tên công ty!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("name_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("descr_shop").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập mô tả gian hàng!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("descr_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("address_shop").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập địa chỉ của gian hàng!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("address_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("mobile_shop").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập số điện thoại di động!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("mobile_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("province_shop").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập Tỉnh thành của shop!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("province_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if ($("#address_kho_shop").attr("disabled") != 'disabled') {
        if (CheckBlank(document.getElementById("address_kho_shop").value)) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập địa chỉ kho!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("address_kho_shop").focus();
                        return false;
                    }
                }
            });
            return false;
        }
        if (CheckBlank(document.getElementById("province_kho_shop").value)) {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập Tỉnh thành của kho!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("province_kho_shop").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    // if (CheckBlank(document.getElementById("shop_type").value)) {
    //     $.jAlert({
    //         'title': 'Yêu cầu nhập',
    //         'content': 'Bạn chưa chọn loại gian hàng!',
    //         'theme': 'default',
    //         'btns': {
    //             'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
    //                 e.preventDefault();
    //                 document.getElementById("shop_type").focus();
    //                 return false;
    //             }
    //         }
    //     });
    //     return false;
    // }
    if (CheckBlank(document.getElementById("hd_category_id").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa chọn danh mục cho gian hàng!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("hd_category_id").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (!CheckPhone(document.getElementById("mobile_shop").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("mobile_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (!CheckPhone(document.getElementById("mobile_shop").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("mobile_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (!CheckWebsite(document.getElementById("website_shop").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Địa chỉ website bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, / . : _ -',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("website_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    // if (CheckBlank(document.getElementById("shop_type").value)) {
    //     $.jAlert({
    //         'title': 'Yêu cầu nhập',
    //         'content': 'Bạn chưa chọn loại gian hàng!',
    //         'theme': 'default',
    //         'btns': {
    //             'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
    //                 e.preventDefault();
    //                 document.getElementById("shop_type").focus();
    //                 return false;
    //             }
    //         }
    //     });
    //     return false;
    // }
    jQuery("#isEditShop").val(1);
    document.frmEditShop.submit();
    return false;
}

function CheckInput_EditShopQ() {
    if (CheckBlank(document.getElementById("hd_category_id").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa chọn danh mục!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("hd_category_id").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (jQuery("#logo_shop")[0].files[0]) {
        var e = /(.jpg|.jpeg|.png|.gif)$/i;
        if (!vali_type("logo_shop", e)) {
            errorAlert("Chỉ chấp nhận ảnh dạng .JPG, .PNG, .GIF");
            return false
        }
        if (jQuery("#logo_shop")[0].files[0].size > 500 * 1024) {
            errorAlert("Dung lượng ảnh upload tối đa 500kb ", "Thông báo");
            return false
        }
    }
    if (jQuery("#banner_shop")[0].files[0]) {
        var e = /(.jpg|.jpeg|.png|.gif|.swf)$/i;
        if (!vali_type("banner_shop", e)) {
            errorAlert("Chỉ chấp nhận ảnh dạng .JPG, .PNG, .GIF, .SWF", "Thông báo");
            return false
        }
        if (jQuery("#banner_shop")[0].files[0].size > 1024 * 1024) {
            errorAlert("Dung lượng Banner upload tối đa 2M", "Thông báo");
            return false
        }
    }
    if (jQuery("#bgimg_shop")[0].files[0]) {
        var e = /(.jpg|.jpeg|.png|.gif)$/i;
        if (!vali_type("bgimg_shop", e)) {
            errorAlert("Chỉ chấp nhận ảnh dạng .JPG, .PNG, .GIF", "Thông báo");
            return false
        }
        if (jQuery("#bgimg_shop")[0].files[0].size > 1024 * 1024) {
            errorAlert("Dung lượng Background upload tối đa 2M", "Notice");
            return false
        }
    }
    if (CheckBlank(document.getElementById("logo_shop").value)) {
        if ($('#img_vavatar_input1').css('display') == 'none') {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập logo !',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("logo_shop").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (!CheckLink(document.getElementById("link_shop").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Link tới gian hàng bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, _-',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("link_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("banner_shop_hiden").value) && CheckBlank(document.getElementById("banner_shop").value)) {
        if ($('#img_vavatar_input2').css('display') == 'none') {
            $.jAlert({
                'title': 'Yêu cầu nhập',
                'content': 'Bạn chưa nhập  banner!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("banner_shop").focus();
                        return false;
                    }
                }
            });
            return false;
        }
    }
    if (CheckBlank(document.getElementById("link_shop").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập link tới gian hàng!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("link_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("name_shop").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập tên công ty!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("name_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("descr_shop").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập mô tả gian hàng!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("descr_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("address_shop").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập địa chỉ của gian hàng!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("address_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("mobile_shop").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập số điện thoại di động!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("mobile_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("province_shop").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập Tỉnh thành của shop!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("province_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (!CheckPhone(document.getElementById("mobile_shop").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("mobile_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (!CheckWebsite(document.getElementById("website_shop").value)) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Địa chỉ website bạn nhập không hợp lệ!\nChỉ chấp nhận các ký tự 0-9, a-z, / . : _ -',
            'theme': 'red',
            'btns': {
                'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("website_shop").focus();
                    return false;
                }
            }
        });
        return false;
    }
    jQuery("#isEditShop").val(1);
    document.frmEditShop.submit();
    return false;
}
function BlockChar(e, t) {
}
function CapitalizeNames(FormName, FieldName) {
}
function AddComma(e) {
    e += "";
    x = e.split(".");
    x1 = x[0];
    x2 = "";
    x2 = x.length > 1 ? "." + x[1] : "";
    var t = /(\d+)(\d{3})/;
    while (t.test(x1)) {
        x1 = x1.replace(t, "$1" + "," + "$2")
    }
    return x1 + x2
}
function FormatCurrency(e, t, n) {
    document.getElementById(e).style.display = "";
    document.getElementById(e).innerHTML = AddComma(n);
    document.getElementById(e).innerHTML = document.getElementById(e).innerHTML + " " + document.getElementById(t).options[document.getElementById(t).selectedIndex].innerHTML
}
function FormatCost(e, t) {
    if (document.getElementById(t)) {
        document.getElementById(t).innerHTML = AddComma(e)
    }
}
function subStr(e, t, n) {
    var r = e.length;
    var i = "";
    var s = 0;
    while (s < t) {
        i += e.charAt(s);
        if (s == r) {
            document.getElementById(n).innerHTML = e;
            return
        }
        s += 1
    }
    document.getElementById(n).innerHTML = i + " ..."
}
function ChangeStyleTextBox(e, t, n) {
    if (n == true) {
        document.getElementById(e).style.backgroundColor = "#DDDDDD";
        document.getElementById(e).value = "0"
    } else {
        document.getElementById(e).style.backgroundColor = "#FFFFFF";
        document.getElementById(e).value = ""
    }
    document.getElementById(t).style.display = "none"
}
function ChangeCheckBox(e) {
    document.getElementById(e).checked = false
}
function ChangeLawRegister(e, t) {
    if (e == true) {
        if (t == 1) {
            document.getElementById("DivNormalRegister").style.display = "none";
            document.getElementById("DivVipRegister").style.display = "";
            document.getElementById("DivShopRegister").style.display = "none";
            jQuery(function () {
                jQuery("#Panel_2").jScrollPane({showArrows: true, scrollbarWidth: 15, arrowSize: 16})
            })
        }
        if (t == 2) {
            document.getElementById("DivNormalRegister").style.display = "none";
            document.getElementById("DivVipRegister").style.display = "none";
            document.getElementById("DivShopRegister").style.display = ""
        }
    } else {
        document.getElementById("DivNormalRegister").style.display = "";
        document.getElementById("DivVipRegister").style.display = "none";
        document.getElementById("DivShopRegister").style.display = "none"
    }
}
function DoCheck(status, FormName, from_) {
    var alen = eval("document." + FormName + ".elements.length");
    alen = alen > 1 ? eval("document." + FormName + ".checkone.length") : 0;
    if (alen > 0) {
        for (var i = 0; i < alen; i++)eval("document." + FormName + ".checkone[i].checked=status")
    } else {
        eval("document." + FormName + ".checkone.checked=status")
    }
    if (from_ > 0)eval("document." + FormName + ".checkall.checked=status")
}
function DoCheckOne(FormName) {
    var alen = eval("document." + FormName + ".elements.length");
    var isChecked = true;
    alen = alen > 1 ? eval("document." + FormName + ".checkone.length") : 0;
    if (alen > 0) {
        for (var i = 0; i < alen; i++)if (eval("document." + FormName + ".checkone[i].checked==false"))isChecked = false
    } else {
        if (eval("document." + FormName + ".checkone.checked==false"))isChecked = false
    }
    eval("document." + FormName + ".checkall.checked=isChecked")
}
function SumCost(e, t, n, r, i, productId) {
    var s = document.getElementById(e).value * document.getElementById(t).value;
    var o = s / i;
    s = Math.round(s);
    o = Math.round(o);
    s = AddComma(s);
    o = AddComma(o);
    quantity = document.getElementById(t).value;
    baseUrl = document.getElementById("baseUrl").innerHTML;
    document.getElementById(n).innerHTML = s;
    document.getElementById(r).innerHTML = o + " USD";
    updateQuantityProduct(baseUrl, productId, quantity, t);
}
function TotalCost(e, t, n, r, i, s) {
    var o = 0;
    var u = 0;
    if (i > 0) {
        for (var a = 1; a <= i; a++) {
            o = o + document.getElementById(e + a).value * document.getElementById(t + a).value
        }
    }
    u = o / s;
    o = Math.round(o);
    vndNoneComma = o;
    u = Math.round(u);
    o = AddComma(o);
    u = AddComma(u);
    document.getElementById(n).innerHTML = o + " VND";
    document.getElementById("totalPrice").value = vndNoneComma;
    document.getElementById(r).innerHTML = "(" + u + " USD)"
}
function ActionDeleteShowcart(e) {
    var t = document.forms['frmShowCart'].elements.length;
    console.log(t);
    var n = false;
    t = t > 1 ? document.forms[e].checkone.length : 0;
    if (t > 0) {
        for (var r = 0; r < t; r++)if (document.forms[e].checkone[r].checked == true) {
            n = true;
            break
        }
    } else {
        if (document.forms[e].checkone.checked == true)n = true
    }
    if (n == true) {
        document.forms[e].submit()
    }
}
function ActionEqual(e) {
    if (e == "1") {
        if (answer) {
            document.getElementById("checkall").checked = false;
            DoCheck(document.frmShowCart.checkall.checked, "frmShowCart", 0);
            document.forms["frmShowCart"].submit();
            return true
        } else {
            return false
        }
    } else {
        alert(e)
    }
}
function submit_payment(e, t) {
    if (e == "1") {
        document.getElementById("checkall").checked = false;
        DoCheck(document.form.checkall.checked, t, 0);
        return true;
    }
}
function ResetQuantity(e, t) {
    for (var n = 1; n <= t; n++) {
    }
}
function ChangeStyleBox(e, t) {
    switch (t) {
        case 1:
            document.getElementById(e).style.border = "1px #2F97FF solid";
            break;
        case 2:
            document.getElementById(e).style.border = "1px #D4EDFF solid";
            break;
        default:
            document.getElementById(e).style.border = "1px #2F97FF solid"
    }
}
function ChangeStyleRow(e, t, n) {
    switch (n) {
        case 1:
            document.getElementById(e).style.background = "#ECF5FF";
            break;
        case 2:
            if (t % 2 == 0) {
                document.getElementById(e).style.background = "#f1f9ff"
            } else {
                document.getElementById(e).style.background = "none"
            }
            break;
        default:
            document.getElementById(e).style.background = "#ECF5FF"
    }
}
function ActionSort(e) {
    window.location.href = e
}
function ActionLink(e) {
    window.location.href = e
}
function Favorite(formName, status) {
    if (status == "1") {
        eval("document." + formName + ".submit();")
    } else {
        alert(status)
    }
}
function Showcart(formName, status) {
    if (status == "1") {
        var form = $('form[name="' + formName + '"]');
        var qty = $('input[name="qty"]').val();
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: form.attr('action'),
            data: form.serialize() + '&qty=' + qty,
            success: function (result) {
                if (result.error == false) {
                    $('.cartNum').text(result.num);
                }
                bootbox.dialog({
                    title: "Thông báo",
                    message: '<p class="' + (result.error == true ? 'alert-danger' : 'alert-success') + '">' + result.message + '</p>'
                });
            },
            error: function () {
            }
        });
    } else {
        alert(status)
    }
}
function Showcart_order_now(formName, status) {
    if (status == "1") {
        var form = $('form[name="' + formName + '"]');
        var qty = $('input[name="qty"]').val();
        jQuery.ajax({
            type: "POST",
            dataType: "json",
            url: form.attr('action'),
            data: form.serialize() + '&qty=' + qty,
            success: function (result) {
                if (result.error == false) {
                    window.location = $(form).attr('action');
                }
            },
            error: function () {
            }
        });
    } else {
        alert(status)
    }
}
function SubmitVote() {
    document.frmVote.submit()
}
function OpenTabTopJob(e, t, n) {
    if (n == "job") {
        var r = "DivTop24hJob"
    } else {
        var r = "DivTop24hEmploy"
    }
    switch (t) {
        case 1:
            for (i = 1; i <= e; i++) {
                document.getElementById(r + "_" + i).style.display = ""
            }
            for (i = e + 1; i <= 3 * e; i++) {
                document.getElementById(r + "_" + i).style.display = "none"
            }
            break;
        case 2:
            for (i = 1; i <= e; i++) {
                document.getElementById(r + "_" + i).style.display = "none"
            }
            for (i = e + 1; i <= 2 * e; i++) {
                document.getElementById(r + "_" + i).style.display = ""
            }
            for (i = 2 * e + 1; i <= 3 * e; i++) {
                document.getElementById(r + "_" + i).style.display = "none"
            }
            break;
        default:
            for (i = 1; i <= 2 * e; i++) {
                document.getElementById(r + "_" + i).style.display = "none"
            }
            for (i = 2 * e + 1; i <= 3 * e; i++) {
                document.getElementById(r + "_" + i).style.display = ""
            }
    }
}
function OpenTabField() {
    if (document.getElementById("DivField_1").style.display == "none") {
        document.getElementById("DivField_1").style.display = "";
        document.getElementById("DivField_2").style.display = "";
        document.getElementById("DivField_3").style.display = "";
        document.getElementById("DivField_4").style.display = ""
    } else {
        document.getElementById("DivField_1").style.display = "none";
        document.getElementById("DivField_2").style.display = "none";
        document.getElementById("DivField_3").style.display = "none";
        document.getElementById("DivField_4").style.display = "none"
    }
}
function ActionSubmit(formName) {
    eval("document." + formName + ".submit();")
}
function mktime() {
    var e = 0, t = 0, n = 0, r = 0, i = new Date, s = new Date, o = arguments, u = o.length;
    var a = {
        0: function (e) {
            return i.setHours(e)
        }, 1: function (e) {
            return i.setMinutes(e)
        }, 2: function (e) {
            var t = i.setSeconds(e);
            r = i.getDate() - s.getDate();
            return t
        }, 3: function (e) {
            var t = i.setMonth(parseInt(e, 10) - 1);
            n = i.getFullYear() - s.getFullYear();
            return t
        }, 4: function (e) {
            return i.setDate(e + r)
        }, 5: function (e) {
            if (e >= 0 && e <= 69) {
                e += 2e3
            } else if (e >= 70 && e <= 100) {
                e += 1900
            }
            return i.setFullYear(e + n)
        }
    };
    for (t = 0; t < u; t++) {
        e = parseInt(o[t] * 1, 10);
        if (isNaN(e)) {
            return false
        } else {
            if (!a[t](e)) {
                return false
            }
        }
    }
    for (t = u; t < 6; t++) {
        switch (t) {
            case 0:
                e = s.getHours();
                break;
            case 1:
                e = s.getMinutes();
                break;
            case 2:
                e = s.getSeconds();
                break;
            case 3:
                e = s.getMonth() + 1;
                break;
            case 4:
                e = s.getDate();
                break;
            case 5:
                e = s.getFullYear();
                break
        }
        a[t](e)
    }
    return Math.floor(i.getTime() / 1e3)
}
function ActionSearch(e, t) {
    var n = "";
    switch (t) {
        case 1:
            n = e;
            isName = document.getElementById("name_search").value;
            isSCost = document.getElementById("cost_search1").value;
            isECost = document.getElementById("cost_search2").value;
            isCurrency = document.getElementById("currency_search").value;
            isSaleoff = document.getElementById("saleoff_search").value;
            isPlace = document.getElementById("province_search").value;
            isCategory = document.getElementById("category_search").value;
            isSDay = document.getElementById("beginday_search1").value;
            isSMonth = document.getElementById("beginmonth_search1").value;
            isSYear = document.getElementById("beginyear_search1").value;
            isEDay = document.getElementById("beginday_search2").value;
            isEMonth = document.getElementById("beginmonth_search2").value;
            isEYear = document.getElementById("beginyear_search2").value;
            isSDate = mktime(0, 0, 0, isSMonth, isSDay, isSYear);
            isEDate = mktime(0, 0, 0, isEMonth, isEDay, isEYear);
            if (!CheckBlank(isName)) {
                n += "name/" + isName + "/"
            }
            if (!CheckBlank(isSCost) && !CheckBlank(isECost)) {
                n += "sCost/" + isSCost + "/";
                n += "eCost/" + isECost + "/";
                n += "currency/" + isCurrency + "/"
            }
            if (document.getElementById("saleoff_search").checked == true) {
                n += "saleoff/1/"
            }
            if (isPlace != "0") {
                n += "place/" + isPlace + "/"
            }
            if (isCategory != "0") {
                n += "category/" + isCategory + "/"
            }
            if (isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008)) {
                n += "sPostdate/" + isSDate + "/";
                n += "ePostdate/" + isEDate + "/"
            }
            window.location.href = n;
            break;
        case 2:
            n = e;
            isTitle = document.getElementById("title_search").value;
            isSView = document.getElementById("view_search1").value;
            isEView = document.getElementById("view_search2").value;
            isPlace = document.getElementById("province_search").value;
            isCategory = document.getElementById("category_search").value;
            isSDay = document.getElementById("beginday_search1").value;
            isSMonth = document.getElementById("beginmonth_search1").value;
            isSYear = document.getElementById("beginyear_search1").value;
            isEDay = document.getElementById("beginday_search2").value;
            isEMonth = document.getElementById("beginmonth_search2").value;
            isEYear = document.getElementById("beginyear_search2").value;
            isSDate = mktime(0, 0, 0, isSMonth, isSDay, isSYear);
            isEDate = mktime(0, 0, 0, isEMonth, isEDay, isEYear);
            if (!CheckBlank(isTitle)) {
                n += "title/" + isTitle + "/"
            }
            if (!CheckBlank(isSView) && !CheckBlank(isEView)) {
                n += "sView/" + isSView + "/";
                n += "eView/" + isEView + "/"
            }
            if (isPlace != "0") {
                n += "place/" + isPlace + "/"
            }
            if (isCategory != "0") {
                n += "category/" + isCategory + "/"
            }
            if (isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008)) {
                n += "sPostdate/" + isSDate + "/";
                n += "ePostdate/" + isEDate + "/"
            }
            window.location.href = n;
            break;
        case 3:
            n = e;
            isTitle = document.getElementById("title_search").value;
            isSalary = document.getElementById("salary_search").value;
            isCurrency = document.getElementById("currency_search").value;
            isPlace = document.getElementById("province_search").value;
            isField = document.getElementById("field_search").value;
            isSDay = document.getElementById("beginday_search1").value;
            isSMonth = document.getElementById("beginmonth_search1").value;
            isSYear = document.getElementById("beginyear_search1").value;
            isEDay = document.getElementById("beginday_search2").value;
            isEMonth = document.getElementById("beginmonth_search2").value;
            isEYear = document.getElementById("beginyear_search2").value;
            isSDate = mktime(0, 0, 0, isSMonth, isSDay, isSYear);
            isEDate = mktime(0, 0, 0, isEMonth, isEDay, isEYear);
            if (!CheckBlank(isTitle)) {
                n += "title/" + isTitle + "/"
            }
            if (!CheckBlank(isSalary)) {
                n += "salary/" + isSalary + "/";
                n += "currency/" + isCurrency + "/"
            }
            if (isPlace != "0") {
                n += "place/" + isPlace + "/"
            }
            if (isField != "0") {
                n += "field/" + isField + "/"
            }
            if (isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008)) {
                n += "sPostdate/" + isSDate + "/";
                n += "ePostdate/" + isEDate + "/"
            }
            window.location.href = n;
            break;
        case 4:
            n = e;
            isTitle = document.getElementById("title_search").value;
            isSalary = document.getElementById("salary_search").value;
            isCurrency = document.getElementById("currency_search").value;
            isPlace = document.getElementById("province_search").value;
            isField = document.getElementById("field_search").value;
            isSDay = document.getElementById("beginday_search1").value;
            isSMonth = document.getElementById("beginmonth_search1").value;
            isSYear = document.getElementById("beginyear_search1").value;
            isEDay = document.getElementById("beginday_search2").value;
            isEMonth = document.getElementById("beginmonth_search2").value;
            isEYear = document.getElementById("beginyear_search2").value;
            isSDate = mktime(0, 0, 0, isSMonth, isSDay, isSYear);
            isEDate = mktime(0, 0, 0, isEMonth, isEDay, isEYear);
            if (!CheckBlank(isTitle)) {
                n += "title/" + isTitle + "/"
            }
            if (!CheckBlank(isSalary)) {
                n += "salary/" + isSalary + "/";
                n += "currency/" + isCurrency + "/"
            }
            if (isPlace != "0") {
                n += "place/" + isPlace + "/"
            }
            if (isField != "0") {
                n += "field/" + isField + "/"
            }
            if (isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008)) {
                n += "sPostdate/" + isSDate + "/";
                n += "ePostdate/" + isEDate + "/"
            }
            window.location.href = n;
            break;
        case 5:
            n = e;
            isName = document.getElementById("name_search").value;
            isAddress_Shop = document.getElementById("address_search").value;
            isSaleoff = document.getElementById("saleoff_search").value;
            isProvince = document.getElementById("province_search").value;
            isCategory = document.getElementById("category_search").value;
            isSDay = document.getElementById("beginday_search1").value;
            isSMonth = document.getElementById("beginmonth_search1").value;
            isSYear = document.getElementById("beginyear_search1").value;
            isEDay = document.getElementById("beginday_search2").value;
            isEMonth = document.getElementById("beginmonth_search2").value;
            isEYear = document.getElementById("beginyear_search2").value;
            isSDate = mktime(0, 0, 0, isSMonth, isSDay, isSYear);
            isEDate = mktime(0, 0, 0, isEMonth, isEDay, isEYear);
            if (!CheckBlank(isName)) {
                n += "name/" + isName + "/"
            }
            if (document.getElementById("saleoff_search").checked == true) {
                n += "saleoff/1/"
            }
            if (!CheckBlank(isAddress_Shop)) {
                n += "address/" + isAddress_Shop + "/"
            }
            if (isProvince != "0") {
                n += "province/" + isProvince + "/"
            }
            if (isCategory != "0") {
                n += "category/" + isCategory + "/"
            }
            if (isSDate >= mktime(0, 0, 0, 1, 1, 2008) && isEDate >= mktime(0, 0, 0, 1, 1, 2008)) {
                n += "sPostdate/" + isSDate + "/";
                n += "ePostdate/" + isEDate + "/"
            }
            window.location.href = n;
            break;
        default:
            var r = "";
            var i = "";
            r = document.getElementById("keyword_account").value;
            i = document.getElementById("search_account").value;
            if (!CheckBlank(r)) {
                n = e + "search/" + i + "/keyword/" + r;
                window.location.href = n
            }
    }
}
function SelectSearch(e) {
    for (i = 1; i < 6; i++) {
        document.getElementById("TabSearch_" + i).className = "menu"
    }
    document.getElementById("TabSearch_" + e).className = "search_selected";
    return e
}
function Search(e, t) {
    var n = t + "search/";
    switch (e) {
        case 2:
            n += "raovat/title/";
            break;
        case 3:
            n += "job/title/";
            break;
        case 4:
            n += "employ/title/";
            break;
        case 5:
            n += "shop/name/";
            break;
        default:
            n += "product/name/"
    }
    var r = jQuery("#category_quick_search").val();
    var i = jQuery("#name_quick_search").val();
    if (!CheckBlank(i)) {
        n = n + i
    } else {
        n = n + "a"
    }
    if (!CheckBlank(r)) {
        n = n + "/category/" + r
    }
    window.location.href = n;
    return false
}
function Guide(e) {
    $totalGuide = 9;
    for ($i = 1; $i < e; $i++) {
        document.getElementById("DivTitleGuide_" + $i).style.display = "none";
        document.getElementById("DivContentGuide_" + $i).style.display = "none";
        document.getElementById("DivListGuide_" + $i).className = "menu_1"
    }
    for ($j = e + 1; $j <= $totalGuide; $j++) {
        document.getElementById("DivTitleGuide_" + $j).style.display = "none";
        document.getElementById("DivContentGuide_" + $j).style.display = "none";
        document.getElementById("DivListGuide_" + $j).className = "menu_1"
    }
    document.getElementById("DivIntroGuide").style.display = "none";
    document.getElementById("DivGuide").style.display = "block";
    document.getElementById("DivTitleGuide_" + e).style.display = "block";
    document.getElementById("DivContentGuide_" + e).style.display = "block";
    document.getElementById("DivListGuide_" + e).className = "menu_2"
}
function TabTaskbarNotify(e) {
    switch (e) {
        case 1:
            if (document.getElementById("DivTaskbarNotify").style.display == "block") {
                document.getElementById("DivTaskbarNotify").style.display = "none"
            } else {
                document.getElementById("DivTaskbarNotify").style.display = "block"
            }
            break;
        default:
            document.getElementById("DivTaskbarNotify").style.display = "none"
    }
}
function validImage(e) {
    e = e * 1;
    if (e > 1506) {
        return true
    } else {
        return false
    }
}
function showThumbnail(e, t, n) {
    var r = t.split(",");
    if (validImage(e)) {
        return "thumbnail_" + n + "_" + r[0]
    } else {
        return r[0]
    }
}
function lowerCase(e, t) {
    str = e.toLowerCase();
    document.getElementById(t).value = str
}
function Notspace(e, t) {
    str = e.toLowerCase();
    document.getElementById(t).value = str.trim();
}
function pagingHomepage(e, t) {
    jQuery(".shop_block").css("display", "none");
    jQuery("#" + e + t).css("display", "block");
    jQuery(".review_page").removeClass("current");
    jQuery("#review_page_" + t).addClass("current")
}
function pagingHomepageVote(e, t) {
    jQuery(".vote_block").css("display", "none");
    jQuery("#" + e + t).css("display", "block");
    jQuery(".review_page_vote").removeClass("current");
    jQuery("#review_page_vote_" + t).addClass("current")
}
function getCategory4Search(e, t) {
    jQuery.ajax({
        type: "POST", url: e + "ajax_category", data: "selCate=" + t, success: function (e) {
            jQuery("#category_quick_search").append(e)
        }, error: function () {
        }
    })
}

function delete_image(a,b,c,d,e,f,g) {
    confirm(function (e1, btn) {
        e1.preventDefault();
        jQuery.ajax({
            type: "POST",
            url: a + "xoa_hinh_anh",
            data: "dk_xoa=" + b + "& field_dk_xoa=" + c + "& tem_field_img=" + d + "& table_update=" + e + "& imgpath=" + f + "& imgname=" + g,
            success: function (e2) {                
                jQuery("#img_vavatar_input").after('<div id="vavatar_input"> <input name="avatar" id="avatar" class="inputimage_formpost" type="file"> <img style="height:116px; margin-top: 15px" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview"> </div>');
                jQuery("#img_vavatar_input").remove();
            },
            error: function () {
            }
        })
    });
    return false
}

function delete_img_ajax(e, t, n, r, i) {
    confirm(function (e1, btn) {
        e1.preventDefault();
        jQuery.ajax({
            type: "POST",
            url: e + "xoa_hinh_one",
            data: "dk_xoa=" + t + "& field_dk_xoa=" + n + "& tem_field_img=" + r + "& table_update=" + i,
            success: function (e) {
                jQuery("#img_vavatar_input").css("display", "none");
                jQuery("#vavatar_input").css("display", "block")
            },
            error: function () {
            }
        })
    });
    return false
}
function delete_img_shop_img(url, idshop, type) {
    confirm(function (e1, btn) {
        e1.preventDefault();
        jQuery.ajax({
            type: "POST",
            url: url + "administ/shop/delete_img",
            data: {idshop: idshop, type: type},
            success: function (data) {
                jQuery("#img_vavatar_input").css("display", "none");
                jQuery("#vavatar_input").css("display", "block")
            },
            error: function () {
            }
        })
    });
    return false
}
function delete_img_ajax_and_defaults(e, t, n, r, i, s, o) {
    confirm(function (e1, btn) {
        e1.preventDefault();
        jQuery.ajax({
            type: "POST",
            url: e + "xoa_hinh_one_and_defalut",
            data: "dk_xoa=" + t + "& field_dk_xoa=" + n + "& tem_field_img=" + r + "& table_update=" + i + "& duong_dan=" + s,
            success: function (e) {
                jQuery("#img_vavatar_input" + o).css("display", "none");
                jQuery("#vavatar_input" + o).css("display", "block")
            },
            error: function () {
            }
        })
    });
    return false
}
function delete_img_ajax_and_shop(e, t, n, r, i, s, o, u, a) {
    confirm(function (e1, btn) {
        e1.preventDefault();
        jQuery.ajax({
            type: "POST",
            url: e + "xoa_hinh_one_and_shop",
            data: "dk_xoa=" + t + "& field_dk_xoa=" + n + "& tem_field_img=" + r + "& table_update=" + i + "& duong_dan=" + s + "& ten_duong_dan=" + a + "& ten_hinh=" + u,
            success: function (e) {
                jQuery("#img_vavatar_input" + o).css("display", "none");
                jQuery("#vavatar_input" + o).css("display", "block")
            },
            error: function () {
            }
        })
    });
    return false
}
function confirmDeleteLandingPage(link) {
    confirm(function (e1, btn) {
        e1.preventDefault();
        window.location.href = link;
    });
    return true;
}
function confirmDeleteContentBran(link) {
    confirm(function (e1, btn) {
        e1.preventDefault();
        window.location.href = link;
    });
    return true;
}
function delete_nhieuimg_ajax(e, t, n, r) {
    confirm(function (e1, btn) {
        e1.preventDefault();
        jQuery.ajax({
            type: "POST",
            url: e + "xoa_hinh_nhieu",
            data: "dk_xoa=" + t + "& dulieu_xoa=" + n,
            success: function (e) {
                jQuery("#image" + r + "_edit").val("");
                jQuery("#img_vavatar_input" + r).css("display", "none");
                jQuery("#vavatar_input" + r).css("display", "block")
            },
            error: function () {
            }
        })
    });
    return false
}
function delete_img_pro(e, t, n, r) {
    var num = r + 1;
    confirm(function (e1, btn) {
        e1.preventDefault();
        jQuery.ajax({
            type: "POST",
            url: e + "del_img_pro",
            data: {id_pro: t, img_name: n, img_num: r},
            success: function (e) {
                jQuery("#image" + num + "_edit").val("");
                jQuery("#image" + num + "_edit").attr('value','');
                jQuery("#img_vavatar_input" + num).css("display", "none");
                jQuery("#vavatar_input" + num).css("display", "block")
            },
            error: function () {
            }
        });
    });
    return false
}
function delete_tintucimg_ajax(e, t, n, r) {
    confirm(function (e1, btn) {
        e1.preventDefault();
        jQuery.ajax({
            type: "POST",
            url: e + "xoa_hinh_tintuc",
            data: "dk_xoa=" + t + "& dulieu_xoa=" + n,
            success: function (e) {
                jQuery("#image" + r + "_edit").val("");
                jQuery("#image" + r + "_edit").attr('value','');
                jQuery("#img_vavatar_input" + r).css("display", "none");
                jQuery("#vavatar_input" + r).css("display", "block")
            },
            error: function () {
            }
        })
    });
    return false
}
function update_theo_doi_hoi_dap(e, t, n, r) {
    if (n != "") {
        jQuery.ajax({
            type: "POST",
            url: e + "theo_doi_hoi_dap",
            data: "id_hds=" + t + "& id_user=" + n + "& hds_theo_doi=" + r,
            success: function (e) {
                alert(e)
            },
            error: function () {
            }
        })
    } else {
        alert("Bạn vui lòng đăng nhập để thực hiện chức năng này")
    }
}
function bao_cao_sai_gia(e, t, n, r) {
    if (n != "") {
        confirm(function (e1, btn) {
            e1.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: e + "product/bao_cao_sai_gia",
                data: "id_hds=" + t + "& id_user=" + n + "& id_gia=" + r,
                success: function (e) {
                    alert(e)
                },
                error: function () {
                }
            })
        });
        return false
    } else {
        alert("Bạn vui lòng đăng nhập để thực hiện chức năng này")
    }
}
function baocaoaovatxau(e, t, n) {
    if (n != "") {
        confirm(function (e1, btn) {
            e1.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: e + "raovat/rao_vat_xau",
                data: "id_hds=" + t + "& id_user=" + n,
                success: function (e) {
                    alert(e)
                },
                error: function () {
                }
            })
        });
        return false
    } else {
        alert("Bạn vui lòng đăng nhập để thực hiện chức năng này")
    }
}
function baocaohoidapxau(e, t, n) {
    if (n != "") {
        confirm(function (e1, btn) {
            e1.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: e + "hoidap/hoi_dap_xau",
                data: "id_hds=" + t + "& id_user=" + n,
                success: function (e) {
                    alert(e)
                },
                error: function () {
                }
            })
        });
        return false
    } else {
        alert("Bạn vui lòng đăng nhập để thực hiện chức năng này")
    }
}
function baocaotraloixau(e, t, n) {
    if (n != "") {
        confirm(function (e1, btn) {
            e1.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: e + "hoidap/tra_loi_xau",
                data: "id_hds=" + t + "& id_user=" + n,
                success: function (e) {
                    alert(e)
                },
                error: function () {
                }
            })
        });
        return false
    } else {
        alert("Bạn vui lòng đăng nhập để thực hiện chức năng này")
    }
}
function baocaotimviecquypham(e, t, n) {
    if (n != "") {
        confirm(function (e1, btn) {
            e1.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: e + "timviec/timviecquypham",
                data: "id_hds=" + t + "& id_user=" + n,
                success: function (e) {
                    alert(e)
                },
                error: function () {
                }
            })
        });
        return false
    } else {
        alert("Bạn vui lòng đăng nhập để thực hiện chức năng này")
    }
}
function baocaotuyendungquypham(e, t, n) {
    if (n != "") {
        confirm(function (e1, btn) {
            e1.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: e + "tuyendung/tuyendungquypham",
                data: "id_hds=" + t + "& id_user=" + n,
                success: function (e) {
                    alert(e)
                },
                error: function () {
                }
            })
        });
        return false
    } else {
        alert("Bạn vui lòng đăng nhập để thực hiện chức năng này")
    }
}
function delete_theo_doi_hoi_dap(e, t, n, r) {
    jQuery.ajax({
        type: "POST",
        url: e + "delete_theo_doi_hoi_dap",
        data: "value_theodoi=" + t + "& hds_id=" + r,
        success: function (e) {
            jQuery("#" + n).css("display", "none")
        },
        error: function () {
        }
    })
}
function getManAndCategory4Search(e) {
    CategoryKeyWord = document.getElementById("hd_category_id").value;
    if (CategoryKeyWord != "") {
        jQuery.ajax({
            type: "POST",
            url: e + "ajax_mancatego",
            data: "selCate=" + CategoryKeyWord,
            success: function (e) {
                if (e != "") {
                    jQuery("#mannufacurer_pro").append(e)
                } else {
                    jQuery("#manafacture_khac").css("display", "block")
                }
                jQuery("#mannufacurer_pro option[value='khac']").each(function () {
                    jQuery(this).remove()
                });
                jQuery("#mannufacurer_pro").append('<option value="khac" >Khác</option>')
            },
            error: function () {
            }
        })
    }
}
function ManafactureKhac(e) {
    if (e == "khac") {
        jQuery("#manafacture_khac").css("display", "block")
    } else {
        jQuery("#manafacture_khac").css("display", "none")
    }
}
function number_format(e, t, n, r) {
    e = (e + "").replace(/[^0-9+\-Ee.]/g, "");
    var i = !isFinite(+e) ? 0 : +e, s = !isFinite(+t) ? 0 : Math.abs(t), o = typeof r === "undefined" ? "," : r, u = typeof n === "undefined" ? "." : n, a = "", f = function (e, t) {
        var n = Math.pow(10, t);
        return "" + Math.round(e * n) / n
    };
    a = (s ? f(i, s) : "" + Math.round(i)).split(".");
    if (a[0].length > 3) {
        a[0] = a[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, o)
    }
    if ((a[1] || "").length < s) {
        a[1] = a[1] || "";
        a[1] += (new Array(s - a[1].length + 1)).join("0")
    }
    return a.join(u)
}
function select_price() {
    var e = parseFloat(jQuery("#select_cost").val());
    var t = parseFloat(e * .01);
    var n = e + t;
    jQuery("#bk_fee").html(number_format(t, 0, ",", "."));
    jQuery("#total_fee").html(number_format(n, 0, ",", "."));
    jQuery("#total_amount").val(n)
}
function notifyBlock1() {
    jQuery(".notice").css("display", "none");
    jQuery("#notify1").css("display", "block");
    jQuery("#notify1").animate({opacity: 0}, 200, "linear", function () {
        jQuery(this).animate({opacity: 1}, 200)
    });
    notify2 = window.setInterval(notifyBlock2, 1e4);
    window.clearInterval(notify1)
}
function notifyBlock2() {
    jQuery(".notice").css("display", "none");
    jQuery("#notify2").css("display", "block");
    jQuery("#notify2").animate({opacity: 0}, 200, "linear", function () {
        jQuery(this).animate({opacity: 1}, 200)
    });
    notify3 = window.setInterval(notifyBlock3, 1e4);
    window.clearInterval(notify2)
}
function notifyBlock3() {
    jQuery(".notice").css("display", "none");
    jQuery("#notify3").css("display", "block");
    jQuery("#notify3").animate({opacity: 0}, 200, "linear", function () {
        jQuery(this).animate({opacity: 1}, 200)
    });
    notify4 = window.setInterval(notifyBlock4, 1e4);
    window.clearInterval(notify3)
}
function notifyBlock4() {
    jQuery(".notice").css("display", "none");
    jQuery("#notify4").css("display", "block");
    jQuery("#notify4").animate({opacity: 0}, 200, "linear", function () {
        jQuery(this).animate({opacity: 1}, 200)
    });
    notify5 = window.setInterval(notifyBlock5, 1e4);
    window.clearInterval(notify4)
}
function notifyBlock5() {
    jQuery(".notice").css("display", "none");
    jQuery("#notify5").css("display", "block");
    jQuery("#notify5").animate({opacity: 0}, 200, "linear", function () {
        jQuery(this).animate({opacity: 1}, 200)
    });
    notify1 = window.setInterval(notifyBlock1, 1e4);
    window.clearInterval(notify5)
}
function hiddenProductViaResolutionQ(e) {
    var t = jQuery(window).width();
    if (t < 1024) {
        jQuery("." + e).css("width", "200px")
    }
    if (t < 1135) {
        jQuery("." + e).css("width", "456px")
    }
    if (t >= 1135 && t < 1280) {
        jQuery("." + e).css("width", "558px")
    }
    if (t >= 1280 && t < 1330) {
    }
    if (t >= 1330 && t < 1500) {
    }
    if (t > 1500) {
    }
}
function hiddenProductViaResolution(e) {
    var t = jQuery(window).width();
    if (t <= 1024) {
        jQuery("." + e + " .width_3").each(function (e) {
            jQuery(this).css("width", "33%");
            if (e >= 3) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t >= 1024 && t < 1280) {
        jQuery("." + e + " .width_3").each(function (e) {
            jQuery(this).css("width", "24%");
            if (e >= 4) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t >= 1280 && t < 1330) {
        jQuery("." + e + " .width_3").each(function (e) {
            jQuery(this).css("width", "25%");
            if (e >= 4) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t >= 1330 && t < 1500) {
        jQuery("." + e + " .width_3").each(function (e) {
            jQuery(this).css("width", "19%");
            if (e >= 5) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t > 1500) {
        jQuery("." + e + " .width_3").each(function (e) {
            jQuery(this).css("width", "16%");
            jQuery(this).css("display", "block")
        })
    }
}
function hiddenProductViaResolutionCategory(e) {
    var t = jQuery(window).width();
    if (t <= 1024) {
        jQuery("." + e + " .showbox_1").each(function (e) {
            jQuery(this).css("width", "30%");
            if (e >= 12) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t >= 1024 && t < 1280) {
        jQuery("." + e + " .showbox_1").each(function (e) {
            jQuery(this).css("width", "22.3%");
            jQuery(this).css("margin-right", "8px");
            if (e >= 16) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t >= 1280 && t < 1330) {
        jQuery("." + e + " .showbox_1").each(function (e) {
            jQuery(this).css("width", "22.5%");
            if (e >= 16) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t >= 1330 && t < 1500) {
        jQuery("." + e + " .showbox_1").each(function (e) {
            jQuery(this).css("width", "18.1%");
            if (e >= 20) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t > 1500) {
        jQuery("." + e + " .showbox_1").each(function (e) {
            jQuery(this).css("width", "15%");
            jQuery(this).css("margin-right", "15px");
            if (e >= 24) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
}
function hiddenProductViaResolutionCategoryDetail(e) {
    var t = jQuery(window).width();
    if (t <= 1024) {
        jQuery("." + e + " .showbox_1").each(function (e) {
            jQuery(this).css("width", "25%");
            if (e >= 6) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t >= 1024 && t < 1280) {
        jQuery("." + e + " .showbox_1").each(function (e) {
            jQuery(this).css("width", "22.3%");
            jQuery(this).css("margin-right", "8px");
            if (e >= 8) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t >= 1280 && t < 1330) {
        jQuery("." + e + " .showbox_1").each(function (e) {
            jQuery(this).css("width", "22.5%");
            if (e >= 8) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t >= 1330 && t < 1500) {
        jQuery("." + e + " .showbox_1").each(function (e) {
            jQuery(this).css("width", "18.1%");
            if (e >= 10) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t > 1500) {
        jQuery("." + e + " .showbox_1").each(function (e) {
            jQuery(this).css("width", "15%");
            jQuery(this).css("margin-right", "15px");
            if (e >= 12) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
}
function hiddenProductViaResolutionId(e) {
    var t = jQuery(window).width();
    if (t <= 1024) {
        jQuery("#" + e + " .width_3").each(function (e) {
            jQuery(this).css("width", "33%");
            if (e >= 3) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t >= 1024 && t < 1280) {
        jQuery("#" + e + " .width_3").each(function (e) {
            jQuery(this).css("width", "24%");
            if (e >= 4) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t >= 1280 && t < 1330) {
        jQuery("#" + e + " .width_3").each(function (e) {
            jQuery(this).css("width", "25%");
            if (e >= 4) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t >= 1330 && t < 1500) {
        jQuery("#" + e + " .width_3").each(function (e) {
            jQuery(this).css("width", "19%");
            if (e >= 5) {
                jQuery(this).css("display", "none")
            } else {
                jQuery(this).css("display", "block")
            }
        })
    }
    if (t > 1500) {
        jQuery("#" + e + " .width_3").each(function (e) {
            jQuery(this).css("width", "16%");
            jQuery(this).css("display", "block")
        })
    }
}
function resizeSlideshowViaResolution() {
    var e = jQuery(window).width();
    if (e <= 1024) {
    }
}
function mySearch(e, t) {
    if (e == 1) {
        product_name = "";
        if (document.getElementById("singleBirdRemote").value != "")product_name = document.getElementById("singleBirdRemote").value;
        category = "";
        if (document.getElementById("category_quick_search").value != "") {
            category = "cat/" + document.getElementById("category_quick_search").value + "/"
        }
        window.location = t + "search/product/name/" + product_name + "/" + category
    }
    if (e == 2) {
        ads_name = document.getElementById("singleBirdRemote").value;
        category = "";
        if (document.getElementById("category_quick_search").value != "") {
            category = "cat/" + document.getElementById("category_quick_search").value + "/"
        }
        window.location = t + "search/raovat/title/" + ads_name + "/" + category
    }
}
function qSearch(e) {
    if (document.getElementById("singleBirdRemote").value == "") {
        alert("Bạn phải gõ từ khóa tìm kiếm")
    } else {
        if (document.getElementById("category_quick_search_q").value == "product") {
            product_name = "";
            if (document.getElementById("singleBirdRemote").value != "")product_name = document.getElementById("singleBirdRemote").value;
            $("#formsearch_home").submit();
        }
        if (document.getElementById("category_quick_search_q").value == "raovat") {
            ads_name = document.getElementById("singleBirdRemote").value;
            window.location = e + "search/raovat/title/" + ads_name
        }
        if (document.getElementById("category_quick_search_q").value == "shop") {
            shop_name = document.getElementById("singleBirdRemote").value;
            window.location = e + "search/shop/name/" + shop_name
        }
        if (document.getElementById("category_quick_search_q").value == "hoidap") {
            shop_name = document.getElementById("singleBirdRemote").value;
            window.location = e + "search/hoidap/name/" + shop_name
        }
        if (document.getElementById("category_quick_search_q").value == "timviec") {
            job_name = document.getElementById("singleBirdRemote").value;
            window.location = e + "search/employ/title/" + job_name
        }
        if (document.getElementById("category_quick_search_q").value == "tuyendung") {
            employ_name = document.getElementById("singleBirdRemote").value;
            window.location = e + "search/job/title/" + employ_name
        }
    }
}
function setValChk(e) {
    if (jQuery("#" + e).attr("checked")) {
        jQuery("#" + e).val(1)
    } else {
        jQuery("#" + e).val(0)
    }
}
function tooltipPicture(e, t) {
    jQuery(e).tooltip({
        delay: 100, bodyHandler: function () {
            width = 350;
            height = 350;
            if (typeof jQuery(this).attr("tooltipWidth") != "undefined") {
                width = parseInt(jQuery(this).attr("tooltipWidth"))
            }
            if (typeof jQuery(this).attr("tooltipHeight") != "undefined") {
                height = parseInt(jQuery(this).attr("tooltipHeight"))
            }
            jQuery("#tooltip").css("width", width + "px");
            picturePath = jQuery("#image-" + t).val();
            strReturn = "";
            strReturn += '<div class="name">' + jQuery("#name-" + t).val() + "</div>";
            strReturn += '<div class="margin">Giá:<b class="price">' + jQuery("#price-" + t).text() + "</b>    (Lượt xem: " + jQuery("#view-" + t).val() + ")</div>";
            strReturn += '<div class="margin">Tại gian hàng:<b><span class="company">' + jQuery("#shop-" + t).val() + "</b></div>";
            strReturn += '<div class="margin">Vị trí:<b>' + jQuery("#pos-" + t).val() + "</b></div>";
            strReturn += '<div class="margin">Bình chọn:<b>' + jQuery("#danhgia-" + t).html() + "</b></div>";
            strReturn += '<div class="picture_only">' + resizeImageSrc(picturePath, jQuery(this).width(), jQuery(this).height(), width, height) + "</div>";
            return strReturn
        }, track: true, showURL: false, extraClass: "tooltip_product"
    })
}
function resizeImageSrc(e, t, n, r, i) {
    opts = {resizeLess: true, html: ""};
    args = resizeImageSrc.arguments;
    if (typeof args[5] != "undefined")jQuery.extend(opts, args[5]);
    if (opts.resizeLess == true || t > r || n > i) {
        ratio = r / t;
        t = r;
        n = n * ratio;
        if (n > i) {
            ratio = i / n;
            n = i;
            t = t * ratio
        }
    }
    return '<img src="' + e + '" width="' + parseInt(t) + '" height="' + parseInt(n) + '" ' + opts.html + "/>"
}
function tooltipPictureUser(e, t) {
    jQuery(e).tooltip({
        delay: 100, bodyHandler: function () {
            width = 350;
            height = 350;
            if (typeof jQuery(this).attr("tooltipWidth") != "undefined") {
                width = parseInt(jQuery(this).attr("tooltipWidth"))
            }
            if (typeof jQuery(this).attr("tooltipHeight") != "undefined") {
                height = parseInt(jQuery(this).attr("tooltipHeight"))
            }
            jQuery("#tooltip").css("width", width + "px");
            picturePath = jQuery("#image-" + t).val();
            strReturn = "";
            strReturn += '<div stle="clear:both" class="name" >' + jQuery("#user-" + t).val() + "</div>";
            strReturn += '<div class="picture_only" style="float:left">' + resizeImageSrc(picturePath, jQuery(this).width(), jQuery(this).height(), 120, 120) + "</div>";
            strReturn += ' <div style="float:left; padding-left:20px;"> ';
            strReturn += '<div class="margin"><b>Họ và tên : </b><span class="company"> ' + jQuery("#name-" + t).val() + "</span></div>";
            strReturn += '<div class="margin"><b>Ngày tham gia : </b><span class="company"> ' + jQuery("#ngaythamgia-" + t).val() + "</span></div>";
            strReturn += '<div class="margin"><b>Sản phẩm : </b><span class="company"> ' + jQuery("#sanpham-" + t).val() + "</div>";
            strReturn += '<div class="margin"><b> Rao vặt : </b><span class="company"> ' + jQuery("#raovat-" + t).val() + "</div> ";
            strReturn += '<div class="margin"><b> Hỏi đáp : </b><span class="company"> ' + jQuery("#hoidap-" + t).val() + "</div>";
            strReturn += '<div class="margin"><b> Trả lời : </b><span class="company"> ' + jQuery("#traloi-" + t).val() + "</div> </div>";
            return strReturn
        }, track: true, showURL: false, extraClass: "tooltip_product"
    })
}
function tooltipPictureHoidap(e, t) {
    jQuery(e).tooltip({
        delay: 100, bodyHandler: function () {
            width = 350;
            height = 350;
            if (typeof jQuery(this).attr("tooltipWidth") != "undefined") {
                width = parseInt(jQuery(this).attr("tooltipWidth"))
            }
            if (typeof jQuery(this).attr("tooltipHeight") != "undefined") {
                height = parseInt(jQuery(this).attr("tooltipHeight"))
            }
            jQuery("#tooltip").css("width", width + "px");
            picturePath = jQuery("#image-" + t).val();
            strReturn = "";
            strReturn += '<div class="name">' + jQuery("#title-" + t).val() + "</div>";
            strReturn += '<div class="margin">' + jQuery("#thongtinrutgon-" + t).val() + "</div>";
            return strReturn
        }, track: true, showURL: false, extraClass: "tooltip_product"
    })
}
function check_hoidap(e, t, n) {
    jQuery("#hd_category_id").val("");
    if (t == 0) {
        jQuery("#hoidap_1").css("display", "none");
        jQuery("#hoidap_2").css("display", "none")
    }
    if (t == 1) {
        jQuery("#hoidap_2").css("display", "none")
    }
    jQuery.ajax({
        type: "POST", url: n + "hoidap/ajax", data: "parent_id=" + e, dataType: "json", success: function (r) {
            if (r[1] > 0) {
                str = '<select id="hd_select_' + parseInt(t + 1) + '" class="form_control_hoidap_select" onclick="check_hoidap(this.value, ' + parseInt(t + 1) + ", '" + n + '\')" >';
                for (i = 0; i < r[1]; i++) {
                    str += '<option value="' + r[0][i].cat_id + '">' + r[0][i].cat_name;
                    if (r[0][i].child_count > 0) {
                        str += " >"
                    }
                    str += "</option>"
                }
                str += "</select>";
                jQuery("#hoidap_" + parseInt(t + 1)).html(str);
                jQuery("#hoidap_" + parseInt(t + 1)).css("display", "inline")
            } else {
                jQuery("#hd_category_id").val(e)
            }
        }, error: function () {
            alert("No Data!")
        }
    })
}

function check_postCategoryProduct(type,e, t, n) {
    jQuery("#hd_category_id").val("");    
    if (t == 0) {
        $('#fee_cate').text('0');
        jQuery("#cat_pro_1").remove();
        jQuery("#cat_pro_2").remove();
        jQuery("#cat_pro_3").remove();
        jQuery("#cat_pro_4").remove();
    }
    if (t == 1) {
        $('#fee_cate').text($('#cat_pro_'+t).children('option:selected').data('value'));
        jQuery("#cat_pro_2").remove();
        jQuery("#cat_pro_3").remove();
        jQuery("#ccat_pro_4").remove();
    }
    if (t == 2) {
        jQuery("#cat_pro_3").remove();
        jQuery("#cat_pro_4").remove();
    }
    if (t == 3) {
        jQuery("#cat_pro_4").remove();
    }
    if (e == 0) {
        return false;
    }
    jQuery.ajax({
        type: "POST",
        url: n + "product/ajax",
        data: "parent_id=" + e,
        dataType: "json",
        success: function (r) {
            // console.log(r);
            if (r[1] > 0) {
                str = '<select id="cat_pro_' + parseInt(t + 1) + '" name="cat_pro_' + parseInt(t + 1) + '" class="form-control form_control_cat_select cat_level" onchange="check_postCategoryProduct('+"'"+type+"'"+',this.value, ' + parseInt(t + 1) + ", '" + n + '\') ">';
                str += '<option selected = "selected" value="0">--Chọn danh mục cho '+ type +'--</option>';
                for (i = 0; i < r[1]; i++) {
                    jQuery("#hd_category_id").val(r[0][i].cat_id);
                    str += '<option  value="' + r[0][i].cat_id + '" data-value="' + r[0][i].b2c_fee + '">' + r[0][i].cat_name;
                    if (r[0][i].child_count > 0) {
                        str += " >"
                    }
                    str += "</option>"
                }
                str += "</select>";
                jQuery("#category_pro_" + parseInt(t + 1)).html(str);                           
            } else {
                jQuery("#hd_category_id").val(e)
            }
        },
        error: function () {
            alert("No Data!")
        }
    })
}

function check_postCategoryRaovat(e, t, n) {
    jQuery("#hd_category_id").val("");
    if (t == 0) {
        jQuery("#hoidap_1").css("display", "none");
        jQuery("#hoidap_2").css("display", "none")
    }
    if (t == 1) {
        jQuery("#hoidap_2").css("display", "none")
    }
    jQuery.ajax({
        type: "POST", url: n + "raovat/ajax", data: "parent_id=" + e, dataType: "json", success: function (r) {
            if (r[1] > 0) {
                str = '<select id="hd_select_' + parseInt(t + 1) + '" class="form_control_hoidap_select" onclick="check_postCategoryRaovat(this.value, ' + parseInt(t + 1) + ", '" + n + '\')  " >';
                for (i = 0; i < r[1]; i++) {
                    str += '<option value="' + r[0][i].cat_id + '">' + r[0][i].cat_name;
                    if (r[0][i].child_count > 0) {
                        str += " >"
                    }
                    str += "</option>"
                }
                str += "</select>";
                jQuery("#hoidap_" + parseInt(t + 1)).html(str);
                jQuery("#hoidap_" + parseInt(t + 1)).css("display", "inline")
            } else {
                jQuery("#hd_category_id").val(e)
            }
        }, error: function () {
            alert("No Data!")
        }
    })
}

function check_edit_gian_hang_cate(e, t, n) {
    jQuery("#hd_category_id").val("");
    if (t == 0) {
        jQuery("#hoidap_1").css("display", "none");
        jQuery("#hoidap_2").css("display", "none")
    }
    if (t == 1) {
        jQuery("#hoidap_2").css("display", "none")
    }
    jQuery.ajax({
        type: "POST",
        url: n + "account/ajax_category_shop",
        data: "parent_id=" + e,
        dataType: "json",
        success: function (r) {
            if (r[1] > 0) {
                str = '<select id="hd_select_' + parseInt(t + 1) + '" class="form_control_hoidap_select" onclick="   check_edit_gian_hang_cate(this.value, ' + parseInt(t + 1) + ", '" + n + '\')  " size="14" onblur="getManAndCategory4Search(\'' + n + '\');" style="width:170px">';
                for (i = 0; i < r[1]; i++) {
                    str += '<option value="' + r[0][i].cat_id + '">' + r[0][i].cat_name;
                    if (r[0][i].child_count > 0) {
                        str += " >"
                    }
                    str += "</option>"
                }
                str += "</select>";
                jQuery("#hoidap_" + parseInt(t + 1)).html(str);
                jQuery("#hoidap_" + parseInt(t + 1)).css("display", "inline")
            } else {
                jQuery("#hd_category_id").val(e)
            }
        },
        error: function () {
        }
    })
}
function check_edit_gian_hang_cate_dang_ky(e, t, n) {
    jQuery("#hd_category_id").val("");
    if (t == 0) {
        jQuery("#hoidap_1").css("display", "none");
        jQuery("#hoidap_2").css("display", "none")
    }
    if (t == 1) {
        jQuery("#hoidap_2").css("display", "none")
    }
    jQuery.ajax({
        type: "POST",
        url: n + "register/ajax_category_shop",
        data: "parent_id=" + e,
        dataType: "json",
        success: function (r) {
            if (r[1] > 0) {
                str = '<select id="hd_select_' + parseInt(t + 1) + '" class="form_control_hoidap_select" onclick="check_edit_gian_hang_cate_dang_ky(this.value, ' + parseInt(t + 1) + ", '" + n + '\')  " size="14" onblur="getManAndCategory4Search(\'' + n + '\');" style="width:170px">';
                for (i = 0; i < r[1]; i++) {
                    str += '<option value="' + r[0][i].cat_id + '">' + r[0][i].cat_name;
                    if (r[0][i].child_count > 0) {
                        str += " >"
                    }
                    str += "</option>"
                }
                str += "</select>";
                jQuery("#hoidap_" + parseInt(t + 1)).html(str);
                jQuery("#hoidap_" + parseInt(t + 1)).css("display", "inline")
            } else {
                jQuery("#hd_category_id").val(e)
            }
        },
        error: function () {
            alert("No Data!")
        }
    })
}
function getManAndCategory4Search_edit(e) {
    CategoryKeyWord = document.getElementById("category_pro_edit").value;
    jQuery("#hd_category_id").val(CategoryKeyWord);
    if (CategoryKeyWord != "") {
        jQuery.ajax({
            type: "POST",
            url: e + "ajax_mancatego",
            data: "selCate=" + CategoryKeyWord,
            success: function (e) {
                if (e != "") {
                    jQuery("#mannufacurer_pro").append(e)
                } else {
                    jQuery("#manafacture_khac").css("display", "block")
                }
                jQuery("#mannufacurer_pro option[value='khac']").each(function () {
                    jQuery(this).remove()
                });
                jQuery("#mannufacurer_pro").append('<option value="khac" >Khác</option>')
            },
            error: function () {
            }
        })
    }
}
function isValidURL(e) {
    var t = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
    if (t.test(e)) {
        return true
    } else {
        return false
    }
}
function deleteEye(e, t) {
    jQuery.post(t + "eye/delete", {id: e}, function (t) {
        if (t == "0") {
            jQuery("#k_item_" + e).css("display", "block")
        }
        if (t == "1") {
            jQuery("#k_item_" + e).css("display", "none")
        }
    })
}
function deleteEyeNoLogin(e, t, n) {
    jQuery.post(n + "eye/deletenologin", {id: t, type: e}, function (n) {
        if (n == "0") {
            jQuery("#k_item_" + e + "_" + t).css("display", "block")
        }
        if (n == "1") {
            jQuery("#k_item_" + e + "_" + t).css("display", "none")
        }
    })
}
function deleteAllEyeType(e, t) {
    jQuery.post(t + "eye/delete_all", {type: e}, function (t) {
        if (t == "0") {
        }
        if (t == "1") {
            if (e == "1") {
                jQuery("#k_sanphamdaxem").html('<h3 class="nodata">Không có dữ liệu</h3>')
            }
            if (e == "2") {
                jQuery("#k_raovatdaxem").html('<h3 class="nodata">Không có dữ liệu</h3>')
            }
            if (e == "3") {
                jQuery("#k_hoidapdaxem").html('<h3 class="nodata">Không có dữ liệu</h3>')
            }
            alert("Xóa thành công!")
        }
    })
}
function deleteAllEyeTypeNoLogin(e, t) {
    jQuery.post(t + "eye/delete_all_no_login", {type: e}, function (t) {
        if (t == "0") {
        }
        if (t == "1") {
            if (e == "1") {
                jQuery("#k_sanphamdaxem").html('<h3 class="nodata">Không có dữ liệu</h3>')
            }
            if (e == "2") {
                jQuery("#k_raovatdaxem").html('<h3 class="nodata">Không có dữ liệu</h3>')
            }
            if (e == "3") {
                jQuery("#k_hoidapdaxem").html('<h3 class="nodata">Không có dữ liệu</h3>')
            }
            alert("Xóa thành công!")
        }
    })
}
function tooltipShopType(e) {
    jQuery(e).tooltip({
        delay: 100, bodyHandler: function () {
            width = 500;
            height = 350;
            if (typeof jQuery(this).attr("tooltipWidth") != "undefined") {
                width = parseInt(jQuery(this).attr("tooltipWidth"))
            }
            if (typeof jQuery(this).attr("tooltipHeight") != "undefined") {
                height = parseInt(jQuery(this).attr("tooltipHeight"))
            }
            jQuery("#tooltip").css("width", width + "px");
            strReturn = jQuery("#k_messagecontent").html();
            return strReturn
        }, track: true, showURL: false, extraClass: "tooltip_product"
    })
}
function resetBrowesIimgQ_shop(e) {
    jQuery("#" + e).val("");
}
function resetBrowesIimgQ(e, n) {
    jQuery("#" + e).val("");
    var img_name = jQuery("#nameImage_" + n).val();    
    ajax_delete_image(img_name, n);
}
function resetBrowesIimgQ_qc(e, n) {
    var img_name = jQuery("#rqc_image_" + n).val();
    ajax_delete_image_qc(img_name, n);
}
function ajax_delete_image(img_name, n) {
    var pro_dir = "";
    if (($('#pro_dir')[0]) && ($('input#pro_dir').val() != "")) {
        pro_dir = $("#pro_dir").val();
    }

    jQuery.ajax({
        type: "POST",
        dataType: "text",
        url: "/product/ajax_delete_image",
        data: {name_pic: img_name, num: n, pro_dir: pro_dir},
        success: function (ret_data) {
            console.log(ret_data);
            if (ret_data == "1") {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Xóa ảnh thành công!',
                    'theme': 'blue',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                            jQuery("#nameImage_" + n).val("");
                            jQuery("#photo_container_" + n + " img").attr("src", function () {
                                return "";
                            });
                            jQuery("#photo_container_" + n + " img").addClass('hidden');
                            jQuery("#image_" + n + "_pro").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
        },
        error: function () {
            alert('Xóa hình không thành công!!')
        }
    });
}

function ajax_delete_image_qc(img_name, n) {
    var pro_dir = "";
    if (($('#pro_dir')[0]) && ($('input#pro_dir').val() != "")) {
        pro_dir = $("#pro_dir").val();
    }
    jQuery.ajax({
        type: "POST",
        dataType: "text",
        url: "/product/ajax_delete_image_qc",
        data: {name_pic: img_name, num: n, pro_dir: pro_dir},
        success: function (ret_data_qc) {
            if (ret_data_qc == "1") {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Xóa ảnh thành công!',
                    'theme': 'blue',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e) {
                            e.preventDefault();
                            jQuery("#rqc_image_" + n).val("");
                            jQuery("#container_show_" + n + " img").attr("src", function () {
                                return "";
                            });
                            jQuery("#container_show_" + n + " img").addClass('hidden');
                            jQuery("#btn_cancel_" + n).addClass('hidden');
                            jQuery("#sp_upload_" + n).removeClass('hidden');
                            return false;
                        }
                    }
                });
                $('.closejAlert').css('display','none');
                return false;
            }
        },
        error: function () {
            alert('Xóa hình không thành công!!');
        }
    });
}

function check_link_shopq(e, t, n) {
    jQuery.ajax({
        type: "POST",
        url: e + "kiem_tra_link_shop",
        data: "tenlink=" + t + "&idUser=" + n,
        success: function (e) {
            if (e != "") {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Link vào xem gian hàng của bạn đã bị trùng với gian hàng khác, vui lòng nhập link khác!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            jQuery("#link_shop").val("");
                            jQuery("#link_shop").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
        },
        error: function () {
        }
    });
}

function slideshowHomePage() {
    var e = jQuery("#slideshowhomepage").html();
    var t = jQuery(window).width();
    if (t <= 1024) {
        var n = 480
    } else {
        var n = 560
    }
    var r = new simpleGallery({
        wrapperid: "simplegallery2",
        dimensions: [n, 230],
        imagearray: [e],
        autoplay: [true, 1, 1e3],
        persist: true,
        fadeduration: 3e3,
        oninit: function () {
        },
        onslide: function (e, t) {
        }
    })
}
function hideddrivetip() {
}
jQuery(document).ready(function () {
    var e = jQuery(window).width();
    if (e <= 1024) {
        jQuery(".fast-link-center div").css("width", "230px");
        jQuery(".fast-link-center").css("width", "950px");
        jQuery(".footer").css("width", "950px")
    }
    if (e <= 1024) {
        jQuery("#divAdRight").css("display", "none");
        jQuery("#divAdLeft").css("display", "none")
    }
    if (e >= 1024 && e < 1180) {
        jQuery("#divAdRight").css("display", "none");
        jQuery("#divAdLeft").css("display", "none")
    }
    if (e >= 1180 && e < 1330) {
        jQuery("#divAdRight").css("right", "0");
        jQuery("#divAdLeft").css("left", "0");
        jQuery("#divAdRight").css("display", "block");
        jQuery("#divAdLeft").css("display", "block")
    }
    if (e >= 1330 && e < 1500) {
        jQuery("#divAdRight").css("margin-left", "990px");
        jQuery("#divAdLeft").css("margin-left", "-155px");
        jQuery("#divAdRight").css("display", "block");
        jQuery("#divAdLeft").css("display", "block")
    }
    if (e > 1500) {
        jQuery("#divAdRight").css("right", "150px");
        jQuery("#divAdLeft").css("left", "150px");
        jQuery("#divAdRight").css("display", "block");
        jQuery("#divAdLeft").css("display", "block")
    }
    jQuery(".chang_status_order").change(function () {
        var e = jQuery(this).attr("id");
        var t = jQuery(this).val();
        var n = jQuery("#baseUrl").val();
        jQuery.ajax({type: "POST", url: n + "account/ajax_update_order/" + e + "/" + t}).done(function (e) {
            alert("Trạng thái đã được lưu")
        })
    });
    jQuery("#bodysite").css("display", "block");
    jQuery(".simple_tip_login").hover(function () {
        jQuery(".hover_login").css("display", "block")
    }, function () {
        jQuery(".hover_login").css("display", "none")
    });
    jQuery(".hover_login").hover(function () {
        jQuery(".hover_login").css("display", "block")
    }, function () {
        jQuery(".hover_login").css("display", "none")
    });
    jQuery("#username-menu").hover(function () {
        jQuery("#infouser").css("display", "block")
    }, function () {
        jQuery("#infouser").css("display", "none")
    });
    hiddenProductViaResolutionQ("liveShow_home_Q");
    hiddenProductViaResolutionQ("homecenterQ");
    jQuery("#infouser").hover(function () {
        jQuery("#infouser").css("display", "block")
    }, function () {
        jQuery("#infouser").css("display", "none")
    });
    jQuery("#navShopAllButtonCustom").hover(function () {
        if (jQuery("#inner_menu").css("display") == "none") {
            jQuery("#inner_menu").slideDown("slow")
        }
    }, function () {
        jQuery("#inner_menu").css("display", "none")
    });
    jQuery("#inner_menu").hover(function () {
        if (jQuery("#inner_menu").css("display") == "none") {
            jQuery("#inner_menu").slideDown("slow")
        }
    }, function () {
        jQuery("#inner_menu").css("display", "none")
    });
    jQuery("#k_hotro").hover(function () {
        jQuery("#k_hotroappend").append(jQuery("#k_hotrocontent"));
        jQuery("#k_hotrocontent").css("display", "block")
    }, function () {
        jQuery("#k_hotrocontent").css("display", "none")
    });
    jQuery("#k_eye").hover(function () {
        jQuery("#k_eyeappend").append(jQuery("#k_eyecontent"));
        jQuery("#k_eyecontent").css("display", "block")
    }, function () {
        jQuery("#k_eyecontent").css("display", "none")
    });
    jQuery("#k_hotrocontent").hover(function () {
        jQuery("#k_hotrocontent").css("display", "block")
    }, function () {
        jQuery("#k_hotrocontent").delay(1e3).css("display", "none")
    });
    jQuery("#k_eyecontent").hover(function () {
        jQuery("#k_eyecontent").css("display", "block")
    }, function () {
        jQuery("#k_eyecontent").delay(1e3).css("display", "none")
    });
    jQuery("#CategorysiteGlobal").hover(function () {
        jQuery(".CategorysiteGlobalConten").css("display", "block")
    }, function () {
        jQuery(".CategorysiteGlobalConten").css("display", "none")
    });
    jQuery(".CategorysiteGlobalConten").hover(function () {
        jQuery(".CategorysiteGlobalConten").css("display", "block")
    }, function () {
        jQuery(".CategorysiteGlobalConten").delay(1e3).css("display", "none")
    });
    jQuery("#CategorysiteGlobalRoot").hover(function () {
        jQuery(".CategorysiterootConten").css("display", "block")
    }, function () {
        jQuery(".CategorysiterootConten").css("display", "none")
    });
    jQuery("#sub_cateory_bgrum").hover(function () {
        jQuery(".sub_cateory_bgrum").css("display", "block")
    }, function () {
        jQuery(".sub_cateory_bgrum").delay(1e3).css("display", "none")
    });
    jQuery(".sub_cateory_bgrum").hover(function () {
        jQuery(".sub_cateory_bgrum").css("display", "block")
    }, function () {
        jQuery(".sub_cateory_bgrum").delay(1e3).css("display", "none")
    });
    jQuery(".CategorysiterootConten").hover(function () {
        jQuery(".CategorysiterootConten").css("display", "block")
    }, function () {
        jQuery(".CategorysiterootConten").delay(1e3).css("display", "none")
    });
    jQuery("#shop_glonal_conten_ho").hover(function () {
        jQuery(".shop_glonal_conten").css("display", "block")
    }, function () {
        jQuery(".shop_glonal_conten").css("display", "none")
    });
    jQuery(".shop_glonal_conten").hover(function () {
        jQuery(".shop_glonal_conten").css("display", "block")
    }, function () {
        jQuery(".CategorysiterootConten").delay(1e3).css("display", "none")
    });
    jQuery("#dhtmlpointer").css("display", "block");
    jQuery("#dhtmltooltip").css("display", "block");
    
	/*jQuery("#mega-1").dcVerticalMegaMenu();*/
    /*
	var t = false;
    jQuery(document).mousewheel(function (e, t) {
        var n = false;
        e = e ? e : window.event;
        n = e.ctrlKey;
        if (n) {
            var r = jQuery(window).width() - 200 - 320;
            jQuery("#container_content_center").css("width", "100%");
            hiddenProductViaResolution("list_product_noibac");
            hiddenProductViaResolution("list_product_firtcate");
            hiddenProductViaResolution("list_product_secondcate");
            hiddenProductViaResolution("list_product_cat3");
            hiddenProductViaResolution("list_product_cat4");
            hiddenProductViaResolution("list_product_cat5");
            hiddenProductViaResolution("list_product_cat6");
            hiddenProductViaResolutionQ("liveShow_home_Q");
            hiddenProductViaResolutionQ("homecenterQ");
            jQuery(".list_product .vote_block").each(function (e) {
                hiddenProductViaResolutionId(jQuery(this).attr("id"))
            });
            jQuery(".list_product .shop_block").each(function (e) {
                hiddenProductViaResolutionId(jQuery(this).attr("id"))
            })
        }
    });
	*/
    jQuery(document).keyup(function (e) {
        if (window.event) {
            key = window.event.keyCode;
            if (window.event.ctrlKey)t = true; else t = false
        } else {
            key = e.which;
            if (e.ctrlKey)t = true; else t = false
        }
        if (t) {
            if (key == 109 || key == 189 || key == 107 || key == 187 || key == 48) {
                var n = jQuery(window).width() - 200 - 320;
                hiddenProductViaResolution("list_product_noibac");
                hiddenProductViaResolution("list_product_firtcate");
                hiddenProductViaResolution("list_product_secondcate");
                hiddenProductViaResolutionQ("liveShow_home_Q");
                hiddenProductViaResolutionQ("homecenterQ");
                hiddenProductViaResolution("list_product_cat3");
                hiddenProductViaResolution("list_product_cat4");
                hiddenProductViaResolution("list_product_cat5");
                hiddenProductViaResolution("list_product_cat6");
                jQuery(".list_product .vote_block").each(function (e) {
                    hiddenProductViaResolutionId(jQuery(this).attr("id"))
                });
                jQuery(".list_product .shop_block").each(function (e) {
                    hiddenProductViaResolutionId(jQuery(this).attr("id"))
                })
            }
        }
    })
});
var rBlock = {
    SpecialChar: /['\'\"\\#~`<>;']/g,
    AllSpecialChar: /['@\'\"\\~<>;`&\/%$^*{}\[\]!|():?+=#']/g,
    NotNumbers: /[^\d]/g
};
var notify1 = "";
var notify2 = "";
var notify3 = "";
var notify4 = "";
var notify5 = "";
function updateQuantityProduct(baseUrl, productId, quantityProduct, id_input) {
    if (productId > 0) {
        console.log('ajax');
        jQuery.ajax({
            type: "POST",
            url: baseUrl + "showcart",
            data: "productId=" + productId + "&quantityProduct=" + quantityProduct,
            success: function (e) {
            },
            error: function () {
            },
        }).done(function (data) {
            SHOWCART_ORDER = jQuery.parseJSON(data);
            if (!data) {
                el = jQuery('#' + id_input).parent().children('.message-order').html('');
            } else {
                el = jQuery('#' + id_input).parent().children('.message-order').html(SHOWCART_ORDER.message);
                jQuery('#' + id_input).val(SHOWCART_ORDER.pro_instock);
            }
        })
    }
}
function slvcheckAll(item, id) {
    if ($(item).is(':checked')) {
        $('#' + id).find('input[name="checkone[]"]').prop('checked', true);
    } else {
        $('#' + id).find('input[name="checkone[]"]').prop('checked', false);
    }
}
function slvDeleteCart(form) {
    if ($('#' + form).find('input[name="checkone[]"]:checked').length >= 1) {
        $('#' + form).submit();
        console.log('===');
    }
}
function renderCartItem(cartlist) {
    var list = $('#cart ')
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
        }
    });
}
function wishlist(pro_id) {
    showLoading();
    $.ajax({
        type: "POST",
        dataType: "json",
        url: siteUrl + 'ajax/action/wishlist',
        data: $('#bt_' + pro_id + ' :input').serialize(),
        success: function (result) {
            var type = result.error == true ? 'alert-danger' : 'alert-success';
            showMessage(result.message, type);
        },
        error: function () {
        }
    });
}
function update_qty(pro_id, num) {
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

function checkOrderInput() {
    orderId = $('#order_id').val();
    orderEmail = $('#order_email').val();
    if (orderId == '') {
        alert("Vui lòng nhập mã đơn hàng!");
        return false;
    } else {
        if (!IsNumber(orderId)) {
            alert("Vui lòng nhập mã đơn hàng dạng số!");
            return false;
        }
    }
    if (orderEmail == '') {
        alert("Vui lòng nhập email!");
        return false;
    } else {
        if (!checkEmail(orderEmail)) {
            alert("Vui lòng nhập đúng định dạng email!");
            return false;
        }
    }
    return true;
}

function CheckInput_CommissionAff() {
    if (CheckBlank(document.getElementById("min").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập doanh số tối thiểu!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("min").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("max").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập doanh số tối đa!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("max").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (parseInt($("#min").value) > parseInt(document.getElementById("max").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Doanh số tối thiểu phải nhỏ hơn doanh số tối đa!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("min").focus();
                    return false;
                }
            }
        });
        return false;
    }
    document.frmCommissionAff.submit();
}

function xacnhanXoa(t,link){
    var id = $(t).attr('alt');
    confirm(function (e1, btn) {
        window.location = siteUrl + link;
    });
    return false;
}
 
function close_outside(rootdivhide,divhide){
    var $win = $(window);
    $win.on("click.Bst", function(event){		
       if ($(rootdivhide).has(event.target).length == 0 && !$(rootdivhide).is(event.target)){
            $(divhide).slideUp();
       }
    });
}

function CheckInput_Emp_Register() {
    var none_check = $('.none_member').css('display');
    var afstore = $('.afstore').css('display');
    if (none_check == 'block') {
        if (CheckBlank(document.getElementById("fullname_regis").value)) {
            alert("Bạn chưa nhập họ tên!");
            document.getElementById("fullname_regis").focus();
            return false
        }
    }
    if (CheckBlank(document.getElementById("password_regis").value)) {
        alert("Bạn chưa nhập mật khẩu!");
        document.getElementById("password_regis").focus();
        return false
    }
    var r = document.getElementById("password_regis").value;
    if (r.length < 6) {
        alert("Mật khẩu phải có ít nhất 6 ký tự!");
        document.getElementById("password_regis").focus();
        return false
    }
    if (CheckBlank(document.getElementById("email_regis").value)) {
        alert("Bạn chưa nhập email!");
        document.getElementById("email_regis").focus();
        return false
    }
    if (!CheckEmail(document.getElementById("email_regis").value)) {
        alert("Email bạn nhập không hợp lê!");
        document.getElementById("email_regis").focus();
        return false
    }
    if (CheckBlank(document.getElementById("mobile_regis").value)) {
        alert("Bạn chưa nhập số điện thoại!");
        document.getElementById("mobile_regis").focus();
        return false
    }
    if (afstore == "block") {
        if (CheckBlank(document.getElementById("idcard_regis").value)) {
            alert("Bạn chưa nhập số chứng minh nhân dân !");
            document.getElementById("idcard_regis").focus();
            return false
        } else {
            if (!IsNumber(document.getElementById("idcard_regis").value)) {
                alert("Số chứng minh nhân dân chỉ được phép nhập số !");
                document.getElementById("idcard_regis").focus();
                return false;
            }
        }
    }

    var c = document.getElementsByName('roles');
    var checked = 0;
    for(var i=0 ; i<c.length; c++)
    {
        if (c[i].checked)
        checked++;
    }
    if(checked < 0){
        return false;
    }
    
    if ($('#result').hasClass('short') || $('#result').hasClass('weak')) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Mật khẩu của bạn không bảo mật! Vui lòng chọn mật khẩu bảo mật hơn.',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("password_regis").focus();
                    return false;
                }
            }
        });
        return false
    }
    document.frmRegister.submit();
}

function CheckInput_Emp_Af_Register(uid) {

    if (CheckBlank(document.getElementById("fullname_regis").value)) {
        alert("Bạn chưa nhập họ tên!");
        document.getElementById("fullname_regis").focus();
        return false
    }
    if (CheckBlank(document.getElementById("mobile_regis").value)) {
        alert("Bạn chưa nhập số điện thoại!");
        document.getElementById("mobile_regis").focus();
        return false
    }
    if (CheckBlank(document.getElementById("password_regis").value)) {
        alert("Bạn chưa nhập mật khẩu!");
        document.getElementById("password_regis").focus();
        return false
    }
    var r = document.getElementById("password_regis").value;
    if (r.length < 6) {
        alert("Mật khẩu phải có ít nhất 6 ký tự!");
        document.getElementById("password_regis").focus();
        return false
    }
    if (CheckBlank(document.getElementById("email_regis").value)) {
        alert("Bạn chưa nhập email!");
        document.getElementById("email_regis").focus();
        return false
    }
    if (!CheckEmail(document.getElementById("email_regis").value)) {
        alert("Email bạn nhập không hợp lê!");
        document.getElementById("email_regis").focus();
        return false
    }
    
    if (CheckBlank(document.getElementById("idcard_regis").value)) {
        alert("Bạn chưa nhập số chứng minh nhân dân !");
        document.getElementById("idcard_regis").focus();
        return false
    } else {
        if (!IsNumber(document.getElementById("idcard_regis").value)) {
            alert("Số chứng minh nhân dân chỉ được phép nhập số !");
            document.getElementById("idcard_regis").focus();
            return false;
        }
    }
    if (CheckBlank(document.getElementById("user_province_get").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập Tỉnh thành!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("user_province_get").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("user_district_get").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập Tỉnh thành!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("user_district_get").focus();
                    return false;
                }
            }
        });
        return false;
    }

    if ($('#result').hasClass('short') || $('#result').hasClass('weak')) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Mật khẩu của bạn không bảo mật! Vui lòng chọn mật khẩu bảo mật hơn.',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("password_regis").focus();
                    return false;
                }
            }
        });
        return false
    }
    document.frmRegister.action = "/account/affiliate/empid/" + uid;
    document.frmRegister.submit();
}

function CheckInput_Emp_Branch_Register() {
    if (CheckBlank(document.getElementById("fullname_regis").value)) {
        alert("Bạn chưa nhập họ tên!");
        document.getElementById("fullname_regis").focus();
        return false
    }
    if (CheckBlank(document.getElementById("mobile_regis").value)) {
        alert("Bạn chưa nhập số điện thoại!");
        document.getElementById("mobile_regis").focus();
        return false
    }
    if (CheckBlank(document.getElementById("password_regis").value)) {
        alert("Bạn chưa nhập mật khẩu!");
        document.getElementById("password_regis").focus();
        return false
    }
    var r = document.getElementById("password_regis").value;
    if (r.length < 6) {
        alert("Mật khẩu phải có ít nhất 6 ký tự!");
        document.getElementById("password_regis").focus();
        return false
    }
    if (CheckBlank(document.getElementById("email_regis").value)) {
        alert("Bạn chưa nhập email!");
        document.getElementById("email_regis").focus();
        return false
    }
    if (!CheckEmail(document.getElementById("email_regis").value)) {
        alert("Email bạn nhập không hợp lê!");
        document.getElementById("email_regis").focus();
        return false
    }
    
    if (CheckBlank(document.getElementById("idcard_regis").value)) {
        alert("Bạn chưa nhập số chứng minh nhân dân !");
        document.getElementById("idcard_regis").focus();
        return false
    } else {
        if (!IsNumber(document.getElementById("idcard_regis").value)) {
            alert("Số chứng minh nhân dân chỉ được phép nhập số !");
            document.getElementById("idcard_regis").focus();
            return false;
        }
    }
    if (CheckBlank(document.getElementById("user_province_get").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập Tỉnh thành!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("user_province_get").focus();
                    return false;
                }
            }
        });
        return false;
    }
    if (CheckBlank(document.getElementById("user_district_get").value)) {
        $.jAlert({
            'title': 'Yêu cầu nhập',
            'content': 'Bạn chưa nhập Tỉnh thành!',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("user_district_get").focus();
                    return false;
                }
            }
        });
        return false;
    }

    if ($('#result').hasClass('short') || $('#result').hasClass('weak')) {
        $.jAlert({
            'title': 'Thông báo',
            'content': 'Mật khẩu của bạn không bảo mật! Vui lòng chọn mật khẩu bảo mật hơn.',
            'theme': 'default',
            'btns': {
                'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                    e.preventDefault();
                    document.getElementById("password_regis").focus();
                    return false;
                }
            }
        });
        return false
    }
    
    document.frmRegister.action = "/account/emp-addbranch";
    document.frmRegister.submit();
}

function check_Input_frmForgot() {
    if (CheckBlank(document.getElementById("password_regis").value)) {
        alert("Bạn chưa nhập mật khẩu!");
        document.getElementById("password_regis").focus();
        return false
    }
    var r = document.getElementById("password_regis").value;
    if (r.length < 6) {
        alert("Mật khẩu phải có ít nhất 6 ký tự!");
        document.getElementById("password_regis").focus();
        return false
    }
    document.frmForgot.action = "/home/forgot/forgotByPhone";
    document.frmForgot.submit();
}



/* 
*	JS for header registry
*
*/

function checkMobile(value, baseurl, el) {
    if (!CheckBlank($('#'+el).val())) {
        if (!CheckPhone($('#'+el).val())) {
            // $.jAlert({
            //     'title': 'Thông báo',
            //     'content': 'Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888 hoặc có mã nước phía trước VD: +849098888888',
            //     'theme': 'default',
            //     'btns': {
            //         'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
            //             e.preventDefault();
            //             $('#'+el).focus();
            //             $('#'+el).val('');
            //             return false;
            //         }
            //     }
            // });
            alert('Số điện thoại bạn nhập không hợp lệ!\nChỉ chấp nhận các số từ 0-9 và các ký tự . ( )\nVí dụ: (08).888888 hoặc 090.8888888 hoặc có mã nước phía trước VD: +849098888888');
            $('#'+el).focus();
            $('#'+el).val('');
            return false;
        } 
        // else {
        //     $.ajax({
        //         type: 'POST',
        //         url: baseurl + 'home/register/user_check_phone_number',
        //         data: {mobile: value},
        //         dataType: 'text',
        //         success: function (data) {                	
        //             if (data == '1') {
        //                 $.jAlert({
        //                     'title': 'Thông báo',
        //                     'content': 'Số điện thoại này đã có người sử dụng. Vui lòng kiểm tra lại và nhập số khác!',
        //                     'theme': 'default',
        //                     'btns': {
        //                         'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
        //                             e.preventDefault();
        //                             $('#'+el).val('');
        //                             $('#'+el).focus();
        //                             return false;
        //                         }
        //                     }
        //                 });                        
        //             } else {

        //             }
        //         },
        //         error: function () {
        //         }
        //     });
        // }
    }
}

function CheckBlank(e) {
    if (TrimInput(e) == "" || e == "") {
        return true
    } else {
        return false
    }
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

function comparePass(pass, repass) {
    if ($('#'+pass).val() != '' 
        && $('#'+repass).val() != '' 
        && $('#'+pass).val() != $('#'+repass).val()) {
        // $.jAlert({
        //     'title': 'Thông báo',
        //     'content': 'Xác nhận mật khẩu không đúng. Vui lòng kiểm tra lại!',
        //     'theme': 'default',
        //     'btns': {
        //         'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
        //             e.preventDefault();
        //             $('#'+repass).val('');
        //             $('#'+repass).focus();
        //             return false;
        //         }
        //     }
        // }); 
        alert('Xác nhận mật khẩu không đúng. Vui lòng kiểm tra lại!');        
        $('#'+repass).val('');
        $('#'+repass).focus();
        return false;      
    }
}
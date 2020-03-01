function validate(value, rule, messenger) {
    var rule_input = rule.split(":");
    if(rule_input.length > 1) {
        rule = rule_input[0];
        var parameter = rule_input[1];
    }
    var check_input = true;
    var error_msg = '';
    switch (rule) {
        case 'required' :
            if(value == null) {
                if(typeof messenger['required'] != 'undefined') {
                    error_msg = '<p>'+messenger['required']+'</p>';   
                }else {
                    error_msg = '<p>Trường này bắt buộc</p>';
                }
                break;
            }
            var len = value.length;
            if ( len == 0 ) {
                if(typeof messenger['required'] != 'undefined') {
                    error_msg = '<p>'+messenger['required']+'</p>';   
                }else {
                    error_msg = '<p>Trường này bắt buộc</p>';
                }
            }
            break;
        case 'max' :
            var len = value.length;
            if ( len > parameter ) {
                if(typeof messenger['max'] != 'undefined') {
                    error_msg = '<p>'+messenger['max']+'</br>';    
                }else {
                    error_msg = '<p>'+'Phải nhỏ hơn '+parameter+'ký tự </p>';
                }
            }
            break;
        case 'email':
            if ( value.length > 0 ) {
                var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                if (!testEmail.test(value)) {
                    if(typeof messenger['email'] != 'undefined') {
                        error_msg = '<p>'+messenger['email']+'</p>';  
                    }else {
                        error_msg = '<p>Định dạng email không đúng</p>';
                    }
                }
            }
            break;
        case 'telephone':
            var phone_expr = /[0-9]/g;
            if ( value.length > 0 ) {
                if (!phone_expr.test(value)) {
                    if(typeof messenger['telephone'] != 'undefined') {
                        error_msg = '<p>'+messenger['telephone']+'</p>';  
                    }else {
                        error_msg = '<p>Định dạng số điện thoại không đúng vui lòng thử lại</p>';
                    }
                }
            }
            break;
        case 'fax':
            var phone_expr = /^([0-9]){3}[-]([0-9]){4}[-]([0-9]){4}$/;
            if ( value.length > 0 ) {
                if (!phone_expr.test(value)) {
                    if(typeof messenger['fax'] != 'undefined') {
                        error_msg = '<p>'+messenger['fax']+'</p>';    
                    }else {
                        error_msg = '<p>Số fax không đúng</p>';
                    }
                }
            }
            break;
        case 'text':
            var len = value.length;
            if ( len > 255 ) {
                if(typeof messenger['text'] != 'undefined') {
                    error_msg = '<p>'+messenger['text']+'</p>';   
                }else {
                    error_msg = '<p>Chỉ được nhập text</p>';
                }
            }
            break;
        case 'date':
            var date_expr = /^((?!(00|13|14|15|16|17|18|19)))[0-1][0-9]\/(?!(00|32|33|34|35|36|37|38|39))[0-3][0-9]\/[1-2][0-9][0-9][0-9]$/;
            if (date_expr.test(value)) {
                var split = value.split('\/');
                switch (split[0]) {
                    case '02':
                    case '04':
                    case '06':
                    case '09':
                    case '11':
                        if (split[1] == 31) {
                            check_input = false;
                        }
                    case '02':
                        if ( split[1] == 30) {
                            check_input = false;
                        } else if ( split[2] % 4 != 0) {
                            if (split[1] == 29 )
                                check_input = false;
                        }
                        break;
                }
            } else {
                if(typeof messenger['date'] != 'undefined') {
                    error_msg ='<p>'+ messenger['date']+'</p>';   
                }else {
                    error_msg = '<p>Sai định dạng vui lòng thử lại</p>';
                }
            }
            break;
        case 'time':
            var time_expr = /^(?!(24|25|26|27|28|29))[0-2][0-9]:[0-5][0-9]$/;
            if (!time_expr.test(value)) {
                if(typeof messenger['time'] != 'undefined') {
                    error_msg = '<p>'+messenger['time']+'</p>';   
                }else {
                    error_msg = '<p>Không phải định dạng thời gian</p>';
                }
            }
            break;
            
        case 'number':
            var number_expr = /^[0-9]{1,10}$/;
            if (!number_expr.test(value) && value != '') {
                if(typeof messenger['number'] != 'undefined') {
                    error_msg = '<p>'+messenger['number']+'</p>'; 
                }else {
                    error_msg = '<p>Không phải là số</p>';
                }   
            }
            break;
        case 'url':
            var pattern = /(http|https):\/\/(\w+:{0,1}\w*)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%!\-\/]))?/;
            if(!pattern.test(value) && value != '') {
                if(typeof messenger['url'] != 'undefined') {
                    error_msg = '<p>'+messenger['url']+'</p>'; 
                }else {
                    error_msg = '<p>Không phải là url</p>';
                }
            }
            break;
        case 'bool':
            if(value == '' || value == 0) {
                if(typeof messenger['bool'] != 'undefined') {
                    error_msg = '<p>'+messenger['bool']+'</p>'; 
                }else {
                    error_msg = '<p>Mảng rỗng</p>';
                }
            }
            break;
        default:
            break;
    }
    if(error_msg != '')
    {
        return error_msg;
    }
    return '';
}

$(document).on('keyup', '.checknum', function() {

    var check = true;
    var data_check = [];
    var error_msg = [];

    data_check.push({'name':'checkmax','value':$(this).val()});



    var rule = {
        checkmax           : 'max:5|number'
    };
    var messenge = {
        checkmax   : {
            max         : 'Không được nhập lớn hơn 5 ký tự',
            number      : 'Vui lòng nhập số'
        }
    };

    $.each(data_check, function( key, value ) {
        var name = value.name;
        
        if(typeof rule[name] != 'undefined') {
            var rule_input = rule[name].split("|");
            var messenger = messenge[name];
            if(typeof messenger != 'undefined') {
                messenger = messenger;
            }
            else {
                messenger = '';
            }
            jQuery.each( rule_input, function( k, v ) {
                if(validate(value.value, v, messenger) != ''){
                    error_msg.push(validate(value.value, v, messenger));
                }
            });
        }
        
    });
    if(error_msg != ''){
        var error_msg_html = '<h2>THÔNG BÁO LỖI</h2>';
        error_msg_html +='<div class="error-msg-inner">';
            jQuery.each( error_msg, function( k, v ) {
                error_msg_html +=v;
            });
        error_msg_html +='</div>';

        $('#myError .content-icon-option').html(error_msg_html);
        openpopup('#myError');
        $(this).val($(this).val().slice(0,8));
    }
});

function showError(error) {
    var error_msg_html = '<h2>THÔNG BÁO LỖI</h2>';
    error_msg_html +='<div class="error-msg-inner">';
        error_msg_html += error;
    error_msg_html +='</div>';

    $('#myError .content-icon-option').html(error_msg_html);
    openpopup('#myError');
}
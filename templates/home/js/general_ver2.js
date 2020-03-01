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
    console.log("else");
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

function metadata_detect(id_video) {
	if('connection' in navigator){
        if(navigator.connection.saveData){
			let video = document.getElementById(id_video);
			video.setAttribute("preload","metadata");
			video.load();
        }
    }
}

function addCartQty(pro_id) {
    // showLoading();
    if($('#minsale').text() <= $('input#qty_' + pro_id).val()) {
        var dataPost = {
            'product_showcart' : pro_id,
            'qty' :  $('input#qty_' + pro_id).val(),
            'dp_color' : $('#dp_color .is-active').text(),
            'dp_meterial' : $('#dp_meterial .is-active').text(),
            'dp_size' : $('#dp_size .is-active').text(),
            'dp_id' : $('#dp_id').text(),
            'af_id' : $('#af_id').text()
        }
        var dataString = JSON.stringify(dataPost);
        
        $.ajax({
            dataType: "text",
            type: "POST",
            url: siteUrl + 'home/showcart/add_to_cart',
            data: {'data': dataString},
            // processData: false,
            success: function (result) {
                // console.log(result);
                result = JSON.parse(result);
                if (result.error == false) {
                    $('.cartNum').text(result.num);
                }
                var type = result.error == true ? 'alert-danger' : 'alert-success';
                $('#modal_mess').modal('show');
                $('#modal_mess .modal-body p').html(result.message);
                
                // showMessage(result.message, type);
            },
            error: function () {
                alert('error connect');
            }
        });   
    }
}

function buyNowQty(pro_id, pro_type) {
    var dataPost = {
        'product_showcart' : pro_id,
        'qty' :  $('input#qty_' + pro_id).val(),
        'dp_color' : $('#dp_color .is-active').text(),
        'dp_meterial' : $('#dp_meterial .is-active').text(),
        'dp_size' : $('#dp_size .is-active').text(),
        'dp_id' : $('#dp_id').text(),
        'af_id' : $('#af_id').text()
    }
    var dataString = JSON.stringify(dataPost);

    $.ajax({
        dataType: "text",
        type: "POST",
        url: siteUrl + 'home/showcart/add_to_cart',
        data: {'data': dataString},
        success: function (result) {
            result = JSON.parse(result);
            console.log(result);
            if (result.error == false) {
                if (typeof pro_type !== 'undefined') {
                    redirect = pro_type == 2 ? siteUrl + 'v-checkout/coupon'
                    : (pro_type == 0 ? siteUrl + 'v-checkout' : siteUrl + 'v-checkout');
                    // window.location = redirect;
                } else {
                    redirect = siteUrl + 'v-checkout';
                    // window.location = redirect;
                }
                window.location = redirect;
            } else {
                var type = result.error == true ? 'alert-danger' : 'alert-success';
                $('#modal_mess').modal('show');
                $('#modal_mess .modal-body p').text(result.message);
            }
        },
        error: function () {
        }
    });
}

function addCartQtyAtShop(pro_id) {
    // showLoading();
    var dataPost = {
        'product_showcart' : pro_id,
        'af_id' : $('#af_id').text()
    }
    var dataString = JSON.stringify(dataPost);
    
    $.ajax({
        dataType: "text",
        type: "POST",
        url: siteUrl + 'home/showcart/add_to_cart_by_attach',
        data: {'data': dataString},
        // processData: false,
        success: function (result) {
            result = JSON.parse(result);
            console.log(result);
            if (result.error == false) {
                $('.cartNum').text(result.num);
            }
            var type = result.error == true ? 'alert-danger' : 'alert-success';
            $('#dialog_mess').modal('show');
            $('#mess_detail').html('<p class="'+type+'">' + result.message + '</p>');
            
            
            // showMessage(result.message, type);
        },
        error: function () {
            alert('error connect');
        }
    });
}

function addCart(pro_id){
    $.ajax({
        type:"POST",
        dataType:"json",
        url:siteUrl+'showcart/add',
        data:$('#bt_'+pro_id+' :input').serialize(),
        success:function(result){
            // if(result.pro_type!=0&&result.error==false)
            // {
            //     location.href=siteUrl+'checkout/v2/'+result.pro_user+'/'+result.pro_type;
            // }
            if(result.error==false){
                $('.cartNum').text(result.num);
            }
            var type = result.error == true ? 'alert-danger' : 'alert-success';
            $('#dialog_mess').modal('show');
            $('#mess_detail').html('<p class="'+type+'">' + result.message + '</p>');
        },
        error:function(){}
    });
}

function report(){
    var frm = $('#frmReport');
    frm.submit(function (e) {
      e.preventDefault();
      $.ajax({
        type: frm.attr('method'),
        url: frm.attr('action'),
        data: frm.serialize(),
        success: function (data) {
          var mes = '';
          if (data == '0') {
            mes = 'Bạn đã gửi báo cáo cho sản phẩm này rồi. Cám ơn bạn!';
          } else if (data == '1') {
            mes = 'Gửi báo cáo sản phẩm thành công. Cảm ơn bạn!';
          }
          $.jAlert({
            'title': 'Thông báo',
            'content': mes,
            'theme': 'default',
            'btns': {
              'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                e.preventDefault();
                location.reload();
                return false;
              }
            }
          });
        },
        error: function (data) {
        }
      });
    });
}
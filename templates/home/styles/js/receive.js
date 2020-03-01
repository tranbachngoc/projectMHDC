function IsNumber(e) {
  var t = "0123456789";
  for (var n = 0; n < e.length; n++) {
    if (t.indexOf(e.charAt(n)) == -1) {
        return false
    }
  }
  return true
}

function checkEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

$(".js-receiver-other").change(function() {
    if(this.checked) {
      $('.show-receiver-other').removeClass('hidden');
    } else {
      $('.show-receiver-other').addClass('hidden');
    }
});


$('body').on('click','.addOrderaddress .btn-save-db', function (){
    var _this = '.addOrderaddress';
    $(_this+' p.note').html('');
    $(_this+' p.note_buy').html('');
    $('form.addOrderaddress').on('submit',function (e) {});

    if ($(_this +' input[name=receiver_other]').is(':checked')) 
    {
        if ($(_this+' input[name=name_buy]').val() == '' || $(_this+' input[name=name_buy]').val() == null) {
           $(_this+' p.note_buy').html('<span class="text-red">Bạn chưa nhập nhập họ tên người mua</span>');
           $(_this+' input[name=name_buy]').css('color','red');
           return false;
        }

        if ($(_this+' input[name=phone_buy]').val() == '' || $(_this+' input[name=phone_buy]').val().length > 10 || !IsNumber($(_this+' input[name=phone_buy]').val())){
            if ($(_this+' input[name=phone_buy]').val() == '') 
            {
              var mess = '<span class="text-red">Bạn chưa nhập số điện thoại người mua</span>';
            }
            else
            {
              var mess = '<span class="text-red">Số điện thoại hợp lệ chỉ gồm 10 số từ 0 đến 9</span>';
            }
           $(_this+' p.note_buy').html(mess);
           $(_this+' input[name=phone_buy]').css('color','red');
           return false;
        }
    }

    if ($(_this+' input[name=name]').val() == '' || $(_this+' input[name=name]').val() == null) {
       $(_this+' p.note').html('<span class="text-red">Bạn chưa nhập nhập họ tên người nhận</span>');
       $(_this+' input[name=name]').css('color','red');
       return false;
    }

    if ($(_this+' input[name=phone]').val() == '' || $(_this+' input[name=phone]').val().length > 10 || !IsNumber($(_this+' input[name=phone]').val())){
       if($(_this+' input[name=phone]').val() == '') {
          var mess = '<span class="text-red">Bạn chưa nhập số điện thoại</span>';
       }else{
          var mess = '<span class="text-red">Số điện thoại hợp lệ chỉ gồm 10 số từ 0 đến 9</span>';
       }
       $(_this+' p.note').html(mess);
       $(_this+' input[name=phone]').css('color','red');
       return false;
    }

    if (!checkEmail($(_this+' input[name=semail]').val()) && $.trim($(_this+' input[name=semail]').val()) != '') {
       mess = '<span class="text-red">Địa chỉ mail không hợp lệ</span>';
       $(_this+' p.note').html(mess);
       $(_this+' input[name=semail]').css('color','red');
       return false;
    }

    if ($(_this+' input[name=address]').val() == '') {
       $(_this+' p.note').html('<span class="text-red">Bạn chưa nhập địa chỉ nhận hàng</span>');
       $(_this+' input[name=address]').css('color','red');
       return false;
    }

    if ($(_this+' .js-province').val() == '') {
       $(_this+' p.note').html('<span class="text-red">Bạn chưa chọn tỉnh/thành phố</span>');
       $(_this+' .js-province').css('color','red');
       $(_this+' .js-province option').css('color','#000');
       return false;
    }

    if ($(_this+' .js-district').val() == '') {
       $(_this+' p.note').html('<span class="text-red">Bạn chưa chọn quận/huyện</span>');
       $(_this+' .js-district').css('color','red');
       $(_this+' .js-district option').css('color','#000');
       return false;
    }
    
    $('.load-wrapp').show();
    var form = $('form.addOrderaddress');
    $.ajax({
        type: "POST",
        url: '/home/checkout/add_address_case',
        dataType: 'json',
        data: form.serialize(),
        success: function(res) {
           if (res.sms_error == '') {
              $('.js-sms-verify-error').text('');
              if (res.case == 1) {
                  $('#phone-creat .phone_number').text(res.phone);
                  $('#phone-creat').modal('show');
              }
              else
              {
                  $('form.addOrderaddress').submit();
              }
           }
           else 
           {
              if ($(_this +' input[name=receiver_other]').is(':checked')) 
              {
                $(_this+' p.note_buy').html('<span class="text-red">'+res.sms_error+'</span>');
              }
              else 
              {
                $(_this+' p.note').html('<span class="text-red">'+res.sms_error+'</span>');
              }
              
           }
        },
        error: function(res) {
          $('#modal_mess').modal('show');
          $('#modal_mess .modal-body p').html('Kết nối lỗi');
        }
    }).always(function() {
        $('.load-wrapp').hide();
    });
    
});


$('.js-btn-code-verify').click(function(){
    var sms_verify = $('#js-sms-verify').val();
    var new_password = $('#phone-creat input[name=password]').val();
    var new_repassword = $('#phone-creat input[name=repassword]').val();
    var js_error = false;
    $('.js-password-error').text('');
    $('.js-repassword-error').text('');
    $('.js-sms-verify-error').text('');

    if ($.trim(new_password) == '') 
    {
      $('.js-password-error').text('Bạn chưa nhập mật khẩu!');
      js_error = true;
    } 
    else if ($.trim(new_password).length < 6) 
    {
      $('.js-password-error').text('Mật khẩu phải có ít nhất 6 ký tự!');
      js_error = true;
    }
    if ($.trim(new_password) != $.trim(new_repassword)) {
      $('.js-repassword-error').text('Xác nhận mật khẩu không đúng. Vui lòng kiểm tra lại!');
      js_error = true;
    }

    if ($.trim(sms_verify) == '') 
    {
      $('.js-sms-verify-error').text('Vui lòng nhập mã xác thực!');
      js_error = true;
    }

    var key_order = $('.key_order').val();
    if (js_error == false) {
      $('.load-wrapp').show();
      $.ajax({
          type: "POST",
          url: '/home/checkout/check_sms_verify',
          dataType: 'json',
          data: {sms_verify: sms_verify, key_order: key_order, new_password: new_password, new_repassword:new_repassword},
          success: function(res) {
              if (res.error == false) 
              {
                  $('form.addOrderaddress').submit();
              }
              else 
              {
                  $('.js-sms-verify-error').text('Sai mã kích hoạt. Vui lòng kiểm tra lại và nhập lại mã khác!');
              }
          },
          error: function(res) {
            $('#modal_mess').modal('show');
            $('#modal_mess .modal-body p').html('Kết nối lỗi');
          }
      }).always(function() {
          $('.load-wrapp').hide();
      });    
    }
});


$('body').on('click','.firstOrderaddress .btn-save-db', function (){
  var _this = '.firstOrderaddress';
  $('form.firstOrderaddress').on('submit',function (e) {});
  if($(_this+' input[name=name]').val() == '' || $(_this+' input[name=name]').val() == null){
     $(_this+' p.note').html('<span class="text-red">Bạn chưa nhập nhập họ tên người nhận</span>');
     return false;
  }

  if($(_this+' input[name=phone]').val() == '' || $(_this+' input[name=phone]').val().length > 10 || !IsNumber($(_this+' input[name=phone]').val())){
     if($(_this+' input[name=phone]').val() == ''){
        var mess = '<span class="text-red">Bạn chưa nhập số điện thoại</span>';
     }else{
        var mess = '<span class="text-red">Số điện thoại hợp lệ chỉ gồm 10 số từ 0 đến 9</span>';
     }
     $(_this+' p.note').html(mess);
     $(_this+' input[name=phone]').css('color','red');
     return false;
  }

  if(!checkEmail($(_this+' input[name=semail]').val()) && $.trim($(_this+' input[name=semail]').val()) != '' ){
     mess = '<span class="text-red">Địa chỉ mail không hợp lệ</span>';
     $(_this+' p.note').html(mess);
     $(_this+' input[name=semail]').css('color','red');
     return false;
  }

  if($(_this+' input[name=address]').val() == ''){
     $(_this+' p.note').html('<span class="text-red">Bạn chưa nhập địa chỉ nhận hàng</span>');
     $(_this+' input[name=address]').css('color','red');
     return false;
  }

  if($(_this+' .js-province').val() == ''){
     $(_this+' p.note').html('<span class="text-red">Bạn chưa chọn tỉnh/thành phố</span>');
     $(_this+' .js-province').css('color','red');
     $(_this+' .js-province option').css('color','#000');
     return false;
  }

  if($(_this+' .js-district').val() == ''){
     $(_this+' p.note').html('<span class="text-red">Bạn chưa chọn quận/huyện</span>');
     $(_this+' .js-district').css('color','red');
     $(_this+' .js-district option').css('color','#000');
     return false;
  }
  $('form.firstOrderaddress').submit();
}); 
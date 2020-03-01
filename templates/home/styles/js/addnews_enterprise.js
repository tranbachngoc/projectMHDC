var formData = new FormData();
var _URL = window.URL || window.webkitURL;

// hiển thị chức năng

$(document).on('click', '#buttonaddfunction', function(e) {
    $('.boxaddfunctionfooter').toggle();
    $('.morefooter.list-checkbox').toggle();
});

// Mở nhập tiêu đề và nội dung

jQuery(document).on('click','#contentNewsFrontEnd', function() {
    $(this).blur();
    $('.boxaddnew').toggle();
});

// Đóng popup

jQuery(document).on('click','.drawer-overlay, .js-back', function() {
    $('.bandangnghigi').removeClass('opened');
    $('.model-content').removeClass('is-open');
    $('.wrapper').removeClass('drawer-open');
    return false;
});

jQuery(document).on('click','button.rediectpreview', function() {

    var form = document.createElement("form");

    var title = document.createElement("input");
    var detail = document.createElement("input");
    var images = document.createElement("input");


    form.method = "POST";
    form.action = siteUrl+'news/preview';

    title.value =   $('input[name="not_title"]').val();
    title.name  =  'not_title';
    form.appendChild(title);

    detail.value =   $('textarea[name="not_detail"]').val();
    detail.name  =  'not_detail';
    form.appendChild(detail);

    var list_images = formData.getAll('images');

    images.value =   JSON.stringify(list_images);
    images.name  =  'images';
    form.appendChild(images);

    document.body.appendChild(form);

    form.submit();
});



// Thêm hình

$(document).on("change",".buttonAddImage",function(event) {
    $('#boxaddimagegallery').css('display','block');
    var files = event.target.files;
    for (var i = 0; i < files.length; i++) {
        var file = files[i];

        // Duyệt từng file trong danh sách và render vào DIV trống đặt sẵn
        renderFileInfo(file);
    }
});

// Tạo id của hình
function GenerateRandomString(len){
    var d = new Date();
    var text = d.getTime();

    return text;
}

// Reader file
function renderFileInfo(file) {
    var fileReader = new FileReader();
    fileReader.onload = function(e) {
        if(file.type == 'video/mp4') {
            formData.append('video', file, file.name);
        }else {

            var id = GenerateRandomString(10);

            var data_image = {
                'image_id'      : id,
                'image_url'     : e.target.result
            };

            var html = '';
            html +='<div class="boxaddimagegallerybox" data-id="'+id+'" style="background-image: url('+e.target.result+')" data-image='+JSON.stringify(data_image)+'>';
                html +='<div class="backgroundfillter"></div>';
                    html +='<button class="addTagImgGallary rediectpreview" data-id="'+id+'" data-url="'+e.target.result+'"></button>';
                html +='<button class="setbackground" data-id="'+id+'"></button>';
                html +='<button class="editimagegallary rediectpreview" data-id="'+id+'" data-url="'+e.target.result+'"></button>';
                html +='<button class="deleteimagegallary" data-id="'+id+'"></button>';
            html +='</div>';
            $(html).insertBefore('#boxaddimagegallery .boxaddmoreimage');

            var images = {
                'image_id'        : id,
                'image_name': file.name,
                'image_url' : e.target.result,
            };
            formData.append('images', JSON.stringify(images));
        }

    };
    fileReader.readAsDataURL(file);
}


$(document).on('click','#submitnews', function() {
    formData.set('not_title',$('#addNewsFrontEnd .boxaddnew input[name="not_title"]').val());
    formData.set('not_detail',$('#addNewsFrontEnd .boxaddnew textarea[name="not_detail"]').val());
    formData.set('domain_post',$('#addNewsFrontEnd .blockdangtin-dangtinby input[name="domain_post"]').val());
    formData.set('personal',$('#addNewsFrontEnd .blockdangtin-dangtinby input[name="personal"]').val());

    var check = true;
    var data_check = [];
    var error_msg = [];

    data_check.push({'name':'not_title','value':formData.get('not_title')});
    data_check.push({'name':'not_detail','value':formData.get('not_detail')});

    // Đếm số hình

    var cout_image = formData.getAll('images');

    data_check.push({
        'name':'cout_image',
        'value':Object.keys(cout_image).length
    });

    var rule = {
        not_title           : 'required',
        not_detail          : 'required',
        cout_image          : 'bool'
    };
    var messenge = {
        not_title   : {
            required    : 'Tiêu đề bắt buộc điền bắt buộc điền',
        },
        not_detail  : {
            required    : 'Vui lòng nhập nội dung tin',
        },
        cout_image : {
            bool        : 'Vui lòng nhập ít nhất 1 tấm hình'
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
    }else {
        formData.set('list_images',JSON.stringify(formData.getAll('images')));

        var error_msg_html = '';
        error_msg_html +='<h2>THÔNG BÁO</h2>';
        error_msg_html +='<div class="error-msg-inner">';
        error_msg_html +='  <p>{{message}}}<p>';
        error_msg_html +='</div>';

        var err_msg = 'Quá trình up tin đang được chạy. Vui lòng không đóng trình duyệt';

        $('#myError .content-icon-option').html(error_msg_html.replace('{{message}}', err_msg));
        openpopup('#myError');

        $.ajax({
            url: siteUrl+'news/addnews',
            processData: false,
            contentType: false,
            type: 'POST',
            dataType : 'json',
            data: formData,
            success:function(data){
                console.log('data',data);
                if(data.type == 'error') {
                    $('#myError .content-icon-option p').html(data.message);
                    openpopup('#myError');
                }
                if(data.type == 'success') {
                    location.reload();
                }
            }
        });
    }

});


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

function openpopup ( element ) {
    $(element).addClass('is-open');
    $('.wrapper').addClass('drawer-open');
}

function closepopup ( element ) {
    $(element).removeClass('is-open');
    $('.wrapper').removeClass('drawer-open');
}

$(document).ready(function() {
    $('body').on('click', '.js_get-pop-commission', function (e) {
        e.preventDefault();
        var template_select  = 'bạn sẽ nhận được {{price}} tiền hoa hồng khi bán sản phẩm này. Bạn muốn chọn bán sản phẩm này ?';
        var price = $(this).attr('data-commission');
        var selected = $(this).attr('data-select');
        var product_id = $(this).attr('data-product');
        var msg = 'Bạn muốn hủy bán sản phẩm này ?';
        if(selected === 'false'){
            msg = template_select.replace('{{price}}', price);
        }
        $('.js_apply-commission').attr('data-product', product_id);

        $('.bd-commision-modal-sm .modal-body').html(msg);
        $('.bd-commision-modal-sm').modal('show');
    });

    $('body').on('click', '.js_apply-commission', function (e) {
        e.preventDefault();
        $('.bd-commision-modal-sm').modal('hide');
        $._loading('show');
        var product_id = $(this).attr('data-product');
        if(!product_id)
            return;
        var selected = $('.js_product-item-'+product_id+' .js_get-pop-commission').attr('data-select');
        var url = 'home/affiliate/ajax_select_pro_sales';
        if(selected !== 'false'){
            url = 'home/affiliate/ajax_cancel_select_pro_sales'
        }
        $.ajax({
            type: "POST",
            url: url,
            dataType: 'json',
            data: {
                proid: product_id,
                id_pro: product_id,
            },
            success: function (data) {
                if (data == 1) {
                    $('.js_product-item-'+product_id+' .js_get-pop-commission').attr({
                        'data-select': (selected === 'true' ? 'false' : 'true')
                    });
                } else {
                    alert('Có lỗi xảy ra!');
                }
            }
        }).always(function() {
            $._loading();
        });
    });

});


/*
* addnews azibai home page
* home/tintuc/defaults
*
* addnews personal home page
* home/personal/pages/profile-home
* */
var formData = new FormData();
var image_type = ["image/gif","image/jpeg","image/png"];
var _URL = window.URL || window.webkitURL;
var main_url = window.location.origin + '/';
var is_busy = false;

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
    var personal    = document.createElement("input");
    var detail      = document.createElement("input");

    form.method = "POST";
    form.action = website_url+'tintuc/previewp';
    personal.value =   $('input[name="personal"]').val();
    personal.name  =  'personal';
    form.appendChild(personal);
    
    var not_detail = $('textarea[name="not_detail"]').val();
    detail.value =   not_detail.replace(/\r?\n/g, '<br />');
    detail.name  =  'not_detail';
    form.appendChild(detail);

    var data = [];
    for (let [key, value] of formData.entries()) {
        var images      = document.createElement("input");
        images.value    = value;
        images.name     = key;
        form.appendChild(images);
    }
    document.body.appendChild(form);

    form.submit();
});



// Thêm hình
$(document).on("change",".buttonAddImage",function(event) {
    $('#boxaddimagegallery').css('display','block');
    var type = $(this).attr('data-type');
    var files = event.target.files;
    for (var i = 0; i < files.length; i++) {
        var file = files[i];

        if(image_type.indexOf(file.type) != -1){
            var have_image =  formData.getAll('have_image').length;
            have_image = parseInt(have_image) + parseInt(files.length);
            if(have_image > 30 ) {
                showError('<p>Chỉ được up tối đa 30 hình</p>');
            }else {
                renderFileInfo(file);
            }
            continue;
        }

        var not_video = formData.get('not_video');
        if((file.type == 'video/quicktime'  || file.type == 'video/mp4') && not_video == null) {
            if(file.size > 524288000) {
                showError('<p>Vui lòng chọn video dưới 500M</p>');
            }else {
                renderFileVideo(file, 'rediectpreview');
            }
        }else {
            showError('<p>Chỉ được up 1 Video</p>'); 
        }
    }
});

$('body').on('click', '.btn-save-style-show-content', function (event) {
    var type_show_content = $('.typeDisplayNewsdetail-nav-tabs .nav-link.active').attr('data-style-show');
    formData.set('type_show', type_show_content);
    $('#typeDisplayNewsdetail').modal('hide');
});

// Reader image
function renderFileInfo(file,type) {
    var fileReader = new FileReader();
    fileReader.onload = function(e) {
        var have_image =  formData.get('have_image');
        if(have_image == null) {
            formData.set('have_image', 1);
        } else {
            have_image = parseInt(formData.get('have_image'))+1;
            formData.set('have_image', have_image);
        }
        
        if(have_image == null || have_image <= 30) {
            var id = GenerateRandomString(10);
            var addimage = new FormData();
            addimage.set('image', file, file.name);
            addimage.set('type', 'content');
            addimage.set('crop', 1);
            $.ajax({
                url: SERVER_OPTIMIZE_URL +'otp-image',
                processData: false,
                contentType: false,
                data: addimage,
                type: 'POST',
                dataType : 'json',
                success:function(res){
                    console.log(res);
                    if(res.error_code === 0) {
                        var images = {
                            'image_id'      : id,
                            'image_name'    : res.data.default.file_name,
                            'image_url'     : res.data.default.file_url,
                            'image_crop'    : res.data.default.file_name_crop,
                            'img_h'         : res.data.default.height,
                            'img_w'         : res.data.default.width,
                            'img_type'      : res.data.default.mime,
                            'path'          : res.data.default.date_dir,
                            'main_url'      : res.data.default.main_url,
                            'text_list'     : {}
                        };

                        var html = '';
                        html +='<div class="boxaddimagegallerybox" data-id="'+id+'" style="background-image: url('+res.data.default.file_url+')" >';
                            html +='<div class="backgroundfillter"></div>';
                            if(type == 'company') {
                                html +='<button class="addTagImgGallary rediectpreview" data-id="'+id+'"></button>';
                            }
                            html +='<button class="editimagegallary rediectpreview" data-id="'+id+'"></button>';
                            html +='<button class="deleteimagegallary" data-id="'+id+'"></button>';
                        html +='</div>';
                        $(html).insertBefore('#boxaddimagegallery .boxaddmoreimage');

                        formData.append('images['+id+']', JSON.stringify(images));

                    }else {
                        var error_msg = '';
                        error_msg +='<h2>THÔNG BÁO LỖI</h2>';
                        error_msg +='<div class="error-msg-inner">';
                            $.each(res.errors, function (key1, val1) {
                                $.each(val1, function (key2, val2) {
                                    error_msg +='<p>'+val2+'</p>';
                                });
                            });
                        error_msg +='</div>';
                        $('#myError .content-icon-option').html(error_msg);
                        openpopup('#myError');
                        formData.set('have_image', formData.get('have_image')-1);
                    }
                }
            });
        }else {
            showError('<p>Chỉ được up tối đa 30 hình</p>');
        }

    };
    fileReader.readAsDataURL(file);
}

// Delete hình
$(document).on('click', '.deleteimagegallary', function(event) {
    console.log('deleteimagegallary');
    event.preventDefault();
    //Lấy index của tấm hình
    var id = $(this).attr('data-id');
    var element = $(this);
    formData.delete('images['+id+']');
    formData.set('have_image', formData.get('have_image') - 1);
    element.parent().remove();
    $('#prelistimagegallery').find('div[data-id="'+element.attr('data-id')+'"]').remove();
});

var link_html_add_item = '';
link_html_add_item +='  <li class="link-item wrap-item-content-link js-play-video" data-url-origin="{{{url_link}}}">';
// link_html_add_item +='      <div class="edit_customlink js_action-link-edit">';
// link_html_add_item +='          <img class="icon-img" src="/templates/home/styles/images/svg/pen_black.svg" alt="Chỉnh sửa link">';
// link_html_add_item +='      </div>';
link_html_add_item +='      <em class="edit_customlink right remove-link-item" data-num="{{{num_item}}}">';
link_html_add_item +='          <img class="icon-img" src="/templates/home/styles/images/svg/x.svg">';
link_html_add_item +='      </em>';

link_html_add_item +='      <a href="{{{detail_link}}}" target="_blank">';
link_html_add_item +='          <p class="img">';
link_html_add_item +='              <img src="{{{url_image}}}">';
link_html_add_item +='          </p>';
link_html_add_item +='      </a>';

link_html_add_item +='      <div class="text">';
link_html_add_item +='          <div class="bg-text-blur" style="background: url({{{url_image}}})"> </div>';
link_html_add_item +='          <a href="{{{url_link}}}" ref="nofollow" target="_blank">';
link_html_add_item +='              <h3 class="one-line">{{{title_link}}}</h3>';
link_html_add_item +='              <p>{{{host_name}}}</p>';
link_html_add_item +='          </a>';
link_html_add_item +='      </div>';
link_html_add_item +='  </li>';

function news_link_template(data, template) {
    for (var index in data) {
        template = template.replace(new RegExp('{{{'+index+'}}}', 'g'), data[index]);
    }
    return template;
}

// Create link item 
function getUnique(arr){
 return arr.filter((e,i)=> arr.indexOf(e) >= i)
}
$(document).on('change', '#addNewsFrontEnd .boxaddnew textarea[name="not_detail"]', function(e) {
    var messagea = $(this).val();
    var links = messagea.match(/\bhttps?:\/\/\S+/gi);
    if(links != null && links.length > 0) {
        links = getUnique(links);
        $.each(links, function( index, value ) {
            var get_element = $('#tabdescontentlinkmain .link-item').find('a[href="'+value+'"]');
            if (get_element.length == 0) {
                $.ajax({
                    url: main_url + 'tintuc/linkinfo',
                    type: 'POST',
                    dataType: 'json',
                    data: {link: value},
                    success: function (data) {
                        var num_item = formData.getAll('num_customlink').length;
                        if (num_item == 0) {
                            formData.set('num_customlink', 1);
                        } else {
                            num_item = parseInt(formData.get('num_customlink')) + 1;
                            formData.set('num_customlink', num_item);
                        }
                        formData.append('not_customlink[' + num_item + ']', JSON.stringify(data));
                        console.log(main_url + 'tintuc/linkinfo ', data);

                        $('#tabdescontentlinkmain .addlinkthem-slider').append(news_link_template({
                            'detail_link': 'javascript:void(0)',
                            'url_image': data.image,
                            'url_link': data.save_link,
                            'title_link': data.title,
                            'host_name': data.host,
                            'num_item': num_item,
                        }, link_html_add_item));
                        $('#tabdescontentlinkmain').css('display', 'block');
                    }
                });
            }
        });
    }
});

// Delete link item
$(document).on('click', '#tabdescontentlinkmain .link-item .remove-link-item', function(e) {
    var id = $(this).attr('data-num');
    formData.delete('not_customlink['+id+']');
    $(this).closest('li.link-item').remove();
    var num_item =  formData.getAll('num_customlink').length;
    if(typeof test === 'number' && num_item > 1) {
        num_item = parseInt(formData.get('num_customlink'))-1;
        formData.set('num_customlink', num_item);
    }else{
        formData.delete('num_customlink');
    }
});
$(document).on('click','#submitnews', function() {
    formData.set('not_detail',$('#addNewsFrontEnd .boxaddnew textarea[name="not_detail"]').val());
    formData.set('domain_post',$('#addNewsFrontEnd .blockdangtin-dangtinby input[name="domain_post"]').val());
    formData.set('personal',$('#addNewsFrontEnd .blockdangtin-dangtinby input[name="personal"]').val());

    var check = 0;
    var check_imageup = 0;
    var data_check = [];
    var error_msg = [];

    data_check.push({'name':'not_detail','value':formData.get('not_detail')});

    var rule = {
        cout_image    : 'bool',
        ajax          : 'bool',
    };
    var messenge = {
        cout_image : {
            bool        : 'Vui lòng nhập ít nhất 1 tấm hình hoặc link liên kết hoặc video'
        },
        ajax : {
            bool        : 'Quá trình up tin đang diễn ra vui lòng đợi!'
        },
        check_imageup   : {
            bool        : 'Vui lòng đợi hình!'
        }
    };

    // Đếm số hình
    var cout_image = 0;

    if(formData.get('have_image')){
        cout_image = Number(formData.get('have_image'));
    }

    if(formData.get('have_video')){
        cout_image = cout_image + 1;
    }

    if(formData.get('num_customlink')){
        cout_image = cout_image + Number(formData.get('num_customlink'));
    }

    if(cout_image) {
        var imageup = 0;
        for(var pair of formData.entries()) {
            // console.log(pair[0]+ ', '+ pair[1]);
            if((pair[0].match(/images\[/) || pair[0].match(/not_customlink\[/) || pair[0].match(/^not_video$/)) && pair[1]) {
                imageup++;
            }
        }
        if(imageup == cout_image) {
            check_imageup = 1;
        }
    }

    data_check.push({
        'name':'cout_image',
        'value':cout_image
    });

    data_check.push({
        'name':'check_imageup',
        'value':check_imageup
    });

    if(is_busy == false) {
        check = 1;
    }

    data_check.push({
        'name':'ajax',
        'value':check
    });

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
        is_busy = true;
        var error_msg_html = '<h2>THÔNG BÁO</h2>';
        error_msg_html +='<div class="error-msg-inner">';
            error_msg_html +='<p>Quá trình up tin đang được chạy. Vui lòng không đóng trình duyệt<p>';
        error_msg_html +='</div>';

        $('#myError .content-icon-option').html(error_msg_html);
        openpopup('#myError');

        $.ajax({
            url: main_url+'tintuc/addnewshome',
            processData: false,
            contentType: false,
            type: 'POST',
            dataType : 'json',
            data: formData,
            success:function(data){
                if(data.type == 'success') {
                    location.reload();
                }else {
                    var error_msg_html = '<h2>THÔNG BÁO</h2>';
                    error_msg_html +='<div class="error-msg-inner">';
                        error_msg_html +='<p>'+data.message+'<p>';
                    error_msg_html +='</div>';

                    $('#myError .content-icon-option').html(error_msg_html);
                    openpopup('#myError');
                    is_busy = false;
                }
            }
        });
    }

});
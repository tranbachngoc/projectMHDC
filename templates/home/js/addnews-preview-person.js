/*
* addnews personal previewp page
* home/tintuc/preview_person
* edit news personal page
* home/tintuc/edit_new_person
* */
var formData = new FormData();
var _URL = window.URL || window.webkitURL;
var main_url = window.location;
main_url = main_url.origin+'/';

// hiển thị chức năng
$(document).on('click', '#buttonaddfunction', function(e) {
    $('.boxaddfunctionfooter').toggle();
    $('.morefooter.list-checkbox').toggle();
    $('.boxaddfunctionfooter').attr('data-status','opened');
    $('.morefooter.list-checkbox').attr('data-status','opened');

    var boxaddnew = $('.boxaddnew');
    var boxaddnew_status = boxaddnew.attr('data-satus');

    if(boxaddnew_status == 'opened') {
        boxaddnew.toggle();
        boxaddnew.attr('data-satus','closed');
    }
});

$('body').on('click', '.btn-save-style-show-content', function (event) {
    var type_show_content = $('.typeDisplayNewsdetail-nav-tabs .nav-link.active').attr('data-style-show');
    formData.set('type_show', type_show_content);
    $('#typeDisplayNewsdetail').modal('hide');
});

// Mở popup đăng tin
jQuery(document).on('click','#contentNewsFrontEnd', function() {
    $(this).blur();
    $(this).toggleClass('opened');
    if ($(this).hasClass('opened')) {
        $('.model-content').addClass('is-open');
        $('.wrapper').addClass('drawer-open');
    } else {
        $('.model-content').removeClass('is-open');
        $('.wrapper').removeClass('drawer-open');
    }
    return false;
});

/*************************** Nhâp nội dung ****************************/

// Mở nhập tiêu đề và nội dung

jQuery(document).on('click','#addtitlecontent', function() {
    closeworking('linkmain');
    $(this).blur();
    var status = $('.boxaddnew').attr('data-satus');
    if(status == 'closed') {
        $('.boxaddnew').attr('data-satus','opened');
    }else {
        $('.boxaddnew').attr('data-satus','closed');
    }
    $('.boxaddnew').toggle();
});

// Thay đổi nội dung title

jQuery(document).on('keyup','#addNewsFrontEnd .boxaddnew input[name="not_title"]', function() {
   $('#pretitlecontent .r-title h2').html($(this).val());
});

// Thay đổi nội dung

jQuery(document).on('keyup','#addNewsFrontEnd .boxaddnew textarea[name="not_detail"]', function() {
   $('#pretitlecontent .r-text').html(nl2br($(this).val()));
});


var link_html_add_item = '';
link_html_add_item +='  <li class="link-item wrap-item-content-link js-play-video" data-url-origin="{{{url_link}}}">';
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
    console.log('change link');
    var messagea = $(this).val();
    var links = messagea.match(/\bhttps?:\/\/\S+/gi);
    if(links != null && links.length > 0) {
        links = getUnique(links);
        $.each(links, function( index, value ) {
            var get_element = $('#tabdescontentlinkmain .link-item').find('a[href="'+value+'"]');
            if (get_element.length == 0)
            {
                $.ajax({
                    url: website_url+'tintuc/linkinfo',
                    type: 'POST',
                    dataType : 'json',
                    data: {link:value},
                    success:function(data){
                        var num_item =  formData.getAll('num_customlink').length;
                        if(num_item == 0) {
                            formData.set('num_customlink', 1);
                        }else {
                            num_item = parseInt(formData.get('num_customlink'))+1;
                            formData.set('num_customlink', num_item);
                        }
                        formData.append('not_customlink['+num_item+']', JSON.stringify(data));

                        $('#tabdescontentlinkmain .addlinkthem-slider').append(news_link_template({
                            'detail_link'   : 'javascript:void(0)',
                            'url_image'     : data.image,
                            'url_link'      : data.save_link,
                            'title_link'    : data.title,
                            'host_name'     : data.host,
                            'num_item'      : num_item,
                        }, link_html_add_item));
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

/************************** edit video *************************************/

$(document).on('click', '.editvideogallary', function(e) {
    closeworking('boxwork');
    var videotitle      = '';
    var videocontent    = '';

    if(formData.get('video_title') != null) {
        videotitle = formData.get('video_title');
    }

    if(formData.get('video_content') != null) {
        videocontent = formData.get('video_content');
    }

    var html ='';

    html +='<div class="menu-add-video">';
        html +='<div class="menu-function-title">';
            html +='<h4>Video</h4>';
        html +='</div>';
        html +='<div class="boxaddvideofunction">';
            html +='<ul>';
                html +='<li class="buttontextvideofunction active" data-tab="buttontextvideofunction">';
                    html +='<p>Tiêu đề và mô tả video</p>';
                html +='</li>';
            html +='</ul>';
        html +='</div>';
    html +='</div>';

    $('.previewnews .sidebar-left').html(html);
    
    var html_tab = '';

    html_tab +='<div class="boxaddstaticcontent">';

        html_tab += '<div class="boxaddcontent buttontextvideofunction active">';
            html_tab +='<input maxlength="60" value="'+videotitle+'" name="videotitle" id="videotitle" placeholder="Nhập tiêu để mô tả">';
            html_tab +='<textarea maxlength="500" name="videocontent" id="videocontent" rows="5" placeholder="Nhập mô tả">'+videocontent+'</textarea>';
        html_tab += '</div>';

        html_tab +='<div class="boxaddvideofunction-footer">';
            html_tab +='<button type="button" class="cancel">Hủy</button>';
            html_tab +='<button type="button" class="save">Lưu</button>';
        html_tab +='</div>';

    html_tab +='</div>';

    $('#addNewsFrontEnd #boxwork').html(html_tab);
});

/**************************** Tin nổi bật ***********************************/

// Mở popup icon

jQuery(document).on('click','.addfeaturednews', function() {
    closeworking('boxaddnewsexample');
    $(this).toggleClass('opened');
    if ($(this).hasClass('opened')) {
        $('#myIconModal').addClass('is-open');
        $('.wrapper').addClass('drawer-open');
        $('.wrapper').find('.drawer-overlay').attr('data-popup','.addfeaturednews');
        $('#myIconModal').find('.btn-back').attr('data-popup','.addfeaturednews');
    } else {
        $('#myIconModal').removeClass('is-open');
        $('.wrapper').removeClass('drawer-open');
        $('.wrapper').find('.drawer-overlay').attr('data-popup','');
        $('#myIconModal').find('.btn-back').attr('data-popup','');
    }
    $(this).removeClass('opened');
    return false;
});

/**************************** Mô tả ngắn ***********************************/

// chèn input mô tả ngắn

$(document).on('click', '.adddesnews', function() {
    closeworking('boxadd');
    var not_description = '';
    if(formData.get('not_description') != null) {
        not_description = formData.get('not_description');
    }

    var adddesnews = '<textarea rows="5" name="adddesnews" value="'+not_description+'" id="adddesnews"  placeholder="Nhập mô tả ngắn">'+not_description+'</textarea>';

    $('#boxaddfunction').html(adddesnews);
});


/******************* Xử lý dữ liệu trước khi lưu ****************************/

// Lưu mô tả ngắn
$(document).on('keyup', 'textarea#adddesnews', function(e) {
    formData.set('not_description', $(this).val());
});


// Lưu từ khóa
$(document).on('change', 'textarea#addkeywordnews', function(e) {
    formData.set('not_keywords', $(this).val());
});

// Lưu link xem thêm
$(document).on('change', 'input#addlinkextendnews', function(e) {
    formData.set('not_video_url', $(this).val());
});

// Lưu tiêu đề và mô tả video
$(document).on('click','.boxaddvideofunction-footer button.save', function (e) {
    formData.set('video_title',$('input#videotitle').val());
    formData.set('video_content',$('textarea#videocontent').val());
    $('#addNewsFrontEnd #boxwork').html('');
    $('.previewnews .sidebar-left').html('');
});
$(document).on('click', '#buttonaddnews, #submitnews', function() {

    var url = website_url+'tintuc/addnewshome';
    if(formData.get('urlupdate') != null) {
        url = formData.get('urlupdate');
    }

    var check = 0;
    var check_imageup = 0;
    var data_check = [];
    var error_msg = [];

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
        //is_busy = true;
        formData.set('personal', 1);
        formData.set('not_detail',$('#addNewsFrontEnd .boxaddnew textarea[name="not_detail"]').val());
        var error_msg_html = '<h2>THÔNG BÁO</h2>';
        error_msg_html +='<div class="error-msg-inner">';
            error_msg_html +='<p>Quá trình up tin đang được chạy. Vui lòng không đóng trình duyệt<p>';
        error_msg_html +='</div>';

        $('#myError .content-icon-option').html(error_msg_html);
        openpopup('#myError');
        
        $.ajax({
            url: url,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType : 'json',
            data: formData,
            success:function(data){
                if(data.type == 'success') {
                    window.location.href = website_url;
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
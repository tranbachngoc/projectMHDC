/*
* update news shop
* home/tintuc/edit_new_home
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
    closeworking('boxaddnew');
    $('#tabdescontentlinkmain').css('display','block');
    //$('.boxaddnew').toggle();
});

// Thay đổi nội dung title

jQuery(document).on('keyup','#addNewsFrontEnd .boxaddnew input[name="not_title"]', function() {
   $('#pretitlecontent .r-title h2').html($(this).val());
});

// Thay đổi nội dung

jQuery(document).on('keyup','#addNewsFrontEnd .boxaddnew textarea[name="not_detail"]', function() {
   $('#pretitlecontent .r-text').html(nl2br($(this).val()));
});

// Create link item 

$(document).on('change', '#addNewsFrontEnd .boxaddnew textarea[name="not_detail"]', function(e) {
    var messagea = $(this).val();
    var links = messagea.match(/\bhttps?:\/\/\S+/gi);
    
    if(links != null && links.length > 0) {
        links = getUnique(links);
        
        $.each(links, function (index, value) {
            var get_element = $('#tabdescontentlinkmain').find('.link-item a[href="'+value+'"]');
            
            if (get_element.length == 0) 
            {
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

                        $('#tabdescontentlinkmain .addlinkthem-slider').append(news_link_template({
                            'detail_link'   : 'javascript:void(0)',
                            'url_image'     : data.image,
                            'url_link'      : data.save_link,
                            'title_link'    : data.title,
                            'host_name'     : data.host,
                            'num_item'      : num_item
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
    var id = $(this).attr('data-id');
    if(id != undefined) {
        $.ajax({
            url: main_url+'tintuc/deletecustomlink',
            type: 'POST',
            dataType : 'json',
            data: {id:id},
            success:function(data){}
        });    
    }
    
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
// Đóng popup

jQuery(document).on('click','.drawer-overlay, .js-back', function() {
    var element = $(this).attr('data-popup');
    $(element).removeClass('opened');
    $('.model-content').removeClass('is-open');
    $('.wrapper').removeClass('drawer-open');
    return false;
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

/*************************** Chèn từ khóa *********************************/

// chèn input từ khóa

$(document).on('click', '.addkeywordnews', function() {
    closeworking('boxadd');
    var not_keywords = '';
    if(formData.get('not_keywords') != null) {
        not_keywords = formData.get('not_keywords');
    }

    var addkeywordnews = '<textarea name="addkeywordnews" value="'+not_keywords+'" id="addkeywordnews" placeholder="Nhập từ khóa" rows="5">'+not_keywords+'</textarea>';

    $('#boxaddfunction').html(addkeywordnews);
});

/*************************** Chèn link youtube *********************************/

// chèn input link youtube

$(document).on('click', '.addlinkextendnews', function() {
    
    var addlinkextendnews = '<input name="addlinkextendnews" id="addlinkextendnews"/ placeholder="Nhập link xem thêm">';

    $('#boxaddfunction').html(addlinkextendnews);
});

/*********** Popup thống kê **************/
// Mở popup
$(document).on('click', '.addstaticnews', function() {
    var data_static = formData.get('static');
    if(data_static != null) {
        data_static = JSON.parse(data_static);
    }else {
        data_static = {
            image_url   : '',
            image_name  : '',
            data_content: {}
        }
    }
    closeworking('boxwork');
    var html ='';

    html +='<div class="menu-add-static">';
        html +='<div class="menu-function-title">';
            html +='<h4>Thống kê</h4>';
        html +='</div>';
        html +='<div class="boxaddstaticfunction">';
            html +='<ul>';
                html +='<li class="buttonimagestaticfunction active" data-tab="boxaddimagestaticfunction">';
                    html +='<p>Ảnh nền thống kê</p>';
                    html += '<div class="boxaddstaticemorefunction">';
                        html +='<div class="buttonaddbgstaticinner">';
                            html +='<img class="" src="'+website_url+'templates/home/images/svg/buttonadd.svg" alt="add image static">';
                            html +='<input type="file" accept="image/*" name="image" class="buttonaddbgstatic">';
                            html +='<span>Chọn hình</span>';
                        html +='</div>';     
                    html += '</div>';
                html +='</li>';
                html +='<li class="buttoncropstaticfunction" data-tab="boxcropimagestaticfunction">';
                    html +='<p>Cắt ảnh</p>';
                html +='</li>';
                html +='<li class="buttontextstaticfunction" data-tab="boxtextstaticfunction">';
                    html +='<p>Nội dung thống kê</p>';
                html +='</li>';
            html +='</ul>';
        html +='</div>';
    html +='</div>';

    $('.previewnews .sidebar-left').html(html);
    
    var html_tab = '';

    html_tab +='<div class="boxaddstaticcontent">';

        // Tab up ảnh
      
        html_tab += '<div class="boxaddcontent boxaddimagestaticfunction active">';
            html_tab += '<div class="boxaddstaticdetailfunction">';
                if(data_static.image_url != '') {
                    html_tab += '<img data-image="'+data_static.image_url+'" src="'+data_static.image_url+'">';
                }
            html_tab += '</div>';
        html_tab += '</div>';

        // Tab crop

        html_tab +='<div class="boxaddcontent boxcropimagestaticfunction"></div>';

        // Tab nọi dung quảng cáo
        var data_content = Object.values(data_static.data_content);
        html_tab += '<div class="boxaddcontent boxtextstaticfunction">';
            html_tab +='<div class="boxaddtextstaticfunctionimage">';
                html_tab +='<div class="boxaddtextstaticfunctionimageinner">';
                    html_tab +='<div class="overlay_bg" style=""></div>';
                    for (var i = 0 ; i < 4; i++ ) {
                        var numberstatic_item   = '';
                        var textstatic_item     = '';
                        var desstatic_item      = '';
                        if(data_content[i] != null) {
                            numberstatic_item   = data_content[i].num;
                            textstatic_item     = data_content[i].title;
                            desstatic_item   = data_content[i].description;
                        }
                        html_tab +='<div class="textaddstatic-item">';
                            html_tab +='<input type="text" value="'+numberstatic_item+'" class="checknum" maxlength="30" min="1" max="99999" name="numberstatic-item-'+i+'" placeholder="Số"/>';
                            html_tab +='<div class="textaddstatic-item-content">';
                                html_tab +='<input type="text" value="'+textstatic_item+'" maxlength="30" name="textstatic-item-'+i+'" placeholder="Nhập tiêu đề thống kê">';
                                html_tab +='<textarea maxlength="50" placeholder="Nhập mô tả thống kê" name="desstatic-item-'+i+'">'+desstatic_item+'</textarea>';
                            html_tab +='</div>';
                        html_tab +='</div>';
                    }
                html_tab +='</div>';
            html_tab +='</div>';
        html_tab += '</div>';

        html_tab +='<div class="boxaddstaticfunction-footer">';
            html_tab +='<button type="button" class="cancel">Hủy</button>';
            html_tab +='<button type="button" class="save">Lưu</button>';
        html_tab +='</div>';

    html_tab +='</div>';

    $('#addNewsFrontEnd #boxwork').html(html_tab);
   
});

// Active tab thống kê

$(document).on('click', '.boxaddstaticfunction ul li', function () {

    var tab_cur = $(this).attr('data-tab');
    $(this).parent().find('li.active').removeClass('active');
    $(this).addClass('active');
    $('.boxaddstaticcontent').find('div.active').removeClass('active');
    $('.boxaddstaticcontent').find('div.'+tab_cur).addClass('active');

    var data_static = formData.get('static');

    if(data_static != '') {
        data_static = JSON.parse(data_static);
    }

    if(tab_cur == 'boxcropimagestaticfunction') {

        var tab_crop ='<img crossOrigin="Anonymous" src="'+data_static.image+'" id="targetstatic">';

        $('#boxwork .boxaddstaticcontent .boxcropimagestaticfunction').html(tab_crop);

        var dkrm = new Darkroom('#targetstatic', {
          // Size options
          minWidth: 100,
          minHeight: 100,
          maxWidth: 550,
          maxHeight: 550,
          // Plugins options
          plugins: {
            save: {
                callback: function() {
                    this.darkroom.selfDestroy(); // Cleanup
                    var newImage = dkrm.canvas.toDataURL();
                    
                    var the_file = Base64ToImage(newImage);
                    
                    var addimage = new FormData();
                    addimage.set('images', the_file, 'static-image.png');
                    $.ajax({
                        url: website_url+'addimagenotthumb',
                        processData: false,
                        contentType: false,
                        data: addimage,
                        type: 'POST',
                        dataType : 'json',
                        success:function(data){
                            if(data.type == 'success') {
                                var data_static = {
                                    image       : data.image_url,
                                    image_name  : data.image_name
                                };
                               
                                formData.set('static', JSON.stringify(data_static));
                            }else {
                                var error_msg = '';

                                error_msg +='<h2>THÔNG BÁO LỖI</h2>';
                                error_msg +='<div class="error-msg-inner">';
                                    error_msg +='<p>'+data.message+'</p>';
                                error_msg +='</div>';
                                $('#myError .content-icon-option').html(error_msg);
                                openpopup('#myError');
                            }
                            
                        }
                    });
    
                    fileStorageLocation = newImage;
                }
            },
            crop: {
              ratio: 1
            }
          },

          // Post initialize script
          initialize: function() {
            var cropPlugin = this.plugins['crop'];
            cropPlugin.selectZone(50, 50, 450, 450);
            // cropPlugin.requireFocus();
          }
        });
    }

    if(tab_cur == 'boxtextstaticfunction') {
        css = {
            'background-image' : 'url('+data_static.image+')',
        };

        $('#boxwork .boxaddstaticcontent .boxaddtextstaticfunctionimage .boxaddtextstaticfunctionimageinner').css(css);
    }

});

// Thêm hình thống kê
$(document).on("change",".buttonaddbgstatic", function(event) {
   
    var file = event.target.files;
    var fileReader = new FileReader();
    fileReader.onload = function(e) {
        var addimage = new FormData();
        addimage.set('images', file[0], file[0].name);
        var data_static = formData.get('static');
        if(data_static != null){
            data_static = JSON.parse(data_static);
            if(typeof data_static.image_path !== 'undefined') {
                addimage.set('dir', data_static.image_path);
            }
        }
        $.ajax({
            url: website_url+'addimagenotthumb',
            processData: false,
            contentType: false,
            data: addimage,
            type: 'POST',
            dataType : 'json',
            success:function(data){
                if(data.type == 'success') {
                    var data_static = {
                        image       : data.image_url,
                        image_name  : data.image_name
                    };

                    var html ='<img data-image="'+data.image_url+'" src="'+data.image_url+'"/>';
                   
                    formData.set('static', JSON.stringify(data_static));

                    $('#boxwork .boxaddstaticdetailfunction').html(html);
                    
                }else {
                    var error_msg = '';

                    error_msg +='<h2>THÔNG BÁO LỖI</h2>';
                    error_msg +='<div class="error-msg-inner">';
                        error_msg +='<p>'+data.message+'</p>';
                    error_msg +='</div>';
                    $('#myError .content-icon-option').html(error_msg);
                    openpopup('#myError');
                }
                
            }
        });

        
    }
    fileReader.readAsDataURL(file[0]);
});

/***************************** Quảng cáo ************************************/
// Chèn box quảng cáo

$(document).on('click', '.addadsnews', function() {
    console.log(JSON.parse(formData.get('ads')));
    closeworking('boxwork');
    
    var html ='';

    html +='<div class="menu-add-ads">';
        html +='<div class="menu-function-title">';
            html +='<h4>Quảng cáo</h4>';
        html +='</div>';
        html +='<div class="boxaddadsfunction">';
            html +='<ul>';
                html +='<li class="buttonimageadsfunction active" data-tab="boxaddimageadsfunction">';
                    html +='<p>Ảnh nền quảng cáo</p>';
                    html += '<div class="boxaddadsemorefunction">';
                        html +='<div class="buttonaddbgadsinner">';
                            html +='<img class="" src="'+website_url+'templates/home/images/svg/buttonadd.svg" alt="add image static">';
                            html +='<input type="file" accept="image/*" name="image" class="buttonaddbgads">';
                            html +='<span>Chọn hình</span>';
                        html +='</div>';     
                    html += '</div>';
                html +='</li>';
                html +='<li class="buttoncropadsfunction" data-tab="boxcropimageadsfunction">';
                    html +='<p>Cắt ảnh</p>';
                html +='</li>';
                html +='<li class="buttontextadsfunction" data-tab="boxtextadsfunction">';
                    html +='<p>Nội dung quảng cáo</p>';
                    html +='<div class="boxaddtextadsfunction">';
                        for (var i = 0; i < 3; i++) {
                            html +='<div class="textaddads-item">';
                                html +='<h4>Nội dung '+(i+1)+':</h4>';
                                html +='<div class="textaddads-item-content">';
                                    html +='<input maxlength="30" name="textads-item-'+i+'" placeholder="Nhập tiêu đề">';
                                    html +='<textarea rows="5" maxlength="60" placeholder="Nhập nội dung" name="desads-item-'+i+'"></textarea>';
                                html +='</div>';
                            html +='</div>';
                        }
                    html +='</div>';
                html +='</li>';
                html +='<li class="buttontimeadsfunction" data-tab="boxtimeadsfunction">';
                    html +='<p>Thời gian quảng cáo</p>';
                html +='</li>';
                html +='<li class="buttonlinkadsfunction" data-tab="boxlinkadsfunction">';
                    html +='<p>Link quảng cáo</p>';
                html +='</li>';
            html +='</ul>';
        html +='</div>';
    html +='</div>';

    $('.previewnews .sidebar-left').html(html);

    var html_tab = '';

    html_tab +='<div class="boxaddadscontent">';
        // Tab anh nền quảng cáo
        html_tab +='<div class="boxaddcontent boxaddimageadsfunction active">';
            html_tab +='<div class="boxaddadsdetailfunction"></div>';
        html_tab +='</div>';

        // Tab crop ảnh
        html_tab +='<div class="boxaddcontent boxcropimageadsfunction"></div>';

        // Tab nọi dung quảng cáo

        html_tab +='<div class="boxaddcontent boxtextadsfunction">';
            html_tab +='<div class="boxaddtextadsfunctionimage"></div>';
        html_tab +='</div>';

        
        // Tab time 

        html_tab +='<div class="boxaddcontent boxtimeadsfunction">';
            html_tab +='<div class="boxaddtimeadsdetailfunction">';
                html_tab +='<div class="boxaddtimeadsdetailfunctioninner">';
                    html_tab +='<div class="overlay_bg" style=""></div>';
                    html_tab +='<div class="slider"></div>';
                    html_tab +='<div class="adsshowprew">';
                        html_tab +='<section class="anaclock">';
                            html_tab +='<div class="clock">';
                                html_tab +='<div class="hour"></div>';
                                html_tab +='<div class="minute"></div>';
                                html_tab +='<div class="second"></div>';
                                html_tab +='<div class="center"></div>';
                            html_tab +='</div>';
                            html_tab +='<div class="textclock" class="text-center">Thời gian còn lại</div>';
                            html_tab +='<div class="countdown" class="text-center"></div>';
                        html_tab +='</section>';
                    html_tab +='</div>';
                    html_tab +='<div class="text-center"><button class="readmore">Xem chi tiết</button></div>';
                html_tab +='</div>';
            html_tab +='</div>';
            html_tab +='<div class="boxaddtimeadsfunction">';
                html_tab +='<div class="time-chonse">';
                    html_tab +='<h3>Thời gian quảng cáo</h3>';
                    html_tab +='<input type="date" name="timeads" id="timeads"/>';
                html_tab +='</div>';
                html_tab +='<div class="time-chonse">';
                    html_tab +='<h3>Chọn kiểu hiển thị</h3>';
                    html_tab +='<div class="list-checkbox">';
                        html_tab +='<div class="checkbox-style">';
                            html_tab +='<label>';
                                html_tab +='<input type="radio" name="ad_display" id="ad_display1" value="1" checked="">';
                                html_tab +='<span class="checkbox"></span>';
                            html_tab +='</label>';
                            html_tab +='<span>Đồng hồ số</span>';
                        html_tab +='</div>';
                        html_tab +='<div class="checkbox-style">';
                            html_tab +='<label>';
                                html_tab +='<input type="radio" name="ad_display" id="ad_display2" value="2">';
                                html_tab +='<span class="checkbox"></span>';
                            html_tab +='</label>';
                            html_tab +='<span>Countdown</span>';
                        html_tab +='</div>';
                    html_tab +='</div>';
                html_tab +='</div>';
                html_tab +='<div class="clear"></div>';
            html_tab +='</div>';
        html_tab +='</div>';

        // Tab link 

        html_tab +='<div class="boxaddcontent boxlinkadsfunction">';
            html_tab +='<div class="boxaddlinkadsdetailfunction">';
                html_tab +='<div class="boxaddlinkadsdetailfunctioninner">';
                    html_tab +='<div class="overlay_bg" style=""></div>';
                    html_tab +='<div class="slider"></div>';
                    html_tab +='<div class="adsshowprew">';
                        html_tab +='<section class="anaclock">';
                            html_tab +='<div class="clock">';
                                html_tab +='<div class="hour"></div>';
                                html_tab +='<div class="minute"></div>';
                                html_tab +='<div class="second"></div>';
                                html_tab +='<div class="center"></div>';
                            html_tab +='</div>';
                            html_tab +='<div class="textclock" class="text-center">Thời gian còn lại</div>';
                            html_tab +='<div class="countdown" class="text-center"></div>';
                        html_tab +='</section>';
                    html_tab +='</div>';
                    html_tab +='<div class="text-center"><button class="readmore">Xem chi tiết</button></div>';
                html_tab +='</div>';
                html_tab +='<div class="boxaddlinkadsfunction">';
                    html_tab +='<h3>Link quảng cáo</h3>';
                    html_tab +='<input type="text" name="linkextendads" id="linkextendads"/>';
                    html_tab +='<div class="clear"></div>';
                html_tab +='</div>';
            html_tab +='</div>';
        html_tab +='</div>';
        html_tab +='<div class="boxaddadsfunction-footer">';
            html_tab +='<button type="button" class="cancel">Hủy</button>';
            html_tab +='<button type="button" class="save">Lưu</button>';
        html_tab +='</div>';
    html_tab +='</div>';

    $('#addNewsFrontEnd #boxwork').html(html_tab);
});

// Thêm hình quảng cáo
$(document).on("change",".buttonaddbgads", function(event) {
   
    var file = event.target.files;

    var fileReader = new FileReader();
    fileReader.onload = function(e) {

        var addimage = new FormData();
        addimage.set('images', file[0], file[0].name);
        var dir = formData.get('dir');
        if(dir != '') {
            addimage.set('dir', dir);
        }
        $.ajax({
            url: website_url+'addimagenotthumb',
            processData: false,
            contentType: false,
            data: addimage,
            type: 'POST',
            dataType : 'json',
            success:function(data){
                if(data.type == 'success') {
                    var data_ads = {
                        image       : data.image_url,
                        image_name  : data.image_name
                    };

                    var html ='<img data-image="'+data.image_url+'" src="'+data.image_url+'"/>';
                   
                    formData.set('ads',JSON.stringify(data_ads));

                    $('#boxwork .boxaddadsdetailfunction').html(html);
                    
                }else {
                    var error_msg = '';

                    error_msg +='<h2>THÔNG BÁO LỖI</h2>';
                    error_msg +='<div class="error-msg-inner">';
                        error_msg +='<p>'+data.message+'</p>';
                    error_msg +='</div>';
                    $('#myError .content-icon-option').html(error_msg);
                    openpopup('#myError');
                }
                
            }
        });
    }
    fileReader.readAsDataURL(file[0]);
});


// Active tab quảng cáo

$(document).on('click', '.boxaddadsfunction ul li', function () {

    var check = false;

    var data_ads = formData.get('ads');

    var tab_cur = $(this).attr('data-tab');

    if(tab_cur == 'boxaddimageadsfunction') {
        check = true;
    }

    if(data_ads != '' && data_ads != null) {
        data_ads = JSON.parse(data_ads);
        if(typeof data_ads.image != 'undefined') {
            check = true;
        }
    }

    if(check == true) {
        
        
        $(this).parent().find('li.active').removeClass('active');
        $(this).addClass('active');
        $('.boxaddadscontent').find('div.boxaddcontent.active').removeClass('active');
        $('.boxaddadscontent').find('div.'+tab_cur).addClass('active');

        
        if(tab_cur == 'boxcropimageadsfunction') {

            var tab_crop ='<img crossOrigin="Anonymous" src="'+data_ads.image+'" id="targetads">';

            $('#boxwork .boxaddadscontent .boxcropimageadsfunction').html(tab_crop);

            var dkrm = new Darkroom('#targetads', {
              // Size options
              minWidth: 100,
              minHeight: 100,
              maxWidth: 550,
              maxHeight: 550,

              // Plugins options
              plugins: {
                save: {
                    callback: function() {
                        this.darkroom.selfDestroy(); // Cleanup
                        var newImage = dkrm.canvas.toDataURL();

                        var the_file = Base64ToImage(newImage);
                    
                        var addimage = new FormData();
                        addimage.set('images', the_file, 'ads-image.png');
                        $.ajax({
                            url: website_url+'addimagenotthumb',
                            processData: false,
                            contentType: false,
                            data: addimage,
                            type: 'POST',
                            dataType : 'json',
                            success:function(data){
                                if(data.type == 'success') {

                                    var data_ads = {
                                        image       : data.image_url,
                                        image_name  : data.image_name
                                    };
                                   
                                    formData.set('ads',JSON.stringify(data_ads));
                                    
                                }else {
                                    var error_msg = '';

                                    error_msg +='<h2>THÔNG BÁO LỖI</h2>';
                                    error_msg +='<div class="error-msg-inner">';
                                        error_msg +='<p>'+data.message+'</p>';
                                    error_msg +='</div>';
                                    $('#myError .content-icon-option').html(error_msg);
                                    openpopup('#myError');
                                }
                                
                            }
                        });

                        fileStorageLocation = newImage;
                    }
                },
                //save: false,
                crop: {
                  
                  ratio: 1
                }
              },

              // Post initialize script
              initialize: function() {
                var cropPlugin = this.plugins['crop'];
                cropPlugin.selectZone(50, 50, 450, 450);

              }
            });
        }

        if(tab_cur == 'boxtextadsfunction') {

            var tab_text ='<img src="'+data_ads.image+'">';

            $('#boxwork .boxaddadscontent .boxaddtextadsfunctionimage').html(tab_text);
        }

        if(tab_cur == 'boxtimeadsfunction') {
            
            var $h = $(".boxaddtimeadsdetailfunctioninner .hour"),
                $m = $(".boxaddtimeadsdetailfunctioninner .minute"),
                $s = $(".boxaddtimeadsdetailfunctioninner .second");
            css = {
                'background-image' : 'url('+data_ads.image+')',
            };

            $('#boxwork .boxaddadscontent .boxaddtimeadsdetailfunction .boxaddtimeadsdetailfunctioninner').css(css);
            
            // Set nội dung
            var html_ads = '<div id="postadlink" class="owl-carousel">';
            for (var i = 1; i <= 3; i++) {
                var title   = '';
                var content = '';
                // lấy tiêu đề
                $('.boxaddtextadsfunction input[name="textads-item-'+i+'"]').each(function( index ) {
                    title = $( this ).val();
                });
                // Lấy content
                $('.boxaddtextadsfunction textarea[name="desads-item-'+i+'"]').each(function( index ) {
                   content = $( this ).val();
                });

                if(title != '' || content != '') {
                    html_ads += '<div class="adtext text-center">';
                        html_ads += '<h2 class="text-uppercase" style="margin-bottom:20px;">'+title+'</h2>';
                        html_ads += '<p style="font-size:16px;margin-top: 0px;">'+content+'</p>';
                    html_ads += '</div>';
                }
            }
            html_ads += '</div>';

            $('.boxaddtimeadsdetailfunction .boxaddtimeadsdetailfunctioninner .slider').html(html_ads);

            $('#postadlink').owlCarousel({ animateOut: 'fadeOutDown', animateIn: 'zoomIn', items: 1, loop: true, margin: 0, nav: false, dots: false, autoplay: true, autoplayTimeout: 3000, autoplayHoverPause: true });

            // Set đồng hồ

            $('.boxaddtimeadsdetailfunctioninner .countdown,.boxaddtimeadsdetailfunctioninner .countdown2').countdown('', function(event) {
                $(this).html(event.strftime('<span><strong>%D</strong><br>Ngày</span> <span><strong>%H</strong><br>Giờ</span> <span><strong>%M</strong><br>Phút</span> <span><strong>%S</strong><br>Giây</span>'));
            });

            setUpFace();
            computeTimePositions($h, $m, $s);
            $(".boxaddtimeadsdetailfunctioninner section").on("resize", setSize).trigger("resize");
        }

        if(tab_cur == 'boxlinkadsfunction') {
            
            var $h = $(".boxaddlinkadsdetailfunctioninner .hour"),
                $m = $(".boxaddlinkadsdetailfunctioninner .minute"),
                $s = $(".boxaddlinkadsdetailfunctioninner .second");
            css = {
                'background-image' : 'url('+data_ads.image+')',
            };

            $('#boxwork .boxaddadscontent .boxaddlinkadsdetailfunction .boxaddlinkadsdetailfunctioninner').css(css);
            
            // Set nội dung
            var html_ads = '<div id="postad" class="owl-carousel">';
            for (var i = 1; i <= 3; i++) {
                var title   = '';
                var content = '';
                // lấy tiêu đề
                $('.boxaddtextadsfunction input[name="textads-item-'+i+'"]').each(function( index ) {
                    title = $( this ).val();
                });
                // Lấy content
                $('.boxaddtextadsfunction textarea[name="desads-item-'+i+'"]').each(function( index ) {
                   content = $( this ).val();
                });

                if(title != '' || content != '') {
                    html_ads += '<div class="adtext text-center">';
                        html_ads += '<h2 class="text-uppercase" style="margin-bottom:20px;">'+title+'</h2>';
                        html_ads += '<p style="font-size:16px;margin-top: 0px;">'+content+'</p>';
                    html_ads += '</div>';
                }
            }
            html_ads += '</div>';

            $('.boxaddlinkadsdetailfunction .boxaddlinkadsdetailfunctioninner .slider').html(html_ads);

            $('#postad').owlCarousel({ animateOut: 'fadeOutDown', animateIn: 'zoomIn', items: 1, loop: true, margin: 0, nav: false, dots: false, autoplay: true, autoplayTimeout: 3000, autoplayHoverPause: true });

            // Set đồng hồ

            $('.boxaddlinkadsdetailfunctioninner .countdown,.boxaddlinkadsdetailfunctioninner .countdown2').countdown('', function(event) {
                    $(this).html(event.strftime('<span><strong>%D</strong><br>Ngày</span> <span><strong>%H</strong><br>Giờ</span> <span><strong>%M</strong><br>Phút</span> <span><strong>%S</strong><br>Giây</span>'));
            });

            setUpFace();
            computeTimePositions($h, $m, $s);
            $(".boxaddlinkadsdetailfunctioninner section").on("resize", setSize).trigger("resize");
        }

    }else {
        var error_msg = '';

        error_msg +='<h2>THÔNG BÁO LỖI</h2>';
        error_msg +='<div class="error-msg-inner">';
            error_msg +='<p>Vui lòng chọn hình</p>';
        error_msg +='</div>';
        $('#myError .content-icon-option').html(error_msg);
        openpopup('#myError');
    }


});


// Change time ads

$(document).on('change', 'input#timeads', function(e) {
    $('.countdown,.countdown2').countdown($(this).val(), function(event) {
        $(this).html(event.strftime('<span><strong>%D</strong><br>Ngày</span> <span><strong>%H</strong><br>Giờ</span> <span><strong>%M</strong><br>Phút</span> <span><strong>%S</strong><br>Giây</span>'));
    });
});

// Change ads type

$(document).on('change', 'input[name="ad_display"]', function(e) {
    if($(this).val() == 2) {
        var time = $('input#timeads').val();
        $('.adsshowprew').html('<div class="countdown2" class="text-center"></div>');
        $('.countdown,.countdown2').countdown(time, function(event) {
            $(this).html(event.strftime('<span><strong>%D</strong><br>Ngày</span> <span><strong>%H</strong><br>Giờ</span> <span><strong>%M</strong><br>Phút</span> <span><strong>%S</strong><br>Giây</span>'));
        });
    }
    if($(this).val() == 1) {

        clock ='<section class="anaclock">';
            clock +='<div class="clock">';
                clock +='<div class="hour"></div>';
                clock +='<div class="minute"></div>';
                clock +='<div class="second"></div>';
                clock +='<div class="center"></div>';
            clock +='</div>';
            clock +='<div class="textclock" class="text-center">Thời gian còn lại</div>';
            clock +='<div class="countdown" class="text-center"></div>';
        clock +='</section>';

        $('.adsshowprew').html(clock);

        var $h = $(".hour"),
            $m = $(".minute"),
            $s = $(".second");

        var time = $('input#timeads').val();

        $('.countdown,.countdown2').countdown(time, function(event) {
            $(this).html(event.strftime('<span><strong>%D</strong><br>Ngày</span> <span><strong>%H</strong><br>Giờ</span> <span><strong>%M</strong><br>Phút</span> <span><strong>%S</strong><br>Giây</span>'));
        });

        setUpFace();
        computeTimePositions($h, $m, $s);
        $(".boxaddlinkadsdetailfunctioninner section").on("resize", setSize).trigger("resize");
    }
    formData.set('ad_display',$(this).val());
});

/************** Liên quan ****************/

// Mở popup
$(document).on('click', '.addrelatednews', function() {
    closeworking('boxwork');
    var relative_title = '';
    if(formData.get('relative_title') != null) {
        relative_title = formData.get('relative_title');
    }
    var related_background = '#808080';
    var related_color = '#FFFFFF';
    var data_related = [];
    var related_style = 0;
    var data_related_style = [
        'Vui lòng chọn kiểu hiển thị',
        'Kiểu số 1',
        'Kiểu số 2'
    ];

    if(formData.get('related_background') != null) {
        related_background = formData.get('related_background');
    }

    if(formData.get('related_color') != null) {
        related_color = formData.get('related_color');
    }

    if(formData.getAll('relative_item').length > 0 ) {
        var data_related = JSON.parse(formData.getAll('relative_item'));
    }

    if(formData.get('related_style') != null) {
        related_style = formData.get('related_style');
    }

    var html ='';

    html +='<div class="menu-add-relative">';
        html +='<div class="menu-function-title">';
            html +='<h4>Liên quan</h4>';
        html +='</div>';
        html +='<div class="boxaddrelatedfunction">';
            html +='<ul>';
                html +='<li class="buttonrelativefunction active" data-tab="boxaddrelativefunction">';
                    html +='<p>Nhập tiêu đề</p>';
                html +='</li>';
                html +='<li class="addcontentrelated" data-tab="boxaddcontentrelated">';
                    html +='<p>Thêm nội dung</p>';
                html +='</li>';
            html +='</ul>';
        html +='</div>';
    html +='</div>';

    $('.previewnews .sidebar-left').html(html);

    var html_tab = '';

    html_tab +='<div class="boxaddrelatedcontent">';
        html_tab +='<div id="boxrelatednews" style="background-color:'+related_background+'">';
            html_tab +='<div class="title"></div>';
            html_tab +='<div class="content-relative"></div>';
        html_tab +='</div>';
        html_tab +='<div class="boxaddcontent boxaddrelativefunction active">';
            html_tab +='<div class="relative-title-add">';
                html_tab +='<h3>Nhập tiêu đề</h3>';
                html_tab +='<input type="text" value="'+relative_title+'" placeholder="KHÁCH HÀNG VIẾT VỀ CHÚNG TÔI" id="related_title">';
            html_tab +='</div>';
            html_tab +='<div class="relative-option">';
                html_tab +='<label>Chọn màu nền:</label>';
                html_tab +='<input type="color" id="related_background" name="related_background" value="'+related_background+'" style="height: 34px;">';
                html_tab +='<div class="clear"></div>';
            html_tab +='</div>';
            html_tab +='<div class="relative-option">';
                html_tab +='<label>Chọn màu chữ:</label>';
                html_tab +='<input type="color" id="related_color" name="related_color" value="#FFFFFF" style="height: 34px;">';
                html_tab +='<div class="clear"></div>';
            html_tab +='</div>';
            html_tab +='<div class="relative-option">';
                html_tab +='<label>Chọn kiểu hiển thị:</label>';
                html_tab +='<select name="related-type" id="related_type" style="height: 34px;">';
                    $.each(data_related_style, function( index, value ) {
                        if(related_style == index) {
                            html_tab +='<option value="'+index+'" selected>'+value+'</option>';
                        }else {
                            html_tab +='<option value="'+index+'">'+value+'</option>';
                        }
                        
                    });
                html_tab +='</select>';
                html_tab +='<div class="clear"></div>';
            html_tab +='</div>';
        html_tab +='</div>';
        html_tab +='<div class="boxaddcontent boxaddcontentrelated">';
            html_tab +='<div id="boxaddcontentrelated"></div>';
        html_tab +='</div>';

        html_tab +='<div class="boxaddrelatedfunction-footer">';
            html_tab +='<button type="button" class="cancel">Hủy</button>';
            html_tab +='<button type="button" class="save">Lưu</button>';
        html_tab +='</div>'
    html_tab +='</div>';


    $('#addNewsFrontEnd #boxwork').html(html_tab);

    // Set nội dung
    var html_related = '<div id="contentRelatedSlider" class="owl-carousel">';

    $.each(data_related, function( index, item ) {
        if(formData.get('sLinkFolderImage') != null) {
            var sLinkFolderImage = formData.get('sLinkFolderImage');
        }
        html_related +='<div class="relative-item">';
            html_related +='<div style="width:100px; margin: 20px auto;">';
                if(item.cus_link){ 
                    html_related +='<a href="'+item.cus_link+'" target="_blank">';
                        html_related +='<img class="img-responsive img-circle" src="'+sLinkFolderImage+item.cus_avatar+'" alt="'+item.cus_text1+'">';
                    html_related +='</a>';
                }
                else {
                    html_related +='<img class="img-responsive img-circle" src="'+sLinkFolderImage+item.cus_avatar+'" alt="'+item.cus_text1+'">';
                }
            html_related +='</div>';                             
            html_related +='<p><strong>'+item.cus_text1+'</strong></p>';
            html_related +='<p style="color:red;word-break: break-word;height:20px;overflow:hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;">'+item.cus_text2+'</p>';
            html_related +='<p style="font-size:small; height: 76px; overflow: hidden;word-break: break-word;">'+item.cus_text3+'</p>';
            html_related +='<p style="margin-bottom:20px;">';
                html_related +='<button class="btn btn-sm btn-link" style="color: '+related_color+'">&nbsp; Xem thêm &nbsp;</button></p>';
                if(item.cus_facebook || item.cus_twitter || item.cus_google) {
                    html_related +='<div class="social">';
                        if(item.cus_facebook){ 
                            html_related +='<a href="'+item.cus_facebook+'" target="_blank">';
                        }
                                html_related +='<img style="padding: 5px;" class="social-icon" src="'+website_url+'templates/home/images/svg/icon_facebook.svg" alt="facebook">';
                        
                        if(item.cus_facebook){ 
                            html_related +='</a>';
                        }
                        if(item.cus_twitter){ 
                            html_related +='<a href="'+item.cus_twitter+'" target="_blank">';
                        }
                                
                                html_related +='<img style="padding: 5px;" class="social-icon" src="'+website_url+'templates/home/images/svg/icon_twitter.svg" alt="twitter">';
                        
                        if(item.cus_twitter){ 
                            html_related +='</a>';
                        }
                        if(item.cus_google){ 
                            html_related +='<a href="'+item.cus_google+'" target="_blank">';
                        }
                            
                            html_related +='<img style="padding: 5px;" class="social-icon" src="'+website_url+'templates/home/images/svg/icon_google.svg" alt="google">';
                        
                        if(item.cus_google){ 
                            html_related +='</a>';
                        }                                        
                    html_related +='</div>';
                }
        html_related +='</div>';
    });

    html_related += '</div>';

    $('#boxwork #boxrelatednews .content-relative').html(html_related);

    $('#contentRelatedSlider').owlCarousel({ animateOut: 'fadeOutDown', animateIn: 'zoomIn', items: 2, loop: true, margin: 10, nav: false, dots: false, autoplay: false, autoplayTimeout: 3000, autoplayHoverPause: true });
});

// Active tab liên quan

$(document).on('click', '.boxaddrelatedfunction ul li', function () {

    var tab_cur = $(this).attr('data-tab');
    $(this).parent().find('li.active').removeClass('active');
    $(this).addClass('active');
    $('.boxaddrelatedcontent').find('div.active').removeClass('active');
    $('.boxaddrelatedcontent').find('div.'+tab_cur).addClass('active');

});

// Thêm nội dung

$(document).on('click', '.addcontentrelated', function() {
    var content_related = '';

        content_related +='<div class="form-group cus_avatar">';
            content_related +='<input type="file" name="cus_avatar" class="form-control" value="">';
            content_related +='<img style="height:116px;" class="" src="/images/noimage.jpg" alt="image preview">';
            content_related +='<label for="cus_avatar" class="">Hình ảnh: </label>';
        content_related +='</div>';
        content_related +='<div class="clear"></div>';

        content_related +='<input type="url" placeholder="Link ảnh" name="cus_link" class="form-control" value="">';

        content_related +='<input type="url" placeholder="Thêm link Facebook" name="cus_facebook" class="form-control" value="">';

        content_related +='<input placeholder="Thêm linkTwitter" type="url" name="cus_twitter" class="form-control" value="">';

        content_related +='<input placeholder="Thêm link Google+" type="url" name="cus_google" class="form-control" value="">';

        content_related +='<input placeholder="Thêm Text 1" type="text" name="cus_text1" class="form-control" value="" maxlength="30">';

        content_related +='<input placeholder="Thêm Text 2" type="text" name="cus_text2" class="form-control" value="" maxlength="30">';

        content_related +='<textarea placeholder="Thêm Text 3" name="cus_text3" class="form-control" rows="10"></textarea>';

        content_related +='<div class="boxaddrelateditemfunction-footer">';
            content_related +='<button type="button" class="cancel">Hủy</button>';
            content_related +='<button type="button" class="save">Lưu</button>';
            content_related +='<button type="button" class="addcontentrelated">Thêm nội dung</button>';
        content_related +='</div>';

    $('#boxwork #boxaddcontentrelated').html(content_related);
});

$(document).on('change', '#boxwork input[name="cus_avatar"]', function (e) {
    var file = event.target.files;
    var element = $(this);
    var fileReader = new FileReader();
    fileReader.onload = function(e) {
        var addimage = new FormData();
        addimage.set('images', file[0], file[0].name);
        var dir = formData.get('dir');
        if(dir != '') {
            addimage.set('dir', dir);
        }
        $.ajax({
            url: website_url+'addimagenotthumb',
            processData: false,
            contentType: false,
            data: addimage,
            type: 'POST',
            dataType : 'json',
            success:function(data){
                if(data.type == 'success') {
                    element.attr('data-image', data.image_name);
                    element.attr('data-url', data.image_url);
                    $("#boxwork #boxaddcontentrelated .cus_avatar img").attr('src',data.image_url);
                }else {
                    var error_msg = '';

                    error_msg +='<h2>THÔNG BÁO LỖI</h2>';
                    error_msg +='<div class="error-msg-inner">';
                        error_msg +='<p>'+data.message+'</p>';
                    error_msg +='</div>';
                    $('#myError .content-icon-option').html(error_msg);
                    openpopup('#myError');
                }
                
            }
        });
        

    }
    fileReader.readAsDataURL(file[0]);
});

$(document).on('click','#boxwork .boxaddrelateditemfunction-footer button.save', function (e) {

    var check = true;
    var data = [];
    var error_msg = [];
    
    // Image Link
    var link_cus_avatar = $('#boxwork input[name="cus_avatar"]').attr('data-url');

    // Avatar
    var cus_avatar = $('#boxwork input[name="cus_avatar"]').attr('data-image');
    data.push({
        'name':'cus_avatar',
        'value':cus_avatar
    });

    // Link
    var cus_link = $('#boxwork input[name="cus_link"]').val();
    data.push({
        'name':'cus_link',
        'value':cus_link
    });

    // Facebook
    var cus_facebook = $('#boxwork input[name="cus_facebook"]').val();
    data.push({
        'name':'cus_facebook',
        'value':cus_facebook
    });

    // Twitter
    var cus_twitter = $('#boxwork input[name="cus_twitter"]').val();
    data.push({
        'name':'cus_twitter',
        'value':cus_twitter
    });

    // Google+
    var cus_google = $('#boxwork input[name="cus_google"]').val();
    data.push({
        'name':'cus_google',
        'value':cus_google
    });

    // Text 1
    var cus_text1 = $('#boxwork input[name="cus_text1"]').val();
    data.push({
        'name':'cus_text1',
        'value':cus_text1
    });

    // Text 2
    var cus_text2 = $('#boxwork input[name="cus_text2"]').val();
    data.push({
        'name':'cus_text2',
        'value':cus_text2
    });

    // Text 3
    var cus_text3 = $('#boxwork textarea[name="cus_text3"]').val();
    data.push({
        'name':'cus_text3',
        'value':cus_text3
    });

    var rule = {
        cus_avatar          : 'required',
        cus_link            : 'url',
        cus_facebook        : 'url',
        cus_twitter         : 'url',
        cus_google          : 'url',
        cus_text1           : 'required',
        cus_text2           : 'required',
        cus_text3           : 'required',
    };
    var messenge = {
        cus_avatar   : {
            required    : 'Vui lòng chọn hình ảnh!',
        },
        cus_link  : {
            url         : 'Link không đúng định dạng',
        },
        cus_facebook  : {
            url         : 'Link không đúng định dạng',
        },
        cus_twitter  : {
            url         : 'Link không đúng định dạng',
        },
        cus_google  : {
            url         : 'Link không đúng định dạng',
        },
        cus_text1   : {
            required    : 'Vui lòng nhập Text 1',
        },
        cus_text2   : {
            required    : 'Vui lòng nhập Text 2',
        },
        cus_text3   : {
            required    : 'Vui lòng nhập Text 3',
        },
    };
    $.each(data, function( key, value ) {
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
                    error_msg +=validate(value.value, v, messenger);
                }
            });
        }
        
    });
    if(error_msg != ''){
        alert(error_msg);
    }else {
        var cus_bg      = $('#related_background').val();
        var cus_color   = $('#related_color').val();
        var relative_item = {
            'cus_avatar'        :   cus_avatar,
            'link_cus_avatar'   :   link_cus_avatar,
            'cus_link'          :   cus_link,
            'cus_facebook'      :   cus_facebook,
            'cus_twitter'       :   cus_twitter,
            'cus_google'        :   cus_google,
            'cus_text1'         :   cus_text1,
            'cus_text2'         :   cus_text2,
            'cus_text3'         :   cus_text3
        };

        formData.append('relative_item', JSON.stringify(relative_item));
        
        var data_related = formData.getAll('relative_item');

        // áp dụng hình nền 

        $('#boxrelatednews').css('background-color',cus_bg);

        // Set nội dung
        var html_related = '<div id="contentRelatedSlider" class="owl-carousel">';

        $.each(data_related, function( index, item ) {
            item = JSON.parse(item);
            var link_image = item.link_cus_avatar;
        
            html_related +='<div class="relative-item">';
                html_related +='<div style="width:100px; margin: 20px auto;">';
                    html_related +='<a href="'+item.cus_link+'" target="_blank">';
                        html_related +='<img class="img-responsive img-circle" src="'+link_image+'" alt="'+item.cus_text1+'">';
                    html_related +='</a>';
                html_related +='</div>';                             
                html_related +='<p><strong>'+item.cus_text1+'</strong></p>';
                html_related +='<p style="color:red;word-break: break-word;height:20px;overflow:hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;">'+item.cus_text2+'</p>';
                html_related +='<p style="font-size:small; height: 76px; overflow: hidden;word-break: break-word;">'+item.cus_text3+'</p>';
                html_related +='<p style="margin-bottom:20px;">';
                    html_related +='<button class="btn btn-sm btn-link" style="color: '+cus_color+'">&nbsp; Xem thêm &nbsp;</button></p>';
                    if(item.cus_facebook || item.cus_twitter || item.cus_google) {
                        html_related +='<div class="social">';
                            if(item.cus_facebook){ 
                                html_related +='<a href="'+item.cus_facebook+'" target="_blank">';
                            }

                                html_related +='<img style="padding: 5px;" class="social-icon" src="'+website_url+'templates/home/images/svg/icon_facebook.svg" alt="facebook">';
                            
                            if(item.cus_facebook){ 
                                html_related +='</a>';
                            }
                            if(item.cus_twitter){ 
                                html_related +='<a href="'+item.cus_twitter+'" target="_blank">';
                            }
                                    html_related +='<img style="padding: 5px;" class="social-icon" src="'+website_url+'templates/home/images/svg/icon_twitter.svg" alt="twitter">';
                            if(item.cus_twitter){
                                html_related +='</a>';
                            }
                            if(item.cus_google){ 
                                html_related +='<a href="'+item.cus_google+'" target="_blank">';
                            }
                                    html_related +='<img style="padding: 5px;" class="social-icon" src="'+website_url+'templates/home/images/svg/icon_google.svg" alt="google">';
                            if(item.cus_google){ 
                                html_related +='</a>';
                            }                                        
                        html_related +='</div>';
                    }
            html_related +='</div>';
        });

        html_related += '</div>';

        $('#boxwork #boxrelatednews .content-relative').html(html_related);

        $('#contentRelatedSlider').owlCarousel({ animateOut: 'fadeOutDown', animateIn: 'zoomIn', items: 2, loop: true, margin: 10, nav: false, dots: false, autoplay: false, autoplayTimeout: 3000, autoplayHoverPause: true });
        

    }
});

// Thêm title related

$(document).on('keyup', '#related_title', function(e) {
    var html_related = '<h4 class="text-center">'+$(this).val()+'</h4>';
    $('#boxwork #boxrelatednews .title').html(html_related);
});

// Đổi màu nên related
$(document).on('change', '#related_background', function(e) {
    $('#boxrelatednews').css('background-color',$(this).val());
});

// Đổi màu chữ related
$(document).on('change', '#related_color', function(e) {
    $('#boxrelatednews h4').css('color',$(this).val());
    $('.relative-item').css('color',$(this).val());
    $('.relative-item button').css('color',$(this).val());
    $('.relative-item a').css('color',$(this).val());
});



/************ Trình diễn ảnh **************/
function showSlider (effect = 'turn,shift,louvers,cube_over,tv,lines,bubbles,dribbles,glass_parallax,parallax,brick,collage,seven,kenburns,cube,blur,book,rotate,domino,slices,blast,blinds,basic,basic_linear,fade,fly,flip,page,stack,stack_vertical',element = '#boxwork #boxSliderNews') {
    var html_slider = '';
    var list_image = [];
    html_slider +='<div id="wowslider-container" class="wowslider-container">';
        html_slider +='<div class="ws_images">';
            html_slider +='<ul class="listimageslider"></ul>';
        html_slider +='</div>';
        html_slider +='<div class="ws_bullets"><div class="listimagesbullets"></div></div>';                  
    html_slider +='</div>';
    html_slider +='<audio id="audioslider" autoplay="true">';
        html_slider +='<source id="audioSource" src="" type="audio/mpeg">';
        html_slider +='Your browser does not support the audio element.';
    html_slider +='</audio>';
    // html_slider +='<audio id="audioslider" src=""></audio>';
    $(element).html(html_slider);
    if(formData.getAll('list_image_id[]').length > 0 ) {
        var html_image = '', html_bullets = '';
        $.each(formData.getAll('list_image_id[]'), function( index, id ) {
            var item = JSON.parse(formData.get('images['+id+']'));
            var title = item.image_name;
            if(typeof item.title != 'undefined') {
                title = item.title;
            }
            list_image.push({'src':item.image_url,'title':title});
            html_image +='<li>';
                html_image +='<img crossOrigin="Anonymous" src="'+item.image_url+'" alt="'+title+'" title="'+title+'" id="wows'+index+'_0" style=""/>';
            html_image +='</li>';

            html_bullets +='<a href="#" title="img'+index+'">';
                html_bullets +='<span>'+index+'</span>';
            html_bullets +='</a>';
        });
        $(element+' #wowslider-container .listimageslider').html(html_image);
        $(element+' #wowslider-container .listimagesbullets').html(html_bullets);
        jQuery("#wowslider-container").wowSlider({
            effect: effect,
            prev: "",
            next: "",
            duration: 20 * 100,
            delay: 20 * 100,
            width: 640,
            height: 360,
            autoPlay: true,
            autoPlayVideo: false,
            playPause: true,
            stopOnHover: false,
            loop: false,
            bullets: 1,
            caption: true,
            captionEffect: "parallax",
            controls: true,
            controlsThumb: false,
            responsive: 2,
            fullScreen: false,
            gestures: 2,
            onBeforeStep: 0,
            images: list_image
        });
    }else {
        $.ajax({
            url: main_url+'tintuc/listimageslider',
            processData: false,
            contentType: false,
            type: 'POST',
            dataType : 'json',
            data: formData,
            success:function(data){
                var html_image = '', html_bullets = '';
                $.each(data, function( index, item ) {
                    html_image +='<li>';
                        html_image +='<img src="'+item.image_url+'" alt="'+item.image_name+'" title="'+item.image_name+'" id="wows'+index+'_0" style=""/>';
                    html_image +='</li>';
                });
                $('#boxwork #boxSliderNews #wowslider-container .listimageslider').html(html_image);
                $.each(data, function( index, item ) {
                    html_bullets +='<a href="#" title="img'+index+'">';
                        html_bullets +='<span>'+index+'</span>';
                    html_bullets +='</a>';
                });
                $('#boxwork #boxSliderNews #wowslider-container .listimagesbullets').html(html_bullets);
                jQuery("#wowslider-container").wowSlider({
                    effect:effect,
                    prev:"",
                    next:"",
                    duration:20*100,
                    delay:20*100,
                    width:540,
                    height:540,
                    autoPlay:true,
                    autoPlayVideo:true,
                    playPause:true,
                    stopOnHover:false,
                    loop:false,
                    bullets:1,
                    caption:true,
                    captionEffect:"move",
                    controls:true,
                    controlsThumb:false,
                    responsive:1,
                    fullScreen:false,
                    gestures:2,
                    onBeforeStep:0,
                    images:0
                });
            }
        });
    }
}

$(document).on('click', '.addeffectnews', function(e) {
    closeworking('boxwork');
    var not_slideshow = formData.get('not_slideshow');
    $('#boxwork select#slider_ef').prop('selectedIndex',0);
    $('#boxwork select#ms').prop('selectedIndex',0);
    
    var html ='';

    html +='<div class="menu-add-slider">';
        html +='<div class="menu-function-title">';
            html +='<h4>Trình diễn ảnh</h4>';
        html +='</div>';
    html +='</div>';

    $('.previewnews .sidebar-left').html(html);

    var html_tab = '';

    html_tab += '<div class="boxaddrelatedcontent">';
        html_tab += '<div id="boxSliderNews"></div>';
    html_tab += '</div>';

    html_tab += '<div class="boxaddsliderfunction">';
        html_tab += '<div class="slider-option-item">';
            html_tab += '<h3>Chọn hiệu ứng</h3>';
            html_tab += '<select id="slider_ef" name="effect" class="form-control">';
                html_tab += '<option value=""> -- Chọn một hiệu ứng -- </option>';              
            html_tab += '</select>';
        html_tab +='</div>';
        html_tab += '<div class="slider-option-item">';
            html_tab += '<h3>Chọn nhạc nền</h3>';
            html_tab += '<select id="ms" name="music" class="form-control">';
                html_tab += '<option value=""> -- Chọn nhạc -- </option>';
            html_tab += '</select>';
        html_tab += '</div>';
        html_tab += '<div class="clear"></div>';
        html_tab += '<div class="list-checkbox">';
            html_tab += '<h3>Bật slider</h3>';
            html_tab += '<div class="checkbox-style">';
                html_tab += '<label>';
                    html_tab += '<input type="radio" name="slideshow" id="nocheck" value="0" checked="">';
                    html_tab += '<span class="checkbox"></span>';
                html_tab += '</label>';
                html_tab += '<span>Tắt</span>';
            html_tab += '</div>';
            html_tab += '<div class="checkbox-style">';
                html_tab += '<label>';
                    if(not_slideshow != null) {
                        html_tab += '<input type="radio" name="slideshow" checked id="ischeck" value="1">';
                    }else {
                        html_tab += '<input type="radio" name="slideshow" id="ischeck" value="1">';
                    }
                    html_tab += '<span class="checkbox"></span>';
                html_tab += '</label>';
                html_tab += '<span>Bật</span>';
            html_tab += '</div>';
        html_tab += '</div>';
    html_tab += '</div>';

    html_tab += '<div class="boxaddsliderfunction-footer">';
        html_tab += '<button type="button" class="cancel">Hủy</button>';
        html_tab += '<button type="button" class="save">Lưu</button>';
    html_tab += '</div>';

    $('#addNewsFrontEnd #boxwork').html(html_tab);
    
    $.ajax({
        url: main_url+'tintuc/listeffectslider',
        processData: false,
        contentType: false,
        type: 'POST',
        dataType : 'json',
        data: {},
        success:function(data){
            var html = '';
            var not_effect = formData.get('not_effect');

            $.each(data, function( key, value ) {
                if(not_effect != null && not_effect == value.value) {
                    html += '<option selected value="'+value.value+'">'+value.name+'</option>';
                }else {
                     html += '<option value="'+value.value+'">'+value.name+'</option>';
                }
            });
            $('select#slider_ef').append(html);
        }
    });

    $.ajax({
        url: main_url+'tintuc/listaudioslider',
        processData: false,
        contentType: false,
        type: 'POST',
        dataType : 'json',
        data: formData,
        success:function(data){
            var html = '';
            var not_music = formData.get('not_music');
    
            $.each(data, function( key, value ) {
                if(not_music != null && not_music == value) {
                    html += '<option selected value="'+value+'">'+value+'</option>';
                }else {
                    html += '<option value="'+value+'">'+value+'</option>';
                }
                
            });
            $('select#ms').append(html);
        }
    });

    showSlider();
    
});

// Thay đổi hiệu ứng

$(document).on('change', 'select#slider_ef', function(e) {
    var eff = $("select#slider_ef option:selected").val();
    showSlider(eff);
    var audio_url = $("select#ms option:selected").val();
    var source = jQuery('source#audioSource');
    source.attr("src",main_url+'media/musics/' + audio_url);
    audio = document.getElementById("audioslider");
    audio.load();
    audio.play();
});

// Thay đổi audio

$(document).on('change', 'select#ms', function(e) {
    var audio_url = $("select#ms option:selected").val();
    var source = jQuery('source#audioSource');
    source.attr("src",main_url+'media/musics/' + audio_url);
    audio = document.getElementById("audioslider");
    audio.load();
    audio.play();
});

$(document).on('click',"#boxwork .boxaddsliderfunction input[name='slideshow']", function(){
    if(parseInt(formData.get('have_image')) < 3 && $(this).val() == 1) {

        var error_msg = '<h2>THÔNG BÁO LỖI</h2>';
        error_msg +='<div class="error-msg-inner"><p>Vui lòng chọn hình ít nhất 3 tấm hình</p></div>';

        $('#myError .content-icon-option').html(error_msg);
        openpopup('#myError');

        $('#boxwork .boxaddsliderfunction input[name="slideshow"][value="0"]').prop('checked', true);

    }
});

/*************************** Chèn chuyên mục tin *********************************/

$(document).on('click', '.addcategoriesnews', function() {
    closeworking('boxadd');
    var not_pro_cat_id = formData.get('not_pro_cat_id');
    $.ajax({
        url: main_url+'tintuc/getcategoriesnewshome',
        processData: false,
        contentType: false,
        type: 'POST',
        dataType : 'json',
        success:function(data){
            var list_category = '<select class="addcategorynews">';
            list_category +='<option value="">Tin thuộc chuyên mục</option>';
            $.each(data, function( index, value ) {
                if(not_pro_cat_id == value.cat_id) {
                    list_category +='<option value="'+value.cat_id+'" selected>'+value.cat_name+'</option>';
                }else {
                    list_category +='<option value="'+value.cat_id+'">'+value.cat_name+'</option>';
                }
            });
            list_category +='</select>';
            $('#boxaddfunction').html(list_category);
        }
    });
});

/******************* Xử lý dữ liệu trước khi lưu ****************************/

// Lưu chuyên mục tin
$(document).on('change', 'select.addcategorynews', function(e) {
    formData.set('not_pro_cat_id', $(this).val());
});

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

// Lưu quảng cáo

$(document).on('click','.boxaddadsfunction-footer button.save', function (e) {
    var data_ads = JSON.parse(formData.get('ads'));
    console.log(data_ads);
    var ad_content = {};
    for (var i = 0; i < 3; i++) {
            var title   = '';
            var content = '';
            // lấy tiêu đề
            $('.boxaddtextadsfunction input[name="textads-item-'+i+'"]').each(function( index ) {
                title = $( this ).val();
            });
            // Lấy content
            $('.boxaddtextadsfunction textarea[name="desads-item-'+i+'"]').each(function( index ) {
               content = $( this ).val();
            });

            if(title != '' || content != '') {
                ad_content[i] = {
                    'title'     : title,
                    'desc'      : content
                };
            }
    }
    data_ads.ad_content = ad_content;

    data_ads.ad_time        = $('#boxwork input#timeads').val();
    data_ads.ad_display     = formData.get('ad_display');
    data_ads.ad_link        = $('#boxwork input#linkextendads').val();
    formData.set('ads', JSON.stringify(data_ads));

    // insert preview
    var html_ads_pre = '';
    var time = $('input#timeads').val();

    if(data_ads.ad_display == 2) {
        
        html_ads_pre +='<div class="boxaddlinkadsdetailfunctioninner">';
            html_ads_pre +='<div class="overlay_bg" style=""></div>';
            html_ads_pre +='<div class="slider"></div>';
            html_ads_pre +='<div class="adsshowprew">';
                html_ads_pre +='<div class="countdown2" class="text-center"></div>';
            html_ads_pre +='</div>';
            html_ads_pre +='<div class="text-center"><button class="readmore">Xem chi tiết</button></div>';
        html_ads_pre +='</div>';
    }
    if(data_ads.ad_display == 1 || data_ads.ad_display == null) {
        
        html_ads_pre +='<div class="boxaddlinkadsdetailfunctioninner">';
            html_ads_pre +='<div class="overlay_bg" style=""></div>';
            html_ads_pre +='<div class="slider"></div>';
            html_ads_pre +='<div class="adsshowprew">';
                html_ads_pre +='<section class="anaclock">';
                    html_ads_pre +='<div class="clock">';
                        html_ads_pre +='<div class="hour"></div>';
                        html_ads_pre +='<div class="minute"></div>';
                        html_ads_pre +='<div class="second"></div>';
                        html_ads_pre +='<div class="center"></div>';
                    html_ads_pre +='</div>';
                    html_ads_pre +='<div class="textclock" class="text-center">Thời gian còn lại</div>';
                    html_ads_pre +='<div class="countdown" class="text-center"></div>';
                html_ads_pre +='</section>';
            html_ads_pre +='</div>';
            html_ads_pre +='<div class="text-center"><button class="readmore">Xem chi tiết</button></div>';
        html_ads_pre +='</div>';
        
    }

    $('#preads').html(html_ads_pre);

    var $h = $(".boxaddlinkadsdetailfunctioninner .hour"),
        $m = $(".boxaddlinkadsdetailfunctioninner .minute"),
        $s = $(".boxaddlinkadsdetailfunctioninner .second");
    css = {
        'background-image' : 'url('+data_ads.image+')',
    };

    $('#preads').css(css);
    
    // Set nội dung
    var html_ads = '<div id="postadpre" class="owl-carousel">';
        $.each(ad_content, function( index, value ) {
            html_ads += '<div class="adtext text-center">';
                html_ads += '<h2 class="text-uppercase" style="margin-bottom:20px;">'+value.title+'</h2>';
                html_ads += '<p style="font-size:16px;margin-top: 0px;">'+value.desc+'</p>';
            html_ads += '</div>';
        });

    html_ads += '</div>';

    $('#preads .slider').html(html_ads);

    $('#postadpre').owlCarousel({ animateOut: 'fadeOutDown', animateIn: 'zoomIn', items: 1, loop: true, margin: 0, nav: false, dots: false, autoplay: true, autoplayTimeout: 3000, autoplayHoverPause: true });

    // Set đồng hồ

    $('#preads .countdown,#preads .countdown2').countdown(time, function(event) {
        $(this).html(event.strftime('<span><strong>%D</strong><br>Ngày</span> <span><strong>%H</strong><br>Giờ</span> <span><strong>%M</strong><br>Phút</span> <span><strong>%S</strong><br>Giây</span>'));
    });

    setUpFace();
    computeTimePositions($h, $m, $s);
    $("#preads section").on("resize", setSize).trigger("resize");
});

// Lưu thống kê
$(document).on('click','.boxaddstaticfunction-footer button.save', function (e) {
    var data_static = JSON.parse(formData.get('static'));

    var data_content = {};
    var static_html = '';
    static_html += '<div class="boxaddtimeadsdetailfunctioninner">';
    for (var i = 0; i < 4; i++) {
        var number = '';
        var title   = '';
        var content = '';
        // lấy số
        $('#boxwork .boxaddtextstaticfunctionimage input[name="numberstatic-item-'+i+'"]').each(function( index ) {
            number = $( this ).val();
        });
        // lấy tiêu đề
        $('#boxwork .boxaddtextstaticfunctionimage input[name="textstatic-item-'+i+'"]').each(function( index ) {
            title = $( this ).val();
        });
        // Lấy content
        $('#boxwork .boxaddtextstaticfunctionimage textarea[name="desstatic-item-'+i+'"]').each(function( index ) {
           content = $( this ).val();
        });

        if(number != '' || title != '' || content != '') {
            data_content[i] = {
                'num'    : number,
                'title'     : title,
                'description'   : content
            };
            static_html += '<div class="textaddstatic-item">';
                static_html += '<p class="number">'+number+'</p>';
                static_html += '<strong>'+title+'</strong>';
                static_html += '<span class="description">'+content+'</span>';
            static_html += '</div>';
        }
    }

    static_html += '</div>';
    if(data_static.image != '') {
        $('#prestatic').css('background-image','url('+data_static.image+')');
    }
    $('#prestatic').html(static_html);
    data_static.data_content = data_content;
    formData.set('static', JSON.stringify(data_static));
});

// Lưu liên quan 

$(document).on('click','.boxaddrelatedfunction-footer button.save', function (e) {
    var check = true;
    var data = [];
    var error_msg = [];

    // Title
    var cus_title = $('input#related_title').val();
    data.push({
        'name':'cus_title',
        'value':cus_title
    });

    // Content

    var cus_content = formData.getAll('relative_item');

    data.push({
        'name':'cus_content',
        'value':Object.keys(cus_content).length
    });

    // Check type 1

    var related_type = $('select#related_type').val();

    if(Object.keys(cus_content).length < 2 && related_type == 1) {
        data.push({
            'name':'cus_type',
            'value': 0
        });
    }else {
        data.push({
            'name':'cus_type',
            'value': 1
        });
    }

    var rule = {
        cus_title          : 'required',
        cus_content        : 'bool',
        cus_type           : 'bool'
    };
    var messenge = {
        cus_title   : {
            required    : 'Vui lòng nhập tiêu đề !',
        },
        cus_content : {
            bool        : 'Vui thêm content!'
        },
        cus_type : {
            bool        : 'Kiểu hiển thị 1 cần 2 nội dung trở lên'
        }
    };

    $.each(data, function( key, value ) {
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
                    error_msg +=validate(value.value, v, messenger);
                }
            });
        }
        
    });
    if(error_msg != ''){
        //alert(error_msg);
        var error_msg_html = '<h2>THÔNG BÁO LỖI</h2>';
        error_msg_html +='<div class="error-msg-inner">';
            error_msg_html +=error_msg;
        error_msg_html +='</div>';

        $('#myError .content-icon-option').html(error_msg_html);
        openpopup('#myError');
    }else {
        formData.set('relative_title',$('input#related_title').val());
        formData.set('related_background',$('input#related_background').val());
        formData.set('related_color',$('input#related_color').val());
        formData.set('related_style',$('select#related_type').val());

        var data_related = formData.getAll('relative_item');

        // áp dụng hình nền 

        $('#prerelative').css('background-color',$('input#related_background').val());

        // Set nội dung
        var html_related = '<div class="title"><h4 class="text-center">'+$('input#related_title').val()+'</h4></div>';
        html_related += '<div id="preRelatedSlider" class="owl-carousel">';

        $.each(data_related, function( index, item ) {
            item = JSON.parse(item);
            var link_image = item.link_cus_avatar;
            
            html_related +='<div class="relative-item">';
                html_related +='<div style="width:100px; margin: 20px auto;">';
                    if(item.cus_link){ 
                        html_related +='<a href="'+item.cus_link+'" target="_blank">';
                    }
                            html_related +='<img class="img-responsive img-circle" src="'+link_image+'" alt="'+item.cus_text1+'">';
                    if(item.cus_link){
                        html_related +='</a>';
                    }
                html_related +='</div>';                             
                html_related +='<p><strong>'+item.cus_text1+'</strong></p>';
                html_related +='<p style="color:red;word-break: break-word;height:20px;overflow:hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;">'+item.cus_text2+'</p>';
                html_related +='<p style="font-size:small; height: 76px; overflow: hidden;word-break: break-word;">'+item.cus_text3+'</p>';
                html_related +='<p style="margin-bottom:20px;">';
                    html_related +='<button class="btn btn-sm btn-link" style="color: '+$('input#related_color').val()+'">&nbsp; Xem thêm &nbsp;</button></p>';
                    if(item.cus_facebook || item.cus_twitter || item.cus_google) {
                        html_related +='<div class="social">';
                            if(item.cus_facebook){ 
                                html_related +='<a href="'+item.cus_facebook+'" target="_blank">';
                            }
                                    html_related +='<img style="padding: 5px;" class="social-icon" src="'+website_url+'templates/home/images/svg/icon_facebook.svg" alt="facebook">';
                            if(item.cus_facebook){
                                html_related +='</a>';
                            }
                            if(item.cus_twitter){ 
                                html_related +='<a href="'+item.cus_twitter+'" target="_blank">';
                            }
                                    html_related +='<img style="padding: 5px;" class="social-icon" src="'+website_url+'templates/home/images/svg/icon_twitter.svg" alt="twitter">';
                            if(item.cus_twitter){
                                html_related +='</a>';
                            }
                            if(item.cus_google){ 
                                html_related +='<a href="'+item.cus_google+'" target="_blank">';
                            }
                                    html_related +='<img style="padding: 5px;" class="social-icon" src="'+website_url+'templates/home/images/svg/icon_google.svg" alt="google">';
                            if(item.cus_google){
                                html_related +='</a>';
                            }                                                     
                        html_related +='</div>';
                    }
            html_related +='</div>';
        });

        html_related += '</div>';

        $('#prerelative').html(html_related);

        $('#preRelatedSlider').owlCarousel({ animateOut: 'fadeOutDown', animateIn: 'zoomIn', items: 2, loop: true, margin: 10, nav: false, dots: false, autoplay: false, autoplayTimeout: 3000, autoplayHoverPause: true });
        
    }
});

// Lưu trình diễn ảnh 
$(document).on('click','.boxaddsliderfunction-footer button.save', function (e) {
    var check = true;
    var data = [];
    var error_msg = [];

    // hiệu ứng
    var ef = $('#boxwork select#slider_ef').val();
    data.push({
        'name':'ef',
        'value':ef
    });

    // nhạc nền

    var ms = $('#boxwork #ms').val();

    data.push({
        'name':'ms',
        'value':ms
    });

    // Bật tắt slider

    var status = $("#boxwork input[name='slideshow']:checked").val();

    data.push({
        'name':'status',
        'value':status
    });

    // Đếm số hình
    var cout_image = formData.get('have_image');

    data.push({
        'name':'cout_image',
        'value':cout_image
    });

    var rule = {
        ef          : 'required',
        ms          : 'required',
        status      : 'required',
        cout_image  : 'bool'    
    };
    var messenge = {
        ef   : {
            required    : 'Vui lòng chọn hiệu ứng!',
        },
        ms : {
            required    : 'Vui lòng chọn nhạc nền!'
        },
        status : {
            required    : 'Vui lòng chọn status Slider!'
        },
        cout_image : {
            bool        : 'Bạn không có đủ số hình để chạy Slider'
        }
    };

    $.each(data, function( key, value ) {
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
                    error_msg +=validate(value.value, v, messenger);
                }
            });
        }
    });

    if(error_msg != ''){
        var error_msg_html = '<h2>THÔNG BÁO LỖI</h2>';
        error_msg_html +='<div class="error-msg-inner">';
            error_msg_html +=error_msg;
        error_msg_html +='</div>';

        $('#myError .content-icon-option').html(error_msg_html);
        openpopup('#myError');

    }else {
        formData.set('not_slideshow',status);
        formData.set('not_effect',ef);
        formData.set('not_music',ms);

        var html_slider = '';
        html_slider += '<div class="boxaddrelatedcontent">';
            html_slider += '<div id="boxPreSliderNews"></div>';
        html_slider += '</div>';

        $('#preview_content #preslider').html(html_slider);
        showSlider(ef,'#preslider #boxPreSliderNews');
        
    }
});

// Lưu tiêu đề và mô tả video
$(document).on('click','.boxaddvideofunction-footer button.save', function (e) {
    formData.set('video_title',$('input#videotitle').val());
    formData.set('video_content',$('textarea#videocontent').val());
    $('#addNewsFrontEnd #boxwork').html('');
    $('.previewnews .sidebar-left').html('');
});

$(document).on('click', '#buttonaddnews, #submitnews', function() {
    console.log('templates/home/js/addnews-update.js:2165');
    var url = formData.get('urlupdate');
    formData.set('not_title',$('#addNewsFrontEnd .boxaddnew input[name="not_title"]').val());
    formData.set('not_detail',$('#addNewsFrontEnd .boxaddnew textarea[name="not_detail"]').val());
   
    var check = true;
    var data_check = [];
    var error_msg = [];

    data_check.push({'name':'not_title','value':formData.get('not_title')});
    data_check.push({'name':'not_detail','value':formData.get('not_detail')});

    // Đếm số hình
    var cout_image = 0;
    if(formData.get('have_image')){
        cout_image =  Number(formData.get('have_image'));
    }

    if(formData.get('have_video')){
        cout_image = cout_image + 1;
    }

    if(formData.get('num_customlink')){
        cout_image = cout_image + Number(formData.get('num_customlink'));
    }

    console.log('cout_image', cout_image);

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

    if(is_busy == false) {
        check = 1;
    }

    data_check.push({
        'name':'ajax',
        'value':check
    });

    var rule = {
        not_title           : 'required',
        not_detail          : 'required',
        cout_image          : 'bool',
        ajax                : 'bool'
    };
    var messenge = {
        not_title   : {
            required    : 'Tiêu đề bắt buộc điền bắt buộc điền',
        },
        not_detail  : {
            required    : 'Vui lòng nhập nội dung tin',
        },
        cout_image : {
            bool        : 'Vui lòng nhập ít nhất 1 tấm hình hoặc video'
        },
        ajax : {
            bool        : 'Quá trình up tin đang diễn ra vui lòng đợi!'
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
        is_busy = true;
        formData.set('relative_content',JSON.stringify(formData.getAll('relative_item')));
        formData.set('list_icon',JSON.stringify(formData.getAll('icon_list')));

        var data = new FormData();
        for (let [key, value] of formData.entries()) {
            data.set(key,value);
        }

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
            data: data,
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
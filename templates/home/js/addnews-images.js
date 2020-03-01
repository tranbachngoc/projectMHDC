var is_busy = false;
var video_busy = false;
// Thêm hình
var image_type = ["image/gif","image/jpeg","image/png"];

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

        if(file.type == 'video/mp4' && not_video == null) {
            if(file.size > 524288000) {
                showError('<p>Vui lòng chọn video dưới 500M</p>');
            }else {
                // renderFileVideo(file);
                /*change upload video*/
                renderFileVideo(file);
            }
        }else {
            showError('<p>Chỉ được up 1 Video</p>'); 
        }
    }
});

// Tạo id của hình
function GenerateRandomString(len){
    var d = new Date();
    return d.getTime();
}

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
            addimage.set('dir', formData.get('dir'));
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
                    if(res && res.error_code === 0) {
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
                            html +='<button class="addTagImgGallary" data-id="'+id+'"></button>';
                            html +='<button class="setbackground" data-id="'+id+'"></button>';
                            html +='<button class="editimagegallary" data-id="'+id+'"></button>';
                            html +='<button class="deleteimagegallary" data-id="'+id+'"></button>';
                        html +='</div>';
                        $(html).insertBefore('#boxaddimagegallery .boxaddmoreimage');
                        // Preview
                        $('#prelistimagegallery').append('<div id="'+id+'" class="icon-item-featured-wappar">'+html+'<p class="title-image"></p><p class="des-image"></p></div>');
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

/*************************** Edit Image ******************************/
// Edit image
$(document).on('click', '.editimagegallary', function() {
    closeworking('boxwork');
    var post_type   = $(this).attr('data-post-type');
    var image_id    = $(this).closest('.boxaddimagegallerybox').attr('data-id');
    var data_image  = JSON.parse(formData.get('images['+image_id+']'));
    if(data_image.image_crop_true == 1){
        var image_url       = data_image.image_crop;
    }else {
        var image_url       = data_image.image_url;
    }

    var list_link   = data_image.list_link;
    var html = '';

    // kích hoạt hình preview

    $('#prelistimagegallery').find('div[data-id="'+image_id+'"]').addClass('active');
    
    html +='<div class="menu-edit-image" data-id="'+image_id+'">';
        html +='<div class="menu-function-title">';
            html +='<h4>Chỉnh sửa ảnh mở rộng</h4>';
        html +='</div>';
        html +='<div class="boxaddimagefunction">';
            html +='<ul>';
                html +='<li class="buttoncropfunction active" data-tab="boxcropfunction">';
                    html +='<p class="activetab">Cắt ảnh</p>';
                html +='</li>';
                html +='<li class="buttonshowfunction" data-tab="boximageshow">';
                    html +='<p class="activetab">Hiển thị</p>';
                    html +='<div class="boxaddtextshowfunction">';
                        html +='<button class="showbutton active" id="showdefault" data-show="default">Mặc định</button>';
                        html +='<button class="showbutton" id="showBackgroundImage" data-show="backgroundimage">Ảnh nền</button>';
                        html +='<button class="showbutton" id="showBackgroundColor" data-show="backgroundcolor">Màu nền</button>';
                    html +='</div>';
                html +='</li>';
                html +='<li class="buttondesfunction" data-tab="boxdesfunction">';
                    html +='<p class="activetab">Mô tả ảnh</p>';
                    html +='<div class="boxaddimagemorefunction">';
                        html +='<div id="tabdesadd" class="funcion-item">';
                            html +='<img src="'+website_url+'templates/home/images/svg/shortdes.svg" alt="Nội dung miêu tả">';
                            html +='<p>Nội dung miêu tả</p>';
                        html +='</div>';
                        html +='<div id="tabdesaddfeatured" class="funcion-item">';
                            html +='<img src="'+website_url+'templates/home/images/svg/pen_edit_image.svg" alt="Nội dung nổi bật">';
                            html +='<p>Nội dung nổi bật</p>';
                        html +='</div>';
                    html +='</div>';
                html +='</li>';
                html +='<li class="buttontextfunction" data-tab="boxaddtextimage">';
                    html +='<p class="activetab">Chữ trên ảnh</p>';
                    html += '<div class="boxaddtextimagefunction">';
                        html +='<div class="text-image">';
                            html +='<div id="tabtextadd" data-numner="0">';
                                html +='<span>Thêm nội dung</span>';
                            html +='</div>';
                            html +='<div class="text-align-local">';
                                html +='<span>Vị trí nội dung</span>';
                                html +='<div class="align-vertical">';
                                    html +='<img src="'+website_url+'templates/home/images/svg/align-top.svg" data-align="top" id="align_vertical_top" alt="Căn trên" class="align-button">';
                                    html +='<img src="'+website_url+'templates/home/images/svg/align-bottom.svg" data-align="bottom" id="align_vertical_bottom" alt="Căn dưới" class="align-button">';
                                    html +='<img src="'+website_url+'templates/home/images/svg/align-middle.svg" data-align="middle" id="align_vertical_center" alt="Căn đều" class="align-button">';
                                html +='</div>';
                                html +='<div class="clear"></div>';
                            html +='</div>';
                            html +='<div id="textbackground">';
                                html +='<span>Màu nền : </span>';
                                html +='<input type="color" id="bg_color_button">';
                                html +='<div class="clear"></div>';
                            html +='</div>';
                            html +='<div id="textcolor">';
                                html +='<span>Màu Chữ : </span>';
                                html +='<input type="color" id="text_color_button" value="#ffffff">';
                                html +='<div class="clear"></div>';
                            html +='</div>';
                            html +='<div id="textfont">';
                                html +='<select id="textfontselect">';
                                    html +='<option value="" selected>Font chữ</option>';                         
                                    html +='<option value="Cousine, monospace">Cousine</option>';
                                    html +='<option value="Chakra Petch, sans-serif">Chakra Petch</option>';
                                    html +='<option value="Jura, sans-serif">Jura</option>';
                                    html +='<option value="Taviraj, serif;">Taviraj</option>';
                                    html +='<option value="Saira Extra Condensed, sans-serif">Saira Extra Condensed</option>';
                                    html +='<option value="Barlow Condensed, sans-serif">Barlow Condensed</option>';
                                    html +='<option value="Open Sans Condensed">Open Sans Condensed</option>';
                                    html +='<option value="Asap, sans-serif">Asap</option>';
                                    html +='<option value="Dancing Script, cursive">Dancing Script</option>';
                                    html +='<option value="Pacifico, cursive">Pacifico</option>';
                                    html +='<option value="Charm, cursive">Charm</option>';
                                    html +='<option value="Oswald, sans-serif">Oswald</option>';
                                    html +='<option value="Saira Condensed, sans-serif">Saira Condensed</option>';
                                    html +='<option value="Cormorant Upright, serif">Cormorant Upright</option>';
                                    html +='<option value="Lemonada, cursive">Lemonada</option>';
                                    html +='<option value="Anton, sans-serif">Anton</option>';
                                    html +='<option value="Bangers, cursive">Bangers</option>';
                                    html +='<option value="Francois One, sans-serif">Francois One</option>';
                                    html +='<option value="Pattaya, sans-serif">Pattaya</option>';
                                html +='</select>';
                            html +='</div>';
                            html +='<div id="texteffect">';
                                html +='<select id="texteffectselect">';
                                    html +='<option value="" selected>Hiệu ứng</option>';
                                    html +='<option value="effect1">Hiệu ứng chữ 1</option>';
                                    html +='<option value="effect2">Hiệu ứng chữ 2</option>'
                                    html +='<option value="effect3">Hiệu ứng chữ 3</option>';
                                    html +='<option value="effect4">Hiệu ứng chữ 4</option>';
                                    html +='<option value="effect5">Hiệu ứng chữ 5</option>';
                                    html +='<option value="effect6">Hiệu ứng chữ 6</option>';
                                    html +='<option value="effect7">Hiệu ứng chữ 7</option>';
                                    html +='<option value="effect8">Hiệu ứng chữ 8</option>';
                                    html +='<option value="effect9">Hiệu ứng chữ 9</option>';
                                    html +='<option value="effect10">Hiệu ứng chữ 10</option>';
                                    html +='<option value="effect11">Hiệu ứng chữ 11</option>';
                                    html +='<option value="effect12">Hiệu ứng chữ 12</option>';
                                    html +='<option value="effect13">Hiệu ứng chữ 13</option>';
                                html +='</select>';
                            html +='</div>';
                            html +='<div id="textaudio">';
                                html += '<div class="accordion js-accordion">';
                                html += '    <div class="accordion-item textaudioselect">';
                                html += '        <div class="accordion-toggle textaudioselect-title">';
                                html += '            Âm Nhạc';
                                html += '        </div>';
                                html += '        <div class="accordion-panel textaudioselect-menu" style="display: none;">';
                                html += '            <div class="dropdown-item textaudioselect-item images audio-from-azibai">';
                                html += '                Nhạc trong kho azibai';
                                html += '            </div>';
                                html += '            <div class="dropdown-item textaudioselect-item">';
                                html += '                Nhạc từ thiết bị';
                                html += '                <input class="select-music images select-audio-from-device" name="myFile" type="file">';
                                html += '                    <i aria-hidden="true" class="fa fa-upload"></i>';
                                html += '                </input>';
                                html += '            </div>';
                                html += '            <div class="dropdown-item textaudioselect-item images audio-from-url">';
                                html += '                Phát nhạc theo liên kết';
                                html += '            </div>';
                                html += '        </div>';
                                html += '    </div>';
                                html += '</div>';
                            html +='</div>';
                        html +='</div>';
                    html += '</div>';
                html +='</li>';
                html +='<li class="buttonlinkfunction" data-tab="boxaddtextlink">';
                    html +='<p class="activetab">Chèn link</p>';
                    html +='<div class="boxaddtextlinkfunction">';
                        html +='<select id="list_products">';
                            html +='<option value="">Liên kết sản phẩm</option>';
                        html +='</select>';
                        html +='<div class="item-link-image">';
                            html +='<label>Link xem thêm : </label>';
                            html +='<input id="link_more_image" name="link_more_image"/>';
                        html +='</div>';
                    html +='</div>';
                html +='</li>';
                html +='<li class="buttonaffectfunction" data-tab="boximageffect">';
                    html +='<p class="activetab">Hiệu ứng</p>';
                    html +='<div class="boxaddtexteffectfunction">';
                        html +='<h3>Chọn hiệu ứng ảnh</h3>';
                        html +='<select id="imageeffectselect">';
                            html +='<option value="" selected>Hiệu ứng</option>';
                            html +='<option value="fadeInLeft">Bên trái qua</option>';
                            html +='<option value="fadeInRight">Bên phải qua</option>';
                            html +='<option value="fadeInDown">Từ dưới lên</option>';
                            html +='<option value="fadeInUp">Từ trên xuống</option>';
                            html +='<option value="fadeIn">Phóng to chậm</option>';
                            html +='<option value="bounceIn">Phóng to nhanh</option>';
                        html +='</select>';
                        html +='<h3>Chọn hiệu ứng chữ</h3>';
                        html +='<select id="imagetexteffectselect">';
                            html +='<option value="" selected>Hiệu ứng</option>';
                            html +='<option value="fadeInLeft">Bên trái qua</option>';
                            html +='<option value="fadeInRight">Bên phải qua</option>';
                            html +='<option value="fadeInDown">Từ dưới lên</option>';
                            html +='<option value="fadeInUp">Từ trên xuống</option>';
                            html +='<option value="fadeIn">Phóng to chậm</option>';
                            html +='<option value="bounceIn">Phóng to nhanh</option>';
                        html +='</select>';
                    html +='</div>';
                html +='</li>';
            html +='</ul>';
        html +='</div>';
    html +='</div>';

    $('.previewnews .sidebar-left').html(html);

    // Mô tả ảnh
    
    var html_tab = '';

    html_tab +='<div class="boxaddimagecontent">';

        // Tab cắt ảnh
        html_tab += '<div class="boxaddcontent boxcropfunction active">';
            html_tab +='<img crossOrigin="Anonymous" src="'+image_url+'" id="target">';
        html_tab += '</div>';
        
        // Tab hiển thị

        html_tab += '<div class="boxaddcontent boximageshow">';
            html_tab +='<div class="boxaddshowimagecontent default">';
                html_tab +='<div class="boxaddshowimagecontentinner">';
                    html_tab +='<div class="image-main" style="background-image: url('+image_url+')"></div>';
                    html_tab +='<div class="boxshowimagecontent"></div>';
                html_tab +='</div>';
            html_tab +='</div>';
            html_tab +='<div id="boxaddtextshowfunctionmore"></div>';
        html_tab += '</div>';

        // Tab mô tả

        html_tab +='<div class="boxaddcontent boxdesfunction">';
            html_tab +='<div class="boxaddimagedetailfunction">';
                html_tab +='<img class="imageadddes" src="'+image_url+'">';
                html_tab +='<div class="tabdescontent"></div>';
                html_tab +='<div id="tabdescontentfeatured"></div>';
                html_tab +='<div id="tabdescontentlink" class="tabdescontentlink">';
                html_tab += '  <div class="addlinkthem addlinkthem-detail no-slider-for version01" id="addlinkthem">';
                html_tab += '      <ul class="edit-news slider addlinkthem-slider">';

                html_tab +='       </ul>';
                html_tab +='   </div>';
                html_tab +='</div>';
            html_tab +='</div>';
        html_tab +='</div>';

        // Tab thêm chữ trên ảnh

        html_tab +='<div class="boxaddcontent boxaddtextimage">';
            html_tab += '<div class="boxaddtextimagecontent">';
                html_tab +='<img src="'+image_url+'">';
                html_tab +='<div style="vertical-align: middle">';
                    html_tab +='<div class="slider-text-item">';
                        
                    html_tab +='</div>';
                html_tab +='</div>';
            html_tab += '</div>';
            html_tab += '<div id="boxaddtextimagecontentword"></div>';
        html_tab +='</div>';

        // Thêm Link


        html_tab += '<div class="boxaddcontent boxaddtextlink">';
            html_tab +='<div class="boxaddlinkimagecontent">';
                html_tab +='<img src="'+image_url+'">';
            html_tab +='</div>';
        html_tab += '</div>';


        // Hiệu ứng

        html_tab +='<div class="boxaddcontent boximageffect">';
            html_tab +='<div class="boxaddeffectimagecontent">';
            html_tab +='</div>';
        html_tab +='</div>';

    html_tab +='</div>';

    $('#addNewsFrontEnd #boxwork').html(html_tab);

    $.ajax({
        url: main_url+'tintuc/getproducthome',
        processData: false,
        contentType: false,
        type: 'GET',
        dataType : 'json',
        success:function(data){
            var html_product = '';
            $.each(data, function( index, value ) {
              html_product +='<option data-value="'+value.pro_name+'" value="'+value.pro_id+'">'+value.pro_name+'</option>';
            });
            $('#list_products').append(html_product);
        }
    });

    var dkrm = new Darkroom('#target', {
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

                var image_id    = $('.menu-edit-image').attr('data-id');
                var data_image = JSON.parse(formData.get('images['+image_id+']'));
                if(data_image == null) {
                    var error_msg = '';

                    error_msg +='<h2>THÔNG BÁO LỖI</h2>';
                    error_msg +='<div class="error-msg-inner">';
                        error_msg +='<p>Không tìm thấy hình</p>';
                    error_msg +='</div>';
                    $('#myError .content-icon-option').html(error_msg);
                    openpopup('#myError');
                }else {
                    var the_file = Base64ToImage(newImage);

                    var addimage = new FormData();
                    addimage.set('image_crop', the_file, data_image.image_name);
                    console.log('addnews-images.js:646');
                    $.ajax({
                        url: main_url+'addimage',
                        processData: false,
                        contentType: false,
                        data: addimage,
                        type: 'POST',
                        dataType : 'json',
                        success:function(data){
                            if(data.type == 'error') {
                                var error_msg = '';

                                error_msg +='<h2>THÔNG BÁO LỖI</h2>';
                                error_msg +='<div class="error-msg-inner">';
                                    error_msg +='<p>'+data.message+'</p>';
                                error_msg +='</div>';
                                $('#myError .content-icon-option').html(error_msg);
                                openpopup('#myError');
                            }else {
                                data_image.image_crop_true = data.image_crop_true;
                                formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
                            }
                            
                        }
                    });
                }
                
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
        //cropPlugin.requireFocus();
      }
    });

    if(!audios_images){
        $.ajax({
            url: website_url+'tintuc/listaudioslider',
            processData: false,
            contentType: false,
            type: 'POST',
            dataType : 'json',
            data: formData,
            success:function(data){
                if(data){
                    var html = '<select class="select-azibai select-audio" id="textaudioselect">';
                    $.each(data, function( key, value ) {
                        html += '<option value="'+value+'">'+value+'</option>';
                    });
                    html += '</select>';
                    audios_images = '<div class="modal-body">' + html + '</div>';
                    $('body').append($.fn.tplModal.getHtml(audios_images, {
                        'type' : 'modal-dialog-centered modal-dialog-sm slideInUp-animated',
                        'title' : 'Chọn Nhạc trong kho azibai',
                        'class'	: 'images addnews-audio-from-azibai',
                        'buttons': [
                            'btnNo',
                            {
                                'btn'  : 'btnYes',
                                'class': 'btn-share btn-save-select-audio-from-azibai',
                            }
                        ],
                    }));
                }
            }
        });
    }

    if(!audios_url){
        audios_url = '<div class="modal-body"><input placeholder="url audio mp3" type="text" class="input-audio"></div>';
        $('body').append($.fn.tplModal.getHtml(audios_url, {
            'type'  : 'modal-dialog-centered modal-dialog-sm slideInUp-animated',
            'title' : 'Phát nhạc theo liên kết',
            'class'	: 'images addnews-audio-from-url',
            'buttons': [
                'btnNo',
                {
                    'btn'  : 'btnYes',
                    'class': 'btn-share btn-save-select-audio-from-url',
                }
            ],
        }));
    }

});

// Set hình đại diện
$(document).on('click', '.setbackground' , function() {
    
    var image_id    = $(this).attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));

    $('#pretitlecontent').css('background-image','url('+data_image.image_url+')');
    if($('#pretitlecontent').find('.backgroundfillteraddnews').length == 0) {
        $('#pretitlecontent').prepend('<div class="backgroundfillteraddnews"></div>');
    }
    $('#pretitlecontent').addClass('have-bg-img');
    formData.set('not_display',1);
    formData.set('not_image',data_image.image_name);
});

// Delete hình
$(document).on('click', '.deleteimagegallary', function(event) {

    //Lấy index của tấm hình
    var id = $(this).attr('data-id');
    var data_image = JSON.parse(formData.get('images['+id+']'));
    var element = $(this);
    if(is_busy == false) {
        is_busy = true;
        $.ajax({
            url: main_url+'deleteimage',
            data: data_image,
            type: 'POST',
            dataType : 'json',
            success:function(data){
                if(data.type == 'success') {
                    formData.delete('images['+id+']');
                    formData.set('have_image', formData.get('have_image')-1);
                    formData.append('images_delete[]', id);
                    element.parent().remove();
                    $('#prelistimagegallery').find('div[data-id="'+element.attr('data-id')+'"]').remove();
                }else {
                    var error_msg = '';

                    error_msg +='<h2>THÔNG BÁO LỖI</h2>';
                    error_msg +='<div class="error-msg-inner">';
                        error_msg +='<p>Có lỗi vui lòng thử lại</p>';
                    error_msg +='</div>';
                    $('#myError .content-icon-option').html(error_msg);
                    openpopup('#myError');
                }
                
            }
        }).always(function () {
            is_busy = false;
        });
    }
    return false;

});

// Kích hoạt chức năng chỉnh sửa ảnh
$(document).on('click', '.boxaddimagefunction ul li p.activetab', function () {
    var tab_cur = $(this).closest('.boxaddimagefunction ul li').attr('data-tab');
    $(this).closest('.boxaddimagefunction ul').find('li.active').removeClass('active');
    $(this).closest('.boxaddimagefunction ul li').addClass('active');
    $('.boxaddimagecontent').find('div.boxaddcontent.active').removeClass('active');
    $('.boxaddimagecontent').find('div.'+tab_cur).addClass('active');

    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));

    if(data_image.image_crop_true == 1) {
        var image_url       = data_image.main_url+data_image.image_crop;
    }else {
        var image_url       = data_image.image_url;
    }

    // Lấy list link

    var list_link = $("#tabdescontentlink").attr('data-link'); 
    
    // Xóa hình để tạo hình crop mới

    if(!tab_cur == 'boxcropfunction') {
        $('.boxaddcontent.boxcropfunction').html('');
    }

    if(tab_cur == 'boxcropfunction') {

        html_tab ='<img crossOrigin="Anonymous" src="'+data_image.main_url+data_image.image_crop+'" id="target">';

        $('.boxaddcontent.boxcropfunction').html(html_tab);
        console.log('addnews-images:630');
        var dkrm = new Darkroom('#target', {
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

                    var image_id    = $('.menu-edit-image').attr('data-id');
                    var data_image = JSON.parse(formData.get('images['+image_id+']'));
                    if(data_image == null) {
                        var error_msg = '';

                        error_msg +='<h2>THÔNG BÁO LỖI</h2>';
                        error_msg +='<div class="error-msg-inner">';
                            error_msg +='<p>Không tìm thấy hình</p>';
                        error_msg +='</div>';
                        $('#myError .content-icon-option').html(error_msg);
                        openpopup('#myError');
                    }else {
                        var the_file = Base64ToImage(newImage);

                        var addimage = new FormData();
                        addimage.set('image_crop', the_file, data_image.image_name);

                        $.ajax({
                            url: main_url+'addimage',
                            processData: false,
                            contentType: false,
                            data: addimage,
                            type: 'POST',
                            dataType : 'json',
                            success:function(data){
                                if(data.type == 'error') {
                                    var error_msg = '';

                                    error_msg +='<h2>THÔNG BÁO LỖI</h2>';
                                    error_msg +='<div class="error-msg-inner">';
                                        error_msg +='<p>'+data.message+'</p>';
                                    error_msg +='</div>';
                                    $('#myError .content-icon-option').html(error_msg);
                                    openpopup('#myError');
                                }else {
                                    data_image.image_crop_true = data.image_crop_true;
                                    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
                                }
                                
                            }
                        });
                    }
                    
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
            //cropPlugin.requireFocus();
          }
        });
    }

    if(tab_cur == 'boximageshow') {
        if(typeof data_image.show != 'undefined' && typeof data_image.show.type_show != 'undefined') {
            var sDataShow = data_image.show.type_show;
            $('.boxaddtextshowfunction').find('button.active').removeClass('active');
            $('.boxaddtextshowfunction').find('button[data-show="'+sDataShow+'"]').addClass('active');
        }

        $('.boxaddshowimagecontentinner .image-main').attr('style','background-image: url('+image_url+')');

        var html_show = '';
        if(typeof data_image.title != 'undefined') {
            html_show += '<div class="title">'+data_image.title+'</div>';
        }
        if(typeof data_image.content != 'undefined') {
            html_show += '<div class="des">'+nl2br(data_image.content)+'</div>';
        }

        if(list_link != undefined) {
            list_link = JSON.parse(list_link);
            html_show += '<div class="tabdescontentlink">';
            html_show += '  <div class="addlinkthem addlinkthem-detail no-slider-for version01" id="addlinkthem">';
            html_show += '      <ul class="edit-news slider addlinkthem-slider">';
                                    $.each(list_link, function ( index, item) {
                                        html_show += news_link_template({
                                            'detail_link'   : 'javascript:void(0)',
                                            'url_image'     : item.image,
                                            'url_link'      : item.save_link,
                                            'title_link'    : item.title,
                                            'host_name'     : item.host,
                                            'num_item'      : index,
                                        }, link_html_add_item);
                                    });
            html_show +='       </ul>';
            html_show +='   </div>';
            html_show +='</div>';
                    
        }
        
        if(typeof data_image.icon_list != 'undefined') {
            html_show += '<div class="list_icon">';
                $.each(data_image.icon_list, function ( index, item) {
                    html_show += '<div class="icon-item-featured '+item.position+'">';
                        html_show += '<div class="image">';
                            html_show += '<img src="'+item.icon_url+'">';
                            html_show += '<button type="button" class="close remove-icon-item" data-icon="'+index+'">×</button>';
                        html_show += '</div>';
                        html_show += '<div class="infomation">';
                            html_show += '<div class="title">'+item.title+'</div>';
                            html_show += '<div class="des">'+item.desc+'</div>';
                        html_show += '</div>';
                    html_show += '</div>';
                });
                html_show += '<div class="clear"></div>';
            html_show += '</div>';
        }
        
        $('.boximageshow .boxshowimagecontent').html(html_show);
    }

    if(tab_cur == 'boximageffect') {
       
        var html_effect = '';
        var html_overlay = '';
        var css = {};

        if(typeof data_image.imgeffect != 'undefined') {
            $('#imageeffectselect').val(data_image.imgeffect);
        }

        if(typeof data_image.texteffect != 'undefined') {
            $('#imagetexteffectselect').val(data_image.texteffect);
        }

        if(typeof data_image.show != 'undefined') {
            if(data_image.show.type_show == 'backgroundimage') {
                css = {
                    'background-image' : 'url('+image_url+')',
                    'background-color' : '',
                    'color'            : '#fff'
                };

                html_overlay = '<div class="overlay_bg" style="opacity:'+data_image.show.overlay_bg+'"></div>';
                
            } else if (data_image.show.type_show == 'backgroundcolor') {
                css = {
                    'background-image' : '',
                    'background-color' : data_image.show.backgroud_color,
                    'color'            : data_image.show.color_text
                };

            }else {
                css = {
                    'background-image' : '',
                    'background-color' : '#ffffff',
                    'color'            : '#000000'
                };
            }
        }
  
        $('.boxaddeffectimagecontent').css(css);
        
        html_effect +='<div class="boxaddeffectimagecontentinner">';
            html_effect +=html_overlay;
            html_effect +='<div class="image-main" style="background-image: url('+image_url+')"></div>';
            html_effect +='<div class="boxeffectcontent">';
                if(typeof data_image.title != 'undefined') {
                    html_effect += '<div class="title">'+data_image.title+'</div>';
                }
                if(typeof data_image.des != 'undefined') {
                    html_effect += '<div class="des">'+data_image.des+'</div>';
                }
                
                if(typeof data_image.icon_list != 'undefined') {
                    html_effect += '<div class="list_icon">';
                        $.each(data_image.icon_list, function ( index, item) {
                            html_effect += '<div class="icon-item-featured '+item.position+'">';
                                html_effect += '<div class="image">';
                                    html_effect += '<img src="'+item.icon_url+'">';
                                    html_effect += '<button type="button" class="close remove-icon-item" data-icon="'+index+'">×</button>';
                                html_effect += '</div>';
                                html_effect += '<div class="infomation">';
                                    html_effect += '<div class="title">'+item.title+'</div>';
                                    html_effect += '<div class="des">'+item.desc+'</div>';
                                html_effect += '</div>';
                            html_effect += '</div>';
                        });
                        html_effect += '';
                    html_effect += '</div>';
                }

                html_effect +='<div class="action">';
                    html_effect +='<div class="action-left">';
                        html_effect +='<ul class="action-left-listaction">';
                            html_effect +='<li class="like"><img class="icon-img" src="'+website_url+'templates/home/styles/images/svg/like.svg" alt="like"></li>';
                            html_effect +='<li class="comment"><a href=""><img class="icon-img" src="'+website_url+'templates/home/styles/images/svg/comment.svg" alt="comment"></a></li>';
                            html_effect +='<li class="share">';
                                html_effect +='<span class="share-click">';
                                    html_effect +='<img class="icon-img" src="'+website_url+'templates/home/styles/images/svg/share.svg" alt="share">';
                                html_effect +='</span>';
                            html_effect +='</li>';
                        html_effect +='</ul>';
                    html_effect +='</div>';
                html_effect +='</div>';
                html_effect +='<div class="show-number-action">';
                    html_effect +='<div class="action-left">';
                        html_effect +='<ul>';
                            html_effect +='<li>0 lượt thích</li>';
                            html_effect +='<li> bình luận</li>';
                            html_effect +='<li>0 chia sẻ</li>';
                        html_effect +='</ul>';
                    html_effect +='</div>';
                    html_effect +='<div class="action-right">';
                         html_effect +='<ul>';
                            html_effect +='<li><a href="">Chi tiết</a></li>';
                            html_effect +='<li><a href="">Xem thêm</a></li>';
                        html_effect +='</ul>';
                    html_effect +='</div>';
                html_effect +='</div>';
            html_effect +='</div>';
        html_effect += '</div>';
        $('.boxaddeffectimagecontent').html(html_effect);
    }

    // Tab mô tả ảnh

    if(tab_cur == 'boxdesfunction') {
        
        if(typeof data_image.title != 'undefined' || typeof data_image.content != 'undefined') {
            var title       = '';
            var content     = '';
            if(typeof data_image.title != 'undefined') {
                title = data_image.title;
            }

            if(typeof data_image.content != 'undefined') {
                content = data_image.content;
            }

            addImageDes(title,content);
        }

        $('.boxdesfunction').find('img.imageadddes').attr('src',data_image.image_url);

        if(typeof data_image.icon_list != 'undefined') {
            $('#tabdescontentfeatured').html('');
            $.each(data_image.icon_list, function( index, item ) {
                addIconHtml('#tabdescontentfeatured',data_image.image_id+index,'addimage',item);
            });
            
        }

        if(typeof data_image.list_link !== 'undefined') {
            $.each(data_image.list_link, function( index, item ) {
                console.log('item', item);
                var temp_image = '';
                if(item.image){
                    temp_image = link_server_image +'/'+ item.image;
                }else{
                    temp_image = item.link_image;
                }

                var temp_obj = {
                    'id'            : item.id,
                    'data_num'      : index,
                    'detail_url'    : domain_use + 'image-link/' + item.id,
                    'domain_use'    : domain_use,
                    'link_origin'   : item.link,
                    'type_link'     : 'image-link',
                    'title'         : (item.title ? item.title : item.link_title),
                    'host'          : item.host
                };

                if(item.video){
                    temp_obj.image_poster   = 'poster="'+ temp_image +'"';
                    temp_obj.is_muted       = 'muted';
                    temp_obj.video          = link_server_image +'/'+ item.video;
                }else{
                    temp_obj.image        = temp_image;
                    temp_obj.media_button = '';
                }
                $('#tabdescontentlink .addlinkthem-slider').append(replace_link_template(temp_obj, link_template['content_item'].template, 'content_item'));
            });

        }
        
    }

    // Tab mô tả ảnh

    if(tab_cur == 'boxaddtextimage' && typeof data_image.text_list != 'undefined') {
        if(typeof data_image.text_list.text_bg != 'undefined'){
            $('#bg_color_button').val(data_image.text_list.text_bg);
            $('.boxaddtextimagecontent').find('.slider-text-item').css({'background-color': data_image.text_list.text_bg});
        }

        if(typeof data_image.text_list.text_color != 'undefined'){
            $('#text_color_button').val(data_image.text_list.text_color);
            $('.boxaddtextimagecontent').find('.slider-text-item').css({'background-color': data_image.text_list.text_color});
        }

        if(typeof data_image.text_list.text_font != 'undefined'){
           $('#textfontselect').val(data_image.text_list.text_font);
        }

        if(typeof data_image.text_list.effect != 'undefined'){
           $('#texteffectselect').val(data_image.text_list.effect);
        }

        if(typeof data_image.text_list.align_vertical != 'undefined'){
            alignVertical(data_image.text_list.align_vertical);
        }

        if(typeof data_image.text_list.list_text_content != 'undefined') {
            if($('#tabtextadd').attr('data-numner') == 0) {
                $.each(data_image.text_list.list_text_content, function( index, item ) {
                    addTextInImage('#boxaddtextimagecontentword',index,item);
                });
                $('#tabtextadd').attr('data-numner',Object.keys(data_image.text_list.list_text_content).length);
                addTextImage(data_image.text_list.list_text_content);
            }
        }
    }
    if(tab_cur == 'boxaddtextlink') {
        if(typeof data_image.link_product != 'undefined'){
           $('#list_products').val(data_image.link_product.pro_id);
        }

        if(typeof data_image.link != 'undefined'){
           $('#link_more_image').val(data_image.link);
        }
    }
    

});

// Change Backgroud
$(document).on('click', '.showbutton', function(e) {

    var html_more = '';
    var backgroundimage = '';
    var backgroundcolor = '';
    var color = '';
    var overlay_bg = '';
    var data_show = $(this).attr('data-show');

    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));
    if(data_image.image_crop_true == 1) {
        var image_url       = data_image.main_url+data_image.image_crop;
    }else {
        var image_url       = data_image.image_url;
    }
    switch(data_show) {
        case 'backgroundimage':
            if($('.boxaddshowimagecontent .boxaddshowimagecontentinner').find('.overlay_bg')) {
                $('.boxaddshowimagecontent .boxaddshowimagecontentinner .overlay_bg').remove();
            }
            $('.boxaddshowimagecontent').css('background-image','url('+data_image.image_url+')');

            $('#'+data_image.image_id).css('background-image','url('+data_image.image_url+')');
            
            $('.boxaddshowimagecontent').removeClass('default');
            $('#boxaddtextshowfunctionmore').css('display','block');

            html_more +='<div class="button-more-item">';
                html_more +='<label>Overlay</label>';
                html_more +='<input data-image-id="'+data_image.image_id+'" type="range" min="0" max="1" step="0.1" value="0.5" id="overlay"/>';
                html_more +='<div class="clear"></div>';
            html_more +='</div>';
            $('#boxaddtextshowfunctionmore').html(html_more);

            $('.boxaddshowimagecontent .boxaddshowimagecontentinner').prepend('<div class="overlay_bg"></div>');
            
            backgroundimage = data_image.image_url;
            overlay_bg = 0.5;
            break;
        case 'backgroundcolor':
            $('.boxaddshowimagecontent').removeClass('default');
            $('.boxaddshowimagecontent').css('background-image','');
            $('.boxaddshowimagecontent').css('background-color','#000000');
            $('#'+data_image.image_id).css('background-color','#000000');
            $('#boxaddtextshowfunctionmore').css('display','block');

            if($('.boxaddshowimagecontent .boxaddshowimagecontentinner').find('.overlay_bg')) {
                $('.boxaddshowimagecontent .boxaddshowimagecontentinner .overlay_bg').remove();
            }

            html_more +='<div class="select-bg-color button-more-item">';
                html_more +='<label>Chọn màu nền:</label>';
                html_more +='<input data-image-id="'+data_image.image_id+'" type="color" id="buttonshowbackgroud"/>';
                html_more +='<div class="clear"></div>';
            html_more +='</div>';
            html_more +='<div class="select-bg-color button-more-item">';
                html_more +='<label>Chọn màu chữ:</label>';
                html_more +='<input data-image-id="'+data_image.image_id+'" type="color" id="buttonshowcolor" value="#ffffff"/>';
                html_more +='<div class="clear"></div>';
            html_more +='</div>';
            $('#boxaddtextshowfunctionmore').html(html_more);

            $('.boxaddshowimagecontent .boxaddshowimagecontentinner').prepend('<div class="overlay_bg"></div>');
            
            backgroundcolor = '#000000';
            color = '#ffffff';
            break;
        default:
            $('#boxaddtextshowfunctionmore').css('display','none');
            if($('.boxaddshowimagecontent .boxaddshowimagecontentinner').find('.overlay_bg')) {
                $('.boxaddshowimagecontent .boxaddshowimagecontentinner .overlay_bg').remove();
            }
            $('.boxaddshowimagecontent').css({'background-image':'','background-color': ''});
            $('.boxaddshowimagecontent').addClass('default');
            backgroundcolor = '#ffffff';
            color = '#000000';
            $('#'+data_image.image_id).css('background-image','');
            $('#'+data_image.image_id).css('background-color','');
    }

    data_image.show = {
        'type_show'         : data_show,
        'backgroud_image'   : data_image.image_name,
        'backgroud_color'   : backgroundcolor,
        'color_text'        : color,
        'overlay_bg'        : overlay_bg
    }

    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));

    $('.boxaddtextshowfunction').find('button.active').removeClass('active');
    $(this).addClass('active');
});

// Thay đổi overlay box hiển thị
$(document).on('change', 'input#overlay', function(e) {
    var data_overlay = $(this).val();

    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));
    data_image.show.overlay_bg = data_overlay;
    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
    
    $('.boxaddshowimagecontent .boxaddshowimagecontentinner .overlay_bg').css('opacity',data_overlay);
});

// Thay đổi màu nền box hiển thị

$(document).on('change', '#buttonshowbackgroud', function(e) {

    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));
    data_image.show.backgroud_color = $(this).val();
    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));

    $('.boxaddshowimagecontent').css('background-color',$(this).val());
});

// Thay đổi màu chữ box hiển thị

$(document).on('change', '#buttonshowcolor', function(e) {
    
    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));
    data_image.show.color_text = $(this).val();

    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));

    $('.boxaddshowimagecontent').css('color',$(this).val());
});

// Add title image 

$(document).on('change', '#tabdestitle', function(e) {
    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));
    data_image.title = $(this).val();
    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
    console.log(JSON.parse(formData.get('images['+image_id+']')));
    // Add Preview
    $('#'+$('.menu-edit-image').attr('data-id')+' p.title-image').html($(this).val());
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

// Add des image 
function getUnique(arr){
 return arr.filter((e,i)=> arr.indexOf(e) >= i);
}

$(document).on('change', '#tabdescontent', function(e) {
    console.log('templates/home/js/addnews-images.js:1121');
    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));
    data_image.content = $(this).val();

    var messagea = $(this).val();

    var links = messagea.match(/\bhttps?:\/\/\S+/gi);
    if(links != null && links.length > 0) {
        links = getUnique(links);
        $.each(links, function( index, value ) {
            var get_element = $('#tabdescontentlink .link-item').find('a[href="'+value+'"]');
            if (get_element.length == 0) 
            {
                $.ajax({
                    url: main_url+'tintuc/linkinfo',
                    type: 'POST',
                    dataType : 'json',
                    data: {link:value},
                    success:function(data){

                        var num_item = 0;
                        var list_link = data_image.list_link;
                
                        if(typeof list_link != 'undefined') {
                            num_item = Object.keys(list_link).length;
                        }

                        $('#tabdescontentlink .addlinkthem-slider').append(news_link_template({
                            'detail_link'   : 'javascript:void(0)',
                            'url_image'     : data.image,
                            'url_link'      : data.save_link,
                            'title_link'    : data.title,
                            'host_name'     : data.host,
                            'num_item'      : num_item
                        }, link_html_add_item));

                        if(num_item == 0 ) {
                            list_link = {0: data};
                        }else {
                            list_link[num_item] = data;
                        }

                        data_image.list_link = list_link;
                        formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
                        $("#tabdescontentlink").attr('data-link',JSON.stringify(list_link));
                    }
                });
            }
        });
    }

    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));

    // Add Preview
    $('#'+$('.menu-edit-image').attr('data-id')+' p.des-image').html($(this).val());
});

// Thay đổi hiệu ứng block hình

$(document).on('change', '#imageeffectselect', function(e) {
    var effect = $(this).val();
    // Change data
    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));
    data_image.imgeffect = effect;
    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
});

// Thay đổi hiệu ứng chữ

$(document).on('change', '#imagetexteffectselect', function(e) {
    var texteffect = $(this).val();
    // Change data
    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));
    data_image.texteffect = texteffect;
    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
});

$(document).on('click', '#tabdesadd', function () {
    addImageDes();
});

// Delete link item 
$(document).on('click', '#tabdescontentlink .link-item .remove-link-item', function(e) {
    var id = $(this).attr('data-num');
    var id_old = $(this).attr('data-id');
    if(id_old != undefined) {
        $.ajax({
            url: main_url+'tintuc/deletecustomlink',
            type: 'POST',
            dataType : 'json',
            data: {id:id_old},
            success:function(data){
                
            }
        });    
    }

    var list_link = $("#tabdescontentlink").attr('data-link');
    if(list_link != undefined) {
        list_link = JSON.parse(list_link);

        delete list_link[Object.keys(list_link)[id]];

        $("#tabdescontentlink").attr('data-link',JSON.stringify(list_link));
    }

    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));

    data_image.list_link = list_link;

    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));

    $(this).closest('li.link-item').remove();

});
// Mở popup icon

jQuery(document).on('click','#tabdesaddfeatured', function() {
    $(this).toggleClass('opened');
    $('#myIconModal').attr('data-type','addimage');
    if ($(this).hasClass('opened')) {
        $('#myIconModal').addClass('is-open');
        $('.wrapper').addClass('drawer-open');
        $('.wrapper').find('.drawer-overlay').attr('data-popup','#tabdesaddfeatured');
        $('#myIconModal').find('.btn-back').attr('data-popup','#tabdesaddfeatured');
    } else {
        $('#myIconModal').removeClass('is-open');
        $('.wrapper').removeClass('drawer-open');
        $('.wrapper').find('.drawer-overlay').attr('data-popup','');
        $('#myIconModal').find('.btn-back').attr('data-popup','');
    }
    $('#tabdesaddfeatured').removeClass('opened');
    return false;
});

// tô màu icon chọn
$('body').on('click', '.chooseimage', function (e) {
    $(this).closest('.list-icon').find('.imagechoose').removeClass('imagechoose');
    var aimage = $(this).data('image');
    var aclass = $(this).data('class');
    $(this).addClass('imagechoose');
});

// mở tùy chọn chèn icon
$(document).on('click', '.insertimage', function (e) {
    var icon        = $('#myIconModal').find('.imagechoose').attr('data-image');
    var icon_url    = $('#myIconModal').find('.imagechoose').attr('data-image-url');
    var icon_type   = $('#myIconModal').find('.imagechoose').attr('data-type');
    if(icon != undefined || icon_url != undefined) {
        var htmlIconOption = '';
        htmlIconOption +='<div class="row">';
            htmlIconOption +='<div class="row-item-icon">';
                htmlIconOption +='<label>icon:</label>';
                htmlIconOption +='<div class="input-group">';
                    if(icon_type == 'json') {
                        htmlIconOption +='<div class="image-json" id="'+icon+'"></div>';
                    }else {
                        htmlIconOption +='<img src="'+icon_url+'">';
                    }
                htmlIconOption +='</div>';
            htmlIconOption +='</div>';
            htmlIconOption +='<div class="row-item">';
                htmlIconOption +='<select tyle="select" name="position" class="form-control">';
                    htmlIconOption +='<option value="left">Chọn vị trí</option>';
                    htmlIconOption +='<option value="left">Icon bên trái</option>';
                    htmlIconOption +='<option value="center">Icon chính giữa</option>';
                    htmlIconOption +='<option value="right">Icon bên phải</option>';
                htmlIconOption +='</select>';
            htmlIconOption +='</div>';
            htmlIconOption +='<div class="row-item">';
                htmlIconOption +='<select tyle="select" name="effect" class="form-control">';
                    htmlIconOption +='<option value="bounceInLeft" selected>Hiệu ứng</option>';
                    htmlIconOption +='<option value="fadeInLeft">Bên trái qua</option>';
                    htmlIconOption +='<option value="fadeInRight">Bên phải qua</option>';
                    htmlIconOption +='<option value="fadeInUp">Từ dưới lên</option>';
                    htmlIconOption +='<option value="fadeInUp">Từ trên xuống</option>';
                    htmlIconOption +='<option value="fadeIn">Phóng to chậm</option>';
                    htmlIconOption +='<option value="bounceIn">Phóng to nhanh</option>';
                htmlIconOption +='</select>';
            htmlIconOption +='</div>';
            htmlIconOption +='<div class="clear"></div>';
        htmlIconOption +='</div>';
        htmlIconOption +='<div class="title-icon-option">';
            if(icon_type == 'json') {
                htmlIconOption +='<div class="image-json" id="preview_'+icon+'"></div>';
            }else {
                htmlIconOption +='<img src="'+icon_url+'">';
            }
            htmlIconOption +='<input placeholder="Nhập tiêu đề" type="text" maxlength="50" name="title" class="form-control">';
             htmlIconOption +='<div class="clear"></div>';
        htmlIconOption +='</div>';
        htmlIconOption +='<div class="des-icon-option">';
            htmlIconOption +='<textarea placeholder="Mô tả" name="desc" rows="5" maxlength="100" class="form-control" rows="2"></textarea>';
        htmlIconOption +='</div>';

        $('#myIconOption .content-icon-option').html(htmlIconOption);
        closepopup('#myIconModal');
        openpopup('#myIconOption');
        if(icon_type == 'json') {
            bodymovin.loadAnimation({
              container: document.getElementById(icon),
              renderer: 'svg',
              loop: true,
              autoplay: true,
              path: icon_url
            });

            bodymovin.loadAnimation({
              container: document.getElementById('preview_'+icon),
              renderer: 'svg',
              loop: true,
              autoplay: true,
              path: icon_url
            });
        }
    }else {
        $('#myIconModal .footer-popup .error').html('<p>Vui lòng chọn icon!</p>');
    }
    
});

// Chèn icon

$(document).on('click', '.inserticon', function(e) {
    
    var element     = '';
    var icon        = $('#myIconModal').find('.imagechoose').attr('data-image');
    var icon_url    = $('#myIconModal').find('.imagechoose').attr('data-image-url');
    var icon_type   = $('#myIconModal').find('.imagechoose').attr('data-type');
    var position    = $('#myIconOption').find('select[name="position"]').val();
    var effect      = $('#myIconOption').find('select[name="effect"]').val();
    var title       = $('#myIconOption').find('input[name="title"]').val();
    var content     = $('#myIconOption').find('textarea[name="desc"]').val();
    var type        = $('#myIconModal').attr('data-type');
    var check = true;
    var num = 0;

    var data_check = [];
    var error_msg = [];

    data_check.push({'name':'icon','value':icon});
    data_check.push({'name':'icon_url','value':icon_url});
    data_check.push({'name':'position','value':position});
    data_check.push({'name':'effect','value':effect});
    data_check.push({'name':'title','value':title});
    data_check.push({'name':'content','value':content});

    var rule = {
        icon           : 'required',
        icon_url       : 'required',
        position       : 'required',
        effect         : 'required',
        title          : 'required',
        content        : 'required'
    };
    var messenge = {
        icon   : {
            required         : 'Bạn chưa chọn icon'
        },
        icon_url   : {
            required         : 'Bạn chưa chọn icon'
        },
        position   : {
            required         : 'Vui lòng chọn vị trí'
        },
        effect   : {
            required         : 'Vui lòng chọn hiệu ứng'
        },
        title   : {
            required         : 'Vui lòng chọn tiêu đề'
        },
        content   : {
            required         : 'Vui lòng nhập mô tả'
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
        var error_msg_html = '';
        jQuery.each( error_msg, function( k, v ) {
            error_msg_html +=v;
        });
        $('#myIconOption .footer-popup .error').html(error_msg_html);
    }else {
        switch(type) {
            case 'addimage':

            var image_id    = $('.menu-edit-image').attr('data-id');
            var data_image = JSON.parse(formData.get('images['+image_id+']'));

            if(typeof data_image.icon_list != 'undefined') {
                
                num = Object.keys(data_image.icon_list).length;
                data_image.icon_list[num] = {
                    'icon'      : icon,
                    'icon_url'  : icon_url,
                    'icon_type' : icon_type,
                    'position'  : position,
                    'effect'    : effect,
                    'title'     : title,
                    'desc'      : content
                };
            }else {
                data_image.icon_list = {0:{
                    'icon'      : icon,
                    'icon_url'  : icon_url,
                    'icon_type' : icon_type,
                    'position'  : position,
                    'effect'    : effect,
                    'title'     : title,
                    'desc'      : content
                }};
            }

            formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));

            element = '#tabdescontentfeatured';
            addIconHtml(element,data_image.image_id,type,data_image.icon_list[num],icon_type);
            break;
            default:
            var icon_list = {
                'icon'      : icon,
                'icon_url'  : icon_url,
                'icon_type' : icon_type,
                'position'  : position,
                'effect'    : effect,
                'title'     : title,
                'desc'      : content
            };

            formData.append('icon_list',JSON.stringify(icon_list));
            var list_icon = formData.getAll('icon_list');
            num = parseInt(Object.keys(list_icon).length - 1);
            element = '#boxaddnewsexample';
            addIconHtml(element,num,type,icon_list,icon_type);
            $(element).css('display','block');
        }
        
        closepopup('#myIconOption');
        $('#myIconModal').attr('data-type','');  
    }
    
});


// Xóa icon

$(document).on('click', '.remove-icon-item', function(e) {
    var data_id = $(this).attr('data-icon');
    var type    = $(this).attr('data-type');

    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));

    switch(type) {
        case 'addimage':
            delete data_image.icon_list[data_id];
            formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
          break;
        default:
            var icon_list = formData.getAll('icon_list');
            delete icon_list[data_id];
            formData.set('icon_list',icon_list);
    }
    if(type != undefined) {
        $('#icon_featured'+type+data_id).remove();
    }else {
        console.log('#icon_featured'+data_id);
        $('#icon_featured'+data_id).remove();
    }
    
    //$('#icon_featured'+type+data_id).remove();
    $(this).closest('.icon-item-featured').remove();
});

// Thêm text

$(document).on('click', '#tabtextadd', function(e) {
    var num = parseInt($(this).attr('data-numner'));
    
    addTextInImage('#boxaddtextimagecontentword',num,'');

    $(this).attr('data-numner',parseInt(num+1));

    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));

    if(typeof data_image.text_list.list_text_content != 'undefined') {
        var num = Object.keys(data_image.text_list.list_text_content).length;
        data_image.text_list.list_text_content[num] = '';
            
    }else {
        var align_vertical = 'middle';
        var text_bg = '';
        var text_color = '';
        var text_font = '';
        var effect = '';

        if(typeof data_image.text_list.text_bg != 'undefined'){
            text_bg = data_image.text_list.text_bg;
        }

        if(typeof data_image.text_list.text_color != 'undefined'){
            text_color = data_image.text_list.text_color;
        }

        if(typeof data_image.text_list.text_font != 'undefined'){
           text_font = data_image.text_list.text_font;
        }

        if(typeof data_image.text_list.effect != 'undefined'){
           effect = data_image.text_list.effect;
        }

        if(typeof data_image.text_list.align_vertical != 'undefined'){
            align_vertical = data_image.text_list.align_vertical;
        }

        data_image.text_list = {
            'list_text_content' : {0:''},
            'align_horizontal'  : 'left',
            'align_vertical'    : align_vertical,
            'text_bg'           : text_bg,
            'text_color'        : text_color,
            'text_font'         : text_font,
            'effect'            : effect,
        };
    }

    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
});

// Cập nhật lại nội dung

$(document).on('change', '#boxaddtextimagecontentword .text-image-item input[type="text"]', function (e) {
    var num = $(this).attr('data-id');

    // Change data
    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));

    data_image.text_list.list_text_content[num] = $(this).val();

    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));

    addTextImage(data_image.text_list.list_text_content);
});

// căn chỉnh chữ chiều ngang

$(document).on('click', '.align-horizontal .align-button', function(e) {
    var data_align = '';
    data_align = $(this).attr('data-align');

    switch(data_align) {
        case 'left':
            $('.boxaddtextimagecontent').find('.slider-text-item').css({'left':'0px', 'right' : 'auto'});
            break;
        case 'center':
            var element = $('.boxaddtextimagecontent').find('.text-image-item');
            var element_width = element.width();
            $(element).css({'left': parseInt((520 - element_width)/2)+'px', 'right' : 'auto'});
            break;
        case 'right':
            $('.boxaddtextimagecontent').find('.slider-text-item').css({'right':'0px','left':'auto'});
            break;
        default:
            $('.boxaddtextimagecontent').find('.slider-text-item').css('left','0px');
    }

    var num = 0;

    num = $('.boxaddtextimagecontent').find('.text-image-item.active').attr('data-text-item');
    
    // Change data
    
    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));

    data_image.text_list['align_horizontal'] = data_align;

    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));

});

// căn chỉnh chữ chiều dọc

$(document).on('click', '.align-vertical .align-button', function(e) {
    var data_align = '';
    data_align = $(this).attr('data-align');
    
    alignVertical(data_align);

    var num = 0;

    num = $('.boxaddtextimagecontent').find('.text-image-item.active').attr('data-text-item');

    // Change data
    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));

    data_image.text_list['align_vertical'] = data_align;

    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
    
});


// Thay đổi màu nền

$(document).on('change', '#bg_color_button', function(e) {
    
    var color = $(this).val();
    $('.boxaddtextimagecontent').find('.slider-text-item').css({'background-color': color});

    var opacity = 0.5;
    var rgbaCol = 'rgba(' + parseInt(color.slice(-6, -4), 16) + ',' + parseInt(color.slice(-4, -2), 16) + ',' + parseInt(color.slice(-2), 16) + ',' + opacity + ')';

    // Change data

    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));

    data_image.text_list['text_bg'] = color;
    data_image.text_list['rgba_color'] = rgbaCol;

    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));

});

// Thay đổi màu chữ

$(document).on('change', '#text_color_button', function(e) {
    var color = $(this).val();
    $('.boxaddtextimagecontent').find('.slider-text-item').css({'color': color});

    // Change data

    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));

    data_image.text_list['text_color'] = color ;

    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
    console.log(JSON.parse(formData.get('images['+image_id+']')));

});

// Thay đổi font

$(document).on('change', '#textfontselect', function(e) {
    var font = $(this).val();
    $('.boxaddtextimagecontent').find('.slider-text-item').css({'font-family': font});

    // Change data
    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));

    data_image.text_list['text_font'] = font;

    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
});

// Thay đổi hiệu ứng
$(document).on('change', '#texteffectselect', function(e) {
    var effect = $(this).val();

    // Change data
    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));


    data_image.text_list['effect']    = effect;

    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
});

// xóa đối tượng text trên hình
$(document).on('click', '#boxaddtextimagecontentword .text-image-item .remove-text-item', function (e) {
    var num = 0;
    num = $(this).closest('.text-image-item').attr('data-text-item');

    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));

    if(typeof data_image.text_list != 'undefined') {
        delete data_image.text_list.list_text_content[num];
    }

    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));

    $(this).closest('.text-image-item').remove();

     var htmlSlider = '<div class="textonimg0 owl-carousel text-center">';

    $.each(data_image.text_list.list_text_content, function( index, itemtext ) {
        htmlSlider +='<div data-text-item="'+num+'" style="display: table-cell; width:1%; vertical-align: middle; padding:20px;">'+itemtext+'</div>';
    });

    
    htmlSlider +='</div>';

    $('.boxaddtextimagecontent .slider-text-item').html(htmlSlider);

    $('.textonimg0').owlCarousel({ animateIn: 'fadeIn', animateOut: 'fadeOut', loop: true, margin: 0, nav: false, dots: false, autoplay: true, autoplayTimeout:2500, items: 1 });

});


function addTextImage(aListText) {

    var htmlSlider = '<div class="textonimg0 owl-carousel text-center">';

    $.each(aListText, function( index, itemtext ) {
        htmlSlider +='<div data-text-item="'+index+'" style="display: table-cell; width:1%; vertical-align: middle; padding:20px;">'+itemtext+'</div>';
    });

    htmlSlider +='</div>';

    $('.boxaddtextimagecontent .slider-text-item').html(htmlSlider);

    $('.textonimg0').owlCarousel({ animateIn: 'fadeIn', animateOut: 'fadeOut', loop: true, margin: 0, nav: false, dots: false, autoplay: true, autoplayTimeout:2500, items: 1 });
}

// Tạo link liên kết sản phẩm

$(document).on('change', '#list_products', function (e) {

    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));

    data_image.link_product = {'pro_id':$(this).val(),'pro_name': $(this).find(":selected").text()};
    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
});

// Tạo link tùy chọn

$(document).on('change', '#link_more_image', function (e) {
    
    var image_id    = $('.menu-edit-image').attr('data-id');
    var data_image = JSON.parse(formData.get('images['+image_id+']'));

    data_image.link = $(this).val();
    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));

});

/************************** edit video *************************************/

$(document).on('click', '.editvideogallary', function(e) {
    var iVideoId = formData.get('not_video');
    if(iVideoId != null) {
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
    }else {
        var error_msg_html = '<h2>THÔNG BÁO</h2>';
        error_msg_html +='<div class="error-msg-inner">';
            error_msg_html +='<p>Có lỗi vui lòng thử lại<p>';
        error_msg_html +='</div>';

        $('#myError .content-icon-option').html(error_msg_html);
        openpopup('#myError');
    }
});
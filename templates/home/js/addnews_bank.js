// hiện thị đầy đủ thông tin

$(document).on('click', '#buttonaddfunction', function(e) {

});

// Thêm nội dung nổi bật 

$(document).on('click', '.addfeaturednews, #buttonaddnewhot', function (e) {
    $('#myIconModal').attr('data-type','addnews');
    $('#myIconModal').modal('show');
});

jQuery(document).on('click','#contentNewsFrontEnd', function() {
    //$(this).blur();
    //$('#contentNews').modal('show');
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

jQuery(document).on('click','.drawer-overlay, .js-back', function() {
    $('.bandangnghigi').removeClass('opened');
    $('.model-content').removeClass('is-open');
    $('.wrapper').removeClass('drawer-open');
    return false;
});

$(document).on("change",".buttonAddImage",function(event) {
    $('#boxaddimagegallery').css('display','block');
    var files = event.target.files;
    for (var i = 0; i < files.length; i++) {
        var file = files[i];

        // Duyệt từng file trong danh sách và render vào DIV trống đặt sẵn
        renderFileInfo(file);
    }
});

$(document).on('click', '.setbackground' , function() {
    data_image = JSON.parse($(this).parent().attr('data-image'));
    
    $('#boxaddnewsexample').css('background-image','url('+data_image.image_url+')');
    if($('#boxaddnewsexample').find('.backgroundfillteraddnews').length == 0) {
        $('#boxaddnewsexample').prepend('<div class="backgroundfillteraddnews"></div>');
    }
    $('#boxaddnewsexample').addClass('have-bg-img');
    formData.set('not_display',1);
    formData.set('not_image',data_image.image_url);
});

$(document).on('click', '.deleteimagegallary', function(event) {
    var sImageId = $(this).attr('data-id');
    var oListImage = formData.getAll('images');
    formData.delete('images');
    $.each(oListImage, function( index, item ) {
        item_object = JSON.parse(item);
        if(item_object.id == sImageId) {
            delete oListImage[index]; 
        }else {
            formData.append('images', item);
        }

    });
    $(this).parent().remove();
    return false;
});

function GenerateRandomString(len){
    var d = new Date();
    var text = d.getTime();
    
    return text;
}

function renderFileInfo(file) {
    var fileReader = new FileReader();
    fileReader.onload = function(e) {
        
        var id = GenerateRandomString(10);

        var data_image = {
            'image_url'     : e.target.result
        };

        var html = '';
        html +='<div class="boxaddimagegallerybox" id="'+id+'" style="background-image: url('+e.target.result+')" data-image='+JSON.stringify(data_image)+'>';
            html +='<div class="backgroundfillter"></div>';
            html +='<button class="setbackground"></button>';
            html +='<button data-toggle="modal" data-target="#boxEditImageNews" class="editimagegallary" data-id="'+id+'" data-url="'+e.target.result+'"></button>';
            html +='<button class="deleteimagegallary" data-id="'+id+'"></button>';
        html +='</div>';
        $(html).insertBefore('#boxaddimagegallery .boxaddmoreimage');
        var images = formData.getAll('images');
        images = {
            'id'        : id,
            'image_name': file.name,
            'image_url' : e.target.result
        };
        formData.append('images', JSON.stringify(images));
    }
    fileReader.readAsDataURL(file);
}

$(document).on('click', '.editimagegallary', function() {

    var html = '';
    var image_url       = $(this).attr('data-url');

    // Add image 
    var data_image = {};
    data_image.id_image = $(this).attr('data-id');
    data_image.image_url = image_url;
    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));
    
    html +='<img src="'+image_url+'" id="target">';
   
    $('#boxEditImageNews .modal-body .boxaddimagecontent').html(html);
    
    var tab_des = '';

    tab_des +='<div class="boxaddcontent boxdesfunction">';
        tab_des +='<div class="boxaddimagemorefunction">';
            tab_des +='<ul class="des-image">';
                tab_des +='<li id="tabdesadd" class="active">';
                tab_des +='<i class="icon_pen_image"></i>';
                tab_des +='<p>Nội dung mô tả</p>';
                tab_des +='</li>';
                tab_des +='<li id="tabdesaddfeatured" class="">';
                tab_des +='<i class="icon_pen_image"></i>';
                tab_des +='<p>Nội dung nổi bật</p>';
                tab_des +='</li>';
            tab_des +='</ul>';
        tab_des +='</div>';
        tab_des +='<div class="boxaddimagedetailfunction">';
            tab_des +='<img class="imageadddes" src="'+image_url+'">';
            tab_des +='<div class="tabdescontent"></div>';
            tab_des +='<div id="tabdescontentfeatured"></div>';
        tab_des +='</div>';
    tab_des +='</div>';

    $('#boxEditImageNews .modal-body .boxaddimagecontent').append(tab_des);

    // Tab Chữ trên ảnh

    tab_text = '';

    tab_text += '<div class="boxaddcontent boxaddtextimage">';
        tab_text += '<div class="boxaddtextimagefunction">';
            tab_text +='<ul class="text-image">';
                tab_text +='<li id="tabtextadd" data-numner="0">';
                tab_text +='<i class="icon_pen_image"></i>';
                tab_text +='<span>Thêm chữ</span>';
                tab_text +='</li>';
                tab_text +='<li class="text-align-local">';
                tab_text +='<i class="icon_local_image"></i>';
                tab_text +='<div class="align-horizontal">';
                    tab_text +='<i class="fa fa-align-left align-button" data-align="left" id="align_horizontal_left" aria-hidden="true"></i>';
                    tab_text +='<i class="fa fa-align-center align-button" data-align="center" id="align_horizontal_center" aria-hidden="true"></i>';
                    tab_text +='<i class="fa fa-align-right align-button" data-align="right" id="align_horizontal_right" aria-hidden="true"></i>';
                tab_text +='</div>';
                tab_text +='<div class="align-vertical">';
                    tab_text +='<i class="icon_align_top_image align-button" data-align="top" id="align_vertical_top"></i>';
                    tab_text +='<i class="icon_align_center_image align-button" data-align="middle" id="align_vertical_center"></i>';
                    tab_text +='<i class="icon_align_right_image align-button" data-align="bottom" id="align_vertical_bottom"></i>';
                tab_text +='</div>';
                tab_text +='</li>';
                tab_text +='<li id="textbackground">';
                    tab_text +='<i class="icon_color_mix_image"></i>';
                    tab_text +='<input type="color" id="bg_color_button"><span>Màu nền</span>';
                tab_text +='</li>';
                tab_text +='<li id="textcolor">';
                    tab_text +='<i class="icon_color_mix_image"></i>';
                    tab_text +='<input type="color" id="text_color_button"><span>Màu Chữ</span>';
                tab_text +='</li>';
                tab_text +='<li id="textfont">';
                    tab_text +='<i class="icon_font_image"></i>';
                    tab_text +='<select id="textfontselect">';
                        tab_text +='<option value="" selected>Font chữ</option>';                         
                        tab_text +='<option value="Anton">Anton</option>';
                        tab_text +='<option value="Arsenal">Arsenal</option>';
                        tab_text +='<option value="Exo">Exo</option>';
                        tab_text +='<option value="Francois One">Francois One</option>';
                        tab_text +='<option value="Muli">Muli</option>';
                        tab_text +='<option value="Nunito Sans">Nunito Sans</option>';
                        tab_text +='<option value="Open Sans Condensed">Open Sans Condensed</option>';
                        tab_text +='<option value="Oswald">Oswald</option>';
                        tab_text +='<option value="Pattaya">Pattaya</option>';
                        tab_text +='<option value="Roboto Condensed">Roboto Condensed</option>';
                        tab_text +='<option value="Saira Condensed">Saira Condensed</option>';
                        tab_text +='<option value="Saira Extra Condensed">Saira Extra Condensed</option>';
                    tab_text +='</select>';
                tab_text +='</li>';
                tab_text +='<li id="texteffect">';
                    tab_text +='<i class="icon_affect_image"></i>';
                    tab_text +='<select id="texteffectselect">';
                        tab_text +='<option value="" selected>Hiệu ứng</option>';
                        tab_text +='<option value="fadeIn">fadeIn</option>';
                        tab_text +='<option value="fadeInUp">fadeInUp</option>'
                        tab_text +='<option value="fadeInDown">fadeInDown</option>';
                        tab_text +='<option value="fadeInLeft">fadeInLeft</option>';
                        tab_text +='<option value="fadeInRight">fadeInRight</option>';
                        tab_text +='<option value="bounceIn">bounceIn</option>';
                        tab_text +='<option value="bounceInUp">bounceInUp</option>';
                        tab_text +='<option value="bounceInDonw">bounceInDonw</option>';
                        tab_text +='<option value="bounceInLeft">bounceInLeft</option>';
                        tab_text +='<option value="bounceInRight">bounceInRight</option>'; 
                        tab_text +='<option value="rotateIn">rotateIn</option>';
                        tab_text +='<option value="rotateInUpLeft">rotateInUpLeft</option>';
                        tab_text +='<option value="rotateInUpRight">rotateInUpRight</option>';
                        tab_text +='<option value="rotateInDownLeft">rotateInDownLeft</option>';
                        tab_text +='<option value="rotateInDownRight">rotateInDownRight</option>';
                        tab_text +='<option value="slideInUp">slideInUp</option>';
                        tab_text +='<option value="slideInDown">slideInDown</option>';
                        tab_text +='<option value="slideInLeft">slideInLeft</option>';
                        tab_text +='<option value="slideInRight">slideInRight</option>';
                        tab_text +='<option value="zoomIn">zoomIn</option>';
                        tab_text +='<option value="zoomInUp">zoomInUp</option>';
                        tab_text +='<option value="zoomInDown">zoomInDown</option>';
                        tab_text +='<option value="zoomInLeft">zoomInLeft</option>';
                        tab_text +='<option value="zoomInRight">zoomInRight</option>';
                    tab_text +='</select>';
                tab_text +='</li>';
            tab_text +='</ul>';
        tab_text += '</div>';
        tab_text += '<div class="boxaddtextimagecontent">';
            tab_text +='<img src="'+image_url+'">';
        tab_text += '</div>';
    tab_text += '</div>';

    $('#boxEditImageNews .modal-body .boxaddimagecontent').append(tab_text);

    // Thêm Link

    tab_link = '';

    tab_link += '<div class="boxaddcontent boxaddtextlink">';
        tab_link +='<div class="boxaddtextlinkfunction">';
            tab_link +='<select id="list_products">';
                tab_link +='<option value="">Liên kết sản phẩm</option>';
            tab_link +='</select>';
            tab_link +='<div class="item-link-image">';
                tab_link +='<label>Link xem thêm : </label>';
                tab_link +='<input id="link_more_image" name="link_more_image"/>';
            tab_link +='</div>';
        tab_link +='</div>';
        tab_link +='<div class="boxaddlinkimagecontent">';
            tab_link +='<img src="'+image_url+'">';
        tab_link +='</div>';
    tab_link += '</div>';

    $('#boxEditImageNews .modal-body .boxaddimagecontent').append(tab_link);


    // Tab hiển thị

    var tab_show = '';

    tab_show += '<div class="boxaddcontent boximageshow">';
        tab_show +='<div class="boxaddtextshowfunction">';
            tab_show +='<button class="showbutton active" id="showdefault" data-show="default">Mặc định</button>';
            tab_show +='<button class="showbutton" id="showBackgroundImage" data-show="backgroundimage">Ảnh nền</button>';
            tab_show +='<button class="showbutton" id="showBackgroundColor" data-show="backgroundcolor">Màu nền</button>';
            tab_show +='<div id="boxaddtextshowfunctionmore"></div>';
        tab_show +='</div>';
        tab_show +='<div class="boxaddshowimagecontent default">';
            tab_show +='<div class="boxaddshowimagecontentinner">';
                tab_show +='<div class="image-main" style="background-image: url('+image_url+')"></div>';
                tab_show +='<div class="boxshowimagecontent"></div>';
            tab_show +='</div>';
        tab_show +='</div>';
    tab_show += '</div>';

    $('#boxEditImageNews .modal-body .boxaddimagecontent').append(tab_show);


    var tab_effect = '';

    tab_effect +='<div class="boxaddcontent boximageffect">';
        tab_effect +='<div class="boxaddtexteffectfunction">';
            tab_effect +='<h3>Chọn hiệu ứng ảnh</h3>';
            tab_effect +='<select id="imageeffectselect">';
                tab_effect +='<option value="" selected>Hiệu ứng</option>';
                tab_effect +='<option value="fadeIn">fadeIn</option>';
                tab_effect +='<option value="fadeInUp">fadeInUp</option>'
                tab_effect +='<option value="fadeInDown">fadeInDown</option>';
                tab_effect +='<option value="fadeInLeft">fadeInLeft</option>';
                tab_effect +='<option value="fadeInRight">fadeInRight</option>';
                tab_effect +='<option value="bounceIn">bounceIn</option>';
                tab_effect +='<option value="bounceInUp">bounceInUp</option>';
                tab_effect +='<option value="bounceInDonw">bounceInDonw</option>';
                tab_effect +='<option value="bounceInLeft">bounceInLeft</option>';
                tab_effect +='<option value="bounceInRight">bounceInRight</option>'; 
                tab_effect +='<option value="rotateIn">rotateIn</option>';
                tab_effect +='<option value="rotateInUpLeft">rotateInUpLeft</option>';
                tab_effect +='<option value="rotateInUpRight">rotateInUpRight</option>';
                tab_effect +='<option value="rotateInDownLeft">rotateInDownLeft</option>';
                tab_effect +='<option value="rotateInDownRight">rotateInDownRight</option>';
                tab_effect +='<option value="slideInUp">slideInUp</option>';
                tab_effect +='<option value="slideInDown">slideInDown</option>';
                tab_effect +='<option value="slideInLeft">slideInLeft</option>';
                tab_effect +='<option value="slideInRight">slideInRight</option>';
                tab_effect +='<option value="zoomIn">zoomIn</option>';
                tab_effect +='<option value="zoomInUp">zoomInUp</option>';
                tab_effect +='<option value="zoomInDown">zoomInDown</option>';
                tab_effect +='<option value="zoomInLeft">zoomInLeft</option>';
                tab_effect +='<option value="zoomInRight">zoomInRight</option>';
            tab_effect +='</select>';
        tab_effect +='</div>';
        tab_effect +='<div class="boxaddeffectimagecontent">';
        tab_effect +='</div>';
    tab_effect +='</div>';

    $('#boxEditImageNews .modal-body .boxaddimagecontent').append(tab_effect); 

    var dkrm = new Darkroom('#target', {
      // Size options
      minWidth: 100,
      minHeight: 100,
      maxWidth: 400,
      maxHeight: 400,
      //ratio: 4/3,
      backgroundColor: '#000',

      // Plugins options
      plugins: {
        save: {
            callback: function() {
                this.darkroom.selfDestroy(); // Cleanup
                var newImage = dkrm.canvas.toDataURL();
                fileStorageLocation = newImage;
            }
        },
        //save: false,
        crop: {
          quickCropKey: 67, //key "c"
          //minHeight: 50,
          //minWidth: 50,
          ratio: 1
        }
      },

      // Post initialize script
      initialize: function() {
        var cropPlugin = this.plugins['crop'];
        cropPlugin.selectZone(0, 0, 600, 450);
        // cropPlugin.requireFocus();
      }
    });

    $.ajax({
        url: siteUrl+'tintuc/getproducthome',
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
});

// Active tab image

$(document).on('click', '.boxaddimagefunction ul li', function () {
   var tab_cur = $(this).attr('data-tab');
   $(this).parent().find('li.active').removeClass('active');
   $(this).addClass('active');
   $('.boxaddimagecontent').find('div.active').removeClass('active');
   $('.boxaddimagecontent').find('div.'+tab_cur).addClass('active');

   if(tab_cur == 'boximageshow') {
        var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));
        var html_show = '';
        if(typeof data_image.title != 'undefined') {
            html_show += '<div class="title">'+data_image.title+'</div>';
        }
        if(typeof data_image.des != 'undefined') {
            html_show += '<div class="des">'+data_image.des+'</div>';
        }
        
        if(typeof data_image.icon_list != 'undefined') {
            html_show += '<div class="list_icon">';
                $.each(data_image.icon_list, function ( index, item) {
                    html_show += '<div class="icon-item-featured '+item.position+'">';
                        html_show += '<div class="image">';
                            html_show += '<img src="'+item.icon_url+'">';
                        html_show += '</div>';
                        html_show += '<div class="infomation">';
                            html_show += '<div class="title">'+item.title+'</div>';
                            html_show += '<div class="des">'+item.content+'</div>';
                        html_show += '</div>';
                    html_show += '</div>';
                    html_show += '<div class="clearfix"></div>';
                });
                html_show += '';
            html_show += '</div>';
        }
        
        $('.boximageshow .boxshowimagecontent').html(html_show);
   }
   if(tab_cur == 'boximageffect') {
        var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));
        var html_effect = '';
        var html_overlay = '';
        var css = {};

        if(typeof data_image.show != 'undefined') {
            if(data_image.show.type_show == 'backgroundimage') {
                css = {
                    'background-image' : 'url('+data_image.show.backgroud_image+')',
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
            html_effect +='<div class="image-main" style="background-image: url('+data_image.image+')"></div>';
            html_effect +='<div class="boxeffectcontent">';
                if(typeof data_image.title != 'undefined') {
                    html_effect += '<div class="title">'+data_image.title+'</div>';
                }
                if(typeof data_image.des != 'undefined') {
                    html_effect += '<div class="des">'+data_image.des+'</div>';
                }
                html_effect += '<ul class="list-button-link">';
                    html_effect += '<li>';
                        html_effect += '<i class="fa fa-pencil-square-o" aria-hidden="true"></i></br>';
                        html_effect += 'Chỉnh sửa';
                    html_effect += '</li>';
                    html_effect += '<li>';
                        html_effect += '<i class="azicon white icon-eye"></i></br>';
                        html_effect += 'Chi tiết';
                    html_effect += '</li>';
                    html_effect += '<li>';
                        html_effect += '<i class="azicon white icon-share"></i></br>';
                        html_effect += 'Chia sẻ';
                    html_effect += '</li>';
                    html_effect += '<li>';
                        html_effect += '<i class="fa fa-ellipsis-h" aria-hidden="true"></i></br>';
                        html_effect += 'Xem thêm';
                    html_effect += '</li>';
                html_effect += '</ul>';
            html_effect +='</div>';
        html_effect += '</div>';
        $('.boxaddeffectimagecontent').html(html_effect);
   }
});

$(document).on('click', '#tabdesadd', function () {
    var sDesImage = '';
    sDesImage += '<input maxlength="60" name="tabdestitle" id="tabdestitle" placeholder="Nhập tiêu để mô tả"/>';
    sDesImage += '<textarea maxlength="250" name="tabdescontent" id="tabdescontent" placeholder="Nhập mô tả"></textarea>';
    if($('.tabdescontent').find('input#tabdestitle').length == 0) {
        $('.tabdescontent').prepend(sDesImage);
    }
});

$(document).on('click', '#tabdesaddfeatured', function () {
    $('#myIconModal').attr('data-type','addimage');
    $('#myIconModal').modal('show');
});

$('body').on('click', '.chooseimage', function (e) {
    $(this).closest('.list-icon').find('.imagechoose').removeClass('imagechoose');
    var aimage = $(this).data('image');
    var aclass = $(this).data('class');
    $('.aicon').css('outline', 'none');
    $(this).find('img').css('outline', '1px solid blue');
    $(this).addClass('imagechoose');
});
$(document).on('click', '.insertimage', function (e) {
    var icon        = $('#myIconModal').find('.imagechoose').attr('data-image');
    var icon_url    = $('#myIconModal').find('.imagechoose').attr('data-image-url');
    var htmlIconOption = '';
    htmlIconOption +='<div class="row">';
        htmlIconOption +='<div class="col-sm-4 col-xs-12" style="margin-bottom:15px">';
            htmlIconOption +='Icon:';
            htmlIconOption +='<div class="input-group">';
                htmlIconOption +='<img src="'+icon_url+'">';
            htmlIconOption +='</div>';
        htmlIconOption +='</div>';
        htmlIconOption +='<div class="col-sm-4 col-xs-12" style="margin-bottom:15px">';
            htmlIconOption +='Chọn vị trí:';
            htmlIconOption +='<select tyle="select" name="position" class="form-control">';
                htmlIconOption +='<option value="left">Icon bên trái</option>';
                htmlIconOption +='<option value="center">Icon chính giữa</option>';
                htmlIconOption +='<option value="right">Icon bên phải</option>';
            htmlIconOption +='</select>';
        htmlIconOption +='</div>';
        htmlIconOption +='<div class="col-sm-4 col-xs-12" style="margin-bottom:15px">';
            htmlIconOption +='Hiệu ứng:';
            htmlIconOption +='<select tyle="select" name="effect" class="form-control">';
                htmlIconOption +='<option value="fadeInLeft">fadeInLeft</option>';
                htmlIconOption +='<option value="fadeInRight">fadeInRight</option>';
                htmlIconOption +='<option value="fadeInUp">fadeInUp</option>';
                htmlIconOption +='<option value="fadeInDown">fadeInDown</option>';
            htmlIconOption +='</select>';
        htmlIconOption +='</div>';
        htmlIconOption +='<div class="col-sm-12 col-xs-12" style="margin-bottom:15px">';
            htmlIconOption +='Tiêu đề:';
            htmlIconOption +='<input type="text" maxlength="50" name="title" class="form-control">';
        htmlIconOption +='</div>';
        htmlIconOption +='<div class="col-sm-12 col-xs-12" style="margin-bottom:15px">';
            htmlIconOption +='Mô tả:';
            htmlIconOption +='<textarea name="desc" maxlength="100" class="form-control" rows="2"></textarea>';
        htmlIconOption +='</div>';
    htmlIconOption +='</div>';
    $('#myIconOption .modal-body').html(htmlIconOption);
    $('#myIconOption').modal('show');
});

// Chèn icon

$(document).on('click', '.inserticon', function(e) {
    var htmlIcon = '';
    var element  = '';
    var icon     = $('#myIconModal').find('.imagechoose').attr('data-image');
    var icon_url = $('#myIconModal').find('.imagechoose').attr('data-image-url');
    var position = $('#myIconOption').find('select[name="position"]').val();
    var effect   = $('#myIconOption').find('select[name="effect"]').val();
    var title    = $('#myIconOption').find('input[name="title"]').val();
    var content  = $('#myIconOption').find('textarea[name="desc"]').val();
    var type = $('#myIconModal').attr('data-type');
    var num = 0;

    switch(type) {
        case 'addimage':
            
            var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));
            var list_icon = data_image.icon_list;
            if(typeof list_icon != 'undefined') {
                num = Object.keys(list_icon).length;
                data_image.icon_list[num] = {
                    'icon'      : icon,
                    'icon_url'  : icon_url,
                    'position'  : position,
                    'effect'    : effect,
                    'title'     : title,
                    'content'   : content
                };
            }else {
                data_image.icon_list = {0:{
                    'icon'      : icon,
                    'icon_url'  : icon_url,
                    'position'  : position,
                    'effect'    : effect,
                    'title'     : title,
                    'content'   : content
                }};
            }

            $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));

            element = '#tabdescontentfeatured';

            break;
        default:
            var icon_list = {
                'icon'      : icon,
                'icon_url'  : icon_url,
                'position'  : position,
                'effect'    : effect,
                'title'     : title,
                'content'   : content
            };

            formData.append('icon_list',JSON.stringify(icon_list));
            var list_icon = formData.getAll('icon_list');
            num = parseInt(Object.keys(list_icon).length - 1);
            element = '#boxaddnewsexample';
    }

    htmlIcon += '<div class="icon-item-featured '+position+'">';
        htmlIcon += '<div class="image">';
            htmlIcon += '<img src="'+icon_url+'">';
            htmlIcon += '<button type="button" class="close remove-icon-item" data-icon="'+num+'">×</button>';
        htmlIcon += '</div>';
        htmlIcon += '<div class="infomation">';
            htmlIcon += '<div class="title">'+title+'</div>';
            htmlIcon += '<div class="des">'+content+'</div>';
        htmlIcon += '</div>';
    htmlIcon += '</div>';
    htmlIcon += '<div class="clearfix"></div>';

    $(element).append(htmlIcon);

});

// Xóa icon

$(document).on('click', '.remove-icon-item', function(e) {
    var data_id = $(this).attr('data-icon');
    var type = $('#myIconModal').attr('data-type');
    switch(type) {
        case 'addimage':
            var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));
            delete data_image.icon_list[data_id];
            $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));
          break;
        default:
            var icon_list = formData.getAll('icon_list');
            delete icon_list[data_id];
            formData.set('icon_list',icon_list);
    }
    $(this).closest('.icon-item-featured').remove();
});

// Thêm text

$(document).on('click', '#tabtextadd', function(e) {
    var num = parseInt($(this).attr('data-numner'));
    var htmlText = '';

    $('.boxaddtextimagecontent').find('.text-image-item.active').removeClass('active');

    htmlText +='<div class="text-image-item active" data-text-item="'+num+'" style="position: absolute;left:0px;top:0px;">';
        htmlText +='<input type="text" id="text_'+num+'">';
        htmlText +='<button type="button" class="close remove-text-item">×</button>';
    htmlText +='</div>';
    $('.boxaddtextimagecontent').append(htmlText);
    $(this).attr('data-numner',num+1);

    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));
    if(num == 0) {
        data_image.text_list = {0:{
            'text_content'      : '',
            'align_horizontal'  : 'left',
            'align_vertical'    : 'top',
            'text_bg'           : '',
            'text_color'        : '',
            'text_font'         : '',
            'effect'            : '',
        }};
    }else {
        data_image.text_list[num] = {
            'text_content'      : '',
            'align_horizontal'  : 'left',
            'align_vertical'    : 'top',
            'text_bg'           : '',
            'text_color'        : '',
            'text_font'         : '',
            'effect'            : '',
        };
    }
    
    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));
});


// căn chỉnh chữ chiều ngang

$(document).on('click', '.align-horizontal .align-button', function(e) {
    var data_align = '';
    data_align = $(this).attr('data-align');
    switch(data_align) {
        case 'left':
            $('.boxaddtextimagecontent').find('.text-image-item.active').css('left','0px');
            break;
        case 'center':
            var element = $('.boxaddtextimagecontent').find('.text-image-item.active');
            var element_width = element.width();
            $(element).css({'left': parseInt((335 - element_width)/2)+'px', 'right' : 'auto'});
            break;
        case 'right':
            $('.boxaddtextimagecontent').find('.text-image-item.active').css({'right':'0px','left':'auto'});
            break;
        default:
            $('.boxaddtextimagecontent').find('.text-image-item.active').css('left','0px');
    }

    var num = 0;

    num = $('.boxaddtextimagecontent').find('.text-image-item.active').attr('data-text-item');

    // Change data
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));

    data_image.text_list[num] = {
        'text_content'      : data_image.text_list[num].text_content,
        'align_horizontal'  : data_align,
        'align_vertical'    : data_image.text_list[num].align_vertical,
        'text_bg'           : data_image.text_list[num].text_bg,
        'text_color'        : data_image.text_list[num].text_color,
        'text_font'         : data_image.text_list[num].text_font,
        'effect'            : data_image.text_list[num].effect,
    };
    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));
});

// căn chỉnh chữ chiều dọc

$(document).on('click', '.align-vertical .align-button', function(e) {
    var data_align = '';
    data_align = $(this).attr('data-align');
    switch(data_align) {
        case 'top':
            $('.boxaddtextimagecontent').find('.text-image-item.active').css('top','0px');
            break;
        case 'middle':
            var element = $('.boxaddtextimage .boxaddtextimagecontent img');
            var element_height = element.height();
            $('.boxaddtextimagecontent').find('.text-image-item.active').css('top',(element_height/2)+'px');
            break;
        case 'bottom':
            $('.boxaddtextimagecontent').find('.text-image-item.active').css({'top':'auto','bottom':'0px'});
            break;
        default:
            $('.boxaddtextimagecontent').find('.text-image-item.active').css({'left':'0px','top':'0px'});
    }

    var num = 0;

    num = $('.boxaddtextimagecontent').find('.text-image-item.active').attr('data-text-item');

    // Change data
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));

    data_image.text_list[num] = {
        'text_content'      : data_image.text_list[num].text_content,
        'align_horizontal'  : data_image.text_list[num].align_horizontal,
        'align_vertical'    : data_align,
        'text_bg'           : data_image.text_list[num].text_bg,
        'text_color'        : data_image.text_list[num].text_color,
        'text_font'         : data_image.text_list[num].text_font,
        'effect'            : data_image.text_list[num].effect,
    };
    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));
    
});

// Thay đổi hình nền

$(document).on('change', '#bg_color_button', function(e) {
    var num = $('.boxaddtextimagecontent').find('.text-image-item.active').attr('data-text-item');
    var color = $(this).val();
    $('.boxaddtextimagecontent').find('.text-image-item.active').css({'background-color': color});

    var opacity = 0.5;
    var rgbaCol = 'rgba(' + parseInt(color.slice(-6, -4), 16) + ',' + parseInt(color.slice(-4, -2), 16) + ',' + parseInt(color.slice(-2), 16) + ',' + opacity + ')';

    // Change data
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));

    data_image.text_list[num] = {
        'text_content'      : data_image.text_list[num].text_content,
        'align_horizontal'  : data_image.text_list[num].align_horizontal,
        'align_vertical'    : data_image.text_list[num].align_vertical,
        'text_bg'           : color,
        'rgba_color'        : rgbaCol,
        'text_color'        : data_image.text_list[num].text_color,
        'text_font'         : data_image.text_list[num].text_font,
        'effect'            : data_image.text_list[num].effect,
    };
    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));

});

// Thay đổi màu chữ

$(document).on('change', '#text_color_button', function(e) {
    var num = $('.boxaddtextimagecontent').find('.text-image-item.active').attr('data-text-item');
    var color = $(this).val();
    $('.boxaddtextimagecontent').find('.text-image-item.active').css({'color': color});

    // Change data
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));

    data_image.text_list[num] = {
        'text_content'      : data_image.text_list[num].text_content,
        'align_horizontal'  : data_image.text_list[num].align_horizontal,
        'align_vertical'    : data_image.text_list[num].align_vertical,
        'text_bg'           : data_image.text_list[num].text_bg,
        'text_color'        : color,
        'text_font'         : data_image.text_list[num].text_font,
        'effect'            : data_image.text_list[num].effect,
    };
    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));

});

// Thay đổi font

$(document).on('change', '#textfontselect', function(e) {
    var num = $('.boxaddtextimagecontent').find('.text-image-item.active').attr('data-text-item');
    var font = $(this).val();
    $('.boxaddtextimagecontent').find('.text-image-item.active').css({'font-family': font});


    // Change data
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));

    data_image.text_list[num] = {
        'text_content'      : data_image.text_list[num].text_content,
        'align_horizontal'  : data_image.text_list[num].align_horizontal,
        'align_vertical'    : data_image.text_list[num].align_vertical,
        'text_bg'           : data_image.text_list[num].text_bg,
        'text_color'        : data_image.text_list[num].text_color,
        'text_font'         : font,
        'effect'            : data_image.text_list[num].effect,
    };
    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));

});

// Thay đổi hiệu ứng

$(document).on('change', '#texteffectselect', function(e) {
    var num = $('.boxaddtextimagecontent').find('.text-image-item.active').attr('data-text-item');
    var effect = $(this).val();

    // Change data
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));

    data_image.text_list[num] = {
        'text_content'      : data_image.text_list[num].text_content,
        'align_horizontal'  : data_image.text_list[num].align_horizontal,
        'align_vertical'    : data_image.text_list[num].align_vertical,
        'text_bg'           : data_image.text_list[num].text_bg,
        'text_color'        : data_image.text_list[num].text_color,
        'text_font'         : data_image.text_list[num].text_font,
        'effect'            : effect,
    };
    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));

});

// xóa đối tượng text trên hình

$(document).on('click', '.boxaddtextimagecontent .text-image-item .remove-text-item', function (e) {
    var num = 0;
    num = $(this).closest('.text-image-item').attr('data-text-item');

    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));

    delete data_image.text_list[num];

    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));
    $(this).closest('.text-image-item').remove();

});

// active lại khi click

$(document).on('click', '.boxaddtextimagecontent .text-image-item input[type="text"]', function (e) {
    $('.boxaddtextimagecontent').find('.text-image-item.active').removeClass('active');
    $(this).closest('.text-image-item').addClass('active');
});

// Cập nhật lại nội dung

$(document).on('change', '.boxaddtextimagecontent .text-image-item input[type="text"]', function (e) {
    var num = $('.boxaddtextimagecontent').find('.text-image-item.active').attr('data-text-item');

    // Change data
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));

    data_image.text_list[num] = {
        'text_content'      : $(this).val(),
        'align_horizontal'  : data_image.text_list[num].align_horizontal,
        'align_vertical'    : data_image.text_list[num].align_vertical,
        'text_bg'           : data_image.text_list[num].text_bg,
        'text_color'        : data_image.text_list[num].text_color,
        'text_font'         : data_image.text_list[num].text_font,
        'effect'            : data_image.text_list[num].effect,
    };
    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));
    console.log(data_image);
});

// Add title image 

$(document).on('change', '#tabdestitle', function(e) {
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));
    data_image.title = $(this).val();
    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));
});

// Add des image 

$(document).on('change', '#tabdescontent', function(e) {
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));
    data_image.des = $(this).val();
    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));
});

// Change Backgroud

$(document).on('click', '.showbutton', function(e) {
    var html_more = '';
    var backgroundimage = '';
    var backgroundcolor = '';
    var color = '';
    var overlay_bg = '';
    var data_show = $(this).attr('data-show');
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));
    switch(data_show) {
        case 'backgroundimage':
            if($('.boxaddshowimagecontent .boxaddshowimagecontentinner').find('.overlay_bg')) {
                $('.boxaddshowimagecontent .boxaddshowimagecontentinner .overlay_bg').remove();
            }
            $('.boxaddshowimagecontent').css('background-image','url('+data_image.image_url+')');
            $('.boxaddshowimagecontent').removeClass('default');
            $('#boxaddtextshowfunctionmore').css('display','block');

            html_more +='<h3>Tùy chọn</h3>';
            html_more +='<div class="button-more-item">';
                html_more +='<label>Overlay</label>';
                html_more +='<input type="range" min="0" max="1" step="0.1" value="0.5" id="overlay"/>';
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
            $('#boxaddtextshowfunctionmore').css('display','block');
            if($('.boxaddshowimagecontent .boxaddshowimagecontentinner').find('.overlay_bg')) {
                $('.boxaddshowimagecontent .boxaddshowimagecontentinner .overlay_bg').remove();
            }

            html_more +='<h3>Tùy chọn</h3>';
            html_more +='<div class="button-more-item">';
                html_more +='<label>Chọn màu nền:</label>';
                html_more +='<input type="color" id="buttonshowbackgroud"/>';
                html_more +='<div class="clearfix"></div>';
            html_more +='</div>';
            html_more +='<div class="button-more-item">';
                html_more +='<label>Chọn màu chữ:</label>';
                html_more +='<input type="color" id="buttonshowcolor" value="#ffffff"/>';
                html_more +='<div class="clearfix"></div>';
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
            $('.boxaddshowimagecontent').css('background-image','');
            $('.boxaddshowimagecontent').addClass('default');
            backgroundcolor = '#ffffff';
            color = '#000000';
    }

    data_image.show = {
        'type_show'         :data_show,
        'backgroud_image'   : backgroundimage,
        'backgroud_color'   : backgroundcolor,
        'color_text'        : color,
        'overlay_bg'        : overlay_bg
    };
    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));


    $('.boxaddtextshowfunction').find('button.active').removeClass('active');
    $(this).addClass('active');
});

// Thay đổi overlay box hiển thị

$(document).on('change', 'input#overlay', function(e) {
    var data_overlay = $(this).val();
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));
   
    data_image.show = {
        'type_show'         : data_image.show.type_show,
        'backgroud_image'   : data_image.show.backgroud_image,
        'backgroud_color'   : data_image.show.backgroud_color,
        'color_text'        : data_image.show.color_text,
        'overlay_bg'        : data_overlay
    };

    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));
    $('.boxaddshowimagecontent .boxaddshowimagecontentinner .overlay_bg').css('opacity',data_overlay);
});

// Lưu hiệu ứng hình

$(document).on('change', 'select#imageeffectselect', function(e) {
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));
   
    data_image.data_effect = $(this).val();

    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));
});

// Thay đổi màu nền box hiển thị

$(document).on('change', '#buttonshowbackgroud', function(e) {
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));
   
    data_image.show = {
        'type_show'         : data_image.show.type_show,
        'backgroud_image'   : data_image.show.backgroud_image,
        'backgroud_color'   : $(this).val(),
        'color_text'        : data_image.show.color_text,
        'overlay_bg'        : data_image.show.data_overlay
    };

    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));

    $('.boxaddshowimagecontent').css('background-color',$(this).val());
});

// Thay đổi màu chữ box hiển thị

$(document).on('change', '#buttonshowcolor', function(e) {

    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));
   
    data_image.show = {
        'type_show'         : data_image.show.type_show,
        'backgroud_image'   : data_image.show.backgroud_image,
        'backgroud_color'   : data_image.show.backgroud_color,
        'color_text'        : $(this).val(),
        'overlay_bg'        : data_image.show.data_overlay
    };

    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));

    $('.boxaddshowimagecontent').css('color',$(this).val());
});


// Tạo link liên kết sản phẩm

$(document).on('change', '#list_products', function (e) {
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));
    data_image.link_product = {'pro_id':$(this).val(),'pro_name': $(this).find(":selected").text()};
    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));
});

// Tạo link tùy chọn

$(document).on('change', '#link_more_image', function (e) {
    var data_image = JSON.parse($("#boxEditImageNews").attr('data-image'));
    data_image.link_extend = $(this).val();
    $("#boxEditImageNews").attr('data-image',JSON.stringify(data_image));
});

// get chuyên mục tin

$(document).on('click', '.addcategoriesnews, #buttonaddcategories', function() {
    $.ajax({
        url: siteUrl+'tintuc/getcategoriesnewshome',
        processData: false,
        contentType: false,
        type: 'POST',
        dataType : 'json',
        success:function(data){
            var list_category = '<select class="addcategorynews">';
            list_category +='<option value="">Tin thuộc chuyên mục</option>';
            $.each(data, function( index, value ) {
              list_category +='<option value="'+value.cat_id+'">'+value.cat_name+'</option>';
            });
            list_category +='</select>';
            $('#boxaddfunction').html(list_category);
        }
    });
});

// chèn input mô tả ngắn

$(document).on('click', '.adddesnews', function() {
    
    var not_description = '';
    if(formData.get('not_description') != null) {
        not_description = formData.get('not_description');
    }

    var adddesnews = '<input name="adddesnews" value="'+not_description+'" id="adddesnews"/ placeholder="Nhập mô tả ngắn">';

    $('#boxaddfunction').html(adddesnews);
});


// chèn input từ khóa

$(document).on('click', '.addkeywordnews', function() {
    var not_keywords = '';
    if(formData.get('not_keywords') != null) {
        not_keywords = formData.get('not_keywords');
    }

    var addkeywordnews = '<input name="addkeywordnews" value="'+not_keywords+'" id="addkeywordnews"/ placeholder="Nhập từ khóa">';

    $('#boxaddfunction').html(addkeywordnews);
});

// chèn input Link xem thêm

$(document).on('click', '.addlinkextendnews', function() {
    
    var addlinkextendnews = '<input name="addlinkextendnews" id="addlinkextendnews"/ placeholder="Nhập link xem thêm">';

    $('#boxaddfunction').html(addlinkextendnews);
});

// Chèn box quảng cáo

$(document).on('click', '.addadsnews', function() {
    $('#boxAdsNews .boxaddadscontent').html('');
    var image_url = '';
    var tab_bg = '';
    tab_bg +='<div class="boxaddcontent boxaddimageadsfunction active">';
        tab_bg += '<div class="boxaddadsemorefunction">';
            tab_bg +='<h3>Chọn hình để làm hình nền</h3>';
            tab_bg +='<div class="buttonaddbgadsinner">';
                tab_bg +='<span>Chọn hình</span>';
                tab_bg +='<input type="file" accept="image/*" name="image" class="buttonaddbgads">';
            tab_bg +='</div>';     
        tab_bg += '</div>';
        tab_bg += '<div class="boxaddadsdetailfunction">';

        tab_bg += '</div>';
    tab_bg += '</div>';
    $('#boxAdsNews .boxaddadscontent').append(tab_bg);

    // Tab crop hình

    tab_crop ='<div class="boxaddcontent boxcropimageadsfunction"></div>';

    $('#boxAdsNews .boxaddadscontent').append(tab_crop);

    // Tab nọi dung quảng cáo
    var data_ads = JSON.parse($("#boxAdsNews").attr('data-ads'));

    tab_content = '';
    tab_content +='<div class="boxaddcontent boxtextadsfunction">';
        tab_content +='<div class="boxaddtextadsfunction">';
            tab_content +='<div class="textaddads-item">';
                tab_content +='<h4>Nội dung 1:</h4>';
                tab_content +='<div class="textaddads-item-content">';
                    tab_content +='<input name="textads-item-1" placeholder="Nhập tiêu đề">';
                    tab_content +='<textarea placeholder="Nhập nội dung" name="desads-item-1"></textarea>';
                tab_content +='</div>';
            tab_content +='</div>';
            tab_content +='<div class="textaddads-item">';
                tab_content +='<h4>Nội dung 2:</h4>';
                tab_content +='<div class="textaddads-item-content">';
                    tab_content +='<input name="textads-item-2" placeholder="Nhập tiêu đề">';
                    tab_content +='<textarea placeholder="Nhập nội dung" name="desads-item-2"></textarea>';
                tab_content +='</div>';
            tab_content +='</div>';
            tab_content +='<div class="textaddads-item">';
                tab_content +='<h4>Nội dung 3:</h4>';
                tab_content +='<div class="textaddads-item-content">';
                    tab_content +='<input name="textads-item-3" placeholder="Nhập tiêu đề">';
                    tab_content +='<textarea placeholder="Nhập nội dung" name="desads-item-3"></textarea>';
                tab_content +='</div>';
            tab_content +='</div>';
        tab_content +='</div>';
        tab_content +='<div class="boxaddtextadsfunctionimage"></div>';
    tab_content +='</div>';

    $('#boxAdsNews .boxaddadscontent').append(tab_content);

    // Tab time 

    tab_time = '';

    tab_time +='<div class="boxaddcontent boxtimeadsfunction">';
        tab_time +='<div class="boxaddtimeadsfunction">';
            tab_time +='<h3>Thời gian quảng cáo</h3>';
            tab_time +='<input type="date" name="timeads" id="timeads"/>';
            tab_time +='<div class="clearfix"></div>';
            tab_time +='<h3>Chọn kiểu hiển thị</h3>';
            tab_time +='<div class="radio">';
                tab_time +='<label>';
                tab_time +='<input type="radio" name="ad_display" id="ad_display1" value="1" checked="">';
                    tab_time +='Đồng hồ số';
                tab_time +='</label>';
            tab_time +='</div>';
            tab_time +='<div class="clearfix"></div>';
            tab_time +='<div class="radio">';
                tab_time +='<label>';
                    tab_time +='<input type="radio" name="ad_display" id="ad_display2" value="2">';
                        tab_time +='Countdown';
                tab_time +='</label>';
            tab_time +='</div>';
        tab_time +='</div>';
        tab_time +='<div class="boxaddtimeadsdetailfunction">';
            tab_time +='<div class="boxaddtimeadsdetailfunctioninner">';
                tab_time +='<div class="overlay_bg" style=""></div>';
                tab_time +='<div class="slider"></div>';
                tab_time +='<div class="adsshowprew">';
                    tab_time +='<section class="anaclock">';
                        tab_time +='<div class="clock">';
                            tab_time +='<div class="hour"></div>';
                            tab_time +='<div class="minute"></div>';
                            tab_time +='<div class="second"></div>';
                            tab_time +='<div class="center"></div>';
                        tab_time +='</div>';
                        tab_time +='<div class="textclock" class="text-center">Thời gian còn lại</div>';
                        tab_time +='<div class="countdown" class="text-center"></div>';
                    tab_time +='</section>';
                tab_time +='</div>';
                tab_time +='<div class="text-center"><button class="readmore">Xem chi tiết</button></div>';
            tab_time +='</div>';
            tab_time +='</div>';
        tab_time +='</div>';
    tab_time +='</div>';

    $('#boxAdsNews .boxaddadscontent').append(tab_time);

    // Tab time 

    tab_link = '';

    tab_link +='<div class="boxaddcontent boxlinkadsfunction">';
        tab_link +='<div class="boxaddlinkadsfunction">';
            tab_link +='<h3>Link quảng cáo</h3>';
            tab_link +='<input type="text" name="linkextendads" id="linkextendads"/>';
            tab_link +='<div class="clearfix"></div>';
        tab_link +='</div>';
        tab_link +='<div class="boxaddlinkadsdetailfunction">';
            tab_link +='<div class="boxaddlinkadsdetailfunctioninner">';
                tab_link +='<div class="overlay_bg" style=""></div>';
                tab_link +='<div class="slider"></div>';
                tab_link +='<div class="adsshowprew">';
                    tab_link +='<section class="anaclock">';
                        tab_link +='<div class="clock">';
                            tab_link +='<div class="hour"></div>';
                            tab_link +='<div class="minute"></div>';
                            tab_link +='<div class="second"></div>';
                            tab_link +='<div class="center"></div>';
                        tab_link +='</div>';
                        tab_link +='<div class="textclock" class="text-center">Thời gian còn lại</div>';
                        tab_link +='<div class="countdown" class="text-center"></div>';
                    tab_link +='</section>';
                tab_link +='</div>';
                tab_link +='<div class="text-center"><button class="readmore">Xem chi tiết</button></div>';
            tab_link +='</div>';
            tab_link +='</div>';
        tab_link +='</div>';
    tab_link +='</div>';

    $('#boxAdsNews .boxaddadscontent').append(tab_link);

    $('#boxAdsNews').modal('show');
});

// Thêm hình quảng cáo
$(document).on("change",".buttonaddbgads", function(event) {
   
    var file = event.target.files;

    var fileReader = new FileReader();
    fileReader.onload = function(e) {

        var html ='<img data-image="'+e.target.result+'" src="'+e.target.result+'"/>';
        
        var data_ads = JSON.parse($("#boxAdsNews").attr('data-ads'));
        data_ads.image = e.target.result;
        $("#boxAdsNews").attr('data-ads',JSON.stringify(data_ads));
        $('#boxAdsNews .boxaddadsdetailfunction').html(html);
    }
    fileReader.readAsDataURL(file[0]);
});


// Active tab quảng cáo

$(document).on('click', '.boxaddadsfunction ul li', function () {
   var tab_cur = $(this).attr('data-tab');
   $(this).parent().find('li.active').removeClass('active');
   $(this).addClass('active');
   $('.boxaddadscontent').find('div.active').removeClass('active');
   $('.boxaddadscontent').find('div.'+tab_cur).addClass('active');

   if(tab_cur == 'boxcropimageadsfunction') {

        var data_ads = JSON.parse($("#boxAdsNews").attr('data-ads'));

        var tab_crop ='<img src="'+data_ads.image+'" id="targetads">';

        $('#boxAdsNews .boxaddadscontent .boxcropimageadsfunction').html(tab_crop);

        var dkrm = new Darkroom('#targetads', {
          // Size options
          minWidth: 100,
          minHeight: 100,
          maxWidth: 400,
          maxHeight: 400,
          //ratio: 4/3,
          backgroundColor: '#000',

          // Plugins options
          plugins: {
            save: {
                callback: function() {
                    this.darkroom.selfDestroy(); // Cleanup
                    var newImage = dkrm.canvas.toDataURL();
                    fileStorageLocation = newImage;
                }
            },
            //save: false,
            crop: {
              quickCropKey: 67, //key "c"
              //minHeight: 50,
              //minWidth: 50,
              ratio: 1
            }
          },

          // Post initialize script
          initialize: function() {
            var cropPlugin = this.plugins['crop'];
            cropPlugin.selectZone(0, 0, 600, 450);
            // cropPlugin.requireFocus();
          }
        });
   }

   if(tab_cur == 'boxtextadsfunction') {
        var data_ads = JSON.parse($("#boxAdsNews").attr('data-ads'));

        var tab_text ='<img src="'+data_ads.image+'">';

        $('#boxAdsNews .boxaddadscontent .boxaddtextadsfunctionimage').html(tab_text);
   }

   if(tab_cur == 'boxtimeadsfunction') {
        var data_ads = JSON.parse($("#boxAdsNews").attr('data-ads'));
        var $h = $(".boxaddtimeadsdetailfunctioninner .hour"),
            $m = $(".boxaddtimeadsdetailfunctioninner .minute"),
            $s = $(".boxaddtimeadsdetailfunctioninner .second");
        css = {
            'background-image' : 'url('+data_ads.image+')',
        };

        $('#boxAdsNews .boxaddadscontent .boxaddtimeadsdetailfunction .boxaddtimeadsdetailfunctioninner').css(css);
        
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
        var data_ads = JSON.parse($("#boxAdsNews").attr('data-ads'));
        var $h = $(".boxaddlinkadsdetailfunctioninner .hour"),
            $m = $(".boxaddlinkadsdetailfunctioninner .minute"),
            $s = $(".boxaddlinkadsdetailfunctioninner .second");
        css = {
            'background-image' : 'url('+data_ads.image+')',
        };

        $('#boxAdsNews .boxaddadscontent .boxaddlinkadsdetailfunction .boxaddlinkadsdetailfunctioninner').css(css);
        
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

        setUpFace();
        computeTimePositions($h, $m, $s);
        $("section").on("resize", setSize).trigger("resize");

        var time = $('input#timeads').val();

        $('.countdown,.countdown2').countdown(time, function(event) {
            $(this).html(event.strftime('<span><strong>%D</strong><br>Ngày</span> <span><strong>%H</strong><br>Giờ</span> <span><strong>%M</strong><br>Phút</span> <span><strong>%S</strong><br>Giây</span>'));
        });
    }
});



if (!window.requestAnimationFrame) {
    window.requestAnimationFrame = window.mozRequestAnimationFrame ||
      window.webkitRequestAnimationFrame ||
      window.msRequestAnimationFrame ||
      window.oRequestAnimationFrame ||
      function (cb) { setTimeout(cb, 1000/60); };
}

function computeTimePositions($h, $m, $s) {
    var now = new Date(),
            h = now.getHours(),
            m = now.getMinutes(),
            s = now.getSeconds(),
            ms = now.getMilliseconds(),
            degS, degM, degH;

    degS = (s * 6) + (6 / 1000 * ms);
    degM = (m * 6) + (6 / 60 * s) + (6 / (60 * 1000) * ms);
    degH = (h * 30) + (30 / 60 * m);
    $s.css({ "transform": "rotate(" + degS + "deg)" });
    $m.css({ "transform": "rotate(" + degM + "deg)" });
    $h.css({ "transform": "rotate(" + degH + "deg)" });

    requestAnimationFrame(function () {
      computeTimePositions($h, $m, $s);
    });
}

function setUpFace() {
    for (var x = 1; x <= 60; x += 1) {
      addTick(x); 
    }

    function addTick(n) {
      var tickClass = "smallTick",
              tickBox = $("<div class=\"faceBox\"></div>"),
              tick = $("<div></div>"),
              tickNum = "";

      if (n % 5 === 0) {
            tickClass = (n % 15 === 0) ? "largeTick" : "mediumTick";
            tickNum = $("<div class=\"tickNum\"></div>").text(n / 5).css({ "transform": "rotate(-" + (n * 6) + "deg)" });
            if (n >= 50) {
              tickNum.css({"left":"-0.5em"});
            }
      }


      tickBox.append(tick.addClass(tickClass)).css({ "transform": "rotate(" + (n * 6) + "deg)" });
      tickBox.append(tickNum);

      $(".clock").append(tickBox);
    }
}

function setSize(element) {
    var b = $(this), //html, body
            w = b.width(),
            x = Math.floor(w / 30) - 1,
            px = (x > 25 ? 26 : x) + "px";

    $(".clock").css({"font-size": px });

    if (b.width() !== 400) {
      setTimeout(function() { $("._drag").hide(); }, 500);
    }
}


/*********** Popup thống kê **************/
// Mở popup
$(document).on('click', '.addstaticnews', function() {

    $('#boxStaticNews .boxaddstaticcontent').html('');
    var image_url = '';
    var tab_bg = '';
    tab_bg +='<div class="boxaddcontent boxaddimagestaticfunction active">';
        tab_bg += '<div class="boxaddstaticemorefunction">';
            tab_bg +='<h3>Chọn hình để làm hình nền</h3>';
            tab_bg +='<div class="buttonaddbgstaticinner">';
                tab_bg +='<span>Chọn hình</span>';
                tab_bg +='<input type="file" accept="image/*" name="image" class="buttonaddbgstatic">';
            tab_bg +='</div>';     
        tab_bg += '</div>';
        tab_bg += '<div class="boxaddstaticdetailfunction">';

        tab_bg += '</div>';
    tab_bg += '</div>';
    $('#boxStaticNews .boxaddstaticcontent').append(tab_bg);

    // Tab crop hình

    tab_crop ='<div class="boxaddcontent boxcropimagestaticfunction"></div>';

    $('#boxStaticNews .boxaddstaticcontent').append(tab_crop);

    // Tab nọi dung quảng cáo
    var data_ads = JSON.parse($("#boxStaticNews").attr('data-static'));

    tab_content = '';
    tab_content +='<div class="boxaddcontent boxtextstaticfunction">';
        tab_content +='<div class="boxaddtextstaticfunction">';

        tab_content +='</div>';
        tab_content +='<div class="boxaddtextstaticfunctionimage">';
            tab_content +='<div class="boxaddtextstaticfunctionimageinner">';
                tab_content +='<div class="overlay_bg" style=""></div>';
                tab_content +='<div class="textaddstatic-item">';
                    tab_content +='<input type="number" name="numberstatic-item-1" placeholder="Số"/>';
                    tab_content +='<div class="textaddstatic-item-content">';
                        tab_content +='<input type="text" name="textstatic-item-1" placeholder="Nhập tiêu đề thống kê">';
                        tab_content +='<textarea placeholder="Nhập mô tả thống kê" name="desstatic-item-1"></textarea>';
                    tab_content +='</div>';
                tab_content +='</div>';
                tab_content +='<div class="textaddstatic-item">';
                    tab_content +='<input type="number" name="numberstatic-item-2" placeholder="Số"/>';
                    tab_content +='<div class="textaddstatic-item-content">';
                        tab_content +='<input type="text" name="textstatic-item-2" placeholder="Nhập tiêu đề thống kê">';
                        tab_content +='<textarea placeholder="Nhập mô tả thống kê" name="desstatic-item-2"></textarea>';
                    tab_content +='</div>';
                tab_content +='</div>';
                tab_content +='<div class="textaddstatic-item">';
                    tab_content +='<input type="number" name="numberstatic-item-3" placeholder="Số"/>';
                    tab_content +='<div class="textaddstatic-item-content">';
                        tab_content +='<input type="text" name="textstatic-item-3" placeholder="Nhập tiêu đề thống kê">';
                        tab_content +='<textarea placeholder="Nhập mô tả thống kê" name="desstatic-item-3"></textarea>';
                    tab_content +='</div>';
                tab_content +='</div>';
                tab_content +='<div class="textaddstatic-item">';
                    tab_content +='<input type="number" name="numberstatic-item-4" placeholder="Số"/>';
                    tab_content +='<div class="textaddstatic-item-content">';
                        tab_content +='<input type="text" name="textstatic-item-4" placeholder="Nhập tiêu đề thống kê">';
                        tab_content +='<textarea placeholder="Nhập mô tả thống kê" name="desstatic-item-4"></textarea>';
                    tab_content +='</div>';
                tab_content +='</div>';
            tab_content +='</div>';
        tab_content +='</div>';
    tab_content +='</div>';

    $('#boxStaticNews .boxaddstaticcontent').append(tab_content);

    $('#boxStaticNews').modal('show');
});

// Active tab quảng cáo

$(document).on('click', '.boxaddstaticfunction ul li', function () {
   var tab_cur = $(this).attr('data-tab');
   $(this).parent().find('li.active').removeClass('active');
   $(this).addClass('active');
   $('.boxaddstaticcontent').find('div.active').removeClass('active');
   $('.boxaddstaticcontent').find('div.'+tab_cur).addClass('active');

    if(tab_cur == 'boxcropimagestaticfunction') {

        var data_static = JSON.parse($("#boxStaticNews").attr('data-static'));

        var tab_crop ='<img src="'+data_static.image+'" id="targetstatic">';

        $('#boxStaticNews .boxaddstaticcontent .boxcropimagestaticfunction').html(tab_crop);

        var dkrm = new Darkroom('#targetstatic', {
          // Size options
          minWidth: 100,
          minHeight: 100,
          maxWidth: 400,
          maxHeight: 400,
          //ratio: 4/3,
          backgroundColor: '#000',

          // Plugins options
          plugins: {
            save: {
                callback: function() {
                    this.darkroom.selfDestroy(); // Cleanup
                    var newImage = dkrm.canvas.toDataURL();
                    fileStorageLocation = newImage;
                }
            },
            //save: false,
            crop: {
              quickCropKey: 67, //key "c"
              //minHeight: 50,
              //minWidth: 50,
              ratio: 1
            }
          },

          // Post initialize script
          initialize: function() {
            var cropPlugin = this.plugins['crop'];
            cropPlugin.selectZone(0, 0, 600, 450);
            // cropPlugin.requireFocus();
          }
        });
    }

    if(tab_cur == 'boxtextstaticfunction') {
        var data_static = JSON.parse($("#boxStaticNews").attr('data-static'));
        css = {
            'background-image' : 'url('+data_static.image+')',
        };

        $('#boxStaticNews .boxaddstaticcontent .boxaddtextstaticfunctionimage .boxaddtextstaticfunctionimageinner').css(css);
    }

});

// Thêm hình thống kê
$(document).on("change",".buttonaddbgstatic", function(event) {
   
    var file = event.target.files;

    var fileReader = new FileReader();
    fileReader.onload = function(e) {

        var html ='<img data-image="'+e.target.result+'" src="'+e.target.result+'"/>';
        
        var data_ads = JSON.parse($("#boxAdsNews").attr('data-ads'));
        data_ads.image = e.target.result;
        $("#boxStaticNews").attr('data-static',JSON.stringify(data_ads));
        $('#boxStaticNews .boxaddstaticdetailfunction').html(html);
    }
    fileReader.readAsDataURL(file[0]);
});

/************** Liên quan ****************/

// Mở popup
$(document).on('click', '.addrelatednews', function() {
    $('#boxRelatedNews').modal('show');
});

// Thêm nội dung

$(document).on('click', '#addcontentrelated', function() {
    var content_related = '';
    content_related +='<div class="row">';
        content_related +='<div class="col-sm-6 form-horizontal">';
            content_related +='<div class="form-group">';
                content_related +='<label for="cus_avatar" class="col-sm-3 control-label">Hình ảnh: </label>';
                content_related +='<div class="col-sm-9">';
                    content_related +='<div style="position: relative;width:116px;height:116px">';
                        content_related +='<input type="file" name="cus_avatar" class="form-control" value="">';
                        content_related +='<img style="height:116px;" class="img-responsive img-thumbnail" src="/images/noimage.jpg" alt="image preview"> </div>';
                    content_related +='</div>';
            content_related +='</div>';
            content_related +='<div class="form-group">';
                content_related +='<label for="cus_link" class="col-sm-3 control-label">Link ảnh: </label>';
                content_related +='<div class="col-sm-9">';
                    content_related +='<input type="url" name="cus_link" class="form-control" value=""> </div>';
            content_related +='</div>';
            content_related +='<div class="form-group">';
                content_related +='<label for="cus_facebook" class="col-sm-3 control-label">Facebook: </label>';
                content_related +='<div class="col-sm-9">';
                    content_related +='<input type="url" name="cus_facebook" class="form-control" value="">';
                content_related +='</div>';
            content_related +='</div>';
            content_related +='<div class="form-group">';
                content_related +='<label for="cus_twitter" class="col-sm-3 control-label">Twitter: </label>';
                content_related +='<div class="col-sm-9">';
                    content_related +='<input type="url" name="cus_twitter" class="form-control" value="">';
                content_related +='</div>';
            content_related +='</div>';
            content_related +='<div class="form-group">';
                content_related +='<label for="cus_google" class="col-sm-3 control-label">Google+: </label>';
                content_related +='<div class="col-sm-9">';
                    content_related +='<input type="url" name="cus_google" class="form-control" value="">';
                content_related +='</div>';
            content_related +='</div>';
        content_related +='</div>';
        content_related +='<div class="col-sm-6 form-horizontal">';
            content_related +='<div class="form-group">';
                content_related +='<label for="cus_text1" class="col-sm-3 control-label">Text 1: </label>';
                content_related +='<div class="col-sm-9">';
                    content_related +='<input type="text" name="cus_text1" class="form-control" value="" maxlength="30">';
                content_related +='</div>';
            content_related +='</div>';
            content_related +='<div class="form-group">';
                content_related +='<label for="cus_text2" class="col-sm-3 control-label">Text 2: </label>';
                content_related +='<div class="col-sm-9">';
                    content_related +='<input type="text" name="cus_text2" class="form-control" value="" maxlength="30">';
                content_related +='</div>';
            content_related +='</div>';
            content_related +='<div class="form-group">';
                content_related +='<label for="cus_text3" class="col-sm-3 control-label">Text 3: </label>';
                content_related +='<div class="col-sm-9">';
                    content_related +='<textarea name="cus_text3" class="form-control" rows="10"></textarea>';
                content_related +='</div>';
            content_related +='</div>';
        content_related +='</div>';
    content_related +='</div>';

    $('#addcontentRelatedBox .modal-body').html(content_related);
    $('#addcontentRelatedBox').modal('show');
});

$(document).on('change', '#addcontentRelatedBox input[name="cus_avatar"]', function (e) {
    var file = event.target.files;
    var element = $(this);
    var fileReader = new FileReader();
    fileReader.onload = function(e) {
        element.attr('data-image', e.target.result);
        $("#addcontentRelatedBox img.img-responsive.img-thumbnail").attr('src',e.target.result);

    }
    fileReader.readAsDataURL(file[0]);
});

$(document).on('click','#addcontentRelatedBox .modal-footer button.save', function (e) {

    var check = true;
    var data = [];
    var error_msg = [];

    // Avatar
    var cus_avatar = $('#addcontentRelatedBox input[name="cus_avatar"]').attr('data-image');
    data.push({
        'name':'cus_avatar',
        'value':cus_avatar
    });

    // Link
    var cus_link = $('#addcontentRelatedBox input[name="cus_link"]').val();
    data.push({
        'name':'cus_link',
        'value':cus_link
    });

    // Facebook
    var cus_facebook = $('#addcontentRelatedBox input[name="cus_facebook"]').val();
    data.push({
        'name':'cus_facebook',
        'value':cus_facebook
    });

    // Twitter
    var cus_twitter = $('#addcontentRelatedBox input[name="cus_twitter"]').val();
    data.push({
        'name':'cus_twitter',
        'value':cus_twitter
    });

    // Google+
    var cus_google = $('#addcontentRelatedBox input[name="cus_google"]').val();
    data.push({
        'name':'cus_google',
        'value':cus_google
    });

    // Text 1
    var cus_text1 = $('#addcontentRelatedBox input[name="cus_text1"]').val();
    data.push({
        'name':'cus_text1',
        'value':cus_text1
    });

    // Text 2
    var cus_text2 = $('#addcontentRelatedBox input[name="cus_text2"]').val();
    data.push({
        'name':'cus_text2',
        'value':cus_text2
    });

    // Text 3
    var cus_text3 = $('#addcontentRelatedBox textarea[name="cus_text3"]').val();
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
            'cus_avatar'    :   cus_avatar,
            'cus_link'      :   cus_link,
            'cus_facebook'  :   cus_facebook,
            'cus_twitter'   :   cus_twitter,
            'cus_google'    :   cus_google,
            'cus_text1'     :   cus_text1,
            'cus_text2'     :   cus_text2,
            'cus_text3'     :   cus_text3
        };

        formData.append('relative_item', JSON.stringify(relative_item));
        
        var data_related = formData.getAll('relative_item');

        // áp dụng hình nền 

        $('#boxrelatednews').css('background-color',cus_bg);

        // Set nội dung
        var html_related = '<div id="contentRelatedSlider" class="owl-carousel">';

        $.each(data_related, function( index, item ) {
            item = JSON.parse(item);
            html_related +='<div class="relative-item">';
                html_related +='<div style="width:100px; margin: 20px auto;">';
                    if(item.cus_link){ 
                        html_related +='<a href="'+item.cus_link+'" target="_blank">';
                            html_related +='<img class="img-responsive img-circle" src="'+item.cus_avatar+'" alt="'+item.cus_text1+'">';
                        html_related +='</a>';
                    }
                    else {
                        html_related +='<img class="img-responsive img-circle" src="/images/noimage.jpg">';
                    }
                html_related +='</div>';                             
                html_related +='<p><strong>'+item.cus_text1+'</strong></p>';
                html_related +='<p style="color:red;word-break: break-word;height:20px;overflow:hidden;text-overflow: ellipsis;display: -webkit-box;-webkit-box-orient: vertical;-webkit-line-clamp: 1;">'+item.cus_text2+'</p>';
                html_related +='<p style="font-size:small; height: 76px; overflow: hidden;word-break: break-word;">'+item.cus_text3+'</p>';
                html_related +='<p style="margin-bottom:20px;">';
                    html_related +='<button class="btn btn-sm btn-link" style="color: '+cus_color+'">&nbsp; Xem thêm &nbsp;</button></p>';
                    if(item.cus_facebook || item.cus_twitter || item.cus_google) {
                        html_related +='<p>';
                            if(item.cus_facebook){ 
                                html_related +='<a style="color: '+cus_color+';border: 1px solid; border-radius: 50%; padding: 5px;" href="'+item.cus_facebook+'" target="_blank"><i class="fa fa-facebook fa-fw"></i></a>';
                            }
                            if(item.cus_twitter){ 
                                html_related +='&nbsp; <a style="color: '+cus_color+';border: 1px solid; border-radius: 50%; padding: 5px;" href="'+item.cus_twitter+'" target="_blank"><i class="fa fa-twitter fa-fw"></i></a> &nbsp;';
                            }
                            if(item.cus_google){ 
                                html_related +='<a style="color: '+cus_color+';border: 1px solid; border-radius: 50%; padding: 5px;" href="'+item.cus_google+'" target="_blank"><i class="fa fa-google-plus fa-fw"></i></a>';
                            }                                        
                        html_related +='</p>';
                    }
            html_related +='</div>';
        });

        html_related += '</div>';

        $('#boxRelatedNews #boxrelatednews .content').html(html_related);

        $('#contentRelatedSlider').owlCarousel({ animateOut: 'fadeOutDown', animateIn: 'zoomIn', items: 2, loop: true, margin: 10, nav: false, dots: false, autoplay: false, autoplayTimeout: 3000, autoplayHoverPause: true });
        

    }
});

// Thêm title related

$(document).on('keyup', '#related_title', function(e) {
    var html_related = '<h4 class="text-center">'+$(this).val()+'</h4>';
    $('#boxRelatedNews #boxrelatednews .title').html(html_related);
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
function showSlider (effect = 'turn,shift,louvers,cube_over,tv,lines,bubbles,dribbles,glass_parallax,parallax,brick,collage,seven,kenburns,cube,blur,book,rotate,domino,slices,blast,blinds,basic,basic_linear,fade,fly,flip,page,stack,stack_vertical') {
    var html_slider = '';
    
    html_slider +='<div id="wowslider-container" class="wowslider-container">';
        html_slider +='<div class="ws_images">';
            html_slider +='<ul class="listimageslider"></ul>';
        html_slider +='</div>';
        html_slider +='<div class="ws_bullets"><div class="listimagesbullets"></div></div>';                  
    html_slider +='</div>';
    html_slider +='<audio autoplay="true">';
        html_slider +='<source id="audioSource" src="" type="audio/mpeg">';
        html_slider +='Your browser does not support the audio element.';
    html_slider +='</audio>';

    // html_slider +='<audio id="audioslider" src=""></audio>';
    $('#boxSliderNews #boxslidernews').html(html_slider);
    if(formData.getAll('images').length > 0 ) {
        var html_image = '', html_bullets = '';
        $.each(formData.getAll('images'), function( index, item ) {
            var item = JSON.parse(item);
            var title = item.image_name;
            if(typeof item.title != 'undefined') {
                title = item.title;
            }
            html_image +='<li>';
                html_image +='<img src="'+item.image_url+'" alt="'+title+'" title="'+title+'" id="wows'+index+'_0" style=""/>';
            html_image +='</li>';
        });
        $('#boxSliderNews #boxslidernews #wowslider-container .listimageslider').html(html_image);
        $.each(formData.getAll('images'), function( index, item ) {
            html_bullets +='<a href="#" title="img'+index+'">';
                html_bullets +='<span>'+index+'</span>';
            html_bullets +='</a>';
        });
        $('#boxSliderNews #boxslidernews #wowslider-container .listimagesbullets').html(html_bullets);
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
    }else {
        $.ajax({
            url: siteUrl+'tintuc/listimageslider',
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
                $('#boxSliderNews #boxslidernews #wowslider-container .listimageslider').html(html_image);
                $.each(data, function( index, item ) {
                    html_bullets +='<a href="#" title="img'+index+'">';
                        html_bullets +='<span>'+index+'</span>';
                    html_bullets +='</a>';
                });
                $('#boxSliderNews #boxslidernews #wowslider-container .listimagesbullets').html(html_bullets);

                effect = effect.replace('|',',');
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
    $('#boxSliderNews select#slider_ef').prop('selectedIndex',0);
    $('#boxSliderNews select#ms').prop('selectedIndex',0);
    showSlider();
     
    $('#boxSliderNews').modal('show');
    
});

// Thay đổi hiệu ứng

$(document).on('change', 'select#slider_ef', function(e) {
    var eff = $("select#slider_ef option:selected").val();
    showSlider(eff);
    var audio = jQuery("#boxSliderNews #boxslidernews audio");
    var source = jQuery(' source#audioSource');
    source.attr("src",siteUrl+'/media/musics/' + $("#ms option:selected").val());
    audio.load();
});

// Thay đổi audio

$(document).on('change', 'select#ms', function(e) {
    var audio_url = $("select#ms option:selected").val();
    var audio = jQuery("#boxSliderNews #boxslidernews audio");
    var source = jQuery(' source#audioSource');
    source.attr("src",siteUrl+'/media/musics/' + audio_url);
    audio.load();
});

// Tắt audio khi đóng tab 
$(document).on('hidden.bs.modal', '#boxSliderNews', function(e) {
    jQuery("#boxSliderNews #boxslidernews").html('');
});

$(document).on('click',"#boxSliderNews input[name='slideshow']", function(){
    if(Object.keys(formData.getAll('images')).length < 3) {
        alert('Ngọc ngơ phải nhập 3 tấm ảnh mới test chức năng này được!');
    }
});

/******* Lưu dữ liệu vào formdata ********/

// Lưu chuyên mục tin
$(document).on('change', 'select.addcategorynews', function(e) {
    formData.set('not_pro_cat_id', $(this).val());
});

// Lưu mô tả ngắn
$(document).on('change', 'input#adddesnews', function(e) {
    formData.set('not_description', $(this).val());
});


// Lưu từ khóa
$(document).on('change', 'input#addkeywordnews', function(e) {
    formData.set('not_keywords', $(this).val());
});

// Lưu link xem thêm
$(document).on('change', 'input#addlinkextendnews', function(e) {
    formData.set('not_video_url', $(this).val());
});


// Lưu quảng cáo

$(document).on('click','#boxAdsNews .modal-footer button.save', function (e) {
    var data_ads = JSON.parse($(this).closest("#boxAdsNews").attr('data-ads'));
    var ad_content = {};
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
                ad_content[i-1] = {
                    'title'     : title,
                    'des'       : content
                };
            }
    }
    data_ads.ad_content = ad_content;

    data_ads.ad_time        = $('#boxAdsNews input#timeads').val();
    data_ads.ad_display     = $('#boxAdsNews input[name="ad_display"]').val();
    data_ads.ad_link        = $('#boxAdsNews input#linkextendads').val();
    formData.set('ads', JSON.stringify(data_ads));
});

// Lưu thống kê
$(document).on('click','#boxStaticNews .modal-footer button.save', function (e) {
    var data_static = JSON.parse($(this).closest("#boxStaticNews").attr('data-static'));

    var data_content = {};
    for (var i = 1; i <= 4; i++) {
        var number = '';
        var title   = '';
        var content = '';
        // lấy số
        $('#boxStaticNews .boxaddtextstaticfunctionimage input[name="numberstatic-item-'+i+'"]').each(function( index ) {
            number = $( this ).val();
        });
        // lấy tiêu đề
        $('#boxStaticNews .boxaddtextstaticfunctionimage input[name="textstatic-item-'+i+'"]').each(function( index ) {
            title = $( this ).val();
        });
        // Lấy content
        $('#boxStaticNews .boxaddtextstaticfunctionimage textarea[name="desstatic-item-'+i+'"]').each(function( index ) {
           content = $( this ).val();
        });

        if(number != '' || title != '' || content != '') {
            data_content[i-1] = {
                'num'    : number,
                'title'     : title,
                'description'   : content
            };
        }
    }
    data_static.data_content = data_content;
    formData.set('static', JSON.stringify(data_static));
});

// Lưu hình ảnh

$(document).on('click','#boxEditImageNews .modal-footer button.save', function (e) {
    var data_image = JSON.parse($(this).closest("#boxEditImageNews").attr('data-image'));
    var oListImage = formData.getAll('images');

    formData.delete('images');
    $.each(oListImage, function( index, item ) {
        item_object = JSON.parse(item);
        if(item_object.id == data_image.id_image) {
            var image = {
                'id'            : data_image.id,
                'image_name'    : item_object.image_name,
                'image_url'     : data_image.image,
                'title'         : data_image.title,
                'content'       : data_image.des,
                'link'          : data_image.link_extend,
                'link_product'  : data_image.link_product,
                'show'          : data_image.show,
                'text_list'     : data_image.text_list,
                'imgeffect'     : data_image.data_effect,
                'icon_list'     : data_image.icon_list
            };
            formData.append('images', JSON.stringify(image));
        }else {
            var image = {
                'id'            : item_object.id,
                'image_name'    : item_object.image_name,
                'image_url'     : item_object.image_url,
                'title'         : item_object.title,
                'content'       : item_object.des,
                'link'          : item_object.link_extend,
                'link_product'  : item_object.link_product,
                'show'          : item_object.show,
                'text_list'     : item_object.text_list,
                'imgeffect'     : item_object.data_effect,
                'icon_list'     : item_object.icon_list
            };
            formData.append('images', JSON.stringify(image));
        }

    });

    $("#boxEditImageNews").attr('data-image','');
});

// Lưu video
$(document).on('change', '#contentNews #videonews', function(e) {
    var file = event.target.files;
    formData.set('video',file[0],file[0].name);
});

// Lưu liên quan 

$(document).on('click','#boxRelatedNews .modal-footer button.save', function (e) {
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

    var rule = {
        cus_title          : 'required',
        cus_content        : 'bool',
    };
    var messenge = {
        cus_title   : {
            required    : 'Vui lòng nhập tiêu đề !',
        },
        cus_content : {
            bool        : 'Vui thêm content!'
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
        alert(error_msg);
    }else {
        formData.set('relative_title',$('input#related_title').val());
        formData.set('related_background',$('input#related_background').val());
        formData.set('related_color',$('input#related_color').val());
        $('#boxRelatedNews').modal('hide');
    }
});

// Lưu trình diễn ảnh 

$(document).on('click','#boxSliderNews .modal-footer button.save', function (e) {
    var check = true;
    var data = [];
    var error_msg = [];

    // hiệu ứng
    var ef = $('select#slider_ef').val();
    data.push({
        'name':'ef',
        'value':ef
    });

    // nhạc nền

    var ms = $('select#ms').val();

    data.push({
        'name':'ms',
        'value':ms
    });

    // Bật tắt slider

    var status = $("#boxSliderNews input[name='slideshow']:checked").val();

    data.push({
        'name':'status',
        'value':status
    });

    // Đếm số hình

    var cout_image = formData.getAll('images');

    data.push({
        'name':'cout_image',
        'value':Object.keys(cout_image).length
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
        alert(error_msg);
    }else {
        formData.set('not_slideshow',status);
        formData.set('not_effect',ef);
        formData.set('not_music',ms);
        $('#boxSliderNews').modal('hide');
    }
});

$(document).on('click', '#buttonaddnews', function() {
    $('.dloadding').css('display','block');
    $('#contentNews #boxaddnewsexample').css('display','none');
    // $('#contentNews').modal('hide');
    formData.set('not_title',$('#boxaddnewsexample input[name="postTitle"]').val());
    formData.set('not_detail',$('#boxaddnewsexample textarea[name="postContent"]').val());
   
    var check = true;
    var data_check = [];
    var error_msg = [];

    data_check.push({'name':'not_title','value':formData.get('not_title')});
    data_check.push({'name':'not_detail','value':formData.get('not_detail')});
    data_check.push({'name':'not_description','value':formData.get('not_description')});
    data_check.push({'name':'not_keywords','value':formData.get('not_keywords')});

    var rule = {
        not_title           : 'required',
        not_detail          : 'required',
        not_description     : 'required',
        not_keywords        : 'required',
    };
    var messenge = {
        not_title   : {
            required    : 'Tiêu đề bắt buộc điền bắt buộc điền',
        },
        not_detail  : {
            required    : 'Vui lòng nhập nội dung tin',
        },
        not_description   : {
            required    : 'Vui lòng nhập mô tả tin',
        },
        not_keywords : {
            required    : 'Vui lòng nhập từ khóa tin',
        },
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
        $('.dloadding').css('display','none');
        $('#contentNews #boxaddnewsexample').css('display','block');
        $('#contentNews #showerror').html(error_msg);
    }else {
        formData.set('list_images',JSON.stringify(formData.getAll('images')));
        formData.set('relative_content',JSON.stringify(formData.getAll('relative_item')));

        $.ajax({
            url: siteUrl+'tintuc/addnewshome',
            processData: false,
            contentType: false,
            type: 'POST',
            dataType : 'json',
            data: formData,
            success:function(data){
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
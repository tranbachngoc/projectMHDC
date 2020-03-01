$(window).on("load",function(){
    if($(".js-scroll-x").length){
        $(".js-scroll-x").mCustomScrollbar({
            axis:"x",
            theme:"dark-thin",
            autoExpandScrollbar:true,
            advanced:{autoExpandHorizontalScroll:true}
        });
    }
});

function detectBackground(x) {
    if (x.matches) {
        $('.trangcuatoi.tindoanhnghiep').removeClass('display-md');
        if(!$('.trangcuatoi.tindoanhnghiep').hasClass('display-sm')){
            $('.trangcuatoi.tindoanhnghiep').addClass('display-sm');
        }
    }else {
        $('.trangcuatoi.tindoanhnghiep').removeClass('display-sm');
        if(!$('.trangcuatoi.tindoanhnghiep').hasClass('display-md')){
            $('.trangcuatoi.tindoanhnghiep').addClass('display-md');
        }
    }
}

var matchBlackBackground = window.matchMedia("(max-width: 767px)");
detectBackground(matchBlackBackground);

var timeout_resize = false;
$(window).resize(function() {
    clearTimeout(timeout_resize);
    timeout_resize = setTimeout(function () {
        detectBackground(matchBlackBackground);
    }, 300);
});

function custom_background(status){
    if(status){
        $('.group-list-link-content').addClass('custom-bg-link').removeClass('')
    }else{
        $('.group-list-link-content').removeClass('custom-bg-link')
    }
}

//page content, lirary
var link_template = {
    'content_item': {
        'image' : {
            'template'  : ''
        },
        'video' :  {
            'target'    : '',
            'template'  : '',
            'button'    : ''
        },
        'template' : '',
        'target'   : '.js_wrap-content-link-',
    },
    'content_index': {
        'image' : {
            'template'  : ''
        },
        'video' :  {
            'target'    : '',
            'template'  : '',
            'button'    : ''
        },
        'template' : '',
        'target'   : '.js_wrap-content-link-',
    },
    'image':  {
        'image' : '',
        'video' : '',
    },
    'library':  {
        'image' : '',
        'video' : '',
    },
};

link_template.content_index.template =  '<div class="wrap-link-index">';
link_template.content_index.template += '     <div class="edit_customlink js_action-link-edit" data-id="{{{id}}}">';
link_template.content_index.template += '        <img class="icon-img" src="/templates/home/styles/images/svg/pen_black.svg" alt="Chỉnh sửa link">';
link_template.content_index.template += '     </div>';
link_template.content_index.template += '     <em class="edit_customlink right js_action-link-remove" data-num="{{{data_num}}}">';
link_template.content_index.template += '        <img class="icon-img" src="/templates/home/styles/images/svg/x.svg">';
link_template.content_index.template += '      </em>';
link_template.content_index.template += '     <a href="{{{detail_url}}}" target="_blank" id="custom_link_inner_{{{id}}}" tabindex="0">';
link_template.content_index.template += '        {{{media_template}}}';
link_template.content_index.template += '     </a>';
link_template.content_index.template += '     <div class="text">';
link_template.content_index.template += '         <div class="bg-text-blur" style="background: url({{{image_url}}})"></div>';
link_template.content_index.template += '         <a href="{{{link_origin}}}" ref="nofollow" target="_blank" tabindex="0">';
link_template.content_index.template += '             <h3 class="one-line">{{{title}}}</h3>';
link_template.content_index.template += '             <p>{{{host}}}</p>';
link_template.content_index.template += '         </a>';
link_template.content_index.template += '     </div>';
link_template.content_index.template += '</div>';

link_template.content_index.image.template =  ' <p class="img">';
link_template.content_index.image.template += '     <img id="image_link_{{{id}}}" src="{{{image_url}}}" alt="" style="opacity: 1;">';
link_template.content_index.image.template += ' </p>';

link_template.content_index.video.template =  ' <p class="video img">';
link_template.content_index.video.template += '     <video id="video_customlink_{{{id}}}" {{{image_poster}}} playsinline="" {{{is_muted}}} ';
link_template.content_index.video.template += '         data-target_btn_volume=".link_btn-volume-{{{id}}}" ';
link_template.content_index.video.template += '         data-target_btn_play=".link_btn_play_{{{id}}}" ';
link_template.content_index.video.template += '         onplay="video_handle_event_play(event)" ';
link_template.content_index.video.template += '         onvolumechange="video_handle_event_volume(event)" ';
link_template.content_index.video.template += '         onpause="video_handle_event_pause(event)"';
link_template.content_index.video.template += '         preload="none">';
link_template.content_index.video.template += '         <source src="{{{source_url}}}" type="video/mp4">';
link_template.content_index.video.template += '         Your browser does not support the video tag.';
link_template.content_index.video.template += '     </video>';
link_template.content_index.video.template += '     {{{media_button}}}';
link_template.content_index.video.template += ' </p>';

link_template.content_index.video.button += '<img class="play_video_customlink js_btn-pause play_video_customlink_bigger link_btn_play_{{{id}}}" src="/templates/home/styles/images/svg/play_video.svg" alt="pause"';
link_template.content_index.video.button += '   data-target_video="#video_customlink_{{{id}}}"';
link_template.content_index.video.button += '   data-id="video_customlink_{{{id}}}">';

link_template.content_item.template  =  '<li class="wrap-item-content-link js_action-tools js_wrap-content-link-{{{id}}} js-play-video" ';
link_template.content_item.template  += '   data-domain-use="{{{domain_use}}}" ';
link_template.content_item.template  += '   data-type="{{{type_link}}}" data-id="{{{id}}}">';
link_template.content_item.template  +=     link_template.content_index.template;
link_template.content_item.template  += '</li>';

link_template.content_item.video.template   = link_template.content_index.video.template;
link_template.content_item.video.button     = link_template.content_index.video.button;
link_template.content_item.image.template   = link_template.content_index.image.template;

// link_template.content_index.video.button += '<img class="custom-link-volume volume_off js_az-volume custom-link-volume-bigger link_btn-volume-{{{id}}}"';
// link_template.content_index.video.button += '   data-target_video="#video_customlink_{{{id}}}"';
// link_template.content_index.video.button += '   src="/templates/home/styles/images/svg/icon-volume-off.svg">';

function replace_link_template(data, template, type) {
    if(!data || typeof data !== 'object' || typeof link_template[type] === 'undefined')
        return '';
    var temp = template;
    for (var index in data) {
        if(index == 'video'){
            temp = temp.replace(/{{{media_template}}}/g, replace_link_template({
                'id'           : data.id,
                'image_poster' : data.image_poster,
                'is_muted'     : data.is_muted,
                'source_url'   : data.video,
            }, link_template[type].video.template, type));

            temp = temp.replace(/{{{media_button}}}/g, replace_link_template({
                'id'           : data.id
            }, link_template[type].video.button, type));
            continue;
        }
        if(index == 'image'){
            temp = temp.replace(/{{{media_template}}}/g, replace_link_template({
                'id'           : data.id,
                'image_url'    : data.image
            }, link_template[type].image.template, type));
            continue;
        }
        temp = temp.replace(new RegExp('{{{'+index+'}}}', 'g'), data[index]);
    }
    return temp;
}

$(document).ready(function() {

    $('#popup-add-custom-link').on('hide.bs.modal', function (e) {
        $._loading();
    });

    $('#popup-add-custom-link').on('hidden.bs.modal', function () {
        $('#popup-add-custom-link .wrap-block-custom-link').html('');
    });

    function file_is_processing(process)
    {
        if(process && typeof process !== 'undefined'){
            $('.js_frm-library-link .js_image-upload-msg').text('Đang xử lý tập tin').show();
            $('.js_btn-process-link').addClass('disable').attr('title', 'Đang xử lý tập tin').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
        }else{
            $('.js_btn-process-link').removeClass('disable').removeAttr('title').html('Lưu');
        }
    }

    function show_form(frm_btn){
        if(typeof frm_btn == 'undefined'){
            return false;
        }
        var frm_title = '';
        if(frm_btn === 'create'){
            frm_btn = 'js_btn-create-library-link';
            frm_title = 'Thêm link liên kết';
        }
        if(frm_btn === 'edit'){
            frm_btn = 'js_btn-edit-library-link';
            frm_title = 'Sửa liên kết';
        }
        if(frm_btn === 'clone'){
            frm_btn = 'js_btn-clone-library-link';
            frm_title = 'Ghim liên kết';
        }

        $('#popup-add-custom-link .js_btn-process-link').attr('id', frm_btn);
        $('#popup-add-custom-link .modal-title').text(frm_title);
        $('#popup-add-custom-link').modal('show');
    }

    $(document).on('click', '.js_library-link-show-more', function (event) {
        event.preventDefault();
        $('.js_library-link-popup-action .js_action-tools').attr({
            'data-id'   : $(this).attr('data-id'),
            'data-link' : $(this).attr('data-link'),
            'data-type' : $(this).attr('data-type')
        });
        $('.js_library-link-popup-action').modal('show');
    });

    $(document).on('click', '.js_action-link-copy', function (event) {
        event.preventDefault();
        clipboard.copy($(this).parents('.js_action-tools').attr('data-link'));
        $('.js_library-link-popup-action').modal('hide');
    });

    $(document).on('change', '.js_category-parent-custom-link', function (event) {
        event.preventDefault();
        categories_child($(this), $(this).parents('form.js_frm-library-link').attr('data-target') + ' .js_category-custom-link');
    });

    $(document).on('change', '.js_library-link-belong-to', function (event) {
        event.preventDefault();
        collection_belong_to($(this).parents('form.js_frm-library-link').attr('data-target'));
    });

    function collection_belong_to(form_call)
    {
        var is_owner = $(form_call + ' input[name="is_owner"]:checked').val();
        var temp     = '<option value="">Chọn bộ sưu tập liên kết</option>';
        $.ajax({
            url: window.location.origin + '/collection/my-collections',
            type: 'POST',
            dataType: 'text',
            data: {is_owner  : is_owner},
            success: function (res) {
                if (typeof res !== 'undefined' && res) {
                    temp += res;
                }
            }
        }).always(function () {
            $(form_call +' .js_collection-custom-link').html(temp);
            if($(form_call +' .js_collection-custom-link').attr('collection-selected')){
                var temp_selected = $(form_call +' .js_collection-custom-link').attr('collection-selected');
                console.log('selected collection', temp_selected);
                $(form_call +' .js_collection-custom-link').val(JSON.parse(temp_selected)).removeAttr('collection-selected');
            }
        });
    }

    $(document).on('change', '.js_collection-category', function (event) {
        event.preventDefault();
        categories_child($(this), '.js_collection-category-child');
    });

    function categories_child(select, select_child)
    {
        if(typeof select === 'undefined' || !select || typeof select_child === 'undefined' || !select_child){
            return;
        }
        var temp = '<option value="">Chọn chuyên mục con</option>';
        var category_id = $(select).val();
        if(!category_id){
            $(select_child).html(temp);
            return;
        }
        $.ajax({
            url: window.location.origin + '/custom-link/category-child',
            type: 'POST',
            dataType: 'json',
            data: {category_id: category_id},
            success: function (res) {
                if (typeof res !== 'undefined' && res) {
                    $.each(res, function (index, val) {
                        temp += '<option value="' + val.id + '">' + val.name + '</option>';
                    });
                }
                category_child_set_html(select_child, temp);
            }
        });
    }

    function category_child_set_html(select_category_child, html)
    {
        if(!select_category_child){
            return;
        }
        $(select_category_child).html(html);
        //nếu có ghi lại selected category child bằng data-selected
        if($(select_category_child).attr('cat-selected')){
            $(select_category_child).val($(select_category_child).attr('cat-selected')).removeAttr('cat-selected');
        }else{
            $(select_category_child).val('');
        }
    }

    $('.js_category-parent-custom-link').trigger('change');
    $('.js_collection-category').trigger('change');

    /*********** upload image *************/
    $(document).on('click', '.js_custom-link-image-icon', function (event) {
        event.preventDefault();
        $($(this).parents('form.js_frm-library-link').attr('data-target') + ' .js_handle-image-upload').trigger('click')
    });

    $(document).on('change', '.js_handle-image-upload', function (event) {
        event.preventDefault();
        //attribute img-old
        $('.js_frm-library-link .js_image-upload-msg').text('').hide();

        if(event.target.files && event.target.files.length){
            var current_file = event.target.files[0];
        }

        if(typeof current_file === 'undefined' || !current_file){
            $('.js_frm-library-link .js_image-upload-msg').removeAttr('src').text('Vui lòng chọn ảnh hoặc video').fadeIn();
            return;
        }

        file_is_processing(true);

        var formData = new FormData();
        formData.append('media_file', current_file);
        $.ajax({
            url: window.location.origin + '/library-link/upload-media',
            type: 'post',
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                if (response && response.status === 1) {
                    $('.js_frm-library-link .js_image-upload-msg').text('').hide();
                    $('.js_frm-library-link .js_image_path-msg').text('').hide();
                    $('.js_frm-library-link .js_video_path-msg').text('').hide();
                    $('.js_frm-library-link .js_image-upload').val(response.image_name);
                    $('.js_frm-library-link .js_video-upload').val(response.video_name);

                    var temp_img = '';
                    if(response.image_url){
                        temp_img = response.image_url;
                    }

                    if(response.video_url){
                        var item_video = '';
                        item_video += '<video poster="'+temp_img+'" autoplay="true" playsinline preload="none" controls>';
                        item_video += '  <source src="'+response.video_url+'" type="video/mp4">';
                        item_video += '  Your browser does not support the video tag.';
                        item_video += '</video>';
                        $('.js_frm-library-link .wrap-block-custom-link').html(item_video);
                    }else{
                        $('.js_frm-library-link .wrap-block-custom-link').html('<img class="center js_custom-link-image" src="'+temp_img+'">');
                    }

                }
                if (response && response.status === 0) {
                    $('.js_frm-library-link .js_image-upload-msg').text(response.message).show();
                    $('.js_frm-library-link .js_image-upload').val('');
                    $('.js_frm-library-link .js_custom-link-image').attr('src', default_image_error_path);
                }
            }
        }).always(function() {
            file_is_processing();
        });
    });
    /*********** end upload image *************/

    /*crawl data url*/
    var node_cl = false;
    $(document).on('click','#popup-crawl-custom-link .btn_process', function(event){
        event.preventDefault();
        //reset form input
        $('.js_frm-library-link .text-danger').fadeOut().text('');
        $('.js_frm-library-link .js_handle_value').val('');
        $('.js_frm-library-link .js_custom-link-image').attr('src', '');
        $('.js_frm-library-link .wrap-block-custom-link').html('');

        $('#popup-crawl-custom-link').modal('hide');
        $._loading('show', 'body');
        var _confirm = false;
        var formData = new FormData();
        formData.append('link', $('#popup-crawl-custom-link input[name="url_process"]').val());
        $.ajax({
            url: window.location.origin + '/tintuc/linkinfo',
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response) {
                console.log('response', response);
                node_cl =  response;
                if(response.title && response.image && response.host){
                    _confirm = true;
                } else {
                    _confirm = confirm("Link xử lý hiện tại không chứa ảnh hoặc tiêu đề, bạn có muốn tiếp tục ?");
                    !response.image ? response.image = '/templates/home/styles/images/default/image_link.jpg': '';
                    !response.title ? response.title = 'Azibai link': '';
                }

                if(_confirm == true) {
                    $('.js_frm-library-link .wrap-block-custom-link').html('<img class="center js_custom-link-image" img-old="'+response.image+'" src="'+response.image+'">');
                    $('.js_frm-library-link .js_custom-link-title').val(response.title);
                    $('.js_frm-library-link .js_custom-link-description').val(response.description);
                    $('.js_frm-library-link .js_save-link').val(response.save_link);
                    //call show form create
                    show_form('create');
                    $('.js_frm-library-link input[name="is_owner"]:checked').trigger('change');
                    $('#popup-crawl-custom-link .url-processed').val('');
                }
            },
            error: function () {
                alert("Error conection!!!");
            }
        }).always(function() {
            $._loading();
        });
    });
    /*end crawl data url*/

    /*create collection url: window.location.origin + "/collection/ajax_Save_CustomLink_Collection"*/
    $(document).on('click','#popup-add-custom-link .btn_save_edit_collection',function(event){
        event.preventDefault();
        var formData = new FormData();
        formData.append('type_id',$('.js_collection-custom-link option:selected').val());
        formData.append('type','collection');
        formData.append('title',node_cl.title);
        formData.append('host',node_cl.host);
        formData.append('image',node_cl.image);
        formData.append('link',node_cl.link);
        formData.append('description',node_cl.description);
        formData.append('detail',$('#popup-add-custom-link textarea.js_custom-link-detail').val());
        $('#popup-add-custom-link').model('hide');
        $.ajax({
            url: window.location.origin + "/collection/ajax_Save_CustomLink_Collection",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if(typeof response !== 'undefined' && response == 1){
                    showAlert('Thông báo', 'Đã thêm bộ sưu tập liên kết.', 'success', '', true);
                }else{
                    alert("Error conection !!!");
                }
            },
            error: function () {
                alert("Error conection !!!");
            }
        });

    });
    /*end create collection*/

    /**********create library link ******** url: '/library-link/create'********/
    $(document).on('click', '#js_btn-create-library-link', function (event) {
        event.preventDefault();
        if($(this).hasClass('disable')){
            return;
        }
        var formData = new FormData();
        var temp_collection = $('.js_frm-library-link .js_collection-custom-link').val();
        if(Array.isArray(temp_collection) && temp_collection.length){
            temp_collection.forEach(function (item) {
                formData.append('collections[]', item);
            });
        }
        formData.append('detail', $('.js_frm-library-link .js_custom-link-detail').val());
        formData.append('is_owner', $('.js_frm-library-link input[name="is_owner"]:checked').val());
        formData.append('category_parent', $('.js_frm-library-link .js_category-parent-custom-link').val());
        formData.append('category_child', $('.js_frm-library-link .js_category-custom-link').val());
        formData.append('is_private', $('.js_frm-library-link input[name="is_private"]').prop('checked'));
        formData.append('link', $('.js_frm-library-link .js_save-link').val());
        formData.append('sho_id', $('.js_frm-library-link .js_sho-id').val());
        formData.append('image', $('.js_frm-library-link .js_image-upload').val());
        formData.append('video', $('.js_frm-library-link .js_video-upload').val());

        $('.js_frm-library-link .text-danger').hide().text('');
        $('#popup-add-custom-link').modal('hide');
        $._loading('show');

        $.ajax({
            url: window.location.origin + '/links/create',
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData,
            success: function (res) {
                if(res && typeof res !== 'undefined'){
                    if(typeof res.status !== 'undefined' && res.status === 1){
                        showAlert('Thông báo',res.message,'success', '', true);
                        $('.js_frm-library-link .text-danger').fadeOut().text('');
                        $('.js_frm-library-link .js_handle_value').val('');
                        $('.js_frm-library-link .js_custom-link-image').attr('src', '');
                        $('.js_frm-library-link .wrap-block-custom-link').html('');
                    }
                    if(typeof res.status !== 'undefined' && res.status === 0){
                        showAlert('Thông báo',res.message,'danger');
                    }
                    if(typeof res.status === 'undefined'){
                        $.each(res, function (index, value) {
                            $('.js_frm-library-link .js_'+index+'-msg').text(value).fadeIn();
                        });
                        $('#popup-add-custom-link').modal('show');
                    }
                }
            }
        }).always(function() {
            $._loading();
        });
    });

    /**********clone library link ***** url: '/library-link/clone' **********************/
    $(document).on('click', '.js_action-link-clone', function (event) {
        event.preventDefault();
        $('.js_library-link-popup-action').modal('hide');
        $._loading('show', 'body');
        var id = $(this).parents('.js_action-tools').attr('data-id');
        var type = $(this).parents('.js_action-tools').attr('data-type');
        if(!id || !type){
            showAlert('Thông báo', 'Liên kết không tồn tại.', 'danger');
            return;
        }
        $('.bosuutap-content-detail-modal video').trigger('pause');

        $.ajax({
            url: window.location.origin + '/'+ type +'/clone/'+id,
            type: "GET",
            dataType: 'json',
            success: function(response) {
                console.log('response', response);
                if(typeof response !== 'undefined' && response.status === true){
                    //call show form clone
                    show_form('clone');

                    $('.js_frm-library-link .js_save-id').val(response.data.id);
                    $('.js_frm-library-link .js_custom-link-title').val(response.data.link_title);
                    $('.js_frm-library-link .js_custom-link-description').val(response.data.link_description);
                    $('.js_frm-library-link .js_custom-link-detail').val(response.data.description);

                    var temp_img = '';
                    if(response.data.image_url){
                        temp_img = response.data.image_url;
                    }else{
                        temp_img = response.data.link_image;
                    }

                    if(response.data.video_url){
                        var item_video = '';
                        item_video += '<video poster="'+temp_img+'" autoplay="true" playsinline preload="none" controls>';
                        item_video += '  <source src="'+response.data.video_url+'" type="video/mp4">';
                        item_video += '  Your browser does not support the video tag.';
                        item_video += '</video>';
                        $('.js_frm-library-link .wrap-block-custom-link').html(item_video);
                    }else{
                        $('.js_frm-library-link .wrap-block-custom-link').html('<img class="center js_custom-link-image" src="'+temp_img+'">');
                    }

                    $('.js_frm-library-link .js_library-link-belong-to:checked').trigger('change');

                    if(response.data.cate_link_id && response.data.cate_link_id != 0){
                        //check xem link có child category hay ko
                        if(response.data.category_parent.id == response.data.category_current.id){
                            //category parent
                            $('.js_frm-library-link .js_category-parent-custom-link').val(response.data.category_parent.id).trigger('change');
                        }else{
                            $('.js_frm-library-link .js_category-custom-link').attr('cat-selected', response.data.cate_link_id);
                            $('.js_frm-library-link .js_category-parent-custom-link').val(response.data.category_parent.id).trigger('change');
                        }
                    }else{
                        $('.js_frm-library-link .js_category-parent-custom-link').val('').trigger('change');
                    }
                    $('.js_frm-library-link input[name="is_private"]').prop('checked', response.data.is_public === "0");
                    $('#popup-add-custom-link').modal('show');
                }else{
                    showAlert('Thông báo', response.message, 'danger');
                }
            },
            error: function () {
                showAlert('Thông báo', "Error conection!!!", 'danger');
            }
        }).always(function() {
            $._loading();
        });
    });

    $(document).on('click', '#js_btn-clone-library-link', function (event) {
        console.log('clone');
        event.preventDefault();
        if($(this).hasClass('disable')){
            return;
        }
        var id = $('.js_frm-library-link .js_save-id').val();
        var formData = new FormData();

        var temp_collection = $('.js_frm-library-link .js_collection-custom-link').val();
        if(Array.isArray(temp_collection) && temp_collection.length){
            temp_collection.forEach(function (item) {
                formData.append('collections[]', item);
            });
        }

        formData.append('id', id);
        formData.append('detail', $('.js_frm-library-link .js_custom-link-detail').val());
        formData.append('category_parent', $('.js_frm-library-link .js_category-parent-custom-link').val());
        formData.append('category_child', $('.js_frm-library-link .js_category-custom-link').val());
        formData.append('is_private', $('.js_frm-library-link input[name="is_private"]').prop('checked'));
        formData.append('sho_id', $('.js_frm-library-link .js_sho-id').val());
        formData.append('is_owner', $('.js_frm-library-link input[name="is_owner"]:checked').val());
        formData.append('image_path', $('.js_frm-library-link .js_image-upload').val());
        formData.append('video_path', $('.js_frm-library-link .js_video-upload').val());

        $('.js_frm-library-link .text-danger').hide().text('');
        $('#popup-add-custom-link').modal('hide');
        $._loading('show');

        $.ajax({
            url: window.location.origin + '/library-link/save-clone/' + id,
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData,
            success: function (res) {
                console.log(res);
                if (res) {
                    if (typeof res.status !== 'undefined' && res.status === 1) {
                        showAlert('Thông báo', res.message, 'success', '', true);
                        $('.js_frm-library-link .text-danger').fadeOut().text('');
                        $('.js_frm-library-link .js_handle_value').val('');
                        $('.js_frm-library-link .js_custom-link-image').attr('src', '');
                        $('.js_frm-library-link .wrap-block-custom-link').html('');
                    }
                    if (typeof res.status !== 'undefined' && res.status === 0) {
                        showAlert('Thông báo', res.message, 'danger');
                    }
                    if (typeof res.status === 'undefined') {
                        $.each(res, function (index, value) {
                            $('.js_frm-library-link .js_' + index + '-msg').text(value).fadeIn();
                        });
                        $('#popup-add-custom-link').modal('show');
                    }
                }
            }
        }).always(function() {
            $._loading();
        });
    });

    /**********update library link **** url: '/library-link/update' ************************/
    $(document).on('click', '.js_action-link-edit', function (event) {
        event.preventDefault();
        $('.js_library-link-popup-action').modal('hide');
        $._loading('show', 'body');
        var id   = $(this).parents('.js_action-tools').attr('data-id');
        var type = $(this).parents('.js_action-tools').attr('data-type');
        if(!id || !type){
            showAlert('Thông báo', 'Liên kết không tồn tại.', 'danger');
            return;
        }
        $('video.video-play').trigger('pause');
        $('.vjs-playing video').trigger('pause');
        $('.bosuutap-content-detail-modal video').trigger('pause');

        //call show form edit
        show_form('edit');

        $.ajax({
            url: window.location.origin +'/'+ type +'/info-link/'+id,
            type: "GET",
            dataType: 'json',
            success: function(response) {
                if(typeof response !== 'undefined' && response.status === true){

                    $('.js_frm-library-link .js_save-id').val(response.data.id);
                    $('.js_frm-library-link .js_type-link').val(type);
                    $('.js_frm-library-link .js_custom-link-title').val(response.data.link_title);
                    $('.js_frm-library-link .js_custom-link-description').val(response.data.link_description);
                    $('.js_frm-library-link .js_custom-link-detail').val(response.data.description);

                    var temp_img = '';
                    if(response.data.image){
                        temp_img = response.data.image;
                    }else{
                        temp_img = response.data.link_image;
                    }

                    if(response.data.video){
                        var item_video = '';
                        item_video += '<video poster="'+temp_img+'" autoplay="true" playsinline preload="none" controls>';
                        item_video += '  <source src="'+response.data.video+'" type="video/mp4">';
                        item_video += '  Your browser does not support the video tag.';
                        item_video += '</video>';
                        $('.js_frm-library-link .wrap-block-custom-link').html(item_video);
                    }else{
                        $('.js_frm-library-link .wrap-block-custom-link').html('<img class="center js_custom-link-image" src="'+temp_img+'">');
                    }

                    if(response.data.collections.length){
                        var temp_selected = [];
                        $.each(response.data.collections, function (index, value) {
                            temp_selected.push(value.id);
                        });
                        //ghi dấu lên html để sau khi ajax thì selected collection
                        $('.js_frm-library-link .js_collection-custom-link').attr('collection-selected', JSON.stringify(temp_selected));
                    }

                    if(response.data.sho_id && response.data.sho_id != 0){
                        $('.js_frm-library-link input[name="is_owner"][value="shop"]').prop('checked', true).trigger('change').parents('.checkbox-style-circle').show();
                        $('.js_frm-library-link input[name="is_owner"][value="personal"]').prop('checked', false);
                    }else{
                        $('.js_frm-library-link input[name="is_owner"][value="shop"]').prop('checked', false);
                        $('.js_frm-library-link input[name="is_owner"][value="personal"]').prop('checked', true).trigger('change').parents('.checkbox-style-circle').show();
                    }

                    if(response.data.cate_link_id && response.data.cate_link_id != 0){
                        //check xem link có child category hay ko
                        if(response.data.category_parent.id == response.data.category_current.id){
                            //category parent
                            $('.js_frm-library-link .js_category-parent-custom-link').val(response.data.category_parent.id).trigger('change');
                        }else{
                            $('.js_frm-library-link .js_category-custom-link').attr('cat-selected', response.data.cate_link_id);
                            $('.js_frm-library-link .js_category-parent-custom-link').val(response.data.category_parent.id).trigger('change');
                        }
                    }else{
                        $('.js_frm-library-link .js_category-parent-custom-link').val('').trigger('change');
                    }

                    $('.js_frm-library-link input[name="is_private"]').prop('checked', response.data.is_public == 0);
                    $('#popup-add-custom-link').modal('show');

                }else{
                    showAlert('Thông báo', response.message, 'danger');
                }
            },
            error: function () {
                $('#popup-add-custom-link').modal('hide');
                showAlert('Thông báo', "Error conection!!!", 'danger');
            }
        }).always(function() {
            $._loading();
        });
    });

    $(document).on('click', '#js_btn-edit-library-link', function (event) {
        event.preventDefault();
        if($(this).hasClass('disable')){
            return;
        }
        var formData        = new FormData();
        var temp_collection = $('.js_frm-library-link .js_collection-custom-link').val();
        var type_link       = $('.js_frm-library-link .js_type-link').val();
        if(Array.isArray(temp_collection) && temp_collection.length){
            temp_collection.forEach(function (item) {
                formData.append('collections[]', item);
            });
        }

        formData.append('detail', $('.js_frm-library-link .js_custom-link-detail').val());
        formData.append('category_parent', $('.js_frm-library-link .js_category-parent-custom-link').val());
        formData.append('category_child', $('.js_frm-library-link .js_category-custom-link').val());
        formData.append('is_private', $('.js_frm-library-link input[name="is_private"]').prop('checked'));
        formData.append('id', $('.js_frm-library-link .js_save-id').val());
        formData.append('image', $('.js_frm-library-link .js_image-upload').val());
        formData.append('video', $('.js_frm-library-link .js_video-upload').val());
        formData.append('sho_id', $('.js_frm-library-link .js_sho-id').val());
        formData.append('is_owner', $('.js_frm-library-link input[name="is_owner"]:checked').val());

        $('.js_frm-library-link .text-danger').hide().text('');
        $('#popup-add-custom-link').modal('hide');
        $._loading('show');

        $.ajax({
            url: window.location.origin +'/'+ type_link +'/update',
            type: 'POST',
            dataType: 'json',
            processData: false,
            contentType: false,
            data: formData,
            success: function (res) {
                if(res && typeof res !== 'undefined'){
                    if(typeof res.status !== 'undefined' && res.status === 1){
                        $('.js_frm-library-link .text-danger').fadeOut().text('');
                        $('.js_frm-library-link .js_handle_value').val('');
                        $('.js_frm-library-link .js_custom-link-image').attr('src', '');
                        $('.js_frm-library-link .wrap-block-custom-link').html('');
                        showAlert('Thông báo',res.message,'success', '', true);

                        var temp_image = '';
                        if(res.data.image){
                            temp_image = res.data.image_url;
                        }else{
                            temp_image = res.data.link_image;
                        }

                        //sử dụng template html từ chỗ khác
                        if(typeof type_link_template !== 'undefined' && typeof link_template[type_link_template] !== 'undefined'){
                            var temp_obj = {
                                'id'            : res.data.id,
                                'detail_url'    : $(link_template[type_link_template].target + res.data.id).attr('data-domain-use') + res.data.short_url,
                                'link_origin'   : res.data.link,
                                'title'         : (res.data.title ? res.data.title : res.data.link_title),
                                'host'          : res.data.host
                            };
                            if(res.data.video){
                                temp_obj.image_poster   = 'poster="'+ temp_image +'"';
                                temp_obj.is_muted       = 'muted';
                                temp_obj.video          = res.data.video_url;
                            }else{
                                temp_obj.image        = temp_image;
                                temp_obj.media_button = '';
                            }
                            $(link_template[type_link_template].target + res.data.id).html(replace_link_template(temp_obj, link_template[type_link_template].template, type_link_template));

                        }else{
                            if(res.data.video){
                                var temp_html = '';
                                temp_html += '<div class="wrap-video-item-single">';
                                temp_html += '	<video poster="'+temp_image+'" playsinline="" preload="none">';
                                temp_html += '		<source src="'+res.data.video_url+'" type="video/mp4">';
                                temp_html += '			Your browser does not support the video tag.';
                                temp_html += '	</video>';
                                temp_html += '	<div class="btn-pause">';
                                temp_html += '		<img src="/templates/home/styles/images/svg/play_video.svg" alt="action video">';
                                temp_html += '	</div>';
                                temp_html += '</div>';
                                $('.item.js_library-link-item-'+res.data.id + ' .img-link a').html(temp_html);
                            }else{
                                $('.item.js_library-link-item-'+res.data.id + ' .img-link a').html('<img onerror="image_error(this)" src="'+temp_image+'">');
                            }
                        }
                    }

                    if(typeof res.status !== 'undefined' && res.status === 0){
                        showAlert('Thông báo',res.message, 'danger');
                    }
                    if(typeof res.status === 'undefined'){
                        $.each(res, function (index, value) {
                            $('.js_frm-library-link .js_'+index+'-msg').text(value).fadeIn();
                        });
                        $('#popup-add-custom-link').modal('show');
                    }
                }
            }
        }).always(function() {
            $._loading();
        });
    });

    /********** delete ********* url: '/library-link/'+ id+'/delete'**********************/
    $(document).on('click', '.js_action-link-delete', function (event) {
        event.preventDefault();
        $('.js_library-link-popup-action').modal('hide');
        var id        = $(this).parents('.js_action-tools').attr('data-id');
        var type_link = $(this).parents('.js_action-tools').attr('data-type');
        if(!id || !type_link){
            showAlert('Thông báo', 'Liên kết không tồn tại.', 'danger');
            return;
        }
        showConfirm({
            'callbackYes': remove_library_link,
            'callbackYesAgument': type_link +'/'+ id
        });
    });

    function remove_library_link(type_link_id)
    {
        $._loading('show');
        $.ajax({
            url: window.location.origin +'/'+ type_link_id +'/delete',
            type: 'POST',
            dataType: 'json',
            success: function (res) {
                if(res && typeof res.status !== 'undefined'){
                    if(res.status === 1){
                        $('.js_library-link-item.js_library-link-item-'+ res.id).remove();
                        //refresh layout
                        if(typeof $grid !== 'undefined'){
                            $grid.imagesLoaded().progress( function() {
                                $grid.masonry('layout');
                            });
                        }
                    }
                    if(res.status === 0){
                        showAlert('Thông báo',res.message, 'danger');
                    }
                }
            }
        }).always(function() {
            $._loading();
        });
    }

    $(document).on('click', '.js_action-link-remove', function (event) {
        event.preventDefault();
        var id        = $(this).parents('.js_action-tools').attr('data-id');
        var type_link = $(this).parents('.js_action-tools').attr('data-type');
        if(!id || !type_link){
            showAlert('Thông báo', 'Liên kết không tồn tại.', 'danger');
            return;
        }
        showConfirm({
            'callbackYes': remove_library_linkdb,
            'callbackYesAgument': type_link +'/'+ id
        });
    });

    function remove_library_linkdb(type_link_id)
    {
        $._loading('show');
        $.ajax({
            url: window.location.origin +'/'+ type_link_id + '/remove',
            type: 'POST',
            dataType: 'json',
            success: function (res) {
                if(res && typeof res.status !== 'undefined'){
                    if(res.status === 1){
                        $('.js_wrap-content-link-'+ res.id).remove();
                    }
                    if(res.status === 0){
                        showAlert('Thông báo',res.message, 'danger');
                    }
                }
            }
        }).always(function() {
            $._loading();
        });
    }

});
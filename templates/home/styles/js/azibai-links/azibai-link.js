$(window).on("load",function(){
    $(".js-scroll-x").mCustomScrollbar({
        axis:"x",
        theme:"dark-thin",
        autoExpandScrollbar:true,
        advanced:{autoExpandHorizontalScroll:true}
    });
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
// matchBlackBackground.addListener(detectBackground);
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

jQuery(document).ready(function($) {

    var common_tpl ='<div class="item">';
    common_tpl +='      <div class="avata">';
    common_tpl +='          <a target="_blank" href="{{{page_url}}}"><img src="{{{avatar}}}"></a>';
    common_tpl +='      </div>';
    common_tpl +='      <div class="info">';
    common_tpl +='          <div class="name">';
    common_tpl +='              <a target="_blank" href="{{{page_url}}}"><span class="name-bold">{{{name}}}</span></a>';
    common_tpl +='              <span class="date">{{{time_post}}}</span>';
    common_tpl +='          </div>';
    common_tpl +='          <div class="txt">';
    common_tpl +='              <p><a href="{{{detail_url}}}" target="_blank">{{{content}}}</a></p>';
    common_tpl +='          </div>';
    common_tpl +='      </div>';
    common_tpl +='  </div>';

    function replace_template(data, template_tpl) {
        var temp123 = template_tpl;
        $.each(data, function (index, val) {
            temp123 = temp123.replace(new RegExp('{{{'+index+'}}}', 'g'), val);
        });
        return temp123;
    }

    function file_is_processing(process)
    {
        if(process && typeof process !== 'undefined'){
            $('.js_frm-library-link .js_image-upload-msg').text('Đang xử lý tập tin').show();
            $('.js_btn-process-link').addClass('disable').attr('title', 'Đang xử lý tập tin').html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
        }else{
            $('.js_btn-process-link').removeClass('disable').removeAttr('title').html('Lưu');
        }
    }

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

    function show_form(frm_btn)
    {
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

    $('#popup-add-custom-link').on('hidden.bs.modal', function () {
        $('#popup-add-custom-link .wrap-block-custom-link').html('');
    });

    $(document).on('click', '.js_action-link-common', function (event) {
        event.preventDefault();
        $('.js_library-link-popup-action').modal('hide');
        $._loading('show', 'body');
        var id = $(this).parents('.js_action-tools').attr('data-link_id');
        if(!id){
            $._loading();
            showAlert('Thông báo', 'Liên kết không tồn tại.', 'danger');
            return;
        }
        // ajax get common link
        $.ajax({
            url: window.location.origin + '/links/links-common/'+ id,
            type: "GET",
            dataType: 'json',
            success: function(response) {
                console.log('response', response);
                if(typeof response !== 'undefined' && response.status === true){
                    var temp = 'Không có dữ liệu';
                    if(isArray(response.data) && response.data.length){
                        temp = '';
                        $.each(response.data, function (index, val) {
                            console.log('val', val);
                            if(parseInt(val.sho_id) > 0){
                                temp += replace_template({
                                    'avatar'    : val.owner.logo,
                                    'name'      : val.owner.sho_name,
                                    'time_post' : val.created_at,
                                    'content'   : val.description ? val.description : val.link_title,
                                    'page_url'  : val.owner.shop_url,
                                    'detail_url': val.owner.shop_url + val.short_url,
                                }, common_tpl);
                            }else {
                                temp += replace_template({
                                    'avatar'    : (val.owner.avatar ? val.owner.avatar_url : ''),
                                    'name'      : val.owner.use_fullname,
                                    'time_post' : val.created_at,
                                    'content'   : val.description ? val.description : val.link_title,
                                    'page_url'  : val.owner.profile_url,
                                    'detail_url': val.owner.profile_url + val.short_url,
                                }, common_tpl);
                            }
                        });

                    }
                    $('#popup_link_common .js_content-link-common').html(temp);
                    $('#popup_link_common').modal('show');

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

    $(document).on('click', '.js_library-link-show-more', function (event) {
        event.preventDefault();
        $('.js_library-link-popup-action .js_action-tools').attr({
            'data-id'      : $(this).attr('data-id'),
            'data-link'    : $(this).attr('data-link'),
            'data-type'    : $(this).attr('data-type'),
            'data-link_id' : $(this).attr('data-link_id')
        });
        console.log({
            'data-id'      : $(this).attr('data-id'),
            'data-link'    : $(this).attr('data-link'),
            'data-type'    : $(this).attr('data-type'),
            'data-link_id' : $(this).attr('data-link_id')
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

    $(document).on('change', '.js_collection-category', function (event) {
        event.preventDefault();
        categories_child($(this), '.js_collection-category-child');
    });

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
                console.log('response', response);
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

    /**********clone library link ***** url: '/type-link/clone' **********************/
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
            url: window.location.origin + '/links/'+ type +'/clone/'+ id,
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
        formData.append('detail',           $('.js_frm-library-link .js_custom-link-detail').val());
        formData.append('category_parent',  $('.js_frm-library-link .js_category-parent-custom-link').val());
        formData.append('category_child',   $('.js_frm-library-link .js_category-custom-link').val());
        formData.append('is_private',       $('.js_frm-library-link input[name="is_private"]').prop('checked'));
        formData.append('sho_id',           $('.js_frm-library-link .js_sho-id').val());
        formData.append('is_owner',         $('.js_frm-library-link input[name="is_owner"]:checked').val());
        formData.append('image_path',       $('.js_frm-library-link .js_image-upload').val());
        formData.append('video_path',       $('.js_frm-library-link .js_video-upload').val());

        $('.js_frm-library-link .text-danger').hide().text('');
        $('#popup-add-custom-link').modal('hide');
        $._loading('show');

        $.ajax({
            url: window.location.origin + '/links/library-link/save-clone',
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
    /********** end clone library link ***** url: '/type-link/clone' **********************/

    $('.js_category-parent-custom-link').trigger('change');
    $('.js_collection-category').trigger('change');

});
$(document).ready(function() {
    // -----------------execute cover----------------------
    $(document).on('click', '.js-button-change-cover', function () {
        $('.js-personal-change-cover').click();
        if(!load_croppier){
            load_croppier = true;
            loadCroppier();
        }
    });

    $(document).on('click', '.js-button-save-cover', function (event) {
        event.preventDefault();
        $._loading('show', '.cover-part');
        var crop_position = $('.js_image-cover-show').croppie('get');
        $.ajax({
            url: '/profile/process_cover',
            type: 'POST',
            dataType: 'json',
            data: crop_position,
            success: function (response) {
                if (response.status !== undefined && response.status === false) {
                    cover_edit_button_status('show');
                    alert(response.message);
                }
                if(response.status !== undefined && response.status === true ){
                    var new_url_temp = response.cloud_server_show_path +'/'+ response.sho_dir_banner +'/'+ response.name;
                    $('.js_image-cover-show').attr({
                        'src': new_url_temp,
                        'data-src-img-old': new_url_temp,
                    });
                }
                $('.croppie-container .js_image-cover-show').croppie('destroy');
                cover_edit_button_status('show');
            }
        }).always(function () {
            $._loading();
        });
    });

    $(document).on('change', '.js-personal-change-cover', function (event) {
        if (check_image('.js-personal-change-cover')) {
            cover_edit_button_status('hide');
            $('.js-submit-form-upload-image').submit();
        }
    });

    $(document).on('click', '.js-button-cancel-cover', function () {
        $('.js_image-cover-show').attr('src', $('.js_image-cover-show').data('src-img-old'));
        $('.croppie-container .js_image-cover-show').croppie('destroy');
        cover_edit_button_status('show');
    });

    $(".js-submit-form-upload-image").submit(function (event) {
        event.preventDefault();
        $._loading('show', '.cover-part');
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: '/profile/upload_cover',
            type: 'post',
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status !== undefined && response.status === false) {
                    //show pop error
                    cover_edit_button_status('show');
                    alert(response.message);
                }
                if (response.status !== undefined && response.status === true) {
                    $('.js_image-cover-show').attr('src', response.image);
                    var crop_cover = $('.wrap-edit-cover-part .js_image-cover-show');
                    var width  = crop_cover.width();
                    var height = Math.round(width/3);
                    crop_cover.croppie({
                        viewport: {width: width, height: height},
                        boundary: {width: width, height: height},
                        showZoomer: false,
                        enableOrientation: true,
                        mouseWheelZoom: false,
                    });
                    crop_cover.croppie('bind', 'url').then(function(){
                        crop_cover.croppie('setZoom', 0);
                    });
                }
            }
        }).always(function () {
            $._loading();
        });
    });

    function cover_edit_button_status(status) {
        if (status === 'show') {
            $('.js-personal-change-cover').val('');
            $('.js-button-change-cover').show();
            $('.js-button-save-cover').hide();
            $('.js-button-cancel-cover').hide();
        } else {
            $('.js-button-change-cover').hide();
            $('.js-button-save-cover').show();
            $('.js-button-cancel-cover').show();
        }
    }

    function check_image(selector) {
        var name = $(selector).val();

        if (!name) {
            return false;
        }

        var file = $(selector)[0].files[0];
        if (file) {
            if (!name.match(/(?:jpg|jpeg|png)$/)) {
                alert('Lỗi: định dạng ảnh cho phép [jpg|jpeg|png]');
                return false;
            }
        }
        return true;
    }

    // -----------------execute cover----------------------
    //----------edit avatar-------------------
    var load_croppier = false;
    $(document).on('click', '.js_open-pop-edit-avatar', function () {
        event.preventDefault();
        $('.js-personal-change-avatar').click();
        if(!load_croppier){
            load_croppier = true;
            loadCroppier();
        }
    });

    $(document).on('change', '.js-personal-change-avatar', function (event) {
        event.preventDefault();
        if (check_image('.js-personal-change-avatar')) {
            $('.js-submit-form-upload-avatar').submit();
        }
    });

    $(".js-submit-form-upload-avatar").submit(function (event) {
        event.preventDefault();
        $._loading('show', 'body');
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: '/profile/upload_avatar',
            type: 'post',
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                if (response.status !== undefined && response.status === false) {
                    alert(response.message);
                }
                if (response.status !== undefined && response.status === true) {
                    //show modal
                    $('.js_cropper-avatar').attr('src', response.image);
                    $('.js_avatar-modal-sm').modal('show');
                }
            }
        }).always(function () {
            $._loading();
            $('.js-personal-change-avatar').val('');
        });
    });

    $(document).on('click', '.js_btn-avatar-save', function (event) {
        event.preventDefault();
        var crop_position = $('.js_cropper-avatar').croppie('get');
        $('.js_avatar-modal-sm').modal('hide');
        $._loading('show', 'body');
        $.ajax({
            url: '/profile/process_avatar',
            type: 'POST',
            dataType: 'json',
            data: crop_position,
            success: function (response) {
                if (response.status !== undefined && response.status === false) {
                    alert(response.message);
                }
                if (response.status !== undefined && response.status === true) {
                    window.location.reload();
                }
            }
        }).always(function () {
            $._loading();
        });
    });

    function loadCroppier() {
        var croppier_css = document.createElement('link');
        croppier_css.href = '/templates/home/styles/plugins/croppier/croppie.css';
        croppier_css.rel = 'stylesheet';
        croppier_css.type = 'text/css';
        croppier_css.media = 'all';
        $('header').after(croppier_css);
        var croppier_script = document.createElement('script');
        croppier_script.src = '/templates/home/styles/plugins/croppier/croppie.js';
        $('#footer').append(croppier_script);
    }

    function demoMain() {
        var mc = $('.cropper-image .js_cropper-avatar');
        mc.croppie({
            viewport: {width: 180, height: 180,},
            boundary: {width: 300, height: 300},
            enableOrientation: true
        });
        mc.croppie('bind', 'url').then(function () {
            mc.croppie('setZoom', 0);
        });

        mc.on('update.croppie', function (ev, data) {
            console.log('jquery update', ev, data);
        });

        $('.js_cropper-rotate').on('click', function(ev) {
            mc.croppie('rotate', parseInt($(this).data('deg')));
        });
    }

    $('.js_avatar-modal-sm').on('shown.bs.modal', function () {
        demoMain();
    }).on('hidden.bs.modal', function (e) {
        $('.warp-crop-avatar .cropper-image').html('<img class="js_cropper-avatar" id="cropper-avatar" src="">')
    });

//-------------edit avatar--------------------

});
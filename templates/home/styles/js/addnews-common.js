$('.accordion .accordion-panel').hide();
$(document).on("click", ".accordion-toggle", function() {
    // Toggle the current accordion panel and close others
    $(".accordion-panel").slideUp();
    $('.accordion.js-accordion').removeClass("is-open");
    if ($(this).next().is(":visible")) {
        $(this).next().slideUp();
    } else {
        $(this).next().slideDown().closest(".accordion-item").addClass("is-open");
    }
    return false;
});

$(document).on('click', '.images.audio-from-azibai', function (event) {
    event.preventDefault();
    $('.images.addnews-audio-from-azibai').modal('show');
});

$(document).on('click', '.images.audio-from-url', function (event) {
    event.preventDefault();
    $('.images.addnews-audio-from-url').modal('show');
});

// Thay audio hình
$(document).on('click', '.images.addnews-audio-from-azibai .btn-save-select-audio-from-azibai', function(e) {
    var image_id     = $('.menu-edit-image').attr('data-id');
    var data_image   = JSON.parse(formData.get('images[' + image_id + ']'));
    data_image.audio = $('.images.addnews-audio-from-azibai .select-audio').val();
    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
    $('.images.addnews-audio-from-azibai').modal('hide');
    $('.accordion .accordion-panel').hide();
});

$(document).on('click', '.images.addnews-audio-from-url .btn-save-select-audio-from-url', function(e) {
    var image_id     = $('.menu-edit-image').attr('data-id');
    var data_image   = JSON.parse(formData.get('images['+image_id+']'));
    data_image.audio = $('.images.addnews-audio-from-url .input-audio').val();
    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
    $('.images.addnews-audio-from-url').modal('hide');
    $('.accordion .accordion-panel').hide();
});

$(document).on('change', '.images.select-audio-from-device', function (event) {
    event.preventDefault();
    if($(this).prop('files').length){
        var file_audio = new FormData();
        file_audio.set('audio', $(this).prop('files')[0]);
        $.ajax({
            headers: {
                'Authorization': "Bearer "+ token,
            },
            withCredentials: true,
            url: api_common_audio_post,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'json',
            data: file_audio,
            success: function (res){
                if(res && res.status === 1){
                    var image_id     = $('.menu-edit-image').attr('data-id');
                    var data_image   = JSON.parse(formData.get('images['+image_id+']'));
                    data_image.audio = res.data.original;
                    formData.set('images['+data_image.image_id+']', JSON.stringify(data_image));
                    $('.accordion .accordion-panel').hide();
                }
            }
        });
    }
});
$(document).ready(function() {
    var new_src = null;
    var url_page = '';
    //Add avt share

    $(document).on('change','.add_avtShare #img-avatarShare', function(){
        if(this.files && this.files.length > 0){
            $('#shareClick .upavatar-share form label.back_avtShare').remove();
            $('.add_avtShare #crop-avatarShare').empty().append('<img class="reviewImg_avtShare center" id="reviewImg_avtShare" src="">');
            if (this.files && this.files[0]) {
                var $click = 0;
                var reader = new FileReader();
                reader.onload = function(e) {
                    var image = new Image();
                    image.src = e.target.result;
                    image.onload = function() {
                        if ((this.width <= 600) && (this.height <= 600)) {
                            alert('Kích thước ảnh bắt buộc lớn hơn 600 x 600');
                        } else {
                            var getWidth = $('.add_avtShare').width();
                            $('#reviewImg_avtShare').attr('src', e.target.result);
                            var dkrm = new Darkroom('#reviewImg_avtShare', {
                                maxWidth: getWidth,
                                maxHeight: 800,
                                plugins: {
                                    save: false,
                                    crop: {
                                        minHeight: 450,
                                        minWidth: 450,
                                        ratio: 1
                                    }
                                },
                                initialize: function() {
                                    var cropPlugin = this.plugins['crop'];
                                    cropPlugin.selectZone(50, 50, 450, 450);
                                    var images_crop = this;
                                    $('.add_avtShare').find('.darkroom-toolbar .darkroom-button-group').eq(1).hide();
                                    $('.add_avtShare').find('.darkroom-toolbar').append('<div class="darkroom-button-group luu_image" style="display:none"><button type="button" class="darkroom-button darkroom-button-default">Lưu</button></div>');
                                    $('.add_avtShare .darkroom-button-group').eq(0).addClass(' reload');
                                    $('.darkroom-button-group.reload .darkroom-button').eq(1).hide();
                                    
                                    this.addEventListener('core:transformation', function() {
                                        newImage = images_crop.sourceImage.toDataURL();
                                        
                                        $('.add_avtShare').find('.darkroom-toolbar .luu_image').show();
                                        $('.add_avtShare').find('.darkroom-toolbar .darkroom-button-group').eq(1).show();
                                        $('.add_avtShare .darkroom-button-group').eq(2).addClass(' crop');
                                        
                                        $('body').on('click', '.darkroom-button-group.reload, .darkroom-button-group.crop', function(){
                                            $('.add_avtShare').find('.darkroom-toolbar .luu_image').hide();
                                            $('.add_avtShare').find('.darkroom-toolbar .darkroom-button-group').eq(1).hide();
                                        });
                                        
                                        new_src = newImage;
                                    });
                                }
                            });
                        }
                    };
                };
                reader.readAsDataURL(this.files[0]);
            }
            $('#shareClick .modal-title').text('Đổi ảnh đại diện chia sẻ');
            $('#shareClick .upavatar-share form label.change-img').before('<label class="btn back_avtShare"><b>Trở lại</b></label>');
            $('.div-temp-share').fadeOut();
        }
    });

    $(document).on('click','.add_avtShare .luu_image',function(){
        var newImage = new_src;
        $('.add_avtShare .after_crop').show();
        $('.add_avtShare #crop-avatarShare').empty();
        $('.add_avtShare #crop-avatarShare').append('<img class="reviewImg_avtShare center" id="reviewImg_avtShare" src="'+newImage+'">');
        var share_type = $('#shareClick').attr('data-type');
        var share_item_id = $('#shareClick').attr('data-item_id');
        var imagename = $('.add_avtShare #reviewImg_avtShare').attr('src');
        url_page = $('#shareClick').data('url_page');
        $.ajax({
            url: siteUrl+"share/add_avatarShare",
            type: "POST",
            data: {avatarShare: imagename, type: share_type, item_id: share_item_id},
            dataType: 'json',
            success: function(response)
            {
                if(response.error == false){
                    $('.add_avtShare form').append('<input type="hidden" name="id" class="id" value="'+response.id+'">');
                    $('.add_avtShare form label').append('<label class="btn delete_avtShare"><b>Xóa ảnh</b></label>');
                    $('.add_avtShare .change-img').after('<img class="img_avtShare" src="'+response.image+'">');
                    $('.add_avtShare').attr('class','update_avtShare');
                    facebookInit(url_page);
                }else{
                    var mess = "Thêm ảnh thất bại";
                    $('#modal_mess').modal('show');
                    $('#modal_mess .modal-body p').html(mess);
                }
            },
            error: function ()
            {
                alert("Error conection!!!");
            }
        });

        $('.div-temp-share').fadeIn();
        $('#crop-avatarShare').html('');
        $('.back_avtShare').fadeOut();
    });

    //Update avt share
    $(document).on('change','.update_avtShare #img-avatarShare', function(){
        var check;
        if(this.files && this.files.length > 0){
            var width = 0;
            var height = 0;
            $('#shareClick .upavatar-share form label.back_avtShare').remove();
            $('.update_avtShare #crop-avatarShare').empty().append('<img class="reviewImg_avtShare center" id="reviewImg_avtShare" src="">');
            if (this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    var image = new Image();
                    image.src = e.target.result;
                    image.onload = function() {
                        if ((this.width <= 600) && (this.height <= 600)) {
                            alert('Kích thước ảnh bắt buộc lớn hơn 600 x 600');
                        } else {
                            var getWidth = $('.update_avtShare').width();
                            $('#reviewImg_avtShare').attr('src', e.target.result);
                            var dkrm = new Darkroom('#reviewImg_avtShare', {
                                maxWidth: getWidth,
                                maxHeight: 800,
                                plugins: {
                                    save: false,
                                    crop: {
                                        minHeight: 600,
                                        minWidth: 600,
                                        ratio: 1
                                    }
                                },
                                initialize: function() {
                                    var cropPlugin = this.plugins['crop'];
                                    cropPlugin.selectZone(50, 50, 600, 600);
                                    var images_crop = this;
                                    $('.update_avtShare').find('.darkroom-toolbar .darkroom-button-group').eq(0).hide();
                                    $('.update_avtShare').find('.darkroom-toolbar .darkroom-button-group').eq(1).hide();
                                    $('.update_avtShare').find('.darkroom-toolbar').append('<div class="darkroom-button-group luu_image" style="display:none"><button type="button" class="darkroom-button darkroom-button-default">Lưu</button></div>');

                                    this.addEventListener('core:transformation', function() {
                                        width = images_crop.image.width;
                                        height = images_crop.image.height;
                                        
                                        /*if(width < 600 || height < 600){
                                            check = false;
                                            alert('bạn phải cắt ảnh tối thiểu 600x600');
                                            $('#crop-avatarShare').append('<div class="width" data="'+width+'">');
                                            $('#crop-avatarShare').append('<div class="height" data="'+height+'">');
                                        }else{*/
                                            check = true;
                                            newImage = images_crop.sourceImage.toDataURL();
                                            $('.update_avtShare').find('.darkroom-toolbar .darkroom-button-group').eq(1).show();
                                            $('.update_avtShare').find('.darkroom-toolbar .luu_image').show();
                                            $('.update_avtShare .darkroom-button-group').eq(2).addClass(' crop');
                                            $('.update_avtShare .darkroom-button-group').eq(0).show();
                                            $('.update_avtShare .darkroom-button-group').eq(0).addClass(' reload');
                                            $('.darkroom-button-group.reload .darkroom-button').eq(1).hide();

                                            $('body').on('click', '.darkroom-button-group.reload, .darkroom-button-group.crop', function(){
                                                $('.update_avtShare').find('.darkroom-toolbar .luu_image').hide();
                                                $('.update_avtShare').find('.darkroom-toolbar .darkroom-button-group').eq(1).hide();
                                            });
                                            new_src = newImage;
                                        // }
                                    });
                                }
                            });
                        }
                    };
                };

                reader.readAsDataURL(this.files[0]);
                /*$('#img-avatarShare, .darkroom-button-success').click(function(){
                    var width = $('#crop-avatarShare .width').attr('data');
                    console.log(width);
                });*/
            }
            $('#shareClick .modal-title').text('Đổi ảnh đại diện chia sẻ');
            $('#shareClick .upavatar-share form label.change-img').before('<label class="btn back_avtShare"><b>Trở lại</b></label>');
            $('.div-temp-share').fadeOut();
            $('.img_avtShare').fadeOut();
            $('.delete_avtShare').fadeOut();
        }
    });

    $(document).on('click','.update_avtShare .luu_image',function(){
        var newImage = new_src;
        $('.update_avtShare .after_crop').show();
        $('.update_avtShare #crop-avatarShare').empty();
        $('.update_avtShare #crop-avatarShare').append('<img class="reviewImg_avtShare center" id="reviewImg_avtShare" src="'+newImage+'">');
        var id = $('.id').val();
        var item_id = $('.item_id').val();
        var imagename = $('.update_avtShare #reviewImg_avtShare').attr('src');
        url_page = $('#shareClick').data('url_page');
        $.ajax({
            async: false,
            url: siteUrl+"share/update_avatarShare",
            type: "POST",
            data: {id: id, avatarShare: imagename, item_id: item_id},
            dataType: 'json',
            success: function(response)
            {
                if(response.error == false){
                    $('.img_avtShare').attr('src', response.image);
                    $('.img_avtShare').fadeIn();
                    facebookInit(url_page);
                }else{
                    var mess = "Cập nhật thất bại";
                    $('#modal_mess').modal('show');
                    $('#modal_mess .modal-body p').html(mess);
                }
            },
            error: function ()
            {
                alert("Error conection!!!");
            }
        });
        $('.div-temp-share').fadeIn();
        $('.delete_avtShare').fadeIn();
        $('#crop-avatarShare').html('');
        $('.back_avtShare').fadeOut();
    });

    $(document).on('click','.update_avtShare .delete_avtShare',function(){
        var id = $('.update_avtShare .id').val();
        url_page = $('#shareClick').data('url_page');
        $.ajax({
            url: siteUrl+"share/delete_avatarShare",
            type: "POST",
            data: {id: id},
            dataType: 'json',
            success: function(response)
            {
                if(response.error == false){
                    $('.id').remove();
                    $('.delete_avtShare').remove();
                    $('#crop-avatarShare').html('');
                    $('.update_avtShare form').append('<input type="hidden" name="type" class="type" value="'+response.type+'">');
                    $('.update_avtShare').attr('class','add_avtShare');
                    $('.img_avtShare').remove();
                    facebookInit(url_page);
                }else{
                    var mess = "Xóa ảnh thất bại";
                    $('#modal_mess').modal('show');
                    $('#modal_mess .modal-body p').html(mess);
                }
            },
            error: function ()
            {
                alert("Error conection!!!");
            }
        });
    });

    $(document).on('click','.back_avtShare',function(){
        $('#shareClick .modal-title').text('Chia sẻ đến');
        $('.div-temp-share').fadeIn();
        $('#crop-avatarShare').html('');
        $('.back_avtShare').fadeOut();
        if($('.update_avtShare').length > 0){
            $('.img_avtShare').fadeIn();
            $('.delete_avtShare').fadeIn();
        }
    });

    function facebookInit(url_page) {
        if (window.FB)
        {
            init(url_page);
            return false;
        }
        var js, id = 'facebook-jssdk', ref = document.getElementsByTagName('script')[0];
        if (document.getElementById(id)) {
            return;
        }
        js = document.createElement('script');
        js.id = id;
        js.async = true;
        js.src = "//connect.facebook.net/en_US/all.js";
        ref.parentNode.insertBefore(js, ref);

        window.fbAsyncInit = function(){
            init(url_page);
        };
    }

    function init(url_page) {
      // init the FB JS SDK
        FB.init({
            appId: $('.box_fb .f_id').data('value'), // App ID from the App Dashboard [Optional]
            status: true, // check the login status upon init?
            cookie: true, // set sessions cookies to allow your server to access the session?
            xfbml: true, // parse XFBML tags on this page?
            version: 'v2.0'
        });
        
        FB.api('https://graph.facebook.com/','post',  {
            id: url_page,
            scrape: true,
            access_token: $('.box_fb .f_id').data('value')+'|'+$('.box_fb .f_secrect').data('value'),
        }, function(response) {
        });
    }

    facebookInit(window.location.href);
});
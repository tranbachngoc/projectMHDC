$(document).ready(function() {
    var new_src = null;
    $(document).on('click','#creatNewCollectionLinks',function(){
        $('#createCollection').modal('show');
        $('#createCollection .after_crop').hide();
        $('#createCollection #crop-zone').empty().append('<img class="reviewImg center" id="reviewImg" src="/templates/home/styles/images/default/error_image_400x400.jpg">');
    });

    $(document).on('change','#createCollection #img-collection', function(){
        $('#createCollection #crop-zone').empty().append('<img class="reviewImg center" id="reviewImg" src="">');
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var image = new Image();
                image.src = e.target.result;
                image.onload = function() {
                    if ((this.width <= 600) && (this.height <= 600)) {
                        alert('Kích thước ảnh bắt buộc lớn hơn 600 x 600');
                    } else {
                        var getWidth = $('#createCollection .modal-body').width();
                        $('#reviewImg').attr('src', e.target.result);
                        var dkrm = new Darkroom('#reviewImg', {
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

                                $('#createCollection').find('.darkroom-toolbar .darkroom-button-group').eq(0).hide();
                                $('#createCollection').find('.darkroom-toolbar .darkroom-button-group').eq(1).hide();
                                $('#createCollection').find('.darkroom-toolbar').append('<div class="darkroom-button-group luu_image" style="display:none"><button type="button" class="darkroom-button darkroom-button-default">Lưu</button></div>');

                                this.addEventListener('core:transformation', function() {
                                    newImage = images_crop.sourceImage.toDataURL();
                                    $('#createCollection').find('.darkroom-toolbar .darkroom-button-group').eq(1).show();
                                    $('#createCollection').find('.darkroom-toolbar .luu_image').show();
                                    new_src = newImage;
                                });
                            }
                        });
                    }
                };
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    $(document).on('click','#createCollection .luu_image',function(){
        var newImage = new_src;
        $('#createCollection .after_crop').show();
        $('#createCollection #crop-zone').empty();
        $('#createCollection #crop-zone').append('<img class="reviewImg center" id="reviewImg" src="'+newImage+'">');
    });

    $(document).on('click','#createCollection .modal-footer .after_crop',function(){
        var formData = new FormData();
        var isPublic = 0;
        if($('#createCollection input[name="isPublic"]:checked').length){
            isPublic = 0;
        } else {
            isPublic = 1;
        }
        formData.append('srcImg',$('#createCollection #reviewImg').attr('src'));
        formData.append('nameCollection',$('#createCollection input[name="nameCollection"]').val());
        formData.append('is_owner', $('.js_frm-create-collection input[name="is_owner"]:checked').val());
        formData.append('sho_id', $('.js_frm-create-collection .js_sho-id').val());
        formData.append('isPublic',isPublic);
        //type_collection
        formData.append('type',3);

        $.ajax({
            url: window.location.origin + "/collection/ajax_createCollection_choose",
            type: "POST",
            data: formData,
            contentType:false,
            processData:false,
            success: function(response)
            {
                if(response == 1){
                    $('#createCollection').modal('hide');
                    showAlert('Thông báo', 'Đã thêm bộ sưu tập liên kết.', 'success', '', true);
                }else{
                    alert("Error conection!!!");
                }
            },
            error: function ()
            {
                alert("Error conection!!!");
            }
        });
    });
});
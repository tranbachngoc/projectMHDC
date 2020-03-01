<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="/templates/home/darkroomjs/css/darkroom.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/darkroomjs/js/fabric.js"></script>
<script src="/templates/home/darkroomjs/js/darkroom.js"></script>

<style>
  .reviewImg {
    max-width: auto;
    max-height: 600px;
  }

  .center {
    display: block;
    margin-left: auto;
    margin-right: auto;
    /* width: 50%; */
  }

  .darkroom-button-group {
    padding: 5px;
    display: inline-block;
  }
</style>
<!-- The Modal -->
<div class="modal fade" id="createCollection">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Tạo bộ sưu tập</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label class="col-form-label" style="display:inline">Chọn hình đại diện bộ sưu tập: 
              <span class="btn btn-azibai btn-file upload_btn" id="sp_upload_1">
                <i class="fa fa-upload" aria-hidden="true"></i>
                <input type="file" class="form-control" name="" accept="image/*" id="img-collection" style="display:none">
              </span>
            </label>
            <div id="crop-zone">
              <img class="reviewImg center" id="reviewImg" src="/templates/home/styles/images/default/error_image_400x400.jpg">
            </div>
          </div>
          <div class="form-group after_crop" style="display:none">
            <label class="col-form-label">Tên bộ sưu tập:</label>
            <input type="text" name="nameCollection" class="" autocomplete="off">
          </div>
          <div class="form-group after_crop" style="display:none">
            <label class="col-form-label">Bí mật:</label>
            <input type="checkbox" name="isPublic" value="check" class="" checked>
          </div>
        </form>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer buttons-group">
        <button type="button" class="btn btn-bg-gray after_crop" style="display:none">Xong</button>
        <button type="button" class="btn btn-bg-white" data-dismiss="modal">Đóng</button>
      </div>

    </div>
  </div>
</div>

<script>
  var new_src = null;
  $('body').on('click','.createCollection',function(){
    $('#createCollection').modal('show');
    $('#createCollection .after_crop').hide();
    $('#createCollection #crop-zone').empty();
    $('#createCollection #crop-zone').append('<img class="reviewImg center" id="reviewImg" src="/templates/home/styles/images/default/error_image_400x400.jpg">');
  });

  $('body').on('change','#createCollection #img-collection', function(){
    $('#createCollection #crop-zone').empty();
    $('#createCollection #crop-zone').append('<img class="reviewImg center" id="reviewImg" src="">');
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
              // Size options
              // minWidth: 600,
              // minHeight: 600,
              maxWidth: getWidth,
              maxHeight: 800,
              //ratio: 4/3,
              // backgroundColor: '#000',

              // Plugins options
              plugins: {
                save: {
                    callback: function() {
                    }
                },
                // rotate: true,
                save: false,
                crop: {
                  //quickCropKey: 67, //key "c"
                  minHeight: 450,
                  minWidth: 450,
                  ratio: 1
                }
              },
              // Post initialize script
              initialize: function() {
                var cropPlugin = this.plugins['crop'];
                cropPlugin.selectZone(50, 50, 450, 450);
                // Add custom listener
                var images_crop = this;

                $('#createCollection').find('.darkroom-toolbar .darkroom-button-group').eq(0).hide();
                $('#createCollection').find('.darkroom-toolbar .darkroom-button-group').eq(1).hide();
                $('#createCollection').find('.darkroom-toolbar').append('<div class="darkroom-button-group luu_image" style="display:none"><button type="button" class="darkroom-button darkroom-button-default">Lưu</button></div>');
                
                this.addEventListener('core:transformation', function() {
                    newImage = images_crop.sourceImage.toDataURL();
                    $('#createCollection').find('.darkroom-toolbar .darkroom-button-group').eq(1).show();
                    $('#createCollection').find('.darkroom-toolbar .luu_image').show();
                    new_src = newImage;
                    // $('body').find('.darkroom-toolbar .luu_image').attr('data-src', newImage);
                    // $('body').find('.after_crop').show();
                    // $('#crop-zone').empty();
                    // $('#crop-zone').append('<img class="reviewImg center" id="reviewImg" src="'+newImage+'">');
                });
              }
            });
          }
        };
      }
      reader.readAsDataURL(this.files[0]);
    }
  });

  $('body').on('click','#createCollection .luu_image',function(){
    // var newImage = $(this).attr('data-src');
    var newImage = new_src;
    $('#createCollection .after_crop').show();
    $('#createCollection #crop-zone').empty();
    $('#createCollection #crop-zone').append('<img class="reviewImg center" id="reviewImg" src="'+newImage+'">');
  });

  $('body').on('click','#createCollection .modal-footer .after_crop',function(){
    var formData = new FormData();
    var isPublic = 0;
    if($('#createCollection input[name="isPublic"]:checked').length){
      var isPublic = 0;
    } else {
      var isPublic = 1;
    }
    formData.append('srcImg',$('#createCollection #reviewImg').attr('src'));
    formData.append('nameCollection',$('#createCollection input[name="nameCollection"]').val());
    formData.append('isPublic',isPublic);
    formData.append('type',type_collection);
    formData.append('sho_id','<?=$shop_current->sho_id?>');
    formData.append('is_owner','shop');

    $('.load-wrapp').show();
		$.ajax({
      url: "<?php echo base_url(); ?>collection/ajax_createCollection_choose",
			type: "POST",
		  data: formData,
      contentType:false,
      processData:false,
			success: function(response)
      {
        if(response == 1){
          $('#createCollection').modal('hide');
          location.reload();
        }else{
          alert("Error conection!!!");
        }
        $('.load-wrapp').hide();
      },
      error: function () {
        alert("Error conection!!!");
        $('.load-wrapp').hide();
      }
		});
  });

</script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="/templates/home/darkroomjs/css/darkroom.css" type="text/css" rel="stylesheet" />
<script src="/templates/home/darkroomjs/js/fabric.js"></script>
<script src="/templates/home/darkroomjs/js/darkroom.js"></script>
<!-- <script src="/templates/home/boostrap/js/bootstrap.min.js"></script> -->

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
<div class="modal fade" id="editCollection">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title"><span class="tab_edit_collection">Chỉnh sữa bộ sưu tập</span><span class="tab_remove_collection">Chọn xóa</span></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="edit-coll">
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
            <div class="form-group">
              <label class="col-form-label">Tên bộ sưu tập:</label>
              <input type="text" autocomplete="off" name="nameCollection" value="" class="">
            </div>
            <div class="form-group">
              <label class="col-form-label">Bí mật:</label>
              <input type="checkbox" name="isPublic" value="check" class="" checked>
            </div>
          </form>
        </div>

        <!-- Modal footer -->
        <div class="modal-footer buttons-group">
          <button type="button" class="btn btn-bg-gray btn_save_edit_collection">Xong</button>
          <button type="button" class="btn btn-bg-white" data-dismiss="modal">Đóng</button>
        </div>
      </div>

      <div class="remove-coll" style="display:none">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-form-label" style="">Bạn có chắc xóa bộ sưu tập này ?</label>
          </div>
          <div class="buttons-group">
            <button type="button" class="btn btn-bg-gray btn_remove">Có</button>
            <button type="button" class="btn btn-bg-white" data-dismiss="modal">Không</button>
          </div>
        </div>
      </div>
      

    </div>
  </div>
</div>

<script>
  var ojb = {};
  var has_newImg = 0;
  var new_src = null;

  $('body').on('click','.editCollection',function(){
    ojb = {
      key : $(this).attr('data-key'),
      avatar : $(this).attr('data-img'),
      title : $(this).attr('data-title'),
      isPublic : $(this).attr('data-pub'),
      img : $(this).attr('data-img'),
    }
    $('#editCollection').modal('show');
    $('#editCollection .edit-coll').show();
    $('#editCollection .remove-coll').hide();

    $('#editCollection .after_crop').hide();
    $('#editCollection #crop-zone').html('<img class="reviewImg center" id="reviewImg" src="' + ojb.avatar + '">');
    $('#editCollection input[name="nameCollection"]').val(ojb.title);
    if(ojb.isPublic == 1){
      $('#editCollection input[name="isPublic"]').attr('checked',false);
    }else{
      $('#editCollection input[name="isPublic"]').attr('checked',true);
    }
  });

  $('body').on('change','#editCollection #img-collection', function(){
    $('#editCollection .btn_save_edit_collection').hide();
    $('#editCollection #crop-zone').html('<img class="reviewImg center" id="reviewImg" src="">');
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var image = new Image();
        image.src = e.target.result;
        image.onload = function() {
          if ((this.width <= 600) && (this.height <= 600)) {
            alert('Kích thước ảnh bắt buộc lớn hơn 600 x 600');
          } else {
            var getWidth = $('#editCollection .edit-coll .modal-body').width();
            $('#editCollection #reviewImg').attr('src', e.target.result);
              var dkrm = new Darkroom('#editCollection #reviewImg', {
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

                $('#editCollection').find('.darkroom-toolbar .darkroom-button-group').eq(0).hide();
                $('#editCollection').find('.darkroom-toolbar .darkroom-button-group').eq(1).hide();
                $('#editCollection').find('.darkroom-toolbar').append('<div class="darkroom-button-group luu_image" style="display:none"><button type="button" class="darkroom-button darkroom-button-default">Lưu</button></div>');
                
                this.addEventListener('core:transformation', function() {
                    newImage = images_crop.sourceImage.toDataURL();
                    $('#editCollection').find('.darkroom-toolbar .darkroom-button-group').eq(1).show();
                    $('#editCollection').find('.darkroom-toolbar .luu_image').show();
                    
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

  $('body').on('click','#editCollection .luu_image',function(){
    var newImage = new_src;
    has_newImg = 1;
    $('#editCollection .btn_save_edit_collection').show();
    $('#editCollection #crop-zone').empty();
    $('#editCollection #crop-zone').append('<img class="reviewImg center" id="reviewImg" src="'+newImage+'">');
  });

  $('body').on('click','#editCollection .modal-footer .btn_save_edit_collection',function(){

    var formData = new FormData();
    if($('#editCollection input[name="isPublic"]:checked').length){
      var isPublic = 0;
    } else {
      var isPublic = 1;
    }

    formData.append('srcImg',$('#editCollection #reviewImg').attr('src'));
    formData.append('nameCollection',$('#editCollection input[name="nameCollection"]').val());
    formData.append('isPublic',isPublic);
    formData.append('type',type_collection);
    formData.append('has_newImg',has_newImg);
    formData.append('key',ojb.key);

    $('.load-wrapp').show();
		$.ajax({
      url: "<?php echo base_url(); ?>collection/ajax_updateCollection_choose",
			type: "POST",
		  data: formData,
      contentType:false,
      processData:false,
			success: function(response)
      {
        if(response == 1){
          $('#editCollection').modal('hide');
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

  $('body').on('click','#editCollection .tab_remove_collection', function(){
    $('#editCollection .edit-coll').hide();
    $('#editCollection .remove-coll').show();
  });

  $('body').on('click','#editCollection .tab_edit_collection', function(){
    $('#editCollection .edit-coll').show();
    $('#editCollection .remove-coll').hide();
  });
  
  $('body').on('click','#editCollection .btn_remove', function(){
    var formData = new FormData();
    formData.append('key',ojb.key);
    formData.append('type',type_collection);

    $.ajax({
      url: "<?php echo base_url(); ?>collection/ajax_deleteCollection_choose",
			type: "POST",
		  data: formData,
      contentType:false,
      processData:false,
			success: function(response)
      {
        if(response == 1){
          $('#editCollection').modal('hide');
          location.reload();
        }else{
          alert("Error conection!!!");
        }
      },
      error: function () {
        alert("Error conection!!!");
      }
		});
  });

</script>
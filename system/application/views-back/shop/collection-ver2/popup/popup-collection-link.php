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
<div class="modal fade bst-modal" id="createCollection" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm">
    <div class="modal-content modal-content-fixed">

      <!-- Modal Header -->
      <div class="modal-header modal-header-fixed">
        <h4 class="modal-title">Tạo bộ sưu tập</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body edit-coll modal-body-fixed">
          <div class="form-group __image-library-link js-crop-box">
            <img class="reviewImg center js_custom-link-image-icon" src="/templates/home/styles/images/svg/add_avata.svg">
            <div class="wrap-block-custom-link">
              <img class="center js_custom-link-image" src="/templates/home/styles/images/default/error_image_400x400.jpg">
            </div>
            <p class="text-danger text-center pl-4 js_image-msg"></p>
          </div>

          <div class="form-group after_crop" style="display:none">
            <!-- <label class="col-form-label ten-bst">Tên bộ sưu tập</label> -->
            <input type="text" autocomplete="off" name="nameCollection" placeholder="Tên bộ sưu tập" class="ten-bst-input">
          </div>
          <div class="form-group after_crop" style="display:none">
            <label class="checkbox-style-circle">
            <input type="radio" name="permission" value="1" class="" checked><span>Cá nhân</span>
            </label>
            <label class="checkbox-style-circle ml30">
            <input type="radio" name="permission" value="0" class="" checked><span>Doanh nghiệp</span>
            </label>
          </div>
          <div class="form-group after_crop" style="display:none">
            <!-- <label class="col-form-label ten-bst">Tên bộ sưu tập</label> -->
            <select name="collectionCate" id="" class="select-category">
              <option value="0">Chọn danh mục - (không bắt buộc)</option>
              <?php foreach ($link_categories_p as $key => $cate) { ?>
              <option value="<?=$cate['id']?>"><?=$cate['name']?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group after_crop" style="display:none">
            <!-- <label class="col-form-label ten-bst">Tên bộ sưu tập</label> -->
            <textarea name="collectionDes" id="" class="w100pc" rows="5" placeholder="Mô tả tối đa 300 ký tự"></textarea>
          </div>

          <div class="form-group after_crop" style="display:none">
            <label class="checkbox-style">
            <input type="checkbox" name="isPublic" value="check" class=""><span>Bí mật</span>
            </label>
          </div>

          <div class="hidden js-input">
            <input type="file" name="image_crop">
          </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer buttons-group modal-footer-fixed">
        <button type="button" class="btn btn-bg-white" data-dismiss="modal">Hủy</button>
        <button type="button" class="btn btn-bg-gray after_crop js-submit-collection">Lưu</button>
      </div>

    </div>
  </div>
</div>

<script>
  // data process
  var new_image_name = '';
  // end data process
  var new_src = data_image = null;

  var html_crop_box_default =  '<img class="reviewImg center js_custom-link-image-icon" src="/templates/home/styles/images/svg/add_avata.svg">';
      html_crop_box_default += '<div class="wrap-block-custom-link">';
      html_crop_box_default +=  '<img class="center js_custom-link-image" src="/templates/home/styles/images/default/error_image_400x400.jpg">';
      html_crop_box_default += '</div>';
      html_crop_box_default += '<p class="text-danger text-center pl-4 js_image-msg"></p>';

  var html_crop_box_process =  '';
      html_crop_box_process += '<div class="wrap-block-custom-link">';
      html_crop_box_process +=  '<img class="center js_custom-link-image-crop" src="">';
      html_crop_box_process += '</div>';

  var html_crop_box_finish =  '';
      html_crop_box_finish += '<div class="wrap-block-custom-link">';
      html_crop_box_finish +=  '<img class="center js_custom-link-image-finish" src="">';
      html_crop_box_finish += '</div>';

  // open popup tao bst link
  $('body').on('click','.createCollection',function(){
    new_src = data_image = null;
    $('#createCollection').modal('show');
    $('#createCollection .js-crop-box').empty();
    $('#createCollection .js-crop-box').html(html_crop_box_default);
    $('#createCollection .after_crop').hide();
  });

  // trigger click input
  $('body').on('click','#createCollection .js_custom-link-image-icon',function(){
    $('#createCollection .js-input input[name="image_crop"]').trigger('click');
  });

  // crop ảnh
  $('body').on('change','#createCollection .js-input input[name="image_crop"]',function(){
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var image = new Image();
        image.src = e.target.result;
        image.onload = function() {
          if ((this.width <= 600) && (this.height <= 600)) {
            $('body').find('#createCollection .js_image-msg').text('Kích thước ảnh bắt buộc lớn hơn 600 x 600')
          } else {
            $('#createCollection .js-input input[name="image_crop"]').val('');
            $('#createCollection .after_crop').hide();

            var getWidth = $('#createCollection .modal-body').width();
            $('#createCollection .js-crop-box').empty();
            $('#createCollection .js-crop-box').html(html_crop_box_process);

            $('#createCollection .js_custom-link-image-crop').attr('src', e.target.result);
              var dkrm = new Darkroom('#createCollection .js_custom-link-image-crop', {
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
                    var newImage = images_crop.sourceImage.toDataURL();
                    $('#createCollection').find('.darkroom-toolbar .darkroom-button-group').eq(1).show();
                    $('#createCollection').find('.darkroom-toolbar .luu_image').show();
                    new_src = newImage;
                });
              }
            });
          }
        };
      }
      reader.readAsDataURL(this.files[0]);
    }
  });

  // lưu ảnh crop
  $('body').on('click','#createCollection .luu_image',function(){
    $('#createCollection .after_crop').show();
    $('#createCollection .js-crop-box').empty();
    $('#createCollection .js-crop-box').html(html_crop_box_default);
    $('#createCollection .js_custom-link-image').attr('src',new_src);

    $('.load-wrapp').show();

    data_image = get_blob_data_b64img(new_src);

    var formdata = new FormData();
    formdata.append("image", data_image.blob);
    $.ajax({
      type: "POST",
      url: "<?=$shop_url.'home/api_common/up_image'?>",
      data: formdata,
      processData: false,
      contentType: false,
      dataType:"json",
      success: function (response) {
        $('.load-wrapp').hide();
        if(response.status == 1) {
          var result = response.data;
          new_image_name = result.original;
        } else {
          alert("Lỗi xử lý ảnh!!!");
          $('#createCollection').modal('hide');
        }
      },
      error: function(err){
        alert("Lỗi!!!");
      },
    });
  });

  $('body').on('click', '#createCollection .js-submit-collection', function (e) {
    if($('#createCollection input[name="nameCollection"]').val().trim() == '') {
      $('body').find('#createCollection .js_image-msg').text('Chưa nhập tên bộ sưu tập');
      e.stopPropagation();
      return false;
    }
    var isPublic = 1;
    if($('#createCollection input[name="isPublic"]:checked').length){
      isPublic = 0;
    }

    var formdata = new FormData();
    formdata.append('name', $('#createCollection input[name="nameCollection"]').val().trim());
    formdata.append('description', $('#createCollection textarea[name="collectionDes"]').val());
    formdata.append('avatar_path', new_image_name);
    formdata.append('img_width', data_image.width);
    formdata.append('img_height', data_image.height);
    formdata.append('mime', data_image.contentType);
    formdata.append('orientation', 0);
    formdata.append('isPublic', isPublic);
    formdata.append('is_personal', $('#createCollection input[name="permission"]:checked').val());
    formdata.append('cate_id', $('#createCollection select[name="collectionCate"] option').filter(":selected").val());
    $('.load-wrapp').show();

    $.ajax({
      url: "<?=$shop_url.'home/api_collection/create_collection_link'?>",
			type: "POST",
      data: formdata,
      contentType: false,
      processData: false,
      dataType: 'json',
			success: function(response) {
        if(response.err == true) {
          alert(response.mgs);
          $('.load-wrapp').hide();
        } else {
          window.location.reload();
        }
      },
      error: function () {
        alert('Error Connection!!!');
        $('.load-wrapp').hide();
      }
    });
  });

</script>

<!-- // popup edit collection link -->
<div class="modal fade bst-modal" id="editCollection" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm">
    <div class="modal-content modal-content-fixed">

      <!-- Modal Header -->
      <div class="modal-header modal-header-fixed">
        <h4 class="modal-title">Chỉnh sửa bộ sưu tập</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body edit-coll modal-body-fixed">
          <div class="form-group __image-library-link js-crop-box">
            <img class="reviewImg center js_custom-link-image-icon" src="/templates/home/styles/images/svg/add_avata.svg">
            <div class="wrap-block-custom-link">
              <img class="center js_custom-link-image" src="/templates/home/styles/images/default/error_image_400x400.jpg">
            </div>
            <p class="text-danger text-center pl-4 js_image-msg"></p>
          </div>

          <div class="form-group after_crop">
            <!-- <label class="col-form-label ten-bst">Tên bộ sưu tập</label> -->
            <input type="text" autocomplete="off" name="nameCollection" placeholder="Tên bộ sưu tập" class="ten-bst-input">
          </div>
          <div class="form-group after_crop">
            <!-- <label class="col-form-label ten-bst">Tên bộ sưu tập</label> -->
            <select name="collectionCate" id="" class="select-category">
              <option value="0">Chọn danh mục - (không bắt buộc)</option>
              <?php foreach ($link_categories_p as $key => $cate) { ?>
              <option value="<?=$cate['id']?>"><?=$cate['name']?></option>
              <?php } ?>
            </select>
          </div>
          <div class="form-group after_crop">
            <!-- <label class="col-form-label ten-bst">Tên bộ sưu tập</label> -->
            <textarea name="collectionDes" id="" class="w100pc" rows="5" placeholder="Mô tả tối đa 300 ký tự"></textarea>
          </div>

          <div class="form-group after_crop">
            <label class="checkbox-style">
            <input type="checkbox" name="isPublic" value="check" class=""><span>Bí mật</span>
            </label>
          </div>

          <div class="hidden js-input">
            <input type="file" name="image_crop">
          </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer buttons-group modal-footer-fixed">
        <div class="bst-group-button">
          <div class="left">
            <!-- <button type="button" class="btn btn-bg-gray after_crop js-delete-collection" data-dismiss="modal">Xóa</button> -->
          </div>
          <div class="right">
            <button type="button" class="btn btn-bg-white" data-dismiss="modal">Hủy</button>
            <button type="button" class="btn btn-bg-gray after_crop js-submit-collection">Lưu</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  var data_id = data_name = data_description = data_cate_id = data_avatar = data_isPublic = '';

  $('body').on('click', '.editCollection', function () {
    new_src = data_image = null;
    $('.load-wrapp').show();
    data_id = $(this).attr('data-id');
    data_name = $(this).attr('data-name');
    data_description = $(this).attr('data-description');
    data_cate_id = $(this).attr('data-cate_id');
    data_avatar = $(this).attr('data-avatar-path');
    data_isPublic = $(this).attr('data-isPublic');
    data_is_personal = $(this).attr('data-is_personal');
    var src = $(this).attr('data-avatar-full');

    // meta hình
    data_image = getMeta(src);

    $('#editCollection .js-crop-box').empty();
    $('#editCollection .js-crop-box').html(html_crop_box_default);

    $('#editCollection .after_crop').show();
    $('#editCollection input[name="nameCollection"]').val(data_name);
    $('#editCollection textarea[name="collectionDes"]').val(data_description);
    $('#editCollection select[name="collectionCate"] option[value='+data_cate_id+']').attr('selected','selected');
    if(data_isPublic == 1) {
      $('#editCollection input[name="isPublic"]').attr('checked', false);
    } else {
      $('#editCollection input[name="isPublic"]').attr('checked', true);
    }
    $('#editCollection .js_custom-link-image').attr('src', src);

    setTimeout(function () {
      $('.modal').modal('hide');
      $('#editCollection').modal('show');
      $('.load-wrapp').hide();
    }, 1000);
  });

  // trigger click input
  $('body').on('click','#editCollection .js_custom-link-image-icon',function(){
    $('#editCollection .js-input input[name="image_crop"]').trigger('click');
  });

  // crop ảnh
  $('body').on('change','#editCollection .js-input input[name="image_crop"]',function(){
    if (this.files && this.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var image = new Image();
        image.src = e.target.result;
        image.onload = function() {
          if ((this.width <= 600) && (this.height <= 600)) {
            $('body').find('#editCollection .js_image-msg').text('Kích thước ảnh bắt buộc lớn hơn 600 x 600')
          } else {
            $('#editCollection .js-input input[name="image_crop"]').val('');
            $('#editCollection .after_crop').hide();

            var getWidth = $('#editCollection .modal-body').width();
            $('#editCollection .js-crop-box').empty();
            $('#editCollection .js-crop-box').html(html_crop_box_process);

            $('#editCollection .js_custom-link-image-crop').attr('src', e.target.result);
              var dkrm = new Darkroom('#editCollection .js_custom-link-image-crop', {
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
                    var newImage = images_crop.sourceImage.toDataURL();
                    $('#editCollection').find('.darkroom-toolbar .darkroom-button-group').eq(1).show();
                    $('#editCollection').find('.darkroom-toolbar .luu_image').show();
                    new_src = newImage;
                });
              }
            });
          }
        };
      }
      reader.readAsDataURL(this.files[0]);
    }
  });

  // lưu ảnh crop
  $('body').on('click','#editCollection .luu_image',function(){
    $('#editCollection .after_crop').show();
    $('#editCollection .js-crop-box').empty();
    $('#editCollection .js-crop-box').html(html_crop_box_default);
    $('#editCollection .js_custom-link-image').attr('src',new_src);

    $('.load-wrapp').show();

    data_image = get_blob_data_b64img(new_src);

    var formdata = new FormData();
    formdata.append("image", data_image.blob);
    $.ajax({
      type: "POST",
      url: "<?=$shop_url.'home/api_common/up_image'?>",
      data: formdata,
      processData: false,
      contentType: false,
      dataType:"json",
      success: function (response) {
        $('.load-wrapp').hide();
        if(response.status == 1) {
          var result = response.data;
          data_avatar = result.original;
        } else {
          alert("Lỗi xử lý ảnh!!!");
          $('#editCollection').modal('hide');
        }
      },
      error: function(err){
        alert("Lỗi!!!");
      },
    });
  });

  // api/collection/link/edit
  $('body').on('click', '#editCollection .js-submit-collection', function (e) {
    if($('#editCollection input[name="nameCollection"]').val().trim() == '') {
      $('body').find('#editCollection .js_image-msg').text('Chưa nhập tên bộ sưu tập');
      e.stopPropagation();
      return false;
    }
    var isPublic = 1;
    if($('#editCollection input[name="isPublic"]:checked').length){
      isPublic = 0;
    }

    if(data_image == undefined || data_image == null) {
      data_image = getMeta(data_avatar);
    }

    var formdata = new FormData();
    formdata.append('id', data_id);
    formdata.append('name', $('#editCollection input[name="nameCollection"]').val().trim());
    formdata.append('description', $('#editCollection textarea[name="collectionDes"]').val());
    formdata.append('avatar_path', data_avatar);
    formdata.append('img_width', data_image.width);
    formdata.append('img_height', data_image.height);
    formdata.append('mime', data_image.contentType);
    formdata.append('orientation', 0);
    formdata.append('isPublic', isPublic);
    formdata.append('is_personal', data_is_personal);
    formdata.append('cate_id', $('#editCollection select[name="collectionCate"] option').filter(":selected").val());
    $('.load-wrapp').show();

    $.ajax({
      url: "<?=$shop_url.'home/api_collection/edit_collection_link'?>",
			type: "POST",
      data: formdata,
      contentType: false,
      processData: false,
      dataType: 'json',
			success: function(response) {
        if(response.err == true) {
          alert(response.mgs);
          $('.load-wrapp').hide();
        } else {
          window.location.reload();
        }
      },
      error: function () {
        alert('Error Connection!!!');
        $('.load-wrapp').hide();
      }
    });
  });
</script>
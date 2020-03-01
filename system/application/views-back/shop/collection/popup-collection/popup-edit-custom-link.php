<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<!-- <script src="/templates/home/boostrap/js/bootstrap.min.js"></script> -->

<style>
  .center {
    display: block;
    margin-left: auto;
    margin-right: auto;
    /* width: 50%; */
  }

  textarea.form-control {
    font-size: 15px;
  }
</style>
<!-- The Modal -->
<div class="modal fade" id="pu-edit-custom-link">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <div style="display:inline" class="add-more-txt">
          <h4 class="modal-title">Sửa nội dung link <?php //var_dump($c_id);?>
            <!-- <span class="btn btn-azibai btn-file upload_btn" id="sp_upload_1">
            <i class="fa fa-upload" aria-hidden="true"></i>
          </span> -->
          </h4>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
          <div class="form-group __image-library-link">
            <img class="reviewImg center js_custom-link-image-icon" id="reviewImg" src="/templates/home/styles/images/svg/add_avata.svg">
            <div class="wrap-block-custom-link"><img class="center js_custom-link-image" id="link_image" src=""></div>
          </div>
        </div>
        <div class="form-group">
          <label class="col-form-label">Tên tiêu đề:</label>
          <input type="text" autocomplete="off" name="link_title" class="" value="" disabled>
        </div>
        <div class="form-group">
          <label class="col-form-label">Mô tả:</label>
          <textarea class="form-control" rows="4" id="link_description" disabled>

          </textarea>
        </div>
        <div class="form-group">
          <label class="col-form-label">Nội dung:</label>
          <textarea class="form-control" rows="4" id="link_detail" placeholder="Nhập nội dung">

          </textarea>
        </div>
        <input type="file" class="hide_0 js_handle-image-upload js_handle_value">
        <input type="hidden" class="js_image-upload js_handle_value" name="image_path" value="">
        <input type="hidden" class="js_video-upload js_handle_value" name="video_path" value="">
      </div>

      <!-- Modal footer -->
      <div class="modal-footer buttons-group">
        <button type="button" class="btn btn-bg-gray btn_update">Cập nhật</button>
        <button type="button" class="btn btn-bg-white" data-dismiss="modal">Đóng</button>
      </div>

    </div>
  </div>
</div>

<script>
  var key = '';
  var tbl = '';
  var title = '';
  var description = '';
  var image = '';
  var detail = '';
  var sourceType = '';
  $('body').on('click', '.edit-lk', function () {
    key = $(this).attr('data-key');
    tbl = $(this).attr('data-tbl');
    title = $(this).attr('data-title');
    description = $(this).attr('data-description');
    source = $(this).attr('data-source');
    sourceType = $(this).attr('data-sourceType');
    image = $(this).attr('data-img');
    detail = $(this).attr('data-detail');

    $('#pu-edit-custom-link').modal('show');
    if(sourceType == 'image') {
      item_image = '<img class="center js_custom-link-image" id="link_image" src="'+source+'">';
      $('#pu-edit-custom-link .wrap-block-custom-link').html(item_image);
    } else if(sourceType == 'video') {
      item_video = '';
      item_video += '<video poster="'+image+'" playsinline preload="none" controls>';
      item_video += '  <source src="'+source+'" type="video/mp4">';
      item_video += '  Your browser does not support the video tag.';
      item_video += '</video>';
      $('#pu-edit-custom-link .wrap-block-custom-link').html(item_video);
    } else {
      item_image = '<img class="center js_custom-link-image" id="link_image" src="'+source+'">';
      $('#pu-edit-custom-link .wrap-block-custom-link').html(item_image);
    }
    $('#pu-edit-custom-link input[name="link_title"]').val(title);
    $('#pu-edit-custom-link textarea#link_description').val(description);
    $('#pu-edit-custom-link textarea#link_detail').val(detail);
  });

  $('#pu-edit-custom-link').on('click', '.btn_update', function () {
    var formData = new FormData();
    formData.append('id', key);
    formData.append('tbl', tbl);
    formData.append('type_id', '<?php echo $c_id ?>');
    formData.append('detail', $('#pu-edit-custom-link').find('textarea#link_detail').val());
    formData.append('image', $('#pu-edit-custom-link input[name="image_path"]').val());
    formData.append('video', $('#pu-edit-custom-link input[name="video_path"]').val());

    $.ajax({
      url: "<?php echo base_url(); ?>collection/ajax_Update_CustomLink_Collection",
      type: "POST",
      data: formData,
      contentType: false,
      processData: false,
      beforeSend: function () {
        $('body').find('.load-wrapp').show();
      },
      success: function (response) {
        if (response == 1) {
          // alert("Thêm thành công !!!");
          location.reload();
        } else {
          alert("Error conection !!!");
        }
      },
      error: function () {
        alert("Error conection !!!");
      }
    }).always(function() {
      $('.load-wrapp').hide();
    });
  });

  $('body').on('click', '#pu-edit-custom-link .js_custom-link-image-icon', function (event) {
    event.preventDefault();
    $('#pu-edit-custom-link .js_handle-image-upload').trigger('click')
  });

  $('body').on('change', '#pu-edit-custom-link .js_handle-image-upload', function (event) {
      event.preventDefault();

      if(event.target.files && event.target.files.length){
        var current_file = event.target.files[0];
      }
      if(typeof current_file === 'undefined' || !current_file){
        alert('Vui lòng chọn ảnh hoặc video');
        return;
      }

      var formData = new FormData();
      formData.append('media_file', current_file);
      $.ajax({
          url: window.location.origin + '/library-link/upload-media',
          type: 'post',
          data: formData,
          dataType: "json",
          contentType: false,
          processData: false,
          beforeSend: function () {
            $('body').find('.load-wrapp').show();
          },
          success: function (response) {
              console.log('response', response);
              if (response && response.status === 1) {
                  $('#pu-edit-custom-link .js_image-upload').val(response.image_name);
                  $('#pu-edit-custom-link .js_video-upload').val(response.video_name);

                  var temp_img = '';
                  if(response.image_url){
                      temp_img = response.image_url;
                  }

                  if(response.video_url){
                      var item_video = '';
                      item_video += '<video poster="'+temp_img+'" playsinline preload="none" controls>';
                      item_video += '  <source src="'+response.video_url+'" type="video/mp4">';
                      item_video += '  Your browser does not support the video tag.';
                      item_video += '</video>';
                      $('#pu-edit-custom-link .wrap-block-custom-link').html(item_video);
                  }else{
                      $('#pu-edit-custom-link .wrap-block-custom-link').html('<img class="center js_custom-link-image" src="'+temp_img+'">');
                  }

              }
              if (response && response.status === 0) {
                alert(response.message);
                  $('#pu-edit-custom-link .js_image-upload').val('');
                  $('#pu-edit-custom-link .js_custom-link-image').attr('src', default_image_error_path);
              }
          }
      }).always(function() {
        $('.load-wrapp').hide();
      });
  });
</script>
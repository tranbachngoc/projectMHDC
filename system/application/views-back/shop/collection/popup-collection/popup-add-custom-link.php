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
<div class="modal fade" id="pu-add-custom-link">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <div style="display:inline" class="add-more-txt"><h4 class="modal-title">Thêm link liên kết
          <!-- <span class="btn btn-azibai btn-file upload_btn" id="sp_upload_1">
            <i class="fa fa-upload" aria-hidden="true"></i>
          </span> -->
        </h4></div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group">
          <input type="text" autocomplete="off" name="url_process" class="url-processed" placeholder="nhập url" value="">
        </div>

        <!-- <div class="form-group">
          <img class="center" src="/templates/home/styles/images/default/error_image_400x400.jpg">
        </div>
        <div class="form-group">
          <label class="col-form-label">Tên tiêu đề:</label>
          <input type="text" name="" class="" value="">
        </div>
        <div class="form-group">
          <label class="col-form-label">Mô tả:</label>
          <input type="text" name="" class="" value="">
        </div> -->

      </div>

      <!-- Modal footer -->
      <div class="modal-footer buttons-group">
        <button type="button" class="btn btn-bg-gray btn_save">Xong</button>
        <button type="button" class="btn btn-bg-gray btn_process">Xử lý</button>
        <button type="button" class="btn btn-bg-white" data-dismiss="modal">Đóng</button>
      </div>

    </div>
  </div>
</div>

<script>
  var node_cl = null;
  $('body').on('click','.add-lk',function(){
    $('#pu-add-custom-link').modal('show');
    var html = '<div class="form-group">';
      html += '<input type="text" autocomplete="off" name="url_process" class="url-processed" placeholder="nhập url" value="">';
      html += '</div>';
    $('#pu-add-custom-link .modal-body').html(html);
    $('#pu-add-custom-link .btn_save').hide();
    $('#pu-add-custom-link .btn_process').show();
  });

  $('body').on('click','.add-more-txt',function(){
    // var html = '<div class="form-group"><input type="text" name="nameCollection" class="" placeholder="nhập url"></div>';
    // $('#cus-url-form').append(html);
  });

  $('body').on('click','.btn_process',function(){
    var _confirm = false;
    var formData = new FormData();
    formData.append('link',$('input[name="url_process"]').val());


    $.ajax({
      url: "<?php echo base_url(); ?>tintuc/linkinfo",
      type: "POST",
      data: formData,
      contentType:false,
      processData:false,
      success: function(response)
      {
        // config header trong function
        // response = node_cl = JSON.parse(response);
        node_cl = response
        if(response.title != '' && response.image != '' && response.host != ''){
          _confirm = true;
        } else {
          _confirm = confirm("Link xử lý hiện tại không chứa ảnh hoặc tiêu đề, bạn có muốn tiếp tục ?");
          response.image == '' ? response.image = '/templates/home/styles/images/default/image_link.jpg': '';
          response.title == '' ? response.title = 'Azibai link': '';
        }

        if(_confirm == true) {
          var html = '<div class="form-group">';
          html += '<div class="form-group __image-library-link">';
            html += '<img class="reviewImg center js_custom-link-image-icon" id="reviewImg" src="/templates/home/styles/images/svg/add_avata.svg">'
            // html += '<img class="center" src="'+response.image+'" id="link_image">';
            html += '<div class="wrap-block-custom-link"><img class="center js_custom-link-image" id="link_image" img-old="'+response.image+'" src="'+response.image+'"></div>'
          html += '</div>';
          html += '<div class="form-group">';
            html += '<label class="col-form-label">Tên tiêu đề:</label>';
            html += '<input type="text" autocomplete="off" name="link_title" class="" value="'+response.title+'" disabled>';
          html += '</div>';
          html += '<div class="form-group">';
            html += '<label class="col-form-label">Mô tả:</label>';
            html += '<textarea class="form-control" rows="4" id="link_description" disabled>';
              html += response.description;
            html += '</textarea>';
          html += '</div>';
          html += '<div class="form-group">';
            html += '<label class="col-form-label">Nội dung:</label>';
            html += '<textarea class="form-control" rows="4" id="link_detail" placeholder="Nhập nội dung">';
              // html += response.description;
            html += '</textarea>';
            html += '<input type="file" class="hide_0 js_handle-image-upload js_handle_value">';
            html += '<input type="hidden" class="js_image-upload js_handle_value" name="image_path" value="">';
            html += '<input type="hidden" class="js_video-upload js_handle_value" name="video_path" value="">';
          html += '</div>';
          $('#pu-add-custom-link .modal-body').html(html);
          $('#pu-add-custom-link .btn_process').hide();
          $('#pu-add-custom-link .btn_save').show();
        }
      },
      error: function () {
        alert("Error conection!!!");
      }
    });
  });

  $('body').on('click', '#pu-add-custom-link .js_custom-link-image-icon', function (event) {
    event.preventDefault();
    $('#pu-add-custom-link .js_handle-image-upload').trigger('click')
  });

  $('body').on('change', '#pu-add-custom-link .js_handle-image-upload', function (event) {
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
                  $('#pu-add-custom-link .js_image-upload').val(response.image_name);
                  $('#pu-add-custom-link .js_video-upload').val(response.video_name);

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
                      $('#pu-add-custom-link .wrap-block-custom-link').html(item_video);
                  }else{
                      $('#pu-add-custom-link .wrap-block-custom-link').html('<img class="center js_custom-link-image" src="'+temp_img+'">');
                  }

              }
              if (response && response.status === 0) {
                alert(response.message);
                  $('#pu-add-custom-link .js_image-upload').val('');
                  $('#pu-add-custom-link .js_custom-link-image').attr('src', default_image_error_path);
              }
          }
      }).always(function() {
        $('.load-wrapp').hide();
      });
  });

  $('body').on('click','#pu-add-custom-link .btn_save',function(){
    var formData = new FormData();
    formData.append('type_id','<?php echo $c_id ?>');
    formData.append('type','collection');
    formData.append('save_link',node_cl.save_link);
    formData.append('detail',$('#pu-add-custom-link textarea#link_detail').val());
    formData.append('image',$('#pu-add-custom-link input[name="image_path"]').val());
    formData.append('video',$('#pu-add-custom-link input[name="video_path"]').val());

     $.ajax({
      url: "<?php echo base_url(); ?>collection/ajax_Save_CustomLink_Collection",
      type: "POST",
      data: formData,
      contentType:false,
      processData:false,
      success: function(response)
      {
        if(response == 1){
          // alert("Thêm thành công !!!");
          location.reload();
        }else{
          alert("Error conection !!!");
        }
      },
      error: function () {
        alert("Error conection !!!");
      }
    });

  });
</script>
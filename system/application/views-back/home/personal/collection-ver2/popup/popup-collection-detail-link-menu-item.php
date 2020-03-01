<div class="modal fade" id="js-menu-item">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">

      <!-- Modal body -->
      <div class="modal-body">

      </div>
    </div>
  </div>
</div>

<div class="modal fade bst-modal" id="popup-alert">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Chú ý</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <div class="form-group after_crop">
          <p>Xóa link sẽ loại bỏ link được chọn ra khỏi <strong>tất cả bộ sưu tập link</strong> đang có link được chọn và xóa khỏi link trong <strong>thư viện link liên kết</strongtất></p>
          <p><strong>Bạn vẫn muốn xóa link này ?</strong></p>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer buttons-group">
        <button type="button" class="btn btn-bg-gray js-delete-link">Xóa</button>
        <button type="button" class="btn btn-bg-white" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

<script>
  var user_id = 0;
  $('body').on('click', '.js-menu-open-user', function () {
    user_id = parseInt($(this).attr('data-user_id'));
    data_id = $(this).attr('data-id');
    data_link_type = $(this).attr('data-link_type');
    data_copy_link = $(this).attr('data-link_url');

    var template = $('#tpl-menu-open-user').html();
    template = template.replace('{{DATA_ID}}', data_id)
    .replace('{{DATA_ID}}', data_id)
    .replace('{{DATA_ID}}', data_id)
    .replace('{{DATA_TYPE}}', data_link_type)
    .replace('{{DATA_TYPE}}', data_link_type)
    .replace('{{DATA_TYPE}}', data_link_type)
    .replace('{{DATA_COPY_LINK}}', data_copy_link);

    $('#js-menu-item .modal-body').html(template)
    if(user_id != <?=(int)$this->session->userData('sessionUser')?>) {
      $('#js-menu-item .modal-body .menu-edit-link').remove();
      $('#js-menu-item .modal-body .menu-delete-link').remove();
    } else {
      $('#js-menu-item .modal-body .menu-save-link').remove();
    }
    $('#js-menu-item').modal('show');
  })

  $('body').on('click', '#js-menu-item .menu-delete-link', function () {
    $('.modal').modal('hide');
    $('#popup-alert .js-delete-link').attr('data-id', $(this).attr('data-id'));
    $('#popup-alert .js-delete-link').attr('data-link_type', $(this).attr('data-link_type'));
    setTimeout(function () {
      $('#popup-alert').modal('show');
    }, 500);
  })

  $('body').on('click', '#popup-alert .js-delete-link', function () {
    var formData = new FormData();
    formData.append('id', $(this).attr('data-id'));
    formData.append('type', $(this).attr('data-link_type'));

    $.ajax({
      type: "POST",
      url: "<?=$url_javascript.'home/api_link/delete_link'?>",
      data: formData,
      dataType: "json",
      processData: false,
      contentType: false,
      beforeSend: function () {
        $('.modal').modal('hide');
        $('.load-wrapp').show();
      },
      success: function (response) {
        console.log(response);
      },
      error: function(err){
        alert("Lỗi!!!");
      },
    });
  });
</script>

<script type="text/html" id="tpl-menu-open-user">
  <ul class="show-more-detail">
    <li class="menu-edit-link"
        data-id="{{DATA_ID}}"
        data-link_type="{{DATA_TYPE}}">
      <a href="javascript:void(0)">Sửa link</a>
    </li>
    <li class="menu-delete-link"
        data-id="{{DATA_ID}}"
        data-link_type="{{DATA_TYPE}}">
      <a href="javascript:void(0)">Xóa link</a>
    </li>
    <li class="menu-save-link"
        data-id="{{DATA_ID}}"
        data-link_type="{{DATA_TYPE}}">
      <a href="javascript:void(0)">Lưu link</a>
    </li>
    <li onclick="copy_text('{{DATA_COPY_LINK}}')">
      <a href="javascript:void(0)">Sao chép liên kết</a>
    </li>
    <li>
      <a href="javascript:void(0)">Chia sẻ liên kết</a>
    </li>
  </ul>
</script>
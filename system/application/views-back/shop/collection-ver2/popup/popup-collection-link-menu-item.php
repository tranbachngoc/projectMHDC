<div class="modal" id="js-menu-item">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">

      <!-- Modal body -->
      <div class="modal-body">
       
      </div>
    </div>
  </div>
</div>

<script>
  var user_id = 0;
  $('body').on('click', '.js-menu-open-user', function () {
    user_id = parseInt($(this).attr('data-user_id'));
    data_id = $(this).attr('data-id');
    data_name = $(this).attr('data-name');
    data_description = $(this).attr('data-description');
    data_cate_id = $(this).attr('data-cate_id');
    data_avatar_path = $(this).attr('data-avatar-path');
    data_avatar_full = $(this).attr('data-avatar-full');
    data_isPublic = $(this).attr('data-isPublic');
    data_is_personal = $(this).attr('data-is_personal');

    data_copy_link = window.location.hostname + '/home/shop/collection_link_detail_v2/'+data_id;

    var template = $('#tpl-menu-open-user').html();
    template = template.replace('{{DATA_ID}}', data_id)
    .replace('{{DATA_NAME}}', data_name)
    .replace('{{DATA_DES}}', data_description)
    .replace('{{DATA_AVATAR_PATH}}', data_avatar_path)
    .replace('{{DATA_AVATAR_FULL}}', data_avatar_full)
    .replace('{{DATA_CATE_ID}}', data_cate_id)
    .replace('{{DATA_IS_PERSONAL}}', data_is_personal)
    .replace('{{DATA_IS_PUBLIC}}', data_isPublic)
    .replace('{{DATA_COPY_LINK}}', data_copy_link);

    $('#js-menu-item .modal-body').html(template)
    if(user_id != <?=(int)$this->session->userData('sessionUser')?>) {
      $('#js-menu-item .modal-body .editCollection').remove();
    }
    $('#js-menu-item').modal('show');
  })
</script>

<script type="text/html" id="tpl-menu-open-user">
  <ul class="show-more-detail">
    <li class="editCollection"
        data-id="{{DATA_ID}}"
        data-name="{{DATA_NAME}}"
        data-description="{{DATA_DES}}"
        data-avatar-path="{{DATA_AVATAR_PATH}}"
        data-avatar-full="{{DATA_AVATAR_FULL}}"
        data-cate_id="{{DATA_CATE_ID}}"
        data-is_personal="{{DATA_IS_PERSONAL}}"
        data-isPublic="{{DATA_IS_PUBLIC}}">
      <a href="javascript:void(0)">Chỉnh sửa bộ sưu tập</a>
    </li>
    <li>
      <a href="javascript:void(0)">Chia sẻ và gửi qua tin nhắn</a>
    </li>
    <li onclick="copy_text('{{DATA_COPY_LINK}}')">
      <a href="javascript:void(0)">Sao chép liên kết</a>
    </li>
  </ul>
</script>

<script type="text/html">
  <ul class="show-more-detail">
    <li data-id="{{DATA_ID}}"
        data-name="{{DATA_NAME}}"
        data-description="{{DATA_DES}}"
        data-avatar="{{DATA_AVATAR}}"
        data-cate_id="{{DATA_CATE_ID}}"
        data-is_personal="{{DATA_IS_PERSONAL}}"
        data-isPublic="{{DATA_IS_PUBLIC}}">
      <a href="javascript:void(0)">Ghim</a>
    </li>
    <li>
      <a href="javascript:void(0)">Chia sẻ và gửi qua tin nhắn</a>
    </li>
    <li>
      <a href="javascript:void(0)">Sao chép liên kết</a>
    </li>
    <li>
      <a href="javascript:void(0)">Báo cáo</a>
    </li>
  </ul>
</script>
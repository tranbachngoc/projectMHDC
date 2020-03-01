<!-- // menu action -->
<div class="modal" id="js-menu-item">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <ul class="show-more-detail">
          <li class="js-action-phancap-step1">
            <a href="javascript:void(0)">Phân cấp</a>
          </li>
          <li class="js-action-service-item-step1">
            <a href="javascript:void(0)">Cấu hình hoa hồng theo từng sản phẩm</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</div>

<!-- //  -->
<div class="modal" id="js-action-phancap-step1">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"> </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <ul class="show-more-detail">
          <li class="level-3">
            <label class="checkbox-style-circle">
              <input type="radio" name="level" value="3"><span>Đại lý (A3)</span>
            </label>
          </li>
          <li class="level-2">
            <label class="checkbox-style-circle">
              <input type="radio" name="level" value="2"><span>Tổng đại lý (A2)</span>
            </label>
          </li>
          <li class="level-2">
            <label class="checkbox-style-circle">
              <input type="radio" name="level" value="1"><span>Nhà phân phối (A1)</span>
            </label>
          </li>
        </ul>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer buttons-group">
        <div class="bst-group-button">
          <div class="left">
            <!-- <button type="button" class="btn btn-bg-gray after_crop js-delete-collection" data-dismiss="modal">Xóa</button> -->
          </div>
          <div class="right">
            <button type="button" class="btn btn-bg-white" data-dismiss="modal">Hủy</button>
            <button type="button" class="btn btn-bg-gray js-submit-action-phancap">Lưu</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="modal" id="js-action-show">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">THÔNG BÁO</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer buttons-group">
        <div class="bst-group-button">
          <div class="left">

          </div>
          <div class="right">
            <button type="button" class="btn btn-bg-white" data-dismiss="modal">Đóng</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>

<script>
  var id = name = level = '';
  $('body').on('click', '.js-menu-item', function () {
    id = $(this).attr('data-id');
    name = $(this).attr('data-name');
    level = $(this).attr('data-level');
    $('#js-menu-item .modal-header .modal-title, #js-action-phancap-step1 .modal-header .modal-title').text(name);
    $('#js-menu-item .js-action-phancap-step1').attr('data-id',id);
    $('#js-menu-item').modal('show');
  })

  // Phân cấp
  $('body').on('click', '.js-action-phancap-step1', function () {
    $('.modal').modal('hide');
    var id = $('#js-menu-item .js-action-phancap-step1').attr('data-id');
    $('#js-action-phancap-step1 .js-submit-action-phancap').attr('data-id', id);
    $('#js-action-phancap-step1 input[name="level"][value='+level+']').attr('checked', true);
    $('#js-action-phancap-step1').modal('show');
  });

  $('body').on('click', '#js-action-phancap-step1 input[name="level"]', function () {
    $('#js-action-phancap-step1 .js-submit-action-phancap').attr('data-level', $(this).val());
  });

  $('body').on('click', '#js-action-phancap-step1 .js-submit-action-phancap', function () {
    id = $(this).attr('data-id');
    level = $(this).attr('data-level');
    $.ajax({
      type: "post",
      url: siteUrl+"profile/affiliate/editlevel",
      data: {id: id, level : level, type_request : 1},
      dataType: "json",
      beforeSend: function () {
        $('.load-wrapp').show();
      },
      success: function (response) {
        $('.load-wrapp').hide();
        if(response.type == 'success') {
          window.location.reload();
        } else {
          $('#js-action-show .modal-body').html(response.message);
          $('#js-action-phancap-step1').modal('hide');
          $('#js-action-show').modal('show');
        }
      }
    });
  });

  $('#js-action-show').on('hidden.bs.modal', function () {
    $('#js-action-phancap-step1').modal('show');
  });

  // cấu hình hoa hồng từng sản phẩm
  $('body').on('click', '.js-action-service-item-step1', function () {
    var url = "<?=azibai_url('/affiliate/user/')?>" + id + '<?="?type_sv=1&href=".urlencode(get_current_full_url())?>';
    window.location.replace(url);
  })
</script>
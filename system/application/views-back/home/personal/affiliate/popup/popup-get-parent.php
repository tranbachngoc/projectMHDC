<div class="modal" id="list_parent">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">DANH SÁCH HỆ THỐNG AFFILIATE</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <ul class="show-more-detail">
          
        </ul>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer buttons-group">
        <div class="bst-group-button">
          <div class="left">
          </div>
          <div class="right">
            <button type="button" class="btn btn-bg-white" data-dismiss="modal">Đóng</button>
            <button type="button" class="btn btn-bg-gray accept_parent">Chọn</button>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<script>
  $('body').on('click', '#chose_parent', function () {
    $.get( siteUrl+"affiliate/getlistparent", function( response ) {
      console.log(response);
      if(typeof response.data != 'undefined') {
        var html = '';
        $.each(response.data, function ( index, item) {
          html +='<li class="">';
            html +='<label class="checkbox-style-circle">';
            if(item.check == 1) {
              html +='<input type="radio" name="parent_id" value="'+item.parent_id+'" checked><span>'+item.name+'</span>';
            }else {
              html +='<input type="radio" name="parent_id" value="'+item.parent_id+'"><span>'+item.name+'</span>';
            }
            html +='</label>';
          html +='</li>';
        });
        $('#list_parent .show-more-detail').html(html);
        $('#list_parent').modal('show');
      }
    });
  });
  $('body').on('click', '.accept_parent', function () {
    var parent_id = $("#list_parent .show-more-detail input[type='radio']:checked").val();
    $.get( siteUrl+"affiliate/choseparent/"+parent_id, function( response ) {
      if(response.type == 'success') {
        location.reload();
      }
    });
  });
  function open_chose() {
    $.get( siteUrl+"affiliate/getlistparent", function( response ) {
      console.log(response);
      if(typeof response.data != 'undefined') {
        var html = '';
        $.each(response.data, function ( index, item) {
          html +='<li class="">';
            html +='<label class="checkbox-style-circle">';
            if(item.check == 1) {
              html +='<input type="radio" name="parent_id" value="'+item.parent_id+'" checked><span>'+item.name+'</span>';
            }else {
              html +='<input type="radio" name="parent_id" value="'+item.parent_id+'"><span>'+item.name+'</span>';
            }
            html +='</label>';
          html +='</li>';
        });
        $('#list_parent .show-more-detail').html(html);
        $('#list_parent').modal('show');
      }
    });
    $('#list_parent').on('hidden.bs.modal', function () {
      $.get( siteUrl+"affiliate/checkparent", function( response ) {
        if(response.type == 'error') {
          open_chose();
        }
      });
    });
  }
</script>
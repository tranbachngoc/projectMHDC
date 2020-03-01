<div class="modal fade" id="pu-pin-node-to-collection">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <div class="add-more-txt">
            <h4 class="modal-title">Ghim vào bộ sưu tập</h4>
        </div>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer buttons-group">
        
      </div>

    </div>
  </div>
</div>
<script>
  var content = '';
  var linkfrom = '';
  $('body').on('click','.pin-node-collection',function(){
    $('#pu-pin-node-to-collection').modal('show');
    var key = $(this).attr('data-key');
    // 1-content/2-product/3-link
    if(type_collection == "<?=COLLECTION_CUSTOMLINK?>") {
      linkfrom = $(this).attr('data-linkfrom');
      var url = "<?=base_url() ?>collection/ajax_loadCollection/"+key+"/"+type_collection+"/"+linkfrom;
    } else {
      var url = "<?=base_url() ?>collection/ajax_loadCollection/"+key+"/"+type_collection;
    }

    $.ajax({
      type: 'POST',
      url: url,
      success: function(data) {
        $('#pu-pin-node-to-collection').find('.modal-body').html(data);
      }
    });

  });

</script>
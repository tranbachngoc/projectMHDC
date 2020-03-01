<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading"><h3 class="panel-title">Lịch sử tin nhắn</h3></div>
        <div class="panel-body">
            <div id="user-activities" class="tab-pane active">
                <div class="timeline-2">
                    <?php if($all_comments): ?>
                        <?php foreach($all_comments as $key => $vals): ?>
                            <div class="time-item">
                                <div class="item-info">
                                    <div class="text-muted"><?php echo date("d-m-Y H:i:s",strtotime($vals->lastupdated)); ?></div>
                                    <p class="history_group">
                                        <a class="history_logo" target="_blank" href="//<?php echo $_thumb[$key]['link'];?>">
                                            <img width="100%" src="<?php echo DOMAIN_CLOUDSERVER.$_thumb[$key]['logo'];?>" title="<?php echo $_thumb[$key]['name']; ?>" alt="<?php echo $_thumb[$key]['name']; ?>"/>
                                        </a>
                                        
                                        <strong><?php echo $vals->content; ?></strong>
                                        <div class="bill">
                                            <?php if($_thumb[$key]['bill']): ?>
                                                <img id="bill" width="80%" src="<?php echo DOMAIN_CLOUDSERVER.$_thumb[$key]['bill'];?>" title="Hóa đơn - click phóng to" alt="Hóa đơn"/>
                                            <?php endif; ?>
                                        </div>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        Không có dữ liệu.
                    <?php endif; ?>
                </div>
            </div>
        </div> <!-- panel-body -->
    </div> <!-- panel -->
</div> <!-- col -->

<!-- Creates the bootstrap modal where the image will appear -->
<div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel">Hóa đơn vận chuyển</h4>
      </div>
      <div class="modal-body" style="text-align: center;">
        <img src="" id="imagepreview">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$("#bill").on("click", function() {
   $('#imagepreview').attr('src', $('#bill').attr('src')); // here asign the image to the modal when the user click the enlarge link
   $('#imagemodal').modal('show'); // imagemodal is the id attribute assigned to the bootstrap modal, then i use the show function
});
</script>
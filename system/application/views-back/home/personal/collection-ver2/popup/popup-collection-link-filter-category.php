<div class="modal modalFilter" id="modalFilter">
  <div class="modal-dialog modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <ul class="show-more-detail">
          <li>
            <a href="javascript:void(0)">Tất cả</a>
          </li>
          <?php foreach ($link_categories_p as $key => $cate) { ?>
          <li>
            <a href="javascript:void(0)"><?=$cate['name']?></a>
          </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
</div>
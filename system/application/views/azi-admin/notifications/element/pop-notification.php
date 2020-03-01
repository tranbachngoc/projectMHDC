<!-- The modal setting push notification -->
<div class="modal" id="settingInformation" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
	    <!-- Modal Header -->
	    <div class="modal-header">
	      <h4 class="modal-title">Cài đặt thông báo cho bài viết</h4>
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	    </div>
	    <!-- Modal body -->
	    <div class="modal-body">
	      <div class="administrator-settingpost">
	        <div class="row">
	          <div class="col-lg-12">
	            <div class="settingpost-adddetails">
	              <p class="text-bold mb10">Thông báo ngay bây giờ</p>
	              <input type="hidden" name="id" id="js-action-send">
	              <form id="js-send-one-notification">
		              <div class="enter-notice">
		                <textarea name="content" placeholder="Nhập nội dung thông báo" class="form-control enter-notice-area"></textarea>
		                <a class="btn-send js-send-one">Gửi thông báo</a>
		              </div>
	              </form>
	              <div class="calender-notice">
	              	<p class="text-bold mb10 mt20">Lên lịch thông báo: </p>
	              	<form id="js-send-mutip-notification">
		                <div class="btn-calender-notice">
		                	<button type="button" class="cursor-pointer add-date-notice js-add-date-notice">
		                		<img src="/templates/home/styles/images/svg/add_circle_black02.svg" alt="">Thêm ngày thông báo
		                	</button>
		                </div>
		                <div class="js-list-date-notice"></div>
		            </form>
	              </div>
	            </div>
	          </div>
	        </div>
	      </div>  
	    </div>   
	    <div class="modal-footer">
	      <div class="shareModal-footer">
	        <div class="permision"></div>
	        <div class="buttons-direct">
	          <button type="button" class="btn-cancle" data-dismiss="modal">Hủy</button>
	          <button type="button" class="btn-share js-send-mutip">Lưu</button>
	        </div>
	      </div>
	    </div>
	    <!-- End modal-footer -->       
	  </div>
	</div>
</div>
<!-- End The Modal -->

<script id="js-template-push-noti" type="text/template">
	<div class="add-date-notice-detail">
	  <div class="add-date">
	    <div class="add-date-select">
	      <p class="txt">Thông báo vào ngày:</p>
	      <input type="text" name="schedules[{{KEY}}][pushed_at]" class="js-date enterdate form-control datetimepicker" placeholder="Chọn ngày">
	    </div>
	    <div class="add-date-action">
	      <button type="button" data-key="{{KEY}}" class="btn-cancle cursor-pointer js-delete-notice">Xóa</button>
	    </div>
	  </div>
	  <div class="input-content">
	    <textarea name="schedules[{{KEY}}][content]" placeholder="Nhập nội dung thông báo" class="form-control enter-notice-area js-content"></textarea>
	  </div>
	</div>
</script>



<!-- The modal show list push notification -->
<div class="modal" id="displayInformation" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-sm slideInUp-animated">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Hiển thị thông báo</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <ul class="displayInformation-show">
          
        </ul>            
      </div>   
      <!--<div class="modal-footer">
        <div class="shareModal-footer">
          <div class="permision"></div>
          <div class="buttons-direct">
            <button class="btn-cancle">Hủy</button>
            <button class="btn-share">Lưu</button>
          </div>
        </div>
      </div> -->
      <!-- End modal-footer -->       
    </div>
  </div>
</div>
<!-- End The Modal -->
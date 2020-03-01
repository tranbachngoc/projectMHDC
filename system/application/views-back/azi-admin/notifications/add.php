<!-- The modal setting push notification -->
<div class="container">
	<div class="administrator-settingpost">
		<h2 class="title-admin"><i class="fa fa-angle-left f20 mr10" aria-hidden="true"></i>Cài đặt thông báo</h2>
		<div class="row">
			<div class="col-md-8">
				<div class="settingpost-infor">
				    <div class="settingpost-adddetails">
					    <p class="text-bold mb10">Thông báo ngay bây giờ</p>
					    <input type="hidden" id="js-action-send" name="" value="<?php echo base_url() . 'azi-admin/notifications/push'?>">
					    <form id="js-send-one-notification">
						    <div class="enter-notice">
						      <textarea name="link" placeholder="Link thông báo" class="form-control enter-notice-area"></textarea>
							</div>
							<div class="enter-notice">
						      <textarea name="content" placeholder="Nhập nội dung thông báo" class="form-control enter-notice-area"></textarea>
						      <a class="btn-send js-send-one">Gửi thông báo</a>
						    </div>
					    </form>
					    <div class="calender-notice">
							<div class="btn-calender-notice">Lên lịch thông báo:
					      		<button type="button" class="cursor-pointer add-date-notice js-add-date-notice-azi ml10">
					      			<img src="/templates/home/styles/images/svg/add_circle_black02.svg" alt=""> Thêm ngày thông báo
					      		</button>
							</div>
						<form id="js-send-mutip-notification-azi">
					      	<div class="js-list-date-notice"></div>
					      	<div class="add-date-action-azi hidden" style="float: right">
						    	<button type="button" class="btn-share btn-save btn-pink js-send-mutip-azi">Lưu</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script id="js-template-push-noti" type="text/template">
	<div class="add-date-notice-detail">
	  <div class="add-date">
	    <div class="add-date-select">
	      <p class="txt">Thông báo vào ngày:</p>
	      <input type="text" name="schedules[{{KEY}}][pushed_at]" class="js-date enterdate form-control datetimepicker" placeholder="Chọn ngày">
	    </div>
	    <div class="add-date-action">
	      <button type="button" data-key="{{KEY}}" class="btn-cancle cursor-pointer js-delete-notice-azi">Xóa</button>
	    <!-- <button type="button" class="btn-share js-send-mutip">Lưu</button> -->
	    </div>
	  </div>
	  <div class="input-content mb10">
	    <textarea name="schedules[{{KEY}}][link]" placeholder="Nhập liên kết thông báo" class="form-control enter-notice-area js-link"></textarea>
	  </div>
	  <div class="input-content">
	    <textarea name="schedules[{{KEY}}][content]" placeholder="Nhập nội dung thông báo" class="form-control enter-notice-area js-content"></textarea>
	  </div>
	</div>
</script>
<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
	<div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header" style="margin-top:10px">Sửa thông tin nhân viên hành chính</h4>
	    <?php if ($updatesuccess == 1) { ?>
    	    <div class="alert alert-success" role="alert">
    		<strong>Chúc mừng!</strong> Bạn đã cập nhật nhân viên thành công. Nhấp <a href="/account/listsubadmin">vào đây</a> để trở về danh sách nhân viên hành chính.
    	    </div>
	    <?php } else { ?>
    	    <form action="" method="POST" class="form-horizontal">    		
    		
    			<div class="form-group">
    			    <div class="col-md-3 control-label" for="fullname">Họ và Tên</div>
    			    <div class="col-md-6">
    				<input type="text" class="form-control" name="use_fullname" value="<?php echo $supadmin->use_fullname ?>">
				    <?php echo form_error('use_fullname'); ?>
    			    </div>
    			</div>
    			<div class="form-group">
    			    <div class="col-md-3 control-label" for="email">Email</div>
    			    <div class="col-md-6">
				<input type="email" class="form-control" name="use_email" value="<?php echo $supadmin->use_email ?>" disabled>
				    <?php echo form_error('use_email'); ?>
    			    </div>
    			</div>
    			<div class="form-group">
    			    <div class="col-md-3 control-label" for="username">Tài khoản</div>
    			    <div class="col-md-6">
    				<input type="text" class="form-control" name="username_regis" value="<?php echo $supadmin->use_username ?>" disabled>
				    <?php echo form_error('username_regis'); ?>
    			    </div>
    			</div>  
			<div class="form-group">
    			    <div class="col-md-3 control-label" for="password">Mật khẩu</div>
    			    <div class="col-md-6">
    				<input type="password" class="form-control" name="use_password" value="nopassvalue" disabled>
				    <?php echo form_error('use_password'); ?>
    			    </div>
    			</div>
    			<div class="form-group">
    			    <div class="col-md-3 control-label" for="use_mobile">Điện thoại</div>
    			    <div class="col-md-6">
    				<input type="tel" class="form-control" name="use_mobile" value="<?php echo $supadmin->use_mobile ?>" disabled>
				    <?php echo form_error('use_mobile'); ?>
    			    </div>
    			</div>
    		 
    			<div class="form-group">
    			    <div class="col-md-3 control-label" for="use_province">Tỉnh/Thành</div>
    			    <div class="col-md-6">
    				<select name="use_province" id="use_province" class="form-control">
    				    <option value="">Chọn Tỉnh/Thành</option>
					<?php foreach ($province as $value) { ?>
					    <option value="<?php echo $value->pre_id ?>" 
						    <?php if ($value->pre_id == $supadmin->use_province) echo 'selected="selected"'; ?>> 
							<?php echo $value->pre_name ?>
					    </option>
					<?php } ?>
    				</select>
				    <?php echo form_error('use_province'); ?>
    			    </div>
    			</div>
    			<div class="form-group">
    			    <div class="col-md-3 control-label" for="use_district">Quận/Huyện</div>
    			    <div class="col-md-6">
    				<select name="use_district" id="use_district" class="form-control">
    				    <option value="">Chọn Quận/Huyện</option>
					<?php
					foreach ($district as $vals):
					    if ($vals->DistrictCode == $supadmin->user_district) {
						$district_selected = "selected='selected'";
					    } else {
						$district_selected = '';
					    }
					    echo '<option value="' . $vals->DistrictCode . '" ' . $district_selected . '>' . $vals->DistrictName . '</option>';
					endforeach;
					?>
    				</select> 
				    <?php echo form_error('use_district'); ?>
    			    </div>
    			</div>
    			<div class="form-group">
    			    <div class="col-md-3 control-label" for="use_address">Địa chỉ</div>
    			    <div class="col-md-6">
    				<input type="text" class="form-control" name="use_address" value="<?php echo $supadmin->use_address ?>">
				    <?php echo form_error('use_address'); ?>
    			    </div>
    			</div>
    			<div class="form-group">
    			    <div class="col-md-3 control-label" for="use_birthday">Ngày sinh</div>
    			    <div class="col-md-6">
    				<input type="date" class="form-control" name="use_birthday" value="<?php echo date("Y-m-d", $supadmin->use_birthday) ?>">
				    <?php echo form_error('use_birthday'); ?>
    			    </div>
    			</div>
    			<div class="form-group">
    			    <div class="col-md-3 control-label" for="use_sex">Giới tính</div>
    			    <div class="col-md-6">
    				<select class="form-control" name="use_sex">
    				    <option value="1" <?php echo ($supadmin->use_sex == 1) ? "selected": "" ?>>Nam</option>
    				    <option value="0" <?php echo ($supadmin->use_sex == 0) ? "selected": "" ?>>Nữ</option>
    				</select>
    			    </div>
    			</div>    		
    		
    		<div class="row">
    		    <div class="col-md-6 col-md-offset-3">
    			<button type="submit" class="btn btn-azibai">Cập nhật</button>
    			<a href="/account/listsubadmin" class="btn btn-default">Hủy bỏ</a>
    			<input type="hidden" class="form-control" name="updatesubadmin" value="1">
    		    </div>
    		</div>
    	    </form> 
	    <?php } ?>
	</div>
    </div>
</div>
<script type="text/javascript">
    $("#use_province").change(function () {
	if ($("#use_province").val()) {
	    $.ajax({
		url: '<?php echo base_url() ?>home/showcart/getDistrict',
		type: "POST",
		data: {user_province_put: $("#use_province").val()},
		cache: true,
		beforeSend: function () {
		    document.getElementById("use_province").disabled = true;
		},
		success: function (response) {
		    document.getElementById("use_province").disabled = false;
		    if (response) {
			var json = JSON.parse(response);
			emptySelectBoxById('use_district', json);
			delete json;
		    } else {
			alert("Lỗi! Vui lòng thử lại");
		    }
		},
		error: function () {
		    alert("Không thành công! Vui lòng thử lại");
		}
	    });
	}
    });
</script>
<?php $this->load->view('home/common/footer'); ?>


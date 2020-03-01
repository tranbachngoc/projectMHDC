<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
	<div class="col-md-9 col-sm-8 col-xs-12">
	    <h2 class="page-header" style="margin-top:0">Thêm nhân viên hành chính</h2>
	    <?php if ($insertsuccess == 1) { ?>
    	    <div class="alert alert-success" role="alert">
    		<strong>Chúc mừng!</strong> Bạn đã thêm nhân viên thành công. Nhấp vào <a href="/account/addsubadmin" class="btn btn-default">nút</a> để tiếp tục thêm nhân viên.
    	    </div>
	    <?php } else { ?>
    	    <form action="" method="POST" class="form-horizontal">
    		<div class="row">
    		    <div class="col-md-6">
    			<div class="form-group">
    			    <label class="col-md-4" for="fullname">Họ và Tên</label>
    			    <div class="col-md-7">
    				<input type="text" class="form-control" name="use_fullname" value="<?php echo $datapost['use_fullname'] ?>">
				    <?php echo form_error('use_fullname'); ?>
    			    </div>
    			</div>
    			<div class="form-group">
    			    <label class="col-md-4" for="email">Email</label>
    			    <div class="col-md-7">
    				<input type="email" class="form-control" name="use_email" value="<?php echo $datapost['use_email'] ?>">
				    <?php echo form_error('use_email'); ?>
    			    </div>
    			</div>
    			<div class="form-group">
    			    <label class="col-md-4" for="username">Tài khoản</label>
    			    <div class="col-md-7">
    				<input type="text" class="form-control" name="username_regis" value="<?php echo $datapost['use_username'] ?>">
				    <?php echo form_error('username_regis'); ?>
    			    </div>
    			</div>
    			<div class="form-group">
    			    <label class="col-md-4" for="password">Mật khẩu</label>
    			    <div class="col-md-7">
    				<input type="password" class="form-control" name="use_password" value="<?php echo $datapost['use_password'] ?>">
				    <?php echo form_error('use_password'); ?>
    			    </div>
    			</div>
    			<div class="form-group">
    			    <label class="col-md-4" for="use_mobile">Điện thoại</label>
    			    <div class="col-md-7">
    				<input type="tel" class="form-control" name="use_mobile" value="<?php echo $datapost['use_mobile'] ?>">
				    <?php echo form_error('use_mobile'); ?>
    			    </div>
    			</div>
    		    </div>
    		    <div class="col-md-6">
    			<div class="form-group">
    			    <label class="col-md-4" for="use_province">Tỉnh/Thành</label>
    			    <div class="col-md-7">
    				<select name="use_province" id="use_province" class="form-control">
    				    <option value="">Chọn Tỉnh/Thành</option>
					<?php foreach ($province as $value) { ?>
					    <option value="<?php echo $value->pre_id ?>" 
						    <?php if ($value->pre_id == $shopedit->fl_province) echo 'selected="selected"'; ?>> 
							<?php echo $value->pre_name ?>
					    </option>
					<?php } ?>
    				</select>
				    <?php echo form_error('use_province'); ?>
    			    </div>
    			</div>
    			<div class="form-group">
    			    <label class="col-md-4" for="use_district">Quận/Huyện</label>
    			    <div class="col-md-7">
    				<select name="use_district" id="use_district" class="form-control">
    				    <option value="">Chọn Quận/Huyện</option>
					<?php
					foreach ($district as $vals):
					    if ($vals->DistrictCode == $shopedit->fl_district) {
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
    			    <label class="col-md-4" for="use_address">Địa chỉ</label>
    			    <div class="col-md-7">
    				<input type="text" class="form-control" name="use_address" value="<?php echo $datapost['use_address'] ?>">
				    <?php echo form_error('use_address'); ?>
    			    </div>
    			</div>
    			<div class="form-group">
    			    <label class="col-md-4" for="use_birthday">Ngày sinh</label>
    			    <div class="col-md-7">
    				<input type="date" class="form-control" name="use_birthday" value="<?php echo $datapost['use_birthday'] ?>">
				    <?php echo form_error('use_birthday'); ?>
    			    </div>
    			</div>
    			<div class="form-group">
    			    <label class="col-md-4" for="use_sex">Giới tính</label>
    			    <div class="col-md-7">
    				<select class="form-control" name="use_sex">
    				    <option value="1">Nam</option>
    				    <option value="0">Nữ</option>
    				</select>
    			    </div>
    			</div>
    		    </div>
    		</div>
    		<div class="row">
    		    <div class="col-md-12 text-center">
    			<button type="submit" class="btn btn-azibai">Thêm nhân viên</button>
    			<input type="hidden" class="form-control" name="addsubadmin" value="1">
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


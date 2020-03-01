<?php $this->load->view('group/common/header'); ?>
<br>
<div id="main" class="container-fluid">
    <div class="row">          
        <div class="col-md-3 sidebar">
            <?php $this->load->view('group/common/menu'); ?>
        </div>   
        <div class="col-md-9 main">  
	    <h4 class="page-header text-uppercase" style="margin-top:10px">Cập nhật thông tin kho hàng</h4>
            <div class="dashboard">
                <!-- ========================== Begin Content ============================ -->
                    <div class="group-news">
                    
                    <form class="form-horizontal" name="frmUpdateGroupStore" id="frmUpdateGroupStore" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="grt_province_store" class="col-sm-3 control-label">Tỉnh/Thành<font color="#FF0000"><b>*</b></font> :</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="grt_province_store" id="grt_province_store">
                                    <option value="">Chọn Quận/Huyện</option>
                                        <?php foreach ($province as $provinceArray) { ?>
                                            <?php if (isset($grt_province_store) && $grt_province_store == $provinceArray->pre_id) { ?>
                                                <option
                                                    value="<?php echo $provinceArray->pre_id; ?>"
                                                    selected="selected"><?php echo $provinceArray->pre_name; ?></option>
                                            <?php } else { ?>
                                                <option
                                                    value="<?php echo $provinceArray->pre_id; ?>"><?php echo $provinceArray->pre_name; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grt_district_store" class="col-sm-3 control-label">Quận/Huyện<font color="#FF0000"><b>*</b></font> :</label>
                            <div class="col-sm-9">
                                <select class="form-control" name="grt_district_store" id="grt_district_store">
                                    <option value="">Chọn Quận/Huyện</option>
                                        <?php  foreach ($district as $provinceArray) {?>
                                            <option value="<?php echo $provinceArray->DistrictCode; ?>"
                                                <?php if (isset($grt_district_store) && $grt_district_store == $provinceArray->DistrictCode) { ?>
                                                    selected="selected" <?php } ?>><?php echo $provinceArray->DistrictName; ?></option>
                                        <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grt_address_store" class="col-sm-3 control-label">Địa chỉ kho<font color="#FF0000"><b>*</b></font> :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="grt_address_store" id="grt_address_store" placeholder="Nhập địa chỉ kho" value="<?php if($grt_address_store && $grt_address_store!=''){echo $grt_address_store;} ?>">
                            </div>
                        </div>                       
                        
                        <div class="form-group">
                            <label for="grt_captcha" class="col-sm-3 control-label">Mã bảo vệ<font color="#FF0000"><b>*</b></font> :</label>
                            <div class="col-sm-3">
                                <img src="<?php echo $imageCaptchaGrtStore; ?>" height="31"/>
                            </div>
                            <div class="col-sm-6">
                                <input  style="text-indent: 5px; padding: 5px 0" onkeypress="return submitenter(this, event)" type="text" name="grt_captcha" id="captcha_groupStore" maxlength="10" class="form-control"/>
                                <span style="color: #f00;"><?php echo $error_captcha ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6 col-sm-3 col-sm-offset-3">
                                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="check_StoreGroup();">Cập nhật</button>
                            </div>
                            <div class="col-xs-6 col-sm-3">
                                <button type="reset" class="btn btn-default btn-lg btn-block">Hủy bỏ</button>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- ========================== End Content ============================ -->
            </div>
        </div> 
    </div>
</div>
<script type="text/javascript">
    $("#grt_province_store").change(function () {
        if ($("#grt_province_store").val()) {
            $.ajax({
                url: '<?php echo getAliasDomain()?>home/showcart/getDistrict',
                type: "POST",
                data: {user_province_put: $("#grt_province_store").val()},
                cache: true,
                beforeSend: function () {
                    document.getElementById("grt_province_store").disabled = true;
                },
                success: function (response) {
                    document.getElementById("grt_province_store").disabled = false;
                    if (response) {
                        var json = JSON.parse(response);
                        emptySelectBoxById('grt_district_store', json);
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
<?php $this->load->view('group/common/footer'); ?>
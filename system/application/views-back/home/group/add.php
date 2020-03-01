<?php $this->load->view('home/common/account/header'); ?>

<div class="container-fluid">
    <div class="row rowmain">
        <?php $this->load->view('home/common/left'); ?>
        <script language="javascript" src="<?php echo base_url(); ?>templates/group/js/general.js"></script>
        <script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>

        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">Tạo group thương mại</h4>
            <form name="frmAddGrt" id="frmAddGrt" method="post" enctype="multipart/form-data" class="form-horizontal">
            <?php if ($shopid > 0) { ?>
                <?php if ($successAddGrt == false) { ?>
                <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">
                    <div class="form-group">
                        <label for="grt_name" class="lb_chonnhom col-sm-3 control-label">Chọn nhóm</label>                       
                        <div class="cnhom col-sm-9">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="grt_type" id="mienphi" value="1" checked="">
                                    Nhóm miễn phí 
                                </label>                            
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="grt_type" id="nhom" value="2">
                                    Nhóm trả phí 
                                </label>                            
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="grt_type" id="kenh" value="3">
                                    Nhóm thuê kênh 
                                </label>                            
                            </div>
                            <div class="radio">
                               <label>
                                    <input type="radio"  name="grt_type" id="cahai" value="4">
                                    Nhóm trả phí và thuê kênh 
                                </label>                            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-sm-12 col-xs-12 col-md-offset-2">

                    <div class="form-group">
                        <label for="grt_name" class="col-sm-3 control-label">Tên nhóm</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="grt_name" id="grt_name"  value="<?php if (isset($grt_name)) {echo $grt_name;} ?>" placeholder="Tên nhóm"/>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="grt_email" class="col-sm-3 control-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="grt_email" id="grt_email" value="<?php if (isset($grt_email)) {echo $grt_email;} ?>" placeholder="emailgroup@domain.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="grt_phone" class="col-sm-3 control-label">Số điện thoại</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="grt_phone" id="grt_phone" value="<?php if (isset($grt_phone)) {echo $grt_phone;} ?>" placeholder="0919575925">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="grt-province" class="col-sm-3 control-label">Tỉnh/Thành</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="grt_province" id="grt_province">
                                <option value="">Chọn Tỉnh/Thành</option>
                                <?php foreach ($province as $vals): ?>
                                    <?php if (($this->input->post('province_regis') == $vals->pre_id) || ($grt_province == $vals->pre_id) || ($users->use_province == $vals->pre_id)): ?>
                                        <?php $selected = 'selected="selected"'; ?>
                                    <?php else: ?>
                                        <?php $selected = ''; ?>
                                    <?php endif; ?>
                                    <option value="<?php echo $vals->pre_id; ?>" <?php echo $selected; ?>><?php echo $vals->pre_name; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="grt_district" class="col-sm-3 control-label">Quận/Huyện</label>
                        <div class="col-sm-9">
                            <select class="form-control" name="grt_district" id="grt_district">
                                <option value="">Chọn Quận/Huyện</option>
                                <?php if (isset($district_list)): ?>
                                    <?php foreach ($district_list as $vals): ?>
                                        <?php if (($this->input->post('district_regis') == $vals['DistrictCode']) || ($grt_district == $vals['DistrictCode'])): ?>
                                            <?php $selected = 'selected="selected"'; ?>
                                        <?php else: ?>
                                            <?php $selected = ''; ?>
                                        <?php endif; ?>
                                        <option value="<?php echo $vals['DistrictCode']; ?>" <?php echo $selected; ?>><?php echo $vals['DistrictName']; ?></option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option <?php if ((isset($district_regis) && $district_regis == $district[0]->DistrictCode) || ($grt_district == $district[0]->DistrictCode)) {
                                        echo 'selected = "selected"';
                                    } ?>value="<?php echo $district[0]->DistrictCode; ?>"><?php echo $district[0]->DistrictName; ?></option>
                                <?php endif; ?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="grt_address" class="col-sm-3 control-label">Địa chỉ</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="grt_address" id="grt_address" value="<?php if (isset($grt_address)) {echo $grt_address;} ?>" placeholder="Số nhà, tên đường, phường/xã">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="grt_bank" class="col-sm-3 control-label">Ngân hàng</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="grt_bank" id="grt_bank"  value="<?php if (isset($grt_bank)) {echo $grt_bank;} ?>" placeholder="Tên ngân hàng">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="grt_bank_number" class="col-sm-3 control-label">Số tài khoản</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="grt_bank_num" id="grt_bank_number" value="<?php if (isset($grt_bank_num)) {echo $grt_bank_num;} ?>" placeholder="Số tài khoản">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="grt_bank_addr" class="col-sm-3 control-label">Chi nhánh</label>
                        <div class="col-sm-9">
                            <input type="text" name="grt_bank_addr" class="form-control" id="grt_bank_addr"  value="<?php if (isset($grt_bank_addr)) {echo $grt_bank_addr;} ?>" placeholder="Chi nhánh ngân hàng" />
                        </div>
                    </div>

                    <div class="form-group">
                        <?php if (isset($captchaAddGrt)) { ?>
                            <label for="grt_captcha" class="col-sm-3 control-label">Captcha</label>
                            <div class="col-sm-4">
                                <img src="<?php echo $captchaAddGrt; ?>" height="31" style=""/>
                            </div>
                            <div class="col-sm-5">
                                <input style="text-indent: 5px; padding: 5px 0" onkeypress="return submitenter(this,event)" type="text" name="grt_captcha" id="captcha_regis" value="" maxlength="10" class="form-control"/>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="button" class="btn btn-azibai" onclick="Check_RegisterGroup();">Tạo nhóm</button>
                            <button type="reset" class="btn btn-default">Hủy bỏ</button>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(document).ready(function(){
                        $('#inforGrtModal').modal('show');
                    });
                </script>
                <?php } else { ?>
                   <div class="text-center">
                       <p>Chúc mừng bạn! Bạn đã tạo Group thương mại thành công! Hãy đăng nhập lại để vào giao diện quản trị group của bạn.</p>
                       <a href="<?php echo base_url().'account'; ?>">Bấm vào đây để quay lại</a><br>
                       <a href="<?php echo base_url().'logout'; ?>">Hoặc bấm vào đây để thoát</a>
                   </div>
                <?php } ?>
            <?php } else { ?>
                <div class="noshop text-center"><?php echo $this->lang->line('noshop'); ?>
                    <a href="<?php echo base_url(); ?>account/shop">tại đây</a></div>
            <?php } ?>
            </form>
        </div>
    </div>
</div>
<!--END RIGHT-->
<!-- Begin:: Modal thông báo dịch vụ -->
 <div class="modal fade" id="inforGrtModal" tabindex="-1" role="dialog" aria-labelledby="inforGrtModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title" id="inforGrtModalLabel">Điều khoản & điều kiện mở Group Thương Mại</h3>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
        <p>Đang cập nhật...</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="checkpackshopusing();">Đồng ý</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="returnBack();">Đóng</button>
      </div>
    </div>
  </div>
</div>
<!-- End:: Modal thông báo dịch vụ -->


<?php $this->load->view('home/common/footer'); ?>
<script>
    $("#grt_province").change(function () {
        if ($("#grt_province").val()) {
            $.ajax({
                url: '<?php echo base_url()?>home/showcart/getDistrict',
                type: "POST",
                data: {user_province_put: $("#grt_province").val()},
                cache: true,
                beforeSend: function () {
                    document.getElementById("grt_province").disabled = true;
                },
                success: function (response) {
                    document.getElementById("grt_province").disabled = false;
                    if (response) {
                        var json = JSON.parse(response);
                        emptySelectBoxById('grt_district', json);
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

    function emptySelectBoxById(eid, value) {
        if (value) {
            var text = "";
            $.each(value, function (k, v) {
                if (k != "") {
                    text += "<option value='" + k + "'>" + v + "</option>";
                }
            });
            document.getElementById(eid).innerHTML = text;
            delete text;
        }
    }

    function returnBack(){
        window.location = '/account';
    }
    // Shop used pack bussiness or professional
    function checkpackshopusing(){
        $.ajax({
            url: '/home/grouptrade/checkpackshopusing',
            type: "POST",
            data: {},
            cache: false,
            success: function (res) {
                if (res != '1') {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Gói dịch vụ của bạn không đủ tiêu chuẩn! Vui lòng nâng cấp DV trước!',
                        'theme': 'default',
                        'btns': {
                            'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                e.preventDefault();
                                returnBack();
                            }
                        }
                    });
                } else {
                    $('#inforGrtModal').modal('hide');
                }
            },
            error: function () {
                alert("Không thành công! Vui lòng thử lại");
            }
        });
    }
</script>

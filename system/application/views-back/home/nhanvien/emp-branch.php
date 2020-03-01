<?php $this->load->view('home/common/account/header'); ?>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/jScrollPane.css"/>
<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>templates/home/css/simplemodal.css" media='screen'/>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/simplemodal.js"></script>

<?php
$group_id = $this->session->userdata('sessionGroup');
?>
<!--BEGIN: LEFT-->
<div id="main" class="container-fluid">
    <div class="row">        
        <!--BEGIN: Left menu-->
        <?php if($this->session->userdata('sessionUser') > 0 && $this->session->userdata('sessionGroup') == StaffStoreUser) {
            $this->load->view('home/common/left');
        } ?>
        <!--END-->
        <div class="col-xs-12 col-lg-9"> 
            <?php if ($successRegister == false) { ?>
                <form name="frmRegister" id="frmRegister" method="post" enctype="multipart/form-data" style="margin-top: 20px;" action="<?=base_url() . 'account/staffs/add'?>">
                    <div class="tile_Register row">
                        <h3>Đăng ký Chi Nhánh</h3>
                        <hr>
                    </div>
                    <!-- Begin Show error if have -->
                    <!-- End Show error if have -->
                    <div class="row wrap_regis">
                        <div id="box_regis_1" class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
                            <input id="style_id" name="style_id" value="" type="hidden">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" value="" name="fullname_regis" id="fullname_regis" placeholder="Họ tên hoặc Tên công ty viết tắt" maxlength="80" class="form-control" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmRegister','fullname_regis');" onfocus="ChangeStyle('fullname_regis',1)" onblur="ChangeStyle('fullname_regis',2)" style="border: 1px solid rgb(204, 204, 204);">
                                </div>
                                <?php echo form_error('fullname_regis'); ?>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input type="text" value="" name="mobile_regis" id="mobile_regis" maxlength="20" class="form-control" placeholder="Điện thoại (dùng làm tài khoản login)" onblur="checkUserMobile(this.value, '<?php echo base_url(); ?>','staffs')">
                                </div>
                                <?php echo form_error('mobile_regis'); ?>
                            </div>
                            <!-- ltngan -->
                            <div id="register" class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    <i class="fa fa-unlock-alt fa-fw"></i>
                                    </span>
                                    <input type="password" value="" name="password_regis" id="password_regis" placeholder="Mật khẩu" class="form-control">
                                </div>
                                <?php echo form_error('password_regis'); ?>
                                <span id="result"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-unlock-alt fa-fw"></i></span>
                                    <input type="password" value="" name="repassword_regis" id="repassword_regis" class="form-control" placeholder="Nhập lại mật khẩu" onfocus="ChangeStyle('repassword_regis',1)" onblur="ChangeStyle('repassword_regis',2)">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope fa-fw"></i></span>
                                    <input type="text" value="" name="email_regis" id="email_regis" placeholder="Email" class="form-control" onkeyup="BlockChar(this,'SpecialChar')" onblur="checkEmailexit(this.value, '<?php echo base_url(); ?>')">
                                </div>
                                <?php echo form_error('email_regis'); ?>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    <i class="fa fa-credit-card fa-fw"></i>
                                    </span>
                                    <input type="text" value="" name="idcard_regis" id="idcard_regis" maxlength="20" placeholder="Số chứng minh nhân dân" onblur="checkUserIdcard_reg(this.value, '<?php echo base_url(); ?>', 'staffs')" class="form-control">
                                </div>
                                <?php echo form_error('idcard_regis'); ?>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-shield fa-rotate-270"></i></span>

                                    <select name="province_regis" id="user_province_get" class="form-control">
                                    <option value="">Chọn Tỉnh/Thành</option>
                                    <?php foreach ($province as $vals): ?>
                                        <?php if (($this->input->post('province_regis') == $vals->pre_id) || ($users->use_province == $vals->pre_id)): ?>
                                        <?php $selected = 'selected="selected"'; ?>
                                        <?php else: ?>
                                        <?php $selected = ''; ?>
                                        <?php endif; ?>
                                        <option
                                        value="<?php echo $vals->pre_id; ?>" <?php echo $selected; ?>><?php echo $vals->pre_name; ?></option>
                                    <?php endforeach; ?>
                                    </select>
                                </div>
                                <?php echo form_error('province_regis'); ?>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-shield fa-rotate-270"></i></span>
                                    <select name="district_regis" id="user_district_get" class="form-control">
                                    <option value="">Chọn Quận/Huyện</option>
                                    <?php if (isset($district_list)): ?>
                                        <?php foreach ($district_list as $vals): ?>
                                        <?php if ($this->input->post('district_regis') == $vals['DistrictCode']): ?>
                                            <?php $selected = 'selected="selected"'; ?>
                                        <?php else: ?>
                                            <?php $selected = ''; ?>
                                        <?php endif; ?>
                                        <option value="<?php echo $vals['DistrictCode']; ?>" <?php echo $selected; ?>><?php echo $vals['DistrictName']; ?></option>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                        <option
                                        <?php if (isset($district_regis) && $district_regis == $district[0]->DistrictCode) {
                                            echo 'selected = "selected"';
                                        } ?>value="<?php echo $district[0]->DistrictCode; ?>"><?php echo $district[0]->DistrictName; ?></option>
                                    <?php endif; ?>
                                    </select>
                                </div>
                                <?php echo form_error('district_regis'); ?>
                            </div>
                            <div class="form-group">
                                <label><input type="checkbox" name="taxtype_regis" id="tax_code_personal" class="tax_type" value="0" checked="checked">&nbsp;Mã số thuế cá nhân</label>&nbsp;&nbsp;&nbsp;
                                <label><input type="checkbox" name="taxtype_regis" id="tax_code_company" class="tax_type" value="1">&nbsp;Mã số thuế doanh nghiệp</label>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    <i class="fa fa-database"></i>
                                    </span>	
                                    <input type="text" value="" name="taxcode_regis" id="taxcode_regis" onblur="checkUserTaxcode_reg(this.value, '<?php echo base_url(); ?>','addbranch')" placeholder="Mã số thuế" maxlength="20" class="form-control ">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    <i class="fa fa-comment"></i>
                                    </span>                                               
                                    <input type="text" value="" name="message_regis" id="messages_regis" placeholder="https://www.facebook.com/messages/t/726068167537746" maxlength="255" class="form-control ">
                                </div>
                            </div>
                        </div>
                        <!--END box_regis_1-->
                        <div class="col-sm-12 checkup" style="text-align: center">
                            <input type="button" onclick="CheckInput_Emp_Branch_Register();" id="confirmBtn" name="submit_register" value="&nbsp; Đăng ký &nbsp;" class="btn btn-azibai">
                            <input type="reset" name="reset_register" value="&nbsp; Làm lại &nbsp;" class="btn btn-default">
                        </div>
                    </div>
                    <!--END wrap_regis-->
                </form>
            <?php } else { ?>
                <div class="tile_Register row">
                    <h3>Đăng ký thành công</h3>
                    <hr>
                </div>
            <?php } ?>
        </div>
    </div>
</div>


<?php $this->load->view('home/common/footer'); ?>

<script type="text/javascript">
    $("#user_province_get").change(function () {
        if ($("#user_province_get").val()) {
            $.ajax({
                url: siteUrl + 'home/showcart/getDistrict',
                type: "POST",
                data: {user_province_put: $("#user_province_get").val()},
                cache: true,
                beforeSend: function () {
                    document.getElementById("user_province_get").disabled = true;
                },
                success: function (response) {
                    document.getElementById("user_province_get").disabled = false;
                    if (response) {
                        var json = JSON.parse(response);
                        emptySelectBoxById('user_district_get', json);
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
                //display the key and value pair
                if (k != "") {
                    text += "<option value='" + k + "'>" + v + "</option>";
                }
            });
            document.getElementById(eid).innerHTML = text;
            delete text;
        }
    }
    
    $("#checkDongY").change(function (){
        var checked = jQuery('#checkDongY').is(':checked');
        if (checked == true) {
            jQuery('#confirmBtn').show();
        }
        else {
            jQuery('#confirmBtn').hide();
        }
    });
</script>

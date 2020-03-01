<?php $this->load->view('home/common/account/header'); ?>
<style>
    .unit { margin-top: 5px; margin-left: 10px; float: left; }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
</style>
<div class="clearfix"></div>
<div id="product_content" class="container-fluid">
    <div class="row rowmain">

        <?php $this->load->view('home/common/left'); ?>
        <?php
        $display2 = 'block';
        $display3 = 'block';
        $disabled = '';
        if ($get_grt[0]->grt_type == 3) { $display2 = 'none'; }
        if ($get_grt[0]->grt_type == 2) { $display3 = 'none'; }
        if ($get_grt[0]->grt_type <= 1) { $disabled = 'disabled'; $readonly_ad = 'readonly'; $readonly_sh = 'readonly'; }
        ?>
        <div class="col-md-9 col-xs-12">
            <h2 class="page-title text-uppercase text-center">Cấu hình hoa hồng cho nhóm <span style="color: #f00"><?php echo $get_grt->grt_name ?></span></h2>

            <div class="note" style="color: #f00"><?php echo $notify?></div>
            <form class="form-horizontal" name="frmConfigcommiss" id="frmConfigcommiss" method="post">

                <div class="form-group" style="display:<?php echo $display2 ?>">
                    <label for="grt_bank" class="col-sm-3 control-label">Hoa hồng chủ nhóm<font
                            color="#FF0000"><b>*</b></font> :</label>
                    <div class="col-sm-9">
                        <input type="number" style="width: 50%;float: left;" class="form-control" name="cmss_for_grt" id="cmss_for_grt" placeholder="Nhập hoa hồng cho nhóm" <?php echo $readonly_ad ?> value="<?php echo $get_grt[0]->cmss_for_admin; //if ($cmss_for_grt && $cmss_for_grt != '') { } ?>">
                        <label for="" class="unit">(%) <em style="font-size: 12px; color: rgba(0, 0, 0, 0.76)">VD: 5%, 10%, 35%</em></label>
                    </div>
                </div>

                <div class="form-group" style="display:<?php echo $display3 ?>">
                    <label for="grt_bank_num" class="col-sm-3 control-label">Hoa hồng thuê kênh<font color="#FF0000"><b>*</b></font> :</label>
                    <div class="col-sm-9">
                        <input type="number" style="width: 50%;float: left;" class="form-control" name="cmss_for_sho" id="cmss_for_sho" placeholder="Nhập hoa hồng cho gian hàng" <?php echo $readonly_sh ?> value="<?php echo $get_grt[0]->cmss_for_shop; //if ($cmss_for_sho && $cmss_for_sho != '') { } ?>">
                        <label for="" class="unit">(%) <em style="font-size: 12px; color: rgba(0, 0, 0, 0.76)">VD: 5%, 10%, 35%</em></label>
                    </div>
                </div>

                <div class="form-group">
                    <label for="grt_captcha" class="col-sm-3 control-label">Mã bảo vệ<font
                            color="#FF0000"><b>*</b></font> :</label>
                    <div class="col-sm-3">
                        <img src="<?php echo $imageCaptchaConfig ?>" height="31" style=""/>
                    </div>
                    <div class="col-sm-6">
                        <input style="text-indent: 5px; width: 50%;padding: 5px 0" type="text" name="captchaConfig" id="captchaConfig" maxlength="10" class="form-control" <?php echo $disabled?>/>
                        <p style="color: #f00; padding: 10px; margin: 0;"><?php echo $error_captcha; ?></p>
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-xs-6 col-sm-3 col-sm-offset-3">
                        <button type="button" class="btn btn-primary btn-lg btn-block" onclick="check_ConfigGroup();" <?php echo $disabled?>>Cập nhật
                        </button>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <button type="reset" class="btn btn-default btn-lg btn-block" <?php echo $disabled?>>Hủy bỏ</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<script type="text/javascript"> 
    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }
    function check_ConfigGroup() {
        //Hoa hồng nhóm
        var cmss_for_grt = $("#cmss_for_grt").val();
        if (CheckBlank(cmss_for_grt)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Bạn chưa nhập hoa hồng nhóm!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("grt_bank").focus();
                        return false;
                    }
                }
            });
            return false;
        }
        if (!CheckBlank(cmss_for_grt)){
            if(isNumber(cmss_for_grt) == true){
                if (cmss_for_grt > 100 || cmss_for_grt < 0) {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Hoa hồng theo phần trăm phải nhỏ hơn 100% và lớn hơn 0%!',
                        'theme': 'default',
                        'btns': {
                            'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                e.preventDefault();
                                document.getElementById("cmss_for_grt").focus();
                                return false;
                            }
                        }
                    });
                    return false;
                }
            }
        }

        //Hoa hồng gian hàng
        var cmss_for_sho = $("#cmss_for_sho").val();
        if (CheckBlank(cmss_for_sho)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Bạn chưa nhập hoa hồng gian hàng!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("cmss_for_sho").focus();
                        return false;
                    }
                }
            });
            return false;
        }
        if (!CheckBlank(cmss_for_sho)) {
            if(isNumber(cmss_for_sho) == true){
                if (cmss_for_sho > 100 || cmss_for_sho < 0) {
                    $.jAlert({
                        'title': 'Thông báo',
                        'content': 'Hoa hồng theo phần trăm phải nhỏ hơn 100% và lớn hơn 0%!',
                        'theme': 'default',
                        'btns': {
                            'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                                e.preventDefault();
                                document.getElementById("cmss_for_sho").focus();
                                return false;
                            }
                        }
                    });
                    return false;
                }
            }
        }       

        if (CheckBlank(document.getElementById("captchaConfig").value)) {
            $.jAlert({
                'title': 'Thông báo',
                'content': 'Bạn chưa nhập mã bảo vệ!',
                'theme': 'default',
                'btns': {
                    'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                        e.preventDefault();
                        document.getElementById("captchaConfig").focus();
                        return false;
                    }
                }
            });
            return false;
        }
        document.frmConfigcommiss.submit();
    }
</script>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

<?php $this->load->view('home/common/header'); ?>
<script language="javascript" src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<!--BEGIN: LEFT-->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 hidden-md hidden-sm hidden-xs" style="background:#fff; position:fixed; top:0; bottom:0; z-index:100">
            <?php $this->load->view('home/common/left_tintuc'); ?>
        </div>
        <div class="col-lg-10 col-lg-offset-2 ">
            <div class="breadcrumbs hidden-xs">
                <a href="<?php echo base_url(); ?>">Trang chủ</a><i class="fa fa-angle-right"></i>
                <span><?php echo $this->lang->line('title_reset'); ?></span>
            </div>
            <div  class="container">
                <div class="row">
                    <div class="col-sm-5">
                        <div class="panel panel-default">
                            <div class="panel-heading"><h4 class="text-center">THÔNG TIN</h4></div>
                            <div class="panel-body">
                                <form name="frmChangePassword" id="frmChangePassword" method="post" class="form-horizontal" style=" border: solid 0px #ddd; ">
                                    <p class="text-center"> <?php if($successResetPassword == true && $pas == null ){  ?>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><font color="#FF0000"><b>*</b></font> Mật khẩu mới:</label>
                                    <div class="col-md-5">
                                        <input type="password" value="" name="forgot_password" id="password_changepass" maxlength="35" class="input_formpost form-control" required />
                                    </div>
                                    <div class="col-md-3">
                                        <?php echo form_error('password_changepass'); ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-4"><font color="#FF0000"><b>*</b></font> Nhập lại mật khẩu mới :</label>
                                    <div class="col-md-5">
                                        <input type="password" value="" name="reforgot_password" id="repassword_changepass" maxlength="35" class="input_formpost form-control" required />
                                    </div>
                                    <div class="col-md-3">
                                        <?php echo form_error('repassword_changepass'); ?>
                                    </div>
                                </div>
                                <div class="form-group" style="text-align: center">
                                    <input type="submit" class="btn btn-primary" value="Cập Nhật">
                                </div>
                                </form>
                                    <?php } elseif ( $pas != null)
                                    {
                                         echo $this->lang->line('success_reset');
                                         ?>
                                        <b><a class="text-primary" href="<?php echo base_url(); ?>">Click vào đây để tiếp tục</a></b>
                                        <?php
                                    }
                                    else
                                        { ?>
                                        <?php echo $this->lang->line('error_reset'); ?>
                                    <?php } ?><br/>
<!--                                    <b><a class="text-primary" href="--><?php //echo base_url(); ?><!--">Click vào đây để tiếp tục</a></b>-->
                                </p>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <?php
                        echo $this->load->view('home/common/info');
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
<script>
    $(document).ready(function(){
        $("#frmChangePassword").validate({
            errorElement: "span", // Định dạng cho thẻ HTML hiện thông báo lỗi
            rules: {
                reforgot_password: {
                    equalTo: "#password_changepass" // So sánh trường cpassword với trường có id là password
                }
            }
        });
    });
</script>

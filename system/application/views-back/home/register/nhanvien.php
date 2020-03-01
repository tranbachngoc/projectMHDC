<?php $this->load->view('home/common/account/header'); ?>
<script src="<?php echo base_url(); ?>templates/home/js/check_email.js"></script>
<?php
$url1 = $this->uri->segment(1);
$url2 = $this->uri->segment(2);
$url3 = $this->uri->segment(3);
$style = $_REQUEST['style'];
$group_id = (int)$this->session->userdata('sessionGroup');
?>
<style>
    .afstore {
        display: <?php if($url1 == 'register' && $url2 == '' ){ echo 'none'; }else{ echo 'block'; } ?>
    }

    .staff {
        display: <?php if(($url1 == 'account' && $url2 == 'staffs' && $url3 == 'add') || ($url1 == 'account' && $url2 == 'addbranch') || ($url1 == 'account' && $url2 == 'addstaffstore')){ echo 'none';}else{echo 'block';}?>
    }

    .staffon {
        display: <?php if(($url1 == 'account' && $url2 == 'staffs' && $url3 == 'add') || ($url1 == 'account' && $url2 == 'addbranch') || ($url1 == 'account' && $url2 == 'addstaffstore')){ echo 'block !important';}else{echo 'none';}?>
    }

    .none_member {
        display: <?php if(($url1 == 'register' && $url2 == '') || ($url1 == 'register' && $url2 == 'affiliate') || ($url1 == 'register' && $url2 == 'afstore') || ($url1 == 'register' && $url2 == 'estore') || ($url1 == 'account' && $url2 == 'staffs' && $url3 == 'add') || ($url1 == 'account' && $url2 == 'addbranch') || ($url1 == 'account' && $url2 == 'addstaffstore')){ echo 'none';}else{ echo 'block';} ?>
    }

    
</style>
<!--BEGIN: LEFT-->
<div id="main" class="container-fluid">
    <div class="row">        
        <!--BEGIN: Left menu-->
        <?php $this->load->view('home/common/left'); ?>        

        <!--END-->
        <div class="col-xs-12 col-lg-9"> 
            <h4 class="page-header text-uppercase" style="margin-top:10px">THÊM NHÂN VIÊN</h4>            
            <?php if ($successRegister == false) { ?>
                <form name="frmRegister" id="frmRegister" method="post" enctype="multipart/form-data" style="margin-top: 20px;" action="<?php echo base_url() . 'account/staffs/add'?>">
                     <!-- Begin Show error if have -->
                    <!-- End Show error if have -->
                    <div class="row wrap_regis">
                        <div id="box_regis_1" class="col-md-6 col-sm-12 col-xs-12 col-md-offset-3">
                            <input id="style_id" name="style_id" value="" type="hidden">
                            <div class="form-group buyer none_member staffon">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input type="text" value="" name="fullname_regis" id="fullname_regis" placeholder="Họ tên hoặc Tên công ty viết tắt" maxlength="80" class="form-control" onkeyup="BlockChar(this,'SpecialChar'); CapitalizeNames('frmRegister','fullname_regis');" onfocus="ChangeStyle('fullname_regis',1)" onblur="ChangeStyle('fullname_regis',2)" style="border: 1px solid rgb(204, 204, 204);">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                    <input type="text" value="" name="mobile_regis" id="mobile_regis" maxlength="20" class="form-control" placeholder="Điện thoại (dùng làm tài khoản login)" onblur="checkUserMobile(this.value, '<?php echo base_url(); ?>','staffs')">
                                </div>
                            </div>
                            <!-- ltngan -->
                            <div id="register" class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    <i class="fa fa-unlock-alt fa-fw"></i>
                                    </span>
                                    <input type="password" value="" name="password_regis" id="password_regis" placeholder="Mật khẩu" class="form-control">
                                </div>
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
                            </div>
                            <div class="form-group afstore" id="afstore_card">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                    <i class="fa fa-credit-card fa-fw"></i>
                                    </span>
                                    <input type="text" value="" name="idcard_regis" id="idcard_regis" maxlength="20" placeholder="Số chứng minh nhân dân" onblur="checkUserIdcard_reg(this.value, '<?php echo base_url(); ?>', 'staffs')" class="form-control">
                                </div>
                            </div>
                            <fieldset class="form-group roles">
                                <legend>Quyền hạn:</legend>
                                <?php foreach ($list_role as $key => $list_part): ?>
                                <div class="col-sm-6">
                                    <?php foreach ($list_part as $key => $value): ?>
                                    <input type="checkbox" name="role_regis[]" value="<?php echo $value->id;?>"><?php echo  $value->rol_name;?><br>
                                    <?php endforeach; ?>
                                </div>
                                <?php endforeach; ?>
                            </fieldset>
                        </div>
                        <!--END box_regis_1-->
                        <div class="col-sm-12 checkup" style="text-align: center">
                            <input type="button" onclick="CheckInput_Emp_Register();" name="submit_register" value="&nbsp; Đăng ký &nbsp;" class="btn btn-azibai">
                            <input type="reset" name="reset_register" value="&nbsp; Làm lại &nbsp;" class="btn btn-default">
                        </div>
                    </div>
                    <!--END wrap_regis-->
                </form>
            <?php } else { ?>
                <div class="tile_Register row">
                    <h3>Đăng ký nhân viên thành công</h3>
                    <hr>
                </div>
            <?php } ?>
        </div>
    </div>
</div>


<?php $this->load->view('home/common/footer'); ?>

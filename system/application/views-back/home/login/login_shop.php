<?php $this->load->view('home/common/login/header'); ?>
<!--BEGIN: LEFT-->
<SCRIPT TYPE="text/javascript">
    function submitenter(myfield, e)
    {
        var keycode;
        if (window.event)
            keycode = window.event.keyCode;
        else if (e)
            keycode = e.which;
        else
            return true;
        if (keycode == 13)
        {
            myfield.form.submit();
            return false;
        } else
            return true;
    }
</SCRIPT>
<?php
if ($_SERVER['HTTP_REFERER'] != base_url() . "login") {
    $_SESSION['previous_page'] = $_SERVER['HTTP_REFERER'];
}
?>
<script>
    function submitSearchTintuc() {
        var keyword = document.getElementById('keyword').value;
        var url = '<?php echo getAliasDomain(); ?>tintuc/search/keyword/' + keyword;
        window.location = url;
        return true;
    }
    function submitenterQ(myfield, e, baseUrl) {
        var keycode;
        if (window.event)
            keycode = window.event.keyCode;
        else if (e)
            keycode = e.which;
        else
            return true;

        if (keycode == 13) {
            submitSearchTintuc();
            return false;
        } else
            return true;
    }
</script>


<div id="main" class="container-fluid">
    

        <div class="row">
            <div class="col-xs-12 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4">

                <div class="text-center" style="margin: 25px">
                    <img src="<?php echo site_url('images/icon-youraccount.png')?>" style="width:100px;"/>
                </div>
                <?php if (isset($successLogin) && $successLogin == false) { ?>
                    <?php if (isset($validLogin) && $validLogin == true) { ?>
                    <?php } else { ?>
                        <?php
                        if (isset($errorLogin) && $errorLogin == true) {
                            echo $this->lang->line('error_message_defaults');
                        }
                        ?>
                        <form name="frmLoginPage" method="post" id="frmLoginPage" class="form-horizontal" role="form">
                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><img height="16" src="<?php echo base_url(); ?>images/icon-72/1_30.gif" alt=""></span>
                                <input placeholder="<?php echo $this->lang->line('username_defaults'); ?>" type="text" onKeyPress="return submitenter(this, event)" name="UsernameLogin" id="UsernameLogin" maxlength="35" class="input_form form-control" onkeyup="BlockChar(this, 'AllSpecialChar')" onfocus="ChangeStyle('UsernameLogin', 1)" onblur="ChangeStyle('UsernameLogin', 2); lowerCase(this.value, 'UsernameLogin');" />
                            </div>

                            <div style="margin-bottom: 25px" class="input-group">
                                <span class="input-group-addon"><img height="16" src="<?php echo base_url(); ?>images/icon-72/1_31.gif" alt=""></span>
                                <input placeholder="<?php echo $this->lang->line('password_defaults'); ?>" type="password" onKeyPress="return submitenter(this, event)" name="PasswordLogin" id="PasswordLogin" maxlength="35" class="input_form form-control" onfocus="ChangeStyle('PasswordLogin', 1)" onblur="ChangeStyle('PasswordLogin', 2);" />
                            </div>

                            <div class="error" style="color:red;">
                                <?php
                                if ($this->session->flashdata('_sessionErrorLogin')) {
                                    echo $this->session->flashdata('_sessionErrorLogin');
                                }
                                ?>                                                                
                            </div>

                            <div style="margin-bottom: 25px">
                                <input type="button" onclick="CheckInput_Login_Page();" name="submit_login" value="<?php echo $this->lang->line('button_login_defaults'); ?>" class="btn btn-warning  btn-block" />
                            </div>

                            <div class="text-center" style="margin-bottom: 25px"> 
                                <a class="forgot_password" href="<?php echo getAliasDomain(); ?>forgot"><?php echo $this->lang->line('forgot_defaults'); ?></a>


                            </div>

                            
                                
                            <div style="border-top: 1px solid#888; padding-top:15px; font-size:95%" >
                                        <p>Nếu bạn chưa có tài khoản trên <a href="<?php echo settingWebsite ?>"><strong>www.azibai.com</strong></a>, bạn có thể <a href="<?php echo settingWebsite ?>/register/verifycode"><strong>đăng ký miễn phí</strong></a> một tài khoản cho mình.
                                            Nếu bạn không thể đăng nhập vào <a href="<?php echo settingWebsite ?>"><strong>www.azibai.com</strong></a> vì lí do quên mật khẩu, bạn có thể sử dụng chức năng <a href="<?php echo getAliasDomain(); ?>forgot"><strong>lấy lại mật khẩu</strong></a> tự động của <a href="<?php echo settingWebsite ?>"><strong>www.azibai.com</strong></a> hoặc bạn vui lòng liên hệ với chúng tôi để được hỗ trợ.</p>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <p class="text-center"><a href="<?php echo $prevurl; ?>">Click vào đây để tiếp tục</a></p>
                                        <ul class="huongdanlogin">
                                        <?php
                                            $contentFooter = Counter_model::getArticle(thongbao_login);
                                            echo html_entity_decode($contentFooter->not_detail);
                                        ?>
                                            <li>
                                                <font color="#FF0000"><b> Nếu không hệ thống sẽ đưa bạn về trang trước trong 3 giây </b></font>
                                            </li>
                                        </ul>
                                    <?php } ?>

                                 
                        </div>
                </form>
            </div>						

        </div>				

</div>
<?php 
    if(isset($js)) {
        echo '<script type="text/javascript" defer src="'.$js.'"></script>';
    }else {
        echo '<script type="text/javascript" defer src="'.loadJs(array(
            'home/js/jquery-migrate-1.2.1.js',
            'home/js/bootstrap.min.js',
            'home/js/select2.full.min.js',
            'home/js/general.js',
            'home/js/jAlert-master/jAlert-v3.min.js',
            'home/js/jAlert-master/jAlert-functions.min.js',
            'home/js/bootbox.min.js',
            'home/js/js-azibai-tung.js',
            'home/js/jquery.autocomplete.js',
            'home/js/jquery.validate.js',
            'home/js/general.js'
        ),'asset/home/script.min.js').'"></script>';
    } 
?>  
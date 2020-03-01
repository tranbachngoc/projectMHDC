<?php /*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */ ?>
<div class="modal fade" id="myLogin" tabindex="-1" role="dialog" aria-labelledby="myLoginLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="frmLoginPage" class="login-gianhang form" name="frmLoginPage" action="/login" method="post" onsubmit="checkForm(this.name, arrCtrlLogin); return false;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myLoginLabel">Thành viên đăng nhập</h4>
                </div>
                <div class="modal-body">                    
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
                            <input type="text" title="Tên đăng nhập..." class="form-control" placeholder="Tên đăng nhập..." name="UsernameLogin" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                            <input type="password" title="Mật khẩu" placeholder="Mật khẩu..." class="form-control" name="PasswordLogin">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <input type="checkbox" id="remember_password" name="remember_password" value="1">&nbsp;
                            <label for="remember_password"> Ghi nhớ đăng nhập</label>
                        </div>
                        <div class="col-sm-6">
			    <?php 
			    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
			    ?>
                            <a class="text_link" href="<?php echo $protocol.domain_site?>/forgot" rel="nofollow">Bạn quên mật khẩu?</a>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_login" value="login">
                    <input type="hidden" name="linkreturn" value="<?php echo current_url() ?> ">
                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                    
                </div>
            </form>    
        </div>
    </div>
</div>


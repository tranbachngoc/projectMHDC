<footer id="footer"></footer>
<div class="modal fade" id="pop-login" tabindex="-1" role="dialog" aria-labelledby="myLoginLabel" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="frmLoginPage" class="login-gianhang form" name="frmLoginPage" action="/login" method="post" onsubmit="checkForm(this.name, arrCtrlLogin); return false;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="modal-title" id="myLoginLabel">Thành viên đăng nhập</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" title="Tên đăng nhập..." class="input_form_custom form-control" placeholder="Tên đăng nhập..." name="UsernameLogin" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <input type="password" title="Mật khẩu" placeholder="Mật khẩu..." class="input_form_custom form-control" name="PasswordLogin">
                    </div>
                    <div class="row">
                        <div class="col-sm-6  text-left">
                            <input type="checkbox" id="remember_password" name="remember_password" value="1">&nbsp;
                            <label for="remember_password"> Ghi nhớ đăng nhập</label>
                        </div>
                        <div class="col-sm-6 text-right"><a class="text_link" href="http://azibai.xyz/forgot" rel="nofollow">Bạn quên mật khẩu?</a></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_login" value="login">
                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                </div>
            </form>
        </div>
    </div>
</div>

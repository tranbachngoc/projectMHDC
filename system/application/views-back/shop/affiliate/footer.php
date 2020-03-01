        <div id="aziload"  style="display: none;">
            <div class="loading_bg"></div>
            <span class="loading"><i class="fa fa-circle-o-notch fa-spin"></i></span>
            <div class="azimes"></div>
        </div> 

        <div id="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="text-center  small">
                            <strong class="text-uppercase"><?php echo $shop->sho_name != '' ? $shop->sho_name : 'Chưa cập nhật';?></strong>
                            <br><?php echo $shop->sho_descr != '' ? $shop->sho_descr : 'Chưa cập nhật'; ?><br>
                            <i class="fa fa-map-marker fa-fw"></i> <?php echo $sho_address != '' ? $sho_address : 'Chưa cập nhật'; ?>
                            <br>
                            <i class="fa fa-tablet fa-fw"></i> <?php echo $user->use_mobile != '' ? $user->use_mobile : 'Chưa cập nhật'; ?>
                            <i class="fa fa-fax fa-fw"></i> <?php echo $user->use_phone != '' ? $user->use_phone : 'Chưa cập nhật'; ?><br>
                            <i class="fa fa-envelope-o fa-fw"></i> <?php echo $user->use_email != '' ? $user->use_email : 'Chưa cập nhật'; ?>
                            <br>
                            <i class="fa fa-globe fa-fw"></i> <?php echo $linkweb != '' ? $linkweb : 'Chưa cập nhật'; ?>
                            <br>
                            Bản quyền <i class="fa fa-copyright fa-fw"></i> 2015 - <span class="text-uppercase"><?php echo $shop->sho_name != '' ? $shop->sho_name : 'Chưa cập nhật'; ?></span>. Thiết kế và phát triển bởi <span class="text-uppercase">Azibai</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
           <div class="vertical-alignment-helper">
                <div class="modal-dialog vertical-align-center" role="document">
                    <div class="modal-content">

                    </div>
                </div>
           </div>
        </div>
        <?php if (!$this->session->userdata('sessionUser')) { ?>
    <div class="modal fade" id="myLogin" tabindex="-1" role="dialog" aria-labelledby="myLoginLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form id="frmLoginPage" class="login-gianhang form" name="frmLoginPage" action="/login" method="post" onsubmit="checkForm(this.name, arrCtrlLogin); return false;">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myLoginLabel">Thành viên đăng nhập</h4>
                </div>
                <div class="modal-body">                    
                    <div class="form-group">                        
                            <input type="text" title="Tên đăng nhập..." class="input_form_custom form-control" placeholder="Tên đăng nhập..." name="UsernameLogin" autocomplete="off" >
                    </div>
                    <div class="form-group">                        
                            <input type="password" title="Mật khẩu" placeholder="Mật khẩu..." class="input_form_custom form-control" name="PasswordLogin" >
                    </div>
                    <div class="row">
                        <div class="col-sm-6  text-left">
                            <input type="checkbox" id="remember_password" name="remember_password" value="1">&nbsp;
                            <label for="remember_password"> Ghi nhớ đăng nhập</label>
                        </div>
                        <div class="col-sm-6 text-right"><a class="text_link" href="<?php echo $mainURL; ?>forgot" rel="nofollow">Bạn quên mật khẩu?</a></div>
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
    <?php } ?>
    <style>
        .loading_bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background-color: #000;
            opacity: 0.5;
        }
        span.loading {
            margin: auto;
            color: #000;
            display: inline-block;
            padding: 10px;
            text-align: center;
            background: #fff;
            border-radius: 3px;
            z-index: 10000;
            position: fixed;
            top: 50%;
            left: 50%;
        }
        .azimes {
            width: 600px;
            margin: auto;
            position: fixed;
            top: 50%;
            margin-top: -2%;
            background: #fff;
            border-radius: 3px;
            z-index: 10000;
            left: 50%;
            margin-left: -25%;
        }
        .azimes p {
            margin: 15px;
            padding: 10px;
        }
    </style>
    
        <style>.alert{margin-bottom: 0px;}</style>
    </body>
</html>

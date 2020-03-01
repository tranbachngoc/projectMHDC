<?php $this->load->view('group/common/header'); ?>
<br>
<div id="main" class="container-fluid">
    <div class="row">          
        <div class="col-md-3 sidebar">
            <?php $this->load->view('group/common/menu'); ?>
        </div>   
        <div class="col-md-9 main">            
	    <h4 class="page-header text-uppercase" style="margin-top:10px">Phân Quyền Admin</h4>
            <div class="dashboard">
                <!-- ========================== Begin Content ============================ -->
                    <div class="group-news">
          
                    <form class="form-horizontal" name="frmUpdateGroupAdmin" id="frmUpdateGroupAdmin" method="post" enctype="multipart/form-data">
                        
                        <div class="form-group" style="text-align: center; color: #ab0909;">
                            <strong>Để lưu được dữ liệu bạn phải nhập tài khoản người kiểm duyệt hoặc tài khoản người phê duyệt</strong>
                        </div>
                        <div class="form-group">
                            <label for="grt_admin" class="col-sm-3 control-label">Admin group:</label>
                            <div class="col-sm-9">
                                <div style="padding: 7px 0; font-weight: bold;"><?php echo $grt_ad_admin; ?></div>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label for="grt_ad_moderator" class="col-sm-3 control-label">Người kiểm duyệt:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="grt_ad_moderator" id="grt_ad_moderator" placeholder="Nhập username của người kiểm duyệt" value="<?php if($grt_ad_moderator && $grt_ad_moderator!=''){echo $grt_ad_moderator;} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grt_ad_approver" class="col-sm-3 control-label">Người phê duyệt:</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="grt_ad_approver" id="grt_ad_approver" placeholder="Nhập username của người phê duyệt" value="<?php if($grt_ad_approver && $grt_ad_approver!=''){echo $grt_ad_approver;} ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="grt_captcha" class="col-sm-3 control-label">Mã Captcha:</label>
                            <div class="col-sm-3">
                                <img src="<?php echo $imageCaptchaGrtAdmin; ?>" height="31"/>
                            </div>
                            <div class="col-sm-6">
                                <input  style="text-indent: 5px; padding: 5px 0" onkeypress="return submitenter(this, event)" type="text" name="grt_captcha" id="captcha_groupAdmin" value="" maxlength="10" class="form-control"/>
                                <span style="color: #f00; display: inherit;"><?php echo $error_captcha ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6 col-sm-3 col-sm-offset-3">
                                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="submitgroup();">Cập nhật</button>
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
    <script>

        function submitenter(e, t, n) {
            var r;
            if (window.event) r = window.event.keyCode;
            else if (t) r = t.which;
            else return true;
            if (r == 13) {
                qSearch(n);
                return false
            } else return true
        }

        function submitgroup() {
            if (CheckBlank(document.getElementById("captcha_groupAdmin").value)) {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Bạn chưa nhập mã bảo vệ!',
                    'theme': 'red',
                    'btns': {
                        'text': 'Ok', 'theme': 'red', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("captcha_groupAdmin").focus();
                            return false;
                        }
                    }
                });

                return false;
            }
            document.frmUpdateGroupAdmin.submit();
        }
    </script>
<?php $this->load->view('group/common/footer'); ?>
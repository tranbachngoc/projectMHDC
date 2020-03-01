<?php $this->load->view('group/common/header'); ?>
<br>
<div id="main" class="container-fluid">
    <div class="row">          
        <div class="col-md-3 sidebar">
            <?php $this->load->view('group/common/menu'); ?>
        </div>   
        <div class="col-md-9 main">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">Cập nhật tài khoản ngân hàng</h4>
            <div class="dashboard">
                <!-- ========================== Begin Content ============================ -->
                    <div class="group-news">
                       
                    <form class="form-horizontal" name="frmUpdateGroupBank" id="frmUpdateGroupBank" method="post" enctype="multipart/form-data">                         
                        <div class="form-group">
                            <label for="grt_bank" class="col-sm-3 control-label">Tên ngân hàng<font color="#FF0000"><b>*</b></font> :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="grt_bank" id="grt_bank" placeholder="Tên ngân hàng" value="<?php if($grt_bank && $grt_bank != ''){echo $grt_bank; } ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grt_bank_num" class="col-sm-3 control-label">Số tài khoản<font color="#FF0000"><b>*</b></font> :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="grt_bank_num" id="grt_bank_num" placeholder="Số tài khoản" value="<?php if($grt_bank_num && $grt_bank_num!=''){echo $grt_bank_num;} ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grt_bank_addr" class="col-sm-3 control-label">Chi nhánh ngân hàng<font color="#FF0000"><b>*</b></font> :</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="grt_bank_addr" id="grt_bank_addr" placeholder="Chi nhánh của ngân hàng" value="<?php if($grt_bank_addr && $grt_bank_addr!=''){echo $grt_bank_addr;} ?>">
                            </div>
                        </div>                       
                        
                        <div class="form-group">
                            <label for="grt_captcha" class="col-sm-3 control-label">Mã bảo vệ<font color="#FF0000"><b>*</b></font> :</label>
                            <div class="col-sm-3">
                                <img src="<?php echo $imageCaptchaGrtBank; ?>" height="31"/>
                            </div>
                            <div class="col-sm-6">
                                <input  style="text-indent: 5px; padding: 5px 0" onkeypress="submitenter(this, event)" type="text" name="grt_captcha" id="captcha_groupBank"  maxlength="10" class="form-control"/>
                                <span style="color: #f00;"><?php echo $error_captcha ?></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-xs-6 col-sm-3 col-sm-offset-3">
                                <button type="button" class="btn btn-primary btn-lg btn-block" onclick="check_BankGroup();">Cập nhật</button>
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
<?php $this->load->view('group/common/footer'); ?>
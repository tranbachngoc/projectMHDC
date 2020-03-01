<?php $this->load->view('home/common/account/header'); ?>

<style>
    .boxnew {
        background: #fff;
        padding-bottom: 20px;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->

        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 boxnew">
            <h4 class="page-header text-uppercase" style="margin-top: 10px">
                Thêm mới doanh thu Cộng tác viên: <b><?php echo $ctv_data->use_fullname; ?></b>
            </h4>

            <?php if($msg_error) { ?>
                <div class="message success" >
                    <div class="alert alert-danger">
                        <?php echo $msg_error; ?>
                        <button type="button" class="close" data-dismiss="alert">×</button>
                    </div>
                </div>
            <?php } ?>
            <div class="message success" >
                <div class="alert alert-danger">
                    Cấu hình doanh thu bắt đầu phải lớn hơn: <?php echo $val_num; ?> VND
                    <button type="button" class="close" data-dismiss="alert">×</button>
                </div>
            </div>

            <div style="width:100%">
                <form name="frmCommissionAff" id="frmCommissionAff" method="post" enctype="multipart/form-data"
                      class="form-horizontal" action="">

                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">Doanh thu từ</div>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                            <div class="input-group">
                                <input type="number" name="min" placeholder="từ" class="input_commiss form-control" id="min" value="<?php echo $min ?>">
                                <span class="input-group-addon"><span style="display: inline-block; width:32px">VNĐ</span></span>
                            </div>
                        </div>                        
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">Đạt đến</div>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                            <div class="input-group">
                                <input type="number" name="max" placeholder="đến" class="input_commiss form-control" id="max" value="<?php echo $max ?>">
                                <span class="input-group-addon"><span style="display: inline-block; width:32px">VNĐ</span></span>
                            </div>                            
                        </div>                      
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12">Hoa hồng</div>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                            <div class="input-group">                                
                                <input type="number" name="percent" placeholder="Hoa hồng" class="input_commiss form-control" value="<?php echo $percent; ?>">
                                <span class="input-group-addon"><span style="display: inline-block; width:32px">%</span></span>
                            </div>
                        </div>                        
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-md-3 col-sm-3 col-xs-12"></div>
                        <div class="col-md-6 col-sm-9 col-xs-12">
                            <SCRIPT TYPE="text/javascript">
                                function submitenter(myfield, e) {
                                    var keycode;
                                    if (window.event) keycode = window.event.keyCode;
                                    else if (e) keycode = e.which;
                                    else return true;
                                    if (keycode == 13) {
                                        CheckInput_CommissionAff();
                                        return false;
                                    }
                                    else
                                        return true;
                                }
                            </SCRIPT>
                            <input type="button" onclick="CheckInput_CommissionAff();" name="submit_postpro" value="Lưu"
                                   class="btn btn-azibai" onkeypress="return submitenter(this,event)">
                            <a class="btn btn-default" href="/account/affiliate/configaffiliate/<?php echo $ctv_data->af_id; ?>">Thoát</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<script>
    function kiemtra() {
        var id_user = $("#afchinhanh").val();
        if (id_user == '') {
            $("#afchinhanh").focus();
            return flase;
        }
    }

    function test() {
        var min = $('#min').val();
        var max = $('#max').val();
        if (min == '') {
            $('#min').css("border-color", "#f00");
        }
        if (max == '') {
            $('#max').css("border-color", "#f00");
        }
    }
    ;
</script>
<style type="text/css">
    input[type=number]::-webkit-inner-spin-button,
    input[type=number]::-webkit-outer-spin-button {
        display: none;
    }
</style>

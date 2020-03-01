<?php $group_id = (int)$this->session->userdata('sessionGroup'); ?>
    <style>
        input#sho_limit_ctv::-webkit-inner-spin-button,
        input#sho_limit_ctv::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
<?php $this->load->view('home/common/account/header'); ?>
    <div class="container">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            <div class="col-lg-9 col-md-9 col-sm-8 col-sm-8 col-xs-12 account_edit db_table">
                <div class="tile_modules tile_modules_blue">Giới hạn số lượng cộng tác viên cho chi nhánh</div>
                <table class="table table-bordered">
                    <tr>
                        <td>
                            <?php if ($successEditBank == false) { ?>
                                <form name="frmCTV" id="frmCTV" action="" method="post" class="form-horizontal col-lg-10">
                                    <div class="rows">
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                                            Số cộng tác viên được giới thiệu:
                                        </div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                            <input type="number"
                                                   value="<?php if ($branchs->sho_limit_ctv > 0) {
                                                       echo $branchs->sho_limit_ctv;
                                                   } ?>" name="sho_limit_ctv" id="sho_limit_ctv"
                                                   placeholder="Số cộng tác viên được phép giới thiệu"
                                                   class="form-control" value="0"/>
                                        </div>
                                    </div>
                                    <div class="rows">
                                        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12"></div>
                                        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                                            <button type="button" id="" onclick="check_limitCTV();" class="btn btn-primary">Cập nhật</button>
                                            <button class="btn btn-danger">Hủy</button>
                                        </div>
                                    </div>
                                    <div class="form-group"></div>
                                    <div class="clearfix"></div>
                                </form>
                            <?php } else { ?>
                                <div class="text-center">
                                    <p class="text-center"><a href="<?php echo base_url(); ?>account">Click vào đây để tiếp tục</a></p>
                                    Cấu hình giới hạn công tác viên cho chi nhánh thành công!
                                </div>
                            <?php } ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <script>
        function check_limitCTV() {
            if (CheckBlank(document.getElementById("sho_limit_ctv").value)) {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Bạn chưa nhập số cộng tác viên',
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("sho_limit_ctv").focus();
                            return false;
                        }
                    }
                });
                return false;
            }
            if (!IsNumber(document.getElementById("sho_limit_ctv").value)) {
                $.jAlert({
                    'title': 'Thông Báo',
                    'content': 'Số cộng tác viênphải nhập là số',
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("sho_limit_ctv").focus();
                            return false;
                        }
                    }
                });
                return false;
            }

            if (document.getElementById("sho_limit_ctv").value == '0') {
                $.jAlert({
                    'title': 'Thông báo',
                    'content': 'Số cộng tác viên giới thiệu  phải lớn hơn 0!',
                    'theme': 'default',
                    'btns': {
                        'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
                            e.preventDefault();
                            document.getElementById("sho_limit_ctv").focus();
                            return false;
                        }
                    }
                });

                return false;
            }
            document.frmCTV.submit();
        }
    </script>
    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
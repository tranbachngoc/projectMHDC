<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            <div class="col-md-9 col-sm-8 col-xs-12">
		<h4 class="page-header text-uppercase" style="margin-top:10px">                   
                    Cấu hình domain
                </h4>
                <!-- Begin Show error if have -->
                <?php if ($this->session->flashdata('ErrorMessage')) { ?>
                    <div class="message success">
                        <div class="alert alert-danger">
                            <?php echo $this->session->flashdata('ErrorMessage'); ?>
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                    </div>
                <?php } ?>
                <!-- End Show error if have -->                
                <form name="frmInputDomain" id="frmInputDomain" method="post">
                    <?php if($oUser->use_id > 0) { ?>
                        <?php if($msg){ ?>
                            <div style="color: red"> <?php echo $msg; ?></div>
                        <?php } ?>
                            <p>Để cài đặt domain riêng:</p>                            
                            <ol>
                                <li>Cấu hình trỏ CName (<a target="_blank" href="<?php echo base_url(); ?>account/docs/498/detail/cau-hinh-domain">Xem hướng dẫn</a>)</li>               
                                <li>Cấu hình DOMAIN</li>
                            </ol>

                            <div class="form-group">
                                <input type="text" name="txtdomain" id="txtdomain" placeholder="Nhập tên miền của bạn" class="form-control" value="<?php echo $oUser->website; ?>" required />
                                <br>
				<p>Lưu ý:</p>
                            
                                <ol>
                                    <li>Tên miền phải thuộc sở hữu của bạn</li>
                                    <li>Tên miền đó hiện tại không sử dụng cho website nào khác</li>
                                    <li>Nhập đúng cấu trúc như sau, VD: <b style="color:red">azibai.com</b></li>
                                    <li>Nếu không đủ các điều kiện trên, vẫn cố tình nhập vào chúng tôi không chịu trách nhiệm. Cảm ơn!</li>
                                </ol>
                            </div>                           
                            
                            <div class="form-group">  
                                <button type="submit" class="btn btn-azibai" onclick="return CheckSyntaxDomain();">Gửi</button>
                                <input type="button" name="cancle_editshop" value="<?php echo $this->lang->line('button_cancle'); ?>" onclick="ActionLink('<?php echo base_url(); ?>account')" class="btn btn-default"/>
                            </div>
                        </div>
                    <?php } ?>
                </form>
            </div>
        </div>
    </div>
    <!--END: RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<script>
    function CheckSyntaxDomain(){
        var dmName = $('#txtdomain').val();
        if(dmName == ''){
            return false;
        } else {
            var pattern = new RegExp("^[a-zA-Z0-9][a-zA-Z0-9-]{0,61}[a-zA-Z0-9](?:\.[a-zA-Z]{2,})+$"); 
            if (!pattern.test(dmName)) {
                alert("Tên miền của bạn không đúng cấu trúc. Vui lòng nhập lại");            
                return false;
            } 
            return true;  
        }   
    }   
</script>
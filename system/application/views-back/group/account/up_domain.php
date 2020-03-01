<?php $this->load->view('group/common/header'); ?>
<br>
<div id="main" class="container-fluid">
    <div class="row">          
        <div class="col-md-3 sidebar">
            <?php $this->load->view('group/common/menu'); ?>
        </div>   
        <div class="col-md-9 main"> 
	    <h4 class="page-header text-uppercase" style="margin-top:10px">Cấu hình domain</h4>
            <div class="dashboard">
                <!-- ========================== Begin Content ============================ -->
                    <div class="group-news">
                   
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
                        <form name="frmInputGrtDomain" id="frmInputGrtDomain" method="post">
                            <?php if($shopid > 0) { ?>                             
                                    <p><strong>Để cài đặt domain riêng:</strong></p>                            
                                    <ol>
                                        <li>Cấu hình trỏ CName (<a target="_blank" href="<?php echo getAliasDomain(); ?>account/docs/498/detail/cau-hinh-domain" style="color: #1A0AF3;">Xem hướng dẫn</a>)</li>               
                                        <li>Cấu hình DOMAIN</li>
                                    </ol>
                                    
                                    <div class="form-group">
                                        <input type="text" name="txtdomain" id="txtdomain" placeholder="Nhập tên miền của bạn" class="form-control" value="<?php echo $grTrade->grt_domain; ?>" required />
                                        <br>
                                        <strong>Lưu ý:</strong><br><span> 1. Tên miền phải thuộc sở hữu của bạn </br> 2. Tên miền đó hiện tại không sử dụng cho website nào khác</br> 3. Nhập đúng cấu trúc như sau, VD: <b style="color:red">azibai.com</b></br> 4. Nếu không đủ các điều kiện trên, vẫn cố tình nhập vào chúng tôi không chịu trách nhiệm. Cảm ơn!</span>
                                    </div>                           
                                    
                                    <div class="form-group">  
                                        <button type="submit" class="btn btn-primary" onclick=" CheckSyntaxDomain();">Gửi</button>
                                        <input type="button"  value="<?php echo $this->lang->line('button_cancle'); ?>" onclick="ActionLink('<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt?>/default')" class="btn btn-default"/>
                                    </div>
                                </div>
                            <?php } ?>
                        </form>
                    </div>
                <!-- ========================== End Content ============================ -->
            </div>
        </div> 
    </div>
</div>
<?php $this->load->view('group/common/footer'); ?>
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
            //return true; 
            document.forms["frmInputGrtDomain"].submit();
        }   
    }
    function ActionLink(link){
        window.location.href = link;
    }
</script>
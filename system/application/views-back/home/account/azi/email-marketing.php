<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <?php 
            $strUrl=$_SERVER['HTTP_HOST'];
            $sub=explode('.', $_SERVER['HTTP_HOST']);
            if(count($sub) === 3){
                $shopname=$sub[0];
                $strUrl=str_replace($shopname .'.', '', $strUrl);
            }
         ?>
        <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 db_table">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">		
                Email Marketing ( Công cụ chăm sóc khách hàng qua Email)
            </h4>
            <form name="frmAccountSendContact" method="post">
                <div class="bs-docs-section">
                    <div class="bs-callout bs-callout-info" id="callout-progress-animation-css3">
                        <h4>Giới thiệu về Email Marketing</h4>
                        <p>Email marketing, một kênh bán hàng, chăm sóc khách hàng hiệu quả.
                        </p>
                    </div>
                    <div class="bs-callout bs-callout-danger">
                        <h4 id="callout-progress-csp"> Công dụng, tính năng</h4>
                        <p>
                          Đang cập nhật
                        </p>
                    </div>
                    <div class="bs-callout bs-callout-warning" id="callout-progress-animation-css3">
                        <h4>Hướng dẫn sử dụng</h4>
                       <!--  <p>
                            Bạn hãy click vào link <a class="text-primary" href="http://emailapp.azibai.com" target="_blank">Azibai Email Markeing</a> để đăng nhập vào công cụ Email marketing và sử dụng những tính năng tuyệt vời của Email Marketing Azibai.
                        </p> -->
                         <p>
                            Bạn hãy click vào link <a class="text-primary" href="http://emailapp.<?php echo $strUrl; ?>" target="_blank">Azibai Email Markeing</a> để đăng nhập vào công cụ Email marketing và sử dụng những tính năng tuyệt vời của Email Marketing Azibai.
                        </p>

                        <a href="<?php echo base_url();?>account/tool-marketing/access-email-marketing" target="_blank"><button type="button" class="btn btn-default1">Truy cập Azibai Email Markeing</button></a>
                        <!--<a href="<?php /*echo base_url();*/?>account/tool-marketing/access-email-marketing" target="_blank"><button type="button" class="btn btn-default1">Tạo thành viên</button></a>-->
                        <a href="#" class="btn btn-default1" id="btn_email">Chuyển tiền qua dịch vụ email</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="chuyentien" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" >
    <div class="modal-dialog modal-lg" role="document" style="width:385px;">
        <div class="modal-content">
            <div class="modal-body">
                    <div>
                        <label>
                            Số tiền : <input type="text" id="amount" name="amount" value="" placeholder="nhập số tiền" />
                        </label>

                        <div class="btn-box" style="display: inline-block;">
                            <input type="submit" value="Chuyển" id="btn-chuyentien" class="btn btn-success" /><a href="#" class="btn btn-danger" data-dismiss="modal">Hủy</a>
                        </div>
                        <!--<div class="alert alert-danger " role="alert">test</div>-->
                        <div>
                            <p>
                                Số tiền hiện có: <?php echo $total_amount; ?>đ
                            </p>
                        </div>
                    </div>
            </div>
        </div>
    </div>

</div>
<script type="text/javascript" lang="javascript">
    $("#btn_email").on('click',function(){
        $("#chuyentien").modal('show');
    });
    $("#btn-chuyentien").click(function(){
      chuyentien();
    });
    function chuyentien(){
        var amount=$("#amount").val();
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "<?php echo base_url(); ?>account/chuyentien_emailmarketing",
            data: { amount: amount }
        })
            .done(function( msg ) {
                if(msg.isOk){
                    console.log( "Đã cập nhật"  );
                    location.reload();
                }
                $("#chuyentien").modal('toggle');
                alert(msg.msg);
            });

    }
    </script>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>

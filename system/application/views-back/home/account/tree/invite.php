<?php $this->load->view('home/common/account/header'); ?>
<script type="application/javascript">
    jQuery(document).ready(function () {
    var copyTextareaBtn = document.querySelector('.js-textareacopybtn');
    copyTextareaBtn.addEventListener('click', function (event) {
    var copyTextarea = document.querySelector('.js-copytextarea');
    copyTextarea.select();

    try {
    var successful = document.execCommand('copy');
    var msg = successful ? 'successful' : 'unsuccessful';
    console.log('Copying text command was ' + msg);
    } catch (err) {
    console.log('Oops, unable to copy');
    }
    });
    });
</script>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header  text-uppercase" style="margin-top:10px"><?php if ($this->uri->segment(3) == 'inviteaf') { ?>Giới thiệu mở Cộng Tác Viên Online<?php } else { ?>Giới thiệu mở Gian hàng <?php } ?></h4>
            <div class="link_invite khungu">Link giới thiệu:
                <textarea class="js-copytextarea form-control"><?php
            switch ($this->session->userdata('sessionGroup')) {
                case 15:
                    if ($this->uri->segment(3) == 'inviteaf') {
                    //echo base_url() . "register/affiliate/pid/" . $userId;
                    echo base_url() . "account/affiliate/empid/" . $userId;
                    } else {
                    //echo base_url() . "register/estore/pid/" . $userId;
                    }
                    break;
                
                default:
                    if ($this->uri->segment(3) == 'inviteaf') {                        
                        // echo base_url() . "register/affiliate/pid/" . $userId;
                        echo base_url() . "register/verifycode?reg_pa=" . $userId;
                    } else {
                        echo base_url() . "register/estore/pid/" . $userId;
                    }
                    break;
            }
            
		    
		    ?></textarea>
                <div class="btncopy"><input name="copylink" class="js-textareacopybtn btn btn-azibai" type="button"
                                            value="Copy Link"/>
                </div>
            </div>
            <!--BEGIN: RIGHT-->
            <!--	--><?php //if( $this->uri->segment(3)=='invite'){   ?>
            <!--	 <div class="link_invite khungu padding"><strong>Giới thiệu mở gian hàng bằng Landing page thiết kế sẵn</strong><br/>-->
            <!--		<div>Link giới thiệu:</div>-->
            <!--		<textarea style="width:100%;">-->
	    <?php // echo base_url()."giai-phap/".$userId;  ?><!--</textarea>-->
            <!--    </div><br/>-->
            <!--<div class="link_invite khungu padding"><strong>Giới thiệu tham gia khóa đào tạo Azibai</strong><br/>
		<div>Link giới thiệu:</div>
		<textarea style="width:100%;"><?php //echo base_url()."dang-ky-hoc/".$userId;   ?></textarea>
    </div>-->
            <!--	--><?php //}   ?>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>


<?php $this->load->view('home/common/header'); ?>
    <script type="application/javascript">
        jQuery( document ).ready(function() {
            var copyTextareaBtn = document.querySelector('.js-textareacopybtn');
            copyTextareaBtn.addEventListener('click', function(event) {
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
<!--BEGIN: RIGHT-->
<div class="col-md-9 col-sm-8 col-xs-12">
    
    <h4 class="page-header text-uppercase" style="margin-top:10px">
        <?php if(isset($notify->link_share) && $notify->link_share !=''){?>
            Nội dung link cần chia sẻ
        <?php } else{?>
        <?php echo $this->lang->line('title_notify_detail'); } ?>
    </h4>
    
    <table class="table table-bordered" border="0" cellpadding="0" cellspacing="0" >
        <tr>
            <td height="50" class="header_communicate">
                <h4><?php echo $notify->not_title; ?></h4>
               <span class="text-primary"><i class="fa fa-calendar"></i> Ngày tạo: <i> <?php echo date('d-m-Y', $notify->not_begindate); ?></i></span>
                <?php $vovel=array("&curren;"); echo html_entity_decode(str_replace($vovel,"#",$notify->not_detail));?>
                <?php //echo $this->bbcode->light($product->pro_detail); ?>
                <?php if(isset($notify->link_share) && $notify->link_share !=''){?>
                <div class="textarea_form">
                <div class="col-lg-2"><i class="fa fa-share"></i> Link chia sẻ:</div>
                    <div class="col-lg-10"><textarea class="js-copytextarea"><?php echo $notify->link_share; ?><?php if($userObject->af_key!=''){ ?>?share=<?php echo $userObject->af_key; ?><?php } ?></textarea></div>
                </div>
                    <div class="col-lg-12"><div class="btncopy"><input name="copylink" class="js-textareacopybtn btn btn-primary" type="button"  value="Copy Link" /></div>
                <?php } ?>
            </td>
        </tr>
    </table>
    </div>
</div>
    </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
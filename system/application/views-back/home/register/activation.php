<?php $this->load->view('home/common/account/header'); ?>
<!--BEGIN: LEFT-->
<div id="main" class="container">
    <div class="panel panel-primary">
        <div class="panel-heading"> <h3 class="panel-title"><?php echo $this->lang->line('title_activation'); ?></h3> </div>
        <div class="panel-body">
            <div class="alert alert-success alert-dismissible fade in" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <?php if(isset($vipOrSalerActivation) && $vipOrSalerActivation == true){ ?>
                <?php echo $this->lang->line('vip_or_saler_activation'); ?>
            <?php }elseif(isset($successActivation) && $successActivation == true){ ?>
                <?php echo '<p>'.$this->lang->line('success_activation').'</p>'; ?>
            <?php }else{ ?>
                <?php echo $this->lang->line('error_activation'); ?>
            <?php } ?>
               <p style="font-weight: 600"> Bạn hãy đăng nhập vào hệ thống của azibai để được hướng dẫn sử dụng cụ thể hơn!</p>
            </div>
            <?php if($user->style_id != ""): ?>
                <h4 style="text-transform: uppercase; font-weight:500" class="text-center text-primary">Template bạn đã chọn</h4>
                <img width="100%" src="<?php echo base_url(); ?>templates/home/images/demo_template/demo<?php echo $user->style_id;?>-thumb.png"/>
            <?php endif; ?>
            <p class="text-center"><a href="<?php echo base_url();?>login">Click vào đây để tiếp tục</a></p>
        </div>
    </div>
</div>
<!--END LEFT-->
<?php $this->load->view('home/common/footer'); ?>
<?php /*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */ ?>

<div class="panel panel-default">                
    <div class="panel-heading"><strong><?php echo $get_grt->grt_name; ?></strong></div>    
    <div class="panel-body" style="padding: 5px">
        <div style="background: #fff; height: 100%">
            <?php if($get_grt->grt_desc) { ?>
            <div style="padding: 5px">
                <span class="pull-left" style="margin-top:5px;">
                    <i class="fa fa-info-circle fa-fw"></i>
                </span>
                <div style="margin-left: 30px">
                    <?php echo $get_grt->grt_desc; ?>
                </div>
            </div>
            <?php } ?>
            <?php if($get_grt->grt_address) { ?>
            <div style="padding: 5px">
                <span class="pull-left" style="margin-top:5px;">
                    <i class="fa fa-map-marker fa-fw"></i>
                </span>
                <div style="margin-left: 30px">
                    <?php echo $get_grt->grt_address .', '.$get_grt->district.', '.$get_grt->province; ?>
                </div>
            </div>
            <?php } ?>
            <?php if($get_grt->grt_phone) { ?>
            <div style="padding: 5px">
                <span class="pull-left" style="margin-top:5px;">
                    <i class="fa fa-phone fa-fw"></i>
                </span>
                <div style="margin-left: 30px">
                    <?php echo $get_grt->grt_phone; ?>
                </div>
            </div>
            <?php } ?>
            <?php if($get_grt->grt_mobile) { ?>
            <div style="padding: 5px">
                <span class="pull-left" style="margin-top:5px;">
                    <i class="fa fa-mobile fa-fw"></i>
                </span>
                <div style="margin-left: 30px">
                    <?php echo $get_grt->grt_mobile; ?>
                </div>
            </div>
            <?php } ?>
            <?php if($get_grt->grt_email) { ?>
            <div style="padding: 5px">
                <span class="pull-left" style="margin-top:5px;">
                    <i class="fa fa-envelope fa-fw"></i>
                </span>
                <div style="margin-left: 30px">
                    <?php echo $get_grt->grt_email; ?>
                </div>
            </div>
            <?php } ?>
            <?php if($get_grt->grt_facebook) { ?>
            <div style="padding: 5px">
                <span class="pull-left" style="margin-top:5px;">
                    <i class="fa fa-facebook fa-fw"></i>
                </span>
                <div style="margin-left: 30px">
                    <?php echo $get_grt->grt_facebook; ?>
                </div>
            </div>
            <?php } ?>
            <?php if($get_grt->grt_message) { ?>
            <div style="padding: 5px">
                <span class="pull-left" style="margin-top:5px;">
                    <i class="fa fa-comments fa-fw"></i>
                </span>
                <div style="margin-left: 30px;text-overflow: ellipsis; white-space: nowrap; overflow: hidden; height: 20px;">
                    <?php echo $get_grt->grt_message; ?>
                </div>
            </div>
            <?php } ?>            
        </div>
    </div>
</div>


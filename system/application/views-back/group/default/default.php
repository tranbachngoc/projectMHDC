<?php $this->load->view('group/common/header'); ?>
<br>
<div id="main" class="container-fluid">
    <div class="row">          
        <div class="col-md-3 sidebar">
            <?php $this->load->view('group/common/menu'); ?>
        </div>   
        <div class="col-md-9 main">            
            <div class="row dashboard">

<?php if ($grt_link) {
    $link_grt = $protocol . $grt_link .'.'. $domainName . '/grtshop';
    if($grt_domain != ''){
        $link_grt = $protocol . $grt_domain;
    }
    ?>
    <div class="col-xs-6 col-sm-3 col-md-3">
                    <div class="fix16by9 ">
                        <a class="menu-item" href="<?php echo $link_grt; ?>" target="blank">
                            <i class="fa fa-home fa-fw fa-2x"></i><br>
                                <span class="menu-item-title">Xem gian hàng </span>
                        </a>
                    </div>                    
        <a href="../news/members.php"></a>
                </div>
<?php } ?>
                <div class="col-xs-6 col-sm-3 col-md-3">
                    <div class="fix16by9 ">
                        <a class="menu-item" href="/grouptrade/<?php echo $segmentGrt; ?>/updatecontact">
                            <i class="fa fa-info-circle fa-fw fa-2x"></i><br>
                                <span class="menu-item-title">Thông tin</span>
                        </a>
                    </div>                    
                </div>

                <div class="col-xs-6 col-sm-3 col-md-3">
                    <div class="fix16by9 ">
                        <a class="menu-item" href="/grouptrade/<?php echo $segmentGrt; ?>/listmember">
                            <i class="fa fa-users fa-fw fa-2x"></i><br>
                            <span class="menu-item-title">Thành viên</span>
                        </a>
                    </div>                    
                </div>

                <div class="col-xs-6 col-sm-3 col-md-3">
                    <div class="fix16by9 ">
                        <a class="menu-item" href="/grouptrade/<?php echo $segmentGrt; ?>/approvenews">
                            <i class="fa fa-newspaper-o fa-fw fa-2x"></i><br>
                            <span class="menu-item-title">Tin tức</span>
                        </a>
                    </div>                    
                </div>

                <div class="col-xs-6 col-sm-3 col-md-3">
                    <div class="fix16by9 ">
                        <a class="menu-item" href="/grouptrade/<?php echo $segmentGrt; ?>/approveproduct">
                            <i class="fa fa-cubes fa-fw fa-2x"></i><br>
                            <span class="menu-item-title">Sản phẩm</span>
                        </a>
                    </div>                    
                </div>

                <div class="col-xs-6 col-sm-3 col-md-3">
                    <div class="fix16by9 ">
                        <a class="menu-item" href="/grouptrade/<?php echo $segmentGrt; ?>/listorder/product">
                            <i class="fa fa-file-text fa-fw fa-2x"></i><br>
                            <span class="menu-item-title">Đơn hàng sản phẩm</span>
                        </a>
                    </div>                    
                </div>

                <div class="col-xs-6 col-sm-3 col-md-3">
                    <div class="fix16by9 ">
                        <a class="menu-item" href="/grouptrade/<?php echo $segmentGrt; ?>/listorder/coupon">
                            <i class="fa fa-file-text fa-fw fa-2x"></i><br>
                            <span class="menu-item-title">Đơn hàng coupon</span>
                        </a>
                    </div>
                </div>

                <div class="col-xs-6 col-sm-3 col-md-3">
                    <div class="fix16by9 ">
                        <a class="menu-item" href="<?php echo getAliasDomain(). 'login'; ?>">
                            <i class="fa fa-sign-out fa-fw fa-2x"></i><br>
                            <span class="menu-item-title">Đăng xuất</span>
                        </a>
                    </div>                    
                </div>
                
            </div>
        </div> 
    </div>
</div>
<?php $this->load->view('group/common/footer'); ?>
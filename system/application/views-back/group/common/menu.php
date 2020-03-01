<nav class="navbar navbar-default">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand visible-xs" href="#">Menu nhóm</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
       <ul class="nav nav-sidebar">
            <?php if ($grt_link) { 
                $protocol = "http://";
                $link_grt = $protocol . $grt_link .'.'. $domainName . '/grtshop';
                if($grt_domain != ''){
                    $link_grt = $protocol . $grt_domain . '/grtshop';
                }
            ?>
            <li class="active">
                <a target="_blank" class="btn_shopnow" href="<?php echo $link_grt; ?>">
                    <i class="fa fa-share fa-fw"></i>&nbsp; Xem gian hàng nhóm</i>
                </a>
            </li>
            <?php } ?>
            <li class="<?php echo $menuSelected == 'index' ? 'active' : ''; ?>">
                <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/default"><i class="fa fa-dashboard fa-fw"></i>&nbsp; Bảng điều khiển</a>
            </li>

            <li class="<?php echo $menuSelected == 'updateinfo' ? 'active' : ''; ?>">
                <a href="#"><i class="fa fa-info-circle fa-fw"></i>&nbsp; Thông tin nhóm<span class="fa fa-angle-down pull-right"></span></a>    
                <ul class="nav-child">
                    <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/updatecontact/">Thông tin liên hệ</a>
                    </li>                                       
                    <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/updateadmin/">Phân quyền admin</a>
                    </li>
                    <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/updatestore/">Thông tin kho</a>
                    </li> 
                    <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/updatebank/">Thông tin ngân hàng</a>
                    </li>                                      
                     <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/updatedomain/">Cấu hình domain</a>
                    </li>  
		    <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/updateslideshow/">Cập nhật banner slide</a>
                    </li> 
		    <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/updatebannerfloor/">Cập nhật banner tầng</a>
                    </li>
                </ul>
            </li>

            <li class="<?php echo $menuSelected == 'members' ? 'active' : ''; ?>">
                <a href="#"><i class="fa fa-users fa-fw"></i>&nbsp; Thành viên <span class="fa fa-angle-down pull-right"></span></a>    
                <ul class="nav-child">
                    <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/listmember/">Duyệt thành viên</a>
                    </li>
                    <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/invitemember/">Mời thành viên</a>
                    </li>           
                </ul>
            </li>

            <li class="<?php echo $menuSelected == 'news' ? 'active' : ''; ?>">
                <a href="#"><i class="fa fa-newspaper-o fa-fw"></i>&nbsp; Tin tức<span class="fa fa-angle-down pull-right"></span></a>    
                <ul class="nav-child">
                    <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/approvenews/">Duyệt tin tức</a>
                    </li>               
                </ul>
            </li>

            <li class="<?php echo $menuSelected == 'products' ? 'active' : ''; ?>">
                <a href="#"><i class="fa fa-cubes fa-fw"></i>&nbsp; Sản phẩm <span class="fa fa-angle-down pull-right"></span></a>    
                <ul class="nav-child">
                    <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/approveproduct/">Duyệt sản phẩm</a>
                    </li>           
                </ul>
            </li>

            <li class="<?php echo $menuSelected == 'orders' ? 'active' : ''; ?>">
                <a href="#"><i class="fa fa-file-text-o fa-fw"></i>&nbsp; Đơn hàng <span class="fa fa-angle-down pull-right"></span></a>    
                <ul class="nav-child">
                    <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/listorder/product/">Đơn hàng sản phẩm</a>
                    </li>
                    <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/listorder/coupon/">Đơn hàng coupon</a>
                    </li>            
                </ul>
            </li>

            <li class="<?php echo $menuSelected == 'statistics' ? 'active' : ''; ?>">
                <a href="#"><i class="fa fa-file-text-o fa-fw"></i>&nbsp; Thống kê thu nhập <span class="fa fa-angle-down pull-right"></span></a>    
                <ul class="nav-child">
                    <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/statisticsgeneral/">Thống kê chung</a>
                    </li>
                    <li>
                        <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/statisticsincome/">Thu nhập gian hàng</a>
                    </li>
                    <?php if ($grt_type == 2 || $grt_type == 4) { ?>
                        <li>
                            <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/statisticsadmin/">Thu nhập chủ nhóm</a>
                        </li>
                    <?php } ?>
                    <?php if ($grt_type == 3 || $grt_type == 4) { ?>
                        <li>
                            <a href="<?php echo getAliasDomain(); ?>grouptrade/<?php echo $segmentGrt ?>/statisticsshop/">Thu nhập thuê kênh</a>
                        </li>
                    <?php } ?>
                </ul>
            </li>

        </ul>
    </div><!-- /.navbar-collapse -->
</nav>
<script>
    jQuery(function ($) {
        $('.nav-sidebar > li').click(function () {
            $(this).addClass('focus');
            $('.nav-sidebar > li').not(this).removeClass('focus');
            $(this).find('.nav-child').slideToggle();
            $('.nav-sidebar > li').not(this).find('.nav-child').slideUp();
        });
    });
</script>
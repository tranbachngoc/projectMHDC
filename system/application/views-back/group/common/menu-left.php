

           <nav class="navbar navbar-default">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="true">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand visible-xs" href="#">Danh mục</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="navbar-collapse collapse in" id="bs-example-navbar-collapse-1" aria-expanded="true" style="">
       <ul class="nav nav-sidebar">
            <li class="<?php echo $menuSelected=='product'?'active':'';?>">
                <a href="#"><i class="fa fa-cubes fa-fw"></i>&nbsp; Danh mục sản phẩm<span class="fa fa-angle-down pull-right"></span></a>    
                <ul class="nav-child">
                    <?php foreach($listCategory as $k => $category) {
                        if ($category->cate_type == 0) { ?>
                        <?php $tlink = 'product'; ?>
                            <li>
                                <?php if(!empty($category->child)){ ?>
                                    <span><?php echo $category->cat_name; ?></span>
                                    <ul>
                                        <?php foreach($category->child as $item){ ?>
                                            <li><a href="<?php echo '/grtshop/'.$tlink.'/cat/'.$item->cat_id.'-'.RemoveSign($item->cat_name); ?>"><?php echo $item->cat_name; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                <?php } else { ?>
                                    <a href="<?php echo '/grtshop/'.$tlink.'/cat/'.$category->cat_id.'-'.RemoveSign($category->cat_name); ?>"><?php echo $category->cat_name; ?></a>
                                <?php } ?>
                            </li>
                        <?php }
                    } ?>
                    <li><a class="hover" href="<?php echo '/grtshop/'.$tlink. '/pro_type/0-Tat-ca-san-pham'; ?>">Tất cả sản phẩm</a></li>                  
                </ul>
            </li>
            <li class="<?php echo $menuSelected=='coupon'?'active':'';?>">
                <a href="#"><i class="fa fa-cubes fa-fw"></i>&nbsp; Danh mục Coupon<span class="fa fa-angle-down pull-right"></span></a>    
                <ul class="nav-child">

                    <?php foreach($listCategory as $k => $category) {
                        if ($category->cate_type == 2) { ?>
                        <?php $tlink = 'coupon'; ?>
                            <li>
                                <?php if(!empty($category->child)){ ?>
                                    <span><?php echo $category->cat_name; ?></span>
                                    <ul>
                                        <?php foreach($category->child as $item){?>
                                            <li><a href="<?php echo '/grtshop/'.$tlink.'/cat/'.$item->cat_id.'-'.RemoveSign($item->cat_name); ?>"><?php echo $item->cat_name; ?></a></li>
                                        <?php } ?>
                                    </ul>
                                <?php } else { ?>
                                    <a href="<?php echo '/grtshop/'.$tlink.'/cat/'.$category->cat_id.'-'.RemoveSign($category->cat_name); ?>"><?php echo $category->cat_name; ?></a>
                                <?php } ?>
                            </li>
                        <?php }
                    } ?>
                    <li><a class="hover" href="<?php echo '/grtshop/'.$tlink.'/pro_type/2-Tat-ca-coupon' ?>">Tất cả coupon</a></li>

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


<div class="panel panel-default panel-about hidden-xs">                
    <div class="panel-heading"><i class="fa fa-user fa-fw"></i> Thành viên</div>
    <div class="panel-body">
        <form id="frmLoginPage" class="login-gianhang form" name="frmLoginPage" action="/login" method="post" onsubmit="checkForm(this.name, arrCtrlLogin); return false;">

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                            <input type="text" title="Tên đăng nhập..." class="form-control" placeholder="Tên đăng nhập..." name="UsernameLogin" autocomplete="off">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                            <input type="password" title="Mật khẩu" placeholder="Mật khẩu..." class="form-control" name="PasswordLogin">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="checkbox" id="remember_password" name="remember_password" value="1">
                            <label for="remember_password">&nbsp; Ghi nhớ đăng nhập</label>
                        </div> 
                    </div>
                    <div class="form-group">
                        <div class="form-group">
                            <input type="submit" class="btn btn-primary btn-block style_default" value="Đăng nhập">
                        </div>
                    </div>
                    
                    <?php 
                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                    ?>
                    <div class="lost_password"><a class="text_link" href="<?php echo $protocol.domain_site?>/forgot" rel="nofollow">Bạn quên mật khẩu?</a></div>
                    <input type="hidden" name="user_login" value="login">
                </form>
    </div>    
</div>
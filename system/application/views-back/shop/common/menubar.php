<?php
    #View logo AZIBAI when client go azibai.com
    $c = '//' . domain_site . '/';
    if (strpos($_SERVER['HTTP_REFERER'], $c)) {
	$_SESSION['fromazibai'] = 1;
    }

    if ($_SESSION['fromazibai'] == 1) {
	$classhidden = "";
    } else {
	$classhidden = "hidden";
    }
?>
    <div id="header_news" class="header_fixed" style="padding:10px;">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-3 text-center" style="pading-right:0px">
                <a href="<?php echo $mainURL ?>">
                    <img style="max-height: 34px;" class=" <?php echo $classhidden; ?>" src="/images/logo-azibai-white.png">
                </a>
            </div>
            <div class="col-lg-5 col-md-4 col-sm-4">
                <form id="tintuc_search" class="form-horizontal" action="<?php echo $domain_shop; ?>/news" method="post" >
                    <div class="input-group">
                        <input type="text" class="form-control" name="key" placeholder="Nhập từ khóa tin tức" value="<?php echo $keysearch ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">&nbsp;<i class="fa fa-search fa-fw"></i>&nbsp;</button>
                        </span>
                      </div>
                </form>        
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5" style="pading-left:0px">            
                <?php                                
                if( $this->session->userdata('sessionUser') && strlen($this->session->userdata('sessionAvatar')) > 10 ){ 
                    $avatar = DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $this->session->userdata('sessionAvatar');
                } else {
                   $avatar = site_url('media/images/avatar/default-avatar.png');                     
                }
                ?>                
                <div class="pull-left">
                    <a class="username">
                        <img class="img-circle" src="<?php echo $avatar; ?>" alt="avatar" style="width:34px; height:34px">                                
                        &nbsp; <?php echo $this->session->userdata('sessionUsername') ? $this->session->userdata('sessionUsername') : 'Khách'; ?>
                    </a>
                </div>                
                <style>
                    ul.menu-top-right {margin:0}
                    ul.menu-top-right li { float: left; list-style: none; margin:3px 10px; }
                    ul.menu-top-right li a { display:block; padding:4px; }
                    ul.menu-top-right ul > li { float: none;  margin:0px; padding:0 4px; }
                    ul.menu-top-right .cartNum { position: absolute; top: 0; right: -5px; font-size: 11px; color: white; background: red; width: 16px; text-align: center; border-radius: 10px; font-weight: bold; }
                </style>
                <ul class="menu-top-right pull-right">
                    <li style="position:relative">
                        <a href="/checkout" title="Xem giỏ hàng">
                            <i class="azicon white icon-cart"></i>
                            <span class="cartNum"><?php echo $azitab['cart_num']; ?></span>
                        </a>
                    </li>         
                    <?php if ((int) $this->session->userdata('sessionUser') > 0) { ?>
                        <li>
			    <a href="/logout" title="Đăng xuất">
				<i class="azicon white icon-logout"></i>                        
			    </a>
			</li>		                
                    <?php } else { ?> 
                    <li>
                        <a href="#" title="Đăng nhập" data-toggle="modal" data-target="#myLogin">
                            <i class="azicon white icon-login"></i>
                        </a>
                    </li>
                    <?php } ?>	
                </ul> 
            </div>
        </div>
    </div>

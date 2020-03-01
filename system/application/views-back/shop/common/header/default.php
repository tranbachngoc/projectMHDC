<?php
if ($isAffiliate == TRUE && $siteGlobal->sho_banner == "") {
    $srcbanner = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $Pa_Shop_Global->sho_dir_banner . '/' . $Pa_Shop_Global->sho_banner;
} else {
    $srcbanner = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $siteGlobal->sho_dir_banner . '/' . $siteGlobal->sho_banner;
}

if ($siteGlobal->sho_logo != "") {
    $sho_logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $siteGlobal->sho_dir_logo . '/' . $siteGlobal->sho_logo;;
} else {
    $sho_logo = 'images/no-logo.png';
}
?> 
<?php if ($isMobile == 1) { 
    $this->load->view('shop/common/m_menu');

?>    
    <div class="headerbanner">
		<div class="shop_banner">
			<div class="fix16by9" style="background: url('<?php echo $srcbanner ?>') no-repeat center center / cover"></div>
		</div> 
		<div class="shop_logo text-center">
			<div>            
			<a href="/" style="background: url('<?php echo $sho_logo ?>') no-repeat center center / cover"></a>
			</div>
		</div>
		<div class="shop_name text-center">
			<h1 style="font-size:18px; margin: 20px 0;">
			<a href="/"><?php echo $siteGlobal->sho_name ?></a>
			</h1>
		</div>	
    </div>
<?php } else { ?>
    <nav class="navbar navbar-inverse navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand visible-xs" href="#">Danh mục</a>
            </div>

	    <?php
	    $shop_af = $this->user_model->get('use_group', "use_id = " . (int) $siteGlobal->sho_user);
	    ?>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-center">                           
                    <li class="<?php
		    if (isset($menuSelected) && $menuSelected == 'home') {
			echo 'active';
		    } else {
			echo 'normal';
		    }
		    ?>">
                        <a target="_self" href="/"><span><?php echo $this->lang->line('index_page_menu_detail_global'); ?></span></a>
                    </li>

                    <li class="<?php
		    if (isset($menuSelected) && $menuSelected == 'introduct') {
			echo 'active';
		    } else {
			echo 'normal';
		    }
		    ?>">
                        <a target="_self" href="/shop/introduct"><span><?php echo $this->lang->line('index_page_menu_introduct_global'); ?></span></a>
                    </li>

                    <li class="<?php
		    if (isset($menuSelected) && $menuSelected == 'defaults') {
			echo 'active';
		    } else {
			echo 'normal';
		    }
		    ?>">
                        <a target="_self" href="/shop"><span>Cửa hàng</span></a>
                    </li>

                    <li class="dropdown <?php
		    if (isset($url) && $url == 'product') {
			echo 'active';
		    } else {
			echo 'normal db_li';
		    }
		    ?>">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
			    <?php echo $this->lang->line('product_menu_detail_global'); ?><span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu db_menu_2">
			    <?php if ($shop_af->use_group == 2) { ?>
				<li><a href="/shop/san-pham-tu-gian-hang/">Sản phẩm từ Gian hàng</a>
				</li>
			    <?php } ?>                                    
			    <?php
			    foreach ($listCategory as $k => $category) {
				if ($category->cate_type == 0) {
				    ?>
	    			<li>
					<?php if (!empty($category->child)) { ?>
					    <span><?php echo $category->cat_name; ?></span>
					    <ul>
						<?php foreach ($category->child as $item) { ?>
		    				<li><a href="<?php echo '/shop/' . $tlink . '/cat/' . $item->cat_id . '-' . RemoveSign($item->cat_name); ?>"><?php echo $item->cat_name; ?></a></li>
						<?php } ?>
					    </ul>
					<?php } else { ?>
					    <a href="<?php echo '/shop/' . $tlink . '/cat/' . $category->cat_id . '-' . RemoveSign($category->cat_name); ?>"><?php echo $category->cat_name; ?></a>
					<?php } ?>
	    			</li>
				    <?php
				}
			    }
			    ?>
                            <li><?php if ($shop_af->use_group == 2) { ?>
				    <a class="hover" href="<?php echo '/shop/' . $tlink . '/pro_type/0-Tat-ca-san-pham' ?>">Xem tất cả sản phẩm</a></li>
			    <?php } else { ?>
				<a class="hover" href="<?php echo '/shop/' . $tlink ?>">Xem tất cả sản phẩm</a></li>
		    <?php } ?>
                </ul>
                </li>

		<?php if (serviceConfig == 1) { ?>
		    <li class="dropdown <?php echo $url == 'services' ? 'active' : 'normal db_li'; ?>">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
			    Dịch vụ <span class="caret"></span>
			</a>

			<ul class="dropdown-menu db_menu_2">
			    <?php if ($shop_af->use_group == 2) { ?>
	    		    <li><a href="/shop/dich-vu-tu-gian-hang/">Dịch vụ từ Gian hàng</a></li>
			    <?php } ?>
			    <?php
			    foreach ($listCategory as $k => $category) {
				if ($category->cate_type == 1) {
				    ?>
				    <li>
					<?php if (!empty($category->child)) { ?>
		    			<span><?php echo $category->cat_name; ?></span>
		    			<ul>
						<?php foreach ($category->child as $item) { ?>
						    <li><a href="<?php echo '/shop/services/cat/' . $item->cat_id . '-' . RemoveSign($item->cat_name); ?>"><?php echo $item->cat_name; ?></a></li>
						<?php } ?>
		    			</ul>
					<?php } else { ?>
		    			<a href="<?php echo '/shop/services/cat/' . $category->cat_id . '-' . RemoveSign($category->cat_name); ?>"><?php echo $category->cat_name; ?></a>
					<?php } ?>
				    </li>
				    <?php
				}
			    }
			    ?>
			    <li><a class="hover" href="<?php echo '/shop/services'; ?>">Xem tất cả dịch vụ</a></li>
			</ul>
		    </li>
		<?php } ?>

                <li class="dropdown <?php echo $url == 'coupon' ? 'active' : 'normal'; ?>"><a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        Coupon<span class="caret"></span>
                    </a>

                    <ul class="dropdown-menu db_menu_2">                           
			<?php
			foreach ($listCategory as $k => $category) {
			    if ($category->cate_type == 2) {
				?>
	    		    <li>
				    <?php if (!empty($category->child)) { ?>
					<span><?php echo $category->cat_name; ?></span>
					<ul>
					    <?php foreach ($category->child as $item) { ?>
		    			    <li><a href="<?php echo '/shop/' . $afLink . '/cat/' . $item->cat_id . '-' . RemoveSign($item->cat_name); ?>"><?php echo $item->cat_name; ?></a></li>
					    <?php } ?>
					</ul>
				    <?php } else { ?>
					<a href="<?php echo '/shop/' . $afLink . '/cat/' . $category->cat_id . '-' . RemoveSign($category->cat_name); ?>"><?php echo $category->cat_name; ?></a>
				    <?php } ?>
	    		    </li>
				<?php
			    }
			}
			?>

			<?php if ($shop_af->use_group == 2) { ?>
			    <li><a class="hover" href="<?php echo '/shop/' . $afLink . '/pro_type/2-Tat-ca-coupon' ?>">Xem tất cả coupon</a></li>
			<?php } else { ?>
			    <li><a class="hover" href="<?php echo '/shop/' . $afLink ?>">Xem tất cả coupon</a></li>
			<?php } ?>
                    </ul>
                </li>                       
		<?php if ($shop_af->use_group != 2) { ?>
		    <li class="<?php
		    if (isset($menuSelected) && $menuSelected == 'warranty') {
			echo 'active';
		    } else {
			echo 'normal db_li';
		    }
		    ?>">
			<a target="_self" href="/shop/warranty"><span><?php echo $this->lang->line('ads_menu_warranty_global'); ?></span></a>
		    </li>
		<?php } ?>                      

                <li class="<?php
		if (isset($menuSelected) && $menuSelected == 'contact') {
		    echo 'active';
		} else {
		    echo 'normal';
		}
		?>">
                    <a target="_self" href="/shop/contact"><span><?php echo $this->lang->line('contact_menu_detail_global'); ?></span></a>
                </li>


                
    		<li> <a class="back_home" target="_blank" href="<?php echo $mainURL; ?>"><span>Azibai</span></a> </li>
		    <?php if ($this->session->userdata('sessionUser') > 0) { ?> 
	                <li class="dropdown">
	                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user fa-fw"></i> <?php echo $this->session->userdata('sessionUsername'); ?></a>
	                    <ul class="dropdown-menu"> 
	                        <li><a href="//<?php echo domain_site ?>/account/edit"><i class="fa fa-user fa-fw"></i> Thông tin cá nhân </a></li>
				<?php if ($this->session->userdata('sessionUser') == $siteGlobal->sho_user) { ?>
	                            <li><a href="//<?php echo domain_site ?>/account/shop"><i class="fa fa-dashboard fa-fw"></i> Quản trị gian hàng</a></li>
				<?php } ?>
	                        <li><a href="/logout"><i class="fa fa-sign-out fa-fw"></i> Đăng xuất</a></li>
	                    </ul>
	                </li>
		    <?php } else { ?>
	                <li> <a href="#" data-toggle="modal" data-target="#myLogin"> Đăng nhập</a></li>
		    <?php } ?> 
                    <li><a href="/checkout"><i class="fa fa-shopping-cart fa-fw"></i>&nbsp;<span class="cartNum badge"><?php echo $azitab['cart_num']; ?></span></a></li>
                </ul>



            </div>
        </div>
    </nav>
    <div style="margin-bottom: 20px;">
        <div class="container">
            <div class="row">
                <div class="col-md-4 text-left">
                   
                </div>  
                <div class="col-md-4 text-center">          
                    <a id="brand" href="/">                        
			<?php
			$shop_logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $siteGlobal->sho_dir_logo . '/' . $siteGlobal->sho_logo;
			?>
			<?php if ($siteGlobal->sho_logo) { ?>
			    <img alt="<?php echo $siteGlobal->sho_name; ?>" src="<?php echo $shop_logo; ?>" border="0" style="max-height:70px;" />
			<?php } else { ?>
			    <img src="/images/logo-azibai.png" border="0" style="max-height:70px;" />
			<?php } ?>
                    </a>                
                </div>
                <div class="col-md-4 text-right">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="headerbanner">
        <div class="shop_banner">
	    <div class="fix3by1" style="background: url('<?php echo $srcbanner ?>') no-repeat center center / cover"></div>
        </div>
    </div>
<?php } ?>


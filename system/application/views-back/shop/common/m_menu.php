<?php 
	##View logo AZIBAI when client go azibai.com
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
<div id="header_news" class="header_fixed">
    <ul class="menu-azinet-top"> 
	<li class="<?php echo $classhidden ?>">
	    <a href="<?php echo $mainURL; ?>">
		<i class="azicon icon-azibai"></i>
	    </a>
	</li>
	<?php if ($packId1 == true) { ?>
    	<li><a href="<?php echo $mainURL . 'register/affiliate/pid/' . $this->session->userdata('sessionUser'); ?>">
		<i class="azicon icon-regisaff"></i> 
	    </a>
	</li>
	<?php } else { ?> 
	    <?php if ($packId2 == true) { ?>
		<li>
		    <a href="<?php echo $mainURL . 'register/affiliate/pid/' . $siteGlobal->sho_user; ?>">
			<i class="azicon icon-regisaff"></i> 
		    </a>
		</li>
	    <?php } ?>
	<?php } ?>
	<?php if ($this->uri->segment(1) == 'shop') { ?>	    
	<li>
	    <a href="/">
		<i class="azicon icon-home"></i>
	    </a>
	</li>
	<?php } else { ?> 
	<li><a href="/shop/">
		<i class="azicon icon-store"></i>
	    </a>
	</li>
	<?php } ?>
	<li>
	    <a href="/checkout/" title="Giỏ hàng">
		<i class="azicon icon-cart"></i>		
	    </a>
	</li>

	<li class="dropdown">
	    <a href="#" data-toggle="dropdown">
		<i class="azicon icon-search"></i>
	    </a>
	    <ul class="dropdown-menu" style="width:100%">
		<li>
		    <div style="padding:10px;">
			<form id="search" class="form">
			    <input class="form-control" name="search"></input>
			</form>
		    </div>
		</li>
	    </ul>
	</li>

	<li class="dropdown">
	    <a href="#" data-toggle="dropdown">
		<i class="azicon icon-bars"></i>
	    </a>
	    <ul class="dropdown-menu" style="width:100%;">
	    
	    
		<?php if ($this->session->userdata('sessionUser')) { ?>
		    <li>
			<a class="hint--left" data-hint="Chào" href="<?php echo $mainURL ?>/account" title="Chào">
			    <i class="azicon icon-user"></i> &nbsp; Chào <strong><?php echo $this->session->userdata('sessionUsername') ?></strong>
			</a>
		    </li>  
		    <li>
			<a class="hint--left" data-hint="Đăng xuất" href="/logout" title="Đăng xuất">
			    <i class="azicon icon-logout"></i> &nbsp; Đăng xuất                        
			</a>
		    </li>
		<?php } else { ?>
		    <li>
			<a class="hint--left" data-hint="Đăng nhập" href="/login/" title="Đăng nhập">
			    <i class="azicon icon-login"></i> &nbsp; Đăng nhập                        
			</a>
		    </li>
		    <li>
			<a class="hint--left" data-hint="Đăng kí" href="/logout/" title="Đăng kí">
			    <i class="azicon icon-user-key"></i> &nbsp; Đăng kí thành viên                      
			</a>
		    </li>                            
		<?php } ?>
		    
	    
	    <?php if ($this->uri->segment(1) == 'shop') { ?>		
		<li>
		    <a href="/shop/introduct/" title="Giới thiệu">
			<i class="azicon icon-info-circle"></i> 
			&nbsp; Giới thiệu     
		    </a>
		</li>
		<li>
		    <a href="/shop/product/" title="Sản phẩm">
			<i class="azicon icon-cube"></i> &nbsp; Sản phẩm     
		    </a>
		</li>
		<li>
		    <a href="/shop/coupon/" title="Coupon">
			<i class="azicon icon-tag"></i> &nbsp; Coupon     
		    </a>
		</li>
		<!-- <li>
		    <a href="/shop/warranty/" title="Chính sách">
			<i class="azicon icon-list-square"></i> &nbsp; Chính sách     
		    </a>
		</li> -->
		<li>
		    <a href="/shop/contact" title="Liên hệ">
			<i class="azicon icon-email"></i> &nbsp; Liên hệ   
		    </a>
		</li>
	    <?php } ?>
	    </ul>
	    
	</li>  


    </ul>
</div>
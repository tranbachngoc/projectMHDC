<div style="height:40px"></div>
<ul class="menu-mobile"> 
    	    <li>
    		<a href="//<?php echo domain_site ?>">
    		    <img src="/templates/home/icons/black/icon-azibai.png" alt="icon-azibai">
    		</a>
    	    </li>
	    <?php if( $this->uri->segment(2)=='product' || $this->uri->segment(2)=='coupon' ) { ?>
    	    <li>
    		<a href="/flatform/news" title="Tin tức">
		    <img src="/templates/home/icons/black/icon-newspaper.png" alt="icon-store">
    		</a>
    	    </li>
	    <?php } else { ?>
	    <li>
    		<a href="/flatform/product" title="Sản phẩm">
		    <img src="/templates/home/icons/black/icon-store.png" alt="icon-store">
    		</a>
    	    </li>
	    <?php } ?>
	    <li>
    		<a href="#" title="Giỏ hàng">
    		    <img src="/templates/home/icons/black/icon-cart.png" alt="icon-cart">
    		</a>
    	    </li>    	    

    	    <li class="dropdown"> 
    		<a id="dropdownMenu4" href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
    		    <img src="/templates/home/icons/black/icon-search.png" alt="icon-search"> 
    		</a>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenu4">
    		    <li>                    
    			<form id="search_tintuc_2" class="form-horizontal" action="" method="get">                            
    			    <div style="margin:10px;">
    				<div class="input-group">
    				    <input name="keyword" id="keyword" class="form-control" type="text" value="" placeholder="Tìm kiếm">
    				    <span class="input-group-btn">
    					<button class="btn btn-primary" type="submit">&nbsp;<i class="fa fa-search"></i>&nbsp;</button>
    				    </span>
    				</div>
    			    </div>
    			</form>
    		    </li>
    		</ul>
    	    </li>

	    <li class="dropdown">
		<a class="dropdown-toggle" type="button" id="dropdownMenu5" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		    <img src="/templates/home/icons/black/icon-bars.png" alt="icon-bars">		
		</a>
		<ul class="dropdown-menu" aria-labelledby="dropdownMenu5">
		    <?php
		    if (isset($currentuser) && $currentuser) {
			if ($currentuser->avatar != '') {
			    $avatar = DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $currentuser->avatar;
			} else {
			    $avatar = site_url('media/images/avatar/default-avatar.png');
			}
			?>
			<li>
			    <a href="#">
				<img class="img-circle" src="<?php echo $avatar; ?>" alt="account" style="width:20px; height:20px"/> &nbsp; <?php echo $this->session->userdata('sessionUsername'); ?>
			    </a>
			</li>
			<li><a href="/flatform/about"><img src="/templates/home/icons/black/bookmarks.png" alt="icon-bookmarks"/> &nbsp; Giới thiệu</a></li>
			<li><a href="/flatform/product"><img src="/templates/home/icons/black/cubes.png" alt="icon-bookmarks"/> &nbsp; Sản phẩm</a></li>
			<li><a href="/flatform/coupon"><img src="/templates/home/icons/black/icon-coupon.png" alt="icon-coupon"/> &nbsp; Coupon</a></li>
			<li><a href="/flatform/contact"><img src="/templates/home/icons/black/icon-email.png" alt="icon-email"/> &nbsp; Liên hệ</a></li>
			<li>
			    <a href="/logout">
				<img src="/templates/home/icons/black/icon-logout.png" alt="icon-logout"/> &nbsp; Đăng xuất
			    </a>
			</li>
		    <?php } else { ?>
			<li><a href="/flatform/about"><img src="/templates/home/icons/black/bookmarks.png" alt="icon-bookmarks"/> &nbsp; Giới thiệu</a></li>
			<li><a href="/flatform/product"><img src="/templates/home/icons/black/cubes.png" alt="icon-bookmarks"/> &nbsp; Sản phẩm</a></li>
			<li><a href="/flatform/coupon"><img src="/templates/home/icons/black/icon-coupon.png" alt="icon-coupon"/> &nbsp; Coupon</a></li>
			<li><a href="/flatform/contact"><img src="/templates/home/icons/black/icon-email.png" alt="icon-email"/> &nbsp; Liên hệ</a></li>
			<li><a href="/login"><img src="/templates/home/icons/black/icon-login.png" alt="icon-user"/> &nbsp; Đăng nhập</a></li>		    
		    <?php } ?>
		    
		</ul>
	    </li>
    	</ul>
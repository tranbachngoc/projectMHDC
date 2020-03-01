<div class="fixtoscroll">
    <ul class="nav mainmenu">
	<li class="active">
	    <a href="/flatform/news/">Tin tức</a>
	</li>
	<li>
	    <a href="/flatform/about">Giới thiệu</a>
	</li>
	<li>
	    <a href="/flatform/product/">Sản phẩm</a>
	</li>
	<li>
	    <a href="/flatform/coupon">Coupon</a>
	</li>
	<li>
	    <a href="/flatform/contact/">Liên hệ</a>
	</li>
	<?php
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	?>
	<li>
	    <a target="_blank" href="<?php echo getAliasDomain(); ?>">Azibai</a>
	</li>
    </ul>
</div>


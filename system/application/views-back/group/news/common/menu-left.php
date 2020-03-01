<div class="panel panel-default panel-mobile fixtoscroll">                
    <div class="panel-heading"><?php echo $get_grt->grt_name; ?></div>    
    <div class="panel-body">
        <ul class="nav nav-sidebar">
            <li> <a href="/grtnews">Trang chủ</a> </li>
            
            <li> <a href="/grtshop/introduction">Giới thiệu</a> </li>

            <li> <a href="/grtshop">Cửa hàng</a> </li>
<!--            
            <li>
                <a href="#">Sản phẩm<span class="fa fa-angle-down pull-right"></span></a>    
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

            <li>
                <a href="#">Coupon <span class="fa fa-angle-down pull-right"></span></a>    
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
            -->
            <li> <a href="/grtshop/contact">Liên hệ</a> </li>
            <li> <a href="<?php echo $mainURL; ?>">Azibai</a> </li>
        </ul>
    </div>    
</div>
<script>
	jQuery(function ($) {
		$('.nav-sidebar > li').click(function () {
			$(this).find('.nav-child').slideToggle();
			$('.nav-sidebar > li').not(this).find('.nav-child').slideUp();
		});
	});
</script>

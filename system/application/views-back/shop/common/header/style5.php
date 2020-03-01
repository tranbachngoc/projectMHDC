
<div class="headertop">
</div>
<div class="headerbottom" style="border-bottom: 1px solid #ddd;">
    <div class="container">
        <div class="row">
           <div class="col-lg-2 col-md-3 text-center">
                <h1 id="brand">
                    <?php $logo  = '/media/shop/logos/'.$siteGlobal->sho_dir_logo.'/'.$siteGlobal->sho_logo;?>
                    <a href="/">
                        <?php if ($siteGlobal->sho_logo) {?>
                            <img alt="<?php echo $siteGlobal->sho_name; ?>" src="<?php echo $logo; ?>" border="0" height="70"  />
                        <?php } else {?>
                            <img src="/images/logo-azibai.png" alt="">
                        <?php } ?>
                    </a>
                </h1>
            </div>

            <div class="col-lg-10 col-md-9">
                <div class="text-right" style="padding: 5px 0">
                    <?php if($package > 1): ?>
                        <span  style="color:orangered"><i class="fa fa-check fa-fw"></i>
                        <?php if($package == 2){ echo "Gian hàng chuyên nghiệp"; }
                        else{echo "gian hàng đảm bảo";} ?></span>
                    <?php endif; ?>&nbsp;&nbsp;&nbsp;
                    <i class="fa fa-phone-square fa-fw"></i> <?php echo $siteGlobal->sho_mobile;?>&nbsp;&nbsp;&nbsp;<a href="/checkout"><i class="fa fa-shopping-cart fa-fw"></i> Giỏ hàng &nbsp;<span class="cartNum badge"><?php echo $azitab['cart_num'];?></span></a>
                    <?php if((int)$this->session->userdata('sessionUser') >0 ){?>
                        &nbsp;&nbsp;&nbsp;<a target="_blank" href="<?php echo $mainURL; ?>account"><i class="fa fa-external-link"></i> Quản trị</a>
                    <?php }?>

                </div>
                <nav class="navbar navbar-default ">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand visible-xs" href="#">Danh mục menu</a>
                    </div>

                    <?php
                        $shop_af = $this->user_model->get('use_group', "use_id = " . (int)$siteGlobal->sho_user);
                    ?>
                    <div class="collapse navbar-collapse" id="myNavbar">
                        <ul class="nav navbar-nav nav-justified">
                            <li class="<?php if(isset($menuSelected) && $menuSelected == 'home'){echo 'active db_active';}else{echo 'normal db_li';} ?>">
                                    <a target="_self" href="/"><span><?php echo $this->lang->line('index_page_menu_detail_global'); ?></span></a>
                            </li>

                            <li class="<?php if(isset($menuSelected) && $menuSelected == 'introduct'){echo 'active db_active';}else{echo 'normal db_li';} ?>"><a target="_self" href="/shop/introduct"><span><?php echo $this->lang->line('index_page_menu_introduct_global'); ?></span></a>
                            </li>

                            <li class="<?php if (isset($menuSelected) && $menuSelected == 'defaults') { echo 'active'; } else { echo 'normal'; } ?>">
                                <a target="_self" href="/shop"><span>Cửa hàng</span></a>
                            </li>

                            <?php $url = $this->uri->segment(3); ?>
                            <li class="dropdown <?php if((isset($menuSelected) && $menuSelected == 'product' && $url =='cat') ||(isset($menuSelected) && $menuSelected == 'product' && $url =='') ){echo 'active';}else{echo 'normal db_li';} ?>">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    <?php echo $this->lang->line('product_menu_detail_global'); ?><span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu db_menu_2">
                                    <?php  if($shop_af->use_group == 2) { ?>
                                        <li><a href="/shop/san-pham-tu-gian-hang/">Sản
                                                phẩm từ Gian hàng</a></li>
                                    <?php } ?>
                                    <?php foreach($listCategory as $k => $category){ ?>
                                        <?php if($category->cate_type == 0) { ?>
                                            <li>
                                                <?php if(!empty($category->child)) { ?>
                                                    <span><?php echo $category->cat_name; ?></span>
                                                    <ul>
                                                        <?php foreach($category->child as $item){ ?>
                                                            <li><a href="<?php echo '/shop/'.$tlink.'/cat/'.$item->cat_id.'-'.RemoveSign($item->cat_name); ?>"><?php echo $item->cat_name; ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } else { ?>
                                                    <a href="<?php echo '/shop/'.$tlink.'/cat/'.$category->cat_id.'-'.RemoveSign($category->cat_name); ?>"><?php echo $category->cat_name; ?></a>
                                                <?php } ?>
                                            </li>
                                        <?php } ?>
                                    <?php } ?>
                                    <li><?php if($shop_af->use_group == 2) { ?>
                                        <a class="hover" href="<?php echo '/shop/'.$tlink.'/pro_type/0-Tat-ca-san-pham' ?>">Xem tất cả sản phẩm</a></li>
                                    <?php } else { ?>
                                        <a class="hover" href="<?php echo '/shop/'.$tlink?>">Xem tất cả sản phẩm</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                            
                            <?php if(serviceConfig == 1){ ?>
                            <li class="dropdown <?php echo $url == 'services' ? 'active': 'normal db_li'; ?>">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    Dịch vụ<span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu db_menu_2">
                                    <?php if($shop_af->use_group == 2) { ?>
                                        <li><a href="/shop/dich-vu-tu-gian-hang/">Dịch vụ từ Gian hàng</a></li>
                                    <?php } ?>
                                    <?php foreach($listCategory as $k => $category) {
                                        if ($category->cate_type == 1) { ?>
                                            <li>
                                                <?php if(!empty($category->child)){?>
                                                    <span><?php echo $category->cat_name; ?></span>
                                                    <ul>
                                                        <?php foreach($category->child as $item){ ?>
                                                            <li><a href="<?php echo '/shop/services/cat/'.$item->cat_id.'-'.RemoveSign($item->cat_name); ?>"><?php echo $item->cat_name; ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php }else{?>
                                                    <a href="<?php echo '/shop/services/cat/'.$category->cat_id.'-'.RemoveSign($category->cat_name); ?>"><?php echo $category->cat_name; ?></a>
                                                <?php }?>
                                            </li>
                                        <?php } }?>
                                    <li><a class="hover" href="<?php echo '/shop/services'; ?>">Xem tất cả dịch vụ</a></li>
                                </ul>
                            </li>
                            <?php } ?>


                            <li class="dropdown <?php echo $url == 'coupon' ? 'active': 'normal db_li'; ?>">
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                    Coupon<span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu db_menu_2">
                                    <?php  if($shop_af->use_group == 2) { ?>
                                        <li><a href="/shop/coupon-tu-gian-hang/">Coupon từ Gian hàng</a></li>
                                    <?php } ?>
                                    <?php foreach($listCategory as $k => $category) {
                                        if ($category->cate_type == 2) { ?>
                                            <li>
                                                <?php if(!empty($category->child)){ ?>
                                                    <span><?php echo $category->cat_name; ?></span>
                                                    <ul>
                                                        <?php foreach($category->child as $item){?>
                                                            <li><a href="<?php echo '/shop/'.$afLink.'/cat/'.$item->cat_id.'-'.RemoveSign($item->cat_name); ?>"><?php echo $item->cat_name; ?></a></li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } else { ?>
                                                    <a href="<?php echo '/shop/'.$afLink.'/cat/'.$category->cat_id.'-'.RemoveSign($category->cat_name); ?>"><?php echo $category->cat_name; ?></a>
                                                <?php } ?>
                                            </li>
                                        <?php } } ?>
                                    <li><?php if($shop_af->use_group == 2) { ?>
                                        <a class="hover" href="<?php echo '/shop/'.$afLink.'/pro_type/2-Tat-ca-coupon' ?>">Xem tất cả coupon</a></li>
                                    <?php } else { ?>
                                        <a class="hover" href="<?php echo '/shop/'.$afLink?>">Xem tất cả coupon</a></li>
                                    <?php } ?>
                                </ul>
                            </li>
                           
                            <?php if($shop_af->use_group != 2){ ?>
                                <li class="<?php if(isset($menuSelected) && $menuSelected == 'warranty'){echo 'active';}else{echo 'normal db_li';} ?>">
                                    <a target="_self" href="/shop/warranty"><span><?php echo $this->lang->line('ads_menu_warranty_global'); ?></span></a>
                                </li>
                            <?php } ?>

                            <li class="<?php if(isset($menuSelected) && $menuSelected == 'contact'){echo 'active';}else{echo 'normal db_li';} ?>">
                                <a target="_self" href="/shop/contact"><span><?php echo $this->lang->line('contact_menu_detail_global'); ?></span></a>
                            </li>
                            <li class="<?php if(isset($menuSelected) && $menuSelected == 'contact'){echo 'active';}else{echo 'normal db_li';} ?>">
                                <a class="back_home" target="_blank" href="<?php echo $mainURL; ?>"><span>Azibai</span></a>
                            </li>
                            <?php if($siteGlobal->sho_guarantee){ ?>
                                <li class="estore_verified"><a>Gian hàng đảm bảo</a></li>
                            <?php } ?>                        
                        </ul>

                    </div>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="headerbanner">
    <div class="" style=" margin-bottom:  30px; text-align:center;">
        <?php if($siteGlobal->sho_banner && file_exists('media/shop/banners/'.$siteGlobal->sho_dir_banner.'/'.$siteGlobal->sho_banner)) {
            $srcbanner = site_url('media/shop/banners/'.$siteGlobal->sho_dir_banner.'/'.$siteGlobal->sho_banner);
        } else {
            $srcbanner = site_url('media/banners/default/default_980_250.jpg');
        } ?>
        <div class="fix3by1" style="background: url('<?php echo $srcbanner ?>') no-repeat center / 100% auto;"></div>
    </div>
</div>
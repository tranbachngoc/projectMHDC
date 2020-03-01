<?php
$shop_af = $this->user_model->get('use_group', "use_id = " . (int) $siteGlobal->sho_user);

$filelogo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $siteGlobal->sho_dir_logo . '/' . $siteGlobal->sho_logo;
if ($siteGlobal->sho_logo != "") {
    $sho_logo = $filelogo;
} else {
    $sho_logo = 'images/no-logo.png';
}
$srcbanner = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $siteGlobal->sho_dir_banner . '/' . $siteGlobal->sho_banner;
if ($isAffiliate == TRUE && $siteGlobal->sho_dir_banner == 'defaults') {
    $srcbanner = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $Pa_Shop_Global->sho_dir_banner . '/' . $Pa_Shop_Global->sho_banner;
}
?>

<?php if ($isMobile == 0) { ?>
    <div class="headertop">
        <div class="container">
            <div class="row"> 
                
                <div class="col-sm-4">
                    <div style="margin:20px 0">
                        <a href="/">
                            <?php if ($siteGlobal->sho_logo != "") { ?>
                                <img alt="<?php echo $siteGlobal->sho_name; ?>" src="<?php echo $sho_logo; ?>" height="75"  />
                            <?php } else { ?>
                                <img alt="<?php echo $siteGlobal->sho_name; ?>" src="/images/logo-azibai.png" height="75">
                            <?php } ?> 
                        </a>
                    </div>
                </div>
                <div class="col-sm-8">
                    <ul class="list-inline text-right" style="margin-top:45px">
                        <li><a href="/checkout"><i class="fa fa-shopping-cart fa-fw"></i> Giỏ hàng <span class="cartNum badge"><?php echo $azitab['cart_num']; ?></span></a></li>
                        <li><a href="tel:<?php echo $siteGlobal->sho_mobile ?>"><i class="fa fa-phone-square fa-fw"></i> <?php echo $siteGlobal->sho_mobile ?></a></li>

                        <?php if ($this->session->userdata('sessionUser') > 0) { ?>
                        <li><i class="fa fa-user fa-fw"></i> <?php echo $this->session->userdata('sessionUsername'); ?></li>
                        <li><a class="navbar-link" href="/logout"> <i class="fa fa-sign-out fa-fw"></i> Đăng xuất</a></li>
                        <?php } else { ?>
                        <li>    <a href="#" data-toggle="modal" data-target="#myLogin"><i class="fa fa-sign-in fa-fw"></i> Đăng nhập</a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <div class="rowbottom">
        <nav class="navbar navbar-default">
            <div class="container"><div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand visible-xs" href="#"></a>
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="<?php
                            if (isset($menuSelected) && $menuSelected == 'home') {
                                echo 'active';
                            } else {
                                echo 'normal';
                            }
                            ?>">
                            <a target="_self" href="/">
                                <i class="fa fa-home fa-fw"></i>
                                <span><?php echo $this->lang->line('index_page_menu_detail_global'); ?></span>
                            </a>
                        </li>

                        <li class="<?php
                        if (isset($menuSelected) && $menuSelected == 'introduct') {
                            echo 'active';
                        } else {
                            echo 'normal';
                        }
                            ?>">
                            <a target="_self" href="/shop/introduct">
                                <i class="fa fa-info-circle fa-fw"></i>
                                <span><?php echo $this->lang->line('index_page_menu_introduct_global'); ?></span>
                            </a>
                        </li>

                        <li class="<?php
                        if (isset($menuSelected) && $menuSelected == 'defaults') {
                            echo 'active';
                        } else {
                            echo 'normal';
                        }
                            ?>">
                            <a target="_self" href="/shop">
                                <i class="fa fa-university fa-fw"></i>
                                <span>Cửa hàng</span>
                            </a>
                        </li>

                        <?php $url = $this->uri->segment(2); ?>
                        <li class="dropdown <?php
                        if (isset($url) && $url == 'product') {
                            echo 'active';
                        } else {
                            echo 'normal db_li';
                        }
                        ?>">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="/">
                                <i class="fa fa-cubes fa-fw"></i> 
                                <span><?php echo $this->lang->line('product_menu_detail_global'); ?></span>
                                <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu db_menu_2">
                                <?php if ($shop_af->use_group == 2) { ?>
                                    <li><a href="/shop/san-pham-tu-gian-hang/">Sản
                                            phẩm từ Gian hàng</a></li>
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
                                <i class="fa fa-hand-o-up fa-fw"></i> Dịch vụ<span class="caret"></span>
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
                                                        <li><a href="<?php echo 'shop/services/cat/' . $item->cat_id . '-' . RemoveSign($item->cat_name); ?>"><?php echo $item->cat_name; ?></a></li>
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
                    <li class="dropdown <?php echo $url == 'coupon' ? 'active' : 'normal'; ?>">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="/">
                            <i class="fa fa-tags fa-fw"></i> <span>Coupon</span> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu db_menu_2">
                            <?php if ($shop_af->use_group == 2) { ?>
                                <li><a href="/shop/coupon-tu-gian-hang/">Coupon từ Gian hàng</a></li>
                            <?php } ?>
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
                            <li><?php if ($shop_af->use_group == 2) { ?>
                                    <a class="hover" href="<?php echo '/shop/' . $afLink . '/pro_type/2-Tat-ca-coupon' ?>">Xem tất cả coupon</a></li>
                            <?php } else { ?>
                                <a class="hover" href="<?php echo '/shop/' . $afLink ?>">Xem tất cả coupon</a></li>
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
                            <a target="_self" href="/shop/warranty">
                                <i class="fa fa-file-text fa-fw"></i>
                                <span><?php echo $this->lang->line('ads_menu_warranty_global'); ?></span>
                            </a>
                        </li>
                    <?php } ?>                        

                    <li class="<?php
                    if (isset($menuSelected) && $menuSelected == 'contact') {
                        echo 'active';
                    } else {
                        echo 'normal';
                    }
                    ?>">
                        <a target="_self" href="/shop/contact">
                            <i class="fa fa-envelope fa-fw"></i>
                            <span><?php echo $this->lang->line('contact_menu_detail_global'); ?></span>
                        </a>
                    </li>

                    <?php if ($siteGlobal->sho_guarantee) { ?>
                        <li class="estore_verified"><a>Gian hàng đảm bảo</a></li>
                    <?php } ?>


                    <li><a class="back_home" target="_blank" href="<?php echo $mainURL; ?>">
                             <i class="fa fa-arrow-right fa-fw"></i>
                             <span>Azibai</span>
                        </a>
                    </li>

                    </ul>
                </div>
            </div>
        </nav>



    </div>
    <div class="rowbanner" style="margin: 30px 0; text-align:center;">
        <div class="container">
            <div class="shop_banner">
                <div class="fix3by1" style="background: url('<?php echo $srcbanner ?>') no-repeat center center / cover"></div>
            </div> 
        </div>
    </div>





<?php } else { 
    $this->load->view('shop/common/m_menu'); ?>
    <div class="headerbanner">
        <div class="shop_banner text-center">
            <div class="fix16by9" style="background: url('<?php echo $srcbanner ?>') no-repeat center / cover"></div>
        </div>
        <div class="shop_logo text-center">
            <div style="vertical-align: middle; display: table-cell; width:100px; height:100px;">            
                <a href="/" style=" border: 1px solid #f9f9f9; display: block; height:100%; 
                   background: url('<?php echo $sho_logo; ?>') no-repeat center center / 100% auto">
                </a>
            </div>
        </div>
        <div class="shop_name text-center">
            <h1 style="font-size:18px; margin: 20px 0;">
                <a href="/"><?php echo $siteGlobal->sho_name ?></a>
            </h1>
        </div>
    </div>
<?php } ?>
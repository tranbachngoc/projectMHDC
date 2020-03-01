<?php $this->load->view('shop/common/header'); ?>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('.image_boxpro').mouseover(function () {
                tooltipPicture(this, jQuery(this).attr('id'));
            });
        });
    </script>
<?php if (isset($siteGlobal)) { ?>
    <!--BEGIN: Center-->
    <div class="container" id="cat_shop">
        <div class="row">
            <div class="col-xs-12">
                <?php

                $global_sholink='';
                if($UserGroup != AffiliateUser){
                    $global_sholink = '/'.$siteGlobal->sho_link;
                }

                $url = $this->uri->segment(2);
                if ($url == 'services' || $url == 'afsevices'){
                    $DM = 'Dịch vụ';
                }elseif($url == 'coupon' || $url == 'afcoupon'){
                    $DM = 'Coupon';
                    $tc = 'Xem tất cả Coupon';
                    $pro_type = '2-Tat-ca-coupon';
                }elseif($url =='product' || $url == 'afproduct'){
                    $DM = 'Sản phẩm';
                    $tc = 'Xem tất cả Sản phẩm';
                    $pro_type = '0-Tat-ca-san-pham';
                }else{
                    $DM = 'Danh mục';
                    $tc = 'Xem tất cả Sản phẩm';
                }

                if ($this->uri->segment(4) == 'pro_type' || $this->uri->segment(3) == 'pro_type') {
                    if ($this->uri->segment(5) == '2-Tat-ca-san-pham' || $this->uri->segment(4) == '2-Tat-ca-san-pham')
                        $urlRoot = 'Tất cả coupon';
                    else
                        $urlRoot = 'Tất cả sản phẩm';
                } else {
                    $urlRoot = $category_name->cat_name;
                }
                ?>

                <ol id="breadcrumb" class="breadcrumb" style="white-space: nowrap; overflow: auto;">
                    <li><a href="<?php echo $global_sholink; ?>/shop" class="home">Mua sắm</a></li>
<!--                    <li><a href="--><?php //echo $URLRoot; ?><!--/shop/product">--><?php //echo $this->lang->line('product_menu_detail_global'); ?><!--</a></li>-->
                    <li><a href="<?php echo $global_sholink; ?>/shop/<?php echo $url.'/pro_type/'.$pro_type?>"><?php echo $DM; ?></a></li>
                    <li><span><?php echo $urlRoot ?></span></li>

                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12 pull-right">
                <div class="row">
                    <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
                        <?php $this->load->view('shop/common/searchbox', $parrams); ?>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">

                        <select autocomplete="off" name="select_sort" class="form-control"
                                onchange="ActionSort(this.value)">
                            <option <?php echo ($default_sort == 'id_desc') ? 'selected="selected"' : ''; ?>
                                value="<?php echo $sortUrl; ?>id/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('sort_main'); ?></option>
                            <option <?php echo ($default_sort == 'name_asc') ? 'selected="selected"' : ''; ?>
                                value="<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>">Tên sản phẩm A&rarr;Z
                            </option>
                            <option <?php echo ($default_sort == 'name_desc') ? 'selected="selected"' : ''; ?>
                                value="<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>">Tên sản phẩm Z&rarr;A
                            </option>
                            <option <?php echo ($default_sort == 'cost_asc') ? 'selected="selected"' : ''; ?>
                                value="<?php echo $sortUrl; ?>cost/by/asc<?php echo $pageSort; ?>">Giá sản phẩm tăng dần
                            </option>
                            <option <?php echo ($default_sort == 'cost_desc') ? 'selected="selected"' : ''; ?>
                                value="<?php echo $sortUrl; ?>cost/by/desc<?php echo $pageSort; ?>">Giá sản phẩm giảm
                                dần
                            </option>
                            <option <?php echo ($default_sort == 'buy_asc') ? 'selected="selected"' : ''; ?>
                                value="<?php echo $sortUrl; ?>buy/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_asc_detail_product'); ?></option>
                            <option <?php echo ($default_sort == 'buy_desc') ? 'selected="selected"' : ''; ?>
                                value="<?php echo $sortUrl; ?>buy/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('buy_desc_detail_product'); ?></option>
                            <option <?php echo ($default_sort == 'view_asc') ? 'selected="selected"' : ''; ?>
                                value="<?php echo $sortUrl; ?>view/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_asc_detail_product'); ?></option>
                            <option <?php echo ($default_sort == 'view_desc') ? 'selected="selected"' : ''; ?>
                                value="<?php echo $sortUrl; ?>view/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('view_desc_detail_product'); ?></option>
                            <option <?php echo ($default_sort == 'date_asc') ? 'selected="selected"' : ''; ?>
                                value="<?php echo $sortUrl; ?>date/by/asc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_asc_detail_product'); ?></option>
                            <option <?php echo ($default_sort == 'date_desc') ? 'selected="selected"' : ''; ?>
                                value="<?php echo $sortUrl; ?>date/by/desc<?php echo $pageSort; ?>"><?php echo $this->lang->line('begindate_desc_detail_product'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="page-title">
                    <h3>
                        <?php
                            if($title_page != false)
                            {                            
                                echo $title_page;
                            } else {
                                echo ($category->cat_name != '') ? $category->cat_name : $this->lang->line('title_detail_product');
                            }
                        ?>
                    </h3>
                </div>
                <form name="frmListPro" method="post" action="">
                    <div class="row">
                        <?php $idDiv = 1; ?>
                        <?php foreach ($product as $productArray) {
                            // Added
                            // by le van son
                            // Calculation discount amount
                            $afSelect = true;
                            $discount = lkvUtil::buildPrice($productArray, $this->session->userdata('sessionGroup'), $afSelect);
                            ?>
                            <div class="col-lg-4 col-md-4 col-sm-6">
                                <?php $this->load->view('shop/product/shop_item', array('product' => $productArray, 'discount' => $discount, 'shop_link' => $siteGlobal->sho_link, 'af' => $siteGlobal->af_key)); ?>
                            </div>
                            <?php $idDiv++; ?>
                        <?php } ?>
                    </div>
                    <div class="linkPage text-center"><?php echo $linkPage; ?></div>
                    <div class="row">
                    </div>
                </form>               
                <script>OpenSearch(0);</script>
                <div style="height:30px;"></div>

            </div>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 pull-left">
                <?php $this->load->view('shop/common/left'); ?>
                <?php $this->load->view('shop/common/right'); ?>
            </div>
        </div>
    </div>
    <!--END Center-->
<?php } ?>
<?php $this->load->view('shop/common/footer'); ?>
<?php 
    if($siteGlobal->sho_phone){
        $phonenumber = $siteGlobal->sho_phone;
    } elseif($siteGlobal->sho_mobile){
        $phonenumber = $siteGlobal->sho_mobile;
    }
    if($phonenumber){
    ?>    
    <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
        <div class="phonering-alo-ph-circle"></div>
        <div class="phonering-alo-ph-circle-fill"></div>            
        <div class="phonering-alo-ph-img-circle">
            <a href="tel:<?php echo $siteGlobal->sho_mobile; ?>">
                <img data-toggle="modal" data-target=".bs-example-modal-md" src="https://i.imgur.com/v8TniL3.png" alt="Liên hệ" width="50" onmouseover="this.src = 'https://i.imgur.com/v8TniL3.png';" onmouseout="this.src = 'https://i.imgur.com/v8TniL3.png';">
            </a>
        </div>
    </div>
<?php } ?>


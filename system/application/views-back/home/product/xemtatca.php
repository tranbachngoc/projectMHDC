<?php $this->load->view('home/common/header');
/*if ($_REQUEST['af_id'] != '') {
    $this->load->model('user_model');
    $userObject = $this->user_model->get("use_id", "af_key = '" . $_REQUEST['af_id'] . "'");
}*/
?>
<?php //$this->load->view('home/common/left'); ?>
    <!--BEGIN: CENTER-->
    <script language="javascript" type="text/javascript">
        document.onclick = hideallpop;
        jQuery(document).ready(function () {

            hiddenProductViaResolutionCategory('showCateGoRyScren');
            hiddenProductViaResolutionCategory('showCateGoRyScrenNew');

            jQuery('.image_boxpro').mouseover(function () {
                tooltipPicture(this, jQuery(this).attr('id'));
            });
            var widthScreen = jQuery(window).width();
            jQuery('.header_bar_v2').css('width', widthScreen);
            jQuery('.logo-banner').css('width', widthScreen);

            var isCtrl = false;
            jQuery(document).keyup(function (e) {
                if (window.event) {
                    key = window.event.keyCode;
                    if (window.event.ctrlKey)
                        isCtrl = true;
                    else
                        isCtrl = false;
                }
                else {
                    key = e.which;     //firefox
                    if (e.ctrlKey)
                        isCtrl = true;
                    else
                        isCtrl = false;
                }
                if (isCtrl) {
                    if (key == 109 || key == 189) {
                        // zoom out
                        hiddenProductViaResolutionCategory('showCateGoRyScren');
                        hiddenProductViaResolutionCategory('showCateGoRyScrenNew');
                    }
                    if (key == 107 || key == 187) {
                        // zoom in
                        hiddenProductViaResolutionCategory('showCateGoRyScren');
                        hiddenProductViaResolutionCategory('showCateGoRyScrenNew');
                    }
                }
            });
        });

        function hoverpop(co, id, obj) {
            jQuery('.sub_sub_cat').css('display', 'none');
            if (co > 0) {
                var position = jQuery(obj).position();
                jQuery('#sub_sub_cat_' + id).css('left', position.left);
                jQuery('#sub_sub_cat_' + id).css('top', position.top + 20);
                jQuery('#sub_sub_cat_' + id).slideDown();
            }
        }
        function hidepop(id) {
            jQuery('#sub_sub_cat_' + id).slideUp();
        }
        function hideallpop() {
            jQuery('.sub_sub_cat').css('display', 'none');
        }

    </script>

    <td width="100%" valign="top">
        <div class="navigate">
            <?php if ($CategorysiteGlobalRoot->cat_id == "") { ?>

            <?php } ?>
            <style>

                .navigate {
                    margin-left: 10px;
                }

                .sub_cateory_bgrum {
                    margin-left: 0px !important;
                }
            </style>

            <div class="bgrumQ">
                <div class="bgrumQHome" id="sub_cateory_bgrum">
                    <a href="<?php echo base_url() ?>" class="home">Home</a>
                    <img alt="" src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>
                </div>
                <div class="sub_cateory_bgrum">
                    <?php echo $sanpham_sub_rum; ?>
                </div>
                <?php if (isset($CategorysiteGlobalRoot->cat_id)) { ?>
                    <div id="CategorysiteGlobalRoot">
                        <a href="<?php echo base_url() ?><?php echo $CategorysiteGlobalRoot->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobalRoot->cat_name); ?>"><?php echo mb_substr($CategorysiteGlobalRoot->cat_name, 0, 30, 'UTF-8'); ?></a>


                        <?php if (isset($CategorysiteRootConten)) { ?>
                            <div class="CategorysiterootConten">
                                <?php echo $CategorysiteRootConten; ?>
                            </div>
                        <?php } ?>

                        <?php if ($CategorysiteRootConten != "") { ?>
                            <img alt="" src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>
                        <?php } else { ?>
                            <img src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif" alt=""/>
                            <?php
                        }
                        ?>
                    </div>
                <?php } ?>

                <?php if (isset($CategorysiteGlobal->cat_id)) { ?>
                    <div id="CategorysiteGlobal">
                        <a href="<?php echo base_url() ?><?php echo $CategorysiteGlobal->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobal->cat_name); ?>"><?php echo mb_substr($CategorysiteGlobal->cat_name, 0, 30, 'UTF-8'); ?></a>

                        <?php if (isset($CategorysiteGlobalConten)) { ?>
                            <div class="CategorysiteGlobalConten">
                                <?php echo $CategorysiteGlobalConten; ?>
                            </div>
                        <?php } ?>

                        <?php if ($CategorysiteGlobalConten != "") { ?>
                            <img alt="" src="<?php echo base_url(); ?>templates/home/images/navigate_icon.gif"/>
                        <?php } else { ?>
                            <img src="<?php echo base_url(); ?>templates/shop/style2/images/navigate_icon.gif" alt=""/>
                            <?php
                        }
                        ?>
                    </div>
                <?php } ?>

                <?php if ($siteGlobal->cat_id != "") ?>
                <?php { ?>

                    <span><?php echo $siteGlobal->cat_name; ?></span>

                <?php } ?>
            </div>

        </div>

        <div style="display:none;">
            <p>

            <div xmlns:v="http://rdf.data-vocabulary.org/#" class="breadcrumbs-title">
<span typeof="v:Breadcrumb">
 <a rel="v:url" property="v:title" href="<?php echo base_url() ?>" class="home">Home</a>
 </span>
                <span class="separator">»</span>
                <?php if (isset($CategorysiteGlobalRoot->cat_id)) { ?>
                    <span typeof="v:Breadcrumb">
<a rel="v:url" property="v:title"
   href="<?php echo base_url() ?><?php echo $CategorysiteGlobalRoot->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobalRoot->cat_name); ?>"
   title="<?php echo $CategorysiteGlobalRoot->cat_name; ?>"><?php echo mb_substr($CategorysiteGlobalRoot->cat_name, 0, 30, 'UTF-8'); ?></a> <span
                            class="separator">»</span>
</span>

                <?php } ?>
                <?php if (isset($CategorysiteGlobal->cat_id)) { ?><span typeof="v:Breadcrumb">
                    <a rel="v:url" property="v:title"
                       href="<?php echo base_url() ?><?php echo $CategorysiteGlobal->cat_id; ?>/<?php echo RemoveSign($CategorysiteGlobal->cat_name); ?>"
                       title="<?php echo $CategorysiteGlobal->cat_name; ?>"><?php echo mb_substr($CategorysiteGlobal->cat_name, 0, 30, 'UTF-8'); ?></a> <span
                        class="separator">»</span>
                    </span>
                <?php } ?>
                <?php if ($siteGlobal->cat_id != "") ?>
                <?php { ?>

                    <?php echo $siteGlobal->cat_name; ?>

                <?php } ?>
            </div>
            </p>
        </div>

        <div style="clear:both; padding-bottom:10px;">
        </div>
        <?php if ((isset($categorylv1) && count($categorylv1) > 0) || (isset($categorylv2) && count($categorylv2) > 0)) { ?>

            <div class="temp_xemtatca">
                <div class="title">
                    <div class="fl"></div>
                    <div class="fc">
                    </div>
                    <div class="fr"></div>
                </div>
                <div class="content">
                    <div class="list_link">


                        <?php if (isset($categorylv1) && count($categorylv1) > 0) {
                            foreach ($categorylv1 as $catitem) {
                                $subcat = $catitem->cat_level2;
                                ?>
                                <div class="sub_cat"><a
                                        onmouseover="hoverpop('<?php echo count($subcat); ?>','<?php echo $catitem->cat_id; ?>',this)" <?php if (count($subcat) > 0) {
                                        echo 'class="has_child"';
                                    } ?>
                                        href="<?php echo base_url() ?><?php echo $catitem->cat_id; ?>/<?php echo RemoveSign($catitem->cat_name); ?>"><?php echo $catitem->cat_name; ?></a>
                                </div>
                                <div class="sub_sub_cat" id="sub_sub_cat_<?php echo $catitem->cat_id; ?>">
                                    <div style="float:right">

                                    </div>
                                    <?php if (count($subcat) > 0) {
                                        foreach ($subcat as $key => $suvcatitem) {
                                            ?>
                                            <div class="sub_sub_cat_item">
                                                <a href="<?php echo base_url() ?><?php echo $suvcatitem->cat_id; ?>/<?php echo RemoveSign($suvcatitem->cat_name); ?>"><?php echo $suvcatitem->cat_name; ?></a>
                                            </div>
                                        <?php }
                                    } ?>
                                    <div style="clear:both"></div>
                                </div>
                            <?php }
                        } ?>
                        <?php if (isset($categorylv2) && count($categorylv2) > 0) {
                            foreach ($categorylv2 as $catitem) {
                                ?>
                                <div class="sub_cat"><a
                                        href="<?php echo base_url() ?><?php echo $catitem->cat_id; ?>/<?php echo RemoveSign($catitem->cat_name); ?>"><?php echo $catitem->cat_name; ?></a>
                                </div>
                            <?php }
                        } ?>
                    </div>

                    <div class="clear"></div>
                </div>
                <div class="bottom">
                    <div class="fl"></div>
                    <div class="fr"></div>
                </div>
            </div>

        <?php } ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="padding:0 10px;">
            <?php $this->load->view('home/advertise/center1'); ?>
            <?php if (count($reliableProduct) > 0) { ?>
                <tr>
                    <td>
                        <div class="temp_3">
                            <div class="title">
                                <div class="fl">
                                    <h2><?php if ($categoryName != '' && isset($categoryName)) {
                                            echo $categoryName . " ";
                                        } ?><?php //echo $this->lang->line('title_reliable_category'); ?></h2>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table align="center" style="margin-top:6px;" width="100%" border="0" cellpadding="0"
                               cellspacing="0">
                            <tr>
                                <td valign="top">
                                    <div class="showCateGoRyScren">
                                        <?php $idDiv = 1; ?>
                                        <?php foreach ($reliableProduct as $reliableProductArray) {
                                            // Added
                                            // by le van son
                                            // Calculation discount amount
                                            $afSelect = false;
                                            /*if ($_REQUEST['af_id'] != '' && $reliableProductArray->is_product_affiliate == 1) {
                                                if ($userObject->use_id > 0) {
                                                    $afSelect = true;
                                                }
                                            }*/

                                            $discount = lkvUtil::buildPrice($reliableProductArray, $this->session->userdata('sessionGroup'), $afSelect);

                                            ?>
                                            <div class="showbox_1" id="DivReliableProductBox_<?php echo $idDiv; ?>"
                                                 onmouseover="ChangeStyleBox('DivReliableProductBox_<?php echo $idDiv; ?>',1)"
                                                 onmouseout="ChangeStyleBox('DivReliableProductBox_<?php echo $idDiv; ?>',2)">
                                                <a href="<?php echo base_url(); ?><?php echo $reliableProductArray->pro_category; ?>/<?php echo $reliableProductArray->pro_id; ?>/<?php echo RemoveSign($reliableProductArray->pro_name); ?>">

                                                    <div class="imgViewCategoryImg">
                                                        <table width="100%" border="0">
                                                            <tr>
                                                                <td width="100%" height="140" align="center"
                                                                    valign="middle">

                                                                    <input type="hidden"
                                                                           id="name-<?php echo $reliableProductArray->pro_id; ?>"
                                                                           value="<?php echo $reliableProductArray->pro_name; ?>"/>
                                                                    <input type="hidden"
                                                                           id="view-<?php echo $reliableProductArray->pro_id; ?>"
                                                                           value="<?php echo $reliableProductArray->pro_view; ?>"/>
                                                                    <input type="hidden"
                                                                           id="shop-<?php echo $reliableProductArray->pro_id; ?>"
                                                                           value="<?php echo $reliableProductArray->sho_name; ?>"/>
                                                                    <input type="hidden"
                                                                           id="pos-<?php echo $reliableProductArray->pro_id; ?>"
                                                                           value="<?php echo $reliableProductArray->pre_name; ?>"/>
                                                                    <input type="hidden"
                                                                           id="date-<?php echo $reliableProductArray->pro_id; ?>"
                                                                           value="<?php echo date('d/m/Y', $reliableProductArray->sho_begindate); ?>"/>
                                                                    <input type="hidden"
                                                                           id="image-<?php echo $reliableProductArray->pro_id; ?>"
                                                                           value="<?php echo base_url() ?>media/images/product/<?php echo $reliableProductArray->pro_dir; ?>/<?php echo show_image($reliableProductArray->pro_image); ?>"/>

                                                                    <div style="display:none"
                                                                         id="danhgia-<?php echo $reliableProductArray->pro_id; ?>">
                                                                        <?php for ($vote = 0; $vote < (int)$reliableProductArray->pro_vote_total; $vote++) { ?>
                                                                            <img
                                                                                src="<?php echo base_url(); ?>templates/home/images/star1.gif"
                                                                                border="0" alt=""/>
                                                                        <?php } ?>
                                                                        <?php for ($vote = 0; $vote < 10 - (int)$reliableProductArray->pro_vote_total; $vote++) { ?>
                                                                            <img
                                                                                src="<?php echo base_url(); ?>templates/home/images/star0.gif"
                                                                                border="0"
                                                                                alt=""/>                                                    <?php } ?>
                                                                        <b>[<?php echo $reliableProductArray->pro_vote; ?>
                                                                            ]</b>

                                                                    </div>


                                                                    <img
                                                                        src="<?php echo base_url() ?>media/images/product/<?php echo $reliableProductArray->pro_dir; ?>/<?php echo show_thumbnail($reliableProductArray->pro_dir, $reliableProductArray->pro_image, 3); ?>"
                                                                        onmouseover="tooltipPicture(this,'<?php echo $reliableProductArray->pro_id; ?>')"
                                                                        id="<?php echo $reliableProductArray->pro_id; ?>"
                                                                        class="image_boxpro"
                                                                        alt="<?php echo($reliableProductArray->pro_name); ?>"/>
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </div>
                                                    <div class="name_showbox_1">
                                                        <h4>
                                                            <?php echo sub($reliableProductArray->pro_name, 35); ?>
                                                            &nbsp;
                                                        </h4>
                                                    </div>
                                                </a>

                                                <div class="icon-saleoff"><span
                                                        class="giamgia"><?php if ($reliableProductArray->pro_saleoff == 1) { ?>Khuyến mãi<?php } ?> </span>
                                                </div>
                                                <div class="cost_showbox"
                                                     id="price-<?php echo $reliableProductArray->pro_id; ?>">
                                                    <span
                                                        id="DivCostReliableOne_<?php echo $idDiv; ?>"><?php echo number_format($discount['salePrice']);?></span>&nbsp;<?php echo $reliableProductArray->pro_currency; ?>
                                                </div>

                                            </div>
                                            <?php $idDiv++; ?>
                                        <?php } ?>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height="16"></td>
                </tr>
                <tr>
                    <td height="5"></td>
                </tr>
                <?php $this->load->view('home/advertise/center2'); ?>
            <?php } ?>


            <tr>
                <td height="16"></td>
            </tr>
            <tr>
                <td height="10"></td>
            </tr>
            <tr>
                <td>
                    <div class="temp_3">
                        <div class="title">
                            <div class="fl">
                                <h2><?php echo $this->lang->line('title_favorite_category'); ?></h2>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <table align="center" width="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table align="center" style="margin-top:6px;" width="100%" border="0" cellpadding="0"
                                       cellspacing="0">
                                    <tr valign="top">
                                        <?php $isCounter = 1; ?>
                                        <?php foreach ($favoriteProduct as $favoriteProductArray){
                                        // Added
                                        // by le van son
                                        // Calculation discount amount
                                        $afSelect = false;
                                        /*if ($_REQUEST['af_id'] != '' && $favoriteProductArray->is_product_affiliate == 1) {
                                            if ($userObject->use_id > 0) {
                                                $afSelect = true;
                                            }
                                        }*/

                                        $discount = lkvUtil::buildPrice($favoriteProductArray, $this->session->userdata('sessionGroup'), $afSelect);
                                        ?>
                                        <td width="12%">
                                            <div class="img_bestvote">
                                                <a class="menu_1"
                                                   href="<?php echo base_url(); ?><?php echo $favoriteProductArray->pro_category; ?>/<?php echo $favoriteProductArray->pro_id; ?>/<?php echo RemoveSign($favoriteProductArray->pro_name); ?>">

                                                    <input type="hidden"
                                                           id="name-<?php echo 'fr' . $favoriteProductArray->pro_id; ?>"
                                                           value="<?php echo $favoriteProductArray->pro_name; ?>"/>
                                                    <input type="hidden"
                                                           id="view-<?php echo 'fr' . $favoriteProductArray->pro_id; ?>"
                                                           value="<?php echo $favoriteProductArray->pro_view; ?>"/>
                                                    <input type="hidden"
                                                           id="shop-<?php echo 'fr' . $favoriteProductArray->pro_id; ?>"
                                                           value="<?php echo $favoriteProductArray->sho_name; ?>"/>
                                                    <input type="hidden"
                                                           id="pos-<?php echo 'fr' . $favoriteProductArray->pro_id; ?>"
                                                           value="<?php echo $favoriteProductArray->pre_name; ?>"/>
                                                    <input type="hidden"
                                                           id="date-<?php echo 'fr' . $favoriteProductArray->pro_id; ?>"
                                                           value="<?php echo date('d/m/Y', $favoriteProductArray->sho_begindate); ?>"/>
                                                    <input type="hidden"
                                                           id="image-<?php echo 'fr' . $favoriteProductArray->pro_id; ?>"
                                                           value="<?php echo base_url() ?>media/images/product/<?php echo $favoriteProductArray->pro_dir; ?>/<?php echo show_image($favoriteProductArray->pro_image); ?>"/>

                                                    <div style="display:none"
                                                         id="danhgia-<?php echo 'fr' . $favoriteProductArray->pro_id; ?>">
                                                        <?php for ($vote = 0; $vote < (int)$favoriteProductArray->pro_vote_total; $vote++) { ?>
                                                            <img
                                                                src="<?php echo base_url(); ?>templates/home/images/star1.gif"
                                                                border="0" alt=""/>
                                                        <?php } ?>
                                                        <?php for ($vote = 0; $vote < 10 - (int)$favoriteProductArray->pro_vote_total; $vote++) { ?>
                                                            <img
                                                                src="<?php echo base_url(); ?>templates/home/images/star0.gif"
                                                                border="0"
                                                                alt=""/>                                                    <?php } ?>
                                                        <b>[<?php echo $favoriteProductArray->pro_vote; ?>]</b>

                                                    </div>


                                                    <div style="display:none"
                                                         id="price-<?php echo 'fr' . $favoriteProductArray->pro_id; ?>">
                                                        <span
                                                            id="DivCostReliablebr_<?php echo 'fr' . $favoriteProductArray->pro_id; ?>"><?php echo number_format($discount['salePrice']);?></span>&nbsp;<?php echo $favoriteProductArray->pro_currency; ?>
                                                    </div>

                                                    <img alt="<?php echo($favoriteProductArray->pro_name); ?>"
                                                         src="<?php echo base_url() ?>media/images/product/<?php echo $favoriteProductArray->pro_dir; ?>/<?php echo show_thumbnail($favoriteProductArray->pro_dir, $favoriteProductArray->pro_image); ?>"
                                                         onmouseover="tooltipPicture(this,'<?php echo 'fr' . $favoriteProductArray->pro_id; ?>')"
                                                         id="<?php echo 'fr' . $favoriteProductArray->pro_id; ?>"
                                                         class="image_boxpro"/>
                                                </a>
                                            </div>
                                        </td>
                                        <td width="38%"
                                            <?php if ($isCounter % 2 != 0){ ?>style="border-right:1px #D4EDFF dotted;"<?php } ?>>
                                            <div class="title_bestvote">
                                                <a class="menu_1"
                                                   href="<?php echo base_url(); ?><?php echo $favoriteProductArray->pro_category; ?>/<?php echo $favoriteProductArray->pro_id; ?>/<?php echo RemoveSign($favoriteProductArray->pro_name); ?>"
                                                   title="<?php echo $this->lang->line('detail_tip'); ?>">
                                                    <?php echo sub($favoriteProductArray->pro_name, 80); ?>
                                                </a>
                                            </div>
                                            <div class="descr_bestvote">

                                                <?php $vovel = array("&curren;"); ?><?php echo cut_string_unicodeutf8(strip_tags(html_entity_decode(str_replace($vovel, "#", $favoriteProductArray->pro_detail))), 150); ?>

                                            </div>
                                            <div class="vote_bestvote">
                                                <?php for ($vote = 0; $vote < (int)$favoriteProductArray->pro_vote_total; $vote++) { ?>
                                                    <img src="<?php echo base_url(); ?>templates/home/images/star1.gif"
                                                         border="0" alt=""/>
                                                <?php } ?>
                                                <?php for ($vote = 0; $vote < 10 - (int)$favoriteProductArray->pro_vote_total; $vote++) { ?>
                                                    <img src="<?php echo base_url(); ?>templates/home/images/star0.gif"
                                                         border="0" alt=""/>
                                                <?php } ?>
                                                <font color="#004B7A"><b>[<?php echo $favoriteProductArray->pro_vote; ?>
                                                        ]</b></font>
                                            </div>
                                        </td>
                                        <?php if ($isCounter % 2 == 0 && $isCounter < count($favoriteProduct)){ ?>
                                    </tr>
                                    <tr valign="top">
                                        <?php } ?>
                                        <?php $isCounter++; ?>
                                        <?php } ?>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td height="16"></td>
            </tr>
            <?php $this->load->view('home/advertise/footer'); ?>
        </table>
    </td>
    <!-- END CENTER-->
<?php $this->load->view('home/common/right'); ?>
<?php $this->load->view('home/common/footer'); ?>
<?php if (isset($successFavoriteProduct) && $successFavoriteProduct == true) { ?>
    <script>alert('<?php echo $this->lang->line('success_add_favorite_category'); ?>');</script>
<?php } ?>
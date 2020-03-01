<?php if (isset($siteGlobal)) { ?>
    <?php if (isset($bannertops) && count($bannertops) > 0) { ?>        
        <script type="text/javascript" src="<?php echo $URLRoot; ?>templates/home/js/simplegallery.js"></script>       
        <script type="text/javascript">
            //<![CDATA[
            var widthScreen = jQuery(window).width();
            if (widthScreen <= 1024) {
                var width1024 = 593;

            }
            else {
                var width1024 = 593;
            }

            var mygallery2 = new simpleGallery({
                wrapperid: "simplegallery2", //ID of main gallery container,
                dimensions: [width1024, 250], //width/height of gallery in pixels. Should reflect dimensions of the images exactly
                imagearray: [
                    <?php foreach($bannertops as $item){ ?>
                    <?php if((int)$item->banner_type == 1 ){ ?>
                    <?php if($item==end($bannertops)){ ?> ["<?php echo $URLRoot; ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $item->content; ?>", "<?php echo prep_url( $item->link); ?>", "_new", ""] <?php }else{ ?>
                        ["<?php echo $URLRoot; ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $item->content; ?>", "<?php echo prep_url( $item->link); ?>", "_new", ""],
                    <?php } ?>
                    <?php } ?>
                    <?php } ?>

                ],
                autoplay: [true, 1, 1000], //[auto_play_boolean, delay_btw_slide_millisec, cycles_before_stopping_int]
                persist: true,
                fadeduration: 2000, //transition duration (milliseconds)
                oninit: function () { //event that fires when gallery has initialized/ ready to run
                },
                onslide: function (curslide, i) { //event that fires after each slide is shown
                    //curslide: returns DOM reference to current slide's DIV (ie: try alert(curslide.innerHTML)
                    //i: integer reflecting current image within collection being shown (0=1st image, 1=2nd etc)
                }
            });
            //]]
        </script>       
        <table border="0" cellpadding="0" cellspacing="0" class="table_module" style="margin-top:0px; border: none;">
            <tr>
                <td align="center">
                    <div class="right_banner" style="text-align:center">
                        <div id="slide" class="pics"
                             style="height: 250px; width:594px;position:relative;background:#CCCCCC">
                            <?php foreach ($bannertops as $item) { ?>
                                <?php if ($item->banner_type == 1) { ?>
                                    <div id="simplegallery2"></div>
                                <?php } elseif ($item->banner_type == 2) {
                                    $height = (590 / $item->banner_width) * $item->banner_height;
                                    ?>
                                    <div style="text-align:center">
                                        <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
                                                style="width:590px; height:<?php echo $height; ?>px;"
                                                id="FlashID_Banner">
                                            <param name="movie"
                                                   value="<?php echo $URLRoot; ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $item->content; ?>"/>
                                            <param name="quality" value="high"/>
                                            <param name="wmode" value="opaque"/>
                                            <param name="swfversion" value="6.0.65.0"/>
                                            <param name="expressinstall"
                                                   value="<?php echo $URLRoot; ?>templates/shop/style1/images/expressInstall.swf"/>
                                            <!--[if !IE]>-->
                                            <object type="application/x-shockwave-flash"
                                                    style="width:590px; height:<?php echo $height; ?>px;"
                                                    data="<?php echo $URLRoot; ?>media/shop/banners/<?php echo $siteGlobal->sho_dir_banner; ?>/<?php echo $item->content; ?>"
                                                    class="banner_flash"><!--<![endif]-->
                                                <param name="quality" value="high"/>
                                                <param name="wmode" value="opaque"/>
                                                <param name="swfversion" value="6.0.65.0"/>
                                                <param name="expressinstall"
                                                       value="<?php echo $URLRoot; ?>templates/shop/style1/images/expressInstall.swf"/>
                                                <div>
                                                    <h4>Content on this page requires a newer version of Adobe Flash
                                                        Player.</h4>

                                                    <p><a href="http://www.adobe.com/go/getflashplayer"><img
                                                                src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif"
                                                                alt="Get Adobe Flash player"/></a></p>
                                                </div>
                                                <!--[if !IE]>--></object>
                                            <!--<![endif]-->
                                        </object>
                                     <!--   <script type="text/javascript">swfobject.registerObject("FlashID_Banner");</script>-->
                                    </div>
                                <?php } else { ?>
                                    <div style="width:190px; margin-left:5px;">
                                        <a target="<?php echo $item->target; ?>" href="<?php echo $item->link; ?>">
                                            <?php echo htmlspecialchars_decode(html_entity_decode($item->content)); ?>
                                        </a>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div>
                    </div>
                </td>
                <?php if ($this->uri->segment(2) == "product" && $this->uri->segment(3) == "detail") { ?>

                    <td valign="top">

                        <table width="201" border="0" cellpadding="0" cellspacing="0" class="table_module_style">
                            <?php if (isset($module) && $module == 'top_lastest_ads') { ?>
                                <?php $this->load->view('shop/raovat/top_lastest'); ?>
                            <?php } ?>
                            <?php if (isset($module) && $module == 'top_lastest_product') { ?>
                                <?php $this->load->view('shop/product/top_lastest'); ?>
                            <?php } ?>
                        </table>


                    </td>
                <?php } ?>
            </tr>
        </table>
    <?php } ?>
    <script language="javascript" type="application/javascript">
        function SummitEnTerAdminShop(myfield, e, baseUrl, idInput) {

            var keycode;
            if (window.event) keycode = window.event.keyCode;
            else if (e) keycode = e.which;
            else return true;

            if (keycode == 13) {

                SearchLinkEnterShop(baseUrl, idInput);
                return false;
            }
            else
                return true;

        }
        function SearchLinkEnterShop(baseUrl, idInput) {
            if (document.getElementById(idInput).value == "") {
                alert("Bạn phải gõ từ khóa tìm kiếm");
            }
            else {

                product_name = '';


                if (document.getElementById("price").value != "" && document.getElementById("price_to").value != "") {
                    window.location = baseUrl + "/search/name/" + document.getElementById("KeywordSearch").value + "/sCost/" + document.getElementById("price").value + "/eCost/" + document.getElementById("KeywordSearch").value + "/currency/VND/";

                }
                else {

                    window.location = baseUrl + "/search/name/" + document.getElementById("KeywordSearch").value;
                }


            }

        }

    </script>
    <form class="form-inline">
        <div class="form-group">
            <input type="text" value="" name="KeywordSearch" id="KeywordSearch" class="form-control keyword"
                   title="Từ khóa tìm kiếm"
                   onKeyPress="return SummitEnTerAdminShop(this,event,'<?php echo $URLRoot; ?>','KeywordSearch')"
                   placeholder="Từ khóa tìm kiếm">
        </div>
        <div class="form-group">
            <input class="form-control min_price" type="text" value="" name="price" id="price" title="Giá nhỏ nhất"
                   onKeyPress="return SummitEnTerAdminShop(this,event,'<?php echo $URLRoot; ?>','KeywordSearch')"
                   placeholder="Giá nhỏ nhất">
        </div>
        <div class="form-group">
            <input class="form-control max_price" type="text" value="" name="price_to" id="price_to"
                   title="Giá lớn nhất"
                   onKeyPress="return SummitEnTerAdminShop(this,event,'<?php echo $URLRoot; ?>','KeywordSearch')"
                   placeholder="Giá lớn nhất">
            <button type="button"  name="button" onclick="Search('<?php echo $URLRoot; ?>')" class="btn btn-default1"><?php echo $this->lang->line('title_search_detail_global'); ?></button>
        </div>
    </form>
<?php } ?>
<?php $this->load->view('shop/news/header'); ?>

<?php
if (isset($siteGlobal)): 
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

    <?php
    if ($isMobile == 0) {
        $this->load->view('shop/common/menubar');
    } else {
        $this->load->view('shop/common/m_menu');
    }
    ?>

    <div class="container-fluid">
        <div class="row rowmain">
            <div class="col-lg-2 col-md-3 hidden-sm hidden-xs"> 
                <?php $this->load->view('shop/common/menu'); ?>
            </div>
            <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12">
                <?php $this->load->view('shop/common/shopinfo'); ?> 
                <div class="panel panel-default">
                    <div class="panel-heading"><span class="text-uppercase">Danh sách shop chọn tin </span><span class="badge pull-right"><?php echo count($listselect)?></span></div>
                    <div class="panel-body" style="padding:0;">
                        
                        <?php foreach ($listselect as $key => $item) { 
                            if ($item->sho_logo != ""){
                                $shop_logo = DOMAIN_CLOUDSERVER.'media/shop/logos/' . $item->sho_dir_logo . '/' . $item->sho_logo;
                            } else {
                                $shop_logo = 'media/images/no-logo.png';
                            }                                                                            
                            if($item->domain) {
                                $linktoshop = '//'.$item->domain;                                 
                            } else { 
                                $linktoshop = '//'.$item->sho_link . '.' . domain_site;                                 
                            }                            
                        ?> 
                        
                        <div style="display: table; width: 100%;">
                            <div style="display: table-cell; width: 90px; padding: 15px"> 
                                <div class="fix1by1 img-circle" style="border:1px solid #eee">
                                    <a class="c" href="<?php echo $linktoshop; ?>" target="_blank" style="background: #fff url('<?php echo $shop_logo ?>') no-repeat center center / cover"></a>
                                </div>                     
                            </div>
                            <div style="display: table-cell; vertical-align: middle">
                                <a href="<?php echo $linktoshop; ?>" target="_blank"><strong><?php echo $item->sho_name ?></strong><br><em>@<?php echo $item->sho_link ?></em></a>
                            </div>
                        </div> 
                        
                        
                        <?php } ?>
                        
                    </div>
                    <div class="panel-footer"> 
                        <a href="javascript:history.back()" class=""><i class="fa fa-long-arrow-left" aria-hidden="true"></i> Về trang trước</a>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-3 col-sm-4 hidden-xs">                 
                <?php if (count($ds_tin_chon) > 0) { ?>
                <div class="panel panel-default ">
                    <div class="panel-heading">Danh sách tin theo dõi</div>
                    <div class="panel-body" style="padding:0">                        
                        <ul class="list-unstyled dstinchon">
                            <?php
                            foreach ($ds_tin_chon as $item) :
                                $number = 10;
                                $content = str_replace("\n", "", strip_tags(preg_replace("/<img[^>]+\>/i", "", $item->not_title)));
                                $item_title = $content;
                                $array = explode(" ", $content);
                                if (count($array) <= $number) {
                                    $item_title = $content;
                                }
                                array_splice($array, $number);
                                $item_title = implode(" ", $array) . " ...";

                                if ($item->not_image != "") {
                                    $item_image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/thumbnail_1_' . $item->not_image;
                                } else {
                                    $item_image = 'media/images/noimage.png';
                                }

                                if ($item->domain) {
                                    $item_link = '//' . $item->domain . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title);
                                } else {
                                    $item_link = '//' . $item->sho_link . '.' . domain_site . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title);
                                }
                                ?>
                                <li class="bochontin_<?php echo $item->not_id ?>">
                                    <a href="<?php echo $item_link ?>">
                                        <div class="pull-left" style="width:44px; height:44px; margin-right: 15px">
                                            <div class="fix1by1 img-circle">
                                                <div class="c" style="background: #fff url('<?php echo $item_image ?>') no-repeat center / cover"></div>
                                            </div>
                                        </div>                                                                                    
                                        <?php echo $item_title ?>                                        
                                    </a>
                                    <?php if ($this->session->userdata('sessionUser') == $siteGlobal->sho_user) { ?>
                                        <button class="btn btn-danger btn-xs" onclick="bochontin2(<?php echo $item->not_id ?>);"> X </button>
                                    <?php } ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>	
                    </div>	
                </div>	
                <?php } ?> 
                
                <?php if (count($ds_duoc_chon) > 0) { ?>
                <div class="panel panel-default ">
                    <div class="panel-heading">Danh sách tin được chọn</div>
                    <div class="panel-body" style="padding:0">                        
                        <ul class="list-unstyled dstinchon">
                            <?php
                            foreach ($ds_duoc_chon as $item) :
                                $number = 10;
                                $content = str_replace("\n", "", strip_tags(preg_replace("/<img[^>]+\>/i", "", $item->not_title)));
                                $item_title = $content;
                                $array = explode(" ", $content);
                                if (count($array) <= $number) {
                                    $item_title = $content;
                                }
                                array_splice($array, $number);
                                $item_title = implode(" ", $array) . " ...";

                                if ($item->not_image != "") {
                                    $item_image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/thumbnail_1_' . $item->not_image;
                                } else {
                                    $item_image = 'media/images/noimage.png';
                                }

                                if ($item->domain) {
                                    $item_link = '//' . $item->domain . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title);
                                } else {
                                    $item_link = '//' . $item->sho_link . '.' . domain_site . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title);
                                }
                                ?>
                                <li class="bochontin_<?php echo $item->not_id ?>">
                                    <a href="<?php echo $item_link ?>">
                                        <div class="pull-left" style="width:44px; height:44px; margin-right: 15px">
                                            <div class="fix1by1 img-circle">
                                                <div class="c" style="background: #fff url('<?php echo $item_image ?>') no-repeat center / cover"></div>
                                            </div>
                                        </div>                                                                                    
                                        <?php echo $item_title ?>                                        
                                    </a>
                                    <?php if ($this->session->userdata('sessionUser') == $siteGlobal->sho_user) { ?>
                                        <button class="btn btn-danger btn-xs" onclick="bochontin2(<?php echo $item->not_id ?>);"> X </button>
                                    <?php } ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>	
                    </div>	
                </div>	
                <?php } ?>
                
                <div class="fixtoscroll">
                    <div style="height:600px; background: #f9f9f9; display: table-cell; width: 1%; vertical-align: middle; text-align: center;">
                        Liên hệ quảng cáo<br><span style="font-size: 24px"><?=settingPhone?></span><br>(300 x 600)
                    </div>                        
                </div>
                <br>
	    </div> 

            <div class="col-lg-2 hidden-md hidden-sm hidden-xs">  
                <?php $this->load->view('shop/common/adsright'); ?>
            </div>                       
        </div>
    </div>
<?php endif; ?>
<div class="clearfix"></div>
<?php if ($this->session->userdata('sessionGroup') == AffiliateUser) { ?>
    <!--Display call-->
    <?php
    if ($siteGlobal->sho_phone) {
        $phonenumber = $siteGlobal->sho_phone;
    } elseif ($siteGlobal->sho_mobile) {
        $phonenumber = $siteGlobal->sho_mobile;
    }
    if ($phonenumber) {
        ?>    
        <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
            <div class="phonering-alo-ph-circle"></div>
            <div class="phonering-alo-ph-circle-fill"></div>            
            <div class="phonering-alo-ph-img-circle">
                <a href="tel:<?php echo $siteGlobal->sho_mobile; ?>">
                    <img data-toggle="modal" data-target=".bs-example-modal-md" src="//i.imgur.com/v8TniL3.png" alt="Liên hệ" width="50" onmouseover="this.src = '//i.imgur.com/v8TniL3.png';" onmouseout="this.src = '//i.imgur.com/v8TniL3.png';">
                </a>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>    
    <?php if ($packId1 == true || $packId2 == true) { ?>
        <?php if ($packId1 == true) { //is Branch  ?>
            <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
                <div class="phonering-alo-ph-circle"></div>
                <div class="phonering-alo-ph-circle-fill"></div>            
                <div class="phonering-alo-ph-img-circle for-affiliate">
                    <a href="<?php echo $mainURL . 'register/affiliate/pid/' . $this->session->userdata('sessionUser'); ?>">
                        <img data-toggle="modal" data-target=".bs-example-modal-md" src="//i.imgur.com/v8TniL3.png" alt="Liên hệ" width="50" onmouseover="this.src = '//i.imgur.com/v8TniL3.png';" onmouseout="this.src = '//i.imgur.com/v8TniL3.png';">
                    </a>
                </div>
            </div>    
        <?php } else { ?> 
            <?php if ($packId2 == true) { ?>
                <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
                    <div class="phonering-alo-ph-circle"></div>
                    <div class="phonering-alo-ph-circle-fill"></div>            
                    <div class="phonering-alo-ph-img-circle for-affiliate">
                        <a href="<?php echo $mainURL . 'register/affiliate/pid/' . $siteGlobal->sho_user; ?>">
                            <img data-toggle="modal" data-target=".bs-example-modal-md" src="//i.imgur.com/v8TniL3.png" alt="Liên hệ" width="50" onmouseover="this.src = '//i.imgur.com/v8TniL3.png';" onmouseout="this.src = '//i.imgur.com/v8TniL3.png';">
                        </a>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>

<?php } ?>
 <script>
    function copylink(link) { clipboard.copy(link); }
    jQuery(function ($) {
        <?php if ($isMobile == 1) { ?>

        <?php } else { ?>
           $('.fixtoscroll').scrollToFixed({
               marginTop: function () {
                   var marginTop = $(window).height() - $(this).outerHeight(true) - 0;
                   if (marginTop >= 0)
                       return 75;
                   return marginTop;
               },
               limit: function () {
                   var limit = 0;
                   limit = $('#footer').offset().top - $(this).outerHeight(true) - 0;
                   return limit;
               }
           });
        <?php } ?>
     });    
 </script>   
<?php $this->load->view('shop/news/footer'); ?>

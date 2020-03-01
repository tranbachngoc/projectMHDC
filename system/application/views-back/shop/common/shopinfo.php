<div class="shop_boxes">
    <?php
	
    $filebanner = DOMAIN_CLOUDSERVER.'media/shop/banners/' . $siteGlobal->sho_dir_banner . '/' . $siteGlobal->sho_banner;
    if($siteGlobal->sho_dir_banner != ""){
        $sho_banner = $filebanner;
    } else {
        $sho_banner = site_url('media/shop/banners/default-banner.jpg');
    }
    if ($isAffiliate == TRUE && $siteGlobal->sho_dir_banner == 'defaults') {
        $sho_banner = DOMAIN_CLOUDSERVER.'media/shop/banners/' . $Pa_Shop_Global->sho_dir_banner . '/' . $Pa_Shop_Global->sho_banner;
    }    
    $filelogo = DOMAIN_CLOUDSERVER.'media/shop/logos/' . $siteGlobal->sho_dir_logo . '/' . $siteGlobal->sho_logo;            
    if ( $siteGlobal->sho_logo!="") {
        $sho_logo = $filelogo;
    } else {
        $sho_logo = site_url('images/no-logo.png');
    }     
    if ($af_id != '') {
	$af_key = '?af_id=' . $af_id;
    } else {
	$af_key = '';
    }	
    ?>
    
    <div class="shop_banner">
        <div class="fix16by9">
            <div class="c" style="background: #fff url('<?php echo $sho_banner; ?>') no-repeat center / cover"></div>
        </div>
    </div>
   
    <div class="shop_brand" style="display: table; width: 100%;">
	<div class="shop__logo" style="display: table-cell; width:60px; padding: 15px;">	    
	    <a href="#">
		<span style="
		    display:block; width:60px; height: 60px; border: 1px solid #eee; border-radius: 50%; overflow: hidden;
		    background: url(<?php echo $sho_logo; ?>) center center / cover no-repeat;">
	       </span>
	    </a>
	</div>
	<div class="shop__name" style="display: table-cell; vertical-align: middle;">	    
	    <strong><?php echo $siteGlobal->sho_name ?></strong>
	    <br/>
	    <a href="/">
		<em>@<?php echo $siteGlobal->sho_link ?></em>
	    </a>	    
	</div>
    </div>
    
    
    
    <div class="shop_bar">
	<div style="padding:15px 10px; border-bottom: 1px solid #ddd;">
	    <a class="btn btn-link" disabled><i class="azicon icon-forward-right"></i>&nbsp; Theo dõi</a>
	    <div class="dropdown pull-right">
		<?php if ($this->session->userdata('sessionUser') != $siteGlobal->sho_user) { ?>               
		    <a class="btn btn-link" href="tel:<?php echo $siteGlobal->sho_mobile ?>" onclick="_gaq.push(['_trackEvent', 'Contact', 'Call Now Button', 'Phone']);">
			<i class="azicon icon-call"></i><span class="hidden-xs">&nbsp; Gọi ngay</span>
		    </a> 
		    <?php if ($siteGlobal->sho_facebook) {
			$face = explode("https://www.facebook.com/", $siteGlobal->sho_facebook);
			$facebook_id = str_replace('profile.php?id=', '', $face[1]);
			?>
			<a class="btn btn-link" target="_blank" href="https://www.messenger.com/t/<?php echo $facebook_id ?>">
			    <i class="azicon icon-message"></i><span class="hidden-xs">&nbsp; Nhắn tin</span>
			</a>
		    <?php } else { ?>
			<a class="btn btn-link" target="_blank" href="sms:<?php echo $siteGlobal->sho_mobile ?>">
			    <i class="azicon icon-message"></i><span class="hidden-xs">&nbsp; Gửi SMS</span>
			</a>
		    <?php } ?>
		<?php } ?>
		<button class="btn btn-link dropdown-toggle" type="button" id="share" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
		    <i class="azicon icon-share"></i><span class="hidden-xs">&nbsp; Chia sẻ</span>
		</button>
		<ul class="dropdown-menu" aria-labelledby="share" style="padding: 15px 0;">
		    <li>
			<a href="javascript:void(0)" onclick=" window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $linktoshop.$af_key ?>&amp;app_id=<?php echo app_id ?>','facebook-share-dialog','width=600,height=450'); return false;">
			    <i class="azicon icon-facebook"></i> &nbsp; Facebook
			</a>
		    </li>
		    <li>
			<a href="javascript:void(0)" onclick="window.open('http://twitter.com/share?text=<?php echo $siteGlobal->sho_name ?>&amp;url=<?php echo $linktoshop.$af_key ?>&amp;hashtags=azibai','twitter-share-dialog', 'width=600,height=450');
				return false;">
			    <i class="azicon icon-twitter"></i> &nbsp; Twitter
			</a>
		    </li>
		    <li>
			<a href="javascript:void(0)" onclick=" window.open('http://plus.google.com/share?url=<?php echo $linktoshop.$af_key ?>','google-share-dialog','width=600,height=450');return false;">
			    <i class="azicon icon-google"></i> &nbsp; Google+
			</a>
		    </li>
		    <li>
			<a href="mailto:someone@example.com?Subject=<?php echo $siteGlobal->sho_name; ?>&amp;Body=<?php echo $siteGlobal->sho_descr . '-' . $linktoshop.$af_key; ?>">
			    <i class="azicon icon-email"></i> &nbsp; Gửi email
			</a>
		    </li>
		    <li>
                        <a href="javascript:void(0)" onclick="copylink('<?php echo $linktoshop.$af_key ?>')">
                            <i class="azicon icon-coppy"></i>&nbsp; Sao chép liên kết
                        </a>
                    </li> 
		</ul>
	    </div>
	</div>
		
        <ul class="menu-justified dropdown small">	       
            <li class="active"><a href="/"><i class="azicon icon-home"></i><br>Trang chủ</a></li>
	    <li class="">
                <a id="dLabel" data-target="#" href="<?php echo $linktoshop ?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="azicon icon-newspaper"></i><br>Loại tin
                </a>
                <ul class="dropdown-menu" aria-labelledby="dLabel" style="left: 0px; right:0px;">
                    <li>
                        <a href="/news/hot"><i class="azicon icon-hot"></i>&nbsp; Tin tức hot </a>
                    </li>
                    <li>
                        <a href="/news/promotion"><i class="azicon icon-gift"></i>&nbsp; Tin khuyến mãi </a>
                    </li>
                    <li>
                        <a href="/news/view"><i class="azicon icon-eye"></i> &nbsp; Tin xem nhiều </a>
                    </li>                    
                </ul>
            </li>
			
           
	    <li class="">
		<a href="<?php echo $linktoshop . '/shop'; ?>">
		    <i class="azicon icon-store"></i><br>Cửa hàng
		</a>
	    </li>  		
           
	    <li><a href="/shop/introduct"><i class="azicon icon-info-circle"></i><br>Giới thiệu</a></li>
	    
	    <?php /*if ($siteGlobal->isAffiliate) { ?>
    	    <li><a class="hover" href="<?php echo '/shop/' . $tlink . '/pro_type/0-Tat-ca-san-pham' ?>"><i class="fa fa-info-circle fa-fw"></i>&nbsp; Sản phẩm</a></li>
	    <?php } else { ?>
    	    <li><a class="hover" href="<?php echo '/shop/' . $tlink ?>"><i class="azicon icon-cubes"></i><br>Sản phẩm</a></li>
	    <?php } ?>	    
	    <?php if ($siteGlobal->isAffiliate) { ?>
    	    <li><a class="hover" href="<?php echo '/shop/' . $afLink . '/pro_type/2-Tat-ca-coupon' ?>"><i class="azicon icon-tags"></i><br>Coupon</a></li>
	    <?php } else { ?>
    	    <li><a class="hover" href="<?php echo '/shop/' . $afLink ?>"><i class="azicon icon-tags"></i><br>Coupon</a></li>
	    <?php }*/ ?>
	    
	   
            <li class="">
                <a id="dLabel" data-target="#" href="<?php echo $linktoshop ?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <i class="azicon icon-more"></i><br>Khác
                </a>
                <ul class="dropdown-menu" aria-labelledby="dLabel" style="left: 0px; right:0px;">
		     <?php if (!$siteGlobal->isAffiliate) { ?>		    
		    <li><a href="/shop/warranty"><i class="azicon icon-list-square"></i> &nbsp; Chính sách</a></li>
		    <?php } ?>
		    <li><a href="/shop/contact"><i class="azicon icon-email"></i> &nbsp; Liên hệ</a></li>
		    <li><a href="<?php echo $mainURL ?>"><i class="azicon icon-azibai"></i> &nbsp; Azibai</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>

<div class="shop_boxes">
    <div class="introduce" style="padding: 5px">
        
        <div style="padding: 5px">
            <span class="pull-left" style="margin-top:3px;">
                <i class="azicon icon-info-circle"></i>
            </span>
            <div style="margin-left: 30px">
                <?php echo $siteGlobal->sho_descr ?>
            </div>
        </div>
        <div style="padding: 5px">
            <span class="pull-left" style="margin-top:3px;">
                <i class="azicon icon-map-marker"></i>
            </span>
            <div style="margin-left: 30px">
                <?php echo $siteGlobal->sho_address . ', ' . $siteGlobal->sho_district . ', ' . $siteGlobal->sho_province ?>
            </div>
        </div>        
        <?php if($siteGlobal->sho_phone) { ?>
        <div style="padding: 5px">
            <span class="pull-left" style="margin-top:3px;">
                <i class="azicon icon-call"></i>
            </span>
            <div style="margin-left: 30px">
                <?php echo $siteGlobal->sho_phone ?>
            </div>
        </div>
        <?php } ?>
        <?php if($siteGlobal->sho_mobile) { ?>
        <div style="padding: 5px">
            <span class="pull-left" style="margin-top:3px;">
                <i class="azicon icon-mobile"></i>
            </span>
            <div style="margin-left: 30px">
                <?php echo $siteGlobal->sho_mobile ?>
            </div>
        </div>
        <?php } ?>
        <?php if($siteGlobal->sho_email) { ?>
        <div style="padding: 5px">
            <span class="pull-left" style="margin-top:3px;">
                <i class="azicon icon-email"></i>
            </span>
            <div style="margin-left: 30px">
                <?php echo $siteGlobal->sho_email ?>
            </div>
        </div>
        <?php } ?>        
        <?php if($siteGlobal->sho_facebook) { ?>
        <div style="padding: 5px">
            <span class="pull-left" style="margin-top:3px;">
                <i class="azicon icon-facebook-2"></i>
            </span>
            <div style="margin-left: 30px;text-overflow: ellipsis; white-space: nowrap; overflow: hidden; height: 20px;">
                <a href="
                   <?php echo $siteGlobal->sho_facebook ?>" target="blank">
                       <?php echo $siteGlobal->sho_facebook ?>
                </a>
            </div>
        </div>
        <?php } ?>
	<br>
	<div style="padding: 5px">
            <span class="pull-left" style="margin-top:3px;">
                <i class="azicon icon-more-circle"></i>
            </span>
            <div style="margin-left: 30px">
                <a href="/shop/introduct">Xem thêm</a>
            </div>
        </div>	
    </div>
</div>
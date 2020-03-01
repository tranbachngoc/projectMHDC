<div class="group-top">
    <?php
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $domainName = $_SERVER['HTTP_HOST'];
    $arrUrl = explode('.', $domainName);
    if (count($arrUrl) === 3) {
        $url = '';
        $url = $arrUrl[1] . '.' . $arrUrl[2];
    } else {
        $url = $domainName;
    }
    $get_grt = $this->grouptrade_model->get('*', 'grt_link = "'. trim(strtolower($arrUrl[0])) .'" AND grt_status = 1');
    ?>
    <?php
        $link_banner = site_url('media/group/banners/default/default_banner.jpg');
        if( $get_grt->grt_banner != '') {        
            $link_banner = DOMAIN_CLOUDSERVER.'media/group/banners/'. $get_grt->grt_dir_banner.'/'.$get_grt->grt_banner;
        }        
        $link_logo = site_url('media/group/logos/default/default_avatar.jpg');
        if( $get_grt->grt_logo != '') {        
            $link_logo = DOMAIN_CLOUDSERVER.'media/group/logos/'. $get_grt->grt_dir_logo.'/'.$get_grt->grt_logo;
        }        
    ?>
    <div class="group-banner">
        <div class="fix16by9" style="
	     background: url(<?php echo $link_banner; ?>) no-repeat center center; 
	    -webkit-background-size: cover;
	    -moz-background-size: cover;
	    -o-background-size: cover;
	    background-size: cover;
	    ">
        </div>
    </div>
    <div class="group-logo img-circle">
        <div style="background: #fff url('<?php echo $link_logo; ?>') no-repeat center center / 100% auto;"></div>
    </div>
    <div class="group-title text-center" style="text-transform: uppercase">
        <?php echo $get_grt->grt_name; ?>
    </div>
    <div class="group-menu">
        <ul>
            <li>
                <a href="/grtshop/introduction">
                    <i class="azicon icon-info-circle"></i><br>Giới thiệu
                </a>
            </li>
            <li>                
                <a href="tel:<?php echo $get_grt->grt_mobile ?>" onclick="_gaq.push(['_trackEvent', 'Contact', 'Call Now Button', 'Phone']);">
		    <i class="azicon icon-call"></i><br>Gọi ngay
		</a>
            </li>            
            <li>
                <?php if( $get_grt->grt_message != '') {  ?>
                <a target="_blank" href="<?php echo $get_grt->grt_message; ?>"><i class="azicon icon-comment"></i><br>Nhắn tin</a>
                <?php } else { ?>
                <a target="_blank" href="sms:<?php echo $get_grt->grt_mobile; ?>"><i class="azicon icon-comment"></i><br>Nhắn tin</a>
                <?php } ?>
            </li>            
            <li>
		<a href="#"  data-toggle="modal" data-target=".share-modal-sm">
		    <i class="azicon icon-share"></i><br>Chia sẻ
		</a>
            </li>            
            <li>
                <a href="/grtnews/members"><i class="azicon icon-group"></i><br>Thành viên</a>
            </li>
            <li>
                <a href="/grtnews/landing_page"><i class="azicon icon-file"></i><br>Tờ rơi</a>
            </li>            
        </ul>
    </div>
</div>
<div class="modal fade share-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
	<div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Chia sẻ trang</h4>
      </div>
	<div class="modal-body">
	    <ul class="nav">
		<li><a  href="javascript:void(0)" onclick=" window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo current_url() ?>&amp;app_id=<?php echo app_id ?>', 'facebook-share-dialog', 'width=600,height=450'); return false;">
		    <img src="/templates/home/icons/icon-facebook.png" alt="facebook"> Facebook
		</a></li>
		<li><a href="javascript:void(0)" onclick="window.open('http://twitter.com/share?text=<?php echo $get_grt->grt_name ?>&amp;url=<?php echo current_url() ?>', 'twitter-share-dialog', 'width=600,height=450'); return false;">
		    <img src="/templates/home/icons/icon-twitter.png" alt="twitter"> Twitter
		</a></li>
		<li><a href="javascript:void(0)" onclick=" window.open('http://plus.google.com/share?url=<?php echo current_url() ?>', 'google-share-dialog', 'width=600,height=450');return false;">
		    <img src="/templates/home/icons/icon-google-plus.png" alt="google-plus"> Google plus
		</a></li>                            
		<li><a href="javascript:void(0);" onclick="copylink('<?php echo current_url() ?>');">
		    <img src="/templates/home/icons/black/icon-coppy.png" alt="coppy-link"> Sao chép liên kết
		</a></li>
		<li><a target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&amp;fs=1&amp;to&amp;su=<?php echo $get_grt->grt_name ?>&amp;body=<?php echo current_url() ?>&amp;ui=2&amp;tf=1">
		    <img src="/templates/home/icons/black/icon-email.png" alt=""> Gửi email
		</a></li>                            
	    </ul>
	</div>
    </div>
  </div>
</div>

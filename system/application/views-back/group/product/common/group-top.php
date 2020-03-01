<style>
    .group-logo div {
        background: #505050;
        text-align: center;
    }
</style>
<div class="group-top">
    <div class="group-banner">
        <div class="fix3by1"
             style="background: url('<?php if( $get_grt->grt_banner == '') { ?>http://webdesign-finder.com/html/a-group/images/gallery/05.jpg<?php } else { echo '/media/group/banners/'.$get_grt->grt_dir_banner.'/'.$get_grt->grt_banner;} ?>') no-repeat center / 100% auto">
        </div>
    </div>
    <div class="group-logo">
        <div>
            <img class="img-circle" src="<?php if( $get_grt->grt_logo != '') {  echo '/media/group/logos/'.$get_grt->grt_dir_logo.'/'.$get_grt->grt_logo;} ?>"></a>
        </div>
    </div>
    <div class="group-title text-center">
        <?php echo $get_grt->grt_name; ?>
    </div>
    <div class="group-menu">
        <ul class="menu-justified dropdown" style="font-size:12px;">

            <li class="">
                <a id="dLabel" data-target="#" href="/group/gioi-thieu" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="/templates/home/icons/black/icon-user.png" alt=""><br>Giới thiệu
                </a>
            </li>

            <li class="">
                <a href="tel:<?php echo $get_grt->grt_mobile ?>" onclick="_gaq.push(['_trackEvent', 'Contact', 'Call Now Button', 'Phone']);"><img src="/templates/home/icons/black/icon-call.png" alt=""><br>Gọi ngay</a>
            </li>
            <?php if( $get_grt->grt_message != '') {  ?>
                <li class="">
                    <a target="_blank" href="<?php echo $get_grt->grt_message; ?>"><img src="/templates/home/icons/black/icon-comment.png" alt=""><br>Nhắn tin</a>
                </li>
            <?php } ?>
            <li class="">
                <a id="dLabel" data-target="#" href="" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="/templates/home/icons/black/share-outline.png" alt=""><br>Chia sẻ
                </a>
                <ul class="dropdown-menu" aria-labelledby="dLabel" style="left: 0px; right:0px;">
                    <li>
                        <a href="../../default/default.php"></a>
                        <div>
                            <a href="javascript:void(0)" onclick=" window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo current_url() ?>&amp;app_id=<?php echo app_id ?>', 'facebook-share-dialog', 'width=600,height=450'); return false;">
                                <img src="/templates/home/icons/icon-facebook.png" alt="">
                            </a> &nbsp;
                            <a href="javascript:void(0)" onclick="window.open('http://twitter.com/share?text=Công ty TNHH Ngân Nguyễn&amp;url=http://appbanhang.net', 'twitter-share-dialog', 'width=600,height=450');
                                                return false;">
                                <img src="/templates/home/icons/icon-twitter.png" alt="">
                            </a> &nbsp;
                            <a href="javascript:void(0)" onclick=" window.open('http://plus.google.com/share?url=http://appbanhang.net', 'google-share-dialog', 'width=600,height=450');return false;">
                                <img src="/templates/home/icons/icon-google-plus.png" alt="">
                            </a>
                            <a href="mailto:someone@example.com?Subject=Công ty TNHH Ngân Nguyễn&amp;Body=Tiền thân là Công ty Đầu tư Thương mại và Dịch vụ được thành lập từ năm 1986.-http://appbanhang.net" class="pull-right">
                                <img src="/templates/home/icons/black/icon-email.png'); ?&gt;" alt="">
                            </a>
                        </div>
                    </li>                                
                </ul>
            </li>

            <li class="">
                <a id="dLabel" data-target="#" href="group/quang-cao" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <img src="/templates/home/icons/black/icon-bullhorn.png" alt=""><br>Quảng cáo
                </a>                            
            </li>
        </ul>
    </div>
</div> 
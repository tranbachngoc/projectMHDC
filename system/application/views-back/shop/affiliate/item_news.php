<?php
$suffix = !empty($shop->user_af_key) ?  '?af_id='. $shop->user_af_key : '';
$shopdomain = $item->domain ? $protocol . $item->domain :  $protocol . $item->sho_link .'.'. domain_site;  
$item_link = $shopdomain . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title) . $suffix;
?>

<div id="item<?php echo $item->not_id ?>" class="itempost">
    <div class="rowtop">        
        <div class="pull-left" style="position: relative; margin-right: 10px; width: 48px; height: 48px; z-index: 1;">
            <?php
            if ($item->sho_logo) {
                $shop_logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $item->sho_dir_logo . '/' . $item->sho_logo;
            } else {
                $shop_logo = 'media/images/no-logo.png';
            }
            ?>
            <a class="img-circle" 
               href="<?php echo $shopdomain; ?>"
               style="border: 1px solid #f7f8f9; display: block; height:100%; background: url('<?php echo $shop_logo; ?>') no-repeat center center / cover ">
            </a>                                        
        </div>                                                                      
        <div class="dropdown">
	    <a href="<?php echo $shopdomain; ?>">
		<strong class="text-capitalize"><?php echo $item->sho_name ?></strong>
	    </a><br> 
            <i class="azicon16 icon-clock"></i>
            <span class="small"><?php echo date('d/m/Y', $item->not_begindate); ?></span> &nbsp;
            <?php if ($this->session->userdata('sessionUser') == $item->sho_user) { ?>
            <span>
		<a  href="#" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		    <i class="azicon16 icon-permission-<?php echo $item->not_permission ?>" data-toggle="tooltip" data-placement="top" title="<?php echo  $item->not_permission_name ?>"></i>
                </a>
                <ul class="permission dropdown-menu" aria-labelledby="dLabel" style="left: -10px; right:-10px; margin-top: 10px;">
                    <?php foreach ($permission as $key => $value) { if($key + 1 == 5) continue; ?>
                        <li class="<?php echo $item->not_permission == (int) $value->id ? 'current' : '' ?>">
                            <a href="javascript:void(0)" onclick="setpermission(<?php echo $item->not_id . ',' . ($key + 1) ?>)">				
				<i class="azicon icon-permission-<?php echo $key + 1 ?>"></i>
				&nbsp; <?php echo $value->name ?></a>
                        </li>
                    <?php } ?>
                </ul>
	    </span>
            <?php } else { ?>
		<i class="azicon16 icon-permission-<?php echo $item->not_permission ?>" data-toggle="tooltip" data-placement="top" title="<?php echo  $item->not_permission_name ?>"></i>
            <?php } ?>
	    <span>
            <a href="#" class="pull-right" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="azicon16 icon-more"></i>
            </a>                                        
            <?php if ($this->session->userdata('sessionUser') == $item->sho_user) : ?>
                <ul class="more dropdown-menu" aria-labelledby="dLabel">                    
                    <li>
                        <a href="javascript:void(0)" onclick="ghimtin(<?php echo $item->not_id ?>)">
			    <i class="azicon icon-tack"></i> &nbsp; Ghim tin lên đầu trang</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="antinnay(<?php echo $item->not_id ?>)">
			    <i class="azicon icon-hidden"></i> &nbsp; Ẩn tin này</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="xoatinnay(<?php echo $item->not_id ?>)">
			    <i class="azicon icon-remove"></i> &nbsp; Xóa tin này</a>
                    </li>
                    <!--li>
                        <a href="#quang-cao"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-bullhorn.png" alt="Quảng cáo"> &nbsp; Quảng cáo</a>
                    </li-->
                </ul>
            <?php else : ?>
                <ul class="more dropdown-menu" aria-labelledby="dLabel">
                    <li>
                        <a href="<?php echo getAliasDomain('shop'); ?>">
                            <i class="azicon icon-store"></i> &nbsp; Đến gian hàng
                        </a>          
                    </li>
                    <li>
                        <a href="tel:<?php echo $item->sho_mobile ?>">
			    <i class="azicon icon-call"></i> &nbsp; Gọi cho gian hàng
			</a>
                    </li>
                    <?php
                    if ($item->sho_facebook) {
                        $face = explode("https://www.facebook.com/", $item->sho_facebook);
                        $facebook_id = str_replace('profile.php?id=', '', $face[1]);
                        $messages = 'https://www.messenger.com/t/' . $facebook_id;
                        ?>
                        <li>
                            <a target="_blank" href="<?php echo $messages ?>">
				<i class="azicon icon-message"></i>&nbsp; Gửi tin nhắn
			    </a>
                        </li>
                        <?php
                    } elseif ($item->sho_mobile) {
                        $messages = 'sms:' . $item->sho_mobile;
                        ?>
                        <li>
                            <a target="_blank" href="<?php echo $messages ?>">
				<i class="azicon icon-message"></i> &nbsp; Gửi tin nhắn
			    </a>
                        </li>
                    <?php } ?>
		    <!--li>
			<a href="#" class="report" data-link="<?php echo $item_link ?>" data-id="<?php echo $item->not_id; ?>" data-toggle="modal" data-target="#reportModal">
			    <i class="azicon icon-report"></i> &nbsp; Gửi báo cáo
			</a>
		    </li-->
                </ul>
            <?php endif; ?>
	    </span>
	</div>
    </div>
    <div class="clearfix"></div>
    <div class="rowmid"> 
        
         <?php if ($item->not_video_url1) { ?>			
            <div class="embed-responsive embed-responsive-16by9" style="margin-bottom: 1px;">
                <video controls class="embed-responsive-item">
                    <source src="<?php echo DOMAIN_CLOUDSERVER . 'video/' . $item->not_video_url1 ?>" type="video/mp4">
                    Your browser does not support the video tag.
               </video>
            </div>
        <?php } ?> 
        
        <?php if (count($item->listImg) > 0) { ?>	
            <div class="rowslide" id="slide_<?php echo $item->not_id ?>">		
                <div class="owl-carousel owl-theme">
                    <?php foreach ($item->listImg as $key => $value) { ?>
                        <div>
                            <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/1x1_' . $value->image ?>" 
                                 alt="<?php echo ($value->title) ? $value->title : $item->not_title ?>" 
                                 title="<?php echo ($value->title) ? $value->title : $item->not_title ?>" 
                                 id="wows1_<?php echo $key ?>" />                                               
                        </div>
                    <?php } ?>
                </div>
            </div>
            <script>
            jQuery(function($){
                $('#slide_<?php echo $item->not_id ?> .owl-carousel').owlCarousel({ loop: false, margin: 0, navText: ['<i class="fa fa-angle-left fa-fw fa-3x"></i>','<i class="fa fa-angle-right fa-fw fa-3x"></i>'], dots: true, items:1, responsive : {0 : { nav: false }, 1000 : { nav: true } } });
            });
            </script>
        <?php } else { ?>
            <?php if (strlen($item->not_image) > 10) { ?>                
                <div class="r-image"> 
                    <a href="<?php echo $item_link; ?>"> 
                        <img class="lazy" width="100%" data-src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/thumbnail_3_' .$item->not_image; ?>" alt=""/>						
                    </a>
                </div>         
            <?php } ?>
        <?php } ?>            
	
        <div class="r-title">                                
            <h4><a href="<?php echo $item_link; ?>"><?php echo $item->not_title ?></a></h4>
        </div>
        <div class="r-text">
            <?php echo $item->not_description; ?>
        </div>
        <p class="small">
            <a class="viewmore" href="<?php echo $item_link; ?>"><em> → Xem tiếp</em></a>
            <span class="pull-right text-muted"><?php echo $item->comments ?> bình luận &nbsp; <?php echo $item->solanchon ?> lượt chọn tin</span>
        </p>
    </div>

    <?php if (count($item->listPro) > 0) { ?>	
        <div class="rowpro" style="padding: 0 10px">		
            <div class="owl-carousel">
                <?php 
                if($item->domain){ $a = $protocol . $item->domain; } else { $a = $protocol . $item->sho_link . '.' . domain_site; }
                foreach ($item->listPro as $k => $value) {
                    if ($value->pro_type == 0) { $pro_type = 'product'; } elseif ($value->pro_type == 1) {$pro_type = 'service'; } else { $pro_type = 'coupon'; }
                    $linktoproduct = $a . '/shop/' . $pro_type . '/detail/' . $value->pro_id . '/' . RemoveSign($value->pro_name) . $suffix;
                    ?>
                    <div class="itempro" style="border: 1px solid #eee; height: 85px;"> 				
                        <a href="<?php echo $linktoproduct ?>">
                            <img class="pull-left" style="height: 83px; width: 83px; margin-right:10px"
                                 src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $value->pro_dir . '/' . show_image($value->pro_image); ?>"/>
                        </a>				
                        <div class="small" style="padding: 6px 0">
                            <div class="proname" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><strong><a href="<?php echo $linktoproduct ?>"><?php echo $value->pro_name ?></a></strong></div>				
                            <div class="procost"><?php echo number_format($value->pro_cost, 0, ",", ".") . ' ' . $value->pro_currency ?></div>
                            <?php if($value->end_date_sale != '' && $value->end_date_sale > strtotime(date("Y-m-d")) ) { ?>	
                                <div class="text-primary"><i class="fa fa-clock-o" aria-hidden="true"></i> <span  data-countdown="<?php echo date("Y-m-d",$value->end_date_sale) ?>"></span></div>
                            <?php } else { ?>
                                <div class="probuy"><a href="<?php echo $linktoproduct ?>" class="btn btn-default btn-xs">→ Xem chi tiết</a></div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>          
    <?php } ?>

    <div class="rowbot small">
        <div class="dropdown text-center">
            <span>
                <a href="<?php echo $item_link ?>#comments">
		    <i class="azicon icon-comment"></i> &nbsp; Bình luận</a>
            </span>
            <span>
                <?php if ($this->session->userdata('sessionUser') == $item->sho_user) : ?>   
                    <a id="dLabel1" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                        <i class="azicon icon-statistic"></i> &nbsp; Thống kê
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dLabel1" style="left: 0px; right:0px;">
                        <li>
                            <a>
                                <span class="pull-right"><?php echo $item->not_view; ?></span>
				<i class="azicon icon-eye"></i> &nbsp; Số lượt xem tin 
			    </a>
                        </li>
                        <li>
                            <a href="<?php echo $linktoshop . '/news/danh-sach-chon-tin/' . $item->not_id . '/' . RemoveSign($item->not_title); ?>">
                                <span class="pull-right" ><?php echo $item->solanchon ?></span>
                                <i class="azicon icon-filter"></i> &nbsp; Số lượt chọn tin 
                            </a>
                        </li>
                    </ul>
                <?php else: ?>
                    &nbsp;
                <?php endif; ?>
            </span>
            <?php if($item->not_permission == 1) { ?>
            <span>
                <a id="dLabel2" href="<?php echo $item_link ?>" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                    <i class="azicon icon-share"></i> &nbsp; Chia sẻ
                </a>
                <ul class="dropdown-menu" aria-labelledby="dLabel2" style="left: 0px; right:0px;">

                    <li class="social-share">
                        <div>
                            <a href="javascript:void(0)" onclick="
                                    window.open(
                                            'https://www.facebook.com/sharer/sharer.php?u=<?php echo $item_link ?>&amp;app_id=<?php echo app_id ?>',
                                            'facebook-share-dialog',
                                            'width=800,height=600');
                                    return false;">
                                <i class="azicon icon-facebook"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="
                                    window.open(
                                            'https://twitter.com/share?text=<?php echo $item->not_title ?>&amp;url=<?php echo $item_link ?>',
                                            'twitter-share-dialog',
                                            'width=800,height=600');
                                    return false;">
                                <i class="azicon icon-twitter"></i>
                            </a>
                            <a href="javascript:void(0)" onclick="
                                    window.open(
                                            'https://plus.google.com/share?url=<?php echo $item_link  ?>',
                                            'google-share-dialog',
                                            'width=800,height=600');
                                    return false;">
                                <i class="azicon icon-google"></i>
                            </a>

                            <a style="display:inline-block; margin-right: 15px;" target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to&su=<?php echo $item->not_title ?>&body=<?php echo $item_link ?>&ui=2&tf=1" class="pull-right">
                                <i class="azicon icon-email"></i>
                            </a>
                        </div>                                        
                    </li>


                    <li>
                        <a href="javascript:void(0)" onclick="copylink('<?php echo $item_link ?>');">
                            <i class="azicon icon-coppy"></i> &nbsp; Sao chép liên kết
                        </a>
                    </li>

                    <?php if ($item->chochontin == 1) : ?>
                        <?php if ($item->dachon == 0) { ?>
                            <li class="chontin">
                                <a  href="javascript:void(0)"  onclick="chontin(<?php echo $item->not_id.','.$item->sho_user ?> );"><i class="azicon icon-square"></i> &nbsp;Chọn tin</a>
                            </li>
                        <?php } else { ?>
                            <li class="bochontin">
                                <a  href="javascript:void(0)"  onclick="bochontin(<?php echo $item->not_id.','.$item->sho_user ?>);"><i class="azicon icon-check-square"></i> &nbsp; Bỏ chọn tin</a>
                            </li>
                        <?php } ?>
                    <?php endif; ?>

                </ul>
            </span>
            <?php } ?>
        </div>
    </div>        
</div>

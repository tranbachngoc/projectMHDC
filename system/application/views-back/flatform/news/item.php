<?php    
    $item_link = getAliasDomain() . 'flatform/news/' . $item->not_id . '/' . RemoveSign($item->not_title);     
    $fileimage = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/thumbnail_3_' .$item->not_image; 
    if ($item->sho_logo!="") {
	$shop_logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $item->sho_dir_logo . '/' . $item->sho_logo;
    } else {
	$shop_logo = site_url('templates/home/images/no-logo.jpg');
    }
    $linkshop = ($item->domain!='') ? 'http://'.$item->domain : 'https://'.$item->sho_link . '.' . domain_site;
?>
<div id="item<?php echo $item->not_id ?>" class="itempost col-xs-12">
    <div class="rowtop">
        <div class="dropdown">
            <a href="#" class="pull-right" id="aLabel<?php echo $item->not_id ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img src="<?php echo base_url() ?>templates/home/icons/black/icon-more.png" alt="more">
            </a>                                        
            <?php if ($this->session->userdata('sessionUser') == $item->sho_user) : ?>
                <ul class="more dropdown-menu" aria-labelledby="aLabel<?php echo $item->not_id ?>">
                    <li>
                        <a href="#quang-cao">
                            <img src="<?php echo base_url() ?>templates/home/icons/black/icon-bullhorn.png" alt="Quảng cáo"/> &nbsp; Quảng cáo</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="ghimtin(<?php echo $item->not_id ?>)">
                            <img src="<?php echo base_url() ?>templates/home/icons/black/icon-tack.png" alt="Ghim tin lên đầu trang"/> &nbsp; Ghim tin lên đầu trang</a>
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="antinnay(<?php echo $item->not_id ?>)">
                            <img src="<?php echo base_url() ?>templates/home/icons/black/icon-hidden.png" alt="Ẩn tin"/> &nbsp; Ẩn tin này</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url() ?>account/news/edit/<?php echo $item->not_id; ?>">
                            <img src="<?php echo base_url() ?>templates/home/icons/black/icon-edit.png" alt="Sửa tin"/> &nbsp; Chỉnh sửa tin</a>
                    </li>

                    <li>
                        <a href="javascript:void(0)" onclick="xoatinnay(<?php echo $item->not_id ?>)">
			    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-remove.png" alt="Xóa tin"/> &nbsp; Xóa tin</a>
                    </li>
                </ul>
            <?php else : ?>
                <ul class="more dropdown-menu" aria-labelledby="aLabel<?php echo $item->not_id ?>">
                    <li>
                        <a href="<?php echo ($item->domain!='') ? 'http://'.$item->domain : 'https://'.$item->sho_link . '.' . domain_site; ?>">
                            <img src="<?php echo base_url() ?>templates/home/icons/black/icon-store.png" alt="Đến gian hàng"> &nbsp;
                            Đến gian hàng
                        </a>          
                    </li>
                    <li>
                        <a href="tel:<?php echo $item->sho_mobile ?>">
			    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-call.png" alt="Gọi ngay"> &nbsp; Gọi ngay
			</a>
                    </li>
                    <?php
                    if ($item->sho_facebook) {
                        $face = explode("https://www.facebook.com/", $item->sho_facebook);
                        $facebook_id = str_replace('profile.php?id=', '', $face[1]);
                        $messages = 'https://www.messenger.com/t/'. $facebook_id;
                        ?>
                        <li>
                            <a target="_blank" href="<?php echo $messages ?>">
				<img src="<?php echo base_url(); ?>templates/home/icons/black/icon-comment.png" alt="Gửi tin nhắn"/> &nbsp; Gửi tin nhắn
			    </a>
                        </li>
                    <?php } elseif($item->sho_mobile) {
                        $messages = 'sms:'.$item->sho_mobile; 
                        ?>
                        <li>
                            <a target="_blank" href="<?php echo $messages ?>">
				<img src="<?php echo base_url() ?>templates/home/icons/black/icon-comment.png" alt="Gửi tin nhắn"/> &nbsp; Gửi tin nhắn
			    </a>
                        </li>
                    <?php } ?>					
			<li>
    			    <a href="#" class="report" data-link="<?php echo $item_link ?>" data-id="<?php echo $item->not_id; ?>" data-toggle="modal" data-target="#reportModal">
    				<img src="<?php echo base_url() ?>templates/home/icons/black/icon-report.png" alt="Gửi báo cáo"/> &nbsp; Gửi báo cáo
    			    </a>
    			</li>					
                </ul>
            <?php endif; ?>
        </div>
        <div class="sho_logo pull-left">            
            <a class="sho_logo_small img-circle" 
               href="<?php echo $linkshop ?>"
               style="border:1px solid #eee; display: block; height:100%; background: url('<?php echo $shop_logo ?>') no-repeat center / cover">
            </a>                                        
        </div>
        <a href="<?php echo $linkshop ?>">
            <strong class="text-capitalize"><?php echo $item->sho_link ?></strong>
        </a> 
        <div class="dropdown">            
                <img src="<?php echo base_url() ?>templates/home/icons/black/icon-history.png" alt="Ngày đăng" height="12" />
            <span class="small"><?php echo date('d/m/Y', $item->not_begindate); ?></span> &nbsp;
            <?php if ($this->session->userdata('sessionUser') == $item->sho_user) { ?>
                <a href="#" id="bLabel<?php echo $item->not_id ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-permission-<?php echo $item->not_permission ?>.png" 
                        alt="<?php echo $item->not_permission_name ?>" height="12"
                        data-toggle="tooltip" data-placement="top" title="<?php echo $item->not_permission_name ?>"
                    />
                </a>
                <ul class="permission dropdown-menu" aria-labelledby="bLabel<?php echo $item->not_id ?>">
                    <?php foreach ($permission as $key => $value) { ?>
                        <li class="<?php echo $item->not_permission == (int)$value->id ? 'current' : '' ?>">
                            <a href="javascript:void(0)" onclick="setpermission(<?php echo $item->not_id . ',' . ($key + 1) ?>)">
				<img src="<?php echo base_url() ?>templates/home/icons/black/icon-permission-<?php echo $key + 1 ?>.png" alt="<?php echo $value->name ?>"/>
				&nbsp;<?php echo $value->name ?>
			    </a>
                        </li>
                    <?php } ?>
                </ul>
            <?php } else { ?>                
                    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-permission-<?php echo $item->not_permission ?>.png" 
                        alt="<?php echo $item->not_permission_name ?>" height="12"
                        data-toggle="tooltip" data-placement="top" title="<?php echo $item->not_permission_name ?>"
                    />               
            <?php } ?>
        </div>        
    </div>
    <div class="clearfix"></div>
    <div class="rowmid">
        <?php  if($item->not_slideshow == 1) {  ?>             
            <div class="r-image">
                <div id="wowslider-container<?php echo $item->not_id ?>" class="wowslider-container">
                    <div class="ws_images">
                        <ul>
                            <?php foreach($item->list_image as $key => $val){ ?>
                            <li><img src="<?php echo $val ?>" alt="img1" title="img1" id="wows<?php echo $key ?>_0"/></li>    
                            <?php } ?>
                        </ul>
                    </div>
                    <div class="ws_bullets">
                        <div>
                            <?php foreach($item->list_image as $key => $val){ ?>
                            <a href="#" title="img<?php echo $key ?>">
                                <span><?php echo $key ?></span>
                            </a>
                             <?php } ?>
                        </div>
                    </div>		    
                    <?php if($item->not_music != ""){?>									
                    <audio preload="none" id="audio<?php echo $item->not_id ?>" src="<?php echo '/media/musics/'.$item->not_music; ?>"></audio>
                    <?php } ?>
                </div>
                <script>
                jQuery("#wowslider-container<?php echo $item->not_id ?>").wowSlider({effect:"<?php echo $item->not_effect ?>",prev:"",next:"",duration:20*100,delay:20*100,width:600,height:338,autoPlay:false,autoPlayVideo:true,playPause:true,stopOnHover:false,loop:false,bullets:1,caption:false,captionEffect:"fade",controls:true,controlsThumb:false,responsive:2,fullScreen:false,gestures:2,onBeforeStep:0,images:0});
                </script>
            </div>
        <?php } else { 
            if ($item->not_image != '') { ?>                
                <div class="r-image"> 
                    <a href="<?php echo $item_link; ?>"> 
						<img class="lazy" width="100%" data-src="<?php echo $fileimage; ?>" alt=""/>						
					</a>
                </div> 
            <?php } ?>         
        <?php } ?>
        <div class="r-title">                                
            <a href="<?php echo $item_link; ?>"><strong><?php echo $item->not_title ?></strong></a>
        </div>
        <div class="r-text">
            <?php echo $item->not_description; ?>
        </div>
        <p class="small">
            <a class="viewmore" href="<?php echo $item_link; ?>"><em> → Xem tiếp</em></a>
            <span class="pull-right text-muted"><?php echo $item->comments ?> Bình luận &nbsp; <?php echo $item->chontin ?> lượt chọn tin</span>
        </p>
    </div>
	
	<?php if(count($item->list_product) > 0) { ?>	
	<div class="rowpro" style="padding: 0 10px">		
	    <div class="owl-carousel">
		    <?php foreach ($item->list_product as $k => $value) {
			$linktoproduct = $linkshop . '/shop/product/detail/' . $value->pro_id . '/' . RemoveSign($value->pro_name);
			?>
			<div class="itempro" style="border: 1px solid #eee; height: 80px; margin-bottom: 15px;"> 				
			    <a href="<?php echo $linktoproduct ?>">
				<img class="pull-left" style="height: 78px; width: 78px; margin-right:10px"
				     src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $value->pro_dir . '/' . show_image($value->pro_image); ?>"/>
			    </a>				
			    <div class="small" style="padding: 5px 0">
				<div class="proname" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><strong><a href="<?php echo $linktoproduct ?>"><?php echo $value->pro_name ?></a></strong></div>				
				<div class="procost"><?php echo number_format($value->pro_cost, 0, ",", ".") . ' ' . $value->pro_currency ?></div>
				<div class="probuy"><a href="<?php echo $linktoproduct ?>" class="btn btn-default btn-xs"><i class="fa fa-shopping-cart fa-fw"></i> Mua ngay</a></div>
			    </div>
			</div>
		    <?php } ?>
	    </div>
        </div>
	 <?php } ?>	
	 
    <div class="rowbot small">
        <div class="dropdown text-center" style="padding: 10px 15px">
            <div class="pull-left">
                <a href="<?php echo $item_link ?>#comments">
		    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-comment.png" alt="icon-comment" height="16"> &nbsp;Bình luận
		</a>
            </div>            
            <div class="pull-right">
                <a id="cLabel<?php echo $item->not_id ?>" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                    <img src="<?php echo base_url() ?>templates/home/icons/black/share-outline.png" alt="share-outline" height="16"> &nbsp;Chia sẻ
                </a>
                <ul class="dropdown-menu" aria-labelledby="cLabel<?php echo $item->not_id ?>" style="left: 0px; right:0px;">
                    <li class="social-share">
                        <div>
                            <a onclick="
									window.open(
										'https://www.facebook.com/sharer/sharer.php?u=<?php echo $item_link ?>&amp;app_id=<?php echo app_id ?>',
										'facebook-share-dialog',
										'width=800,height=600');
									return false;">
                                <img src="<?php echo base_url() ?>templates/home/icons/icon-facebook.png" alt="icon-facebook">
                            </a>
                            <a  onclick="
                                    window.open(
                                            'https://twitter.com/share?text=<?php echo $item->not_title ?>&amp;url=<?php echo $item_link ?>',
                                            'twitter-share-dialog',
                                            'width=800,height=600');
                                    return false;">
                                <img src="<?php echo base_url() ?>templates/home/icons/icon-twitter.png" alt="icon-twitter">
                            </a>
                            <a  onclick="
                                    window.open(
                                            'https://plus.google.com/share?url=<?php echo $item_link ?>',
                                            'google-share-dialog',
                                            'width=800,height=600');
                                    return false;">
                                <img src="<?php echo base_url() ?>templates/home/icons/icon-google-plus.png" alt="icon-google-plus">
                            </a>
							<!--<div style="margin-bottom: -6px; margin-left: 20px;" class="zalo-share-button" data-href="<?php echo $item_link; ?>" data-oaid="4348710545234964335" data-layout="2" data-color="blue" data-customize="false"></div>-->
                            <a style="display:inline-block; margin-right: 15px;" href="mailto:someone@example.com?Subject=<?php echo $item->not_title ?>" target="_top" rel="noreferrer" class="pull-right">
								<img src="<?php echo base_url() ?>templates/home/icons/black/icon-email.png" alt="icon-email">
                            </a>
                        </div>                                        
                    </li>
                    <li>
                        <a href="javascript:void(0)" onclick="copylink('<?php echo $item_link ?>')">
                            <img src="<?php echo base_url() ?>templates/home/icons/black/icon-coppy.png" alt="icon-coppy"> &nbsp;Sao chép liên kết
                        </a>
                    </li>
                        
                    <?php if ($item->chochontin == 1) : ?>
                        <?php if ($item->dachon == 0) { ?>
                            <li class="chontin chontin_<?php echo $item->not_id ?>">
                                <a href="javascript:void(0)"  onclick="chontin(<?php echo $item->not_id ?>);"><img src="<?php echo base_url() ?>templates/home/icons/black/icon-no-check.png" alt="icon-no-check"> &nbsp;Chọn tin</a>
                            </li>
                        <?php } else { ?>
                            <li class="bochontin bochontin_<?php echo $item->not_id ?>">
                                <a  href="javascript:void(0)"  onclick="bochontin(<?php echo $item->not_id ?>);">
                                    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-check.png" alt="icon-check"> &nbsp; Bỏ chọn tin</a>
                            </li>
                        <?php } ?>
                    <?php endif; ?>
                </ul>
            </div>
	    <div class="pull-none">
                <?php if ($this->session->userdata('sessionUser') == $item->sho_user && $item->not_pro_cat_id != 0) : ?>   
                    <a id="dLabel<?php echo $item->not_id ?>" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                        <img src="<?php echo base_url() ?>templates/home/icons/black/icon-statistic.png" alt="icon-statistic" height="16"/> &nbsp;Thống kê
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dLabel<?php echo $item->not_id ?>" style="left: 0px; right:0px;">
                        <li>
                            <a>
							<span><img src="<?php echo base_url() ?>templates/home/icons/black/icon-view.png" alt="icon-view" height="16"/> &nbsp;Số lượt xem tin</span> 
                            <span class="pull-right"><?php echo $item->not_view; ?></span>
							</a>
                        </li>
                        <li>
                            <a href="/content/danh-sach-chon/<?php echo $item->not_id . '/' . RemoveSign($item->not_title) ?>">
                                <img src="<?php echo base_url() ?>templates/home/icons/black/icon-filter.png" alt="icon-filter" height="16"> &nbsp;Số lượt chọn tin 
                                <span class="pull-right" ><?php echo $item->chontin ?></span>
                            </a>
                        </li>
                    </ul> 
		<?php elseif($this->uri->segment(2) == 'category'): ?>
                    &nbsp;
                <?php else : ?>		    
                    <a href="<?php echo getAliasDomain() . 'tintuc/category/' . $item->not_pro_cat_id . '/' . RemoveSign($item->cat_name) . '/' ?>">
			<img src="<?php echo base_url() ?>templates/home/icons/black/icon-newspaper.png" alt="icon-newspaper" height="16"> &nbsp;Liên quan
		    </a>		
                <?php endif; ?>
            </div>
        </div>
    </div>        
</div>
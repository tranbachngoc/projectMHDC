<?php $this->load->view('flatform/common/header_news');?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-2 col-md-3 col-sm-4 hidden-xs"> 
                <?php $this->load->view('flatform/common/menu'); ?>
            </div>
            
            <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12">            
                <div class="newfeeds">
    		<div class="article">
    		    <div class="detail-top">
			    <?php
			    if ($item->not_image != "") {
				$item_image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/thumbnail_2_' . $item->not_image;
			    } else {
				$item_image = base_url() . 'media/images/no_photo_icon.png';
			    }
			    ?>                        
    			<div style="background: #eee url('<?php echo $item_image; ?>') center bottom / 100% auto">
				<?php if (count($listProducts) > 2) { ?>										
				    <div id="wowslider-container<?php echo $item->not_id ?>" class="wowslider-container">
					<div class="ws_images">
					    <ul>
						<?php foreach ($listProducts as $key => $value) { ?>
	    					<li><img src="<?php echo $value->image ?>" alt="img1" title="img1" id="wows<?php echo $key ?>"/></li>    
						<?php } ?>
					    </ul>
					</div>                        
					<?php if ($item->not_music != '') { ?>									
	    				<audio preload="none" id="audio<?php echo $item->not_id ?>" src="<?php echo '/media/musics/' . $item->not_music; ?>"></audio>
					<?php } ?>
				    </div>										
				    <script>
					jQuery("#wowslider-container<?php echo $item->not_id ?>").wowSlider({effect: "<?php echo $item->not_effect ?>", prev: "", next: "", duration: 20 * 100, delay: 20 * 100, width: 600, height: 338, autoPlay: true, autoPlayVideo: true, playPause: true, stopOnHover: false, loop: false, bullets: 1, caption: false, captionEffect: "fade", controls: true, controlsThumb: false, responsive: 2, fullScreen: false, gestures: 2, onBeforeStep: 0, images: 0});
				    </script>    
				<?php } else { ?>
				    <div class="fix16by9"><div class="c"><img src="<?php echo $item_image; ?>"/></div></div>
				<?php } ?>
    			</div>

    			<div class="detail-logo text-center">                                         
    			    <div class="shop-logo">                                                      
				    <?php
				    $filelogo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $item->sho_dir_logo . '/' . $item->sho_logo;
				    if ($item->sho_logo != '') {
					$sho_logo = $filelogo;
				    } else {
					$sho_logo = base_url() . 'images/no-logo.png';
				    }
				    ?>
    				<a href="<?php echo $linktoshop ?>"
    				   style="display: block; background: #fff url('<?php echo $sho_logo; ?>') no-repeat center / cover">
    				</a>                          
    			    </div>
    			</div>
    			<div class="detail-title text-center text-uppercase">    
    			    <strong><?php echo $item->sho_name; ?></strong>
    			</div>
    		    </div>

		   
    		    <div class="boxwhite">   
    			<div class="rowtop">
    			    <div class="dropdown">
    				<span>
    				    <a href="#" class="pull-right" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    					<img src="/templates/home/icons/black/icon-more.png" alt="more">
    				    </a>                                        
					<?php if ($this->session->userdata('sessionUser') == $item->sho_user) : ?>
					    <ul class="dropdown-menu" aria-labelledby="dLabel" style="left: -15px; right:-15px;">
						<!--li>
						    <a href="javascript:void(0)"><img src="/templates/home/icons/black/icon-bullhorn.png" alt="Quảng cáo"> &nbsp; Quảng cáo</a>
						</li-->
						<li>
						    <a href="javascript:void(0)" onclick="ghimtin(<?php echo $item->not_id ?>)"><img src="/templates/home/icons/black/icon-tack.png" alt="Ghim tin lên đầu trang"> &nbsp; Ghim tin lên đầu trang</a>
						</li>
						<!--li>
						    <a href="javascript:void(0)" onclick="antinnay(<?php echo $item->not_id ?>)"><img src="/templates/home/icons/black/icon-hidden.png" alt="Ẩn tin"> &nbsp; Ẩn tin này</a>
						</li-->
						<li>
						    <a href="<?php echo $mainURL ?>account/news/edit/<?php echo $item->not_id ?>"><img src="/templates/home/icons/black/icon-edit.png" alt="Sửa tin"> &nbsp; Chỉnh sửa tin</a>
						</li>

						<!--li>
						    <a href="javascript:void(0)" onclick="xoatinnay(<?php echo $item->not_id ?>)"><img src="/templates/home/icons/black/icon-remove.png" alt="Xóa tin"> &nbsp; Xóa tin </a>
						</li-->
					    </ul>
					<?php else : ?>
					    <ul class="dropdown-menu" aria-labelledby="dLabel" style="left: -15px; right:-15px;">
						<li>
						    <a href="/shop">
							<img src="/templates/home/icons/black/icon-store.png" alt=""> &nbsp;
							Đến gian hàng
						    </a>          
						</li>
						<li>
						    <a href="tel:<?php echo $siteGlobal->sho_mobile ?>"><img src="/templates/home/icons/black/icon-call.png" alt="Gọi ngay"> &nbsp; Gọi ngay</a>
						</li>

						<?php
						if ($siteGlobal->sho_facebook) {
						    $face = explode("//www.facebook.com/", $siteGlobal->sho_facebook);
						    $facebook_id = str_replace('profile.php?id=', '', $face[1]);
						    ?>
	    					<li class="">
	    					    <a target="_blank" href="//www.messenger.com/t/<?php echo $facebook_id ?>"><img src="/templates/home/icons/black/icon-comment.png" alt=""> &nbsp; Gửi tin nhắn</a>
	    					</li>
						<?php } else { ?>
	    					<li class="">
	    					    <a target="_blank" href="sms:<?php echo $siteGlobal->sho_mobile ?>"><img src="/templates/home/icons/black/icon-comment.png" alt=""> &nbsp; Gửi tin nhắn</a>
	    					</li>
						<?php } ?>
					    </ul>
					<?php endif; ?>
    				</span>    
    				<span class="small"> 
				    <img src="http://ketnoidoanhnghiep.azibai.xxx/templates/home/icons/black/icon-history.png" alt="" height="12" /> <?php echo date('d/m/Y', $item->not_begindate); ?> &nbsp;
				    <?php if ($this->session->userdata('sessionUser') == $item->sho_user) { ?>
                                    <a href="#" id="dLabel2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="<?php echo base_url() ?>templates/home/icons/black/icon-permission-<?php echo $item->not_permission ?>.png" 
                                             alt="<?php echo $item->not_permission_name ?>" height="12"
                                             data-toggle="tooltip" data-placement="top" title="<?php echo $item->not_permission_name ?>"
                                        />
                                    </a>                                    
                                    <ul class="permission dropdown-menu" aria-labelledby="dLabel2" style="left: 0px; right:0px;">
                                        <?php  foreach ($permission as $key => $value) { ?>
                                        <li class="<?php echo $item->not_permission == $value->id ? 'current' : '' ?>">
                                            <a href="javascript:void(0)" onclick="setpermission(<?php echo $item->not_id . ',' . ($key+1) ?>)">
                                                <img src="<?php echo base_url() ?>templates/home/icons/black/icon-permission-<?php echo $key+1 ?>.png" alt="<?php echo $value->name ?>"height="16"/> &nbsp;<?php echo $value->name ?></a>
                                        </li>
                                        <?php } ?>
                                    </ul>                                    
                                    <?php } else { ?>
                                        <img src="<?php echo base_url() ?>templates/home/icons/black/icon-permission-<?php echo $item->not_permission ?>.png" 
                                             alt="<?php echo $item->not_permission_name ?>" height="12"
                                             data-toggle="tooltip" data-placement="top" title="<?php echo $item->not_permission_name ?>"
                                        />
                                    <?php } ?>
    				</span>
    			    </div>
    			</div>

    			<div class="rowmid">								
    			    <div class="r-title">
    				<h1>
					<?php echo $item->not_title ?>
    				</h1>
    			    </div>
    			    <div class="r-text">                                    
				    <?php
				    $s = preg_replace('/(?<!href="|">)(?<!src=\")((http|ftp)+(s)?:\/\/[^<>\s]+)/is', '<a class="text-primary" href="\\1" target="_blank">\\1</a>', $item->not_detail);
				    echo $s = '<p>' . str_replace("\n", "</p><p>", $s) . '</p>';
				    ?>                                
    			    </div>
    			</div>
    		    </div>

			<?php if ($item->not_video_url) { ?>                
			    <div class="embed-responsive embed-responsive-16by9" style="margin-bottom: 20px;">
				<iframe class="embed-responsive-item" src="//www.youtube.com/embed/<?php echo $item->not_video_url; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
			    </div>
			<?php } ?>

    		    <div id="img_post_gallery">                        
			    <?php
			    if ($listProducts) {
				foreach ($listProducts as $key => $value) {
				    /*print_r($value);*/
				    /**
				     *   Create link buynow, if AZIBAI ==> azibai home
				     *   else here are shop ==> shop product
				     * */
				    if ($value->product) {
					if ($value->product->domain) {
					    $link = $protocal . $value->product->domain;
					} else {
					    $link = $protocal . $value->product->sho_link . '.' . domain_site;
					}
					$linkshare = $link . '/shop/product/detail/' . $value->product->pro_id . '/' . RemoveSign($value->product->pro_name);
				    } else {
					$linkshare = $ogurl;
				    }
				    $fileimg = $value->image;
				    ?>
	    			<div class="img_post">
	    			    <a class="item key_<?php echo $key ?>" href="<?php echo $fileimg ?>" data-sub-html=".caption<?php echo $key ?>">
	    				<img width="100%" src="<?php echo $fileimg ?>" />
	    			    </a>

					<?php if ($value->caption) { ?>
					    <div class="imgcaption">
						<a href="<?php echo $linkshare; ?>" target="_blank" class="text-uppercase">
						    <strong><?php echo $value->product->domain ? $value->product->domain : $value->product->sho_link . '.' . domain_site; ?></strong>
						</a>
						<div><?php echo nl2br($value->caption); ?></div>
					    </div>
					<?php } ?>

	    			    <div class="caption caption<?php echo $key ?> small">
	    				<ul class="menu-justified dropdown">

	    				    <!--<li class="">     
	    					<a href="javascript:void(0)" onclick="buyNowQty(<?php echo $value->pro_id ?>);">
	    					    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-cart.png" alt="cart" height="20"/><br>Mua ngay
	    					</a> 
	    					<input type="hidden" name="product_showcart" id="product_showcart" value="<?php echo $product->pro_id; ?>"/>
	    					<input type="hidden" name="af_id" value="<?php echo $_REQUEST['af_id']; ?>"/>
	    					<input type="hidden" name="qty_min" value="<?php echo $pty_min; ?>"/>
	    					<input type="hidden" name="qty_max" value="<?php echo $product->pro_instock; ?>"/>
	    					<input type="hidden" name="dp_id" id="dp_id" value="<?php echo $product->id; ?>">
	    				    </li>-->

						<?php if ($value->product) { ?>
						    <li class="">     
							<a href="<?php echo $linkshare; ?>" target="_blank">
							    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-view.png" alt="cart" height="16"/><br>Chi tiết
							</a>  
						    </li>
						<?php } ?>

						<?php if ($this->session->userdata('sessionUser') == $item->sho_user && $value->product != '') : ?>
						    <li class="">
							<a href="<?php echo $mainURL . 'account/product/edit/' . $value->product->pro_id; ?>" target="_blank">
							    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-edit.png" alt="update" height="16"/><br>Chỉnh sửa
							</a>                                                
						    </li>
						<?php endif; ?>


	    				    <li class="">
	    					<a href="<?php echo $linkshare ?>" class="dropdown-toggle"  data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
	    					    <img src="<?php echo base_url() ?>templates/home/icons/black/share-outline.png" alt="" height="16"><br>Chia sẻ
	    					</a>
	    					<ul class="dropdown-menu"  style="left: 0px; right:0px;">
	    					    <li>
	    						<div class="social-share">
	    						    <a href="javascript:void(0)" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $linkshare ?>&amp;app_id=<?php echo app_id ?>', 'facebook-share-dialog', 'width=800, height=450');
	    								   return false;">
	    							<img src="<?php echo base_url() ?>templates/home/icons/icon-facebook.png" alt="">
	    						    </a>
	    						    <a href="javascript:void(0)" onclick="window.open('https://twitter.com/share?text=<?php echo $value->pro_name ?>&amp;url=<?php echo $linkshare ?>', 'twitter-share-dialog', 'width=800,height=450');
	    								       return false;">
	    							<img src="<?php echo base_url() ?>templates/home/icons/icon-twitter.png" alt="">
	    						    </a>
	    						    <a href="javascript:void(0)" onclick="window.open('https://plus.google.com/share?url=<?php echo $linkshare ?>', 'google-share-dialog', 'width=800, height=450');
	    								       return false;">
	    							<img src="<?php echo base_url() ?>templates/home/icons/icon-google-plus.png" alt="">
	    						    </a>                                                            
	    						    <a style="margin-right:15px;" class="pull-right" target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to=&su=<?php echo $value->product->pro_name ?>&body=<?php echo $linkshare ?>&ui=2&tf=1" >
	    							<img src="<?php echo base_url() ?>templates/home/icons/black/icon-email.png" alt="">
	    						    </a>
	    						</div>
	    					    </li>
	    					    <li>
	    						<a href="javascript:void(0)" onclick="copylink('<?php echo $linkshare ?>');">
	    						    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-coppy.png" alt="" height="16"> &nbsp;Sao chép liên kết
	    						</a>
	    					    </li>
	    					</ul>
	    				    </li>


						<?php if ($this->session->userdata('sessionUser') == $item->sho_user) : ?>			
						    <li class=""> 
							<a href="<?php echo $mainURL ?>account/news/edit/<?php echo $item->not_id ?>" target="_blank">
							    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-edit.png" alt="Sửa tin" height="16"><br>Sửa tin
							</a>
						    </li>
						<?php else : ?>
						    <?php if ($value->detail): ?>
		    				    <li class="">
		    					<a href="<?php echo $value->detail ?>" target="_blank">
		    					    <img src="<?php echo base_url() ?>templates/home/icons/black/icon-coupon.png" alt="detail" height="16"><br>Xem thêm
		    					</a>
		    				    </li>
						    <?php endif; ?>	
						<?php endif; ?>
	    				</ul>
	    				<script>
	    				    $('.lg-sub-html ul').removeClass('dropdown').addClass('dropup');
	    				</script>

	    			    </div> 

	    			</div>
				    <?php
				}
			    }
			    ?>
    		    </div>     

    		    <p class="text-right text-muted small"><?php echo $countcomments ?> bình luận &nbsp; <?php echo $item->chontin ?> lượt chọn tin</p>


    		    <div id="cm" class="rowcomment">                        
    			<ul class="menu-justified dropdown" role="tablist" style="background: #f7f8f9;">

    			    <li role="presentation">
    				<a class="" role="button" data-toggle="collapse" href="#comments" aria-expanded="true" aria-controls="collapseExample">
    				    <img src="/templates/home/icons/black/icon-comment.png" alt="" height="20">&nbsp;Bình luận
    				</a>
    			    </li>
    			    <li role="presentation">
    				<a href="#sharepage" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
    				    <img src="/templates/home/icons/black/share-outline.png" alt="" height="20">&nbsp;Chia sẻ
    				</a>

				<?php $linkchiase = $linktoshop . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title); ?>

    				<ul class="dropdown-menu" style="left: 0px; right:0px;">                                    
    				    <li>
    					<div class="social-share">													
    					    <a onclick="
    						    window.open(
    							    'https://www.facebook.com/sharer/sharer.php?u=<?php echo $linkchiase ?>&amp;app_id=<?php echo app_id ?>',
    							    'facebook-share-dialog',
    							    'width=600,height=450');
    						    return false;">
    						<img src="/templates/home/icons/icon-facebook.png" alt="">
    					    </a>
    					    <a onclick="
    						    window.open(
    							    'https://twitter.com/share?text=<?php echo $item_title ?>&amp;url=<?php echo $linkchiase ?>',
    							    'twitter-share-dialog',
    							    'width=600,height=450');
    						    return false;">
    						<img src="/templates/home/icons/icon-twitter.png" alt="">
    					    </a>
    					    <a onclick="
    						    window.open(
    							    'https://plus.google.com/share?url=<?php echo $linkchiase ?>',
    							    'google-share-dialog',
    							    'width=600,height=450');
    						    return false;">
    						<img src="/templates/home/icons/icon-google-plus.png" alt="">
    					    </a>
    					    <a style="margin-right:15px;" class="pull-right" target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to=&su=<?php echo $item_title ?>&body=<?php echo $item_desc . ' - ' . $linkchiase ?>&ui=2&tf=1" >
    						<img src="/templates/home/icons/black/icon-email.png" alt="">
    					    </a>						
    					</div> 
    				    </li>

					<?php if ($item->ConditionsSelectNews == 1) { ?>
					    <?php if ($item->dachon == 0) { ?>
	    				    <li class="chontin">
	    					<a  href="javascript:void(0)"  onclick="chontin(<?php echo $item->not_id ?>);"><img src="/templates/home/icons/black/icon-no-check.png" alt=""> &nbsp;Chọn tin</a>
	    				    </li>
					    <?php } else { ?>
	    				    <li class="bochontin">
	    					<a  href="javascript:void(0)"  onclick="bochontin(<?php echo $item->not_id ?>);"><img src="/templates/home/icons/black/icon-check.png" alt=""> &nbsp; Bỏ chọn tin</a>
	    				    </li>
					    <?php } ?>
					<?php } ?> 
    				    <li>
    					<a href="javascript:void(0)" onclick="copylink('<?php echo $linkchiase; ?>')"><img src="/templates/home/icons/black/icon-coppy.png" alt=""> &nbsp;Sao chép liên kết</a>
    				    </li>                    
    				</ul>
    			    </li>
    			</ul>
    		    </div>
		    
    		    <div class="collapse in" id="comments" aria-expanded="true">	
    			<div id="cmt-container">
    			    <div style="padding:15px 0px">
				    <?php if (count($comments) > 0) { ?>
					<?php if (!empty($comments)): ?>
					    <?php
					    foreach ($comments as $comment): $avatar = base_url() . 'templates/home/images/noavatar.jpg';
						if ($comment['noc_avatar']) {
						    $avatar = DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $comment['noc_avatar'];
						}
						?>
						<div class="cmt-cnt">
						    <img src="<?php echo $avatar; ?>" />
						    <div class="thecom">
							<h5>
							    <?php echo $comment['noc_name']; ?>
							</h5>
							<span data-utime="1371248446" class="com-dt">
							    <?php
							    $dat_cmt = strtotime($comment['noc_date']);
							    echo $dat_cmt = date('d/m/Y', $dat_cmt);
							    ?>
							</span> 
							<p><?php echo $comment['noc_comment']; ?></p>

							<?php if ($this->session->userdata('sessionUser')) : ?>
		    					<div style="margin-left: 45px;"> 
		    					    <a class="" role="button" data-toggle="collapse" href="#comment<?php echo $comment['noc_id'] ?>" aria-expanded="false" aria-controls="collapseExample">
		    						<em>Trả lời</em>
		    						<span class="caret"></span>
		    					    </a>
		    					    <div class="collapse" id="comment<?php echo $comment['noc_id'] ?>">
		    						<form id="commentForm<?php echo $comment['noc_id'] ?>"  class="form-horizontal" method="post" name="frmReply">
		    						    <div class="pull-right">
		    							<input class="btn btn-primary" type="submit" value="Gửi" name="submit_reply"/>
		    						    </div>                                            
		    						    <div style="margin-right:55px;">
		    							<textarea maxlength="500" class="form-control" id="noc_comment" name="noc_comment" placeholder="Nhập nội dung bình luận"></textarea>
		    						    </div>
		    						    <input type="hidden" value="<?php echo $this->session->userdata('sessionUser') ?>" name="noc_user" />
		    						    <input type="hidden" value="<?php echo $item->not_id; ?>" name="noc_content" />
		    						    <input type="hidden" value="<?php echo $comment['noc_id']; ?>" name="noc_reply" />
		    						</form>
		    					    </div>
		    					</div>
		    					<script>
		    					    jQuery(function ($) {
		    						$("#commentForm<?php echo $comment['noc_id'] ?>").validate({
		    						    rules: {noc_comment: "required"},
		    						    messages: {noc_comment: "Vui lòng nhập nội dung bình luận."},
		    						    submitHandler: function (form) {
		    							jQuery.ajax({
		    							    type: "POST",
		    							    url: "/news/comment",
		    							    data: jQuery(form).find(':input').serialize(),
		    							    dataType: "json",
		    							    success: function (data) {
		    								location.reload();
		    							    }
		    							})
		    						    }
		    						});
		    					    });
		    					</script>
							<?php endif; ?>                                                            
						    </div>
						</div>
						<?php
						foreach ($comment['replycomment'] as $key => $value) :
						    $avatar = base_url() . 'templates/home/images/noavatar.jpg';
						    if ($value['noc_avatar']) {
							$avatar = DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $value['noc_avatar'];
						    }
						    ?>
		    				<div class="cmt-cnt" style="margin-left: 45px;">
		    				    <img src="<?php echo $avatar; ?>" />
		    				    <div class="thecom">
		    					<h5>
								<?php echo $value['noc_name']; ?>
		    					</h5>
		    					<span data-utime="1371248446" class="com-dt">
								<?php
								$dat_cmt = strtotime($value['noc_date']);
								echo $dat_cmt = date('d/m/Y', $dat_cmt);
								?>
		    					</span>                                                            
		    					<p>
								<?php echo $value['noc_comment']; ?>
		    					</p>
		    				    </div>
		    				</div>
						<?php endforeach; ?>                                      

					    <?php endforeach; ?>
					<?php endif; ?>
					<?php echo $pager; ?>
				    <?php } else { ?> 
					<?php
				    }//endif     
				    ?>
				    <?php if ($this->session->userdata('sessionUser')) { ?>
					<form id="commentForm1" class="form-horizontal" method="post" name="frmReply">
					    <div class="pull-right">
						<input class="btn btn-primary" type="submit" value="Gửi" name="submit_reply"/>
					    </div>                                            
					    <div style="margin-right:55px;">
						<textarea maxlength="500" class="form-control" id="noc_comment" name="noc_comment" placeholder="Nhập nội dung bình luận"></textarea>
					    </div>
					    <input type="hidden" value="<?php echo $this->session->userdata('sessionUser') ?>" name="noc_user" />
					    <input type="hidden" value="<?php echo $item->not_id; ?>" name="noc_content" />
					    <input type="hidden" value="0" name="noc_reply" />                                        
					</form>
				    <?php } else { ?> 
					
					    <div class="alert alert-info" role="alert">
						Bạn chưa đăng nhập. Vui lòng đăng nhập để viết bình luận!
					    </div>
					
				    <?php } ?>
    			    </div>
				<?php if ((int) $this->session->userdata('sessionUser') > 0) { ?>
				    <script type="text/javascript">
					jQuery(function ($) {
					    $("#commentForm1").validate({
						rules: {noc_comment: "required"},
						messages: {noc_comment: "Vui lòng nhập nội dung bình luận."},
						submitHandler: function (form) {
						    jQuery.ajax({
							type: "POST",
							url: "/news/comment",
							data: jQuery(form).find(':input').serialize(),
							dataType: "json",
							success: function (data) {
							    location.reload();
							}
						    })
						}
					    });
					});
				    </script>
				<?php } ?>
    			    <div class="clearfix"></div>
    			</div>       
    		    </div>
		    
		    <?php $ad = json_decode($item->not_ad);
		    if ($ad->ad_image != "") { ?>
    		    <strong>Quảng cáo:</strong>
    		    <div id="postad">
    			<a href="<?php echo $ad->ad_link ?>" target="_blank">
    			    <img style="" class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $ad->ad_image; ?>" alt="" />
    			</a>
    			<strong class="qc">QC</strong>
    		    </div>					
		    <?php } ?>

		    <?php if (count($listProducts2) > 0) { ?>
			    <strong>Sản phẩm:</strong>		
			    <div id="listProducts" class="owl-carousel text-center">
				<?php foreach ($listProducts2 as $k => $value) {
				    $linktoproduct = $linkshop . '/flatform/product/' . $value->pro_id . '/' . RemoveSign($value->pro_name);
				    ?>
	    			<div class="itempro"> 
	    			    <div class="fix1by1">
	    				<a class="c" href="<?php echo $linktoproduct ?>">
	    				    <img class="pro_image img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $value->pro_dir . '/' . show_image($value->pro_image); ?>"/>
	    				</a>
	    			    </div>
	    			    <div class="proname" style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
	    				<strong><a href="<?php echo $linktoproduct ?>"><?php echo $value->pro_name ?></a></strong>
	    			    </div>
	    			    <p class="pro_cost"><?php echo $value->pro_cost . ' ' . $value->pro_currency ?></p>
	    			    <div class="pro_buy"><a href="<?php echo $linktoproduct ?>" class="btn btn-default btn-sm"><i class="fa fa-shopping-cart fa-fw"></i> Mua ngay</a></div>
	    			</div>
			    <?php } ?>
			    </div>
		    <?php } ?>
		    <?php if (count($list_related) > 0) { ?>    
		    <strong>Bài liên quan:</strong>
    		    <div class="mod-items">    			
			    <?php foreach ($list_related as $key => $value) { ?>
				<?php
				$itemlink = site_url('news/detail/' . $value->not_id . '/' . RemoveSign($value->not_title));
				$item_image = site_url('media/images/noimage.png');
				if ($value->not_image != ''):
				    $item_image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/thumbnail_1_' . $value->not_image;
				endif;
				?>
				<div class="mod-item">
				    <div class="pull-left">
					<a href="<?php echo $itemlink ?>" title="<?php echo $value->not_title ?>">
					    <img src="<?php echo $item_image ?>" style="width:120px; height:120px;" alt="<?php echo $value->not_title ?>"/>
					</a>
				    </div>
				    <div style="margin-left: 120px; padding: 0 10px;">
					<h4 class="item-title"><a title="<?php echo $value->not_title ?>" href="<?php echo $itemlink ?>" ><?php echo $value->not_title ?></a></h4> 
					<div class="small">
					    <i class="fa fa-calendar fa-fw"></i> <?php echo date('d/m/Y', $value->not_begindate); ?>
					    &nbsp;
					    <i class="fa fa-eye fa-fw"></i> <?php echo $value->not_view; ?>
					</div>
				    </div>
				    <div class="clearfix"></div>
				</div>
    <?php } ?>				
    		    </div>
		    <?php } ?>
		    <?php if (count($list_views) > 0) { ?> 
		    <strong>Bài xem nhiều:</strong>
    		    <div class="mod-items">			
			    <?php foreach ($list_views as $key => $value) { ?>
				<?php
				$itemlink = site_url('news/detail/' . $value->not_id . '/' . RemoveSign($value->not_title));
				$item_image = site_url('media/images/noimage.png');
				if ($value->not_image != ''):
				    $item_image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/thumbnail_1_' . $value->not_image;
				endif;
				?>
				<div class="mod-item">
				    <div class="pull-left">
					<a href="<?php echo $itemlink ?>" title="<?php echo $value->not_title ?>">
					    <img src="<?php echo $item_image ?>" style="width:120px; height:120px;" alt="<?php echo $value->not_title ?>"/>
					</a>
				    </div>
				    <div style="margin-left: 120px; padding: 0 10px;">
					<h4 class="item-title"><a title="<?php echo $value->not_title ?>" href="<?php echo $itemlink ?>" ><?php echo $value->not_title ?></a></h4> 
					<div class="small">
					    <i class="fa fa-calendar fa-fw"></i> <?php echo date('d/m/Y', $value->not_begindate); ?>
					    &nbsp;
					    <i class="fa fa-eye fa-fw"></i> <?php echo $value->not_view; ?>
					</div>
				    </div>
				    <div class="clearfix"></div>
				</div>
    <?php } ?>
    		    </div>
    		    <?php } ?>
		    <br>
    		</div>
    	    </div>
                
            </div>
            
            <div class="col-lg-3 col-md-3 " style="position:static">  
               <div class="panel panel-default panel-scrollfix">
                        <div class="panel-heading">      
                            <div class="input-group">
                                <input id="keySearch" type="text" class="form-control" placeholder="Tìm gian hàng" aria-describedby="basic-addon1" onkeyup="myFunction();">
                                <span class="input-group-addon" id="basic-addon1"><i class="fa fa-search"></i></span>
                            </div>
                        </div>    
                        <div class="panel-body" style="height:calc(100vh - 158px); overflow: auto;">        
                            <ul id="listSearch" class="listshop list-unstyled">
                                <?php
                                foreach ($listShop as $value) {
                                    if ($value->domain != '') {
                                        $linktoshop = 'http://' . $value->domain;
                                    } else {
                                        $linktoshop = 'https://' . $value->sho_link . '.' . domain_site;
                                    }
                                    ?>
                                    <li>
                                        <a href="<?php echo $linktoshop ?>/shop">
                                            <span>
                                                <span>
                                                    <img src="<?php echo DOMAIN_CLOUDSERVER . '/media/shop/logos/' . $value->sho_dir_logo . '/' . $value->sho_logo ?>" alt="logo"/> 
                                                </span> 
                                            </span>                                  
                                            <?php echo $value->sho_name ?>
                                        </a>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <script>
                        function myFunction() {
                            var input, filter, ul, li, a, i;
                            input = document.getElementById("keySearch");
                            filter = input.value.toUpperCase();
                            ul = document.getElementById("listSearch");
                            li = ul.getElementsByTagName("li");
                            for (i = 0; i < li.length; i++) {
                                a = li[i].getElementsByTagName("a")[0];
                                if (a.innerHTML.toUpperCase().indexOf(filter) > -1) {
                                    li[i].style.display = "";
                                } else {
                                    li[i].style.display = "none";
                                }
                            }
                        }
                    </script>
            </div> 
            
            <div class="col-lg-2 hidden-md hidden-sm hidden-xs" style="position:static">  
                <?php $this->load->view('flatform/common/ads');?>
            </div>
        </div>
    </div>

<?php if($this->session->userdata('sessionGroup') == AffiliateUser ) { ?>
    <!--Display call-->
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
                    <img data-toggle="modal" data-target=".bs-example-modal-md" src="//i.imgur.com/v8TniL3.png" alt="Liên hệ" width="50" onmouseover="this.src = '//i.imgur.com/v8TniL3.png';" onmouseout="this.src = '//i.imgur.com/v8TniL3.png';">
                </a>
            </div>
        </div>
    <?php } ?>
<?php } else { ?>    
    <?php if($packId1 == true || $packId2 == true ) { ?>
        <?php if($packId1 == true){ //is Branch ?>
            <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
                <div class="phonering-alo-ph-circle"></div>
                <div class="phonering-alo-ph-circle-fill"></div>            
                <div class="phonering-alo-ph-img-circle for-affiliate">
                    <a href="<?php echo $mainURL .'register/affiliate/pid/'.$this->session->userdata('sessionUser'); ?>">
                        <img data-toggle="modal" data-target=".bs-example-modal-md" src="//i.imgur.com/v8TniL3.png" alt="Liên hệ" width="50" onmouseover="this.src = '//i.imgur.com/v8TniL3.png';" onmouseout="this.src = '//i.imgur.com/v8TniL3.png';">
                    </a>
                </div>
            </div>    
        <?php } else { ?> 
            <?php if($packId2 == true) { ?>
            <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
                <div class="phonering-alo-ph-circle"></div>
                <div class="phonering-alo-ph-circle-fill"></div>            
                <div class="phonering-alo-ph-img-circle for-affiliate">
                    <a href="<?php echo $mainURL .'register/affiliate/pid/'.$siteGlobal->sho_user; ?>">
                        <img data-toggle="modal" data-target=".bs-example-modal-md" src="//i.imgur.com/v8TniL3.png" alt="Liên hệ" width="50" onmouseover="this.src = '//i.imgur.com/v8TniL3.png';" onmouseout="this.src = '//i.imgur.com/v8TniL3.png';">
                    </a>
                </div>
            </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>
    
<?php } ?>

<script>
    function copylink(link) {
	clipboard.copy(link);
    }
    jQuery(function ($) {
	$('#listProducts').owlCarousel({items: 3, margin: 20, nav: true, dots: false})

	$('#img_post_gallery').lightGallery({selector: '.item', download: false});
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
	var itempost = $('.wowslider-container');
	var tolerancePixel = 300;
	function checkMedia() {
	    var scrollTop = $(window).scrollTop() + tolerancePixel;
	    var scrollBottom = $(window).scrollTop() + $(window).height() - tolerancePixel;
	    itempost.each(function (index, el) {
		var yTopMedia = $(this).offset().top;
		var yBottomMedia = $(this).height() + yTopMedia;
		if (scrollTop < yBottomMedia && scrollBottom > yTopMedia) {
		    itempost.swipe({
			swipeLeft: function (event, direction, distance, duration, fingerCount) {
			    $(this).find(".ws_play").click();
			},
			swipeRight: function (event, direction, distance, duration, fingerCount) {
			    $(this).find(".ws_play").click();
			},
			threshold: 100
		    });
		} else {
		    $(this).find(".ws_pause").click();
		}
	    });
	}
	$(window).on('scroll', checkMedia);
    });
</script>

<?php $this->load->view('flatform/common/footer');?>






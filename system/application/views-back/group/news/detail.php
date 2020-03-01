<?php $this->load->view('group/news/common/header');?>
<link href="https://fonts.googleapis.com/css?family=Anton|Arsenal|Exo|Francois+One|Muli|Nunito+Sans|Open+Sans+Condensed:300|Oswald|Pattaya|Roboto+Condensed|Saira+Condensed|Saira+Extra+Condensedsubset=latin-ext,vietnamese" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="/templates/home/lightgallery/dist/css/lightgallery.css" />

<div id="main" class="container-fluid">
    <div class="row rowmain">          
        <div class="col-xs-12 col-sm-2">
            <?php $this->load->view('group/news/common/menu-left'); ?>            
        </div>   
        <div class="col-xs-12 col-sm-5">
            <?php if( $item->not_image != '' ) {
		$item_image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $item->not_image;			    
	    } else {
		$item_image = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $item->sho_dir_banner . '/' . $item->sho_banner;		
	    } 
            if($item->not_display == 1) {
                $classicon = 'white'; ?>
                <style>
                    .detail-content { background: url('<?php echo $item_image ?>') no-repeat scroll center/cover; position: relative; padding: 25px 20px 20px; color: #fff;  margin-bottom: 20px; }
                    .detail-content::before { content:''; position: absolute; top:0; right:0; bottom:0; left:0; background:rgba(0,0,0,.75); }  
		</style>
            <?php } else { 
                $classicon = 'black';
            } ?>
	    <div class="newfeeds">
		<div class="article">		    
		    <div class="detail-top" style="position: relative">			  
                        <?php if ($item->not_slideshow == 1) { ?>                            
                                <div class="detail-banner">                            
                                    <div id="wowslider-container<?php echo $item->not_id ?>" class="wowslider-container">
                                        <div class="ws_images">
                                            <ul>
                                                <?php
                                                foreach ($item->listImg as $key => $value) { ?>
                                                <li>
                                                    <img src="<?php echo DOMAIN_CLOUDSERVER .'media/images/content/' . $item->not_dir_image . '/1x1_' .  $value->image ?>" 
                                                     alt="<?php echo ($value->title) ? $value->title : $item->not_title ?>" 
                                                     title="<?php echo ($value->title) ? $value->title : $item->not_title ?>" 
                                                     id="wows1_<?php echo $key ?>" />                                               
                                                </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="ws_bullets">
                                            <div>
                                                <?php foreach ($item->listImg  as $key => $value) { ?>
                                                <a href="#" title="<?php echo $value->title ?>"><span><?php echo $key ?></span></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>		    
                                    
                                    <?php if ($item->not_music != '') { ?>									
                                        <audio preload="false" id="audio<?php echo $item->not_id ?>" src="<?php echo '/media/musics/' . $item->not_music; ?>"></audio>
                                        <img class="az-volume" src="/templates/home/icons/icon-volume-off.png" style="position: absolute;top: 10px;z-index: 9999;right: 10px;width: 40px;"/>
                                    <?php } ?> 
				    <script>
                                        jQuery("#wowslider-container<?php echo $item->not_id ?>").wowSlider({effect:"<?php echo explode("|", $item->not_effect)[0] ?>",prev:"",next:"",duration:20*100,delay:10*100,width:600,height:338,autoPlay:true,autoPlayVideo:false,playPause:true,stopOnHover:false,loop:false,bullets:1,caption:true,captionEffect:"move",controls:true,controlsThumb:false,responsive:1,fullScreen:false,gestures:2,onBeforeStep:0,images:0});
                                    </script>
                                </div>
                                <?php if($isMobile == 1){ ?>
                                    <div class="ngocheo" style=" background: url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $item->not_image; ?>) no-repeat center / cover; "> </div>
                                <?php } ?>
                        <?php } else { ?>
                            <?php if($isMobile == 1){ ?>
                                <div class="detail-banner"> 
                                    <div class="fix1by1">
                                        <div class="c" style="background:url(<?php echo $item_image ?>) no-repeat center center / cover"></div>
                                    </div>
                                </div>
                                <div class="ngocheo" style=" background: url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $item->not_image; ?>) no-repeat center / cover; ">
                                    <div class="not_title"><?php echo $item->not_title ?></div>
                                </div>
                            <?php } else { ?>
                                <div class="detail-banner"> 
                                    <div class="fix16by9">
                                        <div class="c" style="background:url(<?php echo $item_image ?>) no-repeat center center / cover"></div>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
			                        
			<div id="brand" class="detail-brand">
			    <div class="shologo">
                                <?php
                                    $item_logo = site_url('templates/home/images/no-logo.jpg');
                                    if ($item->sho_logo != "") {
                                        $item_logo = DOMAIN_CLOUDSERVER . 'media/shop/logos/' . $item->sho_dir_logo . '/' . $item->sho_logo;
                                    }
                                ?>	
                                <a href="<?php echo $linkshop ?>" 
                                   style="background: white url('<?php echo $item_logo; ?>') no-repeat center center / cover;"> 
                                </a>
			    </div>			
			    <div class="shoname">
                                <a href="<?php echo $linkshop ?>">
				    <strong><?php echo $item->sho_name; ?></strong>
                                </a>
                                
			    </div>
			    <div class="follow text-right">
				<a class="btn btn-default btn-sm disabled" href="#" data-toggle="tooltip" data-placement="top" title="Theo dõi">
				    <i class="azicon16 icon-forward-right"></i>				    
				 </a>
			    </div>
			</div>			   

		    </div>
                    
		    <div class="detail-content">						    
			<div class="dropdown">
				<div class="pull-right">
				    <a href="#" id="dLabel1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="azicon16 <?php echo $classicon ?> icon-more"></i>
				    </a>
				    <?php if ($this->session->userdata('sessionUser') == $item->sho_user) : ?> 
				    <ul class="dropdown-menu" aria-labelledby="dLabel1" style="left: 0px; right:0;">
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
							<i class="azicon icon-remove"></i> &nbsp; Xóa tin</a>
					</li>
				    </ul>
					<?php
				    else :
					?>
				    <ul class="dropdown-menu" aria-labelledby="dLabel1" style="left: 0px; right:0;">
					<li>
					    <a href="<?php echo $linkshop . '/shop'; ?>">
							<i class="azicon icon-store"></i>
						&nbsp; Đến gian hàng
					    </a>  
					</li>
					    <?php if ($item->sho_mobile) { ?>
						<li>
						    <a href="tel:<?php echo $item->sho_mobile ?>">
							<i class="azicon icon-call"></i>
							&nbsp; Gọi cho gian hàng</a>
						</li>
					    <?php } ?>

					    <?php
					    if ($item->sho_facebook) {
						$face = explode("//www.facebook.com/", $item->sho_facebook);
						$facebook_id = str_replace('profile.php?id=', '', $face[1]);
						$messages = 'https://www.messenger.com/t/' . $facebook_id;
						?>
						<li>
						    <a href="<?php echo $messages ?>">
							<i class="azicon icon-message"></i>
							&nbsp; Gửi tin nhắn</a>
						</li>
						<?php
					    } elseif ($item->sho_mobile) {
						$messages = 'sms:' . $item->sho_mobile;
						?>
						<li>
						    <a  href="<?php echo $messages ?>">
							<i class="azicon icon-message"></i>
							&nbsp; Gửi tin nhắn</a>
						</li>
					    <?php } ?> 
					<li>
					    <a href="#" class="report" data-id="<?php echo $item->not_id; ?>" data-link="<?php echo current_url(); ?>" data-toggle="modal" data-target="#reportModal">
						<i class="azicon icon-report"></i>
						&nbsp; Gửi báo cáo
					    </a>
					</li>	
				    </ul>
				    <?php endif; ?>  
				</div>
				<i class="azicon16 <?php echo $classicon ?> icon-clock"></i> 
				<span class=""><?php echo date('d/m/Y', $item->not_begindate); ?> </span>
				&nbsp;
				<?php if ($this->session->userdata('sessionUser') == $item->sho_user) { ?>
				<a href="#" id="dLabel2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    <i class="azicon16 <?php echo $classicon ?> icon-permission-<?php echo $item->not_permission ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $item->not_permission_name ?>"></i>
				</a>
				<ul class="permission dropdown-menu" aria-labelledby="dLabel2" style="left: 0px; right:0px;">
				    <?php foreach ($permission as $key => $value) { ?>
					<li class="<?php echo $item->not_permission == $value->id ? 'current' : '' ?>">
					    <a href="javascript:void(0)" onclick="setpermission(<?php echo $item->not_id . ',' . ($key + 1) ?>)">
						<i class="azicon icon-permission-<?php echo $key + 1 ?>"></i> &nbsp;<?php echo $value->name ?>
					    </a>
					</li>
				    <?php } ?>
				</ul>
				<?php } else { ?>
				<i class="azicon16 <?php echo $classicon ?> icon-permission-<?php echo $item->not_permission ?>" 
				   data-toggle="tooltip" data-placement="top" title="<?php echo $item->not_permission_name ?>">
				</i>
				<?php } ?>
			</div>
			
			<div class="rowmid">
			    <div class="r-title">
                                <h2><?php echo $item->not_title ?></h2>
			    </div>
			    <div class="r-text">                                
                                <?php                               
                                echo $s = preg_replace('/(?<!href="|">)(?<!data-original=\")(?<!src=\")((http|ftp)+(s)?:\/\/[^<>\s]+)/is', '<a class="text-primary" href="\\1" target="_blank">\\1</a>', $item->not_detail);
                                ?>
			    </div>
                            
				<?php 
				$adddd = json_decode($item->not_additional); 
				foreach ($adddd as $key => $value) { 
					if($value->posi == 'left') $imanation = 'fadeInRight';
					if($value->posi == 'center') $imanation = 'fadeInDown';
					if($value->posi == 'right') $imanation = 'fadeInLeft';
					?>                        
					<div class="wow <?php echo $imanation ?> boxicon text-<?php echo $value->posi ?>" style="margin: 60px 0;">
						<?php if($value->icon !=''){ ?>
							<img class="pull-<?php echo $value->posi .' '. $classicon?>" src="/images/icons/<?php echo $value->icon ?>" alt="icon"/>
							<div style="margin-<?php echo $value->posi ?>: 100px;">
                                                            <h3><?php echo $value->title ?></h3>
                                                            <p><?php echo nl2br($value->desc) ?></p>
							</div>					
						<?php } else { ?>
							<div>
                                                            <h3><?php echo $value->title ?></h3>
                                                            <p><?php echo nl2br($value->desc) ?></p>
							</div>
						<?php } ?>
					</div>			
				<?php } ?> 
                
			</div>
                       
		    </div>
                    
		    <?php if ($item->not_video_url) { ?>
    		    <div class="embed-responsive embed-responsive-16by9" style="margin-bottom: 20px;">
    			<iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $item->not_video_url; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
    		    </div>
		    <?php } ?>
			
		    <div class="text-right small" style="padding: 0px 15px;"><?php echo $countcomments ?> bình luận &nbsp; <?php echo $item->chontin ?> lượt chọn tin</div>

		    <div id="comments" class="rowcomment"  style="margin-bottom:20px">
				<div class="dropdown text-center" style="background: #ffffff; "> 
					<?php /*?>
					<span class="pull-left">
						<?php if($item->yeuthich == 1) { ?> 
						<a class="unfavorite_<?php echo $item->not_id ?>" href="javascript:void(0)" onclick="huythich(<?php echo $item->not_id ?>);">
							<span data-toggle="tooltip" data-placement="top" data-original-title="Hủy thích">
								<i class="azicon-green icon-favorite"></i> <span class="hidden-xs">Hủy thích</span>
							</span>
						</a>
						<?php } else { ?>
						<a class="favorite_<?php echo $item->not_id ?>" href="javascript:void(0)" onclick="yeuthich(<?php echo $item->not_id ?>);">
							<span data-toggle="tooltip" data-placement="top" data-original-title="Yêu thích">
								<i class="azicon icon-favorite"></i> <span class="hidden-xs">Yêu thích</span>
							</span>
						</a>
						<?php } ?>
					</span>
					<?php */?>
					<span class="pull-none" style="display: inline-block; padding: 10px 10px;">
						<a role="button" data-toggle="collapse" href="#viewcomments" aria-expanded="true" aria-controls="viewcomments">
							<span data-toggle="tooltip" data-placement="top" data-original-title="Bình luận">
								<i class="azicon icon-comment"></i> &nbsp;Bình luận
							</span>
						</a>
					</span>
					<span class="pull-none" style="display: inline-block; padding: 10px 10px;">
                                            &nbsp;
					</span>
                                        <?php if($item->not_permission == 1){ ?>
					<span class="pull-none" style="display: inline-block; padding: 10px 10px;">
						<a href="#sharepage"  class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                    <span data-toggle="tooltip" data-placement="top" data-original-title="Chia sẻ">
                                                        <i class="azicon icon-share"></i> &nbsp;Chia sẻ
                                                    </span>
						</a>				
						<ul class="dropdown-menu" style="left: 0px; right:0px;">
							<li>
                                                            <div class="social-share">
                                                                    <a class="" href="javascript:void(0)" onclick=" window.open( 'https://www.facebook.com/sharer/sharer.php?u=<?php echo current_url() . $afkey; ?>&amp;app_id=<?php echo app_id ?>', 'facebook-share-dialog', 'width=800,height=600'); return false;">
                                                                            <i class="azicon icon-facebook"></i>
                                                                    </a>
                                                                    <a class="" href="javascript:void(0)" onclick=" window.open( 'https://twitter.com/share?text=<?php echo $item->not_title ?>&amp;url=<?php echo current_url() . $afkey; ?>&amp;hashtags=azibai', 'twitter-share-dialog', 'width=800,height=600'); return false;">
                                                                            <i class="azicon icon-twitter"></i>
                                                                    </a>
                                                                    <a class="" href="javascript:void(0)" onclick=" window.open( 'https://plus.google.com/share?url=<?php echo current_url() . $afkey; ?>', 'google-share-dialog', 'width=800,height=600'); return false;">
                                                                            <i class="azicon icon-google"></i>
                                                                    </a>
                                                                    <a class="pull-right" style="margin-right:15px;" target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to&su=<?php echo $item->not_title ?>&body=<?php echo $item->not_description ?> -- Xem chi tiết: <?php echo current_url() ?>&ui=2&tf=1" >
                                                                            <i class="azicon icon-email"></i>
                                                                    </a> 
                                                            </div>
							</li>
							<?php if ($item->chochontin) { ?>
								<?php if ($item->dachon == 0) { ?>
								<li class="chontin chontin_<?php echo $item->not_id ?>">
									<a href="javascript:void(0)"  onclick="chontin(<?php echo $item->not_id ?>);">
									<i class="azicon icon-square"></i>
									&nbsp;Chọn tin</a>
								</li>
								<?php } else { ?>
								<li class="bochontin bochontin_<?php echo $item->not_id ?>">
									<a href="javascript:void(0)"  onclick="bochontin(<?php echo $item->not_id ?>);">
									<i class="azicon icon-check-square"></i>
									&nbsp;Bỏ chọn tin</a>
								</li>
								<?php } ?>
							<?php } ?> 
							<li>
								<a href="javascript:void(0)" onclick="copylink('<?php echo current_url() . $afkey ?>');">
								<i class="azicon icon-coppy"></i>
								&nbsp;Sao chép liên kết</a>
							</li>
						</ul>
					</span>
                                        <?php  } ?>
                                </div>
			


				<div class="collapse" id="viewcomments" aria-expanded="false">	
					<?php if ($this->session->userdata('sessionUser') != 0) { ?>					
						<div id="cmt-container">
						
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
										<div style="background: #fff; margin-left:45px; padding:5px 10px; border-radius:20px">
											<strong style="color:#008c8c"><?php echo $comment['noc_name']; ?></strong>
											<span data-utime="<?php echo $comment['noc_date'] ?>" class="com-dt">
												(<?php
												$dat_cmt = strtotime($comment['noc_date']);
												echo $dat_cmt = date('d/m/Y', $dat_cmt);
												?>)
											</span> 
											<span><?php echo $comment['noc_comment']; ?></span> 
										</div>
										<?php if ($this->session->userdata('sessionUser')) : ?>
											<div style="padding-left: 45px;"> 
											<a class="" role="button" data-toggle="collapse" href="#comment<?php echo $comment['noc_id'] ?>" aria-expanded="false" aria-controls="collapseExample">
												<em>Trả lời (<?php echo count($comment['replycomment']) ?>)</em>
												<span class="caret"></span>
											</a>
											<div class="collapse" id="comment<?php echo $comment['noc_id'] ?>">
												<form id="commentForm<?php echo $comment['noc_id'] ?>" class="form-horizontal" method="post" name="frmReply">
												<div class="pull-right">
													<input class="btn btn-azibai" <?php if ((int) $this->session->userdata('sessionUser') <= 0) {
											?> data-toggle="modal" data-target="#myModal" type="button"
													   <?php } else { ?> type="submit"
													   <?php } ?> value="Gửi" name="submit_reply"/>
													<input type="hidden" value="<?php echo $this->session->userdata('sessionUser') ?>" name="noc_user" />

													<input type="hidden" value="<?php echo $item->not_id; ?>" name="noc_content" />
													<input type="hidden" value="<?php echo $comment['noc_id']; ?>" name="noc_reply" />
												</div>
												<div style="margin-right:55px;">
													<textarea maxlength="500" class="form-control" id="noc_comment" name="noc_comment" placeholder="Nhập nội dung bình luận"></textarea>
												</div>
												</form>
											</div>

											</div>
											<script>
											jQuery(function ($) {
												$("#commentForm<?php echo $comment['noc_id'] ?>").validate({rules: {noc_comment: "required"}, messages: {noc_comment: "Vui lòng nhập nội dung bình luận."}, submitHandler: function (form) {
												jQuery.ajax({type: "POST", url: siteUrl + "tintuc/comment", data: jQuery(form).find(':input').serialize(), dataType: "json", success: function (data) {
													location.reload();
												}})
												}})
											})
											</script>
										<?php endif; ?>   
									</div>
									<div class="replycomment">
									<?php foreach ($comment['replycomment'] as $key => $value) :
										$avatar = base_url() . 'templates/home/images/noavatar.jpg';
										if ($value['noc_avatar']) {
											$avatar = DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $value['noc_avatar'];
										}
										?>
										<div class="cmt-cnt" style="margin-left: 45px;">
											<img src="<?php echo $avatar; ?>" />
											<div class="thecom">
												<div style="background: #fff; margin-left:45px; padding:5px 10px; border-radius:20px">
													<strong style="color:#008c8c">
														<?php echo $value['noc_name']; ?>
													</strong>
													<span data-utime="<?php echo $value['noc_date'] ?>" class="com-dt">
														(<?php
														$dat_cmt = strtotime($value['noc_date']);
														echo $dat_cmt = date('d/m/Y', $dat_cmt);
														?>)
													</span>                                                            
													<span>
														<?php echo $value['noc_comment']; ?>
													</span>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
									</div>
								</div>
								
							<?php endforeach; ?>
							<?php endif; ?>
							<div class="text-center"><?php echo $pager; ?></div>
						<?php } ?>
							<form id="commentForm1" class="form-horizontal" method="post" name="frmReply">
							<div class="pull-right">
								<input class="btn btn-azibai" <?php if ((int) $this->session->userdata('sessionUser') <= 0) {
							?> data-toggle="modal" data-target="#myModal" type="button"
								   <?php } else { ?> type="submit"
								   <?php } ?> value="Gửi" name="submit_reply"/>
								<input type="hidden" value="<?php echo $this->session->userdata('sessionUser'); ?>" name="noc_user" />
								<input type="hidden" value="<?php echo $item->not_id; ?>" name="noc_content" />
								<input type="hidden" value="0" name="noc_reply" />
							</div>
							<div style="margin-right:55px;">
								<textarea maxlength="500" class="form-control" id="noc_comment" name="noc_comment" placeholder="Nhập nội dung bình luận"></textarea>
							</div>
							</form>
						</div>
						<?php if ((int) $this->session->userdata('sessionUser') > 0) { ?>
						<script type="text/javascript">
							jQuery(function ($) {
							$("#commentForm1").validate({rules: {noc_comment: "required"}, messages: {noc_comment: "Vui lòng nhập nội dung bình luận."}, submitHandler: function (form) {
							jQuery.ajax({type: "POST", url: siteUrl + "tintuc/comment", data: jQuery(form).find(':input').serialize(), dataType: "json", success: function (data1) {
								location.reload();
								}});
							}});
							});
						</script>
						<?php } ?>
						<div class="clearfix"></div>
                                 
					<?php } else { ?>
						<div class="small text-center" style="padding:15px; border:1px solid #eee;">
						Bạn chưa đăng nhập. Vui lòng đăng nhập để xem và viết bình luận!
						</div>
					<?php } ?>					
				</div> 
		    </div>
		    
		    <div id="img_post_gallery">
			<?php
			if ( count($item->listImg  ) > 0) {
			    foreach ($item->listImg  as $key => $value) {
				$imgstyle = json_decode($value->style);
				switch($imgstyle->display) {
				    case 2: // màu nền
					$style = 'padding:0 0 10px; background:'.$imgstyle->background.'; color: '.$imgstyle->color;
					$imagestyle = 'padding:50px 20px 30px;';
					$captionstyle = 'padding:0px 20px 20px; text-align: justify';
                                        $imgborder = 'border:1px solid #999;border-radius:10px;';
					$iconstyle = 'white';
					break;
				    case 1: // ảnh nền
					$style = 'padding:0 0 10px; background: url(' . DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image .'/'. $value->image.') no-repeat center / cover; color: #fff; color: #ffffff';
					$imagestyle = 'padding:50px 20px 30px;';
					$captionstyle = 'padding:0px 20px 20px; text-align: justify';
                                        $imgborder = 'border:1px solid #999;border-radius:10px;';
					$iconstyle = 'white';
					break; 
				    default:
					$style = 'border:1px solid #ddd; padding:0 0 10px;background: #fff;';
					$imagestyle = 'margin-bottom:30px;';
					$captionstyle = 'padding:0px 20px 20px; text-align: justify';
                                        $imgborder = '';
					$iconstyle = 'black';			
					break;
				} ?>
				<div class="img_post img_post_<?php echo $imgstyle->display ?>" style="<?php echo $style ?>">
                                    <div class="<?php echo $imgstyle->imgeffect ?> wow" data-wow-duration="1s" style="<?php echo $imagestyle ?>">
                                        <div style="position: relative">
                                            <a class="item key_<?php echo $key ?>" href="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $value->image ?>" data-sub-html=".caption<?php echo $key ?>">
                                                <img class="img-responsive" style="<?php echo $imgborder ?>" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $value->image ?>"  alt="<?php echo $value->product->pro_name ?>" />
                                            </a>
                                            <?php if ($imgstyle->text_1_image != '' || $imgstyle->text_2_image != '' || $imgstyle->text_2_image != '') { ?>
                                                <?php if ($imgstyle->text_position == 'top') $pcss = 'position: absolute; left:0; right:0; top:0; text-shadow: 1px 1px #000; font-size: 150%;'; ?>
                                                <?php if ($imgstyle->text_position == 'bottom') $pcss = 'position: absolute; left:0; right:0; bottom:0; text-shadow: 1px 1px #000; font-size: 150%;'; ?>
                                                <?php if ($imgstyle->text_position == 'middle') $pcss = 'position: absolute; left:0; right:0; top: 50%; margin-top:-56px; text-shadow: 1px 1px #000; font-size: 150%;'; ?>
                                                <div style="<?php echo $pcss ?>">												
                                                    <div style="vertical-align: <?php echo $imgstyle->text_position; ?>">
                                                        <div style="background-color:<?php echo $imgstyle->rgba_color; ?>; color: <?php echo $imgstyle->text_color; ?>; font-family: '<?php echo $imgstyle->text_font; ?>';">																	
                                                            <div class="textonimg<?php echo $key ?> owl-carousel text-center">
                                                                <div style="display: table-cell; width:1%; vertical-align: middle; padding:20px;"><?php echo $imgstyle->text_1_image; ?></div>
                                                                <div style="display: table-cell; width:1%; vertical-align: middle; padding:20px;"><?php echo $imgstyle->text_2_image; ?></div>
                                                                <div style="display: table-cell; width:1%; vertical-align: middle; padding:20px;"><?php echo $imgstyle->text_3_image; ?></div>
                                                            </div>																	
                                                        </div>                                                            
                                                    </div>
                                                    <script>
							jQuery(function($){
                                                            $('.textonimg<?php echo $key ?>').owlCarousel({ animateOut: '<?php echo $imgstyle->text_effect_out; ?>', animateIn: '<?php echo $imgstyle->text_effect_in; ?>', loop: true, margin: 0, nav: false, dots: false, autoplay: true, autoplayTimeout:2500, items: 1 });
							});
						    </script>														
                                                </div>	
                                            <?php } ?>
                                        </div> 
                                    </div>

                                    <div class="<?php echo $imgstyle->texteffect ?> wow" style="<?php echo $captionstyle ?>" data-wow-duration="2s">					
                                        <div class="imgcaption">
                                            <div style="margin-bottom: 10px; font-size: 18px;">
                                                <h3><?php echo $value->title ?></h3>
                                            </div>
                                            <div class=""><?php echo nl2br($value->caption); ?></div>
                                        </div>

                                        <?php
                                        $caption2 = $imgstyle->caption2;
                                        foreach ($caption2 as $c => $caption) {
                                            ?>
                                            <div class="wow <?php echo $caption->effect ?> boxicon text-<?php echo $caption->posi ?>" style="margin: 60px 0;">
                                                <?php if ($caption->icon != '') { ?>
                                                    <img class="pull-<?php echo $caption->posi . ' ' . $iconstyle ?>" src="/images/icons/<?php echo $caption->icon ?>" alt="icon"/>
                                                    <div style="margin-<?php echo $caption->posi ?>: 100px;">
                                                        <h3><?php echo $caption->title ?></h3>
                                                        <p><?php echo nl2br($caption->desc) ?></p>
                                                    </div>					
                                                <?php } else { ?>
                                                    <div>
                                                        <h3><?php echo $caption->title ?></h3>
                                                        <p><?php echo nl2br($caption->desc) ?></p>
                                                    </div>
                                                <?php } ?>
                                            </div>	
                                            <?php
                                        }
                                        ?>						
                                    </div>
					
					
					
					

                                    <div class="caption caption<?php echo $key ?>">    
					    <ul class="menu-justified dropup small">						    
                                                <?php
						    if ($value->product) {	
                                                         if ($value->product->pro_type == 0) { $pro_type = 'product'; } elseif ($value->product->pro_type == 1) {$pro_type = 'service'; } else { $pro_type = 'coupon'; }
							$linktoproduct = getAliasDomain('grtshop/' . $pro_type . '/detail/' . $value->product->pro_id . '/' . RemoveSign($value->product->pro_name) . $afkey);
							?>
							<li class=""> 
							    <a href="<?php echo $linktoproduct ?>" target="_blank" style="color:<?php echo $iconstyle ?>">
								<i class="azicon <?php echo $iconstyle ?> icon-eye"></i>
								<br/>Chi tiết
							    </a>  
							</li>

							<li class="">
							    <a href="<?php echo $linktoproduct ?>" class="dropdown-toggle"  data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color:<?php echo $iconstyle ?>">
								<i class="azicon <?php echo $iconstyle ?> icon-share"></i>
								<br/>Chia sẻ
							    </a>
							    <ul class="dropdown-menu"  style="left: 0px; right:0px;">
								<li>
								    <div class="social-share">
									<a href="javascript:void(0)" onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $linktoproduct ?>&amp;app_id=<?php echo app_id ?>', 'facebook-share-dialog', 'width=800, height=450');
														    return false;">
									    <i class="azicon icon-facebook"></i>
									</a>
									<a href="javascript:void(0)" onclick="window.open('https://twitter.com/share?text=<?php echo $value->pro_name ?>&amp;url=<?php echo $linktoproduct ?>', 'twitter-share-dialog', 'width=800,height=450');
														    return false;">
									    <i class="azicon icon-twitter"></i>
									</a>
									<a href="javascript:void(0)" onclick="window.open('https://plus.google.com/share?url=<?php echo $linktoproduct ?>', 'google-share-dialog', 'width=800, height=450');
														    return false;">
									    <i class="azicon icon-google"></i>
									</a>
									<a style="margin-right:15px;" class="pull-right" target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to&su=<?php echo $value->pro_name ?>&body=<?php echo $linktoproduct ?>&ui=2&tf=1" >
									    <i class="azicon icon-email"></i>
									</a>

								    </div>
								</li>
								<li>
								    <a href="javascript:void(0)" onclick="copylink('<?php echo $linktoproduct ?>');">
									<i class="azicon icon-coppy"></i>
									&nbsp;Sao chép liên kết
								    </a>
								</li>
							    </ul>
							</li>
						    <?php } ?>

						    <?php if ($value->detail): ?>
							<li class="">
                                                            <a target="blank" href="<?php echo $value->detail ?>" style="color:<?php echo $iconstyle ?>">
								<i class="azicon <?php echo $iconstyle ?> icon-more"></i>
								<br/>Xem thêm
							    </a>
							</li>
						    <?php endif; ?>

					    </ul>					    
					</div> 

				</div>
				
			    <?php } //endforeach ?>
			<?php } //endif ?>
		    </div>
                    
		    <?php 
		    $ad = json_decode($item->not_ad);                    
		    if ($ad->ad_image != "" && $ad->ad_status == 1) {
                        ?>                     
                        <?php if($ad->ad_title1 == '' && $ad->ad_desc1 == '' && $ad->ad_time == '') { ?>
                        <div style="margin-bottom: 20px">
                            <a href="<?php echo $ad->ad_link ?>"><img src="<?php echo DOMAIN_CLOUDSERVER.'media/images/content/'.$item->not_dir_image.'/'.$ad->ad_image ?>"/></a>
                        </div>
                        <?php } else { ?>
                        <div class="adbanner" style="background:url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $ad->ad_image ?>) no-repeat center / cover;">
                            
                            
                            <?php if ($ad->ad_content) { ?>
                            <div id="postad" class="owl-carousel">
                                <?php foreach ($ad->ad_content as $key => $value) { ?>
                                    <div class="adtext text-center">                               
                                        <h2 class="text-uppercase" style="margin-bottom:20px;"><?php echo $value->title ?></h2>                                
                                        <p style="font-size:18px;"><?php echo $value->desc ?></p>                                                              
                                    </div>                                    
                                <?php } ?> 
                             </div>
                            <?php } ?>
                            <br>    
                            <?php if ($ad->ad_time != "") { ?>
                                <?php if ($ad->ad_display == 2) { ?>
                                    <div class="countdown2" class="text-center"></div>
                                <?php } else { ?> 
                                    <div>
                                        <section id="anaclock">						
                                            <div id="clock">
                                                <div id="hour"></div>
                                                <div id="minute"></div>
                                                <div id="second"></div>
                                                <div id="center"></div>					
                                            </div>
                                            <div class="textclock" class="text-center">Thời gian còn lại</div>						
                                            <div class="countdown" class="text-center"></div>
                                        </section>
                                    </div>
                                <?php } ?>  
                            <?php } ?>
				<div style="position: relative; margin: 80px 0 0; text-align: center;">
				    <a href="<?php echo $ad->ad_link ?>" target="_blank" class="btn_ad_link">Xem chi tiết</a>
				</div>   
                        </div>
                        
                        <script src="/templates/home/js/jquery.countdown.min.js"></script>   
                        <script>
                            jQuery(function ($) {
                                $('.countdown,.countdown2').countdown('<?php echo $ad->ad_time ?>', function(event) {
				    $(this).html(event.strftime('<span><strong>%D</strong><br>Ngày</span> <span><strong>%H</strong><br>Giờ</span> <span><strong>%M</strong><br>Phút</span> <span><strong>%S</strong><br>Giây</span>'));
                                });
				
                              if (!window.requestAnimationFrame) {
                                    window.requestAnimationFrame = window.mozRequestAnimationFrame ||
                                      window.webkitRequestAnimationFrame ||
                                      window.msRequestAnimationFrame ||
                                      window.oRequestAnimationFrame ||
                                      function (cb) { setTimeout(cb, 1000/60); };
                              }

                              var $h = $("#hour"),
                                      $m = $("#minute"),
                                      $s = $("#second");

                              function computeTimePositions($h, $m, $s) {
                                    var now = new Date(),
                                            h = now.getHours(),
                                            m = now.getMinutes(),
                                            s = now.getSeconds(),
                                            ms = now.getMilliseconds(),
                                            degS, degM, degH;

                                    degS = (s * 6) + (6 / 1000 * ms);
                                    degM = (m * 6) + (6 / 60 * s) + (6 / (60 * 1000) * ms);
                                    degH = (h * 30) + (30 / 60 * m);

                                    $s.css({ "transform": "rotate(" + degS + "deg)" });
                                    $m.css({ "transform": "rotate(" + degM + "deg)" });
                                    $h.css({ "transform": "rotate(" + degH + "deg)" });

                                    requestAnimationFrame(function () {
                                      computeTimePositions($h, $m, $s);
                                    });
                              }

                              function setUpFace() {
                                    for (var x = 1; x <= 60; x += 1) {
                                      addTick(x); 
                                    }

                                    function addTick(n) {
                                      var tickClass = "smallTick",
                                              tickBox = $("<div class=\"faceBox\"></div>"),
                                              tick = $("<div></div>"),
                                              tickNum = "";

                                      if (n % 5 === 0) {
                                            tickClass = (n % 15 === 0) ? "largeTick" : "mediumTick";
                                            tickNum = $("<div class=\"tickNum\"></div>").text(n / 5).css({ "transform": "rotate(-" + (n * 6) + "deg)" });
                                            if (n >= 50) {
                                              tickNum.css({"left":"-0.5em"});
                                            }
                                      }


                                      tickBox.append(tick.addClass(tickClass)).css({ "transform": "rotate(" + (n * 6) + "deg)" });
                                      tickBox.append(tickNum);

                                      $("#clock").append(tickBox);
                                    }
                              }

                              function setSize() {
                                    var b = $(this), //html, body
                                            w = b.width(),
                                            x = Math.floor(w / 30) - 1,
                                            px = (x > 25 ? 26 : x) + "px";

                                    $("#clock").css({"font-size": px });

                                    if (b.width() !== 400) {
                                      setTimeout(function() { $("._drag").hide(); }, 500);
                                    }
                              }

                              $(document).ready(function () {
                                    setUpFace();
                                    computeTimePositions($h, $m, $s);
                                    $("section").on("resize", setSize).trigger("resize");
                                    //$("section").resizable({handles: 'e'});    
                              });
                            });
                        </script>			
                        <?php } ?>
                    <?php } ?>
                    <?php if($item->not_statistic == 1) {
                        if ($item->statistic != '') {
                              $statistic = json_decode($item->statistic);
                        }
                        ?>
                        <div id="post_statistic" class="post_statistic" style=" background:url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $item->img_statistic ?>) no-repeat center / cover;">
                            <div class="row text-center">
                                <?php  foreach ($statistic as $k =>  $value) { if( $k > 1 && $k % 2 == 1 ) echo '</div><div class="row text-center">';?>
                                <div class="col-xs-6">
                                    <p class="countnumber" style="font-size:48px;" data-count="<?php echo $value->num ?>">0</p>
                                    <p style="font-size:18px"><?php echo $value->title ?></p>
                                    <p style="font-size:12px"><?php echo $value->description ?></p>
                                    <br>
                                </div>
                                <?php } ?>                        
                            </div>
                        </div>
                        <script>
                            var a = 0; $(window).scroll(function() { var oTop = $('#post_statistic').offset().top - window.innerHeight; if (a == 0 && $(window).scrollTop() > oTop) { $('.countnumber').each(function() { var $this = $(this), countTo = $this.attr('data-count'); $({ countNum: $this.text() }).animate({ countNum: countTo }, { duration: 5000, easing: 'swing', step: function() { $this.text(Math.floor(this.countNum)); }, complete: function() { $this.text(this.countNum); } }); }); a = 1; } });                   
                        </script>
                    <?php } ?>
                        
                    <?php $not_customer = json_decode($item->not_customer);                        
                    if(count($not_customer->cus_list) > 0) { ?>    
                        <div  style="padding: 30px 20px 30px; background: <?php echo $not_customer->cus_background ?>; color: <?php echo $not_customer->cus_color ?>; ">
                            <h4 class="text-center"><?php echo $not_customer->cus_title ?></h4>
                            <br>
                            <div id="customer" class="owl-carousel text-center">  
                            <?php foreach ($not_customer->cus_list as $key => $customer) { ?>
                                <div>
                                    <div style="width:100px; margin: 20px auto;">
                                        <a href="<?php echo ($customer->cus_link)?$customer->cus_link:'#customer' ?>" target="_blank">
                                            <img class="img-responsive img-circle" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $customer->cus_avatar ?>" alt="<?php echo $customer->cus_text1 ?>">
                                        </a>
                                    </div>                                
                                    <p><strong><?php echo $customer->cus_text1 ?></strong></p>
                                    <p style="color:red"><?php echo $customer->cus_text2 ?></p>
                                    <p style="font-size:small; height: 76px; overflow: hidden;"><?php echo mb_substr($customer->cus_text3, 0, 150) ?>...</p>                                                                        
                                    <p style="margin-bottom:20px;"><button class="btn btn-sm btn-link" style="color: <?php echo $not_customer->cus_color ?>" data-toggle="modal" data-target="#modal_<?php echo $key ?>">&nbsp; Xem thêm &nbsp;</button></p>
                                    <p>
                                        <a style="color: <?php echo $not_customer->cus_color ?>;border: 1px solid; border-radius: 50%; padding: 5px;" href="<?php echo $customer->cus_facebook ?>" target="_blank"><i class="fa fa-facebook fa-fw"></i></a>
                                        &nbsp; <a style="color: <?php echo $not_customer->cus_color ?>;border: 1px solid; border-radius: 50%; padding: 5px;" href="<?php echo $customer->cus_twitter ?>" target="_blank"><i class="fa fa-twitter fa-fw"></i></a> &nbsp; 
                                        <a style="color: <?php echo $not_customer->cus_color ?>;border: 1px solid; border-radius: 50%; padding: 5px;" href="<?php echo $customer->cus_google ?>" target="_blank"><i class="fa fa-google-plus fa-fw"></i></a>
                                    </p>
                                </div>
                            <?php } ?>    
                            </div>
                        </div>
                        <?php foreach ($not_customer->cus_list as $key => $customer) { ?>
                        <div class="modal fade" id="modal_<?php echo $key ?>" tabindex="-1" role="dialog" aria-labelledby="modal_<?php echo $key ?>_Label">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title"><?php echo $not_customer->cus_title ?></h4>
                                    </div>
                                    <div class="modal-body"> 
                                        <div class="row">
                                            <div class="col-sm-4 col-xs-12 text-center">
                                                <div style="width:200px; margin: 20px auto">
                                                    <a href="<?php echo ($customer->cus_link)?$customer->cus_link:'#customer' ?>" target="_blank">
                                                        <img class="img-responsive img-circle" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $customer->cus_avatar ?>" alt="<?php echo $customer->cus_text1 ?>">
                                                    </a>
                                                </div>
                                                <p><strong><?php echo $customer->cus_text1 ?></strong></p>
                                                <p style="color:red"><?php echo $customer->cus_text2 ?></p>
                                                <p>
                                                    <a style="border: 1px solid; border-radius: 50%; padding: 5px 6px;" href="<?php echo $customer->cus_facebook ?>" target="_blank"><i class="fa fa-facebook fa-fw"></i></a>
                                                    &nbsp; <a style="border: 1px solid; border-radius: 50%; padding: 5px 6px;" href="<?php echo $customer->cus_twitter ?>" target="_blank"><i class="fa fa-twitter fa-fw"></i></a> &nbsp; 
                                                    <a style="border: 1px solid; border-radius: 50%; padding: 5px 6px;" href="<?php echo $customer->cus_google ?>" target="_blank"><i class="fa fa-google-plus fa-fw"></i></a>
                                                </p>
                                            </div>
                                            <div class="col-sm-8 col-xs-12">
                                                <q> <?php echo $customer->cus_text3 ?> </q>
                                            </div>
                                        </div>                                    
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" data-dismiss="modal">Đóng</button>
                                    </div>
                                </div>
                            </div>
                        </div>    
                        <?php } ?>
                        <br> 
                    <?php } //end if count cus_list ?>    

                        
                        <?php if (count($item->listPro) > 0) { ?>
                            <div class="mod-Pro">
                                <div class="title">Sản phẩm:</div>		
                                <div id="listPro" class="owl-carousel text-center">
                                    <?php                                     
                                    foreach ($item->listPro as $k => $product) {
                                        if ($value->pro_type == 0) { $pro_type = 'product'; } elseif ($value->pro_type == 1) {$pro_type = 'service'; } else { $pro_type = 'coupon'; }
                                        $linktoproduct = getAliasDomain('grtshop/' . $pro_type . '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name));
                                        ?>
                                        <div class="itempro" title="<?php echo $product->pro_name ?>" style="border:1px solid #eee; background: #fff; ">                                            
                                            <div class="fix1by1">
                                                <a class="c" href="<?php echo $linktoproduct ?>">
                                                    <img class="pro_image img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/' . show_image($product->pro_image); ?>"/>
                                                </a>
                                            </div>                                            
                                            <div style="padding: 5px 10px; border-top:1px solid #eee;">
                                                <div class="proname">
                                                    <a href="<?php echo $linktoproduct ?>"><?php echo $product->pro_name ?></a>
                                                </div>
                                                <div class="procost">
                                                    <strong><?php echo number_format($product->pro_cost, 0, ",", ".") . ' ' . $product->pro_currency ?></strong>
                                                </div>
                                                <?php if ($product->end_date_sale != '' && $product->end_date_sale > strtotime(date("Y-m-d"))) { ?>	
                                                    <div class="text-primary"><i class="fa fa-clock-o" aria-hidden="true"></i> <span  data-countdown="<?php echo date("Y-m-d", $product->end_date_sale) ?>"></span></div>
                                                <?php } else { ?>
                                                    <div class="probuy"><a href="<?php echo $linktoproduct ?>" class="btn btn-default btn-xs">→ Xem chi tiết</a></div>
                                                <?php } ?>                                                   
                                            </div>                                            
                                        </div>                                       
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
		</div>
            </div>
        </div>

        <div class="col-xs-12 col-sm-3">
            <div class="panel panel-default panel-about">                
                <div class="panel-heading">Sản phẩm mới</div>
                <div class="panel-body">                     
                    <?php
                    foreach ($products as $key => $item) {
                        $images = explode(',', $item->pro_image);
                        ?>
                        <div class="media"> 
                            <div class="media-left">
                                <div class="fix1by1" style="width:70px">
                                    <div class="c">
                                        <a href="<?php echo site_url('grtshop/product/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name)); ?>">
                                            <img class="media-object" alt=""  
                                                 src="<?php
                                                 if ($item->pro_image != "") {
                                                     echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $item->pro_dir . '/thumbnail_1_' . $images[0];
                                                 } else {
                                                     echo site_url('media/images/no_photo_icon.png');
                                                 }
                                                 ?>"/>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="media-body">
                                <h4 class="media-heading">
                                    <a href="<?php echo site_url('grtshop/product/detail/' . $item->pro_id . '/' . RemoveSign($item->pro_name)); ?>">
    <?php echo $item->pro_name ?>
                                    </a>
                                </h4> 
                                <div class="price"><strong class="text-danger"><?php echo number_format($item->pro_cost) ?></strong> đ</div>
                            </div> 
                        </div>
<?php } ?>
                </div>                
            </div>  
        </div>  

        <div class="col-xs-12 col-sm-2">
	    <?php $this->load->view('group/news/common/ads-right'); ?>               
        </div> 
    </div> 
</div>
<?php if ($this->session->userdata('sessionUser') != 0) { ?>
    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel">
        <div class="modal-dialog" role="document">
    	<div class="modal-content">
    	    <form id="frmReport" name="frmReport" action="/home/tintuc/report" method="post" class="form" enctype="multipart/form-data">   
    		<div class="modal-header">
    		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    		    <h4 class="modal-title" id="reportModalLabel">Gửi báo cáo bài viết</h4>
    		</div>
    		<div class="modal-body">
    		    <input id="reportpost" name="not_id" type="hidden" value="">
    		    <input id="reportlink" name="not_link" type="hidden" value="">
			<?php foreach ($listreports as $key => $value) { ?>
			    <div class="radio">
				<label>
				    <input type="radio" name="rp_id" id="optionsReport" value="<?php echo $value->rp_id ?>" <?php echo $key == 0 ? 'checked' : '' ?> >
				    <?php echo $value->rp_desc ?>
				</label>
			    </div>			
			<?php } ?>
                    <textarea type="text" name="rpd_reason" id="rpd_reason" placeholder="Nhập nội dung báo cáo" class="" style="display: none; resize: none; width: 100%; padding: 5px;"/></textarea>
                </div>
    		<div class="modal-footer">
    		    <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
    		    <button type="submit" class="btn btn-primary">Gửi báo cáo</button>
    		</div>
    	    </form>
    	</div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('input[name=rp_id]').each(function(){
                $(this).change(function () {
                    if ($(this).val() == '6' && $(this).is(':checked')) {
                        $('#rpd_reason').fadeIn(400);
                        $('#rpd_reason').attr('required','required');
                    }else{
                        $('#rpd_reason').fadeOut(0);
                        $('#rpd_reason').removeAttr('required');
                    }
                });
            });
        });
    
        $('.report').click(function () {
            $('#reportpost').attr('value', $(this).data('id'));
            $('#reportlink').attr('value', $(this).data('link'));
        });
        
        var frm = $('#frmReport');
        frm.submit(function (e) {
    	e.preventDefault();
    	$.ajax({
    	    type: frm.attr('method'),
    	    url: frm.attr('action'),
    	    data: frm.serialize(),
    	    success: function (data) {
    		var mes = '';
    		$('#reportModal').modal('hide');
    		if (data == '0') {
    		    mes = 'Bạn đã gửi báo cáo bài viết này rồi. Cảm ơn bạn!';
    		} else if (data == '1') {
    		    mes = 'Gửi báo cáo bài viết thành công. Cảm ơn bạn!';
    		}
    		$.jAlert({
    		    'title': 'Thông báo',
    		    'content': mes,
    		    'theme': 'default',
    		    'btns': {
    			'text': 'Ok', 'theme': 'blue', 'onClick': function (e, btn) {
    			    e.preventDefault();
                            location.reload();
    			    return false;
    			}
    		    }
    		});
    	    },
    	    error: function (data) {
    		$('#reportModal').modal('show');
    	    }
    	});
        });
    </script> 
<?php } else { ?>
    <div class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel">
        <div class="modal-dialog" role="document">
    	<div class="modal-content">
    	    <div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    		<h4 class="modal-title" id="reportModalLabel">Gửi báo cáo bài viết</h4>
    	    </div>
    	    <div class="modal-body">
    		<div class="alert alert-warning" role="alert">
    		    Bạn chưa đăng nhập, vui lòng <a href="/login">đăng nhập</a> vào để sử dụng tính năng này!
    		</div>
    	    </div>
    	    <div class="modal-footer">
    		<button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>			
    	    </div>		
    	</div>
        </div>
    </div>
<?php } ?>
<script src="/templates/home/js/jquery.countdown.min.js"></script> 
<script> 
function copylink(link) { clipboard.copy(link); }
jQuery(function ($) {
    <?php if ($isMobile == 1) { ?>
        $(window).scroll(function () {
            var scroll = $(window).scrollTop();
            if (scroll >= $(window).height()/4) {
                $('#header').fadeIn();
            } else {
                $('#header').fadeOut();
            }
        });
        var h = $(window).height() - $('.detail-banner').height();  
        $('.detail-banner').next().css("height",h);	
        $('.ngocheo').click(function(e){ e.preventDefault(); $('html,body').animate({scrollTop: $('#brand').offset().top - 40},'slow'); });
    <?php } else { ?>
        $('.fixtoscroll').scrollToFixed({
            marginTop: function () {
                var marginTop = $(window).height() - $(this).outerHeight(true) - 20;
                if (marginTop >= 0)
                    return 75;
                return marginTop;
            },
            limit: function () {
                var limit = 0;
                limit = $('#footer').offset().top - $(this).outerHeight(true) - 20;
                return limit;
            }
        });
    <?php } ?>
     
      
    
    var clickvolume = 0;
    $(".az-volume").click(function(){ 	
        if(clickvolume == 0){
            $('.az-volume').attr("src","/templates/home/icons/icon-volume-on.png");
            $('#audio<?php echo $item->not_id ?>').trigger("play");
            clickvolume = 1;
        } else {
            $('.az-volume').attr("src","/templates/home/icons/icon-volume-off.png");
            $('#audio<?php echo $item->not_id ?>').trigger("pause");
            clickvolume = 0;
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
                $('.az-volume').attr("src","/templates/home/icons/icon-volume-off.png");
                $('#audio<?php echo $item->not_id ?>').trigger("pause");
            }
        });
    }
    $(document).on('scroll', checkMedia);
    $('[data-countdown]').each(function() { var $this = $(this), finalDate = $(this).data('countdown'); $this.countdown(finalDate, function(event) { $this.html(event.strftime('%D ngày %H:%M:%S')); }); });
    $('.rowpro .owl-carousel').owlCarousel({ loop: true, margin: 5, nav: true, dots: false, responsive:{ 0:{ items:1 }, 600:{ items:2 } } });
    $('.lazy').lazy();
    
    $('#img_post_gallery').lightGallery({selector: '.item', download: false});    
    $('#listPro').owlCarousel({ loop: false, margin: 20, nav: true, dots: false, responsive: { 0: { items: 2 }, 600: { items: 3 } } });
    $('#customer').owlCarousel({ loop: false, margin: 20, nav: false, dots: true, items: 2 });
    $('#postad').owlCarousel({ animateOut: 'fadeOutDown', animateIn: 'zoomIn', loop: true, margin: 0, nav: false, dots: false, autoplay: true, autoplayTimeout:2500, items: 1 });
     new WOW().init();
});
</script>


<?php $this->load->view('group/news/common/footer'); ?>

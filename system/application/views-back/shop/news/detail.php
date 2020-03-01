<?php $this->load->view('shop/news/header-old'); ?>
<link href="https://fonts.googleapis.com/css?family=Anton|Arsenal|Exo|Francois+One|Muli|Nunito+Sans|Open+Sans+Condensed:300|Oswald|Pattaya|Roboto+Condensed|Saira+Condensed|Saira+Extra+Condensedsubset=latin-ext,vietnamese" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="/templates/home/lightgallery/dist/css/lightgallery.css" />

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

    if ($af_id != '') {
        $suffix = '?af_id=' . $af_id;
    } else {
        $suffix = '';
    }
    
    if($item->domain){ $domainshop = $protocol . $item->domain; } else { $domainshop = $protocol . $item->sho_link . '.' . domain_site; }
    
    ?>
    <!--START main-->

    <?php if ($isMobile == 0) { ?>
        <div id="header" class="header_fixed" style="display: block;">			 			
            <?php $this->load->view('shop/common/menubar'); ?>			
        </div>	
    <?php } else { ?>
        <div id="header" class="header_fixed" style="display: none;">	
            <?php $this->load->view('shop/common/m_menu'); ?>	
        </div>
        <style>
            body{ margin-top: 0;}
        </style>
    <?php } ?>


    
    <div class="container-fluid">	
        <div class="row rowmain">
            <div class="col-lg-2 col-md-3 hidden-sm hidden-xs"> 
                <?php $this->load->view('shop/common/menu'); ?>
            </div>  

            <div class="col-lg-5 col-md-6 col-sm-8 col-xs-12">

                <?php
                if ($item->not_image != '') {
                    $item_image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $item->not_image;
                } else {
                    $item_image = DOMAIN_CLOUDSERVER . 'media/shop/banners/' . $item->sho_dir_banner . '/' . $item->sho_banner;
                }                
                if ($item->not_display == 1) { 
                    ?>
                    <style>    
                        .detail-banner {
                            background: url(<?php echo $item_image ?>) no-repeat center;
                            background-size: cover; -moz-background-size: cover; -webkit-background-size: cover; -o-background-size: cover;	
                        }
                        .detail-banner::before { content:''; position: absolute; top:0; right:0; bottom:0; left:0; background:rgba(0,0,0,.75); }    
                        .detail-content { 
                            background: url('<?php echo $item_image ?>') no-repeat scroll center; 
                            background-size: cover; -moz-background-size: cover; -webkit-background-size: cover; -o-background-size: cover;	
                            position: relative; padding: 25px 20px 20px; color: #fff;  margin-bottom: 20px;
                        }
                        .detail-content::before { content:''; position: absolute; top:0; right:0; bottom:0; left:0; background:rgba(0,0,0,.75); } 
                        #videos .owl-nav button { padding: 7px 0; position:absolute; top:50%; margin-top: -30px; background: none; color: #fff;}
                        #videos .owl-nav button:hover { background:rgba(0,0,0,.5); color: #fff;}
                        #videos .owl-nav button.owl-next{ right: 0}
                        #videos .owl-nav button.owl-prev{ left: 0}
                        <?php if ($item->not_slideshow == 1) {   
                            echo '@media only screen and (min-width: 1000px) {
                                .detail-banner { padding: 60px 90px 120px; }
                                .wowslider-container .ws_bullets {top: -35px;}
                                .wowslider-container .ws-title{top: 100%;}                            
                                .wowslider-container a.ws_next { left: 100%;}
                                .wowslider-container a.ws_prev { right: 100%;}
                            }
                            @media only screen and (max-width: 600px) {
                                .detail-banner { height: 100vh;  padding: 60px 20px 20px; }
                                .wowslider-container .ws_bullets {top: -35px;}
                                .wowslider-container .ws-title{top: 100%;}                            
                                .wowslider-container a.ws_next { left: 85%;}
                                .wowslider-container a.ws_prev { right: 85%;}   
                            }';
                        } else {
                            echo '@media only screen and (min-width: 1000px) {

                            }
                            @media only screen and (max-width: 600px) {
                                .detail-banner { height: 100vh; padding: 20px 20px 20px;  } 
                                .detail-banner .fix1by1 { border: 1px solid #fff; border-radius: 10px; }
                            }';    
                        } ?>  
                    </style>
                    <?php
                    $classicon = 'white';
                } else { 
                    ?>
                    <style>    
                        .detail-banner {
                            background: url(<?php echo $item_image ?>) no-repeat center;
                            background-size: cover; -moz-background-size: cover; -webkit-background-size: cover; -o-background-size: cover;	
                        }
                        .detail-banner::before { content:''; position: absolute; top:0; right:0; bottom:0; left:0; background:rgba(0,0,0,.75); }    
                        #videos .owl-nav button { padding: 7px 0; position:absolute; top:50%; margin-top: -30px; background: none; color: #fff;}
                        #videos .owl-nav button:hover { background:rgba(0,0,0,.5); color: #fff;}
                        #videos .owl-nav button.owl-next{ right: 0}
                        #videos .owl-nav button.owl-prev{ left: 0}
                        <?php if ($item->not_slideshow == 1) { 
                            echo '@media only screen and (min-width: 1000px) {
                                .wowslider-container .ws-title{ padding: 0 30px;} 
                            }
                            @media only screen and (max-width: 600px) {
                                .detail-banner { height: 100vh;   }
                                .wowslider-container .ws_bullets {}
                                .wowslider-container .ws-title { padding: 0 30px;}                            
                                .wowslider-container a.ws_next { left: 85%;}
                                .wowslider-container a.ws_prev { right: 85%;}   
                            }';
                         } else { 
                            echo '@media only screen and (min-width: 1000px) {

                            }
                            @media only screen and (max-width: 600px) {
                                .detail-banner { height: 100vh;   }
                                .detail-banner .ngocheo .not_title { padding: 0 30px; }
                            }';    
                        } ?>  
                    </style>
                    <?php
                    $classicon = 'black';
                } 
                ?>
                  
                <div class="newfeeds">
                    <div class="article">                            
                        <div class="detail-top">
                            <?php if ($item->not_slideshow == 1) { ?>                            
                                <div class="detail-banner">                            
                                    <div id="wowslider-container<?php echo $item->not_id ?>" class="wowslider-container">
                                        <div class="ws_images">
                                            <ul>
                                                <?php foreach ($listImg as $key => $value) { ?>
                                                    <li>
                                                        <img src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/1x1_' . $value->image ?>" 
                                                             alt="<?php echo ($value->title) ? $value->title : $item->not_title ?>" 
                                                             title="<?php echo ($value->title) ? $value->title : $item->not_title ?>" 
                                                             id="wows1_<?php echo $key ?>" />                                               
                                                    </li>
                                                <?php } ?>
                                            </ul>
                                        </div>
                                        <div class="ws_bullets">
                                            <div>
                                                <?php foreach ($listImg as $key => $value) { ?>
                                                    <a href="#" title="<?php echo $value->title ?>"><span><?php echo $key ?></span></a>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>			    
                                    <script>
                                        jQuery("#wowslider-container<?php echo $item->not_id ?>").wowSlider({effect: "<?php echo explode("|", $item->not_effect)[0] ?>", prev: "", next: "", duration: 20 * 100, delay: 10 * 100, width: 600, height: 338, autoPlay: true, autoPlayVideo: false, playPause: true, stopOnHover: false, loop: false, bullets: 1, caption: true, captionEffect: "move", controls: true, controlsThumb: false, responsive: 1, fullScreen: false, gestures: 2, onBeforeStep: 0, images: 0});
                                    </script>
                                    <?php if ($item->not_music != '') { ?>									
                                        <audio preload="false" id="audio<?php echo $item->not_id ?>" src="<?php echo '/media/musics/' . $item->not_music; ?>"></audio>
                                        <img class="az-volume" src="/templates/home/icons/icon-volume-off.png" style="position: absolute;top: 10px;z-index: 9999;right: 10px;width: 40px;"/>
                                    <?php } ?>  
                                </div>                                
                            <?php } else { ?>    
                                <?php if ($isMobile == 1) { ?>
                                    <div class="detail-banner"> 
                                        <div class="fix1by1">
                                            <div class="c" style="background:url(<?php echo $item_image ?>) no-repeat center center / cover"></div>
                                        </div>                                        
                                        <div class="ngocheo">
                                            <div class="not_title"><?php echo $item->not_title ?></div>
                                        </div>
                                    </div>
                                <?php } else { ?>

                                    <div class="fix16by9">
                                        <div class="c" style="background:url(<?php echo $item_image ?>) no-repeat center center / cover"></div>
                                    </div>

                                <?php } ?>

                            <?php } ?>
                            <div class="scrollview" style="position: absolute; bottom:0; left:0; right:0; height: 200px; z-index:999;"></div> 
                        </div>
                        <?php if ($item->not_video_url || $item->not_video_url1) { ?>
                        <div id="videos">
                            <div class="owl-carousel">				
                                <?php if ($item->not_video_url1) { ?>			
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <video controls class="embed-responsive-item">
                                            <source src="<?php echo DOMAIN_CLOUDSERVER . 'video/' . $item->not_video_url1 ?>" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    </div>
                                <?php } ?>  
                                <?php if ($item->not_video_url) { ?>
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/<?php echo $item->not_video_url; ?>?rel=0" frameborder="0" allowfullscreen></iframe>
                                    </div>
                                <?php } ?>
                            </div>
                            <script>
                            jQuery(function ($) {
                                $('#videos .owl-carousel').owlCarousel({ loop: false, margin: 0, nav: true, navText: ['<i class="fa fa-angle-left fa-fw fa-3x"></i>','<i class="fa fa-angle-right fa-fw fa-3x"></i>'], dots: false, autoplay: false, items: 1 });
                            });
                            </script>			
                        </div> 
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
                                <strong><?php echo $item->sho_name; ?></strong>
                            </div>
                            <div class="shomore">				
                                <a href="#" class="btn btn-default disabled">
                                    <i class="azicon16 icon-forward-right"></i>
                                </a>    
                            </div>
                        </div>	
                       
                        
                        
                        <div class="detail-content">   
                            <div class="rowtop">
                                <div class="dropdown">
                                    <div class="pull-right">
                                        <a href="#" id="dLabel1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="azicon16 <?php echo $classicon ?> icon-more"></i>
                                        </a>                                        
                                        <?php if ($this->session->userdata('sessionUser') == $item->sho_user) : ?> 
                                            <ul class="dropdown-menu" aria-labelledby="dLabel1" style="right: 0; left: 0;  border: 1px solid #eee">                                        
                                                <li>
                                                    <a href="javascript:void(0)" onclick="ghimtin(<?php echo $item->not_id ?>)">
                                                        <i class="azicon icon-tack"></i> &nbsp; Ghim tin lên đầu trang
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" onclick="antinnay(<?php echo $item->not_id ?>)">
                                                        <i class="azicon icon-hidden"></i> &nbsp; Ẩn tin này
                                                    </a>
                                                </li>
                                                <!--li>
                                                    <a target="blank" href="<?php echo $mainURL ?>account/news/edit/<?php echo $item->not_id ?>">
                                                        <i class="azicon icon-edit"></i> &nbsp; Chỉnh sửa tin
                                                    </a>
                                                </li-->                                                
                                            </ul>
                                            <?php
                                        else :
                                            ?>
                                            <ul class="dropdown-menu" aria-labelledby="dLabel1" style="right: 0; left: 0; border: 1px solid #eee">
                                                <li>
                                                    <a href="<?php echo $linkshop . '/shop'; ?>">
                                                        <i class="azicon icon-store"></i> &nbsp;
                                                        Đến gian hàng
                                                    </a>          
                                                </li>
                                                <?php if ($item->sho_mobile) { ?>
                                                    <li>
                                                        <a href="tel:<?php echo $item->sho_mobile ?>">
                                                            <i class="azicon icon-call"></i> &nbsp; Gọi cho gian hàng
                                                        </a>
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
                                                            <i class="azicon icon-comment"></i> &nbsp; Gửi tin nhắn
                                                        </a>
                                                    </li>
                                                    <?php
                                                } elseif ($item->sho_mobile) {
                                                    $messages = 'sms:' . $item->sho_mobile;
                                                    ?>
                                                    <li>
                                                        <a href="<?php echo $messages ?>">
                                                            <i class="azicon icon-comment"></i> &nbsp; Gửi tin nhắn
                                                        </a>
                                                    </li>
                                                <?php } ?> 
                                                <li>
                                                    <a href="#" class="report" data-id="<?php echo $item->not_id; ?>" data-link="<?php echo current_url(); ?>" data-toggle="modal" data-target="#reportModal">
                                                        <i class="azicon icon-report"></i> &nbsp; Gửi báo cáo
                                                    </a>
                                                </li>	
                                            </ul>
                                        <?php endif; ?> 
                                    </div>
                                    <div class="">                                     
                                        <i class="azicon16 <?php echo $classicon ?> icon-clock"></i>
                                        <span class="small">
                                            <?php echo date('d/m/Y', $item->not_begindate); ?>  
                                        </span> 
                                        &nbsp;
                                        <?php if ($this->session->userdata('sessionUser') == $item->sho_user) { ?>
                                            <a href="#" id="dLabel2" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="azicon16 <?php echo $classicon ?> icon-permission-<?php echo $item->not_permission ?>" 
                                                   data-toggle="tooltip" data-placement="top" title="<?php echo $item->not_permission_name ?>">
                                                </i>
                                            </a>                                    
                                            <ul class="permission dropdown-menu" aria-labelledby="dLabel2" style="left: 0px; right:0px;">
                                                <?php foreach ($permission as $key => $value) { if($key + 1 == 5) continue; ?>
                                                    <li class="<?php echo $item->not_permission == $value->id ? 'current' : '' ?>">
                                                        <a href="javascript:void(0)" onclick="setpermission(<?php echo $item->not_id . ',' . ($key + 1) ?>)">
                                                            <i class="azicon icon-permission-<?php echo $key + 1 ?>"></i>
                                                            <?php echo $value->name ?>
                                                        </a>
                                                    </li>
                                                <?php } ?>
                                            </ul>                                    
                                        <?php } else { ?>
                                            <i class="azicon16 <?php echo $classicon ?> icon-permission-<?php echo $item->not_permission ?>" 
                                               data-toggle="tooltip" data-placement="top" title="<?= $item->not_permission_name ?>">
                                            </i>                                        
                                        <?php } ?> 
                                    </div>
                                </div>
                            </div>
                            <div class="rowmid">								
                                <div class="r-title">
                                    <h2>
                                        <?php echo $item->not_title ?>
                                    </h2>
                                </div>
                                <div class="r-text">                                    
                                    <?php
                                    echo $s = preg_replace('/(?<!href="|">)(?<!src=\")((http|ftp)+(s)?:\/\/[^<>\s]+)/is', '<a class="text-primary" href="\\1" target="_blank">\\1</a>', $item->not_detail);
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
										<img class="pull-<?php echo $value->posi .' '. $classicon ?>" src="/images/icons/<?php echo $value->icon ?>" alt="icon"/>
										<div style="margin-<?php echo $value->posi ?>: 100px;">
											<h3><?php echo $value->title ?></h3>
											<p><?php echo $value->desc ?></p>
										</div>					
									<?php } else { ?>
										<div>
											<h3><?php echo $value->title ?></h3>
											<p><?php echo $value->desc ?></p>
										</div>
									<?php } ?>
								</div>			
							<?php } ?>
                            </div>    
                        </div>
						
                        

                        <div class="text-right small" style="padding: 0px 15px;"><?php echo $countcomments ?> bình luận &nbsp; <?php echo $item->chontin ?> lượt chọn tin</div>
                            
                        <div id="comments" class="rowcomment">
                            <div class="dropdown text-center" style="">                         
                                <span class="pull-none" style="display: inline-block; padding: 10px 10px;">
                                    <a class="" role="button" data-toggle="collapse" href="#viewcomments" aria-expanded="true" aria-controls="collapseExample" style="display: inline-block; padding: 10px 10px;">
                                        <i class="azicon icon-comment"></i>&nbsp;Bình luận
                                    </a>
                                </span>
                                <span class="pull-none" style="display: inline-block; padding: 10px 10px;">
                                    &nbsp;
                                </span>  
                                <?php if($item->not_permission == 1) { ?>
                                <span class="pull-none" style="display: inline-block; padding: 10px 10px;">
                                    <a href="#sharepage" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="display: inline-block; padding: 10px 10px;">
                                        <i class="azicon icon-share"></i>&nbsp;Chia sẻ
                                    </a>

                                    <?php $linkchiase = $linktoshop . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title); ?>

                                    <ul class="dropdown-menu" style="left: 0px; right:0px;">
                                        <li>
                                            <div class="social-share">													
                                                <a onclick="window.open('https://www.facebook.com/sharer/sharer.php?u=<?php echo $linkchiase . $suffix ?>&amp;app_id=<?php echo app_id ?>', 'facebook-share-dialog', 'width=600,height=450'); return false;"> <i class="azicon icon-facebook"></i> </a>                                               
                                                <a onclick="window.open('https://twitter.com/share?text=<?php echo $item_title ?>&amp;url=<?php echo $linkchiase . $suffix ?>', 'twitter-share-dialog', 'width=600,height=450'); return false;"> <i class="azicon icon-twitter"></i> </a>												
                                                <a onclick="window.open('https://plus.google.com/share?url=<?php echo $linkchiase . $suffix ?>', 'google-share-dialog', 'width=600,height=450'); return false;"> <i class="azicon icon-google"></i> </a> 												
                                                <a style="margin-right:15px;" class="pull-right" target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to=&su=<?php echo $item_title ?>&body=<?php echo $item_desc . ' - ' . $linkchiase . $suffix ?>&ui=2&tf=1" > <i class="azicon icon-email"></i> </a>						
                                            </div> 
                                        </li>
                                        <?php if ($item->chochontin == 1) { ?>
                                            <?php if ($item->dachon == 0) { ?>
                                                <li class="chontin"> <a href="javascript:void(0)" onclick="chontin(<?php echo $item->not_id ?>);"> <i class="azicon icon-square"></i> &nbsp;Chọn tin </a> </li>
                                            <?php } else { ?>
                                                <li class="bochontin"> <a href="javascript:void(0)" onclick="bochontin(<?php echo $item->not_id ?>);"> <i class="azicon icon-check-square"></i> &nbsp; Bỏ chọn tin </a> </li>
                                            <?php } ?>
                                        <?php } ?> 
                                        <li>
                                            <a href="javascript:void(0)" onclick="copylink('<?php echo $linkchiase . $suffix; ?>')">
                                                <i class="azicon icon-coppy"></i>  &nbsp;Sao chép liên kết</a>
                                        </li>                    
                                    </ul>
                                </span>   
                                <?php } ?> 
                            </div>
                        </div>

                        <div class="collapse" id="viewcomments" aria-expanded="false">	
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
                                                                    <input type="hidden" value="<?php echo $item->not_id; ?>" name="noc_content" />
								    <input type="hidden" value="<?php echo $item->not_user; ?>" name="item_user" />
								    <input type="hidden" value="<?php echo $item->not_title; ?>" name="item_title" />
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
                                                                            url: "/tintuc/comment",
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
                                                <div class="replycomment">
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
                                        <input type="hidden" value="<?php echo $item->not_id; ?>" name="noc_content" />
					<input type="hidden" value="<?php echo $item->not_user; ?>" name="item_user" />
					<input type="hidden" value="<?php echo $item->not_title; ?>" name="item_title" />
                                        <input type="hidden" value="0" name="noc_reply" />                                        
                                    </form>
                                <?php } else { ?> 

                                    <div class="small text-center" style="padding:15px; border:1px solid #eee; background: #fff;">
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
                                                    url: "/tintuc/comment",
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
                        </div>
                        <br>    		    
                        <?php if (count($listImg) > 0) { ?>
                            <div id="img_post_gallery">
                                <?php
                                foreach ($listImg as $key => $value) {
                                    $imgstyle = json_decode($value->style);
                                    switch ($imgstyle->display) {
                                        case 2: // màu nền
                                            $style = 'outline:1px solid #ddd; padding:0 0 10px; background:' . $imgstyle->background . '; color: ' . $imgstyle->color;
                                            $imagestyle = 'padding:50px 20px 30px;';
                                            $captionstyle = 'padding:0px 20px 20px; text-align: justify';
                                            $imgborder = 'border-radius:10px;';
                                            $iconstyle = 'white';
                                            break;
                                        case 1: // ảnh nền
                                            $style = 'outline:1px solid #ddd; padding:0 0 10px; background: url(' . DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $value->image . ') no-repeat center / cover; color: #fff; color: #ffffff';
                                            $imagestyle = 'padding:50px 20px 30px;';
                                            $captionstyle = 'padding:0px 20px 20px; text-align: justify';
                                            $imgborder = 'border-radius:10px;';
                                            $iconstyle = 'white';
                                            break;
                                        default:
                                            $style = 'outline:1px solid #ddd; padding:0 0 10px;background: #fff;';
                                            $imagestyle = 'padding:0px 0px 30px;';
                                            $captionstyle = 'padding:0px 20px 20px; text-align: justify';
                                            $imgborder = '';
                                            $iconstyle = 'black';
                                            break;
                                    }
                                    ?>		

                                    <div class="img_post img_post_<?php echo $imgstyle->display ?>" style="<?php echo $style ?>">
                                        <div class="<?php echo $imgstyle->imgeffect ?> wow" style="<?php echo $imagestyle ?>">
                                            <a class="item key_<?php echo $key ?>" href="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $value->image ?>" data-sub-html=".caption<?php echo $key ?>">
                                                <img style="<?php echo $imgborder ?>" class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $value->image ?>"  alt="<?php echo $value->product->pro_name ?>" />
                                            </a>
											<?php if($imgstyle->text_1_image != '' || $imgstyle->text_2_image != '' || $imgstyle->text_2_image != ''){ ?>
												<?php if($imgstyle->text_position == 'top') $pcss = 'position: absolute; left:0; right:0; top:0; text-shadow: 1px 1px #000; font-size: 150%;'; ?>
												<?php if($imgstyle->text_position == 'bottom') $pcss = 'position: absolute; left:0; right:0; bottom:0; text-shadow: 1px 1px #000; font-size: 150%;'; ?>
												<?php if($imgstyle->text_position == 'middle') $pcss = 'position: absolute; left:0; right:0; top: 50%; margin-top:-56px; text-shadow: 1px 1px #000; font-size: 150%;'; ?>
												<div style="<?php echo $pcss ?>">												
													<div style="vertical-align: <?php echo $imgstyle->text_position; ?>">
														<div style="background-color:<?php echo $imgstyle->rgba_color; ?>; color: <?php echo $imgstyle->text_color; ?>; font-family: '<?php echo $imgstyle->text_font; ?>';">																	
															<div class="textonimg<?php echo $key ?> owl-carousel text-center">
																<div style="padding:20px;"><?php echo $imgstyle->text_1_image; ?></div>
																<div style="padding:20px;"><?php echo $imgstyle->text_2_image; ?></div>
																<div style="padding:20px;"><?php echo $imgstyle->text_3_image; ?></div>
															</div>																	
														</div>                                                            
													</div>
													<script>
														$('.textonimg<?php echo $key ?>').owlCarousel({ animateOut: '<?php echo $imgstyle->text_effect_out; ?>', animateIn: '<?php echo $imgstyle->text_effect_in; ?>', loop: true, margin: 0, nav: false, dots: false, autoplay: true, autoplayTimeout:2500, items: 1 });
													</script>														
												</div>	
											<?php } ?>
                                        </div>
                                        <?php if ($value->caption != "" || $value->title != "") { ?>
                                            <div class="<?php echo $imgstyle->texteffect ?> wow" style="<?php echo $captionstyle ?>">					
                                                <div class="imgcaption">
                                                    <div style="margin-bottom: 10px; font-size: 18px;">
                                                        <h3><?php echo $value->title ?></h3>
                                                    </div>
                                                    <div class=""><?php echo nl2br($value->caption); ?></div>
                                                </div>
                                                <br>
                                            <br>
						<?php
						$caption2 = $imgstyle->caption2;
							foreach($caption2 as $c => $caption){ ?>
								<div class="wow <?php echo $caption->effect ?> boxicon text-<?php echo $caption->posi ?>" style="margin: 60px 0;">
									<?php if($caption->icon !=''){ ?>
										<img class="pull-<?php echo $caption->posi .' '. $iconstyle?>" src="/images/icons/<?php echo $caption->icon ?>" alt="icon"/>
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
                                        <?php } ?> 

                                        <div class="caption caption<?php echo $key ?>">    
                                            <ul class="menu-justified dropup small">
                                                <?php /* if ($this->session->userdata('sessionUser') == $item->sho_user && $value->product != '') : ?>
                                                  <li class="">
                                                  <a href="<?php echo base_url() . 'account/product/product/edit/' . $value->product->pro_id; ?>" target="_blank" style="color:<?php echo $iconstyle ?>">
                                                  <i class="azicon <?php echo $iconstyle ?> icon-edit"></i><br/>Chỉnh sửa
                                                  </a>
                                                  </li>
                                                  <?php endif; */ ?>
                                                <?php
                                                
                                                if ($value->product) {
                                                    $pro_type = ($value->product->pro_type == 0) ? 'product' : 'coupon';
                                                    $linktoproduct =  $domainshop . '/shop/' . $pro_type . '/detail/' . $value->product->pro_id . '/' . RemoveSign($value->product->pro_name) . $suffix;
                                                    ?>
                                                    <li class=""> 
                                                        <a href="<?php echo $linktoproduct ?>" target="_blank" style="color:<?php echo $iconstyle ?>">
                                                            <i class="azicon <?php echo $iconstyle ?> icon-eye"></i>
                                                            <br/>Chi tiết
                                                        </a>  
                                                    </li>

                                                    <li class="">
                                                        <a href="#" class="dropdown-toggle"  data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" style="color:<?php echo $iconstyle ?>">
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
                                                                    <a href="javascript:void(0)" onclick="window.open('https://twitter.com/share?text=<?php echo $value->product->pro_name ?>&amp;url=<?php echo $linktoproduct ?>', 'twitter-share-dialog', 'width=800,height=450');
                                                                                            return false;">
                                                                        <i class="azicon icon-twitter"></i>
                                                                    </a>
                                                                    <a href="javascript:void(0)" onclick="window.open('https://plus.google.com/share?url=<?php echo $linktoproduct ?>', 'google-share-dialog', 'width=800, height=450');
                                                                                            return false;">
                                                                        <i class="azicon icon-google"></i>
                                                                    </a>
                                                                    <a style="margin-right:15px;" class="pull-right" target="_blank" href="https://mail.google.com/mail/u/0/?view=cm&fs=1&to&su=<?php echo $value->product->pro_name ?>&body=<?php echo $linktoproduct ?>&ui=2&tf=1" >
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
                                                        <a href="<?php echo $value->detail ?>" style="color:<?php echo $iconstyle ?>">
                                                            <i class="azicon <?php echo $iconstyle ?> icon-more"></i>
                                                            <br/>Xem thêm
                                                        </a>
                                                    </li>
                                                <?php endif; ?>

                                            </ul>

                                        </div> 

                                    </div>

                                <?php } //endforeach  ?>
                            </div> 
                        <?php } //endif  ?>

                        <?php
                        $ad = json_decode($item->not_ad);
                        if ($ad->ad_image != "" && $ad->ad_status == 1) {
                            ?>                     
                            <?php if ($ad->ad_title1 == '' && $ad->ad_desc1 == '' && $ad->ad_time == '') { ?>
                                <div style="margin-bottom: 20px">
                                    <a href="<?php echo $ad->ad_link ?>">
                                        <img class="img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $ad->ad_image ?>"/>
                                    </a>
                                </div>
                            <?php } else { ?>
                                <div class="adbanner" style="background:url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $ad->ad_image ?>) no-repeat center / cover;">

                                    <?php if ($ad->ad_content) { ?>
                                        <div id="postad" class="owl-carousel">
                                            <?php foreach ($ad->ad_content as $key => $value) { ?>
                                                <div class="adtext text-center">                               
                                                    <h2 class="text-uppercase" style="margin-bottom:20px;"><?php echo $value->title ?></h2>                                
                                                    <p class="lead"><?php echo $value->desc ?></p>                                                              
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
                                                    <div class="textclock" class="text-center" style="visibility:hidden">azibai</div>						
                                                    <div class="countdown" class="text-center"></div>
                                                </section>
                                            </div>
                                        <?php } ?>  
                                    <?php } ?>
                                    <div style="position: relative; margin: 80px 0 0; text-align: center;">
                                        <a href="<?php echo $ad->ad_link ?>" target="_blank" class="btn_ad_link">Xem chi tiết</a>
                                    </div>
                                </div>

                                   
                                <script>
                                                                    jQuery(function ($) {
                                                                        $('.countdown,.countdown2').countdown('<?php echo $ad->ad_time ?>', function (event) {
                                                                            $(this).html(event.strftime('<span><strong>%D</strong><br>Ngày</span> <span><strong>%H</strong><br>Giờ</span> <span><strong>%M</strong><br>Phút</span> <span><strong>%S</strong><br>Giây</span>'));
                                                                        });

                                                                        if (!window.requestAnimationFrame) {
                                                                            window.requestAnimationFrame = window.mozRequestAnimationFrame ||
                                                                                    window.webkitRequestAnimationFrame ||
                                                                                    window.msRequestAnimationFrame ||
                                                                                    window.oRequestAnimationFrame ||
                                                                                    function (cb) {
                                                                                        setTimeout(cb, 1000 / 60);
                                                                                    };
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

                                                                            $s.css({"transform": "rotate(" + degS + "deg)"});
                                                                            $m.css({"transform": "rotate(" + degM + "deg)"});
                                                                            $h.css({"transform": "rotate(" + degH + "deg)"});

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
                                                                                    tickNum = $("<div class=\"tickNum\"></div>").text(n / 5).css({"transform": "rotate(-" + (n * 6) + "deg)"});
                                                                                    if (n >= 50) {
                                                                                        tickNum.css({"left": "-0.5em"});
                                                                                    }
                                                                                }


                                                                                tickBox.append(tick.addClass(tickClass)).css({"transform": "rotate(" + (n * 6) + "deg)"});
                                                                                tickBox.append(tickNum);

                                                                                $("#clock").append(tickBox);
                                                                            }
                                                                        }

                                                                        function setSize() {
                                                                            var b = $(this), //html, body
                                                                                    w = b.width(),
                                                                                    x = Math.floor(w / 30) - 1,
                                                                                    px = (x > 25 ? 26 : x) + "px";

                                                                            $("#clock").css({"font-size": px});

                                                                            if (b.width() !== 400) {
                                                                                setTimeout(function () {
                                                                                    $("._drag").hide();
                                                                                }, 500);
                                                                            }
                                                                        }

                                                                        $(document).ready(function () {
                                                                            setUpFace();
                                                                            computeTimePositions($h, $m, $s);
                                                                            $("section").on("resize", setSize).trigger("resize");
                                                                            /*$("section").resizable({handles: 'e'});*/
                                                                        });

                                                                    });
                                </script>			
                            <?php } ?>
                        <?php } ?>


                        <?php
                        if ($item->not_statistic == 1) {
                            if ($item->statistic != '') {
                                $statistic = json_decode($item->statistic);
                            }
                            ?>
                            <div id="post_statistic" class="post_statistic" style=" background:url(<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $item->img_statistic ?>) no-repeat center / cover;">
                                <div class="row text-center">
                                    <?php
                                    foreach ($statistic as $k => $value) {
                                        if ($k > 1 && $k % 2 == 1)
                                            echo '</div><div class="row text-center">';
                                        ?>
                                        <div class="col-xs-6">
                                            <p class="countnumber" style="font-size:48px;" data-count="<?php echo $value->num ?>">0</p>
                                            <p style="font-size:18px"><?php echo $value->title ?></p>
                                            <p style="font-size:14px"><?php echo $value->description ?></p>
                                            <br>
                                        </div>
                                    <?php } ?>                        
                                </div>
                            </div>
                            <script>
                                var a = 0;
                                $(window).scroll(function () {
                                    var oTop = $('#post_statistic').offset().top - window.innerHeight;
                                    if (a == 0 && $(window).scrollTop() > oTop) {
                                        $('.countnumber').each(function () {
                                            var $this = $(this), countTo = $this.attr('data-count');
                                            $({countNum: $this.text()}).animate({countNum: countTo}, {duration: 5000, easing: 'swing', step: function () {
                                                    $this.text(Math.floor(this.countNum));
                                                }, complete: function () {
                                                    $this.text(this.countNum);
                                                }});
                                        });
                                        a = 1;
                                    }
                                });
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
                                        <?php if($customer->cus_link) { ?>
                                        <a href="<?php echo $customer->cus_link ?>" target="_blank">
                                            <img class="img-responsive img-circle" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $customer->cus_avatar ?>" alt="<?php echo $customer->cus_text1 ?>">
                                        </a>
                                        <?php } else { ?>
                                            <img class="img-responsive img-circle" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $customer->cus_avatar ?>" alt="<?php echo $customer->cus_text1 ?>">
                                        <?php } ?>                                        
                                    </div>                                
                                    <h3><?php echo $customer->cus_text1 ?></h3>
                                    <p><strong><?php echo $customer->cus_text2 ?></strong></p>
                                    <p style="font-size:small; height: 76px; overflow: hidden;"><?php echo mb_substr($customer->cus_text3, 0, 150) ?>...</p>  
                                    <p style="margin-bottom:20px;"><button class="btn btn-sm btn-link" style="color: <?php echo $not_customer->cus_color ?>" data-toggle="modal" data-target="#modal_<?php echo $key ?>">Xem thêm</button></p>
                                    <?php if( $customer->cus_facebook ||  $customer->cus_facebook ||  $customer->cus_facebook ) { ?>
                                    <p>
                                        <?php if( $customer->cus_facebook ) { ?><a style="color: <?php echo $not_customer->cus_color ?>;border: 1px solid; border-radius: 50%; padding: 5px;" href="<?php echo $customer->cus_facebook ?>" target="_blank"><i class="fa fa-facebook fa-fw"></i></a><?php } ?>
                                        <?php if( $customer->cus_twitter ) { ?>&nbsp; <a style="color: <?php echo $not_customer->cus_color ?>;border: 1px solid; border-radius: 50%; padding: 5px;" href="<?php echo $customer->cus_twitter ?>" target="_blank"><i class="fa fa-twitter fa-fw"></i></a> &nbsp; <?php } ?>
                                        <?php if( $customer->cus_google ) { ?><a style="color: <?php echo $not_customer->cus_color ?>;border: 1px solid; border-radius: 50%; padding: 5px;" href="<?php echo $customer->cus_google ?>" target="_blank"><i class="fa fa-google-plus fa-fw"></i></a><?php } ?>
                                    </p>
                                    <?php } ?>
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
                                                <div style="width:200px; margin: 10px auto 20px;">
                                                    <a href="<?php echo ($customer->cus_link)?$customer->cus_link:'#customer' ?>" target="_blank">
                                                        <img class="img-responsive img-circle" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/' . $customer->cus_avatar ?>" alt="<?php echo $customer->cus_text1 ?>">
                                                    </a>
                                                </div>
                                                <p><strong><?php echo $customer->cus_text1 ?></strong></p>
                                                <p style="color:red"><?php echo $customer->cus_text2 ?></p>
                                                <?php if( $customer->cus_facebook ||  $customer->cus_twitter ||  $customer->cus_google ) { ?>
                                                <p>
                                                    <?php if( $customer->cus_facebook) { ?><a style="border: 1px solid; border-radius: 50%; padding: 5px 6px;" href="<?php echo $customer->cus_facebook ?>" target="_blank"><i class="fa fa-facebook fa-fw"></i></a><?php } ?>
                                                    <?php if( $customer->cus_twitter) { ?>&nbsp; <a style="border: 1px solid; border-radius: 50%; padding: 5px 6px;" href="<?php echo $customer->cus_twitter ?>" target="_blank"><i class="fa fa-twitter fa-fw"></i></a> &nbsp; <?php } ?>
                                                    <?php if( $customer->cus_google) { ?><a style="border: 1px solid; border-radius: 50%; padding: 5px 6px;" href="<?php echo $customer->cus_google ?>" target="_blank"><i class="fa fa-google-plus fa-fw"></i></a><?php } ?>
                                                </p>
                                                <?php } ?>
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

                        <?php if (count($listPro) > 0) { ?>
                            <div class="mod-Pro">
                                <div class="title">Sản phẩm:</div>		
                                <div id="listPro" class="owl-carousel text-center">
                                    <?php                                     
                                    foreach ($listPro as $k => $product) {
                                        if ($value->pro_type == 0) { $pro_type = 'product'; } elseif ($value->pro_type == 1) {$pro_type = 'service'; } else { $pro_type = 'coupon'; }
                                        $linktoproduct = $domainshop . '/shop/' . $pro_type . '/detail/' . $product->pro_id . '/' . RemoveSign($product->pro_name) . $suffix;
                                        ?>
                                        <div class="itempro" title="<?php echo $product->pro_name ?>" style="border:1px solid #eee; background: #fff; "> 
                                            <div class="fix1by1">
                                                <a class="c" href="<?php echo $linktoproduct ?>">
                                                    <img class="pro_image img-responsive" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/product/' . $product->pro_dir . '/' . show_image($product->pro_image); ?>"/>
                                                </a>
                                            </div>

                                            <div style="padding: 5px 10px; border-top:1px solid #eee; ">
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
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12"> 		

                <?php if (count($list_related) > 0) { ?> 
                    <div class="mod-items">  
                        <div class="title">Bài viết liên quan</div>
                        <?php foreach ($list_related as $key => $value) { ?>
                            <?php
                            $number = 10;
                            $content = str_replace("\n", "", strip_tags(preg_replace("/<img[^>]+\>/i", "", $value->not_title)));
                            $item_title = $content;
                            $array = explode(" ", $content);
                            if (count($array) <= $number) {
                                $item_title = $content;
                            } else {
                                array_splice($array, $number);
                                $item_title = implode(" ", $array) . " ...";
                            }
                            $itemlink = $domainshop . '/news/detail/' . $value->not_id . '/' . RemoveSign($value->not_title);
                            
                            $item_image = site_url('media/images/noimage.png');
                            if ($value->not_image != ''):
                                $item_image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/thumbnail_1_' . $value->not_image;
                            endif;
                            ?>
                            <div class="mod-item">
                                <div class="pull-left">
                                    <a href="<?php echo $itemlink ?>" title="<?php echo $item_title ?>">
                                        <img src="<?php echo $item_image ?>" style="width:120px; height:120px;" alt="<?php echo $value->not_title ?>"/>
                                    </a>
                                </div>
                                <div style="margin-left: 120px; padding: 0 10px;">
                                    <p class="item-title"><a title="<?php echo $value->not_title ?>" href="<?php echo $itemlink ?>" ><?php echo $item_title ?></a></p> 
                                    <div class="small text-muted">
                                        <?php echo date('d/m/Y', $value->not_begindate); ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php } ?>				
                    </div>
                <?php } ?>

                <?php if (count($list_views) > 0) { ?>		
                    <div class="mod-items">	
                        <div class="title">Bài viết xem nhiều</div>
                        <?php
                        foreach ($list_views as $key => $value) {
                            $number = 10;
                            $content = str_replace("\n", "", strip_tags(preg_replace("/<img[^>]+\>/i", "", $value->not_title)));
                            $item_title = $content;
                            $array = explode(" ", $content);
                            if (count($array) <= $number) {
                                $item_title = $content;
                            } else {
                                array_splice($array, $number);
                                $item_title = implode(" ", $array) . " ...";
                            }
                            $itemlink = $domainshop . '/news/detail/' . $value->not_id . '/' . RemoveSign($value->not_title);
                            $item_image = site_url('media/images/noimage.png');
                            if ($value->not_image != ''):
                                $item_image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $value->not_dir_image . '/thumbnail_1_' . $value->not_image;
                            endif;
                            ?>
                            <div class="mod-item">
                                <div class="pull-left">
                                    <a href="<?php echo $itemlink ?>" title="<?php echo $value->not_title ?>">
                                        <img src="<?php echo $item_image ?>" style="width:120px; height:120px;" alt="<?php echo $item_title ?>"/>
                                    </a>
                                </div>
                                <div style="margin-left: 120px; padding: 0 10px;">
                                    <p class="item-title"><a title="<?php echo $value->not_title ?>" href="<?php echo $itemlink ?>" ><?php echo $item_title ?></a></p> 
                                    <div class="small text-muted">
                                        <?php echo date('d/m/Y', $value->not_begindate); ?>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        <?php } ?>
                    </div>		    
                <?php } ?>
                <?php if (count($ds_tin_chon) > 0) { ?>
                    <div class="mod-items">
                        <div class="title">Danh sách tin theo dõi</div>
                        <ul class="list-unstyled dstinchon">
                            <?php
                            foreach ($ds_tin_chon as $item) :
                                $number = 10;
                                $content = str_replace("\n", "", strip_tags(preg_replace("/<img[^>]+\>/i", "", $item->not_title)));
                                $item_title = $content;
                                $array = explode(" ", $content);
                                if (count($array) <= $number) {
                                    $item_title = $content;
                                } else {
                                    array_splice($array, $number);
                                    $item_title = implode(" ", $array) . " ...";
                                }
                                if ($item->not_image != "") {
                                    $item_image = DOMAIN_CLOUDSERVER . 'media/images/content/' . $item->not_dir_image . '/thumbnail_1_' . $item->not_image;
                                } else {
                                    $item_image = 'media/images/noimage.png';
                                }

                                if ($item->domain) {
                                    $item_link = $protocol . $item->domain . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title);
                                } else {
                                    $item_link = $protocol . $item->sho_link . '.' . domain_site . '/news/detail/' . $item->not_id . '/' . RemoveSign($item->not_title);
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
                <?php } ?>

                <div class="fixtoscroll" >
                    <div style="border: 1px dashed #008c8c; height:600px; background: #f9f9f9; display: table-cell; width: 1%; vertical-align: middle; text-align: center;">
                        Liên hệ quảng cáo<br><span style="font-size: 24px"><?=settingPhone?></span><br>(300 x 600)
                    </div>                        
                </div>

            </div> 

            <div class="col-lg-2 hidden-md hidden-sm hidden-xs">  
                <?php $this->load->view('shop/common/adsright'); ?>
            </div>
        </div>

    </div>

<?php endif; ?>

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
        <a href="tel:<?php echo $siteGlobal->sho_mobile; ?>">	
            <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
                <div class="phonering-alo-ph-circle"></div>
                <div class="phonering-alo-ph-circle-fill"></div>            
                <div class="phonering-alo-ph-img-circle"></div>
            </div>
        </a>
    <?php } ?>
<?php } else { ?>    
    <?php if ($packId1 == true || $packId2 == true) { ?>
        <?php if ($packId1 == true) { //is Branch       ?>
            <a href="<?php echo $mainURL . 'register/affiliate/pid/' . $this->session->userdata('sessionUser'); ?>">
                <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
                    <div class="phonering-alo-ph-circle"></div>
                    <div class="phonering-alo-ph-circle-fill"></div>            
                    <div class="phonering-alo-ph-img-circle for-affiliate"></div>
                </div>    
            </a>
        <?php } else { ?> 
            <?php if ($packId2 == true) { ?>
                <a href="<?php echo $mainURL . 'register/affiliate/pid/' . $siteGlobal->sho_user; ?>">
                    <div class="phonering-alo-phone phonering-alo-green phonering-alo-show" id="phonering-alo-phoneIcon">
                        <div class="phonering-alo-ph-circle"></div>
                        <div class="phonering-alo-ph-circle-fill"></div>            
                        <div class="phonering-alo-ph-img-circle for-affiliate"></div>
                    </div>
                </a>
            <?php } ?>
        <?php } ?>
    <?php } ?>
<?php } ?>
<script src="/templates/home/js/jquery.countdown.min.js"></script>
<script>


    function copylink(link) {
        clipboard.copy(link);
    }
    jQuery(function ($) {
<?php if ($isMobile == 1) { ?>
            $(window).scroll(function () {
                var scroll = $(window).scrollTop();
                if (scroll >= $(window).height() / 4) {
                    $('#header').fadeIn();
                } else {
                    $('#header').fadeOut();
                }
            });
            /*var h = $(window).height() - $('.detail-banner').height();
            $('.detail-banner').next().css("height", h);*/
            $('.scrollview').click(function (e) {
                e.preventDefault();
                $('html,body').animate({scrollTop: $('#brand').offset().top - 40}, 'slow');
            });
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

        $('.lg-sub-html ul.menu-justified').removeClass('dropdown').addClass('dropup');
        $('.lg-sub-html ul.menu-justified > li > a > .azicon').css('filter', 'invert(100%)');

        var clickvolume = 0;
        $(".az-volume").click(function () {
            if (clickvolume == 0) {
                $('.az-volume').attr("src", "/templates/home/icons/icon-volume-on.png");
                $('#audio<?php echo $item->not_id ?>').trigger("play");
                clickvolume = 1;
            } else {
                $('.az-volume').attr("src", "/templates/home/icons/icon-volume-off.png");
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
                    $('.az-volume').attr("src", "/templates/home/icons/icon-volume-off.png");
                    $('#audio<?php echo $item->not_id ?>').trigger("pause");
                }
            });
        }
        $(document).on('scroll', checkMedia);
        $('#listPro').owlCarousel({margin: 20, nav: true, dots: false, responsive: {0: {items: 2}, 600: {items: 3}}});
        $('[data-countdown]').each(function() { var $this = $(this), finalDate = $(this).data('countdown'); $this.countdown(finalDate, function(event) { $this.html(event.strftime('%D ngày %H:%M:%S')); }); });
        $('#customer').owlCarousel({ loop: false, margin: 20, nav: false, dots: true, responsive: {0: {items: 1}, 600: {items: 2}} });
        $('#img_post_gallery').lightGallery({selector: '.item', download: false});
        $('#postad').owlCarousel({ animateOut: 'fadeOutDown', animateIn: 'zoomIn', items: 1, loop: true, margin: 0, nav: false, dots: false, autoplay: true, autoplayTimeout: 1500, autoplayHoverPause: true });
        new WOW().init();
    });
</script>
<?php $this->load->view('shop/news/footer-old'); ?>


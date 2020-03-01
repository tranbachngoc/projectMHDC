<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN""http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <link rel="shortcut icon" href="/templates/home/images/favicon.png" type="image/x-icon"/>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="description" content="<?php echo $descrSiteGlobal ? $descrSiteGlobal : settingDescr; ?>"/>
        <meta name="keywords" content="<?php echo $keywordSiteGlobal ? str_replace(',', ' |', $keywordSiteGlobal) : settingKeyword; ?>"/>
        <meta property="og:url" content="<?php echo $ogurl; ?>" />
        <meta property="og:type" content="<?php echo $ogtype; ?>" />
        <meta property="og:title" content="<?php echo $ogtitle; ?>" />
        <meta property="og:description" content="<?php echo $ogdescription ? $ogdescription : settingDescr; ?>" />
        <meta property="og:image" content="<?php echo $ogimage ? $ogimage : '/templates/home/images/logoshare.jpg'; ?>" /> 
        <title>Azibai Group</title>
        <link type="text/css" rel="stylesheet" href="/templates/home/css/libraries.css"/>	
        <link type="text/css" rel="stylesheet" href="/templates/group/css/group-news.css"/> 
	
        <script type="text/javascript" language="javascript" src="/templates/home/js/jquery.min.js"></script>
        <script type="text/javascript" language="javascript" src="/templates/home/js/bootstrap.min.js"></script>
        <script type="text/javascript" language="javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery.touchswipe/1.6.4/jquery.touchSwipe.min.js"></script>
        <script type="text/javascript" language="javascript" src="/templates/group/js/general.js"></script>
        <!--<script type="text/javascript" language="javascript" src="/templates/group/js/holder.js"></script>-->
        <link type="text/css" rel="stylesheet" href="/templates/home/js/jAlert-master/jAlert-v3.css"/>
        <script type="text/javascript" language="javascript" src="/templates/home/js/jAlert-master/jAlert-v3.min.js"></script>
        <script language="javascript" src="/templates/home/js/check_email.js"></script>
        <script src="/templates/home/js/select2.full.min.js"></script>
        <script src="/templates/home/js/lang/vi.js"></script>
        <script language="javascript" type="text/javascript">
            var siteUrl = '/';
        </script>
    </head>

    <body>
        <div id="all">
            <div id="header">
                <div class="popupright" id="notification">
		    <div class="container">
			<div style="background: #ffffff; padding: 5px 10px; border-bottom: 1px solid #eee">
			    <a class="closepopup"><i class="fa fa-times-circle "></i></a>
			    <!--<a class="readall" href="#readall">Đã đọc tất cả</a>-->	
			    <strong>Thông báo</strong> 
			</div>
			<div id="list_notification">
			    <div style="background: #fafafa; height: calc(100vh - 90px); overflow: auto; direction: rtl;">
				
				<ol class="list-unstyled small" style="direction: ltr;">
				    <?php 
				    if($listNotifications){
					foreach ($listNotifications as $key => $value) {
					    switch($value->actionType){
						case 'key_new_invite':
						    $meta = json_decode($value->meta); ?>
						    <li class="notification_<?php echo $value->id ?>">						    
							<img class="img-circle pull-left" style="width:60px;" src="<?php echo DOMAIN_CLOUDSERVER . 'media/images/avatar/' . $value->avatar ?>" alt="avatar"/>
                                                        <div style="margin-left: 65px;">
                                                            <div>Thành viên <strong><?php echo $value->use_fullname ?></strong> đã mời bạn tham gia và nhóm <strong><?php echo $value->grt_name ?></strong></div>
                                                            <p>
                                                                <button type="button" class="btn btn-xs btn-primary" onclick="replyInvite(1,<?php echo $this->session->userdata('sessionUser') ?>,<?php echo $meta->grt_id; ?>,'<?php echo $value->id ?>')">Tham gia</button>
                                                                <button type="button" class="btn btn-xs btn-default" onclick="replyInvite(0,<?php echo $this->session->userdata('sessionUser') ?>,<?php echo $meta->grt_id; ?>,'<?php echo $value->id ?>')">Không tham gia</button>
                                                            </p>
                                                        </div>
                                                    </li>
						    <?php
						    break;
						case 'key_new_branch_user': ?>
						    <li class="notification_<?php echo $key ?>">
							<h4><?php echo $value->title ?></h4>
							
						    </li>
						    <?php
						    break;
						case 'key_new_affiliate_user': ?>
						    <li class="notification_<?php echo $key ?>">
							<h4><?php echo $value->title ?></h4>
							
						    </li>
						    <?php
						    break;
						case 'key_affiliate_select_buy_product': ?>
						    <li class="notification_<?php echo $key ?>">
							<h4><?php echo $value->title ?></h4>
							
						    </li>
						    <?php
						    break;
						case 'key_affiliate_remove_select_buy_product': ?>
						    <li class="notification_<?php echo $key ?>">
							
						    </li>
						    <?php
						    break;
						case 'key_new_comment': ?>
						    <!--li class="notification_<?php echo $key ?>">
							<div class="dropdown pull-right">
							    <a class="dropdown-toggle" 
							       id="dropdownNotification<?php echo $key ?>" 
							       href="#"
							       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<span style="font-size:20px">&hellip;</span>
							    </a>
							    <ul class="dropdown-menu" aria-labelledby="dropdownNotification<?php echo $key ?>">
								<li><a href="#">Ẩn thông báo</a></li>
								<li><a href="#">Đánh dấu đã đọc</a></li>
								<li><a href="#">Tắt thông báo</a></li>	
							    </ul>
							</div>
							<div style="margin-right:20px;">
							    <?php $meta = json_decode($value->meta);?>
							    <a href="<?php echo '/tintuc/detail/'.$meta->noc_content.'/'.$meta->noc_title.'/#comments'?>" onclick="readNotification(<?php echo $value->id ?>)">
								<img class="img-circle" src="<?php echo DOMAIN_CLOUDSERVER.'media/images/avatar/'.$value->avatar ?>" alt="avatar" style="width:50px; height:50px; float:left; margin-right: 10px;">
							        <?php echo $value->body ?>
							    </a>						    
							</div>
						    </li-->
						    <?php
						    break;
						case 'key_cty_create_news': ?>
						    <li class="notification_<?php echo $key ?>">
							<h4><?php echo $value->title ?></h4>
							
						    </li>
						    <?php
						    break;
						case 'key_new_order': ?>
						    <li class="notification_<?php echo $key ?>">
							<h4><?php echo $value->title ?></h4>
							
						    </li>
						    <?php
						    break;
						case 'key_status_order': ?>
						    <li class="notification_<?php echo $key ?>">
							<h4><?php echo $value->title ?></h4>
							
						    </li>
						    <?php
						    break;
					    } ?>
					    
<!--					    <li>
						<div class="dropdown pull-right">
						    <a class="dropdown-toggle" 
						       id="dropdownNotification<?php echo $key ?>" 
						       href="#"
						       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<span style="font-size:20px">&hellip;</span>
						    </a>
						    <ul class="dropdown-menu" aria-labelledby="dropdownNotification<?php echo $key ?>">
							<li><a href="#">Ẩn thông báo</a></li>
							<li><a href="#">Đánh dấu đã đọc</a></li>
							<li><a href="#">Tắt tất cả thông báo từ người này</a></li>	
						    </ul>
						</div>						
					    </li> -->
					<?php } //endforeach
				    } else { ?>
					<li>
					    <div style="margin-right:22px">Bạn chưa có thông báo nào</div>
					</li>
				    <?php } ?>		    
				</ol>
			    </div>
			</div>
		    </div>
		</div>
                <div class="header-news">
		    <div class="container-fluid">
                        <div class="row">                    
                            <div class="col-lg-2 col-md-3 col-sm-3 text-center">
                                <a href="/">
                                    <img style="max-height: 34px;" class="" src="/images/logo-azibai-white.png">
                                </a>
                            </div>                            
                            <div class="col-lg-5 col-md-4 col-sm-4">

                            </div>
                            <div class="col-lg-5 col-md-5 col-sm-5">
                                <div class="pull-left">
                                    <?php if ($this->session->userdata('sessionUser')) { ?>
                                        <div class="pull-left">
                                            <a class="username" href="/account"> 
                                                <?php if ($this->session->userdata('sessionAvatar')) { ?>
                                                    <img class="img-circle" src="<?php echo DOMAIN_CLOUDSERVER. 'media/images/avatar/' . $this->session->userdata('sessionAvatar'); ?>"  style="width:34px; height:34px; margin-right: 10px; "/>
                                                <?php } else { ?>
                                                    <img class="img-circle" src="<?php echo '/media/images/avatar/default-avatar.png'; ?>"  style="width:34px; height:34px; margin-right: 10px;"/>
                                                <?php } ?>    
                                                <?php echo $this->session->userdata('sessionUsername'); ?>
                                            </a>
                                        </div>                
                                    <?php } ?>
                                </div> 

                                <ul class="menu-top-right pull-right">                
                                    <li class="">
                                        <a href="/shop/products" title="Mua sắm" id="quick_view">
                                            <i class="azicon icon-store white"></i>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/checkout" title="Xem giỏ hàng">
                                            <i class="azicon icon-cart white"></i>
                                            <span class="cartNum"><?php echo $azitab['cart_num']; ?></span>
                                        </a>
                                    </li>
                                    
				    <li>	
                                        <a  title="Thông báo" href="#notification">   				    
                                            <i class="azicon icon-notification white"></i>
                                            <span class="notification"><?php echo count($listNotifications); ?></span>
                                        </a>				    
                                    </li>
                                    
                                    <?php if ($this->session->userdata('sessionUser')) { ?>
                                        <li class="dropdown pull-right">
                                            <a id="dLabel" data-target="#" href="#" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                                <i class="azicon icon-bars white"></i>
                                            </a>                                    
                                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                                <li>
                                                    <a href="<?php echo site_url('account/edit') ?>" title="Tài khoản">
                                                        <i class="azicon icon-user"></i>&nbsp; Thông tin cá nhân                     
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="<?php echo site_url('account') ?>" title="Quản trị">
                                                        <i class="azicon icon-dashboard"></i>&nbsp; Quản trị                 
                                                    </a>
                                                </li>
                                               
                                                <li>
                                                    <a href="<?php echo site_url('grouptrade') ?>" title="Quản trị">
                                                        <i class="azicon icon-group"></i>&nbsp; Quản trị nhóm               
                                                    </a>
                                                </li>                                               

                                                <li>
                                                    <a href="/logout" title="Đăng xuất">
                                                        <i class="azicon icon-logout"></i>&nbsp; Đăng xuất                        
                                                    </a>
                                                </li>
                                                
                                            </ul>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>          
		    </div>
                </div>                		
            </div>
            
            <style>
                .popupright {
                    position: fixed;
                    top: 54px;
                    bottom: 0;
                    right: 0px;
                    background: #fff;
                    border: 1px solid #ddd;
                    z-index: 10000;
                    display: none;
                }
                .popupright .container {
                    width: 320px;
                    padding: 0;
                }
                #list_notification ol>li {
                    direction: ltr;
                    padding: 10px 10px 10px 15px;
                }
                #list_notification ol>li p { margin: 10px 0}
            </style>
            <script>
                jQuery(function ($) {
                    $('[href="#notification"]').click(function () {		    
                        $('#notification').toggle('fast');
                    });
                });            			
		function replyInvite(reply,uid,grt,id_notification) {
		    var n = parseInt($('.notification').html());
		    var mes = '';
		    $.ajax({
			type: "POST",
			url: "/grouptrade/repinvite",
			data: {reply:reply, uid:uid, grt:grt, id_notification: id_notification},
			success: function (res) {			    
			    if(res == 0) {
				mes = 'Bạn không đồng ý tham gia nhóm.';
                                
			    } else {
				mes = 'Bạn đã đồng ý tham gia nhóm.';
			    }
			    $.jAlert({
				'title': 'Thông báo',
				'content': mes,
				'theme': 'green',
				'btns': {
				     'text': 'Ok', 'theme': 'green', 'onClick': function (e, btn) {
					 e.preventDefault();
					 return false;
				     }
				}
			    });			    
			    $('.notification_'+id_notification).remove();
			    $('.notification').html(n-1);			    
			},
			error: function () {
			    alert('Có lỗi xảy ra. Vui lòng thử lại!');
			}
		    });
		}
	    </script>
            
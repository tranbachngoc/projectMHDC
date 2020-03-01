<?php $this->load->view('group/common/header'); ?>

<style>
    .menu-filter-group li a { background: #ddd;}
    .menu-filter-group li a:hover,.menu-filter-group li a:focus { color: #fff; background-color: #337ab7;}
</style>
<br>
<div id="main" class="container">
    <div class="row">
        <div class="col-xs-12">				
            <div style="text-align: center; white-space: nowrap; overflow: auto;">
                <ul class="nav nav-pills menu-filter-group" style="display: inline-block;">
                    <li role="presentation" class="<?php echo (isset($type) && $type == 0) ? 'active' : ''; ?>"><a href="/grouptrade" title="Tất cả các nhóm"> <span>Tất cả</span> </a></li>
                    <li role="presentation" class="<?php echo (isset($type) && $type == 1) ? 'active' : '' ?>"><a href="<?php echo getAliasDomain() .'grouptrade/type/1'; ?>" title="Nhóm miễn phí"> <span>Nhóm miễn phí</span> </a></li>
                    <li role="presentation" class="<?php echo (isset($type) && $type == 2) ? 'active' : '' ?>"><a href="<?php echo getAliasDomain() .'grouptrade/type/2'; ?>" title="Nhóm trả phí"> <span>Nhóm trả phí</span> </a></li>
                    <li role="presentation" class="<?php echo (isset($type) && $type == 3) ? 'active' : '' ?>"><a href="<?php echo getAliasDomain() .'grouptrade/type/3'; ?>" title="Nhóm thuê kênh"> <span>Nhóm thuê kênh</span> </a></li>
                    <li role="presentation" class="<?php echo (isset($type) && $type == 4) ? 'active' : '' ?>"><a href="<?php echo getAliasDomain() .'grouptrade/type/4'; ?>" title="Trả phí cả hai"> <span>Trả phí cả hai</span> </a></li>
                </ul>
            </div>					
        </div>
    </div>
	<br/>
	<div class="row">
		<div class="col-xs-12">	
			<div class="panel panel-default">
				<div class="panel-heading">
					Nhóm của tôi
				</div>
				<div class="panel-body">
					<?php if(count($list_my_grt) > 0) { ?>				
					<div class="row">

						<?php foreach($list_my_grt as $key => $value) { ?>
						<?php 
							$link_logo = '/images/community.png';
							if($value->grt_logo != '' && file_exists('media/group/logos/'. $value->grt_dir_logo .'/'. $value->grt_logo)){
								$link_logo = '/media/group/logos/'. $value->grt_dir_logo .'/'. $value->grt_logo;
							}
						 ?>
						<div class="col-xs-4 col-sm-3 col-md-2" style="padding:15px;">
							<a href="<?php echo getAliasDomain() .'grouptrade/'. $value->grt_id .'/default'; ?>" title="Đến trang quản trị nhóm">
								<div style="width:80px; margin:0 auto;">
									<div class="fix1by1">
										<div class="c img-circle" style="border: 1px solid #eee; background:url('<?php echo $link_logo; ?>') no-repeat center / 100% auto;"></div>
									</div>
								</div>
								<div class="text-center" style="text-overflow: ellipsis; margin-top: 5px;  overflow: hidden; white-space: nowrap;"><?php echo ($value->grt_name != '') ? $value->grt_name : 'Chưa cập nhật nhóm'; ?></div>
							</a>
						</div>
						<?php } ?>
						
					</div>
					<?php } else { ?>
						<div class="row">
							<div style="padding: 10px;">
								<?php if ((int)$this->session->userdata('sessionUser') == 3) { ?>
									<span>Bạn chưa có nhóm thương mại nào. Hãy <strong><a href="<?php echo getAliasDomain(). 'grouptrade/add'; ?>">vào đây<a></strong> để đăng ký</span>
								<?php } else { ?>
									<span>Gian hàng của bạn chưa có nhóm thương mại nào.</span>
								<?php } ?>								
							</div>
						</div>
					<?php } ?>
				</div>
			</div>		
		</div>

		<div class="col-xs-12">	
			<div class="panel panel-default">
				<div class="panel-heading">
					Nhóm tham gia
				</div>
				
				<div class="panel-body">
					<?php if(count($list_i_join) > 0) { ?>
					<div class="row">						
						<?php foreach($list_i_join as $key => $value) { ?>
						<?php 
                                                    if($value->grt_link == '' && $value->grt_domain == ''){
                                                        $link_grt = '#';
                                                    }else{
                                                        $link_grt = 'http://' . $value->grt_link .'.'. $domainName . '/grtshop'; //$protocol
                                                        if($value->grt_domain != ''){
                                                            $link_grt = 'http://' . $value->grt_domain;
                                                        }
                                                    }
                                                    $link_logo_join = '/images/community_join.png';
                                                    if($value->grt_logo != '' && file_exists('media/group/logos/'. $value->grt_dir_logo .'/'. $value->grt_logo)){
                                                            $link_logo_join = '/media/group/logos/'. $value->grt_dir_logo .'/'. $value->grt_logo;
                                                    }
						 ?>
						<div class="col-xs-4 col-sm-3 col-md-2" style="padding:15px;" title="<?php echo $value->grt_name ?>">
                                                    <?php if($link_grt != '#'){ ?>
							<a href="<?php echo $link_grt; ?>" target="_blank">
                                                    <?php } ?>
                                                            <div style="width:80px; margin:0 auto;">
                                                                <div class="fix1by1">
                                                                    <div class="c img-circle" style="border: 1px solid #eee; background:url('<?php echo $link_logo_join; ?>') no-repeat center /  100% auto;"></div>
                                                                </div>
                                                            </div>
                                                            <div class="text-center" style="text-overflow: ellipsis; margin-top: 5px; overflow: hidden; white-space: nowrap;"><?php echo ($value->grt_name != '') ? $value->grt_name : 'Chưa cập nhật nhóm'; ?></div>
                                                    <?php if($link_grt != '#'){ ?>
                                                        </a>
                                                    <?php } ?>
						</div>

						<?php } ?>

					</div>
					<?php } else { ?>
						<div class="row">
							<div class="" style="padding: 10px;">
								<span>Bạn chưa tham gia nhóm thương mại nào...</span>
							</div>
						</div>
					<?php } ?>

				</div>
			</div>		
		</div>
	</div>
</div>
<?php $this->load->view('group/common/footer'); ?>
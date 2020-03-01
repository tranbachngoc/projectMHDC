<div class="container">
	<div class="administrator-bussinesspost">
	  <h2 class="tit"><a href="<?php echo base_url() .'azi-admin/notifications/list-user' ?>">Thành viên</a></h2>
	  <form method="GET" action="<?php echo base_url() .'azi-admin/notifications/list-user' ?>">
	  	<div class="search">	  	
		    <div class="search-input">
		      <img src="/templates/home/styles/images/svg/search.svg" alt="">
		      <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa" value="<?php echo ($_REQUEST['search']) ? $_REQUEST['search'] : ''  ?>">
		    </div>
		    <div class="search-category">
		      <select name="search_user" class="form-control">
		        <option value="1" <?php echo ($_REQUEST['search_user'] && $_REQUEST['search_user'] == 1) ? 'selected' : ''  ?> >Số điện thoại</option>
		        <option value="0" <?php echo ($_REQUEST['status'] != '' && $_REQUEST['search_user'] == 0) ? 'selected' : ''  ?>>Họ tên</option>
		        <option value="2" <?php echo ($_REQUEST['search_user'] && $_REQUEST['search_user'] == 2) ? 'selected' : ''  ?>>Tài khoản</option>
		      </select>
		    </div>
		    <div class="search-state">
		    	<?php $search_state = $_REQUEST['status']; ?>
		      <select name="status" id="" class="form-control">
		        <option value="">-- Tìm theo trạng thái --</option>
		        <option value="1" <?php echo ($_REQUEST['status'] && $_REQUEST['status'] == 1) ? 'selected' : ''  ?> >Kích hoạt</option>
		        <option value="0" <?php echo ($_REQUEST['status'] != '' && $_REQUEST['status'] == '0') ? 'selected' : ''  ?>>Tắt kích hoạt</option>
		      </select>
		    </div>

		    <div class="search-category">
		    	<?php $search_state = $_REQUEST['status']; ?>
		      <select name="status_block" id="" class="form-control">
		        <option value="">-- Tìm theo chặn --</option>
		        <option value="1" <?php echo ($_REQUEST['status_block'] && $_REQUEST['status_block'] == 1) ? 'selected' : ''  ?>>Không bị chặn</option>
		        <option value="0" <?php echo ($_REQUEST['status_block'] != '' && $_REQUEST['status_block'] == 0) ? 'selected' : ''  ?>>Đang bị chặn</option>
		      </select>
		    </div>
			<?php
			$date_from = 'register_date_from';
			$date_to = 'register_date_to';
			$val_date_from = '';
			$val_date_to = '';

			if(isset($_REQUEST['register_date_from']) || isset($_REQUEST['register_date_to']))
			{
				$val_date_from = $_REQUEST['register_date_from'];
				$val_date_to = $_REQUEST['register_date_to'];
			}

			if(isset($_REQUEST['lasted_login_date_from']) || isset($_REQUEST['lasted_login_date_to']))
			{
				$date_from = 'lasted_login_date_from';
				$date_to = 'lasted_login_date_to';
				$val_date_from = $_REQUEST['lasted_login_date_from'];
				$val_date_to = $_REQUEST['lasted_login_date_to'];
			}
			?>
		    <div class="search-state">
		    	<?php $search_state = $_REQUEST['status']; ?>
		      <select name="" id="" class="form-control date">
		        <option value="1" <?php echo ($_REQUEST['register_date_from'] || $_REQUEST['register_date_to']) ? 'selected' : ''  ?>>Ngày đăng ký</option>
		        <option value="2" <?php echo ($_REQUEST['lasted_login_date_from'] || $_REQUEST['lasted_login_date_to']) ? 'selected' : ''  ?>>Ngày đăng nhập</option>
		      </select>
		    </div>
          	<!-- <p class="txt">Từ</p> -->
			<div class="search-date">
              <div class="from">
                <input type="text" name="<?= $date_from?>" value="<?=$val_date_from?>"  class="datepicker form-control date_from" placeholder="ngày đăng ký">
              </div>
              <p class="txt">Đến</p>
              <div class="to">
                <input type="text" name="<?= $date_to?>" value="<?=$val_date_to?>"  class="datepicker form-control date_to" placeholder="ngày đăng ký">
              </div>
            </div>
		    <button type="submit" class="btn-search cursor-pointer">Tìm kiếm</button>
	    </div>
	  </form>
	  <div class="bussinesspost-table">
	  	<?php
	  	if (!empty($result['msg']['data']))
	  	{
  		?>
		    <table>
		      <tr class="sm-none">
		        <th>Stt</th>
		        <th>User</th>
		        <th>Giới thiệu</th>
		        <th width="250">Họ tên</th>
		        <th>Id user</th>
		        <th>Trạng thái</th>
		        <th>Ngày đăng ký</th>
		        <th>Ngày đăng nhập</th>
		        <th>Cấu hình</th>
		      </tr>
			  <?php //if (!empty($result['data']['data'])) { ?>
					<?php foreach ($result['msg']['data'] as $key => $value)
					{
						$prf_page = base_url().'profile/'.$value['use_id'];
						if($value['website'] != ''){
							$prf_page = 'http://'.$value['website'];
						}
						$shop_page = '';
						if(!empty($value['shop'])){
							if($value['shop']['domain'] != ''){
								$shop_page = 'http://'.$value['shop']['domain'];
							}else{
								if($value['shop']['sho_link'] != ''){
									$shop_page = 'http://'.$value['shop']['sho_link'].'.'.domain_site;
								}
							}
						}
						?>
					<tr>
						<td class="sm-none"><?php echo ++$key+$stt; ?></td>
				        <td class="title text-left">
				          <div class="text">
				          	<a href="<?php echo $prf_page ?>" target="_blank">
				          		<?php echo $value['use_username']; ?>
				          	</a>
				          </div>
				          <div class="sm">
		                    <div class="small-txt">
		                      <span><?php echo $value['use_fullname']; ?></span>
		                      <span><?php echo date('d/m/Y', $value['use_regisdate']); ?></span>
		                    </div>
		                    <div class="small-btn">
		                      	<?php 
					        	if ($value['use_status'] == 1) 
					        	{
					        		echo '<button class="btn js-active-news" data-id="0"><img src="/templates/home/styles/images/svg/check_pink.svg" alt=""> Kích hoạt</button>';
					        	} 
					        	else 
					        	{
					        		echo '<button class="btn change-status cursor-pointer js-active-news" data-id="'.$value['use_id'].'"><img class="js-active-user" src="/templates/home/styles/images/svg/close_gray.svg" alt=""> Kích hoạt</button>';
					        	}
				        		?>
		                      <button class="btn bg-gray js-popup-user" data-target="#modal-popup-user" data-toggle="modal" data-id="<?php echo $value['use_id']; ?>" data-page_prf="<?php echo $prf_page ?>" data-page_shop="<?php echo $shop_page ?>"><img src="/templates/home/styles/images/svg/settings_white.svg" class="mr05" alt="">Cài đặt</button>

		                    </div>
		                    <?php if ($value['is_show_on_homepage'] == 0) { ?>
		                    	<div class="is-block-<?php echo $value['use_id']; ?>"></div>
		                    <?php } ?>
		                  </div>
				        </td>
				        <td class="sm-none text-left"><?php echo ($value['get_presenter']['use_username'] != '') ? $value['get_presenter']['use_username'] : ' - '; ?></td>
				        <td class="sm-none text-left"><?php echo $value['use_fullname']; ?></td>
						<td class="id sm-none"><?php echo $value['use_id']; ?></td>
				        <td class="sm-none">
				        	<?php 
				        	if ($value['use_status'] == 1) 
				        	{
				        		echo '<a class="js-active-user" data-id="0"><img src="/templates/home/styles/images/svg/check_pink.svg" alt=""></a>';
				        	} 
				        	else 
				        	{
				        		echo '<a class="change-status cursor-pointer js-active-news" data-id="'.$value['use_id'].'"><img class="js-active-user" data-id="1" src="/templates/home/styles/images/svg/close_gray.svg" alt=""></a>';
				        		echo '<div class="no-status-'.$value['use_id'].'"></div>';
				        	}
				        	?>
				        </td>
				        <td class="sm-none"><?php echo date('d/m/Y', $value['use_regisdate']); ?></td>
				        <td class="sm-none"><?php echo date('d/m/Y', $value['use_lastest_login']); ?></td>
				        <td class="sm-none">
				        	<?php if ($value['use_status'] == 1) { ?>
				        	<p class="setting cursor-pointer js-popup-user" data-target="#modal-popup-user" data-toggle="modal" data-id="<?php echo $value['use_id']; ?>" data-page_prf="<?php echo $prf_page ?>" data-page_shop="<?php echo $shop_page ?>"> Cài đặt</p>
				        	<?php } else { ?>
				        	<img data-toggle="tooltip" data-placement="top" title="Tài khoản chưa được kích hoạt" src="/templates/home/styles/images/svg/infor_gray.svg" class="mr05" alt="">
				        	<?php } ?>
				        </td>
			        </tr>	
			 		<?php } ?>
			  <?php //} ?>
		    </table>
	    <?php
		}
		else{
			echo '<p class="noti">Không tìm thấy dữ liệu</p>';
		}
		?>
	  </div>

	  <?php echo $pagination ? $pagination : ''; ?>
	</div>        
</div>

<?php $this->load->view('azi-admin/notifications/element/pop-notification'); ?>

<div class="modal" id="modal-popup-user" data-backdrop="static">
  <div class="modal-dialog modal-dialog-center modal-mess">
        <div class="modal-content">
        
          <!-- Modal Header -->
          <div class="modal-header">
          	<p class="title"><b></b></p>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          
          <!-- Modal body -->
          <div class="modal-body">
            
          </div>
          
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
</div>

<script type="text/template" id="temp_popup_user">
	<ul class="show-more-detail js-pop-user" data-id="">
		<li class="page-profile cursor-pointer"><a href="#" target="_blank">Xem trang cá nhân</a></li>
		<li class="page-shop" style="display: none"></li>
		<li class="change-status cursor-pointer">Tắt kích hoạt</li>
		<li class="block-news cursor-pointer">Chặn bài viết</li>
	</ul>
</script>

<script type="text/javascript">
	
</script>
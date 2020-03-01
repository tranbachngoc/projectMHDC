<div class="container">
	<div class="administrator-bussinesspost">
	  <h2 class="tit">Bài viết cá nhân</h2>
	  <form method="GET" action="<?php echo base_url() .'azi-admin/notifications/personal-news' ?>">
	  	<div class="search">	  	
		    <div class="search-input">
		      <img src="/templates/home/styles/images/svg/search.svg" alt="">
		      <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa" value="<?php echo ($_REQUEST['search']) ? $_REQUEST['search'] : ''  ?>">
		    </div>
		    <div class="search-category">
		      <select name="cate_id" class="form-control">
		        <option value="">Tìm theo chuyên mục</option>
		        <?php if (!empty($list_cate)) {  ?>
		        	<?php foreach ($list_cate as $key => $value) { ?>
						<option value="<?php echo $value->cat_id ?>" <?php echo ($_REQUEST['cate_id'] && $_REQUEST['cate_id'] == $value->cat_id) ? 'selected' : ''  ?>><?php echo $value->cat_name ?></option>
		        	<?php } ?>
		    	<?php } ?>
		      </select>
		    </div>
		    <div class="search-state">
		      <?php $search_state = $_REQUEST['status']; ?>
		      <select name="status" id="" class="form-control">
		        <option value="">Tìm theo trạng thái</option>
		        <option value="1" <?php echo ($_REQUEST['status'] && $_REQUEST['status'] == 1) ? 'selected' : ''  ?> >Kích hoạt</option>
		        <option value="0" <?php echo ($search_state === 0 || $search_state === '0') ? 'selected' : ''  ?>>Tắt kích hoạt</option>
		      </select>
		    </div>

			<div class="search-date">
              <div class="from">
                <input type="text" name="from" value="<?=$_REQUEST['from'] ? $_REQUEST['from'] : ''?>"  class="form-control datepicker" placeholder="Chọn ngày">
              </div>
              <p class="txt">Đến</p>
              <div class="to">
                <input type="text" name="to" value="<?=$_REQUEST['to'] ? $_REQUEST['to'] : ''?>" class="form-control datepicker" placeholder="Chọn ngày">
              </div>
            </div>
		    <button type="submit" class="btn-search cursor-pointer">Tìm kiếm</button>
	  	</div>
	  </form>
	  <div class="bussinesspost-table">
	  <?php if (!empty($result['data']['data'])) { ?>
	    <table>
	      <tr class="sm-none">
	        <th>Id</th>
	        <th>Nội dung</th>
	        <th>Chuyên mục</th>
	        <th>Người đăng</th>
	        <th>Ngày đăng</th>
	        <th>Kích hoạt</th>
	        <th>Thông tin</th>
	        <th>Cấu hình</th>
	      </tr>
			<?php foreach ($result['data']['data'] as $key => $value) { ?>
				<tr>
					<td class="id sm-none"><?php echo $value['not_id']; ?></td>
			        <td class="title">
			          <div class="text">
			          	<a href="<?php echo $value['full_link'] ?>">
			          		<?php echo $value['not_description']; ?>
			          	</a>
			          </div>
			          <div class="sm">
	                    <div class="small-txt">
	                      <span><?php echo $value['cat_name']; ?></span>
	                      <span><?php echo $value['use_fullname']; ?></span>
	                      <span><?php echo date('d/m/Y', $value['not_begindate']); ?></span>
	                    </div>
	                    <div class="small-btn">
	                      	<?php 
				        	if ($value['not_status'] == 1) 
				        	{
				        		echo '<a class="js-active-news" data-id="0"><img src="/templates/home/styles/images/svg/check_pink.svg" alt=""></a>';
				        	} 
				        	else 
				        	{
				        		echo '<a class="js-active-news" data-id="1"><img class="js-active-news" data-id="1" src="/templates/home/styles/images/svg/close_gray.svg" alt=""></a>';
				        	}
				        	?>

	                      	<?php if (!empty($value['schedules'])) { ?>
								<button data-toggle="tooltip" data-placement="top" title="Bấm vào icon để xem chi tiết" class="btn js-notification-info" data-id="<?php echo $value['not_id']; ?>"><img src="/templates/home/styles/images/svg/thongtin.svg" class="mr05" alt="">Thông tin</button>
			        	    <?php } else { ?>
								<button data-toggle="tooltip" data-placement="top" title="Chưa được thông báo" class="btn" data-id="<?php echo $value['not_id']; ?>"><img src="/templates/home/styles/images/svg/thongtin.svg" class="mr05" alt="">Thông tin</button>
			        	    <?php } ?>

	                      	<button class="btn bg-gray js-push-notification" data-id="<?php echo $value['not_id']; ?>" data-url="<?php echo base_url() . 'azi-admin/notifications/push_news/' . $value['not_id'];  ?>"><img src="/templates/home/styles/images/svg/settings_white.svg" class="mr05" alt="">Cài đặt</button>
	                    </div>
	                  </div>
			        </td>
			        <td class="sm-none"><?php echo $value['cat_name']; ?></td>
			        <td class="sm-none"><?php echo $value['use_fullname']; ?></td>
			        <td class="sm-none"><?php echo date('d/m/Y', $value['not_begindate']); ?></td>
			        <td class="sm-none">
			        	<?php 
			        	if ($value['not_status'] == 1) 
			        	{
			        		echo '<a class="js-active-news" data-id="0"><img src="/templates/home/styles/images/svg/check_pink.svg" alt=""></a>';
			        	} 
			        	else 
			        	{
			        		echo '<a class="js-active-news" data-id="1"><img class="js-active-news" data-id="1" src="/templates/home/styles/images/svg/close_gray.svg" alt=""></a>';
			        	}
			        	?>
			        </td>
			        <td class="sm-none">
			        	<!-- schedules -->
			        	<?php if (!empty($value['schedules'])) { ?>
			        	<img data-toggle="tooltip" data-placement="top" title="Bấm vào icon để xem chi tiết" class="btn js-notification-info" data-id="<?php echo $value['not_id']; ?>" data-url="<?php echo base_url() . 'azi-admin/notifications/get-notification/' . $value['not_id'];  ?>" data-delete="<?php echo base_url() . 'azi-admin/notifications/delete/' ?>"  src="/templates/home/styles/images/svg/infor_gray.svg" alt="">
			        	<?php } else { ?>
			        	<img data-toggle="tooltip" data-placement="top" title="Chưa được thông báo" class="btn" data-id="<?php echo $value['not_id']; ?>" src="/templates/home/styles/images/svg/infor_gray.svg" alt="">	
			        	<?php } ?>

			        </td>
			        <td class="sm-none">
			        	<?php if ($value['not_status'] == 1) { ?>
			        	<p class="setting cursor-pointer js-push-notification" data-id="<?php echo $value['not_id']; ?>" data-url="<?php echo base_url() . 'azi-admin/notifications/push-news/' . $value['not_id'];  ?>">Cài đặt</p>
			        	<?php } else { ?>
			        	<img data-toggle="tooltip" data-placement="top" title="Bài viết chưa được kích hoạt" src="/templates/home/styles/images/svg/infor_gray.svg" class="mr05" alt="">
			        	<?php } ?>
			        </td>
		        </tr>	
	 		<?php } ?>
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
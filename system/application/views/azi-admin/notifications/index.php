<div class="container">
	<div class="administrator-bussinesspost">
	  <h2 class="tit"><a href="<?php echo base_url() .'azi-admin/notifications' ?>">Thông báo từ azibai</a></h2>
      <div class="more-notice">
        <a href="<?php echo base_url() .'azi-admin/notifications/general/page_push' ?>" target="_blank" class="more-notice-btn">Thêm thông báo</a>
      </div>
	  <form method="GET" action="<?php echo base_url() .'azi-admin/notifications' ?>">
	  	<div class="search">	  	
		    <div class="search-input">
		      <img src="/templates/home/styles/images/svg/search.svg" alt="">
		      <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa" value="<?php echo ($_REQUEST['search']) ? $_REQUEST['search'] : ''  ?>">
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
	    <table class="table-noti-azi">
	      <tr class="sm-none">
	        <th>Id</th>
	        <th class="table-noti-azi-link">Link</th>
	        <!-- <th>cHUYÊN MỤC</th> -->
	        <th class="table-noti-azi-link">Nội dung</th>
	        <th>Ngày đăng</th>
	        <!-- <th>Kích hoạt</th> -->
	        <th class="table-noti-azi-delete">Xóa</th>
	      </tr>
			<?php foreach ($result['data']['data'] as $key => $value) { ?>
				<tr>
					<td class="id sm-none"><?php echo $value['id']; ?></td>
			        <td class="title table-noti-azi-link">
			          <div class="text">
			          	<a href="<?php echo $value['link'] ?>" target="_blank">
			          		<?php echo $value['link']; ?>
			          	</a>
			          </div>
			          <div class="sm">
	                    <div class="small-txt">
	                      <!-- <span><?php //echo $value['cat_name']; ?></span> -->
	                      <span><?php echo $value['content']; ?></span>
	                      <span><?php echo $value['created_at']; ?></span>
	                    </div>
	                    <?php
	                    if($value['finished'] == 0)
	                    {
	                    ?>
	                    <div class="small-btn">
			        	    <button data-toggle="tooltip" data-placement="top" title="Xóa" class="btn js-notification-info" data-id="<?php echo $value['id']; ?>" data-delete="<?php echo base_url() . 'azi-admin/notifications/general/' ?>"><img src="/templates/home/styles/images/svg/delete.svg" class="mr05" alt="">Xóa</button>
	                    </div>
	                    <?php
                		}
	                    ?>
	                  </div>
			        </td>
			        <!-- <td class="sm-none"><?php //echo $value['cat_name']; ?></td> -->
			        <td class="sm-none table-noti-azi-link"><?php echo $value['content']; ?></td>
			        <td class="sm-none"><?php echo $value['created_at']; ?></td>
			        <td class="sm-none table-noti-azi-delete">
	                    <?php
	                    if($value['finished'] == 0)
	                    {
	                    ?>
			        	<img data-toggle="tooltip" data-placement="top" title="Xóa" class="btn js-notification-confirm" data-id="<?php echo $value['id']; ?>" data-delete="<?php echo base_url() . 'azi-admin/notifications/general/' ?>"  src="/templates/home/styles/images/svg/delete.svg" alt="">
	                    <?php
                		}
	                    ?>
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
<?php $this->load->view('home/common/modal-mess'); ?>
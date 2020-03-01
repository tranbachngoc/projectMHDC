<div class="container">
	<div class="administrator-bussinesspost">
	  <h2 class="tit"><a href="<?php echo base_url() .'azi-admin/listtransfer' ?>">Danh sách chuyển tiền</a></h2>
	  <div class="error">
	  <?php if(isset($msg) && $msg != '') { ?>
	  	<p><?=$msg;?></p>
	  <?php } ?>
	  </div>
	  <form method="GET" id="search_money" action="<?php echo base_url() .'azi-admin/listtransfer' ?>">
	  	<div class="search">	  	
		    <div class="search-input">
		      <img src="/templates/home/styles/images/svg/search.svg" alt="">
		      <input type="text" name="search" class="form-control" placeholder="Nhập từ khóa" value="<?php echo ($_REQUEST['search']) ? $_REQUEST['search'] : ''  ?>">
		    </div>
		    <div class="search-category">
		      <select name="bank_type" class="form-control" id="cate_link">
		        <option value="">Loại thẻ</option>
		        <option value="1" <?php echo ($_REQUEST['bank_type'] == 1) ? 'selected' : ''  ?>>Ngân hàng</option>
		        <option value="2" <?php echo ($_REQUEST['bank_type'] == 2) ? 'selected' : ''  ?>>Ví điện tử</option>
		      </select>
		    </div>
		    <div class="search-state">
		    	<?php if(isset($aStatus)) { ?>
        			<select name="status" id="" class="form-control">
        				<option value="">Tìm theo trạng thái</option>
	        			<?php foreach ($aStatus as $iK => $status) { ?>
		        			<?php if($_REQUEST['status'] == $iK) { ?>
		        				<option selected value="<?=$iK?>"><?=$status?></option>
		        			<?php } else { ?>
		        				<option value="<?=$iK?>"><?=$status?></option>
		        			<?php } ?>
		        		<?php } ?>
	        		</select>
        		<?php } ?>
		    </div>

			<div class="search-date">
              <div class="from">
                <input type="text" name="from" value="<?=$_REQUEST['from'] ? $_REQUEST['from'] : ''?>"  class="form-control datepicker" autocomplete="off" placeholder="Chọn ngày">
              </div>
              <p class="txt">Đến</p>
              <div class="to">
                <input type="text" name="to" value="<?=$_REQUEST['to'] ? $_REQUEST['to'] : ''?>" class="form-control datepicker" autocomplete="off" placeholder="Chọn ngày">
              </div>
            </div>
		    <button type="submit" class="btn-search cursor-pointer">Tìm kiếm</button>
	  	</div>
	  </form>
	  <div class="bussinesspost-table">
	  <?php if (!empty($aListTransfer)) { ?>
	    <table>
	      <tr class="sm-none">
	        <th>Id</th>
	        <th>Tài khoản</th>
	        <th>Thông tin cá nhân</th>
	        <th>Tài khoản nhận tiền</th>
	        <th>Số tiền(VNĐ)</th>
	        <th>Thời gian yêu cầu</th>
	        <th>Trạng thái</th>
	        <th>Thông tin</th>
	      </tr>
			<?php foreach ($aListTransfer as $key => $value) { ?>
				<tr>
					<td class="id sm-none"><?php echo $value['id']; ?></td>
					<td class="title" width="10%">
						<?php if(isset($value['user']['use_username'])) { ?>
							<?=$value['user']['use_username']?>
						<?php } ?>
					</td>
			        <td class="title">
			          	<?php if(isset($value['user'])) { ?>
							<p><?=$value['user']['use_fullname']?></p>
							<p><?=$value['user']['use_mobile']?></p>
							<p><?=$value['user']['use_address']?>, <?=$value['user']['DistrictName']?>, <?=$value['user']['ProvinceName']?></p>	
						<?php } ?>
			        </td>
			        <td class="title">
			        	<?php if(isset($value['bank'])) { ?>
							<p><?=$value['bank']['bank_name']?></p>
							<p>Chủ tài khoản : <?=$value['bank']['account_name']?></p>
							<p>TK : <?=$value['bank']['account_number']?></p>
							<p>Chi nhánh : <?=$value['bank']['aff']?></p>	
						<?php } ?>
			        </td>
			        <td class="title"><?=number_format($value['amount'])?></td>
			        <td class="title"><?=$value['created_date']?></td>
			        <td class="title" width="15%">
			        	<?php if(isset($aStatus)) { ?>
			        		<select class="change_status" data-id="<?=$value['id']?>">
			        			<?php foreach ($aStatus as $iK => $status) { ?>
				        			<?php if($value['status'] == $iK) { ?>
				        				<option selected value="<?=$iK?>"><?=$status?></option>
				        			<?php } else { ?>
				        				<option value="<?=$iK?>"><?=$status?></option>
				        			<?php } ?>
				        		<?php } ?>
			        		</select>
			        	<?php } else { echo $value['sStatus']; } ?>
			        </td>
			        <td class="sm-none">
			        	<img data-id="<?=$value['id']?>" class="openlog" src="/templates/home/styles/images/svg/infor_gray.svg" class="mr05" alt="">
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

<!-- The modal setting push notification -->
<div class="modal" id="infomation_money" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
	    <!-- Modal Header -->
	    <div class="modal-header">
	      <h4 class="modal-title">Thông tin</h4>
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	    </div>
	    <!-- Modal body -->
	    <div class="modal-body">
	      <table id="list_log">
	      	<thead>
		      	<tr class="title-page">
		      		<th>Ngày</th>
		      		<th>Trạng thái</th>
		      		<th>Người cập nhật</th>
		      	</tr>
		      	<tr style="border: none;height: 15px">
		      		<th></th>
		      		<th></th>
		      		<th></th>
		      	</tr>
		    </thead>
	      	<tbody></tbody>
	      </table>
	    </div>   
	    <div class="modal-footer">
	      <div class="shareModal-footer">
	        <div class="permision"></div>
	        <div class="buttons-direct">
	          <button type="button" class="btn-cancle" data-dismiss="modal">Đóng</button>
	        </div>
	      </div>
	    </div>
	    <!-- End modal-footer -->       
	  </div>
	</div>
</div>
<!-- End The Modal -->
<!-- The modal setting push notification -->
<div class="modal" id="comfirm_status" data-keyboard="false" data-backdrop="static">
	<div class="modal-dialog modal-lg">
	  <div class="modal-content">
	    <!-- Modal Header -->
	    <div class="modal-header">
	      <h4 class="modal-title">Thông báo</h4>
	      <button type="button" class="close" data-dismiss="modal">&times;</button>
	    </div>
	    <!-- Modal body -->
	    <div class="modal-body">
	      
	    </div>   
	    <div class="modal-footer">
	      <div class="shareModal-footer">
	        <div class="permision"></div>
	        <div class="buttons-direct">
	        	<button type="button" class="btn-cancle" data-dismiss="modal">Hủy</button>
	          	<button type="button" class="btn-share btn-change bg-pink" data-dismiss="modal">Chắc chắn</button>
	        </div>
	      </div>
	    </div>
	    <!-- End modal-footer -->       
	  </div>
	</div>
</div>
<!-- End The Modal -->
<style type="text/css">
	table#list_log thead {
		margin-bottom: 15px;
	}
	table#list_log tr.title-page {
		border: 1px solid rgba(0, 0, 0, 0.1);
		
	}
	table#list_log tr th,
	table#list_log tr td {
		text-align: center;
		padding: 10px 15px;
	}
	table#list_log tr {
		border: 1px solid rgba(0, 0, 0, 0.1);
	}
	.change_status {
		border: none;
		color: #A1A1A1;
	}
	.error {
		margin: 20px 0px;
		color: #FF1678;
	}
</style>
<script>
  	$('body').on('click', '.openlog', function () {
  	var id = $(this).attr('data-id');
	  	$.ajax({
	      type: "GET",
	      url: siteUrl+"azi-admin/listlog/"+id,
	      dataType: 'json',
	      data: {},
	      success: function (response) {
	        if(response.type == 'success') {
	        	var html = '';
	        	html +='<table id="list_log">';
			      	html +='<thead>';
				      	html +='<tr class="title-page">';
				      		html +='<th>Ngày</th>';
				      		html +='<th>Trạng thái</th>';
				      		html +='<th>Người cập nhật</th>';
				      	html +='</tr>';
				      	html +='<tr style="border: none;height: 15px">';
				      		html +='<th></th>';
				      		html +='<th></th>';
				      		html +='<th></th>';
				      	html +='</tr>';
				    html +='</thead>';
			      	html +='<tbody>';
			      		$.each(response.data,function (index, item) {
			          		let date = new Date(item.created_date);
			          		let formatted_date = date.getHours() + ":" + date.getMinutes() + " ngày " + date.getDate() +"/" + (date.getMonth() + 1) + "/" + date.getFullYear();
							html +='<tr>';
							  	html +='<td>'+formatted_date+'</td>';
							  	html +='<td>'+item.status+'</td>';
							  	html +='<td>'+item.user_fullname+'</td>';
							html +='</tr>';
						});
			      	html +='</tbody>';
			    html +='</table>';
	          	
				$('#infomation_money .modal-body').html(html);
	        }else {
	        	var html = ''
	        	html +='<table id="list_log">';
			      	html +='<thead>';
				      	html +='<tr class="title-page">';
				      		html +='<th>Ngày</th>';
				      		html +='<th>Trạng thái</th>';
				      		html +='<th>Người cập nhật</th>';
				      	html +='</tr>';
				      	html +='<tr style="border: none;height: 15px">';
				      		html +='<th></th>';
				      		html +='<th></th>';
				      		html +='<th></th>';
				      	html +='</tr>';
				    html +='</thead>';
			      	html +='<tbody></tbody>';
			    html +='</table>';
		      	html +='<p style="text-align: center;">Chưa có thông tin chuyển trạng thái</p>';
	          	$('#infomation_money .modal-body').html(html);
	        }
	      }
	    });

  		$('#infomation_money').modal('show');
  	});

  	$( "select.change_status" ).change(function () {
   		var status 	= $(this).children("option:selected").val();
   		var text 	= $(this).children("option:selected").text();
   		var id 		= $(this).attr('data-id');
   		$('#comfirm_status .modal-body').html('<p>Bạn có chắc chắn muốn chuyển trạng thái giao dịch thành <strong>'+text+'</strong></p>');
   		$('#comfirm_status .btn-change').attr('onclick','changeStatus("'+status+'","'+id+'")');
   		$('#comfirm_status').modal('show');
  	});

	function changeStatus(status,id) {
  		$.ajax({
	      type: "POST",
	      url: siteUrl+"azi-admin/updatestatus/"+id,
	      dataType: 'json',
	      data: {status: status},
	      success: function (response) {
	        if(response.type == 'error') {
	          alert(response.message);
	        }
	      }
	    });
	}
	$( "#search_money" ).submit(function( event ) {
		var check = true;
	  	var from = $( "#search_money" ).find('input[name="from"]').val();
	  	var to 	 = $( "#search_money" ).find('input[name="to"]').val();

	  	if(from != '' && to == '') {
	  		check = false;
	  		$('.error').html('<p>Vui lòng nhập ngày kết thúc!</p>');
	  	}
	  	if(from == '' && to != '') {
	  		check = false;
	  		$('.error').html('<p>Vui lòng nhập ngày bắt đầu!</p>');
	  	}

	  	if(from != '' && to != '') {
	  		var x = new Date(from);
			var y = new Date(to);
			if(x > y) {
				check = false;
				$('.error').html('<p>Ngày kết thúc phải lớn hơn ngày bắt đầu</p>');
			}
	  	}
	  	if(check == false) {
	  		event.preventDefault();
	  	}else {
	  		$(this).submit();
	  	}
	  	
	});
</script>

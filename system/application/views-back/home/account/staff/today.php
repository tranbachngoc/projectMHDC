<?php $this->load->view('home/common/header'); ?>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
	<!--BEGIN: RIGHT-->
	<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
	    <form name="frmTasktoday" id="frmTasktoday" method="post">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">
		<?php
		foreach ($tasklist as $key => $getday) {
		    $day = date('d', $getday->created_date);
		    $month = date('m', $getday->created_date);
		    $year = date('Y', $getday->created_date);
		}
		$getday = strtolower($this->uri->segment(6));
		$m = date("m");
		$y = date("Y");
		?>
		<span>Công việc trong ngày</span> ( <?php
		if (empty($getday)) {
		    echo date('d') . '/';
		} else {
		    echo $getday . '/';
		} if (isset($month)) {
		    echo $month . '/';
		} else {
		    echo $m . '/';
		} echo $y;
		?> )
		<span class="pull-right">
		    <select name="daytask" id="daytask" onchange="ActionLink('<?php echo $statusUrl; ?>/filter/' + this.value)" class="text-primary">
			<?php
			$list = array();
			$month = date("m");
			$year = date("Y");
			for ($days = 1; $days <= 31; $days++) {
			    $time = mktime(12, 0, 0, $month, $days, $year);
			    if (date('m', $time) == $month) {
				$list[] = date('d', $time);
			    }
			    ?>
			    <?php if (empty($getday) && $days == date('d')) { ?>
				<option selected="selected" value="<?php echo $days; ?>"><?php echo $days . '/' . $month . '/' . $year ?></option>
			    <?php } elseif (isset($getday) && $getday == $days) { ?>
				<option selected="selected" value="<?php echo $days; ?>"><?php echo $days . '/' . $month . '/' . $year ?></option>
			    <?php } else { ?>
				<option value="<?php echo $days; ?>"><?php echo $days . '/' . $month . '/' . $year ?></option>
				<?php
			    }
			}
			?>
		    </select>
		</span>
	    </h4>
	    

		
		    <?php if (empty($tasklist)) { ?>
		    <div class="none_record">
			<p class="text-center">
			    Không có công việc nào được giao!
			</p>
		    </div>
		    <?php } else { ?>
		    <div class="table-responsive">
			<table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">

			    <tr>
				<th width="5%" class="title_account_0">STT</th>
				<th width="20%" class="title_account_2" align="center" >
				    Tên công việc
				    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
				    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>title/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
				</th>
				<th width=20%" class="title_account_2" align="center" >
				    Ngày tháng
				</th>
				<th width=15%" class="title_account_2" align="center" >
				    Nhân viên
				    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" alt="" />
				    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0"  alt="" />
				</th>
				<th width=10%" class="title_account_2" align="center" >
				    Trạng thái 
				</th>
			    </tr>

			    <tbody>
				    <?php
				    foreach ($tasklist as $key => $items) {
					$day = date('d', $items->created_date);
					$month = date('m', $items->created_date);
					$year = date('Y', $items->created_date);
					?>
					<tr>
					    <td width="5%" height="32" class="line_account_0"><?php echo $key + 1; ?></td>
					    <td width="20%" height="32" class="line_account_2">
						<a href="<?php echo base_url(); ?>account/staffs/task/<?php echo $items->use_id; ?>/month/<?php echo $month; ?>/day/<?php echo $day; ?>/edit/<?php echo $items->id; ?>">   <?php echo $items->name; ?></a>
					    </td>
					    <td width="20%" height="32" class="line_account_2">
						<?php echo date('d/m/Y', $items->created_date); ?>
					    </td>
					    <td width="10%" height="32" class="line_account_2">
						<a href="<?php echo base_url(); ?>/account/edit/<?php echo $items->use_id; ?>"><?php echo $items->use_username; ?></a>
					    </td>
					    <td width="10%" height="32" class="line_account_2 text-center">
						<?php if ($items->status == 2) { ?>
						<img src="<?php echo base_url(); ?>templates/home/images/public.png" border="0" alt="<?php echo $this->lang->line('replied_tip'); ?>" title="Đã hoàn thành" />
						<?php } elseif ($items->status == 1) { ?>
						<i class="fa fa-refresh"></i>
						<?php } else { ?>
						<img src="<?php echo base_url(); ?>templates/home/images/unpublic.png" border="0" alt="<?php echo $this->lang->line('replied_tip'); ?>" title="Chưa hoàn thành"/>
						<?php } ?>
					    </td>
					</tr>
				    <?php }
				    ?>
			    </tbody>

			</table>
		    </div>
		<?php } ?>
	    </form>
	</div>
	<?php echo $linkPage; ?>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
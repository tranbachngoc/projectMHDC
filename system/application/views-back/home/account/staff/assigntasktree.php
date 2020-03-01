<?php $this->load->view('home/common/header'); ?>
<div class="container-fluid">
    <div class="row">
	<?php $this->load->view('home/common/left'); ?>
	<!--BEGIN: RIGHT-->
	<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">
		Danh sách Tuyến dưới, Gian hàng
	    </h4>
	    <div class="table-responsive">
		<table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
		    <thead>
			<tr>
			    <th width="5%" class="title_account_0">STT</th>
			    <th width="20%" class="title_account_2" align="center" >
				Tài khoản
				<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
				<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
			    </th>
			    <th width=20%" class="title_account_2" align="center" >
				Họ tên 
				<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
				<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
			    </th>
			    <th width=20%" class="title_account_2" align="center">
				Nhóm 
				<img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>group/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
				<img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>group/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
			    </th>
			    <th width=15%" class="title_account_2" align="center" >
				Email
			    </th>
			    <th width=10%" class="title_account_2" align="center" >
				Điện thoại
			    </th>
			    <th width="10%" class="title_account_1">
				Giao việc
			    </th>
			</tr>
		    </thead>
		    <tbody>
			<?php
			foreach ($staffs as $key => $items) {
			    ?>
    			<tr>
    			    <td width="5%" height="32" class="line_account_0"><?php echo $key + 1; ?></td>
    			    <td width="20%" height="32" class="line_account_2">
    				<a target="_blank" href="<?php echo base_url(); ?>user/profile/<?php echo $items->use_id; ?>"> <?php echo $items->use_username; ?></a>
    			    </td>
    			    <td width="20%" height="32" class="line_account_2">
				    <?php echo $items->use_fullname; ?>
    			    </td>
    			    <td width="20%" height="32" class="line_account_2">
				    <?php
				    if ($items->use_group == AffiliateStoreUser) {
					echo 'Gian hàng';
				    }
				    if ($items->use_group == Developer2User) {
					echo 'Developer 2';
				    }
				    if ($items->use_group == Developer1User) {
					echo 'Developer 1';
				    }
				    if ($items->use_group == Partner2User) {
					echo 'Partner 2';
				    }
				    if ($items->use_group == Partner1User) {
					echo 'Partner 1';
				    }
				    if ($items->use_group == CoreMemberUser) {
					echo 'Core Member';
				    }
				    if ($items->use_group == CoreAdminUser) {
					echo 'Core Admin';
				    }
				    ?>

    			    </td>
    			    <td width="10%" height="32" class="line_account_2">
    				<a href="mailto:<?php echo $items->use_email; ?>"><?php echo $items->use_email; ?></a>
    			    </td>
    			    <td width="10%" height="32" class="line_account_2">
				    <?php echo $items->use_mobile; ?>
    			    </td>
    			    <td width="15%">
    				<a class="btn btn-success" href="<?php echo base_url(); ?>account/staffs/task/<?php echo $items->use_id; ?>/month/<?php echo date('m'); ?>"><i class="fa fa-plus"></i> Giao việc</a>
    			    </td>
    			</tr>
			<?php } ?>
		    </tbody>
		</table>
	    </div>
	    <?php echo $linkPage; ?>
	</div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
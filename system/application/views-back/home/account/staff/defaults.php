<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>
<!--BEGIN: RIGHT-->
<div class="col-md-9 col-sm-8 col-xs-12">
    <h4 class="page-header text-uppercase" style="margin-top:10px;">
        DANH SÁCH NHÂN VIÊN
    </h4>
    <div class="table-responsive">
    <table class="table table-bordered">
       <thead>
       <tr>
           <th width="5%" class="title_account_0">STT</th>
           <th width="20%" class="title_account_2" align="center" >
               Tài khoản
               <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
               <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
           </th>
           <th width="25%" class="hidden-xs" align="center" >
               Họ tên
               <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
               <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
           </th>
           <th width=20%" class="hidden-xs" align="center" >
               Email
           </th>
           <th width=15%" class="title_account_2" align="center" >
               Số điện thoại
           </th>
           <th width="15%" class="title_account_1">
               Giao việc
           </th>
       </tr>
       </thead>
        <tbody>
        <?php foreach($staffs as $key => $items)
                {
        ?>
            <tr>
                <td width="5%" height="32" class="line_account_0"><?php echo $key+$stt; ?></td>
                <td width="20%" height="32" class="line_account_2">
                    <a href="<?php echo base_url(); ?>user/profile/<?php echo $items->use_id;?>" target="_blank"> <?php echo $items->use_username;?></a>
                </td>
                <td width="25%" height="32" class="hidden-xs">
                    <?php echo $items->use_fullname;?>
                </td>
                <td width="20%" height="32" class="hidden-xs">
                    <?php echo $items->use_email;?>
                </td>
                <td width="15%" height="32" class="line_account_2">
                    <?php echo $items->use_mobile;?>
                </td>
                <td width="15%">
                    <a class="btn btn-success" href="<?php echo base_url(); ?>account/staffs/task/<?php echo $items->use_id;?>/month/<?php echo date('m');?>"><i class="fa fa-plus"></i> Giao việc</a>
                </td>
            </tr>
        <?php }?>
         <?php if(count($staffs)  <= 0){ ?>
                   <tr>
                   <td colspan="6"><div class="nojob">Không có nhân viên nào!</div></td>
                   </tr>
                   <?php } ?>
       </tbody>
    </table>
    </div>
	<?php echo $linkPage;?>
    </div>
</div>
    </div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
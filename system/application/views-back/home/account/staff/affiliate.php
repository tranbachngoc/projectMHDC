<?php $this->load->view('home/common/header');  ?>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            <div class="col-lg-9 col-md-9 col-sm-8">
                <h2 class="page-title text-uppercase">
                    Danh sách Affiliate đã giới thiệu
                </h2>
				<div style="overflow: auto; width:100%">
                <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%" class="title_account_0">STT</th>
                        <th width="20%" class="title_account_2" align="center" >
                            Gian hàng
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>nameshop/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>nameshop/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </th>
                        <th width="20%" class="title_account_2" align="center" >
                            Tên đăng nhập
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </th>
                        <th width=20%" class="title_account_2" align="center" >
                            Họ tên 
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </th>
                        <th width=15%" class="title_account_2" align="center" >
                            Email
                        </th>
                        <th width=15%" class="title_account_2" align="center" >
                            Số điện thoại
                        </th>
                    </tr>
                    </thead>
                   <tbody>
                   <?php foreach($staffs as $key => $items)
                   {
                       ?>
                       <tr>
                           <td width="5%" height="32" class="line_account_0"><?php echo $key+1; ?></td>
                           <td width="20%" height="32" class="line_account_2">
                               <a href="<?php echo base_url(); ?><?php echo $items->sho_link;?>"> <?php echo $items->sho_name;?></a>
                           </td>
                           <td width="20%" height="32" class="line_account_2">
                               <a href="<?php echo base_url(); ?>/user/profile/<?php echo $items->use_id;?>"> <?php echo $items->use_username;?></a>
                           </td>
                           <td width="20%" height="32" class="line_account_2">
                               <?php echo $items->use_fullname;?>
                           </td>
                           <td width="10%" height="32" class="line_account_2">
                               <?php echo $items->use_email;?>
                           </td>
                           <td width="10%" height="32" class="line_account_2">
                               <?php echo $items->use_mobile;?>
                           </td>
                       </tr>
                   <?php }?>
                   <?php if(count($staffs)  <= 0 ){ ?>
                   <tr>
                   <td colspan="5"><div class="nojob">Không có Affiliate nào!</div></td>
                   </tr>
                   <?php } ?>
                   </tbody>
                </table>
				</div>
			</div>
        </div>
    </div>
    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
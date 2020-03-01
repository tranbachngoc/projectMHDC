<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
	  <div class="row">
		<?php $this->load->view('home/common/left'); ?>
		<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
		    <h4 class="page-header text-uppercase" style="margin-top: 10px">
			<?php if($this->uri->segment(3) > 0){
			    echo 'Danh sách thành viên của '.$rootUser->use_username;
			} else {
			    echo 'Danh sách thành viên của '.$rootUser->use_username;
			} ?>
		    </h4>
                <div class="tool_more"><a href="<?php echo base_url(); ?>account/tree<?php if($this->uri->segment(3) > 0){ echo "/".$this->uri->segment(3);} ?>"><i class="fa fa-cubes"></i> Xem dạng cây</a></div>
                <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%" class="title_account_0">STT</th>
                        <th width="15%" class="title_account_2" align="center" >
                            Tài khoản
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </th>
                        <th width=15%" class="title_account_2" align="center" >
                            Họ tên
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </th>
                       <th width=15%" class="title_account_2" align="center" >
                            Nhóm
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
                   <?php
				    foreach($staffs as $key => $items)
                   {
                       ?>
                       <tr>
                           <td width="5%" height="32" class="line_account_0"><?php echo $key+1; ?></td>
                           <td width="15%" height="32" class="line_account_2">
                               <a href="<?php echo base_url(); ?>account/treelist/<?php echo $items->use_id;?>"> <?php echo $items->use_username;?></a>
                           </td>
                           <td width="15%" height="32" class="line_account_2">
                               <a href="<?php echo base_url(); ?>user/profile/<?php echo $items->use_id;?>"> <?php echo $items->use_fullname;?> </a>
                           </td>
                           <td width="10%" height="32" class="line_account_2">
							 <!-- <a href="<?php echo base_url(); ?>account/treelist/<?php echo  $parentList[$key]->parent_id;?>"><?php echo  $parentList[$key]->parent_username;?></a>-->
							  <?php
							          switch($items->use_group){										
										case 6: 		
											echo "Developer 2"; 
											break;
										case 7: 		
											echo "Developer 1"; 
											break;
										case 8: 		
											echo "Partner 2"; 	
											break;
										case 9: 		
											echo "Partner 1"; 	
											break;	
										case 10: 		
											echo "Core member"; 	
											break;		
										default:
											echo "";
									  }
							  ?>
							</td>
                           <td width="10%" height="32" class="line_account_2">
                               <?php echo $items->use_email;?>
                           </td>
                           <td width="10%" height="32" class="line_account_2">
                               <?php echo $items->use_mobile;?>
                           </td>
                       </tr>
                   <?php  }?>
                   <?php if(count($staffs) == 0){ ?>
                   <tr><td colspan="6">Không có thành viên nào!</td></tr>
                   <?php } ?>

                   </tbody>
                </table>
                <?php echo $linkPage; ?>
            </div>
        </div>
    </div>
    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-lg-9 col-md-9 col-sm-8">
            <!-- Thông báo lỗi nếu có -->
            <?php if ($this->session->flashdata('flash_message_success') || $this->session->flashdata('flash_message_error')){ ?>
            <div class="message success" ">
            <div class="alert <?php echo ($this->session->flashdata('flash_message_error')?'alert-danger':'alert-success')?>">
                <?php echo ($this->session->flashdata('flash_message_error')?$this->session->flashdata('flash_message_error'):$this->session->flashdata('flash_message_success')); ?>
                <button type="button" class="close" data-dismiss="alert">×</button>
            </div>
        </div>
    <?php } ?>
        <!-- Thông báo lỗi nếu có -->
        <h2 class="page-title"> Danh sách nhân viên gian hàng</h2>
        <div class="visible-xs">
            <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th width="44">STT</th>
                    <th>Thông tin nhân viên</th>
                <tr> 
                    </thead>
            <?php foreach($branchs as $key=>$items): ?>
                <tr>
                    <td style="vertical-align: middle"><?php echo $key+1 ?></th>
                    <td>                     
                        <p>Tài khoản: <strong><a target="_blank" href="<?php echo base_url(); ?>user/profile/<?php echo $items->use_id; ?>"> <?php echo $items->use_username; ?></a></strong></p>
                        <p>Họ tên: <?php echo $items->use_fullname;?></p>
                        <p><i class="fa fa-envelope fa-fw"></i> <?php echo $items->use_email;?></p>
                        <p><i class="fa fa-phone fa-fw"></i> <?php echo $items->use_mobile;?></p>
                        <p>SL Afiliate: <a class="badge" href="<?php echo base_url() .'account/listaffstore/'. $items->use_id; ?>" title="Tổng số affiliate của <?php echo $items->use_username; ?>" ><?php echo $items->sl; ?></a></p>
                        <p>                            
                            <a class="btn btn-default btn-sm" href="<?php echo $items->use_message; ?>" title="Gửi tin nhắn"  onclick=""><i class="fa fa-comment-o"></i></a>
                            <a class="btn btn-default btn-sm" href="<?php echo base_url() .'account/editstaffstore/'. $items->use_id; ?>"><i class="fa fa-pencil-square-o"></i></a>
                            <a class="delete_nvgh btn btn-default btn-sm" href="<?php echo base_url() .'account/liststaffstore/delete/'. $items->use_id; ?>" title="Dữ liệu xóa không được phục hồi"  onclick=""><i class="fa fa-trash-o"></i></a>
                        </p>
                    </td>
                <tr>                
            <?php endforeach; ?>
            </table>
        </div>
        <div class="hidden-xs">
            <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                <thead>
                <tr>
                    <th width="5%" class="title_account_0">STT</th>
                    <th width="20%" class="title_account_2" align="center">
                        Tài khoản
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>use_username/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>use_username/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                    </th>
                    <th width="25%" class="title_account_2" align="center" >
                        Tên nhân viên
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>use_fullname/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>use_fullname/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                    </th>
                    <th width="20%" class="title_account_2" align="center" >
                        Email
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>use_email/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>use_email/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        
                    </th>
                    
                    <th width="5%" class="title_account_2" align="center" >
                        SL Affiliate
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>sl/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>sl/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                    </th>
                    <th width="20%" class="title_account_2" align="center" >
                       Hành động
                    </th>
                    <!-- <th width="15%" class="title_account_2" align="center">
           	  Doanh số
              </th> -->
<!--                     <th width="5%" class="title_account_2" align="center">-->
<!--                      Sửa/Xóa-->
<!--                    </th>-->
                </tr>
                </thead>
                <tbody>
                <?php
                foreach($branchs as $items): 
                    ?>
                    <tr>
                        <td height="32" class="line_account_0">
                            <?php echo $sTT++; ?>
                        </td>
                        <td height="32" class="line_account_2">
                            <a target="_blank" href="<?php echo base_url(); ?>user/profile/<?php echo $items->use_id; ?>"> <?php echo $items->use_username; ?></a>
                        </td>
                        <td height="32" class="line_account_2">
                            <?php echo $items->use_fullname;?>
                        </td>
                        <td height="32" class="line_account_2">
                            <?php echo $items->use_email; ?>
                            <?php echo $items->use_mobile; ?>
                        </td>
                        
                        <td height="32" class="line_account_2 text-center">
                            <a href="<?php echo base_url() .'account/listaffstore/'. $items->use_id; ?>" title="Tổng số affiliate của <?php echo $items->use_username; ?>" ><?php echo $items->sl; ?></a>
                        </td>

                        <td  height="32" class="text-center" style="vertical-align: middle">
						<?php if($items->use_message) { ?>
                            <a class="btn btn-default btn-sm" href="<?php echo $items->use_message; ?>" title="Gửi tin nhắn" ><i class="fa fa-comment-o fa-fw"></i></a>
						<?php } ?>
                            <a class="btn btn-default btn-sm" href="<?php echo base_url() .'account/editstaffstore/'. $items->use_id; ?>"><i class="fa fa-pencil-square-o  fa-fw"></i></a>
<!--                            <button onclick="xacnhanXoa()" type="button"></button>-->
                            <a class="btn btn-default btn-sm delete_nvgh" href="<?php echo base_url() .'account/liststaffstore/delete/'. $items->use_id; ?>" title="Dữ liệu xóa không được phục hồi" onclick=""><i class="fa fa-trash-o  fa-fw"></i></a>
                        </td>
                        <script>
                           function xacnhanXoa(){
                                var xacnhan = confirm('Bạn muốn xóa dữ liệu <?php echo $items->use_username;?>');
                                if(xacnhan == true){
//                                        $.ajax({
//                                            url     : '<?php //echo base_url() .'account/liststaffstore/delete/'. $items->use_id; ?>//',
//                                            type    : "POST",
//                                            data    : {id : walletlog_id},
//                                            success:function(response)
//                                            {
//                                                if(response == 0){
//                                                    alert("Lỗi! Vui lòng thử lại");
//                                                } else {
//                                                    window.location.href='<?php //echo base_url() .'account/liststaffstore'; ?>//';
//                                                }
//                                            },
//                                            error: function()
//                                            {
//                                                alert("Lỗi! Vui lòng thử lại");
//                                            }
//                                        });
                                    $('.delete_nvgh').attr('href',"<?php echo base_url() .'account/liststaffstore/delete/'. $items->use_id; ?>");
                                }
                                else {
                                    return false;
                                }
                            }
                        </script>
                    </tr>
                <?php endforeach; ?>
                <?php  if(count($branchs) <= 0) { ?>
                    <tr>
                        <td colspan="7"><div class="nojob">Không có dữ liệu!</div>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>



            <div class="text-right"><a class="btn btn-primary" href="<?php echo base_url(); ?>account/addstaffstore"> +Thêm mới</a></div>
        </div>
        <?php echo $linkPage; ?>
    </div>
</div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>



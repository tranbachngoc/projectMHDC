<?php $this->load->view('home/common/account/header'); ?>
<div class="container">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-lg-9 col-md-9 col-sm-8">
            <h2 class="page-title text-uppercase">
                Danh sách thành viên
            </h2>
            <div class="db_table" style="overflow: auto; width:100%">
                <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%" class="title_account_0">STT</th>
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
                        <th width=15%" class="title_account_2" align="center" >
                            Gửi yêu cầu
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php   $groupid = $this->session->userdata('sessionGroup');
                    foreach($list_up as $key => $items) {
                        ?>
                        <tr>
                            <td width="5%" height="32" class="line_account_0"><?php echo $key+1; ?></td>
                            <td width="20%" height="32" class="line_account_2">
                                <a href="<?php echo base_url(); ?>/user/profile/<?php echo $items->use_id;?>"> <?php echo $items->use_username;?></a>
                                <div class="shop_parent <?php if($items->userid_parent == $this->session->userdata('sessionUser')){ ?>active<?php } ?>"><i><a href="<?php echo base_url(); ?>/user/profile/<?php echo $items->userid_parent;?>"> <?php echo $items->username_parent;?></a></i></div>
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
                            <td width="15%" height="32" class="line_account_2">
                                <?php
                                if (in_array($items->use_id, $list_allow)){
                                ?>
                                    <?php if ($items->status == 0) {?>
                                    <p class="text-primary"><i class="fa fa-spinner" aria-hidden="true"></i>
                                         Chờ nâng cấp</p>
                                        <?php } else{?>
                                        <p class="text-success"><i class="fa fa-upload" aria-hidden="true"></i> Đã lên cấp</p>
                                        <?php }?>
                                <?php }else{?>
                                    <button type="button" data-toggle="modal" data-target="#myModal_Shop_<?php echo $items->use_id;?>" class="btn btn-primary" >
                                        <i class="fa fa-upload" aria-hidden="true"></i> Lên cấp
                                    </button>
                                <?php }?>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal_Shop_<?php echo $items->use_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Yêu cầu nâng cấp cho thành viên</h4>
                                    </div>
                                    <form id="from_req" name="from_req" action="" method="post">
                                    <div class="modal-body">
                                        <p>Cấp hiện tại của <span class="text-primary"><?php echo $items->use_username;?></span> là:
                                        <span class="text-danger">
                                            <?php
                                            switch ($items->use_group){
                                                case 6:
                                                    echo '<b>Developer2</b>';
                                                    break;
                                                case 7:
                                                    echo '<b>Developer1</b>';
                                                    break;
                                                case 8:
                                                    echo '<b>Partner2</b>';
                                                    break;
                                                case 9:
                                                    echo '<b>Partner1</b>';
                                                    break;
                                            }
                                            ?>
                                        </span>
                                        </p>
                                            <select name="level_list" id="level_list" class="form-control">
                                                <option value="">--Chọn cấp cần lên---</option>
                                                <?php
                                                $groupid = $this->session->userdata('sessionGroup');

                                                switch ($groupid){
                                                    case 8:
                                                        if ($items->use_group == 6){ echo '<option value="7">Developer1</option>';}
                                                        break;
                                                    case 9:
                                                        if ($items->use_group == 6){
                                                            echo '<option value="7">Developer1</option>
                                                               <option value="8">Partner2</option>
                                                              ';
                                                        }
                                                        if ($items->use_group == 7){
                                                            echo '<option value="8">Partner2</option>';
                                                        }
                                                        break;
                                                    case 10:
                                                        if ($items->use_group == 6){
                                                            echo '<option value="7">Developer1</option>
                                                               <option value="8">Partner2</option>
                                                               <option value="9">Partner1</option>
                                                             ';
                                                        }
                                                        if ($items->use_group == 7){
                                                            echo ' <option value="8">Partner2</option>
                                                               <option value="9">Partner1</option>
                                                             ';
                                                        }
                                                        if ($items->use_group == 8){ echo '<option value="9">Partner1</option>';}
                                                        break;
                                                    case 12:
                                                        if ($items->use_group == 6){
                                                            echo '  <option value="7">Developer1</option>
                                                               <option value="8">Partner2</option>
                                                               <option value="9">Partner1</option>
                                                               <option value="10">CoreMember</option>';
                                                        }
                                                        if ($items->use_group == 7){
                                                            echo '<option value="8">Partner2</option>
                                                             <option value="9">Partner1</option>
                                                             <option value="10">CoreMember</option>';
                                                        }
                                                        if ($items->use_group == 8){
                                                            echo '<option value="9">Partner1</option>
                                                             <option value="10">CoreMember</option>';
                                                        }
                                                        if ($items->use_group == 9){
                                                            echo '<option value="10">CoreMember</option>';
                                                        }
                                                        break;
                                                }
                                                ?>
                                            </select>
                                        <p class="erre_mes text-danger"></p>
                                        <input type="hidden" name="usid" value="<?php echo $items->use_id;?>" />
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                        <button type="submit" id="btn_submit"  class="btn btn-primary">Xác nhận</button>
                                    </div>
                                        </form>
                                </div>
                            </div>
                        </div>
                    <?php }?>

                    <?php if($linkPage){?>
                        <tr>
                            <td colspan="7"><?php echo $linkPage;?></td>
                        </tr>
                    <?php } ?>
                    <?php if(count($list_up)  <= 0){ ?>
                        <tr>
                            <td colspan="6"><div class="nojob">Không có nhân viên nào!</div></td>
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
<script>
    jQuery(document).ready(function ($){
        $('#btn_submit').click(function () {
            if ($('#level_list').val() == ''){
                $('.erre_mes').html('Bạn chưa chọn cấp cần lên!');
                return false;
            }
        })
    });
    function add_shop_for_user(){
        if($('#child_list').val() != ''){
            use_id = $('#child_list').val();
            shop_id = $('#shop_id').val();
            $.ajax({
                type: "post",
                url:"<?php echo base_url(); ?>" + 'account/tree/store',
                cache: false,
                data:{use_id: use_id, shop_id: shop_id},
                dataType:'text',
                success: function(data){
                    if(data == '1'){
                        alert("Cập nhật thành công!");
                        $('.modal').modal('hide');
                        location.reload();
                    }else{
                        errorAlert('Có lỗi xảy ra','Thông báo');
                    }
                }
            });
        }else{
            alert("Vui lòng chọn thành viên cần gán!");
        }
        return false;
    }
</script>

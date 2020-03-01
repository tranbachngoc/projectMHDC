<?php $this->load->view('home/common/header'); ?>
<div class="container">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <?php
        $group_id = (int)$this->session->userdata('sessionGroup');
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'];
        ?>
        <div class="col-lg-9 col-md-9 col-sm-8">
            <h2>
                Danh sách nhân viên của gian hàng <?php if( $user_staff->use_id > 0){echo ' của nv: (' .  $user_staff->use_username . ')'; } ?>
            </h2>
            <div style="overflow: auto; width:100%">
                <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?php if(count($staffs) > 0){?>
                        <thead>
                        <tr>
                            <th width="5%" class="title_account_0">STT</th>
                            <th width="20%" class="title_account_2" align="center">
                                Tài khoản
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            </th>
                            <th width=20%" class="title_account_2" align="center" >
                                Tên Gian hàng
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            </th>
                            <th width=15%" class="title_account_2" align="center">
                                Link Gian hàng
                            </th>
                            <th width=15%" class="title_account_2" align="center" >
                                Email
                            </th>
                            <th width=10%" class="title_account_2" align="center" >
                                Điện thoại
                            </th>
                            <?php if($group_id > 3 && $group_id != 11) {?>
                                <th width=10%" class="title_account_2" align="center" >
                                    Gán gian hàng
                                </th>
                            <?php }?>
                        </tr>
                        </thead>
                        <tbody>
                        <!--        --><?php //foreach($staffs as $key => $items)
                        $total = 0;
                        foreach($liststore as $key => $items)
                        {
                            ?>
                            <tr>
                                <td width="5%" height="32" class="line_account_0"><?php echo $key+1+$stt; ?></td>
                                <td width="20%" height="32" class="line_account_2">
                                    <a target="_blank" href="<?php echo base_url(); ?>user/profile/<?php echo $items->use_id;?>"> <?php echo $items->use_username;?></a>
                                    <p style="font-size: 12px; color: #f57420"><i> <?php
                                            foreach($liststore as $itemshop) {
                                                if ($items->parent_shop == $itemshop->sho_user && $items->parent_shop != 0) {
                                                    echo 'Thuộc gian hàng: '.$itemshop->sho_name;
                                                }
                                            }
                                            ?></i></p>
                                </td>
                                <td width="20%" height="32" class="line_account_2">
                                    <?php echo $items->sho_name !=''? $items->sho_name: "Chưa cập nhật";?>
                                </td>
                                <td width="20%" height="32" class="line_account_2">
                                    <?php if($items->sho_name != ''){ ?>
                                        <a target="_blank" <?php if($domain != '' && $group_id == 3){ ?> href="<?php echo $protocol . $domain .'/'. $items->sho_link; ?>" <?php }elseif($domain == '' && $group_id == 3){ ?> href="<?php echo $protocol . $items->pshop .'.'. $domainName .'/'.$items->sho_link; ?>" <?php }else{ ?> href="<?php echo $protocol.$items->sho_link.'.'.$domainName; ?>" <?php } ?> >
                                            <?php echo $items->sho_name;?></a>
                                    <?php }else{ ?>
                                        Chưa cập nhật
                                    <?php } ?>
                                </td>
                                <td width="10%" height="32" class="line_account_2">
                                    <a href="mailto:<?php echo $items->use_email;?>"><?php echo $items->use_email;?></a>
                                </td>
                                <td width="10%" height="32" class="line_account_2">
                                    <?php echo $items->use_mobile; ?>
                                </td>
                                <?php if($group_id > 3 && $group_id != 11) {?>
                                    <td width="10%" height="32" class="line_account_2">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal_<?php echo $items->use_id;?>">
                                            Chọn
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal_<?php echo $items->use_id;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel_<?php echo $items->use_id;?>">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title" id="myModalLabel_<?php echo $items->use_id;?>">Chọn gian hàng</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <select name="parent_shop_id_<?php echo $items->use_id;?>" id="parent_shop_id_<?php echo $items->use_id;?>">
                                                            <option value="">--Chọn gian hàng--</option>
                                                            <?php foreach($list_shop as $itemshop){?>
                                                                <option value="<?php echo $itemshop->use_id;?>"><?php echo $itemshop->use_username;?></option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                                        <button type="button" onclick="add_parent_shop(<?php echo $items->use_id;?>);" class="btn btn-primary">Lưu lại</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                <?php }?>
                            </tr>
                        <?php }?>
                        </tbody>
                    <?php }else{?>
                        <tr>
                            <td class="text-center">
                                Không có dữ liệu!
                            </td>
                        </tr>
                    <?php }?>
                </table>
            </div>
            <?php echo $linkPage;?>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<script>
    function add_parent_shop(use_id){
        var shop_id = $('#parent_shop_id_'+use_id).val();
        if(shop_id == ''){
            errorAlert('Bạn chưa chọn gian hàng');
            return false;
        }else{
            $.ajax({
                type: "post",
                url:"<?php echo base_url(); ?>" + 'home/account/listaffiliate',
                cache: false,
                data:{use_id: use_id, parent_shop_id: shop_id},
                dataType:'text',
                success: function(data){
                    if(data == '1'){
                        $('.modal').modal('hide');
                    }else{
                        errorAlert('Có lỗi xảy ra','Thông báo');
                    }
                }
            });
        }
        return false;
    }
</script>

<?php $this->load->view('home/common/account/header'); ?>
<div class="container">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-lg-9 col-md-9 col-sm-8">
            <h2 class="page-title text-uppercase">
                Danh sách Partner có doanh thu
            </h2>
            <div class="db_table" style="overflow: auto; width:100%">
                <!-- Ẩn theo task trello ngày 12/09/2018 -->
                <!-- <form class="form-inline" action="" style="float: left;width: 100%" method="post">
                    <br>
                    <div class="form-group">
                        <label for="date1"> Lọc doanh số từ ngày: </label>
                        <input type="date" class="form-control" id="datefromshop" name="datefromshop" value="<?php echo $savedateto?>">
                    </div>
                    <div class="form-group">
                        <label for="date2"> Đến ngày: </label>
                        <input type="date" class="form-control" id="datetoshop" name="datetoshop" value="<?php echo $savedatefrom ?>">
                    </div>
                    <div class="form-group">
                        <label for="filter"></label>
                        <button type="submit" class="btn btn-primary">Thực hiện</button>
                    </div>
                </form> -->
                <div colspan="6" class="text-right detail_list" style="font-weight: 600; font-size: 15px">Tổng doanh thu các Partner:<span style="color:#F00; font-size: 15px"><b> <?php echo number_format($totalShowcart,0,",","."); ?> Đ</b></span></div>

                <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%" class="title_account_0">STT</th>
                        <th width=20%" class="title_account_2" align="center" >
                            Họ tên
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </th>
                        
                        <th width="20%" class="title_account_2" align="center" >
                            Tên đăng nhập
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </th><th width=15%" class="title_account_2" align="center" >
                            Email
                        </th>
                        <th width=15%" class="title_account_2" align="center" >
                            Số điện thoại
                        </th>
                        <th width=10%" class="title_account_2" align="center" >
                            Doanh Thu
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>doanhthu/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>doanhthu/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </th>
<!--                        <th width=15%" class="title_account_2" align="center" >-->
<!--                            Gán-->
<!--                        </th>-->
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $total = 0;
                    foreach($staffs as $key => $items)
                    { 
                        $shc = $arrshc[$items->use_id][0];
                        if($shc > 0){
                            $detailDorS = 'statisticlistPartner/prn';
                        }else{
                            $shc = $items->showcarttotal;
                            $detailDorS = 'statisticlistshop/shc';
                        }
                    ?>
                        <tr>
                            <td width="5%" height="32" class="line_account_0"><?php echo $stt++; ?></td>
                            <td width="20%" height="32" class="line_account_2">
                                <?php echo $items->use_fullname;?>
                            </td>
                            <td width="20%" height="32" class="line_account_2">
                                <?php echo $items->use_username;?>
                                <div class="shop_parent <?php if($items->userid_parent == $this->session->userdata('sessionUser')){ ?>active<?php } ?>"><i><?php echo $items->username_parent;?></i></div>
                            </td>
                            <td width="10%" height="32" class="line_account_2">
                                <?php echo $items->use_email;?>
                            </td>
                            <td width="10%" height="32" class="line_account_2">
                                <?php echo $items->use_mobile;?>
                            </td>
                            <td width="10%" height="32" class="line_account_2">
                                <?php 
                                    if(count($arrshc[$items->use_id]) > 0){
                                        $showcarttotal = $arrshc[$items->use_id][0];
                                        $total += $showcarttotal; 
                                    }else{
                                        $showcarttotal = $items->showcarttotal;
                                        $total += $items->showcarttotal; 
                                    }
                                ?>
                                <?php //$total += $items->showcarttotal;?>
                                <a  href="<?php echo base_url(); ?>account/<?php echo $detailDorS?>/<?php echo $items->use_id ?>">
                                    <span style="color: #ff0000; font-weight: 600">  <?php echo number_format($shc,0,",","."); //$items->showcarttotal?> đ</span>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    <td colspan="5" class="text-right detail_list" style="font-weight: 600; font-size: 15px">Tổng doanh thu:</td>
                    <td colspan="2" class="detail_list"><span style="color:#F00; font-size: 15px"><b><?php echo number_format($total,0,",","."); ?> Đ</b></span></td>


                    <?php if(count($staffs) <= 0){ ?>
                        <tr>
                            <td colspan="8"><div class="nojob">Không có doanh thu nào!</div></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php if(count($linkPage) > 0){ ?>
                    <tr>
                        <td colspan="8"><?php echo $linkPage;?></td>
                    </tr>
                <?php } ?>

                <!-- Modal -->
                <div class="modal fade" id="myModal_Shop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Chọn thành viên cần gán cho <span id="shop_name"></span></h4>
                            </div>
                            <div class="modal-body">
                                <select name="child_list" id="child_list">
                                    <option value="">--Chọn thành viên--</option>
                                    <?php foreach($tree_list as $itemtree){?>
                                        <option value="<?php echo $itemtree->use_id;?>"><?php echo $itemtree->use_username;?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="shop_id" id="shop_id" value="0" />
                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                <button type="button" onclick="add_shop_for_user();" class="btn btn-primary">Lưu lại</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<script>
    function add_data_hidden_field(shop_name,user_id,username){
        $('#shop_name').text(shop_name);
        $('#shop_id').val(user_id);
    }

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

<?php $this->load->view('home/common/account/header'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-xm-8 col-xs-12">
	    <h4 class="page-header text-uppercase" style="margin-top:10px">Danh sách Gian hàng <?php echo $text ?></h4>
            <!-- Ẩn theo task trello ngày 12/09/2018 -->
            <!-- <div class="panel panel-default">
                <div class="panel-body form-inline">
                    <form class="form-inline" action="" style="float: left;width: 100%" method="post">                   
                        <div class="form-group">
                            <label for="date1"> Lọc doanh số từ ngày: </label>
                            <input type="date" class="form-control" id="datefromshop" name="datefromshop" value="<?php echo $savedateto ?>">
                        </div>
                        <div class="form-group">
                            <label for="date2"> Đến ngày: </label>
                            <input type="date" class="form-control" id="datetoshop" name="datetoshop" value="<?php echo $savedatefrom ?>">
                        </div>
                        <div class="form-group">
                            <label for="filter"></label>
                            <button type="submit" class="btn btn-azibai">Thực hiện</button>
                        </div>
                    </form>
                </div>
            </div> -->
            <div class="table-responsive">
                
                <div colspan="6" class="text-right detail_list" style="font-weight: 600; font-size: 15px">Tổng doanh thu các gian hàng:<span style="color:#F00; font-size: 15px"><b> <?php echo number_format($total_sum,0,",","."); ?>đ</b></span></div>

                <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%" class="title_account_0">STT</th>

                        <th width="20%" class="title_account_2" align="center" >
                            Gian hàng
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>nameshop/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>nameshop/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </th>

                        <th width="20%" class="title_account_2" align="center">Tên đăng nhập
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" />
                        </th>

                        <th width="20%" class="title_account_2" align="center" >
                            Họ tên
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/asc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                            <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/desc<?php echo $pageSort; ?>')" border="0" style="cursor:pointer;" alt="" />
                        </th>

                        <th width="15%" class="title_account_2" align="center" >
                            Email / Số điện thoại
                        </th>

                        <th width="10%" class="title_account_2" align="center" >
                            Doanh Thu
                        </th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $total = 0;
                    foreach($staffs as $key => $items) {
                    $showcarttotal = 0;
                    ?>
                        <tr>
                            <td width="5%" height="32" class="line_account_0"><?php echo $stt++; ?></td>
                            <td width="20%" height="32" class="line_account_2">
                                <a href="<?php echo $linkGH[$key]['link_gh'];?>/shop" target="_blank"> 
                                    <?php echo $items->sho_name; ?>
                                </a>
                            </td>
                            <td width="20%" height="32" class="line_account_2">                                
                                <?php echo $items->use_username; ?>                               
                                <div class="shop_parent <?php if($items->userid_parent == $this->session->userdata('sessionUser')){ ?> active <?php } ?>">
                                    <i><?php echo $items->username_parent; ?></i>
                                </div>
                            </td>
                            <td width="20%" height="32" class="line_account_2">
                                <?php if($items->use_fullname != '') echo $items->use_fullname; else echo 'Chưa cập nhật'; ?>
                            </td>
                            <td width="10%" height="32" class="line_account_2">
                                <?php echo $items->use_email; ?>
                                <p><?php echo $items->use_mobile; ?></p>
                            </td>                            
                            <td width="10%" height="32" class="line_account_2">
                                <?php                                     
                                    $showcarttotal = $money[$items->use_id];
                                    $total += $showcarttotal;
                                ?>
                                <a  href="<?php echo base_url(); ?>account/detailstatisticlistshop/<?php echo $items->use_id ?>">
                                    <span style="color: #ff0000; font-weight: 600">  <?php echo number_format($showcarttotal,0,",",".");?> </span> đ
                                </a>
                            </td>
                        </tr>
                    <?php }?>
                    <td colspan="5" class="text-right detail_list" style="font-weight: 600; font-size: 15px">Tổng doanh thu:</td>
                    <td colspan="2" class="detail_list"><span style="color:#F00; font-size: 15px"><b><?php echo number_format($total,0,",","."); ?></b></span> đ</td>


                    <?php if(count($staffs) <= 0){ ?>
                        <tr>
                            <td colspan="7"><div class="nojob">Không có doanh thu nào!</div></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php if(count($linkPage) > 0){ ?>
                    <tr>
                        <td colspan="7"><?php echo $linkPage;?></td>
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
                                <button type="button" onclick="add_shop_for_user();" class="btn btn-azibai">Lưu lại</button>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                
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

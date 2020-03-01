<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px">
               đơn hàng của chi nhánh
            </h4>
            <div class="db_table" style="overflow: auto; width:100%">


                <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <thead>
                    <tr>
                        <th width="5%" class="title_account_0">STT</th>
                        <!--<th width="20%" class="title_account_2" align="center">
                            Chi nhánh
                            <img src="<?php /*echo base_url(); */?>templates/home/images/sort_asc.gif"
                                 onclick="ActionSort('<?php /*echo $sortUrl; */?>nameshop/by/asc<?php /*echo $pageSort; */?>')"
                                 border="0" style="cursor:pointer;" alt=""/>
                            <img src="<?php /*echo base_url(); */?>templates/home/images/sort_desc.gif"
                                 onclick="ActionSort('<?php /*echo $sortUrl; */?>nameshop/by/desc<?php /*echo $pageSort; */?>')"
                                 border="0" style="cursor:pointer;" alt=""/>
                        </th>
                        -->
                        <th width="20%" class="title_account_2" align="center">
                            Tên đăng nhập
                        </th>
                        <th width=25%" class="title_account_2" align="center">
                            Họ tên
                        </th>
                        <th width=15%" class="title_account_2" align="center">
                            Email - Số điện thoại
                        </th>
                        <th width=10%" class="title_account_2" align="center">
                            Xem đơn hàng
                    </tr>
                    </thead>
                    <tbody>

                    <?php
                    $count = 0;
                    foreach ($liststoreAF as $key => $items) {
                        $params = array(
                            'select' => 'tbtt_user.use_fullname',
                            'shc_saler' => $items['use_id'],
                            'pro_type' => '0,2'
                        );
                        $result = $this->order_model->list_order_by_id_shop($params, '');
                        if(count($result)>0) {
                            $count = 1;
                            ?>
                            <tr>
                                <td width="5%" height="32" class="line_account_0"><?php echo ++$stt; ?></td>
                                <td width="15%" height="32" class="line_account_2">
                                    <a target="_blank"
                                       href="<?php echo base_url(); ?>user/profile/<?php echo $items['use_id']; ?>">
                                        <?php echo $items['use_username']; ?></a>
                                    <div class="shop_parent active" style="color: orangered !important; font-size: 12px;">
<!--                                        <a target="_blank" href="<?php echo base_url(); ?>user/profile/<?php echo $items['parent_id']; ?>">-->
                                            <i><?php echo $items['info_parent']; ?></i>
<!--                                        </a>-->
                                    </div>
                                </td>
                                <td width="20%" height="32" class="line_account_2">
                                    <?php echo $items['use_fullname'] != '' ? $items['use_fullname'] : "Chưa cập nhật"; ?>
                                </td>
                                <td width="20%" height="32" class="line_account_2">
                                    <i class="fa fa-envelope-o fa-fw"></i>
                                    <a href="mailto:<?php echo $items['use_email']; ?>"><?php echo $items['use_email']; ?></a>
                                    <br/>
                                    <i class="fa fa-phone fa-fw"></i><?php echo $items['use_mobile']; ?>
                                </td>
                                <td width="10%" height="32" class="line_account_2">
                                    <a href="<?php echo base_url(); ?>account/bran_order/<?php echo $items['use_id']; ?>"
                                       target="_blank"
                                       class="left_menu">Xem</a>
                                </td>
                            </tr>
                            <?php
                        }
                    } ?>

                    <?php if ($count == 0) { ?>
                        <tr>
                            <td colspan="8">
                                <div class="nojob">Không có đơn hàng nào!</div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php if (count($linkPage) > 0) { ?>
                    <tr>
                        <td colspan="8"><?php echo $linkPage; ?></td>
                    </tr>
                <?php } ?>

                <!-- Modal -->
                <div class="modal fade" id="myModal_Shop" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                        aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Chọn thành viên cần gán cho <span
                                        id="shop_name"></span></h4>
                            </div>
                            <div class="modal-body">
                                <select name="child_list" id="child_list">
                                    <option value="">--Chọn thành viên--</option>
                                    <?php foreach ($tree_list as $itemtree) { ?>
                                        <option
                                            value="<?php echo $itemtree->use_id; ?>"><?php echo $itemtree->use_username; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="shop_id" id="shop_id" value="0"/>
                                <button type="button" class="btn btn-default" data-dismiss="modal">Hủy</button>
                                <button type="button" onclick="add_shop_for_user();" class="btn btn-primary">Lưu lại
                                </button>
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
    function add_data_hidden_field(shop_name, user_id, username) {
        $('#shop_name').text(shop_name);
        $('#shop_id').val(user_id);
    }

    function add_shop_for_user() {
        if ($('#child_list').val() != '') {
            use_id = $('#child_list').val();
            shop_id = $('#shop_id').val();
            $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + 'account/tree/store',
                cache: false,
                data: {use_id: use_id, shop_id: shop_id},
                dataType: 'text',
                success: function (data) {
                    if (data == '1') {
                        alert("Cập nhật thành công!");
                        $('.modal').modal('hide');
                        location.reload();
                    } else {
                        errorAlert('Có lỗi xảy ra', 'Thông báo');
                    }
                }
            });
        } else {
            alert("Vui lòng chọn thành viên cần gán!");
        }
        return false;
    }
</script>

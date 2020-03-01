<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
    <tr>
        <td valign="top">
            <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="2"></td>
                    <td width="10" class="left_main" valign="top"></td>
                    <td align="center" valign="top">
                        <!--BEGIN: Main-->
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td height="10"></td>
                            </tr>
                            <tr>
                                <td>
                                    <script type="text/javascript">
                                        function addEditBox(id) {
                                            var html = '';
                                            html += '<input id="amount_' + id + '" type="text" value="" placeholder="Nhập số tiền..." />&nbspVND&nbsp;&nbsp;<button class="btn btn-default" type="button" onclick="requestPayment(' + id + ', this);" title="Yêu cầu chuyển khoản">YCCK</button>&nbsp;<button class="btn btn-default" type="button" onclick="cancelAcction(' + id + ');" title="Hủy">Hủy</button>';
                                            $('#row_' + id + ' .rowAction').html(html);
                                        }
                                        function cancelAcction(id) {
                                            var html = '';
                                            html += '<button class="btn btn-default" type="button" onclick="addEditBox(' + id + ');" title="Yêu cầu chuyển khoản">YCCK</button>';
                                            $('#row_' + id + ' .rowAction').html(html);
                                        }
                                        function requestPayment(id, item) {

                                            if ($(item).hasClass('processing')) {
                                                alert('Đang xử lý...');
                                            } else {

                                                var text = 'Bạn muốn tạo yêu cầu chuyển khoản';
                                                var amount = $('#amount_' + id).val();

                                                if (amount <= 0) {
                                                    alert('Yêu cầu không hợp lệ');
                                                    return;
                                                }
                                                var r = confirm(text);
                                                if (r == true) {
                                                    $(item).addClass('processing');
                                                    jQuery.ajax({
                                                        type: "POST",
                                                        url: '<?php echo base_url();?>' + "administ/account/request",
                                                        dataType: 'json',
                                                        data: {uid: id, amount: amount},
                                                        success: function (res) {
                                                            $(item).removeClass('processing');
                                                            if (res.error == false) {
                                                                $('#row_' + id).find('.amount').text(res.amount_text);
                                                                cancelAcction(id);
                                                                alert(res.message);
                                                            } else {
                                                                alert(res.message);
                                                            }

                                                        }
                                                    });
                                                } else {
                                                    $(item).removeClass('processing');
                                                }


                                            }
                                        }
                                        function updatePayment(id, status, item) {
                                            if ($(item).hasClass('processing')) {
                                                alert('Đang xử lý...');
                                            } else {
                                                var text = '';

                                                switch (status) {
                                                    case 1:
                                                        text = 'Bạn muốn tạo yêu cầu thanh toán?';
                                                        break;
                                                    case 2:
                                                        text = 'Bạn muốn xác nhận thanh toán?';
                                                        break;
                                                    case 9:
                                                        text = 'Bạn muốn hủy yêu cầu thanh toán?';
                                                        break;
                                                }
                                                var r = confirm(text);
                                                if (r == true) {
                                                    $(item).addClass('processing');
                                                    jQuery.ajax({
                                                        type: "POST",
                                                        url: '<?php echo base_url();?>' + "administ/account/update",
                                                        dataType: 'json',
                                                        data: {id: id, status: status},
                                                        success: function (res) {
                                                            $(item).removeClass('processing');
                                                            if (res.error == false) {
                                                                $('#row_' + id).remove();

                                                                alert('Đã xác nhận');
                                                            } else {
                                                                alert(res.message);
                                                            }

                                                        }
                                                    });
                                                } else {
                                                    $(item).removeClass('processing');
                                                }

                                            }

                                        }
                                    </script>
                                    <!--BEGIN: Item Menu-->
                                    <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td width="5%" height="67" class="item_menu_left">
                                                <a href="<?php echo base_url(); ?>administ/account">
                                                    <img
                                                        src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png"
                                                        border="0"/>
                                                </a>
                                            </td>
                                            <td width="40%" height="67"
                                                class="item_menu_middle"><?php echo "Quản lý thanh toán"; ?> <?php if($_REQUEST['group_id'] == 3){ echo "Gian hàng ( Thứ 4 hàng tuần )"; } ?></td>
                                            <td width="55%" height="67" class="item_menu_right">
                                                <a href="javascript:void(0);"
                                                   onclick="$('#adminForm').find('input[name=excel]').val(1); $('#adminForm').submit();$('#adminForm').find('input[name=excel]').val(0);">Excel</a>&nbsp;&nbsp;&nbsp;
                                                <?php if (false): ?>
                                                    <div class="icon_item" id="icon_item_1"
                                                         onclick="ActionDelete('frmUser')"
                                                         onmouseover="ChangeStyleIconItem('icon_item_1',1)"
                                                         onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                                                        <table width="100%" height="100%" align="center" border="0"
                                                               cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td align="center">
                                                                    <img
                                                                        src="<?php echo base_url(); ?>templates/admin/images/icon_delete.png"
                                                                        border="0"/>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text_icon_item"
                                                                    nowrap="nowrap"><?php echo $this->lang->line('delete_tool'); ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="icon_item" id="icon_item_2"
                                                         onclick="ActionLink('<?php echo base_url(); ?>administ/user/add')"
                                                         onmouseover="ChangeStyleIconItem('icon_item_2',1)"
                                                         onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                                                        <table width="100%" height="100%" align="center" border="0"
                                                               cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td align="center">
                                                                    <img
                                                                        src="<?php echo base_url(); ?>templates/admin/images/icon_add.png"
                                                                        border="0"/>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text_icon_item"
                                                                    nowrap="nowrap"><?php echo $this->lang->line('add_tool'); ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </table>
                                    <!--END Item Menu-->
                                </td>
                            </tr>
                            <tr>
                                <td height="10"></td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <!--BEGIN: Search-->
                                    <form id="adminForm" action="<?php echo $link; ?>" method="post" class="">
                                        <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                                        <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
                                        <input type="hidden" name="excel" id="excel" autocomplete="off" value="0"/>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="160" align="left">
                                                    <input class="input_search" type="text" name="q"
                                                           value="<?php echo $filter['q']; ?>"
                                                           placeholder="...">
                                                </td>
                                                <td width="120" align="left">
                                                    <select name="qt" autocomplete="off" class="select_search">
                                                        <option value="">-Tìm kiếm theo-</option>
                                                        <?php foreach ($types as $key => $val): ?>
                                                            <option
                                                                value="<?php echo $key; ?>" <?php if ($filter['qt'] == $key) {
                                                                echo 'selected="selected"';
                                                            } ?>><?php echo $val; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td width="120" align="left">

                                                    <select name="group_id" autocomplete="off" class="select_search">
                                                        <option value="">Nhóm thành viên</option>
                                                        <?php foreach ($groups as $val): ?>

                                                            <?php if(in_array($val['gro_id'],array(2,3,6,7,8,9,10,12))) : ?>

                                                                    <option
                                                                        value="<?php echo $val['gro_id']; ?>" <?php if ($filter['group_id'] == $val['gro_id']) {
                                                                        echo 'selected="selected"';
                                                                    } ?>><?php echo $val['gro_name']; ?></option>

                                                                <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td align="left">
                                                    &nbsp;&nbsp;&nbsp;<input
                                                        class="searchBt" type="submit" value=""/>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" id="store" class="btn-store btn-store-primary"> Quản lý gian hàng</a>
                                                </td>
                                                <!---->

                                                <?php if($_REQUEST['group_id'] == 3){ ?>
                                                <td width="115" align="left">

                                                    <select id="dayofweek" name="dayofweek" autocomplete="off" class="select_search">
                                                        <?php foreach ($arrWedDay as $key => $val):
                                                            if(strtotime(date("Y",time())."-".date("m",time())."-".date("d",time())) < strtotime($val)  ){
                                                                continue;
                                                            }
                                                            ?>
                                                        <option value="<?php echo $val; ?>" <?php if ($_REQUEST['dayofweek'] == $val){ echo 'selected="selected"';}?>>Thứ Tư ngày <?php echo date("d/m/Y",strtotime($val)); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>

                                                    <td width="30">
                                                        &nbsp;
                                                    </td>
                                                <?php
                                                }
                                                ?>

                                                <td width="115" align="left">

                                                    <select id="month" name="month" autocomplete="off" class="select_search">
                                                        <option value="01" <?php if ($_REQUEST['month'] == "01"){ echo 'selected="selected"';}?>>Tháng 1</option>
                                                        <option value="02" <?php if ($_REQUEST['month'] == "02"){ echo 'selected="selected"';}?>>Tháng 2</option>
                                                        <option value="03" <?php if ($_REQUEST['month'] == "03"){ echo 'selected="selected"';}?>>Tháng 3</option>
                                                        <option value="04" <?php if ($_REQUEST['month'] == "04"){ echo 'selected="selected"';}?>>Tháng 4</option>
                                                        <option value="05" <?php if ($_REQUEST['month'] == "05"){ echo 'selected="selected"';}?>>Tháng 5</option>
                                                        <option value="06" <?php if ($_REQUEST['month'] == "06"){ echo 'selected="selected"';}?>>Tháng 6</option>
                                                        <option value="07" <?php if ($_REQUEST['month'] == "07"){ echo 'selected="selected"';}?>>Tháng 7</option>
                                                        <option value="08" <?php if ($_REQUEST['month'] == "08"){ echo 'selected="selected"';}?>>Tháng 8</option>
                                                        <option value="09" <?php if ($_REQUEST['month'] == "09"){ echo 'selected="selected"';}?>>Tháng 9</option>
                                                        <option value="10" <?php if ($_REQUEST['month'] == "10"){ echo 'selected="selected"';}?>>Tháng 10</option>
                                                        <option value="11" <?php if ($_REQUEST['month'] == "11"){ echo 'selected="selected"';}?>>Tháng 11</option>
                                                        <option value="12" <?php if ($_REQUEST['month'] == "12"){ echo 'selected="selected"';}?>>Tháng 12</option>

                                                    </select>
                                                </td>
                                                <td width="115" align="left">
                                                    <select name="status" autocomplete="off" class="select_search">
                                                        <?php foreach ($status as $key => $val): ?>
                                                            <option
                                                                value="<?php echo $key; ?>" <?php if (isset($filter['status']) && $filter['status'] == $key) {
                                                                echo 'selected="selected"';
                                                            }elseif(!isset($filter['status']) && $key == 1){  echo 'selected="selected"';} ?>><?php echo $val; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                                <td width="25" align="right">
                                                    <input id="search_status" class="searchBt" type="submit" value=""/>
                                                </td>
                                            </tr>
                                        </table>
                                    </form>
                                    <!--END Search-->
                                </td>
                            </tr>
                            <tr>
                                <td height="5"></td>
                            </tr>
                            <form name="frmUser" method="post">
                                <tr>
                                    <td>
                                        <!--BEGIN: Content-->
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="1%" class="title_list">STT</td>
                                                <td width="10%" class="title_list">
                                                    Họ và tên
                                                </td>
                                                <td width="10%" class="title_list">
                                                    <?php echo $this->lang->line('username_list'); ?>
                                                </td>
                                                <td width="20%" class="title_list">
                                                    Thông tin cá nhân
                                                </td>
                                                <td class="title_list" width="25%">
                                                    Tài khoản ngân hàng
                                                </td>
                                                <td width="9%" class="title_list">
                                                    <?php echo $this->lang->line('group_list'); ?>
                                                    <a href="<?php echo $sort['group']['asc']; ?>">
                                                        <img
                                                            src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                                            border="0"
                                                            style="cursor:pointer;" alt=""/>
                                                    </a>
                                                    <a href="<?php echo $sort['group']['desc']; ?>">
                                                        <img
                                                            src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                                            border="0"
                                                            style="cursor:pointer;" alt=""/>
                                                    </a>
                                                </td>
                                                <td width="15%" class="title_list">
                                                    Số tiền
                                                    <a href="<?php echo $sort['amount']['asc']; ?>">
                                                        <img
                                                            src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                                            border="0"
                                                            style="cursor:pointer;" alt=""/>
                                                    </a>
                                                    <a href="<?php echo $sort['amount']['desc']; ?>">
                                                        <img
                                                            src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                                            border="0"
                                                            style="cursor:pointer;" alt=""/>
                                                    </a>
                                                </td>
                                                <td width="8%" class="title_list"></td>
                                                <td width="2%" class="title_list">ID</td>
                                            </tr>
                                            <!---->
                                            <?php $idDiv = 1;
                                            $kk = 0; ?>
                                            <?php foreach ($accounts as $k => $item) {
                                                ?>
                                                <tr style="background:<?php if ($k % 2 == 0) {
                                                    echo '#F7F7F7';
                                                } else {
                                                    echo '#FFF';
                                                } ?>;" id="row_<?php echo $item['user_id']; ?>"
                                                    onmouseover="ChangeStyleRow('row_<?php echo $item['user_id']; ?>',<?php echo $item['user_id']; ?>,1)"
                                                    onmouseout="ChangeStyleRow('row_<?php echo $item['user_id']; ?>',<?php echo $item['user_id']; ?>,2)">
                                                    <td class="detail_list" style="text-align:center;">
                                                        <b><?php echo $num + $k + 1; ?></b></td>
                                                    <td class="detail_list">
                                                        <?php
                                                        if (isset($item['use_info'])) {
                                                            $tmp = explode('||', $item['use_info']);
                                                            foreach ($tmp as $info) {
                                                                $tmp1 = explode(':', $info);
                                                                $item[trim($tmp1[0])] = $tmp1[1];
                                                            }
                                                        }
                                                        ?>
                                                        <a href="<?php echo base_url() . 'administ/account/detail/' . $item['user_id']; ?>">
                                                            <?php echo $item['use_fullname']; ?>
                                                        </a>
                                                    </td>
                                                    <td class="detail_list">
                                                        <?php
                                                        if (isset($item['use_info'])) {
                                                            $tmp = explode('||', $item['use_info']);
                                                            foreach ($tmp as $info) {
                                                                $tmp1 = explode(':', $info);
                                                                $item[trim($tmp1[0])] = $tmp1[1];
                                                            }
                                                        }
                                                        ?>
                                                        <a href="<?php echo base_url() . 'administ/user/edit/' . $item['user_id']; ?>">
                                                            <?php echo $item['use_username']; ?>
                                                        </a>
                                                    </td>
                                                    <td class="detail_list">
                                                        <?php
                                                        if (isset($item['use_info'])) {
                                                            $tmp = explode('||', $item['use_info']);
                                                            foreach ($tmp as $info) {
                                                                $tmp1 = explode(':', $info);
                                                                $item[trim($tmp1[0])] = $tmp1[1];
                                                            }
                                                        }
                                                        ?>
                                                        <p>
                                                           <b>Địa chỉ:</b> <?php echo $item['use_address']; ?>
                                                        </p>
                                                        <p>
                                                          <b>Email:</b> <?php echo $item['use_email']; ?>
                                                        </p>
                                                        <p>
                                                            <b>Điện thoại:</b> <?php echo $item['use_mobile']; ?>
                                                        </p>
                                                    </td>
                                                    <td class="detail_list">
                                                        Ngân hàng: <?php echo $item['bank_name']; ?>
                                                        , <?php echo $item['bank_add']; ?><br/>
                                                        Tên: <?php echo $item['account_name']; ?><br/>
                                                        Số TK: <?php echo $item['num_account']; ?>
                                                    </td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <?php if ($item['group_id'] == 4){ ?>
                                                        <span style="color:#F00; font-weight:bold;">
                                                            <?php }elseif ($item['use_group'] == 3){ ?>
                                                            <span style="color:#009900; font-weight:bold;">
                                                            <?php }elseif ($item['use_group'] == 2){ ?>
                                                                <span style="color:#06F; font-weight:bold;">
                                                            <?php }else{ ?>
                                                                    <span style="font-weight:normal;">
                                                            <?php } ?>
                                                            <?php echo $item['gro_name']; ?>
											            </span>
                                                    </td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <font color="#FF0000"><b
                                                                class="amount"><?php echo number_format(abs($item['amount'])) . ' VNĐ' ?></b></font>
                                                    </td>
                                                    <td class="detail_list">
                                                        <?php switch($filter['status']){
                                                            case 0:
                                                                //echo '<button title="Yêu cầu chuyển khoản" onclick="updatePayment('. $item['id'].', 1, this);" type="button" class="btn btn-default">YCCK</button>';
                                                                break;
                                                            case 1:
                                                                echo '<button title="Xác nhận chuyển khoản" onclick="updatePayment('. $item['id'].', 2, this);" type="button" class="btn btn-success"><i class="fa fa-check"></i></button> <button title="Hủy yêu cầu chuyển khoản" onclick="updatePayment('. $item['id'].', 9, this);" type="button" class="btn btn-danger"><i class="fa fa-times"></i></button>';
                                                                break;
                                                        }?>
                                                    </td>
                                                    <td class="detail_list">
                                                        <?php echo $item['user_id']; ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                            <!---->
                                            <?php if (empty($accounts)): ?>
                                                <tr>
                                                    <td class="show_page" colspan="10" align="center"><b style="color: red;">Không có
                                                            dữ liệu</b></td>
                                                </tr>
                                            <?php endif; ?>
                                            <tr>
                                                <td class="show_page" colspan="10"><?php echo $pager; ?></td>
                                            </tr>
                                        </table>
                                        <!--END Content-->
                                    </td>
                                </tr>
                            </form>
                        </table>
                        <!--END Main-->
                    </td>
                    <td width="10" class="right_main" valign="top"></td>
                    <td width="2"></td>
                </tr>
                <tr>
                    <td width="2" height="11"></td>
                    <td width="10" height="11" class="corner_lb_main" valign="top"></td>
                    <td height="11" class="middle_bottom_main"></td>
                    <td width="10" height="11" class="corner_rb_main" valign="top"></td>
                    <td width="2" height="11"></td>
                </tr>
            </table>
        </td>
    </tr>
<?php $this->load->view('admin/common/footer'); ?>
<script type="text/javascript" language="javascript" >
    jQuery("#store").click(function(){
        jQuery(".select_search[name=group_id]").val(3);
        jQuery(".select_search[name=status]").val(1);
        var abc = jQuery(".select_search[name=dayofweek]").val();
        jQuery("#adminForm").submit();
    });
    jQuery("#month").change(function(){
        jQuery("#dayofweek option").attr("value","");
    });
    <?php if (!isset($filter['status'])) {?>
   /* $(function(){
        $('#search_status').trigger('click');
    });*/
    <?php } ?>
</script>
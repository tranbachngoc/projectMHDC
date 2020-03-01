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
                                        function updatePayment(id, status, item){
                                            if($(item).hasClass('processing')){
                                                alert('Đang xử lý...');
                                            }else{
                                                var text = '';

                                                switch (status){
                                                    case 2:
                                                        text = 'Bạn đã tiến hành chuyển khoản cho thanh toán này?';
                                                        break;
                                                    case 6:
                                                        text = 'Bạn đang xử lý giao dịch này?';
                                                        break;
                                                    case 8:
                                                        text = 'Bạn muốn hoàn tất thanh toán?';
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
                                                                 switch(status){
                                                                     case 2:
                                                                         $('#row_'+id).find('.rowAction').html('Ðã cập nhật.');
                                                                         break;
                                                                     case 6:
                                                                         $('#row_'+id).find('.rowAction').html('Ðã cập nhật.');
                                                                         break;
                                                                     case 8:
                                                                         $('#row_'+id).find('.rowAction').html('Ðã cập nhật.');
                                                                         break;
                                                                     case 9:
                                                                         $('#row_'+id).find('.rowAction').html('Ðã hủy.');
                                                                         break;
                                                                 }
                                                                 //$('#row_'+id).remove();
                                                                alert('Đã xác nhận');
                                                             }else{
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
                                                    <img src="<?php echo base_url(); ?>templates/home/images/icon/contact-icon.png" border="0" />
                                                </a>
                                            </td>
                                            <td width="40%" height="67" class="item_menu_middle"><?php echo "Quản lý thanh toán"; ?>

                                            </td>
                                            <td width="55%" height="67" class="item_menu_right">
                                                <a href="javascript:void(0);" onclick="$('#adminForm').find('input[name=excel]').val(1); $('#adminForm').submit();">Excel</a>&nbsp;&nbsp;&nbsp;
                                                <?php if(false):?>
                                                    <div class="icon_item" id="icon_item_1" onclick="ActionDelete('frmUser')" onmouseover="ChangeStyleIconItem('icon_item_1',1)" onmouseout="ChangeStyleIconItem('icon_item_1',2)">
                                                        <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td align="center">
                                                                    <img src="<?php echo base_url(); ?>templates/admin/images/icon_delete.png" border="0" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('delete_tool'); ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                    <div class="icon_item" id="icon_item_2" onclick="ActionLink('<?php echo base_url(); ?>administ/user/add')" onmouseover="ChangeStyleIconItem('icon_item_2',1)" onmouseout="ChangeStyleIconItem('icon_item_2',2)">
                                                        <table width="100%" height="100%" align="center" border="0" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td align="center">
                                                                    <img src="<?php echo base_url(); ?>templates/admin/images/icon_add.png" border="0" />
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text_icon_item" nowrap="nowrap"><?php echo $this->lang->line('add_tool'); ?></td>
                                                            </tr>
                                                        </table>
                                                    </div>
                                                <?php endif;?>
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
                                    <form  id="adminForm" action="<?php echo $link; ?>" method="post" class="">
                                        <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                                        <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
                                        <input type="hidden" name="excel" id="excel" value="0"/>
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="700" align="left">
                                                    Thành viên: <b><?php echo $user['use_fullname'];?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    Số dư tài khoản: <b><?php echo number_format($user['havingAmount']).' VND';?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    Đang yêu cầu thanh toán: <b><?php echo number_format(abs($user['bankingAmount'])).' VND';?></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <br />
                                                    Ngân hàng: <?php echo $user['bank_name'];?>, <?php echo $user['bank_add'];?><br />
                                                    Tên: <?php echo $user['account_name'];?><br />
                                                    Số TK: <?php echo $user['num_account'];?>

                                                </td>

                                                <td align="left">

                                                </td>

                                                <!---->
                                                <td width="120" align="left" valign="top">
                                                    <?php if($filter['status'] == 0):?>
                                                    <select name="ctype" autocomplete="off" class="select_search">
                                                        <option value="">-Tất cả-</option>
                                                        <?php foreach($ctypes as $key=>$val):?>
                                                            <option value="<?php echo $val['id'];?>" <?php if ($filter['ctype'] == $val['id']){ echo 'selected="selected"';}?>><?php echo $val['text'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                    <?php endif;?>

                                                </td>
                                                <td width="115" align="left" valign="top">

                                                    <select name="status" autocomplete="off" class="select_search">
                                                        <?php foreach($status as $key=>$val):?>
                                                            <option value="<?php echo $key;?>" <?php if ($filter['status'] == $key){ echo 'selected="selected"';}?>><?php echo $val;?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </td>
                                                <td width="25" align="right" valign="top">
                                                    <input
                                                        class="searchBt" type="submit" value=""/>
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
                                                <td width="25" class="title_list">STT</td>


                                                <td width="150" class="title_list">
                                                    Số tiền
                                                    <a href="<?php echo $sort['amount']['asc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                    <a href="<?php echo $sort['amount']['desc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                </td>
                                                <td width="300" class="title_list">Ghi chú</td>
                                                <td width="125" class="title_list">
                                                    Ngày tạo
                                                    <a href="<?php echo $sort['created_date']['asc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                    <a href="<?php echo $sort['created_date']['desc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                </td>
                                                <td width="100" class="title_list">Trạng thái</td>

                                                <td width="150" class="title_list"></td>
                                                <td width="50" class="title_list">ID</td>

                                            </tr>
                                            <!---->
                                            <?php $idDiv = 1; $kk = 0; ?>
                                            <?php foreach($accounts as $k=>$item){ ?>
                                                <tr style="background:<?php if($k % 2 == 0){echo '#F7F7F7';}else{echo '#FFF';} ?>;" id="row_<?php echo $item['id']; ?>" onmouseover="ChangeStyleRow('row_<?php echo $item['id']; ?>',<?php echo $item['id']; ?>,1)" onmouseout="ChangeStyleRow('row_<?php echo $item['id']; ?>',<?php echo $item['id']; ?>,2)">
                                                    <td class="detail_list" style="text-align:center;"><b><?php echo $num + $k +1; ?></b></td>


                                                    <td class="detail_list" style="text-align:center;">
                                                        <font color="#FF0000"><b><?php echo number_format(abs($item['amount'])).' VNĐ'?></b></font>

                                                    </td>
                                                    <td class="detail_list" ><?php echo $item['description'];?></td>
                                                    <td class="detail_list" ><?php echo $item['created'];?></td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <?php foreach($status as $key=>$val){
                                                            if($key == $item['status']){
                                                                echo $val;
                                                                break;
                                                            }
                                                        }?>
                                                    </td>

                                                    <td class="detail_list rowAction" style="text-align:center;">
                                                        <?php switch($item['status']){
                                                            case 0:
                                                                //echo '<button title="Yêu cầu chuyển khoản" onclick="updatePayment('. $item['id'].', 1, this);" type="button" class="btn btn-default">YCCK</button>';
                                                                break;
                                                            case 1:
                                                                echo '<button title="Tiến hành chuyển khoản" onclick="updatePayment('. $item['id'].', 2, this);" type="button" class="btn btn-default">THCK</button><button title="Hủy yêu cầu chuyển khoản" onclick="updatePayment('. $item['id'].', 9, this);" type="button" class="btn btn-default">Hủy YCCK</button>';
                                                                break;
                                                            case 3:
                                                                echo '<button title="Đang xử lý" onclick="updatePayment('. $item['id'].', 6, this);" type="button" class="btn btn-default">Xử lí</button>';
                                                                break;
                                                            case 6:
                                                                echo '<button title="Hoàn tất" onclick="updatePayment('. $item['id'].', 8, this);" type="button" class="btn btn-default">THCK</button><button title="Hủy yêu cầu chuyển khoản" onclick="updatePayment('. $item['id'].', 9, this);" type="button" class="btn btn-default">Hủy YCCK</button>';
                                                                break;
                                                        }?>
                                                    </td>
                                                    <td class="detail_list" >
                                                        <?php echo $item['id'];?>
                                                    </td>

                                                </tr>

                                            <?php } ?>
                                            <!---->
                                            <?php if(empty($accounts)):?>
                                                <tr>
                                                    <td class="show_page" colspan="8"><b style="color: red;">Không có dữ liệu</b></td>
                                                </tr>
                                            <?php endif;?>
                                            <tr>
                                                <td class="show_page" colspan="8"><?php echo $pager; ?></td>
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
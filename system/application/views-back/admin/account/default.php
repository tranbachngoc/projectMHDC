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
                                                    case 1:
                                                        text = 'Bạn muốn tạo yêu cầu thanh toán?';
                                                        break;
                                                    case 2:
                                                        text = 'Bạn muốn xác nhận thanh toán?';
                                                        break;
                                                    case 3:
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
                                                                 $('#row_'+id).remove();
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
                                            <td width="40%" height="67" class="item_menu_middle"><?php echo "Quản lý thanh toán"; ?></td>
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
                                    <form id="adminForm" action="<?php echo $link; ?>" method="post" class="">
                                        <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                                        <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
                                        <input type="hidden" name="excel" id="excel" value="0"/>

                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td width="160" align="left">
                                                    <input class="input_search" type="text" name="q" value="<?php echo $filter['q']; ?>"
                                                           placeholder="...">
                                                </td>
                                                <td width="120" align="left">
                                                    <select name="qt" autocomplete="off" class="select_search">
                                                        <option value="">-Tìm kiếm theo-</option>
                                                        <?php foreach($types as $key=>$val):?>
                                                            <option value="<?php echo $key;?>" <?php if ($filter['qt'] == $key){ echo 'selected="selected"';}?>><?php echo $val;?></option>

                                                        <?php endforeach;?>
                                                    </select>
                                                </td>
                                                <td width="120" align="left">
                                                    <select name="group_id" autocomplete="off" class="select_search">
                                                        <option value="">Nhóm thành viên</option>
                                                        <?php foreach($groups as $val):?>
                                                            <option value="<?php echo $val['gro_id'];?>" <?php if ($filter['group_id'] == $val['gro_id']){ echo 'selected="selected"';}?>><?php echo $val['gro_name'];?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </td>
                                                <td align="left">
                                                    <input
                                                        class="searchBt" type="submit" value=""/>
                                                </td>
                                                <!---->


                                                <td width="115" align="left">

                                                    <select name="status" autocomplete="off" class="select_search">
                                                        <?php foreach($status as $key=>$val):?>
                                                            <option value="<?php echo $key;?>" <?php if ($filter['status'] == $key){ echo 'selected="selected"';}?>><?php echo $val;?></option>
                                                        <?php endforeach;?>
                                                    </select>
                                                </td>
                                                <td width="25" align="right">
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

                                                <td class="title_list">
                                                    <?php echo $this->lang->line('username_list'); ?>

                                                </td>

                                                <td width="200" class="title_list">
                                                    <?php echo $this->lang->line('group_list'); ?>
                                                    <a href="<?php echo $sort['group']['asc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                    <a href="<?php echo $sort['group']['desc']; ?>">
                                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                                             style="cursor:pointer;" alt=""/>
                                                    </a>
                                                </td>
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
                                                <td width="200" class="title_list">Ghi chú</td>
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
                                                <td width="100" class="title_list"></td>
                                                <td width="150" class="title_list"></td>
                                                <td width="50" class="title_list">ID</td>

                                            </tr>
                                            <!---->
                                            <?php $idDiv = 1; $kk = 0; ?>
                                            <?php foreach($accounts as $k=>$item){ ?>
                                                <tr style="background:<?php if($k % 2 == 0){echo '#F7F7F7';}else{echo '#FFF';} ?>;" id="row_<?php echo $item['id']; ?>" onmouseover="ChangeStyleRow('row_<?php echo $item['id']; ?>',<?php echo $item['id']; ?>,1)" onmouseout="ChangeStyleRow('row_<?php echo $item['id']; ?>',<?php echo $item['id']; ?>,2)">
                                                    <td class="detail_list" style="text-align:center;"><b><?php echo $num + $k +1; ?></b></td>

                                                    <td class="detail_list">
                                                        <a href="<?php echo base_url().'administ/account/detail/'.$item['user_id'];?>">

                                                            <?php echo $item['use_fullname']; ?>
                                                        </a>

                                                    </td>

                                                    <td class="detail_list" style="text-align:center;">
                                                        <?php if($item['group_id'] == 4){ ?>
                                                        <span style="color:#F00; font-weight:bold;">
                                                            <?php }elseif($item['use_group'] == 3){ ?>
                                                                            <span style="color:#009900; font-weight:bold;">
                                                            <?php }elseif($item['use_group'] == 2){ ?>
                                                                                <span style="color:#06F; font-weight:bold;">
                                                            <?php }else{ ?>
                                                                                    <span style="font-weight:normal;">
                                                            <?php } ?>
                                                            <?php echo $item['gro_name']; ?>
											            </span>
                                                    </td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <font color="#FF0000"><b><?php echo number_format($item['amount']).' VNĐ'?></b></font>

                                                    </td>
                                                    <td class="detail_list" ><?php echo $item['description'];?></td>
                                                    <td class="detail_list" ><?php echo $item['created_date'];?></td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <?php foreach($status as $key=>$val){
                                                            if($key == $item['status']){
                                                                echo $val;
                                                                break;
                                                            }
                                                        }?>
                                                    </td>
                                                    <td class="detail_list" >
                                                        <a target="_blank" href="<?php echo base_url().'administ/account/history/'.$item['id'];?>">Lịch sử</a>

                                                    </td>
                                                    <td class="detail_list" style="text-align:center;">
                                                        <?php switch($item['status']){
                                                            case 0:
                                                                echo '<button title="Yêu cầu chuyển khoản" onclick="updatePayment('. $item['id'].', 1, this);" type="button" class="btn btn-default">YCCK</button>';
                                                                break;
                                                            case 1:
                                                                echo '<button title="Xác nhận chuyển khoản" onclick="updatePayment('. $item['id'].', 2, this);" type="button" class="btn btn-default">XNCK</button><button title="Hủy yêu cầu chuyển khoản" onclick="updatePayment('. $item['id'].', 3, this);" type="button" class="btn btn-default">Hủy YCCK</button>';
                                                                break;
                                                        }?>
                                                    </td>
                                                    <td class="detail_list" >
                                                        <?php echo $item['id'];?>
                                                    </td>

                                                </tr>

                                            <?php } ?>
                                            <!---->
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
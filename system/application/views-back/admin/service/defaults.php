<?php $this->load->view('admin/common/header'); ?>
<?php $this->load->view('admin/common/menu'); ?>
    <tr>
        <td>
            <div class="sContentBox">
                <!--BEGIN: Item Menu-->
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td width="5%" height="67" class="item_menu_left">
                            <img
                                src="<?php echo base_url(); ?>templates/home/images/icon/favourite-heart-icon.png"
                                border="0"/>
                        </td>
                        <td width="40%" height="67"
                            class="item_menu_middle">
                            <?php echo $this->lang->line('ser_title'); ?>:
                            <?php foreach ($serviceStatus as $pack) {
                                if ($pack['id'] == $filter['os']) {
                                    echo $pack['name'];
                                    break;
                                }
                            }

                            ?>


                        </td>
                        <td width="55%" height="67" class="item_menu_right">

                            <?php if ($filter['os'] == '01'): ?>
                                <div class="icon_item" id="icon_item_1"
                                     onclick="ActionLink('<?php echo $add; ?>')"
                                     onmouseover="ChangeStyleIconItem('icon_item_1',1)"
                                     onmouseout="ChangeStyleIconItem('icon_item_1',2)">
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
                <form name="sBox" action="<?php echo $link; ?>" method="post" class="searchBox">
                    <input class="input_search" type="text" name="q" value="<?php echo $filter['q']; ?>"
                           placeholder="Nhập từ khóa( tên, user name, email)">
                    Gói: <select class="select_search" name="pid" autocomplete="off">
                        <option value="">Tất cả</option>
                        <?php foreach ($packages as $pack): ?>
                            <option
                                value="<?php echo $pack['id']; ?>" <?php echo ($filter['pid'] == $pack['id']) ? 'selected="selected"' : ''; ?>><?php echo $pack['name']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    Thời gian: <select class="select_search" name="period" autocomplete="off">
                        <option value="">Tất cả</option>
                        <?php foreach ($period as $pItem): ?>
                            <option
                                value="<?php echo $pItem['id']; ?>" <?php echo ($filter['period'] == $pItem['id']) ? 'selected="selected"' : ''; ?>><?php echo $pItem['name']; ?></option>
                        <?php endforeach; ?>
                    </select>


                    Thời gian từ: <input class="input_search" type="text" name="df" value="<?php echo $filter['df']; ?>"
                                         placeholder="yyyy-mm-dd"
                                         autocomplete="off"/>
                    đến <input class="input_search" type="text" name="dt" value="<?php echo $filter['dt']; ?>"
                               placeholder="yyyy-mm-dd"
                               autocomplete="off"/>
                    Theo: <select class="select_search" name="sort" autocomplete="off">
                        <?php foreach ($sortDate as $sortItem): ?>
                            <option
                                value="<?php echo $sortItem['id']; ?>" <?php echo ($filter['sort'] == $sortItem['id']) ? 'selected="selected"' : ''; ?>><?php echo $sortItem['name']; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <input class="searchBt" type="submit" value="">
                    <input type="hidden" name="os" value="<?php echo $filter['os']; ?>"/>
                    <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                    <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
                </form>
                <table width="100%" border="0" align="center" class="main sTable" cellpadding="0" cellspacing="0">
                    <thead>
                    <td class="title_list" width="5%">#
                    </td>
                    <td class="title_list">Username
                        <a href="<?php echo $sort['user']['asc']; ?>">
                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" border="0"/>
                        </a>
                        <a href="<?php echo $sort['user']['desc']; ?>">
                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" border="0"/>
                        </a>

                    </td>
                    <td class="title_list">Ngày tạo
                        <a href="<?php echo $sort['created_date']['asc']; ?>">
                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" border="0"/>
                        </a>
                        <a href="<?php echo $sort['created_date']['desc']; ?>">
                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" border="0"/>
                        </a>
                    </td>

                    <td class="title_list">Người giới thiệu

                    </td>
                    <td class="title_list" width="10%">Gói</td>
                    <td class="title_list" width="10%">Thời gian(tháng)</td>
                    <td class="title_list" width="10%">Số tiền</td>
                    <td class="title_list" width="10%">Ngày bắt đầu</td>
                    <td class="title_list" width="10%">Ngày kết thúc</td>
                    <?php switch ($filter['os']) {
                        case '01':

                            echo '<td class="title_list" style="text-align: center;">Xác nhận</td>';
                            echo '<td class="title_list" style="text-align: center;">Hủy</td>';
                            break;
                        case '02':
                            echo '<td class="title_list" style="text-align: center;">Kích hoạt</td>';
                            break;
                        case '03':
                            echo '<td class="title_list" style="text-align: center;">Trạng thái</td>';
                            break;

                    } ?>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $key => $item): ?>
                        <tr id="row_<?php echo $item['id']; ?>" style="background:<?php if ($key % 2 == 0) {
                            echo '#FFF';
                        } else {
                            echo '#F7F7F7';
                        } ?>;"
                            onmouseover="ChangeStyleRow('row_<?php echo $item['id']; ?>',<?php echo $item['id']; ?>,1)"
                            onmouseout="ChangeStyleRow('row_<?php echo $item['id']; ?>',<?php echo $item['id']; ?>,2)">
                            <td class="detail_list"><?php echo $num + $key + 1; ?></td>
                            <td class="detail_list">
                                <a class="menu"
                                   href="<?php echo base_url() . 'administ/user/edit/' . $item['user_id']; ?>">
                                    <?php echo $item['use_username']; ?>
                                </a>
                                <img src="<?php echo base_url(); ?>templates/admin/images/icon_expand.gif" onmouseover="ddrivetip('<?php echo $this->lang->line('address_tip_defaults'); ?>&nbsp;<?php echo $item['use_address']; ?><br /><?php echo $this->lang->line('phone_tip_defaults') ?>&nbsp;<?php echo $item['use_phone']; ?><br /><?php echo $this->lang->line('yahoo_tip_defaults') ?>&nbsp;<?php echo $item['use_yahoo']; ?>',300,'#F0F8FF');" onmouseout="hideddrivetip();" style="cursor:pointer;" border="0" />
                            </td>
                            <td class="detail_list">
                                <b>
                                    <?php echo $item['created_date'] != '' ? date('d-m-Y', strtotime($item['created_date'])) : ''; ?>
                                </b>

                            </td>
                            <td class="detail_list" align="center" style="text-align:center">

                            	
                             <?php if($item['sponser_id'] > 0):?>
                                    <a class="menu"
                                       href="<?php echo base_url() . 'administ/user/edit/' . $item['sponser_id']; ?>">
                                        <?php echo $item['sponserName']; ?>
                                    </a>
                             <?php endif; ?>
                            </td>
                            <td class="detail_list">
                                <b class="<?php echo $item['info_id']; ?>">
                                    <?php echo $item['package']; ?>
                                </b>
                            </td>
                            <td class="detail_list" style="text-align: center;">
                                <b><?php echo ($item['period'] == '-1') ? 'Không giới hạn' : $item['period']; ?></b></td>
                            <td class="detail_list">
                                <span style="color:#F00; font-weight:bold;">
                                <?php echo $item['amount'] > 0 ? number_format($item['amount'], 0, '.', ',') . ' VNĐ' : 'Miễn phí'; ?>  </span>
                            </td>
                            <td class="detail_list">
                                <b>
                                    <?php echo $item['begined_date'] != '' ? date('d-m-Y', strtotime($item['begined_date'])) : ''; ?>
                                </b>

                            </td>
                            <td class="detail_list">
                                <b>
                                    <?php echo $item['ended_date'] != '' ? date('d-m-Y', strtotime($item['ended_date'])) : ''; ?>
                                </b>


                            </td>
                            <?php switch ($filter['os']) {
                                case '01':
                                    echo '<td class="detail_list" style="text-align: center;">';
                                    echo '<span class="completePayment" style="cursor: pointer;"><img src="'.base_url().'templates/admin/images/active.png" title="Xác nhận thanh toán" /></span>';
                                    echo '</td>';
                                    echo '<td class="detail_list" style="text-align: center;">';
                                    echo '<span class="cancelService" style="cursor: pointer;"><img src="'.base_url().'templates/admin/images/deactive.png" title="Hủy" /></span>';
                                    echo '</td>';
                                    break;
                                case '02':
                                    echo '<td class="detail_list" style="text-align: center;">';
                                    echo '<span class="startService" style="text-align: center;"><img src="'.base_url().'templates/admin/images/active.png" title="Kích hoạt dịch vụ" /></span>';
                                    echo '</td>';
                                    break;
                                case '03':
                                    echo '<td class="detail_list">';
                                    if($item['pack_type'] == 'package'):
                                        echo '<a href="' . base_url() . 'administ/service/subservice/' . $item['id'] . '">Trạng thái</a>';
                                    endif;
                                    echo '</td>';
                                    break;
                            } ?>

                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <!-- <div class="pagination"> -->
                    <tr>
                        <td class="show_page">
                            <?php echo $pager; ?>
                        </td>
                    </tr>
                    
               <!--  </div> -->
            </div>
            <script type="text/javascript">
                var siteUrl = '<?php echo base_url();?>';
                jQuery(document).ready(function () {
                    var form = jQuery('form[name="sBox"]');
                    var table = jQuery('table.sTable');
                    var pStatus = '<?php echo $filter['os'];?>';
                    switch (pStatus) {
                        case '01':
                            table.find('span.completePayment').click(function () {
                                var item = jQuery(this);
                                if (item.hasClass('processing')) {
                                    return;
                                }
                                var id = item.parents('tr').attr('id');
                                id = id.replace('row_', '');
                                confirm(function (e, btn) { //event + button clicked
                                    e.preventDefault();
                                    item.addClass('processing');
                                    jQuery.ajax({
                                        type: "POST",
                                        url: siteUrl + "/administ/service/complete-payment",
                                        dataType: 'json',
                                        data: {order: id},
                                        success: function (res) {
                                            item.removeClass('processing');
                                            if (res.error == false) {
                                                alert('Đã xác nhận');
                                            }else{
                                                alert(res.message);
                                            }
                                            //alert(res.message);
                                            /*$.jAlert({
                                             'title': 'Thông báo',
                                             'content': res.message,
                                             'theme': 'default',
                                             'btns': { 'text': 'close' }
                                             });*/
                                        }
                                    });
                                }, function (e, btn) {
                                    e.preventDefault();
                                    //errorAlert('Denied!');
                                });

                            });


                            table.find('span.cancelService').click(function () {
                                var item = jQuery(this);
                                if (item.hasClass('processing')) {
                                    return;
                                }
                                var id = item.parents('tr').attr('id');
                                id = id.replace('row_', '');
                                confirm(function (e, btn) { //event + button clicked
                                    e.preventDefault();
                                    item.addClass('processing');
                                    jQuery.ajax({
                                        type: "POST",
                                        url: siteUrl + "/administ/service/cancel-order",
                                        dataType: 'json',
                                        data: {order: id},
                                        success: function (res) {
                                            item.removeClass('processing');
                                            if (res.error == false) {
                                                alert('Đã hủy');
                                            } else {
                                                //jAlert(res.message, 'Error');
                                                alert(res.message);
                                            }
                                        }
                                    });
                                }, function (e, btn) {
                                    e.preventDefault();
                                    //errorAlert('Denied!');
                                });
                            });
                            break;
                        case '02':
                            table.find('span.startService').click(function () {
                                var item = jQuery(this);
                                if (item.hasClass('processing')) {
                                    return;
                                }
                                var id = item.parents('tr').attr('id');
                                id = id.replace('row_', '');
                                confirm(function (e, btn) { //event + button clicked
                                    e.preventDefault();
                                    item.addClass('processing');
                                    jQuery.ajax({
                                        type: "POST",
                                        url: siteUrl + "/administ/service/start-service",
                                        dataType: 'json',
                                        data: {order: id},
                                        success: function (res) {
                                            item.removeClass('processing');
                                            if (res.error == false) {
                                                alert('Đã kích hoạt');
                                            } else {
                                                //jAlert(res.message, 'Error');
                                                alert(res.message);
                                            }
                                        }
                                    });
                                }, function (e, btn) {
                                    e.preventDefault();
                                    //errorAlert('Denied!');
                                });

                            });
                            break;
                    }
                });
            </script>
        </td>
    </tr>
<?php $this->load->view('admin/common/footer'); ?>
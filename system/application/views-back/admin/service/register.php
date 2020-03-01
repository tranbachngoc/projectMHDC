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
                            class="item_menu_middle"><?php echo $this->lang->line('ser_title'); ?></td>
                        <td width="55%" height="67" class="item_menu_right">


                        </td>
                    </tr>
                </table>
                <!--END Item Menu-->
                <form name="sBox" action="<?php echo $link; ?>" method="post" class="searchBox">
                    <input class="input_search" type="text" name="q" value="<?php echo $filter['q']; ?>"
                           placeholder="Nhập từ khóa( tên, user name, email)">


                    <input class="searchBt" type="submit" value="">
                    <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                    <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
                </form>
                <table width="100%" border="0" align="center" class="main sTable sBox" cellpadding="0" cellspacing="0">
                    <thead>
                    <td class="title_list" width="5%">#
                    </td>
                    <td class="title_list">Người đăng ký
                        <a href="<?php echo $sort['id']['asc']; ?>">
                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" border="0"/>
                        </a>
                        <a href="<?php echo $sort['id']['desc']; ?>">
                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" border="0"/>
                        </a>

                    </td>

                    <td class="title_list">Tên gói

                    </td>
                    <td class="title_list" width="10%">Ngày tạo
                    </td>
                    <td class="title_list" width="10%">Trạng thái
                    </td>
                    <td class="title_list" width="10%">Ngày bắt đầu</td>
                    <td class="title_list" width="10%">Ngày kết thúc</td>
                    <td class="title_list" width="15%">Gói</td>
                    <td class="title_list" width="10%">Thao tác</td>
                    </thead>
                    <tbody>
                    <?php foreach ($data as $key => $item):
                        $numPackage = count($item['package']);
                        $firstPackage = array();
                        if ($numPackage > 0) {
                            $firstPackage = array_shift($item['package']);
                        }
                        ?>
                        <tr id="row_<?php echo $item['use_id']; ?>">
                            <td <?php echo $numPackage > 1 ? 'rowspan="' . $numPackage . '"' : '';?>
                                class="detail_list"><?php echo $num + $key + 1; ?></td>
                            <td <?php echo $numPackage > 1 ? 'rowspan="' . $numPackage . '"' : '';?>
                                class="detail_list"><?php echo $item['use_fullname']; ?></td>
                            <td class="detail_list">
                                <?php
                                if (!empty($firstPackage)) {
                                    echo '<b>'.$firstPackage['name'].'</b>';
                                    echo '<br />';
                                    echo $firstPackage['period'] != -1 ? $firstPackage['period'] . ' Tháng' : 'Không giới hạn';
                                }
                                ?>
                            </td>
                            <td class="detail_list">
                                <?php
                                if (!empty($firstPackage)) {
                                    echo $firstPackage['created_date'] != '' ? date('d-m-Y', strtotime($firstPackage['created_date'])) : '';
                                }
                                ?>
                            </td>
                            <td class="detail_list">
                                <?php
                                if (!empty($firstPackage)) {
                                    if ($firstPackage['status'] == 0 && $firstPackage['payment_status'] == 0) {
                                        echo 'Đang yêu cầu';
                                    } elseif ($firstPackage['status'] == 0 && $firstPackage['payment_status'] == 1) {
                                        echo 'Đã thanh toán';
                                    } elseif ($firstPackage['status'] == 1 && $firstPackage['payment_status'] == 1) {
                                        if ($firstPackage['ended_date'] > date('Y-m-d H:i:s')) {
                                            echo 'Đang sử dụng';
                                        } else {
                                            echo 'Đã hết hạn';
                                        }

                                    } elseif ($firstPackage['status'] == 9) {
                                        echo 'Đã bị hủy';
                                    }

                                }
                                ?>
                            </td>
                            <td class="detail_list">
                                <?php
                                if (!empty($firstPackage)) {
                                    echo $firstPackage['begined_date'] != '' ? date('d-m-Y', strtotime($firstPackage['begined_date'])) : '';
                                }
                                ?>
                            </td>
                            <td class="detail_list">
                                <?php
                                if (!empty($firstPackage)) {
                                    echo $firstPackage['ended_date'] != '' ? date('d-m-Y', strtotime($firstPackage['ended_date'])) : '';
                                }
                                ?>
                            </td>
                            <td <?php echo $numPackage > 1 ? 'rowspan="' . $numPackage . '"' : '';?>
                                class="detail_list">
                                <select name="package" autocomplete="off">
                                    <?php foreach ($packages as $pItem): ?>
                                        <option
                                            value="<?php echo $pItem['id']; ?>"><?php echo $pItem['name']; ?></option>
                                    <?php endforeach;?>
                                </select>
                            </td>
                            <td <?php echo $numPackage > 1 ? 'rowspan="' . $numPackage . '"' : '';?>
                                class="detail_list"><span class="register">Đăng ký</span></td>
                        </tr>
                        <?php if (!empty($item['package'])):
                        foreach ($item['package'] as $p):
                            ?>
                            <tr>
                                <td class="detail_list">
                                    <?php

                                    echo $p['name'];
                                    echo '<br />';
                                    echo $p['period'] != -1 ? $p['period'] . ' Tháng' : 'Không giới hạn';

                                    ?>
                                </td>
                                <td class="detail_list">
                                    <?php

                                    echo $p['created_date'] != '' ? date('d-m-Y', strtotime($p['created_date'])) : '';

                                    ?>
                                </td>
                                <td class="detail_list">
                                    <?php

                                    if ($p['status'] == 0 && $p['payment_status'] == 0) {
                                        echo 'Đang yêu cầu';
                                    } elseif ($p['status'] == 0 && $p['payment_status'] == 1) {
                                        echo 'Đã thanh toán';
                                    } elseif ($p['status'] == 1 && $p['payment_status'] == 1) {
                                        if ($p['ended_date'] > date('Y-m-d H:i:s')) {
                                            echo 'Đang sử dụng';
                                        } else {
                                            echo 'Đã hết hạn';
                                        }

                                    } elseif ($p['status'] == 9) {
                                        echo 'Đã bị hủy';
                                    }


                                    ?>
                                </td>
                                <td class="detail_list">
                                    <?php

                                    echo $p['begined_date'] != '' ? date('d-m-Y', strtotime($p['begined_date'])) : '';

                                    ?>
                                </td>
                                <td class="detail_list">
                                    <?php

                                    echo $p['ended_date'] != '' ? date('d-m-Y', strtotime($p['ended_date'])) : '';

                                    ?>
                                </td>

                            </tr>

                        <?php endforeach;
                    endif;?>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <tr>
                    <td class="show_page">
                        <?php echo $pager; ?>
                    </td>
                </tr>
            </div>
            <script type="text/javascript">
                var siteUrl = '<?php echo base_url();?>';
                jQuery(document).ready(function () {
                    var table = jQuery('table.sTable');
                    table.find('span.register').click(function () {
                        var item = jQuery(this);
                        if (item.hasClass('processing')) {
                            return;
                        }
                        var box = item.parents('tr');
                        var id = box.attr('id');
                        id = id.replace('row_', '');
                        var package_id = box.find('select[name="package"]').val();
                        confirm(function (e, btn) { //event + button clicked
                            e.preventDefault();
                            item.addClass('processing');
                            jQuery.ajax({
                                type: "POST",
                                url: siteUrl + "/administ/service/add-package",
                                dataType: 'json',
                                data: {package: package_id, uid:id},
                                success: function (res) {
                                    item.removeClass('processing');
									//alert(res.message);
                                    $.jAlert({
                                        'title': 'Thông báo',
                                        'content': res.message,
                                        'theme': 'default',
                                        'btns': {'text': 'close'}
                                    });
                                    if(res.error == false){
                                        $('form.searchBox').submit();
                                    }

                                }
                            });
                        }, function (e, btn) {
                            e.preventDefault();
                            //errorAlert('Denied!');
                        });

                    });
                });
            </script>
        </td>
    </tr>
<?php $this->load->view('admin/common/footer'); ?>
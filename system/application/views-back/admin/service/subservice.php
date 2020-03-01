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
                            class="item_menu_middle">ID: <?php echo $id; ?></td>
                        <td width="55%" height="67" class="item_menu_right"></td>

                    </tr>
                </table>
                <!--END Item Menu-->
                <br />
                <table width="100%" border="0" align="center" class="main afBox" cellpadding="0" cellspacing="0">
                    <thead>
                    <td class="title_list" width="10%">ID


                    </td>
                    <td class="title_list" width="25%">Tên

                    </td>

                    <td class="title_list" width="10%">Dịch vụ sẵn sàng

                    </td>

                    <td class="title_list" width="10%">Ghi chú

                    </td>
                    <td class="title_list" width="10%">Tác vụ

                    </td>

                    </thead>
                    <tbody>
                    <?php foreach ($data as $k => $item): ?>
                        <tr>
                            <td class="detail_list"><?php echo $k + 1; ?></td>
                            <td class="detail_list">
                                <?php echo $item['name']; ?>
                            </td>
                            <td class="detail_list">
                                <input type="checkbox" value="1" name="status" <?php if ($item['status'] == 1) {
                                    echo 'checked="checked" disabled';
                                } ?>
                                       class="input_search" />
                                <input type="hidden" name="service_id" value="<?php echo $item['id'];?>" />

                            </td>

                            <td class="detail_list">
                                <textarea id="note" name="note" class="input_select"><?php if ($item['note'] != '') {
                                        echo $item['note'];
                                    } ?></textarea>
                            </td>
                            <td class="detail_list">
                                <span class="save" style="cursor: pointer;"><button>Lưu</button></span>
                            </td>

                        </tr>
                    <?php endforeach; ?>

                    </tbody>
                </table>

            </div>
            <script type="text/javascript">
                var pid = <?php echo $id;?>;
                jQuery(document).ready(function () {
                    var afBox = jQuery('.afBox');

                    afBox.find('span.save').click(function () {
                        var item = jQuery(this);
                        if (item.hasClass('processing')) {
                            return;
                        }
                        var box = item.closest('tr');
                        var service_id = box.find('input[name="service_id"]').val();
                        var status = 0;
                        if (box.find('input[name="status"]').is(":checked")) {
                            status = 1
                        }
                        var note = box.find('#note').val()
                        item.addClass('processing');

                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo base_url();?>administ/service/update-user-service",
                            dataType: 'json',
                            data: {order_id: pid, service_id: service_id, status: status, note: note},
                            success: function (res) {
                                item.removeClass('processing');
                                if (res.error == false) {
										//alert(res.message);
                                       $.jAlert({
                                            'title': 'Thông báo',
                                            'content': res.message,
                                            'theme': 'default',
                                            'size': 'md',
                                            'showAnimation': 'fadeInUp',
                                            'hideAnimation': 'fadeOutDown'
                                        });

                                } else {
									//alert(res.message);
                                   $.jAlert({
                                        'title': 'Thông báo',
                                        'content': res.message,
                                        'theme': 'default',
                                        'size': 'md',
                                        'showAnimation': 'fadeInUp',
                                        'hideAnimation': 'fadeOutDown'
                                    });

                                }
                            }
                        });


                    })
                    afBox.find('span.delete').click(function () {
                        var item = jQuery(this);
                        if (item.hasClass('processing')) {
                            return;
                        }
                        var box = item.closest('tr');
                        var ordering = box.find('input[name="ordering"]').val();
                        var oldsid = 0;
                        oldsid = box.find('input[name="oldsid"]').val();

                        item.addClass('processing');
                        var uid = jQuery('input[name="uid"]').val();
                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo base_url();?>administ/service/deletePackageService",
                            dataType: 'json',
                            data: {package_id: pid, service_id: oldsid},
                            success: function (res) {
                                item.removeClass('processing');
                                if (res.error == false) {
                                    box.remove();
                                } else {
									//alert(res.message);
                                    $.jAlert({
                                        'title': 'Thông báo',
                                        'content': res.message,
                                        'theme': 'default',
                                        'size': 'md',
                                        'showAnimation': 'fadeInUp',
                                        'hideAnimation': 'fadeOutDown'
                                    });

                                }
                            }
                        });


                    })
                });
            </script>
        </td>
    </tr>
<?php $this->load->view('admin/common/footer'); ?>
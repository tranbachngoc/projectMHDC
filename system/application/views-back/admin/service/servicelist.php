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
                            class="item_menu_middle"><?php echo $this->lang->line('ser_title').' '.$infoText->name; ?></td>
                        <td width="55%" height="67" class="item_menu_right">
                        </td>
                    </tr>
                </table>
                <!--END Item Menu-->
                <form action="<?php echo $link; ?>" method="post" class="searchBox">

                    <input class="input_search" type="text" name="q" value="<?php echo $filter['q']; ?>"
                           placeholder="Từ khóa (id, name)">

                    <input
                        class="searchBt" type="submit" value=""/>
                    <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                    <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
                </form>
                <table width="100%" border="0" align="center" class="main afBox" cellpadding="0" cellspacing="0">
                    <thead>
                    <td class="title_list" width="10%">ID
                        <a href="<?php echo $sort['id']['asc']; ?>">
                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" border="0"/>
                        </a>
                        <a href="<?php echo $sort['id']['desc']; ?>">
                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" border="0"/>
                        </a>

                    </td>
                    <td class="title_list" width="25%">Tên
                        <a href="<?php echo $sort['name']['asc']; ?>">
                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" border="0"/>
                        </a>
                        <a href="<?php echo $sort['name']['desc']; ?>">
                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" border="0"/>
                        </a>
                    </td>

                    <td class="title_list">Mô tả

                    </td>

                    <td class="title_list" width="10%">Sắp xếp

                    </td>
                    <td class="title_list" width="10%">Lưu

                    </td>
                    <td class="title_list" width="10%">Xóa

                    </td>

                    </thead>
                    <tbody>
                    <?php foreach ($list as $k=>$item): ?>
                        <tr id="row_<?php echo $item['id']; ?>" style="background:<?php if ($k % 2 == 0) {
                            echo '#FFF';
                        } else {
                            echo '#F7F7F7';
                        } ?>;"
                            onmouseover="ChangeStyleRow('row_<?php echo $item['id']; ?>',<?php echo $item['id']; ?>,1)"
                            onmouseout="ChangeStyleRow('row_<?php echo $item['id']; ?>',<?php echo $item['id']; ?>,2)">
                            <td class="detail_list"><?php echo $k+1; ?></td>
                            <td class="detail_list">
                                <select name="service_id" autocomplete="off">
                                    <?php foreach ($services as $sitem):
                                        $text = $sitem['limit'] == -1 ? 'Không giới hạn' : $sitem['limit'];

                                        ?>
                                        <option <?php echo $sitem['id'] == $item['service_id'] ? 'selected="selected"' : '';?>
                                            value="<?php echo $sitem['id'];?>"><?php echo $sitem['name'] . ' (' . $text .' '. $sitem['unit'] . ')';?></option>
                                    <?php endforeach; ?>
                                </select>
                                <input type="hidden" name="oldsid" value="<?php echo $item['service_id'];?>" />
                            </td>
                            <td class="detail_list">
                                <?php echo $item['desc'];?>
                            </td>

                            <td class="detail_list">
                                <input type="text" value="<?php echo $item['ordering']; ?>" name="ordering"
                                       class="input_search">
                            </td>
                            <td class="detail_list" style="text-align: center;">
                                <span class="save" style="cursor: pointer;"><img src="<?php echo base_url().'templates/admin/images/save.png';?>" title="Lưu" /></span>
                            </td>
                            <td class="detail_list" style="text-align: center;">
                                <span class="delete" style="cursor: pointer;"><img src="<?php echo base_url().'templates/admin/images/deactive.png';?>" title="Xóa" /></span>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                    <tr class="addNew">
                        <td class="detail_list">#</td>
                        <td class="detail_list">
                            <select name="service_id" autocomplete="off">
                                <?php foreach ($services as $sitem):
                                    $text = $sitem['limit'] == -1 ? 'Không giới hạn' : $sitem['limit'];
                                    ?>
                                    <option <?php echo $sitem['id'] == $item['service_id'] ? 'selected="selected"' : '';?>
                                        value="<?php echo $sitem['id'];?>"><?php echo $sitem['name'] . ' (' . $text .' '. $sitem['unit'] . ')';?></option>
                                <?php endforeach; ?>
                            </select>

                        </td>
                        <td class="detail_list"></td>
                        <td class="detail_list">
                            <input type="text" value="0" name="ordering" class="input_search">
                        </td>
                        <td class="detail_list" style="text-align: center;">
                            <span class="save" style="cursor: pointer;"><img src="<?php echo base_url().'templates/admin/images/save.png';?>" title="Lưu" /></span>
                        </td>
                        <td class="detail_list">

                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <script type="text/javascript">
                var pid = <?php echo $pid;?>;
                jQuery( document ).ready(function() {
                    var afBox = jQuery('.afBox');

                    afBox.find('span.save').click(function(){
                        var item = jQuery(this);
                        if(item.hasClass('processing')){
                            return;
                        }
                        var box = item.closest('tr');
                        var ordering = box.find('input[name="ordering"]').val();
                        var oldsid = 0;
                        if(! box.hasClass('addNew')){
                            oldsid = box.find('input[name="oldsid"]').val();
                        }
                        var service_id = box.find('select[name="service_id"]').val();
                        item.addClass('processing');
                        var uid = jQuery('input[name="uid"]').val();
                        jQuery.ajax({
                            type: "POST",
                            url: "<?php echo base_url();?>administ/service/changePackageService",
                            dataType: 'json',
                            data: {package_id: pid, service_id: service_id, oldsid: oldsid, ordering: ordering},
                            success: function (res) {
                                item.removeClass('processing');
                                if (res.error == false) {
                                    if(oldsid > 0){
										//alert(res.message);
                                        $.jAlert({
                                            'title': 'Thông báo',
                                            'content': res.message,
                                            'theme': 'default',
                                            'size': 'md',
                                            'showAnimation': 'fadeInUp',
                                            'hideAnimation': 'fadeOutDown'
                                        });
                                    }else{
                                        window.location = "<?php echo $link;?>";
                                    }
                                }else{
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
                    afBox.find('span.delete').click(function(){
                        var item = jQuery(this);
                        if(item.hasClass('processing')){
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
                                }else{
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
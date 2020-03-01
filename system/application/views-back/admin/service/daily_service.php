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

                        </td>
                    </tr>
                </table>
                <!--END Item Menu-->

                <!--<form action="<?php /*echo $link; */?>" method="post" class="searchBox">

                    <input class="input_search" type="text" name="q" value="<?php /*echo $filter['q']; */?>"
                           placeholder="Từ khóa (id, name)">

                    <input
                        class="searchBt" type="submit" value=""/>
                    <input type="hidden" name="dir" value="<?php /*echo $filter['dir']; */?>"/>
                    <input type="hidden" name="sort" value="<?php /*echo $filter['sort']; */?>"/>
                </form>-->
                <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
                    <thead>
                    <td class="title_list" width="10%">ID
                    </td>
                    <td class="title_list" width="25%">Tên
                    </td>
                    <td class="title_list" width="10%">Loại</td>
                    <td class="title_list" width="10%">Vị trí</td>
                    <td class="title_list" width="10%">Giá min</td>
                    <td class="title_list" width="10%">Giá max</td>
                    <td class="title_list" width="10%">Đơn vị</td>

                    </thead>
                    <tbody>
                    <?php foreach ($list as $key=>$item): ?>
                        <tr id="row_<?php echo $item['id']; ?>" style="background:<?php if ($key % 2 == 0) {
                            echo '#FFF';
                        } else {
                            echo '#F7F7F7';
                        } ?>;"
                            onmouseover="ChangeStyleRow('row_<?php echo $item['id']; ?>',<?php echo $item['id']; ?>,1)"
                            onmouseout="ChangeStyleRow('row_<?php echo $item['id']; ?>',<?php echo $item['id']; ?>,2)">
                            <td class="detail_list"><?php echo $num + $key + 1; ?></td>
                            <td class="detail_list">
                                <a class="menu" href="<?php echo $link; ?>/edit/<?php echo $item['id']; ?>" title="<?php echo $this->lang->line('edit_tip'); ?>">
                                    <?php echo $item['p_name']; ?>
                                </a>
                            </td>
                            <td class="detail_list">
                                <?php
                                foreach($packageType as $pack):?>
                                    <?php if($pack['code'] == $item['p_type']){
                                        echo $pack['text'];
                                    }?>
                                <?php endforeach;?>
                            </td>
                            <td class="detail_list">
                                <?php echo $item['pos_num'];?>
                            </td>
                            <td class="detail_list">
                                <?php echo $item['price_min'];?>
                            </td>
                            <td class="detail_list">
                                <?php echo $item['price_max'];?>
                            </td>
                            <td class="detail_list">
                                <?php echo $item['unit'];?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <tr>
                    <td class="show_page">
                        <?php echo $pager; ?>
                    </td>
                </tr>
            </div>
        </td>
    </tr>
<?php $this->load->view('admin/common/footer'); ?>
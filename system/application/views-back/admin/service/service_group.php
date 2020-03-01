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

                <form action="<?php echo $link; ?>" method="post" class="searchBox">

                    <input class="input_search" type="text" name="q" value="<?php echo $filter['q']; ?>"
                           placeholder="Từ khóa (id, name)">

                    <input
                        class="searchBt" type="submit" value=""/>
                    <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                    <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
                </form>
                <table width="100%" border="0" align="center" class="main" cellpadding="0" cellspacing="0">
                    <thead>
                    <td class="title_list" width="10%">ID
                        <a href="<?php echo $sort['id']['asc'];?>">
                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" border="0" />
                        </a>
                        <a href="<?php echo $sort['id']['desc'];?>">
                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" border="0" />
                        </a>

                    </td>
                    <td class="title_list" width="25%">Tên
                        <a href="<?php echo $sort['name']['asc'];?>">
                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" border="0" />
                        </a>
                        <a href="<?php echo $sort['name']['desc'];?>">
                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" border="0" />
                        </a>
                    </td>

                    <td class="title_list">Mô tả

                    </td>
                    <td class="title_list">Loại dịch vụ

                    </td>

                    <td class="title_list" width="10%">Kích hoạt

                    </td>

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
                                    <?php echo $item['text']; ?>
                                </a>
                            </td>
                            <td class="detail_list"><?php if($item['content_id'] > 0):?>
                                    <a class="menu" href="<?php echo base_url(); ?>administ/content/edit/<?php echo $item['content_id']; ?>">
                                        <?php echo $item['not_title'];?>
                                    </a>
                            <?php endif;?>
                            </td>
                            <td class="detail_list">
                                <?php echo $item['type'];?>
                            </td>



                            <td class="detail_list" style="text-align: center;">
                                <?php if($item['published'] == 1){ ?>
                                    <img src="<?php echo base_url(); ?>templates/admin/images/active.png" onclick="ActionStatus('<?php echo $link; ?>/status/deactive/<?php echo $item['id']; ?>')" style="cursor:pointer;" border="0" title="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                <?php }else{ ?>
                                    <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" onclick="ActionStatus('<?php echo $link; ?>/status/active/<?php echo $item['id']; ?>')" style="cursor:pointer;" border="0" title="<?php echo $this->lang->line('active_tip'); ?>" />
                                <?php } ?>
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
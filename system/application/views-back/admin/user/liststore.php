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
                                <!--BEGIN: Item Menu-->
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="5%" height="67" class="item_menu_left">
                                            <a href="<?php echo base_url(); ?>administ/user/usertree/624">
                                            	<img src="<?php echo base_url(); ?>templates/home/images/icon/treesystem-icon.png" border="0" />
                                            </a>
                                        </td>
                                        <td width="40%" height="67" class="item_menu_middle">Danh sách gian hàng</td>
                                        <td width="55%" height="67" class="item_menu_right">
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
                                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="160" align="left">
                                            <input type="text" name="keyword" id="keyword" value="<?php echo $keyword; ?>" maxlength="100" class="form-control"  onKeyPress="return SummitEnTerAdmin(this,event,'<?php echo base_url(); ?>administ/user/liststore/<?php echo $this->uri->segment(4); ?>/search/username/keyword/','keyword')" />
                                        </td>
                                        <td width="120" align="left">
                                            <select name="search" id="search" onchange="ActionSearch('<?php echo base_url(); ?>administ/user/liststore/<?php echo $this->uri->segment(4); ?>/',1)" class="select_search">
                                               <!-- <option value="0"><?php //echo $this->lang->line('search_by_search'); ?></option>-->
                                                <option value="username"><?php echo $this->lang->line('username_inactive'); ?></option>
                                            </select>
                                        </td>
                                        <td align="left">
                                            <img src="<?php echo base_url(); ?>templates/admin/images/icon_search.gif" border="0" style="cursor:pointer;" onclick="ActionSearch('<?php echo base_url(); ?>administ/user/usertree/<?php echo $this->uri->segment(4); ?>/',1)" title="<?php echo $this->lang->line('search_tip'); ?>" />
                                        </td>
                                    </tr>
                                </table>
                                <!--END Search-->
                            </td>
                        </tr>
                        <tr>
                            <td height="5"></td>
                        </tr>
                        <form name="frmInActUser" method="post">
                        <tr>
                            <td>
                                <!--BEGIN: Content-->
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td width="25" class="title_list">STT</td>
                                        <td width="20" class="title_list">
                                            <input type="checkbox" name="checkall" id="checkall" value="0" onclick="DoCheck(this.checked,'frmInActUser',0)" />
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('username_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>username/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>username/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                         <td class="title_list">
                                            Họ tên
                                        </td>
                                        <td class="title_list">
                                            Người giới thiệu
                                        </td>
                                        <td class="title_list">
                                            Điện thoại
                                        </td>
                                        <td class="title_list">
                                            <?php echo $this->lang->line('email_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>email/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>email/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                        <td width="60" class="title_list">
                                            <?php echo $this->lang->line('status_list'); ?>
                                        </td>
                                        <td width="125" class="title_list">
                                            <?php echo $this->lang->line('regisdate_list'); ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_asc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>regisdate/by/asc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                            <img src="<?php echo base_url(); ?>templates/admin/images/sort_desc.gif" onclick="ActionSort('<?php echo $sortUrl; ?>regisdate/by/desc<?php echo $pageSort; ?>')" style="cursor:pointer;" border="0" />
                                        </td>
                                    </tr>
                                    <?php $sTT = 1;
                                    foreach($Liststore as $userArray){
                                        ?>
                                    <tr>
                                        <td class="detail_list" style="text-align:center;"><b><?php echo $sTT++; ?></b></td>
                                        <td class="detail_list" style="text-align:center;">
                                            <input type="checkbox" name="checkone[]" id="checkone" value="<?php echo $userArray->use_id; ?>" <?php if($userLogined == $userArray->use_id){echo 'disabled="disabled"';} ?> onclick="DoCheckOne('frmInActUser')" />
                                        </td>
                                        <td class="detail_list">
                                            <a class="menu" href="<?php echo base_url() ?>administ/user/edit/<?php echo $userArray->use_id; ?>" title="Xem danh sách tuyến dưới của <?php echo $userArray->use_username; ?>">
                                                <?php echo $userArray->use_username; ?>
                                            </a>
                                            <a href="<?php echo base_url() ?>administ/user/edit/<?php echo $userArray->use_id; ?>"  target="_blank"><img style=" float: right;" width="17" src="<?php echo base_url(); ?>templates/admin/images/edit.png"  border="0" title="Sửa thông tin <?php echo $userArray->use_username; ?>" /></a>

                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <a class="menu" href="<?php echo base_url() ?>administ/user/edit/<?php echo $userArray->use_id; ?>" title="Chi tiết tài khoản của <?php echo $userArray->use_fullname; ?>">
                                                <?php echo $userArray->use_fullname; ?>
                                            </a>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php foreach ($rootUser as $parent){
                                                if ($parent->use_id == $userArray->parent_id){
                                                ?>
                                            <a class="menu" href="<?php echo base_url() ?>administ/user/edit/<?php echo $parent->use_id; ?>" title="Xem danh sách tuyến dưới của <?php echo $parent->use_username; ?>">
                                                <?php echo $parent->use_username; ?>
                                            </a>
                                            <?php } }?>
                                        </td>
                                         <td class="detail_list" style="text-align:center;">

                                                <?php echo $userArray->use_mobile; ?>

                                        </td>
                                        <td class="detail_list">
                                            <a class="menu" href="mailto:<?php echo $userArray->use_email; ?>">
                                                <?php echo $userArray->use_email; ?>
                                            </a>
                                        </td>
                                        <td class="detail_list" style="text-align:center;">
                                            <?php if($userArray->use_status == 1){ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/active.png" <?php if($userLogined != $userArray->use_id){ ?>  style="cursor:pointer;" <?php } ?> border="0" title="<?php echo $this->lang->line('deactive_tip'); ?>" />
                                            <?php }else{ ?>
                                            <img src="<?php echo base_url(); ?>templates/admin/images/deactive.png" <?php if($userLogined != $userArray->use_id){ ?> style="cursor:pointer;" <?php } ?> border="0" title="<?php echo $this->lang->line('active_tip'); ?>" />
                                            <?php } ?>
                                        </td>
                                        <td class="detail_list" style="text-align:center;"><b><?php echo date('d-m-Y', $userArray->use_regisdate); ?></b></td>
                                        <?php /*?><td class="detail_list" style="text-align:center;"><b><?php if($userArray->use_enddate == $userArray->use_regisdate){echo $this->lang->line('not_set_inactive');}else{echo date('d-m-Y', $userArray->use_enddate);} ?></b></td>
                                        <td class="detail_list" style="text-align:center;"><b><?php echo date('d-m-Y', $userArray->use_lastest_login); ?></b></td><?php */?>
                                    </tr>
                                    <?php $idDiv++; ?>
                                    <?php $kk++; } ?>
                                    <?php if(count($Liststore) <= 0){ ?>
                                     <tr>
                                        <td class="show_page" colspan="9" align="center">Không có thành viên nào!</td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                        <td class="show_page" colspan="9"><?php echo $linkPage; ?></td>
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
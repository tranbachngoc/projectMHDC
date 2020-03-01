<?php $this->load->view('home/common/account/header'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <?php
        $group_id = $this->session->userdata('sessionGroup');
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $domainName = $_SERVER['HTTP_HOST'];
        $text = 'Cộng tác viên online <span style="color: #f00;">' . $user_staff->use_username . '</span> giới thiệu';
        $txt = 'Tổng cộng tác viên:';
        if ($this->uri->segment(2) == 'listbran') {
            $text = 'Chi nhánh <span style="color: #f00;">' . $user_staff->use_username . '</span> đã tạo';
            $txt = 'Tổng chi nhánh:';
        } 

        ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
	    <h4 class="page-header  text-uppercase" style="margin-top:10px">
                Danh sách <?php echo $text ?>
            </h4>

            <p class="col-sm-12" style="text-align: right; font-weight: bold;"><?php echo $txt ?>
                <span style="color:#f00;"><?php echo $totalRecord ?></span>
            </p>

            <div class="visible-xs small">
                <?php foreach ($liststore as $k => $items) {
                    $tenDomain = '';
                    $get_u = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . (int)$items->use_id . '"');
                    switch ($get_u[0]->use_group) {
                        case BranchUser:
                            $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u[0]->parent_id . '"');
                            if ($get_p[0]->use_group == AffiliateStoreUser) {
                                if ($get_p[0]->domain != '') {
                                    $tenDomain = $get_p[0]->domain;
                                } else {
                                    $parent = $get_p[0]->sho_link;
                                }
                            } else {
                                if ($get_p[0]->use_group == StaffStoreUser || $get_p[0]->use_group == StaffUser) {
                                    $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                                    if ($get_p1[0]->domain != '') {
                                        $tenDomain = $get_p1[0]->domain;
                                    } else {
                                        $parent = $get_p1[0]->sho_link;
                                    }
                                }
                            }
                            break;
                        case AffiliateUser:
                            $get_p = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_u[0]->parent_id . '"');
                            if ($get_p[0]->use_group == AffiliateStoreUser || $get_p[0]->use_group == BranchUser) {
                                if ($get_p[0]->domain != '') {
                                    $tenDomain = $get_p[0]->domain;
                                } else {
                                    $parent = $get_p[0]->sho_link;
                                }
                            } else {
                                if ($get_p[0]->use_group == StaffStoreUser || $get_p[0]->use_group == StaffUser) {
                                    $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                                    if ($get_p1[0]->domain != '') {
                                        $tenDomain = $get_p1[0]->domain;
                                    } else {
                                        $parent = $get_p1[0]->sho_link;
                                    }
                                } else {
                                    $get_p1 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p[0]->parent_id . '"');
                                    if ($get_p1[0]->use_group == StaffStoreUser && $get_p[0]->use_group == StaffUser) {
                                        $get_p2 = $this->user_model->fetch_join('use_id,parent_id, use_group, sho_link,domain', "LEFT", "tbtt_shop", "sho_user = use_id", 'use_id = "' . $get_p1[0]->parent_id . '"');
                                        if ($get_p1[0]->domain != '') {
                                            $tenDomain = $get_p2[0]->domain;
                                        } else {
                                            $parent = $get_p2[0]->sho_link;
                                        }
                                    }
                                }
                            }
                            break;
                    } ?>
                    <div
                        style="border:1px solid #ddd; border-bottom: 0px; display: inline-block; text-align: center; width: 50px; padding: 5px; background: #f9f9f9">
                        <?php echo $stt + $k + 1; ?>
                    </div>
                    <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0"
                           style="background: #fff;">
                        <tr>
                            <td width="100">Tài khoản</td>
                            <td>
                                <a target="_blank"
                                   href="<?php echo base_url(); ?>user/profile/<?php echo $items->use_id; ?>"> <?php echo $items->use_username; ?></a>
                                <p style="font-size: 12px; color: #f57420">
                                    <em><?php
                                        foreach ($liststore as $itemshop) {
                                            if ($items->parent_shop == $itemshop->sho_user && $items->parent_shop != 0) {
                                                echo 'Thuộc gian hàng: ' . $itemshop->sho_name;
                                            }
                                        }
                                        ?></em>
                                </p>
                            </td>
                        </tr>
                        <?php
                        if ($group_id != CoreAdminUser && $group_id != CoreMemberUser && $group_id != Partner1User && $group_id != Partner2User && $group_id != Developer1User && $group_id != Developer2User) {
                            ?>
                            <tr>
                                <td>Tên Gian hàng</td>
                                <td>
                                    <?php if ($items->sho_name != '') { ?>
                                        <a href="<?php                                       
                                        if ($tenDomain != '') {
                                            echo $protocol . $tenDomain . '/' . $items->sho_link . '/news';
                                        } else {
                                            echo $protocol . $parent . '.' . $domainName . '/' . $items->sho_link . '/news';
                                        }
                                        ?>" target="_blank"><?php echo $items->sho_name; ?></a>
                                    <?php } else echo 'Chưa cập nhập'; ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Gian hàng</td>
                                <td>
                                    <?php if ($items->sho_name != '') { ?>
                                        <a href="<?php                                        
                                        if ($tenDomain != '') {
                                            echo $protocol . $tenDomain . '/' . $items->sho_link . '/shop';
                                        } else {
                                            echo $protocol . $parent . '.' . $domainName . '/' . $items->sho_link . '/shop';
                                        }
                                        ?>" target="_blank"><?php echo $items->sho_name; ?></a>
                                    <?php } else echo 'Chưa cập nhập'; ?>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td>Email</td>
                            <td><a href="mailto:<?php echo $items->use_email; ?>"><?php echo $items->use_email; ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Điện thoại</td>
                            <td><a href="tel:<?php echo $items->use_mobile; ?>"><?php echo $items->use_mobile; ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Nhắn tin</td>
                            <td>
                                <?php if ($items->use_message) { ?>
                                    <a class="btn btn-info btn-sm"
                                       href="<?php echo str_replace("https://www.facebook.com/messages/t/", "https://www.messenger.com/t/", $items->use_message); ?>"
                                       title="Gửi tin nhắn">
                                        <i class="fa fa-comment fa-fw"></i> &nbsp;Nhắn tin
                                    </a>
                                <?php } ?>
                                &nbsp;
                                <?php if ($items->use_mobile) { ?>
                                    <a class="btn btn-info btn-sm"
                                       href="sms:<?php echo $items->use_mobile ?>">
                                        <i class="fa fa-commenting fa-fw"></i> &nbsp;Gửi SMS
                                    </a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php if ($group_id > AffiliateStoreUser && $group_id != BranchUser && $group_id != StaffUser && $group_id != StaffStoreUser) { ?>
                            <tr>
                                <td>Gán gian hàng</td>
                                <td>&nbsp;</td>
                            </tr>
                        <?php } ?>
                    </table>
                <?php } ?>
            </div>
            <div class="hidden-xs">
                <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0"
                       style="background: #fff;">
                    <?php if (count($staffs) > 0) { ?>
                        <thead>
                        <tr>
                            <th width="40" class="title_account_0">STT</th>
                            <th width="" class="title_account_2" align="center">
                                Tài khoản
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                     onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')"
                                     border="0" style="cursor:pointer;" alt=""/>
                                <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                     onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')"
                                     border="0" style="cursor:pointer;" alt=""/>
                            </th>
                            <?php
                            if ($group_id != CoreAdminUser && $group_id != CoreMemberUser && $group_id != Partner1User && $group_id != Partner2User && $group_id != Developer1User && $group_id != Developer2User)
                            {
                            ?>
                                <th width=" class="title_account_2" align="center">
                                    Tên Gian hàng
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                         onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/asc<?php echo $pageSort; ?>')"
                                         border="0" style="cursor:pointer;" alt=""/>
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                         onclick="ActionSort('<?php echo $sortUrl; ?>hoten/by/desc<?php echo $pageSort; ?>')"
                                         border="0" style="cursor:pointer;" alt=""/>
                                
                                </th>
                                <th width="120" class="title_account_2" align="center">
                                    Link
                                </th>
                            <?php
                            }
                            ?>
                            <th width="" class="title_account_2" align="center">
                                Email - Điện thoại
                            </th>
                            <th width=80" class="title_account_2" align="center">
                                Nhắn tin
                            </th>

                            <?php if ($group_id > AffiliateStoreUser && $group_id != BranchUser && $group_id != StaffUser && $group_id != StaffStoreUser) { ?>
                                <th width=10%" class="title_account_2" align="center">
                                    Gán gian hàng
                                </th>
                            <?php } ?>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        foreach ($liststore as $key => $items) {                          
                            $link_shop = $protocol.$items->sho_link.'.'.domain_site.'/shop';
                            if ($items->domain != '') {
                                $link_shop = $protocol.$items->domain.'/shop';
                            }
                            ?>
                            <tr>
                                <td class="line_account_0 text-center"><?php echo $key + 1 + $stt; ?></td>
                                <td class="line_account_2">
                                    <a target="_blank"
                                       href="<?php echo base_url(); ?>user/profile/<?php echo $items->use_id; ?>">
                                        <?php echo $items->use_username; ?>
                                    </a>
                                    <div class="shop_parent active" style="font-size: 12px;color: orangered!important;">                                       
                                        <i><?php echo $info_parent[$key]['info_parent']; ?></i>
                                    </div>                                    
                                </td>
                                <?php
                                if ($group_id == AffiliateStoreUser || $group_id == AffiliateUser || $group_id == StaffUser || $group_id == BranchUser || $group_id == StaffStoreUser) {
                                    ?>
                                    <td class="line_account_2">
                                        <?php if ($items->sho_name != '') { ?>
                                            <?php echo $items->sho_name; ?>
                                        <?php } else { echo 'Chưa cập nhập';} ?>
                                    </td>

                                    <td class="text-center">
                                        <?php if ($items->sho_name != '') { ?>
                                        <a class="btn btn-default" href="<?php echo $link_shop; ?>" target="_blank" title="Đến trang cửa hàng">
                                            <i class="azicon icon-store"></i> 
                                        </a>
                                        <?php } else { echo 'Chưa cập nhập';} ?>
                                    </td>

                                <?php } ?>
                                <td class="line_account_2">
                                    <i class="fa fa-envelope-o fa-fw"></i> <a
                                        href="mailto:<?php echo $items->use_email; ?>"><?php echo $items->use_email; ?></a><br>
                                    <i class="fa fa-phone fa-fw"></i> <a
                                        href="tel:<?php echo $items->use_mobile; ?>"><?php echo $items->use_mobile; ?></a>
                                </td>
                                <td class="text-center">
                                    <?php if ($items->use_message) { ?>
                                        <a class="btn btn-info btn-sm" href="<?php echo $items->use_message; ?>"
                                           title="Gửi tin nhắn">
                                            <i class="fa fa-comment fa-fw"></i>
                                        </a>
                                    <?php } ?>
                                </td>

                                <?php if ($group_id > AffiliateStoreUser && $group_id != BranchUser && $group_id != StaffUser && $group_id != StaffStoreUser) { ?>
                                    <td class="line_account_2">
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#myModal_<?php echo $items->use_id; ?>">
                                            Chọn
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal_<?php echo $items->use_id; ?>" tabindex="-1"
                                             role="dialog" aria-labelledby="myModalLabel_<?php echo $items->use_id; ?>">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close"><span
                                                                aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title"
                                                            id="myModalLabel_<?php echo $items->use_id; ?>">Chọn gian
                                                            hàng</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <select name="parent_shop_id_<?php echo $items->use_id; ?>"
                                                                id="parent_shop_id_<?php echo $items->use_id; ?>">
                                                            <option value="">--Chọn gian hàng--</option>
                                                            <?php foreach ($list_shop as $itemshop) { ?>
                                                                <option
                                                                    value="<?php echo $itemshop->use_id; ?>"><?php echo $itemshop->use_username; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default"
                                                                data-dismiss="modal">Hủy
                                                        </button>
                                                        <button type="button"
                                                                onclick="add_parent_shop(<?php echo $items->use_id; ?>);"
                                                                class="btn btn-primary">Lưu lại
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                <?php } ?>
                            </tr>
                        <?php } ?>
                        </tbody>
                    <?php } else { ?>
                        <tr>
                            <td class="text-center">
                                Không có dữ liệu!
                            </td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <?php echo $linkPage; ?>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
<script>
    function add_parent_shop(use_id) {
        var shop_id = $('#parent_shop_id_' + use_id).val();
        if (shop_id == '') {
            errorAlert('Bạn chưa chọn gian hàng');
            return false;
        } else {
            $.ajax({
                type: "post",
                url: "<?php echo base_url(); ?>" + 'home/account/listaffiliate',
                cache: false,
                data: {use_id: use_id, parent_shop_id: shop_id},
                dataType: 'text',
                success: function (data) {
                    if (data == '1') {
                        $('.modal').modal('hide');
                    } else {
                        errorAlert('Có lỗi xảy ra', 'Thông báo');
                    }
                }
            });
        }
        return false;
    }
</script>

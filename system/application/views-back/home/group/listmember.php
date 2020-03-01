<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
        <div class="row rowmain">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            <div class="col-md-9 col-xs-12">
                <h4 class="page-header text-uppercase" style="margin-top:10px">Duyệt thành viên</h4>
                <?php 
                if (count($listMember) == 0 || ($listtree && count($listMember) < count($listtree) - 1)) {
                ?>
                    <span>Bạn có muốn duyệt tất cả thành viên trong hệ thống lên group</span>

                    <span class="btn btn-primary" name="" id="" onclick="">
                        <a href="/account/groups/approvemember/<?php echo $this->uri->segment(4) ?>/duyetall" style="color: #fff;">Duyệt tất cả</a>
                    </span>
                <?php } 
                if (count($listMember) > 0){
                //else { ?>
                    <div class="visible-xs">

                        <?php
                        $vt = $stt + $limit+1;
                        if ($vt > count($listMember)) {
                            $vt = count($listMember);
                        }
                        if (count($listMember) > 0) {
                            for ($i = $stt; $i < $vt; $i++) {
                                $arr = $duyetuse_HT = array();
                                $nhom_thamgia = implode(', ', $listMember[$i]['group_thamgia']['grt_name']);
                                $nhom_thamgiaID = implode(', ', $listMember[$i]['group_thamgia']['grt_id']);
                                ?>
                                <div
                                    style="border:1px solid #ddd; border-bottom: 0px; display: inline-block; text-align: center; width: 50px; padding: 5px; background: #f9f9f9">
                                    <?php echo $i + 1; ?>
                                </div>
                                <table class="table table-bordered active"
                                       style="border-bottom:2px solid #999; background: #fff; font-size: 12px;">
                                    <tr>
                                        <td width="110">Avatar</td>
                                        <td><img
                                                src="<?php if ($listMember[$i]['avatar'] != '') {
                                                    echo '/media/images/avatar/' . $listMember[$i]['avatar'];
                                                } else {
                                                    echo '/images/user-avatar-default.png';
                                                } ?>"
                                                style="width:70px; height: 70px "/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="110">Tài khoản</td>
                                        <td><?php echo $listMember[$i]['use_username']; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Họ tên</td>
                                        <td>
                                            <strong><?php if ($listMember[$i]['use_fullname'] != '') echo $listMember[$i]['use_fullname'];
                                                else
                                                    echo 'Chưa cập nhật'; ?></strong></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><?php if ($listMember[$i]['use_email'] != '') echo $listMember[$i]['use_email'];
                                            else
                                                echo 'Chưa cập nhật'; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Điện thoại</td>
                                        <td><?php if ($listMember[$i]['use_mobile'] != '') echo $listMember[$i]['use_mobile'];
                                            else
                                                echo 'Chưa cập nhật'; ?></td>
                                    </tr>
                                    <tr>
                                        <?php
                                        if ($nhom_thamgia != '') {
                                            ?>
                                            <td>Thuộc nhóm</td>
                                            <td><em style="font-size: 12px"><?php echo $nhom_thamgia ?></em></td>
                                        <?php } ?>
                                    </tr>
                                    <tr>
                                        <?php if ($arr_backu && in_array($listMember[$i]['use_id'], $arr_backu)) {
                                            $show = 'in';
                                        } ?>

                                        <td colspan="2" align="center">
                                            <a href="#" data-toggle="modal" id="<?php echo $listMember[$i]['use_id']; ?>"
                                               style="color: #f00"
                                               data-target="#loaigroup-modal"
                                               onclick="loai_use_group(<?php echo $listMember[$i]['use_id']; ?>,'<?php echo $nhom_thamgia ?>','<?php echo $nhom_thamgiaID ?>','<?php echo $show?>');">
                                                <i class="fa fa-times fa-fw"></i> Loại khỏi nhóm
                                            </a>
                                        </td>
                                    </tr>
                                </table>
                                <?php
                            }
                        } else { ?>
                            <tr>
                                <td colspan="10" class="text-center">Không thành viên</td>
                            </tr>
                        <?php } ?>

                    </div>


                    <div class="hidden-xs">
                        <!--<p>Duyệt tất cả thành viên lên Group ? <button class="btn btn-default" onclick="applyAll(<?php echo $this->session->userdata('sessionUser') . ',' . $this->session->userdata('sessionGrt') ?>);">Duyệt tất cả</button></p>-->

                        <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-top: 20px;">
                            <thead>
                            <tr>
                                <th width="20" class="title_account_0">#</th>
                                <th width="90" class="title_account_1">
                                    Avatar
                                </th>
                                <th width="" class="title_account_2" align="center">
                                    Tài khoản
                                </th>
                                <th width="" class="hidden-xs" align="center">
                                    Email - Số điện thoại
                                </th>
                                <th width="" class="title_account_2" align="center">
                                    Lên group
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $vt = $stt + $limit +1;
                            if ($vt > count($listMember)) {
                                $vt = count($listMember);
                            }
                            if (count($listMember) > 0) {
                                for ($i = $stt; $i < $vt; $i++) {
                                        $show = '';
                                        $arr = $duyetuse_HT = array();
                                        $nhom_thamgia = implode(', ', $listMember[$i]['group_thamgia']['grt_name']);
                                        $nhom_thamgiaID = implode(', ', $listMember[$i]['group_thamgia']['grt_id']);
                                        ?>
                                        <tr>
                                            <td width="" height="32" class="line_account_0"><?php echo $i+1; ?></td>
                                            <td height="32" class="line_account_0">
                                                <img
                                                    src="<?php if ($listMember[$i]['avatar'] != '') {
                                                        echo '/media/images/avatar/' . $listMember[$i]['avatar'];
                                                    } else {
                                                        echo '/images/user-avatar-default.png';
                                                    } ?>"
                                                    style="width:70px; height: 70px "/>
                                            </td>
                                            <td height="32" class="line_account_2">
                                                <em>Tài khoản:</em> <?php echo $listMember[$i]['use_username']; ?>
                                                <?php
                                                if ($nhom_thamgia != '') {
                                                    ?>
                                                    <br>
                                                    <em class="small">Đã tham gia:</em> <?php echo $nhom_thamgia ?>
                                                <?php } ?>
                                                <br/>
                                                <em class="small">Họ
                                                    tên: </em><strong><?php if ($listMember[$i]['use_fullname'] != '') echo $listMember[$i]['use_fullname'];
                                                    else
                                                        echo 'Chưa cập nhật'; ?></strong>
                                            </td>
                                            <td height="32">
                                                <i class="fa fa-envelope-o fa-fw"></i>
                                                <?php if ($listMember[$i]['use_email'] != '') echo $listMember[$i]['use_email'];
                                                else
                                                    echo 'Chưa cập nhật'; ?>
                                                <br/>
                                                <i class="fa fa-phone fa-fw"></i>
                                                <?php if ($listMember[$i]['use_mobile'] != '') echo $listMember[$i]['use_mobile'];
                                                else
                                                    echo 'Chưa cập nhật'; ?>
                                                <?php
                                                ?>
                                            </td>
                                            <td class="text-center" style="vertical-align: middle">
                                                <?php 
                                                    $title = 'Đã phê duyệt';
                                                    $icon = 'fa-check fa-fw';
                                                    $color = 'green';
                                                    if ($arr_backu && in_array($listMember[$i]['use_id'], $arr_backu)) {
                                                        $show = 'in';
                                                        $title = 'Phê duyệt';
                                                        $icon = 'fa-pencil-square-o';
                                                        $color = 'black';
                                                    } 
                                                ?>
                                                <a title="<?php echo $title ?>"
                                                   href="#" data-toggle="modal" id="<?php echo $listMember[$i]['use_id']; ?>"
                                                   style="color: <?php echo $color?>"
                                                   data-target="#loaigroup-modal"
                                                   onclick="loai_use_group(<?php echo $listMember[$i]['use_id']; ?>,'<?php echo $nhom_thamgia ?>','<?php echo $nhom_thamgiaID ?>','<?php echo $show ?>');">
                                                    <i class="fa <?php echo $icon ?>"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                }
                            } else { ?>
                                <tr>
                                    <td colspan="5" class="text-center">Không thành viên</td>
                                </tr>
                            <?php }
                            //                        } ?>
                            </tbody>
                        </table>
                    </div>
                <?php } ?>
                <?php echo $linkPage; ?>

                <div id="loaigroup-modal" class="modal fade duyet_loai" tabindex="-1" role="dialog"
                     aria-labelledby="custom-width-modalLabel" aria-hidden="true" style=" padding-right: 17px;">
                    <div class="modal-dialog show_listgroup" style="">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <div class="title" style="text-transform: uppercase">Loại khỏi nhóm</div>
                            </div>

                            <div class="modal-body">
                                <ul class="list_group">
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>

                <script src="<?php echo base_url() . 'templates/home/js/modalEffects.js'; ?>"></script>
                <script>
                    function applyAll(parent_id, group_id) {
                        $.ajax({
                            type: "post",
                            url: "/home/grouptrade/applyAll",
                            cache: false,
                            data: {parent_id: parent_id, group_id: group_id},
                            dataType: 'text',
                            success: function (data) {
                                if (data == '1') {
                                    alert('Success');
                                    location.reload();
                                } else {
                                    alert('Error');
                                }
                            }
                        });
                        return false;
                    }

                    function loai_use_group(use, group_name, group_id, show) {
                        var arr_grtId = group_id.split(', ');
                        var arr_grtname = group_name.split(', ');
                        $('.show_listgroup').fadeIn();
                        var act, title, btn_class, i_chk;
                        for (var i = 0; i < arr_grtId.length; i++) {

                            if (show != '') {
                                act = 'duyet';
                                title = 'Duyệt ';
                                btn_class = 'btn-check';
                                i_chk = 'fa-check';
                            } else {
                                act = 'loai';
                                title = 'Loại khỏi ';
                                btn_class = 'btn-danger';
                                i_chk = 'fa-times';
                            }
                            var item = '<li style="clear:both">' + arr_grtname[i] + '<a href="' + '<?php echo base_url() ?>account/groups/approvemember/' + arr_grtId[i] + '/' + act + '/' + use + '" title="' + title + arr_grtname[i] + '" class="btn ' + btn_class + ' btn-sm loai_nhom pull-right"><i class="fa ' + i_chk + ' fa-fw"></i></a></li>';
                            $('.list_group').append(item);
                        }
                    }
                    $('#loaigroup-modal').click(function () {
                        $("ul.list_group > li").each(function () {
                            $(this).remove();
                        });
                    })
                    $('.close').click(function () {
                        $("ul.list_group > li").each(function () {
                            $(this).remove();
                        });
                    })
                </script>
                <style>
                    .modal-dialog {
                        top: 30%;

                    }

                    .btn-check, .btn-check:hover {
                        background-color: #257cac;
                        border-color: #23709a;
                        color: #fff;
                    }

                    ul.list_group > li {
                        margin-bottom: 10px;
                    }
                </style>
            </div>
        </div>
    </div>
    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
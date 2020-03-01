<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            <div class="col-md-9  col-sm-8 col-xs-12">
                <h4 class="page-header text-uppercase" style="margin-top:10px;">DANH SÁCH NHÂN VIÊN</h4>
                <?php
                    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                    $domainName = $_SERVER['HTTP_HOST'];
                ?>
                
                <?php if (count($staffs) > 0) { ?>

                    <p style="text-align: right; font-weight: bold;">Tổng danh sách nhân viên:
                        <span style="color:#f00;"><?php echo $totalRecord ?></span>
                    </p>

                    <div class="visible-xs">
                        <?php foreach ($staffs as $k => $items){ ?>
                            <div
                                style="border:1px solid #ddd; border-bottom: 0px; display: inline-block; text-align: center; width: 50px; padding: 5px; background: #f9f9f9">
                                <?php echo $sTT + $k; ?>
                            </div>
                            <table class="table table-bordered" style="border-bottom: 2px solid #999; font-size: 12px;">
                                <tr>
                                    <td style="width:100px">Tài khoản</td>
                                    <td>
                                        <strong><a class="text-uppercase" target="_blank"
                                                   href="<?php echo base_url(); ?>user/profile/<?php echo $items['use_id']; ?>"> <?php echo $items['use_username']; ?></a></strong>
                                        <div class="shop_parent active" style="font-size: 12px;color: orangered!important;">
                                            <i><?php echo $items['info_parent'] ?></i>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><span style="text-overflow: ellipsis; white-space: nowrap; overflow: hidden;"><?php echo $items['use_email']; ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Điện thoại</td>
                                    <td><?php echo $items['use_mobile']; ?></td>
                                </tr>
                                
                                <tr>

                                    <td>Nhắn tin</td>
                                    <td>
                                        <?php if ($items['use_message']) { ?>
                                            <a class="btn btn-info btn-sm"
                                               href="<?php echo str_replace("https://www.facebook.com/messages/t/", "https://www.messenger.com/t/", $items['use_message']); ?>"
                                               title="Gửi tin nhắn">
                                                <i class="fa fa-comment fa-fw"></i> &nbsp;Nhắn tin
                                            </a>
                                        <?php } ?>
                                        &nbsp;
                                        <?php if ($items['use_mobile']) { ?>
                                            <a class="btn btn-info btn-sm"
                                               href="sms:<?php echo $items['use_mobile'] ?>">
                                                <i class="fa fa-commenting fa-fw"></i> &nbsp;Gửi SMS
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Phân quyền</td>
                                    <td class="text-center">
                                        <button id = "roleSetting_btn" class="btn btn-primary" data-toggle="modal" data-target="#myModal_mb<?php echo $k;?>">Phân quyền</botton>
                                    </td>
                                </tr>
                            </table>
                            <div class="modal fade" id="myModal_mb<?php echo $k;?>">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <form method="post" enctype="multipart/form-data" id="form-setting-role-mobile_<?php echo $items['use_id']; ?>">
                                        <!-- Modal Header -->
                                        <div class="modal-header">
                                        <h4 class="modal-title">Bảng phân quyền cho nhân viên: <b><?php echo $items['use_username']?></b></h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                
                                        <!-- Modal body -->
                                        <?php foreach ($list_role as $list_part): ?>
                                        <div class="modal-body col-sm-6">
                                            <?php foreach ($list_part as $value): ?>
                                            <?php if (in_array($value->id, $items['emp_roles'])) { ?>
                                                <input type="checkbox" name="role_regis[]" value="<?php echo $value->id;?>" checked><?php echo $value->rol_name;?><br>
                                            <?php } else { ?>
                                                <input type="checkbox" name="role_regis[]" value="<?php echo $value->id;?>"><?php echo $value->rol_name; ?><br>
                                            <?php } ?>
                                            <?php endforeach; ?>
                                        </div>
                                        <?php endforeach; ?>
                                
                                        <!-- Modal footer -->
                                        <div class="modal-footer">
                                        <input type="hidden" id="<?php echo 'userid-mb_'.$items['use_id']; ?>" name="userid" value="<?php echo $items['use_id']; ?>">
                                        <button type="submit" class="btn btn-azibai">Cài đặt</button>
                                        <script>
                                            $("#form-setting-role-mobile_"+ $('#<?php echo 'userid-mb_'.$items['use_id']; ?>').val()).submit(function(event) {
                                                $.ajax({
                                                    type: "POST",
                                                    url: '/account/staffs/modified-role',
                                                    data: $(this).serialize(),
                                                    success: function(resp){
                                                        if (resp == '1') {
                                                            alert('Cập nhập thành công !!!');
                                                        } else {
                                                            alert('Cập nhập không thành công !!!');
                                                        }
                                                    },
                                                    error: function(){alert('Hệ thống đang bị lỗi !!!');}
                                                });
                                                event.preventDefault();
                                            });
                                        </script>
                                        </div>
                                        </form>
                                    </div>
                                    
                                </div>
                            </div>
                            
                        <?php }?>
                    </div>                
                
                    <div class="hidden-xs">
                        <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
                            <thead>
                            <tr>
                                <th width="40" class="title_account_0">STT</th>
                                <th width="300" class="title_account_2" align="center">
                                    Tài khoản
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                         onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')"
                                         border="0" style="cursor:pointer;" alt=""/>
                                    <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                         onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')"
                                         border="0" style="cursor:pointer;" alt=""/>
                                </th>
                                <th>
                                    Email - Điện thoại
                                </th>
                                
                                
                                <th width="100" class="text-center">
                                    Nhắn tin
                                </th>
                                <th width="40" class="">Phân quyền</th>            
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($staffs as $key => $items) { ?>
                                <tr>
                                    <td class="text-center"><?php echo $key + $sTT ?></td>
                                    <td>
                                        <a target="_blank"
                                           href="<?php echo base_url(); ?>user/profile/<?php echo $items['use_id']; ?>"> <?php echo $items['use_username']; ?></a>
                                        <div class="shop_parent active" style="font-size: 12px;color: orangered!important;">
                                            <i><?php echo $items['info_parent'] ?></i>
                                        </div>
                                    </td>
                                    <td>
                                        <i class="fa fa-envelope-o fa-fw"></i> <?php echo $items['use_email']; ?> <br>
                                        <i class="fa fa-phone fa-fw"></i> <?php echo $items['use_mobile']; ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if ($items['use_message']) { ?>
                                            <a class="btn btn-info btn-sm" title="Gửi tin nhắn"
                                               href="<?php echo $items['use_message']; ?>">
                                                <i class="fa fa-comment fa-fw"></i>
                                            </a>
                                        <?php } else { ?>
                                            <a class="btn btn-info btn-sm" title="Gửi tin nhắn SMS"
                                               href="sms:<?php echo $items['use_mobile'] ?>">
                                                <i class="fa fa-comment fa-fw"></i>
                                            </a>
                                        <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <button id = "roleSetting_btn" class="btn btn-primary" data-toggle="modal" data-target="#myModal<?php echo $key ?>">Phân quyền</botton>
                                    </td>
                                </tr>
                                <!-- The Modal -->
                                <div class="modal fade" id="myModal<?php echo $key ?>">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <form method="post" enctype="multipart/form-data" id="form-setting-role_<?php echo $items['use_id']; ?>">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                            <h4 class="modal-title">Bảng phân quyền cho nhân viên: <b><?php echo $items['use_username']?></b></h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                    
                                            <!-- Modal body -->
                                            <?php foreach ($list_role as $list_part): ?>
                                            <div class="modal-body col-sm-6">
                                                <?php foreach ($list_part as $value): ?>
                                                <?php if(in_array($value->id, $items['emp_roles'])){?>
                                                    <input type="checkbox" name="role_regis[]" value="<?php echo $value->id;?>" checked><?php echo $value->rol_name;?><br>
                                                <?php } else {?>
                                                    <input type="checkbox" name="role_regis[]" value="<?php echo $value->id;?>"><?php echo $value->rol_name;?><br>
                                                <?php }?>
                                                <?php endforeach; ?>
                                            </div>
                                            <?php endforeach; ?>
                                    
                                            <!-- Modal footer -->
                                            <div class="modal-footer">
                                                <input type="hidden" id="<?php echo 'userid_'.$items['use_id']; ?>" name="userid" value="<?php echo $items['use_id']; ?>">
                                                <button type="submit" class="btn btn-azibai">Cài đặt</button>
                                            </div>
                                            </form>                            
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $("#form-setting-role_"+ $('#<?php echo 'userid_'.$items['use_id']; ?>').val()).submit(function(event) {
                                        $.ajax({
                                            type: "POST",
                                            url: '/account/staffs/modified-role',
                                            data: $(this).serialize(),
                                            success: function(resp){
                                                if (resp == '1') {
                                                    alert('Cập nhập thành công !!!');
                                                } else {
                                                    alert('Cập nhập không thành công !!!');
                                                }
                                            },
                                            error: function(){alert('Hệ thống đang bị lỗi !!!');}
                                        });
                                        event.preventDefault();
                                    });
                                </script>
                            <?php } ?> 
                            </tbody>
                        </table>
                    </div> 
                
                    <div class="text-center">
                        <?php echo $linkPage; ?>
                    </div>

                <?php } else { ?>
                    <div style="text-align: center; padding: 10px; border:1px solid #eee;">Chưa có dữ liệu cho mục này.</div>
                <?php } ?>
            </div>
        </div>
    </div>
    <!--END RIGHT-->
    
<?php $this->load->view('home/common/footer'); ?>
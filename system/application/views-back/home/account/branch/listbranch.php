<?php $this->load->view('home/common/account/header'); ?>
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
	    
            <div class="col-md-9 col-sm-8 col-xs-12">
		        <h4 class="page-header" style="margin-top:10px">DANH SÁCH CHI NHÁNH</h4>
                <!-- Thông báo lỗi nếu có -->
                <?php if ($this->session->flashdata('flash_message_success') || $this->session->flashdata('flash_message_error')) { ?>
                    <br>
                    <div class="message success">
                        <div class="alert <?php echo($this->session->flashdata('flash_message_error') ? 'alert-danger' : 'alert-success') ?>">
                            <?php echo($this->session->flashdata('flash_message_error') ? $this->session->flashdata('flash_message_error') : $this->session->flashdata('flash_message_success')); ?>
                            <button type="button" class="close" data-dismiss="alert">×</button>
                        </div>
                    </div>
                <?php } ?>                
                <!-- Thông báo lỗi nếu có -->

                <?php if (count($branchs) > 0) { ?>
                    <p class="text-right">
                        <b>Tổng chi nhánh: <span style="color:#f00;"><?php echo $totalRecord ?></span></b>
                    </p>

                    <div class="visible-xs visible-sm">
                        <?php foreach ($branchs as $k => $items): ?>
                            <div
                                style="border:1px solid #ddd; border-bottom: 0px; display: inline-block; text-align: center; width: 50px; padding: 5px; background: #f9f9f9">
                                <?php echo $sTT + $k; ?>
                            </div>
                            <table class="table table-bordered" style="border-bottom: 2px solid #999; font-size: 12px;">
                                <tr>
                                    <td class="text-primary" style="width:90px;">Tài khoản</td>
                                    <td>
                                        <a target="_blank"
                                           href="<?php echo base_url(); ?>user/profile/<?php echo $items['use_id']; ?>">
                                            <?php echo $items['use_username']; ?>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary">Gian hàng</td>
                                    <td>
                                        <a target="_blank" href="<?php echo $items['link_gh'] . '/shop'; ?>">
                                            <?php echo $items['pshop']; ?>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary">Email</td>
                                    <td>
                                        <?php echo $items['use_email']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-primary">Điện thoại</td>
                                    <td>
                                        <?php echo $items['use_mobile']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="100" class="text-primary">Số CTV</td>
                                    <td>
                                        <a href="<?php echo base_url() . 'account/listaffiliate/' . $items['use_id']; ?>" title="Tổng số Cộng tác viên của <?php echo $items['use_username']; ?>">
                                            <?php echo $items['sl']; ?>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <?php if ($group_id != StaffStoreUser) { ?>
                                            <p>
                                                <a class="btn btn-default btn-sm"
                                                   href="<?php echo base_url() . 'branch/configforbranch/' . $items['use_id']; ?>"
                                                   title="Cấu hình chung <?php echo $items['use_username']; ?>">
                                                    <i class="fa fa-cogs fa-fw"></i> &nbsp;Cấu hình chung
                                                </a>
                                            </p>
                                            <p>
                                                <a class="btn btn-default btn-sm" href="<?php echo base_url() . 'account/bank/' . $items['use_id']; ?>" title="Cập nhật tài khoản ngân hàng <?php echo $items['use_username']; ?>">
                                                    <i class="fa fa-pencil-square-o"></i> &nbsp;Cập nhật thông tin tài khoản ngân hàng
                                                </a>
                                            </p>
                                            <p>
                                                <a class="btn btn-default btn-sm" href="<?php echo base_url() . 'account/kho/' . $items['use_id']; ?>" title="Cấu hình kho">
                                                    <i class="fa fa-pencil-square-o  fa-fw"></i> Cấu hình kho
                                                </a>
                                            </p>
                                            <p>
                                                <a class="btn btn-default btn-sm" href="<?php echo base_url() . 'account/limitctv/' . $items['use_id']; ?>" title="Giới hạn ctv <?php echo $items['use_username']; ?>">
                                                    <i class="fa fa-pencil-square-o"></i> &nbsp;Giới hạn số lượng cộng tác viên
                                                </a>
                                            </p>
                                        <?php } ?>
                                        <p>
                                            <?php if ($items['use_message']) { ?>
                                                <a class="btn btn-info btn-sm"
                                                   href="<?php echo str_replace("https://www.facebook.com/messages/t/", "https://www.messenger.com/t/", $items['use_message']); ?>"
                                                   title="Gửi tin nhắn">
                                                    <i class="fa fa-comment fa-fw"></i> &nbsp;Nhắn tin
                                                </a>
                                            <?php } ?>
                                            <?php if ($items['use_mobile']) { ?>
                                                <a class="btn btn-info btn-sm"
                                                   href="sms:<?php echo $items['use_mobile'] ?>?body=Nhập nội dung tin nhắn">
                                                    <i class="fa fa-commenting fa-fw"></i> &nbsp;Gửi SMS
                                                </a>
                                            <?php } ?>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        <?php endforeach; ?>
                    </div>

                    <div class="hidden-xs hidden-sm">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0">
                                <thead>
                                <tr>
                                    <th width="40" class="title_account_0 hidden-xs">STT</th>
                                    <th class="title_account_2" align="center">
                                        Tài khoản
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             onclick="ActionSort('<?php echo $sortUrl; ?>name/by/asc<?php echo $pageSort; ?>')"
                                             border="0" style="cursor:pointer;" alt=""/>
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             onclick="ActionSort('<?php echo $sortUrl; ?>name/by/desc<?php echo $pageSort; ?>')"
                                             border="0" style="cursor:pointer;" alt=""/>
                                    </th>                               
                                    <th class="title_account_2" align="center">
                                        Thông tin chi nhánh
                                    </th>
                                    <th width="120" class="title_account_2" align="center">
                                        Số CTV                                        
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif"
                                             onclick="ActionSort('<?php echo $sortUrl; ?>sl/by/asc<?php echo $pageSort; ?>')"
                                             border="0" style="cursor:pointer;" alt=""/>
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif"
                                             onclick="ActionSort('<?php echo $sortUrl; ?>sl/by/desc<?php echo $pageSort; ?>')"
                                             border="0" style="cursor:pointer;" alt=""/>
                                    </th>
                                    <?php if ($group_id != StaffStoreUser) { ?>
                                        <th width="210" class="title_account_2" align="center">
                                            Cấu hình
                                        </th>
                                    <?php } ?>
				    <th width="100"> 
                                        Nhắn tin
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($branchs as $k => $items): ?>
                                    <tr>
                                        <td height="32" class="hidden-xs line_account_0 text-center">
                                            <p>
                                                <?php echo $sTT + $k; ?>
                                            </p>
                                        </td>
                                        <td height="32" class="line_account_2">
                                            <p>
                                                <a target="_blank" href="<?php echo base_url(); ?>user/profile/<?php echo $items['use_id']; ?>">
                                                    <?php echo $items['use_username']; ?>
                                                </a>
                                            </p>
                                            <div class="shop_parent active" style="font-size: 12px;color: orangered!important;">  <i><?php echo $items['info_parent'] ?></i>
                                               
                                            </div>
                                        </td>
                                       
                                        <td height="32" class="line_account_2">
                                            <p><a target="_blank" href="<?php echo $items['link_gh'] . '/shop'; ?>"><i class="fa fa-share"></i> <?php echo $items['pshop']; ?></a>
                                            </p>
                                            <p><i class="fa fa-envelope-o fa-fw"></i>
                                                <?php echo $items['use_email']; ?>
                                            </p>
                                            <p><i class="fa fa-phone fa-fw"></i>
                                                <?php echo $items['use_mobile']; ?>
                                            </p>
                                        </td>
                                        <td height="32" class="line_account_2 text-center">
                                            <p>
                                                <a href="<?php echo base_url() . 'account/listaffiliate/' . $items['use_id']; ?>"
                                                   title="Tổng số Cộng tác viên của <?php echo $items['use_username']; ?>">
                                                    <?php echo $items['sl']; ?>
                                                </a>
                                            </p>
                                        </td>
                                        <?php if ($group_id != StaffStoreUser) { ?>
                                            <td height="32" class="line_account_2">
                                                <p>
                                                    <a class="btn btn-default " href="<?php echo base_url() . 'branch/configforbranch/' . $items['use_id']; ?>" title="Cấu hình chi nhánh">
                                                        <i class="fa fa-cog fa-fw"></i> Cấu hình chi nhánh
                                                    </a>
						</p>
						<p>
                                                    <a class="btn btn-default " href="<?php echo base_url() . 'account/bank/' . $items['use_id']; ?>"
                                                       title="Cập nhật tài khoản ngân hàng">
                                                        <i class="fa fa-cog fa-fw"></i> Tài khoản ngân hàng
                                                    </a>
                                                </p>
						<p>
                                                    <a class="btn btn-default " href="<?php echo base_url() . 'account/kho/' . $items['use_id']; ?>"
                                                       title="Cấu hình kho">
                                                        <i class="fa fa-cog fa-fw"></i> Cấu hình kho
                                                    </a>
                                                </p>
						<p>
                                                    <a class="btn btn-default " href="<?php echo base_url() . 'account/limitctv/' . $items['use_id']; ?>" title="Giới hạn ctv">
                                                        <i class="fa fa-cog fa-fw"></i> Giới hạn cộng tác viên
                                                    </a>
                                                </p>
                                            </td>
                                        <?php } ?>
                                        <td class="text-center">
                                            <p>
                                                <?php if ($items['use_message']) { ?>
                                                    <a class="btn btn-info btn-sm" title="Gửi tin nhắn"
                                                       href="<?php echo $items['use_message']; ?>">
                                                        <i class="fa fa-comment fa-fw"></i>
                                                    </a>
                                                <?php } else { ?>
                                                    <a class="btn btn-info btn-sm" title="Gửi tin SMS"
                                                       href="sms:<?php echo $items['use_mobile'] ?>?body=Nhập nội dung tin nhắn">
                                                        <i class="fa fa-commenting fa-fw"></i>
                                                    </a>
                                                <?php } ?>
                                            </p>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>                                
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php echo $linkPage; ?>

                <?php } else { ?>
                     <div class="none_record"><p class="text-center">Không có dữ liệu</p></div>  
                <?php } ?>
            </div>

        </div>
    </div>
    <!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
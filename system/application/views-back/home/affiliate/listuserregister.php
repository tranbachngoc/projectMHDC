<?php $this->load->view('home/common/account/header'); ?>

<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <?php
            $group_id = $this->session->userdata('sessionGroup');
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
            $domainName = $_SERVER['HTTP_HOST'];
        ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header  text-uppercase" style="margin-top:10px">
                Danh sách đang ký qua trang doanh nghiệp
            </h4>

            <p class="col-sm-12" style="text-align: right; font-weight: bold;">Tổng: 
                <span style="color:#f00;"><?php echo $totalRecord ?></span>
            </p>

            <div class="visible-xs small">               
                <div style="border:1px solid #ddd; border-bottom: 0px; display: inline-block; text-align: center; width: 50px; padding: 5px; background: #f9f9f9">
                    <?php echo $stt + 1; ?>
                </div>
                <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0" style="background: #fff;">
                    <tr>
                        <td width="100">Tài khoản</td>
                        <td>
                            <a target="_blank"  href="<?php echo base_url(); ?>user/profile/<?php echo $items->use_id; ?>"> <?php echo $items->use_username; ?></a>  
                        </td>
                    </tr>

                    <tr>
                        <td>Tên Gian hàng</td>
                        <td>
                            <?php if ($items->sho_name != '') { ?>
                                <a href="#" target="_blank"><?php echo $items->sho_name; ?></a>
                            <?php } else { echo 'Chưa cập nhập';} ?>
                        </td>
                    </tr>                          
                   
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
                </table> 
            </div>

            <div class="hidden-xs">
                <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0" style="background: #fff;">
                    <?php if (count($listUser) > 0) { ?>
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
                           
                            <th width="" class="title_account_2" align="center">
                                Email - Điện thoại
                            </th>
                            <th width=80" class="title_account_2" align="center">
                                Nhắn tin
                            </th>                            
                        </tr>
                        </thead>

                        <tbody>
                        <?php
                        $total = 0;
                        foreach ($listUser as $key => $items) {                          
                            $link_shop = $protocol.$items->sho_link.'.'.domain_site.'/shop';
                            if ($items->domain != '') {
                                $link_shop = $protocol.$items->domain.'/shop';
                            }
                        ?>
                        <tr>
                            <td class="line_account_0 text-center"><?php echo $key + 1 + $stt; ?></td>
                            <td class="line_account_2">
                                <a target="_blank" href="<?php echo base_url(); ?>user/profile/<?php echo $items->use_id; ?>">
                                    <?php echo $items->use_username; ?>
                                </a>                                                             
                            </td>
                            <?php
                            if ($group_id == AffiliateStoreUser || $group_id == StaffStoreUser) {
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
                                    <a class="btn btn-info btn-sm" href="<?php echo $items->use_message; ?>" title="Gửi tin nhắn">
                                        <i class="fa fa-comment fa-fw"></i>
                                    </a>
                                <?php } ?>
                            </td>                            
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
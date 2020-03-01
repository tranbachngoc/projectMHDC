<?php $this->load->view('home/common/header'); ?>

    <div id="main" class="container-fluid">
        <div class="row">
            <div class="col-lg-2 hidden-md hidden-sm hidden-xs">
                <?php $this->load->view('home/common/left_tintuc'); ?>
            </div>
            <div class="col-lg-10 pull-right ">
                <div class="col-sm-12">
                    <div class="breadcrumbs hidden-xs">
                        <a href="http://localhost/azibai/">Trang chủ</a><i class="fa fa-angle-right"></i>
                        <span> Danh sách Affiliate của <strong><a
                                    href="<?php echo base_url() ?>user/profile/<?php echo $this->uri->segment('3'); ?>"><?php echo $parent_name ?></a></strong></span>
                        </span>
                    </div>
                    <div class="panel panel-default">
                        <!--    <div class="panel-heading text-uppercase"><h2 style="margin:0; font-size:18px">Thông tin thành viên -->
                        <?php //echo $user->use_username; ?><!--</h2></div>-->

                        <!--BEGIN: RIGHT-->
                        <?php
                        $group_id = (int)$this->session->userdata('sessionGroup');
                        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
                        $domainName = $_SERVER['HTTP_HOST'];
                        ?>

                        <div class="col-lg-12 col-md-12 col-sm-11">
                            <div class="visible-xs">
                                <?php if (count($totalaff) > 0) {
                                    $total = 0;
                                    foreach ($totalaff as $key => $items) :
                                        ?>
                                        <div
                                            style="border: 1px solid #eee; padding: 10px 15px; margin-bottom: 15px; background:  #fff;">
                                            <div class="pull-right"
                                                 style="background:#eee; margin: -10px -15px 0 0; width:30px; padding:5px 0; text-align: center"><?php echo $k + $sTT ?></div>
                                            <p><span class="text-primary">Tài khoản</span>:
                                                <a target="_blank" title="<?php echo $items['info_parent']; ?>"
                                                   href="<?php echo base_url(); ?>user/profile/<?php echo $items['use_id']; ?>"> <?php echo $items['showcarttotal'] . $items['use_username']; ?></a>
                                            </p>
                                            <p><span
                                                    class="text-primary">Tên gian hàng</span>: <?php echo $items['sho_name']; ?>
                                            </p>
                                            <p><span class="text-primary">Link gian hàng</span>:
                                                <a target="_blank" href=" <?php if ($items['haveDomain'] != '') {
                                                    echo $protocol . $items['haveDomain'] . '/' . $items['sho_link'];
                                                } else {
                                                    echo $protocol . $items['pshop'] . '.' . $domainName . '/' . $items['sho_link'];
                                                } ?>">
                                                    <?php echo $items['sho_link']; ?>
                                                </a></p>
                                            <p><span
                                                    class="text-primary">Email</span>: <?php echo $items['use_email']; ?>
                                            </p>
                                            <p><span
                                                    class="text-primary">Điện thoại</span>: <?php echo $items['use_mobile']; ?>
                                            </p>
                                        </div>
                                    <?php endforeach;
                                } else {
                                    echo 'Không có dữ liệu!';
                                } ?>
                            </div>
                            <div class="hidden-xs">
                                <div style="overflow: auto; width:100%">
                                    <tr>
                                    </tr>

                                    <table class="table table-bordered" width="100%" border="0" cellpadding="0"
                                           cellspacing="0">
                                        <thead>
                                        <tr>
                                            <th width="5%" class="title_account_0">STT</th>
                                            <th width="20%" class="title_account_2" align="center">
                                                Tài khoản
                                            </th>
                                            <th width="30%" class="title_account_2" align="center">
                                                Tên gian hàng
                                            </th>
                                            <th width="20%" class="title_account_2" align="center">
                                                Link gian hàng
                                            </th>
                                            <th width="15%" class="title_account_2" align="center">
                                                Email
                                            </th>
                                            <th width="15%" class="title_account_2" align="center">
                                                Điện thoại
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $i = 0;
                                        foreach ($totalaff as $key => $items) {
                                            $i++;
                                            ?>
                                            <tr>
                                                <td width="5%" height="32"
                                                    class="line_account_2"><?php echo $sTT + $i; ?></td>
                                                <td width="10%" height="32" class="line_account_2">
                                                    <a target="_blank" title="<?php echo $items['info_parent']; ?>"
                                                       href="<?php echo base_url(); ?>user/profile/<?php echo $items['use_id']; ?>"> <?php echo $items['use_username']; ?></a>
                                                    <br>
                                                    <span
                                                        style="color: #f00; font-size: 12px;"><?php echo $items['info_parent']; ?></span>
                                                </td>
                                                <td width="20%" height="32"
                                                    class="line_account_2"><?php echo $items['sho_name']; ?></td>
                                                <td width="10%" height="32" class="line_account_2">
                                                    <a target="_blank" href="<?php if ($items['haveDomain'] != '') {  echo $protocol . $items['haveDomain'] . '/' . $items['sho_link'];
                                                         } else {
                                                        echo $protocol . $items['pshop'] . '.' . $domainName . '/' . $items['sho_link'];
                                                    } ?>">
                                                        <?php echo $items['sho_link']; ?>
                                                    </a>
                                                </td>
                                                <td width="15%" height="32" class="line_account_2">
                                                    <?php echo $items['use_email']; ?>
                                                </td>
                                                <td width="15%" height="32" class="line_account_2">
                                                    <?php echo $items['use_mobile']; ?>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <?php if (count($totalaff) <= 0) { ?>
                                            <tr>
                                                <td colspan="7">
                                                    <div class="nojob">Không có dữ liệu!</div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>

                                </div>
                                <?php echo $linkPage; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--END LEFT-->

<?php $this->load->view('home/common/footer'); ?>
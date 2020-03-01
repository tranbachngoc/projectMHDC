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
                        <span>  Chi tiết doanh số <?php if($profile->use_group == AffiliateUser) echo ' cộng tác viên';?>
                            <strong><a href="<?php echo base_url()?>user/profile/<?php echo $profile->use_id ?>"><?php echo $profile->use_username?></a></strong></span>
                    </div>
                    <div class="visible-xs">
                        <?php if (count($liststoreAF) > 0) {
                            $total = 0;
                            foreach ($liststoreAF as $key => $items):
                                ?>
                                <div
                                    style="border: 1px solid #eee; padding: 10px 15px; margin-bottom: 15px; background:  #fff;">
                                    <div class="pull-right"
                                         style="background:#eee; margin: -10px -15px 0 0; width:30px; padding:5px 0; text-align: center"><?php echo $k + $sTT ?></div>
                                    <p><span
                                            class="text-primary">Tên cộng tác viên</span>: <?php echo $items->use_username; ?></a>
                                    </p>
                                    <p><span class="text-primary">Tên sản phẩm</span>: <?php echo $items->pro_name; ?>
                                    </p>
                                    <p><span class="text-primary">Số lượng</span>: <?php echo $items->shc_quantity ?>
                                    </p>
                                    <p><span
                                            class="text-primary">Ngày mua</span>: <?php echo date('d-m-Y', $items->shc_change_status_date); ?>
                                    </p>
                                    <p>
                                        <span class="text-primary">Doanh Thu</span>: <?php echo number_format($items->shc_total, 0, ",", "."); ?>Vnđ
                                    </p>
                                </div>
                            <?php endforeach;
                        } else{ echo 'Không có dữ liệu!';} ?>
                    </div>
                    <div class="hidden-xs">
                        <div class="panel panel-default">
                            <div class="col-lg-12 col-md-12 col-sm-11">
                                <div style="overflow: auto; width:100%;">
                                    <table class="table table-bordered" width="100%" border="0" cellpadding="0"
                                           cellspacing="0">
                                        <?php if (count($liststoreAF) > 0) { ?>
                                            <thead>
                                            <tr>
                                                <th width="5%" class="title_account_0">STT</th>
                                                <th width=20%" class="title_account_2" align="center">
                                                    Tên sản phẩm
                                                </th>
                                                <th width=15%" class="title_account_2" align="center">
                                                    Số lượng
                                                </th>
                                                <th width=15%" class="title_account_2" align="center">
                                                    Ngày mua
                                                </th>
                                                <th width=10%" class="title_account_2" align="center">
                                                    Doanh Thu
                                                </th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $total = 0;
                                            foreach ($liststoreAF as $key => $items) { ?>
                                                <tr>
                                                    <td width="5%" height="32"
                                                        class="line_account_0"><?php echo $key + 1 + $stt; ?></td>
                                                    <td width="20%" height="32" class="line_account_2">
                                                        <?php echo $items->pro_name ?>
                                                    </td>
                                                    <td width="10%" height="32" class="line_account_2">
                                                        <?php echo $items->shc_quantity ?>
                                                    </td>
                                                    <td width="10%" height="32" class="line_account_2">
                                                        <?php echo date('d-m-Y', $items->shc_change_status_date); ?>
                                                    </td>
                                                    <td width="20%" height="32" class="line_account_2">
                                                        <span
                                                            style="color: #ff0000; font-weight: 600">  <?php echo number_format($items->shc_total, 0, ",", "."); ?>
                                                            Vnđ</span>
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
                </div>
            </div>
        </div>
    </div>
    <!--END LEFT-->

<?php $this->load->view('home/common/footer'); ?>
<?php $this->load->view('home/common/account/header'); ?>
<div class="container-fluid">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <div class="col-md-9 col-sm-8 col-xs-12">
            <h4 class="page-header text-uppercase" style="margin-top:10px"> 
                Thống kê lượt view theo  sản phẩm
            </h4>

            <script type="text/javascript">
                function copylink(link) {
                    clipboard.copy(link);
                }
                function submitForm() {
                    jQuery("#share-form").submit();
                }
            </script>
            <?php if (count($list) > 0) { ?>
                <div class="table-responsive">
                    <table class="table table-bordered">                    
                        <thead>
                            <tr>
                                <td width="5%" class="text-center hidden-xs">STT</td>
                                <?php
                                if ($use_group != false && $use_group == 3) {
                                    ?>
                                    <td class="text-center">Tên Af / Af_key
                                    </td>
                                    <?php
                                }
                                ?>
                                <td class="text-center">Thời gian xem</td>
                                <td>Thiết bị truy cập</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($list as $k => $item):
                                ?>
                                <tr>
                                    <td class="hidden-xs"><?php echo $stt + $k; ?></td>
                                    <?php
                                    if ($use_group != false && $use_group == 3) {
                                        ?>
                                        <td>
                                            <span class="text-primary"><?php echo $item->use_fullname; ?></span></br>
                                            <span class="text-default"><?php echo $item->af_key; ?></span>
                                        </td>
                                        <?php
                                    }
                                    ?>

                                    <td>
                                        <?php echo $item->time_view; ?>
                                    </td>

                                    <td> <?php echo $item->agent_view; ?></td>

                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            <?php echo $linkPage; ?>
            <?php } else { ?>
                <div class="none_record">
                    <p class="text-center">Không có dữ liệu</p>
                </div>
            <?php } ?>
            <br/>
        </div>
    </div>
</div>
<?php $this->load->view('home/common/footer'); ?>
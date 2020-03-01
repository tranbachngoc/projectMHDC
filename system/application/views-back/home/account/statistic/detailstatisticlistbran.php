<?php $this->load->view('home/common/account/header'); ?>
<div class="container">
    <div class="row">
        <?php $this->load->view('home/common/left'); ?>
        <!--BEGIN: RIGHT-->
        <div class="col-lg-9 col-md-9 col-sm-8">
            <h2 class="page-title text-uppercase">
                Chi tiết doanh số theo gian hàng
            </h2>
            <div style="overflow: auto; width:100%;">
                <table class="table table-bordered"  width="100%" border="0" cellpadding="0" cellspacing="0">
                    <?php if(count($liststoreAF) > 0){?>
                        <thead>
                        <tr>
                            <th width="5%" class="title_account_0">STT</th>
                            <th width="20%" class="title_account_2" align="center">
                                Tên gian hàng
                            </th>
                            <th width=20%" class="title_account_2" align="center" >
                                Tên sản phẩm
                            </th>
                            <th width=15%" class="title_account_2" align="center">
                                Số lượng
                            </th>
                            <th width=15%" class="title_account_2" align="center" >
                                Ngày mua
                            </th>
                            <th width=10%" class="title_account_2" align="center" >
                                Doanh Thu
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $total = 0;
                        foreach($liststoreAF as $key => $items) {?>
                            <tr>
                                <td width="5%" height="32" class="line_account_0"><?php echo $key+1+$stt; ?></td>
                                <td width="20%" height="32" class="line_account_2">
                                    <?php echo $items->use_username ?>
                                </td>
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
                                    <span style="color: #ff0000; font-weight: 600">  <?php echo number_format($items->shc_total,0,",",".");?> đ</span>
                                </td>
                            </tr>
                        <?php }?>
                        </tbody>
                    <?php }else{?>
                        <tr>
                            <td class="text-center">
                                Không có dữ liệu!
                            </td>
                        </tr>
                    <?php }?>
                </table>
            </div>
            <?php echo $linkPage;?>
        </div>
    </div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>


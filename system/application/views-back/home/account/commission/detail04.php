<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2/1/2016
 * Time: 5:28 AM
 */
$group_id = (int)$this->session->userdata('sessionGroup');
?>
<?php $this->load->view('home/common/header'); ?>
    <div class="container">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            <div class="col-lg-9 col-md-9 col-sm-8">
                <h2 class="page-title text-uppercase">
                    <?php echo $commission->description; ?>
                </h2>
                <div style="width:100%; overflow-y: auto;">
                    <form name="frmAccountPro" action="<?php echo $link; ?>" method="post" >
                        <table class="table table-bordered afBox">
                            <tbody>
                            <tr>
                                <td width="5%" class="aligncenter hidden-xs">STT</td>
                                <td class="text-center">Từ thành viên</td>
                                <td class="text-center">Doanh thu</td>
                                <td class="text-center hidden-xs">Danh mục</td>
                                <td class="text-center hidden-xs">Hoa hồng %</td>
                                <td class="text-center hidden-xs">Lợi nhuận Azibai</td>
                                <td class="text-center hidden-xs">Ngày</td>
                            </tr>
                            <?php
                            $total = 0;
                            foreach ($retail as $k => $item) {?>
                                <tr >
                                    <td align="center"><?php echo $k+1; ?></td>
                                    <td align="center">
                                        <?php echo $item->use_username; ?>
                                    </td>
                                    <td align="center">
                                        <span style="color:#FF0000; font-weight:bold"><?php echo number_format($item->pro_price, 0, ",", ".") ;?> đ</span>
                                    </td>
                                    <td align="center">
                                        <?php echo $item->cat_name; ?>
                                    </td>
                                    <td align="center">
                                        <?php echo $item->rsc_percent; ?> %
                                    </td>
                                    <td align="center"><span style="color:#FF0000; font-weight:bold"><?php echo number_format(($item->shc_total*$item->rsc_percent)/100, 0, ",", ".") ;?> đ</span></td>
                                    <td align="center"><?php echo date('d/m/Y',$item->shc_change_status_date); ?></td>
                                </tr>
                                <?php
                                $total += ($item->shc_total*$item->rsc_percent)/100;
                            } ?>
                            <tr>
                                <td colspan="8" align="center">
                                    <div class="nojob">Tổng lợi nhuận của Azibai: <span style="color:#FF0000; font-weight:bold"><?php echo number_format($total, 0, ",", ".") ;?> đ</span> </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" align="center">
                                    <div class="nojob">Hoa hồng nhận được: <span style="color:#FF0000; font-weight:bold"><?php echo number_format(($total*$commission->percent)/100, 0, ",", ".") ;?> đ</span>  (Phần trăm hoa hồng <span style="color:#FF0000; font-weight:bold"><?php echo $commission->percent; ?>%</span>)</div>
                                </td>
                            </tr>
                            <?php if (count($retail) <=0){ ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Không có dữ liệu!</div>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('home/common/footer'); ?>
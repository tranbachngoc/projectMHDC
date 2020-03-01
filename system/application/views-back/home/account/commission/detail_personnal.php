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
                <?php if ($group_id == AffiliateStoreUser){
                    echo 'Chi tiết Hoa hồng';
                } else{
                    echo 'Chi tiết Hoa hồng';
                }
                 ?>
                </h2>
                <div style="width:100%; overflow-y: auto;">
                    <form name="frmAccountPro" action="<?php echo $link; ?>" method="post" >
                        <table class="table table-bordered afBox">
                            <tbody>
                            <tr>
                                <td width="5%" class="aligncenter hidden-xs">STT</td>
                                <td class="text-center">Từ Gian hàng</td>
                                <td class="text-center">Doanh thu</td>
                                <td class="text-center">Gói dịch vụ</td>
                                <td class="text-center hidden-xs">Doanh thu cho Azibai</td>
                                <td class="text-center hidden-xs">Loại hoa hồng</td>
                                <td class="text-center hidden-xs">Ngày</td>
                            </tr>
							<?php
                            $total_pk = 0;
                            if (count($listUserPackage) > 0 || count($listUserPackageDaily) > 0){
                            foreach ($listUserPackage as $k => $item):?>
                                <!-- Modal -->
                                <tr id="af_row_<?php echo $item->id;?>">
                                    <td align="center"><?php echo $num + $k + 1;?></td>
                                    <td align="center">
                                        <a target="_blank" href="<?php echo base_url().$item->sho_link; ?>"> <?php echo $item->use_username; ?></a>
                                    </td>

                                    <td align="right"><div class="" style="color:#FF0000; font-weight:bold">
									<?php echo number_format($item->real_amount, 0, ",", ".") ; ?> đ
                                    </div>

                                    </td>
                                    <td align="center">
                                        <?php echo $item->name; ?>
                                    </td>
                                    <td align="right"><div class="" style="color:#FF0000; font-weight:bold">
									<?php echo number_format($item->real_amount, 0, ",", "."); ?> đ
									</div>
                                    </td>
                                    <td align="center"><?php echo $commission->description; ?>
                                    </td>
                                    <td align="center"><?php echo date("d-m-Y",strtotime($item->created_date)); ?>
                                    </td>

                                </tr>
                            <?php $total_pk += $item->real_amount;
                                    endforeach; ?>
                                    <?php
                                    $total_pkd = 0;
                                    foreach ($listUserPackageDaily as $k => $item):?>
                                        <!-- Modal -->
                                        <tr id="af_row_<?php echo $item->id;?>">
                                            <td align="center"><?php echo $num + ($k+1) + 1;?></td>
                                            <td align="center">
                                                <a target="_blank" href="<?php echo base_url().$item->sho_link; ?>"> <?php echo $item->use_username; ?></a>
                                            </td>
                                            <td align="right"><div class="" style="color:#FF0000; font-weight:bold">
                                                    <?php echo number_format($item->total, 0, ",", ".") ; ?> đ
                                                </div>

                                            </td>
                                            <td align="center">
                                                <?php echo $item->p_name; ?>
                                            </td>
                                            <td align="right"><div class="" style="color:#FF0000; font-weight:bold">
                                                    <?php echo number_format($item->total, 0, ",", "."); ?> đ
                                                </div>
                                            </td>
                                            <td align="center"><?php echo $commission->description; ?>
                                            </td>
                                            <td align="center"><?php echo date("d-m-Y",strtotime($item->created_date)); ?>
                                            </td>

                                        </tr>
                                        <?php
                                        $total_pkd += $item->total;
                                        endforeach; ?>

                                <tr>
                                    <?php $total = $total_pkd + $total_pk; ?>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Tổng doanh thu cho Azibai (đã trừ 10% VAT) <span style="color:#FF0000; font-weight:bold"><?php echo number_format(($total - (FEE_VAT * $total)), 0, ",", ".") ;?> đ</span> </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Hoa hồng nhận được <span style="color:#FF0000; font-weight:bold"><?php echo number_format((($total - (FEE_VAT * $total)) * $commission->percent)/100, 0, ",", ".") ;?> đ</span>  (Phần trăm hoa hồng <span style="color:#FF0000; font-weight:bold"><?php echo $commission->percent; ?>%</span>)</div>
                                    </td>
                                </tr>
                            <?php  }else{ ?>
                                <tr>
                                    <td colspan="7" align="center">
                                        <div class="nojob">Không có dữ liệu!</div>
                                    </td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('home/common/footer'); ?>
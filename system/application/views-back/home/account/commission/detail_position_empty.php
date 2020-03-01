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
                                <td width="5%" rowspan="2" class="aligncenter hidden-xs">STT</td>
                                <td rowspan="2" class="text-center">Từ thành viên</td>
                                <td colspan="2" class="text-center">Lợi nhuận cho Azibai</td>
                                <td rowspan="2" class="text-center">Loại hoa hồng</td>
                                <td rowspan="2" class="text-center hidden-xs">Ngày</td>
                            </tr>
                            <tr>
                                <td>Nhóm</td>
                                <td>Cá nhân</td>
                            </tr>
                            <?php if (count($commis) > 0){
                                $stt = 1;
                                $total_user = 0;
                                foreach ($commis as $item) {
                                    $total_user += $item->total + $item->private_profit;
                                    ?>
                                    <tr>
                                        <td><?php echo $stt;?></td>
                                        <td><?php echo $item->use_username;?></td>
                                        <td><?php
                                            if ($item->total > 0){?>
                                                <span style="color:#FF0000; font-weight:bold"><?php echo number_format($item->total, 0, ",", ".") ;?> đ</span>
                                          <?php  }else{?>
                                               0 <span style="color:#FF0000; font-weight:bold"><?php echo number_format($item->private_profit, 0, ",", ".") ;?> đ</span>
                                            <?php }?>
                                           </td>
                                        <td>  <span style="color:#FF0000; font-weight:bold"><?php echo number_format($item->private_profit, 0, ",", ".") ;?> đ</span></td>
                                        <td><?php
                                            switch ($item->type){
                                                case '01': echo 'Hoa hồng mua sỉ';
                                                    break;
                                                case '02': echo 'Hoa hồng bán sỉ';
                                                    break;
                                                case '03': echo 'Hoa hồng bán giải pháp';
                                                    break;
                                                case '04': echo 'Hoa hồng mua lẻ';
                                                    break;
                                                case '05': echo 'Hoa hồng bán lẻ';
                                                    break;
                                            }
                                            ?></td>
                                        <td><?php echo $commission->created_date_str;?></td>
                                    </tr>
                            <?php   $stt += 1;
                                }
                            }else{?>
                            <tr>
                                <td colspan="5" align="center" >Không có dữ liệu</td>
                            </tr>
                            <?php }?>
                            </tbody>
                        </table>
                        <table class="table table-bordered afBox">
                            <tbody>
                            <tr>
                                <td width="5%" class="aligncenter hidden-xs">STT</td>
                                <td class="text-center">Dev1</td>
                                <td class="text-center">Partner2</td>
                                <td class="text-center">Partner1</td>
                                <td class="text-center hidden-xs">Coremember</td>
                                <td class="text-center hidden-xs">Loại hoa hồng</td>
                                <td class="text-center hidden-xs">Doanh số</td>
                                <td class="text-center hidden-xs">Ngày</td>
                            </tr>
                                    <?php
                                    $hh1 = 0;
                                    $hh2 = 0;
                                    $hh3 = 0;
                                    $hh4 = 0;
                                    $totalproip = 0;
                                    foreach ($commissioEmpty as $k => $item) {?>
                                        <tr >
                                            <td align="center"><?php echo $k+1; ?></td>
                                            <td align="center">
                                                <?php echo $item->dev1_percent; $hh1 += $item->dev1_percent;?> %
                                            </td>
                                            <td align="center">
                                                <?php echo $item->partner2_percent; $hh2 += $item->partner2_percent; ?> %
                                            </td>
                                            <td align="center">
                                                <?php echo $item->partner1_percent; $hh3 += $item->partner1_percent; ?> %
                                            </td>
                                            <td align="center">
                                                <?php echo $item->coremember_percent; $hh4 += $item->coremember_percent; ?> %
                                            </td>
                                            <td align="center">
                                                <?php
                                                    switch ($item->type){
                                                        case '01': echo 'Hoa hồng mua sỉ';
                                                            break;
                                                        case '02': echo 'Hoa hồng bán sỉ';
                                                            break;
                                                        case '03': echo 'Hoa hồng bán giải pháp';
                                                            break;
                                                        case '04': echo 'Hoa hồng mua lẻ';
                                                            break;
                                                        case '05': echo 'Hoa hồng bán lẻ';
                                                            break;
                                                    }
                                                $totalproip += $item->user_child_profit;
                                                ?>
                                            </td>
                                            <td align="center"><span style="color:#FF0000; font-weight:bold"><?php echo number_format($item->user_child_profit, 0, ",", ".") ;?> đ</span></td>
                                            <td align="center"><?php echo $item->created_date_str; ?></td>
                                        </tr>
                                <?php } ?>
                                <tr>
                                    <?php $total = $hh1 + $hh2 + $hh3 + $hh4; ?>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Tổng doanh số của <?php echo $commissioEmpty[0]->use_username; ?>: <span style="color:#FF0000; font-weight:bold"><?php echo number_format($total_user, 0, ",", ".") ;?> đ</span> </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Hoa hồng nhận được: <span style="color:#FF0000; font-weight:bold"><?php echo number_format(($total*$total_user)/100, 0, ",", ".") ;?> đ</span>  (Phần trăm hoa hồng <span style="color:#FF0000; font-weight:bold"><?php echo $total; ?>%</span>)</div>
                                    </td>
                                </tr>
                            <?php if (count($commissioEmpty) <=0){ ?>
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
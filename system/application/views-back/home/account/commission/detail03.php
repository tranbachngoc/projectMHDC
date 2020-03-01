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
                            <?php if($commission->group_id == 6){ ?>
                            <tr>
                                <td width="5%" class="aligncenter hidden-xs">STT</td>

                                <td class="text-center">Từ Gian hàng
                                    
                                </td>

                                <td class="text-center">Doanh thu
                                    
                                </td>      

                                 <td class="text-center">Gói dịch vụ                                    
                                </td>

                                  <td class="text-center hidden-xs">Doanh thu cho Azibai
                                   
                                </td>

                               
                                <td class="text-center hidden-xs">Loại hoa hồng
                                   
                                </td>
                                <td class="text-center hidden-xs">Ngày
                                   
                                </td>
                                

                            </tr>
							<?php  
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
                                    <td align="center">Hoa hồng Bán giải pháp
                                    </td>
                                    <td align="center"><?php echo date("d-m-Y",strtotime($item->created_date)); ?>
                                    </td>
                                    
                                </tr>
                            <?php  endforeach; ?>

                                    <?php  foreach ($listUserPackageDaily as $k => $item):?>

                                        <!-- Modal -->

                                        <tr id="af_row_<?php echo $item->id;?>">
                                            <td align="center"><?php echo $num + ($k+1) + 1;?></td>
                                            <td align="center">
                                                <a target="_blank" href="<?php echo base_url().$item->sho_link; ?>"> <?php echo $item->use_username; ?></a>
                                            </td>

                                            <td align="right"><div class="" style="color:#FF0000; font-weight:bold">
                                                    <?php echo number_format($item->real_amount, 0, ",", ".") ; ?> đ
                                                </div>

                                            </td>
                                            <td align="center">
                                                <?php echo $item->p_name; ?>
                                            </td>
                                            <td align="right"><div class="" style="color:#FF0000; font-weight:bold">
                                                    <?php echo number_format($item->real_amount, 0, ",", "."); ?> đ
                                                </div>
                                            </td>
                                            <td align="center">Hoa hồng Bán giải pháp
                                            </td>
                                            <td align="center"><?php echo date("d-m-Y",strtotime($item->created_date)); ?>
                                            </td>

                                        </tr>
                                        <?php  endforeach; ?>
                             	<?php if(count($revenueService) > 0){ ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Tổng doanh thu cho Azibai (đã trừ 10% VAT) <span style="color:#FF0000; font-weight:bold"><?php echo number_format($revenueService[0]->total, 0, ",", ".") ;?> đ</span> </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Hoa hồng nhận được <span style="color:#FF0000; font-weight:bold"><?php echo number_format($commission->commission, 0, ",", ".") ;?> đ</span>  (Phần trăm hoa hồng <span style="color:#FF0000; font-weight:bold"><?php echo $commission->percent; ?>%</span>)</div>
                                    </td>
                                </tr>
                                <?php } ?>
                           	 <?php if(count($revenueService) <= 0){ ?>
                                <tr>
                                    <td colspan="7" align="center">
                                        <div class="nojob">Không có dữ liệu!</div>
                                    </td>
                                </tr>
                              <?php } ?>
                              
                           <?php }else{
						   // thanh vien tu dev1 tro len
						   ?>
                                <?php if (count($revenueServiceFromDev1Up) > 0){ ?>
                           	<tr>
                                <td width="5%" class="aligncenter hidden-xs" rowspan=2>STT</td>
                                <td class="text-center" rowspan=2>Từ thành viên</td>
                                <td class="text-center hidden-xs" colspan=2>Lợi nhuận cho Azibai</td>
                                <td class="text-center hidden-xs" rowspan=2>Loại hoa hồng</td>
                                <td class="text-center hidden-xs" rowspan=2>Ngày</td>
                            </tr>
                            <tr>
                                <td class="text-center" >Nhóm</td>
                                <td class="text-center" >Cá nhân</td>
                            </tr>
							<?php $sum = 0; foreach ($revenueServiceFromDev1Up as $k => $itemServiceDev1Up): ?>

                                <!-- Modal -->
                                <tr id="af_row_<?php echo $itemServiceDev1Up->id;?>">
                                    <td align="center"><?php echo $num + $k + 1;?></td>
                                    <td align="center">
                                       <?php echo $itemServiceDev1Up->use_username; ?>
                                    </td>
                                    
                                    <td align="center"><div class="" style="color:#FF0000; font-weight:bold">
									    <?php 
                                        $personalStr = '';
                                        $monthYear = explode('-', $itemServiceDev1Up->revenue_month_year);
                                        if($itemServiceDev1Up->group_id == 6) { $personalStr = '?isPersonal=1'; }
                                        if($itemServiceDev1Up->total > 0) {
                                    ?>
                                    <a href="<?php echo base_url().'account/detail-commission/'.$itemServiceDev1Up->user_id.'/type/'.$itemServiceDev1Up->type.'/month/'.$monthYear[0].'/year/'.$monthYear[1].$personalStr; ?>" target="_blank" >
                                    <?php echo number_format($itemServiceDev1Up->total + $itemServiceDev1Up->private_profit, 0, ",", ".") ;  ?> đ
                                    <i class="fa fa-external-link" aria-hidden="true"></i>
                                    </a>
                                    <?php } else{
                                        echo number_format($itemServiceDev1Up->total + $itemServiceDev1Up->private_profit, 0, ",", ".").' đ' ; 
                                    }?>
                                    </div>
									
                                    </td>
                                    <td><div class="" style="color:#FF0000; font-weight:bold">
                                    <?php if(($itemServiceDev1Up->total > 0 && $itemServiceDev1Up->group_id == 6) || $itemServiceDev1Up->private_profit > 0) { ?>
                                        <a href="<?php echo base_url().'account/detail-commission/'.$itemServiceDev1Up->user_id.'/type/'.$itemServiceDev1Up->type.'/month/'.$monthYear[0].'/year/'.$monthYear[1].'?isPersonal=1'; ?>" target="_blank" > 
                                    <?php  if($itemServiceDev1Up->group_id != 6) { 
                                        echo number_format($itemServiceDev1Up->private_profit, 0, ",", ".") ; 
                                        }else{
                                        echo number_format($itemServiceDev1Up->total, 0, ",", ".") ; 
                                        } ?> đ
                                        <i class="fa fa-external-link" aria-hidden="true"></i>
                                        </a>
                                        <?php } else{ echo '0 đ';}?>
                                        </div>
                                    </td>
                                    
                                    <td align="center">Hoa hồng Bán giải pháp
                                    </td>
                                    <td align="center"><?php echo $itemServiceDev1Up->created_date_str; ?>
                                    </td>
                                    
                                </tr>
                            <?php 
                                $sum  += $itemServiceDev1Up->total + $itemServiceDev1Up->private_profit;  
                                endforeach;
                            ?>
                                <?php }else{ ?>
                                <tr>
                                    <td colspan="6" align="center">Không có dữ liệu</td>
                                </tr>
                            <?php }?>

                            	<?php if($profit->private_profit > 0){
									$sum = $sum + $profit->private_profit;
									 ?>
                                <tr>
                                    <td colspan="8" align="right">
                                        <div class="nojob">Lợi nhuận cá nhân mang về cho Azibai <span style="color:#FF0000; font-weight:bold"><?php echo number_format($profit->private_profit, 0, ",", ".") ;?></span> đ</div>
                                    </td>
                                </tr>
                                <?php } ?>
                            
                             	<?php if(count($revenueServiceFromDev1Up) > 0 || $profit->private_profit > 0){ ?>
                                <tr>
                                    <td colspan="8" align="right">
                                        <div class="nojob">Tổng doanh thu cho Azibai (đã trừ 10% VAT) <span style="color:#FF0000; font-weight:bold"><?php echo number_format($sum, 0, ",", ".") ;?></span> đ</div>
                                    </td>
                                </tr>
                               
                                 
                                <tr>
                                    <td colspan="8" align="right">
                                        <div class="nojob">Hoa hồng nhận được <span style="color:#FF0000; font-weight:bold"><?php echo number_format($sum * ($commission->percent/100), 0, ",", ".") ;?></span> đ (Phần trăm hoa hồng <span style="color:#FF0000; font-weight:bold"><?php echo $commission->percent; ?>%</span>)</div>
                                    </td>
                                </tr>
                                <?php } ?>
                           	 <?php if(count($revenueServiceFromDev1Up) <= 0 && $profit->private_profit <= 0){ ?>
                                <tr>
                                    <td colspan="7" align="right">
                                        <div class="nojob">Không có dữ liệu!</div>
                                    </td>
                                </tr>
                              <?php } ?>
                              
                                                                
						   <?php } ?>


                            </tbody>
                        </table>

                    </form>
                    

                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('home/common/footer'); ?>
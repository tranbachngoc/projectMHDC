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
                            <?php 
							//  ban giai phap
							if($commission->type == '03'){ ?>
                            
                            <?php if($commission->group_id == 6){ ?>
                            <tr>
                                <td width="5%" class="aligncenter hidden-xs">STT</td>

                                <td class="text-center">Từ Gian hàng
                                    
                                </td>
                                <?php if($commission->type != '03'){ ?>
                                <td class="text-center" width="12%">Danh mục
                                   
                                </td>
                                <?php } ?>
                                 
                                <td class="text-center">Doanh thu
                                    
                                </td>      
                                <?php if($commission->type == '03'){ ?>     
                                 <td class="text-center">Gói dịch vụ                                    
                                </td>   
                                 <?php } ?>                    
                                <?php if($commission->type != '03'){ ?>
                                <td class="text-center">Hoa hồng cho Azibai
                                    
                                </td>
                                <?php } ?>
                                <?php if($commission->type == '03'){ ?>     
                                  <td class="text-center hidden-xs">Doanh thu cho Azibai
                                   
                                </td>
                                 <?php }else{ ?>
                                  <td class="text-center hidden-xs">Lợi nhuận cho Azibai
                                   
                                </td>
                                <?php } ?>    
                               
                                <td class="text-center hidden-xs">Loại hoa hồng
                                   
                                </td>
                                <td class="text-center hidden-xs">Ngày
                                   
                                </td>
                                

                            </tr>
							<?php 

                            $sum = 0; 

                            foreach ($listUserPackage as $k => $item):?>

                                <!-- Modal -->
								
                                <tr id="af_row_<?php echo $item->id;?>">
                                    <td align="center"><?php echo $num + $k + 1;?></td>
                                    <td align="center">
                                        <a target="_blank" href="<?php echo base_url().$item->sho_link; ?>"> <?php echo $item->use_username; ?></a>
                                    </td>
                                    
                                    <td align="center"><div class="" style="color:#FF0000; font-weight:bold">
									<?php echo number_format($item->amount, 0, ",", ".") ; ?>
                                    </div>
									
                                    </td>
                                    <td align="center">
                                        <?php echo $item->name; ?>
                                    </td>                                   
                                    <td align="center"><div class="" style="color:#FF0000; font-weight:bold">
									<?php echo number_format($item->amount, 0, ",", "."); ?>
									</div>
                                    </td>
                                    <td align="center">Hoa hồng Bán giải pháp
                                    </td>
                                    <td align="center"><?php echo date("d-m-Y",strtotime($item->created_date)); ?>
                                    </td>
                                    
                                </tr>
                            <?php $sum = $sum + $item->total;  endforeach; ?>
                             	<?php if(count($revenueService) > 0){ ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Tổng doanh thu cho Azibai <span style="color:#FF0000; font-weight:bold"><?php echo number_format($revenueService[0]->total, 0, ",", ".") ;?></span> đ</div>
                                    </td>
                                </tr>
                                <?php } ?>
                                 <?php if(count($revenueService) > 0){ ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Hoa hồng nhận được <span style="color:#FF0000; font-weight:bold"><?php echo number_format($commission->commission, 0, ",", ".") ;?></span> đ (Phần trăm hoa hồng <span style="color:#FF0000; font-weight:bold"><?php echo $commission->percent; ?>%</span>)</div>
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
                           	<tr>
                                <td width="5%" class="aligncenter hidden-xs">STT</td>
                                <td class="text-center">Từ thành viên                                    
                                </td>
                                <td class="text-center hidden-xs">Lợi nhuận cho Azibai                                   
                                </td>
                                <td class="text-center hidden-xs">Loại hoa hồng                                   
                                </td>
                                <td class="text-center hidden-xs">Ngày                                   
                                </td>
                            </tr>
							<?php $sum = 0; foreach ($revenueServiceFromDev1Up as $k => $itemServiceDev1Up):?>

                                <!-- Modal -->
								
                                <tr id="af_row_<?php echo $itemServiceDev1Up->id;?>">
                                    <td align="center"><?php echo $num + $k + 1;?></td>
                                    <td align="center">
                                       <?php echo $itemServiceDev1Up->use_username; ?></a>
                                    </td>
                                    
                                    <td align="center"><div class="" style="color:#FF0000; font-weight:bold">
									<?php echo number_format($itemServiceDev1Up->total, 0, ",", ".") ; ?>
                                    </div>
									
                                    </td>
                                    
                                    <td align="center">Hoa hồng Bán giải pháp
                                    </td>
                                    <td align="center"><?php echo $itemServiceDev1Up->created_date_str; ?>
                                    </td>
                                    
                                </tr>
                            <?php $sum = $sum + $itemServiceDev1Up->total;  endforeach; ?>
                            	<?php if($profit->private_profit > 0){
									$sum = $sum + $profit->private_profit;
									 ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Lợi nhuận cá nhân mang về cho Azibai <span style="color:#FF0000; font-weight:bold"><?php echo number_format($profit->private_profit, 0, ",", ".") ;?></span> đ</div>
                                    </td>
                                </tr>
                                <?php } ?>
                            
                             	<?php if(count($revenueServiceFromDev1Up) > 0 || $profit->private_profit > 0){ ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Tổng doanh thu cho Azibai <span style="color:#FF0000; font-weight:bold"><?php echo number_format($sum, 0, ",", ".") ;?></span> đ</div>
                                    </td>
                                </tr>
                                <?php } ?>
                                 <?php if(count($revenueServiceFromDev1Up) > 0 || $profit->private_profit > 0){ ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Hoa hồng nhận được <span style="color:#FF0000; font-weight:bold"><?php echo number_format($sum * ($commission->percent/100), 0, ",", ".") ;?></span> đ (Phần trăm hoa hồng <span style="color:#FF0000; font-weight:bold"><?php echo $commission->percent; ?>%</span>)</div>
                                    </td>
                                </tr>
                                <?php } ?>
                           	 <?php if(count($revenueServiceFromDev1Up) <= 0 && $profit->private_profit <= 0){ ?>
                                <tr>
                                    <td colspan="7" align="center">
                                        <div class="nojob">Không có dữ liệu!</div>
                                    </td>
                                </tr>
                              <?php } ?>
                              
                                                                
						   <?php } ?>                               
							
							
							
							<?php }else{ 
							// hoa hong ban san pham
							// neu khong la hoa hong vi tri trong 
							if($commission->empty_position == 0){
							?> 
                            <?php
                                // neu la dev2
                                if($commission->group_id == Developer2User){ ?>
                            <tr>
                                <td width="5%" class="aligncenter hidden-xs">STT</td>

                                <td class="text-center">Từ Gian hàng 
                                                                   
                                </td>
                                <?php if($commission->type != '03'){ ?>
                                <td class="text-center" width="12%">Danh mục
                                   
                                </td>
                                <?php } ?>
                                 
                                <td class="text-center">Doanh thu
                                    
                                </td>      
                                <?php if($commission->type == '03'){ ?>     
                                 <td class="text-center">Gói dịch vụ                                    
                                </td>   
                                 <?php } ?>                    
                                <?php if($commission->type != '03'){ ?>
                                <td class="text-center">Hoa hồng cho Azibai
                                    
                                </td>
                                <?php } ?>
                                <?php if($commission->type == '03'){ ?>     
                                  <td class="text-center hidden-xs">Doanh thu cho Azibai
                                   
                                </td>
                                 <?php }else{ ?>
                                  <td class="text-center hidden-xs">Lợi nhuận cho Azibai
                                   
                                </td>
                                <?php } ?>    
                               
                                <td class="text-center hidden-xs">Loại hoa hồng
                                   
                                </td>
                                <td class="text-center hidden-xs">Ngày
                                   
                                </td>

                            </tr>
                            <?php $sum = 0; foreach ($revenue as $k => $item):?>

                                <!-- Modal -->

                                <tr id="af_row_<?php echo $item->rsc_id;?>">
                                    <td align="center"><?php echo $num + $k + 1;?></td>
                                    <td align="center">
                                        <?php echo $item->use_username;?>
                                    </td>
                                    <td align="center"><?php echo $item->cat_name;?>
                                    </td>
                                    <td align="center"><div class="" style="color:#FF0000; font-weight:bold">
									<?php echo number_format($item->rsc_revenue, 0, ",", ".") ;?>
                                    </div>
									
                                    </td>
                                    <td align="center"><?php echo $item->rsc_percent;?>%
                                    </td>
                                    <td align="center"><div class="" style="color:#FF0000; font-weight:bold">
									<?php echo number_format($item->rsc_profit, 0, ",", ".");?>
									</div>
                                    </td>
                                    <td align="center"><?php echo $item->rsc_description;?>
                                    </td>
                                    <td align="center"><?php echo $item->rsc_created_date_str; ?>
                                    </td>
                                </tr>
                            <?php $sum = $sum + $item->rsc_profit;  endforeach; ?>
                            	
                             	<?php if(count($revenue) > 0){ ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Tổng lợi nhuận cho Azibai <span style="color:#FF0000; font-weight:bold"><?php echo number_format($sum, 0, ",", ".") ;?></span> đ</div>
                                    </td>
                                </tr>
                                <?php } ?>
                                 <?php if(count($revenue) > 0){ ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Hoa hồng nhận được <span style="color:#FF0000; font-weight:bold"><?php echo number_format($sum * ($commission->percent/100), 0, ",", ".") ;?></span> đ (Phần trăm hoa hồng <span style="color:#FF0000; font-weight:bold"><?php echo $commission->percent; ?>%</span>)</div>
                                    </td>
                                </tr>
                                <?php } ?>
                            <?php if(count($revenue) <= 0){ ?>
                                <tr>
                                    <td colspan="7" align="center">
                                        <div class="nojob">Không có dữ liệu!</div>
                                    </td>
                                </tr>
                            	<?php } ?>

                            <?php }else{ ?>    
                            <tr>
                                <td width="5%" class="aligncenter hidden-xs">STT</td>
                                <?php if($profit->type != '08'){ ?>
                                <td class="text-center">Từ thành viên
                                    
                                </td>
                                <?php } ?>
                                 
                                <td class="text-center">Lợi nhuận cho Azibai
                                    
                                </td>    
                                                             
                                <td class="text-center hidden-xs">Loại hoa hồng                                   
                                </td>
                                <td class="text-center hidden-xs">Ngày                                   
                                </td>
                              </tr>
                            <?php $sum = 0; foreach ($revenueFromDev1Up as $k => $itemDev1Up):?>

                                <!-- Modal -->

                                <tr id="af_row_<?php echo $itemDev1Up->id;?>">
                                    <td align="center"><?php echo $num + $k + 1;?></td>
                                        <?php if($profit->type != '08'){ ?>
                                    <td align="center">
                                        <?php echo $itemDev1Up->use_username;?>
                                    </td>
                                        <?php } ?>
                                    
                                    <td align="center"><div class="" style="color:#FF0000; font-weight:bold">
									<?php echo number_format($itemDev1Up->total, 0, ",", ".") ;?>
                                    </div>
									
                                    </td>                                    
                                    
                                    <td align="center"><?php 
									if($itemDev1Up->type == '01'){
										echo 'Hoa hồng mua sỉ';
									}
									if($itemDev1Up->type == '02'){
										echo 'Hoa hồng bán sỉ';
									}
									if($itemDev1Up->type == '04'){
										echo 'Hoa hồng mua lẻ';
									}
									if($itemDev1Up->type == '05'){
										echo 'Hoa hồng bán lẻ';
									}
                                    if($itemDev1Up->type == '08'){
                                        echo 'Hoa hồng mua lẻ Gian hàng từ Affiliate';
                                    }
                                ?>
                                    </td>
                                    <td align="center"><?php echo $itemDev1Up->created_date_str; ?>
                                    </td>
                                    
                                    
                                </tr>
                            <?php  $sum = $sum + $itemDev1Up->total;  endforeach;
                                    ?>
                            	<?php if($profit->private_profit > 0 && $profit->type != '08'){
                                         $sum = $sum + $profit->private_profit;
									 ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Lợi nhuận cá nhân mang về cho Azibai <span style="color:#FF0000; font-weight:bold"><?php echo number_format($profit->private_profit, 0, ",", ".") ;?></span> đ</div>
                                    </td>
                                </tr>
                                <?php } ?>
                             	<?php if(count($revenueFromDev1Up) > 0){ ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Tổng lợi nhuận cho Azibai <span style="color:#FF0000; font-weight:bold"><?php echo number_format($sum, 0, ",", ".") ;?></span> đ</div>
                                    </td>
                                </tr>
                                <?php } ?>
                                 <?php if(count($revenueFromDev1Up) > 0){ ?>
                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Hoa hồng nhận được <span style="color:#FF0000; font-weight:bold"><?php echo number_format($sum * ($commission->percent/100), 0, ",", ".") ;?></span> đ (Phần trăm hoa hồng <span style="color:#FF0000; font-weight:bold"><?php echo $commission->percent; ?>%</span>)</div>
                                    </td>
                                </tr>
                                <?php } ?>
                            <?php if(count($revenueFromDev1Up) <= 0){ ?>
                                <tr>
                                    <td colspan="7" align="center">
                                        <div class="nojob">Không có dữ liệu!</div>
                                    </td>
                                </tr>
                            	<?php } ?>
                                
                             <?php } ?> 
                             
                             <?php }else{?>  
                             
                            
                              <tr>
                                <td class="text-center">Từ thành viên
                                    
                                </td>                               
                                 
                                <td class="text-center">Vị trí trống Dev1
                                    
                                </td>    
                                 <td class="text-center">Vị trí trống Partner 2
                                    
                                </td>  
                                 <td class="text-center">Vị trí trống Partner 1
                                    
                                </td>  
                                 <td class="text-center">Vị trí trống Core Member
                                    
                                </td>  
                                                                                             
                                <td class="text-center hidden-xs">Tổng lợi nhuận từ thành viên                                   
                                </td>
                                <td class="text-center hidden-xs">Ngày                                   
                                </td>
                              </tr>
                             <tr>
                                
                                <td class="text-center"> <?php echo $commissioEmpty->user_id; ?>
                                    
                                </td>                               
                                 
                                <td class="text-center"><?php echo $commissioEmpty->dev1_percent; ?>%
                                    
                                </td>    
                                 <td class="text-center"><?php echo $commissioEmpty->partner2_percent; ?>%
                                    
                                </td>  
                                 <td class="text-center"><?php echo $commissioEmpty->partner1_percent; ?>%
                                    
                                </td>  
                                 <td class="text-center"><?php echo $commissioEmpty->coremember_percent; ?>%
                                    
                                </td>  
                                                                                             
                                <td class="text-center hidden-xs"><span style="color:#FF0000; font-weight:bold"><?php echo number_format($commissioEmpty->user_child_profit, 0, ",", ".") ; ?> </span>                                  
                                </td>
                                <td class="text-center hidden-xs"><?php echo $commissioEmpty->created_date_str; ?>                              
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
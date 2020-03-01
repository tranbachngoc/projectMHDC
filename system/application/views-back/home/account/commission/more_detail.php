<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2/1/2016
 * Time: 5:28 AM
 */
$group_id = (int)$this->session->userdata('sessionGroup');
// echo "<pre>";
// print_r($revenueList); 
// echo "</pre>";
// echo "a";
// die;
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
                    echo 'Chi tiết Hoa hồng của '.strtoupper($user->use_username);
                }
                 ?>
              </h2>
                <div style="width:100%; overflow-y: auto;">
                    <form name="frmAccountPro" action="<?php echo $link; ?>" method="post" >
                        <table class="table table-bordered afBox">                           
                            <tbody>
                            <?php if($isPersonal){
                                switch ($type) {
                                    case '03':
                            ?>  
                                <!-- cá nhân -->

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
                                <?php if(count($revenueList) > 0){ ?>

                                <tr>
                                    <td colspan="8" align="center">
                                        <div class="nojob">Tổng doanh thu cho Azibai từ <?php echo strtoupper($user->use_username); ?> : <span style="color:#FF0000; font-weight:bold"><?php echo number_format($revenueList[0]->private_profit, 0, ",", ".") ;?> đ</span> </div>
                                    </td>
                                </tr>
                                
                                
                                <?php } ?>
                             <?php if(count($revenueList) <= 0){ ?>
                                <tr>
                                    <td colspan="7" align="center">
                                        <div class="nojob">Không có dữ liệu!</div>
                                    </td>
                                </tr>
                            <?php }                                
                                        break;
                                    default:

                             if(count($retail_pro) > 0){ ?>
                                <thead>

                                <tr>
                                    <th width="1%" class="aligncenter hidden-xs hidden-sm">STT</th>
                                    <th width="10%" class="hidden-xs hidden-sm text-center">
                                        Mã
                                    </th>
                                    <th width="20%" class="aligncenter" >
                                        Tên sản phẩm
                                    </th>
                                    <th width="5%" class="aligncenter hidden-xs hidden-sm">
                                        SL
                                    </th>
                                    <th width="15%" class="aligncenter">
                                        Đơn giá
                                    </th>
                                    <th width="15%" class="hidden-xs hidden-sm text-center">
                                        Danh mục
                                    </th>
                                    <th width="15%" class="hidden-xs hidden-sm">
                                        Tổng tiền
                                    </th>
                                </tr>
                                </thead>
                                <?php $idDiv = 1; $total = 0; ?>
                                <?php foreach( $retail_pro as $k=>$productArray){ ?>
                                    <tr>
                                        <td height="45" class="aligncenter hidden-xs hidden-sm"><?php echo $idDiv; ?></td>
                                        <td>
                                            <a href="<?php echo base_url().'account/order_detail/'.$productArray->shc_orderid; ?>" style="font-size: 13px; font-weight: 600" class="text-info"><i># <?php echo $productArray->shc_orderid; ?></i></a>
                                        </td>
                                        <td><a class="menu_1" href="<?php echo base_url(); ?><?php echo $productArray->pro_category; ?>/<?php echo $productArray->shc_product; ?>/<?php echo RemoveSign($productArray->pro_name); ?>" >
                                                <?php echo sub($productArray->pro_name, 100); ?>
                                            </a></td>
                                        <td width="5%" class="" style="text-align:right;">
                                            <?php echo $productArray->shc_quantity; ?>
                                        </td>
                                        <td class="aligncenter hidden-xs hidden-sm">
                                            <span class="product_price"><?php echo number_format($productArray->pro_price,0,",","."); ?> đ</span>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php echo $productArray->cat_name; ?>
                                        </td>
                                        <td style="text-align:center;">
                                            <?php
                                            echo  ' <span class="product_price">'.number_format($productArray->shc_total,0,",",".").' đ </span>';
                                            ?>
                                        </td>
                                    </tr>
                                    <?php $idDiv++; ?>
                                <?php } ?>
                            <?php }else{ ?>
                                <tr>
                                    <td  colspan="10" class="text-center" ><?php echo $this->lang->line('none_record_product_defaults'); ?></td>
                                </tr>
                            <?php } ?>
                            </table>
                        <h3>Doanh số cá nhân</h3>
                        <table class="table table-bordered afBox">
                            <tbody>
                            <tr>
                                <td width="5%" class="aligncenter hidden-xs">STT</td>
                                <td class="text-center">Từ gian hàng</td>
                                <td class="text-center">Giá</td>
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
                                        <?php echo $item->sho_link; ?>
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
                                    <div class="nojob">Tổng lợi nhuận của Azibai từ <?php echo strtoupper($user->use_username);?>: <span style="color:#FF0000; font-weight:bold"><?php echo number_format($total, 0, ",", ".") ;?> đ</span> </div>
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

<?php
                                }

                            ?>
                            
                              
                           <?php }else{
						   // nhóm

						   ?>   
                           	<tr>
                                <td width="5%" class="aligncenter hidden-xs" rowspan=2>STT</td>
                                <td class="text-center" rowspan=2>Từ thành viên                                    
                                </td>
                                <td class="text-center hidden-xs" colspan=2>Lợi nhuận cho Azibai                                   
                                </td>
                                <td class="text-center hidden-xs" rowspan=2>Loại hoa hồng                                   
                                </td>
                                <td class="text-center hidden-xs" rowspan=2>Ngày                                   
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center" >Nhóm</td>
                                <td class="text-center" >Cá nhân</td>
                            </tr>
							<?php $sum = 0; 
                            foreach ($revenueList as $k => $itemServiceDev1Up):?>

                                <!-- Modal -->
                                <tr id="af_row_<?php echo $itemServiceDev1Up->id;?>">
                                    <td align="center"><?php echo $num + $k + 1;?></td>
                                    <td align="center">
                                       <?php echo $itemServiceDev1Up->use_username; ?></a>
                                    </td>
                                    
                                    <td align="center"><div class="" style="color:#FF0000; font-weight:bold">
                                    <?php 
                                    // print_r($itemServiceDev1Up);die;
                                        $personalStr = '';
                                        if($itemServiceDev1Up->group_id == 6) { $personalStr = '?isPersonal=1';}
                                        if($itemServiceDev1Up->total  > 0) {
                                    ?>
                                    <a href="<?php echo base_url().'account/detail-commission/'.$itemServiceDev1Up->user_id.'/type/'.$type.'/month/'.$month.'/year/'.$year.$personalStr; ?>" target="_blank" >
									<?php echo number_format($itemServiceDev1Up->total + $itemServiceDev1Up->private_profit, 0, ",", ".") ;  ?>
                                    <i class="fa fa-external-link" aria-hidden="true"></i>
                                    </a>
                                    <?php } else{
                                        echo number_format($itemServiceDev1Up->total + $itemServiceDev1Up->private_profit, 0, ",", ".") ; 
                                    }?>
                                    </div>
									
                                    </td>
                                    <td><div class="" style="color:#FF0000; font-weight:bold">
                                     <?php if(($itemServiceDev1Up->total > 0 && $itemServiceDev1Up->group_id == 6) || $itemServiceDev1Up->private_profit > 0) { ?>
                                    <a href="<?php echo base_url().'account/detail-commission/'.$itemServiceDev1Up->user_id.'/type/'.$type.'/month/'.$month.'/year/'.$year.'?isPersonal=1'; ?>" target="_blank" > 
                                    <?php  if($itemServiceDev1Up->group_id != 6) { 
                                        echo number_format($itemServiceDev1Up->private_profit, 0, ",", ".") ; 
                                        }else{
                                        echo number_format($itemServiceDev1Up->total, 0, ",", ".") ; 
                                        } ?>
                                        <i class="fa fa-external-link" aria-hidden="true"></i>
                                        </a>
                                          <?php } else{ echo '0 đ';}?>
                                        </div>
                                    </td>
                                    
                                    <td align="center">
                                    <?php 
                                        switch ($type) {
                                            case '01':
                                                echo "Hoa hồng mua sỉ";
                                                break;
                                            case '02':
                                                echo "Hoa hồng bán sỉ";
                                                break;
                                            case '03':
                                                echo "Hoa hồng bán giải pháp";
                                                break;
                                                
                                            case '04':
                                                echo "Hoa hồng mua lẻ";
                                                break;

                                            case '05':
                                                echo "Hoa hồng bán lẻ";
                                                break;    
                                            case '06':
                                                echo "Hoa hồng Affiliate";
                                                break;   
                                            case '08':
                                                echo "Hoa hồng mua lẻ Gian hàng từ Affiliate";
                                                break;   
                                        }
                                    ?>
                                    </td>
                                    <td align="center"><?php echo $itemServiceDev1Up->created_date_str; ?>
                                    </td>
                                    
                                </tr>
                            <?php 
                                $sum  += $itemServiceDev1Up->total + $itemServiceDev1Up->private_profit;  
                                endforeach;
                            ?>
                            	<?php if($profit->private_profit > 0){
									$sum = $sum + $profit->private_profit;
									 ?>
                                <tr>
                                    <td colspan="8" align="right">
                                        <div class="nojob">Lợi nhuận cá nhân mang về cho Azibai <span style="color:#FF0000; font-weight:bold"><?php echo number_format($profit->private_profit, 0, ",", ".") ;?></span> đ</div>
                                    </td>
                                </tr>
                                <?php } ?>
                            
                             	<?php if(count($revenueList) > 0 || $profit->private_profit > 0){ ?>
                                <tr>
                                    <td colspan="8" align="right">
                                        <div class="nojob">Tổng doanh thu cho Azibai từ <?php echo strtoupper($user->use_username); ?> : <span style="color:#FF0000; font-weight:bold"><?php echo number_format($sum, 0, ",", ".") ;?></span> đ</div>
                                    </td>
                                </tr>
                               
                                 
                                
                                <?php } ?>
                           	 <?php if(count($revenueList) <= 0 && $profit->private_profit <= 0){ ?>
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
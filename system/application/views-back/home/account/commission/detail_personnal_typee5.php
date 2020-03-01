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
                        <table class="table table-bordered" width="100%" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 0; " >
                            <?php if(count($retail_pro) > 0){ ?>
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
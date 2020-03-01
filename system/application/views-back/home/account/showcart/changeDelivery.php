<?php $this->load->view('home/common/account/header'); ?>
<div class="container">
    <div class="row">
<?php $this->load->view('home/common/left'); ?>

<!--BEGIN: RIGHT-->
<div class="col-lg-9 col-md-9 col-sm-8">

    <div id="panel_order_af" class="panel panel-default">
        <div class="panel-heading"><h4><?php echo $this->lang->line('requirements_change_delivery'); ?></h4></div>
        <div class="panel-body">
            <?php if(count($showcart) > 0){ ?>
            
            <table class="table table-hover" width="100%" border="0" cellpadding="0" cellspacing="0">
                <form name="frmAccountShowcart" method="post">
                    <thead>
                    <tr>
                        <td width="15%" class="hidden-xs">Mã đơn hàng</td>
                        <td width="20%">
                            Ngày đặt hàng
                        </td>
                        <td width="20%" >
                            Thanh toán
                        </td>
                        <td  width="15%" >
                            Nhà vận chuyển
                        </td>
                        <td width="15%" class="hidden-xs">
                            Trạng thái
                        </td>
                        <td width="15%"  class="hidden-xs">
                            Tổng tiền
                        </td>
                        <td class="hidden-lg hidden-md">Chi tiết</td>
                    </tr>
                    </thead>
                    <?php $temp = 0;?>
                    <?php foreach($showcart as $k=> $showcartArray){ ?>
                       <?php if($temp == $showcartArray->id){
                                $clas = 'class="row_none"';
                        }else{
                            $clas = '';
                        }?>
                        <tr <?php echo $clas;?> >
                            <td height="32" class="hidden-xs">
                                <a class="menu_1 text-primary" href="<?php echo base_url(); ?>account/order_detail/<?php echo $showcartArray->id; ?>" >
                                    #<?php echo $showcartArray->id; ?>
                                </a>
                            </td>
                            <td height="32" class="line_account_2">
                                <?php echo date('d/m/Y H:i:s',($showcartArray->date)); ?>
                            </td>
                            <td height="32" class="line_account_2">
                                <?php switch ($showcartArray->payment_status){
                                    case '0':
                                        echo 'Chưa thanhn toán';
                                        break;
                                    case '1':
                                        echo 'Đã thanh toán';
                                        break;
                                } ?>
                            </td>
                            <td height="32" class="">
                                <?php switch ($showcartArray->shipping_method){
                                    case 'GHN':
                                        echo 'Giao hàng nhanh';
                                        break;
                                    case 'VTP':
                                        echo 'Viettel Post';
                                        break;
                                    case 'VNPT':
                                        echo 'VNPT';
                                        break;
                                } ?>
                            </td>
                            <td height="32" class="hidden-xs">
                                <?php
                                echo '<p>';
                                switch ($showcartArray->order_status){
                                    case '01':
                                        echo '<span class="text-primary">'.status_1.'</span>';
                                        break;
                                    case '02':
                                        echo '<span class="text-primary">'.status_2.'</span>';
                                        break;
                                    case '03':
                                        echo '<span class="text-primary">'.status_3.'</span>';
                                        break;
                                    case '04':
                                        echo '<span class="text-primary">'.status_4.'</span>';
                                        break;
                                    case '05':
                                        echo '<span class="text-primary">'.status_5.'</span>';
                                        break;
                                    case '06':
                                        echo '<span class="text-primary">'.status_6.'</span>';
                                        break;
                                    case '99':
                                        echo '<span class=text-danger">'.status_99.'</span>';
                                        break;
                                    case '98':
                                        echo '<span class="text-primary">'.status_98.'</span>';
                                        break;
                                }
                                echo '</p>';
                                ?>
                            </td>
                            <td  height="32" class="hidden-xs">
                                <span class="text-danger"><b><?php echo number_format($showcartArray->shc_total,0,',','.');?> đ</b></span>
                            </td>
                        </tr>
                        
                        
                        <tr>
                            <td>
                                <?php
                                $filename = 'media/images/product/'.$showcartArray->pro_dir.'/'.show_thumbnail($showcartArray->pro_dir, $showcartArray->pro_image);
                                if(file_exists($filename) && $filename != ''){
                                    ?>
                                    <img width="80" src="<?php echo base_url().$filename; ?>" />
                                <?php }else{?>
                                    <img width="80" src="<?php echo base_url(); ?>media/images/no_photo_icon.png" />
                                <?php }?>
                            </td>
                            <td colspan="2">
                                <p><?php echo $showcartArray->pro_name;?></p>
                                <p>Hình thức thanh toán:
                                <?php switch ($showcartArray->payment_method){
                                    case 'info_nganluong':
                                        $payment_method = 'Qua Ngân Lượng';
                                        break;
                                    case 'info_cod':
                                        $payment_method = 'Thanh toán trực tiếp';
                                        break;
                                    case 'info_bank':
                                        $payment_method = 'Chuyển khoản';
                                        break;
                                } ?>
                                    <ul>
                                        <li><?php echo $payment_method;?></li>
                                        <?php
                                        if($showcartArray->payment_method != "info_cod"){
                                            echo "<li>Bạn dùng mã đơn hàng ".$showcartArray->id." để sử dụng.</li>";
                                            echo "<li>Thông tin thanh toán: ".$showcartArray->payment_other_info."</li>";
                                        }
                                        ?>
                                    </ul>
                                </p>
                            </td>
                            <td colspan="2">Mã SP: <span class="text-primary"><?php echo $showcartArray->pro_sku;?></span></td>
                            <td>Số lượng: <span class="text-primary"><?php echo count($showcartArray->pro_quality);?></td>
                        </tr>
                        <?php $temp = $showcartArray->id; ?>
                    <?php } ?>
                        
                        
                        
                    <?php } else{ ?>
                        <tr>
                            <td class="none_record" align="center"  >Không có đơn hàng nào</td>
                        </tr>
                    <?php } ?>
                </form>
            </table>
        </div>
    </div>
</div>
</div>
</div>
<!--END RIGHT-->
<?php $this->load->view('home/common/footer'); ?>
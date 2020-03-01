<?php $this->load->view('group/common/header'); ?>
<br>
<div id="main" class="container-fluid">
        <div class="row">
            <div class="col-md-3 sidebar">
                <?php $this->load->view('group/common/menu'); ?>
            </div>
            <div class="col-md-9 main">
		<h4 class="page-header text-uppercase" style="margin-top:10px">Danh sách đơn hàng</h4>
                <div class="dashboard">
                    <!-- ========================== Begin Content ============================ -->                   
                    
                    <form class="form-horizontal" name="frmFilterOrder" id="frmFilterOrder" method="post"
                          enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-xs-12 col-sm-3 col-md-3 col-ld-3">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-barcode"></i></div>
                                    <input type="text" class="form-control" name="order_code" id="order_code"
                                           value="<?php ?>"
                                           placeholder="Mã đơn hàng">
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-ld-3">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-tags"></i></div>
                                    <select class="form-control input-sm" type="text" name="order_status">
                                        <option value="">Trạng thái</option>
                                        <?php foreach ($status_order as $item) { ?>
                                            <option
                                                value="<?php echo $item['status_id']; ?>"><?php echo $item['text']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-ld-3">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-truck"></i></div>
                                    <select class="form-control" name="ship_order" id="ship_order">
                                        <option value="">Nhà vận chuyển</option>
                                        <option value="GHN">Giao hàng nhanh</option>
                                        <option value="VTP">Viettel Post</option>
                                        <option value="GHTK">Giao hàng tiết kiệm</option>
                                        <option value="SHO">Shop giao</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-3 col-md-3 col-ld-3">
                                <button class="btn btn-primary btn-block">Lọc đơn hàng</button>
                            </div>
                        </div>
                    </form>
                    <br/>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr style="background: #eee;">
                                <th width=""> Mã đơn hàng</th>
                                <th width=""> Ngày đặt hàng</th>
                                <th width=""> Thanh toán</th>
                                <th width=""> Nhà vận chuyển</th>
                                <th width=""> Trạng thái</th>
                                <th width="" class="text-right"> Tổng tiền</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php //for($i=0; $i<5; $i++) { ?>
                            <?php if (count($showcart) > 0) { ?>
                                <?php foreach ($showcart as $k => $showcartArray) {
                                    if ($showcartArray->pro_type == 2) {
                                        $pro_type = 'coupon';
                                    } elseif ($showcartArray->pro_type == 0) {
                                        $pro_type = 'product';
                                    }?>
                                    <tr style="background: #fff">
                                        <td class="text-center">
                                            <a class="menu_1 text-primary"
                                               href="<?php echo base_url(); ?>account/order_detail/<?php echo $showcartArray->id; ?>">
                                                #<?php echo $showcartArray->id; ?>
                                            </a>
                                        </td>
                                        <td><?php echo date('d/m/Y H:i:s', ($showcartArray->date)); ?></td>
                                        <td>
                                            <?php
                                            switch ($showcartArray->payment_status) {
                                                case '0':
                                                    echo 'Chưa thanh toán';
                                                    break;
                                                case '1':
                                                    echo 'Đã thanh toán';
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td>

                                            <?php if ($showcartArray->order_coupon_code == '') { ?><?php
                                                switch ($showcartArray->shipping_method) {
                                                    case 'GHN':
                                                        echo 'Giao hàng nhanh';
                                                        break;
                                                    case 'VTP':
                                                        echo 'Viettel Post';
                                                        break;
                                                    case 'GHTK':
                                                        echo 'Giao hàng tiết kiệm';
                                                        break;
                                                    default:
                                                        echo 'Shop giao';
                                                        break;
                                                }
                                                ?>
                                                <?php
                                            } ?>
                                        </td>
                                        <td class="text-primary">
                                            <?php
                                            switch ($showcartArray->order_status) {
                                                case '01':
                                                    echo '<span class="text-primary">' . status_1 . '</span>';
                                                    break;
                                                case '02':
                                                    echo '<span class="text-primary">' . status_2 . '</span>';
                                                    break;
                                                case '03':
                                                    echo '<span class="text-primary">' . status_3 . '</span>';
                                                    break;
                                                case '04':
                                                    echo '<span class="text-primary">' . status_4 . '</span>';
                                                    break;
                                                case '05':
                                                    echo '<span class="text-primary">' . status_5 . '</span>';
                                                    break;
                                                case '06':
                                                    echo '<span class="text-primary">' . status_6 . '</span>';
                                                    break;
                                                case '99':
                                                    echo '<span class=text-danger">' . status_99 . '</span>';
                                                    break;
                                                case '98':
                                                    echo '<span class="text-primary">' . status_98 . '</span>';
                                                    break;
                                            }
                                            ?>
                                        </td>
                                        <td class="text-danger">
                                            <strong><?php echo number_format($showcartArray->shc_total, 0, ',', '.'); ?>
                                                đ</strong></td>
                                    </tr>
                                    <tr style="background: #fff">
                                        <td class="text-center">
                                            <a class="menu_1" target="_blank"
                                               href="<?php echo $info[$k]['link_sp'].'/shop/' . $pro_type . '/detail/' . $showcartArray->pro_id . '/' . RemoveSign($showcartArray->pro_name); ?>">
                                                <?php
                                                if ($showcartArray->shc_dp_pro_id > 0) {
                                                    $filename = 'media/images/product/' . $showcartArray->pro_dir . '/thumbnail_1_' . $showcartArray->dp_images;
                                                } else {
                                                    $filename = 'media/images/product/' . $showcartArray->pro_dir . '/thumbnail_1_' . explode(',',$showcartArray->pro_image)[0];
                                                }

                                                if ($showcartArray->dp_images != '' || $showcartArray->pro_image != '') { //file_exists($filename) && $filename != ''
                                                    ?>
                                                    <img width="80" src="<?php echo DOMAIN_CLOUDSERVER . $filename; ?>"/>
                                                <?php } else { ?>
                                                    <img width="80"
                                                         src="<?php echo base_url(); ?>media/images/no_photo_icon.png"/>
                                                <?php } ?>
                                            </a>
                                        </td>
                                        <td colspan="2">
                                            <strong>
                                                <a class="menu_1" target="_blank"
                                                   href="<?php echo $info[$k]['link_sp'].'/shop/' . $pro_type . '/detail/' . $showcartArray->pro_id . '/' . RemoveSign($showcartArray->pro_name); ?>">
                                                    <?php echo $showcartArray->pro_name; ?>
                                                </a>
                                            </strong>
                                        </td>
                                        <td colspan="2">Mã SP: <span class="text-primary"><?php echo $showcartArray->pro_sku; ?></span></td>
                                        <td>Số lượng: <?php echo $showcartArray->shc_quantity; ?></td>
                                    </tr>
                                    <?php if ($showcart[$k]->id != $showcart[$k + 1]->id) { ?>
                                        <tr style="background: #fff;">
                                            <td colspan="5" style=" vertical-align: middle">
                                                <strong class="text-danger">Bạn cần xử lý đơn hàng này trong vòng
                                                    24h</strong>
                                            </td>
                                            <td>
                                                <a class="btn btn-danger btn-block" href="<?php echo base_url().'grouptrade/'.$this->uri->segment(2).'/orderdetail/'. $showcartArray->id?>">
                                                    <i class="fa fa-sign-in fa-fw"></i> Chi tiết
                                                </a>
                                            </td>
                                        </tr>
                                        <tr style="background: #e9ebee">
                                            <td colspan="6"></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } else { ?>
                                <tr style="background: #fff">
                                    <td colspan="6" align="center">Không có đơn hàng</td>
                                </tr>
                            <?php } ?>
                            <?php if (isset($linkPage) && $linkPage != '') { ?>
                            <tfoot>
                            <tr>
                                <td colspan="6" class="show_page"><?php echo $linkPage; ?></td>
                            </tr>
                            </tfoot>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- ========================== End Content ============================ -->
                </div>
            </div>
        </div>
    </div> 
<?php $this->load->view('group/common/footer'); ?>
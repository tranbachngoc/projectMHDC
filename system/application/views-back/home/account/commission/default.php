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
    <div class="container-fluid">
        <div class="row">
            <?php $this->load->view('home/common/left'); ?>
            <!--BEGIN: RIGHT-->
            <div class="col-lg-9 col-md-9 col-sm-8 col-xs-12">
		<h4 class="page-header text-uppercase" style="margin-top:10px">
                <?php if ($group_id == AffiliateStoreUser){
                    echo 'Thu nhập Gian hàng từ Affiliate';
                } else{
                    echo 'Thống kê Hoa hồng';
                }
                 ?>
              </h4>
                <div class="table-responsive">
                    <form name="frmAccountPro" action="<?php echo $link; ?>" method="post">
                        <div class="panel panel-default">
                                <div class="panel-body form-inline">
                                    <?php if ($group_id == AffiliateStoreUser){
                                        ?>
                                        <select name="type" class="form-control" autocomplete="off">
                                            <option <?php echo $filter['type'] == $types[7]['id'] ? 'selected="selected"': '';?> value="<?php echo $types[7]['id'];?>"><?php echo  $types[7]['text'];?></option>
                                        </select>
                                    <?php  } else {?>
                                        <select name="type" class="form-control" autocomplete="off">
                                            <option value="">Tất cả</option>
                                            <?php foreach($types as $k=>$val):
                                                if($k <5){
                                                    ?>
                                                    <option <?php echo $filter['type'] == $val['id'] ? 'selected="selected"': '';?> value="<?php echo $val['id'];?>"><?php echo $val['text'];?></option>
                                                <?php } endforeach;?>
                                        </select>
                                    <?php  }?>
                                    Tháng
                                    <select class="form-control" name="month" autocomplete="off">
                                        <?php for($i = 1; $i <= 12; $i++):
                                            if($i < 10){ $i = '0'.$i;}
                                            ?>
                                            <option <?php echo $filter['month'] == $i ? 'selected="selected"': '';?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php endfor;?>
                                    </select>

                                    Năm
                                    <select class="form-control" name="year" autocomplete="off">
                                        <?php for($i = 2015; $i <= 2025; $i++):
                                            if($i < 10){ $i = '0'.$i;}
                                            ?>
                                            <option <?php echo $filter['year'] == $i ? 'selected="selected"': '';?> value="<?php echo $i;?>"><?php echo $i;?></option>
                                        <?php endfor;?>
                                    </select>

				    &nbsp;
                                    <button type="submit" class="btn btn-azibai padding-button"><i class="fa fa-search fa-fw"></i> Tìm kiếm</button>
                                    <!--<button type="submit" class="sButton"></button>-->
                                    <input type="hidden" name="dir" value="<?php echo $filter['dir']; ?>"/>
                                    <input type="hidden" name="sort" value="<?php echo $filter['sort']; ?>"/>
                                                                       
                                </div>
                        </div>
                        
                        <table class="table table-bordered afBox">
                            <caption>Tổng cộng: <span style="color: red;"><?php echo number_format($total, 0, ",", ".") . ' đ';?></span></caption>
                            <thead>
                            <tr>
                                <th width="5%" class="aligncenter hidden-xs">STT</th>

                                <th class="text-center">Loại hoa hồng <br />
                                    <a href="<?php echo $sort['type']['asc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                    <a href="<?php echo $sort['type']['desc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                </th>
                                <th class="text-center" width="12%">Tháng<br />
                                    <a href="<?php echo $sort['created_date']['asc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                    <a href="<?php echo $sort['created_date']['desc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                </th>
                                <th class="text-center">Số tiền<br />
                                    <a href="<?php echo $sort['commission']['asc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                    <a href="<?php echo $sort['commission']['desc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                </th>
                                <th class="text-center">Ngày tạo<br />
                                    <a href="<?php echo $sort['created_date']['asc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_asc.gif" border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                    <a href="<?php echo $sort['created_date']['desc']; ?>">
                                        <img src="<?php echo base_url(); ?>templates/home/images/sort_desc.gif" border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                </th>
                                <!--<th class="text-center hidden-xs">Thanh toán<br />
                                    <a href="<?php /*echo $sort['cat']['asc']; */?>">
                                        <img src="<?php /*echo base_url(); */?>templates/home/images/sort_asc.gif" border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                    <a href="<?php /*echo $sort['cat']['desc']; */?>">
                                        <img src="<?php /*echo base_url(); */?>templates/home/images/sort_desc.gif" border="0"
                                             style="cursor:pointer;" alt=""/>
                                    </a>
                                </th>-->
                                <th class="text-center hidden-xs">Chi tiết<br />

                                </th>

                            </tr>
                            </thead>
                            <?php if(count($list) > 0) {?>


                            <tbody>
                            <?php foreach ($list as $k => $item): ?>

                                <!-- Modal -->

                                <tr id="af_row_<?php echo $product['pro_id'];?>">
                                    <td class="hidden-xs"><?php echo $num + $k + 1;?></td>
                                    <td class="aligncenter hidden-xs" >
                                        <?php echo $item['description'];?>
                                    </td>
                                    <td><?php echo $item['commission_month'];?>
                                    </td>
                                    <td align="right"><span
                                            class="product_price"><?php echo number_format($item['commission'], 0, ",", ".") . ' đ';?></span>
                                    </td>
                                    <td><?php echo $item['created_date_str'];?>
                                    </td>
                                    <?php
                                        $type = '';
                                    if ($item['description'] == 'Hoa hồng bán Giải pháp cá nhân'){
                                        $type = '?personal=1';
                                    }else{
                                        $type = '';
                                    }
                                    // account/detail/commission-position-empty
                                    ?>
                                    <td class="aligncenter">
                                    <?php
                                    if ($item['empty_position'] > 0){ ?>
                                    <a href="<?php echo base_url(); ?>account/detail/commission-position-empty/<?php echo $item['id'].$type;?>">
                                        <button type="button" class="btn btn-default1" data-toggle="modal" >
                                            <i class="fa fa-newspaper-o"></i>
                                        </button>
                                    </a>
                                    <?php }else{ ?>
                                        <?php if ($item['type'] == '05' && $this->session->userdata('sessionGroup') != 6){ ?>
                                            <?php
                                            $type = '';
                                            if ($item['description'] == 'Hoa hồng Bán lẻ cá nhân'){
                                                $type = '?personal=1';
                                            }else{
                                                $type = '';
                                            }?>
                                            <a href="<?php echo base_url(); ?>account/detail/commission/retail/<?php echo $item['id'].$type;?>">
                                                <button type="button" class="btn btn-default1" data-toggle="modal" >
                                                    <i class="fa fa-newspaper-o"></i>
                                                </button>
                                            </a>
                                        <?php }elseif($item['type'] == '04'){
                                            $type = '';
                                            if ($item['description'] == 'Hoa hồng Mua lẻ cá nhân'){
                                                $type = '?personal=1';
                                            }else{
                                                $type = '';
                                            }
                                            ?>
                                            <a href="<?php echo base_url(); ?>account/detail/commission/buyer/<?php echo $item['id'].$type;?>">
                                                <button type="button" class="btn btn-default1" data-toggle="modal" >
                                                    <i class="fa fa-newspaper-o"></i>
                                                </button>
                                            </a>
                                        <?php }elseif($item['type'] == '02'){
                                            $type = '';
                                            if ($item['description'] == 'Hoa hồng bán sỉ'){
                                                $type = '?personal=1';
                                            }else{
                                                $type = '';
                                            }
                                            ?>
                                            <a href="<?php echo base_url(); ?>account/detail/commission/wholesale/<?php echo $item['id'].$type;?>">
                                                <button type="button" class="btn btn-default1" data-toggle="modal" >
                                                    <i class="fa fa-newspaper-o"></i>
                                                </button>
                                            </a>
                                        <?php }elseif($item['type'] == '01'){
                                            $type = '';
                                            if ($item['description'] == 'Hoa hồng mua sỉ'){
                                                $type = '?personal=1';
                                            }else{
                                                $type = '';
                                            }
                                            ?>
                                            <a href="<?php echo base_url(); ?>account/detail/commission/aggre/<?php echo $item['id'].$type;?>">
                                                <button type="button" class="btn btn-default1" data-toggle="modal" >
                                                    <i class="fa fa-newspaper-o"></i>
                                                </button>
                                            </a>
                                        <?php }else{?>
                                            <a href="<?php echo base_url(); ?>account/detail/commission/<?php echo $item['id'].$type;?>">
                                                <button type="button" class="btn btn-default1" data-toggle="modal" >
                                                    <i class="fa fa-newspaper-o"></i>
                                                </button>
                                            </a>
                                     <?php } ?>
                                    <?php } ?>
                        </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                            <?php }else{ ?>
                                <tr>
                                    <td colspan="7" align="center">
                                        <div class="nojob">Không có dữ liệu!</div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </table>

                    </form>
                    <?php echo $pager; ?>

                </div>
            </div>
        </div>
    </div>
<?php $this->load->view('home/common/footer'); ?>